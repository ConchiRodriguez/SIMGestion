<?php
error_reporting(~E_ALL);

function buscarCodigoExternoIncidencia($asunto,$id_cli,$mensaje){
	global $db,$dbhandle;

	$x = 0;
	$id_inc = 0;
	$not_sla_mango = 0;
	$rest = "";

#	$sqlcs = "select funcion from sgm_contratos_servicio where visible=1 and id=".$id_servicio_con;
#	if ($id_cli > 0) { $sqlcs .= " and id_contrato in (select id from sgm_contratos where id_cliente=".$id_cli.")"; }
#	$resultcs = mysqli_query($dbhandle,$sqlcs);
#	$rowcs = mysqli_fetch_array($resultcs);

	$codigo_externo = call_user_func("funcionMANGO",$asunto);

	if ($codigo_externo){
		$sqlinc = "select id from sgm_incidencias where visible=1 and id_estado<>-2 and id_incidencia=0 and codigo_externo='".$codigo_externo."'";
		if ($id_cli > 0) { $sqlinc .= " and id_cliente=".$id_cli; }
		$resultinc = mysqli_query($dbhandle,$sqlinc);
		$rowinc = mysqli_fetch_array($resultinc);
		if ($rowinc){
			$x++;
			$id_inc = $rowinc["id"];
		}
		$pos = strpos($mensaje,"con asunto ");
		if ($pos !== false){
			$pos2 = strpos($mensaje,"y en estado");
			$pos3=$pos+11;
			$rest = substr($mensaje, $pos3, ($pos2-$pos3));
		}
		$pos = strpos($asunto,"SLA Status ");
		if ($pos !== false){
			$not_sla_mango = 1;
		}

	}

	return array($x,$id_inc,$codigo_externo,$rest,$not_sla_mango);
}

?>