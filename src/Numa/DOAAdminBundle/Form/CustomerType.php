<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Numa\DOAAdminBundle\Events\AddCustomerSubscriber;

class CustomerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('country')
            ->add('home_phone')
            ->add('work_phone')
            ->add('mobile_phone')
            ->add('fax')
            ->add('email')
            ->add('notes');
        dump("AAA");die();
        $builder->addEventSubscriber(new AddCustomerSubscriber($options['container']));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Customer'
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
