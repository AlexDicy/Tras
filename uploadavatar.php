<?php
require_once 'session.php';
$dir = "members/avatar/";
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

$img = $_POST['image'];
if (empty($img) || !isLoggedIn()) exit("{\"status\": 300, \"error\": \"Empty image, try again.\"}");
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $dir . md5($data) . '.png';
if (file_exists(".".$file)) $success = true;
else $success = file_put_contents(".".$file, $data);
if (!$success) exit("{\"status\": 302, \"error\": \"An error occurred, try again.\"}");
query("UPDATE Members SET Avatar = 'https://tras.pw/$file' WHERE id = " . $_SESSION['info']['id']);
echo "{\"status\": 200}";
?>