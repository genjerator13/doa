<?php

namespace Numa\DOAApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NumaDOAApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
