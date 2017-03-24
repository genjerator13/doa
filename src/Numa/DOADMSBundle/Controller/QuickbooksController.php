<?php

namespace Numa\DOADMSBundle\Controller;

use Doctrine\DBAL\VersionAwarePlatformDriver;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use \Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\Vendor;
use oasis\names\specification\ubl\schema\xsd\CommonAggregateComponents_2\CatalogueLine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;

class QuickbooksController extends Controller
{

    public function indexAction()
    {
        return $this->render('NumaDOADMSBundle:Quickbooks:index.html.twig');
    }

    public function addItemAction(Request $request, $item_id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->find($item_id);

        $qbItem = $this->get("numa.dms.quickbooks")->insertItem($item);
        if($qbItem instanceof QuickBooks_IPP_Object_Item){
            $qbItem=array();
        }
        return $this->render('NumaDOADMSBundle:Quickbooks:item.html.twig', array(
            'item'=>$qbItem
        ));
    }

    public function suppliersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qbSuppliers = $this->get("numa.dms.quickbooks")->getAllSuppliers();
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $vendors = $em->getRepository(Vendor::class)->findByDealerId($dealer->getId());
        //dump($qbSuppliers);die();

        return $this->render('NumaDOADMSBundle:Quickbooks:vendors.html.twig', array(
            'qbSuppliers'=>$qbSuppliers,
            'vendors'=>$vendors,
        ));
    }

    public function qbToDmsVendorsAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $qbSuppliers = $this->get("numa.dms.quickbooks")->qbToDMSVendors($dealer);

        $this->addFlash("success","All the suppliers from QuickBooks are imported to DMS");
        return $this->redirectToRoute('dms_quickbooks_suppliers');
    }

    public function dmsToQbVendorsAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $vendor = $this->get("numa.dms.quickbooks")->importAllDealerVendorsToQB($dealer);


        $this->addFlash("success","All the vendors from DMS are imported to QuickBooks");

        return $this->redirectToRoute('dms_quickbooks_suppliers');
    }


}
