<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;

use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOADMSBundle\Entity\Vendor;

class QuickbooksLib
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
     * Find QB entity by docnumber
     * @param $QBentity
     * @param $docNumber
     * @return bool
     */
    public function findQBByDocNumber($QBentity, $docNumber)
    {
        return $this->findQBEntityByField($QBentity,"DocNumber",$docNumber);
    }

    /**
     * finds QB entity object by fieldname and field value
     * @param $QBentity
     * @param $QBfieldName
     * @param $QBFieldValue
     * @return bool|\QuickBooks_IPP_Object
     */
    public function findQBEntityByField($QBentity,$QBfieldName,$QBFieldValue){
        $qbo = $this->container->get("numa.quickbooks")->init();
        $ItemService = new \QuickBooks_IPP_Service_Term();
        $query = "SELECT * FROM " . $QBentity . " WHERE ".$QBfieldName." = '" . $QBFieldValue . "'";

        $items = $ItemService->query($qbo->getContext(), $qbo->getRealm(), $query);

        if (!empty($items[0])) {
            return $items[0];
        }
        return false;
    }

    /**
     * @param $qbid
     * @return int
     * parse qb id into int  {-12}  => 12
     */
    public function parseId($qbid)
    {
        return intval(str_replace(array("{", "}", "-"), "", $qbid));
    }

    public function insertQBEntityToQB(\QuickBooks_IPP_Object $qbObject)
    {
        $qbObjectClass = get_class($qbObject);
        if(stripos($qbObjectClass,"customer")){
            $entityName = "Customer";
            $entityService = new \QuickBooks_IPP_Service_Customer();
        }elseif(stripos($qbObjectClass,"item")){
            $entityName = "Item";
            $entityService = new \QuickBooks_IPP_Service_Item();
        }elseif(stripos($qbObjectClass,"salesreceipt")){
            $entityName = "SalesReceipt";
            $entityService = new \QuickBooks_IPP_Service_SalesReceipt();
        }elseif(stripos($qbObjectClass,"Bill")){
            $entityName = "Bill";
            $entityService = new \QuickBooks_IPP_Service_Bill();
        }
        $cl = $this->container->get("numa.dms.command.log")->startNewCommand($entityName." add to QB","QB",$this->getDealer());
        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        if (empty($qbObject->getId())) {
            if ($entityService->add($qbo->getContext(), $qbo->getRealm(), $qbObject)) {
                $this->container->get("numa.dms.command.log")->endCommand($cl);
                return $qbObject;
            } else {
                $error = $entityName.' add failed... :' . $entityService->errorMessage();
                $error .= "\n\t". $entityService->lastError();
                dump($error);
                $cl->setFullDetails($error);
                $cl->setStatus("FAILED");
                $this->container->get("numa.dms.command.log")->endCommand($cl);
                return false;
            }
        }
        $cl->setCommand($entityName." update to QB");
        if ($entityService->update($qbo->getContext(), $qbo->getRealm(), $qbObject->getId(), $qbObject)) {

            $this->container->get("numa.dms.command.log")->endCommand($cl);
            return $qbObject;
        } else {
            $error = ' update failed...? ' . $entityService->errorMessage();
            $error .= "\n\t ".$entityService->lastError();
            dump($error);
            $cl->setFullDetails($error);
            $cl->setStatus("FAILED");
            $this->container->get("numa.dms.command.log")->endCommand($cl);
            return false;
        }
    }


}