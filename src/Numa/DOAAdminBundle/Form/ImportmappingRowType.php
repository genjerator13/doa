<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Numa\DOAAdminBundle\Events\AddFeedSourceSubscriber;

class ImportmappingRowType extends AbstractType
{
    public function __construct ($feed_sid = null,$properties=null,$em)
    {
        $this->feed_sid = $feed_sid ;
        $this->properties = $properties ;
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ImportmappingRow', 'collection',
            array('type' => new ImportmappingType($this->feed_sid,$this->properties,$this->em),'attr'=>array('class'=>'form-inline'),'allow_add' => true,  'allow_delete' => true,))
                ->add('feed_sid','hidden',array('data'=>$this->feed_sid));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numa\DOAAdminBundle\Entity\Importmappings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'numa_doaadminbundle_importmappingrows';
    }
}
