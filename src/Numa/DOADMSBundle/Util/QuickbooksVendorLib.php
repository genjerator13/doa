<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Vendor;

class QuickbooksVendorLib
{
    protected $container;
    protected $dealer;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function setDealer(Catalogrecords $dealer)
    {
        $this->dealer = $dealer;
    }

    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * @param $dealer
     * add (update) all dealers vendors to QB
     */
    public function importAllDealerVendorsToQB($dealer)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $vendors = $em->getRepository(Vendor::class)->findByDealerId($dealer->getId());
        $this->importVendorsToQB($vendors);
    }

    /**
     * @param $dealer
     * imports all vendors from QB to DMS
     */
    public function qbToDMSVendors($dealer)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $qbSuppliers = $this->getAllSuppliers();

        foreach ($qbSuppliers as $supplier) {
            $vendor = $this->createVendorFromQB($dealer, $supplier);
        }
        $em->flush();
    }

    /**
     * @param $dealer
     * @param $supplier
     * @return Vendor
     * Creates vendor from QB supplier
     */
    public function createVendorFromQB($dealer, $supplier)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $qbid = $this->container->get("numa.dms.quickbooks")->parseId($supplier->getId());

        $vendor = $em->getRepository(Vendor::class)->findOneBy(array("qb_supplier_id" => $qbid));

        if (!$vendor instanceof Vendor) {
            $vendor = new Vendor();
            $em->persist($vendor);
        }

        $vendor->setQbSupplierId($qbid);
        $vendor->setCatalogrecords($dealer);
        $vendor->setCompanyName($supplier->getCompanyName());
        $vendor->setFirstName($supplier->getGivenName());
        $vendor->setLastName($supplier->getFamilyName());

        if ($supplier->getPrimaryEmailAddr()) {
            $vendor->setEmail($supplier->getPrimaryEmailAddr()->getAddress());
        }

        if ($supplier->getPrimaryPhone()) {
            $vendor->setHomePhone($supplier->getPrimaryPhone()->getFreeFormNumber());
        }

        if ($supplier->getMobile()) {
            $vendor->setMobilePhone($supplier->getMobile()->getFreeFormNumber());
        }

        if ($supplier->getFax()) {
            $vendor->setFax($supplier->getFax()->getFreeFormNumber());
        }

        if ($supplier->getBillAddr()) {
            $vendor->setCity($supplier->getBillAddr()->getCity());
            $vendor->setCountry($supplier->getBillAddr()->getCountry());
            $vendor->setZip($supplier->getBillAddr()->getPostalCode());
            $vendor->setState($supplier->getBillAddr()->getCountrySubDivisionCode());
            $vendor->setAddress($supplier->getBillAddr()->getLine1());
        }

        $vendor->setStatus(null);
        return $vendor;
    }

    /**
     * @param $vendors collection of dms Vendors
     * Adds collection of vendors to QB
     */
    public function importVendorsToQB($vendors)
    {
        if (!empty($vendors)) {
            foreach ($vendors as $vendor) {
                $vendor = $this->dmsToQbVendor($vendor);
            }
        }
    }

    /**
     * For a DMS Vendor entity returns QB vendor object
     * If the DMS vendor name exists just update, else crete new QB vendor record
     * @param Vendor $vendor
     * @return bool|false|\QuickBooks_IPP_Object_Vendor
     */
    public function dmsToQbVendor($vendor)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();
        $VendorService = new \QuickBooks_IPP_Service_Vendor();

//        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbVendor = $this->getSupplier($vendor->getCompanyName());
        if ($qbVendor instanceof \QuickBooks_IPP_Object_Vendor) {
            //update supplier
            $qbVendor = $this->addSupplier($qbVendor, $vendor);
            $resp = $VendorService->update($qbo->getContext(), $qbo->getRealm(), $qbVendor->getId(), $qbVendor);
        } else {
            //insert new supplier
            $qbVendor = new \QuickBooks_IPP_Object_Vendor();
            $qbVendor = $this->addSupplier($qbVendor, $vendor);
            $resp = $VendorService->add($qbo->getContext(), $qbo->getRealm(), $qbVendor);
        }
        if (!$resp) {
//            dump($VendorService->lastError($qbo->getContext()));die();
            return false;
        }
        return $qbVendor;
    }

    /**
     * returns all vendors from QB
     * @return bool
     */
    public function getAllSuppliers()
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $VendorService = new \QuickBooks_IPP_Service_Vendor();

        $qbVendors = $VendorService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Vendor ORDER BY CompanyName ");

        return $qbVendors;
    }

    /**
     * Returns QB vendor object for requested name, if notfound returns false
     * @param $name
     * @return \QuickBooks_IPP_Service_Vendor|false
     */
    public function getSupplier($name)
    {
        return $this->container->get("numa.dms.quickbooks.item")->findQBEntityByField("Vendor", "CompanyName", addslashes($name));
    }

    /**
     * @param \QuickBooks_IPP_Object_Vendor $qbVendor
     * @param Vendor $vendor
     * @return \QuickBooks_IPP_Object_Vendor
     * Maps DMS vendor into QB vendors
     */
    public function addSupplier(\QuickBooks_IPP_Object_Vendor $qbVendor, Vendor $vendor)
    {

        $qbVendor->setCompanyName($vendor->getCompanyName());
        $qbVendor->setDisplayName($vendor->getCompanyName());
        $qbVendor->setGivenName($vendor->getFirstName());
        $qbVendor->setFamilyName($vendor->getLastName());

        $Email = new \QuickBooks_IPP_Object_PrimaryEmailAddr();
        $Email->setAddress($vendor->getEmail());
        $qbVendor->setPrimaryEmailAddr($Email);

        $PrimaryPhone = new \QuickBooks_IPP_Object_PrimaryPhone();
        $PrimaryPhone->setFreeFormNumber($vendor->getHomePhone());
        $qbVendor->setPrimaryPhone($PrimaryPhone);

        $Fax = new \QuickBooks_IPP_Object_Fax();
        $Fax->setFreeFormNumber($vendor->getFax());
        $qbVendor->setFax($Fax);

        $Mobile = new \QuickBooks_IPP_Object_Mobile();
        $Mobile->setFreeFormNumber($vendor->getMobilePhone());
        $qbVendor->setMobile($Mobile);

        $BillAddr = new \QuickBooks_IPP_Object_BillAddr();
        $BillAddr->setLine1($vendor->getAddress());
        $BillAddr->setCity($vendor->getCity());
        $BillAddr->setCountry($vendor->getCountry());
        $BillAddr->setPostalCode($vendor->getZip());
        $BillAddr->setState($vendor->getState());
        $qbVendor->setBillAddr($BillAddr);
        return $qbVendor;
    }
}