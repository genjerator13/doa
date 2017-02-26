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
    const sandboxUrl = "https://sandbox-quickbooks.api.intuit.com/v3/company/";

    public $customerMap = array(
        'firstName' => 'GivenName',
        'lastName' => 'FamilyName',
        'name' => 'CompanyName',
    );

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function callQueryApi($dealer,$query, $format = "array")
    {

        $urlSuffix = "query?query=" . urlencode($query);
        return $this->callApi($dealer, $urlSuffix, $format);
    }

    public function callApi($dealer, $urlSuffix, $format = "array")
    {
        if($dealer instanceof Catalogrecords){}
        $tokenCredentials = unserialize($dealer->getQbTokenCredential());
        $server = $this->getServer($dealer);

        $url = self::sandboxUrl . $dealer->getQbRealmId() . "/" . $urlSuffix;

        $headers = $server->getHeaders($tokenCredentials, 'GET', $url);
        $headers['Accept'] = 'application/json';

        $buzz = $this->container->get("buzz")->get($url, $headers);
        $return = "";
        if ($format == 'array') {
            $return = json_decode($buzz->getContent(), true);
        } elseif ($format == 'json') {
            $return = $buzz->getContent();
        } else {
            throw new \Exception("Wrong format Exception");
        }
        return $return;
    }

    public function insertCustomerFromQB($customer)
    {

        if (!empty($customer)) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            $customerDMS = $em->getRepository(Customer::class)->findOneBy(array('qb_id' => $customer['Id']));

            if (!$customerDMS instanceof Customer) {
                $customerDMS = new Customer();
                $em->persist($customerDMS);
            }

            $dealer = $this->container->get("numa.dms.user")->getSignedDealer();
            if($dealer instanceof Catalogrecords){
                $customerDMS->setDealer($dealer);
            }
            if (!empty($customer['GivenName'])) {
                $customerDMS->setFirstName($customer['GivenName']);
            }
            if (!empty($customer['FamilyName'])) {
                $customerDMS->setLastName($customer['FamilyName']);
            }
            if (!empty($customer['CompanyName'])) {
                $customerDMS->setName($customer['CompanyName']);
            }
            $customerDMS->setQbId($customer['Id']);

            $em->flush();
        }
    }

    public function getServer(Catalogrecords $dealer){
        $server = unserialize($dealer->getQbServer());
        if(empty($server)) {
            $server = new \Wheniwork\OAuth1\Client\Server\Intuit(array(
                'identifier' => $this->container->getParameter("qb_identifier"),
                'secret' => $this->container->getParameter("qb_secret"),
                'callback_uri' => $this->container->get('router')->generate("dms_quickbooks_oauth_redirect", array(), true),
            ));
            $em = $this->container->get('doctrine.orm.entity_manager');
            $dealer->setQbServer(serialize($server));
            $em->flush();
        }
        return $server;
    }

}