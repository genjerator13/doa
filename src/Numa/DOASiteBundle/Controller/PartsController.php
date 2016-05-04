<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Form\PartRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
use Symfony\Component\Stopwatch\Stopwatch;

class PartsController extends Controller {

    public function partAction() {
        $form = $this->
        return $this->render('NumaDOASiteBundle:Parts:parts_form.html.twig', array('form' => $form->createView())
        );
    }

    private function CreateForm($entity) {
        //$action = $this->generateUrl('part_request');

        $form = $this->createForm(new PartRequestType(), $entity, array(
            //'action' => $action,
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}

