<?php
error_reporting(~E_ALL);

function buscarCodigoServicioEmail($asun,$id_cli){
	global $db,$dbhandle;

	$x = 0;
	$data = time();

	//buscar en el asunto el id de alguna incidencia abierta
	$sqlcs = "select id from sgm_contratos_servicio where visible=1";
	if ($id_cli > 0) { $sqlcs .= " and id_contrato in (select id from sgm_contratos where id_cliente=".$id_cli.")"; }
	$resultcs = mysqli_query($dbhandle,$sqlcs);
	while ($rowcs = mysqli_fetch_array($resultcs)){
		if (strpos($asun,$rowcs["codigo_catalogo"]) != false){
			$x++;
			$id_serv = $rowcs["id"];
		}
	}
	return $id_serv;
}

?>