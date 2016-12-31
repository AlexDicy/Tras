<div class="posts-col col-md-6">
	<div class="alert alert-warning" style="display: none" id="new-post-error"><strong>Error</strong> There was an error while posting, please try again.</div>
	<div class="post post-margin-bottom">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject">New post</span>
				</div>
			</div>
			<div class="portlet-body">
				<textarea class="form-control autosize vresize" placeholder="Write a new post" rows="2" id="new-post"></textarea>
			</div>
			<div class="post-footer">
				<div class="actions">
					<a href="#" id="new-post-button" class="post-btn pbtn pbtn-blue active">Post</a>
				</div>
			</div>
		</div>
	</div>
<?php
$userid = $_SESSION['info']['id'];
$postfromids = empty($friendslist) ? $userid : "$userid, ".implode(', ', $friendslist);
$posts = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $userid) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user IN ($postfromids) ORDER BY Posts.id DESC LIMIT 30");
while ($info = mysqli_fetch_array($posts)) {
	include('template/post.php');
}
	include('template/loadmore-btn.php');
?>
</div>
<?php include('template/right-sidebar.php'); ?>
<script>
/*toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": true,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "2000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
toastr["info"]("Welcome back", "<?php echo $nickname ?>")*/
</script>
