<?php

namespace Numa\CCCAdminBundle\Form;

use Numa\CCCAdminBundle\Entity\Origin;
use Numa\CCCAdminBundle\Entity\Vehtypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class OriginType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('po', TextType::class, array('attr' => array('maxlength' => 15), 'label' => 'PO# or Reference#', 'required' => false))
                ->add('collect', null, array('label' => 'Collect', 'required' => false))
                ->add('building_business', TextType::class, array('attr' => array('maxlength' => 26), 'label' => 'Pickup Building / Business Name * ', 'required' => true))
                ->add('address', TextType::class, array('attr' => array('maxlength' => 26), 'label' => 'Pickup Address', 'required' => false))
                ->add('contact_person', TextType::class, array('attr' => array('maxlength' => 22), 'label' => 'Pickup Contact Person', 'required' => false))
                ->add('time_flag', null, array('label' => 'Change Time', 'required' => false))
                ->add('delivery_time', DateTimeType::class, array('label' => 'Requested Pickup Time', 'required' => false, 'data' => new \DateTime()))


                //->add('VehicleType', null, array('label' => 'Vehicle Type * ', 'required' => true))
                ->add('VehicleType', EntityType::class, array(
                    'class' => Vehtypes::class,
                    'multiple' => false,
                    'expanded' => false,
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('v')
                        ->where('v.type=1')
                        ->orderBy('v.id', 'ASC')
                        ;
            }
            ))
                ->add('pieces', NumberType::class, array('attr' => array('maxlength' => 6,'type'=>"number"), 'label' => 'Pieces * ', 'required' => true))
                ->add('weight',  NumberType::class, array('attr' => array('maxlength' => 6,'type'=>"number"), 'label' => 'Weight', 'required' => false))
                ->add('cod_amount', TextType::class, array('label' => 'COD amount', 'required' => false))
                ->add('comments', null, array('attr' => array('maxlength' => 130), 'label' => 'Comments and/or Commodity Instructions', 'required' => false))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Origin::class
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {
        return 'numa_cccadminbundle_origin';
    }

}
