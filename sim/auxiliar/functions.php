<?php

function ver_mail($texto,$id_fact,$x) {
	$texto = str_replace("[b]","<strong>", $texto);
	$texto = str_replace("[/b]","</strong>", $texto);
	$texto = str_replace("[i]","<em>", $texto);
	$texto = str_replace("[/i]","</em>", $texto);
	$texto = str_replace("[u]","<font style=\"text-decoration : underline;\">", $texto);
	$texto = str_replace("[/u]","</font>", $texto);
	$texto = str_replace("[c]","<center>", $texto);
	$texto = str_replace("[/c]","</center>", $texto);
	$texto = str_replace(chr(13),"<br>", $texto);
	$texto = str_replace("[img]","<img src=\"", $texto);
	$texto = str_replace("[/img]","\">", $texto);

	$sqlf = "select * from sgm_cabezera where visible=1 and id=".$_GET["id_fact"];
	$resultf = mysql_query(convertSQL($sqlf));
	$rowf = mysql_fetch_array($resultf);
	$texto = str_replace("[pedido]",$rowf["numero_cliente"], $texto);
	$texto = str_replace("[orden]",$rowf["numero"], $texto);

	$sqlc = "select * from sgm_cuerpo where idfactura=".$id_fact;
	$resultc = mysql_query(convertSQL($sqlc));
	while ($rowc = mysql_fetch_array($resultc)){
		$fechas .= $rowc["fecha_prevision"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rowc["fecha_prevision_propia"]."<br>";
	}
	$texto = str_replace("[fechas]",$fechas, $texto);
	return $texto; 
}

function ver_carta($texto,$id_client,$x) {
	$texto = str_replace("[b]","<strong>", $texto);
	$texto = str_replace("[/b]","</strong>", $texto);
	$texto = str_replace("[i]","<em>", $texto);
	$texto = str_replace("[/i]","</em>", $texto);
	$texto = str_replace("[u]","<font style=\"text-decoration : underline;\">", $texto);
	$texto = str_replace("[/u]","</font>", $texto);
	$texto = str_replace("[c]","<center>", $texto);
	$texto = str_replace("[/c]","</center>", $texto);
	$texto = str_replace(chr(13),"<br>", $texto);
	$texto = str_replace("[img]","<img src=\"", $texto);
	$texto = str_replace("[/img]","\">", $texto);

	if ($x == 1){
		$sql = "select * from sgm_clients where id=".$id_client;
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);

		$texto = str_replace("[client]",$row["nombre"], $texto);
		$texto = str_replace("[cognom1]",$row["cognom1"], $texto);
		$texto = str_replace("[cognom2]",$row["cognom2"], $texto);
		$texto = str_replace("[nif]",$row["nif"], $texto);
		$texto = str_replace("[Adreça]",$row["direccion"], $texto);
		$texto = str_replace("[cp]",$row["cp"], $texto);
		$texto = str_replace("[poblacion]",$row["poblacion"], $texto);
		$texto = str_replace("[provincia]",$row["provincia"], $texto);

		$sqlp = "select * from sys_naciones where CodigoNacion=".$row["id_pais"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);

		$texto = str_replace("[pais]",$rowp["Nacion"], $texto);
		$texto = str_replace("[mail]",$row["mail"], $texto);
		$texto = str_replace("[web]",$row["web"], $texto);
		$texto = str_replace("[telefon1]",$row["telefono"], $texto);
		$texto = str_replace("[telefon2]",$row["telefono2"], $texto);
		$texto = str_replace("[fax1]",$row["fax"], $texto);
		$texto = str_replace("[fax2]",$row["fax2"], $texto);

		$sqlc = "select * from sgm_clients_contactos where pred=1 and id_client=".$id_client;
		$resultc = mysql_query(convertSQL($sqlc));
		$rowc = mysql_fetch_array($resultc);

		$texto = str_replace("[nom]",$rowc["nombre"], $texto);
		$texto = str_replace("[apellido1]",$rowc["apellido1"], $texto);
		$texto = str_replace("[apellido2]",$rowc["apellido2"], $texto);
		$texto = str_replace("[trato]",$rowc["tracte"], $texto);
		$texto = str_replace("[cargo]",$rowc["carrec"], $texto);
		$texto = str_replace("[departament]",$rowc["departament"], $texto);
		$texto = str_replace("[secretari]",$rowc["secretari"], $texto);
		$texto = str_replace("[telefono]",$rowc["telefono"], $texto);
		$texto = str_replace("[fax]",$rowc["fax"], $texto);
		$texto = str_replace("[mail]",$rowc["mail"], $texto);
		$texto = str_replace("[movil]",$rowc["movil"], $texto);
	}
	if ($x == 2){
		$sqlc = "select * from sgm_clients_contactos where id=".$id_client;
		$resultc = mysql_query(convertSQL($sqlc));
		$rowc = mysql_fetch_array($resultc);

		$texto = str_replace("[nom]",$rowc["nombre"], $texto);
		$texto = str_replace("[apellido1]",$rowc["apellido1"], $texto);
		$texto = str_replace("[apellido2]",$rowc["apellido2"], $texto);
		$texto = str_replace("[trato]",$rowc["tracte"], $texto);
		$texto = str_replace("[cargo]",$rowc["carrec"], $texto);
		$texto = str_replace("[departament]",$rowc["departament"], $texto);
		$texto = str_replace("[secretari]",$rowc["secretari"], $texto);
		$texto = str_replace("[telefono]",$rowc["telefono"], $texto);
		$texto = str_replace("[fax]",$rowc["fax"], $texto);
		$texto = str_replace("[mail]",$rowc["mail"], $texto);
		$texto = str_replace("[movil]",$rowc["movil"], $texto);

		$sql = "select * from sgm_clients where id=".$rowc["id_client"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);

		$texto = str_replace("[client]",$row["nombre"], $texto);
		$texto = str_replace("[cognom1]",$row["cognom1"], $texto);
		$texto = str_replace("[cognom2]",$row["cognom2"], $texto);
		$texto = str_replace("[nif]",$row["nif"], $texto);
		$texto = str_replace("[Adreça]",$row["direccion"], $texto);
		$texto = str_replace("[cp]",$row["cp"], $texto);
		$texto = str_replace("[poblacion]",$row["poblacion"], $texto);
		$texto = str_replace("[provincia]",$row["provincia"], $texto);

		$sqlp = "select * from sys_naciones where CodigoNacion=".$row["id_pais"];
		$resultp = mysql_query(convertSQL($sqlp));
		$rowp = mysql_fetch_array($resultp);

		$texto = str_replace("[pais]",$rowp["Nacion"], $texto);
		$texto = str_replace("[mail]",$row["mail"], $texto);
		$texto = str_replace("[web]",$row["web"], $texto);
		$texto = str_replace("[telefon1]",$row["telefono"], $texto);
		$texto = str_replace("[telefon2]",$row["telefono2"], $texto);
		$texto = str_replace("[fax1]",$row["fax"], $texto);
		$texto = str_replace("[fax2]",$row["fax2"], $texto);

	}
	return $texto; 
}

function ver_contacto_mailing($id,$color,$contactes,$check) {
	global $db;
	$sql = "select * from sgm_clients where visible=1 and id=".$id;
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);
	echo "<tr style=\"background-color:".$color."\">";
		echo "<td></td>";
		if (strlen($row["nombre"]) > 50) { 
			echo "<td style=\"padding-left:".$distancia."px;font-weight:".$letra.";\">".substr($row["nombre"],0,49)." ...</td><td></td>";
		} else {
			echo "<td style=\"padding-left:".$distancia."px;font-weight:".$letra.";\">".$row["nombre"]."</td><td></td>";
		}
			if (($check == 1) or ($check != "")){
				echo "<td><input type=\"Checkbox\" id=\"chequea\" name=\"enviar[]\" value=\"0\"></td>";
			}
			if (($check == 1) or ($check == "")){
				echo "<td><input type=\"Checkbox\" id=\"chequea\" name=\"enviar[]\" value=\"".$row["id"]."\" checked></td>";
			}
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=1&id=".$row["id"]."&x=1\"><img src=\"mgestion/pics/icons-mini/page_white_world.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=2&id=".$row["id"]."&x=1\"><img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=160&id=".$row["id"]."&x=1\"><img src=\"mgestion/pics/icons-mini/vcard.png\" border=\"0\"></a></td>";
	echo "</tr>";
	if ($contactes == 1) {
		$sql = "select * from sgm_clients_contactos where visible=1 and id_client=".$id;
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)){
			echo "<tr><td></td><td style=\"padding-left:15px;\">".$row["nombre"]."</td><td>".$row["departament"]."</td>";
			if (($check == 1) or ($check != "")){
				echo "<td><input type=\"Checkbox\" id=\"chequea_perso\" name=\"enviar_perso[]\" value=\"0\"></td>";
			}
			if (($check == 1) or ($check == "")){
				echo "<td><input type=\"Checkbox\" id=\"chequea_perso\" name=\"enviar_perso[]\" value=\"".$row["id"]."\" checked></td>";
			}
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=1&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/page_white_world.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=2&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=160&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/vcard.png\" border=\"0\"></a></td>";
			echo "</tr>";
		}
	}
	if ($contactes == 2) {
		$sql = "select count(*) as total from sgm_clients_contactos where visible=1 and pred=1 and id_client=".$id;
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] > 0) {
			$sql = "select * from sgm_clients_contactos where visible=1 and pred=1 and id_client=".$id;
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			echo "<tr><td></td><td style=\"padding-left:15px;\">".$row["nombre"]."</td><td>".$row["departament"]."</td>";
				if (($check == 1) or ($check != "")){
					echo "<td><input type=\"Checkbox\" id=\"chequea_perso\" name=\"enviar_perso[]\" value=\"0\"></td>";
				}
				if (($check == 1) or ($check == "")){
					echo "<td><input type=\"Checkbox\" id=\"chequea_perso\" name=\"enviar_perso[]\" value=\"".$row["id"]."\" checked></td>";
				}
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=1&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/page_white_world.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=2&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=160&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/vcard.png\" border=\"0\"></a></td>";
			echo "</tr>";
		}
	}
}

function comprovar_ip($ip,$id) 
{ 
	global $db;
	$acceso = false;
	$accesolocal = false;

	### BUSCA SI ES UNA IP LOCAL
	$sqlt = "select * from sgm_sys_ip_local";
	$resultt = mysql_query(convertSQL($sqlt));
	while ($rowt = mysql_fetch_array($resultt)) {
		$accesoip = false;
		$x = 0;
		for ($x = 0 ; $x < strlen($rowt["subxarxa"]) ; $x++) {
			if ($ip[$x] == $rowt["subxarxa"][$x]) { $accesoip = true ; } else { $accesoip = false ; }
		}
		if ($accesoip == true) { $accesolocal = true; }
	}

	### BUSCA EN LA BASE DE DATOS SI DISPONEMOS DE RESTRICCIONES DE IP EN FUNCION DEL ACCESO

	if ($accesolocal == true) { $sqlt = "select count(*) as total from sgm_users_ips where id_user=".$id." AND vigente=1 AND remota=0"; }
	if ($accesolocal == false) { $sqlt = "select count(*) as total from sgm_users_ips where id_user=".$id." AND vigente=1 AND remota=1"; }

	$resultt = mysql_query(convertSQL($sqlt));
	$rowt = mysql_fetch_array($resultt);

	if ($rowt["total"] == 0) {
		$acceso = true;
	} else {

		if ($accesolocal == true) { $sqlt2 = "select count(*) as total from sgm_users_ips where ip='".$ip."' AND id_user=".$id." AND vigente=1 AND remota=0"; }
		if ($accesolocal == false) { $sqlt2 = "select count(*) as total from sgm_users_ips where ip='".$ip."' AND id_user=".$id." AND vigente=1 AND remota=1"; }
		$resultt2 = mysql_query(convertSQL($sqlt2));
		$rowt2 = mysql_fetch_array($resultt2);

		if ($rowt2["total"] > 0) {
			$acceso = true;
		}


	}


	return $acceso;
}

function hora($hora) {
	$horaok = date("H:i", strtotime($hora));
	return $horaok; 
}

function fecha($fecha) {
	if (0 == date("w", strtotime($fecha))) { $fechaok = "Domingo "; }
	if (1 == date("w", strtotime($fecha))) { $fechaok = "Lunes "; }
	if (2 == date("w", strtotime($fecha))) { $fechaok = "Martes "; }
	if (3 == date("w", strtotime($fecha))) { $fechaok = "Miercoles "; }
	if (4 == date("w", strtotime($fecha))) { $fechaok = "Jueves "; }
	if (5 == date("w", strtotime($fecha))) { $fechaok = "Viernes "; }
	if (6 == date("w", strtotime($fecha))) { $fechaok = "Sabado "; }
	$fechaok = $fechaok.date("d-m-y", strtotime($fecha));
	return $fechaok; 
}

function fechacorta($fecha) {
	$fechaok = date("d-m-y", strtotime($fecha));
	return $fechaok; 
}

function fechalarga($fecha) {
	if (0 == date("w", strtotime($fecha))) { $fechaok = "Domingo "; }
	if (1 == date("w", strtotime($fecha))) { $fechaok = "Lunes "; }
	if (2 == date("w", strtotime($fecha))) { $fechaok = "Martes "; }
	if (3 == date("w", strtotime($fecha))) { $fechaok = "Miercoles "; }
	if (4 == date("w", strtotime($fecha))) { $fechaok = "Jueves "; }
	if (5 == date("w", strtotime($fecha))) { $fechaok = "Viernes "; }
	if (6 == date("w", strtotime($fecha))) { $fechaok = "Sabado "; }
	$fechaok = $fechaok.date("j", strtotime($fecha));
	if (1 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Enero "; }
	if (2 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Febrero "; }
	if (3 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Marzo "; }
	if (4 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Abril "; }
	if (5 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Mayo "; }
	if (6 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Junio "; }
	if (7 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Julio "; }
	if (8 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Agosto "; }
	if (9 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Septiembre "; }
	if (10 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Octubre "; }
	if (11 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Noviembre "; }
	if (12 == date("n", strtotime($fecha))) { $fechaok = $fechaok." Diciembre "; }
	$fechaok = $fechaok.date("Y", strtotime($fecha));
	return $fechaok; 
}

function verpost($texto) 
{ 
	$texto = str_replace("<","|", $texto);
	$texto = str_replace(">","|", $texto);
	$texto = str_replace("[b]","<strong>", $texto);
	$texto = str_replace("[/b]","</strong>", $texto);
	$texto = str_replace("[i]","<em>", $texto);
	$texto = str_replace("[/i]","</em>", $texto);
	$texto = str_replace("[u]","<font style=\"text-decoration : underline;\">", $texto);
	$texto = str_replace("[/u]","</font>", $texto);
	$texto = str_replace("[c]","<center>", $texto);
	$texto = str_replace("[/c]","</center>", $texto);
	$texto = replaceUrl($texto);
	$texto = ereg_replace("[[:alnum:]]*\@[[:alnum:]]*.[[:alnum:]]{2,4}","<a href=\"mailto:\\0\">\\0</a>", $texto);
	$texto = str_replace("[img]","<img src=\"", $texto);
	$texto = str_replace("[/img]","\">", $texto);
	$texto = str_replace(chr(13),"<br>", $texto);

	$texto = str_replace("[80]","<img src=\"pics/smiles/bigeek.gif\">", $texto);
	$texto = str_replace("[|D]","<img src=\"pics/smiles/biggrin.gif\">", $texto);
	$texto = str_replace("[|)]","<img src=\"pics/smiles/bigrazz.gif\">", $texto);
	$texto = str_replace("[8)]","<img src=\"pics/smiles/cool.gif\">", $texto);
	$texto = str_replace("[:(]","<img src=\"pics/smiles/cry.gif\">", $texto);
	$texto = str_replace("[xp]","<img src=\"pics/smiles/dead.gif\">", $texto);
	$texto = str_replace("[x)]","<img src=\"pics/smiles/fight.gif\">", $texto);
	$texto = str_replace("[xD]","<img src=\"pics/smiles/laugh.gif\">", $texto);
	$texto = str_replace("[:<]","<img src=\"pics/smiles/mad.gif\">", $texto);
	$texto = str_replace("[]:|]","<img src=\"pics/smiles/new_evil.gif\">", $texto);
	$texto = str_replace("[:[]","<img src=\"pics/smiles/no.gif\">", $texto);
	$texto = str_replace("[:|]","<img src=\"pics/smiles/none.gif\">", $texto);
	$texto = str_replace("[:·D]","<img src=\"pics/smiles/nuts.gif\">", $texto);
	$texto = str_replace("[9)]","<img src=\"pics/smiles/rolleyes.gif\">", $texto);
	$texto = str_replace("[y)]","<img src=\"pics/smiles/yes.gif\">", $texto);
	$texto = str_replace("[*:(]","<img src=\"pics/smiles/sigh.gif\">", $texto);
	$texto = str_replace("[zzz]","<img src=\"pics/smiles/sleep.gif\">", $texto);
	$texto = str_replace("[;)]","<img src=\"pics/smiles/smilewinkgrin.gif\">", $texto);
	$texto = str_replace("[6)]","<img src=\"pics/smiles/smiley54.gif\">", $texto);
	$texto = str_replace("[#:[]","<img src=\"pics/smiles/upset.gif\">", $texto);
	return $texto; 
}

function replaceUrl($message) {
   // Make link from [url]htp://.... [/url] or [url=http://.... ]text[/url]
   while(strpos($message, "[url")!==false){
       $begUrl = strpos($message, "[url");
       $endUrl = strpos($message, "[/url]");
       $url = substr($message, $begUrl, $endUrl-$begUrl+6);
       $posBracket = strpos($url, "]");
  
       if ($posBracket != null){
           if ($posBracket == 4){ 
               // [url]http://.... [/url]
               $link        = substr($url, 5, $endUrl - $begUrl -5);
               $htmlUrl    = "<a href=$link target='_blank'>$link</A>";
           } else {          
               // [url=http://....]text[/url]
               $link        = substr($url, 5, $posBracket-5);
               $text        = substr($url, $posBracket+1, strpos($url, "[/url]") - $posBracket-1);
               $htmlUrl    = "<a href=$link target='main'>$text</A>";
           }
       }
             
       $message = str_replace($url, $htmlUrl, $message);
       // searches for other [url]-nodes
   }
   return $message;
} 

function ocultar($texto) 
{ 
	$texto = str_replace("@", "#", $texto); 
	return $texto; 
} 


function DateToQuotedMySQLDate($Fecha) 
{ 
if ( $Fecha<>"" ){ 
   $trozos=explode("/",$Fecha,3); 
   return "'".$trozos[2]."-".$trozos[1]."-".$trozos[0]."'"; } 
else { return "NULL"; } 
} 

function MySQLDateToDate($MySQLFecha) 
{ 
if (( $MySQLFecha == "" ) or ( $MySQLFecha == "0000-00-00" ) ) { return ""; } 
else { return date("d/m/Y",strtotime($MySQLFecha)); } 
}

function potencia(){
	if(func_num_args() == 1){
		$x = func_get_arg(0);
		return $x * $x; }
	else if(func_num_args() == 2){
		$x = func_get_arg(0);
		$n = func_get_arg(1);
		return pow($x, $n); }
}

function mes($year,$mes) { 
	### parametros configurables
	$fiestalunes = false;
	$fiestamartes = false;
	$fiestamiercoles = false;
	$fiestajueves = false;
	$fiestaviernes = false;
	$fiestasabado = true;
	$fiestadomingo = true;
	global $db;
		$a = $year;
		$m = $mes;
		$d = 1;
		$programada = 1;
		$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$totaldiasmes = 31;
			if ($mes == 1) { $mesesp = "Enero"; }
			if ($mes == 2) { 
				$mesesp = "Febrero";
				if (checkdate(2, 29, $a)) { $totaldiasmes = 29; } else { $totaldiasmes = 28; }
			}
			if ($mes == 3) { $mesesp = "Marzo"; }
			if ($mes == 4) { $mesesp = "Abril"; $totaldiasmes--; }
			if ($mes == 5) { $mesesp = "Mayo"; }
			if ($mes == 6) { $mesesp = "Junio"; $totaldiasmes--;}
			if ($mes == 7) { $mesesp = "Julio"; }
			if ($mes == 8) { $mesesp = "Agosto"; }
			if ($mes == 9) { $mesesp = "Septiembre"; $totaldiasmes--; }
			if ($mes == 10) { $mesesp = "Octubre"; }
			if ($mes == 11) { $mesesp = "Noviembre"; $totaldiasmes--; }
			if ($mes == 12) { $mesesp = "Diciembre"; }
		$semananum = 0;
		$mesok = "<br><strong>".$mesesp."</strong> (".$totaldiasmes.")";
		$mesok .= "<table><tr>";
		$sumadias = 0;
		$diasemana = 1;
		$semanax = 0;

		$control = 0;

		while (($d < 32) and ($mes == $m)) {

			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) { $diasemana = 7; }

			$semana = date("W", mktime(0,0,0,$m ,$d, $a));
			if ($mes != $mesanterior) {
				$mesok .= "<td style=\"text-align:center\">Lunes</td>";
				$mesok .= "<td style=\"text-align:center\">Martes</td>";
				$mesok .= "<td style=\"text-align:center\">Miercoles</td>";
				$mesok .= "<td style=\"text-align:center\">Jueves</td>";
				$mesok .= "<td style=\"text-align:center\">Viernes</td>";
				$mesok .= "<td style=\"text-align:center\">Sabado</td>";
				$mesok .= "<td style=\"text-align:center\">Domingo</td>";
				$mesok .= "</tr><tr>";
			}
			if ($semana != $semanaanterior) {
				$semananum++;
				$mesok .= "</tr><tr>";
			}
			if ($semanax == 0) { 
				if ($diasemana == 7) { $mesok .= "<td></td><td></td><td></td><td></td><td></td><td></td>"; $sumadias = 6;}
				if ($diasemana == 6) { $mesok .= "<td></td><td></td><td></td><td></td><td></td>"; $sumadias = 5;}
				if ($diasemana == 5) { $mesok .= "<td></td><td></td><td></td><td></td>"; $sumadias = 4;}
				if ($diasemana == 4) { $mesok .= "<td></td><td></td><td></td>"; $sumadias = 3;}
				if ($diasemana == 3) { $mesok .= "<td></td><td></td>"; $sumadias = 2;}
				if ($diasemana == 2) { $mesok .= "<td></td>"; $sumadias = 1;}
				if ($diasemana == 1) { $mesok .= ""; $sumadias = 0;}
				$semanax = 1;
			}

			######### COLOR DEL FONDO DEL CALENDARIO
			$date = getdate();
			if ($date["mday"] < 10) { $z = "0".$date["mday"]; }	else {$z = $date["mday"]; }
			if ($date["mon"] < 10) { $y = "0".$date["mon"]; } else {$y = $date["mon"]; }
			$hoy = $date["year"]."-".$y."-".$z;
			if ($fecha == $hoy) {
				$mesok .= "<td style=\"text-align:center;width:80px;background-color:#FFCC33;vertical-align:top;color:black;border:1px Black Solid;height:50px;\">";
			}
			else {
				if ((($diasemana == 1) AND ($fiestalunes == true)) OR (($diasemana == 2) AND ($fiestamartes == true)) OR (($diasemana == 3) AND ($fiestamiercoles == true)) OR (($diasemana == 4) AND ($fiestajueves == true)) OR (($diasemana == 5) AND ($fiestaviernes == true)) OR (($diasemana == 6) AND ($fiestasabado == true)) OR (($diasemana == 7) AND ($fiestadomingo == true))) {
					$mesok .= "<td style=\"text-align:center;width:80px;background-color:red;vertical-align:top;color:white;border : 1px Black Solid;height:50px;\">";
				}
				else {
					$mesok .= "<td style=\"text-align:center;width:80px;background-color:#EEEEEE;vertical-align:top;border : 1px Black Solid;height:50px;\">";
				}
			}
			if ($d < 15) {
				if ($semananum == 1) { $programada = $d + $sumadias; }
				if ($semananum > 1) { 
					if ($diasemana <= $sumadias) { $programada = $d + $sumadias - 7; } else { $programada = $d + $sumadias;	}
				}
			}
			if (($totaldiasmes - $d) < 14) {
				if ($control == 0) {
					if ($diasemana == 7) { $diacorte = 7; }
					if ($diasemana == 6) { $diacorte = 6; }
					if ($diasemana == 5) { $diacorte = 5; }
					if ($diasemana == 4) { $diacorte = 4; }
					if ($diasemana == 3) { $diacorte = 3; }
					if ($diasemana == 2) { $diacorte = 2; }
					if ($diasemana == 1) { $diacorte = 1; }
					$control = 1;
					$semanainicio = $semananum;
				}
				if ($semananum == $semanainicio) { 
					if ($diasemana >= $diacorte) { $programada = 14 + $diasemana;} 
				}
				if ($semananum == ($semanainicio+1)) { 
					if ($diasemana >= $diacorte) { $programada = 21 + $diasemana;} else { $programada = 14 + $diasemana;} 
				}
				if ($semananum == ($semanainicio+2)) { 
					if ($diasemana <= $diacorte) { $programada = 21 + $diasemana;} 
				}
			}
				$mesok .= "<strong style=\"font-size:12px;font-family :\"Arial Black\";\">".$d."</strong>";
				$sql = "select count(*) as total from sgm_incidencias where (data_prevision like '%".$fecha."%') and programada=0";
				$result = mysql_query(convertSQL($sql));
				$row = mysql_fetch_array($result);
					$tareas = $row["total"];
				if ($programada != 0) {
					$sql = "select count(*) as total from sgm_incidencias where programada=".$programada;
					$result = mysql_query(convertSQL($sql));
					$row = mysql_fetch_array($result);
						$tareas = $tareas + $row["total"];
				}
				$minutos = 0;
				if ($tareas > 0) {
					$mesok .= "<br><strong>".$tareas."</strong> Tareas";
						$sql = "select* from sgm_incidencias where (data_prevision like '%".$fecha."%') and programada=0";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							$minutos = $minutos + $row["tiempo"];
						}
						$sql = "select * from sgm_incidencias where programada=".$programada;
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							$minutos = $minutos + $row["tiempo"];
						}
					$mesok .= "<br><strong>".$minutos."</strong> Minutos";
				}
			$mesok .= "</td>";
			$d++;
			$programada = 0;
			$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$mes = date("m", mktime(0,0,0,$m ,$d, $a));
			$semanaanterior = $semana;
			$mesanterior = $mes;
		}
		$mesok .= "</tr></table>";
	return $mesok; 
}

function agenda_mes($dia_select,$year,$mes,$usuario) { 
	global $db;
		$a = $year;
		$m = $mes;
		$d = 1;

	### emes / eany <- mes i any anterios
	### dmes / dany <- mes i anys posteriors
	if ($m == 1) { 
		$emes = 12;
		$eany = $a-1;
	} else {
		$emes = $mes-1;
		if ($emes < 10) { $emes = "0".$emes; }
		$eany = $a;
	}
	if ($m == 12) {
		$dmes = "01";
		$dany = $a+1;
	} else { 
		$dmes = $mes+1;
		if ($dmes < 10) { $dmes = "0".$dmes; }
		$dany = $a;
	}


		$programada = 1;
		$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$totaldiasmes = 31;
			if ($mes == 1) { $mesesp = "Enero"; }
			if ($mes == 2) { 
				$mesesp = "Febrero";
				if (checkdate(2, 29, $a)) { $totaldiasmes = 29; } else { $totaldiasmes = 28; }
			}
			if ($mes == 3) { $mesesp = "Marzo"; }
			if ($mes == 4) { $mesesp = "Abril"; $totaldiasmes--; }
			if ($mes == 5) { $mesesp = "Mayo"; }
			if ($mes == 6) { $mesesp = "Junio"; $totaldiasmes--;}
			if ($mes == 7) { $mesesp = "Julio"; }
			if ($mes == 8) { $mesesp = "Agosto"; }
			if ($mes == 9) { $mesesp = "Septiembre"; $totaldiasmes--; }
			if ($mes == 10) { $mesesp = "Octubre"; }
			if ($mes == 11) { $mesesp = "Noviembre"; $totaldiasmes--; }
			if ($mes == 12) { $mesesp = "Diciembre"; }
		$semananum = 0;
		$mesok = "<table style=\"background-color:#4B53AF\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"text-align:center;;color:white;\">";

		$mesok .= "<a href=\"index.php?op=1017&dd=".$dia_select."&aa=".($eany)."&mm=".($emes)."&usuario=".$usuario."\" style=\"color:white;\">&laquo;&laquo;&nbsp;&nbsp;</a>";
		$mesok .= "<strong>".$mesesp."</strong> ".$year;
		$mesok .= "<a href=\"index.php?op=1017&dd=".$dia_select."&aa=".($dany)."&mm=".($dmes)."&usuario=".$usuario."\" style=\"color:white;\">&nbsp;&nbsp;&raquo;&raquo;</a>";

		$mesok .= "</td></tr><tr><td>";
		$mesok .= "<table style=\"background-color:#4B53AF\" cellpadding=\"0\" cellspacing=\"1\"><tr>";
		$sumadias = 0;
		$diasemana = 1;
		$semanax = 0;
		$control = 0;
		while (($d < 32) and ($mes == $m)) {
			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) { $diasemana = 7; }
			$semana = date("W", mktime(0,0,0,$m ,$d, $a));
			if ($mes != $mesanterior) {
				$mesok .= "<td style=\"text-align:center;color:white;\">L</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">M</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">X</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">J</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">V</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">S</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">D</td>";
				$mesok .= "</tr><tr>";
			}
			if ($semana != $semanaanterior) {
				$semananum++;
				$mesok .= "</tr><tr>";
			}
			if ($semanax == 0) { 
				if ($diasemana == 7) { $mesok .= "<td></td><td></td><td></td><td></td><td></td><td></td>"; $sumadias = 6;}
				if ($diasemana == 6) { $mesok .= "<td></td><td></td><td></td><td></td><td></td>"; $sumadias = 5;}
				if ($diasemana == 5) { $mesok .= "<td></td><td></td><td></td><td></td>"; $sumadias = 4;}
				if ($diasemana == 4) { $mesok .= "<td></td><td></td><td></td>"; $sumadias = 3;}
				if ($diasemana == 3) { $mesok .= "<td></td><td></td>"; $sumadias = 2;}
				if ($diasemana == 2) { $mesok .= "<td></td>"; $sumadias = 1;}
				if ($diasemana == 1) { $mesok .= ""; $sumadias = 0;}
				$semanax = 1;
			}
			######### COLOR DEL FONDO DEL CALENDARIO
			$date = getdate();
			if ($date["mday"] < 10) { $z = "0".$date["mday"]; }	else {$z = $date["mday"]; }
			if ($date["mon"] < 10) { $y = "0".$date["mon"]; } else {$y = $date["mon"]; }
			$hoy = $date["year"]."-".$y."-".$z;
			$sqla = "select count(*) as total from agm_incidencias where fecha='".$fecha."' and id_usuario=".$usuario;
			$resulta = mysql_query(convertSQL($sqla));
			$rowa = mysql_fetch_array($resulta);
			if (($fecha != $hoy) and ($rowa["total"] == 0)) { $color = 'white'; }
			if (($fecha != $hoy) and ($rowa["total"] == 1)) { 
				$sqlac = "select * from av_iaula_actividades where fecha='".$fecha."' and id_iaula=".$iaula;
				$resultac = mysql_query(convertSQL($sqlac));
				$rowac = mysql_fetch_array($resultac);
				$sqlac2 = "select * from av_iaula_actividades_tipos where id='".$rowac["id_tipo_actividad"]."'";
				$resultac2 = mysql_query(convertSQL($sqlac2));
				$rowac2 = mysql_fetch_array($resultac2);
				$color = $rowac2["color"];
			}
			if (($fecha != $hoy) and ($rowa["total"] > 1)) { $color = 'silver'; }
			if (($fecha == $hoy) and ($rowa["total"] > 0)) { $color = '#FF4848'; }
			if (($fecha == $hoy) and ($rowa["total"] == 0)) { $color = '#FFCC33'; }
			$bodercolor = "#4B53AF";
			if ($d == $dia_select) { $bodercolor = "yellow"; }
			$mesok .= "<td style=\"text-align:center;width:20px;background-color:".$color.";height:15px;border : 2px solid ".$bodercolor.";\">";
			if ($d < 10) { $dformat = "0".$d; } else { $dformat = $d; }
			$mesok .= "<a href=\"index.php?op=1017&dd=".$dformat."&aa=".($year)."&mm=".($mes)."&usuario=".$usuario."\" style=\"color:black;\">".$d."</a>";

			$mesok .= "</td>";
			$d++;
			$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$mes = date("m", mktime(0,0,0,$m ,$d, $a));
			$semanaanterior = $semana;
			$mesanterior = $mes;
		}
		$mesok .= "</tr></table>";
		$mesok .= "</td></tr></table>";
	return $mesok; 
}

function agenda_conjunta($dia_select,$year,$mes,$usuario,$conjunta) {
	global $db;
		$a = $year;
		$m = $mes;
		$d = 1;

	### emes / eany <- mes i any anterios
	### dmes / dany <- mes i anys posteriors
	if ($m == 1) { 
		$emes = 12;
		$eany = $a-1;
	} else {
		$emes = $mes-1;
		if ($emes < 10) { $emes = "0".$emes; }
		$eany = $a;
	}
	if ($m == 12) {
		$dmes = "01";
		$dany = $a+1;
	} else { 
		$dmes = $mes+1;
		if ($dmes < 10) { $dmes = "0".$dmes; }
		$dany = $a;
	}


		$programada = 1;
		$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$totaldiasmes = 31;
			if ($mes == 1) { $mesesp = "Enero"; }
			if ($mes == 2) { 
				$mesesp = "Febrero";
				if (checkdate(2, 29, $a)) { $totaldiasmes = 29; } else { $totaldiasmes = 28; }
			}
			if ($mes == 3) { $mesesp = "Marzo"; }
			if ($mes == 4) { $mesesp = "Abril"; $totaldiasmes--; }
			if ($mes == 5) { $mesesp = "Mayo"; }
			if ($mes == 6) { $mesesp = "Junio"; $totaldiasmes--;}
			if ($mes == 7) { $mesesp = "Julio"; }
			if ($mes == 8) { $mesesp = "Agosto"; }
			if ($mes == 9) { $mesesp = "Septiembre"; $totaldiasmes--; }
			if ($mes == 10) { $mesesp = "Octubre"; }
			if ($mes == 11) { $mesesp = "Noviembre"; $totaldiasmes--; }
			if ($mes == 12) { $mesesp = "Diciembre"; }
		$semananum = 0;
		$mesok = "<table style=\"background-color:#4B53AF\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"text-align:center;;color:white;\">";

		$mesok .= "<a href=\"index.php?op=1006&sop=4&dd=".$dia_select."&aa=".($eany)."&mm=".($emes)."&usuario=".$usuario."\" style=\"color:white;\">&laquo;&laquo;&nbsp;&nbsp;</a>";
		$mesok .= "<strong>".$mesesp."</strong> ".$year;
		$mesok .= "<a href=\"index.php?op=1006&sop=4&dd=".$dia_select."&aa=".($dany)."&mm=".($dmes)."&usuario=".$usuario."\" style=\"color:white;\">&nbsp;&nbsp;&raquo;&raquo;</a>";

		$mesok .= "</td></tr><tr><td>";
		$mesok .= "<table style=\"background-color:#4B53AF\" cellpadding=\"0\" cellspacing=\"1\"><tr>";
		$sumadias = 0;
		$diasemana = 1;
		$semanax = 0;
		$control = 0;
		while (($d < 32) and ($mes == $m)) {
			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) { $diasemana = 7; }
			$semana = date("W", mktime(0,0,0,$m ,$d, $a));
			if ($mes != $mesanterior) {
				$mesok .= "<td style=\"text-align:center;color:white;\">L</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">M</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">X</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">J</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">V</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">S</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">D</td>";
				$mesok .= "</tr><tr>";
			}
			if ($semana != $semanaanterior) {
				$semananum++;
				$mesok .= "</tr><tr>";
			}
			if ($semanax == 0) { 
				if ($diasemana == 7) { $mesok .= "<td></td><td></td><td></td><td></td><td></td><td></td>"; $sumadias = 6;}
				if ($diasemana == 6) { $mesok .= "<td></td><td></td><td></td><td></td><td></td>"; $sumadias = 5;}
				if ($diasemana == 5) { $mesok .= "<td></td><td></td><td></td><td></td>"; $sumadias = 4;}
				if ($diasemana == 4) { $mesok .= "<td></td><td></td><td></td>"; $sumadias = 3;}
				if ($diasemana == 3) { $mesok .= "<td></td><td></td>"; $sumadias = 2;}
				if ($diasemana == 2) { $mesok .= "<td></td>"; $sumadias = 1;}
				if ($diasemana == 1) { $mesok .= ""; $sumadias = 0;}
				$semanax = 1;
			}
			######### COLOR DEL FONDO DEL CALENDARIO
			$date = getdate();
			if ($date["mday"] < 10) { $z = "0".$date["mday"]; }	else {$z = $date["mday"]; }
			if ($date["mon"] < 10) { $y = "0".$date["mon"]; } else {$y = $date["mon"]; }
			$hoy = $date["year"]."-".$y."-".$z;
			$sqla = "select count(*) as total from agm_incidencias where fecha='".$fecha."' and id_usuario=".$usuario;
			$resulta = mysql_query(convertSQL($sqla));
			$rowa = mysql_fetch_array($resulta);
			if (($fecha != $hoy) and ($rowa["total"] == 0)) { $color = 'white'; }
			if (($fecha != $hoy) and ($rowa["total"] == 1)) { 
				$sqlac = "select * from av_iaula_actividades where fecha='".$fecha."' and id_iaula=".$iaula;
				$resultac = mysql_query(convertSQL($sqlac));
				$rowac = mysql_fetch_array($resultac);
				$sqlac2 = "select * from av_iaula_actividades_tipos where id='".$rowac["id_tipo_actividad"]."'";
				$resultac2 = mysql_query(convertSQL($sqlac2));
				$rowac2 = mysql_fetch_array($resultac2);
				$color = $rowac2["color"];
			}
			if (($fecha != $hoy) and ($rowa["total"] > 1)) { $color = 'silver'; }
			if (($fecha == $hoy) and ($rowa["total"] > 0)) { $color = '#FF4848'; }
			if (($fecha == $hoy) and ($rowa["total"] == 0)) { $color = '#FFCC33'; }
			$bodercolor = "#4B53AF";
			if ($d == $dia_select) { $bodercolor = "yellow"; }
			$mesok .= "<td style=\"text-align:left;width:120px;background-color:".$color.";height:80px;border : 2px solid ".$bodercolor.";vertical-align:top\">";
			if ($d < 10) { $dformat = "0".$d; } else { $dformat = $d; }
			$mesok .= "<a href=\"index.php?op=1006&dd=".$dformat."&aa=".($year)."&mm=".($mes)."&usuario=".$usuario."\" style=\"color:black;\">".$d."</a>";



					$horainici = '00:00:00';
					if ($m < 10) { $m = "0".$m; }
					if ($d < 10) { $d = "0".$d; }
					$hoy1 = $a."-".$m."-".$d." ".$horainici;
					$horafin = '23:59:59';
					$hoy2 = $a."-".$m."-".$d." ".$horafin;

					$sql = "select * from sgm_incidencias where data_prevision>'".$hoy1."' and data_prevision< '".$hoy2."' and visible=1 and tiempo > 0";
					$sql .= " and ((id_usuario_destino=".$usuario." or id_2=".$usuario." or id_3=".$usuario." or id_4=".$usuario." or id_5=".$usuario." or id_6=".$usuario." or id_7=".$usuario." or id_8=".$usuario." or id_9=".$usuario." or id_10=".$usuario.")";

					if ($conjunta == 1) {

						$sqlux = "select * from sgm_incidencias_usuaris_permisos where id_usuari_visitant=".$usuario." and id_usuari_propietari<>0";
						$resultux = mysql_query(convertSQL($sqlux));
						while ($rowux = mysql_fetch_array($resultux)) {	
							$sql .= " or (id_usuario_destino=".$rowux["id_usuari_propietari"]." or id_2=".$rowux["id_usuari_propietari"]." or id_3=".$rowux["id_usuari_propietari"]." or id_4=".$rowux["id_usuari_propietari"]." or id_5=".$rowux["id_usuari_propietari"]." or id_6=".$rowux["id_usuari_propietari"]." or id_7=".$rowux["id_usuari_propietari"]." or id_8=".$rowux["id_usuari_propietari"]." or id_9=".$rowux["id_usuari_propietari"]." or id_10=".$rowux["id_usuari_propietari"].")";
						}
					}

					$sql .=	") and privada=1 order by data_prevision";

					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)){
							$hora = date("H", strtotime($row["data_prevision"])); 
							$minut = date("i", strtotime($row["data_prevision"]));

							$estado_color = "White";
							if ($row["id_estado"] > 0) {
								$sqle = "select * from sgm_incidencias_estados where id=".$row["id_estado"];
								$resulte = mysql_query(convertSQL($sqle));
								$rowe = mysql_fetch_array($resulte);
								$estado_color = $rowe["color"];
								$estado_color_letras = "Black";
							} else {
								if ($row["id_estado"] == -1) { 
									$estado_color = "Red";
									$estado_color_letras = "White";
								}
								if ($row["id_estado"] == -2) {
									$estado_color = "White";
									$estado_color_letras = "Black";
								}
							}


							$mesok .= "<table cellspacing=\"0\" cellspacing=\"0\" style=\"border:1px solid black;width:100%;background-color : ".$estado_color.";color:".$estado_color_letras."\">";
							$mesok .= "<tr><td><a href=\"index.php?op=1006&sop=2&id=".$row["id"]."\" style=\"color:".$estado_color_letras."\">".$hora.":".$minut." (".$row["tiempo"]." min.)</a></td></tr>";
								$sqlusuario = "select * from sgm_users where id=".$row["id_usuario_destino"];
								$resultusuario = mysql_query(convertSQL($sqlusuario));
								$rowusuario = mysql_fetch_array($resultusuario);
								$mesok .= "<tr><td style=\"color:".$estado_color_letras."\"><strong>".$rowusuario["usuario"]."</strong></td></tr>";
							for ($i = 2 ; $i < 11 ; $i++) {
								if ($row["id_".$i] != 0) {
									$sqlusuario = "select * from sgm_users where id=".$row["id_".$i];
									$resultusuario = mysql_query(convertSQL($sqlusuario));
									$rowusuario = mysql_fetch_array($resultusuario);
									$mesok .= "<tr><td style=\"color:".$estado_color_letras."\"><strong>".$rowusuario["usuario"]."</strong></td></tr>";
								}
							}
							$mesok .= "<tr><td style=\"color:".$estado_color_letras."\"><strong>".$row["asunto"]."</strong></td></tr>";
							$mesok .= "</table>";
					}

			$mesok .= "</td>";
			$d++;
			$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$mes = date("m", mktime(0,0,0,$m ,$d, $a));
			$semanaanterior = $semana;
			$mesanterior = $mes;
		}
		$mesok .= "</tr></table>";
		$mesok .= "</td></tr></table>";
	return $mesok;
}


?>