<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Form\PartRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
use Symfony\Component\Stopwatch\Stopwatch;

class PartsController extends Controller {

    public function partAction() {

        $form= $this->CreateCreateForm();//TODO
        return $this->render('NumaDOASiteBundle:Parts:parts_form.html.twig', array('form' => $form->createView())
        );
    }

    public function CreateCreateForm() {
        //$action = $this->generateUrl('part_request');

        $form = $this->createForm(new PartRequestType(), new PartRequest(), array(
            //'action' => $action,
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Request','attr'=>array('class'=>"btn btn-primary")));

        return $form;
    }
}

