<?php
$page = Shared::get("path")[1];
if ($page == "fulllogin") {
    Shared::set("name", "Login");
    if (!empty(Shared::get("path")['2'])) {
        setcookie("Redirect", $_SERVER['REQUEST_URI'], time()+20, '/');
        header("Location: //" . Shared::get("host"));
        exit();
    }
} else Shared::set("name", ucfirst($page));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'template/head.php' ?>
</head>
<?php include 'template/body.php' ?>
</html>