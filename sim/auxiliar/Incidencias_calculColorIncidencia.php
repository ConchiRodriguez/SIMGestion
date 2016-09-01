<?php
error_reporting(~E_ALL);


function calculColorIncidencia ($temps_pendent){
	global $estado_color,$estado_color_letras;
	$horax = $temps_pendent/3600;
	$horas2 = explode(".",$horax);
	$minutox = (($horax - $horas2[0])*60);
	$minutos2 = explode(".",$minutox);
	$sla = "".$horas2[0]."h. ".$minutos2[0]."m.";
	if ($horas2[0] > 4){
			$estado_color = "White";
			$estado_color_letras = "";
	}
	if (($horas2[0] < 4) and ($horas2[0] >= 0)) {
			$estado_color = "Orange";
			$estado_color_letras = "";
	}
	if (($horas2[0] < 0) or ($minutos2[0] < 0)) {
		$estado_color = "Red";
		$estado_color_letras = "White";
	}
}

?>