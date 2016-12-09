<?php

namespace Numa\DOAModuleBundle\Form;

use Numa\DOAModuleBundle\Events\AdsEventSubscriber;
use Numa\DOAModuleBundle\Events\ComponentEventSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentType extends AbstractType
{
    public $securityContext;
    public function setSecurityContext($securityContext){
        $this->securityContext=$securityContext;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('disabled'=>'true'))
            ->add('type','choice',array('disabled'=>'true','choices'=>array('HTML'=>'HTML','text'=>'text','string'=>'string','image'=>'image','carousel'=>'carousel')))
            ->add('value');
        if(!empty($this->securityContext) && $this->securityContext->isGranted('ROLE_ADMIN')){
            $builder->add('helpdesc','ckeditor', array('label'=>'Help'));
        }
        ;
        $builder->addEventSubscriber(new ComponentEventSubscriber());
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAModuleBundle\Entity\Component'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doamodulebundle_component';
    }
}
