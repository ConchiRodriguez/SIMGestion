<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");

### CONEXIO PLATAFORMA
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
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
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
} else { 
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

?>
<html>
<head>
		<link rel="stylesheet" href="style.css" type="text/css">
<STYLE>
<?php 
if 	(ereg("MSIE", $_SERVER['HTTP_USER_AGENT'])) {
		echo ".saltopagina {";
		echo "PAGE-BREAK-AFTER: always;";
		echo "height:0px; line-height:0px;";
		echo "}";
} else {
		echo ".saltopagina {";
		echo "PAGE-BREAK-AFTER: always;";
		echo "}";
}
?>
</STYLE>
</head>
<body>

<?php

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

	if ($_POST["data_desde"] == ""){
		echo factura_print($_GET["id"]);
	} else {
		$sql = "select * from sgm_cabezera where tipo=".$_POST["id_tipo"]." and fecha_prevision between '".cambiarFormatoFechaYMD($_POST["data_desde"])."' and '".cambiarFormatoFechaYMD($_POST["data_fins"])."' and visible=1";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			echo factura_print($row["id"]);
			echo "<br class=\"saltopagina\" />";
		}
	}
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}


function factura_print($id)
{
		$idioma = strtolower($_POST["idioma"]);
		include ("../../archivos_comunes/factura-print-".$idioma.".php");

		$sqlcabezera = "select * from sgm_cabezera where id=".$id;
		$resultcabezera = mysql_query(convert_sql($sqlcabezera));
		$rowcabezera = mysql_fetch_array($resultcabezera);

		$sqlx = "select * from sgm_factura_tipos where id=".$rowcabezera["tipo"];
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);

		if ($idioma == "es"){
			$tipo = $rowx["tipo"];
		} else {
			$sqli = "select * from sgm_factura_tipos_idiomas where id_tipo=".$rowx["id"];
			$resulti = mysql_query(convert_sql($sqli));
			$rowi = mysql_fetch_array($resulti);
			$tipo = $rowi["".$idioma.""];
		}

		echo "<table cellpadding=\"0px\" cellspacing=\"5px\" style=\"width:650px;border:0px solid black\"><tr><td><center>";

		if ($_POST["tipo"] == 1) {
				echo "<table cellpadding=\"0px\" cellspacing=\"0px\" style=\"width:650px;border:0px solid black\">";
					echo "<tr>";
						echo "<td style=\"vertical_align:middle;text_align:center;\">";
							$sqlele = "select * from sgm_dades_origen_factura";
							$resultele = mysql_query(convert_sql($sqlele));
							$rowele = mysql_fetch_array($resultele);
							echo "<center><img src=\"../files/logos/".$rowele["logo1"]."\"></center>";
						echo "</td>";
					echo "</tr>";
				echo "</table><br>";
				echo "<table cellpadding=\"0px\" cellspacing=\"0px\" style=\"width:650px;border : 1px solid black;\">";
					echo "<tr>";
						echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:center;border-bottom:1px solid black;background-color:#C0C0C0\" ><strong>".$titulo1."</strong></td>";
					echo "</tr><tr>";
						echo "<td>";
						echo "<table cellspacing=\"0\" style=\"border: 0px; width:650px;\"><tr>";
								echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;width:325px;\" >".$numero." : <strong>".$rowcabezera["numero"]." / ".$rowcabezera["version"]."</strong></td>";
								echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >".$numero_rfq." : <strong>".$rowcabezera["numero_rfq"]."</strong></td>";
							echo "</tr><tr>";
								echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;\" >".$fecha." : <strong>".cambiarFormatoFechaDMY($rowcabezera["fecha"])."</strong></td>";
								echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >".$fecha_entrega." : <strong>".cambiarFormatoFechaDMY($rowcabezera["fecha_entrega"])."</strong></td>";
							echo "</tr><tr>";
								echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;\" >".$fecha_vencimiento." : <strong>".cambiarFormatoFechaDMY($rowcabezera["fecha_vencimiento"])."</strong></td>";
								echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >".$cuenta_corriente." : <strong>".$rowcabezera["cuenta"]."</strong></td>";
							echo "</tr></table>";
						echo "</td>";
					echo "</tr><tr>";
						echo "<td>";
							echo "<table cellspacing=\"0\" style=\"border: 0px; width:650px;\">";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;width:325px;\" >".$nombre." : <strong>".$rowcabezera["nombre"]."</strong></td>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >".$nif." : <strong>".$rowcabezera["nif"]."</strong></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;\" >".$direccion." : <strong>".$rowcabezera["direccion"]."</strong></td>";
									echo "<td>";
										echo "<table cellspacing=\"0\" style=\"border: 0px;width:100%\"><tr>";
											echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;\" >".$poblacion." : <strong>".$rowcabezera["poblacion"]."</strong></td>";
												echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >".$cp." : <strong>".$rowcabezera["cp"]."</strong></td>";
										echo "</tr></table>";
									echo "</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-right:1px solid black;\" >".$provincia." : <strong>".$rowcabezera["provincia"]."</strong></td>";
									$sqlp = "select * from sys_naciones where CodigoNacion=".$rowcabezera["id_pais"];
									$resultp = mysql_query(convert_sql($sqlp));
									$rowp = mysql_fetch_array($resultp);
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;\" >".$Nacion." : <strong>".$rowp["Nacion"]."</strong></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-top:1px solid black;border-right:1px solid black;width:325px;\" >".$cnombre." : <strong>".$rowcabezera["cnombre"]."</strong></td>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-top:1px solid black;\" >".$cmail." : <strong>".$rowcabezera["cmail"]."</strong></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
				echo "</tr>";
				echo "</table><br>";
				echo "<table cellpadding=\"0px\" cellspacing=\"0px\" style=\"width:650px;border : 1px solid black;\">";
					echo "<tr>";
						echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:center;border-bottom:1px solid black;background-color:#C0C0C0\" ><strong>".$titulo2."</strong></td>";
					echo "</tr><tr>";
						echo "<td>";
							echo "<table cellspacing=\"0\" style=\"border: 0px; width:650px;\">";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;width:325px;\" >".$nombre." : <strong>".$rowcabezera["enombre"]."</strong></td>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >&nbsp;</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;\" >".$direccion." : <strong>".$rowcabezera["edireccion"]."</strong></td>";
									echo "<td>";
										echo "<table cellspacing=\"0\" style=\"border: 0px;width:100%\"><tr>";
											echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;\" >".$poblacion." : <strong>".$rowcabezera["epoblacion"]."</strong></td>";
											echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-bottom:1px solid black;\" >".$cp." : <strong>".$rowcabezera["ecp"]."</strong></td>";
										echo "</tr></table>";
									echo "</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;border-right:1px solid black;\" >".$provincia." : <strong>".$rowcabezera["eprovincia"]."</strong></td>";
									echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:left;\" >".$Nacion." : <strong>".$rowp["Nacion"]."</strong></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "<table style=\"width:650px;border: 0px solid black\"><tr><td><center><strong style=\"font-size : 20px;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;\">".$tipo."</strong></center></td></tr></table>";
			echo "</center></td></tr><tr><td height=\"500px\"><center>";
		} 

		if ($_POST["tipo"] == 0) {
			echo "<table cellpadding=\"0px\" cellspacing=\"0px\" width=\"100%\" style=\"height:300px;border : 1px solid black;\"><tr>";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 9px;width:250px;vertical-align : top;padding : 5px 5px 5px 5px;margin : 5px 5px 5px 5px;\">";
						$sqlele = "select * from sgm_dades_origen_factura";
						$resultele = mysql_query(convert_sql($sqlele));
						$rowele = mysql_fetch_array($resultele);
#						echo "<img src=\"../files/logos/".$rowele["logo1"]."\">";
						echo "<center><img src=\"../files/logos/".$rowele["logo2"]."\"></center>";
				echo "<br><br><strong style=\"font-size : 12px;\">".$rowele["nombre"]."</strong>";
				echo "<br>".$rowele["nif"]."";
				echo "<br>".$rowele["direccion"]."";
				echo "<br>".$rowele["poblacion"]." (".$rowele["cp"].") ".$rowele["provincia"]."";
				echo "<br>".$telefono." : ".$rowele["telefono"];
				echo "<br>".$e_mail." : ".$rowele["mail"];
				echo "<br>";
				echo "<br><hr size=\"1\" color=\black\">";
				echo "<br>";
				echo "<br>";
				echo "<font style=\"font-size : 12px;\">";
				if ($rowcabezera["numero_cliente"] != "") { 
					echo "<br><strong>Referencia pedido </strong>  : ".$rowcabezera["numero_cliente"]."";
				}
				if ($rowcabezera["numero_rfq"] != "") { 
					echo "<br><strong>RFQ </strong>  : ".$rowcabezera["numero_rfq"]."";
				}
				if ($rowcabezera["fecha_vencimiento"] != "0000-00-00") {
					echo "<br><strong>Fecha Vencimiento </strong>  : ".cambiarFormatoFechaDMY($rowcabezera["fecha_vencimiento"])."";
				}
				echo "</font>";
			echo "</td>";
			echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;width:400px;border-left : 1px solid Black;padding : 5px 5px 5px 5px;margin : 5px 5px 5px 5px;\" >";
				echo "<strong>".$tipo."</strong>";
				echo ": ".$rowcabezera["numero"]." / ".$rowcabezera["version"]."";
				echo "<br><strong>".$fecha."</strong>  : ".cambiarFormatoFechaDMY($rowcabezera["fecha"])."";
					echo "<br><strong>".$nombre."</strong> : ".$rowcabezera["nombre"]."";
					echo "<br><strong>".$nif."</strong> : ".$rowcabezera["nif"]."";
					echo "<br><strong>".$direccion."</strong> : ".$rowcabezera["direccion"]."";
					echo "<br><strong>".$poblacion."/".$cp."</strong> : ".$rowcabezera["poblacion"]." (".$rowcabezera["cp"].") ".$rowcabezera["provincia"]."";
					echo "<br><br><br>";
					echo "<font style=\"font-family:C39HrP24DlTt;font-size:40px;\">";
	##codigo barras##
						echo "&nbsp;&nbsp;".$rowcabezera["numero"]."";
					echo "</font><br><br>";

					echo "<center style=\"font-size:13px\">".$titulo2." : ";
					echo "<br><strong>".$rowcabezera["nombre"]."</strong>";
					echo "<br><strong>".$rowcabezera["edireccion"]."</strong>";
					echo "<br><strong>".$rowcabezera["epoblacion"]."</strong> (".$rowcabezera["ecp"].") <strong>".$rowcabezera["eprovincia"]."</strong>";
					echo "</center>";
				echo "</td>";
			echo "</tr></table>";	

		echo "<table width=\"650px;><tr><td style=\"border: 0px solid black\"\"><center><strong style=\"font-size : 20px;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;\">".$tipo."</strong></center></td></tr></table>";


	echo "</center></td></tr><tr><td height=\"440px\" style=\"border:0px solid black\"><center>";
	}


	echo "<table  style=\"border:1px solid black;height:440px\">";
		echo "<tr style=\";\"><td></td><td style=\"width:50px;height:20px;\" ><em>".$fecha."</em></td><td width=\"100px\" style=\"text-align:right;\"><em>".$codigo."&nbsp;&nbsp;</em></td><td width=\"460px\"><em>".$nombre."</em></td><td width=\"40px\" style=\"text-align:right;\"><em>".$unitats."</em></td><td width=\"100px\" style=\"text-align:right;\"><em>".$precio."</em></td><td width=\"100px\" style=\"text-align:right;\"><em>".$total."</em></td></tr>";
		$x=20;
		$sql = "select * from sgm_cuerpo where idfactura=".$id." order by linea";
		$result = mysql_query(convert_sql($sql));
		$unidades = 0;
		while ($row = mysql_fetch_array($result)) {
			echo "<tr style=\"height:20px;border:1px solid black;\">";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\"><strong>".$row["linea"]."</strong></td>";
				$a = date("Y", strtotime($row["fecha_prevision"])); 
				$m = date("m", strtotime($row["fecha_prevision"])); 
				$d = date("d", strtotime($row["fecha_prevision"])); 
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:center\">".$d."/".$m."/".$a."</td>";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:right;\">".$row["codigo"]."&nbsp;&nbsp;</td>";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\">".$row["nombre"]."</td>";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:right;\">".number_format($row["unidades"], 2, ',', '.')."</td>";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:right;\">".number_format($row["pvp"], 2, ',', '.')." €</td>";
				echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:right;\">".number_format($row["total"], 2, ',', '.')." €</td>";
			echo "</tr>";
			$unidades = $unidades + $row["unidades"];
			$x = $x + 20;
		}
		$x = 400 - $x;
		echo "<tr style=\"height:".$x."\"><td>&nbsp;</td></tr>";
		echo "</table>";

	echo "</center></td></tr>";
	
	echo "<tr><td  style=\"border: 0px;\">";
		echo "<table style=\"border: 0px;\">";
			echo "<tr>";
				echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">".$unitats."<br><strong>".number_format($unidades, 2, ',', '.')."</strong></td>";
				echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">".$importe."<br><strong>".number_format($rowcabezera["subtotal"], 2, ',', '.')." €</strong></td>";
				if ($rowcabezera["descuento"] <> 0) {
					echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">".$descuento." (".$rowcabezera["descuento"]."%)<br><strong>".number_format($rowcabezera["subtotaldescuento"], 2, ',', '.')." €</strong></td>";
				} else {
					echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">&nbsp;</td>";
				}
				$iva = number_format((($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["iva"]), 2, ',', '.');
				echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">".$IVA." (".$rowcabezera["iva"]."%)<br><strong>".$iva." €</strong></td>";
				if ($idioma == 'uk'){
					echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">".$total." ".$importe."<br><strong>".number_format($rowcabezera["total"], 2, ',', '.')." €</strong></td>";
				} else {
					echo "<td style=\"width:125px;border: 1px solid black;text-align:center;\">".$importe." ".$total."<br><strong>".number_format($rowcabezera["total"], 2, ',', '.')." €</strong></td>";
				}
			echo "</tr>";
		echo "</table>";
	echo "</td></tr>";
	
	
	echo "<tr><td class=\"inverse\" width=\"100%\" style=\"background-color:#C0C0C0;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:justify;border: 1px solid black\">";
		$texto = str_replace(chr(13),"<br>", $rowcabezera["notas"]);
		$sqlxb = "select * from sgm_clients where nombre='".$rowcabezera["nombre"]."'";
		$resultxb = mysql_query(convert_sql($sqlxb));
		$rowxb = mysql_fetch_array($resultxb);
		echo $notas." : <br><strong><em>".$texto."</em></strong><br>".$rowxb["dias_vencimiento"]."";
		if ($rowxb["dias"] == 1) { echo " dias "; } else { echo " meses "; }
		echo "".$rowxb["formas_pago"]."<br>";
	echo "</td></tr>";
	echo "<tr><td style=\"font-size: xx-small;\">".$texto_pdatos."</td></tr>";
	if ($rowx["tipo_ot"] == 1){
		echo "<tr><td class=\"inverse\" width=\"100%\" style=\"background-color:#C0C0C0;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;text-align:justify;border: 1px dotted black\">";
			echo "Certificaciones : <br>";
			echo "<table>";
			$sqlxx = "select * from sgm_clients where nombre='".$rowcabezera["nombre"]."'";
			$resultxx = mysql_query(convert_sql($sqlxx));
			$rowxx = mysql_fetch_array($resultxx);
			$sqlxxx = "select * from sgm_clients_certificaciones_docu_client where visible=1 and id_cliente=".$rowxx["id"];
			$resultxxx = mysql_query(convert_sql($sqlxxx));
			while ($rowxxx = mysql_fetch_array($resultxxx)){
				$sqlc = "select * from sgm_clients_certificaciones where visible=1 and id=".$rowxxx["id_certificado"];
				$resultc = mysql_query(convert_sql($sqlc));
				while ($rowc = mysql_fetch_array($resultc)){
					$sqlcd = "select * from sgm_clients_certificaciones_docu where visible=1 and id=".$rowxxx["id_docu"]." and id_certificado=".$rowxxx["id_certificado"];
					$resultcd = mysql_query(convert_sql($sqlcd));
					$rowcd = mysql_fetch_array($resultcd);
					echo "<em>".$rowc["nombre"]." - ".$rowcd["docu"]."</em><br>";
				}
			}
		echo "</table></td></tr>";
	}
	echo "</table>";
}
?>


</body>
</html>
