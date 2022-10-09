<?php
//CAS
require_once("phpCAS-1.3.6/CAS.php");

// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, "cas.insa-toulouse.fr", 443, 'cas', true);

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
phpCAS::setNoCasServerValidation();

// force CAS authentication
phpCAS::forceAuthentication();

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().

// logout if desired
if (isset($_REQUEST['logout'])) {
        phpCAS::logout();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>test</title>
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