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

class SearchController extends Controller {

    public function searchAction(Request $request) {
        $text = $request->get('text');
        $page = $request->get('page');
        $page = empty($page) ? 1 : $page;

        $query = $this->getDoctrine()->getManager()
                        ->createQuery(
                                'SELECT i FROM NumaDOAAdminBundle:Item i
            JOIN i.ItemField ifield
            WHERE ifield.field_string_value LIKE :text'
                        )->setParameter('text', '%' . $text . '%');

        $items = $query->getResult();

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

    public function searchByCategoryModelAction(Request $request) {
        $model = $request->get('model');
        $category = $request->get('category');
        $page = $request->get('page');
        $page = empty($page) ? 1 : $page;
        if (strstr($model, 'fishing')) {
            $model = 'fishing';
        }
//        $repository = $this->getDoctrine()->getRepository('NumaDOAAdmin:Category');
//
//        $query = $repository->createQueryBuilder('c')
//                ->where('c.name like :name')
//                ->setParameter('name', '%$category%')
//                ->getQuery();
//
//        $category = $query->getResult();
        $query = $this->getDoctrine()->getManager()
                ->createQuery(
                        'SELECT i FROM NumaDOAAdminBundle:Item i
                                 JOIN i.ItemField ifield
                                 JOIN i.Category c
                                 WHERE ifield.field_name LIKE \'Boat type\'
                                 AND ifield.field_string_value LIKE :model
                                 AND c.name LIKE :category')
                ->setParameter('model', "%" . $model . "%")
                ->setParameter('category', "%" . $category . "%");
        echo $query->getSql();
        $items = $query->getResult();

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagerfanta->setMaxPerPage(10);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
        return $this->render('NumaDOASiteBundle:Search:default.html.twig', array('items' => $items, 'pagerfanta' => $pagerfanta));
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
                ->add('withPicture', 'checkbox', array('label' => "With pictures only", "required" => false))
                ->add('distance', 'choice', array('label' => "Search Within", "required" => false))
                ->add('zip', 'text', array('label' => "of Postal Code", "required" => false))
                ->add('id', 'text', array('label' => "Ad ID", "required" => false))
                ->add('postedFrom', 'text', array('label' => "Posted within", "required" => false))
                ->add('postedTo', 'text', array('label' => "to", "required" => false))
                ->add('feedFrom', 'text', array('label' => "Feed Sid", "required" => false))
                ->add('feedTo', 'text', array('label' => "to", "required" => false))
                ->add('status', 'text', array('label' => "Status", "required" => false))
                ->add('city', 'text', array('label' => "City", "required" => false))
                ->add('stock', 'text', array('label' => "Stock Number", "required" => false))
                ->add('optionList', 'text', array('label' => "Options List", "required" => false))
                ->add('priceFrom', 'text', array('label' => "Price from", "required" => false))
                ->add('priceTo', 'text', array('label' => "Price to", "required" => false))
                ->add('milleageFrom', 'text', array('label' => "milleage from", "required" => false))
                ->add('milleageTo', 'text', array('label' => "to", "required" => false))
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
                ->add('fueltype', 'entity', array(
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
                ->add('isSold', 'checkbox', array('label' => "Include sold items", "required" => false))
                ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            print_r($form->getData());
            die("success");
        }
        return $this->render('NumaDOASiteBundle:Search:advanced.html.twig', array('form' => $form->createView()));
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
    }

    public function searchAdvancedCar(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels();
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('POST')
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
                ->add('zip', 'text', array('label' => "of Postal Code", "required" => false))
                ->add('body_style', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Body style');
            },
                    'empty_value' => 'Any Body Style',
                    'label' => "Body Style", "required" => false
                ))
                ->add('yearFrom', 'text', array('label' => "Year from", "required" => false))
                ->add('yearTo', 'text', array('label' => "to", "required" => false))
                ->add('text', 'text', array(
                    'label' => 'Search',
                    "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => "Price from", "required" => false))
                ->add('priceTo', 'text', array('label' => "Price to", "required" => false))
                ->add('milleageFrom', 'text', array('label' => "milleage from", "required" => false))
                ->add('milleageTo', 'text', array('label' => "to", "required" => false))
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
                    'empty_value' => 'Any engine',
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
                //->add('fueltype', 'choice', array('label' => "Fuel Type", "required" => false))
                ->add('yearFrom', 'text', array('label' => "Year from", "required" => false))
                ->add('yearTo', 'text', array('label' => "to", "required" => false))
                ->add('IW_NO', 'text', array('label' => "IW NO", "required" => false))
                ->add('isSold', 'checkbox', array('label' => "Include sold items", "required" => false))
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
                ->add('isSold', 'checkbox', array('label' => "Include sold items", "required" => false))
                ->add('withPicture', 'checkbox', array('label' => "With pictures only", "required" => false))
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
            \Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedCar.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

    public function searchAdvancedMarine(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $json = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTreeModels();
        //\Doctrine\Common\Util\Debug::dump($test);die();
        $form = $this->get('form.factory')->createNamedBuilder('', 'form', null, array(
                    'csrf_protection' => false,
                ))
                //->setAttributes(array("class" => "form-horizontal", 'role' => 'form', 'name' => 'search'))
                ->setMethod('POST')
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
                ->add('type', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->findAllBy('Type');
                    },
                    'empty_value' => 'Any type',
                    'label' => "Type", "required" => false
                ))
                ->add('distance', 'choice', array('empty_value' => 'Any distance ', 'choices' => array(10 => "Within 10 km", 20 => "Within 20 km", 30 => "Within 30 km", 40 => "Within 40 km", 50 => "Within 50 km"), 'label' => "Search Within", "required" => false))
                ->add('zip', 'text', array('label' => "of Postal Code", "required" => false))
                
                ->add('yearFrom', 'text', array('label' => "Year from", "required" => false))
                ->add('yearTo', 'text', array('label' => "to", "required" => false))
                ->add('text', 'text', array(
                    'label' => 'Search',
                    "required" => false
                ))
                ->add('priceFrom', 'text', array('label' => "Price from", "required" => false))
                ->add('priceTo', 'text', array('label' => "Price to", "required" => false))
//                ->add('milleageFrom', 'text', array('label' => "milleage from", "required" => false))
//                ->add('milleageTo', 'text', array('label' => "to", "required" => false))
                ->add('keywords', 'hidden', array('label' => "Keyword", "required" => false))
                ->add('length', 'hidden', array('label' => "Length", "required" => false))
                ->add('boatWeight', 'hidden', array('label' => "Boat Weight", "required" => false))
                ->add('beam', 'hidden', array('label' => "Beam", "required" => false))
                ->add('hull', 'hidden', array('label' => "Hull Design", "required" => false))
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
                    'empty_value' => 'Any drive type',
                    'label' => "Drive Type", "required" => false
                ))
               ->add('enginetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->findAllBy('Engine Type');
                    },
                    'empty_value' => 'Any engine type',
                    'label' => "Engine Type", "required" => false
                ))
                ->add('transmission', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Transmission');
            },
                    'empty_value' => 'All Transmissions',
                    'label' => "transmission", "required" => false
                ))
                ->add('enginetype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Engine Type');
            },
                    'empty_value' => 'Any engine',
                    'label' => "Engine", "required" => false
                ))
                ->add('horsepower', 'hidden', array('label' => "Horsepower", "required" => false))
                ->add('fueltype', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                return $er->findAllBy('Fuel Type');
            },
                    'empty_value' => 'All Fuel Types',
                    'label' => "Fuel Types", "required" => false
                ))
                ->add('fuelcapacity', 'hidden', array('label' => "Fuel Capacity", "required" => false))
                ->add('ofhours', 'hidden', array('label' => "Of Hours", "required" => false))
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
                ->add('passengers', 'hidden', array('label' => "Passengers", "required" => false))
                ->add('trailer', 'entity', array(
                    'class' => 'NumaDOAAdminBundle:ListingFieldLists',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->findAllBy('Trailer');
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
            \Doctrine\Common\Util\Debug::dump($query->getResult());
        }
        return $this->render('NumaDOASiteBundle:Search:advancedMarine.html.twig', array('form' => $form->createView(), 'json' => $json));
    }

}
