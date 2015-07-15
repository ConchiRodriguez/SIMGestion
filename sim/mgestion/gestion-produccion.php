<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
include ("../auxiliar/functions.php");
include ("/imagen.php");

if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1023) AND ($autorizado == true)) {
	if ($_GET["usuario"] == "") {
		$usuario = $userid;
	} else {
		$sql = "select * from sgm_users where id=".$_GET["usuario"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$usuario = $row["id"];
	}
	$sql = "select * from sgm_users where id=".$usuario;
	$result = mysql_query(convert_sql($sql));
	$rowusuario = mysql_fetch_array($result);

	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<strong>".$Auxiliares."</strong>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($soption == 550) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=550\" class=".$class.">".$Tamano." ".$Papel."</a></td>";
				if ($soption == 130) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=130\" class=".$class.">".$Idioma."</a></td>";
				if ($soption == 140) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=140\" class=".$class.">".$Pais."</a></td>";
				if ($soption == 500) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=500\" class=".$class.">".$Tarifas."</a></td>";
				if ($soption == 800) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=800\" class=".$class.">".$Calendario."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
	}
	if (((admin($userid,1015) == false) and (admin($userid,1006) == false)) and ($soption >= 100) and ($soption < 300)) { echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
	else {

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_ft_plantilla (plantilla,id_tamany_papel) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["plantilla"]."'";
			$sql = $sql.",".$_POST["id_tamany_papel"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));

			$sqlp = "select * from sgm_ft_plantilla where plantilla='".$_POST["plantilla"]."'";
			$resultp = mysql_query(convert_sql($sqlp));
			$rowp = mysql_fetch_array($resultp);

			$sqlc = "insert into sgm_ft_plantilla_tipus (id_ft,tipus,taula,sgm_taula,sgm_campo,sgm_sql,obligatorio,sgm_campo_visualizado)";
			$sqlc = $sqlc."values (";
			$sqlc = $sqlc."".$rowp["id"]."";
			$sqlc = $sqlc.",'Cliente'";
			$sqlc = $sqlc.",1";
			$sqlc = $sqlc.",'sgm_clients'";
			$sqlc = $sqlc.",'id'";
			$sqlc = $sqlc.",'select * from sgm_clients where visible=1'";
			$sqlc = $sqlc.",1";
			$sqlc = $sqlc.",'nombre'";
			$sqlc = $sqlc.")";
			mysql_query(convert_sql($sqlc));

			$sqlu = "insert into sgm_ft_plantilla_tipus (id_ft,tipus,taula,sgm_taula,sgm_campo,sgm_sql,obligatorio,sgm_campo_visualizado) ";
			$sqlu = $sqlu."values (";
			$sqlu = $sqlu."".$rowp["id"]."";
			$sqlu = $sqlu.",'Usuario Destino'";
			$sqlu = $sqlu.",1";
			$sqlu = $sqlu.",'sgm_users'";
			$sqlu = $sqlu.",'id'";
			$sqlu = $sqlu.",'select * from sgm_users where validado=1 and activo=1 and sgm=1'";
			$sqlu = $sqlu.",1";
			$sqlu = $sqlu.",'usuario'";
			$sqlu = $sqlu.")";
			mysql_query(convert_sql($sqlu));

			$sqlf = "insert into sgm_ft_plantilla_tipus (id_ft,tipus,taula,obligatorio) ";
			$sqlf = $sqlf."values (";
			$sqlf = $sqlf."".$rowp["id"]."";
			$sqlf = $sqlf.",'Fecha Prevision'";
			$sqlf = $sqlf.",0";
			$sqlf = $sqlf.",1";
			$sqlf = $sqlf.")";
			mysql_query(convert_sql($sqlf));

			$sqla = "insert into sgm_ft_plantilla_tipus (id_ft,tipus,taula,obligatorio) ";
			$sqla = $sqla."values (";
			$sqla = $sqla."".$rowp["id"]."";
			$sqla = $sqla.",'Asunto'";
			$sqla = $sqla.",0";
			$sqla = $sqla.",1";
			$sqla = $sqla.")";
			mysql_query(convert_sql($sqla));
		}

		if ($ssoption == 2) {
			$sql = "update sgm_ft_plantilla set ";
			$sql = $sql."plantilla='".$_POST["plantilla"]."'";
			$sql = $sql.",id_tamany_papel='".$_POST["id_tamany_papel"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		if ($ssoption == 3) {
			$sql = "update sgm_ft_plantilla set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Plantillas."</strong><br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Nombre."</td>";
				echo "<td>".$Tamano."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=100&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"plantilla\" style=\"width:150px\"></td>";
				echo "<td>";
					echo "<select name=\"id_tamany_papel\" style=\"width:150px;\">";
						$sqlp = "select * from sgm_tamany_paper";
						$resultp = mysql_query(convert_sql($sqlp));
						while ($rowp = mysql_fetch_array($resultp)){
							if ($rowp["predeterminado"]== 1){
								echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowp["id"]."\">".$rowp["nombre"]."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_ft_plantilla where visible=1 order by plantilla";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align: center;\"><a href=\"index.php?op=1023&sop=101&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=100&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"plantilla\" style=\"width:150px\" value=\"".$row["plantilla"]."\"></td>";
					echo "<td>";
						echo "<select name=\"id_tamany_papel\" style=\"width:150px;\">";
							$sqlp = "select * from sgm_tamany_paper";
							$resultp = mysql_query(convert_sql($sqlp));
							while ($rowp = mysql_fetch_array($resultp)){
								if ($rowp["id"]==$row["id_tamany_papel"]){
									echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["nombre"]."</option>";
								}else{
									echo "<option value=\"".$rowp["id"]."\">".$rowp["nombre"]."</option>";
								}
							}
					echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
					echo "</form>";
					echo "<td>&nbsp;</td>";
					echo "<td style=\"width:100px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1023&sop=105&id=".$row["id"]."\" style=\"color:white;\">".$Descripcion."</a></td>";
					echo "<td>&nbsp;</td>";
					echo "<td style=\"width:100px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1023&sop=110&id=".$row["id"]."\" style=\"color:white;\">".$Editar." ".$Plantilla."</a></td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=100&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=100\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 105) {

		if ($ssoption == 1) {
			$sql = "update sgm_ft_plantilla set ";
			$sql = $sql."descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		$sql = "select * from sgm_ft_plantilla where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>".$Descripccion." ".$Plantilla." : </strong>".$row["plantilla"]."";
		echo "<br>";
		echo boton_volver($Volver);
		echo "<br><center>";
		echo "<form action=\"index.php?op=1023&sop=105&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
		echo "<textarea name=\"descripcion\" rows=\"10\" style=\"width:500px\">".$row["descripcion"]."</textarea>";
		echo "<br><br><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\">";
		echo "</center></form>";
	}

	if ($soption == 110) {
		if ($ssoption == 1) {
			if (((strcasecmp($_POST["tipus"],'Cliente') == 0) or (strcasecmp($_POST["tipus"],'Usuario Destino') == 0) or (strcasecmp($_POST["tipus"],'Fecha Prevision') == 0) or (strcasecmp($_POST["tipus"],'Asunto') == 0)) and ($ssoption == 0)){
				echo mensaje_error("El tipo introducido no es valido.");
			} else {
				$x = is_numeric($_POST["x_posicion"]);
				$y = is_numeric($_POST["y_posicion"]);
				$w = is_numeric($_POST["x_ancho"]);
				$z = is_numeric($_POST["y_alto"]);
				if (($x == true) and ($y == true) and ($w == true) and ($z == true)){

					$sqlp = "select a.x from sgm_tamany_paper a join sgm_ft_plantilla b ON a.id=b.id_tamany_papel";
					$resultp = mysql_query(convert_sql($sqlp));
					$rowp = mysql_fetch_array($resultp);
					$long = $_POST["x_posicion"]+$_POST["x_ancho"];
					if ($rowp["x"] > $long){
						$sql = "insert into sgm_ft_plantilla_tipus (tipus,descripcion,x_posicion,y_posicion,x_ancho,y_alto,taula,id_ft,sgm_taula,sgm_campo,sgm_sql,obligatorio,visualizar,sgm_campo_visualizado)";
						$sql = $sql."values (";
						$sql = $sql."'".$_POST["tipus"]."'";
						$sql = $sql.",'".comillas($_POST["descripcion"])."'";
						$sql = $sql.",".$_POST["x_posicion"]."";
						$sql = $sql.",".$_POST["y_posicion"]."";
						$sql = $sql.",".$_POST["x_ancho"]."";
						$sql = $sql.",".$_POST["y_alto"]."";
						$sql = $sql.",".$_POST["taula"]."";
						$sql = $sql.",".$_GET["id"]."";
						$sql = $sql.",'".$_POST["sgm_taula"]."'";
						$sql = $sql.",'".$_POST["sgm_campo"]."'";
						$sql = $sql.",'".$_POST["sgm_sql"]."'";
						$sql = $sql.",0";
						$sql = $sql.",1";
						$sql = $sql.",'".$_POST["sgm_campo_visualizado"]."'";
						$sql = $sql.")";
						mysql_query(convert_sql($sql));
						echo "<center>";
						echo mensaje_error_c("Operación realizada correctamente.","Green");
					} else {
						echo "<center>";
						echo mensaje_error("El tipo de la plantilla queda fuera de las medidas del papel.");
					}
				} else {
					echo "<center>";
					echo mensaje_error("Los campos de posición y los de amplitud y altura han ser numéricos.");
				}
			}
			echo "</center>";
		}

		if ($ssoption == 2) {
			if (((strcasecmp($_POST["tipus".$row["id"]],'Cliente') == 0) or (strcasecmp($_POST["tipus".$row["id"]],'Usuario Destino') == 0) or (strcasecmp($_POST["tipus".$row["id"]],'Fecha Prevision') == 0) or (strcasecmp($_POST["tipus".$row["id"]],'Asunto') == 0)) and ($_GET[oblig==0])){
				echo "<center>";
				echo mensaje_error("El tipo introducido no es valido.");
			} else {
				$error1=0;
				$error2=0;
				$error3=0;
				$sql = "select * from sgm_ft_plantilla_tipus where visible=1 and id_ft=".$_GET["id"];
				if ($_GET["oblig"]==0){$sql .= " and obligatorio=1";}
				if ($_GET["oblig"]==1){$sql .= " and obligatorio=0";}
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)){
					$x = is_numeric($_POST["x_posicion".$row["id"]]);
					$y = is_numeric($_POST["y_posicion".$row["id"]]);
					$w = is_numeric($_POST["x_ancho".$row["id"]]);
					$z = is_numeric($_POST["y_alto".$row["id"]]);
					if (($x == true) and ($y == true) and ($w == true) and ($z == true)){
						$sqlp = "select a.x from sgm_tamany_paper a join sgm_ft_plantilla b ON a.id=b.id_tamany_papel";
						$resultp = mysql_query(convert_sql($sqlp));
						$rowp = mysql_fetch_array($resultp);
						$long = $_POST["x_posicion".$row["id"]]+$_POST["x_ancho".$row["id"]];
						if ($rowp["x"] > $long){
							$sql = "update sgm_ft_plantilla_tipus set ";
							$sql = $sql."tipus='".$_POST["tipus".$row["id"]]."'";
							$sql = $sql.",visualizar='".$_POST["visualizar".$row["id"]]."'";
							$sql = $sql.",descripcion='".$row["descripcion"]."'";
							$sql = $sql.",x_posicion=".$_POST["x_posicion".$row["id"]]."";
							$sql = $sql.",y_posicion=".$_POST["y_posicion".$row["id"]]."";
							$sql = $sql.",x_ancho=".$_POST["x_ancho".$row["id"]]."";
							$sql = $sql.",y_alto=".$_POST["y_alto".$row["id"]]."";
							$sql = $sql.",taula=".$_POST["taula".$row["id"]]."";
							$sql = $sql.",sgm_taula='".$row["sgm_taula"]."'";
							$sql = $sql.",sgm_campo='".$row["sgm_campo"]."'";
							$sql = $sql.",sgm_sql='".$row["sgm_sql"]."'";
							$sql = $sql.",sgm_campo_visualizado='".$row["sgm_campo_visualizado"]."'";
							$sql = $sql." WHERE id=".$row["id"]."";
							mysql_query(convert_sql($sql));
							$error1 = 1;
						} else {
							$error2 = 1;
						}
					} else {
						$error3 = 1;
					}
				}
				echo "<center>";
				if ($error3==1){echo mensaje_error("Los campos de posición y los de amplitud y altura han ser numéricos.");}
				else {if ($error2==1){echo mensaje_error("El tipo de la plantilla queda fuera de las medidas del papel.");}
				else {if ($error1==1){echo mensaje_error_c("Operación realizada correctamente.","Green");}}}
			}
			echo "</center>";
		}

		$sql = "select * from sgm_ft_plantilla where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<table><tr>";
				echo "<td class=\"menu\"><a href=\"index.php?op=1023&sop=100\" style=\"color:white;\">".$Volver."</a></td>";
				echo "<td style=\"width:660px;text-align:center;\"><strong>".$Edicion." ".$Plantilla.": </strong>".$row["plantilla"]."</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td></td>";
				echo "<td>".$Tipo."</td>";
				echo "<td>".$Descripcion."</td>";
				echo "<td>".$Posicion." X<br>(mm)</td>";
				echo "<td>".$Posicion." Y<br>(mm)</td>";
				echo "<td>".$Ancho." X<br>(mm)</td>";
				echo "<td>".$Alto." Y<br>(mm)</td>";
				echo "<td>".$Tabla."</td>";
			echo "</tr>";

			echo "<tr>";
			$sqlcc = "select count(*) as total from sgm_ft_plantilla_tipus where visible=1 and id_ft=".$_GET["id"]." and (tipus='Cliente' or tipus='Asunto' or tipus='Usuario Destino' or tipus='Fecha Prevision')";
			$resultcc = mysql_query(convert_sql($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			if ($rowcc["total"] == 0) {
				echo "<form action=\"index.php?op=1023&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			} else {
				echo "<form action=\"index.php?op=1023&sop=110&ssop=2&oblig=0&id=".$_GET["id"]."\" method=\"post\">";
			}

			### INICI CAMP OBLIGATORI CLIENTE
			$sqlc = "select * from sgm_ft_plantilla_tipus where id_ft=".$_GET["id"]." and tipus='Cliente'";
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
				echo "<td>";
				echo "<select name=\"visualizar".$rowc["id"]."\" style=\"width:75px\">";
					if ($rowc["visualizar"]== 0){
						echo "<option value=\"0\" selected>No ".$Ver."</option>";
						echo "<option value=\"1\">".$Ver."</option>";
					}
					if ($rowc["visualizar"]== 1){
						echo "<option value=\"0\">No ".$Ver."</option>";
						echo "<option value=\"1\" selected>".$Ver."</option>";
					}
				echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"\" style=\"width:150px\" value=\"Cliente\" disabled></td>";
				echo "<td><input type=\"Text\" name=\"descripcion".$rowc["id"]."\" style=\"width:200px\" value=\"".$rowc["descripcion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_ancho".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_ancho"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_alto".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_alto"]."\"></td>";
				echo "<td>";
				echo "<select name=\"\" style=\"width:50px\" disabled>";
						echo "<option value=\"1\" selected>SI</option>";
				echo "</select>";
				echo "</td>";
				echo "<input type=\"Hidden\"  name=\"tipus".$rowc["id"]."\" style=\"width:150px\" value=\"Cliente\">";
				echo "<input type=\"Hidden\"  name=\"taula".$rowc["id"]."\" style=\"width:150px\" value=\"1\">";
				echo "<td>";
			echo "</tr>";
			### FI CAMP OBLIGATORI CLIENTE
			### INICI CAMP OBLIGATORI USUARI DESTÍ
			echo "<tr>";
			$sqlc = "select * from sgm_ft_plantilla_tipus where id_ft=".$_GET["id"]." and tipus='Usuario Destino'";
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
				echo "<td>";
				echo "<select name=\"visualizar".$rowc["id"]."\" style=\"width:75px\">";
					if ($rowc["visualizar"]== 0){
						echo "<option value=\"0\" selected>No ".$Ver."</option>";
						echo "<option value=\"1\">".$Ver."</option>";
					}
					if ($rowc["visualizar"]== 1){
						echo "<option value=\"0\">No ".$Ver."</option>";
						echo "<option value=\"1\" selected>".$Ver."</option>";
					}
				echo "</td>";
				echo "<input type=\"Hidden\"  name=\"tipus".$rowc["id"]."\" style=\"width:150px\" value=\"Usuario Destino\">";
				echo "<input type=\"Hidden\"  name=\"taula".$rowc["id"]."\" style=\"width:150px\" value=\"1\">";
				echo "<td><input type=\"Text\" name=\"\" style=\"width:150px\" value=\"Usuario Destino\" disabled></td>";
				echo "<td><input type=\"Text\" name=\"descripcion".$rowc["id"]."\" style=\"width:200px\" value=\"".$rowc["descripcion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_ancho".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_ancho"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_alto".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_alto"]."\"></td>";
				echo "<td>";
				echo "<select name=\"\" style=\"width:50px\" disabled>";
						echo "<option value=\"1\" selected>SI</option>";
				echo "</select>";
				echo "</td>";
			echo "</tr>";
			### FI CAMP OBLIGATORI USUARI DESTÍ
			### INICI CAMP OBLIGATORI FECHA PREVISIÓN
			echo "<tr>";
			$sqlc = "select * from sgm_ft_plantilla_tipus where id_ft=".$_GET["id"]." and tipus='Fecha Prevision'";
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
				echo "<td>";
				echo "<select name=\"visualizar".$rowc["id"]."\" style=\"width:75px\">";
					if ($rowc["visualizar"]== 0){
						echo "<option value=\"0\" selected>No ".$Ver."</option>";
						echo "<option value=\"1\">".$Ver."</option>";
					}
					if ($rowc["visualizar"]== 1){
						echo "<option value=\"0\">No ".$Ver."</option>";
						echo "<option value=\"1\" selected>".$Ver."</option>";
					}
				echo "</td>";
				echo "<input type=\"Hidden\"  name=\"tipus".$rowc["id"]."\" style=\"width:150px\" value=\"Fecha Prevision\">";
				echo "<input type=\"Hidden\"  name=\"taula".$rowc["id"]."\" style=\"width:150px\" value=\"0\">";
				echo "<td><input type=\"Text\" name=\"\" style=\"width:150px\" value=\"Fecha Previsión\" disabled></td>";
				echo "<td><input type=\"Text\" name=\"descripcion".$rowc["id"]."\" style=\"width:200px\" value=\"".$rowc["descripcion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_ancho".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_ancho"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_alto".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_alto"]."\"></td>";
				echo "<td>";
				echo "<select name=\"\" style=\"width:50px\" disabled>";
						echo "<option value=\"0\" selected>NO</option>";
				echo "</select>";
				echo "</td>";
			echo "</tr>";
			### FI CAMP OBLIGATORI FECHA PREVISIÓN
			### INICI CAMP OBLIGATORI ASUNTO
			echo "<tr>";
			$sqlc = "select * from sgm_ft_plantilla_tipus where id_ft=".$_GET["id"]." and tipus='Asunto'";
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
				echo "<td>";
				echo "<select name=\"visualizar".$rowc["id"]."\" style=\"width:75px\">";
					if ($rowc["visualizar"]== 0){
						echo "<option value=\"0\" selected>No ".$Ver."</option>";
						echo "<option value=\"1\">".$Ver."</option>";
					}
					if ($rowc["visualizar"]== 1){
						echo "<option value=\"0\">No ".$Ver."</option>";
						echo "<option value=\"1\" selected>".$Ver."</option>";
					}
				echo "</td>";
				echo "<input type=\"Hidden\"  name=\"tipus".$rowc["id"]."\" style=\"width:150px\" value=\"Asunto\">";
				echo "<input type=\"Hidden\"  name=\"taula".$rowc["id"]."\" style=\"width:150px\" value=\"0\">";
				echo "<td><input type=\"Text\" name=\"\" style=\"width:150px\" value=\"Asunto\" disabled></td>";
				echo "<td><input type=\"Text\" name=\"descripcion".$rowc["id"]."\" style=\"width:200px\" value=\"".$rowc["descripcion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_posicion".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_posicion"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"x_ancho".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["x_ancho"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"y_alto".$rowc["id"]."\" style=\"width:70px;text-align:right\" value=\"".$rowc["y_alto"]."\"></td>";
				echo "<td>";
				echo "<select name=\"\" style=\"width:50px\" disabled>";
						echo "<option value=\"0\" selected>NO</option>";
				echo "</select>";
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:200px\"></td>";
				echo "</form>";
			echo "</tr>";

			### FI CAMP OBLIGATORI ASUNTO
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Tipo."</td>";
				echo "<td>".$Descripcion."</td>";
				echo "<td>".$Posicion." X<br>(mm)</td>";
				echo "<td>".$Posicion." Y<br>(mm)</td>";
				echo "<td>".$Ancho." X<br>(mm)</td>";
				echo "<td>".$Alto." Y<br>(mm)</td>";
				echo "<td>".$Tabla."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"tipus\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"x_posicion\" style=\"width:70px;text-align:right\" value=\"0\"></td>";
				echo "<td><input type=\"Text\" name=\"y_posicion\" style=\"width:70px;text-align:right\" value=\"0\"></td>";
				echo "<td><input type=\"Text\" name=\"x_ancho\" style=\"width:70px;text-align:right\" value=\"0\"></td>";
				echo "<td><input type=\"Text\" name=\"y_alto\" style=\"width:70px;text-align:right\" value=\"0\"></td>";
				echo "<td>";
					echo "<select name=\"taula\" style=\"width:50px\">";
						echo "<option value=\"1\">SI</option>";
						echo "<option value=\"0\" selected>NO</option>";
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1023&sop=110&ssop=2&oblig=1&id=".$_GET["id"]."\" method=\"post\">";
			$sql = "select * from sgm_ft_plantilla_tipus where visible=1 and id_ft=".$_GET["id"]." and obligatorio=0";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<input type=\"Hidden\"  name=\"visualizar".$row["id"]."\" style=\"width:150px\" value=\"1\">";
					echo "<td style=\"text-align: center;\"><a href=\"index.php?op=1023&sop=113&ssop=0&id=".$_GET["id"]."&id_tipo=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input type=\"Text\" name=\"tipus".$row["id"]."\" style=\"width:150px\" value=\"".$row["tipus"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion".$row["id"]."\" style=\"width:200px\" value=\"".$row["descripcion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"x_posicion".$row["id"]."\" style=\"width:70px;text-align:right\" value=\"".$row["x_posicion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"y_posicion".$row["id"]."\" style=\"width:70px;text-align:right\" value=\"".$row["y_posicion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"x_ancho".$row["id"]."\" style=\"width:70px;text-align:right\" value=\"".$row["x_ancho"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"y_alto".$row["id"]."\" style=\"width:70px;text-align:right\" value=\"".$row["y_alto"]."\"></td>";
					echo "<td>";
						echo "<select name=\"taula".$row["id"]."\" style=\"width:50px\">";
							if ($row["taula"] == 0) {
								echo "<option value=\"1\">SI</option>";
								echo "<option value=\"0\" selected>NO</option>";
							}
							if ($row["taula"] == 1) {
								echo "<option value=\"1\" selected>SI</option>";
								echo "<option value=\"0\">NO</option>";
							}
						echo "</select>";
					echo "</td>";
					if ($row["taula"] == 1) {
						echo "<td style=\"width:70px;height:14px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1023&sop=120&id_ft=".$_GET["id"]."&id_ft_tipus=".$row["id"]."\" style=\"color:white;\">".$Editar." ".$Tipo."</a>";
						echo "</td>";
					}
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td></td><td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:200px\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 113) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=114&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=110&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 114) {
		echo "<center>";
		$sql = "update sgm_ft_plantilla_tipus set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id_tipo"]."";
		mysql_query(convert_sql($sql));
		echo "<br><br><a href=\"index.php?op=1023&sop=110&id=".$_GET["id"]."\">[ ".$Volver." ]</a>";
		echo "</center>";
	}

	if ($soption == 115) {
		echo "<center>";
		$sql = "update sgm_ft_plantilla_tipus set ";
		$sql = $sql."visualizar = 1";
		$sql = $sql." WHERE id =".$_GET["id_plan"]."";
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente";
		echo "<br><br><a href=\"index.php?op=1023&sop=110&id=".$_GET["id"]."\">[ ".$Volver." ]</a>";
		echo "</center>";
	}

	if ($soption == 116) {
		echo "<center>";
		$sql = "update sgm_ft_plantilla_tipus set ";
		$sql = $sql."visualizar = 0";
		$sql = $sql." WHERE id =".$_GET["id_plan"]."";
		mysql_query(convert_sql($sql));
		echo "<br><br>Operación realizada correctamente";
		echo "<br><br><a href=\"index.php?op=1023&sop=110&id=".$_GET["id"]."\">[ ".$Volver." ]</a>";
		echo "</center>";
	}

	if ($soption == 120) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_ft_plantilla_tipus_campos (campos,id_ft_plantilla_tipus)";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["campos"]."'";
			$sql = $sql.",".$_GET["id_ft_tipus"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_ft_plantilla_tipus_campos set ";
			$sql = $sql."campos='".$_POST["campos"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_ft_plantilla_tipus_campos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		$sql = "select * from sgm_ft_plantilla_tipus where id=".$_GET["id_ft_tipus"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<table><tr>";
				echo "<td class=\"menu\"><a href=\"index.php?op=1023&sop=110&id=".$_GET["id_ft"]."\" style=\"color:white;\">".$Volver."</a></td>";
				echo "<td style=\"width:660px;text-align:center;\"><strong>".$Edicion." ".$Tabla.": </strong>".$row["tipus"]."</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Nombre." ".$Tabla."</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=120&ssop=1&id_ft_tipus=".$_GET["id_ft_tipus"]."&id_ft=".$_GET["id_ft"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"campos\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_ft_plantilla_tipus_campos where id_ft_plantilla_tipus=".$_GET["id_ft_tipus"]." and visible=1 order by campos";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align: center;\"><a href=\"index.php?op=1023&sop=123&id=".$row["id"]."&id_ft_tipus=".$_GET["id_ft_tipus"]."&id_ft=".$_GET["id_ft"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=120&ssop=2&id=".$row["id"]."&id_ft_tipus=".$_GET["id_ft_tipus"]."&id_ft=".$_GET["id_ft"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"campos\" style=\"width:150px\" value=\"".$row["campos"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 123) {
		echo "<center>";
		echo "<br><br>¿Desea eliminar el nombre seleccionado?";
		echo "<br><br><a href=\"index.php?op=1023&sop=120&ssop=3&id_ft_tipus=".$_GET["id_ft_tipus"]."&id_ft=".$_GET["id_ft"]."&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=120&id_ft_tipus=".$_GET["id_ft_tipus"]."&id_ft=".$_GET["id_ft"]."\">[NO]</a>";
		echo "</center>";
	}

	if ($soption == 130){
		if ($ssoption == 1) {
			$sql = "insert into sgm_idiomas (idioma,descripcion,imagen)";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["idioma"]."'";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.",'".comillas($_POST["imagen"])."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_idiomas set ";
			$sql = $sql."idioma='".$_POST["idioma"]."'";
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
			$sql = $sql.",imagen='".$_POST["imagen"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_idiomas set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_idiomas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_idiomas set ";
			$sql = $sql."predefinido = 1";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$sql = "update sgm_idiomas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Administrar." ".$Idioma."</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td></td>";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Idioma."</td>";
				echo "<td>".$Descripcion."</td>";
				echo "<td>".$Imagen."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=130&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"idioma\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Text\" name=\"imagen\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_idiomas where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
					$color = "white";
					if ($row["predefinido"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["predefinido"] == 1) {
						echo "<form action=\"index.php?op=1023&sop=130&ssop=5&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
						echo "</form>";
						echo "<td></td>";
					}
					if ($row["predefinido"] == 0) {
						echo "<form action=\"index.php?op=1023&sop=130&ssop=4&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
						echo "</form>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=131&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					}
					echo "<form action=\"index.php?op=1023&sop=130&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"idioma\" style=\"width:50px\" value=\"".$row["idioma"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:150px\" value=\"".$row["descripcion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"imagen\" style=\"width:100px\" value=\"".$row["imagen"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=130&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=130\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 140){
		if ($ssoption == 1) {
			$sql = "insert into sys_naciones (CodigoNacion,Nacion,SiglaNacion)";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["CodigoNacion"]."";
			$sql = $sql.",'".$_POST["Nacion"]."'";
			$sql = $sql.",'".$_POST["SiglaNacion"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sys_naciones set ";
			$sql = $sql."CodigoNacion=".$_POST["CodigoNacion"]."";
			$sql = $sql.",Nacion='".$_POST["Nacion"]."'";
			$sql = $sql.",SiglaNacion='".$_POST["SiglaNacion"]."'";
			$sql = $sql." WHERE CodigoNacion=".$_GET["CodigoNacion"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sys_naciones set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE CodigoNacion=".$_GET["CodigoNacion"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sys_naciones set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE CodigoNacion<>".$_GET["CodigoNacion"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sys_naciones set ";
			$sql = $sql."predeterminado = 1";
			$sql = $sql." WHERE CodigoNacion =".$_GET["CodigoNacion"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$sql = "update sys_naciones set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE CodigoNacion =".$_GET["CodigoNacion"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Administrar." ".$Pais."</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td></td>";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Codigo."</td>";
				echo "<td>".$Nacion."</td>";
				echo "<td>".$Siglas."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=140&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"CodigoNacion\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Text\" name=\"Nacion\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"SiglaNacion\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sys_naciones where visible=1 order by Nacion";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
					$color = "white";
					if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["predeterminado"] == 1) {
						echo "<form action=\"index.php?op=1023&sop=140&ssop=5&CodigoNacion=".$row["CodigoNacion"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
						echo "</form>";
						echo "</td><td></td>";
					}
					if ($row["predeterminado"] == 0) {
						echo "<form action=\"index.php?op=1023&sop=140&ssop=4&CodigoNacion=".$row["CodigoNacion"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
						echo "</form>";
						echo "</td><td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=141&CodigoNacion=".$row["CodigoNacion"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					}
					echo "<form action=\"index.php?op=1023&sop=140&ssop=2&CodigoNacion=".$row["CodigoNacion"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"CodigoNacion\" style=\"width:50px\" value=\"".$row["CodigoNacion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"Nacion\" style=\"width:200px\" value=\"".$row["Nacion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"SiglaNacion\" style=\"width:50px\" value=\"".$row["SiglaNacion"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 141) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=140&ssop=3&CodigoNacion=".$_GET["CodigoNacion"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=140\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 150) {
		echo "<strong>".$Explotar." ".$Hojas." de ".$Trabajo."</strong><br><br>";
		echo "<table>";
		echo "<form action=\"index.php?op=1023&sop=150\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"width:150px;text-align:right;\">".$Plantilla." : </td>";
				echo "<td><select name=\"id_plantilla\" style=\"width:300\">";
				$sql = "select * from sgm_ft_plantilla where visible=1 order by id";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					if (($row["id"] == $_POST["id_plantilla"]) or ($row["id"] == $_GET["id_plantilla"])){
						echo "<option value=\"".$row["id"]."\" selected>".$row["plantilla"]."</option>";
					} else {
						echo "<option value=\"".$row["id"]."\">".$row["plantilla"]."</option>";
					}
				}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:150px;\"></td>";
			echo "</tr>";
		echo "</form>";
		if (($_POST["id_plantilla"] > 0) or ($_GET["id_plantilla"] > 0)){
			echo "<form action=\"index.php?op=1023&sop=150&id_plantilla=".$_POST["id_plantilla"]."".$_GET["id_plantilla"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"width:150px;text-align:right;\">".$Tipo." : </td><td>";
					echo "<select name=\"id_tipus\" style=\"width:300\">";
					$sql = "select * from sgm_ft_plantilla_tipus where visible=1 and id_ft=".$_POST["id_plantilla"]."".$_GET["id_plantilla"]." order by tipus";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						if (($row["id"] == $_POST["id_tipus"]) or ($row["id"] == $_GET["id_tipus"])){
							echo "<option value=\"".$row["id"]."\" selected>".$row["tipus"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["tipus"]."</option>";
						}
					}
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:150px;\"></td></tr>";
			echo "</form>";
			echo "</tr>";
		}
		if ((($_POST["id_plantilla"] > 0) or ($_GET["id_plantilla"] > 0)) and (($_POST["id_tipus"] > 0) or ($_GET["id_tipus"] > 0))){
			echo "<form action=\"index.php?op=1023&sop=150&id_plantilla=".$_POST["id_plantilla"]."".$_GET["id_plantilla"]."&id_tipus=".$_POST["id_tipus"]."".$_GET["id_tipus"]."\" method=\"post\">";
			$sqlpt = "select * from sgm_ft_plantilla_tipus where id=".$_POST["id_tipus"]."".$_GET["id_tipus"]." and id_ft=".$_POST["id_plantilla"]."".$_GET["id_plantilla"]."";
			$resultpt = mysql_query(convert_sql($sqlpt));
			$rowpt = mysql_fetch_array($resultpt);
			echo "<tr><td></td><td>".$Palabra." ".$Clave."</td><td>".$Fecha." 1 (dd/mm/aaaa)</td><td>".$Fecha." 2 (dd/mm/aaaa)</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				if ($rowpt["taula"] == 0){
					echo "<td><input type=\"Text\" name=\"param1\" value=\"".$_POST["param1"]."\" style=\"width:300px;\"></td>";
				}
				if (($rowpt["taula"] == 1) and ($rowpt["obligatorio"] == 0)){
					echo "<td><select name=\"param1\" style=\"width:300px;\">";
					$sqlcc = "select * from sgm_ft_plantilla_tipus_campos where visible=1 and id_ft_plantilla_tipus=".$rowpt["id"]."";
					$resultcc = mysql_query(convert_sql($sqlcc));
					while ($rowcc = mysql_fetch_array($resultcc)) {
						if ($rowcc["id"] == $_POST["param1"]){
							echo "<option value=\"".$rowcc["id"]."\" selected>".$rowcc["campos"]."</option>";
						} else {
							echo "<option value=\"".$rowcc["id"]."\">".$rowcc["campos"]."</option>";
						}
					}
					echo "</select>";
					echo "</td>";
				}
				if (($rowpt["taula"] == 1) and ($rowpt["obligatorio"] == 1)){
					echo "<td><select name=\"param1\" style=\"width:300px;\">";
					$sqlcc = $rowpt["sgm_sql"];
					$resultcc = mysql_query(convert_sql($sqlcc));
					while ($rowcc = mysql_fetch_array($resultcc)) {
						if ($rowcc["id"] == $_POST["param1"]){
							echo "<option value=\"".$rowcc["id"]."\" selected>".$rowcc["".$rowpt["sgm_campo_visualizado"].""]."</option>";
						} else {
							echo "<option value=\"".$rowcc["id"]."\">".$rowcc["".$rowpt["sgm_campo_visualizado"].""]."</option>";
						}
					}
					echo "</select>";
					echo "</td>";
				}
				echo "<td><input type=\"Text\" name=\"param2\" value=\"".$_POST["param2"]."\" style=\"width:200px;\"></td>";
				echo "<td><input type=\"Text\" name=\"param3\" value=\"".$_POST["param3"]."\" style=\"width:200px;\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:150px;\"></td>";
			echo "</tr>";
			echo "</form>";
		}
		echo "</table>";
		if (($_POST["param1"] != "") or ($_POST["param2"] != "")){
			echo "<br>";
			echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr style=\"background-color:#C8C8C8;\">";
					echo "<td style=\"width:30px\"></td></td>";
					echo "<td style=\"text-align:center;width:300px\">".$Cliente."</td>";
					echo "<td style=\"text-align:center;width:150px\">".$Plantilla."</td>";
					echo "<td style=\"text-align:center;width:75px\">".$OT."</td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";

			$sqld = "select * from sgm_ft_dades where id_plantilla_tipus=".$_GET["id_tipus"];
			$resultd = mysql_query(convert_sql($sqld));
			while ($rowd = mysql_fetch_array($resultd)){
				$ver = false;
				if ($_POST["param1"] != ""){
					if (strstr(str_replace("&#39;","'",$rowd["descripcion"]),$_POST["param1"])){
						$ver = true;
					}
					if ($ver == false){
						if ($rowd["id_plantilla_tipus_campo"] == $_POST["param1"]){
							$ver = true;
						}
					}

					$sqlpt = "select * from sgm_ft_plantilla_tipus where id_ft=".$_POST["id_plantilla"]."".$_GET["id_plantilla"]."";
					$resultpt = mysql_query(convert_sql($sqlpt));
					while ($rowpt = mysql_fetch_array($resultpt)){
						if ($rowpt["taula"] == 1){
							$sqlfpt = "select * from sgm_ft_plantilla_tipus_campos where id_ft_plantilla_tipus=".$rowpt["id"]." and id=".$rowd["id_platilla_tipus_campo"]."";
							$resultfpt = mysql_query(convert_sql($sqlfpt));
							$rowfpt = mysql_fetch_array($resultfpt);
							if ($rowfpt["id"] != 0){ $ver = true; }
						}
					}
				}
				if ($_POST["param2"] != ""){
					list($d2, $m2, $a2) = explode("/", $_POST["param2"]);
					list($d, $m, $a) = explode("/", $rowd["descripcion"]);
						$d = str_replace(chr(34),"",$d);
					$a = str_replace(chr(34),"",$a);
					if ((strlen($d)) <= 1){ $dia = "0".$d; } else { $dia = $d; }
					if ((strlen($m)) <= 1){ $mes = "0".$m; } else { $mes = $m; }
					if ((strlen($a)) <= 2){ $any = "20".$a;} else { $any = $a; }
					$fecha = $any."-".$mes."-".$dia;
					$data_ft = $fecha." 00:00:00";
					$d2 = str_replace(chr(34),"",$d2);
					$a2 = str_replace(chr(34),"",$a2);
					if ((strlen($d2)) <= 1){ $dia = "0".$d2; } else { $dia = $d2; }
					if ((strlen($m2)) <= 1){ $mes = "0".$m2; } else { $mes = $m2; }
					if ((strlen($a2)) <= 2){ $any = "20".$a2;} else { $any = $a2; }
					$fecha2 = $any."-".$mes."-".$dia;
					$data_bus = $fecha2." 00:00:00";
					if ($data_ft >= $data_bus){
						$ver = true;
						if ($_POST["param3"] != ""){
							list($d3, $m3, $a3) = explode("/", $_POST["param3"]);
							$d3 = str_replace(chr(34),"",$d3);
							$a3 = str_replace(chr(34),"",$a3);
							if ((strlen($d3)) <= 1){ $dia = "0".$d3; } else { $dia = $d3; }
							if ((strlen($m3)) <= 1){ $mes = "0".$m3; } else { $mes = $m3; }
							if ((strlen($a3)) <= 2){ $any = "20".$a3;} else { $any = $a3; }
							$fecha3 = $any."-".$mes."-".$dia;
							$data_bus2 = $fecha3." 00:00:00";
							if ($data_ft <= $data_bus2){
								$ver = true;
							} else {
								$ver = false;
							}
						}
					}
				}
				if ($ver == true){
					$sql = "select * from sgm_ft where id=".$rowd["id_ft"]." and visible=1";
					if ($_POST["id_plantilla"] > 0){ $sql.=" and id_plantilla=".$_POST["id_plantilla"];}
					if ($_POST["id_client"] > 0){ $sql.=" and id_client=".$_POST["id_client"];}
					$sql.=" order by id desc";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						$sqlc = "select * from sgm_clients where id=".$row["id_client"];
						$resultc = mysql_query(convert_sql($sqlc));
						$rowc = mysql_fetch_array($resultc);
						$sqlp = "select * from sgm_ft_plantilla where id=".$row["id_plantilla"];
						$resultp = mysql_query(convert_sql($sqlp));
						$rowp = mysql_fetch_array($resultp);
						$sqlf = "select * from sgm_cabezera where id=".$row["id_ot"];
						$resultpf = mysql_query(convert_sql($sqlf));
						$rowf = mysql_fetch_array($resultf);
						echo "<tr>";
							echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=202&id_ot=".$row["id"]."&pag=".$paginas."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
							echo "<td>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</td>";
							echo "<td>".$rowp["plantilla"]."</td>";
							echo "<td>";
							if ($rowf["numero"] == "") {
								echo "Sin OT";
							} else {
								echo "<a href=\"\">[ ".$rowf["numero"]." ]</a>";
							}
							echo "</td>";
							echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=210&id_ft=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
							echo "<td style=\"text-align:center\"><a href=\"mgestion/gestion-produccion-ft-print.php?id=".$rowc["id"]."&id_ft=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px\"></a></td>";
						echo "</tr>";
					}
				}
			}
		echo "</table></center>";
		}
	}

	if ($soption == 200) {
		echo "<strong>".$Nueva." ".$Hoja." de ".$Trabajo." (".$manual.")</strong><br><br>";
		echo "<table>";
		echo "<form action=\"index.php?op=1023&sop=210\" method=\"post\">";
			echo "<tr><td style=\"width:150px;text-align:right;\">".$Plantilla." : </td><td>";
				echo "<select name=\"id_plantilla\" style=\"width:300\">";
				$sql = "select * from sgm_ft_plantilla where visible=1 order by plantilla";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<option value=\"".$row["id"]."\">".$row["plantilla"]."</option>";
				}
				echo "</select>";
			echo "</td></tr>";
			echo "<tr><td style=\"width:150px;text-align:right;\">".$Cliente." : </td><td>";
				echo "<select name=\"id_client\" style=\"width:300\">";
				$sql = "select * from sgm_clients where visible=1 order by nombre";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
				}
				echo "</select>";
			echo "</td></tr>";
			echo "<tr><td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:150px;\"></td></tr>";
		echo "</form>";
		echo "</table>";
	}

	if ($soption == 201) {
		if ($ssoption == 3) {
			$sql = "update sgm_ft set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Listado." ".$Hojas." de ".$Trabajo." :</strong><br><br>";
		echo "<center><table style=\"background-color:silver;\">";
		echo "<form action=\"index.php?op=1023&sop=201\" method=\"post\">";
			echo "<tr><td style=\"width:100px;text-align:right;\">".$Plantilla." : </td><td>";
				echo "<select name=\"id_plantilla\" style=\"width:300\">";
				echo "<option value=\"0\">-</option>";
				$sql = "select * from sgm_ft_plantilla where visible=1 order by plantilla";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					if ($row["id"] == $_POST["id_plantilla"]){
						echo "<option value=\"".$row["id"]."\" selected>".$row["plantilla"]."</option>";
					} else {
						echo "<option value=\"".$row["id"]."\">".$row["plantilla"]."</option>";
					}
				}
				echo "</select>";
			echo "</td>";
			echo "<td style=\"width:100px;text-align:right;\">".$Cliente." : </td><td>";
				echo "<select name=\"id_client\" style=\"width:300\">";
				echo "<option value=\"0\">-</option>";
				$sql = "select * from sgm_clients where visible=1 order by nombre";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					if ($row["id"] == $_POST["id_client"]){
						echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
					} else {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
					}
				}
				echo "</select>";
			echo "</td>";
			echo "<td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:150px;\"></td></tr>";
		echo "</form>";
		echo "</table></center>";
		echo "<br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"width:30px\"></td>";
				echo "<td style=\"text-align:center;width:300px\">".$Cliente."</td>";
				echo "<td style=\"text-align:center;width:150px\">".$Plantilla."</td>";
				echo "<td style=\"text-align:center;width:75px\">".$OT."</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		$pintar = true;
		$sql = "select * from sgm_ft where visible=1";
		if ($_POST["id_plantilla"] > 0){ $sql.=" and id_plantilla=".$_POST["id_plantilla"];}
		if ($_POST["id_client"] > 0){ $sql.=" and id_client=".$_POST["id_client"];}
		$sql.=" order by id desc";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sqlc = "select * from sgm_clients where id=".$row["id_client"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$sqlp = "select * from sgm_ft_plantilla where id=".$row["id_plantilla"];
			$resultp = mysql_query(convert_sql($sqlp));
			$rowp = mysql_fetch_array($resultp);
			$sqlf = "select * from sgm_cabezera where id=".$row["id_ot"];
			$resultpf = mysql_query(convert_sql($sqlf));
			$rowf = mysql_fetch_array($resultf);
			if ($pintar == true) { $color = "#C8C8C8"; $pintar =false; }
			else {$color = "white"; $pintar = true; }
			echo "<tr style=\"background-color:".$color.";\">";
				echo "<td style=\"width:50px\">".$row["id"]."</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=202&id_ot=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<td>".$rowc["nombre"]."</td>";
				echo "<td>".$rowp["plantilla"]."</td>";
				echo "<td>";
					if ($rowf["numero"] == "") {
						echo "Sin OT";
					} else {
						echo "<a href=\"\">[ ".$rowf["numero"]." ]</a>";
					}
				echo "</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=210&id_ft=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "<td style=\"text-align:center\"><a href=\"mgestion/gestion-produccion-ft-print.php?id=".$rowc["id"]."&id_ft=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px\"></a></td>";
			echo "</tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 202) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=201&ssop=3&id=".$_GET["id_ot"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=201&pag=".$_GET["pag"]."\">[NO]</a>";
		echo "</center>";
	}

	if ($soption == 210) {
		if ($ssoption == 1) {
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
					$sqlx = $sqlx."descripcion='".comillas($_POST["textarea".$rowt["id"].""])."'";
					if ($_POST["select".$rowt["id"].""] != "") {
						$sqlx = $sqlx.",id_plantilla_tipus_campo=".$_POST["select".$rowt["id"].""]."";
					}
					$sqlx = $sqlx." WHERE id=".$rowdades2["id"]."";
					mysql_query(convert_sql($sqlx));
				}
				if ($rowdades["total"] == 0) {
					if ($rowt["taula"] == 1) {
						$sqlx = "insert into sgm_ft_dades (id_ft,id_plantilla_tipus,id_plantilla_tipus_campo)";
						$sqlx = $sqlx."values (";
						$sqlx = $sqlx."".$_GET["id_ft"]."";
						$sqlx = $sqlx.",".$rowt["id"]."";
						$sqlx = $sqlx.",".$_POST["select".$rowt["id"].""];
						$sqlx = $sqlx.")";
						mysql_query(convert_sql($sqlx));
					}
					if ($rowt["taula"] == 0) {
						$sqlx = "insert into sgm_ft_dades (id_ft,id_plantilla_tipus,descripcion)";
						$sqlx = $sqlx."values (";
						$sqlx = $sqlx."".$_GET["id_ft"]."";
						$sqlx = $sqlx.",".$rowt["id"]."";
						$sqlx = $sqlx.",'".comillas($_POST["textarea".$rowt["id"].""])."'";
						$sqlx = $sqlx.")";
						mysql_query(convert_sql($sqlx));
					}
				}
			}
			echo $_POST["select".$rowt["id"].""]."";
			echo $_POST["textarea".$rowt["id"].""]."";
		}
		$veure_peu = 0;
		if ($_GET["id_ft"] != "") {
			$id_ft = $_GET["id_ft"];
		} else {
		### incio ".$Anadir." nueva hoja de trabajo
			if ($_POST["id_client"] != "") {
				$sql = "insert into sgm_ft (id_plantilla,id_client)";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["id_plantilla"]."";
				$sql = $sql.",".$_POST["id_client"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
				$id_plantilla = $_POST["id_plantilla"];
			}
			if ($_GET["id_mantenimiento"] != "") {
				$sql = "insert into sgm_ft (id_plantilla,id_mantenimiento)";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_plantilla"]."";
				$sql = $sql.",".$_GET["id_mantenimiento"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
				$id_plantilla = $_GET["id_plantilla"];
			}
			if ($_GET["id_incidencia"] != "") {
				$sql = "insert into sgm_ft (id_plantilla,id_incidencia)";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_plantilla"]."";
				$sql = $sql.",".$_GET["id_incidencia"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
				$id_plantilla = $_GET["id_plantilla"];
			}
			$sql = "select * from sgm_ft order by id desc";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$id_ft = $row["id"];
			$sql = "select * from sgm_ft_plantilla_tipus where id_ft=".$id_ft." and visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlx = "insert into sgm_ft_dades (id_ft,id_plantilla_tipus,id_plantilla_tipus_campo,descripcion)";
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
		$sqlft = "select * from sgm_ft where id=".$id_ft;
		$resultft = mysql_query(convert_sql($sqlft));
		$rowft = mysql_fetch_array($resultft);
		$sqlftp = "select * from sgm_ft_plantilla where id=".$rowft["id_plantilla"];
		$resultftp = mysql_query(convert_sql($sqlftp));
		$rowftp = mysql_fetch_array($resultftp);
		$sqltp = "select * from sgm_tamany_paper where id=".$rowftp["id_tamany_papel"];
		$resulttp = mysql_query(convert_sql($sqltp));
		$rowtp = mysql_fetch_array($resulttp);
		$sqlc = "select * from sgm_clients where id=".$rowft["id_client"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
			echo "<table>";
				echo "<tr>";
					echo "<td style=\"width:200px;\"><strong>".$Introduccion." ".$Datos." ".$Plantilla." : </strong></td>";
					echo "<td style=\"width:80px;height:20px;text-align:center;vertical-align:middle;background-color:LightGrey;border: 1px solid black;\"><a href=\"javascript:history.go(-1);\" style=\"color:black;\">".$Volver."</a></td>";
					echo "<form action=\"index.php?op=1023&sop=210&ssop=1&id_ft=".$id_ft."\" method=\"post\">";
					echo "<td style=\"width:200px;\"><input type=\"submit\" value=\"".$Actualizar."\"></td>";
					echo "<td style=\"width:400px;\"><a href=\"index.php?op=1008&sop=240&id=".$rowft["id_client"]."\"><strong>".$FICHA.": ".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</strong></a></td>";
					echo "<td style=\"width:100px;\"><a href=\"mgestion/gestion-produccion-ft-print.php?id=".$rowft["id_client"]."&id_ft=".$id_ft."\" target=\"_blank\"><strong>".$IMPRIMIR."</strong></a></td>";
					echo "<td style=\"width:100px;\"><a href=\"index.php?op=1006&sop=20&id_cliente=".$rowft["id_client"]."\"><strong>".$INCIDENCIA."</strong></a></td>";
					echo "<td style=\"width:80px;height:20px;text-align:center;vertical-align:middle;background-color:red;border: 1px solid black;\"><a href=\"index.php?op=1023&sop=202&id_ot=".$id_ft."\" style=\"color:white;\">".$Eliminar."</a></td>";
				echo "</tr>";
			echo "</table>";
			echo "<div style=\"margin-top:10px;width:".($rowtp["x"])."mm;height:".($rowtp["y"])."mm;\">";
				echo "<div style=\"vertical-align:top;\">";
					$sqlftpt = "select * from sgm_ft_plantilla_tipus where id_ft=".$rowftp["id"]." and visible=1 and visualizar=1";
					$resultftpt = mysql_query(convert_sql($sqlftpt));
					while ($rowftpt = mysql_fetch_array($resultftpt)){
						$sqlftd = "select * from sgm_ft_dades where id_ft=".$id_ft." and id_plantilla_tipus=".$rowftpt["id"]."";
						$resultftd = mysql_query(convert_sql($sqlftd));
						$rowftd = mysql_fetch_array($resultftd);
						$color = "white";
						if ($rowftpt["obligatorio"] == 1){
							$color="silver";
						}
						echo "<div style=\"position: absolute;left:".($rowftpt["x_posicion"]+40)."mm;top:".($rowftpt["y_posicion"]+50)."mm;background-color:".$color."\">";
						echo $rowftpt["tipus"];
						if ($rowftpt["descripcion"] != ""){
							echo "<br>(".$rowftpt["descripcion"].")<br>";
						} else {
							echo "<br>";
						}
						if ($rowftpt["taula"] == 0){
							echo "<textarea name=\"textarea".$rowftpt["id"]."\" style=\"width:".$rowftpt["x_ancho"]."mm;height:".$rowftpt["y_alto"]."mm;background-color:".$color."\">".$rowftd["descripcion"]."</textarea>";
						} else {
							echo "<select name=\"select".$rowftpt["id"]."\" style=\"width:150px;;background-color:".$color."\">";
								echo "<option value=\"0\">-</option>";
								if ($rowftpt["obligatorio"] == 1){
									$sqlcl = $rowftpt["sgm_sql"];
									$resultcl = mysql_query(convert_sql($sqlcl));
									echo $sqlcl;
									while ($rowcl = mysql_fetch_array($resultcl)){
										if ($rowcl["id"] == $rowftd["id_plantilla_tipus_campo"]) {
											echo "<option value=\"".$rowcl[$rowftpt["sgm_campo"]]."\" selected>".$rowcl[$rowftpt["sgm_campo_visualizado"]]."</option>";
										} else {
											echo "<option value=\"".$rowcl[$rowftpt["sgm_campo"]]."\">".$rowcl[$rowftpt["sgm_campo_visualizado"]]."</option>";
										}
									}
								} else {
									$sqlcl = "select * from sgm_ft_plantilla_tipus_campos where id_ft_plantilla_tipus=".$rowftpt["id"]." and visible=1";
									$resultcl = mysql_query(convert_sql($sqlcl));
									while ($rowcl = mysql_fetch_array($resultcl)){
										if ($rowcl["id"] == $rowftd["id_plantilla_tipus_campo"]) {
											echo "<option value=\"".$rowcl["id"]."\" selected>".$rowcl["campos"]."</option>";
										} else {
											echo "<option value=\"".$rowcl["id"]."\">".$rowcl["campos"]."</option>";
										}
									}
								}
							echo "</select>";
						}
						echo "</div>";
					}
					echo "</form>";
			echo "</div>";
		echo "</div>";
	}

	}

	if ($soption == 420) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_mantenimiento_tipo(nombre,id_clase,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",".$_POST["id_clase"]."";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_mantenimiento_tipo set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",id_clase='".$_POST["id_clase"]."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_mantenimiento_tipo set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}


		echo "<strong>".$Administrar." ".$Mantenimientos."</strong>";
		echo "<br><br>";
		echo "<center>";
		echo "<table><tr><td style=\"vertical-align:top\">";
			echo "<table><tr>";
					echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1023&sop=420\" style=\"color:white;\">".$Anadir." ".$Mantenimientos."</a>";
					echo "</td>";
			echo "</tr></table>";
		echo "<br><br><br>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"vertical-align:top;text-align:center\"><em>".$Eliminar."</em></td>";
				echo "<td style=\"vertical-align:top;\">".$Nombre."</td>";
				echo "<td style=\"vertical-align:top;\">".$Clase."</td>";
				echo "<td style=\"vertical-align:top;text-align:center\"><em>".$Editar."</em></td>";
				echo "<td style=\"vertical-align:top;text-align:center\"><em>".$Anadir."<br>".$Plantilla."</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_mantenimiento_tipo where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "black";
				if ($row["id"] == $_GET["id"]){
					echo "<tr style=\"background-color:#4B53AF;\">";
					$color = "white";
				} else {
					echo "<tr>";
				}
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1023&sop=421&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td style=\"color:".$color.";width:120;\">".$row["nombre"]."</td>";
						$sqlc = "select * from sgm_mantenimiento_clase where id=".$row["id_clase"]."";
						$resultc = mysql_query(convert_sql($sqlc));
						$rowc = mysql_fetch_array($resultc);
						echo "<td style=\"color:".$color.";width:250;\">".$rowc["clase"]."</td>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1023&sop=420&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
						echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=430&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/layout_add.png\" style=\"border:0px\"></a></td>";
					echo "</tr>";
			}
		echo "</table>";

	echo "</td>";
	echo "<td style=\"width:70px\">&nbsp;";
	echo "</td><td style=\"vertical-align:top;\">";

	if ($_GET["id"] == "") {
			echo "<strong>".$Anadir." ".$Nuevo." ".$Mantenimientos."</strong>";
		} else {
			echo "<strong>".$Modificar." ".$Mantenimientos."</strong>";
		}
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			echo "<tr>";
				echo "<td></td>";
				$sql = "select * from sgm_mantenimiento_tipo where visible=1 and id=".$_GET["id"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				if ($_GET["id"] == "") {
					echo "<form action=\"index.php?op=1023&sop=420&ssop=1\" method=\"post\">";
				} else {
					echo "<form action=\"index.php?op=1023&sop=420&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
				}
			echo "</tr><tr>";
				echo "<td>".$Nombre.": </td>";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:150px;\" value=\"".$row["nombre"]."\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>".$Clase.": </td>";
				echo "<td><select name=\"id_clase\" style=\"width:150px;\">";
						$sqlc = "select * from sgm_mantenimiento_clase";
						$resultc = mysql_query(convert_sql($sqlc));
						while ($rowc = mysql_fetch_array($resultc)) {
							if ($row["id_clase"] == $rowc["id"]) {
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["clase"]."</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\">".$rowc["clase"]."</option>";
							}
						}
				echo "</td></select>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>".$Descripcion.": </td>";
				echo "<td><textarea name=\"descripcion\" rows=\"15\" style=\"width:300px\">".$row["descripcion"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
					if ($_GET["id"] == "") {
						echo "<input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\">";
					}else{
						echo "<input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px\">";
					}
				echo "</td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	echo "</td></tr></table>";
	echo "</center>";
	}

	if ($soption == 421) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=420&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1023&sop=420\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 430) {
		if ($ssoption == 1) {
			if ($_POST["id_plantilla"]!= 0){
				$sql = "insert into sgm_mantenimiento_tipo_plantilla (id_plantilla,id_tipo_mantenimiento) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["id_plantilla"]."'";
				$sql = $sql.",'".$_GET["id"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}else{
				echo mensaje_error("La operación no se puede realizar. Debe elegir una plantilla.");
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_mantenimiento_tipo_plantilla set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_plantilla"]."";
			mysql_query(convert_sql($sql));
		}

		$sql = "select * from sgm_mantenimiento_tipo where visible=1 and id=".$_GET["id"]."";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>".$Anadir." ".$Plantilla." a: ".$row["nombre"]."</strong>";
		echo "<br>";
		echo boton_volver($Volver);
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Nombre." ".$Plantilla."</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><form action=\"index.php?op=1023&sop=430&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select name=\"id_plantilla\" style=\"width:310px\">";
						echo "<option value=\"0\" selected>-</option>";
						$sqlp = "select * from sgm_ft_plantilla where visible=1";
						$resultp = mysql_query(convert_sql($sqlp));
						while ($rowp = mysql_fetch_array($resultp)){
							$sqltp = "select count(*) as total from sgm_mantenimiento_tipo_plantilla where visible=1 and id_tipo_mantenimiento=".$row["id"]." and id_plantilla=".$rowp["id"]."";
							$resulttp = mysql_query(convert_sql($sqltp));
							$rowtp = mysql_fetch_array($resulttp);
								if($rowtp["total"] == 0){
								echo "<option value=\"".$rowp["id"]."\">".$rowp["plantilla"]."</option>";
								}
						}
					echo "</select></td>";
				echo "<td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlt = "select * from sgm_mantenimiento_tipo_plantilla where visible=1 and id_tipo_mantenimiento=".$row["id"]."";
			$resultt = mysql_query(convert_sql($sqlt));
			while ($rowt = mysql_fetch_array($resultt)){
				$sqlf = "select * from sgm_ft_plantilla where visible=1 and id=".$rowt["id_plantilla"]."";
				$resultf = mysql_query(convert_sql($sqlf));
				$rowf = mysql_fetch_array($resultf);
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=431&id_plantilla=".$rowt["id"]."&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td>".$rowf["plantilla"]."</td>";
					echo "<td></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 431) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=430&ssop=3&id_plantilla=".$_GET["id_plantilla"]."&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1023&sop=430&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 500) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_tarifas (nombre,porcentage,descuento)";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",".$_POST["porcentage"]."";
			$sql = $sql.",".$_POST["descuento"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_tarifas set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",porcentage=".$_POST["porcentage"]."";
			$sql = $sql.",descuento=".$_POST["descuento"]."";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_tarifas set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Administrar." ".$Tarifas."</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Descuento."/".$Incremento."</td>";
				echo "<td>".$Nombre."</td>";
				echo "<td>".$Porcentage."</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=500&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td>";
					echo "<select name=\"descuento\" style=\"width:150px\">";
						echo "<option value=\"1\" selected>".$Descuento." PVP</option>";
						echo "<option value=\"0\">".$Incremento." PVD</option>";
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"porcentage\" style=\"width:70px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			$sql = "select * from sgm_tarifas where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=501&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=500&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td>";
						echo "<select name=\"descuento\" style=\"width:150px\">";
							if ($row["descuento"] == 0) {
								echo "<option value=\"1\">".$Descuento." PVP</option>";
								echo "<option value=\"0\" selected>".$Incremento." PVD</option>";
							}
							if ($row["descuento"] == 1) {
								echo "<option value=\"1\" selected>".$Descuento." PVP</option>";
								echo "<option value=\"0\">".$Incremento." PVD</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\" value=\"".$row["nombre"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"porcentage\" style=\"width:70px\" value=\"".$row["porcentage"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 501) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=500&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=500\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 550) {
		if ($ssoption == 1) {
			$x = is_numeric($_POST["x"]);
			$y = is_numeric($_POST["y"]);
			if (($x == true) and ($y == true)){
				$sql = "insert into sgm_tamany_paper (nombre,x,y)";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["nombre"]."'";
				$sql = $sql.",".$_POST["x"]."";
				$sql = $sql.",".$_POST["y"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				echo "<center>";
				echo mensaje_error("Las medidas tienen que ser valors numérics.");
				echo "</center>";
			}
		}
		if ($ssoption == 2) {
			$x = is_numeric($_POST["x"]);
			$y = is_numeric($_POST["y"]);
			if (($x == true) and ($y == true)){
				$sql = "update sgm_tamany_paper set ";
				$sql = $sql."nombre='".$_POST["nombre"]."'";
				$sql = $sql.",x=".$_POST["x"]."";
				$sql = $sql.",y=".$_POST["y"]."";
				$sql = $sql." WHERE id=".$_GET["id"]."";
				mysql_query(convert_sql($sql));
			} else {
				echo "<center>";
				echo mensaje_error("Las medidas tienen que ser valors numérics.");
				echo "</center>";
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_tamany_paper set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_tamany_paper set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_tamany_paper set ";
			$sql = $sql."predeterminado = 1";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$sql = "update sgm_tamany_paper set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Administrar." ".$Tamano." de ".$Papel."</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Predet."</em></td>";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Nombre."</td>";
				echo "<td>".$Ancho."</td>";
				echo "<td>".$Alto."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=550&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"x\" style=\"width:60px\"></td>";
				echo "<td><input type=\"Text\" name=\"y\" style=\"width:60px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_tamany_paper where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
					$color = "white";
					if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["predeterminado"] == 1) {
						echo "<form action=\"index.php?op=1023&sop=550&ssop=5&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:60px\">";
						echo "</form>";
					}
					if ($row["predeterminado"] == 0) {
						echo "<form action=\"index.php?op=1023&sop=550&ssop=4&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:60px\">";
						echo "</form>";
					}
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=551&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=550&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\" value=\"".$row["nombre"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"x\" style=\"width:60px\" value=\"".$row["x"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"y\" style=\"width:60px\" value=\"".$row["y"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 551) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=550&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=550\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 600) {
		echo "<strong>".$Logos." :</strong><br><br>";
		if ($ssoption == 1) {
			if(sizeof($_FILES)==0){
				echo "No se puede subir el archivo";
			}
			$archivo = $_FILES["logo"]["tmp_name"];
			$tamanio=array();
			$tamanio = $_FILES["logo"]["size"];
			$tipo = $_FILES["logo"]["type"];
			$nombre_archivo = $_FILES["logo"]["name"];
			extract($_REQUEST);
			if ( $archivo != "none" ){
				$fp = fopen($archivo, "rb");
				$contenido = fread($fp, $tamanio);
				$contenido = addslashes($contenido);
				fclose($fp);

				$sql = "select count(*) as total from sgm_logos where clase=".$_GET["clase"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				if ($row["total"] <= 0){
					$sql = "insert into sgm_logos (clase, nombre_archivo, contenido, tamany, tipo )";
					$sql = $sql."values (";
					$sql = $sql.$_GET["clase"];
					$sql = $sql.",'".$nombre_archivo."'";
					$sql = $sql.",'".$contenido."'";
					$sql = $sql.",".$tamanio."";
					$sql = $sql.",'".$tipo."'";
					$sql = $sql.")";
					mysql_query($sql);
				} else {
					$sql = "update sgm_logos set ";
					$sql = $sql."nombre_archivo='".$nombre_archivo."'";
					$sql = $sql.",contenido='".$contenido."'";
					$sql = $sql.",tamany=".$tamanio."";
					$sql = $sql.",tipo='".$tipo."'";
					$sql = $sql." WHERE clase=".$_GET["clase"]."";
					mysql_query(convert_sql($sql));
				}
			}
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_logos where clase=".$_GET["clase"];
			mysql_query(convert_sql($sql));
		}
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sql = "select * from sgm_logos where clase=1";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<tr><td><strong>".$Logo." ".$Factura." ".$Formato." no ".$Sobre." :</strong><br>dimensión recomendada 500x130 píxels.</td></tr>";
						echo "<tr>";
							echo "<td><a href=\"".$urloriginal."/mgestion/imagen.php?clase=1&tipo=3\" target=\"_blank\">".$row["nombre_archivo"]."</a></td>";
							echo "<td style=\"text-align:right;\">".$row["tamany"]." Kb</td>";
							echo "<td><a href=\"index.php?op=1023&sop=601&clase=1\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1023&sop=600&ssop=1&clase=1\" method=\"post\">";
					echo "<center>";
						echo "<input type=\"file\" name=\"logo\" size=\"29px\">";
						echo "<br><br><input type=\"submit\" value=\"".$Insertar."\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:white;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sql = "select * from sgm_logos where clase=2";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<tr><td><strong>".$Logo." ".$Factura." ".$Formato." ".$Sobre." :</strong><br>dimensión recomendada 200x130 píxels.</td></tr>";
						echo "<tr>";
							echo "<td><a href=\"".$urloriginal."/mgestion/imagen.php?clase=2&tipo=3\" target=\"_blank\">".$row["nombre_archivo"]."</a></td>";
							echo "<td style=\"text-align:right;\">".$row["tamany"]." Kb</td>";
							echo "<td><a href=\"index.php?op=1023&sop=601&clase=2\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1023&sop=600&ssop=1&clase=2\" method=\"post\">";
					echo "<center>";
						echo "<input type=\"file\" name=\"logo\" size=\"29px\">";
						echo "<br><br><input type=\"submit\" value=\"".$Insertar."\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sql = "select * from sgm_logos where clase=3";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<tr><td><strong>".$Logo." ".$Factura." ".$Formato." ".$Ticket." :</strong><br>dimensión recomendada 50x50 píxels.</td></tr>";
						echo "<tr>";
							echo "<td><a href=\"".$urloriginal."/mgestion/imagen.php?clase=3&tipo=3\" target=\"_blank\">".$row["nombre_archivo"]."</a></td>";
							echo "<td style=\"text-align:right;\">".$row["tamany"]." Kb</td>";
							echo "<td><a href=\"index.php?op=1023&sop=601&clase=3\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1023&sop=600&ssop=1&clase=3\" method=\"post\">";
					echo "<center>";
						echo "<input type=\"file\" name=\"logo\" size=\"29px\">";
						echo "<br><br><input type=\"submit\" value=\"".$Insertar."\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:white;\">";
				echo "<td style=\"width:200px;vertical-align:top;\">";
					echo "<table>";
						$sql = "select * from sgm_logos where clase=4";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<tr><td><strong>".$Logo." ".$Impresos." :</strong><br>dimensión recomendada 500x130 píxels.</td></tr>";
						echo "<tr>";
							echo "<td><a href=\"".$urloriginal."/mgestion/imagen.php?clase=4&tipo=3\" target=\"_blank\">".$row["nombre_archivo"]."</a></td>";
							echo "<td style=\"text-align:right;\">".$row["tamany"]." Kb</td>";
							echo "<td><a href=\"index.php?op=1023&sop=601&clase=4\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1023&sop=600&ssop=1&clase=4\" method=\"post\">";
					echo "<center>";
						echo "<input type=\"file\" name=\"logo\" size=\"29px\">";
						echo "<br><br><input type=\"submit\" value=\"".$Insertar."\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 601) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=600&ssop=3&clase=".$_GET["clase"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1023&sop=600\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 700){
		if ($ssoption == 1){
			if(sizeof($_FILES)==0){
				echo "No se puede subir el archivo";
			}
			$archivo = $_FILES["archivo"]["tmp_name"];
			$tamanio=array();
			$tamanio = $_FILES["archivo"]["size"];
			$tipo = $_FILES["archivo"]["type"];
			$nombre_archivo = $_FILES["archivo"]["name"];
			extract($_REQUEST);
			if ( $archivo != "none" ){
				$fp = fopen($archivo, "rb");
				$contenido = fread($fp, $tamanio);
				$contenido = addslashes($contenido);
				fclose($fp);
				$sql = "insert into documentos ( nombre_archivo, contenido, tamany, tipo )";
				$sql = $sql."values (";
				$sql = $sql."'".$nombre_archivo."'";
				$sql = $sql.",'".$contenido."'";
				$sql = $sql.",".$tamanio."";
				$sql = $sql.",'".$tipo."'";
				$sql = $sql.")";
				mysql_query($sql);
			}
		}

		echo "<strong>Documentos :</strong><br><br>";
		echo "<table><tr><td style=\"width:500px\">";
			echo "<form id=\"test_upload\" name=\"test_upload\" action=\"index.php?op=1023&sop=700&ssop=1\" enctype=\"multipart/form-data\" method=\"post\">";
			echo "<table style=\"border:0;\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr>";
					echo "<td style=\"background-color:silver\">".$Archivo."</td>";
				echo "</tr><tr>";
					echo "<td><input type=\"file\" id=\"archivo\" name=\"archivo\"/></td>";
				echo "</tr><tr>";
					echo "<td><input type=\"submit\" value=\"".$Registrar_Documento."\"/></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</td><td style=\"width:500px\">";
			echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver\"><td>".$Archivos_subidos."</td></tr>";
			$sql = "select * from documentos";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result)){
				echo "<tr><td><a href=\"".$urloriginal."/mgestion/imagen.php?id=".$row["id"]."&tipo=1\" target=\"_blank\">".$row["nombre_archivo"]."</a></td></tr>";
			}
			echo "</table>";
		echo "</td></tr></table>";
	}

	if ($soption == 800){
		if ($ssoption == 1) {
			$sql = "insert into sgm_calendario (dia,mes,descripcio) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["dia"]."'";
			$sql = $sql.",'".$_POST["mes"]."'";
			$sql = $sql.",'".$_POST["descripcio"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "delete from sgm_calendario WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_calendario_horario set ";
			$hora_ini = $_POST["hora_inicio"]*3600;
			$sql = $sql."hora_inicio=".$hora_ini."";
			$hora_fi = $_POST["hora_fin"]*3600;
			$sql = $sql.",hora_fin=".$hora_fi."";
			$total_horas = $hora_fi-$hora_ini;
			$sql = $sql.",total_horas=".$total_horas."";
			$sql = $sql." WHERE id=".$_GET["id_h"]."";
			mysql_query(convert_sql($sql));
			echo $sql;
		}
		if ($ssoption == 5) {
			$sql = "delete from sgm_calendario WHERE id=".$_GET["id_h"];
			mysql_query(convert_sql($sql));
			echo $sql;
		}
		echo "<center><table cellpadding=\"10px\"><tr><td style=\"vertical-align:top;\">";
			echo "<center><table>";
			echo "<strong>".$Calendario."</strong>";
			echo "<br><br>";
			echo "<center>";
			echo "<table cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td><em>".$Eliminar."</em></td>";
					echo "<td>".$Dia."</td>";
					echo "<td>".$Mes."</td>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td></td>";
					echo "<form action=\"index.php?op=1023&sop=800&ssop=1&id=".$row["id"]."\" method=\"post\">";
					echo "<td><select name=\"dia\" style=\"width:40px\">";
						for ($i=1; $i <= 31; $i++) {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"mes\" style=\"width:40px\">";
						for ($i=1; $i <= 12; $i++) {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					echo "</select></td>";
					echo "<td><input name=\"descripcio\" type=\"Text\" style=\"width:150px\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>&nbsp;</td>";
				echo "</tr>";
				$sql = "select * from sgm_calendario order by mes, dia";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1023&sop=801&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td>".$row["dia"]."</td>";
						echo "<td>".$row["mes"]."</td>";
						echo "<td>".$row["descripcio"]."</td>";
						echo "<td></td>";
					echo "</tr>";
				}
			echo "</table></center>";
		echo "</td><td style=\"width:100px;\">&nbsp;</td><td style=\"vertical-align:top;\">";
			echo "<center><table>";
			echo "<strong>".$Horario."</strong>";
			echo "<br><br>";
			echo "<center>";
			echo "<table cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td>".$Dia."</td>";
					echo "<td>".$Hora_Inicio."</td>";
					echo "<td>".$Hora_Fin."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "</tr>";
				$sql = "select * from sgm_calendario_horario order by id";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					$hora_ini = $row["hora_inicio"]/3600;
					$hora_fi = $row["hora_fin"]/3600;
					echo "<tr>";
					echo "<form action=\"index.php?op=1023&sop=800&ssop=4&id_h=".$row["id"]."\" method=\"post\">";
						echo "<td>".$row["dia"]."</td>";
						echo "<td><input name=\"hora_inicio\" type=\"Text\" value=\"".$hora_ini."\" style=\"width:70px\"></td>";
						echo "<td><input name=\"hora_fin\" type=\"Text\" value=\"".$hora_fi."\" style=\"width:70px\"></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
					echo "</form>";
					echo "</tr>";
				}
			echo "</table></center>";
		echo "</td></tr></table></center>";
	}

	if ($soption == 801) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=800&ssop=2&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1023&sop=800\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 802) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1023&sop=800&ssop=5&id=".$_GET["id_h"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1023&sop=800\">[ NO ]</a>";
		echo "</center>";
	}
#fi calendario#


	echo "</td></tr></table><br>";
}



?>
