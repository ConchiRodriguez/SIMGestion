<?php
error_reporting(~E_ALL);


function cambiarFormatoFechaYMD($fecha){
	list($dia,$mes,$any)=explode("-",$fecha);
	return $any."-".$mes."-".$dia;
}

function cambiarFormatoFechaDMY($fecha){
	list($any,$mes,$dia)=explode("-",$fecha);
	return $dia."-".$mes."-".$any;
}

?>