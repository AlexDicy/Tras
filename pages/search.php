<?php
if (isset($_GET['query'])){
    $query = escape($_GET['query']);
    $sql = query("SELECT 0 AS id, 0 AS content, Members.nick AS nick FROM Members WHERE Members.nick LIKE '%$query%' LIMIT 30
                  UNION
                  SELECT Posts.id, Posts.content, Members.nick FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.content LIKE '%$query%' LIMIT 30
    ");
    while ($info = mysqli_fetch_array($sql)) {
?>
        <a href="/<?= $info["id"] == 0 ? "user/".$info['nick'] : "post/".$info['nick']."/".$info['id'] ?>">
            <div id="panelPortlet4" class="panel panel-default b0">
                <div class="row row-table row-flush">
                    <div class="col-xs-4 bg-inverse text-center">
                        <em class="fa fa-<?= $info["id"] == 0 ? "user" : "file-text" ?> fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                        <div class="panel-body text-center">
                            <h4 class="mt0"><?= $info['nick'] ?></h4>
                            <p class="mb0 text-muted"><?php if ($info["id"] != 0) echo Shared::removeFormatting($info['content']) ?></p>
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