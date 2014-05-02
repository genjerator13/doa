<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Numa\DOAAdminBundle\Events\AddItemSubscriber;

class ItemFieldType extends AbstractType {

    protected $em;
    public function __construct($em=null) {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('field_id', 'hidden')
                ->add('field_name', 'hidden')
                ->add('field_type', 'hidden')
                ->add('field_string_value')
        ;
        $builder->addEventSubscriber(new AddItemSubscriber($this->em));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\ItemField'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'numa_doaadminbundle_itemfield';
    }

}
