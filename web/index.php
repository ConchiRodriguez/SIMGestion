<?php
include("funcions.php");
if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."");
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "es";
		setcookie("idioma", "".$_GET["i"]."");
	} else { $idioma = $_COOKIE["idioma"]; }
}
if ($_GET["mn"] == "") { $mn = 0; } else { $mn = $_GET["mn"]; }

	if ($idioma == "es"){ include ("sim_web_es.php"); $lengua = "es"; $post = "mn=401&id=285";}
	if ($idioma == "cat"){ include ("sim_web_cat.php"); $lengua = "ca"; $post = "mn=401&id=308";}
	
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
		<title>Solucions-im.com</title>
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

	$url = "www.solucions-im.com/web/";

	
	echo "<table class=\"principal\">";
		echo "<tr class=\"principal_cabezera\">";
			echo "<td class=\"principal_cabezera\">";
				############# INICIO DE LA CABEZERA
				echo "<table class=\"cabezera\">";
					echo "<tr class=\"cabezera\">";
						echo "<td class=\"cabezera_logo\"><a href=\"index.php\"><img src=\"images/logo.jpg\" alt=\"logo\"></a></td>";
						echo "<td class=\"cabezera_menu\">";
							echo "<table class=\"cabezera_menu\">";
								echo "<tr class=\"cabezera_menu\">";
									echo "<td style=\"text-align:left\"><strong>".$Contacto.": 902 787 362</strong></td>";
									echo "<td style=\"text-align:right\">";
									if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat\"><strong>Cat</strong></a> | <a href=\"index.php?i=es\">Es</a>"; }
									if ($idioma == "es") {	echo "<a href=\"index.php?i=cat\">Cat</a> | <a href=\"index.php?i=es\"><strong>Es</strong></a>"; }
									if ($idioma == "en") {	echo "<a href=\"index.php?i=cat\">Cat</a> | <a href=\"index.php?i=es\">Es</a>"; }
									echo "</td>";
								echo "</tr>";
							echo "</table>";
							echo "<table class=\"cabezera_menu\">";
								echo "<tr class=\"cabezera_menu\">";
									$option = "menu";
									if(($mn >= 100) and ($mn<200)) {$option = "menu_select";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=100\" class=\"".$option."\">".$Empresa."</a></td>";
									$option = "menu";
									if(($mn >= 200) and ($mn<300)) {$option = "menu_select";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=200\" class=\"".$option."\">".$Servicios."</a></td>";
									$option = "menu";
									if(($mn >= 300) and ($mn<400)) {$option = "menu_select";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=300\" class=\"".$option."\">".$Productos."</a></td>";
									$option = "menu";
									if(($mn >= 400) and ($mn<500)) {$option = "menu_select";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=400\" class=\"".$option."\">".$Noticias."</a></td>";
									$option = "menu";
									if(($mn >= 500) and ($mn<600)) {$option = "menu_select";}
									echo "<td class=\"".$option."\"><a href=\"index.php?mn=500\" class=\"".$option."\">".$Contacto."</a></td>";
									$option = "menu";
									echo "<td class=\"".$option."\"><a href=\"https://www.solucions-im.com/clientes\" class=\"".$option."\" target=\"_blank\">".$Area_Clientes."</a></td>";
								echo "</tr>";
							echo "</table>";
						#submenu superior
							echo "<table class=\"cabezera_menu\">";
								echo "<tr class=\"cabezera_menu\">";
									if (($mn < 100) or (($mn >= 300) and ($mn < 500)) or ($mn >= 600)) {
										echo "<td style=\"vertical-align:top;text-align:center;font-size:11px;\"><strong>".$Mensage."</strong></td>";
									}
									if (($mn >= 100) and ($mn < 200)) {
										echo "<td class=\"menu_select_empresa\"><a href=\"index.php?mn=110\" class=\"menu_select\">".$Alianzas."</a></td>";
										echo "<td class=\"menu_select_empresa\"><a href=\"index.php?mn=120\" class=\"menu_select\">".$Partners."</a></td>";
										echo "<td class=\"menu_select_empresa\"><a href=\"index.php?mn=130\" class=\"menu_select\">".$Colaboraciones."</a></td>";
										echo "<td class=\"menu_select_empresa\"><a href=\"index.php?mn=150\" class=\"menu_select\">".$Monitorizacion."</a></td>";
									}
									if (($mn >= 200) and ($mn < 300)) {
										echo "<td class=\"menu_select_contacto\"><a href=\"index.php?mn=210\" class=\"menu_select\">".$Prueba_gratis."</a></td>";
										echo "<td class=\"menu_select_contacto\"><a href=\"index.php?mn=220\" class=\"menu_select\">".$Plataforma_24h."</a></td>";
										echo "<td class=\"menu_select_contacto\"><a href=\"index.php?mn=230\" class=\"menu_select\">".$Soluciones_para_pimes."</a></td>";
									}
									if (($mn >= 500) and ($mn < 600)) {
										echo "<td class=\"menu_select_contacto\"><a href=\"index.php?mn=510\" class=\"menu_select\">".$Donde_estamos."</a></td>";
										echo "<td class=\"menu_select_contacto\"><a href=\"index.php?mn=520\" class=\"menu_select\">".$Pide_informacion."</a></td>";
										echo "<td class=\"menu_select_contacto\"><a href=\"index.php?mn=530\" class=\"menu_select\">SIM 2.0</a></td>";
									}
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		###### INICIO FILA CUERPO
		echo "<tr class=\"principal_banner\">";
			echo "<td>";
				echo "<table class=\"cabezera\">";
					echo "<tr class=\"cabezera\">";
						echo "<td class=\"cabezera\">";
						if ($mn == 0) {
							echo "<a href=\"http://www.jornada.solucions-im.com/\"><img src=\"images/inicio/inicio1_".$idioma.".jpg\" alt=\"logo\"></a>";
						} else {
							echo "<a href=\"http://www.jornada.solucions-im.com/\"><img src=\"images/inicio/inicio2_".$idioma.".jpg\" alt=\"logo\"></a>";
						}
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr class=\"principal_cuerpo\">";
			echo "<td>";
				echo "<table width=\"100%;\">";
					echo "<tr>";
					if ($_GET["mn"] == 0){
						echo "<td class=\"cuerpo2\">";
							if ($_GET["mn"] != 230) {echo "<a href=\"index.php?mn=230\"><img src=\"images/sme_solutions_".$idioma.".jpg\" alt=\"logo\"></a><br><br>";}
								echo "<a href=\"index.php?mn=600\"><img src=\"images/demos.jpg\" alt=\"logo\"></a><br><br>";
							if ($_GET["mn"] != 220) {echo "<a href=\"index.php?mn=220\"><img src=\"images/system_24hours_".$idioma.".jpg\" alt=\"logo\"></a><br><br>";}
						echo "</td>";
					}
					if ($_GET["mn"] != 0){
						echo "<td class=\"cuerpo\">";
							if ($_GET["mn"] == 100) {include("menus/menu_empresa_".$idioma.".html");}
							if ($_GET["mn"] == 110) {include("menus/menu_empresa_alianzas_".$idioma.".html");}
							if ($_GET["mn"] == 120) {include("menus/menu_empresa_partner_".$idioma.".html");}
			#				if ($_GET["mn"] == 121) {include("menus/partner-nagios_".$idioma.".php");}
			#				if ($_GET["mn"] == 122) {include("menus/partner-op5_".$idioma.".php");}
							if ($_GET["mn"] == 130) {include("menus/menu_empresa_colaboraciones_".$idioma.".html");}
			#				if ($_GET["mn"] == 140) {include("menus/red_empresarial_".$idioma.".php");}
							if ($_GET["mn"] == 150) {include("menus/menu_monitorizacion_".$idioma.".html");}
							if ($_GET["mn"] == 151) {include("menus/menu_nagios_ti_".$idioma.".html");}
							if ($_GET["mn"] == 152) {include("menus/menu_nagios_app_".$idioma.".html");}
							if ($_GET["mn"] == 153) {include("menus/menu_nagios_ind_".$idioma.".html");}
							if ($_GET["mn"] == 154) {include("menus/menu_nagios_cmdb_".$idioma.".html");}
							if ($_GET["mn"] == 155) {include("menus/menu_nagios_bi_".$idioma.".html");}
							if ($_GET["mn"] == 156) {include("menus/menu_nagios_test_".$idioma.".html");}
							if ($_GET["mn"] == 200) {include("menus/menu_servicios_".$idioma.".html");}
							if ($_GET["mn"] == 210) {include("menus/menu_servicios_piloto.php");}
							if ($_GET["mn"] == 220) {include("menus/menu_servicios_plataforma24.php");}
							if ($_GET["mn"] == 230) {include("menus/menu_pimes_".$idioma.".html");}
							if ($_GET["mn"] == 300) {include("menus/menu_productos_".$idioma.".html");}
							if ($_GET["mn"] == 400) {include("menus/noticias_".$idioma.".php");}
							if ($_GET["mn"] == 401) {include("menus/noticia.php");}
							if (($_GET["mn"] == 500) or ($_GET["mn"] == 520)) {include("menus/menu_contacto_informacion.php");}
							if ($_GET["mn"] == 510) {include("menus/contacto.php");}
							if ($_GET["mn"] == 530) {include("menus/menu_contacto_sim20_".$idioma.".html");}
							if ($_GET["mn"] == 600) {include("menus/demos_".$idioma.".html");}
#							if ($_GET["mn"] == 600) {include("menus/presupuestos.php");}
							if ($_GET["mn"] == 98){include("menus/menu_avisolegal_".$idioma.".html");}
							if ($_GET["mn"] == 99){include("menus/menu_privacidad_".$idioma.".html");}
						}
					if ($_GET["mn"] == 0){
						echo "<td class=\"cuerpo1\">";
							echo "<table class=\"news\">";
								echo "<tr><td></td><td>".$NOTICIAS."</td></tr>";
									$dbhost = "qrg996.dbname.net";
									$dbuname = "qrg996";
									$dbpass = "Solucions69";
									$dbname = "qrg996";
									$dbhandle1 = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
									$db = mysql_select_db($dbname, $dbhandle1) or die("Couldn't open database $myDB");
									if ($idioma == "es") {$tax = 6;} elseif($idioma == "cat") {$tax = 5;}
									$sql = "select * from wp_posts where id in (select object_id from wp_term_relationships where term_taxonomy_id=".$tax.") and post_type='post' and post_status='publish' order by post_date desc limit 0, 5";
									$result = mysql_query($sql, $dbhandle1);
									while ($row = mysql_fetch_array($result)) {
										list($fecha,$hora)=explode(" ",$row["post_date"]);
										List($any,$mes,$dia)=explode("-", $fecha);
										if ($mes == 1) {$mess = "Enero";}
										if ($mes == 2) {$mess = "Febrero";}
										if ($mes == 3) {$mess = "Marzo";}
										if ($mes == 4) {$mess = "Abril";}
										if ($mes == 5) {$mess = "Mayo";}
										if ($mes == 6) {$mess = "Junio";}
										if ($mes == 7) {$mess = "Julio";}
										if ($mes == 8) {$mess = "Agosto";}
										if ($mes == 9) {$mess = "Septiembre";}
										if ($mes == 10) {$mess = "Octubre";}
										if ($mes == 11) {$mess = "Noviembre";}
										if ($mes == 12) {$mess = "Diciembre";}
										echo "<tr>";
											echo "<td class=\"news\">".$mess." ".$any." -&nbsp; </td>";
											echo "<td class=\"news2\"><a href=\"index.php?mn=401&amp;id=".$row["ID"]."\"><strong>".utf8_encode ($row["post_title"])."</strong></a></td>";
										echo "</tr>";
									}
								echo "<tr><td></td><td><a href=\"index.php?mn=401&amp;tax=".$tax."\">".$Leer_todas."</a></td></tr>";
							echo "</table>";
					}
						echo "</td>";
						echo "<td class=\"cuerpo2\">";
							if ($_GET["mn"] != 210) {echo "<a href=\"index.php?mn=210\"><img src=\"images/pilot_test_".$idioma.".jpg\" alt=\"logo\"></a><br><br>";}
							if ($_GET["mn"] != 120){echo "<a href=\"index.php?mn=120\"><img src=\"images/partner_op5.jpg\" alt=\"logo\"></a><br><br>";}
							if ($_GET["mn"] != 120){echo "<a href=\"index.php?mn=120\"><img src=\"images/partner_nagios.jpg\" alt=\"logo\"></a><br><br>";}
							if ($_GET["mn"] != 0){
								if ($_GET["mn"] != 230) { echo "<a href=\"index.php?mn=230\"><img src=\"images/sme_solutions_".$idioma.".jpg\" alt=\"logo\"></a><br><br>";}
								if ($_GET["mn"] != 600) { echo "<a href=\"index.php?mn=600\"><img src=\"images/demos.jpg\" alt=\"logo\"></a><br><br>";}
								if ($_GET["mn"] != 220) {echo "<a href=\"index.php?mn=220\"><img src=\"images/system_24hours_".$idioma.".jpg\" alt=\"logo\"></a><br><br>";}
							}
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
#		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr style=\"height:100px;\">";
			echo "<td>";
				echo "<table class=\"footer\">";
					echo "<tr style=\"height:90px;\">";
						echo "<td style=\"width:250px;vertical-align:top;\">";
							echo "<table style=\"width:200px;\" class=\"footer\">";
								echo "<tr><td><a href=\"index.php?mn=100\" class=\"footer\"><strong>".$Empresa."</strong></a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=110\" class=\"footer\">".$Alianzas."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=120\" class=\"footer\">".$Partners."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=130\" class=\"footer\">".$Colaboraciones."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=150\" class=\"footer\">".$Monitorizacion."</a></td></tr>";
							echo "</table>";
						echo "</td>";
						echo "<td style=\"width:250px;vertical-align:top;\">";
							echo "<table style=\"width:200px;\" class=\"footer\">";
								echo "<tr><td><a href=\"index.php?mn=200\" class=\"footer\"><strong>".$Servicios."</strong></a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=210\" class=\"footer\">".$Prueba_gratis."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=220\" class=\"footer\">".$Plataforma_24h."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=230\" class=\"footer\">".$Soluciones_para_pimes."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=300\" class=\"footer\"><strong>".$Productos."</strong></a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=400\" class=\"footer\"><strong>".$Noticias."</strong></a></td></tr>";
#								echo "<tr><td><a href=\"index.php?mn=230\" class=\"footer\">".$Formacion."</a></td></tr>";
#								echo "<tr><td><a href=\"index.php?mn=240\" class=\"footer\">".$Otros." ".$Servicios."</a></td></tr>";
							echo "</table>";
						echo "</td>";
						echo "<td style=\"width:250px;vertical-align:top;\">";
							echo "<table style=\"width:200px;\" class=\"footer\">";
								echo "<tr><td><a href=\"index.php?mn=500\" class=\"footer\"><strong>".$Contacto."</strong></a></td></tr>";
								echo "<tr><td><strong>902 787 362</strong></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=510\" class=\"footer\">".$Donde_estamos."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=520\" class=\"footer\">".$Pide_informacion."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=530\" class=\"footer\">SIM 2.0</a></td></tr>";
								echo "<tr><td><a href=\"https://www.solucions-im.com/clientes\" target=\"_blank\" class=\"footer\"><strong>".$Area_Clientes."</strong></a></td></tr>";
							echo "</table>";
						echo "</td>";
						echo "<td style=\"width:250px;vertical-align:top;\">";
							echo "<table style=\"width:200px;\" class=\"footer\">";
								echo "<tr>";
									echo "<td><table><tr>";
										echo "<td><a href=\"https://twitter.com/Solucions_im\" target=\"_blank\"><img src=\"images/32x32-twitter.png\" alt=\"twitter\"></a></td>";
										echo "<td><a href=\"https://www.facebook.com/pages/Solucions-Informatiques-Maresme-SLU/384997628255026\" target=\"_blank\"><img src=\"images/32x32-facebook.png\" alt=\"facebook\"></a></td>";
										echo "<td><a href=\"https://www.linkedin.com/company/solucions-informatiques-maresme-slu?trk=cp_followed_name_solucions-informatiques-maresme-slu\" target=\"_blank\"><img src=\"images/32x32-linkedin.png\" alt=\"linkedin\"></a></td>";
										echo "<td><a href=\"https://www.youtube.com/channel/UCB6v5clKL3SdF34VqrnUGTg\" target=\"_blank\"><img src=\"images/32x32-youtube.png\" alt=\"youtube\"></a></td>";
										echo "<td><a href=\"https://www.solucions-im.com/blogs/tecnic/\" target=\"_blank\"><img src=\"images/32x32-wordpress.png\" alt=\"facebook\"></a></td>";
									echo "</tr></table></td>";
								echo "</tr>";
								echo "<tr><td><a href=\"index.php?mn=98\" class=\"footer\">".$Aviso_Legal."</a></td></tr>";
								echo "<tr><td><a href=\"index.php?mn=99\" class=\"footer\">".$Politica_de_privacidad."</a></td></tr>";
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
