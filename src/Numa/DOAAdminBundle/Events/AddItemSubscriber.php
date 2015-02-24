<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddItemSubscriber implements EventSubscriberInterface {

    protected $em;
    protected $securityContext;
    protected $dealerID;

    public function __construct($em,$securityContext,$dealerID) {
        $this->em = $em;
        $this->dealerID = $dealerID;
        
        $this->securityContext = $securityContext;
    }

    public static function getSubscribedEvents() {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::PRE_SUBMIT => 'preSubmitData');
    }

    public function preSubmitData(FormEvent $event) {
        
    }

    public function preSetData(FormEvent $event) {

        $item = $event->getData();
        $form = $event->getForm();
        $formItemFields = $form->get('Itemfield');
        //$data->removeAllItemField();
        //$data->getDoors();
        //check all 
        $cat = $item->getCategoryId();
        foreach (\Numa\DOAAdminBundle\Entity\Item::$carFields as $carFieldDB=>$carFieldField) {
            $listingList = $this->em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByProperty($carFieldDB,1,true);
            
            if ($listingList instanceof \Numa\DOAAdminBundle\Entity\Listingfield) {
                
                $type = $listingList->getType();
                if (strtolower($type) == 'list') {
                    $selected = $item->getItemFieldByName($carFieldDB);
                    $listingList = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $listingList->getId()));
                    $values = array();
                    foreach ($listingList as $key => $value) {
                        $values[$value->getValue()] = $value->getValue();
                    }
                    //make form name from db name TODO function for that
                    $form->add($carFieldField, 'choice', array('choices' => $values, 'data' => $selected, 'required' => false));
                    
                }elseif(strtolower($type) == 'tree') {
                    $selected = $item->getItemFieldByName($carFieldDB);
                    $listingTree = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->findBy(array('listing_field_id' => $listingList->getId(),'level'=>1));
                    $values = array();
                    foreach ($listingTree as $key => $value) {
                        $values[$value->getName()] = $value->getName();
                    }

                    //make form name from db name TODO function for that
                    
                    
                    $form->add($carFieldField, 'choice', array('choices' => $values, 'data' => $selected, 'required' => false));
                    
                }
//                dump($carFieldDB);
//                dump($listingList);
//                    dump($values);
//                    dump($selected);
            }
        }
        //die();

        if (!$this->securityContext->isGranted('ROLE_ADMIN')) {

            $item->setDealer($this->dealerID);
            $form->remove('Dealer');
            $form->add('dealer_id','hidden',array('data'=>$this->dealerID->getId()));                    
        }
        
        foreach ($item->getItemField() as $itemfield) {
            if ($itemfield->getFieldType() == 'boolean') {
                
            } else {
                $item->removeItemField($itemfield);
            }
        }

    }

}
