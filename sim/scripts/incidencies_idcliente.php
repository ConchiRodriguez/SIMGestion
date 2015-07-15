<?php
include ("config.php");
include ("auxiliar/functions.php");
include ("../funciones.php");
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sqld = "select * from sgm_incidencias where id_cliente=0 and visible=1 and id_incidencia=0";
	$resultd = mysql_query(convert_sql($sqld));
	while ($rowd = mysql_fetch_array($resultd)){
		$sqlc = "select * from sgm_contratos_servicio where id=".$rowd["id_servicio"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlco = "select * from sgm_contratos where id=".$rowc["id_contrato"];
		$resultco = mysql_query(convert_sql($sqlco));
		$rowco = mysql_fetch_array($resultco);
		$sqlf = "update sgm_incidencias set ";
		$sqlf = $sqlf."id_cliente=".$rowco["id_cliente"];
		$sqlf = $sqlf." WHERE id=".$rowd["id"]."";
		mysql_query(convert_sql($sqlf));
echo $sqlf."<br>";
	}



?>