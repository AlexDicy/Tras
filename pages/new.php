<?php
if (isset($_POST['text']) && isLoggedIn()) {
    $text = escape(htmlentities($_POST['text']));
    $user = $_SESSION['info']['id'];
    $sql = query("INSERT INTO Posts (user, content) VALUES ('$user', '$text')");
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