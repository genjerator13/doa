<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ImportfeedType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('sid', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('description', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('import_format', 'choice', array('choices' => $this->getImportFormatList(), 'expanded' => false,'attr'=>array('class'=>'form-control')))
            ->add('delimiterx', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('import_method', 'choice', array('choices' => $this->getImportMethod(), 'expanded' => false, 'attr'=>array('class'=>'form-control')))
            ->add('import_source', null )

            ->add('file_import_source', 'file' ,array('required'=>false))
            
                                   
            ->add('root_node', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('Category', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('Dealer', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('notify_on_user_registration', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('options_key', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('options_separator', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
            ->add('default_package', null , array(
                               'attr'=> 
                                       array(
                                         'class'=>'form-control')
                    ))
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
        ;
        
        //$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            $form = $event->getForm();
//            $importFeed = $event->getData();
//            if($importFeed->getImportMethod()=='upload-file'){
//                $form->add('import_source', 'file' );
//            }
//            \Doctrine\Common\Util\Debug::dump($importFeed->getImportMethod());
            //die("aaaa");
        //});
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
