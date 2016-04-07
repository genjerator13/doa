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
            ->add('customer_id','hidden')
            ->add('dealer_id','hidden')
            ->add('item_id','hidden', array('label' => false,'attr'=>array('ng-value'=>'item_id')))
            ->add('dealer_nr', null, array('label' => false,'attr'=>array('ng-model'=>'dealer_nr')))
            ->add('sales_person', null, array('label' => false,'attr'=>array('ng-model'=>'sales_person')))
            ->add('trim', null, array('label' => false,'attr'=>array('ng-model'=>'trim')))
            ->add('tid_make', null, array('label' => false,'attr'=>array('ng-model'=>'tid_make')))
            ->add('tid_model', null, array('label' => false,'attr'=>array('ng-model'=>'tid_model')))
            ->add('tid_year', null, array('label' => false,'attr'=>array('ng-model'=>'tid_year')))
            ->add('tid_milleage', null, array('label' => false,'attr'=>array('ng-model'=>'tid_milleage')))
            ->add('tid_km', null, array('label' => false,'attr'=>array('ng-model'=>'tid_km')))
            ->add('tid_vin', null, array('label' => false,'attr'=>array('ng-model'=>'tid_vin')))
            ->add('payableto', null, array('label' => false,'attr'=>array('ng-model'=>'payableto')))
            ->add('address', null, array('label' => false,'attr'=>array('ng-model'=>'address')))
            ->add('amount', null, array('label' => false,'attr'=>array('ng-model'=>'amount')))
            ->add('total', null, array('label' => false,'attr'=>array('ng-model'=>'total')))
            ->add('less_discount', null, array('label' => false,'attr'=>array('ng-model'=>'less_discount')))
            ->add('options_total_cost', null, array('label' => false,'attr'=>array('ng-model'=>'options_total_cost')))
            ->add('date_created', null, array('label' => false,'attr'=>array('ng-model'=>'date_created')))
            ->add('date_updated', null, array('label' => false,'attr'=>array('ng-model'=>'date_updated')))
            ->add('status', null, array('label' => false,'attr'=>array('ng-model'=>'status')))
            ->add('comments', null, array('label' => false,'attr'=>array('ng-model'=>'comments')))
//            ->add('date_billing','date', array( 'label' => false,
//                                                'attr'=>array('class'=>'datepicker'),
//                                                'widget' => 'single_text',
//                                                'format' => 'dd-MM-yyyy'
//                                                ))
            ->add('date_billing','date',array(
                'label' => false,
                'required'=>false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'datepicker')
            ))
            //->add('date_billing','text',array('attr'=>array('class'=>'datepicker'),'label' => false))
            ->add('opt1', null, array('label' => false,'attr'=>array('ng-model'=>'opt1')))
            ->add('opteq1', null, array('label' => false,'attr'=>array('ng-model'=>'opteq1')))
            ->add('opt2', null, array('label' => false,'attr'=>array('ng-model'=>'opt2')))
            ->add('opteq2', null, array('label' => false,'attr'=>array('ng-model'=>'opteq2')))
            ->add('opt3', null, array('label' => false,'attr'=>array('ng-model'=>'opt3')))
            ->add('opteq3', null, array('label' => false,'attr'=>array('ng-model'=>'opteq3')))
            ->add('opt4', null, array('label' => false,'attr'=>array('ng-model'=>'opt4')))
            ->add('opteq4', null, array('label' => false,'attr'=>array('ng-model'=>'opteq4')))
            ->add('opt5', null, array('label' => false,'attr'=>array('ng-model'=>'opt5')))
            ->add('opteq5', null, array('label' => false,'attr'=>array('ng-model'=>'opteq5')))
            ->add('opt6', null, array('label' => false,'attr'=>array('ng-model'=>'opt6')))
            ->add('opteq6', null, array('label' => false,'attr'=>array('ng-model'=>'opteq6')))
            ->add('opt7', null, array('label' => false,'attr'=>array('ng-model'=>'opt7')))
            ->add('opteq7', null, array('label' => false,'attr'=>array('ng-model'=>'opteq7')))
            ->add('opt8', null, array('label' => false,'attr'=>array('ng-model'=>'opt8')))
            ->add('opteq8', null, array('label' => false,'attr'=>array('ng-model'=>'opteq8')))
            ->add('opt9', null, array('label' => false,'attr'=>array('ng-model'=>'opt9')))
            ->add('opteq9', null, array('label' => false,'attr'=>array('ng-model'=>'opteq9')))
            ->add('opt10', null, array('label' => false,'attr'=>array('ng-model'=>'opt10')))
            ->add('opteq10', null, array('label' => false,'attr'=>array('ng-model'=>'opteq10')))
            ->add('sale_price', null, array('label' => false,'attr'=>array('ng-model'=>'sale_price')))
            ->add('admin_fee', null, array('label' => false,'attr'=>array('ng-model'=>'admin_fee')))
            ->add('warranty', null, array('label' => false,'attr'=>array('ng-model'=>'warranty')))
            ->add('new_warranty', null, array('label' => false,'attr'=>array('ng-model'=>'new_warranty')))
            ->add('used_warranty', null, array('label' => false,'attr'=>array('ng-model'=>'used_warranty')))
            ->add('protection_pkg', null, array('label' => false,'attr'=>array('ng-model'=>'protection_pkg')))
            ->add('tos_total', null, array('label' => false,'attr'=>array('ng-model'=>'tos_total')))
            ->add('less_trade_in', null, array('label' => false,'attr'=>array('ng-model'=>'less_trade_in')))
            ->add('difference_payable', null, array('label' => false,'attr'=>array('ng-model'=>'difference_payable')))
            ->add('tax1', null, array('label' => false,'attr'=>array('ng-model'=>'tax1')))
            ->add('tax2', null, array('label' => false,'attr'=>array('ng-model'=>'tax2')))
            ->add('tax3', null, array('label' => false,'attr'=>array('ng-model'=>'tax3')))
            ->add('other_misc1', null, array('label' => false,'attr'=>array('ng-model'=>'other_misc1')))
            ->add('other_misc2', null, array('label' => false,'attr'=>array('ng-model'=>'other_misc2')))
            ->add('taxt1_name', null, array('label' => false,'attr'=>array('ng-model'=>'taxt1_name')))
            ->add('taxt2_name', null, array('label' => false,'attr'=>array('ng-model'=>'taxt2_name')))
            ->add('taxt3_name', null, array('label' => false,'attr'=>array('ng-model'=>'taxt3_name')))
            ->add('other_misc1_name', null, array('label' => false,'attr'=>array('ng-model'=>'other_misc1_name')))
            ->add('other_misc2_name', null, array('label' => false,'attr'=>array('ng-model'=>'other_misc2_name')))
            ->add('taxes_paid_total', null, array('label' => false,'attr'=>array('ng-model'=>'taxes_paid_total')))
            ->add('lien_on_trade_in', null, array('label' => false,'attr'=>array('ng-model'=>'lien_on_trade_in')))
            ->add('total_due', null, array('label' => false,'attr'=>array('ng-model'=>'total_due')))
            ->add('less_trade_in_tax', null, array('label' => false,'attr'=>array('ng-model'=>'less_trade_in_tax')))
            ->add('less_deposit', null, array('label' => false,'attr'=>array('ng-model'=>'less_deposit')))
            ->add('payable_on_delivery', null, array('label' => false,'attr'=>array('ng-model'=>'payable_on_delivery')))
            ->add('balance_to_finance', null, array('label' => false,'attr'=>array('ng-model'=>'balance_to_finance')))
            ->add('insurance', null, array('label' => false,'attr'=>array('ng-model'=>'insurance')))
            ->add('bank_registration_fee', null, array('label' => false,'attr'=>array('ng-model'=>'bank_registration_fee')))
            ->add('total_balance_due', null, array('label' => false,'attr'=>array('ng-model'=>'total_balance_due')))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Billing',
            'csrf_protection'   => false,
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
