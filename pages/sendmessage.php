<?php
if (isset($_POST['content']) && isset($_POST['chat_id'])) {
    $text = base64_encode(escape(htmlentities($_POST['content'])));
    $chatId = escape(htmlentities($_POST['chat_id']));
    $user = $_SESSION['info']['id'];
    $sql = query("INSERT INTO Messages (user, chat_id, content) VALUES ('$user', '$chatId', '$text')");
    if ($sql) {
        echo "{\"CODE\": 700}";
    } else {
        echo "{\"CODE\": 666}";
    }
}
?>