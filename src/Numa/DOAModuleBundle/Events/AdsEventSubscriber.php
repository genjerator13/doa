<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAModuleBundle\Events;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAModuleBundle\Entity\Component;
use Proxies\__CG__\Numa\DOAModuleBundle\Entity\Ad;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdsEventSubscriber implements EventSubscriberInterface
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
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        $em = $this->container->get("doctrine.orm.entity_manager");
        $dealer = $this->container->get("numa.dms.user")->getSignedDealer();

        if ($dealer instanceof Catalogrecords) {
            $form->add('Pages', 'entity', array('label' => 'Pages',
                'choices' => $em->getRepository('NumaDOAModuleBundle:Page')->findPagesByDealer($dealer->getId()),
                'class' => 'Numa\DOAModuleBundle\Entity\Page',
                'property' => 'url',
                'expanded' => true,
                'multiple' => true,));
        } else {
            $form->add('Pages', 'entity', array('label' => 'Pages',
                'choices' => $em->getRepository('NumaDOAModuleBundle:Page')->findBy(array('dealer_id' => NULL)),
                'class' => 'Numa\DOAModuleBundle\Entity\Page',
                'property' => 'url',
                'expanded' => true,
                'multiple' => true,));
        }

    }

}
