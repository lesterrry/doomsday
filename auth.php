<?php
function keyvalid($key) {
	$csvfile = file('/var/www/api_core/foxhole_keys.csv');
	$data = [];
	foreach ($csvfile as $line)
	{
			$data[] = str_getcsv($line);
	}

	foreach ($data[0] as $point)
	{
		if ($key === $point)
		{
			return true;
		}
	}
	return false;
}
function getusername($key) {
	$arr = explode(':', $key);
	return $arr[0];
}
if (isset($_GET['deauth'])) {
	setcookie("key", "", 1);
	header("Location:index.php");
	exit();
}