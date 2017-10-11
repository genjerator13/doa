<?php

namespace Numa\CCCAdminBundle\Form;

use Genemu\Bundle\FormBundle\Form\JQuery\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('custcode')
            ->add('name')
            ->add('address1')
            ->add('address2')
            ->add('city')
            ->add('prov')
            ->add('postal')
            ->add('phone')
            ->add('fax')
            ->add('duedays')
            ->add('lastpay')
            ->add('lastpur')
            ->add('totbalan')
            ->add('comments')
            ->add('taxcode')
            ->add('custsurchargerate')
            ->add('note')
            ->add('zerodays')
            ->add('thirtydays')
            ->add('sixtydays')
            ->add('ninetydays')
            ->add('discount')
            ->add('ratelevel')
            ->add('email')
            ->add('website')
            ->add('cell')
            ->add('cityprovpostal')
            ->add('addressblock')
            ->add('revised')
            ->add('status')
            ->add('sendmail')
            ->add('contact')
            ->add('username')
            ->add('password', 'password', array('required' => false))
            ->add('terminalid')
            ->add('israteoverride')
            ->add('ishwyrateoverride')
            ->add('isAdmin')
            ->add('custhwysurchargerate');

        $container = $options['container'];

        if ($container->get('security.authorization_checker')->isGranted("ROLE_SUPER_ADMIN") || $container->get('security.authorization_checker')->isGranted("ROLE_OCR")) {
            $builder->add('user_group', ChoiceType::class, array('choices' => array("Regular" => "Regular Customer", "OCR" => "OCR")));
            $builder->add('rate_pdf_file',FileType::class, array('file_path' => 'webPath', 'required' => false));
            $builder->add('delete_rate',SubmitType::class, array('label' => 'Update and delete rate',"attr"=>array("class"=>"btn btn-danger")));
        }
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\Customers'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'numa_cccadminbundle_customers';
    }

    public function getParent()
    {
        return ContainerAwareType::class;
    }
}
