<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NumaDOAAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
