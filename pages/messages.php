<?php
$sql;
$userid = $_SESSION['info']['id'];
$home = false;
if (isset(Shared::get("path")[1]) && isset(Shared::get("path")[2]) && Shared::get("path")[1] == "chat") {
    $chat = escape(Shared::get("path")[1]);
    $sql = query("SELECT `Messages.id` as id, `Messages.user` as user, `Messages.chat_id` as chat_id, `Messages.content` as content, `Messages.post_date` as post_date, `Members.Avatar` as avatar FROM `Messages` JOIN `Members` ON  WHERE `Messages.chat_id` = '$chat'");
} else {
    $home = true;
    $sql = query("SELECT
                    Chats.id,
                    Chats.chat_id,
                    Members.Nick,
                    Members.Avatar,
                    (SELECT Messages.content FROM Messages WHERE Messages.chat_id = Chats.chat_id ORDER BY Messages.post_date DESC LIMIT 1) AS content,
                    (SELECT Messages.post_date FROM Messages WHERE Messages.chat_id = Chats.chat_id ORDER BY Messages.post_date DESC LIMIT 1) AS post_date
                  FROM Chats
                  JOIN Members
                    ON Chats.user = Members.id
                  WHERE Chats.chat_id IN (SELECT Chats.chat_id FROM Chats WHERE Chats.user = '$userid') AND Chats.user <> '$userid'");
}
$previousId = 0;
if ($home) {
    if (mysqli_num_rows($sql) > 0) {
?>
<div class="table-container">
    <table class="table table-filter">
        <tbody>
<?php
        while ($info = mysqli_fetch_array($sql)) {
            include('template/messagerow.php');
        }
?>
        </tbody>
    </table>
</div>
<?php
    } else {
        echo "<p>Start a new chat</p>";
    }
} else {

}
include("template/right-sidebar.php");