<?php
echo $Formulario_inscripcion."<br><br>";
echo "<center><table width=\"80%\">";
	if ($_GET["ml"]== 1){
		if (($_POST["nombre"] != "") and ($_POST["email"] != "") and ($_POST["telefono"] != "") and ($_POST["texto"] != "") and ($_POST["privacidad"] == true)){
			send_mail("Formulari Informacio",$_POST["texto"],$_POST["nombre"],"","",$_POST["email"],$_POST["telefono"],"","","","","","","");
			$send_ok = 1;
		} else {
			if ($_POST["privacidad"] == true) {
				echo "<tr><td></td><td><font color=\"red\" class=\"contacto2\">".$Ajuda_error."</font></td></tr>";
			} else {
				echo "<tr><td></td><td><font color=\"red\" class=\"contacto2\">".$Ajuda_error2."</font></td></tr>";
			}
		}
	}
	if ($send_ok==0){
		echo "<form name=\"formulario\" action=\"index.php?mn=520&ml=1\" method=\"post\">";
		echo "<tr>";
			echo "<td class=\"presupost\">".$Nombre.":</td>";
			echo "<td class=\"presupost2\"><input type=\"text\" name=\"nombre\" class=\"presupost\" value=\"".$_POST["nombre"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"presupost\">".$Email.":</td>";
			echo "<td class=\"presupost2\"><input type=\"text\" name=\"email\" class=\"presupost\" value=\"".$_POST["email"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"presupost\">".$Telefono.":</td>";
			echo "<td class=\"presupost2\"><input type=\"text\" name=\"telefono\" class=\"presupost\" value=\"".$_POST["telefono"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td></td><td class=\"presupost2\">".$Ajuda_info2."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"presupost\" valign=\"top\">".$Descripcion.":</td>";
			echo "<td class=\"presupost2\"><textarea name=\"texto\" rows=\"10\" cols=\"51\">".$_POST["texto"]."</textarea></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td></td><td class=\"presupost2\">".$Ajuda_info3."</td>";
		echo "</tr>";
		echo "<tr><td class=\"presupost\"><input type=\"Checkbox\" name=\"privacidad\" value=\"true\"";
		if ($_POST["privacidad"] == true) { echo " checked"; }
		echo "></td><td class=\"presupost2\"><a href=\"index.php?mn=99\" target=\"_blank\">".$Politica_de_privacidad."</a></td></tr>";
		echo "<tr><td></td><td><input type=\"Submit\" class=\"presupost\" value=\"".$Enviar."\"></td></tr>";
		echo "</form>";
	}
echo "</table></center>";

?>

