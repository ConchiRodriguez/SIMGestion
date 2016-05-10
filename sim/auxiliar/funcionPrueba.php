<?php
error_reporting(~E_ALL);

function funcionPrueba($asun){

	//buscar en el asunto el codigo de incidencia del cliente
	preg_match('(INCMNG\\d+)',$asun,$codigo);

	return $codigo[0];
}

?>