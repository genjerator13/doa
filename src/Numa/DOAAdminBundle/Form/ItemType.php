<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ItemType extends AbstractType
{
    protected $em;
    public function __construct($em=null) {
        $this->em = $em;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('moderation_status','choice',array('choices'=>array('APPROVED','NEW')))
            ->add('keywords')
            ->add('featured')
            ->add('pictures')
            ->add('activation_date','date',array(
	            'widget' => 'single_text',
	            'format' => 'yyyy-MM-dd',
	            'attr' => array('class' => 'date'),
                    'required'=>false
	        ))
            ->add('expiration_date','date',array(
	            'widget' => 'single_text',
	            'format' => 'yyyy-MM-dd',
	            'attr' => array('class' => 'date'),
                    'required'=>false
	        ))
            ->add('auto_extend')
            ->add('feature_highlighted')
            ->add('feature_slideshow')
            ->add('feature_youtube')
            ->add('Importfeed')
            ->add('User')
            ->add('Itemfield', 'collection', array('type' => new \Numa\DOAAdminBundle\Form\ItemFieldType($this->em),
        'by_reference' => false,))
            ->add('Submit','submit')
            
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Item'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_item';
    }
}
