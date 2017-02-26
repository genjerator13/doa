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
            ->add('cust_name',null,array('label'=>'First Name *', 'required' => true))
            ->add('cust_last_name',null,array('label'=>'Last Name *', 'required' => true))
            ->add('contact_by','choice',array('label'=>'Contact Me By','choices'=>array('Email','Phone')))
            ->add('email', 'email', array('label'=>'Email *', 'required' => true))
            ->add('phone', null, array('label'=>'Phone *', 'required' => true))
            ->add('date_appointment','date', array(
                'label'=>'Preferred Appointment Date',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+1),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ))
            ->add('time_appointment','time', array('label'=>'Preferred Appointment Time'))
            ->add('make', null, array('label'=>'Make *', 'required' => true))
            ->add('model', null, array('label'=>'Model *', 'required' => true))
            ->add('year', null, array('label'=>'Year *', 'required' => true))
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
