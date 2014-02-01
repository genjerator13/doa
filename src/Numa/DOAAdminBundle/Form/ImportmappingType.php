<?php

namespace Numa\DOAAdminBundle\Form;

use Numa\DOAAdminBundle\Entity\ListingfieldRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Numa\DOAAdminBundle\Events\AddFeedSourceSubscriber;

class ImportmappingType extends AbstractType
{
    public function __construct($feed_cid = null, $properties = null,$em)
    {
        $this->feed_cid = $feed_cid;
        $this->properties = $properties;
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sid')
            ->add('description', 'text', array('required' => false))
            //->add('field_sid', 'choice', array('choices' => $this->properties['listing'], 'preferred_choices' => $this->properties['preferredChoices'], 'empty_value' => 'Choose an option', 'required' => false))
            ->add('ListingFields', 'entity',
                array(
                    'class' => 'NumaDOAAdminBundle:Listingfield',
                    'property' => 'caption',
                    'query_builder' => function ($lr)
                    {
                               // echo get_class($lr);
                        return $lr->createQueryBuilder('lf')
                            ->where("lf.category_sid IN (0,".$this->feed_cid.")")
                            ->orderBy('lf.caption', 'ASC');
                    },
                    'empty_value' => 'Choose an option',
                    'required' => false
                )
            );
        ;//->add('feed_sid','hidden');
        ;
        //$builder->addEventSubscriber(new AddFeedSourceSubscriber($this->feed_sid, $this->properties));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Importmapping'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_importmapping';
    }

}
