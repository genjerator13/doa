<?php

namespace Numa\DOASettingsBundle\Form;

use Numa\DOASettingsBundle\Events\SettingsSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('value',"ckeditor")
            ->add('section')
        ;


        $builder->addEventSubscriber(new SettingsSubscriber($options['container']));

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOASettingsBundle\Entity\Setting'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doasettingsbundle_setting';
    }

    public function getParent()
    {
        return 'container_aware';
    }
}
