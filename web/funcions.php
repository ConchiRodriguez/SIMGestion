<?php

function send_mail($asunto,$cuerpo,$nombre,$apellido1,$apellido2,$email,$telefono,$empresa,$direccion,$poblacion,$provincia,$plataforma,$hosts,$serveis){
	global $mail_enviado;
	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$destinatario = "administracion@solucions-im.com";
	$titulo = $asunto;
	$mensaje = "<html><head></head><body bgcolor=\"white\">";
	$mensaje .= "<font face=\"Verdana\" size=2>";
	$mensaje .= "Persona de contacto: ".$nombre." ".$apellido1." ".$apellido2."<br>";
	$mensaje .= "Datos contacto: ".$telefono." ".$email."<br>";
	$mensaje .= "Empresa: ".$empresa."<br>";
	$mensaje .= "Direccion empresa: ".$direccion." ".$poblacion." (".$provincia.")<br><br>";
	$mensaje .= "Numero de Hosts: ".$hosts."<br>";
	$mensaje .= "Numero de servicios: ".$serveis."<br>";
	$mensaje .= "Plataforma: ".$plataforma."<br>";
	$mensaje .= "Texto : ".$cuerpo;
	$mensaje .= "</font>";

	$separador = "_separador_de_trozos_".md5 (uniqid (rand())); 
	$cabecera = "MIME-Version: 1.0".$UN_SALTO; 
	$cabecera .= "From: ".$nombre." ".$apellido1." ".$apellido2."<".$email.">".$UN_SALTO;
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
		echo "<tr><td></td><td>".$mail_enviado."</td></tr>";
	}

}

?>
