<?php
if (isset($_GET['link']) && isLoggedIn()) {
    $where = escape($_GET['where']);
    header("Location: https://tras.pw" . $_GET['link']);
    $user = $USERDATA['info']['id'];
    $sql = query("UPDATE `Notifications` SET `viewed` = 1 WHERE `user` = '$user' AND `where` = '$where'");
}
?>