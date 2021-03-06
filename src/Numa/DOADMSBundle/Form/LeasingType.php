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
//            ->add('dealer_id','hidden')
//            ->add('customer_id','hidden')
            ->add('company_name', null, array('label'=> '* Company Operation Name', 'required' => true))
            ->add('company_contact', null, array('label'=> '* Contact', 'required' => true))
            ->add('company_preferred_contact','choice',array('label'=>'* Preferred Contact','choices'=>array('Email','Phone')))
            ->add('company_email', null, array('label'=> '* Email', 'required' => true))
            ->add('company_day_phone', null, array('label'=> '* Day Phone', 'required' => true))
            ->add('company_cell_phone', null, array('label'=> '* Cell Phone', 'required' => true))
            ->add('company_fax', null, array('label'=> '* Fax', 'required' => true))
            ->add('company_address', null, array('label'=> '* Address', 'required' => true))
            ->add('company_city', null, array('label'=> '* City', 'required' => true))
            ->add('company_zip_code', null, array('label'=> '* Postal', 'required' => true))
            ->add('company_type_of_business', null, array('label'=> 'Type Of Business'))
            ->add('company_in_business_since', 'date', array('label'=> 'In Business Since','years'       => range(date('Y'), date('Y') - 50, -1)))
            ->add('company_legal_structure','choice',array('label'=>'Legal Structure','choices'=>array('Incorporated','Partnership', 'Proprietorship')))
            ->add('company_land', null, array('label'=> 'If Farmer, Amount of Land'))
            ->add('cust_first_name', null, array('label'=> '* First Name', 'required' => true))
            ->add('cust_last_name', null, array('label'=> '* Last Name', 'required' => true))
            ->add('preferred_contact','choice',array('label'=>'Preferred Contact','choices'=>array('Email','Phone')))
            ->add('email', null, array('label'=> '* Email', 'required' => true))
            ->add('day_phone', null, array('label'=> 'Day Phone'))
            ->add('cell_phone', null, array('label'=> 'Cell Phone'))
            ->add('address', null, array('label'=> 'Address'))
            ->add('city', null, array('label'=> 'City'))
            ->add('state', null, array('label'=> 'State/Prov'))
            ->add('zip_code', null, array('label'=> 'ZIP Code'))
            ->add('at_residence', null, array('label'=> 'Years at curent residence', 'max_length'=>4))
            ->add('ssn_sin_nr', null, array('label'=> 'SSN/SIN. No.'))
            ->add('birth_date', 'date', array('label'=>'Date of Birth','years' => range(date('Y')-16, date('Y') - 100, -1)))
            ->add('material_status', null, array('label'=> 'Material Status'))
            ->add('residence_type','choice',array('label'=>'Residence Type','choices'=>array('Own'=>"Own",'Rent'=>"Rent")))
            ->add('real_estate', null, array('label'=> 'Value of Real Estate'))
            ->add('mortgage_balance', null, array('label'=> 'Mortgage Balance'))
            ->add('previous_bankruptcy','choice',array('label'=>'Previous Bankruptcy','choices'=>array('Yes'=>"Yes",'No'=>"No")))
            ->add('employer_company', null, array('label'=> 'Company'))
            ->add('employer_type_of_business', null, array('label'=> 'Type Of business'))
            ->add('employer_position', null, array('label'=> 'Position'))
            ->add('employer_on_job', 'date', array('label'=> 'On Job','years' => range(date('Y'), date('Y') - 50, -1)))
            ->add('employer_business_phone', null, array('label'=> 'Business Phone'))
            ->add('employer_address', null, array('label'=> 'Address'))
            ->add('employer_city', null, array('label'=> 'City'))
            ->add('employer_state', null, array('label'=> 'State/Prov'))
            ->add('employer_zip', null, array('label'=> 'Zip/Postal'))
            ->add('employer_previous_address', null, array('label'=> 'Address'))
            ->add('employer_previous_city', null, array('label'=> 'City'))
            ->add('employer_previous_state', null, array('label'=> 'State/Prov'))
            ->add('employer_previous_zip', null, array('label'=> 'Zip/Postal'))

            ->add('make')
            ->add('model')
            ->add('year')
            ->add('vehicle_type')
            ->add('message_text','textarea', array('attr' => array('rows' => '10'), 'required' => false))
//            ->add('date_updated','hidden')
//            ->add('date_created','hidden')
//            ->add('status','hidden')
//            ->add('Dealer','hidden')
//            ->add('Customer','hidden')
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
