<?php
$sql;
$userid = $_SESSION['info']['id'];
$home = false;
$chat = false;
if (isset(Shared::get("path")[1]) && isset(Shared::get("path")[2]) && Shared::get("path")[1] == "chat") {
    $chatid = escape(Shared::get("path")[2]);
    $chat = true;
    $sql = query("SELECT
                    Members.Nick,
                    Members.Avatar,
                    Messages.content,
                    Messages.post_date,
                    Messages.id,
                    Messages.user
                  FROM Messages
                  JOIN Members
                    ON Messages.user = Members.id
                  WHERE Messages.chat_id = '$chatid'");
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
?>
<link type="text/css" rel="stylesheet" href="//<?php echo Shared::get("host") ?>/assets/styles/messages.css">
<?php
if ($home) {
    if (mysqli_num_rows($sql) > 0) {
?>
<div class="table-container">
    <table class="table table-filter">
        <tbody>
            <tr>
                <td>
                    <a href="//<?php echo Shared::get("host") ?>/messages/new/" class="media">
                        <div>
                            <div class="media-body">
                                <h4 class="chat-title">
                                    <i class="fa fa-plus" aria-hidden="true"></i> New chat
                                </h4>
                            </div>
                        </div>
                    </a>
                </td>
            </tr>
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
        echo "<p>Start a new chat!</p>";
    }
} else if ($chat) {
?>
<script>
$(function () {
    var timer;
    $("text-wrapper, text").on("mousedown",function(){
        var elem = $(this);
        timer = setTimeout(function(){
            var pos = elem.position();
            $("#contextMenu").css({"top": pos.top + "px", "left": pos.left + "px"}).show();
            return false;
        }, 2*1000);
    }).on("mouseup mouseleave",function(){
        clearTimeout(timer);
    });
	$(document).bind("contextmenu", function(event) {
        var elem = $(this.toElement);
		if (elem.hasClass("text-wrapper") && elem.hasClass("text")) {
			var pos = elem.position();
        	$("#contextMenu").css({"top": pos.top + "px", "left": pos.left + "px"}).show();
			event.preventDefault();
		}
    })
});
$(document).bind('click', function() {
    $('#contextMenu').hide();
});
</script>
<div class="col-md-6">
<div id="contextMenu">
    <ul>
        <li><a href="#">Edit</a></li>
        <li><a href="#">Delete</a></li>
    </ul>
</div>
    <div class="chat-window">
        <div class="top-menu">
            <div class="buttons">
                <div class="button close"></div>
                <div class="button minimize"></div>
                <div class="button maximize"></div>
            </div>
            <div class="title">Chat</div>
        </div>
        <ul class="messages">
        <?php 
        if (mysqli_num_rows($sql) > 0) {
            while ($info = mysqli_fetch_array($sql)) {
        ?>
            <li class="message <?php echo ($info['user'] == $userid) ? "right":"left"; ?> appeared">
                <div class="avatar">
                    <img class="mb center-block img-circle img-responsive thumb64" src="<?php echo $info['Avatar'] ?>">
                </div>
                <div class="text-wrapper">
                    <div class="text"><?php echo $info['content'] ?></div>
                </div>
            </li>
        <?php
            }
        }
        ?>
        </ul>
        <div class="bottom-wrapper clearfix">
            <div class="message-input-wrapper">
                <input class="message-input" placeholder="Type a message..." />
            </div>
            <div class="send-message">
                <div class="icon"></div>
                <div class="text">Send</div>
            </div>
        </div>
    </div>
</div>
<div class="message-template">
    <li class="message">
        <div class="avatar"></div>
        <div class="text-wrapper">
            <div class="text"></div>
        </div>
    </li>
</div>
<?php
}
include("template/right-sidebar.php");