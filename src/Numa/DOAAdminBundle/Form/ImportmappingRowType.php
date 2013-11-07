<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImportmappingRowType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ImportmappingRow', 'collection', array('type' => new ImportmappingType(),'attr'=>array('class'=>'form-inline'),'allow_add' => true,  'allow_delete' => true,))
            ->add('feed_sid','hidden');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Importmappings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_importmappingrows';
    }
}
