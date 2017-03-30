<?php
echo '<pre>';
echo shell_exec("git fetch origin master 2>&1");
echo shell_exec("git reset --hard FETCH_HEAD");
echo shell_exec("git clean -df");
echo '</pre>';
?>