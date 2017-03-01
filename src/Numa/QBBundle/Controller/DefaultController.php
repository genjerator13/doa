<?php

namespace Numa\QBBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $qbo = $this->get("numa.quickbooks")->init();

        return $this->render('NumaQBBundle:Default:index.html.twig', array('param' => $qbo));
    }

    public function menuAction()
    {
        $param = $this->get("numa.quickbooks")->init();
        $IntuitAnywhere = $param['IntuitAnywhere'];
        $the_username = $param['the_username'];
        $the_tenant = $param['the_tenant'];
        die($IntuitAnywhere->widgetMenu($the_username, $the_tenant));
    }

    public function disconnectAction()
    {
        $param = $this->get("numa.quickbooks")->init();
        $IntuitAnywhere = $param['IntuitAnywhere'];
        $the_username = $param['the_username'];
        $the_tenant = $param['the_tenant'];
        if ($IntuitAnywhere->disconnect($the_username, $the_tenant)) {

        }
        return $this->render('NumaQBBundle:Default:disconnect.html.twig', array('param' => $param));
    }

    public function oauthAction()
    {
        $param = $this->get("numa.quickbooks")->init();
        $IntuitAnywhere = $param['IntuitAnywhere'];
        $the_username = $param['the_username'];
        $the_tenant = $param['the_tenant'];

        if ($IntuitAnywhere->handle($the_username, $the_tenant)) {
            ; // The user has been connected, and will be redirected to $that_url automatically.
        } else {
            // If this happens, something went wrong with the OAuth handshake
            die('Oh no, something bad happened: ' . $IntuitAnywhere->errorNumber() . ': ' . $IntuitAnywhere->errorMessage());
        }
    }

    public function successAction()
    {
        return $this->render('NumaQBBundle:Default:success.html.twig');
    }

    public function customersAction()
    {

        $param = $this->get("numa.quickbooks")->init();

        $CustomerService = new \QuickBooks_IPP_Service_Customer();

        $customers = $CustomerService->query($param['Context'], $param['realm'], "SELECT * FROM Customer");
        $CustomerService = new \QuickBooks_IPP_Service_Customer();

        $Customer = new \QuickBooks_IPP_Object_Customer();
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
