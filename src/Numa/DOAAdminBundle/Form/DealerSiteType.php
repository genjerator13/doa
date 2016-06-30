<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealerSiteType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public $securityContext;
    public function setSecurityContext($securityContext){
        $this->securityContext=$securityContext;
    }
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('site_theme','choice',array("choices"=>array('Default'=>"default","Sea"=>"Sea","Mountain"=>"Mountain","Forest"=>"Forest")))
                ->add('site_url')
                ->add('site_facebook')
                ->add('site_youtube')
                ->add('site_google')
                ->add('site_twitter')
                ->add('site_instagram')
        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Catalogrecords'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'numa_doaadminbundle_dealer_site';
    }

}
