<?php
define("PLAIN_PATH", "/var/www/foxhole_messages/PLAIN.html");
define("PICS_FOLDER_PATH", "/var/www/foxhole_messages/pics/");
require __DIR__ . "/auth.php";
if (isset($_POST['message']) && isset($_POST['key'])) {
	$msg = $_POST['message'];
	$key = $_POST['key'];
	$username = getusername($key);
	$msg = strip_tags($msg);
	if(keyvalid($key)) {
		$picfrmt = "";
		if (isset($_FILES['attachment'])) {
			$filename = date("YmdHis") . "." . pathinfo($_FILES['attachment']['name'])['extension'];
			$filepath = PICS_FOLDER_PATH . $filename;
			if (move_uploaded_file($_FILES['attachment']['tmp_name'], $filepath)) {
				$picfrmt = "<br><a href='file.php?i=" . $filename . "'>Get attachment [" . $_FILES['attachment']['size'] . "B]</a>";
			}
		}
		$msgfrmt = "<p><b>" . date("H:i m.d") . " by " . $username . ":</b><br>" . $msg . $picfrmt . "</p>" . "\n";
		$f = fopen(PLAIN_PATH, 'a');
		flock($f, LOCK_EX);
		fwrite($f, $msgfrmt);
		flock($f, LOCK_UN);
		fclose($f);
	}
	header("Location:index.php");
	exit();
}