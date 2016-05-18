<?php

namespace Numa\DOAModuleBundle\Form;


use Numa\DOAModuleBundle\Events\AdsEventSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id')
            ->add('description')
            ->add('keywords')
            ->add('title')
            ->add('url')

            ->add('component', CollectionType::class, array(
                // each entry in the array will be an "email" field
                'entry_type'   => ComponentType::class,
                // these options are passed to each "email" type
                'entry_options'  => array(
                    'attr'      => array('class' => 'component-box')
                ),
            ));

//            ->add('Ads' , 'entity' , array('label'=>'Ads',
//                'class'    => 'Numa\DOAModuleBundle\Entity\Ad' ,
//                'property' => 'name' ,
//                'expanded' => true ,
//                'multiple' => true , ))
            //->add('is_public')
            //->add('autogenerate')
            //->add('active')
            //->add('created_at')
            //->add('updated_at')
        ;
            //$builder->addEventSubscriber(new AdsEventSubscriber());
//

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAModuleBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doamodulebundle_page';
    }
}
