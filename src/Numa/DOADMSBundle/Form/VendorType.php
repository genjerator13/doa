<?php

namespace Numa\DOADMSBundle\Form;

use Numa\DOADMSBundle\Events\VendorSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VendorType extends AbstractType
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
            ->add('company_name')
            ->add('first_name')
            ->add('last_name')
            ->add('address')
            ->add('address2')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('country')
            ->add('home_phone')
            ->add('work_phone')
            ->add('mobile_phone')
            ->add('sales_person')
            ->add('fax')
            ->add('email')
//            ->add('anotes')
            ->add('followup_date','date')
//            ->add('date_created')
//            ->add('date_updated')
//            ->add('status')
//            ->add('dealer_id')
//            ->add('logo')
//            ->add('Catalogrecords')
            ->add('file_import_source', 'file', array('label'=>'Picture','required' => false, 'data_class' => null))

        ;
        $builder->addEventSubscriber(new VendorSubscriber($options['container']));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Vendor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_vendor';
    }

    public function getParent()
    {
        return 'container_aware';
    }
}
