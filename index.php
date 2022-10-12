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

$first_day = mktime(0, 0, 0, 9, 12, 2022); //$hour, $minute, $second, $month, $day, $year
$last_day = mktime(0, 0, 0, 6, 10, 2023); //$hour, $minute, $second, $month, $day, $year

$percent = 100*($now-$first_day)/($last_day-$first_day);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test</title>
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

		Début d'année : <b><?= date("d/m/Y", $first_day) ?></b><br>
		Date actuelle : <b><?= date("d/m/Y", $now) ?></b><br>
		Fin d'année : <b><?= date("d/m/Y", $last_day) ?></b><br>
		Vous en êtes à <b><?= round($percent, 2) ?>%</b> de la MIC, félicitation !<br><br>

		<div class="bar">
			<div class="percentage has-tip"  style="width: <?= $percent ?>%" data-perc="50%"></div>
		</div>

		<br><br>

		<a href="?logout=">Se déconnecter</a><br><br>
	</main>
	
	<?php
	//var_dump(phpCAS::getAttributes()); 
	/*$memberOfCN = phpCAS::getAttributes()["memberOfCN"];

	foreach($memberOfCN as $i) {
		if(strpos($i, "sve_2_mic") !== FALSE) {
			echo "<b><font color='red'>Tu est en 2MIC : ".$i."</font><br></b>";
		}
	}*/
	?><br>
</body>
</html>