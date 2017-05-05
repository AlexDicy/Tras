<?php
if (isset($_POST['user_id'])) {
    $with = escape($_POST['user_id']);
    $user =  Shared::$USERDATA['info']['id'];
    $chatid = str_shuffle(md5(microtime()));
    $one = query("INSERT IGNORE INTO Chats (user, chat_id) VALUES ('$user', '$chatid')");
    $two = query("INSERT IGNORE INTO Chats (user, chat_id) VALUES ('$with', '$chatid')");
    if ($one && $two) {
        echo "{\"CODE\": 700}";
    } else {
        echo "{\"CODE\": 666}";
    }
}
?>