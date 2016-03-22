<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sales_person',null,array('label'=>'Salesperson'))
            ->add('name')
            ->add('city')
            ->add('state')
            ->add('zip')

            ->add('home_phone')
            ->add('work_phone')
            ->add('mobile_phone')

            ->add('fax')
            ->add('email')
            ->add('followup_date','date')
            ->add('file_import_source', 'file', array('label'=>'Logo Upload','required' => false, 'data_class' => null))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Customer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_customer';
    }
}
