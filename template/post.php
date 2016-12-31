<?php
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
					<a href="/user/<?php echo $info['Nick'] ?>"><span class="caption-subject"><?php echo $info['Nick'] ?><?php if ($info['verified'] == 1) { ?><a> <i class="fa fa-check-circle" style="color: #43a8eb;"></i></a><?php } ?></span></a>
					<a href="/post/<?php echo $info['Nick']."/".$info['id'] ?>"><span class="caption-helper"><small> <?php echo date("H:i d/m/Y", strtotime($info['date'])) ?></small></span></a>
				</div>
				<div class="actions post-menu">
					<a href="#menu" class="post-menu-toggler<?php if ($info['user'] == $_SESSION['info']['id']) {echo " owner";} ?>" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>"><span class="caret"></span></a>
				</div>
			</div>
			<div class="portlet-body">
				<p><?php echo nl2br($info['content']) ?></p>
			</div>
			<div class="post-footer">
				<div class="actions">
					<a class="opinions-counter" data-post-id="<?php echo $info['id'] ?>"><?php echo empty($info['likes']) ? "0" : $info['likes'] ?>/<?php echo empty($info['dislikes']) ? "0" : $info['dislikes'] ?></a>
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
					<?php /*<a href="javascript:;" class="share-btn pbtn pbtn-white active">
						<i class="fa fa-comment"></i>
						Reply
					</a>*/ ?>
				</div>
			</div>
		</div>
	</div>