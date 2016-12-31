<?php
if(isset($path)){
    $id = escape($path[2]);
    $userid = empty($_SESSION['info']['id']) ? 0 : $_SESSION['info']['id'];
    $sql = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $userid) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.id = '$id'");
    $info = mysqli_fetch_array($sql);
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