<?php
$id = escape(Shared::get("path")[2]);
$info = mysqli_fetch_array(Shared::get("content"));
if ($info) {
?>
<div class="posts-col col-md-6">
<?php
    include('template/post.php');
?>
</div>
<?php
    include('template/right-sidebar.php');
} else echo "<p>Post deleted or not found</p>";
?>