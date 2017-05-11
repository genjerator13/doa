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

use Numa\DOAAdminBundle\Entity\Catalogcategory;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;

class listingApi
{

    private $container;
    /*'item method casll => name in XML*/
    public $map = array(
        'year' => 'year',
        'VIN' => 'VIN',
        'status' => 'status',
        'model' => 'model',
        'make' => 'make',
        'stockNr' => 'stock_number',
        'trim' => 'trim',
        'mileage' => 'mileage',
        'engine' => 'engine',
        'interiorColor' => 'interiorColor',
        'exteriorColor' => 'exteriorColor',
        'driveType' => 'driveType',
        'bodyStyle' => 'bodyStyle',
        'FuelType' => 'fuelType',
        'price' => 'price',
        'ImagesForApi' => 'images',
        'OptionsForApi' => 'options',
    );

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function prepareListing($itemid)
    {
        $res = array();
        $em = $this->container->get('doctrine');

        $item = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($itemid);

        if (count($item) == 1) {
            $res = $this->prepareItem($item[0]);
        } elseif (count($item) > 1) {
            $res = $this->prepareArrayItems($item);
        }
        return $res;
    }

    public function prepareItem(Item $item)
    {
        $em = $this->container->get('doctrine');
        $res = array();
        $map = array();
        $listings = $em->getRepository("NumaDOAAdminBundle:Listingfield")->findByCategory($item->getCategoryId());
        foreach ($listings as $listing) {

            if ($listing instanceof Listingfield) {
                $itemProperty = str_ireplace(array(' ', '-', "#", "(", ")"), '', ucfirst($listing->getCaption()));
                $apifield = str_ireplace(array(' ', '-', "#", "(", ")"), '', ucfirst($listing->getCaption()));
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
        $res['id'] = $item->get('id');
        $res['category'] = $item->getCategory()->getName();
        $res['category_id'] = $item->getCategoryId();
        $res['featured'] = $item->getFeatured();
        $router = $this->container->get('router');
        $host = $router->getContext()->getScheme() . "://" . $router->getContext()->getHost();
        $urldesription = $item->getUrlDescription();
        $res['url'] = $router->generate('item_details', array('itemId' => $item->getId(), 'description' => $urldesription), true);

        foreach ($map as $name => $value) {
            $res[strtolower($value)] = $item->get($name);
        }


        if(!empty($res['images']['image'])) {
            $res['images']['image'] = $this->processImages($res['images']['image']);
        }

        return $res;
    }

    public function processImages($images,$host=null)
    {
        $scheme="http";
        if(empty($host)) {
            $host = $this->container->get('numa.dms.user')->getCurrentSiteHost();

            $scheme = $this->container->get('numa.dms.user')->getScheme();

        }
        $tempImages = array();
        if (!empty($images)) {
            foreach ($images as $image) {
                if (substr($image, 0, 4) !== "http") {

                    $image = $scheme . "://" . $host . $image;
                }
                $tempImages[] = $image;
            }
        }
        return $tempImages;
    }

    public function prepareArrayItems($items)
    {
        $res = array();
        foreach ($items as $item) {
            $res['listing'][] = $this->prepareItem($item);
        }
        return $res;
    }

    public function prepareListingByDealer($dealer_group_id, $category)
    {
        $res = array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerAndCategory($dealer_group_id, $category);

        foreach ($items as $item) {

            $res['listing'][] = $this->prepareItem($item);
        }
        return $res;
    }

    public function prepareListingByDealerGroup($dealer_group_id, $category)
    {
        $res = array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerGroupAndCategory($dealer_group_id, $category);

        foreach ($items as $item) {

            $res['listings'][] = $this->prepareItem($item);
        }
        return $res['listings'];
    }

    public function prepareListingByDealerUsername($dealerid, $category)
    {
        $res = array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerUsernameAndCategory($dealerid, $category);

        foreach ($items as $item) {

            $res['listing'][] = $this->prepareItem($item);
        }
        return $res;
    }

    public function prepareAll($category)
    {
        $res = array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByCat($category);
        foreach ($items as $item) {
            $res['listing'][] = $this->prepareItem($item);
        }
        return $res;
    }

    public function formatResponse($items, $format)
    {
        if ($format == 'xml') {
            $xml = $this->container->get('xml')->createXML('listing', $items);
            $response = new Response($xml->saveXML());
        } elseif ($format == 'json') {
            $response = new Response(json_encode($items));
        } elseif ($format == 'csv') {

            $headers = array();
            $values = array();
            if (array_key_exists('id', $items)) {
                foreach ($items as $key => $value) {
                    $headers[] = $key;
                    $values[] = $value;
                }
                $headerCsv = implode(',', $headers);
                $valuesCsv = implode(',', $values);
                $csv = $headerCsv . "\n" . $valuesCsv;
                $response = new Response($csv);
                $response->setStatusCode(200);
                $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
                return $response;
            } elseif (array_key_exists('listing', $items)) {

                $headers = array();
                foreach ($items['listing'] as $itemkey => $item) {

                    foreach ($item as $key => $value) {
                        //if the value is array implode it to value|value2|value3...

                        if (is_array($value) && !empty($value)) {
                            if(key_exists('image',$value) ){

                                $value = $value['image'];
                            }elseif(key_exists('option',$value)){
                                $value = $value['option'];
                            }
                            $value = implode("|", $value);
                        }
                        $headers[$key] = $key;
                        $values[$itemkey][$key] = self::clearValueForCsv($value);
                    }

                }

                $csv = array();
                $headerCsv = implode(',', $headers);
                $valuesCsv = "";


                foreach ($values as $itemkey => $item) {

                    foreach ($headers as $key => $value) {

                        $csv[$itemkey][$key] = "";
                        if (!empty($values[$itemkey][$key])) {
                            $csv[$itemkey][$key] = $values[$itemkey][$key];
                        }
                    }
                    $value = $csv[$itemkey];

                    $valuesCsv .= implode(',', $value) . "\n";
                }


            }

            //$fp = fopen('file.csv', 'w');

            $res = $headerCsv . "\n" . $valuesCsv;

            $response = new Response($res);
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment;filename=feed.csv');
        }
        return $response;
    }

    public static function clearValueForCsv($value)
    {
        if (is_numeric($value)) {
        } elseif (is_string($value)) {
            $value = str_replace('"', " inches ", $value);
            $value = "\"" . $value . "\"";
        }
        if (is_string($value)) {
            $value = preg_replace("/<.*?>/", "", $value);
        }

        return str_replace("\n", "-", $value);
    }

    public function prepareKijijiFromIds($ids)
    {
        $em = $this->container->get('doctrine');

        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        $csvArrayRes = $this->addItemsKijijiFeed($items);

        $dealer = $this->container->get('numa.dms.user')->getSignedDealer();
        $localfile = $this->storeKijijiToLocalServer($items,$dealer->getId());

        $this->storeFeedToKijijiServer($items,$dealer,$localfile);

    }

    /**
     * @param $dealer_id
     * @return file path of the created kijiji feed
     */
    public function makeKijijiFromDealerId($dealer_id)
    {
        $logger = $this->container->get('logger');
        $em = $this->container->get('doctrine');
        $filenameKijiji = "";
        $logger->warning("get items for dealer:" . $dealer_id);
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerAndCategory($dealer_id, 1, 0);

        if (!empty($items)) {
            $csvArrayRes = $this->addItemsKijijiFeed($items);
            $logger->warning("prepare kijiji feed:" . $dealer_id);
            $ret = $this->formatResponse($csvArrayRes, 'csv');
            $dir = $this->container->getParameter('upload_dealer') . "/" . $dealer_id;
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $filenameKijiji = $dir . "/" . "kijiji.csv";
            $logger->warning("store kijiji feed on:" . $filenameKijiji);
            file_put_contents($filenameKijiji, $ret->getContent(), LOCK_EX);
            chmod($filenameKijiji, 0755);   //
        }

        $logger->warning("makeKijijiFromDealerId end:" . $filenameKijiji);
        return $filenameKijiji;
    }

    public function storeKijijiToLocalServer($items,$dealer_id){
        $logger = $this->container->get('logger');
        $em = $this->container->get('doctrine');
        $dealer = $em->getRepository(Catalogrecords::class)->find($dealer_id);
        $filenameKijiji = "";

        if (!empty($items) && $dealer instanceof Catalogrecords) {
            $csvArrayRes = $this->addItemsKijijiFeed($items);
            $logger->warning("prepare kijiji feed:" . $dealer_id);
            $ret = $this->formatResponse($csvArrayRes, 'csv');
            $dir = $this->container->getParameter('upload_dealer') . "/" . $dealer_id;
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $filenameKijiji = $dir . "/" . "kijiji.csv";
            $logger->warning("store kijiji feed on:" . $filenameKijiji);
            file_put_contents($filenameKijiji, $ret->getContent(), LOCK_EX);
            chmod($filenameKijiji, 0755);   //
        }
        return $filenameKijiji;
    }

    public function storeFeedToKijijiServer($items,$dealer,$localfile){
        // set up basic connection

        $ftp_server = $dealer->getFeedKijijiUrl();
        $ftp_user_name = $dealer->getFeedKijijiUsername();
        $ftp_user_pass = $dealer->getFeedKijijiPassword();
        if(!empty($ftp_server)) {

            //$feedsKijiji = $this->storeKijijiToLocalServer($items, $dealer->getId());
            $conn_id = ftp_connect($ftp_server);
            // login with username and password
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

            // upload a file
            if (!ftp_put($conn_id, "kijiji.csv", $localfile, FTP_ASCII)) {
                return "errror";
            }

            // close the connection/
            ftp_close($conn_id);
        }
        return true;
    }

    public function addItemsKijijiFeed($items)
    {
        $csvArrayRes = array();

        foreach ($items as $item) {
            $csvArrayRes['listing'][] = $this->addItemToKijijiFeed($item);
        }
        return $csvArrayRes;
    }

    public function addItemToKijijiFeed($item)
    {
        $csvArray = array();
        if ($item instanceof Item && $item->getDealer() instanceof Catalogrecords) {
            $dealer = $item->getDealer();

            $csvArray['dealer_id'] = $dealer->getId();
            $csvArray['dealer_name'] = $dealer->getName();
            $csvArray['address'] = $dealer->getAddress();
            $csvArray['phone'] = $dealer->getPhone();
            $csvArray['postalcode'] = "";
            $csvArray['email'] = $dealer->getEmail();
            $csvArray['vehicle_id'] = $item->getId();
            $csvArray['vin'] = $item->getVIN();
            $csvArray['stockid'] = $item->getStockNr();
            $csvArray['is_used'] = $item->isUsed();
            $csvArray['is_certified'] = 0;
            $csvArray['year'] = $item->getYear();
            $csvArray['make'] = $item->getMake();
            $csvArray['model'] = $item->getModel();
            $csvArray['body'] = $item->getBodyStyle();
            $csvArray['trim'] = $item->getTrim();
            $csvArray['transmission'] = $item->getTransmission();
            $csvArray['kilometers'] = $item->getMileage();
            $csvArray['exterior_color'] = $item->getExteriorColor();
            $csvArray['price'] = $item->getPrice();
            $csvArray['model_code'] = "";
            $csvArray['comments'] = $item->getCurrentSellerComment();
            if (empty(trim(strip_tags($item->getCurrentSellerComment())))) {
                $csvArray['comments'] = trim(strip_tags($dealer->getDefaultListingComment()));
            }


            $csvArray['drivetrain'] = $item->getDriveType();
            $csvArray['videourl'] = $item->getVideoId();
            $imageList = array();
            $images = $item->get("ImagesForApi");
            if (!empty($images['image'])) {
                $images = $this->processImages($images['image'],$dealer->getSiteUrl());
            }

            $csvArray['images'] = $images;
            $csvArray['category'] = 0;

        }
        return $csvArray;
    }
}
