<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
use Symfony\Component\Stopwatch\Stopwatch;

class DefaultController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $hometabs = '';
        if (!apc_exists('hometabs')) {
            $hometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();
            apc_store('hometabs', $hometabs);
            dump('hometabs');
            //$this->get('memcache.default')->set('jsonCar', $jsonCar);
        } else {
            $hometabs = apc_fetch('hometabs');
        }


        $tabs = array();

        foreach ($hometabs as $tab) {
            $cat = $tab->getCategoryName();
            $tabs[$cat][] = $tab;
        }

        $vehCategory = 1;

        if (!apc_exists('jsonCar')) {
            $jsonCar = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(614);
            apc_store('jsonCar', $jsonCar);
            //$this->get('memcache.default')->set('jsonCar', $jsonCar);
        } else {
            $jsonCar = apc_fetch('jsonCar');
        }

        if (!apc_exists('jsonRvs')) {
            $jsonRvs = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(760);
            //$this->get('memcache.default')->set('jsonRvs', $jsonRvs);
            apc_store('jsonRvs', $jsonRvs);
        } else {
            $jsonRvs = apc_fetch('jsonRvs');
        }
        if (!apc_exists('vehicleBodyStyle')) {
            $vehicleChoices = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Body Style', 1, true, true);
            apc_store('vehicleBodyStyle', $vehicleChoices);
            dump('vehicleBodyStyle');
        } else {
            $vehicleChoices = apc_fetch('vehicleBodyStyle');
        }

        if (!apc_exists('vehicleModel')) {
            $vehicleModel = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Model', 1, true, false);
            apc_store('vehicleModel', $vehicleModel);
            dump('vehicleModel');
        } else {
            $vehicleModel = apc_fetch('vehicleModel');
        }

        if (!apc_exists('vehicleMake')) {
            $vehicleMake = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->findAllBy(614, 1, true, false);
            apc_store('vehicleMake', $vehicleMake);
            dump('vehicleMake');
        } else {
            $vehicleMake = apc_fetch('vehicleMake');
        }
        //dump($vehicleChoices);die();
        $vehicleForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('bodyStyle', 'choice', array(
                    'choices' => $vehicleChoices,
                    'empty_value' => 'Any Body Style',
                    'label' => "Body Style", "required" => false
                ))
                ->add('model', 'choice', array(
                    'choices' => $vehicleModel,
                    'empty_value' => 'Any Model',
                    'label' => "Model", "required" => false
                ))
                ->add('make', 'choice', array(
                    'choices' => $vehicleMake,
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from', "required" => false))
                ->add('priceTo', 'text', array('label' => 'to', "required" => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'choices' => Util::createYearRangeArray(), "required" => false))
                ->add('yearTo', 'choice', array('label' => 'to', 'choices' => Util::createYearRangeArray(), 'preferred_choices' => array(Util::yearMax), "required" => false))
                ->add('category_id', 'hidden', array('data' => 1))
                ->getForm();
        if (!apc_exists('marineBoatType')) {
            $marinaBoatType = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Boat Type', 2, true, true);
            apc_store('marineBoatType', $marinaBoatType);
            dump('marineBoatType');
        } else {
            $marinaBoatType = apc_fetch('marineBoatType');
        }

        if (!apc_exists('marineBoatMake')) {
            $marinaBoatMake = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Boat Make', 2, true, true);
            apc_store('marineBoatMake', $marinaBoatType);
            dump('marineBoatMake');
        } else {
            $marinaBoatMake = apc_fetch('marineBoatMake');
        }

        $marineForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('boatType', 'choice', array(
                    'choices' => $marinaBoatType,
                    'empty_value' => 'Any type',
                    'label' => "Type", "required" => false
                ))
                ->add('boatMake', 'choice', array(
                    'choices' => $marinaBoatMake,
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

        if (!apc_exists('rvMake')) {
            $rvMake = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->findAllBy(760, 4, true, true);
            apc_store('rvMake', $rvMake);
            dump('rvMake');
        } else {
            $rvMake = apc_fetch('rvMake');
        }

        if (!apc_exists('rvClasses')) {
            $rvClasses = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('type', 4, true, true);
            apc_store('rvClasses', $rvClasses);
            dump('rvClasses');
        } else {
            $rvClasses = apc_fetch('rvClasses');
        }

        $rvsForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('modelRvs', 'choice', array('label' => 'Model', 'required' => false))
                ->add('makeRvs', 'choice', array(
                    'choices' => $rvMake,
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('category_id', 'hidden', array('data' => 4, 'required' => false))
                ->add('floorPlan', 'text', array('label' => 'Floor Plan', "required" => false))
                ->add('class', 'choice', array(
                    'choices' => $rvClasses,
                    'empty_value' => 'Any class',
                    'required' => false,
                    'label' => "Class", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from', "required" => false))
                ->add('priceTo', 'text', array('label' => 'to', "required" => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'choices' => Util::createYearRangeArray(), 'required' => false))
                ->add('yearTo', 'choice', array('label' => 'to', 'choices' => Util::createYearRangeArray(), 'required' => false, 'preferred_choices' => array(Util::yearMax)))
                ->getForm();
        if (!apc_exists('motoMake')) {
            $motoMake = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('make', 3, true, false);
            apc_store('motoMake', $motoMake);
            dump('motoMake');
        } else {
            $motoMake = apc_fetch('motoMake');
        }

        if (!apc_exists('motoType')) {
            $motoType = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('type', 3, true, true);
            apc_store('motoType', $motoType);
            dump('motoType');
        } else {
            $motoType = apc_fetch('motoType');
        }
        $motorsportForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                ->add('typeString', 'choice', array('label' => 'Type', 'choices' => $motoType, 'empty_value' => 'Any Type'))
                ->add('Model', 'text', array('label' => 'Model', 'required' => false))
                ->add('make', 'choice', array(
                    'choices' => $motoMake,
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => 'Price from', 'required' => false))
                ->add('priceTo', 'text', array('label' => 'to', 'required' => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'required' => false))
                ->add('yearTo', 'choice', array('label' => 'to', 'required' => false))
                ->add('category_id', 'hidden', array('data' => 3))
                ->getForm();
        if (!apc_exists('agModel')) {
            $agModel = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Ag Application', 13, true);
            apc_store('agModel', $agModel);
            dump('agModel');
        } else {
            $agModel = apc_fetch('agModel');
        }


        $agForm = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_dispatch'))
                ->setAttributes(array("class" => "form-inline", 'role' => 'search', 'name' => 'search'))
                //->add('agApplication', 'choice', array('label' => ''))
                //->add('agApplication', 'choice', array('label' => 'Ag Application', 'choices' => $agModel, 'empty_value' => 'Any Ag Application', 'required' => false))
                ->add('Model', 'choice', array('label' => 'Model', 'required' => false))
                //->add('Make', 'choice', array('label' => 'Make','required'=>false))
                ->add('ag_applicationString', 'choice', array('label' => 'Type', 'choices' => $agModel, 'empty_value' => 'Any Make', 'required' => false))
                ->add('priceFrom', 'text', array('label' => 'Price from', 'required' => false))
                ->add('priceTo', 'text', array('label' => 'to', 'required' => false))
                ->add('yearFrom', 'choice', array('label' => 'Year from', 'required' => false))
                ->add('yearTo', 'choice', array('label' => 'to', 'required' => false))
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
        foreach ($categories as $cat) {
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id' => $cat->getId()));
            $dealers[$cat->getId()] = $dealer;
        }

        return $this->render('NumaDOASiteBundle:Default:categories.html.twig', array('categories' => $categories, 'dealers' => $dealers));
    }

    public function categoryAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcategory');
        $cat_name = $request->get('category_name');
        $category = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findOneById($idCat);
        $catalogs = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id' => $idCat));
        $emailForm = $this->emailDealerForm($request);
        return $this->render('NumaDOASiteBundle:Default:categoryShow.html.twig', array('category' => $category, 'catalogs' => $catalogs, 'emailForm' => $emailForm->createView()));
    }

    public function catalogAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcatalog');
        $cat_name = $request->get('catalog_name');

        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($idCat);


        $emailForm = $this->emailDealerForm($request);
        return $this->render('NumaDOASiteBundle:Default:dealerShow.html.twig', array('dealer' => $dealer, 'emailForm' => $emailForm->createView()));
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
        if (!apc_exists('featured')) {
            dump('featured3');
            $featured = $em->getRepository('NumaDOAAdminBundle:Item')->findFeatured($max);
            $items=array();
            $temp=array();
            
            foreach($featured as $item){
                $temp=array();
                $temp['id'] = $item->getId();
                $temp['year'] = $item->getYear();
                $temp['model'] = $item->getModel();
                $temp['make'] = $item->getMake();
                $temp['price'] = $item->getPrice();
                if(!empty($item->getImages2())){
                    foreach($item->getImages2() as $image){
                        $temp['images']['id']=$image->getId();
                        $temp['images']['src']=$image->getFieldStringValue();
                    }                    
                }
                dump($temp);
                //$temp['images2'] = $item->getImages2();
                $items[] = $temp;
            }
            //die();
            apc_store('featured', $items);
            
        } else {
            $items = apc_fetch('featured');
        }

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

        if ($request->isMethod('POST')) {
            $form->bind($request);

            // $data is a simply array with your form fields 
            // like "query" and "category" as defined above.
            $data = $form->getData();
            if (!empty($data['dealer'])) {
                $em = $this->getDoctrine()->getManager();
                $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('id' => $data['dealer']));


                $emailFrom = $data['email'];
                $emailTo = $dealer->getEmail();
                $emailBody = $data['comments'];
                $twig = $this->container->get('twig');
                $globals = $twig->getGlobals();
                $subject = $globals['subject'];
                $title = $globals['title'];
                $subject = $subject . " " . $title;

                $mailer = $this->get('mailer');
                $message = $mailer->createMessage()
                        ->setSubject('email from ')
                        ->setFrom($emailFrom)
                        ->setTo('e.medjesi@gmail.com')
                        ->setBody($emailTo . ":" . $emailBody);

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
        return $this->render('NumaDOASiteBundle:Seller:search.html.twig', array('form' => $form->createView(), 'catalogs' => $catalogs, 'emailForm' => $emailForm->createView()));
    }

}
