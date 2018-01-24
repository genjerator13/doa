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
        $container = $options['container'];

        $builder
            ->add('username', null, array('label' => "Name"))
            ->add('password', 'password')
            ->add('email')
            ->add('status');
        if ($container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $builder->add('Dealer', 'entity', array(
                //'choices'   => $this->em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted(),
                'class' => 'Numa\DOAAdminBundle\Entity\Catalogrecords',
                'multiple' => true,
                //'empty_value' => 'Choose Dealer',
                'label' => "Dealer"
            ));
        };
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

    public function getParent()
    {
        return 'container_aware';
    }
}
