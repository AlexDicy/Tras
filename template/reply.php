<li class="reply" id="reply-id-<?= $reply['id'] ?>">
    <div class="reply-avatar">
        <img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['avatar'] ?>" />
    </div>
    <div>
        <a href="/user/<?= $reply['Nick'] ?>"><?php echo $reply['Nick'] ?></a>
        <?php echo $reply['content']; ?>
		<p class="m0 text-gray text-sm"><a class="text-gray" href="/post/<?= $reply['Nick'] ?>/<?= $reply['id'] ?>"><?= Shared::elapsedTime($reply['date']) ?></a> <?php if (isLoggedIn() && $reply['user'] == $_SESSION['info']['id']) { ?><a href="javascript:deleteReply(<?= $reply['id'] ?>);">Delete</a><?php } if (isLoggedIn()) { ?><a href="javascript:replyToReply(<?= $reply['id'] ?>);"> Reply</a><?php } ?></p>
	</div>
    <?php if (isset($reply['lrid'])) { ?>
    <div class="reply-avatar">
        <img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['lrmavatar'] ?>" />
    </div>
    <div>
        <a href="/user/<?= $reply['lrmNick'] ?>"><?php echo $reply['lrmNick'] ?></a>
        <?php echo $reply['lrcontent']; ?>
		<p class="m0 text-gray text-sm"><a class="text-gray" href="/post/<?= $reply['lrmNick'] ?>/<?= $reply['lrid'] ?>"><?= Shared::elapsedTime($reply['lrdate']) ?></a> <?php if (isLoggedIn() && $reply['lruser'] == $_SESSION['info']['id']) { ?><a href="javascript:deleteReply(<?= $reply['lrid'] ?>);">Delete</a><?php } if (isLoggedIn()) { ?><a href="javascript:replyToReply(<?= $reply['lrid'] ?>);"> Reply</a><?php } ?></p>
	</div>
    <?php } ?>
</li>