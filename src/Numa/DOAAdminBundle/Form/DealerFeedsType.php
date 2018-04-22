<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealerFeedsType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public $securityContext;

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feed_kijiji_url', null, array('label' => 'Kijiji URL'))
            ->add('feed_kijiji_username', null, array('label' => 'Kijiji Username'))
            ->add('feed_kijiji_password', null, array('label' => 'Kijiji Password'))
            ->add('feed_kijiji_manual', 'checkbox', array('label' => "Kijiji Manually Add Listings", "required" => false))
            ->add('feed_autotrader_url', null, array('label' => 'Autotrader URL'))
            ->add('feed_autotrader_username', null, array('label' => 'Autotrader Username'))
            ->add('feed_autotrader_password', null, array('label' => 'Autotrader Password'))
            ->add('feed_autotrader_manual', 'checkbox', array('label' => "Autotrader Manually Add Listings", "required" => false));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Catalogrecords'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_dealer_feeds';
    }

}
