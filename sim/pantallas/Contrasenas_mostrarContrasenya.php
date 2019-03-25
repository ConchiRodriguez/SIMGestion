<?php
error_reporting(~E_ALL);


function mostrarContrasenya(){
	global $db,$dbhandle,$idioma,$userid,$simclau;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

		?><script>setTimeout ("redireccionar()", 10000);</script><?php
		$sqlc = "select id_client,id_aplicacion,pass from sgm_contrasenyes where id=".$_GET["id_con"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		$sqlcl = "select nombre,cognom1,cognom2 from sgm_clients where id=".$rowc["id_client"];
		$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
		$rowcl = mysqli_fetch_array($resultcl);
		$sqlca = "select aplicacion from sgm_contrasenyes_apliciones where id=".$rowc["id_aplicacion"];
		$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
		$rowca = mysqli_fetch_array($resultca);

		echo "<h4>".$Ver." ".$Contrasena."</h4>";
		echo $Cliente." : ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."<br>".$Aplicacion." : ".$rowca["aplicacion"]."";
		echo "<table class=\"lista\">";
			$cadena = decrypt($rowc["pass"],$simclau);
			echo "<tr><th>".$Contrasena." : </th><td style=\"vertical-align middle;\">".$cadena."</td></tr>";
		echo "</table>";
		echo "<br><br>En 10 segundos será redirigido por motivos de seguridad.<br>";
		$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
		$datosInsert = array($_GET["id_con"],$userid,time(),1);
		insertFunction ("sgm_contrasenyes_lopd",$camposInsert,$datosInsert);
}

?>