<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOADMSBundle\Events;

use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DealerGroup;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Numa\Form\AutocompleteType;

class CustomerSubscriber implements EventSubscriberInterface
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




    /**
     * @param FormEvent $event
     * Based by the type of the each field in the form (item)
     * Fills the select  or other fields
     */
    public function preSetData(FormEvent $event)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_DEALER_PRINCIPAL')) {

            $form = $event->getForm();
            $em = $this->container->get("doctrine.orm.entity_manager");
            $dealerPrincipal = $this->container->get("numa.dms.user")->getSignedDealerPrincipal();

            if ($dealerPrincipal instanceof DealerGroup) {
                $form->add('Catalogrecords', 'entity', array(
                    'choices' => $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealersByDealerGroup($dealerPrincipal->getId()),
                    'class' => "Numa\DOAAdminBundle\Entity\Catalogrecords"
                ));
            }

            //if dealer have dealer group
            //add select field with all the dealers from the group
        }

    }

}
