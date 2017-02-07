<?php
if (isset($_POST['token']) && isLoggedIn()) {
    $token = escape($_POST['token']);
    $userid = $_SESSION['info']['id'];
    query("INSERT IGNORE INTO PushTokens (user, token) VALUES ('$userid', '$token')");
}
?>