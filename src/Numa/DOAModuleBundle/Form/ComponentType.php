<?php

namespace Numa\DOAModuleBundle\Form;

use Numa\DOAModuleBundle\Events\AdsEventSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name')
            ->add('type','choice',array('choices'=>array('text'=>'text','string'=>'string','image'=>'image','carousel'=>'carousel')))
            ->add('value')

        ;
        $builder->addEventSubscriber(new AdsEventSubscriber());
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAModuleBundle\Entity\Component'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doamodulebundle_component';
    }
}
