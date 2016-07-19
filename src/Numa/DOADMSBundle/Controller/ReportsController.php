<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Form\BillingType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Billing controller.
 *
 */
class ReportsController extends Controller
{

    /**
     * Lists all Billing entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findAll();
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function byDateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $date = '2016-06-19';
        $date1 = '2016-08-19';
        $entities = $em->getRepository('NumaDOADMSBundle:Billing')->findByDate($date, $date1);
        return $this->render('NumaDOADMSBundle:Reports:index.html.twig', array(
            'entities' => $entities,
        ));
    }
}