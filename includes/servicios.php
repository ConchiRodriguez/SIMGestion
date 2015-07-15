<?php
if ($option == 201) {

	if ($soption == 0) {
		echo "<center><table cellspacing=\"10\" width=\"700\">";
			echo "<tr><td></td><td><strong>&raquo; SOLUCIONES GNU/LINUX</strong></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=1\"><strong>Configuración Firewall</strong></a><br>A partir de <strong>595€</strong><br>Controla y gestiona el uso de tus conexiones.<br><a href=\"index.php?op=201&sop=1\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=2\"><strong>Configuración Host</strong></a><br>A partir de <strong>995€</strong><br>Disfruta de la potencia de un servidor host propio.<br><a href=\"index.php?op=201&sop=2\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=3\"><strong>Configuración Wi-Fi</strong></a><br>A partir de <strong>1495€</strong><br>Ofrece internet a tus clientes o trabajadores.<br><a href=\"index.php?op=201&sop=3\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
			echo "<tr><td></td><td><strong>&raquo; SERVICIOS GENERALES</strong></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=4\">Provisión de hardware / Consumibles</a><br>Visita nuestra tienda on-line y nuestro extenso catálogo de productos.<br><a href=\"index.php?op=201&sop=4\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=5\">Consultoria / Software</a><br>Soluciones a todos los problemas. Desarrollo de aplicaciones con las últimas tecnologias.<br><a href=\"index.php?op=201&sop=5\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=6\">Mantenimiento / Internet</a><br>Profesionales a disposición de profesionales. Planes de alojamiento en internet.<br><a href=\"index.php?op=201&sop=6\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
			echo "<tr><td></td>";
			echo "<td style=\"text-align : justify;vertical-align : top;\"><a href=\"index.php?op=201&sop=7\">Formación</a><br>Formación presencial o la novedosa e-learning estan a disposción de nuestros clientes.<br><a href=\"index.php?op=201&sop=7\"><img src=\"images/theme-entrar.jpg\" vspace=\"3\" border=\"0\"></a></td></tr>";
		echo "</table></center>";
	}

	if ($soption == 1) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-firewall.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-firewall.html"); 
		echo "</center>";
		}

	if ($soption == 2) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-host.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-host.html"); 
		echo "</center>";
		}

	if ($soption == 3) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-wifi.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-wifi.html"); 
		echo "</center>";
		}

	if ($soption == 4) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-hard.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-hard.html"); 
		echo "</center>";
		}

	if ($soption == 5) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-soft.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-soft.html"); 
		echo "</center>";
		}

	if ($soption == 6) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-mantenimiento.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-mantenimiento.html"); 
		echo "</center>";
		}

	if ($soption == 7) { 
		echo "<br><br>&nbsp;&nbsp;<a href=\"includes/auxiliares/servicios-formacion.html\" target=\"_blank\">[ Versión imprimible ]</a>";
		echo "<br><br><center>";
		include ("includes/auxiliares/servicios-formacion.html"); 
		echo "</center>";
		}

}
?>
