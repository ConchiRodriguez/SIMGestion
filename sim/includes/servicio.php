<?php
if ($option == 14) {
	if ($soption == 0) {
		$sql = "select * from sgm_articles_marcas order by marca";
		$result = $db->sql_query($sql);
		echo "<center><strong class=\"style2\">SERVICIO TÉCNICO</strong><br><br>";
		echo "<table cellpadding=\"5\"><tr><td class=\"style2\"><img src=\"images/E014068.jpg\"></td><td class=\"style2\" style=\"vertical-align:top;\">";
		echo "Nuestro servicio técnico lo forma un equipo preparado para asesorarle en el uso de nuestros productos, y dispuesto a resolver cualquier consulta técnica para ayudarle y apoyarle en su trabajo dirario.";
		echo "<br><br>Para ponerte en contacto con nuestro servicio técnico, dispones de las siguientes opciones :";
		echo "<br><br>Telf : 93 791 21 55";
		echo "<br><br>e-mail : <a href=\"mailto:sat@multivia.com\" class=\"style2\"><strong>sat@multivia.com</strong></a>";
		echo "<br><br>Formulario : <strong>¡ Haz \"click\" aqui !</strong>";

		echo "</td></tr></table></center>";
	}
}
?>