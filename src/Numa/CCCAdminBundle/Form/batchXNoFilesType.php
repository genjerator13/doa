<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class batchXNoFilesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('started')
            ->add('closed')
            ->add('working_days',ChoiceType::class,array('attr'=>array('class'=>"size50"),'label'=>"Working Days",'choices'=>array(range(0, 31))))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\batchX',
            'validation_groups' => 'NewGalleryImage',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'numa_cccadminbundle_batchx';
    }
}
