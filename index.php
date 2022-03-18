<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Goodbye</title>
		<style type="text/css">
			body {
				color: #222;
				background: #999;
				font-family: Arial;
			}

			@media (prefers-color-scheme: dark) {
				body {
					color: #f5f5f5;
					background: #222;
					font-family: Arial;
				}
			}
		</style>
	</head>
	<body>
		<header>
			<h1>💥Goodbye, World!</h1>
			<b>
				<?php
					require __DIR__ . "/auth.php";
					define("PLAIN_PATH", "PATH TO LOG FILE");
					define("SHELL_COMMAND", "COMMAND TO EXECUTE");
					$authstatus = "unauthorized";
					$authok = false;
					$key = "";
					$username = "Unknown";
					if (isset($_GET['key'])) {
						$key = $_GET['key'];
						$authstatus = "query key invalid";
					}
					else if (isset($_COOKIE['key'])) {
						$key = $_COOKIE['key'];
						$authstatus = "cookie key invalid";
					}
					if (isset($key) && keyvalid($key)) {
						$authok = true;
						$username = getusername($key);
						if ($authstatus == "query key invalid") {
							$authstatus = "authorized via query key as " . $username;
							setcookie("key", $key);
						} else {
							$authstatus = "authorized via cookie key as " . $username;
						}
					}
					if (isset($_POST["message"])) {
						$msg = $_POST["message"];
						if(keyvalid($key)) {
							$msgfrmt = "<p><b>" . date("m.d H:i") . " by " . $username . ":</b><br>" . $msg . "</p>\n";
							$f = fopen(PLAIN_PATH, 'a');
							flock($f, LOCK_EX);
							fwrite($f, $msgfrmt);
							flock($f, LOCK_UN);
							fclose($f);
							shell_exec(SHELL_COMMAND);
						}
						header("Refresh:0");
					}
					echo("Last updated: " . date("H:i") . " • Auth status: " . $authstatus);
				?>
				<br>
			</b>
			<br>
		</header>

		<?php
		if ($authok) {
			echo("
					<form method='post'>
						Message: <input type='text' name='message' maxlength=2000 size=100 placeholder='<2000 chars' required><br>
						<input type='submit' value='Submit'>
					</form>
					<hr/>
				");
			$content = file_get_contents(PLAIN_PATH);
			echo($content);
		} else {
			echo("
					<form method='get'> 
						Key: <input type='text' name='key' maxlength=100 size=100 required><br>
						<input type='submit' value='Submit'>
					</form>
					<hr/>
				");
		}
		
		?>

		<footer>
			<hr/>
			<i>
				How can I save my little boy<br>
				From Oppenheimer's deadly toy?<br>
				There is no monopoly of common sense<br>
				On either side of the political fence<br>
			</i>
		</footer>
	<body>
<html>
