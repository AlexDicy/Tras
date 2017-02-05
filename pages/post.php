<?php
$id = escape(Shared::get("path")[2]);
$info = mysqli_fetch_array(Shared::get("get")['posts']->getPost($id));
?>
<div class="posts-col col-md-6">
<?php
include('template/post.php');
?>
</div>
<?php
include('template/right-sidebar.php');
?>