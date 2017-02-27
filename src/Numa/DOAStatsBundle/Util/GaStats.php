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

    public function GaStatsToDB($sessions,$bounceRate,$avgTimeOnPage,$pageViewsPerSession,$percentNewVisits,$pageViews,$avgPageLoadTime,$dealer,$date){

        $em = $this->container->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('NumaDOAStatsBundle:GaStats')->FindByDateAndDealer(new \DateTime($date), $dealer);

        if(!($entity instanceof \Numa\DOAStatsBundle\Entity\GaStats)){
            $entity = new \Numa\DOAStatsBundle\Entity\GaStats();
            $em->persist($entity);
            $entity->setDealer($dealer);
        }
        $entity->setSessions($sessions);
        $entity->setBounceRate($bounceRate);
        $entity->setAvgTimeOnPage($avgTimeOnPage);
        $entity->setPageViewsPerSession($pageViewsPerSession);
        $entity->setPercentNewVisits($percentNewVisits);
        $entity->setPageViews($pageViews);
        $entity->setAvgPageLoadTime($avgPageLoadTime);
        $entity->setDateStats(new \DateTime($date));

        $em->flush();
    }

    public function GaStats($dealer, $date)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $dateStart = date('Y-m-d', strtotime('-1 day', strtotime($date)));

        $analyticsService = $this->container->get('google_analytics_api.api');
        $analytics = $analyticsService->getAnalytics();

        $viewId = $dealer->getSettingGaView();

        $sessions = $analyticsService->getSessionsDateRange($viewId,$dateStart,$date);
        $bounceRate = $analyticsService->getBounceRateDateRange($viewId,$dateStart,$date);
        $avgTimeOnPage = $analyticsService->getAvgTimeOnPageDateRange($viewId,$dateStart,$date);
        $pageViewsPerSession = $analyticsService->getPageviewsPerSessionDateRange($viewId,$dateStart,$date);
        $percentNewVisits = $analyticsService->getPercentNewVisitsDateRange($viewId,$dateStart,$date);
        $pageViews = $analyticsService->getPageViewsDateRange($viewId,$dateStart,$date);
        $avgPageLoadTime = $analyticsService->getAvgPageLoadTimeDateRange($viewId,$dateStart,$date);

        $this->GaStatsToDB($sessions,$bounceRate,$avgTimeOnPage,$pageViewsPerSession,$percentNewVisits,$pageViews,$avgPageLoadTime,$dealer,$date);

    }
}