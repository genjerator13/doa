<?php

namespace Numa\DOADMSBundle\Form;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\UserGroup;
use Numa\DOADMSBundle\Events\DMSUserSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DMSUserType extends AbstractType
{
    public $securityContext;
    public function setSecurityContext($securityContext){
        $this->securityContext=$securityContext;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password','password',array('required' => false))
            ->add('email')
            ->add('active')
//            ->add('activation_key')
//            ->add('verification_key')
//            ->add('trusted_user')
//            ->add('balance')
            ->add('FirstName')
            ->add('LastName')
            ->add('Address')
            ->add('City')
            ->add('PostalCode')
            ->add('PhoneNumber')
            ->add('State')
            ->add('useSignatureBilling',CheckboxType::class,array("required"=>false));
        $builder
            ->add('UserGroup', EntityType::class,array(
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('ug')
                        ->where('ug.id>:id')
                        ->setParameter('id',1)
                        ;
                },
                'class' => UserGroup::class,
                'required'  => false,
                //'empty_value' => 'Choose User Group',
                'label' => "User Group"
            ));

        ;
        $builder->addEventSubscriber(new DMSUserSubscriber($options['container']));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOADMSBundle\Entity\DMSUser'
        ));
    }

    public function getParent() {
        return 'container_aware';
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doadmsbundle_dmsuser';
    }
}
