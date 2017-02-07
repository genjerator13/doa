<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOADMSBundle\Entity\ListingForm;

use Numa\DOADMSBundle\Form\ListingFormContactType;
use Numa\DOADMSBundle\Form\ListingFormDriveType;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOADMSBundle\Form\ListingFormFinanceType;
use Numa\DOADMSBundle\Form\ListingFormOfferTradeInType;
use Numa\DOADMSBundle\Form\ListingFormOfferType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ListingFormRESTController extends Controller implements DealerSiteControllerInterface
{

    public $dealer;

    public function initializeDealer($dealer)
    {
        $this->dealer = $dealer;
    }


    /**
     * @Rest\View
     */
    public function allAction()
    {
        $listingForm = $this->getDoctrine()->getRepository('NumaDOADMSBundle:ListingForm')->findAll();
        return $listingForm;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($dealer_id)
    {
        $listingForm = $this->getDoctrine()->getRepository('NumaDOADMSBundle:ListingForm')->findBy(array('dealer_id' => $dealer_id));
        return $listingForm;
    }

    public function postListingFormAction(Request $request)
    {
        $post = $request->getContent();
        $error = true;

        if (!empty($request->request->get('eprice'))) {
            $data = $request->request->get('eprice');
            $form = new ListingFormEpriceType();
            $id = "eprice_form";

        }
        if (!empty($request->request->get('finance'))) {
            $data = $request->request->get('finance');
            $form = new ListingFormFinanceType();
            $id = "finance_form";

        }
        if (!empty($request->request->get('contactus'))) {
            $data = $request->request->get('contactus');
            $form = new ListingFormContactType();
            $id = "contactus_form";

        }
        if (!empty($request->request->get('testdrive'))) {
            $data = $request->request->get('testdrive');
            $form = new ListingFormDriveType();
            $id = "testdrive_form";

        }
        if (!empty($request->request->get('offer'))) {
            $data = $request->request->get('offer');
            $form = new ListingFormOfferType();
            $id = "offer_form";
        }
        if (!empty($request->request->get('offertradein'))) {

            $data = $request->request->get('offertradein');
            $form = new ListingFormOfferTradeInType();
            $id = "offerTradeIn_form";
        }


        $entity = new ListingForm();
        $entity->setDealer($this->dealer);

        $form = $this->createForm($form, $entity, array(
            'csrf_protection' => false,
            'method' => 'POST',
            'attr' => array('id' => $id),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $error = false;
            //dump("error");
        } else {
            //dump("OK");
            //dump("OK");
        }
        if (!$error) {
            $em = $this->get('doctrine.orm.entity_manager');

            $this->get('Numa.DMSUtils')->attachCustomerByEmail($entity, $entity->getDealer(), $entity->getEmail(), $entity->getCustName(), $entity->getCustLastName(), $entity->getPhone());
            if (!empty($entity->getItemId())) {
                $item = $em->getRepository("NumaDOAAdminBundle:Item")->find($entity->getItemId());
                $entity->setItem($item);
            }

            $em->persist($entity);
            $em->flush();
        }
        if ($error) {
            $response = new JsonResponse(
                array(
                    'message' => 'error',
                    'action' => $form->getErrorsAsString(),
                    500));
            return $response;
        }
        $response = new JsonResponse(
            array(
                'message' => 'Success',
                'action' => '',
                200));
        return $response;
    }
}