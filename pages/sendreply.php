<?php
if (isset($_POST['content']) && isset($_POST['post_id']) && isset($_POST['user'])) {
    $text = escape(htmlentities($_POST['content']));
    $postId = escape($_POST['post_id']);
    $user =  Shared::$USERDATA['info']['id'];
    $userId = escape($_POST['user']);

    if (empty($_POST['content'])) exit("{\"CODE\": 666}");

    $exists = query("SELECT id FROM Posts WHERE id = '$postId' AND user = '$userId'");
    if (!$exists || mysqli_num_rows($exists) < 0) exit("{\"CODE\": 666}");
    
    $sql = query("INSERT INTO Posts (user, post, content) VALUES ('$user', '$postId', '$text')");
    
    if ($sql && $user != $userId) {
        echo "{\"CODE\": 700}";
        newNotification($userId, $user, $postId, 7, substr($_POST['content'], 0, 50));
    } else {
        echo "{\"CODE\": 666}";
    }
}
?>