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
use Numa\DOADMSBundle\Entity\Vendor;
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
        if (!$billing->getActive()) {
            return false;
        }
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
                $sale->setTradeIn($billing->getLessTradeIn());
                $sale->setAcValue($billing->getAcValue());
                $sale->setAsPrice($billing->getAsPrice());
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
                $totalRevenue = $billing->getAsPrice() - $billing->getAcValue() + $billing->getWarranty() +
                                $billing->getLifeInsurance() + $billing->getDisabilityInsurance() +
                                $billing->getAdminFee() + $billing->getBankRegistrationFee() +
                                $billing->getProtectionPkg() + $billing->getLifeInsurance() +
                                $billing->getOtherMisc1() +
                                $billing->getOtherMisc2() + $billing->getTax1() + $billing->getTax2() +
                                $billing->getTax3();
//Revenue This Unit = Total Revenue minus Total Sale Cost
                //$revenueThisUnit = $totalRevenue-
                //Net Gain = ASP Value minus Total Unit Cost
                $sale->setNetGain($sale->getAsPrice() - $sale->getTotalUnitCost());
                $sale->setTotalRevenue($totalRevenue);
                $sale->setRevenueThisUnit($totalRevenue-($sale->getTotalUnitCost()+$sale->getTotalSaleCost()));
                $em->flush($sale);
                $item->setSaleId($sale->getId());
                $em->flush($item);
            }
        }
    }

    public function setListingSoldIfActive(Billing $billing)
    {
        if (!empty($billing->getItem())) {
            $item = $billing->getItem();
            $item->addBilling($billing);
            if ($billing->getItem() instanceof Item && $billing->getActive()) {
                $em = $this->container->get('doctrine.orm.entity_manager');

                $billing->getItem()->setSold(true);
                $billing->getItem()->setSoldDate(new \DateTime());
                $billing->getItem()->setActive(false);
                $em->flush();
            }
        }

    }

    public function uploadRelatedDocs(Sale $sale, File $file, $upload_url, $upload_path)
    {
        $filename = $file->getClientOriginalName();

        //make a folder if not exists
        $dir = $upload_path . $sale->getId();

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        //prepare filename for the image
        $filename = $sale->getId() . "_" . $filename;
        $filename = str_replace(array(" ", '%'), "-", $filename);

        $dirandfile = $sale->getId() . "/" . $filename;

        //full path to the uploaded image
        $fullpathfile = $dir . "/" . $filename;

        $filemoved = $file->move($dir, $filename);
        if ($filemoved instanceof File) {

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

    public function deleteRelatedDoc(RelatedDoc $doc)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $file = $this->container->getParameter("related_docs_path") . $doc->getSrc();

        if (file_exists($file)) {
            unlink($file);
        }
        $em->remove($doc);
        $em->flush();
    }

    public function getAllVendors(Item $item, $withoutVehicle = false)
    {
        $sale = $item->getSale();
        $byVendors = array();
        if ($sale instanceof Sale) {
            //vehvendor
            $vehVendor = $sale->getVendor();
            if (!$vehVendor instanceof Vendor) {
                return false;
            }

            if (!$withoutVehicle) {
                $temp = array();
                $temp['vendor'] = $vehVendor;
                $temp['property'] = "vehicle";
                $temp['docnum'] = "i_" . $item->getId();
                $temp['title'] = $this->container->get("numa.dms.listing")->getListingTitle($item);
                //qb get item from QB by title

                $temp['description'] = $this->container->get("numa.dms.quickbooks.item")->getQBItemDesc($item);
                $temp['amount'] = $this->container->get("numa.dms.quickbooks.item")->getQBItemPrice($item);
                $temp['sku'] = $item->getVIN();
                $qbExpenseAccountSetting = $this->container->get("numa.settings")->getValue2("Inventory", $item->getDealer());
                $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue3("Inventory", $item->getDealer());
                $qbAssetAccountSetting = $this->container->get("numa.settings")->getValue4("Inventory", $item->getDealer());
                $temp['ExpenseAccount'] = $qbExpenseAccountSetting;
                //qb get ea from QB by title
                $temp['IncomeAccount'] = $qbIncomeAccountSetting;
                //qb get ia from QB by title
                $temp['AssetAccount'] = $qbAssetAccountSetting;
                //qb get aa from QB by title

                $temp['qbVendor'] = $this->container->get('numa.dms.quickbooks.vendor')->dmsToQbVendor($vehVendor);
                $temp['qbItem'] = $this->container->get("numa.dms.quickbooks.item")->findQBItemBySku($item->getVIN());
                $temp['qbExpenseAccount'] = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbExpenseAccountSetting);
                $temp['qbIncomeAccount'] = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbIncomeAccountSetting);
                $temp['qbAssetAccount'] = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbAssetAccountSetting);

                //qb
                $byVendors[$vehVendor->getId()][] = $temp;
            }
            $class_methods = get_class_methods(Sale::class);
            $output = array_filter($class_methods, function ($f) {
                return stripos($f, "get") === 0 && stripos($f, "vendorid") > 0 && $f != "getVendorId";
            });
            $props = array();

            foreach ($output as $vendorF) {

                $temp = array();
                //$prop = str_replace("get","",$vendorF);
                $prop = str_replace("VendorId", "", $vendorF);
                $propname = str_replace("get", "", $prop);
                $descF = "getDesc" . $propname;

                $vendorId = $sale->{$vendorF}();
                $amount = $sale->{$prop}();
                if (method_exists($sale, $descF)) {
                    $desc = $sale->{$descF}();
                }

                if (!empty($vendorId)) {
                    $em = $this->container->get('doctrine.orm.entity_manager');

                    $vendor = $em->getRepository(Vendor::class)->find($vendorId);
                    if ($vendor instanceof Vendor) {

                        $temp['vendor'] = $vendor;
                        $temp['amount'] = $amount;
                        $temp['property'] = $prop;
                        $temp['title'] = $propname;
                        $temp['sku'] = "";
                        $temp['docnum'] = "c_" . $item->getId() . "_" . $propname;
                        $qbExpenseAccountSetting = $this->container->get("numa.settings")->getValue2($propname);
                        $qbIncomeAccountSetting = $this->container->get("numa.settings")->getValue3($propname);
                        $qbAssetAccountSetting = $this->container->get("numa.settings")->getValue4($propname);

//                        $qbAPAccountSetting   = $this->container->get("numa.settings")->getValue5($prop);

                        $temp['ExpenseAccount'] = $qbExpenseAccountSetting;
                        $temp['IncomeAccount'] = $qbIncomeAccountSetting;
                        $temp['AssetAccount'] = $qbAssetAccountSetting;
                        $temp['description'] = $this->container->get("numa.dms.quickbooks.item")->getQBItemDesc($item);

                        $temp['qbItem'] = $this->container->get("numa.dms.quickbooks.item")->findQBItemBySku($item->getVIN());
                        $temp['qbExpenseAccount'] = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbExpenseAccountSetting);
                        $temp['qbIncomeAccount'] = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbIncomeAccountSetting);
                        $temp['qbAssetAccount'] = $this->container->get("numa.dms.quickbooks.account")->getAccount($qbAssetAccountSetting);
                        $temp['qbVendor'] = $this->container->get('numa.dms.quickbooks.vendor')->dmsToQbVendor($vendor);
                        if (method_exists($sale, $descF)) {
                            $desc = $sale->{$descF}();
                            $temp['description'] = $desc;
                        }

                        $byVendors[][] = $temp;
                    }
                }
                $props[$prop] = $temp;

            }

        }

        return $byVendors;
    }

}