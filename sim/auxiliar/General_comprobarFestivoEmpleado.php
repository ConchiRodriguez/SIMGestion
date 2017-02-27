<?php
error_reporting(~E_ALL);


function comprobarFestivoEmpleado($fecha,$id_user)
{
	global $db,$dbhandle;
	$festivo=0;
	$sqle = "select * from sgm_rrhh_empleado_calendario where ((data_ini=".$fecha.") or ((".$fecha." >= data_ini) and (".$fecha." <= data_fi))) and id_empleado=(select id from sgm_rrhh_empleado where id_usuario=".$id_user.")";
	$resulte = mysqli_query($dbhandle,convertSQL($sqle));
	$rowe = mysqli_fetch_array($resulte);
	if ($rowe){
		$festivo=1;
	}
#	echo $festivo."<br>";
	return $festivo;
}

?>