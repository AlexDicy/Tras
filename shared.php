<?php

class Shared {
    private static $array = array();

    public static function initialize() {
        if (!array_key_exists("initialized", self::$array)) {
            self::$array["initialized"] = true;
            self::$array["url"] = trim($_SERVER['REQUEST_URI'], "/");
            self::$array["parsed"] = parse_url(self::$array["url"], PHP_URL_SCHEME).'://'.parse_url(self::$array["url"], PHP_URL_HOST);
            self::$array["link"] = explode("/", str_replace(self::$array["parsed"], "", self::$array["url"]));
            self::$array["path"] = self::$array["link"];
            self::$array["link"] = self::$array["link"][0];
            self::$array["host"] = $_SERVER['HTTP_HOST'];
            self::$array["isPage"] = false;
        }
    }

    public static function get($key) {
        return self::$array[$key];
    }

    public static function has($key) {
        return array_key_exists($key, self::$array);
    }

    public static function set($key, $value) {
       self::$array[$key] = $value;
       return $value;
    }
}
?>