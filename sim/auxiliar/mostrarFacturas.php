<?php
error_reporting(~E_ALL);

function mostrarFacturas($row){
	global $db,$dbhandle,$soption,$rowdiv,$totalPagat,$totalSenseIVA,$totalSensePagar,$totalArticles,$Linea,$Fecha,$Codigo,$Nombre,$Unidades,$PVD,$PVP,$Total,$Desplegar,$Plegar,$Cerrar,$Recibos,$Imprimir,$Editar,$Opciones;
	
	$sqltipos = "select * from sgm_factura_tipos where id=".$row["tipo"];
	$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
	$rowtipos = mysqli_fetch_array($resulttipos);
	#### OPCIONES DE VISUALIZACION SI SE MUESTRA O NO
	$hoy = date("Y-m-d");
	$data1 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-100,date("Y")));
	$ver = 0;
	if ($data1 <= $row["fecha"]) { $ver = 1; }
	if ($row["cobrada"] == 0) { $ver = 1;  }
#	No Albarán
#	if (($_GET["id"] != 2) AND ($row["cobrada"] == 0)) { $ver = 1; }
#Albarán
#	if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["aprovado"] == 0) and ($rowtipos["v_subtipos"] == 0) AND ($row["cobrada"] == 1)) { $ver = 0; }
#Pedido
#	if (($rowtipos["tipo_ot"] == 1) AND ($row["cerrada"] == 1)) { $ver = 0; }
#	if (($data1 >= $row["fecha"]) AND ($_GET["id"] == 4) AND ($row["cerrada"] == 1)) { $ver = 0; }
#Hitorico
	if (($_GET["hist"] == 1) or ($_POST["hist"] == 1)) { $ver = 1; }
#Por Articulo
	if (($soption == 200) and ($_POST["articulo"] != '')){
		$sqlcc = "select id from sgm_cuerpo where idfactura=".$row["id"]." and ((codigo like '%".$_POST["articulo"]."%') or (nombre like '%".$_POST["articulo"]."%'))";
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		if ($rowcc){ $ver = 1;  } else { $ver = 0; }
	}
#Factura
	if ($rowtipos["v_recibos"] == 1) {
		if (($row["cobrada"] == 1) and (($_GET["hist"] != 1) and ($_POST["hist"] != 1))){
			$ver = 0;
		}
	}
	if (($row["cerrada"] == 1) and (($_GET["hist"] != 1) and ($_POST["hist"] != 1))) { $ver = 0; }
	if ($ver == 1) {
########## FECHAS AVISOS CERCANIA FECHA PREVISION (colores)
		$a = date("Y", strtotime($row["fecha_prevision"]));
		$m = date("m", strtotime($row["fecha_prevision"]));
		$d = date("d", strtotime($row["fecha_prevision"]));
		$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
		$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
		$color = "#FFFFFF";
#pedido proveedor
		if ($rowtipos["v_subtipos"] == 1){
			if ($row["confirmada_cliente"] == 0) {
				$color = "#FF0000";
			} else {
				$color = "#00EC00";
			}
		}
		#pedido cliente
		if ($rowtipos["tipo_ot"] == 1) {
			$color = "#FFFFFF";
			$fecha_aviso2 = $fecha_aviso;
			$sqlc = "select fecha_prevision from sgm_cuerpo where idfactura=".$row["id"]." and id_estado<>-1 and facturado<>1 order by  fecha_prevision";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$a = date("Y", strtotime($rowc["fecha_prevision"]));
			$m = date("m", strtotime($rowc["fecha_prevision"]));
			$d = date("d", strtotime($rowc["fecha_prevision"]));
			$fecha_prevision2 = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$fecha_aviso2 = date("Y-m-d", mktime(0,0,0,$m ,$d-7, $a));
			$fecha_aviso3 = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
			if ($fecha_prevision2 <= $hoy) {
				$color = "#FF1515";
			} else {
				if ($fecha_aviso2 < $hoy) {
					$color = "yellow";
				} else {
					if ($fecha_aviso3 < $hoy) {
						$color = "#FFA500";
					} else {
						$color = "00EC00";
					}
				}
			}
			if ($row["cerrada"] == 1) { $color = "#FFFFFF"; }
		} 
		#presupuesto
		if ($rowtipos["presu"] == 1) {
			$color = "#FFFFFF";
			$prevision_final = $fecha_prevision;
			$fecha_aviso1 = $fecha_aviso;
			$fecha_aviso2 = $fecha_aviso;
			$sqlc = "select fecha_prevision from sgm_cuerpo where idfactura=".$row["id"]."";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			while ($rowc = mysqli_fetch_array($resultc)){
				$a = date("Y", strtotime($rowc["fecha_prevision"]));
				$m = date("m", strtotime($rowc["fecha_prevision"]));
				$d = date("d", strtotime($rowc["fecha_prevision"]));
				$fecha_prevision2 = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
				if ($fecha_prevision2 < $prevision_final){
					$prevision_final = $fecha_prevision2;
					$fecha_aviso1 = date("Y-m-d", mktime(0,0,0,$m ,$d-7, $a));
				}
			}
			if ($fecha_aviso1 <= $hoy) {
				$color = "#FFA500";
			} else {
				$color = "#FFFFFF";
			}
			if ($row["cerrada"] == 1) { $color = "#FFFFFF"; }
		}
		#factura
		if ($rowtipos["v_recibos"] == 1) {
			$color = "#FFFFFF";
			$a = date("Y", strtotime($row["fecha_vencimiento"]));
			$m = date("m", strtotime($row["fecha_vencimiento"]));
			$d = date("d", strtotime($row["fecha_vencimiento"]));
			$fecha_prevision3 = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$fecha_aviso3 = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
			$hoy2 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+15,date("Y")));
			if ($row["cobrada"] == 1) {
				$color = "#00EC00";
			} else {
				if ($fecha_aviso3 <= $hoy2) {
					$color = "#FFA500";
				}
				if ($fecha_prevision3 < $hoy) {
					$color = "#FF0000";
				}
				$sqld = "select count(*) as total from sgm_recibos where visible=1 and cobrada=0 and id_tipo_pago=4 AND id_factura =".$row["id"];
				$resultd = mysqli_query($dbhandle,convertSQL($sqld));
				$rowd = mysqli_fetch_array($resultd);
				if ($rowd["total"] > 0) { $color = "#0000FF"; }
				$sqlcalc = "select total from sgm_recibos where visible=1 and cobrada=1 AND id_factura=".$row["id"];
				$resultcalc = mysqli_query($dbhandle,convertSQL($sqlcalc));
				$rowcalc = mysqli_fetch_array($resultcalc);
				if ($rowcalc["total"]) { $color = "#FFFF00"; }
			}
			if ($row["cerrada"] == 1) { $color = "#FFFFFF"; }
		}
		#albaranes
		if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["aprovado"] == 0) and ($rowtipos["v_subtipos"] == 0)) {
			$color = "#FF1515";
			if ($row["cerrada"] == 1) { $color = "#00EC00"; }
			if ($row["cobrada"] == 1) { $color = "#FFFFFF"; }
		}
		echo "<tr style=\"background-color:".$color."\">";
			echo "<form method=\"post\" action=\"index.php?op=1003&sop=10&id=".$rowtipos["id"]."&id_fact=".$row["id"]."\">";
				echo "<td><input type=\"Submit\" value=\"".$Opciones."\"></td>";
			echo "</form>";
			if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
				$sqlca = "select count(*) as total from sgm_files where id_elemento in (select id from sgm_cuerpo where idfactura=".$row["id"].")";
				$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
				$rowca = mysqli_fetch_array($resultca);
				if ($rowca["total"] == 0) {$color_docs = "yellow";} else {$color_docs = "white";}
				echo "<td style=\"background-color:".$color_docs.";\">(".$rowca["total"].")</td>";
			}
			echo "<td style=\"text-align:right\">".$row["numero"]."</td>";
			if ($rowtipos["presu"] == 1) { echo "<td>/".$row["version"]."</td>"; }
############ CALCULOS SOBRE LAS FECHAS OFICIALES
				$a = date("Y", strtotime($row["fecha"]));
				$m = date("m", strtotime($row["fecha"]));
				$d = date("d", strtotime($row["fecha"]));
				$date = getdate();
				if ($date["year"]."-".$date["mon"]."-".$date["mday"] < $row["fecha"]) {
					$fecha_proxima = $row["fecha"];
				} else { 
					$fecha_proxima = $row["fecha"];
					$multiplica = 0;
					$sql00 = "select fecha from sgm_facturas_relaciones where id_plantilla=".$row["id"]." order by fecha";
					$result00 = mysqli_query($dbhandle,convertSQL($sql00));
					while ($row00 = mysqli_fetch_array($result00)) {
						if ($fecha_proxima == $row00["fecha"]) {
							$multiplica++;
							$fecha_proxima = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*$multiplica), $a));
						}
					}
				}
				if ($rowtipos["dias"] == 0) {
					echo "<td>".cambiarFormatoFechaDMY($row["fecha"])."</td>";
				} else { 
					if ($fecha_proxima > $date1) {
						$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
						if ($fecha_aviso <  $date1) {
							echo "<td style=\"background-color:orange;color:White;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</td>";
						} else {
							echo "<td>I: ".cambiarFormatoFechaDMY($row["fecha"])."<br>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</td>";
						}
					} else {
						echo "<td style=\"background-color:red;color:White;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</td>";
					}
				}
				if ($rowtipos["v_fecha_prevision"] == 1) { echo "<td>".cambiarFormatoFechaDMY($row["fecha_prevision"])."</td>"; }
				if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td>".cambiarFormatoFechaDMY($row["fecha_vencimiento"])."</td>"; }
				if ($rowtipos["v_numero_cliente"] == 1) {
					if (($rowtipos["tipo_ot"] == 1) and ($row["confirmada"] == 1)) {
						echo "<td>".$row["numero_cliente"]."</td>";
					} else {
						if ($rowtipos["presu"] == 1){
							echo "<td>".$row["numero_cliente"]."</td>";
						} else {
							echo "<td style=\"background-color:white;\">".$row["numero_cliente"]."</td>";
						}
					}
				}
					if ($rowtipos["v_rfq"] == 1) {
						if (($rowtipos["tipo_ot"] == 1) and ($row["aprovado"] == 1)) {
							echo "<td>".$row["numero_rfq"]."</td>";
						} else {
							if ($rowtipos["presu"] == 1){
								echo "<td>".$row["numero_rfq"]."</td>";
							} else {
								echo "<td style=\"background-color:white;\">".$row["numero_rfq"]."</td>";
							}
						}
					}
				if ($rowtipos["tpv"] == 0) {
					if (strlen($row["nombre"]) > 70) {
						echo "<td><a href=\"index.php?op=1008&sop=100&id=".$row["id_cliente"]."\" style=\"color:black\">".substr($row["nombre"],0,70)." ...</a></td>";
					} else {
						echo "<td><a href=\"index.php?op=1008&sop=100&id=".$row["id_cliente"]."\" style=\"color:black\">".$row["nombre"]."</a></td>";
					}
					if ($rowtipos["v_subtipos"] == 1) {
						echo "<td>";
						echo "<select style=\"width:100px\" name=\"subtipo\" disabled>";
							echo "<option value=\"0\">-</option>";
							$sqlsss = "select id,subtipo from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
							$resultsss = mysqli_query($dbhandle,convertSQL($sqlsss));
							while ($rowsss = mysqli_fetch_array($resultsss)) {
								if ($row["subtipo"] == $rowsss["id"]) {
									echo "<option value=\"".$rowsss["id"]."\" selected>".$rowsss["subtipo"]."</option>";
								} else {
									echo "<option value=\"".$rowsss["id"]."\">".$rowsss["subtipo"]."</option>";
								}
							}
						echo "</select>";
						echo "</td>";
					}
				}
				$sqldi = "select id,abrev from sgm_divisas where id=".$row["id_divisa"];
				$resultdi = mysqli_query($dbhandle,convertSQL($sqldi));
				$rowdi = mysqli_fetch_array($resultdi);
				echo "<td style=\"text-align:right;min-width:100px;\">".number_format($row["subtotal"],2,",",".")." ".$rowdi["abrev"]."</td>";
				echo "<td style=\"text-align:right;min-width:100px;\">".number_format($row["total"],2,",",".")." ".$rowdi["abrev"]."</td>";
				if ($rowtipos["v_recibos"] == 1)  {
					$sqlr = "select SUM(total) as total from sgm_recibos where visible=1 and id_factura=".$row["id"]." order by numero desc, numero_serie desc";
					$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
					$rowr = mysqli_fetch_array($resultr);
					echo "<td style=\"text-align:right;min-width:100px;\">".number_format(($row["total"]-$rowr["total"]),2,",",".")." ".$rowdi["abrev"]."</td>";
				}
				if ($rowdiv["id"] == $rowdi["id"]){
					$totalSenseIVA += $row["subtotal"];
					$totalSensePagar += $row["total"];
					$totalPagat += ($row["total"]-$rowr["total"]);
				} else {
					$totalSenseIVA += $row["subtotal"]*$row["div_canvi"];
					$totalSensePagar += $row["total"]*$row["div_canvi"];
					$totalPagat += ($row["total"]-$rowr["total"])*$row["div_canvi"];
				}
				echo "<form method=\"post\" action=\"index.php?op=1003&sop=100&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
					echo "<td><input type=\"Submit\" value=\"".$Editar."\"></td>";
				echo "</form>";
				if ($rowtipos["tpv"] == 0) {
					echo "<form method=\"post\" action=\"index.php?op=1003&sop=20&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
				} else {
					echo "<form method=\"post\" action=\"".$urlmgestion."/sim/mgestion/gestion-facturacion-tiquet-print-pdf.php?id=".$row["id"]."\" target=\"_blank\">";
				}
						echo "<td><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
					echo "</form>";
#					echo "<td style=\"background-color : ".$color.";\"><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
				if ($rowtipos["v_recibos"] == 1)  {
					echo "<form method=\"post\" action=\"index.php?op=1003&sop=30&id=".$row["id"]."\">";
						echo "<td><input type=\"Submit\" value=\"".$Recibos."\"></td>";
					echo "</form>";
				}
				echo "<form method=\"post\" action=\"index.php?op=1003&sop=40&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
					echo "<td><input type=\"Submit\" value=\"".$Cerrar."\"></td>";
				echo "</form>";
				if ($_GET["hist"]) {$link2 = "&hist=".$_GET["hist"];} else {$link2 = "";}
				if ($_GET["tipo"]) {$link2 .= "&tipo=".$_GET["tipo"];} else {$link2 .= "";}
				if ($_GET["y"]) {$link2 .= "&y=".$_GET["y"];} else {$link2 .= "";}
				if ($_GET["m"]) {$link2 .= "&m=".$_GET["m"];} else {$link2 .= "";}
				if ($_GET["d"]) {$link2 .= "&d=".$_GET["d"];} else {$link2 .= "";}
				if ($_GET["id_tipo"]) {$link2 .= "&id_tipo=".$_GET["id_tipo"];} else {$link2 .= "";}
				if (($_POST["todo"] > 0) and ($row["id"] == $_POST["id"])) {
					echo "<form method=\"post\" action=\"index.php?op=1003&sop=".$_GET["sop"]."&filtra=0&id=".$_GET["id"].$link2."\">";
						echo "<input type=\"Hidden\" name=\"id_tipo\" value=\"".$_POST["id_tipo"]."\">";
						echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
						echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
						echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
						echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
						echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
						echo "<input type=\"Hidden\" name=\"hist\" value=\"".$_POST["hist"]."\">";
						echo "<td><input type=\"Submit\" value=\"".$Plegar."\"></td>";
					echo "</form>";
				} else {
					echo "<form method=\"post\" action=\"index.php?op=1003&sop=".$_GET["sop"]."&filtra=1&id=".$_GET["id"].$link2."\">";
						echo "<input type=\"Hidden\" name=\"id_tipo\" value=\"".$_POST["id_tipo"]."\">";
						echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
						echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
						echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
						echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
						echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
						echo "<input type=\"Hidden\" name=\"hist\" value=\"".$_POST["hist"]."\">";
						echo "<input type=\"Hidden\" name=\"todo\" value=\"2\">";
						echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
						echo "<td><input type=\"Submit\" value=\"".$Desplegar."\"></td>";
					echo "</form>";
				}
#		echo "</tr></table>";
		echo "</tr>";
		if ($_GET["filtra"] == 1){
			if ($_POST["todo"] == 1) { $id_fac = $row["id"]; }
			if (($_POST["todo"] == 2) and ($row["id"] == $_POST["id"])) { $id_fac = $_POST["id"]; }
			$sqlxx = "select count(*) as total from sgm_cuerpo where idfactura=".$id_fac."";
			if (($_GET["hist"] == 0) or ($_POST["hist"] == 0)) { $sqlxx = $sqlxx." and id_estado<>-1 and facturado<>1";}
			if ($_POST["data_desde1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde1"])."'"; }
			if ($_POST["data_fins1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins1"])."'"; }
			if ($_POST["data_desde2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde2"])."'"; }
			if ($_POST["data_fins2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins2"])."'"; }
			if ($_POST["articulo"] != '') { $sqlxx = $sqlxx." AND nombre like '%".$_POST["articulo"]."%'"; }
			$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
			$rowxx = mysqli_fetch_array($resultxx);
			if ($rowxx["total"] > 0){
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td colspan=\"12\"><table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
					echo "<tr style=\"background-color:silver;\">";
						echo "<th>".$Linea."</th>";
						echo "<th>".$Fecha." Prev.</th>";
						echo "<th>".$Codigo."</th>";
						echo "<th>".$Nombre."</th>";
						echo "<th>".$Unidades."</th>";
						echo "<th>".$PVD."</th>";
						echo "<th>".$PVP."</th>";
						echo "<th>Desc.%</th>";
						echo "<th>Desc.</th>";
						echo "<th>".$Total."</th>";
					echo "</tr>";
					$sqlxx = "select * from sgm_cuerpo where idfactura=".$id_fac."";
					if (($_GET["hist"] == 0) or ($_POST["hist"] == 0)) { $sqlxx = $sqlxx." and id_estado<>-1 and facturado<>1";}
					if ($_POST["data_desde1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde1"])."'"; }
					if ($_POST["data_fins1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins1"])."'"; }
					if ($_POST["data_desde2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde2"])."'"; }
					if ($_POST["data_fins2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins2"])."'"; }
					if ($_POST["articulo"] != '') { $sqlxx = $sqlxx." AND nombre like '%".$_POST["articulo"]."%'"; }
					$sqlxx = $sqlxx." order by linea";
					$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
					while ($rowxx = mysqli_fetch_array($resultxx)) {
						$color = "white";
						if ($row["tipo"] == 5) {
							if ($rowxx["facturado"] == 1) {
								$color = "blue";
							} else {
								$hoy = date("Y-m-d");
								$a = date("Y", strtotime($rowxx["fecha_prevision"]));
								$m = date("m", strtotime($rowxx["fecha_prevision"]));
								$d = date("d", strtotime($rowxx["fecha_prevision"]));
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
							echo "<td style=\"width:20px\">".$rowxx["linea"]."</td>";
							echo "<td style=\"width:90px\">".$rowxx["fecha_prevision"]."</td>";
							echo "<td style=\"width:100px\">".$rowxx["codigo"]."</td>";
							echo "<td style=\"width:500px\" nowrap>".$rowxx["nombre"]."</td>";
							echo "<td style=\"width:50px\">".$rowxx["unidades"]."</td>";
							if ($row["pvd"] == 0){
								$sqla = "select preu_cost from sgm_articles_costos where visible=1 and id_cuerpo=".$rowxx["id"]." and aprovat=1";
								$resulta = mysqli_query($dbhandle,convertSQL($sqla));
								$rowa = mysqli_fetch_array($resulta);
								echo "<td style=\"width:60px\">".$rowa["preu_cost"]."</td>";
							} else {
								echo "<td style=\"width:60px\">".$row["pvd"]."</td>";
							}
							echo "<td style=\"width:60px\">".$rowxx["pvp"]."</td>";
							echo "<td style=\"width:40px\">".$rowxx["descuento"]."</td>";
							echo "<td style=\"width:40px\">".$rowxx["descuento_absoluto"]."</td>";
							echo "<td style=\"width:80px\"><strong>".$rowxx["total"]."</strong> ".$row2["abrev"]."</td>";
						echo "</tr>";
						$totalArticles += $rowxx["total"];
					}
					echo "<tr><td>&nbsp;</td></tr>";
				echo "</table></td></tr>";
			}
			$id_fac = '';
		}
	}
}

?>