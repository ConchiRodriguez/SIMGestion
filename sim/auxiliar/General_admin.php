<?php
error_reporting(~E_ALL);


function admin($userid,$option)
{ 
	global $db,$dbhandle;
	$admin = false;
		$sql = "select count(*) as total from sgm_users_permisos WHERE id_user=".$userid." AND id_tipus=0 AND id_modulo=".$option;
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] != 0) { 
			$sqladmin = "select * from sgm_users_permisos WHERE id_user=".$userid." AND id_modulo=".$option;
			$resultadmin = mysqli_query($dbhandle,convertSQL($sqladmin));
			$rowadmin = mysqli_fetch_array($resultadmin);
				if ($rowadmin["admin"] == 1) { 
					$admin = true;
				}
		}
	return $admin; 
}

?>