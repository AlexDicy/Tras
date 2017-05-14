<?php

switch (Shared::get("link")) {
    //Home
    case "":
    case "home":
        getPage(null, null, true, "Home", "index");
        break;

    //Private Messages
    case "messages":
        getPage(null, null, true, "Messages", "messages");
        break;
    case "newchat":
        getPage(null, 2, true, "pages/newchat.php");
        break;
    case "pendingmessages":
        getPage(null, 2, true, "pages/pendingmessages.php");
        break;
    case "sendmessage":
        getPage(null, 2, true, "pages/sendmessage.php");
        break;
    case "editmessage":
        getPage(null, 2, true, "pages/editmessage.php");
        break;
    case "deletemessage":
        getPage(null, 2, true, "pages/sendmessage.php");
        break;

    //Search
    case "search":
        getPage(null, null, null, "Results", "search");
        break;

    //Posts
    case "post":
        if (isset(Shared::get("path")[2])) {
            $query = Shared::get("get")['posts']->getPost(escape(Shared::get("path")[2]));
            if (mysqli_num_rows($query) > 0) {
                $post = mysqli_fetch_array($query);
                Shared::set("description", substr(Shared::removeFormatting($post['content']), 0, 120) . "... Post by ".Shared::get("path")[1]." on Tras, Login or register and meet your friends, share your thoughts or read funny posts");
                getPage($post, null, null, "Post", "post");
                break;
            }
        }
        getPage("404");
        break;
    case "getposts":
        getPage(null, 2, true, "pages/getposts.php");
        break;
    case "getpostopinions":
        getPage(null, 2, true, "pages/getpostopinions.php");
        break;
    case "new":
        getPage(null, 2, true, "pages/new.php");
        break;
    case "deletepost":
        getPage(null, 2, true, "pages/deletepost.php");
        break;
    case "edit":
        getPage(null, null, true, "Edit post", "edit");
        break;
    case "editpost":
        getPage(null, 2, true, "pages/editpost.php");
        break;
    //Replies
    case "sendreply":
        getPage(null, 2, true, "pages/sendreply.php");
        break;
    //Users
    case "user":
        if (isset(Shared::get("path")[1])) {
            $nick = escape(Shared::get("path")[1]);
            $query = query("SELECT nick, id, avatar, verified FROM Members WHERE nick = '$nick'");
            if (mysqli_num_rows($query) > 0) {
                getPage(mysqli_fetch_array($query), null, null, "User", "user");
                break;
            }
        }
        getPage("404");
        break;

    //User Pages
    case "friends":
        getPage(null, null, true, "Friends", "friends");
        break;
    case "settings":
        getPage(null, null, true, "Settings", "settings");
        break;
    case "friendsmanager":
        getPage(null, 2, true, "pages/friendsmanager.php");
        break;
    case "opinionmanager":
        getPage(null, 2, true, "pages/opinionmanager.php");
        break;
    case "notificationsmanager":
        getPage(null, 2, true, "pages/notificationsmanager.php");
        break;
    case "readnotification":
        getPage(null, 2, true, "pages/readnotification.php");
        break;
    case "addpushtoken":
        getPage(null, 2, true, "pages/addpushtoken.php");
        break;
    case "notifications":
        getPage(null, null, true, "Notifications", "notifications");
        break;
    
    //Others
    case "sitemap":
        getPage(null, 2, false, "pages/sitemap.php");
        break;
    case "page":
        if (isset(Shared::get("path")[1])) getPage("", 1);
        else {
            getPage("404");
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
    case "setsettings":
        getPage(null, 2, false, "pages/setsettings.php");
        break;

    //Admin
    case "admin":
        getPage(null, null, true, "Administration", "admin");
        break;

    //Any other, is a 404 error
    default:
        getPage("404");
}

//       getPage([object/"404"], [int], [boolean], [string], [string]);
function getPage($content="", $type=0, $userpage=false, $name="", $pagename="") {

    if (!empty($content)) Shared::set("content", $content);
    if (!empty($name)) Shared::set("name", $name);
    if (!empty($pagename)) Shared::set("pagename", $pagename);

    if ($userpage && !Shared::get("i")) {
        Shared::set("isPage", true);
        Shared::iset("path", "fulllogin", 1);
        Shared::iset("path", Shared::get("link"), 2);
        include 'page.php';
        exit();
    }

    if (!is_null($content) && $content == "404") {
        header("HTTP/1.0 404 Not Found");
        $type = 0;
        Shared::set("pagename", "404");
    }

    switch ($type) {
        case 0:
            include "template/base.php";
            break;
        case 1:
            include "page.php";
            break;
        case 2:
            include $name;
            break;
    }
}

function getTitle($name, $link, $path, $infoNick){
    if (empty($infoNick)) {
        switch ($link) {
            case "user":
                return $path[1]." on Tras";
            case "post":
                return $path[1]." post on Tras";
        }
        if (empty($name)) return "Tras";
        return $name . " - Tras";
    }
    return $infoNick." on Tras";
}
?>
