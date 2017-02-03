<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;


use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ItemRESTController extends Controller
{
    const cacheMaxAge = 86400;

    public function getListingsAction()
    {
        $items = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getItemByCat(3);
        return $items;
    }

    public function listingAction(Request $request, $id)
    {
        //check if column separated ids
        //listings can be fetched by separating ids by : /api/listing/1536:1539
        $columnSeparatedIds = explode(":", $id);

        if (count($columnSeparatedIds) > 0) {
            $id = array();
            foreach ($columnSeparatedIds as $cid) {
                $cid = intval($cid);
                $id[] = $cid;
            }
        }


        $items = $this->get('listing_api')->prepareListing($id);


        if ($items instanceof Item) {
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');


        return $this->get('listing_api')->formatResponse($items, $format);
    }

    public function listingsByDealerAction(Request $request, $dealerid)
    {

        $category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareListingByDealer($dealerid, $category);

        if (!$items) {
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        return $this->get('listing_api')->formatResponse($items, $format);
    }

    public function listingsByDealerGroupAction(Request $request, $dealer_group_id)
    {

        $category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareListingByDealerGroup($dealer_group_id, $category);

        if (!$items) {
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        return $this->get('listing_api')->formatResponse($items, $format);
    }

    public function listingsByDealerUsernameAction(Request $request, $dealerid)
    {

        $category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareListingByDealerUsername($dealerid, $category);

        if (!$items) {
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        return $this->get('listing_api')->formatResponse($items, $format);
    }

    public function listingsAllAction(Request $request, $category)
    {
        //$category = $request->query->get('category');

        $items = $this->get('listing_api')->prepareAll($category);
        if (!$items) {
            throw $this->createNotFoundException('The product does not exist');
        }
        $format = $request->attributes->get('_format');
        return $this->get('listing_api')->formatResponse($items, $format);
    }


    public function listingsByDealer2Action(Request $request, $dealerid)
    {

        $listings = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getAllListings($dealerid);

        $func = function($value) {

           $value['categorySubType']="aaa";
            $cat = $value['category_id'];
            if (!empty($cat)) {
                if ($cat == 1) {
                    $value['categorySubType']=$value["body_style"];
                } elseif ($cat == 2) {
                    $value['categorySubType']= $value["type"];
                } elseif ($cat == 3) {
                    $value['categorySubType']= $value["type"];
                } elseif ($cat == 4) {
                    $value['categorySubType']= $value["type"];
                } elseif ($cat == 13) {
                    $value['categorySubType']= $value["ag_application"];
                }
            }

            return $value;

        };
        //dump($listings);die();
        $listings = array_map($func, $listings);
        return $listings;
    }

    public function listingsByDealerGroup2Action(Request $request, $dealer_group_id)
    {
        $em = $this->getDoctrine()->getManager();
        $dealers = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->findBy(array('dealer_group_id'=>$dealer_group_id));
        $dealersIds=array();
        foreach($dealers as $dealer){
            $dealersIds[]=$dealer->getId();
        }
        return $this->listingsByDealer2Action($request,$dealersIds);
    }

    /**
     * @Rest\View
     */
    public function allListingsAction()
    {
        $listings = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getAllListings();
        return $listings;
    }

    /**
     * @Rest\View
     */
    public function listing2Action($id)
    {

        $customers = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->find($id);
        return $customers;
    }


    public function listingByUniquesAction(Request $request, $id)
    {
        $field = $request->get('field');
        $dealer_id = $this->get("numa.dms.user")->getAvailableDealersIds();
        $items = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->findItemsByUnique($id, $field,$dealer_id);

        return $items;
    }

    public function addFeatureAction(Request $request)
    {
        $post = $request->getContent();
        $post = json_decode($post);
        $item_id = $post->item_id;
        $feature_name = $post->name;
        $em = $this->getDoctrine()->getManager();
        //check if already inserted
        $exists = $em->getRepository('NumaDOAAdminBundle:Item')->isItemFieldExists($item_id, $feature_name);
        $response = new JsonResponse(
            array(
                'message' => 'Success',
                'action' => '',
                400));
        if (empty($exists)) {

            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($item_id);


            $itemfield = new ItemField();
            $itemfield->setItem($item);
            $itemfield->setFieldName($feature_name);
            $itemfield->setFieldType('boolean');
            $itemfield->setFieldStringValue($feature_name);
            $itemfield->setFieldBooleanValue(true);
            $em->persist($itemfield);
            $item->addItemField($itemfield);
            $em->flush();
            $response = new JsonResponse(
                array(
                    'message' => 'Success',
                    'action' => 'refresh',
                    400));
        }
        return $response;
    }
}