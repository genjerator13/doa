<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of services
 *
 * @author genjerator
 */

namespace Numa\CCCAdminBundle\Lib;


use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class Services
{
    use ContainerAwareTrait;
    protected $container;

    const CUST_REPORT = 'CustomerDetailsReport';
    const CUST_INVOICE = 'CustomerInvoiceReport';

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * INVOICE REPORT
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $batchid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function batchReportAction($batchid, $stream = true, $user = null)
    {

        $em = $this->container->get('doctrine');
        //get all probills for the customer
        $path = $this->container->get('kernel')->getRootDir() . "/../web/";
        //if admin only

        if (!$user) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        if (is_array($user)) {
            if (!empty($user[0])) {
                $user = $em->getRepository('NumaCCCAdminBundle:Customers')->find($user[0]);
            }
        } elseif (is_numeric($user)) {
            if (!empty(intval($user))) {
                $user = $em->getRepository('NumaCCCAdminBundle:Customers')->find(intval($user));
            }
        }

        $templating = $this->container->get('templating');

        $double = true;

        if ($user->getIsAdmin()) {
            $customers = $em->getRepository('NumaCCCAdminBundle:Probills')->findAllCustomersInBatch($batchid);
        } else {
            $customers[] = $user;
            $double = false;
        }

        $html = $templating->render(
            'NumaCCCAdminBundle:reports:headerPdf.pdf.twig', array(
                'path' => $path
            )
        );

        foreach ($customers as $key => $customer) {

            $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->findAllByCustomer($customer, $batchid)->getResult();
            $totals = $em->getRepository('NumaCCCAdminBundle:Probills')->getTotals($probills, $customer->getDiscount());
            $batch = $em->getRepository('NumaCCCAdminBundle:batchX')->find($batchid);
//            dump($totals);
//            dump($customer);die();
            $html .= $templating->render(
                'NumaCCCAdminBundle:reports:fullReportContent.pdf.twig', array(
                    'probills' => $totals,
                    'customer' => $customer,
                    'batch' => $batch,
                    'double' => $double,
                    'path' => $path,
                )
            );
        }

        $html .= $templating->render(
            'NumaCCCAdminBundle:reports:footerPdf.pdf.twig'
        );

        $download_path = $this->container->getParameter('download_excel_path');
        //dump($download_path . 'CustomerInvoiceReport_' . $batchid .'_'.$user->getCustcode(). '.pdf');
        //die();

        $filename = 'CustomerInvoiceReport_' . $batchid . '_' . $user->getCustcode() . '.pdf';

        $filelocation = $download_path . $filename;
        $outputType = "html";
        if (!$stream) {
            $alreadyThere = $this->container->get('knp_snappy.pdf')->generateFromHtml($html, $filelocation, array(), true);
        } else {
            if ($outputType == 'html') {
                return new Response(
                    $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                    )
                );
            } else {
                return new Response($html);
            }

        }
    }

    public function CustomerDetailsXslAction($batchid, $user, $format = null, $stream = true)
    {
        // ask the service for a Excel5
        ///pdf renderer
//        if (empty($format)) {
//            $format = $request->attributes->get('format');
//        }
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
        $em = $this->container->get('doctrine');

        //get user
        //$user = $this->container->get('security.context')->getToken()->getUser();
        //$cc = $user->getIsAdmin() ? 0 : $user->getId();

        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->getProbils($batchid, $user);

        $data = $this->prepareData($probills);

        $download_path = $this->container->getParameter('download_excel_path');

        $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject($download_path . 'CustomerDetailsReport.xls');

        //dump($phpExcelObject);
        $phpExcelObject->getProperties()->setCreator("Numa")
            ->setLastModifiedBy("Numa web App")
            ->setTitle("Customer Details Report")
            ->setSubject("Customer Details Report")
            ->setDescription("Customer Details Report");
        $phpExcelObject->setActiveSheetIndex(0);
        $activeSheet = $phpExcelObject->getActiveSheet();
        //count rows in excel
        $deptTotalRow = 0;
        /////// LOOP by Customer
        //dump($data['data']);
        //array_intersect_key($data['data'], array("CAME"=>1,"CUST"=>1,"CREDU"=>1)));
        //die();

        $customers = $em->getRepository('NumaCCCAdminBundle:Customers')->findById($user);
        $intersectArray = array();
        foreach ($customers as $custa) {
            $intersectArray[$custa->getCustcode()] = 1;
        }

        $dataData = array_intersect_key($data['data'], $intersectArray);

        foreach ($dataData as $custKey => $cust) {
            $activeSheet->setTitle("CUST" . $cust['custcode']);
            //customer info
            $activeSheet
                ->setCellValue('B2', 'CUSTOMER: ' . $cust['name'])
                ->setCellValue('B3', 'Customer Code: ' . $cust['custcode'])
                ->setCellValue('W1', date('m/d/Y H:i'));
            //Loop by billtype hwy cty
            $countRows = 0;
            $startRow = 7;
            $deptTotalRow = $countRows + $startRow;
            $headerRow = 4;
            $copiedRows = $activeSheet->rangeToArray('B' . $headerRow . ':Z' . ($headerRow + 1));

            $style2 = $activeSheet->getStyle('B' . $headerRow);
            $style = $activeSheet->getStyle('C' . ($headerRow + 1));

            $hasCTY = empty($cust['CTY']) ? false : true;
            $hasHWY = empty($cust['HWY']) ? false : true;
            $onlyCty = $hasCTY && !$hasHWY;
            $onlyHWY = $hasHWY && !$hasCTY;
            $bothHWYCTY = $hasCTY && $hasHWY;

            foreach (array('CTY', 'HWY') as $billtype) {
                //LOOP by dept

                $headerRow = $deptTotalRow - 3;
                if ($onlyHWY) {
                    $activeSheet->setCellValue('B' . $headerRow, 'HiWay Details: ');
                }
                if (!empty($cust[$billtype])) {

                    if ($bothHWYCTY && $billtype == 'HWY') {
                        $addRows = 4;
                        $activeSheet->insertNewRowBefore($deptTotalRow, $addRows);
                        $deptTotalRow += $addRows;
                        $headerRow += $addRows;
                        //dump($deptTotalRow);die();
                        $activeSheet->fromArray($copiedRows, null, 'B' . ($headerRow));

                        $activeSheet->mergeCells('B' . ($headerRow) . ':C' . ($headerRow));
                        $activeSheet->mergeCells('F' . ($headerRow + 1) . ':H' . ($headerRow + 1));
                        $activeSheet->mergeCells('I' . ($headerRow + 1) . ':J' . ($headerRow + 1));
                        $activeSheet->mergeCells('L' . ($headerRow + 1) . ':M' . ($headerRow + 1));
                        $activeSheet->mergeCells('T' . ($headerRow + 1) . ':U' . ($headerRow + 1));
                        $activeSheet->mergeCells('X' . ($headerRow + 1) . ':Z' . ($headerRow + 1));
                        $activeSheet->setCellValue('B' . ($headerRow), 'HiWay Details: ');
                        $activeSheet->duplicateStyle($style, 'b' . ($headerRow + 1) . ':z' . ($headerRow + 1));
                        $activeSheet->duplicateStyle($style2, 'b' . ($headerRow));
                    }


                    foreach ($cust[$billtype] as $deptKey => $dept) {
                        $deptKeyTrim = trim((string)$deptKey);
                        //check if dept is single and empty
                        if (count($cust[$billtype]) > 1 && !empty($deptKeyTrim)) {
                            $activeSheet->insertNewRowBefore($deptTotalRow);
                            $activeSheet->setCellValue('B' . ($deptTotalRow), 'Department: ' . $deptKey);
                            $activeSheet->mergeCells("B" . ($deptTotalRow) . ":C" . ($deptTotalRow));
                            $deptTotalRow++;
                        }

                        //loop by probills in dept

                        foreach ($dept['probills'] as $probillKey => $probill) {
                            $pdate = $probill['p_date'];
                            //insert row by row
                            $activeSheet
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
                            $activeSheet->mergeCells("L" . $deptTotalRow . ":M" . $deptTotalRow);
                            $activeSheet->mergeCells("X" . $deptTotalRow . ":Z" . $deptTotalRow);
                            $deptTotalRow++;
                        }
                        // totals by dept

                        if (count($cust[$billtype]) > 1 && !empty($deptKeyTrim)) {
                            $activeSheet
                                ->insertNewRowBefore($deptTotalRow)
                                ->setCellValue('N' . $deptTotalRow, "Department Total:")
                                ->setCellValue('S' . $deptTotalRow, $data['totals'][$custKey][$billtype][$deptKey]['FSamt'])
                                ->setCellValue('U' . $deptTotalRow, $data['totals'][$custKey][$billtype][$deptKey]['total']);
                            $activeSheet->mergeCells("N" . ($deptTotalRow) . ":R" . ($deptTotalRow));
                            $deptTotalRow++;
                        }
                    }
                }

                //total by customer billtype (HWY, CTY)
                if (!empty($data['totals'][$custKey][$billtype]['total']) && !empty($data['totals'][$custKey][$billtype]['FSamt'])) {
                    $activeSheet->insertNewRowBefore($deptTotalRow);

                    $activeSheet
                        ->setCellValue('S' . $deptTotalRow, $data['totals'][$custKey][$billtype]['FSamt'])
                        ->setCellValue('U' . $deptTotalRow, $data['totals'][$custKey][$billtype]['total'])
                        ->setCellValue('E' . $deptTotalRow, $data['totals'][$custKey][$billtype]['pce'])
                        ->setCellValue('F' . $deptTotalRow, $data['totals'][$custKey][$billtype]['wgt']);
                    //$deptTotalRow++;
                    $activeSheet->mergeCells("B" . $deptTotalRow . ":D" . $deptTotalRow);
                    $activeSheet->mergeCells("K" . $deptTotalRow . ":P" . $deptTotalRow);

                    if ($billtype == 'CTY') {
                        $activeSheet->setCellValue("B" . $deptTotalRow, "City sub totals: ");
                        $activeSheet->setCellValue("K" . $deptTotalRow, "City subtotal before tax: ");
                    } elseif ($billtype == 'HWY') {
                        $activeSheet->setCellValue("B" . $deptTotalRow, "HiWay sub totals: ");
                        $activeSheet->setCellValue("K" . $deptTotalRow, "HiWay subtotal before tax: ");
                    }
                    $deptTotalRow++;
                }
            }

            $deptTotalRow--;
            $activeSheet->removeRow($deptTotalRow, 2);
            $deptTotalRow++;
            $activeSheet->setCellValue("T" . $deptTotalRow, $data['totals'][$custKey]['total']);
            $deptTotalRow++;
            $activeSheet->setCellValue("T" . $deptTotalRow, $data['totals'][$custKey]['FSamt']);
            $activeSheet->mergeCells('T' . $deptTotalRow . ':U' . $deptTotalRow);

            $deptTotalRow++;
            $activeSheet->setCellValue("T" . $deptTotalRow, ($data['totals'][$custKey]['FSamt'] + $data['totals'][$custKey]['total']));
            //$phpExcelObject->getActiveSheet()->duplicateStyle($style, 'B' . ($headerRow + 3) . ':Z' . ($headerRow + 3));

            if ($format == 'PDF') {
                // Redirect output to a client’s web browser (PDF)
                //
                $objWriter = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'PDF');

                if (!$stream) {
                    //$objWriter->save($download_path . 'CustomerDetailsReport_' . $batchid . '_' . $cust['custcode'] . '.pdf');
                    $objWriter->save($this->getReportFile(self::CUST_REPORT, $batchid, $cust['custcode'], $format));
                } else {
//                    header('Content-Type: application/pdf');
//                    header('Content-Disposition: attachment;filename="CustomerDetailsReport_' . $batchid . ".pdf");
//                    header('Cache-Control: max-age=0');
//                    $objWriter->save('php://output');
//                    exit;
                }//die();
            } else if ($format == 'XLS') {
                //EXCELL format//
                // adding headers
                // create the writer
                $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');

                $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');

                //$writer->save($download_path . 'CustomerDetailsReport_' . $batchid . '_' . $cust['custcode'] . '.xls');
                $writer->save($this->getReportFile(self::CUST_REPORT, $batchid, $cust['custcode'], $format));
            }

        }
    }

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
        //$customer = $this->container->get('security.context')->getToken()->getUser();


        $totals = array();
        $temp2 = array();

        foreach ($tempCustomer as $custcode => $customer) {

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
     *
     * @param type $batchid -
     * @param type mixed $users if integer
     * @return type
     */
    public function zipAll($batchid, $user)
    {
        $em = $this->container->get('doctrine');
        $logger = $this->container->get('logger');
        $batch = intval($batchid);
        $logger->warning("zipAll");
        $customer = $em->getRepository('NumaCCCAdminBundle:Customers')->findOneById($user);
        $filename = $this->getZipPath($batchid, $customer->getCustcode());
        $zipFolder = $this->getZipFolder($batchid, $customer->getCustcode());
        $logger->warning("zipAll:" . $zipFolder);
        if (file_exists($filename)) {
            $logger->warning("zipAll:file_exists" . $filename);
            return;
        }

//        if (is_int($users)) {
//            $userid = $users->getId();
//        } elseif (is_array($users)) {
//            
//        }
        //generate the reports
        $logger->warning("batchReportAction" . $batchid);
        $this->batchReportAction($batchid, false, $user);
        $logger->warning("CustomerDetailsXslAction XSL" . $batchid . ":::" . $this->getInvoiceReport($batchid, $customer->getCustcode()));
        $this->CustomerDetailsXslAction($batchid, $user, "XLS", false);

        $logger->warning("getReportFile" . $batchid . ":" . $customer->getCustcode());
        $pdf = $this->getReportFile(self::CUST_REPORT, $batchid, $customer->getCustcode(), 'PDF');

        $this->CustomerDetailsPdf($batchid, $user, $pdf);
        $logger->warning("CustomerDetailsPdf" . $batchid . ":" . $customer->getCustcode());
        $logger->warning($pdf);
        //$download_path = $this->container->getParameter('download_excel_path');
        //$upload_path = $this->container->getParameter('upload');

        //get filepath
        //foreach ($users as $user) {


        $xls = $this->getReportFile(self::CUST_REPORT, $batchid, $customer->getCustcode(), 'XLS');
        $logger->warning("XSL" . $xls);
        $logger->warning("PDF" . $pdf);

        $invoice = $this->getReportFile(self::CUST_INVOICE, $batchid, $customer->getCustcode(), 'PDF');

        $logger->warning("invoice" . $invoice);
        $newsletter = $this->getNewsletterFile($batchid);
        $logger->warning("newsletter" . $newsletter);

//        dump($xls);
//        dump($pdf);
//        dump($invoice);
//        dump($newsletter);


        //create zip archive

        $zip = new \ZipArchive();

        if (!file_exists($zipFolder)) {
            $logger->warning("creating the zip folder: " . $zipFolder);
            mkdir($zipFolder, 0777, true);
        }
        $test = $zip->open($filename, \ZipArchive::CREATE);
        $logger->warning("opening the zip fiolename: " . $filename);
        if ($test !== TRUE) {
            $logger->error("cannot open the fiolename: " . $filename);
            exit("cannot open <$filename>\n");

        }

        //$zip->addFile($xls, 'excelReport.xls');
        if (file_exists($xls)) {
            $logger->warning("adding XSL to zipe: " . $xls);
            $zip->addFile($xls, 'ExcelDetailReport.xls');
        }
        if (file_exists($pdf)) {
            $logger->warning("adding PDF to zipe: " . $pdf);
            $zip->addFile($pdf, 'PdfDetailReport.pdf');
        }


        if (file_exists($invoice)) {

            $logger->warning("adding invoiceReport to zipe: " . $invoice);
            $zip->addFile($invoice, 'PdfInvoice.pdf');
        }
        if (file_exists($newsletter)) {
            $logger->warning("adding newsletter to zipe: " . $invoice);
            $zip->addFile($newsletter, 'newsletter.pdf');
        }
        //}
        $logger->warning("save zip: " . $invoice);
        $zip->close();

    }

    public function getReportFile($reportname, $batchid, $userid, $format)
    {
        $download_path = $this->container->getParameter('download_excel_path');
        $filename = $download_path . $reportname . '_' . $batchid . '_' . $userid . '.' . strtolower($format);
        return $filename;
    }

    public function getNewsletterFile($batchid)
    {
        $upload_path = $this->container->getParameter('upload');
        $filename = $upload_path . $batchid . '/newsletter.pdf';
        return $filename;
    }


    public function getZipPath($batchid, $custcode)
    {
        $upload_path = $this->container->getParameter('upload');
        $zipname = $this->getZipFilename($batchid, $custcode);
        $filename = $upload_path . $batchid . "/" . $zipname;
        return $filename;
    }

    public function getZipFolder($batchid, $custcode)
    {
        $upload_path = $this->container->getParameter('upload');

        $filename = $upload_path . $batchid;
        return $filename;
    }

    public function getZipFilename($batchid, $custcode)
    {
        $zipname = "reports" . "_" . $batchid . "_" . $custcode . ".zip";
        return $zipname;
    }

    public function renderSwiftMessage(\Swift_Message $message, $attachment = "")
    {
        $templating = $this->container->get('templating');
        $html = $this->container->get('templating')->render(
            'NumaCCCAdminBundle:Email:testEmail.html.twig', array(
                'email' => $message,
                'attachment' => $attachment
            )
        );

        return $html;
    }

    public function getReportXLS($batchid, $custcode)
    {
        return $this->getReportFile(self::CUST_REPORT, $batchid, $custcode, "XLS");
    }

    public function getReportPDF($batchid, $custcode)
    {
        return $this->getReportFile(self::CUST_REPORT, $batchid, $custcode, "PDF");
    }

    public function getInvoiceReport($batchid, $custcode)
    {
        return $this->getReportFile(self::CUST_INVOICE, $batchid, $custcode, "PDF");
    }

    public function CustomerDetailsPdf($batchid, $user, $savetoFile = "")
    {
        //disable profiler
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }
        $em = $this->container->get('doctrine');
        $templating = $this->container->get('templating');

        //get user
        //$user = $this->container->get('security.context')->getToken()->getUser();
        //$cc = $user->getIsAdmin() ? 0 : $user->getId();

        $probills = $em->getRepository('NumaCCCAdminBundle:Probills')->getProbils($batchid, $user);
        $data = $this->prepareData($probills);

        $customers = $em->getRepository('NumaCCCAdminBundle:Customers')->findById($user);
        $vehtypes = $em->getRepository('NumaCCCAdminBundle:Vehtypes')->findBy(array('active' => 1));
        $intersectArray = array();
        foreach ($customers as $custa) {
            $intersectArray[$custa->getCustcode()] = 1;
        }

        //$dataData = array_intersect_key($data['data'], $intersectArray);
        //$mpdf = new \mPDF();
        $mpdf = new \mPDF('c', 'letter-L');

        $mpdf->useOnlyCoreFonts = true;    // false is default
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Customer Details Report");
        $mpdf->SetAuthor("Custom Courier Co.");
        $mpdf->SetDisplayMode('fullpage');
        $format = 'pdf';
        //dump($data['data']);die();
        $html = $templating->render(
            'NumaCCCAdminBundle:reports:CustomerDetails2.pdf.twig', array(
                'data' => $data['data'],
                'totals' => $data['totals'],
                'vehTypes' => $vehtypes,
                'title' => "CUSTOMER SUMMARY REPORT",
//                'path' => "CUSTOMER SUMMARY REPORT",
//                'custcode' => $cc,
            )
        );
        if ($format == 'pdf') {

            if (!$savetoFile) {
                $mpdf->WriteHTML($html);
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment;filename="CustomerDetailsReport_' . $batchid . ".pdf");
                header('Cache-Control: max-age=0');
                $mpdf->Output();
                exit;
            } else {
                $mpdf->WriteHTML($html);
                $mpdf->Output($savetoFile, 'F');
                return;
            }

        } else {
            //dump($html); die();
            return new Response($html);
        }

    }

    public function pendingProbillPdf($pendingId)
    {
        //disable profiler
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }
        $em = $this->container->get('doctrine');
        $templating = $this->container->get('templating');

        //get user
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //$cc = $user->getIsAdmin() ? 0 : $user->getId();

        $pendingP = $em->getRepository('NumaCCCAdminBundle:PendingProbill')->findById($pendingId);
        $data = $this->prepareData($pendingP);
        //dump($data);die();


        $customers = $em->getRepository('NumaCCCAdminBundle:Customers')->findById($user);
        $vehtypes = $em->getRepository('NumaCCCAdminBundle:Vehtypes')->findBy(array('active' => 1));
        $intersectArray = array();
        foreach ($customers as $custa) {
            $intersectArray[$custa->getCustcode()] = 1;
        }

        $dataData = array_intersect_key($data['data'], $intersectArray);
        $mpdf = new \mPDF();
        $mpdf = new \mPDF('c', 'letter-L');

        $mpdf->useOnlyCoreFonts = true;    // false is default
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Customer Details Report");
        $mpdf->SetAuthor("Custom Courier Co.");
        $mpdf->SetDisplayMode('fullpage');
        $format = 'pdf';
        //dump($data['data']);die();
        $html = $templating->render(
            'NumaCCCAdminBundle:reports:CustomerDetails2.pdf.twig', array(
                'data' => $data['data'],
                'totals' => $data['totals'],
                'vehTypes' => $vehtypes,
                'title' => "Pending (nonbilled) Probill Report ",
//                'custcode' => $cc,
            )
        );
        if ($format == 'pdf') {

            $mpdf->WriteHTML($html);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="CustomerDetailsReport_' . $batchid . ".pdf");
            header('Cache-Control: max-age=0');
            $mpdf->Output();
            exit;


        } else {
            //dump($html); die();
            return new Response($html);
        }

    }

    public function compareFormAction(Request $request, $form)
    {


        $em = $this->container->get('doctrine');
        $templating = $this->container->get('templating');
        $format="";

        $form->handleRequest($request);

        if ($form->isValid()) {

            if (isset($request->query->all()['form']['Compare PDF'])) {

                $format = "PDF";
            } elseif(isset($request->query->all()['form']['Compare Excel'])) {
                $format = "XLS";
            }



            $batch1Id = intval($form->getData()['batch_1']);
            $batch2Id = intval($form->getData()['batch_2']);

            $batch1 = $em->getRepository("NumaCCCAdminBundle:batchX")->find($batch1Id);
            $batch2 = $em->getRepository("NumaCCCAdminBundle:batchX")->find($batch2Id);
            if (empty($batch1) || empty($batch2)) {
                throw $this->createNotFoundException("One of the batches has not been found!!!");
            }
            //$probills = $em->getRepository("NumaCCCAdminBundle:batchX")->getProbills($batch1Id,$batch2Id);
            $probills1 = $em->getRepository("NumaCCCAdminBundle:batchX")->prepareComparisionData($batch1Id);
            $probills2 = $em->getRepository("NumaCCCAdminBundle:batchX")->prepareComparisionData($batch2Id);
            $customers = $em->getRepository("NumaCCCAdminBundle:batchX")->prepareComparisionCustomers($batch1Id, $batch2Id);


            $mpdf = new \mPDF('c', 'letter-L');

            $mpdf->useOnlyCoreFonts = true;    // false is default
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Customer Details Report");
            $mpdf->SetAuthor("Custom Courier Co.");
            $mpdf->SetDisplayMode('fullpage');


            if ($format == 'PDF') {
                $html = $templating->render('NumaCCCAdminBundle:reports:compare.pdf.twig', array(
                    'customers' => $customers,
                    'batch1' => $batch1,
                    'batch2' => $batch2,
                    'format' => $format
                ));

                $savetoFile = false;
                if (!$savetoFile) {
                    $mpdf->WriteHTML($html);
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="CustomerDetailsReport.pdf"');
                    header('Cache - Control: max - age = 0');
                    $mpdf->Output();
                    exit;
                } else {
                    $mpdf->WriteHTML($html);
                    $mpdf->Output($savetoFile, 'F');
                    exit;
                }


            }if ($format == 'XLS') {

                $download_path = $this->container->getParameter('download_excel_path');

                $phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();

                //dump($phpExcelObject);
                $phpExcelObject->getProperties()->setCreator("Numa")
                    ->setLastModifiedBy("Numa web App")
                    ->setTitle("Customer Details Report")
                    ->setSubject("Customer Details Report")
                    ->setDescription("Customer Details Report");
                $phpExcelObject->setActiveSheetIndex(0);
                $activeSheet = $phpExcelObject->getActiveSheet();
                $activeSheet->mergeCells('A1:E1');
                $activeSheet
                    ->setCellValue('A1', 'Batch # '.$batch1->getName())
                    ->setCellValue('F1', 'Batch # '.$batch2->getName());
                $activeSheet
                    ->setCellValue('A2', 'Cust Name')
                    ->setCellValue('B2', 'Cust Code')
                    ->setCellValue('C2', 'Work Days')
                    ->setCellValue('D2', 'Gross Total')
                    ->setCellValue('E2', 'Daily Average')
                    ->setCellValue('F2', 'Work Days')
                    ->setCellValue('G2', 'Gross Total')
                    ->setCellValue('H2', 'Daily Average');
                $row=3;
                $activeSheet->getColumnDimension('A')->setWidth(50);
                $activeSheet
                    ->getStyle('C3:H10000')
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet
                    ->getStyle('B3:B10000')
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $styleBlueArray = array(
                    'font'  => array(
//                        'bold'  => true,
                        'color' => array('rgb' => 'ffffff'),
//                        'size'  => 15,
                        'name'  => 'Verdana'
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '1E90FF')
                    )

                );

                $styleOrangeArray = array(
                    'font'  => array(
                        'color' => array('rgb' => 'ffffff'),
                        'name'  => 'Verdana'
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'F5871F')
                    )

                );

                $styleBlueTextArray = array(
                    'font'  => array(
                        'color' => array('rgb' => '1E90FF'),
                        'name'  => 'Verdana'
                    ),

                );

                $styleOrangeTextArray = array(
                    'font'  => array(
                        'color' => array('rgb' => 'ff0000'),
                        'name'  => 'Verdana'
                    )

                );

                $activeSheet->getStyle('A1:E2')->applyFromArray($styleBlueArray);
                $activeSheet->getStyle('F1:H2')->applyFromArray($styleOrangeArray);


                for($i=1;$i<=4;$i++) {
                    foreach ($customers[$i] as $custcode=>$cust) {


                        $total1=0;
                        $total2=0;

                        if(!empty($cust[1])){
                            $total1=$cust[1][0]['total'];
                        }

                        if(!empty($cust[2])){
                            $total2=$cust[2][0]['total'];
                        }
                        if(!empty($cust[1])){
                            $activeSheet->setCellValue('A'.$row, $cust[1][0]['Name']);
                        }elseif(!empty($cust[2])){
                            $activeSheet->setCellValue('A'.$row, $cust[2][0]['Name']);
                        }

                        //{% if i<3 %}{% if total1>total2 %}orange{% elseif total1<total2 %}blue{% endif %}{% endif %}

                        if($i<3){
                            if($total1>$total2){
                                $activeSheet->getStyle('A'.$row)->applyFromArray($styleOrangeTextArray);
                            }elseif($total1<$total2){
                                $activeSheet->getStyle('A'.$row)->applyFromArray($styleBlueTextArray);
                            }
                        }


                        $activeSheet->setCellValue('B'.$row, $custcode);
                        if(!empty($cust[1])){
                            $activeSheet->setCellValue('C'.$row, $cust[1][0]['working_days']);
                        }
                        if(!empty($cust[1])){
                            $activeSheet->setCellValue('D'.$row, sprintf("$ %.2f", $cust[1][0]['total']));
                        }
                        if(!empty($cust[1])){
                            $activeSheet->setCellValue('E'.$row, sprintf("$ %.2f", $cust[1][0]['average']));
                        }
                        if(!empty($cust[2])){
                            $activeSheet->setCellValue('F'.$row, sprintf("$ %.2f", $cust[2][0]['working_days']));
                        }
                        if(!empty($cust[2])){
                            $activeSheet->setCellValue('G'.$row, sprintf("$ %.2f", $cust[2][0]['total']));
                            //{% if cust[1][0]['average']>cust[2][0]['average'] %}
                            if($cust[1][0]['average']>$cust[2][0]['average']){
                                $activeSheet->getStyle('G'.$row)->applyFromArray($styleOrangeTextArray);
                            }else{
                                $activeSheet->getStyle('G'.$row)->applyFromArray($styleBlueTextArray);
                            }

                        }
                        if(!empty($cust[2])){
                            $activeSheet->setCellValue('H'.$row, sprintf("$ %.2f", $cust[2][0]['average']));
                        }
                        $row++;
                    }
                }

                //EXCELL format//
                // adding headers
                // create the writer
                $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');



                $writer->save($download_path . 'compareReport.xls');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="CompareReport.xls"');
                header('Cache-Control: max-age=0');

                //$objWriter = PHPExcel_IOFactory::createWriter($phpExcelObject, 'Excel2007');
                $writer->save('php://output');
                exit;


            }else {
                $html = $templating->render('NumaCCCAdminBundle:reports:compare.html.twig', array(
                    'customers' => $customers,
                    'batch1' => $batch1,
                    'batch2' => $batch2,
                    'format' => $format
                ));
                return new Response(
                    $html
                );
            }

        }

//        return $templating->render('NumaCCCAdminBundle:reports:compare_form.html.twig', array(
//            'form' => $form->createView()
//        ));
        return new Response(
            $templating->render('NumaCCCAdminBundle:reports:compare_form.html.twig', array(
                'form' => $form->createView()
            ))
        );

    }

}
