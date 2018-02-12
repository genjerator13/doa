<?php

namespace Numa\DOAAdminBundle\Form;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DMSUser;
use Numa\DOAModuleBundle\Form\SeoType;
use Numa\DOADMSBundle\Form\SaleType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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

    public function __construct($em = null, $securityContext = null, $dealerID = null, $category = null, $container = null)
    {

        $this->em = $em;
        if ($dealerID instanceof DMSUser) {
            ////

            $dealerID = $dealerID->getDealer();
        }

        $this->dealerID = $dealerID;
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
            ->add('sale', new SaleType(), array(
                'data_class' => 'Numa\DOADMSBundle\Entity\Sale', 'by_reference' => true))
            ->add('sold')

            ->add('trim')
            ->add('bodyDescription', null, array('label' => 'Body Description'))
            ->add('exteriorColor')
            ->add('interiorColor')
            ->add('doors')
            ->add('engine')
            ->add('engineType', null, array('label' => 'Engine Type'))
            ->add('fuelType')
            ->add('fuelSystem', null, array('label' => 'Fuel System'))
            ->add('fuelCapacity', null, array('label' => 'Fuel Capacity'))
            ->add('driveType', null, array('label' => 'Drive Type'))
            ->add('videoID', null, array('label' => 'Video ID'))
            ->add('moderation_status', 'choice', array('choices' => array('APPROVED', 'NEW')))
            ->add('keywords')
            ->add('featured')
            //->add('Category', null, array('label' => 'Category'))
            ->add('Category', EntityType::class, array('label' => 'Category','class'=>"Numa\DOAAdminBundle\Entity\Category"))
            ->add('Dealer', EntityType::class,array('choice_label' => 'displayName','class' => Catalogrecords::class))
            ->add('retail_price', null, array('label' => 'Retail Price'))
            ->add('price', null, array('label' => 'Selling Price'))
            ->add('bi_weekly', null, array('label' => 'Bi-Weekly'))
            ->add('year')
            ->add('bodyStyle', 'choice', array(
                'choices' => $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('Body Style', 0, true),
                'required' => true,
                'empty_value' => 'Any Body Style',
                'label' => "Body Style"
            ))
            ->add('sub_category_type',  'choice', array('choices'=>array('Pickup'=>'Pickup', 'Chassis Cab'=>'Chassis Cab', 'Flat Deck'=>'Flat Deck', 'Cube Van'=>'Cube Van', 'Cargo Van'=>'Cargo Van', 'Passenger Van'=>'Passenger Van')))
            ->add('make')
            ->add('model')
            ->add('type')
            ->add('transmission', 'choice', array(
                'choices' => $this->em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAllBy('transmission', 0, true),
                'required' => false,
                'empty_value' => 'Any Transmission',
                'label' => "Transmission", "required" => false
            ))
            ->add('VIN', null, array("label" => "VIN"))
            ->add('engine_VIN', null, array("label" => "Engine VIN"))
            ->add('trailer_VIN', null, array("label" => "Trailer VIN"))
            ->add('mileage')
            ->add('floorPlan', null, array("label" => "Floor Plan"))
            ->add('stockNr', null, array("label" => "Stock Number"))
            ->add('status', 'choice', array('choices' => array('Used' => 'Used', 'New' => 'New')))
            ->add('agApplication', null, array("label" => "Ag Application"))
            ->add('activation_date', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array('class' => 'date'),
                'required' => false
            ))
            ->add('expiration_date', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array('class' => 'date'),
                'required' => false
            ))
            ->add('auto_extend')
            ->add('feature_highlighted')
            ->add('feature_slideshow')
            ->add('feature_youtube')
            ->add('Importfeed')
            ->add('seller_comment', 'ckeditor', array("label" => "Seller Comments"))
            ->add('seller_comment_1', 'ckeditor', array("label" => "Seller Comments 2"))
            ->add('seller_comment_2', 'ckeditor', array("label" => "Seller Comments 3"))
            ->add('seller_comment_active', 'choice', array('choices' => array('Seller Comments', 'Seller Comments 2', 'Seller Comments 3'), 'label' => 'Seller Comment Active'))
            ->add('User')
            ->add('length', 'integer', array("label" => "Length", "required" => false))
            ->add('beam')
            ->add('hullDesign', null, array("label" => "Hull Design"))
            ->add('steeringType', null, array("label" => "Steering Type"))
            ->add('steering')
            ->add('horsepower')
            ->add('ofHours', null, array("label" => "# of Hours"))
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
            ->add('slideOuts', null, array('label' => 'Slide Outs'))
            ->add('flooring')
            ->add('class')
            ->add('weight', "integer", array("required" => false))
            ->add('operatorStation', null, array('label' => 'Operator Station'))
            ->add('speedForward', null, array('label' => 'Speed Forward'))
            ->add('speedReverse', null, array('label' => 'Speed Reverse'))
            ->add('tireSize', null, array('label' => 'Tire Size'))
            ->add('tireEquipment', null, array('label' => 'Tire Equipment'))
            ->add('cuttingWidth', null, array('label' => 'Cutting Width'))
            ->add('coolingSystem')
            ->add('mpgCity', null, array('label' => 'Fuel Economy City'))
            ->add('mpgHighway', null, array('label' => 'Fuel Economy Highway'))
            ->add('iwNo', null, array('label' => 'IW NO'))
            ->add('invoice_nr', null, array("label" => "Invoice #"))
            ->add('invoice_date', 'date', array(
                'label' => "Invoice Date",
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'datepicker')
            ))
            ->add('Itemfield', 'collection', array('type' => new \Numa\DOAAdminBundle\Form\ItemFieldType($this->em),
                'by_reference' => false,))
            ->add('torque')
            ->add('compression_ratio')
            ->add('brakes')
            ->add('wheels')
            ->add('frame')
            ->add('suspension')
            ->add('ground_clereance')
            ->add('fresh_water_capacity')
            ->add('black_water_capacity')
            ->add('gray_water_capacity')
            ->add('hitch_weight')
            ->add('height')
            ->add('pto_horsepower')
            ->add('dbrhorsepower')
            ->add('remotes')
            ->add('tire_size')
            ->add('qb_post_include',null,array('label'    => 'Post to Quickbooks'));
//        , CheckboxType::class, array(
//                'label'    => 'Post to quickbox',
//                'mapped' => false,
//                'data' => true,
//                'required' => false,
//            ))
            ;

        $builder->addEventSubscriber(new AddItemSubscriber($options['container'], $this->securityContext, $this->dealerID, $this->category));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Item',
             'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_item';
    }

    public function getParent()
    {
        return 'container_aware';
    }
}
