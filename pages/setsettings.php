<?php
// For now force BOOLEAN values
if (isset($_POST['name']) && isset($_POST['value'])) {
    $name = escape($_POST['name']);
    $value = escape($_POST['value']);
    if ($value == true || $value == false) {
        $value = $value == "true" ? 1 : 0;
        $userid = Shared::$USERDATA['info']['id'];
        query("UPDATE UserSettings SET `$name` = $value WHERE user_id = '$userid'");
    }
}
?>