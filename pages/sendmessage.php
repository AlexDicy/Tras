<?php
if (isset($_POST['content']) && isset($_POST['chat_id'])) {
    $text = escape(base64_encode(htmlentities($_POST['content'])));
    $chatId = escape($_POST['chat_id']);
    $user = $_SESSION['info']['id'];
    $users = query("SELECT user FROM Chats WHERE chat_id = '$chatId'");
    $usersArray = mysqli_fetch_array($users);
    if (in_array($user, $usersArray)) {
        $sql = query("INSERT INTO Messages (user, chat_id, content) VALUES ('$user', '$chatId', '$text')");
        if ($sql && $_POST['content'] != "") {
            echo "{\"CODE\": 700}";
            if ($users) {
                while ($info = $usersArray) {
                    if ($info['user'] != $user) {
                        query("UPDATE Chats SET `read` = 0 WHERE chat_id = '$chatId' AND user = '". $info['user'] ."'");
                        newNotification($info['user'], $user, $chatId, 6, substr(base64_decode($text), 0, 50));
                    }
                }
            }
        } else {
            echo "{\"CODE\": 666}";
        }
    } else {
            echo "{\"CODE\": 666}";
    }
}
?>