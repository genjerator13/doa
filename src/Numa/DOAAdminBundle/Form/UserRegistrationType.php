<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserRegistrationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username','text',array('label'=>'Username'))
                ->add('password','password',array('label'=>'Password'))
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ))
                ->add('email','email',array('label'=>'Email'))
                ->add('FirstName','text',array('label'=>'First name'))
                ->add('LastName','text',array('label'=>'Last name'))
                ->add('PhoneNumber','text',array('label'=>'Phone number'))
                ->add('DisplayEmail','checkbox',array('label'=>'Display email','required'=>false))
                ->add('Submit', 'button')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'numa_doaadminbundle_user_registration';
    }

}
