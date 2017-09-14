<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BillingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer_id', 'hidden')
            ->add('dealer_id', 'hidden')
            ->add('item_id', 'hidden', array('label' => false, 'attr' => array('ng-value' => 'item_id')))
            //->add('item_id','hidden')
            ->add('dealer_nr', null, array('label' => false, 'attr' => array('ng-model' => 'dealer_nr')))
            ->add('sales_person', null, array('label' => false, 'attr' => array('ng-model' => 'sales_person')))
            ->add('invoice_nr', null, array('label' => false, 'attr' => array('ng-model' => 'invoice_nr')))
            ->add('trim', null, array('label' => false, 'attr' => array('ng-model' => 'trim')))
            ->add('tid_make', null, array('label' => false, 'attr' => array('ng-model' => 'tid_make')))
            ->add('tid_model', null, array('label' => false, 'attr' => array('ng-model' => 'tid_model')))
            ->add('tid_color', null, array('label' => false, 'attr' => array('ng-model' => 'tid_color')))
            ->add('tid_year', null, array('label' => false, 'attr' => array('ng-model' => 'tid_year')))
            ->add('tid_milleage', null, array('label' => false, 'attr' => array('ng-model' => 'tid_milleage')))
            ->add('tid_km', null, array('label' => false, 'attr' => array('ng-model' => 'tid_km')))
            ->add('tid_vin', null, array('label' => false, 'attr' => array('ng-model' => 'tid_vin')))
            ->add('payableto', null, array('label' => false, 'attr' => array('ng-model' => 'payableto')))
            ->add('address', null, array('label' => false, 'attr' => array('ng-model' => 'address')))
            ->add('amount', null, array('label' => false, 'attr' => array('ng-model' => 'amount')))
            ->add('total', null, array('label' => false, 'attr' => array('ng-model' => 'total')))
            ->add('less_discount', null, array('label' => false, 'attr' => array('ng-model' => 'less_discount')))
            ->add('options_total_cost', null, array('label' => false, 'attr' => array('ng-model' => 'options_total_cost')))
            ->add('status', null, array('label' => false, 'attr' => array('ng-model' => 'status')))
            ->add('comments', null, array('label' => false, 'attr' => array('ng-model' => 'comments')))
//            ->add('date_billing','date', array( 'label' => false,
//                                                'attr'=>array('class'=>'datepicker'),
//                                                'widget' => 'single_text',
//                                                'format' => 'dd-MM-yyyy'
//                                                ))
            ->add('date_billing', 'date', array(
                'label' => false,
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-dd-MM',
                'attr' => array('class' => 'datepicker')
            ))
            //->add('date_billing','text',array('attr'=>array('class'=>'datepicker'),'label' => false))
            ->add('active', null, array('label' => "Active"))
            ->add('opt1', null, array('label' => false, 'attr' => array('ng-model' => 'opt1')))
            ->add('opteq1', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq1')))
            ->add('opt2', null, array('label' => false, 'attr' => array('ng-model' => 'opt2')))
            ->add('opteq2', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq2')))
            ->add('opt3', null, array('label' => false, 'attr' => array('ng-model' => 'opt3')))
            ->add('opteq3', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq3')))
            ->add('opt4', null, array('label' => false, 'attr' => array('ng-model' => 'opt4')))
            ->add('opteq4', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq4')))
            ->add('opt5', null, array('label' => false, 'attr' => array('ng-model' => 'opt5')))
            ->add('opteq5', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq5')))
            ->add('opt6', null, array('label' => false, 'attr' => array('ng-model' => 'opt6')))
            ->add('opteq6', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq6')))
            ->add('opt7', null, array('label' => false, 'attr' => array('ng-model' => 'opt7')))
            ->add('opteq7', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq7')))
            ->add('opt8', null, array('label' => false, 'attr' => array('ng-model' => 'opt8')))
            ->add('opteq8', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq8')))
            ->add('opt9', null, array('label' => false, 'attr' => array('ng-model' => 'opt9')))
            ->add('opteq9', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq9')))
            ->add('opt10', null, array('label' => false, 'attr' => array('ng-model' => 'opt10')))
            ->add('opteq10', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq10')))
            ->add('opteq11', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq11')))
            ->add('opt11', null, array('label' => false, 'attr' => array('ng-model' => 'opt11')))
            ->add('opteq12', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq12')))
            ->add('opt12', null, array('label' => false, 'attr' => array('ng-model' => 'opt12')))
            ->add('opteq13', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq13')))
            ->add('opt13', null, array('label' => false, 'attr' => array('ng-model' => 'opt13')))
            ->add('opteq14', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq14')))
            ->add('opt14', null, array('label' => false, 'attr' => array('ng-model' => 'opt14')))
            ->add('opteq15', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq15')))
            ->add('opt15', null, array('label' => false, 'attr' => array('ng-model' => 'opt15')))
            ->add('opteq16', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq16')))
            ->add('opt16', null, array('label' => false, 'attr' => array('ng-model' => 'opt16')))
            ->add('opteq17', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq17')))
            ->add('opt17', null, array('label' => false, 'attr' => array('ng-model' => 'opt17')))
            ->add('opteq18', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq18')))
            ->add('opt18', null, array('label' => false, 'attr' => array('ng-model' => 'opt18')))
            ->add('opteq19', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq19')))
            ->add('opt19', null, array('label' => false, 'attr' => array('ng-model' => 'opt19')))
            ->add('opteq20', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq20')))
            ->add('opt20', null, array('label' => false, 'attr' => array('ng-model' => 'opt20')))
            ->add('opteq21', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq21')))
            ->add('opt21', null, array('label' => false, 'attr' => array('ng-model' => 'opt21')))
            ->add('opteq22', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq22')))
            ->add('opt22', null, array('label' => false, 'attr' => array('ng-model' => 'opt22')))
            ->add('opteq23', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq23')))
            ->add('opt23', null, array('label' => false, 'attr' => array('ng-model' => 'opt23')))
            ->add('opteq24', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq24')))
            ->add('opt24', null, array('label' => false, 'attr' => array('ng-model' => 'opt24')))
            ->add('opteq25', null, array('label' => false, 'attr' => array('maxlength' => 4, 'size' => 4, 'ng-model' => 'opteq25')))
            ->add('opt25', null, array('label' => false, 'attr' => array('ng-model' => 'opt25')))
            ->add('sale_price', null, array('label' => false, 'attr' => array('ng-model' => 'sale_price')))
            ->add('admin_fee', null, array('label' => false, 'attr' => array('ng-model' => 'admin_fee')))
            ->add('warranty', null, array('label' => false, 'attr' => array('ng-model' => 'warranty')))
            ->add('new_warranty', null, array('label' => false, 'attr' => array('ng-model' => 'new_warranty')))
            ->add('used_warranty', null, array('label' => false, 'attr' => array('ng-model' => 'used_warranty')))
            ->add('protection_pkg', null, array('label' => false, 'attr' => array('ng-model' => 'protection_pkg')))
            ->add('tos_total', null, array('label' => false, 'attr' => array('ng-model' => 'tos_total')))
            ->add('less_trade_in', null, array('label' => false, 'attr' => array('ng-model' => 'less_trade_in')))
            ->add('difference_payable', null, array('label' => false, 'attr' => array('ng-model' => 'difference_payable')))
            ->add('tax1', null, array('label' => false, 'attr' => array('ng-model' => 'tax1')))
            ->add('tax2', null, array('label' => false, 'attr' => array('ng-model' => 'tax2')))
            ->add('tax3', null, array('label' => false, 'attr' => array('ng-model' => 'tax3')))
            ->add('other_misc1', null, array('label' => false, 'attr' => array('ng-model' => 'other_misc1')))
            ->add('other_misc2', null, array('label' => false, 'attr' => array('ng-model' => 'other_misc2')))
            ->add('taxt1_name', null, array('label' => false, 'attr' => array('ng-model' => 'taxt1_name')))
            ->add('taxt2_name', null, array('label' => false, 'attr' => array('ng-model' => 'taxt2_name')))
            ->add('taxt3_name', null, array('label' => false, 'attr' => array('ng-model' => 'taxt3_name')))
            ->add('other_misc1_name', null, array('label' => false, 'attr' => array('ng-model' => 'other_misc1_name')))
            ->add('other_misc2_name', null, array('label' => false, 'attr' => array('ng-model' => 'other_misc2_name')))
            ->add('taxes_paid_total', null, array('label' => false, 'attr' => array('ng-model' => 'taxes_paid_total')))
            ->add('lien_on_trade_in', null, array('label' => false, 'attr' => array('ng-model' => 'lien_on_trade_in')))
            ->add('total_due', null, array('label' => false, 'attr' => array('ng-model' => 'total_due')))
            ->add('less_trade_in_tax', null, array('label' => false, 'attr' => array('ng-model' => 'less_trade_in_tax')))
            ->add('less_deposit', null, array('label' => false, 'attr' => array('ng-model' => 'less_deposit')))
            ->add('payable_on_delivery', null, array('label' => false, 'attr' => array('ng-model' => 'payable_on_delivery')))
            ->add('balance_to_finance', null, array('label' => false, 'attr' => array('ng-model' => 'balance_to_finance')))
            ->add('insurance', null, array('label' => false, 'attr' => array('ng-model' => 'insurance')))
            ->add('bank_registration_fee', null, array('label' => false, 'attr' => array('ng-model' => 'bank_registration_fee')))
            ->add('total_balance_due', null, array('label' => false, 'attr' => array('ng-model' => 'total_balance_due')))
            ->add('life_insurance', null, array('label' => false, 'attr' => array('ng-model' => 'life_insurance')))
            ->add('disability_insurance', null, array('label' => false, 'attr' => array('ng-model' => 'disability_insurance')))
            ->add('work_order', 'checkbox', array('label' => 'Work Order', 'attr' => array('ng-model' => 'work_order'), 'required' => false))
            ->add('submitxxx', 'submit', array('label' => 'Submit', 'attr' => array('class' => 'btn btn-primary')))
            ->add('submitAndPrint', 'submit', array('label' => 'Submit and Print', 'attr' => array('class' => 'btn btn-primary')))
            ->add('qb_post_include',null,array('label'    => 'Post to Quickbooks',"data"=>true))
            ->add('manual_gst', null, array('label' => "Manual", 'attr' => array('ng-model' => 'manual_gst')))
            ->add('manual_pst', null, array('label' => "Manual", 'attr' => array('ng-model' => 'manual_pst')))
            ->add('as_price', null, array('label' => false, 'attr' => array('ng-model' => 'as_price')))
            ->add('ac_value', null, array('label' => false, 'attr' => array('ng-model' => 'ac_value')))
;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Billing',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_billing';
    }
}
