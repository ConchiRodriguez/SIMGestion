<?php
error_reporting(~E_ALL);


function admin($userid,$option)
{ 
	global $db;
	$admin = false;
		$sql = "select count(*) as total from sgm_users_permisos WHERE id_user=".$userid." AND id_tipus=0 AND id_modulo=".$option;
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { 
			$sqladmin = "select * from sgm_users_permisos WHERE id_user=".$userid." AND id_modulo=".$option;
			$resultadmin = mysql_query(convertSQL($sqladmin));
			$rowadmin = mysql_fetch_array($resultadmin);
				if ($rowadmin["admin"] == 1) { 
					$admin = true;
				}
		}
	return $admin; 
}

?>