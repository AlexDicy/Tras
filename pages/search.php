<?php
if (isset($_GET["query"])){
    $query = escape($_GET["query"]);
    $sql = query("SELECT 0 AS id, 0 AS content, Members.nick, Members.verified, Members.avatar, 0 AS date FROM Members WHERE Members.nick LIKE '%$query%' LIMIT 30
                  UNION
                  SELECT Posts.id, Posts.content, Members.nick, Members.verified, Members.avatar, Posts.date FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.content LIKE '%$query%' LIMIT 30
    ");
    while ($info = mysqli_fetch_array($sql)) {
        $post = $info["id"] != 0;
?>
        <a href="/<?= !$post ? "user/".$info["nick"] : "post/".$info["nick"]."/".$info["id"] ?>">
            <div id="panelPortlet4" class="panel panel-default b0">
                <div class="row row-table row-flush">
                    <div class="col-xs-2 bg-primary">
                        <img class="sidebar-avatar center-block thumb64" src="<?php echo $info['avatar'] ?>" alt="<?= $info["nick"] ?> Avatar image"/>
                    </div>
                    <div class="col-xs-10">
                        <div class="panel-body">
                            <span class="caption-subject"><?= $info["nick"]." ".Shared::getVerifiedBadge($info["verified"], false) ?></span><?php if ($post) echo "<span class=\"caption-helper\"><small>" . Shared::elapsedTime($info["date"]) . "</small></span>" ?>
                            <p class="mb0 text-muted"><?php if ($post) echo Shared::removeFormatting($info["content"]) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
<?php
    }
} else {
    echo  "<p>Please enter a search query</p>";
}
?>