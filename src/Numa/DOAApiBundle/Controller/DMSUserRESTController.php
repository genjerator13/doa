<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

class DMSUserRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $users = $this->getDoctrine()->getRepository('NumaDOADMSBundle:DMSUser')->findAll();
        //dump($users);die();
        return $users;
    }

    /**
     * @Rest\View
     */
    public function allDmsAction()
    {
        $users = $this->getDoctrine()->getRepository('NumaDOADMSBundle:DMSUser')->findBy(array('user_group_id'=>array(1,3,4)));
        return $users;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction()
    {
        $user = $this->get("Numa.Dms.User")->getSignedDealer();
        $users = $this->getDoctrine()->getRepository('NumaDOADMSBundle:DMSUser')->findBy(array('Dealer'=>$user));
        return $users;
    }

    /**
     * @Rest\View
     */
    public function byDealerPrincipalAction($dealer_group_id)
    {

        $customer = $this->getDoctrine()->getRepository('NumaDOADMSBundle:DMSUser')->findByDealerGroupId($dealer_group_id);
        //dump($customer);die();
        if (!$customer) {
            //throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        return $customer;
    }
}