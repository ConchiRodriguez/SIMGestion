<?php 
error_reporting(E_ALL);

	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$idioma = strtolower("es");
	include ("../../archivos_comunes/factura-print-".$idioma.".php");

	define("FPDF_FONTPATH","../font/");
	require('fpdf.php');

	class PDF extends FPDF
	{
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			//times italic 8
			$this->SetFont('times','I',8);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
			//Logo
#			$this->Image('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg',160,285,40);
			$this->Image('../../archivos_comunes/images/logo1.jpg',160,285,40);
		}
	}

	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('times','B',16);
	$sql = "select * from sgm_clients where id=".$_GET["id"];
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);

	$sqlt = "select * from sgm_clients_tratos where id=".$row["id_trato"];
	$resultt = mysql_query(convert_sql($sqlt));
	$rowt = mysql_fetch_array($resultt);
	$pdf->Cell(0,10,"".$rowt["trato"]." ".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."",0,1);
	$pdf->SetFont('times','',10);
	$pdf->Cell(40,10,"Datos Generales",0,1);
	$pdf->SetFont('times','',8);
	if( $row["id_carrer"] == 0 ){
		$direccion = $row["cvia"]." ".$row["direccion"];
	} else {
		$sqlt = "select * from sgm_clients_carrer_tipo where id=".$row["id_tipo_carrer"];
		$resultt = mysql_query(convert_sql($sqlt));
		$rowt = mysql_fetch_array($resultt);
		$sqlc = "select * from sgm_clients_carrer where id=".$row["id_carrer"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlz = "select * from sgm_clients_sector_zf where id=".$row["id_sector_zf"];
		$resultz = mysql_query(convert_sql($sqlz));
		$rowz = mysql_fetch_array($resultz);
		$direccion = $rowt["nombre"]." ".$rowc["nombre"]."";
		if ($row["numero"] > 0){ $direccion .= " num.";}
		$direccion .= " ".$row["numero"]." ".$rowz["nombre"]."";
	}

	$pdf->Cell(0,5,"".$direccion." ".$row["telefono"]." ".$row["telefono2"]."",0,1);
	$pdf->Cell(0,5,"".$row["poblacion"]." ".$row["cp"]." ".$row["fax1"]." ".$row["fax2"]."",0,1);
	$pdf->Cell(0,5,"".$row["provincia"]." ".$row["mail"]."",0,1);
	if ($row["id_agrupacio"] > 0){
		$sqlj = "select count(*) as total from sgm_clients where visible=1 and id_agrupacio=".$row["id_agrupacio"]." and id<>".$row["id"];
		$resultj = mysql_query(convert_sql($sqlj));
		$rowj = mysql_fetch_array($resultj);
		$sqlj2 = "select count(*) as total from sgm_clients where visible=1 and id=".$row["id_agrupacio"];
		$resultj2 = mysql_query(convert_sql($sqlj2));
		$rowj2 = mysql_fetch_array($resultj2);
	}
	if ($row["id_agrupacio"] == 0){
		$sqlj3 = "select count(*) as total from sgm_clients where visible=1 and id_agrupacio=".$row["id"]." and id<>".$row["id_agrupacio"];
		$resultj3 = mysql_query(convert_sql($sqlj3));
		$rowj3 = mysql_fetch_array($resultj3);
	}
	if (($rowj["total"] > 0) or ($rowj2["total"] > 0) or ($rowj3["total"] > 0)){
		$pdf->SetFont('times','',10);
		$pdf->Cell(40,10,"Contacto Principal y Delegaciones",0,1);
	}
	$sqlc = "select * from sgm_clients where visible=1 order by nombre";
	$resultc = mysql_query(convert_sql($sqlc));
	while ($rowc = mysql_fetch_array($resultc)) {
		if( $rowc["id_carrer"] < 0 ){
			$direccion1 = $rowc["cvia"]." ".$rowc["direccion"];
		} else {
			$sqlt = "select * from sgm_clients_carrer_tipo where id=".$rowc["id_tipo_carrer"];
			$resultt = mysql_query(convert_sql($sqlt));
			$rowt = mysql_fetch_array($resultt);
			$sqlca = "select * from sgm_clients_carrer where id=".$rowc["id_carrer"];
			$resultca = mysql_query(convert_sql($sqlca));
			$rowca = mysql_fetch_array($resultca);
			$sqlz = "select * from sgm_clients_sector_zf where id=".$rowc["id_sector_zf"];
			$resultz = mysql_query(convert_sql($sqlz));
			$rowz = mysql_fetch_array($resultz);
			$direccion1 = $rowt["nombre"]." ".$rowca["nombre"]."";
			if ($row["numero"] > 0){ $direccion1 .= " num.";}
			$direccion1 .= " ".$rowc["numero"]." ".$rowz["nombre"]."";
		}
		if ($row["id_agrupacio"] > 0) {
			if (($rowc["id_agrupacio"] == $row["id_agrupacio"]) and ($rowc["id"] != $row["id"])) {
				$pdf->SetFont('times','',8);
				$pdf->Cell(0,5,"".$rowc["nombre"]."",0,1);
				$pdf->Cell(0,5,"".$rowc["nif"]."",0,1);
				$pdf->Cell(40,5,"".$direccion1."");
				if ($rowc["cp"] != "") {
					$pdf->Cell(0,5," (".$rowc["cp"].") ",0,1);
				} else {
					$pdf->Ln();
				}
				$pdf->Cell(0,5,"".$rowc["poblacion"]."",0,1);
				if ($rowc["provincia"] != "") {$pdf->Cell(0,5,"".$rowc["provincia"]."",0,1);}
				if ($rowc["telefono"] != "") { $pdf->Cell(0,5,"Teléfono : ".$rowc["telefono"]."",0,1);}
				if ($rowc["mail"] != "") { $pdf->Cell(0,5,"eMail : ".$rowc["mail"]."",0,1);}
				if ($rowc["url"] != "") { $pdf->Cell(0,5,"Web : ".$rowc["url"]."",0,1);}
			}
			if ($rowc["id"] == $row["id_agrupacio"]) {
				$pdf->SetFont('times','',8);
				$pdf->Cell(0,5,"".$rowc["nombre"]."(*)",0,1);
				$pdf->Cell(0,5,"".$rowc["nif"]."",0,1);
				$pdf->Cell(40,5,"".$direccion1."");
				if ($rowc["cp"] != "") {
					$pdf->Cell(0,5," (".$rowc["cp"].") ",0,1);
				} else {
					$pdf->Ln();
				}
				$pdf->Cell(0,5,"".$rowc["poblacion"]."",0,1);
				if ($rowc["provincia"] != "") {$pdf->Cell(0,5,"".$rowc["provincia"]."",0,1);}
				if ($rowc["telefono"] != "") { $pdf->Cell(0,5,"Teléfono : ".$rowc["telefono"]."",0,1);}
				if ($rowc["mail"] != "") { $pdf->Cell(0,5,"eMail : ".$rowc["mail"]."",0,1);}
				if ($rowc["url"] != "") { $pdf->Cell(0,5,"Web : ".$rowc["url"]."",0,1);}
			}
		}
		if ($row["id_agrupacio"] == 0) {
			if (($rowc["id_agrupacio"] == $row["id"]) and ($rowc["id"] != $row["id"])) {
				$pdf->SetFont('times','',8);
				$pdf->Cell(0,5,"".$rowc["nombre"]."",0,1);
				$pdf->Cell(0,5,"".$rowc["nif"]."",0,1);
				$pdf->Cell(40,5,"".$direccion1."");
				if ($rowc["cp"] != "") {
					$pdf->Cell(0,5," (".$rowc["cp"].") ",0,1);
				} else {
					$pdf->Ln();
				}
				$pdf->Cell(0,5,"".$rowc["poblacion"]."",0,1);
				if ($rowc["provincia"] != "") {$pdf->Cell(0,5,"".$rowc["provincia"]."",0,1);}
				if ($rowc["telefono"] != "") { $pdf->Cell(0,5,"Teléfono : ".$rowc["telefono"]."",0,1);}
				if ($rowc["mail"] != "") { $pdf->Cell(0,5,"eMail : ".$rowc["mail"]."",0,1);}
				if ($rowc["url"] != "") { $pdf->Cell(0,5,"Web : ".$rowc["url"]."",0,1);}
			}
		}
	}
	if ($row["id_origen"] > 0){
		$sqlj = "select count(*) as total from sgm_clients where visible=1 and id_origen=".$row["id_origen"]." and id<>".$row["id"];
		$resultj = mysql_query(convert_sql($sqlj));
		$rowj = mysql_fetch_array($resultj);
		$sqlj2 = "select count(*) as total from sgm_clients where visible=1 and id=".$row["id_origen"];
		$resultj2 = mysql_query(convert_sql($sqlj2));
		$rowj2 = mysql_fetch_array($resultj2);
	}
	if ($row["id_origen"] == 0){
		$sqlj3 = "select count(*) as total from sgm_clients where visible=1 and id_origen=".$row["id"]." and id<>".$row["id_origen"];
		$resultj3 = mysql_query(convert_sql($sqlj3));
		$rowj3 = mysql_fetch_array($resultj3);
	}
	if ((($row["id_origen"] > 0) and (($rowj["total"] > 0) or ($rowj2["total"] > 0))) or (($row["id_origen"] == 0) and ($rowj3["total"] > 0))){
		$pdf->SetFont('times','',10);
		$pdf->Cell(40,10,"Delegación Central",0,1);
	}
	$sqlc = "select * from sgm_clients where visible=1 order by nombre";
	$resultc = mysql_query(convert_sql($sqlc));
	while ($rowc = mysql_fetch_array($resultc)) {
		if( $rowc["id_carrer"] < 0 ){
			$direccion2 = $rowc["cvia"]." ".$rowc["direccion"];
		} else {
			$sqlt = "select * from sgm_clients_carrer_tipo where id=".$rowc["id_tipo_carrer"];
			$resultt = mysql_query(convert_sql($sqlt));
			$rowt = mysql_fetch_array($resultt);
			$sqlca = "select * from sgm_clients_carrer where id=".$rowc["id_carrer"];
			$resultca = mysql_query(convert_sql($sqlca));
			$rowca = mysql_fetch_array($resultca);
			$sqlz = "select * from sgm_clients_sector_zf where id=".$rowc["id_sector_zf"];
			$resultz = mysql_query(convert_sql($sqlz));
			$rowz = mysql_fetch_array($resultz);
			$direccion2 = $rowt["nombre"]." ".$rowca["nombre"]."";
			if ($row["numero"] > 0){ $direccion2 .= " num.";}
			$direccion2 .= " ".$rowc["numero"]." ".$rowz["nombre"]."";
		}
		if ($row["id_origen"] > 0) {
			if (($rowc["id_origen"] == $row["id_origen"]) and ($rowc["id"] != $row["id"])) {
				$pdf->SetFont('times','',8);
				$pdf->Cell(0,5,"".$rowc["nombre"]."",0,1);
				$pdf->Cell(0,5,"".$rowc["nif"]."",0,1);
				$pdf->Cell(40,5,"".$direccion2."");
				if ($rowc["cp"] != "") {
					$pdf->Cell(0,5," (".$rowc["cp"].") ",0,1);
				} else {
					$pdf->Ln();
				}
				$pdf->Cell(0,5,"".$rowc["poblacion"]."",0,1);
				if ($rowc["provincia"] != "") {$pdf->Cell(0,5,"".$rowc["provincia"]."",0,1);}
				if ($rowc["telefono"] != "") { $pdf->Cell(0,5,"Teléfono : ".$rowc["telefono"]."",0,1);}
				if ($rowc["mail"] != "") { $pdf->Cell(0,5,"eMail : ".$rowc["mail"]."",0,1);}
				if ($rowc["url"] != "") { $pdf->Cell(0,5,"Web : ".$rowc["url"]."",0,1);}
			}
			if ($rowc["id"] == $row["id_origen"]) {
				$pdf->SetFont('times','',8);
				$pdf->Cell(0,5,"".$rowc["nombre"]."(*)",0,1);
				$pdf->Cell(0,5,"".$rowc["nif"]."",0,1);
				$pdf->Cell(40,5,"".$direccion2."");
				if ($rowc["cp"] != "") {
					$pdf->Cell(0,5," (".$rowc["cp"].") ",0,1);
				} else {
					$pdf->Ln();
				}
				$pdf->Cell(0,5,"".$rowc["poblacion"]."",0,1);
				if ($rowc["provincia"] != "") {$pdf->Cell(0,5,"".$rowc["provincia"]."",0,1);}
				if ($rowc["telefono"] != "") { $pdf->Cell(0,5,"Teléfono : ".$rowc["telefono"]."",0,1);}
				if ($rowc["mail"] != "") { $pdf->Cell(0,5,"eMail : ".$rowc["mail"]."",0,1);}
				if ($rowc["url"] != "") { $pdf->Cell(0,5,"Web : ".$rowc["url"]."",0,1);}
			}
		}
	}
	$pdf->SetFont('times','',10);
	$pdf->Cell(40,10,"Contactos Personales",0,1);
	$sqlc = "select * from sgm_clients_contactos where id_client=".$_GET["id"];
	$resultc = mysql_query(convert_sql($sqlc));
	while ($rowc = mysql_fetch_array($resultc)) {
		$sqlt = "select * from sgm_clients_tratos where id=".$rowc["id_trato"];
		$resultt = mysql_query(convert_sql($sqlt));
		$rowt = mysql_fetch_array($resultt);
		$pdf->SetFont('times','',8);
		$pdf->Cell(0,5,"".$rowt["trato"]." ".$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"]." ".$rowc["telefono"]." ".$rowc["movil"]." ".$rowc["fax"]." ".$rowc["mail"]."",0,1);
	}
	$pdf->Output("../pdf/contacto.pdf");
	header("Location: ".$urloriginal."/pdf/contacto.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>

