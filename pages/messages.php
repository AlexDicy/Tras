<?php
$sql;
$userid = $_SESSION['info']['id'];
$home = false;
if (isset(Shared::get("path")[1]) && isset(Shared::get("path")[2]) && Shared::get("path")[1] == "chat") {
    $chat = escape(Shared::get("path")[1]);
    $sql = query("SELECT `Messages.id` as id, `Messages.user` as user, `Messages.chat_id` as chat_id, `Messages.content` as content, `Messages.post_date` as post_date, `Members.Avatar` as avatar FROM `Messages` JOIN `Members` ON  WHERE `Messages.chat_id` = '$chat'");
} else {
    $home = true;
    $sql = query("SELECT Chats.id, Chats.user_1, Chats.user_2, Members.Avatar FROM Chats WHERE user_1 = '$userid' OR user_2 = '$userid'");
}
$previousId = 0;
if ($home) {
    if (mysqli_num_rows($sql) > 0) {
        while ($info = mysqli_fetch_array($sql)) {
            include('template/messagerow.php');
        }
    } else {
        echo "<p>Start a new chat</p>";
    }
} else {

}
?>
<?php include("template/right-sidebar.php"); ?>

<div class="table-container">
	<table class="table table-filter">
		<tbody>
			<tr>
				<td>
					<div class="media">
						<a href="#" class="pull-left">
							<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo">
						</a>
						<div class="media-body">
							<span class="media-meta pull-right">Febrero 13, 2016</span>
							<h4 class="title">
								Lorem Impsum
								<span class="pull-right pagado">(Pagado)</span>
							</h4>
							<p class="summary">Ut enim ad minim veniam, quis nostrud exercitation...</p>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>