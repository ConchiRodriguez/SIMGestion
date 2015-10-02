<?php
echo $Ajuda_plataforma24."<br><br>";
echo "<table width=\"100%\">";
if ($_GET["ml"]== 1){
	if (isset($_POST["nombre"]) and isset($_POST["apellido1"]) and isset($_POST["apellido2"]) and isset($_POST["email"]) and isset($_POST["telefono"]) and isset($_POST["empresa"]) and isset($_POST["direccion"]) and isset($_POST["poblacion"]) and isset($_POST["provincia"]) and ($_POST["privacidad"] == true)){
#		send_mail($_POST["nombre"],$_POST["apellido1"],$_POST["apellido2"],$_POST["email"],$_POST["telefono"],$_POST["empresa"],$_POST["direccion"],$_POST["poblacion"],$_POST["provincia"]);
	} else {
		if ($_POST["privacidad"] == true) {
			echo "<tr><td></td><td style=\"text-aling:center;\"><font color=\"red\">".$campos_oblig."</font></td></tr>";
		} else {
			echo "<tr><td></td><td style=\"text-aling:center;\"><font color=\"red\">".$campos_oblig2."</font></td></tr>";
		}
	}
}
	echo "<form name=\"formulario\" action=\"index.php?mn=600&ml=1\" method=\"post\">";
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
#	echo "<tr><td>&nbsp;</td></tr>";
#	echo "<tr>";
#		echo "<td class=\"presupost\"><strong>".$Datos_tecnicos."</strong></td>";
#		echo "<td class=\"presupost2\"></td>";
#	echo "</tr>";

	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td class=\"presupost\"><input type=\"Checkbox\" name=\"privacidad\" value=\"true\"";
	if ($_POST["privacidad"] == true) { echo " checked"; }
	echo "></td><td class=\"presupost2\"><a href=\"index.php?lg=200\">".$Politica_de_privacidad."</a></td></tr>";
	echo "<tr><td></td><td><input class=\"presupost\" type=\"Submit\" value=\"".$Enviar."\"></td></tr>";
	echo "</form>";
echo "</table>";
echo "<br><br>";



function send_mail($remitente,$remite,$num_serv,$hosts,$servicios,$telefono){
	global $mail_enviado,$Servicios_interes,$Instalacion_migracion,$Monitorizacion_plataforma,$Gestion_incidencias,$Gestion_cambios,$Aviso_alertas;
	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$destinatario = "info@solucions-im.com";
	$titulo = "Solicitud de Presupuesto";
	$mensaje = "<html><head></head><body bgcolor=\"white\">";
	$mensaje .= "<font face=\"Verdana\" size=2>";
	$mensaje .= "Número de hosts: ".$hosts."<br><br>";
	$mensaje .= "Número de servicios: ".$num_serv."<br><br>";
	$mensaje .= $Servicios_interes."<br>";
	if (is_numeric($clave = array_search('instal', $servicios))) {$mensaje .= $Instalacion_migracion."<br>";}
	if (is_numeric($clave = array_search('monitor', $servicios))) {$mensaje .= $Monitorizacion_plataforma."<br>";}
	if (is_numeric($clave = array_search('incidencia', $servicios))) {$mensaje .= $Gestion_incidencias."<br>";}
	if (is_numeric($clave = array_search('cambio', $servicios))) {$mensaje .= $Gestion_cambios."<br>";}
	if (is_numeric($clave = array_search('alerta', $servicios))) {$mensaje .= $Aviso_alertas."<br>";}
	$mensaje .= "<br>Tel&eacute;fono: ".$telefono."<br><br>";
	$mensaje .= "</font>";

	$separador = "_separador_de_trozos_".md5 (uniqid (rand())); 
	$cabecera = "MIME-Version: 1.0".$UN_SALTO; 
	$cabecera .= "From: ".$remitente."<".$remite.">".$UN_SALTO;
	$cabecera .= "Return-path: ". $remite.$UN_SALTO;
	$cabecera .= "Reply-To: ".$remite.$UN_SALTO;
	$cabecera .="X-Mailer: PHP/". phpversion().$UN_SALTO;
	$cabecera .= "Content-Type: multipart/mixed;".$UN_SALTO; 
	$cabecera .= " boundary=".$separador."".$DOS_SALTOS; 

	$texto ="--".$separador."".$UN_SALTO; 
	$texto .="Content-Type: text/html; charset=\"ISO-8859-1\"".$UN_SALTO; 
	$texto .="Content-Transfer-Encoding: 7bit".$DOS_SALTOS; 
	$texto .= "Solucitud informacion web<br><br>";
	$texto .= $mensaje;

	if( mail($destinatario, $titulo, $texto, $cabecera)){
		echo "<tr><td></td><td>".$mail_enviado."</td></tr>";
	}

}
?>

