<?php
if (isset($_POST['chat_id'])) {
    $chatid = escape($_POST['chat_id']);
    $userid =  Shared::$USERDATA['info']['id'];
    $count = query("SELECT SUM(`read` = 0) AS total FROM Chats WHERE chat_id = '$chatid' AND user = '$userid'");
    if ($count) {
        $info = mysqli_fetch_array($count);
        echo "{\"CODE\":".(($info['total'] > 0) ? "700}" : "666}");
    }
}