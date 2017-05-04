<?php
if (isset($_POST['id']) && $_POST['text']) {
    $id = escape($_POST['id']);
    $content = escape(htmlentities($_POST['text']));
    $userid = $USERDATA['info']['id'];
    $edit = query("UPDATE Posts SET content = '$content' WHERE id = '$id' AND user = '$userid'");
    if ($edit) echo "{\"CODE\": 200}";
    else echo "{\"CODE\": 302}";
} else {
    echo "{\"CODE\": 300}";
}
?>