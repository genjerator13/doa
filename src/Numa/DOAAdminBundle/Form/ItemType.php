<?php

namespace Numa\DOAAdminBundle\Form;

use Numa\DOAModuleBundle\Form\SeoType;
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
    protected $category;
    protected $container;
    public function __construct($em=null, $securityContext=null,$dealerID=null,$category=null,$container=null) {
        $this->em = $em;
        $this->dealerID =$dealerID ;
        $this->securityContext = $securityContext;
        $this->category = $category;
        $this->container = $container;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('Seo', new SeoType())

            ->add('sold')
            ->add('trim')
            ->add('bodyDescription')
            ->add('exteriorColor')
            ->add('interiorColor')
            ->add('doors')
            ->add('engine')
            ->add('engineType')
            ->add('fuelType')
            ->add('fuelSystem')
            ->add('fuelCapacity')
            ->add('driveType')
            ->add('videoID')
            ->add('moderation_status','choice',array('choices'=>array('APPROVED','NEW')))
            ->add('keywords')
            ->add('featured')
            ->add('Category',null,array('label'=>'Category'))
            ->add('Dealer')

            ->add('retail_price')
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
            ->add('stockNr',null,array("label"=>"Stock Number"))
            ->add('status','choice',array('choices'=>array('New'=>'New',"Used"=>"Used")))
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
            ->add('seller_comment','ckeditor')
            ->add('User')
            ->add('length')
            ->add('beam')            
            ->add('hullDesign')
            ->add('steeringType')
            ->add('steering')
            ->add('horsepower')
            ->add('fuelCapacity')
            ->add('ofHours')

            ->add('passengers')
            ->add('battery')
            ->add('trailer')
            ->add('ignition')
            ->add('gears')
            ->add('width')
            ->add('displacement')
            ->add('chassis')
            ->add('chassisType')
            ->add('sleeps')
            ->add('slideOuts')
            ->add('flooring')
            ->add('floorPlan')
            ->add('class')
            ->add('weight')
            ->add('operatorStation')
            ->add('speedForward')
            ->add('speedReverse')
            ->add('tireSize')
            ->add('tireEquipment')
            ->add('cuttingWidth')
            ->add('coolingSystem')
            ->add('mpgCity',null,array('label'=>'Fuel Economy City'))
            ->add('mpgHighway',null,array('label'=>'Fuel Economy Highway'))
            ->add('iwNo')
            ->add('invoice_nr',null,array("label"=>"Invoice #"))
            ->add('invoice_date', 'date', array(
                'label' => "Invoice Date",
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'datepicker')
            ))
            ->add('invoice_amount')
            ->add('discount1',null,array("label"=>"Discount 1"))
            ->add('discount2',null,array("label"=>"Discount 2"))
            ->add('sale_amount')
            ->add('Itemfield', 'collection', array('type' => new \Numa\DOAAdminBundle\Form\ItemFieldType($this->em),
        'by_reference' => false,))            
        ;
        
        $builder->addEventSubscriber(new AddItemSubscriber($this->em,$this->securityContext,$this->dealerID, $this->category));
//        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
//            $event->stopPropagation();
//        }, 900);
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
