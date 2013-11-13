<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Numa\DOAAdminBundle\Events\AddFeedSourceSubscriber;

class ImportmappingType extends AbstractType
{
    public function __construct ($feed_sid = null)
    {
        $this->feed_sid = $feed_sid ;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sid')
            ->add('description','text',array('required'=>false))
            ->add('ListingFields')
            ->add('feed_sid','hidden');
        ;
        $builder->addEventSubscriber(new AddFeedSourceSubscriber($this->feed_sid));

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Importmapping'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_importmapping';
    }
}
