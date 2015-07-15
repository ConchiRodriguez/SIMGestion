<?php
include ("../archivos_comunes/config.php");
include ("../archivos_comunes/functions.php");
include ("../archivos_comunes/funciones.php");
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sqld = "select * from sgm_incidencias where id_estado=-2 and visible=1 and id_incidencia=0";
	$resultd = mysql_query(convert_sql($sqld));
	while ($rowd = mysql_fetch_array($resultd)){
		$sqlc = "select * from sgm_contratos_servicio where id=".$rowd["id_servicio"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		if ($rowc["temps_resposta"] != 0){
			$temps_pendent=(calculSLA($rowd["id"],1));
			if ($temps_pendent > 0) { $sla = 0;} else { $sla = 1;}
		} else {
			$sla = 0;
			$temps_pendent = $rowd["temps_pendent"];
		}
		$sqlf = "update sgm_incidencias set ";
		$sqlf = $sqlf."sla=".$sla;
		$sqlf = $sqlf.",temps_pendent=".$temps_pendent;
		$sqlf = $sqlf." WHERE id=".$rowd["id"]."";
		mysql_query(convert_sql($sqlf));
echo $sqlf."<br>";
	}



?>