<?php

namespace Numa\DOADMSBundle\Form;

use Numa\DOADMSBundle\Entity\SaveSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SaveSearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bodyStyle',null,array('label'=>'Body Style', 'required'=>true))
            ->add('make', null, array('label'=>'Make'))
            ->add('model', null, array('label'=>'Model'))
            ->add('yearFrom', null, array('label'=>'Year from'))
            ->add('yearTo', null, array('label'=>'Year to'))
            ->add('custName', null, array('label'=>'Full Name'))
            ->add('period',ChoiceType::class,array('label'=>'Period', 'required'=>true,'choices'=>array(1=>'1 week',2=>'2 week',3=>'3 week',4=>'4 week',8=>'8 week',16=>'16 week',)))
            ->add('phone', null, array('label'=>'Phone'))
            ->add('email', null, array('label'=>'Email'))
            ->add('contact_by','choice',array('label'=>'Contact Me By *','choices'=>array('Email'=>"Email",'Phone'=>"Phone")))
            ->add('comment')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SaveSearch::class,
            'csrf_protection' => false,
            //'data_class' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'save_search';
    }
}
