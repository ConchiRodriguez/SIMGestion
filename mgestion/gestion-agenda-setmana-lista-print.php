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
	$sqla = "select * from sgm_agendas_users where visible=1 and id_user=".$_GET["usuario"];
	$resulta = mysql_query(convert_sql($sqla));
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

	class PDF extends FPDF
	{
		//Pie de p�gina
		function Footer()
		{
			//Posici�n: a 1,5 cm del final
			$this->SetY(-10);
			//times italic 8
			$this->SetFont('times','I',8);
			//N�mero de p�gina
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
			//Logo
			$this->Image('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg',160,285,40);
		}
		function dia_setmana($d,$a,$m,$clau)
		{
			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) {$diasemana = 7;}
				$lu = date("d-m-Y", mktime(0,0,0,$m ,$d+1-$diasemana, $a));
				$ma = date("d-m-Y", mktime(0,0,0,$m ,$d+2-$diasemana, $a));
				$mi = date("d-m-Y", mktime(0,0,0,$m ,$d+3-$diasemana, $a));
				$ju = date("d-m-Y", mktime(0,0,0,$m ,$d+4-$diasemana, $a));
				$vi = date("d-m-Y", mktime(0,0,0,$m ,$d+5-$diasemana, $a));
				$sa = date("d-m-Y", mktime(0,0,0,$m ,$d+6-$diasemana, $a));
				$do = date("d-m-Y", mktime(0,0,0,$m ,$d+7-$diasemana, $a));
			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) {$diasemana = 7;}
				$lu2 = date("Y-m-d", mktime(0,0,0,$m ,$d+1-$diasemana, $a));
				$ma2 = date("Y-m-d", mktime(0,0,0,$m ,$d+2-$diasemana, $a));
				$mi2 = date("Y-m-d", mktime(0,0,0,$m ,$d+3-$diasemana, $a));
				$ju2 = date("Y-m-d", mktime(0,0,0,$m ,$d+4-$diasemana, $a));
				$vi2 = date("Y-m-d", mktime(0,0,0,$m ,$d+5-$diasemana, $a));
				$sa2 = date("Y-m-d", mktime(0,0,0,$m ,$d+6-$diasemana, $a));
				$do2 = date("Y-m-d", mktime(0,0,0,$m ,$d+7-$diasemana, $a));
			if ($clau == 1) {return $lu;}
			if ($clau == 11) {return $lu2;}
			if ($clau == 2) {return $ma;}
			if ($clau == 22) {return $ma2;}
			if ($clau == 3) {return $mi;}
			if ($clau == 33) {return $mi2;}
			if ($clau == 4) {return $ju;}
			if ($clau == 44) {return $ju2;}
			if ($clau == 5) {return $vi;}
			if ($clau == 55) {return $vi2;}
			if ($clau == 6) {return $sa;}
			if ($clau == 66) {return $sa2;}
			if ($clau == 7) {return $do;}
			if ($clau == 77) {return $do2;}
		}
	}

	//Creaci�n del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('times','B',10);
	$lunes=$pdf->dia_setmana($dia,$any,$mes,1);
	$pdf->Cell(90,5,$lunes);
	$pdf->Cell(40,5,"Semana de ".$rowsgm["usuario"],0,1);

	$domingo=$pdf->dia_setmana($dia,$any,$mes,7);
	$pdf->Cell(90,5,$domingo);
	$date = getdate(); 
	if ($date["mon"] < 10 ) { $date["mon"] = "0".$date["mon"]; }
	if ($date["mday"] < 10 ) { $date["mday"] = "0".$date["mday"]; }
	$fecha = $date["mday"]."-".$date["mon"]."-".$date["year"];
	$pdf->Cell(40,5,"Impreso el ".$fecha,0,1);


	$lunes1=$pdf->dia_setmana($dia,$any,$mes,11);
	$martes=$pdf->dia_setmana($dia,$any,$mes,2);
	$martes1=$pdf->dia_setmana($dia,$any,$mes,22);
	$miercoles=$pdf->dia_setmana($dia,$any,$mes,3);
	$miercoles1=$pdf->dia_setmana($dia,$any,$mes,33);
	$jueves=$pdf->dia_setmana($dia,$any,$mes,4);
	$jueves1=$pdf->dia_setmana($dia,$any,$mes,44);
	$viernes=$pdf->dia_setmana($dia,$any,$mes,5);
	$viernes1=$pdf->dia_setmana($dia,$any,$mes,55);
	$sabado=$pdf->dia_setmana($dia,$any,$mes,6);
	$sabado1=$pdf->dia_setmana($dia,$any,$mes,66);
	$domingo1=$pdf->dia_setmana($dia,$any,$mes,77);
	$pdf->SetFillColor(192,192,192);
	$pdf->SetXY(10,30);
	$pdf->Cell(180,7,$lunes,0,1,'',true);
	$sqltotal = "select * from sgm_incidencias where data_prevision>'".$lunes1." 00:00:00' and data_prevision<'".$lunes1." 23:59:59' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
	$resulttotal = mysql_query(convert_sql($sqltotal));
	while ($rowtotal = mysql_fetch_array($resulttotal)) {
		$hora = date("H", strtotime($rowtotal["data_prevision"])); 
		$minut = date("i", strtotime($rowtotal["data_prevision"]));
		$pdf->Cell(10,5,$hora.":".$minut,0,0,'',false);
		$pdf->Cell(70,5,$rowtotal["asunto"],0,1,'',false);
	}
	$pdf->SetXY(10,80);
	$pdf->Cell(180,7,$martes,0,1,'',true);
	$sqltotal = "select * from sgm_incidencias where data_prevision>'".$martes1." 00:00:00' and data_prevision<'".$martes1." 23:59:59' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
	$resulttotal = mysql_query(convert_sql($sqltotal));
	while ($rowtotal = mysql_fetch_array($resulttotal)) {
		$hora = date("H", strtotime($rowtotal["data_prevision"])); 
		$minut = date("i", strtotime($rowtotal["data_prevision"]));
		$pdf->Cell(10,5,$hora.":".$minut,0,0,'',false);
		$pdf->Cell(70,5,$rowtotal["asunto"],0,1,'',false);
	}
	$pdf->SetXY(10,120);
	$pdf->Cell(180,7,$miercoles,0,1,'',true);
	$sqltotal = "select * from sgm_incidencias where data_prevision>'".$miercoles1." 00:00:00' and data_prevision<'".$miercoles1." 23:59:59' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
	$resulttotal = mysql_query(convert_sql($sqltotal));
	while ($rowtotal = mysql_fetch_array($resulttotal)) {
		$hora = date("H", strtotime($rowtotal["data_prevision"])); 
		$minut = date("i", strtotime($rowtotal["data_prevision"]));
		$pdf->Cell(10,5,$hora.":".$minut,0,0,'',false);
		$pdf->Cell(70,5,$rowtotal["asunto"],0,1,'',false);
	}

	$pdf->SetXY(10,170);
	$pdf->Cell(180,7,$jueves,0,1,'',true);
	$sqltotal = "select * from sgm_incidencias where data_prevision>'".$jueves1." 00:00:00' and data_prevision<'".$jueves1." 23:59:59' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
	$resulttotal = mysql_query(convert_sql($sqltotal));
	while ($rowtotal = mysql_fetch_array($resulttotal)) {
		$hora = date("H", strtotime($rowtotal["data_prevision"])); 
		$minut = date("i", strtotime($rowtotal["data_prevision"]));
		$pdf->Cell(10,5,$hora.":".$minut,0,0,'',false);
		$pdf->Cell(70,5,$rowtotal["asunto"],0,1,'',false);
	}
	$pdf->SetXY(10,220);
	$pdf->Cell(180,7,$viernes,0,1,'',true);
	$sqltotal = "select * from sgm_incidencias where data_prevision>'".$viernes1." 00:00:00' and data_prevision<'".$viernes1." 23:59:59' and visible=1 and tiempo > 0 and id_agenda in (".$agenda.") and privada=1 order by data_prevision";
	$resulttotal = mysql_query(convert_sql($sqltotal));
	while ($rowtotal = mysql_fetch_array($resulttotal)) {
		$hora = date("H", strtotime($rowtotal["data_prevision"])); 
		$minut = date("i", strtotime($rowtotal["data_prevision"]));
		$pdf->Cell(10,5,$hora.":".$minut,0,0,'',false);
		$pdf->Cell(70,5,$rowtotal["asunto"],0,1,'',false);
	}
	$pdf->Output("../pdf/semana_lista.pdf");
	if (!unlink('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg')){
		echo "no se pudo borrar la imagen";
	}
	header("Location: ".$urloriginal."/pdf/semana_lista.pdf");
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>
