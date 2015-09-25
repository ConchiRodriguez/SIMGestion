<?php
error_reporting(~E_ALL);
date_default_timezone_set('Europe/Madrid');

### BUSCA SI ES UNA IP LOCAL
$accesolocal = true;
$ip = $_SERVER['REMOTE_ADDR'];
$subxarxa = "192.168.1.";
$x = 0;
for ($x = 0 ; $x < strlen($subxarxa) ; $x++) {
	if ($ip[$x] != $subxarxa[$x]) { $accesolocal = false ; }
}

if ($accesolocal == true) {	include ("../archivos_comunes/config.php"); }
if ($accesolocal == false) { include ("../archivos_comunes/config2.php"); }

include ("../archivos_comunes/variables.php");
include ("../archivos_comunes/functions.php");
include ("../archivos_comunes/funciones.php");
include ("../archivos_comunes/funciones_modificadoras.php");
#if(!isset($HTTP_SERVER_VARS[HTTPS])) { header("Location: ".$urlmgestion); }

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
	setcookie("musername", "", time()-1, "/sim");
	setcookie("mpassword", "", time()-1, "/sim");
	unset($_COOKIE["musername"]); 
	unset($_COOKIE["mpassword"]); 
	header("Location: ".$urlmgestion."/logout.php");
}

if ($option == 667) {
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/sim", $domain);
	header("Location: ".$urlmgestion);
}


if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/sim", $domain);
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "es";
		setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/sim", $domain);
	} else { $idioma = $_COOKIE["idioma"]; }
}

if ($idioma == "es"){ include ("../archivos_comunes/sgm_es.php");}
if ($idioma == "cat"){ include ("../archivos_comunes/sgm_cat.php");}

#include ("mgestion/funciones.php");

if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if (crypt($_POST["pass"], $row["pass"]) == $row["pass"]){
				$user = true;
				$username = $row["usuario"];
				$userid = $row["id"];
				$sgm = $row["sgm"];
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, "/sim");
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/sim");
				header("Location: ".$urlmgestion."/index.php?op=200");
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
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, "/sim");
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/sim");
		}
	}
}

lopd($userid,$username,$option,$soption);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>SIMGESTION 3.0</title>

		<?php include ("auxiliar/functions-js.php"); ?>
		<script>
		function desplegableCombinado(){
			if (document.getElementById('id_servicio2').value!=0){document.getElementById('id_cliente').value=0;}
			if (document.getElementById('id_cliente').value!=0){document.getElementById('id_cliente').value=0;}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado2(){
			if (document.getElementById('id_cliente').value!=0){document.getElementById('id_servicio').value=0;}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado3($service2){
			if ($service2!=0){document.getElementById('id_servicio').value=0;}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado5(){
			document.forms.form2.action='';
			document.forms.form2.target='';
			document.forms.form2.method='POST';
			document.forms.form2.submit();
		}

		</script>
	</head>
<body>
<center>
<?php 
if (($option == 800) or ($option == 900) or ($option == 600)) {
	include ("mgestion/lenguajes/help-es.php");
	include ("mgestion/help/mail.php");
	include ("mgestion/gestion-articulos-etiqueta-print.php");
} else {

echo "<table class=\"maestra\">";
	echo "<tr>";
		echo "<td class=\"maestra\">";
			echo "<table style=\"width:100%;\"><tr>";
				echo "<td style=\"color:white;width:90%;\">";
					if ($user == true) {
						echo $Bienvenido." <strong>".$username."</strong>&nbsp;&nbsp;(id.<strong>".$userid.")</strong>";
					} else {
						echo "<a href=\"index.php?op=100\" style=\"color : white;\"><strong>[ ".$Identificarse." ]</strong></a>";
					}
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<strong>".date("d/m/Y")."&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i")."</strong>";
			echo "</td>";
			echo "<td style=\"color:white;width:5%;\">";
				if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat\" style=\"color : white;\"><strong>Cat</strong></a> | <a href=\"index.php?i=es\" style=\"color : white;\">Es</a>"; }
				if ($idioma == "es") {	echo "<a href=\"index.php?i=cat\" style=\"color : white;\">Cat</a> | <a href=\"index.php?i=es\" style=\"color : white;\"><strong>Es</strong></a>"; }
			echo "</td>";
			echo "<td style=\"width:5%;text-align:right;vertical-align:middle;\"><a href=\"index.php?sop=666\"  style=\"color : white;\">[".$Salir."]</a></td>";
			echo "</tr></table>";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td colspan=\"3\" style\"border-left : 0px solid Silver; border-right : 0px solid Silver; padding-left:1px; padding-right:1px; padding-top:1px;text-align:justify;vertical-align:top;\">";

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
				if ($option == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=0\" class=".$class.">".$Panel_usuario."</a></td>";
				$sqlu = "select * from sgm_users where id=".$userid;
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
					if ($rowu["sgm"] == 1) {
						$sqlm = "select * from sgm_users_permisos_modulos_grupos where visible=1 order by nombre";
						$resultm = mysql_query(convert_sql($sqlm));
						while ($rowm = mysql_fetch_array($resultm)) {
							if ($rowm["id"] == $id_grupo) {$class = "menu_select";} else {$class = "menu";}
							echo "<td class=".$class."><a href=\"index.php?id_grupo=".$rowm["id"]."\" class=".$class.">".$rowm["nombre"]."</a></td>";
						}
					}
			echo "</tr></table></center>";

##			if ($option == 0) {
				echo "<center><table cellpadding=\"0\" cellspacing=\"1\"><tr>";
					$sqlm = "select * from sgm_users_permisos_modulos where visible=1 and id_grupo=".$id_grupo." order by nombre";
					$resultm = mysql_query(convert_sql($sqlm));
					while ($rowm = mysql_fetch_array($resultm)) {
							if ($rowm["id_modulo"] == $option) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=".$rowm["id_modulo"]."\" class=".$class.">".$rowm["nombre"]."</a></td>";
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
					if ($option == 5) { include ("includes/encriptar.php");}
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
		echo "<td class=\"maestra\">";
			echo "<font style=\"color : white; padding-left : 5px;\">&copy;2015 Solucions-im.com</font>";
		echo "</td>";
	echo "</tr>";
	}
echo "</table>";
}
?>
</center>

</body>
</html>
<?php
	// Cerrar la conexión
	mysql_close($dbhandle);
?>