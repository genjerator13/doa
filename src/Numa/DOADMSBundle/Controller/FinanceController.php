<?php

namespace Numa\DOADMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Numa\DOADMSBundle\Entity\Finance;
use Numa\DOADMSBundle\Form\ServiceRequestType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FinanceController extends Controller
{
    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $finance = new Finance();
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
        $form = $this->createFormBuilder($finance)

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
            ->add('state',text,array('label'=>'* State/Prov.', 'required' => true))
            ->add('zip_code', null, array('label'=>'* ZIP Code', 'required' => true))

            ->add('ssn_sin_nr', null, array('label'=>'* SSN / SIN. No.', 'required' => true))
            ->add('birth_date', 'date', array('label'=>'* Date of Birth', 'required' => true))
            ->add('residence_type','choice',array('label'=>'* Residence Type', 'required' => true,'choices'=>array('Own'=>"Own",'Rent'=>"Rent")))
            ->add('monthly_payment', null, array('label'=> '* Monthly Payment', 'required' => true))
            ->add('at_residence', 'date', array('label'=> '* At Residence', 'required' => true))


            ->add('employer', null, array('label'=> '* Employer', 'required' => true))
            ->add('occupation', null, array('label'=> '* Occupation', 'required' => true))
            ->add('monthly_income', null, array('label'=> '* Monthly Income', 'required' => true))
            ->add('on_job', 'date', array('label'=> '* On Job', 'required' => true))
            ->add('business_phone', null, array('label'=> '* Business Phone', 'required' => true))
            ->add('employer_address', null, array('label'=> '* Address', 'required' => true))
            ->add('employer_city', null, array('label'=> '* City', 'required' => true))
            ->add('employer_state','choice',array('label'=>'* State/Prov', 'required' => true,'choices'=>array('AR','')))
            ->add('employer_zip', null, array('label'=> '* Zip/Postal', 'required' => true))

            ->add('source', null, array('label'=> 'Source', 'required' => true))
            ->add('other_monthly_income', null, array('label'=> 'Monthly Income', 'required' => true))

            ->add('save', SubmitType::class, array('label' => 'Send'))
            ->getForm();

        return $this->render('NumaDOADMSBundle:Finance:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
