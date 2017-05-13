<!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>

<?php
Shared::set("notifications", getNotifications(7));
Shared::set("notificationsCount", Shared::get("notifications")['count']);
Shared::unsetValue("notifications", "count");
?>

<?php include 'template/head.php' ?>
</head>
<body class="layout-fixed <?php if (Shared::get("darkmode")) echo "bg-inverse bg-light" ?>">
    <?php include 'noscript.php' ?>
    <div class="app-container">
        <?php include "template/header.php"; ?>
        <?php include "template/sidebar.php"; ?>
        <section>
            <div class="app">
                <h3><?php echo Shared::get("name") ?></h3>
                <div class="container-fluid">
                    <?php include "pages/".Shared::get("pagename").".php"; ?>
                </div>
            </div>
        </section>
        <?php include "template/delete-post-modal.php"; ?>
        <?php include "template/delete-reply-modal.php"; ?>
        <?php include "template/share-modal.php"; ?>
        <?php include "template/replytoreply-modal.php"; ?>
        <footer>
            <span>© <?php echo date('Y'); ?> - Tras</span>
        </footer>
    </div>
    <?php include "template/endscripts.php"; ?>
</body>
</html>
