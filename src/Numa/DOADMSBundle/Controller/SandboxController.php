<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;
use mikehaertl\pdftk\Pdf;


class SandboxController extends Controller
{
    public function indexAction(Request $request){
//        $session = ssh2_connect('dtf.thefidelisgroup.net', 22);
//        ssh2_auth_password($session, 'dmscomplete', 'D=M$30LLt@!');
//        dump("ssh2.sftp://$session/test.csv");
//        //$stream = fopen("ssh2.sftp://dtf.thefidelisgroup.net/incoming/test.csv", 'r');
//        $stream = fopen("ssh2.sftp://dmscomplete:D=M$30LLt@!@dtf.thefidelisgroup.net:22/incoming/test.csv", 'r');
//        dump($stream);
//        die();

        if ($connection = ssh2_connect('dtf.thefidelisgroup.net', 22)) {
            echo "Connected to SFTP server.";
        } else {
            echo "Can't connect to SFTP server.";
        }
        if (ssh2_auth_password($connection, 'dmscomplete', 'D=M$30LLt@!')) {
            echo "Logged to SFTP server.";
        } else {
            echo "Can't log to SFTP server.";
        }

        $sftp = ssh2_sftp($connection);

        $stream = fopen("ssh2.sftp://$sftp/./incoming/test.csv", 'w');

        fwrite($stream, 'rtrtrtrtrtrtrtrrtr');
        fclose($stream);

        //$files = array_diff(scandir('ssh2.sftp://dtf.thefidelisgroup.net/incoming' ), array('..', '.'));

die();
    }
    public function indexAction3(Request $request){

    }
    public function index2Action(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        //$images = $this->get('numa.dms.images')->getAllImagesIntoArray();
//        $image_path=$this->getParameter("web_path");
//        //$images = $this->get('numa.dms.images')->clearCacheImagesItemId(33533);
//        $dealer = $this->get('numa.dms.images')->clearCacheDealer(56);
//        die();


// Fill form with data array
        $pdf = new \mikehaertl\pdftk\Pdf('/var/www/doa/sample.pdf');
        $pdf->fillForm([
            'VehMake'=>'aaaaaaaaaaaaa',

        ])
            ->needAppearances()
            ->saveAs('/var/www/doa/sampleFFF.pdf');

//// Fill form from FDF
//        $pdf = new Pdf('/var/www/doa/sample.pdf');
//        $pdf->fillForm('data.xfdf')
//            ->saveAs('/var/www/doa/sample.pdf');

// Check for errors
        if (!$pdf->saveAs('/var/www/doa/sample.pdf')) {
            $error = $pdf->getError();
        }
        dump($error);

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


}
