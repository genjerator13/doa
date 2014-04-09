<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class itemController extends Controller {

    public function detailsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $itemId = $request->get('itemId');
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemId);
        //$test = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTree();
        //\Doctrine\Common\Util\Debug::dump($test);die();
        if(empty($item)){
             throw $this->createNotFoundException('message');
        }
        $itemfields = $item->getItemFieldsArray();
        switch ($item->getCategoryId()) {
            case 1:
                //car
                return $this->render('NumaDOASiteBundle:Item:detailsCar.html.twig', array('item' => $item, 'itemfields' => $itemfields));
                break;
            case 2:
                //marine
                return $this->render('NumaDOASiteBundle:Item:detailsBoat.html.twig', array('item' => $item, 'itemfields' => $itemfields));
                break;
            case 3:
                //motorsport
                return $this->render('NumaDOASiteBundle:Item:detailsMotorsport.html.twig', array('item' => $item, 'itemfields' => $itemfields));
                break;
            case 4:
                //rvs
                return $this->render('NumaDOASiteBundle:Item:detailsRVs.html.twig', array('item' => $item, 'itemfields' => $itemfields));
                break;
            default:
                break;
        }
    }

}
