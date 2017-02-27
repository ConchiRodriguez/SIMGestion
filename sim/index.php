<?php
#32599E antiguo color
$user = false;
$userid = 0;
$sgm = 0;

error_reporting(E_ALL);
date_default_timezone_set('Europe/Madrid');

include ("config.php");

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

foreach (glob("auxiliar/*.php") as $filename)
{
    include ($filename);
}

foreach (glob("pantallas/*.php") as $filename2)
{
    include ($filename2);
}

if ($_GET['op'] != "") { $option = $_GET['op']; } else { $option = 0; }
if ($_GET['sop'] != "") { $soption = $_GET['sop']; } else { $soption = 0; }
if ($_GET['ssop'] != "") { $ssoption = $_GET['ssop']; } else { $ssoption = 0; }

if ($soption == 666) {
	setcookie("musername", "", time()-1, $url_raiz, $domain);
	setcookie("mpassword", "", time()-1, $url_raiz, $domain);
	unset($_COOKIE["musername"]); 
	unset($_COOKIE["mpassword"]); 
	header("Location: ".$urlmgestion);
}

if ($option == 667) {
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, $url_raiz, $domain);
	header("Location: ".$urlmgestion);
}


if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, $url_raiz, $domain);
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "es";
		setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, $url_raiz, $domain);
	} else { $idioma = $_COOKIE["idioma"]; }
}

if ($idioma == "es"){ include ("sgm_es.php");}
if ($idioma == "cat"){ include ("sgm_cat.php");}

if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='".$_POST["user"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if (crypt($_POST["pass"], $row["pass"]) == $row["pass"]){
				$user = true;
				$username = $row["usuario"];
				$userid = $row["id"];
				$sgm = $row["sgm"];
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, $url_raiz, $domain);
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, $url_raiz, $domain);
				header("Location: ".$urlmgestion."/index.php?op=200");
			}
		}
	}
	if ($_GET["idp"] != "") {
		$sql = "select * from sgm_users WHERE validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)){
			if ($_GET["idp"] == $row["pass"]){
				$user = true;
				$username = $row["usuario"];
				$userid = $row["id"];
				$sgm = $row["sgm"];
				setcookie("musername", $row["usuario"], time()+60*$cookiestime, $url_raiz, $domain);
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, $url_raiz, $domain);
				header("Location: ".$urlmgestion."/index.php?op=200&sop=70");
			}
		}
	}
} else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysqli_query($dbhandle,convertSQL($sql));
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
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, $url_raiz, $domain);
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, $url_raiz, $domain);
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
		<title>SIMGESTION DES</title>

		<?php include ("functions-js.php"); ?>
  </head>
<body>
<center>
<?php 
if ($option == 1000) {
	include ("mgestion/gestion-incidencias-notificaciones.php");
} else {
	echo "<table class=\"maestra\">";
		echo "<tr>";
			echo "<td class=\"maestra\">";
				echo "<table style=\"width:100%;\"><tr>";
#				echo "<table border=1><tr>";
					echo "<td style=\"color:white;width:210px;\">";
						if ($user == true) {
							echo "<strong>".$Bienvenido." <strong>".$username." (".$userid.")</strong>";
						} else {
							echo "<a href=\"index.php?op=100\" style=\"color:white;\"><strong>[ ".$Identificarse." ]</strong></a>";
						}
#						echo "&nbsp;&nbsp;&nbsp;&nbsp; <strong>".date("d/m/Y")."&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i")."</strong>";
					echo "</td>";
					echo "<td style=\"color:white;width:1100px;\">";
					if ($sgm == 1) {
						echo "<ul class=\"menu1\">";
							echo "<li><a href=\"index.php?op=200\">".$Panel_usuario."</a>";
							$sqlu = "select * from sgm_users where id=".$userid;
							$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
							$rowu = mysqli_fetch_array($resultu);
								if ($rowu["sgm"] == 1) {
									$sqlmg = "select * from sgm_users_permisos_modulos_grupos where visible=1 order by nombre_".$idioma;
									$resultmg = mysqli_query($dbhandle,convertSQL($sqlmg));
									while ($rowmg = mysqli_fetch_array($resultmg)) {

										echo "<li><a href=\"#\">".$rowmg["nombre_".$idioma]."</a>";
											echo "<ul>";
												$sqlm = "select * from sgm_users_permisos_modulos where visible=1 and id_grupo=".$rowmg["id"]." order by nombre_".$idioma;
												$resultm = mysqli_query($dbhandle,convertSQL($sqlm));
												while ($rowm = mysqli_fetch_array($resultm)) {
													echo "<li><a href=\"index.php?op=".$rowm["id_modulo"]."\">".$rowm["nombre_".$idioma]."</a></li>";
												}
											echo "</ul>";
										echo "</li>";
									}
								}
						echo "</ul>";
					}
					echo "</td>";
					echo "<td style=\"vertical-align:middle;text-align:center;width:250px;\" nowrap>";
					if ($sgm == 1) {
						echo "<form method=get action=\"http://www.google.com/search\" target=\"_blank\">";
						echo "<input type=\"text\" name=\"q\" style=\"width:150px\" value=\"\" autofocus>";
						echo "<input type=\"hidden\" name=\"hl\" value=\"es\">";
						echo "<input type=\"submit\" name=\"btnG\" value=\"".$Busqueda." Google\" style=\"width:100px\">";
						echo "</form>";
					}
					echo "</td>";
				if ($sgm == 1) {
					echo "<td style=\"width:30px;\">";
						echo "<a href=\"index.php?op=1008&sop=100\"><img src=\"mgestion/pics/icons-mini/group_add.png\" alt=\"Cliente\" title=\"".$Anadir." ".$Cliente."\" border=\"0\"></a>";
					echo "</td>";
					echo "<td style=\"width:30px;\">";
						echo "<a href=\"index.php?op=1018&sop=100&id_entrada=1\"><img src=\"mgestion/pics/icons-mini/telephone.png\" alt=\"Telefono\" title=\"".$Incidencia." ".$Telefono."\" border=\"0\"></a>";
					echo "</td>";
				}
					echo "<td style=\"color:white;width:60px;\">";
						if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat\" style=\"color:white;\"><strong>Cat</strong></a> | <a href=\"index.php?i=es\" style=\"color:white;\">Es</a>"; }
						if ($idioma == "es") {	echo "<a href=\"index.php?i=cat\" style=\"color:white;\">Cat</a> | <a href=\"index.php?i=es\" style=\"color:white;\"><strong>Es</strong></a>"; }
					echo "</td>";
					echo "<td style=\"width:30px;\">";
						echo "<a href=\"index.php?sop=666\"><img src=\"mgestion/pics/icons-mini/door_out.png\" alt=\"Logout\" title=\"".$Salir."\" border=\"0\"></a>";
					echo "</td>";
				echo "</tr></table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td  class=\"maestra2\">";
				$veure_peu = 1;
				include ("mgestion/indice.php");
#				if ($option == 0) { }
			echo "</td>";
		echo "</tr>";
#		if ($veure_peu != 0){
		echo "<tr>";
			echo "<td class=\"maestra\" style=\"color:white;\">&copy;".date('Y')." Solucions-im.com</td>";
		echo "</tr>";
#		}
	echo "</table>";

#	$errors= error_get_last();
#	echo "COPY ERROR: ".$errors['type'];
#	echo "<br />\n".$errors['message'];
#	var_dump($errors);

}
?>
</center>
</body>
</html>
<?php
	// Cerrar la conexión
	mysql_close($dbhandle);
?>
