<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartRequestType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cust_name',null,array('label'=>'First Name'))
            ->add('cust_last_name',null,array('label'=>'Last Name'))
            ->add('contact_by','choice',array('label'=>'Contact Me By','choices'=>array('Email','Phone')))
            ->add('email')
            ->add('phone')
            ->add('make')
            ->add('model')
            ->add('year')
            ->add('vin')
            ->add('part_num',null,array('label'=>'Part Number #', 'attr'=>array("data-role"=>"tagsinput")))
            ->add('part_desc',null,array('label'=>'Part Description'))
            ->add('comment')
            //->add('date_created')
            //->add('date_updated')
            //->add('status')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\PartRequest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_partrequest';
    }
}
