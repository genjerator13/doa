<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('started_at')
            ->add('ended_at')
            ->add('customer_id')
            ->add('batch_id')
            ->add('status')
            ->add('body')
            ->add('attachment')
            ->add('subject')
            ->add('email_from')
            ->add('email_to')
            ->add('Customers')
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\Email'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_cccadminbundle_email';
    }
}
