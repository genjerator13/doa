<?php

namespace Numa\DOADMSBundle\Form;

use Numa\DOADMSBundle\Entity\FillablePdf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FillablePdfType extends AbstractType
{
    public $securityContext;

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $states = array(
            'USA' => array(
                'XX' => 'Choose a State',
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Delaware',
                'DC' => 'District Of Columbia',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucky',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'NC' => 'North Carolina',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
                'TT' => 'Trinidad and Tobago',
            ), 'Canada' =>
                array(
                    "AL" => "Alberta",
                    "BC" => "British Columbia",
                    "BC" => "Manitoba",
                    "NL" => "Newfoundland and Labrador",
                    "NS" => "Nova Scotia",
                    "ON" => "Ontario",
                    "PE" => "Prince Edward Island",
                    "QC" => "Quebec",
                    "SK" => "Saskatchewan",
                    "NT" => "Northwest Territories",
                    "NU" => "Nunavut",
                    "YT" => "Yukon",

                    )
        );
///<select>
//	<option value="AB">Alberta</option>
//	<option value="BC">British Columbia</option>
//	<option value="MB">Manitoba</option>
//	<option value="NB">New Brunswick</option>
//	<option value="NL">Newfoundland and Labrador</option>
//	<option value="NS">Nova Scotia</option>
//	<option value="ON">Ontario</option>
//	<option value="PE">Prince Edward Island</option>
//	<option value="QC">Quebec</option>
//	<option value="SK">Saskatchewan</option>
//	<option value="NT">Northwest Territories</option>
//	<option value="NU">Nunavut</option>
//	<option value="YT">Yukon</option>
//</select>
        $builder
            //->add('dealer_id')
            ->add('name', 'text')
            ->add('state', 'choice', array('choices' => $states));
        //->add('','ckeditor');
        if (!empty($this->securityContext) && $this->securityContext->isGranted('ROLE_ADMIN')) {
            $builder->add('helpdesc', 'ckeditor', array('label' => 'Help'));
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
            'data_class' => FillablePdf::class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fillable_pdf';
    }
}
