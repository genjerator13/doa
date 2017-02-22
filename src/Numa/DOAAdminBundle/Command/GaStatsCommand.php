<?php

namespace Numa\DOAAdminBundle\Command;


use Numa\DOAStatsBundle\Entity\GaStats;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class GaStatsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        //set_error_handler( array( $this, 'myErrorHandler' ) );
        $this
            ->setName('numa:stats')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');

        $em = $this->getContainer()->get('doctrine')->getManager();

        if ($command == 'gastats') {
            $this->GaStats($param1);
        }
//        elseif ($command == 'sold') {
//            $this->setSoldDate();
//        }
    }

    public function GaStatsToDB($sessions,$bounceRate,$avgTimeOnPage,$pageViewsPerSession,$percentNewVisits,$pageViews,$avgPageLoadTime,$param1){

        $em = $this->getContainer()->get('doctrine')->getManager();
        $entity = new GaStats();

        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($param1);

        $entity->setDealer($dealer);

        $entity->setSessions($sessions);
        $entity->setBounceRate($bounceRate);
        $entity->setAvgTimeOnPage($avgTimeOnPage);
        $entity->setPageViewsPerSession($pageViewsPerSession);
        $entity->setPercentNewVisits($percentNewVisits);
        $entity->setPageViews($pageViews);
        $entity->setAvgPageLoadTime($avgPageLoadTime);

        $em->persist($entity);
        $em->flush();

    }
    public function GaStats($param1)
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
        $response = $this->report($analytics);
        //printResults($response);

//        $this->printResults($response);


        $analyticsService = $this->getContainer()->get('google_analytics_api.api');
        $analytics = $analyticsService->getAnalytics();
        //dump($analytics);
        $viewId = '140601798';
// get some metrics (last 30 days, date format is yyyy-mm-dd)
        $sessions = $analyticsService->getSessionsDateRange($viewId,'1daysAgo','today');
        $bounceRate = $analyticsService->getBounceRateDateRange($viewId,'1daysAgo','today');
        $avgTimeOnPage = $analyticsService->getAvgTimeOnPageDateRange($viewId,'1daysAgo','today');
        $pageViewsPerSession = $analyticsService->getPageviewsPerSessionDateRange($viewId,'1daysAgo','today');
        $percentNewVisits = $analyticsService->getPercentNewVisitsDateRange($viewId,'1daysAgo','today');
        $pageViews = $analyticsService->getPageViewsDateRange($viewId,'1daysAgo','today');
        $avgPageLoadTime = $analyticsService->getAvgPageLoadTimeDateRange($viewId,'1daysAgo','today');

        $this->GaStatsToDB($sessions,$bounceRate,$avgTimeOnPage,$pageViewsPerSession,$percentNewVisits,$pageViews,$avgPageLoadTime,$param1);
//        dump($sessions);
//        dump($bounceRate);
//        dump($avgTimeOnPage);
//        dump($pageViewsPerSession);
//        dump($percentNewVisits);
//        dump($pageViews);
//        dump($avgPageLoadTime);
//        dump($response);die();

        die();
    }
    function initializeAnalytics()
    {
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = "/var/www/doa/My Project-5c94ecfcd7a7.json";

        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);

        $analytics = new \Google_Service_AnalyticsReporting($client);

        return $analytics;

    }
    function report($analytics) {

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