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
            $listAll = $this->listDefaultQBAccounts();
            //$form->add('value',null,array("label"=>"QB Name"));

            if(strtolower($data->getname())=="inventory") {
                $listTaxes = $this->listAllTaxes();
                $form->remove('value');
                $form->add('value5',ChoiceType::class,array("choices"=>$listTaxes,"label"=>"Sale Tax"));
                $form->add('value6',ChoiceType::class,array("choices"=>$listTaxes,"label"=>"Purchase Tax"));
            }else{
                //service
                $listServices = $this->container->get("numa.dms.quickbooks.item")->getAllserviceItems();
                $form->add('value',ChoiceType::class,array("choices"=>$listServices,"label"=>"Service Name from QB"));
            }

            $listExpense = $this->listDefaultQBAccounts("Expense");
            $listAsset = $this->listDefaultQBAccounts("Asset");
            $listRevenue = $this->listDefaultQBAccounts("Revenue");
            //dump($list);
            $form->remove('section');

            $form->add('value2',ChoiceType::class,array("choices"=>$listExpense,"label"=>"Expense Account"));
            $form->add('value3',ChoiceType::class,array("choices"=>$listRevenue,"label"=>"Income Account"));
            $form->add('value4',ChoiceType::class,array("choices"=>$listAsset,"label"=>"Asset Account"));
            $form->remove('section');
        }
    }

    public function listDefaultQBAccounts($category=null){
        $dealer = $this->container->get("numa.dms.user")->getSignedUser();
        $list =  $this->container->get("numa.dms.quickbooks.account")->listAllAccounts($dealer, $category);
        return $list;
    }

    public function listAllTaxes(){
        $dealer = $this->container->get("numa.dms.user")->getSignedUser();
        $list =  $this->container->get("numa.dms.quickbooks.tax")->listAllTaxes($dealer);
        return $list;
    }

}