<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;

class QuickbooksSaleLib
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