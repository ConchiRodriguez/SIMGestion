<?php 
#error_reporting(~E_ALL);

	include ("../config.php");
	include ("../functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
	$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}

	$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
	$resultcabezera = mysql_query(convert_sql($sqlcabezera));
	$rowcabezera = mysql_fetch_array($resultcabezera);

	$sqlc = "select * from sgm_clients where id=".$rowcabezera["id_cliente"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);

	$sqli = "select * from sgm_idiomas where id=".$rowc["id_idioma"];
	$resulti = mysql_query(convert_sql($sqli));
	$rowi = mysql_fetch_array($resulti);
	$idioma = strtolower($rowi["idioma"]);
	include ("../mgestion/lenguajes/factura-print-".$idioma.".php");

	define("FPDF_FONTPATH","../font/");
	require('fpdf.php');


	//Creación del objeto de la clase heredada
	$pdf=new FPDF();
	$pdf->AddFont('Verdana','','../font/verdana.php');
	$pdf->AddFont('Verdana-Bold','B','../font/verdanab.php');
	$pdf->AddFont('Verdana','B','../font/verdanab.php');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$sqlele = "select * from sgm_dades_origen_factura";
	$resultele = mysql_query(convert_sql($sqlele));
	$rowele = mysql_fetch_array($resultele);

if ($_GET["tipo"] == 1) {
	$pdf->Image('../images/logos/logo1.jpg',10,5,80,18);

	$pdf->SetXY(10,25);
	$pdf->SetFont('Verdana','',8);
	$pdf->Cell(90,4,$rowele["nombre"],0,0);
	$pdf->Cell(90,4,$rowele["direccion"],0,1);
	$pdf->Cell(90,4,$rowele["nif"],0,0);
	$pdf->Cell(90,4,$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"],0,1);
	$pdf->Cell(90,4, "Teléfono: ".$rowele["telefono"],0,0);
	$pdf->Cell(90,4, "E-mail: ".$rowele["mail"],0,1);
	$pdf->Cell(90,4,"",0,1);

	$pdf->SetFont('Verdana','',8);
	$pdf->Cell(90,5,$numero." : ".$rowcabezera["numero"]." / ".$rowcabezera["version"],1,0);
	$pdf->Cell(90,5,$fecha." : ".cambiarFormatoFechaDMY($rowcabezera["fecha"]),1,1);
	$pdf->Cell(90,5,$fecha_vencimiento." : ".cambiarFormatoFechaDMY($rowcabezera["fecha_vencimiento"]),1,0);
	$pdf->Cell(90,5,$fecha_entrega." : ".cambiarFormatoFechaDMY($rowcabezera["fecha_entrega"]),1,1);
	$pdf->Cell(90,5,$nombre." : ".$rowcabezera["nombre"],1,0);
	$pdf->Cell(90,5,$nif." / CIF: ".$rowcabezera["nif"],1,1);
	$pdf->Cell(90,5,$direccion." : ".$rowcabezera["direccion"],1,0);
	$pdf->Cell(90,5,$poblacion.": ".$rowcabezera["poblacion"],1,1);
	$pdf->Cell(90,5,$cp." : ".$rowcabezera["cp"],1,0);
	$pdf->Cell(90,5,$provincia.": ".$rowcabezera["provincia"],1,1);
}

if ($_GET["tipo"] == 0) {
	$pdf->Image('../images/logos/logo2.jpg',10,5,40,40);

	$pdf->SetXY(10,42);
	$pdf->SetFont('Verdana','',8);
	$pdf->Cell(90,4,"".$rowele["nombre"],0,1);
	$pdf->Cell(90,4,"".$rowele["nif"],0,1);
	$pdf->Cell(90,4,$rowele["direccion"],0,1);
	$pdf->Cell(90,4,$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"],0,1);
	$pdf->Cell(90,4, "Teléfono: ".$rowele["telefono"],0,1);
	$pdf->Cell(90,4, "E-mail: ".$rowele["mail"],0,1);
	$pdf->Cell(90,4,"",0,1);

	$pdf->SetXY(102,10);
	$pdf->SetFont('Verdana','',8);
	$pdf->MultiCell(90,3,$numero." : ".$rowcabezera["numero"]." / ".$rowcabezera["version"]."\n".$fecha." : ".cambiarFormatoFechaDMY($rowcabezera["fecha"])."\n".$fecha_vencimiento." : ".cambiarFormatoFechaDMY($rowcabezera["fecha_vencimiento"])."\n".$nombre." : ".$rowcabezera["nombre"]."\nNIF / CIF: ".$rowcabezera["nif"]."",0,'L');

	$pdf->SetXY(102,50);
	$pdf->SetFont('Verdana','',10);
	$pdf->MultiCell(95,5,$rowcabezera["nombre"]."\n".$rowcabezera["direccion"]."\n".$rowcabezera["poblacion"]." (".$rowcabezera["cp"].") ".$rowcabezera["provincia"],0,'L');
	$pdf->SetY(71);
}

	$sqlx = "select * from sgm_factura_tipos where id=".$rowcabezera["tipo"];
	$resultx = mysql_query(convert_sql($sqlx));
	$rowx = mysql_fetch_array($resultx);

	$pdf->SetFont('Verdana','B',18);
	$pdf->Cell(180,20,$rowx["tipo"],0,1,'C');
	$pdf->SetFont('Verdana','',10);
	$pdf->Cell(20,5,"".$fecha."",'LTB',0);
	$pdf->Cell(20,5,"".$codigo."",'TB',0);
	$pdf->Cell(80,5,"".$nombre."",'TB',0);
	$pdf->Cell(20,5,"".$unitats."",'TB',0);
	$pdf->Cell(20,5,"".$precio."",'TB',0);
	$pdf->Cell(20,5,"".$total."",'TBR',1);

	$pdf->SetFont('Verdana','',8);
	$unidades2 = 0;
	$lineas = 0;
	$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by linea";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)) {
		$data = date("d / m / y", strtotime($row["fecha_prevision"])); 
		$pdf->Cell(20,5,$data,'L',0);
		$pdf->Cell(20,5,$row["codigo"],'',0);
		$pdf->Cell(80,5,$row["nombre"],'',0);
		$pdf->Cell(20,5,$row["unidades"],'',0);
		$pdf->Cell(20,5,$row["pvp"].'€','',0);
		$pdf->Cell(20,5,$row["total"].'€','R',1);
		$unidades2 = $unidades2 + $row["unidades"];
		$lineas ++;
	}
	for ($i = 30; $i > $lineas; $i--){
		$pdf->Cell(180,5,'','LR',1);
	}
	$pdf->Cell(180,5,'','LBR',1);

	$pdf->Cell(36,5,"".$unitats."",'LTR',0);
	$pdf->Cell(36,5,"".$importe."",'LTR',0);
	$pdf->Cell(36,5,"".$descuento."",'LTR',0);
	$pdf->Cell(36,5,"IVA",'LTR',0);
	$pdf->Cell(36,5,"".$total."",'LTR',1);

	$pdf->Cell(36,5,$unidades2,'LBR',0);
	$pdf->Cell(36,5,$rowcabezera["subtotal"].'€','LBR',0);
	$pdf->Cell(36,5,'('.$rowcabezera["descuento"].'%)'.$rowcabezera["subtotaldescuento"],'LBR',0);
	$iva = (($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["iva"]);
	$pdf->Cell(36,5,$iva.'€','LBR',0);
	$pdf->Cell(36,5,$rowcabezera["total"].'€','LBR',1);

	$pdf->SetFont('Verdana','',6);
	$pdf->Cell(180,3,' ',0,1);
	$pdf->MultiCell(180,3,$texto_pdatos,0,1);

	$pdf->Output("factura.pdf");
	header("Location: ".$urloriginal."/mgestion/factura.pdf");


?>
