<?php
error_reporting(~E_ALL);


function calculDataVencimientFact($id_client,$fecha_factura) 
{ 
	global $db,$dbhandle;

	$a = date("Y", strtotime($fecha_factura));
	$m = date("m", strtotime($fecha_factura));
	$d = date("d", strtotime($fecha_factura));

	$sqlc = "select * from sgm_clients where id=".$id_client;
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);

	$sqlcd = "select * from sgm_clients_dias_vencimiento where id_cliente=".$id_client." order by dia asc";
	$resultcd = mysqli_query($dbhandle,convertSQL($sqlcd));
	while ($rowcd = mysqli_fetch_array($resultcd)){
		if ($d < $rowcd["dia"]){
			$dia_mes = $rowcd["dia"];
			break;
		} 
	}
	if ($dia_mes == 0){
		$sqlcd = "select * from sgm_clients_dias_vencimiento where id_cliente=".$id_client." order by dia asc";
		$resultcd = mysqli_query($dbhandle,convertSQL($sqlcd));
		$rowcd = mysqli_fetch_array($resultcd);
		$dia_mes = $rowcd["dia"];
	}

	if ($rowc["dias"] == 1) {
		$fecha_factura2 = date("U", strtotime($fecha_factura));
		if ($rowc["dias_vencimiento"] != 0) {
			$fecha_ven = $fecha_factura2 + ($rowc["dias_vencimiento"]*24*60*60);
			$any = date("Y",$fecha_ven);
			$mes = date("m",$fecha_ven);
			$dia = date("d",$fecha_ven);
			if (($dia > $dia_mes) and ($dia_mes > 0)){ $mes = $mes+1; }
			$dia = $dia_mes;
		}
	} elseif ($rowc["dias"] == 0){
		$meses = $rowc["dias_vencimiento"];
		if ($dia_mes > 0){ $dia = $dia_mes;}
	}
	
	$fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$mes+$meses ,$dia, $any));
	
	if (date("U", strtotime($fecha_factura)) > date("U", strtotime($fecha_vencimiento))){
		$fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+30, $a));
	}

	return $fecha_vencimiento;
}

?>