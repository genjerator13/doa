<?php
namespace Numa\DOAAdminBundle\Form;

use Numa\DOAAdminBundle\Form\AntispamButtonType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Numa\DOAAdminBundle\Form\AntiSpamButtonType as asbt;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SendEmailType extends AbstractType implements ContainerAwareInterface
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $container = $this->container;
        $builder
            ->add('comments', 'textarea')
            ->add('first_name', 'text')
            ->add('last_name', 'text')
            ->add('email', 'email')
            ->add('dealer', 'hidden')
          ->add('captcha', 'genemu_captcha',array('mapped' => false,));

//            ->add('button',  new asbt($this->container))
//            ->addEventListener(FormEvents::POST_BIND, function(FormEvent $event) use($container) {
//                $form = $event->getForm();
//
//                $antispamParams = $container->getParameter('antispam_button');
//
//                if (!$form->has('button') || $form['button']->getData() !== $antispamParams['good']) {
//                    $form->addError(new FormError('spam.detected'));
//                    dump("ERRR");
//                }
//
//            })
//
//        ;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'sendEmail';
    }
}