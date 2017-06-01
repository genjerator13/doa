<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LeasingType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dealer_id','hidden')
            ->add('customer_id','hidden')
            ->add('company_name')
            ->add('company_contact')
            ->add('company_preferred_contact')
            ->add('company_email')
            ->add('company_day_phone')
            ->add('company_cell_phone')
            ->add('company_fax')
            ->add('company_address')
            ->add('company_city')
            ->add('company_zip_code')
            ->add('company_type_of_business')
            ->add('company_in_business_since')
            ->add('company_legal_structure')
            ->add('company_land')
            ->add('cust_first_name')
            ->add('cust_last_name')
            ->add('preferred_contact')
            ->add('email')
            ->add('day_phone')
            ->add('cell_phone')
            ->add('address')
            ->add('city')
            ->add('state')
            ->add('zip_code')
            ->add('ssn_sin_nr')
            ->add('birth_date')
            ->add('material_status')
            ->add('residence_type')
            ->add('monthly_payment')
            ->add('at_residence')
            ->add('real_estate')
            ->add('landlord_phone')
            ->add('mortgage_balance')
            ->add('previous_bankruptcy')
            ->add('employer_company')
            ->add('employer_type_of_business')
            ->add('employer_position')
            ->add('employer_on_job')
            ->add('employer_business_phone')
            ->add('employer_address')
            ->add('employer_city')
            ->add('employer_state')
            ->add('employer_zip')
            ->add('employer_previous_address')
            ->add('employer_previous_city')
            ->add('employer_previous_state')
            ->add('employer_previous_zip')
            ->add('vendor_company')
            ->add('vendor_address')
            ->add('vendor_city')
            ->add('vendor_contact')
            ->add('vendor_phone')
            ->add('vendor_email')
            ->add('make')
            ->add('model')
            ->add('year')
            ->add('vehicle_type')
            ->add('message_text')
            ->add('date_updated','hidden')
            ->add('date_created','hidden')
            ->add('status','hidden')
            ->add('Dealer','hidden')
            ->add('Customer','hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Leasing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_leasing';
    }
}
