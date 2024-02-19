<?php
require("../../../lang/lang.php");

$strings = tr();

?>
<html lang="en-US">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $strings['title'] ?></title>
	<link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div class="row pt-5 mt-2" style="margin-left: 390px">
			<h2><?= $strings['title'] ?></h2>
		</div>
		<div class="row pt-3 mt-2">
			<form method="POST">
				<input class="form-control" type="text" name="ip" aria-label="ip" style="margin-top: 30px; margin-left: 400px; width: 500px; ">
				<button type="submit" class="btn btn-primary" style="margin-top: 30px; margin-left: 400px; width: 500px;">Ping</button>
			</form>
		</div>
		<div class="row pt-5 mt-2" style="margin-left: 400px">
			<?php
			// Comprova si s'ha enviat la IP
			if (isset($_POST["ip"])) {
				// Utilitza "strip_tags" per prevenir possibles atacs XSS
				$input = strip_tags($_POST["ip"]);

				// Llista de paraules prohibides
				$blacklists = array("ls", "cat", "less", "tail", "more", "whoami", "pwd", "echo", "ps");
				$arraySize = count($blacklists);
				$status = 0;

				// Comprova si la IP no conté paraules prohibides
				foreach ($blacklists as $blacklist) {
					if (!stristr($input, $blacklist)) {
						$status++;
					}
				}

				// Si la IP és vàlida, executa el ping
				if ($arraySize == $status) {
					// Utilitza "escapeshellarg" per evitar la injecció de comandes
					exec("ping -n 3 " . escapeshellarg($input), $out);

					if (!empty($out)) {
						// Mostra la resposta del ping
						echo '<div class="alert alert-primary" role="alert" style="width:500px;" > <strong>  <p style="text-align:center;">';
						foreach ($out as $line) {
							// Utilitza "htmlentities" per prevenir possibles atacs XSS
							echo htmlentities($line);
							echo "<br>";
						}
						echo ' </p></strong></div>';
					}
				} else {
					// Mostra un missatge d'error si la IP conté paraules prohibides
					echo '<div class="alert alert-danger" role="alert" style="width:500px;" > <strong>  <p style="text-align:center;">ERROR</p></strong></div>';
				}
			}
			?>
		</div>
	</div>
	<script id="VLBar" title="Title" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
