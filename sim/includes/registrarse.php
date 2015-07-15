<?php
if ($option == 100) {
	if ($soption == 0) {
		echo "<h4>LOGIN</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form method=\"post\" action=\"index.php\">";
			echo "<tr><th><font class=\"tahomagrey\">Usuario</font></th>";
			echo "<td><input type=\"Text\" name=\"user\" maxlength=\"100\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
			echo "<tr><th><font class=\"tahomagrey\">Password</font></th>";
			echo "<td><input type=\"Password\" name=\"pass\" maxlength=\"100\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Entrar\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
			echo "</form>";
		echo "</table>";
		echo "<br>Si no recuerdas la contraseña pincha <a href=\"index.php?op=100&sop=4\">aqui.</a>";
		
	}
	if ($soption == 1) {
		include ("includes/terminosdeuso.php");
		?>
		<br><br>
		<br><br>
		<form action="index.php" method="get">
		<input type="Hidden" name="op" value="100">
		<input type="Hidden" name="sop" value="2">
		<input type="Checkbox" name="ok" value="1" style="border : 0;"> Acepto las condiciones.
		<br><br>
		<table>
		<tr><td><strong>*Nombre de usuario.</strong><br>Nombre que aparecera en los mensajes y usaras para hacer el login.</td><td style="vertical-align : middle;"><input type="Text" name="user" class="px100">*</td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr><td><strong>*Dirección e-mail.</strong><br>Aquí recibiras el mail de confirmación de registro.</td><td style="vertical-align : middle;"><input type="pass" name="mail" class="px200">*</td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr><td><strong>Mostrar direccion e-mail en la web.</strong><br>Selecciona que "NO" si quieres que no se muestre tu mail en este site.</td><td style="vertical-align : middle;"><input type="Radio" name="public" value="1" checked style="border : 0;">Si<input type="Radio" name="public" value="0" style="border : 0;">No</td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr><td><strong>*Contraseña.</strong><br>Máximo 10 caracteres.</td><td style="vertical-align : middle;"><input type="Password" name="pass1" class="px100" maxlength="10">*</td></tr>
		<tr><td><strong>*Repetir contraseña.</strong><br>Máximo 10 caracteres.</td><td style="vertical-align : middle;"><input type="Password" name="pass2" class="px100" maxlength="10">*</td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr><td><strong>Dirección de tu web.</strong><br>Dirección de tu página personal o de empresa.</td><td style="vertical-align : middle;"><input type="pass" name="url" class="px200" value="http://"></td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr><td><strong>Cuenta MSN.</strong><br>Cuenta de MSN.</td><td style="vertical-align : middle;"><input type="text" name="msn" class="px200"></td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr><td><strong>Cuenta ICQ.</strong><br>Introduce solo numeros, sin - ni espacios.</td><td style="vertical-align : middle;"><input type="text" name="icq" class="px100"></td></tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<?php
		echo "<tr><td><strong>Fecha nacimiento.</strong><br>Introduce aqui tu fecha de nacimiento.</td><td>";
		echo "<select name=\"day\" class=\"px50\">";
		$size = 1; While ($size <= 31) { echo "<option value=\"".$size."\">".$size."</option>"; $size++; }
		echo "</select>";
		echo "<select name=\"month\" class=\"px50\">";
		$size = 1; While ($size <= 12) { echo "<option value=\"".$size."\">".$size."</option>"; $size++; }
		echo "</select>";
		echo "<select name=\"year\" class=\"px75\">";
		$size = 1900; While ($size <= 2008) { echo "<option value=\"".$size."\">".$size."</option>"; $size++; }
		echo "</select>";
		echo "</td></tr>";
#		echo "<tr><td>&nbsp;</td><td></td></tr>";
#		echo "<tr><td><strong>Pais de residencia.</strong><br>Introduce aqui el pais desde donde juegas habitualmente.</td>";
#		echo "<td><select name=\"country\" style=\"width:150px\">";
#		$sql = "select * from sgm_country ORDER BY name";
#		$result = $db->sql_query($sql);
#		while ($row = $db->sql_fetchrow($result)) {
#			echo "<option value=\"".$row["cod"]."\">".$row["name"]."</option>";
#		}
#		echo "</select></td></tr>";
		?>
		</table>
		<br><br><input type="Submit" value="Registrarse" class="px150">
		</form>
		<br>* Campos obligatorios.
		<?php
	}
	if ($soption == 2) {
		$registro = 1;
		if ($_GET["ok"] != 1) { echo "<br>No has aceptado las condiciones de uso."; $registro = 0; }
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_GET["user"]."'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($row["total"] != 0) { echo "<br>Nombre de usuario ya registrado."; $registro = 0; }
		if ($_GET["user"] == "") { echo "<br>Valor en el campo nombre de usuario incorrecto."; $registro = 0; }
		$sql = "select Count(*) AS total from sgm_users WHERE mail='".$_GET["mail"]."'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($row["total"] != 0) { echo "<br>Direccion e-mail ya registrada."; $registro = 0; }
		if (comprobar_mail($_GET["mail"]) == false) { echo "<br>Valor en el campo e-mail incorrecto."; $registro = 0; }
		if (($_GET["pass1"] != $_GET["pass2"]) OR $_GET["pass1"] == "") { echo "<br>Valor en los campos passwords incorrecto."; $registro = 0; }
		if ($_GET["country"] == "xx") { echo "<br>Debes seleccionar un pais."; $registro = 0; }
		if ($registro == 1 ) {
#			$sql = "insert into sgm_users (usuario,pass,mail,url,msn,icq,dateborn,datejoin,public,country,nick,warnick) ";
			$sql = "insert into sgm_users (usuario,pass,mail,url,msn,icq,dateborn,datejoin,public) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_GET["user"]."'";
			$sql = $sql.",'".$_GET["pass1"]."'";
			$sql = $sql.",'".$_GET["mail"]."'";
			$sql = $sql.",'".$_GET["url"]."'";
			$sql = $sql.",'".$_GET["msn"]."'";
			$sql = $sql.",'".$_GET["icq"]."'";
			$sql = $sql.",'".$_GET['year']."-".$_GET['month']."-".$_GET['day']."'";
			$date = getdate(); 
			$sql = $sql.",'".$date["year"]."-".$date["mon"]."-".$date["mday"]."'";
			$sql = $sql.",".$_GET["public"]."";
#			$sql = $sql.",'".$_GET["country"]."'";
#			$sql = $sql.",'".$_GET["user"]."'";
#			$sql = $sql.",'".$_GET["user"]."'";
			$sql = $sql.")";
			$db->sql_query($sql);
			#ENVIO NOTIFICACIÓN
			$destino = $_GET["mail"];
			$asunto = "Mensaje de confirmación de registro.";
			$mensaje = "A sido registrado con esta cuenta de mail en : <a href=\"".$urloriginal."\">".$urloriginal."</a>";
			$mensaje .= "<br><br>Para confirmar su registro debe pulsar en el siguiente link: <a href=\"".$urloriginal."/index.php?op=100&sop=3&user=".$_GET["user"]."\">CONFIRMAR MI REGISTRO</a>";
			$mensaje .= "<br><br>Usuario : ".$_GET["user"];
			$mensaje .= "<br>Password : ".$_GET["pass1"];
			$mensaje .= "<br><br>No responda este mail.";
			$cabeceras = "From: ".$notify_from."\nX-Mailer: PHP/" . phpversion();
			$cabeceras .= "MIME-Version: 1.0\r\n";
			$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
			mail($destino, $asunto, $mensaje, $cabeceras);

			echo "<br><br>Usuario registrado correctamente. <br><br>Se ha enviado un mail para validación del registro a : <strong>".$_GET["mail"]."</strong>";
		}
	}
	if ($soption == 3) {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_GET["user"]."'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($row["total"] == 1) {
			$sql = "update sgm_users set validado=1 WHERE usuario='".$_GET["user"]."'";
			$db->sql_query($sql);
			echo "El usuario ".$_GET["user"]." se ha autorizado correctamente.";
		}
		else { echo "El usuario ".$_GET["user"]." NO ha podido autorizarse."; }
	}

	if ($soption == 4) {
			echo "<strong>RECUPERAR PASSWORD/CONTRASEÑA OLBIDADA</strong>";
			echo "<br><br>";
			echo "Si has perdido la password de usuario con el que te registrarte, solo debes rellenar el formulario inferior con la dirección mail que usaste para el registro.";
			echo "<br><br>";
			echo "En menos de 48 horas recibiras de nuevo tus datos.";
			echo "<form action=\"index.php?op=100&sop=5\" method=\"post\">";
			echo "<br><br>";
			echo "<table>";
			echo "<tr><td><strong>*Dirección e-mail.</strong><br>La que usaste para el registro.</td><td style=\"vertical-align : middle;\"><input type=\"text\" name=\"mail\" class=\"px200\">*</td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Recuperar\" class=\"px150\"></td></tr>";
			echo "</table>";
			echo "</form>";
			echo "<br>* Campos obligatorios.";
	}
	if ($soption == 5) {
		$registro = 1;
		$sql = "select count(*) aS total from sgm_users WHERE mail='".$_POST["mail"]."'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($row["total"] == 0) { echo "<br>Esta direccion e-mail no esta registrada."; $registro = 0; }
		if ($registro == 1 ) {
			$sql2 = "select * from sgm_users WHERE mail='".$_POST["mail"]."'";
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
			echo "<center><br>Se ha enviado un mail para la recuperación de password a : <strong>".$_POST["mail"]."</strong></center>";
		}
	}

}
?>
