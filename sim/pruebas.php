<?php

echo "HELLO!";
	$dbhandle = new mysqli('qnc882.dbname.net',"qnc882","Dominio5","qnc882");
	$db = mysqli_select_db($dbhandle, "qnc882") or die("Couldn't open database");

	$sqlcon = "select * from sgm_incidencias where id=22945";
	$resultcon = mysqli_query($dbhandle,$sqlcon);
	echo $sqlcon."<br>";
	$rowcon = mysqli_fetch_array($resultcon);
	$mensaje = $rowcon["notas_registro"];


	echo "<textarea cols=\"50\" rows=\"20\">".$mensaje."</textarea>";


	$mensaje = trim($mensaje,"' '\t\n\r\0\x0B");
	$mensaje = str_replace("</p>",,$mensaje);
#	$mensaje = str_replace("","\t",$mensaje);
	echo "<textarea cols=\"50\" rows=\"20\">".$mensaje."</textarea>";
?>
