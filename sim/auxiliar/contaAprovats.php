<?php
error_reporting(~E_ALL);


function contaAprovats($id_linia,$id_factura)
{
	$sql = "select count(*) as total from sgm_cuerpo where id=".$id_linia."";
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);
	$sql2 = "select count(*) as total2 from sgm_cuerpo where id=".$id_linia." and aprovat=1";
	$result2 = mysql_query(convertSQL($sql2));
	$row2 = mysql_fetch_array($result2);
	if ($row["total"] == $row2["total2"]){
		$sqlc = "update sgm_cabezera set ";
		$sqlc = $sqlc."confirmada_cliente=1";
		$sqlc = $sqlc." WHERE id=".$id_factura."";
		mysql_query(convertSQL($sqlc));
	} else {
		$sqlc = "update sgm_cabezera set ";
		$sqlc = $sqlc."confirmada_cliente=0";
		$sqlc = $sqlc." WHERE id=".$id_factura."";
		mysql_query(convertSQL($sqlc));
	}
}

?>
