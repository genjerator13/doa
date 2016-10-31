<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of option
 *
 * @author genjerator
 */

namespace Numa\DOAAdminBundle\Lib;
class Option
{
    private $value;
    private $name;
    private $order;

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOrder()
    {
        return $this->order;
    }

}
