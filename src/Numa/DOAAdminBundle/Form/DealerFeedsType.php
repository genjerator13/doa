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
            ->add('feed_autotrader_manual', 'checkbox', array('label' => "Autotrader Manually Add Listings", "required" => false))
            ->add('feed_siriusxm_url', null, array('label' => 'Siriusxm URL'))
            ->add('feed_siriusxm_username', null, array('label' => 'Siriusxm Username'))
            ->add('feed_siriusxm_password', null, array('label' => 'Siriusxm Password'))
            ->add('feed_siriusxm_manual', 'checkbox', array('label' => "Siriusxm Manually Add Listings", "required" => false))
            ->add('feed_vauto_url', null, array('label' => 'Vauto URL'))
            ->add('feed_vauto_username', null, array('label' => 'Vauto Username'))
            ->add('feed_vauto_password', null, array('label' => 'Vauto Password'))
            ->add('feed_vauto_manual', 'checkbox', array('label' => "Vauto Manually Add Listings", "required" => false))

            ->add('feed_cargurus_url', null, array('label' => 'cargurus URL'))
            ->add('feed_cargurus_username', null, array('label' => 'cargurus Username'))
            ->add('feed_cargurus_password', null, array('label' => 'cargurus Password'))
            ->add('feed_cargurus_id', null, array('label' => 'cargurus ID'))
            //->add('feed_carget_manual', 'checkbox', array('label' => "Carget Manually Add Listings", "required" => false))
        ;

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
