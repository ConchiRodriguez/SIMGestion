<?php
error_reporting(~E_ALL);


function modificarPermisosUsuaris ($url_volver,$url){
	global $db,$dbhandle,$Volver,$Administrar,$Permisos,$Acceso,$Modulo,$Modificar,$ssoption,$Si,$No;
	if ($ssoption == 1) {
		$sql = "select id from sgm_users_permisos_modulos where visible=1 order by nombre";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)) {
			if ($_POST["permiso".$row["id"]] == 0) {
				$sqlt = "select * from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				deleteFunction ("sgm_users_permisos",$rowt["id"]);
			}
			if ($_POST["permiso".$row["id"]] == 1) {
				$sqlt = "select * from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				if (!$rowt){
					$camposInsert = "id_user,id_modulo";
					$datosInsert = array($_GET["id_user"],$_POST["id_modulo".$row["id"]]);
					insertFunction ("sgm_users_permisos",$camposInsert,$datosInsert);
				}
			}
			$sqlt = "select * from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
			$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
			$rowt = mysqli_fetch_array($resultt);
			$camposUpdate = array("admin");
			$datosUpdate = array($_POST["admin".$row["id"]]);
			updateFunction ("sgm_users_permisos",$rowt["id"],$camposUpdate,$datosUpdate);
		}
	}

	$sql = "select usuario from sgm_users where id=".$_GET["id_user"];
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	echo "<h4>".$Administrar." ".$Permisos.": ".$row["usuario"]."</h4>";
	echo boton(array($url_volver),array("&laquo; ".$Volver));
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<th>".$Modulo."</th>";
			echo "<th>".$Acceso."</th>";
			echo "<th>Admin</th>";
			echo "<th></th>";
		echo "</tr>";
	echo "<form action=\"index.php?".$url."&id_user=".$_GET["id_user"]."&ssop=1\" method=\"post\">";
		echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100%\"></td></tr>";
	$sql = "select * from sgm_users_permisos_modulos where visible=1 order by nombre";
	$result = mysqli_query($dbhandle,convertSQL($sql));
	while ($row = mysqli_fetch_array($result)) {
		$sqlt = "select count(*) as total from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$row["id_modulo"];
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
			$sqlad = "select id,admin from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$row["id_modulo"];
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

?>