<?php
error_reporting(~E_ALL);


function simAlert(){
	global $db,$dbhandle;
	$diezmin = 600;
	$fechaant = 0;

	$sqlcsa = "select * from sgm_clients_servidors_param";
	$resultcsa = mysql_query($sqlcsa,$dbhandle);
	$rowcsa = mysqli_fetch_array($resultcsa);
	$cpu = $rowcsa["cpu"];
	$mem = $rowcsa["mem"];
	$memswap = $rowcsa["memswap"];
	$hhdd = $rowcsa["hd"];

	$sqlcbd = "select * from sgm_clients_bases_dades where visible=1";
	$resultcbd = mysql_query($sqlcbd,$dbhandle);
	while ($rowcbd = mysqli_fetch_array($resultcbd)){
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = $rowcbd["pass"];
		$base = $rowcbd["base"];
		$id_cliente=$rowcbd["id_client"];

		$sqlcsi = "select * from sgm_clients_servidors where id_client=".$id_cliente." and visible=1";
		$resultcsi= mysql_query($sqlcsi,$dbhandle);
		while ($rowcsi = mysqli_fetch_array($resultcsi)){
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
			$rownac = mysqli_fetch_array($resultnac);
			$i = $rownac["total"];

			$sqlna = "select * from sim_nagios where id_servidor=".$rowcsi["servidor"]."";
			if ($rowcsi["indice"] > 0){ $sqlna .= " and id >= ".$rowcsi["indice"]; }
			$sqlna .=" order by time_register";
			$resultna = mysql_query($sqlna,$dbhandle3);
			while ($rowna = mysqli_fetch_array($resultna)){

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
	global $db,$dbhandle;
	$sqlcsa = "select * from sgm_clients_servidors_alertes where servidor=".$servidors." and id_cliente=".$id_cliente." and fecha_caida=".$fechaant;
	$resultcsa= mysql_query($sqlcsa,$dbhandle);
	$rowcsa = mysqli_fetch_array($resultcsa);
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
		$rowc = mysqli_fetch_array($resultc);
		$sqlcos = "select * from sgm_contratos_servicio where servicio like '%inci%' and id_contrato in (select id from sgm_contratos where id_cliente=".$id_cliente." and activo=1 and id_contrato_tipo between 1 and 2)";
		$resultcos= mysql_query($sqlcos,$dbhandle);
		$rowcos = mysqli_fetch_array($resultcos);
		$sqlcsi = "select * from sgm_clients_servidors where id_client=".$id_cliente." and id=".$servidors;
		$resultcsi= mysql_query($sqlcsi);
		$rowcsi = mysqli_fetch_array($resultcsi);
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
		$rowcsa = mysqli_fetch_array($resultcsa);
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

?>