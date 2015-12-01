<?php
error_reporting(~E_ALL);


function calculDataVencimientFact($id_client,$fecha_factura) 
{ 
	global $db;
	$sqlc = "select * from sgm_clients where id=".$id_client;
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);

	$a = date("Y", strtotime($fecha_factura));
	$m = date("m", strtotime($fecha_factura));
	$d = date("d", strtotime($fecha_factura));
	$fecha_factura = date("U", strtotime($fecha_factura));
	if ($rowc["dia_mes_vencimiento"] != 0) {
		$d = $rowc["dia_mes_vencimiento"];
		$fecha_ven = $fecha_factura + ($rowc["dias_vencimiento"]*24*60*60);
		$a = date("Y",$fecha_ven);
		$m = date("m",$fecha_ven);
		$dia = date("d",$fecha_ven);
		if ($dia > $d){ $m = $m+1;}
	}
	if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));}
	if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+$rowc["dias_vencimiento"] ,$d, $a));}

	return $fecha_vencimiento;
}

?>