<?php
function getNotifications() {
    $query = query("SELECT * From Notifications WHERE user = ".$_SESSION['info']['id']." ORDER BY id LIMIT 10");
    $array = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $array[] = $row;
    }
    return $array;
}
echo "<pre>";
print_r(getNotifications());
echo "</pre>";
?>