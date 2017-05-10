<?php
if (isset($_POST['id']) && isLoggedIn()) {
    $id = escape($_POST['id']);
    $user =  Shared::$USERDATA['info']['id'];
    $sql = query("DELETE FROM Posts WHERE id = $id AND user = $user");
    query("DELETE FROM Notifications WHERE `where` = $id AND `from` = $user");
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