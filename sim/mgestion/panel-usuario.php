<?php

if (($option == 200) and ($user == false)) {
	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";
} else {

	$sqluser = "select * from sgm_users WHERE id=".$userid;
	$resultuser = mysql_query(convertSQL($sqluser));
	$rowuser = mysql_fetch_array($resultuser);

	$sqluserclient = "select count(*) as total from sgm_users_clients WHERE id_user=".$userid;
	$resultuserclient = mysql_query(convertSQL($sqluserclient));
	$rowuserclient = mysql_fetch_array($resultuserclient);
	$nclientes = $rowuserclient["total"];

	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Panel_usuario."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
		#			echo "<td class=menu>";
		#				echo "<a href=\"index.php?op=200&sop=10&id=".$rowuser["id"]."\" style=\"color:white;\">Datos Usuario</a>";
		#			echo "</td>";
					echo "<td class=menu>";
						echo "<a href=\"index.php?op=200&sop=70&id=".$rowuser["id"]."\" style=\"color:white;\">".$Cambio." ".$Contrasena."</a>";
					echo "</td>";
#					$sqlp = "select count(*) as total from sgm_users_permisos_modulos WHERE id_modulo=1003 and visible=1";
#					$resultp = mysql_query(convertSQL($sqlp));
#					$rowp = mysql_fetch_array($resultp);
#					if ($rowp["total"] == 1) {
#						$sqlpe = "select * from sgm_users_permisos_modulos WHERE id_modulo=1003 and visible=1";
#						$resultpe = mysql_query(convertSQL($sqlpe));
#						$rowpe = mysql_fetch_array($resultpe);
#						$sqlp = "select * from sgm_users_permisos WHERE id_modulo=1003";
#						$resultp = mysql_query(convertSQL($sqlp));
#						while ($rowp = mysql_fetch_array($resultp)){
#							if ($rowp["id_user"] == $rowuser["id"]){
#										echo "<td class=menu>";
#											echo "<a href=\"index.php?op=200&sop=30&id=".$rowuser["id"]."\" style=\"color:white;\">".$rowpe["nombre"]."</a>";
#										echo "</td>";
#							}
#						}
#					}
#					$sqlp = "select count(*) as total from sgm_users_permisos_modulos WHERE id_modulo=1006 and visible=1";
#					$resultp = mysql_query(convertSQL($sqlp));
#					$rowp = mysql_fetch_array($resultp);
#					if ($rowp["total"] == 1) {
#						$sqlpe = "select * from sgm_users_permisos_modulos WHERE id_modulo=1006 and visible=1";
#						$resultpe = mysql_query(convertSQL($sqlpe));
#						$rowpe = mysql_fetch_array($resultpe);
#						$sqlp = "select * from sgm_users_permisos WHERE id_modulo=1006";
#						$resultp = mysql_query(convertSQL($sqlp));
#						while ($rowp = mysql_fetch_array($resultp)){
#							if ($rowp["id_user"] == $rowuser["id"]){
#								echo "<td class=menu>";
#									echo "<a href=\"index.php?op=200&sop=40&id=".$rowuser["id"]."\" style=\"color:white;\">".$rowpe["nombre"]."</a>";
#								echo "</td>";
#							}
#						}
#					}
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
#		echo "<tr><td></td><td><table cellpadding=\"1\" cellspacing=\"0\">";
#			echo "<tr style=\"background-color:silver\">";
#				echo "<td style=\"width:100px;text-align:left;\">".$Total."</td>";
#				$sqli = "select sum(duracion) as duracion_total from sgm_incidencias where visible=1 and id_incidencia<>0 and id_usuario_registro=".$userid."";
#				$resulti = mysql_query(convertSQL($sqli));
#				$rowi = mysql_fetch_array($resulti);
#				$hora = $rowi["duracion_total"]/60;
#				$horas = explode(".",$hora);
#				$minutos = $rowi["duracion_total"] % 60;
#
#				$fecha1 = strtotime('2013-05-01');
#				$fecha2 = time();
#				$x = 0;
#				for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){
#					$fest = comprobar_festivo($fecha1);
#					if ($fest == 0) {$x++;}
#				}
#				$total_total = $x*8;
#				echo "<td style=\"width:300px;text-align:left;\">".$horas[0]." ".$Horas." ".$minutos." ".$Minutos." / ".$total_total." ".$Horas." ".$Laborables."</td>";
#			echo "</tr>";
#		echo "</table></td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
	echo "</table><br>";
	echo "<table class=\"principal\"><tr><td>";

	if ($soption == 0) {
	}

	if ($soption == 5) {
		echo "<center>";
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
			$result = mysql_query(convertSQL($sql));
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
		echo "</center>";
	}

	if ($soption == 10) {
		echo "<center>";
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
			echo "</td></tr></table>";
		echo "</center>";
	}

	if ($soption == 11) {
		$sqlx = "select count(*) as total from sgm_users WHERE mail='".$_POST["mail"]."' AND id<>".$userid;
		$resultx = mysql_query(convertSQL($sqlx));
		$rowx = mysql_fetch_array($resultx);
		if ($rowx["total"] == 0) {
			$sql = "update sgm_users set mail='".$_POST["mail"]."',msn='".$_POST["msn"]."',icq='".$_POST["icq"]."',url='".$_POST["url"]."',dateborn='".$_POST["dateborn"]."',public=".$_POST["public"]." WHERE id=".$userid;
			mysql_query(convertSQL($sql));
		}
		else {
			echo "No se a podido actualizar los datos por que la dirección de correo mail ya esta en uso.";
		}
		echo "<br><br><a href=\"index.php?op=200&sop=10\">[ Volver ]</a>";
	}

	if ($soption == 20) {
		if ($nclientes == 0) {
			echo "<br><strong>Este usuario no esta relacionado con ningun cliente.</strong>";
			echo "<br><br>";
			echo "Si usted ya es cliente nuestro y simplemente desea que su usuario se relacione con una cuenta de cliente, envie un mail a <a href=\"mailto:administracion@multivia.com\">administracion@multivia.com</a> indicando su nombre de usuario o id.";
			echo "<br><br>";
			echo "Si por el contrario desea crear una cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
		} else {
			echo "<strong>Bienvenido al área de gestión de usuarios</strong>";
			echo "<br><br>";
			echo "Si desea crear una nueva cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
			echo "<br><br>";
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=200&sop=21&id_user=".$_GET["id"]."\" style=\"color:white;\">Gestión Usuarios</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:500px;\">";
		$sql = "select * from sgm_users where id_origen=".$_GET["id_user"];
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td><strong>".$row["usuario"]."</strong></td>";
			echo "</tr>";
			$sqlu = "select * from sgm_users_clients where id_user=".$row["id"];
			$resultu = mysql_query(convertSQL($sqlu));
			while ($rowu = mysql_fetch_array($resultu)) {
				echo "<tr>";
					$sqlc = "select * from sgm_clients where id=".$rowu["id_client"];
					$resultc = mysql_query(convertSQL($sqlc));
					$rowc = mysql_fetch_array($resultc);
					if ($client != $rowu["id_client"]) {
						echo "<td>".$rowc["nombre"]."</td>";
						$sqlp = "select * from sgm_users_permisos_modulos where visible=1 and id_modulo in ('1014','1006','1004','1003','1002')";
						$resultp = mysql_query(convertSQL($sqlp));
						while ($rowp = mysql_fetch_array($resultp)) {
							$sqlpm = "select count(*) as total from sgm_users_clients where id_modulo in ('".$rowp["id_modulo"]."','-1') and id_user=".$row["id"]." and id_client=".$rowu["id_client"];
							$resultpm = mysql_query(convertSQL($sqlpm));
							$rowpm = mysql_fetch_array($resultpm);
							if ($rowpm["total"] == 1) { $color = "#4B53AF"; $colorl = "white"; } else { $color = "silver"; $colorl = "black"; }
							echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black;color:".$colorl."\">".$rowp["nombre"]."</td><td>&nbsp;</td>";
						}
					echo "</tr>";
					$client = $rowu["id_client"];
					echo "<tr><td></td></tr>";
					}
			}
			echo "<tr><td></td></tr>";
			echo "<tr><td></td></tr>";
			busca_usuarios2($row["id"]);
			}			echo "</table>";
	}

#	if ($soption == 21) {
#		if ($ssoption == 1) {
#			echo "<center>";
#			$registro = 1;
#			$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."'";
#			$result = mysql_query(convertSQL($sql));
#			$row = mysql_fetch_array($result);
#			if ($row["total"] != 0) { echo "<br>Nombre de usuario ya registrado."; $registro = 0; }
#			if ($_POST["user"] == "") { echo "<br>Valor en el campo nombre de usuario incorrecto."; $registro = 0; }
#			$sql = "select Count(*) AS total from sgm_users WHERE mail='".$_POST["mail"]."'";
#			$result = mysql_query(convertSQL($sql));
#			$row = mysql_fetch_array($result);
#			if ($row["total"] != 0) { echo "<br>Direccion e-mail ya registrada."; $registro = 0; }
#			if (comprobar_mail($_POST["mail"]) == false) { echo "<br>Valor en el campo e-mail incorrecto."; $registro = 0; }
#			if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { echo "<br>Valor en los campos passwords incorrecto."; $registro = 0; }
#			if ($_POST["country"] == "xx") { echo "<br>Debes seleccionar un pais."; $registro = 0; }
#			if ($registro == 0 ) {
#				echo "<br><br><strong>Completa correctamente todos los campos obligatorios.</strong>";
#			}
#			if ($registro == 1 ) {
#				$sql = "insert into sgm_users (usuario,pass,mail,id_origen) ";
#				$sql = $sql."values (";
#				$sql = $sql."'".$_POST["user"]."'";
#				$sql = $sql.",'".$_POST["pass1"]."'";
#				$sql = $sql.",'".$_POST["mail"]."'";
#				$sql = $sql.",'".$_GET["id_user"]."'";
#				$sql = $sql.")";
#				mysql_query(convertSQL($sql));
#			}
#			echo "</center>";
#		}
#		if ($ssoption == 2) {
#			$registro = 1;
#			$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."'";
#			$result = mysql_query(convertSQL($sql));
#			$row = mysql_fetch_array($result);
#			if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { echo "<br>Valor en los campos passwords incorrecto."; $registro = 0; }
#			if ($registro == 1 ) {
#				$sql = "update sgm_users set ";
#				$sql = $sql."pass='".$_POST["pass1"]."'";
#				$sql = $sql." WHERE id=".$_GET["id"]."";
#				mysql_query(convertSQL($sql));
#			echo $sql;
#			}
#		}
#		if ($ssoption == 3) {
#			$sql = "update sgm_users set ";
#			$sql = $sql."activo=0";
#			$sql = $sql." WHERE id=".$_GET["id"]."";
#			mysql_query(convertSQL($sql));
#		}

#		echo "<center>";
#		echo "<table><tr><td style=\"vertical-align:top\">";
#			echo "<table><tr>";
#					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
#						echo "<a href=\"index.php?op=200&sop=21&id_user=".$_GET["id_user"]."\" style=\"color:white;\">Añadir Usuarios</a>";
#					echo "</td>";
#			echo "</tr></table>";
#		echo "<br><br><br>";
#		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
#			echo "<tr style=\"background-color: Silver;\">";
#				echo "<td style=\"text-align:center;width:20px;\"><em>Eliminar</em></td>";
#				echo "<td style=\"text-align:center;width:220px;\">Nombre</td>";
#				echo "<td style=\"text-align:center;width:20px;\"><em>Editar</em></td>";
#				echo "<td style=\"text-align:center;width:20px;\"><em>Permisos</em></td>";
#			echo "</tr>";
#			$sql = "select * from sgm_users where id_origen=".$_GET["id_user"];
#			$result = mysql_query(convertSQL($sql));
#			while ($row = mysql_fetch_array($result)) {
#				$color = "black";
#				if ($row["id"] == $_GET["id"]){
#					echo "<tr style=\"background-color:#4B53AF;\">";
#					$color = "white";
#				} else {
#					echo "<tr>";
#				}
#						echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=22&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
#						echo "<td style=\"color:".$color.";width:220px;\">".$row["usuario"]."</td>";
#						echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=21&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
#						$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$row["id"];
#						$resultt = mysql_query(convertSQL($sqlt));
#						$rowt = mysql_fetch_array($resultt);
#						if ($rowt["total"] > 0) {
#							echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=23&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/application_key.png\" style=\"border:0px;\"></a></td>";
#						} else {
#							echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=23&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/application.png\" style=\"border:0px;\"></a></td>";
#						}
#						busca_usuarios($row["id"],($x+10));
#					echo "</tr>";
#			}
#		echo "</table>";

#	echo "</td>";
#	echo "<td style=\"width:70px\">&nbsp;";
#	echo "</td><td style=\"vertical-align:top;\">";
#	if ($_GET["id"] == "") {
#			echo "<strong>Añadir Nuevo Usuario</strong>";
#		} else {
#			echo "<strong>Modificar Usuario</strong>";
#		}
#		echo "<br><br>";
#		echo "<center>";
#		echo "<table>";
#			echo "<tr>";
#			echo "<td></td>";
#			$sql = "select * from sgm_users where id=".$_GET["id"];
#			$result = mysql_query(convertSQL($sql));
#			$row = mysql_fetch_array($result);
#			if ($_GET["id"] == "") {
#				echo "<form action=\"index.php?op=200&sop=21&ssop=1&id_user=".$_GET["id_user"]."\" method=\"post\">";
#				echo "<tr><td><strong>*Nombre de usuario.</strong></td><td style=\"vertical-align : middle;\"><input type=\"Text\" name=\"user\" class=\"px100\" value=\"".$row["usuario"]."\">*</td></tr>";
#				echo "<tr><td><strong>*Dirección e-mail.</strong></td><td style=\"vertical-align : middle;\"><input type=\"pass\" name=\"mail\" class=\"px200\" value=\"".$row["mail"]."\">*</td></tr>";
#			} else {
#				echo "<form action=\"index.php?op=200&sop=21&ssop=2&id=".$_GET["id"]."&id_user=".$_GET["id_user"]."\" method=\"post\">";
#			}
#			echo "</tr>";
#			echo "<tr><td><strong>*Contraseña.</strong><br>Máximo 10 caracteres.</td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass1\" class=\"px100\" maxlength=\"10\">*</td></tr>";
#			echo "<tr><td><strong>*Repetir contraseña.</strong><br>Máximo 10 caracteres.</td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" class=\"px100\" maxlength=\"10\">*</td></tr>";
#			echo "<tr>";
#				echo "<td>";
#					if ($_GET["id"] == "") {
#						echo "<input type=\"submit\" value=\"Añadir\" style=\"width:100px\">";
#					}else{
#						echo "<input type=\"submit\" value=\"Modificar\" style=\"width:100px\">";
#					}
#				echo "</td>";
#			echo "</tr>";
#			echo "</form>";
#			echo "<tr><td>* Campos obligatorios.</td><tr>";
#		echo "</table>";
#		echo "</center>";

#	echo "</td></tr></table>";
#	echo "</center>";
#	}

	if ($soption == 22) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea invalidar este usuario?";
		echo "<br><br><a href=\"index.php?op=200&sop=21&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=200&sop=21\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 23) {
		$sql = "select * from sgm_users where id=".$_GET["id"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>Permisos de Usuario: </strong> ".$row["usuario"]."<br>";
		echo boton_volver($Volver);
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		$sqlc = "select * from sgm_users_clients where id_user=".$_GET["id_user"];
		$resultc = mysql_query(convertSQL($sqlc));
		while ($rowc = mysql_fetch_array($resultc)) {
			$sqlcl = "select * from sgm_clients where id=".$rowc["id_client"];
			$resultcl = mysql_query(convertSQL($sqlcl));
			$rowcl = mysql_fetch_array($resultcl);
			echo "<tr><td><strong>".$rowcl["nombre"]."</strong></td></tr>";
			echo "<tr><td></td><td><strong>Acceso</strong></td><td></td><td><strong>Módulo</strong></td></tr>";
			$sql = "select * from sgm_users_permisos_modulos where visible=1 and id_modulo in ('1014','1006','1004','1003','1002')";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$_GET["id"]." and id_client=".$rowc["id_client"]." and id_modulo=".$row["id_modulo"];
				$resultt = mysql_query(convertSQL($sqlt));
				$rowt = mysql_fetch_array($resultt);
				$sqlto = "select count(*) as total from sgm_users_clients where id_user=".$_GET["id_user"]." and id_client=".$rowc["id_client"]." and id_modulo in ('".$row["id_modulo"]."','-1')";
				$resultto = mysql_query(convertSQL($sqlto));
				$rowto = mysql_fetch_array($resultto);
				echo "<tr>";
					echo "<form action=\"index.php?op=200&sop=24&id_user=".$_GET["id_user"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$_GET["id"]."\">";
					echo "<input type=\"Hidden\" name=\"id_client\" value=\"".$rowc["id_client"]."\">";
					echo "<input type=\"Hidden\" name=\"id_modulo\" value=\"".$row["id_modulo"]."\">";
					$sqlm = "select count(*) as total from sgm_users_clients where id_user=".$_GET["id"]." and id_client=".$rowc["id_client"]." and id_modulo='-1'";
					$resultm = mysql_query(convertSQL($sqlm));
					$rowm = mysql_fetch_array($resultm);
					if ($rowm["total"] == 0) {
						if ($rowto["total"] == 0){
							echo "<td><select name=\"permiso\" style=\"width:40px\" disabled>";
								echo "<option value=\"0\" selected>NO</option>";
						} else {
							echo "<td><select name=\"permiso\" style=\"width:40px\">";
							if ($rowt["total"] == 1) {
								echo "<option value=\"1\" selected>SI</option>";
								echo "<option value=\"0\">NO</option>";
							}
							if ($rowt["total"] == 0) {
								echo "<option value=\"1\">SI</option>";
								echo "<option value=\"0\" selected>NO</option>";
							}
						}
					} else {
						echo "<td><select name=\"permiso\" style=\"width:40px\" disabled>";
							echo "<option value=\"1\" selected>SI</option>";
					}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"Cambiar\"></td>";
					echo "</form>";
					echo "<td><strong>".$row["nombre"]."</strong></td>";
					echo "<td><em>(".$row["descripcion"].")</em></td>";
				echo "</tr>";
			}
			$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$_GET["id"]." and id_client=".$rowc["id_client"]." and id_modulo='-1'";
			$resultt = mysql_query(convertSQL($sqlt));
			$rowt = mysql_fetch_array($resultt);
			$sqlto = "select count(*) as total from sgm_users_clients where id_user=".$_GET["id_user"]." and id_client=".$rowc["id_client"]." and id_modulo='-1'";
			$resultto = mysql_query(convertSQL($sqlto));
			$rowto = mysql_fetch_array($resultto);
			$sqlm = "select * from sgm_users_clients where id_user=".$_GET["id"]." and id_client=".$rowc["id_client"];
			$resultm = mysql_query(convertSQL($sqlm));
			$rowm = mysql_fetch_array($resultm);
			echo "<tr>";
				echo "<form action=\"index.php?op=200&sop=24&id_user=".$_GET["id_user"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$_GET["id"]."\">";
				echo "<input type=\"Hidden\" name=\"id_client\" value=\"".$rowc["id_client"]."\">";
				echo "<input type=\"Hidden\" name=\"id_modulo\" value=\"-1\">";
				if ($rowto["total"] == 0) {
					echo "<td><select name=\"permiso\" style=\"width:40px\" disabled>";
						echo "<option value=\"0\" selected>NO</option>";
				} else {
					echo "<td><select name=\"permiso\" style=\"width:40px\">";
					if ($rowt["total"] == 1) {
						echo "<option value=\"1\" selected>SI</option>";
						echo "<option value=\"0\">NO</option>";
					}
					if ($rowt["total"] == 0) {
						echo "<option value=\"1\">SI</option>";
						echo "<option value=\"0\" selected>NO</option>";
					}
				}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Cambiar\"></td>";
				echo "</form>";
				echo "<td><strong>Todos</strong></td>";
				echo "<td><em>(Permiso para todos los módulos)</em></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 24) {
		if ($_POST["permiso"] == 0) {
			$sql = "delete from sgm_users_clients WHERE id_user=".$_POST["id_user"]." and id_client=".$_POST["id_client"]." and id_modulo=".$_POST["id_modulo"];
			mysql_query(convertSQL($sql));
		}
		if ($_POST["permiso"] == 1) {
			$sql = "insert into sgm_users_clients (id_user,id_client,id_modulo) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["id_user"]."";
			$sql = $sql.",".$_POST["id_client"]."";
			$sql = $sql.",".$_POST["id_modulo"]."";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=200&sop=23&id=".$_POST["id_user"]."&id_user=".$_GET["id_user"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 30) {
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
		$sqltipos = "select * from sgm_factura_tipos where ((id=1) OR (id=2)) order by id";
		$resulttipos = mysql_query(convertSQL($sqltipos));
		while ($rowtipos = mysql_fetch_array($resulttipos)) {
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td></td><td></td><td><strong>".$rowtipos["tipo"]."</strong></td><td></td><td></td></tr>";
			echo "<tr style=\"background-color:silver\"><td style=\"width:70px\"><em><center>Número</center></em></td><td style=\"width:85px\"><em><center>Fecha</center></em></td><td style=\"width:250px\"><em>Cliente</em></td><td style=\"text-align:right;\"><em>Total</em>&nbsp;&nbsp;</td><td></td><td>&nbsp;&nbsp;<em>Estado</em></td></tr>";
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." AND id_user=".$userid." order by numero desc,fecha desc";
			$result = mysql_query(convertSQL($sql));
			$fechahoy = getdate();
			while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
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
						echo "<td>".$row["nombre"]."</td>";
						echo "<td style=\"text-align : right;\"><strong>".$row["total"]." €</strong> </td>";
						echo "<td>&nbsp;&nbsp;<a href=\"mgestion/gestion-facturas-print.php?id=".$row["id"]."\" target=\"_blank\">[Visualizar]</a></td>";
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
		echo "</center>";
	}

	if ($soption == 36) {
		$autorizado = 0;
		$sql = "select count(*) as total from sgm_users_clients WHERE (id_client=".$_GET["id"].") AND (id_user=".$userid.")";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$autorizado = $row["total"];
	
		if ($autorizado == 0) {
			echo "<br><strong>Este usuario no autorizado con el cliente seleccionado.</strong><br><br>";
		}
		else {
		$sqltipos = "select * from sgm_factura_tipos where id=5 order by id";
		$resulttipos = mysql_query(convertSQL($sqltipos));
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
		while ($rowtipos = mysql_fetch_array($resulttipos)) {
			echo "<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td><strong>".$rowtipos["tipo"]."</strong></td><td></td><td></td></tr>";
			echo "<tr><td></td><td style=\"width:70px\"><em><center>Número</center></em></td><td><em><center>Ref. Cliente</center></em></td><td style=\"width:85px\"><em><center>Fecha</center></em></td><td><em>Cliente</em></td><td style=\"text-align:right;\"></td><td></td></tr>";
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." AND id_cliente=".$_GET["id"]." order by numero desc,fecha desc";
			$result = mysql_query(convertSQL($sql));
			$fechahoy = getdate();
			while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td><img src=\"pics/flexa.gif\" border=\"0\"></td>";
						echo "<td><center>".$row["numero"]."</center></td>";
						echo "<td><center><strong>".$row["numero_cliente"]."</strong></center></td>";
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
						echo "<td>".$row["nombre"]."</td>";
						echo "<td>&nbsp;&nbsp;<a href=\"index.php?op=200&sop=37&id=".$row["id"]."\" class=\"gris\">[ Detalles ]</a></td>";
					echo "</tr>";
			}
		}
		echo "</table>";
		echo "</center>";
	}
	}

	if ($soption == 37) {
		$autorizado = false;
		if ($user == true) {
				$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
				$resultcabezera = mysql_query(convertSQL($sqlcabezera));
				$rowcabezera = mysql_fetch_array($resultcabezera);
				$sql = "update sgm_cabezera set ";
				$sql = $sql."print=".($rowcabezera["print"]+1);
				$sql = $sql." WHERE id=".$rowcabezera["id"]."";
				mysql_query(convertSQL($sql));
				$sqlsgm = "select * from sgm_users where id=".$userid;
				$resultsgm = mysql_query(convertSQL($sqlsgm));
				$rowsgm = mysql_fetch_array($resultsgm);
				if ($rowsgm["sgm"] == 1) { $autorizado = true; }
				$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
				$resultpermiso = mysql_query(convertSQL($sqlpermiso));
				$rowpermiso = mysql_fetch_array($resultpermiso);
				if ($rowpermiso["total"] >= 1) { $autorizado = true; }
		}
		if ($autorizado == false) {
			echo "<br><strong>Este usuario no autorizado con el cliente seleccionado.</strong><br><br>";
		}
		else {

		$sql = "select * from sgm_cabezera where id=".$_GET["id"]." ORDER BY id";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		echo "<center>";
		echo "<table><tr><td style=\"width:400px;vertical-align:top;\">";
				echo "<table>";
				echo "<tr><td><strong>Número Pedido</strong></td><td>".$row["numero"]."</td></tr>";
				echo "<tr><td><strong>Ref. Cliente</strong></td><td>".$row["numero_cliente"]."</td></tr>";
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
		echo "</td><td style=\"width:200px;vertical-align:top;\">";
		echo "</td></tr></table>";

		echo "<br><br>";
		echo "<table cellspacing=\"0\">";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
		$result = mysql_query(convertSQL($sql));
		$x = 1;

		echo "<tr><td></td><td></td><td><em>Fecha Prevision</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td></td><td></td><td><center>M</center></td><td><center>A</center></td></tr>";
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
					echo "<select style=\"background-color : ".$rowes["color"].";width:125px\" name=\"id_estado".$x."\" disabled>";
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
#				echo "<td><a href=\"index.php?op=1014&sop=1&id=".$row["id"]."\"><strong>[Producción]</strong></a></td>";
#				echo "<td><a href=\"index.php?op=1014&sop=11&id=".$row["id"]."\"><strong>[OT]</strong></a></td>";
					$sqlxx = "select count(*) as total from sgm_cuerpo where id_cuerpo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
#				echo "<td><a href=\"index.php?op=1014&sop=60&id=".$row["id"]."\"><strong>[".$rowxx["total"]."]</strong></a></td>";
					$sqlxx = "select count(*) as total from sgm_cuerpo_archivos where id_cuerpo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
#				echo "<td><a href=\"index.php?op=1014&sop=50&id=".$row["id"]."\"><strong>[".$rowxx["total"]."]</strong></a></td>";
		echo "</tr>";
		$x++;
		}
		echo "<tr><td></td><td></td><td><em>Fecha Prevision</em></td><td><em>Código</em></td><td><em>Nombre</em></td><td><em>Unidades</em></td><td></td><td></td><td><center>M</center></td><td><center>A</center></td></tr>";
		echo "</form>";
		echo "</table>";
		echo "</center>";
		}

	}
	if ($soption == 38) {
		if ($nclientes == 0) {
			echo "<br><strong>Este usuario no esta relacionado con ningun cliente.</strong>";
			echo "<br><br>";
			echo "Si usted ya es cliente nuestro y simplemente desea que su usuario se relacione con una cuenta de cliente, envie un mail a <a href=\"mailto:administracion@multivia.com\">administracion@multivia.com</a> indicando su nombre de usuario o id.";
			echo "<br><br>";
			echo "Si por el contrario desea crear una cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
		}
		else {
			echo "<strong>Bienvenido al área de consulta de producción</strong>";
			echo "<br><br>";
			echo "Si desea crear una nueva cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
			$sql = "select * from sgm_users_clients WHERE id_user=".$userid;
			$result = mysql_query(convertSQL($sql));
			echo "<br><center><table><tr><td style=\"width:150px;\"><strong>Empresa</strong></td><td></td><td></td></tr>";
			while ($row = mysql_fetch_array($result)) {
				$sql1 = "select * from sgm_clients WHERE id=".$row["id_client"];
				$result1 = mysql_query(convertSQL($sql1));
				$row1 = mysql_fetch_array($result1);
				echo "<tr>";
				echo "<td>".$row1["nombre"]."</td>";
#				echo "<td><a href=\"index.php?op=200&sop=32&id=".$row1["id"]."\" class=\"gris\">[ Datos Facturación ]</a></td>";
				echo "<td><a href=\"index.php?op=200&sop=36&id=".$row1["id"]."\" class=\"gris\">[ Ver Pedidos ]</a></td>";
#				echo "<td><a href=\"index.php?op=200&sop=31&id=".$row1["id"]."\" class=\"gris\">[ Ver Facturas ]</a></td>";
				echo "</tr>";
			}
			echo "</table></center><br><br>";
		}
	}

	if ($soption == 39) {
		if ($nclientes == 0) {
			echo "<br><strong>Este usuario no esta relacionado con ningun cliente.</strong>";
			echo "<br><br>";
			echo "Si usted ya es cliente nuestro y simplemente desea que su usuario se relacione con una cuenta de cliente, envie un mail a <a href=\"mailto:administracion@multivia.com\">administracion@multivia.com</a> indicando su nombre de usuario o id.";
			echo "<br><br>";
			echo "Si por el contrario desea crear una cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.";
		}
		else {
			echo "<strong>Bienvenido al área consulta de stock de artículos</strong>";
			echo "<br><br>";
			echo "Si desea crear una nueva cuenta de cliente haga <a href=\"index.php?op=200&sop=34\">click aquí</a>.<br>";
			$sql = "select * from sgm_users_clients WHERE id_user=".$userid;
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				$sql1 = "select * from sgm_clients WHERE id=".$row["id_client"];
				$result1 = mysql_query(convertSQL($sql1));
				$row1 = mysql_fetch_array($result1);
				echo "<br><center><table><tr><td style=\"text-align:right;\"><em>Código</em></td><td style=\"text-align:right;\">Ref. Cliente</td><td style=\"width:150px;\">&nbsp;<strong>Empresa : ".$row1["nombre"]."</strong></td><td style=\"text-align:right;\"><em>Stock</em></td></tr>";
					$sqlxx = "select * from sgm_articles_rel_clientes WHERE id_cliente=".$row1["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					while ($rowxx = mysql_fetch_array($resultxx)) {
						$sql11 = "select * from sgm_articles WHERE id=".$rowxx["id_articulo"];
						$result11 = mysql_query(convertSQL($sql11));
						$row11 = mysql_fetch_array($result11);
						echo "<tr>";
							echo "<td style=\"text-align:right;width:100px\">".$row11["codigo"]."</td>";
							echo "<td style=\"text-align:right;width:100px\">".$row11["codigo2"]."</td>";
							echo "<td style=\"text-align:left;width:300px\">&nbsp;".$row11["nombre"]."</td>";
								$sqls = "select sum(unidades) as total from sgm_stock where id_article=".$rowxx["id_articulo"];
								$results = mysql_query(convertSQL($sqls));
								$rows = mysql_fetch_array($results);
							echo "<td style=\"text-align:right;width:100px\"><strong>".$rows["total"]."</strong></td>";
						echo "</tr>";
					}
				echo "</table></center><br><br>";
			}
		}
	}

	if ($soption == 40) {
		echo "<table><tr>";
			echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1006&sop=20&inc=0&usuario=".$userid."\" style=\"color:white;\">".$Nueva." ".$Incidencia."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:1000px\">";
		echo "<tr><td></td><td></td><td><strong>".$Tareas." ".$Pendientes."</strong></td></tr>";
		echo "<tr style=\"background-color:silver\">";
			echo "<td><em>Estado</em></td>";
			echo "<td style=\"text-align:center;width:200px\">Fecha Prevision</td>";
			echo "<td style=\"text-align:center\">Notas de registro</td>";
		echo "</tr>";
		$sql = "select * from sgm_incidencias WHERE id_usuario=".$userid." AND id_estado <> -2 order by data_prevision";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				$sqlx = "select * from sgm_incidencias_estados WHERE id=".$row["id_estado"];
				$resultx = mysql_query(convertSQL($sqlx));
				$rowx = mysql_fetch_array($resultx);
				$estado = $rowx["estado"];
				if ($row["id_estado"] == -1) { $estado = "Registrada";}
				echo "<td>".$estado."</td>";
				echo "<td><strong>".$row["data_prevision"]."</strong></td>";
				echo "<td><a href=\"index.php?op=1006&sop=20&id=".$row["id"]."&inc=0&usuario=".$userid."\">";
					if (strlen($row["notas_registro"]) > 100) { echo substr($row["notas_registro"],0,100)." ..."; }
						else { echo $row["notas_registro"]; }
				echo "</a></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 42) {
		$autorizado = 0;
		$sql = "select count(*) as total from sgm_users_clients WHERE (id_client=".$_GET["id"].") AND (id_user=".$userid.")";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$autorizado = $row["total"];
		if ($autorizado == 0) {
			echo "<br><strong>Este usuario no autorizado con el cliente seleccionado.</strong><br><br>";
		}
		else {
			echo "<strong>Plantillas del Cliente</strong>";
			echo "<br><br><a href=\"index.php?op=200&sop=40\"><img src=\"mgestion/pics/icons-mini/arrow_left.png\" style=\"border:0px\"></a><br>Volver<br>";
			echo "<center>";
			echo "<table cellspacing=\"0\" style=\"width:400px\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>Id</em></td>";
				echo "<td style=\"text-align:center\">Plantilla</td>";
				echo "<td style=\"text-align:center\">Descripción</td>";
				echo "<td style=\"text-align:center\"><em>Imprimir</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_ft WHERE id_client=".$_GET["id"]."";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					$sqlx = "select * from sgm_ft_plantilla WHERE id=".$row["id_plantilla"];
					$resultx = mysql_query(convertSQL($sqlx));
					$rowx = mysql_fetch_array($resultx);
					echo "<td>".$rowx["id"]."</td>";
					echo "<td>".$rowx["plantilla"]."</td>";
					echo "<td>".$rowx["descripcion"]."</td>";
					echo "<td style=\"text-align:center\"><a href=\"mgestion/gestion-produccion-ft-print.php?id=".$_GET["id"]."&id_ft=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</center>";
		}
	}

	if ($soption == 70) {
		echo "<h4>".$Cambio." ".$Contrasena."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=200&sop=71\" method=\"post\">";
			echo "<tr><th>".$Contrasena."</th><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass1\" style=\"width:100px\" maxlength=\"10\" placeholder=\"".$ayudaPanelUserPass."\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" style=\"width:100px\" maxlength=\"10\" placeholder=\"".$ayudaPanelUserPass."\"></td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"".$Modificar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 71) {
		if (($_POST["pass1"] == $_POST["pass2"]) AND ($_POST["pass1"] != "")) {
			$contrasena = crypt($_POST["pass1"]);
			$sql = "update sgm_users set ";
			$sql = $sql."pass='".$contrasena."'";
			$sql = $sql." WHERE id=".$userid."";
			mysql_query(convertSQL($sql));
			echo "<center>";
			echo "<br><br>".$ayudaPanelUserPass2;
			echo boton(array("op=0&sop=666"),array($Salir));
			echo "</center>";
		} else { echo mensageError($errorPanelUserPass); }
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
		mysql_query(convertSQL($sql));
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=200\">[ Volver ]</a>";
	}


echo "</td></tr></table><br>";
}





function busca_usuarios($id,$x)
{ 
	global $db;
			$sql = "select * from sgm_users where id_origen=".$id;
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=200&sop=21&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td style=\"padding-left: ".$x."px;color:".$color.";width:120;\">".$row["usuario"]."</td>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=200&sop=21&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
						$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$row["id"];
						$resultt = mysql_query(convertSQL($sqlt));
						$rowt = mysql_fetch_array($resultt);
						if ($rowt["total"] > 0) {
							echo "<td style=\"text-align:center\"><a href=\"index.php?op=200&sop=23&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/application_key.png\" style=\"border:0px;\"></a></td>";
						} else {
							echo "<td style=\"text-align:center\"><a href=\"index.php?op=200&sop=23&id=".$row["id"]."&id_user=".$_GET["id_user"]."\"><img src=\"mgestion/pics/icons-mini/application.png\" style=\"border:0px;\"></a></td>";
						}
				echo "</tr>";
				busca_usuarios($row["id"],($x+10));
			}
}

function busca_usuarios2($id)
{ 
	global $db;
		$sql = "select * from sgm_users where id_origen=".$id;
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td><strong>".$row["usuario"]."</strong></td>";
			echo "</tr>";
			$sqlu = "select * from sgm_users_clients where id_user=".$row["id"];
			$resultu = mysql_query(convertSQL($sqlu));
			while ($rowu = mysql_fetch_array($resultu)) {
				echo "<tr>";
					$sqlc = "select * from sgm_clients where id=".$rowu["id_client"];
					$resultc = mysql_query(convertSQL($sqlc));
					$rowc = mysql_fetch_array($resultc);
					if ($client != $rowu["id_client"]) {
						echo "<td>".$rowc["nombre"]."</td>";
						$sqlp = "select * from sgm_users_permisos_modulos where visible=1 and id_modulo in ('1014','1006','1004','1003','1002')";
						$resultp = mysql_query(convertSQL($sqlp));
						while ($rowp = mysql_fetch_array($resultp)) {
							$sqlpm = "select count(*) as total from sgm_users_clients where id_modulo in ('".$rowp["id_modulo"]."','-1') and id_client=".$rowu["id_client"];
							$resultpm = mysql_query(convertSQL($sqlpm));
							$rowpm = mysql_fetch_array($resultpm);
							if ($rowpm["total"] == 1) { $color = "#4B53AF"; $colorl = "white"; } else { $color = "silver"; $colorl = "black"; }
							echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black;color:".$colorl."\">".$rowp["nombre"]."</td><td>&nbsp;</td>";
						}
					echo "</tr>";
					$client = $rowu["id_client"];
					echo "<tr><td></td></tr>";
					}
			}
			echo "<tr><td></td></tr>";
			echo "<tr><td></td></tr>";
			busca_usuarios2($row["id"]);
			}

}

function comprobar_festivo($fecha)
{
	global $db;
	$festivo=0;
#Extreiem l'hora a la que acabaria la peça
	$dia_sem = date("w", ($fecha));
	if ($dia_sem == 0){
		$festivo=1;
	}
	if ($dia_sem == 6){
		$festivo=1;
	}
	$sqlc = "select * from sgm_calendario where dia=".date("j", ($fecha))." and mes=".date("n", ($fecha))."";
	$resultc = mysql_query(convertSQL($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc){
		$festivo=1;
	}
	return $festivo;
}

?>
