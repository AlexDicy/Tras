<div class="col-md-6">
<?php
$page = 0;
if (isset($_GET['page'])) {
    $get = (int) $_GET['page'];
    $page = $get >= 0 ? $get : 0;
}
$notifications = getNotificationsByOffset(escape($page) * 10, 10);
$count = getNotificationsCount(true);
unset($notifications['count']);

foreach ($notifications as $n) {
?>
    <a class="notification-link" data-notification-id="<?php echo $n['id'] ?>" href="<?php echo $n['link'] ?>">
        <div class="panel panel-default b0<?php echo $n['viewed'] == 1 ? " bg-gray-lighter viewed":""; ?>">
            <div class="row row-table row-flush">
                <div class="col-xs-2 text-center">
                    <img class="sidebar-avatar mb-sm mt-sm center-block img-responsive thumb64" src="<?php echo $n['Avatar'] ?>" alt="Avatar image"/>
                </div>
                <div class="col-xs-10">
                    <div class="panel-body text-center">
                        <h4 class="mt0"><?php echo $n['title'] ?></h4>
                        <p class="mb0 text-muted"><?php if (!empty($n['content'])) { echo Shared::removeFormatting($n['content'])." "; } ?><?php echo Shared::elapsedTime($n['when']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php
}
?>
<ul class="pagination">
    <?php
    for ($i = 1; $i <= $count/10; $i++) {
        $p = $i - 1;
        $class = $page == $p ? ' class="active"' : "";
    ?>
    <li <?= $class ?>><a href="/notifications/?page=<?= $p ?>"><?= $p ?></a></li>
    <?php
    }
    ?>
</ul>
</div>
<?php include("template/right-sidebar.php");