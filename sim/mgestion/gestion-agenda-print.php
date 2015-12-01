<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}

	include ("../config.php");
	include ("../auxiliar/functions.php");

### CONEXIO PLATAFORMA
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}

if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			if ($row["pass"] == $_POST["pass"]) {
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, "/");
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
				header("Location: ".$urloriginal."/index.php?op=200");
			}
		}
	}
}
else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["pass"] == $_COOKIE["mpassword"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, "/");
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
		}
	}
}


$autorizado = false;
if ($user == true) {
		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convertSQL($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }

		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowi["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysql_query(convertSQL($sqlpermiso));
		$rowpermiso = mysql_fetch_array($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }

}
if ($autorizado == true) {
	$nombre_archivo = 'C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\mgestion\\logo.jpeg';
	$file=fopen($nombre_archivo,'w+');
	if (is_writable($nombre_archivo)) {
		$sql = "select * from sgm_logos where clase=4";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
			if (fwrite($file,$row["contenido"]) === FALSE) {
				mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
				exit;
			}
			fclose($file);
	} else {
		mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
	}

	define("FPDF_FONTPATH","C:/Archivos de programa/EasyPHP1-8/www/demo/font/");
	require('fpdf.php');

	class PDF extends FPDF
	{
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
			//Logo
			$this->Image('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\mgestion\\logo.jpeg',160,285,40);
		}
	}

	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$sqli = "select * from sgm_incidencias where id=".$_GET["id"];
	$resulti = mysql_query(convertSQL($sqli));
	$rowi = mysql_fetch_array($resulti);

	$sql = "select * from sgm_clients where id=".$rowi["id_cliente"];
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);

	$pdf->SetFont('Arial','B',16);
	$sqlt = "select * from sgm_clients_tratos where id=".$row["id_trato"];
	$resultt = mysql_query(convertSQL($sqlt));
	$rowt = mysql_fetch_array($resultt);
	if ($rowt["trato"] != ""){
		$pdf->Cell(0,10,"".$rowt["trato"]." ".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."",0,1);
	} else {
		$pdf->Cell(0,10,"".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."",0,1);
	}
	$pdf->SetFont('Arial','',8);
	$pdf->SetFont('Arial','',8);
	if ($row["id_carrer"] == 0){
		$pdf->Cell(0,5,"".$row["direccion"]." ".$row["telefono"]." ".$row["telefono2"]."",0,1);
	} else {
		$sqltc = "select * from sgm_clients_carrer_tipo where id=".$row["id_tipo_carrer"];
		$resulttc = mysql_query(convertSQL($sqltc));
		$rowtc = mysql_fetch_array($resulttc);
		$sqlc = "select * from sgm_clients_carrer where id=".$row["id_carrer"];
		$resultc = mysql_query(convertSQL($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlszf = "select * from sgm_clients_carrer where id=".$row["id_sector_zf"];
		$resultszf = mysql_query(convertSQL($sqlszf));
		$rowszf = mysql_fetch_array($resultszf);
		if ($rowszf["nombre"] != ""){$sector = "sector ".$rowszf["nombre"];}
		$pdf->Cell(0,5,"".$rowtc["nombre"]." ".$rowc["nombre"]." ".$row["numero"]." ".$sector." ".$row["telefono"]." ".$row["telefono2"]."",0,1);
	}
	$pdf->Cell(0,5,"".$row["poblacion"]." ".$row["cp"]." ".$row["fax1"]." ".$row["fax2"]."",0,1);
	$pdf->Cell(0,5,"".$row["provincia"]." ".$row["mail"]."",0,1);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,"Incidencia : ".$rowi["id"]."",0,1);
	$pdf->Cell(0,5,"Fecha : ".$rowi["data_registro"]."",0,1);
	$pdf->Cell(0,5,"Fecha prevision : ".$rowi["data_prevision"]."",0,1);
	$pdf->Cell(0,5,"Fecha margen : ".$rowi["data_margen"]."",0,1);

	$sqli2 = "select * from sgm_agendas_users where propietario=1 and id_agenda=".$rowi["id_agenda"];
	$resulti2 = mysql_query(convertSQL($sqli2));
	$rowi2 = mysql_fetch_array($resulti2);
	$sqli3 = "select * from sgm_users where id=".$rowi2["id_user"];
	$resulti3 = mysql_query(convertSQL($sqli3));
	$rowi3 = mysql_fetch_array($resulti3);
	$pdf->Cell(0,5,"Técnico responsable : ".$rowi3["usuario"]."",0,1);

	if($rowi["id_estado"] < 0){
		if($rowi["id_estado"] == -1){$estado = "Registrada";}
		if($rowi["id_estado"] == -2){$estado = "Finalizada";}
	} else {
		$sqli2 = "select * from sgm_incidencias_estados where id=".$rowi["id_estado"];
		$resulti2 = mysql_query(convertSQL($sqli2));
		$rowi2 = mysql_fetch_array($resulti2);
		$estado = $rowi2["estado"];
	}
	$pdf->Cell(0,5,"Estado incidencia : ".$estado."",0,1);

	$sqli2 = "select * from sgm_incidencias_tipos where id=".$rowi["id_tipo"];
	$resulti2 = mysql_query(convertSQL($sqli2));
	$rowi2 = mysql_fetch_array($resulti2);
	$pdf->Cell(0,5,"Tipo : ".$rowi2["tipo"]."",0,1);

	$sqli2 = "select * from sgm_incidencias_entrada where id=".$rowi["id_entrada"];
	$resulti2 = mysql_query(convertSQL($sqli2));
	$rowi2 = mysql_fetch_array($resulti2);
	$pdf->Cell(0,5,"Entrada : ".$rowi2["entrada"]."",0,1);

	$pdf->Ln();
	$pdf->Cell(0,5,"Notas registro : ",0,1);
	$pdf->MultiCell(0,5,"".$rowi["notas_registro"]."");

	$pdf->Ln();
	$pdf->Cell(0,5,"Notas desarrollo : ",0,1);
	$sqln = "select * from sgm_incidencias_notas_desarrollo where id_incidencia=".$rowi["id"]." order by fecha";
	$resultn = mysql_query(convertSQL($sqln));
	while($rown= mysql_fetch_array($resultn)){
		$pdf->MultiCell(0,5,"".$rown["fecha"]." - ".$rown["notas"]."");
	}

	$pdf->Ln();
	$pdf->Cell(0,5,"Notas conclusion : ",0,1);
	$pdf->MultiCell(0,5,"".$rowi["notas_conclusion"]."");

	$pdf->Output("../pdf/incidencia.pdf");

	if (!unlink('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\mgestion\\logo.jpeg')){
		echo "no se pudo borrar la imagen";
	}
	header("Location: ".$urloriginal."/pdf/incidencia.pdf");
}
else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>


</body>
</html>
