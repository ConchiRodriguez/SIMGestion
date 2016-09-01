<?php
error_reporting(~E_ALL);


function deleteCuerpo($id,$idfactura){
	global $db,$dbhandle;
	deleteFunction ("sgm_cuerpo",$id);
	refactura($idfactura);
	$num = 1;
	$sqll = "select * from sgm_cuerpo where idfactura=".$idfactura." order by linea";
	$resultl = mysqli_query($dbhandle,convertSQL($sqll));
	while ($rowl = mysqli_fetch_array($resultl)) {
		if ($num == $rowl["linea"]) {
			$num++;
		} else {
			$camposUpdate = array("linea");
			$datosUpdate = array($num);
			updateFunction ("sgm_cuerpo",$rowl["id"],$camposUpdate,$datosUpdate);
			$num++;
		}
	}
	$data = date("U");
	$camposInsert = "id_factura, id_usuario, fecha";
	$datosInsert = array($_GET["id"],$userid,$data);
	insertFunction ("sgm_factura_modificacio",$camposInsert,$datosInsert);
}

?>