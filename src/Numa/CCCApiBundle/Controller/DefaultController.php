<?php

namespace Numa\CCCApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NumaCCCApiBundle:Default:index.html.twig');
    }
}
