<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealerGroupType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',null,array('label'=>"Name"))
            ->add('password','password')
            ->add('email')
            ->add('status')
            ->add('Dealer', 'entity',array(
                //'choices'   => $this->em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted(),
                'class' => 'Numa\DOAAdminBundle\Entity\Catalogrecords',
                'multiple'  => true,
                //'empty_value' => 'Choose Dealer',
                'label' => "Dealer"
            ))
//            ->add('date_created')
//            ->add('date_updated')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\DealerGroup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_dealergroup';
    }
}
