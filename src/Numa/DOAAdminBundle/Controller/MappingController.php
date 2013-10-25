<?php
namespace Numa\DOAAdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Mapping controller.
 *
 */
class MappingController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('NumaDOAAdminBundle:Mapping:index.html.twig');
    }
    
    public function mappingAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('NumaDOAAdminBundle:Mapping:index.html.twig');
    }
}