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
        $res['id']=$item->get('id');
        $router=$this->container->get('router');
        //path('item_details', {'itemId': item.id, 'description': desc|url_encode(),'searchQ':searchQ});
        $urldesription= $item->getMake()."-".$item->getModel();
       // dump($item);die();
        $res['url']= $router->generate('item_details',array('itemId' => $item->getId(),'description'=>$urldesription),true);

        foreach($map as $name=>$value){
            $res[$value]=$item->get($name);
        }

        //dump($res);
        //die();
        return $res;
    }

    public function prepareListingByDealer($dealerid,$category){
        $res=array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerAndCategory($dealerid,$category);
        foreach($items as $item){
            $res['listing'][]=$this->prepareItem($item);
        }
        return $res;
    }

    public function prepareAll($category){
        $res=array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByCat($category);
        foreach($items as $item){
            $res['listing'][]=$this->prepareItem($item);
        }
        return $res;
    }


}
