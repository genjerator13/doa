<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogrecordsType extends AbstractType {

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
                 ->add('Dcategory' , 'entity' , array(
                'class'    => 'Numa\DOAAdminBundle\Entity\Dcategory' ,
                'property' => 'name' ,
                'expanded' => false ,
                'multiple' => true , ))
                ->add('username')
                ->add('url')
                ->add('dealerId')
                ->add('email')
                ->add('address')
                ->add('fax')
                ->add('phone')
                ->add('phone')
                ->add('contact')
                ->add('city')
                ->add('zip')
                ->add('state')
                ->add('description', 'ckeditor')
                ->add('Catalogcategory')

                ->add('file_import_source', 'file', array('required' => false, 'data_class' => null))
                ->add('logo_url', 'text', array('required' => false))
                ->add('password', 'password', array('required' => false))
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
