<?php
error_reporting(~E_ALL);

function resumEconomicContractes($id){
	global $Enero,$Febrero,$Marzo,$Abril,$Mayo,$Junio,$Julio,$Agosto,$Septiembre,$Octubre,$Noviembre,$Diciembre,$Total;
		echo "<center><table cellspacing=\"0\" style=\"width:200px\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$fechahoy = getdate();
					$yact = $fechahoy["year"];
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
		echo "<br><center><table cellspacing=\"0\" style=\"width:1800px\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Enero."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Febrero."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Marzo."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Abril."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Mayo."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Junio."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Julio."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Agosto."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Septiembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Octubre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Noviembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Diciembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select * from sgm_contratos where activo=1 and renovado=0 and visible=1";
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$sqlc = "select * from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\"><strong>";
					echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">".$rowc["nombre"]."</a> : </strong><a href=\"index.php?op=1011&sop=100&id=".$rowtipos["id"]."\">".$rowtipos["num_contrato"]."</a>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysql_query(convert_sql($sqls));
				while ($rows = mysql_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 1; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\">".number_format ($total_euros,2,',','')." €</td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 1; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong>".number_format ($total_euros_mes[$x],2,',','')." €</strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table></center>";
	} else {
		echo "<br><center><table cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Enero."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Febrero."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Marzo."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Abril."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Mayo."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Junio."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select * from sgm_contratos where activo=1 and renovado=0 and visible=1 and id=".$id;
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$sqlc = "select * from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\"><strong>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysql_query(convert_sql($sqls));
				while ($rows = mysql_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 1; $x <= 6; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\"><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_serv=".$rows["id"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros,2,',','')." €</a></td>";
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
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros_mes[$x],2,',','')." €</a></strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Julio."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Agosto."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Septiembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Octubre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Noviembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Diciembre."</strong></a></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select * from sgm_contratos where activo=1 and renovado=0 and visible=1 and id=".$id;
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$sqlc = "select * from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\"><strong>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysql_query(convert_sql($sqls));
				while ($rows = mysql_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 7; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\"><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_serv=".$rows["id"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros,2,',','')." €</a></td>";
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
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros_mes[$x],2,',','')." €</a></strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table></center>";
	}
}

function calculSLAtotal(){
	global $db;
	$sql = "select * from sgm_incidencias where id_incidencia=0 and visible=1 and id_estado<>-2";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
		$pendent = calculSLA($row["id"],0);
		if ($row["pausada"] == 0){$previsio = fecha_prevision($row["id_servicio"], $row["fecha_inicio"]);} else {$previsio = 0;}
		$sql1 = "update sgm_incidencias set ";
		$sql1 = $sql1."temps_pendent=".$pendent;
		$sql1 = $sql1.",fecha_prevision=".$previsio;
		$sql1 = $sql1." WHERE id=".$row["id"]."";
		mysql_query($sql1);
#		echo $sql1."<br>";
	}
}

function calculSLA($id,$cierre){
	global $db;
	$sql = "select * from sgm_incidencias where id=".$id."";
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);

	$durada = 0;
	$pausada = 0;

	$sqlc = "select * from sgm_contratos_servicio where id=".$row["id_servicio"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
		$contador = 0;
		$fecha_ant = 0;
		$sqld = "select * from sgm_incidencias where id_incidencia=".$id." and visible=1 and fecha_inicio >= ".$row["fecha_inicio"]." order by fecha_inicio";
		$resultd = mysql_query(convert_sql($sqld));
		while ($rowd = mysql_fetch_array($resultd)){
			if ($contador==0){$fecha_ant = $row["fecha_inicio"];}
			if ($rowc["nbd"] == 1) {$tiempo = buscaFestivo($rowd["fecha_inicio"],$fecha_ant);}
			if ($rowc["nbd"] == 0) {$tiempo = $rowd["fecha_inicio"]-$fecha_ant;}
			if (($pausada == 0)){$durada += $tiempo;}
			$fecha_ant = $rowd["fecha_inicio"];
			$contador++;
			$pausada = $rowd["pausada"];
#			echo $id."-".($rowd["fecha_inicio"] - $row["fecha_inicio"])."-".$durada."a<br><br>";
		}
		if ($fecha_ant == 0){$fecha_ant = $row["fecha_inicio"];}
		if (($pausada==0) and ($cierre==0)){
			if ($rowc["nbd"] == 1) {$tiempo = buscaFestivo(time(),$fecha_ant);}
			if ($rowc["nbd"] == 0) {$tiempo = time()-$fecha_ant;}
#			$tiempo = buscaFestivo(time(),$fecha_ant);
			$durada += $tiempo;
#			echo $id." ".(time() - $fecha_ant)."--".$tiempo."--".$durada."1<br>";
		} elseif (($pausada==0) and ($cierre==1)){
			if ($rowc["nbd"] == 1) {$tiempo = buscaFestivo($row["fecha_cierre"],$fecha_ant);}
			if ($rowc["nbd"] == 0) {$tiempo = $row["fecha_cierre"]-$fecha_ant;}
#			$tiempo = buscaFestivo($row["fecha_cierre"],$fecha_ant);
			$durada += $tiempo;
#			echo $id." ".(time() - $fecha_ant)."-b-".$tiempo."-b-".$durada."2<br>";
		}

	$sqlc = "select * from sgm_contratos_servicio where id=".$row["id_servicio"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	$sla = ($rowc["temps_resposta"]*3600)-$durada;
#	echo "ID:".$row["id"]."SLA:".($sla/3600)."Durada:".($durada/3600)."Temps Resposta:".$rowc["temps_resposta"]."<br>";
	return $sla;
}


function buscaFestivo($fecha_act,$fecha_ant){
	global $db;
	$tiempo=0;

	#calcul primera hora del dia, 00:00:00
	$data_ini = date("Y-m-d", $fecha_act);
	$act_hora = date("H",$fecha_act);
	$act_min = date("i",$fecha_act);
	$act_sec = date("s",$fecha_act);
	$time_act = $act_sec + ($act_min*60) + ($act_hora*3600);
	$data_act = date('U', strtotime($data_ini));
	$data_fi = date("Y-m-d", $fecha_ant);
	$ant_hora = date("H",$fecha_ant);
	$ant_min = date("i",$fecha_ant);
	$ant_sec = date("s",$fecha_ant);
	$time_ant = $ant_sec + ($ant_min*60) + ($ant_hora*3600);
	$data_ant = date('U', strtotime($data_fi));
	$mesdia=0;

	$diaSemana2 = date("N", ($data_ant));
	$sqlch2 = "select * from sgm_calendario_horario where id=".$diaSemana2."";
	$resultch2 = mysql_query(convert_sql($sqlch2));
	$rowch2 = mysql_fetch_array($resultch2);
	if ($fecha_ant < ($data_ant+$rowch2["hora_fin"])) {$y= $time_ant;}
	if ($fecha_ant < ($data_ant+$rowch2["hora_inicio"])){$y= $rowch2["hora_inicio"];}
	if ($fecha_ant > ($data_ant+$rowch2["hora_inicio"])) {$y= $time_ant;}
	if ($fecha_ant > ($data_ant+$rowch2["hora_fin"])) {$y= $rowch2["hora_fin"];}

	$diaSemana = date("N", ($data_act));
	$sqlch = "select * from sgm_calendario_horario where id=".$diaSemana."";
	$resultch = mysql_query(convert_sql($sqlch));
	$rowch = mysql_fetch_array($resultch);
	if ($fecha_act < ($data_act+$rowch["hora_fin"])) {$x = $time_act;}
	if ($fecha_act < ($data_ant+$rowch["hora_inicio"])){$x= $rowch["hora_inicio"];}
	if ($fecha_act > ($data_ant+$rowch["hora_inicio"])) {$x= $time_act;}
	if ($fecha_act > ($data_act+$rowch["hora_fin"])){$x= $rowch["hora_fin"];}

	if ($data_ant < $data_act){
		$tiempo += $rowch2["hora_fin"]-$y;
		$tiempo += $x - $rowch["hora_inicio"];
	} else {
		$tiempo += $x-$y;
	}

	$data_ant = sumaDies($data_ant,1);
	while ($data_ant < $data_act){
		$comprobar = comprobar_festivo2($data_ant);
		if ($comprobar == 0){
			$diaSemanaX = date("N", ($data_ant));
			$sqlch = "select * from sgm_calendario_horario where id=".$diaSemanaX."";
			$resultch = mysql_query(convert_sql($sqlch));
			$rowch = mysql_fetch_array($resultch);
			$tiempo += (($data_ant+$rowch["hora_fin"]) - ($data_ant+$rowch["hora_inicio"]));
#					echo "g".($tiempo/3600)."<br>";
		}
		$data_ant = sumaDies($data_ant,1);
	}

	return $tiempo;
}

function fecha_prevision($id_servicio, $data_ini)
{
	global $db;

	$sqlc = "select * from sgm_contratos_servicio where id=".$id_servicio;
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc["temps_resposta"] > 0){
		$temps_resposta = ($rowc["temps_resposta"]*3600)-$temps_transcurregut;
		$fecha_ini = (date("Y-m-d H:i:s", $data_ini));
		list($fecha,$hora)=explode(" ",$fecha_ini);
		list($any,$mes,$dia)=explode("-", $fecha);
		$j = 0;

		if ($rowc["nbd"] == 0){
			$prevision = $temps_resposta+$data_ini;
		}

		if ($rowc["nbd"] == 1) {
			while ($temps_resposta > 0){
				$festivo = comprobar_festivo2($data_ini);
				while ($festivo == 1){
					$j++;
					$dia_dema = date("N", sumaDies($data_ini,1));
					$sqlch = "select * from sgm_calendario_horario where id=".$dia_dema;
					$resultch = mysql_query(convert_sql($sqlch));
					$rowch = mysql_fetch_array($resultch);
					$data_ini = date(U, mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
					$festivo = comprobar_festivo2($data_ini);
				}
				$dia2 = date("N", ($data_ini));
				$sqlch = "select * from sgm_calendario_horario where id=".$dia2;
				$resultch = mysql_query(convert_sql($sqlch));
				$rowch = mysql_fetch_array($resultch);
				$inici_jornada = date(U, mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
				if ($data_ini >= $inici_jornada) {$data_ini=$data_ini;} else {$data_ini=$inici_jornada;}
				$fin_jornada = date(U, mktime(($rowch["hora_fin"]/3600), 0, 0, $mes, $dia+$j, $any));
				$hores_prev = $temps_resposta - ($fin_jornada - $data_ini);
				if ($hores_prev > 0){
					if (($fin_jornada - $data_ini) >= 0){
						$temps_resposta = $temps_resposta - ($fin_jornada - $data_ini);
					}
					$j++;
					$dia_dema = date("N", sumaDies($data_ini,1));
					$sqlch2 = "select * from sgm_calendario_horario where id=".$dia_dema;
					$resultch2 = mysql_query(convert_sql($sqlch2));
					$rowch2 = mysql_fetch_array($resultch2);
					$data_ini = date(U, mktime(($rowch2["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
				}
				if ($hores_prev <= 0){
					$prevision = $data_ini + $temps_resposta;
					$temps_resposta = 0;
				}
			}
		}
	} else {
		$prevision = 0;
	}
	return $prevision;
}

function comprobar_festivo2($fecha)
{
	global $db;
	$festivo=0;
#Extreiem l'hora a la que acabaria la peça
	$dia_sem = date("w", ($fecha));
	if ($dia_sem == 0){
		$festivo=1;
	}
	if ($dia_sem == 6){
		$festivo=1;
	}
	$sqlc = "select * from sgm_calendario where dia=".date("j", ($fecha))." and mes=".date("n", ($fecha))."";
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc){
		$festivo=1;
	}
	return $festivo;
}

function sumaDies($dia_actual,$num){
	$proxim_any = date("Y",$dia_actual);
	$proxim_mes = date("m",$dia_actual);
	$proxim_dia = date("d",$dia_actual);
	$dia_prox = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+$num,$proxim_any));
	return $dia_prox;
}

function servidoresMonitorizados ($id_cliente, $serv_linea,$ssop){
	global $db,$dbhandle,$Uso,$Memoria;
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
		$pass = $rowcbd["pass"];
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

function detalleServidoresMonitorizados ($id_cliente,$id_serv,$color){
	global $db,$dbhandle,$Volver,$Dia,$Mes,$Any,$Ultimos,$Estados,$Buscar,$Fecha,$Registro,$Servidor,$Uso,$Memoria,$Espacio;
		$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
		$resultcbd = mysql_query(convert_sql($sqlcbd));
		$rowcbd = mysql_fetch_array($resultcbd);
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = $rowcbd["pass"];
		$base = $rowcbd["base"];

		$sqlcsa = "select * from sgm_clients_servidors_param";
		$resultcsa = mysql_query(convert_sql($sqlcsa));
		$rowcsa = mysql_fetch_array($resultcsa);
		$cpu = $rowcsa["cpu"];
		$mem = $rowcsa["mem"];
		$memswap = $rowcsa["memswap"];
		$hhdd = $rowcsa["hd"];

		$sqlcs = "select * from sgm_clients_servidors where servidor=".$id_serv." and id_client in (".$id_cliente.") and visible=1";
		$resultcs = mysql_query(convert_sql($sqlcs,$dbhandle));
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
			$resultna = mysql_query(convert_sql($sqlna,$dbhandle2));
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

function calendari_economic($rec){
	global $db;
	$mes = gmdate("n");
	$mes_anterior = date("U", mktime(0,0,0,$mes-1, 1, date("Y")));
	$mes_ultimo = date("U", mktime(0,0,0,$mes+12, 1-1, date("Y")));
	$dia_actual=$mes_anterior;
	$dia_actual1 = date("U", mktime(0,0,0,$mes-1, 1-1, date("Y")));
	if ($rec == 1) {$dia_actual=date("U", mktime(0,0,0,1,1,2012)); $dia_actual1=date("U", mktime(0,0,0,1,1-1,2012));}

	$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual1."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ($row){
		$saldo_inicial = $row["liquido"];
		$pagos_externos = $row["externos"];
	} else {
		$saldo_inicial = 0;
		$pagos_externos = 0;
	}

	while ($dia_actual<=$mes_ultimo){
		$dia_actual2 = date("Y-m-d", $dia_actual);
		$hoy = date("U", mktime(0,0,0,date("m"), date("d"), date("Y")));

		$data_iva1 =  date("Y-m-d", mktime(0,0,0,1,20,date("Y")));
		$data_iva2 =  date("Y-m-d", mktime(0,0,0,4, 20,date("Y")));
		$data_iva3 =  date("Y-m-d", mktime(0,0,0,7,20,date("Y")));
		$data_iva4 =  date("Y-m-d", mktime(0,0,0,10,20,date("Y")));
		if ($dia_actual2 == $data_iva1){
			$inicio_iva1 = date("Y-m-d", mktime(0,0,0,10,01,date("Y")-1));
			$fin_iva1 = date("Y-m-d", mktime(0,0,0,12,31,date("Y")-1));
			$sqliva1 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=1 and fecha between '".$inicio_iva1."' and '".$fin_iva1."'";
			$resultiva1 = mysql_query($sqliva1);
			$rowiva1 = mysql_fetch_array($resultiva1);
			$sqliva11 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=5 and fecha between '".$inicio_iva1."' and '".$fin_iva1."'";
			$resultiva11 = mysql_query($sqliva11);
			$rowiva11 = mysql_fetch_array($resultiva11);
			$iva1 = $rowiva1["total"] -$rowiva11["total"];
		}
		if ($dia_actual2 == $data_iva2){
			$inicio_iva2 = date("Y-m-d", mktime(0,0,0,1, 01, date("Y")));
			$fin_iva2 = date("Y-m-d", mktime(0,0,0,3, 31, date("Y")));
			$sqliva2 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=1 and fecha between '".$inicio_iva2."' and '".$fin_iva2."'";
			$resultiva2 = mysql_query($sqliva2);
			$rowiva2 = mysql_fetch_array($resultiva2);
			$sqliva22 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=5 and fecha between '".$inicio_iva2."' and '".$fin_iva2."'";
			$resultiva22 = mysql_query($sqliva22);
			$rowiva22 = mysql_fetch_array($resultiva22);
			$iva2 = $rowiva2["total"] -$rowiva22["total"];
		}
		if ($dia_actual2 == $data_iva3){
			$inicio_iva3 = date("Y-m-d", mktime(0,0,0,4, 01, date("Y")));
			$fin_iva3 = date("Y-m-d", mktime(0,0,0,6, 31, date("Y")));
			$sqliva3 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=1 and fecha between '".$inicio_iva3."' and '".$fin_iva3."'";
			$resultiva3 = mysql_query($sqliva3);
			$rowiva3 = mysql_fetch_array($resultiva3);
			$sqliva33 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=5 and fecha between '".$inicio_iva3."' and '".$fin_iva3."'";
			$resultiva33 = mysql_query($sqliva33);
			$rowiva33 = mysql_fetch_array($resultiva33);
			$iva3 = $rowiva3["total"] -$rowiva33["total"];
		}
		if ($dia_actual2 == $data_iva4){
			$inicio_iva4 = date("Y-m-d", mktime(0,0,0,7, 01, date("Y")));
			$fin_iva4 = date("Y-m-d", mktime(0,0,0,9, 31, date("Y")));
			$sqliva4 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=1 and fecha between '".$inicio_iva4."' and '".$fin_iva4."'";
			$resultiva4 = mysql_query($sqliva4);
			$rowiva4 = mysql_fetch_array($resultiva4);
			$sqliva44 = "select sum(total - subtotal) as total from sgm_cabezera where visible=1 and tipo=5 and fecha between '".$inicio_iva4."' and '".$fin_iva4."'";
			$resultiva44 = mysql_query($sqliva44);
			$rowiva44 = mysql_fetch_array($resultiva44);
			$iva4 = $rowiva4["total"] -$rowiva44["total"];
		}
		if ($hoy > $dia_actual){
			$sqlgasto = "select sum(total) as total_gasto from sgm_cabezera where visible=1 and tipo=5 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		} elseif ($hoy <= $dia_actual){
			$sqlgasto = "select sum(total) as total_gasto from sgm_cabezera where visible=1 and tipo in (5,8) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		}
		$resultgasto = mysql_query($sqlgasto);
		$rowgasto = mysql_fetch_array($resultgasto);

		if ($hoy > $dia_actual){
			$sqlingre1 = "select sum(total) as total_ingre1 from sgm_recibos where id_factura IN (select id from sgm_cabezera where visible=1 and tipo=1 and id_pagador=1 and cerrada=0) and fecha='".$dia_actual2."' and visible=1";
		} elseif ($hoy <= $dia_actual){
			$sqlingre1 = "select sum(total) as total_ingre1 from sgm_cabezera where visible=1 and tipo=1 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1 and cerrada=0";
		}
		$resultingre1 = mysql_query($sqlingre1);
		$rowingre1 = mysql_fetch_array($resultingre1);

#		$sqlingre1 = "select sum(total) as total_ingre1 from sgm_cabezera where visible=1 and tipo=1 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
#		$resultingre1 = mysql_query($sqlingre1);
#		$rowingre1 = mysql_fetch_array($resultingre1);

		$sqlingre2 = "select sum(total) as total_ingre2 from sgm_cabezera where visible=1 and tipo=7 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		$resultingre2 = mysql_query($sqlingre2);
		$rowingre2 = mysql_fetch_array($resultingre2);
		$sqliv = "select sum(total) as total_ingreso_varios from sgm_cabezera where visible=1 and tipo=9 and fecha_vencimiento = '".$dia_actual2."' and id_pagador=1";
		$resultiv = mysql_query($sqliv);
		$rowiv = mysql_fetch_array($resultiv);
		$sqlprep = "select sum(total) as total_prep from sgm_cabezera where visible=1 and tipo=10 and fecha_vencimiento = '".$dia_actual2."' and id_pagador=1";
		$resultprep = mysql_query($sqlprep);
		$rowprep = mysql_fetch_array($resultprep);
		$sqlex = "select sum(total) as total_externos from sgm_cabezera where visible=1 and fecha_vencimiento = '".$dia_actual2."' and id_pagador<>1";
		$resultex = mysql_query($sqlex);
		$rowex = mysql_fetch_array($resultex);
		$total_gastos = $rowgasto["total_gasto"] + $iva1 + $iva2 + $iva3 + $iva4;
		$saldo_actual = $saldo_inicial - $rowgasto["total_gasto"] + ($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"]) + $rowiv["total_ingreso_varios"];
		$ingresos = ($rowingre1["total_ingre1"]+$rowingre2["total_ingre2"]+ $rowiv["total_ingreso_varios"]);
		$pagos_externos = $pagos_externos + $rowex["total_externos"];
#		echo date("Y-m-d", $dia_actual)."<br>Saldo : ".$saldo_inicial." - Ingresos :".($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowiv["total_ingreso_varios"])." - Gastos : ".$rowgasto["total_gasto"]." - Saldo Final:".$saldo_actual."<br>";
		$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if (!$row){
			$sql = "insert into sgm_factura_calendario (fecha,gastos,ingresos,pre_pagos,externos,liquido) ";
			$sql = $sql."values (";
			$sql = $sql."".$dia_actual."";
			$sql = $sql.",'".$total_gastos."'";
			$sql = $sql.",'".$ingresos."'";
			$sql = $sql.",'".$rowprep["total_prep"]."'";
			$sql = $sql.",'".$pagos_externos."'";
			$sql = $sql.",'".$saldo_actual."'";
			$sql = $sql.")";
			mysql_query($sql);
#			echo $sql."in<br>";
		} else {
			$sql = "update sgm_factura_calendario set ";
			$sql = $sql."gastos='".$total_gastos."'";
			$sql = $sql.",ingresos='".$ingresos."'";
			$sql = $sql.",pre_pagos='".$rowprep["total_prep"]."'";
			$sql = $sql.",externos='".$pagos_externos."'";
			$sql = $sql.",liquido='".$saldo_actual."'";
			$sql = $sql." WHERE fecha=".$dia_actual."";
			mysql_query($sql);
#			echo $sql."<br>";
		}
		$saldo_inicial = $saldo_actual;
		$proxim_any = date("Y",$dia_actual);
		$proxim_mes = date("m",$dia_actual);
		$proxim_dia = date("d",$dia_actual);
		$dia_actual = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+1,$proxim_any));
		$iva1=0;
		$iva2=0;
		$iva3=0;
		$iva4=0;
		$irpf1=0;
		$irpf2=0;
		$irpf3=0;
		$irpf4=0;
	}
}

function correo_incidencias(){
	global $db;
	$imap = imap_open ("{mail.solucions-im.net:143/imap/notls}INBOX", "proves@solucions-im.net", "Proves15") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
#	$imap = imap_open ("{mail.solucions-im.com:143/imap/notls}INBOX", "soporte@solucions-im.com", "Multi12") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
	$checar = imap_check($imap);
	// Detalles generales de todos los mensajes del usuario.
	$resultados = imap_fetch_overview($imap,"1:{$checar->Nmsgs}",0);
	// Ordenamos los mensajes arriba los más nuevos y abajo los más antiguos
#	krsort($resultados);
	foreach ($resultados as $detalles) {

		$destinatario = imap_utf8($detalles->to);
		$destinatario = str_replace('"','',$destinatario);
		$destinatario = str_replace("'","",$destinatario);
		$uid = $detalles->uid;
		$sqli = "select * from sgm_incidencias_correos where destinatario='".$destinatario."'";
		$resulti = mysql_query($sqli);
		$rowi = mysql_fetch_array($resulti);
		if (!$rowi) {
			$sql = "insert into sgm_incidencias_correos (uid,destinatario) ";
			$sql = $sql."values (";
			$sql = $sql."".$uid."";
			$sql = $sql.",'".$destinatario."'";
			$sql = $sql.")";
			mysql_query($sql);
#			echo $sql."<br>";
			$sqli = "select * from sgm_incidencias_correos where destinatario='".$destinatario."'";
			$resulti = mysql_query($sqli);
			$rowi = mysql_fetch_array($resulti);
		} else {
			if ($uid > $rowi["uid"]){
				$sql = "update sgm_incidencias_correos set ";
				$sql = $sql."uid=".$uid;
				$sql = $sql." WHERE destinatario='".$rowi["destinatario"]."'";
				mysql_query($sql);
#				echo $sql."<br>";
			}
		}
		if ($uid > $rowi["uid"]){
			$asunto = imap_utf8($detalles->subject);
			$remitente = imap_utf8($detalles->from);
			$remite = imap_headerinfo($imap,$detalles->msgno);
			$correo_rem = $remite->from;
			foreach ($correo_rem as $correo_remite) {
				$correo_remitente = $correo_remite->mailbox."@".$correo_remite->host;
			}

#			$fecha = $detalles->date;
#			$id = $detalles->message_id;
#			$num_mensage = $detalles->msgno;
			$leido = $detalles->seen;
			$estructura = imap_fetchstructure($imap,$detalles->msgno);
			$flattenedParts = flattenParts($estructura->parts);
			if ($flattenedParts){
				foreach($flattenedParts as $partNumber => $part) {
					switch($part->type) {
						case 0:
							// the HTML or plain text part of the email
							$message = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
							// now do something with the message, e.g. render it
							$message = str_replace("</p>","\r\n",$message);
							$message = strip_tags($message,'\r\n');
							$message = str_replace("&nbsp;", "", $message);
							$message = trim($message);
						break;
					
						case 1:
							// multi-part headers, can ignore
					
						break;
						case 2:
							// attached message headers, can ignore
						break;
					
						case 3: // application
						case 4: // audio
						case 5: // image
							$tipus = "image/";
						case 6: // video
						case 7: // other
							$filename = getFilenameFromPart($part);
							$tipus .= $part->subtype;
							$size = $part->bytes;
							if($filename) {
								// it's an attachment
								$attachment = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
								// now do something with the attachment, e.g. save it somewhere
								file_put_contents("../sim/files/incidencias/".$filename,$attachment,FILE_APPEND); 
							}
							else {
								// don't know what it is
							}
						break;
					}
	#				echo "<pre>".var_dump($message)."</pre>";
				}
			} else {
				$message = imap_body($imap, $detalles->msgno);
			}
#			echo "<img src=\"".$filename."\">";

			$cabeza = imap_header($imap, $detalles->msgno );
			$data_missatge = strtotime($cabeza->MailDate);
			$data = time();

			$sqlum = "select * from sgm_users where mail='".$correo_remitente."'";
			$resultum = mysql_query($sqlum);
			$rowum = mysql_fetch_array($resultum);
			if ($rowum){
				$sqluc = "select * from sgm_users_clients where id_user=".$rowum["id"];
				$resultuc = mysql_query($sqluc);
				$rowuc = mysql_fetch_array($resultuc);
				$id_cliente = $rowuc["id_client"];
				$id_usuario = $rowum["id"];
			} else {
				$sqlcc = "select * from sgm_clients_contactos where mail='".$correo_remitente."'";
				$resultcc = mysql_query($sqlcc);
				$rowcc = mysql_fetch_array($resultcc);
				if ($rowcc){
					$id_cliente = $rowcc["id_client"];
					$id_usuario = 0;
				} else {
					$sqlumh = "select * from sgm_users where mail='%@".$correo_remite->host."'";
					$resultumh = mysql_query($sqlumh);
					$rowumh = mysql_fetch_array($resultumh);
					if ($rowumh){
						$sqluch = "select * from sgm_users_clients where id_user=".$rowumh["id"];
						$resultuch = mysql_query($sqluch);
						$rowuch = mysql_fetch_array($resultuch);
						$id_cliente = $rowuch["id_client"];
						$id_usuario = 0;
					}
				}
			}
			if (($remitente != "guardian@grupserhs.com") and ($remitente != "soporte@solucions-im.com")){
				$sql = "insert into sgm_incidencias (correo,id_usuario_registro,id_usuario_origen,id_cliente,fecha_registro_inicio,fecha_inicio,id_estado,id_entrada,notas_registro,asunto,pausada)";
				$sql = $sql."values (";
				$sql = $sql."1";
				$sql = $sql.",".$id_usuario."";
				$sql = $sql.",".$id_usuario."";
				$sql = $sql.",".$id_cliente."";
				$sql = $sql.",".$data."";
				$sql = $sql.",".$data_missatge."";
				$sql = $sql.",-1";
				$sql = $sql.",3";
				$sql = $sql.",'".comillas(utf8_decode($message))."'";
				$sql = $sql.",'".comillas(utf8_decode($asunto))."'";
				$sql = $sql.",0";
				$sql = $sql.")";
				mysql_query($sql);
#	echo $sql."<br>";
				if ($filename){
					$sqlin = "select * from sgm_incidencias where fecha_registro_inicio=".$data." and fecha_inicio=".$data_missatge." and asunto='".comillas($asunto)."'";
					$resultin = mysql_query($sqlin);
					$rowin = mysql_fetch_array($resultin);
					$sql2 = "insert into sgm_files (id_tipo,name,type,size,id_incidencia)";
					$sql2 = $sql2."values (";
					$sql2 = $sql2."1";
					$sql2 = $sql2.",'".$filename."'";
					$sql2 = $sql2.",'".$tipus."'";
					$sql2 = $sql2.",".$size;
					$sql2 = $sql2.",".$rowin["id"];
					$sql2 = $sql2.")";
					mysql_query($sql2);
#	echo $sql2."<br>";
				}
			}
			if ($leido == 0){imap_clearflag_full($imap, $uid, "\\Seen");}
		}
	}

	imap_close($imap, CL_EXPUNGE);

}

function getPart($connection, $messageNumber, $partNumber, $encoding) {
	
	$data = imap_fetchbody($connection, $messageNumber, $partNumber);
	switch($encoding) {
		case 0: return $data; // 7BIT
		case 1: return $data; // 8BIT
		case 2: return $data; // BINARY
		case 3: return base64_decode($data); // BASE64
		case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
		case 5: return $data; // OTHER
	}
}

function getFilenameFromPart($part) {

	$filename = '';
	
	if($part->ifdparameters) {
		foreach($part->dparameters as $object) {
			if(strtolower($object->attribute) == 'filename') {
				$filename = $object->value;
			}
		}
	}

	if(!$filename && $part->ifparameters) {
		foreach($part->parameters as $object) {
			if(strtolower($object->attribute) == 'name') {
				$filename = $object->value;
			}
		}
	}
	
	return $filename;
	
}

function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {

	foreach($messageParts as $part) {
		$flattenedParts[$prefix.$index] = $part;
		if(isset($part->parts)) {
			if($part->type == 2) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
			}
			elseif($fullPrefix) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
			}
			else {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
			}
			unset($flattenedParts[$prefix.$index]->parts);
		}
		$index++;
	}

	return $flattenedParts;
}

function simAlert(){
	global $db,$dbhandle;
	$diezmin = 600;
	$fechaant = 0;

	$sqlcsa = "select * from sgm_clients_servidors_param";
	$resultcsa = mysql_query($sqlcsa,$dbhandle);
	$rowcsa = mysql_fetch_array($resultcsa);
	$cpu = $rowcsa["cpu"];
	$mem = $rowcsa["mem"];
	$memswap = $rowcsa["memswap"];
	$hhdd = $rowcsa["hd"];

	$sqlcbd = "select * from sgm_clients_bases_dades where visible=1";
	$resultcbd = mysql_query($sqlcbd,$dbhandle);
	while ($rowcbd = mysql_fetch_array($resultcbd)){
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = $rowcbd["pass"];
		$base = $rowcbd["base"];
		$id_cliente=$rowcbd["id_client"];

		$sqlcsi = "select * from sgm_clients_servidors where id_client=".$id_cliente." and visible=1";
		$resultcsi= mysql_query($sqlcsi,$dbhandle);
		while ($rowcsi = mysql_fetch_array($resultcsi)){
			$nagiosServ = 0;
			$httpdServ = 0;
			$mysqldServ = 0;
			$cpuServ = 0;
			$memServ = 0;
			$memswapServ = 0;
			$hhddServ = 0;

			$dbhandle3 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
			$db3 = mysql_select_db($base, $dbhandle3) or die("Couldn't open database $myDB");

			$sqlnac = "select count(*) as total from sim_nagios where id_servidor=".$rowcsi["servidor"]."";
			if ($rowcsi["indice"] > 0){ $sqlnac .= " and id >= ".$rowcsi["indice"]; }
			$sqlnac .=" order by time_register";
			$resultnac = mysql_query($sqlnac,$dbhandle3);
			$rownac = mysql_fetch_array($resultnac);
			$i = $rownac["total"];

			$sqlna = "select * from sim_nagios where id_servidor=".$rowcsi["servidor"]."";
			if ($rowcsi["indice"] > 0){ $sqlna .= " and id >= ".$rowcsi["indice"]; }
			$sqlna .=" order by time_register";
			$resultna = mysql_query($sqlna,$dbhandle3);
			while ($rowna = mysql_fetch_array($resultna)){

				$text= $id_cliente." - ".$rowcsi["servidor"]." - ".date("Y-m-d H:i:s", $rowna["time_register"])."<br>";

				if ($fechaant != 0){
					$maxtime = $fechaant + $diezmin;
					if ($rowna["time_register"] > $maxtime){
						echo insertar_alerta($id_cliente, $rowcsi["servidor"], $fechaant, $rowna["time_register"], $rowna["id"], "81");
						$text.= " - 81/n";
						echo controlLog($text);
					}

					if (($i != 1) and (($rowna["time_register"]+$diezmin) < time())){
						echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "82");
						$text.= " - 82/n";
						echo controlLog($text);
					}
				}

				if ($rowna["nagios"] == 0){
					if($nagiosant == 0) {$nagiosServ++;} else {$nagiosServ = 0;}
				} else {
					$nagiosServ = 0;
				}
				if ($rowna["httpd"] == 0){
					if($httpdant == 0) {$httpdServ++;} else {$httpdServ = 0;}
				} else {
					$httpdServ = 0;
				}
				if ($rowna["mysqld"] == 0){
					if($mysqldant == 0) {$mysqldServ++;} else {$mysqldServ = 0;}
				} else {
					$mysqldServ = 0;
				}
				if ($rowna["cpu"] > $cpu){
					if($cpuant > $cpu) {$cpuServ++;} else {$cpuServ = 0;}
				} else {
					$cpuServ = 0;
				}
				if ($rowna["mem"] > $mem){
					if($memant > $mem) {$memServ++;} else {$memServ = 0;}
				} else {
					$memServ = 0;
				}
				if ($rowna["mem_swap"] < $memswap){
					if($memswapant < $memswap) {$memswapServ++;} else {$memswapServ = 0;}
				} else {
					$memswapServ = 0;
				}
				if ($rowna["hd"] < $hhdd){
					if($hhddant < $hhdd) {$hhddServ++;} else {$hhddServ = 0;}
				} else {
					$hhddServ = 0;
				}

				if ($nagiosServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "1");
					$nagiosServ = 0;
					$text.= " - 1/n";
					echo controlLog($text);
				}
				if ($httpdServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "2");
					$httpdServ = 0;
					$text.= " - 2/n";
					echo controlLog($text);
				}
				if ($mysqldServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "3");
					$mysqldServ = 0;
					$text.= " - 3/n";
					echo controlLog($text);
				}
				if ($cpuServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "4");
					$cpuServ = 0;
					$text.= " - 4/n";
					echo controlLog($text);
				}
				if ($memServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "5");
					$memServ = 0;
					$text.= " - 5/n";
					echo controlLog($text);
				}
				if ($memswapServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "6");
					$memswapServ = 0;
					$text.= " - 6/n";
					echo controlLog($text);
				}
				if ($hhddServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "7");
					$hhddServ = 0;
					$text.= " - 7/n";
					echo controlLog($text);
				}
#				echo $nagiosServ."-".$httpdServ."-".$mysqldServ."-".$cpuServ."-".$memServ."-".$memswapServ."-".$hhddServ."-".$rowna["time_register"]."<br>";
				$fechaant = $rowna["time_register"];
				$i--;
				$indice = $rowna["id"];
				$nagiosant = $rowna["nagios"];
				$httpdant = $rowna["httpd"];
				$mysqldant = $rowna["mysqld"];
				$cpuant = $rowna["cpu"];
				$memant = $rowna["mem"];
				$memswapant = $rowna["mem_swap"];
				$hhddant = $rowna["hd"];
			}
			$sql = "update sgm_clients_servidors set ";
			$sql = $sql."indice=".$indice."";
			$sql = $sql." WHERE id_client=".$id_cliente." and servidor=".$rowcsi["servidor"];
			mysql_query($sql,$dbhandle);
		}
	}
}

function insertar_alerta($id_cliente, $servidors, $fechaant, $fechaact, $id, $error)
{
	global $db;
	$sqlcsa = "select * from sgm_clients_servidors_alertes where servidor=".$servidors." and id_cliente=".$id_cliente." and fecha_caida=".$fechaant;
	$resultcsa= mysql_query($sqlcsa,$dbhandle);
	$rowcsa = mysql_fetch_array($resultcsa);
	if (($fechaant != 0) and (!$rowcsa)){
		$sql = "insert into sgm_clients_servidors_alertes (servidor, id_cliente, fecha_caida, caido, error) ";
		$sql = $sql."values (";
		$sql = $sql."".$servidors."";
		$sql = $sql.",".$id_cliente."";
		$sql = $sql.",".$fechaant."";
		$sql = $sql.",0";
		$sql = $sql.",".$error."";
		$sql = $sql.")";
		mysql_query($sql);
#echo $sql."<br>";

		$sqlc = "select * from sgm_clients where id=".$id_cliente."";
		$resultc= mysql_query($sqlc,$dbhandle);
		$rowc = mysql_fetch_array($resultc);
		$sqlcos = "select * from sgm_contratos_servicio where servicio like '%inci%' and id_contrato in (select id from sgm_contratos where id_cliente=".$id_cliente." and activo=1 and id_contrato_tipo between 1 and 2)";
		$resultcos= mysql_query($sqlcos,$dbhandle);
		$rowcos = mysql_fetch_array($resultcos);
		$sqlcsi = "select * from sgm_clients_servidors where id_client=".$id_cliente." and id=".$servidors;
		$resultcsi= mysql_query($sqlcsi);
		$rowcsi = mysql_fetch_array($resultcsi);
		$sql = "insert into sgm_incidencias (id_usuario_destino,id_usuario_origen,id_servicio,fecha_inicio,fecha_registro_inicio,fecha_prevision,id_estado,id_entrada,notas_registro,asunto)";
		$sql = $sql."values (";
		$sql = $sql."28";
		$sql = $sql.",28";
		if ($rowcos["id"] != 0){
			$sql = $sql.",".$rowcos["id"]."";
		} else {
			$sql = $sql.",0";
		}
		$data = time();
		$sql = $sql.",".$data."";
		$sql = $sql.",".$data."";
		$prevision = fecha_prevision($rowcos["id"], $data);
		$sql = $sql.",".$prevision."";
		$sql = $sql.",-1";
		$sql = $sql.",4";
		if($error == 1) {$texto_error = 'servicio nagios';}
		if($error == 2) {$texto_error = 'servicio httpd';}
		if($error == 3) {$texto_error = 'servicio mysqld';}
		if($error == 4) {$texto_error = 'espacio CPU';}
		if($error == 5) {$texto_error = 'memoria';}
		if($error == 6) {$texto_error = 'memoria swap';}
		if($error == 7) {$texto_error = 'disco duro';}
		if($error == 8) {$texto_error = 'tiempo de respuesta';}
		$sql = $sql.",'El servidor ".$rowcsi["descripcion"]." del cliente ".$rowc["nombre"]." tiene una alerta ".$texto_error."'";
		$sql = $sql.",'Alerta servidor ".$rowcsi["descripcion"]."'";
		$sql = $sql.")";
		mysql_query($sql);
#echo $sql."<br>";
#		send_mail("Alerta servidor ".$rowcsi["descripcion"]."","El servidor ".$rowcsi["descripcion"]." del cliente ".$rowc["nombre"]." tiene una alerta ".$texto_error."");
	}
	if ($fechaact != 0) {
		$sqlcsa = "select * from sgm_clients_servidors_alertes where servidor=".$servidors." and id_cliente=".$id_cliente." and error=".$error." and caido=0 order by id desc";
		$resultcsa= mysql_query($sqlcsa,$dbhandle);
		$rowcsa = mysql_fetch_array($resultcsa);
		if ($rowcsa){
			$tiempo = $fechaact - $rowcsa["fecha_caida"];
			$sql = "update sgm_clients_servidors_alertes set ";
			$sql = $sql."fecha_subida=".$fechaact."";
			$sql = $sql.",tiempo=".$tiempo."";
			$sql = $sql.",caido=1";
			$sql = $sql." WHERE id=".$rowcsa["id"]."";
			mysql_query($sql);
#echo $sql."<br>";
		}
	}
}

function controlLog($text){
	if (!$gestor = fopen("controlLog.txt", "a+")) { echo "No se pueden grabar los datos de registro de accesos."; }
	if (fwrite($gestor, $text.Chr(13)) === FALSE) { echo "Cannot write to file ($filename)"; }
}

function encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return base64_encode($result);
}

function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

function informesContratos(){
	global $db,$Informes,$Cliente,$Mes,$Ano,$Horas,$Imprimir,$urlmgestion,$Contrato,$Ver_Horas;
	echo "<strong>".$Informes."</strong>";
	echo "<br><br>";
	echo "<center><table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td>".$Cliente."</td>";
			echo "<td>".$Contrato."</td>";
			echo "<td>".$Mes."-".$Ano."</td>";
			echo "<td>".$Ver_Horas."</td>";
			echo "<td></td>";
		echo "</tr><tr>";
			echo "<form method=\"post\" name=\"form2\" action=\"".$urlmgestion."/mgestion/gestion-contratos-informe-print-pdf.php\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
			echo "<td><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:300px\" onchange=\"desplegableCombinado5()\">";
				echo "<option value=\"0\">Todos</option>";
				$sqli = "select * from sgm_clients where visible=1 and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
				$resulti = mysql_query(convert_sql($sqli));
				while ($rowi = mysql_fetch_array($resulti)) {
					if ($_POST["id_cliente"] == $rowi["id"]){
						echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["nombre"]." ".$rowi["apellido1"]." ".$rowi["apellido2"]."</option>";
					} else {
						echo "<option value=\"".$rowi["id"]."\">".$rowi["nombre"]." ".$rowi["apellido1"]." ".$rowi["apellido2"]."</option>";
					}
				}
			echo "</select></td>";
			echo "<td><select name=\"id_contrato\" id=\"id_contrato\" style=\"width:300px\" onchange=\"desplegableCombinado5()\">";
				echo "<option value=\"0\">Todos</option>";
				$sqlc = "select id,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_POST["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				while ($rowc = mysql_fetch_array($resultc)) {
					if ($_POST["id_contrato"] == $rowc["id"]){
						echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$rowc["id"]."\">".$rowc["descripcion"]."</option>";
					}
				}
			echo "</select></td>";
			$sqlco = "select * from sgm_contratos where id=".$_POST["id_contrato"]." order by fecha_ini";
			$resultco = mysql_query(convert_sql($sqlco));
			$rowco = mysql_fetch_array($resultco);
			if ($rowco){
				$mes_ini = date("U",strtotime($rowco["fecha_ini"]));
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
				$mes_act = $mes_ini;
			} else {
				$mes_ini = 0;
				$mes_fin = 0;
				$count = 1;
				$sqlco2 = "select * from sgm_contratos where visible=1 and activo=1";
				if ($_POST["id_cliente"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysql_query(convert_sql($sqlco2));
				while ($rowco2 = mysql_fetch_array($resultco2)){
					if (count == 1) {$mes_ini = date("U",strtotime($rowco2["fecha_ini"])); $mes_fin = date("U",strtotime($rowco2["fecha_fin"])); $count ++;}
					else {
						if ($rowco2["fecha_ini"] < $mes_ini) {$mes_ini = date("U",strtotime($rowco2["fecha_ini"]));}
						if ($rowco2["fecha_fin"] > $mes_ini) {$mes_fin = date("U",strtotime($rowco2["fecha_fin"]));}
					}
				}
				$mes_act = $mes_ini;
			}
			echo $mes_act;
			echo "<td style=\"width:100px;\"><select name=\"fecha\" style=\"width:150px;\">";

				while (($mes_ini<=$mes_act) and ($mes_act<=$mes_fin)){
					$any_inicio = date("Y",$mes_act);
					$mes_inicio = date("m",$mes_act);

					echo "<option value=\"".$mes_inicio."-".$any_inicio."\">".$mes_inicio."-".$any_inicio."yy</option>";
					$proxim_any = date("Y",$mes_act);
					$proxim_mes = date("m",$mes_act);
					$proxim_dia = date("d",$mes_act);
					$mes_act = date("U",mktime(0,0,0,$proxim_mes+1,$proxim_dia,$proxim_any));
					
				}
			echo "</select></td>";
			echo "<td><select name=\"horas\" style=\"width:50px\">";
				echo "<option value=\"0\" selected>NO</option>";
				echo "<option value=\"1\">SI</option>";
			echo "</select></td>";
			echo "<td><input type=\"Submit\" value=\"".$Imprimir."\" style=\"width:100px\"></td>";
			echo "</form>";
		echo "</tr>";
	echo "</table></center>";
}

?>
