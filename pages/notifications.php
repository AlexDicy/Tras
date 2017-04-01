<div class="col-md-6">
<?php
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
                        <p class="mb0 text-muted"><?php if (!empty($n['content'])) { echo $n['content']." "; } ?><?php echo Shared::elapsedTime($n['when']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php
}
?>
</div>
<?php include("template/right-sidebar.php");