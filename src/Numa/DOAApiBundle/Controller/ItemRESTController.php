<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;


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

    const cacheMaxAge = 86400;
    public function getListingsAction(){
        $items = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getItemByCat(3);
        return $items;
    }

    public function listingAction(Request $request,$id){
        //check if column separated ids
        //listings can be fetched by separating ids by : /api/listing/1536:1539
        $columnSeparatedIds = explode(":",$id);

        if(count($columnSeparatedIds)>0){
            $id = array();
            foreach($columnSeparatedIds as $cid){
                $cid=intval($cid);
                $id[]=$cid;
            }
        }


        $items = $this->get('listing_api')->prepareListing($id);


        if($items instanceof Item){
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');



        return $this->get('listing_api')->formatResponse($items,$format);
    }

    public function listingsByDealerAction(Request $request,$dealerid){

        $category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareListingByDealer($dealerid,$category);

        if(!$items){
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        return $this->get('listing_api')->formatResponse($items,$format);
    }

    public function listingsAllAction(Request $request,$category){
        //$category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareAll($category);
        if(!$items){
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        return $this->get('listing_api')->formatResponse($items,$format);
    }
}