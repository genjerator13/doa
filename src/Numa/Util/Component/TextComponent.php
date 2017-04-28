<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 28.4.17.
 * Time: 13.53
 */

namespace Numa\Util\Component;


class TextComponent implements ComponentView
{
    private $componentEntity;

    public function __construct(ComponentEntityInterface $componentEntity)
    {
        $this->componentEntity = $componentEntity;
    }

    public function display()
    {
        return $this->componentEntity->getValue();
    }


    public function setComponentEntity(ComponentEntityInterface $componentEntity){
        $this->componentEntity = $componentEntity;
    }

}