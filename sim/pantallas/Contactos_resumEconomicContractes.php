<?php
error_reporting(~E_ALL);

	
function resumEconomicContractes($id){
	global $db,$dbhandle,$Enero,$Febrero,$Marzo,$Abril,$Mayo,$Junio,$Julio,$Agosto,$Septiembre,$Octubre,$Noviembre,$Ano,$Total,$meses;

	$sqldiv = "select * from sgm_divisas where visible=1 and predefinido=1";
	$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
	$rowdiv = mysqli_fetch_array($resultdiv);

		echo "<center><table cellspacing=\"0\" style=\"width:200px\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$yact = date('Y');
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&y=".$yant."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&y=".$yact."\">".$yact."</a></td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&y=".$ypost."\">&gt;".$ypost."</a></td>";
		echo "</tr></table></center>";
	if ($id == 0) { 
		echo "<br><center><table cellspacing=\"0\" style=\"width:100%\">";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 0; $x < 12; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$meses[$x]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".$Total." ".$rowdiv["abrev"]."</strong></td>";
				}
				echo "<td style=\"text-align:right;\"><strong>".$Total." ".$Ano." h.</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." ".$Ano." ".$rowdiv["abrev"]."</strong></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$inicio_any = date("Y-m-d", mktime(0,0,0,1,1,$yact));
			$final_any = date("Y-m-d", mktime(23,59,59,12,31,$yact));
			$sqltipos = "select id,id_cliente,num_contrato,descripcion from sgm_contratos where ((fecha_ini between '".$inicio_any."' and '".$final_any."') or (fecha_fin between '".$inicio_any."' and '".$final_any."') or (fecha_ini<'".$inicio_any."' and fecha_fin>'".$final_any."') ) and visible=1";
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$total_horas_any = 0;
				$total_euros_any = 0;
				$sqlc = "select id,nombre from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"27\">";
					echo "<a href=\"index.php?op=1011&sop=100&id=".$rowtipos["id"]."\">".$rowtipos["num_contrato"]." - ".$rowtipos["descripcion"]."</a>";
				echo "</td></tr>";
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"27\">";
					echo "<strong><a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">".$rowc["nombre"]."</a></strong>";
				echo "</td></tr>";
				$sqls = "select id,servicio,precio_hora from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				while ($rows = mysqli_fetch_array($results)){
					echo "<tr>";
						echo "<td nowrap>".$rows["servicio"]."</td>";
					for ($x = 1; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where visible=1 and fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
							$rowind = mysqli_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo $horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td nowrap style=\"text-align:right;background-color:".$color."\">".number_format ($total_euros,2,',','')." ".$rowdiv["abrev"]."</td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
						$inicio_mes = date("U", mktime(0,0,0,1, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,13, 1-1,$yact));
						echo "<td nowrap style=\"text-align:right;\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where visible=1 and fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
							$rowind = mysqli_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo $horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td nowrap style=\"text-align:right;\">".number_format ($total_euros,2,',','')." ".$rowdiv["abrev"]."</td>";
						$total_horas_any += $rowind["total"];
						$total_euros_any += $total_euros;
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 1; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td nowrap style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td>";
						echo "<td nowrap style=\"text-align:right;background-color:".$color."\"><strong>".number_format ($total_euros_mes[$x],2,',','')." ".$rowdiv["abrev"]."</strong></td>";
					}
						echo "<td nowrap style=\"text-align:right;\">";
							$hora = $total_horas_any/60;
							$horas = explode(".",$hora);
							$minutos = $total_horas_any % 60;
							echo $horas[0]." h. ".$minutos." m.";
						echo "</td>";
						echo "<td nowrap style=\"text-align:right;\">".number_format ($total_euros_any,2,',','')." ".$rowdiv["abrev"]."</td>";
					echo "</tr>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table></center>";
	} else {
		echo "<br><center><table cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 0; $x < 6; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$meses[$x]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".$Total." ".$rowdiv["abrev"]."</strong></td>";
				}
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select id,id_cliente from sgm_contratos where activo=1 and renovado=0 and visible=1 and id=".$id;
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"27\"><strong>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				while ($rows = mysqli_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 1; $x <= 6; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
							$rowind = mysqli_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\"><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_serv=".$rows["id"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros,2,',','')." ".$rowdiv["abrev"]."</a></td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 1; $x <= 6; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros_mes[$x],2,',','')." ".$rowdiv["abrev"]."</a></strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 6; $x < 12; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$meses[$x]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".$Total." ".$rowdiv["abrev"]."</strong></td>";
				}
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select * from sgm_contratos where activo=1 and renovado=0 and visible=1 and id=".$id;
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
			while ($rowtipos = mysqli_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$sqlc = "select * from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\"><strong>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				while ($rows = mysqli_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 7; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
							$rowind = mysqli_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\"><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_serv=".$rows["id"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros,2,',','')." ".$rowdiv["abrev"]."</a></td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 7; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros_mes[$x],2,',','')." ".$rowdiv["abrev"]."</a></strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table></center>";
	}
}

?>