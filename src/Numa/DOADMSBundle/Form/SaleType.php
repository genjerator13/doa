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
        $container = $options['container'];
        $dealer = $container->get("numa.dms.user")->getSignedDealer();
        $em = $container->get("doctrine.orm.entity_manager");
        $builder
            ->add('Vendor', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
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
            ->add('invoice_amt')
            ->add('related_taxes_1',null,array('label'=>'Taxes 1'))
            ->add('related_taxes_2',null,array('label'=>'Taxes 2'))
            ->add('delivery')
            ->add('clean_up')
            ->add('glass')
            ->add('mechanical_1')
            ->add('mechanical_2')
            ->add('other_exp_1')
            ->add('other_exp_2')
            ->add('other_exp_3')
            ->add('other_exp_4')
            ->add('other_exp_5')
            ->add('total_unit_cost')
            ->add('net_gain')
            ->add('protect_pkg')
            ->add('warranty')
            ->add('doc_fees')
            ->add('admin_fees')
            ->add('insurance')
            ->add('life_ins')
            ->add('disability_ins')
            ->add('feverse',null,array('label'=>"Reverse"))
            ->add('misc_1')
            ->add('misc_2')
            ->add('misc_3')
            ->add('sales_comms')
            ->add('total_sale_cost')
            ->add('discrip1',null,array('label'=>'Description 1'))
            ->add('discrip2',null,array('label'=>'Description 2'))
            ->add('discrip3',null,array('label'=>'Description 3'))
            ->add('discrip4',null,array('label'=>'Description 4'))
            ->add('discrip5',null,array('label'=>'Description 5'))
            ->add('discrip6',null,array('label'=>'Description 6'))
            ->add('discrip7',null,array('label'=>'Description 7'))
            ->add('tax_1_out')
            ->add('tax_2_out')
            ->add('trade_in_tax')
            ->add('tax_1_in')
            ->add('tax_2_in')
            ->add('net_tax')
            ->add('selling_price')
            ->add('trade_in')
            ->add('warranty1',null,array('label'=>'Warranty'))
            ->add('life_insur')
            ->add('disability_ins1',null,array('label'=>'Disability Ins'))
            ->add('admin_fees1',null,array('label'=>'Admin Fees'))
            ->add('doc_fees1',null,array('label'=>'Doc Fees'))
            ->add('protect_pkg1',null,array('label'=>'Protect PKG'))
            ->add('insurance1',null,array('label'=>'Insurance'))
            ->add('bank_commis')
            ->add('other_1')
            ->add('other_2')
            ->add('other_3')
            ->add('total_revenue')
            ->add('revenue_this_unit')
            ->add('supplier',null,array('label'=>'Supplier 1'))
            ->add('supplier1',null,array('label'=>'Supplier 2'))
            ->add('supplier2',null,array('label'=>'Supplier 3'))
            ->add('gst',null,array('attr' => array('maxlength' => '10')))
            ->add('gst1',null,array('attr' => array('maxlength' => '10')))
            ->add('gst2',null,array('attr' => array('maxlength' => '10')))
            ->add('gst3',null,array('attr' => array('maxlength' => '10')))
            ->add('gst4',null,array('attr' => array('maxlength' => '10')))
            ->add('gst5',null,array('attr' => array('maxlength' => '10')))
            ->add('gst6',null,array('attr' => array('maxlength' => '10')))
            ->add('gst7',null,array('attr' => array('maxlength' => '10')))
            ->add('gst8',null,array('attr' => array('maxlength' => '10')))
            ->add('gst9',null,array('attr' => array('maxlength' => '10')))
            ->add('unit_tax_other')
            ->add('submitAndPrint', 'submit', array('label' => 'Submit and Print', 'attr' => array('class' => 'btn btn-primary')));

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

    public function getParent()
    {
        return 'container_aware';
    }
}
