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
            ->add('customer_id')
            ->add('dealer_id')
            ->add('item_id')
            ->add('dealer_nr', null, array('label' => false))
            ->add('sales_person', null, array('label' => false))
            ->add('trim', null, array('label' => false))
            ->add('tid_make', null, array('label' => false))
            ->add('tid_model', null, array('label' => false))
            ->add('tid_year', null, array('label' => false))
            ->add('tid_milleage', null, array('label' => false))
            ->add('tid_km')
            ->add('tid_vin')
            ->add('payableto')
            ->add('address')
            ->add('amount')
            ->add('total')
            ->add('less_discount')
            ->add('options_total_cost')
            ->add('date_created')
            ->add('date_updated')
            ->add('status')
            ->add('comments')
            ->add('date_billing','text',array('attr'=>array('class'=>'datepicker'),'label' => false))
            ->add('opt1')
            ->add('opteq1')
            ->add('opt2')
            ->add('opteq2')
            ->add('opt3')
            ->add('opteq3')
            ->add('opt4')
            ->add('opteq4')
            ->add('opt5')
            ->add('opteq5')
            ->add('opt6')
            ->add('opteq6')
            ->add('opt7')
            ->add('opteq7')
            ->add('opt8')
            ->add('opteq8')
            ->add('opt9')
            ->add('opteq9')
            ->add('opt10')
            ->add('opteq10')
            ->add('sale_price')
            ->add('admin_fee')
            ->add('warranty')
            ->add('protection_pkg')
            ->add('tos_total')
            ->add('less_trade_in')
            ->add('difference_payable')
            ->add('tax1')
            ->add('tax2')
            ->add('tax3')
            ->add('other_misc1')
            ->add('other_misc2')
            ->add('text1_name')
            ->add('text2_name')
            ->add('text3_name')
            ->add('other_misc1_name')
            ->add('other_misc2_name')
            ->add('taxes_paid_total')
            ->add('lien_on_trade_in')
            ->add('total_due')
            ->add('less_trade_in_tax')
            ->add('less_deposit')
            ->add('payable_on_delivery')
            ->add('balance_to_finance')
            ->add('insurance')
            ->add('bank_registration_fee')
            ->add('total_balance_due')
            ->add('Customer')
            ->add('Dealer')
            ->add('Item')
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
