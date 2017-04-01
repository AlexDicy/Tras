<?php
if ($_SESSION['info']['rank'] !== 48) exit("Why are you here?");
?>
<h4>Welcome, <?= $_SESSION['info']['Nick'] ?></h4>