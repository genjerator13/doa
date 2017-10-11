<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CustomRateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('src_file',FileType::class, array('label'=>'Document','file_path' => 'webPath', 'required' => false))
            ->add('custommade_rate',null,array('label'=>'Custom Rates', 'attr'=>array("data-role"=>"tagsinput")))
//            ->add('Rates', 'entity',array(
//                //'choices'   => $this->em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted(),
//                'class' => 'Numa\CCCAdminBundle\Entity\Rates',
//                'multiple'  => true,
//                'expanded'  => true ,
//                //'empty_value' => 'Choose Dealer',
//                'label' => "Rates"
//            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\CustomRate'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_cccadminbundle_customrate';
    }
    
}
