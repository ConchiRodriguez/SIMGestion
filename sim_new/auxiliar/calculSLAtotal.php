<?php
error_reporting(~E_ALL);


function calculSLAtotal(){
	global $db,$dbhandle;
	$sql = "select * from sim_incidencias where id_incidencia=0 and visible=1 and id_estado<>-2";
	$result = mysqli_query($dbhandle,convertSQL($sql));
	while ($row = mysqli_fetch_array($result)){
#		echo $row["id"];
		$pendent = calculSLA($row["id"],0);
		if ($row["pausada"] == 0){$previsio = fecha_prevision($row["id_servicio"], $row["fecha_inicio"]);} else {$previsio = 0;}
		$sql1 = "update sim_incidencias set ";
		$sql1 = $sql1."tiempo_pendiente=".$pendent;
		$sql1 = $sql1.",fecha_prevision=".$previsio;
		$sql1 = $sql1." WHERE id=".$row["id"]."";
		mysqli_query($dbhandle,$sql1);
#		echo $sql1."<br>";
	}
}

function calculSLA($id,$cierre){
	global $db,$dbhandle;
	$sql = "select * from sim_incidencias where id=".$id."";
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);

	$durada = 0;
	$pausada = 0;

	$sqlc = "select * from sim_contratos_servicio where id=".$row["id_servicio"];
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);
		$contador = 0;
		$fecha_ant = 0;
		$sqld = "select * from sim_incidencias where id_incidencia=".$id." and visible=1 and fecha_inicio >= ".$row["fecha_inicio"]." order by fecha_inicio";
		$resultd = mysqli_query($dbhandle,convertSQL($sqld));
		while ($rowd = mysqli_fetch_array($resultd)){
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

	$sqlc = "select * from sim_contratos_servicio where id=".$row["id_servicio"];
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);
	$sla = ($rowc["temps_resposta"]*3600)-$durada;
#	echo "ID:".$row["id"]."SLA:".($sla/3600)."Durada:".($durada/3600)."Temps Resposta:".$rowc["temps_resposta"]."<br>";
	return $sla;
}


function buscaFestivo($fecha_act,$fecha_ant){
	global $db,$dbhandle;
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

	if (comprobar_festivo2($data_ant) == 0){
		$diaSemana2 = date("N", ($data_ant));
		$sqlch2 = "select * from sim_calendario_horario where id=".$diaSemana2."";
		$resultch2 = mysqli_query($dbhandle,convertSQL($sqlch2));
		$rowch2 = mysqli_fetch_array($resultch2);
		if ($fecha_ant < ($data_ant+$rowch2["hora_fin"])) {$y= $time_ant;}
		if ($fecha_ant < ($data_ant+$rowch2["hora_inicio"])){$y= $rowch2["hora_inicio"];}
		if ($fecha_ant > ($data_ant+$rowch2["hora_inicio"])) {$y= $time_ant;}
		if ($fecha_ant > ($data_ant+$rowch2["hora_fin"])) {$y= $rowch2["hora_fin"];}
	} else {
		$y= 0;
	}

	if (comprobar_festivo2($data_act) == 0){
		$diaSemana = date("N", ($data_act));
		$sqlch = "select * from sim_calendario_horario where id=".$diaSemana."";
		$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
		$rowch = mysqli_fetch_array($resultch);
		if ($fecha_act < ($data_act+$rowch["hora_fin"])) {$x = $time_act;}
		if ($fecha_act < ($data_ant+$rowch["hora_inicio"])){$x= $rowch["hora_inicio"];}
		if ($fecha_act > ($data_ant+$rowch["hora_inicio"])) {$x= $time_act;}
		if ($fecha_act > ($data_act+$rowch["hora_fin"])){$x= $rowch["hora_fin"];}
	} else {
		$x= 0;
	}

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
			$sqlch = "select * from sim_calendario_horario where id=".$diaSemanaX."";
			$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
			$rowch = mysqli_fetch_array($resultch);
			$tiempo += (($data_ant+$rowch["hora_fin"]) - ($data_ant+$rowch["hora_inicio"]));
#			echo "g".($tiempo/3600)."<br>";
		}
		$data_ant = sumaDies($data_ant,1);
	}

	return $tiempo;
}

function fecha_prevision($id_servicio, $data_ini)
{
	global $db,$dbhandle;

	$sqlc = "select * from sim_contratos_servicio where id=".$id_servicio;
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);
	if ($rowc["temps_resposta"] > 0){
		$temps_resposta = ($rowc["temps_resposta"]*3600);
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
					$sqlch = "select * from sim_calendario_horario where id=".$dia_dema;
					$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
					$rowch = mysqli_fetch_array($resultch);
					$data_ini = date('U', mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
					$festivo = comprobar_festivo2($data_ini);
				}
				$dia2 = date("N", ($data_ini));
				$sqlch = "select * from sim_calendario_horario where id=".$dia2;
				$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
				$rowch = mysqli_fetch_array($resultch);
				$inici_jornada = date('U', mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
				if ($data_ini >= $inici_jornada) {$data_ini=$data_ini;} else {$data_ini=$inici_jornada;}
				$fin_jornada = date('U', mktime(($rowch["hora_fin"]/3600), 0, 0, $mes, $dia+$j, $any));
				$hores_prev = $temps_resposta - ($fin_jornada - $data_ini);
				if ($hores_prev > 0){
					if (($fin_jornada - $data_ini) >= 0){
						$temps_resposta = $temps_resposta - ($fin_jornada - $data_ini);
					}
					$j++;
					$dia_dema = date("N", sumaDies($data_ini,1));
					$sqlch2 = "select * from sim_calendario_horario where id=".$dia_dema;
					$resultch2 = mysqli_query($dbhandle,convertSQL($sqlch2));
					$rowch2 = mysqli_fetch_array($resultch2);
					$data_ini = date('U', mktime(($rowch2["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
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
	global $db,$dbhandle;
	$festivo=0;
#Extreiem l'hora a la que acabaria la peça
	$dia_sem = date("w", ($fecha));
	if ($dia_sem == 0){
		$festivo=1;
	}
	if ($dia_sem == 6){
		$festivo=1;
	}
	$sqlc = "select * from sim_calendario where dia=".date("j", ($fecha))." and mes=".date("n", ($fecha))."";
	$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
	$rowc = mysqli_fetch_array($resultc);
	if ($rowc){
		$festivo=1;
	}
#	echo $festivo."<br>";
	return $festivo;
}

?>