<?php
error_reporting(~E_ALL);


function deleteFunction ($tabla,$id){
	$sql = "delete from ".$tabla." WHERE id=".$id;
	mysql_query(convertSQL($sql));
#	echo $sql;
}

?>