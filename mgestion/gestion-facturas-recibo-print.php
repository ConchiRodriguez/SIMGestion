<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
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
} else { 
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
</head>
<body style="padding : 0px 0px 0px 0px;margin : 0px 0px 0px 0px;">

<?php

$autorizado = true;
if ($user == true) {
		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convert_sql($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }
}
if ($autorizado == true) {

		$sqlr = "select * from sgm_recibos where id=".$_GET["id"];
		$resultr = mysql_query(convert_sql($sqlr));
		$rowr = mysql_fetch_array($resultr);

		$sqlcli = "select * from sgm_clients where id=".$rowr["id_cliente"];
		$resultcli = mysql_query(convert_sql($sqlcli));
		$rowcli = mysql_fetch_array($resultcli);

		$sqlf = "select * from sgm_cabezera where id=".$rowr["id_factura"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);

		$sqld = "select * from sgm_dades_origen_factura";
		$resultd = mysql_query(convert_sql($sqld));
		$rowd = mysql_fetch_array($resultd);

	echo "<table width=\"700px\" cellpadding=\"0px\" cellspacing=\"0px\" style=\"border: 0px solid black\"><tr><td style=\"border: 0px solid black\"><center>";
		echo "<table cellpadding=\"0px\" cellspacing=\"0px\" width=\"100%\" style=\"height:250px;border : 0px solid black; border-right : 0px; border-left : 0px; border-top : 0px;\"><tr>";
			echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 7px;width:125px;vertical-align : top;\">";
				echo "".$rowr["onombre"]."";
				echo "<br>".$rowr["onif"]."";
				echo "<br>".$rowr["odireccion"]."";
				echo "<br>".$rowr["opoblacion"]." (".$rowr["ocp"].") ".$rowr["oprovincia"]."";
#				echo "<br><br>Telf : ".$rowcabezera["otelefono"];
#				echo "<br>e-Mail : ".$rowcabezera["omail"];
				echo "<br><br><br><br><br>";
				echo "<br><br><br><br><br>";
		echo "</td>";
		echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 7px;width:10px;vertical-align : top;\">&nbsp;";
		echo "</td>";
		echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;vertical-align:top;\" >";
			echo "<table style=\"border:0px\">";
				echo "<tr>";
					echo "<td style=\"text-align:left;width:150px;border:0px\">";
						echo "<font style=\"font-size : 8px\">RECIBO NÚMERO</font>";
						echo "<br><strong>".$rowf["numero"]."/".$rowr["numero_serie"]."</strong>";
					echo "</td>";
					echo "<td style=\"text-align:center;width:150px;border:0px\">";
						echo "<font style=\"font-size : 8px\">LOCALIDAD DE EXPEDICION</font>";
						echo "<br><strong>".$rowd["poblacion"]."</strong>";
					echo "</td>";
					echo "<td style=\"text-align:center;width:150px;border:0px\">";
						echo "<font style=\"font-size : 8px\">TOTAL IMPORTE</font>";
						echo "<br><strong>".number_format($rowr["total"], 2, ',', '.')." €</strong>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			echo "<br>";
			echo "<table style=\"border:0px\">";
				echo "<tr>";
					echo "<td style=\"text-align:left;width:150px;border:0px\">";
						echo "<font style=\"font-size : 8px\">FECHA EXPEDICIÓN</font>";
						echo "<br><strong>".$rowr["fecha"]."</strong>";
					echo "</td>";

					echo "<td style=\"text-align:center;width:150px;border:0px\">";
					if ($rowr["id_tipo_pago"] == 4) {
						echo "<font style=\"font-size : 8px\">VENCIMIENTO</font>";
						echo "<br><strong>".$rowr["fecha_vencimiento"]."</strong>";
					}
					echo "</td>";

					echo "<td style=\"text-align:center;width:150px;border:0px\">";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			echo "<br>";
				echo "<br><center><font style=\"font-size : 8px\">LA CANTIDAD DE € : </font> ".strtoupper(convertir_a_letras($rowr["total"]))."</center>";
			echo "<br>";
			echo "<br>";

			echo "<table style=\"border:0px\">";
				echo "<tr>";
					echo "<td style=\"text-align:left;width:150px;border:0px\">";
					if ($rowr["id_tipo_pago"] == 4) {
						echo "<font style=\"font-size : 8px\">PAGABLE A</font>";
						echo "<br><strong>".$rowcli["entidadbancaria"]."</strong>";
					} else {
						echo "<font style=\"font-size : 8px\">FORMA DE PAGO</font>";
						$sqlxx = "select * from sgm_tpv_tipos_pago WHERE id=".$rowr["id_tipo_pago"];
						$resultxx = mysql_query(convert_sql($sqlxx));
						$rowxx = mysql_fetch_array($resultxx);

						echo "<br><strong>".$rowxx["tipo"]."</strong>";
					}
					echo "</td>";
					echo "<td style=\"text-align:center;width:150px;border:0px\">";
					if ($rowr["id_tipo_pago"] == 4) {
						echo "<font style=\"font-size : 8px\">NUMERO DE CUENTA</font>";
						echo "<br><strong>".$rowcli["cuentabancaria"]."</strong>";
					}
					echo "</td>";
					echo "<td style=\"text-align:right;width:175px;border:0px\">";
						echo "<font style=\"font-size : 8px\">(NOMBRE DEL EXPEDIDOR)</font>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			echo "<br><br><font style=\"font-size : 8px\">NOMBRE Y DOMICILIO DEL LIBRADO</font>";

				echo "<br><strong>".$rowr["nombre"]."</strong>";
				echo "<br><strong>".$rowr["nif"]."</strong>";
				echo "<br><strong>".$rowr["direccion"]."</strong>";
				echo "<br><strong>".$rowr["poblacion"]."</strong> (".$rowr["cp"].") <strong>".$rowr["provincia"]."</strong>";
				echo "<br><br>";
			echo "</td>";
		echo "</tr></table>";



	echo "</center></td></tr>";
	echo "</table>";
}
else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>


</body>
</html>
