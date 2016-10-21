<?php
error_reporting(~E_ALL);


function calendari_economic($rec){
	global $db,$dbhandle;
	$mes = gmdate("n");
	$mes_anterior = date("U", mktime(0,0,0,$mes-1, 1, date("Y")));
	$mes_ultimo = date("U", mktime(0,0,0,$mes+12, 1-1, date("Y")));
	$dia_actual=$mes_anterior;
	$dia_actual1 = date("U", mktime(0,0,0,$mes-1, 1-1, date("Y")));
	if ($rec == 1) {$dia_actual=date("U", mktime(0,0,0,1,1,2012)); $dia_actual1=date("U", mktime(0,0,0,1,1-1,2012));}

	$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual1."'";
	$result = mysqli_query($dbhandle,$sql);
	$row = mysqli_fetch_array($result);
	if ($row){
		$saldo_inicial = $row["liquido"];
		$pagos_externos = $row["externos"];
	} else {
		$saldo_inicial = 0;
		$pagos_externos = 0;
	}

	while ($dia_actual<=$mes_ultimo){
		$dia_actual2 = date("Y-m-d", $dia_actual);
		$hoy = date("U", mktime(0,0,0,date("m"), date("d"), date("Y")));

		if ($hoy >= $dia_actual){
			$sqlgasto = "select sum(total) as total_gasto from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=-1 and facturable=0) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
			$resultgasto = mysqli_query($dbhandle,$sqlgasto);
			$rowgasto = mysqli_fetch_array($resultgasto);
		}
		if ($hoy <= $dia_actual){
			$sqlgasto = "select sum(total) as total_gasto2 from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=-1) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
			$resultgasto = mysqli_query($dbhandle,$sqlgasto);
			$rowgasto = mysqli_fetch_array($resultgasto);
		}

		if ($hoy >= $dia_actual){
			$sqlingre1 = "select sum(total) as total_ingre1 from sgm_recibos where id_factura IN (select id from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=1 and v_recibos=1) and id_pagador=1 and cerrada=0) and fecha='".$dia_actual2."' and visible=1";
			$resultingre1 = mysqli_query($dbhandle,$sqlingre1);
			$rowingre1 = mysqli_fetch_array($resultingre1);
		}
		if ($hoy <= $dia_actual){
			$sqlingre2 = "select sum(total) as total_ingre2 from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=1 and v_recibos=1) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1 and cerrada=0 and cobrada=0";
			$resultingre2 = mysqli_query($dbhandle,$sqlingre2);
			$rowingre2 = mysqli_fetch_array($resultingre2);
			$ingre2 = $rowingre2["total_ingre2"];
		} else {
			$ingre2 = 0;
		}

		$sqlingre3 = "select sum(total) as total_ingre3 from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=1 and v_recibos=0) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1 and cerrada=0 and cobrada=0";
		$resultingre3 = mysqli_query($dbhandle,$sqlingre3);
		$rowingre3 = mysqli_fetch_array($resultingre3);

		$sqlex = "select sum(total) as total_externos from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=-1) and fecha_vencimiento = '".$dia_actual2."' and id_pagador<>1";
		$resultex = mysqli_query($dbhandle,$sqlex);
		$rowex = mysqli_fetch_array($resultex);

		$total_gastos = $rowgasto["total_gasto"]+$rowgasto["total_gasto2"];
		$total_ingresos = ($rowingre1["total_ingre1"] + $ingre2 + $rowingre3["total_ingre3"]);
		$saldo_actual = $saldo_inicial - $total_gastos + $total_ingresos;
		$pagos_externos = $pagos_externos + $rowex["total_externos"];
#		echo date("Y-m-d", $dia_actual)."-----Saldo : ".$saldo_inicial." - Ingresos :".$total_ingresos."--".$rowingre1["total_ingre1"]."1--".$rowingre2["total_ingre2"]."2--".$rowingre3["total_ingre3"]."3-- Gastos : ".$total_gastos." - Saldo Final:".$saldo_actual."<br>";
		$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual."'";
		$result = mysqli_query($dbhandle,$sql);
		$row = mysqli_fetch_array($result);
		if (!$row){
			$sql = "insert into sgm_factura_calendario (fecha,gastos,ingresos,externos,liquido) ";
			$sql = $sql."values (";
			$sql = $sql."".$dia_actual."";
			$sql = $sql.",'".$total_gastos."'";
			$sql = $sql.",'".$total_ingresos."'";
			$sql = $sql.",'".$pagos_externos."'";
			$sql = $sql.",'".$saldo_actual."'";
			$sql = $sql.")";
			mysqli_query($dbhandle,$sql);
#			echo $sql."in<br>";
		} else {
			$sql = "update sgm_factura_calendario set ";
			$sql = $sql."gastos='".$total_gastos."'";
			$sql = $sql.",ingresos='".$total_ingresos."'";
			$sql = $sql.",externos='".$pagos_externos."'";
			$sql = $sql.",liquido='".$saldo_actual."'";
			$sql = $sql." WHERE fecha=".$dia_actual."";
			mysqli_query($dbhandle,$sql);
#			echo $sql."<br>";
		}
		$saldo_inicial = $saldo_actual;
		$proxim_any = date("Y",$dia_actual);
		$proxim_mes = date("m",$dia_actual);
		$proxim_dia = date("d",$dia_actual);
		$dia_actual = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+1,$proxim_any));
		$rowgasto["total_gasto"] = 0;
		$rowingre1["total_ingre1"] = 0;
		$rowingre2["total_ingre2"] = 0;
		$rowingre3["total_ingre3"] = 0;
		$rowex["total_externos"] = 0;
	}
}

?>