<?php
error_reporting(~E_ALL);


function servidoresMonitorizados ($id_cliente, $serv_linea,$ssop){
	global $db,$dbhandle,$Uso,$Memoria,$simclau;
	echo "<tr>";
	$i = 1;
	$sqlcs2 = "select * from sgm_clients_servidors where id_client in (".$id_cliente.") and visible=1";
	$resultcs2 = mysql_query($sqlcs2,$dbhandle);
	while ($rowcs2 = mysql_fetch_array($resultcs2)){
		if ($i > $serv_linea) { echo "</tr><tr>"; }
		$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
		$resultcbd = mysql_query($sqlcbd,$dbhandle);
		$rowcbd = mysql_fetch_array($resultcbd);
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = decrypt($rowcbd["pass"],$simclau);
		$base = $rowcbd["base"];

		$sqlcsa = "select * from sgm_clients_servidors_param";
		$resultcsa = mysql_query($sqlcsa,$dbhandle);
		$rowcsa = mysql_fetch_array($resultcsa);
		$cpu = $rowcsa["cpu"];
		$mem = $rowcsa["mem"];
		$memswap = $rowcsa["memswap"];
		$hhdd = $rowcsa["hd"];

		$dbhandle3 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
		$db3 = mysql_select_db($base, $dbhandle3) or die("Couldn't open database $myDB");

		$sqlna = "select * from sim_nagios where id_servidor=".$rowcs2["servidor"]." order by time_register desc";
		$resultna = mysql_query(convert_sql($sqlna,$dbhandle3));
		$rowna = mysql_fetch_array($resultna);

		if ($rowna["nagios"] == 0){ $nagios = "OFF"; $colorn = "red"; $colorna = "white"; } else { $nagios = "ON"; $colorn = "Yellowgreen"; $colorna = "black"; }
		if ($rowna["httpd"] == 0){ $httpd = "OFF"; $colorh = "red"; $colorht = "white"; } else { $httpd = "ON"; $colorh = "Yellowgreen"; $colorht = "black"; }
		if ($rowna["mysqld"] == 0){ $mysqld = "OFF"; $colors = "red"; $colorsq = "white"; } else { $mysqld = "ON"; $colors = "Yellowgreen"; $colorsq = "black"; }
		if ($rowna["cpu"] >= $cpu){ $colorc = "red"; $colorcp = "white"; } else { $colorc = "Yellowgreen"; $colorcp = "black"; }
		if ($rowna["mem"] >= $mem){ $colorm = "red"; $colorme = "white"; } else { $colorm = "Yellowgreen"; $colorme = "black"; }
		if ($rowna["mem_swap"] <= $memswap){ $colorms = "red"; $colormsw = "white"; } else { $colorms = "Yellowgreen"; $colormsw = "black"; }
		if ($rowna["hd"] <= $hhdd){ $colorhd = "red"; $colorhhdd = "white"; } else { $colorhd = "Yellowgreen"; $colorhhdd = "black"; }
		$hd = ($rowna["hd"]/1000000);
		$diezmin = 600;
		if (($rowna["time_register"]+$diezmin) < time()){
			$color_linea = "red";
			$color_letras = "white";
			$colorn = "red"; $colorna = "white";
			$colorh = "red"; $colorht = "white";
			$colors = "red"; $colorsq = "white";
			$colorc = "red"; $colorcp = "white";
			$colorm = "red"; $colorme = "white";
			$colorms = "red"; $colormsw = "white";
			$colorhd = "red"; $colorhhdd = "white";
		} else { $color_linea = "white";}
		echo "<td style=\"vertical-align:top;\"><table>";
			echo "<tr><td style=\"vertical-align:top;\">".$rowcs2["descripcion"]."</td></tr>";
			echo "<tr><td><table><tr>";
				echo "<td style=\"text-align:center;vertical-align:top;background-color:".$color_linea.";color:".$color_letras.";\">";
					$fecha_ser = date("Y-m-d H:i:s", $rowna["time_server"]);
					echo $fecha_ser."<br>";
					echo "<a href=\"index.php?op=".$_GET["op"]."&sop=".$ssop."&id=".$_GET["id"]."&id_serv=".$rowcs2["servidor"]."&id_cli=".$id_cliente."\" style=\"text-decoration: none;\"><img src=\"".$urlmgestion."/archivos_comunes/images/server_nagios.JPG\" style=\"border:0px;\"></a>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorc.";color:".$colorcp."\">".$Uso." CPU : ".$rowna["cpu"]."%</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorm.";color:".$colorme."\">".$Uso." ".$Memoria." : ".$rowna["mem"]."%</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorms.";color:".$colormsw."\">".$Uso." ".$Memoria." SWAP : ".$rowna["mem_swap"]."%</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorhd.";color:".$colorhhdd."\">".$Espacio." HD : ".number_format ( $hd,2,".",",")." Gb.</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorn.";color:".$colorna."\">Nagios : ".$nagios."</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorh.";color:".$colorht."\">HTTP : ".$httpd."</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colors.";color:".$colorsq."\">MYSQL : ".$mysqld."</td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr></table></td></tr>";
		echo "</table></td>";
		$i++;
	}
	echo "</tr>";
}

?>