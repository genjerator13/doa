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

class UserRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $users = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:User')->findAll();
        //dump($users);die();
        return $users;
    }

    /**
     * @Rest\View
     */
    public function allDmsAction()
    {
        $users = $this->getDoctrine()->getRepository('NumaDOAAdminBundle:User')->findBy(array('user_group_id'=>array(1,3,4)));
        return $users;
    }
}