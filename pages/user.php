<?php
$nick = escape(Shared::get("path")[1]);
$userid = empty($_SESSION['info']['id']) ? 0 : $_SESSION['info']['id'];
$sql = query("SELECT id, Avatar, verified FROM Members WHERE Nick = '$nick'");
$queryid = mysqli_fetch_array($sql)
?>
<div class="clearfix">
    <h3 class="pull-left" style="margin: -16px 0 8px 0;"><a href="/user/<?php echo $nick ?>"><?php echo $nick ?><?php if ($queryid['verified'] == 1) { ?><a> <i class="fa fa-check-circle" style="color: #43a8eb;"></i></a><?php } ?></a></h3>
    <img class="pull-right mb center-block img-circle img-responsive thumb128" src="<?php echo $queryid['Avatar'] ?>">
<?php
if (isLoggedIn() && $nick != $_SESSION['info']['Nick']) {
    if (in_array($queryid['id'], Shared::get("friendslist"))) $class = "btn-danger fa fa-minus isfriend";
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
$empty = true;
$result = Shared::get("get")['posts']->getUserPosts($queryid['id']);
while ($info = mysqli_fetch_array($result)) {
    $empty = false;
    include('template/post.php');
}
if ($empty) {
    echo "<p>No posts from this user</p>";
} else {
    $userpage = true;
    include('template/loadmore-btn.php');
}
?>
</div>
<?php include("template/right-sidebar.php"); ?>