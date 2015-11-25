<?php

namespace Numa\DOAAdminBundle\Form;

use Numa\DOAAdminBundle\Events\AddFeedSourceSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ImportfeedType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('sid', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('description', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('photo_feed')
                ->add('import_format', 'choice', array('label'=>'Import Format','choices' => $this->getImportFormatList(), 'expanded' => false, 'attr' => array('class' => 'form-control')))
                ->add('delimiterx', null, array('label'=>'CSV Delimiter',
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('import_method', 'choice', array('label'=>'Import Method','choices' => $this->getImportMethod(), 'expanded' => false, 'attr' => array('class' => 'form-control')))
                ->add('import_source', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('file_import_source', 'file', array('label'=>'Import Source File','required' => false))
                ->add('root_node', null, array('label'=>'XML Root Node',
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('Category', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('Dealer', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
//                ->add('notify_on_user_registration', null, array('label'=>'Notify on User Registration',
//                    'attr' =>
//                    array(
//                        'class' => 'form-control')
//                ))
                ->add('options_key', null, array('label'=>'Options Key',
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('options_separator', null, array('label'=>'Options Separator',
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
//                ->add('default_package', null, array('label'=>'Default Package',
//                    'attr' =>
//                    array(
//                        'class' => 'form-control')
//                ))
                ->add('autogenerate_seo','checkbox',array('label'=>'Autogenerate Seo'))
                ->add('pictures_key',null,array('label'=>'Picture Key'))
                ->add('pictures_separator',null,array('label'=>'Picture Separator'))
                ->add('pictures_save_localy',null,array('label'=>'Save Picture Localy?'))
                ->add('activate_listing',null,array('label'=>'Activate Listing'))
                ->add('make_featured',null,array('label'=>'Make Featured'))
                ->add('make_highlighted',null,array('label'=>'Make Highlighted'))
//                ->add('make_slideshow',null,array('label'=>'Make Slideshow'))
                ->add('make_youtubevideo',null,array('label'=>'Make Youtube Video'))
                ->add('add_options',null,array('label'=>'Add Options'))
                ->add('add_list_values',null,array('label'=>'Add List Values'))
                ->add('add_tree_values',null,array('label'=>'Import Format'))
                ->add('unique_field',null,array('label'=>'Unique Field'))
//                ->add('update_on_match',null,array('label'=>'Update on Match'))
                ->add('expiration_after',null,array('label'=>'Expiration After'))
                ->add('only_matched_dealers',null,array('label'=>'Fetch Only Matched Dealers'))
                ->add('username', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
                ->add('password', null, array(
                    'attr' =>
                    array(
                        'class' => 'form-control')
                ))
        ;

       // $data = $this->get

        //$builder->add('unique_field','choice',array('data'=>))
        //$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            $form = $event->getForm();
//            $importFeed = $event->getData();
//            if($importFeed->getImportMethod()=='upload-file'){
//                $form->add('import_source', 'file' );
//            }
//            \Doctrine\Common\Util\Debug::dump($importFeed->getImportMethod());
        //die("aaaa");
        //});
        $builder->addEventSubscriber(new AddFeedSourceSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Importfeed'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'numa_doaadminbundle_importfeed';
    }

    /**
     * Get import format array list
     * @return array
     */
    function getImportFormatList() {
        return array('0' => 'Select format from the list', 'XML' => 'XML', 'CSV' => 'CSV', 'Iron Search XML' => 'Iron Search XML');
    }

    function getImportMethod() {
        return array('0' => 'Select fimport method', 'local-file' => 'Local File', 'upload-file' => 'Upload File', 'Link-URL' => 'Link (URL)');
    }

    function getUniqueFields(){

    }

}
