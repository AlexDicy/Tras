<?php
require_once 'session.php';
reloadInfo();
$url = trim($_SERVER['REQUEST_URI'], "/");
$host = parse_url($url, PHP_URL_SCHEME).'://'.parse_url($url, PHP_URL_HOST);
$link = explode("/", str_replace($host, "", $url));
$path = $link; $link = $link[0];

$isPage = false;
$file;
$title = "Tras";
$description = "";
$i = isLoggedIn();
$pagename = "index";
$name = "";
$infoNick = "";

function getTitle(){
    global $name;
    global $link;
    global $path;
    global $infoNick;
    if (empty($infoNick)) {
        switch ($link) {
            case "user":
            //$sql = query("SELECT Nick FROM Members WHERE id = '$path[1]'");
            //$info = mysqli_fetch_array($sql);
            //return $info['Nick']." on Tras";
                return $path[1]." on Tras";
            case "post":
                return $path[1]." post on Tras";
        }
        if (empty($name)) return "Tras";
        return $name . " - Tras";
    }
    return $infoNick." on Tras";
}

function getDescription(){
    global $name;
    global $link;
    global $path;
    global $infoNick;
    global $description;
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

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

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

$nickname =  $i ? $_SESSION['info']['Nick'] : "Not Logged In";
$friends =  $i ? "Friends: ".getFriendsCount($_SESSION['info']['id']) : "Friends: 0";
$avatar =  $i ? $_SESSION['info']['Avatar'] : "https://tras.pw/assets/images/guest.png";
$friendslist = $i ? getFriendsList() : array();


if (substr($link, 0, 1) == "?") $link = "";
if (substr(array_slice($path, -1)[0], 0, 1) == "?") array_slice($path, -1)[0] = "";
switch ($link) {
    case "":
    case "home":
        if (!$i) {
            $isPage = true;
            $path['1'] = "fulllogin";
            $path['2'] = $link;
        }
        $pagename = "index";
        $name = "Home";
        $file = 'template/base.php';
        break;
    case "search":
        $pagename = "search";
        $name = "Results";
        $file = 'template/base.php';
        break;
    case "post":
        $pagename = "post";
        $name = "Post";
        $file = 'template/base.php';
        break;
    case "user":
        $pagename = "user";
        $name = "User";
        $file = 'template/base.php';
        break;
    case "friends":
        $pagename = "friends";
        $name = "Friends";
        $file = 'template/base.php';
        break;
    case "settings":
        $pagename = "settings";
        $name = "Settings";
        $file = 'template/base.php';
        break;
    case "friendsmanager":
        $file = 'pages/friendsmanager.php';
        break;
    case "opinionmanager":
        $file = 'pages/opinionmanager.php';
        break;
    case "notificationsmanager":
        $file = 'pages/notificationsmanager.php';
        break;
    case "getposts":
        $file = 'pages/getposts.php';
        break;
    case "getpostopinions":
        $file = 'pages/getpostopinions.php';
        break;
    case "notifications":
        $pagename = "notifications";
        $name = "Notifications";
        $file = 'template/base.php';
        break;
    case "new":
        $file = 'pages/new.php';
        break;
    case "delete":
        $file = 'pages/delete.php';
        break;
    case "sitemap":
        $file = 'pages/sitemap.php';
        break;
    case "edit":
        $pagename = "edit";
        $name = "Edit post";
        $file = 'template/base.php';
        break;
    case "editpost":
        $file = 'pages/editpost.php';
        break;
    case "page":
        if(isset($path[1])) $isPage = true;
        else {
            header("HTTP/1.0 404 Not Found");
            $file = 'pagefiles/404.php';
        }
        break;
    case "tos":
        echo file_get_contents("pagefiles/tos.html");
        break;
    case "privacy":
        echo file_get_contents("pagefiles/privacy.html");
        break;
    case "changelog":
        echo file_get_contents("pagefiles/changelog.html");
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        $file = 'pagefiles/404.php';
}

if ($isPage) {
    include 'page.php';
} else {
    include $file;    
}
?>