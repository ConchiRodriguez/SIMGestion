<?php
if ($option == 202) {
	if ($soption == 0) {
		echo "<center>";
		echo "<table width=\"500\"><tr><td>";
			echo "<center><strong class=\"style2\" style=\"color : #FFA500;\">SERVICIO TÉCNICO</strong><br><br>";
				echo "<table>";
				echo "<tr>";
					echo "<td><img src=\"images/E014068.jpg\"></td><td style=\"vertical-align:top; background-color : #FFC862; color:black; padding : 5px 5px 5px 5px; text-align:justify;\">";
					echo "Nuestro servicio técnico lo forma un equipo preparado para asesorarle en el uso de nuestros productos, y dispuesto a resolver cualquier consulta técnica para ayudarle y apoyarle en su trabajo dirario.";
					echo "<br><br>Para ponerse en contacto con nuestro servicio técnico, dispone de las siguientes opciones :";
					echo "<br><br>Telf : <font size=\"4\">902 431 941</font>";
					echo "<br>e-mail : <a href=\"mailto:sat@multivia.com\" style=\"color:black\"><font size=\"4\">sat@multivia.com</font></strong></a>";
					echo "<br><br>Tambien puede rellenar el siguiente formulario.";
					echo "</td>";
				echo "</tr>";
			echo "</table></center>";
		echo "</td></tr></table>";
		echo "<br><br>";
		echo "<form action=\"index.php?op=202&sop=1\" method=\"post\">";
			echo "<table>";
				echo "<tr><td style=\"text-align:right\">Motivo del contacto</td><td>";
					echo "<select name=\"opcion\" style=\"width:300px;background-color : #FFC862;\">";
						echo "<option value=\"Consulta general\">Consulta general</option>";
						echo "<option value=\"Consulta de hardware\">Consulta de hardware</option>";
						echo "<option value=\"Consulta de software\">Consulta de software</option>";
						echo "<option value=\"Presupuesto\">Presupuesto</option>";
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right\">Nombre de contacto</td><td><input type=\"Text\" name=\"nombre\" style=\"width:300px;background-color : #FFC862;\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">Telf. de contacto</td><td><input type=\"Text\" name=\"telf\" style=\"width:300px;background-color : #FFC862;\"></td></tr>";
				echo "<tr><td style=\"text-align:right\">e-Mail de contacto</td><td><input type=\"Text\" name=\"mail\" style=\"width:300px;background-color : #FFC862;\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\">Detalles</td><td><textarea name=\"detalles\" style=\"width:500px;background-color : #FFC862;\" rows=\"10\"></textarea></td></tr>";
				echo "<tr><td style=\"text-align:right\"></td><td><input type=\"Submit\" value=\"Enviar formulario\" style=\"width:200px;background-color : #FFC862;\"></td></tr>";
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
		$mensaje .= "<br>Telefono : ".$_POST["mail"];
		$mensaje .= "<br><br>Detalles : ".$_POST["detalles"];
		$mensaje .= "<br><br>No responda este mail.";
		$cabeceras = "From: ".$notify_from."\nX-Mailer: PHP/" . phpversion();
		$cabeceras .= "MIME-Version: 1.0\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
		mail($destino, $asunto, $mensaje, $cabeceras);
	}

}
?>