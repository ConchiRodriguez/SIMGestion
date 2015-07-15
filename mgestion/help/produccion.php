<?php

if ($option == 950){
	if ($soption == 1) {
		$sql = "update sgm_cabezera set ";
		$sql = $sql."notas_prod='".$_POST["notas_prod"]."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		echo $sql;
	}
	$sqltipos = "select * from sgm_cabezera where id=".$_GET["id"];
	$resulttipos = mysql_query(convert_sql($sqltipos));
	$rowtipos = mysql_fetch_array($resulttipos);
	echo "<table cellpadding=\"12\">";
		echo "<form action=\"index.php?op=950&sop=1&id=".$_GET["id"]."\" method=\"post\">";
		echo "<tr>";
			echo "<td style=\"text-align: justify\">";
				echo "<br>Notas<br>";
			echo "</td>";
		echo "</tr><tr>";
			echo "<td><textarea name=\"notas_prod\" rows=\"12\" style=\"width:600px\">";
			$data = getdate();
			$fecha = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			$hora = date("H:i:s", mktime($date["hours"] ,$date["minutes"], $date["seconds"],$date["mon"] ,$date["mday"], $date["year"]));
			echo $rowtipos["notas_prod"].chr(13).cambiarFormatoFechaDMY($fecha)." ".$hora." -";
			echo "</textarea></td>";
		echo "</tr><tr>";
			echo "<td style=\"text-align:center;\">";
				echo "<input type=\"Submit\" value=\"Actualizar\" style=\"width:75px;\">";
			echo "</form>";
				echo "<input type=button value=\"Cerrar\" style=\"width:75px;\" onClick=\"javascript:window.close();\">";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}


?>