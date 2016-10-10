<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SaleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Vendor', 'entity',array(
                //'choices'   => $this->em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted(),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('sales_person')
            ->add('stock_nr')
            ->add('vin')
            ->add('invoice_nr')
            ->add('invoice_date')
            ->add('invoica_amt')
            ->add('related_taxes_1')
            ->add('related_taxes_2')
            ->add('delivery')
            ->add('clear_up')
            ->add('glass')
            ->add('mechanical_1')
            ->add('mechanical_2')
            ->add('other_exp_1')
            ->add('other_exp_2')
            ->add('other_exp_3')
            ->add('other_exp_4')
            ->add('other_exp_5')
            ->add('total_unit_cost')
            ->add('net_grain')
            ->add('protect_pkg')
            ->add('warranty')
            ->add('doc_fees')
            ->add('admin_fees')
            ->add('insurance')
            ->add('life_ins')
            ->add('disability_ins')
            ->add('feverse')
            ->add('misc_1')
            ->add('misc_2')
            ->add('misc_3')
            ->add('sales_comms')
            ->add('total_sale_cost')
            ->add('discrip1')
            ->add('discrip2')
            ->add('discrip3')
            ->add('discrip4')
            ->add('discrip5')
            ->add('discrip6')
            ->add('discrip7')
            ->add('tax_1_out')
            ->add('tax_2_out')
            ->add('trade_in_tax')
            ->add('tax_1_in')
            ->add('tax_2_in')
            ->add('net_tax')
            ->add('selling_price')
            ->add('trade_in')
            ->add('warranty1')
            ->add('life_insur')
            ->add('disability_ins1')
            ->add('admin_fees1')
            ->add('doc_fees1')
            ->add('protect_pkg1')
            ->add('insurance1')
            ->add('bank_commis')
            ->add('other_1')
            ->add('other_2')
            ->add('other_3')
            ->add('total_revenue')
            ->add('revenue_this_unit')
            //->add('item_id','hidden')
//            ->add('Vendor')
//            ->add('Item')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\Sale'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_sale';
    }
}
