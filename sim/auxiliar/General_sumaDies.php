<?php
error_reporting(~E_ALL);


function sumaDies($dia_actual,$num){
	$proxim_any = date("Y",$dia_actual);
	$proxim_mes = date("m",$dia_actual);
	$proxim_dia = date("d",$dia_actual);
	$dia_prox = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+$num,$proxim_any));
	return $dia_prox;
}

?>