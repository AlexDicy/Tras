<?php
$info = mysqli_fetch_array(Shared::get("content"));
if ($info) {
    if ($info["nick"] != Shared::get("path")[1]) echo "<script> window.location.replace(\"https://tras.pw/post/".$info["nick"]."/".Shared::get("path")[2]."\"); </script>";
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