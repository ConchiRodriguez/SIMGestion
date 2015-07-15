<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}

if ($_COOKIE["username"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["pass"] == $_POST["pass"]) {
				setcookie("username", $_POST["user"], time()+86400*$cookiestime, "/", $domain);
				setcookie("password", md5( $row["pass"] ), time()+86400*$cookiestime, "/", $domain);
				header("Location: ".$urloriginal."/index.php?op=200");
			}
		}
	}
}
else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ( md5( $row["pass"] ) == $_COOKIE["password"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
		}
	}
}

$autorizado = true;
if ($user == true) {
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultcabezera = mysql_query(convert_sql($sqlcabezera));
		$rowcabezera = mysql_fetch_array($resultcabezera);

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convert_sql($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }

		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysql_query(convert_sql($sqlpermiso));
		$rowpermiso = mysql_fetch_array($resultpermiso);
		if ($rowpermiso["total"] >= 1) { $autorizado = true; }

}


if ($autorizado == true) {
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
			$this->Image('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg',160,285,40);
		}
	}

	//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();
	$pdf->SetFont('times','B',15);
	$x=10;
	$sqlc = "select * from sgm_clients where id=".$_GET["id"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	$pdf->Cell(0,5,$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"],'LTR',1);
	$x +=5;
	$pdf->SetFont('times','',9);
	$pdf->Cell(0,5,$rowc["nif"],'LR',1);
	$x +=5;
	if ($rowc["cp"] != "") {$direccion=$rowc["direccion"]." (".$rowc["cp"].")";} else {$direccion=$rowc["direccion"];}
	$pdf->Cell(0,5,$direccion,'LR',1);
	$x +=5;
	if ($rowc["provincia"] != "") {$poblacion=$rowc["poblacion"]." (".$rowc["provincia"].")";} else {$poblacion=$rowc["poblacion"];}
	$pdf->Cell(0,5,$poblacion,'LR',1);
	$x +=5;
	if ($rowc["telefono"] != "") {$pdf->Cell(0,5,$rowc["telefono"],'LR',1);	$x +=5;}
	if ($rowc["mail"] != "") {$pdf->Cell(0,5,$rowc["mail"],'LR',1);	$x +=5;}
	if ($rowc["web"] != "") {$pdf->Cell(0,5,$rowc["web"],'LR',1);	$x +=5;}
	$pdf->Line(10,$x,200,$x);

	$sqlft = "select * from sgm_ft where id=".$_GET["id_ft"];
	$resultft = mysql_query(convert_sql($sqlft));
	$rowft = mysql_fetch_array($resultft);
	$sqlftp = "select * from sgm_ft_plantilla where id=".$rowft["id_plantilla"];
	$resultftp = mysql_query(convert_sql($sqlftp));
	$rowftp = mysql_fetch_array($resultftp);

	if ($rowft["id_incidencia"] != 0){
		$sqli = "select * from sgm_incidencias where id=".$rowft["id_incidencia"];
		$resulti = mysql_query(convert_sql($sqli));
		$rowi = mysql_fetch_array($resulti);
		$sqlu = "select * from sgm_users where id=".$rowi["id_usuario"];
		$resultu = mysql_query(convert_sql($sqlu));
		$rowu = mysql_fetch_array($resultu);
		$sqlud = "select * from sgm_users where id=".$rowi["id_usuario_destino"];
		$resultud = mysql_query(convert_sql($sqlud));
		$rowud = mysql_fetch_array($resultud);
		$pdf->SetFont('times','B',11);
		$pdf->Cell(0,5,"Id. Incidencia : ".$rowi["id"]."",0,1);
		$pdf->Cell(0,5,"Usuario Registro:".$rowu["usuario"]."",0,1);
		$pdf->Cell(0,5,"Usuario Destino :".$rowud["usuario"]."",0,1);
		$pdf->Cell(0,5,"Asunto :".$rowi["asunto"]."",0,1);
		$pdf->Cell(0,5,"Fecha Prevision :".$rowi["data_prevision"]."",0,1);
	}

	$sqltp = "select * from sgm_tamany_paper where id=".$rowftp["id_tamany_paper"];
	$resulttp = mysql_query(convert_sql($sqltp));
	$rowtp = mysql_fetch_array($resulttp);

	$y = $x;
	$sqlftpt = "select * from sgm_ft_plantilla_tipus where id_ft=".$rowftp["id"]." and visible=1 and visualizar=1";
	$resultftpt = mysql_query(convert_sql($sqlftpt));
	while ($rowftpt = mysql_fetch_array($resultftpt)){
		$x_pos = $rowftpt["x_posicion"];
		$y_posicion = ($rowftpt["y_posicion"] - ($rowtp["y"]*$page));
		if ($y_posicion < $rowtp["y"]){
			$y_pos = $y_posicion;
		} else {
			$y_pos = ($y_posicion - $rowtp["y"]);
			$pdf->AddPage();
			$page += 1;
		}

		$pdf->SetXY($x_pos,$y_pos+$y);
		$pdf->Cell(20,5,$rowftpt["tipus"]);
		$y += 5;

		if ($rowftpt["descripcion"] != ""){
			$pdf->SetXY($x_pos,$y_pos+$y);
			$pdf->Cell(20,5,"(".$rowftpt["descripcion"].")");
			$y += 5;
		}
		$pdf->SetXY($x_pos,$y_pos+$y);

		$sqlftd = "select * from sgm_ft_dades where id_ft=".$_GET["id_ft"]." and id_plantilla_tipus=".$rowftpt["id"]."";
		$resultftd = mysql_query(convert_sql($sqlftd));
		$rowftd = mysql_fetch_array($resultftd);
		if ($rowftpt["taula"] == 0){
			$campo = $rowftd["descripcion"];
			$pdf->MultiCell($rowftpt["x_ancho"],5,$campo,1);
		} else {
			if ($rowftd["id_plantilla_tipus_campo"] > 0){
				if ($rowftpt["obligatorio"] == 1){
					$sqlcl = $rowftpt["sgm_sql"];
					$resultcl = mysql_query(convert_sql($sqlcl));
					while ($rowcl = mysql_fetch_array($resultcl)){
						if ($rowcl["id"] == $rowftd["id_plantilla_tipus_campo"]) {$campo = $rowcl[$rowftpt["sgm_campo_visualizado"]];}
					}
				} else {
					$sqlcl = "select * from sgm_ft_plantilla_tipus_campos where id_ft_plantilla_tipus=".$rowftpt["id"]." and visible=1";
					$resultcl = mysql_query(convert_sql($sqlcl));
					while ($rowcl = mysql_fetch_array($resultcl)){
						if ($rowcl["id"] == $rowftd["id_plantilla_tipus_campo"]) {$campo = $rowcl["campos"];}
					}
				}
			} else {
				$campo = "";
			}
			$pdf->Cell(20,5,$campo,1);
		}
	}
	$pdf->Output("../pdf/plantilla.pdf");
	if (!unlink('C:\\Archivos de programa\\EasyPHP1-8\\www\\demo\\temporal\\logo.jpeg')){
		echo "no se pudo borrar la imagen";
	}
	header("Location: ".$urloriginal."/pdf/plantilla.pdf");
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>
