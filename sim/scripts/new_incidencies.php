<?php
include ("config.php");
include ("auxiliar/functions.php");
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sqli = "select * from sgm_incidencias where data_prevision > 1400000000 or pausada=1";
	$resulti = mysql_query(convert_sql($sqli));
	while ($rowi = mysql_fetch_array($resulti)){
		$sqlii = "update sgm_incidencias set ";
		$sqlii = $sqlii."data_prevision=0";
		$sqlii = $sqlii." WHERE id=".$rowi["id"]."";
		mysql_query(convert_sql($sqlii));
		echo $sqlii."<br>";
	}
	$sqle = "select * from sgm_incidencias where id_entrada=5";
	$resulte = mysql_query(convert_sql($sqle));
	while ($rowe = mysql_fetch_array($resulte)){
		$sqlie = "update sgm_incidencias set ";
		$sqlie = $sqlie."id_entrada=0";
		$sqlie = $sqlie." WHERE id=".$rowe["id"]."";
		mysql_query(convert_sql($sqlie));
		echo $sqlie."<br>";
	}

	$sqli = "select * from sgm_incidencias where visible=1";
	$resulti = mysql_query(convert_sql($sqli));
	while ($rowi = mysql_fetch_array($resulti)){
		$temps_transcorregut = 0;
		$temps_pendent = 0;
		$sqlip = "select * from sgm_incidencias_pausa where id_incidencia=".$rowi["id"]." and data_reanudacion is NULL";
		$resultip = mysql_query(convert_sql($sqlip));
		$rowip = mysql_fetch_array($resultip);
		$sqlc = "select * from sgm_contratos_servicio where id=".$rowi["id_servicio"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		if (($rowc["temps_resposta"] > 0) and $rowip){
			$temps_pendent = $rowip["sla_restante"];
			$temps_transcorregut = ($rowc["temps_resposta"]*3600) - $temps_pendent;
		}
		$sqlii = "update sgm_incidencias set ";
		$sqlii = $sqlii."fecha_prevision=".$rowi["data_prevision"]."";
		$sqlii = $sqlii.",fecha_inicio=".$rowi["data_registro2"]."";
		$sqlii = $sqlii.",fecha_registro_inicio=".$rowi["data_insert2"]."";
		$sqlii = $sqlii.",fecha_registro_cierre=".$rowi["data_finalizacion2"]."";
		$sqlii = $sqlii.",id_usuario_registro=".$rowi["id_usuario"]."";
		$sqlii = $sqlii.",temps_transcorregut=".$temps_transcorregut;
		$sqlii = $sqlii.",temps_pendent=".$temps_pendent;
		$sqlii = $sqlii." WHERE id=".$rowi["id"]." and id_incidencia=0";
		mysql_query(convert_sql($sqlii));
		echo $sqlii."<br>";
	}

	$sqlin = "select * from sgm_incidencias_notas_desarrollo";
	$resultin = mysql_query(convert_sql($sqlin));
	while ($rowin = mysql_fetch_array($resultin)){
		$sql = "insert into sgm_incidencias (id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,duracion,visible_cliente,pausada)";
		$sql = $sql."values (";
		$sql = $sql."".$rowin["id_incidencia"]."";
		$sql = $sql.",".$rowin["id_usuario"]."";
		$sql = $sql.",".$rowin["data_insert2"]."";
		$sql = $sql.",".$rowin["data_registro2"]."";
		$sql = $sql.",'".comillas($rowin["notas"])."'";
		$sql = $sql.",".$rowin["tiempo"]."";
		$sql = $sql.",".$rowin["visible_cliente"]."";
		$sql = $sql.",".$rowin["pausada"]."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		echo $sql."<br>";
	}


?>