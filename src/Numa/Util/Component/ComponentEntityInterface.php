<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 28.4.17.
 * Time: 13.54
 */

namespace Numa\Util\Component;


interface ComponentEntityInterface
{
    public function getName();
    public function getType();
    public function getValue();
    public function getId();
}