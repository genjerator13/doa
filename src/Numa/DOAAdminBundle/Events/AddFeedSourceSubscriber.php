<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Numa\DOAAdminBundle\Lib\RemoteFeed;

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

    public function preSetData(FormEvent $event)
    {
//        $data = $event->getData();
//        $form = $event->getForm();
//
//        //dump($data);die();
//        if ($data && $data->getId()) {
//
//            $feed = new RemoteFeed($data->getId());
//            $props = $feed->getRemoteProperties();
////            //
//            if(!empty($props)) {
//                $uf = $form->get('unique_field');
//
//                $form->add('unique_field', 'choice', array('choices' => $props, 'empty_value' => 'Choose an option', 'required' => true, 'attr' => array('class' => 'form-control')));
//            }
//            //$entities = $em->getRepository('NumaDOAAdminBundle:Importmapping')
//            //$form->add('field_sid', 'choice', array('choices' => $this->properties,'empty_value' => 'Choose an option','required'=>false));
//        }

    }

}