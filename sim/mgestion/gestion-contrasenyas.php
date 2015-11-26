<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1024) AND ($autorizado == true)) {
	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Contrasenas."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1024&sop=0\" class=".$class.">".$Buscar." ".$Contrasenas."</a></td>";
					if (($soption >= 100) and ($soption < 200) and ($_GET["id_con"] <= 0)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1024&sop=100\" class=".$class.">".$Anadir." ".$Contrasenas."</a></td>";
					if (($soption != "") and ($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1024&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
	echo "</table><br>";
	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($_POST["id_contrato"] > 0) { $id_contrato = $_POST["id_contrato"];} elseif ($_GET["id_contrato"] > 0) { $id_contrato = $_GET["id_contrato"];}
	if ($_POST["id_aplicacion"] > 0) { $id_aplicacion = $_POST["id_aplicacion"];} elseif ($_GET["id_aplicacion"] > 0) { $id_aplicacion = $_GET["id_aplicacion"];}

	if ($soption == 0) {
		echo "<h4>".$Contrasenas." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Contrato."</th>";
				echo "<th>".$Aplicacion."</th>";
			echo "</tr>";
		echo "<form action=\"index.php?op=1024&sop=0\" method=\"post\">";
			echo "<tr>";
				echo "<td><select style=\"width:700px\" name=\"id_contrato\">";
					echo "<option value=\"0\">-</option>";
					$sqlc = "select * from sgm_clients where visible=1 order by nombre";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						$sql = "select * from sgm_contratos where visible=1 and activo=1 and id_cliente_final=".$rowc["id"]."";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)){
							if ($row){
								if($row["id"] == $id_contrato){
									echo "<option value=\"".$row["id"]."\" selected>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]." - ".$row["descripcion"]."</option>";
								} else {
									echo "<option value=\"".$row["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]." - ".$row["descripcion"]."</option>";
								}
							}
						}
					}
				echo "</select></td>";
				echo "<td><select style=\"width:200px\" name=\"id_aplicacion\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_contrasenyes_apliciones where visible=1 order by aplicacion";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						if ($id_aplicacion == $row["id"]){
							echo "<option value=\"".$row["id"]."\" selected>".$row["aplicacion"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["aplicacion"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:150px\"></td>";
			echo "</tr>";
		echo "</form>";
		echo "</table>";
		echo mostrarContrasenyes("op=1024&sop=100","op=1024&sop=1","op=1024&sop=2","op=1024&sop=3");
	}

	if ($soption == 1) {
		$sqlc = "select * from sgm_contrasenyes where id=".$_GET["id_con"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1024&sop=0&ssop=3&id_con=".$_GET["id_con"]."&id_contrato=".$rowc["id_contrato"],"op=1024&sop=0&id_contrato=".$rowc["id_contrato"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 2) {
		echo  modificarContrasenya("op=1024&sop=0");
	}

	if ($soption == 3) {
		echo mostrarContrasenya();
	}

	if ($soption == 100){
		afegirModificarContrasenya ("op=1024&sop=0");
	}
	
	if (($soption == 500) AND ($admin == true)) {
		if ($admin == true) {
			echo boton(array("op=1024&sop=510"),array($Aplicaciones));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)){
			$datosInsert = array($_POST["aplicacion"],$_POST["descripcion"]);
			insertFunction ("sgm_contrasenyes_apliciones","aplicacion,descripcion",$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)){
			$camposUpdate = array("aplicacion","descripcion");
			$datosUpdate = array($_POST["aplicacion"],$_POST["descripcion"]);
			updateFunction ("sgm_contrasenyes_apliciones",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)){
			$sqlc = "select count(*) as total from sgm_contrasenyes where visible=1 and id_aplicacion=".$_GET["id"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			if ($rowc["total"] > 0){
				mensageError($ContrasenyaAppErrorEliminar);
			} else {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sgm_contrasenyes_apliciones",$_GET["id"],$camposUpdate,$datosUpdate);
			}
		}

		echo "<h4>".$Aplicaciones." : </h4>";
		echo boton(array("op=1024&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th style=\"text-align:center;\">".$Aplicacion."</th>";
				echo "<th style=\"text-align:center;\">".$Descripcion."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1024&sop=510&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"aplicacion\" required></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contrasenyes_apliciones where visible=1 order by aplicacion";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1024&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1024&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["aplicacion"]."\" style=\"width:150px\" name=\"aplicacion\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 511) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1024&sop=510&ssop=3&id=".$_GET["id"],"op=1024&sop=510"),array($Si,$No));
		echo "</center>";
	}

#	if ($soption == 1234) {
#		$sql = "select * from sgm_contrasenyes";
#		$result = mysql_query(convert_sql($sql));
#		while ($row = mysql_fetch_array($result)) {
#			$cadena = encrypt($row["pass"], $simclau);
#			$sql = "update sgm_contrasenyes set ";
#			$sql = $sql."pass='".$cadena."'";
#			$sql = $sql." WHERE id=".$row["id"]."";
#			mysql_query(convert_sql($sql));
#			echo $sql."<br>";
#		}
#	}

	echo "</td></tr></table><br>";
}

?>

