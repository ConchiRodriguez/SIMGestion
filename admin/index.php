<script>
function redireccionar(){
	window.location="index.php?";
}
setTimeout ("redireccionar()", 600000);
</script>
<?PHP
include ("../sim/config.php");

foreach (glob("../sim/auxiliar/*.php") as $filename)
{
    include ($filename);
}
foreach (glob("../sim/pantallas/*.php") as $filename)
{
    include ($filename);
}

echo "<center><table cellspacing=\"10\" cellpadding=\"0\" style=\"width:85%;margin-left:auto;margin-right:auto;\">";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr>";
		echo "<td style=\"vertical-align:top;text-align:center\" colspan=\"5\">";
			echo "<form method=get action=\"http://www.google.com/search\" target=\"_blank\">";
			echo "<input type=\"text\" name=\"q\" size=\"50\" maxlength=\"250px\" value=\"\" autofocus>";
			echo "<input type=\"hidden\" name=\"hl\" value=\"es\">";
			echo "<input type=\"submit\" name=\"btnG\" value=\"Buscar\">";
			echo "</form>";
		echo "</td>";
	echo "</tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr>";
		echo "<td style=\"vertical-align:top;text-align:center;width:15%;\">";
			echo "<table style=\"font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Produccio</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://www.solucions-im.com/web\" target=\"_blank\">Web</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://serviciodecorreo.es/\" target=\"_blank\">Mail Arsys</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://outlook.office365.com/owa/\" target=\"_blank\">Mail Office 365</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://solucionsim.sharepoint.com/SitePages/Inicio.aspx\" target=\"_blank\">Gestor Documental</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
#				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"http://77.227.173.151:8080/nagios/\" target=\"_blank\">GhostBuster</a></td></tr>";
#				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://www.solucions-im.com/sim\" target=\"_blank\">SIMGestion</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://www.solucions-im.com/clientes\" target=\"_blank\">Area Clientes</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://172.30.16.20/faqs/\" target=\"_blank\">PHPmyFAQ</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://op5.solucions-im.com\" target=\"_blank\">Blog op5</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://nagios.solucions-im.com\" target=\"_blank\">Blog Nagios</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://jornada.solucions-im.com\" target=\"_blank\">Web Jornada</a></td></tr>";
			echo "</table>";
		echo "</td>";
		echo "<td style=\"vertical-align:top;text-align:center;width:15%;\">";
			echo "<table style=\"font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Xarxes Socials</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://www.facebook.com/pages/Solucions-Informatiques-Maresme-SLU/384997628255026\" target=\"_blank\">Facebook</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://twitter.com/Solucions_im\" target=\"_blank\">Twitter @Solucions_im</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://twitter.com/SIM_technical\" target=\"_blank\">Twitter @SIM_technical</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"http://www.linkedin.com/company/solucions-informatiques-maresme-slu?trk=cp_followed_name_solucions-informatiques-maresme-slu\" target=\"_blank\">Linkedin</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://www.solucions-im.com/blogs/tecnic/\" target=\"_blank\">Blog Tecnic</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://www.solucions-im.com/blogs/news/\" target=\"_blank\">Blog Noticies</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"http://www.youtube.com/channel/UCB6v5clKL3SdF34VqrnUGTg\" target=\"_blank\">youtube</a></td></tr>";
			echo "</table>";
		echo "</td>";
		echo "<td style=\"vertical-align:top;text-align:center;width:15%;\">";
			echo "<table style=\"font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Desenvolupament</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.net/sim\" target=\"_blank\">SIMGestion DES</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.com/sim_pre\" target=\"_blank\">SIMGestion PRE</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.net/clientes\" target=\"_blank\">Area Clientes</a></td></tr>";
			echo "</table>";
		echo "</td>";
		echo "<td style=\"vertical-align:top;text-align:center;width:15%;\">";
			echo "<table style=\"font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Bases de dades</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://qnc882.dbname.net\" target=\"_blank\">SIMGestion PRO</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://qqk106.dbname.net\" target=\"_blank\">SIMGestion DES</a></td></tr>";
			echo "</table>";
		echo "</td>";
		echo "<td style=\"vertical-align:top;text-align:center;width:15%;\">";
			echo "<table style=\"font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Labs</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://212.36.69.125/nagios/\" target=\"_blank\">Cerberus Nagios</a></td></tr>";
#				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://172.30.16.16\" target=\"_blank\">Atlas Splunk</a></td></tr>";
#				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://172.30.16.18\" target=\"_blank\">Tea SIMges</a></td></tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
echo "</table></center>";

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");
#echo calendari_economic(0);
echo correoIncidencias();
#echo comprobarTipoCliente();
echo calculSLAtotal();
#echo simAlert();


?>