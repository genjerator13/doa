<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Numa\Util;

use Numa\Util\SearchItem;

/**
 * Description of searchParameters
 *
 * @author genjerator
 */
class searchParameters
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
            'bodyStyle' => new SearchItem('body_style', "", 'list'),
            'bodyStyleString' => new SearchItem('body_style', "", 'string'),
            'bodyStyleSlug' => new SearchItem('body_style', "", 'listSlug'),
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
                if(!$value->isValueEmpty())
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
        //dump($this->params);die();
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

    public function createSearchQuery()
    {
        //create query
        $em = $this->container->get('doctrine')->getEntityManager();
        $filters = $em->getFilters()
            ->enable('active_filter');
        $filters->setParameter('active', true);
        $qb = $em->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i');

        //->orderBy('u.name', 'ASC');

        foreach ($this->params as $key => $searchItem) {
            if ($this->isParamSet($key)) {

                if ($searchItem instanceof \Numa\Util\SearchItem) {

                    if (!$searchItem->isValueEmpty()) {

                        $type = $searchItem->getType();
                        $dbName = $searchItem->getDbFieldName();
                        $value = $searchItem->getValue();

                        if ($dbName == 'all') {

                            $q = $this->createAllQuery($qb, $searchItem->getValue());

                            //$qb->andWhere($q);
                            //$qb->setParameter('text', "%" . $searchItem->getValue() . "%");
//                        } elseif ($type == 'category') {
//                            $qb->andWhere('i.category_id=:cat');
//                            $qb->setParameter('cat', $searchItem->getValue());
                        } elseif ($type == 'string') {

                            if ($dbName == "body_style" && strtolower($searchItem->getValue()) == "other") {
                                $qb->andWhere('i.' . $dbName . ' is null');
                            } else {
                                $qb->andWhere('i.' . $dbName . ' LIKE :' . $dbName);
                                $qb->setParameter($dbName, "%" . $searchItem->getValue() . "%");
                            }
                        } elseif ($type == 'int') {
                            $qb->andWhere('i.' . $dbName . ' = :' . $dbName);

                            $qb->setParameter($dbName, $searchItem->getValue());
                        } elseif ($type == 'rangeFrom') {
                            $qb->andWhere('i.' . $dbName . ' >= :' . $dbName . "from");
                            $qb->setParameter($dbName . "from", floatval($searchItem->getValue()));
                        } elseif ($type == 'rangeTo') {
                            $qb->andWhere('i.' . $dbName . '<= :' . $dbName . "to");
                            $qb->setParameter($dbName . "to", floatval($searchItem->getValue()));
                        } elseif ($type == 'dateRangeFrom') {
//                            $qb->andWhere('i.date_created >= :dateFrom')
//                            
//                                    ->setParameter('dateFrom', $monday->format('Y-m-d'))
//                                    ->setParameter('sunday', $sunday->format('Y-m-d'));
                        } elseif ($type == 'dateRangeTo') {
//                            $qb->andWhere('i.date_created >=' . $searchItem->getValue());
//                            //$qb->orderBy('ifield.field_integer_value', "ASC");
                        } elseif ($type == 'list') {
                            $lflValue = $this->container->get('doctrine')->getRepository("NumaDOAAdminBundle:ListingFieldLists")->findOneBy(array('id' => $searchItem->getValue()));
                            $qb->andWhere('i.' . $dbName . ' LIKE :' . $dbName);

                            $qb->setParameter($dbName, "%" . $lflValue->getValue() . "%");
                        } elseif ($type == 'listSlug') {
                            $lflValue = $this->container->get('doctrine')->getRepository("NumaDOAAdminBundle:ListingFieldLists")->findOneBy(array('slug' => $searchItem->getValue()));
                            $qb->andWhere('i.' . $dbName . ' LIKE :' . $dbName);
                            $qb->orWhere('i.ag_application' . ' LIKE :' . $dbName);
                            $qb->setParameter($dbName, "%" . $lflValue->getValue() . "%");

                        } elseif ($type == 'tree') {
                            $lflValue = $this->container->get('doctrine')->getRepository("NumaDOAAdminBundle:ListingFieldTree")->findOneBy(array('id' => $searchItem->getValue()));

                            $qb->andWhere('i.' . $dbName . ' LIKE :' . $dbName);
                            $qb->setParameter($dbName, "%" . $lflValue->getName() . "%");
                        }
                    }
                }
            }
        }
        //sort

        //die();


        if ($this->sort_by == 'date_created') {

            $qb->addOrderBy("i.date_updated", $this->sort_order);
            $qb->addOrderBy("i.date_created", $this->sort_order);
        } else {
            if (!empty($this->sort_by)) {
                if(array_key_exists($this->sort_by,$this->params)){
                    $qb->addOrderBy("i." . $this->sort_by, $this->sort_order);
                }

            }
        }
        $qb->addOrderBy("i.sold", 'ASC');
        $this->queryBuilder = $qb;
        return $qb->getQuery();
    }


    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function createAllQuery($qb, $string)
    {
        $param = "text";
        $words = explode(" ", $string);

        $q = $this->createSingleAllQuery($qb, $param);
        $qb->setParameter($param, $string);
        if (count($words) > 1) {
            $c = 2;
            foreach ($words as $word) {
                $param = "text" . $c;
                $v = " AND ";
                if ($c == 2) {
                    $v = " OR ";
                }
                $q = $q . $v . $this->createSingleAllQuery($qb, $param);

                $qb->setParameter($param, $word);
                $c++;
            }
        }
        $qb->andWhere($q);
        //dump($qb);die();
        return $q;

    }

    private function createSingleAllQuery($qb, $param)
    {
        $q = '(i.model LIKE :' . $param . ' or i.make LIKe :' . $param . ' or i.type LIKE :' . $param . ' or i.body_style LIKE :' . $param . ' or i.year LIKE :' . $param . ' or i.VIN LIKE :' . $param . ' or i.transmission LIKE :' . $param . ' or i.floor_plan LIKE :text or i.keywords LIKE :' . $param . ' or i.stock_nr LIKE :' . $param . ')';
        return $q;
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
        $finder = $this->container->get('fos_elastica.finder.app.item');
        $boolQuery = new \Elastica\Query\BoolQuery();

        foreach ($this->params as $key => $searchItem) {
            if ($searchItem instanceof SearchItem) {

                if (!$searchItem->isValueEmpty()) {

                    if($searchItem->isString()){

                        if($searchItem->getDbFieldName()=='status'){
                            //search by lowercase and upercase until i find better solution
                            $fieldQuery = new \Elastica\Query\Wildcard();
                            $fieldQuery->setValue('status',strtolower($searchItem->getValue()).'*');
                            $boolQuery->addShould($fieldQuery);

                            $fieldQuery = new \Elastica\Query\Wildcard();
                            $fieldQuery->setValue('status',strtoupper($searchItem->getValue()).'*');
                            $boolQuery->addShould($fieldQuery);
                        }else{

                        }
                    }elseif($searchItem->isInt()){
                        $fieldQuery = new \Elastica\Query\Term();
                        $fieldQuery->setTerm($searchItem->getDbFieldName(),$searchItem->getValue());
                        $boolQuery->addShould($fieldQuery);
                    }elseif($searchItem->isCategory()){
                        $fieldQuery = new \Elastica\Query\Term();
                        $fieldQuery->setTerm('categoryName',$searchItem->getValue());
                        $boolQuery->addShould($fieldQuery);
                    }

                }
            }

        }



        $this->pagerFanta = $finder->findPaginated($boolQuery);

    }

    public function getPagerFanta(){
        return $this->pagerFanta;
    }
}
