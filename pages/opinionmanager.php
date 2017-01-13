<?php
if (isset($_POST['id']) && isLoggedIn()) {
    $post = escape($_POST['id']);
    $type = empty($_POST['type']) ? 1 : escape($_POST['type']);
    $user = $_SESSION['info']['id'];
    $opinion = ($type == 0) ? 2 : 1;
    $postinfo = mysqli_fetch_array(query("SELECT SUBSTRING(Posts.content, 1, 30), user FROM Posts WHERE Posts.id = '$post' LIMIT 1"));
    $postcontent = $postinfo[0];
    $postuser = $postinfo[1];
    if (isset($_POST['add'])) {
        $sql = query("INSERT IGNORE INTO Opinions(result,user,post,type) VALUES ((1000000000*'$user')+'$post','$user','$post','$type')");
        //Do not notify for dislikes atm
        if ($opinion == 1) newNotification($postuser, $user, $post, $opinion, $postcontent."...");
    } else {
        $sql = query("DELETE FROM Opinions WHERE result = (1000000000*'$user')+'$post'");
        if ($opinion == 1) deleteNotification($postuser, $user, $post, $opinion, $postcontent."...");
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