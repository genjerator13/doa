<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Entity\Customers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('NumaCCCAdminBundle:Default:index.html.twig', array('name' => "test"));
    }



//    public function loginAction(Request $request) {
//        $session = $request->getSession();
//
//        // get the login error if there is one
//        dump(SecurityContext::AUTHENTICATION_ERROR);
//        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
//            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
//        } else {
//            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
//            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
//        }
//
//        return $this->render('NumaCCCAdminBundle:Default:login.html.twig', array(
//                    // last username entered by the user
//                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
//                    'error' => $error,
//        ));
//    }
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('NumaCCCAdminBundle:Default:login.html.twig', array(
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError(),
        ));
    }

    public function pageNotFoundAction() {
        return $this->redirectToRoute("numa_ccc_admin_homepage");
    }

    public function downloadAction($filename, $folder) {
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir() . "/../web/upload/";
        $content = file_get_contents($path . $folder . "/" . $filename);

        $response = new \Symfony\Component\HttpFoundation\Response();

        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename);

        $response->setContent($content);
        return $response;
    }

    public function downloadDelAction($filename, $folder) {
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir() . "/../web/upload/";
        $fullpath = $path . $folder . "/" . $filename;
        unlink($fullpath);
        $this->addFlash(
                'success', 'Newsletter file has been deleted!'
        );
        return $this->redirect($this->generateUrl('batchx'));
    }

    public function customRateAction(){
        $customer =
        $customer = $this->get('security.token_storage')->getToken()->getUser();
        $customRate ="";

        if($customer instanceof Customers) {
            $customRate = $this->get("numa.customer")->getCustomPdf($customer);
        }

        return $this->render('NumaCCCAdminBundle:Default:customRate.html.twig', array('customrate'=>$customRate
        ));
    }

}
