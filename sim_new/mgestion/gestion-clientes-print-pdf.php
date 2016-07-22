<?php

#error_reporting(E_ALL);

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
		$sqlc = "select * from sim_clientess_classificacio_tipus where id in (".$_POST["id_classificacio"].")";
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		while ($rowc = mysqli_fetch_array($resultc)){
			$id_classificacio .= "".$rowc["nom"]."  ";
		}
		$pdf->Cell(105,5, $id_classificacio);
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["tipo"] != 0) {
		$sqlt = "select * from sim_clientess_tipos where id in (".$_POST["tipo"].")";
		$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
		while ($rowt = mysqli_fetch_array($resultt)){
			$tipo .= "".$rowt["tipo"]."  ";
		}
		$pdf->Cell(105,5,"Tipo: ".$tipo."");
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["grupo"] != 0) {
		$sqlg = "select * from sim_clientess_grupos where id in (".$_POST["grupo"].")";
		$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
		while ($rowg = mysqli_fetch_array($resultg)){
			$grupo .= $rowg["grupo"]."  ";
		}
		$pdf->Cell(105,5,"Grupo: ".$grupo."");
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["sector"] != 0) {
		$sqls = "select * from sim_clientess_sectors where id in (".$_POST["sector"].")";
		$results = mysqli_query($dbhandle,convertSQL($sqls));
		while ($rows = mysqli_fetch_array($results)){
			$sector .= $rows["sector"]."  ";
		}
		$pdf->Cell(105,5,"Sector: ".$sector."");
		$ln += 1;
	}
	if ($ln == 2){$pdf->Ln(); $ln =0;}
	if ($_POST["ubicacion"] != 0) {
		$sqlu = "select * from sim_clientess_ubicacion where id in (".$_POST["ubicacion"].")";
		$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
		while ($rowu = mysqli_fetch_array($resultu)){
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
	for ($i = 48; $i <= 90; $i++) {
		if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
			if ($_POST[chr($i)] == true) {
				$ver_todas_letras = false;
			}
		}
	}
	#### INICIA BUCLE TODAS LAS LETRAS
	for ($i = 48; $i <= 90; $i++) {
		if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
			$linea_letra = 1;
			$color = "white";
			$sql = "select id,id_agrupacion from sim_clientes where visible=1 and nombre like '".chr($i)."%'";
			if ($action == 2) { $sql = $sql." and id_agrupacio=".$id;}
			if ($_POST["likenombre"] != "") { $sql = $sql." and (nombre like '%".$_POST["likenombre"]."%' or apellido1 like '%".$_POST["likenombre"]."%' or apellido2 like '%".$_POST["likenombre"]."%')";}
			$sql =$sql." order by nombre,apellido1,apellido2,id_origen";
#			echo $sql."<br>";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				#### MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
				if($_POST["id_tipo"] != ""){
					if ($row["id_agrupacion"] == 0){$ver = true;} else {$ver = false;}
				} else {
					$ver = true;
				}
				#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
				if ($ver_todas_letras == false) {
					if ($_POST[chr($i)] != true) {
						$ver = false;
					}
				}
				#### BUSCA TIPUS
				if (($ver == true) and ($_POST["tipos"] != "")) {
					$sqlcxx = "select count(*) as total from sim_clientes_rel_tipos where id_cliente=".$row["id"]." and id_tipo in (".$_POST["tipos"].")";
					$resultcxx = mysqli_query($dbhandle,convertSQL($sqlcxx));
					$rowcxx = mysqli_fetch_array($resultcxx);
					if ($rowcxx["total"] <= 0) { $ver = false; }

					$sqlcxx2 = "select id from sim_clientes_tipos where id_origen in (".$_POST["tipos"].")";
					$resultcxx2 = mysqli_query($dbhandle,convertSQL($sqlcxx2));
					while ($rowcxx2 = mysqli_fetch_array($resultcxx2)) {
						$sqlcxx3 = "select count(*) as total from sim_clientes_rel_tipos where id_cliente=".$row["id"]." and id_tipo=".$rowcxx2["id"];
						$resultcxx3 = mysqli_query($dbhandle,convertSQL($sqlcxx3));
						$rowcxx3 = mysqli_fetch_array($resultcxx3);
						if ($rowcxx3["total"] > 0) { $ver = true; }

						$sqlcxx4 = "select id from sim_clientes_tipos where id_origen=".$rowcxx2["id"];
						$resultcxx4 = mysqli_query($dbhandle,convertSQL($sqlcxx4));
						while ($rowcxx4 = mysqli_fetch_array($resultcxx4)) {
							$sqlcxx5 = "select count(*) as total  from sim_clientes_rel_tipos where id_cliente=".$row["id"]." and id_tipo=".$rowcxx4["id"];
							$resultcxx5 = mysqli_query($dbhandle,convertSQL($sqlcxx5));
							$rowcxx5 = mysqli_fetch_array($resultcxx5);
							if ($rowcxx5["total"] > 0) { $ver = true; }
						}
					}
				}
				if (($ver == true) and ($_POST["sectores"] != "")) {
					$sqlsec = "select count(*) as total from sim_clientes_rel_sectores where id_cliente=".$row["id"]." and id_sector in (".$_POST["sectores"].")";
					$resultsec = mysqli_query($dbhandle,convertSQL($sqlsec));
					$rowsec = mysqli_fetch_array($resultsec);
					if ($rowsec["total"] <= 0) { $ver = false; }
				}
				if (($ver == true) and ($_POST["origenes"] != "")) {
					$sqlsec = "select count(*) as total from sim_clientes_rel_origen where id_cliente=".$row["id"]." and id_origen in (".$_POST["origenes"].")";
					$resultsec = mysqli_query($dbhandle,convertSQL($sqlsec));
					$rowsec = mysqli_fetch_array($resultsec);
					if ($rowsec["total"] <= 0) { $ver = false; }
				}
				if (($ver == true) and ($_POST["paises"] != "")) {
					$sqlp = "select count(*) as total from sim_clientes_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=1 and id_ubicacion in (".$_POST["paises"].")";
					$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
					$rowp = mysqli_fetch_array($resultp);
					if ($rowp["total"] <= 0) { $ver = false; }
				}
				if (($ver == true) and ($_POST["comunidades"] != "")) {
					$sqlcom = "select count(*) as total from sim_clientes_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=2 and id_ubicacion in (".$_POST["comunidades"].")";
					$resultcom = mysqli_query($dbhandle,convertSQL($sqlcom));
					$rowcom = mysqli_fetch_array($resultcom);
					if ($rowcom["total"] <= 0) { $ver = false; }
				}
				if (($ver == true) and ($_POST["provincias"] != "")) {
					$sqlpro = "select count(*) as total from sim_clientes_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=3 and id_ubicacion in (".$_POST["provincias"].")";
					$resultpro = mysqli_query($dbhandle,convertSQL($sqlpro));
					$rowpro = mysqli_fetch_array($resultpro);
					if ($rowpro["total"] <= 0) { $ver = false; }
				}
				if (($ver == true) and ($_POST["regiones"] != "")) {
					$sqlreg = "select count(*) as total from sim_clientes_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=4 and id_ubicacion in (".$_POST["regiones"].")";
					$resultreg = mysqli_query($dbhandle,convertSQL($sqlreg));
					$rowreg = mysqli_fetch_array($resultreg);
					if ($rowreg["total"] <= 0) { $ver = false; }
				}
				#### INICI IMPRESIO PANTALLA
				if ($ver == true) {
					$pdf->SetFillColor("white");
					$pdf->SetTextColor("black");
					$z++;
					$sqlc = "select * from sim_clientes where id=".$row["id"];
					$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
					$rowc = mysqli_fetch_array($resultc);
					if ($_POST["colorsi"] == true){
						$sqlctt = "select * from sim_clientes_rel_tipos where visible=1 and id_tipo<>0 and id_client=".$row["id"]." and predeterminado=1";
						$resultctt = mysqli_query($dbhandle,convertSQL($sqlctt));
						$rowctt = mysqli_fetch_array($resultctt);
						if ($rowctt) {
							$id_class_tipus = $rowctt["id_tipo"];
						} else {
							$sqlcc = "select * from sim_clientes_rel_tipos where id_client=".$row["id"];
							$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
							$rowcc = mysqli_fetch_array($resultcc);
							$id_class_tipus = $rowcc["id_tipo"];
						}
						if ($id_class_tipus > 0){
							echo $sqlct = "select * from sim_clientes_tipos where id=".$id_class_tipus;
							$resultct = mysqli_query($dbhandle,convertSQL($sqlct));
							$rowct = mysqli_fetch_array($resultct);
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
					$pdf->Cell(0,5,$z." -  ".$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"]." ".$rowc["telefono"],0,1,'L',$pinta);
					$y = $pdf->GetY();
					$x = $pdf->GetX();
					$pdf->SetXY($x+4,$y);
					if ($rowc["direccion"] != ""){
						$pdf->Cell(0,5,$rowc["direccion"]." ".$rowc["poblacion"]." ".$rowc["cp"]." ".$rowc["provincia"]."",0,1,'L',$pinta);
					}
					if ($_POST["completa"] == true){
						$sqlc1 = "select * from sim_clientess_contactos where id_client=".$rowc["id"];
						$resultc1 = mysqli_query($dbhandle,convertSQL($sqlc1));
						while ($rowc1 = mysqli_fetch_array($resultc1)){
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

