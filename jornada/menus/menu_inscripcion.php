<?php
echo "<b>".$FormularioInscripcion."</b><br><br>";
echo "<table class=\"cuerpo\">";
	if ($_GET["ml"]== 1){
		if (($_POST["nombre"] != "") and ($_POST["email"] != "") and ($_POST["empresa"] != "") and ($_POST["privacidad"] == true)){
			send_mail("Formulari Inscripcion",$_POST["nombre"],$_POST["email"],$_POST["empresa"],$_POST["departamento"],$_POST["cargo"]);
			$send_ok = 1;
		} else {
			if ($_POST["privacidad"] == true) {
				echo "<tr><td class=\"msg\">".$Ajuda_error."</td></tr>";
			} else {
				echo "<tr><td class=\"msg\">".$Ajuda_error2."</td></tr>";
			}
		}
	}
	if ($send_ok==0){
		echo "<form name=\"formulario\" action=\"index.php?mn=10&ml=1\" method=\"post\">";
		echo "<tr>";
			echo "<td class=\"form\">".$NombreyApellidos.":</td>";
			echo "<td class=\"form2\"><input type=\"text\" name=\"nombre\" class=\"form\" value=\"".$_POST["nombre"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"form\">".$Email.":</td>";
			echo "<td class=\"form2\"><input type=\"text\" name=\"email\" class=\"form\" value=\"".$_POST["email"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"form\">".$Empresa.":</td>";
			echo "<td class=\"form2\"><input type=\"text\" name=\"empresa\" class=\"form\" value=\"".$_POST["empresa"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"form\">".$Departamento.":</td>";
			echo "<td class=\"form2\"><input type=\"text\" name=\"departamento\" class=\"form\" value=\"".$_POST["departamento"]."\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class=\"form\">".$Cargo.":</td>";
			echo "<td class=\"form2\"><input type=\"text\" name=\"cargo\" class=\"form\" value=\"".$_POST["cargo"]."\"></td>";
		echo "</tr>";
		echo "<tr><td class=\"form\"><input type=\"Checkbox\" name=\"privacidad\" value=\"true\"";
		if ($_POST["privacidad"] == true) { echo " checked"; }
		echo "></td><td class=\"form2\"><a href=\"index.php?mn=99\" target=\"_blank\">".$Politica_de_privacidad."</a></td></tr>";
		echo "<tr><td></td><td><input type=\"Submit\" class=\"form\" value=\"".$Inscribir."\"></td></tr>";
		echo "</form>";
	}
echo "</table>";

?>

