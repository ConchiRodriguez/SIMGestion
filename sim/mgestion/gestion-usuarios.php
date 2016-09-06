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
		echo modificarPermisosUsuaris ("op=1002&sop=0","op=1002&sop=2");
	}

	if ($soption == 3) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_users_clients where id_user=".$_GET["id_user"]." and id_client=".$_POST["id_client"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
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

		$sqluser = "select id,usuario from sgm_users WHERE id=".$_GET["id_user"];
		$resultuser = mysqli_query($dbhandle,convertSQL($sqluser));
		$rowuser = mysqli_fetch_array($resultuser);
		echo "<h4>".$Clientes." ".$Usuario." : ".$rowuser["usuario"]."</h4>";
		echo boton(array("op=1002&sop=0"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Clientes."</th>";
				echo "<th>".$Admin."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1002&sop=3&ssop=1&id_user=".$rowuser["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><select name=\"id_client\" style=\"width:500px;\">";
					$sqlc = "select id,nombre from sgm_clients where visible=1 order by nombre";
					$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
					while ($rowc = mysqli_fetch_array($resultc)) {
						echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select name=\"admin\" style=\"width:40px\">";
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input value=\"".$Anadir."\" type=\"Submit\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";

			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_users_clients where id_user=".$_GET["id_user"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlc = "select id,nombre from sgm_clients where id=".$row["id_client"];
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				echo "<tr>";
					echo "<td style=\"text-align:center\"><a href=\"index.php?op=1002&sop=3&ssop=3&id_user=".$_GET["id_user"]."&id_linea=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
					echo "<td style=\"width:200px;\">".$rowc["nombre"]."</td>";
					echo "<form action=\"index.php?op=1002&sop=3&ssop=2&id_user=".$_GET["id_user"]."&id_linea=".$row["id"]."\" method=\"post\">";
					echo "<td><select name=\"admin\" style=\"width:40px\">";
						if ($row["admin"] == 1) {
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						}
						if ($row["admin"] == 0) {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
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
			
			$sqlut = "select * from sgm_users_tipus where visible=1 and tipus='".$_POST["tipus"]."'";
			$resultut = mysqli_query($dbhandle,convertSQL($sqlut));
			$rowut = mysqli_fetch_array($resultut);
			
			$sql = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				if ($_POST[$row["departamento"]] == 1){
					$camposInsert = "id_tipo,id_departamento";
					$datosInsert = array($rowut["id"],$row["id"]);
					insertFunction ("sim_usuarios_tipos_departamentos",$camposInsert,$datosInsert);
				}
			}
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
				$sql = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)){
					echo "<th style=\"text-align:center\">".$row["departamento"]."</th>";
				}
				echo "<th></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1002&sop=510&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"tipus\" style=\"width:200px;\" required></td>";
				$sql = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)){
					echo "<td><input type=\"Checkbox\" name=\"".$row["departamento"]."\" value=\"1\"></td>";
				}
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
		$sqlut = "select * from sgm_users_tipus where visible=1 order by tipus";
		$resultut = mysqli_query($dbhandle,convertSQL($sqlut));
		while ($rowut = mysqli_fetch_array($resultut)) {
			echo "<tr>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1002&sop=511&id=".$rowut["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
				echo "<form action=\"index.php?op=1002&sop=510&ssop=2&id=".$rowut["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"tipus\" style=\"width:200px;\" value=\"".$rowut["tipus"]."\" required></td>";
				$sql = "select * from sgm_rrhh_departamento where visible=1 order by departamento";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)){
					echo "<td><input type=\"Checkbox\" name=\"".$row["departamento"]."\" value=\"1\"></td>";
				}
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
		echo boton(array("op=1002&sop=510&ssop=3&id=".$_GET["id"],"op=1002&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 512) and ($admin == true)) {
		if ($ssoption == 1) {
			$sql = "select id from sgm_users_permisos_modulos where visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				if ($_POST["permiso".$row["id"]] == 0) {
					$sqlt = "select * from sgm_users_permisos where id_tipus=".$_GET["id"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
					$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
					$rowt = mysqli_fetch_array($resultt);
					deleteFunction ("sgm_users_permisos",$rowt["id"]);
				}
				if ($_POST["permiso".$row["id"]] == 1) {
					$sqlt = "select * from sgm_users_permisos where id_tipus=".$_GET["id"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
					$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
					$rowt = mysqli_fetch_array($resultt);
					if (!$rowt){
						$camposInsert = "id_tipus,id_modulo";
						$datosInsert = array($_GET["id"],$_POST["id_modulo".$row["id"]]);
						insertFunction ("sgm_users_permisos",$camposInsert,$datosInsert);
					}
				}
				$sqlt = "select * from sgm_users_permisos where id_tipus=".$_GET["id"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				$camposUpdate = array("admin");
				$datosUpdate = array($_POST["admin".$row["id"]]);
				updateFunction ("sgm_users_permisos",$rowt["id"],$camposUpdate,$datosUpdate);
			}
		}

		$sql = "select * from sgm_users_tipus where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<h4>".$Permisos." ".$Tipo." ".$Usuario." : ".$row["tipus"]."</h4>";
			echo boton(array("op=1002&sop=510"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Modulo."</th>";
				echo "<th>".$Acceso."</th>";
				echo "<th>Admin</th>";
				echo "<th></th>";
			echo "</tr>";
		echo "<form action=\"index.php?op=1002&sop=512&&id=".$_GET["id"]."&ssop=1\" method=\"post\">";
			echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100%\"></td></tr>";
		$sql = "select id,nombre,id_modulo from sgm_users_permisos_modulos where visible=1 order by nombre";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)) {
			$sqlt = "select count(*) as total from sgm_users_permisos where id_tipus=".$_GET["id"]." and id_modulo=".$row["id_modulo"];
			$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
			$rowt = mysqli_fetch_array($resultt);
			echo "<tr>";
				echo "<td style=\"width:150px\"><strong>".$row["nombre"]."</strong></td>";
				echo "<input type=\"Hidden\" name=\"id_modulo".$row["id"]."\" value=\"".$row["id_modulo"]."\">";
				echo "<td style=\"width:60px\"><select name=\"permiso".$row["id"]."\" style=\"width:40px\">";
					if ($rowt["total"] == 1) {
						echo "<option value=\"1\" selected>".$Si."</option>";
						echo "<option value=\"0\">".$No."</option>";
					}
					if ($rowt["total"] == 0) {
						echo "<option value=\"1\">".$Si."</option>";
						echo "<option value=\"0\" selected>".$No."</option>";
					}
				echo "</select></td>";
				$sqlad = "select * from sgm_users_permisos where id_tipus=".$_GET["id"]." and id_modulo=".$row["id_modulo"];
				$resultad = mysqli_query($dbhandle,convertSQL($sqlad));
				$rowad = mysqli_fetch_array($resultad);
				echo "<td style=\"width:60px\"><select name=\"admin".$row["id"]."\" style=\"width:40px\">";
					if ($rowad["admin"] == 1) {
						echo "<option value=\"1\" selected>".$Si."</option>";
						echo "<option value=\"0\">".$No."</option>";
					}
					if ($rowad["admin"] == 0) {
						echo "<option value=\"1\">".$Si."</option>";
						echo "<option value=\"0\" selected>".$No."</option>";
					}
				echo "</select></td>";
			echo "</tr>";
		}
			echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100%\"></td></tr>";
		echo "</form>";
		echo "</table>";
	}

	echo "</td></tr></table><br>";
}
?>
