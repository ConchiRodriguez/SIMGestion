<?php
error_reporting(~E_ALL);


function comprobarIdentificador($tipo_identificador,$nif)
{ 
	if (($tipo_identificador == 2) or ($tipo_identificador == 3) or ($tipo_identificador == 4)) { $check_nif = 1;} else { $check_nif = valida_nif_cif_nie($nif);}
	
	return $check_nif;
}

?>