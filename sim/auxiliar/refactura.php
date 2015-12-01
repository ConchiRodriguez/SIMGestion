<?php
error_reporting(~E_ALL);


function refactura($idfactura) {
	global $db;
	#CALCULO DEL TOTAL DE LAS LINEAS
	$sql = "select count(*) as total from sgm_cuerpo where idfactura=".$idfactura;
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);
	if ($row["total"] == 0) { $subtotal = 0; } else {
		$sql = "select sum(total) as subtotal from sgm_cuerpo where suma=0 and idfactura=".$idfactura;
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["subtotal"]) { $subtotal = $row["subtotal"]; } else { $subtotal = 0; }
	}
	# SELECT DE LA CABEZERA
	$sql = "select * from sgm_cabezera where id=".$idfactura;
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);
	if ($row["total_forzado"] == 0) {
		$sql = "update sgm_cabezera set ";
		$sql = $sql."subtotal=".$subtotal;
		if ($row["descuento_absoluto"] == 0) { $x = $subtotal - (($subtotal / 100) * $row["descuento"]) ; }
		if ($row["descuento"] == 0) { $x = $subtotal - $row["descuento_absoluto"] ;	}
		$sql = $sql.",subtotaldescuento=".$x;
		$xx = (($x / 100) * $row["iva"]) + $x;
		$xxx = $xx -(($x / 100) * $row["retenciones"]);
		$sql = $sql.",total=".$xxx;
		$sql = $sql." WHERE id=".$idfactura;
		mysql_query(convertSQL($sql));
#		echo $sql;
	}
	if ($row["total_forzado"] == 1) {
		$sql = "update sgm_cabezera set ";
		$sql = $sql."subtotal=".$subtotal;
		$x = $row["total"]/(1+(($row["iva"]/100) - ($row["retenciones"]/100)));
		$sql = $sql.",subtotaldescuento=".$x;
		$xx = 100-($x/($subtotal/100));
		$sql = $sql.",descuento=".$xx;
		$sql = $sql.",descuento_absoluto=".($subtotal-$x);
		$sql = $sql.",total=".$row["total"];
		$sql = $sql." WHERE id=".$idfactura;
		mysql_query(convertSQL($sql));
#		echo $sql;
	}
}

?>