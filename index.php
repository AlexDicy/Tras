<?php
require_once "session.php";

require_once "get/posts.php";

Shared::initialize();

Shared::set("title", "Tras");

Shared::set("description", "");
$i = Shared::set("i", isLoggedIn());

Shared::set("pagename", "index");
Shared::set("name", "");
Shared::set("infoNick", "");

Shared::set("nickname", $i ? Shared::$USERDATA['info']['nick'] : "Not Logged In");
Shared::set("friends", $i ? "Friends: ".getFriendsCount(Shared::$USERDATA['info']['id']) : "Friends: 0");
Shared::set("avatar", $i ? Shared::$USERDATA['info']['avatar'] : "https://tras.pw/assets/images/guest.png");
Shared::set("friendslist", $i ? getFriendsList() : array());

Shared::set("get", ["posts" => new GetPosts($i ? Shared::$USERDATA['info']['id'] : 0, Shared::get("friendslist"))]);


if (substr(Shared::get("link"), 0, 1) == "?") Shared::set("link", "");
if (substr(array_slice(Shared::get("path"), -1)[0], 0, 1) == "?") Shared::set("path", array_slice(Shared::get("path"), -1)[0] = "");

require 'routes.php';

?>