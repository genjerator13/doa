<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FinanceServiceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dealer_id', 'hidden')
            ->add('customer_id', 'hidden')

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
            ->add('landlord_name')
            ->add('landlord_phone', null, array('label'=>'Phone #'))

            ->add('employer_name', null, array('label'=> '* Employer', 'required' => true))
            ->add('employer_occupation', null, array('label'=> '* Occupation', 'required' => true))
            ->add('employer_monthly_income', null, array('label'=> '* Monthly Income', 'required' => true))
            ->add('employer_on_job', 'date', array('label'=> '* On Job', 'required' => true,'years'       => range(date('Y'), date('Y') - 50, -1)))
            ->add('employer_business_phone', null, array('label'=> '* Business Phone', 'required' => true))
            ->add('employer_address', null, array('label'=> '* Address', 'required' => true))
            ->add('employer_city', null, array('label'=> '* City', 'required' => true))
            ->add('employer_state','text',array('label'=>'* State/Prov', 'required' => true))
            ->add('employer_zip', null, array('label'=> '* Zip/Postal', 'required' => true))


            ->add('supervisors_name')
            ->add('other_name', null, array('label'=>'* Name'))
            ->add('other_address', null, array('label'=>'* Address'))
            ->add('other_city', null, array('label'=> '* City'))
            ->add('other_state','text',array('label'=>'* State/Prov'))
            ->add('other_zip', null, array('label'=> '* Zip/Postal'))
            ->add('other_home_phone', null, array('label'=> 'Home Phone'))
            ->add('other_work_phone', null, array('label'=> 'Work Phone'))
            ->add('make')
            ->add('model')
            ->add('year')
            ->add('vehicle_type')
            ->add('plate')
            ->add('vin')
            ->add('mileage')
            ->add('financed_by')
            ->add('message_text','textarea', array('attr' => array('rows' => '10'), 'label'=> 'Summary Description Of Service Work'))
            ->add('Dealer', 'hidden')
            ->add('Customer', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\FinanceService'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_financeservice';
    }
}
