<?php
if ($option == 203) {
	if ($soption == 0) {
		echo "<center>";
		echo "<table width=\"500\"><tr><td>";
			echo "<center><strong class=\"style2\" style=\"color : Navy;\">SERVICIO TÉCNICO</strong><br><br>";
				echo "<table>";
				echo "<tr>";
					echo "<td><img src=\"images/back_6.jpg\"></td><td style=\"vertical-align:top; background-color : #CACAFF; color:black; padding : 5px 5px 5px 5px; text-align:justify;\">";
					echo "Para contactar con nuestro personal o los respectivos departamentos, dispone de las siguientes opciones :";
					echo "<br><br>Telf : <font size=\"4\">902 431 941</font>";
					echo "<br>e-mail : <a href=\"mailto:info@multivia.com\" style=\"color:black\"><font size=\"4\">info@multivia.com</font></strong></a>";
					echo "<br><br>Tambien puede rellenar el siguiente formulario.";
					echo "</td>";
				echo "</tr>";
			echo "</table></center>";
		echo "</td></tr></table>";
		echo "<br><br>";
		echo "<form action=\"index.php?op=202&sop=1\" method=\"post\">";
			echo "<table>";
				echo "<tr><td style=\"text-align:right\">Destinatario</td><td>";
					echo "<select name=\"opcion\" style=\"width:300px;background-color : #CACAFF;\">";
						echo "<option value=\"Información General : info@multivia.com\">Información General : info@multivia.com</option>";
						echo "<option value=\"Servicio Atención Técnica : sat@multivia.com\">Servicio Atención Técnica : sat@multivia.com</option>";
						echo "<option value=\"Administración : administracion@multivia.com\">Administración : administracion@multivia.com</option>";
						echo "<option value=\"Dirección : direccion@multivia.com\">Dirección : direccion@multivia.com</option>";
						echo "<option value=\"Personales : jordi.espasa@multivia.com\">Personales : jordi.espasa@multivia.com</option>";
						echo "<option value=\"Personales : frank.espasa@multivia.com\">Personales : frank.espasa@multivia.com</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right\">Nombre de contacto</td><td><input type=\"Text\" name=\"nombre\" style=\"width:300px;background-color : #CACAFF;\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">Telf. de contacto</td><td><input type=\"Text\" name=\"telf\" style=\"width:300px;background-color : #CACAFF;\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">e-Mail de contacto</td><td><input type=\"Text\" name=\"mail\" style=\"width:300px;background-color : #CACAFF;\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Detalles</td><td><textarea name=\"detalles\" style=\"width:500px;background-color : #CACAFF;\" rows=\"10\"></textarea></td></tr>";
				echo "<tr><td style=\"text-align:right\"></td><td><input type=\"Submit\" value=\"Enviar formulario\" style=\"width:200px;background-color : #CACAFF;\"></td></tr>";
			echo "</table>";
		echo "</form>";
		echo "</center>";
	}
	
	if ($soption == 1) {
		echo "<center>";
		echo "<table width=\"500\"><tr><td>";
			echo "<center><strong class=\"style2\" style=\"color : #FFA500;\">SERVICIO TÉCNICO</strong><br><br>";
				echo "<table>";
				echo "<tr>";
					echo "<td><img src=\"images/E014068.jpg\"></td><td style=\"vertical-align:top; background-color : #FFC862; color:black; padding : 5px 5px 5px 5px; text-align:justify;\">";
					echo "Grácias por confiar en nuestro equipo. En breve contactaremso con usted.";
					echo "<br><br><br><center><font size=\"2\"><strong>El mensaje se ha mandado correctamente</strong></font></center>";
					echo "</td>";
				echo "</tr>";
			echo "</table></center>";
		echo "</td></tr></table>";
		echo "</center>";
		#ENVIO NOTIFICACIÓN
		$destino = $notify_from;
		$asunto = "Mensaje WEB de MULTIVIA : ".$_POST["opcion"];
		$mensaje = "Ha recibido un mail enviado desde la web : <strong>".$urloriginal."</strong>";
		$mensaje .= "<br><br>";
		$mensaje .= "<br><br>Nombre : ".$_POST["nombre"];
		$mensaje .= "<br>Telefono : ".$_POST["telf"];
		$mensaje .= "<br>e-Mail : ".$_POST["mail"];
		$mensaje .= "<br><br>Detalles : ".$_POST["detalles"];
		$mensaje .= "<br><br>No responda este mail.";
		$cabeceras = "From: ".$notify_from."\nX-Mailer: PHP/" . phpversion();
		$cabeceras .= "MIME-Version: 1.0\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
		mail($destino, $asunto, $mensaje, $cabeceras);
	}

}
?>