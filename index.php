<?php
$file = fopen('.env', 'rb');
$env = fread($file, filesize('.env'));
fclose($file);

if($env == "LOCAL") {
	echo "Tu est en LOCAAAAL<br><br>";
} else {
	//on importe le CAS
	require_once("phpCAS-1.3.6/CAS.php");
	phpCAS::client(CAS_VERSION_2_0, "cas.insa-toulouse.fr", 443, 'cas', true);
	phpCAS::setNoCasServerValidation();
	phpCAS::forceAuthentication();
	if (isset($_REQUEST['logout'])) {
		phpCAS::logout();
	}
}

$now = strtotime("now");

$first_day = mktime(11, 0, 0, 9, 22, 2025); //$hour, $minute, $second, $month, $day, $year
$last_day = mktime(14, 15, 0, 1, 27, 2026); //$hour, $minute, $second, $month, $day, $year

$percent = 100*($now-$first_day)/($last_day-$first_day);

include "bouton.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LES MIC !!!!!</title>
	<style>
		.bar {
			width: 30em;
			height: 1em;
			border-radius: 0.5em;
			position: relative;
			background: #f2f2f2;
			box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
		}
		.bar .percentage {
		    position: relative;
		    font-size: 1em;
		    background: tomato;
		    height: 1em;
		    border-radius: 0.5em;
		  }
	</style>
</head>
<body>
	<main>

		Début d'année : <b><?= date("d/m/Y H:i:s", $first_day) ?></b><br>
		Date actuelle : <b><?= date("d/m/Y H:i:s", $now) ?></b><br>
		Fin d'année : <b><?= date("d/m/Y H:i:s", $last_day) ?></b><br>

		<?php
		if($env != "LOCAL") {
			$memberOfCN = phpCAS::getAttributes()["memberOfCN"];
			echo "Vous en êtes à <b>".round($percent, 2)."%</b> de la 5TLS-SEC, félicitations !<br><br>";

			/*foreach($memberOfCN as $i) {
				if(strpos($i, "sve_2_mic") != FALSE) {
					echo "Vous en êtes à <b>".round($percent, 2)."%</b> de la MIC, félicitations !<br><br>";
				} else {
					echo "Vous en êtes à <b>".round($percent, 2)."%</b> de l'année, félicitations ! (Vous n'êtes pas en MIC donc la date de fin d'année ... je ne la connais pas)<br><br>";
				}
			}*/
		}
		?>

		<div class="bar">
			<div class="percentage has-tip"  style="width: <?= $percent ?>%" data-perc="50%"></div>
		</div>

		<br><br>

		<?php  Button("En attendant si tu veux mes fiches", "ptites_fiches"); ?>

		<br><br>

		<?php  Button("Se déconnecter", "?logout="); ?>
	</main>
</body>
</html>
