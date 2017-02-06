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
while ($info = mysqli_fetch_array(Shared::get("get")['posts']->getHomePosts())) {
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
toastr["info"]("Welcome back", "")*/
</script>
