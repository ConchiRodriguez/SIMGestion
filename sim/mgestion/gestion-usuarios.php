<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1002) AND ($autorizado == true)) {
	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Usuarios."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if (($soption != "") and ($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1002&sop=0\" class=".$class.">".$Usuarios."</a></td>";
				if (($soption != "") and ($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1002&sop=100\" class=".$class.">".$Anadir." ".$Usuario."</a></td>";
				if (($soption != "") and ($soption >= 500) and ($soption < 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1002&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 0) {
		echo "<h4>".$Usuarios." :</h4>";
		echo "<table><tr>";
			echo "<td class=\"menu\">";
				if ($_GET["ver"] == 0) { 
					$sql = "select * from sgm_users where activo=1 order by usuario";
					echo "<a href=\"index.php?op=1002&sop=0&ver=1\" style=\"color:white;\">".$Ver." ".$Todos."</a>";
				}
				if ($_GET["ver"] == 1) { 
					$sql = "select * from sgm_users order by usuario";
					echo "<a href=\"index.php?op=1002&sop=0&ver=0\" style=\"color:white;\">".$Ver." ".$Solo." ".$Activos."</a>";
				}
			echo "</td>";
			echo "<td class=\"menu\">";
				echo "<a href=\"index.php?op=1002&sop=0&sims=1&ver=1\" style=\"color:white;\">".$Ver." SIMs</a>";
				if ($_GET["sims"] == 1) { 
					$sql = "select * from sgm_users where sgm=1 order by usuario";
				}
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		mostrarUsuari($sql,"1","2","3");
	}

	if (($soption == 1) or ($soption == 100)) {
		echo afegirModificarUsuari ("op=1002&sop=0");
	}


	if ($soption == 2) {
		echo modificarPermisosUsuaris ("op=1002&sop=0");
	}

	if ($soption == 3) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_users_clients where id_user=".$_GET["id_user"]." and id_client=".$_POST["id_client"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if (!$row){
				$camposInsert = "id_user,id_client,admin";
				$datosInsert = array($_GET["id_user"],$_POST["id_client"],$_POST["admin"]);
				insertFunction ("sgm_users_clients",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$camposUpdate = array("admin");
			$datosUpdate = array($_POST["admin"]);
			updateFunction ("sgm_users_clients",$_GET["id_linea"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_users_clients",$_GET["id_linea"]);
		}

		$sqluser = "select * from sgm_users WHERE id=".$_GET["id_user"];
		$resultuser = mysql_query(convert_sql($sqluser));
		$rowuser = mysql_fetch_array($resultuser);
		echo "<h4>".$Clientes." ".$Usuario." : ".$rowuser["usuario"]."</h4>";
		echo boton(array("op=1002&sop=0"),array("&laquo; ".$Volver));
		echo "<table cellspacing=\"0\ style=\"width:300px;\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Clientes."</th>";
				echo "<th>Admin</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1002&sop=3&ssop=1&id_user=".$rowuser["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><select name=\"id_client\" style=\"width:200px;\">";
					$sqlc = "select * from sgm_clients where visible=1 order by nombre";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select name=\"admin\" style=\"width:40px\">";
					echo "<option value=\"0\" selected>NO</option>";
					echo "<option value=\"1\">SI</option>";
				echo "</select></td>";
				echo "<td><input value=\"".$Anadir."\" type=\"Submit\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";

			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_users_clients where id_user=".$_GET["id_user"];
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlc = "select * from sgm_clients where id=".$row["id_client"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr>";
					echo "<td style=\"text-align:center\"><a href=\"index.php?op=1002&sop=3&ssop=3&id_user=".$_GET["id_user"]."&id_linea=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
					echo "<td style=\"width:200px;\">".$rowc["nombre"]."</td>";
					echo "<form action=\"index.php?op=1002&sop=3&ssop=2&id_user=".$_GET["id_user"]."&id_linea=".$row["id"]."\" method=\"post\">";
					echo "<td><select name=\"admin\" style=\"width:40px\">";
						if ($row["admin"] == 1) {
							echo "<option value=\"1\" selected>SI</option>";
							echo "<option value=\"0\">NO</option>";
						}
						if ($row["admin"] == 0) {
							echo "<option value=\"1\">SI</option>";
							echo "<option value=\"0\" selected>NO</option>";
						}
					echo "</select></td>";
					echo "<input type=\"Hidden\" name=\"id_client\" value=\"".$rowc["id"]."\">";
					echo "<td><input value=\"".$Modificar."\" type=\"Submit\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1002&sop=510"),array($Tipos));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1){
			$datosInsert = array($_POST["tipus"]);
			insertFunction ("sgm_users_tipus","tipus",$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("tipus");
			$datosUpdate = array($_POST["tipus"]);
			updateFunction ("sgm_users_tipus",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3){
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_users_tipus",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Tipos."</h4>";
		echo boton(array("op=1002&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th style=\"text-align:center\">".$Tipo."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1002&sop=510&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"tipus\" style=\"width:200px;\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
		$sqlut = "select * from sgm_users_tipus where visible=1 order by tipus";
		$resultut = mysql_query(convert_sql($sqlut));
		while ($rowut = mysql_fetch_array($resultut)) {
			echo "<tr>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1002&sop=511&id=".$rowut["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
				echo "<form action=\"index.php?op=1002&sop=510&ssop=2&id=".$rowut["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"tipus\" style=\"width:200px;\" value=\"".$rowut["tipus"]."\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
				echo "</form>";
				echo "<td>";
					echo boton_form("op=1002&sop=512&id=".$rowut["id"]."",$Permisos." ".$Tipo);
				echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	if (($soption == 511) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1002&sop=510&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1002&sop=510\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 512) and ($admin == true)) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_users_permisos where id_tipus=".$_GET["id"]." and id_modulo=".$_POST["id_modulo"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if (!$row){
				$camposInsert = "id_tipus,id_modulo,admin";
				$datosInsert = array($_GET["id"],$_POST["id_modulo"],$_POST["admin"]);
				insertFunction ("sgm_users_permisos",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$camposUpdate = array("admin");
			$datosUpdate = array($_POST["admin"]);
			updateFunction ("sgm_users_permisos",$_GET["id_linea"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_users_permisos",$_GET["id_linea"]);
		}

		$sqluser = "select * from sgm_users_permisos WHERE id_tipus=".$_GET["id"];
		$resultuser = mysql_query(convert_sql($sqluser));
		$rowuser = mysql_fetch_array($resultuser);
		echo "<h4>".$Permisos." ".$Tipo." ".$Usuario." : </h4>";
		echo boton(array("op=1002&sop=510"),array("&laquo; ".$Volver));
		echo "<table cellspacing=\"0\ style=\"width:300px;\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Modulo."</th>";
				echo "<th>Admin.</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1002&sop=512&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><select name=\"id_modulo\" style=\"width:200px;\">";
					$sqlc = "select * from sgm_users_permisos_modulos where visible=1 order by id_modulo";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						echo "<option value=\"".$rowc["id_modulo"]."\">".$rowc["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select name=\"admin\" style=\"width:40px\">";
					echo "<option value=\"0\" selected>NO</option>";
					echo "<option value=\"1\">SI</option>";
				echo "</select></td>";
				echo "<td><input value=\"".$Anadir."\" type=\"Submit\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_users_permisos where id_tipus=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlc = "select * from sgm_users_permisos_modulos where id_modulo=".$row["id_modulo"]." order by nombre";
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr>";
					echo "<td style=\"text-align:center\"><a href=\"index.php?op=1002&sop=512&ssop=3&id=".$_GET["id"]."&id_linea=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
					echo "<td style=\"width:200px;\">".$rowc["nombre"]."</td>";
					echo "<form action=\"index.php?op=1002&sop=512&ssop=2&id=".$_GET["id"]."&id_linea=".$row["id"]."\" method=\"post\">";
					echo "<td><select name=\"admin\" style=\"width:40px\">";
						if ($row["admin"] == 1) {
							echo "<option value=\"1\" selected>SI</option>";
							echo "<option value=\"0\">NO</option>";
						}
						if ($row["admin"] == 0) {
							echo "<option value=\"1\">SI</option>";
							echo "<option value=\"0\" selected>NO</option>";
						}
					echo "</select></td>";
					echo "<td><input value=\"".$Modificar."\" type=\"Submit\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	echo "</td></tr></table><br>";
}
?>
