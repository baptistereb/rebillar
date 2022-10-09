<?php

//CAS
require_once("phpCAS-1.3.6/CAS.php");
phpCAS::client(CAS_VERSION_2_0, "cas.insa-toulouse.fr", 443, 'cas', true);
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();
if (isset($_REQUEST['logout'])) {
        phpCAS::logout();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test</title>
</head>
<body>
	Cette page pour le moment ne sert qu'a faire des tests 

	<a href="?logout=">Se déconnecter</a><br><br>
	<?php var_dump(phpCAS::getAttributes()); ?><br><br><br>
	<?php
	$memberOfCN = phpCAS::getAttributes()["memberOfCN"];

	foreach($memberOfCN as $i) {
		if(strpos($i, "sve_2_mic") !== FALSE) {
			echo "<b><font color='red'>Tu est en 2MIC : ".$i."</font><br></b>";
		} elseif(strpos($i, "sve") !== FALSE) {
			echo "<b><font color='red'>".$i."</font></b>";
		} else {
			echo "<font color='red'>".$i."</font><br>";
		}
	}
	?><br>
</body>
</html>