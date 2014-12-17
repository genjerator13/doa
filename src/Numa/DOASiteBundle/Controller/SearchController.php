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
use Doctrine\ORM\EntityRepository;
use Numa\Util\searchParameters;

class SearchController extends Controller {

    protected $searchParameters;
    protected $queryUrl;

    /**
     * Collects all parameters and turn them into searchParameters
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type 
     */
    public function initSearchParams(Request $request, $additionalParams = array()) {
        if (empty($this->searchParameters) || empty($this->searchParameters->init)) {
            $this->searchParameters = new \Numa\Util\searchParameters($this->container);
        }

        $this->searchParameters->setListingPerPage($request->query->get('listings_per_page'));
        $parameters = $request->query->all();

        $parameters = array_merge($parameters, $request->attributes->get('_route_params'));
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
        //set sort search parameters
        $this->searchParameters->setSort($parameters);
        //$sortParams =  $parameters['search_field'];

        $this->searchParameters->setAll($parameters);
    }

    public function searchAction(Request $request) {
        $this->initSearchParams($request);

        $page = $request->get('page');
        $number = intval($request->get('listings_per_page'));
        $parameters = $this->searchParameters->getParams(false);
        //$queryUrl = $this->searchParameters->makeUrlQuery();
        //create query        
        $query = $this->searchParameters->createSearchQuery();

        $param = $this->showItems($query, $page, $this->searchParameters->getListingPerPage());

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function showItems($query, $page = 1, $number = 10) {

        $items = $query->getResult();

        //die($page);
        $page = empty($page) ? 1 : $page;
        //pagination

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
        $number = empty($number) ? 10 : $number;
        $pagerfanta->setMaxPerPage($number);
        //$queryUrl = $this->searchParameters->makeUrlQuery();

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        $this->queryUrl = $this->searchParameters->makeUrlQuery();
        $this->queryUrlNoSort = $this->searchParameters->makeUrlQuery(false);

        return array('items' => $items,
            'pagerfanta' => $pagerfanta,
            'listing_per_page' => $number,
            'queryUrl' => $this->queryUrl,
            'queryUrlNoSort' => $this->queryUrlNoSort,
            'sort_by' => $this->searchParameters->getSortBy(),
            'sort_order' => $this->searchParameters->getSortOrder()
        );
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

    public function createQuerySearchByCategory($model, $category, $page = 1) {

        $model = str_replace(" boat", "", $model);
        if (strstr($model, 'watercraft')) {
            $model = 'watercraft';
        }
        if ($category == 'car') {
            $query = $this->getDoctrine()->getManager()
                    ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 WHERE i.body_style LIKE :model                              
                                 AND i.category_id=1')
                    ->setParameter('model', "%" . $model . "%")
                    ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'marine') {
            $query = $this->getDoctrine()->getManager()
                    ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%boat type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                    ->setParameter('model', "%" . $model . "%")
                    ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'rvs') {
            $query = $this->getDoctrine()->getManager()
                    ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                    ->setParameter('model', "%" . $model . "%")
                    ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'motorsport') {
            $query = $this->getDoctrine()->getManager()
                    ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                    ->setParameter('model', "%" . $model . "%")
                    ->setParameter('category', "%" . $category . "%");
        } elseif ($category == 'ag') {
            $query = $this->getDoctrine()->getManager()
                    ->createQuery('SELECT distinct i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'%type%\'                                 
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                    ->setParameter('model', "%" . $model . "%")
                    ->setParameter('category', "%" . $category . "%");
        }
        return $query;
    }

    public function searchByCategoryModelAction(Request $request) {
        $model = urldecode($request->get('model'));
        $category = $request->get('category');

        $cat = $this->getDoctrine()->getManager()->getRepository('NumaDOAAdminBundle:Category')->findOneBy(array('name' => $category));

        $this->initSearchParams($request, array('category_id' => $cat->getId()));

        $page = $request->get('page');
        $number = intval($request->get('listings_per_page'));

        //create query        
        $query = $this->searchParameters->createSearchQuery();

        $param = $this->showItems($query, $page, $this->searchParameters->getListingPerPage());

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function searchByDealerAction(Request $request) {


        $page = empty($page) ? 1 : $page;
        
        $this->initSearchParams($request);
        $page = $request->get('page');
        $number = intval($request->get('listings_per_page'));

        //create query        
        $query = $this->searchParameters->createSearchQuery();

        $param = $this->showItems($query, $page, $this->searchParameters->getListingPerPage());

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', $param);
    }

    public function searchAdvancedAction(Request $request) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
            },
                    'empty_value' => 'All categories',
                    'label' => "in", "required" => false
                ))
                //->add('category', 'choice', array('label' => "in", "required" => false))
                ->add('withPicture', 'checkbox', array('label' => "With Pictures Only", "required" => false))
                ->add('distance', 'choice', array('label' => "Search Within", "required" => false))
                ->add('zip', 'text', array('label' => "Of Zip / Postal", "required" => false))
                ->add('id', 'text', array('label' => "Ad ID", "required" => false))
                ->add('postedFrom', 'text', array('label' => "Posted Within", "required" => false))
                ->add('postedTo', 'text', array('label' => "To", "required" => false))
                ->add('feedFrom', 'text', array('label' => "Feed Sid", "required" => false))
                ->add('feedTo', 'text', array('label' => "To", "required" => false))
                ->add('status', 'text', array('label' => "Status", "required" => false))
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
            },
                    'empty_value' => 'All categories',
                    'label' => "in", "required" => false
                ))
                ->add('transmission', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Transmission');
            },
                    'empty_value' => 'All Transmissions',
                    'label' => "transmission", "required" => false
                ))
                ->add('fuelType', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Fuel Type');
            },
                    'empty_value' => 'All Fuel Types',
                    'label' => "Fuel Types", "required" => false
                ))
                //->add('fueltype', 'choice', array('label' => "Fuel Type", "required" => false))
                ->add('yearFrom', 'text', array('label' => "Year from", "required" => false))
                ->add('yearTo', 'text', array('label' => "to", "required" => false))
                ->add('IW_NO', 'text', array('label' => "IW NO", "required" => false))
                ->add('isSold', 'checkbox', array('label' => "Include Sold items", "required" => false))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->proccessAdvancedSearch($form->getData());
            //print_r($form->getData());
            //die("success");
        }
        return $this->render('NumaDOASiteBundle:Search:advanced.html.twig', array('form' => $form->createView()));
    }

    private function proccessAdvancedSearch($post, $category = 0) {
        if ($category == 0) {
            return $this->proccessGeneralSearch($post);
        }
    }

    private function proccessGeneralSearch($post = array()) {
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
                ->join('i.ItemField', 'ifield');

        ;


        if (!empty($post['text'])) {
            $qb->andWhere('ifield.field_string_value LIKE :text')
                    ->setParameter('text', "%" . $post['text'] . "%");
        }

        return $this->showSearchResults($qb);
    }

    public function showSearchResults($qbuilder, $page = 1) {
        $items = $qbuilder->getQuery()->getResult();

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qbuilder));
        $pagerfanta->setMaxPerPage(10);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('NumaDOASiteBundle:Search:default.html.twig', array('items' => $items, 'pagerfanta' => $pagerfanta));
    }

    public function searchAdvancedCategoryAction(Request $request) {
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

    public function searchAdvancedCar(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(614);
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_advanced_category', array('category' => 'car')))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('make');
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('model', 'hidden', array('label' => "Model", "required" => false))
                ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
                ->add('zip', 'text', array('label' => "Of Zip / Postal", "required" => false))
                ->add('bodyStyle', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Transmission');
            },
                    'empty_value' => 'All Transmissions',
                    'label' => "transmission", "required" => false
                ))
                ->add('engine', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('engine');
            },
                    'empty_value' => 'Any Engine',
                    'label' => "Engine", "required" => false
                ))
                ->add('fuelType', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Transmission');
            },
                    'empty_value' => 'Any Transmissions',
                    'label' => "Transmission", "required" => false
                ))
                ->add('engine', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Engine');
            },
                    'empty_value' => 'Any Engine',
                    'label' => "Engine", "required" => false
                ))
                ->add('exteriorColor', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Exterior Color');
            },
                    'empty_value' => 'Any Exterior Color',
                    'label' => "Exterior Color", "required" => false
                ))
                ->add('interiorColor', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Interior Color');
            },
                    'empty_value' => 'Any Interior Color',
                    'label' => "Interior Color", "required" => false
                ))
                ->add('isSold', 'checkbox', array('label' => "Include Sold Items", "required" => false))
                ->add('withPicture', 'checkbox', array('label' => "With Pictures Only", "required" => false))
                ->add('category_id', 'hidden', array('data' => 1))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                            'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                    ->setParameter('model', 197);
            //\Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedCar.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    public function searchAdvancedMarine(Request $request) {
        $em = $this->getDoctrine()->getManager();
        //$json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels();
        $json = "";
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_advanced_category', array('category' => 'marine')))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Boat Make');
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('model', 'text', array('label' => "Model", "required" => false))
                ->add('type', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Steering Type');
            },
                    'empty_value' => 'Any steering type',
                    'label' => "Steering Type", "required" => false
                ))
                ->add('drivetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Drive Type');
            },
                    'empty_value' => 'Any Drive Type',
                    'label' => "Drive Type", "required" => false
                ))
                ->add('enginetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Engine Type');
            },
                    'empty_value' => 'Any Engine Type',
                    'label' => "Engine Type", "required" => false
                ))
                ->add('transmission', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Transmission');
            },
                    'empty_value' => 'All Transmissions',
                    'label' => "Transmission", "required" => false
                ))
                ->add('enginetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Engine Type');
            },
                    'empty_value' => 'Any Engine',
                    'label' => "Engine Type", "required" => false
                ))
                ->add('horsepower', 'text', array('label' => "Horsepower", "required" => false))
                ->add('fueltype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Fuel Type');
            },
                    'empty_value' => 'All Fuel Types',
                    'label' => "Fuel Types", "required" => false
                ))
                ->add('fuelcapacity', 'text', array('label' => "Fuel Capacity", "required" => false))
                ->add('ofhours', 'text', array('label' => "# Of Hours", "required" => false))
                //->add('fueltype', 'choice', array('label' => "Fuel Type", "required" => false))
//                ->add('yearFrom', 'text', array('label' => "Year from", "required" => false))
//                ->add('yearTo', 'text', array('label' => "to", "required" => false))
//                ->add('IW_NO', 'text', array('label' => "IW NO", "required" => false))
//                ->add('isSold', 'checkbox', array('label' => "Include sold items", "required" => false))
//                ->add('engine', 'entity', array(
//                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
//                    'query_builder' => function(EntityRepository $er) {
//                return $er->findAllBy('Engine');
//            },
//                    'empty_value' => 'Any Engine',
//                    'label' => "Engine", "required" => false
//                ))
                ->add('transmission', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Transmission');
            },
                    'empty_value' => 'Any Transmissions',
                    'label' => "Transmission", "required" => false
                ))
                ->add('exterior_color', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Exterior Color');
            },
                    'empty_value' => 'Any Exterior Color',
                    'label' => "Exterior Color", "required" => false
                ))
                ->add('interior_color', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Interior Color');
            },
                    'empty_value' => 'Any Interior Color',
                    'label' => "Interior Color", "required" => false
                ))
                ->add('passengers', 'text', array('label' => "# Of Passengers", "required" => false))
                ->add('trailer', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Trailer', 2);
            },
                    'empty_value' => 'Any Trailer',
                    'label' => "Trailer", "required" => false
                ))
                ->add('battery', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Battery');
            },
                    'empty_value' => 'Any Battery',
                    'label' => "Battery", "required" => false
                ))
                ->add('withPicture', 'checkbox', array('label' => "With Pictures Only", "required" => false))
                ->add('isSold', 'checkbox', array('label' => "Include Sold Items", "required" => false))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                            'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                    ->setParameter('model', 197);
            //\Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedMarine.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    public function searchAdvancedMotorsport(Request $request) {
        $em = $this->getDoctrine()->getManager();
        //$json = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->getJsonListModels(700);
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_advanced_category', array('category' => 'motorsport')))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('make', 3);
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('model', 'text', array('label' => "Model", "required" => false))
                ->add('type', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Engine');
            },
                    'empty_value' => 'Any Engine',
                    'label' => "Engine", "required" => false
                ))
                ->add('enginetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Steering Type');
            },
                    'empty_value' => 'Any Steering Type',
                    'label' => "Steering Type", "required" => false
                ))
                ->add('ignition', 'text', array('label' => "Ignition", "required" => false))
                ->add('drivetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Drive Type');
            },
                    'empty_value' => 'Any Drive Type',
                    'label' => "Drive Type", "required" => false
                ))
                ->add('gears', 'text', array('label' => "Gears", "required" => false))
                ->add('passengers', 'text', array('label' => "# Passengers", "required" => false))
                ->add('exterior_color', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Exterior Color');
            },
                    'empty_value' => 'Any Exterior Color',
                    'label' => "Exterior Color", "required" => false
                ))
                ->add('cooling_system', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Cooling System');
            },
                    'empty_value' => 'Any Cooling System',
                    'label' => "Colling System", "required" => false
                ))
                ->add('length', 'text', array('label' => "Length", "required" => false))
                ->add('width', 'text', array('label' => "Width", "required" => false))
                ->add('trailer', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Trailer');
            },
                    'empty_value' => 'Any Trailer',
                    'label' => "Trailer", "required" => false
                ))
                ->add('withPicture', 'checkbox', array('label' => "With pictures only", "required" => false))
                ->add('isSold', 'checkbox', array('label' => "Include sold items", "required" => false))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                            'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                    ->setParameter('model', 197);
            //\Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedMotorsport.html.twig', array('form' => $form->createView()));
    }

    public function searchAdvancedRVs(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(760);
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_advanced_category', array('category' => 'rvs')))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('make');
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('classs', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('classs');
            },
                    'empty_value' => 'Any Class',
                    'label' => "Class", "required" => false
                ))
                ->add('model', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('model');
            },
                    'empty_value' => 'Any Model',
                    'label' => "Model", "required" => false
                ))
                ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
                ->add('zip', 'text', array('label' => "of Zip / Postal", "required" => false))
                ->add('type', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('chassistype');
            },
                    'empty_value' => 'Any Chassis Type',
                    'label' => "Chassis Type", "required" => false
                ))
                ->add('engine', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('engine');
            },
                    'empty_value' => 'Any Engine',
                    'label' => "Engine", "required" => false
                ))
                ->add('fueltype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Fuel Type');
            },
                    'empty_value' => 'All Fuel Types',
                    'label' => "Fuel Types", "required" => false
                ))
                ->add('transmission', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('drivetype');
            },
                    'empty_value' => 'Any Drive Type',
                    'label' => "Drive Type", "required" => false
                ))
                ->add('sleeps', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
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
                ->add('issold', 'checkbox', array('label' => "Include Sold Items", "required" => false))
                ->add('withpictures', 'checkbox', array('label' => "With Pictures Only", "required" => false))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                            'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                    ->setParameter('model', 197);
            //\Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedRVs.html.twig', array('form' => $form->createView(), 'json' => $json));
    }
    //ag
    
    
    public function searchAdvancedAg(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels(721);
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('GET')
                ->setAction($this->get('router')->generate('search_advanced_category', array('category' => 'Ag')))
                ->add('make', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('make');
            },
                    'empty_value' => 'Any Make',
                    'label' => "Make", "required" => false
                ))
                ->add('classs', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('classs');
            },
                    'empty_value' => 'Any Class',
                    'label' => "Class", "required" => false
                ))
                ->add('model', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('model');
            },
                    'empty_value' => 'Any Model',
                    'label' => "Model", "required" => false
                ))
                ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
                ->add('zip', 'text', array('label' => "of Zip / Postal", "required" => false))
                ->add('type', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('chassistype');
            },
                    'empty_value' => 'Any Chassis Type',
                    'label' => "Chassis Type", "required" => false
                ))
                ->add('engine', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('engine');
            },
                    'empty_value' => 'Any Engine',
                    'label' => "Engine", "required" => false
                ))
                ->add('fueltype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Fuel Type');
            },
                    'empty_value' => 'All Fuel Types',
                    'label' => "Fuel Types", "required" => false
                ))
                ->add('transmission', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('drivetype');
            },
                    'empty_value' => 'Any Drive Type',
                    'label' => "Drive Type", "required" => false
                ))
                ->add('sleeps', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldTree',
                    'query_builder' => function(EntityRepository $er) {
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
                ->add('issold', 'checkbox', array('label' => "Include Sold Items", "required" => false))
                ->add('withpictures', 'checkbox', array('label' => "With Pictures Only", "required" => false))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $data = $form->getData();
            $query = $this->getDoctrine()->getManager()
                    ->createQuery(
                            'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 WHERE ifield.field_integer_value = :model
                                 AND i.category_id=2
                                ')
                    ->setParameter('model', 197);
            //\Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedAg.html.twig', array('form' => $form->createView(), 'json' => $json));
    }
    
    //endeg
    public function saveSearchAction(Request $request) {

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

}
