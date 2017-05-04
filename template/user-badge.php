<div class="panel panel-default b0">
    <div class="portlet-handler ui-sortable-handle">
        <div class="row row-table row-flush">
            <div class="sidebar-avatar text-center" style="background-image:url(<?php echo $info['avatar'] ?>);"></div>
            <div class="col-xs-8">
                <div class="panel-body text-center">
                    <div class="pull-left" style="margin-left: 20px;position: absolute;margin-top: -8px;">
                        <a href="/user/<?php echo $info['nick'] ?>/"<h4 class="mt0"><?php echo $info['nick'] ?></h4></a>
                        <p class="mb0 text-muted">Friends: <?php echo getFriendsCount($info['id']) ?></p>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-add-friend btn-primary pull-right fa fa-plus" data-user-id="<?php echo $info['id'] ?>"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>