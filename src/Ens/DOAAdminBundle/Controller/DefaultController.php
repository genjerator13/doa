<?php

namespace Ens\DOAAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EnsDOAAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
