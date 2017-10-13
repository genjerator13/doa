<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array("max_length"=>"100"))
            ->add('contact')
            ->add('comment')
            ->add('email')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\Quote'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_cccadminbundle_quote';
    }
}
