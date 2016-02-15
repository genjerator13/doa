<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAModuleBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdsEventSubscriber implements EventSubscriberInterface
{

    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::PRE_SUBMIT => 'preSubmitData');
    }

    public function preSubmitData(FormEvent $event)
    {

    }

    public function preSetData(FormEvent $event)
    {

        $data = $event->getData();
        $form = $event->getForm();

        //dump($data->getAds());die();
    }

}
