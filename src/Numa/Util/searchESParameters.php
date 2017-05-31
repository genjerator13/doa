<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Numa\Util;

use Numa\Util\SearchItem;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Description of searchParameters
 *
 * @author genjerator
 */
class searchESParameters
{

    private $container;
    protected $page = 1;
    protected $sort_by = "";
    protected $sort_order = "asc";
    public $init = false;
    protected $params = array();
    protected $listing_per_page;
    protected $queryBuilder;
    protected $pagerFanta;

    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->initParams();
    }

    public function initParams()
    {
        $this->init = true;
        $this->listing_per_page = 10;
        $this->params = array(
            //universal
            'id' => new SearchItem('id', '', 'int'),
            'text' => new SearchItem('all', '', 'text'),
            'category' => new SearchItem('category', '', 'category'),
            'category_id' => new SearchItem('category_id', 0, 'int'),
            'priceFrom' => new SearchItem('price', 0, 'rangeFrom'),
            'priceTo' => new SearchItem('price', '', 'rangeTo'),
            'year' => new SearchItem('year', 0, 'int'),
            'yearTo' => new SearchItem('year', 0, 'rangeTo'),
            'yearFrom' => new SearchItem('year', 0, 'rangeFrom'),
            'postedFrom' => new SearchItem('date_created', 0, 'dateRangeFrom'),
            'postedTo' => new SearchItem('date_created', 0, 'dateRangeTo'),
            'zip' => new SearchItem('Postal', "", 'string'),
            'stock' => new SearchItem('stock_nr', "", 'string'),
            'status' => new SearchItem('status', "", 'string'),
            'IW_NO' => new SearchItem('IW_NO', "", 'string'),
            'isSold' => new SearchItem('sold', 0, 'int'),
            'exteriorColor' => new SearchItem('exterior_color', 0, 'int'),
            'interiorColor' => new SearchItem('interior_color', 0, 'int'),
            //'withPicture'      => new SearchItem('color', 0, 'int'),
            //marine
            'searchText' => new SearchItem('all', "", "text"),
            'boatType' => new SearchItem('type', 0, "list"),
            'typeString' => new SearchItem('type', 0, "string"),
            'typeSlug' => new SearchItem('type', 0, "listSlug"),
            'categorySubType' => new SearchItem('categorySubType', 0, "string"),
            'categorySubTypeWildcard' => new SearchItem('categorySubType', 0, "wildcard"),
            'ag_applicationString' => new SearchItem('ag_application', 0, "string"),
            'boatTypeString' => new SearchItem('type', 0, "string"),
            'boatTypeSlug' => new SearchItem('type', 0, "listSlug"),
            'boatModel' => new SearchItem('model', "", "string"),
            'boatMake' => new SearchItem('make', 0, "list"),
            'modelRvs' => new SearchItem('model', "", "string"),
            'makeRvs' => new SearchItem('make', 0, "tree"),
            'rvsTypeString' => new SearchItem('type', 0, "string"),
            'rvsTypeSlug' => new SearchItem('type', 0, "listSlug"),
            //cars
            'bodyStyle' => new SearchItem('bodyStyle', "", 'string'),
            'bodyStyleString' => new SearchItem('bodyStyle', "", 'string'),
            'bodyStyleSlug' => new SearchItem('bodyStyle', "", 'listSlug'),
            'make' => new SearchItem('make', "", 'tree'),
            'make_string' => new SearchItem('make', "", 'string'),
            'model' => new SearchItem('model', "", 'string'),
            'transmission' => new SearchItem('transmission', 0, 'list'),
            'engine' => new SearchItem('engine', 0, 'list'),
            'mileageFrom' => new SearchItem('mileage', 0, 'rangeFrom'),
            'mileageTo' => new SearchItem('mileage', 0, 'rangeTo'),
            'fuelType' => new SearchItem('fuel_type', 0, 'int'),
            'dealer_id' => new SearchItem('dealer_id', 0, 'int'),
            'feed_id' => new SearchItem('feed_id', 0, 'int'),
            //
            'VIN' => new SearchItem('VIN', 0, 'string'),
        );
    }

    public function getParams($all = true)
    {
        $res = array();
        if ($all) {
            return $this->params;
        } else {
            foreach ($this->params as $key => $param) {
                if ($this->isParamValueSet($key)) {
                    $res[$key] = $param;
                }
            }
        }
        return $res;
    }

    /**
     * Returns url query based by the search parameters and by sorting fields and order
     * @return string
     */
    public function makeUrlQuery($sort = true)
    {
        $params = $this->getParams(false);
        $aQuery = array();
        foreach ($params as $key => $value) {
            $aQuery[] = $key . "=" . $value->getValue();
        }

        if ($sort) {
            //add sort by field
            if (!empty($this->sort_by)) {

                $aQuery[] = "sort_by=" . $this->sort_by;
            }
            //add sort order
            if (!empty($this->sort_by)) {
                $aQuery[] = "sort_order=" . $this->sort_order;
            }
        }
        $query = implode("&", $aQuery);
        return $query;
    }

    public function get($key)
    {
        if ($this->isParamSet($key)) {
            $value = $this->params[$key];
            return $value;
        }
        return false;
    }

    public function dump()
    {
        foreach ($this->params as $key => $value) {
            if ($value instanceof SearchItem) {
                if (!$value->isValueEmpty())
                    dump($value);
            }
        }
    }

    public function setListingPerPage($lpg = 10)
    {
        $this->listing_per_page = $lpg;
    }

    public function getListingPerPage()
    {
        return $this->listing_per_page;
    }

    public function setAll($params)
    {

        if (!empty($params['category_id']) && $params['category_id'] == 13 && !empty($params['typeString'])) {
            $params['ag_applicationString'] = $params['typeString'];
            unset($params['typeString']);
        }
        if (!empty($params['categorySubType'])) {
            $params['categorySubType'] = strtolower(str_replace("-", " ", $params['categorySubType']));
        }

        foreach ($params as $key => $value) {

            if ($this->isParamSet($key)) {
                if (is_array($value)) {
                    $value = $value[0];
                }
                if (!empty($value)) {
                    $this->params[$key]->setValue(urldecode(trim($value)));
                }
            }
        }

    }

    public function set($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function isParamSet($key)
    {
        if (!empty($this->params[$key]) && $this->params[$key] instanceof SearchItem) {
            return true;
        }
        return false;
    }

    public function isParamValueSet($key)
    {

        if (!empty($this->params[$key]) && $this->params[$key] instanceof SearchItem) {
            $searchItem = $this->params[$key];
            $searchItemValue = $searchItem->getValue();
            if (!empty($searchItemValue)) {
                return true;
            }
        }
        return false;
    }

    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function getSearchText()
    {
        return get('searchText');
    }

    public function getPage()
    {
        return $this->page;
    }

    /**
     * Prepares search text
     * @param type $searchText
     */
    public function setSearchText($searchText)
    {
        $this->searchText = empty($searchText) ? " " : $searchText;
        $this->set('searchText', $this->searchText);
    }

    /**
     * Prepares page number
     * @param type $page
     */
    public function setPage($page)
    {
        $intPage = intval($page);
        $this->page = empty($intPage) ? 1 : $intPage;
    }

    public function setBoatModel($boatModel)
    {
        $this->set('boatModel', $this->set('boatModel', $boatModel));
    }

    public function getBoatModel()
    {
        return get('searchText');;
    }

    public function setYears($yearfrom, $yearto)
    {
        $this->set('yearFrom', $yearfrom);
        $this->set('yearTo', $yearto);
    }

    public function getYearfrom()
    {
        return get('yearFrom');;
    }

    public function getYearto()
    {
        return get('yearTo');;
    }

    public function setPrice($pricefrom, $priceto)
    {
        $this->set('priceFrom', $pricefrom);
        $this->set('priceTo', $priceto);
    }

    public function getPricefrom()
    {
        return get('priceFrom');;
    }

    public function getPriceto()
    {
        return get('priceTo');;
    }

    public function setSort($sort)
    {
        if (!empty($sort['sort_by'])) {
            $this->sort_by = $sort['sort_by'];
        }

        if (!empty($sort['sort_order'])) {
            $this->sort_order = $sort['sort_order'];
            if (strtolower($sort['sort_order']) == 'desc') {
                $this->sort_order = 'desc';
            }
        }
    }

    public function getSortBy()
    {
        return $this->sort_by;
    }

    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * Prepares sorting
     * @param type $dateStart
     * @param type $dateEnd
     */
    public function setOrder($order)
    {
        if (!empty($order)) {
            $this->order = $order;
        }
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function getOrder()
    {
        return $this->order;
    }

    /* elastic search starts here */

    public function createElasticSearchResults()
    {
        //$index = $this->get('fos_elastica.index.app.item');
        //$finder = $this->container->get('fos_elastica.finder.app.item');
        $finder = $this->container->get('fos_elastica.index.app.item');
        $boolQuery = new \Elastica\Query\BoolQuery();


        foreach ($this->params as $key => $searchItem) {
            if ($searchItem instanceof SearchItem) {

                if (!$searchItem->isValueEmpty()) {

                    if ($searchItem->isString()) {

                        if ($searchItem->getDbFieldName() == 'status') {
                            //search by lowercase and upercase until i find better solution
                            $fieldQuery = new \Elastica\Query\Wildcard();
                            $fieldQuery->setValue('status', strtolower($searchItem->getValue()) . '*');
                            $boolQuery->addMust($fieldQuery);

                            $fieldQuery = new \Elastica\Query\Wildcard();
                            $fieldQuery->setValue('status', strtoupper($searchItem->getValue()) . '*');
                            $boolQuery->addShould($fieldQuery);
                        } elseif ($searchItem->getDbFieldName() == 'categorySubType' && $searchItem->getValue() == "class b c motorhome") {


                            $boolFilter = new \Elastica\Filter\BoolFilter();
                            $fieldQuery = new \Elastica\Filter\Term();
                            $fieldQuery->setTerm($searchItem->getDbFieldName(), "class b motorhome");
                            $fieldQuery2 = new \Elastica\Filter\Term();
                            $fieldQuery2->setTerm($searchItem->getDbFieldName(), "class c motorhome");
                            $fieldQueryAll = new \Elastica\Filter\Term();
                            $fieldQueryAll->setTerm($searchItem->getDbFieldName(), "class b c motorhome");
                            $boolFilter->addShould($fieldQuery);
                            $boolFilter->addShould($fieldQuery2);
                            $boolFilter->addShould($fieldQueryAll);
                        }
                        else {
                            $fieldQuery = new \Elastica\Query\Term();
                            $fieldQuery->setTerm($searchItem->getDbFieldName(), $searchItem->getValue());
                            $boolQuery->addMust($fieldQuery);
                        }
                    } elseif ($searchItem->isInt()) {
                        $fieldQuery = new \Elastica\Query\Term();
                        $fieldQuery->setTerm($searchItem->getDbFieldName(), $searchItem->getValue());
                        if ($searchItem->getDbFieldName() == 'dealer_id') {
                            $boolQuery->addMust($fieldQuery);
                        } else {
                            $boolQuery->addMust($fieldQuery);
                        }
                    } elseif ($searchItem->isCategory()) {
                        $fieldQuery = new \Elastica\Query\Term();
                        $fieldQuery->setTerm('categoryName', $searchItem->getValue());
                        $boolQuery->addMust($fieldQuery);
                    } elseif ($searchItem->isText()) {
                        $fieldQuery = new \Elastica\Query\QueryString($searchItem->getValue());

                        $boolQuery->addMust($fieldQuery);
                    } elseif ($searchItem->isRangeFrom()) {
                        $fieldQuery = new \Elastica\Query\Range($searchItem->getDbFieldName(), array('gte' => $searchItem->getValue()));
                        $boolQuery->addMust($fieldQuery);
                    } elseif ($searchItem->isRangeTo()) {
                        $fieldQuery = new \Elastica\Query\Range($searchItem->getDbFieldName(), array('lte' => $searchItem->getValue()));
                        $boolQuery->addMust($fieldQuery);
                    } elseif ($searchItem->isWildcard()) {
                        $fieldQuery = new \Elastica\Query\Wildcard();
                        $fieldQuery->setValue($searchItem->getDbFieldName(), "*" . $searchItem->getValue() . "*");
                        $boolQuery->addMust($fieldQuery);
                    }elseif ($searchItem->isAll()) {
                        $fieldQuery = new \Elastica\Query\QueryString($searchItem->getValue());

                        $boolQuery->addMust($fieldQuery);
                    }
                }
            }
        }

        $fieldQuery = new \Elastica\Query\Term();
        $fieldQuery->setTerm('active', 1);
        $boolQuery->addMust($fieldQuery);
        if (!empty($boolFilter)) {
            $boolQuery->addFilter($boolFilter);
        }


        $elasticaQuery = new \Elastica\Query();
        $elasticaQuery->setQuery($boolQuery);

        if (!empty($this->sort_by)) {

            $elasticaQuery->addSort(array($this->sort_by => $this->sort_order));
        }

        $elasticaQuery->addSort(array("sold" => 'asc'));

        $this->elasticaQuery = $elasticaQuery;

        $search = $finder->createSearch($elasticaQuery);
        $this->pagerFanta = $finder->search();
        $results = $this->pagerFanta->getResults();
        $search->setQuery($elasticaQuery);

        $elasticaQuery->setSize(10000);
        $res = $search->search();
        $adapter = new ArrayAdapter($res->getResults());
        $this->pagerFanta = new Pagerfanta($adapter);
    }

    public function getPagerFanta()
    {
        return $this->pagerFanta;
    }

    public function getElasticaQuery()
    {
        return $this->elasticaQuery;
    }
}
