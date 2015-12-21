<?php
error_reporting(~E_ALL);


function detalleServidoresMonitorizados ($id_cliente,$id_serv,$color){
	global $db,$dbhandle,$Volver,$Dia,$Mes,$Any,$Ultimos,$Estados,$Buscar,$Fecha,$Registro,$Servidor,$Uso,$Memoria,$Espacio,$simclau;
		$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
		$resultcbd = mysql_query(convertSQL($sqlcbd));
		$rowcbd = mysql_fetch_array($resultcbd);
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = decrypt($rowcbd["pass"],$simclau);
		$base = $rowcbd["base"];

		$sqlcsa = "select * from sgm_clients_servidors_param";
		$resultcsa = mysql_query(convertSQL($sqlcsa));
		$rowcsa = mysql_fetch_array($resultcsa);
		$cpu = $rowcsa["cpu"];
		$mem = $rowcsa["mem"];
		$memswap = $rowcsa["memswap"];
		$hhdd = $rowcsa["hd"];

		$sqlcs = "select * from sgm_clients_servidors where servidor=".$id_serv." and id_client in (".$id_cliente.") and visible=1";
		$resultcs = mysql_query(convertSQL($sqlcs,$dbhandle));
		$rowcs = mysql_fetch_array($resultcs);
		
		echo "<strong>".$Ultimos." ".$Estados." :</strong> ".$rowcs["descripcion"]."";
		echo "<br>";
			echo "<table><tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black\">";
						echo "<a href=\"javascript:history.go(-1);\" style=\"color:white;\">&laquo; ".$Volver."</a>";
					echo "</td>";
			echo "</tr></table>";
		echo "<br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\"><td>".$Dia."</td><td>".$Mes."</td><td>".$Any."</td><td></td></tr>";
			echo "<form action=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id_cli=".$id_cliente."&id_serv=".$_GET["id_serv"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td><select name=\"dia\" style=\"width:40px\">";
					for ($i=1;$i<=31;$i++){
						if (($_POST["dia"] != "") and ($_POST["dia"] == $i)){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} elseif (($_POST["dia"] == "") and (date("j") == $i)) {
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} else {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					}
					echo "</select></td>";
				echo "<td><select name=\"mes\" style=\"width:40px\">";
					for ($i=1;$i<=12;$i++){
						if (($_POST["mes"] != "") and ($_POST["mes"] == $i)){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} elseif (($_POST["mes"] == "") and (date("n")) == $i) {
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} else {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					}
					echo "</select></td>";
				echo "<td><select name=\"any\" style=\"width:60px\">";
					for ($i=2013;$i<=2023;$i++){
						if (($_POST["any"] != "") and ($_POST["any"] == $i)){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} elseif (($_POST["any"] == "") and (date("Y") == $i)) {
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} else {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					}
					echo "</select></td>";
					echo "<td><input type=\"submit\" value=\"".$Buscar."\"></td>";
			echo "</form>";
			echo "</tr>";
		echo "</table></center>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:center;width:150px\">".$Fecha." ".$Registro."</td>";
				echo "<td style=\"text-align:center;width:150px\">".$Fecha." ".$Servidor."</td>";
				echo "<td style=\"text-align:center;width:100px\">% ".$Uso." CPU</td>";
				echo "<td style=\"text-align:center;width:150px\">% ".$Uso." ".$Memoria."</td>";
				echo "<td style=\"text-align:center;width:150px\">% ".$Uso." ".$Memoria." SWAP</td>";
				echo "<td style=\"text-align:center;width:100px\">".$Espacio." HD</td>";
				echo "<td style=\"text-align:center;width:80px\">Nagios</td>";
				echo "<td style=\"text-align:center;width:80px\">HTTP</td>";
				echo "<td style=\"text-align:center;width:80px\">MYSQL</td>";
			echo "</tr>";

		$dbhandle2 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
		$db2 = mysql_select_db($base, $dbhandle2) or die("Couldn't open database $myDB");

		if ($_POST["dia"] != ""){
			$data_ini = (date(U, mktime (0,0,0,$_POST["mes"],$_POST["dia"],$_POST["any"])));
			$data_fin = (date(U, mktime (23,59,59,$_POST["mes"],$_POST["dia"],$_POST["any"])));
		} else {
			$data_ini = (date(U, mktime (0,0,0,date("n"),date("j"),date("Y"))));
			$data_fin = (date(U, mktime (23,59,59,date("n"),date("j"),date("Y"))));
		}
			$sqlna = "select * from sim_nagios where id_servidor=".$_GET["id_serv"]." and time_register between ".$data_ini." and ".$data_fin." order by time_register desc";
			$resultna = mysql_query(convertSQL($sqlna,$dbhandle2));
			while ($rowna = mysql_fetch_array($resultna)){
				if ($rowna["nagios"] == 0){ $nagios = "OFF"; $colorn = "red"; $colorna = "white"; } else { $nagios = "ON"; $colorn = "white"; $colorna = "black"; }
				if ($rowna["httpd"] == 0){ $httpd = "OFF"; $colorh = "red"; $colorht = "white"; } else { $httpd = "ON"; $colorh = "white"; $colorht = "black"; }
				if ($rowna["mysqld"] == 0){ $mysqld = "OFF"; $colors = "red"; $colormy = "white"; } else { $mysqld = "ON"; $colors = "white"; $colormy = "black"; }
				if ($rowna["cpu"] >= $cpu){ $colorc = "red"; $colorcp = "white"; } else { $colorc = "white"; $colorcp = "black"; }
				if ($rowna["mem"] >= $mem){ $colorm = "red"; $colorme = "white"; } else { $colorm = "white"; $colorme = "black"; }
				if ($rowna["mem_swap"] <= $memswap){ $colorms = "red"; $colormsw = "white"; } else { $colorms = "white"; $colormsw = "black"; }
				if ($rowna["hd"] <= $hhdd){ $colorhd = "red"; $colorhhdd = "white"; } else { $colorhd = "white"; $colorhhdd = "black"; }
				$difer = $rowna["time_register"] - $rowna["time_server"];
				if ($fechaant > 0){$difer2 = $fechaant - $rowna["time_register"];} else { $difer2=0;}
				if ((($difer < -600) or ($difer > 600)) or ($difer2 > 600)){ $colorti = "red"; $colorte = "white"; } else { $colorti = "white"; $colorte = "black"; }
				$fecha_reg = date("Y-m-d H:i:s", $rowna["time_register"]);
				$fecha_ser = date("Y-m-d H:i:s", $rowna["time_server"]);
				$hd = ($rowna["hd"]/1000000);
				echo "<tr>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorti.";color:".$colorte.";\">".$fecha_reg."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorti.";color:".$colorte.";\">".$fecha_ser."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorc.";color:".$colorcp.";\">".$rowna["cpu"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorm.";color:".$colorme.";\">".$rowna["mem"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorms.";color:".$colormsw.";\">".$rowna["mem_swap"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorhd.";color:".$colorhhdd.";\">".number_format ( $hd,2,".",",")." Gb.</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorn.";color:".$colorna.";\">".$nagios."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorh.";color:".$colorht.";\">".$httpd."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colors.";color:".$colormy.";\">".$mysqld."</td>";
				echo "</tr>";
				$fechaant = $rowna["time_register"];
			}
		mysql_close($dbhandle2);
		echo "</table>";
		echo "</center>";
}

?>