<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array("field_name"=>'Image List'));
        $arrayImages = array();
        foreach($images as $image){
            if(substr($image->getFieldStringValue(), 0, 7 ) !== "http://"){
                $arrayImages[] = $image->getFieldStringValue();
            }
        }


        $dir    = 'upload/itemsimages'; // path from top
        $scanedFiles = scandir($dir);
        $files = array_diff($scanedFiles, array('.', '..'));

        foreach($files as $file){
            // "is_dir" only works from top directory, so append the $dir before the file
            if (is_dir($dir.'/'.$file)){
                $scanedFilesFolder = scandir($dir.'/'.$file);
                $filesFolder = array_diff($scanedFilesFolder, array('.', '..'));
                foreach ($filesFolder as $fileFolder) {
                    $img = $dir.'/'.$file.'/'.$fileFolder;
                    if(in_array('/'.$img, $arrayImages)){
                        dump($img);
                    }
                    else{
                        dump($img.'DELETE');
                    }
                }

            } else{
                $img = $dir.'/'.$file;
                if(in_array('/'.$img, $arrayImages)){
                    dump($img);
                }
                else{
                    dump($img.'DELETE');
                }
            }
        }
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


}
