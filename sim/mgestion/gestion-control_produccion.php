<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1014) AND ($autorizado == true)) {


	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<strong>Control de Producción 1.071011</strong>";
			echo "<br>";
			echo "<br>";

			$sqltipos = "select * from sgm_factura_tipos where tipo_ot=1 order by orden";
			$resulttipos = mysql_query(convertSQL($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)) {
				echo "<a href=\"index.php?op=1014&sop=10&id=".$rowtipos["id"]."&ssop=1\"><strong>H</strong></a>&nbsp;";
				echo "<a href=\"index.php?op=1014&sop=10&id=".$rowtipos["id"]."\">&raquo; ".$rowtipos["tipo"]."</a>";
				echo "<br>";
			}



			echo "<br><a href=\"index.php?op=1014&sop=30\">&raquo; Listado de estados de producción</a>";
			echo "<br><a href=\"index.php?op=1014&sop=110\">&raquo; Listado de estados de ordenes</a>";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<br>";
			if ($admin == true) {
				echo "<br><a href=\"index.php?op=1014&sop=70\">&raquo; Lista materiales pendientes</a>";
				echo "<br>";
				echo "<br><a href=\"index.php?op=1014&sop=100\">&raquo; Tabla estados producción</a>";
			}
			if ($admin == false) {
				echo "<br>&raquo; Lista materiales pendientes";
				echo "<br>";
				echo "<br>&raquo; Tabla estados producción";
			}
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 1) or ($soption == 11) or ($soption == 50) or ($soption == 60)) {
		$sqlp = "select * from sgm_cuerpo where id=".$_GET["id"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);

		$sqlf = "select * from sgm_cabezera where id=".$rowp["idfactura"];
		$resultf = mysql_query(convertSQL($sqlf));
		$rowf = mysql_fetch_array($resultf);

		echo "<table style=\"width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr><td style=\"width:50%;vertical-align : top;text-align:left;\">";
				echo "<strong>Histórico de pieza : </strong>".$rowp["nombre"];
				echo "<br><strong>Unidades : </strong>".$rowp["unidades"];
				echo "<br><a href=\"index.php?op=1014&sop=22&id=".$rowf["id"]."\">&raquo; Volver al pedido </a>";
				echo "<br>";
				echo "<br><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">&raquo; Procesos/Incidencias </a>";
				echo "<br><a href=\"index.php?op=1014&sop=11&id=".$_GET["id"]."\">&raquo; Orden de seguimiento</a>";
				echo "<br><a href=\"index.php?op=1014&sop=60&id=".$_GET["id"]."\">&raquo; Materiales</a>";
				echo "<br><a href=\"index.php?op=1014&sop=50&id=".$_GET["id"]."\">&raquo; Gestión archivos</a>";
			echo "</td><td style=\"width:50%;vertical-align : top;text-align:left;\">";
				echo "<strong>Nº pedido : </strong>".$rowf["numero"];
				echo "<br><strong>Código : </strong>".$rowp["codigo"];
				echo "<br><strong>Nº ref. cliente : </strong>".$rowf["numero_cliente"];
				echo "<br><strong>Cliente : </strong>".$rowf["nombre"];
				echo "<br>";
				echo "<br><strong>Fecha pedido : </strong>".$rowf["fecha"];
				echo "<br><strong>Fecha entrega : </strong>".$rowp["fecha_prevision"];
		echo "</td></tr></table><br>";
	}


	if ($soption == 1) {
		$sqlp = "select * from sgm_cuerpo where id=".$_GET["id"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);
		echo "<table><tr><td style=\"vertical-align:top;width:50%\">";
			if ($rowp["bloqueado"] == 0) { 
				echo "<table cellspacing=\"0\">";
					echo "<form method=\"post\" action=\"index.php?op=1014&sop=2&id=".$_GET["id"]."\">";
						$date = getdate();
						echo "<td></td>";
						echo "<td><input style=\"width:75px\" name=\"fecha\" type=\"Text\" value=\"".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."\"></td>";
						echo "<td><input style=\"width:60px\" name=\"hora\" type=\"Text\" value=\"".date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."\"></td>";
						echo "<td>";
						echo "<select style=\"width:125px\" name=\"id_estado\">";
							echo "<option value=\"0\">Sin Iniciar</option>";
							echo "<option value=\"-1\">Finalizado</option>";
							$sqles = "select * from sgm_cuerpo_estados order by estado";
							$resultes = mysql_query(convertSQL($sqles));
							while ($rowes = mysql_fetch_array($resultes)) {
								echo "<option value=\"".$rowes["id"]."\">".$rowes["estado"]."</option>";
							}
						echo "</select>";
						echo "</td>";
						echo "<td><input type=\"submit\" value=\"Añadir\"></td>";
					echo "</form>";
				echo "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
				echo "</table>";
			} else { echo "<strong style=\"color:red;text-align:center;\">PIEZA EN PROCESO EXTERNO : PENDIENTE CONTROL CALIDAD</strong><br><br>"; }

			$sql = "select * from sgm_cuerpo_estados_historico where id_cuerpo=".$_GET["id"]." order by fecha desc, hora desc";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				#### MUESTRA INCIDENCIAS DEL PROCESO
				$sqli = "select * from sgm_cuerpo_incidencias where id_proceso=".$row["id"]." order by fecha desc, hora desc";
				$resulti = mysql_query(convertSQL($sqli));
				while ($rowi = mysql_fetch_array($resulti)) {
					echo "<table cellspacing=\"0\">";
						echo "<tr>";
							echo "<td><form method=\"post\" action=\"index.php?op=1014&sop=7&id=".$_GET["id"]."&id_incidencia=".$rowi["id"]."\"><input type=\"Submit\" value=\"E\"></form></td>";
							if ($rowi["cerrada"] == 0) { echo "<td style=\"color:red;width:230px\">Incidencia-Abierta (Prev. : ".$rowi["fecha_prevision"].")</td>"; }
							if ($rowi["cerrada"] == 1) { echo "<td style=\"color:green;width:230px\">Incidencia-Cerrada</td>"; }
							echo "<form method=\"post\" action=\"index.php?op=1014&sop=3&id=".$_GET["id"]."&id_incidencia=".$rowi["id"]."\">";
							echo "<td><input type=\"submit\" value=\"Ver-Editar\" style=\"width:60px\"></td>";
						echo "</form>";
						echo "</tr>";
					echo "</table>";
				}

				#### MUESTRA PROCESO
				$sqle = "select * from sgm_cuerpo_estados where id=".$row["id_estado"];
				$resulte = mysql_query(convertSQL($sqle));
				$rowe = mysql_fetch_array($resulte);
					$sqles = "select * from sgm_cuerpo_estados where id=".$row["id_estado"];
					$resultes = mysql_query(convertSQL($sqles));
					$rowes = mysql_fetch_array($resultes);
				echo "<table cellspacing=\"0\">";
				echo "<tr style=\"background-color:".$rowes["color"]."\">";
					echo "<td><form method=\"post\" action=\"index.php?op=1014&sop=4&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\"><input type=\"Submit\" value=\"E\"></form></td>";
					echo "<form method=\"post\" action=\"index.php?op=1014&sop=3&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
					echo "<td><input style=\"width:75px\" name=\"fecha\" type=\"Text\" value=\"".$row["fecha"]."\"></td>";
					echo "<td><input style=\"width:60px\" name=\"hora\" type=\"Text\" value=\"".$row["hora"]."\"></td>";
					echo "<td>";
					echo "<select style=\"background-color:".$rowes["color"].";width:125px\" name=\"id_estado\">";
						if ($row["id_estado"] == 0) { echo "<option value=\"0\" selected>Sin Iniciar</option>"; }
						else { echo "<option value=\"0\">Sin Iniciar</option>"; }
						if ($row["id_estado"] == -1) { echo "<option value=\"-1\" selected>Finalizado</option>"; }
						else { echo "<option value=\"-1\">Finalizado</option>"; }
						$sqles = "select * from sgm_cuerpo_estados order by estado";
						$resultes = mysql_query(convertSQL($sqles));
						while ($rowes = mysql_fetch_array($resultes)) {
							if ($rowes["id"] == $row["id_estado"]) { echo "<option value=\"".$rowes["id"]."\" selected>".$rowes["estado"]."</option>"; }
							else { echo "<option value=\"".$rowes["id"]."\">".$rowes["estado"]."</option>"; }
						}
					echo "</select>";
					echo "</td>";
					echo "<td><input type=\"submit\" value=\"Cambiar\" style=\"width:60px\"></td>";
				echo "</form>";
				echo "</tr>";
				echo "</table>";

			}
		echo "</td><td style=\"vertical-align:top;width:50%\">";
			echo "<strong>Añadir incidencia :</strong><br><br>";
			echo "<table>";
				echo "<form method=\"post\" action=\"index.php?op=1014&sop=6&id=".$_GET["id"]."\">";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Proceso : </td>";
				echo "<td>";
					echo "<select style=\"width:300px\" name=\"id_proceso\">";
						$sqles = "select * from sgm_cuerpo_estados_historico where id_cuerpo=".$_GET["id"]." order by fecha desc, hora desc";
						$resultes = mysql_query(convertSQL($sqles));
						while ($rowes = mysql_fetch_array($resultes)) {
							$sqlest = "select * from sgm_cuerpo_estados where id=".$rowes["id_estado"];
							$resultest = mysql_query(convertSQL($sqlest));
							$rowest = mysql_fetch_array($resultest);
							echo "<option value=\"".$rowes["id"]."\">".$rowes["fecha"]." (".$rowes["hora"].") ".$rowest["estado"]."</option>";
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Fecha y Hora : </td><td>";
					echo "<input type=\"text\" name=\"fecha\" style=\"width:75px\" value=\"".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."\">";
					echo "&nbsp;&nbsp;<input type=\"text\" name=\"hora\" style=\"width:75px\" value=\"".date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."\">";
				echo "</td></tr>";

				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Problema : </td><td><textarea name=\"problema\" rows=\"2\" style=\"width:300px\"></textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Causas : </td><td><textarea name=\"causa\" rows=\"2\" style=\"width:300px\"></textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Solución :</td><td><textarea name=\"solucion\" rows=\"2\" style=\"width:300px\"></textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Acción correctiva : </td><td><textarea name=\"accion_correctiva\" rows=\"2\" style=\"width:300px\"></textarea></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Fecha de previsión : </td><td><input type=\"text\" name=\"fecha_prevision\" style=\"width:75px\" value=\"".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Cerrada : </td><td>";
					echo "<select style=\"width:50px\" name=\"cerrada\">";
						echo "<option value=\"0\">NO</option>";
						echo "<option value=\"1\">SI</option>";
					echo "</select>";

				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Fecha cierre : </td><td><input type=\"text\" name=\"fecha_cierre\" style=\"width:75px\" value=\"".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."\"></td></tr>";
				echo "<tr><td></td><td><input type=\"Submit\" value=\"Añadir incidencia\" style=\"width:300px\"></td></tr>";
				echo "</form>";
			echo "</table>";
		echo "</td></tr></table>";
	}

	if ($soption == 2) {
		$sql = "update sgm_cuerpo set ";
		$sql = $sql."id_estado=".$_POST["id_estado"];
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convertSQL($sql));
	
		$sql1 = "insert into sgm_cuerpo_estados_historico (id_cuerpo,id_estado,fecha,hora) ";
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$_GET["id"];
		$sql1 = $sql1.",".$_POST["id_estado"];
			$date = getdate();
		$sql1 = $sql1.",'".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."'";
		$sql1 = $sql1.",'".date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."'";
		$sql1 = $sql1.")";
		mysql_query(convertSQL($sql1));
	
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 3) {
		$sql = "update sgm_cuerpo_estados_historico set ";
		$sql = $sql."id_estado=".$_POST["id_estado"];
		$sql = $sql.",fecha='".$_POST["fecha"]."'";
		$sql = $sql.",hora='".$_POST["hora"]."'";
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
		mysql_query(convertSQL($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 4) {
		echo "<br><br>¿Seguro que desea eliminar este proceso?";
		echo "<br><br><a href=\"index.php?op=1014&sop=5&id=".$_GET["id"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">[ SI ]</a><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if ($soption == 5) {
		$sql = "delete from sgm_cuerpo_estados_historico WHERE id=".$_GET["id_cuerpo"];
		mysql_query(convertSQL($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 6) {
		if ($_POST["cerrada"] == 0) { $sql1 = "insert into sgm_cuerpo_incidencias (id_cuerpo,id_proceso,fecha,hora,problema,causa,solucion,accion_correctiva,fecha_prevision,cerrada) "; }
		if ($_POST["cerrada"] == 1) { $sql1 = "insert into sgm_cuerpo_incidencias (id_cuerpo,id_proceso,fecha,hora,problema,causa,solucion,accion_correctiva,fecha_prevision,cerrada,fecha_cierre) "; }
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$_GET["id"];
		$sql1 = $sql1.",".$_POST["id_proceso"];
		$sql1 = $sql1.",'".$_POST["fecha"]."'";
		$sql1 = $sql1.",'".$_POST["hora"]."'";
		$sql1 = $sql1.",'".$_POST["problema"]."'";
		$sql1 = $sql1.",'".$_POST["causa"]."'";
		$sql1 = $sql1.",'".$_POST["solucion"]."'";
		$sql1 = $sql1.",'".$_POST["accion_correctiva"]."'";
		$sql1 = $sql1.",'".$_POST["fecha_prevision"]."'";
		$sql1 = $sql1.",'".$_POST["cerrada"]."'";
		if ($_POST["cerrada"] == 1) { $sql1 = $sql1.",'".$_POST["fecha_cierre"]."'"; }
		$sql1 = $sql1.")";
		mysql_query(convertSQL($sql1));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 7) {
		echo "<br><br>¿Seguro que desea eliminar esta incidencia?";
		echo "<br><br><a href=\"index.php?op=1014&sop=8&id=".$_GET["id"]."&id_incidencia=".$_GET["id_incidencia"]."\">[ SI ]</a><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if ($soption == 8) {
		$sql = "delete from sgm_cuerpo_incidencias WHERE id=".$_GET["id_incidencia"];
		mysql_query(convertSQL($sql));
		echo $sql."<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=1&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 10) {
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id"]." order by id";
		$resulttipos = mysql_query(convertSQL($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);

		echo "<table style=\"width:100%\"><tr><td style=\"width:50%\">";
			echo "<strong style=\"font-size : 20px;\">".$rowtipos["tipo"]."</strong><br><br>";
		echo "</td><td style=\"width:50%;background-color : #DBDBDB;text-align:center;\">";
			echo "<strong>Opciones</strong><br>";
			echo "<center><table>";

				echo "<tr>";
				echo "<form action=\"index.php?op=1014&sop=10&filtra=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
				echo "<td>Cliente &nbsp;</td>";
				echo "<td>";
					echo "<select style=\"width:180px\" name=\"id_cliente\">";
					echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 ";
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (cliente=1 or impacto=1 or proveedor=1) "; }
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 0)) { $sql = $sql." and (cliente=1 or impacto=1) "; }
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 0) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (cliente=1 or proveedor=1) "; }
						if (($rowtipos["cliente"] == 0) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (impacto=1 or proveedor=1) "; }
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 0) and ($rowtipos["proveedor"] == 0)) { $sql = $sql." and (cliente=1) "; }
						if (($rowtipos["cliente"] == 0) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 0)) { $sql = $sql." and (impacto=1) "; }
						if (($rowtipos["cliente"] == 0) and ($rowtipos["impacto"] == 0) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (proveedor=1) "; }
						$sql = $sql."order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"Filtro\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "</tr>";

				echo "<tr>";
				echo "<form action=\"index.php?op=1014&sop=10&ssop=1&filtra=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
				echo "<td>Cliente &nbsp;</td>";
				echo "<td>";
					echo "<select style=\"width:180px\" name=\"id_cliente\">";
					echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 ";
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (cliente=1 or impacto=1 or proveedor=1) "; }
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 0)) { $sql = $sql." and (cliente=1 or impacto=1) "; }
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 0) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (cliente=1 or proveedor=1) "; }
						if (($rowtipos["cliente"] == 0) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (impacto=1 or proveedor=1) "; }
						if (($rowtipos["cliente"] == 1) and ($rowtipos["impacto"] == 0) and ($rowtipos["proveedor"] == 0)) { $sql = $sql." and (cliente=1) "; }
						if (($rowtipos["cliente"] == 0) and ($rowtipos["impacto"] == 1) and ($rowtipos["proveedor"] == 0)) { $sql = $sql." and (impacto=1) "; }
						if (($rowtipos["cliente"] == 0) and ($rowtipos["impacto"] == 0) and ($rowtipos["proveedor"] == 1)) { $sql = $sql." and (proveedor=1) "; }
						$sql = $sql."order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"Filtro Hist.\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "</tr>";

			echo "</table></center>";
			echo "<br>";
		echo "</td></tr></table>";

		echo "<br>";




		echo "<table cellpadding=\"1\" cellspacing=\"0\">";

			echo "<tr><td style=\"width:60px\"><em><center>Número</center></em></td><td style=\"width:75px\"><em>Fecha</em></td><td style=\"width:75px\"><em>Fecha previsión</em></td><td style=\"width:75px\"><em><center>Ref. Ped. Cli.</center><td style=\"width:180px\"><em>Cliente</em></td><td></td></tr>";
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$_GET["id"]."";
				if (($_GET["filtra"]  == 1) AND ($_POST["id_cliente"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente"]; }
			$sql = $sql." order by numero desc,fecha desc";

			$result = mysql_query(convertSQL($sql));
			$fechahoy = getdate();
			$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-100, $fechahoy["year"]));
			$hoy = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
			while ($row = mysql_fetch_array($result)) {



				#### OPCIONES DE VISUALIZACION SI SE MUESTRA O NO
				$ver = 0;
				if ($data1 <= $row["fecha"]) { $ver = 1; }
				if ($row["cerrada"] == 1) { $ver = 0; }
				if ($ssoption == 1) { $ver = 1; }

				if ($ver == 1) {

					########## FECHAS AVISOS CERCANIA FECHA PREVISION
					$a = date("Y", strtotime($row["fecha_prevision"]));
					$m = date("m", strtotime($row["fecha_prevision"]));
					$d = date("d", strtotime($row["fecha_prevision"]));
					$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
					$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
					$color = "#00EC00";
					if ($rowtipos["id"] == 5) {
						if ($fecha_prevision <= $hoy) { $color = "#FF1515"; }
						else {
							if ($fecha_aviso < $hoy) { $color = "orange"; } else { $color = "#00EC00"; }
						}
					} else { $color = "#00EC00"; }

					if ($row["cerrada"] == 1) { $color = "white"; }


					echo "<tr style=\"background-color : ".$color."\">";
						echo "<td><center>".$row["numero"]."</center></td>";
						############ CALCULOS SOBRE LAS FECHAS OFICIALES
							$a = date("Y", strtotime($row["fecha"]));
							$m = date("m", strtotime($row["fecha"]));
							$d = date("d", strtotime($row["fecha"]));
							$date = getdate();
							if ($date["year"]."-".$date["mon"]."-".$date["mday"] < $row["fecha"]) {
								$fecha_proxima = $row["fecha"];
							}
							else { 
								$fecha_proxima = $row["fecha"];
								$multiplica = 0;
								$sql00 = "select * from sgm_facturas_relaciones where id_plantilla=".$row["id"]." order by fecha";
								$result00 = mysql_query(convertSQL($sql00));
								while ($row00 = mysql_fetch_array($result00)) {
									if ($fecha_proxima == $row00["fecha"]) {
										$multiplica++;
										$fecha_proxima = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*$multiplica), $a));
									}
								}
							}
						if ($rowtipos["dias"] == 0) { echo "<td style=\"text-align:center;\"><strong>".$row["fecha"]."</strong></td>"; }
							else { 
								if ($fecha_proxima > $date1) {
									$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
									if ($fecha_aviso <  $date1) { echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
									else { echo "<td style=\"text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
								}
								else { echo "<td style=\"background-color:red;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
							}
						echo "<td style=\"text-align:center;\">".$row["fecha_prevision"]."</td>";
						echo "<td>".$row["numero_cliente"]."</td>";
						if (strlen($row["nombre"]) > 30) {
							echo "<td>".substr($row["nombre"],0,30)." ...</td>";
						} else {
							echo "<td>".$row["nombre"]."</td>";
						}
						echo "<td><form method=\"post\" action=\"index.php?op=1014&sop=22&id=".$row["id"]."\"><input type=\"Submit\" value=\"Producción\" style=\"width:75px\"></form></td>";
						echo "<td><form method=\"post\" action=\"index.php?op=1014&sop=300&id=".$row["id"]."\"><input type=\"Submit\" value=\"Albaran\" style=\"width:75px\"></form></td>";
						echo "<td><form method=\"post\" action=\"index.php?op=1015&sop=95\">";
							$sqlw = "select count(*) as total from sgm_control_calidad where visible=1 and id_cabezera=".$row["id"];
							$resultw = mysql_query(convertSQL($sqlw));
							$roww = mysql_fetch_array($resultw);

							echo "<input type=\"Submit\" value=\"CC (".$roww["total"].")\" style=\"width:75px\">";
							echo "<input type=\"hidden\" name=\"id_cabezera\" value=\"".$row["id"]."\">";
							echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$row["id_cliente"]."\">";
							echo "<input type=\"hidden\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\">";
						echo "</form></td>";
					echo "</tr>";
				}
			}

		echo "</table>";
	}


	if ($soption == 11) {
		$sqlp = "select count(*) as total from sgm_cuerpo_orden_seguimiento where id_cuerpo=".$_GET["id"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);
		if ($rowp["total"] == 0) {
			$sql1 = "insert into sgm_cuerpo_orden_seguimiento (id_cuerpo) ";
			$sql1 = $sql1."values (";
			$sql1 = $sql1."".$_GET["id"];
			$sql1 = $sql1.")";
			mysql_query(convertSQL($sql1));
		}
		$sql = "select * from sgm_cuerpo_orden_seguimiento where id_cuerpo=".$_GET["id"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);


		echo "<form method=\"post\" action=\"includes/gestion-control_produccion_print_orden_seguimiento.php?id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
		echo "<input value=\"Imprimir Orden de Seguimiento\" type=\"Submit\" style=\"width:200px\">";
		echo "</form>";

		echo "<br>";

		echo "<form method=\"post\" action=\"index.php?op=1014&sop=12&id=".$_GET["id"]."\">";

		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td style=\"text-align:right;width:80px\"><strong>Visto Bueno : </strong></td><td><select name=\"finalizado\" style=\"width:50px\">";
					if ($row["finalizado"] == 1) {
						echo "<option value=\"1\" selected>SI</option>";
						echo "<option value=\"0\">NO</option>";
					}
					if ($row["finalizado"] == 0) {
						echo "<option value=\"1\">SI</option>";
						echo "<option value=\"0\" selected>NO</option>";
					}
				echo "</select></td>";
				echo "<td style=\"text-align:right;width:140px\">Validación autocontrol : </td><td><select name=\"val_autocontrol\" style=\"width:80px\">";
					if ($row["val_autocontrol"] == 1) {
						echo "<option value=\"1\" selected>Completo</option>";
						echo "<option value=\"0\">Incompleto</option>";
					}
					if ($row["val_autocontrol"] == 0) {
						echo "<option value=\"1\">Completo</option>";
						echo "<option value=\"0\" selected>Incompleto</option>";
					}
				echo "</select></td>";
				echo "<td style=\"text-align:right;width:120px\">Validación horas : </td><td><select name=\"val_horas\" style=\"width:80px\">";
					if ($row["val_horas"] == 1) {
						echo "<option value=\"1\" selected>Completo</option>";
						echo "<option value=\"0\">Incompleto</option>";
					}
					if ($row["val_horas"] == 0) {
						echo "<option value=\"1\">Completo</option>";
						echo "<option value=\"0\" selected>Incompleto</option>";
					}
				echo "</select></td>";
				echo "<td style=\"text-align:right;width:120px\">Validación cotas : </td><td><select name=\"val_cotas\" style=\"width:80px\">";
					if ($row["val_cotas"] == 1) {
						echo "<option value=\"1\" selected>Completo</option>";
						echo "<option value=\"0\">Incompleto</option>";
					}
					if ($row["val_cotas"] == 0) {
						echo "<option value=\"1\">Completo</option>";
						echo "<option value=\"0\" selected>Incompleto</option>";
					}
				echo "</select></td>";
			echo "</tr>";
		echo "</table>";

		echo "<br>";

		echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;\">Descripción&nbsp;</td>";
		echo "<td><textarea name=\"descripcion\" rows=\"5\" style=\"width:500px\">".$row["descripcion"]."</textarea></td></tr></table>";

		echo "<br>";

		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td>Fase</td>";
				echo "<td></td>";
				echo "<td>Autocontrol</td>";
				echo "<td></td>";
				echo "<td></td>";
#				echo "<td></td>";
#				echo "<td>Verificación</td>";
#				echo "<td></td>";
				echo "<td></td>";
				echo "<td>Horas</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		$totalhoras = 0;
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">Sierra&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"serra_autocontrol_1\" value=\"".$row["serra_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"serra_autocontrol_2\" value=\"".$row["serra_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"serra_autocontrol_3\" value=\"".$row["serra_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"serra_autocontrol_4\" value=\"".$row["serra_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"serra_verificacion_1\" value=\"".$row["serra_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"serra_horas_1\" value=\"".$row["serra_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"serra_horas_2\" value=\"".$row["serra_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"serra_horas_3\" value=\"".$row["serra_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"serra_horas_4\" value=\"".$row["serra_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["serra_horas_1"]+$row["serra_horas_2"]+$row["serra_horas_3"]+$row["serra_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["serra_horas_1"]+$row["serra_horas_2"]+$row["serra_horas_3"]+$row["serra_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">CNC&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cnc_autocontrol_1\" value=\"".$row["cnc_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cnc_autocontrol_2\" value=\"".$row["cnc_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cnc_autocontrol_3\" value=\"".$row["cnc_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cnc_autocontrol_4\" value=\"".$row["cnc_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"cnc_verificacion_1\" value=\"".$row["cnc_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cnc_horas_1\" value=\"".$row["cnc_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cnc_horas_2\" value=\"".$row["cnc_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cnc_horas_3\" value=\"".$row["cnc_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cnc_horas_4\" value=\"".$row["cnc_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["cnc_horas_1"]+$row["cnc_horas_2"]+$row["cnc_horas_3"]+$row["cnc_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["cnc_horas_1"]+$row["cnc_horas_2"]+$row["cnc_horas_3"]+$row["cnc_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">TNC&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"tnc_autocontrol_1\" value=\"".$row["tnc_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"tnc_autocontrol_2\" value=\"".$row["tnc_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"tnc_autocontrol_3\" value=\"".$row["tnc_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"tnc_autocontrol_4\" value=\"".$row["tnc_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"tnc_verificacion_1\" value=\"".$row["tnc_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"tnc_horas_1\" value=\"".$row["tnc_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"tnc_horas_2\" value=\"".$row["tnc_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"tnc_horas_3\" value=\"".$row["tnc_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"tnc_horas_4\" value=\"".$row["tnc_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["tnc_horas_1"]+$row["tnc_horas_2"]+$row["tnc_horas_3"]+$row["tnc_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["tnc_horas_1"]+$row["tnc_horas_2"]+$row["tnc_horas_3"]+$row["tnc_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">Torno&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"torn_autocontrol_1\" value=\"".$row["torn_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"torn_autocontrol_2\" value=\"".$row["torn_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"torn_autocontrol_3\" value=\"".$row["torn_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"torn_autocontrol_4\" value=\"".$row["torn_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"torn_verificacion_1\" value=\"".$row["torn_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"torn_horas_1\" value=\"".$row["torn_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"torn_horas_2\" value=\"".$row["torn_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"torn_horas_3\" value=\"".$row["torn_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"torn_horas_4\" value=\"".$row["torn_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["torn_horas_1"]+$row["torn_horas_2"]+$row["torn_horas_3"]+$row["torn_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["torn_horas_1"]+$row["torn_horas_2"]+$row["torn_horas_3"]+$row["torn_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">Fresa&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"fresa_autocontrol_1\" value=\"".$row["fresa_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"fresa_autocontrol_2\" value=\"".$row["fresa_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"fresa_autocontrol_3\" value=\"".$row["fresa_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"fresa_autocontrol_4\" value=\"".$row["fresa_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"fresa_verificacion_1\" value=\"".$row["fresa_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"fresa_horas_1\" value=\"".$row["fresa_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"fresa_horas_2\" value=\"".$row["fresa_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"fresa_horas_3\" value=\"".$row["fresa_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"fresa_horas_4\" value=\"".$row["fresa_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["fresa_horas_1"]+$row["fresa_horas_2"]+$row["fresa_horas_3"]+$row["fresa_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["fresa_horas_1"]+$row["fresa_horas_2"]+$row["fresa_horas_3"]+$row["fresa_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">Ajuste&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"ajust_autocontrol_1\" value=\"".$row["ajust_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"ajust_autocontrol_2\" value=\"".$row["ajust_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"ajust_autocontrol_3\" value=\"".$row["ajust_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"ajust_autocontrol_4\" value=\"".$row["ajust_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"ajust_verificacion_1\" value=\"".$row["ajust_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"ajust_horas_1\" value=\"".$row["ajust_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"ajust_horas_2\" value=\"".$row["ajust_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"ajust_horas_3\" value=\"".$row["ajust_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"ajust_horas_4\" value=\"".$row["ajust_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["ajust_horas_1"]+$row["ajust_horas_2"]+$row["ajust_horas_3"]+$row["ajust_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["ajust_horas_1"]+$row["ajust_horas_2"]+$row["ajust_horas_3"]+$row["ajust_horas_4"]);
			echo "</tr>";
#			echo "<tr>";
#				echo "<td style=\"width:75px;text-align:right;\">Soldadura&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_1\" value=\"".$row["soldadura_autocontrol_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_2\" value=\"".$row["soldadura_autocontrol_2"]."\" style=\"width:60px;\"></td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_3\" value=\"".$row["soldadura_autocontrol_3"]."\" style=\"width:60px;\"></td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_4\" value=\"".$row["soldadura_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_verificacion_1\" value=\"".$row["soldadura_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_horas_1\" value=\"".$row["soldadura_horas_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_horas_2\" value=\"".$row["soldadura_horas_2"]."\" style=\"width:60px;\"></td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_horas_3\" value=\"".$row["soldadura_horas_3"]."\" style=\"width:60px;\"></td>";
#				echo "<td><input type=\"Text\" name=\"soldadura_horas_4\" value=\"".$row["soldadura_horas_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["soldadura_horas_1"]+$row["soldadura_horas_2"]+$row["soldadura_horas_3"]+$row["soldadura_horas_4"])."</strong></td>";
#				$totalhoras = $totalhoras+($row["soldadura_horas_1"]+$row["soldadura_horas_2"]+$row["soldadura_horas_3"]+$row["soldadura_horas_4"]);
#			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">Rectificado&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_1\" value=\"".$row["rectificat_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_2\" value=\"".$row["rectificat_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_3\" value=\"".$row["rectificat_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_4\" value=\"".$row["rectificat_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"rectificat_verificacion_1\" value=\"".$row["rectificat_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"rectificat_horas_1\" value=\"".$row["rectificat_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"rectificat_horas_2\" value=\"".$row["rectificat_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"rectificat_horas_3\" value=\"".$row["rectificat_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"rectificat_horas_4\" value=\"".$row["rectificat_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["rectificat_horas_1"]+$row["rectificat_horas_2"]+$row["rectificat_horas_3"]+$row["rectificat_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["rectificat_horas_1"]+$row["rectificat_horas_2"]+$row["rectificat_horas_3"]+$row["rectificat_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:75px;text-align:right;\">Programacion&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"programacion_autocontrol_1\" value=\"".$row["programacion_autocontrol_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"programacion_autocontrol_2\" value=\"".$row["programacion_autocontrol_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"programacion_autocontrol_3\" value=\"".$row["programacion_autocontrol_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"programacion_autocontrol_4\" value=\"".$row["programacion_autocontrol_4"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
#				echo "<td><input type=\"Text\" name=\"programacion_verificacion_1\" value=\"".$row["programacion_verificacion_1"]."\" style=\"width:60px;\"></td>";
#				echo "<td>&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"programacion_horas_1\" value=\"".$row["programacion_horas_1"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"programacion_horas_2\" value=\"".$row["programacion_horas_2"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"programacion_horas_3\" value=\"".$row["programacion_horas_3"]."\" style=\"width:60px;\"></td>";
				echo "<td><input type=\"Text\" name=\"programacion_horas_4\" value=\"".$row["programacion_horas_4"]."\" style=\"width:60px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".($row["programacion_horas_1"]+$row["programacion_horas_2"]+$row["programacion_horas_3"]+$row["programacion_horas_4"])."</strong></td>";
				$totalhoras = $totalhoras+($row["programacion_horas_1"]+$row["programacion_horas_2"]+$row["programacion_horas_3"]+$row["programacion_horas_4"]);
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
#				echo "<td></td>";
#				echo "<td></td>";
#				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"width:60px;text-align:right\">Total</td>";
				echo "<td style=\"width:60px;text-align:right\"><strong>".$totalhoras."</strong></td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><center><input type=\"Submit\" value=\"Actualizar Orden de Seguimiento\" style=\"width:500px\"></center><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><center>Teórica</center></td>";
				echo "<td><center>Real</center></td>";
				echo "<td></td>";
				echo "<td><center>Teórica</center></td>";
				echo "<td><center>Real</center></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_1_a\" value=\"".$row["cota_1_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_1_b\" value=\"".$row["cota_1_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_2_a\" value=\"".$row["cota_2_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_2_b\" value=\"".$row["cota_2_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_3_a\" value=\"".$row["cota_3_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_3_b\" value=\"".$row["cota_3_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_4_a\" value=\"".$row["cota_4_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_4_b\" value=\"".$row["cota_4_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_5_a\" value=\"".$row["cota_5_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_5_b\" value=\"".$row["cota_5_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_6_a\" value=\"".$row["cota_6_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_6_b\" value=\"".$row["cota_6_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_7_a\" value=\"".$row["cota_7_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_7_b\" value=\"".$row["cota_7_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_8_a\" value=\"".$row["cota_8_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_8_b\" value=\"".$row["cota_8_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_9_a\" value=\"".$row["cota_9_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_9_b\" value=\"".$row["cota_9_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_10_a\" value=\"".$row["cota_10_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_10_b\" value=\"".$row["cota_10_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_11_a\" value=\"".$row["cota_11_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_11_b\" value=\"".$row["cota_11_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_12_a\" value=\"".$row["cota_12_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_12_b\" value=\"".$row["cota_12_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_13_a\" value=\"".$row["cota_13_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_13_b\" value=\"".$row["cota_13_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_14_a\" value=\"".$row["cota_14_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_14_b\" value=\"".$row["cota_14_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_15_a\" value=\"".$row["cota_15_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_15_b\" value=\"".$row["cota_15_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_16_a\" value=\"".$row["cota_16_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_16_b\" value=\"".$row["cota_16_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_17_a\" value=\"".$row["cota_17_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_17_b\" value=\"".$row["cota_17_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_18_a\" value=\"".$row["cota_18_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_18_b\" value=\"".$row["cota_18_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_19_a\" value=\"".$row["cota_19_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_19_b\" value=\"".$row["cota_19_b"]."\" style=\"width:125px;\"></td>";
				echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
				echo "<td><input type=\"Text\" name=\"cota_20_a\" value=\"".$row["cota_20_a"]."\" style=\"width:125px;\"></td>";
				echo "<td><input type=\"Text\" name=\"cota_20_b\" value=\"".$row["cota_20_b"]."\" style=\"width:125px;\"></td>";
			echo "</tr>";


		echo "</table>";
		echo "<br><center><input type=\"Submit\" value=\"Actualizar Orden de Seguimiento\" style=\"width:500px\"></center><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;\">Aplicaciones&nbsp;<br>exteriores&nbsp;</td>";
		echo "<td><textarea name=\"aplicaciones_exteriores\" rows=\"5\" style=\"width:500px\">".$row["aplicaciones_exteriores"]."</textarea></td></tr></table>";
		echo "<br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;\">Observaciones&nbsp;</td>";
		echo "<td><textarea name=\"observaciones\" rows=\"5\" style=\"width:500px\">".$row["observaciones"]."</textarea></td></tr></table>";
		echo "<br><center><input type=\"Submit\" value=\"Actualizar Orden de Seguimiento\" style=\"width:500px\"></center><br>";
		echo "</form>";

	}

	if ($soption == 12) {
		$sql = "update sgm_cuerpo_orden_seguimiento set ";
		$sql = $sql."serra_autocontrol_1='".$_POST["serra_autocontrol_1"]."'";
		$sql = $sql.",serra_autocontrol_2='".$_POST["serra_autocontrol_2"]."'";
		$sql = $sql.",serra_autocontrol_3='".$_POST["serra_autocontrol_3"]."'";
		$sql = $sql.",serra_autocontrol_4='".$_POST["serra_autocontrol_4"]."'";
		$sql = $sql.",serra_verificacion_1='".$_POST["serra_verificacion_1"]."'";
		$sql = $sql.",serra_horas_1='".$_POST["serra_horas_1"]."'";
		$sql = $sql.",serra_horas_2='".$_POST["serra_horas_2"]."'";
		$sql = $sql.",serra_horas_3='".$_POST["serra_horas_3"]."'";
		$sql = $sql.",serra_horas_4='".$_POST["serra_horas_4"]."'";

		$sql = $sql.",cnc_autocontrol_1='".$_POST["cnc_autocontrol_1"]."'";
		$sql = $sql.",cnc_autocontrol_2='".$_POST["cnc_autocontrol_2"]."'";
		$sql = $sql.",cnc_autocontrol_3='".$_POST["cnc_autocontrol_3"]."'";
		$sql = $sql.",cnc_autocontrol_4='".$_POST["cnc_autocontrol_4"]."'";
		$sql = $sql.",cnc_verificacion_1='".$_POST["cnc_verificacion_1"]."'";
		$sql = $sql.",cnc_horas_1='".$_POST["cnc_horas_1"]."'";
		$sql = $sql.",cnc_horas_2='".$_POST["cnc_horas_2"]."'";
		$sql = $sql.",cnc_horas_3='".$_POST["cnc_horas_3"]."'";
		$sql = $sql.",cnc_horas_4='".$_POST["cnc_horas_4"]."'";

		$sql = $sql.",tnc_autocontrol_1='".$_POST["tnc_autocontrol_1"]."'";
		$sql = $sql.",tnc_autocontrol_2='".$_POST["tnc_autocontrol_2"]."'";
		$sql = $sql.",tnc_autocontrol_3='".$_POST["tnc_autocontrol_3"]."'";
		$sql = $sql.",tnc_autocontrol_4='".$_POST["tnc_autocontrol_4"]."'";
		$sql = $sql.",tnc_verificacion_1='".$_POST["tnc_verificacion_1"]."'";
		$sql = $sql.",tnc_horas_1='".$_POST["tnc_horas_1"]."'";
		$sql = $sql.",tnc_horas_2='".$_POST["tnc_horas_2"]."'";
		$sql = $sql.",tnc_horas_3='".$_POST["tnc_horas_3"]."'";
		$sql = $sql.",tnc_horas_4='".$_POST["tnc_horas_4"]."'";


		$sql = $sql.",torn_autocontrol_1='".$_POST["torn_autocontrol_1"]."'";
		$sql = $sql.",torn_autocontrol_2='".$_POST["torn_autocontrol_2"]."'";
		$sql = $sql.",torn_autocontrol_3='".$_POST["torn_autocontrol_3"]."'";
		$sql = $sql.",torn_autocontrol_4='".$_POST["torn_autocontrol_4"]."'";
		$sql = $sql.",torn_verificacion_1='".$_POST["torn_verificacion_1"]."'";
		$sql = $sql.",torn_horas_1='".$_POST["torn_horas_1"]."'";
		$sql = $sql.",torn_horas_2='".$_POST["torn_horas_2"]."'";
		$sql = $sql.",torn_horas_3='".$_POST["torn_horas_3"]."'";
		$sql = $sql.",torn_horas_4='".$_POST["torn_horas_4"]."'";

		$sql = $sql.",fresa_autocontrol_1='".$_POST["fresa_autocontrol_1"]."'";
		$sql = $sql.",fresa_autocontrol_2='".$_POST["fresa_autocontrol_2"]."'";
		$sql = $sql.",fresa_autocontrol_3='".$_POST["fresa_autocontrol_3"]."'";
		$sql = $sql.",fresa_autocontrol_4='".$_POST["fresa_autocontrol_4"]."'";
		$sql = $sql.",fresa_verificacion_1='".$_POST["fresa_verificacion_1"]."'";
		$sql = $sql.",fresa_horas_1='".$_POST["fresa_horas_1"]."'";
		$sql = $sql.",fresa_horas_2='".$_POST["fresa_horas_2"]."'";
		$sql = $sql.",fresa_horas_3='".$_POST["fresa_horas_3"]."'";
		$sql = $sql.",fresa_horas_4='".$_POST["fresa_horas_4"]."'";


		$sql = $sql.",ajust_autocontrol_1='".$_POST["ajust_autocontrol_1"]."'";
		$sql = $sql.",ajust_autocontrol_2='".$_POST["ajust_autocontrol_2"]."'";
		$sql = $sql.",ajust_autocontrol_3='".$_POST["ajust_autocontrol_3"]."'";
		$sql = $sql.",ajust_autocontrol_4='".$_POST["ajust_autocontrol_4"]."'";
		$sql = $sql.",ajust_verificacion_1='".$_POST["ajust_verificacion_1"]."'";
		$sql = $sql.",ajust_horas_1='".$_POST["ajust_horas_1"]."'";
		$sql = $sql.",ajust_horas_2='".$_POST["ajust_horas_2"]."'";
		$sql = $sql.",ajust_horas_3='".$_POST["ajust_horas_3"]."'";
		$sql = $sql.",ajust_horas_4='".$_POST["ajust_horas_4"]."'";

#		$sql = $sql.",soldadura_autocontrol_1='".$_POST["soldadura_autocontrol_1"]."'";
#		$sql = $sql.",soldadura_autocontrol_2='".$_POST["soldadura_autocontrol_2"]."'";
#		$sql = $sql.",soldadura_autocontrol_3='".$_POST["soldadura_autocontrol_3"]."'";
#		$sql = $sql.",soldadura_autocontrol_4='".$_POST["soldadura_autocontrol_4"]."'";
#		$sql = $sql.",soldadura_verificacion_1='".$_POST["soldadura_verificacion_1"]."'";
#		$sql = $sql.",soldadura_horas_1='".$_POST["soldadura_horas_1"]."'";
#		$sql = $sql.",soldadura_horas_2='".$_POST["soldadura_horas_2"]."'";
#		$sql = $sql.",soldadura_horas_3='".$_POST["soldadura_horas_3"]."'";
#		$sql = $sql.",soldadura_horas_4='".$_POST["soldadura_horas_4"]."'";


		$sql = $sql.",rectificat_autocontrol_1='".$_POST["rectificat_autocontrol_1"]."'";
		$sql = $sql.",rectificat_autocontrol_2='".$_POST["rectificat_autocontrol_2"]."'";
		$sql = $sql.",rectificat_autocontrol_3='".$_POST["rectificat_autocontrol_3"]."'";
		$sql = $sql.",rectificat_autocontrol_4='".$_POST["rectificat_autocontrol_4"]."'";
		$sql = $sql.",rectificat_verificacion_1='".$_POST["rectificat_verificacion_1"]."'";
		$sql = $sql.",rectificat_horas_1='".$_POST["rectificat_horas_1"]."'";
		$sql = $sql.",rectificat_horas_2='".$_POST["rectificat_horas_2"]."'";
		$sql = $sql.",rectificat_horas_3='".$_POST["rectificat_horas_3"]."'";
		$sql = $sql.",rectificat_horas_4='".$_POST["rectificat_horas_4"]."'";

		$sql = $sql.",programacion_autocontrol_1='".$_POST["programacion_autocontrol_1"]."'";
		$sql = $sql.",programacion_autocontrol_2='".$_POST["programacion_autocontrol_2"]."'";
		$sql = $sql.",programacion_autocontrol_3='".$_POST["programacion_autocontrol_3"]."'";
		$sql = $sql.",programacion_autocontrol_4='".$_POST["programacion_autocontrol_4"]."'";
		$sql = $sql.",programacion_verificacion_1='".$_POST["programacion_verificacion_1"]."'";
		$sql = $sql.",programacion_horas_1='".$_POST["programacion_horas_1"]."'";
		$sql = $sql.",programacion_horas_2='".$_POST["programacion_horas_2"]."'";
		$sql = $sql.",programacion_horas_3='".$_POST["programacion_horas_3"]."'";
		$sql = $sql.",programacion_horas_4='".$_POST["programacion_horas_4"]."'";

		$sql = $sql.",cota_1_a='".$_POST["cota_1_a"]."'";
		$sql = $sql.",cota_1_b='".$_POST["cota_1_b"]."'";
		$sql = $sql.",cota_2_a='".$_POST["cota_2_a"]."'";
		$sql = $sql.",cota_2_b='".$_POST["cota_2_b"]."'";
		$sql = $sql.",cota_3_a='".$_POST["cota_3_a"]."'";
		$sql = $sql.",cota_3_b='".$_POST["cota_3_b"]."'";
		$sql = $sql.",cota_4_a='".$_POST["cota_4_a"]."'";
		$sql = $sql.",cota_4_b='".$_POST["cota_4_b"]."'";
		$sql = $sql.",cota_5_a='".$_POST["cota_5_a"]."'";
		$sql = $sql.",cota_5_b='".$_POST["cota_5_b"]."'";
		$sql = $sql.",cota_6_a='".$_POST["cota_6_a"]."'";
		$sql = $sql.",cota_6_b='".$_POST["cota_6_b"]."'";
		$sql = $sql.",cota_7_a='".$_POST["cota_7_a"]."'";
		$sql = $sql.",cota_7_b='".$_POST["cota_7_b"]."'";
		$sql = $sql.",cota_8_a='".$_POST["cota_8_a"]."'";
		$sql = $sql.",cota_8_b='".$_POST["cota_8_b"]."'";
		$sql = $sql.",cota_9_a='".$_POST["cota_9_a"]."'";
		$sql = $sql.",cota_9_b='".$_POST["cota_9_b"]."'";
		$sql = $sql.",cota_10_a='".$_POST["cota_10_a"]."'";
		$sql = $sql.",cota_10_b='".$_POST["cota_10_b"]."'";

		$sql = $sql.",cota_11_a='".$_POST["cota_11_a"]."'";
		$sql = $sql.",cota_11_b='".$_POST["cota_11_b"]."'";
		$sql = $sql.",cota_12_a='".$_POST["cota_12_a"]."'";
		$sql = $sql.",cota_12_b='".$_POST["cota_12_b"]."'";
		$sql = $sql.",cota_13_a='".$_POST["cota_13_a"]."'";
		$sql = $sql.",cota_13_b='".$_POST["cota_13_b"]."'";
		$sql = $sql.",cota_14_a='".$_POST["cota_14_a"]."'";
		$sql = $sql.",cota_14_b='".$_POST["cota_14_b"]."'";
		$sql = $sql.",cota_15_a='".$_POST["cota_15_a"]."'";
		$sql = $sql.",cota_15_b='".$_POST["cota_15_b"]."'";
		$sql = $sql.",cota_16_a='".$_POST["cota_16_a"]."'";
		$sql = $sql.",cota_16_b='".$_POST["cota_16_b"]."'";
		$sql = $sql.",cota_17_a='".$_POST["cota_17_a"]."'";
		$sql = $sql.",cota_17_b='".$_POST["cota_17_b"]."'";
		$sql = $sql.",cota_18_a='".$_POST["cota_18_a"]."'";
		$sql = $sql.",cota_18_b='".$_POST["cota_18_b"]."'";
		$sql = $sql.",cota_19_a='".$_POST["cota_19_a"]."'";
		$sql = $sql.",cota_19_b='".$_POST["cota_19_b"]."'";
		$sql = $sql.",cota_20_a='".$_POST["cota_20_a"]."'";
		$sql = $sql.",cota_20_b='".$_POST["cota_20_b"]."'";

		$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
		$sql = $sql.",aplicaciones_exteriores='".$_POST["aplicaciones_exteriores"]."'";
		$sql = $sql.",observaciones='".$_POST["observaciones"]."'";

		if ($_POST["finalizado"] == 0) {
			$sql = $sql.",finalizado=".$_POST["finalizado"]."";
			$sql = $sql.",val_autocontrol=".$_POST["val_autocontrol"]."";
			$sql = $sql.",val_horas=".$_POST["val_horas"]."";
			$sql = $sql.",val_cotas=".$_POST["val_cotas"]."";
		}

		if ($_POST["finalizado"] == 1) {
			$sql = $sql.",finalizado=1";
			$sql = $sql.",val_autocontrol=1";
			$sql = $sql.",val_horas=1";
			$sql = $sql.",val_cotas=1";
		}

		$sql = $sql." WHERE id_cuerpo=".$_GET["id"]."";
		mysql_query(convertSQL($sql));


		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=11&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 22) {
		$sql = "select * from sgm_cabezera where id=".$_GET["id"]." ORDER BY id";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		echo "<table><tr><td style=\"width:300px;vertical-align:top;\">";
				echo "<table>";
				echo "<tr><td><strong>Número</strong></td><td>".$row["numero"]."</td></tr>";
				echo "<tr><td>Ref. Cliente</td><td>".$row["numero_cliente"]."</td></tr>";
				echo "<tr><td><strong>Fecha</strong></td><td>".$row["fecha"]."</td></tr>";
				echo "<tr><td><strong>Fecha Previsión</strong></td><td>".$row["fecha_prevision"]."</td></tr>";
				echo "<tr><td>Nombre</td><td><a href=\"index.php?op=1011&sop=0&id=".$row["id_cliente"]."&origen=1003\">".$row["nombre"]."</a></td></tr>";
				echo "<tr><td>E-mail</td><td>".$row["mail"]."</td></tr>";
				echo "<tr><td>Telefono</td><td>".$row["telefono"]."</td></tr>";
				echo "</table>";
		echo "</td><td style=\"width:300px;vertical-align:top;\">";
				echo "<a href=\"index.php?op=1014&sop=70&id=".$_GET["id"]."\">&raquo; Listado materiales</a>";
				echo "<br><br>";
				echo "<form method=\"post\" action=\"includes/gestion-control_produccion_print_lista_materiales.php?id=".$_GET["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
				echo "<input value=\"Imprimir Lista de Materiales\" type=\"Submit\" style=\"width:200px\">";
				echo "</form>";

				echo "<form method=\"post\" action=\"includes/gestion-control_produccion_print_orden_seguimiento_todas.php?id=".$_GET["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
				echo "<input value=\"Imprimir todas las OT\" type=\"Submit\" style=\"width:200px\">";
				echo "</form>";

		echo "</td></tr></table>";

		echo "<br><br>";
		echo "<table cellspacing=\"0\">";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
		$result = mysql_query(convertSQL($sql));
		$x = 1;
		echo "<form method=\"post\" action=\"index.php?op=1014&sop=103&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
		echo "<tr><td></td><td><input type=\"Submit\" value=\"Cambiar Estado\" style=\"width:125px\"></td><td><em>Fecha Prevision</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td></td><td></td><td><center>M</center></td><td><center>A</center></td></tr>";
		while ($row = mysql_fetch_array($result)) {
			$color = "white";
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
				if ($fecha_entrega < $hoy) { $color = "red"; }
					else { if ($fecha_aviso < $hoy) { $color = "orange"; }
				}
			}
			echo "<tr>";
				echo "<td>".$row["linea"]."</td>";
				echo "<td>";
					$sqles = "select * from sgm_cuerpo_estados where id=".$row["id_estado"];
					$resultes = mysql_query(convertSQL($sqles));
					$rowes = mysql_fetch_array($resultes);
					if ($row["id_estado"] == -1) { $color2 = "blue"; } else { $color2 = $rowes["color"]; }

					echo "<select style=\"background-color : ".$color2.";width:125px\" name=\"id_estado".$x."\">";
						if ($row["id_estado"] == 0) { echo "<option value=\"0\" selected>Sin Iniciar</option>"; }
						else { echo "<option value=\"0\">Sin Iniciar</option>"; }
						if ($row["id_estado"] == -1) { echo "<option value=\"-1\" selected>Finalizado</option>"; }
						else { echo "<option value=\"-1\">Finalizado</option>"; }
						$sqles = "select * from sgm_cuerpo_estados order by estado";
						$resultes = mysql_query(convertSQL($sqles));
						while ($rowes = mysql_fetch_array($resultes)) {
							if ($rowes["id"] == $row["id_estado"]) { echo "<option value=\"".$rowes["id"]."\" selected>".$rowes["estado"]."</option>"; }
							else { echo "<option value=\"".$rowes["id"]."\">".$rowes["estado"]."</option>"; }
						}
						
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"background-color : ".$color.";width:75px\" value=\"".$row["fecha_prevision"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"unidades\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td><a href=\"index.php?op=1014&sop=1&id=".$row["id"]."\"><strong>[Producción]</strong></a></td>";
				echo "<td><a href=\"index.php?op=1014&sop=11&id=".$row["id"]."\"><strong>[OT]</strong></a></td>";
					$sqlxx = "select count(*) as total from sgm_cuerpo where id_cuerpo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
				echo "<td><a href=\"index.php?op=1014&sop=60&id=".$row["id"]."\"><strong>[".$rowxx["total"]."]</strong></a></td>";
					$sqlxx = "select count(*) as total from sgm_cuerpo_archivos where id_cuerpo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
				echo "<td><a href=\"index.php?op=1014&sop=50&id=".$row["id"]."\"><strong>[".$rowxx["total"]."]</strong></a></td>";
		echo "</tr>";
		$x++;
		}
		echo "<tr><td></td><td><input type=\"Submit\" value=\"Cambiar Estado\" style=\"width:125px\"></td><td><em>Fecha Prevision</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td></td><td></td><td><center>M</center></td><td><center>A</center></td></tr>";
		echo "</form>";
		echo "</table>";
		echo "<br>";
		echo "<br>M - <em>Lineas de <strong>M</strong>aterial</em>";
		echo "<br>A - <em>Lineas de <strong>A</strong>rchivos</em>";

	}


	if (($soption >= 30) and ($soption <= 40)) {
		echo "<table style=\"width:100%\"><tr><td style=\"vertical-align:top;width:50%\">";
		echo "<strong>Listados de estados internos :</strong><br>";
			echo "<br><a href=\"index.php?op=1014&sop=31&id=0\">&raquo; Estado : Sin Iniciar</a>";
			$sql = "select * from sgm_cuerpo_estados where externo=0 order by estado";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<br><a href=\"index.php?op=1014&sop=31&id=".$row["id"]."\">&raquo; Estado : ".$row["estado"]."</a>";
			}
		echo "</td><td style=\"vertical-align:top;width:50%\">";
		echo "<strong>Listados de estados externos :</strong><br>";
			$sql = "select * from sgm_cuerpo_estados where externo=1 order by estado";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<br><a href=\"index.php?op=1014&sop=31&id=".$row["id"]."\">&raquo; Estado : ".$row["estado"]."</a>";
			}
		echo "</td></tr></table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 31) {
		echo "<table cellspacing=\"0\">";
		echo "<tr><td><em>Estado</em></td><td></td><td><em>Fecha Prevision</em></td><td><em>Nº Pedido</em></td><td><em>Nº Pedido Cli.</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td></td><td></td><td></td></tr>";


		$sqlestado = "select * from sgm_cuerpo_estados where id=".$_GET["id"];
		$resultestado = mysql_query(convertSQL($sqlestado));
		$rowestado = mysql_fetch_array($resultestado);
		echo "<strong style=\"font-size:12px\">ESTADO DE PRODUCCIÓN : ".$rowestado["estado"]."</strong><br><br>";


		$sql = "select * from sgm_cuerpo where id_estado=".$_GET["id"]." and id_cuerpo=0 order by prioridad desc,fecha_prevision";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
		
		$ver = 0;
		$sqlff = "select * from sgm_cabezera where id=".$row["idfactura"];
		$resultff = mysql_query(convertSQL($sqlff));
		$rowff = mysql_fetch_array($resultff);
		if (($rowff["cerrada"] == 0) and ($rowff["tipo"] == 3)) { $ver = 1; }

		if ($ver == 1) {
			$color = "white";
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
				if ($fecha_entrega < $hoy) { $color = "red"; }
					else { if ($fecha_aviso < $hoy) { $color = "orange"; }
				}
			}
			echo "<tr>";

				echo "<form method=\"post\" action=\"index.php?op=1014&sop=33&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
					echo "<td><input type=\"Text\" style=\"width:50px\" name=\"prioridad\" value=\"".$row["prioridad"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"Ok\"></td>";
				echo "</form>";
			
				echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"background-color : ".$color.";width:75px\" value=\"".$row["fecha_prevision"]."\"></td>";
					$sqlc = "select * from sgm_cabezera where id=".$row["idfactura"];
					$resultc = mysql_query(convertSQL($sqlc));
					$rowc = mysql_fetch_array($resultc);
				echo "<td><input type=\"Text\" style=\"width:50px\" value=\"".$rowc["numero"]."\" disabled></td>";
				echo "<td><input type=\"Text\" style=\"width:75px\" value=\"".$row["codigo"]."\" disabled></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" value=\"".$row["nombre"]."\" disabled></td>";
				echo "<td><input type=\"Text\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\" disabled></td>";

				if ($rowestado["externo"] == 1) {

					if ($row["bloqueado"] == 0) {
						echo "<form method=\"post\" action=\"index.php?op=1014&sop=32&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
							echo "<td><select name=\"idfactura\" style=\"width:100px\">";
								echo "<option value=\"0\">Pendiente</option>";
								$sqlf = "select * from sgm_cabezera where tipo=4 and cerrada=0 and visible=1";
								$resultf = mysql_query(convertSQL($sqlf));
								while ($rowf = mysql_fetch_array($resultf)) {
									echo "<option value=\"".$rowf["id"]."\">".$rowf["numero"]."-".$rowf["nombre"]."</option>";
								}
							echo "</select></td>";
							echo "<td><input value=\"Añadir\" type=\"Submit\" style=\"width:50px\"></td>";
						echo "</form>";
					}
					if ($row["bloqueado"] == 1) {
						################ DESBLOQUEO MANUAL
						echo "<form method=\"post\" action=\"index.php?op=1014&sop=34&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
							echo "<td><input value=\"Desbloqueo\" type=\"Submit\" style=\"width:100px\"></td>";
						echo "</form>";
					}

				}

				if ($row["bloqueado"] == 1) { echo "<td><a href=\"index.php?op=1003&sop=22&id=".$rowc["id"]."\">[ ".$rowc["numero"]." ]</a></td>"; }
				echo "<td><a href=\"index.php?op=1014&sop=1&id=".$row["id"]."\">[ Ver ]</a></td>";
		echo "</tr>";
		}
		}
		echo "</table>";
		echo "<br><br>";

	}


	if ($soption == 32) {
		traspasar_cuerpo($_GET["id_cuerpo"],$_POST["idfactura"]);

		$sql = "update sgm_cuerpo set ";
		$sql = $sql."bloqueado=1";
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=31&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 33) {
		$sql = "update sgm_cuerpo set ";
		$sql = $sql."prioridad=".$_POST["prioridad"];
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"];
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=31&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 34) {
		echo "<br><br>¿Seguro que desea desbloquear este proceso?";
		echo "<br><br><a href=\"index.php?op=1014&sop=35&id=".$_GET["id"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">[ SI ]</a><a href=\"index.php?op=1014&sop=31&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if ($soption == 35) {
		$sql = "update sgm_cuerpo set ";
		$sql = $sql."bloqueado=0";
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"];
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=31&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 50) {
		echo "<br><br>";
			echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:400px;vertical-align:top;\">";
						echo "<strong>Listado de archivos :</strong><br><br>";
						$sql = "select * from sgm_cuerpo_archivos_tipos order by nombre";
						$result = mysql_query(convertSQL($sql));
						echo "<table>";
						while ($row = mysql_fetch_array($result)) {
							$sqlele = "select * from sgm_cuerpo_archivos where id_tipo=".$row["id"]." and id_cuerpo=".$_GET["id"];
							$resultele = mysql_query(convertSQL($sqlele));
							while ($rowele = mysql_fetch_array($resultele)) {
								echo "<tr><td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/archivos/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td>&nbsp;<a href=\"index.php?op=1014&sop=52&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\">[ Eliminar ]</a></td></tr>";
							}
						}
						echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>Formulario de envio de archivos :</strong><br><br>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1014&sop=51\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"Hidden\" name=\"id_cuerpo\" value=\"".$_GET["id"]."\">";
					echo "<select name=\"id_tipo\" style=\"width:200px\">";
						$sql = "select * from sgm_cuerpo_archivos_tipos order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"file\" name=\"archivo\">";
					echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta ARCHIVOS/\" style=\"width:200px\">";
					echo "</form>";
					echo "</center>";
			echo "</td></tr></table>";
	}

	if ($soption == 51) {
		if (version_compare(phpversion(), "4.0.0", ">")) {
			$archivo_name = $_FILES['archivo']['name'];
			$archivo_size = $_FILES['archivo']['size'];
			$archivo_type =  $_FILES['archivo']['type'];
			$archivo = $_FILES['archivo']['tmp_name'];
			$tipo = $_POST["id_tipo"];
			$id_cuerpo = $_POST["id_cuerpo"];
		}
		if (version_compare(phpversion(), "4.0.1", "<")) {
			$archivo_name = $HTTP_POST_FILES['archivo']['name'];
			$archivo_size = $HTTP_POST_FILES['archivo']['size'];
			$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
			$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
			$tipo = $HTTP_POST_VARS["id_tipo"];
			$id_cuerpo = $HTTP_POST_VARS["id_cuerpo"];
		}
		$sql = "select * from sgm_cuerpo_archivos_tipos where id=".$tipo;
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$lim_tamano = $row["limite_kb"]*1000;
		$sqlt = "select count(*) as total from sgm_cuerpo_archivos where name='".$archivo_name."'";
		$resultt = mysql_query(convertSQL($sqlt));
		$rowt = mysql_fetch_array($resultt);
		if ($rowt["total"] != 0) {
			echo "No se puede añadir archivo por que ya existe uno con el mismo nombre.";
		}
		else {
			if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
			    if (copy ($archivo, "archivos/".$archivo_name)) {
					echo "<center>";
					echo "<h2>Se ha transferido el archivo $archivo_name</h2>";
					echo "<br>Su tamaño es: $archivo_size bytes<br><br>";
					echo "Operación realizada correctamente.";
					echo "<br><br><a href=\"index.php?op=1014&sop=50&id=".$id_cuerpo."\">[ Volver ]</a>";
					echo "</center>";
					$sql = "insert into sgm_cuerpo_archivos (id_tipo,name,type,size,id_cuerpo) ";
					$sql = $sql."values (";
					$sql = $sql."".$tipo."";
					$sql = $sql.",'".$archivo_name."'";
					$sql = $sql.",'".$archivo_type."'";
					$sql = $sql.",".$archivo_size."";
					$sql = $sql.",".$id_cuerpo."";
					$sql = $sql.")";
					mysql_query(convertSQL($sql));
	              }
				}else{
				    echo "<h2>No ha podido transferirse el archivo.</h2>";
		    		echo "<h3>Su tamaño no puede exceder de ".$lim_tamano." bytes.</h2>";
			}
		}
	}

	if ($soption == 52) {
		echo "<center>";
		echo "¿Seguro que desea eliminar este archivo?";
		echo "<br><br><a href=\"index.php?op=1014&sop=53&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."\">[ SI ]</a><a href=\"index.php?op=1014&sop=50&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 53) {
		$sql = "delete from sgm_cuerpo_archivos WHERE id=".$_GET["id_archivo"];
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=50&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 60) {
		echo "<table>";
			echo "<tr><td></td><td style=\"text-align:center;\"><em>Código</em></td><td style=\"text-align:center;\"><em>Nombre</em></td><td style=\"text-align:center;\"><em>Unidades</em></td>";
#			echo "<td style=\"text-align:center;\"><em>PVD</em></td>";
			echo "<td style=\"text-align:center;\"><em>PVP</em></td><td style=\"text-align:center;\"><em>Total</em></td><td></td>";
			echo "</tr>";
			echo "<tr>";
				$sqlp = "select * from sgm_cuerpo where id=".$_GET["id"];
				$resultp = mysql_query(convertSQL($sqlp));
				$rowp = mysql_fetch_array($resultp);
				echo "<td><a href=\"#\" onclick=\"formulario.codigo.value='".$rowp["codigo"]."'\">[CC]</a></td>";
				echo "<form method=\"post\" action=\"index.php?op=1014&sop=61&id=".$_GET["id"]."\" name=\"formulario\">";
				echo "<td><input name=\"codigo\" type=\"Text\" style=\"width:90px\"></td>";
				echo "<td><input name=\"nombre\" type=\"Text\" style=\"width:250px\"></td>";
				echo "<td><input name=\"unidades\" type=\"Text\" style=\"width:50px\" value=\"0.00\"></td>";
#				echo "<td><input name=\"pvd\" type=\"Text\" style=\"width:50px\" value=\"0.00\"></td>";
				echo "<td><input name=\"pvp\" type=\"Text\" style=\"width:50px\" value=\"0.00\"></td>";
				echo "<td><input type=\"Text\" style=\"width:50px\" value=\"0.00\" disabled></td>";
				echo "<td><input value=\"Añadir\" type=\"Submit\" style=\"width:75px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td><td></td><td></td>";
			echo "<td></td><td></td></tr>";
		$sql = "select * from sgm_cuerpo where id_cuerpo=".$_GET["id"];
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td><a href=\"index.php?op=1014&sop=63&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">[E]</a></td>";
				echo "<form method=\"post\" action=\"index.php?op=1014&sop=62&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
				echo "<td><input name=\"codigo\" type=\"Text\" style=\"width:90px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input name=\"nombre\" type=\"Text\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input name=\"unidades\" type=\"Text\" style=\"width:50px\" value=\"".$row["unidades"]."\"></td>";
#				echo "<td><input name=\"pvd\" type=\"Text\" style=\"width:50px\" value=\"".$row["pvd"]."\"></td>";
				echo "<td><input name=\"pvp\" type=\"Text\" style=\"width:50px\" value=\"".$row["pvp"]."\"></td>";
				echo "<td><input name=\"pvp\" type=\"Text\" style=\"width:50px\" value=\"".$row["total"]."\" disabled></td>";
				echo "<td><input value=\"Modificar\" type=\"Submit\" style=\"width:75px\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table><br><br>";
#		echo "<br><br>Ø&nbsp;&nbsp;&nbsp;[]";
	}

	if ($soption == 61) {
		$sql1 = "insert into sgm_cuerpo (id_cuerpo,codigo,nombre,unidades,pvp,total) ";
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$_GET["id"];
		$sql1 = $sql1.",'".$_POST["codigo"]."'";
		$sql1 = $sql1.",'".$_POST["nombre"]."'";
		$sql1 = $sql1.",".$_POST["unidades"]."";
		$sql1 = $sql1.",".$_POST["pvp"]."";
		$sql1 = $sql1.",".($_POST["pvp"]*$_POST["unidades"])."";
		$sql1 = $sql1.")";
		mysql_query(convertSQL($sql1));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=60&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 62) {
		$sql = "update sgm_cuerpo set ";
		$sql = $sql."codigo='".$_POST["codigo"]."'";
		$sql = $sql.",nombre='".$_POST["nombre"]."'";
		$sql = $sql.",unidades=".$_POST["unidades"]."";
#		$sql = $sql.",pvd=".$_POST["pvd"]."";
		$sql = $sql.",pvp=".$_POST["pvp"]."";
		$sql = $sql.",total=".($_POST["pvp"]*$_POST["unidades"])."";
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
		mysql_query(convertSQL($sql));
		echo $sql."<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=60&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 63) {
		echo "<center>";
		echo "¿Seguro que desea eliminar este material?";
		echo "<br><br><a href=\"index.php?op=1014&sop=64&id=".$_GET["id"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">[ SI ]</a><a href=\"index.php?op=1014&sop=60&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 64) {
		$sql = "delete from sgm_cuerpo WHERE id=".$_GET["id_cuerpo"];
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=60&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 70) {
		echo "<br><strong>Lista de materiales pendientes : </strong><br><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"1\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\"><em>Ped. Cliente</em></td>";
				echo "<td style=\"text-align:center;\"><em>Código</em></td>";
				echo "<td style=\"text-align:center;\"><em>Material</em></td>";
				echo "<td style=\"text-align:center;\"><em>Unidades</em></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\"><em>Ped. Proveedor</em></td><td></td>";
			echo "</tr>";

		if ($_GET["id"] <> "") {
			$sqlx = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
			$resultx = mysql_query(convertSQL($sqlx));
			$x = 0;
			while ($rowx = mysql_fetch_array($resultx)) {
				if ($x == 1) { $sql2 = $sql2." or id_cuerpo=".$rowx["id"]; }
				if ($x == 0) { $sql2 = $sql2." id_cuerpo=".$rowx["id"];	$x = 1;	}
			}
			$sql = "select * from sgm_cuerpo where ".$sql2." order by id";
		}

		if ($_GET["id"] == "") {
			$sql = "select * from sgm_cuerpo where id_cuerpo<>0 order by id";
		}

		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				$sqlorigen = "select * from sgm_cuerpo where id=".$row["id_cuerpo"];
				$resultorigen = mysql_query(convertSQL($sqlorigen));
				echo $sqlorigen;
				$roworigen = mysql_fetch_array($resultorigen);

				$sqlfac = "select * from sgm_cabezera where id=".$roworigen["idfactura"];
				$resultfac = mysql_query(convertSQL($sqlfac));
				$rowfac = mysql_fetch_array($resultfac);

				echo "<form method=\"post\" action=\"index.php?op=1014&sop=22&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
				echo "<td><input value=\"Ver\" type=\"Submit\" style=\"width:30px\"></td>";
				echo "</form>";

				echo "<form method=\"post\" action=\"index.php?op=1014&sop=72&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
				echo "<td><input type=\"Text\" style=\"width:50px\" value=\"".$rowfac["numero"]."\" disabled></td>";
				echo "<td><input name=\"codigo\" type=\"Text\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input name=\"nombre\" type=\"Text\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input name=\"unidades\" type=\"Text\" style=\"width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td><input value=\"Modificar\" type=\"Submit\" style=\"width:55px\"></td>";
				echo "</form>";
				if ($row["idfactura"] == 0) {
					echo "<form method=\"post\" action=\"index.php?op=1014&sop=71&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
						echo "<td><select name=\"idfactura\" style=\"width:100px\">";
							echo "<option value=\"0\">Pendiente</option>";
							$sqlf = "select * from sgm_cabezera where tipo=4 and cerrada=0 and visible=1";
							$resultf = mysql_query(convertSQL($sqlf));
							while ($rowf = mysql_fetch_array($resultf)) {
								echo "<option value=\"".$rowf["id"]."\">".$rowf["numero"]."-".$rowf["nombre"]."</option>";
							}
						echo "</select></td>";
						echo "<td><input value=\"Añadir\" type=\"Submit\" style=\"width:75px\"></td>";
					echo "</form>";
				}
				if ($row["idfactura"] <> 0) {
					$sqlf = "select * from sgm_cabezera where id=".$row["idfactura"];
					$resultf = mysql_query(convertSQL($sqlf));
					$rowf = mysql_fetch_array($resultf);
					if ($rowf["cerrada"] == 0) {
						echo "<form method=\"post\" action=\"index.php?op=1014&sop=71&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
							echo "<td><select name=\"idfactura\" style=\"width:100px\">";
								echo "<option value=\"0\">Pendiente</option>";
								$sqlf = "select * from sgm_cabezera where tipo=4 and cerrada=0 and visible=1";
								$resultf = mysql_query(convertSQL($sqlf));
								while ($rowf = mysql_fetch_array($resultf)) {
									if ($rowf["id"] == $row["idfactura"]) {
										echo "<option value=\"".$rowf["id"]."\" selected>".$rowf["numero"]."-".$rowf["nombre"]."</option>";
									} else {
										echo "<option value=\"".$rowf["id"]."\">".$rowf["numero"]."-".$rowf["nombre"]."</option>";
									}
								}
							echo "</select></td>";
							echo "<td><input value=\"Añadir\" type=\"Submit\" style=\"width:75px\"></td>";
						echo "</form>";
					}
					if ($rowf["cerrada"] == 1) {
							echo "<td><select name=\"idfactura\" disabled style=\"width:100px\">";
								echo "<option value=\"0\">Pendiente</option>";
								$sqlf = "select * from sgm_cabezera where tipo=4 and cerrada=0 and visible=1";
								$resultf = mysql_query(convertSQL($sqlf));
								while ($rowf = mysql_fetch_array($resultf)) {
									if ($rowf["id"] == $row["idfactura"]) {
										echo "<option value=\"".$rowf["id"]."\" selected>".$rowf["numero"]."-".$rowf["nombre"]."</option>";
									} else {
										echo "<option value=\"".$rowf["id"]."\">".$rowf["numero"]."-".$rowf["nombre"]."</option>";
									}
								}
							echo "</select></td>";
							echo "<td></td>";
					}
				}
			echo "</tr>";
		}
		echo "</table>";
	}

	if ($soption == 71) {
		$sql = "update sgm_cuerpo set ";
		$sql = $sql."idfactura=".$_POST["idfactura"]."";
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=70&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 72) {
		$sqlorigen = "select * from sgm_cuerpo where id=".$_GET["id_cuerpo"];
		$resultorigen = mysql_query(convertSQL($sqlorigen));
		$roworigen = mysql_fetch_array($resultorigen);
		$sql = "update sgm_cuerpo set ";
		$sql = $sql."codigo='".$_POST["codigo"]."'";
		$sql = $sql.",nombre='".$_POST["nombre"]."'";
		$sql = $sql.",unidades=".$_POST["unidades"]."";
		$sql = $sql.",total=".($roworigen["pvp"]*$_POST["unidades"])."";
		$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
		mysql_query(convertSQL($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=70&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_cuerpo_estados (estado,color,externo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["estado"]."'";
			$sql = $sql.",'".$_POST["color"]."'";
			$sql = $sql.",".$_POST["externo"]."";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_cuerpo_estados set ";
			$sql = $sql."estado='".$_POST["estado"]."'";
			$sql = $sql.",color='".$_POST["color"]."'";
			$sql = $sql.",externo=".$_POST["externo"]."";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>Estados Producci&oacute;n</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td>Id.</td>";
				echo "<td>Estado</td>";
				echo "<td>Color</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<form method=\"post\" action=\"index.php?op=1014&sop=100&ssop=1&id=".$row["id"]."\">";
				echo "<td><input type=\"Text\" name=\"estado\" value=\"".$row["estado"]."\" style=\"width:150px;\"></td>";
				echo "<td><input type=\"Text\" name=\"color\" value=\"".$row["color"]."\" style=\"width:150px;\"></td>";
				echo "<td><select name=\"externo\" style=\"width:150px;\">";
					echo "<option value=\"0\">Interno</option>";
					echo "<option value=\"1\">Externo</option>";
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:150px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_cuerpo_estados order by estado";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr style=\"background-color: ".$row["color"].";\">";
				echo "<td>".$row["id"]."</td>";
				echo "<form method=\"post\" action=\"index.php?op=1014&sop=100&ssop=2&id=".$row["id"]."\">";
				echo "<td><input type=\"Text\" name=\"estado\" value=\"".$row["estado"]."\" style=\"width:150px;\"></td>";
				echo "<td><input type=\"Text\" name=\"color\" value=\"".$row["color"]."\" style=\"width:150px;\"></td>";
				echo "<td><select name=\"externo\" style=\"width:150px;\">";
					if ($row["externo"] == 0) {
						echo "<option value=\"0\" selected>Interno</option>";
						echo "<option value=\"1\">Externo</option>";
					}
					if ($row["externo"] == 1) {
						echo "<option value=\"0\">Interno</option>";
						echo "<option value=\"1\" selected>Externo</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:150px;\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 103) {
		echo "<form method=\"post\" action=\"index.php?op=1014&sop=103&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
		$result = mysql_query(convertSQL($sql));
		$x = 1;
		while ($row = mysql_fetch_array($result)) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."id_estado=".$_POST["id_estado".$x.""];
			$sql = $sql." WHERE id=".$row["id"]."";
			mysql_query(convertSQL($sql));
#			echo $sql."<br>";

			if ($_POST["id_estado".$x.""] <> $row["id_estado"]) {
				$sql1 = "insert into sgm_cuerpo_estados_historico (id_cuerpo,id_estado,fecha,hora) ";
				$sql1 = $sql1."values (";
				$sql1 = $sql1."".$row["id"];
				$sql1 = $sql1.",".$_POST["id_estado".$x.""];
					$date = getdate();
				$sql1 = $sql1.",'".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."'";
				$sql1 = $sql1.",'".date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]))."'";
				$sql1 = $sql1.")";
				mysql_query(convertSQL($sql1));
#				echo $sql1."<br><br>";
			}
			$x++;
		}
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=22&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 110) {
		echo "<br><a href=\"index.php?op=1014&sop=110&ssop=0\">&raquo; Listado de ordenes de trabajo : Finalizadas</a>";
		echo "<br><a href=\"index.php?op=1014&sop=110&ssop=1\">&raquo; Listado de ordenes de trabajo : Pendientes de finalizar</a>";
		echo "<br><a href=\"index.php?op=1014&sop=110&ssop=2\">&raquo; Listado de ordenes de trabajo : Pendientes valorar autocontrol</a>";
		echo "<br><a href=\"index.php?op=1014&sop=110&ssop=3\">&raquo; Listado de ordenes de trabajo : Pendientes valorar horas</a>";
		echo "<br><a href=\"index.php?op=1014&sop=110&ssop=4\">&raquo; Listado de ordenes de trabajo : Pendientes valorar cotas</a>";
		if ($ssoption == 0) { $sql = "select * from sgm_cuerpo_orden_seguimiento where finalizado=1"; }
		if ($ssoption == 1) { $sql = "select * from sgm_cuerpo_orden_seguimiento where finalizado=0"; }
		if ($ssoption == 2) { $sql = "select * from sgm_cuerpo_orden_seguimiento where val_autocontrol=0"; }
		if ($ssoption == 3) { $sql = "select * from sgm_cuerpo_orden_seguimiento where val_horas=0"; }
		if ($ssoption == 4) { $sql = "select * from sgm_cuerpo_orden_seguimiento where val_cotas=0"; }
		$result = mysql_query(convertSQL($sql));
		echo "<br><br>";
		echo "<table>";
		echo "<tr><td style=\"width:100px;text-align:center;\">OT</td><td style=\"width:120px;text-align:center;\">Visto Bueno</td><td style=\"width:120px;text-align:center;\">Validación Autocontrol</td><td style=\"width:120px;text-align:center;\">Validación Horas</td><td style=\"width:120px;text-align:center;\">Validación Cotas</td></tr>";
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td><center><a href=\"index.php?op=1014&sop=11&id=".$row["id_cuerpo"]."\">OT : ".$row["id"]."</a></center></td>";
				if ($row["finalizado"] == 1) { echo "<td><center><strong>SI</strong></center></td>"; } else { echo "<td><center>NO</center></td>"; }
				if ($row["val_autocontrol"] == 1) { echo "<td><center><strong>Completo</strong></center></td>"; } else { echo "<td><center>Incompleto</center></td>"; }
				if ($row["val_horas"] == 1) { echo "<td><center><strong>Completo</strong></center></td>"; } else { echo "<td><center>Incompleto</center></td>"; }
				if ($row["val_cotas"] == 1) { echo "<td><center><strong>Completo</strong></center></td>"; } else { echo "<td><center>Incompleto</center></td>"; }
			echo "</tr>";
		}
		echo "</table>";
	}


	if ($soption == 300) {
		cierrapedido($_GET["id"]);
		$sql = "select * from sgm_cabezera where id=".$_GET["id"]." ORDER BY id";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$cerrada = $row["cerrada"];
		echo "<table><tr><td style=\"width:300px;vertical-align:top;\">";
				echo "<table>";
				echo "<tr><td><strong>Numero</strong></td><td>".$row["numero"]."</td></tr>";
				echo "<tr><td><strong>Fecha</strong></td><td>".$row["fecha"]."</td></tr>";
				echo "<tr><td><strong>Fecha Previsión</strong></td><td>".$row["fecha_prevision"]."</td></tr>";
				echo "<tr><td>Nombre</td><td>".$row["nombre"]."</td></tr>";
				echo "<tr><td>NIF</td><td>".$row["nif"]."</td></tr>";
				echo "<tr><td>Dirección</td><td>".$row["direccion"]."</td></tr>";
				echo "<tr><td>Población</td><td>".$row["poblacion"]."</td></tr>";
				echo "<tr><td>Codigo Postal</td><td>".$row["cp"]."</td></tr>";
				echo "<tr><td>Provincia</td><td>".$row["provincia"]."</td></tr>";
				echo "<tr><td>E-mail</td><td>".$row["mail"]."</td></tr>";
				echo "<tr><td>Telefono</td><td>".$row["telefono"]."</td></tr>";
				echo "</table>";
		echo "</td><td style=\"width:300px;vertical-align:top;\">";
				if ($cerrada == 0) {
					echo "<form method=\"post\" action=\"index.php?op=1014&sop=301&id=".$_GET["id"]."&fecha=".$row["fecha"]."\">";
					echo "<input value=\"Generar Albaran Completo\" type=\"Submit\" style=\"width:200px\">";
					echo "</form>";
				}
		echo "</td></tr></table>";
		echo "<br><br>";
		echo "<table cellspacing=\"0\">";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." and facturado=0 order by id";
		$result = mysql_query(convertSQL($sql));
		$x = 1;
		echo "<form method=\"post\" action=\"index.php?op=1014&sop=303&id=".$_GET["id"]."\">";
		if ($cerrada == 0) {
			echo "<tr><td></td><td></td><td></td><td></td><td></td><td><input type=\"text\" name=\"fecha\" value=\"".$row["fecha"]."\" style=\"width:75px\"></td></tr>";
		}
		echo "<tr><td><em>Estado</em></td><td><em>Fecha Prevision</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td>";
			if ($cerrada == 0) { echo "<input type=\"Submit\" value=\"Albaran\" style=\"width:75px\">"; }
		echo "</td></tr>";
		while ($row = mysql_fetch_array($result)) {
			$color = "white";
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
				if ($fecha_entrega < $hoy) { $color = "red"; }
					else { if ($fecha_aviso < $hoy) { $color = "orange"; }
				}
			}
			echo "<tr>";
				echo "<td>";
					$sqles = "select * from sgm_cuerpo_estados where id=".$row["id_estado"];
					$resultes = mysql_query(convertSQL($sqles));
					$rowes = mysql_fetch_array($resultes);
					echo "<select style=\"background-color : ".$rowes["color"].";width:125px\" name=\"id_estado".$x."\" disabled>";
						echo "<option value=\"0\">Sin Iniciar</option>";
						$sqles = "select * from sgm_cuerpo_estados order by estado";
						$resultes = mysql_query(convertSQL($sqles));
						while ($rowes = mysql_fetch_array($resultes)) {
							if ($rowes["id"] == $row["id_estado"]) { echo "<option value=\"".$rowes["id"]."\" selected>".$rowes["estado"]."</option>"; }
							else { echo "<option value=\"".$rowes["id"]."\">".$rowes["estado"]."</option>"; }
						}
						
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"background-color : ".$color.";width:75px\" value=\"".$row["fecha_prevision"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"unidades\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td>";
					echo "<select style=\"width:75px\" name=\"id_estado".$x."\">";
							echo "<option value=\"0\" selected>-</option>";
							echo "<option value=\"1\">Albaran</option>";
					echo "</select>";
				echo "</td>";
		echo "</tr>";
		$x++;
		}
		if ($cerrada == 0) {
			echo "<tr><td><em>Estado</em></td><td><em>Fecha Prevision</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td><input type=\"Submit\" value=\"Albaran\" style=\"width:75px\"></td></tr>";
		}
		echo "</form>";


		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." and facturado=1 order by id";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			$color = "white";
			if ($row["facturado"] == 1) {
				$color = "#4281fd";
			} else {
				$date = getdate();
				$hoy = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				$a = date("Y", strtotime($row["fecha_prevision"]));
				$m = date("m", strtotime($row["fecha_prevision"]));
				$d = date("d", strtotime($row["fecha_prevision"]));
				$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
				$fecha_entrega = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
				if ($fecha_entrega < $hoy) { $color = "red"; }
					else { if ($fecha_aviso < $hoy) { $color = "orange"; }
				}
			}
			echo "<tr>";
				echo "<td>";
					$sqles = "select * from sgm_cuerpo_estados where id=".$row["id_estado"];
					$resultes = mysql_query(convertSQL($sqles));
					$rowes = mysql_fetch_array($resultes);
					echo "<select style=\"background-color : ".$rowes["color"].";width:125px\" name=\"id_estado".$x."\" disabled>";
						echo "<option value=\"0\">Sin Iniciar</option>";
						$sqles = "select * from sgm_cuerpo_estados order by estado";
						$resultes = mysql_query(convertSQL($sqles));
						while ($rowes = mysql_fetch_array($resultes)) {
							if ($rowes["id"] == $row["id_estado"]) { echo "<option value=\"".$rowes["id"]."\" selected>".$rowes["estado"]."</option>"; }
							else { echo "<option value=\"".$rowes["id"]."\">".$rowes["estado"]."</option>"; }
						}
						
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"background-color : ".$color.";width:75px\" value=\"".$row["fecha_prevision"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"unidades\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td>";
					echo "<select style=\"width:75px\" name=\"id_estado".$x."\" disabled>";
						echo "<option value=\"1\" selected>Procesado</option>";
					echo "</select>";
				echo "</td>";
		echo "</tr>";
		}
		echo "<input type=\"Hidden\" value=\"".$x."\" name=\"x\"></form>";
		echo "</table>";
	}

	if ($soption == 303) {

		# mira si el albaran esta valorado o no
		$cerrada = 1;
		$sqll = "select * from sgm_cuerpo where facturado=0 and idfactura=".$_GET["id"];
		$resultl = mysql_query(convertSQL($sqll));
		$x=1;
		while ($rowl = mysql_fetch_array($resultl)) {
			if ($_POST["id_estado".$x] == 1) {
				if ($rowl["pvp"] == 0.0) { $cerrada = 0; }
			}
			$x++;
		}

		$sqlc = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultc = mysql_query(convertSQL($sqlc));
		$rowc = mysql_fetch_array($resultc);

		$sqln = "select * from sgm_cabezera where visible=1 AND tipo=2 order by numero desc";
		$resultn = mysql_query(convertSQL($sqln));
		$rown = mysql_fetch_array($resultn);
		$numero = $rown["numero"] + 1;

		$sql = "select * from sgm_clients where id=".$rowc["id_cliente"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$sql = "insert into sgm_cabezera (numero,numero_cliente,fecha,fecha_prevision,tipo,nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,id_cliente,id_user,notas,cerrada) ";
		$sql = $sql."values (";
		$sql = $sql.$numero;
		$sql = $sql.",'".$rowc["numero_cliente"]."'";
		$sql = $sql.",'".$_POST["fecha"]."'";
		$sql = $sql.",'".$rowc["fecha_prevision"]."'";
		$sql = $sql.",2";
		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".$row["direccion"]."'";
		$sql = $sql.",'".$row["poblacion"]."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".$row["provincia"]."'";
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";

		$sql2 = "select * from sgm_dades_origen_factura";
		$result2 = mysql_query(convertSQL($sql2));
		$row = mysql_fetch_array($result2);

		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".$row["direccion"]."'";
		$sql = $sql.",'".$row["poblacion"]."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".$row["provincia"]."'";
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";

		$sql = $sql.",".$rowc["id_cliente"];
		$sql = $sql.",".$userid;
		$sql = $sql.",'OT : ".$rowc["numero"]."'";
		$sql = $sql.",".$cerrada;
		$sql = $sql.")";
		mysql_query(convertSQL($sql));

		$sqln = "select * from sgm_cabezera order by id desc";
		$resultn = mysql_query(convertSQL($sqln));
		$rown = mysql_fetch_array($resultn);
		$ultima_cabezera = $rown["id"];

		$sqll = "select * from sgm_cuerpo where facturado=0 and idfactura=".$_GET["id"];
		$resultl = mysql_query(convertSQL($sqll));
		$x=1;
		while ($rowl = mysql_fetch_array($resultl)) {
			if ($_POST["id_estado".$x] == 1) {
				$sql = "insert into sgm_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total,fecha_prevision) ";
				$sql = $sql."values (";
				$sql = $sql."".$ultima_cabezera;
				$sql = $sql.",'".$rowl["codigo"]."'";
				$sql = $sql.",'".$rowl["nombre"]."'";
				$sql = $sql.",0";
				$sql = $sql.",".$rowl["pvp"];
				$sql = $sql.",".$rowl["unidades"];
				$total = $rowl["unidades"] * $rowl["pvp"];
				$sql = $sql.",".$total;
				$sql = $sql.",'".$rowl["fecha_prevision"]."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."facturado=1";
				$sql = $sql." WHERE id=".$rowl["id"]."";
				mysql_query(convertSQL($sql));
			}
			$x++;
		}

		refactura($ultima_cabezera);
		cierrapedido($_GET["id"]);

		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=300&id=".$_GET["id"]."\">[ Volver ]</a>";

	}

	if ($soption == 301) {
		echo "<center>";
			echo "Selecciona la fecha para el albaran :";
			if ($ssoption == 0) { echo "<form method=\"post\" action=\"index.php?op=1014&sop=302&id=".$_GET["id"]."\">"; }
				echo "<table><tr>";
					echo "<td><input type=\"text\" value=\"".$_GET["fecha"]."\" name=\"fecha\"></td>";
					echo "<td><input type=\"Submit\" value=\"Continuar\" style=\"width:125px\"></td>";
				echo "</tr></table>";
			echo "</form>";
		$sqln = "select * from sgm_cabezera where visible=1 AND tipo=2 order by numero desc";
		$resultn = mysql_query(convertSQL($sqln));
		$rown = mysql_fetch_array($resultn);
		echo "<br><em style=\"color:red\">La feha del último albarán es : <strong>".$rown["fecha"]."</strong></em>";
		echo "</center>";
	}



	if ($soption == 302) {

		# mira si el albaran esta valorado o no
		$cerrada = 1;
		$sqll = "select * from sgm_cuerpo where idfactura=".$_GET["id"];
		$resultl = mysql_query(convertSQL($sqll));
		while ($rowl = mysql_fetch_array($resultl)) {
			if ($rowl["pvp"] == 0.0) { $cerrada = 0; }
		}

		$sqlc = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultc = mysql_query(convertSQL($sqlc));
		$rowc = mysql_fetch_array($resultc);

		$sqln = "select * from sgm_cabezera where visible=1 AND tipo=2 order by numero desc";
		$resultn = mysql_query(convertSQL($sqln));
		$rown = mysql_fetch_array($resultn);
		$numero = $rown["numero"] + 1;

		$sql = "select * from sgm_clients where id=".$rowc["id_cliente"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$sql = "insert into sgm_cabezera (numero,numero_cliente,fecha,fecha_prevision,tipo,nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,id_cliente,id_user,notas,cerrada) ";
		$sql = $sql."values (";
		$sql = $sql.$numero;
		$sql = $sql.",'".$rowc["numero_cliente"]."'";
		$sql = $sql.",'".$_POST["fecha"]."'";
		$sql = $sql.",'".$rowc["fecha_prevision"]."'";
		$sql = $sql.",2";
		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".$row["direccion"]."'";
		$sql = $sql.",'".$row["poblacion"]."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".$row["provincia"]."'";
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";

		$sql2 = "select * from sgm_dades_origen_factura";
		$result2 = mysql_query(convertSQL($sql2));
		$row = mysql_fetch_array($result2);

		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",'".$row["nif"]."'";
		$sql = $sql.",'".$row["direccion"]."'";
		$sql = $sql.",'".$row["poblacion"]."'";
		$sql = $sql.",'".$row["cp"]."'";
		$sql = $sql.",'".$row["provincia"]."'";
		$sql = $sql.",'".$row["mail"]."'";
		$sql = $sql.",'".$row["telefono"]."'";

		$sql = $sql.",".$rowc["id_cliente"];
		$sql = $sql.",".$userid;
		$sql = $sql.",'OT : ".$rowc["numero"]."'";
		$sql = $sql.",".$cerrada;
		$sql = $sql.")";
		mysql_query(convertSQL($sql));

		$sqln = "select * from sgm_cabezera order by id desc";
		$resultn = mysql_query(convertSQL($sqln));
		$rown = mysql_fetch_array($resultn);
		$ultima_cabezera = $rown["id"];

		$sqll = "select * from sgm_cuerpo where facturado=0 and idfactura=".$_GET["id"];
		$resultl = mysql_query(convertSQL($sqll));
		while ($rowl = mysql_fetch_array($resultl)) {
			$sql = "insert into sgm_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total,fecha_prevision) ";
			$sql = $sql."values (";
			$sql = $sql."".$ultima_cabezera;
			$sql = $sql.",'".$rowl["codigo"]."'";
			$sql = $sql.",'".$rowl["nombre"]."'";
			$sql = $sql.",0";
			$sql = $sql.",".$rowl["pvp"];
			$sql = $sql.",".$rowl["unidades"];
			$total = $rowl["unidades"] * $rowl["pvp"];
			$sql = $sql.",".$total;
			$sql = $sql.",'".$rowl["fecha_prevision"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));

			$sql = "update sgm_cuerpo set ";
			$sql = $sql."facturado=1";
			$sql = $sql." WHERE id=".$rowl["id"]."";
			mysql_query(convertSQL($sql));
		}
		refactura($ultima_cabezera);
		cierrapedido($_GET["id"]);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1014&sop=300&id=".$_GET["id"]."\">[ Volver ]</a>";
	}

	if ($soption == 999999) {
		$sql = "select * from sgm_cuerpo_orden_seguimiento where descripcion=''";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			$sqlc = "select * from sgm_cuerpo where id=".$row["id_cuerpo"];
			$resultc = mysql_query(convertSQL($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$sql1 = "update sgm_cuerpo_orden_seguimiento set ";
			$sql1 = $sql1."descripcion='".$rowc["nombre"]."'";
			$sql1 = $sql1." WHERE id=".$row["id"]."";
			mysql_query(convertSQL($sql1));
			echo $sql1."<br>";
		}
	}
	echo "</td></tr></table><br>";
}

?>
