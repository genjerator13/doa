<?php

namespace Numa\DOADMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('Vendor_Delivery', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Clean_up', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Glass', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Body_shop', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Mechanical_1', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Mechanical_2', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_1', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_2', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_3', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_4', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_5', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_6', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Other_exp_7', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Protect_pkg', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Warranty', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Doc_fees', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Admin_fees', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Insurance', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Life_ins', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Disability_ins', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Feverse', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Misc_1', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Misc_2', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Misc_3', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('Vendor_Sales_comms', 'entity',array(
                'choices'   => $em->getRepository('NumaDOADMSBundle:Vendor')->findAllNotDeleted($dealer),
                'class' => 'Numa\DOADMSBundle\Entity\Vendor',
                'required'  => false,
                'empty_value' => 'Choose Vendor',
                'label' => "Vendor", "required" => false
            ))
            ->add('sales_person')
            ->add('stock_nr',null,array('label'=>"Stock #"))
            ->add('vin',null,array('label'=>"VIN #"))
            ->add('invoice_nr')
            ->add('invoice_date', 'date', array(
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-dd-MM',
                'attr' => array('class' => 'datepicker')
            ))
            ->add('invoice_amt',null,array())
            ->add('invoice_amt_gst',null,array('label'=>'Inv AMT with GST'))
            ->add('related_taxes_1',null,array('label'=>'PST'))
            ->add('related_taxes_2',null,array('label'=>'GST'))
            ->add('delivery',null,array())
            ->add('lot_pak',null,array())
            ->add('tag_fee',null,array())
            ->add('clean_up',null,array())
            ->add('glass',null,array())
            ->add('body_shop',NumberType::class,array('required'  => false))
            ->add('mechanical_1',null,array())
            ->add('mechanical_2',null,array())
            ->add('other_exp_1',null,array())
            ->add('other_exp_2',null,array())
            ->add('other_exp_3',null,array())
            ->add('other_exp_4',null,array())
            ->add('other_exp_5',null,array())
            ->add('other_exp_6',NumberType::class,array('required'  => false))
            ->add('other_exp_7',NumberType::class,array('required'  => false))
            ->add('total_unit_cost',null,array())
            ->add('net_gain',null,array())
            ->add('protect_pkg',null,array())
            ->add('warranty',null,array())
            ->add('doc_fees',null,array())
            ->add('admin_fees',null,array())
            ->add('insurance',null,array())
            ->add('life_ins',null,array())
            ->add('disability_ins',null,array())
            ->add('feverse',null,array('label'=>"Reserve"))
            ->add('misc_1',null,array())
            ->add('misc_2',null,array())
            ->add('misc_3',null,array())
            ->add('sales_comms',null,array())
            ->add('total_sale_cost',null,array())
            ->add('desc_delivery','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_clean_up','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_body_shop','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_glass','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_mechanical_1','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_mechanical_2','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_1','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_2','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_3','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_4','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_5','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_6','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('desc_other_exp_7','textarea',array('label'=>'Descrip','required'  => false,'attr' => array('rows' => '1')))
            ->add('tax_1_out',null,array('label'=>'PST on Purchases'))
            ->add('tax_2_out',null,array('label'=>'GST on Purchases'))
            ->add('trade_in_tax',null)
            ->add('tax_1_in',null,array('label'=>'PST on Sale'))
            ->add('tax_2_in',null,array('label'=>'GST on Sale'))
            ->add('net_tax',null)
            ->add('selling_price',null,array('label'=>'Sold for'))
            ->add('trade_in',null,array())
            ->add('warranty1',null,array('label'=>'Warranty'))
            ->add('life_insur',null,array())
            ->add('disability_ins1',null,array('label'=>'Disability Ins'))
            ->add('admin_fees1',null,array('label'=>'Other Fees'))
            ->add('doc_fees1',null,array('label'=>'Doc Fees'))
            ->add('protect_pkg1',null,array('label'=>'Protect PKG'))
            ->add('insurance1',null,array('label'=>'Insurance'))
            ->add('bank_commis',null,array())
            ->add('other_1',null,array())
            ->add('other_2',null,array())
            ->add('other_3',null,array())
            ->add('total_revenue',null,array())
            ->add('revenue_this_unit',null,array())
            ->add('gst_delivery',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_clean_up',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_glass',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_body_shop',NumberType::class,array('attr' => array('maxlength' => '10'),'required'  => false))
            ->add('gst_mechanical_1',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_mechanical_2',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_other_exp_1',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_other_exp_2',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_other_exp_3',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_other_exp_4',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_other_exp_5',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_other_exp_6',NumberType::class,array('attr' => array('maxlength' => '10'),'required'  => false))
            ->add('gst_other_exp_7',NumberType::class,array('attr' => array('maxlength' => '10'),'required'  => false))
            ->add('unit_tax_other',null,array('label'=>'GST on Expences'))
            ->add('gst_protect_pkg',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_warranty',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_doc_fees',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_admin_fees',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_insurance',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_life_ins',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_disability_ins',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_feverse',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_misc_1',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_misc_2',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_misc_3',null,array('attr' => array('maxlength' => '10')))
            ->add('gst_sales_comms',null,array('attr' => array('maxlength' => '10')))
            ->add('submitAndPrint', 'submit', array('label' => 'Submit and Print', 'attr' => array('class' => 'btn btn-primary')))
            ->add('as_price',null,array('label'=>'ASP','attr' => array('maxlength' => '10')))
            ->add('ac_value',null,array('label'=>'ACV','attr' => array('maxlength' => '10')))
            ->add('note','textarea',array('label'=>'Note','required'  => false,'attr' => array('rows' => '4')))
            ->add('calculate_gst', 'checkbox', array('label' => 'Manual Calculate GST', 'required' => false))
            ->add('calculate_gst_1', 'checkbox', array('label' => 'Manual Calculate GST', 'required' => false))
            ->add('manual_invoice_gst', 'checkbox', array('label' => 'Manual Invoice GST', 'required' => false))
            ->add('manual_gst', 'checkbox', array('label' => 'Manual GST', 'required' => false))
        ;

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
