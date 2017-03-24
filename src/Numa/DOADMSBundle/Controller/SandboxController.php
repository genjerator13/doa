<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->find(31806);
        $this->get("numa.dms.sale")->getAllVendors($item);
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

   
}
