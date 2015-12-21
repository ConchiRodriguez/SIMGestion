<?php
error_reporting(~E_ALL);


function insertFunction ($tabla,$camposInsert,$datosInsert){
	$sql = "insert into ".$tabla." (".$camposInsert.")";
	$sql = $sql."values (";
	for ($i=0;$i<=(count($datosInsert)-1);$i++){
		if ($i == 0) {
			$sql = $sql."";
		} else {
			$sql = $sql.",";
		}
		$sql = $sql."'".comillas($datosInsert[$i])."'";
	}
	$sql = $sql.")";
	mysql_query(convertSQL($sql));
#	echo $sql;
}

?>