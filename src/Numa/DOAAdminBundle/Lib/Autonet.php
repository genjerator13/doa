<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Autonet
 *
 * @author genjerator
 */

namespace Numa\DOAAdminBundle\Lib;

use Symfony\Component\DependencyInjection\SimpleXMLElement;

class Autonet extends Curl {

    //put your code here
    public function __construct() {
        $username = "MediaTech";
        $password = "CaHuVB9";
        $this->setPassword($password);
        $this->setUsername($username);
        $this->setBaseUrl("https://www.agedstock.com/services/edi/");
        parent::__construct();
    }

    public function allDealersList() {
        $this->setUrlSuffix("dealers/");
    }

    public function parseAlldealers() {
        $this->setUrlSuffix("dealers/");
        $dealers = $this->call();

        $dealerXml = new SimpleXMLElement($dealers);

        $json = json_encode($dealerXml);
        $array = json_decode($json, TRUE);

        $res = array();

        return $array;
    }

    public function parseDealerVehicles($dealer_id) {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles");
        $dealers = $this->call();

        $dealerXml = new SimpleXMLElement($dealers);
        $json = json_encode($dealerXml);
        $array = json_decode($json, TRUE);

        $xml = "<inventory>";
        foreach ($array['vehicle'] as $vehicle) {
            $vehXML = $this->getVehicleXml($dealer_id, $vehicle['@attributes']['id']);

            $xml .= $vehXML;
        }
        $xml .= "</inventory>";

        return $xml;
    }

    public function getVehicleXml($dealer_id, $vehicle_id) {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id);
        $vehicles = $this->call();

        $vehiclesXml = new SimpleXMLElement($vehicles);
        $json = json_encode($vehiclesXml);
        $array = json_decode($json, TRUE);
        $photos = $this->getVehiclePhotos($dealer_id, $vehicle_id);
       
        
        
        //foreach ()
        $xml1 = simplexml_load_string( $vehicles);
        $xml2 = simplexml_load_string($photos);

        $domToChange = dom_import_simplexml($xml1->photos);
        dump($photos);
        $domReplace = dom_import_simplexml($xml2);

        $nodeImport = $domToChange->ownerDocument->importNode($domReplace, TRUE);
        $domToChange->parentNode->replaceChild($nodeImport, $domToChange);

        $xml = str_replace('<?xml version="1.0"?>', "",$xml1->asXML());
        //dump($xml);die();
        return $xml;
    }

    public function getVehiclePhotos($dealer_id, $vehicle_id) {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id . "/photos");
        $photos = $this->call();

        $photosXml = new SimpleXMLElement($photos);
        $json = json_encode($photosXml);
        $array = json_decode($json, TRUE);
        $photosXml = "\n<photos>\n";
        if(!empty($array['photo'])){
            
            foreach ($array['photo'] as $key=>$photo) {
                $photosXml .= "<photo>\n";
                $photosXml .= $this->getFullPath()."/".$key."\n";                
                $photosXml .= "</photo>\n";
            }
            
        }
        $photosXml .= "</photos>\n";
        //dump($photosXml);die();
        return $photosXml;
    }

    public function getPhoto($dealer_id, $vehicle_id, $photo_id) {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id . "/photos");
        $photos = $this->call();

        $photosXml = new SimpleXMLElement($photos);
        $json = json_encode($photosXml);
        $array = json_decode($json, TRUE);

        return $array;
    }

}
