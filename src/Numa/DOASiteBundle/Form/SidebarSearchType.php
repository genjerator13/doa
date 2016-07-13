<?php

namespace Numa\DOASiteBundle\Form;

use Numa\DOAModuleBundle\Form\SeoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Numa\DOAAdminBundle\Events\AddItemSubscriber;
use Symfony\Component\Form\FormEvents;

class SidebarSearchType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = array(0=>"All Categories",1=>"Car",2=>"Marine",3=>"Moto Sport",4=>"RVs",13=>"Ag");
        $builder

            ->add('category_id','choice',array('label'=>'Category',"choices"=>$categories))

            ->add('year','integer',array('label'=>'Year',"required"=>false))
            ->add('make_string','text',array('label'=>'Make',"required"=>false))
            ->add('model','text',array('label'=>'Model',"required"=>false))
            ->add('search','submit',array('label'=>'Search'))

            //->add('type')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Numa\DOAAdminBundle\Entity\Item'
//        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
