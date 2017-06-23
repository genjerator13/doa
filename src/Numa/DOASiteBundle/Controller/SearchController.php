<?php

namespace Numa\DOASiteBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOASiteBundle\Form\SidebarSearchType;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityRepository;
use Numa\Util\searchParameters;
use Symfony\Component\Stopwatch\Stopwatch;

class SearchController extends Controller implements DealerSiteControllerInterface{

    public $dealer;

    public $items;
    public $query;
    public $twigParams;
    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }



    protected $searchParameters;
    protected $queryUrl;

    /**
     * Collects all parameters and turn them into searchParameters
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function initSearchParams(Request $request = null, $additionalParams = array())
    {
        if (empty($this->searchParameters) || empty($this->searchParameters->init)) {
            $this->searchParameters = new \Numa\Util\searchParameters($this->container);
        }
        $parameters = array();

        if (!empty($request)) {
            $this->searchParameters->setListingPerPage($request->query->get('listings_per_page'));
            $parameters = $request->query->all();

            $parameters = array_merge($parameters, $request->attributes->get('_route_params'));

        }

        if (!empty($additionalParams)) {
            $parameters = array_merge($parameters, $additionalParams);
        }
        //set the search source, where from the search came from URL
        if (!empty($parameters['searchSource'])) {
            $aSearchSource = explode('&', $parameters['searchSource']);
            foreach ($aSearchSource as $key => $param) {
                $paramValue = explode("=", $param);
                $parameters[$paramValue[0]] = $paramValue[1];
            }
            unset($parameters['searchSource']);
            $this->searchParameters->setAll($parameters);
            return $this->redirect($this->generateUrl('search_dispatch', $parameters));
        }
        //dump($parameters);die();

        if($this->dealer instanceof Catalogrecords){
            $parameters['dealer_id'] = $this->dealer->getId();
            $parameters['dealer'] = $this->dealer;
        }
        //set sort search parameters
        $this->searchParameters->setSort($parameters);
        //$sortParams =  $parameters['search_field'];

        $this->searchParameters->setAll($parameters);

    }

    public function getSearchParameters()
    {
        return $this->searchParameters;
    }

    public function searchAction(Request $request)
    {

        $this->initSearchParams($request);

        $page = $request->get('page');

        $this->query = $this->searchParameters->createSearchQuery();

        $param = $this->showItems($this->query, $page, $this->searchParameters->getListingPerPage());
        $sidebarForm = $this->createSidebarForm();

        $param['sidebarForm'] = $sidebarForm->createView();
        $sidebarParam = $this->setSidebarSearchParams();
        $param = array_merge($param, $sidebarParam);

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function showItems($query, $page = 1, $number = 10)
    {
        $this->query = $query;
        $this->items = $this->query->getResult();
        $page = empty($page) ? 1 : $page;
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($this->query));
        $number = empty($number) ? 10 : $number;
        $pagerfanta->setMaxPerPage($number);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        //$stopwatch->lap('eventName');
        $this->queryUrl = $this->searchParameters->makeUrlQuery();
        $this->queryUrlNoSort = $this->searchParameters->makeUrlQuery(false);
        //$stopwatch->stop('eventName');
        return array('items' => $this->items,
            'pagerfanta' => $pagerfanta,
            'listing_per_page' => $number,
            'queryUrl' => $this->queryUrl,
            'queryUrlNoSort' => $this->queryUrlNoSort,
            'sort_by' => $this->searchParameters->getSortBy(),
            'sort_order' => $this->searchParameters->getSortOrder(),
            'dealer' => $this->dealer,
        );
    }

    public function searchDispatcherAction(Request $request)
    {
        $text = $request->get('text');

        if (empty($text)) {
            $text = "";
            //return $this->searchByOneParam($text, 1);
        }
        $param = array('text' => $text);
        return $this->redirect($this->generateUrl('search', $param));
    }

    public function createQuerySearchByCategory($model, $category, $page = 1)
    {

        $model = str_replace(" boat", "", $model);
        if (strstr($model, 'watercraft')) {
            $model = 'watercraft';
        }
        if ($category == 'car') {
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 WHERE i.body_style LIKE :model                              
                                 AND i.category_id=1')
                ->setParameter('model', "%" . $model . "%")
                ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'marine') {
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%boat type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                ->setParameter('model', "%" . $model . "%")
                ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'rvs') {
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                ->setParameter('model', "%" . $model . "%")
                ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'motorsport') {
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                ->setParameter('model', "%" . $model . "%")
                ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'ag') {
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                ->setParameter('model', "%" . $model . "%")
                ->setParameter('category', "%" . $category . "%");
        }
        return $this->query;
    }

    public function searchByCategoryModelAction(Request $request)
    {
        //$model = urldecode($request->get('model'));
        $em = $this->container->get('doctrine.orm.entity_manager');
        $category = $request->get('category');

        $cat = $this->getDoctrine()->getManager()->getRepository('NumaDOAAdminBundle:Category')->findOneBy(array('name' => $category));

        $this->initSearchParams($request, array('category_id' => $cat->getId()));

        $page = $request->get('page');
        //$number = intval($request->get('listings_per_page'));

        //create query        
        $this->query = $this->searchParameters->createSearchQuery();

        //read data from page Page
        $param = $this->showItems($this->query, $page, $this->searchParameters->getListingPerPage());
        $currentUrl = $request->getPathInfo();
        $webpage = $em->getRepository("NumaDOAModuleBundle:Page")->findOneBy(array('url' => $currentUrl));
        $ads = array();
        if ($webpage instanceof Page) {

            $ads = $webpage->getActiveAds();

            if(!empty($ads) && !$ads->isEmpty()) {
                $em->getRepository('NumaDOAModuleBundle:Ad')->addView($ads);
            }
        }

        $param['ads'] = $ads;
        $param['webpage'] = $webpage;
        $sidebarForm = $this->createSidebarForm();
        $param['sidebarForm'] = $sidebarForm->createView();
        $sidebarParam = $this->setSidebarSearchParams();
        $param = array_merge($param, $sidebarParam);
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function searchByDealerAction(Request $request)
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('eventName');

        $page = empty($page) ? 1 : $page;

        $this->initSearchParams($request);
        $page = $request->get('page');
        $number = intval($request->get('listings_per_page'));

        //create query
        $this->query = $this->searchParameters->createSearchQuery();
        $param = $this->showItems($this->query, $page, $this->searchParameters->getListingPerPage());
        $sidebarForm = $this->createSidebarForm();
        $param['sidebarForm'] = $sidebarForm->createView();
        $sidebarParam = $this->setSidebarSearchParams();
        $param = array_merge($param, $sidebarParam);
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function searchAdvancedAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            ->setMethod('GET')
            ->setAction($this->get('router')->generate('search_dispatch'))
            ->add('searchText', 'text', array(
                'label' => 'Search',
                "required" => false
            ))
            ->add('category', 'entity', array(
                'class' => 'NumaDOAAdminBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'empty_value' => 'All categories',
                'label' => "in", "required" => false
            ))
            //->add('category', 'choice', array('label' => "in", "required" => false))
            ->add('withPicture', 'choice', array('label' => "With Pictures Only", "required" => false))
            ->add('distance', 'choice', array('label' => "Search Within", "required" => false))
            ->add('zip', 'text', array('label' => "Of Zip / Postal", "required" => false))
            ->add('id', 'text', array('label' => "Ad ID", "required" => false))
//            ->add('postedFrom', 'text', array('label' => "Posted Within", "required" => false))
//            ->add('postedTo', 'text', array('label' => "To", "required" => false))
//            ->add('feedFrom', 'text', array('label' => "Feed Sid", "required" => false))
//            ->add('feedTo', 'text', array('label' => "To", "required" => false))
            ->add('status', 'choice', array('label' => "Status", "required" => false,'choices'=>array('N'=>'New','U'=>'Used')))
            ->add('city', 'text', array('label' => "City", "required" => false))
            ->add('stock', 'text', array('label' => "Stock Number", "required" => false))
            ->add('optionList', 'text', array('label' => "Options List", "required" => false))
            ->add('priceFrom', 'text', array('label' => "Price From", "required" => false))
            ->add('priceTo', 'text', array('label' => "Price To", "required" => false))
            ->add('mileageFrom', 'text', array('label' => "Milleage From", "required" => false))
            ->add('mileageTo', 'text', array('label' => "To", "required" => false))
            ->add('VIN', 'text', array('label' => "VIN", "required" => false))
            ->add('category', 'entity', array(
                'class' => 'NumaDOAAdminBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'empty_value' => 'All categories',
                'label' => "in", "required" => false
            ))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'All Transmissions',
                'label' => "transmission", "required" => false
            ))
            ->add('fuelType', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Fuel Type');
                },
                'empty_value' => 'All Fuel Types',
                'label' => "Fuel Types", "required" => false
            ))
            //->add('fueltype', 'choice', array('label' => "Fuel Type", "required" => false))
            ->add('yearFrom', 'text', array('label' => "Year from", "required" => false))
            ->add('yearTo', 'text', array('label' => "to", "required" => false))
            ->add('IW_NO', 'text', array('label' => "IW NO", "required" => false))
            ->add('isSold', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'include sold items')))
            ->add('withPicture', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'with pictures only')))
            ->add('Search','submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->proccessAdvancedSearch($form->getData());
            //print_r($form->getData());
            //die("success");
        }
        return $this->render('NumaDOASiteBundle:Search:advanced.html.twig', array(
            'form' => $form->createView(),
            'dealer' => $this->dealer,
        ));
    }

    private function proccessAdvancedSearch($post, $category = 0)
    {
        if ($category == 0) {
            return $this->proccessGeneralSearch($post);
        }
    }

    private function proccessGeneralSearch($post = array())
    {
        // [text] => [category] => 
        // [withPicture] => [distance] =>
        //  [zip] => [id] => [postedFrom] => 
        //  [postedTo] => [feedFrom] => [feedTo] => 
        //  [status] => [city] => [stock] => [optionList] => 
        //  [priceFrom] => [priceTo] => [milleageFrom] => [milleageTo]
        //   => [VIN] => [transmission] => [fueltype] => 
        //   [yearFrom] => [yearTo] => [IW_NO] => [isSold] =>
        //$page = $request->get('page');
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->join('i.ItemField', 'ifield');;


        if (!empty($post['text'])) {
            $qb->andWhere('ifield.field_string_value LIKE :text')
                ->setParameter('text', "%" . $post['text'] . "%");
        }

        return $this->showSearchResults($qb);
    }

    public function showSearchResults($qbuilder, $page = 1)
    {
        $this->items = $qbuilder->getQuery()->getResult();

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qbuilder));
        $pagerfanta->setMaxPerPage(10);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        $sidebarForm = $this->createSidebarForm();
        $param['sidebarForm'] = $sidebarForm->createView();
        $sidebarParam = $this->setSidebarSearchParams();
        $param = array_merge($param, $sidebarParam);
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', array('items' => $this->items, 'pagerfanta' => $pagerfanta));
    }

    public function searchAdvancedCategoryAction(Request $request)
    {
        $categoryName = $request->get('category');
        if (empty($category)) {
            //404 TO DO
        }
        if (strtolower($categoryName) == 'car') {
            return $this->searchAdvancedCar($request);
        }

        if (strtolower($categoryName) == 'marine') {
            return $this->searchAdvancedMarine($request);
        }

        if (strtolower($categoryName) == 'motorsport') {
            return $this->searchAdvancedMotorsport($request);
        }
        if (strtolower($categoryName) == 'rvs') {
            return $this->searchAdvancedRVs($request);
        }

        if (strtolower($categoryName) == 'ag') {
            return $this->searchAdvancedAg($request);
        }
    }

    public function searchAdvancedCar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(614);

        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            ->setMethod('GET')
            ->setAction($this->get('router')->generate('search_dispatch'))
            ->add('make', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy(614);
                },
                'empty_value' => 'Any Make',
                'label' => "Make", "required" => false
            ))
            ->add('model', 'hidden', array('label' => "Model", "required" => false))
            ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
            ->add('zip', 'text', array('label' => "Of Zip / Postal", "required" => false))
            ->add('bodyStyle', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Body style');
                },
                'empty_value' => 'Any Body Style',
                'label' => "Body Style", "required" => false
            ))
            ->add('yearFrom', 'text', array('label' => "Year From", "required" => false))
            ->add('yearTo', 'text', array('label' => "To", "required" => false))
            ->add('text', 'text', array(
                'label' => 'Search',
                "required" => false
            ))
            ->add('priceFrom', 'text', array('label' => "Price From", "required" => false))
            ->add('priceTo', 'text', array('label' => "Price To", "required" => false))
            ->add('mileageFrom', 'text', array('label' => "Mileage From", "required" => false))
            ->add('mileageTo', 'text', array('label' => "To", "required" => false))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'All Transmissions',
                'label' => "transmission", "required" => false
            ))
            ->add('engine', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('engine');
                },
                'empty_value' => 'Any Engine',
                'label' => "Engine", "required" => false
            ))
            ->add('fuelType', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Fuel Type');
                },
                'empty_value' => 'All Fuel Types',
                'label' => "Fuel Types", "required" => false
            ))
            //->add('fueltype', 'choice', array('label' => "Fuel Type", "required" => false))
            ->add('yearFrom', 'text', array('label' => "Year From", "required" => false))
            ->add('yearTo', 'text', array('label' => "To", "required" => false))
            ->add('IW_NO', 'text', array('label' => "IW NO", "required" => false))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'Any Transmissions',
                'label' => "Transmission", "required" => false
            ))
            ->add('engine', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Engine');
                },
                'empty_value' => 'Any Engine',
                'label' => "Engine", "required" => false
            ))
            ->add('exteriorColor', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Exterior Color');
                },
                'empty_value' => 'Any Exterior Color',
                'label' => "Exterior Color", "required" => false
            ))
            ->add('interiorColor', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Interior Color');
                },
                'empty_value' => 'Any Interior Color',
                'label' => "Interior Color", "required" => false
            ))
            ->add('isSold', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'include sold items')))
            ->add('withPicture', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'with pictures only')))
            ->add('category_id', 'hidden', array('data' => 1))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery(
                    'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                ->setParameter('model', 197);

        }
        return $this->render('NumaDOASiteBundle:Search:advancedCar.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    public function searchAdvancedMarine(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels();
        $json = "";
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            ->setMethod('GET')
            ->setAction($this->get('router')->generate('search_dispatch'))
            ->add('boatMake', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Boat Make');
                },
                'empty_value' => 'Any Make',
                'label' => "Make", "required" => false
            ))
            ->add('model', 'text', array('label' => "Model", "required" => false))
            ->add('type', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Boat Type');
                },
                'empty_value' => 'Any type',
                'label' => "Type", "required" => false
            ))
            ->add('distance', 'choice', array('empty_value' => 'Any Distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
            ->add('zip', 'text', array('label' => "Of Zip / Postal", "required" => false))
            ->add('yearFrom', 'text', array('label' => "Year From", "required" => false))
            ->add('yearTo', 'text', array('label' => "To", "required" => false))
//                ->add('text', 'text', array(
//                    'label' => 'Search',
//                    "required" => false
//                ))
            ->add('priceFrom', 'text', array('label' => "Price From", "required" => false))
            ->add('priceTo', 'text', array('label' => "Price To", "required" => false))
//                ->add('milleageFrom', 'text', array('label' => "milleage from", "required" => false))
//                ->add('milleageTo', 'text', array('label' => "to", "required" => false))
            ->add('keywords', 'text', array('label' => "Keyword", "required" => false))
            ->add('length', 'text', array('label' => "Length", "required" => false))
            ->add('boatWeight', 'text', array('label' => "Boat Weight", "required" => false))
            ->add('beam', 'text', array('label' => "Beam", "required" => false))
            ->add('hull', 'text', array('label' => "Hull Design", "required" => false))
            ->add('steeringtype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Steering Type');
                },
                'empty_value' => 'Any steering type',
                'label' => "Steering Type", "required" => false
            ))
            ->add('drivetype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Drive Type');
                },
                'empty_value' => 'Any Drive Type',
                'label' => "Drive Type", "required" => false
            ))
            ->add('enginetype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Engine Type');
                },
                'empty_value' => 'Any Engine Type',
                'label' => "Engine Type", "required" => false
            ))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'All Transmissions',
                'label' => "Transmission", "required" => false
            ))
            ->add('enginetype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Engine Type');
                },
                'empty_value' => 'Any Engine',
                'label' => "Engine Type", "required" => false
            ))
            ->add('horsepower', 'text', array('label' => "Horsepower", "required" => false))
            ->add('fueltype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Fuel Type');
                },
                'empty_value' => 'All Fuel Types',
                'label' => "Fuel Types", "required" => false
            ))
            ->add('fuelcapacity', 'text', array('label' => "Fuel Capacity", "required" => false))
            ->add('ofhours', 'text', array('label' => "# Of Hours", "required" => false))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'Any Transmissions',
                'label' => "Transmission", "required" => false
            ))
            ->add('exterior_color', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Exterior Color');
                },
                'empty_value' => 'Any Exterior Color',
                'label' => "Exterior Color", "required" => false
            ))
            ->add('interior_color', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Interior Color');
                },
                'empty_value' => 'Any Interior Color',
                'label' => "Interior Color", "required" => false
            ))
            ->add('passengers', 'text', array('label' => "# Of Passengers", "required" => false))
            ->add('trailer', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Trailer', 2);
                },
                'empty_value' => 'Any Trailer',
                'label' => "Trailer", "required" => false
            ))
            ->add('battery', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Battery');
                },
                'empty_value' => 'Any Battery',
                'label' => "Battery", "required" => false
            ))
            ->add('withPicture', 'checkbox', array('label' => "With Pictures Only", "required" => false))
            ->add('isSold', 'checkbox', array('label' => "Include Sold Items", "required" => false))
            ->add('category_id', 'hidden', array('data' => 2))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery(
                    'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                ->setParameter('model', 197);

        }
        return $this->render('NumaDOASiteBundle:Search:advancedMarine.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    public function searchAdvancedMotorsport(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$json = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->getJsonListModels(700);        
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            ->setMethod('GET')
            ->setAction($this->get('router')->generate('search_dispatch'))
            ->add('make', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('make', 3);
                },
                'empty_value' => 'Any Make',
                'label' => "Make", "required" => false
            ))
            ->add('model', 'text', array('label' => "Model", "required" => false))
            ->add('type', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Type', 3);
                },
                'empty_value' => 'Any type',
                'label' => "Type", "required" => false
            ))
            ->add('distance', 'choice', array('empty_value' => 'Any Distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
            ->add('zip', 'text', array('label' => "Of Zip / Postal", "required" => false))
            ->add('yearFrom', 'text', array('label' => "Year From", "required" => false))
            ->add('yearTo', 'text', array('label' => "To", "required" => false))
//                ->add('text', 'text', array(
//                    'label' => 'Search',
//                    "required" => false
//                ))
            ->add('priceFrom', 'text', array('label' => "Price From", "required" => false))
            ->add('priceTo', 'text', array('label' => "Price To", "required" => false))
            ->add('milleageFrom', 'text', array('label' => "Milleage From", "required" => false))
            ->add('milleageTo', 'text', array('label' => "To", "required" => false))
            ->add('keywords', 'text', array('label' => "Keyword", "required" => false))
            ->add('engine', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Engine');
                },
                'empty_value' => 'Any Engine',
                'label' => "Engine", "required" => false
            ))
            ->add('enginetype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Engine Type');
                },
                'empty_value' => 'Any engine type',
                'label' => "Engine Type", "required" => false
            ))
            ->add('displacement', 'text', array('label' => "Displacement", "required" => false))
            ->add('ofhours', 'text', array('label' => "# of Hours", "required" => false))
            ->add('fuelsystem', 'text', array('label' => "Fuel System", "required" => false))
            ->add('fuelcapacity', 'text', array('label' => "Fuel Capacity", "required" => false))
            ->add('hull', 'hidden', array('label' => "Hull Design", "required" => false))
            ->add('steeringtype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Steering Type');
                },
                'empty_value' => 'Any Steering Type',
                'label' => "Steering Type", "required" => false
            ))
            ->add('ignition', 'text', array('label' => "Ignition", "required" => false))
            ->add('drivetype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Drive Type');
                },
                'empty_value' => 'Any Drive Type',
                'label' => "Drive Type", "required" => false
            ))
            ->add('gears', 'text', array('label' => "Gears", "required" => false))
            ->add('passengers', 'text', array('label' => "# Passengers", "required" => false))
            ->add('exterior_color', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Exterior Color');
                },
                'empty_value' => 'Any Exterior Color',
                'label' => "Exterior Color", "required" => false
            ))
            ->add('cooling_system', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Cooling System');
                },
                'empty_value' => 'Any Cooling System',
                'label' => "Colling System", "required" => false
            ))
            ->add('length', 'text', array('label' => "Length", "required" => false))
            ->add('width', 'text', array('label' => "Width", "required" => false))
            ->add('trailer', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Trailer');
                },
                'empty_value' => 'Any Trailer',
                'label' => "Trailer", "required" => false
            ))
            ->add('isSold', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'include sold items')))
            ->add('withPicture', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'with pictures only')))
            ->add('category_id', 'hidden', array('data' => 3))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery(
                    'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                ->setParameter('model', 197);

        }
        return $this->render('NumaDOASiteBundle:Search:advancedMotorsport.html.twig', array('form' => $form->createView()));
    }

    public function searchAdvancedRVs(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(760);

        $lftreec = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree');
        $rvMake = $lftreec->findAllBy(760, 4, true, true);
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            ->setMethod('GET')
            ->setAction($this->get('router')->generate('search_dispatch'))
            ->add('makeRvs', 'choice', array(
                'choices' => $rvMake,
                'empty_value' => 'Any Make',
                'label' => "Make", "required" => false
            ))
//                ->add('makeRvs', 'entity', array(
//                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
//                    'query_builder' => function(EntityRepository $er) {
//                return $er->findAllBy(760, 4);
//            },
//                    'empty_value' => 'Any Make',
//                    'label' => "Make", "required" => false
//                ))
            ->add('classs', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('classs');
                },
                'empty_value' => 'Any Class',
                'label' => "Class", "required" => false
            ))
            ->add('modelRvs', 'choice', array('label' => 'Model', 'required' => false))
            ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
            ->add('zip', 'text', array('label' => "of Zip / Postal", "required" => false))
            ->add('type', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('type');
                },
                'empty_value' => 'Any Type',
                'label' => "Type", "required" => false
            ))
            ->add('yearFrom', 'text', array('label' => "Year From", "required" => false))
            ->add('yearTo', 'text', array('label' => "To", "required" => false))
            ->add('priceFrom', 'text', array('label' => "Price From", "required" => false))
            ->add('priceTo', 'text', array('label' => "Price To", "required" => false))
            ->add('milleageFrom', 'text', array('label' => "Milleage From", "required" => false))
            ->add('milleageTo', 'text', array('label' => "To", "required" => false))
            ->add('keyword', 'hidden', array('label' => "Keyword", "required" => false))
            ->add('chassistype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('chassistype');
                },
                'empty_value' => 'Any Chassis Type',
                'label' => "Chassis Type", "required" => false
            ))
            ->add('engine', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('engine');
                },
                'empty_value' => 'Any Engine',
                'label' => "Engine", "required" => false
            ))
            ->add('fueltype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Fuel Type');
                },
                'empty_value' => 'All Fuel Types',
                'label' => "Fuel Types", "required" => false
            ))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'Any Transmission',
                'label' => "Transmission", "required" => false
            ))
//                ->add('text', 'text', array(
//                    'label' => 'Search',
//                    "required" => false
//                ))
            ->add('drivetype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('drivetype');
                },
                'empty_value' => 'Any Drive Type',
                'label' => "Drive Type", "required" => false
            ))
            ->add('sleeps', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('sleeps');
                },
                'empty_value' => 'Any Sleeps',
                'label' => "Sleeps", "required" => false
            ))
            ->add('slideouts', 'text', array('label' => "Slide Outs", "required" => false))
            ->add('length', 'text', array('label' => "Length (ft)", "required" => false))
            ->add('weight', 'text', array('label' => "Weight (lbs)", "required" => false))
            ->add('exteriorcolor', 'text', array('label' => "Exterior Color", "required" => false))
            ->add('interiorcolor', 'text', array('label' => "Interior Color", "required" => false))
            ->add('flooring', 'text', array('label' => "Flooring", "required" => false))
            ->add('addonscreenroom', 'checkbox', array('label' => "Add-On Screen Room", "required" => false))
            ->add('cablehookup', 'checkbox', array('label' => "Cable Hookup", "required" => false))
            ->add('ceilingfansvents', 'checkbox', array('label' => "Ceiling Fans/Vents", "required" => false))
            ->add('dcconverter', 'checkbox', array('label' => "DC Converter", "required" => false))
            ->add('electricaljacks', 'checkbox', array('label' => "Electrical Jacks", "required" => false))
            ->add('stabilizerjacks', 'checkbox', array('label' => "Stabilizer Jacks", "required" => false))
            ->add('furnace', 'checkbox', array('label' => "Furnace", "required" => false))
            ->add('airconditionerroof', 'checkbox', array('label' => "Air Conditioner (Roof)", "required" => false))
            ->add('airconditionercentral', 'checkbox', array('label' => "Air Conditioner (Central-Ducted)", "required" => false))
            ->add('dieselgenerator', 'checkbox', array('label' => "Diesel Generator", "required" => false))
            ->add('gasgenerator', 'checkbox', array('label' => "Gas Generator", "required" => false))
            ->add('propanetank', 'checkbox', array('label' => "Propane Tank", "required" => false))
            ->add('propanegenerator', 'checkbox', array('label' => "Propane Generator", "required" => false))
            ->add('electricalhookup', 'checkbox', array('label' => "Electrical Hookup", "required" => false))
            ->add('stereo', 'checkbox', array('label' => "Stereo", "required" => false))
            ->add('dvdplayer', 'checkbox', array('label' => "DVD Player", "required" => false))
            ->add('cd', 'checkbox', array('label' => "CD", "required" => false))
            ->add('satellitedish', 'checkbox', array('label' => "Satellite Dish", "required" => false))
            ->add('centralvac', 'checkbox', array('label' => "Central Vac", "required" => false))
            ->add('insulatedplumbing', 'checkbox', array('label' => "Insulated Plumbing", "required" => false))
            ->add('portableskylight', 'checkbox', array('label' => "Portable Skylight", "required" => false))
            ->add('shower', 'checkbox', array('label' => "Shower", "required" => false))
            ->add('exteriorshower', 'checkbox', array('label' => "Exterior Shower", "required" => false))
            ->add('tub', 'checkbox', array('label' => "Tub", "required" => false))
            ->add('toilet', 'checkbox', array('label' => "Toilet", "required" => false))
            ->add('waterheater', 'checkbox', array('label' => "Water Heater", "required" => false))
            ->add('dsiwaterheater', 'checkbox', array('label' => "DSI Water Heater", "required" => false))
            ->add('doublebed', 'checkbox', array('label' => "Double Bed", "required" => false))
            ->add('bunkbeds', 'checkbox', array('label' => "Bunk Beds", "required" => false))
            ->add('frontoverheadbunk', 'checkbox', array('label' => "Front Overhead Bunk", "required" => false))
            ->add('jackjillbunks', 'checkbox', array('label' => "Jack/Jill Bunks", "required" => false))
            ->add('queenbed', 'checkbox', array('label' => "Queen Bed", "required" => false))
            ->add('rearbed', 'checkbox', array('label' => "Rear Bed", "required" => false))
            ->add('twinbed', 'checkbox', array('label' => "Twin Bed", "required" => false))
            ->add('sofabeddaveno', 'checkbox', array('label' => "Sofa Bed/Daveno", "required" => false))
            ->add('lpgco2detectors', 'checkbox', array('label' => "LPG/CO2 Detectors", "required" => false))
            ->add('tvantenna', 'checkbox', array('label' => "TV Antenna", "required" => false))
            ->add('tv', 'checkbox', array('label' => "TV", "required" => false))
            ->add('vcr', 'checkbox', array('label' => "VCR", "required" => false))
            ->add('stove', 'checkbox', array('label' => "Stove", "required" => false))
            ->add('oven', 'checkbox', array('label' => "Oven", "required" => false))
            ->add('rangehood', 'checkbox', array('label' => "Range Hood", "required" => false))
            ->add('microwave', 'checkbox', array('label' => "Microwave", "required" => false))
            ->add('convectionoven', 'checkbox', array('label' => "Convection Oven", "required" => false))
            ->add('roofrack', 'checkbox', array('label' => "Roof Rack", "required" => false))
            ->add('awning', 'checkbox', array('label' => "Awning", "required" => false))
            ->add('ladder', 'checkbox', array('label' => "Ladder", "required" => false))
            ->add('trailerhitch', 'checkbox', array('label' => "Trailer", "required" => false))
            ->add('sparetire', 'checkbox', array('label' => "Spare Tire", "required" => false))
            ->add('backupcamera', 'checkbox', array('label' => "Backup Camera", "required" => false))
            ->add('isSold', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'include sold items')))
            ->add('withPicture', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'with pictures only')))
            ->add('category_id', 'hidden', array('data' => 4))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery(
                    'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                ->setParameter('model', 197);
        }
        return $this->render('NumaDOASiteBundle:Search:advancedRVs.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    //ag


    public function searchAdvancedAg(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(721);

        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
            'csrf_protection' => false,
        ))
            //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
            ->setMethod('GET')
            ->setAction($this->get('router')->generate('search_dispatch', array('category' => 'Ag')))
            ->add('make', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Make', 13);
                },
                'empty_value' => 'Any Make',
                'label' => "Make", "required" => false
            ))
            ->add('model', 'text', array('label' => "Model", "required" => false))
            ->add('agApplication', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Ag Application');
                },
                'empty_value' => 'Any Ag Application',
                'label' => "Ag Application", "required" => false
            ))
            ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
            ->add('zip', 'text', array('label' => "of Zip / Postal", "required" => false))
            ->add('yearFrom', 'text', array('label' => "Year From", "required" => false))
            ->add('yearTo', 'text', array('label' => "To", "required" => false))
            ->add('priceFrom', 'text', array('label' => "Price From", "required" => false))
            ->add('priceTo', 'text', array('label' => "Price To", "required" => false))
            ->add('keyword', 'text', array('label' => "Keyword", "required" => false))
            ->add('engine', 'text', array('label' => "Engine", "required" => false))
            ->add('horsepower', 'text', array('label' => "Horse Power", "required" => false))
            ->add('hours', 'text', array('label' => "Hours", "required" => false))
            ->add('fueltype', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Fuel Type', 0);
                },
                'empty_value' => 'All Fuel Types',
                'label' => "Fuel Types", "required" => false
            ))
            ->add('transmission', 'entity', array(
                'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAllBy('Transmission');
                },
                'empty_value' => 'Any Transmission',
                'label' => "Transmission", "required" => false
            ))
            ->add('stering', 'text', array('label' => "Stering", "required" => false))
            ->add('speedForward', 'text', array('label' => "Speed Forward", "required" => false))
            ->add('speedReverse', 'text', array('label' => "Speed Reverse", "required" => false))
            ->add('tireSize', 'text', array('label' => "Tire Size", "required" => false))
            ->add('tireEquipment', 'text', array('label' => "Tire Equipment", "required" => false))
            ->add('cuttingWidthFrom', 'text', array('label' => "Cutting Width From", "required" => false))
            ->add('cuttingWidthTo', 'text', array('label' => "Cutting Width To", "required" => false))
            ->add('isSold', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'include sold items')))
            ->add('withPicture', 'choice', array('expanded' => true, 'multiple' => true, "required" => false, 'choices' => array(1 => 'with pictures only')))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $this->query = $this->getDoctrine()->getManager()
                ->createQuery(
                    'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                ->setParameter('model', 197);
        }
        return $this->render('NumaDOASiteBundle:Search:advancedAg.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    //endeg
    public function saveSearchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $ret = array();
        $search_url = $request->get('url');
        $name = $request->get('name');

        $userSearches = $em->getRepository('NumaDOAAdminBundle:UserSearch')
            ->findBy(array('User' => $user));
        $userSearchCount = count($userSearches);
        $userSearchExists = $em->getRepository('NumaDOAAdminBundle:UserSearch')
            ->findOneBy(array('User' => $user,
                'search_url' => $search_url,
                'name' => $name
            ));

        if (empty($userSearchExists)) {
            $userSearch = new \Numa\DOAAdminBundle\Entity\UserSearch();
            $userSearch->setUser($user);
            $userSearch->setName($name);
            $userSearch->setSearchUrl($search_url);
            $em->persist($userSearch);
            $userSearchCount++;
        }

        $em->flush();
        $ret = array('savedSearch' => $userSearchCount);

        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    public function searchByStatusAction(Request $request)
    {
        $page = empty($page) ? 1 : $page;

        $this->initSearchParams($request);
        $page = $request->get('page');

        $number = intval($request->get('listings_per_page'));

        //create query
        $this->query = $this->searchParameters->createSearchQuery();
        $param = $this->showItems($this->query, $page, $this->searchParameters->getListingPerPage());
        //create sidebar

        $sidebarType = new SidebarSearchType();

        $sidebarForm = $this->createSidebarForm();
        $param['sidebarForm'] = $sidebarForm->createView();
        $sidebarParam = $this->setSidebarSearchParams();
        $param = array_merge($param, $sidebarParam);
        //dump($param);die();
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function createSidebarForm(){
        $sidebarType = new SidebarSearchType();
        $paramsO = $this->getSearchParameters();
        $sidebarForm = $this->container->get('form.factory')->create($sidebarType,null,array(
            'action' => $this->generateUrl('search_dispatch'),
            'method' => 'GET'));
        $params = $paramsO->getParams();
        $em = $this->getDoctrine()->getManager();



        //dump($this->dealer->isRVsDealer());


        $bodyStyle = $em->getRepository('NumaDOAAdminBundle:Item')->getAllSingleColumn("body_style",$this->dealer);
        $bodyStyle[] = array("body_style"=>"Other");
        $bodyStyle = $this->makeChoicesForChoiceType($bodyStyle,"body_style","Any Body Style");
        $sidebarForm->add('bodyStyleString','choice',array('label'=>'Body Style','choices'=>$bodyStyle,));

        $make = $em->getRepository('NumaDOAAdminBundle:Item')->getAllmake($this->dealer);
        //dump($make);die();
        $make = $this->makeMakeChoicesForChoiceType($make,"make","Any Make");
        $sidebarForm->add('make','choice',array('label'=>'Make','choices'=>$make,"required"=>false));

        $yearFrom = $em->getRepository('NumaDOAAdminBundle:Item')->getAllSingleColumn("year",$this->dealer);
        $yearFrom = $this->makeChoicesForChoiceType($yearFrom,"year","Any Year");
        $sidebarForm->add('yearFrom','choice',array('label'=>'Year From','choices'=>$yearFrom,"required"=>false));

        $yearTo = $em->getRepository('NumaDOAAdminBundle:Item')->getAllSingleColumn("year",$this->dealer,"DESC");
        $yearTo = $this->makeChoicesForChoiceType($yearTo,"year","Any Year");
        $sidebarForm->add('yearTo','choice',array('label'=>'Year To','choices'=>$yearTo,"required"=>false));

//        $criteriaMinYear = Criteria::create()->orderBy(array('year' => Criteria::ASC));
//        $criteriaMaxYear = Criteria::create()->orderBy(array('year' => Criteria::DESC));
//
//        $minYear = $this->items->matching($criteriaMinYear);
//        $maxYear = $this->items->matching($criteriaMaxYear);
//        dump($minYear);
//        dump($maxYear);die();
        //die();
        if(!empty($params['bodyStyleString']) && !empty($params['bodyStyleString']->getValue())) {
            $sidebarForm->get('bodyStyleString')->setData($params['bodyStyleString']->getValue());
        }
        if(!empty($params['yearFrom']) && !empty($params['yearFrom']->getValue())) {
            $sidebarForm->get('yearFrom')->setData($params['yearFrom']->getValue());
        }
        if(!empty($params['yearTo']) && !empty($params['yearTo']->getValue())) {
            $sidebarForm->get('yearTo')->setData($params['yearTo']->getValue());
        }
        if(!empty($params['make']) && !empty($params['make']->getValue())) {
            $sidebarForm->get('make')->setData($params['make']->getValue());
        }
        if(!empty($params['model']) && !empty($params['model']->getValue())) {
            $sidebarForm->get('model')->setData($params['model']->getValue());
        }
        if(!empty($params['mileageFrom']) && !empty($params['mileageFrom']->getValue())) {
            $sidebarForm->get('mileageFrom')->setData($params['mileageFrom']->getValue());
        }
        if(!empty($params['mileageTo']) && !empty($params['mileageTo']->getValue())) {
            $sidebarForm->get('mileageTo')->setData($params['mileageTo']->getValue());
        }
        if(!empty($params['priceFrom']) && !empty($params['priceFrom']->getValue())) {
            $sidebarForm->get('priceFrom')->setData($params['priceFrom']->getValue());
        }
        if(!empty($params['priceTo']) && !empty($params['priceTo']->getValue())) {
            $sidebarForm->get('priceTo')->setData($params['priceTo']->getValue());
        }
        //dump($params['year']->getValue());die();

        return $sidebarForm;
        //$param['sidebarForm'] = $sidebarForm->createView();
    }

    private function setSidebarSearchParams(){
        $em = $this->getDoctrine()->getManager();

        $lftreec = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree');
        $lflistc = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists');
        $lftreec->setMemcached($this->get('mymemcache'));
        $lflistc->setMemcached($this->get('mymemcache'));

        $jsonCar = $lftreec->getJsonTreeModels(614);

        $jsonRvs = $lftreec->getJsonTreeModels(760);
        $params  = array('jsonCar'=>$jsonCar,'jsonRvs'=>$jsonRvs);
        return $params;
    }

    /**
     * Makes choices for dropdown from search results
     */
    public function makeChoicesForChoiceType($items,$field,$first=""){
        $res=array();
        $res[0]=$first;
        foreach ($items as $item) {
            $res[$item[$field]]=$item[$field];
        }
        return $res;
    }

    /**
     * Makes choices for dropdown from search results
     */
    public function makeMakeChoicesForChoiceType($items,$field,$first=""){
        $res=array();
        $res[0]=$first;
        foreach ($items as $item) {
            $res[$item['id']]=$item[$field];
        }
        return $res;
    }

}
