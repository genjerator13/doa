<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListingFormFinanceType extends AbstractType
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
            ->add('email', 'email', array('label'=>'Email *', 'required' => false))
            ->add('phone')
            ->add('comment')
            ->add('type','hidden',array('data'=>'finance'))
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
        return 'finance';
    }
}
