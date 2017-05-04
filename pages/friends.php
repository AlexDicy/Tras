<?php
$userid = $_SESSION['info']['id'];
Shared::set("friendsids", empty(Shared::get("friendslist")) ? "" : implode(', ', Shared::get("friendslist")));
$sql = query("SELECT id, nick FROM Members WHERE id IN (".Shared::get("friendsids").") LIMIT 30");
while($info = mysqli_fetch_array($sql)){
?>
<a href="/user/<?php echo $info['nick'] ?>">
    <div id="panelPortlet4" class="panel panel-default b0">
        <div class="row row-table row-flush">
            <div class="col-xs-4 bg-danger text-center">
                <em class="fa fa-user fa-2x"></em>
            </div>
            <div class="col-xs-8">
                <div class="panel-body text-center">
                    <h4 class="mt0"><?php echo $info['nick'] ?></h4>
                    <p class="mb0 text-muted"><?php echo $info['id'] ?></p>
                </div>
            </div>
        </div>
    </div>
</a>
<?php
}
?>