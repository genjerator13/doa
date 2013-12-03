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
        //$data = $event->getData();
        //$form = $event->getForm();
        //$values = $data->getFieldStringValue();
        //if($data->getFieldName()=="Make"){
            //echo $values.":::".$data->getFieldName().":::".$data->();
            //\Doctrine\Common\Util\Debug::dump($data);
        //}
        //$form->add('field_string_value','text', array('required'=>false));
        /*
        if ($data->getFieldType()=='list') {
            $values = $data->getFieldStringValue();

            //$form->add('field_string_value', 'choice',array('choices'=>$values,'required'=>false));
        }else if ($data->getFieldType()=='string') {
            $values = $data->getFieldStringValue();
            $form->add('field_string_value','text', array('required'=>false));
        }
        else if ($data->getFieldType()=='integer') {
            $data->setFieldStringValue($data->getFieldIntegerValue());
            $form->add('field_integer_value', 'number',array('required'=>false));
            $form->remove('field_string_value');
        }
        else if ($data->getFieldType()=='date') {
            $values = $data->getFieldStringValue();
            $form->add('field_date_value', 'datetime',array('required'=>false));
            $form->remove('field_string_value');
        }
        else if ($data->getFieldType()=='boolean') {
            $data->setFieldStringValue($data->getFieldBooleanValue());
            $values = $data->getFieldStringValue();
            $form->add('field_boolean_value', 'checkbox',array('required'=>false));
            $form->remove('field_string_value');
        }
        */
    }

}