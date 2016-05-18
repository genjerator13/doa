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

    /**
     * @Rest\View
     */
    public function listingsByDealer2Action(Request $request, $dealerid)
    {
        $customers = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->getItemByDealerAndCategory($dealerid);
        return $customers;
    }

    /**
     * @Rest\View
     */
    public function allListingsAction()
    {
        $customers = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->findAll();
        return $customers;
    }

    /**
     * @Rest\View
     */
    public function listing2Action($id)
    {

        $customers = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->find($id);
        return $customers;
    }

    /**
     * @Rest\View
     */
    public function listingByUniquesAction(Request $request, $id)
    {
        $field = $request->get('field');
        $customers = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->findItemsBy($id, $field);
        return $customers;
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