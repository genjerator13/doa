<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOADMSBundle\Entity\PartRequest;
use Numa\DOADMSBundle\Form\PartRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PartsController extends Controller {

    public function partAction(Request $request) {

        $entity = new PartRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Success!');

            return $this->redirect($this->generateUrl('part_form'));

        }

        return $this->render('NumaDOASiteBundle:Parts:parts_form.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }



    public function createAction(Request $request)
    {
        $entity = new PartRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('partrequest'));

        }

        return $this->render('NumaDOADMSBundle:PartRequest:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PartRequest entity.
     *
     * @param PartRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PartRequest $entity)
    {
        $form = $this->createForm(new PartRequestType(), $entity, array(
            'action' => $this->generateUrl('part_form'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

}

