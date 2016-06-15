<?php
error_reporting(~E_ALL);

function send_mail($destinatario,$asunto,$email,$cuerpo){
	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$titulo = "=?ISO-8859-1?B?".base64_encode($asunto)."=?=";
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
	$cabecera .= "X-Priority: 3".$UN_SALTO; 
	$cabecera .= "Content-Type: text/html; charset=UTF-8".$UN_SALTO; 
	$cabecera .= " boundary=".$separador."".$DOS_SALTOS; 

	mail($destinatario, $titulo, $mensaje, $cabecera);
}

?>