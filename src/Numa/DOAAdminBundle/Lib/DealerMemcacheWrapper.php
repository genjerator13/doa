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

use Numa\DOAAdminBundle\Entity\Catalogrecords;

use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOAModuleBundle\Entity\Component;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class DealerMemcacheWrapper extends MemcacheWrapper
{
    const dealerPrefix = "dealer_";
    public function setDealer(Catalogrecords $dealer){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer(array($normalizer));
        $arrayDealer = $serializer->normalize($dealer, null, array('groups' => array('site')));
        $this->getContainer()->get('mymemcache')->set(self::dealerPrefix . $dealer->getId(),$arrayDealer);
    }

    public function getDealer($dealer_id){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer(array($normalizer));
        $memDealer = $this->getContainer()->get('mymemcache')->get(self::dealerPrefix . $dealer_id);
        $memObjDealer = null;
        if(!empty($memDealer)) {
            $memObjDealer = $serializer->denormalize(
                $memDealer,
                Catalogrecords::class,
                null,
                array('groups' => array('site'))
            );
            $dealer = $memObjDealer;
            $memObjDealer->setId($memDealer['id']);
        }
        return $memObjDealer;
    }

    public function deleteDealerCache(Catalogrecords $dealer){
        $dealerHost = str_replace("www.", "", $dealer->getSiteUrl());
        $key = $this::dealerPrefix.$dealerHost;

        $dealerQueue = $this->get("dealer_".$dealer->getId());
        if(!empty($dealerQueue)){
            foreach ($dealerQueue as $item) {
                $this->delete($item);
            }
        }

        $dealerQueue = $this->set("dealer_".$dealer->getId(),"");
        return $this->delete($key);
    }

    public function addToDealerQueue($dealerId,$key){
        $dealerQueue = $this->get("dealer_".$dealerId);

        if(empty($dealerQueue)){
            $dealerQueue = array();
        }

        array_push($dealerQueue,$key);
        $this->set("dealer_".$dealerId,$dealerQueue);
    }
    public function getPageComponent($url, $dealerId,$name){

        $key = "pagecomponent_".$dealerId."_".$url."_".$name;

        $em=$this->getContainer()->get("doctrine.orm.entity_manager");
        $function = function () use ($url,$dealerId,$name,$em) {

            return $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($url, $dealerId,$name);;
        };

        return $this->getObject($key, $function, $dealerId);
    }

    public function getObject($key,$function,$dealerId){
        $mem = $this->get($key);
//        $em=$this->getContainer()->get("doctrine.orm.entity_manager");
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer(array($normalizer));
        $component = null;
        if(empty($mem)){
            $dbObj = $function;
            $arrayComponent = $serializer->normalize($dbObj, null, array('groups' => array('site')));
            $this->set($key,$arrayComponent);
            $this->addToDealerQueue($dealerId,$key);
            $component = $dbObj;
        }else{

            $memObj = $serializer->denormalize(
                $mem,
                Component::class,
                null,
                array('groups' => array('site'))
            );
            $memObj->setId($mem['id']);
            $component = $memObj;
        }
        return $component;
    }

    public function getDealerComponent($dealer,$name){
        $key = "dealercomponent_".$dealer->getId()."_".$name;
        $em=$this->getContainer()->get("doctrine.orm.entity_manager");

        $function = function () use ($dealer,$name,$em) {

            return $em->getRepository('NumaDOADMSBundle:DealerComponent')->findOneBy(array('Dealer'=>$dealer,'name'=>$name));
        };

        return $this->getObject($key, $function, $dealer->getId());
    }

}
