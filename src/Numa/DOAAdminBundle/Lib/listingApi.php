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
use Numa\DOAAdminBundle\Entity\Listingfield;
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
        $listing = $em->getRepository("NumaDOAAdminBundle:Listingfield")->findByCategory($item->getCategoryId());


        $res = $this->prepareItem($item);

        return $res;
    }

    public function prepareItem(Item $item){
        $em = $this->container->get('doctrine');
        $res=array();
        $map=array();
        $listings = $em->getRepository("NumaDOAAdminBundle:Listingfield")->findByCategory($item->getCategoryId());
        foreach($listings as $listing){

            if($listing instanceof Listingfield) {
                $itemProperty = str_ireplace(array(' ', '-', "#", "(",")"), '', ucfirst($listing->getCaption()));
                $apifield = str_ireplace(array(' ', '-', "#", "(",")"), '', ucfirst($listing->getCaption()));
                if (!empty($listing->getItemFieldCaption())) {
                    $itemProperty = $listing->getItemFieldCaption();
                }

                if (!empty($listing->getApiCaption())) {
                    $apifield = $listing->getApiCaption();
                }
                if (!$listing->getExcludeFromApi()) {
                    $map[$itemProperty] = $apifield;
                }
            }
        }
        //dump($map);
        foreach($map as $name=>$value){
            $res[$value]=$item->get($name);
        }

        //dump($res);
        //die();
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
