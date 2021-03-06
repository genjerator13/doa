<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DealerComponentType extends AbstractType
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
            //->add('dealer_id')
            ->add('name', 'text', array('disabled'=>'true'))
            ->add('type','choice',array('choices'=>array('HTML'=>'HTML','Text'=>'Text','String'=>'String','Image'=>'Image','Carousel'=>'Carousel')))
            ->add('value','ckeditor');
        if(!empty($this->securityContext) && $this->securityContext->isGranted('ROLE_ADMIN')){
            $builder->add('helpdesc','ckeditor', array('label'=>'Help'));
        }
        //$builder->add('helpdesc','ckeditor', array('label'=>'Help'))
//            ->add('settings', 'hidden')
//            ->add('date_updated', 'hidden')
//            ->add('date_created', 'hidden')
//            ->add('status', 'hidden')
            //->add('Dealer', 'hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\DealerComponent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_dealercomponent';
    }
}
