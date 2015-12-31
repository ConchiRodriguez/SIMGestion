<?php
error_reporting(~E_ALL);


function mostrarUsuari ($sql_usuaris,$link_edit,$link_permisos,$link_clientes){
	global $db,$dbhandle,$Usuario,$Gestion,$Validado,$Activo,$Ultima,$Conexion,$Modificar,$ssoption,$Permisos,$Clientes,$UsuarioYaReg,$NombreIncorrecto,$MailYaReg,$MailIncorrecto,$PassIncorrecto,$CompletaCorrect,$Si,$No;
	if ($ssoption == 1) {
		$camposUpdate = array("sgm","activo","validado");
		$datosUpdate = array($_POST["sgm"],$_POST["activo"],$_POST["validado"]);
		updateFunction ("sgm_users",$_POST["id_user"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 2) {
		$registro = 1;
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."'";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] != 0) { echo mensageError($UsuarioYaReg); $registro = 0; }
		if ($_POST["user"] == "") { echo mensageError($NombreIncorrecto); $registro = 0; }
		$sql = "select Count(*) AS total from sgm_users WHERE mail='".$_POST["mail"]."'";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] != 0) { echo mensageError($MailYaReg); $registro = 0; }
		if (comprobarMail($_POST["mail"]) == false) { echo mensageError($MailIncorrecto); $registro = 0; }
		if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { echo mensageError($PassIncorrecto); $registro = 0; }
		if ($registro == 0 ) {echo mensageError($CompletaCorrect);}
		echo $contrasena = crypt($_POST["pass1"]);
		if ($registro == 1 ) {
			$datosInsert = array($_POST["user"],$contrasena,$_POST["mail"],date("Y-m-d"),$_POST["id_tipus"]);
			insertFunction ("sgm_users","usuario,pass,mail,datejoin,id_tipus",$datosInsert);
			$sqlu = "select id from sgm_users where usuario='".$_POST["user"]."'";
			$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
			$rowu = mysqli_fetch_array($resultu);
			$sql = "select id_modulo,admin from sgm_users_permisos where id_tipus=".$_POST["id_tipus"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$datosInsert = array($rowu["id"],$row["id_modulo"],$row["admin"]);
				insertFunction ("sgm_users_permisos","id_user,id_modulo,admin",$datosInsert);
			}
		}
		if ($_GET["id"] > 0){
			$camposInsert = "id_user,id_client";
			$datosInsert = array($rowu["id"],$_GET["id"]);
			insertFunction ("sgm_users_clients",$camposInsert,$datosInsert);
		}
	}
	if ($ssoption == 3) {
		$sqlx = "select id_tipus from sgm_users WHERE mail='".$_POST["mail"]."' AND id<>".$_GET["id_user"];
		$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
		$rowx = mysqli_fetch_array($resultx);
		if (!$rowx){
			if ($_POST["pass1"] != "") {
				if ($_POST["pass1"] == $_POST["pass2"]){
					$contrasena = crypt($_POST["pass1"]);
					$camposUpdate = array("usuario","mail","pass","id_tipus");
					$datosUpdate = array($_POST["user"],$_POST["mail"],$contrasena,$_POST["id_tipus"]);
				} else {
					echo mensageError($PassIncorrecto);
				}
			} else {
				$camposUpdate = array("usuario","mail","id_tipus");
				$datosUpdate = array($_POST["user"],$_POST["mail"],$_POST["id_tipus"]);
			}
			updateFunction ("sgm_users",$_GET["id_user"],$camposUpdate,$datosUpdate);
			if ($rowx["id_tipus"] != $_POST["id_tipus"]){
				$sqlt = "select id from sgm_users_permisos where id_user=".$_GET["id_user"];
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				while ($rowt = mysqli_fetch_array($resultt)){
					deleteFunction ("sgm_users_permisos",$rowt["id"]);
				}
				$sql = "select id_modulo,admin from sgm_users_permisos where id_tipus=".$_POST["id_tipus"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					$datosInsert = array($_GET["id_user"],$row["id_modulo"],$row["admin"]);
					insertFunction ("sgm_users_permisos","id_user,id_modulo,admin",$datosInsert);
				}
			}
		}
	}

	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<th style=\"text-align:center;width:20px\">Id.</th>";
			echo "<th style=\"text-align:center;width:20px\">Id.Or.</th>";
			echo "<th></th>";
			echo "<th style=\"text-align:center;width:300px\">".$Usuario."</th>";
			echo "<th style=\"text-align:center;width:50px\">".$Gestion."</th>";
			echo "<th style=\"text-align:center;width:50px\">".$Validado."</th>";
			echo "<th style=\"text-align:center;width:50px\">".$Activo."</th>";
			echo "<th></th>";
			echo "<th style=\"text-align:center;width:20px\">".$Permisos."</th>";
		if ($_GET["id"] <= 0){
			echo "<th style=\"text-align:center;width:20px\">".$Clientes."</th>";
		}
		echo "</tr>";
	$sql = $sql_usuaris;
	$result = mysqli_query($dbhandle,convertSQL($sql));
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>";
			echo "<td style=\"text-align:center;\">".$row["id"]."</td>";
			echo "<td style=\"text-align:center;\">".$row["id_origen"]."</td>";
			echo "<td></td>";
			echo "<td>";
				echo " <a href=\"index.php?op=".$_GET["op"]."&sop=".$link_edit."&id_user=".$row["id"]."\"><strong>".$row["usuario"]."</strong></a>";
			echo "</td>";
			echo "<form action=\"index.php?".$_SERVER["QUERY_STRING"]."&ssop=1&ver=".$_GET["ver"]."&sims=".$_GET["sims"]."\" method=\"post\">";
			echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$row["id"]."\">";
			echo "<td style=\"text-align:left;\"><select name=\"sgm\" style=\"width:40px\">";
				if ($row["sgm"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($row["sgm"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select>";
			echo "</td>";
			echo "<td style=\"text-align:center;\"><select name=\"validado\" style=\"width:40px\">";
				if ($row["validado"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($row["validado"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select></td>";
			echo "<td style=\"text-align:center;\"><select name=\"activo\" style=\"width:40px\">";
				if ($row["activo"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($row["activo"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select></td>";
			echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
			echo "</form>";
			$sqlt = "select count(*) as total from sgm_users_permisos where id_user=".$row["id"];
			$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
			$rowt = mysqli_fetch_array($resultt);
			if ($rowt["total"] > 0) { $imagen = "application_key.png"; } else { $imagen = "application.png"; }
			echo "<td style=\"text-align:center\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$link_permisos."&id_user=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/".$imagen."\" style=\"border:0px;\"></a></td>";
			## SI MODULO FACTURAS MUESTRO CLIENTES RELACIONADOS
		if ($_GET["id"] <= 0){
			$sqlp = "select count(*) as total from sgm_users_permisos_modulos WHERE id_modulo=1003";
			$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
			$rowp = mysqli_fetch_array($resultp);
			if ($rowp["total"] == 1) {
				$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$row["id"];
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				if ($rowt["total"] > 0) { $imagen2 = "report_user.png"; } else { $imagen2 = "report.png"; }
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$link_clientes."&id_user=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/".$imagen2."\" style=\"border:0px;\"></a></td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>";
}

?>