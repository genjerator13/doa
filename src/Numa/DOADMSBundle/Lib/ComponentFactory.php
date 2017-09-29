<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 7.10.16.
 * Time: 13.29
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOAModuleBundle\Entity\Component;
use Symfony\Component\HttpFoundation\Request;

class ComponentFactory
{
    protected $componentHolder;
    protected $dealer;
    protected $request;

    public function __construct(Catalogrecords $dealer,Request $request)
    {
        $this->dealer=$dealer;
        $this->request=$request;
        $pathinfo = $request->getPathInfo();

//        if (substr($pathinfo, 0, 2) === "/e") {
//            $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
//        }

        $host = trim(strip_tags($request->getHost()));
        //$dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getDealerByHost($host);
    }

    public function setDealer(Catalogrecords $dealer){
        $this->dealer=$dealer;
    }

    public function setComponentHolder(ComponentInterface $componentHolder)
    {
        $this->componentHolder = new $componentHolder();
    }

    public function getComponents(){
        if($this->componentHolder instanceof Catalogrecords){
            $this->componentHolder = $this->componentHolder->getComponents();
        }elseif($this->componentHolder instanceof Page ){

        }
    }

    public function setComponentdByType($type,$path,$dealerId)
    {
        if($type=="dealer"){
            $this->components = new DealerComponent();
        }else{
            $this->components = new Component();
        }
    }

}