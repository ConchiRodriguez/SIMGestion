<?php
error_reporting(~E_ALL);


function autorizado($userid,$option)
{ 
	global $db,$dbhandle;
	$autorizado = false;
		$sqlu = "select count(*) as total from sgm_users_permisos WHERE id_user=".$userid." AND id_tipus=0 AND id_modulo=".$option;
		$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
		$rowu = mysqli_fetch_array($resultu);
		if ($rowu["total"] > 0) { 
			$autorizado = true;
		}
	return $autorizado; 
}

?>