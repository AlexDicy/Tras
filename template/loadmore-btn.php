<?php
if (isset($userpage) && isset($queryid) && $userpage) {
	$classes = "load-more-userpage ";
	$datauser = 'data-user="'.$queryid['id'].'" ';
} else {
	$classes = "";
	$datauser = "";
}
?>
<div class="load-more">
	<button class="load-more-btn <?php echo $classes ?>btn btn-default" autocomplete="off" <?php echo $datauser ?>data-loading-text="Loading...">Load More</button>
</div>