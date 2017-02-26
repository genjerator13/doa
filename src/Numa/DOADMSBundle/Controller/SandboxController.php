<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {
        // Your application token (Intuit will give you this when you register an Intuit Anywhere app)
        $token = '1c83db3db8f0fb44bfba721b5589dd1ed557';
// Your OAuth consumer key and secret (Intuit will give you both of these when you register an Intuit app)
//
// IMPORTANT:
//	To pass your tech review with Intuit, you'll have to AES encrypt these and
//	store them somewhere safe.
//
// The OAuth request/access tokens will be encrypted and stored for you by the
//	PHP DevKit IntuitAnywhere classes automatically.
        $oauth_consumer_key = 'qyprd5kDh2hG89BYGV3zawcxjF3srW';
        $oauth_consumer_secret = 'ysIIAnLN7z6XFi3mExYiVbOoPJnLB4UFoiWOPVIF';
// If you're using DEVELOPMENT TOKENS, you MUST USE SANDBOX MODE!!!  If you're in PRODUCTION, then DO NOT use sandbox.
        $sandbox = true;     // When you're using development tokens
//$sandbox = false;    // When you're using production tokens
// This is the URL of your OAuth auth handler page
        $quickbooks_oauth_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/partner_platform/example_app_ipp_v3/oauth.php';
// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
        $quickbooks_success_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/partner_platform/example_app_ipp_v3/success.php';
// This is the menu URL script
        $quickbooks_menu_url = 'http://quickbooks.v3.com:8888/quickbooks-php/docs/partner_platform/example_app_ipp_v3/menu.php';
// This is a database connection string that will be used to store the OAuth credentials
// $dsn = 'pgsql://username:password@hostname/database';
// $dsn = 'mysql://username:password@hostname/database';
        $dsn = 'mysqli://root:root@localhost/midcity';
// You should set this to an encryption key specific to your app
        $encryption_key = 'bcde1234';
// Do not change this unless you really know what you're doing!!!  99% of apps will not require a change to this.
        $the_username = 'DO_NOT_CHANGE_ME';
// The tenant that user is accessing within your own app
        $the_tenant = 12345;
// Initialize the database tables for storing OAuth information
        if (!\QuickBooks_Utilities::initialized($dsn))
        {

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
        $IntuitAnywhere = new \QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, "http://doa.local/dms/sandbox/", "doa.local/dms/qb/oauth");
// Are they connected to QuickBooks right now?
        dump($IntuitAnywhere->check($the_username, $the_tenant));
        //if ($IntuitAnywhere->check($the_username, $the_tenant) and
        //    $IntuitAnywhere->test($the_username, $the_tenant))
        //{
            // Yes, they are
            $quickbooks_is_connected = true;
            // Set up the IPP instance
            $IPP = new \QuickBooks_IPP();
        //$IPP->set
        dump($IPP);
            // Get our OAuth credentials from the database
            $creds = $IntuitAnywhere->load($the_username, $the_tenant);
            // Tell the framework to load some data from the OAuth store
            $IPP->authMode(
                \QuickBooks_IPP::AUTHMODE_OAUTH,
                $the_username,
                $creds);
            if ($sandbox)
            {
                // Turn on sandbox mode/URLs
                $IPP->sandbox(true);
            }
            // Print the credentials we're using
            //print_r($creds);
            // This is our current realm
            $realm = $creds['qb_realm'];
            // Load the OAuth information from the database
            $Context = $IPP->context();
            // Get some company info
            $CompanyInfoService = new \QuickBooks_IPP_Service_CompanyInfo();
            $quickbooks_CompanyInfo = $CompanyInfoService->get($Context, $realm);
            dump($quickbooks_CompanyInfo);
        //}
        //else
       // {
            // No, they are not
       //     $quickbooks_is_connected = false;
       //     dump("aaaa");
        //}

        die();
    }
    function initializeAnalytics()
    {
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = "/home/genjerator/Downloads/My Project-5c94ecfcd7a7.json";

        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);

        $analytics = new \Google_Service_AnalyticsReporting($client);

        return $analytics;
    }
    function getReport($analytics) {

        // Replace with your view ID, for example XXXX.
        $VIEW_ID = "140601798";

        // Create the DateRange object.
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate("7daysAgo");
        $dateRange->setEndDate("today");

        // Create the Metrics object.
        $sessions = new \Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");

        // Create the ReportRequest object.
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions));

        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $analytics->reports->batchGet( $body );
    }

    function printResults($reports) {
        for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();

            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                $row = $rows[ $rowIndex ];
                $dimensions = $row->getDimensions();
                $metrics = $row->getMetrics();
                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                    print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                }

                for ($j = 0; $j < count( $metricHeaders ) && $j < count( $metrics ); $j++) {
                    $entry = $metricHeaders[$j];
                    $values = $metrics[$j];
                    print("Metric type: " . $entry->getType() . "\n" );
                    for ( $valueIndex = 0; $valueIndex < count( $values->getValues() ); $valueIndex++ ) {
                        $value = $values->getValues()[ $valueIndex ];
                        print($entry->getName() . ": " . $value . "\n");
                    }
                }
            }
        }
    }


    public function oauthAction(Request $request)
    {
        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
            // Retrieve the temporary credentials we saved before
            $temporaryCredentials = unserialize($this->get("session")->get("temporary_credentials"));

            // We will now retrieve token credentials from the server
            $server = unserialize($this->get("session")->get('server'));


            $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);
            dump($tokenCredentials);
            $this->get("session")->set('token_credential',serialize($tokenCredentials));
            die();
            dump($_GET['oauth_token']);
            dump($_GET['oauth_verifier']);


        }
die();
    }

    public function testAction(){
        $tokenCredentials = unserialize($this->get("session")->get('token_credential'));
        $server = unserialize($this->get("session")->get('server'));

        //$user = $server->getUserDetails($tokenCredentials);
        //dump($user);
        $url = "https://sandbox-quickbooks.api.intuit.com/v3/company/123145730610364/query?query=select%20%2A%20from%20customer";
        //$url = "https://sandbox-quickbooks.api.intuit.com/v3/company/193514471433949/customer/1";


        $headers = $server->getHeaders($tokenCredentials, 'GET', $url);
        $headers['Accept'] = 'application/json';
        //$buzz = $this->get("buzz")->get($url,$headers);
        $buzz = $this->get("buzz")->get($url,$headers);
        //dump($buzz->getContent());
        dump($tokenCredentials);
        dump($buzz);
        die();
        return new JsonResponse(json_decode($buzz->getContent()));
        die();
        $response = $client->get($url, [
            'headers' => $headers,
        ]);
        $content = $response->getBody()->getContents();
        $json = json_decode((string) $response->getBody(), true);
        $xml =  simplexml_load_string((string) $response->getBody());
        $xml2 =  ((string) $response->getBody());
dump($xml2);
        die();
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $xml);

        $fileContents = trim(str_replace('"', "'", $fileContents));

        $simpleXml = simplexml_load_string($fileContents);
        //dump($simpleXml);
        $json = json_encode($xml);
        //dump($json);
        //dump($xml);
        //$obj = json_decode($content);
        //dump($obj);
        //dump($content);
        return new JsonResponse($json);

    }

}
