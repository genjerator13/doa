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
//        $analyticsService = $this->get('google_analytics_api.api');
//        $analytics = $analyticsService->getAnalytics();
//
//        $viewId = '140601798'; // set your view id
//
//// get some metrics (last 30 days, date format is yyyy-mm-dd)
//        $sessions = $analyticsService->getSessionsDateRange($viewId,'30daysAgo','today');
//        dump($analytics);
//
//// get some metrics (last 30 days, date format is yyyy-mm-dd)
//        $sessions = $analyticsService->getSessionsDateRange($viewId,'30daysAgo','today');
        $analytics = $this->initializeAnalytics();
        $response = $this->getReport($analytics);
        //printResults($response);

        $this->printResults($response);


        $analyticsService = $this->get('google_analytics_api.api');
        $analytics = $analyticsService->getAnalytics();
        //dump($analytics);
        $viewId = '140601798';
// get some metrics (last 30 days, date format is yyyy-mm-dd)
        $sessions = $analyticsService->getSessionsDateRange($viewId,'yesterday','today');
        $sessions2 = $analyticsService->getSessionsDateRange($viewId,'2daysAgo','yesterday');
        $bounceRate = $analyticsService->getBounceRateDateRange($viewId,'30daysAgo','today');
        $avgTimeOnPage = $analyticsService->getAvgTimeOnPageDateRange($viewId,'30daysAgo','today');
        $pageViewsPerSession = $analyticsService->getPageviewsPerSessionDateRange($viewId,'30daysAgo','today');
        $percentNewVisits = $analyticsService->getPercentNewVisitsDateRange($viewId,'30daysAgo','today');
        $pageViews = $analyticsService->getPageViewsDateRange($viewId,'30daysAgo','today');
        $avgPageLoadTime = $analyticsService->getAvgPageLoadTimeDateRange($viewId,'30daysAgo','today');

        dump($sessions);
        dump($sessions2);
        dump($avgTimeOnPage);
        dump($pageViewsPerSession);
        dump($percentNewVisits);
        dump($pageViews);
        dump($avgPageLoadTime);
        dump($response);die();

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
