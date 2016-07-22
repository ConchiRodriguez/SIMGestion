<?php 
	error_reporting(E_ALL);

	include ("../config.php");
#	include ("../../archivos_comunes/functions.php");
	foreach (glob("../auxiliar/*.php") as $filename)
	{
		include ($filename);
	}
	$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
	$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

	$idioma = strtolower("es");
	include ("lenguajes/factura-print-".$idioma.".php");

	define("FPDF_FONTPATH","../font/");
	require('fpdf.php');

	$pdf=new FPDF();
	$pdf->AddFont('Calibri','','../font/Calibri.php');
	$pdf->AddFont('Calibri-Bold','B','../font/Calibrib.php');
	$pdf->AddFont('Calibri','B','../font/Calibrib.php');
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$pdf->Image('../../archivos_comunes/images/logo1.jpg',5,5,50,11);

	$pdf->SetXY(40,5);
	$pdf->SetFont('Calibri','B',18);
	$pdf->Cell(140,20,$recibo,0,1,'C');

	$pdf->SetFont('Calibri','',8);

	$sqlr = "select * from sim_factura_recibos where id=".$_GET["id"];
	$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
	$rowr = mysqli_fetch_array($resultr);
	$sqlf = "select * from sim_factura where id=".$rowr["id_factura"];
	$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
	$rowf = mysqli_fetch_array($resultf);
	$sqlele = "select * from sim_factura_dades_origen";
	$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
	$rowele = mysqli_fetch_array($resultele);
	$sqldi = "select * from sim_divisas where id=".$rowf["id_divisa"];
	$resultdi = mysqli_query($dbhandle,convertSQL($sqldi));
	$rowdi = mysqli_fetch_array($resultdi);
	$sqlxtp = "select * from sim_factura_tipos_pago where id=".$rowr["id_tipo_pago"];
	$resultxtp = mysqli_query($dbhandle,convertSQL($sqlxtp));
	$rowxtp = mysqli_fetch_array($resultxtp);

	$pdf->SetXY(5,20);
	$pdf->MultiCell(50,5,$numero."\n".$rowf["numero"]."/".$rowr["numero_serie"],1);
	$pdf->SetXY(55,20);
	$pdf->MultiCell(50,5,$fecha."\n".cambiarFormatoFechaDMY($rowr["fecha"]),1);
	$pdf->SetXY(105,20);
	$pdf->MultiCell(50,5,$poblacion."\n".$rowele["poblacion"],1);
	$pdf->SetXY(155,20);
	$pdf->MultiCell(50,5,$forma_de_pago."\n".$rowxtp["id_tipo"],1);

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
	$pdf->SetFont('Calibri','',6);
	$pdf->MultiCell(200,3,$texto_pdatos,0,'J');

	$pdf->Output("../pdf/recibo.pdf");
	header("Location: ../pdf/recibo.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);


?>

