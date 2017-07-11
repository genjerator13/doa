<?php


namespace Numa\DOAAdminBundle\Events;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddFeedSourceSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    function __construct($feed_sid = null, $properties = null)
    {

        $this->feed_sid = $feed_sid;
        $this->properties = $properties;
    }

}