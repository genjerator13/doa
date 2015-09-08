<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealerCouponsType extends AbstractType {

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
                ->add('name')

                ->add('city')
                ->add('zip')
                ->add('state')
                ->add('description', 'ckeditor')
            ->add('coupon', 'collection', array('type' => new CouponType()));


        ;
        if(!empty($this->securityContext) && $this->securityContext->isGranted('ROLE_BUSINES')){
            $builder->remove('logo_url');
        }
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
        return 'numa_doaadminbundle_catalogrecords';
    }

}
