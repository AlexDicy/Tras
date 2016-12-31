<?php
if(isset($path)){
    $nick = escape($path[1]);
    $userid = empty($_SESSION['info']['id']) ? 0 : $_SESSION['info']['id'];
    $sql = query("SELECT id, Avatar, verified FROM Members WHERE Nick = '$nick'");
    $queryid = mysqli_fetch_array($sql)
?>
<div class="clearfix">
    <h3 class="pull-left" style="margin: -16px 0 8px 0;"><a href="/user/<?php echo $nick ?>"><?php echo $nick ?><?php if ($queryid['verified'] == 1) { ?><a> <i class="fa fa-check-circle" style="color: #43a8eb;"></i></a><?php } ?></a></h3>
    <img class="pull-right mb center-block img-circle img-responsive thumb128" src="<?php echo $queryid['Avatar'] ?>">
<?php
        if ($nick != $_SESSION['info']['Nick']) {
        if (in_array($queryid['id'], $friendslist)) $class = "btn-danger fa fa-minus isfriend";
        else $class = "btn-primary fa fa-plus";
?>
    <a class="pull-right post-margin-bottom btn btn-add-friend <?php echo $class ?>" data-user-id="<?php echo $queryid['id'] ?>"></a>
<?php
    }
?>
    <p class="pull-right">Friends: <?php echo getFriendsCount($queryid['id']) ?></p>
</div>
<div class="posts-col col-md-6">
<?php
    $posts = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $userid) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user = '".$queryid['id']."' ORDER BY Posts.id DESC LIMIT 30");
    $empty = true;
    while ($info = mysqli_fetch_array($posts)) {
        $empty = false;
	    include('template/post.php');
    }
    if ($empty) {
        echo "<p>No posts from this user</p>";
    } else {
        $userpage = true;
        include('template/loadmore-btn.php');
    }
} else {
    echo  "<p>WTF?</p>";
}
?>
</div>
<?php include("template/right-sidebar.php"); ?>