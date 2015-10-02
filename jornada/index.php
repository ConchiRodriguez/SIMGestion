<?php
include("funcions.php");
if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."");
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "cat";
		setcookie("idioma", "".$_GET["i"]."");
	} else { $idioma = $_COOKIE["idioma"]; }
}
if ($_GET["mn"] == "") { $mn = 0; } else { $mn = $_GET["mn"]; }

	if ($idioma == "es"){ include ("sim_web_es.php"); $lengua = "es";}
	if ($idioma == "cat"){ include ("sim_web_cat.php"); $lengua = "ca";}
	
#registre de visites al web
	$date = getdate();
	$sql1 = $sql1."	".date("Y-m-d", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
	$sql1 = $sql1."	".date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
	if (version_compare(phpversion(), "4.0.0", ">")) {
		$sql1 = $sql1."	".$_SERVER[REMOTE_ADDR];
		$sql1 = $sql1."	".$_SERVER[HTTP_USER_AGENT];
			$x = $_SERVER[PHP_SELF];
			if ($_SERVER[QUERY_STRING] != "") { $x = $x."?".$_SERVER[QUERY_STRING]; }
		$sql1 = $sql1."	".$x;
		$sql1 = $sql1."	".$_SERVER[HTTP_REFERER];
	}
	if (version_compare(phpversion(), "4.0.1", "<")) {
		$sql1 = $sql1."	".$HTTP_SERVER_VARS[REMOTE_ADDR];
		$sql1 = $sql1."	".$HTTP_SERVER_VARS[HTTP_USER_AGENT];
			$x = $HTTP_SERVER_VARS[PHP_SELF];
			if ($HTTP_SERVER_VARS[QUERY_STRING] != "") { $x = $x."?".$HTTP_SERVER_VARS[QUERY_STRING]; }
		$sql1 = $sql1."	".$x;
		$sql1 = $sql1."	".$HTTP_SERVER_VARS[HTTP_REFERER];
	}

	if (!$gestor = fopen("reg_acces_web.txt", "a+")) { echo "No se pueden grabar los datos de registro de accesos."; }
	if (fwrite($gestor, $sql1.Chr(13)) === FALSE) { echo "Cannot write to file reg_acces_web.txt"; }


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
	<head>
		<title>III Jornada</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
		<meta name="keywords" content="monitorizacion,nagios,monitoring,monitor,nagios XI,solucions-im,naemon,op5" >
		<meta name="description" content="servicios profesionales de monitorizacion con nagios, consultoria, backup, formacion, gestion de incidencias, auditoria">
		<meta name="geo.position" content="41.695637,2.714969">
		<meta name="DC.title" content="Solucions-im.com" >
		<meta name="DC.creator" content="Solucions-im.com" >
		<meta name="DC.Type" content="website" >
		<meta name=”twitter:site” content=”@Solucions_im”>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="https://www.solucions-im.com/web/favicon.ico" type="image/x-icon">
		<div id="fb-root"></div>
		<script type="text/javascript">
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}
		(document, 'script', 'facebook-jssdk'));
		</script>
		<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-41958413-3', 'auto');
			ga('send', 'pageview');

		</script>
<body>
<?php
	echo "<table class=\"principal\">";
		############# INICIO DE LA CABEZERA
		echo "<tr class=\"principal_cabezera\">";
			echo "<td class=\"principal_cabezera\">";
				echo "<table class=\"cabezera\">";
					echo "<tr class=\"cabezera\">";
						echo "<td class=\"cabezera_logo\"><a href=\"index.php\"><img src=\"images/logo.jpg\" alt=\"logo\"></a></td>";
						echo "<td class=\"cabezera_menu\">";
							echo "<table class=\"cabezera_menu\">";
								echo "<tr>";
									echo "<td style=\"text-align:right\" colspan=\"5\">";
									if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat\"><strong>Cat</strong></a> | <a href=\"index.php?i=es\">Es</a>"; }
									if ($idioma == "es") {	echo "<a href=\"index.php?i=cat\">Cat</a> | <a href=\"index.php?i=es\"><strong>Es</strong></a>"; }
									if ($idioma == "en") {	echo "<a href=\"index.php?i=cat\">Cat</a> | <a href=\"index.php?i=es\">Es</a>"; }
									echo "</td>";
								echo "</tr>";
								echo "<tr>";
									if($mn == 0) {$option = "menu_select";} else {$option = "menu";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=0\" class=\"".$option."\">".$Programa."</a></td>";
									if($mn == 10) {$option = "menu_select";} else {$option = "menu";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=10\" class=\"".$option."\">".$Inscripcion."</a></td>";
									if($mn == 20) {$option = "menu_select";} else {$option = "menu";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=20\" class=\"".$option."\">".$Patrocinadores."</a></td>";
									if($mn == 30) {$option = "menu_select";} else {$option = "menu";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=30\" class=\"".$option."\">".$Ubicacion."</a></td>";
									if($mn == 40) {$option = "menu_select";} else {$option = "menu";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=40\" class=\"".$option."\">".$Descargas."</a></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		###### INICIO CUERPO
		echo "<tr class=\"principal_banner\">";
			echo "<td>";
				echo "<table class=\"cabezera\">";
					echo "<tr class=\"cabezera\">";
						echo "<td class=\"cabezera\"><img src=\"images/inicio_".$idioma.".jpg\" alt=\"logo\"></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr class=\"principal_cuerpo\">";
			echo "<td>";
				echo "<table class=\"cabezera\">";
					echo "<tr class=\"cabezera\">";
						echo "<td class=\"cuerpo\">";
							if ($_GET["mn"] == 0) {include("menus/menu_programa.php");}
							if ($_GET["mn"] == 10) {include("menus/menu_inscripcion.php");}
							if ($_GET["mn"] == 20) {include("menus/menu_patrocinadores.php");}
							if ($_GET["mn"] == 30) {include("menus/menu_ubicacion.php");}
							if ($_GET["mn"] == 40) {include("menus/menu_descargas.php");}
							if ($_GET["mn"] == 98){include("menus/menu_avisolegal_".$idioma.".html");}
							if ($_GET["mn"] == 99){include("menus/menu_privacidad_".$idioma.".html");}
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
#		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr class=\"principal_footer\">";
			echo "<td>";
				echo "<table class=\"footer\">";
					echo "<tr>";
						echo "<td class=\"footer\">";
							echo "<table class=\"footer\" cellspacing=\"15px\">";
								echo "<tr><td class=\"footer2\"><a href=\"index.php?mn=0\" class=\"footer\"><strong>".$Inscripcion."</strong></a></td>";
								echo "<td class=\"footer2\"><a href=\"index.php?mn=10\" class=\"footer\"><strong>".$Programa."</strong></a></td>";
								echo "<td class=\"footer2\"><a href=\"index.php?mn=20\" class=\"footer\"><strong>".$Patrocinadores."</strong></a></td>";
								echo "<td class=\"footer2\"><a href=\"index.php?mn=30\" class=\"footer\"><strong>".$Ubicacion."</strong></a></td>";
								echo "<td class=\"footer2\"><a href=\"index.php?mn=40\" class=\"footer\"><strong>".$Descargas."</strong></a></td>";
								echo "<td class=\"footer2\"><a href=\"index.php?mn=98\" class=\"footer\">".$Aviso_Legal."</a></td>";
								echo "<td class=\"footer2\"><a href=\"index.php?mn=99\" class=\"footer\">".$Politica_de_privacidad."</a></td></tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<center><table width=\"20%\">";
					echo "<tr>";
						echo "<td><a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img style=\"border:0\" src=\"images/W3Ccss.gif\" alt=\"CSS Valido!\"></a></td>";
						echo "<td><a href=\"http://validator.w3.org/check?uri=referer\"><img src=\"images/W3Cxhtml.gif\" alt=\"Valid HTML 4.01 Transitional\"></a></td>";
					echo "</tr>";
				echo "</table></center>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";

	?>
</body>
</html>
