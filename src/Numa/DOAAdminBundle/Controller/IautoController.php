<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Form\ImportfeedType;
use Numa\DOAAdminBundle\Entity\Item;

/**
 * Importfeed controller.
 *
 */
class IautoController extends Controller
{

    /**
     * Lists all Importfeed entities.
     *
     */
    public $map = array();

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('NumaDOAAdminBundle:CommandLog')->findLastCommandLog(100);
        return $this->render('NumaDOAAdminBundle:CommandLog:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function importAction(Request $request, $folder)
    {
        $em = $this->getDoctrine()->getManager();

        //load folder web/iauto/folder
        ///load file data_export.csv
        $upload_path = $this->container->getParameter('upload_path');
        $upload_url = $this->container->getParameter('upload_url');
        $iautoFolder = $this->container->getParameter('iauto') . "/" . $folder;
        $iautoImagesFolder = $iautoFolder;
        $tmp = array();
        $res = array();
        $importedItems = array();
        $filename = "export_data.csv";
        if (($handle = fopen($iautoFolder . "/" . $filename, "r")) !== FALSE) {
            $rowCount = 0;
            $map = $this->mapColumns($folder);

            while (($row = fgetcsv($handle)) !== FALSE) {
                //var_dump($row); // process the row.
                if ($rowCount > 0) {
                    foreach ($header as $key => $value) {
                        $tmp[$value] = $row[$key];
                    }
                    $res[] = $tmp;
                } else {
                    $header = $row;
                }
                $rowCount++;
            }
        }


        foreach ($res as $key => $value) {

            $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneBy(array('sid' => $value['id']));

            if (!$item instanceof \Numa\DOAAdminBundle\Entity\Item) {
                $item = new item();
                $em->persist($item);
            }
            foreach ($item->getItemField() as $key => $itemField) {
                $em->remove($itemField);
            }
            foreach ($value as $cellname => $cell) {
                $mapValue = $map[$cellname];

                if (stripos($mapValue, '(bool)') !== false) {
                    //$map = str
                    $fieldname = substr($mapValue, 6);
                    if (!empty($fieldname) && !empty($mapValue)) {
                        $itemField = new \Numa\DOAAdminBundle\Entity\ItemField();
                        $valuexxx = false;
                        if ($cell == "true") {
                            $valuexxx = true;
                        }
                        $itemField->setFieldType('boolean');
                        $itemField->setFieldName($fieldname);
                        $itemField->setAllValues($valuexxx);

                        $item->addItemField($itemField);

                        unset($itemField);
                    }
                } elseif ($mapValue == "category") {
                    $category = $em->getRepository('NumaDOAAdminBundle:Category')->findOneBy(array('name' => $value['category']));
                    if ($category instanceof \Numa\DOAAdminBundle\Entity\Category) {
                        $item->setCategory($category);
                    }
                } elseif ($mapValue == "pictures") {
                    $pictures = explode(";", $cell);
                    foreach ($pictures as $order => $picture) {
                        if (!empty($picture)) {
                            $itemField = new \Numa\DOAAdminBundle\Entity\ItemField();
                            $picture = $iautoImagesFolder . "/" . $picture;
                            $itemField->handleImage($picture, $upload_path, $upload_url, "item" . $item->getSid(), $order, true, $item->getSid());
                            $item->addItemField($itemField);
                            unset($itemField);
                        }
                    }
                } elseif ($mapValue == "dealerId") {
                    $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($cell);
                    if ($dealer instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
                        $item->setDealer($dealer);
                    }

                } elseif ($mapValue == "OptionsList") {
                    $cell = strip_tags($cell, "<br>");
                    $cell = str_replace("Features", "", $cell);
                    $cell = trim(str_replace("Options (included)", "", $cell));
                    $cell = preg_replace("/[\r\n]+/", "", $cell);
                    $cell = preg_replace('/[\x00-\x1F\x7F]/', '', $cell);
                    $item->processOptionsList($cell, "<br />");
                } else {
                    $item->setField($mapValue, $cell);
                }
            }
            $importedItems[] = $item;
        }
        $em->flush();

        return $this->render('NumaDOAAdminBundle:Importmapping:fetch.html.twig', array('items' => $importedItems));
    }

    public function mapColumns($folder)
    {
        $em = $this->getDoctrine()->getManager();

        //load folder web/iauto/folder
        ///load file data_export.csv

        $res = array();
        $filename = "iautomap.csv";
        if (($handle = fopen($this->container->getParameter('iauto') . "/" . $folder . "/" . $filename, "r")) !== FALSE) {
            $rowCount = 0;
            $tmp = array();
            $row = fgetcsv($handle);
            $row2 = fgetcsv($handle);
            foreach ($row as $key => $value) {
                $this->map[$value] = $row2[$key];
            }
        }

        return $this->map;
    }

}
