<?php
if (isset($_POST['id']) && isLoggedIn()) {
    $id = escape($_POST['id']);
    $user = $USERDATA['info']['id'];
    $sql = query("UPDATE Notifications SET viewed = 1 WHERE user = $user AND id = $id");
}
?>