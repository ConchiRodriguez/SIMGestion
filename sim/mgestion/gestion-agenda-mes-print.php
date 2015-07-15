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
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convert_sql($sql));
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
		$result = mysql_query(convert_sql($sql));
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
		$resulti = mysql_query(convert_sql($sqli));
		$rowi = mysql_fetch_array($resulti);

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convert_sql($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }


		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowi["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysql_query(convert_sql($sqlpermiso));
		$rowpermiso = mysql_fetch_array($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }

}
if ($autorizado == true) {
	$dia = $_GET["dd"]; $mes = $_GET["mm"]; $any = $_GET["aa"];
	$x=0;
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
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
			if (fwrite($file,$row["contenido"]) === FALSE) {
				mensaje_error("No se puede escribir al archivo (".$nombre_archivo.")");
				exit;
			}
			fclose($file);
	} else {
		mensaje_error("No se puede escribir al archivo (".$nombre_archivo.")");
	}

	define("FPDF_FONTPATH","C:/Archivos de programa/EasyPHP1-8/www/demo/font/");
	require('fpdf.php');

	//Creación del objeto de la clase heredada
require_once("pdfUSACalendar.php");

class MyCalendar extends PDF_USA_Calendar
{
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
function printDay($date)
{
	$sqla = "select * from sgm_agendas_users where visible=1 and id_user=".$_GET["usuario"];
	$resulta = mysql_query(convert_sql($sqla));
	while ($rowa = mysql_fetch_array($resulta)) {
		if ($x != 0){ $agenda .= ",";}
		$agenda .= $rowa["id_agenda"];
		$x++;
	}
	$incidencia="";
	// add logic here to customize a day
	$this->JDtoYMD($date,$year,$month,$day);
	$horainici = '00:00:00';
	$hoy1 = $year."-".$month."-".$day." ".$horainici;
	$horafin = '23:59:59';
	$hoy2 = $year."-".$month."-".$day." ".$horafin;
	$sql = "select * from sgm_incidencias where data_prevision>'".$hoy1."' and data_prevision< '".$hoy2."' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
		$hora = date("H", strtotime($row["data_prevision"])); 
		$minut = date("i", strtotime($row["data_prevision"]));
		$incidencia .= $hora.":".$minut." ".$row["asunto"]."\n              ";
	}

	$this->SetFillColor(192,192,192);
	$this->SetFont("Times", "", 7);
	$wd = gmdate("w",jdtounix($date));
	if (($wd == 0) or ($wd == 6)){
		$this->MultiCell($this->squareWidth, $this->squareHeight, $incidencia, 0, "", true);
	}
	$this->MultiCell($this->squareWidth, 7, "              ".$incidencia, 0, "", false);
	$this->SetFont("Times", "B", 20);
}

} // class MyCalendar extends PDF_USA_Calendar

// MyCalendar shows how to customize your calendar with Easter, some select Jewish holidays and a birthday
// Supports any size paper FPDF does
$pdf = new MyCalendar("L", "Letter");
// you can set margins and line width here. PDF_USA_Calendar uses the current settings.
	$pdf->AliasNbPages();
$pdf->SetMargins(7,7);
$pdf->SetAutoPageBreak(false, 0);
// set fill color for non-weekend holidays
$greyValue = 190;
$pdf->SetFillColor($greyValue,$greyValue,$greyValue);
// print the calendar for a whole year
	$date = $pdf->MDYtoJD($mes, 1, $any);
	$pdf->printMonth($date);
	$pdf->Output("../pdf/mes.pdf");
	if (!unlink('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg')){
		echo "no se pudo borrar la imagen";
	}
	header("Location: ".$urloriginal."/pdf/mes.pdf");
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>
