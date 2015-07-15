<?php
error_reporting(~E_ALL);
#date_default_timezone_set('Europe/Paris');

### BUSCA SI ES UNA IP LOCAL
$accesolocal = true;
$ip = $_SERVER['REMOTE_ADDR'];
$subxarxa = "192.168.1.";
$x = 0;
for ($x = 0 ; $x < strlen($subxarxa) ; $x++) {
	if ($ip[$x] != $subxarxa[$x]) { $accesolocal = false ; }
}

if ($accesolocal == true) {	include ("config.php"); }
if ($accesolocal == false) { include ("config2.php"); }

include ("auxiliar/functions.php");
#if(!isset($HTTP_SERVER_VARS[HTTPS])) { header("Location: ".$urloriginal); }

#	$basededatos = "MSSQL";
	$basededatos = "MYSQL";

### CONEXION
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

if ($_GET['op'] != "") { $option = $_GET['op']; } else { $option = 0; }
if ($_GET['sop'] != "") { $soption = $_GET['sop']; } else { $soption = 0; }
if ($_GET['ssop'] != "") { $ssoption = $_GET['ssop']; } else { $ssoption = 0; }
if ($_GET['fu'] != "") { $funcio = $_GET['fu']; } else { $funcio = 0; }
if ($_GET['sfu'] != "") { $sfuncio = $_GET['sfu']; } else { $sfuncio = 0; }
#if ($_GET['idioma'] != "") { $idioma = $_GET['dir']; } else { $idioma = "es"; }

$user = false;
$userid = 0;
if ($soption == 666) {
	setcookie("musername", "", time()-1, "/");
	setcookie("mpassword", "", time()-1, "/");
	unset($_COOKIE["musername"]); 
	unset($_COOKIE["mpassword"]); 
	header("Location: ".$urloriginal."/logout.php");
}

if ($option == 667) {
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}


if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/", $domain);
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "es";
		setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/", $domain);
	} else { $idioma = $_COOKIE["idioma"]; }
}

if ($idioma == "es"){ include ("sgm_es.php");}
if ($idioma == "cat"){ include ("sgm_cat.php");}

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
				header("Location: ".$urloriginal."/index.php?op=200&sop=40&id=".$_POST["user"]);
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

lopd($userid,$username,$option,$soption);

if ($_POST["exec_sql_0"] != "") { mysql_query(convert_sql($_POST["exec_sql_0"])); }
if ($_POST["exec_sql_1"] != "") { mysql_query(convert_sql($_POST["exec_sql_1"])); }
if ($_POST["exec_sql_2"] != "") { mysql_query(convert_sql($_POST["exec_sql_2"])); }
if ($_POST["exec_sql_3"] != "") { mysql_query(convert_sql($_POST["exec_sql_3"])); }
if ($_POST["exec_sql_4"] != "") { mysql_query(convert_sql($_POST["exec_sql_4"])); }
if ($_POST["exec_sql_5"] != "") { mysql_query(convert_sql($_POST["exec_sql_5"])); }
if ($_POST["exec_sql_6"] != "") { mysql_query(convert_sql($_POST["exec_sql_6"])); }
if ($_POST["exec_sql_7"] != "") { mysql_query(convert_sql($_POST["exec_sql_7"])); }
if ($_POST["exec_sql_8"] != "") { mysql_query(convert_sql($_POST["exec_sql_8"])); }
if ($_POST["exec_sql_9"] != "") { mysql_query(convert_sql($_POST["exec_sql_9"])); }
?>

<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>SIM MGESTION 2.0</title>

		<?php include ("auxiliar/functions-js.php"); ?>

	</head>
<body>
<center>
<?php 
if (($option == 800) or ($option == 900) or ($option == 600) or ($option == 950)) {
	include ("mgestion/lenguajes/help-es.php");
	include ("mgestion/help/mail.php");
	include ("mgestion/help/produccion.php");
	include ("mgestion/gestion-articulos-etiqueta-print.php");
} else {
?>
<table border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" width="1250">
	<tr>
		<td background="images/bajo.jpg" height="20px">
			<font style="color : white; padding-left : 5px;">
			<?php 
				if ($user == true) {
					echo "Bienvenido <strong>".$username."</strong> id : <strong>".$userid."</strong>";
				} else {
					echo "<a href=\"index.php?op=100\" style=\"color : white;\"><strong>[ Identificarse ]</strong></a>";
				}
				
				$date = getdate();
				if ($date["mday"] < 10) { $z = "0".$date["mday"]; }
				else {$z = $date["mday"]; }
				if ($date["mon"] < 10) { $y = "0".$date["mon"]; }
				else {$y = $date["mon"]; }
				echo "&nbsp;&nbsp;&nbsp;".$z."/".$y."/".$date["year"]."";
				if ($date["minutes"] < 10) { $x = "0".$date["minutes"]; }
				else {$x = $date["minutes"]; }
				if ($date["hours"] < 10) { $y = "0".$date["hours"]; }
				else {$y = $date["hours"]; }
				echo "&nbsp;&nbsp;&nbsp;<strong>".$y.":".$x."</strong>";
				echo "&nbsp;&nbsp;&nbsp;<strong>Barcelona</strong> (UE)";
				if ($accesolocal == true) {	echo " <strong>L</strong>"; }
				if ($accesolocal == false) {	echo " <strong>E</strong>"; }
			?>
			</font>
		</td>
	</tr>
	<tr>
		<td style="border-left : 0px solid Silver; border-right : 0px solid Silver; padding-left:1px; padding-right:1px; padding-top:1px;text-align:justify;height:100%;vertical-align:top;">


		<?php
		if ($sgm == 1) {

			if ($option <> 0) {
				$sqlmodulo = "select * from sgm_users_permisos_modulos where id_modulo=".$option;
				$resultmodulo = mysql_query(convert_sql($sqlmodulo));
				$rowmodulo = mysql_fetch_array($resultmodulo);
				$id_grupo = $rowmodulo["id_grupo"];
			} else {
				$id_grupo = $_GET["id_grupo"];
			}

			echo "<center><table cellpadding=\"0\" cellspacing=\"1\"><tr>";
				echo "<td style=\"width:150px;text-align:center;vertical-align:middle\"><a href=\"index.php?op=200&sop=0\" class=\"gris\">".$Panel_de_Usuario."</a></td>";
				$sqlu = "select * from sgm_users where id=".$userid;
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
					if ($rowu["sgm"] == 1) {
						$sqlm = "select * from sgm_users_permisos_modulos_grupos where visible=1 order by nombre";
						$resultm = mysql_query(convert_sql($sqlm));
						while ($rowm = mysql_fetch_array($resultm)) {
							$color = "#4B53AF";
							$color_letras = "white";
							if ($rowm["id"] == $id_grupo) {
								$color = "white";
								$color_letras = "#4B53AF";
							}
							echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: ".$color_letras.";border: 1px solid black\"><a href=\"index.php?id_grupo=".$rowm["id"]."\" class=\"gris\" style=\"color:".$color_letras.";\">";
							echo $rowm["nombre"]."</a></td>";
						}
					}
				echo "<td style=\"width:120px;text-align:center;vertical-align:middle;\"><a href=\"index.php?sop=666\" class=\"gris\">".$Salir."</a></td>";
				echo "<td>";
					if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat\"><strong>Cat</strong></a> | <a href=\"index.php?i=es\">Es</a>"; }
					if ($idioma == "es") {	echo "<a href=\"index.php?i=cat\">Cat</a> | <a href=\"index.php?i=es\"><strong>Es</strong></a>"; }
				echo "</td>";
			echo "</tr></table></center>";

##			if ($option == 0) {
				echo "<center><table cellpadding=\"0\" cellspacing=\"1\"><tr>";
					$sqlm = "select * from sgm_users_permisos_modulos where visible=1 and id_grupo=".$id_grupo." order by nombre";
					$resultm = mysql_query(convert_sql($sqlm));
					while ($rowm = mysql_fetch_array($resultm)) {
							$color = "#4B53AF";
							$color_letras = "white";
							if ($rowm["id_modulo"] == $option) {
								$color = "white";
								$color_letras = "#4B53AF";
							}
						echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: ".$color.";color: ".$color_letras.";border: 1px solid black\"><a href=\"index.php?op=".$rowm["id_modulo"]."\" class=\"gris\" style=\"color:".$color_letras.";\">";
						echo $rowm["nombre"]."</a></td>";
					}
				echo "</tr></table></center>";
			}
##		}

?>


		</td>
	</tr>
	<tr>
		<td style="border-left : 0px solid Silver; border-right : 0px solid Silver; padding-left:1px; padding-right:1px; padding-top:1px;text-align:justify;height:100%;vertical-align:top;">
		<?php
			$veure_peu = 1;
					include ("mgestion/indice.php");
#					if ($option == 0) { include ("includes/inicio.php");}
					if ($option == 0) { }
					if ($option == 1) { include ("includes/tiendaonline.php");}
					if ($option == 2) { include ("includes/mail.php");}
					if ($option == 6) { include ("includes/linux.php");}
					if ($option == 10) { include ("includes/campus.php");}
					if ($option == 11) { include ("includes/noticias.php");}
					if ($option == 12) { include ("includes/noticia.php");}
					if ($option == 100) { include ("includes/registrarse.php");}
					if ($option == 201) { include ("includes/servicios.php");}
					if ($option == 202) { include ("includes/sat.php");}
					if ($option == 203) { include ("includes/contactar.php");}
					if ($option == 300) { include ("includes/privacidad.php");}
					if ($option == 301) { include ("includes/avisolegal.php");}
					if ($option == 302) { include ("includes/terminosdeuso.php");}
					if ($option == 303) { include ("includes/rrhh.php");}
					if ($option == 304) { include ("includes/ssl.php");}
					if ($option == 700) { include ("includes/elearning.php");}
					if ($funcio <> 0) { include ("mgestion/funcions.php");}

		echo "</td>";
	echo "</tr>";
	if ($veure_peu != 0){
	echo "<tr>";
		echo "<td background=\"images/11.jpg\" height=\"20px\">";
			echo "<font style=\"color : white; padding-left : 5px;\">&copy;2012 Solucions-im.com</font>";
		echo "</td>";
	echo "</tr>";
	}
echo "</table>";
}
?>
</center>

</body>
</html>
