<?php
error_reporting(~E_ALL);


function insertFunction ($tabla,$camposInsert,$datosInsert){
	global $db,$dbhandle;
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
	mysqli_query($dbhandle,convertSQL($sql));
	echo $sql;
}

?>