<?php

class Shared {
    private static $array = array();
    private static $friendsCountCache = array();
    public static $USERDATA = array();

    public static function initialize() {
        if (!array_key_exists("initialized", self::$array)) {
            $link = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            self::$array["initialized"] = true;
            self::$array["url"] = trim($link, "/");
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

    public static function getDescription($name, $link, $path, $infoNick, $description){
        if (empty($description) && empty($infoNick)) {
            switch ($link) {
                case "user":
                    return "Meet, See friends or Read posts by ".$path[1]." on Tras";
                case "post":
                    return "Post by ".$path[1]." on Tras, Login or register and meet your friends, share your thoughts or read funny posts";
            }
            if (empty($name)) return "Login or register to Tras and meet your friends, share your thoughts or read funny posts";
            return $name . " Page on Tras, Login or register to Tras and meet your friends, share your thoughts or read funny posts";
        }
        return "Meet, See friends or Read posts by $infoNick on Tras";
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

        if ($diff->days > 100) return date("d M Y H:i", strtotime($datetime));
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

    public static function parsePost($text) {
        if (strpos($text, '!~') !== false) {
            // Bold
            $text = str_replace("**", "<b>", $text);
            $text = str_replace("/*", "</b>", $text);

            // Italics
            $text = str_replace("__", "<i>", $text);
            $text = str_replace("/_", "</i>", $text);

            // Superscript
            $text = str_replace("^^", "<sup>", $text);
            $text = str_replace("/^", "</sup>", $text);

            // Subscript
            $text = str_replace("~~", "<sub>", $text);
            $text = str_replace("/~", "</sub>", $text);

            // Quote
            $text = str_replace("&gt;&gt;", "<blockquote>", $text);
            $text = str_replace("/&gt;", "</blockquote>", $text);

            $text = str_replace("!~", "", $text);
            $text .= "</i></b></sup></sub>";
        }
        return $text;
    }

    public static function removeFormatting($text) {
        if (strpos($text, '!~') !== false) {
            // Bold
            $text = str_replace("**", "", $text);
            $text = str_replace("/*", "", $text);

            // Italics
            $text = str_replace("__", "", $text);
            $text = str_replace("/_", "", $text);

            // Superscript
            $text = str_replace("^^", "", $text);
            $text = str_replace("/^", "", $text);

            // Subscript
            $text = str_replace("~~", "", $text);
            $text = str_replace("/~", "", $text);

            // Quote
            $text = str_replace("&gt;&gt;", "", $text);
            $text = str_replace("/&gt;", "", $text);

            $text = str_replace("!~", "", $text);
        }
        return $text;
    }

    public static function getVerifiedBadge($level, $useLink = true) {
        if ($level == 1) {
            $start = $useLink ? "<a class=\"verified-link\" data-v-level=\"1\"> " : "<span>";
            $end = $useLink ? "</a>" : " </span>";
            return $start."<i class=\"fa fa-check-circle\" style=\"color: #42A5F5;\"></i>".$end;
        } else if ($level == 2) {
            $start = $useLink ? "<a class=\"verified-link\" data-v-level=\"2\"> " : "<span>";
            $end = $useLink ? "</a>" : " </span>";
            return $start."<i class=\"fa fa-check-circle\" style=\"color: #4CAF50;\"></i>".$end;
        }
        return "";
    }

    public static function getFriendsCount($nick) {
        if (!isset($nick)) {
            $nick = Shared::$USERDATA['info']['id'];
        }
        if (isset(self::$friendsCountCache[$nick])) return self::$friendsCountCache[$nick];

        $sql = query("SELECT COUNT(Friends.To) FROM Friends WHERE Friends.To = (SELECT id FROM Members WHERE nick = '$nick')");
        $count = mysqli_fetch_array($sql)[0];
        self::$friendsCountCache[$nick] = $count;

        return $count;
    }
}
?>
