<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
#if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";  }
#if (($option == 1027) AND ($autorizado == true)) {
if (($option == 1027)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Facturacion."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1027&sop=0\" class=".$class.">".$Facturacion."</a></td>";
					if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1027&sop=100\" class=".$class.">".$Resumenes."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1027&sop=200\" class=".$class.">".$Buscar." ".$Facturas."</a></td>";
					if ($soption == 210) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1027&sop=210\" class=".$class.">".$Impresion."</a></td>";
					if ($soption == 290) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1027&sop=290\" class=".$class.">".$Informes."</a></td>";
					if (($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1027&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 200)) {
		if ($soption == 0){
			echo "<table cellpadding=\"1\" cellspacing=\"2\" class=\"lista\">";
				echo "<tr>";
				$sqltipos2 = "select * from sgm_factura_tipos where visible=1 order by orden,descripcion";
				$resulttipos2 = mysql_query(convert_sql($sqltipos2));
				while ($rowtipos2 = mysql_fetch_array($resulttipos2)) {
					$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
					$resultpermiso = mysql_query(convert_sql($sqlpermiso));
					$rowpermiso = mysql_fetch_array($resultpermiso);
					if ($rowpermiso["total"] > 0) { 
						$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
						$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
						$rowpermiso2 = mysql_fetch_array($resultpermiso2);
						if ($rowtipos2["id"] == $_GET["id"]) {$class2 = "menu_select";} else {$class2 = "menu";}
						if ($rowpermiso2["admin"] == 0) { echo "<td class=".$class2."><a href=\"index.php?op=1027&sop=0&id=".$rowtipos2["id"]."\" class=".$class2.">".$rowtipos2["tipo"]."</a></td>";}
						if ($rowpermiso2["admin"] == 1) { echo "<td class=".$class2."><a href=\"index.php?op=1027&sop=0&id=".$rowtipos2["id"]."\" class=".$class2."><strong>".$rowtipos2["tipo"]."<strong></a></td>";}
					} else { echo "<td style=\"background-color:black;color:white;border:1px solid black;text-align:center;vertical-align:middle;height:20px;width:150px;\"><a href=\"index.php?op=1027&sop=0\" class=\"menu\">".$rowtipos2["tipo"]."</a></td>"; }
				}
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
		}
		
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id"];
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		if ($soption == 200) {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr>";
					echo "<th>".$Cliente."</th>";
					echo "<th>Ref. Ped. ".$Cliente."</th>";
					echo "<th>".$Desde."</th>";
					echo "<th>".$Hasta."</th>";
					echo "<th>".$Articulo."</th>";
				echo "</tr><tr>";
					echo "<form action=\"index.php?op=1027&sop=200&filtra=1&hist=0&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos2["id"]."\">";
					echo "<td>";
						echo "<select style=\"width:300px\" name=\"id_cliente\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 ";
						$sql = $sql."order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_cliente"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\"></td>";
					$fecha = getdate();
					if ($_POST["data_desde1"]){
						$data = $_POST["data_desde1"];
						$data1 = $_POST["data_fins1"];
					} else {
						$data = cambiarFormatoFechaDMY(date("Y-m-d", mktime(0,0,0,$fecha["mon"] ,$fecha["mday"], $fecha["year"])));
						$data1 = $data;
					}
					if ($_POST["data_desde2"]){
						$data2 = $_POST["data_desde2"];
						$data3 = $_POST["data_fins2"];
					} else {
						$data2 = cambiarFormatoFechaDMY(date("Y-m-d", mktime(0,0,0,$fecha["mon"] ,$fecha["mday"], $fecha["year"])));
						$data3 = $data2;
					}
					echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_desde1\" value=\"".$data."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_fins1\" value=\"".$data1."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"articulo\" value=\"".$_POST["articulo"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
				echo "<tr>";
					echo "<form action=\"index.php?op=1027&sop=200&ssop=10&filtra=1&hist=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
					echo "<td>";
						echo "<select style=\"width:300px\" name=\"id_cliente2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 ";
						$sql = $sql."order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_cliente2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_desde2\" value=\"".$data2."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_fins2\" value=\"".$data3."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:100px;\" name=\"articulo\" value=\"".$_POST["articulo"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Buscar." Hist.\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			echo "<br>";
		}
		if ($_GET["id"] != ""){
			if ($ssoption == 1) {
				$sqlcc = "select count(*) as total from sgm_cabezera where visible=1 and numero=".$_POST["numero"]." and tipo=".$_POST["tipo"];
				$resultcc = mysql_query(convert_sql($sqlcc));
				$rowcc = mysql_fetch_array($resultcc);
				if ($rowcc["total"] == 0){
					$fecha = cambiarFormatoFechaYMD($_POST["fecha"]);
					$fecha_prev = cambiarFormatoFechaYMD($_POST["fecha_prevision"]);
					$datosInsert = array('numero'=>$_POST["numero"],'tipo'=>$_POST["tipo"],'subtipo'=>$_POST["subtipo"],'version'=>$_POST["version"],'numero_rfq'=>$_POST["numero_rfq"],'numero_cliente'=>$_POST["numero_cliente"],'fecha'=>$fecha,'fecha_prevision'=>$fecha_prev,'id_cliente'=>$_POST["id_cliente"]);
					insertCabezera($datosInsert);
				}
			}
			if ($ssoption == 20) {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
			}
			if ($ssoption == 4) {
				echo trafactura($_GET["id_fact"],$_POST["id_tipus"],$_POST["data"]);
			}
			if ($ssoption == 8) {
				$sql = "update sgm_cabezera set ";
				$sql = $sql."cerrada=1";
				$sql = $sql." WHERE id=".$_GET["id_fact"]."";
				mysql_query(convert_sql($sql));
			}
			if ($_GET["hist"] == 2){
				echo boton(array("op=1027&sop=0&id=".$rowtipos["id"]),array($Actual));
			} else {
				echo boton(array("op=1027&sop=0&id=".$rowtipos["id"]."&hist=2"),array($Historico));
			}
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					$tds = 4;
					echo "<th></th>";
					echo "<th>Docs</th>";
					echo "<th>".$Numero."</th>";
					if ($rowtipos["presu"] == 1) { echo "<th>Ver.</th>"; $tds++;}
					echo "<th>".$Fecha."</th>";
					if ($rowtipos["v_fecha_prevision"] == 1) { echo "<th>".$Prevision."</th>"; $tds++;}
					if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<th>".$Vencimiento."</th>"; $tds++;}
					if ($rowtipos["v_numero_cliente"] == 1) { echo "<th><center>Ref. Ped. ".$Cliente."</center></th>"; $tds++;}
#					if ($rowtipos["v_rfq"] == 1) { echo "<th><center>".$Numero." RFQ</center></th>"; $tds++;}
					if ($rowtipos["tpv"] == 0) { echo "<th>".$Cliente."</th>"; $tds++;}
					if ($rowtipos["v_subtipos"] == 1) { echo "<th>".$Subtipo."</th>"; $tds++;}
					echo "<th>".$Subtotal."</th>";
					echo "<th>".$Total."</th>";
					if ($rowtipos["v_recibos"] == 1)  {echo "<th>".$Pendiente."</th>";}
			if ($_GET["filtra"]  == 1){
					echo "<form action=\"index.php?op=1027&sop=0&ssop=".$_GET["ssop"]."&filtra=1&id=".$_GET["id"]."&hist=".$_GET["hist"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
					echo "<input type=\"Hidden\" name=\"id_cliente2\" value=\"".$_POST["id_cliente2"]."\">";
					echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
					echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
					echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
					echo "<input type=\"Hidden\" name=\"data_desde2\" value=\"".$_POST["data_desde2"]."\">";
					echo "<input type=\"Hidden\" name=\"data_fins2\" value=\"".$_POST["data_fins2"]."\">";
					echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
					echo "<input type=\"Hidden\" name=\"todo\" value=\"1\">";
					echo "<td></td><td></td><td><input type=\"Submit\" value=\"".$Desplegar." ".$Todo."\" style=\"width:100px\"></td>";
					echo "</form>";
			}
				echo "</tr>";
				echo "<tr>";
					echo "<form action=\"index.php?op=1027&sop=0&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
					$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." order by numero desc";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					$numero = $row["numero"] + 1;
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><input type=\"Text\" name=\"numero\" value=\"".$numero."\" style=\"width:100px;text-align:right;\"></td>";
					if ($rowtipos["presu"] == 1) { 
						echo "<td style=\"width:30px;text-align:center\"><input type=\"Text\" name=\"version\" value=\"0\" style=\"width:25px\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"version\" value=\"0\">";
					}
					$date = getdate();
					$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
					echo "<td><input type=\"Text\" name=\"fecha\" style=\"width:80px\" value=\"".cambiarFormatoFechaDMY($date1)."\"></td>";
				### CALCULO DE LA FECHA DE PREVISION DE ENTREGA
					$suma = $rowtipos["v_fecha_prevision_dias"];
					$a = date("Y", strtotime($date1)); 
					$m = date("n", strtotime($date1)); 
					$d = date("j", strtotime($date1)); 
					$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d+$suma, $a));
					if ($rowtipos["v_fecha_prevision"] == 1) { 
						echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:80px\" value=\"".cambiarFormatoFechaDMY($fecha_prevision)."\"></td>";
					} else {
						echo "<input type=\"hidden\" name=\"fecha_prevision\" style=\"width:80px\" value=\"0\">";
					}
					if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td></td>"; }
					if ($rowtipos["v_numero_cliente"] == 1) { 
						echo "<td><input type=\"Text\" name=\"numero_cliente\" style=\"width:100px\"></td>";
					} else { "<input type=\"hidden\" name=\"numero_cliente\">"; }
#					if ($rowtipos["v_rfq"] == 1) { 
#						echo "<td><input type=\"Text\" name=\"numero_rfq\" style=\"width:125px\"></td>";
#					} else { "<input type=\"hidden\" name=\"numero_rfq\">"; }
					if ($rowtipos["tpv"] == 0) { 
						echo "<td>";
							echo "<select style=\"width:400px\" name=\"id_cliente\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select * from sgm_clients where visible=1 ";
							$sql = $sql."order by nombre";
							$result = mysql_query(convert_sql($sql));
							while ($row = mysql_fetch_array($result)) {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
							echo "</select>";
						echo "</td>";
					}
					if ($rowtipos["tpv"] == 1) { 
						echo "<input type=\"hidden\" name=\"id_cliente\" value=\"0\">";
					}
					if ($rowtipos["v_subtipos"] == 1) {
						echo "<td>";
							echo "<select style=\"width:100px\" name=\"subtipo\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select * from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
							$result = mysql_query(convert_sql($sql));
							while ($row = mysql_fetch_array($result)) {
								echo "<option value=\"".$row["id"]."\">".$row["subtipo"]."</option>";
							}
							echo "</select>";
						echo "</td>";
					} else {
						echo "<input type=\"hidden\" name=\"subtipo\" value=\"0\">";
					}
					echo "<td><input type=\"Submit\" value=\"".$Nueva."\" style=\"width:100px\"></td>";
					echo "<td style=\"width:100px\"></td>";
					echo "<td style=\"width:100px\"></td>";
					echo "</form>";
				echo "</tr>";
				$totalSensePagar = 0;
				$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"];
				if (($soption == 200) AND ($_POST["id_cliente"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente"]; }
				if (($soption == 200) AND ($_POST["id_cliente2"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente2"]; }
				if (($soption == 200) AND ($_POST["ref_cli"] != '')) { $sql = $sql." AND numero_cliente like '%".$_POST["ref_cli"]."%'"; }
				if (($soption == 200) AND ($_GET["fecha"] != 0)) { $sql = $sql." AND fecha='".date("Y-m-d", $_GET["fecha"])."'"; }
				if (($soption == 200) AND ($_POST["data_desde1"] != 0)) { $sql = $sql." AND fecha>='".cambiarFormatoFechaDMY($_POST["data_desde1"])."'"; }
				if (($soption == 200) AND ($_POST["data_fins1"] != 0)) { $sql = $sql." AND fecha<='".cambiarFormatoFechaDMY($_POST["data_fins1"])."'"; }
				if (($soption == 200) AND ($_POST["data_desde2"] != 0)) { $sql = $sql." AND fecha>='".cambiarFormatoFechaDMY($_POST["data_desde2"])."'"; }
				if (($soption == 200) AND ($_POST["data_fins2"] != 0)) { $sql = $sql." AND fecha<='".cambiarFormatoFechaDMY($_POST["data_fins2"])."'"; }
				$sql = $sql." order by numero desc,version desc,fecha desc";
#echo $sql;
				$result = mysql_query(convert_sql($sql));
				$fechahoy = getdate();
				$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-100, $fechahoy["year"]));
				$hoy = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
				while ($row = mysql_fetch_array($result)) {
					#### OPCIONES DE VISUALIZACION SI SE MUESTRA O NO
					$ver = 0;
					if ($data1 <= $row["fecha"]) { $ver = 1; }
					if ($row["cobrada"] == 0) { $ver = 1; }
	#				#No Albarán
	#				if (($_GET["id"] != 2) AND ($row["cobrada"] == 0)) { $ver = 1; }
					#Albarán
	#				if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["aprovado"] == 0) and ($rowtipos["v_subtipos"] == 0) AND ($row["cobrada"] == 1)) { $ver = 0; }
	#				#pedido cliente
	#				if (($rowtipos["tipo_ot"] == 1) AND ($row["cerrada"] == 1)) { $ver = 0; }
	#				if (($data1 >= $row["fecha"]) AND ($_GET["id"] == 4) AND ($row["cerrada"] == 1)) { $ver = 0; }
					if ($_GET["hist"] == 2) { $ver = 1; }
					if ($_GET["filtra"]  == 1){
						$sqlcc = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
						if ($_POST["articulo"] != '') { $sqlcc = $sqlcc." AND ((codigo like '%".$_POST["articulo"]."%') or (nombre like '%".$_POST["articulo"]."%'))"; }
						$resultcc = mysql_query(convert_sql($sqlcc));
						$rowcc = mysql_fetch_array($resultcc);
						if ($rowcc){ $ver = 1; } else { $ver = 0; }
					}
					#factura
					if ($rowtipos["v_recibos"] == 1) {
						$hoyd = date("Y-m-d");
						if (($row["cobrada"] == 1) and ($_GET["hist"] != 2)){
							$ver = 0;
						}
					}
					if (($row["cerrada"] == 1) and ($_GET["hist"] != 2)) { $ver = 0; }
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
							$sqlc = "select * from sgm_cuerpo where idfactura=".$row["id"]." and id_estado<>-1 and facturado<>1 order by  fecha_prevision";
							$resultc = mysql_query(convert_sql($sqlc));
							$rowc = mysql_fetch_array($resultc);
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
							$sqlc = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
							$resultc = mysql_query(convert_sql($sqlc));
							while ($rowc = mysql_fetch_array($resultc)){
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
							$hoy2 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]+15, $fechahoy["year"]));
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
								$resultd = mysql_query(convert_sql($sqld));
								$rowd = mysql_fetch_array($resultd);
								if ($rowd["total"] > 0) { $color = "#0000FF"; }
								$sqlcalc = "select * from sgm_recibos where visible=1 and cobrada=1 AND id_factura =".$row["id"];
								$resultcalc = mysql_query(convert_sql($sqlcalc));
								$rowcalc = mysql_fetch_array($resultcalc);
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
							echo "<form method=\"post\" action=\"index.php?op=1027&sop=10&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
								echo "<td><input type=\"Submit\" value=\"".$Opciones."\" style=\"width:100px\"></td>";
							echo "</form>";
							$sqlca = "select count(*) as total from sgm_files where id_cuerpo in (select id from sgm_cuerpo where idfactura=".$row["id"].")";
							$resultca = mysql_query(convert_sql($sqlca));
							$rowca = mysql_fetch_array($resultca);
							if ($rowca["total"] == 0) {$color_docs = "yellow";} else {$color_docs = $color;}
							echo "<td style=\"background-color:".$color_docs.";\">(".$rowca["total"].")</td>";
							echo "<td style=\"text-align:right;width:100px\">".$row["numero"]."</td>";
							if ($rowtipos["presu"] == 1) { echo "<td style=\"width:25px\">/".$row["version"]."</td>"; }
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
									$sql00 = "select * from sgm_facturas_relaciones where id_plantilla=".$row["id"]." order by fecha";
									$result00 = mysql_query(convert_sql($sql00));
									while ($row00 = mysql_fetch_array($result00)) {
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
#									if ($rowtipos["v_rfq"] == 1) {
#										if (($rowtipos["tipo_ot"] == 1) and ($row["aprovado"] == 1)) {
#											echo "<td>".$row["numero_rfq"]."</td>";
#										} else {
#											if ($rowtipos["presu"] == 1){
#												echo "<td>".$row["numero_rfq"]."</td>";
#											} else {
#												echo "<td style=\"background-color:white;\">".$row["numero_rfq"]."</td>";
#											}
#										}
#									}
								if ($rowtipos["tpv"] == 0) {
									if (strlen($row["nombre"]) > 70) {
										echo "<td><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1027\" style=\"color:black\">".substr($row["nombre"],0,70)." ...</a></td>";
									} else {
										echo "<td><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1027\" style=\"color:black\">".$row["nombre"]."</a></td>";
									}
									if ($rowtipos["v_subtipos"] == 1) {
										echo "<td>";
										echo "<select style=\"width:100px\" name=\"subtipo\" disabled>";
											echo "<option value=\"0\">-</option>";
											$sqlsss = "select * from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
											$resultsss = mysql_query(convert_sql($sqlsss));
											while ($rowsss = mysql_fetch_array($resultsss)) {
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
								$sqldiv = "select * from sgm_divisas where predefinido=1";
								$resultdiv = mysql_query(convert_sql($sqldiv));
								$rowdiv = mysql_fetch_array($resultdiv);
								$sqldi = "select * from sgm_divisas where id=".$row["id_divisa"];
								$resultdi = mysql_query(convert_sql($sqldi));
								$rowdi = mysql_fetch_array($resultdi);
								echo "<td style=\"text-align:right;\">".number_format($row["subtotal"],2,",",".").$rowdi["simbolo"]."</td>";
								echo "<td style=\"text-align:right;\">".number_format($row["total"],2,",",".").$rowdi["simbolo"]."</td>";
								if ($rowtipos["v_recibos"] == 1)  {
									$sqlr = "select SUM(total) as total from sgm_recibos where visible=1 and id_factura=".$row["id"]." order by numero desc, numero_serie desc";
									$resultr = mysql_query(convert_sql($sqlr));
									$rowr = mysql_fetch_array($resultr);
									echo "<td style=\"text-align:right;\">".number_format(($row["total"]-$rowr["total"]),2,",",".").$rowdi["simbolo"]."</td>";
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
								echo "<form method=\"post\" action=\"index.php?op=1027&sop=22&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
									echo "<td><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
								echo "</form>";
								if ($rowtipos["tpv"] == 0) {
									echo "<form method=\"post\" action=\"index.php?op=1027&sop=12&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
								} else {
									echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-tiquet-print.php?id=".$row["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
								}
										echo "<td><input type=\"Submit\" value=\"".$Imprimir."\" style=\"width:100px\"></td>";
									echo "</form>";
#								echo "<td style=\"background-color : ".$color.";\"><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
								if ($rowtipos["v_recibos"] == 1)  {
									echo "<form method=\"post\" action=\"index.php?op=1027&sop=200&id=".$row["id"]."\">";
										echo "<td><input type=\"Submit\" value=\"".$Recibos."\" style=\"width:100px\"></td>";
									echo "</form>";
								}
								echo "<form method=\"post\" action=\"index.php?op=1027&sop=11&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
									echo "<td><input type=\"Submit\" value=\"".$Cerrar."\" style=\"width:100px\"></td>";
								echo "</form>";
								if (($_POST["todo"] > 0) and ($row["id"] == $_POST["id"])) {
									echo "<form method=\"post\" action=\"index.php?op=1027&sop=200&filtra=1&id=".$_GET["id"]."\">";
										echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
										echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
										echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
										echo "<input type=\"Hidden\" name=\"data_desde2\" value=\"".$_POST["data_desde2"]."\">";
										echo "<input type=\"Hidden\" name=\"data_fins2\" value=\"".$_POST["data_fins2"]."\">";
										echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
										echo "<td><input type=\"Submit\" value=\"".$Plegar."\" style=\"width:100px\"></td>";
									echo "</form>";
								} else {
									echo "<form method=\"post\" action=\"index.php?op=1027&sop=200&filtra=1&id=".$_GET["id"]."\">";
										echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
										echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
										echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
										echo "<input type=\"Hidden\" name=\"data_desde2\" value=\"".$_POST["data_desde2"]."\">";
										echo "<input type=\"Hidden\" name=\"data_fins2\" value=\"".$_POST["data_fins2"]."\">";
										echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
										echo "<input type=\"Hidden\" name=\"todo\" value=\"2\">";
										echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
										echo "<td><input type=\"Submit\" value=\"".$Desplegar."\" style=\"width:100px\"></td>";
									echo "</form>";
								}
	#						echo "</tr></table>";
						echo "</tr>";
					if ($_GET["filtra"] == 1){
						if ($_POST["todo"] == 1) { $id_fac = $row["id"]; }
						if (($_POST["todo"] == 2) and ($row["id"] == $_POST["id"])) { $id_fac = $_POST["id"]; }
						$sqlxx = "select count(*) as total from sgm_cuerpo where idfactura=".$id_fac."";
						if ($_GET["hist"] == 0) { $sqlxx = $sqlxx." and id_estado<>-1 and facturado<>1";}
						if ($_POST["data_desde1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde1"])."'"; }
						if ($_POST["data_fins1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins1"])."'"; }
						if ($_POST["data_desde2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde2"])."'"; }
						if ($_POST["data_fins2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins2"])."'"; }
						if ($_POST["articulo"] != '') { $sqlxx = $sqlxx." AND nombre like '%".$_POST["articulo"]."%'"; }
						$resultxx = mysql_query(convert_sql($sqlxx));
						$rowxx = mysql_fetch_array($resultxx);
						if ($rowxx["total"] > 0){
							echo "<tr><td>&nbsp;</td></tr>";
							echo "<tr><td colspan=\"12\"><table cellspacing=\"0\">";
								echo "<tr style=\"background-color:silver;\">";
									echo "<td>".$Linea."</td>";
									echo "<td>".$Fecha." Prev.</td>";
									echo "<td>".$Codigo."</td>";
									echo "<td>".$Nombre."</td>";
									echo "<td>".$Unidades."</td>";
									echo "<td>".$PVD."</td>";
									echo "<td>".$PVP."</td>";
									echo "<td>Desc.%</td>";
									echo "<td>Desc.</td>";
									echo "<td>".$Total."</td>";
								echo "</tr>";
								$sqlxx = "select * from sgm_cuerpo where idfactura=".$id_fac."";
								if ($_GET["hist"] == 0) { $sqlxx = $sqlxx." and id_estado<>-1 and facturado<>1";}
								if ($_POST["data_desde1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde1"])."'"; }
								if ($_POST["data_fins1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins1"])."'"; }
								if ($_POST["data_desde2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde2"])."'"; }
								if ($_POST["data_fins2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins2"])."'"; }
								if ($_POST["articulo"] != '') { $sqlxx = $sqlxx." AND nombre like '%".$_POST["articulo"]."%'"; }
								$sqlxx = $sqlxx." order by linea";
								$resultxx = mysql_query(convert_sql($sqlxx));
								while ($rowxx = mysql_fetch_array($resultxx)) {
									$color = "white";
									if ($row["tipo"] == 5) {
										if ($rowxx["facturado"] == 1) {
											$color = "blue";
										} else {
											$date = getdate();
											$hoy = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
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
										echo "<td><input type=\"Text\" style=\"width:20px\" name=\"linea\" value=\"".$rowxx["linea"]."\"></td>";
										echo "<td><input type=\"Text\" style=\"width:90px\" name=\"fecha_prevision\" value=\"".$rowxx["fecha_prevision"]."\"></td>";
										echo "<td><input type=\"Text\" style=\"width:100px\" name=\"codigo\" value=\"".$rowxx["codigo"]."\"></td>";
										echo "<td><input type=\"Text\" style=\"width:400px\" name=\"nombre\" value=\"".$rowxx["nombre"]."\"></td>";
										echo "<td><input type=\"Text\" style=\"width:50px\" name=\"unidades\" style=\"text-align:right;\" value=\"".$rowxx["unidades"]."\"></td>";
										if ($row["pvd"] == 0){
											$sqla = "select * from sgm_articles_costos where visible=1 and id_cuerpo=".$rowxx["id"]." and aprovat=1";
											$resulta = mysql_query(convert_sql($sqla));
											$rowa = mysql_fetch_array($resulta);
											echo "<td><input type=\"Text\" style=\"width:60px\" name=\"pvd\" style=\"text-align:right;background-color:white;color:silver\" value=\"".$rowa["preu_cost"]."\"></td>";
										} else {
											echo "<td><input type=\"Text\" style=\"width:60px\" name=\"pvd\" style=\"text-align:right;background-color:white;color:silver\" value=\"".$row["pvd"]."\"></td>";
										}
										echo "<td><input type=\"Text\" style=\"width:60px\" name=\"pvp\" style=\"text-align:right;\" value=\"".$rowxx["pvp"]."\"></td>";
										echo "<td><input type=\"Text\" style=\"width:40px\" name=\"descuento\" style=\"text-align:right;\" value=\"".$rowxx["descuento"]."\"></td>";
										echo "<td><input type=\"Text\" style=\"width:40px\" name=\"descuento_absoluto\" style=\"text-align:right;\" value=\"".$rowxx["descuento_absoluto"]."\"></td>";
										echo "<td style=\"text-align:right;background-color : silver;width:80px\"><strong>".$rowxx["total"]."</strong> ".$row2["abrev"]."</td>";
									echo "</tr>";
								}
								echo "<tr><td>&nbsp;</td></tr>";
							echo "</table></td></tr>";
						}
						$id_fac = '';
					}
				}
			}
				echo "<tr><td> </td></tr>";
				echo "<tr>";
					echo "<td colspan=\"".$tds."\" style=\"text-align:right;\"><strong>".$Total."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".number_format($totalSenseIVA,2,",",".").$rowdiv["simbolo"]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".number_format($totalSensePagar,2,",",".").$rowdiv["simbolo"]."</strong></td>";
					if ($rowtipos["v_recibos"] == 1)  {echo "<td style=\"text-align:right;\"><strong>".number_format($totalPagat,2,",",".").$rowdiv["simbolo"]."</strong></td>";}
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
			echo "</table>";
		}
	}

	if ($soption == 10) {
		if ($ssoption == 1) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."confirmada=".$_POST["confirmada"];
			$sql = $sql.",confirmada_cliente=".$_POST["confirmada_cliente"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		$sql = "select * from sgm_cabezera where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$sqlf = "select * from sgm_factura_tipos where id=".$_GET["id_tipo"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);

		echo "<h4>".$Opciones."</h4>";
		echo boton(array("op=1027&sop=0&id=".$_GET["id_tipo"]),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\">";
						echo "<tr>";
							echo "<td style=\"width:400px\"><strong>".$Eliminar." ".$rowf["tipo"]."</strong></td>";
						echo "</tr><tr>";
							echo "<td style=\"width:400px\">".$ayudaFacturaEliminar."</td>";
						echo "</tr>";
					echo "</table><table>";
						echo "<tr>";
							echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:red;border: 1px solid black;\">";
								echo "<a href=\"index.php?op=1027&sop=11&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" style=\"color:white;\">".$Eliminar."</a>";
							echo "</td>";
						echo "</tr><tr>";
							echo "<td>&nbsp;</td>";
						echo "</tr>";
					echo "</table></center>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;Width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\">";
						echo "<tr>";
							echo "<td style=\"width:400px\"><strong>".$Traspaso."</strong></td>";
						echo "</tr><tr>";
							echo "<td style=\"width:400px\"></td>";
						echo "</tr>";
					echo "</table><table>";
						echo "<tr>";
							echo "<td class=\"menu\">";
								echo "<a href=\"index.php?op=1027&sop=10&ssop=1&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" style=\"color:white;\">".$Completo."</a>";
							echo "</td>";
							echo "<td class=\"menu\">";
								echo "<a href=\"index.php?op=1027&sop=12&fu=1&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" style=\"color:white;\">".$Parcial."</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo "<br>";
					if ($ssoption == 1){
						echo "<table style=\"width:400px;background-color:grey;\">";
							echo "<tr>";
								echo "<form action=\"index.php?op=1027&sop=0&ssop=4&id=".$_GET["id_tipo"]."&id_fact=".$_GET["id"]."\" method=\"post\">";
								$date = getdate();
								$date = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
								echo "<td><input type=\"text\" name=\"data\" value=\"".$date."\" style=\"width:100px\"></td>";
								echo "<td><select name=\"id_tipus\" style=\"width:200px\">";
									echo "<option value=\"".$rowf["id"]."\">".$rowf["tipo"]."</option>";
									$sqlr = "select * from sgm_factura_tipos_relaciones where id_tipo_o=".$_GET["id_tipo"];
									$resultr = mysql_query(convert_sql($sqlr));
									while ($rowr = mysql_fetch_array($resultr)) {
										$sqld = "select * from sgm_factura_tipos where id=".$rowr["id_tipo_d"];
										$resultd = mysql_query(convert_sql($sqld));
										$rowd = mysql_fetch_array($resultd);
										echo "<option value=\"".$rowd["id"]."\">".$rowd["tipo"]."</option>";
									}
								echo "</select></td>";
								echo "<td><input type=\"Submit\" value=\"".$Enviar."\" style=\"width:100px\"></td>";
								echo "</form>";
							echo "</tr>";
						echo "</table>";
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 11) {
		echo "<br><br>¿Seguro que desea eliminar esta factura?";
		echo "<br><br><a href=\"index.php?op=1027&sop=10&ssop=20&id_fact=".$_GET["id"]."&id=".$_GET["id_tipo"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1027&sop=600&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\">[ NO ]</a>";
	}

	if ($soption == 12) {
		echo "<strong>".$Traspaso." ".$Parcial."</strong>";
		echo "<br><br>";
		echo boton_volver($Volver);
		echo "<br>";
	}


	if ($soption == 500) {
#		if ($admin == true) {
			echo boton(array("op=1027&sop=510","op=1027&sop=520","op=1027&sop=530","op=1027&sop=540","op=1027&sop=550","op=1027&sop=560","op=1027&sop=570"),array($Datos." ".$Origen,$Logos,$Tipos,$Permisos,$Relaciones,$Divisas,$Fuentes));
#		}
#		if ($admin == false) {
#			echo $UseNoAutorizado;
#		}
	}

#	if (($soption == 510) and ($admin == true)) {
	if (($soption == 510)) {
		if ($ssoption == 1) {
			$sql = "select count(*) as total from sgm_dades_origen_factura";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] == 0){
				$camposinsert = "nombre,nif,direccion,poblacion,cp,provincia,mail,telefono";
				$datosInsert = array($_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["mail"],$_POST["telefono"]);
				insertFunction ("sgm_dades_origen_factura",$camposinsert,$datosInsert);
			}
			if ($row["total"] == 1) {
				$camposUpdate = array("nombre","nif","direccion","poblacion","cp","provincia","mail","telefono");
				$datosUpdate = array($_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["mail"],$_POST["telefono"]);
				updateFunction ("sgm_dades_origen_factura","1",$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 2) {
			$camposinsert = "id_dades_origen_factura,entidad_bancaria,iban,descripcion";
			$datosInsert = array($_GET["id"],$_POST["entidad_bancaria"],$_POST["iban"],$_POST["descripcion"]);
			insertFunction ("sgm_dades_origen_factura_iban",$camposinsert,$datosInsert);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("entidad_bancaria","iban","descripcion");
			$datosUpdate = array($_POST["entidad_bancaria"],$_POST["iban"],$_POST["descripcion"]);
			updateFunction ("sgm_dades_origen_factura_iban",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "delete from sgm_dades_origen_factura_iban WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_dades_origen_factura_iban set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
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
		echo boton(array("op=1027&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:40%\">";
					$sql = "select * from sgm_dades_origen_factura";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<table>";
					echo "<form action=\"index.php?op=1027&sop=510&ssop=1\" method=\"post\">";
						echo "<tr><th>".$Nombre."</th><td><input type=\"Text\" name=\"nombre\" style=\"width:300px\" value=\"".$row["nombre"]."\"></td></tr>";
						echo "<tr><th>".$NIF."</th><td><input type=\"Text\" name=\"nif\" style=\"width:300px\" value=\"".$row["nif"]."\"></td></tr>";
						echo "<tr><th>".$Direccion."</th><td><input type=\"Text\" name=\"direccion\" style=\"width:300px\" value=\"".$row["direccion"]."\"></td></tr>";
						echo "<tr><th>".$Poblacion."</th><td><input type=\"Text\" name=\"poblacion\" style=\"width:300px\" value=\"".$row["poblacion"]."\"></td></tr>";
						echo "<tr><th>".$Codigo." ".$Postal."</th><td><input type=\"Text\" name=\"cp\" style=\"width:300px\" value=\"".$row["cp"]."\"></td></tr>";
						echo "<tr><th>".$Provincia."</th><td><input type=\"Text\" name=\"provincia\" style=\"width:300px\" value=\"".$row["provincia"]."\"></td></tr>";
						echo "<tr><th>".$Email."</th><td><input type=\"Text\" name=\"mail\" style=\"width:300px\" value=\"".$row["mail"]."\"></td></tr>";
						echo "<tr><th>".$Telefono."</th><td><input type=\"Text\" name=\"telefono\" style=\"width:300px\" value=\"".$row["telefono"]."\"></td></tr>";
						echo "<tr><th></th><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:300px\"></td></tr>";
					echo "</form>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:60%\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color : Silver;\">";
							echo "<th></th>";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Entidad." ".$Bancaria."</th>";
							echo "<th>IBAN</th>";
							echo "<th>".$Descripcion."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
						echo "<form action=\"index.php?op=1027&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><input type=\"Text\" name=\"entidad_bancaria\" style=\"width:200px\"></td>";
							echo "<td><input type=\"Text\" name=\"iban\" style=\"width:200px\"></td>";
							echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:200px\"></td>";
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
						echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql2 = "select * from sgm_dades_origen_factura_iban where id_dades_origen_factura=".$row["id"];
						$result2 = mysql_query(convert_sql($sql2));
						while ($row2 = mysql_fetch_array($result2)) {
							echo "<tr>";
					$color = "white";
					if ($row2["predefinido"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
							echo "<td>";
						if ($row2["predefinido"] == 1) {
							echo "<form action=\"index.php?op=1027&sop=510&ssop=6&id=".$row2["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
							echo "</form>";
							echo "<td></td>";
						}
						if ($row2["predefinido"] == 0) {
							echo "<form action=\"index.php?op=1027&sop=510&ssop=5&id=".$row2["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
							echo "</form>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1027&sop=511&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						}
							echo "<form action=\"index.php?op=1027&sop=510&ssop=3&id=".$row2["id"]."\" method=\"post\">";
							echo "<td><input type=\"Text\" name=\"entidad_bancaria\" style=\"width:200px\" value=\"".$row2["entidad_bancaria"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"iban\" style=\"width:200px\" value=\"".$row2["iban"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:200px\" value=\"".$row2["descripcion"]."\"></td>";
							echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
							echo "</form>";
						echo "</tr>";
					}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

#	if (($soption == 511) and ($admin == true)) {
	if (($soption == 511)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1027&sop=510&ssop=4&id=".$_GET["id"],"op=1027&sop=510"),array($Si,$No));
		echo "</center>";
	}

#	if (($soption == 520) and ($admin == true)) {
	if (($soption == 520)) {
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
			$sql = "select * from sgm_files_tipos where id=".$tipo;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$lim_tamano = $row["limite_kb"]*1000;
			if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
				if ($_GET["logo"] == 1){$archivo_name = "logo1.jpg";}
				if ($_GET["logo"] == 3){$archivo_name = "logo3.jpg";}
				if (copy ($archivo, "../archivos_comunes/images/".$archivo_name)) {
					if ($_GET["logo"] == 1){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo1='".$archivo_name."'";
						mysql_query(convert_sql($sql));
					}
					if ($_GET["logo"] == 3){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo_ticket='".$archivo_name."'";
						mysql_query(convert_sql($sql));
					}
				}
			}else{
				echo mensaje_error($errorSubirArchivoTamany);
			}
		}
		if ($ssoption == 2) {
			$sql = "update sgm_dades_origen_factura set ";
			if ($_GET["logo"] == 1){ $sql = $sql."logo1=''";}
			if ($_GET["logo"] == 3){ $sql = $sql."logo_ticket=''";}
			mysql_query(convert_sql($sql));
		}
		echo "<h4>".$Logos."</h4>";
		echo boton(array("op=1027&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"70%\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sqlele = "select * from sgm_dades_origen_factura";
						$resultele = mysql_query(convert_sql($sqlele));
						$rowele = mysql_fetch_array($resultele);
						echo "<tr><td colspan=\"2\"><strong>".$Logo." ".$Factura." (320x70 pixels):</strong></td></tr>";
						if ($rowele["logo1"] != ""){
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1027&ssop=521&logo=1\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td><a href=\"../archivos_comunes/images/".$rowele["logo1"]."\" target=\"_blank\"><strong>".$rowele["logo1"]."</a></strong></td>";
							echo "</tr>";
							echo "<tr><td colspan=\"2\"><img src=\"../archivos_comunes/images/".$rowele["logo1"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1027&sop=520&ssop=1&logo=1\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"archivos_comunes/images/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:white;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sqlele = "select * from sgm_dades_origen_factura";
						$resultele = mysql_query(convert_sql($sqlele));
						$rowele = mysql_fetch_array($resultele);
						echo "<tr><td colspan=\"2\"><strong>".$Logo." Ticket (50x50 pixels):</strong></td></tr>";
						if ($rowele["logo_ticket"] != ""){
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1027&ssop=521&logo=3\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td><a href=\"../archivos_comunes/images/".$rowele["logo_ticket"]."\" target=\"_blank\"><strong>".$rowele["logo_ticket"]."</a></strong></td>";
							echo "</tr>";
							echo "<tr><td colspan=\"2\"><img src=\"../archivos_comunes/images/".$rowele["logo_ticket"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1027&sop=520&ssop=1&logo=3\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"archivos_comunes/images/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

#	if (($soption == 521) AND ($admin == true)) {
	if (($soption == 521)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=520&ssop=2&logo=".$_GET["logo"],"op=1011&sop=520"),array($Si,$No));
		echo "</center>";
	}

#	if (($soption == 530) AND ($admin == true)) {
	if (($soption == 530)) {
		if ($ssoption == 1) {
			$camposInsert = "tipo,orden,descripcion,dias,facturable,tpv,caja,v_fecha_prevision,v_fecha_prevision_dias,v_fecha_vencimiento,v_numero_cliente,v_subtipos,v_pesobultos,v_recibos,tipo_ot,presu,presu_dias,stock,aprovado,v_rfq";
			$datosInsert = array($_POST["tipo"],$_POST["orden"],$_POST["descripcion"],$_POST["dias"],$_POST["facturable"],$_POST["tpv"],$_POST["caja"],$_POST["v_fecha_prevision"],$_POST["v_fecha_prevision_dias"],$_POST["v_fecha_vencimiento"],$_POST["v_numero_cliente"],$_POST["v_subtipos"],$_POST["v_pesobultos"],$_POST["v_recibos"],$_POST["tipo_ot"],$_POST["presu"],$_POST["presu_dias"],$_POST["stock"],$_POST["aprovado"],$_POST["v_rfq"]);
			insertFunction ("sgm_factura_tipos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("tipo","orden","descripcion","dias","facturable","tpv","caja","v_fecha_prevision","v_fecha_prevision_dias","v_fecha_vencimiento","v_numero_cliente","v_subtipos","v_pesobultos","v_recibos","tipo_ot","presu","presu_dias","stock","aprovado","v_rfq");
			$datosUpdate = array($_POST["tipo"],$_POST["orden"],$_POST["descripcion"],$_POST["dias"],$_POST["facturable"],$_POST["tpv"],$_POST["caja"],$_POST["v_fecha_prevision"],$_POST["v_fecha_prevision_dias"],$_POST["v_fecha_vencimiento"],$_POST["v_numero_cliente"],$_POST["v_subtipos"],$_POST["v_pesobultos"],$_POST["v_recibos"],$_POST["tipo_ot"],$_POST["presu"],$_POST["presu_dias"],$_POST["stock"],$_POST["aprovado"],$_POST["v_rfq"]);
			updateFunction ("sgm_factura_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_factura_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Tipos."</h4>";
		echo boton(array("op=1027&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<th></th>";
				echo "<th>".$Orden."</th>";
				echo "<th>".$Tipo."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th>".$Plantilla."</th>";
				echo "<th>".$Dias."</th>";
				echo "<th></th>";
				echo "<th>TPV</th>";
				echo "<th>".$Caja."</th>";
				echo "<th></th>";
				echo "<th>V.Prev</th>";
				echo "<th>".$Dias."</th>";
				echo "<th></th>";
				echo "<th>V.Venc</th>";
				echo "<th>V.Ref</th>";
				echo "<th>V.Sub</th>";
				echo "<th>V.Pes</th>";
				echo "<th>V.Rec</th>";
				echo "<th>OT</th>";
				echo "<th>Presu</th>";
				echo "<th>".$Dias."</th>";
				echo "<th>".$Stock."</th>";
				echo "<th>".$Aprobar."</th>";
#				echo "<th>V.RFQ</th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1027&sop=530&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"orden\" style=\"width:20px\" value=\"0\"></td>";
				echo "<td><input type=\"Text\" name=\"tipo\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:200px\"></td>";
				echo "<td><select name=\"facturable\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"dias\" style=\"width:30px\" value=\"0\"></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><select name=\"tpv\" style=\"width:50px\">";
					echo "<option value=\"0\"selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"caja\" style=\"width:50px\">";
					echo "<option value=\"0\"selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td></td>";
				echo "<td><select name=\"v_fecha_prevision\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"v_fecha_prevision_dias\" style=\"width:30px\" value=\"0\"></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><select name=\"v_fecha_vencimiento\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_numero_cliente\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_subtipos\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_pesobultos\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_recibos\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"tipo_ot\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select name=\"presu\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"presu_dias\" style=\"width:30px\" value=\"0\"></td>";
				echo "<td><select name=\"stock\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>=</option>";
					echo "<option value=\"-1\">-</option>";
					echo "<option value=\"1\">+</option>";
				echo "</select></td>";
				echo "<td><select name=\"aprovado\" style=\"width:50px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
#				echo "<td><select name=\"v_rfq\" style=\"width:50px\">";
#					echo "<option value=\"0\" selected>".$No."</option>";
#					echo "<option value=\"1\">".$Si."</option>";
#				echo "</select></td>";
				echo "<td><input type=\"Submit\" style=\"width:100px\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqltipos = "select * from sgm_factura_tipos where visible=1 order by orden,descripcion";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)) {
				echo "<form action=\"index.php?op=1027&sop=530&ssop=2&id=".$rowtipos["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1027&sop=501&id=".$rowtipos["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input type=\"Text\" name=\"orden\" value=\"".$rowtipos["orden"]."\" style=\"width:20px\"></td>";
					echo "<td><input type=\"Text\" name=\"tipo\" value=\"".$rowtipos["tipo"]."\" style=\"width:150px\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" value=\"".$rowtipos["descripcion"]."\" style=\"width:200px\"></td>";
					echo "<td><select name=\"facturable\" style=\"width:50px\">";
						if ($rowtipos["facturable"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["facturable"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"dias\" value=\"".$rowtipos["dias"]."\" style=\"width:30px\"></td>";
					echo "<td>&nbsp;</td>";
					echo "<td><select name=\"tpv\" style=\"width:50px\">";
						if ($rowtipos["tpv"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["tpv"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"caja\" style=\"width:50px\">";
						if ($rowtipos["caja"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["caja"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td>&nbsp;</td>";
					echo "<td><select name=\"v_fecha_prevision\" style=\"width:50px\">";
						if ($rowtipos["v_fecha_prevision"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_fecha_prevision"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"v_fecha_prevision_dias\" value=\"".$rowtipos["v_fecha_prevision_dias"]."\" style=\"width:30px\"></td>";
					echo "<td>&nbsp;</td>";
					echo "<td><select name=\"v_fecha_vencimiento\" style=\"width:50px\">";
						if ($rowtipos["v_fecha_vencimiento"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_fecha_vencimiento"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_numero_cliente\" style=\"width:50px\">";
						if ($rowtipos["v_numero_cliente"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_numero_cliente"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_subtipos\" style=\"width:50px\">";
						if ($rowtipos["v_subtipos"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_subtipos"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_pesobultos\" style=\"width:50px\">";
						if ($rowtipos["v_pesobultos"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_pesobultos"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_recibos\" style=\"width:50px\">";
						if ($rowtipos["v_recibos"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["v_recibos"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"tipo_ot\" style=\"width:50px\">";
						if ($rowtipos["tipo_ot"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["tipo_ot"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"presu\" style=\"width:50px\">";
						if ($rowtipos["presu"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["presu"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"presu_dias\" value=\"".$rowtipos["presu_dias"]."\" style=\"width:30px\"></td>";
					echo "<td><select name=\"stock\" style=\"width:50px\">";
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
					echo "<td><select name=\"aprovado\" style=\"width:50px\">";
						if ($rowtipos["aprovado"] == 0) {
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($rowtipos["aprovado"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
#					echo "<td><select name=\"v_rfq\" style=\"width:50px\">";
#						if ($rowtipos["v_rfq"] == 0) {
#							echo "<option value=\"0\" selected>".$No."</option>";
#							echo "<option value=\"1\">".$Si."</option>";
#						}
#						if ($rowtipos["v_rfq"] == 1) {
#							echo "<option value=\"0\">".$No."</option>";
#							echo "<option value=\"1\" selected>".$Si."</option>";
#						}
#					echo "</select></td>";
					echo "<td><input type=\"Submit\" style=\"width:100px\" value=\"".$Modificar."\"></td>";
					echo "<td>";
						echo boton_form("op=1027&sop=535&id=".$rowtipos["id"],$Opciones);
					echo "</td>";
				echo "</tr>";
				echo "</form>";
			}
		echo "</table>";
		echo "<br>".$ayudaFacturaTipos;
	}

#	if (($soption == 531) AND ($admin == true)) {
	if (($soption == 531)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1027&sop=530&ssop=3&id=".$_GET["id"],"op=1027&sop=530"),array($Si,$No));
		echo "</center>";
	}

#	if (($soption == 535) and ($admin == true)) {
	if ($soption == 535) {
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
			$sql = "select * from sgm_idiomas where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqli = "select * from sgm_factura_tipos_idiomas where id_tipo=".$_GET["id"]." and id_idioma=".$row["id"];
				$resulti = mysql_query(convert_sql($sqli));
				$rowi = mysql_fetch_array($resulti);
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
		$sqltipos = "select * from sgm_factura_tipos where visible=1 and id=".$_GET["id"];
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		echo "<h4>".$rowtipos["tipo"]."</h4>";
		echo boton(array("op=1027&sop=530"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"70%\">";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
					$sqltipos = "select * from sgm_factura_tipos where visible=1 and id=".$_GET["id"];
					$resulttipos = mysql_query(convert_sql($sqltipos));
					$rowtipos = mysql_fetch_array($resulttipos);
						echo "<tr style=\"background-color:silver;\">";
							echo "<th></th>";
							echo "<th>".$Idiomas."</th>";
						echo "</tr>";
						echo "<form method=\"post\" action=\"index.php?op=1027&sop=535&ssop=4&id=".$_GET["id"]."\">";
						$sql = "select * from sgm_idiomas where visible=1";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							$sqli = "select * from sgm_factura_tipos_idiomas where id_tipo=".$_GET["id"]." and id_idioma=".$row["id"];
							$resulti = mysql_query(convert_sql($sqli));
							$rowi = mysql_fetch_array($resulti);
							echo "<tr>";
								echo "<td>".$row["descripcion"]."</td>";
								echo "<td><input type=\"Text\" name=\"tipo".$row["id"]."\" value=\"".$rowi["tipo"]."\"></td>";
							echo "</tr>";
						}
						echo "<tr><td></td><td><input type=\"Submit\" style=\"width:100px\" value=\"".$Modificar."\"></td></tr>";
						echo "</form>";
					echo "</table>";
				echo "</td><td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Subtipos."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<form action=\"index.php?op=1027&sop=535&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
						echo "<tr>";
							echo "<td></td>";
							echo "<td><input type=\"text\" name=\"subtipo\"></td>";
							echo "<td><input type=\"submit\" style=\"width:100px;\" value=\"".$Anadir."\"></td>";
						echo "</tr>";
						echo "</form>";
						$sqlstipos = "select * from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
						$resultstipos = mysql_query(convert_sql($sqlstipos));
						while ($rowstipos = mysql_fetch_array($resultstipos)) {
							echo "<form action=\"index.php?op=1027&sop=535&ssop=2&id=".$_GET["id"]."&id_sub=".$rowstipos["id"]."\" method=\"post\">";
							echo "<tr>";
								echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1027&sop=536&id=".$_GET["id"]."&id_sub=".$rowstipos["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
								echo "<td><input type=\"text\" value=\"".$rowstipos["subtipo"]."\" name=\"subtipo\"></td>";
								echo "<td><input type=\"submit\" style=\"width:100px;\" value=\"".$Modificar."\"></td>";
							echo "</tr>";
							echo "</form>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

#	if (($soption == 536) AND ($admin == true)) {
	if (($soption == 536)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1027&sop=535&ssop=3&id=".$_GET["id"]."&id_sub=".$_GET["id_sub"],"op=1027&sop=535&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#	if (($soption == 540) AND ($admin == true)) {
	if ($soption == 540) {
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
		echo boton(array("op=1027&sop=500","op=1027&sop=540&tip=1","op=1027&sop=540&tip=2"),array("&laquo; ".$Volver,$Ver_Por_Tipo,$Ver_Por_Usuario));
		if (($soption == 540) and ($_GET["tip"] == 1)) {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color : Silver;\">";
					echo "<th>".$Tipo."</th>";
					echo "<th>".$Eliminar."</th>";
					echo "<th>".$Usuario."</th>";
					echo "<th>".$Admin."</th>";
				echo "</tr>";
				$sql = "select * from sgm_factura_tipos where visible=1 order by tipo";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
					echo "<form action=\"index.php?op=1027&sop=540&tip=1&ssop=1&id_tipo=".$row["id"]."\" method=\"post\">";
						echo "<td style=\"width:150px;text-align:right;\">".$row["tipo"]."</td>";
						echo "<td></td>";
						echo "<td><select name=\"id_user\" style=\"width:150px\">";
							echo "<option value=\"0\">-</option>";
							$sqlx = "select * from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
							$resultx = mysql_query(convert_sql($sqlx));
							while ($rowx = mysql_fetch_array($resultx)) {
								echo "<option value=\"".$rowx["id"]."\">".$rowx["usuario"]."</option>";
							}
						echo "</select></td>";
						echo "<td><select name=\"admin\" style=\"width:50px\">";
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						echo "</select></td>";
						echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
					echo "</form>";
					echo "</tr>";
					$sql2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$row["id"];
					$result2 = mysql_query(convert_sql($sql2));
					while ($row2 = mysql_fetch_array($result2)) {
						$sqlv = "select * from sgm_users where id=".$row2["id_user"];
						$resultv = mysql_query(convert_sql($sqlv));
						$rowv = mysql_fetch_array($resultv);
						echo "<tr>";
						echo "<form action=\"index.php?op=1027&sop=540&tip=1&ssop=2&id=".$row2["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1027&sop=541&tip=1&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
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
							echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
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
				$sqlx = "select * from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
				$resultx = mysql_query(convert_sql($sqlx));
				while ($rowx = mysql_fetch_array($resultx)) {
					echo "<tr>";
					echo "<form action=\"index.php?op=1027&sop=540&tip=2&ssop=1&id_user=".$rowx["id"]."\" method=\"post\">";
						echo "<td style=\"width:150px;text-align:right;\">".$rowx["usuario"]."</td>";
						echo "<td></td>";
						echo "<td><select name=\"id_tipo\" style=\"width:150px\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select * from sgm_factura_tipos where visible=1 order by tipo";
							$result = mysql_query(convert_sql($sql));
							while ($row = mysql_fetch_array($result)) {
								echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
							}
						echo "</select></td>";
						echo "<td><select name=\"admin\" style=\"width:50px\">";
						echo "<option value=\"0\" selected>".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
						echo "</select></td>";
						echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
					echo "</form>";
					echo "</tr>";
					$sql2 = "select * from sgm_factura_tipos_permisos where id_user=".$rowx["id"];
					$result2 = mysql_query(convert_sql($sql2));
					while ($row2 = mysql_fetch_array($result2)) {
						$sqlv = "select * from sgm_factura_tipos where visible=1 and id=".$row2["id_tipo"];
						$resultv = mysql_query(convert_sql($sqlv));
						$rowv = mysql_fetch_array($resultv);
						echo "<tr>";
						echo "<form action=\"index.php?op=1027&sop=540&tip=2&ssop=2&id=".$row2["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1027&sop=541&tip=2&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
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
							echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
						echo "</form>";
						echo "</tr>";
					}
				}
			echo "</table>";
		}
	}

#	if (($soption == 541) AND ($admin == true)) {
	if ($soption == 541) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1027&sop=540&ssop=3&tip=".$_GET["tip"]."&id=".$_GET["id"],"op=1027&sop=540&tip=".$_GET["tip"]),array($Si,$No));
		echo "</center>";
	}
	
#	if (($soption == 550) AND ($admin == true)) {
	if ($soption == 550) {
		if ($ssoption == 1) {
			if ($_POST["id_tipo_d"] != 0) {
				$camposInsert = "id_tipo_o,id_tipo_d";
				$datosInsert = array($_GET["id_tipo_o"],$_POST["id_tipo_d"]);
				insertFunction ("sgm_factura_tipos_relaciones",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_factura_tipos_relaciones",$_GET["id"]);
		}

		echo "<h4>".$Relaciones."</h4> (".$ayudaFecturaRelaciones.")";
		echo boton(array("op=1027&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Origen."</th>";
				echo "<th>".$Destino."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sqltipos = "select * from sgm_factura_tipos where visible=1 order by tipo";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)) {
			echo "<form method=\"post\" action=\"index.php?op=1027&sop=550&ssop=1&id_tipo_o=".$rowtipos["id"]."\">";
				echo "<tr>";
					echo "<td>".$rowtipos["tipo"]."</td>";
					echo "<td><select name=\"id_tipo_d\" style=\"width:150px;\">";
						echo "<option value=\"0\">-</option>";
						$sqltipos1 = "select * from sgm_factura_tipos where visible=1 order by tipo";
						$resulttipos1 = mysql_query(convert_sql($sqltipos1));
						while ($rowtipos1 = mysql_fetch_array($resulttipos1)) {
							echo "<option value=\"".$rowtipos1["id"]."\">".$rowtipos1["tipo"]."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Relacionar."\"></td>";
				echo "<tr>";
				echo "</form>";
				$sqltiposrel = "select * from sgm_factura_tipos_relaciones where id_tipo_o=".$rowtipos["id"];
				$resulttiposrel = mysql_query(convert_sql($sqltiposrel));
				while ($rowtiposrel = mysql_fetch_array($resulttiposrel)) {
					$sqltipos2 = "select * from sgm_factura_tipos where id=".$rowtiposrel["id_tipo_d"];
					$resulttipos2 = mysql_query(convert_sql($sqltipos2));
					$rowtipos2 = mysql_fetch_array($resulttipos2);
					echo "<tr>";
						echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1027&sop=551&id=".$rowtiposrel["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						echo "<td>".$rowtipos2["tipo"]."</td>";
					echo "</tr>";
				}
			}
		echo "</table>";
	}

#	if (($soption == 551) AND ($admin == true)) {
	if (($soption == 551) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1002&sop=550&ssop=3&id=".$_GET["id"],"op=1002&sop=550"),array($Si,$No));
		echo "</center>";
	}

#	if (($soption == 560) AND ($admin == true)) {
	if ($soption == 560) {
		if ($ssoption == 1) {
			$camposInsert = "abrev,divisa,canvi,simbolo";
			$datosInsert = array($_POST["abrev"],$_POST["divisa"],$_POST["canvi"],$_POST["simbolo"]);
			insertFunction ("sgm_divisas",$camposInsert,$datosInsert);

			$sqld = "select * from sgm_divisas order by id desc";
			$resultd = mysql_query(convert_sql($sqld));
			$rowd = mysql_fetch_array($resultd);
			$fecha=date("Y-m-d");
			$camposInsert = "id_divisa,id_usuario,fecha,canvi";
			$datosInsert = array($rowd["id"],$userid,$fecha,$_POST["canvi"]);
			insertFunction ("sgm_divisas_mod_canvi",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$sqld = "select * from sgm_divisas where id=".$_GET["id"];
			$resultd = mysql_query(convert_sql($sqld));
			$rowd = mysql_fetch_array($resultd);
			if ($rowd["canvi"] != $_POST["canvi"]){
				$fecha=date("Y-m-d");
				$camposInsert = "id_divisa,id_usuario,fecha,canvi";
				$datosInsert = array($_GET["id"],$userid,$fecha,$_POST["canvi"]);
				insertFunction ("sgm_divisas_mod_canvi",$camposInsert,$datosInsert);
			}
			$camposUpdate = array("abrev","divisa","canvi","simbolo");
			$datosUpdate = array($_POST["abrev"],$_POST["divisa"],$_POST["canvi"],$_POST["simbolo"]);
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
			mysql_query(convert_sql($sql));
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
		echo boton(array("op=1027&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Predeterminado."</th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Abreviatura."</th>";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$Simbolo."</th>";
				echo "<th>".$Cambio."</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<form action=\"index.php?op=1027&sop=560&ssop=1\" method=\"post\">";
				echo "<td style=\"text-align:center;width:40;\"></td>";
				echo "<td style=\"text-align:center;width:40;\"></td>";
				echo "<td><input type=\"Text\" style=\"width:60px\" name=\"abrev\"></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" name=\"divisa\"></td>";
				echo "<td><input type=\"Text\" style=\"width:20px\" name=\"simbolo\"></td>";
				echo "<td><input type=\"Text\" style=\"width:100px\" name=\"canvi\" value=\"0\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "</form>";
			echo "</tr>";
			$sql = "select * from sgm_divisas where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["predefinido"] == 1) { $color = "#FF4500"; }
					echo "<tr style=\"background-color : ".$color."\">";
					echo "<td>";
				if ($row["predefinido"] == 1) {
					echo "<form action=\"index.php?op=1027&sop=560&ssop=5&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"Despred.\" style=\"width:100px\">";
					echo "</form>";
					echo "<td></td>";
				}
				if ($row["predefinido"] == 0) {
					echo "<form action=\"index.php?op=1027&sop=560&ssop=4&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"Pred.\" style=\"width:100px\">";
					echo "</form>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1027&sop=561&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				}
				echo "<form action=\"index.php?op=1027&sop=560&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" style=\"width:60px\" name=\"abrev\" value=\"".$row["abrev"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" name=\"divisa\" value=\"".$row["divisa"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:20px\" name=\"simbolo\" value=\"".$row["simbolo"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:100px\" name=\"canvi\" value=\"".$row["canvi"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1027&sop=565&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
	}

#	if (($soption == 561) AND ($admin == true)) {
	if (($soption == 561) ) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1027&sop=560&ssop=3&id=".$_GET["id"],"op=1027&sop=560"),array($Si,$No));
		echo "</center>";
	}

#	if (($soption == 565) AND ($admin == true)) {
	if ($soption == 565) {
		echo "<h4>".$Detalles." ".$Divisas."</h4>";
		echo boton(array("op=1027&sop=560"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Cambio."</th>";
				echo "<th>".$Usuario."</th>";
			echo "</tr>";
			echo $sql = "select * from sgm_divisas_mod_canvi where id_divisa=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlu = "select * from sgm_users where id=".$row["id_usuario"];
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
				echo "<td style=\"text-align:left;width:100px\">".$row["fecha"]."</td>";
				echo "<td style=\"text-align:left;width:100px\">".$row["canvi"]."</td>";
				echo "<td style=\"text-align:left;width:100px\">".$rowu["usuario"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

#	if (($soption == 570) AND ($admin == true)) {
	if ($soption == 570) {
		echo "<h4>".$Fuentes."</h4>";
		echo boton(array("op=1027&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Fuentes."</td>";
			echo "</tr><td>&nbsp;</td><tr>";
			echo "</tr><tr>";
				echo "<td><a href=\"mgestion/fonts/C39HrP24DlTt.ttf?\">".$Codigo." de ".$Barras."</a></td>";
			echo "</tr>";
		echo "</table>";
	}
	
	echo "</td></tr></table><br>";
}
?>