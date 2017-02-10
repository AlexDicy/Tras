<?php
if (isset($_POST['content']) && isset($_POST['chat_id'])) {
    $text = base64_encode(escape(htmlentities($_POST['content'])));
    $chatId = escape(htmlentities($_POST['chat_id']));
    $user = $_SESSION['info']['id'];
    $sql = query("INSERT INTO Messages (user, chat_id, content) VALUES ('$user', '$chatId', '$text')");
    $users = query("SELECT user FROM Chats WHERE chat_id = '$chatId' AND user <> '$user'");
    if ($sql) {
        echo "{\"CODE\": 700}";
        if ($users) {
            while ($info = mysqli_fetch_array($users)) {
                query("UPDATE Chats SET `read` = 0 WHERE chat_id = '$chatId' AND user = '". $info['user'] ."'");
                newNotification($info['user'], $user, $chatId, 6, substr(base64_decode($text), 0, 50));
            }
        }
    } else {
        echo "{\"CODE\": 666}";
    }
}
?>