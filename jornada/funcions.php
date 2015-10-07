<?php

function send_mail($asunto,$nombre,$email,$empresa,$departamento,$cargo){
	global $mail_enviado;
	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$destinatario = "jornada.sim@solucions-im.com";
	$titulo = $asunto;
	$mensaje = "<html><head></head><body bgcolor=\"white\">";
	$mensaje .= "<font face=\"Verdana\" size=2>";
	$mensaje .= "Nombre: ".$nombre."<br>";
	$mensaje .= "E-mail: ".$email."<br>";
	$mensaje .= "Empresa: ".$empresa."<br>";
	$mensaje .= "Departamento: ".$departamento."<br>";
	$mensaje .= "Cargo: ".$cargo."<br>";
	$mensaje .= "</font>";

	$separador = "_separador_de_trozos_".md5 (uniqid (rand())); 
	$cabecera = "MIME-Version: 1.0".$UN_SALTO; 
	$cabecera .= "From: ".$nombre."<".$email.">".$UN_SALTO;
	$cabecera .= "Return-path: ". $email.$UN_SALTO;
	$cabecera .= "Reply-To: ".$email.$UN_SALTO;
	$cabecera .= "X-Mailer: PHP/". phpversion().$UN_SALTO;
	$cabecera .= "Content-Type: multipart/mixed;".$UN_SALTO; 
	$cabecera .= " boundary=".$separador."".$DOS_SALTOS; 

	$texto ="--".$separador."".$UN_SALTO; 
	$texto .="Content-Type: text/html; charset=\"UTF-8\"".$UN_SALTO; 
	$texto .="Content-Transfer-Encoding: 7bit".$DOS_SALTOS; 
	$texto .= $asunto."<br><br>";
	$texto .= $mensaje;

	if( mail($destinatario, $titulo, $texto, $cabecera)){
		echo "<tr><td class=\"msg\">".$mail_enviado."</td></tr>";
	}

}

?>
