<?php

namespace Numa\DOAAdminBundle\Form;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AntiSpamButtonType extends AbstractType implements ContainerAwareInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $antispamParams = $this->container->getParameter('antispam_button');

        $resolver->setDefaults(array(
            'choices' => array(
                $antispamParams['bad'] => 'do.not.add.comment',
                $antispamParams['good'] => 'add.comment'
            ),
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['btn_classes'] = array('btn', 'btn btn-primary');
        $view->vars['label_prefix'] = array(null, '<i class="icon-comment icon-white"></i> ');
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'antispambutton';
    }
}