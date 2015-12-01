<?php 

error_reporting(~E_ALL);

if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}
if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			if ($row["pass"] == $_POST["pass"]) {
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, "/");
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
				header("Location: ".$urloriginal."/index.php?op=200");
			}
		}
	}
}
else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["pass"] == $_COOKIE["mpassword"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, "/");
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
		}
	}
}



?>
<html>
<head>
		<link rel="stylesheet" href="style.css" type="text/css">
<STYLE>
<?php 
if 	(ereg("MSIE", $_SERVER['HTTP_USER_AGENT'])) {
		echo ".saltopagina {";
		echo "PAGE-BREAK-AFTER: always;";
		echo "height:0px; line-height:0px;";
		echo "}";
} else {
		echo ".saltopagina {";
		echo "PAGE-BREAK-AFTER: always;";
		echo "}";
}
?>
</STYLE>
</head>
<body>
<?php 

$autorizado = false;
if ($user == true) {

		$sqli = "select * from sgm_incidencias where id=".$_GET["id"];
		$resulti = mysql_query(convertSQL($sqli));
		$rowi = mysql_fetch_array($resulti);

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convertSQL($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }


		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowi["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysql_query(convertSQL($sqlpermiso));
		$rowpermiso = mysql_fetch_array($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }

}
if ($autorizado == true) {
	if ($_POST["carta"] != "") {
		$sql = "select * from sgm_cartas where id=".$_POST["carta"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$clients = $_POST["clients"];
		for ($i = 0; $i < strlen($clients) ; $i++){
			while ($clients[$i] != ","){
				$clientes = $clientes.$clients[$i];
				$i++;
			}
				echo ver_carta($row["cuerpo"],$clientes,1);
				echo "<br class=\"saltopagina\" />";
				$clientes = "";
		}
		$contacts = $_POST["contactes"];
		for ($i = 0; $i < strlen($contacts) ; $i++){
			while ($contacts[$i] != ","){
				$contact = $contact.$contacts[$i];
				$i++;
			}
				echo ver_carta($row["cuerpo"],$contact,2);
				echo "<br class=\"saltopagina\" />";
				$contact = "";
		}
	} else {
		echo ver_carta($_POST["message"],0,0);
	}
}

?>


</body>
</html>
