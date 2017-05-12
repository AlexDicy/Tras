<?php
$userid = empty( Shared::$USERDATA['info']['id']) ? 0 :  Shared::$USERDATA['info']['id'];
$queryid = Shared::get("content");
$nick = $queryid['nick'];
?>
<div class="clearfix">
    <h3 class="pull-left" style="margin: -16px 0 8px 0;"><a href="/user/<?php echo $nick ?>"><?php echo $nick ?><?php if ($queryid['verified'] == 1) { ?><a> <i class="fa fa-check-circle" style="color: #42A5F5;"></i></a><?php } else if ($queryid['verified'] == 2) { ?><a> <i class="fa fa-check-circle" style="color: #4CAF50;"></i></a><?php } ?></a></h3>
    <img class="pull-right mb center-block img-circle img-responsive thumb128" src="<?php echo $queryid['avatar'] ?>">
<?php
if (isLoggedIn() && $nick !=  Shared::$USERDATA['info']['nick']) {
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