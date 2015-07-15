<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
$autorizado = true;
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }

if (($option == 1015) AND ($autorizado == true)) {
	$date = getdate();
	$xdate = $date["year"]."-".$date["mon"]."-".$date["mday"];

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" >";
		echo "<tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<center><table><tr>";
				echo "<td style=\"height:20px;width:120px;\";><strong>Calidad 3.0 :</strong></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 1)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1015&sop=1\" class=\"gris\" style=\"color:".$lcolor."\">Listado de incidencias</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 99) and ($soption != 1)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1015&sop=99\" class=\"gris\" style=\"color:".$lcolor."\">Listado Controles</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 100) and ($soption != 1)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1015&sop=100\" class=\"gris\" style=\"color:".$lcolor."\">Control Manual</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 200) and ($soption != 1)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1015&sop=200\" class=\"gris\" style=\"color:".$lcolor."\">Control Automático</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 300) and ($soption != 1)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1015&sop=300\" class=\"gris\" style=\"color:".$lcolor."\">Indicadores</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 500) and ($soption != 1)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1015&sop=500\" class=\"gris\" style=\"color:".$lcolor."\">Plan de Calibraciones</a></td>";
			echo "</tr></table></center>";

		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";



	if ($soption == 1) {
		echo "<br><strong>Listado de incidencias de producción : </strong><br><br>";
		echo "<table cellspacing=\"0\" cellspacing=\"0\">";
			echo "<tr><td></td><td><a href=\"index.php?op=1015&sop=1&ssop=0\">Registro</a></td><td></td><td><a href=\"index.php?op=1015&sop=1&ssop=2\">Estado</a></td><td><a href=\"index.php?op=1015&sop=1&ssop=1\">Previsión</a></td><td>Cierre</td><td></td><td>Solución</td></tr>";
		if ($ssoption == 0) { $sql = "select * from sgm_cuerpo_incidencias order by fecha desc, hora desc"; }
		if ($ssoption == 1) { $sql = "select * from sgm_cuerpo_incidencias order by fecha_prevision desc"; }
		if ($ssoption == 2) { $sql = "select * from sgm_cuerpo_incidencias order by cerrada"; }
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"vertical-align:top\"><a href=\"index.php?op=1014&sop=1&id=".$row["id_cuerpo"]."\">[+]</a></td>";
				echo "<td style=\"vertical-align:top\">".$row["fecha"]."</td>";
				echo "<td style=\"vertical-align:top\"><strong>".$row["hora"]."</strong></td>";
				if ($row["cerrada"] == 0) { echo "<td style=\"vertical-align:top\"><strong style=\"color:red\">Pendiente</strong></td>"; }
				if ($row["cerrada"] == 1) { echo "<td style=\"vertical-align:top\"><strong style=\"color:green\">Cerrada</strong></td>"; }
				echo "<td style=\"vertical-align:top\">".$row["fecha_prevision"]."</td>";
				if ($row["fecha_cierre"] == "0000-00-00") {
					echo "<td></td>";
				} else { echo "<td style=\"vertical-align:top\"><strong>".$row["fecha_cierre"]."</strong></td>"; }
				echo "<td style=\"vertical-align:top\"><a href=\"index.php?op=1015&sop=2&id_incidencia=".$row["id"]."&id_cuerpo=".$row["id_cuerpo"]."\">[ Ver-Editar ]</a>";
				echo "<td style=\"vertical-align:top;width:350px;text-align:justify\">".$row["solucion"]."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	if ($soption == 2) {
		if ($ssoption == 2) {
			$sql = "select * from sgm_cuerpo_incidencias where id=".$_GET["id_incidencia"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$sql = "update sgm_cuerpo_incidencias set ";
			$sql = $sql."cerrada=".$_POST["cerrada"];
			$sql = $sql.",id_proceso=".$_POST["id_proceso"];
			$sql = $sql.",fecha='".$_POST["fecha"]."'";
			$sql = $sql.",hora='".$_POST["hora"]."'";
			$sql = $sql.",fecha_prevision='".$_POST["fecha_prevision"]."'";
			$sql = $sql.",problema='".$_POST["problema"]."'";
			$sql = $sql.",causa='".$_POST["causa"]."'";
			$sql = $sql.",solucion='".$_POST["solucion"]."'";
			$sql = $sql.",accion_correctiva='".$_POST["accion_correctiva"]."'";
			if (($_POST["cerrada"] == 1) and ($row["fecha_cierre"] == "0000-00-00")) { $sql = $sql.",fecha_cierre='".$_POST["fecha_cierre"]."'"; }
			$sql = $sql." WHERE id=".$_GET["id_incidencia"]."";
			mysql_query(convert_sql($sql));
		}
			$sql = "select * from sgm_cuerpo_incidencias where id=".$_GET["id_incidencia"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);

			echo "<strong>Editar incidencia :</strong><br><br>";
			echo "<table>";
				echo "<form method=\"post\" action=\"index.php?op=1015&sop=2&ssop=2&id_incidencia=".$_GET["id_incidencia"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Proceso : </td>";
				echo "<td>";
					echo "<select style=\"width:300px\" name=\"id_proceso\">";
						$sqles = "select * from sgm_cuerpo_estados_historico where id_cuerpo=".$_GET["id_cuerpo"]." order by fecha desc, hora desc";
						$resultes = mysql_query(convert_sql($sqles));
						while ($rowes = mysql_fetch_array($resultes)) {
							$sqlest = "select * from sgm_cuerpo_estados where id=".$rowes["id_estado"];
							$resultest = mysql_query(convert_sql($sqlest));
							$rowest = mysql_fetch_array($resultest);
							echo "<option value=\"".$rowes["id"]."\">".$rowes["fecha"]." (".$rowes["hora"].") ".$rowest["estado"]."</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Fecha y Hora : </td><td>";
					echo "<input type=\"text\" name=\"fecha\" style=\"width:75px\" value=\"".$row["fecha"]."\">";
					echo "&nbsp;&nbsp;<input type=\"text\" name=\"hora\" style=\"width:75px\" value=\"".$row["hora"]."\">";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Problema : </td><td><textarea name=\"problema\" rows=\"2\" style=\"width:300px\">".$row["problema"]."</textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Causas : </td><td><textarea name=\"causa\" rows=\"2\" style=\"width:300px\">".$row["causa"]."</textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Solución :</td><td><textarea name=\"solucion\" rows=\"2\" style=\"width:300px\">".$row["solucion"]."</textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Acción correctiva : </td><td><textarea name=\"accion_correctiva\" rows=\"2\" style=\"width:300px\">".$row["accion_correctiva"]."</textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Fecha de previsión : </td><td><input type=\"text\" name=\"fecha_prevision\" style=\"width:75px\" value=\"".$row["fecha_prevision"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Cerrada : </td><td>";
					echo "<select style=\"width:50px\" name=\"cerrada\">";
					if ($row["cerrada"] == 0) {
						echo "<option value=\"0\" selected>NO</option>";
						echo "<option value=\"1\">SI</option>";
					}
					if ($row["cerrada"] == 1) {
						echo "<option value=\"0\">NO</option>";
						echo "<option value=\"1\" selected>SI</option>";
					}
					echo "</select>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Fecha cierre : </td><td><input type=\"text\" name=\"fecha_cierre\" style=\"width:75px\" value=\"";
				if ($row["fecha_cierre"] == "0000-00-00") {
					echo date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
				} else { echo $row["fecha_cierre"]; }
				echo "\"></td></tr>";
				echo "<tr><td></td><td><input type=\"Submit\" value=\"Modificar incidencia\" style=\"width:300px\"></td></tr>";
				echo "</form>";
			echo "</table>";
	}

	if (($soption == 95)) {
		echo "<strong>Control Calidad Pedido Proveedor :</strong><br><br>";
		echo "<table><tr><td>";
			echo "<table>";

				echo "<form method=\"post\" action=\"index.php?op=1015&sop=101\">";

				$sql = "select * from sgm_cabezera where id=".$_POST["id_cabezera"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<tr><td style=\"text-align:right;\">Número : </td><td><strong>".$row["numero"]."</strong></td></tr>";

				$sql = "select * from sgm_clients where id=".$_POST["id_cliente"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<tr><td style=\"text-align:right;\">Cliente : </td><td><strong>".$row["nombre"]."</strong></td></tr>";

				echo "<input type=\"hidden\" name=\"id_cabezera\" value=\"".$_POST["id_cabezera"]."\">";
				echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";

				echo "<tr><td style=\"text-align:right;\">Fecha : </td><td><input type=\"Text\" value=\"".$xdate."\" style=\"width:75px\" name=\"fecha\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha previsión : </td><td><input type=\"Text\" value=\"".$_POST["fecha_prevision"]."\" style=\"width:75px\" name=\"fecha_prevision\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha llegada : </td><td><input type=\"Text\" value=\"".$xdate."\" style=\"width:75px\" name=\"fecha_llegada\"></td></tr>";

				echo "<tr><td style=\"text-align:right\">Embalage : </td><td>";
					echo "<select name=\"embalage\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcto (0)</option>";
						echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Material : </td><td>";
					echo "<select name=\"material\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcto (0)</option>";
						echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Medidas : </td><td>";
					echo "<select name=\"medidas\" style=\"width:150px\">";
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4\">&lt;85%</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Acabados : </td><td>";
					echo "<select name=\"acabados\" style=\"width:150px\">";
						echo "<option value=\"0\">Correctos (0)</option>";
						echo "<option value=\"0.25\">Incorrectos (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Cantidad : </td><td>";
					echo "<select name=\"cantidad\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcta (0)</option>";
						echo "<option value=\"0.25\">Incorrecta (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"Añadir Control Calidad\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</td><td>";
		echo "</td></tr></table>";
	}



	if (($soption == 99)) {
		if ($ssoption == 1) {
			$sql = "update sgm_control_calidad set ";
			$sql = $sql."fecha='".$_POST["fecha"]."'";
			$sql = $sql.",fecha_prevision='".$_POST["fecha_prevision"]."'";
			$sql = $sql.",fecha_llegada='".$_POST["fecha_llegada"]."'";
			$sql = $sql.",embalage=".$_POST["embalage"]."";
			$sql = $sql.",material=".$_POST["material"]."";
			$sql = $sql.",medidas=".$_POST["medidas"]."";
			$sql = $sql.",acabados=".$_POST["acabados"]."";
			$sql = $sql.",cantidad=".$_POST["cantidad"]."";
			$i = ((( (strtotime($_POST["fecha_prevision"])) - (strtotime($_POST["fecha_llegada"])) ) /86400)*(-1));
			if ($i > 5) { $i = 5; }
			if ($i < 0) { $i = 0; }
			$sql = $sql.",puntos_fechas=".$i."";
			$sql = $sql.",total=".($_POST["embalage"]+$_POST["material"]+$_POST["medidas"]+$_POST["acabados"]+$_POST["cantidad"]+$i)."";
			$sql = $sql.",id_user=".$_POST["id_user"]."";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_control_calidad set ";
			$sql = $sql."id_cabezera=".$_POST["id_cabezera"]."";
			$sql = $sql.",id_cliente=".$_POST["id_cliente"]."";
			$sql = $sql.",fecha='".$_POST["fecha"]."'";
			$sql = $sql.",fecha_prevision='".$_POST["fecha_prevision"]."'";
			$sql = $sql.",fecha_llegada='".$_POST["fecha_llegada"]."'";
			$sql = $sql.",embalage=".$_POST["embalage"]."";
			$sql = $sql.",material=".$_POST["material"]."";
			$sql = $sql.",medidas=".$_POST["medidas"]."";
			$sql = $sql.",acabados=".$_POST["acabados"]."";
			$sql = $sql.",cantidad=".$_POST["cantidad"]."";
			$i = ((( (strtotime($_POST["fecha_prevision"])) - (strtotime($_POST["fecha_llegada"])) ) /86400)*(-1));
			if ($i > 5) { $i = 5; }
			if ($i < 0) { $i = 0; }
			$sql = $sql.",puntos_fechas=".$i."";
			$sql = $sql.",total=".($_POST["embalage"]+$_POST["material"]+$_POST["medidas"]+$_POST["acabados"]+$_POST["cantidad"]+$i)."";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_control_calidad set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<table style=\"width:100%\"><tr><td style=\"width:50%\">";
			echo "<strong style=\"font-size : 20px;\">".$rowtipos["tipo"]."</strong><br><br>";
		echo "</td><td style=\"width:50%;background-color : #DBDBDB;text-align:center;\">";
			echo "<strong>Opciones</strong><br>";
			echo "<center><table>";
				echo "<tr>";
				echo "<form action=\"index.php?op=1015&sop=99\" method=\"post\">";
				echo "<td>Cliente &nbsp;</td>";
				echo "<td>";
					echo "<select style=\"width:180px\" name=\"id_cliente\">";
					echo "<option value=\"\">-</option>";
						$sql = "select * from sgm_clients where visible=1 ";
						$sql = $sql." and (proveedor=1) ";
						$sql = $sql."order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_GET["id"] == 1) {
								if ((valida_nif_cif_nie($row["nif"]) <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
								} else { echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>"; }
							} else {
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"Filtro Hist.\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "</tr>";
			echo "</table></center>";
			echo "<br>";
		echo "</td></tr></table>";
		echo "<table>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:left;width:150px\">Cliente/Proveedor</td>";
				echo "<td style=\"text-align:center;width:50px\">Pedido</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Pedido</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Previsión</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Llegada</td>";
				echo "<td style=\"text-align:center;width:25px\">Emb.</td>";
				echo "<td style=\"text-align:center;width:25px\">Mat.</td>";
				echo "<td style=\"text-align:center;width:25px\">Med.</td>";
				echo "<td style=\"text-align:center;width:25px\">Aca.</td>";
				echo "<td style=\"text-align:center;width:25px\">Can.</td>";
				echo "<td style=\"text-align:center;width:25px\">Fec.</td>";
				echo "<td style=\"text-align:center;width:25px\"><strong>Total</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		if ($_POST["id_cliente"] == "" ) { $sql = "select * from sgm_control_calidad where visible=1 order by id DESC LIMIT 0 , 20"; }
		if ($_POST["id_cliente"] > 0 ) { $sql = "select * from sgm_control_calidad where visible=1 and id_cliente=".$_POST["id_cliente"]." order by id DESC"; }
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
				echo "<td><a href=\"index.php?op=1015&sop=102&id=".$row["id"]."\">[E]</a></td>";
				$sqlc = "select * from sgm_clients where id=".$row["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				if (strlen($rowc["nombre"]) > 35) {
					echo "<td><a href=\"index.php?op=1011&sop=0&id=".$rowc["id"]."&origen=1003\"><strong>".substr($rowc["nombre"],0,35)." ...</strong></a></td>";
				} else {
					echo "<td><a href=\"index.php?op=1011&sop=0&id=".$rowc["id"]."&origen=1003\"><strong>".$rowc["nombre"]."</strong></a></td>";
				}

				if ($row["manual"] == 1) {
					echo "<td><strong>".$row["id_cabezera"]."</strong></td>";
				}
				if ($row["manual"] == 0) {
					$sqlf = "select * from sgm_cabezera where id=".$row["id_cabezera"];
					$resultf = mysql_query(convert_sql($sqlf));
					$rowf = mysql_fetch_array($resultf);
					echo "<td><a href=\"index.php?op=1003&sop=22&id=".$row["id_cabezera"]."\"><strong>".$rowf["numero"]."</strong></a></td>";
				}
				echo "<td style=\"text-align:center;width:75px\"><strong>".$row["fecha"]."</strong></td>";
				echo "<td style=\"text-align:center;width:75px\">".$row["fecha_prevision"]."</td>";
				echo "<td style=\"text-align:center;width:75px\"><strong>".$row["fecha_llegada"]."</strong></td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["embalage"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["material"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["medidas"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["acabados"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["cantidad"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["puntos_fechas"]."</td>";
				echo "<td style=\"text-align:center;width:25px\"><strong>".(10-$row["total"])."</strong></td>";
				if ($row["manual"] == 1) {
					echo "<td><a href=\"index.php?op=1015&sop=104&id=".$row["id"]."\">[Editar]</a></td>";
				}
				if ($row["manual"] == 0) {
					echo "<td><a href=\"index.php?op=1015&sop=110&id=".$row["id"]."\">[Editar]</a></td>";
				}
			echo "</tr>";
		}
		echo "</table>";
	}


	if (($soption == 100)) {
		echo "<strong>Control Calidad Pedido Proveedor (manual) :</strong><br><br>";
		echo "<table><tr><td>";
			echo "<table>";

				echo "<form method=\"post\" action=\"index.php?op=1015&sop=101\">";
				echo "<tr><td style=\"text-align:right;\">Número pedido : </td><td><input type=\"Text\" style=\"width:75px\" name=\"id_cabezera\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">Cliente/Proveedor : </td><td>";
					echo "<select name=\"id_cliente\" style=\"width:150px\">";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
						}
					echo "</select>";
				echo "</td></tr>";


				echo "<tr><td style=\"text-align:right;\">Fecha : </td><td><input type=\"Text\" value=\"".$xdate."\" style=\"width:75px\" name=\"fecha\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha previsión : </td><td><input type=\"Text\" value=\"".$xdate."\" style=\"width:75px\" name=\"fecha_prevision\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha llegada : </td><td><input type=\"Text\" value=\"".$xdate."\" style=\"width:75px\" name=\"fecha_llegada\"></td></tr>";

				echo "<tr><td style=\"text-align:right\">Embalage : </td><td>";
					echo "<select name=\"embalage\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcto (0)</option>";
						echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Material : </td><td>";
					echo "<select name=\"material\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcto (0)</option>";
						echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Medidas : </td><td>";
					echo "<select name=\"medidas\" style=\"width:150px\">";
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4\">&lt;85%</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Acabados : </td><td>";
					echo "<select name=\"acabados\" style=\"width:150px\">";
						echo "<option value=\"0\">Correctos (0)</option>";
						echo "<option value=\"0.25\">Incorrectos (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Cantidad : </td><td>";
					echo "<select name=\"cantidad\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcta (0)</option>";
						echo "<option value=\"0.25\">Incorrecta (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"Añadir Control Calidad\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</td><td>";
		echo "</td></tr></table>";
	}

	if ($soption == 101) {
		$sql = "insert into sgm_control_calidad (id_cabezera,id_cliente,fecha,fecha_prevision,fecha_llegada,embalage,material,medidas,acabados,cantidad,puntos_fechas,total) ";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_cabezera"]."";
		$sql = $sql.",".$_POST["id_cliente"]."";
		$sql = $sql.",'".$_POST["fecha"]."'";
		$sql = $sql.",'".$_POST["fecha_prevision"]."'";
		$sql = $sql.",'".$_POST["fecha_llegada"]."'";
		$sql = $sql.",".$_POST["embalage"]."";
		$sql = $sql.",".$_POST["material"]."";
		$sql = $sql.",".$_POST["medidas"]."";
		$sql = $sql.",".$_POST["acabados"]."";
		$sql = $sql.",".$_POST["cantidad"]."";
		$i = ((( (strtotime($_POST["fecha_prevision"])) - (strtotime($_POST["fecha_llegada"])) ) /86400)*(-1));
		if ($i > 5) { $i = 5; }
		if ($i < 0) { $i = 0; }
		$sql = $sql.",".$i;
		$sql = $sql.",".($_POST["embalage"]+$_POST["material"]+$_POST["medidas"]+$_POST["acabados"]+$_POST["cantidad"]+$i)."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		echo $sql."<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1015&sop=0\">[ Volver ]</a>";
	}

	if (($soption == 102)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este control de calidad?";
		echo "<br><br><a href=\"index.php?op=1015&sop=99&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1015&sop=99\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 104)) {
		echo "<strong>Control Calidad Pedido Proveedor (manual) :</strong><br><br>";
		echo "<table><tr><td>";
			echo "<table>";

			$sqlcc = "select * from sgm_control_calidad where id=".$_GET["id"];
			$resultcc = mysql_query(convert_sql($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);

				echo "<form method=\"post\" action=\"index.php?op=1015&sop=99&sop=2&id=".$_GET["id"]."\">";
				echo "<tr><td style=\"text-align:right;\">Número pedido : </td><td><input type=\"Text\" style=\"width:75px\" name=\"id_cabezera\" value=\"".$rowcc["id_cabezera"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">Cliente/Proveedor : </td><td>";
					echo "<select name=\"id_cliente\" style=\"width:150px\">";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($rowcc["id_cliente"] == $row["id"]) {
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
							}
						}
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Fecha : </td><td><input type=\"Text\" style=\"width:75px\" name=\"fecha\" value=\"".$rowcc["fecha"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha previsión : </td><td><input type=\"Text\" style=\"width:75px\" name=\"fecha_prevision\" value=\"".$rowcc["fecha_prevision"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha llegada : </td><td><input type=\"Text\" style=\"width:75px\" name=\"fecha_llegada\" value=\"".$rowcc["fecha_llegada"]."\"></td></tr>";

				echo "<tr><td style=\"text-align:right\">Embalage : </td><td>";
					echo "<select name=\"embalage\" style=\"width:150px\">";
						if ($rowcc["embalage"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["embalage"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Material : </td><td>";
					echo "<select name=\"material\" style=\"width:150px\">";
						if ($rowcc["material"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["material"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Medidas : </td><td>";
					echo "<select name=\"medidas\" style=\"width:150px\">";
						if ($rowcc["medidas"] == 0.0) {
							echo "<option value=\"0\" selected>100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 0.8) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\" selected>96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 1.6) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\" selected>90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 2.8) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.2\">96-100%</option>";
							echo "<option value=\"0.4\">90-96%</option>";
							echo "<option value=\"0.7\" selected>85-90%</option>";
							echo "<option value=\"1.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 4.0) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\" selected>&lt;85%</option>";
						}
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Acabados : </td><td>";
					echo "<select name=\"acabados\" style=\"width:150px\">";
						if ($rowcc["acabados"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["acabados"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;\">Cantidad : </td><td>";
					echo "<select name=\"cantidad\" style=\"width:150px\">";
						if ($rowcc["cantidad"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["cantidad"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"Modificar Control Calidad\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</td><td>";
		echo "</td></tr></table>";
	}

	if (($soption == 110)) {
		echo "<strong>Control Calidad Pedido Proveedor :</strong><br><br>";
		echo "<table><tr><td>";
			echo "<table>";

			$sqlcc = "select * from sgm_control_calidad where id=".$_GET["id"];
			$resultcc = mysql_query(convert_sql($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);

				echo "<form method=\"post\" action=\"index.php?op=1015&sop=99&ssop=1&id=".$_GET["id"]."\">";
					$sqlf = "select * from sgm_cabezera where id=".$rowcc["id_cabezera"];
					$resultf = mysql_query(convert_sql($sqlf));
					$rowf = mysql_fetch_array($resultf);
				echo "<tr><td style=\"text-align:right;\">Número pedido : </td><td><input type=\"Text\" style=\"width:75px\" name=\"id_cabezera\" value=\"".$rowf["numero"]."\" disabled></td></tr>";
				echo "<tr><td style=\"text-align:right\">Cliente/Proveedor : </td><td>";
					echo "<select name=\"id_cliente\" style=\"width:150px\" disabled>";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($rowcc["id_cliente"] == $row["id"]) {
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
							}
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right\">Usuario : </td><td>";
					if ($rowcc["id_user"] <= 0){
						$sqlu = "select * from sgm_users where id=".$userid;
					} else { 
						$sqlu = "select * from sgm_users where id=".$rowcc["id_user"];
					}
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
					echo "<input style=\"width:150px\" value=\"".$rowu["usuario"]."\" disabled></td></tr>";
					echo "<input type=\"Hidden\" value=\"".$rowu["id"]."\" name=\"id_user\">";
					$x = 1;
					$sqlcc2 = "select * from sgm_cuerpo where idfactura=".$rowcc["id_cabezera"]." and controlcalidad=".$rowcc["id"]." order by id";
					$resultcc = mysql_query(convert_sql($sqlcc2));
					while ($rowcc2 = mysql_fetch_array($resultcc2)) {
						echo "<tr><td></td><td style=\"text-align:right\"><strong>".$rowcc2["codigo"]."</strong> ".$rowcc2["nombre"]." (<strong>".number_format($rowcc2["unidades"], 2, ',', '.')." unid.</strong>)</td></tr>";
					}
				echo "<tr><td style=\"text-align:right;\">Fecha : </td><td><input type=\"Text\" style=\"width:75px\" name=\"fecha\" value=\"".$rowcc["fecha"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha previsión : </td><td><input type=\"Text\" style=\"width:75px\" name=\"fecha_prevision\" value=\"".$rowcc["fecha_prevision"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha llegada : </td><td><input type=\"Text\" style=\"width:75px\" name=\"fecha_llegada\" value=\"".$rowcc["fecha_llegada"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">Embalage : </td><td>";
					echo "<select name=\"embalage\" style=\"width:150px\">";
						if ($rowcc["embalage"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["embalage"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Material : </td><td>";
					echo "<select name=\"material\" style=\"width:150px\">";
						if ($rowcc["material"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["material"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Medidas : </td><td>";
					echo "<select name=\"medidas\" style=\"width:150px\">";
						if ($rowcc["medidas"] == 0.0) {
							echo "<option value=\"0\" selected>100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 0.8) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\" selected>96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 1.6) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\" selected>90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 2.8) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.2\">96-100%</option>";
							echo "<option value=\"0.4\">90-96%</option>";
							echo "<option value=\"0.7\" selected>85-90%</option>";
							echo "<option value=\"1.0\">&lt;85%</option>";
						}
						if ($rowcc["medidas"] == 4.0) {
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4.0\" selected>&lt;85%</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Acabados : </td><td>";
					echo "<select name=\"acabados\" style=\"width:150px\">";
						if ($rowcc["acabados"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["acabados"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Cantidad : </td><td>";
					echo "<select name=\"cantidad\" style=\"width:150px\">";
						if ($rowcc["cantidad"] == 0.25) {
							echo "<option value=\"0\">Correcto (0)</option>";
							echo "<option value=\"0.25\" selected>Incorrecto (0,25)</option>";
						}
						if ($rowcc["cantidad"] == 0.0) {
							echo "<option value=\"0\" selected>Correcto (0)</option>";
							echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"Modificar Control Calidad\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</td><td>";
		echo "</td></tr></table>";
	}

	if (($soption == 200)) {
		echo "<strong>Control Calidad Pedido Proveedor :</strong><br><br>";
		echo "<table><tr><td>";
			echo "<table>";
				echo "<form method=\"post\" action=\"index.php?op=1015&sop=201\">";
				echo "<tr><td style=\"text-align:right\">Pedido : </td><td>";
					echo "<select name=\"id_cabezera\" style=\"width:150px\">";
						$sql = "select * from sgm_cabezera where tipo=4 and cerrada=1 and controlcalidad=0 order by numero";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["numero"]."</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Tipo de control : </td><td>";
					echo "<select name=\"tipo\" style=\"width:150px\">";
						echo "<option value=\"0\">Total</option>";
						echo "<option value=\"1\">Parcial</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"Realizar Control Calidad\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</td><td>";
		echo "</td></tr></table>";
	}


	if (($soption == 201)) {
		$sql = "select * from sgm_cabezera where id=".$_POST["id_cabezera"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$sqlp = "select * from sgm_clients where id=".$row["id_cliente"];
		$resultp = mysql_query(convert_sql($sqlp));
		$rowp = mysql_fetch_array($resultp);
		echo "<strong>Control Calidad Pedido Proveedor :</strong><br><br>";
		echo "<table><tr><td>";
			echo "<table>";
				echo "<form method=\"post\" action=\"index.php?op=1015&sop=202\" name=\"formulario\">";
				echo "<input type=\"Hidden\" name=\"id_cabezera\" value=\"".$_POST["id_cabezera"]."\">";
				echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$_POST["tipo"]."\">";
				echo "<tr><td style=\"text-align:right;\">Número pedido proveedor : </td><td><strong>".$row["numero"]."</strong></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Nombre proveedor : </td><td><strong>".$rowp["nombre"]."</strong></td></tr>";
				if ($_POST["tipo"] == 0) {
				}
				if ($_POST["tipo"] == 1) {
					echo "<tr><td style=\"text-align:right\"><em>Selecciona las lineas parciales</em></td><td></td></tr>";
					$x = 1;
					$sqlcc = "select * from sgm_cuerpo where idfactura=".$_POST["id_cabezera"]." and controlcalidad=0 order by id";
					$resultcc = mysql_query(convert_sql($sqlcc));
					while ($rowcc = mysql_fetch_array($resultcc)) {
						echo "<tr><td style=\"text-align:right\"><strong>".$rowcc["codigo"]."</strong> ".$rowcc["nombre"]." (<strong>".number_format($rowcc["unidades"], 2, ',', '.')." unid.</strong>)</td><td>";
							echo "<select name=\"linea_".$x."\" style=\"width:75px\">";
								echo "<option value=\"0\">NO</option>";
								echo "<option value=\"1\" selected>SI</option>";
							echo "</select>";
						echo "</td></tr>";
						$x++;
					}
					$sqlcc = "select * from sgm_cuerpo where idfactura=".$_POST["id_cabezera"]." and controlcalidad>0";;
					$resultcc = mysql_query(convert_sql($sqlcc));
					while ($rowcc = mysql_fetch_array($resultcc)) {
						echo "<tr><td style=\"text-align:right\"><strong>".$rowcc["codigo"]."</strong> ".$rowcc["nombre"]." (<strong>".number_format($rowcc["unidades"], 2, ',', '.')." unid.</strong>)</td><td>";
							echo "<a href=\"index.php?op=1015&sop=110&id=".$rowcc["controlcalidad"]."\">[ Ver control de calidad ]</a>";
						echo "</td></tr>";
					}
				}
				echo "<tr><td style=\"text-align:right;\">Fecha previsión : </td><td><a href=\"#\" onclick=\"formulario.fecha_llegada.value='".$row["fecha_prevision"]."'\"><strong>".$row["fecha_prevision"]."</strong></a></td></tr>";
				echo "<tr><td style=\"text-align:right;\">Fecha llegada : </td><td><input type=\"Text\" value=\"".$xdate."\" style=\"width:75px\" name=\"fecha_llegada\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">Embalage : </td><td>";
					echo "<select name=\"embalage\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcto (0)</option>";
						echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Material : </td><td>";
					echo "<select name=\"material\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcto (0)</option>";
						echo "<option value=\"0.25\">Incorrecto (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Medidas : </td><td>";
					echo "<select name=\"medidas\" style=\"width:150px\">";
							echo "<option value=\"0\">100%</option>";
							echo "<option value=\"0.8\">96-100%</option>";
							echo "<option value=\"1.6\">90-96%</option>";
							echo "<option value=\"2.8\">85-90%</option>";
							echo "<option value=\"4\">&lt;85%</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Acabados : </td><td>";
					echo "<select name=\"acabados\" style=\"width:150px\">";
						echo "<option value=\"0\">Correctos (0)</option>";
						echo "<option value=\"0.25\">Incorrectos (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\">Cantidad : </td><td>";
					echo "<select name=\"cantidad\" style=\"width:150px\">";
						echo "<option value=\"0\">Correcta (0)</option>";
						echo "<option value=\"0.25\">Incorrecta (0,25)</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"Añadir Control Calidad\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</td><td>";
		echo "</td></tr></table>";
	}

	if ($soption == 202) {
		$sql2 = "select * from sgm_cabezera where id=".$_POST["id_cabezera"];
		$result2 = mysql_query(convert_sql($sql2));
		$row2 = mysql_fetch_array($result2);
		$sql = "insert into sgm_control_calidad (id_cabezera,id_cliente,fecha,fecha_prevision,fecha_llegada,embalage,material,medidas,acabados,cantidad,puntos_fechas,total,manual) ";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_cabezera"]."";
		$sql = $sql.",".$row2["id_cliente"]."";
		$sql = $sql.",'".$row2["fecha"]."'";
		$sql = $sql.",'".$row2["fecha_prevision"]."'";
		$sql = $sql.",'".$_POST["fecha_llegada"]."'";
		$sql = $sql.",".$_POST["embalage"]."";
		$sql = $sql.",".$_POST["material"]."";
		$sql = $sql.",".$_POST["medidas"]."";
		$sql = $sql.",".$_POST["acabados"]."";
		$sql = $sql.",".$_POST["cantidad"]."";
		$i = ((( (strtotime($row2["fecha_prevision"])) - (strtotime($_POST["fecha_llegada"])) ) /86400)*(-1));
		if ($i > 5) { $i = 5; }
		if ($i < 0) { $i = 0; }
		$sql = $sql.",".$i;
		$sql = $sql.",".($_POST["embalage"]+$_POST["material"]+$_POST["medidas"]+$_POST["acabados"]+$_POST["cantidad"]+$i)."";
		$sql = $sql.",0";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		$sql3 = "select id from sgm_control_calidad order by id DESC";
		$result3 = mysql_query(convert_sql($sql3));
		$row3 = mysql_fetch_array($result3);
		$id_control_calidad = $row3["id"];
		### PONE EL ID DEL CONTROL DE CALIDAD A TODAS LAS LINEAS DEL PEDIDO PENDIENTES DE CONTRO DE CALIDAD
		if ($_POST["tipo"] == 0) {
			$sqlcc = "select * from sgm_cuerpo where idfactura=".$_POST["id_cabezera"]." and controlcalidad=0 order by id";
			$resultcc = mysql_query(convert_sql($sqlcc));
			while ($rowcc = mysql_fetch_array($resultcc)) {
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."controlcalidad=".$id_control_calidad;
				$sql = $sql." WHERE id=".$rowcc["id"]."";
				mysql_query(convert_sql($sql));
				### DESBLOQUEA ORIGEN
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."bloqueado=0";
				$sql = $sql." WHERE id=".$rowcc["id_origen"]."";
				mysql_query(convert_sql($sql));
			}
		}
		### PONE EL ID DEL CONTROL DE CALIDAD A TODAS LAS LINEAS DEL PEDIDO PENDIENTES DE CONTRO DE CALIDAD Y QUE HAN SIDO SELECCIONADAS
		if ($_POST["tipo"] == 1) {
			$x = 1;
			$sqlcc = "select * from sgm_cuerpo where idfactura=".$_POST["id_cabezera"]." and controlcalidad=0 order by id";
			$resultcc = mysql_query(convert_sql($sqlcc));
			while ($rowcc = mysql_fetch_array($resultcc)) {
				if ($_POST["linea_".$x] == 1) {
					$sql = "update sgm_cuerpo set ";
					$sql = $sql."controlcalidad=".$id_control_calidad;
					$sql = $sql." WHERE id=".$rowcc["id"]."";
					mysql_query(convert_sql($sql));
					### DESBLOQUEA ORIGEN
					$sql = "update sgm_cuerpo set ";
					$sql = $sql."bloqueado=0";
					$sql = $sql." WHERE id=".$rowcc["id_origen"]."";
					mysql_query(convert_sql($sql));
				}
				$x++;
			}
		}
		### PONE EL CONTROLCALIDAD = 1 EN LA CABEZERA DEL PEDIDO SI TODAS LAS LINEAS DEL PEDIDO TIENEN EL CONTROLCALIDAD > 0
		$sqlcc = "select count(*) as total from sgm_cuerpo where idfactura=".$_POST["id_cabezera"]." and controlcalidad=0";
		$resultcc = mysql_query(convert_sql($sqlcc));
		$rowcc = mysql_fetch_array($resultcc);
		if ($rowcc["total"] == 0) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."controlcalidad=1";
			$sql = $sql." WHERE id=".$_POST["id_cabezera"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1015&sop=0\">[ Volver ]</a>";
	}

	if ($soption == 300) {
			echo "<table>";
				echo "<tr>";
					echo "<td style=\"width:100px\">Indicador</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<form method=\"post\" action=\"index.php?op=1015&sop=301\">";
					echo "<td style=\"width:100px;vertical-align:top;\"><strong>Totales</strong></td>";
					echo "<td style=\"width:300px;vertical-align:top;\">Número de facturas, pedidos, presupuestos ... entre dos fechas dadas.</td>";
					echo "<td style=\"vertical-align:top;\">";
						$sql = "select fecha from sgm_cabezera where visible=1 order by fecha";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						$mes_inicio = date('n',strtotime($row["fecha"]));
						$year_inicio = date('Y',strtotime($row["fecha"]));
						$date = getdate(); 
						$mes_final = $date["mon"];
						$year_final = $date["year"];
						
						echo "Desde <select name=\"fecha_inicio\" style=\"width:100px\">";
						for ($x = $year_inicio; $x <= $year_final; $x++) {
							if ($x == $year_final) { $hasta = $mes_final; } else { $hasta = 12; }
							if ($x == $year_inicio) { $y = $mes_inicio; } else { $y = 1; }
							for ($y; $y <= $hasta; $y++) {
								if ($y < 10) { $pinta_mes = "0".$y; } else { $pinta_mes = $y; }
								echo "<option value=\"".$x."-".$pinta_mes."-01\">01-".$pinta_mes."-".$x."</option>";
							}
						}
						echo "</select>";
						echo "Hasta <select name=\"fecha_fin\" style=\"width:100px\">";
						for ($x = $year_inicio; $x <= $year_final; $x++) {
							if ($x == $year_final) { $hasta = $mes_final; } else { $hasta = 12; }
							if ($x == $year_inicio) { $y = $mes_inicio; } else { $y = 1; }
							for ($y; $y <= $hasta; $y++) {
								if ($y < 10) { $pinta_mes = "0".$y; } else { $pinta_mes = $y; }
								echo "<option value=\"".$x."-".$pinta_mes."-".date('t',mktime(0, 0, 0, $y, 1, $x))."\">".date('t',mktime(0, 0, 0, $y, 1, $x))."-".$pinta_mes."-".$x."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td style=\"vertical-align:top;\"><input type=\"Submit\" value=\"Consultar\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
	}

	if ($soption == 301) {
		echo "<br>Resultados de la consulta entre fecha inicial <strong>".$_POST["fecha_inicio"]."</strong> y <strong>".$_POST["fecha_fin"]."</strong> :<br><br>";
		echo "<table>";
		$sql = "select * from sgm_factura_tipos";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td>".$row["tipo"]."</td>";
				$sqlt = "select count(*) as total from sgm_cabezera where visible=1 and fecha>='".$_POST["fecha_inicio"]."' and fecha<='".$_POST["fecha_fin"]."' and tipo=".$row["id"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				echo "<td><strong>".$rowt["total"]."</strong></td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	if ($soption == 400) {
		if ($soption == 2) {
			$sql = "update sgm_equipos set ";
			$sql = $sql."codigo='".$_POST["codigo"]."'";
			$sql = $sql.",equipo='".$_POST["equipo"]."'";
			$sql = $sql.",mmodelo='".$_POST["mmodelo"]."'";
			$sql = $sql.",numerods='".$_POST["numerods"]."'";
			$sql = $sql.",preci=".$_POST["preci"]."";
			$sql = $sql.",rango='".$_POST["rango"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		if ($ssoption == 3) {
			$sql = "update sgm_equipos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Equipos de Medicion</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Numero</td>";
				echo "<td>Equipo</td>";
				echo "<td><em>Editar</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_equipos where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1015&sop=404&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td>".$row["codigo"]."</td>";
					echo "<td>".$row["equipo"]."</td>";
					echo "<td><a href=\"index.php?op=1015&sop=401&ssop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 401) {
		if ($ssoption == 1){
			echo "<strong>Añadir Nuevo Equipo</strong>";
		} else {
			echo "<strong>Modificar Equipo</strong>";
		}
		echo "<br><br><br>";
		echo "<table>";
			echo "<tr>";
			echo "<td></td>";
			$sql = "select * from sgm_control_calidad_equipos where visible=1 and id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($ssoption == 1){
				echo "<form action=\"index.php?op=1015&sop=402\" method=\"post\">";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
			} else {
				echo "<form action=\"index.php?op=1015&sop=400&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
			}
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Codigo</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"codigo\" style=\"width:150px;\" value=\"".$row["codigo"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Equipo</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"equipo\" style=\"width:150px;\" value=\"".$row["equipo"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Marca y Modelo</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"mmodelo\" style=\"width:150px;\" value=\"".$row["mmodelo"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Numero de Serie</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"numerods\" style=\"width:150px;\" value=\"".$row["numerods"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Precision</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"preci\" style=\"width:150px;\" value=\"".$row["preci"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Rango</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"rango\" style=\"width:150px;\" value=\"".$row["rango"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
					if ($ssoption == 1){
						echo "<input type=\"submit\" value=\"Añadir\" style=\"width:100px\">";
					}else{
						echo "<input type=\"submit\" value=\"Modificar\" style=\"width:100px\">";
					}
				echo "</td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 404) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este equipo?";
		echo "<br><br><a href=\"index.php?op=1015&sop=400&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1015&sop=400\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 410) {
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td>Nombre</td>";
				echo "<td>Resultados</td>";
			echo "</tr>";
			$sqlt = "select * from sgm_mantenimiento_tipo_plantilla where visible=1 and id_tipo_mantenimiento=".$_GET["id_tipo_mantenimiento"];
			$resultt = mysql_query(convert_sql($sqlt));
			while ($rowt = mysql_fetch_array($resultt)) {
				echo "<tr>";
					$sqlt2 = "select * from sgm_ft_plantilla where id=".$rowt["id_plantilla"]."";
					$resultt2 = mysql_query(convert_sql($sqlt2));
					$rowt2 = mysql_fetch_array($resultt2);
					echo "<td>".$rowt2["plantilla"]."</td>";
					echo "<td>";
					$sqlres = "select count(*) as total from sgm_ft where id_plantilla=".$rowt["id"]." and id_mantenimiento=".$_GET["id_mantenimiento"];
					$resultres = mysql_query(convert_sql($sqlres));
					$rowres = mysql_fetch_array($resultres);
					if ($rowres["total"] == 0) {
						echo "<a href=\"index.php?op=1023&sop=210&id_mantenimiento=".$_GET["id_mantenimiento"]."&id_plantilla=".$rowt["id_plantilla"]."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px\">";
					}
					if ($rowres["total"] == 1) {
						$sqlres2 = "select * from sgm_ft where id_plantilla=".$rowt["id"]." and id_mantenimiento=".$_GET["id_mantenimiento"];
						$resultres2 = mysql_query(convert_sql($sqlres2));
						$rowres2 = mysql_fetch_array($resultres2);
						echo "<a href=\"index.php?op=1023&sop=210&id_ft=".$rowres2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\">";
					}
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 411) {
		$sqlt = "select * from sgm_mantenimiento_tipo where visible=1 and id=".$_GET["id_mantenimiento"]."";
		$resultt = mysql_query(convert_sql($sqlt));
		$rowt = mysql_fetch_array($resultt);
		echo "<strong>Plantillas de: ".$rowt["nombre"]."</strong><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"width:150px;text-align:center;\">Plantilla</td>";
				echo "<td style=\"width:150px;text-align:center;\"><em>Editar</em></td>";
			echo "</tr>";
				$sql = "select * from sgm_mantenimiento_tipo_plantilla where visible=1 and id_tipo_mantenimiento=".$rowt["id"]."";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)){
					$sqlp = "select * from sgm_ft_plantilla where visible=1 and id=".$row["id_plantilla"]."";
					$resultp = mysql_query(convert_sql($sqlp));
					while ($rowp = mysql_fetch_array($resultp)) {
						echo "<tr>";
							echo "<td style=\"width:150px;text-align:left;\">".$rowp["plantilla"]."</td>";
							echo "<td style=\"width:150px;text-align:center;\"><a href=\"index.php?op=1015&sop=412&id_mantenimiento=".$_GET["id_mantenimiento"]."&id_plantilla=".$rowp["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></td>";
						echo "</tr>";
					}
				}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 412) {
		if ($_GET["id_ft"] != "") {
			$id_ft = $_GET["id_ft"];
		} else {
		### incio añadir nueva hoja de trabajo
		$sql = "insert into sgm_ft (id_plantilla,id_mantenimiento)";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_plantilla"]."";
		$sql = $sql.",".$_POST["id_mantenimiento"]."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		$sql = "select * from sgm_ft order by id desc";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$id_ft = $row["id"];
		$sql = "select * from sgm_ft_plantilla_tipus where id_ft=".$_POST["id_plantilla"]." and visible=1";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sqlx = "insert into sgm_ft_dades (id_ft,id_plantilla_tipus,id_platilla_tipus_campo,descripcion)";
			$sqlx = $sqlx."values (";
			$sqlx = $sqlx."".$id_ft."";
			$sqlx = $sqlx.",".$row["id"]."";
			$sqlx = $sqlx.",0";
			$sqlx = $sqlx.",''";
			$sqlx = $sqlx.")";
			mysql_query(convert_sql($sqlx));
		}
		################FIN
		}
			echo "<strong>Introducción datos plantilla : </strong><br><br>";
		$sqlft = "select * from sgm_ft where id=".$id_ft;
		$resultft = mysql_query(convert_sql($sqlft));
		$rowft = mysql_fetch_array($resultft);

		$sqlftp = "select * from sgm_ft_plantilla where id=".$rowft["id_plantilla"];
		$resultftp = mysql_query(convert_sql($sqlftp));
		$rowftp = mysql_fetch_array($resultftp);

		$col = $rowftp["columnas"];
		$fil = $rowftp["filas"];
		if ($col == 0) { $col = 1; }
		echo "<form action=\"index.php?op=1015&sop=413&id_ft=".$id_ft."\" method=\"post\">";
		$celda=1;
		$ancho = 750/$col;
		echo "<table border=\"1px\">";
		for ($xfil = 1; $xfil <= $fil ;$xfil++) {
			echo "<tr>";
			for ($xcol = 1; $xcol <= $col ;$xcol++) {
				echo "<td style=\"vertical-align:top;width:".$ancho."px;\">&nbsp;";
					$sql = "select * from sgm_ft_plantilla_tipus where id_ft=".$rowft["id_plantilla"]." and celda=".$celda." and visible=1 order by orden";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						$sqldades = "select * from sgm_ft_dades where id_ft=".$id_ft." and id_plantilla_tipus=".$row["id"];
						$resultdades = mysql_query(convert_sql($sqldades));
						$rowdades = mysql_fetch_array($resultdades);
						if ($row["taula"] == 0) {
							echo "<br><br><strong>".$row["tipus"]."</strong><br><em>(".$row["descripcion"].")</em>";
							echo "<br><textarea name=\"textarea".$row["id"]."\" rows=\"5\" style=\"width:".$ancho."px;\">".$rowdades["descripcion"]."</textarea>";
						}
						if ($row["taula"] == 1) {
							echo "<br><br><strong>".$row["tipus"]."</strong><br><em>(".$row["descripcion"].")</em>";
							echo "<br><select name=\"select".$row["id"]."\" style=\"width:".$ancho."px;\">";
								echo "<option value=\"0\">-</option>";
								$sqlxx = "select * from sgm_ft_plantilla_tipus_campos where id_ft_plantilla_tipus=".$row["id"]." and visible=1";
								$resultxx = mysql_query(convert_sql($sqlxx));
								while ($rowxx = mysql_fetch_array($resultxx)) {
									if ($rowdades["id_platilla_tipus_campo"] == $rowxx["id"]) {
										echo "<option value=\"".$rowxx["id"]."\" selected>".$rowxx["campos"]."</option>";
									} else {
										echo "<option value=\"".$rowxx["id"]."\">".$rowxx["campos"]."</option>";
									}
								}
							echo "</select>";
						}
					}
				echo "</td>";
				$celda++;
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "<br><br><input type=\"submit\" value=\"Actualizar\">";
		echo "</form>";
	}

	if ($soption == 413) {
		$sqlft = "select * from sgm_ft where id=".$_GET["id_ft"];
		$resultft = mysql_query(convert_sql($sqlft));
		$rowft = mysql_fetch_array($resultft);
		$sqlt = "select * from sgm_ft_plantilla_tipus where id_ft=".$rowft["id_plantilla"]." and visible=1";;
		$resultt = mysql_query(convert_sql($sqlt));
		while ($rowt = mysql_fetch_array($resultt)) {
			$sqldades = "select count(*) as total from sgm_ft_dades where id_plantilla_tipus=".$rowt["id"]." and id_ft=".$_GET["id_ft"];
			$resultdades = mysql_query(convert_sql($sqldades));
			$rowdades = mysql_fetch_array($resultdades);
			if ($rowdades["total"] == 1) {
				$sqldades2 = "select * from sgm_ft_dades where id_plantilla_tipus=".$rowt["id"]." and id_ft=".$_GET["id_ft"];
				$resultdades2 = mysql_query(convert_sql($sqldades2));
				$rowdades2 = mysql_fetch_array($resultdades2);
				$sqlx = "update sgm_ft_dades set ";
				$sqlx = $sqlx."descripcion='".$_POST["textarea".$rowt["id"].""]."'";
				if ($_POST["select".$rowt["id"].""] != "") {
					$sqlx = $sqlx.",id_platilla_tipus_campo=".$_POST["select".$rowt["id"].""]."";
				}
				$sqlx = $sqlx." WHERE id=".$rowdades2["id"]."";
				mysql_query(convert_sql($sqlx));
			}
			if ($rowdades["total"] == 0) {
				if ($rowt["taula"] == 1) {
					$sqlx = "insert into sgm_ft_dades (id_ft,id_plantilla_tipus,id_platilla_tipus_campo)";
					$sqlx = $sqlx."values (";
					$sqlx = $sqlx."".$id_ft."";
					$sqlx = $sqlx.",".$rowt["id"]."";
					$sqlx = $sqlx.",".$_POST["select".$rowt["id"].""];
					$sqlx = $sqlx.")";
					mysql_query(convert_sql($sqlx));
				}
				if ($rowt["taula"] == 0) {
					$sqlx = "insert into sgm_ft_dades (id_ft,id_plantilla_tipus,descripcion)";
					$sqlx = $sqlx."values (";
					$sqlx = $sqlx."".$id_ft."";
					$sqlx = $sqlx.",".$rowt["id"]."";
					$sqlx = $sqlx.",'".$_POST["textarea".$rowt["id"].""]."'";
					$sqlx = $sqlx.")";
					mysql_query(convert_sql($sqlx));
				}
			}
		}
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1015&sop=412&id_ft=".$_GET["id_ft"]."\">[ Volver ]</a>";
	}

	if ($soption == 421) {
		if ($ssoption == 3) {
			$sql = "update sgm_ft set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		$sql = "select * from sgm_equipos where visible=1 and id=".$_GET["id_equipo"]."";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>Listado Plantillas: ".$row["equipo"]."</strong><br><br>";
		$lineas_por_pagina = 25;
		$paginas = ceil($row["total2"]/$lineas_por_pagina);
		if ($_GET["pag"] == "") { $pag = 1; } else { $pag = $_GET["pag"]; }
		$inicio = $lineas_por_pagina*($pag-1);
		echo "<br><center>";
		echo "<a href=\"index.php?op=1015&sop=421\">Primera</a>&nbsp;&nbsp;";
		if ($pag == 1) { echo "&laquo;&laquo;&nbsp;&nbsp;"; } else { echo "<a href=\"index.php?op=1015&sop=421&pag=".($pag-1)."\">&laquo;&laquo;</a>&nbsp;&nbsp;"; }
		echo $pag;
		if ($pag == $paginas) { echo "&nbsp;&nbsp;&raquo;&raquo;"; } else { echo "&nbsp;&nbsp;<a href=\"index.php?op=1015&sop=421&pag=".($pag+1)."\">&raquo;&raquo;</a>"; }
		echo "&nbsp;&nbsp;<a href=\"index.php?op=1015&sop=421&pag=".$paginas."\">Última</a>";
		echo "</center><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;width:150px\">Calibraciones</td>";
				echo "<td style=\"text-align:center;width:150px\">Plantilla</td>";
#				echo "<td style=\"text-align:center;width:75px\">OT</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		$pintar = true;
		$sql = "select * from sgm_ft where visible=1 and order by id desc limit ".$inicio.", ".$lineas_por_pagina;
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sqlc = "select * from sgm_mantenimiento_tipo where id=".$row["id_manteniment"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$sqlp = "select * from sgm_mantenimiento_tipo_plantilla where id=".$row["id_plantilla"];
			$resultpc = mysql_query(convert_sql($sqlp));
			$rowp = mysql_fetch_array($resultp);
			if ($pintar == true) { $color = "#C8C8C8"; $pintar =false; }
			else {$color = "white"; $pintar = true; }
			echo "<tr style=\"background-color:".$color.";\">";
				echo "<td style=\"width:50px\">".$row["id"]."</td>";
				echo "<td><a href=\"index.php?op=1015&sop=422&id_mantenimiento=".$row["id"]."&pag=".$paginas."\">[E]</a></td>";
				echo "<td>".$rowc["nombre"]."</td>";
				echo "<td>".$rowp["plantilla"]."</td>";
				echo "<td><a href=\"index.php?op=1015&sop=430&id_ft=".$row["id"]."\">[ Editar ]</a></td>";
				echo "<td><a href=\"mgestion/gestion-produccion-ft-print.php?id_ft=".$row["id"]."\" target=\"_blank\">[ Imprimir ]</a></td>";
				
			echo "</tr>";
		}
		echo "</table>";
		echo "<br><center>";
		echo "<a href=\"index.php?op=1015&sop=201\">Primera</a>&nbsp;&nbsp;";
		if ($pag == 1) { echo "&laquo;&laquo;&nbsp;&nbsp;"; } else { echo "<a href=\"index.php?op=1015&sop=421&pag=".($pag-1)."\">&laquo;&laquo;</a>&nbsp;&nbsp;"; }
		echo $pag;
		if ($pag == $paginas) { echo "&nbsp;&nbsp;&raquo;&raquo;"; } else { echo "&nbsp;&nbsp;<a href=\"index.php?op=1015&sop=421&pag=".($pag+1)."\">&raquo;&raquo;</a>"; }
		echo "&nbsp;&nbsp;<a href=\"index.php?op=1015&sop=421&pag=".$paginas."\">Última</a>";
		echo "</center><br>";
	}

	if ($soption == 422) {
		echo "<br><br>¿Desea eliminar el nombre seleccionado?";
		echo "<br><br><a href=\"index.php?op=1015&sop=421&ssop=3&id=".$_GET["id_mantenimiento"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1015&sop=421&pag=".$_GET["pag"]."\">[NO]</a>";
	}


	if ($soption == 500) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_mantenimiento (id_tipo_mantenimiento,id_equipo,fecha) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["id_tipo_mantenimiento"]."";
			$sql = $sql.",".$_POST["id_equipo"]."";
			$sql = $sql.",'".$_POST["fecha"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_mantenimiento set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Plan de Calibraciones</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:500px;\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td>Tipo</td>";
				echo "<td>Equipo / Codigo</td>";
				echo "<td>Fecha</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><form action=\"index.php?op=1015&sop=500&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select name=\"id_tipo_mantenimiento\" style=\"width:150px\">";
					$sqlt = "select * from sgm_mantenimiento_tipo where visible=1 and id_clase=1";
					$resultt = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($resultt)){
							echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
					}
					echo "</select></td>";
				echo "<td><select name=\"id_equipo\" style=\"width:150px\">";
					$sqle = "select * from sgm_equipos where visible=1";
					$resulte = mysql_query(convert_sql($sqle));
					while ($rowe = mysql_fetch_array($resulte)){
							echo "<option value=\"".$rowe["id"]."\">".$rowe["equipo"]." / ".$rowe["codigo"]."</option>";
					}
				echo "</select></td>";
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				echo "<td><input type=\"text\" name=\"fecha\" style=\"width:90px;\" value=\"".$date1."\"></td>";
				echo "<td><input type=\"submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>&nbsp;</tr>";
			echo "<tr><form action=\"index.php?op=1015&sop=500\" method=\"post\">";
				echo "<td></td>";
				echo "<td>Tipo</td>";
				echo "<td>Equipo / Codigo</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><select name=\"id_tipo_mantenimiento\" style=\"width:150px\">";
					echo "<option value=\"0\" selected>-</option>";
					$sqlt = "select * from sgm_mantenimiento_tipo where visible=1 and id_clase=1";
					$resultt = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($resultt)){
							echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
					}
					echo "</select></td>";
				echo "<td><select name=\"id_equipo\" style=\"width:150px\">";
					echo "<option value=\"0\" selected>-</option>";
					$sqle = "select * from sgm_equipos where visible=1";
					$resulte = mysql_query(convert_sql($sqle));
					while ($rowe = mysql_fetch_array($resulte)){
							echo "<option value=\"".$rowe["id"]."\">".$rowe["equipo"]." / ".$rowe["codigo"]."</option>";
					}
				echo "</select></td>";
				echo "<td></td>";
				echo "<td><input type=\"submit\" value=\"Filtrar\" style=\"width:100px\"</td>";
				echo "<td style=\"width:100px\"></td></form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Tipo de Calibracion</td>";
				echo "<td>Equipo</td>";
				echo "<td>Fecha<br>Proxima</td>";
				echo "<td><em>Calibraciones</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_mantenimiento where visible=1";
			if (($_POST["id_tipo_mantenimiento"] != "") and ($_POST["id_tipo_mantenimiento"] != 0)) { $sql = $sql." and id_tipo_mantenimiento = ".$_POST["id_tipo_mantenimiento"].""; }
			if (($_POST["id_equipo"] != "") and ($_POST["id_equipo"] != 0)) { $sql = $sql." and id_equipo = ".$_POST["id_equipo"].""; }
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				#$date = getdate();
				#$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				#if ($row["fecha"]>= $date1){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1015&sop=501&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						$sqlm = "select * from sgm_mantenimiento_tipo where visible=1 and id=".$row["id_tipo_mantenimiento"]."";
						$resultm = mysql_query(convert_sql($sqlm));
						$rowm = mysql_fetch_array($resultm);
						echo "<td>".$rowm["nombre"]."</td>";
						$sqlc = "select * from sgm_equipos where visible=1 and id=".$row["id_equipo"]."";
						$resultc = mysql_query(convert_sql($sqlc));
						$rowc = mysql_fetch_array($resultc);
						echo "<td>".$rowc["equipo"]." / ".$rowc["codigo"]."</td>";
						echo "<td>".$row["fecha"]."</td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1015&sop=410&id_tipo_mantenimiento=".$row["id_tipo_mantenimiento"]."&id_mantenimiento=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/wrench_orange.png\" style=\"border:0px\"></a></td>";
					echo "</tr>";
				#}
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 501) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este equipo?";
		echo "<br><br><a href=\"index.php?op=1015&sop=500&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1015&sop=500\">[ NO ]</a>";
		echo "</center>";
	}




echo "</td></tr></table><br>";
}
?>
