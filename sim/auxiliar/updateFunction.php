<?php
error_reporting(~E_ALL);


function updateFunction ($tabla,$id,$camposUpdate,$datosUpdate){
	global $dbhandle;
	$sql = "update ".$tabla." set ";
	for ($i=0;$i<=(count($datosUpdate)-1);$i++){
		if ($i == 0) {
			$sql = $sql."";
		} else {
			$sql = $sql.",";
		}
		$sql = $sql.$camposUpdate[$i]."='".comillas($datosUpdate[$i])."'";
	}
	$sql = $sql." WHERE id=".$id."";
	mysqli_query($dbhandle,convertSQL($sql));
#	echo $sql;
}

?>