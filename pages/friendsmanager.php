<?php
if (isset($_POST['id']) && isLoggedIn()) {
    $friend = escape($_POST['id']);
    $user =  Shared::$USERDATA['info']['id'];
    if (isset($_POST['add'])) {
        $sql = query("INSERT IGNORE INTO Friends(Friends.Result,Friends.From,Friends.To) VALUES ((1000000000*'$user')+'$friend','$user','$friend')");
        newNotification($friend, $user, 0, 5, "");
    } else {
        $sql = query("DELETE FROM Friends WHERE Friends.Result = (1000000000*'$user')+'$friend' AND Friends.From = '$user' AND Friends.To = '$friend'");
        deleteNotification($friend, $user, 0, 5, "");
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