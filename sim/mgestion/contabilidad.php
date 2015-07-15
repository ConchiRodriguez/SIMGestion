<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);

if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1019) AND ($autorizado == true)) {
	if ($_GET['or'] != "") { $orden = $_GET['or']; } else { $orden = 0; }

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<strong>Contabilidad 1.0</strong>";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
			if ($admin == true) {
				echo "<br><a href=\"index.php?op=1019&sop=100\">&raquo; Administrar Plan Contable</a>";
			}
			if ($admin == false) {
			}
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 100) {
		echo "<strong>Gestión del plan contable :</strong>";
		echo "<br><br><center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:center;\"><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Dependencia</td>";
				echo "<td style=\"text-align:center;\">Cuenta</td>";
				echo "<td style=\"text-align:center;\">Nombre</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";

			echo "<tr>";
			echo "<form action=\"index.php?op=1019&sop=101\" method=\"post\">";
				echo "<td style=\"text-align:center;\"></td>";
				echo "<td style=\"text-align:center;\"><select name=\"id_origen\" style=\"width:150px;\">";
					echo "<option value=\"0\">-</option>";
					$sqls = "select * from sgm_compte_plan where visible=1";
					$results = $db->sql_query($sqls);
					while ($rows = $db->sql_fetchrow($results)) {
						echo "<option value=\"".$rows["id"]."\">".$rows["codigo"]." ".$rows["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td style=\"text-align:center;\"><input type=\"Text\" name=\"codigo\" style=\"width:100px;\"></td>";
				echo "<td style=\"text-align:center;\"><input type=\"Text\" name=\"nombre\" style=\"width:250px;\"></td>";
				echo "<td style=\"text-align:center;\"><select name=\"activo\" style=\"width:60px;\">";
					echo "<option value=\"0\">Pasiva</option>";
					echo "<option value=\"1\">Activa</option>";
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:60px;\"></td>";
			echo "</form>";
			echo "</tr>";

			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"text-align:center;\"><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Dependencia</td>";
				echo "<td style=\"text-align:center;\">Cuenta</td>";
				echo "<td style=\"text-align:center;\">Nombre</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";

		$sql = "select * from sgm_compte_plan where visible=1";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
			echo "<form action=\"index.php?op=1019&sop=102&id=".$row["id"]."\" method=\"post\">";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1019&sop=103&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<td style=\"text-align:center;\"><select name=\"id_origen\" style=\"width:150px;\">";
					echo "<option value=\"0\">-</option>";
					$sqls = "select * from sgm_compte_plan where visible=1";
					$results = $db->sql_query($sqls);
					while ($rows = $db->sql_fetchrow($results)) {
						if ($row["id_origen"] == $rows["id"]) { echo "<option value=\"".$rows["id"]."\" selected>".$rows["codigo"]." ".$rows["nombre"]."</option>"; }
						else { echo "<option value=\"".$rows["id"]."\">".$rows["codigo"]." ".$rows["nombre"]."</option>"; }
					}
				echo "</select></td>";
				echo "<td style=\"text-align:center;\"><input type=\"Text\" name=\"codigo\" style=\"width:100px;\" value=\"".$row["codigo"]."\"></td>";
				echo "<td style=\"text-align:center;\"><input type=\"Text\" name=\"nombre\" style=\"width:250px;\" value=\"".$row["nombre"]."\"></td>";
				echo "<td style=\"text-align:center;\"><select name=\"activo\" style=\"width:60px;\">";
					if ($row["activo"] == 0) {
						echo "<option value=\"0\" selected>Pasiva</option>";
						echo "<option value=\"1\">Activa</option>";
					}
					if ($row["activo"] == 1) {
						echo "<option value=\"0\">Pasiva</option>";
						echo "<option value=\"1\" selected>Activa</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:60px;\"></td>";
			echo "</form>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 101) and ($admin == true)) {	
		$sql = "insert into sgm_compte_plan (id_origen,codigo,nombre,activo) ";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_origen"];
		$sql = $sql.",'".$_POST["codigo"]."'";
		$sql = $sql.",'".$_POST["nombre"]."'";
		$sql = $sql.",".$_POST["activo"];
		$sql = $sql.")";
		$db->sql_query($sql);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1019&sop=100\">[ Volver ]</a>";
	}

	if (($soption == 102) and ($admin == true)) {
		$sql = "update sgm_compte_plan set ";
		$sql = $sql."id_origen=".$_POST["id_origen"];
		$sql = $sql.",codigo='".$_POST["codigo"]."'";
		$sql = $sql.",nombre='".$_POST["nombre"]."'";
		$sql = $sql.",activo=".$_POST["activo"];
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1019&sop=100\">[ Volver ]</a>";
	}

	if (($soption == 103) and ($admin == true)) {
		echo "<br><br>¿Desea eliminar la cuenta seleccionada?";
		echo "<br><br><a href=\"index.php?op=1019&sop=104&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1019&sop=100\">[ NO ]</a>";
	}

	if (($soption == 104) and ($admin == true)) {
		$sql = "update sgm_compte_plan set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1019&sop=100\">[ Volver ]</a>";
	}


	echo "</td></tr></table><br>";

}
?>
