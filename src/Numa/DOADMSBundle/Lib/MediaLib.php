<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


use mikehaertl\pdftk\Pdf;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\BillingDoc;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Util\containerTrait;
use Symfony\Component\HttpFoundation\Response;

class MediaLib
{
    use containerTrait;

    public function addMedia()
    {

    }

    public function addFillablePdf()
    {

    }

    public function showMedia(Media $media)
    {
        $templating = $this->container->get("templating");
        //dump("AAAA");die();
        $html = $templating->render('NumaDOADMSBundle:Media:media.pdf.twig', array(
            'media' => $media,
        ));

        return $html;
    }

    public function addMediaFromFile($filename)
    {

        if (file_exists($filename)) {

            $em = $this->em;
            $media = $em->getRepository(Media::class)->findOneBy(array("name" => basename($filename)));
            if (!$media instanceof Media) {
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

    public function addFillablePdfFromFile($filename, $state)
    {
        if (file_exists($filename)) {
            $em = $this->em;
            $media = $this->addMediaFromFile($filename);
            $fillablePdf = $em->getRepository(FillablePdf::class)->findOneBy(array("name" => $media->getName()));
            if (!$fillablePdf instanceof FillablePdf) {
                $fillablePdf = new FillablePdf();
                $em->persist($fillablePdf);
            }
            $fillablePdf->setMedia($media);
            $fillablePdf->setName($media->getName());
            $fillablePdf->setState($state);

            $em->flush();
            return $fillablePdf;
        }
        return false;
    }

    public function deleteFillablePdf(FillablePdf $fillablePdf)
    {
        $em = $this->em;
        $billingDocs = $em->getRepository(FillablePdf::class)->deleteFillablePdf($fillablePdf);


        return $fillablePdf;

    }

    public function parseAllFillablePdf(){
        $em = $this->em;
        $fillablePdfs = $em->getRepository(FillablePdf::class)->findAll();
        dump(count($fillablePdfs));
        foreach($fillablePdfs as $pdf){
            $this->parseFillablePdf($pdf);
        }
    }

    public function parseFillablePdf(FillablePdf $fpdf){
        $em = $this->em;

        $tmpfile = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmpfile, base64_decode($fpdf->getMedia()->getContent()));
        $pdf = new Pdf($tmpfile);

        $fillablePdfdata = $pdf->getDataFields();
        foreach($fillablePdfdata as $field){

            $fillablePdfField = $em->getRepository(fillablePdfField::class)->findOneBy(array("FillablePdf"=>$fpdf,"name"=>$field['FieldName']));
            if(!$fillablePdfField instanceof FillablePdfField){
                $fillablePdfField = new FillablePdfField();
                $em->persist($fillablePdfField);
            }

            $fillablePdfField->setFillablePdf($fpdf);
            $fillablePdfField->setName($field['FieldName']);
            $fillablePdfField->setType($field['FieldType']);

        }
        $em->flush();

    }


    public function renderTermConditions(Billing $billing)
    {
        $templating = $this->container->get("templating");
        $dealer = $billing->getDealer();
        $html = $templating->render("NumaDOADMSBundle:Billing:terms.html.twig",
            array(
                'dealer' => $dealer,
            )
        );

        //$mpdf = new \mPDF("", "A4", 0, "", 5, 5, 10, 5);
        $mpdf = new \Mpdf\Mpdf(array('format' => 'A4', "margin_left" => 5, "margin_right" => 5, "margin_top" => 3, "margin_bottom" => 3));
        $mpdf->shrink_tables_to_fit = 1;
        //$mpdf->useOnlyCoreFonts = true;    // false is default

        $mpdf->SetTitle("Bill of Sale");
        $mpdf->SetAuthor($dealer->getName());
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        $tmpfile = sys_get_temp_dir() . "/terms_" . $dealer->getId() . '.pdf';
        $mpdf->Output($tmpfile, 'F');
        return $tmpfile;
    }

    public function renderOriginalBillOfSale(Billing $billing, $billingTemplate, $billingTemplateName)
    {
        $templating = $this->container->get("templating");


        //$billingTemplate = $this->container->get('numa.settings')->getStripped('billing_template', array(), $billing->getDealer());
        $html = $templating->render(
            $billingTemplate,
            array('billing' => $billing,
                'id' => $billing->getId(),
                'customer' => $billing->getCustomer(),
                'dealer' => $billing->getDealer(),
                'item' => $billing->getItem(),
                'template' => $billingTemplateName)
        );


        //$mpdf = new \mPDF("", "A4", 0, "", 5, 5, 10, 5);
        $mpdf = new \Mpdf\Mpdf(array('format' => 'A4', "margin_left" => 5, "margin_right" => 5, "margin_top" => 3, "margin_bottom" => 3));
        $mpdf->shrink_tables_to_fit = 1;
        //$mpdf->useOnlyCoreFonts = true;    // false is default

        $mpdf->SetTitle("Bill of Sale");
        $mpdf->SetAuthor($billing->getDealer()->getName());
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);
        $tmpfile = sys_get_temp_dir() . "/bos_" . $billing->getId() . '.pdf';
        $mpdf->Output($tmpfile, 'F');
        return $tmpfile;
    }

    public function renderBillingDocs(Billing $billing)
    {
        $em = $this->em;
        $billingDocs = $em->getRepository(BillingDoc::class)->findBy(array("Billing" => $billing));
        $ret = array();
        foreach ($billingDocs as $bc) {
            $pdf = $this->renderFillablePdf($billing, $bc->getFillablePdf());
            $ret[] = $pdf;
        }
        return $ret;
    }

    public function renderFillablePdf(Billing $billing, FillablePdf $fillablePdf)
    {
        $fillablePdfFields = $fillablePdf->getFillablePdfField();

        $tmpfile = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmpfile, base64_decode($fillablePdf->getMedia()->getContent()));
        $pdf = new Pdf($tmpfile);
        $args = array();
        foreach ($fillablePdfFields as $field) {
            if ($field instanceof FillablePdfField)
                $billingFieldValue = $this->globalmapBillingFieldFillable($billing, $field);

            if ($billingFieldValue instanceof \DateTime) {
                $billingFieldValue = $billingFieldValue->format("Y-m-d");
            }
            $args[$field->getName()] = $billingFieldValue;

            $pdf->fillForm($args)->flatten();
            $pdf->needAppearances();
        }
        return $pdf;
    }

    public function globalmapBillingFieldFillable(Billing $billing, FillablePdfField $fillablePdfField)
    {
        $billingFieldName = $fillablePdfField->getBillingFieldName();
        $splitName = explode("+", $billingFieldName);


        if (count($splitName) > 1) {
            $sum = 0;
            foreach ($splitName as $name) {
                $one = floatval($this->mapBillingFieldWithFillable($billing, $name));

                $sum += $one;
            }

            $sum = number_format($sum, 2);

            return $sum;
        }
        return $this->mapBillingFieldWithFillable($billing, $splitName[0]);
    }

    public function mapBillingFieldWithFillable(Billing $billing, $billingFieldName)
    {
        $functionValue = "";
        //$billingFieldName = $name;

        $splitName = explode(":", $billingFieldName);
        if (empty($billingFieldName)) {
            return "";
        }
        if (count($splitName) > 1) {
            $item = $billing->getItem();
            $dealer = $billing->getDealer();
            $customer = $billing->getCustomer();
            $splitName2 = explode("-", $splitName[1]);
            $functionName = $splitName[1];
            $args = array();
            if (!empty($splitName2[1])) {
                $functionName = $splitName2[0];
                $args = array("number" => $splitName2[1]);
            }

            if (strtolower($splitName[0]) == "item") {
                if ($item instanceof Item) {

                    $function = $this->getContainer()->get("numa.dms.listing")->asFunction($functionName);
                    if (method_exists($item, $function)) {
                        $functionValue = $item->{$function}();

                        //return $functionValue;
                    }
                }
            } elseif (strtolower($splitName[0]) == "customer") {

                if ($customer instanceof Customer) {
                    $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($functionName));
                    $functionValue = "";
                    if (method_exists($customer, $function)) {
                        $functionValue = $customer->{$function}();

                    }

                    //return $functionValue;
                }
            } elseif (strtolower($splitName[0]) == "dealer") {
                if ($dealer instanceof Catalogrecords) {
                    $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($functionName));
                    $functionValue = "";

                    if (method_exists($dealer, $function)) {
                        $functionValue = $dealer->{$function}();

                    }

                    //return $functionValue;
                }
            } elseif (strtolower($splitName[0]) == "text") {
                return $splitName[1];
            } elseif (strtolower($splitName[0]) == "billing") {

                $function = 'get' . str_ireplace(array(" ", "_"), '', ucfirst($functionName));
                $functionValue = "";
                if (method_exists($billing, $function)) {
                    $functionValue = $billing->{$function}();
                }

            }
        }
        if (!empty($splitName[2]) && strtoupper($splitName[2]) == 'MONEY') {

            $functionValue = number_format($functionValue, 2);

        }
        if (!empty($splitName[2]) && strtoupper($splitName[2]) == 'NEGATIVE') {

            $functionValue = -1 * $functionValue;

        }
        if (!empty($splitName[2]) && strtoupper($splitName[2]) == 'Y') {
            if ($functionValue instanceof \DateTime) {
                $functionValue = $functionValue->format("Y");
            }

        }
        if (!empty($splitName[2]) && strtoupper($splitName[2]) == 'M') {
            if ($functionValue instanceof \DateTime) {
                $functionValue = $functionValue->format("m");
            }
        }
        if (!empty($splitName[2]) && strtoupper($splitName[2]) == 'D') {
            if ($functionValue instanceof \DateTime) {
                $functionValue = $functionValue->format("d");
            }
        }
        if (!empty($args['number'])) {
            return substr(strval($functionValue), $args['number'] - 1, 1);
        }


        return $functionValue;
    }


    public function printBGuide(Item $item)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $bguideEntity = $em->getRepository(FillablePdf::class)->find(11);
        $pdf = $this->fillBuyersGuide($bguideEntity, $item);
        return $pdf;
    }

    public function printFillablePdf(FillablePdf $fpdf)
    {
        $html = $this->showMedia($fpdf->getMedia());
        return new Response($html);
    }

    public function fillBuyersGuide(FillablePdf $fillablePdf, Item $item)
    {
        $tmpfile = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmpfile, base64_decode($fillablePdf->getMedia()->getContent()));
        $pdf = new Pdf($tmpfile);
        $args = array();
        $dealer = $item->getDealer();

        $args['Make'] = $item->getMake();
        $args['Model'] = $item->getModel();
        $args['Year'] = $item->getModel();
        $args['Vin'] = $item->getVIN();
        $args['DealerName'] = $dealer->getName();
        $args['DealerAddress'] = $dealer->getAddress();
        $args['DealerCity'] = $dealer->getCity();
        $args['DealerState'] = $dealer->getState();
        $args['DealerZip'] = $dealer->getZip();
        $args['StockNumber'] = $item->getStockNr();
        //$args['Salesperson'] = $dealer->sal

        $pdf->fillForm($args)->flatten();
        $pdf->needAppearances();

        return $pdf;
    }
}