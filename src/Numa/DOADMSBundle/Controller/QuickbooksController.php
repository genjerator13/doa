<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use \Numa\DOADMSBundle\Entity\Customer;
use oasis\names\specification\ubl\schema\xsd\CommonAggregateComponents_2\CatalogueLine;
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
        $dealer = $this->get('numa.dms.user')->getSignedDealer();

        if (!$dealer instanceof Catalogrecords) {
            die("dealer only");
            //throw ("aaaaa");
        }
        $server               = $this->get("numa.dms.quickbooks")->getServer($dealer);

        // Retrieve temporary credentials
        $temporaryCredentials = $server->getTemporaryCredentials();
        $em = $this->getDoctrine()->getManager();
        $dealer->setQbTempToken(serialize($temporaryCredentials));
        $em->flush();
        //$this->get("session")->set("temporary_credentials", serialize($temporaryCredentials));
        //$this->get("session")->set("server", serialize($server));


        $server->authorize($temporaryCredentials);

        die();
        //$server = new \Wheniwork\OAuth1\Client\Server\Intuit()

    }

    public function indexAction()
    {
        return $this->render('NumaDOADMSBundle:Quickbooks:index.html.twig');
    }

    public function oauthAction(Request $request)
    {
        $oauth_token = $request->get('oauth_token');
        $oauth_verifier = $request->get('oauth_verifier');
        $realm_id = $request->get('realmId');
        $dealer = $this->get('numa.dms.user')->getSignedDealer();

        if (!empty($dealer->getQbTokenCredential())) {
            return $this->redirectToRoute("dms_quickbooks_index");
        }

        if (!empty($oauth_token) && !empty($oauth_verifier)) {

            $server = $this->get("numa.dms.quickbooks")->getServer($dealer);

            // Retrieve temporary credentials
            $temporaryCredentials = $dealer->getQbTempToken();

            // We will now retrieve token credentials from the server

            $tokenCredentials = $server->getTokenCredentials(unserialize($temporaryCredentials), $_GET['oauth_token'], $_GET['oauth_verifier']);


            //$this->get("session")->set('token_credential',serialize($tokenCredentials));
            if ($dealer instanceof Catalogrecords && !empty($realm_id)) {
                $em = $this->getDoctrine()->getManager();
                $dealer->setQbRealmId($realm_id);
                $dealer->setQbTokenCredential(serialize($tokenCredentials));
                $em->flush();
            }
            dump($tokenCredentials);
            die();
            return $this->redirectToRoute("dms_quickbooks_index");
        }
    }

    public function customersAction()
    {
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $customers = $this->get("numa.dms.quickbooks")->callQueryApi($dealer, "select * from customer ORDER BY Id DESC");

        $customers = $customers['QueryResponse']['Customer'];
        $ids = array();
        $customers2 = array();
        foreach ($customers as $customer) {
            $ids[] = $customer['Id'];
            $customers2[$customer['Id']] = $customer;
        }

        $em = $this->getDoctrine()->getManager();
        $customerDMS = $em->getRepository(Customer::class)->findBy(array("qb_id" => $ids));

        foreach ($customerDMS as $customerDMS) {
            $customers2[$customerDMS->getQbId()]['dms_id'] = $customerDMS->getId();
        }
        //dump($customers2);die();
        return $this->render('NumaDOADMSBundle:Quickbooks:customers.html.twig', array(
            'customers' => $customers2,
        ));
    }

    public function fetchCustomerFromQBAction(Request $request, $id)
    {
        $customer_id = intval($id);
        $customer = $this->get("numa.dms.quickbooks")->callApi("customer/" . $customer_id);
        $this->get("numa.dms.quickbooks")->insertCustomerFromQB($customer['Customer']);
        return $this->redirectToRoute("dms_quickbooks_custmers");
        die();
    }

}
