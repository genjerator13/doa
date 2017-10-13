<?php

namespace Numa\CCCAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public $name;
    public function __construct($name="") {
        $this->name=$name;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('name',HiddenType::class)
            ->add('value',null,array('label' => $this->name))
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\CCCAdminBundle\Entity\Settings'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        //dump("getName".$this->name);
        if(empty($this->name)){
            return 'numa_cccadminbundle_settings';
        }
        return $this->name;
    }
    
    public function setName($name){
        //dump("setName".$name);
        $this->name = $name;
    }
}
