<?php
$sql;
$userid = $_SESSION['info']['id'];
$home = false;
$chat = false;
$new = false;
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
                  FROM Chats
                  JOIN Messages
                    ON Messages.chat_id = Messages.chat_id
                  JOIN Members
                    ON Messages.user = Members.id
                  WHERE Chats.chat_id = '$chatid' AND Chats.user = '$userid'");
} else if (isset(Shared::get("path")[1]) && Shared::get("path")[1] == "new") {
    $friendsids = empty(Shared::get("friendslist")) ? "" : implode(', ', Shared::get("friendslist"));
    $new = true;
    $sql = query("SELECT id, Nick FROM Members WHERE id IN (".$friendsids.")");
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
    $("text-wrapper, text, avatar, avatar-image").on("mousedown", function(){
        var elem = $(this);
        timer = setTimeout(function(){
            var pos = elem.position();
            $("#contextMenu").css({"top": pos.top + "px", "left": pos.left + "px"}).show();
            return false;
        }, 2*1000);
    }).on("mouseup mouseleave",function(){
        clearTimeout(timer);
    });

    var msg = document.getElementById("messages");
    msg.scrollTop = msg.scrollHeight - msg.clientHeight;

    window.scrollMessages = function() {
        var isScrolled = msg.scrollHeight - msg.clientHeight <= msg.scrollTop + 10;
        if (isScrolled)
            msg.scrollTop = msg.scrollHeight - msg.clientHeight;
    };

    var Message;
    Message = function (arg) {
        this.text = arg.text, this.messageSide = arg.messageSide;
        this.draw = function (that) {
            return function () {
                var message;
                message = $($(".message-template").clone().html());
                message.addClass(that.messageSide).find(".text").html(that.text);
                $(".messages").append(message);
                return setTimeout(function() {
                    return message.addClass("appeared");
                }, 0);
            };
        }(this);
        return this;
    };

    function sAlert(name, val) {
        if (val) {
            $(name).fadeIn("fast", function() {
                $(name).show()
            });
        } else {
            $(name).fadeOut("fast", function() {
                $(name).hide()
            });
        }
    }

    function sendMessage(text, position, messages) {
        message = new Message({
            text: text,
            messageSide: position
        });
        message.draw();
        messages.animate({scrollTop: messages.prop('scrollHeight')}, 300);
    }

    $(".send-message").on("click", function() {
        sAlert("#error", false);
        var that = $(this);
        var input = $("#message-input");
        var text = input.val();
        var messages = $(msg);
        if (text.length > 0) {
            $.ajax({
                url: "/sendmessage",
                type: "POST",
                dataType: "json",
                data: {
                    content: text,
                    chat_id: "<?php echo Shared::get("path")[2]; ?>"
                },
                success: function(data) {
                    if (data.CODE == 700) {
                        input.val("");
                        sendMessage(text, "right", messages);
                    } else sAlert("#error", true);
                },
                error: function() {
                    sAlert("#error", true);
                }
            });
        }
    });
});
$(document).bind("contextmenu", function(event) {
    var elem = $(event.toElement);
    if (elem.hasClass("text-wrapper") || elem.hasClass("text") || elem.hasClass("avatar") || elem.hasClass("avatar-image")) {
        $("#contextMenu").css({"top": event.pageY + "px", "left": event.pageX + "px"}).show();
        event.preventDefault();
    }
});
$(document).bind('click', function() {
    $('#contextMenu').hide();
});
</script>
<div class="col-md-6">
<div class="alert alert-danger" style="display: none" id="error"><strong>Error</strong> please try again.</div>
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
        <ul id="messages" class="messages">
        <?php 
        if (mysqli_num_rows($sql) > 0) {
            while ($info = mysqli_fetch_array($sql)) {
        ?>
            <li class="message <?php echo ($info['user'] == $userid) ? "right":"left"; ?> appeared">
                <div class="avatar">
                    <img class="avatar-image mb center-block img-circle img-responsive thumb64" src="<?php echo $info['Avatar'] ?>">
                </div>
                <div class="text-wrapper">
                    <div class="text"><?php echo base64_decode($info['content']); ?></div>
                </div>
            </li>
        <?php
            }
        }
        ?>
        </ul>
        <div class="bottom-wrapper clearfix">
            <div class="message-input-wrapper">
                <input class="message-input" id="message-input" placeholder="Type a message..." />
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
        <div class="avatar">
            <img class="avatar-image mb center-block img-circle img-responsive thumb64" src="<?php echo $_SESSION['info']['Avatar']; ?>">
        </div>
        <div class="text-wrapper">
            <div class="text"></div>
        </div>
    </li>
</div>
<?php
} else if ($new) {
?>
<script>
$(function() {
    $(".new-chat").on("click", function() {
        var that = $(this);
        $.ajax({
            url: "/newchat",
            type: "POST",
            dataType: "json",
            data: {
                user_id: that.data("user-id")
            },
            success: function(data) {
                if (data.CODE == 700) {
                    window.location.href = "https://tras.pw/messages";
                }
            }
        });
        return false;
    });
});
</script>
<?php
    while($info = mysqli_fetch_array($sql)){
?>
<a class="new-chat" data-user-id="<?php echo $info['id'] ?>" href="//<?php echo Shared::get("host"); ?>/messages/">
    <div id="panelPortlet4" class="panel panel-default b0">
        <div class="row row-table row-flush">
            <div class="col-xs-4 bg-danger text-center">
                <em class="fa fa-user fa-2x"></em>
            </div>
            <div class="col-xs-8">
                <div class="panel-body text-center">
                    <h4 class="mt0"><?php echo $info['Nick'] ?></h4>
                    <p class="mb0 text-muted"><?php echo $info['id'] ?></p>
                </div>
            </div>
        </div>
    </div>
</a>
<?php
    }
}
include("template/right-sidebar.php");