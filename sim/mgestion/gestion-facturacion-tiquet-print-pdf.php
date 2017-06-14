<?php 
	error_reporting(~E_ALL);

	include ("../config.php");
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

	$sqlele = "select * from sgm_dades_origen_factura";
	$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
	$rowele = mysqli_fetch_array($resultele);

	$pdf->Image('../../archivos_comunes/images/logo3.jpg',3,5,10,10);
	$pdf->SetFont('Calibri','',6);
	$pdf->SetXY(15,5);
	$pdf->Cell(50,3,$rowele["nombre"],0,1,'C');
	$pdf->SetXY(15,8);
	$pdf->Cell(50,3,$rowele["nif"]."   ".$rowele["direccion"],0,1,'C');
	$pdf->SetXY(15,11);
	$pdf->Cell(50,3,$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"],0,1,'C');

	$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
	$resultcabezera = mysqli_query($dbhandle,convertSQL($sqlcabezera));
	$rowcabezera = mysqli_fetch_array($resultcabezera);
	$pdf->SetXY(3,18);
	$pdf->Cell(60,3,$fecha.": ".$rowcabezera["fecha"]."    ".$numero.": ".$rowcabezera["numero"],0,1);

	$pdf->SetXY(3,23);
	$pdf->Cell(40,3,"".$nombre."",'B',0);
	$pdf->Cell(10,3,"".$unitats."",'B',0);
	$pdf->Cell(10,3,"".$total."",'B',1);
	$pdf->SetX(3);

	$sqldi = "select * from sgm_divisas where id=".$rowcabezera["id_divisa"];
	$resultdi = mysqli_query($dbhandle,convertSQL($sqldi));
	$rowdi = mysqli_fetch_array($resultdi);

	$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
	$result = mysqli_query($dbhandle,convertSQL($sql));
	while ($row = mysqli_fetch_array($result)) {
		$pdf->Cell(40,4,$row["nombre"],'',0);
		$pdf->Cell(10,4,number_format($row["unidades"], 2, ',', '.'),'',0);
		$pdf->Cell(10,4,number_format($row["total"], 2, ',', '.')." ".$rowdi["abrev"],'',1);
		$pdf->SetX(3);
	}

	$pdf->Cell(20,3,"".$subtotal."",'LTR',0);
	$pdf->Cell(20,3,"IVA (".$rowele["iva"].")",'LTR',0);
	$pdf->Cell(20,3,"".$total."",'LTR',1);
	$pdf->SetX(3);

	$pdf->Cell(20,3,number_format($rowcabezera["subtotaldescuento"], 2, ',', '.')." ".$rowdi["abrev"],'LBR',0);
	$iva = (($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["iva"]);
	$pdf->Cell(20,3,number_format($iva, 2, ',', '.')." ".$rowdi["abrev"],'LBR',0);
	$pdf->Cell(20,3,number_format($rowcabezera["total"], 2, ',', '.')." ".$rowdi["abrev"],'LBR',1);
	$pdf->SetX(3);

	$sqlxtp = "select * from sgm_tpv_tipos_pago where id=".$rowcabezera["id_tipo_pago"];
	$resultxtp = mysqli_query($dbhandle,convertSQL($sqlxtp));
	$rowxtp = mysqli_fetch_array($resultxtp);
	$pdf->Cell(60,4,$forma_de_pago.": ".$rowxtp["tipo"],0,1);

	$pdf->Output("../pdf/tiquet.pdf");
	header("Location: ../pdf/tiquet.pdf");


	// Cerrar la conexión
	mysql_close($dbhandle);


?>

