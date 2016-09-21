<?php
error_reporting(~E_ALL);


function modificarContrasenya($url_volver){
	global $db,$dbhandle,$ssoption,$userid,$simclau,$idioma;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

	if ($ssoption == 1) {
		$cadena = encrypt($_POST["passold"],$simclau);
		$sql = "select Count(*) AS total from sgm_contrasenyes WHERE id='".$_GET["id_con"]."' and pass='".$cadena."'";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if (($_POST["pass1"] != $_POST["pass2"]) or ($_POST["pass1"] == "") or ($row["total"] <= 0)) { echo mensaje_error($PassIncorrecto);}
		if (($row["total"] > 0) and ($_POST["pass1"] == $_POST["pass2"]) and ($_POST["pass1"] != "")){
			$cadena2 = encrypt($_POST["pass1"],$simclau);

			$camposUpdate = array("pass");
			$datosUpdate = array($cadena2);
			updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
			echo mensaje_error_c($mesaje_modificar,"green");
			
			$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
			$datosInsert = array($_GET["id_con"],$userid,time(),2);
			insertFunction ("sgm_contrasenyes_lopd",$camposInsert,$datosInsert);
		}
	}
	$sqlc = "select id_contrato,id_aplicacion from sgm_contrasenyes where id=".$_GET["id_con"];
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);
	$sqlcl = "select nombre,cognom1,cognom2 from sgm_clients where id in (select id_cliente from sgm_contratos where id=".$rowc["id_contrato"].")";
	$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
	$rowcl = mysqli_fetch_array($resultcl);
	$sqlca = "select aplicacion from sgm_contrasenyes_apliciones where id=".$rowc["id_aplicacion"];
	$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
	$rowca = mysqli_fetch_array($resultca);

	echo "<h4>".$Modificar." ".$Contrasena." </h4>";
	echo "".$Cliente." : ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."<br>".$Aplicacion." : ".$rowca["aplicacion"]."";
	echo boton(array($url_volver."&id_contrato=".$rowc["id_contrato"]."&id_aplicacion=".$rowc["id_aplicacion"]),array("&laquo; ".$Volver));
	echo "<table class=\"lista\">";
		echo "<form action=\"index.php?".$_SERVER["QUERY_STRING"]."&ssop=1\" method=\"post\">";
		echo "<tr><th>".$Contrasena." ".$Anterior."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"passold\" style=\"width:100px\" required>*</td></tr>";
		echo "<tr><th>".$Nueva." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"pass1\" style=\"width:100px\" required>*</td></tr>";
		echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"pass2\" style=\"width:100px\" required>*</td></tr>";
		echo "<tr>";
			echo "<td></td><td class=\"submit\">";
				echo "<input type=\"submit\" value=\"".$Modificar."\">";
			echo "</td>";
		echo "</tr>";
		echo "</form>";
		echo "<tr><td>* ".$Campos." ".$Obligatorios."</td><tr>";
	echo "</table>";
}

?>