<?php 
#error_reporting(~E_ALL);

	include ("../config.php");
	include ("../../archivos_comunes/functions.php");
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

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

	$pdf->Image('../../archivos_comunes/images/logo1.jpg',10,10,60,13);
	$pdf->SetFont('Calibri','B',8);
	$pdf->SetXY(10,25);

	if ($_POST["subfamilia"] > 0){ 
		$sqlsf = "select * from sgm_articles_subgrupos where id=".$_POST["subfamilia"];
		$resultsf = mysql_query(convert_sql($sqlsf));
		$rowsf = mysql_fetch_array($resultsf);

		$sqlf = "select * from sgm_articles_grupos where id=".$rowsf["id_grupo"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);

		$pdf->Cell(180,10, $listado_articulos.": ".$rowf["grupo"]." - ".$rowsf["subgrupo"],0,1);
	} else {
		$pdf->Cell(180,10, $listado_articulos.": ",0,1);
	}

	$pdf->Cell(40,5,"".$codigo."",'LTB',0);
	$pdf->Cell(80,5,"".$nombre."",'TB',0);
	$pdf->Cell(20,5,"".$unitats."",'TB',0);
	$pdf->Cell(20,5,"PVD",'TB',0);
	$pdf->Cell(20,5,"PVP",'TBR',1);

	$sql = "select * from sgm_articles where visible=1 ";
	if ($_POST["subfamilia"] > 0){ $sql = $sql."and id_subgrupo=".$_POST["subfamilia"];	}
	$sql = $sql." order by codigo";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)) {
		$sqls = "select * from sgm_stock WHERE vigente=1 and id_article=".$row["id"];
		$results = mysql_query(convert_sql($sqls));
		$rows = mysql_fetch_array($results);

		$pdf->Cell(40,5,$row["codigo"],'',0);
		$pdf->Cell(80,5,$row["nombre"],'',0);
		$pdf->Cell(20,5,$rows["unidades"],'',0);
		$pdf->Cell(20,5,$rows["pvd"],'',0);
		$pdf->Cell(20,5,$rows["pvp"],'',1);
	}

	$pdf->Output("../pdf/articulos_lista.pdf");
	header("Location: ../pdf/articulos_lista.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>
