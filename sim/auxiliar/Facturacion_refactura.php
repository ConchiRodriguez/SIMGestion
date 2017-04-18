<?php
error_reporting(~E_ALL);


function refactura($idfactura) {
	global $db,$dbhandle;
	#CALCULO DEL TOTAL DE LAS LINEAS
	$sql = "select count(*) as total from sgm_cuerpo where idfactura=".$idfactura;
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	if ($row["total"] == 0) { $subtotal = 0; } else {
		$sql = "select sum(total) as subtotal from sgm_cuerpo where suma=0 and idfactura=".$idfactura;
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["subtotal"]) { $subtotal = $row["subtotal"]; } else { $subtotal = 0; }
	}
	# SELECT DE LA CABEZERA
	$sql = "select * from sgm_cabezera where id=".$idfactura;
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	if ($row["total_forzado"] == 0) {
		if ($row["descuento_absoluto"] == 0) { $x = $subtotal - (($subtotal / 100) * $row["descuento"]) ; }
		if ($row["descuento"] == 0) { $x = $subtotal - $row["descuento_absoluto"] ;	}
		$xx = (($x / 100) * $row["iva"]) + $x;
		$xxx = $xx -(($x / 100) * $row["retenciones"]);
		$camposUpdate = array("subtotal","subtotaldescuento","total");
		$datosUpdate = array($subtotal,$x,$xxx);
		updateFunction ("sgm_cabezera",$idfactura,$camposUpdate,$datosUpdate);
	}
	if ($row["total_forzado"] == 1) {
		$x = $row["total"]/(1+(($row["iva"]/100) - ($row["retenciones"]/100)));
		$xx = 100-($x/($subtotal/100));
		$xxx = $subtotal-$x;
		$camposUpdate = array("subtotal","subtotaldescuento","descuento","descuento_absoluto","total");
		$datosUpdate = array($subtotal,$x,$xx,$xxx,$row["total"]);
		updateFunction ("sgm_cabezera",$idfactura,$camposUpdate,$datosUpdate);
	}
}

?>