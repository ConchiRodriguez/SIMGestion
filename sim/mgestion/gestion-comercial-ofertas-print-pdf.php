<?php 
#	error_reporting(~E_ALL);

	include ("../config.php");
	foreach (glob("../auxiliar/*.php") as $filename)
	{
		include ($filename);
	}
	$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
	$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

	$sqlof = "select * from sim_comercial_oferta where id=".$_GET["id"];
	$resultof = mysqli_query($dbhandle,convertSQL($sqlof));
	$rowof = mysqli_fetch_array($resultof);

	$sqli = "select * from sgm_idiomas where id=".$rowof["id_idioma"];
	$resulti = mysqli_query($dbhandle,convertSQL($sqli));
	$rowi = mysqli_fetch_array($resulti);

	include ("lenguajes/factura-print-".$rowi["idioma"].".php");

	$sqldo = "select * from sgm_dades_origen_factura";
	$resultdo = mysqli_query($dbhandle,convertSQL($sqldo));
	$rowdo = mysqli_fetch_array($resultdo);

	$adress = $rowdo['direccion'].", ".$rowdo['cp']." ".$rowdo['poblacion']."\n Tel. +34 ".$rowdo['telefono']." ".$rowdo['mail'];
	$texto = $rowdo['nombre']."\n".$rowdo['nif']."\n".$rowdo['direccion'].", ".$rowdo['cp']." ".$rowdo['poblacion']." (".$rowdo['provincia'].")\nTel. +34 ".$rowdo['telefono']." ".$rowdo['mail']."\n\n";
	$texto_ca = "Li recordem, que les seves dades es troben recollides en un fitxer titularitat de SOLUCIONS INFORMATIQUES MARESME S.L. amb la finalitat de prestar els seus serveis. D'acord amb la Llei Orgànica 15/1999 de Protecció de Caràcter Personal pot exercitar els drets d'accés, rectificació, cancel·lació i oposició enviant un escrit de sol·licitud i fotocòpies del DNI a SOLUCIONS INFORMATIQUES MARESME S.L, Avda. Maresme, 44 baixos, 2 de Tordera província de Barcelona.";
	$texto_es = "Le recordamos que sus datos se encuentran recogidos en un archivo titularidad de SOLUCIONS INFORMATIQUES MARESME S.L. con la finalidad de prestar sus servicios. De acuerdo con la Ley Orgánica 15/1999 de Protección de Carácter Personal puede ejercitar los derechos de acceso, ratificación, cancelación y oposición enviando un escrito de solicitud y fotocopia del DNI a SOLUCIONS INFORMATIQUES MARESME S.L. Avda. Maresme, 44 Bajos, 2 de Tordera provincia de Barcelona.";
	if ($rowi["idioma"] == 'es') { $texto_lopd = $texto.$texto_es; } else { $texto_lopd = $texto.$texto_ca; }

	define("FPDF_FONTPATH","../font/");
#	require('fpdf.php');
	require('html_table.php');

class PDF extends PDF_HTML_Table
{
	protected $_toc=array();
	protected $_numbering=false;
	protected $_numberingFooter=false;
	protected $_numPageNum=3;

    function AddPage($orientation='', $format='', $rotation=0) {
        parent::AddPage($orientation,$format,$rotation);
        if($this->_numbering)
            $this->_numPageNum++;
    }

    function startPageNums() {
        $this->_numbering=true;
        $this->_numberingFooter=true;
    }

    function stopPageNums() {
        $this->_numbering=false;
    }

    function numPageNo() {
        return $this->_numPageNum;
    }

    function entryTOC($txt, $level=0) {
        $this->_toc[]=array('t'=>$txt,'l'=>$level,'p'=>$this->numPageNo());
    }

    function insertTOC( $location=1,$labelSize=20,$entrySize=10,$tocfont='Calibri') {
		global $indice;
        //make toc at end
        $this->stopPageNums();
        $this->AddPage();
        $tocstart=$this->page;

        $this->SetFont($tocfont,'B',$labelSize);
        $this->Cell(0,5,$indice,0,1,'C');
        $this->Ln(10);

        foreach($this->_toc as $t) {

            //Offset
            $level=$t['l'];
            if($level>0)
                $this->Cell($level*8);
            $weight='';
            if($level==0)
                $weight='B';
            $str=$t['t'];
            $this->SetFont($tocfont,$weight,$entrySize);
            $strsize=$this->GetStringWidth($str);
            $this->Cell($strsize+2,$this->FontSize+2,$str);

            //Filling dots
            $this->SetFont($tocfont,'',$entrySize);
            $PageCellSize=$this->GetStringWidth($t['p'])+2;
            $w=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*8)-($strsize+2);
            $nb=$w/$this->GetStringWidth('.');
            $dots=str_repeat('.',$nb);
            $this->Cell($w,$this->FontSize+2,$dots,0,0,'R');

            //Page number
            $this->Cell($PageCellSize,$this->FontSize+2,$t['p'],0,1,'R');
        }

        //Grab it and move to selected location
        $n=$this->page;
        $n_toc = $n - $tocstart + 1;
        $last = array();

        //store toc pages
        for($i = $tocstart;$i <= $n;$i++)
            $last[]=$this->pages[$i];

        //move pages
        for($i=$tocstart-1;$i>=$location-1;$i--)
            $this->pages[$i+$n_toc]=$this->pages[$i];

        //Put toc pages at insert point
        for($i = 0;$i < $n_toc;$i++)
            $this->pages[$location + $i]=$last[$i];
    }

    function Footer() {
        if(!$this->_numberingFooter)
            return;
        //Go to 1.5 cm from bottom
        $this->SetY(-15);
        //Select Calibri italic 8
        $this->SetFont('Calibri','',8);
        $this->Cell(0,7,$this->numPageNo(),0,0,'C'); 
        if(!$this->_numbering)
            $this->_numberingFooter=false;
    }

	function WriteTableValoraciones($id){
		global $db,$dbhandle,$valoracion_economica,$unitats,$articulos,$precio,$total,$descuento;

		$this->SetTextColor(51,51,159);
		$this->SetFontSize(14);
		$this->SetStyle('B',true);
		$this->Cell(170,5,$valoracion_economica,0,1);
		$this->entryTOC($valoracion_economica,0);
		$this->Ln(5);
 
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(0,0,0);

 		$sqlov = "select * from sim_comercial_oferta_valoracion where aceptada=1 and id_comercial_oferta=".$id;
		$resultov = mysqli_query($dbhandle,convertSQL($sqlov));
		$rowov = mysqli_fetch_array($resultov);
		if ($rowov){
			$this->SetFont('Calibri','',12);
			$this->Cell(170,5,$rowov["descripcion"],0,1);
			$this->Ln();
			$this->SetFont('Calibri','',10);
			$this->Cell(100,5,$articulos,'B',0);
			$this->Cell(40,5,$unitats,'B',0);
			$this->Cell(30,5,$precio." ".$total,'B',1,'R');

			$total_val = 0;
			$sqlcova = "select * from sim_comercial_oferta_valoracion_rel_articulos where id_comercial_oferta_valoracion=".$rowov["id"];
			$resultcova = mysqli_query($dbhandle,convertSQL($sqlcova));
			while ($rowcova = mysqli_fetch_array($resultcova)){
				$sqla = "select * from sgm_articles where id=".$rowcova["id_articulo"];
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				$rowa = mysqli_fetch_array($resulta);

				$sql = "select id_divisa_pvp from sgm_stock where vigente=1 and id_article=".$rowcova["id_articulo"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				$sqld = "select abrev from sgm_divisas where id=".$row["id_divisa_pvp"];
				$resultd = mysqli_query($dbhandle,convertSQL($sqld));
				$rowd = mysqli_fetch_array($resultd);
				$total_art = $rowcova["pvp"] * $rowcova["unidades"];
				$total_val += $total_art;
				
				$this->SetFont('Calibri','',9);
				$this->Cell(100,5,comillasInver($rowa["nombre"]),0,0);
				$this->Cell(40,5,$rowcova["unidades"],0,0);
				$this->Cell(30,5,$total_art." ".$rowd["abrev"],0,1,'R');
			}
			$this->Cell(100,5,'','T',0);
			$this->Cell(40,5,$descuento.": ".$rowov["descuento"]."%",'T',0);
			$total_valoracion = $total_val - (($total_val*$rowov["descuento"])/100);
			$this->Cell(30,5,$total_valoracion." ".$rowd["abrev"],'T',1,'R');
			$this->Ln(15);
		} else {
			$sqlov = "select * from sim_comercial_oferta_valoracion where id_comercial_oferta=".$id;
			$resultov = mysqli_query($dbhandle,convertSQL($sqlov));
			while ($rowov = mysqli_fetch_array($resultov)){

				$this->SetFont('Calibri','',12);
				$this->Cell(170,5,$rowov["descripcion"],0,1);
				$this->Ln();
				$this->SetFont('Calibri','',10);
				$this->Cell(100,5,$articulos,'B',0);
				$this->Cell(40,5,$unitats,'B',0);
				$this->Cell(30,5,$precio." ".$total,'B',1,'R');

				$total_val = 0;
				$sqlcova = "select * from sim_comercial_oferta_valoracion_rel_articulos where id_comercial_oferta_valoracion=".$rowov["id"];
				$resultcova = mysqli_query($dbhandle,convertSQL($sqlcova));
				while ($rowcova = mysqli_fetch_array($resultcova)){
					$sqla = "select * from sgm_articles where id=".$rowcova["id_articulo"];
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					$rowa = mysqli_fetch_array($resulta);

					$sql = "select id_divisa_pvp from sgm_stock where vigente=1 and id_article=".$rowcova["id_articulo"];
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					$sqld = "select abrev from sgm_divisas where id=".$row["id_divisa_pvp"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					$total_art = $rowcova["pvp"] * $rowcova["unidades"];
					$total_val += $total_art;
					
					$this->SetFont('Calibri','',9);
					$this->Cell(100,5,comillasInver($rowa["nombre"]),0,0);
					$this->Cell(40,5,$rowcova["unidades"],0,0);
					$this->Cell(30,5,$total_art." ".$rowd["abrev"],0,1,'R');
				}
				$this->Cell(100,5,'','T',0);
				$this->Cell(40,5,$descuento.": ".$rowov["descuento"]."%",'T',0,'L');
				$total_valoracion = $total_val - (($total_val*$rowov["descuento"])/100);
				$this->Cell(30,5,$total_valoracion." ".$rowd["abrev"],'T',1,'R');
				$this->Ln(15);
			}
		}
	}
	
	function Portada($titul,$descripcio,$data,$versio,$aut)
	{
		global $db,$dbhandle,$titulo,$tema,$fecha,$version,$autor,$adress,$texto_lopd;

		$this->AddPage();
		$this->SetFillColor(51,51,159);
		$this->Cell(0,15,'',0,1,'C',true);
		$this->Image('pics/fpdf/logo_sim.jpg',150,25,50,10,'JPG');
		$this->Image('pics/fpdf/imagen_portada.jpg',10,35,190,100,'JPG');
		$this->Ln(112);
		$this->SetFillColor(180,180,237);
		$this->SetTextColor(255,255,255);
		$this->SetFont('Calibri','',25);
		$this->Cell(70,20,$titul,0,0,'L',true);
		$this->SetFont('Calibri','',18);
		$this->Cell(0,20,$descripcio,0,1,'L',true);
		$this->Ln(2);
		$this->SetFillColor(51,51,159);
		$this->Cell(0,80,'',0,1,'C',true);
		$this->Ln(0.5);
		$this->SetFont('Calibri','B',9);
		$this->SetTextColor(255,255,255);
		$this->SetDrawColor(255,255,255);
		$this->MultiCell(0,5,$adress,0,'C',true);
		$this->Ln(0.5);
		$this->Cell(0,20,'',0,1,'C',true);
		$this->AddPage();
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(0,0,0);
		$this->Cell(43,10,$titulo,1,0,'C');
		$this->Cell(43,10,$tema,1,0,'C');
		$this->Cell(30,10,$fecha,1,0,'C');
		$this->Cell(30,10,$version,1,0,'C');
		$this->Cell(43,10,$autor,1,1,'C');
		$this->SetFont('Calibri','',8);
		$this->Cell(43,10,$titul,1,0,'C');
		$this->Cell(43,10,$descripcio,1,0,'C');
		$this->Cell(30,10,$data,1,0,'C');
		$this->Cell(30,10,$versio,1,0,'C');
		$this->Cell(43,10,$aut,1,1,'C');
	
		$this->SetDrawColor(51,51,159);
		$this->Rect(10,190,190,1,'F');
		$this->Image('pics/fpdf/logo_sim.jpg',10,195,50,10,'JPG');
		$this->Ln(180);
		$this->MultiCell(0,5,$texto_lopd,0,'J');
	}

	function Contraportada()
	{
		global $adress;
		
		$this->AddPage();
		$this->Image('pics/fpdf/solucions-i_QR_Droid.jpg',85,150,40,40,'JPG');
		$this->Image('pics/fpdf/logo_sim.jpg',80,190,50,10,'JPG');
		$this->Image('pics/fpdf/64x64-facebook.jpg',81,200,12,12,'JPG','https://www.facebook.com/pages/Solucions-Informatiques-Maresme-SLU/384997628255026');
		$this->Image('pics/fpdf/64x64-linkedin.jpg',93,200,12,12,'JPG','http://www.linkedin.com/company/solucions-informatiques-maresme-slu?trk=cp_followed_name_solucions-informatiques-maresme-slu');
		$this->Image('pics/fpdf/64x64-youtube.jpg',105,200,12,12,'JPG','http://www.youtube.com/channel/UCB6v5clKL3SdF34VqrnUGTg');
		$this->Image('pics/fpdf/64x64-twitter.jpg',117,200,12,12,'JPG','https://twitter.com/Solucions_im');
		$this->SetXY(10,220);
		$this->SetFont('Calibri','B',9);
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(51,51,159);
		$this->MultiCell(0,5,"\n\n\n".$adress."\n\n\n\n\n\n",0,'C',true);
		$this->SetXY(87,245);
		$this->Write(5,'www.solucions-im.com','http://www.solucions-im.com');
	}

}

	$sql1 = "select id,usuario from sgm_users where sgm=1 and id=".$rowof["id_autor"];
	$result1 = mysqli_query($dbhandle,convertSQL($sql1));
	$row1 = mysqli_fetch_array($result1);

 	$pdf=new PDF();
	$pdf->AddFont('Calibri','','../font/Calibri.php');
	$pdf->AddFont('Calibri-Bold','B','../font/Calibrib.php');
	$pdf->AddFont('Calibri','B','../font/Calibrib.php');
	$pdf->SetCreator("Solucions-IM");
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle($rowof["descripcion"]);
	$pdf->Portada('Oferta Comercial',$rowof["descripcion"],$rowof["fecha"],$rowof["version"],$row1["usuario"]);
	$pdf->startPageNums();

	$pdf->SetMargins(20,30,15);
	$pdf->AddPage();

	$orden_contenido = 1;

	$sqlofc = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
	$resultofc = mysqli_query($dbhandle,convertSQL($sqlofc));
	while ($rowofc = mysqli_fetch_array($resultofc)){
#		echo $orden_contenido."-".substr($rowofc["orden"],0,2)."<br>";
		if ($orden_contenido != substr($rowofc["orden"],0,2)){
			$pdf->AddPage();
			$orden_contenido = substr($rowofc["orden"],0,2);
		} else {
			$pdf->Ln(10);
		}
		$sqlcon = "select * from sim_comercial_contenido where visible=1 and id=".$rowofc["id_comercial_contenido"];
		$resultcon = mysqli_query($dbhandle,convertSQL($sqlcon));
		$rowcon = mysqli_fetch_array($resultcon);
		if ($rowcon["editable"] == 1){
			$sqlcc = "select contenido from sim_comercial_contenido where visible=1 and id_comercial_contenido=".$rowcon["id"]." and id_comercial_oferta=".$_GET["id"];
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if ($rowcc){ $content = $rowcc["contenido"]; $content_ext = $rowcc["contenido_extenso"]; } else { $content = $rowcon["contenido"]; $content_ext = $rowcon["contenido_extenso"]; }
		} else {
			$content = $rowcon["contenido"];
			$content_ext = $rowcon["contenido_extenso"];
		}
		if ($_POST["tipo"] == 0) {$contenido = $content;} else {$contenido = $content.$content_ext;}

		$pdf->SetTextColor(51,51,159);
		$pdf->SetFontSize(14);
		$pdf->SetStyle('B',true);
		$pdf->Cell(180,5,ltrim($rowofc["orden"],'0')." ".comillasInver($rowcon["titulo"]),0,1);
		$pdf->entryTOC(ltrim($rowofc["orden"],'0')." ".comillasInver($rowcon["titulo"]),0);

		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Calibri','',10);


		$sqlcli = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowof["id_cliente"];
		$resultcli = mysqli_query($dbhandle,convertSQL($sqlcli));
		$rowcli = mysqli_fetch_array($resultcli);
		$sqlts = "select tipo_servidor from sim_comercial_tipos_servidores where visible=1 and id=".$rowof["id_tipo_servidor"];
		$resultts = mysqli_query($dbhandle,convertSQL($sqlts));
		$rowts = mysqli_fetch_array($resultts);
		$sqlso = "select software from sim_comercial_software where visible=1 and id=".$rowof["id_software"];
		$resultso = mysqli_query($dbhandle,convertSQL($sqlso));
		$rowso = mysqli_fetch_array($resultso);

		$servidores = array();
		$sqlcse = "select servidores from sim_comercial_oferta_servidores where id_comercial_oferta=".$_GET["id"];
		$resultcse = mysqli_query($dbhandle,convertSQL($sqlcse));
		while ($rowcse = mysqli_fetch_array($resultcse)){
			$servidores[] = $rowcse["servidores"];
		}
		$taula_resum = "<table style=\"width: 868px;\">";
		$taula_resum .= "<tr><td>".$Servicio."</td>";
		for ($i=0;$i<count($servidores);$i++) {$taula_resum .= "<td>".$servidores[$i]."</td>";}
		$taula_resum .= "</tr>";
		$sqlsr = "select id_servicio from sim_comercial_oferta_rel_servicios where id_comercial_oferta=".$_GET["id"];
		$resultsr = mysqli_query($dbhandle,convertSQL($sqlsr));
		while ($rowsr = mysqli_fetch_array($resultsr)){
			$sqlse = "select servicio,id_servicio_origen from sgm_contratos_servicio where visible=1 and id=".$rowsr["id_servicio"];
			$resultse = mysqli_query($dbhandle,convertSQL($sqlse));
			$rowse = mysqli_fetch_array($resultse);
			$sqlseo = "select codigo_origen from sgm_contratos_servicio_origen where visible=1 and id=".$rowse["id_servicio_origen"];
			$resultseo = mysqli_query($dbhandle,convertSQL($sqlseo));
			$rowseo = mysqli_fetch_array($resultseo);
			$taula_resum .= "<tr><td>".utf8_encode($rowse["servicio"])."</td>";
			for ($i=0;$i<count($servidores);$i++) {$taula_resum .= "<td>".utf8_encode($rowseo["codigo_origen"])."</td>";}
			$taula_resum .= "</tr>";
		}
		$taula_resum .= "</table>";

		$contenido = str_replace( '[CLIENT]', utf8_encode($rowcli["nombre"]." ".$rowcli["cognom1"]." ".$rowcli["cognom2"]), $contenido );
		$contenido = str_replace( '[NUM_DISP]', $rowof["num_dispositivos"], $contenido );
		$contenido = str_replace( '[NUM_SERVEIS]', $rowof["num_servicios"], $contenido );
		$contenido = str_replace( '[TIPUS_SERVIDOR]', $rowts["tipo_servidor"], $contenido );
		$contenido = str_replace( '[SOFTWARE]', $rowso["software"], $contenido );
		$contenido = str_replace( '[TAULA_RESUM]', $taula_resum, $contenido );
		$pdf->WriteHTML($contenido,0);
	}
	$pdf->AddPage();
	$pdf->WriteTableValoraciones($_GET["id"]);
	$pdf->stopPageNums();
	$pdf->insertTOC(3);
	$pdf->Contraportada();

	$pdf->Output();
#	$pdf->Output("../pdf/oferta.pdf");
#	header("Location: ../pdf/oferta.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>
