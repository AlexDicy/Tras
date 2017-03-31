<li>
    <div class="reply-avatar">
        <img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['avatar'] ?>" />
    </div>
    <div>
        <a href="/user/<?php echo $reply['Nick'] ?>"><?php echo $reply['Nick'] ?></a>
        <?php echo $reply['content']; ?>
		<p class="m0 text-gray text-sm"><?= Shared::elapsedTime($reply['date']) ?> <?php if ($reply['user'] == $_SESSION['info']['id'] && false) { ?><a href="javascript:;">Delete</a><?php } ?></p>
	</div>
</li>