<?php
	function keyvalid($key) {
		$csvfile = file('FILE WITH KEYS SEPARATED BY COMMA');
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
