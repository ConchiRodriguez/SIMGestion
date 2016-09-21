<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1020) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$RRHH."</h4>";
		echo "</td><td style=\"width:92%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($soption == 0) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=0\" class=".$class.">".$Empleados."</a></td>";
				if ($_GET["id"] > 0){$variable = $Editar;} else {$variable = $Anadir;}
				if ($soption == 100) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=100\" class=".$class.">".$variable." ".$Empleados."</a></td>";
				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=200\" class=".$class.">".$Buscar." ".$Empleados."</a></td>";
				if ($soption == 300) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=300\" class=".$class.">".$Organigrama."</a></td>";
				if (($soption >= 500) and ($soption <= 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=500\" class=".$class.">".$Administrar."</a></td>";
			echo "</tr></table></center>";
			echo "<center><table><tr>";
			echo "</tr></table></center>";
	echo "</table><br>";
	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 3) {
			mysqli_query($dbhandle,convertSQL($sql));
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_empleado",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($soption == 0) { echo "<h4>".$Actual."</h4>";}
		if ($soption == 1) { echo "<h4>".$Historico."</h4>";}
		if ($soption == 200) { echo "<h4>".$Buscador."</h4>";}
		if ($soption != 200){
			echo "<table><tr>";
				echo "<td>";
					if ($soption == 1) { echo boton(array("op=1020&sop=0"),array($Activo));}
					if ($soption == 0) { echo boton(array("op=1020&sop=1"),array($Inactivo));}
				echo "</td>";
			echo "</tr></table>";
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			if ($soption == 200){
				echo "<form action=\"index.php?op=1020&sop=200&filtro=1\" method=\"post\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<th>".$Departamento."</th>";
					echo "<th>".$Puestos_trabajo."</th>";
					echo "<th>".$Cliente."</th>";
				echo "</tr>";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td><select style=\"width:250px\" name=\"id_departamento\">";
						echo "<option value=\"0\">-</option>";
							$sqlt = "select id,departamento from sgm_rrhh_departamento where visible=1 order by departamento";
							$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
							while ($rowt = mysqli_fetch_array($resultt)){
								if ($_POST["id_departamento"] == $rowt["id"]) {
									echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["departamento"]."</option>";
								} else {
									echo "<option value=\"".$rowt["id"]."\">".$rowt["departamento"]."</option>";
								}
							}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_puesto\">";
						echo "<option value=\"0\">-</option>";
							$sqlg = "select id,puesto from sgm_rrhh_puesto_trabajo where visible=1 and activo=1";
							$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
							while ($rowg = mysqli_fetch_array($resultg)){
								if ($_POST["id_puesto"] == $rowg["id"]) {
									echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["puesto"]."</option>";
								} else {
									echo "<option value=\"".$rowg["id"]."\">".$rowg["puesto"]."</option>";
								}
							}
					echo "</select></td>";
					echo "<td><select style=\"width:500px\" name=\"id_cliente\">";
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
					echo "</select></td>";
				echo "</tr>";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td colspan=\"3\">";
						echo "<table cellpadding=\"0\" cellspacing=\"1\" class=\"lista\">";
							echo "<tr>";
							echo "<th style=\"color:black;text-align: right;\">".$Inicial."</th>";
								for ($i = 0; $i <= 127; $i++) {
									if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
										echo "<td style=\"color:black;text-align: center;\">".chr($i)."</td>";
									}
								}
							echo "</tr>";
							echo "<tr>";
								echo "<th></th>";
								for ($i = 0; $i <= 127; $i++) {
									if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
										echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"".chr($i)."\"";
										if ($_POST[chr($i)] == true) { echo " checked"; }
										echo " value=\"true\" style=\"border:0px\"></td>";
									}
								}
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td colspan=\"3\" style=\"text-align:center;\"><input type=\"submit\" value=\"".$Buscar."\" style=\"width:550px\"></td>";
				echo "</form>";
				echo "</tr>";
			} else {
				echo "<tr>";
					echo "<td>";
					for ($i = 0; $i <= 127; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							$sqlxt = "select count(*) as total from sgm_rrhh_empleado where visible=1 and nombre like '".chr($i)."%'  order by nombre";
							$resultxt = mysqli_query($dbhandle,convertSQL($sqlxt));
							$rowxt = mysqli_fetch_array($resultxt);
							if ($rowxt["total"] > 0) {
								echo "<a href=\"#".chr($i)."\"  name=\"indice\"><strong>".chr($i)."</strong></a>&nbsp;";
							} else {
								echo "<font style=\"color:silver;\">".chr($i)."</font>&nbsp;";
							}
						}
					}
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		if (($soption != 200) or ($_GET["filtro"] > 0)){
			echo "<br><br>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$ver_todas_letras = true;
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
					if ($_POST[chr($i)] == true) {
						$ver_todas_letras = false;
					}
				}
			}
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
					if ($ver_todas_letras == false) {
						if ($_POST[chr($i)] != true) {
							$ver = false;
						}	else {
							$ver = true;
						}
					} else {
						$ver = true;
					}
					if ($ver == true){
						$contador = 0;
						$cambio = 0;
						$sql = "select * from sgm_rrhh_empleado where visible=1 and nombre like '".chr($i)."%'";
						if (($_POST["id_departamento"] > 0) or ($_POST["id_puesto"] > 0)) {
							$sql .= " and id in (";
							$sql .= "select id_empleado from sgm_rrhh_empleado_puesto where visible=1 ";
							if ($_POST["id_puesto"] > 0) { $sql .= " and id_puesto=".$_POST["id_puesto"]; }
							elseif ($_POST["id_departamento"] > 0) { $sql .= " and id_puesto in (select id from sgm_rrhh_puesto_trabajo where id_departamento=".$_POST["id_departamento"].")"; }
							$sql .= ")";
						}
						if ($_POST["id_cliente"] > 0) { $sql .= " and id_usuario in (select id_user from sgm_users_clients where id_client=".$_POST["id_cliente"].")"; }
#						echo $sql;
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($contador==0){
								echo "<tr style=\"background-color: Silver;\">";
									echo "<th></th>";
									echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\">".chr($i)."</a></th>";
									echo "<th>".$Nombre."</th>";
									echo "<th style=\"width:150px;\">".$Puesto_trabajo."</th>";
									echo "<th>".$Departamento."</th>";
									echo "<th></th>";
								echo "</tr>";
								$contador++;
							}
							if ($cambio == 0) { $color = "white"; $cambio = 1; } else { $color = "#F5F5F5"; $cambio = 0; }
							echo "<tr style=\"background-color:".$color."\">";
								echo "<td style=\"vertical-align:top\"><a href=\"index.php?op=1020&sop=0&ssop=3&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
								if ((valida_nif_cif_nie($row["nif"]) <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
									echo "<td style=\"vertical-align:top\"><img src=\"mgestion/pics/icons-mini/page_white_error.png\" alt=\"ERROR\" border=\"0\"></td>";
								} else { 
									echo "<td></td>"; 
								}
								echo "<td style=\"width:300px;vertical-align:top\">".$row["nombre"]."</td>";
								echo "<td colspan=\"2\"><table>";
								$sqlp = "select id_departamento,puesto from sgm_rrhh_puesto_trabajo where visible=1 and id in (select id_puesto from sgm_rrhh_empleado_puesto where visible=1 and id_empleado=".$row["id"].")";
								$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
								while ($rowp = mysqli_fetch_array($resultp)){
									$sqld = "select departamento from sgm_rrhh_departamento where visible=1 and id=".$rowp["id_departamento"];
									$resultd = mysqli_query($dbhandle,convertSQL($sqld));
									$rowd = mysqli_fetch_array($resultd);
									echo "<tr><td style=\"width:150px;\">".$rowp["puesto"]."</td><td>".$rowd["departamento"]."</td></tr>";
								}
								echo "</table></td>";
								echo "<form action=\"index.php?op=1020&sop=100&id=".$row["id"]."\" method=\"post\">";
								echo "<td style=\"vertical-align:top\" class=\"submit\"><input type=\"submit\" value=\"".$Editar."\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					}
				}
			}
			echo "</table>";
		}
	}

	if (($soption >= 100) and ($soption < 200) and  (($_GET["id"] != 0) or ($ssoption == 1))) {
		if (($soption == 100) and ($ssoption == 1)) {
			$camposInsert="num_ins_segsoc,num_afil_segsoc,id_usuario,entidadbancaria,domiciliobancario,cuentabancaria,fecha_baja,fecha_incor,nombre,nif,direccion,poblacion,cp,provincia,id_pais,mail,telefono,telefono2,notas";
			$datosInsert = array($_POST["num_ins_segsoc"],$_POST["num_afil_segsoc"],$_POST["id_usuario"],$_POST["entidadbancaria"],$_POST["domiciliobancario"],$_POST["cuentabancaria"],$_POST["fecha_baja"],$_POST["fecha_incor"],$_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["notas"]);
			insertFunction ("sgm_rrhh_empleado",$camposInsert,$datosInsert);
			$sql = "select id from sgm_rrhh_empleado where visible=1 and nombre='".$_POST["nombre"]."' and nif='".$_POST["nif"]."' order by id desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$id_empleado = $row["id"];
		} else {
			$id_empleado = $_GET["id"];
		}
		if (($soption == 100) and ($ssoption == 2)) {
			$camposUpdate = array('num_ins_segsoc','num_afil_segsoc','id_usuario','entidadbancaria','domiciliobancario','cuentabancaria','fecha_baja','fecha_incor','nombre','nif','direccion','poblacion','cp','provincia','id_pais','mail','telefono','telefono2','notas');
			$datosUpdate = array($_POST["num_ins_segsoc"],$_POST["num_afil_segsoc"],$_POST["id_usuario"],$_POST["entidadbancaria"],$_POST["domiciliobancario"],$_POST["cuentabancaria"],$_POST["fecha_baja"],$_POST["fecha_incor"],$_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["notas"]);
			updateFunction("sgm_rrhh_empleado",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		$sql = "select * from sgm_rrhh_empleado where id=".$id_empleado;
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=100&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Generales."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=110&id=".$row["id"]."\" style=\"color:white;\">".$Archivos."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=120&id=".$row["id"]."\" style=\"color:white;\">".$Formacion."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=130&id=".$row["id"]."\" style=\"color:white;\">".$Horarios."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=140&id=".$row["id"]."\" style=\"color:white;\">".$Puestos_trabajo."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\" style=\"color:white;\">".$Nominas."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=160&id=".$row["id"]."\" style=\"color:white;\">".$Dias_festivos."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=170&id=".$row["id"]."&hist=1\" style=\"color:white;\">".$Facturacion."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:400px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]."</strong></a>";
					echo "<br>".$row["nif"];
					echo "<br><strong>".$row["direccion"]."</strong>";
					if ($row["cp"] != "") {echo " (".$row["cp"].")";}
					echo "<strong> ".$row["poblacion"]."</strong>";
					if ($row["provincia"] != "") {echo " (".$row["provincia"].")";}
					if ($row["telefono"] != "") { echo "<br>Teléfono : <strong>".$row["telefono"]."</strong>"; }
					if ($row["mail"] != "") { echo "<br>eMail : <a href=\"mailto:".$row["email"]."\"><strong>".$row["mail"]."</strong></a>"; }
					echo "<br>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1020&sop=101&id=".$row["id"]."\" style=\"color:white;\">".$Eliminar."</a></td>";
						echo "</tr>";
						echo "<tr>";
						echo "</tr>";
						echo "<tr>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "</center>";
		echo "<table style=\"border-bottom:1px solid grey;border-left:1px solid grey;border-right:1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 100) {
		if ($id_empleado > 0) {
			$sqlem = "select * from sgm_rrhh_empleado where id=".$id_empleado;
			$resultem = mysqli_query($dbhandle,convertSQL($sqlem));
			$rowem = mysqli_fetch_array($resultem);
			echo "<form action=\"index.php?op=1020&sop=100&ssop=2&id=".$id_empleado."\"  method=\"post\">";
		} 
		if ($id_empleado == 0) {
			echo "<form action=\"index.php?op=1020&sop=100&ssop=1\"  method=\"post\">";
		}

		echo "<h4>".$Datos_Generales."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><td></td><th>".$Datos_Fiscales."</th></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Nombre.":</th><td colspan=\"3\"><input type=\"Text\" name=\"nombre\" value=\"".$rowem["nombre"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$NIF.": </th><td colspan=\"3\"><input type=\"Text\" name=\"nif\" value=\"".$rowem["nif"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Num_ins_segsoc.": </th><td colspan=\"3\"><input type=\"Text\" name=\"num_ins_segsoc\" value=\"".$rowem["num_ins_segsoc"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Num_afil_segsoc.": </th><td colspan=\"3\"><input type=\"Text\" name=\"num_afil_segsoc\" value=\"".$rowem["num_afil_segsoc"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;;vertical-align:top;\">".$Direccion.": </th><td colspan=\"3\"><textarea name=\"direccion\" rows=\"2\" style=\"width:350px\">".$row["direccion"]."</textarea></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$CP.": </th><td colspan=\"3\"><input type=\"Text\" name=\"cp\" value=\"".$rowem["cp"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Poblacion.": </th><td colspan=\"3\"><input type=\"Text\" name=\"poblacion\" value=\"".$rowem["poblacion"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Provincia.": </th><td colspan=\"3\"><input type=\"Text\" name=\"provincia\" value=\"".$rowem["provincia"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td></td><th>".$Datos_Adicionales."</th></tr>";
						echo "<tr><th style=\"text-align:right;\">".$Pais.": </th><td colspan=\"3\">";
							echo "<select name=\"id_pais\" style=\"width:350px;\">";
							echo "<option value=\"0\">-</option>";
							$sqlo = "select id,pais from sim_paises where visible=1 order by pais";
							$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
							while ($rowo = mysqli_fetch_array($resulto)) {
								if ($_GET["id"] == 0){
									if ($rowo["predefinido"] == 1){
										echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["pais"]."</option>";
									} else {
										echo "<option value=\"".$rowo["id"]."\">".$rowo["pais"]."</option>";
									}
								} elseif ($rowem["id_pais"] == $rowo["id"]){
										echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["pais"]."</option>";
								} else {
									echo "<option value=\"".$rowo["id"]."\">".$rowo["pais"]."</option>";
								}
							}
						echo "</select></td></tr>";
						echo "<tr><th style=\"text-align:right;\">".$Email."</th><td colspan=\"3\"><input type=\"Text\" name=\"mail\" value=\"".$rowem["mail"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr><th style=\"text-align:right;\">".$Telefono."</th><td><input type=\"Text\" name=\"telefono\" value=\"".$rowem["telefono"]."\" style=\"width:145px\"></td>";
							echo "<th style=\"text-align:right;width:60px\">".$Telefono." 2</th><td><input type=\"Text\" name=\"telefono2\" value=\"".$rowem["telefono2"]."\" style=\"width:140px\"></td>";
						echo "</tr></tr>";
						if ($rowem["fecha_incor"] == ""){$date1 = date("Y-m-d");} else {$date1 = $rowem["fecha_incor"];}
						if ($rowem["fecha_baja"] == ""){$date2 = date("Y-m-d");} else {$date2 = $rowem["fecha_baja"];}
							echo "<th style=\"text-align:right;\">".$Fecha_Incorporacion."</th><td><input type=\"text\" name=\"fecha_incor\" style=\"width:145px\" value=\"".$date1."\"></td>";
							echo "<th style=\"text-align:right;width:60px\">".$Fecha_Baja."</th><td><input type=\"text\" name=\"fecha_baja\" style=\"width:140px\" value=\"".$date2."\"></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Notas.": </th>";
							echo "<td colspan=\"3\"><textarea name=\"notas\" style=\"width:350px\" rows=\"2\">".$rowem["notas"]."</textarea></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"width:50px;\"></td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><td></td><th>".$Datos_Bancarios." : </th><tr>";
							echo "<th style=\"text-align:right;\">".$Entidad.": </th>";
							echo "<td><input type=\"text\" name=\"entidadbancaria\" style=\"width:350px\" value=\"".$rowem["entidadbancaria"]."\"></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;\">".$Direccion.": </th>";
							echo "<td><input type=\"Text\" name=\"domiciliobancario\" style=\"width:350px\" value=\"".$rowem["domiciliobancario"]."\"></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;\">IBAN : </th>";
							echo "<td><input type=\"Text\" name=\"cuentabancaria\" style=\"width:350px\" value=\"".$rowem["cuentabancaria"]."\"></td>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td></td><th>".$Datos." SIMges: </th><tr>";
						echo "<tr><th style=\"text-align:right;\">".$Usuario.": </th><td>";
							echo "<select name=\"id_usuario\" style=\"width:350px;\">";
							echo "<option value=\"0\">-</option>";
							$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 order by usuario";
							$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
							while ($rowu = mysqli_fetch_array($resultu)) {
								if ($rowem["id_usuario"] == $rowu["id"]){
									echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
								} else {
									echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
								}
							}
						echo "</select></td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			if ($_GET["id"] > 0) { echo "<tr><td colspan=\"3\"><input type=\"submit\" value=\"".$Guardar."\" style=\"width:100%\"></td></tr>"; }
			if ($_GET["id"] == 0) {	echo "<tr><td colspan=\"3\"><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100%\"></td></tr>";	}
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=0&ssop=3&id=".$_GET["id"],"op=1020&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 110) {
		echo "<h4>".$Archivos."</h4>";
		anadirArchivo ($_GET["id"],6,"");
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=110&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1020&sop=110&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 120){
		echo "<h4>".$Formacion."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th style=\"width:300px\">".$Cursos."</th>";
				echo "<th style=\"width:100px\">".$Fecha_Inicio."</th>";
				echo "<th style=\"width:100px\">".$Fecha_Fin."</th>";
			echo "</tr>";
			$sqlf = "select nombre,fecha_inicio,fecha_fin from sgm_rrhh_formacion where id in (select id_curso from sgm_rrhh_formacion_empleado where id_empleado=".$_GET["id"]." and visible=1)";
			$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
			while ($rowf = mysqli_fetch_array($resultf)){
				echo "<tr>";
					echo "<td>".$rowf["nombre"]."</td>";
					echo "<td>".$rowf["fecha_inicio"]."</td>";
					echo "<td>".$rowf["fecha_fin"]."</td></tr>";
			}
		echo "</table>";
		echo "<br>";
	}

	if ($soption == 130){
		if ((($_POST["data_ini"] > $_POST["data_fi"]) and ($_POST["data_fi"] != "") and ($_POST["data_fi"] != "0000-00-00")) or ($_POST["hora_ini"] > $_POST["hora_fi"]) or ($_POST["hora_ini2"] > $_POST["hora_fi2"])){
			echo $_POST["data_fi"].mensageError($ErrorEmpleadoHorario);
		} else {
			if ($ssoption == 1) {
				$camposinsert = "id_empleado,data_ini,data_fi,hora_ini,hora_fi,hora_ini2,hora_fi2,dia_setmana";
				$datosInsert = array($_GET["id"],$_POST["data_ini"],$_POST["data_fi"],$_POST["hora_ini"],$_POST["hora_fi"],$_POST["hora_ini2"],$_POST["hora_fi2"],$_POST["dia_setmana"]);
				insertFunction ("sgm_rrhh_empleado_horario",$camposinsert,$datosInsert);
			}
			if ($ssoption == 2) {
				$camposUpdate = array("data_ini","data_fi","hora_ini","hora_fi","hora_ini2","hora_fi2","dia_setmana");
				$datosUpdate = array($_POST["data_ini"],$_POST["data_fi"],$_POST["hora_ini"],$_POST["hora_fi"],$_POST["hora_ini2"],$_POST["hora_fi2"],$_POST["dia_setmana"]);
				updateFunction ("sgm_rrhh_empleado_horario",$_GET["id_horari"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_empleado_horario",$_GET["id_horari"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Horarios."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Fecha_Inicio."</th>";
				echo "<th>".$Fecha_Fin."</th>";
				echo "<th>".$Hora_Inicio."</th>";
				echo "<th>".$Hora_Fin."</th>";
				echo "<th>".$Hora_Inicio." 2</th>";
				echo "<th>".$Hora_Fin." 2</th>";
				echo "<th>".$Dia."</th>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1020&sop=130&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"data_ini\" style=\"width:100px;\" value=\"".date("Y-m-d")."\"></td>";
				echo "<td><input type=\"text\" name=\"data_fi\" style=\"width:100px;\" value=\"\"></td>";
				echo "<td><input type=\"text\" name=\"hora_ini\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_fi\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_ini2\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_fi2\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><select name=\"dia_setmana\" style=\"width:100px\">";
					echo "<option value=\"-1\">".$Todos."</option>";
					for ($i=0;$i<=6;$i++){
						echo "<option value=\"".$i."\">".$dias[$i]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$fecha = date("Y-m-d");
			$sql = "select * from sgm_rrhh_empleado_horario where visible=1 and id_empleado=".$_GET["id"]." order by data_ini desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$color = "white";
				if (($fecha >= $row["data_ini"]) and (($fecha <= $row["data_fi"]) or ($row["data_fi"] == "0000-00-00"))) { $color = "green"; }
				echo "<tr style=\"background-color:".$color."\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=131&id=".$_GET["id"]."&id_horari=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1020&sop=130&ssop=2&id=".$_GET["id"]."&id_horari=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" name=\"data_ini\" style=\"width:100px;\" value=\"".$row["data_ini"]."\"></td>";
					echo "<td><input type=\"text\" name=\"data_fi\" style=\"width:100px;\" value=\"".$row["data_fi"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_ini\" style=\"width:70px;\" value=\"".$row["hora_ini"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_fi\" style=\"width:70px;\" value=\"".$row["hora_fi"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_ini2\" style=\"width:70px;\" value=\"".$row["hora_ini2"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_fi2\" style=\"width:70px;\" value=\"".$row["hora_fi2"]."\"></td>";
					echo "<td><select name=\"dia_setmana\" style=\"width:100px\">";
						if ($row["dia_setmana"] == -1) {
							echo "<option value=\"-1\" selected>".$Todos."</option>";
							for ($i=0;$i<=6;$i++){
								echo "<option value=\"".$i."\">".$dias[$i]."</option>";
							}
						} else {
							echo "<option value=\"-1\">".$Todos."</option>";
							for ($i=0;$i<=6;$i++){
								if ($row["dia_setmana"] == $i) {
									echo "<option value=\"".$i."\" selected>".$dias[$i]."</option>";
								} else {
									echo "<option value=\"".$i."\">".$dias[$i]."</option>";
								}
							}
						}
					echo "</select></td>";
					echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table><br>";
	}
	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=130&ssop=3&id=".$_GET["id"]."&id_horari=".$_GET["id_horari"],"op=1020&sop=130&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 140){
		if ($ssoption == 1) {
			$camposInsert = "id_empleado,id_puesto,fecha_alta,fecha_baja";
			$datosInsert = array($_GET["id"],$_POST["id_puesto"],$_POST["fecha_alta"],$_POST["fecha_baja"]);
			insertFunction ("sgm_rrhh_empleado_puesto",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("fecha_alta","fecha_baja");
			$datosUpdate = array($_POST["fecha_alta"],$_POST["fecha_baja"]);
			updateFunction ("sgm_rrhh_empleado_puesto",$_GET["puesto"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_empleado_puesto",$_GET["puesto"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Puestos_trabajo."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Puesto_trabajo."</th>";
				echo "<th>".$Fecha_Alta."</th>";
				echo "<th>".$Fecha_Baja."</th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1020&sop=140&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_puesto\" style=\"width:350px;\">";
				echo "<option value=\"0\">-</option>";
				$sqlpt = "select id,id_departamento,puesto from sgm_rrhh_puesto_trabajo where visible=1 and activo=1 and id NOT IN (select id_puesto from sgm_rrhh_empleado_puesto where fecha_baja='0000-00-00' and visible=1) order by puesto";
				$resultpt = mysqli_query($dbhandle,convertSQL($sqlpt));
				while ($rowpt = mysqli_fetch_array($resultpt)) {
					$sqld = "select departamento from sgm_rrhh_departamento where visible=1 and id=".$rowpt["id_departamento"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					if ($rowem["id_puesto"] == $rowpt["id"]){
						echo "<option value=\"".$rowpt["id"]."\" selected>".$rowpt["puesto"]." (".$rowd["departamento"].")</option>";
					} else {
						echo "<option value=\"".$rowpt["id"]."\">".$rowpt["puesto"]." (".$rowd["departamento"].")</option>";
					}
				}
				echo "</select></td>";
				echo "<td><input type=\"text\" name=\"fecha_alta\" style=\"width:100px\" value=\"".date("Y-m-d")."\"></td>";
				echo "<td><input type=\"text\" name=\"fecha_baja\" style=\"width:100px\" value=\"0000-00-00\"></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlpe = "select * from sgm_rrhh_empleado_puesto where id_empleado=".$_GET["id"]." and visible=1";
			$resultpe = mysqli_query($dbhandle,convertSQL($sqlpe));
			while ($rowpe = mysqli_fetch_array($resultpe)){
				$sqle = "select puesto from sgm_rrhh_puesto_trabajo where id=".$rowpe["id_puesto"];
				$resulte = mysqli_query($dbhandle,convertSQL($sqle));
				while ($rowe = mysqli_fetch_array($resulte)){
					echo "<form action=\"index.php?op=1020&sop=140&ssop=2&id=".$_GET["id"]."&puesto=".$row["id"]."\" method=\"post\">";
					echo "<tr>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1020&sop=141&id=".$_GET["id"]."&puesto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td>".$rowe["puesto"]."</td>";
						echo "<td><input type=\"text\" name=\"fecha_alta\" style=\"width:100px\" value=\"".$rowpe["fecha_alta"]."\"></td>";
						echo "<td><input type=\"text\" name=\"fecha_baja\" style=\"width:100px\" value=\"".$rowpe["fecha_baja"]."\"></td>";
						echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		echo "</table>";
	}

	if ($soption == 141) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=140&ssop=3&id=".$_GET["id"]."&puesto=".$_GET["puesto"],"op=1020&sop=140&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 150) {
		if (date(U,strtotime($_POST["data_ini"])) > date(U,strtotime($_POST["data_fi"]))) {
			echo mensageError($ErrorEmpleadoCalendario);
		} else {
			if ($ssoption == 1) {
				$camposInsert = "id_empleado,data_ini,data_fi,total";
				$datosInsert = array($_GET["id"],date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])),$_POST["total"]);
				insertFunction ("sgm_rrhh_empleado_nominas",$camposInsert,$datosInsert);
			}
			if ($ssoption == 2){
				$camposUpdate = array("data_ini","data_fi","total");
				$datosUpdate = array(date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])),$_POST["total"]);
				updateFunction ("sgm_rrhh_empleado_nominas",$_GET["id_nom"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_rrhh_empleado_nominas",$_GET["id_nom"]);
		}
		echo "<h4>".$Nominas."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Desde."</th>";
				echo "<th>".$Hasta."</th>";
				echo "<th>".$Total."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1020&sop=150&ssop=1&id=".$_GET["id"]."&id_nom=".$row["id"]."\" method=\"post\">";
				echo "<td><input name=\"data_ini\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y')."\"></td>";
				echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',time()+(30*24*60*60))."\"></td>";
				echo "<td><input name=\"total\" type=\"Text\" style=\"width:150px\" value=\"0.00\"></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_rrhh_empleado_nominas where id_empleado=".$_GET["id"]." order by data_ini";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1020&sop=150&ssop=2&id=".$_GET["id"]."&id_nom=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1020&sop=151&id=".$_GET["id"]."&id_nom=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input name=\"data_ini\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',$row["data_ini"])."\"></td>";
					if ($row["data_fi"] > 0) {
						echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',$row["data_fi"])."\"></td>";
					} else {
						echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\"></td>";
					}
					echo "<td><input name=\"total\" type=\"Text\" style=\"width:150px\" value=\"".$row["total"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 151) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=150&ssop=3&id=".$_GET["id"]."&id_nom=".$_GET["id_nom"],"op=1020&sop=150&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 160){
		if (($_POST["data_fi"] != '') and (date(U,strtotime($_POST["data_ini"])) > date(U,strtotime($_POST["data_fi"])))) {
			echo mensageError($ErrorEmpleadoCalendario);
		} else {
			$total_di = dif_dias_fechas(date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])));
			if ($ssoption == 1) {
				$camposInsert = "id_empleado,data_ini,data_fi,total_dias,motivo,vacaciones,remunerado";
				$datosInsert = array($_GET["id"],date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])),$total_di,$_POST["motivo"],$_POST["vacaciones"],$_POST["remunerado"]);
				insertFunction ("sgm_rrhh_empleado_calendario",$camposInsert,$datosInsert);
			}
			if ($ssoption == 2){
				$camposUpdate = array("data_ini","data_fi","total_dias","motivo","vacaciones","remunerado");
				$datosUpdate = array(date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])),$total_di,$_POST["motivo"],$_POST["vacaciones"],$_POST["remunerado"]);
				updateFunction ("sgm_rrhh_empleado_calendario",$_GET["id_dia"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_rrhh_empleado_calendario",$_GET["id_dia"]);
		}
		echo "<h4>".$Dias_festivos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Desde."</th>";
							echo "<th>".$Hasta." (".$Opcional.")</th>";
							echo "<th>".$Motivo."</th>";
							echo "<th>".$Vacaciones."</th>";
							echo "<th>".$Remunerado."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<td></td>";
							echo "<form action=\"index.php?op=1020&sop=160&ssop=1&id=".$_GET["id"]."&id_dia=".$row["id"]."\" method=\"post\">";
							echo "<td><input name=\"data_ini\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y')."\"></td>";
							echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\"></td>";
							echo "<td><input name=\"motivo\" type=\"Text\" style=\"width:200px\"></td>";
							echo "<td><select name=\"vacaciones\" style=\"width:60px\">";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
							echo "<td><select name=\"remunerado\" style=\"width:60px\">";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sgm_rrhh_empleado_calendario where id_empleado=".$_GET["id"]." order by data_ini desc";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							echo "<tr>";
								echo "<form action=\"index.php?op=1020&sop=160&ssop=2&id=".$_GET["id"]."&id_dia=".$row["id"]."\" method=\"post\">";
								echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1020&sop=161&id=".$_GET["id"]."&id_dia=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<td><input name=\"data_ini\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',$row["data_ini"])."\"></td>";
								if ($row["data_fi"] > 0) {
									echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',$row["data_fi"])."\"></td>";
								} else {
									echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\"></td>";
								}
								echo "<td><input name=\"motivo\" type=\"Text\" style=\"width:200px\" value=\"".$row["motivo"]."\"></td>";
								echo "<td><select name=\"vacaciones\" style=\"width:60px\">";
									if ($row["vacaciones"] == 0) {
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\">".$Si."</option>";
									} else {
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\" selected>".$Si."</option>";
									}
								echo "</select></td>";
								echo "<td><select name=\"remunerado\" style=\"width:60px\">";
									if ($row["remunerado"] == 0) {
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\">".$Si."</option>";
									} else {
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\" selected>".$Si."</option>";
									}
								echo "</select></td>";
								echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td><td style=\"vertical-align:top;width:50px;\">";
				echo "</td><td  style=\"vertical-align:top;\">";
				$sqlj = "select * from sgm_rrhh_jornada_anual";
				$resultj = mysqli_query($dbhandle,convertSQL($sqlj));
				$rowj = mysqli_fetch_array($resultj);
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th colspan=\"2\">".$Dias_vacaciones_any."</th>";
						echo "</tr>";
						for ($i=2012;$i<=(date('Y')+1);$i++){
							$dias_vac=0;
							$sql = "select data_fi,data_ini,total_dias from sgm_rrhh_empleado_calendario where id_empleado=".$_GET["id"]." and data_ini between ".date("U", mktime(0, 0, 0, 1, 1, $i))." and ".date("U", mktime(0, 0, 0, 12, 31, $i))." and vacaciones=1";
							$result = mysqli_query($dbhandle,convertSQL($sql));
							while ($row = mysqli_fetch_array($result)) {
								if (($row["data_fi"] > 0) and (date("Y",$row["data_fi"]) > $i)){
									$dias_vac += dif_dias_fechas($row["data_ini"],date("U", mktime(0, 0, 0, 12, 31, $i)));
								} else {
									$dias_vac += $row["total_dias"];
								}
							}
							$sql2 = "select data_fi,data_ini from sgm_rrhh_empleado_calendario where id_empleado=".$_GET["id"]." and data_fi between ".date("U", mktime(0, 0, 0, 1, 1, $i))." and ".date("U", mktime(0, 0, 0, 12, 31, $i))." and vacaciones=1";
							$result2 = mysqli_query($dbhandle,convertSQL($sql2));
							while ($row2 = mysqli_fetch_array($result2)) {
								if (date("Y",$row2["data_ini"]) < $i){
									$dias_vac += dif_dias_fechas(date("U", mktime(0, 0, 0, 1, 1, $i)),$row2["data_fi"]);
								}
							}
							echo "<tr>";
								if($rowj["num_dias_vac"] < $dias_vac) { $color = "yellow"; } else { $color = "white"; }
								echo "<td style=\"background-color:".$color.";text-align:right;\">".$dias_vac."</td><td> / ".$rowj["num_dias_vac"]." (".$i.")</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td><td style=\"vertical-align:top;width:50px;\">";
				echo "</td><td  style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th colspan=\"2\">".$Dias_libres_any."</th>";
						echo "</tr>";
						$dias_lib=0;
						for ($i=2012;$i<=date('Y');$i++){
							$sql = "select data_fi,data_ini,total_dias from sgm_rrhh_empleado_calendario where id_empleado=".$_GET["id"]." and data_ini between ".date("U", mktime(0, 0, 0, 1, 1, $i))." and ".date("U", mktime(0, 0, 0, 12, 31, $i))." and vacaciones=0 and remunerado=0";
							$result = mysqli_query($dbhandle,convertSQL($sql));
							while ($row = mysqli_fetch_array($result)) {
								if (($row["data_fi"] > 0) and (date("Y",$row["data_fi"]) > $i)){
									$dias_lib += dif_dias_fechas($row["data_ini"],date("U", mktime(0, 0, 0, 12, 31, $i)));
								} else {
									$dias_lib += $row["total_dias"];
								}
							}
							echo "<tr>";
								if($rowj["num_dias_lib"] < $dias_lib) { $color = "yellow"; } else { $color = "white"; }
								echo "<td style=\"background-color:".$color.";text-align:right;\">".$dias_lib."</td><td> / ".$rowj["num_dias_lib"]." (".$i.")</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 161) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=160&ssop=3&id=".$_GET["id"]."&id_dia=".$_GET["id_dia"],"op=1020&sop=160&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 170) {
		echo "<h4>".$Facturcion."</h4>";
		$presu = 0;
		$v_fecha_pre = 0;
		$v_fecha_ven = 0;
		$v_numero_cli = 0;
		$v_rfq = 0;
		$tpv = 1;
		$v_sub = 0;
		$v_docs = 0;
		$v_recibo = 0;
		$tds = 3;
		$sqltipo = "select * from sgm_factura_tipos where id IN (9,5)";
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
				if ($v_docs == 1) { echo "<th>Docs</th>"; $tds++;}
				echo "<th>".$Numero."</th>";
				if ($presu == 1) { echo "<th>Ver.</th>";  $tds++;}
				echo "<th>".$Fecha."</th>";
				if ($v_fecha_pre == 1) { echo "<th>".$Fecha." ".$Prevision."</th>"; $tds++; }
				if ($v_fecha_ven == 1) { echo "<th>".$Vencimiento."</th>"; $tds++; }
				if ($v_numero_cli == 1) { echo "<th>Ref. Ped. Cli.</th>"; $tds++; }
				if ($v_rfq == 1) { echo "<th>".$Numero." RFQ</th>"; $tds++; }
				if ($tpv == 0) { echo "<th>".$Cliente."</th>"; $tds++; }
				if ($v_sub == 1) { echo "<th>".$Subtipo."</th>"; $tds++; }
				echo "<th style=\"text-align:right\">".$Subtotal."</th>";
				echo "<th style=\"text-align:right\">".$Total."</th>";
				if ($v_recibo == 1)  {echo "<th style=\"text-align:right;\">".$Pendiente."</th>"; $tds2++;}
			echo "</tr>";
			$totalSensePagar = 0;
			$totalSenseIVA = 0;
			$totalPagat = 0;
			$sqldiv = "select id,abrev from sgm_divisas where predefinido=1";
			$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
			$rowdiv = mysqli_fetch_array($resultdiv);
			$sqlem = "select id_usuario from sgm_rrhh_empleado where id=".$_GET["id"];
			$resultem = mysqli_query($dbhandle,convertSQL($sqlem));
			$rowem = mysqli_fetch_array($resultem);
			$sqlca = "select * from sgm_cabezera where visible=1 and id_pagador=".$rowem["id_usuario"]." order by numero desc,version desc,fecha desc";
			$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
			while ($rowca = mysqli_fetch_array($resultca)) {
				echo mostrarFacturas($rowca);
			}
			echo "<tr>";
				echo "<td colspan=\"".$tds."\" style=\"text-align:right;\"><strong>".$Total."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".number_format($totalSenseIVA,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".number_format($totalSensePagar,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";
				if ($rowtipos["v_recibos"] == 1)  {echo "<td style=\"text-align:right;\"><strong>".number_format($totalPagat,2,",",".")." ".$rowdiv["abrev"]."</strong></td>";}
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 300) {
		echo "<h4>".$Organigrama."</h4>";
		if ($_GET["emple"] == 0) { $emple = 1; $ver1 = $Ver_Empleados;} elseif ($_GET["emple"] == 1){ $emple = 0; $ver1 = $Ver_Departamentos;}
		echo boton(array("op=1020&sop=300&emple=".$emple),array($ver1));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;\">";
			echo "<tr style=\"background-color:silver;\"><th style=\"text-align:center;\">Solucions-IM</th></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td>";
					busca_departamentos(0,$_GET["emple"]);
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1020&sop=510","op=1020&sop=520","op=1020&sop=530","op=1020&sop=540","op=1020&sop=550"),array($Calendario." ".$$Laboral,$Horario_atencion,$Departamentos,$Puestos_trabajo,$Cursos));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "dia,mes,ano,descripcio";
			$datosInsert = array($_POST["dia"],$_POST["mes"]+1,$_POST["ano"],$_POST["descripcio"]);
			insertFunction ("sgm_calendario",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			deleteFunction ("sgm_calendario",$_GET["id"]);
		}
		if ($ssoption == 3) {
			if ($_GET["id"] == 0){
				$camposInsert = "num_dias_vac,num_dias_lib,num_horas_any";
				$datosInsert = array($_POST["num_dias_vac"],$_POST["num_dias_lib"],$_POST["num_horas_any"]);
				insertFunction ("sgm_rrhh_jornada_anual",$camposInsert,$datosInsert);
			} else {
				$camposUpdate=array('num_dias_vac','num_dias_lib','num_horas_any');
				$datosUpdate=array($_POST["num_dias_vac"],$_POST["num_dias_lib"],$_POST["num_horas_any"]);
				updateFunction("sgm_rrhh_jornada_anual",$_GET["id"],$camposUpdate,$datosUpdate);
			}
		}
		echo "<h4>".$Calendario." ".$Laboral."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo boton(array("op=1020&sop=515"),array($Historico));
		
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Dia."</th>";
							echo "<th>".$Mes."</th>";
							echo "<th>".$Ano."</th>";
							echo "<th>".$Festividad."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<td></td>";
							echo "<form action=\"index.php?op=1020&sop=510&ssop=1&id=".$row["id"]."\" method=\"post\">";
							echo "<td><select name=\"dia\" style=\"width:40px\">";
								for ($i=1; $i <= 31; $i++) {
									echo "<option value=\"".$i."\">".$i."</option>";
								}
							echo "</select></td>";
							echo "<td><select name=\"mes\" style=\"width:100px\">";
								for ($i=0; $i < count($meses); $i++) {
									echo "<option value=\"".$i."\">".$meses[$i]."</option>";
								}
							echo "</select></td>";
							echo "<td><select name=\"ano\" style=\"width:100px\">";
								$year = date("Y");
								for ($j=2012;$j<=date("Y")+1;$j++){
									if ($j == $year){
										echo "<option value=\"".$j."\" selected>".$j."</option>";
									} else {
										echo "<option value=\"".$j."\">".$j."</option>";
									}
								}
							echo "</select></td>";
							echo "<td><input name=\"descripcio\" type=\"Text\" style=\"width:150px\"></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sgm_calendario where ano=".date("Y")." order by ano,mes,dia";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;width:40px;\"><a href=\"index.php?op=1020&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<td>".$row["dia"]."</td>";
								echo "<td>".$meses[$row["mes"]-1]."</td>";
								echo "<td>".$row["ano"]."</td>";
								echo "<td>".$row["descripcio"]."</td>";
								echo "<td></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td><td style=\"vertical-align:top;width:50px;\">";
				$sqlj = "select * from sgm_rrhh_jornada_anual";
				$resultj = mysqli_query($dbhandle,convertSQL($sqlj));
				$rowj = mysqli_fetch_array($resultj);
				echo "</td><td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<form action=\"index.php?op=1020&sop=510&ssop=3&id=".$rowj["id"]."\" method=\"post\">";
						echo "<tr>";
							echo "<th>".$Dias_vacaciones_any."</th>";
							echo "<td><input name=\"num_dias_vac\" type=\"Text\" style=\"width:100px;text-align:right;\" value=\"".$rowj["num_dias_vac"]."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th>".$Dias_libres_any."</th>";
							echo "<td><input name=\"num_dias_lib\" type=\"Text\" style=\"width:100px;text-align:right;\" value=\"".$rowj["num_dias_lib"]."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th>".$Jornada_anual."</th>";
							echo "<td><input name=\"num_horas_any\" type=\"Text\" style=\"width:100px;text-align:right;\" value=\"".$rowj["num_horas_any"]."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td></td><td class=\"submit\"><input type=\"submit\" value=\"".$Guardar."\"></td>";
						echo "</tr>";
						echo "</form>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 511) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=510&ssop=2&id=".$_GET["id"],"op=1020&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 515) AND ($admin == true)) {
		echo "<h4>".$Historico."</h4>";
		echo boton(array("op=1020&sop=510"),array("&laquo; ".$Volver));
		
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Dia."</th>";
							echo "<th>".$Mes."</th>";
							echo "<th>".$Ano."</th>";
							echo "<th>".$Festividad."</th>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sgm_calendario where ano<>".date("Y")." order by ano,mes,dia";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							echo "<tr>";
								echo "<td style=\"width:40px\">".$row["dia"]."</td>";
								echo "<td style=\"width:100px\">".$meses[$row["mes"]-1]."</td>";
								echo "<td style=\"width:100px\">".$row["ano"]."</td>";
								echo "<td style=\"width:150px\">".$row["descripcio"]."</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 520) AND ($admin == true)) {
		if ($ssoption == 1) {
			$hora_ini = $_POST["hora_inicio"]*3600;
			$hora_fi = $_POST["hora_fin"]*3600;
			$total_horas = $hora_fi-$hora_ini;
			$camposUpdate=array('hora_inicio','hora_fin','total_horas');
			$datosUpdate=array($hora_ini,$hora_fi,$total_horas);
			updateFunction("sgm_calendario_horario",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Horario_atencion."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Dia."</th>";
				echo "<th>".$Hora_Inicio."</th>";
				echo "<th>".$Hora_Fin."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sql = "select * from sgm_calendario_horario order by id";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$hora_ini = $row["hora_inicio"]/3600;
				$hora_fi = $row["hora_fin"]/3600;
				echo "<tr>";
				echo "<form action=\"index.php?op=1020&sop=520&ssop=1&id=".$row["id"]."\" method=\"post\">";
					echo "<td>".$row["dia"]."</td>";
					echo "<td><input name=\"hora_inicio\" type=\"number\" min=\"1\" value=\"".$hora_ini."\" style=\"width:60px\"></td>";
					echo "<td><input name=\"hora_fin\" type=\"number\" min=\"1\" value=\"".$hora_fi."\" style=\"width:60px\"></td>";
					echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 530) AND ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "id_departamento,departamento";
			$datosInsert = array($_POST["id_departamento"],$_POST["departamento"]);
			insertFunction ("sgm_rrhh_departamento",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("id_departamento","departamento");
			$datosUpdate = array($_POST["id_departamento"],$_POST["departamento"]);
			updateFunction ("sgm_rrhh_departamento",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_departamento",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Departamentos."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Departamento." ".$Superior."</th>";
				echo "<th>".$Departamento."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1020&sop=530&ssop=1\" method=\"post\">";
				echo "<td><select name=\"id_departamento\" style=\"width:200px\">";
					echo "<option value=\"0\" selected>-</option>";
					$sql = "select * from sgm_rrhh_departamento where visible=1";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)){
						echo "<option value=\"".$row["id"]."\">".$row["departamento"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"text\" name=\"departamento\" style=\"width:200px\" required></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<tr style=\"text-align:center\">";
					echo "<td>";
						$trobat = busca_puesto($row["id"]);
						if ($trobat == 0){
							echo "<a href=\"index.php?op=1020&sop=531&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
						}
					echo "</td>";
					echo "<form action=\"index.php?op=1020&sop=530&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><select name=\"id_departamento\" style=\"width:200px\">";
						echo "<option value=\"0\" selected>-</option>";
						$sqld = "select * from sgm_rrhh_departamento where visible=1";
						$resultd = mysqli_query($dbhandle,convertSQL($sqld));
						while ($rowd = mysqli_fetch_array($resultd)){
							if ($row["id"] != $rowd["id"]) {
								if ($row["id_departamento"] == $rowd["id"]) {
									echo "<option value=\"".$rowd["id"]."\" selected>".$rowd["departamento"]."</option>";
								} else {
									echo "<option value=\"".$rowd["id"]."\">".$rowd["departamento"]."</option>";
								}
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"departamento\" style=\"width:200px\" value=\"".$row["departamento"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 531) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=510&ssop=3&id=".$_GET["id"],"op=1020&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 540) AND ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "id_departamento,puesto,tareas,f_general,f_especifica,experiencia,habilidades";
			$datosInsert = array($_POST["id_departamento"],$_POST["puesto"],$_POST["tareas"],$_POST["f_general"],$_POST["f_especifica"],$_POST["experiencia"],$_POST["habilidades"]);
			insertFunction ("sgm_rrhh_puesto_trabajo",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("id_departamento","puesto","tareas","f_general","f_especifica","experiencia","habilidades");
			$datosUpdate = array($_POST["id_departamento"],$_POST["puesto"],$_POST["tareas"],$_POST["f_general"],$_POST["f_especifica"],$_POST["experiencia"],$_POST["habilidades"]);
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "select * from sgm_rrhh_puesto_trabajo where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposinsert = "id_departamento,puesto,tareas,f_general,f_especifica,experiencia,habilidades,activo";
			$datosInsert = array($row["id_departamento"],$row["puesto"],$row["tareas"],$row["f_general"],$row["f_especifica"],$row["experiencia"],$row["habilidades"],$row["activo"]);
			insertFunction ("sgm_rrhh_puesto_trabajo",$camposinsert,$datosInsert);
		}
		if ($ssoption == 5) {
			echo $sql = "select id from sgm_rrhh_empleado_puesto where fecha_baja='0000-00-00' and visible=1 and id_puesto in (select * from sgm_rrhh_puesto_trabajo where id=".$_GET["id"].")";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if ($row){
				echo mensageError($ErrorPuestoDasactivar);
			} else {
				$camposUpdate = array("activo");
				$datosUpdate = array("0");
				updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 6) {
			$camposUpdate = array("activo");
			$datosUpdate = array("1");
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Puestos_trabajo."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo boton(array("op=1020&sop=540&id=".$_GET["id"]."&edit=1"),array($Anadir." ".$Puesto));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"100%\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Puesto_trabajo."</th>";
							echo "<th>".$Departamento."</th>";
							echo "<th>".$Empleado." ".$Actual."</th>";
							echo "<th></th>";
							echo "<th></th>";
							echo "<th></th>";
							echo "<th></th>";
						echo "</tr>";
						$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 order by puesto";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)){
							echo "<tr>";
								echo "<td style=\"text-align:center;\">";
								$trobat = busca_puesto($row["id"]);
								if ($trobat == 0){
									echo "<a href=\"index.php?op=1020&sop=541&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
								}
								echo "</td>";
								$x = "black";
								if ($row["activo"] == 0) { $x = "silver"; }
								echo "<td style=\"text-align:left;color:".$x."\">".$row["puesto"]."</td>";
								$sqld = "select departamento from sgm_rrhh_departamento where visible=1 and id=".$row["id_departamento"];
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								$rowd = mysqli_fetch_array($resultd);
								echo "<td style=\"text-align:left;\">".$rowd["departamento"]."</td>";
								$sqlp = "select id,nombre from sgm_rrhh_empleado where id=(select id_empleado from sgm_rrhh_empleado_puesto where visible=1 and fecha_baja='0000-00-00' and id_puesto=".$row["id"].")";
								$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
								$rowp = mysqli_fetch_array($resultp);
								echo "<td style=\"text-align:left;\"><a href=\"index.php?op=1020&sop=100&id=".$rowp["id"]."\">".$rowp["nombre"]."</a></td>";
								echo "<form action=\"index.php?op=1020&sop=540&id=".$row["id"]."&edit=2\" method=\"post\">";
									echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Editar."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=542&id=".$row["id"]."\" method=\"post\">";
									echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Historico."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=540&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Duplicar."\"></td>";
								echo "</form>";
								if ($row["activo"] == 1) {
									echo "<form action=\"index.php?op=1020&sop=540&ssop=5&id=".$row["id"]."\" method=\"post\">";
										echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Desactivar."\"></td>";
									echo "</form>";
								} else {
									echo "<form action=\"index.php?op=1020&sop=540&ssop=6&id=".$row["id"]."\" method=\"post\">";
										echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Activar."\"></td>";
									echo "</form>";
								}
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
				echo "<td>";
					if ($_GET["edit"] > 0){
						$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id=".$_GET["id"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						if ($_GET["edit"] == 1){
							echo "<caption>".$Anadir." ".$Puesto."</caption>";
							echo "<form action=\"index.php?op=1020&sop=540&ssop=1\" method=\"post\">";
						}
						if ($_GET["edit"] == 2) {
							echo "<caption>".$Editar." ".$Puesto."</caption>";
							echo "<form action=\"index.php?op=1020&sop=540&ssop=2&id=".$row["id"]."\" method=\"post\">";
						}
							echo "<tr>";
								if ($_GET["edit"] == 1) { echo "<td></td><td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:500px\"></td>"; }
								if ($_GET["edit"] == 2) { echo "<td></td><td><input type=\"submit\" value=\"".$Editar."\" style=\"width:500px\"></td>"; }
							echo "</tr><tr>";
								echo "<td>".$Puesto."</td>";
								echo "<td><input type=\"text\" name=\"puesto\" value=\"".$row["puesto"]."\" style=\"width:500px\"></td>";
							echo "</tr><tr>";
								echo "<td>".$Departamento."</td>";
								echo "<td><select name=\"id_departamento\" style=\"width:500px\">";
										echo "<option value=\"0\" selected>-</option>";
										$sqld = "select id,departamento from sgm_rrhh_departamento where visible=1 order by departamento";
										$resultd = mysqli_query($dbhandle,convertSQL($sqld));
										while ($rowd = mysqli_fetch_array($resultd)){
											if (($row["id_departamento"] == $rowd["id"]) or ($_GET["id"] == $rowd["id"])) {
												echo "<option value=\"".$rowd["id"]."\" selected>".$rowd["departamento"]."</option>";
											} else {
												echo "<option value=\"".$rowd["id"]."\">".$rowd["departamento"]."</option>";
											}
										}
									echo "</select></td>";
							echo "</tr><tr>";
								echo "<td style=\"vertical-align:top;\">".$Funciones."</td>";
								echo "<td><textarea rows=\"5\" name=\"tareas\" style=\"width:500px\">".$row["tareas"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<td style=\"vertical-align:top;\">".$Formacion_general."</td>";
								echo "<td><textarea rows=\"5\" name=\"f_general\" style=\"width:500px\">".$row["f_general"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<td style=\"vertical-align:top;\">".$Formacion_especifica."</td>";
								echo "<td><textarea rows=\"5\" name=\"f_especifica\" style=\"width:500px\">".$row["f_especifica"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<td style=\"vertical-align:top;\">".$Experiencia."</td>";
								echo "<td><textarea rows=\"5\" name=\"experiencia\" style=\"width:500px\">".$row["experiencia"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<td style=\"vertical-align:top;\">".$Habilidades_personales."</td>";
								echo "<td><textarea rows=\"5\" name=\"habilidades\" style=\"width:500px\">".$row["habilidades"]."</textarea></td>";
							echo "</tr><tr>";
								if ($_GET["edit"] == 1) { echo "<td></td><td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:500px\"></td>"; }
								if ($_GET["edit"] == 2) { echo "<td></td><td><input type=\"submit\" value=\"".$Editar."\" style=\"width:500px\"></td></tr>"; }
							echo "<tr></tr>";
							echo "</form>";
							echo "</tr>";
						echo "</table>";
						
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 541) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=540&ssop=3&id=".$_GET["id"],"op=1020&sop=540"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 542) AND ($admin == true)) {
		$sql = "select id,puesto from sgm_rrhh_puesto_trabajo where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<h4>".$Puesto_trabajo." : ".$row["puesto"]."</h4>";
		echo boton(array("op=1020&sop=540"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Nombre." ".$Empleado."</th>";
				echo "<th>".$Fecha." ".$Alta."</th>";
				echo "<th>".$Fecha." ".$Baja."</th>";
			echo "</tr>";
			$sqlpe = "select * from sgm_rrhh_empleado_puesto where id_puesto=".$row["id"];
			$resultpe = mysqli_query($dbhandle,convertSQL($sqlpe));
			while ($rowpe = mysqli_fetch_array($resultpe)){
				$sqle = "select nombre from sgm_rrhh_empleado where id=".$rowpe["id_empleado"];
				$resulte = mysqli_query($dbhandle,convertSQL($sqle));
				while ($rowe = mysqli_fetch_array($resulte)){
					echo "<tr>";
						echo "<td>".$rowe["nombre"]."</td>";
						echo "<td>".$rowpe["fecha_alta"]."</td>";
						echo "<td>".$rowpe["fecha_baja"]."</td>";
					echo "</tr>";
				}
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 550) AND ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "fecha,fecha_inicio,fecha_fin,numero,nombre,tipo,impartidor,duracion,temario,observaciones,coste,planificado,realizado";
			$datosInsert = array($_POST["fecha"],$_POST["fecha_inicio"],$_POST["fecha_fin"],$_POST["numero"],$_POST["nombre"],$_POST["tipo"],$_POST["impartidor"],$_POST["duracion"],$_POST["temario"],$_POST["observaciones"],$_POST["coste"],$_POST["planificado"],$_POST["realizado"]);
			insertFunction ("sgm_rrhh_formacion",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("fecha","fecha_inicio","fecha_fin","numero","nombre","tipo","impartidor","duracion","temario","observaciones","coste","planificado","realizado");
			$datosUpdate = array($_POST["fecha"],$_POST["fecha_inicio"],$_POST["fecha_fin"],$_POST["numero"],$_POST["nombre"],$_POST["tipo"],$_POST["impartidor"],$_POST["duracion"],$_POST["temario"],$_POST["observaciones"],$_POST["coste"],$_POST["planificado"],$_POST["realizado"]);
			updateFunction ("sgm_rrhh_formacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_formacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "select * from sgm_rrhh_formacion where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposinsert = "fecha,fecha_inicio,fecha_fin,numero,nombre,tipo,impartidor,duracion,temario,observaciones,coste,planificado,realizado";
			$datosInsert = array($row["fecha"],$row["fecha_inicio"],$row["fecha_fin"],$row["numero"],$row["nombre"],$row["tipo"],$row["impartidor"],$row["duracion"],$row["temario"],$row["observaciones"],$row["coste"],$row["planificado"],$row["realizado"]);
			insertFunction ("sgm_rrhh_formacion",$camposinsert,$datosInsert);
		}
		echo "<h4>".$Cursos."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo boton(array("op=1020&sop=550&edit=1"),array($Anadir." ".$Curso));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"100%\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th>".$Eliminar."</th>"; 
							echo "<th>".$Nombre."</th>";
							echo "<th>".$Fecha_Inicio."</th>";
							echo "<th></th>";
							echo "<th></th>";
							echo "<th></th>";
						echo "</tr>";
						$sql = "select * from sgm_rrhh_formacion where visible=1";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)){
							echo "<tr>";
								echo "<td style=\"text-align:center\">";
								$sqlp = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$row["id"];
								$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
								$rowp = mysqli_fetch_array($resultp);
								if ($rowp["total"] == 0){
									echo "<a href=\"index.php?op=1020&sop=551&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
								}
								echo "</td>";
								echo "<td>".$row["nombre"]."</td>";
								echo "<td>".$row["fecha_inicio"]."</td>";
								echo "<form action=\"index.php?op=1020&sop=550&id=".$row["id"]."&edit=2\" method=\"post\">";
									echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Editar."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=550&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Duplicar."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=552&id=".$row["id"]."\" method=\"post\">";
									echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir." ".$Empleados."\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
				echo "<td>";
					if ($_GET["edit"] > 0){
						echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						if ($_GET["edit"] == 1){
							echo "<caption>".$Anadir." ".$Curso."</caption>";
							echo "<form action=\"index.php?op=1020&sop=550&ssop=1\" method=\"post\">";
						}
						if ($_GET["edit"] == 2) {
							echo "<caption>".$Editar." ".$Curso."</caption>";
							echo "<form action=\"index.php?op=1020&sop=550&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
						}
							echo "<tr>";
							if ($_GET["edit"] == 1) { echo "<td></td><td colspan=\"5\"><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100%\"></td>"; }
							if ($_GET["edit"] == 2) { echo "<td></td><td colspan=\"5\"><input type=\"submit\" value=\"".$Editar."\" style=\"width:100%\"></td>"; }
							$sqlx = "select * from sgm_rrhh_formacion where id=".$_GET["id"]."";
							$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
							$rowx = mysqli_fetch_array($resultx);
							echo "</tr><tr>";
								if ($rowx["fecha"] == ""){$date1 = date("Y-m-d");} else {$date1 = $rowx["fecha"];}
								if ($rowx["fecha_inicio"] == ""){$date2 = date("Y-m-d");} else {$date2 = $rowx["fecha_inicio"];}
								if ($rowx["fecha_fin"] == ""){$date3 = date("Y-m-d");} else {$date3 = $rowx["fecha_fin"];}
								echo "<th style=\"text-align:right\">".$Fecha_Prevision."</th><td><input type=\"text\" name=\"fecha\" style=\"width:100px\" value=\"".$date1."\"></td>";
								echo "<th style=\"text-align:right\">".$Fecha_Inicio."</th><td><input type=\"text\" name=\"fecha_inicio\" style=\"width:100px\" value=\"".$date2."\"></td>";
								echo "<th style=\"text-align:right\">".$Fecha_Fin."</th><td><input type=\"text\" name=\"fecha_fin\" style=\"width:100px\" value=\"".$date3."\"></td>";
							echo "</tr><tr>";
								echo "<th style=\"text-align:right\">".$Tipo."</th><td><select name=\"tipo\" style=\"width:100px\">";
									echo "<option value=\"0\">".$Interno."</option>";
									echo "<option value=\"1\">".$Externo."</option>";
								echo "</select></td>";
								echo "<th style=\"text-align:right\">".$Costes."</th><td><input type=\"Text\" name=\"coste\" style=\"width:100px;text-align:right\" value=\"".$rowx["coste"]."\">?</td>";
							echo "</tr><tr>";
								echo "<th style=\"text-align:right\">".$Numero."</th><td colspan=\"5\"><input type=\"text\" name=\"numero\" style=\"width:200px\" value=\"".$rowx["numero"]."\"></td>";
							echo "</tr><tr>";
								echo "<th style=\"text-align:right\">".$Nombre."</th><td colspan=\"5\"><input type=\"text\" name=\"nombre\" style=\"width:200px\" value=\"".$rowx["nombre"]."\"></td>";
							echo "</tr><tr>";
								echo "<th style=\"text-align:right\">".$Impartido_por."</th><td colspan=\"5\"><input type=\"text\" name=\"impartidor\" style=\"width:200px\" value=\"".$rowx["impartidor"]."\"></td>";
							echo "</tr><tr>";
								echo "<th style=\"text-align:right\">".$Duracion." (".$Horas.")</th><td colspan=\"5\"><input type=\"Text\" name=\"duracion\" style=\"width:200px\" value=\"".$rowx["duracion"]."\"></td>";
							echo "</tr><tr>";
								echo "<th style=\"vertical-align:top;text-align:right\">".$Temario."</th><td colspan=\"5\"><textarea rows=\"5\" name=\"temario\" style=\"width:100%\">".$rowx["temario"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<th style=\"vertical-align:top;text-align:right\">".$Observacions."</th><td colspan=\"5\"><textarea rows=\"5\" name=\"observaciones\" style=\"width:100%\">".$rowx["observaciones"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<th  style=\"text-align:right\">".$Planificado."</th><td colspan=\"5\"><select name=\"planificado\" style=\"width:50px\">";
									if ($rowx["planificado"] == 1){
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\" selected>".$Si."</option>";
									}
									if ($rowx["planificado"] == 0){
										echo "<option value=\"0\" selected>".$No."</option>";
										echo "<option value=\"1\">".$Si."</option>";
									}
									echo "</select></td>";
							echo "<tr></tr>";
								echo "<th  style=\"text-align:right\">".$Realizado."</th><td colspan=\"5\"><select name=\"realizado\" style=\"width:50px\">";
									if ($rowx["realizado"] == 1){
										echo "<option value=\"0\">".$No."</option>";
										echo "<option value=\"1\" selected>".$Si."</option>";
									}
									if ($rowx["realizado"] == 0){
										echo "<option value=\"0\" selected>".$No."</option>";
										echo "<option value=\"1\">".$Si."</option>";
									}
									echo "</select></td>";
							echo "<tr></tr>";
								if ($_GET["edit"] == 1) { echo "<td></td><td colspan=\"5\"><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100%\"></td>"; }
								if ($_GET["edit"] == 2) { echo "<td></td><td colspan=\"5\"><input type=\"submit\" value=\"".$Editar."\" style=\"width:100%\"></td></tr>"; }
								echo "</form>";
							echo "</tr>";
						echo "</table>";
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 551) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=550&ssop=3&id=".$_GET["id"],"op=1020&sop=550&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 552) AND ($admin == true)) {
		if ($ssoption == 1) {
			$sqlt2 = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"]." and id_empleado=".$_POST["id_empleado"];
			$resultt2 = mysqli_query($dbhandle,convertSQL($sqlt2));
			$rowt2 = mysqli_fetch_array($resultt2);
			if ($rowt2["total"] == 0) {
				$camposinsert = "id_empleado,id_curso";
				$datosInsert = array($_POST["id_empleado"],$_GET["id"]);
				insertFunction ("sgm_rrhh_formacion_empleado",$camposinsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$sqlp = "select id from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$_POST["id_departamento"];
			$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
			while ($rowp = mysqli_fetch_array($resultp)){
				$sql = "select id_empleado,fecha_baja from sgm_rrhh_empleado_puesto where visible=1 and id_puesto=".$rowp["id"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				$sqlt2 = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"]." and id_empleado=".$row["id_empleado"];
				$resultt2 = mysqli_query($dbhandle,convertSQL($sqlt2));
				$rowt2 = mysqli_fetch_array($resultt2);
				if ($rowt2["total"] == 0) {
					if ($row["fecha_baja"] == '0000-00-00') {
						$camposinsert = "id_empleado,id_curso";
						$datosInsert = array($row["id_empleado"],$_GET["id"]);
						insertFunction ("sgm_rrhh_formacion_empleado",$camposinsert,$datosInsert);
					}
				}
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_formacion_empleado set visible=0 WHERE id_curso=".$_GET["id"]." and id_empleado=".$_GET["id_empleado"];
			mysqli_query($dbhandle,convertSQL($sql));
#			echo $sql;
		}
		$sqlf = "select nombre from sgm_rrhh_formacion where visible=1 and id=".$_GET["id"];
		$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
		$rowf = mysqli_fetch_array($resultf);
		echo "<h4>".$Anadir." ".$Empleados." : ".$rowf["nombre"]."</h4>";
		echo boton(array("op=1020&sop=550"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"5\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th>".$Empleados."</th>";
							echo "<form action=\"index.php?op=1020&sop=552&ssop=1&id=".$_GET["id"]."\" method=\"POST\">";
							echo "<td><select name=\"id_empleado\" style=\"width:200px\">";
								echo "<option value=\"0\">-</option>";
								$sql = "select id,nombre from sgm_rrhh_empleado where visible=1";
								$result = mysqli_query($dbhandle,convertSQL($sql));
								while ($row = mysqli_fetch_array($result)){
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
								}
							echo "</select></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
							echo "</form>";
						echo "</tr><tr>";
							echo "<th>".$Departamentos."</th>";
							echo "<form action=\"index.php?op=1020&sop=552&ssop=2&id=".$_GET["id"]."\" method=\"POST\">";
							echo "<td><select name=\"id_departamento\" style=\"width:200px\">";
								echo "<option value=\"0\">-</option>";
								$sqld = "select id,departamento from sgm_rrhh_departamento where visible=1";
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								while ($rowd = mysqli_fetch_array($resultd)){
									echo "<option value=\"".$rowd["id"]."\">".$rowd["departamento"]."</option>";
								}
							echo "</select></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"width:50px;\"></td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Empleados."</th>";
						echo "</tr>";
						$sqle = "select id,nombre from sgm_rrhh_empleado where visible=1 and id in (select id_empleado from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"].")";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						while ($rowe = mysqli_fetch_array($resulte)){
							echo "<tr>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=553&id=".$_GET["id"]."&id_empleado=".$rowe["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<td>".$rowe["nombre"]."</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if (($soption == 553) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=552&ssop=3&id=".$_GET["id"]."&id_empleado=".$_GET["id_empleado"],"op=1020&sop=552&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	echo "</td></tr></table><br>";

}


function busca_puesto($id)
{
	global $db,$dbhandle;
	$sqlp = "select id from sgm_rrhh_empleado_puesto where visible=1 and fecha_baja='0000-00-00' and id_puesto in (select id from sgm_rrhh_puesto_trabajo where visible=1 and activo=1 and id=".$id.")";
	$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
	while ($rowp = mysqli_fetch_array($resultp)){
		if ($rowp){
			return 1;
		} else {
			return 0;
		}
	}
}
function busca_departamentos($id,$emple)
{ 
	global $db,$dbhandle;
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;\">";
		echo "<tr>";
		$sql = "select id,departamento from sgm_rrhh_departamento where visible=1 and id_departamento=".$id." order by departamento";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)){
			echo "<td style=\";vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;border-right:1px solid black;border-left:1px solid black\">";
					echo "<tr><th style=\"text-align:center;\">".$row["departamento"]."</th></tr>";
					echo "<tr><td>&nbsp;</td></tr>";
					if ($emple == 1){
						$sqlp = "select id,puesto from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$row["id"]." order by puesto";
						$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
						while ($rowp = mysqli_fetch_array($resultp)){
							$sqle = "select nombre from sgm_rrhh_empleado where visible=1 and id=(select id_empleado from sgm_rrhh_empleado_puesto where visible=1 and id_puesto=".$rowp["id"]." and fecha_baja= '0000-00-00')";
							$resulte = mysqli_query($dbhandle,convertSQL($sqle));
							$rowe = mysqli_fetch_array($resulte);
							echo "<tr><td style=\"text-align:center;\">".$rowp["puesto"]."&nbsp;:&nbsp;".$rowe["nombre"]."</td></tr>";
						}
					echo "<tr><td>&nbsp;</td></tr>";
					}
					echo "<tr>";
						echo "<td>";
							busca_departamentos($row["id"]);
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		}
		echo "</tr>";
	echo "</table>";
}

function dif_dias_fechas($data1,$data2)
{ 
	global $db,$dbhandle;
	$data_1 = $data1;
	$dif_dias = 0;
	if ($data2 > 0) {
		while ($data_1 < $data2){
			$comprobar += comprobarFestivo($data_1);
			$data_1 = sumaDies($data_1,1);
		}
		$dif = ($data2-$data1);
		$dif_dias = intval($dif/24/60/60)-$comprobar;
	}
	return $dif_dias+1;
}


function comprobarFestivo($fecha)
{
	global $db,$dbhandle;
	$festivo=0;
	$dia_sem = date("w", ($fecha));
	if ($dia_sem == 0){
		$festivo=1;
	}
	if ($dia_sem == 6){
		$festivo=1;
	}
	$sqlc = "select * from sgm_calendario where dia=".date("j", ($fecha))." and mes=".date("n", ($fecha))." and ano=".date("Y", ($fecha))."";
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);
	if ($rowc){
		$festivo=1;
	}
#	echo $festivo."<br>";
	return $festivo;
}

?>
