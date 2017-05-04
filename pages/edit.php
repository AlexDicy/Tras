<?php
$id = escape(Shared::get("path")[1]);
$userid = $USERDATA['info']['id'];
$post = query("SELECT Posts.id, Posts.content, Members.nick, Members.id as user_id FROM Posts JOIN Members ON Members.id = Posts.user WHERE Posts.id = '$id' AND Posts.user = '$userid'");
$info = mysqli_fetch_array($post);
?>
<div class="alert alert-warning" style="display: none" id="edit-post-error"><strong>Error</strong> There was an error while editing, please try again.</div>
<div class="post post-margin-bottom">
	<?php if ($userid == $info['user_id']) { ?>
	<div class="portlet full-margin-bottom">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject">Edit your post</span>
			</div>
		</div>
		<div class="portlet-body">
			<textarea class="form-control autosize vresize" placeholder="Post cannot be empty" rows="2" id="edit-post"><?php echo $info['content'] ?></textarea>
		</div>
		<div class="post-footer">
			<div class="actions">
				<a href="#" id="edit-post-button" data-post-id="<?php echo $id ?>" data-post-user="<?php echo $info['nick'] ?>" class="post-btn pbtn pbtn-blue active">Edit</a>
			</div>
		</div>
	</div>
	<?php } else { ?>
		<div class="alert alert-warning"><strong>Error</strong> You do not own this post, therefore you cannot edit it.</div>
	<?php } ?>
</div>