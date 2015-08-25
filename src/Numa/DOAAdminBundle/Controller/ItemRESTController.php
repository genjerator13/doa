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
    /**
     * @return Item
     * @View
     */
    public function getListingAction($id){
        $item = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:Item')->find($id);

        return $item;
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