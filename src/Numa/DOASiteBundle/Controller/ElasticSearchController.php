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
            $this->searchParameters = new \Numa\Util\searchESParameters($this->container);
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

    public function generateTwigParams($request,$pagerFanta)
    {

        $page = $request->get('page');
        $page = empty($page) ? 1 : $page;
        $number = intval($request->get('listings_per_page'));
        $number = empty($number) ? 10 : $number;

        $this->queryUrl = $this->searchParameters->makeUrlQuery();
        $this->queryUrlNoSort = $this->searchParameters->makeUrlQuery(false);

        $pagerFanta->setMaxPerPage($number);
        $pagerFanta->setCurrentPage($page);

        $sidebarType = new SidebarSearchType();

        $sidebarForm = $this->createSidebarForm();
        //$param['sidebarForm'] = $sidebarForm->createView();
        $sidebarParam = $this->setSidebarSearchParams();
        $params = array(
            'sidebarForm' => $sidebarForm->createView(),
            'page'=>$page,
            'listing_per_page' => $number,
            'queryUrl' => $this->queryUrl,
            'queryUrlNoSort' => $this->queryUrlNoSort,
            'sort_by' => $this->searchParameters->getSortBy(),
            'sort_order' => $this->searchParameters->getSortOrder(),
            'dealer' => $this->dealer,
            'pagerfanta'=>$pagerFanta
        );
        $params = array_merge($params, $sidebarParam);
        return $params;
    }


    public function searchAction(Request $request)
    {
        return $this->doSearch($request);
    }

    private function doSearch(Request $request,$params=array()){
        $this->initSearchParams($request);
        $this->searchParameters->createElasticSearchResults();
        //$this->searchParameters->dump();
        $pagerFanta=$this->searchParameters->getPagerFanta();
        $param = $this->generateTwigParams($request, $pagerFanta);

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function searchByCategoryModelAction(Request $request)
    {

        $this->doSearch($request);
    }

    public function createSidebarForm(){
        $sidebarType = new SidebarSearchType();
        $paramsO = $this->getSearchParameters();
        $sidebarForm = $this->container->get('form.factory')->create($sidebarType,null,array(
            'action' => $this->generateUrl('search_dispatch'),
            'method' => 'GET'));
        $params = $paramsO->getParams();
        $em = $this->getDoctrine()->getManager();



        //dump($this->dealer->isRVsDealer());


        $bodyStyle = $em->getRepository('NumaDOAAdminBundle:Item')->getAllSingleColumn("body_style",$this->dealer);
        $bodyStyle[] = array("body_style"=>"Other");
        $bodyStyle = $this->makeChoicesForChoiceType($bodyStyle,"body_style","Any Body Style");
        $sidebarForm->add('bodyStyleString','choice',array('label'=>'Body Style','choices'=>$bodyStyle,));

        $make = $em->getRepository('NumaDOAAdminBundle:Item')->getAllmake($this->dealer);
        //dump($make);die();
        $make = $this->makeMakeChoicesForChoiceType($make,"make","Any Make");
        $sidebarForm->add('make','choice',array('label'=>'Make','choices'=>$make,"required"=>false));

        $yearFrom = $em->getRepository('NumaDOAAdminBundle:Item')->getAllSingleColumn("year",$this->dealer);
        $yearFrom = $this->makeChoicesForChoiceType($yearFrom,"year","Any Year");
        $sidebarForm->add('yearFrom','choice',array('label'=>'Year From','choices'=>$yearFrom,"required"=>false));

        $yearTo = $em->getRepository('NumaDOAAdminBundle:Item')->getAllSingleColumn("year",$this->dealer,"DESC");
        $yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('yearTo','choice',array('label'=>'Year To','choices'=>$yearTo,"required"=>false));

//        $criteriaMinYear = Criteria::create()->orderBy(array('year' => Criteria::ASC));
//        $criteriaMaxYear = Criteria::create()->orderBy(array('year' => Criteria::DESC));
//
//        $minYear = $this->items->matching($criteriaMinYear);
//        $maxYear = $this->items->matching($criteriaMaxYear);
//        dump($minYear);
//        dump($maxYear);die();
        //die();
        if(!empty($params['bodyStyleString']) && !empty($params['bodyStyleString']->getValue())) {
            $sidebarForm->get('bodyStyleString')->setData($params['bodyStyleString']->getValue());
        }
        if(!empty($params['yearFrom']) && !empty($params['yearFrom']->getValue())) {
            $sidebarForm->get('yearFrom')->setData($params['yearFrom']->getValue());
        }
        if(!empty($params['yearTo']) && !empty($params['yearTo']->getValue())) {
            $sidebarForm->get('yearTo')->setData($params['yearTo']->getValue());
        }
        if(!empty($params['make']) && !empty($params['make']->getValue())) {
            $sidebarForm->get('make')->setData($params['make']->getValue());
        }
        if(!empty($params['model']) && !empty($params['model']->getValue())) {
            $sidebarForm->get('model')->setData($params['model']->getValue());
        }
        if(!empty($params['mileageFrom']) && !empty($params['mileageFrom']->getValue())) {
            $sidebarForm->get('mileageFrom')->setData($params['mileageFrom']->getValue());
        }
        if(!empty($params['mileageTo']) && !empty($params['mileageTo']->getValue())) {
            $sidebarForm->get('mileageTo')->setData($params['mileageTo']->getValue());
        }
        if(!empty($params['priceFrom']) && !empty($params['priceFrom']->getValue())) {
            $sidebarForm->get('priceFrom')->setData($params['priceFrom']->getValue());
        }
        if(!empty($params['priceTo']) && !empty($params['priceTo']->getValue())) {
            $sidebarForm->get('priceTo')->setData($params['priceTo']->getValue());
        }
        //dump($params['year']->getValue());die();
        return $sidebarForm;
        //$param['sidebarForm'] = $sidebarForm->createView();
    }

    private function setSidebarSearchParams(){
        $em = $this->getDoctrine()->getManager();

        $lftreec = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree');
        $lflistc = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists');
        $lftreec->setMemcached($this->get('mymemcache'));
        $lflistc->setMemcached($this->get('mymemcache'));

        $jsonCar = $lftreec->getJsonTreeModels(614);

        $jsonRvs = $lftreec->getJsonTreeModels(760);
        $params  = array('jsonCar'=>$jsonCar,'jsonRvs'=>$jsonRvs);
        return $params;
    }

    /**
     * Makes choices for dropdown from search results
     */
    public function makeChoicesForChoiceType($items,$field,$first=""){
        $res=array();
        $res[0]=$first;
        foreach ($items as $item) {
            $res[strtolower($item[$field])]=$item[$field];
        }

        return $res;
    }

    /**
     * Makes choices for dropdown from search results
     */
    public function makeMakeChoicesForChoiceType($items,$field,$first=""){
        $res=array();
        $res[0]=$first;
        foreach ($items as $item) {
            $res[$item['id']]=$item[$field];
        }
        return $res;
    }

}
