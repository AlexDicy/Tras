<div id="replytoreply-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reply</h4>
            </div>
            <div class="modal-body">
                <?php if (isLoggedIn()) { ?><input type="text" placeholder="Write here" class="form-control" id="replytoreply-text" /> <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="replytoreply-button" class="btn btn-success" data-dismiss="modal">Reply</button>
            </div>
        </div>
    </div>
</div>