<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
use Symfony\Component\Stopwatch\Stopwatch;

class DefaultController extends Controller {

    public function indexAction() {
        $nocache = false;
        $em = $this->getDoctrine()->getManager();
        $hometabs = $this->get('mymemcache')->get('hometabs');
         
        if (empty($hometabs)) {
            $hometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();

            $this->get('mymemcache')->set('hometabs', $hometabs);
            $nocache = true;
            //$this->get('memcache.default')->set('jsonCar', $jsonCar);
        }

        $tabs = array();
        foreach ($hometabs as $tab) {
            $cat = $tab->getCategoryName();
            $tabs[$cat][] = $tab;
        }

        $vehCategory = 1;
        $lftreec = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree');
        $lflistc = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists');
        $lftreec->setMemcached($this->get('mymemcache'));
        $lflistc->setMemcached($this->get('mymemcache'));

        $jsonCar = $lftreec->getJsonTreeModels(614);

        $jsonRvs = $lftreec->getJsonTreeModels(760);
        $vehicleChoices = $lflistc->findAllBy('Body Style', 1, true, true);
        $vehicleModel = $lflistc->findAllBy('Model', 1, true, false);
        $vehicleMake = $lftreec->findAllBy(614, 1, true, false);

        //die();

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

        $marinaBoatType = $lflistc->findAllBy('Boat Type', 2, true, true);
        $marinaBoatMake = $lflistc->findAllBy('Boat Make', 2, true, true);

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


        $rvMake = $lftreec->findAllBy(760, 4, true, true);
        $rvClasses = $lflistc->findAllBy('type', 4, true, true);


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

        $motoMake = $lflistc->findAllBy('make', 3, true, false);
        $motoType = $lflistc->findAllBy('type', 3, true, true);

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

        $agModel = $lflistc->findAllBy('Ag Application', 13, true);

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

        $webpage = $em->getRepository("NumaDOAModuleBundle:Page")->findOneBy(array('url'=>"/"));


        $response = $this->render('NumaDOASiteBundle:Default:index.html.twig', array(
            'webpage' => $webpage,
            'tabs' => $tabs,
            'jsonCar' => $jsonCar,
            'jsonRvs' => $jsonRvs,
            'vehicleForm' => $vehicleForm->createView(),
            'motorsportForm' => $motorsportForm->createView(),
            'rvsForm' => $rvsForm->createView(),
            'agForm' => $agForm->createView(),
            'marineForm' => $marineForm->createView()));
        if (!$nocache) {
            $response->setPublic();
            $response->setSharedMaxAge(600);
            $response->setMaxAge(600);
        }
        return $response;
    }

    public function categoriesAction() {

        //$stopwatch = new Stopwatch();
//        $stopwatch->start('eventName');
//        dump($stopwatch);
        $em = $this->getDoctrine()->getManager();
//        $categories = $this->get('mymemcache')->get('dealer_categories');
//
//        if (empty($categories)) {
            $categories = $em->getRepository('NumaDOAAdminBundle:Dcategory')->findAll();
//        }
//        $dealers = $this->get('mymemcache')->get('dealers_count');

//        if (empty($dealers)) {
//            $dealers=array();
//            foreach ($categories as $cat) {
//                $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id' => $cat->getId()));
//                $dealers[$cat->getId()] = $dealer;
//            }
//        }

//        $event = $stopwatch->stop('eventName');
//        dump($stopwatch);
        return $this->render('NumaDOASiteBundle:Default:categories.html.twig', array('categories' => $categories));
    }

    public function categoryAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcategory');
        $cat_name = $request->get('category_name');
        //$category = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findOneById($idCat);
        $catalogs = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->xfindByDCategory($idCat);

        //$items = $em->getRepository('NumaDOAAdminBundle:Item')->($user->getId());
        //dump($catalogs);//die();
        //TODO
        $emailForm = $this->emailDealerForm($request);
        return $this->render('NumaDOASiteBundle:Default:categoryShow.html.twig', array('catalogs' => $catalogs, 'emailForm' => $emailForm->createView()));
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

    public function sidebarMenuAction() {


        return $this->render('NumaDOASiteBundle::sidebarMenu.html.twig');
    }

    public function featuredAddAction($max,$order=1) {
        $em = $this->getDoctrine()->getManager();

        $itemrep = $em->getRepository('NumaDOAAdminBundle:Item');

        $itemrep->setMemcached($this->get('mymemcache'));
        $featured = $itemrep->findFeatured($max*2);

        $items = array();
        $temp = array();
        $items = array_slice($featured, $max);
        //dump($items);die();
        $response = $this->render('NumaDOASiteBundle::featuredAdd.html.twig', array('items' => $items));

        if($order==1){
            $items = array_slice($featured, 0,$max);

            $response = $this->render('NumaDOASiteBundle::featuredAdd.html.twig', array('items' => $items));
        }

        $response->setPublic();
        $response->setSharedMaxAge(60);
        $response->setMaxAge(60);
        return $response;
    }

    public function carouselAction($max,$order=1) {
        $em = $this->getDoctrine()->getManager();

        $carouselImages = $em->getRepository('NumaDOAAdminBundle:ImageCarousel')->findBy(array("active"=>true));

        $response = $this->render('NumaDOASiteBundle:Default:featuredHorizontal.html.twig', array('images' => $carouselImages));

//        $response->setPublic();
//        $response->setSharedMaxAge(60);
//        $response->setMaxAge(60);
        return $response;
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
            ->add('captcha', 'genemu_captcha',array('mapped' => false,))
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

    public function statisticsAction(Request $request) {
        $stats = $this->get('Numa.Dashboard.Stats')->dashboardStats();
        $stats['site'] = true;
        return $this->render('NumaDOASiteBundle:Default:statistics.html.twig',$stats);
    }

}

