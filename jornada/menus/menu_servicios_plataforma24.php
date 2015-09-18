<?php
echo $Ajuda_plataforma24."<br><br>";
echo "<center>";
echo "<table width=\"80%\">";
if ($_GET["ml"]== 1){
	if (($_POST["nombre"] != "") and ($_POST["apellido1"] != "") and ($_POST["apellido2"] != "") and ($_POST["email"] != "") and ($_POST["telefono"] != "") and ($_POST["empresa"] != "") and ($_POST["direccion"] != "") and ($_POST["poblacion"] != "") and ($_POST["provincia"] != "") and (is_numeric($_POST["num_serv"])) and (is_numeric($_POST["num_host"])) and (isset($_POST["plataforma"])) and ($_POST["privacidad"] == true)){
		send_mail("Formulari 24 hores","",$_POST["nombre"],$_POST["apellido1"],$_POST["apellido2"],$_POST["email"],$_POST["telefono"],$_POST["empresa"],$_POST["direccion"],$_POST["poblacion"],$_POST["provincia"],$_POST["num_host"],$_POST["num_serv"],$_POST["plataforma"]);
		$send_ok = 1;
	} else {
		if ($_POST["privacidad"] == true) {
			if ((is_numeric($_POST["num_serv"])) and (is_numeric($_POST["num_host"]))){
				echo "<tr><td></td><td style=\"text-aling:center;\"><font color=\"red\">".$Ajuda_error."</font></td></tr>";
			} else {
				echo "<tr><td></td><td style=\"text-aling:center;\"><font color=\"red\">".$Ajuda_error3."</font></td></tr>";
			}
		} else {
			echo "<tr><td></td><td style=\"text-aling:center;\"><font color=\"red\">".$Ajuda_error2."</font></td></tr>";
				echo "<tr><td></td><td><a href=\"index.php?mn=220\">".$Volver."</a></td></tr>";
		}
	}
}
if ($send_ok==0){
	echo "<form name=\"formulario\" action=\"index.php?mn=220&ml=1\" method=\"post\">";
	echo "<tr>";
		echo "<td class=\"presupost\"><strong>".$Datos_contacto."</strong></td>";
		echo "<td class=\"presupost2\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Nombre.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"nombre\" value=\"".$_POST["nombre"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Apellido1.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"apellido1\" value=\"".$_POST["apellido1"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Apellido2.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"apellido2\" value=\"".$_POST["apellido2"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Email.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"email\" value=\"".$_POST["email"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Telefono.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"telefono\" value=\"".$_POST["telefono"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Empresa.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"empresa\" value=\"".$_POST["empresa"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Direccion.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"direccion\" value=\"".$_POST["direccion"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Poblacion.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"poblacion\" value=\"".$_POST["poblacion"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Provincia.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"provincia\" value=\"".$_POST["provincia"]."\"></td>";
	echo "</tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr>";
		echo "<td class=\"presupost\"><strong>".$Datos_tecnicos."</strong></td>";
		echo "<td class=\"presupost2\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">*".$Numero_host.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"num_host\" value=\"".$_POST["num_host"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\"></td>";
		echo "<td class=\"presupost3\">".$Ajuda_plataforma."</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">*".$Numero_serv.":</td>";
		echo "<td class=\"presupost2\"><input class=\"presupost\" type=\"text\" name=\"num_serv\" value=\"".$_POST["num_serv"]."\"></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\"></td>";
		echo "<td class=\"presupost3\">".$Ajuda_plataforma1."</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class=\"presupost\">".$Plataforma.":</td>";
		echo "<td class=\"presupost2\"><input type=\"radio\" name=\"plataforma\" value=\"nagios\"";
		if ($_POST["plataforma"] == "nagios") { echo " checked"; }
		echo ">Nagios Core</td>";
	echo "</tr><tr>";
		echo "<td class=\"presupost\"></td><td class=\"presupost2\"><input type=\"radio\" name=\"plataforma\" value=\"nagiosxi\"";
		if ($_POST["plataforma"] == "nagiosxi") { echo " checked"; }
		echo ">Nagios XI</td>";
	echo "</tr><tr>";
		echo "<td class=\"presupost\"></td><td class=\"presupost2\"><input type=\"radio\" name=\"plataforma\" value=\"op5\"";
		if ($_POST["plataforma"] == "op5") { echo " checked"; }
		echo ">Op5 Monitor</td>";
	echo "</tr><tr>";
		echo "<td class=\"presupost\"></td><td class=\"presupost2\"><input type=\"radio\" name=\"plataforma\" value=\"naemon\"";
		if ($_POST["plataforma"] == "naemon") { echo " checked"; }
		echo ">Naemon</td>";
	echo "</tr>";

	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td class=\"presupost\"><input type=\"Checkbox\" name=\"privacidad\" value=\"true\"";
	if ($_POST["privacidad"] == true) { echo " checked"; }
	echo "></td><td class=\"presupost2\"><a href=\"index.php?mn=99\" target=\"_blank\">".$Politica_de_privacidad."</a></td></tr>";
	echo "<tr><td></td><td><input class=\"presupost\" type=\"Submit\" value=\"".$Enviar."\"></td></tr>";
	echo "</form>";
}
echo "</table>";
echo "</center>";
echo "<br><br>";

?>

