<?php
if (isset($_POST['id']) && isLoggedIn()) {
    $post = escape($_POST['id']);
    $type = escape($_POST['type']);
    $user = $_SESSION['info']['id'];
    if (isset($_POST['add'])) {
        $sql = query("INSERT IGNORE INTO Opinions(result,user,post,type) VALUES ((1000000000*'$user')+'$post','$user','$post','$type')");
        //newNotification($friend, $user, 0, 5, "");
    } else {
        $sql = query("DELETE FROM Opinions WHERE result = (1000000000*'$user')+'$post'");
    }
    if ($sql) {
?>
{"CODE": 200}
<?php
    } else {
?>
{"CODE": 302}
<?php
    }
} else {
?>
{"CODE": 300}
<?php
}
?>