<?php 
error_reporting(~E_ALL);

	include ("../config.php");
	include ("../auxiliar/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}
if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			if ($row["pass"] == $_POST["pass"]) {
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, "/");
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
				header("Location: ".$urloriginal."/index.php?op=200");
			}
		}
	}
}
else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["pass"] == $_COOKIE["mpassword"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, "/");
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
		}
	}
}

$autorizado = false;
if ($user == true) {

		$sqli = "select * from sgm_incidencias where id=".$_GET["id"];
		$resulti = mysql_query(convertSQL($sqli));
		$rowi = mysql_fetch_array($resulti);

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convertSQL($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }


		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowi["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysql_query(convertSQL($sqlpermiso));
		$rowpermiso = mysql_fetch_array($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }

}
if ($autorizado == true) {
	$dia = $_GET["dd"]; $mes = $_GET["mm"]; $any = $_GET["aa"];
	$x=0;
	$sqla = "select * from sgm_agendas_users where visible=1 and id_user=".$_GET["usuario"];
	$resulta = mysql_query(convertSQL($sqla));
	while ($rowa = mysql_fetch_array($resulta)) {
		if ($x != 0){ $agenda .= ",";}
		$agenda .= $rowa["id_agenda"];
		$x++;
	}
	if ($mes == 1) { $mesesp = "Enero"; }
	if ($mes == 2) { $mesesp = "Febrero"; }
	if ($mes == 3) { $mesesp = "Marzo"; }
	if ($mes == 4) { $mesesp = "Abril"; }
	if ($mes == 5) { $mesesp = "Mayo"; }
	if ($mes == 6) { $mesesp = "Junio"; }
	if ($mes == 7) { $mesesp = "Julio"; }
	if ($mes == 8) { $mesesp = "Agosto"; }
	if ($mes == 9) { $mesesp = "Septiembre"; }
	if ($mes == 10) { $mesesp = "Octubre"; }
	if ($mes == 11) { $mesesp = "Noviembre"; }
	if ($mes == 12) { $mesesp = "Diciembre"; }

	$nombre_archivo = 'C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg';
	$file=fopen($nombre_archivo,'w+');
	if (is_writable($nombre_archivo)) {
		$sql = "select * from sgm_logos where clase=4";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
			if (fwrite($file,$row["contenido"]) === FALSE) {
				mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
				exit;
			}
			fclose($file);
	} else {
		mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
	}

	define("FPDF_FONTPATH","C:/Archivos de programa/EasyPHP1-8/www/demo/font/");
	require('fpdf.php');

	class PDF extends FPDF
	{
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-10);
			//times italic 8
			$this->SetFont('times','I',8);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
			//Logo
			$this->Image('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg',160,285,40);
		}
		function totaldiasdelmes($mes){
			$totaldiasmes = 31;
			if ($mes == 2) { if (checkdate(2, 29, $a)) { $totaldiasmes = 29; } else { $totaldiasmes = 28; }
			}
			if ($mes == 4) { $totaldiasmes--; }
			if ($mes == 6) { $totaldiasmes--;}
			if ($mes == 9) { $totaldiasmes--; }
			if ($mes == 11) { $totaldiasmes--; }
			return $totaldiasmes;
		}
	}

	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('times','B',10);
	$pdf->Cell(90,5,$mesesp);
	$pdf->Cell(40,5,"Mes de ".$rowsgm["usuario"],0,1);
	$date = getdate(); 
	if ($date["mon"] < 10 ) { $date["mon"] = "0".$date["mon"]; }
	if ($date["mday"] < 10 ) { $date["mday"] = "0".$date["mday"]; }
	$fecha = $date["mday"]."-".$date["mon"]."-".$date["year"];
	$pdf->Cell(40,5,"Impreso el ".$fecha,0,1);

	$pdf->SetFillColor(192,192,192);
	$dtotal = $pdf->totaldiasdelmes($mes);

	for ($d = 1; $d <= $dtotal; $d++) {
		$dia =	$d."-".$mes."-".$any;
		$pdf->Cell(180,7,$dia,0,1,'',true);
		$data = $any."-".$mes."-".$d;
		$hoy1= $data." 00:00:00";
		$hoy2= $data." 23:59:59";
		$sqlto = "select count(*) as total from sgm_incidencias where data_prevision>'".$hoy1."' and data_prevision<'".$hoy2."' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1";
		$resultto = mysql_query(convertSQL($sqlto));
		$rowto = mysql_fetch_array($resultto);
		if ($rowto["total"] > 0){
			$sqltotal = "select * from sgm_incidencias where data_prevision>'".$hoy1."' and data_prevision<'".$hoy2."' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
			$resulttotal = mysql_query(convertSQL($sqltotal));
			while ($rowtotal = mysql_fetch_array($resulttotal)){
				$hora = date("H", strtotime($rowtotal["data_prevision"])); 
				$minut = date("i", strtotime($rowtotal["data_prevision"]));
				$pdf->Cell(10,5,$hora.":".$minut,0,0,'',false);
				$pdf->Cell(70,5,$rowtotal["asunto"],0,1,'',false);
			}
			if ($rowto["total"] == 3){$pdf->Cell(180,10,"",0,1,false);}
			if ($rowto["total"] == 2){$pdf->Cell(180,20,"",0,1,false);}
			if ($rowto["total"] == 1){$pdf->Cell(180,30,"",0,1,false);}
		} else {
			$pdf->Cell(180,40,"",0,1,false);
		}
	}
	$pdf->Output("../pdf/mes_lista.pdf");
	if (!unlink('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg')){
		echo "no se pudo borrar la imagen";
	}
	header("Location: ".$urloriginal."/pdf/mes_lista.pdf");

} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>
