<?php

namespace Numa\DOADMSBundle\Form;

use Numa\DOADMSBundle\Events\CustomerSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
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
//            ->add('Catalogrecords')
            ->add('sales_person',null,array('label'=>'Salesperson', 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.sales_person')))
            ->add('name',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.name')))
            ->add('first_name',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.first_name')))
            ->add('last_name',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.last_name')))
            ->add('contact',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.contact')))
            ->add('address',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.address')))
            ->add('address2',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.address2')))
            ->add('city',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.city')))
            ->add('state',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.state')))
            ->add('zip',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.zip')))
            ->add('home_phone',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.home_phone')))
            ->add('work_phone',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.work_phone')))
            ->add('mobile_phone',null,array('attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.mobile_phone')))
            ->add('fax',null,array( 'attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.fax')))
            ->add('email',null,array('attr' => array('ng-model' => 'customernew.numa_doaadminbundle_customer.email')))
            ->add('file_import_source', 'file', array('label'=>'Picture','required' => false, 'data_class' => null))

        ;
        $builder->addEventSubscriber(new CustomerSubscriber($options['container']));
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

    public function getParent()
    {
        return 'container_aware';
    }
}
