<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Goodbye</title>
		<link rel="icon" href="boom.png" type="image/png">
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
				a {
					color: #ff7f49;
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
					define("PLAIN_PATH", "/var/www/foxhole_messages/PLAIN.html");
					define("VERSION", "0.2.0");
					$authstatus = "unauthorized";
					$authok = false;
					$key = "";
					$username = "Unknown";
					if (isset($_POST['key'])) {
						$key = $_POST['key'];
						$authstatus = "POST key invalid";
					}
					else if (isset($_COOKIE['key'])) {
						$key = $_COOKIE['key'];
						$authstatus = "cookie key invalid";
					}
					else if (isset($_GET['key'])) {
						$key = $_GET['key'];
						$authstatus = "GET key invalid";
					}
					if (isset($key) && keyvalid($key)) {
						$authok = true;
						$logoutprompt = " • <a href='auth.php?deauth'>Deauthorize</a>";
						$username = getusername($key);
						if ($authstatus == "POST key invalid") {
							$authstatus = "authorized via POST key as " . $username;
							setcookie("key", $key);
							header("Refresh:0");
						}
						else if ($authstatus == "GET key invalid") {
							$authstatus = "authorized via GET key as " . $username;
							setcookie("key", $key);
						} else {
							$authstatus = "authorized via cookie key as " . $username . $logoutprompt;
						}
					}
					
					echo("Version: " . VERSION . " • Last updated: " . date("H.i") . " • Auth status: " . $authstatus);
				?>
				<br>
			</b>
			<br>
		</header>

		<?php
		if ($authok) {
			echo("
					<form action='message.php' method='post' enctype='multipart/form-data'>
						<input type='hidden' name='key' value='" . $key . "' />
						Message: <input type='text' name='message' maxlength=2000 size=100 placeholder='<2000 chars' required>
						<input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
						<input type='file' name='attachment'><br>
						<input type='submit' value='Send'>
					</form>
					<hr>
				");
			$content = file_get_contents(PLAIN_PATH);
			echo($content);
		} else {
			echo("
					<form method='post'> 
						Key: <input type='text' name='key' maxlength=100 size=100 required><br>
						<input type='submit' value='Submit'>
					</form>
					<hr>
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
