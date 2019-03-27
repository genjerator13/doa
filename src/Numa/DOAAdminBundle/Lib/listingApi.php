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

use Doctrine\Common\Collections\ArrayCollection;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Sale;
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


        if (!empty($res['images']['image'])) {
            $res['images']['image'] = $this->processImages($res['images']['image']);
        }

        return $res;
    }

    public function processImages($images, $host = null)
    {
        $scheme = "http";
        if (empty($host)) {

            $scheme = $this->container->get('numa.dms.user')->getScheme();
        }
        $host = $this->container->get('numa.dms.user')->getCurrentSiteHostWWW($host);
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
        $headerCsv="";
        $valuesCsv="";
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
                        if ($value instanceof \DateTime) {
                            $value = $value->format("Y-m-d");
                        }

                        //if the value is array implode it to value|value2|value3...

                        if (is_array($value) && !empty($value)) {
                            if (key_exists('image', $value)) {

                                $value = $value['image'];
                            } elseif (key_exists('option', $value)) {
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
            $res = $headerCsv . "\n" . $valuesCsv;

            $response = new Response($res);
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment;filename=feed.csv');
        }
        return $response;
    }

    public function formatSiriusXMResponse($items, $includes, $format)
    {

        $headers = array();
        $values = array();
        //dump($items);
        //dump($itemkey);
        //die();

        $headers = array();

        foreach ($items as $itemKey => $item) {
            if ($item instanceof Billing) {
                $billing = $item;
                $item = $billing->getItem();
            }
            foreach ($includes as $key => $field) {
                $split = explode(":", $key);
                if ($split[0] == 'customer') {
                    $customer = $billing->getCustomer();
                    $cmethodName = "get" . ucfirst($split[1]);
                    if (method_exists($customer, $cmethodName)) {
                        $value = $customer->{$cmethodName}();

                        if ($value instanceof \DateTime) {
                            $value = $value->format("Y-m-d");
                        }

                        $headers[$field] = $field;
                        $values[$itemKey][$field] = self::clearValueForCsv($value);
                    }
                } else {
                    $methodName = "get" . ucfirst($key);

                    if (method_exists($item, $methodName)) {
                        $value = $item->{$methodName}();

                        if ($value instanceof \DateTime) {
                            $value = $value->format("Y-m-d");
                        }

                        $headers[$field] = $field;
                        $values[$itemKey][$field] = self::clearValueForCsv($value);
                    }
                }
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

        $res = $headerCsv . "\n" . $valuesCsv;

        $response = new Response($res);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=feed.csv');

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

    public function prepareRfeedFromIds($ids, $rfeedName = 'kijiji')
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $items = $em->getRepository("NumaDOAAdminBundle:Item")->findByIds($ids);
        $csvArrayRes = $this->addItemsToRfeed($items, $rfeedName);

        $dealer = $this->container->get('numa.dms.user')->getSignedDealer();
        $localfile = $this->storeRfeedToLocalServer($items, $dealer->getId(), $rfeedName);
        $dealer->setRfeedManual(1, $rfeedName);
        $em->flush();
//        $this->storeFeedToKijijiServer($items,$dealer,$localfile);

    }

    /**
     * @param $dealer_id
     * @return file path of the created kijiji feed
     */
    public function makeRfeedFromDealerId($dealer_id, $rfeedName = 'kijiji')
    {

        $logger = $this->container->get('logger');
        $em = $this->container->get('doctrine');
        $filename = "";
        $logger->warning("get items for dealer:" . $dealer_id);
        $items = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerAndCategory($dealer_id, array(1, 4), 0);
        $collection = $items;
        if($dealer_id==54){
            $items2 = $em->getRepository("NumaDOAAdminBundle:Item")->getItemByDealerAndCategory(55, array(1, 4), 0);
            $collection =  array_merge($items, $items2);
        }

        $dealer = $em->getRepository(Catalogrecords::class)->find($dealer_id);
        if ($dealer->getRfeedManual($rfeedName)) {
            $items = $em->getRepository("NumaDOAAdminBundle:Item")->getManualRfeedItems($dealer_id, $rfeedName);
        }

        if (!empty($items)) {

            $csvArrayRes = $this->addItemsToRfeed($items, $rfeedName);
            $logger->warning("prepare " . $rfeedName . " feed:" . $dealer_id);
            $ret = $this->formatResponse($csvArrayRes, 'csv');
            $dir = $this->container->getParameter('upload_dealer') . "/" . $dealer_id;
            dump($dir);
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $filename = $dir . "/" . $rfeedName . ".csv";

            if ($rfeedName == 'autotrader') {
                $filename = $dir . "/".$dealer->getRfeedUsername('autotrader').".csv";
            }
            if ($rfeedName == 'cargurus') {
                $filename = $dir . "/".$rfeedName."_".$dealer->getFeedCargurusId() . ".csv";
            }


            if ($rfeedName == 'siriusxm') {
                $filename = $dir . "/" . $dealer_id . "_siriusxm_sales.csv";
                $billing = $em->getRepository(Billing::class)->findSoldByDate(null, null, $dealer_id);
                $csvArrayRes2 = $this->addItemsToRfeed($billing, $rfeedName);
                //dump($csvArrayRes2);
                $ret2 = $this->formatResponse($csvArrayRes2, 'csv');
                $filename2 = $dir . "/" . $dealer_id . "_siriusxm_inventory.csv";
                file_put_contents($filename2, $ret2->getContent(), LOCK_EX);
                chmod($filename2, 0755);   //
                $logger->warning("store " . $rfeedName . " feed on:" . $filename);
                file_put_contents($filename, $ret->getContent(), LOCK_EX);
                dump($filename);
                chmod($filename, 0755);   //

                return array($filename, $filename2);
            }

            $logger->warning("store " . $rfeedName . " feed on:" . $filename);
            file_put_contents($filename, $ret->getContent(), LOCK_EX);
            dump($filename);
            chmod($filename, 0755);   //
        }

        $logger->warning($rfeedName . ": makeRfeedFromDealerId end:" . $filename);
        return $filename;
    }

    public function storeRfeedToLocalServer($items, $dealer_id, $rfeedName = 'kijiji')
    {
        $logger = $this->container->get('logger');
        $em = $this->container->get('doctrine');
        $dealer = $em->getRepository(Catalogrecords::class)->find($dealer_id);
        $filename = "";

        if (!empty($items) && $dealer instanceof Catalogrecords) {
            $csvArrayRes = $this->addItemsKijijiFeed($items);
            $logger->warning("prepare " . $rfeedName . " feed:" . $dealer_id);
            $ret = $this->formatResponse($csvArrayRes, 'csv');
            $dir = $this->container->getParameter('upload_dealer') . "/" . $dealer_id;
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $filename = $dir . "/" . $rfeedName . ".csv";
            $logger->warning("store " . $rfeedName . " feed on:" . $filename);
            file_put_contents($filename, $ret->getContent(), LOCK_EX);
            chmod($filename, 0755);   //
        }
        return $filename;
    }

    public function storeFeedToKijijiServer($items, $dealer, $localfile)
    {
        // set up basic connection

        $ftp_server = $dealer->getFeedKijijiUrl();
        $ftp_user_name = $dealer->getFeedKijijiUsername();
        $ftp_user_pass = $dealer->getFeedKijijiPassword();
        if (!empty($ftp_server)) {

            //$feedsKijiji = $this->storeKijijiToLocalServer($items, $dealer->getId());
            $conn_id = ftp_connect($ftp_server);
            // login with username and password
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

            // upload a file
            ftp_pasv($conn_id, true);
            if (!ftp_put($conn_id, "kijiji.csv", $localfile, FTP_ASCII)) {
                return "errror";
            }

            // close the connection/
            ftp_close($conn_id);
        }
        return true;
    }

    public function addItemsToRfeed($items, $rfeedName = 'kijiji')
    {
        $logger = $this->container->get('logger');
        $csvArrayRes = array();

        foreach ($items as $item) {
            $logger->warning("addItemsToRfeed " . $rfeedName . " feed:" . $item->getId());
            $csvArrayRes['listing'][] = $this->addItemToRfeed($item, $rfeedName);
        }

        $logger->warning("addItemsToRfeed end " . $rfeedName . " feed:");
        return $csvArrayRes;
    }

    public function addItemToRfeed($item, $rfeedName = 'kijiji')
    {
        $logger = $this->container->get('logger');
        $csvArray = array();
        $firstImage = true;
        $category="";
        if($item instanceof Item) {
            $subcategory = $item->getSubCategoryType();
            $subcategory = str_ireplace("van", "", $subcategory);
            $subcategory = str_ireplace("deck", "", $subcategory);
            $subcategory = strtolower(trim($subcategory));

            if ($subcategory == "cargo" || $subcategory == 'cube' || $subcategory == "cargo") {
                $category = 8218;
            }
            if ($subcategory == "pickup") {
                $category = 8160;
            }
            if ($subcategory == "flat") {
                $category = 8213;
            }
        }
        if ($rfeedName == 'siriusxm' && $item instanceof Item && $item->getDealer() instanceof Catalogrecords) {

            $dealer = $item->getDealer();

            $csvArray['Stock Number'] = $item->getStockNr();
            $csvArray['Stock Date'] = $item->getDateCreated();
            $csvArray['VIN'] = $item->getVIN();
            $csvArray['Make'] = $item->getMake();
            $csvArray['Model'] = $item->getModel();
            $csvArray['Model Year'] = $item->getYear();
        } elseif ($rfeedName == 'siriusxm' && $item instanceof Billing && $item->getDealer() instanceof Catalogrecords) {
            $dealer = $item->getDealer();

            $csvArray['Stock Number'] = $item->getItem()->getStockNr();
            $csvArray['Stock Date'] = $item->getItem()->getSoldDate();
            $csvArray['VIN'] = $item->getItem()->getVIN();
            $csvArray['Make'] = $item->getItem()->getMake();
            $csvArray['Model'] = $item->getItem()->getModel();
            $csvArray['Model Year'] = $item->getItem()->getYear();
            $csvArray['First Name'] = $item->getCustomer()->getFirstName();
            $csvArray['Last Name'] = $item->getCustomer()->getLastName();
            $csvArray['Address'] = $item->getCustomer()->getAddress();
            $csvArray['City'] = $item->getCustomer()->getCity();
            $csvArray['State'] = $item->getCustomer()->getState();
            $csvArray['Country'] = $item->getCustomer()->getCountry();
            $csvArray['Zip'] = $item->getCustomer()->getZip();
            $csvArray['Phone'] = $item->getCustomer()->getPhone();
            $csvArray['Email'] = $item->getCustomer()->getEmail();
        } else {
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
                $csvArray['is_used'] = $item->isUsedString();
                $csvArray['is_certified'] = 0;
                $csvArray['year'] = $item->getYear();
                $csvArray['make'] = $item->getMake();
                $csvArray['model'] = $item->getModel();
                $csvArray['engine'] = $item->getEngine();
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

                //$images = $item->get("ImagesForApi");
                $images = $this->container->get("numa.dms.listing")->getImagesForApi($item);
                if (!empty($images['image'])) {
                    $images = $this->processImages($images['image'], $dealer->getSiteUrl());
                }
                $csvArray['images'] = $images;
                $csvArray['category'] = 0;
                if ($item->getCategory()->getId() == 4) {
                    if (stripos($item->getType(), "motorhome") !== false) {
                        $csvArray['category'] = 333;
                        dump("333");
                    } else {
                        $csvArray['category'] = 334;
                        dump("334");
                    }
                }

                $csvArray['MSRP'] = $item->getRetailPriceString();

            }
            if ($rfeedName == 'autotrader' || $rfeedName == 'cargurus') {
                $csvArray['comments'] = strip_tags(str_replace(chr(194), " ", $item->getCurrentSellerComment()), '<br>');
                $csvArray['is_used'] = $item->isUsedString();
                $csvArray['photo'] = "";
                $csvArray['photo_last_modified'] = "";
                $csvArray['additional_photos'] = "";
                $csvArray['additional_photo_last_modified'] = "";

                $csvArray['last_modified_date'] = "";
                if ($item->getDateUpdated() instanceof \DateTime) {
                    $csvArray['last_modified_date'] = $item->getDateUpdated();
                }


                if (!empty($images)) {
                    $csvArray['photo'] = $images[0];
                    $csvArray['photo_last_modified'] = $item->getDateUpdated();
                    array_shift($images);
                    $csvArray['additional_photos'] = implode("|", $images);;
                    $dateUpdated = array();
                    foreach ($images as $image) {
                        $dateUpdated[] = $item->getDateUpdated()->format("Y-m-d");
                    }
                    $csvArray['additional_photo_last_modified'] = implode("|", $dateUpdated);;

                    unset($csvArray['images']);
                }
            }
            if ($rfeedName == 'autotrader') {
                $category = "";

                $type = $item->getType();
                if (stripos($type, '5th') !== false || stripos($type, 'Fifth') !== false) {

                    $category = 16;
                }
                if (stripos($type, 'Travel Trailer') !== false ) {
                    $category = 19;
                }
                if (stripos($type, 'A Motorhome') !== false ) {
                    $category = 13;
                }
                if (stripos($type, 'B Motorhome') !== false ) {
                    $category = 15;
                }
                if (stripos($type, 'C Motorhome') !== false ) {
                    $category = 14;
                }

                if (stripos($type, 'park model') !== false ) {
                    $category = 17;
                }
                if (stripos($type, 'tent') !== false ) {
                    $category = 18;
                }
                if (stripos($type, 'tent') !== false ) {
                    $category = 18;
                }
                if (stripos($type, 'truck') !== false ) {
                    $category = 20;
                }

                if (stripos($type, 'toy') !== false ) {
                    $category = 91;
                }
                if($subcategory=="cargo" || $subcategory=='cube' || $subcategory=="cargo"){
                    $category = 5;
                }
                if($subcategory=="pickup"){
                    $category = 5;
                }
                if($subcategory=="flat"){
                    $category = 5;
                }
                dump($category);
                dump($type);


//13 RV\Class A Motorhome///
//15 RV\Class B Motorhome (Camper Van)///
//14 RV\Class C Motorhome///
//16 RV\Fifth Wheel////
//17 RV\Park Model////
//18 RV\Tent Trailer////
//91 RV\Toy Hauler
//19 RV\Travel Trailer///
//20 RV\Truck Camper///

                $csvArray['category'] = $category;
                $csvArray['model_code'] = $category;
            }
            if ($rfeedName == 'cargurus') {
                $csvArray['city'] = $item->getDealer()->getCity();
                $csvArray['postalcode'] = $item->getDealer()->getZip();
                $options = $item->getOptionsForApi();
                $value = "";
                if (is_array($options) && !empty($options)) {

                    if (key_exists('option', $options)) {
                        $value = $options['option'];
                    }
                    $value = implode("|", $value);
                }

                $csvArray['options'] = self::clearValueForCsv($value);
            }

            if ($rfeedName == 'vauto') {
                $csvArray['comments'] = strip_tags(str_replace(chr(194), " ", $item->getCurrentSellerComment()), '<br>');
                $csvArray['is_used'] = $item->isUsedString();
                $csvArray['photo'] = "";
                $csvArray['photo_last_modified'] = "";
                $csvArray['additional_photos'] = "";
                $csvArray['additional_photo_last_modified'] = "";

                $csvArray['last_modified_date'] = "";
                if ($item->getDateUpdated() instanceof \DateTime) {
                    $csvArray['last_modified_date'] = $item->getDateUpdated();
                }

                if (!empty($images)) {
                    $csvArray['photo'] = $images[0];
                    $csvArray['photo_last_modified'] = $item->getDateUpdated();
                    array_shift($images);
                    $csvArray['additional_photos'] = implode("|", $images);;
                    $dateUpdated = array();
                    foreach ($images as $image) {
                        $dateUpdated[] = $item->getDateUpdated()->format("Y-m-d");
                    }
                    $csvArray['additional_photo_last_modified'] = implode("|", $dateUpdated);;

                    unset($csvArray['images']);
                }
                //dump($item->getSale()->getInvoiceAmt());
                $csvArray['invoice_amount'] = "";
                $csvArray['invoice_date'] = "";
                $csvArray['total_unit_cost'] = "";
                if ($item->getSale() instanceof Sale) {
                    $csvArray['invoice_amount'] = $item->getSale()->getInvoiceAmt();
                    $invoiceDate = $item->getSale()->getInvoiceDate();
                    if ($invoiceDate instanceof \DateTime) {
                        $csvArray['invoice_date'] = $invoiceDate->format("Y-m-d");
                    }
                    $csvArray['total_unit_cost'] = $item->getSale()->getTotalUnitCost();
                }

                unset($csvArray['images']);
            }

        }

        return $csvArray;
    }

    public function prepareSiriusInventory($dealer)
    {
        $res = array();
        $em = $this->container->get('doctrine');
        $items = $em->getRepository(Item::class)->getItemByDealerAndCategory($dealer);

        foreach ($items as $item) {

            $res['listing'][] = $this->prepareItem($item);
        }
        return $res;
    }
}
