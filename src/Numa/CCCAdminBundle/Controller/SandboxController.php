<?php

namespace Numa\CCCAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SandboxController extends Controller
{
    public function testAction()
    {
        $logger = $this->get('logger');
        $logger->warning('Some application warnings, but the application works');
        $logger->error('An error occurred xxx');

        return $this->render('NumaCCCAdminBundle:Sandbox:test.html.twig', array(
            // ...
        ));
    }

}
