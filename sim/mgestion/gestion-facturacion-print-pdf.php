<?php 
	error_reporting(~E_ALL);

	include ("../config.php");
	foreach (glob("../auxiliar/*.php") as $filename)
	{
		include ($filename);
	}
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$idioma = strtolower($_POST["idioma"]);
	include ("lenguajes/factura-print-".$idioma.".php");

	define("FPDF_FONTPATH","../font/");
	require('fpdf.php');
	

class PDF extends FPDF
{
	function NbLines($w,$txt){
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0){
			$w=$this->w-$this->rMargin-$this->x;
		}
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n"){
			$nb--;
		}
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' '){
				$sep=$i;
			}
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j){
						$i++;
					}
				} else {
					$i=$sep+1;
				}
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			} else {
				$i++;
			}
		}
		return $nl;
	}

	function factura_print($id,$tipo){
		global $retenciones,$cambio,$subtotal,$idioma,$pedido,$numero,$fecha,$fecha_vencimiento,$fecha_entrega,$nombre,$nif,$direccion,$poblacion,$cp,$provincia,$codigo,$unitats,$precio,$total,$importe,$descuento,$texto_pdatos,$notas;
		//Creación del objeto de la clase heredada
	
		$sqlele = "select * from sgm_dades_origen_factura";
		$resultele = mysql_query(convertSQL($sqlele));
		$rowele = mysql_fetch_array($resultele);

	
		$sqlcabezera = "select * from sgm_cabezera where id=".$id;
		$resultcabezera = mysql_query(convertSQL($sqlcabezera));
		$rowcabezera = mysql_fetch_array($resultcabezera);
	
		$sqlele2 = "select * from sgm_dades_origen_factura_iban where id=".$rowcabezera["id_dades_origen_factura_iban"];
		$resultele2 = mysql_query(convertSQL($sqlele2));
		$rowele2 = mysql_fetch_array($resultele2);

		$sqldi = "select * from sgm_divisas where id=".$rowcabezera["id_divisa"];
		$resultdi = mysql_query(convertSQL($sqldi));
		$rowdi = mysql_fetch_array($resultdi);

		$sqldiv = "select * from sgm_divisas_mod_canvi where id_divisa=".$rowdi["id"]." order by fecha desc";
		$resultdiv = mysql_query(convertSQL($sqldiv));
		$rowdiv = mysql_fetch_array($resultdiv);

		if ($tipo == 1) {
			#no sobre#
			$this->Image('../../archivos_comunes/images/logo1.jpg',10,5,80,18);
	
			$this->SetXY(10,25);
			$this->SetFont('Calibri','',10);
			$this->Cell(90,4,$rowele["nombre"],0,0);
			$this->Cell(90,4,$rowele["direccion"],0,1);
			$this->Cell(90,4,$rowele["nif"],0,0);
			$this->Cell(90,4,$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"],0,1);
			$this->Cell(90,4, "Teléfono: ".$rowele["telefono"],0,0);
			$this->Cell(90,4, "IBAN: ".$rowele2["iban"],0,1);
			$this->Cell(90,4, "E-mail: ".$rowele["mail"],0,0);
			$this->Cell(90,4,"",0,1);
			$this->Cell(90,4,"",0,1);
	
			$this->SetFont('Calibri','',10);
			$this->Cell(90,5,$numero." : ".$rowcabezera["numero"]." / ".$rowcabezera["version"],1,0);
			$this->Cell(90,5,$pedido." : ".$rowcabezera["numero_cliente"],1,1);
			$this->Cell(90,5,$fecha." : ".cambiarFormatoFechaDMY($rowcabezera["fecha"]),1,0);
			$this->Cell(90,5,$fecha_vencimiento." : ".cambiarFormatoFechaDMY($rowcabezera["fecha_vencimiento"]),1,1);
			$this->Cell(90,5,$fecha_entrega." : ".cambiarFormatoFechaDMY($rowcabezera["fecha_entrega"]),1,0);
			$this->Cell(90,5,$nombre." : ".str_replace("&#39;", "'", $rowcabezera["nombre"]),1,1);
			$this->Cell(90,5,$nif." / CIF: ".$rowcabezera["nif"],1,0);
			$this->Cell(90,5,$direccion." : ".str_replace("&#39;", "'", $rowcabezera["direccion"]),1,1);
			$this->Cell(90,5,$poblacion.": ".str_replace("&#39;", "'", $rowcabezera["poblacion"]),1,0);
			$this->Cell(90,5,$cp." : ".$rowcabezera["cp"],1,1);
			$this->Cell(90,5,$provincia.": ".$rowcabezera["provincia"],1,0);
			$this->Cell(90,5,'',1,1);
			$limit_lines = 34;
#			$this->SetFont('codi_barres','',8);
#			$this->Cell(90,5,$rowcabezera["numero"]." / ".$rowcabezera["version"],1,0);
		}
		
		if ($tipo == 0) {
			#sobre#
			$this->Image('../../archivos_comunes/images/logo1.jpg',10,10,80,18);
		
			$this->SetXY(10,35);
			$this->SetFont('Calibri','',10);
			$this->Cell(90,4,"".$rowele["nombre"],0,1);
			$this->Cell(90,4,"".$rowele["nif"],0,1);
			$this->Cell(90,4,$rowele["direccion"],0,1);
			$this->Cell(90,4,$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"],0,1);
			$this->Cell(90,4, "Teléfono: ".$rowele["telefono"],0,1);
			$this->Cell(90,4, "E-mail: ".$rowele["mail"],0,1);
			$this->Cell(90,4, "IBAN: ".$rowele2["iban"],0,1);
			$this->Cell(90,4,"",0,1);
		
			$this->SetXY(102,10);
			$this->SetFont('Calibri','',10);
			$this->MultiCell(90,3,$numero." : ".$rowcabezera["numero"]." / ".$rowcabezera["version"]."\n".$pedido." : ".$rowcabezera["numero_cliente"]."\n".$fecha." : ".cambiarFormatoFechaDMY($rowcabezera["fecha"])."\n".$fecha_vencimiento." : ".cambiarFormatoFechaDMY($rowcabezera["fecha_vencimiento"])."\n".$nombre." : ".str_replace("&#39;", "'", $rowcabezera["nombre"])."\nNIF / CIF: ".$rowcabezera["nif"]."",0,'L');
		
			$this->SetXY(102,45);
			$this->SetFont('Calibri','',12);
			$this->MultiCell(95,5,str_replace("&#39;", "'", $rowcabezera["nombre"])."\n".str_replace("&#39;", "'", $rowcabezera["direccion"])."\n".str_replace("&#39;", "'", $rowcabezera["poblacion"])." (".$rowcabezera["cp"].") ".$rowcabezera["provincia"],0,'L');
			$this->SetY(71);
			$limit_lines = 34;
#			$this->SetFont('codi_barres','',8);
#			$this->Cell(90,5,$rowcabezera["numero"]." / ".$rowcabezera["version"],1,0);
		}
		
	


		$sqlx = "select * from sgm_factura_tipos where id=".$rowcabezera["tipo"];
		$resultx = mysql_query(convertSQL($sqlx));
		$rowx = mysql_fetch_array($resultx);
		if ($idioma == "es"){
			$fac_tipo = $rowx["tipo"];
		} else {
			$sqlid = "select * from sgm_idiomas where idioma='".$idioma."'";
			$resultid = mysql_query(convertSQL($sqlid));
			$rowid = mysql_fetch_array($resultid);
			$sqli = "select * from sgm_factura_tipos_idiomas where id_tipo=".$rowx["id"]." and id_idioma=".$rowid["id"];
			$resulti = mysql_query(convertSQL($sqli));
			$rowi = mysql_fetch_array($resulti);
			$fac_tipo = $rowi["tipo"];
		}

		$this->SetFont('Calibri','B',20);
		$this->Cell(180,20,$fac_tipo,0,1,'C');
		$this->SetFont('Calibri','',12);
		$this->Cell(20,5,"".$fecha."",'LTB',0);
		$this->Cell(20,5,"".$codigo."",'TB',0);
		$this->Cell(80,5,"".$nombre."",'TB',0);
		$this->Cell(20,5,"".$unitats."",'TB',0);
		$this->Cell(20,5,"".$precio."",'TB',0);
		$this->Cell(20,5,"".$total."",'TBR',1);
	
		$this->SetFont('Calibri','',10);
		$unidades2 = 0;
		$lineas = 0;
		$sql = "select * from sgm_cuerpo where idfactura=".$id." order by linea";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)) {
			$data = date("d / m / y", strtotime($row["fecha_prevision"])); 
			$X = $this->GetX();
			$Y = $this->GetY();
			$text = str_replace("&#39;", "'", $row["nombre"]);
			$num_lines = $this->NbLines(80,$text);
			$height = (5*$num_lines);
			$this->Cell(20,$height,$data,'LB',0);
			$this->SetXY($X+20,$Y);
			$this->Cell(20,$height,$row["codigo"],'B',0);
			$this->SetXY($X+40,$Y);
			$this->MultiCell(80,5,$text,'B');
			$this->SetXY($X+120,$Y);
			$this->Cell(20,$height,number_format($row["unidades"], 2, ',', '.'),'B',0);
			$this->SetXY($X+140,$Y);
			$this->Cell(20,$height,number_format($row["pvp"], 2, ',', '.').$rowdi["simbolo"],'B',0);
			$this->SetXY($X+160,$Y);
			$this->Cell(20,$height,number_format($row["total"], 2, ',', '.').$rowdi["simbolo"],'RB',1);
#			$this->SetXY($X,$Y+$height);
#			$this->Ln();
			$unidades2 = $unidades2 + $row["unidades"];
			$lineas += $num_lines;
			if ($lineas > $limit_lines){
				$this->AddPage();
				$this->SetFont('Calibri','',12);
				$this->Cell(20,5,"".$fecha."",'LTB',0);
				$this->Cell(20,5,"".$codigo."",'TB',0);
				$this->Cell(80,5,"".$nombre."",'TB',0);
				$this->Cell(20,5,"".$unitats."",'TB',0);
				$this->Cell(20,5,"".$precio."",'TB',0);
				$this->Cell(20,5,"".$total."",'TBR',1);
				$this->SetFont('Calibri','',10);
				$lineas = -16;
			}
		}

		$text_notes = str_replace("&#39;", "'", $rowcabezera["notas"]);
		$num_lines_notes = $this->NbLines(180,$text_notes);
		$lineas = $lineas + $num_lines_notes;

		for ($i = 29; $i > $lineas; $i--){
			$this->Cell(180,5,'','LR',1);
		}
#		$this->Cell(180,5,'','LBR',1);

		$this->Cell(15,5,"".$unitats."",'LTR',0);
		$this->Cell(25,5,"".$importe."",'LTR',0);
		$this->Cell(35,5,"".$descuento."",'LTR',0);
		$this->Cell(25,5,"".$subtotal."",'LTR',0);
		$this->Cell(25,5,"IVA (".number_format($rowcabezera["iva"],0)."%)",'LTR',0);
		$this->Cell(30,5,$retenciones." (".number_format($rowcabezera["retenciones"],0)."%)",'LTR',0);
		$this->Cell(25,5,"".$total."",'LTR',1);
	
		$this->Cell(15,5,number_format($unidades2, 2, ',', '.'),'LBR',0);
		$this->Cell(25,5,number_format($rowcabezera["subtotal"], 2, ',', '.').$rowdi["simbolo"],'LBR',0);
		$this->Cell(35,5,number_format($rowcabezera["subtotal"]-$rowcabezera["subtotaldescuento"], 2, ',', '.').$rowdi["simbolo"].' ('.number_format($rowcabezera["descuento"], 2, ',', '.').'%)','LBR',0);
		$this->Cell(25,5,number_format($rowcabezera["subtotaldescuento"], 2, ',', '.').$rowdi["simbolo"],'LBR',0);
		$iva = (($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["iva"]);
		$this->Cell(25,5,number_format($iva, 2, ',', '.').$rowdi["simbolo"],'LBR',0);
		$retencion = (($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["retenciones"]);
		$this->Cell(30,5,number_format($retencion, 2, ',', '.').$rowdi["simbolo"],'LBR',0);
		$this->Cell(25,5,number_format($rowcabezera["total"], 2, ',', '.').$rowdi["simbolo"],'LBR',1);
	
		$sqld = "select * from sgm_divisas where predefinido=1";
		$resultd = mysql_query(convertSQL($sqld));
		$rowd = mysql_fetch_array($resultd);
		
		if ($rowcabezera["id_divisa"] != $rowd["id"]){
			$this->Cell(15,5,$cambio.": 1".$rowd["simbolo"]."=".number_format($rowdi["canvi"], 2, ',', '.').$rowdi["simbolo"],'LTR',0);
			$this->Cell(25,5,"".$importe."",'LTR',0);
			$this->Cell(35,5,"".$descuento."",'LTR',0);
			$this->Cell(25,5,"".$subtotal."",'LTR',0);
			$this->Cell(25,5,"IVA(".number_format($rowcabezera["iva"],0)."%)",'LTR',0);
			$this->Cell(30,5,$retenciones." (".number_format($rowcabezera["retenciones"],0)."%)",'LTR',0);
			$this->Cell(25,5,"".$total."",'LTR',1);
		
			$div_importe = $rowcabezera["subtotal"] * $rowdi["canvi"];
			$div_decuento = ($rowcabezera["subtotal"]-$rowcabezera["subtotaldescuento"]) * $rowdi["canvi"];
			$div_subtotal = $rowcabezera["subtotaldescuento"] * $rowdi["canvi"];
			$div_total = $rowcabezera["total"] * $rowdi["canvi"];

		
			$this->Cell(15,5,"(".$rowdiv["fecha"].")",'LBR',0);
			$this->Cell(25,5,number_format($div_importe, 2, ',', '.').$rowd["simbolo"],'LBR',0);
			$this->Cell(35,5,number_format($div_decuento, 2, ',', '.').$rowd["simbolo"].' ('.number_format($rowcabezera["descuento"], 2, ',', '.').'%)','LBR',0);
			$this->Cell(25,5,number_format($div_subtotal, 2, ',', '.').$rowd["simbolo"],'LBR',0);
			$iva = (($div_subtotal / 100) * $rowcabezera["iva"]);
			$this->Cell(25,5,number_format($iva, 2, ',', '.').$rowd["simbolo"],'LBR',0);
			$retencion = (($div_subtotal / 100) * $rowcabezera["retenciones"]);
			$this->Cell(30,5,number_format($retencion, 2, ',', '.').$rowd["simbolo"],'LBR',0);
			$this->Cell(25,5,number_format($div_total, 2, ',', '.').$rowd["simbolo"],'LBR',1);
		}

		$this->SetFont('Calibri','',8);
		$this->MultiCell(180,3,$notas.":\n".$text_notes,'LRTB',1);
		$this->Cell(180,3,' ',0,1);
		$this->SetFont('Calibri','',6);
		$this->MultiCell(180,3,$texto_pdatos,0,'J');

	}
}

	$pdf=new PDF();
#	$pdf->AddFont('codi_barres','','../../archivos_comunes/font/codi_barres.php');
	$pdf->AddFont('Calibri','','../font/Calibri.php');
	$pdf->AddFont('Calibri-Bold','B','../font/Calibrib.php');
	$pdf->AddFont('Calibri','B','../font/Calibrib.php');
	$pdf->AliasNbPages();

	if ($_POST["data_desde"] == ""){
		$pdf->AddPage();
		$pdf->factura_print($_GET["id"],$_POST["tipo"]);
	} else {
		$sql = "select * from sgm_cabezera where tipo=".$_POST["id_tipo"]." and fecha_prevision between '".cambiarFormatoFechaYMD($_POST["data_desde"])."' and '".cambiarFormatoFechaYMD($_POST["data_fins"])."' and visible=1";
		$result = mysql_query(convertSQL($sql));
		while ($row = mysql_fetch_array($result)){
			$pdf->AddPage();
			$pdf->factura_print($row["id"],$_POST["tipo"]);
		}
	}

	$pdf->Output("../pdf/factura.pdf");
	header("Location: ../pdf/factura.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>
