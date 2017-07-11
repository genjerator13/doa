<?php

// Numa\DOAAdminBundle\Events/AddFeedSourceSubscriber.php

namespace Numa\DOAAdminBundle\Events;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddItemFieldSubscriber implements EventSubscriberInterface
{

    protected $em;

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData', FormEvents::PRE_SUBMIT => 'preSubmitData');
    }

    public function preSetData(FormEvent $event)
    {

        $data = $event->getData();
        $form = $event->getForm();

        if ($data->getFieldType() == 'list') {

            $id = $data->getFieldIntegerValue();
            $stringVal = $data->getFieldStringValue();
            $selected = 0;
            if (!empty($id)) {
                $selected = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findOneById($id);

                if ($selected instanceof \Numa\DOAAdminBundle\Entity\ListingFieldLists) {
                    $selected = $selected->getId();
                } else {
                    $selected = 0;
                }
            }

            $listingList = $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $data->getListingfield()->getId()));
            $values = array();

            foreach ($listingList as $key => $value) {
                $values[$value->getId()] = $value->getValue();
            }


            $form->add('field_string_value', 'hidden');
            $form->add('field_integer_value', 'choice', array('choices' => $values, 'data' => $selected, 'required' => false));
            $form->add('field_id', 'hidden');
        } else if ($data->getFieldType() == 'boolean') {
            $form->add('field_string_value', 'hidden');
            $form->add('field_boolean_value', 'checkbox', array('required' => false, 'data' => $data->getFieldBooleanValue()));
        } else if ($data->getFieldType() == 'string') {
            $form->add('field_string_value', 'text', array('required' => false));
        } else if ($data->getFieldType() == 'geo') {
            $form->add('field_string_value', 'text', array('required' => false));
        } else if ($data->getFieldType() == 'integer') {
            $form->add('field_string_value', 'text', array('required' => false));
        } else if ($data->getFieldType() == 'decimal') {
            $form->add('field_string_value', 'text', array('required' => false));
        } else if ($data->getFieldType() == 'video') {
            $form->add('field_string_value', 'text', array('required' => false));
        } else if ($data->getFieldType() == 'rating') {
            $form->add('field_string_value', 'text', array('required' => false));
        } else if ($data->getFieldType() == 'array') {
            $form->add('field_string_value', 'text', array('required' => false));
        }
    }

}
