<?php
include ("config.php");
include ("auxiliar/functions.php");
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sql = "select * from sgm_incidencias_notas_desarrollo";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){

		$sql = "insert into sgm_incidencias (id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,duracion,visible_cliente,pausada)";
		$sql = $sql."values (";
		$sql = $sql."".$row["id_incidencia"]."";
		$sql = $sql.",".$row["id_usuario"]."";
		$sql = $sql.",".$row["fecha_registro_inicio"]."";
		$sql = $sql.",".$row["fecha_inicio"]."";
		$sql = $sql.",'".$row["notas"]."'";
		$sql = $sql.",".$row["tiempo"]."";
		$sql = $sql.",".$row["visible_cliente"]."";
		$sql = $sql.",".$row["pausada"]."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		echo $sql;
	}


?>