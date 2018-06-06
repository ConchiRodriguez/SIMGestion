<?php

error_reporting(~E_ALL);
#date_default_timezone_set('Europe/Paris');

include ("config.php");

foreach (glob("../sim/auxiliar/*.php") as $filename)
{
    include ($filename);
}

foreach (glob("../sim/pantallas/*.php") as $filename2)
{
    include ($filename2);
}

#include ("functions.php");
#include ("../archivos_comunes/funciones.php");
#if(!isset($HTTP_SERVER_VARS[HTTPS])) { header("Location: ".$urlclientes); }

#	$basededatos = "MSSQL";
	$basededatos = "MYSQL";

### CONEXION
#$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass, true) or die("Couldn't connect to SQL Server on $dbhost");
#$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");
mysqli_set_charset($dbhandle,"utf8");

if ($_GET['op'] != "") { $option = $_GET['op']; } else { $option = 0; }
if ($_GET['sop'] != "") { $soption = $_GET['sop']; } else { $soption = 0; }
if ($_GET['ssop'] != "") { $ssoption = $_GET['ssop']; } else { $ssoption = 0; }
if ($_GET['idioma'] != "") { $idioma = $_GET['dir']; } else { $idioma = "es"; }

$user = false;
$userid = 0;

if ($option == 667) {
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/clientes", $domain);
	header("Location: ".$urlclientes);
}


if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/clientes", $domain);
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "es";
		setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, "/clientes", $domain);
	} else { $idioma = $_COOKIE["idioma"]; }
}

if ($idioma == "es"){ include ("../sim/sgm_es.php");}
if ($idioma == "cat"){ include ("../sim/sgm_cat.php");}

if ($soption == 666) {
	if ($ssoption == 1) {
		$sql = "update sgm_users set ";
		if (($_POST["pass1"] == $_POST["pass2"]) AND ($_POST["pass1"] != "")) {
			$contrasena = crypt($_POST["pass1"]);
			$sql = $sql."pass='".$contrasena."'";
		} else {
			echo $ErrorPass;
		}
		$sql = $sql.", mail='".$_POST["mail"]."'";
		$sql = $sql." WHERE id=".$_POST["id_user"]."";
		mysqli_query($dbhandle,convertSQL($sql));
	}
	setcookie("musername", "", time()-1, "/clientes");
	setcookie("mpassword", "", time()-1, "/clientes");
	unset($_COOKIE["musername"]); 
	unset($_COOKIE["mpassword"]); 
	header("Location: ".$urlclientes."/logout.php");
}

if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
#			if ($row["pass"] == $_POST["pass"]) {
			if (crypt($_POST["pass"], $row["pass"]) == $row["pass"]){
				$user = true;
				$username = $row["usuario"];
				$userid = $row["id"];
				$sgm = $row["sgm"];
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, "/clientes");
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/clientes");
				header("Location: ".$urlclientes."/index.php?op=200");
			}
		}
	}
} else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysqli_query($dbhandle,$sql);
	$row = mysqli_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["pass"] == $_COOKIE["mpassword"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, "/clientes");
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/clientes");
		}
	}
}

lopd($userid,$username,$option,$soption);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<link rel="stylesheet" href="../sim/style.css" type="text/css">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			<title>Area Clientes Solucions-IM</title>
		<?php include ("../sim/functions-js.php"); ?>
	</head>
<body>
<center>
<?php 
	echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\" width=\"1250\">";
		echo "<tr>";
			echo "<td style=\"height:20px; width:1250; background-color:grey; \"><font style=\"color : white; padding-left : 5px;\">";
				if ($user == true) {
					echo $Area." ".$Clientes." - ".$Bienvenido." <strong>".$username."</strong>";
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
			echo "</font></td>";
		echo "</tr><tr>";
			echo "<td style=\"border-left : 0px solid Silver; border-right : 0px solid Silver; padding-left:1px; padding-right:1px; padding-top:1px;text-align:justify;height:100%;vertical-align:top;\">";
#		if ($sgm == 1) {
		if ($user == true) {
			if ($option <> 0) {
				$sqlmodulo = "select * from sgm_users_permisos_modulos where id_modulo=".$option;
				$resultmodulo = mysqli_query($dbhandle,convertSQL($sqlmodulo));
				$rowmodulo = mysqli_fetch_array($resultmodulo);
				$id_grupo = $rowmodulo["id_grupo"];
			} else {
				$id_grupo = $_GET["id_grupo"];
			}

			echo "<center><table cellpadding=\"0\" cellspacing=\"1\"><tr>";
				$sqluser = "select * from sgm_users WHERE id=".$userid;
				$resultuser = mysqli_query($dbhandle,convertSQL($sqluser));
				$rowuser = mysqli_fetch_array($resultuser);
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;\">";
					if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat&op=200&sop=0&id=".$rowuser["id"]."\"><strong>Cat</strong></a> | <a href=\"index.php?i=es&op=200&sop=0&id=".$rowuser["id"]."\">Es</a>"; }
					if ($idioma == "es") {	echo "<a href=\"index.php?i=cat&op=200&sop=0&id=".$rowuser["id"]."\">Cat</a> | <a href=\"index.php?i=es&op=200&sop=0&id=".$rowuser["id"]."\"><strong>Es</strong></a>"; }
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=0&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/go-home-10.png\" style=\"border:0px;\"><br>".$Inicio."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=70&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-process-own.png\" style=\"border:0px;\"><br>".$Datos." ".$Usuario."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=20&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-process-users.png\" style=\"border:0px;\"><br>".$Anadir." ".$Usuarios."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=50&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/toggle_log.png\" style=\"border:0px;\"><br>".$Datos." ".$Empresa."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=30&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/accessories-calculator-4.png\" style=\"border:0px;\"><br>".$Facturacion."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=10&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-close.png\" style=\"border:0px;\"><br>".$Contratos."</a>";
				echo "</td>";
#				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
#					echo "<a href=\"index.php?op=200&sop=80&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-file-columns.png\" style=\"border:0px;\"><br>".$Proyectos."</a>";
#				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=40&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-pim-tasks.png\" style=\"border:0px;\"><br>".$Incidencias."</a>";
				echo "</td>";
#				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
#					echo "<a href=\"index.php?op=200&sop=90&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-nofullscreen.png\" style=\"border:0px;\"><br>".$Estado." ".$Servidor."</a>";
#				echo "</td>";
#				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
#					echo "<a href=\"index.php?op=200&sop=100&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/view-pim-news.png\" style=\"border:0px;\"><br>".$Reports."</a>";
#				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=110&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/document-open-4.png\" style=\"border:0px;\"><br>".$Documentos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?op=200&sop=60&id=".$rowuser["id"]."\" style=\"text-decoration: none;\"><img src=\"images/icons/kgpg_show.png\" style=\"border:0px;\"><br>".$Contrasenas."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:bottom;\">";
					echo "<a href=\"index.php?sop=666\" style=\"text-decoration: none;\"><img src=\"images/icons/system-log-out-3.png\" style=\"border:0px;\"><br>".$Salir."</a>";
				echo "</td>";
			echo "</tr></table></center>";
		}

##			if ($option == 0) {
				echo "<center><table cellpadding=\"0\" cellspacing=\"1\"><tr>";
					$sqlm = "select * from sgm_users_permisos_modulos where visible=1 and id_grupo=".$id_grupo." order by nombre";
					$resultm = mysqli_query($dbhandle,convertSQL($sqlm));
					while ($rowm = mysqli_fetch_array($resultm)) {
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
		echo "</td>";
	echo "</tr><tr>";
		echo "<td style=\"border-left : 0px solid Silver; border-right : 0px solid Silver; padding-left:1px; padding-right:1px; padding-top:1px;text-align:justify;height:100%;vertical-align:top;\">";
			if ($option == 0) {
				echo "<br><br><center><a href=\"index.php?op=100\" style=\"text-decoration: none;\"><img src=\"images/area_cliente.jpg\" style=\"border:0px;\"></a></center><br><br>";
			}
			if ($option == 100) {
				echo "<strong>".$Acceso." ".$Cliente."</strong>";
				echo "<br><br><br>";
				echo "<center>";
					echo "<table cellpadding=\"0\">";
					echo "<form method=\"post\" action=\"index.php\">";
					echo "<tr><td><font class=\"tahomagrey\"><strong>Usuario</strong></font></td>";
					echo "<td><input type=\"Text\" name=\"user\" maxlength=\"100\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
					echo "<tr><td><font class=\"tahomagrey\"><strong>Password</strong></font></td>";
					echo "<td><input type=\"Password\" name=\"pass\" maxlength=\"100\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
					echo "<tr><td></td><td><input type=\"Submit\" value=\"Entrar\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
					echo "</form>";
					echo "</table>";
				echo "</center>";
				echo "<br><br><br>";
			}
			if ($option == 200) { include ("mgestion/user.php");}
		echo "</td>";
	echo "</tr><tr>";
		echo "<td style=\"text-align:center;\">".$Horario." ".$Atencion." ".$Cliente." : <strong>9h.</strong> a <strong>17h.</strong> de <strong>".$Lunes."</strong> a <strong>".$Viernes."</strong>. ".$Soporte." : <strong>soporte@solucions-im.com</strong>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"https://twitter.com/Solucions_im\" target=\"_blank\" name=\"@solucions_im\">@solucions_im</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"https://www.facebook.com/pages/Solucions-Informatiques-Maresme-SLU/384997628255026\" target=\"_blank\" name=\"facebook\">Facebook</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"http://www.solucions-im.com/blogs/tecnic/\" target=\"_blank\" name=\"blog\">Blog</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"http://www.solucions-im.com\" target=\"_blank\" name=\"blog\">www.solucions-im.com</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"http://www.nagios.org\" target=\"_blank\" name=\"blog\">Nagios.org</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"http://www.nagios.com\" target=\"_blank\" name=\"blog\">Nagios.com</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"http://www.nagios-es.org\" target=\"_blank\" name=\"blog\">Nagios-es.org</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href=\"https://www.op5.com\" target=\"_blank\" name=\"blog\">op5.com</a></td>";
	echo "</tr><tr><td>&nbsp;</td></tr><tr>";
		echo "<td style=\"height:20px;width:1250px;background-color:grey;color:white;padding-left:5px;text-align:center;\">&copy;".date("Y")." Solucions-im.com</td>";
	echo "</tr>";
echo "</table>";


?>
<div id="thawteseal" style="text-align:center;" title="Click to Verify - This site chose Thawte SSL for secure e-commerce and confidential communications.">
<div><a href="http://www.thawte.com/ssl-certificates/" target="_blank" style="color:#000000; text-decoration:none; font:bold 10px arial,sans-serif; margin:0px; padding:0px;">ABOUT SSL CERTIFICATES</a></div>
</div>
</center>

</body>
</html>
