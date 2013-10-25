<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImportfeedType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sid')
            ->add('description')
            ->add('import_format', 'choice', array('choices' => $this->getImportFormatList(), 'expanded' => false))
            ->add('delimiter')
            ->add('import_method', 'choice', array('choices' => $this->getImportMethod(), 'expanded' => false))
            ->add('import_source')
            ->add('root_node')
            ->add('category')
            ->add('default_user')
            ->add('notify_on_user_registration')
            ->add('options_key')
            ->add('options_separator')
            ->add('default_package')
            ->add('pictures_key')
            ->add('pictures_separator')
            ->add('activate_listing')
            ->add('make_featured')
            ->add('make_highlighted')
            ->add('make_slideshow')
            ->add('make_youtubevideo')
            ->add('add_options')
            ->add('add_list_values')
            ->add('add_tree_values')
            ->add('unique_field')
            ->add('update_on_match')
            ->add('expiration_after')
            ->add('updated_on')
            ->add('user_type')
            ->add('user_unique_field')
        ;
           
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Importfeed'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_importfeed';
    }
    
    /**
     * Get import format array list
     * @return array
     */
    function getImportFormatList(){
        return array('0'=>'Select format from the list','XML'=>'XML','CSV'=>'CSV','Iron Search XML'=>'Iron Search XML');
    }
    
    function getImportMethod(){
        return array('0'=>'Select fimport method','local-file'=>'Local File','upload-file'=>'Upload File','Link-URL'=>'Link (URL)');
    }
}
