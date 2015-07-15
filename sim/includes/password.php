<?php
if ($option == 102) {
	if ($soption == 0) {
		?>
		<strong><em>Recuperar password</em></strong><br><br>
		<table style=" border-bottom : 1px solid Black; border-left : 1px solid Black; border-right : 1px solid Black; border-top : 1px solid Black; width=700; text-align : justify;">
		<tr><td>
		Si has perdido la password de usuario con el que te registrarte, solo debes rellenar el formulario inferior con la dirección mail que usaste para el registro.
		<br><br>En menos de 48 horas recibiras de nuevo tus datos.
		</td></tr>
		</table>
		<form action="index.php?op=102&sop=1" method="post">
		<br><br>
		<table>
		<tr><td><strong>*Dirección e-mail.</strong><br>La que usaste para el registro.</td><td style="vertical-align : middle;"><input type="text" name="mail" class="px200">*</td></tr>
		</table>
		<br><br><input type="Submit" value="Recuperar" class="px150">
		</form>
		<br>* Campos obligatorios.
		<?php
	}
	if ($soption == 1) {
		$registro = 1;
		$sql = "select Count(*) AS total from vs_users WHERE mail='".$_POST["mail"]."'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($row["total"] == 0) { echo "<br>Esta direccion e-mail no esta registrada."; $registro = 0; }
		if ($registro == 1 ) {
			$sql2 = "select * from vs_users WHERE mail='".$_POST["mail"]."'";
			$result2 = $db->sql_query($sql2);
			$row2 = $db->sql_fetchrow($result2);

			#ENVIO NOTIFICACIÓN
			$destino = $row2["mail"];
			$asunto = "Mensaje de precuperación de password.";
			$mensaje = "A sido recordada la password de : <a href=\"".$urloriginal."\">".$urloriginal."</a>";
			$mensaje .= "<br><br>Usuario : ".$row2["usuario"];
			$mensaje .= "<br>Password : ".$row2["pass"];
			$mensaje .= "<br><br>No responda este mail.";
			$cabeceras = "From: ".$notify_from."\nX-Mailer: PHP/" . phpversion();
			$cabeceras .= "MIME-Version: 1.0\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
			mail($destino, $asunto, $mensaje, $cabeceras);
			echo "<br><br>Se ha enviado un mail para la recuperación de password a : <strong>".$_POST["mail"]."</strong>";
		}
	}
}
?>
