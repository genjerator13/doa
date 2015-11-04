<?php

namespace Numa\DOAModuleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('keywords')
            ->add('title')
            //->add('url')
            //->add('is_public')
            ->add('active')
            ->add('autogenerate')
            //->add('created_at')
            //->add('updated_at')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAModuleBundle\Entity\Seo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doamodulebundle_seo';
    }
}
