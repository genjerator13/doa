<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Numa\CCCAdminBundle\Events\DispatchSubscriber;

class DispatchcardType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('serv_type', ChoiceType::class, array('attr'=>array('maxlength'=>3), 'label' => 'Serv Type *', 'required' => true,'choices_as_values' => true, 'choices' => array('REG' => 'REG', 'DIR' => "DIR")))
                ->add('call_in_buy', TextType::class, array('attr'=>array('maxlength'=>15), 'label' => 'Call in by *', 'required' => true))
                //->add('po', 'text', array('attr'=>array('maxlength'=>15),'label' => 'PO#', 'required' => false))
                ->add('origin', CollectionType::class, array('entry_options' => array('label' => false), 'entry_type' => OriginType::class, 'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true))
                ->add('destination',  CollectionType::class, array('entry_options' => array('label' => false), 'entry_type' => DestinationType::class, 'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true))
//                ->add('saveAndPrint', SubmitType::class, array('label' => 'Save and Print'))
//                ->add('saveAndAddMultiOrigin', SubmitType::class, array('label' => 'Save and Add Multi Origin'))
//                ->add('saveAndAddMultiDest', SubmitType::class, array('label' => 'Save and Add Multi Destination'))


        ;
        $builder->addEventSubscriber(new DispatchSubscriber($options['container']));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\Dispatchcard'
        ));
    }
    /**
     * @return string
     */
    public function getBlockPrefix() {
        return 'numa_cccadminbundle_dispatchcard';
    }

    public function getParent()
    {
        return ContainerAwareType::class;
    }

}
