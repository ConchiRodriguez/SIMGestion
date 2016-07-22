<?php
error_reporting(~E_ALL);


function mostrarContrasenya(){
	global $db,$dbhandle,$Contrasena,$Cliente,$Aplicacion,$Ver,$userid,$simclau;
		?><script>setTimeout ("redireccionar()", 10000);</script><?php
		$sqlc = "select id_contrato,id_aplicacion,pass from sim_contrasenas where id=".$_GET["id_con"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		$sqlcl = "select nombre,apellido1,apellido2 from sim_clientes where id in (select id_cliente from sim_contratos where id=".$rowc["id_contrato"].")";
		$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
		$rowcl = mysqli_fetch_array($resultcl);
		$sqlca = "select aplicacion from sim_contrasenas_apliciones where id=".$rowc["id_aplicacion"];
		$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
		$rowca = mysqli_fetch_array($resultca);

		echo "<h4>".$Ver." ".$Contrasena."</h4>";
		echo $Cliente." : ".$rowcl["nombre"]." ".$rowcl["apellido1"]." ".$rowcl["apellido2"]."<br>".$Aplicacion." : ".$rowca["aplicacion"]."";
		echo "<table class=\"lista\">";
			$cadena = decrypt($rowc["pass"],$simclau);
			echo "<tr><th>".$Contrasena." : </th><td style=\"vertical-align middle;\">".$cadena."</td></tr>";
		echo "</table>";
		echo "<br><br>En 10 segundos será redirigido por motivos de seguridad.<br>";
		$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
		$datosInsert = array($_GET["id_con"],$userid,time(),1);
		insertFunction ("sim_contrasenas_lopd",$camposInsert,$datosInsert);
}

?>