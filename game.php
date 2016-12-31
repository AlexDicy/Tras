<?php
function showPage($name, $url){
    $title;
    $description;
    $head;
    $body;
    $i = isLoggedIn();
    $nickname =  $i ? $_SESSION['info']['Nick'] : "Not Logged In";
    $friends =  $i ? "Friends: ".getFriendsCount() : "Friends: 0";
    $avatar =  $i ? $_SESSION['info']['Avatar'] : "https://tras.pw/assets/images/guest.png";
    if ($name == "changelog") {
        $title = title("Changelog");
        $description = "Tras game changelog";
        $head = "";
        $body = file_get_contents("pages/changelog.html");
    } else if ($name == "privacy") {
        $title = title("Privacy");
        $description = "Tras website privacy";
        $head = "";
        $body = file_get_contents("pages/privacy.html");
    } else if ($name == "tos") {
        $title = title("Terms of Service");
        $description = "Tras website Terms of Service";
        $head = "";
        $body = file_get_contents("pages/tos.html");
    } else if ($name == "game.php") {
        include("pages/index.php");
    } else {
        header("HTTP/1.0 404 Not Found");
        $link = $_SERVER['REQUEST_URI'];
        $title = title("Not Found");
        $description = "This page wasn't found!";
        $head = "<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:700\" rel=\"stylesheet\" type=\"text/css\">
            <style>
            body {
                font-family: 'Ubuntu'!important;
                margin: 20px;
                text-align: center;
            }
            </style>";
        $body = "<h1>Not Found - $link</h1><p>I didn't find any page with this name :(</p><br><p>404 Error</p>";
    }
include("pages/html.php");
}
showPage($link, $url);
?>
