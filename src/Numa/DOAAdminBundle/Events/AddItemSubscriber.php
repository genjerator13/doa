<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Numa\DOAAdminBundle\Entity\Item;
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
        //$formItemFields = $form->get('Itemfield');
        //$data->removeAllItemField();
        //$data->getDoors();
        //check all 
        $cat = $item->getCategoryId();
        if ($this->category instanceof \Numa\DOAAdminBundle\Entity\Category) {
            $cat = $this->category->getId();
        }

        foreach (\Numa\DOAAdminBundle\Entity\Item::$fields[$cat] as $carFieldDB => $carFieldField) {
            $listingList = $this->em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByProperty($carFieldDB, $cat, true);

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

                    //make form name from db name TODO function for that

                    //$form->add($carFieldField, 'choice', array('choices' => $values, 'data' => $selected, 'required' => false));
                    
                    $form->add($carFieldField, AutocompleteType::class, array('choices' => $values, 'data' => $selected, 'required' => false));
                } elseif (strtolower($type) == 'tree') {

                    $selected = $item->getItemFieldByName($carFieldField);


                    $listingTree = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->findBy(array('listing_field_id' => $listingList->getId(), 'level' => 1),
                        array('name' => 'ASC'));
                    $values = array();
                    foreach ($listingTree as $key => $value) {
                        $values[$value->getName()] = $value->getName();
                    }
                    //dump($values);
                    //dump($selected);
                    //make form name from db name TODO function for that


                    $form->add($carFieldField, AutocompleteType::class, array('choices' => $values, 'data' => $selected, 'required' => false));
                }
            }
        }
        //die();

        if (!$this->securityContext->isGranted('ROLE_ADMIN')) {

            $item->setDealer($this->dealerID);
            $form->remove('Dealer');
            $form->add('dealer_id', 'hidden', array('data' => $this->dealerID->getId()));
        }

        foreach ($item->getItemField() as $itemfield) {
            if ($itemfield->getFieldType() == 'boolean') {

            } else {
                $item->removeItemField($itemfield);
            }
        }
    }

}
