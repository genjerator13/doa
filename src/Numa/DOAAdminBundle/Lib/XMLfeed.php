<?php
namespace Numa\DOAAdminBundle\Lib;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAware;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XMLfeed
 *
 * @author genjerator
 */
class XMLfeed extends ContainerAware{
    const URL = "Link-URL";
    const XML = "XML";
    var $XMLproperties = array();
    public function __construct($id) {
        
    }
    public function getFeed($id) {
        $em = \Numa\DOAAdminBundle\NumaDOAAdminBundle::getContainer()->get('doctrine')->getEntityManager('default'); 
        $entity = $em->getRepository('NumaDOAAdminBundle:Importfeed')->findOneById(3);;
        $source = $entity->getImportSource();
        
        $category = $entity->getCategory();

        if (self::URL == $entity->getImportMethod()) {
            if (self::XML == $entity->getImportFormat()) {
                $source = 'c:\work\DOA\feeds.asp.xml';
                $f = fopen($source, 'r');
                
                $xml_obj = simplexml_load_file($source);
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
    
    public function getXMLproperties($id)
    {
        if(empty($this->XMLproperties)){
            $this->getFeed($id);
        }
        return $this->XMLproperties;
    }
}
