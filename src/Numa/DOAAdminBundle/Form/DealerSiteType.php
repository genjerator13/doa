<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealerSiteType extends AbstractType
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
            ->add('site_theme', 'choice', array('label' => "Theme", "choices" => array('Default' => "Default", "Sea" => "Sea", "Mountain" => "Mountain", "Mountain8b" => "Mountain8b", "Forest" => "Forest", "Garden" => "Garden", "Bridge" => "Bridge")))
            ->add('site_url', null, array('label' => 'URL'))
            ->add('site_facebook', null, array('label' => 'Facebook'))
            ->add('site_youtube', null, array('label' => 'Youtube'))
            ->add('site_google', null, array('label' => 'Google'))
            ->add('site_twitter', null, array('label' => 'Twitter'))
            ->add('site_instagram', null, array('label' => 'Instagram'))
            ->add('site_googlemap', null, array('label' => 'Google Map'))
            ->add('site_google_tag', null, array('label' => 'Google Tag Manager #'))
            ->add('site_facebook_pixel_id', null, array('label' => 'Facebook Pixel Id #'));
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
        return 'numa_doaadminbundle_dealer_site';
    }

}
