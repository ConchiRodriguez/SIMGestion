<?php
error_reporting(~E_ALL);

$email='soporte@solucions-im.com';

$domain = explode('@', $email);   
if (checkdnsrr($domain[1])){
	echo "Dominio de la dirección válida"; 
}   


?>