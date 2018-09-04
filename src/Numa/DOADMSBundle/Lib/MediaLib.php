<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


use mikehaertl\pdftk\Pdf;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\BillingDoc;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Util\containerTrait;

class MediaLib
{
    use containerTrait;

    public function addMedia(){

    }

    public function addFillablePdf(){

    }

    public function showMedia(Media $media)
    {
        $templating = $this->container->get("templating");
        //dump("AAAA");die();
        return $templating->render('NumaDOADMSBundle:Media:media.pdf.twig', array(
            'media' => $media,
        ));
    }

    public function addMediaFromFile($filename){

        if(file_exists($filename)) {

            $em = $this->em;
            $media = $em->getRepository(Media::class)->findOneBy(array("name"=>basename($filename)));
            if(!$media instanceof Media) {
                $media = new Media();
                $em->persist($media);
            }
            $media->setName(basename($filename));
            $media->setMimetype(mime_content_type($filename));
            $content = file_get_contents($filename);
            $media->setContent(base64_encode($content));

            $em->flush();
            return $media;
        }

        return false;
    }

    public function addFillablePdfFromFile($filename){
        if(file_exists($filename)) {
            $em = $this->em;
            $media = $this->addMediaFromFile($filename);
            $fillablePdf = $em->getRepository(FillablePdf::class)->findOneBy(array("name"=>$media->getName()));
            if(!$fillablePdf instanceof FillablePdf) {
                $fillablePdf = new FillablePdf();
                $em->persist($fillablePdf);
            }
            $fillablePdf->setMedia($media);
            $fillablePdf->setName($media->getName());

            $em->flush();
            return $fillablePdf;
        }
        return false;
    }
    public function renderBillingDocs(Billing $billing){
        $em = $this->em;
        $billingDocs = $em->getRepository(BillingDoc::class)->findBy(array("Billing"=>$billing));
        $ret = array();
        foreach($billingDocs as $bc){
            $pdf = $this->renderFillablePdf($billing, $bc->getFillablePdf());
            $ret[]=$pdf;
        }
        return $ret;
    }
    public function renderFillablePdf(Billing $billing, FillablePdf $fillablePdf){
        $fillablePdfFields = $fillablePdf->getFillablePdfField();

        $tmpfile = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmpfile, base64_decode($fillablePdf->getMedia()->getContent()));
        $pdf = new Pdf($tmpfile);
        $args=array();
        foreach($fillablePdfFields as $field){
            if($field instanceof FillablePdfField)
            $billingFieldValue = $this->mapBillingFieldWithFillable($billing,$field);
            $args[$field->getName()]=$billingFieldValue;

        }


        $pdf->fillForm($args)->flatten();
        $pdf->needAppearances();
        //$pdf->saveAs($tmpfile);
        return $pdf;
        die();
    }

    public function mapBillingFieldWithFillable(Billing $billing, FillablePdfField $fillablePdfField){
        $item=$billing->getItem();
        $billingFieldName = $fillablePdfField->getBillingFieldName();

        $splitName = explode(":", $billingFieldName);

        if (count($splitName) > 1) {
            if (strtolower($splitName[0]) == "item") {
                if ($item instanceof Item) {
                    $splitName2 = explode("-", $splitName[1]);
                    $functionName = $splitName[1];
                    $args=array();
                    if(!empty($splitName2[1])){
                        $functionName = $splitName2[0];
                        $args=array("number"=>$splitName2[1]);
                    }
                    $function = $this->getContainer()->get("numa.dms.listing")->asFunction($functionName);
                    if (method_exists($item, $function)) {
                        $functionValue = $item->{$function}();
                        if(!empty($args['number'])){
                            return substr(strval($functionValue),$args['number']-1,1);
                        }
                        return $functionValue;
                    }
                }
            }
        }
        return "";
    }



}