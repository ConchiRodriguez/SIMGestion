<?php
error_reporting(~E_ALL);

function valida_nif_cif_nie($cif) {
	//returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad,-3 = NIE bad, 0 = ??? bad
	$cif=strtoupper($cif);
	if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/',$cif)) { return 0; }
	
	for ($i=0;$i<9;$i++) {$num[$i]=substr($cif,$i,1);}
	$suma=$num[2]+$num[4]+$num[6];
	
	for ($i=1;$i<8;$i+=2) {$suma+=substr((2*$num[$i]),0,1)+substr((2*$num[$i]),1,1);}
	$n=10-substr($suma,strlen($suma)-1,1);
	
	if (preg_match('/^[ABCDEFGHJNPQRSVW]{1}/',$cif)) {
		if ($num[8]==chr(64+$n) || $num[8]==substr($n,strlen($n)-1,1)) {return 2;} else {return -2;}
	}
	
	if (preg_match('/^[KLM]{1}/',$cif)) {
	if ($num[8]==chr(64+$n)) {return 2;} else {return -2;}}
	
	if (preg_match('/^[TX]{1}/',$cif)) {
	if ($num[8]==substr("TRWAGMYFPDXBNJZSQVHLCKE",substr(preg_replace('/X/','0',$cif),0,8)%23,1) || preg_match('/^[T]{1}[A-Z0-9]{8}$/',$cif)) {return 3;} else {return -3;}}
	
	if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/',$cif)) {
	if ($num[8]==substr("TRWAGMYFPDXBNJZSQVHLCKE",substr($cif,0,8)%23,1)) {return 1;} else {return -1;}}
	return 0;
}

?>