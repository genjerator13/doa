<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAAdminBundle\Controller;


use Numa\DOAAdminBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemRESTController extends Controller
{
    /**
     * @return array
     * @View
     */
    public function getListingsAction(){
        $items = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getItemByCat(3);

        return $items;
    }

    public function listingAction(Request $request,$id){
        $item = $this->get('listing_api')->prepareListing($id);


        if($item instanceof Item){
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        if($format=='xml') {
            $xml = $this->get('xml')->createXML('listing', $item);
            $response = new Response($xml->saveXML());
        }elseif($format=='json'){
            $response = new Response(json_encode($item));
        }
        return $response;
    }

    public function listingsByDealerAction(Request $request,$dealerid){
        $category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareListingByDealer($dealerid,$category);
        if(!$items){
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        if($format=='xml') {
            $xml = $this->get('xml')->createXML('listings', $items);
            $response = new Response($xml->saveXML());
        }elseif($format=='json'){
            $response = new Response(json_encode($items));
        }
        return $response;
    }

    public function listingsAllAction(Request $request,$category){
        //$category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareAll($category);
        if(!$items){
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        if($format=='xml') {
            $xml = $this->get('xml')->createXML('listings', $items);
            $response = new Response($xml->saveXML());
        }elseif($format=='json'){
            $response = new Response(json_encode($items));
        }
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