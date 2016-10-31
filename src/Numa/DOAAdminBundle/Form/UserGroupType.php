<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('reg_form_template')
            ->add('description')
            ->add('immediate_activation')
            ->add('user_menu_template')
            ->add('initial_balance')
            ->add('make_user_trusted');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\UserGroup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_usergroup';
    }
}
