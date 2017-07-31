<?php
namespace Numa\DOASettingsBundle\Util;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOASettingsBundle\Entity\Setting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;

class SettingsQBLib
{
    /**
     * @var EntityManager
     */
    protected $em;
    protected $container;
    /**
     * @var EntityRepository
     */
    protected $repo;
    protected $properties = array(
        "Inventory",
        "Delivery",
        "Clean up",
        "Class",
        "Mechanical1",
        "Mechanical2",
        "Other exp 1",
        "Other exp 2",
        "Other exp 3",
        "Other exp 4",
        "Other exp 5",
        "Sold for",
        "Trade in",
        "Warranty",
        "Life Insururance",
        "Disability Ins",
        "Doc Fees",
        "Admin Fees",
        "Protect PKG",
        "Insurance",
        "Bank commis",
        "Other 1",
        "Other 2",
        "Other 3",
        "Protect pkg",
        "Disability ins",
        "Reserve",
        "Misc 1",
        "Misc 2",
        "Misc 3",
        "Sale Comms",
        );

    public function __construct(EntityManager $em, Container $container)
    {
        $this->container = $container;
        $this->em = $em;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = null;
    }

    public function insertQBSettings(Catalogrecords $dealer)
    {
        foreach($this->properties as $property){
            $this->insertQBSettingsEntity($dealer,$property);
        }
    }

    public function insertQBSettingsEntity(Catalogrecords $dealer, $property)
    {
        //check if the property already exists
        $setting = $this->container->get("numa.settings")->getSettingsEntity($property,$dealer);
        if(!$setting instanceof Setting){

            $this->container->get("numa.settings")->set($property,"","QB",$dealer);
        }

    }

}