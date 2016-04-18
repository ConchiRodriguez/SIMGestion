<?php
error_reporting(~E_ALL);

function buscarCodigoIncidenciaEmail($asun,$id_cli){
	global $db,$dbhandle;

	$x = 0;
	$data = time();

	//buscar en el asunto el id de alguna incidencia abierta
	$sqlinc = "select id from sgm_incidencias where visible=1 and id_estado<>-2";
	if ($id_cli > 0) { $sqlinc .= " and id_cliente=".$id_cli; }
	$resultinc = mysqli_query($dbhandle,$sqlinc);
	while ($rowinc = mysqli_fetch_array($resultinc)){
		if (strpos($asun,$rowinc["id"]) != false){
			$x++;
			$id_inc = $rowinc["id"];
		}
	}
	return $id_inc;
}

?>