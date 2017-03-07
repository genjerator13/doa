<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\RelatedDoc;
use Numa\DOADMSBundle\Entity\Sale;
use Numa\DOADMSBundle\Entity\SaleRelatedDoc;
use Symfony\Component\HttpFoundation\File\File;

class SaleLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function createSaleByBilling(Billing $billing)
    {
//        dump($billing->getItem());die();
        if (!empty($billing->getSalePrice()) || !empty($billing->getWarranty()) || !empty($billing->getAdminFee()) || !empty($billing->getBankRegistrationFee()) || !empty($billing->getProtectionPkg()) || !empty($billing->getLifeInsurance()) || !empty($billing->getDisabilityInsurance()) || !empty($billing->getOtherMisc1()) || !empty($billing->getOtherMisc2()) || !empty($billing->getTaxt1Name()) || !empty($billing->getTaxt2Name()) || !empty($billing->getTaxt3Name()) || !empty($billing->getTax1()) || !empty($billing->getTax2()) || !empty($billing->getTax3()) || !empty($billing->getSalesPerson())) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            //check if vin exists already
            $item = $billing->getItem();
            if ($item instanceof Item) {
                $sale = $item->getSale();
//                dump($item->getSaleId());
                if (!$sale instanceof Sale) {
                    $sale = new Sale();
//                    $sale->setItem($item);
                    $em->persist($sale);
                }
                $sale->setSellingPrice($billing->getSalePrice());
                $sale->setWarranty1($billing->getWarranty());
                $sale->setAdminFees1($billing->getAdminFee());
                $sale->setDocFees1($billing->getBankRegistrationFee());
                $sale->setProtectPkg1($billing->getProtectionPkg());
                $sale->setLifeInsur($billing->getLifeInsurance());
                $sale->setDisabilityIns1($billing->getDisabilityInsurance());
                $sale->setTax1In($billing->getOtherMisc1());
                $sale->setTax2In($billing->getOtherMisc2());
                $sale->setOther1Des($billing->getTaxt1Name());
                $sale->setOther2Des($billing->getTaxt2Name());
                $sale->setOther3Des($billing->getTaxt3Name());
                $sale->setOther1($billing->getTax1());
                $sale->setOther2($billing->getTax2());
                $sale->setOther3($billing->getTax3());
                $sale->setSalesPerson($billing->getSalesPerson());

                $em->flush($sale);
                $item->setSaleId($sale->getId());
                $em->flush($item);
            }
        }
    }

    public function uploadRelatedDocs(Sale $sale, File $file, $upload_url, $upload_path)
    {
        $filename = $file->getClientOriginalName();

        //make a folder if not exists
        $dir = $upload_path.$sale->getId();

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        //prepare filename for the image
        $filename = $sale->getId() . "_" . $filename;
        $filename = str_replace(array(" ", '%'), "-", $filename);

        $dirandfile = $sale->getId()."/".$filename;

        //full path to the uploaded image
        $fullpathfile = $dir . "/" . $filename;

        $filemoved = $file->move($dir, $filename);
        if($filemoved instanceof File) {

            $em = $this->container->get('doctrine.orm.entity_manager');
            $relatedDoc = new RelatedDoc();
            $relatedDoc->setName($filename);
            $relatedDoc->setTitle($filename);
            $relatedDoc->setSrc($dirandfile);

            $saleRelatedDocs = new SaleRelatedDoc();
            $saleRelatedDocs->setSale($sale);
            $saleRelatedDocs->setRelatedDoc($relatedDoc);
            $em->persist($relatedDoc);
            $em->persist($saleRelatedDocs);
            $em->flush();
        }
    }

    public function deleteRelatedDoc(RelatedDoc $doc){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $file = $this->container->getParameter("related_docs_path").$doc->getSrc();

        if(file_exists($file)){
            unlink($file);
        }
        $em->remove($doc);
        $em->flush();
    }
}