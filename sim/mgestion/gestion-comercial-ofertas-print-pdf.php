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

    function insertTOC( $location=1,$labelSize=20,$entrySize=10,$tocfont='Times') {
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
        $this->SetFont('Times','I',8);
        $this->Cell(0,7,$this->numPageNo(),0,0,'C'); 
        if(!$this->_numbering)
            $this->_numberingFooter=false;
    }

	function WriteHTML($html)
	{
		// Intérprete de HTML
		$html = strip_tags($html,"<a><img><p><br><font><tr><blockquote><h1><h2><h3><h4><pre><red><blue><ul><li><hr>"); 
		$html = str_replace("\n",' ',$html);
		$html = str_replace('&trade;','™',$html);
		$html = str_replace('&copy;','©',$html);
		$html = str_replace('&euro;','€',$html);
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
				else
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
                if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                    if(!isset($attr['WIDTH']))
                        $attr['WIDTH'] = 0;
                    if(!isset($attr['HEIGHT']))
                        $attr['HEIGHT'] = 0;
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                    $this->Ln(3);
                }
                break;
            case 'LI':
                $this->Ln(4);
                $this->Write(5,'    - ');
                $this->mySetTextColor(-1);
                break;
            case 'TR':
                $this->Ln(7);
                $this->PutLine();
                break;
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
            $this->SetFont('Times','',10);
            $this->SetFontSize(10);
            $this->SetStyle('U',false);
            $this->SetStyle('B',false);
            $this->mySetTextColor(-1);
        }
        if ($tag=='PRE'){
            $this->SetFont('Times','',10);
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
                $this->SetFont('Times','',10);
                $this->issetfont=false;
            }
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
		$this->SetFont('Times','',10);
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

	function WriteTable($id){
		global $db,$dbhandle,$valoracion_economica,$unitats,$articulos,$precio,$total;

		$this->SetTextColor(51,51,159);
		$this->SetFontSize(14);
		$this->SetStyle('B',true);
		$this->Cell(180,5,$valoracion_economica,0,1);
		$this->entryTOC($valoracion_economica,0);
		$this->Ln(5);
 
		$this->SetTextColor(0,0,0);
		$this->SetDrawColor(0,0,0);

 		$sqlov = "select * from sim_comercial_oferta_valoracion where id_comercial_oferta=".$id;
		$resultov = mysqli_query($dbhandle,convertSQL($sqlov));
		while ($rowov = mysqli_fetch_array($resultov)){

			$this->SetFont('Times','',12);
			$this->Cell(180,5,$rowov["descripcion"],0,1);
			$this->Ln();
			$this->SetFont('Times','',10);
			$this->Cell(40,5,$unitats,0,0);
			$this->Cell(100,5,$articulos,0,0);
			$this->Cell(40,5,$precio." ".$total,0,1);

			$total_val = 0;
			$sqlcova = "select * from sim_comercial_oferta_valoracion_rel_articulos where id_comercial_oferta_valoracion=".$rowov["id"];
			$resultcova = mysqli_query($dbhandle,convertSQL($sqlcova));
			while ($rowcova = mysqli_fetch_array($resultcova)){
				$sqla = "select * from sgm_articles where id=".$rowcova["id_articulo"];
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				$rowa = mysqli_fetch_array($resulta);

				$sql = "select pvp,id_divisa_pvp from sgm_stock where vigente=1 and id_article=".$rowcova["id_articulo"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				$sqld = "select abrev from sgm_divisas where id=".$row["id_divisa_pvp"];
				$resultd = mysqli_query($dbhandle,convertSQL($sqld));
				$rowd = mysqli_fetch_array($resultd);
				$total_art = $row["pvp"] * $rowcova["unidades"];
				$total_val += $total_art;
				
				$this->SetFont('Times','',10);
				$this->Cell(40,5,$rowcova["unidades"],0,0);
				$this->Cell(100,5,comillasInver($rowa["nombre"]),0,0);
				$this->Cell(40,5,$total_art." ".$rowd["abrev"],0,1,'R');
			}
			$this->Cell(40,5,'','T',0);
			$this->Cell(100,5,'','T',0);
			$this->Cell(40,5,$total_val." ".$rowd["abrev"],'T',1,'R');
			$this->Ln(15);
 		}
	}
}


	
 	$pdf=new PDF();
	$pdf->SetCreator("Solucions-IM");
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle($rowof["descripcion"]);
	$pdf->Portada('Oferta Comercial',$rowi["idioma"]);
	$pdf->startPageNums();

	$sqlofc = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
	$resultofc = mysqli_query($dbhandle,convertSQL($sqlofc));
	while ($rowofc = mysqli_fetch_array($resultofc)){
		$pdf->AddPage();
		$sqlcon = "select * from sim_comercial_contenido where id=".$rowofc["id_comercial_contenido"];
		$resultcon = mysqli_query($dbhandle,convertSQL($sqlcon));
		$rowcon = mysqli_fetch_array($resultcon);
		if ($_POST["tipo"] == 0) {$contenido = html_entity_decode ($rowcon["contenido"]);} else {$contenido = html_entity_decode ($rowcon["contenido"].$rowcon["contenido_extenso"]);}

		$pdf->SetTextColor(51,51,159);
		$pdf->SetFontSize(14);
		$pdf->SetStyle('B',true);
		$pdf->Cell(180,5,$rowofc["orden"]." ".$rowcon["titulo"],0,1);
		$pdf->entryTOC($rowofc["orden"]." ".$rowcon["titulo"],0);
		$pdf->Ln(5);

		$texto_html = $contenido."<br>";
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Times','',10);
		$pdf->WriteHTML($texto_html);
		
		$sqlf = "select * from sgm_files where tipo_id_elemento=7 and id_elemento=".$rowcon["id"];
		$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
		$rowf = mysqli_fetch_array($resultf);
		if ($rowf){
			$pdf->Image('../archivos/comercial/'.$rowf["name"],$pdf->GetX(),$pdf->GetY()+10,100,50);
		}
	}
	$pdf->AddPage();
	$pdf->WriteTable($_GET["id"]);
	$pdf->stopPageNums();
	$pdf->insertTOC(3);
	$pdf->Contraportada();

	$pdf->Output("../pdf/oferta.pdf");
	header("Location: ../pdf/oferta.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>
