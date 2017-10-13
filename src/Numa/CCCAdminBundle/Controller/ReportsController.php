<?php

namespace Numa\CCCAdminBundle\Controller;

use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\User;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\CCCAdminBundle\Entity\batchX;
use Numa\CCCAdminBundle\Form\batchXType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
//use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Configuration;
use Numa\CCCAdminBundle\Entity\Probills;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Process\Process;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use BG\BarcodeBundle\Util\Base1DBarcode as barCode;
use BG\BarcodeBundle\Util\Base2DBarcode as matrixCode;


/**
 * batchX controller.
 *
 */
class ReportsController extends Controller
{

    public function prepareData($probills)
    {
        $data = array();
        $temp = array();
        $temp2 = array();
        $tempCustomer = array();
        foreach ($probills as $probill) {
            $tempProbill = array();

            $tempProbill['waybill'] = $probill->getWaybill();
            $tempProbill['p_date'] = $probill->getPDate();

            $tempProbill['subitem'] = $probill->getSubItem();
            $tempProbill['ref'] = $probill->getRef();
            $tempProbill['PCE'] = $probill->getPCE();
            $tempProbill['WGT'] = $probill->getWGT();
            $tempProbill['shipper'] = $probill->getShipper();
            $tempProbill['receiver'] = $probill->getReceiver();
            $th = $probill->getTTimeH();
            $tm = $probill->getTTimeM();
            $tempProbill['time'] = (empty($th) ? "0" : $th) . ":" . (empty($tm) ? "0" : $tm);
            $tempProbill['signature'] = $probill->getSignature();
            $tempProbill['driver'] = $probill->getDriverCode();
            $tempProbill['vehicle_code'] = $probill->getVehcode();
            $tempProbill['FS'] = $probill->getCusSurchargeRate();
            $tempProbill['FSamt'] = $probill->getCustSurchargeAMT();
            $tempProbill['total'] = $probill->getTotal();
            $tempProbill['serv_type'] = $probill->getServType();
            $tempProbill['details'] = $probill->getDetails();
            $tempProbill['billtype'] = $probill->getBilltype();

            $d = $probill->getDept();
            $dept = empty($d) ? "   " : trim($probill->getDept());
            //$tempCustomer[$probill->getCustomerCode()][$probill->getBillType()][$dept]['probills'][] = $tempProbill;
            //$tempCustomer[$probill->getCustomerCode()][$probill->getBillType()][$dept]['probills'][$probill->getPDate()->format('Y-M-d')."-".$probill->getWaybill()."-".$probill->getSubItem()] = $tempProbill;
            $tempCustomer[$probill->getCustomerCode()][$probill->getBillType()][$dept]['probills'][$probill->getPDate()->format('Y-M-d') . "-" . $probill->getWaybill() . "-" . $probill->getSubItem() . "-" . $probill->getId()] = $tempProbill;


            $c = $probill->getCustomer();
            $customer = empty($c) ? "null" : $probill->getCustomer();
            $tempCustomer[$probill->getCustomerCode()]['name'] = $customer;
            $tempCustomer[$probill->getCustomerCode()]['custcode'] = $probill->getCustomerCode();
        }
        $customer = $this->get('security.token_storage')->getToken()->getUser();


        $totals = array();
        $temp2 = array();

        foreach ($tempCustomer as $custcode => $customer) {
            $temp = array();
            $totals[$custcode]['wgt'] = 0;
            $totals[$custcode]['pce'] = 0;
            $totals[$custcode]['total'] = 0;
            $totals[$custcode]['FSamt'] = 0;
            $ctyhwy = array('CTY', 'HWY');
            foreach ($ctyhwy as $billtype) {

                $totals[$custcode][$billtype]['pce'] = 0;
                $totals[$custcode][$billtype]['wgt'] = 0;
                $totals[$custcode][$billtype]['total'] = 0;
                $totals[$custcode][$billtype]['FSamt'] = 0;

                $temp = array();

                if (!empty($customer[$billtype])) {
                    foreach ($customer[$billtype] as $keyDept => $dept) {
                        $keyDept = (string)$keyDept . ":";

                        if (!empty($dept) && is_array($dept)) {
                            ksort($dept);
                            ksort($dept['probills']);
                        }
                        $temp[$keyDept] = $dept;


                        $fsAmt = 0;
                        $total = 0;
                        $pce = 0;
                        $wgt = 0;
                        $totals[$custcode][$billtype][$keyDept]['pce'] = $pce;
                        $totals[$custcode][$billtype][$keyDept]['wgt'] = $wgt;
                        $totals[$custcode][$billtype][$keyDept]['FSamt'] = $fsAmt;
                        $totals[$custcode][$billtype][$keyDept]['total'] = $total;
                        foreach ($dept['probills'] as $probill) {
                            $pce = $pce + $probill['PCE'];
                            $wgt = $wgt + $probill['WGT'];
                            $total = $total + $probill['total'];
                            $fsAmt = $fsAmt + $probill['FSamt'];
                        }
                        //totals by customer billtype and dept
                        $totals[$custcode][$billtype][$keyDept]['pce'] = $pce;
                        $totals[$custcode][$billtype][$keyDept]['wgt'] = $wgt;
                        $totals[$custcode][$billtype][$keyDept]['FSamt'] = $fsAmt;
                        $totals[$custcode][$billtype][$keyDept]['total'] = $total;

                        //totals by customer and billtype (CTY, HWY)
                        $totals[$custcode][$billtype]['pce'] = $totals[$custcode][$billtype]['pce'] + $pce;
                        $totals[$custcode][$billtype]['wgt'] = $totals[$custcode][$billtype]['wgt'] + $wgt;
                        $totals[$custcode][$billtype]['FSamt'] = $totals[$custcode][$billtype]['FSamt'] + $fsAmt;
                        $totals[$custcode][$billtype]['total'] = $totals[$custcode][$billtype]['total'] + $total;
                        //totals by customer
                        $totals[$custcode]['pce'] = $totals[$custcode]['pce'] + $totals[$custcode][$billtype][$keyDept]['pce'];
                        $totals[$custcode]['wgt'] = $totals[$custcode]['wgt'] + $totals[$custcode][$billtype][$keyDept]['wgt'];
                        $totals[$custcode]['total'] = $totals[$custcode]['total'] + $totals[$custcode][$billtype][$keyDept]['total'];
                        $totals[$custcode]['FSamt'] = $totals[$custcode]['FSamt'] + $totals[$custcode][$billtype][$keyDept]['FSamt'];
                    }
                    uksort($temp, "self::cmp");
                    $temp2[$custcode][$billtype] = $temp;
                }

                //die();
                $temp2[$custcode]['name'] = $customer['name'];
                $temp2[$custcode]['custcode'] = $custcode;
            }
        }

        return array('data' => $temp2, 'totals' => $totals);
    }

    /**
     *
     *
     */
    public function CustomerDetailsAction(Request $request, $batchid)
    {
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }
        $em = $this->getDoctrine()->getManager();
        $cc = 0;
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getIsAdmin()) {
            $cc = $user->getId();
        }

        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->getProbils($batchid, $cc);
        $data = $this->prepareData($probills);
        //dump($data);die();
        $path = $this->get('kernel')->getRootDir() . "/../web/";
        $html = $this->vView(
            'NumaCCCAdminBundle:reports:CustomerDetails.pdf.twig', array(
                'data' => $data['data'],
                'totals' => $data['totals'],
                'path' => $path,
                'custcode' => $cc,
            )
        );;

        return new Response(
            $html
        );
    }

    public function CustomerDetailsXslAction(Request $request, $batchid, $format = null, $stream = true)
    {
        // ask the service for a Excel5
        ///pdf renderer
        if (empty($format)) {
            $format = $request->attributes->get('format');
        }
        //die();
        $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mPDF';
        $rendererLibraryPath = dirname(__FILE__) . '/../../../libraries/PDF/' . $rendererLibrary;
        $rendererLibraryPath = '/var/ccc2/vendor/phpoffice/phpexcel/Classes/PHPExcel/Writer/PDF/tcPDF.php';
        ///var/ccc2/vendor/phpoffice/phpexcel/Classes/PHPExcel/Writer/PDF/mPDF.php
        //$rendererLibraryPath = '/var/ccc2/vendor/mpdf/mpdf/' . $rendererLibrary;
        $rendererLibraryPath = (dirname(__FILE__) . '/../../../../vendor/mpdf/mpdf'); //works

        if (!\PHPExcel_Settings::setPdfRenderer(
            $rendererName, $rendererLibraryPath
        )
        ) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                '<br />' .
                'at the top of this script as appropriate for your directory structure'
            );
        }
        //disable profiler
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }
        $em = $this->getDoctrine()->getManager();
        //get user
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if($user instanceof Customers) {
            $cc = $user->getIsAdmin() ? 0 : $user->getId();
        }elseif($user instanceof User){
            $cc=0;
        }
        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->getProbils($batchid, $cc);
        $data = $this->prepareData($probills);

        $download_path = $this->container->getParameter('download_excel_path');
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($download_path . 'CustomerDetailsReport.xls');
        //dump($phpExcelObject);
        $phpExcelObject->getProperties()->setCreator("Numa")
            ->setLastModifiedBy("Numa web App")
            ->setTitle("Customer Details Report")
            ->setSubject("Customer Details Report")
            ->setDescription("Customer Details Report");
        $phpExcelObject->setActiveSheetIndex(0);
        //count rows in excel
        $deptTotalRow = 0;
        /////// LOOP by Customer
        foreach ($data['data'] as $custKey => $cust) {
            $phpExcelObject->getActiveSheet()->setTitle("CUST" . $cust['custcode']);
            //customer info
            $phpExcelObject->getActiveSheet()
                ->setCellValue('B2', 'CUSTOMER: ' . $cust['name'])
                ->setCellValue('B3', 'Customer Code: ' . $cust['custcode'])
                ->setCellValue('W1', date('m/d/Y H:i'));
            //Loop by billtype hwy cty
            $countRows = 0;
            $startRow = 7;
            $deptTotalRow = $countRows + $startRow;
            $headerRow = 4;
            $copiedRows = $phpExcelObject->getActiveSheet()->rangeToArray('B' . $headerRow . ':Z' . ($headerRow + 1));

            $style2 = $phpExcelObject->getActiveSheet()->getStyle('B' . $headerRow);
            $style = $phpExcelObject->getActiveSheet()->getStyle('C' . ($headerRow + 1));

            $hasCTY = empty($cust['CTY']) ? false : true;
            $hasHWY = empty($cust['HWY']) ? false : true;
            $onlyCty = $hasCTY && !$hasHWY;
            $onlyHWY = $hasHWY && !$hasCTY;
            $bothHWYCTY = $hasCTY && $hasHWY;

            foreach (array('CTY', 'HWY') as $billtype) {
                //LOOP by dept

                $headerRow = $deptTotalRow - 3;
                if ($onlyHWY) {
                    $phpExcelObject->getActiveSheet()->setCellValue('B' . $headerRow, 'HiWay Details: ');
                }
                if (!empty($cust[$billtype])) {

                    if ($bothHWYCTY && $billtype == 'HWY') {
                        $addRows = 4;
                        $phpExcelObject->getActiveSheet()->insertNewRowBefore($deptTotalRow, $addRows);
                        $deptTotalRow += $addRows;
                        $headerRow += $addRows;
                        //dump($deptTotalRow);die();
                        $phpExcelObject->getActiveSheet()->fromArray($copiedRows, null, 'B' . ($headerRow));

                        $phpExcelObject->getActiveSheet()->mergeCells('B' . ($headerRow) . ':C' . ($headerRow));
                        $phpExcelObject->getActiveSheet()->mergeCells('F' . ($headerRow + 1) . ':H' . ($headerRow + 1));
                        $phpExcelObject->getActiveSheet()->mergeCells('I' . ($headerRow + 1) . ':J' . ($headerRow + 1));
                        $phpExcelObject->getActiveSheet()->mergeCells('L' . ($headerRow + 1) . ':M' . ($headerRow + 1));
                        $phpExcelObject->getActiveSheet()->mergeCells('T' . ($headerRow + 1) . ':U' . ($headerRow + 1));
                        $phpExcelObject->getActiveSheet()->mergeCells('X' . ($headerRow + 1) . ':Z' . ($headerRow + 1));
                        $phpExcelObject->getActiveSheet()->setCellValue('B' . ($headerRow), 'HiWay Details: ');
                        $phpExcelObject->getActiveSheet()->duplicateStyle($style, 'b' . ($headerRow + 1) . ':z' . ($headerRow + 1));
                        $phpExcelObject->getActiveSheet()->duplicateStyle($style2, 'b' . ($headerRow));
                    }


                    foreach ($cust[$billtype] as $deptKey => $dept) {
                        $deptKeyTrim = trim((string)$deptKey);
                        //check if dept is single and empty
                        if (count($cust[$billtype]) > 1 && !empty($deptKeyTrim)) {
                            $phpExcelObject->getActiveSheet()->insertNewRowBefore($deptTotalRow);
                            $phpExcelObject->getActiveSheet()->setCellValue('B' . ($deptTotalRow), 'Department: ' . $deptKey);
                            $phpExcelObject->getActiveSheet()->mergeCells("B" . ($deptTotalRow) . ":C" . ($deptTotalRow));
                            $deptTotalRow++;
                        }

                        //loop by probills in dept

                        foreach ($dept['probills'] as $probillKey => $probill) {
                            $pdate = $probill['p_date'];
                            //insert row by row
                            $phpExcelObject->getActiveSheet()
                                ->insertNewRowBefore($deptTotalRow)
                                ->setCellValue('B' . $deptTotalRow, $probill['waybill'])
                                ->setCellValue('C' . $deptTotalRow, $pdate instanceof \DateTime ? $pdate->format('m/d/Y') : "")
                                ->setCellValue('D' . $deptTotalRow, $probill['ref'])
                                ->setCellValue('E' . $deptTotalRow, $probill['PCE'])
                                ->setCellValue('F' . $deptTotalRow, $probill['WGT'])
                                ->setCellValue('I' . $deptTotalRow, $probill['shipper'])
                                ->setCellValue('K' . $deptTotalRow, $probill['receiver'])
                                ->setCellValue('L' . $deptTotalRow, $probill['time'])
                                ->setCellValue('N' . $deptTotalRow, $probill['signature'])
                                ->setCellValue('P' . $deptTotalRow, $probill['driver'])
                                ->setCellValue('Q' . $deptTotalRow, $probill['vehicle_code'])
                                ->setCellValue('R' . $deptTotalRow, $probill['FS'])
                                ->setCellValue('S' . $deptTotalRow, $probill['FSamt'])
                                ->setCellValue('U' . $deptTotalRow, $probill['total'])
                                ->setCellValue('W' . $deptTotalRow, $probill['serv_type'])
                                ->setCellValue('X' . $deptTotalRow, $probill['details']);
                            $phpExcelObject->getActiveSheet()->mergeCells("L" . $deptTotalRow . ":M" . $deptTotalRow);
                            $phpExcelObject->getActiveSheet()->mergeCells("X" . $deptTotalRow . ":Z" . $deptTotalRow);
                            $deptTotalRow++;
                        }
                        // totals by dept

                        if (count($cust[$billtype]) > 1 && !empty($deptKeyTrim)) {
                            $phpExcelObject->getActiveSheet()
                                ->insertNewRowBefore($deptTotalRow)
                                ->setCellValue('N' . $deptTotalRow, "Department Total:")
                                ->setCellValue('S' . $deptTotalRow, $data['totals'][$custKey][$billtype][$deptKey]['FSamt'])
                                ->setCellValue('U' . $deptTotalRow, $data['totals'][$custKey][$billtype][$deptKey]['total']);
                            $phpExcelObject->getActiveSheet()->mergeCells("N" . ($deptTotalRow) . ":R" . ($deptTotalRow));
                            $deptTotalRow++;
                        }
                    }
                }

                //total by customer billtype (HWY, CTY)
                if (!empty($data['totals'][$custKey][$billtype]['total']) && !empty($data['totals'][$custKey][$billtype]['FSamt'])) {
                    $phpExcelObject->getActiveSheet()->insertNewRowBefore($deptTotalRow);

                    $phpExcelObject->getActiveSheet()
                        ->setCellValue('S' . $deptTotalRow, $data['totals'][$custKey][$billtype]['FSamt'])
                        ->setCellValue('U' . $deptTotalRow, $data['totals'][$custKey][$billtype]['total'])
                        ->setCellValue('E' . $deptTotalRow, $data['totals'][$custKey][$billtype]['pce'])
                        ->setCellValue('F' . $deptTotalRow, $data['totals'][$custKey][$billtype]['wgt']);
                    //$deptTotalRow++;
                    $phpExcelObject->getActiveSheet()->mergeCells("B" . $deptTotalRow . ":D" . $deptTotalRow);
                    $phpExcelObject->getActiveSheet()->mergeCells("K" . $deptTotalRow . ":P" . $deptTotalRow);

                    if ($billtype == 'CTY') {
                        $phpExcelObject->getActiveSheet()->setCellValue("B" . $deptTotalRow, "City sub totals: ");
                        $phpExcelObject->getActiveSheet()->setCellValue("K" . $deptTotalRow, "City subtotal before tax: ");
                    } elseif ($billtype == 'HWY') {
                        $phpExcelObject->getActiveSheet()->setCellValue("B" . $deptTotalRow, "HiWay sub totals: ");
                        $phpExcelObject->getActiveSheet()->setCellValue("K" . $deptTotalRow, "HiWay subtotal before tax: ");
                    }
                    $deptTotalRow++;
                }
            }

            //$deptTotalRow--;
            $toremove = $deptTotalRow;

            //dump($deptTotalRow);die();
            $deptTotalRow++;
            $deptTotalRow++;
            $phpExcelObject->getActiveSheet()->setCellValue("T" . $deptTotalRow, $data['totals'][$custKey]['total']);
            $deptTotalRow++;
            $phpExcelObject->getActiveSheet()->setCellValue("T" . $deptTotalRow, $data['totals'][$custKey]['FSamt']);
            $phpExcelObject->getActiveSheet()->mergeCells('T' . $deptTotalRow . ':U' . $deptTotalRow);

            $deptTotalRow++;
            $phpExcelObject->getActiveSheet()->setCellValue("T" . $deptTotalRow, ($data['totals'][$custKey]['FSamt'] + $data['totals'][$custKey]['total']));
            $phpExcelObject->getActiveSheet()->removeRow($toremove,2);
        }
        //$phpExcelObject->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);
        if ($format == 'PDF') {
            // Redirect output to a client’s web browser (PDF)
            //
            $objWriter = $this->get('phpexcel')->createWriter($phpExcelObject, 'PDF');

            if (!$stream) {
                $objWriter->save($download_path . 'CustomerDetailsReport_' . $batchid . '_' . $user->getCustcode() . '.pdf');
            } else {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment;filename="CustomerDetailsReport_' . $batchid . ".pdf");
                header('Cache-Control: max-age=0');
                $objWriter->save('php://output');
                exit;
            }
        }
        //EXCELL format//
        // adding headers
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stream-file.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        //dump($download_path . 'CustomerDetailsReport_' . $batchid . 'xls');die();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $writer->save($download_path . 'CustomerDetailsReport_' . $batchid . '_' . $user->getCustcode() . '.xls');
        return $response;
    }

    static function cmp($a, $b)
    {
        if ($a == 'OOT' || $b == 'OOT') {
            if ($a == 'OOT') {
                return strcasecmp('ZZZ', $b);
            }
            if ($b == 'OOT') {
                return strcasecmp($a, 'ZZZZ');
            }
        }
        return strcasecmp($a, $b);
    }

    /**
     * INVOICE REPORT
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $batchid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function batchReportAction(Request $request, $batchid, $stream = true)
    {
        return $this->get('Numa.Controiller.Reports')->batchReportAction($batchid);
    }

    public function dispatchBolReportAction(Request $request, $dispatchcard)
    {
        // ask the service for a Excel5
        ///pdf renderer
        $format = $request->attributes->get('format');
        //die();
        $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mPDF';
        //$rendererLibraryPath = dirname(__FILE__) . '/../../../libraries/PDF/' . $rendererLibrary;
        //$rendererLibraryPath = '/var/ccc2/vendor/phpoffice/phpexcel/Classes/PHPExcel/Writer/PDF/tcPDF.php';
        ///var/ccc2/vendor/phpoffice/phpexcel/Classes/PHPExcel/Writer/PDF/mPDF.php
        //$rendererLibraryPath = '/var/ccc2/vendor/mpdf/mpdf/' . $rendererLibrary;
        $rendererLibraryPath = (dirname(__FILE__) . '/../../../../vendor/mpdf/mpdf'); //works

        if (!\PHPExcel_Settings::setPdfRenderer(
            $rendererName, $rendererLibraryPath
        )
        ) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                '<br />' .
                'at the top of this script as appropriate for your directory structure'
            );
        }
        //disable profiler
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }
        $em = $this->getDoctrine()->getManager();
        //get user
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cc = $user->getIsAdmin() ? 0 : $user->getId();


        $download_path = $this->container->getParameter('download_excel_path');
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($download_path . 'BOL.xls');
        //dump($phpExcelObject);
        $phpExcelObject->getProperties()->setCreator("Numa")
            ->setLastModifiedBy("Numa web App")
            ->setTitle("Customer Details Report")
            ->setSubject("Customer Details Report")
            ->setDescription("Customer Details Report");
        $phpExcelObject->setActiveSheetIndex(0);

        $dispatchCards = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->findOneBy(array('id' => $dispatchcard));
        $origin = $dispatchCards->getOrigin()->first();
        $destination = $dispatchCards->getDestination()->first();
        //dump($destination);die(0);
        $currentRow = 7;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getDateorder() instanceof \DateTime ? $dispatchCards->getDateorder()->format('m/d/Y') : "");
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, $dispatchCards->getId());
        $currentRow++;

        if ($dispatchCards->getCustomer()) {
            $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getCustomer()->getCustcode());
        }

        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getServType());
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, $dispatchCards->getPo());
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getCallInBuy());
        $currentRow++;
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $origin->getBuildingBusiness());
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, $origin->getDeliveryTime() instanceof \DateTime ? $origin->getDeliveryTime()->format('m/d/Y H:i') : "");
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $origin->getAddress());
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $origin->getContactPerson());
        $currentRow++;
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $destination->getBuildingBusiness());
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, $destination->getDeliveryTime() instanceof \DateTime ? $destination->getDeliveryTime()->format('m/d/Y H:i') : "");

        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $destination->getAddress());
        if ($destination->getVehicleType()) {
            $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, $destination->getVehicleType()->getVehdesc());
        }
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $destination->getContactPerson());
        $phpExcelObject->getActiveSheet()->setCellValue("K" . $currentRow, $destination->getPieces());
        $phpExcelObject->getActiveSheet()->setCellValue("M" . $currentRow, $destination->getWeight());
        $currentRow++;
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getCommodityInstruction());
        $currentRow++;
        $currentRow++;
        $phpExcelObject->getActiveSheet()->setCellValue("B" . $currentRow, $dispatchCards->getCodAmount());


        // adding headers
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stream-file.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $writer->save($download_path . 'CustomerDetailsReport_' . $dispatchcard . '.xls');

        return $response;
    }

    public function DispatchBOLPdfAction(Request $request, $dispatchcard)
    {
        $em = $this->getDoctrine()->getManager();
        $format = $request->attributes->get('format');
        //get all probills for the customer

        $path = $this->get('kernel')->getRootDir() . "/../web/";


        //if admin only
        $user = $this->get('security.token_storage')->getToken()->getUser();
        //$cc = $user->getIsAdmin();
        $double = true;

        $customers[] = $user;
        $dispatchEntity = $em->getRepository('NumaCCCAdminBundle:Dispatchcard')->find($dispatchcard);

        ////
        $myBarcode = new matrixCode();
        $myBarcode->savePath = $this->container->getParameter('barcode_path');
        //dump($myBarcode);die();
        $bcPathAbs = $myBarcode->getBarcodePNGPath($dispatchEntity->getId(), 'PDF417', 3, 3);


        $html = $this->renderView(
            'NumaCCCAdminBundle:reports:BOL.pdf.twig', array(
                'path' => $path,
                'dispatchcard' => $dispatchEntity,
                'barcode' => $bcPathAbs,
            )
        );
        if ($format == 'PDF') {
            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
                    'Content-Type' => 'application/pdf',
                )
            );
        } elseif ($format == 'HTML') {
            return new Response(
                $html
            );
        }
    }

    public function downloadAllAction(Request $request, $batchid)
    {
        $batch = intval($batchid);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $this->get("Numa.Controiller.Reports")->zipAll($batchid, array($user->getId()));
        $zipname = $this->get("Numa.Controiller.Reports")->getZipFilename($batchid, $user->getCustcode());

        $response = $this->forward('NumaCCCAdminBundle:Default:download', array(
            'filename' => $zipname,
            'folder' => $batchid,
        ));


        return $response;
    }

    public function CustomerDetailPdfAction($batchid)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        return $this->get('Numa.Controiller.Reports')->CustomerDetailsPdf($batchid, $user);
    }

    public function pendingDetailsAction(Request $request, $id)
    {
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }
        $em = $this->getDoctrine()->getManager();
        $cc = 0;


        $pending = $em->getRepository('NumaCCCAdminBundle:PendingProbill')->find($id);
        //dump($data);die();
        $html = $this->renderView(
            'NumaCCCAdminBundle:reports:pendingDetails.html.twig', array(
                'probill' => $pending
            )
        );;

        return new Response(
            $html
        );
    }

    public function compareFormAction(Request $request)
    {
        $action = 'report_compare_form';
        $em = $this->container->get('doctrine');
        $batches = $em->getRepository("NumaCCCAdminBundle:batchX")->findBy(array(), array("id" => "desc"));
        $batchesArray = array();
        foreach ($batches as $batch) {
            $batchesArray[$batch->getName()] = $batch->getId();
        }

        $form = $this->createFormBuilder(null, array('csrf_protection' => false))
            ->setAction($this->generateUrl($action))
            ->setMethod('GET')
            ->add('batch_1', ChoiceType::class, array('label' => 'Batch 1', 'choices' => $batchesArray,'choices_as_values' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Youtube video URL')))
            ->add('batch_2', ChoiceType::class, array('label' => 'Batch 2', 'choices' => $batchesArray,'choices_as_values' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Youtube video URL')))
            ->add('Compare HTML', SubmitType::class, array('label' => 'Comapre HTML', 'attr' => array('class' => 'btn btn-primary')))
            ->add('Compare PDF', SubmitType::class, array('label' => 'Comapare PDF', 'attr' => array('class' => 'btn btn-primary')))
            ->add('Compare Excel', SubmitType::class, array('label' => 'Comapare XLS', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        return $this->get('Numa.Controiller.Reports')->compareFormAction($request,$form);
    }

    public function compareAction()
    {
        return $this->render('NumaCCCAdminBundle:reports:compare.html.twig', array());
    }
}
