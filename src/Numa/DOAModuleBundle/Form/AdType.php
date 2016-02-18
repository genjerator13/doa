<?php

namespace Numa\DOAModuleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
           // ->add('position','choice',)
            ->add('position', ChoiceType::class, array(
                'choices'  => array(
                    'Left Side' => 'Left Side',
                    'Content' => 'Content',
                    'Right Side' => 'Right Side',
                )))
            ->add('status')
            ->add('status', ChoiceType::class, array(
                'choices'  => array(
                    'Enabled' => 'enabled',
                    'Disabled' => 'disabled',

                )))
            ->add('size', ChoiceType::class, array(
                'choices'  => array(
                    'Size 1' => 'size1',
                    'Size 2' => 'size2',

                )))
            ->add('file_import_source','file', array('label'=>'Photo Upload','required' => false, 'data_class' => null))
            ->add('page_id','hidden')
            ->add('body')


        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAModuleBundle\Entity\Ad',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doamodulebundle_ad';
    }
}
