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

class ElasticSearchController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public $items;
    public $query;
    public $twigParams;

    public function initializeDealer($dealer)
    {

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

        if (!empty($additionalParams)) {
            $parameters = array_merge($parameters, $additionalParams);
        }

        if (!empty($request)) {
            $this->searchParameters->setListingPerPage($request->query->get('listings_per_page'));
            $parametersq = $request->query->all();
            $parameters = array_merge($parameters, $parametersq);
            $parameters = array_merge($parameters, $request->attributes->get('_route_params'));
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


        if ($this->dealer instanceof Catalogrecords) {

            $parameters['dealer_id'] = $this->dealer->getId();
            $parameters['dealerObj'] = $this->dealer;
        }

        //set sort search parameters
        $this->searchParameters->setSort($parameters);

        $this->searchParameters->setAll($parameters);
    }

    public function getSearchParameters()
    {
        return $this->searchParameters;
    }

    public function generateTwigParams($request, $pagerFanta, $ads)
    {

        $page = $request->get('page');
        $page = empty($page) ? 1 : $page;
        $number = intval($request->get('listings_per_page'));
        $number = empty($number) ? 10 : $number;

        $this->queryUrl = $this->searchParameters->makeUrlQuery();
        $this->queryUrlNoSort = $this->searchParameters->makeUrlQuery(false);

        $pagerFanta->setMaxPerPage($number);
        $pagerFanta->setCurrentPage($page);

        $sidebarForm = $this->createSidebarForm();

        $sidebarParam = $this->createAggregation();
        $params = array(
            'sidebarForm' => $sidebarForm->createView(),
            'page' => $page,
            'listing_per_page' => $number,
            'queryUrl' => $this->queryUrl,
            'queryUrlNoSort' => $this->queryUrlNoSort,
            'sort_by' => $this->searchParameters->getSortBy(),
            'sort_order' => $this->searchParameters->getSortOrder(),
            'dealer' => $this->dealer,
            'pagerfanta' => $pagerFanta,
            "dealerObj"=>$this->dealer,
            'ads' => $ads
        );
        $params = array_merge($params, $sidebarParam);
        return $params;
    }


    public function searchAction(Request $request)
    {
        return $this->doSearch($request);
    }

    public function searchAjaxAction(Request $request)
    {
        $html = $this->doSearch($request);

        return $html;
    }

    private function doSearch(Request $request, $params = array())
    {
        //
        $additionParams=array();
        if($this->get("numa.dms.user")->isTruxrusDomain()) {
            $additionParams = array("sort_by" => "price", "sort_order" => "asc");
        }
        $this->initSearchParams($request,$additionParams);

        $this->searchParameters->createElasticSearchResults();

        $pagerFanta = $this->searchParameters->getPagerFanta();
//ADS
        $em = $this->container->get('doctrine.orm.entity_manager');
        $currentUrl = $request->getPathInfo();
        $dealer = $this->container->get("numa.dms.user")->getDealerByHost();

        if ($dealer instanceof Catalogrecords) {
            $webpage = $em->getRepository("NumaDOAModuleBundle:Page")->findPageComponentByUrl($currentUrl, $dealer->getId());

        } else {
            $webpage = $em->getRepository("NumaDOAModuleBundle:Page")->findPageComponentByUrl($currentUrl);
        }



        $ads = array();
        if ($webpage instanceof Page) {

            $ads = $webpage->getActiveAds();

            if (!empty($ads) && !$ads->isEmpty()) {
                $em->getRepository('NumaDOAModuleBundle:Ad')->addView($ads);
            }
        }

        $param = $this->generateTwigParams($request, $pagerFanta, $ads);

        if ($request->isXmlHttpRequest()) {

            return $this->render('NumaDOASiteBundle:Search:searchResults.html.twig', $param);
        }

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function searchByCategoryModelAction(Request $request)
    {

        $this->doSearch($request);
    }

    public function createSidebarForm()
    {
        $sidebarType = new SidebarSearchType();
        $sidebarParam = $this->createAggregation();


        $sidebarForm = $this->container->get('form.factory')->create($sidebarType, null, array(
            'action' => $this->generateUrl('search_dispatch'),
            'attr' => array('id' => 'sidebarSearch'),
            'method' => 'GET'));


        if (!empty($sidebarParam['category'])) {
            $category = array('' => 'Choose Category');
            $category += $sidebarParam['category'];
            $sidebarForm->add('category', 'choice', array('label' => 'Category', 'choices' => $category, "required" => false));
        }
        if (!empty($sidebarParam['subCat'])) {
            $subCat = array('' => 'Choose Subcategory');
            $subCat += $sidebarParam['subCat'];
            $sidebarForm->add('categorySubType', 'choice', array('label' => 'Sub Category', 'choices' => $subCat, "required" => false));
        }

        if (!empty($sidebarParam['year'])) {
            $sidebarForm = $this->addSidebarFormField('yearFrom', 'Year From', $sidebarForm, $sidebarParam['year'], "Choose Year From");
            $sidebarForm = $this->addSidebarFormField('yearTo', 'Year To', $sidebarForm, $sidebarParam['year'], "Choose Year To");
        }

        if (!empty($sidebarParam['model'])) {
            $sidebarForm = $this->addSidebarFormField('model', 'Model', $sidebarForm, $sidebarParam['model'], "Choose Model");
        }
        if (!empty($sidebarParam['make'])) {
            $sidebarForm = $this->addSidebarFormField('make_string', 'Make', $sidebarForm, $sidebarParam['make'], "Choose Make");
        }

        $sidebarForm->add('mileageFrom', 'text', array('label' => 'Mileage From', "required" => false));

        $sidebarForm->add('mileageTo', 'text', array('label' => 'Mileage To', "required" => false));

        $sidebarForm->add('priceFrom', 'text', array('label' => 'Price From', "required" => false));

        $sidebarForm->add('priceTo', 'text', array('label' => 'Price To', "required" => false));

        $sidebarForm->add('search', 'submit');
        $sidebarForm->add('reset', 'reset');

        $params = $this->searchParameters->getParams();

        if (!empty($params['category']) && !empty($params['category']->getValue())) {
            $sidebarForm->get('category')->setData($params['category']->getValue());
        }
        if (!empty($params['categorySubType']) && !empty($params['categorySubType']->getValue())) {
            $sidebarForm->get('categorySubType')->setData($params['categorySubType']->getValue());
        }
        if (!empty($params['yearFrom']) && !empty($params['yearFrom']->getValue())) {
            $sidebarForm->get('yearFrom')->setData($params['yearFrom']->getValue());
        }
        if (!empty($params['yearTo']) && !empty($params['yearTo']->getValue())) {
            $sidebarForm->get('yearTo')->setData($params['yearTo']->getValue());
        }

        if (!empty($params['make_string']) && !empty($params['make_string']->getValue())) {
            $sidebarForm->get('make_string')->setData($params['make_string']->getValue());
        }
        if (!empty($params['model']) && !empty($params['model']->getValue())) {
            $sidebarForm->get('model')->setData($params['model']->getValue());
        }
        if (!empty($params['mileageFrom']) && !empty($params['mileageFrom']->getValue())) {
            $sidebarForm->get('mileageFrom')->setData($params['mileageFrom']->getValue());
        }
        if (!empty($params['mileageTo']) && !empty($params['mileageTo']->getValue())) {
            $sidebarForm->get('mileageTo')->setData($params['mileageTo']->getValue());
        }
        if (!empty($params['priceFrom']) && !empty($params['priceFrom']->getValue())) {
            $sidebarForm->get('priceFrom')->setData($params['priceFrom']->getValue());
        }
        if (!empty($params['priceTo']) && !empty($params['priceTo']->getValue())) {
            $sidebarForm->get('priceTo')->setData($params['priceTo']->getValue());
        }
        return $sidebarForm;

    }

    private function addSidebarFormField($field, $label, $form, $param, $emptyValue)
    {

        if (!empty($param)) {
            $result = array();
            $resulta = array();
            array_walk($param, function (&$val, $key) use (&$result) {
                $result[$val['value']] = $val['value'] . " ( " . $val['count'] . " ) ";
            });
            if (!empty($emptyValue)) {
                $resulta[""] = $emptyValue;
            }
            $resulta += $result;
            if ($field == "yearFrom") {
                ksort($resulta);
            }
            $form->add($field, 'choice', array('label' => $label, 'choices' => $resulta, "required" => false));
        }

        return $form;
    }

    private function createAggregation()
    {
        $size = 200;
        $search = $this->get('fos_elastica.index.app.item');


        $elasticaQuery = $this->searchParameters->getElasticaQuery();

        //make
        $elasticaAggMake = new \Elastica\Aggregation\Terms('make');
        $elasticaAggMake->setField('make');
        $elasticaAggMake->setSize($size);
        //trim
        $elasticaAggTrim = new \Elastica\Aggregation\Terms('trim');
        $elasticaAggTrim->setField('trim');
        $elasticaAggTrim->setSize($size);
        //bodyStyle
        $elasticaAggBodyStyle = new \Elastica\Aggregation\Terms('bodyStyle');
        $elasticaAggBodyStyle->setField('bodyStyle');
        $elasticaAggBodyStyle->setSize($size);
        //model
        $elasticaAggModel = new \Elastica\Aggregation\Terms('model');
        $elasticaAggModel->setField('model');
        $elasticaAggModel->setSize($size);
        //category
        $elasticaAggCategory = new \Elastica\Aggregation\Terms('category');
        $elasticaAggCategory->setField('categoryName');
        $elasticaAggCategory->setSize($size);
        //categorySubType
        $elasticaAggSubCat = new \Elastica\Aggregation\Terms('categorySubType');
        $elasticaAggSubCat->setField('categorySubType');
        $elasticaAggSubCat->setSize($size);
        //truckVanType
        $elasticatruckVanType = new \Elastica\Aggregation\Terms('truckVanType');
        $elasticatruckVanType->setField('truckVanType');
        $elasticatruckVanType->setSize($size);

        //year
        $elasticaYear = new \Elastica\Aggregation\Terms('year');
        $elasticaYear->setField('year');
        $elasticaYear->setSize(20);
        $elasticaYear->setOrder('_term', "desc");
        //price
        $elasticaPrice = new \Elastica\Aggregation\Range('price');
        $elasticaPrice->addRange(0, 5000);
        $elasticaPrice->addRange(5000, 10000);
        $elasticaPrice->addRange(10000, 15000);
        $elasticaPrice->addRange(15000, 20000);
        $elasticaPrice->addRange(20000, 30000);
        $elasticaPrice->addRange(30000, 40000);
        $elasticaPrice->addRange(40000, 50000);
        $elasticaPrice->addRange(50000, 60000);
        $elasticaPrice->addRange(70000, 80000);
        $elasticaPrice->addRange(80000, 90000);
        $elasticaPrice->addRange(90000, 100000);
        $elasticaPrice->addRange(100000, 1000000);
        $elasticaPrice->setField('price');
        //priceStats
        $elasticaPriceStats = new \Elastica\Aggregation\Stats('priceStats');
        $elasticaPriceStats->setField('price');
        //mileageStats
        $elasticaMileageStats = new \Elastica\Aggregation\Stats('mileageStats');
        $elasticaMileageStats->setField('mileage');
        //yearStats
        $elasticaYearStats = new \Elastica\Aggregation\Stats('yearStats');
        $elasticaYearStats->setField('year');
        //$elasticaYearStats->set

        //$elasticaYear->setOrder('year','desc');


        //$elasticaAggreg->setSize(550);

        //$elasticaAggreg->setOrder('_count', 'desc');

        $elasticaQuery->addAggregation($elasticaAggMake);
        $elasticaQuery->addAggregation($elasticaAggTrim);
        $elasticaQuery->addAggregation($elasticaAggBodyStyle);
        $elasticaQuery->addAggregation($elasticaAggModel);
        $elasticaQuery->addAggregation($elasticaAggSubCat);
        $elasticaQuery->addAggregation($elasticaAggCategory);
        $elasticaQuery->addAggregation($elasticaYear);
        $elasticaQuery->addAggregation($elasticaPrice);
        $elasticaQuery->addAggregation($elasticaPriceStats);
        $elasticaQuery->addAggregation($elasticaMileageStats);
        $elasticaQuery->addAggregation($elasticaYearStats);
        $elasticaQuery->addAggregation($elasticatruckVanType);

        // ResultSet

        $elasticaResultSet = $search->search($elasticaQuery);


        // Get Aggregations
        $elasticaAggregs = $elasticaResultSet->getAggregations();
        $result = array();

        foreach ($elasticaAggregs['categorySubType']['buckets'] as $sc) {
            $result['subCat'][$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
        }

        foreach ($elasticaAggregs['make']['buckets'] as $sc) {

            $temp = array();
            //$temp[$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
            $temp['value'] = $sc['key'];
            $temp['count'] = $sc['doc_count'];
            $result['make'][] = $temp;
        }

        foreach ($elasticaAggregs['trim']['buckets'] as $sc) {
            $result['trim'][$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
        }
        foreach ($elasticaAggregs['bodyStyle']['buckets'] as $sc) {
            $temp = array();
            //$temp[$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
            $temp['value'] = $sc['key'];
            $temp['count'] = $sc['doc_count'];
            $result['bodyStyle'][] = $temp;
        }

        foreach ($elasticaAggregs['truckVanType']['buckets'] as $sc) {
            $temp = array();
            //$temp[$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
            $temp['value'] = $sc['key'];
            $temp['count'] = $sc['doc_count'];
            $result['truckVanType'][] = $temp;
        }

        foreach ($elasticaAggregs['model']['buckets'] as $sc) {
            //$result['model'][$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
            $temp = array();
            //$temp[$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
            $temp['value'] = $sc['key'];
            $temp['count'] = $sc['doc_count'];
            $result['model'][] = $temp;
        }

        foreach ($elasticaAggregs['year']['buckets'] as $sc) {
            $temp['value'] = $sc['key'];
            $temp['count'] = $sc['doc_count'];
            $result['year'][] = $temp;
        }

        foreach ($elasticaAggregs['category']['buckets'] as $sc) {
            $result['category'][$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
        }
        foreach ($elasticaAggregs['price']['buckets'] as $sc) {
            $temp = array();
            $temp['from'] = $sc['from'];
            $temp['to'] = $sc['to'];
            $temp['count'] = $sc['doc_count'];
            $result['price'][] = $temp;
        }
        foreach ($elasticaAggregs['category']['buckets'] as $sc) {

            $result['category'][$sc['key']] = $sc['key'] . " (" . $sc['doc_count'] . ")";
        }


        $result['mileageStats']['min'] = intval($elasticaAggregs['mileageStats']['min']);
        $result['mileageStats']['max'] = intval($elasticaAggregs['mileageStats']['max']);
        $result['priceStats']['min'] = intval($elasticaAggregs['priceStats']['min']);
        $result['priceStats']['max'] = intval($elasticaAggregs['priceStats']['max']);

        return $result;
    }
}
