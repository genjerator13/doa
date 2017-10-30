<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DealerGroup;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Numa\Form\AutocompleteType;

class AddCustomerSubscriber implements EventSubscriberInterface
{



    public function __construct($container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::POST_SUBMIT => 'postSubmitData',);
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
        $form = $event->getForm();
        dump($form);die();
        if ($this->securityContext->isGranted('ROLE_DEALER_PRINCIPAL')) {
            $dealerPrincipal = $this->container->get("numa.dms.user")->getSignedDealerPrincipal();

            if ($dealerPrincipal instanceof DealerGroup) {

                $form->add('Dealer', 'entity', array(
                    'choices' => $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealersByDealerGroup($dealerPrincipal->getId()),
                    'class' => "Numa\DOAAdminBundle\Entity\Catalogrecords",
                    'choice_label' => 'displayName'
                ));
            }

            //if dealer have dealer group
            //add select field with all the dealers from the group
        }

        if ($this->securityContext->isGranted('ROLE_SALE2_DEALER_GROUP_DMS')) {
            $dealer = $this->container->get("numa.dms.user")->getSignedDealer();
            $dealerGroup = $dealer->getDealerGroup();
            if ($dealerGroup instanceof DealerGroup) {

                $form->add('Dealer', 'entity', array(
                    'choices' => $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealersByDealerGroup($dealerGroup->getId()),
                    'class' => "Numa\DOAAdminBundle\Entity\Catalogrecords",
                    'choice_label' => 'displayName'
                ));

            }

            //if dealer have dealer group
            //add select field with all the dealers from the group
        }
    }

}
