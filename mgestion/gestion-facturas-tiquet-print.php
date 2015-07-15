<?php 
error_reporting(~E_ALL);
#date_default_timezone_set('Europe/Paris');

	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");

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




$autorizado = true;
if ($autorizado == true) {
			$sqlx = "select * from sgm_factura_tipos where id=".$rowf["tipo"];
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);

			$sqlxtp = "select * from sgm_tpv_tipos_pago where id=".$rowf["id_tipo_pago"];
			$resultxtp = mysql_query(convert_sql($sqlxtp));
			$rowxtp = mysql_fetch_array($resultxtp);

		echo "<table cellpadding=\"0px\" cellspacing=\"1px\" style=\"width:250px;border:0px solid black\">";
			echo "<tr>";
				$sqlele = "select * from sgm_dades_origen_factura";
				$resultele = mysql_query(convert_sql($sqlele));
				$rowele = mysql_fetch_array($resultele);
				echo "<td><img src=\"imagen.php?tipo=3&clase=3\"></td>";
				echo "<td><center>";
					$sqlf = "select * from sgm_cabezera where id=".$_GET["id"];
					$resultf = mysql_query(convert_sql($sqlf));
					$rowf = mysql_fetch_array($resultf);
					echo "<strong style=\"font-size : 8px;\">".$rowf["onombre"]." (".$rowf["onif"].")";
					echo "<br>".$rowf["odireccion"]."";
					echo "<br>".$rowf["opoblacion"]." (".$rowf["ocp"].") ".$rowf["oprovincia"]."";
					echo "</strong>";
				echo "</center></td>";
			echo "</tr>";
		echo "</table>";
		echo "<table width=\"250px;border: 1px solid black;\"><tr><td><center>";
			echo "<strong style=\"font-size : 8px;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;\">".$rowx["tipo"]."";
			echo "<br>Num : ".$rowf["numero"]."  (".$rowf["fecha"].")</strong>";
		echo "</td></tr></table>";
		echo "<table cellpadding=\"0px\" cellspacing=\"1px\" style=\"width:250px;border:0px solid black\"><tr><td><center>";
			echo "<tr><td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;text-align:left;\">ARTICULO</td><td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;text-align:right;\">UNID.</td><td></td><td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;text-align:right;\">TOTAL €</td></tr>";
				$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;\">".$row["nombre"]."</td>";
						echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;text-align:right;\">".number_format($row["unidades"], 1, ',', '.')."</td>";
						echo "<td>&nbsp;</td>";
						echo "<td style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;text-align:right;\">".number_format($row["total"], 2, ',', '.')."</td>";
					echo "</tr>";
				}
		echo "</table>";

		echo "<table cellpadding=\"0px\" cellspacing=\"1px\" style=\"width:250px;border:0px solid black\"><tr><td><center>";
			echo "<tr>";
				echo "<td style=\"width:125px;border: 1px solid black;text-align:center;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;\">BASE IMP.<br><strong>".number_format($rowf["subtotal"], 2, ',', '.')." €</strong></td>";
				if ($rowf["descuento"] <> 0) {
					echo "<td style=\"width:125px;border: 1px solid black;text-align:center;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;\">DES. (".number_format($rowf["descuento"], 2, ',', '.')."%)<br><strong>".number_format($rowf["subtotaldescuento"], 2, ',', '.')." €</strong></td>";
				}
				$iva = number_format((($rowf["subtotaldescuento"] / 100) * $rowf["iva"]), 2, ',', '.');
				echo "<td style=\"width:125px;border: 1px solid black;text-align:center;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;\">IVA (".number_format($rowf["iva"], 0, ',', '.')."%)<br><strong>".$iva." €</strong></td>";
				echo "<td style=\"width:125px;border: 1px solid black;text-align:center;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 8px;\">TOTAL <br><strong>".number_format($rowf["total"], 2, ',', '.')." €</strong></td>";
			echo "</tr>";
		echo "</table>";
		echo "<font style=\"font-size : 8px;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;\">Forma de pago : <strong>".$rowxtp["tipo"]."</strong></font>";

}
else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>


</body>
</html>
