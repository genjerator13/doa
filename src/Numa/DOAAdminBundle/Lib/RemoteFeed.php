<?php

namespace Numa\DOAAdminBundle\Lib;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Propel1\Tests\Fixtures\Item;
use Symfony\Component\DependencyInjection\ContainerAware;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XMLfeed
 *
 * @author genjerator
 */
class RemoteFeed extends ContainerAware {

    const URL = "Link-URL";
    const XML = "XML";
    const CSV = "CSV";

    var $properties = array();
    var $em;
    var $entity;
    var $source;
    var $category;

    public function __construct($id) {
        $this->feedid = $id;
        $this->getFeed();
    }

    public function getFeed() {
        $this->em = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->get('doctrine')->getEntityManager('default');
        $this->entity = $this->em->getRepository('NumaDOAAdminBundle:Importfeed')->findOneById($this->feedid);
        ;
        $this->source = $this->entity->getImportSource();
        $this->category = $this->entity->getCategory();
    }

    public function getRemoteProperties() {
        if (empty($this->properties)) {
            $this->fetchProperties();
        }
        return $this->properties;
    }

    public function fetchRemoteProperties() {
        if (empty($this->XMLproperties)) {
            if (self::URL == $this->entity->getImportMethod()) {
                if (self::XML == $this->entity->getImportFormat()) {
                    $xml_obj = simplexml_load_file($this->source);
                    foreach ($xml_obj->children() as $child) {
                        foreach ($child->children() as $property) {

                            $this->properties[$property->getName()] = $property->getName();
                        }
                        break;
                    }
                }
            } elseif (self::CSV == $this->entity->getImportFormat()) {
                if (($handle = fopen($this->entity->getAbsolutePath(), "r")) !== FALSE) {
                    $row = fgetcsv($handle);
                    //set the properties from header
                    foreach ($row as $hCell) {

                        $this->properties[$hCell] = $hCell;
                    }
                }
            }
        }
    }

    public function getXMLItems() {
        if (self::URL == $this->entity->getImportMethod()) {
            if (self::XML == $this->entity->getImportFormat()) {
                $xml_obj = simplexml_load_file($this->source);
                $this->items = self::xml2array($xml_obj->children());
                if (!empty($this->items['item'])) {
                    $this->items = $this->items['item'];
                } elseif (!empty($this->items['inventor'])) {
                    $this->items = $this->items['inventor'];
                }
                return $this->items;
            }
        }
    }

    public function getRemoteItems() {

        if (self::URL == $this->entity->getImportMethod()) {
            if (self::XML == $this->entity->getImportFormat()) {
                $xml_obj = simplexml_load_file($this->source);
                $this->items = self::xml2array($xml_obj->children());
                if (!empty($this->items['item'])) {
                    $this->items = $this->items['item'];
                } elseif (!empty($this->items['inventor'])) {
                    $this->items = $this->items['inventor'];
                }
                return $this->xml2array($this->items);
            }
        } elseif (self::CSV == $this->entity->getImportFormat()) {

            if (($handle = fopen($this->entity->getAbsolutePath(), "r")) !== FALSE) {
                $rowCount = 0;
                while (($row = fgetcsv($handle)) !== FALSE) {
                    //var_dump($row); // process the row.

                    if ($rowCount > 0) {
                        foreach ($header as $key => $value) {
                            $tmp[$value] = $row[$key];
                        }
                        $this->items[] = $tmp;
                    } else {
                        $header = $row;
                    }
                    $rowCount++;
                }
            }
        }
        
        return $this->items;
    }

    public function createItems() {
        foreach ($this->items as $item) {
            $item = new Item();
        }
    }

    static function xml2array($xmlObject, $out = array()) {
        foreach ((array) $xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? self::xml2array($node) : $node;

        return $out;
    }

    public static function getValue($XMLvalue, $type = "string") {
        switch ($type) {
            case "string":
                return (string) $XMLvalue;
                break;
            case "integer":
                return intval((string) $XMLvalue);
                break;
            case "hhh":
                echo "i equals 2";
                break;
        }
    }
/*
    public function xml2array($xml) {
        $arr = array();

        foreach ($xml as $element) {
            $tag = $element->getName();
            $e = get_object_vars($element);
            if (!empty($e)) {
                $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
            } else {
                $arr[$tag] = trim($element);
            }
        }

        return $arr;
    }
*/
}
