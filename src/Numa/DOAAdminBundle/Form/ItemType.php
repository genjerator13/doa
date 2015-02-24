<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Numa\DOAAdminBundle\Events\AddItemSubscriber;
use Symfony\Component\Form\FormEvents;

class ItemType extends AbstractType
{
    protected $em;
    protected $securityContext;
    protected $dealerID;
    public function __construct($em=null, $securityContext=null,$dealerID=null) {
        $this->em = $em;
        $this->dealerID =$dealerID ;
        $this->securityContext = $securityContext;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('sold')
            ->add('trim')
            ->add('bodyDescription')
            ->add('exteriorColor')
            ->add('interiorColor')
            ->add('doors')
            ->add('engine')
            ->add('fuelType')
            ->add('driveType')
            ->add('videoID')
            ->add('moderation_status','choice',array('choices'=>array('APPROVED','NEW')))
            ->add('keywords')
            ->add('featured')
            ->add('Category')
            ->add('Dealer')

            ->add('price')
            ->add('year')
            ->add('bodyStyle', 'choice', array(
                    'choices'   => $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Body Style',0,true),
                    'required'  => false,
                    'empty_value' => 'Any Body Style',
                    'label' => "Body Style", "required" => false
                ))

            ->add('make')
            ->add('model')
            ->add('type')
            ->add('transmission', 'choice', array(
                    'choices'   => $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('transmission',0,true),
                    'required'  => false,
                    'empty_value' => 'Any Transmission',
                    'label' => "Transmission", "required" => false
                ))
            ->add('VIN')
            ->add('mileage')
            ->add('floorPlan')
            ->add('stockNr')
            ->add('status')
            ->add('agApplication')
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
        ;
        
        $builder->addEventSubscriber(new AddItemSubscriber($this->em,$this->securityContext,$this->dealerID));
        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
        $event->stopPropagation();
    }, 900);
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
