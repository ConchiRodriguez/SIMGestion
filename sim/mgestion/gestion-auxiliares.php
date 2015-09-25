<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1023) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Auxiliares."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($soption == 100) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=100\" class=".$class.">".$Tarifas."</a></td>";
				if ($soption == 110) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=110\" class=".$class.">".$Calendario." ".$$Laboral."</a></td>";
				if ($soption == 130) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=130\" class=".$class.">".$Idioma."</a></td>";
				if ($soption == 140) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=140\" class=".$class.">".$Pais."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,porcentage,descuento";
			$datosInsert = array($_POST["nombre"],$_POST["porcentage"],$_POST["descuento"]);
			insertFunction ("sgm_tarifas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('nombre','porcentage','descuento');
			$datosUpdate=array($_POST["nombre"],$_POST["porcentage"],$_POST["descuento"]);
			updateFunction("sgm_tarifas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_tarifas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Tarifas."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Descuento."/".$Incremento."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Porcentage."</th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=100&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td>";
					echo "<select name=\"descuento\" style=\"width:150px\">";
						echo "<option value=\"1\" selected>".$Descuento." ".$PVP."</option>";
						echo "<option value=\"0\">".$Incremento." ".$PVD."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"porcentage\" style=\"width:70px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_tarifas where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=101&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=100&ssop=2&id=".$row["id"]."\" method=\"post\">";
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

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=100&ssop=3&id=".$_GET["id"],"op=1023&sop=100"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 110){
		if ($ssoption == 1) {
			$camposInsert = "dia,mes,descripcio";
			$datosInsert = array($_POST["dia"],$_POST["mes"],$_POST["descripcio"]);
			insertFunction ("sgm_calendario",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			deleteFunction ("sgm_calendario",$_GET["id"]);
		}
		if ($ssoption == 4) {
			$hora_ini = $_POST["hora_inicio"]*3600;
			$hora_fi = $_POST["hora_fin"]*3600;
			$total_horas = $hora_fi-$hora_ini;
			$camposUpdate=array('hora_inicio','hora_fin','total_horas');
			$datosUpdate=array($hora_ini,$hora_fi,$total_horas);
			updateFunction("sgm_calendario_horario",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			deleteFunction ("sgm_calendario",$_GET["id_h"]);
		}

		echo "<table cellpadding=\"10px\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<h4>".$Calendario." ".$$Laboral."</h4>";
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
							echo "<form action=\"index.php?op=1023&sop=110&ssop=1&id=".$row["id"]."\" method=\"post\">";
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
						$sql = "select * from sgm_calendario order by mes, dia";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1023&sop=111&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<td>".$row["dia"]."</td>";
								echo "<td>".$row["mes"]."</td>";
								echo "<td>".$row["descripcio"]."</td>";
								echo "<td></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td><td style=\"width:100px;\">&nbsp;</td><td style=\"vertical-align:top;\">";
					echo "<h4>".$Horarios."</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Dia."</th>";
							echo "<th>".$Hora_Inicio."</th>";
							echo "<th>".$Hora_Fin."</th>";
						echo "</tr>";
						$sql = "select * from sgm_calendario_horario order by id";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							$hora_ini = $row["hora_inicio"]/3600;
							$hora_fi = $row["hora_fin"]/3600;
							echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=110&ssop=4&id_h=".$row["id"]."\" method=\"post\">";
								echo "<td>".$row["dia"]."</td>";
								echo "<td><input name=\"hora_inicio\" type=\"Text\" value=\"".$hora_ini."\" style=\"width:70px\"></td>";
								echo "<td><input name=\"hora_fin\" type=\"Text\" value=\"".$hora_fi."\" style=\"width:70px\"></td>";
								echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
							echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=110&ssop=2&id=".$_GET["id"],"op=1023&sop=110"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 130){
		if ($ssoption == 1) {
			$camposInsert = "idioma,descripcion,imagen";
			$datosInsert = array($_POST["idioma"],$_POST["descripcion"],$_POST["imagen"]);
			insertFunction ("sgm_idiomas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('idioma','descripcion','imagen');
			$datosUpdate=array($_POST["idioma"],$_POST["descripcion"],$_POST["imagen"]);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_idiomas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$camposUpdate=array('predefinido');
			$datosUpdate=array(1);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$camposUpdate=array('predefinido');
			$datosUpdate=array(0);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Idioma."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Idioma."*</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th>".$Imagen."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=130&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"idioma\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Text\" name=\"imagen\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
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
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td colspan=\"6\">* ".$ayuda_iso_idioma." <a href=\"https://es.wikipedia.org/wiki/ISO_639-1\" target=\"_blank\">https://es.wikipedia.org/wiki/ISO_639-1</a></td></tr>";
		echo "</table>";
	}

	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=130&ssop=3&id=".$_GET["id"],"op=1023&sop=130"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 140){
		if ($ssoption == 1) {
			$camposInsert = "pais,siglas";
			$datosInsert = array($_POST["pais"],$_POST["siglas"]);
			insertFunction ("sgm_paises",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('pais','siglas');
			$datosUpdate=array($_POST["pais"],$_POST["siglas"]);
			updateFunction("sgm_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_paises set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$camposUpdate=array('predefinido');
			$datosUpdate=array(1);
			updateFunction("sgm_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$camposUpdate=array('predefinido');
			$datosUpdate=array(0);
			updateFunction("sgm_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Paises."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Pais."</th>";
				echo "<th>".$Siglas."*</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=140&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"pais\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_paises where visible=1 order by pais";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
					$color = "white";
					if ($row["predefinido"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["predefinido"] == 1) {
						echo "<form action=\"index.php?op=1023&sop=140&ssop=5&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
						echo "</form>";
						echo "</td><td></td>";
					}
					if ($row["predefinido"] == 0) {
						echo "<form action=\"index.php?op=1023&sop=140&ssop=4&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
						echo "</form>";
						echo "</td><td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=141&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					}
					echo "<form action=\"index.php?op=1023&sop=140&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"pais\" style=\"width:200px\" value=\"".$row["pais"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\" value=\"".$row["siglas"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td colspan=\"6\">* ".$ayuda_iso_pais." <a href=\"https://es.wikipedia.org/wiki/ISO_3166-1\" target=\"_blank\">https://es.wikipedia.org/wiki/ISO_3166-1</a></td></tr>";
		echo "</table>";
	}

	if ($soption == 141) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=140&ssop=3&id=".$_GET["id"],"op=1023&sop=140"),array($Si,$No));
		echo "</center>";
	}

	echo "</td></tr></table><br>";
}

?>
