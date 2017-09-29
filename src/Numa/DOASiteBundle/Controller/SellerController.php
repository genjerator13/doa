<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SellerController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;

    }

    public function searchAction(Request $request)
    {
        $form = $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            ->setAction($this->get('router')->generate('search_sellers'))
            ->setAttributes(array('role' => 'search', 'name' => 'search'))
            ->add('Name', 'text', array('label' => "Dealership Name", 'required' => false))
            ->add('City', 'text', array('label' => "City", 'required' => false))
            ->getForm();
        $form->handleRequest($request);
        $catalogs = array();
        if ($form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $name = $request->get('Name');
            $city = $request->get('City');
            $catalogs = $em->createQuery("SELECT c FROM NumaDOAAdminBundle:Catalogrecords c WHERE c.name LIKE :name AND c.address LIKE :city")
                ->setParameter('name', '%' . $name . '%')
                ->setParameter('city', '%' . $city . '%')
                ->getResult();
            //$catalogs = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('name' => $name));
            //return $this->render('NumaDOASiteBundle:Default:category.html.twig', array('catalogs' => $catalogs));
        }
        return $this->render('NumaDOASiteBundle:Seller:search.html.twig', array('form' => $form->createView(), 'catalogs' => $catalogs));
    }

    public function couponsAction(Request $request, $dealername = "")
    {
        $em = $this->getDoctrine()->getManager();

        if (empty($dealername) && $this->dealer instanceof Catalogrecords) {
            $dealer = $this->dealer;
        } else {
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('username' => $dealername));
        }
        $coupons = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getNonEmptyCoupons($dealer->getId());

        return $this->render('NumaDOASiteBundle:Seller:coupon.html.twig', array('dealer' => $dealer, 'coupons' => $coupons));
    }

}
