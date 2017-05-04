<?php
if(isset($_POST['search'])){
    $name = escape($_POST['search']);
    $sql = query("SELECT id, nick FROM Members WHERE nick LIKE '%" . $name .  "%' LIMIT 30");
    while($info = mysqli_fetch_array($sql)){
?>
        <a href="/user/<?php echo $info['nick'] ?>">
            <div id="panelPortlet4" class="panel panel-default b0">
                <div class="row row-table row-flush">
                    <div class="col-xs-4 bg-danger text-center">
                        <em class="fa fa-user fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                        <div class="panel-body text-center">
                            <h4 class="mt0"><?php echo $info['nick'] ?></h4>
                            <p class="mb0 text-muted"><?php echo $info['id'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
<?php
    }
$sql = query("SELECT Posts.id, Members.nick, Posts.content FROM Posts JOIN Members ON Posts.user = Members.id WHERE content LIKE '%" . $name .  "%' LIMIT 30");
    while($info = mysqli_fetch_array($sql)){
?>
        <a href="/post/<?php echo $info['nick']."/".$info['id'] ?>">
            <div id="panelPortlet4" class="panel panel-default b0">
                <div class="row row-table row-flush">
                    <div class="col-xs-4 bg-inverse text-center">
                        <em class="fa fa-file-text fa-2x"></em>
                    </div>
                    <div class="col-xs-8">
                        <div class="panel-body text-center">
                            <h4 class="mt0"><?php echo $info['nick'] ?></h4>
                            <p class="mb0 text-muted"><?php echo $info['content'] ?></p>
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