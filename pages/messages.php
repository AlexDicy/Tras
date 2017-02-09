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
$previousId = 0;
if ($home) {
    if (mysqli_num_rows($sql) > 0) {
?>
<style>
.table-filter {
    background-color: #fff;
    border-bottom: 1px solid #eee;
}
.table-filter tbody tr:hover {
    cursor: pointer;
    background-color: #eee;
}
.table-filter tbody tr td {
    padding: 10px;
    vertical-align: middle;
    border-top-color: #eee;
}
.table-filter tbody tr.selected td {
    background-color: #eee;
}
.table-filter tr td:first-child {
    width: 38px;
}
.table-filter tr td:nth-child(2) {
    width: 35px;
}
h4.chat-title {
    margin-bottom: 0;
}
</style>
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
<style>
.chat-window {
    min-height: 500px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    background-color: #f8f8f8;
    overflow: hidden;
    margin-bottom: 34px;
}
.top-menu {
    background-color: #fff;
    width: 100%;
    padding: 20px 0 15px;
    box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
}
.top-menu .buttons {
    margin: 3px 0 0 20px;
    position: absolute;
}
.top-menu .buttons .button {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
    position: relative;
}
.top-menu .buttons .button.close {
    background-color: #f5886e;
}
.top-menu .buttons .button.minimize {
    background-color: #fdbf68;
}
.top-menu .buttons .button.maximize {
    background-color: #a3d063;
}
.top-menu .title {
    text-align: center;
    color: #bcbdc0;
    font-size: 20px;
}
.messages {
    position: relative;
    list-style: none;
    padding: 20px 10px 0 10px;
    margin: 0;
    min-height: 340px;
    overflow: auto;
    max-height: 442px;
}
.messages .message {
    clear: both;
    overflow: hidden;
    margin-bottom: 20px;
    transition: all 0.5s linear;
    opacity: 0;
}
.messages .message.left .avatar {
    float: left;
}
.messages .message.left .text-wrapper {
    background-color: #ffe6cb;
    margin-left: 20px;
}
.messages .message.left .text-wrapper::after,
.messages .message.left .text-wrapper::before {
    right: 100%;
    border-right-color: #ffe6cb;
}
.messages .message.left .text {
    color: #c48843;
}
.messages .message.right .avatar {
    float: right;
}
.messages .message.right .text-wrapper {
    background-color: #c7eafc;
    margin-right: 20px;
    float: right;
}
.messages .message.right .text-wrapper::after,
.messages .message.right .text-wrapper::before {
    left: 100%;
    border-left-color: #c7eafc;
}
.messages .message.right .text {
    color: #45829b;
}
.messages .message.appeared {
    opacity: 1;
}
.messages .message .avatar {
    display: inline-block;
}
.messages .message .text-wrapper {
    display: inline-block;
    padding: 14px;
    border-radius: 5px;
    min-width: 100px;
    position: relative;
}
.messages .message .text-wrapper::after,
.messages .message .text-wrapper:before {
    top: 18px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}
.messages .message .text-wrapper::after {
    border-width: 13px;
    margin-top: 0px;
}
.messages .message .text-wrapper::before {
    border-width: 15px;
    margin-top: -4px;
}
.messages .message .text-wrapper .text {
    font-size: 18px;
    font-weight: 300;
}
.bottom-wrapper {
    position: relative;
    width: 100%;
    background-color: #fff;
    padding: 20px 20px;
    bottom: 0;
}
.bottom-wrapper .message-input-wrapper {
    display: inline-block;
    height: 50px;
    border-radius: 4px;
    border: 1px solid #bcbdc0;
    width: calc(100% - 160px);
    min-width: 200px;
    position: relative;
    padding: 0 20px;
}
.bottom-wrapper .message-input-wrapper .message-input {
    border: none;
    height: 100%;
    box-sizing: border-box;
    width: calc(100% - 40px);
    position: absolute;
    outline-width: 0;
    color: gray;
}
.bottom-wrapper .send-message {
    width: 140px;
    height: 50px;
    display: inline-block;
    border-radius: 6px;
    background-color: #a3d063;
    border: 2px solid #a3d063;
    color: #fff;
    cursor: pointer;
    transition: all 0.2s linear;
    text-align: center;
    float: right;
}
.bottom-wrapper .send-message:hover {
    color: #a3d063;
    background-color: #fff;
}
.bottom-wrapper .send-message .text {
    font-size: 18px;
    font-weight: 300;
    display: inline-block;
    line-height: 48px;
}
.message-template {
    display: none;
}
#contextMenu {
    display: none;
    z-index: 1000;
    position: fixed;
    overflow: hidden;
    border: 1px solid #CCC;
    white-space: nowrap;
    font-family: sans-serif;
    background: #FFF;
    color: #333;
    border-radius: 5px;
    padding: 0;
}
#contextMenu li {
    padding: 8px 12px;
    cursor: pointer;
    list-style-type: none;
    transition: all .3s ease;
}
#contextMenu li:hover {
    background-color: #DEF;
}
#contextMenu ul {
    margin: 0;
    padding: 0;
}
</style>
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
	})
});
$(document).bind("contextmenu", function(event) {
    var element = $(event.target);
    if (element.hasClass("text-wrapper") || element.hasClass("text")) {
        $("#contextMenu").css({"top": event.pageY + "px", "left": event.pageX + "px"}).show();
        event.preventDefault();
    }
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