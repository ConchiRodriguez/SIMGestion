<?php
error_reporting(~E_ALL);


function deleteFunction ($tabla,$id){
	$sql = "delete from ".$tabla." WHERE id=".$id;
	mysql_query(convert_sql($sql));
	echo $sql;
}

?>