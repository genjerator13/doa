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
        $tempImages = array();
        if (!empty($res['images']['image'])) {
            foreach ($res['images']['image'] as $image) {
                if (substr($image, 0, 4) !== "http") {
                    $image = $host . $image;
                }
                $tempImages[] = $image;
            }
            $res['images']['image'] = $tempImages;
        }

        return $res;
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

                            $value = implode("|", reset($value));
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
            //dump($item);
        } elseif (is_string($value)) {
            $value = str_replace('"', " inches ", $value);
            $value = "\"" . $value . "\"";
        }
        if (is_string($value)) {
            //$value = strip_tags('<li>', $value);

            $value = preg_replace("/<.*?>/", "", $value);
            //dump($value);
        }

        return str_replace("\n", "-", $value);
    }
}
