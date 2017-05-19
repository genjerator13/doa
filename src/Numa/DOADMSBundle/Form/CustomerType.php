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
            ->add('sales_person',null,array('label'=>'Salesperson'))
            ->add('name')
            ->add('first_name')
            ->add('last_name')
            ->add('address')
            ->add('address2')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('home_phone')
            ->add('work_phone')
            ->add('mobile_phone')
            ->add('fax')
            ->add('email')
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
