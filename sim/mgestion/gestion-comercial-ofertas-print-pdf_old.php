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
	$texto_ca = "Li recordem, que les seves dades es troben recollides en un fitxer titularitat de SOLUCIONS INFORMATIQUES MARESME S.L. amb la finalitat de prestar els seus serveis. D'acord amb la Llei Org�nica 15/1999 de Protecci� de Car�cter Personal pot exercitar els drets d'acc�s, rectificaci�, cancel�laci� i oposici� enviant un escrit de sol�licitud i fotoc�pies del DNI a SOLUCIONS INFORMATIQUES MARESME S.L, Avda. Maresme, 44 baixos, 2 de Tordera prov�ncia de Barcelona.";
	$texto_es = "Le recordamos que sus datos se encuentran recogidos en un archivo titularidad de SOLUCIONS INFORMATIQUES MARESME S.L. con la finalidad de prestar sus servicios. De acuerdo con la Ley Org�nica 15/1999 de Protecci�n de Car�cter Personal puede ejercitar los derechos de acceso, ratificaci�n, cancelaci�n y oposici�n enviando un escrito de solicitud y fotocopia del DNI a SOLUCIONS INFORMATIQUES MARESME S.L. Avda. Maresme, 44 Bajos, 2 de Tordera provincia de Barcelona.";
	if ($rowi["idioma"] == 'es') { $texto_lopd = $texto.$texto_es; } else { $texto_lopd = $texto.$texto_ca; }

	define("FPDF_FONTPATH","../font/");
	require('fpdf.php');

class PDF extends FPDF
{
	protected $B = 0;
	protected $I = 0;
	protected $U = 0;
	protected $HREF = '';

	protected $_toc=array();
	protected $_numbering=false;
	protected $_numberingFooter=false;
	protected $_numPageNum=3;

    protected $tableborder=0;
    protected $tdbegin=false;
    protected $tdwidth=0;
    protected $tdheight=0;
    protected $tdalign="L";
    protected $tdbgcolor=false;

    protected $oldx=0;
    protected $oldy=0;

    protected $fontlist=array("arial","times","courier","helvetica","symbol");
    protected $issetfont=false;
    protected $issetcolor=false;

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
        //Select Arial italic 8
        $this->SetFont('Calibri','',8);
        $this->Cell(0,7,$this->numPageNo(),0,0,'C'); 
        if(!$this->_numbering)
            $this->_numberingFooter=false;
    }

	function WriteHTML($html)
	{
		// Int�rprete de HTML
		$html = strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><h1><h2><h3><h4><pre><red><blue><ul><li><hr><tbody><td><table><sup>");
		$html = str_replace("\n",' ',$html);
		$html = str_replace("\t",'',$html);
		$html = str_replace('&trade;','�',$html);
		$html = str_replace('&copy;','�',$html);
		$html = str_replace('&euro;','�',$html);
		$html = str_replace('&rsquo;',"'",$html);
		$html = str_replace('&ndash;','-',$html);
		$html = str_replace('&ldquo;','"',$html);
		$html = str_replace('&rdquo;','"',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// new line
				if($this->PRE)
					$e=str_replace("\r","\n",$e);
				else
					$e=str_replace("\r","",$e);
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				elseif($this->tdbegin) {
					if(trim($e)!='' && $e!="&nbsp;") {
						$this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
					}
					elseif($e=="&nbsp;") {
						$this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
					}
				} else
						$this->Write(5,stripslashes($e));
			}
			else
			{
				// Etiqueta
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraer atributos
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}

	function OpenTag($tag, $attr)
	{
		// Etiqueta de apertura
		switch($tag){
			case 'TABLE': // TABLE-BEGIN
			case 'table': // TABLE-BEGIN
				if( !empty($attr['border']) ) $this->tableborder=$attr['border'];
				else $this->tableborder=0;
				break;
			case 'TR': //TR-BEGIN
			case 'tr': //TR-BEGIN
				break;
			case 'TD': // TD-BEGIN
			case 'td': // TD-BEGIN
				if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
				else $this->tdwidth=40; // Set to your own width if you need bigger fixed cells
				if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
				else $this->tdheight=6; // Set to your own height if you need bigger fixed cells
				if( !empty($attr['ALIGN']) ) {
					$align=$attr['ALIGN'];        
					if($align=='LEFT') $this->tdalign='L';
					if($align=='CENTER') $this->tdalign='C';
					if($align=='RIGHT') $this->tdalign='R';
				}
				else $this->tdalign='L'; // Set to your own
				if( !empty($attr['BGCOLOR']) ) {
					$coul=hex2dec($attr['BGCOLOR']);
						$this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
						$this->tdbgcolor=true;
					}
				$this->tdbegin=true;
				break;
			case 'STRONG':
			case 'B':
				$this->SetStyle('B',true);
				break;
            case 'H1':
                $this->Ln(5);
                $this->SetTextColor(150,0,0);
                $this->SetFontSize(22);
                break;
            case 'H2':
                $this->Ln(5);
                $this->SetFontSize(18);
                $this->SetStyle('U',true);
                break;
            case 'H3':
                $this->Ln(5);
                $this->SetFontSize(16);
                $this->SetStyle('U',true);
                break;
            case 'H4':
                $this->Ln(5);
                $this->SetTextColor(51,51,159);
                $this->SetFontSize(14);
                $this->SetStyle('B',true);
                break;
            case 'PRE':
                $this->SetFontSize(11);
                $this->SetStyle('B',false);
                $this->SetStyle('I',false);
                $this->PRE=true;
                break;
           case 'BLOCKQUOTE':
                $this->mySetTextColor(100,0,45);
                $this->Ln(3);
                break;
            case 'I':
            case 'EM':
                $this->SetStyle('I',true);
                break;
            case 'U':
                $this->SetStyle('U',true);
                break;
            case 'A':
                $this->HREF=$attr['HREF'];
                break;
            case 'IMG':
            case 'img':
                if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                    if(!isset($attr['WIDTH']))
                        $attr['WIDTH'] = 0;
                    if(!isset($attr['HEIGHT']))
                        $attr['HEIGHT'] = 0;
					echo $attr['SRC'];
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                    $this->Ln(3);
                }
                break;
            case 'LI':
                $this->Ln(4);
                $this->Write(5,'    - ');
                $this->mySetTextColor(-1);
                break;
#			case 'TR':
#				$this->Ln(7);
#				$this->PutLine();
#				break;
            case 'BR':
                $this->Ln(2);
                break;
            case 'P':
                $this->Ln(5);
                break;
            case 'HR':
                $this->PutLine();
                break;
            case 'FONT':
                if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                    $coul=hex2dec($attr['COLOR']);
                    $this->mySetTextColor($coul['R'],$coul['G'],$coul['B']);
                    $this->issetcolor=true;
                }
                if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                    $this->SetFont(strtolower($attr['FACE']));
                    $this->issetfont=true;
                }
                break;
        }
	}

	function CloseTag($tag)
	{
		// Etiqueta de cierre
        if ($tag=='H1' || $tag=='H2' || $tag=='H3' || $tag=='H4'){
            $this->Ln(6);
            $this->SetFont('Calibri','',10);
            $this->SetFontSize(10);
            $this->SetStyle('U',false);
            $this->SetStyle('B',false);
            $this->mySetTextColor(-1);
        }
        if ($tag=='PRE'){
            $this->SetFont('Calibri','',10);
            $this->SetFontSize(10);
            $this->PRE=false;
        }
        if ($tag=='RED' || $tag=='BLUE')
            $this->mySetTextColor(-1);
        if ($tag=='BLOCKQUOTE'){
            $this->mySetTextColor(0,0,0);
            $this->Ln(3);
        }
        if($tag=='STRONG')
            $tag='B';
        if($tag=='EM')
            $tag='I';
        if((!$this->bi) && $tag=='B')
            $tag='U';
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='FONT'){
            if ($this->issetcolor==true) {
                $this->SetTextColor(0,0,0);
            }
            if ($this->issetfont) {
                $this->SetFont('Calibri','',10);
                $this->issetfont=false;
            }
        }
		if($tag=='TD') { // TD-END
			$this->tdbegin=false;
			$this->tdwidth=0;
			$this->tdheight=0;
			$this->tdalign="L";
			$this->tdbgcolor=false;
		}
		if($tag=='TR') { // TR-END
			$this->Ln();
		}
		if($tag=='TABLE') { // TABLE-END
			$this->tableborder=0;
		}

	}

	function SetStyle($tag, $enable)
	{
		// Modificar estilo y escoger la fuente correspondiente
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
		// Escribir un hiper-enlace
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
		$this->SetFont('Calibri','',10);
 	}

    function PutLine()
    {
        $this->Ln(2);
        $this->Line($this->GetX(),$this->GetY(),$this->GetX()+187,$this->GetY());
        $this->Ln(3);
    }

    function mySetTextColor($r,$g=0,$b=0){
        static $_r=0, $_g=0, $_b=0;

        if ($r==-1) 
            $this->SetTextColor($_r,$_g,$_b);
        else {
            $this->SetTextColor($r,$g,$b);
            $_r=$r;
            $_g=$g;
            $_b=$b;
        }
    }

	function hex2dec($color = "#000000"){
		$tbl_color = array();
		$tbl_color['R']=hexdec(substr($color, 1, 2));
		$tbl_color['G']=hexdec(substr($color, 3, 2));
		$tbl_color['B']=hexdec(substr($color, 5, 2));
		return $tbl_color;
	}

	function px2mm($px){
		return $px*25.4/72;
	}

	function WriteTableValoraciones($id){
		global $db,$dbhandle,$valoracion_economica,$unitats,$articulos,$precio,$total,$descuento;

		$this->SetTextColor(51,51,159);
		$this->SetFontSize(14);
		$this->SetStyle('B',true);
		$this->Cell(180,5,$valoracion_economica,0,1);
		$this->entryTOC($valoracion_economica,0);
		$this->Ln(5);
 
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(0,0,0);

 		$sqlov = "select * from sim_comercial_oferta_valoracion where aceptada=1 and id_comercial_oferta=".$id;
		$resultov = mysqli_query($dbhandle,convertSQL($sqlov));
		$rowov = mysqli_fetch_array($resultov);
		if ($rowov){
			$this->SetFont('Calibri','',12);
			$this->Cell(180,5,$rowov["descripcion"],0,1);
			$this->Ln();
			$this->SetFont('Calibri','',10);
			$this->Cell(100,5,$articulos,0,0);
			$this->Cell(40,5,$unitats,0,0);
			$this->Cell(40,5,$precio." ".$total,0,1,'R');

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
				$this->Cell(40,5,$total_art." ".$rowd["abrev"],0,1,'R');
			}
			$this->Cell(40,5,'','T',0);
			$this->Cell(100,5,$descuento.": ".$rowov["descuento"]."%",'T',0);
			$total_valoracion = $total_val - (($total_val*$rowov["descuento"])/100);
			$this->Cell(40,5,$total_valoracion." ".$rowd["abrev"],'T',1,'R');
			$this->Ln(15);
		} else {
			$sqlov = "select * from sim_comercial_oferta_valoracion where id_comercial_oferta=".$id;
			$resultov = mysqli_query($dbhandle,convertSQL($sqlov));
			while ($rowov = mysqli_fetch_array($resultov)){

				$this->SetFont('Calibri','',12);
				$this->Cell(180,5,$rowov["descripcion"],0,1);
				$this->Ln();
				$this->SetFont('Calibri','',10);
				$this->Cell(100,5,$articulos,0,0);
				$this->Cell(40,5,$unitats,0,0);
				$this->Cell(40,5,$precio." ".$total,0,1,'R');

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
					$this->Cell(40,5,$total_art." ".$rowd["abrev"],0,1,'R');
				}
				$this->Cell(40,5,'','T',0);
				$this->Cell(100,5,$descuento.": ".$rowov["descuento"]."%",'T',0);
				$total_valoracion = $total_val - (($total_val*$rowov["descuento"])/100);
				$this->Cell(40,5,$total_valoracion." ".$rowd["abrev"],'T',1,'R');
				$this->Ln(15);
			}
		}
	}
	
	function Portada($titul,$descripcio,$data,$versio,$aut)
	{
		global $db,$dbhandle,$titulo,$tema,$fecha,$version,$autor,$adress,$texto_lopd;

		$sql1 = "select id,usuario from sgm_users where sgm=1 and id=".$aut;
		$result1 = mysqli_query($dbhandle,convertSQL($sql1));
		$row1 = mysqli_fetch_array($result1);

		$this->AddPage();
		$this->SetFillColor(51,51,159);
		$this->Cell(0,15,'',0,1,'C',true);
		$this->Image('pics/fpdf/logo_sim.jpg',150,25,50,10,'JPG');
		$this->Image('pics/fpdf/imagen_portada.jpg',10,35,190,100,'JPG');
		$this->Ln(112);
		$this->SetFillColor(180,180,237);
		$this->SetTextColor(255,255,255);
		$this->SetFont('Arial','',25);
		$this->Cell(70,20,$titul,0,0,'L',true);
		$this->SetFont('Arial','',18);
		$this->Cell(0,20,$descripcion,0,1,'L',true);
		$this->Ln(2);
		$this->SetFillColor(51,51,159);
		$this->Cell(0,80,'',0,1,'C',true);
		$this->Ln(0.5);
		$this->SetFont('Arial','B',9);
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
		$this->SetFont('Arial','',8);
		$this->Cell(43,10,$titul,1,0,'C');
		$this->Cell(43,10,$descripcio,1,0,'C');
		$this->Cell(30,10,$data,1,0,'C');
		$this->Cell(30,10,$versio,1,0,'C');
		$this->Cell(43,10,$row1['usuario'],1,1,'C');
		
		
		
		
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
		$this->SetFont('Arial','B',9);
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(51,51,159);
		$this->MultiCell(0,5,"\n\n\n".$adress."\n\n\n\n\n\n",0,'C',true);
		$this->SetXY(87,245);
		$this->Write(5,'www.solucions-im.com','http://www.solucions-im.com');
	}

}


	
 	$pdf=new PDF();
	$pdf->AddFont('Calibri','','../font/Calibri.php');
	$pdf->AddFont('Calibri-Bold','B','../font/Calibrib.php');
	$pdf->AddFont('Calibri','B','../font/Calibrib.php');
	$pdf->SetCreator("Solucions-IM");
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle($rowof["descripcion"]);
	$pdf->Portada('Oferta Comercial',$rowof["descripcion"],$rowof["fecha"],$rowof["version"],$rowof["id_autor"]);
	$pdf->startPageNums();

	$pdf->AddPage();
	$contenido_antecedentes = html_entity_decode(utf8_decode($rowof["contenido_antecedentes"]));
	$contenido_necesidades = html_entity_decode(utf8_decode($rowof["contenido_necesidades"]));
	$contenido_mejoras = html_entity_decode(utf8_decode($rowof["contenido_mejoras"]));

	$pdf->SetTextColor(51,51,159);
	$pdf->SetFontSize(14);
	$pdf->SetStyle('B',true);
	$pdf->Cell(180,5,"1 ".$descripcion_general,0,1);
	$pdf->entryTOC("1 ".$descripcion_general,0);
	$pdf->Ln(5);

	$pdf->Cell(180,5,"1.1 ".$antecedentes,0,1);
	$pdf->entryTOC("1.1 ".$antecedentes,0);
	$pdf->Ln(5);

	$texto_html = $contenido_antecedentes."<br>";
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Calibri','',10);
	$pdf->WriteHTML($texto_html);
	$pdf->Ln(15);

	$pdf->SetTextColor(51,51,159);
	$pdf->SetFontSize(14);
	$pdf->SetStyle('B',true);
	$pdf->Cell(180,5,"1.2 ".$necesidades_objetivos,0,1);
	$pdf->entryTOC("1.2 ".$necesidades_objetivos,0);
	$pdf->Ln(5);

	$texto_html = $contenido_necesidades."<br>";
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Calibri','',10);
	$pdf->WriteHTML($texto_html);
	$pdf->Ln(15);

	$pdf->SetTextColor(51,51,159);
	$pdf->SetFontSize(14);
	$pdf->SetStyle('B',true);
	$pdf->Cell(180,5,"1.3 ".$propuesta_mejoras,0,1);
	$pdf->entryTOC("1.3 ".$propuesta_mejoras,0);
	$pdf->Ln(5);

	$texto_html = $contenido_mejoras."<br>";
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Calibri','',10);
	$pdf->WriteHTML($texto_html);
	$pdf->Ln(15);

	$orden_contenido = 1;
	$sqlofc = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
	$resultofc = mysqli_query($dbhandle,convertSQL($sqlofc));
	while ($rowofc = mysqli_fetch_array($resultofc)){
#		echo $orden_contenido."-".substr($rowofc["orden"],0,2)."<br>";
		if ($orden_contenido != substr($rowofc["orden"],0,2)){
			$pdf->AddPage();
			$orden_contenido = substr($rowofc["orden"],0,2);
		} else {
			$pdf->Ln(15);
		}
		$sqlcon = "select * from sim_comercial_contenido where id=".$rowofc["id_comercial_contenido"];
		$resultcon = mysqli_query($dbhandle,convertSQL($sqlcon));
		$rowcon = mysqli_fetch_array($resultcon);
		if ($_POST["tipo"] == 0) {$contenido = $rowcon["contenido"];} else {$contenido = $rowcon["contenido"].$rowcon["contenido_extenso"];}

		$pdf->SetTextColor(51,51,159);
		$pdf->SetFontSize(14);
		$pdf->SetStyle('B',true);
		
		$pdf->Cell(180,5,ltrim($rowofc["orden"],'0')." ".$rowcon["titulo"],0,1);
		$pdf->entryTOC(ltrim($rowofc["orden"],'0')." ".$rowcon["titulo"],0);
		$pdf->Ln(5);

		$texto_html = html_entity_decode(utf8_decode($contenido))."<br>";
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Calibri','',10);
		$pdf->WriteHTML($texto_html);
	}
	$pdf->AddPage();
	$pdf->WriteTableValoraciones($_GET["id"]);
	$pdf->stopPageNums();
	$pdf->insertTOC(3);
	$pdf->Contraportada();

	$pdf->Output("../pdf/oferta.pdf");
	header("Location: ../pdf/oferta.pdf");

	// Cerrar la conexi�n
	mysql_close($dbhandle);

?>
