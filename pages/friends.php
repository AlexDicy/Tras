<?php
$userid = $_SESSION['info']['id'];
$friendsids = empty($friendslist) ? "" : implode(', ', $friendslist);
$sql = query("SELECT id, Nick FROM Members WHERE id IN ($friendsids) LIMIT 30");
while($info = mysqli_fetch_array($sql)){
?>
<a href="/user/<?php echo $info['Nick'] ?>">
    <div id="panelPortlet4" class="panel panel-default b0">
        <div class="row row-table row-flush">
            <div class="col-xs-4 bg-danger text-center">
                <em class="fa fa-user fa-2x"></em>
            </div>
            <div class="col-xs-8">
                <div class="panel-body text-center">
                    <h4 class="mt0"><?php echo $info['Nick'] ?></h4>
                    <p class="mb0 text-muted"><?php echo $info['id'] ?></p>
                </div>
            </div>
        </div>
    </div>
</a>
<?php
}
?>