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
			if ($_GET["grup"] == 1){
				if (($soption == 30) or ($soption == 31)) {$color = "white"; $lcolor = "#4B53AF";} else {$color = "#4B53AF"; $lcolor = "white";}
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1020&sop=30&grup=1\" style=\"color: ".$lcolor."\">Organigrama</a></td>";
				if ($soption == 90) {$color = "white"; $lcolor = "#4B53AF";} else {$color = "#4B53AF"; $lcolor = "white";}
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1020&sop=90&grup=1\" style=\"color: ".$lcolor."\">Plantilla Actual</a></td>";
				if ($soption == 110) {$color = "white"; $lcolor = "#4B53AF";} else {$color = "#4B53AF"; $lcolor = "white";}
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1020&sop=110&grup=1\" style=\"color: ".$lcolor."\">Horarios</a></td>";
			}
			if ($_GET["grup"] == 2){
				if ($soption == 10) {$color = "white"; $lcolor = "#4B53AF";} else {$color = "#4B53AF"; $lcolor = "white";}
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1020&sop=10&grup=2\" style=\"color: ".$lcolor."\">Bolsa de Trabajadores</a></td>";
				if (($soption == 1) or ($soption == 2)) {$color = "white"; $lcolor = "#4B53AF";} else {$color = "#4B53AF"; $lcolor = "white";}
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1020&sop=1&grup=2\" style=\"color: ".$lcolor."\">Ofertas de Trabajo</a></td>";
			}
			echo "</tr></table></center>";
	echo "</table><br>";
	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 3) {
			mysql_query(convert_sql($sql));
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
							$resultt = mysql_query(convert_sql($sqlt));
							while ($rowt = mysql_fetch_array($resultt)){
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
							$resultg = mysql_query(convert_sql($sqlg));
							while ($rowg = mysql_fetch_array($resultg)){
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
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
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
					echo "<td colspan=\"3\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:550px\"></td>";
				echo "</form>";
				echo "</tr>";
			} else {
				echo "<tr>";
					echo "<td>";
					for ($i = 0; $i <= 127; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							$sqlxt = "select count(*) as total from sgm_rrhh_empleado where visible=1 and nombre like '".chr($i)."%'  order by nombre";
							$resultxt = mysql_query(convert_sql($sqlxt));
							$rowxt = mysql_fetch_array($resultxt);
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
							$sql .= "select id_empleado from sgm_rrhh_puesto_empleado where visible=1 ";
							if ($_POST["id_puesto"] > 0) { $sql .= " and id_puesto=".$_POST["id_puesto"]; }
							elseif ($_POST["id_departamento"] > 0) { $sql .= " and id_puesto in (select id from sgm_rrhh_puesto_trabajo where id_departamento=".$_POST["id_departamento"].")"; }
							$sql .= ")";
						}
						if ($_POST["id_cliente"] > 0) { $sql .= " and id_usuario in (select id_user from sgm_users_clients where id_client=".$_POST["id_cliente"].")"; }
#						echo $sql;
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($contador==0){
								echo "<tr style=\"background-color: Silver;\">";
									echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\">".chr($i)."</a></th>";
									echo "<th>".$Nombre."</th>";
									echo "<th>".$Puesto_trabajo."/".$Departamento."</th>";
								echo "</tr>";
								$contador++;
							}
							if ($cambio == 0) { $color = "white"; $cambio = 1; } else { $color = "#F5F5F5"; $cambio = 0; }
							echo "<tr style=\"background-color:".$color."\">";
								if ((valida_nif_cif_nie($row["nif"]) <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
									echo "<td style=\"vertical-align:top\"><img src=\"mgestion/pics/icons-mini/page_white_error.png\" alt=\"ERROR\" border=\"0\"></td>";
								} else { 
									echo "<td></td>"; 
								}
								echo "<td style=\"width:300px;vertical-align:top\"><a href=\"index.php?op=1020&sop=100&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
								echo "<td><table>";
								$sqlpe = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_empleado=".$row["id"];
								$resultpe = mysql_query(convert_sql($sqlpe));
								$rowpe = mysql_fetch_array($resultpe);
								$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id in (select id_puesto from sgm_rrhh_puesto_empleado where visible=1 and id_empleado=".$row["id"].")";
								$resultp = mysql_query(convert_sql($sqlp));
								while ($rowp = mysql_fetch_array($resultp)){
									$sqld = "select * from sgm_rrhh_departamento where visible=1 and id=".$rowp["id_departamento"];
									$resultd = mysql_query(convert_sql($sqld));
									$rowd = mysql_fetch_array($resultd);
									echo "<tr><td style=\"width:150px;\">".$rowp["puesto"]."</td><td>".$rowd["departamento"]."</td></tr>";
								}
								echo "</table></td>";
							echo "</tr>";
						}
					}
				}
			}
			echo "</table>";
		}
	}
	if (($soption >= 100) and ($soption < 200) and  ($_GET["id"] != 0)) {
		if (($soption == 100) and ($ssoption == 1)) {
			$camposInsert="num_ins_segsoc,num_afil_segsoc,id_usuario,entidadbancaria,domiciliobancario,cuentabancaria,fecha_baja,fecha_incor,nombre,nif,direccion,poblacion,cp,provincia,id_pais,mail,telefono,telefono2,fax,fax2,notas";
			$datosInsert = array($_POST["num_ins_segsoc"],$_POST["num_afil_segsoc"],$_POST["id_usuario"],$_POST["entidadbancaria"],$_POST["domiciliobancario"],$_POST["cuentabancaria"],$_POST["fecha_baja"],$_POST["fecha_incor"],$_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["fax"],$_POST["fax2"],$_POST["notas"]);
			insertFunction ("sgm_rrhh_empleado",$camposInsert,$datosInsert);
			$sql = "select id from sgm_rrhh_empleado where visible=1 and nombre='".$_POST["nombre"]."' and nif='".$_POST["nif"]."' order by id desc";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$id_empleado = $row["id"];
		} else {
			$id_empleado = $_GET["id"];
		}
		if (($soption == 100) and ($ssoption == 2)) {
			$camposUpdate = array('num_ins_segsoc','num_afil_segsoc','id_usuario','entidadbancaria','domiciliobancario','cuentabancaria','fecha_baja','fecha_incor','nombre','nif','direccion','poblacion','cp','provincia','id_pais','mail','telefono','telefono2','fax','fax2','notas');
			$datosUpdate = array($_POST["num_ins_segsoc"],$_POST["num_afil_segsoc"],$_POST["id_usuario"],$_POST["entidadbancaria"],$_POST["domiciliobancario"],$_POST["cuentabancaria"],$_POST["fecha_baja"],$_POST["fecha_incor"],$_POST["nombre"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["fax"],$_POST["fax2"],$_POST["notas"]);
			updateFunction("sgm_rrhh_empleado",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		$sql = "select * from sgm_rrhh_empleado where id=".$id_empleado;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
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
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=140&id=".$row["id"]."\" style=\"color:white;\">".$Contratos."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\" style=\"color:white;\">".$Nominas."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1020&sop=160&id=".$row["id"]."\" style=\"color:white;\">".$Dias_festivos."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:400px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]."</strong></a>";
					echo "<br>".$row["nif"];
					echo "<br><strong>".$row["direccion"]."</strong>";
					if ($row["cp"] != "") {echo " (".$row["cp"].")";}
					echo "<strong> ".$row["poblacion"]."</strong>";
					if ($row["provincia"] != "") {echo " (".$row["provincia"].")";}
					if ($row["telefono"] != "") { echo "<br>Tel�fono : <strong>".$row["telefono"]."</strong>"; }
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
			$resultem = mysql_query(convert_sql($sqlem));
			$rowem = mysql_fetch_array($resultem);
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
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Nombre.":</th><td><input type=\"Text\" name=\"nombre\" value=\"".$rowem["nombre"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$NIF.": </th><td><input type=\"Text\" name=\"nif\" value=\"".$rowem["nif"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Num_ins_segsoc.": </th><td><input type=\"Text\" name=\"num_ins_segsoc\" value=\"".$rowem["num_ins_segsoc"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Num_afil_segsoc.": </th><td><input type=\"Text\" name=\"num_afil_segsoc\" value=\"".$rowem["num_afil_segsoc"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;;vertical-align:top;\">".$Direccion.": </th><td><textarea name=\"direccion\" rows=\"2\" style=\"width:350px\">".$row["direccion"]."</textarea></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$CP.": </th><td><input type=\"Text\" name=\"cp\" value=\"".$rowem["cp"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Poblacion.": </th><td><input type=\"Text\" name=\"poblacion\" value=\"".$rowem["poblacion"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr style=\"background-color:Silver;\"><th style=\"text-align:right;\">".$Provincia.": </th><td><input type=\"Text\" name=\"provincia\" value=\"".$rowem["provincia"]."\" style=\"width:350px\"></td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td></td><th>".$Datos." SIMges: </th><tr>";
						echo "<tr><th style=\"text-align:right;\">".$Usuario.": </th><td>";
							echo "<select name=\"id_usuario\" style=\"width:350px;\">";
							echo "<option value=\"0\">-</option>";
							$sqlu = "select * from sgm_users where validado=1 and activo=1 and sgm=1 order by usuario";
							$resultu = mysql_query(convert_sql($sqlu));
							while ($rowu = mysql_fetch_array($resultu)) {
								if ($rowem["id_usuario"] == $rowu["id"]){
									echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
								} else {
									echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
								}
							}
						echo "</td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"width:50px;\"></td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><td></td><th>".$Datos_Adicionales."</th></tr>";
						echo "<tr><th style=\"text-align:right;\">".$Pais.": </th><td colspan=\"3\">";
							echo "<select name=\"id_pais\" style=\"width:350px;\">";
							echo "<option value=\"0\">-</option>";
							$sqlo = "select * from sgm_paises where visible=1 order by pais";
							$resulto = mysql_query(convert_sql($sqlo));
							while ($rowo = mysql_fetch_array($resulto)) {
								if ($_GET["id"] == 0){
									if ($rowo["predeterminado"] == 1){
										echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["pais"]."</option>";
									}
								} elseif ($rowem["id_pais"] == $rowo["id"]){
										echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["pais"]."</option>";
								} else {
									echo "<option value=\"".$rowo["id"]."\">".$rowo["pais"]."</option>";
								}
							}
						echo "</td></tr>";
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
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td></td><th>".$Datos_Bancarios." : </th><tr>";
							echo "<th>".$Entidad.": </th>";
							echo "<td colspan=\"3\"><input type=\"text\" name=\"entidadbancaria\" style=\"width:350px\" value=\"".$rowem["entidadbancaria"]."\"></td>";
						echo "</tr><tr>";
							echo "<th>".$Direccion.": </th>";
							echo "<td colspan=\"3\"><input type=\"Text\" name=\"domiciliobancario\" style=\"width:350px\" value=\"".$rowem["domiciliobancario"]."\"></td>";
						echo "</tr><tr>";
							echo "<th>IBAN : </th>";
							echo "<td colspan=\"3\"><input type=\"Text\" name=\"cuentabancaria\" style=\"width:350px\" value=\"".$rowem["cuentabancaria"]."\"></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			if ($_GET["id"] > 0) { echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100%\"></td></tr>"; }
			if ($_GET["id"] == 0) {	echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100%\"></td></tr>";	}
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
		if ($ssoption == 1) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				$archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
				$tipo = $_POST["id_tipo"];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
				$tipo = $HTTP_POST_VARS["id_tipo"];
			}
			echo subirArchivo($tipo,$archivo,$archivo_name,$archivo_size,$archivo_type,6,$_GET["id"]);
		}
		if ($ssoption == 2) {
			$sqlf = "select name from sgm_files where id=".$_GET["id_archivo"];
			$resultf = mysql_query(convert_sql($sqlf));
			$rowf = mysql_fetch_array($resultf);
			deleteFunction ("sgm_files",$_GET["id_archivo"]);
			$filepath = "archivos/empleados/".$rowf["name"];
			unlink($filepath);
		}

		echo "<h4>".$Archivos."</h4>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr>";
					echo "<td style=\"width:50%;vertical-align:top;\">";
						echo "<h4>".$Archivos." :</h4>";
						echo "<table>";
						$sql = "select * from sgm_files_tipos order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=6 and id_elemento=".$_GET["id"];
							$resultele = mysql_query(convert_sql($sqlele));
							while ($rowele = mysql_fetch_array($resultele)) {
								echo "<tr>";
									echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=111&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
									echo "<td style=\"text-align:right;\">".$row["nombre"]."</td>";
									echo "<td><a href=\"".$urloriginal."/archivos/empleados/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
									echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "</tr>";
							}
						}
						echo "</table>";
					echo "</td><td style=\"width:50%;vertical-align:top;\">";
						echo "<h4>".$Formulario_Subir_Archivo." :</h4>";
						echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1020&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
						echo "<table>";
							echo "<tr>";
								echo "<td><select name=\"id_tipo\" style=\"width:300px\">";
									$sql = "select * from sgm_files_tipos order by nombre";
									$result = mysql_query(convert_sql($sql));
									while ($row = mysql_fetch_array($result)) {
										echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
									}
								echo "</select></td>";
							echo "</tr>";
							echo "<tr><td><input type=\"file\" name=\"archivo\" size=\"30px\"></td></tr>";
							echo "<tr><td><input type=\"submit\" value=\"Enviar a la carpeta /archivos/empleados/\" style=\"width:300px\"></td></tr>";
						echo "</table>";
						echo "</form>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "<br><br>";
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
			$sqlc = "select * from sgm_rrhh_formacion_empleado where id_empleado=".$_GET["id"]." and visible=1";
			$resultc = mysql_query(convert_sql($sqlc));
			while ($rowc = mysql_fetch_array($resultc)){
				$sqlf = "select * from sgm_rrhh_formacion where id=".$rowc["id_curso"];
				$resultf = mysql_query(convert_sql($sqlf));
				while ($rowf = mysql_fetch_array($resultf)){
					echo "<tr>";
						echo "<td>".$rowf["nombre"]."</td>";
						echo "<td>".$rowf["fecha_inicio"]."</td>";
						echo "<td>".$rowf["fecha_fin"]."</td></tr>";
				}
			}
		echo "</table>";
		echo "<br>";
	}
	if ($soption == 130){
		if (($_POST["data_ini"] > $_POST["data_fi"]) or ($_POST["hora_ini"] > $_POST["hora_fi"]) or ($_POST["hora_ini2"] > $_POST["hora_fi2"])){
			echo mensaje_error($ErrorEmpleadoHorario);
		} else {
			if ($ssoption == 1) {
				$camposinsert = "id_empleado,data_ini,data_fi,hora_ini,hora_fi,hora_ini2,hora_fi2";
				$datosInsert = array($_GET["id"],$_POST["data_ini"],$_POST["data_fi"],$_POST["hora_ini"],$_POST["hora_fi"],$_POST["hora_ini2"],$_POST["hora_fi2"]);
				insertFunction ("sgm_rrhh_empleado_horario",$camposinsert,$datosInsert);
			}
			if ($ssoption == 2) {
				$camposUpdate = array("data_ini","data_fi","hora_ini","hora_fi","hora_ini2","hora_fi2");
				$datosUpdate = array($_POST["data_ini"],$_POST["data_fi"],$_POST["hora_ini"],$_POST["hora_fi"],$_POST["hora_ini2"],$_POST["hora_fi2"]);
				updateFunction ("sgm_rrhh_empleado_horario",$_GET["id_horari"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_empleado_horario",$_GET["id_horari"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Horarios."</h4>";
		$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$_GET["id"];
		$resulte = mysql_query(convert_sql($sqle));
		$rowe = mysql_fetch_array($resulte);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Fecha_Inicio."</th>";
				echo "<th>".$Fecha_Fin."</th>";
				echo "<th>".$Hora_Inicio."</th>";
				echo "<th>".$Hora_Fin."</th>";
				echo "<th>".$Hora_Inicio." 2</th>";
				echo "<th>".$Hora_Fin." 2</th>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1020&sop=130&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"data_ini\" style=\"width:100px;\" value=\"".date("Y-m-d")."\"></td>";
				echo "<td><input type=\"text\" name=\"data_fi\" style=\"width:100px;\" value=\"0000-00-00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_ini\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_fi\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_ini2\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_fi2\" style=\"width:70px;\" value=\"00:00\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$fecha = date("Y-m-d");
			$sql = "select * from sgm_rrhh_empleado_horario where visible=1 and id_empleado=".$_GET["id"]." order by data_ini desc";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				$color = "white";
				if (($fecha >= $row["data_ini"]) and ($fecha <= $row["data_fi"])) { $color = "green"; }
				echo "<tr style=\"background-color:".$color."\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=131&id=".$_GET["id"]."&id_horari=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1020&sop=130&ssop=2&id=".$_GET["id"]."&id_horari=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" name=\"data_ini\" style=\"width:100px;\" value=\"".$row["data_ini"]."\"></td>";
					echo "<td><input type=\"text\" name=\"data_fi\" style=\"width:100px;\" value=\"".$row["data_fi"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_ini\" style=\"width:70px;\" value=\"".$row["hora_ini"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_fi\" style=\"width:70px;\" value=\"".$row["hora_fi"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_ini2\" style=\"width:70px;\" value=\"".$row["hora_ini2"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_fi2\" style=\"width:70px;\" value=\"".$row["hora_fi2"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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
		echo "<h4>".$Contratos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th style=\"width:300px\">".$Puesto_trabajo."</th>";
				echo "<th style=\"width:100px\">".$Fecha_Alta."</th>";
				echo "<th style=\"width:100px\">".$Fecha_Baja."</th>";
			echo "</tr>";
			$sqlpe = "select * from sgm_rrhh_puesto_empleado where id_empleado=".$_GET["id"]." and visible=1";
			$resultpe = mysql_query(convert_sql($sqlpe));
			while ($rowpe = mysql_fetch_array($resultpe)){
				$sqle = "select * from sgm_rrhh_puesto_trabajo where id=".$rowpe["id_puesto"];
				$resulte = mysql_query(convert_sql($sqle));
				while ($rowe = mysql_fetch_array($resulte)){
					echo "<tr>";
						echo "<td>".$rowe["puesto"]."</td>";
						echo "<td>".$rowpe["fecha_alta"]."</td>";
						echo "<td>".$rowpe["fecha_baja"]."</td>";
					echo "</tr>";
				}
			}
		echo "</table>";
	}

	if ($soption == 150) {
		if (date(U,strtotime($_POST["data_ini"])) > date(U,strtotime($_POST["data_fi"]))) {
			echo mensaje_error($ErrorEmpleadoCalendario);
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
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_rrhh_empleado_nominas where id_empleado=".$_GET["id"]." order by data_ini";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
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
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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
		if (($_POST["data_fi"] != '') and ($_POST["data_ini"] > $_POST["data_fi"])) {
			echo mensaje_error($ErrorEmpleadoCalendario);
		} else {
			if ($ssoption == 1) {
				$camposInsert = "id_empleado,data_ini,data_fi,motivo";
				$datosInsert = array($_GET["id"],date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])),$_POST["motivo"]);
				insertFunction ("sgm_rrhh_empleado_calendario",$camposInsert,$datosInsert);
			}
			if ($ssoption == 2){
				$camposUpdate = array("data_ini","data_fi","motivo");
				$datosUpdate = array(date(U,strtotime($_POST["data_ini"])),date(U,strtotime($_POST["data_fi"])),$_POST["motivo"]);
				updateFunction ("sgm_rrhh_empleado_calendario",$_GET["id_dia"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_rrhh_empleado_calendario",$_GET["id_dia"]);
		}
		echo "<h4>".$Dias_festivos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Desde."</th>";
				echo "<th>".$Hasta." (".$Opcional.")</th>";
				echo "<th>".$Motivo."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1020&sop=160&ssop=1&id=".$_GET["id"]."&id_dia=".$row["id"]."\" method=\"post\">";
				echo "<td><input name=\"data_ini\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y')."\"></td>";
				echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\"></td>";
				echo "<td><input name=\"motivo\" type=\"Text\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_rrhh_empleado_calendario where id_empleado=".$_GET["id"]." order by data_ini";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1020&sop=160&ssop=2&id=".$_GET["id"]."&id_dia=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1020&sop=161&id=".$_GET["id"]."&id_dia=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input name=\"data_ini\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',$row["data_ini"])."\"></td>";
					if ($row["data_fi"] > 0) {
						echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\" value=\"".date('d-m-Y',$row["data_fi"])."\"></td>";
					} else {
						echo "<td><input name=\"data_fi\" type=\"Text\" style=\"width:100px\"></td>";
					}
					echo "<td><input name=\"motivo\" type=\"Text\" style=\"width:150px\" value=\"".$row["motivo"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 161) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=160&ssop=3&id=".$_GET["id"]."&id_dia=".$_GET["id_dia"],"op=1020&sop=160&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
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
			echo boton(array("op=1020&sop=510","op=1020&sop=520","op=1020&sop=530","op=1020&sop=540","op=1020&sop=550"),array($Calendario." ".$$Laboral,$Horarios,$Departamentos,$Puestos_trabajo,$Cursos));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}
	if (($soption == 510) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "dia,mes,descripcio";
			$datosInsert = array($_POST["dia"],$_POST["mes"]+1,$_POST["descripcio"]);
			insertFunction ("sgm_calendario",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			deleteFunction ("sgm_calendario",$_GET["id"]);
		}
		echo "<h4>".$Calendario." ".$$Laboral."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Dia."</th>";
				echo "<th>".$Mes."</th>";
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
				echo "<td><input name=\"descripcio\" type=\"Text\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_calendario order by mes, dia";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1020&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td>".$row["dia"]."</td>";
					echo "<td>".$meses[$row["mes"]-1]."</td>";
					echo "<td>".$row["descripcio"]."</td>";
					echo "<td></td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 511) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1020&sop=510&ssop=2&id=".$_GET["id"],"op=1020&sop=510"),array($Si,$No));
		echo "</center>";
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
		echo "<h4>".$Horarios."</h4>";
		echo boton(array("op=1020&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Dia."</th>";
				echo "<th>".$Hora_Inicio."</th>";
				echo "<th>".$Hora_Fin."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sql = "select * from sgm_calendario_horario order by id";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$hora_ini = $row["hora_inicio"]/3600;
				$hora_fi = $row["hora_fin"]/3600;
				echo "<tr>";
				echo "<form action=\"index.php?op=1020&sop=520&ssop=1&id=".$row["id"]."\" method=\"post\">";
					echo "<td>".$row["dia"]."</td>";
					echo "<td><input name=\"hora_inicio\" type=\"number\" min=\"1\" value=\"".$hora_ini."\" style=\"width:60px\"></td>";
					echo "<td><input name=\"hora_fin\" type=\"number\" min=\"1\" value=\"".$hora_fi."\" style=\"width:60px\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
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
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)){
						echo "<option value=\"".$row["id"]."\">".$row["departamento"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"text\" name=\"departamento\" style=\"width:200px\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
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
						$resultd = mysql_query(convert_sql($sqld));
						while ($rowd = mysql_fetch_array($resultd)){
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
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				boton_form("op=1020&sop=535&id=".$row["id"],$Puestos_trabajo);
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
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id_puesto"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id_puesto"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "select * from sgm_rrhh_puesto_trabajo where id=".$_GET["id_puesto"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$camposinsert = "id_departamento,puesto,tareas,f_general,f_especifica,experiencia,habilidades,activo";
			$datosInsert = array($row["id_departamento"],$row["puesto"],$row["tareas"],$row["f_general"],$row["f_especifica"],$row["experiencia"],$row["habilidades"],$row["activo"]);
			insertFunction ("sgm_rrhh_puesto_trabajo",$camposinsert,$datosInsert);
		}
		if ($ssoption == 5) {
			$camposUpdate = array("activo");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id_puesto"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			$camposUpdate = array("activo");
			$datosUpdate = array("1");
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id_puesto"],$camposUpdate,$datosUpdate);
		}
		$sql = "select * from sgm_rrhh_departamento where visible=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
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
							echo "<th>".$Empleado." ".$Actual."</th>";
							echo "<th></th>";
							echo "<th></th>";
							echo "<th></th>";
							echo "<th></th>";
						echo "</tr>";
						$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 order by puesto";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)){
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
								$sqlp = "select * from sgm_rrhh_empleado where id=(select id_empleado from sgm_rrhh_puesto_empleado where visible=1 and fecha_baja='0000-00-00' and id_puesto=".$row["id"].")";
								$resultp = mysql_query(convert_sql($sqlp));
								$rowp = mysql_fetch_array($resultp);
								echo "<td style=\"text-align:left;\"><a href=\"index.php?op=1020&sop=100&id=".$rowp["id"]."\">".$rowp["nombre"]."</a></td>";
								echo "<form action=\"index.php?op=1020&sop=540&id=".$_GET["id"]."&id_puesto=".$row["id"]."&edit=2\" method=\"post\">";
									echo "<td><input type=\"Submit\" value=\"".$Editar."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=542&id=".$_GET["id"]."&id_puesto=".$row["id"]."\" method=\"post\">";
									echo "<td><input type=\"Submit\" value=\"".$Historico."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=540&ssop=4&id=".$_GET["id"]."&id_puesto=".$row["id"]."\" method=\"post\">";
									echo "<td><input type=\"Submit\" value=\"".$Duplicar."\"></td>";
								echo "</form>";
								if ($row["activo"] == 1) {
									echo "<form action=\"index.php?op=1020&sop=540&ssop=5&id=".$_GET["id"]."&id_puesto=".$row["id"]."\" method=\"post\">";
										echo "<td><input type=\"Submit\" value=\"".$Desactivar."\"></td>";
									echo "</form>";
								} else {
									echo "<form action=\"index.php?op=1020&sop=540&ssop=6&id=".$_GET["id"]."&id_puesto=".$row["id"]."\" method=\"post\">";
										echo "<td><input type=\"Submit\" value=\"".$Activar."\"></td>";
									echo "</form>";
								}
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
				echo "<td>";
					if ($_GET["edit"] > 0){
						echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						if ($_GET["edit"] == 1){
							echo "<caption>".$Anadir." ".$Puesto."</caption>";
							echo "<form action=\"index.php?op=1020&sop=540&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
						}
						if ($_GET["edit"] == 2) {
							echo "<caption>".$Editar." ".$Puesto."</caption>";
							echo "<form action=\"index.php?op=1020&sop=540&ssop=2&id=".$_GET["id"]."&id_puesto=".$row["id"]."\" method=\"post\">";
						}
							$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id=".$_GET["id_puesto"]."";
							$result = mysql_query(convert_sql($sql));
							$row = mysql_fetch_array($result);
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
										$sqld = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
										$resultd = mysql_query(convert_sql($sqld));
										while ($rowd = mysql_fetch_array($resultd)){
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

	if (($soption == 541) AND ($admin == true)) {
		echo boton(array("op=1020&sop=540&id=".$_GET["id"]),array("&laquo; ".$Volver));
		$sql = "select * from sgm_rrhh_puesto_trabajo where id=".$_GET["id_puesto"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<h4>".$Puesto_trabajo." : ".$row["puesto"]."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Nombre." ".$Empleado."</th>";
				echo "<th>".$Fecha." ".$Alta."</th>";
				echo "<th>".$Fecha." ".$Baja."</th>";
			echo "</tr>";
			$sqlpe = "select * from sgm_rrhh_puesto_empleado where id_puesto=".$row["id"];
			$resultpe = mysql_query(convert_sql($sqlpe));
			while ($rowpe = mysql_fetch_array($resultpe)){
				$sqle = "select * from sgm_rrhh_empleado where id=".$rowpe["id_empleado"];
				$resulte = mysql_query(convert_sql($sqle));
				while ($rowe = mysql_fetch_array($resulte)){
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
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
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
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)){
							echo "<tr>";
								echo "<td style=\"text-align:center\">";
								$sqlp = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$row["id"];
								$resultp = mysql_query(convert_sql($sqlp));
								$rowp = mysql_fetch_array($resultp);
								if ($rowp["total"] == 0){
									echo "<a href=\"index.php?op=1020&sop=551&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
								}
								echo "</td>";
								$sqlpl = "select * from sgm_rrhh_formacion_plan where visible=1 and id=".$row["id_plan"];
								$resultpl = mysql_query(convert_sql($sqlpl));
								$rowpl = mysql_fetch_array($resultpl);
								echo "<td>".$row["nombre"]."</td>";
								echo "<td>".$row["fecha_inicio"]."</td>";
								echo "<form action=\"index.php?op=1020&sop=550&id=".$row["id"]."&edit=2\" method=\"post\">";
									echo "<td><input type=\"Submit\" value=\"".$Editar."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=550&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<td><input type=\"Submit\" value=\"".$Duplicar."\"></td>";
								echo "</form>";
								echo "<form action=\"index.php?op=1020&sop=552&id=".$row["id"]."\" method=\"post\">";
									echo "<td><input type=\"Submit\" value=\"".$Anadir." ".$Empleados."\"></td>";
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
							$resultx = mysql_query(convert_sql($sqlx));
							$rowx = mysql_fetch_array($resultx);
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
			$resultt2 = mysql_query(convert_sql($sqlt2));
			$rowt2 = mysql_fetch_array($resultt2);
			if ($rowt2["total"] == 0) {
				$camposinsert = "id_empleado,id_curso";
				$datosInsert = array($_POST["id_empleado"],$_GET["id"]);
				insertFunction ("sgm_rrhh_formacion_empleado",$camposinsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$_POST["id_departamento"];
			$resultp = mysql_query(convert_sql($sqlp));
			while ($rowp = mysql_fetch_array($resultp)){
				$sql = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$sqlt2 = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"]." and id_empleado=".$row["id_empleado"];
				$resultt2 = mysql_query(convert_sql($sqlt2));
				$rowt2 = mysql_fetch_array($resultt2);
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
			mysql_query(convert_sql($sql));
#			echo $sql;
		}
		$sqlf = "select * from sgm_rrhh_formacion where visible=1 and id=".$_GET["id"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
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
								$sql = "select * from sgm_rrhh_empleado where visible=1";
								$result = mysql_query(convert_sql($sql));
								while ($row = mysql_fetch_array($result)){
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
								}
							echo "</select></td>";
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
							echo "</form>";
						echo "</tr><tr>";
							echo "<th>".$Departamentos."</th>";
							echo "<form action=\"index.php?op=1020&sop=552&ssop=2&id=".$_GET["id"]."\" method=\"POST\">";
							echo "<td><select name=\"id_departamento\" style=\"width:200px\">";
								echo "<option value=\"0\">-</option>";
								$sqld = "select * from sgm_rrhh_departamento where visible=1";
								$resultd = mysql_query(convert_sql($sqld));
								while ($rowd = mysql_fetch_array($resultd)){
									echo "<option value=\"".$rowd["id"]."\">".$rowd["departamento"]."</option>";
								}
							echo "</select></td>";
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
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
						$sql = "select * from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"];
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)){
							$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$row["id_empleado"];
							$resulte = mysql_query(convert_sql($sqle));
							while ($rowe = mysql_fetch_array($resulte)){
								echo "<tr>";
									echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=553&id=".$_GET["id"]."&id_empleado=".$rowe["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
									echo "<td>".$rowe["nombre"]."</td>";
								echo "</tr>";
							}
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


function busca_puesto($iddep)
{
	global $db;
		$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 and activo=1 and id_departamento=".$iddep;
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			$sqlp = "select * from sgm_rrhh_puesto_empleado where visible=1 and fecha_baja='0000-00-00' and id_puesto=".$row["id"];
			$resultp = mysql_query(convert_sql($sqlp));
			while ($rowp = mysql_fetch_array($resultp)){
				if ($rowp["id"] == ""){
					return 0;
				} else {
					return 1;
				}
			}
		}
}
function busca_departamentos($id,$emple)
{ 
	global $db;
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;\">";
		echo "<tr>";
		$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=".$id." order by departamento";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			echo "<td style=\";vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;border-right:1px solid black;border-left:1px solid black\">";
					echo "<tr><th style=\"text-align:center;\">".$row["departamento"]."</th></tr>";
					echo "<tr><td>&nbsp;</td></tr>";
					if ($emple == 1){
						$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$row["id"]." order by puesto";
						$resultp = mysql_query(convert_sql($sqlp));
						while ($rowp = mysql_fetch_array($resultp)){
							$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=(select id_empleado from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"]." and fecha_baja= '0000-00-00')";
							$resulte = mysql_query(convert_sql($sqle));
							$rowe = mysql_fetch_array($resulte);
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


?>
