<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 26.10.16.
 * Time: 16.56
 */

namespace Numa\DOADMSBundle\Form;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContainerAwareType extends AbstractType implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'container' => $this->container
        ));
    }

    public function getName() {
        return 'container_aware';
    }

    public function getParent() {
        return 'form';
    }
}