<?php
if (isset($_POST['token'])) {
    $token = escape($_POST['token']);
    $userid =  Shared::$USERDATA['info']['id'];
    query("INSERT IGNORE INTO PushTokens (user, token) VALUES ('$userid', '$token')");
}
?>