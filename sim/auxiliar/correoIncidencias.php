<?php
error_reporting(~E_ALL);

function correoIncidencias(){
	global $db,$dbhandle,$asunto;
	
	$asunto = '';
//Revisar si hay correo nuevo()
	extraerDatosEmail();
}

?>