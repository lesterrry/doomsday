<?php
if (!isset($_GET['i'])) { echo("ERR_NOARG"); exit(); }
define("PICS_FOLDER_PATH", "/var/www/foxhole_messages/pics/");
$file = PICS_FOLDER_PATH . $_GET['i'];
if (!file_exists($file)) { echo("ERR_NOFILE"); exit(); }
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);
exit();