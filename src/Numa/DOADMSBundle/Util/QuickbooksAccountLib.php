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

    public function listAllAccounts(Catalogrecords $dealer){

        $qbo = $this->container->get("numa.quickbooks")->init($dealer);
        $ItemService = new \QuickBooks_IPP_Service_Term();
        $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), "SELECT * FROM Account");
        $r = array();
        foreach($items as $item){
            $r[$item->getName()] = $item->getName();
        }
        return $r;
    }
}