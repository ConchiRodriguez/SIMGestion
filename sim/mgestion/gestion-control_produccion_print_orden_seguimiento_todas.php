<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../config.php");
	include ("../auxiliar/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$user = false;

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

?>
<html>
<head>
		<link rel="stylesheet" href="style.css" type="text/css">
	
	<STYLE>
		H1.SaltoDePagina
		{
			PAGE-BREAK-AFTER: always
		}
	</STYLE>
</head>
<body>

<?php

$autorizado = true;

if ($autorizado == true) {

		$sqlf = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);

		$sp = 0;
		$lineas = $_POST["ot"];
		for ($i = 0 ; $i < count($lineas); $i++){
			$linies = $linies.$lineas[$i].",";
		}
		$linies .= "0";
		$sqlp = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." and id in (".$linies.") order by linea";
		$resultp = mysql_query(convert_sql($sqlp));
		while ($rowp = mysql_fetch_array($resultp)) {
			if ($sp == 1) { echo "<H1 class=SaltoDePagina> </H1>"; }
			if ($sp == 0) { $sp = 1; }
			echo "<table style=\"border:0px\"><tr><td style=\"width:600px;text-align:center;border:0px;\">";
				echo "<table style=\"width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr><td style=\"width:50%;vertical-align : top;text-align:left;\">";
						echo "<strong>Nº OT : </strong>".$rowf["numero"];
						echo "<br><strong>Nº de linea : </strong>".$rowp["linea"];
						echo "<br><strong>Nº plano : </strong>".$rowp["codigo"];
						echo "<br>";
						echo "<br><strong>Pieza : </strong>".$rowp["nombre"];
						echo "<br><strong>Unidades : </strong>".number_format($rowp["unidades"],2,',','.');
					echo "</td><td style=\"width:50%;vertical-align : top;text-align:left;\">";
						echo "<strong>Nº ref. cliente : </strong>".$rowf["numero_cliente"];
						echo "<br><strong>Cliente : </strong>".$rowf["nombre"];
						echo "<br>";
						echo "<br><strong>Fecha pedido : </strong>".cambiarFormatoFechaDMY($rowf["fecha"]);
						echo "<br><strong>Fecha entrega : </strong>".cambiarFormatoFechaDMY($rowp["fecha_prevision"]);
				echo "</td></tr></table><br>";
				$sql = "select * from sgm_cuerpo_orden_seguimiento where id_cuerpo=".$rowp["id"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\";border:0px;\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;border:0px;\">Descripción&nbsp;</td>";
				echo "<td><textarea name=\"descripcion\" style=\"width:550px;height:50px\">".$row["descripcion"]."</textarea></td></tr></table>";
				echo "<br>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\"  style=\"border:0px\">";
					echo "<tr>";
						echo "<td>Fase</td>";
						echo "<td></td>";
						echo "<td>Autocontrol</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
#						echo "<td>Ver.</td>";
						echo "<td>Horas</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
					echo "</tr>";
				$totalhoras = 0;
					echo "<tr>";
						echo "<td style=\"width:65px;text-align:right;\">Sierra&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"serra_autocontrol_1\" value=\"".$row["serra_autocontrol_1"]."\" style=\"width:65px;;height:20px\"></td>";
						echo "<td><input type=\"Text\" name=\"serra_autocontrol_2\" value=\"".$row["serra_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"serra_autocontrol_3\" value=\"".$row["serra_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"serra_autocontrol_4\" value=\"".$row["serra_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"serra_verificacion_1\" value=\"".$row["serra_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["serra_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["serra_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"serra_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["serra_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["serra_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"serra_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["serra_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["serra_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"serra_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["serra_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["serra_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"serra_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["serra_horas_1"]+$row["serra_horas_2"]+$row["serra_horas_3"]+$row["serra_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["serra_horas_1"]+$row["serra_horas_2"]+$row["serra_horas_3"]+$row["serra_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">CNC&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cnc_autocontrol_1\" value=\"".$row["cnc_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"cnc_autocontrol_2\" value=\"".$row["cnc_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"cnc_autocontrol_3\" value=\"".$row["cnc_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"cnc_autocontrol_4\" value=\"".$row["cnc_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"cnc_verificacion_1\" value=\"".$row["cnc_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["cnc_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["cnc_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"cnc_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["cnc_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["cnc_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"cnc_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["cnc_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["cnc_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"cnc_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["cnc_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["cnc_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"cnc_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["cnc_horas_1"]+$row["cnc_horas_2"]+$row["cnc_horas_3"]+$row["cnc_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["cnc_horas_1"]+$row["cnc_horas_2"]+$row["cnc_horas_3"]+$row["cnc_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">TNC&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"tnc_autocontrol_1\" value=\"".$row["tnc_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"tnc_autocontrol_2\" value=\"".$row["tnc_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"tnc_autocontrol_3\" value=\"".$row["tnc_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"tnc_autocontrol_4\" value=\"".$row["tnc_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"tnc_verificacion_1\" value=\"".$row["tnc_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["tnc_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["tnc_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"tnc_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["tnc_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["tnc_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"tnc_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["tnc_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["tnc_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"tnc_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["tnc_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["tnc_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"tnc_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["tnc_horas_1"]+$row["tnc_horas_2"]+$row["tnc_horas_3"]+$row["tnc_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["tnc_horas_1"]+$row["tnc_horas_2"]+$row["tnc_horas_3"]+$row["tnc_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">Torno&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"torn_autocontrol_1\" value=\"".$row["torn_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"torn_autocontrol_2\" value=\"".$row["torn_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"torn_autocontrol_3\" value=\"".$row["torn_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"torn_autocontrol_4\" value=\"".$row["torn_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"torn_verificacion_1\" value=\"".$row["torn_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["torn_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["torn_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"torn_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["torn_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["torn_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"torn_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["torn_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["torn_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"torn_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["torn_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["torn_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"torn_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["torn_horas_1"]+$row["torn_horas_2"]+$row["torn_horas_3"]+$row["torn_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["torn_horas_1"]+$row["torn_horas_2"]+$row["torn_horas_3"]+$row["torn_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">Fresa&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"fresa_autocontrol_1\" value=\"".$row["fresa_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"fresa_autocontrol_2\" value=\"".$row["fresa_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"fresa_autocontrol_3\" value=\"".$row["fresa_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"fresa_autocontrol_4\" value=\"".$row["fresa_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"fresa_verificacion_1\" value=\"".$row["fresa_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["fresa_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["fresa_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"fresa_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["fresa_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["fresa_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"fresa_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["fresa_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["fresa_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"fresa_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["fresa_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["fresa_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"fresa_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["fresa_horas_1"]+$row["fresa_horas_2"]+$row["fresa_horas_3"]+$row["fresa_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["fresa_horas_1"]+$row["fresa_horas_2"]+$row["fresa_horas_3"]+$row["fresa_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">Ajuste&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"ajust_autocontrol_1\" value=\"".$row["ajust_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"ajust_autocontrol_2\" value=\"".$row["ajust_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"ajust_autocontrol_3\" value=\"".$row["ajust_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"ajust_autocontrol_4\" value=\"".$row["ajust_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"ajust_verificacion_1\" value=\"".$row["ajust_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["ajust_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["ajust_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"ajust_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["ajust_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["ajust_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"ajust_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["ajust_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["ajust_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"ajust_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["ajust_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["ajust_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"ajust_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["ajust_horas_1"]+$row["ajust_horas_2"]+$row["ajust_horas_3"]+$row["ajust_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["ajust_horas_1"]+$row["ajust_horas_2"]+$row["ajust_horas_3"]+$row["ajust_horas_4"]);
					echo "</tr>";
#					echo "<tr>";
#						echo "<td style=\"width:65px;height:20px;text-align:right;\">Soldadura&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_1\" value=\"".$row["soldadura_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_2\" value=\"".$row["soldadura_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_3\" value=\"".$row["soldadura_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_autocontrol_4\" value=\"".$row["soldadura_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_verificacion_1\" value=\"".$row["soldadura_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_horas_1\" value=\"".$row["soldadura_horas_1"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_horas_2\" value=\"".$row["soldadura_horas_2"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_horas_3\" value=\"".$row["soldadura_horas_3"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td><input type=\"Text\" name=\"soldadura_horas_4\" value=\"".$row["soldadura_horas_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["soldadura_horas_1"]+$row["soldadura_horas_2"]+$row["soldadura_horas_3"]+$row["soldadura_horas_4"])."</strong></td>";
#						$totalhoras = $totalhoras+($row["soldadura_horas_1"]+$row["soldadura_horas_2"]+$row["soldadura_horas_3"]+$row["soldadura_horas_4"]);
#					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">Rectificado&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_1\" value=\"".$row["rectificat_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_2\" value=\"".$row["rectificat_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_3\" value=\"".$row["rectificat_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"rectificat_autocontrol_4\" value=\"".$row["rectificat_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"rectificat_verificacion_1\" value=\"".$row["rectificat_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["rectificat_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["rectificat_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"rectificat_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["rectificat_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["rectificat_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"rectificat_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["rectificat_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["rectificat_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"rectificat_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["rectificat_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["rectificat_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"rectificat_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["rectificat_horas_1"]+$row["rectificat_horas_2"]+$row["rectificat_horas_3"]+$row["rectificat_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["rectificat_horas_1"]+$row["rectificat_horas_2"]+$row["rectificat_horas_3"]+$row["rectificat_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:65px;height:20px;text-align:right;\">Programacion&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"programacion_autocontrol_1\" value=\"".$row["programacion_autocontrol_1"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"programacion_autocontrol_2\" value=\"".$row["programacion_autocontrol_2"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"programacion_autocontrol_3\" value=\"".$row["programacion_autocontrol_3"]."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td><input type=\"Text\" name=\"programacion_autocontrol_4\" value=\"".$row["programacion_autocontrol_4"]."\" style=\"width:65px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
#						echo "<td><input type=\"Text\" name=\"programacion_verificacion_1\" value=\"".$row["programacion_verificacion_1"]."\" style=\"width:35px;height:20px;\"></td>";
#						echo "<td>&nbsp;</td>";
						if ($row["programacion_horas_1"] == 0.00) { $horas = ''; } else { $horas = $row["programacion_horas_1"]; }
						echo "<td><input type=\"Text\" name=\"programacion_horas_1\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["programacion_horas_2"] == 0.00) { $horas = ''; } else { $horas = $row["programacion_horas_2"]; }
						echo "<td><input type=\"Text\" name=\"programacion_horas_2\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["programacion_horas_3"] == 0.00) { $horas = ''; } else { $horas = $row["programacion_horas_3"]; }
						echo "<td><input type=\"Text\" name=\"programacion_horas_3\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						if ($row["programacion_horas_4"] == 0.00) { $horas = ''; } else { $horas = $row["programacion_horas_4"]; }
						echo "<td><input type=\"Text\" name=\"programacion_horas_4\" value=\"".$horas."\" style=\"width:65px;height:20px;\"></td>";
						echo "<td style=\"width:65px;height:20px;text-align:right\"><strong>".($row["programacion_horas_1"]+$row["programacion_horas_2"]+$row["programacion_horas_3"]+$row["programacion_horas_4"])."</strong></td>";
						$totalhoras = $totalhoras+($row["programacion_horas_1"]+$row["programacion_horas_2"]+$row["programacion_horas_3"]+$row["programacion_horas_4"]);
					echo "</tr>";
					echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
#						echo "<td></td>";
#						echo "<td></td>";
#						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td style=\"width:65px;text-align:right\">Total</td>";
						echo "<td style=\"width:65px;text-align:right\"><strong>".$totalhoras."</strong></td>";
					echo "</tr>";
				echo "</table>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\"  style=\"border:0px\">";
					echo "<tr>";
						echo "<td></td>";
						echo "<td><center>Teórica</center></td>";
						echo "<td><center>Real</center></td>";
						echo "<td></td>";
						echo "<td><center>Teórica</center></td>";
						echo "<td><center>Real</center></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_1_a\" value=\"".$row["cota_1_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_1_b\" value=\"".$row["cota_1_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_2_a\" value=\"".$row["cota_2_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_2_b\" value=\"".$row["cota_2_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_3_a\" value=\"".$row["cota_3_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_3_b\" value=\"".$row["cota_3_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_4_a\" value=\"".$row["cota_4_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_4_b\" value=\"".$row["cota_4_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_5_a\" value=\"".$row["cota_5_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_5_b\" value=\"".$row["cota_5_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_6_a\" value=\"".$row["cota_6_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_6_b\" value=\"".$row["cota_6_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_7_a\" value=\"".$row["cota_7_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_7_b\" value=\"".$row["cota_7_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_8_a\" value=\"".$row["cota_8_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_8_b\" value=\"".$row["cota_8_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_9_a\" value=\"".$row["cota_9_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_9_b\" value=\"".$row["cota_9_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_10_a\" value=\"".$row["cota_10_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_10_b\" value=\"".$row["cota_10_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_11_a\" value=\"".$row["cota_11_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_11_b\" value=\"".$row["cota_11_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_12_a\" value=\"".$row["cota_12_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_12_b\" value=\"".$row["cota_12_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_13_a\" value=\"".$row["cota_13_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_13_b\" value=\"".$row["cota_13_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_14_a\" value=\"".$row["cota_14_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_14_b\" value=\"".$row["cota_14_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_15_a\" value=\"".$row["cota_15_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_15_b\" value=\"".$row["cota_15_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_16_a\" value=\"".$row["cota_16_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_16_b\" value=\"".$row["cota_16_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_17_a\" value=\"".$row["cota_17_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_17_b\" value=\"".$row["cota_17_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_18_a\" value=\"".$row["cota_18_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_18_b\" value=\"".$row["cota_18_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_19_a\" value=\"".$row["cota_19_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_19_b\" value=\"".$row["cota_19_b"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td style=\"width:60px;text-align:right\">Cota&nbsp;</td>";
						echo "<td><input type=\"Text\" name=\"cota_20_a\" value=\"".$row["cota_20_a"]."\" style=\"width:120px;height:30px\"></td>";
						echo "<td><input type=\"Text\" name=\"cota_20_b\" value=\"".$row["cota_20_b"]."\" style=\"width:120px;height:30px\"></td>";
					echo "</tr>";
				echo "</table>";
				echo "<br>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\"  style=\"border:0px\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;\">Aplicaciones&nbsp;<br>exteriores&nbsp;</td>";
				echo "<td><textarea name=\"aplicaciones_exteriores\" style=\"width:550px;height:100px\">".$row["aplicaciones_exteriores"]."</textarea></td></tr></table>";
				echo "<br>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\"  style=\"border:0px\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;\">Observaciones&nbsp;</td>";
				echo "<td><textarea name=\"observaciones\" style=\"width:550px;height:100px\">".$row["observaciones"]."</textarea></td></tr></table>";
				echo "<br>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\"  style=\"border:0px\"><tr><td style=\"vertical-align:top;text-align:right;width:85px;\">Materiales&nbsp;:</td>";
				echo "<td>";
				$sqlfx = "select * from sgm_cuerpo where id_cuerpo=".$rowp["id"];
				$resultfx = mysql_query(convert_sql($sqlfx));
				$x = 0;
				while ($rowfx = mysql_fetch_array($resultfx)) {
					if ($x == 1) { echo "<br>- <strong>".number_format($rowfx["unidades"],2,',','.')."</strong> unidad/es de <strong>".$rowfx["nombre"]."</strong>"; }
					if ($x == 0) { echo "- <strong>".number_format($rowfx["unidades"],2,',','.')."</strong> unidad/es de <strong>".$rowfx["nombre"]."</strong>"; $x = 1; }
				}
				echo "</td></tr></table>";
			echo "</td></tr></table>";
	}

}
else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>

</td></tr></table>


</body>
</html>
