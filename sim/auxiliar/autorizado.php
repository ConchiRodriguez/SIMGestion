<?php
error_reporting(~E_ALL);


function autorizado($userid,$option)
{ 
	global $db;
	$autorizado = false;
		$sql = "select count(*) as total from sgm_users_permisos WHERE id_user=".$userid." AND id_tipus=0 AND id_modulo=".$option;
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { 
			$autorizado = true;
		}
	return $autorizado; 
}

?>