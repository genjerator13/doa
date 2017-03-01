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
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\Sale;

class QuickbooksLib
{
    protected $container;


    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function insertItem(Item $item){
        $param = $this->get("numa.quickbooks")->init();

        $itemService = new \QuickBooks_IPP_Service_Item();

        $qbItem = new \QuickBooks_IPP_Object_Item();
        $qbItem->setName();
        $Customer->setTitle('Ms');
        $Customer->setGivenName('Sha333nnon');
        $Customer->setMiddleName('B333');
        $Customer->setFamilyName('Palme343r');
        $Customer->setDisplayName('Shann343on B Palmer ' . mt_rand(0, 1000));

// Terms (e.g. Net 30, etc.)
        $Customer->setSalesTermRef(4);

// Phone #
        $PrimaryPhone = new \QuickBooks_IPP_Object_PrimaryPhone();
        $PrimaryPhone->setFreeFormNumber('860-532-0089');
        $Customer->setPrimaryPhone($PrimaryPhone);

// Mobile #
        $Mobile = new \QuickBooks_IPP_Object_Mobile();
        $Mobile->setFreeFormNumber('860-53432-0033489');
        $Customer->setMobile($Mobile);

// Fax #
        $Fax = new \QuickBooks_IPP_Object_Fax();
        $Fax->setFreeFormNumber('860-53sdf2-0089df');
        $Customer->setFax($Fax);

// Bill address
        $BillAddr = new \QuickBooks_IPP_Object_BillAddr();
        $BillAddr->setLine1('72 E Blue Grass Road');
        $BillAddr->setLine2('Suite D');
        $BillAddr->setCity('Mt Pleasant');
        $BillAddr->setCountrySubDivisionCode('MI');
        $BillAddr->setPostalCode('48858');
        $Customer->setBillAddr($BillAddr);

// Email
        $PrimaryEmailAddr = new \QuickBooks_IPP_Object_PrimaryEmailAddr();
        $PrimaryEmailAddr->setAddress('suppdfgdfgort@consodfgdgfdfgblibyte.com');
        $Customer->setPrimaryEmailAddr($PrimaryEmailAddr);

        if ($resp = $CustomerService->add($param['Context'], $param['realm'], $Customer))
        {
            print('Our new customer ID is: [' . $resp . '] (name "' . $Customer->getDisplayName() . '")');
        }
        else
        {
            print($CustomerService->lastError($param['Context']));
        }
        return $this->render('NumaQBBundle:Default:customers.html.twig', array('customers' => $customers,'c'=>$Customer));
    }

}