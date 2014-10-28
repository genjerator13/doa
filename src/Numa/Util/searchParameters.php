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
        $this->listing_per_page=10;
        $this->params = array(
            //universal
            'text' => new SearchItem('all', '', 'text'),
            'category' => new SearchItem('category', '', 'string'),
            'category_id' => new SearchItem('category', 0, 'category'),
            'priceFrom' => new SearchItem('Price', 0, 'rangeFrom'),
            'priceTo' => new SearchItem('Price', '', 'rangeTo'),
            'yearTo' => new SearchItem('Year', 0, 'rangeFrom'),
            'yearFrom' => new SearchItem('Year', 0, 'rangeTo'),
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
            'boatType' => new SearchItem('Boat Type', 0, "int"),
            'boatModel' => new SearchItem('Boat Model', "", "string"),
            'boatMake' => new SearchItem('Boat Make', 0, "int"),
            //cars
            'bodyStyle' => new SearchItem('Body Style', "", 'string'),
            'make' => new SearchItem('make', "", 'int'),
            'model' => new SearchItem('model', "", 'string'),
            'transmission' => new SearchItem('Transmission', 0, 'int'),
            'engine' => new SearchItem('Engine', 0, 'int'),
            'mileageFrom' => new SearchItem('Mileage', 0, 'rangeFrom'),
            'mileageTo' => new SearchItem('Mileage', 0, 'rangeTo'),
            'fuelType' => new SearchItem('fuelType', 0, 'int'),
        );
    }

    public function getParams() {
        return $this->params;
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
    public function setListingPerPage($lpg=10){
        $this->listing_per_page = $lpg;
    }
    
    public function getListingPerPage(){
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

    public function createSearchQuery() {
        //create query
        $qb = $this->container->get('doctrine')->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from('NumaDOAAdminBundle:Item', 'i')
                ->join('i.ItemField', 'ifield');

        //->orderBy('u.name', 'ASC');

        foreach ($this->params as $key => $searchItem) {
            if ($this->isParamSet($key)) {

                if ($searchItem instanceof \Numa\Util\SearchItem) {

                    if (!$searchItem->isValueEmpty()) {
                        $type = $searchItem->getType();
                        
                        if ($type == 'text') {
                            $qb->andWhere('ifield.field_string_value LIKE :text');
                            $qb->setParameter('text', "%" . $searchItem->getValue() . "%");
                        } elseif ($type == 'category') {
                            $qb->andWhere('i.category_id=:cat');
                            $qb->setParameter('cat', $searchItem->getValue());
                        } elseif ($type == 'string') {
                            $qb->andWhere('ifield.field_name like \'%' . $searchItem->getDbFieldName() . '%\'');
                            $qb->andWhere('ifield.field_string_value like \'%' . $searchItem->getValue() . '%\'');
                        } elseif ($type == 'int') {
                            $qb->andWhere('ifield.field_name like \'%' . $searchItem->getDbFieldName() . '%\'');
                            $qb->andWhere('ifield.field_integer_value = ' . $searchItem->getValue());
                        } elseif ($type == 'rangeFrom') {
                            $qb->andWhere('ifield.field_name like \'%' . $searchItem->getDbFieldName() . '%\'');
                            $qb->andWhere('ifield.field_integer_value <=' . $searchItem->getValue());
                            //$qb->orderBy('ifield.field_integer_value', "ASC");
                        } elseif ($type == 'rangeTo') {
                            $qb->andWhere('ifield.field_name like \'%' . $searchItem->getDbFieldName() . '%\'');
                            $qb->andWhere('ifield.field_integer_value >=' . $searchItem->getValue());
                            //$qb->orderBy('ifield.field_integer_value', "ASC");
                        } elseif ($type == 'dateRangeFrom') {
                            $qb->andWhere('i.date_created >= :dateFrom')
                            
                                    ->setParameter('dateFrom', $monday->format('Y-m-d'))
                                    ->setParameter('sunday', $sunday->format('Y-m-d'));
                        } elseif ($type == 'dateRangeTo') {
                            $qb->andWhere('i.date_created >=' . $searchItem->getValue());
                            //$qb->orderBy('ifield.field_integer_value', "ASC");
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
