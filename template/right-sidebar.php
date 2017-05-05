<div class="col-md-6">
	<div class="right-sidebar">
		<?php
		if (isLoggedIn()) {
			$userid =  Shared::$USERDATA['info']['id'];
			$notInclude = empty(Shared::get("friendslist")) ? $userid : "$userid, ".implode(', ', Shared::get("friendslist"));
			$whoToFollow = query("SELECT id, nick, avatar FROM Members WHERE confirmed = 1 AND id NOT IN ($notInclude) ORDER BY RAND() LIMIT 10");
			if (mysqli_num_rows($whoToFollow) > 0) {
		?>
		<div class="post post-margin-bottom">
			<div class="portlet" id="who-to-follow">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject">Casual users to follow</span>
					</div>
				</div>
				<div id="who-to-follow-collapse" class="portlet-body collapse in">
<?php
while ($info = mysqli_fetch_array($whoToFollow)) {
	include('template/user-badge.php');
}
?>
				</div>
				<div class="post-footer">
					<div class="actions">
						<a id="close-portlet-button" data-toggle="collapse" data-parent="#who-to-follow" href="#who-to-follow-collapse" class="post-btn pbtn pbtn-blue active">Toggle</a>
					</div>
				</div>
			</div>
		</div>
		<?php }} ?>
		<div class="post post-margin-bottom">
			<div class="portlet">
				<?php /*<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject">New post</span>
					</div>
				</div>*/?>
				<div class="portlet-body">
					<!-- Tras Right sidebar -->
					<ins class="adsbygoogle"
     					style="display:block"
     					data-ad-client="ca-pub-8086066615009128"
     					data-ad-slot="1930970495"
     					data-ad-format="auto"></ins>					
				</div>
			</div>
		</div>
	</div>
</div>