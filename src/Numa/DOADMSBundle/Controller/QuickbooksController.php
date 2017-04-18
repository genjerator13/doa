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

    public function listingPreviewAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->find(intval($id));

        $vendors =  $this->container->get("numa.dms.sale")->getAllVendors($item);
        //dump($vendors);

//        $QBPOs = $this->get('numa.dms.quickbooks')->addToQBPO($id,true);
        //$QBPOs = $this->get('numa.dms.quickbooks')->insertPurchaseOrdersForItem($item,true);
        //die();
        return $this->render('NumaDOADMSBundle:Quickbooks:listingPreview.html.twig', array(
           // 'QBPOs'=>$QBPOs,
            'item'=>$item,
            'vendors'=>$vendors
        ));
    }

    public function listingPreviewQBAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->find(intval($id));

        $vendors =  $this->container->get("numa.dms.sale")->getAllVendors($item,true);
        dump($vendors);

//        $QBPOs = $this->get('numa.dms.quickbooks')->addToQBPO($id,true);
        //$QBPOs = $this->get('numa.dms.quickbooks')->insertPurchaseOrdersForItem($item,true);

        return $this->render('NumaDOADMSBundle:Quickbooks:listingPreviewQB.html.twig', array(
            // 'QBPOs'=>$QBPOs,
            'item'=>$item,
            'vendors'=>$vendors
        ));
    }

    public function vendorSyncAction(Request $request, $id,$item_id){
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $vendor = $em->getRepository(Vendor::class)->findOneBy(array("Catalogrecords"=>$dealer,"id"=>$id));

        if(!$vendor instanceof Vendor){
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $dealer = $this->get('numa.dms.quickbooks')->dmsToQbVendor($vendor);
        $this->addFlash("Success","The vendor ".$vendor->getCompanyName()." is synchronized with QB.");
        return $this->redirectToRoute("dms_quickbooks_listing_preview",array("id"=>$item_id));
    }
}
