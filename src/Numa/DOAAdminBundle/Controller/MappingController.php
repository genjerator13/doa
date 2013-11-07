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
    var $XMLproperties =array();
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('NumaDOAAdminBundle:Mapping:index.html.twig');
    }

    public function mappingAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $entityImportFeed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($id);
        $this->getFeed($entityImportFeed);
        $query = $em->createQuery(
            'SELECT lf FROM NumaDOAAdminBundle:Listingfield lf WHERE lf.category_sid  in (0,11)');
        //$listingFields = $entityImportFeed->getListingFields();
        $listingFiellds = $query->getArrayResult();
        if (!$entityImportFeed) {
            throw $this->createNotFoundException('Unable to find Importfeed entity.');
        }

        return $this->render('NumaDOAAdminBundle:Mapping:index.html.twig', array(
                    'entity' => $entityImportFeed,
                    'XMLproperties' => $this->XMLproperties,
                    'dbProperties' => $listingFiellds,
        ));
    }

    public function getFeed(\Numa\DOAAdminBundle\Entity\Importfeed $entity) {
        $source = $entity->getImportSource();
        $category = $entity->getCategory();
        if (self::URL == $entity->getImportMethod()) {
            if (self::XML == $entity->getImportFormat()) {
                $xml_obj = simplexml_load_file($entity->getImportSource());
                foreach ($xml_obj->children() as $child) {
                    if(empty($this->XMLproperties)){
                        foreach($child->children() as $property){
                            $this->XMLproperties[$property->getName()] =$property->getName();
                        }
                        break;
                    }
                }
            }
        }
    }

}