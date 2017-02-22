<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemDefaultType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public $securityContext;

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('default_listing_comment', 'ckeditor', array('label' => 'Default Listing Comment'))
            ->add('fuel_economy', 'choice', array("choices" => array("mpg" => 'Miles per gallon (MPG)',"km/L" => "Kilometer per litre (km/L)", "L/100km" => "Liters per 100 kilometers (L/100km)")))
            ->add('setting_purechat', "textarea",array('label'=>"Pure Chat code","required"=>false))
            ->add('setting_ga', "text",array('label'=>"Google Analytics code","required"=>false))
            ->add('setting_ga_view', "text",array('label'=>"Google Analytics View ID","required"=>false));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Catalogrecords'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_item_default';
    }

}
