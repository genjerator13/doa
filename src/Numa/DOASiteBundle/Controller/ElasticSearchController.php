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
        $sidebarParam = $this->createAggregation();
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
        $sidebarParam = $this->createAggregation();

        //$paramsO = $this->getSearchParameters();
        $sidebarForm = $this->container->get('form.factory')->create($sidebarType,null,array(
            'action' => $this->generateUrl('search_dispatch'),
            'method' => 'GET'));
        //$params = $paramsO->getParams();
        $em = $this->getDoctrine()->getManager();

        $subCat = array('' => '');
        $subCat += $sidebarParam['subCat'];
//        dump($subCat);die();
        //$bodyStyle[] = array("body_style"=>"Other");
        //dump($bodyStyle);die();
        //$bodyStyle = $this->makeChoicesForChoiceType($bodyStyle,"body_style","Any Body Style");
        $sidebarForm->add('categorySubType','choice',array('label'=>'Sub Category','choices'=>$subCat,"required"=>false));

        $make = $sidebarParam['make'];
        //dump($make);die();
        //$make = $this->makeMakeChoicesForChoiceType($make,"make","Any Make");
        $sidebarForm->add('make_string','choice',array('label'=>'Make','choices'=>$make,"required"=>false));

        $model = $sidebarParam['model'];
//        dump($model);die();
        //$make = $this->makeMakeChoicesForChoiceType($make,"make","Any Make");
        $sidebarForm->add('model','choice',array('label'=>'Model','choices'=>$model,"required"=>false));

        $yearFrom = $sidebarParam['year'];
        ksort($yearFrom);
//        dump($yearFrom);die();
        //$yearFrom = $this->makeChoicesForChoiceType($yearFrom,"year","Any Year");
        $sidebarForm->add('yearFrom','choice',array('label'=>'Year From','choices'=>$yearFrom,"required"=>false));
//dump($yearFrom);die();

        $yearTo =  $sidebarParam['year'];
        //$yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('yearTo','choice',array('label'=>'Year To','choices'=>$yearTo,"required"=>false));

        $mileageFrom =  $sidebarParam['mileageStats']['min'];
//        dump($mileageFrom);die();
        //$yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('mileageFrom','text',array('label'=>'Mileage From',"required"=>false,"data"=>$mileageFrom));

        $mileageTo =  $sidebarParam['mileageStats']['max'];
//        dump($mileageTo);die();
        //$yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('mileageTo','text',array('label'=>'Mileage To',"required"=>false,"data"=>$mileageTo));

        $priceFrom =  $sidebarParam['priceStats']['min'];
//        dump($priceFrom);
        //$yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('priceFrom','text',array('label'=>'Price From',"required"=>false,"data"=>$priceFrom));

        $priceTo =  $sidebarParam['priceStats']['max'];
//        dump($priceTo);die();
        //$yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('priceTo','text',array('label'=>'Price To',"required"=>false,"data"=>$priceTo));

        $sidebarForm->add('search','submit');

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

        return $sidebarForm;

    }

    private function createAggregation()
    {
        $search = $this->get('fos_elastica.index.app.item');
        //$search = $this->get('fos_elastica.finder.app.item');
        // index



        //$query = new \Elastica\Query\MatchAll();


//        $boolQuery = new \Elastica\Query\BoolQuery();
//
//        $fieldQuery = new \Elastica\Query\Term();
//        $fieldQuery->setTerm('active', 1);
//        $boolQuery->addMust($fieldQuery);
//
//        $fieldQuery = new \Elastica\Query\Term();
//        $fieldQuery->setTerm('dealer_id', 3);///to do
//        $boolQuery->addMust($fieldQuery);
//
        //$elasticaQuery = new \Elastica\Query();
        //$elasticaQuery->setQuery($boolQuery);

        $elasticaQuery = $this->searchParameters->getElasticaQuery();


        //$elasticaQuery->setSize(550);
        //make
        $elasticaAggMake = new \Elastica\Aggregation\Terms('make');
        $elasticaAggMake->setField('make');
        //subCategory
        $elasticaAggModel = new \Elastica\Aggregation\Terms('model');
        $elasticaAggModel->setField('model');
        //categorySubType
        $elasticaAggSubCat= new \Elastica\Aggregation\Terms('categorySubType');
        $elasticaAggSubCat->setField('categorySubType');

        //year
        $elasticaYear= new \Elastica\Aggregation\Terms('year');
        $elasticaYear->setField('year');
        $elasticaYear->setSize(20);
        //price
        $elasticaPrice= new \Elastica\Aggregation\Range('price');
        $elasticaPrice->addRange(0,5000);
        $elasticaPrice->addRange(5000,10000);
        $elasticaPrice->addRange(10000,15000);
        $elasticaPrice->addRange(15000,20000);
        $elasticaPrice->addRange(20000,30000);
        $elasticaPrice->addRange(30000,40000);
        $elasticaPrice->addRange(40000,50000);
        $elasticaPrice->addRange(50000,60000);
        $elasticaPrice->addRange(70000,80000);
        $elasticaPrice->addRange(80000,90000);
        $elasticaPrice->addRange(90000,100000);
        $elasticaPrice->addRange(100000,1000000);
        $elasticaPrice->setField('price');
        //priceStats
        $elasticaPriceStats= new \Elastica\Aggregation\Stats('priceStats');
        $elasticaPriceStats->setField('price');
        //mileageStats
        $elasticaMileageStats= new \Elastica\Aggregation\Stats('mileageStats');
        $elasticaMileageStats->setField('mileage');
        //yearStats
        $elasticaYearStats= new \Elastica\Aggregation\Stats('yearStats');
        $elasticaYearStats->setField('year');

        //$elasticaYear->setOrder('year','desc');


        //$elasticaAggreg->setSize(550);

        //$elasticaAggreg->setOrder('_count', 'desc');

        $elasticaQuery->addAggregation($elasticaAggMake);
        $elasticaQuery->addAggregation($elasticaAggModel);
        $elasticaQuery->addAggregation($elasticaAggSubCat);
        $elasticaQuery->addAggregation($elasticaYear);
        $elasticaQuery->addAggregation($elasticaPrice);
        $elasticaQuery->addAggregation($elasticaPriceStats);
        $elasticaQuery->addAggregation($elasticaMileageStats);
        $elasticaQuery->addAggregation($elasticaYearStats);

        // ResultSet

        $elasticaResultSet = $search->search($elasticaQuery);


        // Get Aggregations
        $elasticaAggregs = $elasticaResultSet->getAggregations();
        $result = array();
//        dump($elasticaAggregs);
        foreach($elasticaAggregs['categorySubType']['buckets'] as $sc){
            $result['subCat'][$sc['key']]=$sc['key']." (".$sc['doc_count'].")";

        }

        foreach($elasticaAggregs['make']['buckets'] as $sc){
            $result['make'][$sc['key']]=$sc['key']." (".$sc['doc_count'].")";

        }

        foreach($elasticaAggregs['model']['buckets'] as $sc){
            $result['model'][$sc['key']]=$sc['key']." (".$sc['doc_count'].")";
        }

        foreach($elasticaAggregs['year']['buckets'] as $sc){
            $result['year'][$sc['key']]=$sc['key']." (".$sc['doc_count'].")";
        }

            $result['mileageStats']['min']=intval($elasticaAggregs['mileageStats']['min']);
            $result['mileageStats']['max']=intval($elasticaAggregs['mileageStats']['max']);
            $result['priceStats']['min']=intval($elasticaAggregs['priceStats']['min']);
            $result['priceStats']['max']=intval($elasticaAggregs['priceStats']['max']);
//        dump($result);die();

//        dump($elasticaAggregs);die();

        //dump($result);die();
        //$result['subCat']
        //$elasticaResultSet->

        return $result;
    }



}
