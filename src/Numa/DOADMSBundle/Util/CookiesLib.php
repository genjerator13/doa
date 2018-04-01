<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Imagine\Image\Box;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CookiesLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function setCookie($request,Item $item,&$response){
        $allCookies = $request->cookies->all();
        $cookies=array();
        if(!empty($allCookies['notebook'])){
            $cookies = unserialize($allCookies['notebook']);
        }

        $temp=array();
        $temp['price']=$item->getPriceString();
        $temp['year']=$item->getYear();
        $temp['make']=$item->getMake();
        $temp['model']=$item->getModel();
        $temp['trim']=$item->getTrim();
        $temp['url']=$this->container->get("numa.dms.listing")->generateUrl($item);
        $temp['image']=$item->getCoverImageSrc();


        $cookies[$item->getId()]=$temp;

        $response->headers->setCookie(new Cookie('notebook', serialize($cookies), time() + (3600 * 48)));

    }

    public function getCookies($request)
    {

        $allCookies = $request->cookies->all();
        $cookies = unserialize($allCookies['notebook']);
        return $cookies;
    }

    public function countCookie($request)
    {

        $allCookies = $request->cookies->all();

        $notebook=array();
        if(!empty($allCookies['notebook'])) {
            $notebook = unserialize($allCookies['notebook']);
        }
        $count = count($notebook);
        return $count;
    }
}