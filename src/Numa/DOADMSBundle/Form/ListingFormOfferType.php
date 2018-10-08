<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListingFormOfferType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cust_name',null,array('label'=>'First Name *', 'required'=>true))
            ->add('cust_last_name',null,array('label'=>'Last Name *', 'required'=>true))
            ->add('cust_officer', null, array('label'=>'Sales Person *', 'required'=>true))
            ->add('email', null, array('label'=>'Email *', 'required' => true))
            ->add('phone')
            ->add('offer_amt', null, array('label'=>'Offer Amount', 'required' => false))
            ->add('type','hidden',array('data'=>'offer'))
            ->add('item_id','hidden')

//            ->add('date_created')
//            ->add('date_updated')
//            ->add('status')
//            ->add('Dealer')
//            ->add('Customer')
//            ->add('Item')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Numa\DOADMSBundle\Entity\ListingForm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'offer';
    }
}
