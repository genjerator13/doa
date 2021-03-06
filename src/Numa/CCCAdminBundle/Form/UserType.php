<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('name')
            ->add('password',PasswordType::class)
            //->add('user_group_id')
            ->add('registration_date', DateTimeType::class)
            ->add('UserGroup')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\User'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_cccadminbundle_user';
    }
    
}
