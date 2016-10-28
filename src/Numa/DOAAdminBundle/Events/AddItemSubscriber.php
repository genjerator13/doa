<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Numa\Form\AutocompleteType;

class AddItemSubscriber implements EventSubscriberInterface
{

    protected $em;
    protected $securityContext;
    protected $dealerID;
    protected $category;
    protected $container;

    public function __construct($em, $securityContext, $dealerID, $category)
    {
        $this->em = $em;
        $this->dealerID = $dealerID;
        $this->category = $category;

        $this->securityContext = $securityContext;

    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::PRE_SUBMIT => 'preSubmitData', FormEvents::POST_SUBMIT => 'postSubmitData',);
    }

    public function preSubmitData(FormEvent $event)
    {

    }

    public function postSubmitData(FormEvent $event)
    {
        $item = $event->getData();
        $form = $event->getForm();

        if ($item instanceof Item) {
            $seo = $item->getSeo();
            if ($seo instanceof Seo && !$seo->isEmpty() && !$seo->getAutogenerate()) {

            } else {

                //$setting = $this->container->get("numa.settings");
                //dump($seo);die();

            }
        }
        //die();
    }

    /**
     * @param FormEvent $event
     * Based by the type of the each field in the form (item)
     * Fills the select  or other fields
     */
    public function preSetData(FormEvent $event)
    {

        $item = $event->getData();
        $form = $event->getForm();
        //check all 
        $cat = $item->getCategoryId();
        if ($this->category instanceof \Numa\DOAAdminBundle\Entity\Category) {
            $cat = $this->category->getId();
        }

        foreach (\Numa\DOAAdminBundle\Entity\Item::$fields[$cat] as $carFieldDB => $carFieldField) {
            $listingList = $this->em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByProperty($carFieldDB, $cat, true);
            //dump($carFieldDB);
            if ($listingList instanceof \Numa\DOAAdminBundle\Entity\Listingfield) {

                $type = $listingList->getType();

                if (strtolower($type) == 'list') {


                    $selected = $item->get($carFieldDB);
                    if (empty($selected)) {
                        $selected = $item->getItemFieldByName($carFieldDB);
                    }
                    $listingLists = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllByListingField($listingList->getId(), "ASC");

                    $values = array();
                    foreach ($listingLists as $key => $value) {
                        $values[$value->getValue()] = $value->getValue();
                    }
                    //if the value is not in the list addi it
                    //if() {
                       // dump($carFieldDB);
                        //die();
                    //}
                    if (!in_array($selected, $values)) {
                        $values[$selected] = $selected;
                    }

                    //make form name from db name TODO function for that

                    //$form->add($carFieldField, 'choice', array('choices' => $values, 'data' => $selected, 'required' => false));

                    if($carFieldDB=="ag_application" || $carFieldDB=="Boat Type" || ($carFieldField=="type" && ($cat=4 || $cat==3))) {

                        $form->add($carFieldField, 'choice', array('choices' => $values, 'data' => $selected, 'required' => false));
                    }else {
                        $form->add($carFieldField, AutocompleteType::class, array('choices' => $values, 'data' => $selected, 'required' => false));
                    }
                } elseif (strtolower($type) == 'tree') {

                    $selected = $item->getItemFieldByName($carFieldField);


                    $listingTree = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->findBy(array('listing_field_id' => $listingList->getId(), 'level' => 1),
                        array('name' => 'ASC'));
                    $values = array();
                    foreach ($listingTree as $key => $value) {
                        $values[$value->getName()] = $value->getName();
                    }
                    //make form name from db name TODO function for that


                    $form->add($carFieldField, AutocompleteType::class, array('choices' => $values, 'data' => $selected, 'required' => false));
                }
            }
        }
        //die();

        if($this->dealerID instanceof Catalogrecords)
        {
            
            if(empty($item->getId())){
                $form->add('seller_comment','ckeditor',array("data"=>$this->dealerID->getDefaultListingComment()));
            }
        }

        if (!$this->securityContext->isGranted('ROLE_ADMIN')) {

            $item->setDealer($this->dealerID);
            $form->remove('Dealer');
            $form->add('dealer_id', 'hidden', array('data' => $this->dealerID->getId()));
        }

        if ($this->securityContext->isGranted('ROLE_DMS_USER') || $this->securityContext->isGranted('ROLE_BUSINES')) {

            if($this->dealerID instanceof Catalogrecords && empty($dg)){
                $dg = $this->dealerID->getDealerGroup();
                $form->add('Dealer','entity');
            }

            //if dealer have dealer group
            //add select field with all the dealers from the group
        }

        foreach ($item->getItemField() as $itemfield) {
            if ($itemfield->getFieldType() == 'boolean') {

            } else {
                $item->removeItemField($itemfield);
            }
        }
    }

}
