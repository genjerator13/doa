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
                if (!empty($test['option'])) {
                    $optionsArray = $test['option'];
                }
                if (!empty($test['specification'])) {
                    $optionsArray = $test['specification'];
                }
            }
        }
        
        foreach ($optionsArray as $key => $optionXXX) {
            
            $option = new Option();
            $value = "";
            $name =  "";  
            if(!empty($optionXXX['name'])){
                $name = $optionXXX['name'];
            }
            if(!empty($optionXXX['label'])){
                $name = $optionXXX['label'];
            }
            if(!empty($optionXXX['value'])){
                $value = $optionXXX['value'];
            }
            if(!empty($optionXXX['specification-name'])){
                $name = $optionXXX['specification-name'];
            }
            if(!empty($optionXXX['specification-value'])){
                $value = $optionXXX['specification-value'];
            }
            if(empty($value)){
                $value=false;
            }

            if(empty($name)){
                $name = $value;
                $value = true;
            }

            if(!empty($name)){                
                $option->setValue($value);
                $option->setName($name);
                $this->addOption($option);
            }

        }
        
   }
}
