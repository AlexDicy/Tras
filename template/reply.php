<?php
if (isset($reply['numreplies'])) {
    $numreplies = $reply['numreplies'];
    $numrepliesText = $numreplies == 1 ? " reply " : " replies ";
}
if (isset($reply['lrnumreplies'])) {
    $lrnumreplies = $reply['lrnumreplies'];
    $lrnumrepliesText = $lrnumreplies == 1 ? " reply " : " replies ";
}
?>

<li class="reply" id="reply-id-<?= $reply['id'] ?>">
    <div class="reply-avatar">
        <img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['avatar'] ?>" />
    </div>
    <div>
        <a href="/user/<?= $reply['nick'] ?>"><?php echo $reply['nick'] ?></a>
        <?php echo $reply['content']; ?>
		<p class="m0 text-gray text-sm">
            <a class="text-gray" href="/post/<?= $reply['nick'] ?>/<?= $reply['id'] ?>"><?= Shared::elapsedTime($reply['date']) ?></a> 
            <?= isset($numreplies) ? $numreplies.$numrepliesText : "" ?>
            <?php if (isLoggedIn() && $reply['user'] ==  Shared::$USERDATA['info']['id']) { ?>
            <a href="javascript:deleteReply(<?= $reply['id'] ?>);">Delete</a>
            <?php } if (isLoggedIn()) { ?><a href="javascript:replyToReply(<?= $reply['id'].", ".$reply['user'] ?>);"> Reply</a><?php } ?>
        </p>
	</div>
</li>
<?php if (isset($reply['lrid'])) { ?>
<li class="reply" id="reply-id-<?= $reply['lrid'] ?>">
    <div class="reply-avatar-sub">
        <img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['lrmavatar'] ?>" />
    </div>
    <div>
        <a href="/user/<?= $reply['lrmnick'] ?>"><?php echo $reply['lrmnick'] ?></a>
        <?php echo $reply['lrcontent']; ?>
		<p class="m0 text-gray text-sm">
            <a class="text-gray" href="/post/<?= $reply['lrmnick'] ?>/<?= $reply['lrid'] ?>"><?= Shared::elapsedTime($reply['lrdate']) ?></a> 
            <?= isset($lrnumreplies) ? $lrnumreplies.$lrnumrepliesText : "" ?>
            <?php if (isLoggedIn() && $reply['lruser'] ==  Shared::$USERDATA['info']['id']) { ?>
            <a href="javascript:deleteReply(<?= $reply['lrid'] ?>);">Delete</a>
            <?php } if (isLoggedIn()) { ?><a href="javascript:replyToReply(<?= $reply['lrid'].", ".$reply['lruser'] ?>);"> Reply</a><?php } ?></p>
	</div>
</li>
<?php } ?>