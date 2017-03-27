<?php
if (isset($_POST['content']) && isset($_POST['chat_id'])) {
    $text = escape(base64_encode(htmlentities($_POST['content'])));
    $chatId = escape($_POST['chat_id']);
    $user = $_SESSION['info']['id'];
    $users = query("SELECT user FROM Chats WHERE chat_id = '$chatId'");
    $inArray = false;
    $usersArray = array();
    while ($info = mysqli_fetch_array($users)) {
        if ($info['user'] == $user) {
            $inArray = true;
        } else {
            $usersArray[] = $info['user'];
        }
    }
    if ($inArray) {
        $sql = query("INSERT INTO Messages (user, chat_id, content) VALUES ('$user', '$chatId', '$text')");
        if ($sql && $_POST['content'] != "") {
            echo "{\"CODE\": 700}";
            if ($users) {
                foreach ($usersArray as $info) {
                    query("UPDATE Chats SET `read` = 0 WHERE chat_id = '$chatId' AND user = '". $info ."'");
                    newNotification($info, $user, $chatId, 6, substr($_POST['content'], 0, 50));
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