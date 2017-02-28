<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\QBBundle\Util;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Sale;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\SimpleXMLElement;

class Service
{
    protected $container;
    protected $CompanyInfoService;
    protected $quickbooksCompanyInfo;
    protected $Context;
    protected $quickbooksOauthUrl;
    protected $quickbooksSuccessUrl;
    protected $quickbooksMenuUrl;
    protected $IntuitAnywhere;
    protected $tenant;
    protected $username;
    protected $isConnected;


    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function init()
    {
        $token = '1c83db3db8f0fb44bfba721b5589dd1ed557';
        $oauth_consumer_key = 'qyprd5kDh2hG89BYGV3zawcxjF3srW';
        $oauth_consumer_secret = 'ysIIAnLN7z6XFi3mExYiVbOoPJnLB4UFoiWOPVIF';


        $sandbox = true;     // When you're using development tokens
        //$sandbox = false;    // When you're using production tokens

        // This is the URL of your OAuth auth handler page
        $this->quickbooksOauthUrl = 'http://doa.local/dms/quickbooks/oauth';

// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
        $this->quickbooksSuccessUrl = 'http://doa.local/dms/quickbooks/success';

// This is the menu URL script
        $this->quickbooksMenuUrl = 'http://doa.local/dms/quickbooks/menu';

// This is a database connection string that will be used to store the OAuth credentials
// $dsn = 'pgsql://username:password@hostname/database';
// $dsn = 'mysql://username:password@hostname/database';
        $dsn = 'mysqli://root:root@localhost/qb';

// You should set this to an encryption key specific to your app
        $encryption_key = 'bcde1234';

// Do not change this unless you really know what you're doing!!!  99% of apps will not require a change to this.
        $this->username = 'DO_NOT_CHANGE_ME';

// The tenant that user is accessing within your own app
        $this->tenant = 12345;

// Initialize the database tables for storing OAuth information
        if (!\QuickBooks_Utilities::initialized($dsn)) {
            // Initialize creates the neccessary database schema for queueing up requests and logging
            \QuickBooks_Utilities::initialize($dsn);
        }

// Instantiate our Intuit Anywhere auth handler
//
// The parameters passed to the constructor are:
//	$dsn
//	$oauth_consumer_key		Intuit will give this to you when you create a new Intuit Anywhere application at AppCenter.Intuit.com
//	$oauth_consumer_secret	Intuit will give this to you too
//	$this_url				This is the full URL (e.g. http://path/to/this/file.php) of THIS SCRIPT
//	$that_url				After the user authenticates, they will be forwarded to this URL
//
        $this->IntuitAnywhere = new \QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $this->quickbooksOauthUrl, $this->quickbooksSuccessUrl);

// Are they connected to QuickBooks right now?
        if ($this->IntuitAnywhere->check($this->username, $this->tenant) and
            $this->IntuitAnywhere->test($this->username, $this->tenant)
        ) {
            // Yes, they are
            $this->isConnected = true;

            // Set up the IPP instance
            $IPP = new \QuickBooks_IPP($dsn);

            // Get our OAuth credentials from the database
            $creds = $this->IntuitAnywhere->load($this->username, $this->tenant);

            // Tell the framework to load some data from the OAuth store
            $IPP->authMode(
                \QuickBooks_IPP::AUTHMODE_OAUTH,
                $this->username,
                $creds);

            if ($sandbox) {
                // Turn on sandbox mode/URLs
                $IPP->sandbox(true);
            }

            // Print the credentials we're using
            //print_r($creds);

            // This is our current realm
            $this->realm = $creds['qb_realm'];

            // Load the OAuth information from the database
            $this->Context = $IPP->context();

            // Get some company info
            $this->CompanyInfoService = new \QuickBooks_IPP_Service_CompanyInfo();
            $this->quickbooksCompanyInfo = $this->CompanyInfoService->get($this->Context, $this->realm);
        } else {
            // No, they are not
            $this->isConnected = false;
        }
//        $return =  array(
//            'quickbooks_is_connected'=>$quickbooks_is_connected,
//            'quickbooks_oauth_url'=>$quickbooks_oauth_url,
//            'quickbooks_success_url'=>$quickbooks_success_url,
//            'quickbooks_menu_url'=>$quickbooks_menu_url,
//            //'CompanyInfoService'=>$quickbooks_CompanyInfo,
//            //'realm'=>$realm,
//            'IntuitAnywhere'=>$IntuitAnywhere,
//            'the_tenant'=>$the_tenant,
//            'the_username'=>$the_username,
//            );
//        if(!empty($quickbooks_CompanyInfo)){
//            $return['CompanyInfoService'] = $quickbooks_CompanyInfo;
//            $return['realm'] = $realm;
//            $return['Context'] = $Context;
//        }
        return $this;
    }

    public function isConnected(){
        return $this->isConnected;
    }

    public function getCompanyInfoService(){
        return $this->quickbooksCompanyInfo;
    }

    public function getIntuitAnywhere(){
        return $this->IntuitAnywhere;
    }

    public function getRealm(){
        return $this->realm;
    }

    public function getContext(){
        return $this->getContext();
    }

    public function getTenant(){
        return $this->tenant;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getQuickbooksOauthUrl(){
        return $this->quickbooksOauthUrl;
    }

    public function getQuickbooksMenuUrl(){
        return $this->quickbooksMenuUrl;
    }

    public function getQuickbooksSuccessUrl(){
        return $this->quickbooksSuccessUrl;
    }


}