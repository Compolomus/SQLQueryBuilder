<?php

namespace Koenig\SQLQueryBuilder\System;

class Placeholders
{
    public static $counter = 1;
    
    public static $placeholders = [];
    
    public static function count() {
        return count(self::$placeholders);
    }
    
    public static function add($key, $value) {
        self::$placeholders[$key] = $value;
        self::$counter++;
    }
}
