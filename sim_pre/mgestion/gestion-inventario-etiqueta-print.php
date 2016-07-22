<?php 
error_reporting(~E_ALL);
#date_default_timezone_set('Europe/Paris');

include ("../../archivos_comunes/config.php");
include ("../../archivos_comunes/functions.php");
include ("../../archivos_comunes/sgm_es.php");

### CONEXION
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");


?>
<html>
<head>
		<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<?php
$sql = "select * from sgm_inventario where id=".$_GET["id"].$row1["id"];
$result = mysql_query(convertSQL($sql));
$row = mysql_fetch_array($result);
echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" >";
	echo "<tr>";
		echo "<th></th>";
		echo "<th>".$Datos." ".$Generales."</th>";
	echo "</tr>";
	echo "<tr><td style=\"text-align:right;\">".$Nombre.": </td><td>".$row["nombre"]."</td></tr>";
	echo "<tr><td style=\"text-align:right;\">".$Tipo.": </td>";
		$sqlo = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"];
		$resulto = mysql_query(convertSQL($sqlo));
		$rowo = mysql_fetch_array($resulto);
		echo "<td>".$rowo["tipo"]."</td>";
	echo "</tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td></td><td><strong>".$Atributos."</strong></td></tr>";
	$sqla = "select * from sgm_inventario_tipo_atributo where visible=1 and id_tipo=".$row["id_tipo"]."";
	$resulta = mysql_query(convertSQL($sqla));
	while ($rowa = mysql_fetch_array($resulta)) {
		$sqld = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and id_atribut=".$rowa["id"]." and id_inventario=".$row["id"]."";
		$resultd = mysql_query(convertSQL($sqld));
		$rowd = mysql_fetch_array($resultd);
		echo "<tr><td style=\"text-align:right;\">".$rowa["atributo"]." : </td><td>".$rowd["dada"]."</td></tr>";
	}
echo "</table>";
?>

</body>
</html>
