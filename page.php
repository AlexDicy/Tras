<?php
$page = $path[1];
if ($page == "fulllogin") $name = "Login";
else $name = ucfirst($page);
?>

<!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<?php include 'template/head.php' ?>
</head>
<?php include 'template/body.php' ?>
</html>