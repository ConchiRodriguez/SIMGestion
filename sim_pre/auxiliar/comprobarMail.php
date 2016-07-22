<?php
error_reporting(~E_ALL);


function comprobarMail($mail){ 
	if (!ereg("^([a-zA-Z0-9._/\]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,10})$",$mail)){ 
		return FALSE; 
	} else { 
		return TRUE; 
	} 
}

?>