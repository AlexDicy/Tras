<?php
if (isset($_POST['id'])) {
?>
<div id="opinions-list-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Opinions List</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <?php
                    $result = query("SELECT Opinions.user, Opinions.type, Opinions.date, Members.Nick, Members.Avatar FROM Opinions JOIN Members ON Opinions.user = Members.id WHERE Opinions.post = '".escape($_POST['id'])."'");
                    while ($info = mysqli_fetch_array($result)) {
                    ?>
                    <div class="panel panel-default b0">
                        <div class="portlet-handler ui-sortable-handle">
                            <div class="row row-table row-flush">
                                <div class="sidebar-avatar text-center" style="background-image:url(<?php echo $info['Avatar'] ?>);"></div>
                                <div class="col-xs-8">
                                    <div class="panel-body text-center">
                                        <div class="pull-left" style="margin-left: 20px;position: absolute;margin-top: -8px;">
                                            <a href="/user/<?php echo $info['Nick'] ?>"<h4 class="mt0"><?php echo $info['Nick'] ?></h4></a>
                                            <p class="mb0 text-muted">Type: <?php echo $info['type'] == 1 ? "Like" : "Dislike" ?></p>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-add-friend btn-primary pull-right fa fa-plus" data-user-id="<?php echo $info['user'] ?>"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$("#opinions-list-modal").remove();" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
windowReload();
</script>
<?php
}
?>