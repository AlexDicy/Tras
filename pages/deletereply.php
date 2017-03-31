<?php
if (isset($_POST['id']) && isLoggedIn()) {
    $id = escape($_POST['id']);
    $user = $_SESSION['info']['id'];
    $sql = query("DELETE FROM Replies WHERE id = $id AND user = $user");
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