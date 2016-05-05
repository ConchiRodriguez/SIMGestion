<?php
error_reporting(~E_ALL);

function buscarCodigoExternoIncidencia($id_servicio_con,$id_cli){
	global $db,$dbhandle;

	$sqlcs = "select funcion from sgm_contratos_servicio where visible=1 and id=".$id_servicio_con;
	if ($id_cli > 0) { $sqlcs .= " and id_contrato in (select id from sgm_contratos where id_cliente=".$id_cli.")"; }
	$resultcs = mysqli_query($dbhandle,$sqlcs);
	$rowcs = mysqli_fetch_array($resultcs);
	
	$codigo_externo = call_user_func($rowcs["funcion"]);
	
	return $codigo_externo;
}

?>