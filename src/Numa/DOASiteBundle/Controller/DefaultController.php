<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;

class DefaultController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $hometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();
        $tabs = array();
        foreach ($hometabs as $tab) {
            $tabs[$tab->getCategoryName()][] = $tab;
        }
        
        //print_r($tabs);
        $vehCategory = 1;
        $jsonCar = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(614);
        $jsonRvs = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(760);
        $vehicleForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('bodyStyle', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Body Style');
            },
                    'empty_value' => 'Any Body Style',
                    'label' => "Body Style", "required" => false
                ))
                ->add('model', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Model', 1);
            },
                    'empty_value' => 'Any Model',
                    'label' => "Model", "required" => false
                ))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy(614);
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from', "required" => false))
                ->add('priceTo', 'text', array('label' => 'to', "required" => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'choices' => Util::createYearRangeArray(), "required" => false))
                ->add('yearTo', 'choice', array('label' => 'to', 'choices' => Util::createYearRangeArray(), 'preferred_choices' => array(Util::yearMax), "required" => false))
                ->add('category_id', 'hidden', array('data' => 1))
                ->getForm();

        $marineForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('boatType', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Boat Type');
            },
                    'empty_value' => 'Any type',
                    'label' => "Type", "required" => false
                ))
                ->add('boatMake', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {

                return $er->findAllBy('Boat Make');
            },
                    'empty_value' => 'Any make',
                    'label' => "Make", "required" => false
                ))
                ->add('boatModel', 'text', array('label' => 'Model', "required" => false))
                ->add('priceFrom', 'text', array('label' => 'Price from', "required" => false))
                ->add('priceTo', 'text', array('label' => 'to', "required" => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'choices' => Util::createYearRangeArray()))
                ->add('yearTo', 'choice', array('label' => 'to', 'choices' => Util::createYearRangeArray(), 'preferred_choices' => array(Util::yearMax)))
                ->add('category_id', 'hidden', array('data' => 2))
                ->getForm();

        $rvsForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('modelRvs', 'choice', array('label' => 'Model'))
                ->add('makeRvs', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy(760, 4);
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('category_id', 'hidden', array('data' => 4))
                ->add('florPane', 'text', array('label' => 'Flor Pane', "required" => false))
                ->add('class', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('type',4);
            },
                    'empty_value' => 'Any class',
                    'label' => "Class", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from', "required" => false))
                ->add('priceTo', 'text', array('label' => 'to', "required" => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'choices' => Util::createYearRangeArray()))
                ->add('yearTo', 'choice', array('label' => 'to', 'choices' => Util::createYearRangeArray(), 'preferred_choices' => array(Util::yearMax)))
                ->getForm();
        $motorsportForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('Type', 'choice', array('label' => 'Type'))
                ->add('Model', 'text', array('label' => 'Model'))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('make', 3);
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from'))
                ->add('priceTo', 'text', array('label' => 'to'))
                ->add('yearFrom', 'choice', array('label' => 'Year from'))
                ->add('yearTo', 'choice', array('label' => 'to'))
                ->getForm();
        $agForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
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
                    'jsonCar' => $jsonCar,
                    'jsonRvs' => $jsonRvs,
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

    public function catalogAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcatalog');
        $cat_name = $request->get('catalog_name');

        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($idCat);
        return $this->render('NumaDOASiteBundle:Default:dealerShow.html.twig', array('dealer' => $dealer));
    }

    public function searchAction(Request $request) {
        $form =  $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('text', 'search', array('label' => false))
                ->getForm();

        return $this->render('NumaDOASiteBundle::search.html.twig', array('form' => $form->createView()));
    }

    public function featuredAddAction($max) {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findFeatured($max);

        return $this->render('NumaDOASiteBundle::featuredAdd.html.twig', array('items' => $items));
    }
    
    public function accessDeniedAction(){
        return $this->render('NumaDOASiteBundle:Errors:accessDenied.html.twig');
    }

}
