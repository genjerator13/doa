<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DMSUserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password','password')
            ->add('email')
            ->add('active')
//            ->add('activation_key')
//            ->add('verification_key')
//            ->add('trusted_user')
//            ->add('balance')
            ->add('FirstName')
            ->add('LastName')
            ->add('Address')
            ->add('City')
            ->add('PostalCode')
            ->add('PhoneNumber')
            ->add('State')
            ->add('UserGroup')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\DMSUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_dmsuser';
    }
}
