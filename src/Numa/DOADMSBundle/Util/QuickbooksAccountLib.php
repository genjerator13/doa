<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;

class QuickbooksAccountLib
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

    public function listAllAccounts(Catalogrecords $dealer,$category=null){

        $qbo = $this->container->get("numa.quickbooks")->init($dealer);
        $ItemService = new \QuickBooks_IPP_Service_Term();
        if(empty($category)) {
            $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Account");
        }else{
            $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "select * from Account where Classification='".$category."'");
        }
        $r = array();
        foreach($items as $item){
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
        //dump($name);
        //dump($type);
        //dump($Account);
        return false;
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