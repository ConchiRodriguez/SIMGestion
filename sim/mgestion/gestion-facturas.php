<?php

### POSIBILITAT DE CANVIAR SUBTIPUS FATCURA ON COP EDITADA
### BLOQUEJAR CANVI USUARI CREACIO

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) { echo "<center><br><strong>".$UsuarioNoAutorizado."</strong></center><br><br>"; }
if (($option == 1003) AND ($autorizado == true)) {

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:20%;vertical-align : top;text-align:left;\">";
		echo "<strong>".$Facturacion." :</strong><br>";
		echo "<br><a href=\"index.php?op=1003&sop=102\">&raquo; ".$Resumenes." ".$Totales."</a>";
		echo "<br><a href=\"index.php?op=1003&sop=105\">&raquo; ".$Situacion." ".$Anual."</a>";
		echo "<br><a href=\"index.php?op=1003&sop=120\">&raquo; ".$Resumenes." por ".$Usuarios."</a>";
		echo "</td><td style=\"width:20%;vertical-align : top;text-align:left;\">";
		$sqltipos = "select count(*) as total from sgm_factura_tipos where visible=1";
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		$lineas = number_format((($rowtipos["total"])/3), 0, ',', '.');
		$x = 0;
		$y = 1;
		$sqltipos2 = "select * from sgm_factura_tipos where visible=1 order by orden,descripcion";
		$resulttipos2 = mysql_query(convert_sql($sqltipos2));
		while ($rowtipos2 = mysql_fetch_array($resulttipos2)) {
			if ($x >= ($lineas*$y)) {
				echo "</td><td style=\"width:20%;vertical-align : top;text-align:left;\">";
				$y++;
			}
			$x++;
			$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
			$resultpermiso = mysql_query(convert_sql($sqlpermiso));
			$rowpermiso = mysql_fetch_array($resultpermiso);
			if ($rowpermiso["total"] > 0) { 
				$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
				$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
				$rowpermiso2 = mysql_fetch_array($resultpermiso2);
				if ($rowpermiso2["admin"] == 0) { echo "<br><a href=\"index.php?op=1003&sop=10&id=".$rowtipos2["id"]."\">&raquo; ".$rowtipos2["tipo"]."</a>"; }
				if ($rowpermiso2["admin"] == 1) { echo "<br><a href=\"index.php?op=1003&sop=10&id=".$rowtipos2["id"]."\">&raquo; <strong>".$rowtipos2["tipo"]."</strong></a>"; }
			} else { echo "<br>&raquo; ".$rowtipos2["tipo"]; }
		}
		echo "</td><td style=\"width:20%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if ($soption == 70) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=70\" class=".$class.">".$Impresion."</a></td>";
					if ($soption == 910) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=910\" class=".$class.">".$Buscar."</a></td>";
					if (($soption == 40) or ($soption == 400) or ($soption == 500) or ($soption == 550) or ($soption == 300) or ($soption == 800) or ($soption == 310) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1003&sop=40\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
	echo "</td></tr></table><br>";
	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 5) {
		if ($ssoption == 1000) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				$archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
			}
			$sql = "select * from sgm_files_tipos where id=".$_POST["id_tipo"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$lim_tamano = $row["limite_kb"]*1000;
			$sqlt = "select count(*) as total from sgm_files where name='".$archivo_name."'";
			$resultt = mysql_query(convert_sql($sqlt));
			$rowt = mysql_fetch_array($resultt);
			if ($rowt["total"] != 0) {
				echo mensaje_error("No se puede añadir archivo por que ya existe uno con el mismo nombre.");
			} else {
				if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
					if (copy ($archivo, "files/facturacion/".$archivo_name)) {
						$sql = "insert into sgm_files (id_tipo,name,type,size,id_cuerpo) ";
						$sql = $sql."values (";
						$sql = $sql."".$_POST["id_tipo"]."";
						$sql = $sql.",'".$archivo_name."'";
						$sql = $sql.",'".$archivo_type."'";
						$sql = $sql.",".$archivo_size."";
						$sql = $sql.",".$_GET["id"]."";
						$sql = $sql.")";
						mysql_query(convert_sql($sql));
					}
				}else{
					echo mensaje_error("<h2>No ha podido transferirse el archivo.</h2><br><h3>Su tamaño no puede exceder de ".$lim_tamano." bytes.</h2>");
				}
			}
		}

		if ($ssoption == 1001) {
			echo "<center>";
			echo "¿Seguro que desea eliminar este archivo?";
			echo "<br><br><a href=\"index.php?op=1003&sop=5&ssop=1002&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=70&id=".$_GET["id"]."\">[ NO ]</a>";
			echo "</center>";
		}

		if ($ssoption == 1002) {
			$sql = "delete from sgm_files WHERE id=".$_GET["id_archivo"];
			mysql_query(convert_sql($sql));
			echo "<center>";
			echo "Operación realizada correctamente.";
			echo "</center>";
		}

			echo "<table><tr>";
				echo "<td class=\"menu\">";
					echo "<a href=\"index.php?op=1003&sop=22&id=".$_GET["id_factura"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
			echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:600px;vertical-align:top;\">";
			echo "<strong>".$Listado." de ".$Archivos." :</strong><br><br>";
						$sql = "select * from sgm_files_tipos order by nombre";
						$result = mysql_query(convert_sql($sql));
						echo "<table>";
						while ($row = mysql_fetch_array($result)) {
							$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and id_cuerpo=".$_GET["id"];
							$resultele = mysql_query(convert_sql($sqlele));
							while ($rowele = mysql_fetch_array($resultele)) {
								echo "<tr><td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urlmgestion."/files/facturacion/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td>&nbsp;<a href=\"index.php?op=1003&sop=5&ssop=1001&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\">[ Eliminar ]</a></td></tr>";
							}
						}
						echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>".$Formulario." de ".$envio." de ".$Archivos." :</strong><br><br>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1003&sop=5&ssop=1000&id=".$_GET["id"]."&id_factura=".$_GET["id_factura"]."\" method=\"post\">";
					echo "<select name=\"id_tipo\" style=\"width:300px\">";
						$sql = "select * from sgm_files_tipos order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"file\" name=\"archivo\" style=\"width:300px\">";
					echo "<br><br><input type=\"submit\" value=\"".$Enviar." a la ".$carpeta." files/facturacion\" style=\"width:300px\">";
					echo "</form>";
			echo "</td></tr></table>";
	}


	if ($soption == 9) {
		$sql = "update sgm_cabezera set ";
		if ($_POST["cobrada"] == 'ok') { $sql = $sql."cobrada=1"; }
		if ($_POST["cobrada"] != 'ok') { $sql = $sql."cobrada=0"; }
		$sql = $sql.",id_tipo_pago=".$_POST["id_tipo_pago"];
		$sql = $sql." WHERE id=".$_POST["id"]."";
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=10&id=".$_GET["id_tipo"]."\">[ ".$Volver." ]</a>";
	}

	if ($soption == 10) {
		if ($ssoption == 1) {
			$sqlcc = "select count(*) as total from sgm_cabezera where visible=1 and numero=".$_POST["numero"]." and tipo=".$_POST["tipo"];
			$resultcc = mysql_query(convert_sql($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			if ($rowcc["total"] == 0){
				insertCabezera($_POST["numero"],$_POST["tipo"],$_POST["subtipo"],$_POST["version"],$_POST["numero_rfq"],$_POST["numero_cliente"],cambiarFormatoFechaYMD($_POST["fecha"]),cambiarFormatoFechaYMD($_POST["fecha_prevision"]),$_POST["cliente"],0,0,0);
			}
		}
		if ($ssoption == 20) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 7) {
			echo trafactura($_GET["id_fact"],$_POST["id_tipus"],$_POST["data"]);
		}
		if ($ssoption == 8) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."cerrada=1";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<center>";
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id"];
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		$admin_tipo = 0;
		$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$rowtipos["id"]." and id_user=".$userid;
		$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
		$rowpermiso2 = mysql_fetch_array($resultpermiso2);
		if ($rowpermiso2["admin"] == 1) { $admin_tipo = 1; }
		echo "<table style=\"width:100%\">";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<strong style=\"font-size : 20px;\">".$rowtipos["tipo"]."</strong><br><br>";
					if ($ssoption == 10){
						echo "<a href=\"index.php?op=1003&sop=10&id=".$rowtipos["id"]."\">&raquo; ".$Actual."</a>&nbsp;";
					} else {
						echo "<a href=\"index.php?op=1003&sop=10&id=".$rowtipos["id"]."&ssop=10\">&raquo; ".$Historico."</a>&nbsp;";
					}
					if ($admin_tipo == 1) { echo "<br><a href=\"index.php?op=1003&sop=103&id=".$rowtipos["id"]."\">&raquo; ".$Resumenes." ".$Totales."</a>"; }
					if ($admin_tipo == 1) { echo "<br><a href=\"index.php?op=1003&sop=110&id=".$rowtipos["id"]."\">&raquo; ".$Resumenes." ".$Periodos."</a>"; }
				echo "</td>";
				echo "<td style=\"width:50%;background-color : #DBDBDB;text-align:center;vertical-align:top;\">";
					echo "<center><table>";
						echo "<tr>";
							echo "<td><strong>".$Cliente."</strong></td>";
							echo "<td><strong>Ref. Ped. Cli.</strong></td>";
							echo "<td><strong>".$Desde."</strong></td>";
							echo "<td><strong>".$Hasta."</strong></td>";
							echo "<td><strong>".$Articulo."</strong></td>";
						echo "</tr><tr>";
							echo "<form action=\"index.php?op=1003&sop=10&filtra=1&hist=0&id=".$_GET["id"]."\" method=\"post\">";
							echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
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
							echo "<form action=\"index.php?op=1003&sop=10&ssop=10&filtra=1&hist=1&id=".$_GET["id"]."\" method=\"post\">";
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
					echo "</table></center>";
					echo "<br>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:1000px\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td></td>";
				if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
					echo "<td>Docs</td>";
				}
				echo "<td style=\"width:70px\"><center>".$Numero."</center></td>";
				if ($rowtipos["presu"] == 1) { echo "<td style=\"width:30px;text-align:center\">Ver.</td>"; }
				echo "<td style=\"width:100px;text-align:center\">".$Fecha."</td>";
				if ($rowtipos["v_fecha_prevision"] == 1) { echo "<td style=\"width:90px;text-align:center\">".$Fecha." ".$Prevision."</td>"; }
				if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td style=\"width:90px;text-align:center\">".$Vencimiento."</td>"; }
				if ($rowtipos["v_numero_cliente"] == 1) { echo "<td style=\"width:90px;text-align:center\"><center>Ref. Ped. Cli.</center></td>"; }
				if ($rowtipos["v_rfq"] == 1) { echo "<td style=\"width:90px;text-align:center\"><center>".$Numero." RFQ</center></td>"; }
				if ($rowtipos["tpv"] == 0) { echo "<td>".$Cliente."</td>"; }
				if ($rowtipos["v_subtipos"] == 1) { echo "<td style=\"width:90px;text-align:center\"><center>".$Subtipo."</center></td>"; }
				echo "<td style=\"width:90px;text-align:center\">".$Total."</td><td></td>";
		if ($_GET["filtra"]  == 1){
				echo "<form action=\"index.php?op=1003&sop=10&ssop=".$_GET["ssop"]."&filtra=1&id=".$_GET["id"]."&hist=".$_GET["hist"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
				echo "<input type=\"Hidden\" name=\"id_cliente2\" value=\"".$_POST["id_cliente2"]."\">";
				echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
				echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
				echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
				echo "<input type=\"Hidden\" name=\"data_desde2\" value=\"".$_POST["data_desde2"]."\">";
				echo "<input type=\"Hidden\" name=\"data_fins2\" value=\"".$_POST["data_fins2"]."\">";
				echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
				echo "<input type=\"Hidden\" name=\"todo\" value=\"1\">";
				echo "<td></td><td></td><td><input type=\"Submit\" value=\"".$Desplegar." ".$Todo."\" style=\"width:110px\"></td>";
				echo "</form>";
		}
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1003&sop=10&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
				$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." order by numero desc";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$numero = $row["numero"] + 1;
				echo "<td></td>";
				if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
					echo "<td></td>";
				}
				echo "<td><input type=\"Text\" name=\"numero\" value=\"".$numero."\" style=\"width:65px;text-align:right;\"></td>";
				if ($rowtipos["presu"] == 1) { 
					echo "<td style=\"width:30px;text-align:center\"><input type=\"Text\" name=\"version\" value=\"0\" style=\"width:25px\"></td>";
				} else {
					echo "<input type=\"hidden\" name=\"version\" value=\"0\">";
				}
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				echo "<td><input type=\"Text\" name=\"fecha\" style=\"width:100px\" value=\"".cambiarFormatoFechaDMY($date1)."\"></td>";
			### CALCULO DE LA FECHA DE PREVISION DE ENTREGA
				$suma = $rowtipos["v_fecha_prevision_dias"];
				$a = date("Y", strtotime($date1)); 
				$m = date("n", strtotime($date1)); 
				$d = date("j", strtotime($date1)); 
				$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d+$suma, $a));
				if ($rowtipos["v_fecha_prevision"] == 1) { 
					echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:70px\" value=\"".cambiarFormatoFechaDMY($fecha_prevision)."\"></td>";
				} else {
					echo "<input type=\"hidden\" name=\"fecha_prevision\" style=\"width:70px\" value=\"0\">";
				}
				if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td></td>"; }
				if ($rowtipos["v_numero_cliente"] == 1) { 
					echo "<td><input type=\"Text\" name=\"numero_cliente\" style=\"width:150px\"></td>";
				} else { "<input type=\"hidden\" name=\"numero_cliente\">"; }
				if ($rowtipos["v_rfq"] == 1) { 
					echo "<td><input type=\"Text\" name=\"numero_rfq\" style=\"width:125px\"></td>";
				} else { "<input type=\"hidden\" name=\"numero_rfq\">"; }
				if ($rowtipos["tpv"] == 0) { 
					echo "<td>";
						echo "<select style=\"width:300px\" name=\"cliente\">";
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
					echo "<input type=\"hidden\" name=\"cliente\" value=\"0\">";
				}
				if ($rowtipos["v_subtipos"] == 1) {
					echo "<td>";
						echo "<select style=\"width:70px\" name=\"subtipo\">";
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
				echo "<td><input type=\"Submit\" value=\"".$Nueva."\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$totalSensePagar = 0;
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"];
			if (($_GET["filtra"] == 1) AND ($_POST["id_cliente"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente"]; }
			if (($_GET["filtra"] == 1) AND ($_POST["id_cliente2"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente2"]; }
			if (($_GET["filtra"] == 1) AND ($_POST["ref_cli"] != '')) { $sql = $sql." AND numero_cliente like '%".$_POST["ref_cli"]."%'"; }
			if (($_GET["filtra"] == 1) AND ($_GET["fecha"] != 0)) { $sql = $sql." AND fecha='".date("Y-m-d", $_GET["fecha"])."'"; }
			if (($_GET["filtra"] == 1) AND ($_POST["data_desde1"] != 0)) { $sql = $sql." AND fecha>='".cambiarFormatoFechaDMY($_POST["data_desde1"])."'"; }
			if (($_GET["filtra"] == 1) AND ($_POST["data_fins1"] != 0)) { $sql = $sql." AND fecha<='".cambiarFormatoFechaDMY($_POST["data_fins1"])."'"; }
			if (($_GET["filtra"] == 1) AND ($_POST["data_desde2"] != 0)) { $sql = $sql." AND fecha>='".cambiarFormatoFechaDMY($_POST["data_desde2"])."'"; }
			if (($_GET["filtra"] == 1) AND ($_POST["data_fins2"] != 0)) { $sql = $sql." AND fecha<='".cambiarFormatoFechaDMY($_POST["data_fins2"])."'"; }
			$sql = $sql." order by numero desc,version desc,fecha desc";
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
				if ($ssoption == 10) { $ver = 1; }
				if ($_GET["filtra"]  == 1){
					$sqlcc = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
					if ($_POST["articulo"] != '') { $sqlcc = $sqlcc." AND ((codigo like '%".$_POST["articulo"]."%') or (nombre like '%".$_POST["articulo"]."%'))"; }
#					echo $sqlcc."<br>";
					$resultcc = mysql_query(convert_sql($sqlcc));
					$rowcc = mysql_fetch_array($resultcc);
					if ($rowcc){ $ver = 1; } else { $ver = 0; }
				}
				#factura
				if ($rowtipos["v_recibos"] == 1) {
					$date = getdate();
					$hoyd = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
					if (($row["cobrada"] == 1) and ($ssoption != 10)){
						$ver = 0;
					}
				}
				if (($row["cerrada"] == 1) and ($ssoption != 10)) { $ver = 0; }
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
					echo "<tr style=\"border-bottom : 1px dashed Black;\">";
#						echo "<td><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
						echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=600&id=".$row["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"Opciones\" style=\"width:70px\"></form></td>";
					if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
						$sqlca = "select count(*) as total from sgm_files where id_cuerpo in (select id from sgm_cuerpo where idfactura=".$row["id"].")";
						$resultca = mysql_query(convert_sql($sqlca));
						$rowca = mysql_fetch_array($resultca);
						if ($rowca["total"] == 0) {$color_docs = "yellow";} else {$color_docs = "white";}
						echo "<td style=\"background-color:".$color_docs.";\">(".$rowca["total"].")</td>";
					}
#						echo "</tr></table></td>";
						echo "<td style=\"background-color : ".$color.";text-align:right;width:65px\"><strong>".$row["numero"]."</strong></td>";
						if ($rowtipos["presu"] == 1) { echo "<td style=\"background-color:".$color.";text-align:left\"><strong>/".$row["version"]."</strong></td>"; }
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
								echo "<td style=\"background-color : ".$color.";text-align:center;\"><strong>".cambiarFormatoFechaDMY($row["fecha"])."</strong></td>";
							} else { 
								if ($fecha_proxima > $date1) {
									$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
									if ($fecha_aviso <  $date1) {
										echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
									} else {
										echo "<td style=\"background-color : ".$color.";text-align:center;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
									}
								} else {
									echo "<td style=\"background-color:red;color:White;text-align:center;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>"; }
								}
								if ($rowtipos["v_fecha_prevision"] == 1) { echo "<td style=\"background-color : ".$color.";text-align:center;\">".cambiarFormatoFechaDMY($row["fecha_prevision"])."</td>"; }
								if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td style=\"background-color : ".$color.";text-align:center;\">".cambiarFormatoFechaDMY($row["fecha_vencimiento"])."</td>"; }
								if ($rowtipos["v_numero_cliente"] == 1) {
									if (($rowtipos["tipo_ot"] == 1) and ($row["confirmada"] == 1)) {
										echo "<td style=\"background-color : ".$color.";\">".$row["numero_cliente"]."</td>";
									} else {
										if ($rowtipos["presu"] == 1){
											echo "<td style=\"background-color : ".$color.";\">".$row["numero_cliente"]."</td>";
										} else {
											echo "<td>".$row["numero_cliente"]."</td>";
										}
									}
								}
								if ($rowtipos["v_rfq"] == 1) {
									if (($rowtipos["tipo_ot"] == 1) and ($row["aprovado"] == 1)) {
										echo "<td style=\"background-color : ".$color.";\">".$row["numero_rfq"]."</td>";
									} else {
										if ($rowtipos["presu"] == 1){
											echo "<td style=\"background-color : ".$color.";\">".$row["numero_rfq"]."</td>";
										} else {
											echo "<td>".$row["numero_rfq"]."</td>";
										}
									}
								}
								if ($rowtipos["tpv"] == 0) {
									if (strlen($row["nombre"]) > 25) {
										echo "<td style=\"background-color : ".$color.";\"><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1003\" style=\"color:black\">".substr($row["nombre"],0,25)." ...</a></td>";
									} else {
										echo "<td style=\"background-color : ".$color.";\"><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1003\" style=\"color:black\">".$row["nombre"]."</a></td>";
									}
									if ($rowtipos["v_subtipos"] == 1) {
										echo "<td style=\"background-color : ".$color.";\">";
										echo "<select style=\"width:70px\" name=\"subtipo\" disabled>";
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

							echo "<td style=\"background-color : ".$color.";text-align : right;\">".number_format($row["total"],2).$rowdi["simbolo"]."</td>";
							if ($rowdiv["id"] == $rowdi["id"]){
								$totalSensePagar += $row["total"];
							} else {
								$totalSensePagar += $row["total"]*$row["div_canvi"];
							}
							echo "<td style=\"background-color : ".$color.";\"><form method=\"post\" action=\"index.php?op=1003&sop=22&id=".$row["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"Editar\" style=\"width:50px\"></form></td>";
							if ($rowtipos["tpv"] == 0) {
								echo "<form method=\"post\" action=\"index.php?op=1003&sop=12&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
									echo "<td style=\"background-color : ".$color.";\"><input type=\"Submit\" value=\"Imp.\" style=\"width:50px\"></td>";
								echo "</form>";
							}
							if ($rowtipos["tpv"] == 1) {
								echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-tiquet-print.php?id=".$row["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
									echo "<td style=\"background-color : ".$color.";\"><input type=\"Submit\" value=\"Imp.\" style=\"width:50px\"></td>";
								echo "</form>";
							}
#							echo "<td style=\"background-color : ".$color.";\"><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
							if ($rowtipos["v_recibos"] == 1)  {
								echo "<td style=\"background-color:".$color.";width:50px;text-align:right;\">";
									echo "<form method=\"post\" action=\"index.php?op=1003&sop=200&id=".$row["id"]."\"><input type=\"Submit\" value=\"".$Recibos."\" style=\"width:50px\"></form>";
								echo "</td>";
									$sqlr = "select SUM(total) as total from sgm_recibos where visible=1 and id_factura=".$row["id"]." order by numero desc, numero_serie desc";
									$resultr = mysql_query(convert_sql($sqlr));
									$rowr = mysql_fetch_array($resultr);
									echo "<td style=\"background-color:".$color.";width:400px;text-align:right;\">".number_format(($row["total"]-$rowr["total"]),2).$rowdi["simbolo"]."</td>";
							}
							echo "<td style=\"background-color:".$color.";width:50px;text-align:right;\">";
								echo "<form method=\"post\" action=\"index.php?op=1003&sop=11&id=".$row["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"".$Cerrar."\" style=\"width:50px\"></form>";
							echo "</td>";
							if (($_POST["todo"] > 0) and ($row["id"] == $_POST["id"])) {
								echo "<form method=\"post\" action=\"index.php?op=1003&sop=10&filtra=1&id=".$_GET["id"]."\">";
									echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
									echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
									echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
									echo "<input type=\"Hidden\" name=\"data_desde2\" value=\"".$_POST["data_desde2"]."\">";
									echo "<input type=\"Hidden\" name=\"data_fins2\" value=\"".$_POST["data_fins2"]."\">";
									echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
									echo "<td style=\"background-color : ".$color.";\"><input type=\"Submit\" value=\"Plegar\" style=\"width:50px\"></td>";
								echo "</form>";
							} else {
								echo "<form method=\"post\" action=\"index.php?op=1003&sop=10&filtra=1&id=".$_GET["id"]."\">";
									echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
									echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
									echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
									echo "<input type=\"Hidden\" name=\"data_desde2\" value=\"".$_POST["data_desde2"]."\">";
									echo "<input type=\"Hidden\" name=\"data_fins2\" value=\"".$_POST["data_fins2"]."\">";
									echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
									echo "<input type=\"Hidden\" name=\"todo\" value=\"2\">";
									echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
									echo "<td style=\"background-color : ".$color.";\"><input type=\"Submit\" value=\"Despl.\" style=\"width:50px\"></td>";
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
								echo "<td>PVD</td>";
								echo "<td>PVP</td>";
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
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><strong>".$Total."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".number_format($totalSensePagar,2).$rowdiv["simbolo"]."</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 11) {
		echo "<center>";
		echo "¿Seguro que desea cerrar este documento?";
		echo "<br><br><a href=\"index.php?op=1003&sop=10&ssop=8&id=".$_GET["id_tipo"]."&id_fact".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=10&id=".$_GET["id_tipo"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 12) {
		echo "<strong>".$Impresion." ".$Documentos."</strong>";
			echo "<center><table cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td>".$Tipo."</td>";
					echo "<td>".$Idioma."</td>";
					echo "<td></td>";
				echo "</tr><tr>";
					echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-print-pdf.php?id=".$_GET["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
					echo "<td><select name=\"tipo\" style=\"width:70px\">";
						echo "<option value=\"0\">".$Sobre."</option>";
						echo "<option value=\"1\">No ".$Sobre."</option>";
					echo "</select></td>";
					echo "<td><select name=\"idioma\" style=\"width:90px\">";
						echo "<option value=\"0\">-</option>";
						$sqli = "select * from sgm_idiomas where visible=1";
						$resulti = mysql_query(convert_sql($sqli));
						while ($rowi = mysql_fetch_array($resulti)) {
							if ($rowi["predefinido"] == 1) {
								echo "<option value=\"".$rowi["idioma"]."\" selected>".$rowi["descripcion"]."</option>";
							} else {
								echo "<option value=\"".$rowi["idioma"]."\">".$rowi["descripcion"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Imprimir." (".$_GET["print"].")\" style=\"width:100px\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table></center>";
			echo "<center><table cellspacing=\"0\">";
				echo "</tr><tr>";
					echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-print-e.php?id=".$_GET["id"]."\" target=\"_blank\">";
					echo "<td></td>";
					echo "<td><select name=\"idioma\" style=\"width:90px\">";
						echo "<option value=\"0\">-</option>";
						$sqli = "select * from sgm_idiomas where visible=1";
						$resulti = mysql_query(convert_sql($sqli));
						while ($rowi = mysql_fetch_array($resulti)) {
							if ($rowi["predefinido"] == 1) {
								echo "<option value=\"".$rowi["idioma"]."\" selected>".$rowi["descripcion"]."</option>";
							} else {
								echo "<option value=\"".$rowi["idioma"]."\">".$rowi["descripcion"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Imprimir." (e)\" style=\"width:100px\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table></center>";
	}

	if ($soption == 20) {
		echo "<strong>".$Usuarios." ".$Modificadores." :</strong><br><br>";
		echo boton_volver($Volver);
		echo "<center><table cellspacing=\"0\" style=\"width:300px;\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Usuario."</td>";
				echo "<td>".$Fecha."</td>";
				echo "<td>".$Hora."</td>";
			echo "</tr>";
			$sql = "select * from sgm_factura_modificacio where id_factura=".$_GET["id"]." order by data";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlu = "select * from sgm_users where id=".$row["id_usuario"];
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
				echo "<tr>";
					echo "<td>".$rowu["usuario"]."</td>";
					echo "<td>".$row["data"]."</td>";
					echo "<td>".$row["hora"]."</td>";
				echo "</tr>";
			}
		echo "</table></center><br>";
	}

	if ($soption == 22) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_clients where id=".$_POST["cliente"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$sql = "update sgm_cabezera set ";
			$sql = $sql."nombre='".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."'";
			$sql = $sql.",nif='".$row["nif"]."'";
			$sql = $sql.",direccion='".$row["direccion"]."'";
			$sql = $sql.",poblacion='".$row["poblacion"]."'";
			$sql = $sql.",cp='".$row["cp"]."'";
			$sql = $sql.",provincia='".$row["provincia"]."'";
			$sql = $sql.",mail='".$row["mail"]."'";
			$sql = $sql.",telefono='".$row["telefono"]."'";
			$sql = $sql.",id_cliente=".$row["id"]."";
			$sql = $sql.",cnombre=''";
			$sql = $sql.",cmail=''";
			$sql = $sql.",ctelefono=''";
			if ($row["id_direccion_envio"] == 0) {
				$sql = $sql.",edireccion='".$row["direccion"]."'";
				$sql = $sql.",epoblacion='".$row["poblacion"]."'";
				$sql = $sql.",ecp='".$row["cp"]."'";
				$sql = $sql.",eprovincia='".$row["provincia"]."'";
			}
			if ($row["id_direccion_envio"] <> 0) {
				$sql3 = "select * from sgm_clients_envios where id=".$row["id_direccion_envio"];
				$result3 = mysql_query(convert_sql($sql3));
				$row3 = mysql_fetch_array($result3);
				$sql = $sql.",edireccion='".$row3["direccion"]."'";
				$sql = $sql.",epoblacion='".$row3["poblacion"]."'";
				$sql = $sql.",ecp='".$row3["cp"]."'";
				$sql = $sql.",eprovincia='".$row3["provincia"]."'";
			}
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 2) {
			$sqlc = "select * from sgm_clients_contactos where id=".$_POST["id_contacto"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$sql = "update sgm_cabezera set ";
			$sql = $sql."cnombre='".$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"]."'";
			$sql = $sql.",ctelefono='".$rowc["telefono"]."'";
			$sql = $sql.",cmail='".$rowc["mail"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 3) {
			$sql = "select * from sgm_clients where id=".$_GET["id_cliente"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$sql = "update sgm_cabezera set ";
			if ($_POST["id_direccion_envio"] == 0) {
				$sql = $sql."edireccion='".$row["direccion"]."'";
				$sql = $sql.",epoblacion='".$row["poblacion"]."'";
				$sql = $sql.",ecp='".$row["cp"]."'";
				$sql = $sql.",eprovincia='".$row["provincia"]."'";
			}
			if ($_POST["id_direccion_envio"] <> 0) {
				$sql3 = "select * from sgm_clients_envios where id=".$_POST["id_direccion_envio"];
				$result3 = mysql_query(convert_sql($sql3));
				$row3 = mysql_fetch_array($result3);
				$sql = $sql."edireccion='".$row3["direccion"]."'";
				$sql = $sql.",epoblacion='".$row3["poblacion"]."'";
				$sql = $sql.",ecp='".$row3["cp"]."'";
				$sql = $sql.",eprovincia='".$row3["provincia"]."'";
			}
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 4) {
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "select * from sgm_cabezera where id=".$_GET["id"];
			$resultf = mysql_query(convert_sql($sqlf));
			$rowf = mysql_fetch_array($resultf);
			if ($rowf["fecha_prevision"] != cambiarFormatoFechaDMY($_POST["fecha_prevision"])){
				$sqlf = "insert into sgm_factura_canvi_data_prevision (id_factura,id_usuario,fecha_ant,data) ";
				$sqlf = $sqlf."values (";
				$sqlf = $sqlf."".$_GET["id"]."";
				$sqlf = $sqlf.",".$userid;
				$sqlf = $sqlf.",'".cambiarFormatoFechaDMY($rowf["fecha_prevision"])."'";
				$sqlf = $sqlf.",'".$fecha."'";
				$sqlf = $sqlf.")";
				mysql_query(convert_sql($sqlf));
			}
			if ($rowf["fecha_entrega"] != cambiarFormatoFechaDMY($_POST["fecha_entrega"])){
				$sqlf = "insert into sgm_factura_canvi_data_entrega (id_factura,id_usuario,fecha_ant,data) ";
				$sqlf = $sqlf."values (";
				$sqlf = $sqlf."".$_GET["id"]."";
				$sqlf = $sqlf.",".$userid;
				$sqlf = $sqlf.",'".cambiarFormatoFechaDMY($rowf["fecha_entrega"])."'";
				$sqlf = $sqlf.",'".$fecha."'";
				$sqlf = $sqlf.")";
				mysql_query(convert_sql($sqlf));
			}
			$fechaf = cambiarFormatoFechaDMY($_POST["fecha"]);
			$fecha_prevf = cambiarFormatoFechaDMY($_POST["fecha_prevision"]);
			$fecha_entf = cambiarFormatoFechaDMY($_POST["fecha_entrega"]);
			$fecha_venf = cambiarFormatoFechaDMY($_POST["fecha_vencimiento"]);
			updateCabezera($rowf["id"],$_POST["numero"],$rowf["tipo"],0,$_POST["version"],$_POST["numero_rfq"],$_POST["numero_cliente"],$fechaf,$fecha_prevf,$fecha_entf,$fecha_venf,$_POST["id_client"],0,0,$_POST["nombre"],$_POST["cnombre"],$_POST["cmail"],$_POST["ctelf"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["mail"],$_POST["telefono"],$_POST["edireccion"],$_POST["epoblacion"],$_POST["ecp"],$_POST["eprovincia"],$_POST["notas"],$_POST["imp_exp"],$_POST["id_divisa"],$_POST["div_canvi"],$_POST["id_pagador"],$_POST["id_user"],$_POST["id_dades_origen_factura_iban"]);
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 5) {
			if ((($_POST["nombre"] == "") and ($_POST["codigo"] != "")) or ($_POST["buscar"] == 1)) {
				$sql = "select * from sgm_articles where codigo='".$_POST["codigo"]."' or codigo2='".$_POST["codigo"]."'";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
		#### INSERTA DATOS EN EL CUERPO
				$sql = "insert into sgm_cuerpo (idfactura,linea,codigo,nombre,pvd,pvp,unidades,total,fecha_prevision,id_article,stock,fecha_prevision_propia) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id"];
				$sql = $sql.",".$_POST["linea"];
				if ($row["codigo"] == $_POST["codigo"]) { $sql = $sql.",'".$row["codigo"]."'"; } 
				if ($row["codigo2"] == $_POST["codigo"]) { $sql = $sql.",'".$row["codigo2"]."'"; } 
				$sql = $sql.",'".$row["nombre"]."'";
				$sql = $sql.",".$row["precio"];
				$sql = $sql.",".$row["precio"];
				$sql = $sql.",".$_POST["unidades"];
				$total = $_POST["unidades"] * $row["precio"];
				$sql = $sql.",".$total;
				$sql = $sql.",'".cambiarFormatoFechaDMY($_POST["fecha_prevision"])."'";
				$sql = $sql.",".$row["id"];
				$sql = $sql.",1";
				$sql = $sql.",'".cambiarFormatoFechaDMY($_POST["fecha_prevision"])."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
#				echo $sql;
			} else {
				$sql = "insert into sgm_cuerpo (idfactura,linea,codigo,nombre,pvd,pvp,unidades,total,fecha_prevision,id_article,stock,fecha_prevision_propia) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id"];
				$sql = $sql.",".$_POST["linea"];
				$sql = $sql.",'".$_POST["codigo"]."'";
				$sql = $sql.",'".comillas($_POST["nombre"])."'";
				$sql = $sql.",".$_POST["pvd"];
				$sql = $sql.",".$_POST["pvp"];
				$sql = $sql.",".$_POST["unidades"];
				$total = $_POST["unidades"] * $_POST["pvp"];
				$sql = $sql.",".$total;
				$sql = $sql.",'".cambiarFormatoFechaDMY($_POST["fecha_prevision"])."'";
				$sql = $sql.",0";
				$sql = $sql.",1";
				$sql = $sql.",'".cambiarFormatoFechaDMY($_POST["fecha_prevision"])."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
			refactura($_GET["id"]);
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 6) {
			$sql = "delete from sgm_cuerpo WHERE id=".$_GET["id_cuerpo"];
			mysql_query(convert_sql($sql));
			refactura($_GET["idfactura"]);
			$num = 1;
			$sqll = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
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

			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 9) {
			$x=1;
			$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				if ($row["fecha_prevision"] != $_POST["fecha_prevision".$x.""]){
					$date = getdate();
					$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
					$sqlf = "insert into sgm_factura_canvi_data_prevision_cuerpo (id_factura,id_usuario,fecha_ant,data,id_cuerpo) ";
					$sqlf = $sqlf."values (";
					$sqlf = $sqlf."".$_GET["id"]."";
					$sqlf = $sqlf.",".$userid;
					$sqlf = $sqlf.",'".cambiarFormatoFechaDMY($row["fecha_prevision"])."'";
					$sqlf = $sqlf.",'".$fecha."'";
					$sqlf = $sqlf.",".$row["id"];
					$sqlf = $sqlf.")";
					mysql_query(convert_sql($sqlf));
				}
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."codigo='".$_POST["codigo".$x.""]."'";
				$sql = $sql.",nombre='".comillas($_POST["nombre".$x.""])."'";
				if ($_POST["pvd".$x.""] == ""){
					$sql = $sql.",pvd=0";
				} else {
					$pvd = ereg_replace(",","", $_POST["pvd".$x.""] );
					$sql = $sql.",pvd=".$pvd;
				}
				$pvp = ereg_replace(",","", $_POST["pvp".$x.""] );
				$sql = $sql.",pvp=".$pvp;
				$sql = $sql.",linea=".$_POST["linea".$x.""];
				$sql = $sql.",unidades=".$_POST["unidades".$x.""];
				if ( (($_POST["descuento".$x.""] != "") OR ($_POST["descuento".$x.""] != 0)) AND (($_POST["descuento_absoluto".$x.""] != "") OR ($_POST["descuento_absoluto".$x.""] != 0)) )  {
					if  ($_POST["descuento_absoluto".$x.""] == 0) {
						$total = ($_POST["pvp".$x.""]-($_POST["pvp".$x.""]/100)*$_POST["descuento".$x.""])*$_POST["unidades".$x.""];
						$sql = $sql.",descuento=".$_POST["descuento".$x.""];
						$sql = $sql.",descuento_absoluto=0";
					} else {
						$total = ($_POST["pvp".$x.""]- $_POST["descuento_absoluto".$x.""] )* $_POST["unidades".$x.""];
						$sql = $sql.",descuento=0";
						$sql = $sql.",descuento_absoluto=".$_POST["descuento_absoluto".$x.""];
					}
				} else {
					$total = $_POST["unidades".$x.""] * $_POST["pvp".$x.""];
				}
				$sql = $sql.",total=".$total;
				$sql = $sql.",fecha_prevision='".cambiarFormatoFechaDMY($_POST["fecha_prevision".$x.""])."'";
				$sql = $sql." WHERE id=".$_POST["id".$x.""]."";
				mysql_query(convert_sql($sql));
				$x++;
			}
			refactura($_GET["id"]);
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		$cambio_pago = false;
		if ($ssoption == 10) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."id_tipo_pago=".$_POST["id_tipo_pago"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$cambio_pago = true;
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$_GET["id"]."";
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".$fecha."'";
			$sqlf = $sqlf.",'".$hora."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 11) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."suma=1";
			$sql = $sql." WHERE id=".$_GET["id_linea"]."";
			mysql_query(convert_sql($sql));
			refactura($_GET["id"]);
		}
		if ($ssoption == 12) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."suma=0";
			$sql = $sql." WHERE id=".$_GET["id_linea"]."";
			mysql_query(convert_sql($sql));
			refactura($_GET["id"]);
		}
		if ($ssoption == 13) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."aprovat=1";
			$sql = $sql." WHERE id=".$_GET["id_linea"]."";
			mysql_query(convert_sql($sql));
			conta_aprovats($_GET["id_linea"],$_GET["id"]);
		}
		refactura($_GET["id"]);
		if ($fu == ""){
			echo "<table><tr>";
				echo "<td style=\"width:200px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=20&id=".$_GET["id"]."\" style=\"color:white;\">".$Usuarios." ".$Modificadores."</a>";
				echo "</td>";
			echo "</tr></table>";
			$sql = "select * from sgm_cabezera where id=".$_GET["id"]." ORDER BY id";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$sqlf = "select * from sgm_factura_tipos where id=".$row["tipo"];
			$resultf = mysql_query(convert_sql($sqlf));
			$rowf = mysql_fetch_array($resultf);
			echo "<center>";
			if ($rowf["tpv"] == 1) {
				if ($row["id_tipo_pago"] == 0) { echo "<center><table><tr><td style=\"background-color:#FF6347;width:500px;vertical-align:middle;height:50px;text-align:center\">"; }
				if ($row["id_tipo_pago"] <> 0) { echo "<center><table><tr><td style=\"background-color:#32CD32;width:500px;vertical-align:middle;height:50px;text-align:center\">"; }
				echo "<form action=\"index.php?op=1003&sop=22&ssop=10&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
				echo "<select name=\"id_tipo_pago\" style=\"width:150px;\">";
				echo "<option value=\"0\">-</option>";
				$sql1 = "select * from sgm_tpv_tipos_pago order by id";
				$result1 = mysql_query(convert_sql($sql1));
				while ($row1 = mysql_fetch_array($result1)) {
					if ($row["id_tipo_pago"] == $row1["id"]) {
						echo "<option value=\"".$row1["id"]."\" selected>".$row1["tipo"]."</option>";
					} else {
						echo "<option value=\"".$row1["id"]."\">".$row1["tipo"]."</option>";
					}
				}
				echo "</select>";
				if ($cambio_pago == true) { 
					echo "<input type=\"hidden\" value=\"1\" name=\"cambio2\">";
				} else {
					echo "<input type=\"hidden\" value=\"0\" name=\"cambio2\">";
				}
				echo "<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:150px\">";
				echo "</form>";
				if (($cambio_pago == true) and ($_POST["cambio2"] == 0)) { echo "Forma de pago cambiada correctamente."; }
				if (($cambio_pago == true) and ($_POST["cambio2"] == 1)) { echo "Ha realizado otro cambio en la forma de pago."; }
				
				echo "</td></tr></table></center>";
			}
			if ($rowf["tpv"] == 0) {
				echo "<table><tr><td>";
					echo "<table>";
					echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=22&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td>";
					echo "<select name=\"cliente\" style=\"width:200px\">";
					echo "<option value=\"0\">-</option>";
					$sqltipos = "select * from sgm_factura_tipos where (id=".$row["tipo"].") order by id";
					$resulttipos = mysql_query(convert_sql($sqltipos));
					$rowtipos = mysql_fetch_array($resulttipos);
					$sqlx = "select * from sgm_clients where visible=1 order by nombre";
					$resultx = mysql_query(convert_sql($sqlx));
					while ($rowx = mysql_fetch_array($resultx)) {
						echo "<option value=\"".$rowx["id"]."\">".$rowx["nombre"]." ".$rowx["cognom1"]." ".$rowx["cognom2"]."</option>";
					}
					echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Submit\" value=\"".$Cambio." ".$Cliente."\" style=\"width:110px\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1003&sop=22&ssop=2&id=".$_GET["id"]."&id_cliente=".$row["id_cliente"]."\" method=\"post\">";
					echo "<td><select name=\"id_contacto\" style=\"width:200px\">";
					echo "<option value=\"0\">-</option>";
					$sqlcc = "select * from sgm_clients_contactos where id_client=".$row["id_cliente"]." order by nombre";
					$resultcc = mysql_query(convert_sql($sqlcc));
					while ($rowcc = mysql_fetch_array($resultcc)) {
						echo "<option value=\"".$rowcc["id"]."\">".$rowcc["nombre"]." ".$rowcc["apellido1"]." ".$rowcc["apellido2"]."</option>";
					}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Cambio." ".$Contacto."\" style=\"width:110px\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1003&sop=22&ssop=3&id=".$_GET["id"]."&id_cliente=".$row["id_cliente"]."\" method=\"post\">";
					echo "<td><select name=\"id_direccion_envio\" style=\"width:200px\">";
					echo "<option value=\"0\">-</option>";
					echo "<option value=\"0\">".$Direccion." ".$Datos_Fiscales."</option>";
					$sql1 = "select * from sgm_clients_envios where id_client=".$row["id_cliente"]." order by nombre";
					$result1 = mysql_query(convert_sql($sql1));
					while ($row1 = mysql_fetch_array($result1)) {
						echo "<option value=\"".$row1["id"]."\">".$row1["nombre"]."(".$row1["direccion"].", ".$row1["poblacion"]." (".$row1["cp"].") ".$row1["provincia"].")</option>";
					}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Cambio." ".$Direccion." ".$Envio."\" style=\"width:135px\"></td>";
					echo "</tr>";
					echo "</form>";
					echo "</table>";
				echo "</td></tr></table>";
				$id_tipo = $row["tipo"];
				echo "<form action=\"index.php?op=1003&sop=22&ssop=4&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
				#echo"<br><br>";
				echo "<table bgcolor=\"#c0c0c0\">";
					echo "<tr>";
						echo "<td>";
							echo "<table>";
								echo "<tr>";
									echo "<td>";
										echo "<table><tr>";
											echo "<td style=\"vertical-align:top;\">";
												echo "<table>";
													echo "<tr><td><strong>".$rowf["tipo"]."</strong></td><td><input type=\"Text\" name=\"numero\" style=\"width:100px\" value=\"".$row["numero"]."\"><strong>&nbsp;/&nbsp;</strong><input type=\"Text\" name=\"version\" style=\"width:25px\" value=\"".$row["version"]."\"></td></tr>";
													if ($rowtipos["presu"] == 1){
														echo "<tr><td>".$Numero." RFQ</td><td><input type=\"Text\" name=\"numero_rfq\" style=\"width:100px\" value=\"".$row["numero_rfq"]."\"></td></tr>";
													} else {
														echo "<tr><td>Ref. Ped. Cli.</td><td><input type=\"Text\" name=\"numero_cliente\" style=\"width:100px\" value=\"".$row["numero_cliente"]."\"></td></tr>";
													}
													echo "<tr><td><strong>".$Fecha."</strong></td><td><input type=\"Text\" name=\"fecha\" style=\"width:100px\" value=\"".cambiarFormatoFechaYMD($row["fecha"])."\"></td></tr>";
													echo "<tr><td><strong>".$Fecha." ".$Prevision."</strong></td><td><input type=\"Text\" name=\"fecha_prevision\"  style=\"width:100px;vertical-align:bottom;\" value=\"".cambiarFormatoFechaYMD($row["fecha_prevision"])."\"><a href=\"index.php?op=1003&sop=60&id=".$_GET["id"]."&classe=1\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td></tr>";
													$color_entrega ="white";
													if ($row["fecha_entrega"] > $row["fecha_prevision"]) { $color_entrega ="#FF4500"; }
													echo "<tr><td><strong>".$Fecha." ".$Entrega."</strong></td><td><input type=\"Text\" name=\"fecha_entrega\" value=\"".cambiarFormatoFechaYMD($row["fecha_entrega"])."\" style=\"width:100px;vertical-align:bottom;background-color: ".$color_entrega.";\"><a href=\"index.php?op=1003&sop=60&id=".$_GET["id"]."&classe=2\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td></tr>";
													echo "<tr><td>".$Fecha." ".$Vencimiento."</td><td><input type=\"Text\" name=\"fecha_vencimiento\" style=\"width:100px\" value=\"".cambiarFormatoFechaYMD($row["fecha_vencimiento"])."\"></td></tr>";
													echo "<tr><td>".$Contacto."</td><td><input type=\"Text\" name=\"cnombre\" style=\"width:200px\" value=\"".$row["cnombre"]."\"></td></tr>";
													echo "<tr><td>".$Email."</td><td><input type=\"Text\" name=\"cmail\" style=\"width:200px\" value=\"".$row["cmail"]."\"></td></tr>";
													echo "<tr><td>".$Telefono."</td><td><input type=\"Text\" name=\"ctelf\" style=\"width:200px\" value=\"".$row["ctelefono"]."\"></td></tr>";
												echo "</table>";
											echo "</td>";
											echo "<td style=\"vertical-align:top;\">";
											echo "<table>";
												echo "<tr><td>".$Nombre."</td><td><input type=\"Text\" name=\"nombre\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td></tr>";
												echo "<tr><td>NIF</td><td><input type=\"Text\" name=\"nif\" style=\"width:250px\" value=\"".$row["nif"]."\"></td></tr>";
												echo "<tr><td>".$Direccion."</td><td><input type=\"Text\" name=\"direccion\" style=\"width:250px\" value=\"".$row["direccion"]."\"></td></tr>";
												echo "<tr><td>".$Poblacion."</td><td><input type=\"Text\" name=\"poblacion\" style=\"width:250px\" value=\"".$row["poblacion"]."\"></td></tr>";
												echo "<tr><td>".$Codigo." ".$Postal."</td><td><input type=\"Text\" name=\"cp\" style=\"width:250px\" value=\"".$row["cp"]."\"></td></tr>";
												echo "<tr><td>".$Provincia."</td><td><input type=\"Text\" name=\"provincia\" style=\"width:250px\" value=\"".$row["provincia"]."\"></td></tr>";
												echo "<tr><td>".$Pais."</td><td><select name=\"id_pais\" style=\"width:250px\">";
												$sqlp = "select * from sgm_paises where visible=1 order by pais";
												$resultp = mysql_query(convert_sql($sqlp));
												while ($rowp = mysql_fetch_array($resultp)){
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
												echo "<tr><td>".$Email."</td><td><input type=\"Text\" name=\"mail\" style=\"width:250px\" value=\"".$row["mail"]."\"></td></tr>";
												echo "<tr><td>".$Telefono."</td><td><input type=\"Text\" name=\"telefono\" style=\"width:250px\" value=\"".$row["telefono"]."\"></td></tr>";
											echo "</table>";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
								echo "<table>";
									echo "<tr>";
										echo "<td style=\"width:100px;\">".$Notas."</td>";
										echo "<td style=\"text-align:right;\"><textarea name=\"notas\" style=\"width:535px\" rows=\"2\">".$row["notas"]."</textarea></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
							echo "<td style=\"vertical-align:top;\">";
								echo "<strong>Dirección de envio</strong><br>";
								echo "<table>";
									echo "<tr><td>".$Direccion."</td><td><input type=\"Text\" name=\"edireccion\" class=\"px250\" value=\"".$row["edireccion"]."\"></td></tr>";
									echo "<tr><td>".$Poblacion."</td><td><input type=\"Text\" name=\"epoblacion\" class=\"px250\" value=\"".$row["epoblacion"]."\"></td></tr>";
									echo "<tr><td>".$Codigo." ".$Postal."</td><td><input type=\"Text\" name=\"ecp\" class=\"px250\" value=\"".$row["ecp"]."\"></td></tr>";
									echo "<tr><td>".$Provincia."</td><td><input type=\"Text\" name=\"eprovincia\" class=\"px250\" value=\"".$row["eprovincia"]."\"></td></tr>";
								echo "</table>";
								echo "<strong>".$Datos." ".$Origen." ".$Factura."</strong><br>";
								echo "<table>";
								$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$rowf["id"]." and id_user=".$userid;
								$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
								$rowpermiso2 = mysql_fetch_array($resultpermiso2);
									echo "<tr>";
										echo "<td>IBAN</td>";
										echo "<td>";
											if ($rowpermiso2["admin"] == 0){
												echo "<select name=\"id_dades_origen_factura_iban\" class=\"px250\" disabled>";
											} else {
												echo "<select name=\"id_dades_origen_factura_iban\" class=\"px250\">";
											}
											$seleccionar = 0;
											$sql1 = "select * from sgm_dades_origen_factura_iban";
											$result1 = mysql_query(convert_sql($sql1));
											while ($row1 = mysql_fetch_array($result1)) {
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
										echo "<td>Ref. ".$Cliente."</td>";
										echo "<td>";
											if ($rowpermiso2["admin"] == 0){
												echo "<select name=\"id_client\" class=\"px250\" disabled>";
											} else {
												echo "<select name=\"id_client\" class=\"px250\">";
											}
											echo "<option value=\"0\">-</option>";
											$sql1 = "select * from sgm_clients where visible=1 order by nombre";
											$result1 = mysql_query(convert_sql($sql1));
											while ($row1 = mysql_fetch_array($result1)) {
												if ($row["id_cliente"] == $row1["id"]) {
													echo "<option value=\"".$row1["id"]."\" selected>".$row1["nombre"]."</option>";
												} else {
													echo "<option value=\"".$row1["id"]."\">".$row1["nombre"]."</option>";
												}
											}
											echo "</select>";
										echo "</td>";
									echo "</tr><tr>";
										echo "<td>Ref. ".$Usuario."</td>";
										echo "<td>";
											if ($rowpermiso2["admin"] == 0){
												echo "<select name=\"id_user\" class=\"px250\" disabled>";
											} else {
												echo "<select name=\"id_user\" class=\"px250\">";
											}
											echo "<option value=\"0\">-</option>";
											$sql1 = "select * from sgm_users where sgm=1 order by usuario";
											$result1 = mysql_query(convert_sql($sql1));
											while ($row1 = mysql_fetch_array($result1)) {
												if ($row["id_user"] == $row1["id"]) {
													echo "<option value=\"".$row1["id"]."\" selected>".$row1["usuario"]."</option>";
												} else {
													echo "<option value=\"".$row1["id"]."\">".$row1["usuario"]."</option>";
												}
											}
											echo "</select>";
										echo "</td>";
									echo "</tr><tr>";
										echo "<td>".$Usuario." ".$Gasto."</td>";
										echo "<td>";
											if ($rowpermiso2["admin"] == 0){
												echo "<select name=\"id_pagador\" class=\"px250\" disabled>";
											} else {
												echo "<select name=\"id_pagador\" class=\"px250\">";
											}
											echo "<option value=\"0\">-</option>";
											$sql1 = "select * from sgm_users where sgm=1 order by usuario";
											$result1 = mysql_query(convert_sql($sql1));
											while ($row1 = mysql_fetch_array($result1)) {
												if ($row["id_pagador"] == $row1["id"]) {
													echo "<option value=\"".$row1["id"]."\" selected>".$row1["usuario"]."</option>";
												} else {
													echo "<option value=\"".$row1["id"]."\">".$row1["usuario"]."</option>";
												}
											}
											echo "</select>";
										echo "</td>";
									echo "</tr><tr>";
										echo "<td>Impo./Expo.</td>";
										echo "<td>";
											if ($row["imp_exp"] == 0 ){
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"0\" checked style=\"border:0px\">NO";
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"1\" style=\"border:0px\">SI";
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"2\" style=\"border:0px\">UE";
											}
											if ($row["imp_exp"] == 1 ){
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"0\" style=\"border:0px\">NO";
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"1\" checked style=\"border:0px\">SI";
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"2\" style=\"border:0px\">UE";
											}
											if ($row["imp_exp"] == 2 ){
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"0\" style=\"border:0px\">NO";
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"1\" style=\"border:0px\">SI";
												echo "<input type=\"Radio\" name=\"imp_exp\" value=\"2\" checked style=\"border:0px\">UE";
											}
										echo "</td>";
									echo "</tr><tr>";
										echo "<td></td>";
										echo "<td>";
											echo "<table>";
												echo "<tr>";
													echo "<td>".$Divisa."</td>";
													echo "<td>".$Cambio."</td>";
												echo "</tr>";
												echo "<tr><td><select name=\"id_divisa\" style=\"width:150px;\">";
													echo "<option value=\"0\">-</option>";
													$sql1 = "select * from sgm_divisas where visible=1";
													$result1 = mysql_query(convert_sql($sql1));
													while ($row1 = mysql_fetch_array($result1)) {
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
													echo "<td><input type=\"Text\" name=\"div_canvi\" value=\"".$row["div_canvi"]."\" style=\"width:94px;\"></td>";
												echo "</tr>";
											echo "</table>";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<tr><td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:350px\"></td></tr>";
				echo "</table>";
				echo "</form>";
			}
			$sql2 = "select * from sgm_divisas where visible=1 and id=".$row["id_divisa"];
			$result2 = mysql_query(convert_sql($sql2));
			$row2 = mysql_fetch_array($result2);
			echo "<br>";
			echo "<table cellspacing=\"0\">";
				echo "<tr><td></td><td></td><td><em>".$Fecha." ".$Prevision."</em></td><td><em>".$Codigo."</em></td><td><center><em>".$Unidades."</em></center></td>";
					echo "<td><center><em>Desc.%</em></center></td><td><center><em>Desc.".$row2["abrev"]."</em></center></td></tr>";
				echo "<tr style=\"background-color:silver;\">";
					echo "<form action=\"index.php?op=1003&sop=22&ssop=5&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"buscar\" value=\"1\">";
					echo "<td></td>";
					$sqlxx = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea desc";
					$resultxx = mysql_query(convert_sql($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
					$linea = $rowxx["linea"] +1;
					echo "<td><input type=\"Text\" name=\"linea\" style=\"width:20px\" value=\"".$linea."\"></td>";
					echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:80px\" value=\"".cambiarFormatoFechaYMD($row["fecha_prevision"])."\"></td>";
					echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\"></td>";
					echo "<td><input type=\"Text\" name=\"unidades\" style=\"width:50px\" value=\"0.000\"></td>";
					echo "<td><input type=\"Text\" name=\"descuento\" style=\"width:40px\" value=\"0.000\"></td>";
					echo "<td><input type=\"Text\" name=\"descuento_absoluto\" style=\"width:40px\" value=\"0.000\"></td>";
					echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:70px\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			echo "<table cellspacing=\"0\">";
				echo "<tr><td></td><td></td><td><em>".$Fecha." ".$Prevision."</em></td><td><em>".$Codigo."</em></td><td><em>".$Nombre."</em></td><td><center><em>".$Unidades."</em></center></td>";
					echo "<td></td><td><center><em>PVD</em></center></td>";
					echo "<td><center><em>PVP</em></center></td><td><center><em>Desc.%</em></center></td><td><center><em>Desc.".$row2["abrev"]."</em></center></td><td></td></tr>";
					echo "<tr style=\"background-color:silver;\">";
						echo "<form action=\"index.php?op=1003&sop=22&ssop=5&id=".$_GET["id"]."\" method=\"post\">";
						echo "<td></td>";
						$sqlxx = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea desc";
						$resultxx = mysql_query(convert_sql($sqlxx));
						$rowxx = mysql_fetch_array($resultxx);
						$linea = $rowxx["linea"] +1;
						echo "<td><input type=\"Text\" name=\"linea\" style=\"width:20px\" value=\"".$linea."\"></td>";
						echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:90px\" value=\"".cambiarFormatoFechaYMD($row["fecha_prevision"])."\"></td>";
						echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\"></td>";
						echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:250px\"></td>";
						echo "<td><input type=\"Text\" name=\"unidades\" style=\"width:50px\" value=\"0.000\"></td>";
						echo "<td></td><td><input type=\"Text\" name=\"pvd\" style=\"width:60px\" value=\"0.000\"></td>";
						echo "<td><input type=\"Text\" name=\"pvp\" style=\"width:60px\" value=\"0.000\"></td>";
						echo "<td><input type=\"Text\" name=\"descuento\" style=\"width:40px\" value=\"0.000\"></td>";
						echo "<td><input type=\"Text\" name=\"descuento_absoluto\" style=\"width:40px\" value=\"0.000\"></td>";
						echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:70px\"></td>";
						echo "</form>";
					echo "</tr>";
					echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style=\"text-align:center;\"><em>Total</em></td></tr>";
					$x=1;
					echo "<form action=\"index.php?op=1003&sop=22&ssop=9&id=".$_GET["id"]."\" method=\"post\">";
					echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td><td></td><td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:70px\"></td></tr>";
			$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($id_tipo == 5) {
					if ($row["facturado"] == 1) {
						$color = "blue";
					} else {
						$date = getdate();
						$hoy = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
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
					echo "<td style=\"width:50px;height:5px;text-align:center;vertical-align:middle;background-color:#C0C0C0;border:1px solid black\">";
						echo "<a href=\"index.php?op=1003&sop=24&idfactura=".$_GET["id"]."&id=".$row["id"]."\" style=\"color:black;\">".$Opciones."</a>";
					echo "</td>";
					echo "<input type=\"hidden\" name=\"id".$x."\" value=\"".$row["id"]."\">";
					echo "<td><input type=\"Text\" name=\"linea".$x."\" style=\"width:20px\" value=\"".$row["linea"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"fecha_prevision".$x."\" style=\"width:90px\" value=\"".cambiarFormatoFechaYMD($row["fecha_prevision"])."\"><a href=\"index.php?op=1003&sop=60&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."&classe=3\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td>";
					echo "<input type=\"Hidden\" name=\"x\" value=\"".$x."\">";
					echo "<input type=\"Hidden\" name=\"cuerpo\" value=\"".$row["id"]."\">";
					echo "<td><input type=\"Text\" name=\"codigo".$x."\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"nombre".$x."\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"unidades".$x."\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\"></td>";
					if (($rowtipos["presu"] == 1) or ($rowtipos["tipo_ot"] == 1)) {
						echo "<td><a href=\"index.php?op=1003&sop=22&fu=3&tipo=1&id=".$row["id"]."&id_factura=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/calculator_edit.png\" style=\"border:0px;\"></a></td>";
					} else {
						echo "<td></td>";
					}
					if ($row["pvd"] == 0){
						$sqla = "select * from sgm_articles_costos where visible=1 and id_cuerpo=".$row["id"]." and aprovat=1";
						$resulta = mysql_query(convert_sql($sqla));
						$rowa = mysql_fetch_array($resulta);
						echo "<td><input type=\"Text\" name=\"pvd".$x."\" style=\"text-align:right;width:60px;background-color:white;color:silver\" value=\"".number_format ($rowa["preu_cost"],3)."\"></td>";
					} else {
						echo "<td><input type=\"Text\" name=\"pvd".$x."\" style=\"text-align:right;width:60px;background-color:white;color:silver\" value=\"".number_format ($row["pvd"],3)."\"></td>";
					}
					echo "<td><input type=\"Text\" name=\"pvp".$x."\" style=\"text-align:right;width:60px\" value=\"".number_format ($row["pvp"],3,".","")."\"></td>";
					echo "<td><input type=\"Text\" name=\"descuento".$x."\" style=\"text-align:right;width:40px\" value=\"".number_format ($row["descuento"],3)."\"></td>";
					echo "<td><input type=\"Text\" name=\"descuento_absoluto".$x."\" style=\"text-align:right;width:40px\" value=\"".number_format ($row["descuento_absoluto"],3)."\"></td>";
					echo "<td style=\"text-align:right;background-color : silver;\"><strong>".$row["total"]."</strong> ".$row2["simbolo"]."</td>";
					if ($rowtipos["presu"] == 1){
						echo "<td style=\"width:50px;height:10px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						if ($row["suma"] == 0){
							echo "<a href=\"index.php?op=1003&sop=22&ssop=11&id=".$_GET["id"]."&id_linea=".$row["id"]."\" style=\"color:white;\">No Sumar</a>";
						} else {
							echo "<a href=\"index.php?op=1003&sop=22&ssop=12&id=".$_GET["id"]."&id_linea=".$row["id"]."\" style=\"color:white;\">Sumar</a>";
						}
						echo "</td>";
					}
					if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["v_subtipos"] == 1)){
						if ($row["aprovat"] == 0){
							echo "<td style=\"width:50px;height:10px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\"><a href=\"index.php?op=1003&sop=22&ssop=13&id=".$_GET["id"]."&id_linea=".$row["id"]."\" style=\"color:white;\">Aprovar</a></td>";
						} else {
							echo "<td></td>";
						}
					}
					echo "<td><a href=\"index.php?op=1003&sop=5&id=".$row["id"]."&id_factura=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_stack.png\" style=\"border:0px;\"></a></td>";
				echo "</tr>";
				$x++;
			}
			echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td><td></td><td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:70px\"></td></tr>";
			echo "</form>";
			$sql = "select * from sgm_cabezera where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<tr><td style=\"text-align:right;\" colspan=\"11\"><em>".$Subtotal."</em></td><td style=\"text-align:right;\">".number_format ($row["subtotal"],3)." ".$row2["simbolo"]."</td><td></td></tr>";
			echo "<form action=\"index.php?op=1003&sop=27&id=".$row["id"]."\" method=\"post\">";
			echo "<tr><td style=\"text-align:right;\" colspan=\"11\"><em>Desc.%</em></td><td><input type=\"Text\" name=\"descuento\" style=\"text-align:right;width:60px\" value=\"".number_format ($row["descuento"],3)."\">%</td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:70px\"></td></tr>";
			echo "</form>";
			echo "<form action=\"index.php?op=1003&sop=27&id=".$row["id"]."\" method=\"post\">";
			echo "<tr><td style=\"text-align:right;\" colspan=\"11\"><em>Desc.".$row2["simbolo"]."</em></td><td><input type=\"Text\" name=\"descuento_absoluto\" style=\"text-align:right;width:60px\" value=\"".number_format ($row["descuento_absoluto"],3)."\"> ".$row2["simbolo"]."</td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:70px\"></td></tr>";
			echo "</form>";
			echo "<form action=\"index.php?op=1003&sop=28&id=".$row["id"]."\" method=\"post\">";
			echo "<tr><td style=\"text-align:right;\" colspan=\"11\"><em>IVA</em></td><td><input type=\"Text\" name=\"iva\" style=\"text-align:right;width:60px\" value=\"".$row["iva"]."\">%</td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:70px\"></td></tr>";
			echo "</form>";
			echo "<form action=\"index.php?op=1003&sop=35&id=".$row["id"]."\" method=\"post\">";
			$color_fondo_total = "white";
			if ($row["total_forzado"] == 1) { $color_fondo_total = "#FF6347"; }
			echo "<tr><td style=\"text-align:right;\" colspan=\"11\"><em>".$Total."</em></td><td><input type=\"Text\" name=\"total\" style=\"text-align:right;width:60px;background-color:".$color_fondo_total."\" value=\"".number_format ($row["total"],3)."\"> ".$row2["simbolo"]."</td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:70px\"></td></tr>";
			echo "</form>";
			echo "</table>";
			echo "<br><br>";
			echo "</center>";
		}
	}

	if ($soption == 24){
		echo "<strong>".$Opciones."</strong><br><br>";
		echo "<center><table style=\"width:900px\" cellspacing=\"10\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;Width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\"><tr>";
						echo "<td style=\"width:400px\"><strong>".$Convertir." a ".$Articulo."</strong></td>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">Convierte la linea del documento en un nuevo articulo. Se traspasará también el calculo de coste, si lo hay.</td>";
					echo "</tr></table>";
					echo "<form action=\"index.php?op=1003&sop=26&id=".$_GET["id"]."&idfactura=".$_GET["idfactura"]."\" method=\"post\">";
					echo "<table><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<input type=\"Submit\" value=\"".$Convertir."\" style=\"background-color:#4B53AF;border:0px;color:white;\">";
						echo "</td>";
					echo "</tr></table></center></form>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\"><tr>";
						echo "<td style=\"width:400px\"><strong>".$Eliminar."</strong></td>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">Se eliminará el articulo en todo el progama. Todos los datos relacionados con él serán inaccesible.</td>";
					echo "</tr></table><table><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:red;border: 1px solid black;\">";
							echo "<a href=\"index.php?op=1003&sop=25&id=".$_GET["id"]."&idfactura=".$_GET["idfactura"]."\" style=\"color:white;\">".$Eliminar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table></center>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 25) {
		echo "<br><br>¿Seguro que desea eliminar esta linea de la factura?";
		echo "<br><br><a href=\"index.php?op=1003&sop=22&ssop=6&id=".$_GET["idfactura"]."&id_cuerpo=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=22&id=".$_GET["idfactura"]."\">[ NO ]</a>";
	}

	if ($soption == 26) {
		$sqlc = "select * from sgm_cuerpo where id=".$_GET["id"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlf = "insert into sgm_articles (nombre,fecha,fecha_ant,data,id_cuerpo) ";
		$sqlf = $sqlf."values (";
		$sqlf = $sqlf."'".$rowc["nombre"]."'";
		$hoy = getdate();
		$fecha = date("Y-m-d", mktime(0,0,0,$hoy["mon"] ,$hoy["mday"]-1000, $hoy["year"]));
		$sqlf = $sqlf.",'".$fecha."'";
		$sqlf = $sqlf.")";
		mysql_query(convert_sql($sqlf));
		$sqla = "select * from sgm_articles order by id desc";
		$resulta = mysql_query(convert_sql($sqla));
		$rowa = mysql_fetch_array($resulta);
		$id = $rowa["id"] + 1;
		$sql = "update sgm_articles_costos set ";
		$sql = $sql."id_article=".$id;
		$sql = $sql.",id_cuerpo=0";
		$sql = $sql." WHERE id_cuerpo=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
	}

	if ($soption == 27) {
		$sql = "update sgm_cabezera set ";
		if ($_POST["descuento"] == "") {
			$sql = $sql."descuento=0";
			$sql = $sql.",descuento_absoluto=".$_POST["descuento_absoluto"];
		}
		if ($_POST["descuento_absoluto"] == "") {
			$sql = $sql."descuento_absoluto=0";
			$sql = $sql.",descuento=".$_POST["descuento"];
		}
		$sql = $sql.",total_forzado=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		refactura($_GET["id"]);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=22&id=".$_GET["id"]."\">[ ".$Volver." ]</a>";
	}

	if ($soption == 28) {
		$sql = "update sgm_cabezera set ";
		$sql = $sql."iva=".$_POST["iva"];
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		refactura($_GET["id"]);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=22&id=".$_GET["id"]."\">[ ".$Volver." ]</a>";
	}

	if ($soption == 35) {
		$sql = "update sgm_cabezera set ";
		$sql = $sql."total=".$_POST["total"];
		$sql = $sql.",total_forzado=1";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		refactura($_GET["id"]);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=22&id=".$_GET["id"]."\">[ ".$Volver." ]</a>";
	}

	if ($soption == 40) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=310\" style=\"color:white;\">".$Datos." ".$Origen."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=400\" style=\"color:white;\">".$Permisos." ".$Usuarios."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=500\" style=\"color:white;\">".$Tipos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=550\" style=\"color:white;\">".$Relaciones."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=300\" style=\"color:white;\">".$Subtipos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=800\" style=\"color:white;\">".$Cajas."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=700\" style=\"color:white;\">".$Divisas."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=450\" style=\"color:white;\">".$Logos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=80\" style=\"color:white;\">".$Fuentes."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 50) {
		$sql = "insert into sgm_facturas_relaciones (id_plantilla,fecha,id_factura) ";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_plantilla"]."";
		$sql = $sql.",'".$_POST["fecha"]."'";
		$sql = $sql.",".$_POST["id_factura"];
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=0\">[ ".$Volver." ]</a>";
	}

	if ($soption == 51) {
		echo "<br><br>Inserta fecha de factura";
		echo "<form action=\"index.php?op=1003&sop=52\" method=\"post\">";
		echo "<input type=\"Hidden\" name=\"id_plantilla\" value=\"".$_POST["id_plantilla"]."\">";
		echo "<input type=\"Hidden\" name=\"fecha\" value=\"".$_POST["fecha"]."\">";
		echo "<input type=\"Text\" name=\"fecha_nueva\" value=\"".$_POST["fecha"]."\">";
		echo "<input type=\"Submit\" value=\"Facturar\" style=\"border:0px;\" ></form>";
		echo "<br><br>";
	}

	if ($soption == 52) {
		$sql = "select * from sgm_cabezera where id=".$_POST["id_plantilla"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		### COPIA CABEZERA PLANTILLA
		$sql = "insert into sgm_cabezera (numero,numero_cliente,fecha,fecha_prevision,fecha_vencimiento,tipo,nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,edireccion,epoblacion,ecp,eprovincia,notas,subtotal,descuento,subtotaldescuento,iva,total,id_cliente,id_user) ";
		$sql = $sql."values (";
		$sqlxx = "select * from sgm_cabezera where visible=1 AND tipo=1 order by numero desc";
		$resultxx = mysql_query(convert_sql($sqlxx));
		$rowxx = mysql_fetch_array($resultxx);
		$numero = $rowxx["numero"] + 1;
		$sql = $sql."".$numero."";
		$sql = $sql.",'".$row["numero_cliente"]."'";
		$sql = $sql.",'".$_POST["fecha_nueva"]."'";
		$sql = $sql.",'".$row["fecha_prevision"]."'";
		$sql = $sql.",'".calcular_fecha_vencimiento($row["id_cliente"],$_POST["fecha_nueva"])."'";
		$sql = $sql.",1";
		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".$row["direccion"]."'";
		$sql = $sql.",'".$row["poblacion"]."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".$row["provincia"]."'";
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";
		$sql = $sql.",'".$row["onombre"]."'";
		$sql = $sql.",'".$row["onif"]."'";
		$sql = $sql.",'".$row["odireccion"]."'";
		$sql = $sql.",'".$row["opoblacion"]."'";
		$sql = $sql.",'".$row["ocp"]."'";
		$sql = $sql.",'".$row["oprovincia"]."'";
		$sql = $sql.",'".$row["omail"]."'";
		$sql = $sql.",'".$row["otelefono"]."'";
		$sql = $sql.",'".$row["edireccion"]."'";
		$sql = $sql.",'".$row["epoblacion"]."'";
		$sql = $sql.",'".$row["ecp"]."'";
		$sql = $sql.",'".$row["eprovincia"]."'";
		$sql = $sql.",'".$row["notas"]."'";
		$sql = $sql.",".$row["subtotal"]."";
		$sql = $sql.",".$row["descuento"]."";
		$sql = $sql.",".$row["subtotaldescuento"]."";
		$sql = $sql.",".$row["iva"]."";
		$sql = $sql.",".$row["total"]."";
		$sql = $sql.",".$row["id_cliente"]."";
		$sql = $sql.",".$row["id_user"]."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		### COPIA LINEAS PLANTILLA
		$sqlxx = "select * from sgm_cabezera where visible=1 AND tipo=1 order by numero desc";
		$resultxx = mysql_query(convert_sql($sqlxx));
		$rowxx = mysql_fetch_array($resultxx);
		$numero_factura = $rowxx["numero"];
		$id_factura = $rowxx["id"];
		$sql1 = "insert into sgm_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total) ";
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$id_factura;
		$sql1 = $sql1.",''";
		$sql1 = $sql1.",'ALBARAN ".$row["numero"]." (".$row["fecha"].")'";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.")";
		mysql_query(convert_sql($sql1));
		$sql = "select * from sgm_cuerpo where idfactura=".$_POST["id_plantilla"];
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sql1 = "insert into sgm_cuerpo (idfactura,linea,fecha_prevision,codigo,nombre,pvd,pvp,unidades,total) ";
			$sql1 = $sql1."values (";
			$sql1 = $sql1."".$id_factura;
			$sql1 = $sql1.",".$row["linea"];
			$sql1 = $sql1.",'".$row["fecha_prevision"]."'";
			$sql1 = $sql1.",'".$row["codigo"]."'";
			$sql1 = $sql1.",'".$row["nombre"]."'";
			$sql1 = $sql1.",".$row["pvd"];
			$sql1 = $sql1.",".$row["pvp"];
			$sql1 = $sql1.",".$row["unidades"];
			$sql1 = $sql1.",".$row["total"];
			$sql1 = $sql1.")";
			mysql_query(convert_sql($sql1));
		}
		### RELACIONA PLANTILLA CON FACTURA
		$sql = "insert into sgm_facturas_relaciones (id_plantilla,fecha,id_factura) ";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_plantilla"]."";
		$sql = $sql.",'".$_POST["fecha"]."'";
		$sql = $sql.",".$numero_factura;
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		### PONE COBRADO EL ALBARAN
		$sql = "update sgm_cabezera set ";
		$sql = $sql."cobrada=1";
		$sql = $sql." WHERE id=".$_POST["id_plantilla"]."";
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=0\">[ ".$Volver." ]</a>";
	}

	if ($soption == 53) {
		$sqlxx = "select * from sgm_cabezera where visible=1 AND tipo=1 AND numero=".$_POST["id_factura"];
		$resultxx = mysql_query(convert_sql($sqlxx));
		$rowxx = mysql_fetch_array($resultxx);
		$id_factura = $rowxx["id"];
		$sql1 = "insert into sgm_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total) ";
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$id_factura;
		$sql1 = $sql1.",''";
		$sql1 = $sql1.",'ALBARAN ".$_POST["id_plantilla_numero"]." (".$_POST["id_plantilla_fecha"].")'";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.",0";
		$sql1 = $sql1.")";
		mysql_query(convert_sql($sql1));
		### COPIA LINEAS PLANTILLA
		$sql = "select * from sgm_cuerpo where idfactura=".$_POST["id_plantilla"];
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sql1 = "insert into sgm_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total) ";
			$sql1 = $sql1."values (";
			$sql1 = $sql1."".$id_factura;
			$sql1 = $sql1.",'".$row["codigo"]."'";
			$sql1 = $sql1.",'".$row["nombre"]."'";
			$sql1 = $sql1.",".$row["pvd"];
			$sql1 = $sql1.",".$row["pvp"];
			$sql1 = $sql1.",".$row["unidades"];
			$sql1 = $sql1.",".$row["total"];
			$sql1 = $sql1.")";
			mysql_query(convert_sql($sql1));
		}
		refactura($id_factura);
		### PONE COBRADO EL ALBARAN
		$sql = "update sgm_cabezera set ";
		$sql = $sql."cobrada=1";
		$sql = $sql." WHERE id=".$_POST["id_plantilla"]."";
		#echo "<br>".$sql;
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=0\">[ ".$Volver." ]</a>";
	}

	if ($soption == 54) {
		$sql = "update sgm_cabezera set ";
		$sql = $sql."cerrada=1";
		$sql = $sql." WHERE id=".$_POST["id"]."";
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1003&sop=10&id=".$_GET["serie"]."\">[ ".$Volver." ]</a>";
	}

	if ($soption == 60) {
		echo "<strong>Listado cambios de fecha</strong><br>";
		echo boton_volver($Volver);
		echo "<center><table cellspacing=\"0\" style=\"width:300px;\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td>".$Fecha." ".$Cambio."</td>";
				echo "<td>".$Usuario."</td>";
				echo "<td>".$Fecha." ".$Cambiada."</td>";
			echo "</tr>";
			if ($_GET["classe"] == 1) {
				$sql = "select * from sgm_factura_canvi_data_prevision where id_factura=".$_GET["id"];
			}
			if ($_GET["classe"] == 2) {
				$sql = "select * from sgm_factura_canvi_data_entrega where id_factura=".$_GET["id"];
			}
			if ($_GET["classe"] == 3) {
				$sql = "select * from sgm_factura_canvi_data_prevision_cuerpo where id_factura=".$_GET["id"]." and id_cuerpo=".$_GET["id_cuerpo"];
			}
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr>";
				echo "<td>".$row["data"]."</td>";
				$sqlu = "select * from sgm_users where id=".$row["id_usuario"];
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
				echo "<td>".$rowu["usuario"]."</td>";
				echo "<td>".$row["fecha_ant"]."</td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 70) {
		echo "<strong>".$Impresion." de ".$Documentos." ".$por." ".$fecha."</strong><br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Tipo." ".$Documento."</td>";
				echo "<td>".$Fecha." ".$Desde."</td>";
				echo "<td>".$Fecha." ".$Hasta."</td>";
				echo "<td>".$Impresion."</td>";
				echo "<td>".$Idioma."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-print-pdf.php?\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
				echo "<td>";
				echo "<select name=\"id_tipo\" style=\"width:200px\">";
				echo "<option value=\"0\">-</option>";
				$sqlx = "select * from sgm_factura_tipos where visible=1 order by tipo";
				$resultx = mysql_query(convert_sql($sqlx));
				while ($rowx = mysql_fetch_array($resultx)) {
					echo "<option value=\"".$rowx["id"]."\">".$rowx["tipo"]."</option>";
				}
				echo "</select>";
				echo "</td>";
				$fecha = getdate();
				$data = cambiarFormatoFechaDMY(date("Y-m-d", mktime(0,0,0,$fecha["mon"] ,$fecha["mday"], $fecha["year"])));
				echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_desde\" value=\"".$data."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_fins\" value=\"".$data."\"></td>";
				echo "<td><select name=\"tipo\" style=\"width:70px\">";
				echo "<option value=\"0\">".$Sobre."</option>";
				echo "<option value=\"1\">No ".$Sobre."</option>";
				echo "</select></td>";
				echo "<td><select name=\"idioma\" style=\"width:90px\">";
				echo "<option value=\"0\">-</option>";
				$sqli = "select * from sgm_idiomas where visible=1";
				$resulti = mysql_query(convert_sql($sqli));
				while ($rowi = mysql_fetch_array($resulti)) {
					if ($rowi["predefinido"] == 1) {
						echo "<option value=\"".$rowi["idioma"]."\" selected>".$rowi["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$rowi["idioma"]."\">".$rowi["descripcion"]."</option>";
					}
				}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Imprimir."\" style=\"width:100px;\" ></td>";
			echo "</form>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 80) {
		echo "<strong>".$Descarga." de ".$Fuentes."</strong><br>";
		echo boton_volver($Volver);
		echo "<center><table cellspacing=\"0\" style=\"width:150px;\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Fuentes."</td>";
			echo "</tr><td>&nbsp;</td><tr>";
			echo "</tr><tr>";
				echo "<td><a href=\"mgestion/fonts/C39HrP24DlTt.ttf?\">".$Codigo." de ".$Barras."</a></td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sqlcc = "select count(*) as total from sgm_cabezera where visible=1 and numero=".$_POST["numero"]." and tipo=".$_POST["tipo"];
			$resultcc = mysql_query(convert_sql($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			if ($rowcc["total"] == 0){
				$sql = "select * from sgm_clients where id=".$_POST["cliente"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$sqltipos = "select * from sgm_factura_tipos where id=".$_POST["tipo"];
				$resulttipos = mysql_query(convert_sql($sqltipos));
				$rowtipos = mysql_fetch_array($resulttipos);
				$sql = "insert into sgm_cabezera (numero,iva,version,numero_rfq,numero_cliente,fecha,fecha_prevision,fecha_entrega,fecha_vencimiento,tipo,subtipo,nombre,nif,direccion,poblacion,cp,provincia,id_pais,mail,telefono,edireccion,epoblacion,ecp,eprovincia,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,id_cliente,id_user,id_divisa,div_canvi,cnombre,cmail,ctelefono,cuenta) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["numero"]."";
				$sql = $sql.",21";
				$sql = $sql.",'".$_POST["version"]."'";
				$sql = $sql.",'".$_POST["numero_rfq"]."'";
				$sql = $sql.",'".$_POST["numero_cliente"]."'";
				$sql = $sql.",'".cambiarFormatoFechaYMD($_POST["fecha"])."'";
				$sql = $sql.",'".cambiarFormatoFechaYMD($_POST["fecha_prevision"])."'";
				$sql = $sql.",'".cambiarFormatoFechaYMD($_POST["fecha_prevision"])."'";
				if ($rowtipos["v_fecha_vencimiento"] == 1) {
					$fecha_vencimiento = calcular_fecha_vencimiento($_POST["cliente"],cambiarFormatoFechaYMD($_POST["fecha"]));
				} else { $fecha_vencimiento = cambiarFormatoFechaYMD($_POST["fecha"]); }
				if ($rowtipos["presu"] == 1) {
					$suma = $rowtipos["presu_dias"];
					$date1 = cambiarFormatoFechaYMD($_POST["fecha"]);
					$a = date("Y", strtotime($date1)); 
					$m = date("n", strtotime($date1)); 
					$d = date("j", strtotime($date1)); 
					$fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$suma, $a));
				} else { $fecha_vencimiento = cambiarFormatoFechaYMD($_POST["fecha"]); }
				$sql = $sql.",'".$fecha_vencimiento."'";
				$sql = $sql.",".$_POST["tipo"];
				$sql = $sql.",".$_POST["subtipo"];
				$sql = $sql.",'".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."'";
				$sql = $sql.",'".$row["nif"]."'";
				$sql = $sql.",'".$row["direccion"]."'";
				$sql = $sql.",'".$row["poblacion"]."'";
				$sql = $sql.",'".$row["cp"]."'";
				$sql = $sql.",'".$row["provincia"]."'";
				$sql = $sql.",".$row["id_pais"];
				$sql = $sql.",'".$row["mail"]."'";
				$sql = $sql.",'".$row["telefono"]."'";
				if ($row["id_direccion_envio"] == 0) {
					$sql = $sql.",'".$row["direccion"]."'";
					$sql = $sql.",'".$row["poblacion"]."'";
					$sql = $sql.",'".$row["cp"]."'";
					$sql = $sql.",'".$row["provincia"]."'";
				}
				if ($row["id_direccion_envio"] <> 0) {
					$sql3 = "select * from sgm_clients_envios where id=".$row["id_direccion_envio"];
					$result3 = mysql_query(convert_sql($sql3));
					$row3 = mysql_fetch_array($result3);
					$sql = $sql.",'".$row3["direccion"]."'";
					$sql = $sql.",'".$row3["poblacion"]."'";
					$sql = $sql.",'".$row3["cp"]."'";
					$sql = $sql.",'".$row3["provincia"]."'";
				}
				$sql2 = "select * from sgm_dades_origen_factura";
				$result2 = mysql_query(convert_sql($sql2));
				$row2 = mysql_fetch_array($result2);
				$sql = $sql.",'".$row["nombre"]."'";
				$sql = $sql.",'".$row["nif"]."'";
				$sql = $sql.",'".$row["direccion"]."'";
				$sql = $sql.",'".$row["poblacion"]."'";
				$sql = $sql.",'".$row["cp"]."'";
				$sql = $sql.",'".$row["provincia"]."'";
				$sql = $sql.",'".$row["mail"]."'";
				$sql = $sql.",'".$row["telefono"]."'";
				$sql = $sql.",".$_POST["cliente"];
				$sql = $sql.",".$userid;
				$sqld = "select * from sgm_divisas where predefinido=1";
				$resultd = mysql_query(convert_sql($sqld));
				$rowd = mysql_fetch_array($resultd);
				$sql = $sql.",".$rowd["id"];
				$sql = $sql.",".$rowd["canvi"];
				$sqlc = "select * from sgm_clients_contactos where pred=1 and id_client=".$_POST["cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$sql = $sql.",'".$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"]."'";
				$sql = $sql.",'".$rowc["mail"]."'";
				$sql = $sql.",'".$rowc["telefono"]."'";
				if ($row["cuentacontable"] != 0){
					$sql = $sql.",".$row["cuentacontable"]."";
				} else {
					$sql = $sql.",0";
				}
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 20) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 7) {
			echo trafactura($_GET["id_fact"],$_POST["id_tipus"],$_POST["data"]);
		}

		echo "<center>";
		$presu = 0;
		$v_fecha_pre = 0;
		$v_fecha_ven = 0;
		$v_numero_cli = 0;
		$v_rfq = 0;
		$tpv = 1;
		$v_sub = 0;
		if (($_GET["tipo"] == 1) or ($_GET["iduser"] > 0)) {$sqltipo = "select * from sgm_factura_tipos where id IN (8,5)";}
		if ($_GET["tipo"] == 2) {$sqltipo = "select * from sgm_factura_tipos where id IN (10)";}
		if ($_GET["tipo"] == 3) {$sqltipo = "select * from sgm_factura_tipos where id IN (7,1,9)";}
		if ($_GET["tipo"] == 4) {$sqltipo = "select * from sgm_factura_tipos where id IN (8,5)";}
		if ($_GET["tipo"] == 5) {$sqltipo = "select * from sgm_factura_tipos where id = 1";}
		$resulttipo = mysql_query(convert_sql($sqltipo));
		while ($rowtipo = mysql_fetch_array($resulttipo)){
			if ($rowtipo["presu"] == 1){ $presu = 1; }
			if ($rowtipo["v_fecha_prevision"] == 1) { $v_fecha_pre = 1; }
			if ($rowtipo["v_fecha_vencimiento"] == 1) { $v_fecha_ven = 1; }
			if ($rowtipo["v_numero_cliente"] == 1) { $v_numero_cli = 1; }
			if ($rowtipo["v_rfq"] == 1) { $v_rfq = 1; }
			if ($rowtipo["tpv"] == 0) { $tpv = 0; }
			if ($rowtipo["v_subtipos"] == 1) { $v_sub = 1; }
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:1000px\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td></td>";
				echo "<td>Docs</td>";
				echo "<td style=\"width:70px\"><center>".$Numero."</center></td>";
				if ($presu == 1) { echo "<td style=\"width:30px;text-align:center\">Ver.</td>"; }
				echo "<td style=\"width:100px;text-align:center\">".$Fecha."</td>";
				if ($v_fecha_pre == 1) { echo "<td style=\"width:90px;text-align:center\">".$Fecha." ".$Prevision."</td>"; }
				if ($v_fecha_ven == 1) { echo "<td style=\"width:90px;text-align:center\">".$Vencimiento."</td>"; }
				if ($v_numero_cli == 1) { echo "<td style=\"width:90px;text-align:center\"><center>Ref. Ped. Cli.</center></td>"; }
				if ($v_rfq == 1) { echo "<td style=\"width:90px;text-align:center\"><center>".$Numero." RFQ</center></td>"; }
				if ($tpv == 0) { echo "<td>".$Cliente."</td>"; }
				if ($v_sub == 1) { echo "<td style=\"width:90px;text-align:center\"><center>".$Subtipo."</center></td>"; }
				echo "<td style=\"width:90px;text-align:center\">".$Total."</td><td></td>";
			echo "</tr>";
			$totalSensePagar = 0;
#			$sql = "select * from sgm_cabezera where visible=1 AND tipo in ".$rowtipos["id"];
			$fechahoy = getdate();
			$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-300, $fechahoy["year"]));
			$hoy = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
			if ($_GET["tipo"] == 1) {$sqlca = "select * from sgm_cabezera where visible=1 AND tipo IN (8,5) and id_pagador=1";}
			if ($_GET["tipo"] == 2) {$sqlca = "select * from sgm_cabezera where visible=1 AND tipo IN (10) and id_pagador=1";}
			if ($_GET["tipo"] == 3) {$sqlca = "select * from sgm_cabezera where visible=1 AND tipo IN (7,1,9)";}
			if ($_GET["tipo"] == 4) {$sqlca = "select * from sgm_cabezera where visible=1 AND tipo IN (8,5) and id_pagador<>1";}
			if ($_GET["tipo"] == 5) {$sqlca = "select * from sgm_cabezera where visible=1 and tipo=1 and id in (select id_factura from sgm_recibos where fecha='".date("Y-m-d", $_GET["fecha"])."' and visible=1)";}
			if ($_GET["iduser"] != "") {$sqlca = "select * from sgm_cabezera where visible=1 and id_pagador=".$_GET["iduser"];}
			if (($_GET["tipo"] != 4) and ($_GET["tipo"] != 5) and ($_GET["iduser"] <= 0)){$sqlca = $sqlca." AND fecha_vencimiento='".date("Y-m-d", $_GET["fecha"])."'";}
			$sqlca = $sqlca." order by numero desc,version desc,fecha desc";
#			echo $sqlca;
			$resultca = mysql_query(convert_sql($sqlca));
			while ($rowca = mysql_fetch_array($resultca)) {
		#### OPCIONES DE VISUALIZACION SI SE MUESTRA O NO
				$ver = 0;
				if ($data1 <= $rowca["fecha"]) { $ver = 1; }
				if ($rowca["cobrada"] == 0) { $ver = 1; }
#				#No Albarán
#				if (($_GET["id"] != 2) AND ($rowca["cobrada"] == 0)) { $ver = 1; }
				#Albarán
#				if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["aprovado"] == 0) and ($rowtipos["v_subtipos"] == 0) AND ($rowca["cobrada"] == 1)) { $ver = 0; }
#				#pedido cliente
#				if (($rowtipos["tipo_ot"] == 1) AND ($rowca["cerrada"] == 1)) { $ver = 0; }
#				if (($data1 >= $rowca["fecha"]) AND ($_GET["id"] == 4) AND ($rowca["cerrada"] == 1)) { $ver = 0; }
				#factura
				if ($rowtipos["v_recibos"] == 1) {
					$date = getdate();
					$hoyd = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
					if ($rowca["cobrada"] == 1){
						$ver = 0;
					}
				}
				if ($_GET["tipo"] == 5) { $ver = 1;}
				if ($ssoption == 10) { $ver = 1; }
				if (($rowca["cerrada"] == 1) and ($ssop != 10)) { $ver = 0; }
				if ($ver == 1) {
		########## FECHAS AVISOS CERCANIA FECHA PREVISION (colores)
					$a = date("Y", strtotime($rowca["fecha_prevision"]));
					$m = date("m", strtotime($rowca["fecha_prevision"]));
					$d = date("d", strtotime($rowca["fecha_prevision"]));
					$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
					$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
					$color = "#FFFFFF";
					#pedido proveedor
					if ($rowtipos["v_subtipos"] == 1){
						if ($rowca["confirmada_cliente"] == 0) {
							$color = "#FF0000";
						} else {
							$color = "#00EC00";
						}
					}
					#pedido cliente
					if ($rowtipos["tipo_ot"] == 1) {
						$color = "#FFFFFF";
						$fecha_aviso2 = $fecha_aviso;
						$sqlc = "select * from sgm_cuerpo where idfactura=".$rowca["id"]." and id_estado<>-1 and facturado<>1 order by  fecha_prevision";
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
						if ($rowca["cerrada"] == 1) { $color = "#FFFFFF"; }
					} 
					#presupuesto
					if ($rowtipos["presu"] == 1) {
						$color = "#FFFFFF";
						$prevision_final = $fecha_prevision;
						$fecha_aviso1 = $fecha_aviso;
						$fecha_aviso2 = $fecha_aviso;
						$sqlc = "select * from sgm_cuerpo where idfactura=".$rowca["id"]."";
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
						if ($rowca["cerrada"] == 1) { $color = "#FFFFFF"; }
					}
					#factura
					if ($rowtipos["v_recibos"] == 1) {
						$color = "#FFFFFF";
						$a = date("Y", strtotime($rowca["fecha_vencimiento"]));
						$m = date("m", strtotime($rowca["fecha_vencimiento"]));
						$d = date("d", strtotime($rowca["fecha_vencimiento"]));
						$fecha_prevision3 = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
						$fecha_aviso3 = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
						$hoy2 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]+15, $fechahoy["year"]));
						if ($rowca["cobrada"] == 1) {
							$color = "#00EC00";
						} else {
							if ($fecha_aviso3 <= $hoy2) {
								$color = "#FFA500";
							}
							if ($fecha_prevision3 < $hoy) {
								$color = "#FF0000";
							}
							$sqld = "select count(*) as total from sgm_recibos where visible=1 and cobrada=0 and id_tipo_pago=4 AND id_factura =".$rowca["id"];
							$resultd = mysql_query(convert_sql($sqld));
							$rowd = mysql_fetch_array($resultd);
							if ($rowd["total"] > 0) { $color = "#0000FF"; }
							$sqlcalc = "select * from sgm_recibos where visible=1 and cobrada=1 AND id_factura =".$rowca["id"];
							$resultcalc = mysql_query(convert_sql($sqlcalc));
							$rowcalc = mysql_fetch_array($resultcalc);
							if ($rowcalc["total"]) { $color = "#FFFF00"; }
						}
						if ($rowca["cerrada"] == 1) { $color = "#FFFFFF"; }
					}
					#albaranes
					if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["aprovado"] == 0) and ($rowtipos["v_subtipos"] == 0)) {
						$color = "#FF1515";
						if ($rowca["cerrada"] == 1) { $color = "#00EC00"; }
						if ($rowca["cobrada"] == 1) { $color = "#FFFFFF"; }
					}
					echo "<tr style=\"border-bottom : 1px dashed Black;\">";
#						echo "<td><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
						echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=600&id=".$rowca["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"Opciones\" style=\"width:70px\"></form></td>";
						$sqlca2 = "select count(*) as total from sgm_files where id_cuerpo in (select id from sgm_cuerpo where idfactura=".$rowca["id"].")";
						$resultca2 = mysql_query(convert_sql($sqlca2));
						$rowca2 = mysql_fetch_array($resultca2);
						echo "<td>(".$rowca2["total"].")</td>";
#						echo "</tr></table></td>";
						echo "<td style=\"background-color : ".$color.";text-align:right;width:65px\"><strong>".$rowca["numero"]."</strong></td>";
						if ($rowtipos["presu"] == 1) { echo "<td style=\"background-color : ".$color.";text-align:left\"><strong>/".$rowca["version"]."</strong></td>"; }
					############ CALCULOS SOBRE LAS FECHAS OFICIALES
							$a = date("Y", strtotime($rowca["fecha"]));
							$m = date("m", strtotime($rowca["fecha"]));
							$d = date("d", strtotime($rowca["fecha"]));
							$date = getdate();
							if ($date["year"]."-".$date["mon"]."-".$date["mday"] < $rowca["fecha"]) {
								$fecha_proxima = $rowca["fecha"];
							} else { 
								$fecha_proxima = $rowca["fecha"];
								$multiplica = 0;
								$sql00 = "select * from sgm_facturas_relaciones where id_plantilla=".$rowca["id"]." order by fecha";
								$result00 = mysql_query(convert_sql($sql00));
								while ($row00 = mysql_fetch_array($result00)) {
									if ($fecha_proxima == $row00["fecha"]) {
										$multiplica++;
										$fecha_proxima = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*$multiplica), $a));
									}
								}
							}
							if ($rowtipos["dias"] == 0) {
								echo "<td style=\"background-color : ".$color.";text-align:center;\"><strong>".cambiarFormatoFechaDMY($rowca["fecha"])."</strong></td>";
							} else { 
								if ($fecha_proxima > $date1) {
									$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
									if ($fecha_aviso <  $date1) {
										echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".cambiarFormatoFechaDMY($rowca["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
									} else {
										echo "<td style=\"background-color : ".$color.";text-align:center;\">I: ".cambiarFormatoFechaDMY($rowca["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
									}
								} else {
									echo "<td style=\"background-color:red;color:White;text-align:center;\">I: ".cambiarFormatoFechaDMY($rowca["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>"; }
								}
								if ($rowtipos["v_fecha_prevision"] == 1) { echo "<td style=\"background-color : ".$color.";text-align:center;\">".cambiarFormatoFechaDMY($rowca["fecha_prevision"])."</td>"; }
								if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td style=\"background-color : ".$color.";text-align:center;\">".cambiarFormatoFechaDMY($rowca["fecha_vencimiento"])."</td>"; }
								if ($rowtipos["v_numero_cliente"] == 1) {
									if (($rowtipos["tipo_ot"] == 1) and ($rowca["confirmada"] == 1)) {
										echo "<td style=\"background-color : ".$color.";\">".$rowca["numero_cliente"]."</td>";
									} else {
										if ($rowtipos["presu"] == 1){
											echo "<td style=\"background-color : ".$color.";\">".$rowca["numero_cliente"]."</td>";
										} else {
											echo "<td>".$rowca["numero_cliente"]."</td>";
										}
									}
								}
								if ($rowtipos["v_rfq"] == 1) {
									if (($rowtipos["tipo_ot"] == 1) and ($rowca["aprovado"] == 1)) {
										echo "<td style=\"background-color : ".$color.";\">".$rowca["numero_rfq"]."</td>";
									} else {
										if ($rowtipos["presu"] == 1){
											echo "<td style=\"background-color : ".$color.";\">".$rowca["numero_rfq"]."</td>";
										} else {
											echo "<td>".$rowca["numero_rfq"]."</td>";
										}
									}
								}
								if ($rowtipos["tpv"] == 0) {
									if (strlen($rowca["nombre"]) > 25) {
										echo "<td style=\"background-color : ".$color.";\"><a href=\"index.php?op=1011&sop=0&id=".$rowca["id_cliente"]."&origen=1003\" style=\"color:black\">".substr($rowca["nombre"],0,25)." ...</a></td>";
									} else {
										echo "<td style=\"background-color : ".$color.";\"><a href=\"index.php?op=1011&sop=0&id=".$rowca["id_cliente"]."&origen=1003\" style=\"color:black\">".$rowca["nombre"]."</a></td>";
									}
									if ($rowtipos["v_subtipos"] == 1) {
										echo "<td style=\"background-color : ".$color.";\">";
										echo "<select style=\"width:70px\" name=\"subtipo\" disabled>";
											echo "<option value=\"0\">-</option>";
											$sqlsss = "select * from sgm_factura_subtipos where visible=1 and id_tipo=".$_GET["id"]." order by subtipo";
											$resultsss = mysql_query(convert_sql($sqlsss));
											while ($rowsss = mysql_fetch_array($resultsss)) {
												if ($rowca["subtipo"] == $rowsss["id"]) {
													echo "<option value=\"".$rowsss["id"]."\" selected>".$rowsss["subtipo"]."</option>";
												} else {
													echo "<option value=\"".$rowsss["id"]."\">".$rowsss["subtipo"]."</option>";
												}
											}
										echo "</select>";
										echo "</td>";
								}
							}
							echo "<td style=\"background-color : ".$color.";text-align : right;\">".number_format($rowca["total"],2)." €</td>";
							$totalSensePagar += $rowca["total"];
							echo "<td style=\"background-color : ".$color.";\"><form method=\"post\" action=\"index.php?op=1003&sop=22&id=".$rowca["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"Editar\" style=\"width:50px\"></form></td>";
							if ($rowtipos["tpv"] == 0) {
								echo "<form method=\"post\" action=\"index.php?op=1003&sop=12&id=".$rowca["id"]."&id_tipo=".$_GET["id"]."\">";
									echo "<td style=\"background-color : ".$color.";\"><input type=\"Submit\" value=\"Imp.\" style=\"width:50px\"></td>";
								echo "</form>";
							}
							if ($rowtipos["tpv"] == 1) {
								echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-tiquet-print.php?id=".$rowca["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
									echo "<td style=\"background-color : ".$color.";\"><input type=\"Submit\" value=\"Imp.\" style=\"width:50px\"></td>";
								echo "</form>";
							}
#							echo "<td style=\"background-color : ".$color.";\"><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
							if ($rowtipos["v_recibos"] == 1)  {
								echo "<td>";
									echo "<form method=\"post\" action=\"index.php?op=1003&sop=200&id=".$rowca["id"]."\"><input type=\"Submit\" value=\"".$Recibos."\" style=\"width:50px\"></form>";
								echo "</td>";
									$sqlr = "select SUM(total) as total from sgm_recibos where visible=1 and id_factura=".$rowca["id"]." order by numero desc, numero_serie desc";
									$resultr = mysql_query(convert_sql($sqlr));
									$rowr = mysql_fetch_array($resultr);
									echo "<td style=\"background-color:".$color.";width:300px;text-align:right;\">".number_format(($rowca["total"]-$rowr["total"]),2)." €</td>";
							}
#							echo "<td>";
#								echo "<form method=\"post\" action=\"index.php?op=1003&sop=11&id=".$rowca["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"".$Cerrar."\" style=\"width:50px\"></form>";
#							echo "</td>";
					echo "</tr>";
			}
		}
			echo "<tr>";
				echo "<td colspan=\"5\" style=\"text-align:right;\"><strong>".$Total."</strong></td>";
				echo "<td style=\"text-align:right;\">".number_format($totalSensePagar,2)." €</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 101) {
		echo "<strong>".$Resumen." ".$Mensual." (".$Base_imponible.", IVA ".$ygriega." ".$Total.") : </strong><br><br>";
		echo boton_volver($Volver);
		echo "<br><center><table cellspacing=\"0\" style=\"width:200px\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$fechahoy = getdate();
					$yact = $fechahoy["year"];
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=101&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=101&y=".$yact."&m=".$_GET["m"]."\">".$yact."</a></td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=101&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
			echo "</tr>";
			echo "<tr>";
				if ($_GET["m"] == "") {
					$fechahoy = getdate();
					$mact = $fechahoy["year"];
				} else {
					$mact = $_GET["m"];
				}
				$mant = $mact - 1;
				$mpost = $mact +1;
				if ($mant >= 1){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=101&y=".$yact."&m=".$mant."\">".$mant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=101&y=".$yact."&m=".$mact."\">".$mact."</a></td>";
				if ($mpost <= 12){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=101&y=".$yact."&m=".$mpost."\">&gt;".$mpost."</a></td>";
				} else { echo "<td></td>";}
		echo "</tr></table></center>";
		echo "<br><center><table cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 1; $x <= 31; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$x."</strong></td>";
				}
				echo "<td style=\"text-align:right;\"><strong>".$Total."</strong></td>";
			echo "</tr><tr>";
			$sqltipos = "select * from sgm_factura_tipos where visible=1 order by orden";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				$totala1 = 0;
				$totala3 = 0;
				$totala4 = 0;
				echo "<td>".$rowtipos["tipo"]."</td>";
				for ($x = 1; $x <= 31; $x++) {
					if ($x < 10) { $d = "0".$x; } else { $d = $x; }
					$sql = "select sum(subtotal) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$rowtipos["id"]." and fecha='".$yact."-".$mact."-".$d."'";
					if ($rowtipos["v_recibos"] == 1) { $sql = $sql." and cobrada=1"; }
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<td style=\"text-align:right;\">(".$row["total4"].")<br><strong>".number_format($row["total1"], 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($row["total3"]-$row["total1"]), 2, ',', '.')."</strong><br><strong>".number_format($row["total3"], 2, ',', '.')."</strong></td>";
					$totala1 = $totala1+$row["total1"];
					$totala3 = $totala3+$row["total3"];
					$totala4 = $totala4+$row["total4"];
				}
				echo "<td style=\"text-align:right;color:blue;\">(".$totala4.")<br><strong>".number_format($totala1, 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($totala3-$totala1), 2, ',', '.')."</strong><br><strong>".number_format($totala3, 2, ',', '.')."</strong></td>";
				echo "</tr><tr>";
			}
		echo "</tr></table></center>";
	}

	if ($soption == 102) {
		echo "<strong>".$Resumen." ".$Anual." (".$Base_imponible.", IVA ".$ygriega." ".$Total.") : </strong><br><br>";
		echo boton_volver($Volver);
		echo "<br><center><table cellspacing=\"0\" style=\"width:200px\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$fechahoy = getdate();
					$yact = $fechahoy["year"];
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=102&y=".$yant."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=102&y=".$yact."\">".$yact."</a></td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=102&y=".$ypost."\">&gt;".$ypost."</a></td>";
		echo "</tr></table></center>";
		echo "<br><center><table cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=1&y=".$yact."\"><strong>".$Enero."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=2&y=".$yact."\"><strong>".$Febrero."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=3&y=".$yact."\"><strong>".$Marzo."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong style=\"color:blue;\"> TRI 1</strong></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=4&y=".$yact."\"><strong>".$Abril."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=5&y=".$yact."\"><strong>".$Mayo."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=6&y=".$yact."\"><strong>".$Junio."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong style=\"color:blue;\"> TRI 2</strong></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=7&y=".$yact."\"><strong>".$Julio."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=8&y=".$yact."\"><strong>".$Agosto."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=9&y=".$yact."\"><strong>".$Septiembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong style=\"color:blue;\"> TRI 3</strong></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=10&y=".$yact."\"><strong>".$Octubre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=11&y=".$yact."\"><strong>".$Noviembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=101&m=12&y=".$yact."\"><strong>".$Diciembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong style=\"color:blue;\"> TRI 4</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total."</strong></td>";
			echo "</tr>";
			$sqltipos = "select * from sgm_factura_tipos where visible=1 order by orden";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
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
					$yf = $yact;
					if ($x < 10) { $m = "0".$x; } else { $m = $x; }
					if ($x == 12) { 
						$mf = "01";
						$yf = $yact+1;
					} else {
						if ($x < 9) { $mf = "0".($x+1); } else { $mf = $x+1; }
					}
					$sql = "select sum(subtotal) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$rowtipos["id"]." and ((fecha>= '".$y."-".$m."-01') and (fecha<'".$yf."-".$mf."-01'))";
#					if ($rowtipos["v_recibos"] == 1) { $sql = $sql." and cobrada=1"; }
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<td style=\"text-align:right;\">(".$row["total4"].")<br><strong>".number_format($row["total1"], 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($row["total3"]-$row["total1"]), 2, ',', '.')."</strong><br><strong>".number_format($row["total3"], 2, ',', '.')."</strong></td>";
					$tri1 = $tri1+$row["total1"];
					$tri3 = $tri3+$row["total3"];
					$tri4 = $tri4+$row["total4"];
					if ($tri == 3) {
						echo "<td style=\"text-align:right;color:blue;\">(".$tri4.")<br><strong>".number_format($tri1, 2, ',', '.')."</strong><br><strong style=\"color:blue;\">".number_format(($tri3-$tri1), 2, ',', '.')."</strong><br><strong>".number_format($tri3, 2, ',', '.')."</strong></td>";
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
		echo "</table></center>";
	}

	if ($soption == 103) {
		echo "<strong>".$Resumen." (".$Base_imponible.", IVA ".$ygriega." ".$Total.") : </strong><br><br>";
		echo boton_volver($Volver);
		echo "<center><table cellspacing=\"0\" style=\"width:800px\"><tr>";
		for ($i = 2012; $i <= 2025; $i++) {
			$totala1 = 0;
			$totala3 = 0;
			$totala4 = 0;
			echo "</tr><tr style=\"background-color:silver;\">";
				echo "<td style=\"text-align:center;\"><strong>".$i."</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:center;\"><strong>1</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>2</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>3</strong></td>";
				echo "<td style=\"text-align:center;\"><strong style=\"color:blue;\"> TRI 1</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>4</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>5</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>6</strong></td>";
				echo "<td style=\"text-align:center;\"><strong style=\"color:blue;\"> TRI 2</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>7</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>8</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>9</strong></td>";
				echo "<td style=\"text-align:center;\"><strong style=\"color:blue;\"> TRI 3</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>10</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>11</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>12</strong></td>";
				echo "<td style=\"text-align:center;\"><strong style=\"color:blue;\"> TRI 4</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>TOTAL</strong></td>";
			echo "</tr></tr>";
			$tri = 1;
			$tri1 = 0;
			$tri3 = 0;
			$tri4 = 0;
			for ($x = 1; $x <= 12; $x++) {
				$y = $i;
				$yf = $i;
				if ($x < 10) { $m = "0".$x; } else { $m = $x; }
				if ($x == 12) { 
					$mf = "01";
					$yf = $i+1;
				} else {
					if ($x < 9) { $mf = "0".($x+1); } else { $mf = $x+1; }
				}
				$sql = "select sum(subtotal) as total1, sum(total) as total3,count(*) as total4 from sgm_cabezera where visible=1 and tipo=".$_GET["id"]." and ((fecha>= '".$y."-".$m."-01') and (fecha<'".$yf."-".$mf."-01'))";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<td style=\"text-align:right;\">(".$row["total4"].")<br><strong>".number_format($row["total1"], 2, ',', '.')."</strong><br><strong style=\"color:red;\">".number_format(($row["total3"]-$row["total1"]), 2, ',', '.')."</strong><br><strong>".number_format($row["total3"], 2, ',', '.')."</strong></td>";
				$tri1 = $tri1+$row["total1"];
				$tri3 = $tri3+$row["total3"];
				$tri4 = $tri4+$row["total4"];
				if ($tri == 3) {
					echo "<td style=\"text-align:right;color:blue;\">(".$tri4.")<br><strong>".number_format($tri1, 2, ',', '.')."</strong><br><strong style=\"color:blue;\">".number_format(($tri3-$tri1), 2, ',', '.')."</strong><br><strong>".number_format($tri3, 2, ',', '.')."</strong></td>";
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
		echo "</tr></table></center>";
	}

	if ($soption == 105) {
		if ($ssoption == 1) {
			echo calendari_economic(1);
		}
		echo "<strong>".$Situacion." ".$Anual." (".$Gastos."/ Pre-".$Gastos."/".$Ingresos."/".$Externo."/".$Total.") : </strong>";
		echo "<form action=\"index.php?op=1003&sop=106\" method=\"post\">";
		echo "<input type=\"submit\" action=\"index.php?op=1003&sop=105\" value=\"recalcul total\">";
		echo "</form>";
		echo "<br><br>";
		if ($admin == true){
			echo "<center><table cellspacing=\"0\" style=\"width:200px\">";
				echo "<tr>";
					if ($_GET["y"] == "") {
						$fechahoy = getdate();
						$yact = $fechahoy["year"];
					} else {
						$yact = $_GET["y"];
					}
					$yant = $yact - 1;
					$ypost = $yact +1;
					if ($yant >= 2012){
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=105&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
					} else { echo "<td></td>";}
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=105&y=".$yact."&m=".$_GET["m"]."\">".$yact."</a></td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=105&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
				echo "</tr>";
				echo "<tr>";
					if ($_GET["m"] == "") {
						$fechahoy = getdate();
						$mact = gmdate("n");
					} else {
						$mact = $_GET["m"];
					}
					$mant = $mact - 1;
					$mpost = $mact +1;
					if ($mant >= 1){
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=105&y=".$yact."&m=".$mant."\">".$mant."&lt;</a></td>";
					} else { echo "<td></td>";}
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=105&y=".$yact."&m=".$mact."\">".$mact."</a></td>";
					if ($mpost <= 12){
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=105&y=".$yact."&m=".$mpost."\">&gt;".$mpost."</a></td>";
					} else { echo "<td></td>";}
			echo "</tr></table></center><br><br>";
		}
		echo "<center><table cellspacing=\"5\" cellpadding=\"0\" style=\"width:1200px\">";
		$contador=($mact-1);
		$mes = ($mact-1);

		if ($mes == 12){ $any = $yact-1;} else { $any = $yact;}
		$mes_anterior = date("U", mktime(0,0,0,$mes,1,$any));
		$mes_ultimo = date("U", mktime(0,0,0,$mes+12, 1-1, $yact));
		$dia_actual=$mes_anterior;
		while ($dia_actual<=$mes_ultimo){
			$contador=$m;
			$m = date("n", $dia_actual);
			$meso = $meses[$m-1];
			if ($contador != $m){
				echo "</tr><tr><td>".$meso."</td></tr><tr>";
			}
			$hoy = date("Y-m-d", mktime(0,0,0,date("m"), date("d"), date("Y")));
			$dia_actual2 = date("Y-m-d", $dia_actual);
			if ($hoy == $dia_actual2){ $color_fondo = "yellow";} else { $color_fondo = "white";}
			$d = date("d", $dia_actual);
			echo "<td style=\"background-color:".$color_fondo."\">";
				echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%\">";
					echo "<tr><td><strong>".$d."</strong></td></tr>";
					$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual."'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["gastos"] > 0) {$color = "red";$color_letra = "white";} else {$color = $color_fondo; $color_letra = "black";}
					if ($row["pre_pagos"] > 0) {$color_pre = "red";$color_letra1 = "white";} else {$color_pre = $color_fondo; $color_letra1 = "black";}
					if ($row["ingresos"] > 0) {$color3 = "#1EB53A";} else {$color3 = $color_fondo;}
					if ($row["liquido"] >= 0) {$color2 = "#1EB53A"; $color_letra2 = "black";} else {$color2 = "red"; $color_letra2 = "white";}
					if ($dia_actual2 < $hoy){ $tipus = 5;} else { $tipus = 3;}
					echo "<tr><td style=\"text-align:right;background-color:".$color.";\"><a href=\"index.php?op=1003&sop=100&tipo=1&filtra=1&fecha=".$dia_actual."\" style=\"color:".$color_letra.";\">".number_format($row["gastos"], 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:".$color_pre."\"><a href=\"index.php?op=1003&sop=100tipo=2&filtra=1&fecha=".$dia_actual."\" style=\"color:".$color_letra1.";\">".number_format($row["pre_pagos"], 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:".$color3."\"><a href=\"index.php?op=1003&sop=100&tipo=".$tipus."&filtra=1&fecha=".$dia_actual."\" style=\"color:black;\">".number_format($row["ingresos"], 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:#0084C9\"><a href=\"index.php?op=1003&sop=100&tipo=4&filtra=1&fecha=".$dia_actual."\" style=\"color:black;\">".number_format($row["externos"], 2)."</a></td></tr>";
					echo "<tr><td style=\"text-align:right;background-color:".$color2.";\">".number_format($row["liquido"], 2)."</td></tr>";
				echo "</table>";
			echo "</td>";
			$proxim_any = date("Y",$dia_actual);
			$proxim_mes = date("m",$dia_actual);
			$proxim_dia = date("d",$dia_actual);
			$dia_actual = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+1,$proxim_any));
		}
		echo "</table></center>";
	}

	if ($soption == 106) {
		echo "<center><br><br>¿Seguro que desea hacer un recalculo total? Esta acci&oacute;n puede durar varios minutos, ya que se harà un recalculo total desde el 1 de Enero de 2012.";
		echo "<br><br><a href=\"index.php?op=1003&sop=105&ssop=1\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1003&sop=105\">[ NO ]</a></center>";
	}

	if ($soption == 110) {
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id"];
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		echo "<strong>".$Resumen." ".$Periodico." (".$Base_imponible.", IVA ".$ygriega." ".$Total.") : ".$rowtipos["tipo"]."</strong><br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=10&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center><table style=\"width:100%\"><tr><td style=\"vertical-align:top;width:50%;\">";
			echo "<center><table cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td>".$Fecha." ".$Inicio."</td>";
					echo "<td>".$Fecha." ".$Fin."</td>";
					echo "<td>".$Cliente."</td>";
				echo "</tr>";
				echo "<tr>";
					$date = getdate();
					$fecha = cambiarFormatoFechaDMY(date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"])));
					$fecha2 = cambiarFormatoFechaDMY(date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"]+1, $date["year"])));
					if ($_POST["fecha_inici"] != ""){ $fecha = $_POST["fecha_inici"];}
					if ($_POST["fecha_fi"] != ""){ $fecha2 = $_POST["fecha_fi"];}
					echo "<form action=\"index.php?op=1003&sop=110&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"fecha_inici\" value=\"".$fecha."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"fecha_fi\" value=\"".$fecha2."\"></td>";
					echo "<td>";
						echo "<select style=\"width:180px\" name=\"cliente\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select * from sgm_clients where visible=1 ";
							$sql = $sql."order by nombre";
							$result = mysql_query(convert_sql($sql));
							while ($row = mysql_fetch_array($result)) {
								if ($row["nombre"] == $_POST["cliente"]){
									echo "<option value=\"".$row["nombre"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
								} else {
									echo "<option value=\"".$row["nombre"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
								}
							}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"submit\" value=\"".$Buscar."\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			if ($_POST["fecha_inici"] != ""){
				echo "<br><br>";
				echo "<center>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:700px\">";
					echo "<tr style=\"background-color:silver;\">";
						echo "<td style=\"width:70px\"></td>";
						echo "<td style=\"width:50px\">".$Numero."</td>";
						if ($rowtipos["presu"] == 1) {
							echo "<td style=\"width:30px;text-align:center\">Ver.</td>";
						}
							echo "<td style=\"width:75px;text-align:center\">".$Fecha."</td>";
						if ($rowtipos["v_fecha_prevision"] == 1) {
							echo "<td style=\"width:75px;text-align:center\">".$Fecha." prev.</td>";
						}
						if ($rowtipos["v_fecha_vencimiento"] == 1) {
							echo "<td style=\"width:75px;text-align:center\">".$Vencimiento."</td>";
						}
						if ($rowtipos["v_numero_cliente"] == 1) {
							echo "<td style=\"width:130px;text-align:center\">Ref. Ped. Cli.</td>"; }
						if ($rowtipos["tpv"] == 0) { echo "<td style=\"width:250px;;text-align:center\">".$Cliente."</td>"; }
						if ($rowtipos["v_subtipos"] == 1) { echo "<td style=\"width:70px;text-align:center\"><em><center>".$Subtipo."</center></td>"; }
						echo "<td style=\"width:80px;text-align:center\"><em>".$Total."</em></td></tr>";
						$sql = "select * from sgm_cabezera where fecha between '".cambiarFormatoFechaYMD($_POST["fecha_inici"])."' and '".cambiarFormatoFechaYMD($_POST["fecha_fi"])."' and tipo=".$_GET["id"]." and visible=1";
						if ($_POST["cliente"]) { $sql = $sql." and nombre='".$_POST["cliente"]."'"; }
						if (($_GET["filtra"]  == 1) AND ($_POST["id_cliente"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente"]; }
						$sql = $sql." order by numero desc,version desc,fecha desc";
						$result = mysql_query(convert_sql($sql));
						$fechahoy = getdate();
						$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-100, $fechahoy["year"]));
						$hoy = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
						while ($row = mysql_fetch_array($result)) {
					#### OPCIONES DE VISUALIZACION SI SE MUESTRA O NO
							$ver = 0;
							if ($data1 <= $row["fecha"]) { $ver = 1; }
#							if (($_GET["id"] != 2) AND ($row["cobrada"] == 0)) { $ver = 1; }
#							if (($_GET["id"] == 2) AND ($row["cobrada"] == 1)) { $ver = 0; }
#							if (($_GET["id"] == 5) AND ($row["cerrada"] == 1)) { $ver = 0; }
							if (($data1 >= $row["fecha"]) AND ($_GET["id"] == 4) AND ($row["cerrada"] == 1)) { $ver = 0; }
							if ($ssoption == 1) { $ver = 1; }
							if ($ver == 1) {
							########## FECHAS AVISOS CERCANIA FECHA PREVISION
								$a = date("Y", strtotime($row["fecha_prevision"]));
								$m = date("m", strtotime($row["fecha_prevision"]));
								$d = date("d", strtotime($row["fecha_prevision"]));
								$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
								$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
								$color = "#FFFFFF";
								if ($rowtipos["v_numero_cliente"] == 0){
									if ($row["aprovado"] == 0) {
										$color = "#FF0000";
									} else {
										$color = "#00EC00";
									}
								}
								if ($rowtipos["tipo_ot"] == 1) {
									$color = "#FFFFFF";
									$fecha_aviso2 = $fecha_aviso;
									$sqlc = "select * from sgm_cuerpo where idfactura=".$row["id"]." and id_estado<>-1 order by  fecha_prevision";
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
									}
									if ($row["cerrada"] == 1) { $color = "#FFFFFF"; }
								} 
								if (($rowtipos["v_fecha_prevision"] == 1) and ($rowtipos["aprovado"] == 0) and ($rowtipos["v_subtipos"] == 0)) {
									$color = "#FF1515";
									if ($row["cerrada"] == 1) { $color = "#00EC00"; }
									if ($row["cobrada"] == 1) { $color = "#FFFFFF"; }
								}
								echo "<tr style=\"background-color : ".$color.";border-bottom : 1px dashed Black;\">";
									echo "<td><table cellpadding=\"0\" cellspacing=\"0\"><tr>";
										echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=600&id=".$row["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"Opciones\" style=\"width:70px\"></form></td>";
									echo "</tr></table></td>";
									echo "<td style=\"text-align:right\"><strong>".$row["numero"]."</strong></td>";
									if ($rowtipos["presu"] == 1) { echo "<td style=\"text-align:left\"><strong>/".$row["version"]."</strong></td>"; }
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
										echo "<td style=\"text-align:center;\"><strong>".cambiarFormatoFechaDMY($row["fecha"])."</strong></td>";
									} else { 
										if ($fecha_proxima > $date1) {
											$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
											if ($fecha_aviso <  $date1) {
												echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
											} else {
												echo "<td style=\"text-align:center;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
											}
										} else {
											echo "<td style=\"background-color:red;color:White;text-align:center;\">I: ".cambiarFormatoFechaDMY($row["fecha"])."<br><strong>P: ".cambiarFormatoFechaDMY($fecha_proxima)."</strong></td>";
										}
									}
									if ($rowtipos["v_fecha_prevision"] == 1) { echo "<td style=\"text-align:center;\">".cambiarFormatoFechaDMY($row["fecha_prevision"])."</td>"; }
									if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<td style=\"text-align:center;\">".cambiarFormatoFechaDMY($row["fecha_vencimiento"])."</td>"; }
									if ($rowtipos["v_numero_cliente"] == 1) { echo "<td>".$row["numero_cliente"]."</td>"; }
									if ($rowtipos["tpv"] == 0) {
									if (strlen($row["nombre"]) > 25) {
										echo "<td><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1003\" style=\"color:black;\">".substr($row["nombre"],0,25)." ...</a></td>";
									} else {
										echo "<td><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1003\" style=\"color:black;\">".$row["nombre"]."</a></td>";
									}
									if ($rowtipos["v_subtipos"] == 1) {
										echo "<td>";
										echo "<select style=\"width:70px\" name=\"subtipo\" disabled>";
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
									} else {
									}
								}
								echo "<td style=\"text-align : right;\">".number_format ($row["total"],2)." €</td>";
								echo "<td style=\"width:50px\"><form method=\"post\" action=\"index.php?op=1003&sop=22&id=".$row["id"]."&id_tipo=".$_GET["id"]."\"><input type=\"Submit\" value=\"".$Editar."\" style=\"width:70px\"></form></td>";
								if ($rowtipos["tpv"] == 0) {
									echo "<form method=\"post\" action=\"index.php?op=1003&sop=12&id=".$row["id"]."&id_tipo=".$_GET["id"]."\">";
									echo "<td style=\"width:50px\"><input type=\"Submit\" value=\"Imp. (".$row["print"].")\"></td>";
									echo "</form>";
								}
								if ($rowtipos["tpv"] == 1) {
									echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-tiquet-print.php?id=".$row["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
									echo "<td style=\"width:50px\"><input type=\"Submit\" value=\"Imp. (".$row["print"].")\"></td>";
									echo "</form>";
								}
								echo "<td><table cellpadding=\"0\" cellspacing=\"0\"><tr><td>";
								if ($rowtipos["v_recibos"] == 1)  {
									echo "<td>";
									echo "<form method=\"post\" action=\"index.php?op=1003&sop=200&id=".$row["id"]."\"><input type=\"Submit\" value=\"".$Recibos."\" style=\"width:50px\"></form>";
									echo "</td><td style=\"width:100px;text-align:right;\">";
									$sqlr = "select SUM(total) as total from sgm_recibos where visible=1 and id_factura=".$row["id"]." order by numero desc, numero_serie desc";
									$resultr = mysql_query(convert_sql($sqlr));
									$rowr = mysql_fetch_array($resultr);
									echo "".number_format(($row["total"]-$rowr["total"]), 3, '.', '')." €";
									echo "</td>";
								} else { 
									echo "<td></td>";
									echo "<td></td>";
								}
								echo "</td>";
							echo "</tr></table></td>";
						echo "</tr>";
						}
					}
					echo "<tr><td>&nbsp;</td></tr>";
					echo "<tr style=\"background-color:silver\">";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td style=\"width:100px;text-align:center;\">".$Base." Imp.</td>";
						echo "<td style=\"width:100px;text-align:center;\">I.V.A.</td>";
						echo "<td style=\"width:100px;text-align:center;\">".$Total."</td>";
						echo "<td style=\"width:60px;text-align:center;\">%</td>";
					echo "</tr>";
					$base_imp = 0;
					$iva = 0;
					$total = 0;
					$sql = "select * from sgm_cabezera where fecha between '".cambiarFormatoFechaYMD($_POST["fecha_inici"])."' and '".cambiarFormatoFechaYMD($_POST["fecha_fi"])."' and tipo=".$_GET["id"];
					if ($_POST["cliente"]) { $sql = $sql." and nombre='".$_POST["cliente"]."'"; }
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)){
						if ($row["subtotaldescuento"] != ""){
							$base_imp = $base_imp + $row["subtotaldescuento"];
						} else {
							$base_imp = $base_imp + $row["subtotal"];
						}
						$iva = $iva + ($row["total"] - $row["subtotal"]);
						$total = $total + $row["total"];
					}
					echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td style=\"text-align:right;\">".number_format ($base_imp,2)."</td>";
						echo "<td style=\"text-align:right;\">".$iva."</td>";
						echo "<td style=\"text-align:right;\">".number_format ($total,2)."</td>";
						$total2 = 0;
						$sqlp = "select * from sgm_cabezera where fecha between '".cambiarFormatoFechaYMD($_POST["fecha_inici"])."' and '".cambiarFormatoFechaYMD($_POST["fecha_fi"])."' and tipo=".$_GET["id"]." and visible=1";
						$resultp = mysql_query(convert_sql($sqlp));
						while ($rowp = mysql_fetch_array($resultp)){
							$total2 = $total2 + $rowp["total"];
						}
						$percentage=($total*100)/$total2;
						echo "<td style=\"text-align:right;\">".number_format ($percentage,3)."</td>";
						echo "<td></td>";
					echo "</tr>";
				echo "</table></center>";
			}
		echo "</td><td style=\"vertical-align:top;width:50%;\">";
			echo "<center><table cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td>Año</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=110&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td><select name=\"any\" style=\"width:90px\">";
						echo "<option value=\"2012\">2012</option>";
						echo "<option value=\"2013\">2013</option>";
						echo "<option value=\"2014\">2014</option>";
						echo "<option value=\"2015\">2015</option>";
						echo "<option value=\"2016\">2016</option>";
						echo "<option value=\"2017\">2017</option>";
						echo "<option value=\"2018\">2018</option>";
						echo "<option value=\"2019\">2019</option>";
						echo "<option value=\"2020\">2020</option>";
						echo "<option value=\"2021\">2021</option>";
						echo "<option value=\"2022\">2022</option>";
						echo "<option value=\"2023\">2023</option>";
						echo "<option value=\"2024\">2024</option>";
						echo "<option value=\"2025\">2025</option>";
						echo "<option value=\"2026\">2026</option>";
						echo "<option value=\"2027\">2027</option>";
						echo "<option value=\"2028\">2028</option>";
						echo "<option value=\"2029\">2029</option>";
						echo "<option value=\"2030\">2030</option>";
					echo "</select></td>";
					echo "<td><input type=\"submit\" value=\"".$Buscar."\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			if ($_POST["any"] != ""){
				echo "<br><br>";
				echo "<table cellspacing=\"0\">";
					echo "<tr style=\"background-color:silver\">";
						echo "<td style=\"width:100px;text-align:left;\">".$Mes."</td>";
						echo "<td style=\"width:100px;text-align:left;\">".$Base_imponible."</td>";
						echo "<td style=\"width:100px;text-align:left;\">I.V.A.</td>";
						echo "<td style=\"width:100px;text-align:left;\">".$Total."</td>";
					echo "</tr>";
					$base_total = 0;
					$iva_total = 0;
					$total_total = 0;
					$i = 1;
					$base_tri = 0;
					$iva_tri = 0;
					$total_tri = 0;
					echo "<tr>Año : ".$_POST["any"]."</tr>";
				for ($mes = 1; $mes <= 12; $mes++){
					$base_imp = 0;
					$iva = 0;
					$total = 0;
					if ($mes < 10) {$mesi = "0".$mes;} else {$mesi = $mes;}
					$sql = "select * from sgm_cabezera where fecha between '".$_POST["any"]."-".$mesi."-01' and '".$_POST["any"]."-".$mesi."-31' and tipo=".$_GET["id"];
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)){
						if ($row["subtotaldescuento"] != ""){
							$base_imp = $base_imp + $row["subtotaldescuento"];
						} else {
							$base_imp = $base_imp + $row["subtotal"];
						}
						$iva = $iva + ($row["total"] - $row["subtotal"]);
						$total = $total + $row["total"];
					}
					echo "<tr>";
						if ($mes == 1) {$meso = "Enero";}
						if ($mes == 2) {$meso = "Febrero";}
						if ($mes == 3) {$meso = "Marzo";}
						if ($mes == 4) {$meso = "Abril";}
						if ($mes == 5) {$meso = "Mayo";}
						if ($mes == 6) {$meso = "Junio";}
						if ($mes == 7) {$meso = "Julio";}
						if ($mes == 8) {$meso = "Agosto";}
						if ($mes == 9) {$meso = "Septiembre";}
						if ($mes == 10) {$meso = "Octubre";}
						if ($mes == 11) {$meso = "Noviembre";}
						if ($mes == 12) {$meso = "Diciembre";}
						echo "<td>".$meso."</td>";
						echo "<td>".$base_imp."</td>";
						echo "<td>".$iva."</td>";
						echo "<td>".$total."</td>";
						echo "<td></td>";
					echo "</tr>";
					$base_tri = $base_tri + $base_imp;
					$iva_tri = $iva_tri + $iva;
					$total_tri = $total_tri + $total;
					if ($i == 3){
						echo "<tr>";
							echo "<td><strong>".$Total." ".$Trimestre."</strong></td>";
							echo "<td><strong>".$base_tri."</strong></td>";
							echo "<td><strong>".$iva_tri."</strong></td>";
							echo "<td><strong>".$total_tri."</strong></td>";
						echo "</tr>";
						$i = 0;
						$base_tri = 0;
						$iva_tri = 0;
						$total_tri = 0;
					}
					$i++;
					$base_total = $base_total + $base_imp;
					$iva_total = $iva_total + $iva;
					$total_total = $total_total + $total;
				}
					echo "<tr><td>&nbsp;</td></tr><tr>";
						echo "<td><strong>".$Total."</strong></td>";
						echo "<td><strong>".$base_total."</strong></td>";
						echo "<td><strong>".$iva_total."</strong></td>";
						echo "<td><strong>".$total_total."</strong></td>";
						echo "<td></td>";
					echo "</tr>";
				echo "</table></center>";
			}
		echo "</td></tr></table>";
	}

	if ($soption == 120) {
			echo "<br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td>".$Usuario."</td>";
				echo "<td>".$Total."</td>";
			echo "</tr>";
			$sqls= "select * from sgm_users where activo=1 and validado=1 and sgm=1 order by usuario";
			$results = mysql_query(convert_sql($sqls));
			while ($rows = mysql_fetch_array($results)) {
				$sqlf= "select sum(total) as totales from sgm_cabezera where visible=1 and tipo=5 and id_pagador = ".$rows["id"];
				$resultf = mysql_query(convert_sql($sqlf));
				$rowf = mysql_fetch_array($resultf);
				echo "<tr>";
					echo "<td style=\"text-align:left;width:150px\"><a href=\"index.php?op=1003&sop=100&iduser=".$rows["id"]."&filtra=1\">".$rows["usuario"]."</a></td>";
					echo "<td style=\"text-align:right;width:100px\">".number_format($rowf["totales"], 2, ',', '.')." €</td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 200) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_cabezera where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			### COPIA CABEZERA PLANTILLA
			$sql = "insert into sgm_recibos (numero,numero_serie,id_factura,fecha,fecha_vencimiento,nombre,nif,direccion,poblacion,cp,provincia,onombre,onif,odireccion,opoblacion,ocp,oprovincia,total,id_cliente,id_user,id_tipo_pago,cobrada) ";
			$sql = $sql."values (";
			$sqlxx = "select * from sgm_recibos where visible=1 and id_factura=".$_GET["id"]." order by numero desc,numero_serie desc";
			$resultxx = mysql_query(convert_sql($sqlxx));
			$rowxx = mysql_fetch_array($resultxx);
			$numero = $rowxx["numero"] + 1;
			$numero_serie = $rowxx["numero_serie"] + 1;
			$sql = $sql."".$numero."";
			$sql = $sql.",".$numero_serie."";
			$sql = $sql.",".$_GET["id"];
			$sql = $sql.",'".cambiarFormatoFechaYMD($_POST["fecha_emision"])."'";
			$sql = $sql.",'".cambiarFormatoFechaYMD($_POST["fecha_vencimiento"])."'";
			$sql = $sql.",'".$row["nombre"]."'";
			$sql = $sql.",'".$row["nif"]."'";
			$sql = $sql.",'".$row["direccion"]."'";
			$sql = $sql.",'".$row["poblacion"]."'";
			$sql = $sql.",'".$row["cp"]."'";
			$sql = $sql.",'".$row["provincia"]."'";
			$sql = $sql.",'".$row["onombre"]."'";
			$sql = $sql.",'".$row["onif"]."'";
			$sql = $sql.",'".$row["odireccion"]."'";
			$sql = $sql.",'".$row["opoblacion"]."'";
			$sql = $sql.",'".$row["ocp"]."'";
			$sql = $sql.",'".$row["oprovincia"]."'";
			$sql = $sql.",".$_POST["total"]."";
			$sql = $sql.",".$row["id_cliente"]."";
			$sql = $sql.",".$row["id_user"]."";
			$sql = $sql.",".$_POST["id_tipo_pago"]."";
			$sql = $sql.",".$_POST["cobrada"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
			## COMPRUEBA SI ESTAN LOS RECIBOS REALIZADOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"];
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$sql = "update sgm_cabezera set recibos=1 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set recibos=0 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			}
			## COMPRUEBA SI ESTA COBRADA O NO A PARTIR DE LOS RECIBOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"]." and cobrada=1";
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$sql = "update sgm_cabezera set cobrada=1 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set cobrada=0 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 2) {
			$sql = "update sgm_recibos set ";
			$sql = $sql."numero_serie=".$_POST["numero_serie"]."";
			$sql = $sql.",fecha='".cambiarFormatoFechaYMD($_POST["fecha_emision"])."'";
			$sql = $sql.",fecha_vencimiento='".cambiarFormatoFechaYMD($_POST["fecha_vencimiento"])."'";
			$sql = $sql.",total=".$_POST["total"]."";
			$sql = $sql.",id_tipo_pago=".$_POST["id_tipo_pago"]."";
			$sql = $sql.",cobrada=".$_POST["cobrada"]."";
			$sql = $sql." WHERE id=".$_GET["id_recibo"]."";
			mysql_query(convert_sql($sql));
			$sql = "select * from sgm_cabezera where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			## COMPRUEBA SI ESTAN LOS RECIBOS REALIZADOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"];
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$sql = "update sgm_cabezera set recibos=1 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set recibos=0 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			}
			## COMPRUEBA SI ESTA COBRADA O NO A PARTIR DE LOS RECIBOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"]." and cobrada=1";
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$sql = "update sgm_cabezera set cobrada=1 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set cobrada=0 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_recibos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_recibo"]."";
			mysql_query(convert_sql($sql));
			
			$sql = "select * from sgm_cabezera where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			
			## COMPRUEBA SI ESTAN LOS RECIBOS REALIZADOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"];
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$sql = "update sgm_cabezera set recibos=1 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set recibos=0 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			}
			## COMPRUEBA SI ESTA COBRADA O NO A PARTIR DE LOS RECIBOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$row["id"]." and cobrada=1";
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $row["total"]) {
				$sql = "update sgm_cabezera set cobrada=1 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set cobrada=0 WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sql));
			}
		}

		$sqlf = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
		$sqlc = "select * from sgm_clients where id=".$rowf["id_cliente"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqltipos = "select * from sgm_factura_tipos where id=".$rowf["tipo"];
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		echo "<table><tr><td style=\"vertical-align:top;width:250px;\">";
			echo "<strong>".$Recibos."</strong>";
			echo "<br>";
			echo "<br><strong>".$rowtipos["tipo"]."</strong> : ".$rowf["numero"];
			echo "<br><strong>".$Fecha."</strong> : ".cambiarFormatoFechaDMY($rowf["fecha"]);
			echo "<br><strong>".$Importe."</strong> : ".number_format($rowf["total"], 2, ',', '.')." €";
			echo "</td><td style=\"text-align:left;vertical-align:top;\">";
			echo "<br><strong>".$Cliente."</strong> : ".$rowc["nombre"];
			echo "<br>".$Entidad." ".$Bancaria." : ".$rowc["entidadbancaria"];
			echo "<br>".$Direccion." ".$Entidad." : ".$rowc["domiciliobancario"];
			echo "<br>".$Numero." de ".$Cuenta." : ".$rowc["cuentabancaria"];
			echo "<br><strong>".$Factura." el ".$diaa." </strong> : ".$rowc["dia_facturacion"];
			echo "<br><strong>".$Vencimiento." a</strong> : ".$rowc["dias_vencimiento"];
			if ($rowc["dias"] == 1) { echo " día/s naturales"; }
			if ($rowc["dias"] == 0) { echo " mes/es naturales"; }
		echo "</td></tr></table>";
		echo "<br><br>";
		echo "<center><table border=\"0px\" cellpadding=\"0\">";
			echo "<tr>";
				$sqlrecs = "select * from sgm_recibos order by numero";
				$resulrecs = mysql_query(convert_sql($sqlrecs));
				$rowrecs = mysql_fetch_array($resultrecs);
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\">".$Fecha."<br>".$Emision."</td>";
				echo "<td style=\"text-align:center;\">".$Fecha."<br>".$Vencimiento."</td>";
				echo "<td style=\"text-align:center;\">".$Importe."</td>";
				echo "<td style=\"text-align:center;\">".$Tipo." ".$Pago."</td>";
				echo "<td style=\"text-align:center;\">".$Cobrado."</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1003&sop=200&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><strong>Fact.</strong></td>";
				echo "<td><strong>".$Serie."</strong></td>";
				echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"fecha_emision\" value=\"".cambiarFormatoFechaDMY(date("Y-m-d"))."\"></td>";
				$sqlt = "select count(*) as total from sgm_clients_dias_recibos where id_cliente=".$rowc["id"]." order by dia";
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] == 0) {
					$a = date("Y", strtotime($rowf["fecha"]));
					$m = date("m", strtotime($rowf["fecha"]));
					$d = date("d", strtotime($rowf["fecha"]));
					if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$rowc["dias_vencimiento"], $a)); }
					if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+$rowc["dias_vencimiento"] ,$d, $a)); }
				} else {
					$sqlz = "select * from sgm_clients_dias_recibos where id_cliente=".$rowc["id"]." order by dia";
					$resultz = mysql_query(convert_sql($sqlz));
					while ($rowz = mysql_fetch_array($resultz)) {
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
				echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"fecha_vencimiento\" value=\"".cambiarFormatoFechaDMY($fecha_vencimiento)."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"total\" value=\"".$rowf["total"]."\"></td>";
				echo "<td><select name=\"id_tipo_pago\" style=\"width:90px\">";
				echo "<option value=\"0\">".$Pendiente."</option>";
				$sqlfp = "select * from sgm_tpv_tipos_pago order by tipo";
				$resultfp = mysql_query(convert_sql($sqlfp));
				while ($rowfp = mysql_fetch_array($resultfp)) {
					if ($rowfp["id"] == $row["id_tipo_pago"]) {
						echo "<option value=\"".$rowfp["id"]."\" selected>".$rowfp["tipo"]."</option>";
					} else {
						echo "<option value=\"".$rowfp["id"]."\">".$rowfp["tipo"]."</option>";
					}
				}
				echo "</select></td>";
				echo "<td><select name=\"cobrada\">";
					echo "<option value=\"0\" selected>NO</option>";
					echo "<option value=\"1\">SI</option>";
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Nuevo."\" style=\"width:60px;\"></td>";
				echo "</form>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sqlr = "select * from sgm_recibos where visible=1 and id_factura=".$_GET["id"]." order by numero desc, numero_serie desc";
			$resultr = mysql_query(convert_sql($sqlr));
			while ($rowr = mysql_fetch_array($resultr)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=200&ssop=2&id=".$_GET["id"]."&id_recibo=".$rowr["id"]."\" method=\"post\">";
					echo "<td><a href=\"index.php?op=1003&sop=201&id=".$_GET["id"]."&id_recibo=".$rowr["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
					echo "<td><strong>".$rowf["numero"]."</strong>/</td>";
					echo "<td><input type=\"Text\" style=\"width:25px;\" name=\"numero_serie\" value=\"".$rowr["numero_serie"]."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"fecha_emision\" value=\"".cambiarFormatoFechaDMY($rowr["fecha"])."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"fecha_vencimiento\" value=\"".cambiarFormatoFechaDMY($rowr["fecha_vencimiento"])."\"></td>";
					echo "<td><input type=\"Text\" style=\"width:75px;\" name=\"total\" value=\"".$rowr["total"]."\"></td>";
					echo "<td><select name=\"id_tipo_pago\" style=\"width:90px\">";
						echo "<option value=\"0\">Pendiente</option>";
						$sqlfp = "select * from sgm_tpv_tipos_pago order by tipo";
						$resultfp = mysql_query(convert_sql($sqlfp));
						while ($rowfp = mysql_fetch_array($resultfp)) {
							if ($rowfp["id"] == $rowr["id_tipo_pago"]) {
								echo "<option value=\"".$rowfp["id"]."\" selected>".$rowfp["tipo"]."</option>";
							} else {
								echo "<option value=\"".$rowfp["id"]."\">".$rowfp["tipo"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select name=\"cobrada\">";
						if ($rowr["cobrada"] == 0) { 
							echo "<option value=\"0\" selected>NO</option>";
							echo "<option value=\"1\">SI</option>";
						}
						if ($rowr["cobrada"] == 1) { 
							echo "<option value=\"0\">NO</option>";
							echo "<option value=\"1\" selected>SI</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:60px;\"></td>";
					echo "</form>";
					echo "<td><form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-facturas-recibo-print.php?id=".$rowr["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
					echo "<input type=\"Submit\" value=\"".$Imprimir."\"></form>";
					echo "</td>";
					$sqlx = "select * from sgm_clients where id=".$rowf["id_cliente"];
					$resultx = mysql_query(convert_sql($sqlx));
					$rowx = mysql_fetch_array($resultx);
					if (($rowx["cuentabancaria"] != "") and ($rowr["id_tipo_pago"] == 4)) {
						echo "<td><a href=\"index.php?op=1003&sop=9999&id_factura=".$rowr["id_factura"]."\">*</a></td>";
					} else { 
						echo "<td></td><td></td>";
					}
				echo "</tr>";
			}
		echo "</table></center>";
		echo "<br><br>";
	}

	if ($soption == 201) {
		echo "<br><br>¿Seguro que desea eliminar este recibo?";
		echo "<br><br><a href=\"index.php?op=1003&sop=200&ssop=3&id=".$_GET["id"]."&id_recibo=".$_GET["id_recibo"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1003&sop=200&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if ($soption == 300) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_factura_subtipos (id_tipo,subtipo) ";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id_tipo"]."";
			$sql = $sql.",'".$_POST["subtipo"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_factura_subtipos set ";
			$sql = $sql."subtipo='".$_POST["subtipo"]."'";
			$sql = $sql." WHERE id=".$_GET["id_subtipo"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_factura_subtipos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Administracion." ".$Subtipos." :</strong><br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center><table>";
		$sqltipos = "select * from sgm_factura_tipos where visible=1 order by tipo";
		$resulttipos = mysql_query(convert_sql($sqltipos));
		while ($rowtipos = mysql_fetch_array($resulttipos)) {
			echo "<form action=\"index.php?op=1003&sop=300&ssop=1&id_tipo=".$rowtipos["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td>".$rowtipos["tipo"]."</td>";
				echo "<td><input type=\"text\" name=\"subtipo\"></td>";
				echo "<td><input type=\"submit\" style=\"width:100px;\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			$sqlstipos = "select * from sgm_factura_subtipos where visible=1 and id_tipo=".$rowtipos["id"]." order by subtipo";
			$resultstipos = mysql_query(convert_sql($sqlstipos));
			while ($rowstipos = mysql_fetch_array($resultstipos)) {
				echo "<form action=\"index.php?op=1003&sop=300&ssop=2&id_subtipo=".$rowstipos["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=302&id=".$rowstipos["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
					echo "<td><input type=\"text\" value=\"".$rowstipos["subtipo"]."\" name=\"subtipo\"></td>";
					echo "<td><input type=\"submit\" style=\"width:100px;\" value=\"".$Modificar."\"></td>";
				echo "</tr>";
				echo "</form>";
			}
		}
		echo "</table></center><br>";
	}

	if ($soption == 302) {
		echo "<br><br>¿Seguro que desea eliminar este tipo?";
		echo "<br><br><a href=\"index.php?op=1003&sop=300&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=300\">[ NO ]</a>";
	}

	if ($soption == 310){
		if (($ssoption == 1) and ($admin == true)) {
			$sql = "select count(*) as total from sgm_dades_origen_factura";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] == 0){
				$sql = "insert into sgm_dades_origen_factura (nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,notas) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["nombre"]."'";
				$sql = $sql.",'".$_POST["nif"]."'";
				$sql = $sql.",'".$_POST["direccion"]."'";
				$sql = $sql.",'".$_POST["poblacion"]."'";
				$sql = $sql.",'".$_POST["cp"]."'";
				$sql = $sql.",'".$_POST["provincia"]."'";
				$sql = $sql.",'".$_POST["mail"]."'";
				$sql = $sql.",'".$_POST["telefono"]."'";
				$sql = $sql.",'".$_POST["notas"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
			if ($row["total"] == 1) {
				$sql = "update sgm_dades_origen_factura set ";
				$sql = $sql."nombre='".$_POST["nombre"]."'";
				$sql = $sql.",nif='".$_POST["nif"]."'";
				$sql = $sql.",direccion='".$_POST["direccion"]."'";
				$sql = $sql.",poblacion='".$_POST["poblacion"]."'";
				$sql = $sql.",cp='".$_POST["cp"]."'";
				$sql = $sql.",provincia='".$_POST["provincia"]."'";
				$sql = $sql.",mail='".$_POST["mail"]."'";
				$sql = $sql.",telefono='".$_POST["telefono"]."'";
				$sql = $sql.",notas='".$_POST["notas"]."'";
				mysql_query(convert_sql($sql));
			}
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "insert into sgm_dades_origen_factura_iban(id_dades_origen_factura,entidad_bancaria,iban,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_GET["id"]."'";
			$sql = $sql.",'".$_POST["entidad_bancaria"]."'";
			$sql = $sql.",'".$_POST["iban"]."'";
			$sql = $sql.",'".$_POST["descripcion"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_dades_origen_factura_iban set ";
			$sql = $sql."entidad_bancaria='".$_POST["entidad_bancaria"]."'";
			$sql = $sql.",iban='".$_POST["iban"]."'";
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 4) and ($admin == true)) {
			$sql = "delete from sgm_dades_origen_factura_iban WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 5) and ($admin == true)) {
			$sql = "update sgm_dades_origen_factura_iban set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_dades_origen_factura_iban set ";
			$sql = $sql."predefinido = 1";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 6) and ($admin == true)) {
			$sql = "update sgm_dades_origen_factura_iban set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Administracion." ".$Datos." ".$Origen." :</strong>";
		echo "<br>";
		echo "<table><tr>";
			echo "<td  class=menu>";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table><br>";
		echo "<br>";
		echo "<table><tr>";
			echo "<td style=\"vertical-align:top;width:40%\">";
				$sql = "select * from sgm_dades_origen_factura";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<table>";
				echo "<form action=\"index.php?op=1003&sop=310&ssop=1\" method=\"post\">";
					echo "<tr><td>".$Nombre."</td><td><input type=\"Text\" name=\"nombre\" style=\"width:300px\" value=\"".$row["nombre"]."\"></td></tr>";
					echo "<tr><td>NIF</td><td><input type=\"Text\" name=\"nif\" style=\"width:300px\" value=\"".$row["nif"]."\"></td></tr>";
					echo "<tr><td>".$Direccion."</td><td><input type=\"Text\" name=\"direccion\" style=\"width:300px\" value=\"".$row["direccion"]."\"></td></tr>";
					echo "<tr><td>".$Poblacion."</td><td><input type=\"Text\" name=\"poblacion\" style=\"width:300px\" value=\"".$row["poblacion"]."\"></td></tr>";
					echo "<tr><td>".$Codigo." ".$Postal."</td><td><input type=\"Text\" name=\"cp\" style=\"width:300px\" value=\"".$row["cp"]."\"></td></tr>";
					echo "<tr><td>".$Provincia."</td><td><input type=\"Text\" name=\"provincia\" style=\"width:300px\" value=\"".$row["provincia"]."\"></td></tr>";
					echo "<tr><td>".$Email."</td><td><input type=\"Text\" name=\"mail\" style=\"width:300px\" value=\"".$row["mail"]."\"></td></tr>";
					echo "<tr><td>".$Telefono."</td><td><input type=\"Text\" name=\"telefono\" style=\"width:300px\" value=\"".$row["telefono"]."\"></td></tr>";
					echo "<tr><td>".$Notas."</td><td><textarea name=\"notas\" style=\"width:300px\" rows=\"6\">".$row["notas"]."</textarea></td></tr>";
					echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:150px\"></td></tr>";
				echo "</form>";
				echo "</table>";
			echo "</td>";
			echo "<td style=\"vertical-align:top;width:60%\">";
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
					echo "<tr style=\"background-color : Silver;\">";
						echo "<td style=\"text-align:center;\"></td>";
						echo "<td style=\"text-align:center;\">".$Eliminar."</td>";
						echo "<td style=\"text-align:center;width:250px\">".$Entidad." ".$Bancaria."</td>";
						echo "<td style=\"text-align:center;width:250px\">IBAN</td>";
						echo "<td style=\"text-align:center;width:250px\">".$Descripcion."</td>";
						echo "<td style=\"text-align:center;\"></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=310&ssop=2&id=".$row["id"]."\" method=\"post\">";
						echo "<td style=\"text-align:center;\"></td>";
						echo "<td style=\"text-align:center;\"></td>";
						echo "<td><input type=\"Text\" name=\"entidad_bancaria\" style=\"width:200px\"></td>";
						echo "<td><input type=\"Text\" name=\"iban\" style=\"width:200px\"></td>";
						echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:200px\"></td>";
						echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
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
					echo "<form action=\"index.php?op=1003&sop=310&ssop=6&id=".$row2["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"Despred.\" style=\"width:100px\">";
					echo "</form>";
					echo "<td></td>";
				}
				if ($row2["predefinido"] == 0) {
					echo "<form action=\"index.php?op=1003&sop=310&ssop=5&id=".$row2["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"Pred.\" style=\"width:100px\">";
					echo "</form>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=311&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				}
						echo "<form action=\"index.php?op=1003&sop=310&ssop=3&id=".$row2["id"]."\" method=\"post\">";
#							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=311&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
							echo "<td><input type=\"Text\" name=\"entidad_bancaria\" style=\"width:200px\" value=\"".$row2["entidad_bancaria"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"iban\" style=\"width:200px\" value=\"".$row2["iban"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:200px\" value=\"".$row2["descripcion"]."\"></td>";
							echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
						echo "</form>";
						echo "</tr>";
					}
				echo "</table>";
			echo "</td>";
		echo "</tr></table>";
	}

	if (($soption == 311) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Desea eliminar este IBAN?";
		echo "<br><br><a href=\"index.php?op=1003&sop=310&ssop=4&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1003&sop=310\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 400) {
		echo "<strong>".$Administracion." ".$Permisos." :</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td class=menu>";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">".$Volver."</a>";
			echo "</td>";
			echo "<td class=menu>";
				echo "<a href=\"index.php?op=1003&sop=400&tip=1\" style=\"color:white;\">".$Ver." ".$por." ".$Tipo."</a>";
			echo "</td>";
			echo "<td class=menu>";
				echo "<a href=\"index.php?op=1003&sop=400&tip=2\" style=\"color:white;\">".$Ver." ".$por." ".$Usuario."</a>";
			echo "</td>";
		echo "</tr></table>";
	}

	if (($soption == 400) and ($_GET["tip"] == 1)) {
		if (($ssoption == 1) and ($admin == true)) {
			$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$_GET["id_tipo"]." and id_user=".$_POST["id_user"];
			$resultpermiso = mysql_query(convert_sql($sqlpermiso));
			$rowpermiso = mysql_fetch_array($resultpermiso);
			if ($rowpermiso["total"] == 0) { 
				$sql = "insert into sgm_factura_tipos_permisos (id_user,id_tipo,admin) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["id_user"];
				$sql = $sql.",".$_GET["id_tipo"];
				$sql = $sql.",".$_POST["admin"];
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$_POST["id_tipo"]." and id_user=".$_POST["id_user"];
				$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
				$rowpermiso2 = mysql_fetch_array($resultpermiso2);
				$sql = "update sgm_factura_tipos_permisos set ";
				$sql = $sql."admin=".$_POST["admin"];
				$sql = $sql." WHERE id=".$rowpermiso2["id"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_factura_tipos_permisos set ";
			$sql = $sql."admin=".$_POST["admin"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "delete from sgm_factura_tipos_permisos WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}

		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr>";
				echo "<td style=\"text-align:center;\">".$Tipo."</td>";
				echo "<td style=\"text-align:center;\">".$Eliminar."</td>";
				echo "<td style=\"text-align:center;\">".$Usuario."</td>";
				echo "<td style=\"text-align:center;\">Admin.</td>";
			echo "</tr>";
			$sql = "select * from sgm_factura_tipos where visible=1 order by tipo";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr style=\"background-color : Silver;\">";
				echo "<form action=\"index.php?op=1003&sop=400&tip=1&ssop=1&id_tipo=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"width:150px\">".$row["tipo"]."</td>";
					echo "<td></td>";
					echo "<td><select name=\"id_user\" style=\"width:150px\">";
						echo "<option value=\"0\">-</option>";
						$sqlx = "select * from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
						$resultx = mysql_query(convert_sql($sqlx));
						while ($rowx = mysql_fetch_array($resultx)) {
							echo "<option value=\"".$rowx["id"]."\">".$rowx["usuario"]."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"admin\" style=\"width:80px\">";
						echo "<option value=\"0\" selected>No</option>";
						echo "<option value=\"1\">Si</option>";
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "</tr>";
				$sql2 = "select * from sgm_factura_tipos_permisos where visible=1 and id_tipo=".$row["id"];
				$result2 = mysql_query(convert_sql($sql2));
				while ($row2 = mysql_fetch_array($result2)) {
					$sqlv = "select * from sgm_users where id=".$row2["id_user"];
					$resultv = mysql_query(convert_sql($sqlv));
					$rowv = mysql_fetch_array($resultv);
					echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=400&tip=1&ssop=2&id=".$row2["id"]."\" method=\"post\">";
						echo "<td></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=401&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
						echo "<td>".$rowv["usuario"]."</td>";
						echo "<td><select name=\"admin\" style=\"width:80px\">";
						if ($row2["admin"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row2["admin"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
						echo "</select></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
					echo "</tr>";
				}
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 401) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Desea eliminar el permiso seleccionado?";
		echo "<br><br><a href=\"index.php?op=1003&sop=400&tip=1&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1003&sop=400&tip=1\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 400) and ($_GET["tip"] == 2)) {
		if (($ssoption == 1) and ($admin == true)) {
			$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$_POST["id_tipo"]." and id_user=".$_GET["id_user"];
			$resultpermiso = mysql_query(convert_sql($sqlpermiso));
			$rowpermiso = mysql_fetch_array($resultpermiso);
			if ($rowpermiso["total"] == 0) { 
				$sql = "insert into sgm_factura_tipos_permisos (id_user,id_tipo,admin) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_user"];
				$sql = $sql.",".$_POST["id_tipo"];
				$sql = $sql.",".$_POST["admin"];
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				$sqlpermiso2 = "select * from sgm_factura_tipos_permisos where id_tipo=".$_POST["id_tipo"]." and id_user=".$_POST["id_user"];
				$resultpermiso2 = mysql_query(convert_sql($sqlpermiso2));
				$rowpermiso2 = mysql_fetch_array($resultpermiso2);
				$sql = "update sgm_factura_tipos_permisos set ";
				$sql = $sql."admin=".$_POST["admin"];
				$sql = $sql." WHERE id=".$rowpermiso2["id"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_factura_tipos_permisos set ";
			$sql = $sql."admin=".$_POST["admin"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "delete from sgm_factura_tipos_permisos WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}

		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr>";
				echo "<td style=\"text-align:center;\">".$Tipo."</td>";
				echo "<td style=\"text-align:center;\">".$Eliminar."</td>";
				echo "<td style=\"text-align:center;\">".$Usuario."</td>";
				echo "<td style=\"text-align:center;\">Admin.</td>";
			echo "</tr>";
			$sqlx = "select * from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
			$resultx = mysql_query(convert_sql($sqlx));
			while ($rowx = mysql_fetch_array($resultx)) {
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr style=\"background-color : Silver;\">";
				echo "<form action=\"index.php?op=1003&sop=400&tip=2&ssop=1&id_user=".$rowx["id"]."\" method=\"post\">";
					echo "<td style=\"width:150px\">".$rowx["usuario"]."</td>";
					echo "<td></td>";
					echo "<td><select name=\"id_tipo\" style=\"width:150px\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_factura_tipos where visible=1 order by tipo";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"admin\" style=\"width:80px\">";
					echo "<option value=\"0\" selected>No</option>";
					echo "<option value=\"1\">Si</option>";
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "</tr>";
				$sql2 = "select * from sgm_factura_tipos_permisos where id_user=".$rowx["id"];
				$result2 = mysql_query(convert_sql($sql2));
				while ($row2 = mysql_fetch_array($result2)) {
					$sqlv = "select * from sgm_factura_tipos where visible=1 and id=".$row2["id_tipo"];
					$resultv = mysql_query(convert_sql($sqlv));
					$rowv = mysql_fetch_array($resultv);
					echo "<tr>";
					echo "<form action=\"index.php?op=1003&sop=400&tip=2&ssop=2&id=".$row2["id"]."\" method=\"post\">";
						echo "<td></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=402&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
						echo "<td>".$rowv["tipo"]."</td>";
						echo "<td><select name=\"admin\" style=\"width:80px\">";
						if ($row2["admin"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row2["admin"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
						echo "</select></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
					echo "</tr>";
				}
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 402) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Desea eliminar el permiso seleccionado?";
		echo "<br><br><a href=\"index.php?op=1003&sop=400&tip=2&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1003&sop=400&tip=2\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 450) {
		echo "<strong>".$Logos." ".$Factura." :</strong><br><br>";
		echo "<table><tr>";
			echo "<td class=menu>";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		if ($ssoption == 1000) {
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
				if ($_GET["logo"] == 2){$archivo_name = "logo2.jpg";}
				if ($_GET["logo"] == 3){$archivo_name = "logo3.jpg";}
				if (copy ($archivo, "files/logos/".$archivo_name)) {
					echo "<center>";
					echo "<h2>Se ha transferido el archivo $archivo_name</h2>";
					echo "<br>Su tamaño es: $archivo_size bytes<br><br>";
					echo "Operación realizada correctamente.";
					echo "</center>";
					if ($_GET["logo"] == 1){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo1='".$archivo_name."'";
						mysql_query(convert_sql($sql));
					}
					if ($_GET["logo"] == 2){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo2='".$archivo_name."'";
						mysql_query(convert_sql($sql));
					}
					if ($_GET["logo"] == 3){
						$sql = "update sgm_dades_origen_factura set ";
						$sql = $sql."logo_ticket='".$archivo_name."'";
						mysql_query(convert_sql($sql));
					}
				}
			}else{
				echo "<h2>No ha podido transferirse el archivo.</h2>";
				echo "<h3>Su tamaño no puede exceder de ".$lim_tamano." bytes.</h2>";
			}
		}
		if ($ssoption == 1001) {
			echo "<center>";
			echo "¿Seguro que desea eliminar este archivo?";
			echo "<br><br><a href=\"index.php?op=1003&sop=450&ssop=1002&logo=".$_GET["logo"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=310\">[ NO ]</a>";
			echo "</center>";
		}
		if ($ssoption == 1002) {
			$sql = "update sgm_dades_origen_factura set ";
			if ($_GET["logo"] == 1){ $sql = $sql."logo1=''";}
			if ($_GET["logo"] == 2){ $sql = $sql."logo2=''";}
			if ($_GET["logo"] == 3){ $sql = $sql."logo_ticket=''";}
			mysql_query(convert_sql($sql));
			echo "<center>";
			echo "Operación realizada correctamente.";
			echo "</center>";
		}
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>Formulario de envio de archivos :</strong><br>límite de 250 Kb.<br>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sqlele = "select * from sgm_dades_origen_factura";
						$resultele = mysql_query(convert_sql($sqlele));
						$rowele = mysql_fetch_array($resultele);
						echo "<tr><td><strong>Logo Factura format no Sobre :</strong><br>dimensión recomendada 500x130 píxels.</td></tr>";
						if ($rowele["logo1"] != ""){
							echo "<tr>";
								echo "<td><a href=\"".$urlmgestion."/files/logos/".$rowele["logo1"]."\" target=\"_blank\"><strong>".$rowele["logo1"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td><a href=\"index.php?op=1003&sop=450&ssop=1001&logo=1\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
							echo "</tr>";
							echo "<tr><td><img src=\"files/logos/".$rowele["logo1"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1003&sop=450&ssop=1000&logo=1\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta FILES/LOGOS/\" style=\"width:200px\">";
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
						echo "<tr><td><strong>Logo Factura format Sobre :</strong><br>dimensión recomendada 200x130 píxels.</td></tr>";
						if ($rowele["logo2"] != ""){
							echo "<tr>";
								echo "<td><a href=\"".$urlmgestion."/files/logos/".$rowele["logo2"]."\" target=\"_blank\"><strong>".$rowele["logo2"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td><a href=\"index.php?op=1003&sop=450&ssop=1001&logo=2\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
							echo "</tr>";
							echo "<tr><td><img src=\"files/logos/".$rowele["logo2"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1003&sop=450&ssop=1000&logo=2\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta FILES/LOGOS/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sqlele = "select * from sgm_dades_origen_factura";
						$resultele = mysql_query(convert_sql($sqlele));
						$rowele = mysql_fetch_array($resultele);
						echo "<tr><td><strong>Logo Factura format Ticket :</strong><br>dimensión recomendada 50x50 píxels.</td></tr>";
						if ($rowele["logo_ticket"] != ""){
							echo "<tr>";
								echo "<td><a href=\"".$urlmgestion."/files/logos/".$rowele["logo_ticket"]."\" target=\"_blank\"><strong>".$rowele["logo_ticket"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td><a href=\"index.php?op=1003&sop=450&ssop=1001&logo=3\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
							echo "</tr>";
							echo "<tr><td><img src=\"files/logos/".$rowele["logo_ticket"]."\"></td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1003&sop=450&ssop=1000&logo=3\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"hidden\" name=\"id_tipo\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta FILES/LOGOS/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 500) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_factura_tipos (tipo,orden,descripcion,dias,facturable,tpv,caja,v_fecha_prevision,v_fecha_prevision_dias,v_fecha_vencimiento,v_numero_cliente,v_subtipos,v_pesobultos,v_recibos,tipo_ot,presu,presu_dias,stock,aprovado,v_rfq) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["tipo"]."'";
			$sql = $sql.",".$_POST["orden"];
			$sql = $sql.",'".$_POST["descripcion"]."'";
			$sql = $sql.",".$_POST["dias"];
			$sql = $sql.",".$_POST["facturable"];
			$sql = $sql.",".$_POST["tpv"];
			$sql = $sql.",".$_POST["caja"];
			$sql = $sql.",".$_POST["v_fecha_prevision"];
			$sql = $sql.",".$_POST["v_fecha_prevision_dias"];
			$sql = $sql.",".$_POST["v_fecha_vencimiento"];
			$sql = $sql.",".$_POST["v_numero_cliente"];
			$sql = $sql.",".$_POST["v_subtipos"];
			$sql = $sql.",".$_POST["v_pesobultos"];
			$sql = $sql.",".$_POST["v_recibos"];
			$sql = $sql.",".$_POST["tipo_ot"];
			$sql = $sql.",".$_POST["presu"];
			$sql = $sql.",".$_POST["presu_dias"];
			$sql = $sql.",".$_POST["stock"];
			$sql = $sql.",".$_POST["aprovado"];
			$sql = $sql.",".$_POST["v_rfq"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_factura_tipos set ";
			$sql = $sql."tipo='".$_POST["tipo"]."'";;
			$sql = $sql.",orden=".$_POST["orden"];
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";;
			$sql = $sql.",dias=".$_POST["dias"];
			$sql = $sql.",facturable=".$_POST["facturable"];
			$sql = $sql.",tpv=".$_POST["tpv"];
			$sql = $sql.",caja=".$_POST["caja"];
			$sql = $sql.",v_fecha_prevision=".$_POST["v_fecha_prevision"];
			$sql = $sql.",v_fecha_prevision_dias=".$_POST["v_fecha_prevision_dias"];
			$sql = $sql.",v_fecha_vencimiento=".$_POST["v_fecha_vencimiento"];
			$sql = $sql.",v_numero_cliente=".$_POST["v_numero_cliente"];
			$sql = $sql.",v_subtipos=".$_POST["v_subtipos"];
			$sql = $sql.",v_pesobultos=".$_POST["v_pesobultos"];
			$sql = $sql.",v_recibos=".$_POST["v_recibos"];
			$sql = $sql.",tipo_ot=".$_POST["tipo_ot"];
			$sql = $sql.",presu=".$_POST["presu"];
			$sql = $sql.",presu_dias=".$_POST["presu_dias"];
			$sql = $sql.",stock=".$_POST["stock"];
			$sql = $sql.",aprovado=".$_POST["aprovado"];
			$sql = $sql.",v_rfq=".$_POST["v_rfq"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_factura_tipos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Administracion." de ".$Tipos." :</strong><br><br>";
		echo "<table><tr>";
			echo "<td class=menu>";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<table cellpadding=\"0\" cellspacing=\"1\">";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><strong>Ord</strong></td>";
				echo "<td style=\"text-align:center\"><strong>".$Tipo."</strong></td>";
				echo "<td style=\"text-align:center\"><strong>".$Descripcion."</strong></td>";
				echo "<td style=\"text-align:center\"><strong>Plant</strong></td>";
				echo "<td style=\"text-align:center\"><strong>".$Dias."</strong></td>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><strong>TPV</strong></td>";
				echo "<td style=\"text-align:center\"><strong>".$Caja."</strong></td>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><strong>V.Prev</strong></td>";
				echo "<td style=\"text-align:center\"><strong>".$Dias."</strong></td>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><strong>V.Venc</strong></td>";
				echo "<td style=\"text-align:center\"><strong>V.Ref</strong></td>";
				echo "<td style=\"text-align:center\"><strong>V.Sub</strong></td>";
				echo "<td style=\"text-align:center\"><strong>V.Pes</strong></td>";
				echo "<td style=\"text-align:center\"><strong>V.Rec</strong></td>";
				echo "<td style=\"text-align:center\"><strong>OT</strong></td>";
				echo "<td style=\"text-align:center\"><strong>Presu</strong></td>";
				echo "<td style=\"text-align:center\"><strong>".$Dias."</strong></td>";
				echo "<td style=\"text-align:center\"><strong>Stock</strong></td>";
				echo "<td style=\"text-align:center\"><strong>Aprov.</strong></td>";
				echo "<td style=\"text-align:center\"><strong>V.RFQ</strong></td>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1003&sop=500&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"orden\" style=\"width:20px\" value=\"0\"></td>";
				echo "<td><input type=\"Text\" name=\"tipo\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:125px\"></td>";
				echo "<td><select name=\"facturable\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"dias\" style=\"width:30px\" value=\"0\"></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><select name=\"tpv\" style=\"width:32px\">";
					echo "<option value=\"0\"selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"caja\" style=\"width:32px\">";
					echo "<option value=\"0\"selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><select name=\"v_fecha_prevision\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"v_fecha_prevision_dias\" style=\"width:30px\" value=\"0\"></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><select name=\"v_fecha_vencimiento\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_numero_cliente\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_subtipos\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_pesobultos\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_recibos\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"tipo_ot\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"presu\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"presu_dias\" style=\"width:30px\" value=\"0\"></td>";
				echo "<td><select name=\"stock\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>=</option>";
					echo "<option value=\"-1\">-</option>";
					echo "<option value=\"1\">+</option>";
				echo "</select></td>";
				echo "<td><select name=\"aprovado\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><select name=\"v_rfq\" style=\"width:32px\">";
					echo "<option value=\"0\" selected>N</option>";
					echo "<option value=\"1\">S</option>";
				echo "</select></td>";
				echo "<td><input type=\"Submit\" style=\"width:60px\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			$sqltipos = "select * from sgm_factura_tipos where visible=1 order by orden,descripcion";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)) {
				echo "<form action=\"index.php?op=1003&sop=500&ssop=2&id=".$rowtipos["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=501&id=".$rowtipos["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input type=\"Text\" name=\"orden\" value=\"".$rowtipos["orden"]."\" style=\"width:20px\"></td>";
					echo "<td><input type=\"Text\" name=\"tipo\" value=\"".$rowtipos["tipo"]."\" style=\"width:150px\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" value=\"".$rowtipos["descripcion"]."\" style=\"width:200px\"></td>";
					echo "<td><select name=\"facturable\" style=\"width:32px\">";
						if ($rowtipos["facturable"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["facturable"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"dias\" value=\"".$rowtipos["dias"]."\" style=\"width:30px\"></td>";
					echo "<td>&nbsp;</td>";
					echo "<td><select name=\"tpv\" style=\"width:32px\">";
						if ($rowtipos["tpv"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["tpv"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"caja\" style=\"width:32px\">";
						if ($rowtipos["caja"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["caja"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td>&nbsp;</td>";
					echo "<td><select name=\"v_fecha_prevision\" style=\"width:32px\">";
						if ($rowtipos["v_fecha_prevision"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_fecha_prevision"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"v_fecha_prevision_dias\" value=\"".$rowtipos["v_fecha_prevision_dias"]."\" style=\"width:30px\"></td>";
					echo "<td>&nbsp;</td>";
					echo "<td><select name=\"v_fecha_vencimiento\" style=\"width:32px\">";
						if ($rowtipos["v_fecha_vencimiento"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_fecha_vencimiento"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_numero_cliente\" style=\"width:32px\">";
						if ($rowtipos["v_numero_cliente"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_numero_cliente"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_subtipos\" style=\"width:32px\">";
						if ($rowtipos["v_subtipos"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_subtipos"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_pesobultos\" style=\"width:32px\">";
						if ($rowtipos["v_pesobultos"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_pesobultos"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_recibos\" style=\"width:32px\">";
						if ($rowtipos["v_recibos"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_recibos"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"tipo_ot\" style=\"width:32px\">";
						if ($rowtipos["tipo_ot"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["tipo_ot"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"presu\" style=\"width:32px\">";
						if ($rowtipos["presu"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["presu"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"presu_dias\" value=\"".$rowtipos["presu_dias"]."\" style=\"width:30px\"></td>";
					echo "<td><select name=\"stock\" style=\"width:32px\">";
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
					echo "<td><select name=\"aprovado\" style=\"width:32px\">";
						if ($rowtipos["aprovado"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["aprovado"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"v_rfq\" style=\"width:32px\">";
						if ($rowtipos["v_rfq"] == 0) {
							echo "<option value=\"0\" selected>N</option>";
							echo "<option value=\"1\">S</option>";
						}
						if ($rowtipos["v_rfq"] == 1) {
							echo "<option value=\"0\">N</option>";
							echo "<option value=\"1\" selected>S</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" style=\"width:60px\" value=\"".$Modificar."\"></td>";
					echo "<td style=\"width:60px;height:16px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1003&sop=510&id=".$rowtipos["id"]."\" style=\"color:white;\">Opciones</a>";
					echo "</td>";
				echo "</tr>";
				echo "</form>";
			}
		echo "</table>";
		echo "<br><strong>Ord.</strong> - (Orden) Orden en que aparecen los difrentes tipos en el listado superior.";
		echo "<br><strong>Plant</strong> - (Plantilla) Hace referencia a si este tipo debe de poder facturarse de forma continua.";
		echo "<br><strong>Días</strong> - (Días) La periocidad en días en que debe regenerarse una nueva plantilla.";
		echo "<br><strong>TPV</strong> - (TPV) Terminal Punto de Venta. No pide cliente, las impresiones son en formato tiquet.";
		echo "<br><strong>Caja</strong> - (Inlcuir en caja) Los resultados de este grupo se mostraran en los cierres de caja.";
		echo "<br><strong>V.Prev</strong> - (Visualizar previsión) Visualiza en el listado la fecha de previsión (usado para pedidos de clientes/proveedores).";
		echo "<br><strong>Días</strong> - (Días) Días que suma de forma automática a la previsión. Fecha de previsión = Fecha actual + Días.";
		echo "<br><strong>V.Ven</strong> - (Visualizar Vencimiento) Visualiza en el listado la el vencimiento de la factura. Fecha de vencimiento = Fecha actual + Días de la ficha cliente.";
		echo "<br><strong>V.Ref</strong> - (Visualizar Referencia del Cliente) Visualiza en el listado número de referencia del cliente y nombre de solicitante.";
		echo "<br><strong>V.Sub</strong> - (Visualizar Subtipos) Visualiza el subtipo (en caso de que existan).";
		echo "<br><strong>V.Pes</strong> - (Visualizar Peso) Visualiza en el peso y número de bultos, la impresión se realiza sin líneas ni totales.";
		echo "<br><strong>V.Rec</strong> - (Visualizar Recibos) Permite la gestión de recibos para el control del cobro.";
		echo "<br><strong>OT</strong> - (OT) Orden de trabajo. Se utilizará en gestión de pedidos.";
		echo "<br><strong>Presu</strong> - Formato de presupuesto. Vencimiento y càlculo de costes.";
		echo "<br><strong>Días</strong> - (Días) Días que suma a la caducidad del presupuesto. Fecha de caducidad = Fecha actual + Días.";
		echo "<br><strong>Aprov.</strong> - (Aprovar) Dar aprovación a un presupuesto";
		echo "<br><strong>V.RFQ</strong> - (Visualizar RFQ) Visualiza numero RFQ";
	}

	if ($soption == 501) {
		echo "<br><br>¿Seguro que desea eliminar este tipo?";
		echo "<br><br><a href=\"index.php?op=1003&sop=500&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=500\">[ NO ]</a>";
	}

	if ($soption == 510) {
		if ($ssoption == 1) {
			$sqli = "select count(*) as total from sgm_factura_tipos_idiomas where id_tipo=".$_GET["id"];
			$resulti = mysql_query(convert_sql($sqli));
			$rowi = mysql_fetch_array($resulti);
			if ($rowi["total"] > 0){
				$sql = "update sgm_factura_tipos_idiomas set ";
				$sql = $sql."cat='".$_POST["cat"]."'";
				$sql = $sql.",uk='".$_POST["uk"]."'";
				$sql = $sql.",fr='".$_POST["fr"]."'";
				$sql = $sql." WHERE id_tipo=".$_GET["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "insert into sgm_factura_tipos_idiomas (id_tipo,cat,uk,fr) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id"];
				$sql = $sql.",'".$_POST["cat"]."'";
				$sql = $sql.",'".$_POST["uk"]."'";
				$sql = $sql.",'".$_POST["fr"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		echo "<strong>".$Idiomas." ".$Tipos." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center><table>";
		$sqltipos = "select * from sgm_factura_tipos where visible=1 and id=".$_GET["id"];
		$resulttipos = mysql_query(convert_sql($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		$sqli = "select * from sgm_factura_tipos_idiomas where id_tipo=".$_GET["id"];
		$resulti = mysql_query(convert_sql($sqli));
		$rowi = mysql_fetch_array($resulti);
		echo "<form method=\"post\" action=\"index.php?op=1003&sop=510&ssop=1&id=".$rowtipos["id"]."\">";
			echo "<tr><td><strong>".$rowtipos["tipo"]."</strong></td><td></td></tr>";
			echo "<tr><td><input type=\"Text\" name=\"cat\" value=\"".$rowi["cat"]."\"></td><td>Catalán</td></tr>";
			echo "<tr><td><input type=\"Text\" name=\"uk\" value=\"".$rowi["uk"]."\"></td><td>Inglés</td></tr>";
			echo "<tr><td><input type=\"Text\" name=\"fr\" value=\"".$rowi["fr"]."\"></td><td>Francés</td></tr>";
			echo "<tr><td><input type=\"Submit\" style=\"width:100px\" value=\"".$Cambiar."\"></td><td></td></tr>";
		echo "</table></center>";
		}

	if ($soption == 550) {
		if ($ssoption == 1) {
			if ($_POST["id_tipo_d"] != 0) {
				$sql = "insert into sgm_factura_tipos_relaciones (id_tipo_o,id_tipo_d) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_tipo_o"];
				$sql = $sql.",".$_POST["id_tipo_d"];
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_factura_tipos_relaciones WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Relaciones." ".$Tipos." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br>Las relaciones entre tipos marcaran de donde a donde se pueden traspasar datos de facturación. Si queremos convertir albaranes en facturas, debemos indicar que albaranes tienen destino en facturas.<br><br>";
		$sqltipos = "select * from sgm_factura_tipos where visible=1 order by tipo";
		$resulttipos = mysql_query(convert_sql($sqltipos));
		echo "<center><table cellspacing=\"0\">";
		while ($rowtipos = mysql_fetch_array($resulttipos)) {
		echo "<form method=\"post\" action=\"index.php?op=1003&sop=550&ssop=1&id_tipo_o=".$rowtipos["id"]."\">";
			echo "<tr style=\"background-color:silver;\">";
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
					echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1003&sop=552&id=".$rowtiposrel["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td>".$rowtipos2["tipo"]."</td>";
				echo "</tr>";
			}
		}
		echo "</table></center>";
	}

	if ($soption == 552) {
		echo "<br><br>¿Seguro que desea eliminar este cliente?";
		echo "<br><br><a href=\"index.php?op=1003&sop=550&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1003&sop=550\">[ NO ]</a>";
	}

	if ($soption == 600) {
		if ($ssoption == 10) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."confirmada=".$_POST["confirmada"];
			$sql = $sql.",confirmada_cliente=".$_POST["confirmada_cliente"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		$sql = "select * from sgm_cabezera where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$sqlf = "select * from sgm_factura_tipos where id=".$row["tipo"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
		echo "<strong>".$Opciones."</strong><br><br>";
		echo "<center><table style=\"width:900px\" cellspacing=\"10\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\">";
						echo "<tr>";
							echo "<td style=\"width:400px\"><strong>".$Eliminar." ".$rowf["tipo"]."</strong></td>";
						echo "</tr><tr>";
							echo "<td style=\"width:400px\">Se eliminará el articulo en todo el progama. Todos los datos relacionados con él serán inaccesible.</td>";
						echo "</tr>";
					echo "</table><table>";
						echo "<tr>";
							echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:red;border: 1px solid black;\">";
								echo "<a href=\"index.php?op=1003&sop=601&id=".$row["id"]."&id_tipo=".$_GET["id_tipo"]."\" style=\"color:white;\">".$Eliminar."</a>";
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
							echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1003&sop=600&ssop=1&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" style=\"color:white;\">".$Completo."</a>";
							echo "</td>";
							echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1003&sop=602&fu=1&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" style=\"color:white;\">".$Parcial."</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					echo "<br>";
					if ($ssoption == 1){
						echo "<table style=\"width:400px;background-color:grey;\">";
							echo "<tr>";
								echo "<form action=\"index.php?op=1003&sop=10&ssop=7&id=".$_GET["id_tipo"]."&id_fact=".$_GET["id"]."\" method=\"post\">";
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
							echo "</form></tr>";
						echo "</table>";
					}
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 601) {
		echo "<br><br>¿Seguro que desea eliminar esta factura?";
		echo "<br><br><a href=\"index.php?op=1003&sop=10&ssop=20&id_fact=".$_GET["id"]."&id=".$_GET["id_tipo"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1003&sop=600&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\">[ NO ]</a>";
	}

	if ($soption == 602) {
		echo "<strong>".$Traspaso." ".$Parcial."</strong>";
		echo "<br><br>";
		echo boton_volver($Volver);
		echo "<br>";
	}

	if ($soption == 700) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_divisas (abrev,divisa,canvi,simbolo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["abrev"]."'";
			$sql = $sql.",'".$_POST["divisa"]."'";
			$sql = $sql.",".$_POST["canvi"]."";
			$sql = $sql.",'".$_POST["simbolo"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));

			$sqld = "select * from sgm_divisas order by id desc";
			$resultd = mysql_query(convert_sql($sqld));
			$rowd = mysql_fetch_array($resultd);
			$sqlf = "insert into sgm_divisas_mod_canvi (id_divisa,id_usuario,fecha,canvi) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$rowd["id"];
			$sqlf = $sqlf.",".$userid;
			$sqlf = $sqlf.",'".date("Y")."-".date("m")."-".date("d")."'";
			$sqlf = $sqlf.",'".$_POST["canvi"]."'";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));
		}
		if ($ssoption == 2) {
			$sqld = "select * from sgm_divisas where id=".$_GET["id"];
			$resultd = mysql_query(convert_sql($sqld));
			$rowd = mysql_fetch_array($resultd);
			if ($rowd["canvi"] != $_POST["canvi"]){
				$sqlf = "insert into sgm_divisas_mod_canvi (id_divisa,id_usuario,fecha,canvi) ";
				$sqlf = $sqlf."values (";
				$sqlf = $sqlf."".$_GET["id"];
				$sqlf = $sqlf.",".$userid;
				$sqlf = $sqlf.",'".date("Y")."-".date("m")."-".date("d")."'";
				$sqlf = $sqlf.",'".$_POST["canvi"]."'";
				$sqlf = $sqlf.")";
				mysql_query(convert_sql($sqlf));
			}

			$sqlc = "update sgm_divisas set ";
			$sqlc = $sqlc."abrev='".$_POST["abrev"]."'";
			$sqlc = $sqlc.",divisa='".$_POST["divisa"]."'";
			$sqlc = $sqlc.",canvi=".$_POST["canvi"]."";
			$sqlc = $sqlc.",simbolo='".$_POST["simbolo"]."'";
			$sqlc = $sqlc." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sqlc));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_divisas set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_divisas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_divisas set ";
			$sql = $sql."predefinido = 1";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_divisas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Divisas."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Predeterminado</em></td>";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">".$Abreviatura."</td>";
				echo "<td style=\"text-align:center;\">".$Divisa."</td>";
				echo "<td style=\"text-align:center;\">".$Simbolo."</td>";
				echo "<td style=\"text-align:center;\">".$Cambio."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<form action=\"index.php?op=1003&sop=700&ssop=1\" method=\"post\">";
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
					echo "<form action=\"index.php?op=1003&sop=700&ssop=5&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"Despred.\" style=\"width:100px\">";
					echo "</form>";
					echo "<td></td>";
				}
				if ($row["predefinido"] == 0) {
					echo "<form action=\"index.php?op=1003&sop=700&ssop=4&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"Pred.\" style=\"width:100px\">";
					echo "</form>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=701&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				}
				echo "<form action=\"index.php?op=1003&sop=700&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" style=\"width:60px\" name=\"abrev\" value=\"".$row["abrev"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" name=\"divisa\" value=\"".$row["divisa"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:20px\" name=\"simbolo\" value=\"".$row["simbolo"]."\"></td>";
				echo "<td><input type=\"Text\" style=\"width:100px\" name=\"canvi\" value=\"".$row["canvi"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=710&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 701) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta divisa?";
		echo "<br><br><a href=\"index.php?op=1003&sop=700&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1003&sop=700\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 710) {
		echo "<strong>".$Divisas."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=700\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:left;width:100px\">".$Fecha."</td>";
				echo "<td style=\"text-align:left;width:100px\">".$Cambio."</td>";
				echo "<td style=\"text-align:left;width:100px\">".$Usuario."</td>";
			echo "</tr>";
			$sql = "select * from sgm_divisas_mod_canvi where id_divisa=".$_GET["id"];
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
		echo "</center>";
	}

	if ($soption == 800) {
		echo "<strong>".$Cajas."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1003&sop=800&ssop=1\" style=\"color:white;\">".$Nueva." ".$Caja."</a>";
			echo "</td>";
			echo "<td class=\"menu\">";
				echo "<a href=\"\" style=\"color:white;\">".$Ver." ".$Cajas." ".$Anteriores."</a>";
			echo "</td>";
		echo "</tr></table>";

		if ($ssoption == 1) {
			echo "<table>";
				echo "<tr>";
					echo "<td style=\"width:100px;text-align:right\">".$Fecha." ".$Inicio."</td>";
					echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b500\"></td>";
					echo "<td style=\"width:100px;text-align:right\">".$Fecha." ".$Fin."</td>";
					echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m2\"></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td style=\"width:100px;text-align:right\">".$Cambio." ".$Anterior."</td>";
					echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b500\" disabled></td>";
				echo "</tr>";
			echo "</table>";
			echo "<table>";
				echo "<tr>";
					echo "<td style=\"vertical-align:top\">";
						echo "<table>";
							echo "<tr>";
								echo "<td style=\"width:150px;text-align:center;\">".$Tipo."</td>";
								echo "<td style=\"width:75px;text-align:center;\">".$Total."</td>";
								echo "<td style=\"width:150px;text-align:center;\">".$Forma." de ".$Pago."</td>";
							echo "</tr>";
							$sqltipos2 = "select * from sgm_factura_tipos where visible=1 and (v_recibos=1 or tpv=1) order by orden,descripcion";
							$resulttipos2 = mysql_query(convert_sql($sqltipos2));
							while ($rowtipos2 = mysql_fetch_array($resulttipos2)) {
								echo "<tr>";
									echo "<td><strong>".$rowtipos2["tipo"]."</strong></td>";
									echo "<td style=\"width:75px;text-align:center;\">0€</td>";
									echo "<td style=\"width:150px;text-align:center;\">-</td>";
								echo "</tr>";
							}
						echo "</table>";
					echo "</td>";
					echo "<td style=\"vertical-align:top\">";
						echo "<table>";
							echo "<tr>";
								echo "<td style=\"width:150px;text-align:center;\">".$Tipo."</td>";
								echo "<td style=\"width:75px;text-align:center;\">".$Unidades."</td>";
								echo "<td style=\"width:75px;text-align:center;\">".$Total."</td>";
							echo "</tr>";
							$sqltipos2 = "select * from sgm_tpv_tipos_pago order by tipo";
							$resulttipos2 = mysql_query(convert_sql($sqltipos2));
							while ($rowtipos2 = mysql_fetch_array($resulttipos2)) {
								echo "<tr>";
								echo "<td><strong>".$rowtipos2["tipo"]."</strong></td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m1\"></td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m1\"></td>";
								echo "</tr>";
							}
						echo "</table>";
						echo "<br>";
						echo "<table>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 500 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b500\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 2 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m2\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 200 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b200\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 1 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m1\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 100 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b100\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 0.50 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m50\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 50 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b50\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 0.20 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m20\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 20 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b20\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 0.10 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m10\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 10 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b10\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 0.05 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m05\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Billetes." de 5 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"b5\"></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 0.02 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m02\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"width:100px;text-align:right\">".$Total." ".$Efectivo."</td>";
								echo "<td>&nbsp;&nbsp;<strong>0€</strong></td>";
								echo "<td style=\"width:120px;text-align:right\">".$Monedas." de 0.01 €</td>";
								echo "<td><input type=\"Text\" style=\"width:75px\" name=\"m01\"></td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		}
	}

	if ($soption == 910) {
		echo "<strong>".$Buscar." ".$Articulos." en ".$Factura."</strong>";
		echo "<center><table style=\"background-color:silver;width:200px;\" cellspacing=\"0\"><tr>";
			echo "<tr>";
				echo "<td>".$Codigo." ".$Articulo."</td>";
				echo "<td>".$Nombre." ".$Articulo."</td>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1003&sop=910&ssop=1\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"codigo\" value=\"".$_POST["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre\" value=\"".$_POST["nombre"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\"></td>";
			echo "</form>";
			echo "</tr>";
		echo "</table></center>";
		if ($ssoption == 1) {
			echo "<br>";
			echo "<center><table cellspacing=\"0\" style=\"width:900px;\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td>".$Cliente."</td>";
					echo "<td>".$Tipo."</td>";
					echo "<td>Nº OT</td>";
					echo "<td>Nº Cliente</td>";
					echo "<td>Nº RFQ</td>";
					echo "<td style=\"width:100px\">".$Fecha."</td>";
					echo "<td>".$Codigo." Art.</td>";
					echo "<td>".$Nombre." Art.</td>";
					echo "<td>".$Ver."</td>";
				echo "</tr>";
				$sql = "select * from sgm_cuerpo where codigo like '%".$_POST["codigo"]."%' and nombre like '%".$_POST["nombre"]."%' order by fecha_prevision desc";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					$sqlc = "select * from sgm_cabezera where id=".$row["idfactura"]."";
					$resultc = mysql_query(convert_sql($sqlc));
					$rowc = mysql_fetch_array($resultc);
					if ($rowc["visible"] == 1) {
						$sqlt = "select * from sgm_factura_tipos where id=".$rowc["tipo"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
						echo "<tr>";
							echo "<td>".$rowc["nombre"]."</td>";
							echo "<td><strong>".$rowt["tipo"]."</strong></td>";
							echo "<td><strong>".$rowc["numero"]."</strong></td>";
							echo "<td><strong>".$rowc["numero_cliente"]."</strong></td>";
							echo "<td><strong>".$rowc["numero_rfq"]."</strong></td>";
							echo "<td>".$rowc["fecha"]."</td>";
							echo "<td><strong>".$row["codigo"]."</strong></td>";
							echo "<td>".$row["nombre"]."</td>";
							echo "<td><a href=\"index.php?op=1003&sop=22&id=".$rowc["id"]."&id_tipo=".$rowc["tipo"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"></a></td>";
						echo "</tr>";
					}
				}
			echo "</table></center>";
		}
	}

	if ($soption == 9999) {
		$fechahoy = getdate();
		$fecha = date("dmy", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
		
		$A1 = '51';
		$A2 = '70';
		$B1 = 'B62203211';
		$B12 = '000';
		$B2 = $fecha;
		$B3 = '      ';
		$C = 'Solucions Globals Maresme S.L.          ';
		$D = '                    ';
		$E1 = '2100';
		$E2 = '0071';
		$E3 = '            ';
		$F = '                                        ';
		$G = '              ';
		$cabpresentador = $A1.$A2.$B1.$B12.$B2.$B3.$C.$D.$E1.$E2.$E3.$F.$G;
		
		$A1 = '53';
		$A2 = '70';
		$B1 = 'B62203211';
		$B12 = '000';
		$B2 = $fecha;
		$B3 = '      ';
		$C = 'Solucions Globals Maresme S.L.          ';
		$D = '21000071100200404206';
		$E1 = '        ';
		$E2 = '06';
		$E3 = '          ';
		$F =  '                                        ';
		$G1 = '  ';
		#                $G2 = 'XXXXXXXXX';
		$G2 = '         ';
		$G3 = '   ';
		$cabordenante = $A1.$A2.$B1.$B12.$B2.$B3.$C.$D.$E1.$E2.$E3.$F.$G1.$G2.$G3;
		
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id_factura"];
		$resultcabezera = mysql_query(convert_sql($sqlcabezera));
		$rowcabezera = mysql_fetch_array($resultcabezera);
		
		$A1 = '56';
		$A2 = '70';
		$B1 = 'B62203211';
		$B12 = '000';
		$B2 = $rowcabezera["numero"];
		$espacios = 12-strlen($B2);
		for ($x = 1; $espacios >= $x; $x++) { $B2 = $B2.' '; }
		$C = $rowcabezera["nombre"];
		$espacios = 40-strlen($C);
		for ($x = 1; $espacios >= $x; $x++) { $C = $C.' '; }
		$sqlx = "select * from sgm_clients where id=".$rowcabezera["id_cliente"];
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);
		$D = $rowx["cuentabancaria"];
		$E = $rowcabezera["total"]*100;
		$espacios = 10-strlen($E);
		for ($x = 1; $espacios >= $x; $x++) { $E = '0'.$E; }
		$F1 = '      ';
		$F2 = '          ';
		$G = 'SGM S.L. Factura : '.$rowcabezera["numero"];
		$espacios = 40-strlen($G);
		for ($x = 1; $espacios >= $x; $x++) { $G = $G.' '; }
		$H = $fecha.'  ';
		$individualobligatorio = $A1.$A2.$B1.$B12.$B2.$C.$D.$E.$F1.$F2.$G.$H;
		
		$A1 = '58';
		$A2 = '70';
		$B1 = 'B62203211';
		$B12 = '000';
		$B2 = '            ';
		$C = '                                        ';
		$D = '                    ';
		$E1 = $rowcabezera["total"]*100;
		$espacios = 10-strlen($E1);
		for ($x = 1; $espacios >= $x; $x++) { $E1 = '0'.$E1; }
		$E2 = '      ';
		
		$F1 = '1         ';
		$F2 = '3         ';
		$F3 = '                    ';
		$G  = '                  ';
		$cabtotalclienteordenante = $A1.$A2.$B1.$B12.$B2.$C.$D.$E1.$E2.$F1.$F2.$F3.$G;
		
		$A1 = '59';
		$A2 = '70';
		$B1 = 'B62203211';
		$B12 = '000';
		$B2 = '            ';
		$C = '                                        ';
		$D1 = '1   ';
		$D2 = '                ';
		$E1 = $rowcabezera["total"]*100;
		$espacios = 10-strlen($E1);
		for ($x = 1; $espacios >= $x; $x++) { $E1= '0'.$E1; }
		$E2 = '      ';
		
		$F1 = '1         ';
		$F2 = '5         ';
		$F3 = '                    ';
		$G  = '                  ';
		$cabtotal = $A1.$A2.$B1.$B12.$B2.$C.$D.$E1.$E2.$F1.$F2.$F3.$G;
		
		$fichero = fopen("domiciliacion.txt","w"); 
		$string1 = $cabpresentador;
		$string2 = $cabordenante;
		$string3 = $individualobligatorio;
		$string4 = $cabtotalclienteordenante;
		$string5 = $cabtotal;
		fputs($fichero,$string1."\r\n");
		fputs($fichero,$string2."\r\n");
		fputs($fichero,$string3."\r\n");
		fputs($fichero,$string4."\r\n");
		fputs($fichero,$string5."\r\n");
		fclose($fichero); 
		echo "Para recoger el fichero a (Q58) a mandar : <a href=\"domiciliacion.txt\">click boton derecho y \"guardar como\"</a>";
	}

	if ($soption == 99999) {
		$sqlr = "select * from sgm_cabezera where visible=1 and tipo=1";
		$resultr = mysql_query(convert_sql($sqlr));
		while ($rowr = mysql_fetch_array($resultr)) {
			## COMPRUEBA SI ESTAN LOS RECIBOS REALIZADOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$rowr["id"];
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $rowr["total"]) {
				$sql = "update sgm_cabezera set recibos=1 WHERE id=".$rowr["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set recibos=0 WHERE id=".$rowr["id"]."";
				mysql_query(convert_sql($sql));
			}
			## COMPRUEBA SI ESTA COBRADA O NO A PARTIR DE LOS RECIBOS
			$sqlcalc = "select SUM(total) as total from sgm_recibos where visible=1 AND id_factura =".$rowr["id"]." and cobrada=1";
			$resultcalc = mysql_query(convert_sql($sqlcalc));
			$rowcalc = mysql_fetch_array($resultcalc);
			if ($rowcalc["total"] >= $rowr["total"]) {
				$sql = "update sgm_cabezera set cobrada=1 WHERE id=".$rowr["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cabezera set cobrada=0 WHERE id=".$rowr["id"]."";
				mysql_query(convert_sql($sql));
			}
		}
	}

	echo "</td></tr></table><br>";
}

?>
