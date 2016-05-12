<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServiceRequestType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cust_name',null,array('label'=>'First Name'))
            ->add('cust_last_name',null,array('label'=>'Last Name'))
            ->add('contact_by','choice',array('label'=>'Contact Me By','choices'=>array('Email','Phone')))
            ->add('email')
            ->add('phone')
            ->add('date_appointment','date', array('label'=>'Preferred Appointment Date'))
            ->add('time_appointment','time', array('label'=>'Preferred Appointment Time'))
            ->add('make')
            ->add('model')
            ->add('year')
            ->add('comment')
//            ->add('dealer_id')
//            ->add('Dealer')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\ServiceRequest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_servicerequest';
    }
}
