<?php

namespace Numa\CCCAdminBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DispatchSubscriber implements EventSubscriberInterface
{


    protected $container;

    public function __construct($container)
    {

        $this->container = $container;


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

    }

    /**
     * @param FormEvent $event
     * Based by the type of the each field in the form (item)
     * Fills the select  or other fields
     */
    public function preSetData(FormEvent $event)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_OCR')) {
            $item = $event->getData();
            $form = $event->getForm();

            $form->add('Customer');

        }
    }

}
