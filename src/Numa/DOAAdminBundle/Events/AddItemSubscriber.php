<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddItemSubscriber implements EventSubscriberInterface {

    protected $em;
    public function __construct($em) {
        $this->em = $em;
    }

    public static function getSubscribedEvents() {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::PRE_SUBMIT=>'preSubmitData');
    }
    public function preSubmitData(FormEvent $event) {
        //$data = $event->getData();
/*
        if($data ['field_type']  == 'list'){
                    //print_r($data);die();
            $id = $data->getFieldIntegerValue();
            if (!empty($id)) {
                $selected = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findOneById($id);
                if(!empty($selected)){
                    //$data->setFieldStringValue($selected->getValue());
                }
            }
        }
 * 
 */
    }
    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        if ($data->getFieldType() == 'list') {
            $id = $data->getFieldIntegerValue();
            $stringVal = $data->getFieldStringValue();
            if (!empty($id)) {
                $selected = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findOneById($id);
                $listingList = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id'=>$data->getFieldId()));                
                $values = array();
                foreach ($listingList as $key => $value) {
                    //print_r($value);
                    $values[$value->getId()] = $value->getValue();
                }

                $form->remove('field_string_value');
                $form->add('field_integer_value', 'choice', array('choices' => $values,'data' => $selected->getId(), 'required' => false));
            }elseif(!empty($stringVal)){
                
            }
        }
       
    }

}