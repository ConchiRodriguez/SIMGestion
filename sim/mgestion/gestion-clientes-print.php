<?php

#error_reporting(E_ALL);

	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$idioma = strtolower("es");
	include ("lenguajes/factura-print-".$idioma.".php");

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
		$this->Image('../../archivos_comunes/images/logo1.jpg',160,285,40);
	}
	function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
	function HTML2RGB($c, &$r, &$g, &$b)
	{
		static $colors = array('aliceblue'=>'#F0F8FF','antiquewhite'=>'#FAEBD7','aqua'=>'#00FFFF','aquamarine'=>'#7FFFD4','azure'=>'#F0FFFF','beige'=>'#F5F5DC',
						'bisque'=>'#FFE4C4','black'=>'#000000','blanchedalmond'=>'#FFEBCD','blue'=>'#0000FF','blueviolet'=>'#8A2BE2','brown'=>'#A52A2A',
						'burlywood'=>'#DEB887','cadetblue'=>'#5F9EA0','chartreuse'=>'#7FFF00','chocolate'=>'#D2691E','coral'=>'#FF7F50','cornflowerblue'=>'#6495ED',
						'cornsilk'=>'#FFF8DC','crimson'=>'#DC143C','Cyan'=>'#00FFFF','darkblue'=>'#00008B','darkcyan'=>'#008B8B','darkgoldenrod'=>'#B8860B',
						'darkgray'=>'#A9A9A9','darkgreen'=>'#006400','darkkhaki'=>'#BDB76B','darkmagenta'=>'#8B008B','darkolivegreen'=>'#8B008B',
						'darkorange'=>'#FF8C00','darkorchid'=>'#9932CC','darkred'=>'#8B0000','darksalmon'=>'#E9967A','darkseagreen'=>'#8FBC8F',
						'darkslateblue'=>'#483D8B','darkslategrey'=>'#2F4F4F','darkturquoise'=>'#00CED1','darkviolet'=>'#9400D3','deeppink'=>'#FF1493',
						'deepskyblue'=>'#00BFFF','dimgray'=>'#696969','dodgerblue'=>'#1E90FF','firebrick'=>'#B22222',''=>'#','floralwhite'=>'#FFFAF0',
						'forestgreen'=>'#228B22','fuchsia'=>'#FF00FF','gainsboro'=>'#DCDCDC','ghostwhite'=>'#F8F8FF','gold'=>'#FFD700','goldenrod'=>'#DAA520',
						'gray'=>'#808080','green'=>'#008000','greenyellow'=>'#ADFF2F','honeydew'=>'#F0FFF0','hotpink'=>'#FF69B4','indianred'=>'#CD5C5C',
						'indigo'=>'#4B0082','ivory'=>'#FFFFF0','khaki'=>'#F0E68C','lavander'=>'#E6E6FA','lavanderblush'=>'#FFF0F5','lawngreen'=>'#7CFC00',
						'lemonchiffon'=>'#FFFACD','lightblue'=>'#ADD8E6','lightcoral'=>'#F08080','lightcyan'=>'#E0FFFF','lightgoldenrodyellow'=>'#FAFAD2',
						'lightgreen'=>'#90EE90','lightgrey'=>'#D3D3D3','lightpink'=>'#FFB6C1','lightsalmon'=>'#FFA07A','lightseagreen'=>'#20B2AA',
						'lightskyblue'=>'#87CEFA','lightslategrey'=>'#778899','lightsteelblue'=>'#B0C4DE','lightyellow'=>'#FFFFE0','lime'=>'#00FF00',
						'limegreen'=>'#32CD32','linen'=>'#FAF0E6','magenta'=>'#FF00FF','maroon'=>'#800000','mediumaquamarine'=>'#66CDAA','mediumblue'=>'#0000CD',
						'mediumorchid'=>'#BA55D3','mediumpurple'=>'#9370DB','mediumseagreen'=>'#3CB371','mediumslateblue'=>'#7B68EE','mediumspringgreen'=>'#00FA9A',
						'mediumturquoise'=>'#48D1CC','mediumvioletred'=>'#C71585','midnightblue'=>'#191970','mintcream'=>'#F5FFFA','mistyrose'=>'#FFE4E1',
						'moccasin'=>'#FFE4B5','navajowhite'=>'#FFDEAD','navy'=>'#000080','oldlace'=>'#FDF5E6','olive'=>'#808000','olivedrab'=>'#6B8E23',
						'orange'=>'#FFA500','orangered'=>'#FF4500','orchid'=>'#DA70D6','palegoldenrod'=>'#EEE8AA','palegreen'=>'#98FB98','paleturquoise'=>'#AFEEEE',
						'palevioletred'=>'#DB7093','papayawhip'=>'#FFEFD5','peachpuff'=>'#FFDAB9','peru'=>'#CD853F','pink'=>'#FFC0CB','plum'=>'#DDA0DD',
						'powderblue'=>'#B0E0E6','purple'=>'#800080','red'=>'#FF0000','rosybrown'=>'#BC8F8F','royalblue'=>'#4169E1','saddlebrown'=>'#8B4513',
						'salmon'=>'#FA8072','sandybrown'=>'#F4A460','seagreen'=>'#2E8B57','seashell'=>'#FFF5EE','sienna'=>'#A0522D','silver'=>'#C0C0C0',
						'skyblue'=>'#87CEEB','slateblue'=>'#6A5ACD','slategray'=>'#708090','snow'=>'#FFFAFA','springgreen'=>'#00FF7F','steelblue'=>'#4682B4',
						'tan'=>'#D2B48C','teal'=>'#008080','thistle'=>'#D8BFD8','tomato'=>'#FF6347','turquoise'=>'#40E0D0','violet'=>'#EE82EE','wheat'=>'#F5DEB3',
						'white'=>'#FFFFFF','whitesmoke'=>'#F5F5F5','yellow'=>'#FFFF00','yellowgreen'=>'#9ACD32');

		$c=strtolower($c);
		if(isset($colors[$c])){
			$c=$colors[$c];
		}
		if($c[0]!='#') {
			$this->Error('Incorrect color: '.$c);
		} else {
			$r=hexdec(substr($c,1,2));
			$g=hexdec(substr($c,3,2));
			$b=hexdec(substr($c,5,2));
		}
	}
	function SetFillColor($r, $g=-1, $b=-1)
	{
		if(is_string($r))
			if ($r[0] == '#'){
				List($red,$green,$black) = $this->hex2rgb($r);
				parent::SetFillColor($red,$green,$black);
			} else {
				$this->HTML2RGB($r,$r,$g,$b);
				parent::SetFillColor($r,$g,$b);
			}
	}
	
	function SetTextColor($r,$g=-1,$b=-1)
	{
		if(is_string($r))
			if ($r[0] == '#'){
				List($red,$green,$black) = $this->hex2rgb($r);
				parent::SetTextColor($red,$green,$black);
			} else {
				$this->HTML2RGB($r,$r,$g,$b);
				parent::SetTextColor($r,$g,$b);
			}
	}
}

	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('times','B',16);

	$pdf->Cell(40,10,"Contactos :",0,1);
	$pdf->SetFont('times','',8);
	$ln = 0;
	if ($_POST["id_classificacio"] != 0) {
		$sqlc = "select * from sgm_clients_classificacio_tipus where id in (".$_POST["id_classificacio"].")";
		$resultc = mysql_query(convert_sql($sqlc));
		while ($rowc = mysql_fetch_array($resultc)){
			$id_classificacio .= "".$rowc["nom"]."  ";
		}
		$pdf->Cell(105,5, $id_classificacio);
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["tipo"] != 0) {
		$sqlt = "select * from sgm_clients_tipos where id in (".$_POST["tipo"].")";
		$resultt = mysql_query(convert_sql($sqlt));
		while ($rowt = mysql_fetch_array($resultt)){
			$tipo .= "".$rowt["tipo"]."  ";
		}
		$pdf->Cell(105,5,"Tipo: ".$tipo."");
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["grupo"] != 0) {
		$sqlg = "select * from sgm_clients_grupos where id in (".$_POST["grupo"].")";
		$resultg = mysql_query(convert_sql($sqlg));
		while ($rowg = mysql_fetch_array($resultg)){
			$grupo .= $rowg["grupo"]."  ";
		}
		$pdf->Cell(105,5,"Grupo: ".$grupo."");
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["sector"] != 0) {
		$sqls = "select * from sgm_clients_sectors where id in (".$_POST["sector"].")";
		$results = mysql_query(convert_sql($sqls));
		while ($rows = mysql_fetch_array($results)){
			$sector .= $rows["sector"]."  ";
		}
		$pdf->Cell(105,5,"Sector: ".$sector."");
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["ubicacion"] != 0) {
		$sqlu = "select * from sgm_clients_ubicacion where id in (".$_POST["ubicacion"].")";
		$resultu = mysql_query(convert_sql($sqlu));
		while ($rowu = mysql_fetch_array($resultu)){
			$ubicacion .= $rowu["ubicacion"]."  ";
		}
		$pdf->Cell(105,5,"Ubicación: ".$ubicacion."");
		$ln += 1;
	}
	if ($ln == 1){$pdf->Ln();}
	$pdf->Ln(10);
	$z = 0;
	#### DETERMINA SI HAY FILTRO POR INICIO LETRA
	$ver_todas_letras = true;
	for ($i = 0; $i <= 127; $i++) {
		if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
			if ($_POST[chr($i)] == true) {
				$ver_todas_letras = false;
			}
		}
	}
	#### INICIA BUCLE TODAS LAS LETRAS
	for ($i = 0; $i <= 127; $i++) {
		if ( ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) and (($_POST[chr($i)] == "true") or ($ver_todas_letras == true)) ) {
			$linea_letra = 1;
			$color = "white";
			$calidad = 0;
			$sql = "select * from sgm_clients where visible=1";
			if ($tipo != "") { $sql = $sql." and id_tipo in (".$_POST["tipo"].")"; }
			if ($grupo != "") { $sql = $sql." and id_grupo in (".$_POST["grupo"].")"; }
			if ($sector != "") { $sql = $sql." and sector in (".$_POST["sector"].")"; }
			if ($ubicacion != "") { $sql = $sql." and id_ubicacion in (".$_POST["ubicacion"].")"; }
			if ($_POST["id_client"] != 0) { $sql = $sql." and id=".$_POST["id_client"]; }
			$sql = $sql." and nombre like '".chr($i)."%'";
			if ($_POST["likenombre"] != "") {
				$sql = $sql." and (nombre like '%".$_POST["likenombre"]."%' or cognom1 like '%".$_POST["likenombre"]."%' or cognom2 like '%".$_POST["likenombre"]."%')";
			}
			$sql =$sql." order by nombre,cognom1,cognom2,id_origen";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$ver = true;
				#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
				if ($ver_todas_letras == false) {
					if ($_POST[chr($i)] != true) {
						$ver = false;
					}
				}
				#### BUSCA TIPUS
				if (($ver == true) and (($_GET["id_classificacio"] != "") OR ($_POST["id_classificacio"] != ""))) {
					if (($_GET["id_classificacio"] != "") OR ($_POST["id_classificacio"] != 0))  {
						if ($_GET["id_classificacio"] != "") { $id_classificacio = $_GET["id_classificacio"]; }
						if ($_POST["id_classificacio"] != "") { $id_classificacio = $_POST["id_classificacio"]; }
						$sqlcxx = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus in (".$id_classificacio.")";
						$resultcxx = mysql_query(convert_sql($sqlcxx));
						$rowcxx = mysql_fetch_array($resultcxx);
						if ($rowcxx["total"] <= 0) { $ver = false; }
						$sqlcxx2 = "select * from sgm_clients_classificacio_tipus where id_origen in (".$id_classificacio.")";
						$resultcxx2 = mysql_query(convert_sql($sqlcxx2));
						while ($rowcxx2 = mysql_fetch_array($resultcxx2)) {
							$sqlcxx3 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx2["id"];
							$resultcxx3 = mysql_query(convert_sql($sqlcxx3));
							$rowcxx3 = mysql_fetch_array($resultcxx3);
							if ($rowcxx3["total"] > 0) { $ver = true; }
							$sqlcxx4 = "select * from sgm_clients_classificacio_tipus where id_origen=".$rowcxx2["id"];
							$resultcxx4 = mysql_query(convert_sql($sqlcxx4));
							while ($rowcxx4 = mysql_fetch_array($resultcxx4)) {
								$sqlcxx5 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx4["id"];
								$resultcxx5 = mysql_query(convert_sql($sqlcxx5));
								$rowcxx5 = mysql_fetch_array($resultcxx5);
								if ($rowcxx5["total"] > 0) { $ver = true; }
							}
						}
					}
				}
				#### INICI IMPRESIO PANTALLA
				if ($ver == true) {
					$pdf->SetFillColor("white");
					$pdf->SetTextColor("black");
					$z++;
					$sqlc = "select * from sgm_clients where id=".$row["id"];
					$resultc = mysql_query(convert_sql($sqlc));
					$rowc = mysql_fetch_array($resultc);
					if ($_POST["colorsi"] == true){
						$sqlctt = "select * from sgm_clients_classificacio where visible=1 and id_clasificacio_tipus<>0 and id_client=".$row["id"]." and predeterminado=1";
						$resultctt = mysql_query(convert_sql($sqlctt));
						$rowctt = mysql_fetch_array($resultctt);
						if ($rowctt) {
							$id_class_tipus = $rowctt["id_clasificacio_tipus"];
						} else {
							$sqlcc = "select * from sgm_clients_classificacio where id_client=".$row["id"];
							$resultcc = mysql_query(convert_sql($sqlcc));
							$rowcc = mysql_fetch_array($resultcc);
							$id_class_tipus = $rowcc["id_clasificacio_tipus"];
						}
						if ($id_class_tipus > 0){
							$sqlct = "select * from sgm_clients_classificacio_tipus where id=".$id_class_tipus;
							$resultct = mysql_query(convert_sql($sqlct));
							$rowct = mysql_fetch_array($resultct);
							if ($rowct["color"] != ""){
								$pdf->SetFillColor($rowct["color"]);
								$pdf->SetTextColor($rowct["color_lletra"]);
								$pinta = true;
							} else {
								$pinta = false;
							}
						} else {
							$pinta = false;
						}
					} else {
						$pinta = false;
					}
					$pdf->Cell(0,5,$z." -  ".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]." ".$rowc["telefono"],0,1,'L',$pinta);
					$y = $pdf->GetY();
					$x = $pdf->GetX();
					$pdf->SetXY($x+4,$y);
					if (($rowc["direccion"] != "") and ($rowc["id_carrer"] == 0)){
						$pdf->Cell(0,5,$rowc["direccion"]." ".$rowc["poblacion"]." ".$rowc["cp"]." ".$rowc["provincia"]."",0,1,'L',$pinta);
					}
					if ($rowc["id_carrer"] > 0){
						$sqld = "select * from sgm_clients_carrer_tipo where id=".$rowc["id_tipo_carrer"]." and visible=1";
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$sqldd = "select * from sgm_clients_carrer where id=".$rowc["id_carrer"]." and visible=1";
						$resultdd = mysql_query(convert_sql($sqldd));
						$rowdd = mysql_fetch_array($resultdd);
						$sqlddd = "select * from sgm_clients_sector_zf where id=".$rowc["id_sector_zf"]." and visible=1";
						$resultddd = mysql_query(convert_sql($sqlddd));
						$rowddd = mysql_fetch_array($resultddd);
						$pdf->Cell(0,5,"".$rowd["nombre"]." ".$rowdd["nombre"]." ".$rowc["numero"]." ".$rowddd["nombre"]." ".$rowc["poblacion"]." ".$rowc["cp"]." ".$rowc["provincia"]."",0,1,'L',$pinta);
					}
					if ($_POST["completa"] == true){
						$sqlc1 = "select * from sgm_clients_contactos where id_client=".$rowc["id"];
						$resultc1 = mysql_query(convert_sql($sqlc1));
						while ($rowc1 = mysql_fetch_array($resultc1)){
							$y = $pdf->GetY();
							$x = $pdf->GetX();
							$pdf->SetXY($x+4,$y);
							$pdf->Cell(0,5,"".  $rowc1["nombre"]." ".  $rowc1["apellido1"]." ".  $rowc1["apellido2"]." ".  $rowc1["telefono"]." ".  $rowc1["movil"]." ".  $rowc1["fax"]." ".  $rowc1["mail"]." ".  $rowc12["carrec"]."",0,1,'L',$pinta);
						}
					}
				}
			}
		}
	}

	$pdf->Output("../pdf/cliente.pdf");
	header("Location: ../pdf/cliente.pdf");

	// Cerrar la conexión
	mysql_close($dbhandle);

?>

