<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAAdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;

class ItemRESTController extends Controller
{
    /**
     * @return array
     * @View
     */
    public function getListingsAction(){
        $items = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getItemByCat(3);
        //dump($items);die();
        return $items;
    }

    public function listingAction($id){
        $item = $this->get('listing_api')->prepareListing($id);
        //dump($item);die();
        $xml   = $this->get('xml')->createXML('listing',$item);
        //dump($xml->saveXML());die();
        $response = new Response($xml->saveXML());
        return $response;
    }

    public function listingsByDealerAction($dealerid){
        $items = $this->get('listing_api')->prepareListingByDealer($dealerid);
        //dump($items);die();
        $xml   = $this->get('xml')->createXML('listings',$items);
        //dump($xml->saveXML());die();
        $response = new Response($xml->saveXML());
        return $response;
    }

    /**
     * @return Array
     * @View
     */
    public function getListingDealerAction($id){
        $items = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getItemByDealer($id);
        //dump($items);die();
        return $items;
    }

}