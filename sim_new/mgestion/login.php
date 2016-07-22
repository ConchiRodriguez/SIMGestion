<?php
if ($option == 100) {
	if ($soption == 0) {
		echo "<h4>LOGIN</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form method=\"post\" action=\"index.php\">";
			echo "<tr>";
				echo "<th><font class=\"tahomagrey\">".$Usuario."</font></th>";
				echo "<td><input type=\"Text\" name=\"user\" maxlength=\"100\" style=\"width:150px\"></td>";
			echo "</tr><tr>";
				echo "<th><font class=\"tahomagrey\">".$Contrasena."</font></th>";
				echo "<td><input type=\"Password\" name=\"pass\" maxlength=\"100\" style=\"width:150px\"></td>";
			echo "</tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Entrar."\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "<tr><td></td><td><a href=\"index.php?op=100&sop=1\">".$ayudaLogin."</a></td></tr>";
		echo "</table>";
		echo "<br>";
	}
	if ($soption == 1) {
		echo "<h4>".$Recuperar." ".$Contrasena."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=100&sop=2\" method=\"post\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>E-Mail</th>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"vertical-align:middle;\"><input type=\"text\" name=\"mail\"  style=\"width:300px;\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Recuperar."\"></td>";
			echo "</tr>";
		echo "</table>";
		echo "</form>";
		echo "<br>";
	}
	if ($soption == 2) {
		$registro = 1;
		$sql = "select count(*) as total from sim_usuarios WHERE mail='".$_POST["mail"]."'";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] == 0) { echo mensageError($errorMensajeRecuperacion); $registro = 0; }
		if ($registro == 1 ) {
			$sql2 = "select * from sim_usuarios WHERE mail='".$_POST["mail"]."'";
			$result2 = mysqli_query($dbhandle,convertSQL($sql2));
			$row2 = mysqli_fetch_array($result2);

			#ENVIO NOTIFICACIÓN
			$destino = $row2["mail"];
			$asunto = $asuntoMensajeRecuperacion;
			$mensaje = "<br><br>".$Usuario." : ".$row2["usuario"];
			$mensaje .= "<br><br>".$textoMensajeRecuperacion1." : <a href=\"".$urloriginal."/index.php?op=200&sop=70&idp=".$row2["contrasena"]."\">".$urloriginal."</a>";
			$mensaje .= "<br><br>".$textoMensajeRecuperacion2;
			$cabeceras = "From: ".$notify_from."\nX-Mailer: PHP/" . phpversion();
			$cabeceras .= "MIME-Version: 1.0\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
			mail($destino, $asunto, $mensaje, $cabeceras);
			echo mensageInfo($ayudaMensajeRecuperacion."<strong>".$_POST["mail"]."</strong>","green");
		}
	}

}
?>
