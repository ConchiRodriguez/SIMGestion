<?php
error_reporting(~E_ALL);

function enviarNotificacion(){
	global $db,$dbhandle;

	$sqlm = "select * from sgm_incidencias where fecha_inicio=".$data_missatge;
	$resultm = mysqli_query($dbhandle,$sqlm);
	$rowm = mysqli_fetch_array($resultm);
	
	$asunto="[Solucions-IM] [SIM - ".$rowm["id"]."] ".utf8_decode($rowm["asunto"]);
	$email="soporte@solucions-im";
	$cuerpo="<font face=\"Calibri\" size=4>**Aquest es un missatge autom&agrave;tic.**<br><br>";
	$cuerpo.="Hem rebut el seu e-mail i s'ha creat una incid&egrave;ncia que els nostres t&egrave;cnics gestionaran.<br><br>";

	$cuerpo.="Per facilitar mes informaci&oacute;, contesti aquest missatge.<br><br>";

	$cuerpo.="Id Incid&egrave;ncia: ".$rowm["id"]."<br>";
	$cuerpo.="Assumpte: ".utf8_decode($rowm["asunto"])."<br>";
	$cuerpo.="Data: ".date(DATE_RFC2822,$rowm["fecha_registro_inicio"])."<br>";
	$cuerpo.="Remitent: ".$correo_remitente."<br><br>";

	$cuerpo.="Gr&agrave;cies per contactar amb el departament de suport de Solucions-IM.</font><br>";

	send_mail($correo_remitente,$asunto,$email,$cuerpo);
}


function send_mail($destinatario,$asunto,$email,$cuerpo){
	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$titulo = $asunto;
	$mensaje = "<html><head></head><body bgcolor=\"white\">";
	$mensaje .= "<font face=\"Calibri\" size=4>";
	$mensaje .= $cuerpo;
	$mensaje .= "</font>";

	$separador = "_separador_de_trozos_".md5 (uniqid (rand())); 

	$cabecera = "MIME-Version: 1.0".$UN_SALTO; 
	$cabecera .= "From: Solucions-IM<".$email.">".$UN_SALTO;
	$cabecera .= "Return-path: ". $email.$UN_SALTO;
	$cabecera .= "Reply-To: ".$email.$UN_SALTO;
	$cabecera .= "X-Mailer: PHP/". phpversion().$UN_SALTO;
	$cabecera .= "X-Priority: 1".$UN_SALTO; 
	$cabecera .= "Content-Type: text/html; charset=UTF-8".$UN_SALTO; 
	$cabecera .= " boundary=".$separador."".$DOS_SALTOS; 

	mail($destinatario, $titulo, $mensaje, $cabecera);
}

?>