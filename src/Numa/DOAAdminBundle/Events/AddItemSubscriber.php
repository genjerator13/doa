<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddItemSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        
        if ($data->getFieldType()=='list') {
            $values = $data->getFieldStringValue();

            $form->add('field_string_value', 'choice',array('choices'=>$values));
        }else if ($data->getFieldType()=='string') {
            $values = $data->getFieldStringValue();
            $form->add('field_string_value', 'text');
        }
        else if ($data->getFieldType()=='integer') {
            $values = $data->getFieldStringValue();
            $form->add('field_integer_value', 'number');
            $form->remove('field_string_value');
        }
        else if ($data->getFieldType()=='date') {
            $values = $data->getFieldStringValue();
            $form->add('field_string_value', 'datetime');
            $form->remove('field_string_value');
        }
    }

}