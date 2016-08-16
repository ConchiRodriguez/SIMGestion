<?php
error_reporting(~E_ALL);

function funcionMANGO($asun){

	//buscar en el asunto el codigo de incidencia del cliente
	preg_match('(INCMNG\\d+)',$asun,$codigo);

	return $codigo[0];
}

?>