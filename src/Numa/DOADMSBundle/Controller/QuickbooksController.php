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
        $qbSuppliers = $this->get("numa.dms.quickbooks")->getAllSuppliers();
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        foreach($qbSuppliers as $supplier){
            $qbid = $this->get("numa.dms.quickbooks")->parseId($supplier->getId());
            $vendor = $em->getRepository(Vendor::class)->findOneBy(array("qb_supplier_id"=>$qbid));

            if(!$vendor instanceof Vendor){
                $vendor = new Vendor();
                $em->persist($vendor);
            }
            $vendor->setQbSupplierId($qbid);
            $vendor->setCatalogrecords($dealer);
            $vendor->setCompanyName($supplier->getCompanyName());
            $vendor->setFirstName($supplier->getGivenName());
            $vendor->setLastName($supplier->getFamilyName());

            if($supplier->getPrimaryEmailAddr()){
                $vendor->setEmail($supplier->getPrimaryEmailAddr()->getAddress());
            }

            if($supplier->getPrimaryPhone()){
                $vendor->setHomePhone($supplier->getPrimaryPhone()->getFreeFormNumber());
            }

            if($supplier->getMobile()){
                $vendor->setMobilePhone($supplier->getMobile()->getFreeFormNumber());
            }

            if($supplier->getFax()){
                $vendor->setFax($supplier->getFax()->getFreeFormNumber());
            }

            if($supplier->getBillAddr()){
                $vendor->setCity($supplier->getBillAddr()->getCity());
                $vendor->setCountry($supplier->getBillAddr()->getCountry());
                $vendor->setZip($supplier->getBillAddr()->getPostalCode());
                $vendor->setState($supplier->getBillAddr()->getCountrySubDivisionCode());
                $vendor->setAddress($supplier->getBillAddr()->getLine1());
            }

            $vendor->setStatus(null);
        }

        $this->addFlash("success","All the suppliers from QuickBooks are imported to DMS");
        $em->flush();
        return $this->redirectToRoute('dms_quickbooks_suppliers');
    }

    public function dmsToQbVendorsAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $dealer = $this->get('numa.dms.user')->getSignedDealer();
        $vendors = $em->getRepository(Vendor::class)->findByDealerId($dealer->getId());
        foreach($vendors as $vendor){
            $vendor = $this->get("numa.dms.quickbooks")->dmsToQbVendor($vendor);
        }

        $this->addFlash("success","All the vendors from DMS are imported to QuickBooks");
        $em->flush();
        return $this->redirectToRoute('dms_quickbooks_suppliers');
    }


}
