<?php
if ($option == 303) {

	if ($soption == 0) {
		echo "<br><center><strong>BOLSA DE TRABAJO</strong></center><br>";
		echo "Si estas interesado/a en trabajar con nosotros puedes dejarnos tu curriculum en la siguiente dirección de correo electrónico : <a href=\"mailto:rrhh@multivia.com\">rrhh@multivia.com</a>";
		$date = getdate();
		if ($date["mday"] < 10) { $z = "0".$date["mday"]; }	else {$z = $date["mday"]; }
		if ($date["mon"] < 10) { $y = "0".$date["mon"]; } else {$y = $date["mon"]; }
		echo "<br>En la tabla inferior puedes ver nuestras ofertas de trabajo actualizadas el dia : <strong>".$z."/".$y."/".$date["year"]."</strong>";
		echo "<br><br>";
		echo "<center><table bgcolor=\"#0058B0\">";
			echo "<tr>";
				echo "<td style=\"color: white;text-align:center;width:200px\"><strong>Puesto de trabajo</strong></td>";
				echo "<td style=\"color: white;text-align:center;width:300px\"\"><strong>Condiciones</strong></td>";
				echo "<td style=\"color: white;text-align:center;width:100px\"\"><strong>Localidad</strong></td>";
			echo "</tr>";
			echo "<tr style=\"border : 1px solid #0058B0; background-color : White;\">";
				echo "<td style=\"text-align:center;width:200px\">-</strong></td>";
				echo "<td style=\"text-align:center;width:300px\"\">-</td>";
				echo "<td style=\"text-align:center;width:100px\"\">-</td>";
			echo "</tr>";
		echo "</table></center>";
		}

}
?>
