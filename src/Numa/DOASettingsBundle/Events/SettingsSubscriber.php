<?php

/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 11.4.17.
 * Time: 14.35
 */
namespace Numa\DOASettingsBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SettingsSubscriber implements EventSubscriberInterface
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }


    public function preSetData(FormEvent $event)
    {

        $data = $event->getData();
        $form = $event->getForm();

        if($data->getSection()=="QB"){
            $list = $this->listDefaultQBAccounts();
            //dump($list);
            $form->remove('section');
            $form->add('value',ChoiceType::class,array("choices"=>$list,"label"=>"QB Name"));
            $form->add('value2',ChoiceType::class,array("choices"=>$list,"label"=>"Expense Account"));
            $form->add('value3',ChoiceType::class,array("choices"=>$list,"label"=>"Income Account"));
            $form->add('value4',ChoiceType::class,array("choices"=>$list,"label"=>"Asset Account"));
            $form->add('section');
        }

    }

    public function listDefaultQBAccounts(){
        $dealer = $this->container->get("numa.dms.user")->getSignedUser();
        $list =  $this->container->get("numa.dms.quickbooks.account")->listAllAccounts($dealer);
        return $list;
    }

}