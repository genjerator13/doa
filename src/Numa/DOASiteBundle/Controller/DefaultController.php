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
            $cat = $tab->getCategoryName();
            $tabs[$cat][] = $tab;
        }

        //print_r($tabs);
        $vehCategory = 1;
        //$jsonCar ="";
        //$jsonRvs ="";

        $jsonCar = $this->get('memcache.default')->get('jsonCar');
        if (empty($jsonCar)) {
            $jsonCar = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(614);
            $this->get('memcache.default')->set('jsonCar', $jsonCar);
        }

        $jsonRvs = $this->get('memcache.default')->get('jsonRvs');
        if (empty($jsonCar)) {
            $jsonRvs = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(760);
            $this->get('memcache.default')->set('jsonRvs', $jsonRvs);
        }
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
                ->add('modelRvs', 'choice', array('label' => 'Model', 'required' => false))
                ->add('makeRvs', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy(760, 4);
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('category_id', 'hidden', array('data' => 4, 'required' => false))
                ->add('floorPlan', 'text', array('label' => 'Floor Plan', "required" => false))
                ->add('class', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('type', 4);
            },
                    'empty_value' => 'Any class',
                    'required' => false,
                    'label' => "Class", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from', "required" => false))
                ->add('priceTo', 'text', array('label' => 'to', "required" => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'choices' => Util::createYearRangeArray(), 'required' => false))
                ->add('yearTo', 'choice', array('label' => 'to', 'choices' => Util::createYearRangeArray(), 'required' => false, 'preferred_choices' => array(Util::yearMax)))
                ->getForm();
        $motorsportForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('typeString', 'choice', array('label' => 'Type','choices'=>$em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('type', 3, true),'empty_value' => 'Any Type'))
                ->add('Model', 'text', array('label' => 'Model','required'=>false))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('make', 3);
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from','required'=>false))
                ->add('priceTo', 'text', array('label' => 'to','required'=>false))
                ->add('yearFrom', 'choice', array('label' => 'Year from','required'=>false))
                ->add('yearTo', 'choice', array('label' => 'to','required'=>false))
                ->add('category_id', 'hidden', array('data' => 3))
                ->getForm();
        $agForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                //->add('agApplication', 'choice', array('label' => ''))
                ->add('agApplication', 'choice', array('label' => 'Ag Application','choices'=>$em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Ag Application', 13, true),'empty_value' => 'Any Ag Application','required'=>false))
                
                ->add('Model', 'choice', array('label' => 'Model','required'=>false))
                //->add('Make', 'choice', array('label' => 'Make','required'=>false))
                ->add('ag_applicationString', 'choice', array('label' => 'Type','choices'=>$em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Make', 13, true),'empty_value' => 'Any Make','required'=>false))
                
                ->add('priceFrom', 'text', array('label' => 'Price from','required'=>false))
                ->add('priceTo', 'text', array('label' => 'to','required'=>false))
                ->add('yearFrom', 'choice', array('label' => 'Year from','required'=>false))
                ->add('yearTo', 'choice', array('label' => 'to','required'=>false))
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
        $dealers = array();
        foreach($categories as $cat){
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id'=>$cat->getId()));
            $dealers[$cat->getId()] = $dealer;
        }
        
        return $this->render('NumaDOASiteBundle:Default:categories.html.twig', array('categories' => $categories , 'dealers' => $dealers));
    }

    public function categoryAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcategory');
        $cat_name = $request->get('category_name');
        $category = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findOneById($idCat);
        $catalogs = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id' => $idCat));
        $emailForm = $this->emailDealerForm($request);
        return $this->render('NumaDOASiteBundle:Default:categoryShow.html.twig', array('category' => $category, 'catalogs' => $catalogs,'emailForm'=>$emailForm->createView()));
    }

    public function catalogAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcatalog');
        $cat_name = $request->get('catalog_name');

        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($idCat);
        
        
        $emailForm = $this->emailDealerForm($request);
        return $this->render('NumaDOASiteBundle:Default:dealerShow.html.twig', array('dealer' => $dealer,'emailForm'=>$emailForm->createView()));
    }

    public function searchAction(Request $request, $route = "") {
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('text', 'search', array('label' => false))
                ->getForm();
        return $this->render('NumaDOASiteBundle::search.html.twig', array('form' => $form->createView(), 'route' => $route));
    }

    public function featuredAddAction($max) {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findFeatured($max);

        return $this->render('NumaDOASiteBundle::featuredAdd.html.twig', array('items' => $items));
    }

    public function accessDeniedAction() {
        return $this->render('NumaDOASiteBundle:Errors:accessDenied.html.twig');
    }
    
    public function emailDealerForm($request) {
        $data = array();
        $form = $this->createFormBuilder($data)
                ->add('comments', 'textarea')
                ->add('first_name', 'text')
                ->add('last_name', 'text')
                ->add('email', 'email')
                ->add('dealer', 'hidden')
                ->getForm();

        if ($request->isMethod('POST') ) {
            $form->bind($request);

            // $data is a simply array with your form fields 
            // like "query" and "category" as defined above.
            $data = $form->getData();
            if(!empty($data['dealer'])){
                $em = $this->getDoctrine()->getManager();
                $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('id'=>$data['dealer']));


                $emailFrom = $data['email'];
                $emailTo = $dealer->getEmail();
                $emailBody = $data['comments'];
                $twig = $this->container->get('twig');
                $globals = $twig->getGlobals();
                $subject = $globals['subject'];
                $title = $globals['title'];
                $subject = $subject ." ".$title;

                $mailer = $this->get('mailer');
                $message = $mailer->createMessage()
                        ->setSubject('email from ')
                        ->setFrom($emailFrom)
                        ->setTo('e.medjesi@gmail.com')
                        ->setBody($emailTo.":".$emailBody);

                $ok = $mailer->send($message);
            }

        }
        return $form;
    }
    
    public function searchSellerAction(Request $request) {
        
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
        $emailForm = $this->emailDealerForm($request);
        return $this->render('NumaDOASiteBundle:Seller:search.html.twig', array('form' => $form->createView(),'catalogs' => $catalogs, 'emailForm'=>$emailForm->createView()));
    }


}
