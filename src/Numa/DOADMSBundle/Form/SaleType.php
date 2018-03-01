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
            ->add('invoice_amt',null,array('scale'=>2))
            ->add('related_taxes_1',null,array('label'=>'PST','scale'=>2))
            ->add('related_taxes_2',null,array('label'=>'GST','scale'=>2))
            ->add('delivery',null,array('scale'=>2))
            ->add('clean_up',null,array('scale'=>2))
            ->add('glass',null,array('scale'=>2))
            ->add('body_shop',NumberType::class,array('scale'=>2,'required'  => false))
            ->add('mechanical_1',null,array('scale'=>2))
            ->add('mechanical_2',null,array('scale'=>2))
            ->add('other_exp_1',null,array('scale'=>2))
            ->add('other_exp_2',null,array('scale'=>2))
            ->add('other_exp_3',null,array('scale'=>2))
            ->add('other_exp_4',null,array('scale'=>2))
            ->add('other_exp_5',null,array('scale'=>2))
            ->add('other_exp_6',NumberType::class,array('scale'=>2,'required'  => false))
            ->add('other_exp_7',NumberType::class,array('scale'=>2,'required'  => false))
            ->add('total_unit_cost',null,array('scale'=>2))
            ->add('net_gain',null,array('scale'=>2))
            ->add('protect_pkg',null,array('scale'=>2))
            ->add('warranty',null,array('scale'=>2))
            ->add('doc_fees',null,array('scale'=>2))
            ->add('admin_fees',null,array('scale'=>2))
            ->add('insurance',null,array('scale'=>2))
            ->add('life_ins',null,array('scale'=>2))
            ->add('disability_ins',null,array('scale'=>2))
            ->add('feverse',null,array('label'=>"Reserve",'scale'=>2))
            ->add('misc_1',null,array('scale'=>2))
            ->add('misc_2',null,array('scale'=>2))
            ->add('misc_3',null,array('scale'=>2))
            ->add('sales_comms',null,array('scale'=>2))
            ->add('total_sale_cost',null,array('scale'=>2))
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
            ->add('tax_1_out',null,array('label'=>'PST on Purchases','scale'=>2))
            ->add('tax_2_out',null,array('label'=>'GST on Purchases','scale'=>2))
            ->add('trade_in_tax',null,array('scale'=>2))
            ->add('tax_1_in',null,array('label'=>'PST on Sale','scale'=>2))
            ->add('tax_2_in',null,array('label'=>'GST on Sale','scale'=>2))
            ->add('net_tax',null,array('scale'=>2))
            ->add('selling_price',null,array('label'=>'Sold for','scale'=>2))
            ->add('trade_in',null,array('scale'=>2))
            ->add('warranty1',null,array('label'=>'Warranty','scale'=>2))
            ->add('life_insur',null,array('scale'=>2))
            ->add('disability_ins1',null,array('label'=>'Disability Ins','scale'=>2))
            ->add('admin_fees1',null,array('label'=>'Other Fees','scale'=>2))
            ->add('doc_fees1',null,array('label'=>'Doc Fees','scale'=>2))
            ->add('protect_pkg1',null,array('label'=>'Protect PKG','scale'=>2))
            ->add('insurance1',null,array('label'=>'Insurance','scale'=>2))
            ->add('bank_commis',null,array('scale'=>2))
            ->add('other_1',null,array('scale'=>2))
            ->add('other_2',null,array('scale'=>2))
            ->add('other_3',null,array('scale'=>2))
            ->add('total_revenue',null,array('scale'=>2))
            ->add('revenue_this_unit',null,array('scale'=>2))
            ->add('gst_delivery',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_clean_up',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_glass',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_body_shop',NumberType::class,array('attr' => array('maxlength' => '10'),'scale'=>2,'required'  => false))
            ->add('gst_mechanical_1',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_mechanical_2',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_other_exp_1',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_other_exp_2',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_other_exp_3',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_other_exp_4',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_other_exp_5',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_other_exp_6',NumberType::class,array('attr' => array('maxlength' => '10'),'scale'=>2,'required'  => false))
            ->add('gst_other_exp_7',NumberType::class,array('attr' => array('maxlength' => '10'),'scale'=>2,'required'  => false))
            ->add('unit_tax_other',null,array('label'=>'GST on Expences','scale'=>2))
            ->add('gst_protect_pkg',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_warranty',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_doc_fees',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_admin_fees',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_insurance',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_life_ins',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_disability_ins',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_feverse',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_misc_1',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_misc_2',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_misc_3',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('gst_sales_comms',null,array('attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('submitAndPrint', 'submit', array('label' => 'Submit and Print', 'attr' => array('class' => 'btn btn-primary')))
            ->add('as_price',null,array('label'=>'ASP','attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('ac_value',null,array('label'=>'ACV','attr' => array('maxlength' => '10'),'scale'=>2))
            ->add('note','textarea',array('label'=>'Note','required'  => false,'attr' => array('rows' => '4')))
            ->add('calculate_gst', 'checkbox', array('label' => 'Manual Calculate GST', 'required' => false))
            ->add('calculate_gst_1', 'checkbox', array('label' => 'Manual Calculate GST', 'required' => false))
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
