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
class RemoteFeed extends ContainerAware
{

    const URL = "Link-URL";
    const XML = "XML";
    const CSV = "CSV";
    const UPLOAD = "upload-file";

    var $properties = array();
    var $em;
    var $entity;
    var $source;
    var $category;
    var $items;

    public function __construct($id)
    {
        $this->feedid = $id;

        $this->getFeed();
    }

    public function getFeed()
    {
        $this->em = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->get('doctrine')->getManager('default');

        $this->entity = $this->em->getRepository('NumaDOAAdminBundle:Importfeed')->findOneById($this->feedid);
        $this->items = array();
        $this->source = $this->entity->getImportSource();
        $this->category = $this->entity->getCategory();
    }

    public function getRemoteProperties()
    {
        if (empty($this->properties)) {
            $this->fetchRemoteProperties();

        }
        return $this->properties;
    }

    /**
     * fetches meta data from remote sources: columns from csv or nodes from XML
     *
     */
    public function fetchRemoteProperties()
    {

        $upload_path = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->getParameter('upload_feed');
        if (self::URL == $this->entity->getImportMethod()) {
            $upload_path = "";
        }
        if (empty($this->properties)) {

            if (self::URL == $this->entity->getImportMethod() || self::UPLOAD == $this->entity->getImportMethod()) {

                if (self::XML == $this->entity->getImportFormat()) {
                    //$xml_obj = simplexml_load_file($upload_path . $this->source);
                    $xml_obj = simplexml_load_file($upload_path . $this->source, null, LIBXML_NOERROR);
                    //simplexml_load_file('url', null, LIBXML_NOERROR);
                    $rootNode = $this->entity->getRootNode();
                    if (!empty($rootNode)) {
                        $xmlSource = $xml_obj->xpath($this->entity->getRootNode());
                    }
                    if (empty($xmlSource)) {
                        $xmlSource = $xml_obj->children();
                    }

                    foreach ($xmlSource as $child) {
                       // dump($xmlSource);

                        foreach ($child->children() as $property) {

                            if ($property instanceof \SimpleXMLElement) {
                                //foreach($property->children() as $innerproperty){
                                $array = json_decode(json_encode($property), TRUE);
                                foreach ($array as $key => $prop) {
                                    if (is_string($prop)) {
                                        //dump($property->getName() . "::" . $prop . ":::" . $key);
                                        //dump($prop);
                                        if(!empty($key)) {
                                            $this->properties[$property->getName() . "_" . $key] = $property->getName() . "_" . $key;
                                        }
                                    }
                                }

                                //}
                            }
                            $this->properties[$property->getName()] = $property->getName();

                        }
                        //die();
                        break;
                    }

                } elseif (self::CSV == $this->entity->getImportFormat()) {
                    $handleSource = $this->entity->getImportSource();

                    if (!file_exists($upload_path . $this->entity->getID())) {
                        mkdir($upload_path . $this->entity->getID());
                    }
                    $filename = $this->entity->getAbsolutePath();
                    $local_file = $upload_path . $this->entity->getID() . "/ftp_source.csv";
                    if (strtolower(substr($this->entity->getImportSource(), 0, 6)) == "ftp://") {
                        $ftp = self::getFtpConnection($handleSource);
                        ftp_get($ftp['conn'], $local_file, $ftp['filepath'], FTP_ASCII);
                        $filename = $local_file;
                    } elseif (strtolower(substr($this->entity->getImportSource(), 0, 7)) == "http://") {

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $handleSource);
                        $fp = fopen($local_file, 'w');
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_exec($ch);
                        curl_close($ch);
                        fclose($fp);
                        $filename = $local_file;
                    }
                    if (!file_exists($filename)) {
                        trigger_error("Import source does not exists!!!", E_USER_ERROR);
                    }
                    if (($handle = fopen($filename, "r")) !== FALSE) {
                        $delimeter = $this->entity->getDelimiterx();
                        if (empty($delimeter)) {
                            $delimeter = ',';
                        }
                        $row = fgetcsv($handle, 0, $delimeter);
                        //set the properties from header
                        foreach ($row as $hCell) {

                            $this->properties[$hCell] = $hCell;
                        }
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
                //$this->items = self::xml2array($xml_obj->children());
                $this->items = json_decode(json_encode((array)$xml_obj), 1);
                if (!empty($this->items['item'])) {
                    $this->items = $this->items['item'];
                } elseif (!empty($this->items['inventor'])) {
                    $this->items = $this->items['inventor'];
                }
                return $this->items;
            }
        }
    }

    public function getRemoteItems()
    {

        $sourceFile = $this->source;
        $upload_path = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->getParameter('upload_feed');
        $rootNode = $this->entity->getRootNode();
        $root = explode("/", $rootNode);

        if (self::UPLOAD == $this->entity->getImportMethod()) {
            $sourceFile = $upload_path . $sourceFile;
        }
        if (self::XML == $this->entity->getImportFormat()) {
            $xml_obj = simplexml_load_file($sourceFile, 'SimpleXMLElement', LIBXML_NOCDATA);

            $rootNode = $this->entity->getRootNode();
            if (!empty($rootNode)) {
                $xmlSource = $xml_obj->xpath($rootNode);
            }

            if (empty($xmlSource)) {
                $xmlSource = $xml_obj->children();
            }

            ///$this->items = self::xml2array($xmlSource);

            $this->items = json_decode(json_encode((array)$xml_obj), 1);
            // dump($rootNode);


            if (!empty($rootNode)) {

                $c = 0;
                $temp = $this->items;
                foreach ($root as $node) {
                    if (!empty($node)) {
                        if ($c > 0) {
                            $temp = $temp[$node];

                        }
                        $c++;
                    }
                }
                //die();
                if (!empty($temp)) {
                    $this->items = $temp;
                }
            } else {
                if (!empty($this->items['item'])) {
                    $this->items = $this->items['item'];
                } elseif (!empty($this->items['inventor'])) {
                    $this->items = $this->items['inventor'];
                }
            }

            //$arrayItem = $this->xml2array($this->items);
            $temp = $this->items;

            foreach ($temp as $itemkey=>$item) {
                foreach ($item as $key => $prop) {

                    if (is_array($prop)) {
                        foreach ($prop as $keyvalue => $value) {
                            if (is_string($value)) {

                                //dump($key.":".$keyvalue . ":" . $value);
                                $this->items[$itemkey][$key."_".$keyvalue] = $value;

                            }
                        }
                    }
                }

            }


            return $this->items;
        }
        if (self::CSV == $this->entity->getImportFormat()) {

            $filename = $this->entity->getAbsolutePath();
            $rowCount = 0;

            $handleSource = $this->entity->getImportSource();
            $local_file = $upload_path . $this->entity->getID() . "/ftp_source.csv";
            if (strtolower(substr($this->entity->getImportSource(), 0, 6)) == "ftp://") {


                if (!file_exists($upload_path . $this->entity->getID())) {
                    mkdir($upload_path . $this->entity->getID());
                    echo $upload_path . $this->entity->getID();
                }


                $ftp = self::getFtpConnection($handleSource);

                ftp_get($ftp['conn'], $local_file, $ftp['filepath'], FTP_ASCII);
                $filename = $local_file;
            } elseif (strtolower(substr($this->entity->getImportSource(), 0, 7)) == "http://") {

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $handleSource);
                $fp = fopen($local_file, 'w');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                $filename = $local_file;
            }

            if (!file_exists($filename)) {
                trigger_error("Import source does not exists!!!", E_USER_ERROR);
            }
            if (($handle = fopen($filename, "r")) !== FALSE) {
                $delimeter = $this->entity->getDelimiterx();
                if (empty($delimeter)) {
                    $delimeter = ',';
                }

                while (($row = fgetcsv($handle, 0, $delimeter)) !== FALSE && !empty($row) ) {
                    //var_dump($row); // process the row.

                    if ($rowCount > 0) {
                        foreach ($header as $key => $value) {

                            $tmp[trim($value)] = $row[trim($key)];

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

    public function createItems()
    {
        foreach ($this->items as $item) {
            $item = new Item();
        }
    }

    static function getFtpConnection($uri)
    {
        // Split FTP URI into:
        // $match[0] = ftp://username:password@sld.domain.tld/path1/path2/
        // $match[1] = ftp://
        // $match[2] = username
        // $match[3] = password
        // $match[4] = sld.domain.tld
        // $match[5] = /path1/path2/
        preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)\/(.*)/i", $uri, $match);

        // Set up a connection

        $conn = ftp_connect($match[3]);

        // Login
        if (ftp_login($conn, $match[1], $match[2])) {
            // Change the dir
            //ftp_chdir($conn, $match[5]);
            ftp_pasv($conn, true);
            // Return the resource
            return array('conn' => $conn, 'filepath' => $match[4]);
        }

        // Or retun null
        return null;
    }

    static function xml2array1($xmlObject, $out = array())
    {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? self::xml2array($node) : $node;

        return $out;
    }

    static function xml2array($xml)
    {
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
