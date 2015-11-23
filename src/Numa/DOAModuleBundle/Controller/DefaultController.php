<?php

namespace Numa\DOAModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NumaDOAModuleBundle:Default:index.html.twig', array('name' => $name));
    }
}
