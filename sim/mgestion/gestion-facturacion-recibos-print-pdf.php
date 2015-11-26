<?php 
	error_reporting(E_ALL);

	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$idioma = strtolower("es");
	include ("lenguajes/factura-print-".$idioma.".php");

	define("FPDF_FONTPATH","../font/");
	require('fpdf.php');

	$pdf=new FPDF();
	$pdf->AddFont('Verdana','','../../archivos_comunes/font/verdana.php');
	$pdf->AddFont('Verdana-Bold','B','../../archivos_comunes/font/verdanab.php');
	$pdf->AddFont('Verdana','B','../../archivos_comunes/font/verdanab.php');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->Image('../../archivos_comunes/images/logo1.jpg',5,5,50,11);

	$pdf->SetXY(40,5);
	$pdf->SetFont('Verdana','B',18);
	$pdf->Cell(140,20,$recibo,0,1,'C');

	$pdf->SetFont('Verdana','',8);

	$sqlr = "select * from sgm_recibos where id=".$_GET["id"];
	$resultr = mysql_query(convert_sql($sqlr));
	$rowr = mysql_fetch_array($resultr);
	$sqlf = "select * from sgm_cabezera where id=".$rowr["id_factura"];
	$resultf = mysql_query(convert_sql($sqlf));
	$rowf = mysql_fetch_array($resultf);
	$sqlele = "select * from sgm_dades_origen_factura";
	$resultele = mysql_query(convert_sql($sqlele));
	$rowele = mysql_fetch_array($resultele);
	$sqldi = "select * from sgm_divisas where id=".$rowf["id_divisa"];
	$resultdi = mysql_query(convert_sql($sqldi));
	$rowdi = mysql_fetch_array($resultdi);
	$sqlxtp = "select * from sgm_tpv_tipos_pago where id=".$rowr["id_tipo_pago"];
	$resultxtp = mysql_query(convert_sql($sqlxtp));
	$rowxtp = mysql_fetch_array($resultxtp);

	$pdf->SetXY(5,20);
	$pdf->MultiCell(50,5,$numero."\n".$rowf["numero"]."/".$rowr["numero_serie"],1);
	$pdf->SetXY(55,20);
	$pdf->MultiCell(50,5,$fecha."\n".cambiarFormatoFechaDMY($rowr["fecha"]),1);
	$pdf->SetXY(105,20);
	$pdf->MultiCell(50,5,$poblacion."\n".$rowele["poblacion"],1);
	$pdf->SetXY(155,20);
	$pdf->MultiCell(50,5,$forma_de_pago."\n".$rowxtp["tipo"],1);

	$pdf->SetXY(5,30);
	$pdf->MultiCell(150,5,$acreedor."\n".$rowele["nombre"],1);
	$pdf->SetXY(155,30);
	$pdf->MultiCell(50,5,$nif."\n".$rowele["nif"],1);

	$pdf->SetXY(5,40);
	$pdf->MultiCell(150,5,$deudor."\n".$rowr["nombre"],1);
	$pdf->SetXY(155,40);
	$pdf->MultiCell(50,5,$nif."\n".$rowr["nif"],1);

	$pdf->SetXY(5,50);
	$pdf->MultiCell(50,5,$importe."\n".number_format($rowr["total"], 2, ',', '.')." ".$rowdi["abrev"],1);
	$pdf->SetXY(55,50);
	$pdf->MultiCell(150,5,$importe."\n".strtoupper(convertir_a_letras($rowr["total"]))." ".$rowdi["abrev"],1);

	$pdf->SetXY(5,62);
	$pdf->SetFont('Verdana','',6);
	$pdf->MultiCell(200,3,$texto_pdatos,0,'J');

	$pdf->Output("../pdf/recibo.pdf");
	header("Location: ../pdf/recibo.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);


?>

