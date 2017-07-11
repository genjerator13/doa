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

class Autonet extends Curl
{

    public $options;

    //put your code here
    public function __construct()
    {
        $username = "MediaTech";
        $password = "CaHuVB9";
        $this->setPassword($password);
        $this->setUsername($username);
        $this->setBaseUrl("https://www.agedstock.com/services/edi/");
        parent::__construct();
    }

    public function allDealersList()
    {
        $this->setUrlSuffix("dealers/");
    }

    public function parseAlldealers()
    {
        $this->setUrlSuffix("dealers/");
        $dealers = $this->call();

        $dealerXml = new SimpleXMLElement($dealers);

        $json = json_encode($dealerXml);
        $array = json_decode($json, TRUE);
        return $array;
    }

    public function parseDealerVehicles($dealer_id)
    {
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

    public function getVehicleXml($dealer_id, $vehicle_id)
    {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id);
        $vehicles = $this->call();
        //ids
        $xml1Vehicles = simplexml_load_string($vehicles);
        $id = (string)$xml1Vehicles->attributes()->id[0];
        $xml1Vehicles->addChild("id", $id);

        //process elements with children
        foreach ($xml1Vehicles->children() as $key => $elements) {
            foreach ($elements->children() as $keyInner => $innerElement) {
                if (strtolower($keyInner) != 'option') {
                    $xml1Vehicles->addChild($key . "_" . $keyInner, $innerElement);
                }
            }
        }

        //replace photo element from vehicle XML

        $photos = $this->getVehiclePhotos($dealer_id, $vehicle_id);
        $xml1Photos = $xml1Vehicles;
        $xml2Photos = simplexml_load_string($photos);
        $domToChangePhotos = dom_import_simplexml($xml1Photos->photos);
        $domReplacePhotos = dom_import_simplexml($xml2Photos);
        $nodeImport = $domToChangePhotos->ownerDocument->importNode($domReplacePhotos, TRUE);
        $domToChangePhotos->parentNode->replaceChild($nodeImport, $domToChangePhotos);

        //replace option element from vehicle XML
        $xml1Options = simplexml_load_string($xml1Photos->asXML());
        $optionsReplacement = $this->processOptions($xml1Options->options);

        $xml2Options = simplexml_load_string($optionsReplacement);
        $domToChangeOptions = dom_import_simplexml($xml1Options->options);

        $domReplaceOptions = dom_import_simplexml($xml2Options);
        $nodeImportOptions = $domToChangeOptions->ownerDocument->importNode($domReplaceOptions, TRUE);
        $domToChangeOptions->parentNode->replaceChild($nodeImportOptions, $domToChangeOptions);

        $xml = str_replace('<?xml version="1.0"?>', "", $xml1Options->asXML());
        return $xml;
    }

    public function getVehiclePhotos($dealer_id, $vehicle_id)
    {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id . "/photos");
        $photos = $this->call();

        $photosXml = new SimpleXMLElement($photos);
        $json = json_encode($photosXml);
        $array = json_decode($json, TRUE);
        $photosXml = "\n<photos>\n";
        if (!empty($array['photo'])) {

            foreach ($array['photo'] as $key => $photo) {
                $photosXml .= "<photo>";
                $photosXml .= $this->getFullPath() . "/" . $key;
                $photosXml .= "</photo>\n";
            }
        }
        $photosXml .= "</photos>\n";

        return $photosXml;
    }

    public function processOptions($options)
    {
        $this->mapOptions();
        $optionsXml = "<options>";
        foreach ($options->option as $option) {
            $tempArray = (array)$option['id'];
            if (array_key_exists($tempArray[0], $this->options)) {
                $optionsXml .= "<option id='" . $tempArray[0] . "'>" . htmlentities($this->options[$tempArray[0]]) . "</option>";
            }
        }
        $optionsXml .= "</options>";
        return $optionsXml;
    }

    public function mapOptions()
    {
        if (empty($this->options)) {
            $this->setUrlSuffix("assets/options");
            $options = $this->call();
            $optionsXml = new SimpleXMLElement($options);
            $json = json_encode($optionsXml);
            $array = json_decode($json, TRUE);
            foreach ($array['class'] as $class) {

                foreach ($class['option'] as $option) {
                    //dump($option);
                    $id = $option['@attributes']['id'];
                    $this->options[$id] = trim($option['desc']);
                }
            }

        }
    }

    public function getOption($dealer_id, $vehicle_id, $photo_id)
    {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id . "/photos");
        $photos = $this->call();

        $photosXml = new SimpleXMLElement($photos);
        $json = json_encode($photosXml);
        $array = json_decode($json, TRUE);

        return $array;
    }

    public function getPhoto($dealer_id, $vehicle_id, $photo_id)
    {
        $this->setUrlSuffix("dealers/" . $dealer_id . "/vehicles/" . $vehicle_id . "/photos");
        $photos = $this->call();

        $photosXml = new SimpleXMLElement($photos);
        $json = json_encode($photosXml);
        $array = json_decode($json, TRUE);

        return $array;
    }

}
