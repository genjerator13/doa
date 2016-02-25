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
            ->add('url')
            ->add('start_date','date')
            ->add('end_date','date')
           // ->add('position','choice',)
            ->add('position', 'choice', array(
                'choices'  => array(
                    'leftside_ad' => 'Left Side',
                    'content_ad' => 'Content',
                    'rightside_ad' => 'Right Side',
                )))
            ->add('status')
            ->add('status', 'choice', array(
                'choices'  => array(
                    'enabled' => 'Enabled',
                    'disabled' => 'Disabled',

                )))
            ->add('size', 'choice', array(
                'choices'  => array(
                    'size1' => 'Size 1',
                    'size2' => 'Size 2',

                )))
            ->add('file_import_source','file', array('label'=>'Photo Upload','required' => false, 'data_class' => null))
            ->add('page_id','hidden')
            ->add('body')
            ->add('Pages' , 'entity' , array('label'=>'Pages',
                'class'    => 'Numa\DOAModuleBundle\Entity\Page' ,
                'property' => 'title' ,
                'expanded' => true ,
                'multiple' => true , ))


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
