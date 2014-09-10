<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchItem
 *
 * @author genjerator
 */
namespace Numa\Util;
class SearchItem {
    //put your code here
    protected $type;
    protected $dbFieldName;
    protected $value;
    
    
    public function __construct($dbFieldValue,$value='',$type='string') {
        $this->dbFieldName = $dbFieldValue;
        $this->value = $value;
        $this->type = $type;
    }
    public function getType(){
        return $this->type;
    }
    
    public function getDbFieldName(){
        return $this->dbFieldName;
    }
    
    public function getValue(){
        return $this->value;
    }
    
    public function setValue($value){
        $this->value = preg_replace("/[^A-Za-z0-9 \_\-\.]/", '', $value);
    }
    
    public function dump(){
        echo "<p>"
                . "type= ".$this->getType().":"
                . "dnFieldName=".$this->getDbFieldName().":"
                . "value=".$this->getValue().":"
                . "</p>";
    }
    
    public function isValueEmpty(){
        $value = $this->getValue();
        return empty($value);
    }
}
