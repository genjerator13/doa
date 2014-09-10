<?php

namespace Numa\Util;

class Util {

    const yearMin = 1950;
    const yearMax = 2016;

    static function createYearRangeArray() {
        $ret = array();
        for ($i = self::yearMin; $i <= self::yearMax; $i++) {
            $ret[$i]=$i;
        }
        return $ret;
    }

}
