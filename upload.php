<?php
require_once 'session.php';
$dir = "/members/avatar/";
$uploadOk = 1;
$image;
$rsz;
$none = "none.png";
$fn = $_FILES["image"]["tmp_name"];
$file_name = $dir . $none;
$maxDim = 2000;
$minDim = 200;
$width = $height = 0;
$resized = false;

if (empty($fn)) {
    $uploadOk = 0;
    echo "Empty   " . $_FILES["image"]["tmp_name"];
    $proceed = false;
} else {
    $proceed = true;
}

if ($proceed) {
    $file_name = $dir . basename(hash_file('md5', $fn)) . ".png";
    $imageFileType = pathinfo($fn, PATHINFO_EXTENSION);
    if ($_FILES["image"]["size"] > 20000000 || !isLoggedIn()) {
        $uploadOk = 0;
    }
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $image = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
        list($width, $height, $type, $attr) = $check;
        if ($width > $maxDim || $height > $maxDim) {
            $ratio = $check[0]/$check[1];
            if ($ratio > 1) {
                $width = $maxDim;
                $height = $maxDim/$ratio;
            } else {
                $width = $maxDim*$ratio;
                $height = $maxDim;
            }
            $rsz = imagecreatetruecolor($width, $height);
            imagealphablending($rsz, false);
            imagesavealpha($rsz, true);
            imagecopyresampled($rsz, $image, 0, 0, 0, 0, $width, $height, $check[0], $check[1]);
            $resized = true;
        } else if ($width < $minDim || $height < $minDim) {
            exit("{\"error\": \"Image must be at least 200x200\"}");
        }
        if ($resized) {
            imagepng($rsz, "." . $file_name . ".tmp.png");
            $image = imagecreatefrompng("." . $file_name . ".tmp.png");
            imagealphablending($image, false);
            imagesavealpha($image, true);
            unlink("." . $file_name . ".tmp.png");
            imagedestroy($rsz);
        }
    } else $uploadOk = 0;
}

if ($uploadOk == 0 || !$proceed) {
    echo "{\"error\": \"An error occured, try again.\"}";
    $cc = "cc";
} else {
    if ($proceed && file_exists("." . $file_name)) {
        $cc = "cc";
        echo "{}";
        setAvatar();
    } else if ($proceed && imagepng($image, "." . $file_name)) {
        echo "{}";
        imagedestroy($image);
        setAvatar();
    } else if (!isset($cc)){
        echo "{\"error\": \"An error occured, try again.\"}";
    }
}
function setAvatar() {
    global $file_name;
    query("UPDATE Members SET avatar = 'https://tras.pw/$file_name' WHERE id = " . $USERDATA['info']['id']);
}
?>
