<?php
namespace Numa\CCCAdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Form\ImportfeedType;

/**
 * Importfeed controller.
 *
 */
class CommandLogController extends Controller {
        /**
     * Lists all Importfeed entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NumaCCCAdminBundle:CommandLog')->findLastCommandLog(100);

        return $this->render('NumaCCCAdminBundle:CommandLog:index.html.twig', array(
                    'entities' => $entities,
        ));
    }
//    
//    public function detailsAction($id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('NumaDOAAdminBundle:CommandLog')->find($id);
//        return $this->render('NumaDOAAdminBundle:CommandLog:details.html.twig', array(
//                    'entity' => $entity,
//        ));
//    }
}