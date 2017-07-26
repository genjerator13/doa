<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Billing;

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

    public function createQBSale(Billing $billing){

        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);
        $docNumber = $this->generateQBSaleDocNumber($billing);
        $qbSale = $this->findQBSaleByDocNumber($docNumber);

        if (!$qbSale instanceof \QuickBooks_IPP_Object_SalesReceipt) {
            $qbBill = new \QuickBooks_IPP_Object_SalesReceipt();
        }
        $qbSale->setDocNumber($docNumber);

        return $qbBill;
    }

    public function findQBSaleByDocNumber($docNumber)
    {
        return $this->container->get("numa.dms.quickbooks")->findQBByDocNumber('SalesReceipt', $docNumber);
    }

    public function generateQBSaleDocNumber(Billing $billing)
    {
        $itemStr = "_0_";
        if($billing->getItem() instanceof Item){
            $itemStr= "_".$billing->getItem()->getId()."_";
        }
        return $billing->getDealerId() . "_" . $billing->getId().$itemStr;
    }

    public function addLineToSale(\QuickBooks_IPP_Object_SalesReceipt $qbSale,$account,$sku,$description,$qty,$rate,$amount,$saleTax)
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

        $qbSale->addLine($Line);
        return $qbSale;
    }
}