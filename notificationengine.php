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
            $n = getFinalAlert($n);
            $array[] = $n;
        }
    }
    return $array;
}

function getFinalAlert($n) {
    if (!isset($n['Nick'])) {
        $n['Nick'] = mysqli_fetch_assoc(query("SELECT Nick FROM Members WHERE id = '". $n['from'] ."'"))['Nick'];
    }
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
    return $n;
}

function newNotification($user, $from, $where, $type, $content) {
    $content = escape(htmlentities($content));
    $sql = "INSERT INTO Notifications (`user`, `from`, `where`, `type`, `content`) VALUES ('$user', '$from', '$where', '$type', '$content') ON DUPLICATE KEY UPDATE `hide` = 0";
    $pushtoken = query("SELECT token FROM PushTokens WHERE user='$user'");
    if (!empty($pushtoken)) {
        $array = array("user" => $user, "from" => $from, "where" => $where, "type" => $type, "content" => $content);
        $alert = getFinalAlert($array);
        while ($token = mysqli_fetch_assoc($pushtoken)) {
            $settings = "{ \"notification\": {\"title\": \"Tras\", \"body\": \"".$alert['title']."\", \"click_action\" : \"https://tras.pw".$alert['link']."\", \"icon\": \"https://tras.pw/images/logo-128.png\" }, \"to\" : \"".$token['token']."\"}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: key=AAAAtrUBppc:APA91bHnFzZnnlXRn0n2BuM05UWH5pGaOk-Ef1BLfgSRbIk6pYCuNZvUtXaJBGdf7D4PFDZwkpPKUIgzLjo5LaYW8Evjw_j-oEtYqE4W-BU-X3yIQ3Ub4skZdkOW7fCugSNn6uEzeoyi'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $settings);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    /*
        curl -X POST --header "Authorization: key=AAAAtrUBppc:APA91bHnFzZnnlXRn0n2BuM05UWH5pGaOk-Ef1BLfgSRbIk6pYCuNZvUtXaJBGdf7D4PFDZwkpPKUIgzLjo5LaYW8Evjw_j-oEtYqE4W-BU-X3yIQ3Ub4skZdkOW7fCugSNn6uEzeoyi" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{ \"notification\": {\"title\": \"Tras\", \"body\": \"it works :)\",\"click_action\" : \"https://tras.pw\", \"icon\": \"https://tras.pw/images/logo-128.png\"},\"to\" : \"dgWrb-VyP9M:APA91bEmJTpbc3EFDRE-TtxNE3k5Z4KzCp_RJP6Kcw9Ui3_OSsPXlwtD9ANT1nyExRDR5_jMoq_H8BrPndYeql2wrjRdAtlkWj9wKT6CWOyKGpPk3G80EzsWAY1AW31IMiI7Uv0MbVKw\"}"
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