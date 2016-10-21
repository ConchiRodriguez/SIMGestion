<?php 
#	error_reporting(~E_ALL);

	include ("../config.php");
	foreach (glob("../auxiliar/*.php") as $filename)
	{
		include ($filename);
	}
	$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
	$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

	$idioma = strtolower($_POST["idioma"]);
	include ("lenguajes/factura-print-".$idioma.".php");

	require('html2pdf.php');



	$texto_html='';
	
	$sqlof = "select * from sim_comercial_oferta where id=".$_GET["id"];
	$resultof = mysqli_query($dbhandle,convertSQL($sqlof));
	$rowof = mysqli_fetch_array($resultof);

	$sqlofc = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"];
	$resultofc = mysqli_query($dbhandle,convertSQL($sqlofc));
	while ($rowofc = mysqli_fetch_array($resultofc)){
		$sqlcon = "select * from sim_comercial_contenido where id=".$rowofc["id_comercial_contenido"];
		$resultcon = mysqli_query($dbhandle,convertSQL($sqlcon));
		$rowcon = mysqli_fetch_array($resultcon);
		if ($_POST["tipo"] == 0) {$contenido = $rowcon["contenido"];} else {$contenido = $rowcon["contenido"].$rowcon["contenido_extenso"];}
		$texto_html = $texto_html."<h4>".$rowofc["orden"]." ".$rowcon["titulo"]."<h4><br>".$contenido."<br>";
	}

    $pdf = new createPDF($texto_html,$rowof["descripcion"]);
    $pdf->run();


#	header("Location: ../pdf/oferta.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>
