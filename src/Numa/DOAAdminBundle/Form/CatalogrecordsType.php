<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogrecordsType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public $securityContext;

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('legal_trade_name')
            ->add('biweekly_url')
            ->add('Dcategory', 'entity', array('label' => 'Dealer Category',
                'class' => 'Numa\DOAAdminBundle\Entity\Dcategory',
                'property' => 'name',
                'expanded' => true,
                'multiple' => true,))
            ->add('username')
            ->add('url')
            ->add('dealerId')
            ->add('dealer_number',null,array('label' => 'Dealer #'))
            ->add('email')
            ->add('finance_email')
            ->add('address')
            ->add('fax')
            ->add('phone')
            ->add('service_phone')
            ->add('contact')
            ->add('city')
            ->add('zip')
            ->add('country')
            ->add('state')
            ->add('gst')
            ->add('description', 'ckeditor')
            ->add('ServiceHours', 'ckeditor')
            ->add('terms_text', 'ckeditor', array('label' => 'Terms & Conditions', 'required' => false, 'data_class' => null))
            ->add('file_import_source', 'file', array('label' => 'Logo Upload', 'required' => false, 'data_class' => null))
            ->add('logo_url', 'text', array('label' => 'Logo Url', 'required' => false))
            ->add('password', 'password', array('required' => false));
        if (!empty($this->securityContext) && $this->securityContext->isGranted('ROLE_BUSINES')) {
            $builder->remove('logo_url');
        }

        if (!empty($this->securityContext) && $this->securityContext->isGranted('ROLE_ADMIN')) {
            $builder->add('Admindealer', 'checkbox', array('required' => false));
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Catalogrecords'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_catalogrecords';
    }

}
