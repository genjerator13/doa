<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

}
