<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";  }
if (($option == 1003) AND ($autorizado == true)) {
	$sqldiv = "select * from sgm_divisas where predefinido=1";
	$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
	$rowdiv = mysqli_fetch_array($resultdiv);
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Facturacion."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if (($soption >= 0) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=0\" class=".$class.">".$Facturacion."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=200\" class=".$class.">".$Buscar." ".$Facturas."</a></td>";
					if ($soption == 300) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=300\" class=".$class.">".$Impresion."</a></td>";
					if (($soption >= 400) and ($soption < 500)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=400\" class=".$class.">".$Resumenes."</a></td>";
					if (($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=500\" class=".$class.">".$Administrar."</a></td>";
					if ($soption == 600) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=600\" class=".$class.">".$Ayuda."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption >= 0) and ($soption < 200)){
			echo "<table cellpadding=\"1\" cellspacing=\"2\" class=\"lista\">";
				echo "<tr>";
				$sqltipos2 = "select id,tipo from sgm_factura_tipos where visible=1 order by orden,descripcion";
				$resulttipos2 = mysqli_query($dbhandle,convertSQL($sqltipos2));
				while ($rowtipos2 = mysqli_fetch_array($resulttipos2)) {
					$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
					$resultpermiso = mysqli_query($dbhandle,convertSQL($sqlpermiso));
					$rowpermiso = mysqli_fetch_array($resultpermiso);
					if ($rowpermiso["total"] > 0) { 
						if (($rowtipos2["id"] == $_GET["id"]) or ($rowtipos2["id"] == $_GET["id_tipo"])) {$class2 = "menu_select";} else {$class2 = "menu";}
						echo "<td class=".$class2."><a href=\"index.php?op=1003&sop=0&id=".$rowtipos2["id"]."\" class=".$class2.">".$rowtipos2["tipo"]."</a></td>";
					} else { echo "<td style=\"background-color:black;color:white;border:1px solid black;text-align:center;vertical-align:middle;height:20px;width:150px;\"><a href=\"index.php?op=1003&sop=0\" class=\"menu\">".$rowtipos2["tipo"]."</a></td>"; }
				}
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if (($soption == 0) or ($soption == 200)) {
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id"].$_POST["id_tipo"];
		$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
		$rowtipos = mysqli_fetch_array($resulttipos);
		if ($soption == 200) {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<th>".$Tipo."</th>";
					echo "<th>".$Cliente."</th>";
					echo "<th>".$Pedido." ".$Cliente."</th>";
					echo "<th>".$Contrato."</th>";
					echo "<th>".$Desde."</th>";
					echo "<th>".$Hasta."</th>";
					echo "<th>".$Codigo."</th>";
					echo "<th>".$Articulo."</th>";
					echo "<th>".$Historico."</th>";
					echo "<th></th>";
				echo "</tr><tr style=\"background-color:silver;\">";
					echo "<form action=\"index.php?op=1003&sop=200\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos2["id"]."\">";
					echo "<td style=\"width:10%\">";
						echo "<select name=\"id_tipo\">";
						$sqlft = "select id,tipo from sgm_factura_tipos where visible=1 order by orden,descripcion";
						$resultft = mysqli_query($dbhandle,convertSQL($sqlft));
						echo "<option value=\"0\">".$Todas."</option>";
						while ($rowft = mysqli_fetch_array($resultft)) {
							if ($_POST["id_tipo"] == $rowft["id"]){
								echo "<option value=\"".$rowft["id"]."\" selected>".$rowft["tipo"]."</option>";
							} else {
								echo "<option value=\"".$rowft["id"]."\">".$rowft["tipo"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td style=\"width:30%\">";
						echo "<select name=\"id_cliente\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_cliente"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td style=\"width:5%;\"><input type=\"Text\" style=\"width:100%;\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\"></td>";
					echo "<td style=\"width:15%\">";
						echo "<select name=\"id_contrato\">";
						echo "<option value=\"0\">".$Todos."</option>";
						$sql1a = "select id,descripcion,id_cliente from sgm_contratos where visible=1 and activo=1";
						$result1a = mysqli_query($dbhandle,convertSQL($sql1a));
						while ($row1a = mysqli_fetch_array($result1a)) {
							$sqlcl = "select alias from sgm_clients where id=".$row1a["id_cliente"];
							$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
							$rowcl = mysqli_fetch_array($resultcl);
							if ($_POST["id_contrato"] == $row1a["id"]) { 
								echo "<option value=\"".$row1a["id"]."\" selected>(".$rowcl["alias"].")".$row1a["descripcion"]."</option>";
							} else {
								echo "<option value=\"".$row1a["id"]."\">(".$rowcl["alias"].")".$row1a["descripcion"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					$fecha = getdate();
					if ($_POST["data_desde1"]){
						$data = $_POST["data_desde1"];
						$data1 = $_POST["data_fins1"];
					} else {
						$data = cambiarFormatoFechaDMY(date("Y-m-d"));
						$data1 = $data;
					}
					if ($_POST["data_desde2"]){
						$data2 = $_POST["data_desde2"];
						$data3 = $_POST["data_fins2"];
					} else {
						$data2 = cambiarFormatoFechaDMY(date("Y-m-d", mktime(0,0,0,$fecha["mon"] ,$fecha["mday"], $fecha["year"])));
						$data3 = $data2;
					}
					echo "<td><input type=\"Text\" style=\"width:100%;\" name=\"data_desde1\" value=\"".$data."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:100%;\" name=\"data_fins1\" value=\"".$data1."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:100%;\" name=\"codigo\" value=\"".$_POST["codigo"]."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:100%;\" name=\"articulo\" value=\"".$_POST["articulo"]."\"></td>";
					echo "<td>";
						echo "<select name=\"hist\">";
						echo "<option value=\"0\">-</option>";
							if ($_POST["hist"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			echo "<br>";
		}
		if (($_GET["id"] != "") or $_POST["id_tipo"] or $_POST["id_cliente"] or $_POST["ref_cli"] or $_POST["data_desde1"] or $_POST["data_fins1"] or $_POST["codigo"] or $_POST["articulo"] or $_POST["hist"] or $_POST["id_contrato"]){
			if ($ssoption == 1) {
				$sqlcc = "select count(*) as total from sgm_cabezera where visible=1 and numero=".$_POST["numero"]." and tipo=".$_POST["tipo"];
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				$rowcc = mysqli_fetch_array($resultcc);
				if ($rowcc["total"] == 0){
					$fecha = cambiarFormatoFechaYMD($_POST["fecha"]);
					if ($_POST["fecha_prevision"] > 0) {
						$fecha_prev = cambiarFormatoFechaYMD($_POST["fecha_prevision"]);
					} else {
						$fecha_prev = cambiarFormatoFechaYMD($_POST["fecha"]);
					}
					if ($_POST["fecha_vencimiento"] > 0) {
						$fecha_ven = cambiarFormatoFechaYMD($_POST["fecha_vencimiento"]);
					} else {
						$fecha_ven = cambiarFormatoFechaYMD($_POST["fecha"]);
					}
					$datosInsert = array('numero'=>$_POST["numero"],'tipo'=>$_POST["tipo"],'subtipo'=>$_POST["subtipo"],'version'=>$_POST["version"],'numero_rfq'=>$_POST["numero_rfq"],'numero_cliente'=>$_POST["numero_cliente"],'fecha'=>$fecha,'fecha_prevision'=>$fecha_prev,'fecha_vencimiento'=>$fecha_ven,'id_cliente'=>$_POST["id_cliente"]);
					insertCabezera($datosInsert);
				}
			}
			if ($ssoption == 2) {
				list($id_tipus,$cerrar) = explode(',', $_POST["id_tipus"]);

				$camposUpdate = array("cerrada");
				$datosUpdate = array($cerrar);
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);

				$sqlfa = "select numero from sgm_cabezera where visible=1 and tipo=".$id_tipus." order by numero desc";
				$resultfa = mysqli_query($dbhandle,convertSQL($sqlfa));
				$rowfa = mysqli_fetch_array($resultfa);
				$sqla = "select * from sgm_cabezera where visible=1 and id=".$_GET["id_fact"];
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				$rowa = mysqli_fetch_array($resulta);
				$sqlfav = "select version from sgm_cabezera where visible=1 and numero=".$rowa["numero"]." order by version desc";
				$resultfav = mysqli_query($dbhandle,convertSQL($sqlfav));
				$rowfav = mysqli_fetch_array($resultfav);
				$sqlf = "select presu from sgm_factura_tipos where visible=1 and id=".$id_tipus;
				$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
				$rowf = mysqli_fetch_array($resultf);
				if (($rowa["tipo"] == $id_tipus) and ($rowf["presu"] == 1)){
					$numero = $rowa["numero"];
					$version = ($rowfav["version"] + 1);
				} else {
					$numero = ($rowfa["numero"]+1);
					$version = $rowfav["version"];
				}
				$datosInsert = array('id_contrato'=>$rowa["id_contrato"],'id_origen'=>$rowa["id"],'numero'=>$numero,'version'=>$version,'tipo'=>$id_tipus,'subtipo'=>$rowa["subtipo"],'numero_cliente'=>$rowa["numero_cliente"],'fecha'=>cambiarFormatoFechaYMD($_POST["data"]),'id_cliente'=>$rowa["id_cliente"],'notas'=>$rowa["notas"],'total_forzado'=>$rowa["total_forzado"],'recibos'=>$rowa["recibos"],'confirmada'=>$rowa["confirmada"],'confirmada_cliente'=>$rowa["confirmada_cliente"],'fecha_prevision'=>cambiarFormatoFechaYMD($_POST["data"]),'fecha_entrega'=>cambiarFormatoFechaYMD($_POST["data"]),'fecha_vencimiento'=>cambiarFormatoFechaYMD($_POST["data"]),'nombre'=>$rowa["nombre"],'nif'=>$rowa["nif"],'direccion'=>$rowa["direccion"],'poblacion'=>$rowa["poblacion"],'cp'=>$rowa["cp"],'provincia'=>$rowa["provincia"],'id_pais'=>$rowa["id_pais"],'mail'=>$rowa["mail"],'telefono'=>$rowa["telefono"],'edireccion'=>$rowa["edireccion"],'epoblacion'=>$rowa["epoblacion"],'ecp'=>$rowa["ecp"],'eprovincia'=>$rowa["eprovincia"],'eid_pais'=>$rowa["eid_pais"],'onombre'=>$rowa["onombre"],'onif'=>$rowa["onif"],'odireccion'=>$rowa["odireccion"],'opoblacion'=>$rowa["opoblacion"],'ocp'=>$rowa["ocp"],'oprovincia'=>$rowa["oprovincia"],'omail'=>$rowa["omail"],'otelefono'=>$rowa["otelefono"],'subtotal'=>$rowa["subtotal"],'descuento'=>$rowa["descuento"],'descuento_absoluto'=>$rowa["descuento_absoluto"],'subtotaldescuento'=>$rowa["subtotaldescuento"],'iva'=>$rowa["iva"],'total'=>$rowa["total"],'id_user'=>$rowa["id_user"],'id_tipo_pago'=>$rowa["id_tipo_pago"],'print'=>$rowa["print"],'id_divisa'=>$rowa["id_divisa"],'div_canvi'=>$rowa["div_canvi"],'imp_exp'=>$rowa["imp_exp"],'retenciones'=>$rowa["retenciones"]);
				insertCabezera($datosInsert);

				$sqlfac = "select id from sgm_cabezera where visible=1 order by id desc";
				$resultfac = mysqli_query($dbhandle,convertSQL($sqlfac));
				$rowfac = mysqli_fetch_array($resultfac);

				$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id_fact"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)){
					if ($_POST["trasp"] == 2) {
						if ($_POST["traspasar_".$row["id"]] == true) {
							if ((($row["descuento"] != "") OR ($_POST["descuento"] != 0)) AND (($row["descuento_absoluto"] != "") OR ($row["descuento_absoluto"] != 0)))  {
								if  ($row["descuento_absoluto"] == 0) {
									$total = ($row["pvp"]-($row["pvp"]/100)*$row["descuento"])*$_POST["unitats_".$row["id"].""];
									$descuento = $row["descuento"];
									$descuento_absoluto = 0;
								} else {
									$total = ($row["pvp"]- $row["descuento_absoluto"] )* $_POST["unitats_".$row["id"].""];
									$descuento = 0;
									$descuento_absoluto = $row["descuento_absoluto"];
								}
							} else {
								$total = $_POST["unitats_".$row["id"].""] * $row["pvp"];
							}
							$camposInsert = "id_origen,linea,id_cuerpo,idfactura,id_estado,fecha_prevision,fecha_entrega,facturado,id_facturado,codigo,nombre,pvd,pvp,unidades,descuento,descuento_absoluto,subtotaldescuento,total,notes,bloqueado,id_article,stock,prioridad,controlcalidad,id_tarifa,tarifa";
							$datosInsert = array($row["id"],$row["linea"],$row["id_cuerpo"],$rowfac["id"],$row["id_estado"],$row["fecha_prevision"],$row["fecha_entrega"],$row["facturado"],$row["id_facturado"],$row["codigo"],$row["nombre"],$row["pvd"],$row["pvp"],$_POST["unitats_".$row["id"]],$descuento,$descuento_absoluto,$row["subtotaldescuento"],$total,$row["notes"],$row["bloqueado"],$row["id_article"],$row["stock"],$row["prioridad"],$row["controlcalidad"],$row["id_tarifa"],$row["tarifa"]);
							insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
						}
					}
					if ($_POST["trasp"] == 1) {
						$camposInsert = "id_origen,linea,id_cuerpo,idfactura,id_estado,fecha_prevision,fecha_entrega,facturado,id_facturado,codigo,nombre,pvd,pvp,unidades,descuento,descuento_absoluto,subtotaldescuento,total,notes,bloqueado,id_article,stock,prioridad,controlcalidad,id_tarifa,tarifa";
						$datosInsert = array($row["id"],$row["linea"],$row["id_cuerpo"],$rowfac["id"],$row["id_estado"],$row["fecha_prevision"],$row["fecha_entrega"],$row["facturado"],$row["id_facturado"],$row["codigo"],$row["nombre"],$row["pvd"],$row["pvp"],$row["unidades"],$row["descuento"],$row["descuento_absoluto"],$row["subtotaldescuento"],$row["total"],$row["notes"],$row["bloqueado"],$row["id_article"],$row["stock"],$row["prioridad"],$row["controlcalidad"],$row["id_tarifa"],$row["tarifa"]);
						insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
					}
					if ($id_tipus != $rowa["tipo"]){
						$sqlc = "select id from sgm_cuerpo order by id desc";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						$rowc = mysqli_fetch_array($resultc);
						$sqlf = "select * from sgm_files where id_elemento=".$row["id"];
						$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
						while ($rowf = mysqli_fetch_array($resultf)){
							$camposInsert = "id_tipo,name,type,size,tipo_id_elemento,id_elemento";
							$datosInsert = array($rowf["id_tipo"],$rowf["name"],$rowf["type"],$rowf["size"],$rowf["tipo_id_elemento"],$rowc["id"]);
							insertFunction ("sgm_files",$camposInsert,$datosInsert);
						}
					}
				}
				refactura($rowfac["id"]);
			}
			if ($ssoption == 3) {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
				$sqlc = "select id from sgm_cuerpo where idfactura=".$_GET["id_fact"];
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				while ($rowc = mysqli_fetch_array($resultc)){
					$sql = "update sgm_files set ";
					$sql = $sql."visible = 0";
					$sql = $sql." WHERE id_elemento=".$rowc["id"]."";
					mysqli_query($dbhandle,convertSQL($sql));
				}
			}
			if ($ssoption == 4) {
				$camposUpdate = array("aprovado");
				$datosUpdate = array("1");
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
			}
			if ($ssoption == 5) {
				$camposUpdate = array("aprovado");
				$datosUpdate = array("0");
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
			}
			if ($ssoption == 8) {
				$camposUpdate = array("cerrada");
				$datosUpdate = array("1");
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
			}
			if ($ssoption == 9) {
				$camposUpdate = array("cerrada");
				$datosUpdate = array("0");
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
			}
			if ($ssoption == 10) {
				$any = date("Y")-1;
				$sqlcs = "select id from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." and fecha<='".$any."-12-31' and cerrada=0";
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)){
					$camposUpdate = array("cerrada");
					$datosUpdate = array("1");
					updateFunction ("sgm_cabezera",$rowcs["id"],$camposUpdate,$datosUpdate);
				}
			}
			if (($_GET["hist"] == 1) and ($_GET["id"] != "")){
				echo boton(array("op=1003&sop=0&id=".$rowtipos["id"]),array($Actual));
			} elseif (($_GET["hist"] == 0) and ($_GET["id"] != "")){
				echo boton(array("op=1003&sop=0&id=".$rowtipos["id"]."&hist=1"),array($Historico));
			}
			if ($rowtipos["contabilidad"] == -1){
				echo boton(array("op=1003&sop=0&ssop=10&id=".$_GET["id"]),array($Cierre_ano_ant));
			}
			$tds2 = 3;
			echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<th></th>";
					
					if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
						echo "<th style=\"min-width:20px;width:30px;\">Docs</th>";
					} else { echo "<td></td>"; }
					echo "<th style=\"min-width:60px;width:80px;\">".$Numero."</th>";
					if ($rowtipos["presu"] == 1) { echo "<th>Ver.</th>";} else { echo "<td></td>"; }
					echo "<th style=\"min-width:60px;width:80px;\">".$Fecha."</th>";
					if ($rowtipos["v_fecha_prevision"] == 1) { echo "<th style=\"min-width:70px;width:80px;\">".$Prevision."</th>";} else { echo "<td></td>"; }
					if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<th style=\"min-width:70px;width:80px;\">".$Vencimiento."</th>";} else { echo "<td></td>"; }
					if ($rowtipos["v_numero_cliente"] == 1) { echo "<th style=\"min-width:80px;width:80px;\">Ref. Ped. ".$Cliente."</th>";} else { echo "<td></td>"; }
					if ($rowtipos["v_rfq"] == 1) { echo "<th style=\"min-width:80px;width:80px;\">".$Numero." RFQ</th>";} else { echo "<td></td>"; }
					if ($rowtipos["tpv"] == 0) { echo "<th class=\"factur\">".$Cliente."</th>";} else { echo "<td></td>"; }
					if ($rowtipos["v_subtipos"] == 1) { echo "<th style=\"min-width:100px;width:80px;\">".$Subtipo."</th>";} else { echo "<td></td>"; }
					echo "<th style=\"text-align:right;width:100px;\">".$Subtotal."</th>";
					echo "<th style=\"text-align:right;width:100px;\">".$Total."</th>";
					if ($rowtipos["v_recibos"] == 1)  {echo "<th style=\"text-align:right;width:100px;\">".$Pendiente."</th>";} else { echo "<td></td>"; }
					if ($_GET["id"]) {$link = "&id=".$_GET["id"];} else {$link = "";}
					if ($_GET["hist"]) {$link .= "&hist=".$_GET["hist"];} else {$link .= "";}
					if ($_GET["filtra"] == 0){
						echo "<form action=\"index.php?op=1003&sop=".$_GET["sop"]."&filtra=1".$link."\" method=\"post\">";
					} else {
						echo "<form action=\"index.php?op=1003&sop=".$_GET["sop"]."&filtra=0".$link."\" method=\"post\">";
					}
					echo "<input type=\"Hidden\" name=\"id_tipo\" value=\"".$_POST["id_tipo"]."\">";
					echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
					echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
					echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
					echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
					echo "<input type=\"Hidden\" name=\"codigo\" value=\"".$_POST["codigo"]."\">";
					echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
					echo "<input type=\"Hidden\" name=\"hist\" value=\"".$_POST["hist"]."\">";
					echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$_POST["id_contrato"]."\">";
					echo "<input type=\"Hidden\" name=\"todo\" value=\"1\">";
					if ($rowtipos["aprovado"] == 1)  {$tds2++;}
					if ($rowtipos["v_recibos"] == 1)  {$tds2++;}
					if ($_GET["filtra"] == 0){
						echo "<td class=\"submit\" colspan=\"".$tds2."\" style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"".$Desplegar." ".$Todo."\"></td>";
					} else {
						echo "<td class=\"submit\" colspan=\"".$tds2."\" style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"".$Plegar." ".$Todo."\"></td>";
					}
					echo "</form>";
				echo "</tr>";
			if ($soption != 200){
				echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=0&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
					$sql = "select numero from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." order by numero desc";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					$numero = $row["numero"] + 1;
					echo "<td style=\"width:0px;\"></td>";
					echo "<td style=\"width:0px;\"></td>";
					echo "<td><input type=\"Text\" name=\"numero\" value=\"".$numero."\" style=\"text-align:right;width:100%\"></td>";
					if ($rowtipos["presu"] == 1) { 
						echo "<td style=\"text-align:center\"><input type=\"Text\" name=\"version\" value=\"0\" style=\"width:100%\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"version\" value=\"0\">";
						echo "<td></td>";
					}
					$date1 = date("Y-m-d");
					echo "<td><input type=\"Text\" name=\"fecha\" style=\"text-align:right;width:100%\" value=\"".cambiarFormatoFechaDMY($date1)."\"></td>";
				### CALCULO DE LA FECHA DE PREVISION DE ENTREGA
					$suma = $rowtipos["v_fecha_prevision_dias"];
					$a = date("Y", strtotime($date1)); 
					$m = date("n", strtotime($date1)); 
					$d = date("j", strtotime($date1)); 
					$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d+$suma, $a));
					$fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$suma, $a));
					if ($rowtipos["v_fecha_prevision"] == 1) { 
						echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:100%\" value=\"".cambiarFormatoFechaDMY($fecha_prevision)."\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"fecha_prevision\" value=\"0\">";
						echo "<td></td>";
					}
					if ($rowtipos["v_fecha_vencimiento"] == 1) { 
						echo "<td><input type=\"Text\" name=\"fecha_vencimiento\" style=\"width:100%\" value=\"".cambiarFormatoFechaDMY($fecha_vencimiento)."\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"fecha_vencimiento\" value=\"0\">";
						echo "<td></td>";
					}
					if ($rowtipos["v_numero_cliente"] == 1) { 
						echo "<td><input type=\"Text\" name=\"numero_cliente\" style=\"width:100%\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"numero_cliente\">";
						echo "<td></td>";
					}
					if ($rowtipos["v_rfq"] == 1) { 
						echo "<td><input type=\"Text\" name=\"numero_rfq\" style=\"width:100%\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"numero_rfq\">";
						echo "<td></td>";
					}
					if ($rowtipos["tpv"] == 0) { 
						echo "<td>";
							echo "<select name=\"id_cliente\" style=\"width:100%;\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 ";
							$sql = $sql."order by nombre";
							$result = mysqli_query($dbhandle,convertSQL($sql));
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
							echo "</select>";
						echo "</td>";
					}
					if ($rowtipos["tpv"] == 1) { 
						echo "<input type=\"hidden\" name=\"id_cliente\" value=\"0\">";
						echo "<td></td>";
					}
					if ($rowtipos["v_subtipos"] == 1) {
						echo "<td>";
							echo "<select style=\"width:100px\" name=\"subtipo\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select id,subtipo from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
							$result = mysqli_query($dbhandle,convertSQL($sql));
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value=\"".$row["id"]."\">".$row["subtipo"]."</option>";
							}
							echo "</select>";
						echo "</td>";
					} else {
						echo "<input type=\"hidden\" name=\"subtipo\" value=\"0\">";
						echo "<td></td>";
					}
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
					echo "<td style=\"width:0px;\"></td>";
					echo "<td style=\"width:0px;\"></td>";
					echo "</form>";
				echo "</tr>";
			}
				$totalSensePagar = 0;
				$totalSenseIVA = 0;
				$totalPagat = 0;
				$totalArticles = 0;
				$sql = "select * from sgm_cabezera where visible=1";
				if (($rowtipos["id"] != 0)) { $sql = $sql." AND tipo=".$rowtipos["id"]; }
				if (($soption == 200) AND ($_POST["id_cliente"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente"]; }
				if (($soption == 200) AND ($_POST["id_cliente2"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente2"]; }
				if (($soption == 200) AND ($_POST["id_contrato"] != 0)) { $sql = $sql." AND id_contrato=".$_POST["id_contrato"]; }
				if (($soption == 200) AND ($_POST["ref_cli"] != '')) { $sql = $sql." AND numero_cliente like '%".$_POST["ref_cli"]."%'"; }
				if (($soption == 200) AND ($_GET["fecha"] != 0)) { $sql = $sql." AND fecha='".date("Y-m-d", $_GET["fecha"])."'"; }
				if (($soption == 200) AND ($_POST["data_desde1"] != 0)) { $sql = $sql." AND fecha>='".cambiarFormatoFechaDMY($_POST["data_desde1"])."'"; }
				if (($soption == 200) AND ($_POST["data_fins1"] != 0)) { $sql = $sql." AND fecha<='".cambiarFormatoFechaDMY($_POST["data_fins1"])."'"; }
				$sql = $sql." order by numero desc,version desc,fecha desc";
#echo $sql;
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					echo mostrarFacturas($row);
				}
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr>";
					echo "<td colspan=\"11\" style=\"text-align:right;\"><strong>".$Total."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".number_format($totalSenseIVA,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".number_format($totalSensePagar,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";
					if ($rowtipos["v_recibos"] == 1)  {echo "<td style=\"text-align:right;\"><strong>".number_format($totalPagat,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";}
					echo "<td></td>";
					if ($filtra == 1)  {echo "<td><strong>".$Total." ".$Articulo."</strong></td><td style=\"text-align:left;\"><strong>".number_format($totalArticles,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";}
				echo "</tr>";
			echo "</table>";
		}
	}

	if ($soption == 10) {
		$sqlf = "select id,tipo,aprovado from sgm_factura_tipos where id=".$_GET["id"];
		$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
		$rowf = mysqli_fetch_array($resultf);

		echo "<h4>".$Opciones."</h4>";
		echo boton_volver("&laquo; ".$Volver);
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\">";
						echo "<tr>";
							echo "<th style=\"width:400px\">".$Eliminar." ".$rowf["tipo"]."</th>";
						echo "</tr><tr>";
							echo "<td style=\"width:400px\">".$ayudaFacturaEliminar."</td>";
						echo "</tr>";
					echo "</table><table>";
						echo "<tr>";
							echo boton_form("op=1003&sop=11&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"],$Eliminar);
						echo "</tr><tr>";
							echo "<td>&nbsp;</td>";
						echo "</tr>";
					echo "</table></center>";
				echo "</td>";
			$sql = "select aprovado from sgm_cabezera where id=".$_GET["id_fact"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
				echo "<td style=\"vertical-align:top;Width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\">";
						echo "<tr>";
							echo "<th style=\"width:400px\">".$Traspaso."</th>";
						echo "</tr><tr>";
							echo "<td style=\"width:400px\"></td>";
						echo "</tr>";
					echo "</table><table>";
						echo "<tr>";
							echo boton_form("op=1003&sop=10&ssop=1&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"],$Completo);
							echo boton_form("op=1003&sop=12&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"],$Parcial);
						echo "</tr>";
					echo "</table>";
					echo "<br>";
					if ($ssoption == 1){
						echo "<table style=\"width:400px;background-color:grey;\">";
							echo "<tr>";
								echo "<form action=\"index.php?op=1003&sop=0&ssop=2&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"]."\" method=\"post\">";
								$date = date("d-m-Y");
								echo "<td><input type=\"text\" name=\"data\" value=\"".$date."\" style=\"width:100px\"></td>";
								echo "<td><select name=\"id_tipus\" style=\"width:200px\">";
									echo "<option value=\"".$rowf["id"]."\">".$rowf["tipo"]."</option>";
								$ver = 1;
								if (($rowf["aprovado"] == 1) and ($row["aprovado"] == 0)){ $ver = 0;}
								if ($ver == 1){
									$sqlr = "select id_tipo_d,cerrar from sgm_factura_tipos_relaciones where id_tipo_o=".$_GET["id"];
									$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
									while ($rowr = mysqli_fetch_array($resultr)) {
										$sqld = "select * from sgm_factura_tipos where id=".$rowr["id_tipo_d"];
										$resultd = mysqli_query($dbhandle,convertSQL($sqld));
										$rowd = mysqli_fetch_array($resultd);
										echo "<option value=\"".$rowd["id"].",".$rowr["cerrar"]."\">".$rowd["tipo"]."</option>";
									}
								}
								echo "</select></td>";
								echo "<input type=\"Hidden\" name=\"trasp\" value=\"1\">";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Enviar."\"></td>";
								echo "</form>";
							echo "</tr>";
						echo "</table>";
				echo "</td>";
			}
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 11) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=0&ssop=3&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"],"op=1003&sop=10&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 12) {
		echo "<h4>".$Traspaso." ".$Parcial."</h4>";
		echo boton(array("op=1003&sop=10&id_fact=".$_GET["id_fact"]),array("&laquo; ".$Volver));
		$sql = "select id_cliente,numero,fecha,tipo from sgm_cabezera where visible=1 and id=".$_GET["id_fact"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$sqlc = "select nombre from sgm_clients where visible=1 and id=".$row["id_cliente"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		echo "<table cellpadding=\"5\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\"><th>".$Numero." ".$Factura." : </th><td>".$row["numero"]."</td></tr>";
			echo "<tr style=\"background-color:silver;\"><th>".$Fecha." : </th><td>".$row["fecha"]."</td></tr>";
			echo "<tr style=\"background-color:silver;\"><th>".$Cliente." : </th><td>".$rowc["nombre"]."</td></tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Codigo."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Unidades."</th>";
				echo "<th>".$UnidadesATraspasar."</th>";
				echo "<th>".$Traspasar."</th>";
			echo "</tr>";
		echo "<form action=\"index.php?op=1003&sop=0&ssop=2&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"]."\" method=\"post\">";
		$sqlcu = "select codigo,nombre,unidades,id from sgm_cuerpo where idfactura=".$_GET["id_fact"];
		$resultcu = mysqli_query($dbhandle,convertSQL($sqlcu));
		while ($rowcu = mysqli_fetch_array($resultcu)){
			echo "<tr>";
				echo "<td>".$rowcu["codigo"]."</td>";
				echo "<td>".$rowcu["nombre"]."</td>";
				echo "<td>".$rowcu["unidades"]."</td>";
				echo "<td><input type=\"text\" name=\"unitats_".$rowcu["id"]."\" value=\"".$rowcu["unidades"]."\" style=\"width:100px;\"></td>";
				if (($_POST["traspasar_".$rowcu["id"]] == true) or ($_POST["traspasar_".$rowcu["id"]] == "")) {
					echo "<td style=\"width:50px;text-align:center\"><input name=\"traspasar_".$rowcu["id"]."\" type=\"Checkbox\" checked></td>";
				} else {
					echo "<td style=\"width:50px;text-align:center\"><input name=\"traspasar_".$rowcu["id"]."\" type=\"Checkbox\"></td>";
				}
			echo "</tr>";
		}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				$date = date("Y-m-d");
				echo "<td><input type=\"text\" name=\"data\" value=\"".$date."\" style=\"width:100px\"></td>";
				echo "<td><select name=\"id_tipus\" style=\"width:200px\">";
					$sqlf = "select id,tipo from sgm_factura_tipos where id=".$row["tipo"];
					$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
					$rowf = mysqli_fetch_array($resultf);
					echo "<option value=\"".$rowf["id"]."\">".$rowf["tipo"]."</option>";
					$sqlr = "select id_tipo_d,cerrar from sgm_factura_tipos_relaciones where id_tipo_o=".$_GET["id"];
					$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
					while ($rowr = mysqli_fetch_array($resultr)) {
						$sqld = "select id,tipo from sgm_factura_tipos where id=".$rowr["id_tipo_d"];
						$resultd = mysqli_query($dbhandle,convertSQL($sqld));
						$rowd = mysqli_fetch_array($resultd);
					echo "<option value=\"".$rowd["id"].",".$rowr["cerrar"]."\">".$rowd["tipo"]."</option>";
					}
				echo "</select></td>";
				echo "<input type=\"Hidden\" name=\"trasp\" value=\"2\">";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Enviar."\"></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 20) {
		echo "<h4>".$Impresion." ".$Documentos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Tipo."</th>";
				echo "<th>".$Idioma."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturacion-print-pdf.php?id=".$_GET["id"]."\" target=\"_blank\">";
				echo "<td><select name=\"tipo\" style=\"width:70px\">";
					echo "<option value=\"0\">".$Sobre."</option>";
					echo "<option value=\"1\">".$No_sobre."</option>";
				echo "</select></td>";
				echo "<td><select name=\"idioma\" style=\"width:90px\">";
					$sqli = "select idioma,descripcion,predefinido from sgm_idiomas where visible=1";
					$resulti = mysqli_query($dbhandle,convertSQL($sqli));
					while ($rowi = mysqli_fetch_array($resulti)) {
						if ($rowi["predefinido"] == 1) {
							echo "<option value=\"".$rowi["idioma"]."\" selected>".$rowi["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$rowi["idioma"]."\">".$rowi["descripcion"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
				echo "</form>";
			echo "</tr><tr>";
				echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturacion-print-e.php?id=".$_GET["id"]."\" target=\"_blank\">";
				echo "<td>Facturae</td>";
				echo "<td><select name=\"idioma\" style=\"width:90px\">";
					$sqli = "select idioma,descripcion,predefinido from sgm_idiomas where visible=1";
					$resulti = mysqli_query($dbhandle,convertSQL($sqli));
					while ($rowi = mysqli_fetch_array($resulti)) {
						if ($rowi["predefinido"] == 1) {
							echo "<option value=\"".$rowi["idioma"]."\" selected>".$rowi["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$rowi["idioma"]."\">".$rowi["descripcion"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 30) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_cabezera where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			### COPIA CABEZERA PLANTILLA
			$sqlxx = "select numero,numero_serie from sgm_recibos where visible=1 and id_factura=".$_GET["id"]." order by numero desc,numero_serie desc";
			$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
			$rowxx = mysqli_fetch_array($resultxx);
			$numero = $rowxx["numero"] + 1;
			$numero_serie = $rowxx["numero_serie"] + 1;
			$fecha_emi = cambiarFormatoFechaYMD($_POST["fecha_emision"]);
			$fecha_ven = cambiarFormatoFechaYMD($_POST["fecha_vencimiento"]);
			$camposInsert = "numero,numero_serie,id_factura,fecha,fecha_vencimiento,nombre,nif,direccion,poblacion,cp,provincia,onombre,onif,odireccion,opoblacion,ocp,oprovincia,total,id_cliente,id_user,id_tipo_pago,cobrada";
			$datosInsert = array($numero,$numero_serie,$_GET["id"],$fecha_emi,$fecha_ven,$row["nombre"],$row["nif"],$row["direccion"],$row["poblacion"],$row["cp"],$row["provincia"],$row["onombre"],$row["onif"],$row["odireccion"],$row["opoblacion"],$row["ocp"],$row["oprovincia"],$_POST["total"],$row["id_cliente"],$row["id_user"],$_POST["id_tipo_pago"],$_POST["cobrada"]);
			insertFunction ("sgm_recibos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$fecha_emi = cambiarFormatoFechaYMD($_POST["fecha_emision"]);
			$fecha_ven = cambiarFormatoFechaYMD($_POST["fecha_vencimiento"]);
			$camposUpdate = array("numero_serie","fecha","fecha_vencimiento","total","id_tipo_pago","cobrada");
			$datosUpdate = array($_POST["numero_serie"],$fecha_emi,$fecha_ven,$_POST["total"],$_POST["id_tipo_pago"],$_POST["cobrada"]);
			updateFunction ("sgm_recibos",$_GET["id_recibo"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_recibos",$_GET["id_recibo"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption > 0){
			$sql = "select id,total from sgm_cabezera where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			## COMPRUEBA SI ESTAN LOS RECIBOS REALIZADOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"];
			$resultcalc = mysqli_query($dbhandle,convertSQL($sqlcalc));
			$rowcalc = mysqli_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$camposUpdate = array("recibos");
				$datosUpdate = array("1");
				updateFunction ("sgm_cabezera",$row["id"],$camposUpdate,$datosUpdate);
			} else {
				$camposUpdate = array("recibos");
				$datosUpdate = array("0");
				updateFunction ("sgm_cabezera",$row["id"],$camposUpdate,$datosUpdate);
			}
			## COMPRUEBA SI ESTA COBRADA O NO A PARTIR DE LOS RECIBOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"]." and cobrada=1";
			$resultcalc = mysqli_query($dbhandle,convertSQL($sqlcalc));
			$rowcalc = mysqli_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$camposUpdate = array("cobrada");
				$datosUpdate = array("1");
				updateFunction ("sgm_cabezera",$row["id"],$camposUpdate,$datosUpdate);
			} else {
				$camposUpdate = array("cobrada");
				$datosUpdate = array("0");
				updateFunction ("sgm_cabezera",$row["id"],$camposUpdate,$datosUpdate);
			}
		}

		$sqlf = "select fecha_vencimiento,id_cliente,tipo,id_divisa,fecha,numero,total from sgm_cabezera where id=".$_GET["id"];
		$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
		$rowf = mysqli_fetch_array($resultf);
		$sqlc = "select id,nombre,entidadbancaria,domiciliobancario,cuentabancaria,dias_vencimiento,dias from sgm_clients where id=".$rowf["id_cliente"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		$sqltipos = "select tipo from sgm_factura_tipos where id=".$rowf["tipo"];
		$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
		$rowtipos = mysqli_fetch_array($resulttipos);
		$sqldiv2 = "select abrev from sgm_divisas where id=".$rowf["id_divisa"];
		$resultdiv2 = mysqli_query($dbhandle,convertSQL($sqldiv2));
		$rowdiv2 = mysqli_fetch_array($resultdiv2);
		$sqlre = "select sum(total) as total_recibos from sgm_recibos where visible=1 and id_factura=".$_GET["id"];
		$resultre = mysqli_query($dbhandle,convertSQL($sqlre));
		$rowre = mysqli_fetch_array($resultre);
		echo "<h4>".$Recibos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"text-align:left;vertical-align:top;width:25%;\">";
					echo "<table>";
						echo "<tr><th>".$rowtipos["tipo"]."</th><td>".$rowf["numero"]."</td></tr>";
						echo "<tr><th>".$Fecha."</th><td>".cambiarFormatoFechaDMY($rowf["fecha"])."</td></tr>";
						echo "<tr><th>".$Fecha." ".$Vencimiento."</th><td>".cambiarFormatoFechaDMY($rowf["fecha_vencimiento"])."</td></tr>";
					echo "</table>";
				echo "</td><td style=\"text-align:left;vertical-align:top;width:50%;\">";
					echo "<table>";
						echo "<tr><th>".$Cliente."</th><td>".$rowc["nombre"]."</td></tr>";
						echo "<tr><th>".$Importe."</th><td>".number_format($rowf["total"], 2, ',', '.')." ".$rowdiv2["abrev"]."</td></tr>";
						echo "<tr><th>".$Dia." ".$Vencimiento."</th><td>".$rowc["dias_vencimiento"];
						if ($rowc["dias"] == 1) { echo " ".$diaas_naturales; }
						if ($rowc["dias"] == 0) { echo " ".$messes_naturales; }
						echo "</td></tr>";
					echo "</table>";
				echo "</td><td style=\"text-align:left;vertical-align:top;width:25%;\">";
					echo "<table>";
						echo "<tr><th>".$Entidad." ".$Bancaria."</th><td>".$rowc["entidadbancaria"]."</td></tr>";
						echo "<tr><th>".$Direccion." ".$Entidad."</th><td>".$rowc["domiciliobancario"]."</td></tr>";
						echo "<tr><th>".$Numero." ".$Cuenta."</th><td>".$rowc["cuentabancaria"]."</td>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td style=\"text-align:left;vertical-align:top;width:100%;\" colspan=\"3\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th></th>";
							echo "<th>".$Numero." ".$Factura."/</th>";
							echo "<th>".$Serie."</th>";
							echo "<th>".$Fecha." ".$Emision."</th>";
							echo "<th>".$Fecha." ".$Vencimiento."</th>";
							echo "<th>".$Importe."</th>";
							echo "<th>".$Tipo." ".$Pago."</th>";
							echo "<th colspan=\"4\">".$Cobrado."</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1003&sop=30&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
							echo "<td colspan=\"3\"></td>";
							echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"fecha_emision\" value=\"".cambiarFormatoFechaDMY(date("Y-m-d"))."\"></td>";
							$sqlt = "select count(*) as total from sgm_clients_dias_recibos where id_cliente=".$rowc["id"]." order by dia";
							$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
							$rowt = mysqli_fetch_array($resultt);
							if ($rowt["total"] == 0) {
								$a = date("Y", strtotime($rowf["fecha"]));
								$m = date("m", strtotime($rowf["fecha"]));
								$d = date("d", strtotime($rowf["fecha"]));
								if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$rowc["dias_vencimiento"], $a)); }
								if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+$rowc["dias_vencimiento"] ,$d, $a)); }
							} else {
								$sqlz = "select dia from sgm_clients_dias_recibos where id_cliente=".$rowc["id"]." order by dia";
								$resultz = mysqli_query($dbhandle,convertSQL($sqlz));
								while ($rowz = mysqli_fetch_array($resultz)) {
									$a = date("Y", strtotime($rowf["fecha"]));
									$m = date("m", strtotime($rowf["fecha"]));
									$df = date("d", strtotime($rowf["fecha"]));
									$d = $rowz["dia"];
									if ($df <= $d) {
										if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$rowc["dias_vencimiento"], $a)); }
										if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+$rowc["dias_vencimiento"] ,$d, $a)); }
									}
								}
							}
							echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"fecha_vencimiento\" value=\"".cambiarFormatoFechaDMY($fecha_vencimiento)."\"></td>";
							echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"total\" value=\"".($rowf["total"]-$rowre["total_recibos"])."\"></td>";
							echo "<td><select name=\"id_tipo_pago\" style=\"width:100px\">";
							echo "<option value=\"0\">".$Pendiente."</option>";
							$sqlfp = "select id,tipo from sgm_tpv_tipos_pago order by tipo";
							$resultfp = mysqli_query($dbhandle,convertSQL($sqlfp));
							while ($rowfp = mysqli_fetch_array($resultfp)) {
								if ($rowfp["id"] == $row["id_tipo_pago"]) {
									echo "<option value=\"".$rowfp["id"]."\" selected>".$rowfp["tipo"]."</option>";
								} else {
									echo "<option value=\"".$rowfp["id"]."\">".$rowfp["tipo"]."</option>";
								}
							}
							echo "</select></td>";
							echo "<td><select name=\"cobrada\" style=\"width:50px\">";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Nuevo."\"></td>";
							echo "</form>";
							echo "<td></td>";
							echo "<td></td>";
						echo "</tr>";
						$sqlr = "select * from sgm_recibos where visible=1 and id_factura=".$_GET["id"]." order by numero desc, numero_serie desc";
						$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
						while ($rowr = mysqli_fetch_array($resultr)) {
							echo "<tr>";
								echo "<form action=\"index.php?op=1003&sop=30&ssop=2&id=".$_GET["id"]."&id_recibo=".$rowr["id"]."\" method=\"post\">";
								echo "<td><a href=\"index.php?op=1003&sop=31&id=".$_GET["id"]."&id_recibo=".$rowr["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td style=\"text-align:right;\">".$rowf["numero"]."/</td>";
								echo "<td><input type=\"Text\" style=\"width:25px;\" name=\"numero_serie\" value=\"".$rowr["numero_serie"]."\"></td>";
								echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"fecha_emision\" value=\"".cambiarFormatoFechaDMY($rowr["fecha"])."\"></td>";
								echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"fecha_vencimiento\" value=\"".cambiarFormatoFechaDMY($rowr["fecha_vencimiento"])."\"></td>";
								echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"total\" value=\"".$rowr["total"]."\"></td>";
								echo "<td><select name=\"id_tipo_pago\" style=\"width:100px\">";
									echo "<option value=\"0\">Pendiente</option>";
									$sqlfp = "select id,tipo from sgm_tpv_tipos_pago order by tipo";
									$resultfp = mysqli_query($dbhandle,convertSQL($sqlfp));
									while ($rowfp = mysqli_fetch_array($resultfp)) {
										if ($rowfp["id"] == $rowr["id_tipo_pago"]) {
											echo "<option value=\"".$rowfp["id"]."\" selected>".$rowfp["tipo"]."</option>";
										} else {
											echo "<option value=\"".$rowfp["id"]."\">".$rowfp["tipo"]."</option>";
										}
									}
								echo "</select></td>";
								echo "<td><select name=\"cobrada\" style=\"width:50px\">";
									if ($rowr["cobrada"] == 0) { 
										echo "<option value=\"0\" selected>".$No."</option>";
										echo "<option value=\"1\">".$Si."</option>";
									}
									if ($rowr["cobrada"] == 1) { 
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\" selected>".$Si."</option>";
									}
								echo "</select></td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
								echo "</form>";
								echo "<td class=\"submit\">";
									echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturacion-recibos-print-pdf.php?id=".$rowr["id"]."\" target=\"_blank\">";
										echo "<input type=\"Submit\" value=\"".$Imprimir."\">";
									echo "</form>";
								echo "</td>";
#								$sqlx = "select * from sgm_clients where id=".$rowf["id_cliente"];
#								$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
#								$rowx = mysqli_fetch_array($resultx);
#								if (($rowx["cuentabancaria"] != "") and ($rowr["id_tipo_pago"] == 4)) {
#									echo "<td><a href=\"index.php?op=1003&sop=9999&id_factura=".$rowr["id_factura"]."\">*</a></td>";
#								} else { 
#									echo "<td></td><td></td>";
#								}
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
	}

	if ($soption == 31) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=30&ssop=3&id=".$_GET["id"]."&id_recibo=".$_GET["id_recibo"],"op=1003&sop=30".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 40) {
		echo "<center>";
		echo "<br><br>".$ayudaFacturaCerrar;
		echo boton(array("op=1003&sop=0&ssop=8&id=".$_GET["id_tipo"]."&id_fact=".$_GET["id"],"op=1003&sop=0&id=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 41) {
		echo "<center>";
		echo "<br><br>".$ayudaFacturaAbrir;
		echo boton(array("op=1003&sop=0&ssop=9&id=".$_GET["id_tipo"]."&id_fact=".$_GET["id"],"op=1003&sop=0&id=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 50) {
		echo "<center>";
		echo "<br><br>".$ayudaFacturaAprobar;
		echo boton(array("op=1003&sop=0&ssop=4&id=".$_GET["id_tipo"]."&id_fact=".$_GET["id"],"op=1003&sop=0&id=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 51) {
		echo "<center>";
		echo "<br><br>".$ayudaFacturaDesaprobar;
		echo boton(array("op=1003&sop=0&ssop=5&id=".$_GET["id_tipo"]."&id_fact=".$_GET["id"],"op=1003&sop=0&id=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_clients where id=".$_POST["id_cliente"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$sqlc = "select nombre,apellido1,apellido2,mail,telefono from sgm_clients_contactos where pred=1 and id_client=".$_POST['id_cliente'];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$camposUpdate = array("nombre","nif","direccion","poblacion","cp","provincia","mail","telefono","id_cliente","edireccion","epoblacion","ecp","eprovincia","cnombre","cmail","ctelefono");
			$datosUpdate = array($row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"],$row["nif"],$row["direccion"],$row["poblacion"],$row["cp"],$row["provincia"],$row["mail"],$row["telefono"],$row["id"],$row["direccion"],$row["poblacion"],$row["cp"],$row["provincia"],$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"],$rowc["mail"],$rowc["telefono"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 2) {
			$sqlc = "select nombre,apellido1,apellido2,mail,telefono from sgm_clients_contactos where id=".$_POST["id_contacto"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$camposUpdate = array("cnombre","cmail","ctelefono");
			$datosUpdate = array($rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"],$rowc["mail"],$rowc["telefono"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$sql = "select * from sgm_clients where id=".$_GET["id_cliente"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposUpdate = array("edireccion","epoblacion","ecp","eprovincia");
			$datosUpdate = array($row["direccion"],$row["poblacion"],$row["cp"],$row["provincia"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$fecha = date("Y-m-d");
			$sqlf = "select fecha_prevision,fecha_entrega from sgm_cabezera where id=".$_GET["id"];
			$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
			$rowf = mysqli_fetch_array($resultf);
			if ($rowf["fecha_prevision"] != cambiarFormatoFechaDMY($_POST["fecha_prevision"])){
				$camposInsert = "id_factura, id_usuario, fecha_ant, data";
				$datosInsert = array($_GET["id"],$userid,$rowf["fecha_prevision"],$fecha);
				insertFunction ("sgm_factura_canvi_data_prevision",$camposInsert,$datosInsert);
			}
			if ($rowf["fecha_entrega"] != cambiarFormatoFechaDMY($_POST["fecha_entrega"])){
				$camposInsert = "id_factura, id_usuario, fecha_ant, data";
				$datosInsert = array($_GET["id"],$userid,$rowf["fecha_entrega"],$fecha);
				insertFunction ("sgm_factura_canvi_data_entrega",$camposInsert,$datosInsert);
			}
			$fechaf = date("Y-m-d", strtotime(cambiarFormatoFechaDMY($_POST["fecha"])));
			$fecha_prevf = date("Y-m-d", strtotime(cambiarFormatoFechaDMY($_POST["fecha_prevision"])));
			$fecha_entf = date("Y-m-d", strtotime(cambiarFormatoFechaDMY($_POST["fecha_entrega"])));
			$fecha_venf = date("Y-m-d", strtotime(cambiarFormatoFechaDMY($_POST["fecha_vencimiento"])));

			$camposUpdate = array("numero","version","numero_rfq","numero_cliente","fecha","fecha_prevision","fecha_entrega","fecha_vencimiento","id_cliente","nombre","nif","direccion","poblacion","cp","provincia","id_pais","mail","telefono","edireccion","epoblacion","ecp","eprovincia","notas","imp_exp","id_divisa","div_canvi","id_pagador","id_user","id_dades_origen_factura_iban","cnombre","cmail","ctelefono","id_contrato");
			$datosUpdate = array($_POST["numero"],$_POST["version"],$_POST["numero_rfq"],$_POST["numero_cliente"],$fechaf,$fecha_prevf,$fecha_entf,$fecha_venf,$_POST["id_cliente"],$_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["mail"],$_POST["telefono"],$_POST["edireccion"],$_POST["epoblacion"],$_POST["ecp"],$_POST["eprovincia"],$_POST["notas"],$_POST["imp_exp"],$_POST["id_divisa"],$_POST["div_canvi"],$_POST["id_pagador"],$_POST["id_user"],$_POST["id_dades_origen_factura_iban"],$_POST["cnombre"],$_POST["cmail"],$_POST["ctelf"],$_POST["id_contrato"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
		}
#### INSERTA DATOS EN EL CUERPO
		if ($ssoption == 5) {
			$fecha_prev = cambiarFormatoFechaDMY($_POST["fecha_prevision"]);
			if ($_POST["codigo2"] != "") { $codigo = $_POST["codigo2"]; } else { $codigo = $_POST["codigo"]; }
			if ($codigo != ''){
				$sql = "select * from sgm_articles where codigo='".$codigo."'";
			} elseif ($_POST["nombre"] != ''){
				$sql = "select * from sgm_articles where nombre='".$_POST["nombre"]."'";
			}
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$sqls = "select pvd,pvp from sgm_stock where id_article=".$row["id"];
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			$rows = mysqli_fetch_array($results);
			if ($row) {
				$total = $_POST["unidades"] * $rows["pvp"];
				if ($_POST["descuento"] > 0){ $total = $total-($total/100)*$_POST["descuento"] ; }
				if ($_POST["descuento_absoluto"] > 0){ $total = $total-$_POST["descuento_absoluto"] ; }
				$camposInsert = "idfactura,linea,codigo,nombre,pvd,pvp,unidades,descuento,descuento_absoluto,total,fecha_prevision,id_article,fecha_prevision_propia";
				$datosInsert = array($_GET["id"],$_POST["linea"],$row["codigo"],$row["nombre"],$rows["pvd"],$rows["pvp"],$_POST["unidades"],$_POST["descuento"],$_POST["descuento_absoluto"],$total,$fecha_prev,$row["id"],$fecha_prev);
				insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
			} else {
				$total = $_POST["unidades"] * $_POST["pvp"];
				if ($_POST["descuento"] > 0){ $total = $total-(($total/100)*$_POST["descuento"]) ; }
				if ($_POST["descuento_absoluto"] > 0){ $total = $total-$_POST["descuento_absoluto"] ; }
				$camposInsert = "idfactura,linea,codigo,nombre,pvd,pvp,unidades,descuento,descuento_absoluto,total,fecha_prevision,id_article,fecha_prevision_propia";
				$datosInsert = array($_GET["id"],$_POST["linea"],$codigo,$_POST["nombre"],$_POST["pvd"],$_POST["pvp"],$_POST["unidades"],$_POST["descuento"],$_POST["descuento_absoluto"],$total,$fecha_prev,0,$fecha_prev);
				insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
			}
			refactura($_GET["id"]);
		}
#### ELIMINAR CUERPO
		if ($ssoption == 6) {
			deleteFunction ("sgm_cuerpo",$_GET["id_cuerpo"]);
			$sql = "update sgm_files set ";
			$sql = $sql."visible = 0";
			$sql = $sql." WHERE id_elemento=".$_GET["id_cuerpo"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			refactura($_GET["idfactura"]);
			$num = 1;
			$sqll = "select linea,id from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
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
			refactura($_GET["id"]);
		}
		if ($ssoption == 9) {
			$sql = "select id,fecha_prevision from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$codigo = '';
				if ($row["fecha_prevision"] != cambiarFormatoFechaDMY($_POST["fecha_prevision".$row["id"].""])){
					$fecha = date("Y-m-d");
					$camposInsert = "id_factura,id_usuario,fecha_ant,data,id_cuerpo";
					$datosInsert = array($_GET["id"],$userid,$row["fecha_prevision"],$fecha,$row["id"]);
					insertFunction ("sgm_factura_canvi_data_prevision_cuerpo",$camposInsert,$datosInsert);
				}
				$fecha_prev = cambiarFormatoFechaDMY($_POST["fecha_prevision".$row["id"].""]);
				if ($_POST["codigo2".$row["id"].""] != '') {
					$codigo = $_POST["codigo2".$row["id"].""];
				} elseif ($_POST["codigo".$row["id"].""] != '') {
					$codigo = $_POST["codigo".$row["id"].""];
				} else { $codigo = '';}
				if ($codigo != ''){
					$sqla = "select * from sgm_articles where codigo='".$codigo."'";
				} elseif ($_POST["nombre".$row["id"].""] != ''){
					$sqla = "select id,nombre from sgm_articles where nombre='".$_POST["nombre".$row["id"].""]."'";
				} else { $sqla = '';}
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				$rowa = mysqli_fetch_array($resulta);
				$sqls = "select pvd,pvp from sgm_stock where id_article=".$rowa["id"];
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				$rows = mysqli_fetch_array($results);
				if ($rows) {
					$ini_pvd = $rows["pvd"];
					$ini_pvp = $rows["pvp"];
				} else {
					$ini_pvd = $_POST["pvd".$row["id"].""];
					$ini_pvp = $_POST["pvp".$row["id"].""];
				}
				if ($ini_pvd == ""){ $pvd=0; } else { $pvd = ereg_replace(",","", $ini_pvd ); }
				$pvp = ereg_replace(",","", $ini_pvp );
				if ( (($_POST["descuento".$row["id"].""] != "") OR ($_POST["descuento".$row["id"].""] != 0)) AND (($_POST["descuento_absoluto".$row["id"].""] != "") OR ($_POST["descuento_absoluto".$row["id"].""] != 0)) )  {
					if  ($_POST["descuento_absoluto".$row["id"].""] == 0) {
						$total = ($ini_pvp-(($ini_pvp/100)*$_POST["descuento".$row["id"].""]))*$_POST["unidades".$row["id"].""];
						$descuento = $_POST["descuento".$row["id"].""];
						$descuento_absoluto = 0;
					} else {
						$total = ($ini_pvp- $_POST["descuento_absoluto".$row["id"].""] )* $_POST["unidades".$row["id"].""];
						$descuento = 0;
						$descuento_absoluto = $_POST["descuento_absoluto".$row["id"].""];
					}
				} else {
					$total = $_POST["unidades".$row["id"].""] * $ini_pvp;
				}

				if ($rowa) {
					$camposUpdate = array("codigo","nombre","pvd","pvp","linea","unidades","descuento","descuento_absoluto","total","fecha_prevision");
					$datosUpdate = array($codigo,$rowa["nombre"],$rows["pvd"],$rows["pvp"],$_POST["linea".$row["id"].""],$_POST["unidades".$row["id"].""],$descuento,$descuento_absoluto,$total,$fecha_prev);
					updateFunction ("sgm_cuerpo",$row["id"],$camposUpdate,$datosUpdate);
				} else {
					$camposUpdate = array("codigo","nombre","pvd","pvp","linea","unidades","descuento","descuento_absoluto","total","fecha_prevision");
					$datosUpdate = array($codigo,$_POST["nombre".$row["id"].""],$pvd,$pvp,$_POST["linea".$row["id"].""],$_POST["unidades".$row["id"].""],$descuento,$descuento_absoluto,$total,$fecha_prev);
					updateFunction ("sgm_cuerpo",$row["id"],$camposUpdate,$datosUpdate);
				}
			}
			refactura($_GET["id"]);
		}
		$cambio_pago = false;
		if ($ssoption == 10) {
			$camposUpdate = array("id_tipo_pago");
			$datosUpdate = array($_POST["id_tipo_pago"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
			$cambio_pago = true;
		}
		if ($ssoption == 11) {
			$camposUpdate = array("suma");
			$datosUpdate = array("1");
			updateFunction ("sgm_cuerpo",$_GET["id_linea"],$camposUpdate,$datosUpdate);
			refactura($_GET["id"]);
		}
		if ($ssoption == 12) {
			$camposUpdate = array("suma");
			$datosUpdate = array("0");
			updateFunction ("sgm_cuerpo",$_GET["id_linea"],$camposUpdate,$datosUpdate);
			refactura($_GET["id"]);
		}
		if ($ssoption == 13) {
			$camposUpdate = array("aprovat");
			$datosUpdate = array("1");
			updateFunction ("sgm_cuerpo",$_GET["id_linea"],$camposUpdate,$datosUpdate);
			contaAprovats($_GET["id_linea"],$_GET["id"]);
		}
		if ($ssoption == 14) {
			$camposUpdate = array("retenciones");
			$datosUpdate = array($_POST["retenciones"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
			refactura($_GET["id"]);
		}
		if ($ssoption == 15) {
			if ($_POST["descuento"] == "") {
				$descuento=0;
				$descuento_absoluto=$_POST["descuento_absoluto"];
			}
			if ($_POST["descuento_absoluto"] == "") {
				$descuento_absoluto=0;
				$descuento=$_POST["descuento"];
			}
			$camposUpdate = array("descuento","descuento_absoluto","total_forzado");
			$datosUpdate = array($descuento,$descuento_absoluto,0);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
			refactura($_GET["id"]);
		}
		if ($ssoption == 16) {
			$camposUpdate = array("iva");
			$datosUpdate = array($_POST["iva"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
			refactura($_GET["id"]);
		}
		if ($ssoption == 17) {
			$camposUpdate = array("total","total_forzado");
			$datosUpdate = array($_POST["total"],1);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
			refactura($_GET["id"]);
		}
		if ($ssoption == 18) {
			$sql = "select id,total_forzado,id_divisa,total,subtotal,descuento_absoluto,subtotaldescuento from sgm_cabezera where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$sqldivi = "select canvi from sgm_divisas_canvis where visible=1 and id_divisa_origen=".$row["id_divisa"]." and id_divisa_destino=".$_POST["id_div_canvi"];
			$resultdivi = mysqli_query($dbhandle,convertSQL($sqldivi));
			$rowdivi = mysqli_fetch_array($resultdivi);
			$camposUpdate = array("subtotal","descuento_absoluto","subtotaldescuento","total","total_forzado","div_canvi","id_divisa");
			$datosUpdate = array($row["subtotal"]*$rowdivi["canvi"],$row["descuento_absoluto"]*$rowdivi["canvi"],$row["subtotaldescuento"]*$rowdivi["canvi"],$row["total"]*$rowdivi["canvi"],$row["total_forzado"]*$rowdivi["canvi"],$rowdivi["canvi"],$_POST["id_div_canvi"]);
			updateFunction ("sgm_cabezera",$_GET["id"],$camposUpdate,$datosUpdate);
			$sqll = "select id,pvd,pvp,total,descuento_absoluto,subtotaldescuento from sgm_cuerpo where idfactura=".$row["id"];
			$resultl = mysqli_query($dbhandle,convertSQL($sqll));
			while ($rowl = mysqli_fetch_array($resultl)) {
				$camposUpdate = array("pvd","descuento_absoluto","subtotaldescuento","total","pvp");
				$datosUpdate = array($rowl["pvd"]*$rowdivi["canvi"],$rowl["descuento_absoluto"]*$rowdivi["canvi"],$rowl["subtotaldescuento"]*$rowdivi["canvi"],$rowl["total"]*$rowdivi["canvi"],$rowl["pvp"]*$rowdivi["canvi"]);
				updateFunction ("sgm_cuerpo",$rowl["id"],$camposUpdate,$datosUpdate);
			}
			refactura($_GET["id"]);
		}
		if (($ssoption >= 1) and ($ssoption <= 18)) {
			$fecha = date("U");
			$camposInsert = "id_factura, id_usuario, fecha";
			$datosInsert = array($_GET["id"],$userid,$fecha);
			insertFunction ("sgm_factura_modificacio",$camposInsert,$datosInsert);
		}
		echo boton(array("op=1003&sop=104&id_tipo=".$_GET["id_tipo"]."&id=".$_GET["id"]),array($Modificadores));
		$sql = "select * from sgm_cabezera where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$sqlf = "select tpv,id,tipo from sgm_factura_tipos where id=".$row["tipo"];
		$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
		$rowf = mysqli_fetch_array($resultf);
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"width:100%;vertical-align:top;text-align:left;\">";
					if ($rowf["tpv"] == 1) {
						if (($cambio_pago == true) and ($_POST["cambio2"] == 0)) { mensageError($InfoCambioFormaPagoTPV); }
						if (($cambio_pago == true) and ($_POST["cambio2"] == 1)) { mensageError($InfoCambioFormaPagoTPV2); }
						echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
							if ($row["id_tipo_pago"] == 0) { $color = $color_naranja; } elseif ($row["id_tipo_pago"] <> 0) {$color = $color_verde;}
							echo "<tr style=\"background-color:".$color.";width:450px;vertical-align:middle;height:50px;text-align:center\">";
								echo "<form action=\"index.php?op=1003&sop=100&ssop=10&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
								echo "<td><select name=\"id_tipo_pago\">";
									echo "<option value=\"0\">-</option>";
									$sql1 = "select id,tipo from sgm_tpv_tipos_pago order by id";
									$result1 = mysqli_query($dbhandle,convertSQL($sql1));
									while ($row1 = mysqli_fetch_array($result1)) {
										if ($row["id_tipo_pago"] == $row1["id"]) {
											echo "<option value=\"".$row1["id"]."\" selected>".$row1["tipo"]."</option>";
										} else {
											echo "<option value=\"".$row1["id"]."\">".$row1["tipo"]."</option>";
										}
									}
									echo "</select></td>";
									echo "<td class=\"submit\">";
									if ($cambio_pago == true) { 
										echo "<input type=\"hidden\" value=\"1\" name=\"cambio2\">";
									} else {
										echo "<input type=\"hidden\" value=\"0\" name=\"cambio2\">";
									}
									echo "<input type=\"Submit\" value=\"".$Modificar."\"></td>";
									echo "</form>";
							echo "</tr>";
						echo "</table>";
					}
					if ($rowf["tpv"] == 0) {
						echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:100%\">";
							echo "<tr>";
								echo "<form action=\"index.php?op=1003&sop=100&ssop=1&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
								echo "<td><select name=\"id_cliente\">";
									echo "<option value=\"0\">-</option>";
									$sqltipos = "select presu,v_fecha_prevision,v_subtipos from sgm_factura_tipos where id=".$row["tipo"]." order by id";
									$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
									$rowtipos = mysqli_fetch_array($resulttipos);
									$sqlx = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
									$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
									while ($rowx = mysqli_fetch_array($resultx)) {
										echo "<option value=\"".$rowx["id"]."\">".$rowx["nombre"]." ".$rowx["cognom1"]." ".$rowx["cognom2"]."</option>";
									}
									echo "</select>";
								echo "</td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Cambio." ".$Cliente."\"></td>";
								echo "</form>";
								echo "<td>&nbsp;</td>";
								echo "<form action=\"index.php?op=1003&sop=100&ssop=2&id=".$_GET["id"]."&id_cliente=".$row["id_cliente"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
								echo "<td><select name=\"id_contacto\">";
									echo "<option value=\"0\">-</option>";
									$sqlcc = "select id,nombre,apellido1,apellido2 from sgm_clients_contactos where id_client=".$row["id_cliente"]." order by nombre";
									$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
									while ($rowcc = mysqli_fetch_array($resultcc)) {
										echo "<option value=\"".$rowcc["id"]."\">".$rowcc["nombre"]." ".$rowcc["apellido1"]." ".$rowcc["apellido2"]."</option>";
									}
								echo "</select></td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Cambio." ".$Contacto."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1003&sop=100&ssop=18&id=".$_GET["id"]."&id_cliente=".$row["id_cliente"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
								echo "<td><select name=\"id_div_canvi\">";
									echo "<option value=\"0\">-</option>";
									$sqldi = "select abrev from sgm_divisas where visible=1 and id=".$row["id_divisa"];
									$resultdi = mysqli_query($dbhandle,convertSQL($sqldi));
									$rowdi = mysqli_fetch_array($resultdi);
									$sqldivc = "select id_divisa_destino,canvi from sgm_divisas_canvis where id_divisa_origen=".$row["id_divisa"];
									$resultdivc = mysqli_query($dbhandle,convertSQL($sqldivc));
									while ($rowdivc = mysqli_fetch_array($resultdivc)) {
										if ($rowdivc["id_divisa_destino"] != $row["id_divisa"]) {
											$sqldivs = "select id,divisa,abrev from sgm_divisas where visible=1 and id=".$rowdivc["id_divisa_destino"];
											$resultdivs = mysqli_query($dbhandle,convertSQL($sqldivs));
											$rowdivs = mysqli_fetch_array($resultdivs);
											echo "<option value=\"".$rowdivs["id"]."\">".$rowdivs["divisa"]." (1 ".$rowdi["abrev"]." = ".$rowdivc["canvi"]." ".$rowdivs["abrev"].")</option>";
										}
									}
									echo "</select>";
								echo "</td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Cambio_Importe_a."\"></td>";
								echo "</form>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr><tr>";
					echo "<td style=\"width:100%;vertical-align:top;text-align:left;\">";
						$id_tipo = $row["tipo"];
						echo "<form action=\"index.php?op=1003&sop=100&ssop=4&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
						echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$row["id_cliente"]."\">";
						echo "<table cellpadding=\"1\" cellspacing=\"0\" bgcolor=\"#c0c0c0\" style=\"width:100%\">";
							echo "<tr>";
								echo "<td style=\"vertical-align:top;width:20%\">";
									echo "<table style=\"width:100%;\">";
										echo "<tr><th>".$rowf["tipo"]."</th><td><input style=\"width:80%\" type=\"Text\" name=\"numero\" value=\"".$row["numero"]."\"><strong>&nbsp;/&nbsp;</strong><input type=\"Text\" name=\"version\" style=\"width:10%\" value=\"".$row["version"]."\"></td></tr>";
										if ($rowtipos["presu"] == 1){
											echo "<tr><th>".$Numero." RFQ</th><td><input type=\"Text\" name=\"numero_rfq\" value=\"".$row["numero_rfq"]."\"></td></tr>";
										} else {
											echo "<tr><th>".$Pedido." ".$Cliente."</th><td><input type=\"Text\" name=\"numero_cliente\" value=\"".$row["numero_cliente"]."\"></td></tr>";
										}
										echo "<tr><th>".$Fecha."</th><td><input type=\"Text\" name=\"fecha\" value=\"".cambiarFormatoFechaYMD($row["fecha"])."\"></td></tr>";
										echo "<tr><th>".$Fecha." ".$Prevision."</th><td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:80%;vertical-align:bottom;\" value=\"".cambiarFormatoFechaYMD($row["fecha_prevision"])."\"><a href=\"index.php?op=1003&sop=105&id=".$_GET["id"]."&classe=1\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td></tr>";
										$color_entrega ="white";
										if ($row["fecha_entrega"] > $row["fecha_prevision"]) { $color_entrega ="#FF4500"; }
										echo "<tr><th>".$Fecha." ".$Entrega."</th><td><input type=\"Text\" name=\"fecha_entrega\" value=\"".cambiarFormatoFechaYMD($row["fecha_entrega"])."\" style=\"width:80%;vertical-align:bottom;background-color: ".$color_entrega.";\"><a href=\"index.php?op=1003&sop=105&id=".$_GET["id"]."&classe=2\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td></tr>";
										echo "<tr><th>".$Fecha." ".$Vencimiento."</th><td><input type=\"Text\" name=\"fecha_vencimiento\" value=\"".cambiarFormatoFechaYMD($row["fecha_vencimiento"])."\"></td></tr>";
									echo "</table>";
								echo "</td>";
								echo "<td style=\"vertical-align:top;width:30%\">";
									echo "<table style=\"width:100%;\">";
										echo "<tr><th>".$Nombre."</th><td><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"></td></tr>";
										echo "<tr><th>".$NIF."</th><td><input type=\"Text\" name=\"nif\" value=\"".$row["nif"]."\"></td></tr>";
										echo "<tr><th>".$Direccion."</th><td><input type=\"Text\" name=\"direccion\" value=\"".$row["direccion"]."\"></td></tr>";
										echo "<tr><th>".$Poblacion."</th><td><input type=\"Text\" name=\"poblacion\" value=\"".$row["poblacion"]."\"></td></tr>";
										echo "<tr><th>".$Codigo." ".$Postal."</th><td><input type=\"Text\" name=\"cp\" value=\"".$row["cp"]."\"></td></tr>";
										echo "<tr><th>".$Provincia."</th><td><input type=\"Text\" name=\"provincia\" value=\"".$row["provincia"]."\"></td></tr>";
									echo "</table>";
								echo "</td>";
								echo "<td style=\"vertical-align:top;width:25%\">";
									echo "<table style=\"width:100%;\">";
										echo "<tr><th>".$Pais."</th><td><select name=\"id_pais\">";
										$sqlp = "select id,pais from sim_paises where visible=1 order by pais";
										$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
										while ($rowp = mysqli_fetch_array($resultp)){
											if ($row["id_pais"] == $rowp["id"]){
												echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["pais"]."</option>";
											} else {
												if ($rowp["predeterminado"] == 1){
													echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["pais"]."</option>";
												} else {
													echo "<option value=\"".$rowp["id"]."\">".$rowp["pais"]."</option>";
												}
											}
										}
										echo "</select></td></tr>";
										echo "<tr><th>".$Email."</th><td><input type=\"Text\" name=\"mail\" value=\"".$row["mail"]."\"></td></tr>";
										echo "<tr><th>".$Telefono."</th><td><input type=\"Text\" name=\"telefono\" value=\"".$row["telefono"]."\"></td></tr>";
										echo "<tr><th>".$Contacto."</th><td><input type=\"Text\" name=\"cnombre\" value=\"".$row["cnombre"]."\"></td></tr>";
										echo "<tr><th>".$Email."</th><td><input type=\"Text\" name=\"cmail\" value=\"".$row["cmail"]."\"></td></tr>";
										echo "<tr><th>".$Telefono."</th><td><input type=\"Text\" name=\"ctelf\" value=\"".$row["ctelefono"]."\"></td></tr>";
									echo "</table>";
								echo "</td>";
								echo "<td style=\"vertical-align:top;width:30%\">";
									echo "<table style=\"width:100%\">";
									$sqlpermiso2 = "select admin from sgm_factura_tipos_permisos where id_tipo=".$rowf["id"]." and id_user=".$userid;
									$resultpermiso2 = mysqli_query($dbhandle,convertSQL($sqlpermiso2));
									$rowpermiso2 = mysqli_fetch_array($resultpermiso2);
										echo "<tr>";
											echo "<th style=\"width:20%;\">".$Contrato."</th>";
											echo "<td style=\"width:80%;\">";
												if ($rowpermiso2["admin"] == 0){
													echo "<select name=\"id_contrato\" disabled>";
												} else {
													echo "<select name=\"id_contrato\">";
												}
												echo "<option value=\"0\">-</option>";
												$sqlcl1 = "select id from sgm_clients where visible=1 and nif=(select nif from sgm_dades_origen_factura)";
												$resultcl1 = mysqli_query($dbhandle,convertSQL($sqlcl1));
												$rowcl1 = mysqli_fetch_array($resultcl1);
												$sql1b = "select count(*) as total from sgm_contratos where visible=1 and activo=1 and id_cliente=".$row["id_cliente"]." and id_cliente<>".$rowcl1["nif"];
												$result1b = mysqli_query($dbhandle,convertSQL($sql1b));
												$row1b = mysqli_fetch_array($result1b);
												if ($row1b["total"] > 0){
													$sql1a = "select id,descripcion,id_cliente from sgm_contratos where visible=1 and activo=1 and id_cliente=".$row["id_cliente"]." and id_cliente<>".$rowcl1["nif"];
												} else {
													$sql1b2b = "select count(*) as total from sgm_contratos where visible=1 and activo=1 and id_cliente=(select id_agrupacio from sgm_clients where id=".$row["id_cliente"].")";
													$result1b2b = mysqli_query($dbhandle,convertSQL($sql1b2b));
													$row1b2b = mysqli_fetch_array($result1b2b);
													if ($row1b2b["total"] > 0){
														$sql1b2 = "select id_agrupacio from sgm_clients where id=".$row["id_cliente"];
														$result1b2 = mysqli_query($dbhandle,convertSQL($sql1b2));
														$row1b2 = mysqli_fetch_array($result1b2);
														$sql1a = "select id,descripcion,id_cliente from sgm_contratos where visible=1 and activo=1 and id_cliente=".$row1b2["id_agrupacio"];
													} else {
														$sql1a = "select id,descripcion,id_cliente from sgm_contratos where visible=1 and activo=1";
													}
												}
												$result1a = mysqli_query($dbhandle,convertSQL($sql1a));
												while ($row1a = mysqli_fetch_array($result1a)) {
													$sqlcl = "select alias from sgm_clients where id=".$row1a["id_cliente"];
													$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
													$rowcl = mysqli_fetch_array($resultcl);
													if ($row["id_contrato"] == $row1a["id"]) { 
														echo "<option value=\"".$row1a["id"]."\" selected>(".$rowcl["alias"].")".$row1a["descripcion"]."</option>";
													} else {
														echo "<option value=\"".$row1a["id"]."\">(".$rowcl["alias"].")".$row1a["descripcion"]."</option>";
													}
												}
												echo "</select>";
											echo "</td>";
										echo "</tr><tr>";
											echo "<th style=\"width:20%;\">IBAN</th>";
											echo "<td style=\"width:80%;\">";
												if ($rowpermiso2["admin"] == 0){
													echo "<select name=\"id_dades_origen_factura_iban\" disabled>";
												} else {
													echo "<select name=\"id_dades_origen_factura_iban\">";
												}
												$seleccionar = 0;
												$sql1 = "select id,entidad_bancaria,descripcion from sgm_dades_origen_factura_iban";
												$result1 = mysqli_query($dbhandle,convertSQL($sql1));
												while ($row1 = mysqli_fetch_array($result1)) {
													if ($row["id_dades_origen_factura_iban"] == $row1["id"]) { 
														echo "<option value=\"".$row1["id"]."\" selected>".$row1["entidad_bancaria"]." (".$row1["descripcion"].")</option>";
														$seleccionar = 1;
													} else {
														if (($row1["predefinido"] == 1) and ($selecionar = 0)){
															echo "<option value=\"".$row1["id"]."\" selected>".$row1["entidad_bancaria"]." (".$row1["descripcion"].")</option>";
														} else {
															echo "<option value=\"".$row1["id"]."\">".$row1["entidad_bancaria"]." (".$row1["descripcion"].")</option>";
														}
													}
												}
												echo "</select>";
											echo "</td>";
										echo "</tr><tr>";
											echo "<th>".$Usuario."</th>";
											echo "<td>";
												if ($rowpermiso2["admin"] == 0){
													echo "<select name=\"id_user\" disabled>";
												} else {
													echo "<select name=\"id_user\">";
												}
												echo "<option value=\"0\">-</option>";
												$sql1 = "select id,usuario from sgm_users where sgm=1 order by usuario";
												$result1 = mysqli_query($dbhandle,convertSQL($sql1));
												while ($row1 = mysqli_fetch_array($result1)) {
													if ($row["id_user"] == $row1["id"]) {
														echo "<option value=\"".$row1["id"]."\" selected>".$row1["usuario"]."</option>";
													} else {
														echo "<option value=\"".$row1["id"]."\">".$row1["usuario"]."</option>";
													}
												}
												echo "</select>";
											echo "</td>";
										echo "</tr><tr>";
											echo "<th>".$Usuario." ".$Responsable."</th>";
											echo "<td>";
												if ($rowpermiso2["admin"] == 0){
													echo "<select name=\"id_pagador\" disabled>";
												} else {
													echo "<select name=\"id_pagador\">";
												}
												echo "<option value=\"0\">-</option>";
												$sql1 = "select id,usuario from sgm_users where sgm=1 order by usuario";
												$result1 = mysqli_query($dbhandle,convertSQL($sql1));
												while ($row1 = mysqli_fetch_array($result1)) {
													if ($row["id_pagador"] == $row1["id"]) {
														echo "<option value=\"".$row1["id"]."\" selected>".$row1["usuario"]."</option>";
													} else {
														echo "<option value=\"".$row1["id"]."\">".$row1["usuario"]."</option>";
													}
												}
												echo "</select>";
											echo "</td>";
										echo "</tr><tr>";
											echo "<th>".$Divisa." ".$rowf["tipo"]."</th>";
											echo "<td><select name=\"id_divisa\">";
												echo "<option value=\"0\">-</option>";
												$sql1 = "select id,divisa,predefinido from sgm_divisas where visible=1";
												$result1 = mysqli_query($dbhandle,convertSQL($sql1));
												while ($row1 = mysqli_fetch_array($result1)) {
													if ($row["id_divisa"] == $row1["id"]) {
														echo "<option value=\"".$row1["id"]."\" selected>".$row1["divisa"]."</option>";
														$seleccionar = 1;
													} else {
														if (($row1["predefinido"] == 1) and ($selecionar == 0)){
																	echo "<option value=\"".$row1["id"]."\" selected>".$row1["divisa"]."</option>";
														} else {
															echo "<option value=\"".$row1["id"]."\">".$row1["divisa"]."</option>";
														}
													}
												}
												echo "</select>";
											echo "</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<th style=\"vertical-align:top;\">".$Notas."</th>";
											echo "<td><textarea name=\"notas\" style=\"width:100%\" rows=\"2\">".$row["notas"]."</textarea></td>";
										echo "</tr>";
									echo "</table>";
								echo "</td>";
							echo "</tr>";
							echo "<tr bgcolor=\"white\"><td colspan=\"3\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
						echo "</table>";
						echo "</form>";
					}
					echo "</td>";
				echo "</tr><tr>";
					echo "<td style=\"width:100%;vertical-align:top;text-align:left;\">";
						$sql2 = "select abrev from sgm_divisas where visible=1 and id=".$row["id_divisa"];
						$result2 = mysqli_query($dbhandle,convertSQL($sql2));
						$row2 = mysqli_fetch_array($result2);
						echo "<table cellpadding=\"1\" cellspacing=\"0\">";
							echo "<tr style=\"background-color:silver;\">";
								echo "<th style=\"width:100px\"></th>";
								echo "<th style=\"width:50px\"></th>";
								echo "<th style=\"width:100px\">".$Fecha." ".$Prevision."</th>";
								echo "<th></th>";
								echo "<th style=\"width:100px;\">".$Codigo."</th>";
								echo "<th style=\"width:100px;\">".$Codigo."</th>";
								echo "<th style=\"width:300px\">".$Nombre."</th>";
								echo "<th style=\"width:100px\">".$Unidades."</th>";
								echo "<th></th>";
								echo "<th style=\"width:100px\">PVD</th>";
								echo "<th style=\"width:100px\">PVP</th>";
								echo "<th style=\"width:100px\">Desc.%</th>";
								echo "<th style=\"width:100px\">Desc. ".$row2["abrev"]."</th>";
								echo "<th style=\"width:100px\"></th>";
								echo "<th></th>";
								echo "<th></th>";
							echo "</tr><tr>";
								echo "<form action=\"index.php?op=1003&sop=100&ssop=5&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
								echo "<td></td>";
								$sqlxx = "select linea from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea desc";
								$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
								$rowxx = mysqli_fetch_array($resultxx);
								$linea = $rowxx["linea"] +1;
								echo "<td><input type=\"Text\" name=\"linea\" value=\"".$linea."\"></td>";
								echo "<td><input type=\"Text\" name=\"fecha_prevision\" value=\"".cambiarFormatoFechaYMD($row["fecha_prevision"])."\"></td>";
								echo "<td></td>";
								echo "<td>";
									echo "<select name=\"codigo2\">";
									echo "<option value=\"\">-</option>";
									$sql1 = "select codigo from sgm_articles where visible=1 order by codigo";
									$result1 = mysqli_query($dbhandle,convertSQL($sql1));
									while ($row1 = mysqli_fetch_array($result1)) {
										echo "<option value=\"".$row1["codigo"]."\">".$row1["codigo"]."</option>";
									}
									echo "</select>";
								echo "</td>";
								echo "<td><input type=\"Text\" name=\"codigo\"></td>";
								echo "<td><input type=\"Text\" name=\"nombre\"></td>";
								echo "<td><input type=\"Text\" name=\"unidades\" value=\"0.000\" style=\"text-align:right;\"></td>";
								echo "<td></td><td style=\"width:5%\"><input type=\"Text\" name=\"pvd\" value=\"0.000\" style=\"text-align:right;\"></td>";
								echo "<td><input type=\"Text\" name=\"pvp\" value=\"0.000\" style=\"text-align:right;\"></td>";
								echo "<td><input type=\"Text\" name=\"descuento\" value=\"0.000\" style=\"text-align:right;\"></td>";
								echo "<td><input type=\"Text\" name=\"descuento_absoluto\" value=\"0.000\" style=\"text-align:right;\"></td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
								echo "</form>";
							echo "</tr>";
							echo "<tr><th colspan=\"13\"></th><th>".$Total."</th></tr>";
							echo "<form action=\"index.php?op=1003&sop=100&ssop=9&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
							echo "<tr><td colspan=\"13\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
						$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							$color = "white";
							if ($id_tipo == 5) {
								if ($row["facturado"] == 1) {
									$color = "blue";
								} else {
									$hoy = date("Y-m-d");
									$a = date("Y", strtotime($row["fecha_prevision"]));
									$m = date("m", strtotime($row["fecha_prevision"]));
									$d = date("d", strtotime($row["fecha_prevision"]));
									$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
									$fecha_entrega = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
									if ($fecha_entrega < $hoy) {
										$color = "red";
									} else {
										if ($fecha_aviso < $hoy) { $color = "orange"; }
									}
								}
							}
							echo "<tr style=\"background-color : ".$color.";\">";
							echo boton_form("op=1003&sop=101&id_tipo=".$_GET["id_tipo"]."&idfactura=".$_GET["id"]."&id=".$row["id"],$Opciones);
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"linea".$row["id"]."\" value=\"".$row["linea"]."\"></td>";
								$fecha_previ = cambiarFormatoFechaYMD($row["fecha_prevision"]);
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"fecha_prevision".$row["id"]."\" value=\"".$fecha_previ."\"></td>";
								echo "<td style=\"vertical-align:bottom;\"><a href=\"index.php?op=1003&sop=105&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."&classe=3\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td>";
								echo "<td>";
									echo "<select name=\"codigo2".$row["id"]."\">";
									echo "<option value=\"\">-</option>";
									$sql1 = "select codigo from sgm_articles where visible=1 order by codigo";
									$result1 = mysqli_query($dbhandle,convertSQL($sql1));
									while ($row1 = mysqli_fetch_array($result1)) {
										if ($row1["codigo"] == $row["codigo"]){
											echo "<option value=\"".$row1["codigo"]."\" selected>".$row1["codigo"]."</option>";
										} else {
											echo "<option value=\"".$row1["codigo"]."\">".$row1["codigo"]."</option>";
										}
									}
									echo "</select>";
								echo "</td>";
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"codigo".$row["id"]."\" value=\"".$row["codigo"]."\"></td>";
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"nombre".$row["id"]."\" value=\"".$row["nombre"]."\" required></td>";
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"unidades".$row["id"]."\" style=\"text-align:right;\" value=\"".$row["unidades"]."\"></td>";
				#				if (($rowtipos["presu"] == 1) or ($rowtipos["tipo_ot"] == 1)) {
				#					echo "<td style=\"vertical-align:bottom;\"><a href=\"index.php?op=1003&sop=107&tipo=1&id=".$row["id"]."&id_factura=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/calculator_edit.png\" style=\"border:0px;\"></a></td>";
				#				} else {
									echo "<td></td>";
				#				}
								if ($row["pvd"] == 0){
									$sqla = "select preu_cost from sgm_articles_costos where visible=1 and id_cuerpo=".$row["id"]." and aprovat=1";
									$resulta = mysqli_query($dbhandle,convertSQL($sqla));
									$rowa = mysqli_fetch_array($resulta);
									echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"pvd".$row["id"]."\" style=\"text-align:right;background-color:white;color:silver\" value=\"".number_format ($rowa["preu_cost"],3)."\"></td>";
								} else {
									echo "<td><input type=\"Text\" name=\"pvd".$row["id"]."\" style=\"text-align:right;background-color:white;color:silver\" value=\"".number_format ($row["pvd"],3)."\"></td>";
								}
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"pvp".$row["id"]."\" style=\"text-align:right;\" value=\"".number_format ($row["pvp"],3,".","")."\"></td>";
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"descuento".$row["id"]."\" style=\"text-align:right;\" value=\"".number_format ($row["descuento"],3)."\"></td>";
								echo "<td style=\"vertical-align:bottom;\"><input type=\"Text\" name=\"descuento_absoluto".$row["id"]."\" style=\"text-align:right;\" value=\"".number_format ($row["descuento_absoluto"],3)."\"></td>";
								echo "<td style=\"text-align:right;background-color:silver;vertical-align:bottom;\"><strong>".$row["total"]."</strong></td><td>".$row2["abrev"]."</td>";
								if ($rowtipos["presu"] == 1){
									if ($row["suma"] == 0){
										echo boton_form("op=1003&sop=100&ssop=11&id_tipo=".$_GET["id_tipo"]."&id=".$_GET["id"]."&id_linea=".$row["id"],$No." ".$Sumar);
									} else {
										echo boton_form("op=1003&sop=100&ssop=12&id_tipo=".$_GET["id_tipo"]."&id=".$_GET["id"]."&id_linea=".$row["id"],$Sumar);
									}
								}
								if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["v_subtipos"] == 1)){
									if ($row["aprovat"] == 0){
										echo boton_form("op=1003&sop=100&ssop=13&id_tipo=".$_GET["id_tipo"]."&id=".$_GET["id"]."&id_linea=".$row["id"],$Aprobar);
									} else {
										echo "<td></td>";
									}
								}
								echo "<td style=\"vertical-align:bottom;\"><a href=\"index.php?op=1003&sop=107&id=".$row["id"]."&id_factura=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\"><img src=\"mgestion/pics/icons-mini/page_white_stack.png\" style=\"border:0px;\"></a></td>";
							echo "</tr>";
						}
							echo "<tr><td colspan=\"13\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
							echo "</form>";
							$sql = "select id,subtotal,descuento,iva,total_forzado,descuento_absoluto,total,retenciones from sgm_cabezera where id=".$_GET["id"];
							$result = mysqli_query($dbhandle,convertSQL($sql));
							$row = mysqli_fetch_array($result);
							echo "<tr><th style=\"text-align:right;\" colspan=\"13\">".$Subtotal."</th><td style=\"text-align:right;\">".number_format ($row["subtotal"],3)."</td><td>".$row2["abrev"]."</td><td></td></tr>";
							echo "<form action=\"index.php?op=1003&sop=100&ssop=15&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
							echo "<tr><th style=\"text-align:right;\" colspan=\"13\">Desc.%</th><td><input type=\"Text\" name=\"descuento\" style=\"text-align:right;\" value=\"".number_format ($row["descuento"],3)."\"></td><td>%</td><td><input type=\"submit\" value=\"".$Modificar."\"></td></tr>";
							echo "</form>";
							echo "<form action=\"index.php?op=1003&sop=100&ssop=15&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
							echo "<tr><th style=\"text-align:right;\" colspan=\"13\">Desc. ".$row2["abrev"]."</th><td><input type=\"Text\" name=\"descuento_absoluto\" style=\"text-align:right;\" value=\"".number_format ($row["descuento_absoluto"],3)."\"></td><td>".$row2["abrev"]."</td><td><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
							echo "</form>";
							echo "<form action=\"index.php?op=1003&sop=100&ssop=16&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
							echo "<tr><th style=\"text-align:right;\" colspan=\"13\">IVA</th><td><input type=\"Text\" name=\"iva\" style=\"text-align:right;\" value=\"".$row["iva"]."\"></td><td>%</td><td><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
							echo "</form>";
							echo "<form action=\"index.php?op=1003&sop=100&ssop=14&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
							echo "<tr><th style=\"text-align:right;\" colspan=\"13\">".$Retenciones."</th><td><input type=\"Text\" name=\"retenciones\" style=\"text-align:right;\" value=\"".$row["retenciones"]."\"></td><td>%</td><td><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
							echo "</form>";
							echo "<form action=\"index.php?op=1003&sop=100&ssop=17&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
							$color_fondo_total = "white";
							if ($row["total_forzado"] == 1) { $color_fondo_total = "#FF6347"; }
							echo "<tr><th style=\"text-align:right;\" colspan=\"13\">".$Total."</th><td><input type=\"Text\" name=\"total\" style=\"text-align:right;;background-color:".$color_fondo_total."\" value=\"".number_format ($row["total"],3)."\"></td><td>".$row2["abrev"]."</td><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
							echo "</form>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
	}

	if ($soption == 101){
		echo "<h4>".$Opciones."</h4>";
		echo boton(array("op=1003&sop=100&id=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"]),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"1\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\"><tr>";
						echo "<th style=\"width:400px\">".$ConvertirAArticulo."</th>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">".$ayudaCuerpoConvertir."</td>";
					echo "</tr></table>";
					echo "<form action=\"index.php?op=1003&sop=102&id=".$_GET["id"]."&idfactura=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
					echo "<table><tr>";
						echo boton_form("op=1003&sop=102&id=".$_GET["id"]."&idfactura=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"],$Convertir);
					echo "</tr></table></center></form>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\"><tr>";
						echo "<th style=\"width:400px\">".$Eliminar."</th>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">".$ayudaCuerpoEliminar."</td>";
					echo "</tr></table><table><tr>";
						echo boton_form("op=1003&sop=103&id=".$_GET["id"]."&idfactura=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"],$Eliminar);
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table></center>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 102) {
		$sqlc = "select codigo,nombre,unidades,pvd,pvp from sgm_cuerpo where id=".$_GET["id"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		$sqlcf = "select id_divisa from sgm_cabezera where id=".$_GET["idfactura"];
		$resultcf = mysqli_query($dbhandle,convertSQL($sqlcf));
		$rowcf = mysqli_fetch_array($resultcf);

		$sqlar = "select id from sgm_articles where codigo='".$rowc["codigo"]."' or nombre='".$rowc["nombre"]."'";
		$resultar = mysqli_query($dbhandle,convertSQL($sqlar));
		$rowar = mysqli_fetch_array($resultar);
		if (!$rowar){
			$camposInsert = "codigo,nombre";
			$datosInsert = array($rowc["codigo"],$rowc["nombre"]);
			insertFunction ("sgm_articles",$camposInsert,$datosInsert);

			$sql = "select id from sgm_articles where codigo='".$rowc["codigo"]."' and nombre='".$rowc["nombre"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);

			$camposInsert = "id_article,unidades,pvd,id_divisa_pvd,pvp,id_divisa_pvp,vigente,fecha,id_user";
			$datosInsert = array($row["id"],$rowc["unidades"],$rowc["pvd"],$rowcf["id_divisa"],$rowc["pvp"],$rowcf["id_divisa"],1,date("Y-m-d"),$userid);
			insertFunction ("sgm_stock",$camposInsert,$datosInsert);

			$camposUpdate = array("id_article","id_cuerpo");
			$datosUpdate = array($row["id"],0);
			updateFunction ("sgm_articles_costos",$_GET["id"],$camposUpdate,$datosUpdate);

			echo "<table cellpadding=\"1\" cellspacing=\"\" class=\"lista\">";
				echo "<tr>";
					echo boton_form("op=1003&sop=100&id=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"],$Volver);
					echo boton_form("op=1004&sop=100&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"],$Articulo);
				echo "</tr>";
			echo "</table>";
		} else {
				echo mensageError($ErrorAnadirArticulo);
			echo "<table cellpadding=\"1\" cellspacing=\"\" class=\"lista\">";
				echo "<tr>";
					echo boton_form("op=1003&sop=100&id=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"]."&id_tipo=".$_GET["id_tipo"],$Volver);
				echo "</tr>";
			echo "</table>";
		}
	}

	if ($soption == 103) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=100&ssop=6&id=".$_GET["idfactura"]."&id_cuerpo=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"],"op=1003&sop=100&id=".$_GET["idfactura"]."&id_tipo=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 104) {
		echo "<strong>".$Usuarios." ".$Modificadores." :</strong><br><br>";
		echo boton(array("op=1003&sop=100&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"3\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Fecha."</th>";
			echo "</tr>";
			$sql = "select id_usuario,fecha from sgm_factura_modificacio where id_factura=".$_GET["id"]." order by fecha";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlu = "select usuario from sgm_users where id=".$row["id_usuario"];
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);
				echo "<tr>";
					echo "<td>".$rowu["usuario"]."</td>";
					echo "<td>".date("Y-m-d H:i:s",$row["fecha"])."</td>";
				echo "</tr>";
			}
		echo "</table><br>";
	}

	if ($soption == 105) {
		echo "<h4>".$Cambios_fecha ."</h4>";
		echo boton(array("op=1003&sop=100&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Fecha." ".$Cambio."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Fecha." ".$Cambiada."</th>";
			echo "</tr>";
			if ($_GET["classe"] == 1) {
				$sql = "select id_usuario,data,fecha_ant from sgm_factura_canvi_data_prevision where id_factura=".$_GET["id"];
			}
			if ($_GET["classe"] == 2) {
				$sql = "select id_usuario,data,fecha_ant from sgm_factura_canvi_data_entrega where id_factura=".$_GET["id"];
			}
			if ($_GET["classe"] == 3) {
				$sql = "select id_usuario,data,fecha_ant from sgm_factura_canvi_data_prevision_cuerpo where id_factura=".$_GET["id"]." and id_cuerpo=".$_GET["id_cuerpo"];
			}
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$sqlu = "select usuario from sgm_users where id=".$row["id_usuario"];
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);
				echo "<tr>";
					echo "<td>".$row["data"]."</td>";
					echo "<td>".$rowu["usuario"]."</td>";
					echo "<td>".$row["fecha_ant"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 107) {
		echo boton(array("op=1003&sop=100&id=".$_GET["id_factura"]."&id_tipo=".$_GET["id_tipo"]),array("&laquo; ".$Volver));
		anadirArchivo ($_GET["id"],0,"&id_factura=".$_GET["id_factura"]."&id_tipo=".$_GET["id_tipo"]);
	}

	if ($soption == 108) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=107&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."&id_factura=".$_GET["id_factura"]."&id_tipo=".$_GET["id_tipo"],"op=1003&sop=107&id=".$_GET["id"]."&id_factura=".$_GET["id_factura"]."&id_tipo=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 300) {
		echo "<h4>".$Impresion."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Tipo." ".$Documento."</th>";
				echo "<th>".$Fecha." ".$Desde."</th>";
				echo "<th>".$Fecha." ".$Hasta."</th>";
				echo "<th>".$Impresion."</th>";
				echo "<th>".$Idioma."</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturacion-print-pdf.php?\" target=\"_blank\">";
				echo "<td>";
					echo "<select name=\"id_tipo\" style=\"width:200px\">";
					$sqlx = "select id,tipo from sgm_factura_tipos where visible=1 order by tipo";
					$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
					while ($rowx = mysqli_fetch_array($resultx)) {
						echo "<option value=\"".$rowx["id"]."\">".$rowx["tipo"]."</option>";
					}
					echo "</select>";
				echo "</td>";
				$data = cambiarFormatoFechaDMY(date("Y-m-d"));
				echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_desde\" value=\"".$data."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_fins\" value=\"".$data."\"></td>";
				echo "<td><select name=\"tipo\" style=\"width:70px\">";
				echo "<option value=\"0\">".$Sobre."</option>";
				echo "<option value=\"1\">".$No_sobre."</option>";
				echo "</select></td>";
				echo "<td><select name=\"idioma\" style=\"width:90px\">";
				echo "<option value=\"0\">-</option>";
				$sqli = "select predefinido,idioma,descripcion from sgm_idiomas where visible=1";
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				while ($rowi = mysqli_fetch_array($resulti)) {
					if ($rowi["predefinido"] == 1) {
						echo "<option value=\"".$rowi["idioma"]."\" selected>".$rowi["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$rowi["idioma"]."\">".$rowi["descripcion"]."</option>";
					}
				}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
			echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption >= 400) and ($soption < 500)) {
				echo "<table cellpadding=\"1\" cellspacing=\"2\" class=\"lista\">";
					echo "<tr>";
						echo boton_form("op=1003&sop=410",$Calendario);
						echo boton_form("op=1003&sop=420",$Anual);
						echo boton_form("op=1003&sop=430",$Usuarios);
						echo boton_form("op=1003&sop=440",$Tipos);
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr></table><br>";
		echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align:top;text-align:left;\">";
	}
	
	if ($soption == 410) {
		if ($ssoption == 1) {
			echo calendari_economic(1);
		}
		echo "<h4>".$Calendario_Economico." (".$Gastos."/".$Ingresos."/".$Externo."/".$Total.") : </h4>";
		echo "<form action=\"index.php?op=1003&sop=411\" method=\"post\">";
			echo "<input type=\"submit\" value=\"".$Recalcular."\"  style=\"width:100px;\">";
		echo "</form>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$yact = date("Y");
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=410&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=410&y=".$yact."&m=".$_GET["m"]."\">".$yact."</a></td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=410&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
			echo "</tr>";
			echo "<tr>";
				if ($_GET["m"] == "") {
					$mact = date("n");
				} else {
					$mact = $_GET["m"];
				}
				$mant = $mact - 1;
				$mpost = $mact +1;
				if ($mant >= 1){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=410&y=".$yact."&m=".$mant."\">".$mant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=410&y=".$yact."&m=".$mact."\">".$mact."</a></td>";
				if ($mpost <= 12){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=410&y=".$yact."&m=".$mpost."\">&gt;".$mpost."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		$contador=($mact-1);
		$mes = ($mact-1);

		if ($mes == 12){ $any = $yact-1;} else { $any = $yact;}
		$data_iva1 = date("U", mktime(0,0,0,1,30,$any));
		$data_iva2 = date("U", mktime(0,0,0,4,20,$any));
		$data_iva3 = date("U", mktime(0,0,0,7,20,$any));
		$data_iva4 = date("U", mktime(0,0,0,10,20,$any));
		$mes_anterior = date("U", mktime(0,0,0,$mes,1,$any));
		$mes_ultimo = date("U", mktime(0,0,0,$mes+12, 1-1, $yact));
		$dia_actual=$mes_anterior;
		$dia_anterior=$mes_anterior;
		$iva2 = 0;
		while ($dia_actual<=$mes_ultimo){
			$contador=$m;
			$m = date("n", $dia_actual);
			if ($contador != $m){
				echo "</tr><tr><th>".$meses[$m-1]."</th></tr><tr>";
			}
			$hoy = date("Y-m-d");
			$dia_actual2 = date("Y-m-d", $dia_actual);
			if ($hoy == $dia_actual2){ $color_fondo = "yellow";} else { $color_fondo = "white";}
			$d = date("d", $dia_actual);

			$iva = 0;
			
			if (($dia_actual == $data_iva1) or ($dia_actual == $data_iva2) or ($dia_actual == $data_iva3) or ($dia_actual == $data_iva4)) {
				if ($dia_actual == $data_iva1){ $mes1 = 10; $mes2 = 12; $any2 = $any-1;}
				if ($dia_actual == $data_iva2){ $mes1 = 1; $mes2 = 3; $any2 = $any;}
				if ($dia_actual == $data_iva3){ $mes1 = 4; $mes2 = 6; $any2 = $any;}
				if ($dia_actual == $data_iva4){ $mes1 = 7; $mes2 = 9; $any2 = $any;}
				$dia_iva1 = date("Y-m-d", mktime(0,0,0,$mes1,1,$any2));
				$last_day = date('t',strtotime($any2."-".$mes2."-1"));
				$dia_iva2 = date("Y-m-d", mktime(0,0,0,$mes2,$last_day,$any2));
				$sqlgasto = "select sum(total) as total_gasto,sum(subtotaldescuento) as subtotal_gasto from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=-1 and facturable=0) and fecha between '".$dia_iva1."' and '".$dia_iva2."' and id_pagador=1";
				$resultgasto = mysqli_query($dbhandle,$sqlgasto);
				$rowgasto = mysqli_fetch_array($resultgasto);

				$sqlingre1 = "select sum(total) as total_ingre,sum(subtotaldescuento) as subtotal_ingre from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=1 and v_recibos=1) and fecha between '".$dia_iva1."' and '".$dia_iva2."' and id_pagador=1";
				$resultingre1 = mysqli_query($dbhandle,$sqlingre1);
				$rowingre1 = mysqli_fetch_array($resultingre1);

				$iva = ($rowingre1["total_ingre"]-$rowingre1["subtotal_ingre"]) - ($rowgasto["total_gasto"]-$rowgasto["subtotal_gasto"]);
			}
			
			$sqliva = "select id from sgm_cabezera where visible=1 and tipo=12 and fecha>='".$dia_anterior."' and fecha<='".$dia_actual2."' and id_pagador=1";
			$resultiva = mysqli_query($dbhandle,$sqliva);
			$rowiva = mysqli_fetch_array($resultiva);
			if ($rowiva){
				$iva = 0;
				$iva2 = 0;
			} else {
				$iva2 += $iva;
			}
			
			echo "<td style=\"background-color:".$color_fondo."\">";
				echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%\">";
					echo "<tr><th>".$d."</th></tr>";
					$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual."'";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					if ($row["gastos"] > 0) {$color = "red";$color_letra = "white";} else {$color = $color_fondo; $color_letra = "black";}
					if ($row["ingresos"] > 0) {$color3 = "#1EB53A";} else {$color3 = $color_fondo;}
					if (($row["liquido"]-$iva2) >= 0) {$color2 = "#1EB53A"; $color_letra2 = "black";} else {$color2 = "red"; $color_letra2 = "white";}
					if ($dia_actual2 < $hoy){ $tipus = 5;} elseif ($dia_actual2 == $hoy){$tipus = 9;} else { $tipus = 3;}
					echo "<tr><td style=\"text-align:right;background-color:".$color.";\"><a href=\"index.php?op=1003&sop=490&hist=1&tipo=1&fecha=".$dia_actual."\" style=\"color:".$color_letra.";\">".number_format($row["gastos"]+$iva, 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:".$color3."\"><a href=\"index.php?op=1003&sop=490&hist=1&tipo=".$tipus."&fecha=".$dia_actual."\" style=\"color:black;\">".number_format($row["ingresos"], 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:#0084C9\"><a href=\"index.php?op=1003&sop=490&hist=1&tipo=4&fecha=".$dia_actual."\" style=\"color:black;\">".number_format($row["externos"], 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:".$color2.";\">".number_format($row["liquido"]-$iva2, 2)."</td></tr>";
				echo "</table>";
			echo "</td>";
			$proxim_any = date("Y",$dia_actual);
			$proxim_mes = date("m",$dia_actual);
			$proxim_dia = date("d",$dia_actual);
			$dia_anterior = date("Y-m-d",mktime(0,0,0,$proxim_mes,$proxim_dia-6,$proxim_any));
			$dia_actual = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+1,$proxim_any));
		}
		echo "</table>";
	}

	if ($soption == 411) {
		echo "<center>";
		echo "<br><br>".$pregunta_recalculo;
		echo boton(array("op=1003&sop=410&ssop=1","op=1003&sop=410"),array($Si,$No));
		echo "</center>";
	}
	
	if ($soption == 420) {
		echo "<h4>".$Resumen." ".$Anual." (".$Base_imponible."/IVA/".$Total.") : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$yact = date("Y");
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=420&y=".$yant."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=420&y=".$yact."\">".$yact."</a></td>";
				if ($ypost <= (date("Y")+1)){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=420&y=".$ypost."\">&gt;".$ypost."</a></td>";
				} else { echo "<td></td>";}
		echo "</tr></table></center>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				echo "<th></th>";
				$tri = 0;
				$trimes = 1;
				for ($x = 0; $x <= 11; $x++) {
					$m = $x+1;
					$tri++;
					echo "<th style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=421&m=".$m."&y=".$yact."\">".$meses[$x]."</a></th>";
					if ($tri == 3){
						echo "<th style=\"text-align:right;color:blue;\"> TRI ".$trimes."</th>";
						$tri = 0;
						$trimes ++;
					}
				}
				echo "<th style=\"text-align:right;\">".$Total."</th>";
			echo "</tr>";
			$sqltipos = "select id,tipo from sgm_factura_tipos where visible=1 order by orden";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)){
				echo "<tr>";
				$totala1 = 0;
				$totala3 = 0;
				$totala4 = 0;
				$tri = 1;
				$tri1 = 0;
				$tri3 = 0;
				$tri4 = 0;
				echo "<td>".$rowtipos["tipo"]."</td>";
				for ($x = 1; $x <= 12; $x++) {
					$y = $yact;
#					$yf = $yact;
#					if ($x < 10) { $m = "0".$x; } else { $m = $x; }
#					if ($x == 12) { 
#						$mf = "01";
#						$yf = $yact+1;
#					} else {
#						if ($x < 9) { $mf = "0".($x+1); } else { $mf = $x+1; }
#					}
					$dia1 = date("Y-m-d", mktime(0,0,0,$x,1,$y));
					$last_day = date('t',strtotime($y."-".$x."-1"));
					$dia2 = date("Y-m-t", mktime(0,0,0,$x,$last_day,$y));
#					$sql = "select sum(subtotaldescuento) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$rowtipos["id"]." and ((fecha>= '".$y."-".$m."-01') and (fecha<'".$yf."-".$mf."-01'))";
					$sql = "select sum(subtotaldescuento) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$rowtipos["id"]." and fecha between '".$dia1."' and '".$dia2."'";
#					if ($rowtipos["v_recibos"] == 1) { $sql = $sql." and cobrada=1"; }
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=490&tipo=6&hist=1&y=".$y."&m=".$x."&id_tipo=".$rowtipos["id"]."\" style=\"color:black;\">(".$row["total4"].")<br><strong>".number_format($row["total1"], 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($row["total3"]-$row["total1"]), 2, ',', '.')."</strong><br><strong>".number_format($row["total3"], 2, ',', '.')."</strong></a></td>";
					$tri1 = $tri1+$row["total1"];
					$tri3 = $tri3+$row["total3"];
					$tri4 = $tri4+$row["total4"];
					if ($tri == 3) {
						echo "<td style=\"text-align:right;color:blue;\"><a href=\"index.php?op=1003&sop=490&tipo=7&hist=1&y=".$y."&m=".$x."&id_tipo=".$rowtipos["id"]."\" style=\"color:blue;\">(".$tri4.")<br><strong>".number_format($tri1, 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($tri3-$tri1), 2, ',', '.')."</strong><br><strong>".number_format($tri3, 2, ',', '.')."</strong></a></td>";
						$tri = 0;
						$totala1 = $totala1+$tri1;
						$totala3 = $totala3+$tri3;
						$totala4 = $totala4+$tri4;
						$tri1 = 0;
						$tri3 = 0;
						$tri4 = 0;
					} else {
					}
					$tri++;
				}
				echo "<td style=\"text-align:right;color:blue;\">(".$totala4.")<br><strong>".number_format($totala1, 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($totala3-$totala1), 2, ',', '.')."</strong><br><strong>".number_format($totala3, 2, ',', '.')."</strong></td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 421) {
		echo "<h4>".$Resumen." ".$Mensual." (".$Base_imponible."/IVA/".$Total.") : </h4>";
		echo boton(array("op=1003&sop=420"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"5\" class=\"lista\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$yact = date("Y");
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=421&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=421&y=".$yact."&m=".$_GET["m"]."\">".$yact."</a></td>";
				if ($ypost <= (date("Y")+1)){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=421&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
			echo "<tr>";
				if ($_GET["m"] == "") {
					$mact = date("m");
				} else {
					$mact = $_GET["m"];
				}
				$mant = $mact - 1;
				$mpost = $mact +1;
				if ($mant >= 1){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=421&y=".$yact."&m=".$mant."\">".$mant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=421&y=".$yact."&m=".$mact."\">".$mact."</a></td>";
				if ($mpost <= 12){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=421&y=".$yact."&m=".$mpost."\">&gt;".$mpost."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				echo "<td></td>";
				$diasmes = cal_days_in_month(CAL_GREGORIAN, $mact, $yact);
				for ($x = 1; $x <= $diasmes; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$x."</strong></td>";
				}
				echo "<td style=\"text-align:right;\"><strong>".$Total."</strong></td>";
			echo "</tr><tr>";
			$sqltipos = "select id,tipo,v_recibos from sgm_factura_tipos where visible=1 order by orden";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)){
				$totala1 = 0;
				$totala3 = 0;
				$totala4 = 0;
				echo "<td>".$rowtipos["tipo"]."</td>";
				for ($x = 1; $x <= $diasmes; $x++) {
					if ($x < 10) { $d = "0".$x; } else { $d = $x; }
					$sql = "select sum(subtotaldescuento) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$rowtipos["id"]." and fecha='".$yact."-".$mact."-".$d."'";
					if ($rowtipos["v_recibos"] == 1) { $sql = $sql." and cobrada=1"; }
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=490&tipo=8&hist=1&y=".$_GET["y"]."&m=".$_GET["m"]."&d=".$d."&id_tipo=".$rowtipos["id"]."\" style=\"color:black;\">(".$row["total4"].")<br><strong>".number_format($row["total1"], 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($row["total3"]-$row["total1"]), 2, ',', '.')."</strong><br><strong>".number_format($row["total3"], 2, ',', '.')."</strong></a></td>";
					$totala1 = $totala1+$row["total1"];
					$totala3 = $totala3+$row["total3"];
					$totala4 = $totala4+$row["total4"];
				}
				echo "<td style=\"text-align:right;color:blue;\">(".$totala4.")<br><strong>".number_format($totala1, 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($totala3-$totala1), 2, ',', '.')."</strong><br><strong>".number_format($totala3, 2, ',', '.')."</strong></td>";
				echo "</tr><tr>";
			}
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 430) {
		echo "<h4>".$Resumen." ".$Usuarios."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Total."</th>";
			echo "</tr>";
			$sqls= "select id,usuario from sgm_users where activo=1 and validado=1 and sgm=1 order by usuario";
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			while ($rows = mysqli_fetch_array($results)) {
				$sqlf= "select sum(total) as totales from sgm_cabezera where visible=1 and tipo=5 and id_pagador=".$rows["id"];
				$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
				$rowf = mysqli_fetch_array($resultf);
				echo "<tr>";
					echo "<td style=\"text-align:left;width:150px\"><a href=\"index.php?op=1003&sop=490&iduser=".$rows["id"]."&hist=1\">".$rows["usuario"]."</a></td>";
					echo "<td style=\"text-align:right;width:100px\">".number_format($rowf["totales"], 2, ',', '.')." ".$rowdiv["abrev"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 440) {
		echo "<h4>".$Resumen." ".$Tipos." (".$Base_imponible."/IVA/".$Total.") : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1003&sop=440\" method=\"post\">";
			echo "<tr>";
				echo "<th style=\"text-align:center;\">".$Tipo." : </th>";
				echo "<td><select name=\"id_tipo\">";
				$sqltipos = "select id,tipo from sgm_factura_tipos where visible=1 order by orden";
				$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
				while ($rowtipos = mysqli_fetch_array($resulttipos)) {
					if ($_POST["id_tipo"] == $rowtipos["id"]) {
						echo "<option value=\"".$rowtipos["id"]."\" selected>".$rowtipos["tipo"]."</option>";
					} else {
						echo "<option value=\"".$rowtipos["id"]."\">".$rowtipos["tipo"]."</option>";
					}
				}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Enviar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"8\" class=\"lista\">";
			echo "<tr>";
		for ($i = date("Y"); $i >= 2012; $i--) {
			$totala1 = 0;
			$totala3 = 0;
			$totala4 = 0;
			echo "</tr><tr style=\"background-color:silver;\">";
				echo "<th style=\"text-align:left;\" colspan=\"17\">".$i."</th>";
			echo "</tr><tr>";
				$tri = 0;
				$trimes = 1;
				for ($x = 0; $x <= 11; $x++) {
					$m = $x+1;
					$tri++;
					echo "<th style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=421&m=".$m."&y=".$yact."\">".$meses[$x]."</a></th>";
					if ($tri == 3){
						echo "<th style=\"text-align:right;color:blue;\"> TRI ".$trimes."</th>";
						$tri = 0;
						$trimes ++;
					}
				}
				echo "<th style=\"text-align:center;\">".$Total."</th>";
			echo "</tr></tr>";
				$tri = 1;
				$tri1 = 0;
				$tri3 = 0;
				$tri4 = 0;
				for ($x = 1; $x <= 12; $x++) {
					$y = $i;
#					$yf = $yact;
#					if ($x < 10) { $m = "0".$x; } else { $m = $x; }
#					if ($x == 12) { 
#						$mf = "01";
#						$yf = $yact+1;
#					} else {
#						if ($x < 9) { $mf = "0".($x+1); } else { $mf = $x+1; }
#					}
					$dia1 = date("Y-m-d", mktime(0,0,0,$x,1,$y));
					$last_day = date('t',strtotime($y."-".$x."-1"));
					$dia2 = date("Y-m-t", mktime(0,0,0,$x,$last_day,$y));
					$sql = "select sum(subtotaldescuento) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$_POST["id_tipo"]." and fecha between '".$dia1."' and '".$dia2."'";
#					$sql = "select sum(subtotaldescuento) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$_POST["id_tipo"]." and ((fecha>= '".$y."-".$m."-01') and (fecha<'".$yf."-".$mf."-01'))";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=490&tipo=6&hist=1&y=".$y."&m=".$x."&id_tipo=".$_POST["id_tipo"]."\" style=\"color:black;\">(".$row["total4"].")<br><strong>".number_format($row["total1"], 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($row["total3"]-$row["total1"]), 2, ',', '.')."</strong><br><strong>".number_format($row["total3"], 2, ',', '.')."</strong></a></td>";
					$tri1 = $tri1+$row["total1"];
					$tri3 = $tri3+$row["total3"];
					$tri4 = $tri4+$row["total4"];
					if ($tri == 3) {
						echo "<td style=\"text-align:right;color:blue;\"><a href=\"index.php?op=1003&sop=490&tipo=7&hist=1&y=".$y."&m=".$x."&id_tipo=".$_POST["id_tipo"]."\" style=\"color:blue;\">(".$tri4.")<br><strong>".number_format($tri1, 2, ',', '.')."</strong><br><strong style=\"color:blue;\">".number_format(($tri3-$tri1), 2, ',', '.')."</strong><br><strong>".number_format($tri3, 2, ',', '.')."</strong></a></td>";
						$tri = 0;
						$totala1 = $totala1+$tri1;
						$totala3 = $totala3+$tri3;
						$totala4 = $totala4+$tri4;
						$tri1 = 0;
						$tri3 = 0;
						$tri4 = 0;
					} else {
					}
				$tri++;
				}
				echo "<td style=\"text-align:right;color:blue;\">(".$totala4.")<br><strong>".number_format($totala1, 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($totala3-$totala1), 2, ',', '.')."</strong><br><strong>".number_format($totala3, 2, ',', '.')."</strong></td>";
		}
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 490) {
		$presu = 0;
		$v_fecha_pre = 0;
		$v_fecha_ven = 0;
		$v_numero_cli = 0;
		$v_rfq = 0;
		$tpv = 1;
		$v_sub = 0;
		$v_docs = 0;
		$v_recibo = 0;
		if (($_GET["tipo"] == 1) or ($_GET["tipo"] == 4) or ($_GET["iduser"] > 0)) {$sqltipo = "select * from sgm_factura_tipos where contabilidad=-1";}
		if (($_GET["tipo"] == 3) or ($_GET["tipo"] == 5) or ($_GET["tipo"] == 9)) {$sqltipo = "select * from sgm_factura_tipos where contabilidad=1";}
		if (($_GET["tipo"] == 6) or ($_GET["tipo"] == 7) or ($_GET["tipo"] == 8)) {$sqltipo = "select * from sgm_factura_tipos where id =".$_GET["id_tipo"];}
#		echo $sqltipo;
		$resulttipo = mysqli_query($dbhandle,convertSQL($sqltipo));
		while ($rowtipo = mysqli_fetch_array($resulttipo)){
			if ($rowtipo["presu"] == 1){ $presu = 1;}
			if ($rowtipo["v_fecha_prevision"] == 1) { $v_fecha_pre = 1;}
			if ($rowtipo["v_fecha_vencimiento"] == 1) { $v_fecha_ven = 1;}
			if ($rowtipo["v_numero_cliente"] == 1) { $v_numero_cli = 1;}
			if ($rowtipo["v_rfq"] == 1) { $v_rfq = 1;}
			if ($rowtipo["tpv"] == 0) { $tpv = 0;}
			if ($rowtipo["v_subtipos"] == 1) { $v_sub = 1;}
			if (($rowtipo["v_recibos"] == 0) and ($rowtipo["v_fecha_prevision"] == 0) and ($rowtipo["v_rfq"] == 0) and ($rowtipo["presu"] == 0) and ($rowtipo["dias"] == 0) and ($rowtipo["v_fecha_vencimiento"] == 0) and ($rowtipo["v_numero_cliente"] == 0) and ($rowtipo["tipo_ot"] == 0)) { $v_docs = 1;}
			if ($rowtipo["v_recibos"] == 1) { $v_recibo = 1;}
		}
		echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th></th>";
				if ($v_docs == 1) { echo "<th>Docs</th>";} else {echo "<th></th>";}
				echo "<th>".$Numero."</th>";
				if ($presu == 1) { echo "<th>Ver.</th>";} else {echo "<th></th>";}
				echo "<th>".$Fecha."</th>";
				if ($v_fecha_pre == 1) { echo "<th>".$Fecha." ".$Prevision."</th>";} else {echo "<th></th>";}
				if ($v_fecha_ven == 1) { echo "<th>".$Vencimiento."</th>";} else {echo "<th></th>";}
				if ($v_numero_cli == 1) { echo "<th>Ref. Ped. Cli.</th>";} else {echo "<th></th>";}
				if ($v_rfq == 1) { echo "<th>".$Numero." RFQ</th>";} else {echo "<th></th>";}
				if ($tpv == 0) { echo "<th>".$Cliente."</th>";} else {echo "<th></th>";}
				if ($v_sub == 1) { echo "<th>".$Subtipo."</th>";} else {echo "<th></th>";}
				echo "<th style=\"text-align:right\">".$Subtotal."</th>";
				echo "<th style=\"text-align:right\">".$Total."</th>";
				if ($v_recibo == 1)  {echo "<th style=\"text-align:right;\">".$Pendiente."</th>";} else {echo "<th></th>";}
			echo "</tr>";
			$totalSensePagar = 0;
			$totalSenseIVA = 0;
			$totalPagat = 0;
			$fechahoy = getdate();
			$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-300, $fechahoy["year"]));
			$hoy = date("Y-m-d");
			$sqlca = "select * from sgm_cabezera where visible=1 ";
			if ($_GET["tipo"] == 1) {$sqlca .= " AND tipo IN (select id from sgm_factura_tipos where contabilidad=-1) and id_pagador=1";}
			if ($_GET["tipo"] == 3) {$sqlca .= " AND tipo IN (select id from sgm_factura_tipos where contabilidad=1)";}
			if ($_GET["tipo"] == 4) {$sqlca .= " AND tipo IN (select id from sgm_factura_tipos where contabilidad=-1) and id_pagador<>1";}
			if ($_GET["tipo"] == 5) {$sqlca .= " and tipo IN (select id from sgm_factura_tipos where contabilidad=1) and id in (select id_factura from sgm_recibos where fecha='".date("Y-m-d", $_GET["fecha"])."' and visible=1)";}
			if ($_GET["iduser"] != "") {$sqlca .= " and id_pagador=".$_GET["iduser"];}
			if (($_GET["tipo"] != 4) and ($_GET["tipo"] != 5) and ($_GET["iduser"] <= 0)){$sqlca = $sqlca." AND fecha_vencimiento='".date("Y-m-d", $_GET["fecha"])."'";}
			if ($_GET["tipo"] == 6) {$sqlca = "select * from sgm_cabezera where visible=1 and tipo=".$_GET["id_tipo"]." and fecha between '".$_GET["y"]."-".$_GET["m"]."-01' and '".$_GET["y"]."-".$_GET["m"]."-31'";}
			if ($_GET["tipo"] == 7) {$sqlca = "select * from sgm_cabezera where visible=1 and tipo=".$_GET["id_tipo"]." and fecha between '".$_GET["y"]."-".($_GET["m"]-2)."-01' and '".$_GET["y"]."-".$_GET["m"]."-31'";}
			if ($_GET["tipo"] == 8) {$sqlca = "select * from sgm_cabezera where visible=1 and tipo=".$_GET["id_tipo"]." and fecha='".$_GET["y"]."-".$_GET["m"]."-".$_GET["d"]."'";}
			if ($_GET["tipo"] == 9) {$sqlca = "select * from sgm_cabezera where visible=1 and ((tipo IN (select id from sgm_factura_tipos where contabilidad=1) AND fecha_vencimiento='".date("Y-m-d", $_GET["fecha"])."') or (id in (select id_factura from sgm_recibos where fecha='".date("Y-m-d", $_GET["fecha"])."' and visible=1)))";}
			$sqlca = $sqlca." order by numero desc,version desc,fecha desc";
#			echo $sqlca;
			$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
			while ($rowca = mysqli_fetch_array($resultca)) {
				echo mostrarFacturas($rowca);
			}
			echo "<tr>";
				echo "<td colspan=\"11\" style=\"text-align:right;\"><strong>".$Total."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".number_format($totalSenseIVA,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".number_format($totalSensePagar,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";
				if ($rowtipos["v_recibos"] == 1)  {echo "<td style=\"text-align:right;\"><strong>".number_format($totalPagat,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";}
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1003&sop=510","op=1003&sop=520","op=1003&sop=530","op=1003&sop=540","op=1003&sop=550","op=1003&sop=560","op=1003&sop=570"),array($Datos." ".$Origen,$Logos,$Tipos,$Permisos,$Relaciones,$Divisas,$Fuentes));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1) {
			$sql = "select count(*) as total from sgm_dades_origen_factura";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if ($row["total"] == 0){
				$camposinsert = "nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,iva";
				$datosInsert = array($_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["mail"],$_POST["telefono"],$_POST["iva"]);
				insertFunction ("sgm_dades_origen_factura",$camposinsert,$datosInsert);
			}
			if ($row["total"] == 1) {
				$camposUpdate = array("nombre","nif","direccion","poblacion","cp","provincia","mail","telefono","iva");
				$datosUpdate = array($_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["mail"],$_POST["telefono"],$_POST["iva"]);
				updateFunction ("sgm_dades_origen_factura","1",$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 2) {
			$camposinsert = "id_dades_origen_factura,entidad_bancaria,iban,descripcion,swift_bic";
			$datosInsert = array($_GET["id"],$_POST["entidad_bancaria"],$_POST["iban"],$_POST["descripcion"],$_POST["swift_bic"]);
			insertFunction ("sgm_dades_origen_factura_iban",$camposinsert,$datosInsert);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("entidad_bancaria","iban","descripcion","swift_bic");
			$datosUpdate = array($_POST["entidad_bancaria"],$_POST["iban"],$_POST["descripcion"],$_POST["swift_bic"]);
			updateFunction ("sgm_dades_origen_factura_iban",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "delete from sgm_dades_origen_factura_iban WHERE id=".$_GET["id"];
			mysqli_query($dbhandle,convertSQL($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_dades_origen_factura_iban set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$camposUpdate = array("predefinido");
			$datosUpdate = array("1");
			updateFunction ("sgm_dades_origen_factura_iban",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			$camposUpdate = array("predefinido");
			$datosUpdate = array("0");
			updateFunction ("sgm_dades_origen_factura_iban",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Datos." ".$Origen."</h4>";
		echo boton(array("op=1003&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\" style=\"width:100%\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:30%\">";
					$sql = "select * from sgm_dades_origen_factura";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<table style=\"width:100%\">";
					echo "<form action=\"index.php?op=1003&sop=510&ssop=1\" method=\"post\">";
						echo "<tr><th style=\"width:30%\">".$Nombre."</th><td style=\"width:70%\"><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"></td></tr>";
						echo "<tr><th>".$NIF."</th><td><input type=\"Text\" name=\"nif\" value=\"".$row["nif"]."\"></td></tr>";
						echo "<tr><th>".$Direccion."</th><td><input type=\"Text\" name=\"direccion\" value=\"".$row["direccion"]."\"></td></tr>";
						echo "<tr><th>".$Poblacion."</th><td><input type=\"Text\" name=\"poblacion\" value=\"".$row["poblacion"]."\"></td></tr>";
						echo "<tr><th>".$Codigo." ".$Postal."</th><td><input type=\"Text\" name=\"cp\" value=\"".$row["cp"]."\"></td></tr>";
						echo "<tr><th>".$Provincia."</th><td><input type=\"Text\" name=\"provincia\" value=\"".$row["provincia"]."\"></td></tr>";
						echo "<tr><th>".$Email."</th><td><input type=\"Text\" name=\"mail\" value=\"".$row["mail"]."\"></td></tr>";
						echo "<tr><th>".$Telefono."</th><td><input type=\"tel\" pattern=\"".$reg_exp_telf."\" name=\"telefono\" value=\"".$row["telefono"]."\" placeholder=\"000000000\"></td></tr>";
						echo "<tr><th>I.V.A.</th><td><input type=\"Text\" name=\"iva\" value=\"".$row["iva"]."\"></td></tr>";
						echo "<tr><th></th><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
					echo "</form>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:70%\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%\">";
						echo "<tr style=\"background-color : Silver;\">";
							echo "<th></th>";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Entidad." ".$Bancaria."</th>";
							echo "<th>IBAN</th>";
							echo "<th>SWIFT/BIC</th>";
							echo "<th>".$Descripcion."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
						echo "<form action=\"index.php?op=1003&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td style=\"width:10%\"><input type=\"Text\" name=\"entidad_bancaria\"></td>";
							echo "<td style=\"width:40%\"><input type=\"Text\" name=\"iban\"></td>";
							echo "<td style=\"width:10%\"><input type=\"Text\" name=\"swift_bic\"></td>";
							echo "<td style=\"width:20%\"><input type=\"Text\" name=\"descripcion\"></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
						echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql2 = "select id,predefinido,entidad_bancaria,iban,swift_bic,descripcion from sgm_dades_origen_factura_iban where id_dades_origen_factura=".$row["id"];
						$result2 = mysqli_query($dbhandle,convertSQL($sql2));
						while ($row2 = mysqli_fetch_array($result2)) {
							echo "<tr>";
					$color = "white";
					if ($row2["predefinido"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
							echo "<td class=\"submit\">";
						if ($row2["predefinido"] == 1) {
							echo "<form action=\"index.php?op=1003&sop=510&ssop=6&id=".$row2["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
							echo "</form>";
							echo "<td></td>";
						}
						if ($row2["predefinido"] == 0) {
							echo "<form action=\"index.php?op=1003&sop=510&ssop=5&id=".$row2["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Predeterminar."\">";
							echo "</form>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=511&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						}
							echo "<form action=\"index.php?op=1003&sop=510&ssop=3&id=".$row2["id"]."\" method=\"post\">";
							echo "<td><input type=\"Text\" name=\"entidad_bancaria\" style=\"width:100%\" value=\"".$row2["entidad_bancaria"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"iban\" style=\"width:100%\" value=\"".$row2["iban"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"swift_bic\" style=\"width:100%\" value=\"".$row2["swift_bic"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:100%\" value=\"".$row2["descripcion"]."\"></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
							echo "</form>";
						echo "</tr>";
					}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 511) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=510&ssop=4&id=".$_GET["id"],"op=1003&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) and ($admin == true)) {
		if ($ssoption == 1) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				echo $archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
				$tipo = $_POST["id_tipo"];
				$id_cuerpo = $_POST["id_cuerpo"];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				echo $archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
				$tipo = $HTTP_POST_VARS["id_tipo"];
				$id_cuerpo = $HTTP_POST_VARS["id_cuerpo"];
			}
			$sql = "select limite_kb from sgm_files_tipos where id=".$tipo;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$lim_tamano = $row["limite_kb"]*1000;
			if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
				if ($_GET["logo"] == 1){$archivo_name = "logo1.jpg";}
				if ($_GET["logo"] == 3){$archivo_name = "logo3.jpg";}
				if (copy ($archivo, "pics/".$archivo_name)) {
					if ($_GET["logo"] == 1){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo1='".$archivo_name."'";
						mysqli_query($dbhandle,convertSQL($sql));
					}
					if ($_GET["logo"] == 3){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo_ticket='".$archivo_name."'";
						mysqli_query($dbhandle,convertSQL($sql));
					}
				}
			}else{
				echo mensageError($errorSubirArchivoTamany);
			}
		}
		if ($ssoption == 2) {
			$sql = "update sgm_dades_origen_factura set ";
			if ($_GET["logo"] == 1){ $sql = $sql."logo1=''";}
			if ($_GET["logo"] == 3){ $sql = $sql."logo_ticket=''";}
			mysqli_query($dbhandle,convertSQL($sql));
		}
		echo "<h4>".$Logos."</h4>";
		echo boton(array("op=1003&sop=500"),array("&laquo; ".$Volver));
		$sqlele = "select logo1,logo_ticket from sgm_dades_origen_factura";
		$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
		$rowele = mysqli_fetch_array($resultele);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"70%\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						echo "<tr><td colspan=\"2\"><strong>".$Logo." ".$Factura." (320x70 pixels):</strong></td></tr>";
						if ($rowele["logo1"] != ""){
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1003&ssop=521&logo=1\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td><a href=\"mgestion/pics/".$rowele["logo1"]."\" target=\"_blank\"><strong>".$rowele["logo1"]."</a></strong></td>";
							echo "</tr>";
							echo "<tr><td colspan=\"2\"><img src=\"mgestion/pics/".$rowele["logo1"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1003&sop=520&ssop=1&logo=1\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"mgestion/pics/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:white;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						echo "<tr><td colspan=\"2\"><strong>".$Logo." Ticket (50x50 pixels):</strong></td></tr>";
						if ($rowele["logo_ticket"] != ""){
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1003&ssop=521&logo=3\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td><a href=\"mgestion/pics/".$rowele["logo_ticket"]."\" target=\"_blank\"><strong>".$rowele["logo_ticket"]."</a></strong></td>";
							echo "</tr>";
							echo "<tr><td colspan=\"2\"><img src=\"mgestion/pics/".$rowele["logo_ticket"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1003&sop=520&ssop=1&logo=3\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"mgestion/pics/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 521) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=520&ssop=2&logo=".$_GET["logo"],"op=1003&sop=520"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 530) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "tipo,orden,descripcion,dias,facturable,tpv,caja,v_fecha_prevision,v_fecha_prevision_dias,v_fecha_vencimiento,v_numero_cliente,v_subtipos,v_pesobultos,v_recibos,tipo_ot,presu,presu_dias,stock,aprovado,v_rfq,contabilidad";
			$datosInsert = array($_POST["tipo"],$_POST["orden"],$_POST["descripcion"],$_POST["dias"],$_POST["facturable"],$_POST["tpv"],$_POST["caja"],$_POST["v_fecha_prevision"],$_POST["v_fecha_prevision_dias"],$_POST["v_fecha_vencimiento"],$_POST["v_numero_cliente"],$_POST["v_subtipos"],$_POST["v_pesobultos"],$_POST["v_recibos"],$_POST["tipo_ot"],$_POST["presu"],$_POST["presu_dias"],$_POST["stock"],$_POST["aprovado"],$_POST["v_rfq"],$_POST["contabilidad"]);
			insertFunction ("sgm_factura_tipos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("tipo","orden","descripcion","dias","facturable","tpv","caja","v_fecha_prevision","v_fecha_prevision_dias","v_fecha_vencimiento","v_numero_cliente","v_subtipos","v_pesobultos","v_recibos","tipo_ot","presu","presu_dias","stock","aprovado","v_rfq","contabilidad");
			$datosUpdate = array($_POST["tipo"],$_POST["orden"],$_POST["descripcion"],$_POST["dias"],$_POST["facturable"],$_POST["tpv"],$_POST["caja"],$_POST["v_fecha_prevision"],$_POST["v_fecha_prevision_dias"],$_POST["v_fecha_vencimiento"],$_POST["v_numero_cliente"],$_POST["v_subtipos"],$_POST["v_pesobultos"],$_POST["v_recibos"],$_POST["tipo_ot"],$_POST["presu"],$_POST["presu_dias"],$_POST["stock"],$_POST["aprovado"],$_POST["v_rfq"],$_POST["contabilidad"]);
			updateFunction ("sgm_factura_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_factura_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Tipos."</h4>";
		echo boton(array("op=1003&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<th></th>";
				echo "<th>".$Orden."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_orden."\"></th>";
				echo "<th>".$Tipo."</th>";
#				echo "<th>".$Descripcion."</th>";
				echo "<th>".$Plantilla."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_plantilla."\"></th>";
				echo "<th>".$Dias."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_plantilla_dias."\"></th>";
				echo "<th>V.Prev<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_prevision."\"></th>";
				echo "<th>".$Dias."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_prevision_dias."\"></th>";
				echo "<th>V.Venc<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_vencimiento."\"></th>";
				echo "<th>V.Ref<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_referencia_cliente."\"></th>";
				echo "<th>V.Sub<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_subtipo."\"></th>";
				echo "<th>V.Rec<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_recibos."\"></th>";
				echo "<th>Presu<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_presupuesto."\"></th>";
				echo "<th>".$Dias."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_presupuesto_dias."\"></th>";
				echo "<th>".$Stock."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_stock."\"></th>";
				echo "<th>".$Aprobar."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_aprobar."\"></th>";
				echo "<th>V.RFQ<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_ver_rfq."\"></th>";
				echo "<th>".$Caja."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_facturacion_caja."\"></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1003&sop=530&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"width:50px\"><input type=\"number\" min=\"0\" name=\"orden\" value=\"0\" style=\"width:100%\"></td>";
				echo "<td style=\"width:25%\"><input type=\"Text\" name=\"tipo\" style=\"width:100%\"></td>";
#				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:100%\"></td>";
				echo "<td><select name=\"facturable\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td style=\"width:35px\"><input type=\"number\" min=\"0\" name=\"dias\" value=\"0\" style=\"width:100%\"></td>";
				echo "<td><select name=\"v_fecha_prevision\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td style=\"width:35px\"><input type=\"number\" min=\"0\" name=\"v_fecha_prevision_dias\" value=\"0\" style=\"width:100%\"></td>";
				echo "<td><select name=\"v_fecha_vencimiento\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_numero_cliente\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_subtipos\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_recibos\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"presu\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td style=\"width:35px\"><input type=\"number\" min=\"0\" name=\"presu_dias\" value=\"0\" style=\"width:100%\"></td>";
				echo "<td><select name=\"stock\">";
					echo "<option value=\"0\" selected>=</option>";
					echo "<option value=\"-1\">-</option>";
					echo "<option value=\"1\">+</option>";
				echo "</select></td>";
				echo "<td><select name=\"aprovado\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_rfq\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"contabilidad\">";
					echo "<option value=\"0\" selected>=</option>";
					echo "<option value=\"-1\">-</option>";
					echo "<option value=\"1\">+</option>";
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqltipos = "select * from sgm_factura_tipos where visible=1 order by orden,descripcion";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)) {
				echo "<form action=\"index.php?op=1003&sop=530&ssop=2&id=".$rowtipos["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=501&id=".$rowtipos["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input type=\"number\" name=\"orden\" value=\"".$rowtipos["orden"]."\" style=\"width:100%\"></td>";
					echo "<td><input type=\"Text\" name=\"tipo\" value=\"".$rowtipos["tipo"]."\" style=\"width:100%\"></td>";
#					echo "<td><input type=\"Text\" name=\"descripcion\" value=\"".$rowtipos["descripcion"]."\" style=\"width:100%\"></td>";
					echo "<td><select name=\"facturable\">";
						if ($rowtipos["facturable"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["facturable"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"number\" name=\"dias\" value=\"".$rowtipos["dias"]."\" style=\"width:100%\"></td>";
					echo "<td><select name=\"v_fecha_prevision\">";
						if ($rowtipos["v_fecha_prevision"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_fecha_prevision"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"number\" name=\"v_fecha_prevision_dias\" value=\"".$rowtipos["v_fecha_prevision_dias"]."\" style=\"width:100%\"></td>";
					echo "<td><select name=\"v_fecha_vencimiento\">";
						if ($rowtipos["v_fecha_vencimiento"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_fecha_vencimiento"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_numero_cliente\">";
						if ($rowtipos["v_numero_cliente"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_numero_cliente"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_subtipos\">";
						if ($rowtipos["v_subtipos"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_subtipos"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_recibos\">";
						if ($rowtipos["v_recibos"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_recibos"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"presu\">";
						if ($rowtipos["presu"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["presu"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"number\" name=\"presu_dias\" value=\"".$rowtipos["presu_dias"]."\" style=\"width:100%\"></td>";
					echo "<td><select name=\"stock\">";
						if ($rowtipos["stock"] == 0) {
							echo "<option value=\"0\" selected>=</option>";
							echo "<option value=\"-1\">-</option>";
							echo "<option value=\"1\">+</option>";
						}
						if ($rowtipos["stock"] == -1) {
							echo "<option value=\"0\">=</option>";
							echo "<option value=\"-1\" selected>-</option>";
							echo "<option value=\"1\">+</option>";
						}
						if ($rowtipos["stock"] == 1) {
							echo "<option value=\"0\">=</option>";
							echo "<option value=\"-1\">-</option>";
							echo "<option value=\"1\" selected>+</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"aprovado\">";
						if ($rowtipos["aprovado"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["aprovado"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_rfq\">";
						if ($rowtipos["v_rfq"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_rfq"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"contabilidad\">";
						if ($rowtipos["contabilidad"] == 0) {
							echo "<option value=\"0\" selected>=</option>";
							echo "<option value=\"-1\">-</option>";
							echo "<option value=\"1\">+</option>";
						}
						if ($rowtipos["contabilidad"] == -1) {
							echo "<option value=\"0\">=</option>";
							echo "<option value=\"-1\" selected>-</option>";
							echo "<option value=\"1\">+</option>";
						}
						if ($rowtipos["contabilidad"] == 1) {
							echo "<option value=\"0\">=</option>";
							echo "<option value=\"-1\">-</option>";
							echo "<option value=\"1\" selected>+</option>";
						}
					echo "</select></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "<td>";
						echo boton_form("op=1003&sop=535&id=".$rowtipos["id"],$Opciones);
					echo "</td>";
				echo "</tr>";
				echo "</form>";
			}
		echo "</table>";
	}

	if (($soption == 531) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=530&ssop=3&id=".$_GET["id"],"op=1003&sop=530"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 535) and ($admin == true)) {
		if ($ssoption == 1){
			$camposInsert = "id_tipo,subtipo";
			$datosInsert = array($_GET["id"],$_POST["subtipo"]);
			insertFunction ("sgm_factura_subtipos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("subtipo");
			$datosUpdate = array($_POST["subtipo"]);
			updateFunction ("sgm_factura_subtipos",$_GET["id_sub"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3){
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_factura_subtipos",$_GET["id_sub"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "select id from sgm_idiomas where visible=1";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqli = "select id from sgm_factura_tipos_idiomas where id_tipo=".$_GET["id"]." and id_idioma=".$row["id"];
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				$rowi = mysqli_fetch_array($resulti);
				if ($rowi){
					$camposUpdate = array("tipo");
					$datosUpdate = array($_POST["tipo".$row["id"]]);
					updateFunction ("sgm_factura_tipos_idiomas",$rowi["id"],$camposUpdate,$datosUpdate);
				} else {
					$camposInsert = "id_tipo,id_idioma,tipo";
					$datosInsert = array($_GET["id"],$row["id"],$_POST["tipo".$row["id"]]);
					insertFunction ("sgm_factura_tipos_idiomas",$camposInsert,$datosInsert);
				}
			}
		}
		$sqltipos = "select tipo from sgm_factura_tipos where visible=1 and id=".$_GET["id"];
		$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
		$rowtipos = mysqli_fetch_array($resulttipos);
		echo "<h4>".$rowtipos["tipo"]."</h4>";
		echo boton(array("op=1003&sop=530"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"70%\">";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th></th>";
							echo "<th>".$Idiomas."</th>";
						echo "</tr>";
						echo "<form method=\"post\" action=\"index.php?op=1003&sop=535&ssop=4&id=".$_GET["id"]."\">";
						$sql = "select id,descripcion from sgm_idiomas where visible=1";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							$sqli = "select tipo from sgm_factura_tipos_idiomas where id_tipo=".$_GET["id"]." and id_idioma=".$row["id"];
							$resulti = mysqli_query($dbhandle,convertSQL($sqli));
							$rowi = mysqli_fetch_array($resulti);
							echo "<tr>";
								echo "<td>".$row["descripcion"]."</td>";
								echo "<td><input type=\"Text\" name=\"tipo".$row["id"]."\" value=\"".$rowi["tipo"]."\"></td>";
							echo "</tr>";
						}
						echo "<tr><td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
						echo "</form>";
					echo "</table>";
				echo "</td><td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Subtipos."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<form action=\"index.php?op=1003&sop=535&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
						echo "<tr>";
							echo "<td></td>";
							echo "<td><input type=\"text\" name=\"subtipo\"></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
						echo "</tr>";
						echo "</form>";
						$sqlstipos = "select id,subtipo from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
						$resultstipos = mysqli_query($dbhandle,convertSQL($sqlstipos));
						while ($rowstipos = mysqli_fetch_array($resultstipos)) {
							echo "<form action=\"index.php?op=1003&sop=535&ssop=2&id=".$_GET["id"]."&id_sub=".$rowstipos["id"]."\" method=\"post\">";
							echo "<tr>";
								echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=536&id=".$_GET["id"]."&id_sub=".$rowstipos["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td><input type=\"text\" value=\"".$rowstipos["subtipo"]."\" name=\"subtipo\"></td>";
								echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
							echo "</tr>";
							echo "</form>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 536) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=535&ssop=3&id=".$_GET["id"]."&id_sub=".$_GET["id_sub"],"op=1003&sop=535&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 540) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "id_user,id_tipo,admin";
			$datosInsert = array($_POST["id_user"].$_GET["id_user"],$_GET["id_tipo"].$_POST["id_tipo"],$_POST["admin"]);
			insertFunction ("sgm_factura_tipos_permisos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("admin");
			$datosUpdate = array($_POST["admin"]);
			updateFunction ("sgm_factura_tipos_permisos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_factura_tipos_permisos",$_GET["id"]);
		}

		echo "<h4>".$Permisos."</h4>";
		echo boton(array("op=1003&sop=500","op=1003&sop=540&tip=1","op=1003&sop=540&tip=2"),array("&laquo; ".$Volver,$Ver_Por_Tipo,$Ver_Por_Usuario));
		if (($soption == 540) and ($_GET["tip"] == 1)) {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color : Silver;\">";
					echo "<th>".$Tipo."</th>";
					echo "<th>".$Eliminar."</th>";
					echo "<th>".$Usuario."</th>";
					echo "<th>".$Admin."</th>";
				echo "</tr>";
				$sql = "select id,tipo from sgm_factura_tipos where visible=1 order by tipo";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=540&tip=1&ssop=1&id_tipo=".$row["id"]."\" method=\"post\">";
						echo "<td style=\"width:150px;text-align:right;\">".$row["tipo"]."</td>";
						echo "<td></td>";
						echo "<td><select name=\"id_user\" style=\"width:150px\">";
							echo "<option value=\"0\">-</option>";
							$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
							$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
							while ($rowx = mysqli_fetch_array($resultx)) {
								echo "<option value=\"".$rowx["id"]."\">".$rowx["usuario"]."</option>";
							}
						echo "</select></td>";
						echo "<td><select name=\"admin\" style=\"width:50px\">";
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						echo "</select></td>";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
					echo "</form>";
					echo "</tr>";
					$sql2 = "select id,id_user,admin from sgm_factura_tipos_permisos where id_tipo=".$row["id"];
					$result2 = mysqli_query($dbhandle,convertSQL($sql2));
					while ($row2 = mysqli_fetch_array($result2)) {
						$sqlv = "select usuario from sgm_users where id=".$row2["id_user"];
						$resultv = mysqli_query($dbhandle,convertSQL($sqlv));
						$rowv = mysqli_fetch_array($resultv);
						echo "<tr>";
						echo "<form action=\"index.php?op=1003&sop=540&tip=1&ssop=2&id=".$row2["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=541&tip=1&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
							echo "<td>".$rowv["usuario"]."</td>";
							echo "<td><select name=\"admin\" style=\"width:50px\">";
							if ($row2["admin"] == 0) {
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							}
							if ($row2["admin"] == 1) {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
						echo "</form>";
						echo "</tr>";
					}
				}
			echo "</table>";
			echo "</center>";
		}
		if (($soption == 540) and ($_GET["tip"] == 2)) {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color : Silver;\">";
					echo "<th>".$Usuario."</th>";
					echo "<th>".$Eliminar."</th>";
					echo "<th>".$Tipo."</th>";
					echo "<th>".$Admin."</th>";
				echo "</tr>";
				$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
				$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
				while ($rowx = mysqli_fetch_array($resultx)) {
					echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=540&tip=2&ssop=1&id_user=".$rowx["id"]."\" method=\"post\">";
						echo "<td style=\"width:150px;text-align:right;\">".$rowx["usuario"]."</td>";
						echo "<td></td>";
						echo "<td><select name=\"id_tipo\" style=\"width:150px\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select id,tipo from sgm_factura_tipos where visible=1 order by tipo";
							$result = mysqli_query($dbhandle,convertSQL($sql));
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
							}
						echo "</select></td>";
						echo "<td><select name=\"admin\" style=\"width:50px\">";
						echo "<option value=\"0\" selected>".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
						echo "</select></td>";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
					echo "</form>";
					echo "</tr>";
					$sql2 = "select id,id_tipo,admin from sgm_factura_tipos_permisos where id_user=".$rowx["id"];
					$result2 = mysqli_query($dbhandle,convertSQL($sql2));
					while ($row2 = mysqli_fetch_array($result2)) {
						$sqlv = "select tipo from sgm_factura_tipos where visible=1 and id=".$row2["id_tipo"];
						$resultv = mysqli_query($dbhandle,convertSQL($sqlv));
						$rowv = mysqli_fetch_array($resultv);
						echo "<tr>";
						echo "<form action=\"index.php?op=1003&sop=540&tip=2&ssop=2&id=".$row2["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=541&tip=2&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
							echo "<td>".$rowv["tipo"]."</td>";
							echo "<td><select name=\"admin\" style=\"width:50px\">";
							if ($row2["admin"] == 0) {
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							}
							if ($row2["admin"] == 1) {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
						echo "</form>";
						echo "</tr>";
					}
				}
			echo "</table>";
		}
	}

	if (($soption == 541) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=540&ssop=3&tip=".$_GET["tip"]."&id=".$_GET["id"],"op=1003&sop=540&tip=".$_GET["tip"]),array($Si,$No));
		echo "</center>";
	}
	
	if (($soption == 550) AND ($admin == true)) {
		if ($ssoption == 1) {
			if ($_POST["id_tipo_d"] != 0) {
				$camposInsert = "id_tipo_o,id_tipo_d";
				$datosInsert = array($_GET["id_tipo_o"],$_POST["id_tipo_d"]);
				insertFunction ("sgm_factura_tipos_relaciones",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$camposUpdate = array("cerrar");
			$datosUpdate = array($_POST["cerrar"]);
			updateFunction ("sgm_factura_tipos_relaciones",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_factura_tipos_relaciones",$_GET["id"]);
		}

		echo "<h4>".$Relaciones."</h4> (".$ayudaFacturaRelaciones.")";
		echo boton(array("op=1003&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Origen."</th>";
				echo "<th>".$Destino."</th>";
				echo "<th>".$Cerrar."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sqltipos = "select id,tipo from sgm_factura_tipos where visible=1 order by tipo";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)) {
			echo "<form method=\"post\" action=\"index.php?op=1003&sop=550&ssop=1&id_tipo_o=".$rowtipos["id"]."\">";
				echo "<tr>";
					echo "<td>".$rowtipos["tipo"]."</td>";
					echo "<td><select name=\"id_tipo_d\">";
						echo "<option value=\"0\">-</option>";
						$sqltipos1 = "select id,tipo from sgm_factura_tipos where visible=1 order by tipo";
						$resulttipos1 = mysqli_query($dbhandle,convertSQL($sqltipos1));
						while ($rowtipos1 = mysqli_fetch_array($resulttipos1)) {
							echo "<option value=\"".$rowtipos1["id"]."\">".$rowtipos1["tipo"]."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"cerrar\">";
						echo "<option value=\"0\">".$Si."</option>";
						echo "<option value=\"1\">".$No."</option>";
					echo "</select></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Relacionar."\"></td>";
				echo "<tr>";
				echo "</form>";
				$sqltiposrel = "select id,id_tipo_d,cerrar from sgm_factura_tipos_relaciones where id_tipo_o=".$rowtipos["id"];
				$resulttiposrel = mysqli_query($dbhandle,convertSQL($sqltiposrel));
				while ($rowtiposrel = mysqli_fetch_array($resulttiposrel)) {
					echo "<form method=\"post\" action=\"index.php?op=1003&sop=550&ssop=2&id=".$rowtiposrel["id"]."\">";
					$sqltipos2 = "select tipo from sgm_factura_tipos where id=".$rowtiposrel["id_tipo_d"];
					$resulttipos2 = mysqli_query($dbhandle,convertSQL($sqltipos2));
					$rowtipos2 = mysqli_fetch_array($resulttipos2);
					echo "<tr>";
						echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=551&id=".$rowtiposrel["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						echo "<td>".$rowtipos2["tipo"]."</td>";
						echo "<td><select name=\"cerrar\">";
						if ($rowtiposrel["cerrar"] == 0){
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						} elseif ($rowtiposrel["cerrar"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
						echo "</select></td>";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		echo "</table>";
	}

	if (($soption == 551) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=550&ssop=3&id=".$_GET["id"],"op=1003&sop=550"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 560) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "abrev,divisa,simbolo";
			$datosInsert = array($_POST["abrev"],$_POST["divisa"],$_POST["simbolo"]);
			insertFunction ("sgm_divisas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("abrev","divisa","simbolo");
			$datosUpdate = array($_POST["abrev"],$_POST["divisa"],$_POST["simbolo"]);
			updateFunction ("sgm_divisas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_divisas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "update sgm_divisas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$camposUpdate = array("predefinido");
			$datosUpdate = array("1");
			updateFunction ("sgm_divisas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate = array("predefinido");
			$datosUpdate = array("0");
			updateFunction ("sgm_divisas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Divisas."</h4>";
		echo boton(array("op=1003&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Predeterminado."</th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Abreviatura."</th>";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$Simbolo."</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<form action=\"index.php?op=1003&sop=560&ssop=1\" method=\"post\">";
				echo "<td style=\"text-align:center;width:40;\"></td>";
				echo "<td style=\"text-align:center;width:40;\"></td>";
				echo "<td><input type=\"Text\" style=\"width:60px\" name=\"abrev\"></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" name=\"divisa\"></td>";
				echo "<td><input type=\"Text\" style=\"width:20px\" name=\"simbolo\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			$sql = "select * from sgm_divisas where visible=1";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$color = "white";
				if ($row["predefinido"] == 1) { $color = "#FF4500"; }
					echo "<tr style=\"background-color : ".$color."\">";
					echo "<td class=\"submit\">";
				if ($row["predefinido"] == 1) {
					echo "<form action=\"index.php?op=1003&sop=560&ssop=5&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
					echo "</form>";
					echo "<td></td>";
				}
				if ($row["predefinido"] == 0) {
					echo "<form action=\"index.php?op=1003&sop=560&ssop=4&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predeterminar.".\">";
					echo "</form>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=561&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				}
				echo "<form action=\"index.php?op=1003&sop=560&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" style=\"width:60px\" name=\"abrev\" value=\"".$row["abrev"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" name=\"divisa\" value=\"".$row["divisa"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:20px\" name=\"simbolo\" value=\"".$row["simbolo"]."\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				echo boton_form("op=1003&sop=565&id=".$row["id"],$Cambio);
				echo boton_form("op=1003&sop=566&id=".$row["id"],$Historico);
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 561) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1003&sop=560&ssop=3&id=".$_GET["id"],"op=1003&sop=560"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 565) AND ($admin == true)) {
		if ($ssoption == 1) {
			$sql = "select id from sgm_divisas where visible=1 and id<>".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqli = "select id,canvi from sgm_divisas_canvis where id_divisa_origen=".$_GET["id"]." and id_divisa_destino=".$row["id"];
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				$rowi = mysqli_fetch_array($resulti);
				if ($rowi){
					if ($rowi["canvi"] != $_POST["canvi"]){
						$camposUpdate = array("canvi");
						$datosUpdate = array($_POST["canvi".$row["id"]]);
						updateFunction ("sgm_divisas_canvis",$rowi["id"],$camposUpdate,$datosUpdate);
						$fecha=date("Y-m-d");
						$camposInsert = "id_divisa_origen,id_divisa_destino,id_usuario,fecha,canvi";
						$datosInsert = array($_GET["id"],$row["id"],$userid,$fecha,$_POST["canvi".$row["id"]]);
						insertFunction ("sgm_divisas_mod_canvi",$camposInsert,$datosInsert);
					}
				} else {
					$camposInsert = "id_divisa_origen,id_divisa_destino,canvi";
					$datosInsert = array($_GET["id"],$row["id"],$_POST["canvi".$row["id"]]);
					insertFunction ("sgm_divisas_canvis",$camposInsert,$datosInsert);
				}
			}
		}
		echo "<h4>".$Cambios." ".$Divisas."</h4>";
		echo boton(array("op=1003&sop=560"),array("&laquo; ".$Volver));
		$sql = "select id,divisa from sgm_divisas where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$Cambio."</th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1003&sop=565&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"text-align:left;width:100px\">1 ".$row["divisa"]." = </td>";
				$sqld = "select id,divisa,abrev from sgm_divisas where visible=1 and id<>".$row["id"];
				$resultd = mysqli_query($dbhandle,convertSQL($sqld));
				while ($rowd = mysqli_fetch_array($resultd)) {
					$sqldc = "select canvi from sgm_divisas_canvis where id_divisa_origen=".$_GET["id"]." and id_divisa_destino=".$rowd["id"];
					$resultdc = mysqli_query($dbhandle,convertSQL($sqldc));
					$rowdc = mysqli_fetch_array($resultdc);
						echo "<td style=\"text-align:left;width:100px\">".$rowd["divisa"]."</td>";
						echo "<td style=\"text-align:left;width:150px\"><input type=\"Text\" style=\"width:80px\" name=\"canvi".$rowd["id"]."\" value=\"".$rowdc["canvi"]."\"> ".$rowd["abrev"]."</td>";
					echo "</tr><tr><td></td>";
				}
			echo "</tr>";
			echo "<tr>";
				echo "<td colspan=\"2\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if (($soption == 566) AND ($admin == true)) {
		echo "<h4>".$Historico." ".$Cambios."</h4>";
		echo boton(array("op=1003&sop=560"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Cambio."</th>";
				echo "<th>".$Usuario."</th>";
			echo "</tr>";
			$sql = "select * from sgm_divisas_mod_canvi where id_divisa_origen=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					$sqlu = "select usuario from sgm_users where id=".$row["id_usuario"];
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					$rowu = mysqli_fetch_array($resultu);
					$sqld = "select divisa from sgm_divisas where id=".$row["id_divisa_destino"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					echo "<td style=\"text-align:left;width:100px\">".$rowd["divisa"]."</td>";
					echo "<td style=\"text-align:left;width:100px\">".$row["fecha"]."</td>";
					echo "<td style=\"text-align:left;width:100px\">".$row["canvi"]."</td>";
					echo "<td style=\"text-align:left;width:100px\">".$rowu["usuario"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 570) AND ($admin == true)) {
		echo "<h4>".$Fuentes."</h4>";
		echo boton(array("op=1003&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Fuentes."</th>";
			echo "</tr><td>&nbsp;</td><tr>";
			echo "</tr><tr>";
				echo "<td><a href=\"".$urlmgestion."/font/free3of9.ttf\">".$Codigo." de ".$Barras."</a></td>";
			echo "</tr>";
		echo "</table>";
	}

#ayuda#
	if ($soption == 600){
		echo "<h4>".$Ayuda."</h4>";
		echo "<div style=\"margin-left:10%;margin-right:10%;margin-bottom:5%;\">";
			echo "<h4>".$Colores."</h4>";
			echo $FacturasAyudaColores;
		echo "</div>";
	}
#ayuda fin#

	
	echo "</td></tr></table><br>";
}

if (($soption == 100000) AND ($admin == true)) {
	$sql = "select * from sgm_files";
	$result = mysqli_query($dbhandle,convertSQL($sql));
	while ($row = mysqli_fetch_array($result)) {
		if ($row["id_cuerpo"] != 0){
				$camposUpdate = array("id_elemento");
				$datosUpdate = array($row["id_cuerpo"]);
				updateFunction ("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}
		if ($row["id_article"] != 0){
				$camposUpdate = array("id_elemento");
				$datosUpdate = array($row["id_article"]);
				updateFunction ("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}
		if ($row["id_client"] != 0){
				$camposUpdate = array("id_elemento");
				$datosUpdate = array($row["id_client"]);
				updateFunction ("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}
		if ($row["id_contrato"] != 0){
				$camposUpdate = array("id_elemento");
				$datosUpdate = array($row["id_contrato"]);
				updateFunction ("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}
		if ($row["id_incidencia"] != 0){
				$camposUpdate = array("id_elemento");
				$datosUpdate = array($row["id_incidencia"]);
				updateFunction ("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}
		if ($row["id_cabezera"] != 0){
				$camposUpdate = array("id_elemento");
				$datosUpdate = array($row["id_cabezera"]);
				updateFunction ("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}
	}
}



?>