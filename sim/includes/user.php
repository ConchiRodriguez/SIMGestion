<?php

if ($option == 200) {

if ($user == false) {
	echo "Usuario no autorizado. Compruebe su usuario y/o password de nuevo";
	}
	else {

	$sqluser = "select * from sgm_users WHERE id=".$userid;
	$resultuser = mysql_query($sqluser);
	$rowuser = mysql_fetch_array($resultuser);
	
	$sqluserclient = "select count(*) as total from sgm_users_clients WHERE id_user=".$userid;
	$resultuserclient = mysql_query($sqluserclient);
	$rowuserclient = mysql_fetch_array($resultuserclient);
	$nclientes = $rowuserclient["total"];



	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";

		if ($rowuser["sgm"] == 1) {
			$sqlp = "select count(*) as total from sgm_users_permisos_modulos";
			$resultp = mysql_query($sqlp);
			$rowp = mysql_fetch_array($resultp);
			if ($rowp["total"] != 0) {
				echo "<td style=\"width:25%;vertical-align : top;\">";
					echo "<table style=\"width:100%\" cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr><td style=\"width:100%;text-align:left;\"><strong class=\"gris\">ADMINISTRACIÓN</strong></td></tr>";
						$sqlm = "select * from sgm_users_permisos_modulos where visible=1 order by nombre";
						$resultm = mysql_query($sqlm);
						while ($rowm = mysql_fetch_array($resultm)) {
							echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?op=".$rowm["id_modulo"]."\" class=\"gris\">&raquo; ".$rowm["nombre"]."</a></td></tr>";
						}
					echo "</table>";
				echo "</td>";
			}
		}

		echo "<td style=\"width:25%;vertical-align : top;\">";
			echo "<table style=\"width:100%\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr><td style=\"width:100%;text-align:left;\"><strong class=\"gris\">DATOS USUARIO</strong></td></tr>";
				echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?op=200&sop=10\" class=\"gris\">&raquo; Datos de usuario</a></td></tr>";
				echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?op=200&sop=72\" class=\"gris\">&raquo; Modificar firma</a></td></tr>";
				echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?op=200&sop=70\" class=\"gris\">&raquo; Cambio de password</a></td></tr>";
				echo "<tr><td style=\"width:100%;text-align:left;\">&nbsp;</td></tr>";

				$sqlp = "select count(*) as total from sgm_users_permisos_modulos WHERE id_modulo=1003";
				$resultp = mysql_query($sqlp);
				$rowp = mysql_fetch_array($resultp);
				if ($rowp["total"] == 1) {
					echo "<tr><td style=\"width:100%;text-align:left;\"><strong class=\"gris\">DATOS CLIENTE</strong></td></tr>";
					echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?op=200&sop=30\" class=\"gris\">&raquo; Facturación</a></td></tr>";
					echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?op=200&sop=40\" class=\"gris\">&raquo; Incidencias</a></td></tr>";
				}

			echo "</table>";
		echo "</td>";

		echo "<td style=\"width:25%;vertical-align : top;\">";
			echo "<table style=\"width:100%\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr><td style=\"width:100%;text-align:left;\"><strong class=\"gris\">OTROS</strong></td></tr>";
				echo "<tr><td style=\"width:100%;text-align:left;\"><a href=\"index.php?sop=666\" class=\"gris\">&raquo; Salir</td></tr>";
			echo "</table>";
		echo "</td>";

echo "</tr></table><br>";
echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" class=\"gris\"><tr><td>";


	if ($soption == 40) {
		if ($nclientes == 0) {
			echo "<br><strong>Este usuario no esta relacionado con ningun cliente.</strong>";
			echo "<br><br>";
			echo "Si usted ya es cliente nuestro y simplemente desea que su usuario se relacione con una cuenta de cliente, envie un mail a <a href=\"mailto:administracion@multivia.com\">administracion@multivia.com</a> indicando su nombre de usuario o id.";
			echo "<br><br>";
			echo "Si por el contrario desea crear una cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
		}
		else {
			echo "<strong>Bienvenido al área de incidencias de Multivia.com</strong>";
			echo "<br><br>";
			echo "Si crear una nueva cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
			$sql = "select * from sgm_users_clients WHERE id_user=".$userid;
			$result = mysql_query($sql);
			echo "<br><table><tr><td style=\"width:150px;\"><strong>Empresa</strong></td><td></td><td></td></tr>";
			while ($row = mysql_fetch_array($result)) {
				$sql1 = "select * from sgm_clients WHERE id=".$row["id_client"];
				$result1 = mysql_query($sql1);
				$row1 = mysql_fetch_array($result1);
				echo "<tr>";
				echo "<td>".$row1["nombre"]."</td>";
				echo "<td><a href=\"index.php?op=200&sop=41&id=".$row1["id"]."\" class=\"gris\">[ Ver incidencias ]</a></td>";
				echo "</tr>";
			}
			echo "</table><br><br>";
		}
	}


	if ($soption == 41) {
		$autorizado = 0;
		$sql = "select count(*) as total from sgm_users_clients WHERE (id_client=".$_GET["id"].") AND (id_user=".$userid.")";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$autorizado = $row["total"];
	
		if ($autorizado == 0) {
			echo "<br><strong>Este usuario no autorizado con el cliente seleccionado.</strong><br><br>";
		}
		else {
			$sql = "select * from sgm_incidencias WHERE id_cliente=".$_GET["id"]." order by data_registro desc";
			$result = mysql_query($sql);
			echo "<table>";
			echo "<tr><td><em>Estado</em></td><td><em>Fecha registro</em></td><td></td><td>Incidencia</td></tr>";
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					$sqlx = "select * from sgm_incidencias_estados WHERE id=".$row["id_estado"];
					$resultx = mysql_query($sqlx);
					$rowx = mysql_fetch_array($resultx);

					echo "<td>".$rowx["estado"]."</td>";

					echo "<td><strong>".$row["data_registro"]."</strong></td>";
					echo "<td><a href=\"includes/gestion-incidencia-print.php?id=".$row["id"]."\" target=\"_blank\">[ Imprimir ]</a></td>";
					echo "<td>";
						if (strlen($row["notas_registro"]) > 100) { echo substr($row["notas_registro"],0,100)." ..."; }
							else { echo $row["notas_registro"]; }
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
	}

























	if ($soption == 0) {
		echo "<br>Bienvenido al <strong>PANEL DE USUARIO</strong>.<br><br>Desde esta extranet podrás acceder a tus datos fiscales, facturación y demás opciones a tu disposición.<br><br>";
	}


	if ($soption == 2) {
		if (($_POST["nombre"] == "") OR ($_POST["nif"] == "") OR ($_POST["direccion"] == "") OR ($_POST["poblacion"] == "") OR ($_POST["cp"] == "") OR ($_POST["provincia"] == "")) {
			echo "<br><br>Debes introduccir todos los campos obligatorios.<br><br>";
		} else {
			$sql = "update sgm_clients set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",nif='".$_POST["nif"]."'";
			$sql = $sql.",direccion='".$_POST["direccion"]."'";
			$sql = $sql.",poblacion='".$_POST["poblacion"]."'";
			$sql = $sql.",cp='".$_POST["cp"]."'";
			$sql = $sql.",cuentabancaria='".$_POST["cuentabancaria"]."'";
			$sql = $sql.",provincia='".$_POST["provincia"]."'";
			$sql = $sql.",mail='".$_POST["mail"]."'";
			$sql = $sql.",web='".$_POST["web"]."'";
			$sql = $sql.",telefono='".$_POST["telefono"]."'";
			$sql = $sql.",sector=".$_POST["sector"]."";
			$sql = $sql.",propaganda=".$_POST["propaganda"]."";
			$sql = $sql.",contacto_nombre='".$_POST["contacto_nombre"]."'";
			$sql = $sql.",contacto_telefono='".$_POST["contacto_telefono"]."'";
			$sql = $sql.",contacto_mail='".$_POST["contacto_mail"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query($sql);
			echo $sql."<br><br>Operación realizada correctamente.";
			echo "<br><br><a href=\"index.php?op=200&sop=1\"><img src=\"pics/flexa.gif\" border=\"0\">[ Volver ]</a>";
		}
	}

	if ($soption == 5) {
		echo "<table>";
		echo "<form action=\"index.php?dir=".$modulo."&sop=3\" method=\"post\">";
		echo "<tr><td><strong>Datos fiscales</strong></td><td></td></tr>";
		echo "<tr><td>Nombre</td><td><input type=\"Text\" name=\"nombre\" class=\"px300\"></td></tr>";
		echo "<tr><td>NIF</td><td><input type=\"Text\" name=\"nif\" class=\"px150\"></td></tr>";
		echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"direccion\" class=\"px150\"></td></tr>";
		echo "<tr><td>Población</td><td><input type=\"Text\" name=\"poblacion\" class=\"px150\"></td></tr>";
		echo "<tr><td>Codigo Postal</td><td><input type=\"Text\" name=\"cp\" class=\"px150\"></td></tr>";
		echo "<tr><td>Provincia</td><td><input type=\"Text\" name=\"provincia\" class=\"px150\"></td></tr>";
		echo "<tr><td><strong>Datos bancarios</strong></td><td></td></tr>";
		echo "<tr><td>Cuenta bancaria</td><td><input type=\"Text\" name=\"cuentabancaria\" class=\"px300\"></td></tr>";
		echo "<tr><td><strong>Datos adicionales</strong></td><td></td></tr>";
		echo "<tr><td>Sector</td><td><select class=\"px150\" name=\"sector\">";
			echo "<option value=\"0\">Indeterminado</option>";
			$sql = "select * from sgm_clients_sectors order by sector";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result)) {
				echo "<option value=\"".$row["id"]."\">".$row["sector"]."</option>";
			}
		echo "</select></td></tr>";
		echo "<tr><td>E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\"></td></tr>";
		echo "<tr><td>Web</td><td><input type=\"Text\" name=\"web\" class=\"px150\"></td></tr>";
		echo "<tr><td>Telefono</td><td><input type=\"Text\" name=\"telefono\" class=\"px150\"></td></tr>";
		echo "<tr><td>Notas</td><td><textarea name=\"notas\" class=\"px300\" rows=\"6\"></textarea></td></tr>";
		echo "<tr><td><strong>Datos comerciales</strong></td><td></td></tr>";
		echo "<tr><td>Nombre contacto</td><td><input type=\"Text\" name=\"contacto_nombre\" class=\"px300\"></td></tr>";
		echo "<tr><td>Telefono contacto</td><td><input type=\"Text\" name=\"contacto_telefono\" class=\"px150\"></td></tr>";
		echo "<tr><td>Mail contacto</td><td><input type=\"Text\" name=\"contacto_mail\" class=\"px150\"></td></tr>";
		echo "<tr><td>Recibir propaganda</td><td>";
			echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\"checked>";
			echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\">";
		echo "</td></tr>";
		echo "<tr><td>Notas comerciales</td><td><textarea name=\"notas_comerciales\" class=\"px300\" rows=\"6\"></textarea></td></tr>";
		echo "<tr><td><strong>Definición cliente</strong></td><td></td></tr>";
		echo "<tr><td>Client</td><td>";
			echo "SI <input type=\"Radio\" name=\"client\" value=\"1\" checked>";
			echo "NO <input type=\"Radio\" name=\"client\" value=\"0\">";
		echo "</td></tr>";
		echo "<tr><td>Client Tipus</td><td>";
			echo "Particular <input type=\"Radio\" name=\"clienttipus\" value=\"0\" checked>";
			echo "Empresa <input type=\"Radio\" name=\"clienttipus\" value=\"1\">";
		echo "</td></tr>";
		echo "<tr><td>Client VIP</td><td>";
			echo "Si <input type=\"Radio\" name=\"clientvip\" value=\"1\">";
			echo "No <input type=\"Radio\" name=\"clientvip\" value=\"0\" checked>";
		echo "</td></tr>";
		echo "<tr><td></td><td><input type=\"Submit\" value=\"Añadir\" style=\"width:150px\"></td></tr>";
		echo "</form>";
		echo "</table>";
	}

	if ($soption == 10) {
			echo "<table><tr><td style=\"vertical-align:top;\">";
			echo "Datos del usuario : <strong><em>".$username."</em></strong><br><br>";
			echo "<form action=\"index.php?op=200&sop=11\" method=\"post\">";
			echo "<table>";
			echo "<tr><td>Dirección eMail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\" value=\"".$rowuser["mail"]."\"></td></tr>";
			if ($rowuser["public"] == 1) { echo "<tr><td>Mostrar eMail</td><td><input type=\"Radio\" name=\"public\" value=\"1\" checked style=\"border : 0;\">Si<input type=\"Radio\" name=\"public\" value=\"0\" style=\"border : 0;\">No</td></tr>"; 	}
			else { echo "<tr><td>Mostrar eMail</td><td><input type=\"Radio\" name=\"public\" value=\"1\" style=\"border : 0;\">Si<input type=\"Radio\" name=\"public\" value=\"0\" style=\"border : 0;\" checked>No</td></tr>"; 	}
			echo "<tr><td>Dirección web</td><td><input type=\"Text\" name=\"url\" class=\"px200\" value=\"".$rowuser["url"]."\"></td></tr>";
			echo "<tr><td>MSN</td><td><input type=\"Text\" name=\"msn\" class=\"px150\" value=\"".$rowuser["msn"]."\"></td></tr>";
			echo "<tr><td>ICQ</td><td><input type=\"Text\" name=\"icq\" class=\"px100\" value=\"".$rowuser["icq"]."\"></td></tr>";
			echo "<tr><td>Fecha nacimiento</td><td><input type=\"Text\" name=\"dateborn\" class=\"px100\" value=\"".$rowuser["dateborn"]."\"></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Cambiar\" class=\"px100\"></td></tr>";
			echo "</table>";
			echo "</form>";
		echo "</td>";
		echo "</td></tr></table>";
	}

	if ($soption == 11) {
		$sqlx = "select count(*) as total from sgm_users WHERE mail='".$_POST["mail"]."' AND id<>".$userid;
		$resultx = mysql_query($sqlx);
		$rowx = mysql_fetch_array($resultx);
		if ($rowx["total"] == 0) {
			$sql = "update sgm_users set mail='".$_POST["mail"]."',msn='".$_POST["msn"]."',icq='".$_POST["icq"]."',url='".$_POST["url"]."',dateborn='".$_POST["dateborn"]."',public=".$_POST["public"]." WHERE id=".$userid;
			mysql_query($sql);
		}
		else {
			echo "No se a podido actualizar los datos por que la dirección de correo mail ya esta en uso.";
		}
		echo "<br><br><a href=\"index.php?op=200&sop=10\">[ Volver ]</a>";
	}


	if ($soption == 30) {
		if ($nclientes == 0) {
			echo "<br><strong>Este usuario no esta relacionado con ningun cliente.</strong>";
			echo "<br><br>";
			echo "Si usted ya es cliente nuestro y simplemente desea que su usuario se relacione con una cuenta de cliente, envie un mail a <a href=\"mailto:administracion@multivia.com\">administracion@multivia.com</a> indicando su nombre de usuario o id.";
			echo "<br><br>";
			echo "Si por el contrario desea crear una cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
		}
		else {
			echo "<strong>Bienvenido al área de facturación de Multivia.com</strong>";
			echo "<br><br>";
			echo "Si crear una nueva cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
			$sql = "select * from sgm_users_clients WHERE id_user=".$userid;
			$result = mysql_query($sql);
			echo "<br><table><tr><td style=\"width:150px;\"><strong>Empresa</strong></td><td></td><td></td></tr>";
			while ($row = mysql_fetch_array($result)) {
				$sql1 = "select * from sgm_clients WHERE id=".$row["id_client"];
				$result1 = mysql_query($sql1);
				$row1 = mysql_fetch_array($result1);
				echo "<tr>";
				echo "<td>".$row1["nombre"]."</td>";
				echo "<td><a href=\"index.php?op=200&sop=32&id=".$row1["id"]."\" class=\"gris\">[ Datos Facturación ]</a></td>";
				echo "<td><a href=\"index.php?op=200&sop=31&id=".$row1["id"]."\" class=\"gris\">[ Ver Facturas / Estado ]</a></td>";
				echo "</tr>";
			}
			echo "</table><br><br>";
		}
	}


	if ($soption == 31) {
		$autorizado = 0;
		$sql = "select count(*) as total from sgm_users_clients WHERE (id_client=".$_GET["id"].") AND (id_user=".$userid.")";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$autorizado = $row["total"];
	
		if ($autorizado == 0) {
			echo "<br><strong>Este usuario no autorizado con el cliente seleccionado.</strong><br><br>";
		}
		else {
		$sqltipos = "select * from sgm_factura_tipos where ((id=1) OR (id=2)) order by id";
		$resulttipos = mysql_query($sqltipos);
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
		while ($rowtipos = mysql_fetch_array($resulttipos)) {
			echo "<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td><strong>".$rowtipos["tipo"]."</strong></td><td></td><td></td></tr>";
			echo "<tr><td></td><td style=\"width:70px\"><em><center>Número</center></em></td><td style=\"width:85px\"><em><center>Fecha</center></em></td><td style=\"width:250px\"><em>Cliente</em></td><td style=\"text-align:right;\"><em>Total</em>&nbsp;&nbsp;</td><td></td><td>&nbsp;&nbsp;<em>Estado</em></td></tr>";
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." AND id_cliente=".$_GET["id"]." order by numero desc,fecha desc";
			$result = mysql_query($sql);
			$fechahoy = getdate();
			while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td><img src=\"pics/flexa.gif\" border=\"0\"></td>";
						echo "<td><center>".$row["numero"]."</center></td>";
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
								$result00 = mysql_query($sql00);
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
						echo "<td>".$row["nombre"]."</td>";
						echo "<td style=\"text-align : right;\"><strong>".$row["total"]." €</strong> </td>";
						echo "<td>&nbsp;&nbsp;<a href=\"includes/gestion-facturas-print.php?id=".$row["id"]."\" target=\"_blank\" class=\"gris\">[Visualizar]</a></td>";
						echo "<td>&nbsp;&nbsp;";
						if ($rowtipos["id"] == 1) {
							if ($row["cobrada"] == 1) {
								echo "<em>PAGADA</em>";
							} else {
								if ($row["domiciliada"] == 1) {
									echo "<em>DOMICILIADA</em>";
								} else {
									echo "<em>PENDIENTE</em>";
								}
							}
						}
						if ($rowtipos["id"] == 2) {
							if ($row["cobrada"] == 1) {
								echo "<em>FACTURADO</em>";
							} else {
								echo "<em>PENDIENTE</em>";
							}
						}
						echo "</td>";
					echo "</tr>";
			}
		}
		echo "</table>";
	}
	}

	if ($soption == 32) {
		$autorizado = 0;
		$sql = "select count(*) as total from sgm_users_clients WHERE (id_client=".$_GET["id"].") AND (id_user=".$userid.")";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$autorizado = $row["total"];
	
		if ($autorizado == 0) {
			echo "<br><strong>Este usuario no autorizado con el cliente seleccionado.</strong><br><br>";
		}
		else {
			$sql = "select * from sgm_clients where id=".$_GET["id"];
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			echo "<table>";
			echo "<form action=\"index.php?op=200&sop=33&id=".$row["id"]."\" method=\"post\">";
			echo "<tr><td class=\"gris\"><strong>Datos fiscales</strong></td><td></td></tr>";
			echo "<tr><td class=\"gris\">Nombre <strong>*</strong></td><td><input type=\"Text\" name=\"nombre\" class=\"gris\" style=\"width:200px\" value=\"".$row["nombre"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">NIF <strong>*</strong></td><td><input type=\"Text\" name=\"nif\" class=\"gris\" style=\"width:150px\" value=\"".$row["nif"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Dirección <strong>*</strong></td><td><input type=\"Text\" name=\"direccion\" class=\"gris\" style=\"width:150px\" value=\"".$row["direccion"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Población <strong>*</strong></td><td><input type=\"Text\" name=\"poblacion\" class=\"gris\" style=\"width:150px\" value=\"".$row["poblacion"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Codigo Postal <strong>*</strong></td><td><input type=\"Text\" name=\"cp\" class=\"gris\" style=\"width:150px\" value=\"".$row["cp"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Provincia <strong>*</strong></td><td><input type=\"Text\" name=\"provincia\" class=\"gris\" style=\"width:150px\" value=\"".$row["provincia"]."\"></td></tr>";
			echo "<tr><td class=\"gris\"><strong>Datos bancarios</strong></td><td></td></tr>";
			echo "<tr><td class=\"gris\">Cuenta bancaria</td><td><input type=\"Text\" name=\"cuentabancaria\" class=\"gris\" style=\"width:300px\" value=\"".$row["cuentabancaria"]."\"></td></tr>";
			echo "<tr><td class=\"gris\"><strong>Datos adicionales</strong></td><td></td></tr>";
			echo "<tr><td class=\"gris\">Sector</td><td><select class=\"gris\" style=\"width:150px\" name=\"sector\">";
				echo "<option value=\"0\">Indeterminado</option>";
				$sql1 = "select * from sgm_clients_sectors order by sector";
				$result1 = mysql_query($sql1);
				while ($row1 = mysql_fetch_array($result1)) {
					if ($row1["id"] == $row["sector"]) { echo "<option value=\"".$row1["id"]."\" selected>".$row1["sector"]."</option>"; }
					else { echo "<option value=\"".$row1["id"]."\">".$row1["sector"]."</option>"; }
				}
			echo "</select></td></tr>";
			echo "<tr><td class=\"gris\">E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"gris\" style=\"width:150px\" value=\"".$row["mail"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Web</td><td><input type=\"Text\" name=\"web\" class=\"gris\" style=\"width:150px\" value=\"".$row["web"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Telefono</td><td><input type=\"Text\" name=\"telefono\" class=\"gris\" style=\"width:150px\" value=\"".$row["telefono"]."\"></td></tr>";
			echo "<tr><td class=\"gris\"><strong>Datos comerciales</strong></td><td></td></tr>";
			echo "<tr><td class=\"gris\">Nombre contacto</td><td><input type=\"Text\" name=\"contacto_nombre\" class=\"gris\" style=\"width:150px\" value=\"".$row["contacto_nombre"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Telefono contacto</td><td><input type=\"Text\" name=\"contacto_telefono\" class=\"gris\" style=\"width:150px\" value=\"".$row["contacto_telefono"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Mail contacto</td><td><input type=\"Text\" name=\"contacto_mail\" class=\"gris\" style=\"width:150px\" value=\"".$row["contacto_mail"]."\"></td></tr>";
			echo "<tr><td class=\"gris\">Recibir propaganda</td><td class=\"gris\">";
				if ($row["propaganda"] == 1) {
					echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\" style=\"border:0px\" checked>";
					echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\" style=\"border:0px\">";
				}
				if ($row["propaganda"] == 0) {
					echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\" style=\"border:0px\">";
					echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\" style=\"border:0px\" checked>";
				}
			echo "</td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Modificar Datos\" style=\"width:150px\" class=\"gris\"></td></tr>";
			echo "</form>";
			echo "</table>";
			echo "<strong>*</strong> Campos obligatorios.";
		}
	}

	if ($soption == 33) {
		$ok = 1;
		if ($_POST["nombre"] == '') { $ok = 0; }
		if ($_POST["nif"] == '') { $ok = 0; }
		if ($_POST["direccion"] == '') { $ok = 0; }
		if ($_POST["poblacion"] == '') { $ok = 0; }
		if ($_POST["cp"] == '') { $ok = 0; }
		if ($_POST["provincia"] == '') { $ok = 0; }
		if ($ok == 0) {
			echo "<br><br>No se completó la actualización de datos. Hay campos obligatorios en blanco.";
			echo "<br><br><a href=\"index.php?op=200&sop=32&id=".$_GET["id"]."\" class=\"gris\"><img src=\"pics/flexa.gif\" border=\"0\">[ Volver ]</a>";
		}
		if ($ok == 1) {
			$sql = "update sgm_clients set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",nif='".$_POST["nif"]."'";
			$sql = $sql.",direccion='".$_POST["direccion"]."'";
			$sql = $sql.",poblacion='".$_POST["poblacion"]."'";
			$sql = $sql.",cp='".$_POST["cp"]."'";
			$sql = $sql.",cuentabancaria='".$_POST["cuentabancaria"]."'";
			$sql = $sql.",provincia='".$_POST["provincia"]."'";
			$sql = $sql.",mail='".$_POST["mail"]."'";
			$sql = $sql.",web='".$_POST["web"]."'";
			$sql = $sql.",telefono='".$_POST["telefono"]."'";
			$sql = $sql.",sector=".$_POST["sector"]."";
			$sql = $sql.",propaganda=".$_POST["propaganda"]."";
			$sql = $sql.",contacto_nombre='".$_POST["contacto_nombre"]."'";
			$sql = $sql.",contacto_telefono='".$_POST["contacto_telefono"]."'";
			$sql = $sql.",contacto_mail='".$_POST["contacto_mail"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query($sql);
			echo "<br><br>Operación realizada correctamente.";
			echo "<br><br><a href=\"index.php?op=200&sop=32&id=".$_GET["id"]."\" class=\"gris\"><img src=\"pics/flexa.gif\" border=\"0\">[ Volver ]</a>";
		}
	}

	if ($soption == 34) {
		echo "<table>";
		echo "<form action=\"index.php?op=200&sop=35\" method=\"post\">";
		echo "<tr><td><strong>Datos fiscales</strong></td><td></td></tr>";
		echo "<tr><td>Nombre *</td><td><input type=\"Text\" name=\"nombre\" class=\"px300\"></td></tr>";
		echo "<tr><td>NIF *</td><td><input type=\"Text\" name=\"nif\" class=\"px150\"></td></tr>";
		echo "<tr><td>Dirección *</td><td><input type=\"Text\" name=\"direccion\" class=\"px150\"></td></tr>";
		echo "<tr><td>Población *</td><td><input type=\"Text\" name=\"poblacion\" class=\"px150\"></td></tr>";
		echo "<tr><td>Codigo Postal *</td><td><input type=\"Text\" name=\"cp\" class=\"px150\"></td></tr>";
		echo "<tr><td>Provincia *</td><td><input type=\"Text\" name=\"provincia\" class=\"px150\"></td></tr>";
		echo "<tr><td><strong>Datos bancarios</strong></td><td></td></tr>";
		echo "<tr><td>Cuenta bancaria</td><td><input type=\"Text\" name=\"cuentabancaria\" class=\"px300\"></td></tr>";
		echo "<tr><td><strong>Datos adicionales</strong></td><td></td></tr>";
		echo "<tr><td>E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\"></td></tr>";
		echo "<tr><td>Web</td><td><input type=\"Text\" name=\"web\" class=\"px150\"></td></tr>";
		echo "<tr><td>Telefono *</td><td><input type=\"Text\" name=\"telefono\" class=\"px150\"></td></tr>";
		echo "<tr><td><strong>Datos comerciales</strong></td><td></td></tr>";
		echo "<tr><td>Nombre contacto</td><td><input type=\"Text\" name=\"contacto_nombre\" class=\"px300\"></td></tr>";
		echo "<tr><td>Telefono contacto</td><td><input type=\"Text\" name=\"contacto_telefono\" class=\"px150\"></td></tr>";
		echo "<tr><td>Mail contacto</td><td><input type=\"Text\" name=\"contacto_mail\" class=\"px150\"></td></tr>";
		echo "<tr><td>Recibir propaganda</td><td>";
			echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\"checked>";
			echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\">";
		echo "</td></tr>";
		echo "<tr><td></td><td><input type=\"Submit\" value=\"Crear ficha cliente\" style=\"width:150px\"></td></tr>";
		echo "</form>";
		echo "</table>";
		echo "* - Campos obligatorios.";
	}

	if ($soption == 35) {
		if (($_POST["nombre"] == "") or ($_POST["nif"] == "") or ($_POST["direccion"] == "") or ($_POST["poblacion"] == "") or ($_POST["cp"] == "") or ($_POST["provincia"] == "") or ($_POST["telefono"] == "")) {
			echo "Debe rellenar todos los campos obligatorios (marcados con un \"<strong>*</strong>\").";
		}
		else {
			$sql = "insert into sgm_clients (nombre,nif,direccion,poblacion,cp,provincia,mail,web,telefono,cuentabancaria,contacto_nombre,contacto_telefono,contacto_mail,propaganda) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",'".$_POST["nif"]."'";
			$sql = $sql.",'".$_POST["direccion"]."'";
			$sql = $sql.",'".$_POST["poblacion"]."'";
			$sql = $sql.",'".$_POST["cp"]."'";
			$sql = $sql.",'".$_POST["provincia"]."'";
			$sql = $sql.",'".$_POST["mail"]."'";
			$sql = $sql.",'".$_POST["web"]."'";
			$sql = $sql.",'".$_POST["telefono"]."'";
			$sql = $sql.",'".$_POST["cuentabancaria"]."'";
			$sql = $sql.",'".$_POST["contacto_nombre"]."'";
			$sql = $sql.",'".$_POST["contacto_telefono"]."'";
			$sql = $sql.",'".$_POST["contacto_mail"]."'";
			$sql = $sql.",".$_POST["propaganda"]."";
			$sql = $sql.")";
			mysql_query($sql);

			$sql = "select * from sgm_clients where nombre='".$_POST["nombre"]."' and nif='".$_POST["nif"]."' and poblacion='".$_POST["poblacion"]."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			
			$sql = "insert into sgm_users_clients (id_client,id_user) ";
			$sql = $sql."values (";
			$sql = $sql."".$row["id"]."";
			$sql = $sql.",".$userid;
			$sql = $sql.")";
			mysql_query($sql);

			echo $sql."<br><br>Operación realizada correctamente.";
			echo "<br><br><a href=\"index.php?op=200&sop=30\">[ Volver ]</a>";
		}
	}

	if ($soption == 70) {
		echo "<br><strong>Formulario para cambiar la password (contraseña) de acceso:</strong><br>";
			echo "<br><form action=\"index.php?op=200&sop=71\" method=\"post\">";
			echo "<table>";
			echo "<tr><td><strong>*Contraseña.</strong><br>Máximo 10 caracteres.</td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass1\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr><td><strong>*Repetir contraseña.</strong><br>Máximo 10 caracteres.</td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"Cambiar\" class=\"px100\"></td>";
			echo "</tr></table>";
			echo "</form>";
	}

	if ($soption == 71) {
		if (($_POST["pass1"] == $_POST["pass2"]) AND ($_POST["pass1"] != "")) {
			$sql = "update sgm_users set ";
			$sql = $sql."pass='".$_POST["pass1"]."'";
			$sql = $sql." WHERE id=".$userid."";
			mysql_query($sql);
			echo "Operación realizada correctamente. Si no pudiera de nuevo hacer correctamente el login, borre las cookies referentes a multivia.com de su navegador.";
			echo "<br><br><a href=\"index.php?op=0&sop=666\">[ DESCONECTARSE ]</a>";
		}
		else { echo "<br><br>Error al introducir las passwords<br><br>"; }
	}

	if ($soption == 72) {

			echo "<form action=\"index.php?op=200&sop=73\" method=\"post\">";
			echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$rowuser["id"]."\">";
			echo "<center><table><tr><td></td><td style=\"width:300px;text-align:justify;\" class=\"gris\"><strong>FIRMA DE USUARIO :</strong><br><br>La firma se usa en el momento de mandar mensajes a los foros. Si el usuario selecciona SI a la firma, por defecto siempre se adjuntará al mensaje que se envie.<br><br></td></tr>";
			if ($rowuser["firma"] == 1) { echo "<tr><td>Firma predeterminada</td><td><input type=\"Radio\" name=\"firma\" value=\"1\" checked style=\"border : 0;\">Si<input type=\"Radio\" name=\"firma\" value=\"0\" style=\"border : 0;\">No</td></tr>"; 	}
			else { echo "<tr><td>Firma predetermina</td><td><input type=\"Radio\" name=\"firma\" value=\"1\" style=\"border : 0;\">Si<input type=\"Radio\" name=\"firma\" value=\"0\" style=\"border : 0;\" checked>No</td></tr>"; 	}
			echo "<tr><td>Firma (máx. 255 car.)</td><td><textarea name=\"textfirma\" class=\"px400\" rows=\"8\">".$rowuser["textfirma"]."</textarea></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Cambiar\" class=\"px100\"></td></tr>";
			echo "</table></center>";
			echo "</form>";
	}

	if ($soption == 73) {
		$sql = "update sgm_users set ";
		$sql = $sql."firma=".$_POST["firma"]."";
		$sql = $sql.",textfirma='".$_POST["textfirma"]."'";
		$sql = $sql." WHERE id=".$_POST["id_user"]."";
		mysql_query($sql);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=200\">[ Volver ]</a>";
	}


echo "</td></tr></table>";
}
}

?>
