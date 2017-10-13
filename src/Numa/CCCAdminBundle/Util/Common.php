<?php

namespace Numa\CCCAdminBundle\Util;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Common
 *
 * @author genjerator
 */
class Common {

    public static function set($fieldname, $value) {
        $fieldname = strtolower($fieldname);
        $this->$fieldname = $value;
        echo '$this->' . $fieldname . "=" . $value . "\n";

        //check if date
        if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $value)) {
            $this->$fieldname = new \DateTime($value);
        }
    }

}
