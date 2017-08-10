<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;

class QuickbooksTaxLib extends QuickbooksLib
{

    public function listAllTaxes(Catalogrecords $dealer)
    {

        $qbo = $this->container->get("numa.quickbooks")->init($dealer);
        $taxService = new \QuickBooks_IPP_Service_Term();

        $taxes = $taxService->query($qbo->getContext(), $qbo->getRealm(), "select * from taxcode");

        $r = array();
        foreach ($taxes as $item) {
            $r[$item->getName()] = $item->getName();
        }
        return $r;
    }

    /**
     * Get the value from settings "Inventory" sale tax value5 and returns the QB object taxcode
     *
     * @return bool|\QuickBooks_IPP_Object_TaxCode
     */
    public function getSaleTax(){
        $qbSaleTaxSetting = $this->container->get("numa.settings")->getValue5("Inventory");
        return $this->getTax($qbSaleTaxSetting);
    }
    /**
     * Get the value from settings "Inventory" purchase tax value6 and returns the QB object taxcode
     *
     * @return bool|\QuickBooks_IPP_Object_TaxCode
     */
    public function getPurchaseTax(){
        $qbPurchaseTaxSetting = $this->container->get("numa.settings")->getValue6("Inventory");
        return $this->getTax($qbPurchaseTaxSetting);
    }

    /**
     * get QB object taxcode by $taxName parameter
     * @param $taxName
     * @return bool|\QuickBooks_IPP_Object_TaxCode
     */
    public function getTax($taxName)
    {
        if (!empty($taxName)) {
            $qbo = $this->container->get("numa.quickbooks")->init();
            $ItemService = new \QuickBooks_IPP_Service_Term();
            $q = "SELECT * FROM TaxCode WHERE name = '" . $taxName . "'";
            $tax = $ItemService->query($qbo->getContext(), $qbo->getRealm(),$q );
            if (!empty($tax[0])) {
                return $tax[0];
            }
        }
        return false;
    }

}