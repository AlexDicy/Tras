<?php

    $text = $info['content'];

    $hasOpinion = $info['has_opinion'];
    $opinion = $info['has_opinion'] == 1 ? true : false;
    $likeClass = $hasOpinion ? " active" : " active";
    $dislikeClass = $hasOpinion ? " active" : " active";
    $value = is_null($hasOpinion);
    if (!$value && $opinion) {
        $likeClass = " active" ;
        $dislikeClass = "";
    } else if (!$value && !$opinion) {
        $likeClass = "";
        $dislikeClass = " active";
    }
?>
    <div class="post post-margin-bottom">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <a href="/user/<?php echo $info['Nick'] ?>/"><span class="caption-subject"><?php echo $info['Nick'] ?><?php if ($info['verified'] == 1) { ?><a> <i class="fa fa-check-circle" style="color: #42A5F5;"></i></a><?php } else if ($info['verified'] == 2) { ?><a> <i class="fa fa-check-circle" style="color: #4CAF50;"></i></a><?php } ?></span></a>
                    <a href="/post/<?php echo $info['Nick']."/".$info['id'] ?>/"><span class="caption-helper"><small> <?php echo date("H:i d/m/Y", strtotime($info['date'])) ?></small></span></a>
                </div>
                <?php if (isLoggedIn()) { ?>
                <div class="actions post-menu">
                    <a href="#menu" class="post-menu-toggler<?php if ($info['user'] == $_SESSION['info']['id']) {echo " owner";} ?>" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>"><span class="caret"></span></a>
                </div>
                <?php } ?>
            </div>
            <div class="portlet-body">
                <p><?php echo nl2br(formatter($text)) ?></p>
            </div>
            <div class="post-footer">
                <div class="actions">
                    <a class="opinions-counter" data-post-id="<?php echo $info['id'] ?>"><?php echo empty($info['likes']) ? "0" : $info['likes'] ?>/<?php echo empty($info['dislikes']) ? "0" : $info['dislikes'] ?></a>
                    <?php if (isLoggedIn()) { ?>
                    <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" class="like-btn pbtn pbtn-blue<?php echo $likeClass ?>">
                        <i class="fa fa-heart"></i>
                        Like
                    </a>
                    <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" class="dislike-btn pbtn pbtn-red<?php echo $dislikeClass ?>">
                        <i class="fa fa-thumbs-down"></i>
                        Dislike
                    </a>
                    <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-share"></i>
                        Share
                    </a>
                    <?php } /*<a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-comment"></i>
                        Reply
                    </a>
                    <?php } /*<a href="javascript:;" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-comment"></i>
                        Reply
                    </a>*/ ?>
                </div>
                <?php /*<input type="text" data-post-id="<?php echo $info['id'] ?>" placeholder="Reply to <?php echo $info['Nick'] ?>'s post" class="form-control send-reply-input" />
				<?php
				if ($replies) {
					echo "<ul class=\"replies\">";
					while ($reply = mysqli_fetch_array($replies)) {
						?>
					<li>
						<div class="reply-avatar">
							<img class="mb center-block img-circle img-responsive thumb32" src="<?php echo $reply['avatar'] ?>" />
						</div>
						<div>
							<a href="/user/<?php echo $reply['Nick'] ?>"><?php echo $reply['Nick'] ?></a>
						<?php
							echo "{$reply['content']}";
						?>
							<p class="m0 text-gray text-sm"><?php echo Shared::elapsedTime($reply['date']) ?> <?php if ($reply['user'] == $_SESSION['info']['id']) { ?><a href="javascript:;">Delete</a><?php } ?></p>
						</div>
				<?php
						echo "</li>";
					}
					echo "</ul>";
				}
				?>
				<style>
.replies {
    padding: 0;
	margin: 0;
    list-style: none;
    max-height: 200px;
    overflow: auto;
}
.replies li {
    margin: 0;
    margin-top: 10px;
}
.replies li > div {
    display:table-cell;
}
.reply-avatar {
    margin-right: 5px;
    float: left;
}

				</style>
				*/ ?>
            </div>
        </div>
    </div>