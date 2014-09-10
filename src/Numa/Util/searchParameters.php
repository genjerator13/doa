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

    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
        $this->initParams();
    }

    public function initParams() {
        $this->init = true;
        $this->params = array(
            //universal
            'category' => new SearchItem('category', '', 'string'),
            'category_id' => new SearchItem('category', 0, 'category'),
            'priceFrom' => new SearchItem('Price', 0, 'rangeFrom'),
            'priceTo' => new SearchItem('Price', '', 'rangeTo'),
            'yearTo' => new SearchItem('Year', 0, 'rangeFrom'),
            'yearFrom' => new SearchItem('Year', 0, 'rangeTo'),
            //marine
            'searchText' => new SearchItem('all', "", "string"),
            'boatType' => new SearchItem('Boat Type', 0, "int"),
            'boatModel' => new SearchItem('Boat Model',"", "string"),
            'boatMake' => new SearchItem('Boat Make',0, "int"),            
            //cars
            'bodyStyle' => new SearchItem('Body Style', "", 'string'),
            'make' => new SearchItem('make', "", 'int'),
            'model' => new SearchItem('model', "", 'string'),
        );
    }

    public function getParams() {
        return $this->params;
    }

    public function get($key) {
        $value = $this->params[$key];
        return $value;
    }

    public function dump() {
        foreach ($this->params as $key => $value) {
            if ($value instanceof SearchItem) {
                echo $key.":::::";
                $value->dump();
            }
        }
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
        $searchItem = $this->get($key);
        if($searchItem instanceof SearchItem){            
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
                        print_r($searchItem);
                        if ($type == 'all') {
                            $qb->andWhere('ifield.field_string_value LIKE :text');
                            $qb->setParameter('text', "%" . $searchItem->getValue() . "%");
                        } elseif ($type == 'category') {
                            $qb->andWhere('i.category_id=:cat');
                            $qb->setParameter('cat', $searchItem->getValue());
                        } elseif ($type == 'string') {
                            $qb->andWhere('ifield.field_name = \'' . $searchItem->getDbFieldName() . '\'');                            
                            $qb->andWhere('ifield.field_string_value like \'%' . $searchItem->getValue().'%\'');
                        } elseif ($type == 'int') {
                            $qb->andWhere('ifield.field_name = \'' . $searchItem->getDbFieldName() . '\'');                            
                            $qb->andWhere('ifield.field_integer_value = ' . $searchItem->getValue());
                        }
                        elseif ($type == 'rangeFrom') {
                            $qb->andWhere('ifield.field_name = \''.$searchItem->getDbFieldName().'\'');
                            $qb->andWhere('ifield.field_integer_value <=' . $searchItem->getValue());
                            //$qb->orderBy('ifield.field_integer_value', "ASC");
                        }elseif ($type == 'rangeTo') {
                            $qb->andWhere('ifield.field_name = \''.$searchItem->getDbFieldName().'\'');
                            $qb->andWhere('ifield.field_integer_value >=' . $searchItem->getValue());
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
