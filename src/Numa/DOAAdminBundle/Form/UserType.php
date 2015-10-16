<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password','password',array('required'=>false))
            ->add('email')
            ->add('active')
            ->add('activation_key')
            ->add('verification_key')
            ->add('trusted_user')
            ->add('FirstName')
            ->add('LastName')
            ->add('DealershipName')
            ->add('Address')
            ->add('City')
            ->add('PostalCode','text',array('label' => "Zip / Postal", "required" => false))
            ->add('PhoneNumber')
            ->add('DealershipWebsite')
            ->add('DisplayEmail')
            ->add('State')
            ->add('DealershipLogo')
            ->add('third_party_id')
            ->add('UserGroup')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_user';
    }
}
