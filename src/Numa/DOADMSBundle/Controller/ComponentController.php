<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOADMSBundle\Form\DealerComponentType;

/**
 * DealerComponent controller.
 *
 */
class ComponentController extends Controller
{

    /**
     * Lists all DealerComponent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('Numa.Dms.User')->getSignedDealer();
        return $this->render('NumaDOADMSBundle:DealerComponent:index.html.twig',array("dealer"=>$dealer));
    }

}
