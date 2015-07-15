<?php

function quitarAcentos($string){
	return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝªº',
'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYao');
}

function boton($ruta,$texto) 
{
	echo "<table><tr>";
	for ($i=0;$i<=(count($ruta)-1);$i++){
		echo "<td class=\"boton\">";
			echo "<a href=\"index.php?".$ruta[$i]."\" style=\"color:white;\">".$texto[$i]."</a>";
		echo "</td>";
	}
	echo "</tr></table>";
}
function boton_form($ruta,$texto) 
{
	echo "<td class=\"boton\" style=\"height:3px;\">";
		echo "<a href=\"index.php?".$ruta."\" style=\"color:white;\">".$texto."</a>";
	echo "</td>";
}

function boton_volver($Volver) 
{
	echo "<table cellpadding=\"0\">";
		echo "<tr><td class=menu><a href=\"javascript:history.go(-1);\" style=\"color:white;\">".$Volver."</a></td></tr>";
	echo "</table>";
}

function cambiarFormatoFechaYMD($fecha){
	list($dia,$mes,$any)=explode("-",$fecha);
	return $any."-".$mes."-".$dia;
}

function cambiarFormatoFechaDMY($fecha){
	list($any,$mes,$dia)=explode("-",$fecha);
	return $dia."-".$mes."-".$any;
}

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
	$resultf = mysql_query(convert_sql($sqlf));
	$rowf = mysql_fetch_array($resultf);
	$texto = str_replace("[pedido]",$rowf["numero_cliente"], $texto);
	$texto = str_replace("[orden]",$rowf["numero"], $texto);

	$sqlc = "select * from sgm_cuerpo where idfactura=".$id_fact;
	$resultc = mysql_query(convert_sql($sqlc));
	while ($rowc = mysql_fetch_array($resultc)){
		$fechas .= $rowc["fecha_prevision"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rowc["fecha_prevision_propia"]."<br>";
	}
	$texto = str_replace("[fechas]",$fechas, $texto);
	return $texto; 
}

function conta_aprovats($id_linia,$id_factura)
{
	$sql = "select count(*) as total from sgm_cuerpo where id=".$id_linia."";
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	$sql2 = "select count(*) as total2 from sgm_cuerpo where id=".$id_linia." and aprovat=1";
	$result2 = mysql_query(convert_sql($sql2));
	$row2 = mysql_fetch_array($result2);
	if ($row["total"] == $row2["total2"]){
		$sqlc = "update sgm_cabezera set ";
		$sqlc = $sqlc."confirmada_cliente=1";
		$sqlc = $sqlc." WHERE id=".$id_factura."";
		mysql_query(convert_sql($sqlc));
	} else {
		$sqlc = "update sgm_cabezera set ";
		$sqlc = $sqlc."confirmada_cliente=0";
		$sqlc = $sqlc." WHERE id=".$id_factura."";
		mysql_query(convert_sql($sqlc));
	}
}

function mensaje_error($texto) 
{
	echo "<center><table><tr><td style=\"background-color:red; color:white; width:400px; vertical-align:middle;height:50px; text-align:center;\">";
	echo $texto;
	echo "</td></tr></table></center>";
}

function mensaje_error_c($texto,$color) 
{
	echo "<center><table><tr><td style=\"background-color:".$color."; color:white; width:400px; vertical-align:middle;height:50px; text-align:center;\">";
	echo $texto;
	echo "</td></tr></table></center>";
}

function lopd($userid,$username,$option,$soption) {
#	date_default_timezone_set('Europe/Paris');

	$sql1 = "$userid	$username	$option	$soption";
	$date = getdate();
	$sql1 = $sql1."	".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
	$sql1 = $sql1."	".date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
	if (version_compare(phpversion(), "4.0.0", ">")) {
		$sql1 = $sql1."	".$_SERVER[REMOTE_ADDR];
		$sql1 = $sql1."	".$_SERVER[HTTP_USER_AGENT];
			$x = $_SERVER[PHP_SELF];
			if ($_SERVER[QUERY_STRING] != "") { $x = $x."?".$_SERVER[QUERY_STRING]; }
		$sql1 = $sql1."	".$x;
		$sql1 = $sql1."	".$_SERVER[HTTP_REFERER];
	}
	if (version_compare(phpversion(), "4.0.1", "<")) {
		$sql1 = $sql1."	".$HTTP_SERVER_VARS[REMOTE_ADDR];
		$sql1 = $sql1."	".$HTTP_SERVER_VARS[HTTP_USER_AGENT];
			$x = $HTTP_SERVER_VARS[PHP_SELF];
			if ($HTTP_SERVER_VARS[QUERY_STRING] != "") { $x = $x."?".$HTTP_SERVER_VARS[QUERY_STRING]; }
		$sql1 = $sql1."	".$x;
		$sql1 = $sql1."	".$HTTP_SERVER_VARS[HTTP_REFERER];
	}

	if (!$gestor = fopen("reg_acces.txt", "a+")) { echo "No se pueden grabar los datos de registro de accesos."; }
	if (fwrite($gestor, $sql1.Chr(13)) === FALSE) { echo "Cannot write to file ($filename)"; }
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
		$result = mysql_query(convert_sql($sql));
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
		$resultp = mysql_query(convert_sql($sqlp));
		$rowp = mysql_fetch_array($resultp);

		$texto = str_replace("[pais]",$rowp["Nacion"], $texto);
		$texto = str_replace("[mail]",$row["mail"], $texto);
		$texto = str_replace("[web]",$row["web"], $texto);
		$texto = str_replace("[telefon1]",$row["telefono"], $texto);
		$texto = str_replace("[telefon2]",$row["telefono2"], $texto);
		$texto = str_replace("[fax1]",$row["fax"], $texto);
		$texto = str_replace("[fax2]",$row["fax2"], $texto);

		$sqlc = "select * from sgm_clients_contactos where pred=1 and id_client=".$id_client;
		$resultc = mysql_query(convert_sql($sqlc));
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
		$resultc = mysql_query(convert_sql($sqlc));
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
		$result = mysql_query(convert_sql($sql));
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
		$resultp = mysql_query(convert_sql($sqlp));
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
	$result = mysql_query(convert_sql($sql));
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
		$result = mysql_query(convert_sql($sql));
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
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] > 0) {
			$sql = "select * from sgm_clients_contactos where visible=1 and pred=1 and id_client=".$id;
			$result = mysql_query(convert_sql($sql));
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

function convert_sql($sql) { 
	$basededatos = "mysql";
#	$basededatos = "mssql";

	if ($basededatos == "mysql") {
		$sql2 = $sql;
	}

	if ($basededatos == "mssql") {
		$sql2 = $sql;
		for($i=0; $i<strlen($sql); $i++) {
			if ($sql[$i] == "'") {

				if( (($sql[$i+1] > chr(47)) and ($sql[$i+1] < chr(58))) and (($sql[$i+2] > chr(47)) and ($sql[$i+2] < chr(58))) and (($sql[$i+3] > chr(47)) and ($sql[$i+3] < chr(58))) and (($sql[$i+4] > chr(47)) and ($sql[$i+4] < chr(58))) and ($sql[$i+5] == chr(45)) and (($sql[$i+6] > chr(47)) and ($sql[$i+6] < chr(58))) and (($sql[$i+7] > chr(47)) and ($sql[$i+7] < chr(58))) and ($sql[$i+8] == chr(45)) and (($sql[$i+9] > chr(47)) and ($sql[$i+9] < chr(58))) and (($sql[$i+10] > chr(47)) and ($sql[$i+10] < chr(58))) )  {
					$sql2[$i+1] = $sql[$i+9];
					$sql2[$i+2] = $sql[$i+10];
					$sql2[$i+3] = "/";
					$sql2[$i+4] = $sql[$i+6];
					$sql2[$i+5] = $sql[$i+7];
					$sql2[$i+6] = "/";
					$sql2[$i+7] = $sql[$i+1];
					$sql2[$i+8] = $sql[$i+2];
					$sql2[$i+9] = $sql[$i+3];
					$sql2[$i+10] = $sql[$i+4];
				}
				
			}

		}
	}
	return $sql2;
}

function trafactura($id_cabecera, $tipus_nou, $date) 
{
	global $db;

	$sqlfa = "select * from sgm_cabezera where visible=1 and tipo=".$tipus_nou." order by numero desc";
	$resultfa = mysql_query(convert_sql($sqlfa));
	$rowfa = mysql_fetch_array($resultfa);
	$numero = ($rowfa["numero"]+1);

	$sqla = "select * from sgm_cabezera where visible=1 and id=".$id_cabecera;
	$resulta = mysql_query(convert_sql($sqla));
	$rowa = mysql_fetch_array($resulta);

	$sql = "insert into sgm_cabezera (id_origen,numero,version,numero_cliente,fecha,fecha_prevision,fecha_entrega,fecha_vencimiento,visible,tipo,subtipo,nombre,nif";
	$sql = $sql.",direccion,poblacion,cp,provincia,id_pais,mail,telefono,edireccion,epoblacion,ecp,eprovincia,eid_pais,onombre,onif,odireccion,opoblacion,ocp";
	$sql = $sql.",oprovincia,omail,otelefono,notas,subtotal,descuento,descuento_absoluto,subtotaldescuento,iva,total,total_forzado,id_cliente,id_user,recibos,cobrada";
	$sql = $sql.",id_tipo_pago,file,cerrada,controlcalidad,print,bultos,peso,nombre_contacto,confirmada,confirmada_cliente,id_divisa,div_canvi,imp_exp,trz) ";
	$sql = $sql."values (";
	$sql = $sql."".$rowa["id_origen"];
	$sqlf = "select * from sgm_factura_tipos where visible=1 and id=".$_POST["id_tipus"];
	$resultf = mysql_query(convert_sql($sqlf));
	$rowf = mysql_fetch_array($resultf);
	if (($rowa["tipo"] == $_POST["id_tipus"]) and ($rowf["presu"] == 1)){
		$sql = $sql.",".$rowa["numero"];
		$version = ($rowa["version"] + 1);
		$sql = $sql.",'".$version."'";
	} else {
		$sql = $sql.",".$numero;
		$sql = $sql.",'".$rowa["version"]."'";
	}
	$sql = $sql.",'".$rowa["numero_cliente"]."'";
	$sql = $sql.",'".$date."'";
	$sql = $sql.",'".$date."'";
	$sql = $sql.",'".$date."'";
	$sql = $sql.",'".$date."'";
	$sql = $sql.",".$rowa["visible"];
	$sql = $sql.",".$tipus_nou;
	$sql = $sql.",".$rowa["subtipo"];
	$sql = $sql.",'".$rowa["nombre"]."'";
	$sql = $sql.",'".$rowa["nif"]."'";
	$sql = $sql.",'".$rowa["direccion"]."'";
	$sql = $sql.",'".$rowa["poblacion"]."'";
	$sql = $sql.",'".$rowa["cp"]."'";
	$sql = $sql.",'".$rowa["provincia"]."'";
	$sql = $sql.",".$rowa["id_pais"]."";
	$sql = $sql.",'".$rowa["mail"]."'";
	$sql = $sql.",'".$rowa["telefono"]."'";
	$sql = $sql.",'".$rowa["edireccion"]."'";
	$sql = $sql.",'".$rowa["epoblacion"]."'";
	$sql = $sql.",'".$rowa["ecp"]."'";
	$sql = $sql.",'".$rowa["eprovincia"]."'";
	$sql = $sql.",".$rowa["eid_pais"]."";
	$sql = $sql.",'".$rowa["onombre"]."'";
	$sql = $sql.",'".$rowa["onif"]."'";
	$sql = $sql.",'".$rowa["odireccion"]."'";
	$sql = $sql.",'".$rowa["opoblacion"]."'";
	$sql = $sql.",'".$rowa["ocp"]."'";
	$sql = $sql.",'".$rowa["oprovincia"]."'";
	$sql = $sql.",'".$rowa["omail"]."'";
	$sql = $sql.",'".$rowa["otelefono"]."'";
	$sql = $sql.",'".$rowa["notas"]."'";
	$sql = $sql.",'".$rowa["subtotal"]."'";
	$sql = $sql.",'".$rowa["descuento"]."'";
	$sql = $sql.",'".$rowa["descuento_absoluto"]."'";
	$sql = $sql.",'".$rowa["subtotaldescuento"]."'";
	$sql = $sql.",'".$rowa["iva"]."'";
	$sql = $sql.",'".$rowa["total"]."'";
	$sql = $sql.",'".$rowa["total_forzado"]."'";
	$sql = $sql.",".$rowa["id_cliente"];
	$sql = $sql.",".$rowa["id_user"];
	$sql = $sql.",".$rowa["recibos"];
	$sql = $sql.",0";
	$sql = $sql.",".$rowa["id_tipo_pago"];
	$sql = $sql.",'".$rowa["file"]."'";
	$sql = $sql.",0";
	$sql = $sql.",".$rowa["controlcalidad"];
	$sql = $sql.",".$rowa["print"];
	$sql = $sql.",".$rowa["bultos"];
	$sql = $sql.",".$rowa["peso"];
	$sql = $sql.",'".$rowa["nombre_contacto"]."'";
	$sql = $sql.",0";
	$sql = $sql.",0";
	$sql = $sql.",".$rowa["id_divisa"];
	$sql = $sql.",'".$rowa["div_canvi"]."'";
	$sql = $sql.",".$rowa["imp_exp"];
	$sql = $sql.",".$rowa["id"];
	$sql = $sql.")";
	mysql_query(convert_sql($sql));

	$sqlfac = "select * from sgm_cabezera where visible=1 order by id desc";
	$resultfac = mysql_query(convert_sql($sqlfac));
	$rowfac = mysql_fetch_array($resultfac);

	$sqlm = "select * from sgm_factura_modificacio where id_factura=".$id_cabecera;
	$resultm = mysql_query(convert_sql($sqlm));
	while ($rowm = mysql_fetch_array($resultm)){
		$sqlf = "insert into sgm_factura_modificacio (id_factura, id_usuario, data, hora) ";
		$sqlf = $sqlf."values (";
		$sqlf = $sqlf."".$rowfac["id"]."";
		$sqlf = $sqlf.",".$rowm["id_usuario"];
		$sqlf = $sqlf.",'".$rowm["data"]."'";
		$sqlf = $sqlf.",'".$rowm["hora"]."'";
		$sqlf = $sqlf.")";
		mysql_query(convert_sql($sqlf));
	}

	$sql = "select * from sgm_cuerpo where idfactura=".$id_cabecera;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){

	$sql = "insert into sgm_cuerpo (id_origen,linea,id_cuerpo,idfactura,id_estado,fecha_prevision,fecha_entrega,fecha_prevision_propia,facturado,id_facturado,codigo,nombre,pvd";
	$sql = $sql.",pvp,unidades,descuento,descuento_absoluto,subtotaldescuento,total,notes,bloqueado,id_article,stock,prioridad,controlcalidad,id_tarifa,tarifa,trz) ";
	$sql = $sql."values (";
	$sql = $sql."".$row["id_origen"]."";
	$sql = $sql.",".$row["linea"]."";
	$sql = $sql.",".$row["id_cuerpo"]."";
	$sql = $sql.",".$rowfac["id"]."";
	$sql = $sql.",".$row["id_estado"]."";
	$sql = $sql.",'".$date."'";
	$sql = $sql.",'".$date."'";
	$sql = $sql.",'".$row["fecha_entrega"]."'";
	$sql = $sql.",".$row["facturado"];
	$sql = $sql.",".$row["id_facturado"];
	$sql = $sql.",'".$row["codigo"]."'";
	$sql = $sql.",'".$row["nombre"]."'";
	$sql = $sql.",'".$row["pvd"]."'";
	$sql = $sql.",'".$row["pvp"]."'";
	$sql = $sql.",'".$row["unidades"]."'";
	$sql = $sql.",'".$row["descuento"]."'";
	$sql = $sql.",'".$row["descuento_absoluto"]."'";
	$sql = $sql.",'".$row["subtotaldescuento"]."'";
	$sql = $sql.",'".$row["total"]."'";
	$sql = $sql.",'".$row["notes"]."'";
	$sql = $sql.",".$row["bloqueado"];
	$sql = $sql.",".$row["id_article"];
	$sql = $sql.",".$row["stock"];
	$sql = $sql.",".$row["prioridad"];
	$sql = $sql.",".$row["controlcalidad"];
	$sql = $sql.",".$row["id_tarifa"];
	$sql = $sql.",'".$row["tarifa"]."'";
	$sql = $sql.",".$row["id"];
	$sql = $sql.")";
	mysql_query(convert_sql($sql));
	}

	$sqlc = "select * from sgm_cuerpo where visible=1 order by id desc";
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	trafactura_costos($row["id"],$rowc["id"],0,0);
	refactura($rowfa["id"]);
}

function trafactura_costos($id_cuerpo_ori,$id_cuerpo_des,$id_article_ori,$id_article_des) 
{
	global $db;

	if ($id_cuerpo_ori > 0){
		$sql = "select * from sgm_articles_costos where id_cuerpo=".$id_cuerpo_ori;
	}
	if ($id_article_ori > 0){
		$sql = "select * from sgm_articles_costos where id_article=".$id_article_ori;
	}
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){

		$sql = "insert into sgm_articles_costos (id_article,id_cuerpo,preu_cost,pes_cost,visible,descripcio,temps,fecha) ";
		$sql = $sql."values (";
		$sql = $sql."".$id_article_des."";
		$sql = $sql."".$id_cuerpo_des."";
		$sql = $sql.",'".$row["preu_cost"]."'";
		$sql = $sql.",'".$row["pes_cost"]."'";
		$sql = $sql.",".$row["visible"]."";
		$sql = $sql.",'".$row["descripcio"]."'";
		$sql = $sql.",".$row["temps"]."";
		$sql = $sql.",'".$row["fecha"]."'";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
	}

	$sqlaf = "select * from sgm_articles_fases_recursos where visible=1 and id_coste=".$row["id"];
	$resultaf = mysql_query(convert_sql($sqlaf));
	$rowaf = mysql_fetch_array($resultaf);

	$sqlac = "select * from sgm_articles_costos where visible=1 order by id desc";
	$resultac = mysql_query(convert_sql($sqlac));
	$rowac = mysql_fetch_array($resultac);

	$sql = "insert into sgm_articles_fases_recursos (id_fase,id_recurso,id_coste,preu_fases,visible,ordre,temps,calc_temps) ";
	$sql = $sql."values (";
	$sql = $sql."".$rowaf["id_fase"]."";
	$sql = $sql."".$rowaf["id_recurso"]."";
	$sql = $sql.",".$rowac["id"]."";
	$sql = $sql.",'".$rowaf["preu_fases"]."'";
	$sql = $sql.",".$rowaf["visible"]."";
	$sql = $sql.",".$rowaf["ordre"]."";
	$sql = $sql.",".$rowaf["temps"]."";
	$sql = $sql.",".$rowaf["calc_temps"]."";
	$sql = $sql.")";
	mysql_query(convert_sql($sql));

	$sqlae = "select * from sgm_articles_estacada where visible=1 and id_fase_recurso=".$rowaf["id"];
	$resultae = mysql_query(convert_sql($sqlae));
	$rowae = mysql_fetch_array($resultae);

	$sqlafr = "select * from sgm_articles_fases_recursos where visible=1 order by id desc";
	$resultafr = mysql_query(convert_sql($sqlafr));
	$rowafr = mysql_fetch_array($resultafr);

	$sql = "insert into sgm_articles_estacada (id_fase_recurso,visible,orden,descripcio) ";
	$sql = $sql."values (";
	$sql = $sql."".$rowafr["id"]."";
	$sql = $sql.",".$rowae["visible"]."";
	$sql = $sql.",".$rowae["orden"]."";
	$sql = $sql.",'".$rowae["descripcio"]."'";
	$sql = $sql.")";
	mysql_query(convert_sql($sql));

	$sqlao = "select * from sgm_articles_operaciones where visible=1 and id_estacada=".$rowae["id"];
	$resultao = mysql_query(convert_sql($sqlao));
	$rowao = mysql_fetch_array($resultao);

	$sqlae = "select * from sgm_articles_estacada where visible=1 order by id desc";
	$resultae = mysql_query(convert_sql($sqlae));
	$rowae = mysql_fetch_array($resultae);

	$sql = "insert into sgm_articles_operaciones (id_operacion,id_estacada,visible,temps,descripcio) ";
	$sql = $sql."values (";
	$sql = $sql."".$rowao["id_operacion"]."";
	$sql = $sql."".$rowae["id"]."";
	$sql = $sql.",".$rowao["visible"]."";
	$sql = $sql.",".$rowao["temps"]."";
	$sql = $sql.",'".$rowao["descripcio"]."'";
	$sql = $sql.")";
	mysql_query(convert_sql($sql));
}

function colors() 
{
?>
    <TABLE cellpadding="1" cellspacing="1">
        <TR> 
          <TD style="BORDER-BOTTOM: black 2px solid"><strong></strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>Nombre</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>RGB</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong></strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>Nombre</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>RGB</strong></TD>
        </TR>
        <TR>
        <TR><TD style="BACKGROUND: aliceblue"; width="15px">&nbsp;</TD><TD>AliceBlue</TD><TD>#F0F8FF</TD><TD style="BACKGROUND: lightsalmon"; width="15px">&nbsp;</TD><TD>LightSalmon</TD><TD>#FFA07A</TD></TR>
		<TR><TD style="BACKGROUND: antiquewhite">&nbsp;</TD><TD>AntiqueWhite</TD><TD>#FAEBD7</TD><TD style="BACKGROUND: lightseagreen">&nbsp;</TD><TD>LightSeaGreen</TD><TD>#20B2AA</TD></TR>
		<TR><TD style="BACKGROUND: aqua">&nbsp;</TD><TD>Aqua</TD><TD>#00FFFF</TD><TD style="BACKGROUND: lightskyblue">&nbsp;</TD><TD>LightSkyBlue</TD><TD>#87CEFA</TD></TR>
		<TR><TD style="BACKGROUND: aquamarine">&nbsp;</TD><TD>Aquamarine</TD><TD>#7FFFD4</TD><TD style="BACKGROUND: lightslategray">&nbsp;</TD><TD>LightSlateGray</TD><TD>#778899</TD></TR>
		<TR><TD style="BACKGROUND: azure">&nbsp;</TD><TD>Azure</TD><TD>#F0FFFF</TD><TD style="BACKGROUND: lightsteelblue">&nbsp;</TD><TD>LightSteelBlue</TD><TD>#B0C4DE</TD></TR>
		<TR><TD style="BACKGROUND: beige">&nbsp;</TD><TD>Beige</TD><TD>#F5F5DC</TD><TD style="BACKGROUND: lightyellow">&nbsp;</TD><TD>LightYellow</TD><TD>#FFFFE0</TD></TR>
		<TR><TD style="BACKGROUND: bisque">&nbsp;</TD><TD>Bisque</TD><TD>#FFE4C4</TD><TD style="BACKGROUND: lime">&nbsp;</TD><TD>Lime</TD><TD>#00FF00</TD></TR>
		<TR><TD style="BACKGROUND: black">&nbsp;</TD><TD>Black</TD><TD>#000000</TD><TD style="BACKGROUND: limegreen">&nbsp;</TD><TD>LimeGreen</TD><TD>#32CD32</TD></TR>
		<TR><TD style="BACKGROUND: blanchedalmond">&nbsp;</TD><TD>BlanchedAlmond</TD><TD>#FFEBCD</TD><TD style="BACKGROUND: linen">&nbsp;</TD><TD>Linen</TD><TD>#FAF0E6</TD></TR>
		<TR><TD style="BACKGROUND: blue">&nbsp;</TD><TD>Blue</TD><TD>#0000FF</TD><TD style="BACKGROUND: magenta">&nbsp;</TD><TD>Magenta</TD><TD>#FF00FF</TD></TR>
		<TR><TD style="BACKGROUND: blueviolet">&nbsp;</TD><TD>BlueViolet</TD><TD>#8A2BE2</TD><TD style="BACKGROUND: maroon">&nbsp;</TD><TD>Maroon</TD><TD>#800000</TD></TR>
		<TR><TD style="BACKGROUND: brown">&nbsp;</TD><TD>Brown</TD><TD>#A52A2A</TD><TD style="BACKGROUND: mediumaquamarine">&nbsp;</TD><TD>MediumAquamarine</TD><TD>#66CDAA</TD></TR>
		<TR><TD style="BACKGROUND: burlywood">&nbsp;</TD><TD>BurlyWood</TD><TD>#DEB887</TD><TD style="BACKGROUND: mediumblue">&nbsp;</TD><TD>MediumBlue</TD><TD>#0000CD</TD></TR>
		<TR><TD style="BACKGROUND: cadetblue">&nbsp;</TD><TD>CadetBlue</TD><TD>#5F9EA0</TD><TD style="BACKGROUND: mediumorchid">&nbsp;</TD><TD>MediumOrchid</TD><TD>#BA55D3</TD></TR>
		<TR><TD style="BACKGROUND: chartreuse">&nbsp;</TD><TD>Chartreuse</TD><TD>#7FFF00</TD><TD style="BACKGROUND: mediumpurple">&nbsp;</TD><TD>MediumPurple</TD><TD>#9370DB</TD></TR>
		<TR><TD style="BACKGROUND: chocolate">&nbsp;</TD><TD>Chocolate</TD><TD>#D2691E</TD><TD style="BACKGROUND: mediumseagreen">&nbsp;</TD><TD>MediumSeaGreen</TD><TD>#3CB371</TD></TR>
		<TR><TD style="BACKGROUND: coral">&nbsp;</TD><TD>Coral</TD><TD>#FF7F50</TD><TD style="BACKGROUND: mediumslateblue">&nbsp;</TD><TD>MediumSlateBlue</TD><TD>#7B68EE</TD></TR>
		<TR><TD style="BACKGROUND: cornflowerblue">&nbsp;</TD><TD>CornflowerBlue</TD><TD>#6495ED</TD><TD style="BACKGROUND: mediumspringgreen">&nbsp;</TD><TD>MediumSpringGreen</TD><TD>#00FA9A</TD></TR>
		<TR><TD style="BACKGROUND: cornsilk">&nbsp;</TD><TD>Cornsilk</TD><TD>#FFF8DC</TD><TD style="BACKGROUND: mediumturquoise">&nbsp;</TD><TD>MediumTurquoise</TD><TD>#48D1CC</TD></TR>
		<TR><TD style="BACKGROUND: crimson">&nbsp;</TD><TD>Crimson</TD><TD>#DC143C</TD><TD style="BACKGROUND: mediumvioletred">&nbsp;</TD><TD>MediumVioletRed</TD><TD>#C71585</TD></TR>
		<TR><TD style="BACKGROUND: cyan">&nbsp;</TD><TD>Cyan</TD><TD>#00FFFF</TD><TD style="BACKGROUND: midnightblue">&nbsp;</TD><TD>MidnightBlue</TD><TD>#191970</TD></TR>
		<TR><TD style="BACKGROUND: darkblue">&nbsp;</TD><TD>DarkBlue</TD><TD>#00008B</TD><TD style="BACKGROUND: mintcream">&nbsp;</TD><TD>MintCream</TD><TD>#F5FFFA</TD></TR>
		<TR><TD style="BACKGROUND: darkcyan">&nbsp;</TD><TD>DarkCyan</TD><TD>#008B8B</TD><TD style="BACKGROUND: mistyrose">&nbsp;</TD><TD>MistyRose</TD><TD>#FFE4E1</TD></TR>
		<TR><TD style="BACKGROUND: darkgoldenrod">&nbsp;</TD><TD>DarkGoldenrod</TD><TD>#B8860B</TD><TD style="BACKGROUND: moccasin">&nbsp;</TD><TD>Moccasin</TD><TD>#FFE4B5</TD></TR>
		<TR><TD style="BACKGROUND: darkgray">&nbsp;</TD><TD>DarkGray</TD><TD>#A9A9A9</TD><TD style="BACKGROUND: navajowhite">&nbsp;</TD><TD>NavajoWhite</TD><TD>#FFDEAD</TD></TR>
		<TR><TD style="BACKGROUND: darkgreen">&nbsp;</TD><TD>DarkGreen</TD><TD>#006400</TD><TD style="BACKGROUND: navy">&nbsp;</TD><TD>Navy</TD><TD>#000080</TD></TR>
		<TR><TD style="BACKGROUND: darkkhaki">&nbsp;</TD><TD>DarkKhaki</TD><TD>#BDB76B</TD><TD style="BACKGROUND: oldlace">&nbsp;</TD><TD>OldLace</TD><TD>#FDF5E6</TD></TR>
		<TR><TD style="BACKGROUND: darkmagenta">&nbsp;</TD><TD>DarkMagenta</TD><TD>#8B008B</TD><TD style="BACKGROUND: olive">&nbsp;</TD><TD>Olive</TD><TD>#808000</TD></TR>
		<TR><TD style="BACKGROUND: darkolivegreen">&nbsp;</TD><TD>DarkOliveGreen</TD><TD>#556B2F</TD><TD style="BACKGROUND: olivedrab">&nbsp;</TD><TD>OliveDrab</TD><TD>#6B8E23</TD></TR>
		<TR><TD style="BACKGROUND: darkorange">&nbsp;</TD><TD>DarkOrange</TD><TD>#FF8C00</TD><TD style="BACKGROUND: orange">&nbsp;</TD><TD>Orange</TD><TD>#FFA500</TD></TR>
		<TR><TD style="BACKGROUND: darkorchid">&nbsp;</TD><TD>DarkOrchid</TD><TD>#9932CC</TD><TD style="BACKGROUND: orangered">&nbsp;</TD><TD>OrangeRed</TD><TD>#FF4500</TD></TR>
		<TR><TD style="BACKGROUND: darkred">&nbsp;</TD><TD>DarkRed</TD><TD>#8B0000</TD><TD style="BACKGROUND: orchid">&nbsp;</TD><TD>Orchid</TD><TD>#DA70D6</TD></TR>
		<TR><TD style="BACKGROUND: darksalmon">&nbsp;</TD><TD>DarkSalmon</TD><TD>#E9967A</TD><TD style="BACKGROUND: palegoldenrod">&nbsp;</TD><TD>PaleGoldenrod</TD><TD>#EEE8AA</TD></TR>
		<TR><TD style="BACKGROUND: darkseagreen">&nbsp;</TD><TD>DarkSeaGreen</TD><TD>#8FBC8F</TD><TD style="BACKGROUND: palegreen">&nbsp;</TD><TD>PaleGreen</TD><TD>#98FB98</TD></TR>
		<TR><TD style="BACKGROUND: darkslateblue">&nbsp;</TD><TD>DarkSlateBlue</TD><TD>#483D8B</TD><TD style="BACKGROUND: paleturquoise">&nbsp;</TD><TD>PaleTurquoise</TD><TD>#AFEEEE</TD></TR>
		<TR><TD style="BACKGROUND: darkslategray">&nbsp;</TD><TD>DarkSlateGray</TD><TD>#2F4F4F</TD><TD style="BACKGROUND: palevioletred">&nbsp;</TD><TD>PaleVioletRed</TD><TD>#DB7093</TD></TR>
		<TR><TD style="BACKGROUND: darkturquoise">&nbsp;</TD><TD>DarkTurquoise</TD><TD>#00CED1</TD><TD style="BACKGROUND: papayawhip">&nbsp;</TD><TD>PapayaWhip</TD><TD>#FFEFD5</TD></TR>
		<TR><TD style="BACKGROUND: darkviolet">&nbsp;</TD><TD>DarkViolet</TD><TD>#9400D3</TD><TD style="BACKGROUND: peachpuff">&nbsp;</TD><TD>PeachPuff</TD><TD>#FFDAB9</TD></TR>
		<TR><TD style="BACKGROUND: deeppink">&nbsp;</TD><TD>DeepPink</TD><TD>#FF1493</TD><TD style="BACKGROUND: peru">&nbsp;</TD><TD>Peru</TD><TD>#CD853F</TD></TR>
		<TR><TD style="BACKGROUND: deepskyblue">&nbsp;</TD><TD>DeepSkyBlue</TD><TD>#00BFFF</TD><TD style="BACKGROUND: pink">&nbsp;</TD><TD>Pink</TD><TD>#FFC0CB</TD></TR>
		<TR><TD style="BACKGROUND: dimgray">&nbsp;</TD><TD>DimGray</TD><TD>#696969</TD><TD style="BACKGROUND: plum">&nbsp;</TD><TD>Plum</TD><TD>#DDA0DD</TD></TR>
		<TR><TD style="BACKGROUND: dodgerblue">&nbsp;</TD><TD>DodgerBlue</TD><TD>#1E90FF</TD><TD style="BACKGROUND: powderblue">&nbsp;</TD><TD>PowderBlue</TD><TD>#B0E0E6</TD></TR>
		<TR><TD style="BACKGROUND: firebrick">&nbsp;</TD><TD>FireBrick</TD><TD>#B22222</TD><TD style="BACKGROUND: purple">&nbsp;</TD><TD>Purple</TD><TD>#800080</TD></TR>
		<TR><TD style="BACKGROUND: floralwhite">&nbsp;</TD><TD>FloralWhite</TD><TD>#FFFAF0</TD><TD style="BACKGROUND: red">&nbsp;</TD><TD>Red</TD><TD>#FF0000</TD></TR>
		<TR><TD style="BACKGROUND: forestgreen">&nbsp;</TD><TD>ForestGreen</TD><TD>#228B22</TD><TD style="BACKGROUND: rosybrown">&nbsp;</TD><TD>RosyBrown</TD><TD>#BC8F8F</TD></TR>
		<TR><TD style="BACKGROUND: fuchsia">&nbsp;</TD><TD>Fuchsia</TD><TD>#FF00FF</TD><TD style="BACKGROUND: royalblue">&nbsp;</TD><TD>RoyalBlue</TD><TD>#4169E1</TD></TR>
		<TR><TD style="BACKGROUND: gainsboro">&nbsp;</TD><TD>Gainsboro</TD><TD>#DCDCDC</TD><TD style="BACKGROUND: saddlebrown">&nbsp;</TD><TD>SaddleBrown</TD><TD>#8B4513</TD></TR>
		<TR><TD style="BACKGROUND: ghostwhite">&nbsp;</TD><TD>GhostWhite</TD><TD>#F8F8FF</TD><TD style="BACKGROUND: salmon">&nbsp;</TD><TD>Salmon</TD><TD>#FA8072</TD></TR>
		<TR><TD style="BACKGROUND: gold">&nbsp;</TD><TD>Gold</TD><TD>#FFD700</TD><TD style="BACKGROUND: sandybrown">&nbsp;</TD><TD>SandyBrown</TD><TD>#F4A460</TD></TR>
		<TR><TD style="BACKGROUND: goldenrod">&nbsp;</TD><TD>Goldenrod</TD><TD>#DAA520</TD><TD style="BACKGROUND: seagreen">&nbsp;</TD><TD>SeaGreen</TD><TD>#2E8B57</TD></TR>
		<TR><TD style="BACKGROUND: gray">&nbsp;</TD><TD>Gray</TD><TD>#808080</TD><TD style="BACKGROUND: seashell">&nbsp;</TD><TD>Seashell</TD><TD>#FFF5EE</TD></TR>
		<TR><TD style="BACKGROUND: green">&nbsp;</TD><TD>Green</TD><TD>#008000</TD><TD style="BACKGROUND: sienna">&nbsp;</TD><TD>Sienna</TD><TD>#A0522D</TD></TR>
		<TR><TD style="BACKGROUND: greenyellow">&nbsp;</TD><TD>GreenYellow</TD><TD>#ADFF2F</TD><TD style="BACKGROUND: silver">&nbsp;</TD><TD>Silver</TD><TD>#C0C0C0</TD></TR>
		<TR><TD style="BACKGROUND: honeydew">&nbsp;</TD><TD>Honeydew</TD><TD>#F0FFF0</TD><TD style="BACKGROUND: skyblue">&nbsp;</TD><TD>SkyBlue</TD><TD>#87CEEB</TD></TR>
		<TR><TD style="BACKGROUND: hotpink">&nbsp;</TD><TD>HotPink</TD><TD>#FF69B4</TD><TD style="BACKGROUND: slateblue">&nbsp;</TD><TD>SlateBlue</TD><TD>#6A5ACD</TD></TR>
		<TR><TD style="BACKGROUND: indianred">&nbsp;</TD><TD>IndianRed</TD><TD>#CD5C5C</TD><TD style="BACKGROUND: slategray">&nbsp;</TD><TD>SlateGray</TD><TD>#708090</TD></TR>
		<TR><TD style="BACKGROUND: indigo">&nbsp;</TD><TD>Indigo</TD><TD>#4B0082</TD><TD style="BACKGROUND: snow">&nbsp;</TD><TD>Snow</TD><TD>#FFFAFA</TD></TR>
		<TR><TD style="BACKGROUND: ivory">&nbsp;</TD><TD>Ivory</TD><TD>#FFFFF0</TD><TD style="BACKGROUND: springgreen">&nbsp;</TD><TD>SpringGreen</TD><TD>#00FF7F</TD></TR>
		<TR><TD style="BACKGROUND: khaki">&nbsp;</TD><TD>Khaki</TD><TD>#F0E68C</TD><TD style="BACKGROUND: steelblue">&nbsp;</TD><TD>SteelBlue</TD><TD>#4682B4</TD></TR>
		<TR><TD style="BACKGROUND: lavender">&nbsp;</TD><TD>Lavender</TD><TD>#E6E6FA</TD><TD style="BACKGROUND: tan">&nbsp;</TD><TD>Tan</TD><TD>#D2B48C</TD></TR>
		<TR><TD style="BACKGROUND: lavenderblush">&nbsp;</TD><TD>LavenderBlush</TD><TD>#FFF0F5</TD><TD style="BACKGROUND: teal">&nbsp;</TD><TD>Teal</TD><TD>#008080</TD></TR>
		<TR><TD style="BACKGROUND: lawngreen">&nbsp;</TD><TD>LawnGreen</TD><TD>#7CFC00</TD><TD style="BACKGROUND: thistle">&nbsp;</TD><TD>Thistle</TD><TD>#D8BFD8</TD></TR>
		<TR><TD style="BACKGROUND: lemonchiffon">&nbsp;</TD><TD>LemonChiffon</TD><TD>#FFFACD</TD><TD style="BACKGROUND: tomato">&nbsp;</TD><TD>Tomato</TD><TD>#FF6347</TD></TR>
		<TR><TD style="BACKGROUND: lightblue">&nbsp;</TD><TD>LightBlue</TD><TD>#ADD8E6</TD><TD style="BACKGROUND: turquoise">&nbsp;</TD><TD>Turquoise</TD><TD>#40E0D0</TD></TR>
		<TR><TD style="BACKGROUND: lightcoral">&nbsp;</TD><TD>LightCoral</TD><TD>#F08080</TD><TD style="BACKGROUND: violet">&nbsp;</TD><TD>Violet</TD><TD>#EE82EE</TD></TR>
		<TR><TD style="BACKGROUND: lightcyan">&nbsp;</TD><TD>LightCyan</TD><TD>#E0FFFF</TD><TD style="BACKGROUND: wheat">&nbsp;</TD><TD>Wheat</TD><TD>#F5DEB3</TD></TR>
		<TR><TD style="BACKGROUND: lightgoldenrodyellow">&nbsp;</TD><TD>LightGoldenrodYellow</TD><TD>#FAFAD2</TD><TD style="BACKGROUND: white">&nbsp;</TD><TD>White</TD><TD>#FFFFFF</TD></TR>
		<TR><TD style="BACKGROUND: lightgreen">&nbsp;</TD><TD>LightGreen</TD><TD>#90EE90</TD><TD style="BACKGROUND: whitesmoke">&nbsp;</TD><TD>WhiteSmoke</TD><TD>#F5F5F5</TD></TR>
		<TR><TD style="BACKGROUND: lightgrey">&nbsp;</TD><TD>LightGrey</TD><TD>#D3D3D3</TD><TD style="BACKGROUND: yellow">&nbsp;</TD><TD>Yellow</TD><TD>#FFFF00</TD></TR>
		<TR><TD style="BACKGROUND: lightpink">&nbsp;</TD><TD>LightPink</TD><TD>#FFB6C1</TD><TD style="BACKGROUND: yellowgreen">&nbsp;</TD><TD>YellowGreen</TD><TD>#9ACD32</TD></TR>
    </TABLE>
<?php
}

function colors2() 
{
?>
    <TABLE cellpadding="1" cellspacing="1">
        <TR> 
          <TD style="BORDER-BOTTOM: black 2px solid"><strong></strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>Nombre</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>RGB</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong></strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>Nombre</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>RGB</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong></strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>Nombre</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>RGB</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong></strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>Nombre</strong></TD>
          <TD style="BORDER-BOTTOM: black 2px solid"><strong>RGB</strong></TD>
        </TR>
        <TR><TD style="BACKGROUND: aliceblue"; width="15px">&nbsp;</TD><TD>AliceBlue</TD><TD>#F0F8FF</TD><TD style="BACKGROUND: lightsalmon"; width="15px">&nbsp;</TD><TD>LightSalmon</TD><TD>#FFA07A</TD>
			<TD style="BACKGROUND: antiquewhite"; width="15px">&nbsp;</TD><TD>AntiqueWhite</TD><TD>#FAEBD7</TD><TD style="BACKGROUND: lightseagreen"; width="15px">&nbsp;</TD><TD>LightSeaGreen</TD><TD>#20B2AA</TD></TR>
		<TR><TD style="BACKGROUND: aqua">&nbsp;</TD><TD>Aqua</TD><TD>#00FFFF</TD><TD style="BACKGROUND: lightskyblue">&nbsp;</TD><TD>LightSkyBlue</TD><TD>#87CEFA</TD>
			<TD style="BACKGROUND: aquamarine">&nbsp;</TD><TD>Aquamarine</TD><TD>#7FFFD4</TD><TD style="BACKGROUND: lightslategray">&nbsp;</TD><TD>LightSlateGray</TD><TD>#778899</TD></TR>
		<TR><TD style="BACKGROUND: azure">&nbsp;</TD><TD>Azure</TD><TD>#F0FFFF</TD><TD style="BACKGROUND: lightsteelblue">&nbsp;</TD><TD>LightSteelBlue</TD><TD>#B0C4DE</TD>
			<TD style="BACKGROUND: beige">&nbsp;</TD><TD>Beige</TD><TD>#F5F5DC</TD><TD style="BACKGROUND: lightyellow">&nbsp;</TD><TD>LightYellow</TD><TD>#FFFFE0</TD></TR>
		<TR><TD style="BACKGROUND: bisque">&nbsp;</TD><TD>Bisque</TD><TD>#FFE4C4</TD><TD style="BACKGROUND: lime">&nbsp;</TD><TD>Lime</TD><TD>#00FF00</TD>
			<TD style="BACKGROUND: black">&nbsp;</TD><TD>Black</TD><TD>#000000</TD><TD style="BACKGROUND: limegreen">&nbsp;</TD><TD>LimeGreen</TD><TD>#32CD32</TD></TR>
		<TR><TD style="BACKGROUND: blanchedalmond">&nbsp;</TD><TD>BlanchedAlmond</TD><TD>#FFEBCD</TD><TD style="BACKGROUND: linen">&nbsp;</TD><TD>Linen</TD><TD>#FAF0E6</TD>
			<TD style="BACKGROUND: blue">&nbsp;</TD><TD>Blue</TD><TD>#0000FF</TD><TD style="BACKGROUND: magenta">&nbsp;</TD><TD>Magenta</TD><TD>#FF00FF</TD></TR>
		<TR><TD style="BACKGROUND: blueviolet">&nbsp;</TD><TD>BlueViolet</TD><TD>#8A2BE2</TD><TD style="BACKGROUND: maroon">&nbsp;</TD><TD>Maroon</TD><TD>#800000</TD>
			<TD style="BACKGROUND: brown">&nbsp;</TD><TD>Brown</TD><TD>#A52A2A</TD><TD style="BACKGROUND: mediumaquamarine">&nbsp;</TD><TD>MediumAquamarine</TD><TD>#66CDAA</TD></TR>
		<TR><TD style="BACKGROUND: burlywood">&nbsp;</TD><TD>BurlyWood</TD><TD>#DEB887</TD><TD style="BACKGROUND: mediumblue">&nbsp;</TD><TD>MediumBlue</TD><TD>#0000CD</TD>
			<TD style="BACKGROUND: cadetblue">&nbsp;</TD><TD>CadetBlue</TD><TD>#5F9EA0</TD><TD style="BACKGROUND: mediumorchid">&nbsp;</TD><TD>MediumOrchid</TD><TD>#BA55D3</TD></TR>
		<TR><TD style="BACKGROUND: chartreuse">&nbsp;</TD><TD>Chartreuse</TD><TD>#7FFF00</TD><TD style="BACKGROUND: mediumpurple">&nbsp;</TD><TD>MediumPurple</TD><TD>#9370DB</TD>
			<TD style="BACKGROUND: chocolate">&nbsp;</TD><TD>Chocolate</TD><TD>#D2691E</TD><TD style="BACKGROUND: mediumseagreen">&nbsp;</TD><TD>MediumSeaGreen</TD><TD>#3CB371</TD></TR>
		<TR><TD style="BACKGROUND: coral">&nbsp;</TD><TD>Coral</TD><TD>#FF7F50</TD><TD style="BACKGROUND: mediumslateblue">&nbsp;</TD><TD>MediumSlateBlue</TD><TD>#7B68EE</TD>
			<TD style="BACKGROUND: cornflowerblue">&nbsp;</TD><TD>CornflowerBlue</TD><TD>#6495ED</TD><TD style="BACKGROUND: mediumspringgreen">&nbsp;</TD><TD>MediumSpringGreen</TD><TD>#00FA9A</TD></TR>
		<TR><TD style="BACKGROUND: cornsilk">&nbsp;</TD><TD>Cornsilk</TD><TD>#FFF8DC</TD><TD style="BACKGROUND: mediumturquoise">&nbsp;</TD><TD>MediumTurquoise</TD><TD>#48D1CC</TD>
			<TD style="BACKGROUND: crimson">&nbsp;</TD><TD>Crimson</TD><TD>#DC143C</TD><TD style="BACKGROUND: mediumvioletred">&nbsp;</TD><TD>MediumVioletRed</TD><TD>#C71585</TD></TR>
		<TR><TD style="BACKGROUND: cyan">&nbsp;</TD><TD>Cyan</TD><TD>#00FFFF</TD><TD style="BACKGROUND: midnightblue">&nbsp;</TD><TD>MidnightBlue</TD><TD>#191970</TD>
			<TD style="BACKGROUND: darkblue">&nbsp;</TD><TD>DarkBlue</TD><TD>#00008B</TD><TD style="BACKGROUND: mintcream">&nbsp;</TD><TD>MintCream</TD><TD>#F5FFFA</TD></TR>
		<TR><TD style="BACKGROUND: darkcyan">&nbsp;</TD><TD>DarkCyan</TD><TD>#008B8B</TD><TD style="BACKGROUND: mistyrose">&nbsp;</TD><TD>MistyRose</TD><TD>#FFE4E1</TD>
			<TD style="BACKGROUND: darkgoldenrod">&nbsp;</TD><TD>DarkGoldenrod</TD><TD>#B8860B</TD><TD style="BACKGROUND: moccasin">&nbsp;</TD><TD>Moccasin</TD><TD>#FFE4B5</TD></TR>
		<TR><TD style="BACKGROUND: darkgray">&nbsp;</TD><TD>DarkGray</TD><TD>#A9A9A9</TD><TD style="BACKGROUND: navajowhite">&nbsp;</TD><TD>NavajoWhite</TD><TD>#FFDEAD</TD>
			<TD style="BACKGROUND: darkgreen">&nbsp;</TD><TD>DarkGreen</TD><TD>#006400</TD><TD style="BACKGROUND: navy">&nbsp;</TD><TD>Navy</TD><TD>#000080</TD></TR>
		<TR><TD style="BACKGROUND: darkkhaki">&nbsp;</TD><TD>DarkKhaki</TD><TD>#BDB76B</TD><TD style="BACKGROUND: oldlace">&nbsp;</TD><TD>OldLace</TD><TD>#FDF5E6</TD>
			<TD style="BACKGROUND: darkmagenta">&nbsp;</TD><TD>DarkMagenta</TD><TD>#8B008B</TD><TD style="BACKGROUND: olive">&nbsp;</TD><TD>Olive</TD><TD>#808000</TD></TR>
		<TR><TD style="BACKGROUND: darkolivegreen">&nbsp;</TD><TD>DarkOliveGreen</TD><TD>#556B2F</TD><TD style="BACKGROUND: olivedrab">&nbsp;</TD><TD>OliveDrab</TD><TD>#6B8E23</TD>
			<TD style="BACKGROUND: darkorange">&nbsp;</TD><TD>DarkOrange</TD><TD>#FF8C00</TD><TD style="BACKGROUND: orange">&nbsp;</TD><TD>Orange</TD><TD>#FFA500</TD></TR>
		<TR><TD style="BACKGROUND: darkorchid">&nbsp;</TD><TD>DarkOrchid</TD><TD>#9932CC</TD><TD style="BACKGROUND: orangered">&nbsp;</TD><TD>OrangeRed</TD><TD>#FF4500</TD>
			<TD style="BACKGROUND: darkred">&nbsp;</TD><TD>DarkRed</TD><TD>#8B0000</TD><TD style="BACKGROUND: orchid">&nbsp;</TD><TD>Orchid</TD><TD>#DA70D6</TD></TR>
		<TR><TD style="BACKGROUND: darksalmon">&nbsp;</TD><TD>DarkSalmon</TD><TD>#E9967A</TD><TD style="BACKGROUND: palegoldenrod">&nbsp;</TD><TD>PaleGoldenrod</TD><TD>#EEE8AA</TD>
			<TD style="BACKGROUND: darkseagreen">&nbsp;</TD><TD>DarkSeaGreen</TD><TD>#8FBC8F</TD><TD style="BACKGROUND: palegreen">&nbsp;</TD><TD>PaleGreen</TD><TD>#98FB98</TD></TR>
		<TR><TD style="BACKGROUND: darkslateblue">&nbsp;</TD><TD>DarkSlateBlue</TD><TD>#483D8B</TD><TD style="BACKGROUND: paleturquoise">&nbsp;</TD><TD>PaleTurquoise</TD><TD>#AFEEEE</TD>
			<TD style="BACKGROUND: darkslategray">&nbsp;</TD><TD>DarkSlateGray</TD><TD>#2F4F4F</TD><TD style="BACKGROUND: palevioletred">&nbsp;</TD><TD>PaleVioletRed</TD><TD>#DB7093</TD></TR>
		<TR><TD style="BACKGROUND: darkturquoise">&nbsp;</TD><TD>DarkTurquoise</TD><TD>#00CED1</TD><TD style="BACKGROUND: papayawhip">&nbsp;</TD><TD>PapayaWhip</TD><TD>#FFEFD5</TD>
			<TD style="BACKGROUND: darkviolet">&nbsp;</TD><TD>DarkViolet</TD><TD>#9400D3</TD><TD style="BACKGROUND: peachpuff">&nbsp;</TD><TD>PeachPuff</TD><TD>#FFDAB9</TD></TR>
		<TR><TD style="BACKGROUND: deeppink">&nbsp;</TD><TD>DeepPink</TD><TD>#FF1493</TD><TD style="BACKGROUND: peru">&nbsp;</TD><TD>Peru</TD><TD>#CD853F</TD>
			<TD style="BACKGROUND: deepskyblue">&nbsp;</TD><TD>DeepSkyBlue</TD><TD>#00BFFF</TD><TD style="BACKGROUND: pink">&nbsp;</TD><TD>Pink</TD><TD>#FFC0CB</TD></TR>
		<TR><TD style="BACKGROUND: dimgray">&nbsp;</TD><TD>DimGray</TD><TD>#696969</TD><TD style="BACKGROUND: plum">&nbsp;</TD><TD>Plum</TD><TD>#DDA0DD</TD>
			<TD style="BACKGROUND: dodgerblue">&nbsp;</TD><TD>DodgerBlue</TD><TD>#1E90FF</TD><TD style="BACKGROUND: powderblue">&nbsp;</TD><TD>PowderBlue</TD><TD>#B0E0E6</TD></TR>
		<TR><TD style="BACKGROUND: firebrick">&nbsp;</TD><TD>FireBrick</TD><TD>#B22222</TD><TD style="BACKGROUND: purple">&nbsp;</TD><TD>Purple</TD><TD>#800080</TD>
			<TD style="BACKGROUND: floralwhite">&nbsp;</TD><TD>FloralWhite</TD><TD>#FFFAF0</TD><TD style="BACKGROUND: red">&nbsp;</TD><TD>Red</TD><TD>#FF0000</TD></TR>
		<TR><TD style="BACKGROUND: forestgreen">&nbsp;</TD><TD>ForestGreen</TD><TD>#228B22</TD><TD style="BACKGROUND: rosybrown">&nbsp;</TD><TD>RosyBrown</TD><TD>#BC8F8F</TD>
			<TD style="BACKGROUND: fuchsia">&nbsp;</TD><TD>Fuchsia</TD><TD>#FF00FF</TD><TD style="BACKGROUND: royalblue">&nbsp;</TD><TD>RoyalBlue</TD><TD>#4169E1</TD></TR>
		<TR><TD style="BACKGROUND: gainsboro">&nbsp;</TD><TD>Gainsboro</TD><TD>#DCDCDC</TD><TD style="BACKGROUND: saddlebrown">&nbsp;</TD><TD>SaddleBrown</TD><TD>#8B4513</TD>
			<TD style="BACKGROUND: ghostwhite">&nbsp;</TD><TD>GhostWhite</TD><TD>#F8F8FF</TD><TD style="BACKGROUND: salmon">&nbsp;</TD><TD>Salmon</TD><TD>#FA8072</TD></TR>
		<TR><TD style="BACKGROUND: gold">&nbsp;</TD><TD>Gold</TD><TD>#FFD700</TD><TD style="BACKGROUND: sandybrown">&nbsp;</TD><TD>SandyBrown</TD><TD>#F4A460</TD>
			<TD style="BACKGROUND: goldenrod">&nbsp;</TD><TD>Goldenrod</TD><TD>#DAA520</TD><TD style="BACKGROUND: seagreen">&nbsp;</TD><TD>SeaGreen</TD><TD>#2E8B57</TD></TR>
		<TR><TD style="BACKGROUND: gray">&nbsp;</TD><TD>Gray</TD><TD>#808080</TD><TD style="BACKGROUND: seashell">&nbsp;</TD><TD>Seashell</TD><TD>#FFF5EE</TD>
			<TD style="BACKGROUND: green">&nbsp;</TD><TD>Green</TD><TD>#008000</TD><TD style="BACKGROUND: sienna">&nbsp;</TD><TD>Sienna</TD><TD>#A0522D</TD></TR>
		<TR><TD style="BACKGROUND: greenyellow">&nbsp;</TD><TD>GreenYellow</TD><TD>#ADFF2F</TD><TD style="BACKGROUND: silver">&nbsp;</TD><TD>Silver</TD><TD>#C0C0C0</TD>
			<TD style="BACKGROUND: honeydew">&nbsp;</TD><TD>Honeydew</TD><TD>#F0FFF0</TD><TD style="BACKGROUND: skyblue">&nbsp;</TD><TD>SkyBlue</TD><TD>#87CEEB</TD></TR>
		<TR><TD style="BACKGROUND: hotpink">&nbsp;</TD><TD>HotPink</TD><TD>#FF69B4</TD><TD style="BACKGROUND: slateblue">&nbsp;</TD><TD>SlateBlue</TD><TD>#6A5ACD</TD>
			<TD style="BACKGROUND: indianred">&nbsp;</TD><TD>IndianRed</TD><TD>#CD5C5C</TD><TD style="BACKGROUND: slategray">&nbsp;</TD><TD>SlateGray</TD><TD>#708090</TD></TR>
		<TR><TD style="BACKGROUND: indigo">&nbsp;</TD><TD>Indigo</TD><TD>#4B0082</TD><TD style="BACKGROUND: snow">&nbsp;</TD><TD>Snow</TD><TD>#FFFAFA</TD>
			<TD style="BACKGROUND: ivory">&nbsp;</TD><TD>Ivory</TD><TD>#FFFFF0</TD><TD style="BACKGROUND: springgreen">&nbsp;</TD><TD>SpringGreen</TD><TD>#00FF7F</TD></TR>
		<TR><TD style="BACKGROUND: khaki">&nbsp;</TD><TD>Khaki</TD><TD>#F0E68C</TD><TD style="BACKGROUND: steelblue">&nbsp;</TD><TD>SteelBlue</TD><TD>#4682B4</TD>
			<TD style="BACKGROUND: lavender">&nbsp;</TD><TD>Lavender</TD><TD>#E6E6FA</TD><TD style="BACKGROUND: tan">&nbsp;</TD><TD>Tan</TD><TD>#D2B48C</TD></TR>
		<TR><TD style="BACKGROUND: lavenderblush">&nbsp;</TD><TD>LavenderBlush</TD><TD>#FFF0F5</TD><TD style="BACKGROUND: teal">&nbsp;</TD><TD>Teal</TD><TD>#008080</TD>
			<TD style="BACKGROUND: lawngreen">&nbsp;</TD><TD>LawnGreen</TD><TD>#7CFC00</TD><TD style="BACKGROUND: thistle">&nbsp;</TD><TD>Thistle</TD><TD>#D8BFD8</TD></TR>
		<TR><TD style="BACKGROUND: lemonchiffon">&nbsp;</TD><TD>LemonChiffon</TD><TD>#FFFACD</TD><TD style="BACKGROUND: tomato">&nbsp;</TD><TD>Tomato</TD><TD>#FF6347</TD>
			<TD style="BACKGROUND: lightblue">&nbsp;</TD><TD>LightBlue</TD><TD>#ADD8E6</TD><TD style="BACKGROUND: turquoise">&nbsp;</TD><TD>Turquoise</TD><TD>#40E0D0</TD></TR>
		<TR><TD style="BACKGROUND: lightcoral">&nbsp;</TD><TD>LightCoral</TD><TD>#F08080</TD><TD style="BACKGROUND: violet">&nbsp;</TD><TD>Violet</TD><TD>#EE82EE</TD>
			<TD style="BACKGROUND: lightcyan">&nbsp;</TD><TD>LightCyan</TD><TD>#E0FFFF</TD><TD style="BACKGROUND: wheat">&nbsp;</TD><TD>Wheat</TD><TD>#F5DEB3</TD></TR>
		<TR><TD style="BACKGROUND: lightgoldenrodyellow">&nbsp;</TD><TD>LightGoldenrodYellow</TD><TD>#FAFAD2</TD><TD style="BACKGROUND: white">&nbsp;</TD><TD>White</TD><TD>#FFFFFF</TD>
			<TD style="BACKGROUND: lightgreen">&nbsp;</TD><TD>LightGreen</TD><TD>#90EE90</TD><TD style="BACKGROUND: whitesmoke">&nbsp;</TD><TD>WhiteSmoke</TD><TD>#F5F5F5</TD></TR>
		<TR><TD style="BACKGROUND: lightgrey">&nbsp;</TD><TD>LightGrey</TD><TD>#D3D3D3</TD><TD style="BACKGROUND: yellow">&nbsp;</TD><TD>Yellow</TD><TD>#FFFF00</TD>
			<TD style="BACKGROUND: lightpink">&nbsp;</TD><TD>LightPink</TD><TD>#FFB6C1</TD><TD style="BACKGROUND: yellowgreen">&nbsp;</TD><TD>YellowGreen</TD><TD>#9ACD32</TD></TR>
    </TABLE>
<?php
}

function comprovar_ip($ip,$id) 
{ 
	global $db;
	$acceso = false;
	$accesolocal = false;

	### BUSCA SI ES UNA IP LOCAL
	$sqlt = "select * from sgm_sys_ip_local";
	$resultt = mysql_query(convert_sql($sqlt));
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

	$resultt = mysql_query(convert_sql($sqlt));
	$rowt = mysql_fetch_array($resultt);

	if ($rowt["total"] == 0) {
		$acceso = true;
	} else {

		if ($accesolocal == true) { $sqlt2 = "select count(*) as total from sgm_users_ips where ip='".$ip."' AND id_user=".$id." AND vigente=1 AND remota=0"; }
		if ($accesolocal == false) { $sqlt2 = "select count(*) as total from sgm_users_ips where ip='".$ip."' AND id_user=".$id." AND vigente=1 AND remota=1"; }
		$resultt2 = mysql_query(convert_sql($sqlt2));
		$rowt2 = mysql_fetch_array($resultt2);

		if ($rowt2["total"] > 0) {
			$acceso = true;
		}


	}


	return $acceso;
}

function cierrapedido($id) 
{ 
	global $db;
		$sqlt = "select count(*) as total from sgm_cuerpo where idfactura=".$id." and facturado=1";
		$resultt = mysql_query(convert_sql($sqlt));
		$rowt = mysql_fetch_array($resultt);
		$sqlt2 = "select count(*) as total from sgm_cuerpo where idfactura=".$id;
		$resultt2 = mysql_query(convert_sql($sqlt2));
		$rowt2 = mysql_fetch_array($resultt2);
		
		echo "<strong>a".$rowt["total"]."</strong>";
		echo "<strong>b".$rowt2["total"]."</strong>";

		if ($rowt["total"] == $rowt2["total"]) {
			$sql = "update sgm_cabezera set cerrada=1 WHERE id=".$id;
		mysql_query(convert_sql($sql));

		}
}

function calcular_fecha_vencimiento($id_client,$fecha_factura) 
{ 
	global $db;
		$sqlc = "select * from sgm_clients where id=".$id_client;
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);

		$sqlt = "select count(*) as total from sgm_clients_dias_recibos where id_cliente=".$rowc["id"]." order by dia";
		$resultt = mysql_query(convert_sql($sqlt));
		$rowt = mysql_fetch_array($resultt);
		if ($rowt["total"] == 0) {
			$a = date("Y", strtotime($fecha_factura));
			$m = date("m", strtotime($fecha_factura));
			$d = date("d", strtotime($fecha_factura));
			if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$rowc["dias_vencimiento"], $a)); }
			if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+$rowc["dias_vencimiento"] ,$d, $a)); }
		} else {
			$control = 0;
			$sqlz = "select * from sgm_clients_dias_recibos where id_cliente=".$rowc["id"]." order by dia";
			$resultz = mysql_query(convert_sql($sqlz));
			while ($rowz = mysql_fetch_array($resultz)) {
				$a = date("Y", strtotime($fecha_factura));
				$m = date("m", strtotime($fecha_factura));
				$df = date("d", strtotime($fecha_factura));
				$d = $rowz["dia"];
				if (($df <= $d) and ($control == 0)) {
					if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m ,$d+$rowc["dias_vencimiento"], $a)); }
					if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+$rowc["dias_vencimiento"] ,$d, $a)); }
					$control = 1;
				} 
				if ($control == 0) {
					if ($rowc["dias"] == 1) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+1 ,$d+$rowc["dias_vencimiento"], $a)); }
					if ($rowc["dias"] == 0) { $fecha_vencimiento = date("Y-m-d", mktime(0,0,0,$m+1+$rowc["dias_vencimiento"] ,$d, $a)); }
				}
			}
		}
	return $fecha_vencimiento;
}


function traspasar_cuerpo($id_origen,$id_cabezera) 
{ 
	global $db;

	$sqlc = "select * from sgm_cuerpo WHERE id=".$id_origen;
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);

	$sqlf = "select * from sgm_cabezera WHERE id=".$rowc["idfactura"];
	$resultf = mysql_query(convert_sql($sqlf));
	$rowf = mysql_fetch_array($resultf);

	$sqlfdestino = "select * from sgm_cabezera WHERE id=".$id_cabezera;
	$resultfdestino = mysql_query(convert_sql($sqlfdestino));
	$rowfdestino = mysql_fetch_array($resultfdestino);

	$sql = "select * from sgm_cuerpo WHERE id=".$id_origen;
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);

	$sqle = "select * from sgm_cuerpo_estados where id=".$row["id_estado"];
	$resulte = mysql_query(convert_sql($sqle));
	$rowe = mysql_fetch_array($resulte);


		$sql1 = "insert into sgm_cuerpo (id_origen,idfactura,fecha_prevision,codigo,nombre,unidades,pvp,total) ";
		$sql1 = $sql1."values (";
		$sql1 = $sql1."".$id_origen;
		$sql1 = $sql1.",".$id_cabezera;
		$sql1 = $sql1.",'".$rowfdestino["fecha_prevision"]."'";
		$sql1 = $sql1.",'".$row["codigo"]."'";
		$sql1 = $sql1.",'".$row["nombre"]." (".$rowe["estado"].")'";
		$sql1 = $sql1.",".$row["unidades"]."";
		$sql1 = $sql1.",".$row["pvp"]."";
		$sql1 = $sql1.",".($row["pvp"]*$row["unidades"])."";
		$sql1 = $sql1.")";
		mysql_query(convert_sql($sql1));

}


#La función principal se llama "convertir_a_letras($numero)". Admite un rango desde "0.01" hasta "999999999.99" (incluyendo los dos decimales).
function centimos() {
	global $importe_parcial;
	$importe_parcial = number_format($importe_parcial, 2, ".", "") * 100;
	if ($importe_parcial > 0)
		$num_letra = " con ".decena_centimos($importe_parcial);
	else
		$num_letra = "";
	return $num_letra;
}

function unidad_centimos($numero) {
	switch ($numero) { 
		case 9: { $num_letra = "nueve céntimos"; break; }
		case 8: { $num_letra = "ocho céntimos"; break; }
		case 7: { $num_letra = "siete céntimos"; break; }
		case 6: { $num_letra = "seis céntimos"; break; }
		case 5: { $num_letra = "cinco céntimos"; break; }
		case 4: { $num_letra = "cuatro céntimos"; break; }
		case 3: { $num_letra = "tres céntimos"; break; }
		case 2: { $num_letra = "dos céntimos"; break; }
		case 1: { $num_letra = "un céntimo"; break; }
	}
	return $num_letra;
}


function decena_centimos($numero) {
	if ($numero >= 10) {
		if ($numero >= 90 && $numero <= 99) {
			if ($numero == 90) return "noventa céntimos";
			else if ($numero == 91) return "noventa y un céntimos";
		else
			return "noventa y ".unidad_centimos($numero - 90);
		}
		if ($numero >= 80 && $numero <= 89) {
			if ($numero == 80) return "ochenta céntimos";
			else if ($numero == 81) return "ochenta y un céntimos";
		else
			return "ochenta y ".unidad_centimos($numero - 80);
		}
		if ($numero >= 70 && $numero <= 79) { 
			if ($numero == 70) return "setenta céntimos";
			else if ($numero == 71) return "setenta y un céntimos";
		else
			return "setenta y ".unidad_centimos($numero - 70);
		}
		if ($numero >= 60 && $numero <= 69) {
			if ($numero == 60) return "sesenta céntimos";
			else if ($numero == 61) return "sesenta y un céntimos";
		else
			return "sesenta y ".unidad_centimos($numero - 60);
		}
		if ($numero >= 50 && $numero <= 59) {
			if ($numero == 50) return "cincuenta céntimos";
			else if ($numero == 51) return "cincuenta y un céntimos";
		else
			return "cincuenta y ".unidad_centimos($numero - 50);
		}
		if ($numero >= 40 && $numero <= 49) {
			if ($numero == 40) return "cuarenta céntimos";
			else if ($numero == 41) return "cuarenta y un céntimos";
		else
			return "cuarenta y ".unidad_centimos($numero - 40);
		}
		if ($numero >= 30 && $numero <= 39) {
			if ($numero == 30) return "treinta céntimos";
			else if ($numero == 91) return "treinta y un céntimos";
		else
			return "treinta y ".unidad_centimos($numero - 30);
		}
		if ($numero >= 20 && $numero <= 29) {
			if ($numero == 20) return "veinte céntimos";
			else if ($numero == 21) return "veintiun céntimos";
		else
			return "veinti".unidad_centimos($numero - 20);
		}
		if ($numero >= 10 && $numero <= 19) {
			if ($numero == 10) return "diez céntimos";
			else if ($numero == 11) return "once céntimos";
			else if ($numero == 12) return "doce céntimos";
			else if ($numero == 13) return "trece céntimos";
			else if ($numero == 14) return "catorce céntimos";
			else if ($numero == 15) return "quince céntimos";
			else if ($numero == 16) return "dieciseis céntimos";
			else if ($numero == 17) return "diecisiete céntimos";
			else if ($numero == 18) return "dieciocho céntimos";
			else if ($numero == 19) return "diecinueve céntimos";
		}
	}
	else
	return unidad_centimos($numero);
}


function unidad($numero) {
	switch ($numero) {
		case 9: { $num = "nueve"; break; }
		case 8: { $num = "ocho"; break; }
		case 7: { $num = "siete"; break; }
		case 6: { $num = "seis"; break; }
		case 5: { $num = "cinco"; break; }
		case 4: { $num = "cuatro";break; }
		case 3: { $num = "tres"; break; }
		case 2: { $num = "dos"; break; }
		case 1: { $num = "uno"; break; }
	}
	return $num;
}


function decena($numero)
{
if ($numero >= 90 && $numero <= 99)
{
$num_letra = "noventa ";

if ($numero > 90)
$num_letra = $num_letra."y ".unidad($numero - 90);
}
else if ($numero >= 80 && $numero <= 89)
{
$num_letra = "ochenta ";

if ($numero > 80)
$num_letra = $num_letra."y ".unidad($numero - 80);
}
else if ($numero >= 70 && $numero <= 79)
{
$num_letra = "setenta ";

if ($numero > 70)
$num_letra = $num_letra."y ".unidad($numero - 70);
}
else if ($numero >= 60 && $numero <= 69)
{
$num_letra = "sesenta ";

if ($numero > 60)
$num_letra = $num_letra."y ".unidad($numero - 60);
}
else if ($numero >= 50 && $numero <= 59)
{
$num_letra = "cincuenta ";

if ($numero > 50)
$num_letra = $num_letra."y ".unidad($numero - 50);
}
else if ($numero >= 40 && $numero <= 49)
{
$num_letra = "cuarenta ";

if ($numero > 40)
$num_letra = $num_letra."y ".unidad($numero - 40);
}
else if ($numero >= 30 && $numero <= 39)
{
$num_letra = "treinta ";

if ($numero > 30)
$num_letra = $num_letra."y ".unidad($numero - 30);
}
else if ($numero >= 20 && $numero <= 29)
{
if ($numero == 20)
$num_letra = "veinte ";
else
$num_letra = "veinti".unidad($numero - 20);
}
else if ($numero >= 10 && $numero <= 19)
{
switch ($numero)
{
case 10:
{
$num_letra = "diez ";
break;
}
case 11:
{
$num_letra = "once ";
break;
}
case 12:
{
$num_letra = "doce ";
break;
}
case 13:
{
$num_letra = "trece ";
break;
}
case 14:
{
$num_letra = "catorce ";
break;
}
case 15:
{
$num_letra = "quince ";
break;
}
case 16:
{
$num_letra = "dieciseis ";
break;
}
case 17:
{
$num_letra = "diecisiete ";
break;
}
case 18:
{
$num_letra = "dieciocho ";
break;
}
case 19:
{
$num_letra = "diecinueve ";
break;
}
}
}
else
$num_letra = unidad($numero);

return $num_letra;
}


function centena($numero)
{
if ($numero >= 100)
{
if ($numero >= 900 & $numero <= 999)
{
$num_letra = "novecientos ";

if ($numero > 900)
$num_letra = $num_letra.decena($numero - 900);
}
else if ($numero >= 800 && $numero <= 899)
{
$num_letra = "ochocientos ";

if ($numero > 800)
$num_letra = $num_letra.decena($numero - 800);
}
else if ($numero >= 700 && $numero <= 799)
{
$num_letra = "setecientos ";

if ($numero > 700)
$num_letra = $num_letra.decena($numero - 700);
}
else if ($numero >= 600 && $numero <= 699)
{
$num_letra = "seiscientos ";

if ($numero > 600)
$num_letra = $num_letra.decena($numero - 600);
}
else if ($numero >= 500 && $numero <= 599)
{
$num_letra = "quinientos ";

if ($numero > 500)
$num_letra = $num_letra.decena($numero - 500);
}
else if ($numero >= 400 && $numero <= 499)
{
$num_letra = "cuatrocientos ";

if ($numero > 400)
$num_letra = $num_letra.decena($numero - 400);
}
else if ($numero >= 300 && $numero <= 399)
{
$num_letra = "trescientos ";

if ($numero > 300)
$num_letra = $num_letra.decena($numero - 300);
}
else if ($numero >= 200 && $numero <= 299)
{
$num_letra = "doscientos ";

if ($numero > 200)
$num_letra = $num_letra.decena($numero - 200);
}
else if ($numero >= 100 && $numero <= 199)
{
if ($numero == 100)
$num_letra = "cien ";
else
$num_letra = "ciento ".decena($numero - 100);
}
}
else
$num_letra = decena($numero);

return $num_letra;
}


function cien()
{
global $importe_parcial;

$parcial = 0; $car = 0;

while (substr($importe_parcial, 0, 1) == 0)
$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);

if ($importe_parcial >= 1 && $importe_parcial <= 9.99)
$car = 1;
else if ($importe_parcial >= 10 && $importe_parcial <= 99.99)
$car = 2;
else if ($importe_parcial >= 100 && $importe_parcial <= 999.99)
$car = 3;

$parcial = substr($importe_parcial, 0, $car);
$importe_parcial = substr($importe_parcial, $car);

$num_letra = centena($parcial).centimos();

return $num_letra;
}


function cien_mil()
{
global $importe_parcial;

$parcial = 0; $car = 0;

while (substr($importe_parcial, 0, 1) == 0)
$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);

if ($importe_parcial >= 1000 && $importe_parcial <= 9999.99)
$car = 1;
else if ($importe_parcial >= 10000 && $importe_parcial <= 99999.99)
$car = 2;
else if ($importe_parcial >= 100000 && $importe_parcial <= 999999.99)
$car = 3;

$parcial = substr($importe_parcial, 0, $car);
$importe_parcial = substr($importe_parcial, $car);

if ($parcial > 0)
{
if ($parcial == 1)
$num_letra = "mil ";
else
$num_letra = centena($parcial)." mil ";
}

return $num_letra;
}


function millon()
{
global $importe_parcial;

$parcial = 0; $car = 0;

while (substr($importe_parcial, 0, 1) == 0)
$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);

if ($importe_parcial >= 1000000 && $importe_parcial <= 9999999.99)
$car = 1;
else if ($importe_parcial >= 10000000 && $importe_parcial <= 99999999.99)
$car = 2;
else if ($importe_parcial >= 100000000 && $importe_parcial <= 999999999.99)
$car = 3;

$parcial = substr($importe_parcial, 0, $car);
$importe_parcial = substr($importe_parcial, $car);

if ($parcial == 1)
$num_letras = "un millón ";
else
$num_letras = centena($parcial)." millones ";

return $num_letras;
}


function convertir_a_letras($numero)
{
global $importe_parcial;

$importe_parcial = $numero;

if ($numero < 1000000000)
{
if ($numero >= 1000000 && $numero <= 999999999.99)
$num_letras = millon().cien_mil().cien();
else if ($numero >= 1000 && $numero <= 999999.99)
$num_letras = cien_mil().cien();
else if ($numero >= 1 && $numero <= 999.99)
$num_letras = cien();
else if ($numero >= 0.01 && $numero <= 0.99)
{
if ($numero == 0.01)
$num_letras = "un céntimo";
else
$num_letras = convertir_a_letras(($numero * 100)."/100")." céntimos";
}
}
return $num_letras;
}

	function refactura($idfactura) {
		global $db;
		#CALCULO DEL TOTAL DE LAS LINEAS
		$sql = "select count(*) as total from sgm_cuerpo where idfactura=".$idfactura;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 0) { $subtotal = 0; } else {
			$sql = "select sum(total) as subtotal from sgm_cuerpo where suma=0 and idfactura=".$idfactura;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["subtotal"]) { $subtotal = $row["subtotal"]; } else { $subtotal = 0; }
		}
		# SELECT DE LA CABEZERA
		$sql = "select * from sgm_cabezera where id=".$idfactura;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total_forzado"] == 0) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."subtotal=".$subtotal;
			if ($row["descuento_absoluto"] == 0) { $x = $subtotal - (($subtotal / 100) * $row["descuento"]) ; }
			if ($row["descuento"] == 0) { $x = $subtotal - $row["descuento_absoluto"] ;	}
			$sql = $sql.",subtotaldescuento=".$x;
			$xx = (($x / 100) * $row["iva"]) + $x;
			$sql = $sql.",total=".$xx;
			$sql = $sql." WHERE id=".$idfactura;
			mysql_query(convert_sql($sql));
		}
		if ($row["total_forzado"] == 1) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."subtotal=".$subtotal;
			$x = $row["total"]/(1+($row["iva"]/100));
			$sql = $sql.",subtotaldescuento=".$x;
			$xx = 100-($x/($subtotal/100));
			$sql = $sql.",descuento=".$xx;
			$sql = $sql.",descuento_absoluto=".($subtotal-$x);
			$sql = $sql.",total=".$row["total"];
			$sql = $sql." WHERE id=".$idfactura;
			mysql_query(convert_sql($sql));
#			echo $sql;
		}
	}

function autorizado($userid,$option)
{ 
	global $db;
	$autorizado = false;
		$sql = "select count(*) as total from sgm_users_permisos WHERE id_user=".$userid." AND id_tipus=0 AND id_modulo=".$option;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { 
			$autorizado = true;
		}
	return $autorizado; 
}

function admin($userid,$option)
{ 
	global $db;
	$admin = false;
		$sql = "select count(*) as total from sgm_users_permisos WHERE id_user=".$userid." AND id_tipus=0 AND id_modulo=".$option;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { 
			$sqladmin = "select * from sgm_users_permisos WHERE id_user=".$userid." AND id_modulo=".$option;
			$resultadmin = mysql_query(convert_sql($sqladmin));
			$rowadmin = mysql_fetch_array($resultadmin);
				if ($rowadmin["admin"] == 1) { 
					$admin = true;
				}
		}
	return $admin; 
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

function recalc_votos() 
{ 
	global $db;
	$sqlf = "select * from vs_firmas";
	$resultf = mysql_query(convert_sql($sqlf));
	while ($rowf = mysql_fetch_array($resultf)) {
		$sql = "select count(*) as total from vs_firmas_votos where id_semana=".$rowf["id_semana"]." AND id_year=".$rowf["id_year"]." AND admin=0";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$totalvotosusuarios = $row["total"];
		$sql = "select count(*) as total from vs_firmas_votos where id_semana=".$rowf["id_semana"]." AND id_year=".$rowf["id_year"]." AND admin=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$totalvotosadmin = $row["total"];

		$sql = "select count(*) as total from vs_firmas_votos where id_firma=".$rowf["id"]."  AND admin=0";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$votosusuarios = $row["total"];
		$sql = "select count(*) as total from vs_firmas_votos where id_firma=".$rowf["id"]."  AND admin=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$votosadmin = $row["total"];

		$votos = (($totalvotosusuarios/40)*$votosusuarios)+(($totalvotosadmin/40)*$votosadmin);
		
		$sql = "update vs_firmas set votos=".$votos." WHERE id=".$rowf["id_new"];
		mysql_query(convert_sql($sql));

	}

} 


function buscaclan($id) 
{ 
	global $db;
	if ($id == 0) {
		$clan = "&nbsp;";
	}
	else {
		$sql = "select count(*) as total from vs_squads WHERE id=".$id;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 0) {
			$clan = "?¿";
		}
		else {
			$sql = "select * from vs_squads WHERE id=".$id;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$clan = "<a href=\"index.php?op=3&id_clan=".$row["id"]."\">".$row["shortname"]."</a>";
		}
	}
	return $clan; 
}

function buscarnick($id) 
{ 
	global $db;
	if ($id == 0) {
		$nick = "&nbsp;";
	}
	else {
		$sql = "select count(*) as total from sgm_users WHERE id=".$id;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 0) {
			$nick = "?¿";
		}
		else {
			$sql = "select * from sgm_users WHERE id=".$id;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$nick = $row["usuario"];
#			$nick = "<a href=\"index.php?op=15&id_player=".$row["id"]."\">".$row["nick"]."</a>";
		}
	}
	return $nick; 
}

function buscarwarnick($id) 
{ 
	global $db;
	if ($id == 0) {
		$nick = "&nbsp;";
	}
	else {
		$sql = "select count(*) as total from vs_users WHERE id=".$id;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 0) {
			$nick = "?¿";
		}
		else {
			$sql = "select * from vs_users WHERE id=".$id;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$nick = "<a href=\"index.php?op=15&id_player=".$row["id"]."\">".$row["warnick"]."</a>";
		}
	}
	return $nick; 
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

function comprobar_mail($mail){ 
  if (!ereg("^([a-zA-Z0-9._/\]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,10})$",$mail)){ 
      return FALSE; 
  } else { 
       return TRUE; 
  } 
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

function recalc_matchs($id_ladder){
    global $db;
	$sql = "select * from vs_match WHERE id_ladder=".$id_ladder;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)) {
		$date = getdate();
		$dateof = $row["datematch"];
		$datealt = $row["datematch"];

		#### CANCELA ENCUENTROS AMISTOSOS CON FECHA RETO > QUE FECHA DEL RETO Y QUE NO HAN SIDO MODIFICADOS
		if ((date("Y-n-j", strtotime($dateof)) < $date["year"]."-".$date["mon"]."-".$date["mday"]) AND ($row["canceled"] == 0) AND ($row["amistoso"] == 1) AND ($row["id_squad_alt"] == 0) ) {
			$sql = "update vs_match set ";
			$sql = $sql."canceled=1";
			$sql = $sql." WHERE id=".$row["id"];
			mysql_query(convert_sql($sql));
		}
		#	date("Y-n-j", mktime(0,0,0,date("m") ,date("d")+$size, date("Y")))

	}
}

function recalc_standings($id_ladder) {
    global $db;
	$sqlladder = "select * from vs_ladders WHERE id=".$id_ladder;
	$resultladder = mysql_query(convert_sql($sqlladder));
	$rowladder = mysql_fetch_array($resultladder);
	$sqlstandings = "select * from vs_standings WHERE id_ladder=".$id_ladder;
	$resultstandings = mysql_query(convert_sql($sqlstandings));
	while ($rowstandings = mysql_fetch_array($resultstandings)) {
		$gameswin = 0;
		$gamestie = 0;
		$gameslost = 0;
		$mapswin = 0;
		$mapstie = 0;
		$mapslost = 0;
		$last_result = 0;
		$points = $rowladder["ini_points"];
		$sqlmatch = "select * from vs_match WHERE (id_local_squad=".$rowstandings["id_squad"]." OR id_visitant_squad=".$rowstandings["id_squad"]." ) AND amistoso=0 AND no_played=0 AND result=1 AND id_ladder=".$id_ladder;
		$resultmatch = mysql_query(convert_sql($sqlmatch));
		while ($rowsmatch = mysql_fetch_array($resultmatch)) {
			##### CALCULATE RESULTS GAMES
			$last_result = $rowsmatch["id_winner"];
			if ($rowstandings["id_squad"] == $rowsmatch["id_winner"]) { $gameswin++; }
			else { if ($rowsmatch["id_winner"] == 0) { $gamestie++; }
				else { $gameslost++; }
			}
			##### CALCULATE RESULTS MAPS
			$sqlmaps = "select * from vs_match_maps WHERE id_match=".$rowsmatch["id"];
			$resultmaps = mysql_query(convert_sql($sqlmaps));
			while ($rowsmaps = mysql_fetch_array($resultsmaps)) {
				if ($rowstandings["id_squad"] == $rowsmaps["id_squad_win"]) { $mapswin++; }
				else { if ($rowsmaps["id_squad_win"] == 0) { $mapstie++; }
					else { $mapslost++;	}
				}
			}
			##### CALCULATE RESULTS POINTS ELO
			if ($rowladder["system_elo"] == 1) {
				if ($rowsmatch["id_local_squad"] == $rowstandings["id_squad"]) {
					if ($rowstandings["id_squad"] == $rowsmatch["id_winner"]) {	$points = ($points + $rowsmatch["points_win"]);	}
					else {
						if ($rowsmatch["id_winner"] == 0) {	$points = ($points + $rowsmatch["points_tie"]);	}
						else { $points = ($points + $rowsmatch["points_lost"]); }
					}
				}
				if ($rowsmatch["id_visitant_squad"] == $rowstandings["id_squad"]) {
					if ($rowstandings["id_squad"] == $rowsmatch["id_winner"]) { $points = ($points - $rowsmatch["points_lost"]); }
					else {
						if ($rowsmatch["id_winner"] == 0) {	$points = ($points - $rowsmatch["points_tie"]);	}
						else { $points = ($points - $rowsmatch["points_win"]); }
					}
				}
			}
		}
		##### CALCULATE RESULTS POINTS GAMES
		if ($rowladder["system_games"] == 1) {
			$points = $points + ($rowladder["game_points_win"] * $gameswin);
			$points = $points + ($rowladder["game_points_tie"] * $gamestie);
			$points = $points + ($rowladder["game_points_lost"] * $gamelost);
		}
		##### CALCULATE RESULTS POINTS MAPS
		if ($rowladder["system_maps"] == 1) {
			$points = $points + ($rowladder["map_points_win"] * $mapswin);
			$points = $points + ($rowladder["map_points_tie"] * $mapstie);
			$points = $points + ($rowladder["map_points_lost"] * $mapslost);
		}
		##### UPDATE STANDINGS
		$sql = "update vs_standings set ";
		$sql = $sql."gameswin=".$gameswin;
		$sql = $sql.",gamestie=".$gamestie;
		$sql = $sql.",gameslost=".$gameslost;
		$sql = $sql.",mapswin=".$mapswin;
		$sql = $sql.",mapstie=".$mapstie;
		$sql = $sql.",mapslost=".$mapslost;
		$sql = $sql.",points=".$points;
		if ($last_result == $rowstandings["id_squad"]) { $sql = $sql.",last_result=1"; }
		else {
			if ($last_result == 0 ) { $sql = $sql.",last_result=0"; }
			else { $sql = $sql.",last_result=-1"; }
		}
		$sql = $sql." WHERE id=".$rowstandings["id"];
		mysql_query(convert_sql($sql));
	}
	
	$posicion = 0;
	$puntosanteriores = 0;
	$sqlstandings = "select * from vs_standings WHERE (id_ladder=".$id_ladder.") AND (blocked=0) AND ((gameswin>0) OR (gamestie>0) OR (gameslost>0)) AND (hibernado=0)  ORDER BY lider DESC, points-penalties-autopenalties DESC";
	$resultstandings = mysql_query(convert_sql($sqlstandings));
	while ($rowstandings = mysql_fetch_array($resultstandings)) {
		$puntosactuales = $rowstandings["points"] - $rowstandings["penalties"] - $rowstandings["autopenalties"];
		if ($puntosanteriores != $puntosactuales) { $posicion++; }
		$sql = "update vs_standings set ";
		$sql = $sql."posicion=".$posicion;
		$sql = $sql." WHERE id=".$rowstandings["id"];
		mysql_query(convert_sql($sql));
		$puntosanteriores = $puntosactuales;
	}
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
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
					$tareas = $row["total"];
				if ($programada != 0) {
					$sql = "select count(*) as total from sgm_incidencias where programada=".$programada;
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
						$tareas = $tareas + $row["total"];
				}
				$minutos = 0;
				if ($tareas > 0) {
					$mesok .= "<br><strong>".$tareas."</strong> Tareas";
						$sql = "select* from sgm_incidencias where (data_prevision like '%".$fecha."%') and programada=0";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							$minutos = $minutos + $row["tiempo"];
						}
						$sql = "select * from sgm_incidencias where programada=".$programada;
						$result = mysql_query(convert_sql($sql));
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


function av_alumno($userid,$iaula)
{ 
	global $db;
	$resultado = false;
		$sql = "select count(*) as total from av_iaula_users where id_user=".$userid." and id_iaula=".$iaula;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { $resultado = true; }
	return $resultado; 
}

function av_tutor($userid,$iaula)
{ 
	global $db;
	$resultado = false;
		$sqladmin = "select * from av_iaula_users where id_user=".$userid." and id_iaula=".$iaula;
		$resultadmin = mysql_query(convert_sql($sqladmin));
		$rowadmin = mysql_fetch_array($resultadmin);
		if ($rowadmin["tutor"] == 1) { $resultado = true; }
	return $resultado; 
}

function av_administrador($userid,$iaula)
{ 
	global $db;
	$resultado = false;
		$sqladmin = "select * from av_iaula_users where id_user=".$userid." and id_iaula=".$iaula;
		$resultadmin = mysql_query(convert_sql($sqladmin));
		$rowadmin = mysql_fetch_array($resultadmin);
		if ($rowadmin["administrador"] == 1) { $resultado = true; }
	return $resultado; 
}

function av_mes($year,$mes,$iaula) { 
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
		$mesok = "<table style=\"background-color:#9999cc\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"text-align:center;\">";
		$mesok .= "<strong>".$mesesp."</strong> ".$year;
		$mesok .= "</td></tr><tr><td>";
		$mesok .= "<table style=\"background-color:#9999cc\"><tr>";
		$sumadias = 0;
		$diasemana = 1;
		$semanax = 0;
		$control = 0;
		while (($d < 32) and ($mes == $m)) {
			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) { $diasemana = 7; }
			$semana = date("W", mktime(0,0,0,$m ,$d, $a));
			if ($mes != $mesanterior) {
				$mesok .= "<td style=\"text-align:center\">L</td>";
				$mesok .= "<td style=\"text-align:center\">M</td>";
				$mesok .= "<td style=\"text-align:center\">X</td>";
				$mesok .= "<td style=\"text-align:center\">J</td>";
				$mesok .= "<td style=\"text-align:center\">V</td>";
				$mesok .= "<td style=\"text-align:center\">S</td>";
				$mesok .= "<td style=\"text-align:center\">D</td>";
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
			$sqla = "select count(*) as total from av_iaula_actividades where fecha='".$fecha."' and id_iaula=".$iaula;
			$resulta = mysql_query(convert_sql($sqla));
			$rowa = mysql_fetch_array($resulta);
			if (($fecha != $hoy) and ($rowa["total"] == 0)) { $color = 'white'; }
			if (($fecha != $hoy) and ($rowa["total"] == 1)) { 
				$sqlac = "select * from av_iaula_actividades where fecha='".$fecha."' and id_iaula=".$iaula;
				$resultac = mysql_query(convert_sql($sqlac));
				$rowac = mysql_fetch_array($resultac);
				$sqlac2 = "select * from av_iaula_actividades_tipos where id='".$rowac["id_tipo_actividad"]."'";
				$resultac2 = mysql_query(convert_sql($sqlac2));
				$rowac2 = mysql_fetch_array($resultac2);
				$color = $rowac2["color"];
			}
			if (($fecha != $hoy) and ($rowa["total"] > 1)) { $color = 'silver'; }
			if (($fecha == $hoy) and ($rowa["total"] > 0)) { $color = '#FF4848'; }
			if (($fecha == $hoy) and ($rowa["total"] == 0)) { $color = '#FFCC33'; }
			$mesok .= "<td style=\"text-align:center;width:20px;background-color:".$color.";height:15px;\">";
			if ($rowa["total"] >= 1) { $mesok .= "<a href=\"index.php?op=700&sop=2007&iaula=".$_GET["iaula"]."&fecha=".$fecha."\" style=\"color:black\">".$d."</a>"; }
			else { $mesok .= $d; }
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
			$resulta = mysql_query(convert_sql($sqla));
			$rowa = mysql_fetch_array($resulta);
			if (($fecha != $hoy) and ($rowa["total"] == 0)) { $color = 'white'; }
			if (($fecha != $hoy) and ($rowa["total"] == 1)) { 
				$sqlac = "select * from av_iaula_actividades where fecha='".$fecha."' and id_iaula=".$iaula;
				$resultac = mysql_query(convert_sql($sqlac));
				$rowac = mysql_fetch_array($resultac);
				$sqlac2 = "select * from av_iaula_actividades_tipos where id='".$rowac["id_tipo_actividad"]."'";
				$resultac2 = mysql_query(convert_sql($sqlac2));
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



function valida_nif_cif_nie($cif) {
	//returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad,-3 = NIE bad, 0 = ??? bad
	$cif=strtoupper($cif);
	if (!ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)',$cif)) { return 0; }
	
	for ($i=0;$i<9;$i++) {$num[$i]=substr($cif,$i,1);}
	$suma=$num[2]+$num[4]+$num[6];
	
	for ($i=1;$i<8;$i+=2) {$suma+=substr((2*$num[$i]),0,1)+substr((2*$num[$i]),1,1);}
	$n=10-substr($suma,strlen($suma)-1,1);
	
	if (ereg('^[ABCDEFGHJNPQRSVW]{1}',$cif)) {
	if ($num[8]==chr(64+$n) || $num[8]==substr($n,strlen($n)-1,1)) {return 2;} else {return -2;}}
	
	if (ereg('^[KLM]{1}',$cif)) {
	if ($num[8]==chr(64+$n)) {return 2;} else {return -2;}}
	
	if (ereg('^[TX]{1}',$cif)) {
	if ($num[8]==substr("TRWAGMYFPDXBNJZSQVHLCKE",substr(ereg_replace('X','0',$cif),0,8)%23,1) || ereg('^[T]{1}[A-Z0-9]{8}$',$cif)) {return 3;} else {return -3;}}
	
	if (ereg('(^[0-9]{8}[A-Z]{1}$)',$cif)) {
	if ($num[8]==substr("TRWAGMYFPDXBNJZSQVHLCKE",substr($cif,0,8)%23,1)) {return 1;} else {return -1;}}
	return 0;
}

function subirArchivo($tipo, $archivo, $archivo_name, $archivo_size, $archivo_type,$id_cuerpo,$id_article,$id_client,$id_contrato,$id_incidencia) {
	global $db,$errorSubirArchivoDuplicado,$errorSubirArchivoTamany;
	
	if ($id_cuerpo > 0) {$adress = "facturas/";}
	if ($id_article > 0) {$adress = "articulos/";}
	if ($id_client > 0) {$adress = "clientes/";}
	if ($id_contrato > 0) {$adress = "contratos/";}
	if ($id_incidencia > 0) {$adress = "incidencias/";}

	$sql = "select * from sgm_files_tipos where id=".$tipo;
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	$lim_tamano = $row["limite_kb"]*1000;
	$sqlt = "select count(*) as total from sgm_files where name='".$archivo_name."'";
	$resultt = mysql_query(convert_sql($sqlt));
	$rowt = mysql_fetch_array($resultt);
	if ($rowt["total"] != 0) {
		echo mensaje_error($errorSubirArchivoDuplicado);
	} else {
		if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
			if (copy ($archivo, "archivos/".$adress.$archivo_name)) {
				$camposInsert = "id_tipo,name,type,size,id_cuerpo,id_article,id_client,id_contrato,id_incidencia";
				$datosInsert = array($tipo,$archivo_name,$archivo_type,$archivo_size,$id_cuerpo,$id_article,$id_client,$id_contrato,$id_incidencia);
				insertFunction ("sgm_files",$camposInsert,$datosInsert);
			}
		}else{
			echo mensaje_error($errorSubirArchivoTamany);
		}
	}
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
			$resulta = mysql_query(convert_sql($sqla));
			$rowa = mysql_fetch_array($resulta);
			if (($fecha != $hoy) and ($rowa["total"] == 0)) { $color = 'white'; }
			if (($fecha != $hoy) and ($rowa["total"] == 1)) { 
				$sqlac = "select * from av_iaula_actividades where fecha='".$fecha."' and id_iaula=".$iaula;
				$resultac = mysql_query(convert_sql($sqlac));
				$rowac = mysql_fetch_array($resultac);
				$sqlac2 = "select * from av_iaula_actividades_tipos where id='".$rowac["id_tipo_actividad"]."'";
				$resultac2 = mysql_query(convert_sql($sqlac2));
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
						$resultux = mysql_query(convert_sql($sqlux));
						while ($rowux = mysql_fetch_array($resultux)) {	
							$sql .= " or (id_usuario_destino=".$rowux["id_usuari_propietari"]." or id_2=".$rowux["id_usuari_propietari"]." or id_3=".$rowux["id_usuari_propietari"]." or id_4=".$rowux["id_usuari_propietari"]." or id_5=".$rowux["id_usuari_propietari"]." or id_6=".$rowux["id_usuari_propietari"]." or id_7=".$rowux["id_usuari_propietari"]." or id_8=".$rowux["id_usuari_propietari"]." or id_9=".$rowux["id_usuari_propietari"]." or id_10=".$rowux["id_usuari_propietari"].")";
						}
					}

					$sql .=	") and privada=1 order by data_prevision";

					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)){
							$hora = date("H", strtotime($row["data_prevision"])); 
							$minut = date("i", strtotime($row["data_prevision"]));

							$estado_color = "White";
							if ($row["id_estado"] > 0) {
								$sqle = "select * from sgm_incidencias_estados where id=".$row["id_estado"];
								$resulte = mysql_query(convert_sql($sqle));
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
								$resultusuario = mysql_query(convert_sql($sqlusuario));
								$rowusuario = mysql_fetch_array($resultusuario);
								$mesok .= "<tr><td style=\"color:".$estado_color_letras."\"><strong>".$rowusuario["usuario"]."</strong></td></tr>";
							for ($i = 2 ; $i < 11 ; $i++) {
								if ($row["id_".$i] != 0) {
									$sqlusuario = "select * from sgm_users where id=".$row["id_".$i];
									$resultusuario = mysql_query(convert_sql($sqlusuario));
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