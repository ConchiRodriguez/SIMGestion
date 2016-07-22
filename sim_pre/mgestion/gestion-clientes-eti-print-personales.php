<?php 
error_reporting(~E_ALL);

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
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
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
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
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
<body style="padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;">

<?php

$autorizado = false;
if ($user == true) {
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultcabezera = mysqli_query($dbhandle,convertSQL($sqlcabezera));
		$rowcabezera = mysqli_fetch_array($resultcabezera);

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysqli_query($dbhandle,convertSQL($sqlsgm));
		$rowsgm = mysqli_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }

		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysqli_query($dbhandle,convertSQL($sqlpermiso));
		$rowpermiso = mysqli_fetch_array($resultpermiso);
		if ($rowpermiso["total"] >= 1) { $autorizado = true; }

}

$autorizado = true;
if ($autorizado == true) {
	$y =1;
	$x = 1;
	$y_fi = 2;
	$x_fi = 7;
	$etiqueta = 1;
	$total_etiquetas = $y_fi * $x_fi;
	$width_total = 190;
	$width_td = $width_total/$y_fi;
	$height_total = 280;
	$height_td = $height_total/$x_fi;
	$posicion = 0;

	echo "<table cellpadding=\"0px\" cellspacing=\"0px\" style=\"border: 0px solid black\"><tr>";

	if ($_POST["personal"] == 1) {
		$sqlx3 = "select * from sgm_clients where id=".$_POST["cliente"];
		$resultx3 = mysqli_query($dbhandle,convertSQL($sqlx3));
		$rowx3 = mysqli_fetch_array($resultx3);
		while ($_POST["posicion"] >= $posicion){
			if ($_POST["posicion"] == $posicion) {
				echo "<td style=\"text-align:top;border:0px solid black;width:".$width_td."mm;height:".$height_td."mm;padding: 10px 30px 10px 30px;vertical-align:middle;font-size: 12px;\">";
					$sqlx4 = "select * from sgm_clients_tratos where id=".$rowx3["id_trato"];
					$resultx4 = mysqli_query($dbhandle,convertSQL($sqlx4));
					$rowx4 = mysqli_fetch_array($resultx4);
					echo "<br>".$rowx4["trato"]." ".$rowx3["nombre"]." ".$rowx3["cognom1"]." ".$rowx3["cognom2"];
					$sqltc = "select * from sgm_clients_carrer_tipo where id=".$rowx3["id_tipo_carrer"];
					$resulttc = mysqli_query($dbhandle,convertSQL($sqltc));
					$rowtc = mysqli_fetch_array($resulttc);
					$sqlac = "select * from sgm_clients_carrer where id=".$rowx3["id_carrer"];
					$resultac = mysqli_query($dbhandle,convertSQL($sqlac));
					$rowac = mysqli_fetch_array($resultac);
					$sqlzf = "select * from sgm_clients_sector_zf where id=".$rowx3["id_sector_zf"];
					$resultzf = mysqli_query($dbhandle,convertSQL($sqlzf));
					$rowzf = mysqli_fetch_array($resultzf);
				if (($rowx3["id_tipo_carrer"] > 0) or ($rowx3["id_carrer"] > 0) or ($rowx3["numero"] > 0) or ($rowx3["id_sector_zf"] > 0)){
					echo "<br>".$rowtc["nombre"]." ".$rowac["nombre"].", núm. ".$rowx3["numero"].", Sector ".$rowzf["nombre"]."";
				} else {
					echo "<br>".$rowx3["direccion"];
				}
					$sqlx2 = "select * from sgm_clients_ubicacion where id=".$rowx3["id_ubicacion"];
					$resultx2 = mysqli_query($dbhandle,convertSQL($sqlx2));
					$rowx2 = mysqli_fetch_array($resultx2);
					if ($rowx3["id_ubicacion"] != 0) {	echo "<br>".$rowx2["ubicacion"]; }
					echo "<br>".$rowx3["cp"]." ".$rowx3["poblacion"]."";
				echo "</td>";
				if ($y == $y_fi) { echo "</tr><tr>"; $y=1; } else { $y++; }
			} else {
				echo "<td style=\"text-align:top;border:0px solid black;width:".$width_td."mm;height:".$height_td."mm;padding: 10px 30px 10px 30px;vertical-align:middle;font-size: 12px;\">";
				echo "&nbsp;</td>";
				if ($y == $y_fi) { echo "</tr><tr>"; $y=1; } else { $y++; }
			}
			$posicion ++;
		}
	}

	if ($_POST["personal"] == 2) {
		$sqlx3 = "select * from sgm_clients_contactos where id=".$_POST["cliente"];
		$resultx3 = mysqli_query($dbhandle,convertSQL($sqlx3));
		$rowx3 = mysqli_fetch_array($resultx3);
		while ($_POST["posicion"] >= $posicion){
			if ($_POST["posicion"] == $posicion) {
				echo "<td style=\"text-align:top;border:0px solid black;width:".$width_td."mm;height:".$height_td."mm;padding: 10px 30px 10px 30px;vertical-align:middle;font-size: 12px;\">";
					$sqlx4 = "select * from sgm_clients_tratos where id=".$rowx3["id_trato"];
					$resultx4 = mysqli_query($dbhandle,convertSQL($sqlx4));
					$rowx4 = mysqli_fetch_array($resultx4);
					echo "<br>".$rowx4["trato"]." ".$rowx3["nombre"]." ".$rowx3["cognom1"]." ".$rowx3["cognom2"];

					$sqlx = "select * from sgm_clients where id=".$rowx3["id_client"];
					$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
					$rowx = mysqli_fetch_array($resultx);
					$sqltc = "select * from sgm_clients_carrer_tipo where id=".$rowx["id_tipo_carrer"];
					$resulttc = mysqli_query($dbhandle,convertSQL($sqltc));
					$rowtc = mysqli_fetch_array($resulttc);
					$sqlac = "select * from sgm_clients_carrer where id=".$rowx["id_carrer"];
					$resultac = mysqli_query($dbhandle,convertSQL($sqlac));
					$rowac = mysqli_fetch_array($resultac);
					$sqlzf = "select * from sgm_clients_sector_zf where id=".$rowx["id_sector_zf"];
					$resultzf = mysqli_query($dbhandle,convertSQL($sqlzf));
					$rowzf = mysqli_fetch_array($resultzf);
				if (($rowx["id_tipo_carrer"] > 0) or ($rowx["id_carrer"] > 0) or ($rowx["numero"] > 0) or ($rowx["id_sector_zf"] > 0)){
					echo "<br>".$rowtc["nombre"]." ".$rowac["nombre"].", núm. ".$rowx["numero"].", Sector ".$rowzf["nombre"]."";
				} else {
					echo "<br>".$rowx["direccion"];
				}

					$sqlx2 = "select * from sgm_clients_ubicacion where id=".$rowx["id_ubicacion"];
					$resultx2 = mysqli_query($dbhandle,convertSQL($sqlx2));
					$rowx2 = mysqli_fetch_array($resultx2);
					if ($rowx["id_ubicacion"] != 0) {	echo "<br>".$rowx2["ubicacion"]; }
					echo "<br>".$rowx["cp"]." ".$rowx["poblacion"]."";
				echo "</td>";
				if ($y == $y_fi) { echo "</tr><tr>"; $y=1; } else { $y++; }
			} else {
				echo "<td style=\"text-align:top;border:0px solid black;width:".$width_td."mm;height:".$height_td."mm;padding: 10px 30px 10px 30px;vertical-align:middle;font-size: 12px;\">";
				echo "&nbsp;</td>";
				if ($y == $y_fi) { echo "</tr><tr>"; $y=1; } else { $y++; }
			}
			$posicion ++;
		}
	}

} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>


</body>
</html>
