<?php

namespace Numa\DOAStatsBundle\Util;


class GaStats
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function GaStatsToDB($sessions,$bounceRate,$avgTimeOnPage,$pageViewsPerSession,$percentNewVisits,$pageViews,$avgPageLoadTime,$dealer){

        $em = $this->container->get('doctrine.orm.entity_manager');
        $entity = new \Numa\DOAStatsBundle\Entity\GaStats();

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

    public function GaStats($dealer_id, $date)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealer_id);
        $analyticsService = $this->container->get('google_analytics_api.api');
        $analytics = $analyticsService->getAnalytics();
        $viewId = $dealer->getSettingGaView();
        $sessions = $analyticsService->getSessionsDateRange($viewId,'1daysAgo','today');
        $bounceRate = $analyticsService->getBounceRateDateRange($viewId,'1daysAgo','today');
        $avgTimeOnPage = $analyticsService->getAvgTimeOnPageDateRange($viewId,'1daysAgo','today');
        $pageViewsPerSession = $analyticsService->getPageviewsPerSessionDateRange($viewId,'1daysAgo','today');
        $percentNewVisits = $analyticsService->getPercentNewVisitsDateRange($viewId,'1daysAgo','today');
        $pageViews = $analyticsService->getPageViewsDateRange($viewId,'1daysAgo','today');
        $avgPageLoadTime = $analyticsService->getAvgPageLoadTimeDateRange($viewId,'1daysAgo','today');

        $this->GaStatsToDB($sessions,$bounceRate,$avgTimeOnPage,$pageViewsPerSession,$percentNewVisits,$pageViews,$avgPageLoadTime,$dealer);

        die();
    }
}