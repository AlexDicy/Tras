<?php

switch (Shared::get("link")) {
    case "":
    case "home":
        if (!Shared::get("i")) {
            Shared::set("isPage", true);
            Shared::set("path", "fulllogin", 1);
            Shared::set("path", Shared::get("link"), 2);
        } else {
            getPage(null, null, "Home", "index");
        }
        break;
    case "search":
        Shared::set("pagename", "search");
        Shared::set("name", "Results");
        Shared::set("file", 'template/base.php');
        break;
    case "post":
        Shared::set("file", 'template/base.php');
        if(isset(Shared::get("path")[1]) && isset(Shared::get("path")[2])) {
            Shared::set("name", "Post");
            Shared::set("pagename", "post");
        }
        else {
            header("HTTP/1.0 404 Not Found");
            Shared::set("name", "Not found");
            Shared::set("pagename", "404");
        }
        break;
    case "user":
        Shared::set("file", 'template/base.php');
        if(isset(Shared::get("path")[1])) {
            Shared::set("pagename", "user");
            Shared::set("name", "User");
        } else {
            header("HTTP/1.0 404 Not Found");
            Shared::set("name", "Not found");
            Shared::set("pagename", "404");
        }
        break;
    case "friends":
        Shared::set("pagename", "friends");
        Shared::set("name", "Friends");
        Shared::set("file", 'template/base.php');
        break;
    case "settings":
        Shared::set("pagename", "settings");
        Shared::set("name", "Settings");
        Shared::set("file", 'template/base.php');
        break;
    case "friendsmanager":
        Shared::set("file", 'pages/friendsmanager.php');
        break;
    case "opinionmanager":
        Shared::set("file", 'pages/opinionmanager.php');
        break;
    case "notificationsmanager":
        Shared::set("file", 'pages/notificationsmanager.php');
        break;
    case "getposts":
        Shared::set("file", 'pages/getposts.php');
        break;
    case "getpostopinions":
        Shared::set("file", 'pages/getpostopinions.php');
        break;
    case "notifications":
        Shared::set("pagename", "notifications");
        Shared::set("name", "Notifications");
        Shared::set("file", 'template/base.php');
        break;
    case "new":
        Shared::set("file", 'pages/new.php');
        break;
    case "delete":
        Shared::set("file", 'pages/delete.php');
        break;
    case "sitemap":
        Shared::set("file", 'pages/sitemap.php');
        break;
    case "edit":
        Shared::set("pagename", "edit");
        Shared::set("name", "Edit post");
        Shared::set("file", 'template/base.php');
        break;
    case "editpost":
        Shared::set("file", 'pages/editpost.php');
        break;
    case "page":
        if(isset(Shared::get("path")[1])) getPage("", 1);
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
    default:
        getPage("404");
}

if (Shared::get("isPage")) {
    include 'page.php';
} else if (Shared::has("file")) {
    include Shared::get("file");
}

function getPage($content="", $type=0, $name="", $pagename="") {

    if (!empty($content)) Shared::set("content", $content);
    if (!empty($name)) Shared::set("name", $name);
    if (!empty($pagename)) Shared::set("pagename", $pagename);

    if ($content == "404") {
        header("HTTP/1.0 404 Not Found");
        include 'pagefiles/404.php';
        exit();
    }

    if ($type == 1) {
        include 'page.php';
    } else {
        include 'template/base.php';
    }

    //return $page;
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

function getDescription($name, $link, $path, $infoNick, $description){
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

?>
