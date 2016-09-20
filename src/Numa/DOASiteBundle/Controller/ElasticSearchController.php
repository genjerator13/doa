<?php

namespace Numa\DOASiteBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOASiteBundle\Form\SidebarSearchType;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityRepository;
use Numa\Util\searchParameters;
use Symfony\Component\Stopwatch\Stopwatch;

class ElasticSearchController extends Controller implements DealerSiteControllerInterface{

    public $dealer;

    public $items;
    public $query;
    public $twigParams;
    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }



    protected $searchParameters;
    protected $queryUrl;

    /**
     * Collects all parameters and turn them into searchParameters
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function initSearchParams(Request $request = null, $additionalParams = array())
    {
        if (empty($this->searchParameters) || empty($this->searchParameters->init)) {
            $this->searchParameters = new \Numa\Util\searchParameters($this->container);
        }
        $parameters = array();

        if (!empty($request)) {
            $this->searchParameters->setListingPerPage($request->query->get('listings_per_page'));
            $parameters = $request->query->all();

            $parameters = array_merge($parameters, $request->attributes->get('_route_params'));

        }

        if (!empty($additionalParams)) {
            $parameters = array_merge($parameters, $additionalParams);
        }
        //set the search source, where from the search came from URL
        if (!empty($parameters['searchSource'])) {
            $aSearchSource = explode('&', $parameters['searchSource']);
            foreach ($aSearchSource as $key => $param) {
                $paramValue = explode("=", $param);
                $parameters[$paramValue[0]] = $paramValue[1];
            }
            unset($parameters['searchSource']);
            $this->searchParameters->setAll($parameters);
            return $this->redirect($this->generateUrl('search_dispatch', $parameters));
        }
        //dump($parameters);die();

        if($this->dealer instanceof Catalogrecords){
            $parameters['dealer_id'] = $this->dealer->getId();
            $parameters['dealer'] = $this->dealer;
        }
        //set sort search parameters
        $this->searchParameters->setSort($parameters);
        //$sortParams =  $parameters['search_field'];

        $this->searchParameters->setAll($parameters);
    }

    public function getSearchParameters()
    {
        return $this->searchParameters;
    }



}
