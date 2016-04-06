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
            ->add('dealer_id')
            ->add('item_id','hidden')
            ->add('dealer_nr', null, array('label' => false))
            ->add('sales_person', null, array('label' => false))
            ->add('trim', null, array('label' => false))
            ->add('tid_make', null, array('label' => false))
            ->add('tid_model', null, array('label' => false))
            ->add('tid_year', null, array('label' => false))
            ->add('tid_milleage', null, array('label' => false))
            ->add('tid_km', null, array('label' => false))
            ->add('tid_vin', null, array('label' => false))
            ->add('payableto', null, array('label' => false))
            ->add('address', null, array('label' => false))
            ->add('amount', null, array('label' => false))
            ->add('total', null, array('label' => false))
            ->add('less_discount', null, array('label' => false))
            ->add('options_total_cost', null, array('label' => false))
            ->add('date_created', null, array('label' => false))
            ->add('date_updated', null, array('label' => false))
            ->add('status', null, array('label' => false))
            ->add('comments', null, array('label' => false))
//            ->add('date_billing','date', array( 'label' => false,
//                                                'attr'=>array('class'=>'datepicker'),
//                                                'widget' => 'single_text',
//                                                'format' => 'dd-MM-yyyy'
//                                                ))
            ->add('date_billing','date',array(
                'label' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'datepicker')
            ))
            //->add('date_billing','text',array('attr'=>array('class'=>'datepicker'),'label' => false))
            ->add('opt1', null, array('label' => false))
            ->add('opteq1', null, array('label' => false))
            ->add('opt2', null, array('label' => false))
            ->add('opteq2', null, array('label' => false))
            ->add('opt3', null, array('label' => false))
            ->add('opteq3', null, array('label' => false))
            ->add('opt4', null, array('label' => false))
            ->add('opteq4', null, array('label' => false))
            ->add('opt5', null, array('label' => false))
            ->add('opteq5', null, array('label' => false))
            ->add('opt6', null, array('label' => false))
            ->add('opteq6', null, array('label' => false))
            ->add('opt7', null, array('label' => false))
            ->add('opteq7', null, array('label' => false))
            ->add('opt8', null, array('label' => false))
            ->add('opteq8', null, array('label' => false))
            ->add('opt9', null, array('label' => false))
            ->add('opteq9', null, array('label' => false))
            ->add('opt10', null, array('label' => false))
            ->add('opteq10', null, array('label' => false))
            ->add('sale_price', null, array('label' => false))
            ->add('admin_fee', null, array('label' => false))
            ->add('warranty', null, array('label' => false))
            ->add('protection_pkg', null, array('label' => false))
            ->add('tos_total', null, array('label' => false))
            ->add('less_trade_in', null, array('label' => false))
            ->add('difference_payable', null, array('label' => false))
            ->add('tax1', null, array('label' => false))
            ->add('tax2', null, array('label' => false))
            ->add('tax3', null, array('label' => false))
            ->add('other_misc1', null, array('label' => false))
            ->add('other_misc2', null, array('label' => false))
            ->add('taxt1_name', null, array('label' => false))
            ->add('taxt2_name', null, array('label' => false))
            ->add('taxt3_name', null, array('label' => false))
            ->add('other_misc1_name', null, array('label' => false))
            ->add('other_misc2_name', null, array('label' => false))
            ->add('taxes_paid_total', null, array('label' => false))
            ->add('lien_on_trade_in', null, array('label' => false))
            ->add('total_due', null, array('label' => false))
            ->add('less_trade_in_tax', null, array('label' => false))
            ->add('less_deposit', null, array('label' => false))
            ->add('payable_on_delivery', null, array('label' => false))
            ->add('balance_to_finance', null, array('label' => false))
            ->add('insurance', null, array('label' => false))
            ->add('bank_registration_fee', null, array('label' => false))
            ->add('total_balance_due', null, array('label' => false))
            ->add('Customer', null, array('label' => false))
            ->add('Dealer', null, array('label' => false))
            ->add('Item', null, array('label' => false))
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
