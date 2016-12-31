<?php
require_once '../../session.php';
$i = isLoggedIn();
$nickname =  $i ? $_SESSION['info']['Nick'] : "Not Logged In";
$friends =  $i ? "Friends: ".$_SESSION['info']['Friends'] : "Friends: 0";
$avatar =  $i ? $_SESSION['info']['Avatar'] : "https://tras.pw/assets/images/guest.png";
if (isset($_GET['name'])) {
    include('files/' . $_GET['name']);
}
    /*
    $file = $_GET['name'];
    $nickname = $_GET['nickname'];
    if (isset($file)) {
        if (isset($nickname)) {

        }
        print $file;
    }
    */
?>