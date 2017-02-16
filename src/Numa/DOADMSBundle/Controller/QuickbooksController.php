<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use \Numa\DOADMSBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;

class QuickbooksController extends Controller
{
    /**
     * @param Request $request
     */
    public function launchAction(Request $request)
    {

        $server = new \Wheniwork\OAuth1\Client\Server\Intuit(array(
            'identifier'   => $this->getParameter("qb_identifier"),
            'secret'       => $this->getParameter("qb_secret"),
            'callback_uri' => $this->generateUrl("dms_quickbooks_oauth_redirect",array(),true),
        ));

        // Retrieve temporary credentials
        $temporaryCredentials = $server->getTemporaryCredentials();
        $this->get("session")->set("temporary_credentials",serialize($temporaryCredentials));
        $this->get("session")->set("server",serialize($server));
//        dump($server);
//        dump($temporaryCredentials);
//        die();
        $server->authorize($temporaryCredentials);
        die();
        //$server = new \Wheniwork\OAuth1\Client\Server\Intuit()

    }
    public function indexAction(){
        return $this->render('NumaDOADMSBundle:Quickbooks:index.html.twig');
    }
    public function oauthAction(Request $request)
    {
        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
            // Retrieve the temporary credentials we saved before
            $temporaryCredentials = unserialize($this->get("session")->get("temporary_credentials"));

            // We will now retrieve token credentials from the server
            $server = unserialize($this->get("session")->get('server'));


            $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);

            $this->get("session")->set('token_credential',serialize($tokenCredentials));

            return $this->redirectToRoute("dms_quickbooks_index");
        }
die();
    }

    public function customersAction(){
        $customers = $this->get("numa.dms.quickbooks")->callQueryApi("select * from customer ORDER BY Id DESC");

        $customers = $customers['QueryResponse']['Customer'];
        $ids=array();
        $customers2=array();
        foreach ($customers as $customer){
            $ids[]=$customer['Id'];
            $customers2[$customer['Id']]=$customer;
        }

        $em = $this->getDoctrine()->getManager();
        $customerDMS = $em->getRepository(Customer::class)->findBy(array("qb_id"=>$ids));

        foreach ($customerDMS as $customerDMS){
            $customers2[$customerDMS->getQbId()]['dms_id']=$customerDMS->getId();
        }
        //dump($customers2);die();
        return $this->render('NumaDOADMSBundle:Quickbooks:customers.html.twig', array(
            'customers' => $customers2,
        ));
    }

    public function fetchCustomerFromQBAction(Request $request, $id){
        $customer_id=intval($id);
        $customer = $this->get("numa.dms.quickbooks")->callApi("customer/".$customer_id);
        $this->get("numa.dms.quickbooks")->insertCustomerFromQB($customer['Customer']);
        return $this->redirectToRoute("dms_quickbooks_custmers");
        die();
    }

}
