<?php

if ($accesolocal == true) {	include ("../archivos_comunes/config.php"); }
if ($accesolocal == false) { include ("../archivos_comunes/config2.php"); }

include ("../archivos_comunes/functions.php");
include ("../archivos_comunes/funciones.php");

$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sqld = "select * from sgm_cabezera";
	$resultd = mysql_query(convert_sql($sqld));
	while ($rowd = mysql_fetch_array($resultd)){
		$sqlf = "update sgm_cabezera set ";
		$sqlf = $sqlf."fecha2=".strtotime($rowd["fecha"]);
		$sqlf = $sqlf.",fecha_prevision2=".strtotime($rowd["fecha_prevision"]);
		$sqlf = $sqlf.",fecha_entrega2=".strtotime($rowd["fecha_entrega"]);
		$sqlf = $sqlf.",fecha_vencimiento2=".strtotime($rowd["fecha_vencimiento"]);
		$sqlf = $sqlf." WHERE id=".$rowd["id"]."";
		mysql_query(convert_sql($sqlf));
echo $sqlf."<br>";
	}



?>