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

    public static function getTitle($name, $link, $path, $infoNick) {
        if (empty($infoNick)) {
            switch ($link) {
                case "user":
                    return $path[1]." on Tras";
                case "post":
                    return $path[1]." post on Tras";
            }
            if (empty($name)) return "Tras";

            if ($name == "Messages") {
                $count = Shared::get("notificationsCount");
                $prefix = empty($count) ? "": "(".$count.") ";
                return $prefix . $name . " - Tras";
            }
            return $name . " - Tras";
        }
        return $infoNick." on Tras";
    }

    public static function has($key) {
        return array_key_exists($key, self::$array);
    }

    public static function set($key, $value) {
        self::$array[$key] = $value;
        return $value;
    }
    
    public static function iset($key, $value, $index) {
        self::$array[$key][$index] = $value;
        return $value;
    }

    public static function unsetValue($key, $index) {
        unset(self::$array[$key][$index]);
    }

    public static function elapsedTime($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->days > 100) return date("d M H:i Y", strtotime($datetime));
        if ($diff->days > 6) return date("d M H:i", strtotime($datetime));

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
?>
