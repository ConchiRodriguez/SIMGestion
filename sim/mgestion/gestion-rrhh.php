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
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=0".$adres."\" class=".$class.">".$Empleados."</a></td>";
				if($_GET["id"] > 0){$variable = $Editar;} else {$variable = $Anadir;}
				if (($soption == 100) and ($_GET["id"] == 0)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=100".$adres."\" class=".$class.">".$variable." ".$Empleados."</a></td>";
				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1020&sop=200".$adres."\" class=".$class.">".$Buscar." ".$Empleados."</a></td>";
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
				echo "<form action=\"index.php?op=1020&sop=200\" method=\"post\">";
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
							if ($_POST["id_cliente_final2"] == $row["id"]){
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
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		for ($i = 0; $i <= 127; $i++) {
			if (((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) and (($filtro == 0) or ($filtro == $i))) {
				$sqlxt = "select count(*) as total from sgm_rrhh_empleado where visible=1 and nombre like '".chr($i)."%' order by nombre";
				$resultxt = mysql_query(convert_sql($sqlxt));
				$rowxt = mysql_fetch_array($resultxt);
					if ($rowxt["total"] > 0) {
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\">".chr($i)."</a></th>";
							echo "<th style=\"width:500px;\">".$Nombre."</th>";
							echo "<th></th>";
						echo "</tr>";
						$cambio = 0;
						$sqlt = "select * from sgm_rrhh_empleado where visible=1 and nombre like '".chr($i)."%' order by nombre";
						$result = mysql_query(convert_sql($sqlt));
						while ($row = mysql_fetch_array($result)) {
							if ($cambio == 0) { $color = "white"; $cambio = 1; } else { $color = "#F5F5F5"; $cambio = 0; }
							echo "<tr style=\"background-color:".$color."\">";
								if ((valida_nif_cif_nie($row["nif"]) <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
									echo "<td><img src=\"mgestion/pics/icons-mini/page_white_error.png\" alt=\"ERROR\" border=\"0\"></td>";
								} else { 
									echo "<td></td>"; 
								}
								echo "<td><a href=\"index.php?op=1020&sop=100&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
								echo "<td>".$row["nombre"]."</td>";
								echo "<td>".$row["nombre"]."</td>";
							echo "</tr>";
						}
				}
			}
		}
		echo "</table>";
	}

	if ($soption == 10) {
		if ($ssoption == 1) {
			$sql = "update sgm_rrhh_bolsa set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_rrhh_bolsa set ";
			$sql = $sql."notas='".$_POST["notas"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Bolsa de trabajo : </strong>";
		echo "<table>";
		echo "<tr><td></td><td>Datos / Contacto</td></tr>";
		$sql = "select * from sgm_rrhh_bolsa where visible=1 order by fecha desc";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:100px;\"><a href=\"index.php?op=1020&sop=11&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a><br><a href=\"index.php?op=1020&sop=13&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "<td style=\"vertical-align:top;width:250px;\"><strong>Fecha alta : </strong>".$row["fecha"]."<br><strong>Contacto : </strong>".$row["contacto"]."</td>";
				echo "<td style=\"vertical-align:top;width:250px;\"><strong>Notas : </strong>".$row["notas"]."</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td><td></td><td></td></tr>";
		}
		echo "</table>";
	}

	if ($soption == 11) {
		echo "<br><br>¿Seguro que desea eliminar este curriculum?";
		echo "<br><br><a href=\"index.php?op=1020&sop=10&ssop=1&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1020&sop=10\">[ NO ]</a>";
	}

	if ($soption == 13) {
		echo "<br><center><strong>Datos / Curriculum Vitae</strong></center>";
		echo "<br><br>";
		$sql = "select * from sgm_rrhh_bolsa where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<table>";
			echo "<form action=\"index.php?op=1020&sop=10&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr><td style=\"text-align:right;vertical-align:top\">Notas : </td><td><textarea name=\"notas\" rows=\"8\" style=\"width:500px\">".$row["notas"]."</textarea></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top\"></td><td><input type=\"Submit\" value=\"Modificar Notas\" style=\"width:500px\"></td></tr>";
			echo "</form>";
			echo "<tr><td style=\"text-align:right;vertical-align:top\">Contacto : </td><td><textarea name=\"contacto\" rows=\"8\" style=\"width:500px\" disabled>".$row["contacto"]."</textarea></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top\">Carta de presentación : </td><td><textarea name=\"carta\" rows=\"8\" style=\"width:500px\" disabled>".$row["carta"]."</textarea></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top\">Curriculum Vitae : </td><td><textarea name=\"cv\" rows=\"15\" style=\"width:500px\" disabled>".$row["cv"]."</textarea></td></tr>";
		echo "</table>";
	}

	if ($soption == 30) {
		echo "<strong>Organigrama</strong>";
		echo "<table><tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1020&sop=31&grup=1\" style=\"color:white;\">Ver Empleados</a>";
					echo "</td>";
				echo "<td><a href=\"".$urloriginal."/mgestion/gestion-rrhh-print.php?&op=".$_GET["sop"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px;\"></a></td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table>";
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=0 order by departamento";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr><td style=\"padding-left: 0px;\">";
					echo "&nbsp;<a href=\"index.php?op=1020&sop=31\"><img src=\"mgestion/pics/icons-mini/chart_organisation.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"index.php?op=1020&sop=40\"><img src=\"mgestion/pics/icons-mini/status_online.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"index.php?op=1020&sop=110\"><img src=\"mgestion/pics/icons-mini/status_away.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"index.php?op=1020&sop=50\"><img src=\"mgestion/pics/icons-mini/user_gray.png\" border=\"0\"></a>";
					echo "&nbsp;".$row["departamento"]."";
				echo "</td></tr>";
				busca_departamentos($row["id"],50);
			}
		echo "</table></center>";

		echo "<br><img src=\"mgestion/pics/icons-mini/chart_organisation.png\" border=\"0\">Detalle organizativo del departamento.";
		echo "<br><img src=\"mgestion/pics/icons-mini/status_online.png\" border=\"0\">Puestos de trabajo.";
		echo "<br><img src=\"mgestion/pics/icons-mini/status_away.png\" border=\"0\">Control horario de los trabajadores";
		echo "<br><img src=\"mgestion/pics/icons-mini/user_gray.png\" border=\"0\">Cursos de formación.";
	}

	if ($soption == 31) {
		echo "<strong>Organigrama</strong>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=30&grup=1\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
				echo "<td><a href=\"".$urloriginal."/mgestion/gestion-rrhh-print.php?&op=".$_GET["sop"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px;\"></a></td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table>";
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=0 order by departamento";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr><td style=\"padding-left: 0px;\">";
				echo "<img src=\"mgestion/pics/icons-mini/user_gray.png\" border=\"0\">&nbsp;<strong>".$row["departamento"]."</strong>";
				$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$row["id"]." order by puesto";
				$resultp = mysql_query(convert_sql($sqlp));
				while ($rowp = mysql_fetch_array($resultp)){
					$sqlpe = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"]." and fecha_baja= '0000-00-00'";
					$resultpe = mysql_query(convert_sql($sqlpe));
					while ($rowpe = mysql_fetch_array($resultpe)){
						$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$rowpe["id_empleado"]."";
						$resulte = mysql_query(convert_sql($sqle));
						$rowe = mysql_fetch_array($resulte);
						echo "</td></tr><tr><td style=\"padding-left: 0px;\">";
						echo "&nbsp;<a href=\"\"><img src=\"mgestion/pics/icons-mini/user.png\" border=\"0\"></a>";
						echo "&nbsp;".$rowp["puesto"].": &nbsp;".$rowe["nombre"]."";
						echo "<tr><td>";
					}
				}
				busca_departamentos2($row["id"],50);
				echo "</td></tr>";
			}
		echo "</table></center>";
		echo "<br><br><br><img src=\"mgestion/pics/icons-mini/user.png\" border=\"0\"> Puestos de trabajo.";
		echo "<br><img src=\"mgestion/pics/icons-mini/user_gray.png\" border=\"0\"> Departamento.";
	}

	if ($soption == 50) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_rrhh_formacion (fecha,fecha_inicio,fecha_fin,numero,nombre,tipo,impartidor,duracion,temario,observaciones,coste,id_plan,planificado,realizado) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["fecha"]."'";
			$sql = $sql.",'".$_POST["fecha_inicio"]."'";
			$sql = $sql.",'".$_POST["fecha_fin"]."'";
			$sql = $sql.",'".$_POST["numero"]."'";
			$sql = $sql.",'".$_POST["nombre"]."'";
			$sql = $sql.",".$_POST["tipo"]."";
			$sql = $sql.",'".$_POST["impartidor"]."'";
			$sql = $sql.",'".$_POST["duracion"]."'";
			$sql = $sql.",'".$_POST["temario"]."'";
			$sql = $sql.",'".$_POST["observaciones"]."'";
			$sql = $sql.",'".$_POST["coste"]."'";
			$sql = $sql.",".$_POST["id_plan"]."";
			$sql = $sql.",".$_POST["planificado"]."";
			$sql = $sql.",".$_POST["realizado"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_rrhh_formacion set ";
			$sql = $sql."fecha='".$_POST["fecha"]."'";
			$sql = $sql.",fecha_inicio='".$_POST["fecha_inicio"]."'";
			$sql = $sql.",fecha_fin='".$_POST["fecha_fin"]."'";
			$sql = $sql.",numero='".$_POST["numero"]."'";
			$sql = $sql.",nombre='".$_POST["nombre"]."'";
			$sql = $sql.",tipo=".$_POST["tipo"]."";
			$sql = $sql.",impartidor='".$_POST["impartidor"]."'";
			$sql = $sql.",duracion='".$_POST["duracion"]."'";
			$sql = $sql.",temario='".$_POST["temario"]."'";
			$sql = $sql.",observaciones='".$_POST["observaciones"]."'";
			$sql = $sql.",coste='".$_POST["coste"]."'";
			$sql = $sql.",id_plan=".$_POST["id_plan"]."";
			$sql = $sql.",planificado=".$_POST["planificado"]."";
			$sql = $sql.",realizado=".$_POST["realizado"]."";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_formacion set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 4) {
			$sql = "select * from sgm_rrhh_formacion where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$sql = "insert into sgm_rrhh_formacion (nombre,tipo,duracion,temario,observaciones) ";
			$sql = $sql."values (";
			$sql = $sql."'".$row["nombre"]."'";
			$sql = $sql.",".$row["tipo"]."";
			$sql = $sql.",'".$row["duracion"]."'";
			$sql = $sql.",'".$row["temario"]."'";
			$sql = $sql.",'".$row["observaciones"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Administrar Cursos</strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=120\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=51&ssop=1\" style=\"color:white;\">Añadir Curso</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:bottom;\"><em>Eliminar</em></td>"; 
				echo "<td></td>";
				echo "<td style=\"text-align:bottom;\"><strong>Plan Formativo</strong></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:bottom;width:150px\"><strong>Nombre</strong></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:bottom;width:150px\"><strong>Fecha Inicio</strong></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:bottom;\"><em>Editar</em></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:bottom;\"><em>Duplicar</em></td>";
				echo "<td></td>";
				echo "<td><em>Añadir<br>personal</em></td>";
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
					echo "<a href=\"index.php?op=1020&sop=54&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
				}else{echo "&nbsp;";}
				echo "</td>";
				echo "<td>&nbsp;</td>";
				$sqlpl = "select * from sgm_rrhh_formacion_plan where visible=1 and id=".$row["id_plan"];
				$resultpl = mysql_query(convert_sql($sqlpl));
				$rowpl = mysql_fetch_array($resultpl);
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1020&sop=102&ssop=2&id=".$rowpl["id"]."\">".$rowpl["nombre"]."</a></td>";
				echo "<td>&nbsp;</td>";
				echo "<td>".$row["nombre"]."</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>".$row["fecha_inicio"]."</td>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1020&sop=51&ssop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1020&sop=52&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_copy.png\" style=\"border:0px\"></a></td>";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1020&sop=56&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/user_add.png\" style=\"border:0px\"></a></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
		echo "<br><br><br>";
		echo "<table><tr><td><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\">  Con el curso sin personal implicado.</td></tr></table>";
	}

	if ($soption == 51) {
		if ($ssoption == 1){
			echo "<strong>Añadir Nuevo Curso</strong><br><br>";
		} else {
			echo "<strong>Modificar Curso</strong><br><br>";
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=50\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table>";
			echo "<tr>";
			if ($ssoption == 1){
				echo "<form action=\"index.php?op=1020&sop=50&ssop=1\" method=\"post\">";
				echo "<td></td><td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
			} else {
				echo "<form action=\"index.php?op=1020&sop=50&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td><td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
			}
			$sqlx = "select * from sgm_rrhh_formacion where id=".$_GET["id"]."";
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
			echo "</tr><tr>";
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				if ($rowx["fecha"] == ""){
					echo "<td style=\"text-align:right\">Fecha Previsión</td><td><input type=\"text\" name=\"fecha\" style=\"width:100px\" value=\"".$date1."\"></td>";
				} else {
					echo "<td style=\"text-align:right\">Fecha Previsión</td><td><input type=\"text\" name=\"fecha\" style=\"width:100px\" value=\"".$rowx["fecha"]."\"></td>";
				}
			echo "</tr><tr>";
				if ($rowx["fecha_inicio"] == ""){
					echo "<td style=\"text-align:right\">Fecha Inicio</td><td><input type=\"text\" name=\"fecha_inicio\" style=\"width:100px\" value=\"".$date1."\"></td>";
				} else {
					echo "<td style=\"text-align:right\">Fecha Inicio</td><td><input type=\"text\" name=\"fecha_inicio\" style=\"width:100px\" value=\"".$rowx["fecha_inicio"]."\"></td>";
				}
			echo "</tr><tr>";
				if ($rowx["fecha_fin"] == ""){
					echo "<td style=\"text-align:right\">Fecha Fin</td><td><input type=\"text\" name=\"fecha_fin\" style=\"width:100px\" value=\"".$date1."\"></td>";
				} else {
					echo "<td style=\"text-align:right\">Fecha Fin</td><td><input type=\"text\" name=\"fecha_fin\" style=\"width:100px\" value=\"".$rowx["fecha_fin"]."\"></td>";
				}
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Tipo</td><td><select name=\"tipo\" style=\"width:100px\">";
					echo "<option value=\"0\">Interno</option>";
					echo "<option value=\"1\">Externo</option>";
				echo "</select></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Numero</td><td><input type=\"text\" name=\"numero\" style=\"width:200px\" value=\"".$rowx["numero"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Nombre</td><td><input type=\"text\" name=\"nombre\" style=\"width:200px\" value=\"".$rowx["nombre"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Impartido por</td><td><input type=\"text\" name=\"impartidor\" style=\"width:200px\" value=\"".$rowx["impartidor"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Duracion</td><td><input type=\"Text\" name=\"duracion\" style=\"width:200px\" value=\"".$rowx["duracion"]."\">&nbsp;* Horas</td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;text-align:right\">Temario</td><td><textarea rows=\"5\" name=\"temario\" style=\"width:500px\">".$rowx["temario"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;text-align:right\">Observaciones</td><td><textarea rows=\"5\" name=\"observaciones\" style=\"width:500px\">".$rowx["observaciones"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Costes</td><td><input type=\"Text\" name=\"coste\" style=\"width:200px\" value=\"".$rowx["coste"]."\"></td>";
			echo "</tr><tr>";
				$sqlp = "select * from sgm_rrhh_formacion_plan where visible=1 and id=".$rowx["id_plan"];
				$resultp = mysql_query(convert_sql($sqlp));
				$rowp = mysql_fetch_array($resultp);
				echo "<td style=\"text-align:right\">Plan de Formacion</td><td><select name=\"id_plan\" style=\"width:200px\" value=\"".$rowp["nombre"]."\">";
					echo "<option value=\"0\" selected>-</option>";
					$sqli = "select * from sgm_rrhh_formacion_plan where visible=1";
					$resulti = mysql_query(convert_sql($sqli));
					while ($rowi = mysql_fetch_array($resulti)){
						if ($rowx["id_plan"] == $rowi["id"]){
							echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["nombre"]."</option>";
						}else{
							echo "<option value=\"".$rowi["id"]."\">".$rowi["nombre"]."</option>";
						}
					}
					echo "</select></td>";
			echo "<tr></tr>";
				echo "<td  style=\"text-align:right\">Planificado</td><td><select name=\"planificado\" style=\"width:50px\">";
					if ($rowx["planificado"] == 1){
						echo "<option value=\"0\">NO</option>";
						echo "<option value=\"1\" selected>SI</option>";
					}
					if ($rowx["planificado"] == 0){
						echo "<option value=\"0\" selected>NO</option>";
						echo "<option value=\"1\">SI</option>";
					}
					echo "</select></td>";
			echo "<tr></tr>";
				echo "<td  style=\"text-align:right\">Realizado</td><td><select name=\"realizado\" style=\"width:50px\">";
					if ($rowx["realizado"] == 1){
						echo "<option value=\"0\">NO</option>";
						echo "<option value=\"1\" selected>SI</option>";
					}
					if ($rowx["realizado"] == 0){
						echo "<option value=\"0\" selected>NO</option>";
						echo "<option value=\"1\">SI</option>";
					}
					echo "</select></td>";
					echo "</select></td>";
			echo "<tr></tr>";
				if ($ssoption == 1){
					echo "<td></td><td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				} else {
					echo "<td></td><td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
				}
				echo "</form>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 52) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea duplicar este curso?";
		echo "<br><br><a href=\"index.php?op=1020&sop=50&ssop=4&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=50\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 54) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este curso?";
		echo "<br><br><a href=\"index.php?op=1020&sop=50&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=50\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 56){
		if ($ssoption == 1) {
			$sqlt2 = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"]." and id_empleado=".$_POST["id_empleado"];
			$resultt2 = mysql_query(convert_sql($sqlt2));
			$rowt2 = mysql_fetch_array($resultt2);
			if ($rowt2["total"] == 0) {
				$sql = "insert into sgm_rrhh_formacion_empleado (id_empleado, id_curso) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["id_empleado"]."";
				$sql = $sql.",".$_GET["id"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 2) {
			$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$_POST["id_departamento"];
			$resultp = mysql_query(convert_sql($sqlp));
			while ($rowp = mysql_fetch_array($resultp)){
				$sqlt = "select count(*) as total from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] > 0) {

					$sql = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"];
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);

					$sqlt2 = "select count(*) as total from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"]." and id_empleado=".$row["id_empleado"];
					$resultt2 = mysql_query(convert_sql($sqlt2));
					$rowt2 = mysql_fetch_array($resultt2);

					if ($rowt2["total"] == 0) {
						if ($row["fecha_baja"] == '0000-00-00') {
							$sql = "insert into sgm_rrhh_formacion_empleado (id_empleado, id_curso) ";
							$sql = $sql."values (";
							$sql = $sql."".$row["id_empleado"]."";
							$sql = $sql.",".$_GET["id"]."";
							$sql = $sql.")";
							mysql_query(convert_sql($sql));
						}
					}

				}
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_formacion_empleado set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id_curso=".$_GET["id"]." and id_empleado=".$_GET["id_empleado"]."";
			mysql_query(convert_sql($sql));
		}

		$sqlf = "select * from sgm_rrhh_formacion where visible=1 and id=".$_GET["id"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
		echo "<strong>Añadir Personal al Curso : ".$rowf["nombre"]."</strong>";
		echo "<br><br>";
		echo "<table style=\"width:800px;\"><tr><td>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=50\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<table>";
			echo "<tr>";
				echo "<td>";
					echo "Introducir Empleados";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1020&sop=56&ssop=1&id=".$_GET["id"]."\" method=\"POST\">";
				echo "<td>";
						echo "<select name=\"id_empleado\" style=\"width:200px\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select * from sgm_rrhh_empleado where visible=1";
							$result = mysql_query(convert_sql($sql));
							while ($row = mysql_fetch_array($result)){
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
								}
						echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr><tr>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td>";
					echo "Introducir Departamentos";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td>";
				echo "<form action=\"index.php?op=1020&sop=56&ssop=2&id=".$_GET["id"]."\" method=\"POST\">";
					echo "<select name=\"id_departamento\" style=\"width:200px\">";
							echo "<option value=\"0\">-</option>";
							$sqld = "select * from sgm_rrhh_departamento where visible=1";
							$resultd = mysql_query(convert_sql($sqld));
							while ($rowd = mysql_fetch_array($resultd)){
								echo "<option value=\"".$rowd["id"]."\">".$rowd["departamento"]."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</td><td>&nbsp;</td><td>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:200px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:center;\"><em>Eliminar</em></td>";
				echo "<td style=\"width:150px;\">Empleados</td>";
			echo "</tr>";
			$sql = "select * from sgm_rrhh_formacion_empleado where visible=1 and id_curso=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$row["id_empleado"];
				$resulte = mysql_query(convert_sql($sqle));
				while ($rowe = mysql_fetch_array($resulte)){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=57&id=".$_GET["id"]."&id_empleado=".$rowe["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td>".$rowe["nombre"]."</td>";
					echo "</tr>";
				}
			}
		echo "</table>";
		echo "</center>";
		echo "</td></tr></table>";
	}

	if ($soption == 57) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este empleado del curso?";
		echo "<br><br><a href=\"index.php?op=1020&sop=56&ssop=3&id=".$_GET["id"]."&id_empleado=".$_GET["id_empleado"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=56&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 90) {
		if ($ssoption == 1) {
			if (($_POST["id_puesto"] != 0) and ($_POST["id_empleado"] != 0)){
				$sql = "insert into sgm_rrhh_puesto_empleado (id_puesto,id_empleado,fecha_alta) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["id_puesto"]."";
				$sql = $sql.",".$_POST["id_empleado"]."";
				$sql = $sql.",'".$_POST["fecha_alta"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				echo mensaje_error("Debe introducir un puesto de trabajo y un empleado para llevar a cabo esta acción");
			}
		}
		if ($ssoption == 2) {
			$sql = "update sgm_rrhh_puesto_empleado set ";
			$sql = $sql."fecha_baja='".$_POST["fecha_baja"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_puesto_empleado set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Plantilla Actual</strong>";
		echo "<br><br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:center;width:150px\">Puesto Trabajo</td>";
				echo "<td style=\"text-align:center;width:150px\">Trabajador</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Alta</td>";
			echo "</tr>";
		echo "<form action=\"index.php?op=1020&sop=90&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<select name=\"id_puesto\" style=\"width:150px\">";
						echo "<option value=\"0\">-</option>";
						$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 order by puesto";
						$resultp = mysql_query(convert_sql($sqlp));
						while ($rowp = mysql_fetch_array($resultp)){
							echo "<option value=\"".$rowp["id"]."\">".$rowp["puesto"]."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<select name=\"id_empleado\" style=\"width:150px\">";
						echo "<option value=\"0\">-</option>";
						$sqle = "select * from sgm_rrhh_empleado where visible=1 order by nombre";
						$resulte = mysql_query(convert_sql($sqle));
						while ($rowe = mysql_fetch_array($resulte)){
								echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
						}
						echo "</select>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;\">";
					$date = getdate();
					$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
					echo "<input type=\"text\" name=\"fecha_alta\" value=\"".$date1."\" style=\" width:75px\">";
				echo "</td>";
				echo "<td>";
					echo "<input type=\"Submit\" value=\"Añadir\" style=\"width:100px\">";
				echo "</td>";
			echo "</tr>";
			echo "</form>";
			echo "</table><br><br><table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:center;\"><em>Eliminar</em></td>"; 
				echo "<td style=\"text-align:center;width:150px\">Departamento</td>"; 
				echo "<td style=\"text-align:center;width:150px\">Puesto Trabajo</td>";
				echo "<td style=\"text-align:center;width:150px\">Trabajador</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Alta</td>";
				echo "<td>Fecha Baja</td>";
			echo "</tr>";
			$date = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"]-15, $date["year"]));
			$sql = "select * from sgm_rrhh_puesto_empleado where visible=1 and (fecha_baja='0000-00-00' or fecha_baja>='".$fecha."') order by fecha_baja, fecha_alta desc";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr>";
					echo "<td style=\"text-align:center;vertical-align:top\">";
						echo "<a href=\"index.php?op=1020&sop=93&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
					echo "</td><td style=\"vertical-align:top;\">";
						$sqldep1 = "select * from sgm_rrhh_puesto_trabajo where id=".$row["id_puesto"];
						$resultdep1 = mysql_query(convert_sql($sqldep1));
						while ($rowdep1 = mysql_fetch_array($resultdep1)){
							$sqldep2 = "select * from sgm_rrhh_departamento where id=".$rowdep1["id_departamento"];
							$resultdep2 = mysql_query(convert_sql($sqldep2));
							$rowdep2 = mysql_fetch_array($resultdep2);
							
							echo "<a href=\"index.php?op=1020&sop=40\">".$rowdep2["departamento"]."</a>";
						}
					echo "</td><td style=\"vertical-align:top;\">";
						$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1";
						$resultp = mysql_query(convert_sql($sqlp));
						while ($rowp = mysql_fetch_array($resultp)){
							if ($row["id_puesto"] == $rowp["id"]){
								echo "<a href=\"index.php?op=1020&sop=41&ssop=2&id=".$row["id_puesto"]."\">".$rowp["puesto"]."</a>";
							}
						}
					echo "</td>";
					echo "<td style=\"vertical-align:top;\">";
						$sqlp = "select * from sgm_rrhh_empleado where visible=1";
						$resulte = mysql_query(convert_sql($sqle));
						while ($rowe = mysql_fetch_array($resulte)){
							if ($row["id_empleado"] == $rowe["id"]){
								echo "<a href=\"index.php?op=1020&sop=71&ssop=2&id=".$row["id_empleado"]."\">".$rowe["nombre"]."</a>";
							}
						}
					echo "</td>";
					echo "<td style=\"text-align:center;vertical-align:top;\">";
						echo $row["fecha_alta"];
					echo "</td>";
					if ($row["fecha_baja"] == '0000-00-00') {
						echo "<form action=\"index.php?op=1020&sop=90&ssop=2&id=".$row["id"]."\" method=\"post\">";
						echo "<td style=\"vertical-align:top;\">";
							$date = getdate();
							$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
							echo "<input type=\"text\" name=\"fecha_baja\" value=\"".$date1."\" style=\"width:100px\" ";
						echo "</td>";
						echo "<td style=\"vertical-align:top;\">";
							echo "<input type=\"submit\" value=\"Baja\" style=\"width:100px\"";
						echo "</td>";
						echo "</form>";
					} else {
						echo "<td style=\"vertical-align:top;\">".$row["fecha_baja"]."</td><td></td>";
					}

				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 93) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este trabajador?";
		echo "<br><br><a href=\"index.php?op=1020&sop=90&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=90\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sql = "update sgm_rrhh_formacion_plan set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Administrar Planes de formacion</strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=120\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=102\" style=\"color:white;\">Añadir Plan</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br><br>";
			echo "<center>";
			echo "<table cellspacing=\"0\" style=\"width:300px;\">";
				echo "<tr style=\"background-color: Silver;\">";
					echo "<td style=\"text-align:center\"><em>Eliminar</em></td>";
					echo "<td></td>";
					echo "<td style=\"text-align:left\">Nombre</td>";
					echo "<td></td>";
					echo "<td style=\"text-align:center\"><em>Editar</em></td>";
				echo "</tr>";
				$sql = "select * from sgm_rrhh_formacion_plan where visible=1";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)){
				echo "<tr>";
					echo "<td  style=\"text-align:center\"><a href=\"index.php?op=1020&sop=101&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td></td>";
					echo "<td  style=\"text-align:left\">".$row["nombre"]."</td>";
					echo "<td></td>";
					echo "<td  style=\"text-align:center\"><a href=\"index.php?op=1020&sop=102&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
				}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este plan de formacion?";
		echo "<br><br><a href=\"index.php?op=1020&sop=100&ssop=1&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=100\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 102) {
		if ($ssoption == 3) {
			$sql = "insert into sgm_rrhh_formacion_plan (nombre,necesidades,objetivos,metodos,resultados) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",'".$_POST["necesidades"]."'";
			$sql = $sql.",'".$_POST["objetivos"]."'";
			$sql = $sql.",'".$_POST["metodos"]."'";
			$sql = $sql.",'".$_POST["resultados"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_rrhh_formacion_plan set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",necesidades='".$_POST["necesidades"]."'";
			$sql = $sql.",objetivos='".$_POST["objetivos"]."'";
			$sql = $sql.",metodos='".$_POST["metodos"]."'";
			$sql = $sql.",resultados='".$_POST["resultados"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_rrhh_formacion set ";
			$sql = $sql."id_plan=".$_GET["id"]."";
			$sql = $sql." WHERE id=".$_POST["id_curso"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 6) {
			$sql = "update sgm_rrhh_formacion set ";
			$sql = $sql."id_plan=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		if ($_GET["id"] == ""){
			echo "<strong>Añadir Nuevo Plan de Formacion</strong><br><br>";
		} else {
			echo "<strong>Modificar Plan de Formacion</strong><br><br>";
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=100\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table>";
						echo "<tr>";
							echo "<td></td>";
							if ($_GET["id"] == ""){
								echo "<form action=\"index.php?op=1020&sop=102&ssop=3\" method=\"post\">";
								echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
							} else {
								echo "<form action=\"index.php?op=1020&sop=102&ssop=4&id=".$_GET["id"]."\" method=\"post\">";
								echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
							}
						$sql = "select * from sgm_rrhh_formacion_plan where id=".$_GET["id"]."";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;\">Nombre</td><td><input type=\"text\" name=\"nombre\" style=\"width:200px;\" value=\"".$row["nombre"]."\"></td>";
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;\">Necesidades<br>Formativas</td><td><textarea name=\"necesidades\" rows=\"8\" style=\"width:350px;\">".$row["necesidades"]."</textarea></td>";
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;\">Objetivos</td><td><textarea name=\"objetivos\" rows=\"8\" style=\"width:350px;\">".$row["objetivos"]."</textarea></td>";
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;\">Metodos</td><td><textarea name=\"metodos\" rows=\"8\" style=\"width:350px;\">".$row["metodos"]."</textarea></td>";
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;\">Resultados</td><td><textarea name=\"resultados\" rows=\"8\" style=\"width:350px;\">".$row["resultados"]."</textarea></td>";
						echo "</tr><tr>";
							echo "<td></td>";
							if ($_GET["id"] == ""){
								echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
							} else {
								echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
							}
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;\">";
				if ($_GET["id"] != ""){
					echo "<table>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td>Añadir Cursos al Plan</td>";
						echo "</tr><tr>";
						echo "&nbsp;</tr><tr>";
							echo "<form action=\"index.php?op=1020&sop=102&ssop=5&id=".$_GET["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td>";
								echo "<select name=\"id_curso\" style=\"width:150px\">";
								echo "<option value=\"0\">-</option>";
								$sqle = "select * from sgm_rrhh_formacion where visible=1 order by nombre";
								$resulte = mysql_query(convert_sql($sqle));
								while ($rowe = mysql_fetch_array($resulte)){
									echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
								}
								echo "</select>";
							echo "</td>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
							echo "</form>";
						echo "</tr>";
							$sqlc = "select * from sgm_rrhh_formacion where visible=1 and id_plan=".$_GET["id"]." order by nombre";
							$resultc = mysql_query(convert_sql($sqlc));
							while ($rowc = mysql_fetch_array($resultc)){
								echo "<tr>";
									echo "<td  style=\"text-align:center\"><a href=\"index.php?op=1020&sop=102&ssop=6&id=".$rowc["id"]."&id_plan=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
									echo "<td></td>";
									echo "<td><a href=\"index.php?op=1020&sop=51&ssop=2&id=".$rowc["id"]."\">".$rowc["nombre"]."</a></td>";
								echo "</tr>";
							}
				echo "</table>";
			}
			echo "</td>";
		echo "</tr>";
	echo "</table></center>";
	}

	if ($soption == 110) {
		echo "<strong>Horarios</strong>";
		echo "<center><table cellspacing=\"0\" style=\"width:500px\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"background-color:silver;\"><strong>Horario Intensivo</strong></td>";
				echo "<td style=\"background-color:silver;\"></td>";
				echo "<td style=\"background-color:silver;\"><strong>Horario Partido</strong></td>";
				echo "<td style=\"background-color:silver;\"></td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Editar</em></td>";
				echo "<td><em>Horario</em></td>";
				echo "<td>Nombre Empleado</td>";
				echo "<td>Hora Inicio</td>";
				echo "<td>Hora Fin</td>";
				echo "<td>Hora Inicio 2</td>";
				echo "<td>Hora Fin 2</td>";
			echo "</tr>";
		$date = getdate();
		$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
		$sql = "select * from sgm_rrhh_empleado_horario where visible=1 and data_ini <= '".$date1."' and data_fi >= '".$date1."'"." order by hora_ini";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			echo "<tr>";
				$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$row["id_empleado"]."";
				$resulte = mysql_query(convert_sql($sqle));
				$rowe = mysql_fetch_array($resulte);
				echo "<td  style=\"text-align:center\"><a href=\"index.php?op=1020&sop=71&ssop=2&id=".$rowe["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "<td  style=\"text-align:center\"><a href=\"index.php?op=1020&sop=80&id=".$rowe["id"]."\"><img src=\"mgestion/pics/icons-mini/time.png\" style=\"border:0px\"></a></td>";
				echo "<td><a href=\"index.php?op=1020&sop=80&id=".$rowe["id"]."\">".$rowe["nombre"]."</a></td><td>".$row["hora_ini"]."</td><td>".$row["hora_fi"]."</td>";
				if (($row["hora_ini2"] != "00:00") and ($row["hora_fi2"] != "00:00")) {
					echo "<td>".$row["hora_ini2"]."</td><td>".$row["hora_fi2"]."</td>";
				} else {
					echo "<td></td><td></td>";
				}
			echo "</tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 120) {
		if ($admin == true) {
			echo "<table cellpadding=\"2\" cellspacing=\"2\" ><tr>";
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:#4B53AF;border: 1px solid black\"><a href=\"index.php?op=1020&sop=100\" style=\"color:white\">Planes de Formación</a></td>";
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:#4B53AF;border: 1px solid black\"><a href=\"index.php?op=1020&sop=50\" style=\"color:white\">Cursos</a></td>";
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:#4B53AF;border: 1px solid black\"><a href=\"index.php?op=1020&sop=20\" style=\"color:white\">Departamentos</a></td>";
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:#4B53AF;border: 1px solid black\"><a href=\"index.php?op=1020&sop=40\" style=\"color:white\">Puestos de Trabajo</a></td>";
			echo "</tr></table>";
		}
	}

	if (($soption >= 150) and ($soption <= 200) and  ($_GET["id"] != 0)) {
		$sql = "select * from sgm_rrhh_empleado where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<center>";
		echo "<table cellpadding=\"0\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\" style=\"color:white;\">Datos fiscales</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=160&id=".$row["id"]."\" style=\"color:white;\">Datos Académicos</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=170&id=".$row["id"]."\" style=\"color:white;\">Cursos Formativos</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=180&id=".$row["id"]."\" style=\"color:white;\">Horarios</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=190&id=".$row["id"]."\" style=\"color:white;\">Contratos</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: silver;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=200&id=".$row["id"]."\" style=\"color:black;\">Nóminas</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: silver;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=210&id=".$row["id"]."\" style=\"color:black;\">Valoración</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: silver;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=220&id=".$row["id"]."\" style=\"color:black;\">Gestión de dias trabajados</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: silver;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=230&id=".$row["id"]."\" style=\"color:black;\">Seguridad e Higiene</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:400px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]."</strong></a>";
					echo "<br>".$row["nif"];
					echo "<br><strong>".$row["direccion"]."</strong>";
					if ($row["cp"] != "") {echo " (".$row["cp"].") ";}
					echo "<strong>".$row["poblacion"]."</strong>";
					if ($row["provincia"] != "") {echo " (".$row["provincia"].")";}
					echo "<br>";
					if ($row["telefono"] != "") { echo "<br>Teléfono : <strong>".$row["telefono"]."</strong>"; }
					if ($row["mail"] != "") { echo "<br>eMail : <a href=\"mailto:".$row["email"]."\"><strong>".$row["mail"]."</strong></a>"; }
					echo "<br>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color: red;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=152&id=".$row["id"]."\" style=\"color:white;\">Eliminar</a></td>";
						echo "</tr>";
						echo "<tr>";
##							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=220&id=".$row["id"]."\" style=\"color:white;\">Datos bancarios<br>Gestión de facturación</a></td>";
						echo "</tr>";
						echo "<tr>";
##							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1020&sop=230&id=".$row["id"]."\" style=\"color:white;\">Definición cliente</a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";


			echo "</tr>";
		echo "</table>";

		echo "</td></tr></table><br>";
		echo "</center>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 150) {
		if ($ssoption == 2) {
			$sql = "update sgm_rrhh_empleado set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",nif='".$_POST["nif"]."'";
			$sql = $sql.",direccion='".$_POST["direccion"]."'";
			$sql = $sql.",poblacion='".$_POST["poblacion"]."'";
			$sql = $sql.",cp='".$_POST["cp"]."'";
			$sql = $sql.",provincia='".$_POST["provincia"]."'";
			$sql = $sql.",id_pais=".$_POST["id_pais"];
			$sql = $sql.",mail='".$_POST["mail"]."'";
			$sql = $sql.",telefono='".$_POST["telefono"]."'";
			$sql = $sql.",fax='".$_POST["fax"]."'";
			$sql = $sql.",telefono2='".$_POST["telefono2"]."'";
			$sql = $sql.",fax2='".$_POST["fax2"]."'";
			$sql = $sql.",notas='".$_POST["notas"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_empleado set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		if ($_GET["id"] > 0) {
			$sqlem = "select * from sgm_rrhh_empleado where id=".$_GET["id"];
			$resultem = mysql_query(convert_sql($sqlem));
			$rowem = mysql_fetch_array($resultem);
			echo "<form action=\"index.php?op=1020&sop=150&ssop=2&id=".$_GET["id"]."\"  method=\"post\">";
		} 
		if ($_GET["id"] == 0) {
			echo "<form action=\"index.php?op=1020&sop=151\"  method=\"post\">";
		}
		echo "<strong>Datos fiscales</strong>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;width:70px\">Nombre: </td><td><input type=\"Text\" name=\"nombre\" value=\"".$rowem["nombre"]."\" class=\"px300\"></td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;width:70px\">NIF: </td><td><input type=\"Text\" name=\"nif\" value=\"".$rowem["nif"]."\" class=\"px300\"></td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;width:70px;vertical-align:top;\">Dirección: </td><td><textarea name=\"direccion\" class=\"px300\" rows=\"3\">".$row["direccion"]."</textarea></td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;width:70px\">Código Postal: </td><td><input type=\"Text\" name=\"cp\" value=\"".$rowem["cp"]."\" class=\"px300\"></td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;width:70px\">Población: </td><td><input type=\"Text\" name=\"poblacion\" value=\"".$rowem["poblacion"]."\" class=\"px300\"></td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;width:70px\">Provincia: </td><td><input type=\"Text\" name=\"provincia\" value=\"".$rowem["provincia"]."\" class=\"px300\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:70px\">Pais: </td><td>";
				echo "<select name=\"id_pais\" style=\"width:300px;\">";
				echo "<option value=\"0\">-</option>";
				$sqlo = "select * from sys_naciones where visible=1 order by Nacion";
				$resulto = mysql_query(convert_sql($sqlo));
				while ($rowo = mysql_fetch_array($resulto)) {
					if ($_GET["id"] == 0){
						if ($rowo["predeterminado"] == 1){
							echo "<option value=\"".$rowo["CodigoNacion"]."\" selected>".$rowo["Nacion"]."</option>";
						}
					} else {
						if ($row["id_pais"] == $rowo["CodigoNacion"]){
							echo "<option value=\"".$rowo["CodigoNacion"]."\" selected>".$rowo["Nacion"]."</option>";
						}
					}
					echo "<option value=\"".$rowo["CodigoNacion"]."\">".$rowo["Nacion"]."</option>";
				}
			echo "</td></tr>";
			echo "<tr><td style=\"text-align:right;width:70px\">E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px300\" value=\"".$rowem["mail"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:70px\">Teléfono</td><td>";
				echo "<table cellspacing=\"0\">";
					echo "<tr><td><input type=\"Text\" name=\"telefono\" class=\"px120\" value=\"".$rowem["telefono"]."\"></td>";
					echo "<td style=\"text-align:right;width:55px\">Teléfono 2</td><td><input type=\"Text\" name=\"telefono2\" class=\"px120\" value=\"".$rowem["telefono2"]."\"></td></tr>";
				echo "</table>";
			echo "</td></tr>";
			echo "<tr><td style=\"text-align:right;width:70px\">Fax</td><td>";
				echo "<table cellspacing=\"0\">";
					echo "<tr><td><input type=\"Text\" name=\"fax\" class=\"px120\" value=\"".$rowem["fax"]."\"></td>";
					echo "<td style=\"text-align:right;width:55px\">Fax 2</td><td><input type=\"Text\" name=\"fax2\" class=\"px120\" value=\"".$rowem["fax2"]."\"></td></tr>";
				echo "</table>";
			echo "</td></tr>";
			echo "<tr>";
				echo "<td style=\"text-align:right;width:70px;vertical-align:top;\">Notas: </td>";
				echo "<td><textarea name=\"notas\" style=\"width:300px\" rows=\"5\">".$rowem["notas"]."</textarea></td>";
				echo "<td style=\"width:200px\"></td>";
			echo "</tr>";
		if ($_GET["id"] > 0) { echo "<tr><td></td><td><input type=\"Submit\" value=\"Guardar cambios\" style=\"width:300px\"></td></tr>"; }
		if ($_GET["id"] == 0) {	echo "<tr><td></td><td><input type=\"Submit\" value=\"Añadir\" style=\"width:300px\"></td></tr>";	}
		echo "</form>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 151) {
		$sql = "insert into sgm_rrhh_empleado (nombre,nif,direccion,poblacion,cp,provincia,id_pais,mail,telefono,telefono2,fax,fax2,notas)";
		$sql = $sql."values (";
		$sql = $sql."'".$_POST["nombre"]."'";
		$sql = $sql.",'".$_POST["nif"]."'";
		$sql = $sql.",'".$_POST["direccion"]."'";
		$sql = $sql.",'".$_POST["poblacion"]."'";
		$sql = $sql.",'".$_POST["cp"]."'";
		$sql = $sql.",'".$_POST["provincia"]."'";
		$sql = $sql.",'".$_POST["id_pais"]."'";
		$sql = $sql.",'".$_POST["mail"]."'";
		$sql = $sql.",'".$_POST["telefono"]."'";
		$sql = $sql.",'".$_POST["fax"]."'";
		$sql = $sql.",'".$_POST["telefono2"]."'";
		$sql = $sql.",'".$_POST["fax2"]."'";
		$sql = $sql.",'".$_POST["notas"]."'";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		$sql = "select * from sgm_rrhh_empleado where visible=1 order by id desc";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\">[ Volver ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1020&sop=150&id=".$row["id"]."\">[ Continuar ]</a>";
		echo "</center>";
	}

	if ($soption == 152) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este empleado?";
		echo "<br><br><a href=\"index.php?op=1020&sop=150&sop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1020&sop=150&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 160) {
		if ($ssoption == 1) {
			$sql = "update sgm_rrhh_empleado set ";
			$sql = $sql."fecha_incor='".$_POST["fecha_incor"]."'";
			$sql = $sql.",codigo='".$_POST["codigo"]."'";
			$sql = $sql.",plan_acogida='".$_POST["plan_acogida"]."'";
			$sql = $sql.",formacion='".$_POST["formacion"]."'";
			$sql = $sql.",trayectoria='".$_POST["trayectoria"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_empleado set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Datos Académicos</strong><br>";
		echo "<table><tr>";
				echo "<td><a href=\"".$urloriginal."/mgestion/gestion-rrhh-print.php?&op=".$_GET["sop"]."&id=".$_GET["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px;\"></a></td>";
		echo "</tr></table>";
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1020&sop=160&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
							echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
						$sql = "select * from sgm_rrhh_empleado where id=".$_GET["id"]." and visible=1";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<tr></tr>";
						if ($row["fecha_incor"] == ""){
							$date = getdate();
							$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
							echo "<tr>";
								echo "<td style=\"text-align:left\"><strong>Fecha Incorporación</strong></td>";
							echo "</tr><tr>";
								echo "<td><input type=\"text\" name=\"fecha_incor\" style=\"width:100px\" value=\"".$date1."\"></td>";
						} else {
							echo "<tr>";
								echo "<td style=\"text-align:left\"><strong>Fecha Incorporación</strong></td>";
							echo "</tr><tr>";
								echo "<td><input type=\"text\" name=\"fecha_incor\" style=\"width:100px\" value=\"".$row["fecha_incor"]."\"></td>";
						}
							echo "</tr><tr>";
								echo "<td style=\"text-align:left\"><strong>Codigo</strong></td>";
							echo "</tr><tr>";
								echo "<td><input type=\"text\" name=\"codigo\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
							echo "</tr><tr>";
								echo "<td style=\"text-align:left\"><strong>Plan de Acogida</strong></td>";
							echo "</tr><tr>";
								echo "<td><textarea rows=\"5\" name=\"plan_acogida\" style=\"width:480px\">".$row["plan_acogida"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<td style=\"text-align:left\"><strong>Formacion Previa</strong></td>";
							echo "</tr><tr>";
								echo "<td><textarea rows=\"5\" name=\"formacion\" style=\"width:480px\">".$row["formacion"]."</textarea></td>";
							echo "</tr><tr>";
								echo "<td style=\"text-align:left\"><strong>Trayectoria Profesional</strong></td>";
							echo "</tr><tr>";
								echo "<td><textarea rows=\"5\" name=\"trayectoria\" style=\"width:480px\">".$row["trayectoria"]."</textarea></td>";
							echo "</tr><tr>";
							if ($ssoption == 1){
								echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
							} else {
								echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
							}
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td>";
				echo "</td><td>";
				echo "</td><td>";
				echo "</td><td>";
				echo "</td><td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:200px;vertical-align:top;\">";
								echo "<strong>Formulario de envio de archivos :</strong><br><br>";
								echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1020&sop=162&id=".$_GET["id"]."\" method=\"post\">";
								echo "<center>";
								echo "<select name=\"id_tipo\" style=\"width:200px\">";
									$sql = "select * from sgm_files_tipos order by nombre";
									$result = mysql_query(convert_sql($sql));
									while ($row = mysql_fetch_array($result)) {
										echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
									}
								echo "</select>";
								echo "<br><br>";
								echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
								echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta ARCHIVOS/\" style=\"width:200px\">";
								echo "</form>";
								echo "</center>";
							echo "</td>";
						echo "</tr><tr>";
							echo "<td style=\"width:400px;\">";
								echo "<br><br><strong>Listado de archivos :</strong><br><br>";
								$sql = "select * from sgm_files_tipos order by nombre";
								$result = mysql_query(convert_sql($sql));
								echo "<table>";
									while ($row = mysql_fetch_array($result)) {
										$sqlele = "select * from sgm_files where id_tipo=".$row["id"];
										$resultele = mysql_query(convert_sql($sqlele));
										while ($rowele = mysql_fetch_array($resultele)) {
											echo "<tr><td style=\"vertical-align:top;\">".$row["nombre"]."</td>";
											echo "<td style=\"vertical-align:top;\"><a href=\"".$urloriginal."/archivos/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
											echo "</td><td style=\"vertical-align:top;width:50px;text-align:right\">".round(($rowele["size"]/1000), 1)." Kb</td>";
											echo "<td style=\"vertical-align:top;\">&nbsp;<a href=\"index.php?op=1020&sop=163&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td></tr>";
										}
									}
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br><br>";
	}

	if ($soption == 161) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este trabajador?";
		echo "<br><br><a href=\"index.php?op=1020&sop=160&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=160\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 162){
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
		subirArchivo($tipo, $archivo, $archivo_name, $archivo_size, $archivo_type);
	}

	if ($soption == 163) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este archivo?";
		echo "<br><br><a href=\"index.php?op=1020&sop=164&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=160&ssop=2&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 164) {
		$sql = "delete from sgm_files WHERE id=".$_GET["id_archivo"]."";
		mysql_query(convert_sql($sql));
		echo "<center><br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1020&sop=160&ssop=2&id=".$_GET["id"]."\">[ Volver ]</a></center>";
	}

	if ($soption == 170){
		echo "<strong>Cursos Formativos</strong><br><br>";
		echo "<center>";
			echo "<table cellspacing=\"0\" style=\"width:375px;vertical-align:top\">";
				echo "<tr style=\"background-color: Silver;\">";
					echo "<td>&nbsp;</td><td><strong>Cursos Realizados</strong></td>";
					echo "<td><strong>Fecha Inicio</strong></td>";
					echo "<td><strong>Fecha Fin</strong></td>";
				echo "</tr>";
				echo "<tr></tr>";
				echo "<tr></tr>";
				$sqlc = "select * from sgm_rrhh_formacion_empleado where id_empleado=".$_GET["id"]." and visible=1";
				$resultc = mysql_query(convert_sql($sqlc));
				while ($rowc = mysql_fetch_array($resultc)){
					$sqlf = "select * from sgm_rrhh_formacion where id=".$rowc["id_curso"];
					$resultf = mysql_query(convert_sql($sqlf));
					while ($rowf = mysql_fetch_array($resultf)){
						echo "<tr>";
							echo "<td>&nbsp;</td><td>".$rowf["nombre"]."</td>";
							echo "<td>".$rowf["fecha_inicio"]."</td>";
							echo "<td>".$rowf["fecha_fin"]."</td></tr>";
					}
				}
			echo "</table>";
		echo "</center>";
		echo "<br>";
	}

	if ($soption == 180){
		if ($ssoption == 1) {
			if (($_POST["data_ini"] > $_POST["data_fi"]) or ($_POST["hora_ini"] > $_POST["hora_fi"]) or ($_POST["hora_ini2"] > $_POST["hora_fi2"])){
				echo "<center>Las fechas o las horas introducidas no son correctas</center>";
			} else {
				$sql = "insert into sgm_rrhh_empleado_horario (id_empleado,data_ini,data_fi,hora_ini,hora_fi,hora_ini2,hora_fi2) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id"];
				$sql = $sql.",'".$_POST["data_ini"]."'";
				$sql = $sql.",'".$_POST["data_fi"]."'";
				$sql = $sql.",'".$_POST["hora_ini"]."'";
				$sql = $sql.",'".$_POST["hora_fi"]."'";
				$sql = $sql.",'".$_POST["hora_ini2"]."'";
				$sql = $sql.",'".$_POST["hora_fi2"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 2) {
			if (($_POST["data_ini"] > $_POST["data_fi"]) or ($_POST["hora_ini"] > $_POST["hora_fi"]) or ($_POST["hora_ini2"] > $_POST["hora_fi2"])) {
				echo "<center>Las fechas o las horas introducidas no son correctas</center>";
			} else {
				$sql = "update sgm_rrhh_empleado_horario set ";
				$sql = $sql."data_ini='".$_POST["data_ini"]."'";
				$sql = $sql.",data_fi='".$_POST["data_fi"]."'";
				$sql = $sql.",hora_ini='".$_POST["hora_ini"]."'";
				$sql = $sql.",hora_fi='".$_POST["hora_fi"]."'";
				$sql = $sql.",hora_ini2='".$_POST["hora_ini2"]."'";
				$sql = $sql.",hora_fi2='".$_POST["hora_fi2"]."'";
				$sql = $sql." WHERE id=".$_GET["id_horari"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_rrhh_empleado_horario set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_horari"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Horarios</strong><br><br>";
		$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$_GET["id"];
		$resulte = mysql_query(convert_sql($sqle));
		$rowe = mysql_fetch_array($resulte);
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:center;\"><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Fecha Inicio</td>";
				echo "<td style=\"text-align:center;\">&nbsp;</td>";
				echo "<td style=\"text-align:center;\">Fecha Fin</td>";
				echo "<td style=\"text-align:center;\">&nbsp;</td>";
				echo "<td style=\"text-align:center;\">Hora Inicio</td>";
				echo "<td style=\"text-align:center;\">Hora Fin</td>";
				echo "<td style=\"text-align:center;\">Hora Inicio 2</td>";
				echo "<td style=\"text-align:center;\">Hora Fin 2</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1020&sop=180&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"data_ini\" style=\"width:100px;text-align:right;\" value=\"0000-00-00\"></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"data_fi\" style=\"width:100px;text-align:right;\" value=\"0000-00-00\"></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"hora_ini\" style=\"width:100px;text-align:right;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_fi\" style=\"width:100px;text-align:right;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_ini2\" style=\"width:100px;text-align:right;\" value=\"00:00\"></td>";
				echo "<td><input type=\"text\" name=\"hora_fi2\" style=\"width:100px;text-align:right;\" value=\"00:00\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$date = getdate();
			if ($date["mon"] < 10){ $date["mon"] = "0".$date["mon"]; }
			$fecha = $date["year"]."-".$date["mon"]."-".$date["mday"];
			$i = "1";
			$sql = "select * from sgm_rrhh_empleado_horario where visible=1 and id_empleado=".$_GET["id"]." order by data_ini desc";
			$result = mysql_query(convert_sql($sql));
			while (($row = mysql_fetch_array($result)) and ($i <=4)){
				$color = "white";
				if (($fecha >= $row["data_ini"]) and ($fecha <= $row["data_fi"])) { $color = "red"; }
				echo "<tr style=\"background-color:".$color."\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1020&sop=181&id=".$_GET["id"]."&id_horari=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1020&sop=180&ssop=2&id=".$_GET["id"]."&id_horari=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" name=\"data_ini\" style=\"width:100px;text-align:right;\" value=\"".$row["data_ini"]."\"></td>";
					echo "<td></td>";
					echo "<td><input type=\"text\" name=\"data_fi\" style=\"width:100px;text-align:right;\" value=\"".$row["data_fi"]."\"></td>";
					echo "<td></td>";
					echo "<td><input type=\"text\" name=\"hora_ini\" style=\"width:100px;text-align:right;\" value=\"".$row["hora_ini"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_fi\" style=\"width:100px;text-align:right;\" value=\"".$row["hora_fi"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_ini2\" style=\"width:100px;text-align:right;\" value=\"".$row["hora_ini2"]."\"></td>";
					echo "<td><input type=\"text\" name=\"hora_fi2\" style=\"width:100px;text-align:right;\" value=\"".$row["hora_fi2"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
					echo "<td></td>";
					echo "</form>";
				echo "</tr>";
				$i ++;
			}
		echo "</table></center><br>";
	}

	if ($soption == 181) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este horario?";
		echo "<br><br><a href=\"index.php?op=1020&sop=180&ssop=3&id=".$_GET["id"]."&id_horari=".$_GET["id_horari"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=180\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 190){
		echo "<strong>Contratos</strong><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:375px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td>&nbsp;</td><td><strong>Puesto Trabajo</strong></td>";
				echo "<td><strong>Fecha Alta</strong></td>";
				echo "<td><strong>Fecha Baja</strong></td>";
			echo "</tr>";
			echo "<tr></tr>";
			echo "<tr></tr>";
			$sqlpe = "select * from sgm_rrhh_puesto_empleado where id_empleado=".$_GET["id"]." and visible=1";
			$resultpe = mysql_query(convert_sql($sqlpe));
			while ($rowpe = mysql_fetch_array($resultpe)){
				$sqle = "select * from sgm_rrhh_puesto_trabajo where id=".$rowpe["id_puesto"];
				$resulte = mysql_query(convert_sql($sqle));
				while ($rowe = mysql_fetch_array($resulte)){
					echo "<tr><td>&nbsp;</td><td>".$rowe["puesto"]."</td>";
					echo "<td>".$rowpe["fecha_alta"]."</td>";
					echo "<td>".$rowpe["fecha_baja"]."</td></tr>";
				}
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1020&sop=510","op=1020&sop=520","op=1020&sop=530"),array($Calendario." ".$$Laboral,$Horarios,$Departamentos));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "dia,mes,descripcio";
			$datosInsert = array($_POST["dia"],$_POST["mes"],$_POST["descripcio"]);
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

	if ($soption == 511) {
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

	if (($soption == 535) AND ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "id_departamento,puesto";
			$datosInsert = array($_POST["id_departamento"],$_POST["puesto"]);
			insertFunction ("sgm_rrhh_puesto_trabajo",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("id_departamento","puesto");
			$datosUpdate = array($_POST["id_departamento"],$_POST["puesto"]);
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_rrhh_puesto_trabajo",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sql = "select * from sgm_rrhh_puesto_trabajo where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);

			$camposinsert = "id_departamento,puesto";
			$datosInsert = array($row["id_departamento"],$row["puesto"]);
			insertFunction ("sgm_rrhh_puesto_trabajo",$camposinsert,$datosInsert);
		}

		$sql = "select * from sgm_rrhh_departamento where visible=1 and id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<h4>".$Puestos_trabajo." : ".$row["departamento"]."</h4>";
		echo boton(array("op=1020&sop=530"),array("&laquo; ".$Volver));
		echo boton(array("op=1020&sop=535&id=".$_GET["id"]."&edit=1"),array($Anadir." ".$Puesto));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Puesto_trabajo."</th>";
				echo "<th>".$Empleado."</th>";
				echo "<th style=\"text-align:center;vertical-align:bottom;\"><em>Editar</em></th>";
				echo "<th style=\"text-align:center;vertical-align:bottom;\"><em>Hist.</em></th>";
				echo "<th style=\"text-align:center;vertical-align:bottom;\"><em>Dupl.</em></th>";
			echo "</tr>";
			$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$_GET["id"]." order by puesto";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr>";
					echo "<td style=\"text-align:center;\">";
					$trobat = busca_puesto($row["id"]);
					if ($trobat == 0){
						echo "<a href=\"index.php?op=1020&sop=536&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a>";
					}
					echo "</td>";
					$x = "black";
					if ($row["activo"] == 0) { $x = "silver"; }
					echo "<td style=\"text-align:left;color:".$x."\">".$row["puesto"]."</td>";
					echo "<form action=\"index.php?op=1020&sop=535&id=".$_GET["id"]."&edit=2\" method=\"post\">";
						echo "<td><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1020&sop=537&id=".$_GET["id"]."\" method=\"post\">";
						echo "<td><input type=\"Submit\" value=\"".$Historico."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1020&sop=538&id=".$_GET["id"]."\" method=\"post\">";
						echo "<td><input type=\"Submit\" value=\"".$Duplicar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";

		if ($_GET["edit"] == 1){
			echo "<h4>".$Anadir." ".$Puesto."</h4>";
			echo "<form action=\"index.php?op=1020&sop=535&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
		}
		if ($_GET["edit"] == 2) {
			echo "<h4>".$Editar." ".$Puesto."</h4>";
			echo "<form action=\"index.php?op=1020&sop=535&ssop=2&id=".$_GET["id"]."&id_puesto=".$row["id"]."\" method=\"post\">";
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id=".$_GET["id"]."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<tr>";
				if ($ssoption == 1) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:200px\"></td>"; }
				if ($ssoption == 2) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"".$Editar."\" style=\"width:200px\"></td>"; }
			echo "</tr><tr>";
				echo "<td>Puesto</td>";
				echo "<td><input type=\"text\" name=\"puesto\" value=\"".$row["puesto"]."\" style=\"width:200px\"></td>";
			echo "</tr><tr>";
				echo "<td>Departamento</td>";
				echo "<td><select name=\"id_departamento\" style=\"width:200px\">";
						echo "<option value=\"0\" selected>-</option>";
						$sqld = "select * from sgm_rrhh_departamento where visible=1";
						$resultd = mysql_query(convert_sql($sqld));
						while ($rowd = mysql_fetch_array($resultd)){
							if ($row["id_departamento"] == $rowd["id"]) { echo "<option value=\"".$rowd["id"]."\" selected>".$rowd["departamento"]."</option>";
								} else { echo "<option value=\"".$rowd["id"]."\">".$rowd["departamento"]."</option>";
							}
						}
					echo "</select></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;\">Funciones y Tareas</td>";
				echo "<td><textarea rows=\"5\" name=\"tareas\" style=\"width:500px\">".$row["tareas"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;\">Formación General</td>";
				echo "<td><textarea rows=\"5\" name=\"f_general\" style=\"width:500px\">".$row["f_general"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;\">Formación Especifica</td>";
				echo "<td><textarea rows=\"5\" name=\"f_especifica\" style=\"width:500px\">".$row["f_especifica"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;\">Experiencia</td>";
				echo "<td><textarea rows=\"5\" name=\"experiencia\" style=\"width:500px\">".$row["experiencia"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;\">Habilidades Personales</td>";
				echo "<td><textarea rows=\"5\" name=\"habilidades\" style=\"width:500px\">".$row["habilidades"]."</textarea></td>";
			echo "</tr><tr>";
				if ($ssoption == 1) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"Añadir\" style=\"width:200px\"></td>"; }
				if ($ssoption == 2) {echo "<td>Activo</td>";
									echo "<td><select name=\"activo\" style=\"50px\">";
									$sql = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id=".$_GET["id"]."";
									$result = mysql_query(convert_sql($sql));
									$row = mysql_fetch_array($result);
									if (($row["activo"] == "") or ($row["activo"] == 1)){
										echo "<option value=\"0\">NO</option>";
										echo "<option value=\"1\" selected>SI</option>";
										}else{
										echo "<option value=\"0\" selected>NO</option>";
										echo "<option value=\"1\">SI</option>";
										}
									echo "</select></td>";
									echo "</tr><tr><td>&nbsp;</td><td><input type=\"submit\" value=\"Modificar\" style=\"width:200px\"></td></tr>"; }
			echo "<tr></tr>";
			echo "</form>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 42) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este puesto de trabajo?";
		echo "<br><br><a href=\"index.php?op=1020&sop=40&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=40\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 43) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea duplicar este puesto de trabajo?";
		echo "<br><br><a href=\"index.php?op=1020&sop=40&ssop=4&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1020&sop=40\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 44){
		$sql = "select * from sgm_rrhh_puesto_trabajo where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "Puesto de Trabajo : <strong>".$row["puesto"]."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1020&sop=40\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td>&nbsp;</td><td><strong>Nombre Trabajador</strong></td><td>&nbsp;</td><td><strong>Fecha Alta</strong></td><td>&nbsp;</td><td><strong>Fecha Baja</strong></td>";			echo "<tr></tr>";
			echo "<tr></tr>";
			$sqlpe = "select * from sgm_rrhh_puesto_empleado where id_puesto=".$row["id"];
			$resultpe = mysql_query(convert_sql($sqlpe));
			while ($rowpe = mysql_fetch_array($resultpe)){
				$sqle = "select * from sgm_rrhh_empleado where id=".$rowpe["id_empleado"];
				$resulte = mysql_query(convert_sql($sqle));
				while ($rowe = mysql_fetch_array($resulte)){
					echo "<tr><td>&nbsp;</td><td>".$rowe["nombre"]."</td><td>&nbsp;</td><td>".$rowpe["fecha_alta"]."</td><td>&nbsp;</td><td>".$rowpe["fecha_baja"]."</td></tr>";
				}
			}
		echo "</table>";
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

function busca_departamentos($id,$x)
{ 
	global $db;
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=".$id;
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr><td style=\"padding-left: ".$x."px;\">";
					echo "&nbsp;<a href=\"\"><img src=\"mgestion/pics/icons-mini/chart_organisation.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"index.php?op=1020&sop=40\"><img src=\"mgestion/pics/icons-mini/status_online.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"\"><img src=\"mgestion/pics/icons-mini/status_away.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"index.php?op=1020&sop=50\"><img src=\"mgestion/pics/icons-mini/user_gray.png\" border=\"0\"></a>";
					echo "&nbsp;".$row["departamento"]."";
				echo "</td></tr>";
				busca_departamentos($row["id"],($x+50));
			}
}

function busca_departamentos2($id,$x)
{ 
	global $db;
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=".$id;
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr><td style=\"padding-left: ".$x."px;\">";
				echo "<img src=\"mgestion/pics/icons-mini/user_gray.png\" border=\"0\">&nbsp;<strong>".$row["departamento"]."</strong>";
				$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$row["id"]." order by puesto";
				$resultp = mysql_query(convert_sql($sqlp));
				while ($rowp = mysql_fetch_array($resultp)){
					$sqlpe = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"]." and fecha_baja= '0000-00-00'";
					$resultpe = mysql_query(convert_sql($sqlpe));
					while ($rowpe = mysql_fetch_array($resultpe)){
						$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$rowpe["id_empleado"]."";
						$resulte = mysql_query(convert_sql($sqle));
						$rowe = mysql_fetch_array($resulte);
						echo "</td></tr><tr><td style=\"padding-left: ".$x."px;\">";
						echo "&nbsp;<a href=\"\"><img src=\"mgestion/pics/icons-mini/user.png\" border=\"0\"></a>";
						echo "&nbsp;".$rowp["puesto"].": &nbsp;".$rowe["nombre"]."";
						echo "<tr><td>";
					}
				}
				echo "</td></tr>";
				busca_departamentos2($row["id"],($x+50));
			}
}

?>
