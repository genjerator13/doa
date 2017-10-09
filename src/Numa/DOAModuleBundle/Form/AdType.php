<?php

namespace Numa\DOAModuleBundle\Form;

use Numa\DOAModuleBundle\Events\AdsEventSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdType extends AbstractType
{
    protected $container;
    public function __construct($container = null){
        $this->container = $container;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('url')
//            ->add('start_date','date')
            ->add('start_date', 'date', array(
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array('class' => 'datepicker')
            ))
//            ->add('end_date','date')
            ->add('end_date', 'date', array(
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array('class' => 'datepicker')
            ))
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
                    'size350x250' => '350 X 250',
                    'size350x150' => '350 X 125',

                )))
            ->add('file_import_source','file', array('label'=>'Photo Upload','required' => false, 'data_class' => null))
            ->add('page_id','hidden')
            ->add('body','ckeditor')
//            ->add('Pages' , 'entity' , array('label'=>'Pages',
//                'class'    => 'Numa\DOAModuleBundle\Entity\Page' ,
//                'property' => 'url' ,
//                'expanded' => true ,
//                'multiple' => true , ))
        ;
        $builder->addEventSubscriber(new AdsEventSubscriber($options['container']));
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

    public function getParent()
    {
        return 'container_aware';
    }
}
