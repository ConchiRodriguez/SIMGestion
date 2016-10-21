<?php
error_reporting(~E_ALL);


function deleteFunction ($tabla,$id){
	global $dbhandle;
	$sql = "delete from ".$tabla." WHERE id=".$id;
	mysqli_query($dbhandle,convertSQL($sql));
	echo $sql."<br>";
}

?>