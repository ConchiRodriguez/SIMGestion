<script>
function redireccionar(){
	window.location="index.php?";
}
setTimeout ("redireccionar()", 600000);
</script>
<?PHP
include ("../archivos_comunes/config.php");
#include("../archivos_comunes/functions.php");
#include("../archivos_comunes/funciones.php");

foreach (glob("../sim/auxiliar/*.php") as $filename)
{
    include ($filename);
}

echo "<center><table cellspacing=\"10\" style=\"width:1000px;\">";
	echo "<tr>";
		echo "<td style=\"vertical-align:top;text-align:center\">";
			echo "<table style=\"width:300px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Produccio</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://www.solucions-im.com/web\" target=\"_blank\">Web</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"https://serviciodecorreo.es/\" target=\"_blank\">Mail</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left\"><a href=\"http://77.227.173.151:8080/nagios/\" target=\"_blank\">GhostBuster</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://www.solucions-im.com/sim\" target=\"_blank\">SIMGestion</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"https://www.solucions-im.com/clientes\" target=\"_blank\">Area Clientes</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.net/mediawiki/\" target=\"_blank\">MediaWiki</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.org/foros/nagios/hospitals\" target=\"_blank\">Foro Hospitals</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.com/inicio\" target=\"_blank\">Nova Web</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://op5.solucions-im.com\" target=\"_blank\">blog op5</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://nagios.solucions-im.com\" target=\"_blank\">Blog Nagios</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.monitorizacion.org\" target=\"_blank\">Monitorizacion.org</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.monitoritzacio.org\" target=\"_blank\">Monitoritzacio.org</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.na-cloud.com\" target=\"_blank\">Na-Cloud.com</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://list.monitoritzacio.org/mailman/listinfo/monitoritzacio.org.pymes-colaboracio\" target=\"_blank\">Pymes-colaboracio Info</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://list.monitoritzacio.org/mailman/admin/monitoritzacio.org.pymes-colaboracio\" target=\"_blank\">Pymes-colaboracio Admin</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"\" target=\"_blank\">Forum Monitorització Info</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://list.monitoritzacio.org/mailman/admin/monitoritzacio.org.forum-monitoritzacio\" target=\"_blank\">Forum Monitorització Admin</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://94.125.136.170/naemon/cgi-bin/login.cgi?naemon/\" target=\"_blank\">Demo Naemon</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://94.125.136.174/\" target=\"_blank\">Alicia Server</a></td></tr>";
			echo "</table>";
		echo "</td>";
		echo "<td style=\"vertical-align:top;text-align:center\">";
			echo "<table style=\"width:300px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
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
		echo "<td style=\"vertical-align:top;text-align:center\">";
			echo "<table style=\"width:300px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;font-size: 10px;\">";
				echo "<tr><td><h3>Desenvolupament</h3></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.com/inicio\" target=\"_blank\">Nova Web</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.net/sim\" target=\"_blank\">SIMGestion</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://www.solucions-im.net/clientes\" target=\"_blank\">Area Clientes</a></td></tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr><td><h4>Bases de dades</h4></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qnc882.dbname.net\" target=\"_blank\">SIMGestion</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qqk106.dbname.net\" target=\"_blank\">SIMGestion Desenvolupament</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qpz494.dbname.net\" target=\"_blank\">SIMPolice proves</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qqm138.dbname.net\" target=\"_blank\">SIMPolice CSMS</a></td></tr>";
#				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qqs228.dbname.net\" target=\"_blank\">SIMPolice Can Ruti</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qrn780.dbname.net\" target=\"_blank\">SIMPolice TMB</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qrj446.dbname.net\" target=\"_blank\">SIMPolice SERHS</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qsd905.dbname.net\" target=\"_blank\">SIMPolice Garraf</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qtf064.solucions-im.com\" target=\"_blank\">SIMPolice IN2</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qui471.solucions-im.com\" target=\"_blank\">SIMPolice Leng-D'or</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qui473.solucions-im.com\" target=\"_blank\">SIMPolice SISinf</a></td></tr>";
				echo "<tr><td style=\"vertical-align:top;text-align:left;\"><a href=\"http://qvu498.solucions-im.com\" target=\"_blank\">SIMPolice Mango</a></td></tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
echo "</table></center>";

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");
echo comprobarTipoCliente();
echo calendari_economic(0);
echo correoIncidencias();
#echo calculSLAtotal();
#echo simAlert();


?>