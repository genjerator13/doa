<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAModuleBundle\Events;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAModuleBundle\Entity\Component;
use Proxies\__CG__\Numa\DOAModuleBundle\Entity\Ad;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ComponentEventSubscriber implements EventSubscriberInterface
{

//    protected $container;

    public function __construct()
    {
//        $this->container = $container;
    }

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

        if ($data instanceof Component) {
            $type = $data->getType();
            if (!empty($data->getType())) {
                $form->add('value', null);
                if (strtolower($type) == "text") {
                    $form->add('value', 'textarea');
                } elseif (strtolower($type) == "html") {
                    $form->add('value', 'ckeditor');
                }
            }
        }
    }

}
