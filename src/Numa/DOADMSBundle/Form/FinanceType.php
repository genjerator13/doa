<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FinanceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $loanTerms = array(""=>'Chose A Term',
            "6 Months"=>"6 Months",
            "12 Months"=>"12 Months",
            "18 Months"=>"18 Months",
            "24 Months"=>"24 Months",
            "30 Months"=>"30 Months",
            "36 Months"=>"36 Months",
            "42 Months"=>"42 Months",
            "48 Months"=>"48 Months",
            "54 Months"=>"54 Months",
            "60 Months"=>"60 Months",
            "72 Months"=>"72 Months",
            "84 Months"=>"84 Months",
            "96 Months"=>"96 Months",
            "108 Months"=>"108 Months",
            "120 Months"=>"120 Months",
        );

        $builder
            ->add('applicant_type','choice',array('choices'=>array('Individual','Joint')))
            ->add('amount_required', null)
            ->add('loan_term','choice',array('label'=>'* Loan Term', 'required' => true, 'choices'=>$loanTerms))
            ->add('down_payment', null, array('label'=> '* Down Payment', 'required' => true))
            ->add('trade_in','choice',array('label'=>'* Trade-In', 'required' => true, 'choices'=>array('Yes','No')))

            ->add('message_text','textarea', array('attr' => array('rows' => '10')))
            ->add('make', null)
            ->add('model', null)
            ->add('year', null)
            ->add('vehicle_type', null)
            ->add('interested_in','choice',array('label'=>'* Interested In', 'required' => true, 'choices'=>array('Choose Vehicle Type','Hatchback','Convertible', 'Truck', 'Van', 'Wagon', 'SUV', 'Coupe', 'Sedan', 'Crossover')))

            ->add('cust_name', null, array('label'=> '* Name', 'required' => true))
            ->add('cust_last_name', null, array('label'=> '* Last Name', 'required' => true))
            ->add('preferred_contact','choice',array('label'=>'* Preferred Contact','choices'=>array('Email','Phone')))
            ->add('email', null, array('label'=>'* Email', 'required' => true))
            ->add('day_phone', null, array('label'=>'* Day Phone', 'required' => true))
            ->add('cell_phone', null, array('label'=>'Cell Phone'))
            ->add('address', null, array('label'=>'* Address', 'required' => true))
            ->add('city', null, array('label'=>'* City', 'required' => true))
            ->add('state','text',array('label'=>'* State/Prov', 'required' => true))
            ->add('zip_code', null, array('label'=>'* ZIP Code', 'required' => true))

            ->add('ssn_sin_nr', null, array('label'=>'* SSN / SIN. No.', 'required' => true))
            ->add('birth_date', 'date', array('label'=>'* Date of Birth', 'required' => true,'years'       => range(date('Y')-16, date('Y') - 100, -1)))
            ->add('residence_type','choice',array('label'=>'* Residence Type', 'required' => true,'choices'=>array('Own'=>"Own",'Rent'=>"Rent")))
            ->add('monthly_payment', null, array('label'=> '* Monthly Payment', 'required' => true))
            ->add('at_residence', 'date', array('label'=> '* At Residence', 'required' => true,'years'       => range(date('Y'), date('Y') - 50, -1)))


            ->add('employer', null, array('label'=> '* Employer', 'required' => true))
            ->add('occupation', null, array('label'=> '* Occupation', 'required' => true))
            ->add('monthly_income', null, array('label'=> '* Monthly Income', 'required' => true))
            ->add('on_job', 'date', array('label'=> '* On Job', 'required' => true,'years'       => range(date('Y'), date('Y') - 50, -1)))
            ->add('business_phone', null, array('label'=> '* Business Phone', 'required' => true))
            ->add('employer_address', null, array('label'=> '* Address', 'required' => true))
            ->add('employer_city', null, array('label'=> '* City', 'required' => true))
            ->add('employer_state','text',array('label'=>'* State/Prov', 'required' => true))
            ->add('employer_zip', null, array('label'=> '* Zip/Postal', 'required' => true))

            ->add('source', null, array('label'=> 'Source', 'required' => true))
            ->add('other_monthly_income', null, array('label'=> 'Monthly Income', 'required' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Finance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_finance';
    }
}
