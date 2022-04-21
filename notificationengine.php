<?php
function getNotifications($num) {
    return getNotificationsByOffset(0, $num);
}

function getNotificationsByOffset($start, $num) {
    $array = array();
    $array['count'] = "";
    if (isLoggedIn()) {
        $userid = Shared::$USERDATA['info']['id'];
        $where = "WHERE user = $userid AND Notifications.from <> $userid AND Notifications.hide = 0";
        $query = query("SELECT Notifications.id, Notifications.user, Notifications.from, Notifications.where, Notifications.type, Notifications.when, Notifications.content, Notifications.viewed, Members.avatar, Members.nick FROM Notifications LEFT JOIN Members ON Members.id = Notifications.from $where ORDER BY id DESC LIMIT $start, $num");
        $count = mysqli_num_rows(query("SELECT id FROM Notifications $where AND viewed = 0 AND hide = 0 LIMIT 100"));
        $array['count'] = ($count == 0 ? "":($count == 100 ? "99+":$count));
        while ($n = mysqli_fetch_assoc($query)) {
            $n = getFinalAlert($n);
            $array[] = $n;
        }
    }
    return $array;
}

function getNotificationsCount($all = true) {
    if (isLoggedIn()) {
        $userid = Shared::$USERDATA['info']['id'];
        return mysqli_num_rows(query("SELECT id FROM Notifications WHERE user = $userid AND Notifications.from <> $userid AND hide = 0 LIMIT 1000"));
    }
    return 0;
}

function getFinalAlert($n) {
    if (!isset($n['nick'])) {
        $n['nick'] = mysqli_fetch_assoc(query("SELECT nick FROM Members WHERE id = '". $n['from'] ."'"))['nick'];
    }
    $linkbase = "https://tras.pw/readnotification/?where=".$n['where']."&link=";
    switch ($n['type']) {
        case 1:
            $n['title'] = $n['nick']." likes your post";
            $n['link'] = $linkbase."/post/".Shared::$USERDATA['info']['nick']."/".$n['where'];
            $n['collapsible'] = $n['where'];
            break;
        case 2:
            $n['title'] = $n['nick']." dislikes your post";
            $n['link'] = $linkbase."/post/".Shared::$USERDATA['info']['nick']."/".$n['where'];
            $n['collapsible'] = $n['where'];
            break;
        case 3:
            $n['title'] = $n['nick']." replied to your post";
            $n['link'] = $linkbase."/post/".Shared::$USERDATA['info']['nick']."/".$n['where'];
            $n['collapsible'] = $n['where'];
            $n['forceSend'] = true;
            break;
        case 4:
            $n['title'] = "Tras alert";
            $n['link'] = $linkbase."/alert/".$n['id'];
            $n['avatar'] = "https://tras.pw/images/logo-min.png";
            $n['forceSend'] = true;
            break;
        case 5:
            $n['title'] = $n['nick']." has added you as friend";
            $n['link'] = $linkbase."/user/".$n['nick'];
            $n['collapsible'] = $n['nick'];
            break;
        case 6:
            $n['title'] = $n['nick']." wrote: ".$n['content'];
            $n['link'] = $linkbase."/messages/chat/".$n['where'];
            $n['collapsible'] = $n['where'];
            $n['forceSend'] = true;
            break;
        //Didn't the third work the same? I didn't see it
        case 7:
            $n['title'] = $n['nick']." replied: ".$n['content'];
            $n['link'] = $linkbase."/post/".Shared::$USERDATA['info']['nick']."/".$n['where'];
            $n['collapsible'] = $n['where'];
            $n['forceSend'] = true;
            break;
    }
    return $n;
}

function newNotification($user, $from, $where, $type, $content) {
    $unsafeContent = unsafeEscape($content);
    $content = escape(htmlentities($content));

    $array = array("user" => $user, "from" => $from, "where" => $where, "type" => $type, "content" => $unsafeContent, "collapsible" => false, "forceSend" => false);
    $alert = getFinalAlert($array);

    $exists = $alert['forceSend'] ? 0: mysqli_num_rows(query("SELECT user FROM Notifications WHERE `user` = '$user' AND `from`='$from' AND `type`='$type' AND `where` = '$where'"));
    $sql = "INSERT INTO Notifications (`user`, `from`, `where`, `type`, `content`) VALUES ('$user', '$from', '$where', '$type', '$content') ON DUPLICATE KEY UPDATE `hide` = 0";
    $pushtoken = query("SELECT token FROM PushTokens WHERE user = '$user'");
    if (!empty($pushtoken) && $exists < 1) {
        while ($token = mysqli_fetch_assoc($pushtoken)) {
            $collapseKey = $alert["collapsible"] !== false ? ", \"collapse_key\": \"".escape($alert["collapsible"])."\"" : "";
            $settings = "{
                \"notification\": {
                    \"title\": \"Tras\",
                    \"body\": \"".$alert['title']."\",
                    \"click_action\": \"".$alert['link']."\",
                    \"icon\": \"https://tras.pw/images/logo-128.png\" },
                    \"to\": \"".$token['token']."\" $collapseKey }";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: key=** key **'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $settings);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    /*
        curl -X POST --header "Authorization: key=** key **" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{ \"notification\": {\"title\": \"Tras\", \"body\": \"it works :)\",\"click_action\" : \"https://tras.pw\", \"icon\": \"https://tras.pw/images/logo-128.png\"},\"to\" : \"dgWrb-VyP9M:APA91bEmJTpbc3EFDRE-TtxNE3k5Z4KzCp_RJP6Kcw9Ui3_OSsPXlwtD9ANT1nyExRDR5_jMoq_H8BrPndYeql2wrjRdAtlkWj9wKT6CWOyKGpPk3G80EzsWAY1AW31IMiI7Uv0MbVKw\"}"
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

function deleteMessageNotification($user, $where) {
    $sql = "DELETE FROM Notifications WHERE `user` = '$user' AND `where` = '$where' AND `type` = '6'";
    if (query($sql)) return true;
    query($sql);
}
?>
