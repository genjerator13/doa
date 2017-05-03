<?php
namespace Numa\Util\Component;
abstract class ComponentView {
    abstract public function display();


    public function componentWrapper(ComponentEntityInterface $component,$html){
        $id = "c-".$component->getId();
        $class = "componentx";
        $htmlOut = "";
        if($component instanceof Component){
            $id = "dc-".$component->getId();
            $class = "dealer-componentx";
        }
        $htmlOut = '<div id="'.$id.'" class="'.$class.'">'.$html."</div>";

        return $htmlOut;
    }
}
