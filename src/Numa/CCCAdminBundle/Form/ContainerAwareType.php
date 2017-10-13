<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 26.10.16.
 * Time: 16.56
 */

namespace Numa\CCCAdminBundle\Form;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContainerAwareType extends AbstractType implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'container' => $this->container
        ));
    }
//    public function getName() {
//        return ContainerAwareType::class;
//    }

    public function getParent() {
        return FormType::class;
    }
}