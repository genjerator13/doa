<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchController extends Controller {

    public function searchAction(Request $request) {
        $text = $request->get('text');
        $page = empty($request->get('page')) ? 1 : $request->get('page');

        $query = $this->getDoctrine()->getManager()
                        ->createQuery(
                                'SELECT i FROM NumaDOAAdminBundle:Item i
            JOIN i.ItemField ifield
            WHERE ifield.field_string_value LIKE :text'
                        )->setParameter('text', '%' . $text . '%');

        $items = $query->getResult();
        //\Doctrine\Common\Util\Debug::dump($items);
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagerfanta->setMaxPerPage(10);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', array('items' => $items, 'pagerfanta' => $pagerfanta));
    }

    public function searchDispatcherAction(Request $request) {
        $text = $request->get('text');

        if (empty($text)) {
            $text = "";
            //return $this->searchByOneParam($text, 1);
        }
        $param = array('text' => $text);
        return $this->redirect($this->generateUrl('search', $param));
    }

    public function searchAdvancedAction(Request $request) {
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_advanced'))
                ->add('text', 'text', array(
                    'label' => 'Search',
                    "required"=>false
                ))
                ->add('category', 'choice', array('label' => "in","required"=>false))
                ->add('withPicture', 'checkbox', array('label' => "With pictures only","required"=>false))
                ->add('distance', 'choice', array('label' => "Search Within","required"=>false))
                ->add('zip', 'text', array('label' => "of Postal Code","required"=>false))
                ->add('id', 'text', array('label' => "Ad ID","required"=>false))
                ->add('postedFrom', 'text', array('label' => "Posted within","required"=>false))
                ->add('postedTo', 'text', array('label' => "to","required"=>false))
                ->add('feedFrom', 'text', array('label' => "Feed Sid","required"=>false))
                ->add('feedTo', 'text', array('label' => "to","required"=>false))
                ->add('status', 'text', array('label' => "Status","required"=>false))
                ->add('city', 'text', array('label' => "City","required"=>false))
                ->add('stock', 'text', array('label' => "Stock Number","required"=>false))
                ->add('optionList', 'text', array('label' => "Options List","required"=>false))
                ->add('priceFrom', 'text', array('label' => "Price from","required"=>false))
                ->add('priceTo', 'text', array('label' => "Price to","required"=>false))
                ->add('milleageFrom', 'text', array('label' => "milleage from","required"=>false))
                ->add('milleageTo', 'text', array('label' => "to","required"=>false))
                ->add('VIN', 'text', array('label' => "VIN","required"=>false))
                ->add('transmission', 'choice', array('label' => "transmission","required"=>false))
                ->add('fueltype', 'choice', array('label' => "Fuel Type","required"=>false))
                ->add('yearFrom', 'text', array('label' => "Year from","required"=>false))
                ->add('yearTo', 'text', array('label' => "to","required"=>false))
                ->add('IW_NO', 'text', array('label' => "IW NO","required"=>false))
                ->add('isSold', 'checkbox', array('label' => "Include sold items","required"=>false))
                ->getForm();
        return $this->render('NumaDOASiteBundle:Search:advanced.html.twig', array('form' => $form->createView()));
    }

//    public function searchByOneParam($param1, $page = 1) {
//
//
//        return $this->render('RentaboSiteBundle:Search:default.html.twig', array('facets' => $facets, 'items' => $items, 'page' => $page, 'totalpages' => $totalpages, 'param1' => $param1));
//    }
}
