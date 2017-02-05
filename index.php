<?php
require_once "session.php";

require_once "get/posts.php";

require_once "shared.php";

Shared::initialize();

reloadInfo();

Shared::set("title", "Tras");

Shared::set("description", "");
$i = Shared::set("i", isLoggedIn());

Shared::set("pagename", "index");
Shared::set("name", "");
Shared::set("infoNick", "");

Shared::set("nickname", $i ? $_SESSION['info']['Nick'] : "Not Logged In");
Shared::set("friends", $i ? "Friends: ".getFriendsCount($_SESSION['info']['id']) : "Friends: 0");
Shared::set("avatar", $i ? $_SESSION['info']['Avatar'] : "https://tras.pw/assets/images/guest.png");
Shared::set("friendslist", $i ? getFriendsList() : array());

Shared::set("get", ["posts" => new GetPosts($i ? $_SESSION['info']['id'] : 0, Shared::get("friendslist"))]);

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


if (substr(Shared::get("link"), 0, 1) == "?") Shared::set("link", "");
if (substr(array_slice(Shared::get("path"), -1)[0], 0, 1) == "?") Shared::set("path", array_slice(Shared::get("path"), -1)[0] = "");

require 'routes.php';

?>