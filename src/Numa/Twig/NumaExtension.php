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
            'dumpFields' => new \Twig_Function_Method($this, 'dumpFields')
        );
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

}

?>
