<?php
echo '<pre>';
echo shell_exec("git pull 2>&1");
// echo shell_exec("git fetch origin master 2>&1");
// echo shell_exec("git reset --hard FETCH_HEAD 2>&1");
// echo shell_exec("git clean -df 2>&1");
echo '</pre>';
?>