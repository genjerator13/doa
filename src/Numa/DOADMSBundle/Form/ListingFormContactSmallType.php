<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListingFormContactSmallType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,array('label'=>false, 'required'=>true,'attr'=>array('placeholder'=>"Your email")))
            ->add('cust_name',HiddenType::class,array('data'=>"smallcontact"))
            ->add('cust_last_name',HiddenType::class,array('data'=>"smallcontact"))
            ->add('custName',HiddenType::class,array('data'=>"smallcontact"))
            ->add('comment',null,array('label'=>false,'data'=>"Hi, I'm interested in this vehicle. Please contact me."))
            ->add('type','hidden',array('data'=>'contactsmall'))
            ->add('item_id','hidden')
            ->add('emailCopy',CheckboxType::class,array('label'=>"Send me a copy of email",'required'=>false))
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
            'data_class' => 'Numa\DOADMSBundle\Entity\ListingForm',
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ));
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//
//        ));
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contactsmall';
    }
}
