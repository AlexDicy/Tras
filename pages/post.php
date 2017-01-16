<?php
if(isset($path)){
    $id = escape($path[2]);
    $info = mysqli_fetch_array($get['posts']->getPost($id));
?>
<div class="posts-col col-md-6">
<?php
    include('template/post.php');
?>
</div>
<?php
    include('template/right-sidebar.php');
} else {
    echo  "<p>Please enter a search query</p>";
}
?>