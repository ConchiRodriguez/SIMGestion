<?php
error_reporting(~E_ALL);


function comprobarTipoCliente()
{ 
	global $db,$dbhandle;
	$sqlc = "select * from sgm_clients where visible=1";
	$resultc = mysqli_query($dbhandle,$sqlc);
	while ($rowc = mysqli_fetch_array($resultc)){
		$sqlct = "select * from sgm_clients_tipos where visible=1";
		$resultct = mysqli_query($dbhandle,$sqlct);
		while ($rowct = mysqli_fetch_array($resultct)){
			$valido = 1;
			if ($valido == 1){
				$sqlct1 = "select count(*) as total from sgm_cabezera where visible=1 and id_cliente=".$rowc["id"];
				if ($rowct["id_tipo_factura"] > 0) { $sqlct1.= " and tipo=".$rowct["id_tipo_factura"]; }
				$resultct1 = mysqli_query($dbhandle,$sqlct1);
				$rowct1 = mysqli_fetch_array($resultct1);
				if (($rowct1["total"] > 0) and ($rowct["factura"] == 0)) { $valido = 0; }
				if (($rowct1["total"] == 0) and ($rowct["factura"] == 1)) { $valido = 0; }
			}
			if ($valido == 1){
				$sqlct2 = "select count(*) as total from sgm_contratos where visible=1 and id_cliente=".$rowc["id"];
				if ($rowct["contrato_activo"] == 1) { $sqlct2.= " and activo=1"; }
				if ($rowct["contrato_activo"] == 2) { $sqlct2.= " and activo=0"; }
				$resultct2 = mysqli_query($dbhandle,$sqlct2);
				$rowct2 = mysqli_fetch_array($resultct2);
				if (($rowct2["total"] > 0) and ($rowct["contrato"] == 0)) { $valido = 0; }
				if (($rowct2["total"] == 0) and ($rowct["contrato"] == 1)) { $valido = 0; }
			}
			if ($valido == 1){
				$sqlct3 = "select count(*) as total from sgm_incidencias where visible=1 and id_cliente=".$rowc["id"];
				$resultct3 = mysqli_query($dbhandle,$sqlct3);
				$rowct3 = mysqli_fetch_array($resultct3);
				if (($rowct3["total"] > 0) and ($rowct["incidencia"] == 0)) { $valido = 0; }
				if (($rowct3["total"] == 0) and ($rowct["incidencia"] == 1)) { $valido = 0; }
			}
			if ($valido == 1){
				$check_nif = comprobarIdentificador($rowc["tipo_identificador"],$rowc["nif"]);
				if (($rowct["datos_fiscales"] == 0) and (($check_nif > 0) and ($rowc["nombre"] != "") and ($rowc["direccion"] != "") and ($rowc["cp"] != "") and ($rowc["poblacion"] != "") and ($rowc["provincia"] != ""))) { $valido = 0; }
				if (($rowct["datos_fiscales"] == 1) and (($check_nif <= 0) OR ($rowc["nombre"] == "") OR ($rowc["direccion"] == "") OR ($rowc["cp"] == "") OR ($rowc["poblacion"] == "") OR ($rowc["provincia"] == ""))) { $valido = 0; }
			}

			if ($valido == 1){
				$sql = "select * from sgm_clients_rel_tipos where id_cliente=".$rowc["id"]." and id_tipo=".$rowct["id"];
				$result = mysqli_query($dbhandle,$sql);
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert="id_cliente,id_tipo";
					$datosInsert = array($rowc["id"],$rowct["id"]);
					insertFunction ("sgm_clients_rel_tipos",$camposInsert,$datosInsert);
				}
			} elseif ($valido == 0) {
				$sql = "select * from sgm_clients_rel_tipos where id_cliente=".$rowc["id"]." and id_tipo=".$rowct["id"];
				$result = mysqli_query($dbhandle,$sql);
				$row = mysqli_fetch_array($result);
				if ($row){
					deleteFunction ("sgm_clients_rel_tipos",$row["id"]);
				}
				
			}
		}
	}
}

?>