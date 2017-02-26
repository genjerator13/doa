<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListingFormDriveType extends AbstractType
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
            ->add('contact_by','choice',array('label'=>'Contact Me By *','choices'=>array('Email'=>'Email','Phone'=>'Phone')))
            ->add('email', null, array('label'=>'Email *', 'required' => true))
            ->add('phone')
            ->add('date_drive','date', array(
                'label'=>'Best Date *',
                'required' => true,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+1),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ))
            ->add('type','hidden',array('data'=>'testdrive'))
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
            'data_class' => 'Numa\DOADMSBundle\Entity\ListingForm',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'testdrive';
    }
}
