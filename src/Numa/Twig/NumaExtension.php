<?php

// src/Rentabo/Twig/RentaboExtension.php

namespace Numa\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class NumaExtension extends \Twig_Extension {

    protected $container;

    public function __construct(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array(
            'showItemField' => new \Twig_Function_Method($this, 'showItemField'),
            'dumpFields' => new \Twig_Function_Method($this, 'dumpFields'),
            'price' => new \Twig_Function_Method($this, 'price'),
            'file_existsx' => new \Twig_Function_Method($this,'file_existsx')
        );
    }
    
    public function file_existsx($filename){
        //echo "\\var\\doa\\web\\".$filename;
        return file_exists(trim($filename,"/"));
    }
    
    public function showItemField($itemFields, $fieldname, $type = 'string') {
        $res = "";
        $fieldname = strtolower($fieldname);
        if (!empty($itemFields[$fieldname])) {
            if (count($itemFields[$fieldname]) == 1) {
                $itemfieldObject = $itemFields[$fieldname][0];
                $res = $itemfieldObject->getFieldStringValue();
                return $res;
            }
        }
        return $res;
        ;
    }

    public function dumpFields($itemFields) {
        $res ="sss";
        foreach ($itemFields as $key=>$item) {
            $res .= $key.".</br>";
        }
        return $res;        
    }

    public function getName() {
        return 'numa_extension';
    }
    
    public function price($price){
        $price = intval($price);
        if(empty($price)){
            $price = "No price";
        }else{
            $price = money_format('%(#10n', $price);
        }
        $return = '<span class="price">'.$price.'</span>';
        return $return;
    }

}

?>
