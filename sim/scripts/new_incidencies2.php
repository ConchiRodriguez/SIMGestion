<?php
include ("config.php");
include ("auxiliar/functions.php");
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sqli = "select * from sgm_incidencias where visible=1 and id_incidencia=0 and fecha_registro_cierre<>0";
	$resulti = mysql_query(convert_sql($sqli));
	while ($rowi = mysql_fetch_array($resulti)){
		$sqlin = "select * from sgm_incidencias where visible=1 and id_incidencia=".$rowi["id"]."";
		$resultin = mysql_query(convert_sql($sqlin));
		while ($rowin = mysql_fetch_array($resultin)){
			$data_pre = date("Y-m-d H:i:s", $rowin["fecha_registro_inicio"]-120);
			$data_pos = date("Y-m-d H:i:s", $rowin["fecha_registro_inicio"]+120);
			$sqlip = "select * from sgm_incidencias_pausa where id_incidencia=".$rowi["id"]." and data_pausa between '".$data_pre."' and '".$data_pos."'";
			$resultip = mysql_query(convert_sql($sqlip));
			$rowip = mysql_fetch_array($resultip);
			if ($rowip){
				$sqlii = "update sgm_incidencias set ";
				$sqlii = $sqlii."pausada=1";
				$sqlii = $sqlii." WHERE id=".$rowin["id"]."";
				mysql_query(convert_sql($sqlii));
		echo $sqlii."<br>";
			}
		}
		$contador = 0;
		$sqlin = "select * from sgm_incidencias where visible=1 and id_incidencia=".$rowi["id"]." order by fecha_inicio";
		$resultin = mysql_query(convert_sql($sqlin));
		while ($rowin = mysql_fetch_array($resultin)){
			if ($rowin["pausada"] == 1) {
				$pausada = 1;
				if ($contador == 0){
					$id_pausada = $rowin["id"];
					$contador++;
				}
			} else {
				$pausada = 0;
			}
		}
		if (($contador > 0) and ($pausada=1)){
			$sqlin = "select * from sgm_incidencias where visible=1 and id=".$id_pausada;
			$resultin = mysql_query(convert_sql($sqlin));
			$rowin = mysql_fetch_array($resultin);
			$fecha = $rowin["fecha_inicio"];
		} else {
			$fecha = $rowi["fecha_cierre"];
		}
		$sqlc = "select * from sgm_contratos_servicio where id=".$rowi["id_servicio"]."";
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		if ($rowc["temps_resposta"] != 0){
			if ($rowi["fecha_prevision"] > 0){
				$hora_limit = $rowi["fecha_prevision"] - $rowi["fecha_cierre"];
			} else {
				$hora_limit = (fecha_prevision($rowi["id_servicio"],$rowi["fecha_inicio"])) - $fecha;
			}
			if ($hora_limit >= 0){ $sla = 1;} else { $sla = 0;}
		} else {
			$sla = 0;
		}
		if ($rowi["fecha_cierre"] == 0){ $fecha_cierre = $rowi["fecha_registro_cierre"];} else { $fecha_cierre = $rowi["fecha_cierre"];}
		$sqlii = "update sgm_incidencias set ";
		$sqlii = $sqlii."fecha_cierre=".$fecha_cierre."";
		$sqlii = $sqlii.",sla=".$sla."";
		$sqlii = $sqlii." WHERE id=".$rowi["id"]."";
		mysql_query(convert_sql($sqlii));
		echo $sqlii."<br>";
	}


function fecha_prevision($id_servicio, $data_ini)
{
	global $db;
	$j = 0;
	$fecha_ini = (date("Y-m-d H:i:s", $data_ini));
	list($fecha,$hora)=explode(" ",$fecha_ini);
	list($any,$mes,$dia)=explode("-", $fecha);

	$sqlc = "select * from sgm_contratos_servicio where id=".$id_servicio;
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc["temps_resposta"] > 0){
		$temps_resposta = ($rowc["temps_resposta"]*3600)-$temps_transcurregut;
		if ($rowc["nbd"] == 0){
			$prevision = $temps_resposta+$data_ini;
		}
		if ($rowc["nbd"] == 1) {
			while ($temps_resposta > 0){
				$festivo = comprobar_festivo($data_ini);
				while ($festivo == 1){
					$j++;
					$dia_dema = date("N", $data_ini+(86400));
					$sqlch = "select * from sgm_calendario_horario where id=".$dia_dema;
					$resultch = mysql_query(convert_sql($sqlch));
					$rowch = mysql_fetch_array($resultch);
					$data_ini = date(U, mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
					$festivo = comprobar_festivo($data_ini);
				}
				if ($festivo == 0){
					$data_ini = $data_ini;
				}
				$dia2 = date("N", ($data_ini));
				$sqlch = "select * from sgm_calendario_horario where id=".$dia2;
				$resultch = mysql_query(convert_sql($sqlch));
				$rowch = mysql_fetch_array($resultch);
				$fin_jornada = date(U, mktime(($rowch["hora_fin"]/3600), 0, 0, $mes, $dia+$j, $any));
				$hores_prev = $temps_resposta - ($fin_jornada - $data_ini);
				if ($hores_prev > 0){
					if (($fin_jornada - $data_ini) >= 0){
						$temps_resposta = $temps_resposta - ($fin_jornada - $data_ini);
					}
					$j++;
					$dia_dema = date("N", $data_ini+ (86400));
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


function comprobar_festivo($fecha)
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

?>