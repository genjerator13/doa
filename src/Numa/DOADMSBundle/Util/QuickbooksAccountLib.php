<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;

class QuickbooksAccountLib extends QuickbooksLib
{

    public function listAllAccounts(Catalogrecords $dealer, $category = null)
    {

        $qbo = $this->container->get("numa.quickbooks")->init($dealer);
        $ItemService = new \QuickBooks_IPP_Service_Term();
        if (empty($category)) {
            $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Account");
        } else {
            $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "select * from Account where Classification='" . $category . "'");
        }
        $r = array();
        foreach ($items as $item) {
            $r[$item->getName()] = $item->getName();
        }
        return $r;
    }

    public function addAccount($name, $type)
    {
        $qbo = $this->container->get("numa.quickbooks")->init();

        $AccountService = new \QuickBooks_IPP_Service_Account();

        $Account = new \QuickBooks_IPP_Object_Account();

        $Account->setName($name);
        $Account->setDescription($name);
        $Account->setAccountType($type);

        if ($resp = $AccountService->add($qbo->getContext(), $qbo->getRealm(), $Account)) {
            return $Account;
        }

        return false;
    }
    /**
     * Get the value from settings "Inventory" expense account value2 and returns the QB object account
     *
     * @return bool|\QuickBooks_IPP_Object_Account
     */
    public function getExpenseAccount(){
        $qbExpenseAccount = $this->container->get("numa.settings")->getValue2("Inventory");
        return $this->getAccount($qbExpenseAccount);
    }

    /**
     * Get the value from settings "Inventory" income account value3 and returns the QB object account
     *
     * @return bool|\QuickBooks_IPP_Object_Account
     */
    public function getIncomeAccount(){
        $qbIncomeAccount = $this->container->get("numa.settings")->getValue3("Inventory");
        return $this->getAccount($qbIncomeAccount);
    }

    /**
     * Get the value from settings "Inventory" income account value3 and returns the QB object account
     *
     * @return bool|\QuickBooks_IPP_Object_Account
     */
    public function getAssetAccount(){
        $qbIncomeAccount = $this->container->get("numa.settings")->getValue4("Inventory");
        return $this->getAccount($qbIncomeAccount);
    }

    public function getAccount($account)
    {
        if (!empty($account)) {
            $qbo = $this->container->get("numa.quickbooks")->init();
            $ItemService = new \QuickBooks_IPP_Service_Term();
            $accountr = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Account WHERE name = '" . $account . "'");

            if (!empty($accountr[0])) {
                return $accountr[0];
            }
        }
        return false;
    }
}