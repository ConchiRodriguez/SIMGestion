<?php
error_reporting(~E_ALL);


function mostrarContrato ($id_contrato,$id_cliente,$sop_delete_serv,$sop_delete_fact){
	global $db,$dbhandle,$option,$soption,$ssoption,$Numero,$Contrato,$Volver,$Tipo,$Cliente,$Final,$Descripcion,$Fecha,$Inicio,$Fin,$Responsable_cliente,$Responsable_tecnico,$Editar,$Anadir,$Desactivar,$Activar,$Renovar,$Facturas,$Prevision,$Concepto,$Importe,$Modificar;

	if ($id_cliente > 0){ $contrato_adress = $id_cliente."&id_con=".$id_contrato;} else { $contrato_adress = $id_contrato;}
	$contract = $id_contrato;
	
	if ($ssoption == 1) {
		echo $contract;
		$camposUpdate = array("num_contrato","id_contrato_tipo","id_cliente","id_cliente_final","fecha_ini","fecha_fin","descripcion","id_responsable","id_tecnico");
		$datosUpdate = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"]);
		updateFunction ("sgm_contratos",$_POST["id_contrato"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 5) {
		$camposUpdate = array("activo");
		$datosUpdate = array("0");
		updateFunction ("sgm_contratos",$_POST["id_contrato"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 6) {
		$camposUpdate = array("activo");
		$datosUpdate = array("1");
		updateFunction ("sgm_contratos",$_POST["id_contrato"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 7) {
		$sqln = "select num_contrato from sgm_contratos where visible=1 order by num_contrato desc";
		$resultn = mysqli_query($dbhandle,convertSQL($sqln));
		$rown = mysqli_fetch_array($resultn);
		$numeroc = ($rown["num_contrato"]+ 1);
		$sqlcc = "select * from sgm_contratos where visible=1 and id=".$_POST["id_contrato"]."";
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		$ini = date("U",strtotime($rowcc["fecha_fin"].""));
		$inici = $ini+86400;
		$fecha_inici = date("Y-m-d", $inici);
		$fin = $inici+31536000;
		$fecha_fin = date("Y-m-d", $fin);
		if ($rowcc){
			$camposInsert = "id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico,id_contrato";
			$datosInsert = array($rowcc["id_contrato_tipo"],$rowcc["id_cliente"],$rowcc["id_cliente_final"],$numeroc,$fecha_inici,$fecha_fin,$rowcc["descripcion"],$rowcc["id_responsable"],$rowcc["id_tecnico"],$_POST["id_contrato"]);
			insertFunction ("sgm_contratos",$camposInsert,$datosInsert);
			$camposUpdate = array("renovado");
			$datosUpdate = array("1");
			updateFunction ("sgm_contratos",$_POST["id_contrato"],$camposUpdate,$datosUpdate);

			$sqlc = "select id from sgm_contratos where num_contrato='".$numeroc."'";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			
			$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_POST["id_contrato"];
			$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
			while ($rowcs = mysqli_fetch_array($resultcs)) {
				$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email,funcion";
				$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"],$_POST["funcion"]);
				insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
			}

			$sqlca = "select id,fecha,fecha_prevision,id_cliente from sgm_cabezera where visible=1 and id_contrato=".$_POST["id_contrato"];
			$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
			while ($rowca = mysqli_fetch_array($resultca)) {
				$datosInsert = array('fecha' => $rowca["fecha"], 'fecha_prevision' => $rowca["fecha_prevision"], 'id_cliente' => $rowca["id_cliente"], 'id_contrato' => $rowc["id"]);
				insertCabezera($datosInsert);
				$sqlcab = "select id from sgm_cabezera where visible=1 and id_contrato=".$rowc["id"]." order by id desc";
				$resultcab = mysqli_query($dbhandle,convertSQL($sqlcab));
				$rowcab = mysqli_fetch_array($resultcab);
				$sqlcu = "select * from sgm_cuerpo where idfactura=".$rowca["id"];
				$resultcu = mysqli_query($dbhandle,convertSQL($sqlcu));
				while ($rowcu = mysqli_fetch_array($resultcu)) {
#						insertCuerpo($rowcab["id"],1,0,$rowcu["nombre"],0,$rowcu["total"],1,$rowcu["fecha_prevision"],0,0,$rowcu["fecha_prevision_propia"]);
					$camposInsert = "idfactura,nombre,pvp,unidades,fecha_prevision,fecha_prevision_propia,total";
					$datosInsert = array($rowcab["id"],$rowcu["nombre"],$rowcu["pvp"],1,$rowcu["fecha_prevision"],$rowcu["fecha_prevision"],$rowcu["total"]);
					insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
					refactura($rowcab["id"]);
				}
			}

			$sqlco = "select id from sgm_contrasenyes where visible=1 and id_contrato=".$_POST["id_contrato"];
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				$camposUpdate = array("id_contrato");
				$datosUpdate = array($rowc["id"]);
				updateFunction ("sgm_contrasenyes",$rowco["id"],$camposUpdate,$datosUpdate);
			}
		}
	}
	if ($ssoption == 10) {
		$datosInsert = array('fecha' => $_POST["fecha"], 'fecha_prevision' => $_POST["fecha_prevision"], 'id_cliente' => $_POST["id_cliente"], 'id_contrato' => $_POST["id_contrato"]);
		insertCabezera($datosInsert);
#			insertCabezera(0,7,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],$_POST["id_cliente"],$_POST["id_contrato"],0);
		$sql = "select id from sgm_cabezera where visible=1 and id_contrato=".$_POST["id_contrato"]." order by id desc";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$camposInsert = "idfactura,nombre,pvp,unidades,fecha_prevision,fecha_prevision_propia,total";
		$datosInsert = array($row["id"],$_POST["concepto"],$_POST["importe"],1,$_POST["fecha_prevision"],$_POST["fecha_prevision"],$_POST["importe"]);
		insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
		refactura($row["id"]);
#			insertCuerpo($row["id"],1,0,$_POST["concepto"],0,$_POST["importe"],1,$_POST["fecha_prevision"],0,0,$_POST["fecha_prevision"]);
	}
	if ($ssoption == 11) {
		$sql = "select fecha_prevision from sgm_cabezera where visible=1 and id=".$_GET["id_fact"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["fecha_prevision"] != $_POST["fecha_prevision"]){
			$camposInsert = "id_factura,id_usuario,fecha_ant,data";
			$datosInsert = array($_GET["id_fact"],$userid,$row["fecha_prevision"],$_POST["fecha_prevision"]);
			insertFunction ("sgm_factura_canvi_data_prevision",$camposInsert,$datosInsert);
		}
		$camposUpdate = array("fecha","fecha_prevision");
		$datosUpdate = array($_POST["fecha"],$_POST["fecha_prevision"]);
		updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
		$data = date("Y-m-d");
		$hora = date("H:i:s");
		$camposInsert = "id_factura, id_usuario, data, hora";
		$datosInsert = array($_GET["id_fact"],$userid,$data,$hora);
		insertFunction ("sgm_factura_modificacio",$camposInsert,$datosInsert);
#			updateCabezera($_GET["id_fact"],0,0,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],0,0,$_POST["id_cliente"],$_POST["id_contrato"],0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

		$sql = "select id,fecha_prevision from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$camposUpdate = array("nombre","pvp","fecha_prevision","fecha_prevision_propia","total");
		$datosUpdate = array($_POST["concepto"],$_POST["importe"],$_POST["fecha_prevision"],$_POST["fecha_prevision"],$_POST["importe"]);
		updateFunction ("sgm_cuerpo",$row["id"],$camposUpdate,$datosUpdate);
		if ($row["fecha_prevision"] != $_POST["fecha_prevision"]){
			$fecha = date("Y-m-d");
			$camposInsert = "id_factura,id_usuario,fecha_ant,data,id_cuerpo";
			$datosInsert = array($_GET["id_fact"],$userid,$row["fecha_prevision"],$fecha,$row["id"]);
			insertFunction ("sgm_factura_canvi_data_prevision_cuerpo",$camposInsert,$datosInsert);
		}
#			updateCuerpo($row["id"],$_GET["id_fact"],$row["linea"],$row["codigo"],$_POST["concepto"],$row["pvd"],$_POST["importe"],1,$_POST["fecha_prevision"],$row["id_article"],$row["stock"],$_POST["fecha_prevision"],$row["descuento"],$row["descuento_absoluto"]);
		refactura($_GET["id_fact"]);
	}
	if ($ssoption == 12) {
		deleteFunction("sgm_cabezera",$_GET["id_fact"]);
		$sql = "select id from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		deleteCuerpo($row["id"],$_GET["id_fact"]);
	}

	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		if ($id_contrato != "") {
			echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=1&id=".$contrato_adress."\" method=\"post\">";
			$sqlc = "select * from sgm_contratos where visible=1 and id=".$id_contrato;
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$numeroc = $rowc["num_contrato"];
			echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
		} else {
			echo "<form action=\"index.php?op=".$option."&sop=0&ssop=1\" method=\"post\">";
			$numeroc = 0;
			$sqln = "select num_contrato from sgm_contratos where visible=1 order by num_contrato desc";
			$resultn = mysqli_query($dbhandle,convertSQL($sqln));
			$rown = mysqli_fetch_array($resultn);
			$numeroc = ($rown["num_contrato"]+ 1);
		}
		echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Contrato.": </td><td><input style=\"width:100px\" type=\"Text\" name=\"num_contrato\" value=\"".$numeroc."\"></td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Contrato." ".$Tipo.": </td>";
			echo "<td><select style=\"width:500px\" name=\"id_contrato_tipo\">";
				$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					if ($row["id"] == $rowc["id_contrato_tipo"]){
						echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." - ".$row["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]." - ".$row["descripcion"]."</option>";
					}
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td style=\"text-align:right;\">".$Cliente.": </td>";
			echo "<td><select style=\"width:500px\" name=\"id_cliente\">";
				$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				while ($rowa = mysqli_fetch_array($resulta)) {
					if ($rowa["id"] == $rowc["id_cliente"]){
						echo "<option value=\"".$rowa["id"]."\" selected>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
					} else {
						echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
					}
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td style=\"text-align:right;\">".$Cliente." ".$Final.": </td>";
			echo "<td><select style=\"width:500px\" name=\"id_cliente_final\">";
				$sqlb = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
				$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
				while ($rowb = mysqli_fetch_array($resultb)) {
					if ($rowb["id"] == $rowc["id_cliente_final"]){
						echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
					} else {
						echo "<option value=\"".$rowb["id"]."\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
					}
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td style=\"text-align:right;\">".$Descripcion.": </td><td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\" value=\"".$rowc["descripcion"]."\"></td></tr>";
		if ($id_contrato != "") {
			$date1 = $rowc["fecha_ini"];
			$date2 = $rowc["fecha_fin"];
		} else {
			$date = getdate();
			$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$date2 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
		}
		echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Inicio.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_ini\" value=\"".$date1."\"></td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Fin.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_fin\" value=\"".$date2."\"></td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Responsable_cliente.": </td>";
			echo "<td><select name=\"id_responsable\" style=\"width:150px\">";
			$sqlua = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1";
			$resultua = mysqli_query($dbhandle,convertSQL($sqlua));
			while ($rowua = mysqli_fetch_array($resultua)) {
					if ($rowua["id"] == $rowc["id_responsable"]){
						echo "<option value=\"".$rowua["id"]."\" selected>".$rowua["usuario"]."</option>";
					} else {
						echo "<option value=\"".$rowua["id"]."\">".$rowua["usuario"]."</option>";
					}
			}
			echo "</select></td>";
		echo "</tr>";
		echo "<tr><td style=\"text-align:right;\">".$Responsable_tecnico.": </td>";
			echo "<td><select name=\"id_tecnico\" style=\"width:150px\">";
			$sqluu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1";
			$resultuu = mysqli_query($dbhandle,convertSQL($sqluu));
			while ($rowuu = mysqli_fetch_array($resultuu)) {
					if ($rowuu["id"] == $rowc["id_tecnico"]){
						echo "<option value=\"".$rowuu["id"]."\" selected>".$rowuu["usuario"]."</option>";
					} else {
						echo "<option value=\"".$rowuu["id"]."\">".$rowuu["usuario"]."</option>";
					}
			}
			echo "</select></td>";
		echo "</tr>";
		if ($_GET["edit"] == "") {
			if ($id_contrato != "") {
				echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
			} else {
				echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			}
		}
		echo "</form>";
		if ($id_contrato != "") {
			if ($rowc["activo"] == 1) {
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=5&id=".$contrato_adress."\" method=\"post\">";
				echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Desactivar."\"></td>";
			} else {
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=6&id=".$contrato_adress."\" method=\"post\">";
				echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Activar."\"></td>";
			}
			echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
			echo "</form>";
		}
		if ($id_contrato != "") {
			if ($rowc["renovado"] == 0) {
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=7&id=".$contrato_adress."\" method=\"post\">";
				echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"renovar".$Renovar."\"></td>";
				echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
				echo "</form>";
			} else {
				echo "<td></td><td></td>";
			}
		}
	echo "</table>";
	echo "<br><br>";

	if ($id_contrato != "") {
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<caption>".$Facturas."</caption>";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Fecha." ".$Prevision."</th>";
				echo "<th>".$Concepto."</th>";
				echo "<th>".$Importe."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
			echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=10&id=".$contrato_adress."\" method=\"post\">";
				echo "<td></td>";
				echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowc["id_cliente"]."\">";
				echo "<input type=\"hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
				$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
				echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$date."\"></td>";
				echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$date."\"></td>";
				echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\"></td>";
				echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"1\" step=\"any\" name=\"importe\" value=\"0\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select id,fecha,fecha_prevision from sgm_cabezera where visible=1 and id_contrato=".$id_contrato."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlcu = "select nombre,pvp from sgm_cuerpo where idfactura=".$row["id"]."";
				$resultcu = mysqli_query($dbhandle,convertSQL($sqlcu));
				$rowcu = mysqli_fetch_array($resultcu);
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$option."&sop=".$sop_delete_fact."&id=".$id_contrato."&id_fact=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=11&id=".$contrato_adress."&id_fact=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowc["id_cliente"]."\">";
					echo "<input type=\"hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$row["fecha"]."\"></td>";
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\"></td>";
					echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\" value=\"".$rowcu["nombre"]."\"></td>";
					echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"1\" step=\"any\" name=\"importe\" value=\"".$rowcu["pvp"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "<br><br><br>";
		mostrarServicio($id_contrato,$sop_delete_serv);
	}
}

?>