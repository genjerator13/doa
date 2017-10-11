<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LtDispatchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $vehtypes = array(
            "1 Ton Flat Deck"=>"1 Ton Flat Deck",
            //"3 Ton Cube Van with Hydraulic Power Tailgate"=>"3 Ton Cube Van with Hydraulic Power Tailgate",
            "3 Ton Cube Van"=>"3 Ton Cube Van",
            "3 Ton Cube Van with hydraulic liftgate"=>"3 Ton Cube Van with hydraulic liftgate",
            "3 Ton Flat Deck"=>"3 Ton Flat Deck",
            "3 Ton Flat Deck with Hoist"=>"3 Ton Flat Deck with Hoist",
            "3 Ton Flat Deck with 32’ trailer"=>"3 Ton Flat Deck with 32’ trailer",
            "3 Ton Flat Deck with 35’ Trailer"=>"3 Ton Flat Deck with 35’ Trailer",
            "3 Ton tilt deck with winch"=>"3 Ton tilt deck with winch",
            "4 Ton tilt deck with winch"=>"4 Ton tilt deck with winch",
            "5 Ton tilt deck with winch"=>"5 Ton tilt deck with winch",
            "5 Ton Flat Deck"=>"5 Ton Flat Deck",
            "5 Ton Flat Deck with Picker"=>"5 Ton Flat Deck with Picker",
            "5 Ton Flat Deck with Portable Forklift"=>"5 Ton Flat Deck with Portable Moffett Forklift",
            "Semi/Power Unit"=>"Semi/Power Unit",
        );
        $semipower = array(
            "Semi/Power Unit only"=>"Semi/Power Unit only",
            "28' flat deck trailer"=>"28' flat deck trailer",
            "32' flat deck trailer"=>"32' flat deck trailer",
            "60' b-train combination flat deck trailer"=>"60' b-train combination flat deck trailer",
            "28' Van-body pup trailer"=>"28' Van-body pup trailer",
            "32' Hard-top curtain flat deck trailer"=>"32' Hard-top curtain flat deck trailer",
            "32' Hard-top curtain flat deck trailer with portable forklift"=>"32' Hard-top curtain flat deck trailer with portable forklift",
            "53' flat deck trailer"=>"53' flat deck trailer",
            "53' soft top accordion style curtain flat deck trailer"=>"53' soft top accordion style curtain flat deck trailer",
            "48' flat deck trailer"=>"48' flat deck trailer",
            "48' Hard-top curtain flat deck trailer"=>"48' Hard-top curtain flat deck trailer",
            "48' Hard-top curtain flat deck trailer with portable forklift"=>"48' Hard-top curtain flat deck trailer with portable forklift"
        );

        $builder->add('order_placed_by')
            ->add('order_placed_from', null, array('label' => "Order placed from (Business Name)"))
            ->add('contact_phone_number')
            ->add('service_type', 'choice', array('choices' => array("Regular" => "Regular - 45 min to 1.25  hrs estimated for pickups.", "NTO" => "Nto        - Next Truck Out. When available this puts your load next in line. Surcharge applicable.")))
            ->add('pickup_location')
            ->add('pickup_city')
            ->add('pickup_contact_phone')
            ->add('pickup_time', 'datetime',array("label"=>"Requested Pickup Time"))
            ->add('delivery_location')
            ->add('delivery_city')
            ->add('delivery_contact_phone')
            ->add('delivery_time', 'datetime',array("label"=>"Requested Delivery Time"))
            ->add('customer_charged')
            ->add('contact_info',null,array("label"=>"Contact info of customer charged"))
            ->add('length')
            ->add('width')
            ->add('height')
            ->add('weight', null, array("label" => "Load Weight (Lbs.)"))
            #->add('additional_details')
            ->add('vehtype_requested', ChoiceType::class, array("required" => true, 'data' => 0, "label" => "Vehicle Types Requested", 'expanded' => true, 'choices' => array(0 => "Not Sure, dispatch will call you for details.", 1=> "I want to select my vehicle type.")))
            ->add('additional_details', null, array("label" => "Additional Load Details", "attr" => array("rows" => 10, "cols" => 200)))
            ->add('vehicletype',ChoiceType::class,array("choices"=>$vehtypes,"label"=>"Vehicle Type"))
            ->add('semipower_unit',ChoiceType::class,array("choices"=>$semipower,"label"=>"Trailer Required for Semi"))
//            ->add('vehicle_types' , 'entity' , array('label'=>'',
//                'class'    => 'Numa\CCCAdminBundle\Entity\Vehtypes' ,
//                'property' => 'Vehdesc' ,
//                'expanded' => true ,
//                'multiple' => true ,
//                'label_attr'=>array('class'=>'checkbox-inline')))
            ->add('additional' , EntityType::class , array('label'=>'Additional Requirements',
                'class'    => 'Numa\CCCAdminBundle\Entity\AdditionalReq' ,
                'property' => 'name' ,
                'expanded' => true ,
                'multiple' => true ,
                'label_attr'=>array('class'=>'checkbox-inline')))
            ->add('send_quote', ChoiceType::class, array("required" => true, 'data' => 1, "label" => "Would you like a quote sent to you for this load?", 'expanded' => true, 'choices' => array(1 => "Yes", 0 => "No")))
            ->add('email', null, array("label" => "If yes please fill out email address"));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\LtDispatch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_cccadminbundle_ltdispatch';
    }
}
