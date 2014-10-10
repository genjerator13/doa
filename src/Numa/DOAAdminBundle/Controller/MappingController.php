<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Mapping controller.
 *
 */
class MappingController extends Controller {

    const URL = "Link-URL";
    const XML = "XML";
    const CSV = "CSV";

    var $XMLproperties = array();
    var $properties = array();

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('NumaDOAAdminBundle:Mapping:index.html.twig');
    }

    public function mappingAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entityImportFeed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);
        $this->getXMLFeed($entityImportFeed);
        $query = $em->createQuery(
                'SELECT lf FROM NumaDOAAdminBundle:Listingfield lf WHERE lf.category_sid  in (0,11)');
        //$listingFields = $entityImportFeed->getListingFields();
        $listingFiellds = $query->getArrayResult();
        if (!$entityImportFeed) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        return $this->render('NumaDOAAdminBundle:Mapping:index.html.twig', array(
                    'entity' => $entityImportFeed,
                    'properties' => $this->properties,
                    'dbProperties' => $listingFiellds,
        ));
    }

    public function getXMLFeed(\Numa\DOAAdminBundle\Entity\Importfeed $entity) {
        $source = $entity->getImportSource();
        $category = $entity->getCategory();
        if (self::URL == $entity->getImportMethod()) {
            if (self::XML == $entity->getImportFormat()) {
                $xml_obj = simplexml_load_file($entity->getImportSource());
                foreach ($xml_obj->children() as $child) {
                    if (empty($this->properties)) {
                        foreach ($child->children() as $property) {
                            $this->properties[$property->getName()] = $property->getName();
                        }
                        break;
                    }
                }
            }
        }elseif (self::CSV == $entity->getImportFormat()) {
            $row = fgetcsv($entity->getImportSource());
            //set the properties from header
            foreach ($row as $hCell) {
                $this->properties[$hCell] = $hCell;
            }
        }
    }

    public function getCSVFeed(\Numa\DOAAdminBundle\Entity\Importfeed $entity) {
        $source = $entity->getImportSource();
        $category = $entity->getCategory();
        //if (self::URL == $entity->getImportMethod()) {
        $res = array();
        if (self::CSV == $entity->getImportFormat()) {
            //get the first row from the CSV
            $row = fgetcsv($entity->getImportSource());
            //set the properties from header
            foreach ($row as $hCell) {
                $this->properties[$hCell] = $hCell;
            }
        }
        //}
    }

}
