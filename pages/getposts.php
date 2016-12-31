<?php
if (isset($_POST['page']) && isLoggedIn()) {
    $page = 20 + $_POST['page'] * 10;
    $userid = $_SESSION['info']['id'];
    $postfromids = empty($friendslist) ? $userid : "$userid, ".implode(', ', $friendslist);
    if (isset($_POST['user']) && !empty($_POST['user'])) {
        $from = "= '".escape($_POST['user'])."'";
    } else {
        $from = "IN ($postfromids)";
    }
    $postsquery = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $userid) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user $from ORDER BY Posts.id DESC LIMIT $page, 10");
    //$text = "SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $userid) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user $from ORDER BY Posts.id DESC LIMIT $page, 10";
    while ($info = mysqli_fetch_array($postsquery)) {
        include 'template/post.php';
    }
    //file_put_contents('./log_'.date("j.n.Y").'.txt', $text."   --- %% $from %% ---   ".PHP_EOL, FILE_APPEND);
} else {
?>
{"CODE": 300}
<?php
}
?>