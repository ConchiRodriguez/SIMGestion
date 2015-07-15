<?php
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../config.php");
	include ("../auxiliar/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}

if ($_GET["tipo"] == 1){
	$sql = "Select * from documentos where id=".$_GET["id"];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
}

if ($_GET["tipo"] == 2){
	$sql = "Select * from sgm_cartas_adjuntos where id=".$_GET["id"];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
}

if ($_GET["tipo"] == 3){
	$sql = "Select * from sgm_logos where clase=".$_GET["clase"];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
}

	$mime = $row["tipo"];
	$imagen = $row["contenido"];
	$contenido = "Content-type:".$mime."";
	header($contenido);
	echo $imagen;


?>