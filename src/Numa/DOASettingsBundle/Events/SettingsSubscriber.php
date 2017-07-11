<?php

/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 11.4.17.
 * Time: 14.35
 */
namespace Numa\DOASettingsBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SettingsSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }


    public function preSetData(FormEvent $event)
    {

        $data = $event->getData();
        $form = $event->getForm();

        if($data->getSection()=="QB"){
            $form->remove('section');
            $form->add('value',null,array("label"=>"QB Name"));
            $form->add('value2',null,array("label"=>"Expense Account"));
            $form->add('value3',null,array("label"=>"Income Account"));
            $form->add('value4',null,array("label"=>"Asset Account"));
            $form->add('section');
        }

    }

}