<li class="reply" id="reply-id-<?= $reply['id'] ?>">
    <div class="reply-avatar">
        <img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['avatar'] ?>" />
    </div>
    <div>
        <a href="/user/<?= $reply['Nick'] ?>"><?php echo $reply['Nick'] ?></a>
        <?php echo $reply['content']; ?>
		<p class="m0 text-gray text-sm"><a class="text-gray" href="/post/<?= $reply['Nick'] ?>/<?= $reply['id'] ?>"><?= Shared::elapsedTime($reply['date']) ?></a> <?php if ($reply['user'] == $_SESSION['info']['id']) { ?><a href="javascript:deleteReply(<?= $reply['id'] ?>);">Delete</a><?php } ?></p>
	</div>
</li>