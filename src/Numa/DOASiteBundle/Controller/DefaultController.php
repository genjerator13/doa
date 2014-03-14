<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $hometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();
        $tabs = array();
        foreach ($hometabs as $tab) {
            $tabs[$tab->getCategoryName()][] = $tab;
        }

        $vehicleForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('BodyStyle', 'choice', array('label' => 'Body Style'))
                ->add('Model', 'choice', array('label' => 'Model'))
                ->add('Make', 'choice', array('label' => 'Make'))
                ->add('priceFrom', 'text', array('label' => 'Price from'))
                ->add('priceTo', 'text', array('label' => 'to'))
                ->add('yearFrom', 'choice', array('label' => 'Year from'))
                ->add('yearTo', 'choice', array('label' => 'to'))
                ->getForm();

        $marineForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('BoatType', 'choice', array('label' => 'Boat Type'))
                ->add('Model', 'choice', array('label' => 'Model'))
                ->add('Make', 'choice', array('label' => 'Make'))
                ->add('priceFrom', 'text', array('label' => 'Price from'))
                ->add('priceTo', 'text', array('label' => 'to'))
                ->add('yearFrom', 'choice', array('label' => 'Year from'))
                ->add('yearTo', 'choice', array('label' => 'to'))
                ->getForm();

        $rvsForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('Model', 'choice', array('label' => 'Model'))
                ->add('Make', 'choice', array('label' => 'Make'))
                ->add('FlorPane', 'text', array('label' => 'Flor Pane'))
                ->add('Class', 'choice', array('label' => 'Class'))
                ->add('priceFrom', 'text', array('label' => 'Price from'))
                ->add('priceTo', 'text', array('label' => 'to'))
                ->add('yearFrom', 'choice', array('label' => 'Year from'))
                ->add('yearTo', 'choice', array('label' => 'to'))
                ->getForm();
        $motorsportForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('Type', 'choice', array('label' => 'Type'))
                ->add('Model', 'choice', array('label' => 'Model'))
                ->add('Make', 'choice', array('label' => 'Make'))
                ->add('priceFrom', 'text', array('label' => 'Price from'))
                ->add('priceTo', 'text', array('label' => 'to'))
                ->add('yearFrom', 'choice', array('label' => 'Year from'))
                ->add('yearTo', 'choice', array('label' => 'to'))
                ->getForm();
        $agForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('agApplication', 'choice', array('label' => 'Ag Application'))
                ->add('Model', 'choice', array('label' => 'Model'))
                ->add('Make', 'choice', array('label' => 'Make'))
                ->add('priceFrom', 'text', array('label' => 'Price from'))
                ->add('priceTo', 'text', array('label' => 'to'))
                ->add('yearFrom', 'choice', array('label' => 'Year from'))
                ->add('yearTo', 'choice', array('label' => 'to'))
                ->getForm();

        return $this->render('NumaDOASiteBundle:Default:index.html.twig', array(
                    'tabs' => $tabs,
                    'vehicleForm' => $vehicleForm->createView(),
                    'motorsportForm' => $motorsportForm->createView(),
                    'rvsForm' => $rvsForm->createView(),
                    'agForm' => $agForm->createView(),
                    'marineForm' => $marineForm->createView()));
    }

    public function categoriesAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findAll();

        return $this->render('NumaDOASiteBundle:Default:categories.html.twig', array('categories' => $categories));
    }

    public function categoryAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcategory');
        $cat_name = $request->get('category_name');
        $category = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findOneById($idCat);
        $catalogs = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id' => $idCat));
        return $this->render('NumaDOASiteBundle:Default:categoryShow.html.twig', array('category' => $category, 'catalogs' => $catalogs));
    }

    public function searchAction(Request $request) {
        $form = $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('POST')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('text', 'search', array('label' => false))
                ->getForm();

        return $this->render('NumaDOASiteBundle::search.html.twig', array('form' => $form->createView()));
    }

}
