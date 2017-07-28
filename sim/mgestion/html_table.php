<?php
require('fpdf.php');
require('htmlparser.inc');

function px2mm($px){
    return $px*25.4/72;
}

class PDF_HTML_Table extends FPDF
{
protected $B;
protected $I;
protected $U;
protected $HREF;

function __construct($orientation='P', $unit='mm', $format='A4')
{
	//Call parent constructor
	parent::__construct($orientation,$unit,$format);
	//Initialization
	$this->B=0;
	$this->I=0;
	$this->U=0;
	$this->HREF='';
}

function Justify($text, $w, $h)
{
	if (strlen($text) > 2){
		$tab_paragraphe = explode("\n", $text);
		$nb_paragraphe = count($tab_paragraphe);
		$j = 0;

		while ($j<$nb_paragraphe) {

			$paragraphe = $tab_paragraphe[$j];
			$tab_mot = explode(' ', $paragraphe);
			$nb_mot = count($tab_mot);

			// Handle strings longer than paragraph width
			$k=0;
			$l=0;
			while ($k<$nb_mot) {

				$len_mot = strlen ($tab_mot[$k]);
				if ($len_mot<($w-5) )
				{
					$tab_mot2[$l] = $tab_mot[$k];
					$l++;    
				} else {
					$m=0;
					$chaine_lettre='';
					while ($m<$len_mot) {

						$lettre = substr($tab_mot[$k], $m, 1);
						$len_chaine_lettre = $this->GetStringWidth($chaine_lettre.$lettre);

						if ($len_chaine_lettre>($w-7)) {
							$tab_mot2[$l] = $chaine_lettre . '-';
							$chaine_lettre = $lettre;
							$l++;
						} else {
							$chaine_lettre .= $lettre;
						}
						$m++;
					}
					if ($chaine_lettre) {
						$tab_mot2[$l] = $chaine_lettre;
						$l++;
					}

				}
				$k++;
			}

			// Justified lines
			$nb_mot = count($tab_mot2);
			$i=0;
			$ligne = '';
			while ($i<$nb_mot) {

				$mot = $tab_mot2[$i];
				$len_ligne = $this->GetStringWidth($ligne . ' ' . $mot);

				if ($len_ligne>($w-5)) {

					$len_ligne = $this->GetStringWidth($ligne);
					$nb_carac = strlen ($ligne);
					$ecart = (($w-2) - $len_ligne) / $nb_carac;
					$this->_out(sprintf('BT %.3F Tc ET',$ecart*$this->k));
					$this->MultiCell($w,$h,$ligne);
					$ligne = $mot;

				} else {

					if ($ligne)
					{
						$ligne .= ' ' . $mot;
					} else {
						$ligne = $mot;
					}

				}
				$i++;
			}

			// Last line
			$this->_out('BT 0 Tc ET');
			$this->MultiCell($w,$h,$ligne);
			$tab_mot = '';
			$tab_mot2 = '';
			$j++;
		}

	}
}

function WriteHTML2($html)
{
	global $lista_spc;
	//HTML parser
 	$html=str_replace("\n",' ',$html);
	$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			//Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else{
				$w = 170;
				if ($lista_spc == 1){ $w = 167;}
				if ($lista_spc == 2){ $w = 160;}
				if ($lista_spc == 3){ $w = 152;}
				if ($lista_spc == 4){ $w = 144;}
				$this->justify($e,$w,4);
#				$this->Write(5,$e);
			}
		}
		else
		{
			//Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				//Extract attributes
				$a2=explode(' ',$e);
				$tag=strtoupper(array_shift($a2));
				$attr=array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])]=$a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

function OpenTag($tag, $attr)
{
	global $lista_spc;
	//Opening tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF=$attr['HREF'];
	if($tag=='BR')
		$this->Ln(3);
	if($tag=='P')
		$this->Ln(3);
	if($tag=='IMG'){
		if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
			if(!isset($attr['WIDTH'])){
				$attr['WIDTH'] = 0;
			}
			if(!isset($attr['HEIGHT'])){
				$attr['HEIGHT'] = 0;
			}
			$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
		}
		$this->Ln();
	}
	if($tag=='UL'){
		$lista_spc++;
	}
	if($tag=='LI'){
		$this->Ln();
		if ($lista_spc == 1){
			$this->Write(5,' - ');
		}
		if ($lista_spc == 2){
			$this->Write(5,'         - ');
		}
		if ($lista_spc == 3){
			$this->Write(5,'                - ');
		}
		if ($lista_spc == 4){
			$this->Write(5,'                        - ');
		}
	}
}

function CloseTag($tag)
{
	global $lista_spc;
	//Closing tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF='';
	if($tag=='P')
		$this->Ln();
	if($tag=='UL'){
		$lista_spc--;
		if ($lista_spc == 0){
			$this->Ln();
		}
	}
}

function SetStyle($tag, $enable)
{
	//Modify style and select corresponding font
	$this->$tag+=($enable ? 1 : -1);
	$style='';
	foreach(array('B','I','U') as $s)
		if($this->$s>0)
			$style.=$s;
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	//Put a hyperlink
	$this->SetTextColor(0,0,0);
#	$this->SetStyle('U',true);
	$this->SetFont('Arial','U',10);
	$this->Write(5,$txt,$URL);
#	$this->SetStyle('Arial',false);
	$this->SetFont('Calibri','',10);
	$this->SetTextColor(0);
}

function WriteTable($data, $w)
{
	$this->SetLineWidth(.3);
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	foreach($data as $row)
	{
		$nb=0;
		for($i=0;$i<count($row);$i++)
			$nb=max($nb,$this->NbLines($w[$i],trim($row[$i])));
		$h=5*$nb;
		$this->CheckPageBreak($h);
		for($i=0;$i<count($row);$i++)
		{
			$x=$this->GetX();
			$y=$this->GetY();
			$this->Rect($x,$y,$w[$i],$h);
			$this->MultiCell($w[$i],5,trim($row[$i]),0,'L');
			//Put the position to the right of the cell
			$this->SetXY($x+$w[$i],$y);					
		}
		$this->Ln($h);
	}
}

function NbLines($w, $txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
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
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function ReplaceHTML($html)
{
	$html = html_entity_decode(utf8_decode($html));
#	$html = str_replace( '<li>', "\n<br> - " , $html );
#	$html = str_replace( '<LI>', "\n - " , $html );
#	$html = str_replace( '</ul>', "\n\n" , $html );
	$html = str_replace( '<strong>', "<b>" , $html );
	$html = str_replace( '</strong>', "</b>" , $html );
#	$html = str_replace( '<em>', "<i>" , $html );
#	$html = str_replace( '</em>', "</i>" , $html );
	$html = str_replace( '&#160;', "\n" , $html );
	$html = str_replace( '&nbsp;', " " , $html );
	$html = str_replace( '&quot;', "\"" , $html ); 
	$html = str_replace( '&rsquo;',"'",$html);
	$html = str_replace( '&ndash;','-',$html);
	$html = str_replace( '&ldquo;','"',$html);
	$html = str_replace( '&rdquo;','"',$html);
	$html = str_replace( '&#39;', "'" , $html );
	$html = str_replace( '&trade;','™',$html);
	$html = str_replace( '&copy;','©',$html);
	$html = str_replace( '&euro;',chr(128),$html);
	return $html;
}

function ParseTable($Table)
{
	$_var='';
	$htmlText = $Table;
	$parser = new HtmlParser ($htmlText);
	while ($parser->parse())
	{
		if(strtolower($parser->iNodeName)=='table')
		{
			if($parser->iNodeType == NODE_TYPE_ENDELEMENT)
				$_var .='/::';
			else
				$_var .='::';
		}
		if(strtolower($parser->iNodeName)=='tr')
		{
			if($parser->iNodeType == NODE_TYPE_ENDELEMENT)
				$_var .='!-:'; //opening row
			else
				$_var .=':-!'; //closing row
		}
		if(strtolower($parser->iNodeName)=='td' && $parser->iNodeType == NODE_TYPE_ENDELEMENT)
		{
			$_var .='#,#';
		}
		if ($parser->iNodeName=='Text' && isset($parser->iNodeValue))
		{
			$_var .= $parser->iNodeValue;
		}
	}
	$elems = explode(':-!',str_replace('/','',str_replace('::','',str_replace('!-:','',$_var)))); //opening row
	foreach($elems as $key=>$value)
	{
		if(trim($value)!='')
		{
			$elems2 = explode('#,#',$value);
			array_pop($elems2);
			$data[] = $elems2;
		}
	}
	return $data;
}

function WriteHTML($html,$index)
{
	$lista_spc = 0;
	if ($index == 0) { $html = $this->ReplaceHTML($html); }
	//Search for a table
	$start = strpos(strtolower($html),'<table');
	$end = strpos(strtolower($html),'</table');
	if($start!==false && $end!==false)
	{
		$this->WriteHTML2(substr($html,0,$start).'<BR>');
		$tableVar = substr($html,$start,$end-$start);
		$tableData = $this->ParseTable($tableVar);
		for($i=1;$i<=count($tableData[0]);$i++)
		{
			if($this->CurOrientation=='L')
				$w[] = abs(150/(count($tableData[0])))+24;
			else
				$w[] = abs(150/(count($tableData[0])))+5;
		}
		$this->WriteTable($tableData,$w);
		$this->WriteHTML(substr($html,$end+8,strlen($html)-1).'<BR>',1);
	}
	else
	{
		$this->WriteHTML2($html);
	}
}

}
?>