<?php
error_reporting(~E_ALL);

function insertCabezera($datosInsert){
	global $db,$dbhandle,$userid,$errorFacturaCrear;
#	print_r($datosInsert);
	if (!array_key_exists('numero', $datosInsert)){
		if (array_key_exists('tipo', $datosInsert)){
			$sqltipo = "select * from sgm_factura_tipos where id=".$datosInsert['tipo'];
			$resulttipo = mysqli_query($dbhandle,convertSQL($sqltipo));
			$rowtipo = mysqli_fetch_array($resulttipo);
			$sqlxx = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipo["id"]." order by numero desc";
			$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
			$rowxx = mysqli_fetch_array($resultxx);
			$numero = $rowxx["numero"] + 1;
			$tipo = $rowtipo["id"];
			$version = 0;
			$v_recibos=$rowtipo["v_recibos"];
		}
	} else {
		$numero = $datosInsert['numero'];
		$tipo = $datosInsert['tipo'];
		$version = $datosInsert['version'];
		$sqltipo = "select * from sgm_factura_tipos where id=".$tipo;
		$resulttipo = mysqli_query($dbhandle,convertSQL($sqltipo));
		$rowtipo = mysqli_fetch_array($resulttipo);
		$v_recibos=$rowtipo["v_recibos"];
	}
	$sqlcc = "select count(*) as total from sgm_cabezera where visible=1 and numero=".$numero." and version=".$version." and tipo=".$tipo;
	$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
	$rowcc = mysqli_fetch_array($resultcc);
	if ($rowcc["total"] == 0){
		$sql = "select * from sgm_clients where id=".$datosInsert['id_cliente'];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$sqlta = "select * from sgm_tarifas where id=(select id_tarifa from sgm_contratos where id=".$datosInsert['id_contrato'].")";
		$resultta = mysqli_query($dbhandle,convertSQL($sqlta));
		$rowta = mysqli_fetch_array($resultta);
		$sqltipos = "select * from sgm_factura_tipos where id=".$tipo;
		$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
		$rowtipos = mysqli_fetch_array($resulttipos);
		if (array_key_exists('fecha_prevision', $datosInsert)){
			$fecha_prevision = $datosInsert['fecha_prevision'];
			$fecha_entrega = $datosInsert['fecha_prevision'];
		} else {
			$fecha_prevision = $datosInsert['fecha'];
			$fecha_entrega = $datosInsert['fecha'];
		}
		if ($rowtipos["v_fecha_vencimiento"] == 1) {
			$fecha_vencimiento = calcular_fecha_vencimiento($datosInsert['id_cliente'],$datosInsert['fecha']);
		} else {
			$fecha_vencimiento = $datosInsert['fecha'];
		}
		if ($row["id_direccion_envio"] == 0) {
			$edireccion = $row["direccion"];
			$epoblacion = $row["poblacion"];
			$ecp = $row["cp"];
			$eprovincia = $row["provincia"];
			$eid_pais = $row["id_pais"];
		}
		if ($row["id_direccion_envio"] <> 0) {
			$sql3 = "select * from sgm_clients_envios where id=".$row["id_direccion_envio"];
			$result3 = mysqli_query($dbhandle,convertSQL($sql3));
			$row3 = mysqli_fetch_array($result3);
			$edireccion = $row3["direccion"];
			$epoblacion = $row3["poblacion"];
			$ecp = $row3["cp"];
			$eprovincia = $row3["provincia"];
			$eid_pais = $row3["id_pais"];
		}
		$sql2 = "select * from sgm_dades_origen_factura";
		$result2 = mysqli_query($dbhandle,convertSQL($sql2));
		$row2 = mysqli_fetch_array($result2);
		$sqld = "select * from sgm_divisas where predefinido=1";
		$resultd = mysqli_query($dbhandle,convertSQL($sqld));
		$rowd = mysqli_fetch_array($resultd);
		$sqlc = "select * from sgm_clients_contactos where pred=1 and id_client=".$datosInsert['id_cliente'];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		if (!array_key_exists('id_dades_origen_factura_iban', $datosInsert)){
			$sqldo = "select * from sgm_dades_origen_factura_iban where predefinido=1";
			$resultdo = mysqli_query($dbhandle,convertSQL($sqldo));
			$rowdo = mysqli_fetch_array($resultdo);
			$id_dades_origen_factura_iban = $rowdo["id"];
		} else {
			$id_dades_origen_factura_iban = $datosInsert['id_dades_origen_factura_iban'];
		}

		$fecha = date("Y-m-d", strtotime($datosInsert["fecha"]));
		$fecha_prevision = date("Y-m-d", strtotime($fecha_prevision));
		$fecha_entrega = date("Y-m-d", strtotime($fecha_entrega));
		$fecha_vencimiento = date("Y-m-d", strtotime($fecha_vencimiento));

		$camposInsert = "numero,iva,version,numero_rfq,numero_cliente,fecha,fecha_prevision,fecha_entrega,fecha_vencimiento,tipo,subtipo,nombre,nif,direccion,poblacion,cp,provincia,id_pais,mail,telefono,edireccion,epoblacion,ecp,eprovincia,eid_pais,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,id_cliente,id_user,id_divisa,div_canvi,cnombre,cmail,ctelefono,cuenta,id_contrato,id_licencia,id_dades_origen_factura_iban,notas,total_forzado,recibos,confirmada,confirmada_cliente,descuento";
		$datosInsert2 = array($numero,$row2["iva"],$version,$datosInsert["numero_rfq"],$datosInsert["numero_cliente"],$fecha,$fecha_prevision,$fecha_entrega,$fecha_vencimiento,$tipo,$datosInsert['subtipo'],$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"],$row["nif"],$row["direccion"],$row["poblacion"],$row["cp"],$row["provincia"],$row["id_pais"],$row["mail"],$row["telefono"],$edireccion,$epoblacion,$ecp,$eprovincia,$eid_pais,$row2["nombre"],$row2["nif"],$row2["direccion"],$row2["poblacion"],$row2["cp"],$row2["provincia"],$row2["mail"],$row2["telefono"],$datosInsert['id_cliente'],$userid,$rowd["id"],$rowd["canvi"],$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"],$rowc["mail"],$rowc["telefono"],$row["cuentacontable"],$datosInsert['id_contrato'],$datosInsert['id_licencia'],$id_dades_origen_factura_iban,$datosInsert['notas'],$datosInsert['total_forzado'],$datosInsert['recibos'],$datosInsert['confirmada'],$datosInsert['confirmada_cliente'],$rowta["porcentage"]);
		insertFunction ("sgm_cabezera",$camposInsert,$datosInsert2);
		if (($v_recibos == 1) and ($datosInsert["fecha"] > date("Y-m-d"))){
			echo mensageError($errorFacturaCrear);
		}
	}
}

?>