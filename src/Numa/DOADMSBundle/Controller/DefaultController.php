<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NumaDOADMSBundle:Default:index.html.twig');
    }
}
