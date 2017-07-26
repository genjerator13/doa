<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;

class QuickbooksBillLib
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

    public function addLineToBill($qbBill,$account, $amount, $description)
    {
        $Line = new \QuickBooks_IPP_Object_Line();
        $Line->setDetailType('AccountBasedExpenseLineDetail');

        $Line->setAmount($amount);

        //$settingLib = $this->container->get("numa.settings");

        $Line->setDescription($description);
        $AccountBasedExpenseLineDetail = new \QuickBooks_IPP_Object_AccountBasedExpenseLineDetail();

        $accountId = "{-17}";
        if($account instanceof \QuickBooks_IPP_Object_Account){
            $accountId =$account->getId();
        }

        $AccountBasedExpenseLineDetail->setAccountRef($accountId);

        $Line->setAccountBasedExpenseLineDetail($AccountBasedExpenseLineDetail);

        $qbBill->addLine($Line);
        return $qbBill;
    }

    public function insertItemBills(Item $item)
    {
        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        $vendors = $this->container->get("numa.dms.sale")->getAllVendors($item, true);

        $QBBills = array();

        foreach ($vendors as $vendor) {
            $QBBill = $this->createQBBill($item, $vendor);
            $QBBills[] = $QBBill;
        }

        $done = $this->insertQBBills($QBBills);

        return true;
    }

    public function createQBBill($item, $vendorArray)
    {
        $vendor = $vendorArray[0]['vendor'];
        $property = $vendorArray[0]['property'];
        $qbVendor = $vendorArray[0]['qbVendor'];
        $qbItem = $vendorArray[0]['qbItem'];

        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        $docNumber = $this->generateQBBillDocNumber($item, $property);
        $qbBill = $this->findQBBillByDocNumber($docNumber);

        if (!$qbBill instanceof \QuickBooks_IPP_Object_Bill) {
            $qbBill = new \QuickBooks_IPP_Object_Bill();
        }
        $qbBill->setDocNumber($docNumber);
        $qbBill->setVendorRef($qbVendor->getId());
        $qbBill->setItemRef($qbItem->getId());
        $qbBill->setLine(null);
        foreach ($vendorArray as $vendorItem) {
            $this->addLineToBill($qbBill,$vendorItem['qbExpenseAccount'], $vendorItem['amount'], $property);
        }


        return $qbBill;
    }

    /**
     * Finds a QB bill by doc number or if there is no bill with that QB number, creates a new one
     * @param $docNumber
     * @return
     */
    public function findQBBillByDocNumber($docNumber)
    {
        return $this->container->get("numa.dms.quickbooks")->findQBByDocNumber('Bill', $docNumber);
    }

    public function generateQBBillDocNumber(Item $item, $property)
    {

        if (stripos($property, "get") === 0) {
            $property = strip_tags(strtolower(substr($property, 3)));
        };
        return $item->getDealerId() . "_" . $item->getId() . "_" . $property;
    }

    public function insertQBBill(\QuickBooks_IPP_Object_Bill $qbBill){
        $BillService = new \QuickBooks_IPP_Service_Bill();
        $qbo = $this->container->get("numa.quickbooks")->init();
        if(empty($qbBill->getId())) {
            if ($resp = $BillService->add($qbo->getContext(), $qbo->getRealm(), $qbBill)) {
                return $qbBill;
            } else {
                dump('Bill add failed...? ' . $BillService->lastError());
                return false;
            }
        }else{
            if ($resp = $BillService->update($qbo->getContext(), $qbo->getRealm(),$qbBill->getId(), $qbBill)) {
                return $qbBill;
            } else {
                dump('Bill update failed...? ' . $BillService->lastError());
                return false;
            }
        }
        return $qbBill;
    }

    public function insertQBBills($qbBills){
        $done = array();
        foreach ($qbBills as $qbBill) {
            $done[] = $this->insertQBBill($qbBill);
        }
        return $done;
    }
}