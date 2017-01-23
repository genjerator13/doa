<?php

namespace Numa\Util;
use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException;
class Util {

    const yearMin = 1950;
    const yearMax = 2017;

    static function createYearRangeArray() {
        $ret = array();
        for ($i = self::yearMin; $i <= self::yearMax; $i++) {
            $ret[$i] = $i;
        }
        return $ret;
    }

}
