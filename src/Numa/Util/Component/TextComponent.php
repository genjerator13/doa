<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 28.4.17.
 * Time: 13.53
 */

namespace Numa\Util\Component;


class TextComponent extends ComponentView
{
    private $componentEntity;

    public function __construct(ComponentEntityInterface $componentEntity)
    {
        $this->componentEntity = $componentEntity;
    }

    public function display()
    {
        return $this->componentWrapper($this->componentEntity,$this->componentEntity->getValue());
    }


    public function setComponentEntity(ComponentEntityInterface $componentEntity){
        $this->componentEntity = $componentEntity;
    }

}