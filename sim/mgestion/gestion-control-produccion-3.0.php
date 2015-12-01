<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1016) AND ($autorizado == true)) {

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<strong>Gestión de Producción 3.0</strong>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if ($soption == 4) {$color = "white"; $colorl = "blue";	} else { $color = "#4B53AF"; $colorl = "white";	}
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black\">";
						echo "<a href=\"index.php?op=1016&sop=4\" style=\"color:".$colorl.";\">Vista Recursos</a>";
					echo "</td>";
					if (($soption == 0) or ($soption >= 500)) {$color = "white"; $colorl = "blue"; } else { $color = "#4B53AF"; $colorl = "white";	}
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black\">";
						echo "<a href=\"index.php?op=1016&sop=500\" style=\"color:".$colorl.";\">Vista Producció</a>";
					echo "</td>";
					if (($soption >= 1) and ($soption <= 50)) { $color = "white"; $colorl = "blue"; } else { $color = "#4B53AF"; $colorl = "white"; }
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black\">";
						echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:".$colorl.";\">Administrar</a>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";

#Gestió Producció#
	if ($soption >= 500) {
			echo "<tr><td></td><td><table>";
			$sqltipos = "select * from sgm_factura_tipos where tipo_ot=1 order by orden";
			$resulttipos = mysql_query(convertSQL($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)) {
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=510&id=".$rowtipos["id"]."\" style=\"color:white;\">".$rowtipos["tipo"]."</a>";
				echo "</td>";
			}
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=700\" style=\"color:white;\">Materiales Pendientes</a>";
				echo "</td>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=720\" style=\"color:white;\">Listado estados producción</a>";
				echo "</td>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=710\" style=\"color:white;\">Listado estados ordenes</a>";
				echo "</td>";
			echo "</tr></table></td>";
	}
#Gestió Producció fi#

		echo "</table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

#Vista general de produció
	if ($soption == 4) {
		if ($ssoption == 1) {
			$sql = "update sgm_recursos set ";
			$sql = $sql."id_estado = ".$_POST["id_estado"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Vista General</strong>";
		echo "<br>";
		echo "<table cellspacing=\"0\">";
			$sql = "select * from sgm_recursos_grupo where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr style=\"background-color:silver;width:600px;\"><td><strong>".$row["grupo"]."</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				echo "<tr>";
				$sqlt = "select count(*) as total from sgm_recursos where visible=1 and id_grupo=".$row["id"]." and pred=1";
				$resultt = mysql_query(convertSQL($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] > 0 ){
					echo "<td><table>";
						$sqlr = "select * from sgm_recursos where visible=1 and id_grupo=".$row["id"]." and pred=1";
						$resultr = mysql_query(convertSQL($sqlr));
						$rowr = mysql_fetch_array($resultr);
						if ($rowr["id_estado"] == 0){
							$sqle = "select * from sgm_recursos_estados where visible=1 order by horas desc";
							$resulte = mysql_query(convertSQL($sqle));
							while ($rowe = mysql_fetch_array($resulte)){
								if ($total_temps_recurs <= $rowe["horas"]){$color = $rowe["color"];}
							}
						} else {
							$sqle = "select * from sgm_recursos_estados_ad where visible=1 and id=".$rowr["id_estado"];
							$resulte = mysql_query(convertSQL($sqle));
							$rowe = mysql_fetch_array($resulte);
							$color = $rowe["color"];
						}
						echo "<tr><td><a href=\"index.php?op=1016&sop=100&id_re=".$rowr["id"]."\">".$rowr["recurso"]."</a></td></tr>";
						echo "<tr><td style=\"width:150px;height:30px;vertical-align:top;border:solid black 3px;background-color:".$color."\">&nbsp;</td></tr>";
						echo "<tr><td><form action=\"index.php?op=1016&sop=4&ssop=1&id=".$rowr["id"]."\" method=\"post\">";
							echo "<select name=\"id_estado\" style=\"width:100px\">";
								echo "<option value=\"0\">-</option>";
							$sqle = "select * from sgm_recursos_estados_ad where visible=1";
							$resulte = mysql_query(convertSQL($sqle));
							while ($rowe = mysql_fetch_array($resulte)) {
								if ($rowe["id"] == $rowr["id_estado"]){
									echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["estado"]."</option>";
								} else {
									echo "<option value=\"".$rowe["id"]."\">".$rowe["estado"]."</option>";
								}
							}
						echo "</select>";
						echo "<input type=\"Submit\" value=\"Cambiar\" style=\"width:50px\">";
						echo "</form></td></tr>";
						echo "<tr>";
							echo "<td style=\"width:150px;height:50px;vertical-align:top;\">";
							echo "Tiempo de carga: <br>";
							echo "Empleados: <br>";
							echo "</td>";
						echo "</tr>";
					echo "</table></td>";
					echo "<td style=\"width:15px;\">&nbsp;</td>";
				}
				$sqlt = "select count(*) as total from sgm_recursos where visible=1 and id_grupo=".$row["id"]." and pred=0";
				$resultt = mysql_query(convertSQL($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] > 0 ){
					$sqlr = "select * from sgm_recursos where visible=1 and id_grupo=".$row["id"]." and pred=0";
					$resultr = mysql_query(convertSQL($sqlr));
					while ($rowr = mysql_fetch_array($resultr)){
						echo "<td><table>";
						if ($rowr["id_estado"] == 0){
							$sqle = "select * from sgm_recursos_estados where visible=1 order by horas desc";
							$resulte = mysql_query(convertSQL($sqle));
							while ($rowe = mysql_fetch_array($resulte)){
								if ($total_temps_recurs <= $rowe["horas"]){$color = $rowe["color"];}
							}
						} else {
							$sqle = "select * from sgm_recursos_estados_ad where visible=1 and id=".$rowr["id_estado"];
							$resulte = mysql_query(convertSQL($sqle));
							$rowe = mysql_fetch_array($resulte);
							$color = $rowe["color"];
						}
						echo "<tr><td><a href=\"index.php?op=1016&sop=100&id_re=".$rowr["id"]."\">".$rowr["recurso"]."</a></td></tr>";
						echo "<tr><td style=\"width:150px;height:30px;vertical-align:top;background-color:".$color."\"></td></tr>";
						echo "<tr><td><form action=\"index.php?op=1016&sop=4&ssop=1&id=".$rowr["id"]."\" method=\"post\">";
							echo "<select name=\"id_estado\" style=\"width:100px\">";
								echo "<option value=\"0\">-</option>";
							$sqle = "select * from sgm_recursos_estados_ad where visible=1";
							$resulte = mysql_query(convertSQL($sqle));
							while ($rowe = mysql_fetch_array($resulte)) {
								if ($rowe["id"] == $rowr["id_estado"]){
									echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["estado"]."</option>";
								} else {
									echo "<option value=\"".$rowe["id"]."\">".$rowe["estado"]."</option>";
								}
							}
						echo "</select>";
						echo "<input type=\"Submit\" value=\"Cambiar\" style=\"width:50px\">";
						echo "</form></td></tr>";
					echo "<tr>";
						echo "<td style=\"width:150px;height:50px;vertical-align:top;\">";
						echo "Tiempo de carga: <br>";
						echo "Empleados: <br>";
						echo "</td>";
					echo "</tr>";
					echo "</table></td>";
					echo "<td style=\"width:15px;\">&nbsp;</td>";
					}
				}
			echo "</tr>";
		}
		echo "</table>";
	}
# fi vista general

#Administració de taules auxiliars del módul#
	if ($soption == 1) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=2\" style=\"color:white;\">Material</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=10\" style=\"color:white;\">Fases</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=5\" style=\"color:white;\">Recursos</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=25\" style=\"color:white;\">Operaciones</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=35\" style=\"color:white;\">Estados Recursos</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=40\" style=\"color:white;\">Estados Producción</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=50\" style=\"color:white;\">E-mail</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}
#Administració de taules auxiliars del módul fi#

#Materials#
	if ($soption == 2) {
		if ($ssoption == 1) {
			if ($_POST["preu_kl"] == "") {
				echo "<center>";
				echo "<br><br>No es posible añadir un material sin peso o sin precio por kilo.";
				echo "</center>";
			} else {
				$sql = "insert into sgm_material (codigo,material,descripcion,preu_kl,tarifa,especifico) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["codigo"]."'";
				$sql = $sql.",'".$_POST["material"]."'";
				$sql = $sql.",'".$_POST["descripcion"]."'";
				$sql = $sql.",'".$_POST["preu_kl"]."'";
				$sql = $sql.",'".$_POST["tarifa"]."'";
				$sql = $sql.",'".$_POST["especifico"]."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
			}
		}
		if ($ssoption == 2) {
				$sqlc = "update sgm_material set ";
				$sqlc = $sqlc."codigo='".$_POST["codigo"]."'";
				$sqlc = $sqlc.",material='".$_POST["material"]."'";
				$sqlc = $sqlc.",descripcion='".$_POST["descripcion"]."'";
				$sqlc = $sqlc.",x='".$_POST["x"]."'";
				$sqlc = $sqlc.",y='".$_POST["y"]."'";
				$sqlc = $sqlc.",z='".$_POST["z"]."'";
				$sqlc = $sqlc.",radio='".$_POST["radio"]."'";
				$sqlc = $sqlc.",diametro='".$_POST["diametro"]."'";
				$sqlc = $sqlc.",preu_kl='".$_POST["preu_kl"]."'";
				$sqlc = $sqlc.",tarifa='".$_POST["tarifa"]."'";
				$sqlc = $sqlc.",especifico='".$_POST["especifico"]."'";
				$sqlc = $sqlc.",calc_preu='".$_POST["calc_preu"]."'";
				$tarifa = ($_POST["tarifa"]/100)+1;
				if ($_POST["especifico"] == 1){
					if ($_POST["calc_preu"] == 0){
						$sqlc = $sqlc.",peso_espec='".$_POST["peso_espec"]."'";
						if (($_POST["y"] != 0) and ($_POST["x"] != 0)) {
							$volum = ($_POST["x"]*$_POST["y"]*$_POST["z"]);
						}
						if (($_POST["diametro"] != 0) or ($_POST["radio"] != 0)) {
							if ($_POST["diametro"] != 0){
								$radio = $_POST["diametro"]/2;
							} else {
								$radio = ($_POST["radio"]);
							}
							$volum = ((pi()*pow($radio,2))*($_POST["z"]));
						}
						$sqlc = $sqlc.",pes_mm3='".number_format((((($_POST["peso_espec"]/1000000)*$volum))/$volum), 8, '.', '')."'";
						$sqlc = $sqlc.",peso='".number_format(((($_POST["peso_espec"]/1000000)*$volum)), 8, '.', '')."'";
						$sqlc = $sqlc.",preu_mm3='".number_format(((((($_POST["peso_espec"]/1000000)*$volum)*$tarifa)*$_POST["preu_kl"])/$volum), 8, '.', '')."'";
						$sqlc = $sqlc.",preu_total='".number_format(((((($_POST["peso_espec"]/1000000)*$volum)*$tarifa)*$_POST["preu_kl"])), 4, '.', '')."'";
					}
					if ($_POST["calc_preu"] == 1){
						$sqlc = $sqlc.",peso='".$_POST["peso"]."'";
						if (($_POST["y"] != 0) and ($_POST["x"] != 0)) {
							$volum = ($_POST["x"]*$_POST["y"]*$_POST["z"]);
						}
						if (($_POST["diametro"] != 0) or ($_POST["radio"] != 0)) {
							if ($_POST["diametro"] != 0){
								$radio = $_POST["diametro"]/2;
							} else {
								$radio = ($_POST["radio"]);
							}
							$volum = ((pi()*pow($radio,2))*($_POST["z"]));
						}
						$sqlc = $sqlc.",pes_mm3='".number_format(($_POST["peso"]/$volum), 8, '.', '')."'";
						$sqlc = $sqlc.",peso_espec='".number_format((($_POST["peso"]/$volum)*1000000), 8, '.', '')."'";
						$sqlc = $sqlc.",preu_mm3='".number_format(((($_POST["peso"]*$tarifa)*$_POST["preu_kl"])/$volum), 8, '.', '')."'";
						$sqlc = $sqlc.",preu_total='".number_format((($_POST["peso"]*$tarifa)*$_POST["preu_kl"]), 4, '.', '')."'";
					}
				}
				if ($_POST["especifico"] == 2){
					$sqlc = $sqlc.",peso_espec='".($_POST["peso_espec"])."'";
					$sqlc = $sqlc.",pes_mm3='".number_format(($_POST["peso_espec"]/1000000), 8, '.', '')."'";
					$sqlc = $sqlc.",preu_mm3='".number_format(((($_POST["peso_espec"]/1000000)*$tarifa)*$_POST["preu_kl"]), 4, '.', '')."'";
				}
				$sqlc = $sqlc." WHERE id=".$_GET["id"]."";
				mysql_query(convertSQL($sqlc));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_material set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Material</strong>";
		echo "<br><br>";
			echo "<table><tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
					echo "</td>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1016&sop=2&id=0\" style=\"color:white;\">Añadir Material</a>";
					echo "</td>";
			echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table><tr><td style=\"vertical-align:top\">";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Codigo</td>";
				echo "<td style=\"text-align:center;\">Material</td>";
				echo "<td style=\"text-align:center;\">Precio/Kg.</td>";
				echo "<td style=\"text-align:center;\">Precio</td>";
				echo "<td><em>Editar</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_material where visible=1 and especifico=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=3&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td style=\"width:120;\">".$row["codigo"]."</td>";
						echo "<td style=\"width:250;\">".$row["material"]."</td>";
						echo "<td style=\"width:50;\">".$row["preu_kl"]."</td>";
						echo "<td style=\"width:50;\">".number_format($row["preu_total"],3,'.','')."</td>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
					echo "</tr>";
			}
		echo "</table>";
		echo "<br><br><br>";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Codigo</td>";
				echo "<td style=\"text-align:center;\">Material</td>";
				echo "<td style=\"text-align:center;\">Precio/Kg.</td>";
				echo "<td><em>Editar</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_material where visible=1 and especifico=2";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=3&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td style=\"width:120;\">".$row["codigo"]."</td>";
						echo "<td style=\"width:250;\">".$row["material"]."</td>";
						echo "<td style=\"width:50;\">".$row["preu_kl"]."</td>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
					echo "</tr>";
			}
		echo "</table>";
	echo "</td>";
	echo "<td style=\"width:70px\">&nbsp;";
	echo "</td><td style=\"vertical-align:top;\">";
	if ($_GET["id"] != "") {
	if ($_GET["id"] == 0) {
			echo "<strong>Añadir Nuevo Material</strong>";
			echo "<form action=\"index.php?op=1016&sop=2&ssop=1\" method=\"post\">";
		} else {
			echo "<strong>Modificar Material</strong>";
			echo "<form action=\"index.php?op=1016&sop=2&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
		}
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			$sql = "select * from sgm_material where visible=1 and id=".$_GET["id"];
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:left\"><strong>Definición Material</strong></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Codigo</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"codigo\" style=\"width:300px;\" value=\"".$row["codigo"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Material</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"material\" style=\"width:300px;\" value=\"".$row["material"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Descripcion</td>";
				echo "<td>";
					echo "<textarea rows=\"5\" name=\"descripcion\" style=\"width:300px;\">".$row["descripcion"]."</textarea>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Tarifa (%)</td>";
				echo "<td>";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td>";
								echo "<input type=\"text\" name=\"tarifa\" style=\"width:100px;\" value=\"".$row["tarifa"]."\">";
							echo "</td>";
							echo "<td style=\"text-align:center;width:100px;\">Precio €/ Kg.</td>";
						echo "<td>";
							echo "<input type=\"text\" name=\"preu_kl\" style=\"width:100px;\" value=\"".$row["preu_kl"]."\">";
						echo "</td>";
					echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Tipo</td>";
				echo "<td>";
					echo "<select name=\"especifico\" style=\"width:100px;\">";
					if ($row["especifico"] != 2) {
						echo "<option value=\"1\" selected>Barra</option>";
						echo "<option value=\"2\">Material</option>";
					}
					if ($row["especifico"] == 2) {
						echo "<option value=\"1\">Barra</option>";
						echo "<option value=\"2\" selected>Material</option>";
					}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			if ($row["especifico"] == 1) {
				echo "<tr>";
					echo "<td></td>";
					echo "<td style=\"text-align:left\"><strong>Dimesiones Barra</strong></td>";
				echo "</tr><tr>";
					echo "<td style=\"text-align:right\">X (mm.)</td>";
					echo "<td>";
						echo "<table cellpadding=\"0\" cellspacing=\"0\">";
							echo "<tr>";
								#echo "<td style=\"text-align:right\">X</td>";
								echo "<td style=\"text-align:left\">";
									echo "<input type=\"text\" name=\"x\" style=\"width:62px;\" value=\"".$row["x"]."\">";
								echo "</td>";
								echo "<td style=\"text-align:center;width:57px;\">Y (mm.)</td>";
								echo "<td>";
									echo "<input type=\"text\" name=\"y\" style=\"width:62px;\" value=\"".$row["y"]."\">";
								echo "</td>";
								echo "<td style=\"text-align:center;width:58px;\">Z (mm.)</td>";
								echo "<td>";
									echo "<input type=\"text\" name=\"z\" style=\"width:62px;\" value=\"".$row["z"]."\">";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr><tr>";	
					echo "<td style=\"text-align:right\">Radio (mm.)</td>";
					echo "<td>";
						echo "<table cellpadding=\"0\" cellspacing=\"0\">";
							echo "<tr>";
								echo "<td>";
									echo "<input type=\"text\" name=\"radio\" style=\"width:100px;\" value=\"".$row["radio"]."\">";
								echo "</td>";
								echo "<td style=\"text-align:center;width:100px;\">Diametro (mm.)</td>";
							echo "<td>";
								echo "<input type=\"text\" name=\"diametro\" style=\"width:100px;\" value=\"".$row["diametro"]."\">";
							echo "</td>";
						echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr><tr>";
					echo "<td style=\"text-align:right\"></td>";
					echo "<td>Calculo Peso :</td>";
				echo "</tr>";
				echo "</tr><tr>";
					echo "<td></td>";
					echo "<td><table><tr>";
						echo "<td style=\"width:50px;text-align:center;\">";
						if ($row["calc_preu"] == 0) {
							echo "<input type=\"Radio\" name=\"calc_preu\" value=\"0\" checked>";
						} else {
							echo "<input type=\"Radio\" name=\"calc_preu\" value=\"0\">";
						}
						echo "</td>";
						echo "<td style=\"text-align:right;width:140px;\">Peso Específico(kg/dm&sup3;)</td>";
						echo "<td style=\"text-align:right\">";
							echo "<input type=\"text\" name=\"peso_espec\" style=\"width:100px;\" value=\"".$row["peso_espec"]."\">";
						echo "</td>";
					echo "</tr></table></td>";
				echo "</tr><tr>";
					echo "<td></td>";
					echo "<td><table><tr>";
						echo "<td style=\"width:50px;text-align:center;\">";
						if ($row["calc_preu"] == 1) {
							echo "<input type=\"Radio\" name=\"calc_preu\" value=\"1\" checked>";
						} else {
							echo "<input type=\"Radio\" name=\"calc_preu\" value=\"1\">";
						}
						echo "</td>";
						echo "<td style=\"text-align:right;width:140px;\">Peso (kg.)</td>";
						echo "<td style=\"text-align:right\">";
							echo "<input type=\"text\" name=\"peso\" style=\"width:100px;\" value=\"".$row["peso"]."\">";
						echo "</td>";
					echo "</tr></table></td>";
				echo "</tr>";
			}
			if ($row["especifico"] == 2) {
				echo "<tr>";
					echo "<td></td>";
					echo "<td style=\"text-align:left\"><strong>Dimesiones Material</strong></td>";
				echo "</tr><tr>";
					echo "<td style=\"text-align:right\">Peso Específico(kg/dm&sup3;)</td>";
					echo "<td>";
						echo "<input type=\"text\" name=\"peso_espec\" style=\"width:100px;\" value=\"".$row["peso_espec"]."\">";
					echo "</td>";
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td style=\"text-align:right\">Precio mm&sup3;(€)</td>";
				echo "<td>";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:100px;\"><strong>".$row["preu_mm3"]."</strong></td>";
							echo "<td style=\"text-align:center;width:100px;\">Pes mm&sup3;(Kg.)</td>";
							echo "<td style=\"width:100px;\"><strong>".$row["pes_mm3"]."</strong></td>";
					echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr>";
			echo "<tr>";
				echo "<td style=\"text-align:right\">Precio total(€)</td>";
				echo "<td>";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:100px;\"><strong>".$row["preu_total"]."</strong></td>";
							echo "<td style=\"text-align:center;width:100px;\"></td>";
							echo "<td style=\"width:100px;\"><strong></strong></td>";
					echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
					if ($_GET["id"] == 0) {
						echo "<input type=\"submit\" value=\"Añadir\" style=\"width:100px\">";
					}else{
						echo "<input type=\"submit\" value=\"Modificar\" style=\"width:100px\">";
					}
				echo "</td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}
	echo "</td></tr></table>";
	echo "</center>";
	}

	if ($soption == 3) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este material?";
		echo "<br><br><a href=\"index.php?op=1016&sop=2&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=2\">[ NO ]</a>";
		echo "</center>";
	}
#Materials fi#

#Recursos#
	if ($soption == 5) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_recursos_grupo (grupo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["grupo"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_recursos_grupo set ";
			$sql = $sql."grupo='".$_POST["grupo"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_recursos_grupo set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_recursos set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id<>".$_GET["id_pre"]." and id_grupo=".$_GET["id_grupo"];
			mysql_query(convertSQL($sql));
			$sql = "update sgm_recursos set ";
			$sql = $sql."pred = 1";
			$sql = $sql." WHERE id =".$_GET["id_pre"]." and id_grupo=".$_GET["id_grupo"];
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_recursos set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id =".$_GET["id_pre"]." and id_grupo=".$_GET["id_grupo"];
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 6) {
			if (($_POST["coste_hora"] == "") or ($_POST["temps_pre"] == "")){
				echo "<center>";
				echo "<br><br>No es posible añadir un recurso sin precio por hora o sin tiempo de preparación.";
				echo "</center>";
			} else {
				$sql = "insert into sgm_recursos (recurso,notas,coste_hora,unitat,id_grupo,temps_pre) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["recurso"]."'";
				$sql = $sql.",'".$_POST["notas"]."'";
				$sql = $sql.",'".$_POST["coste_hora"]."'";
				$sql = $sql.",".$_POST["unitat"]."";
				$sql = $sql.",".$_POST["id_grupo"]."";
				$sql = $sql.",".$_POST["temps_pre"]."";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
			}
		}
		if ($ssoption == 7) {
			$sql = "select * from sgm_recursos where id=".$_GET["id"]."";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			$sql = "update sgm_recursos set ";
			$sql = $sql."recurso='".$_POST["recurso"]."'";
			$sql = $sql.",notas='".$_POST["notas"]."'";
			$sql = $sql.",coste_hora='".$_POST["coste_hora"]."'";
			$sql = $sql.",unitat=".$_POST["unitat"]."";
			$sql = $sql.",id_grupo=".$_POST["id_grupo"]."";
			$sql = $sql.",temps_pre=".$_POST["temps_pre"]."";
			if ($row["id_grupo"] != $_POST["id_grupo"]) {
				$sql = $sql.",pred=0";
			}
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 8) {
			$sql = "update sgm_recursos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Recursos</strong>";
		echo "<br><br>";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=5&id_re=0\" style=\"color:white;\">Añadir Recurso</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "<br><br>";
		echo "<table><tr><td>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Grupo</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><form action=\"index.php?op=1016&sop=5&ssop=1\" method=\"post\"></td>";
				echo "<td><input name=\"grupo\" type=\"text\" style=\"width:250px;height:16px;\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_recursos_grupo where visible=1 order by grupo";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr style=\"background-color:silver;\">";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=6&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1016&sop=5&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input name=\"grupo\" type=\"text\" style=\"width:250px;height:16px;\" value=\"".$row["grupo"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
				echo "<tr><td></td><td>";
					echo "<table cellspacing=\"0\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<td></td>";
							echo "<td><em>Eliminar</em></td>";
							echo "<td>Recurso</td>";
							echo "<td></td>";
						echo "</tr>";
						$sqlsu= "select * from sgm_recursos where visible=1 and id_grupo=".$row["id"];
						$resultsu = mysql_query(convertSQL($sqlsu));
						while ($rowsu = mysql_fetch_array($resultsu)){
							$color = "white";
							$colorl = "black";
							if ($rowsu["pred"] == 1) { $color = "#FF4500"; $colorl = "white"; }
							echo "<tr style=\"background-color : ".$color."\">";
								echo "<td>";
								if ($rowsu["pred"] == 1) {
									echo "<form action=\"index.php?op=1016&sop=5&ssop=5&id_pre=".$rowsu["id"]."&id_grupo=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"Despred\" style=\"width:50px\">";
									echo "</form>";
								}
								if ($rowsu["pred"] == 0) {
									echo "<form action=\"index.php?op=1016&sop=5&ssop=4&id_pre=".$rowsu["id"]."&id_grupo=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"Pred\" style=\"width:50px\">";
									echo "</form>";
								}
								echo "</td>";
								echo "<form action=\"index.php?op=1016&sop=5&id_re=".$rowsu["id"]."\" method=\"post\">";
								echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=7&id=".$rowsu["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<td><input name=\"operacion\" type=\"Text\" value=\"".$rowsu["recurso"]."\" style=\"width:90px;\" disabled></td>";
								echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:60px;\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td></tr>";
				echo "<tr>";
					echo "<td>&nbsp;<br>&nbsp;</td>";
				echo "</tr>";
			}
		echo "</table></center>";
		echo "</td><td>&nbsp;</td><td style=\"vertical-align:top\">";
	if ($_GET["id_re"] != "") {
	if ($_GET["id_re"] == 0) {
			echo "<strong>Añadir Nuevo Recurso</strong>";
			echo "<form action=\"index.php?op=1016&sop=5&ssop=6\" method=\"post\">";
		} else {
			echo "<strong>Modificar Recurso</strong>";
			echo "<form action=\"index.php?op=1016&sop=5&ssop=7&id=".$_GET["id_re"]."\" method=\"post\">";
		}
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			$sql = "select * from sgm_recursos where visible=1 and id=".$_GET["id_re"];
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			echo "<tr>";
				echo "<td style=\"text-align:right\">Recurso</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"recurso\" style=\"width:300px;\" value=\"".$row["recurso"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Notas</td>";
				echo "<td>";
					echo "<textarea rows=\"6\" name=\"notas\" style=\"width:300px;\">".$row["notas"]."</textarea>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Coste/Hora (€.)</td>";
				echo "<td>";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"text-align:left\">";
								echo "<input type=\"text\" name=\"coste_hora\" style=\"width:150px;\" value=\"".$row["coste_hora"]."\">";
							echo "</td>";
							echo "<td style=\"text-align:center;width:80px;\">Preu unitat</td>";
							echo "<td>";
								echo "<select name=\"unitat\" style=\"width:70px;\">";
									if ($row["unitat"] == 0) {
										echo "<option value=\"0\" selected>NO</option>";
										echo "<option value=\"1\">SI</option>";
									} else {
										echo "<option value=\"0\">NO</option>";
										echo "<option value=\"1\" selected>SI</option>";
									}
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Grupo</td>";
				echo "<td>";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"text-align:left\">";
								echo "<select name=\"id_grupo\" style=\"width:150px;\">";
									$sqlg = "select * from sgm_recursos_grupo where visible=1 order by grupo";
									$resultg = mysql_query(convertSQL($sqlg));
									while ($rowg = mysql_fetch_array($resultg)){
										if ($rowg["id"] == $row["id_grupo"]) {
											echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["grupo"]."</option>";
										} else {
											echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
										}
									}
							echo "</td>";
							echo "<td style=\"text-align:center;width:110px;\">Tiempo preparación</td>";
							echo "<td>";
								echo "<input type=\"text\" name=\"temps_pre\" style=\"width:40px;\" value=\"".$row["temps_pre"]."\">";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
					if ($_GET["id_re"] == 0) {
						echo "<input type=\"submit\" value=\"Añadir\" style=\"width:100px\">";
					}else{
						echo "<input type=\"submit\" value=\"Modificar\" style=\"width:100px\">";
					}
				echo "</td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}
	echo "</td></tr></table>";
	}

	if ($soption == 6) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este grupo?";
		echo "<br><br><a href=\"index.php?op=1016&sop=5&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=5\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 7) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este recurso?";
		echo "<br><br><a href=\"index.php?op=1016&sop=5&ssop=8&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=5\">[ NO ]</a>";
		echo "</center>";
	}
#Recursos fi#

#fases#
	if ($soption == 10) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_fases (fase,notas) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["fase"]."'";
			$sql = $sql.",'".$_POST["notas"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_fases set ";
			$sql = $sql."fase='".$_POST["fase"]."'";
			$sql = $sql.",notas='".$_POST["notas"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_fases set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Fases</strong>";
		echo "<br><br>";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=10&id=0\" style=\"color:white;\">Añadir Fase</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table><tr><td style=\"vertical-align:top\">";
		echo "<table cellspacing=\"0\" style=\"width:450px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Fases</td>";
				echo "<td><em>Editar</em></td>";
				echo "<td><em>Grupos</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_fases where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "black";
				if ($row["id"] == $_GET["id"]){
					echo "<tr style=\"background-color:#4B53AF;\">";
					$color = "white";
				} else {
					echo "<tr>";
				}
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=11&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td style=\"color:".$color.";width:370;\">".$row["fase"]."</td>";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=10&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=12&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_gear.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
	echo "</td>";
	echo "<td style=\"width:70px\">&nbsp;";
	echo "</td><td style=\"vertical-align:top;\">";
	if ($_GET["id"] != "") {
	if ($_GET["id"] == 0) {
			echo "<strong>Añadir Nueva Fase</strong>";
			echo "<form action=\"index.php?op=1016&sop=10&ssop=1\" method=\"post\">";
		} else {
			echo "<strong>Modificar Fase</strong>";
			echo "<form action=\"index.php?op=1016&sop=10&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
		}
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			echo "<tr>";
			echo "<td></td>";
			$sql = "select * from sgm_fases where visible=1 and id=".$_GET["id"];
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Fase</td>";
				echo "<td>";
					echo "<input type=\"text\" name=\"fase\" style=\"width:300px;\" value=\"".$row["fase"]."\">";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right\">Notas</td>";
				echo "<td>";
					echo "<textarea rows=\"6\" name=\"notas\" style=\"width:300px;\">".$row["notas"]."</textarea>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
					if ($_GET["id"] == 0) {
						echo "<input type=\"submit\" value=\"Añadir\" style=\"width:100px\">";
					}else{
						echo "<input type=\"submit\" value=\"Modificar\" style=\"width:100px\">";
					}
				echo "</td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}
	echo "</td></tr></table>";
	echo "</center>";
	}

	if ($soption == 11) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta fase?";
		echo "<br><br><a href=\"index.php?op=1016&sop=10&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=10\">[ NO ]</a>";
		echo "</center>";
	}
#fases fi#

#grups per fases#
	if ($soption == 12) {
		if ($ssoption == 1) {
				$sql = "insert into sgm_fases_grupo_rec (id_fase,id_grupo_rec) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_GET["id"]."'";
				$sql = $sql.",'".$_POST["id_grupo_rec"]."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_fases_grupo_rec set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_grup"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_fases_grupo_rec set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id<>".$_GET["id_grup"]."";
			mysql_query(convertSQL($sql));
			$sql = "update sgm_fases_grupo_rec set ";
			$sql = $sql."pred = 1";
			$sql = $sql." WHERE id =".$_GET["id_grup"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_fases_grupo_rec set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id =".$_GET["id_grup"]."";
			mysql_query(convertSQL($sql));
		}
		$sql = "select * from sgm_fases where visible=1 and id=".$_GET["id"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>Grupos de recursos de la fase : ".$row["fase"]."</strong>";
		echo "<br><br>";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=10\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Predeterminar</em></td>";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Grupo</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1016&sop=12&ssop=1&id=".$row["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><select name=\"id_grupo_rec\" style=\"width:210px\">";
					$sql = "select * from sgm_recursos_grupo where visible=1";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)) {
						$sqlf = "select count(*) as total from sgm_fases_grupo_rec where visible=1 and id_fase=".$_GET["id"]." and id_grupo_rec=".$row["id"];
						$resultf = mysql_query(convertSQL($sqlf));
						$rowf = mysql_fetch_array($resultf);
						if ($rowf["total"] <= 0) {
							echo "<option value=\"".$row["id"]."\">".$row["grupo"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_fases_grupo_rec where visible=1 and id_fase=".$_GET["id"];
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
					$color = "white";
					if ($row["pred"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["pred"] == 1) {
						echo "<form action=\"index.php?op=1016&sop=12&ssop=5&id=".$_GET["id"]."&id_grup=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"Despre.\" style=\"width:50px\">";
						echo "</form>";
					}
					if ($row["pred"] == 0) {
						echo "<form action=\"index.php?op=1016&sop=12&ssop=4&id=".$_GET["id"]."&id_grup=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"Predet.\" style=\"width:50px\">";
						echo "</form>";
					}
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1016&sop=13&id=".$_GET["id"]."&id_grup=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					$sqlg = "select * from sgm_recursos_grupo where visible=1 and id=".$row["id_grupo_rec"];
					$resultg = mysql_query(convertSQL($sqlg));
					$rowg = mysql_fetch_array($resultg);
					echo "<td>".$rowg["grupo"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 13) {
		echo "<center>";
		echo "<br><br>¿Desea eliminar el grupo seleccionado?";
		echo "<br><br><a href=\"index.php?op=1016&sop=12&ssop=3&id=".$_GET["id"]."&id_grup=".$_GET["id_grup"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1016&sop=12&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}
#fi grups per fases#

#estats#
	if ($soption == 15) {
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
		if ($ssoption == 3) {
			$sql = "update sgm_cuerpo_estados set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Fases</strong>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table><tr><td style=\"vertical-align:top\">";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "<br><br><br>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Estado</td>";
				echo "<td>Color</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=15&ssop=1&id=".$row["id"]."\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"estado\" value=\"".$row["estado"]."\" style=\"width:100px;\"></td>";
				echo "<td><input type=\"Text\" name=\"color\" value=\"".$row["color"]."\" style=\"width:100px;\"></td>";
				echo "<td><select name=\"externo\" style=\"width:100px;\">";
					echo "<option value=\"0\">Interno</option>";
					echo "<option value=\"1\">Externo</option>";
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
		$sql = "select * from sgm_cuerpo_estados where visible=1 order by estado";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr bgcolor=\"".$row["color"]."\">";
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=15&ssop=2&id=".$row["id"]."\">";
				echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=16&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<td><input type=\"Text\" name=\"estado\" value=\"".$row["estado"]."\" style=\"width:100px;\"></td>";
				echo "<td><input type=\"Text\" name=\"color\" value=\"".$row["color"]."\" style=\"width:100px;\"></td>";
				echo "<td><select name=\"externo\" style=\"width:100px;\">";
					if ($row["externo"] == 0) {
						echo "<option value=\"0\" selected>Interno</option>";
						echo "<option value=\"1\">Externo</option>";
					}
					if ($row["externo"] == 1) {
						echo "<option value=\"0\">Interno</option>";
						echo "<option value=\"1\" selected>Externo</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 16) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este estado?";
		echo "<br><br><a href=\"index.php?op=1016&sop=15&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=15\">[ NO ]</a>";
		echo "</center>";
	}
#estats fi#

#grupos recursos#
	if ($soption == 20) {
		echo "<strong>Grupos Recursos</strong>";
		echo "<br><br>";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=5\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:300px\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Nombre Grupo</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><form action=\"index.php?op=1016&sop=20&ssop=1&id=".$row["id"]."\" method=\"post\"></td>";
				echo "<td><input name=\"grupo\" type=\"Text\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_recursos_grupo where visible=1 order by grupo";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=21&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1016&sop=20&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input name=\"grupo\" type=\"Text\" value=\"".$row["grupo"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 21) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este grupo de recurso?";
		echo "<br><br><a href=\"index.php?op=1016&sop=20&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=20\">[ NO ]</a>";
		echo "</center>";
	}
#fi grupos recursos#

#operaciones#
	if ($soption == 25) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_operaciones (operacion,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["operacion"]."'";
			$sql = $sql.",'".$_POST["descripcion"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_operaciones set ";
			$sql = $sql."operacion='".$_POST["operacion"]."'";
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_operaciones set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Operaciones</strong>";
		echo "<br><br>";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:500px\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Operación</td>";
				echo "<td>Descripcion</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><form action=\"index.php?op=1016&sop=25&ssop=1&id=".$row["id"]."\" method=\"post\"></td>";
				echo "<td><input name=\"operacion\" type=\"Text\"></td>";
				echo "<td><input name=\"descripcion\" type=\"Text\" style=\"width:300px\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_operaciones where visible=1 order by operacion";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=26&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1016&sop=25&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input name=\"operacion\" type=\"Text\" value=\"".$row["operacion"]."\"></td>";
					echo "<td><input name=\"descripcion\" type=\"Text\" value=\"".$row["descripcion"]."\" style=\"width:300px\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 26) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta operación?";
		echo "<br><br><a href=\"index.php?op=1016&sop=25&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=25\">[ NO ]</a>";
		echo "</center>";
	}
#fi operaciones#

#estados recursos#
	if ($soption == 35) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_recursos_estados (estado,horas,color) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["estado"]."'";
			$sql = $sql.",".$_POST["horas"]."";
			$sql = $sql.",'".$_POST["color"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_recursos_estados set ";
			$sql = $sql."estado='".$_POST["estado"]."'";
			$sql = $sql.",horas=".$_POST["horas"]."";
			$sql = $sql.",color='".$_POST["color"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_recursos_estados set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 4) {
			$sql = "insert into sgm_recursos_estados_ad (estado,color) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["estado"]."'";
			$sql = $sql.",'".$_POST["color"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_recursos_estados_ad set ";
			$sql = $sql."estado='".$_POST["estado"]."'";
			$sql = $sql.",color='".$_POST["color"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 6) {
			$sql = "update sgm_recursos_estados_ad set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Estados de Recursos</strong>";
		echo "<br><br>";
		echo "<table cellspacing=\"0\"><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center><table><tr><td style=\"vertical-align:top;\">";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Estado</td>";
				echo "<td>Horas</td>";
				echo "<td>Color</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1016&sop=35&ssop=1&id=".$row["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"estado\" style=\"width:100px\"></td>";
				echo "<td><input type=\"text\" name=\"horas\" value=\"0\" style=\"width:100px;text-align:right;\"></td>";
				echo "<td><input type=\"text\" name=\"color\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_recursos_estados where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr style=\"background-color:".$row["color"]."\">";
					echo "<form action=\"index.php?op=1016&sop=35&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=36&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input type=\"text\" name=\"estado\" value=\"".$row["estado"]."\" style=\"width:100px\"></td>";
					echo "<td><input type=\"text\" name=\"horas\" value=\"".$row["horas"]."\" style=\"width:100px;text-align:right;\"></td>";
					echo "<td><input type=\"text\" name=\"color\" value=\"".$row["color"]."\" style=\"width:100px;text-align:right;\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "<br><br>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><strong>Estados Adicionales</strong></td>";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Estado</td>";
				echo "<td>Color</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1016&sop=35&ssop=4\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"estado\" style=\"width:100px\"></td>";
				echo "<td><input type=\"text\" name=\"color\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_recursos_estados_ad where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr style=\"background-color:".$row["color"]."\">";
					echo "<form action=\"index.php?op=1016&sop=35&ssop=5&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=1016&sop=37&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input type=\"text\" name=\"estado\" value=\"".$row["estado"]."\" style=\"width:100px\"></td>";
					echo "<td><input type=\"text\" name=\"color\" value=\"".$row["color"]."\" style=\"width:100px;text-align:right;\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:100px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	echo "</td><td bgcolor=\"#CCCCCC\" style=\"vertical-align:top;\">";
	colors();
	echo "</td></tr></table></center>";
	}

	if ($soption == 36) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este estado?";
		echo "<br><br><a href=\"index.php?op=1016&sop=35&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=35\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 37) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este estado?";
		echo "<br><br><a href=\"index.php?op=1016&sop=35&ssop=6&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1016&sop=35\">[ NO ]</a>";
		echo "</center>";
	}
#fi estados recursos#

#Estados producció#
	if ($soption == 40) {
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
		echo "<br><br>";
		echo "<table cellspacing=\"0\"><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
			echo "</td>";
		echo "</tr></table>";
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
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=40&ssop=1&id=".$row["id"]."\">";
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
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=40&ssop=2&id=".$row["id"]."\">";
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
#fi estados producció#

	if ($soption == 50) {
		if ($ssoption == 1) {
			$sql = "select count(*) as total from sgm_cartas where visible=1";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] > 0) {
				$sql = "update sgm_cartas set ";
				$sql = $sql."asunto='".$_POST["asunto"]."'";
				$sql = $sql.",cuerpo='".$_POST["message"]."'";
				$sql = $sql.",carta=0";
				$sql = $sql." WHERE id=1";
				mysql_query(convertSQL($sql));
			} else {
				$sql1 = "insert into sgm_cartas (asunto,cuerpo,carta,visible) ";
				$sql1 = $sql1."values (";
				$sql1 = $sql1."'".$_POST["asunto"]."'";
				$sql1 = $sql1.",'".$_POST["message"]."'";
				$sql1 = $sql1.",0";
				$sql1 = $sql1.",1";
				$sql1 = $sql1.")";
				mysql_query(convertSQL($sql1));
			}
		}

		echo "<strong>Email</strong><br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=1\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center><table><tr><td>";
			echo "<table>";
					$sql = "select * from sgm_cartas where visible=1";
					$result = mysql_query(convertSQL($sql));
					$row = mysql_fetch_array($result);
					echo "<form action=\"index.php?op=1016&sop=50&ssop=1\" method=\"post\" name=\"post\">";
					echo "<tr><td style=\"text-align:right\"><strong>Asunto :</strong></td><td><input type=\"Text\" name=\"asunto\" style=\"width:600px\" value=\"".$row["asunto"]."\"></td></tr>";
					echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>Texto :</strong></td><td><textarea name=\"message\" rows=\"20\" style=\"width:600px\">".$row["cuerpo"]."</textarea></td></tr>";
					echo "<tr><td></td><td><input type=\"submit\" value=\"Modificar\" style=\"width:150px\"></td></tr>";
					echo "</form>";
			echo "</table>";
		echo "</td><td style=\"vertical-align:top\">";
			echo "<table><tr><td>&nbsp;</td></tr><tr><td>";
				include ("bbcode1.php");
			echo "</td></tr></table>";
		echo "</td></tr></table></center>";
	}

#Carrega dels recursos#
	if ($soption == 100) {
		$sqlt = "select * from sgm_recursos where visible=1 and id=".$_GET["id_re"];
		$resultt = mysql_query(convertSQL($sqlt));
		$rowt = mysql_fetch_array($resultt);
		echo "<strong>Carga del Recurso : ".$rowt["recurso"]."</strong>";
		echo "<br><br>";
		echo "<table cellspacing=\"0\"><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1016&sop=4\" style=\"color:white;\">&laquo; Volver</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:200px\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td>Operación</td>";
				echo "<td>Tiempo</td>";
				echo "<td></td>";
			echo "</tr>";
			$sqlc = "select * from sgm_articles_costos where visible=1 and aprovat=1";
			$resultc = mysql_query(convertSQL($sqlc));
			while ($rowc = mysql_fetch_array($resultc)){
				$sqlfr = "select * from sgm_articles_fases_recursos where visible=1 and id_recurso=".$rowt["id_grupo"]." and id_coste=".$rowc["id"];
				$resultfr = mysql_query(convertSQL($sqlfr));
				while ($rowfr = mysql_fetch_array($resultfr)){
					$sqle = "select * from sgm_articles_estacada where visible=1 and id_fase_recurso=".$rowfr["id"];
					$resulte = mysql_query(convertSQL($sqle));
					while ($rowe = mysql_fetch_array($resulte)){
						$sqlo = "select * from sgm_articles_operaciones where visible=1 and id_estacada=".$rowe["id"];
						$resulto = mysql_query(convertSQL($sqlo));
						while ($rowo = mysql_fetch_array($resulto)){
							$sqlop = "select * from sgm_operaciones where visible=1 and id=".$rowo["id_operacion"];
							$resultop = mysql_query(convertSQL($sqlop));
							$rowop = mysql_fetch_array($resultop);
							echo "<tr>";
								echo "<td>".$rowop["operacion"]."</td>";
								echo "<td>".$rowo["temps"]."</td>";
							echo "</tr>";
						}
					}
				}
			}
		echo "</table>";
	}
#Carrega dels recursos fi#

#Gestió Comandes#
	if (($soption == 0) or ($soption == 510)) {
		if ($ssoption == 10) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."confirmada_cliente=1";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convertSQL($sql));
			$sqle = "select * from sgm_cuerpo where idfactura=".$_GET["id_fact"];
			$resulte = mysql_query(convertSQL($sqle));
			while ($rowe = mysql_fetch_array($resulte)) {
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."aprovat=1";
				$sql = $sql.",fecha_prevision='".$rowe["fecha_prevision_propia"]."'";
				$sql = $sql." WHERE id=".$rowe["id"]."";
				mysql_query(convertSQL($sql));
			}
		}
		if ($ssoption == 20) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."confirmada_cliente=0";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convertSQL($sql));
			$sqle = "select * from sgm_cuerpo where idfactura=".$_GET["id_fact"];
			$resulte = mysql_query(convertSQL($sqle));
			while ($rowe = mysql_fetch_array($resulte)) {
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."aprovat=0";
				$sql = $sql." WHERE id=".$rowe["id"]."";
				mysql_query(convertSQL($sql));
			}
		}
		if ($ssoption == 30) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."confirmada=1";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 40) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."confirmada=0";
			$sql = $sql." WHERE id=".$_GET["id_fact"]."";
			mysql_query(convertSQL($sql));
		}
		if ($_GET["id"] == 0){
			$sqltipos1 = "select * from sgm_factura_tipos where tipo_ot=1 order by orden";
			$resulttipos1 = mysql_query(convertSQL($sqltipos1));
			$rowtipos1 = mysql_fetch_array($resulttipos1);
		}
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id"].$rowtipos1["id"]." order by id";
		$resulttipos = mysql_query(convertSQL($sqltipos));
		$rowtipos = mysql_fetch_array($resulttipos);
		echo "<table style=\"width:100%\">";
			echo "<tr>";
				echo "<td style=\"width:50%\">";
					echo "<strong style=\"font-size : 20px;\">".$rowtipos["tipo"]."</strong><br><br>";
					if ($ssoption == 1){
						echo "<a href=\"index.php?op=1016&sop=510&id=".$rowtipos["id"]."\">Ver Actual</a>&nbsp;";
					} else {
						echo "<a href=\"index.php?op=1016&sop=510&id=".$rowtipos["id"]."&ssop=1\">Ver Histórico</a>&nbsp;";
					}
				echo "</td>";
				echo "<td style=\"width:50%;background-color : #DBDBDB;text-align:center;\">";
					echo "<center><table>";
						echo "<tr>";
							echo "<td><strong>Cliente</strong></td>";
							echo "<td><strong>Ref. Ped. Cli.</strong></td>";
							echo "<td><strong>Desde</strong></td>";
							echo "<td><strong>Hasta</strong></td>";
							echo "<td><strong>Articulo</strong></td>";
						echo "</tr><tr>";
							echo "<form action=\"index.php?op=1016&sop=510&hist=0&filtra=1&id=".$_GET["id"].$rowtipos1["id"]."\" method=\"post\">";
							echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
							echo "<td>";
								echo "<select style=\"width:180px\" name=\"id_cliente\">";
								echo "<option value=\"0\">-</option>";
									$sql = "select * from sgm_clients where visible=1 ";
									$sql = $sql."order by nombre";
									$result = mysql_query(convertSQL($sql));
									while ($row = mysql_fetch_array($result)) {
										echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
									}
								echo "</select>";
							echo "</td>";
							echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\"></td>";
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
							echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"articulo\" value=\"".$_POST["articulo"]."\"></td>";
							echo "<td><input type=\"Submit\" value=\"Filtro\" style=\"width:80px\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1016&sop=510&hist=1&filtra=1&id=".$_GET["id"]."\" method=\"post\">";
							echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$rowtipos["id"]."\">";
							echo "<td>";
								echo "<select style=\"width:180px\" name=\"id_cliente\">";
								echo "<option value=\"0\">-</option>";
								$sql = "select * from sgm_clients where visible=1 ";
								$sql = $sql."order by nombre";
								$result = mysql_query(convertSQL($sql));
								while ($row = mysql_fetch_array($result)) {
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
								}
								echo "</select>";
							echo "</td>";
							echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\"></td>";
							echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_desde2\" value=\"".$data2."\"></td>";
							echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"data_fins2\" value=\"".$data3."\"></td>";
							echo "<td><input type=\"Text\" style=\"width:80px;\" name=\"articulo\" value=\"".$_POST["articulo"]."\"></td>";
							echo "<td><input type=\"Submit\" value=\"Filtro Hist.\" style=\"width:80px\"></td>";
							echo "</form>";
						echo "</tr>";
					echo "</table></center>";
					echo "<br>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<center><table cellpadding=\"1\" cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"width:60px\">Número</td>";
				echo "<td style=\"width:100px\">Fecha</td>";
				echo "<td style=\"width:100px\">Fecha previsión</td>";
				echo "<td style=\"width:150px\">Ref. Ped. Cli.</td>";
				echo "<td style=\"width:200px\">Cliente</td>";
				echo "<td style=\"width:75px\"></td>";
				echo "<td style=\"width:75px\"></td>";
				echo "<td style=\"width:75px\">Interno</td>";
				echo "<td style=\"width:75px\">Cliente</td>";
			echo "</tr>";
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$_GET["id"].$rowtipos1["id"]."";
			if (($_GET["filtra"] == 1) AND ($_POST["id_cliente"] != 0)) { $sql = $sql." AND id_cliente=".$_POST["id_cliente"]; }
			if (($_GET["filtra"] == 1) AND ($_POST["ref_cli"] != '')) { $sql = $sql." AND numero_cliente like '%".$_POST["ref_cli"]."%'"; }
			$sql = $sql." order by numero desc,fecha desc";
			$result = mysql_query(convertSQL($sql));
			$fechahoy = getdate();
			$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-100, $fechahoy["year"]));
			$hoy = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
			while ($row = mysql_fetch_array($result)) {
				#### OPCIONES DE VISUALIZACION SI SE MUESTRA O NO
				$ver = 1;
#				if ($data1 <= $row["fecha"]) { $ver = 1; }
				if ($row["cerrada"] == 1) { $ver = 0; }
				if ($ssoption == 1) { $ver = 1; }
				if ($_GET["filtra"]  == 1){
					$sqlcc = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
					if ($_GET["hist"] == 0) { $sqlcc = $sqlcc." and id_estado<>-1 and facturado<>1";}
					if ($_POST["data_desde1"] != 0) { $sqlcc = $sqlcc." AND fecha_prevision>='".cambiarFormatoFechaDMY($_POST["data_desde1"])."'"; }
					if ($_POST["data_fins1"] != 0) { $sqlcc = $sqlcc." AND fecha_prevision<='".cambiarFormatoFechaDMY($_POST["data_fins1"])."'"; }
					if ($_POST["data_desde2"] != 0) { $sqlcc = $sqlcc." AND fecha_prevision>='".cambiarFormatoFechaDMY($_POST["data_desde2"])."'"; }
					if ($_POST["data_fins2"] != 0) { $sqlcc = $sqlcc." AND fecha_prevision<='".cambiarFormatoFechaDMY($_POST["data_fins2"])."'"; }
					if ($_POST["articulo"] != '') { $sqlcc = $sqlcc." AND ((codigo like '%".$_POST["articulo"]."%') or (nombre like '%".$_POST["articulo"]."%'))"; }
					$resultcc = mysql_query(convertSQL($sqlcc));
					$rowcc = mysql_fetch_array($resultcc);
					if ($rowcc){ $ver = 1; } else { $ver = 0; }
				}
				if ($ver == 1) {
					########## FECHAS AVISOS CERCANIA FECHA PREVISION (colores)
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
						$sqlc = "select * from sgm_cuerpo where idfactura=".$row["id"]." and id_estado<>-1 and facturado<>1 order by  fecha_prevision";
						$resultc = mysql_query(convertSQL($sqlc));
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
						$resultc = mysql_query(convertSQL($sqlc));
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
						if ($rowtipos["dias"] == 0) { echo "<td style=\"text-align:center;\"><strong>".cambiarFormatoFechaDMY($row["fecha"])."</strong></td>"; }
							else { 
								if ($fecha_proxima > $date1) {
									$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
									if ($fecha_aviso <  $date1) { echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
									else { echo "<td style=\"text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
								}
								else { echo "<td style=\"background-color:red;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
							}
						echo "<td style=\"text-align:center;\">";
							echo cambiarFormatoFechaDMY($row["fecha_prevision"]);
						echo "</td>";
						echo "<td>".$row["numero_cliente"]."</td>";
						if (strlen($row["nombre"]) > 30) {
							echo "<td>".substr($row["nombre"],0,30)." ...</td>";
						} else {
							echo "<td>".$row["nombre"]."</td>";
						}
						echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=520&id=".$row["id"]."\"><input type=\"Submit\" value=\"Producción\" style=\"width:75px\"></form></td>";
						echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=600&id=".$row["id"]."\"><input type=\"Submit\" value=\"Albaran\" style=\"width:75px\"></form></td>";
						echo "<td><form method=\"post\" action=\"index.php?op=1015&sop=95\">";
							$sqlw = "select count(*) as total from sgm_control_calidad where visible=1 and id_cabezera=".$row["id"];
							$resultw = mysql_query(convertSQL($sqlw));
							$roww = mysql_fetch_array($resultw);
							echo "<input type=\"Submit\" value=\"CC (".$roww["total"].")\" style=\"width:75px\">";
							echo "<input type=\"hidden\" name=\"id_cabezera\" value=\"".$row["id"]."\">";
							echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$row["id_cliente"]."\">";
							echo "<input type=\"hidden\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\">";
						echo "</form></td>";
						echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=511&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><input type=\"Submit\" value=\"Enviar Email\" style=\"width:75px\"></form></td>";
						if ($row["confirmada"] == 0){
							echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=510&ssop=30&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><input type=\"Submit\" value=\"Pendiente\" style=\"width:75px;background-color:red\"></form></td>";
						} else {
							echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=510&ssop=40&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><input type=\"Submit\" value=\"Confirmado\" style=\"width:75px;background-color:#00EC00\"></form></td>";
						}
						if ($row["confirmada_cliente"] == 0){
							echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=510&ssop=10&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><input type=\"Submit\" value=\"Pendiente\" style=\"width:75px;background-color:red\"></form></td>";
						} else {
							echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=510&ssop=20&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><input type=\"Submit\" value=\"Confirmado\" style=\"width:75px;background-color:#00EC00\"></form></td>";
						}
				echo "<td style=\"width:75px;text-align:center;vertical-align:middle;background-color:silver;border: 1px solid black\"><a href=\"index.php?op=950&id=".$row["id"]."\" onclick=\"NewWindow(this.href,'name','700','300','no');return false;\" style=\"color:black\">Notas</a></td>";
					echo "</tr>";
				if ($_GET["filtra"]  == 1){
					$sqlxx = "select count(*) as total from sgm_cuerpo where idfactura=".$row["id"]."";
					if ($_GET["hist"] = 0) { $sqlxx = $sqlxx." and id_estado<>-1 and facturado<>1";}
					if ($_POST["data_desde1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde1"])."'"; }
					if ($_POST["data_fins1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins1"])."'"; }
					if ($_POST["data_desde2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde2"])."'"; }
					if ($_POST["data_fins2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins2"])."'"; }
					if ($_POST["articulo"] != '') { $sqlxx = $sqlxx." AND ((codigo like '%".$_POST["articulo"]."%') or (nombre like '%".$_POST["articulo"]."%'))"; }
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
					if ($rowxx["total"] > 0){
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr style=\"background-color:silver;\">";
							echo "<td>Linea</td>";
							echo "<td>Fecha Prev.</td>";
							echo "<td>Código</td>";
							echo "<td>Nombre</td>";
							echo "<td>Unidades</td>";
						echo "</tr>";
						$sqlxx = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
						if ($_GET["hist"] == 0) { $sqlxx = $sqlxx." and id_estado<>-1 and facturado<>1";}
						if ($_POST["data_desde1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde1"])."'"; }
						if ($_POST["data_fins1"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins1"])."'"; }
						if ($_POST["data_desde2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision>='".cambiarFormatoFechaYMD($_POST["data_desde2"])."'"; }
						if ($_POST["data_fins2"] != 0) { $sqlxx = $sqlxx." AND fecha_prevision<='".cambiarFormatoFechaYMD($_POST["data_fins2"])."'"; }
						if ($_POST["articulo"] != '') { $sqlxx = $sqlxx." AND ((codigo like '%".$_POST["articulo"]."%') or (nombre like '%".$_POST["articulo"]."%'))"; }
						$sqlxx = $sqlxx." order by linea";
						$resultxx = mysql_query(convertSQL($sqlxx));
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
							echo "<td><input type=\"Text\" name=\"linea\" style=\"width:20px\" value=\"".$rowxx["linea"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"width:70px\" value=\"".$rowxx["fecha_prevision"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\" value=\"".$rowxx["codigo"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$rowxx["nombre"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"unidades\" style=\"text-align:right;width:50px\" value=\"".$rowxx["unidades"]."\"></td>";
						echo "</tr>";
						}
						echo "<tr><td>&nbsp;</td></tr>";
					}
				}
			}
		}
		echo "</table></center>";
	}
#Gestió Comandes fi#

#Enviament mail per confirmar dates amb el client
	if ($soption == 511) {
		$sql = "select * from sgm_cartas where visible=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);

		$sqlc = "select * from sgm_cabezera where visible=1 and id=".$_GET["id_fact"];
		$resultc = mysql_query(convertSQL($sqlc));
		$rowc = mysql_fetch_array($resultc);

		$sqle = "select * from sgm_clients where visible=1 and nombre='".$rowc["nombre"]."'";
		$resulte = mysql_query(convertSQL($sqle));
		$rowe = mysql_fetch_array($resulte);

		$destino = $rowe["mail"];
		$asunto = $row["asunto"];
		$mensaje = ver_mail($row["cuerpo"],$_GET["id_fact"]);
		$cabeceras = "From: conchi.rodriguez@multivia.com\n";
		$cabeceras .= "X-Mailer: PHP/" . phpversion();
		$cabeceras .= "MIME-Version: 1.0\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
		if (mail($destino, $asunto, $mensaje, $cabeceras)) { echo "<br>Se ha enviado un mail a : <strong>".$rowe["mail"]."</strong><br>";}

		$sql1 = "insert into sgm_cartas_enviadas (id_user,id_client,id_carta,fecha,id_fact) ";
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$userid;
		$sql1 = $sql1.",".$rowe["id"];
		$sql1 = $sql1.",0";
		$date = getdate(); 
		$fecha = $date["year"]."-".$date["mon"]."-".$date["mday"];
		$sql1 = $sql1.",'".$fecha."'";
		$sql1 = $sql1.",".$rowc["id"];
		$sql1 = $sql1.")";
		mysql_query(convertSQL($sql1));
	}

#Fitxes de producció#
	if ($soption == 520) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
			$result = mysql_query(convertSQL($sql));
			$x = 1;
			while ($row = mysql_fetch_array($result)) {
				$sql = "update sgm_cuerpo set ";
				$sql = $sql."id_estado=".$_POST["id_estado".$x.""];
				$sql = $sql.",fecha_prevision_propia='".cambiarFormatoFechaYMD($_POST["fecha_prevision_propia".$x.""])."'";
				$sql = $sql." WHERE id=".$row["id"]."";
				mysql_query(convertSQL($sql));
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
				}
				$x++;
			}
		}
		if ($ssoption == 2) {
			$sqle = "select * from sgm_cuerpo where id=".$_GET["id_linea"];
			$resulte = mysql_query(convertSQL($sqle));
			$rowe = mysql_fetch_array($resulte);
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."aprovat=1";
			$sql = $sql.",fecha_prevision='".$rowe["fecha_prevision_propia"]."'";
			$sql = $sql." WHERE id=".$_GET["id_linea"]."";
			mysql_query(convertSQL($sql));
			contaAprovats($_GET["id_linea"],$_GET["id"]);
		}
		if ($ssoption == 3) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."aprovat=0";
			$sql = $sql." WHERE id=".$_GET["id_linea"]."";
			mysql_query(convertSQL($sql));
			contaAprovats($_GET["id_linea"],$_GET["id"]);
		}
		$sql = "select * from sgm_cabezera where id=".$_GET["id"]." ORDER BY id";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		echo "<table><tr><td style=\"width:400px;vertical-align:top;\">";
			echo "<table>";
			echo "<tr><td><strong>Número</strong></td><td>".$row["numero"]."</td></tr>";
			echo "<tr><td>Ref. Cliente</td><td>".$row["numero_cliente"]."</td></tr>";
			echo "<tr><td><strong>Fecha</strong></td><td>".cambiarFormatoFechaDMY($row["fecha"])."</td></tr>";
			echo "<tr><td><strong>Fecha Previsión</strong></td><td>".cambiarFormatoFechaDMY($row["fecha_prevision"])."</td></tr>";
			echo "<tr><td>Nombre</td><td><a href=\"index.php?op=1011&sop=4&id=".$row["id_cliente"]."&origen=1003\">".$row["nombre"]."</a></td></tr>";
			echo "<tr><td>E-mail</td><td>".$row["mail"]."</td></tr>";
			echo "<tr><td>Telefono</td><td>".$row["telefono"]."</td></tr>";
			echo "</table>";
		echo "</td><td style=\"width:200px;vertical-align:top;\">";
			echo "<a href=\"index.php?op=1016&sop=700&id=".$_GET["id"]."\">LISTADO MATERIALES</a>";
			echo "<br><br>";
		echo "</td>";
		echo "</td><td style=\"width:200px;vertical-align:top;\">";
			echo "<form method=\"post\" action=\"".$urloriginal."/mgestion/gestion-control_produccion_print_lista_materiales.php?id=".$_GET["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
			echo "<input value=\"Imprimir Lista de Materiales\" type=\"Submit\" style=\"width:200px\">";
			echo "</form>";
		echo "</td>";
		echo "<td style=\"width:200px;vertical-align:top;\">";
			echo "<table><tr>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#C0C0C0;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=522&id=".$_GET["id"]."\" style=\"color:black;\">Imprimir las OT</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "</td>";
		echo "<td style=\"width:200px;vertical-align:top;\">";
			echo "<table><tr>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#C0C0C0;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=521&id=".$_GET["id"]."\" style=\"color:black;\">E-mail enviados</a>";
				echo "</td>";
			echo "</tr></table>";
		echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table cellspacing=\"0\">";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
		$result = mysql_query(convertSQL($sql));
		$x = 1;
		echo "<form method=\"post\" action=\"index.php?op=1016&sop=520&ssop=1&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
		echo "<tr>";
			echo "<td></td>";
			echo "<td><input type=\"Submit\" value=\"Guardar\" style=\"width:125px\"></td>";
			echo "<td><em>Fecha Prev. Propia</em></td>";
			echo "<td><em>Fecha Prevision</em></td>";
			echo "<td><em>Código</em></td>";
			echo "<td><em>Nombre</em></td>";
			echo "<td><em>Unidades</em></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><center>M</center></td>";
			echo "<td><center>A</center></td>";
		echo "</tr>";
		while ($row = mysql_fetch_array($result)) {
			$fechahoy = getdate();
			$hoy = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"], $fechahoy["year"]));
			$color = "#FFFFFF";
			$a = date("Y", strtotime($row["fecha_prevision"]));
			$m = date("m", strtotime($row["fecha_prevision"]));
			$d = date("d", strtotime($row["fecha_prevision"]));
			$fecha_prevision2 = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$fecha_aviso2 = date("Y-m-d", mktime(0,0,0,$m ,$d-15, $a));
			if ($fecha_prevision2 <= $hoy) {
				$color = "#FF1515";
			} else {
				if ($fecha_aviso2 < $hoy) {
					$color = "#FFA500";
				} else {
					$color = "00EC00";
				}
			}
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
				if ($fecha_entrega <= $hoy) {
					$color = "#FF1515";
				} else {
					if ($fecha_aviso < $hoy) {
						$color = "#FFA500";
					} else {
						$color = "00EC00";
					}
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
				echo "<td><input type=\"Text\" name=\"fecha_prevision_propia".$x."\" style=\";width:75px\" value=\"".cambiarFormatoFechaDMY($row["fecha_prevision_propia"])."\"></td>";
				echo "<td style=\"background-color : ".$color.";width:75px\">".cambiarFormatoFechaDMY($row["fecha_prevision"])."</td>";
				echo "<td style=\"width:100px\" >".$row["codigo"]."</td>";
				echo "<td style=\"width:250px\" >".$row["nombre"]."</td>";
				echo "<td style=\"text-align:right;width:50px\" >".$row["unidades"]."</td>";
				echo "<td>&nbsp;<a href=\"index.php?op=1016&sop=540&id=".$row["id"]."\"><strong>Producción</strong></a></td>";
				echo "<td>&nbsp;<a href=\"index.php?op=1016&sop=530&id=".$row["id"]."\"><strong>OT</strong></a></td>";
					$sqlxx = "select count(*) as total from sgm_cuerpo where id_cuerpo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
				echo "<td>&nbsp;<a href=\"index.php?op=1016&sop=560&id=".$row["id"]."\"><strong>".$rowxx["total"]."</strong></a></td>";
					$sqlxx = "select count(*) as total from sgm_cuerpo_archivos where id_cuerpo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
				echo "<td>&nbsp;<a href=\"index.php?op=1016&sop=550&id=".$row["id"]."\"><strong>".$rowxx["total"]."</strong></a></td>";
				if ($row["aprovat"] == 0){
					echo "<td style=\"width:50px;height:10px;text-align:center;vertical-align:middle;background-color:silver;border:1px solid black\"><a href=\"index.php?op=1016&sop=520&ssop=2&id=".$_GET["id"]."&id_linea=".$row["id"]."\" style=\"color:black;\">Pendiente</a></td>";
				} else {
					echo "<td style=\"width:50px;height:10px;text-align:center;vertical-align:middle;background-color:silver;border:1px solid black\"><a href=\"index.php?op=1016&sop=520&ssop=3&id=".$_GET["id"]."&id_linea=".$row["id"]."\" style=\"color:black;\">Confirmado</a></td>";
				}
		echo "</tr>";
		$x++;
		}
		echo "<tr>";
			echo "<td></td>";
			echo "<td><input type=\"Submit\" value=\"Guardar\" style=\"width:125px\"></td>";
			echo "<td><em>Fecha Prev. Propia</em></td>";
			echo "<td><em>Fecha Prevision</em></td>";
			echo "<td><em>Código</em></td>";
			echo "<td><em>Nombre</em></td>";
			echo "<td><em>Unidades</em></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><center>M</center></td>";
			echo "<td><center>A</center></td>";
		echo "</tr>";
		echo "</form>";
		echo "</table></center>";
		echo "<br>";
		echo "<br>M - <em>Lineas de <strong>M</strong>aterial</em>";
		echo "<br>A - <em>Lineas de <strong>A</strong>rchivos</em>";
		
	}

	if ($soption == 521) {
		echo "<strong>E-mails enviados :</strong><br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1016&sop=520&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; Volver</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center><table cellspacing=\"0\" style=\"width:200px;\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>Usuario</td>";
				echo "<td>Fecha</td>";
			echo "</tr>";
			$sqlc = "select * from sgm_cabezera where visible=1 and id=".$_GET["id"];
			$resultc = mysql_query(convertSQL($sqlc));
			$rowc = mysql_fetch_array($resultc);
	
			$sqle = "select * from sgm_clients where visible=1 and nombre='".$rowc["nombre"]."'";
			$resulte = mysql_query(convertSQL($sqle));
			$rowe = mysql_fetch_array($resulte);

			$sql = "select * from sgm_cartas_enviadas where id_fact=".$_GET["id"]." order by fecha";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlu = "select * from sgm_users where id=".$row["id_user"];
				$resultu = mysql_query(convertSQL($sqlu));
				$rowu = mysql_fetch_array($resultu);
				echo "<tr>";
					echo "<td>".$rowu["usuario"]."</td>";
					echo "<td>".$row["fecha"]."</td>";
				echo "</tr>";
			}
		echo "</table></center><br>";
	}

	if ($soption == 522) {
		echo "<strong>Imprimir OT :</strong><br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1016&sop=520&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; Volver</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center><table cellspacing=\"0\" style=\"width:600px;\">";
			echo "<tr><td></td><td></td><td><td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:silver;border:1px solid black\"><a href=\"javascript:marcar()\" style=\"color:black;\">Marcar Todos</a></td>";
			echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:silver;border:1px solid black\"><a href=\"javascript:desmarcar()\" style=\"color:black;\">Desmarcar Todos</a></td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>Fecha Prevision</td>";
				echo "<td>Código</td>";
				echo "<td>Nombre</td>";
				echo "<td>Unidades</td>";
				echo "<td style=\"text-align: center;\">Imprimir</td>";
			echo "</tr>";
			echo "<form name=\"formulari\" method=\"post\" action=\"".$urloriginal."/mgestion/gestion-control_produccion_print_orden_seguimiento_todas.php?id=".$_GET["id"]."\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
			$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"width:100px\">".cambiarFormatoFechaDMY($row["fecha_prevision"])."</td>";
					echo "<td style=\"width:100px\" >".$row["codigo"]."</td>";
					echo "<td style=\"width:250px\" >".$row["nombre"]."</td>";
					echo "<td style=\"text-align:right;width:50px\" >".$row["unidades"]."</td>";
					echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" id=\"chequea\" name=\"ot[]\" value=\"".$row["id"]."\"";
				echo "</tr>";
			}
			echo "<tr><td></td><td></td><td><input value=\"Imprimir Lista de Materiales\" type=\"Submit\" style=\"width:200px\"></td></tr>";
			echo "</form>";
		echo "</table></center><br>";
	}

	if (($soption >= 530) and ($soption <= 560)) {
		$sqlp = "select * from sgm_cuerpo where id=".$_GET["id"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);
		$sqlf = "select * from sgm_cabezera where id=".$rowp["idfactura"];
		$resultf = mysql_query(convertSQL($sqlf));
		$rowf = mysql_fetch_array($resultf);
		echo "<table style=\"width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr><td style=\"width:50%;vertical-align : top;text-align:left;\">";
				echo "<strong>Histórico de pieza : </strong>".$rowp["nombre"];
				echo "<br><strong>Unidades : </strong>".$rowp["unidades"];
				echo "<br><a href=\"index.php?op=1016&sop=520&id=".$rowf["id"]."\">&raquo; Volver al pedido </a>";
				echo "<br>";
				echo "<br><a href=\"index.php?op=1016&sop=540&id=".$_GET["id"]."\">&raquo; Procesos/Incidencias </a>";
				echo "<br><a href=\"index.php?op=1016&sop=530&id=".$_GET["id"]."\">&raquo; Orden de seguimiento</a>";
				echo "<br><a href=\"index.php?op=1016&sop=560&id=".$_GET["id"]."\">&raquo; Materiales</a>";
				echo "<br><a href=\"index.php?op=1016&sop=550&id=".$_GET["id"]."\">&raquo; Gestión archivos</a>";
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

	if ($soption == 530) {
		if ($ssoption == 1) {
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
		}
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
		echo "<a href=\"".$urloriginal."/mgestion/gestion-control_produccion_print_orden_seguimiento.php?id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px;\"></a>";
		echo "<br><br>";
		echo "<form method=\"post\" action=\"index.php?op=1016&sop=530&ssop=1&id=".$_GET["id"]."\">";
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

	if ($soption == 540) {
		if ($ssoption == 1) {
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
		}
		if ($ssoption == 2) {
			$sql = "delete from sgm_cuerpo_incidencias WHERE id=".$_GET["id_incidencia"];
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_cuerpo_estados_historico set ";
			$sql = $sql."id_estado=".$_POST["id_estado"];
			$sql = $sql.",fecha='".$_POST["fecha"]."'";
			$sql = $sql.",hora='".$_POST["hora"]."'";
			$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 4) {
			$sql = "delete from sgm_cuerpo_estados_historico WHERE id=".$_GET["id_cuerpo"];
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 5) {
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
		}
		$sqlp = "select * from sgm_cuerpo where id=".$_GET["id"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);
		echo "<table><tr><td style=\"vertical-align:top;width:50%\">";
			if ($rowp["bloqueado"] == 0) { 
				echo "<table cellspacing=\"0\">";
					echo "<form method=\"post\" action=\"index.php?op=1016&sop=540&ssop=1&id=".$_GET["id"]."\">";
						$date = getdate();
						echo "<td></td>";
						echo "<td><input style=\"width:75px\" name=\"fecha\" type=\"Text\" value=\"".cambiarFormatoFechaDMY(date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"])))."\"></td>";
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
							echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=542&id=".$_GET["id"]."&id_incidencia=".$rowi["id"]."\"><input type=\"Submit\" value=\"E\"></form></td>";
							if ($rowi["cerrada"] == 0) { echo "<td style=\"color:red;width:230px\">Incidencia-Abierta (Prev. : ".$rowi["fecha_prevision"].")</td>"; }
							if ($rowi["cerrada"] == 1) { echo "<td style=\"color:green;width:230px\">Incidencia-Cerrada</td>"; }
							echo "<form method=\"post\" action=\"index.php?op=1016&sop=540&ssop=3&id=".$_GET["id"]."&id_incidencia=".$rowi["id"]."\">";
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
					echo "<td><form method=\"post\" action=\"index.php?op=1016&sop=541&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\"><input type=\"Submit\" value=\"E\"></form></td>";
					echo "<form method=\"post\" action=\"index.php?op=1016&sop=540&ssop=3&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
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
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=540&ssop=5&id=".$_GET["id"]."\">";
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

	if ($soption == 541) {
		echo "<br><br>¿Seguro que desea eliminar este proceso?";
		echo "<br><br><a href=\"index.php?op=1016&sop=540&ssop=4&id=".$_GET["id"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">[ SI ]</a><a href=\"index.php?op=1016&sop=540&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if ($soption == 542) {
		echo "<br><br>¿Seguro que desea eliminar esta incidencia?";
		echo "<br><br><a href=\"index.php?op=1016&sop=540&ssop=2&id=".$_GET["id"]."&id_incidencia=".$_GET["id_incidencia"]."\">[ SI ]</a><a href=\"index.php?op=1016&sop=540&id=".$_GET["id"]."\">[ NO ]</a>";
	}
#Fitxes de producció fi#

#Archius OT#
	if ($soption == 550) {
		if ($ssoption == 3) {
			$sql = "delete from sgm_cuerpo_archivos WHERE id=".$_GET["id_archivo"];
			mysql_query(convertSQL($sql));
		}
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
								echo "<td>&nbsp;<a href=\"index.php?op=1016&sop=552&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\">[ Eliminar ]</a></td></tr>";
							}
						}
						echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>Formulario de envio de archivos :</strong><br><br>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1016&sop=551\" method=\"post\">";
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

	if ($soption == 551) {
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
					echo "<br><br><a href=\"index.php?op=1016&sop=550&id=".$id_cuerpo."\">[ Volver ]</a>";
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

	if ($soption == 552) {
		echo "<center>";
		echo "¿Seguro que desea eliminar este archivo?";
		echo "<br><br><a href=\"index.php?op=1016&sop=550&ssop=3&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."\">[ SI ]</a><a href=\"index.php?op=1016&sop=550&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}
#Archius OT fi#

#materiales OT#
	if ($soption == 560) {
		if ($ssoption == 1) {
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
		}
		if ($ssoption == 2) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."codigo='".$_POST["codigo"]."'";
			$sql = $sql.",nombre='".$_POST["nombre"]."'";
			$sql = $sql.",unidades=".$_POST["unidades"]."";
			$sql = $sql.",pvp=".$_POST["pvp"]."";
			$sql = $sql.",total=".($_POST["pvp"]*$_POST["unidades"])."";
			$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_cuerpo WHERE id=".$_GET["id_cuerpo"];
			mysql_query(convertSQL($sql));
		}
		echo "<table>";
			echo "<tr><td></td><td style=\"text-align:center;\"><em>Código</em></td><td style=\"text-align:center;\"><em>Nombre</em></td><td style=\"text-align:center;\"><em>Unidades</em></td>";
			echo "<td style=\"text-align:center;\"><em>PVP</em></td><td style=\"text-align:center;\"><em>Total</em></td><td></td>";
			echo "</tr>";
			echo "<tr>";
				$sqlp = "select * from sgm_cuerpo where id=".$_GET["id"];
				$resultp = mysql_query(convertSQL($sqlp));
				$rowp = mysql_fetch_array($resultp);
				echo "<td><a href=\"#\" onclick=\"formulario.codigo.value='".$rowp["codigo"]."'\">[CC]</a></td>";
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=560&ssop=1&id=".$_GET["id"]."\" name=\"formulario\">";
				echo "<td><input name=\"codigo\" type=\"Text\" style=\"width:90px\"></td>";
				echo "<td><input name=\"nombre\" type=\"Text\" style=\"width:250px\"></td>";
				echo "<td><input name=\"unidades\" type=\"Text\" style=\"width:50px\" value=\"0.00\"></td>";
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
				echo "<td><a href=\"index.php?op=1016&sop=561&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">[E]</a></td>";
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=560&ssop=2&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
				echo "<td><input name=\"codigo\" type=\"Text\" style=\"width:90px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input name=\"nombre\" type=\"Text\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input name=\"unidades\" type=\"Text\" style=\"width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td><input name=\"pvp\" type=\"Text\" style=\"width:50px\" value=\"".$row["pvp"]."\"></td>";
				echo "<td><input name=\"pvp\" type=\"Text\" style=\"width:50px\" value=\"".$row["total"]."\" disabled></td>";
				echo "<td><input value=\"Modificar\" type=\"Submit\" style=\"width:75px\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table><br><br>";
	}

	if ($soption == 561) {
		echo "<center>";
		echo "¿Seguro que desea eliminar este material?";
		echo "<br><br><a href=\"index.php?op=1016&sop=560&ssop=3&id=".$_GET["id"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">[ SI ]</a><a href=\"index.php?op=1016&sop=560&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}
#materiales OT fi#

#Albaran OT#
	if ($soption == 600) {
		if ($ssoption == 3) {
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
			$sqlnn = "select * from sgm_cuerpo where facturado=0 and idfactura=".$_GET["id"]." order by fecha_prevision desc";
			$resultnn = mysql_query(convertSQL($sqlnn));
			$rownn = mysql_fetch_array($resultnn);
			$sqlz = "update sgm_cabezera set ";
			$sqlz = $sqlz."fecha_prevision='".$rownn["fecha_prevision"]."'";
			$sqlz = $sqlz." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sqlz));
		}
		if ($ssoption == 2) {
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
		}
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
					echo "<form method=\"post\" action=\"index.php?op=1016&sop=301&id=".$_GET["id"]."&fecha=".$row["fecha"]."\">";
					echo "<input value=\"Generar Albaran Completo\" type=\"Submit\" style=\"width:200px\">";
					echo "</form>";
				}
		echo "</td></tr></table>";
		echo "<br><br>";
		echo "<table cellspacing=\"0\">";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." and facturado=0 order by id";
		$result = mysql_query(convertSQL($sql));
		$x = 1;
		echo "<form method=\"post\" action=\"index.php?op=1016&sop=600&ssop=3&id=".$_GET["id"]."\">";
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

	if ($soption == 301) {
		echo "<center>";
			echo "Selecciona la fecha para el albaran :";
			if ($ssoption == 0) { echo "<form method=\"post\" action=\"index.php?op=1016&sop=600&ssop=2&id=".$_GET["id"]."\">"; }
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
#Albaran OT fi#

#Materials Pendents#
	if ($soption == 700) {
		if ($ssoption == 1) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."idfactura=".$_POST["idfactura"]."";
			$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
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
		}
		echo "<br><strong>Materiales Pendientes : </strong><br><br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\">Ped. Cliente</td>";
				echo "<td style=\"text-align:center;\">Código</td>";
				echo "<td style=\"text-align:center;\">Material</td>";
				echo "<td style=\"text-align:center;\">Unidades</td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\">Ped. Proveedor</td><td></td>";
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
				$roworigen = mysql_fetch_array($resultorigen);
				$sqlfac = "select * from sgm_cabezera where id=".$roworigen["idfactura"];
				$resultfac = mysql_query(convertSQL($sqlfac));
				$rowfac = mysql_fetch_array($resultfac);
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=520&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
				echo "<td><input value=\"Ver\" type=\"Submit\" style=\"width:30px\"></td>";
				echo "</form>";
				echo "<form method=\"post\" action=\"index.php?op=1016&sop=700&ssop=2&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
				echo "<td>&nbsp;<input type=\"Text\" style=\"width:50px\" value=\"".$rowfac["numero"]."\" disabled></td>";
				echo "<td>&nbsp;<input name=\"codigo\" type=\"Text\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td>&nbsp;<input name=\"nombre\" type=\"Text\" style=\"width:250px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td>&nbsp;<input name=\"unidades\" type=\"Text\" style=\"width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td>&nbsp;<input value=\"Modificar\" type=\"Submit\" style=\"width:55px\"></td>";
				echo "</form>";
				if ($row["idfactura"] == 0) {
					echo "<form method=\"post\" action=\"index.php?op=1016&sop=700&ssop=1&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
						echo "<td>&nbsp;<select name=\"idfactura\" style=\"width:100px\">";
							echo "<option value=\"0\">Pendiente</option>";
							$sqlf = "select * from sgm_cabezera where tipo=4 and cerrada=0 and visible=1";
							$resultf = mysql_query(convertSQL($sqlf));
							while ($rowf = mysql_fetch_array($resultf)) {
								echo "<option value=\"".$rowf["id"]."\">".$rowf["numero"]."-".$rowf["nombre"]."</option>";
							}
						echo "</select></td>";
						echo "<td>&nbsp;<input value=\"Añadir\" type=\"Submit\" style=\"width:75px\"></td>";
					echo "</form>";
				}
				if ($row["idfactura"] <> 0) {
					$sqlf = "select * from sgm_cabezera where id=".$row["idfactura"];
					$resultf = mysql_query(convertSQL($sqlf));
					$rowf = mysql_fetch_array($resultf);
					if ($rowf["cerrada"] == 0) {
						echo "<form method=\"post\" action=\"index.php?op=1016&sop=700&ssop=1&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
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
		echo "</table></center>";
	}
#Materials Pendents fi#

#Llistats d'estats OT#
	if ($soption == 710) {
		echo "<strong>Listados de estados OT :</strong><br><br>";
		echo "<center><table>";
			echo "<tr>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=710&ssop=0\" style=\"color:white;\">Finalizadas</a>";
				echo "</td>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=710&ssop=1\" style=\"color:white;\">Pendientes de finalizar</a>";
				echo "</td>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=710&ssop=2\" style=\"color:white;\">Pendientes valorar autocontrol</a>";
				echo "</td>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=710&ssop=3\" style=\"color:white;\">Pendientes valorar horas</a>";
				echo "</td>";
				echo "<td style=\"width:175px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1016&sop=710&ssop=4\" style=\"color:white;\">Pendientes valorar cotas</a>";
				echo "</td>";
				if ($ssoption == 0) { $sql = "select * from sgm_cuerpo_orden_seguimiento where finalizado=1"; }
				if ($ssoption == 1) { $sql = "select * from sgm_cuerpo_orden_seguimiento where finalizado=0"; }
				if ($ssoption == 2) { $sql = "select * from sgm_cuerpo_orden_seguimiento where val_autocontrol=0"; }
				if ($ssoption == 3) { $sql = "select * from sgm_cuerpo_orden_seguimiento where val_horas=0"; }
				if ($ssoption == 4) { $sql = "select * from sgm_cuerpo_orden_seguimiento where val_cotas=0"; }
				$result = mysql_query(convertSQL($sql));
			echo "</tr>";
		echo "</table></center>";
		echo "<br>";
		echo "<table>";
		echo "<tr><td style=\"width:100px;text-align:center;\">OT</td><td style=\"width:120px;text-align:center;\">Visto Bueno</td><td style=\"width:120px;text-align:center;\">Validación Autocontrol</td><td style=\"width:120px;text-align:center;\">Validación Horas</td><td style=\"width:120px;text-align:center;\">Validación Cotas</td></tr>";
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td><center><a href=\"index.php?op=1016&sop=530&id=".$row["id_cuerpo"]."\">OT : ".$row["id"]."</a></center></td>";
				if ($row["finalizado"] == 1) { echo "<td><center><strong>SI</strong></center></td>"; } else { echo "<td><center>NO</center></td>"; }
				if ($row["val_autocontrol"] == 1) { echo "<td><center><strong>Completo</strong></center></td>"; } else { echo "<td><center>Incompleto</center></td>"; }
				if ($row["val_horas"] == 1) { echo "<td><center><strong>Completo</strong></center></td>"; } else { echo "<td><center>Incompleto</center></td>"; }
				if ($row["val_cotas"] == 1) { echo "<td><center><strong>Completo</strong></center></td>"; } else { echo "<td><center>Incompleto</center></td>"; }
			echo "</tr>";
		}
		echo "</table>";
	}
#Llistats d'estats OT fi#

#Llistats d'estats producció#
	if (($soption >= 720) and ($soption <= 725)) {
		echo "<table style=\"width:100%\"><tr><td style=\"vertical-align:top;width:50%\">";
		echo "<strong>Listados de estados internos :</strong><br>";
			echo "<br><a href=\"index.php?op=1016&sop=720&id=0\">Sin Iniciar</a>";
			$sql = "select * from sgm_cuerpo_estados where externo=0 order by estado";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<br><a href=\"index.php?op=1016&sop=720&id=".$row["id"]."\">".$row["estado"]."</a>";
			}
		echo "</td><td style=\"vertical-align:top;width:50%\">";
		echo "<strong>Listados de estados externos :</strong><br>";
			$sql = "select * from sgm_cuerpo_estados where externo=1 order by estado";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<br><a href=\"index.php?op=1016&sop=720&id=".$row["id"]."\">".$row["estado"]."</a>";
			}
		echo "</td></tr></table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 720) {
		if ($soption == 1) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."bloqueado=0";
			$sql = $sql." WHERE id=".$_GET["id_cuerpo"];
			mysql_query(convertSQL($sql));
		}
		if ($soption == 2) {
			traspasar_cuerpo($_GET["id_cuerpo"],$_POST["idfactura"]);
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."bloqueado=1";
			$sql = $sql." WHERE id=".$_GET["id_cuerpo"]."";
			mysql_query(convertSQL($sql));
		}
		if ($soption == 3) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."prioridad=".$_POST["prioridad"];
			$sql = $sql." WHERE id=".$_GET["id_cuerpo"];
			mysql_query(convertSQL($sql));
		}
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td>Estado</td>";
				echo "<td></td>";
				echo "<td>Fecha Prevision</td>";
				echo "<td>Nº Pedido</td>";
				echo "<td>Nº Pedido Cli.</td>";
				echo "<td>Código</td>";
				echo "<td>Nombre</td>";
				echo "<td>Unidades</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		if ($_GET["id"] == 0){
			$estado = "Sin Iniciar";
		} else {
			$sqlestado = "select * from sgm_cuerpo_estados where id=".$_GET["id"];
			$resultestado = mysql_query(convertSQL($sqlestado));
			$rowestado = mysql_fetch_array($resultestado);
			$estado = $rowestado["estado"];
		}
		echo "<strong style=\"font-size:12px\">ESTADO DE PRODUCCIÓN : ".$estado."</strong><br><br>";
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
			echo "<form method=\"post\" action=\"index.php?op=1016&sop=720&ssop=3&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
 				echo "<td><input type=\"Text\" style=\"width:50px\" name=\"prioridad\" value=\"".$row["prioridad"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"Ok\"></td>";
			echo "</form>";
				echo "<td><input type=\"Text\" name=\"fecha_prevision\" style=\"background-color : ".$color.";width:75px\" value=\"".cambiarFormatoFechaDMY($row["fecha_prevision"])."\"></td>";
				$sqlc = "select * from sgm_cabezera where id=".$row["idfactura"];
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<td><input type=\"Text\" style=\"width:50px\" value=\"".$rowc["numero"]."\" disabled></td>";
				echo "<td><input type=\"Text\" style=\"width:75px\" value=\"".$row["codigo"]."\" disabled></td>";
				echo "<td><input type=\"Text\" style=\"width:200px\" value=\"".$row["nombre"]."\" disabled></td>";
				echo "<td><input type=\"Text\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\" disabled></td>";
				if ($rowestado["externo"] == 1) {
					if ($row["bloqueado"] == 0) {
						echo "<form method=\"post\" action=\"index.php?op=1016&sop=720&ssop=2&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
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
						echo "<form method=\"post\" action=\"index.php?op=1016&sop=721&id=".$_GET["id"]."&id_cuerpo=".$row["id"]."\">";
							echo "<td><input value=\"Desbloqueo\" type=\"Submit\" style=\"width:100px\"></td>";
						echo "</form>";
					}
				}
				if ($row["bloqueado"] == 1) { echo "<td><a href=\"index.php?op=1003&sop=22&id=".$rowc["id"]."\">[ ".$rowc["numero"]." ]</a></td>"; }
				echo "<td><a href=\"index.php?op=1016&sop=540&id=".$row["id"]."\">[ Ver ]</a></td>";
			echo "</tr>";
			}
		}
		echo "</table></center>";
		echo "<br><br>";
	}

	if ($soption == 721) {
		echo "<br><br>¿Seguro que desea desbloquear este proceso?";
		echo "<br><br><a href=\"index.php?op=1016&sop=720&ssop=1&id=".$_GET["id"]."&id_cuerpo=".$_GET["id_cuerpo"]."\">[ SI ]</a><a href=\"index.php?op=1016&sop=720&id=".$_GET["id"]."\">[ NO ]</a>";
	}
#Llistats d'estats producció fi#

	echo "</td></tr></table><br>";
}
?>
