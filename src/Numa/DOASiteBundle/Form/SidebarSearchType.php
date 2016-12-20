<?php

namespace Numa\DOASiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;

class SidebarSearchType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('category','choice',array('label'=>'Category',"choices"=>array()))
            ->add('categorySubType','choice',array('label'=>'Body Style',"choices"=>array()))
            ->add('yearFrom','text',array('label'=>'Year From',"required"=>false))
            ->add('yearTo','text',array('label'=>'Year To',"required"=>false))
            ->add('make_string','choice',array('label'=>'Make',"required"=>false))
            ->add('model','choice',array('label'=>'Model',"required"=>false))
            ->add('mileageFrom','text',array('label'=>'Mileage From',"required"=>false))
            ->add('mileageTo','text',array('label'=>'Mileage To',"required"=>false))
            ->add('priceFrom','text',array('label'=>'Price From',"required"=>false))
            ->add('priceTo','text',array('label'=>'Price To',"required"=>false))
            ->add('search','submit',array('label'=>'Search', 'attr' => array('class' => 'btn btn-primary')))
            ->add('reset','reset',array('label'=>'Reset', 'attr' => array('class' => 'btn btn-default') ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
