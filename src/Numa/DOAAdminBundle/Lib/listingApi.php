<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MemcacheWrapper
 *
 * @author genjerator
 */

namespace Numa\DOAAdminBundle\Lib;

use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\DependencyInjection\Container;

class listingApi {

    private $container;
    /*'item method casll => name in XML*/
    public  $map=array(
        'year'=>'year',
        'VIN'=>'VIN',
        'status'=>'status',
        'model'=>'model',
        'make'=>'make',
        'stockNr'=>'stock_number',
        'trim'=>'trim',
        'mileage'=>'mileage',
        'engine'=>'engine',
        'interiorColor'=>'interiorColor',
        'exteriorColor'=>'exteriorColor',
        'driveType'=>'driveType',
        'bodyStyle'=>'bodyStyle',
        'FuelType'=>'fuelType',
        'price'=>'price',
        'ImagesForApi'=>'images',
        'OptionsForApi'=>'options',
    );
    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function prepareListing($itemid){
        $res=array();
        $em = $this->container->get('doctrine');
        $item = $em->getRepository("NumaDOAAdminBundle:Item")->find($itemid);
        $res = $this->prepareItem($item);
        return $res;
    }

    public function prepareItem(Item $item){
        foreach($this->map as $name=>$map){

            $res[$map]=$item->get($name);
        }
        return $res;
    }

    public function prepareListingByDealer($dealerid){
        $res=array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealer($dealerid);
        foreach($items as $item){
            $res['listing'][]=$this->prepareItem($item);
        }
        return $res;
    }


}
