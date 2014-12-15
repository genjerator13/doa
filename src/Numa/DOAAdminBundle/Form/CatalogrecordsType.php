<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogrecordsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('username')
            ->add('url')
            ->add('email')
            ->add('address')
            ->add('fax')
            ->add('phone')
            ->add('phone')
            ->add('contact')
            ->add('city')
            ->add('zip')            
            ->add('state')            
            ->add('description', 'genemu_tinymce',array('attr'=>array('class'=>'tinymce')))
            ->add('CatalogCategory')
            ->add('file_import_source','file',array('required'=>false,'data_class' => null))
            ->add('logo_url','text',array('required'=>false))
            ->add('password','password',array('required'=>false))
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
        return 'numa_doaadminbundle_catalogrecords';
    }
}
