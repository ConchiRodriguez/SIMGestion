<?php
error_reporting(~E_ALL);

function insertCabezera($numero,$tipo,$subtipo,$version,$numero_rfq,$numero_cliente,$fecha,$fecha_prevision,$id_cliente,$id_contrato,$id_licencia,$id_dades_origen_factura_iban){
	global $userid;
	if ($numero == 0){
		$sqlxx = "select * from sgm_cabezera where visible=1 AND tipo=7 order by numero desc";
		$resultxx = mysql_query(convert_sql($sqlxx));
		$rowxx = mysql_fetch_array($resultxx);
		$numero = $rowxx["numero"] + 1;
	}
	$sqlcc = "select count(*) as total from sgm_cabezera where visible=1 and numero=".$numero." and tipo=".$tipo;
	$resultcc = mysql_query(convert_sql($sqlcc));
	$rowcc = mysql_fetch_array($resultcc);
	if ($rowcc["total"] == 0){
		$sql = "select * from sgm_clients where id=".$id_cliente;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$sqltipos = "select * from sgm_factura_tipos where id=".$tipo;
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		$sql = "insert into sgm_cabezera (numero,iva,version,numero_rfq,numero_cliente,fecha,fecha_prevision,fecha_entrega,fecha_vencimiento,tipo,subtipo,nombre,nif,direccion,poblacion,cp,provincia,id_pais,mail,telefono,edireccion,epoblacion,ecp,eprovincia,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,id_cliente,id_user,id_divisa,div_canvi,cnombre,cmail,ctelefono,cuenta,id_contrato,id_licencia,id_dades_origen_factura_iban) ";
		$sql = $sql."values (";
		$sql = $sql."".$numero."";
		$sql = $sql.",21";
		$sql = $sql.",'".$version."'";
		$sql = $sql.",'".$numero_rfq."'";
		$sql = $sql.",'".$numero_cliente."'";
		$sql = $sql.",'".$fecha."'";
		if ($fecha_prevision != 0){
			$sql = $sql.",'".$fecha_prevision."'";
			$sql = $sql.",'".$fecha_prevision."'";
		} else {
			$sql = $sql.",'".$fecha."'";
			$sql = $sql.",'".$fecha."'";
		}
		if ($rowtipos["v_fecha_vencimiento"] == 1) {
			$fecha_vencimiento = calcular_fecha_vencimiento($id_cliente,cambiarFormatoFechaYMD($fecha));
		} else { $fecha_vencimiento = $fecha; }
		if ($rowtipos["presu"] == 1) {
			$suma = $rowtipos["presu_dias"];
			$date1 = $fecha;
			$a = date("Y", strtotime($date1)); 
			$m = date("n", strtotime($date1)); 
			$d = date("j", strtotime($date1)); 
			$fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$suma, $a));
		} else { $fecha_vencimiento = $fecha; }
		$sql = $sql.",'".$fecha_vencimiento."'";
		$sql = $sql.",".$tipo;
		$sql = $sql.",".$subtipo;
		$sql = $sql.",'".comillas($row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"])."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".comillas($row["direccion"])."'";
		$sql = $sql.",'".comillas($row["poblacion"])."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".comillas($row["provincia"])."'";
		$sql = $sql.",".$row["id_pais"];
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";
		if ($row["id_direccion_envio"] == 0) {
			$sql = $sql.",'".comillas($row["direccion"])."'";
			$sql = $sql.",'".comillas($row["poblacion"])."'";
			$sql = $sql.",'".$row["cp"]."'";
			$sql = $sql.",'".comillas($row["provincia"])."'";
		}
		if ($row["id_direccion_envio"] <> 0) {
			$sql3 = "select * from sgm_clients_envios where id=".$row["id_direccion_envio"];
			$result3 = mysql_query(convert_sql($sql3));
			$row3 = mysql_fetch_array($result3);
			$sql = $sql.",'".comillas($row3["direccion"])."'";
			$sql = $sql.",'".comillas($row3["poblacion"])."'";
			$sql = $sql.",'".$row3["cp"]."'";
			$sql = $sql.",'".comillas($row3["provincia"])."'";
		}
		$sql2 = "select * from sgm_dades_origen_factura";
		$result2 = mysql_query(convert_sql($sql2));
		$row2 = mysql_fetch_array($result2);
		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".comillas($row["direccion"])."'";
		$sql = $sql.",'".comillas($row["poblacion"])."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".comillas($row["provincia"])."'";
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";
		$sql = $sql.",".$id_cliente;
		$sql = $sql.",".$userid;
		$sqld = "select * from sgm_divisas where predefinido=1";
		$resultd = mysql_query(convert_sql($sqld));
		$rowd = mysql_fetch_array($resultd);
		$sql = $sql.",".$rowd["id"];
		$sql = $sql.",".$rowd["canvi"];
		$sqlc = "select * from sgm_clients_contactos where pred=1 and id_client=".$_POST["cliente"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sql = $sql.",'".comillas($rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"])."'";
		$sql = $sql.",'".$rowc["mail"]."'";
		$sql = $sql.",'".$rowc["telefono"]."'";
		if ($row["cuentacontable"] != 0){
			$sql = $sql.",".$row["cuentacontable"]."";
		} else {
			$sql = $sql.",0";
		}
		$sql = $sql.",".$id_contrato;
		$sql = $sql.",".$id_licencia;
		if ($id_dades_origen_factura_iban == 0){
			$sqldo = "select * from sgm_dades_origen_factura_iban where predefinido=1";
			$resultdo = mysql_query(convert_sql($sqldo));
			$rowdo = mysql_fetch_array($resultdo);
			$sql = $sql.",".$rowdo["id"]."";
		} else {
			$sql = $sql.",".$id_dades_origen_factura_iban;
		}
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
#		echo $sql;
	}
}

function insertCuerpo($idfactura,$linea,$codigo,$nombre,$pvd,$pvp,$unidades,$fecha_prevision,$id_article,$stock,$fecha_prevision_propia){
	$sql = "insert into sgm_cuerpo (idfactura,linea,codigo,nombre,pvd,pvp,unidades,total,fecha_prevision,id_article,stock,fecha_prevision_propia) ";
	$sql = $sql."values (";
	$sql = $sql."".$idfactura;
	$sql = $sql.",".$linea;
	$sql = $sql.",'".$codigo."'";
	$sql = $sql.",'".comillas($nombre)."'";
	$sql = $sql.",'".$pvd."'";
	$sql = $sql.",'".$pvp."'";
	$sql = $sql.",".$unidades;
	$total = $unidades * $pvp;
	$sql = $sql.",'".$total."'";
	$sql = $sql.",'".$fecha_prevision."'";
	$sql = $sql.",".$id_article;
	$sql = $sql.",".$stock;
	$sql = $sql.",'".$fecha_prevision."'";
	$sql = $sql.")";
	mysql_query(convert_sql($sql));
#	echo $sql;
	refactura($idfactura);
}

function updateCabezera($id,$numero,$tipo,$subtipo,$version,$numero_rfq,$numero_cliente,$fecha,$fecha_prevision,$fecha_entrega,$fecha_vencimiento,$id_cliente,$id_contrato,$id_licencia,$nombre,$cnombre,$cmail,$ctelf,$nif,$direccion,$poblacion,$cp,$provincia,$id_pais,$mail,$telefono,$edireccion,$epoblacion,$ecp,$eprovincia,$notas,$imp_exp,$id_divisa,$div_canvi,$id_pagador,$id_user,$id_dades_origen_factura_iban){
	global $userid;
	$sqlf = "select * from sgm_cabezera where id=".$id;
	$resultf = mysql_query(convert_sql($sqlf));
	$rowf = mysql_fetch_array($resultf);
	if ($rowf["fecha_prevision"] != $_POST["fecha_prevision"]){
		$sqlf = "insert into sgm_factura_canvi_data_prevision (id_factura,id_usuario,fecha_ant,data) ";
		$sqlf = $sqlf."values (";
		$sqlf = $sqlf."".$id."";
		$sqlf = $sqlf.",".$userid;
		$sqlf = $sqlf.",'".$rowf["fecha_prevision"]."'";
		$sqlf = $sqlf.",'".$fecha."'";
		$sqlf = $sqlf.")";
		mysql_query(convert_sql($sqlf));
#	echo $sqlf."<br>";
	}
	if (($rowf["fecha_entrega"] != $_POST["fecha_entrega"]) and ($_POST["fecha_entrega"] > 0)){
		$sqlf = "insert into sgm_factura_canvi_data_entrega (id_factura,id_usuario,fecha_ant,data) ";
		$sqlf = $sqlf."values (";
		$sqlf = $sqlf."".$_GET["id"]."";
		$sqlf = $sqlf.",".$userid;
		$sqlf = $sqlf.",'".$rowf["fecha_entrega"]."'";
		$sqlf = $sqlf.",'".$fecha."'";
		$sqlf = $sqlf.")";
		mysql_query(convert_sql($sqlf));
#	echo $sqlf."<br>";
	}
	$sql = "update sgm_cabezera set ";
	if ($fecha != 0){$sql = $sql."fecha='".$fecha."'";} else {$sql = $sql."fecha='".$rowf["fecha"]."'";}
	if ($fecha_prevision != 0){$sql = $sql.",fecha_prevision='".$fecha_prevision."'";} else {$sql = $sql.",fecha_prevision='".$rowf["fecha_prevision"]."'";}
	if ($numero != 0){$sql = $sql.",numero='".$numero."'";} else {$sql = $sql.",numero='".$rowf["numero"]."'";}
	if ($version != 0){$sql = $sql.",version='".$version."'";} else {$sql = $sql.",version='".$rowf["version"]."'";}
	if ($numero_rfq != 0){$sql = $sql.",numero_rfq='".$numero_rfq."'";} else {$sql = $sql.",numero_rfq='".$rowf["numero_rfq"]."'";}
	if ($numero_cliente != 0){$sql = $sql.",numero_cliente='".$numero_cliente."'";} else {$sql = $sql.",numero_cliente='".$rowf["numero_cliente"]."'";}
	if ($fecha_entrega != 0){$sql = $sql.",fecha_entrega='".$fecha_entrega."'";} else {$sql = $sql.",fecha_entrega='".$rowf["fecha_entrega"]."'";}
	if ($fecha_vencimiento != 0){$sql = $sql.",fecha_vencimiento='".$fecha_vencimiento."'";} else {$sql = $sql.",fecha_vencimiento='".$rowf["fecha_vencimiento"]."'";}
	if ($notas != 0){$sql = $sql.",notas='".comillas($notas)."'";} else {$sql = $sql.",notas='".comillas($rowf["notas"])."'";}

	if (($id_cliente != 0) and ($id_cliente != $rowf["id_cliente"])){
		$sqlc = "select * from sgm_clients where id=".$id_cliente;
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sql = $sql.",nombre='".comillas($rowc["nombre"])." ".comillas($rowc["cognom1"])." ".comillas($rowc["cognom2"])."'";
		$sql = $sql.",nif='".$rowc["nif"]."'";
		$sql = $sql.",direccion='".comillas($rowc["direccion"])."'";
		$sql = $sql.",poblacion='".comillas($rowc["poblacion"])."'";
		$sql = $sql.",cp='".$rowc["cp"]."'";
		$sql = $sql.",provincia='".comillas($rowc["provincia"])."'";
		$sql = $sql.",id_pais=".$rowc["id_pais"];
		$sql = $sql.",mail='".$rowc["mail"]."'";
		$sql = $sql.",telefono='".$rowc["telefono"]."'";
		if ($rowc["id_direccion_envio"] == 0) {
			$sql = $sql.",edireccion=''";
			$sql = $sql.",epoblacion=''";
			$sql = $sql.",ecp=''";
			$sql = $sql.",eprovincia=''";
		}
		if ($rowc["id_direccion_envio"] <> 0) {
			$sql3 = "select * from sgm_clients_envios where id=".$rowc["id_direccion_envio"];
			$result3 = mysql_query(convert_sql($sql3));
			$row3 = mysql_fetch_array($result3);
			$sql = $sql.",edireccion='".comillas($row3["direccion"])."'";
			$sql = $sql.",epoblacion='".comillas($row3["poblacion"])."'";
			$sql = $sql.",ecp='".$row3["cp"]."'";
			$sql = $sql.",eprovincia='".comillas($row3["provincia"])."'";
		}
		$sqlc = "select * from sgm_clients_contactos where pred=1 and id_client=".$_POST["cliente"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sql = $sql.",cnombre='".comillas($rowc["nombre"])." ".comillas($rowc["apellido1"])." ".comillas($rowc["apellido2"])."'";
		$sql = $sql.",cmail='".$rowc["mail"]."'";
		$sql = $sql.",ctelefono='".$rowc["telefono"]."'";
	} else {
		if ($nombre != 0){$sql = $sql.",nombre='".comillas($nombre)."'";} else {$sql = $sql.",nombre='".$rowf["nombre"]."'";}
		if ($nif != 0){$sql = $sql.",nif='".$nif."'";} else {$sql = $sql.",nif='".$rowf["nif"]."'";}
		if ($direccion != 0){$sql = $sql.",direccion='".comillas($direccion)."'";} else {$sql = $sql.",direccion='".$rowf["direccion"]."'";}
		if ($poblacion != 0){$sql = $sql.",poblacion='".comillas($poblacion)."'";} else {$sql = $sql.",poblacion='".$rowf["poblacion"]."'";}
		if ($cp != 0){$sql = $sql.",cp='".$cp."'";} else {$sql = $sql.",cp='".$rowf["cp"]."'";}
		if ($provincia != 0){$sql = $sql.",provincia='".comillas($provincia)."'";} else {$sql = $sql.",provincia='".$rowf["provincia"]."'";}
		if ($id_pais != 0){$sql = $sql.",id_pais='".$id_pais."'";} else {$sql = $sql.",id_pais='".$rowf["id_pais"]."'";}
		if ($mail != 0){$sql = $sql.",mail='".$mail."'";} else {$sql = $sql.",mail='".$rowf["mail"]."'";}
		if ($telefono != 0){$sql = $sql.",telefono='".$telefono."'";} else {$sql = $sql.",telefono='".$rowf["telefono"]."'";}

		if ($edireccion != 0){$sql = $sql.",edireccion='".comillas($edireccion)."'";} else {$sql = $sql.",edireccion='".$rowf["edireccion"]."'";}
		if ($epoblacion != 0){$sql = $sql.",epoblacion='".comillas($epoblacion)."'";} else {$sql = $sql.",epoblacion='".$rowf["epoblacion"]."'";}
		if ($ecp != 0){$sql = $sql.",ecp='".$ecp."'";} else {$sql = $sql.",ecp='".$rowf["ecp"]."'";}
		if ($eprovincia != 0){$sql = $sql.",eprovincia='".comillas($eprovincia)."'";} else {$sql = $sql.",eprovincia='".$rowf["eprovincia"]."'";}

		if ($cnombre != 0){$sql = $sql.",cnombre='".comillas($cnombre)."'";} else {$sql = $sql.",cnombre='".$rowf["cnombre"]."'";}
		if ($cmail != 0){$sql = $sql.",cmail='".$cmail."'";} else {$sql = $sql.",cmail='".$rowf["cmail"]."'";}
		if ($ctelf != 0){$sql = $sql.",ctelefono='".$ctelf."'";} else {$sql = $sql.",ctelefono='".$rowf["ctelefono"]."'";}
		if ($nombre != 0){$sql = $sql.",nombre='".comillas($nombre)."'";} else {$sql = $sql.",nombre='".$rowf["nombre"]."'";}
		if ($nif != 0){$sql = $sql.",nif='".$nif."'";} else {$sql = $sql.",nif='".$rowf["nif"]."'";}
		if ($direccion != 0){$sql = $sql.",direccion='".comillas($direccion)."'";} else {$sql = $sql.",direccion='".$rowf["direccion"]."'";}
		if ($poblacion != 0){$sql = $sql.",poblacion='".comillas($poblacion)."'";} else {$sql = $sql.",poblacion='".$rowf["poblacion"]."'";}
		if ($cp != 0){$sql = $sql.",cp='".$cp."'";} else {$sql = $sql.",cp='".$rowf["cp"]."'";}
		if ($provincia != 0){$sql = $sql.",provincia='".comillas($provincia)."'";} else {$sql = $sql.",provincia='".$rowf["provincia"]."'";}
		if ($id_pais != 0){$sql = $sql.",id_pais='".$id_pais."'";} else {$sql = $sql.",id_pais='".$rowf["id_pais"]."'";}
		if ($mail != 0){$sql = $sql.",mail='".$mail."'";} else {$sql = $sql.",mail='".$rowf["mail"]."'";}
		if ($telefono != 0){$sql = $sql.",telefono='".$telefono."'";} else {$sql = $sql.",telefono='".$rowf["telefono"]."'";}
	}
	if ($id_cliente != 0){$sql = $sql.",id_cliente='".$id_cliente."'";} else {$sql = $sql.",id_cliente='".$rowf["id_cliente"]."'";}

	$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$tipo." and id_user=".$userid;
	$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
	$rowpermiso2 = mysql_fetch_array($resultpermiso2);
	if ($rowpermiso2["admin"] == 1) {
		$sql = $sql.",id_user=".$id_user;
		$sql = $sql.",id_pagador=".$id_pagador;
	} else {
		$sql = $sql.",id_user=".$rowf["id_user"];
		$sql = $sql.",id_pagador=".$rowf["id_pagador"];
	}
	$sql = $sql.",imp_exp=".$imp_exp;
	$sql = $sql.",id_divisa=".$id_divisa;
	if ($id_divisa != $rowf["id_divisa"]){
		if ($id_divisa > 0) {
			$sqldi = "select * from sgm_divisas where id=".$id_divisa;
			$resultdi = mysql_query(convert_sql($sqldi));
			$rowdi = mysql_fetch_array($resultdi);
			$sql = $sql.",div_canvi=".$rowdi["canvi"];
		} else {
			$sql = $sql.",div_canvi=0";
		}
	} else {
		$sql = $sql.",div_canvi=".$div_canvi;
	}
	if ($id_dades_origen_factura_iban != 0){$sql = $sql.",id_dades_origen_factura_iban='".$id_dades_origen_factura_iban."'";} else {$sql = $sql.",id_dades_origen_factura_iban='".$rowf["id_dades_origen_factura_iban"]."'";}
	$sql = $sql." WHERE id=".$id."";
	mysql_query(convert_sql($sql));
#	echo $sql."<br>";

	$data = date("Y-m-d");
	$hora = date("H:i:s");
	$sqlfm = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
	$sqlfm = $sqlfm."values (";
	$sqlfm = $sqlfm."".$id."";
	$sqlfm = $sqlfm.",".$userid;
	$sqlfm = $sqlfm.",'".$data."'";
	$sqlfm = $sqlfm.",'".$hora."'";
	$sqlfm = $sqlfm.")";
	mysql_query(convert_sql($sqlfm));
#	echo $sqlfm."<br>";
}

function updateCuerpo($id,$idfactura,$linea,$codigo,$nombre,$pvd,$pvp,$unidades,$fecha_prevision,$id_article,$stock,$fecha_prevision_propia,$descuento,$descuento_absoluto){
	global $userid;
	$sql = "select * from sgm_cuerpo where id=".$id."";
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	if ($row["fecha_prevision"] != $fecha_prevision){
		$fecha = date("Y-m-d");
		$sqlf = "insert into sgm_factura_canvi_data_prevision_cuerpo (id_factura,id_usuario,fecha_ant,data,id_cuerpo) ";
		$sqlf = $sqlf."values (";
		$sqlf = $sqlf."".$idfactura."";
		$sqlf = $sqlf.",".$userid;
		$sqlf = $sqlf.",'".$row["fecha_prevision"]."'";
		$sqlf = $sqlf.",'".$fecha."'";
		$sqlf = $sqlf.",".$row["id"];
		$sqlf = $sqlf.")";
		mysql_query(convert_sql($sqlf));
#		echo $sqlf."<br>";
	}
	$sql = "update sgm_cuerpo set ";
	$sql = $sql."codigo='".$codigo."'";
	$sql = $sql.",nombre='".comillas($nombre)."'";
	if ($pvd == ""){
		$sql = $sql.",pvd=0";
	} else {
		$pvd = ereg_replace(",","",$pvd);
		$sql = $sql.",pvd='".$pvd."'";
	}
	$pvp = ereg_replace(",","",$pvp);
	$sql = $sql.",pvp='".$pvp."'";
	$sql = $sql.",linea=".$linea;
	$sql = $sql.",unidades=".$unidades;
	if ( (($descuento != "") OR ($descuento != 0)) AND (($descuento_absoluto != "") OR ($descuento_absoluto != 0)) )  {
		if  ($_POST["descuento_absoluto".$x.""] == 0) {
			$total = ($pvp-($pvp/100)*$descuento)*$unidades;
			$sql = $sql.",descuento='".$descuento."'";
			$sql = $sql.",descuento_absoluto=0";
		} else {
			$total = ($pvp- $descuento_absoluto)* $unidades;
			$sql = $sql.",descuento=0";
			$sql = $sql.",descuento_absoluto='".$descuento_absoluto."'";
		}
	} else {
		$total = $unidades * $pvp;
	}
	$sql = $sql.",total='".$total."'";
	$sql = $sql.",fecha_prevision='".$fecha_prevision."'";
	$sql = $sql." WHERE id=".$id."";
	mysql_query(convert_sql($sql));
#	echo $sql."<br>";
	refactura($idfactura);
}

function deleteCabezera($idfactura) {
	$sql = "update sgm_cabezera set ";
	$sql = $sql."visible=0";
	$sql = $sql." WHERE id=".$idfactura."";
	mysql_query(convert_sql($sql));
}

function deleteCuerpo($id,$idfactura){
	$sql = "delete from sgm_cuerpo WHERE id=".$id;
	mysql_query(convert_sql($sql));
	refactura($idfactura);
	$num = 1;
	$sqll = "select * from sgm_cuerpo where idfactura=".$idfactura." order by linea";
	$resultl = mysql_query(convert_sql($sqll));
	while ($rowl = mysql_fetch_array($resultl)) {
		if ($num == $rowl["linea"]) {
			$num++;
		} else {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."linea=".$num;
			$sql = $sql." WHERE id=".$rowl["id"]."";
			mysql_query(convert_sql($sql));
			$num++;
		}
	}
	$data = date("Y-m-d");
	$hora = date("H:i:s");
	$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
	$sqlf = $sqlf."values (";
	$sqlf = $sqlf."".$_GET["id"]."";
	$sqlf = $sqlf.",".$userid;
	$sqlf = $sqlf.",'".$data."'";
	$sqlf = $sqlf.",'".$hora."'";
	$sqlf = $sqlf.")";
	mysql_query(convert_sql($sqlf));
}

function insertFunction ($tabla,$camposInsert,$datosInsert){
	$sql = "insert into ".$tabla." (".$camposInsert.")";
	$sql = $sql."values (";
	for ($i=0;$i<=(count($datosInsert)-1);$i++){
		if ($i == 0) {
			$sql = $sql."";
		} else {
			$sql = $sql.",";
		}
		$sql = $sql."'".comillas($datosInsert[$i])."'";
	}
	$sql = $sql.")";
	mysql_query(convert_sql($sql));
	echo $sql;
}

function updateFunction ($tabla,$id,$camposUpdate,$datosUpdate){
	$sql = "update ".$tabla." set ";
	for ($i=0;$i<=(count($datosUpdate)-1);$i++){
		if ($i == 0) {
			$sql = $sql."";
		} else {
			$sql = $sql.",";
		}
		$sql = $sql.$camposUpdate[$i]."='".comillas($datosUpdate[$i])."'";
	}
	$sql = $sql." WHERE id=".$id."";
	mysql_query(convert_sql($sql));
	echo $sql;
}

function deleteFunction ($tabla,$id){
	$sql = "delete from ".$tabla." WHERE id=".$id;
	mysql_query(convert_sql($sql));
}
?>