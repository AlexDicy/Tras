<?php
function getNotifications($num) {
    $array = array();
    $array['count'] = "";
    if (isLoggedIn()) {
        $userid = $_SESSION['info']['id'];
        $where = "WHERE user = $userid AND Notifications.from <> $userid AND Notifications.hide = 0";
        $query = query("SELECT Notifications.id, Notifications.user, Notifications.from, Notifications.where, Notifications.type, Notifications.when, Notifications.content, Notifications.viewed, Members.Avatar, Members.Nick FROM Notifications LEFT JOIN Members ON Members.id = Notifications.from     $where ORDER BY id DESC LIMIT $num");
        $count = mysqli_num_rows(query("SELECT id FROM Notifications $where AND viewed = 0 AND hide = 0 LIMIT 100"));
        $array['count'] = ($count == 0 ? "":($count == 100 ? "99+":$count));
        while ($n = mysqli_fetch_assoc($query)) {
            switch ($n['type']) {
                case 1:
                    $n['title'] = $n['Nick']." likes your post";
                    $n['link'] = "/post/".$_SESSION['info']['Nick']."/".$n['where'];
                    break;
                case 2:
                    $n['title'] = $n['Nick']." dislikes your post";
                    $n['link'] = "/post/".$_SESSION['info']['Nick']."/".$n['where'];
                    break;
                case 3:
                    $n['title'] = $n['Nick']." replied to your post";
                    $n['link'] = "/post/".$_SESSION['info']['Nick']."/".$n['where'];
                    break;
                case 4:
                    $n['title'] = "Tras alert";
                    $n['link'] = "/alert/".$n['id'];
                    $n['Avatar'] = "https://tras.pw/images/logo-min.png";
                    break;
                case 5:
                    $n['title'] = $n['Nick']." has added you as friend";
                    $n['link'] = "/user/".$n['Nick'];
                    break;
            }
            $array[] = $n;
        }
    }
    return $array;
}

function newNotification($user, $from, $where, $type, $content) {
    $content = escape(htmlentities($content));
    $sql = "INSERT INTO Notifications (`user`, `from`, `where`, `type`, `content`) VALUES ('$user', '$from', '$where', '$type', '$content') ON DUPLICATE KEY UPDATE `hide` = 0";
    /*
        curl -X POST 
        --header "Authorization: key=<server key>" 
        --header "Content-Type: application/json" 
        https://fcm.googleapis.com/fcm/send
        -d "{\"to\":\"<device registration id>\",\"priority\":\"high\",\"notification\":{\"body\": \"FOO BAR BLA BLA\"}}"
    */
    /*
        { "notification": {
            "title": "Background Message Title",
            "body": "Background message body",
            "click_action" : "https://dummypage.com"
        },

        "to" : "eEz-Q2sG8nQ:APA91bHJQRT0JJ..."

        }
    */
    if (query($sql)) return true;
    query($sql);
}

function deleteNotification($user, $from, $where, $type, $content) {
    $content = escape(htmlentities($content));
    $sql = "UPDATE Notifications SET `hide` = 1 WHERE `user` = '$user' AND `from` = '$from' AND `where` = '$where' AND `type` = '$type' AND `content` = '$content'";
    if (query($sql)) return true;
    query($sql);
}
?>