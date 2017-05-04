<?php
if (isset($_POST['id'])) {
?>
<div id="opinions-list-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Opinions List</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <?php
                    $result = query("SELECT Opinions.user, Opinions.type, Opinions.date, Members.nick, Members.avatar FROM Opinions JOIN Members ON Opinions.user = Members.id WHERE Opinions.post = '".escape($_POST['id'])."'");
                    while ($info = mysqli_fetch_array($result)) {
                    ?>
                    <div class="row row-table row-flush post-margin-bottom">
                        <div class="sidebar-avatar text-center" style="background-image:url(<?php echo $info['avatar'] ?>);"></div>
                        <div class="col-xs-7">
                            <div class="panel-body">
                                <div style="margin-left: 20px;margin-top: -8px;">
                                    <a href="/user/<?php echo $info['nick'] ?>"<h4 class="mt0"><?php echo $info['nick'] ?></h4></a>
                                    <p class="mb0 text-muted"><?php echo $info['type'] == 1 ? "Like" : "Dislike" ?></p>
                                    <p class="mb0 text-muted"><?php echo date("H:i d/m/Y", strtotime($info['date'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="opinions-modal-close-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
}
?>