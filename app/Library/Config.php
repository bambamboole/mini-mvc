<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 05.12.17
 * Time: 19:29
 */

namespace App\Library;

class Config {

    private static $registry = Array();

    public static function set($key, $value) {
        self::$registry[$key] = $value;
    }

    public static function get($key) {
        if (array_key_exists($key, self::$registry)) {
            return self::$registry[$key];
        }
        return false;
    }
}
