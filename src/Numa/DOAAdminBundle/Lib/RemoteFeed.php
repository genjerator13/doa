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
    const UPLOAD = "upload-file";

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
            $this->fetchRemoteProperties();
        }
        return $this->properties;
    }

    public function fetchRemoteProperties() {


        if (empty($this->properties)) {
            if (self::URL == $this->entity->getImportMethod() || self::UPLOAD == $this->entity->getImportMethod()) {
                if (self::XML == $this->entity->getImportFormat()) {
                    $xml_obj = simplexml_load_file($this->source);
                    foreach ($xml_obj->children() as $child) {
                        foreach ($child->children() as $property) {

                            $this->properties[$property->getName()] = $property->getName();
                        }
                        break;
                    }
                } elseif (self::CSV == $this->entity->getImportFormat()) {
                    $handleSource = $this->entity->getAbsolutePath();
                    //echo strtolower(substr( $this->entity->getImportSource(), 0, 6 )).":::";
                    /*
                    if (strtolower(substr($this->entity->getImportSource(), 0, 6)) == "ftp://") {

                        $handleSource = $this->entity->getImportSource();
                        $upload_path = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->getParameter('upload_feed');
                        $local_file .= $this->entity->getID() . "/ftp_source.csv";
die($local_file);
                        ftp_get($ftpExplode[0], $local_file, $ftpExplode[1], FTP_ASCII);
                        
                    }
                    //die($handleSource);
                     * 
                     */
                    if (($handle = fopen($handleSource, "r")) !== FALSE) {
                        $row = fgetcsv($handle);
                        //set the properties from header
                        foreach ($row as $hCell) {

                            $this->properties[$hCell] = $hCell;
                        }
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
        $rowCount = 0;
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
            $filename = $this->entity->getAbsolutePath();
            if (strtolower(substr($this->entity->getImportSource(), 0, 6)) == "ftp://") {

                $handleSource = $this->entity->getImportSource();
                $upload_path = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->getParameter('upload_feed');
                if(!file_exists($upload_path .  $this->entity->getID())){
                    mkdir($upload_path .  $this->entity->getID());
                    echo $upload_path .  $this->entity->getID();
                }
                
                $local_file = $upload_path .  $this->entity->getID() . "/ftp_source.csv";
                $conn = self::getFtpConnection($handleSource);
                $ftpExplode = explode("/", $handleSource);

                ftp_get($conn, $local_file, $ftpExplode[count($ftpExplode)-1], FTP_ASCII);
                
                $filename = $local_file;
            }
            if (($handle = fopen($filename, "r")) !== FALSE) {
                
                
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

    static function getFtpConnection($uri) {
        // Split FTP URI into:
        // $match[0] = ftp://username:password@sld.domain.tld/path1/path2/
        // $match[1] = ftp://
        // $match[2] = username
        // $match[3] = password
        // $match[4] = sld.domain.tld
        // $match[5] = /path1/path2/
        preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)\/(.*)/i", $uri, $match);

        // Set up a connection
        print_r($match);
        $conn = ftp_connect($match[3]);

        // Login
        if (ftp_login($conn, $match[1], $match[2])) {
            // Change the dir
            //ftp_chdir($conn, $match[5]);
            ftp_pasv($conn, true);
            // Return the resource
            return $conn;
        }

        // Or retun null
        return null;
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
