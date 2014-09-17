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
class XMLfeed extends ContainerAware
{
    const URL = "Link-URL";
    const XML = "XML";
    var $XMLproperties = array();
    var $em;
    var $entity;
    var $source;
    var $category;

    public function __construct($id)
    {
        $this->feedid = $id;
        $this->getFeed();
    }

    public function getFeed()
    {
        $this->em = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->get('doctrine')->getEntityManager('default');
        $this->entity = $this->em->getRepository('NumaDOAAdminBundle:Importfeed')->findOneById($this->feedid);;
        $this->source = $this->entity->getImportSource();
        $this->category = $this->entity->getCategory();
    }
    public function getXMLproperties()
    {
        if (empty($this->XMLproperties)) {
            $this->fetchXMLproperties();
        }
        return $this->XMLproperties;
    }
    public function fetchXMLproperties()
    {

        if (empty($this->XMLproperties)) {
            if (self::URL == $this->entity->getImportMethod()) {
                if (self::XML == $this->entity->getImportFormat()) {

                    $xml_obj = simplexml_load_file($this->source);

                    foreach ($xml_obj->children() as $child) {


                        foreach ($child->children() as $property) {
                            $this->XMLproperties[$property->getName()] = $property->getName();
                        }

                        break;

                    }

                }
            }
        }
    }

    public function getXMLItems()
    {
        if (self::URL == $this->entity->getImportMethod()) {
            if (self::XML == $this->entity->getImportFormat()) {
                $xml_obj = simplexml_load_file($this->source);
                $this->items = self::xml2array($xml_obj->children());
                $this->items = $this->items['item'];
                return $this->items;
            }
        }
    }

    public function createItems()
    {
        foreach ($this->items as $item) {
            $item = new Item();

        }
    }

    static function xml2array($xmlObject, $out = array())
    {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? self::xml2array($node) : $node;

        return $out;
    }

    public static function getValue($XMLvalue, $type = "string")
    {
        switch ($type) {
            case "string":
                return (string)$XMLvalue;
                break;
            case "integer":
                return intval((string)$XMLvalue);
                break;
            case "hhh":
                echo "i equals 2";
                break;
        }
    }
}
