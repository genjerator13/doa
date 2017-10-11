<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProbillsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isinvoiced')
            ->add('shipmentmode')
            ->add('pDate')
            ->add('driver_code')
            ->add('customer_code')
            ->add('ref')
            ->add('servType')
            ->add('customer')
            ->add('dept')
            ->add('waybill')
            ->add('shipper')
            ->add('pickupHr')
            ->add('pickupMn')
            ->add('deliveryHr')
            ->add('deliveryMn')
            ->add('pU')
            ->add('dE')
            ->add('receiver')
            ->add('pce')
            ->add('wgt')
            ->add('rate_code')
            ->add('rateDescription')
            ->add('paygst')
            ->add('rateAmt')
            ->add('extraPiece')
            ->add('extraPceRate')
            ->add('extraAmt')
            ->add('miscAmt')
            ->add('miscdesc')
            ->add('gstAmt')
            ->add('grandtotal')
            ->add('paid')
            ->add('balance')
            ->add('drvRate')
            ->add('drvTotal')
            ->add('gross')
            ->add('comments')
            ->add('signature')
            ->add('ttimeH')
            ->add('ttimeM')
            ->add('invoice')
            ->add('waitime')
            ->add('waitchrg')
            ->add('vehicleId')
            ->add('trailerId')
            ->add('batch')
            ->add('rushAmt')
            ->add('called')
            ->add('delivered')
            ->add('deliverytime')
            ->add('status')
            ->add('custsurchargeamt')
            ->add('drvsurrate')
            ->add('cussurchargerate')
            ->add('driversurcharge')
            ->add('total')
            ->add('taxcode')
            ->add('drvgross')
            ->add('trailerchg')
            ->add('miles')
            ->add('pickupShipper')
            ->add('pickupAddr1')
            ->add('pickupAddr2')
            ->add('pickupCity')
            ->add('pickupProv')
            ->add('pickupPostal')
            ->add('pickupPhone')
            ->add('pickupContact')
            ->add('pickupDetail')
            ->add('pickupRef')
            ->add('shiptoReceiver')
            ->add('shiptoAddr1')
            ->add('shiptoAddr2')
            ->add('shiptoCity')
            ->add('shiptoProv')
            ->add('shiptoPostal')
            ->add('shiptoPhone')
            ->add('shiptoContact')
            ->add('shiptoDetail')
            ->add('shiptoRef')
            ->add('posted')
            ->add('printed')
            ->add('commodity')
            ->add('routecode')
            ->add('tracking')
            ->add('barcode')
            ->add('details')
            ->add('glaccount')
            ->add('paymenttype')
            ->add('payref')
            ->add('codAmt')
            ->add('subitem')
            ->add('entrydate')
            ->add('shipmentid')
            ->add('ratelevel')
            ->add('subtotal')
            ->add('billtype')
            ->add('fuelsurchargedifferential')
            ->add('diffsurchargeamt')
            ->add('commodityId')
            ->add('initials')
            ->add('shiptoId')
            ->add('pickupfromId')
            ->add('createdAt')
            ->add('vehcode')
            ->add('customers')
            ->add('rates')
            ->add('vehtypes')
            ->add('drivers')
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\Probills'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_cccadminbundle_probills';
    }
}
