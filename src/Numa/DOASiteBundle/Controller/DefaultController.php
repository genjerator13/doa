<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {    
        $em = $this->getDoctrine()->getManager();
        $hometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();
        $tabs= array();
        foreach($hometabs as $tab){
            $tabs[$tab->getCategoryName()][] = $tab;            
        }
        return $this->render('NumaDOASiteBundle:Default:index.html.twig', array( 'tabs' => $tabs));
    }
    
    public function categoriesAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findAll();

        return $this->render('NumaDOASiteBundle:Default:categories.html.twig', array( 'categories' => $categories));
    }
    
    public function categoryAction(request $request) {
        $em = $this->getDoctrine()->getManager();
        $idCat = $request->get('idcategory');
        $cat_name = $request->get('category_name');
        $category = $em->getRepository('NumaDOAAdminBundle:Catalogcategory')->findOneById($idCat);
        $catalogs = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findBy(array('category_id'=>$idCat));
        return $this->render('NumaDOASiteBundle:Default:category.html.twig', array( 'category' => $category, 'catalogs' => $catalogs));
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
