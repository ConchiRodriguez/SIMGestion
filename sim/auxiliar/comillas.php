<?php
error_reporting(~E_ALL);

function comillasInver($cadena) {
#	$cadena = str_replace("\r\n", "<br>", $cadena);
	$cadena = str_replace("&#39;","'", $cadena);
	return $cadena;
}

function comillas($cadena) {
#	$cadena = str_replace("\r\n", "<br>", $cadena);
	$cadena = str_replace("'", "&#39;", $cadena);
	$cadena = str_replace(" /", " -/", $cadena);

	return $cadena;
}

?>