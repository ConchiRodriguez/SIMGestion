<?php
error_reporting(~E_ALL);

/*
$tipo: 1=incidencia nueva, 2=nota de incidencia, 3=asignación de técnico, 4=cierre de incidencia;
*/


function enviarNotificacion($correo_remitente,$id,$codigo,$id_codigo_externo,$tipo){
	global $db,$dbhandle;

	$sqlm = "select * from sgm_incidencias where id=".$id;
	$resultm = mysqli_query($dbhandle,$sqlm);
	$rowm = mysqli_fetch_array($resultm);
	
	$asunto="[Solucions-IM]";
	if ($id != '') {$asunto.=" [SIM".$id."] ";}
	if ($codigo != '') { $asunto.= " ".$codigo;}
	if ($id_codigo_externo != '') { $asunto.= " ".$id_codigo_externo;}
	$asunto.=utf8_decode($rowm["asunto"]);
	$email="proves@solucions-im.net";
	if ($tipo == 1) {
		$cuerpo="<font face=\"Calibri\" size=4>**Aquest es un missatge autom&agrave;tic.**<br><br>";
		$cuerpo.="Hem rebut el seu e-mail i s'ha creat una incid&egrave;ncia que els nostres t&egrave;cnics gestionaran.<br><br>";

		$cuerpo.="Per facilitar mes informaci&oacute;, contesti aquest missatge.<br><br>";

		$cuerpo.="Id Incid&egrave;ncia: ".$id."<br>";
		$cuerpo.="Assumpte: ".utf8_decode($rowm["asunto"])."<br>";
		$cuerpo.="Data: ".date(DATE_RFC2822,$rowm["fecha_registro_inicio"])."<br>";
		$cuerpo.="Remitent: ".$correo_remitente."<br><br>";

		$cuerpo.="Gr&agrave;cies per contactar amb el departament de suport de Solucions-IM.</font><br>";
	} elseif ($tipo == 2){
		$cuerpo="<font face=\"Calibri\" size=4>**Aquest es un missatge autom&agrave;tic.**<br><br>";
		$cuerpo.="Hem rebut el seu e-mail amb informació adicional.<br><br>";

		$cuerpo.="Per facilitar mes informaci&oacute;, contesti aquest missatge.<br><br>";

		$cuerpo.="Id Incid&egrave;ncia: ".$id."<br>";
		$cuerpo.="Assumpte: ".utf8_decode($rowm["asunto"])."<br>";
		$cuerpo.="Data: ".date(DATE_RFC2822,$rowm["fecha_registro_inicio"])."<br>";
		$cuerpo.="Remitent: ".$correo_remitente."<br><br>";

		$cuerpo.="Gr&agrave;cies per contactar amb el departament de suport de Solucions-IM.</font><br>";
		
	}





	send_mail($correo_remitente,$asunto,$email,$cuerpo);
}

?>