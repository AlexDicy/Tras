<?php
echo '<pre>';
echo shell_exec("git pull 2>&1");
echo '</pre>';
?>