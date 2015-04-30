<?php
namespace Numa\DOAAdminBundle\Lib;
use  Doctrine\Common\Collections\ArrayCollection;
use Numa\DOAAdminBundle\Lib\Option;
class OptionsDecorator {
   private $options;
   public function __construct() {
       $this->options = new ArrayCollection();
   }
   
   public function getOptions(){
       if($this->options instanceof ArrayCollection){
            return $this->options;
       }
       return null;
   }
   
   public function addOption($options){
       $this->options->add($options);
   }
   
   public function processOptionsFrom($source){
       $optionsArray = array();
       if (is_string($source)) {
            $test = json_decode($source, true);

            if (is_array($test)) {
                
                if (!empty($test['attribute'])) {
                    $optionsArray = $test['attribute'];
                }
                
            }
        }
        
        foreach ($optionsArray as $key => $value) {
            $option = new Option();
            $option->setName($value['name']);
            $option->setValue($value['value']);
            $this->addOption($option);
        }
   }
}
