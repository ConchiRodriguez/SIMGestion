<?php
error_reporting(~E_ALL);


function calendari_economic($rec){
	global $db;
	$mes = gmdate("n");
	$mes_anterior = date("U", mktime(0,0,0,$mes-1, 1, date("Y")));
	$mes_ultimo = date("U", mktime(0,0,0,$mes+12, 1-1, date("Y")));
	$dia_actual=$mes_anterior;
	$dia_actual1 = date("U", mktime(0,0,0,$mes-1, 1-1, date("Y")));
	if ($rec == 1) {$dia_actual=date("U", mktime(0,0,0,1,1,2012)); $dia_actual1=date("U", mktime(0,0,0,1,1-1,2012));}

	$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual1."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
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
			$sqlgasto = "select sum(total) as total_gasto from sgm_cabezera where visible=1 and tipo=5 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
			$resultgasto = mysql_query($sqlgasto);
			$rowgasto = mysql_fetch_array($resultgasto);
		}
		if ($hoy == $dia_actual){
			$sqlgasto2 = "select sum(total) as total_gasto2 from sgm_cabezera where visible=1 and tipo=8 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		} elseif ($hoy < $dia_actual){
			$sqlgasto2 = "select sum(total) as total_gasto2 from sgm_cabezera where visible=1 and tipo in (5,8) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		}
			$resultgasto2 = mysql_query($sqlgasto2);
			$rowgasto2 = mysql_fetch_array($resultgasto2);


		if ($hoy >= $dia_actual){
			$sqlingre1 = "select sum(total) as total_ingre1 from sgm_recibos where id_factura IN (select id from sgm_cabezera where visible=1 and tipo=1 and id_pagador=1 and cerrada=0) and fecha='".$dia_actual2."' and visible=1";
			$resultingre1 = mysql_query($sqlingre1);
			$rowingre1 = mysql_fetch_array($resultingre1);
		}
		if ($hoy <= $dia_actual){
			$sqlingre2 = "select sum(total) as total_ingre2 from sgm_cabezera where visible=1 and tipo=1 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1 and cerrada=0 and cobrada=0";
			$resultingre2 = mysql_query($sqlingre2);
			$rowingre2 = mysql_fetch_array($resultingre2);
		}

#		$sqlingre1 = "select sum(total) as total_ingre1 from sgm_cabezera where visible=1 and tipo=1 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
#		$resultingre1 = mysql_query($sqlingre1);
#		$rowingre1 = mysql_fetch_array($resultingre1);

		$sqlingre3 = "select sum(total) as total_ingre3 from sgm_cabezera where visible=1 and tipo=7 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		$resultingre3 = mysql_query($sqlingre3);
		$rowingre3 = mysql_fetch_array($resultingre3);
		$sqliv = "select sum(total) as total_ingreso_varios from sgm_cabezera where visible=1 and tipo=9 and fecha_vencimiento = '".$dia_actual2."' and id_pagador=1";
		$resultiv = mysql_query($sqliv);
		$rowiv = mysql_fetch_array($resultiv);
		$sqlprep = "select sum(total) as total_prep from sgm_cabezera where visible=1 and tipo=10 and fecha_vencimiento = '".$dia_actual2."' and id_pagador=1";
		$resultprep = mysql_query($sqlprep);
		$rowprep = mysql_fetch_array($resultprep);
		$sqlex = "select sum(total) as total_externos from sgm_cabezera where visible=1 and fecha_vencimiento = '".$dia_actual2."' and id_pagador<>1";
		$resultex = mysql_query($sqlex);
		$rowex = mysql_fetch_array($resultex);
		$total_gastos = $rowgasto["total_gasto"] + $rowgasto2["total_gasto2"];
		$saldo_actual = $saldo_inicial - $rowgasto["total_gasto"] - $rowgasto2["total_gasto2"] + ($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowingre3["total_ingre3"]) + $rowiv["total_ingreso_varios"];
		$ingresos = ($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowingre3["total_ingre3"] + $rowiv["total_ingreso_varios"]);
		$pagos_externos = $pagos_externos + $rowex["total_externos"];
#		echo date("Y-m-d", $dia_actual)."<br>Saldo : ".$saldo_inicial." - Ingresos :".($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowiv["total_ingreso_varios"])." - Gastos : ".$rowgasto["total_gasto"]." - Saldo Final:".$saldo_actual."<br>";
		$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if (!$row){
			$sql = "insert into sgm_factura_calendario (fecha,gastos,ingresos,pre_pagos,externos,liquido) ";
			$sql = $sql."values (";
			$sql = $sql."".$dia_actual."";
			$sql = $sql.",'".$total_gastos."'";
			$sql = $sql.",'".$ingresos."'";
			$sql = $sql.",'".$rowprep["total_prep"]."'";
			$sql = $sql.",'".$pagos_externos."'";
			$sql = $sql.",'".$saldo_actual."'";
			$sql = $sql.")";
			mysql_query($sql);
#			echo $sql."in<br>";
		} else {
			$sql = "update sgm_factura_calendario set ";
			$sql = $sql."gastos='".$total_gastos."'";
			$sql = $sql.",ingresos='".$ingresos."'";
			$sql = $sql.",pre_pagos='".$rowprep["total_prep"]."'";
			$sql = $sql.",externos='".$pagos_externos."'";
			$sql = $sql.",liquido='".$saldo_actual."'";
			$sql = $sql." WHERE fecha=".$dia_actual."";
			mysql_query($sql);
#			echo $sql."<br>";
		}
		$saldo_inicial = $saldo_actual;
		$proxim_any = date("Y",$dia_actual);
		$proxim_mes = date("m",$dia_actual);
		$proxim_dia = date("d",$dia_actual);
		$dia_actual = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+1,$proxim_any));
		$iva1=0;
		$iva2=0;
		$iva3=0;
		$iva4=0;
		$irpf1=0;
		$irpf2=0;
		$irpf3=0;
		$irpf4=0;
		$rowgasto["total_gasto"]=0;
		$rowingre1["total_ingre1"]=0;
	}
}

?>