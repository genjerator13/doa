<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $stats = $this->get('Numa.Dashboard.Stats')->dashboardStats();
        return $this->render('NumaDOAAdminBundle:Default:index.html.twig',
            $stats);
    }

}
