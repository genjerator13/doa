<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class itemController extends Controller {

    public function detailsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $itemId = $request->get('itemId');
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemId);
        //$test = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTree();
        //\Doctrine\Common\Util\Debug::dump($test);die();
        if (empty($item)) {
            throw $this->createNotFoundException('message');
        }
        //$itemfields = $item->getItemFieldsArray();
        //get dealer
        $dealerid = $item->getItemFieldByName('dealer');

        $dealer = $em->getRepository('NumaDOAAdminBundle:CatalogRecords')->find($dealerid);
        switch ($item->getCategoryId()) {
            case 1:
                //car
                return $this->render('NumaDOASiteBundle:Item:detailsCar.html.twig', array('item' => $item, 'dealer' => $dealer));
                break;
            case 2:
                //marine
                return $this->render('NumaDOASiteBundle:Item:detailsBoat.html.twig', array('item' => $item, 'dealer' => $dealer));
                break;
            case 3:
                //motorsport
                return $this->render('NumaDOASiteBundle:Item:detailsBoat.html.twig', array('item' => $item, 'dealer' => $dealer));
                break;
            case 4:
                //rvs
                return $this->render('NumaDOASiteBundle:Item:detailsRVs.html.twig', array('item' => $item));
                break;
            default:
                break;
        }
    }

    public function saveadAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $itemid = intval($request->get('itemid'));
        $act = $request->get('act');
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemid);
        $ret = array();
        if ($item instanceof \Numa\DOAAdminBundle\Entity\Item) {

            $userItem = $em->getRepository('NumaDOAAdminBundle:UserItem')
                    ->findOneBy(array('User' => $user,
                'item_type' => \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD));
            $userItems = $em->getRepository('NumaDOAAdminBundle:UserItem')
                    ->findBy(array('User' => $user,
                'item_type' => \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD));
            $userItemsCount = count($userItems);
            if ($act == 'add') {
                $userItemExists = $em->getRepository('NumaDOAAdminBundle:UserItem')
                    ->findOneBy(array('User' => $user,
                                      'Item' => $item,
                'item_type' => \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD));
                if(empty($userItemExists)){
                    $userItem = new \Numa\DOAAdminBundle\Entity\UserItem();
                    $userItem->setUser($user);
                    $userItem->setItem($item);
                    $userItem->setItemType(\Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD);
                    $em->persist($userItem);
                    $userItemsCount++;
                }
            } elseif ($act == 'remove') {
                $userItemsCount--;
                $em->remove($userItem);
            }

            $em->flush();
            $savedAds = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemid);
            $ret = array('savedAds' => $userItemsCount);
        }
        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
