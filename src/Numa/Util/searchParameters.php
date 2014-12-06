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
class searchParameters {

    private $container;
    protected $page = 1;
    protected $sort = "";
    protected $order = "asc";
    public $init = false;
    protected $params = array();
    protected $listing_per_page;

    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
        $this->initParams();
    }

    public function initParams() {
        $this->init = true;
        $this->listing_per_page = 10;
        $this->params = array(
            //universal
            'text' => new SearchItem('all', '', 'text'),
            'category' => new SearchItem('category', '', 'string'),
            'category_id' => new SearchItem('category', 0, 'category'),
            'priceFrom' => new SearchItem('price', 0, 'rangeFrom'),
            'priceTo' => new SearchItem('price', '', 'rangeTo'),
            'yearTo' => new SearchItem('year', 0, 'rangeTo'),
            'yearFrom' => new SearchItem('year', 0, 'rangeFrom'),
            'postedFrom' => new SearchItem('date_created', 0, 'dateRangeFrom'),
            'postedTo' => new SearchItem('date_created', 0, 'dateRangeTo'),
            'zip' => new SearchItem('Postal', "", 'string'),
            'IW_NO' => new SearchItem('IW_NO', "", 'string'),
            'isSold' => new SearchItem('active', 0, 'int'),
            'exteriorColor' => new SearchItem('color', 0, 'int'),
            'interiorColor' => new SearchItem('color', 0, 'int'),
            //'withPicture'      => new SearchItem('color', 0, 'int'),
            //marine
            'searchText' => new SearchItem('all', "", "text"),
            'boatType' => new SearchItem('type', 0, "list"),
            'boatModel' => new SearchItem('model', "", "string"),
            'boatMake' => new SearchItem('make', 0, "list"),
            //cars
            'bodyStyle' => new SearchItem('body_style', "", 'list'),
            'make' => new SearchItem('make', "", 'tree'),
            'model' => new SearchItem('model', "", 'string'),
            'transmission' => new SearchItem('Transmission', 0, 'int'),
            'engine' => new SearchItem('Engine', 0, 'int'),
            'mileageFrom' => new SearchItem('Mileage', 0, 'rangeFrom'),
            'mileageTo' => new SearchItem('Mileage', 0, 'rangeTo'),
            'fuelType' => new SearchItem('fuelType', 0, 'int'),
        );
    }

    public function getParams($all = true) {
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

    public function makeUrlQuery() {
        $params = $this->getParams(false);
        $aQuery = array();
        foreach ($params as $key => $value) {
            $aQuery[] = $key . "=" . $value->getValue();
        }
        $query = implode("&", $aQuery);
        return $query;
    }

    public function get($key) {
        if ($this->isParamSet($key)) {
            $value = $this->params[$key];
            return $value;
        }
        return $false;
    }

    public function dump() {
        foreach ($this->params as $key => $value) {
            if ($value instanceof SearchItem) {

                $value->dump();
            }
        }
    }

    public function setListingPerPage($lpg = 10) {
        $this->listing_per_page = $lpg;
    }

    public function getListingPerPage() {
        return $this->listing_per_page;
    }

    public function setAll($params) {
        foreach ($params as $key => $value) {
            if ($this->isParamSet($key)) {
                $this->params[$key]->setValue($value);                
            }
        }
    }

    public function set($key, $value) {
        $this->params[$key] = $value;
    }

    public function isParamSet($key) {
        if (!empty($this->params[$key]) && $this->params[$key] instanceof SearchItem) {
            return true;
        }
        return false;
    }

    public function isParamValueSet($key) {

        if (!empty($this->params[$key]) && $this->params[$key] instanceof SearchItem) {
            $searchItem = $this->params[$key];
            $searchItemValue = $searchItem->getValue();
            if (!empty($searchItemValue)) {
                return true;
            }
        }
        return false;
    }

    public function createSearchQuery() {
        //create query
        $qb = $this->container->get('doctrine')->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from('NumaDOAAdminBundle:Item', 'i');

        //->orderBy('u.name', 'ASC');

        foreach ($this->params as $key => $searchItem) {
            if ($this->isParamSet($key)) {

                if ($searchItem instanceof \Numa\Util\SearchItem) {

                    if (!$searchItem->isValueEmpty()) {
                        var_dump($searchItem);
                        $type = $searchItem->getType();
                        $dbName = $searchItem->getDbFieldName();
                        $value = $searchItem->getValue();
                        echo $dbName . ":" . $type;
                        if ($type == 'text') {
                            $qb->andWhere('i.' . $dbName . ' LIKE :text');
                            $qb->setParameter('text', "%" . $searchItem->getValue() . "%");
                        } elseif ($type == 'category') {
                            $qb->andWhere('i.category_id=:cat');
                            $qb->setParameter('cat', $searchItem->getValue());
                        } elseif ($type == 'string') {
                            $qb->andWhere('i.' . $dbName . ' LIKE :' . $dbName);
                            $qb->setParameter($dbName, "%" . $searchItem->getValue() . "%");
                        } elseif ($type == 'int') {
//                            $qb->andWhere('ifield.field_name like \'%' . $searchItem->getDbFieldName() . '%\'');
//                            $qb->andWhere('ifield.field_integer_value = ' . $searchItem->getValue());
                        } elseif ($type == 'rangeFrom') {
                            $qb->andWhere('i.' . $dbName . ' >= :' . $dbName."from");
                            $qb->setParameter($dbName."from", floatval($searchItem->getValue()));
                                                        
                        } elseif ($type == 'rangeTo') {
                            $qb->andWhere('i.' . $dbName . '<= :' . $dbName."to");
                            $qb->setParameter($dbName."to", floatval($searchItem->getValue()));
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
                        } elseif ($type == 'tree') {
                            $lflValue = $this->container->get('doctrine')->getRepository("NumaDOAAdminBundle:ListingFieldTree")->findOneBy(array('id' => $searchItem->getValue()));
                            $qb->andWhere('i.' . $dbName . ' LIKE :' . $dbName);
                            $qb->setParameter($dbName, "%" . $lflValue->getName() . "%");
                        }
                    }
                }
            }
        }
        /*
          if (!empty($make)) {
          $qb->andWhere('ifield.field_name like \'%Boat Make%\'');
          $qb->andWhere('ifield.field_integer_value =' . $make);
          }
          if (!empty($BoatType)) {
          $qb->andWhere('ifield.field_name like \'%Boat Type%\'');
          $qb->andWhere('ifield.field_integer_value =' . $BoatType);
          }
          if (!empty($priceFrom)) {
          $qb->andWhere('ifield.field_name like \'%price%\'');
          $qb->andWhere('ifield.field_integer_value >=' . $priceFrom);
          $qb->orderBy('ifield.field_integer_value', "ASC");
          }
          if (!empty($priceTo)) {
          $qb->andWhere('ifield.field_name like \'%price%\'');
          $qb->andWhere('ifield.field_integer_value <=' . $priceTo);
          $qb->orderBy('ifield.field_integer_value', "ASC");
          }
         * 
         */

        return $qb->getQuery();
    }

    public function getSearchText() {
        return get('searchText');
    }

    public function getPage() {
        return $this->page;
    }

    /**
     * Prepares search text
     * @param type $searchText
     */
    public function setSearchText($searchText) {
        $this->searchText = empty($searchText) ? " " : $searchText;
        $this->set('searchText', $this->searchText);
    }

    /**
     * Prepares page number
     * @param type $page
     */
    public function setPage($page) {
        $intPage = intval($page);
        $this->page = empty($intPage) ? 1 : $intPage;
    }

    public function setBoatModel($boatModel) {
        $this->set('boatModel', $this->set('boatModel', $boatModel));
    }

    public function getBoatModel() {
        return get('searchText');
        ;
    }

    public function setYears($yearfrom, $yearto) {
        $this->set('yearFrom', $yearfrom);
        $this->set('yearTo', $yearto);
    }

    public function getYearfrom() {
        return get('yearFrom');
        ;
    }

    public function getYearto() {
        return get('yearTo');
        ;
    }

    public function setPrice($pricefrom, $priceto) {
        $this->set('priceFrom', $pricefrom);
        $this->set('priceTo', $priceto);
    }

    public function getPricefrom() {
        return get('priceFrom');
        ;
    }

    public function getPriceto() {
        return get('priceTo');
        ;
    }

    public function setSort($sort) {
        if (!empty($sort)) {
            $this->sort = $sort;
        }
    }

    /**
     * Prepares sorting
     * @param type $dateStart
     * @param type $dateEnd
     */
    public function setOrder($order) {
        if (!empty($order)) {
            $this->order = $order;
        }
    }

    public function getSort() {
        return $this->sort;
    }

    public function getOrder() {
        return $this->order;
    }

}
