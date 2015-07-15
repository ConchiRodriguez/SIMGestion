<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }

if (($option == 1030) AND ($autorizado == true)) {
	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<strong>Gestión Deportiva 1.0</strong>";
			echo "<br><br>";
			echo "<table>";
				echo "<tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1030&sop=1\" style=\"color:white;\">Equipos</a>";
					echo "</td>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1030&sop=10\" style=\"color:white;\">Fichas</a>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";




	if ($soption == 10) {
		echo "<strong>Gestión de fixas deportivas : </strong><br><br>";
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1030&sop=10&ssop=100\" style=\"color:white;\">Nueva ficha</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1030&sop=10\" style=\"color:white;\">Ver todas</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";

		if ($ssoption == 100) {
		}
		if ($ssoption == 101) {
			$sql = "insert into sgm_dep_equipos (codigo,nombre,id_seccion,id_temporada) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["codigo"]."'";
			$sql = $sql.",'".$_POST["nombre"]."'";
			$sql = $sql.",".$_POST["id_seccion"];
			$sql = $sql.",".$_GET["id_temporada"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
	}








	if ($soption == 1) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_dep_equipos (codigo,nombre,id_seccion,id_temporada) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["codigo"]."'";
			$sql = $sql.",'".$_POST["nombre"]."'";
			$sql = $sql.",".$_POST["id_seccion"];
			$sql = $sql.",".$_GET["id_temporada"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_dep_equipos set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",codigo='".$_POST["codigo"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:white;border:1px solid black\">";
					echo "<a href=\"index.php?op=1030&sop=3\" style=\"color:#4B53AF\">Secciones</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:white;border:1px solid black\">";
					echo "<a href=\"index.php?op=1030&sop=2\" style=\"color:#4B53AF\">Nueva temporada</a>";
				echo "</td>";
				$sql = "select * from sgm_dep_temporada where visible=1 order by nombre";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1030&sop=1&id_temporada=".$row["id"]."\" style=\"color:white;\">".$row["nombre"]."</a>";
					echo "</td>";
				}
			echo "</tr>";
		echo "</table>";

		if ($_GET["id_temporada"] != "") {
			$sql = "select * from sgm_dep_secciones where visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<br><table><tr><td style=\"width:400px;height:15px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black;color:white\">".$row["nombre"]."</td></tr></table>";
				echo "<table>";
					echo "<form action=\"index.php?op=1030&sop=1&ssop=1&id_temporada=".$_GET["id_temporada"]."\" method=\"post\">";
					echo "<tr>";
						echo "<td></td>";
						echo "<td style=\text-align:center;\">Código</td>";
						echo "<td style=\text-align:center;\">Equipo</td>";
						echo "<td></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td></td>";
						echo "<input type=\"hidden\" name=\"id_seccion\" value=\"".$row["id"]."\">";
						echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:50px\" name=\"codigo\"></td>";
						echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
						echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Nuevo\"></td>";
					echo "</tr>";
					echo "</form>";
					$sqle = "select * from sgm_dep_equipos where visible=1 and id_seccion=".$row["id"]." and id_temporada=".$_GET["id_temporada"]." order by codigo,nombre";
					$resulte = mysql_query(convert_sql($sqle));
					while ($rowe = mysql_fetch_array($resulte)) {
						echo "<tr>";
							echo "<form action=\"index.php?op=1030&sop=1&ssop=3&id_temporada=".$_GET["id_temporada"]."&id=".$row["id"]."\" method=\"post\">";
							echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Eliminar\"></td>";
							echo "</form>";
							echo "<form action=\"index.php?op=1030&sop=1&ssop=2&id_temporada=".$_GET["id_temporada"]."&id=".$rowe["id"]."\" method=\"post\">";
							echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:50px\" name=\"codigo\" value=\"".$rowe["codigo"]."\"></td>";
							echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\" value=\"".$rowe["nombre"]."\"></td>";
							echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Cambiar\"></td>";
							echo "</form>";
							echo "<td><a href=\"index.php?op=1030&sop=4&id_temporada=".$_GET["id_temporada"]."&id_equipo=".$rowe["id"]."\">[Rivales]</a></td>";
						echo "</tr>";
					}
				echo "</table>";
			}
		}
	}


	if ($soption == 4) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_dep_equipos_rivales (nombre,id_equipo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",".$_GET["id_equipo"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		if ($ssoption == 3) {
			echo "<center>¿Seguro que desea eliminar este equipo? Se eliminaran todos partidos y resultados.";
			echo "<br><br><a href=\"index.php?op=1030&sop=3&ssop=4&id_temporada=".$_GET["id_temporada"]."&id_equipo=".$_GET["id_equipo"]."&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1030&sop=4&id_temporada=".$_GET["id_temporada"]."&id_equipo=".$_GET["id_equipo"]."\">[ NO ]</a></center><br>";
		}
		if ($ssoption == 4) {
			$sql = "update sgm_dep_equipos_rivales set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<table>";
			echo "<form action=\"index.php?op=1030&sop=4&ssop=1&id_temporada=".$_GET["id_temporada"]."&id_equipo=".$_GET["id_equipo"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Nuevo\"></td>";
			echo "</tr>";
			echo "</form>";
			$sqle = "select * from sgm_dep_equipos_rivales where id_equipo=".$_GET["id_equipo"]." and visible=1 order by nombre";
			$resulte = mysql_query(convert_sql($sqle));
			while ($rowe = mysql_fetch_array($resulte)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1030&sop=1&ssop=4&id_temporada=".$_GET["id_temporada"]."&id_equipo=".$_GET["id_equipo"]."\" method=\"post\">";
					echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Eliminar\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1030&sop=4&ssop=2&id_temporada=".$_GET["id_temporada"]."&id_equipo=".$_GET["id_equipo"]."\" method=\"post\">";
					echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\" value=\"".$rowe["nombre"]."\"></td>";
					echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Cambiar\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

















	if ($soption == 2) {
		echo "<strong>Temporadas : </strong><br><br>";
		if ($ssoption == 1) {
			$sql = "insert into sgm_dep_temporada (nombre,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",'".$_POST["descripcion"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_dep_temporada set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			echo "<center>¿Seguro que desea eliminar esta temporada? Se eliminaran todos los equipos y resultados.";
			echo "<br><br><a href=\"index.php?op=1030&sop=2&ssop=4&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1030&sop=2\">[ NO ]</a></center><br>";
		}
		if ($ssoption == 4) {
			$sql = "update sgm_dep_temporada set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<table>";
			echo "<form action=\"index.php?op=1030&sop=2&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><textarea style=\"width:400px\" name=\"descripcion\" rows=\"2\"></textarea></td>";
				echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:150px\" value=\"Nueva\"></td>";
			echo "</tr>";
			echo "</form>";
			$sql = "select * from sgm_dep_temporada where visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1030&sop=2&ssop=3&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Eliminar\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1030&sop=2&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\" value=\"".$row["nombre"]."\"></td>";
					echo "<td><textarea style=\"width:400px\" name=\"descripcion\" rows=\"2\">".$row["descripcion"]."</textarea></td>";
					echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:150px\" value=\"Cambiar\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}
	
	if ($soption == 3) {
		echo "<strong>Secciones de la entidad : </strong><br><br>";
		if ($ssoption == 1) {
			$sql = "insert into sgm_dep_secciones (nombre,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",'".$_POST["descripcion"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_dep_secciones set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			echo "<center>¿Seguro que desea eliminar esta sección? Se eliminaran todos los equipos y resultados de todas las temporadas.";
			echo "<br><br><a href=\"index.php?op=1030&sop=3&ssop=4&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1030&sop=3\">[ NO ]</a></center><br>";
		}
		if ($ssoption == 4) {
			$sql = "update sgm_dep_secciones set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<table>";
			echo "<form action=\"index.php?op=1030&sop=3&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><textarea style=\"width:400px\" name=\"descripcion\" rows=\"2\"></textarea></td>";
				echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:150px\" value=\"Nueva\"></td>";
			echo "</tr>";
			echo "</form>";
			$sql = "select * from sgm_dep_secciones where visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1030&sop=3&ssop=3&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:50px\" value=\"Eliminar\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1030&sop=3&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"vertical-align:top\"><input type=\"text\" style=\"width:150px\" name=\"nombre\" value=\"".$row["nombre"]."\"></td>";
					echo "<td><textarea style=\"width:400px\" name=\"descripcion\" rows=\"2\">".$row["descripcion"]."</textarea></td>";
					echo "<td style=\"vertical-align:top\"><input type=\"submit\" style=\"width:150px\" value=\"Cambiar\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}


	echo "</td></tr></table><br>";
}
?>
