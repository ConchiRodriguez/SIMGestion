<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);

if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1017) AND ($autorizado == true)) {
	if ($_GET["usuario"] == "") { $usuario = $userid; }
	else {
		$sql = "select * from sgm_users where id=".$_GET["usuario"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$usuario = $row["id"];
	}
	$sql = "select * from sgm_users where id=".$usuario;
	$result = mysql_query(convertSQL($sql));
	$rowusuario = mysql_fetch_array($result);

### IDENTIFICACION DE LAS FECHAS
	if ($_GET["dd"] == "") {
		$dia = date("d"); $mes = date("m"); $any = date("Y");
	} else {
		$dia = $_GET["dd"]; $mes = $_GET["mm"]; $any = $_GET["aa"];
	}

	if ($mes == 1) { 
		$emes = 12;
		$eany = $any-1;
	} else {
		$emes = $mes-1;
		if ($emes < 10) { $emes = "0".$emes; }
		$eany = $any;
	}
	if ($mes == 12) {
		$dmes = "01";
		$dany = $any+1;
	} else { 
		$dmes = $mes+1;
		if ($dmes < 10) { $dmes = "0".$dmes; }
		$dany = $any;
	}

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<center><table><tr>";
				echo "<td style=\"height:20px;width:120px;\";><strong>".$Tareas." :</strong></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 0) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=0&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$General."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 10) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=10&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Calendario."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 20) and ($_GET["id"] == "")) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=20&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Nueva." ".$Tarea."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 30) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=30&dd=".$dia."&aa=".$any."&mm=".$mes."&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Imprimir."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 200) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=200&dd=".$_GET["dd"]."&aa=".$_GET["aa"]."&mm=".$_GET["mm"]."&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Sincronizar."</a></td>";
				if ($admin == true) {
					$color = "#4B53AF";
					$lcolor = "white";
					if ($soption == 40) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=40&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Administrar."</a></td>";
				}

				if ($soption == 0){
					echo "</tr><tr><td></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 4) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=0&ssop=4&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Completa."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 3) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=0&ssop=3&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Historico."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
				}
				if ($soption == 30){
					echo "</tr><tr><td></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 0) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=30&ssop=0&usuario=".$userid."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" class=\"gris\" style=\"color:".$lcolor."\">".$Jornada."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 1) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=30&ssop=1&usuario=".$userid."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" class=\"gris\" style=\"color:".$lcolor."\">".$Semana."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 2) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=30&ssop=2&usuario=".$userid."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" class=\"gris\" style=\"color:".$lcolor."\">".$Mes."</a></td>";
#					$color = "#4B53AF";
#					$lcolor = "white";
#					if ($ssoption == 3) { $color = "white"; $lcolor = "blue"; }
#					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=30&ssop=3&usuario=".$userid."&dia=".$dia."&mes=".$mes."&any=".$any."\" class=\"gris\" style=\"color:".$lcolor."\">Todas</a></td>";
				}
				if ($soption == 20){
					echo "</tr><tr><td></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($_GET["inc"] == 0) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=20&inc=0&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Tarea."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($_GET["inc"] == 1) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=20&inc=1&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Telefonica."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($_GET["inc"] == 2) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1017&sop=20&inc=2&usuario=".$userid."\" class=\"gris\" style=\"color:".$lcolor."\">".$Nota."</a></td>";
				}
			echo "</tr></table></center>";
		echo "</td></tr></table><br>";

		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";



if (($soption == 0) and ($ssoption <= 2)) {
	if ($ssoption == 1) {
		$sql = "update sgm_tareas set ";
		$sql = $sql."id_origen=".$_POST["id_origen"]."";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convertSQL($sql));
	}
	if ($ssoption == 2) {
		$sql = "update sgm_tareas set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convertSQL($sql));
	}
	echo "<center>";
	echo "<table style=\"width:100%\" cellpadding=\"2\" cellspacing=\"2\" >";
		echo "<tr>";
			echo "<td style=\"width:120px;vertical-align : top;text-align:left;\">";
				echo "<table cellpadding=\"0\">";
					echo "<tr>";
						echo "<td style=\"vertical-align : top;text-align:left;\">";
							echo "<table><tr><td style=\"vertical-align : top;\">";
								echo agenda_mes($dia,$any,$mes,$usuario,$soption);
								echo "</td><td style=\"vertical-align : top;\">";
								if ($mes == 12){ $m = 01; $a = $any+1; } else { $m = $mes+1; $a = $any; }
								echo agenda_mes(0,$a,$m,$usuario,$soption);
								echo "</td></tr></table>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td><td>";
				echo "<form name=\"formulari\" action=\"index.php?op=1017&sop=0&usuario=".$usuario."\" method=\"post\">";
				echo "<table cellspacing=\"20\">";
					echo "<tr><td><strong>".$Seleccionar." ".$Agendas." (maximo de 2) :</strong></td></tr>";
					echo "<tr>";
						echo "<td><table><tr>";
						$casilla = $_POST["casilla1"];
						$sql = "select * from sgm_agendas_users where visible=1 and id_user=".$usuario;
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)){
							$sqlv = "select * from sgm_agendas where visible=1 and id=".$row["id_agenda"];
							$resultv = mysql_query(convertSQL($sqlv));
							while ($rowv = mysql_fetch_array($resultv)){
									echo "<td style=\"vertical-align:center;font-size:15px;font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;\"><input class=\"bigcheck\" type=\"checkbox\" name=\"casilla1[]\" value=\"".$rowv["id"]."\" onClick=\"limitarSeleccion()\">".$rowv["nombre"]."</td>";
							}
						}
						echo "<td><input type=\"Submit\" name=\"Ver\" value=\"".$Ver." ".$Agendas."\"></td>";
						echo "</tr></table></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
	echo "</table><table>";
		echo "<tr>";
		if ($_POST["casilla1"] != ""){
			$x=0;
			$casilla = $_POST["casilla1"];
			for ($i = 0 ; $i < count($casilla); $i++){
				$casillas = $casillas.$casilla[$i].",";
			}
			for ($i = 0; $i < strlen($casillas) ; $i++){
				while ($casillas[$i] != ","){
					$id_agenda = $id_agenda.$casillas[$i];
					$i++;
				}
					echo ver_agenda($id_agenda,$dia,$any,$mes,$usuario);
					$x++;
					$sql = "update sgm_users set ";
					$sql = $sql."id_agenda".$x."=".$id_agenda."";
					$sql = $sql." WHERE id=".$usuario."";
					mysql_query(convertSQL($sql));
					$id_agenda = "";
			}
			if ($x == 1){
				$sql = "update sgm_users set ";
				$sql = $sql."id_agenda2=-1";
				$sql = $sql." WHERE id=".$usuario."";
				mysql_query(convertSQL($sql));
			}
		} else {
			$sql = "select * from sgm_users where activo=1 and validado=1 and id=".$usuario;
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
				if ($row["id_agenda1"] > 0){echo ver_agenda($row["id_agenda1"],$dia,$any,$mes,$usuario);}
				if ($row["id_agenda2"] > 0){echo ver_agenda($row["id_agenda2"],$dia,$any,$mes,$usuario);}
		}
			echo "<td style=\"vertical-align:top;\">";
			$horainici = '00:00:00';
			$hoy1 = $any."-".$mes."-".$dia." ".$horainici;
			$horafin = '23:59:59';
			$hoy2 = $any."-".$mes."-".$dia." ".$horafin;
			### DETERMINA SI HAY PERMISO DE EDICION
			$sqlag = "select * from sgm_users where activo=1 and validado=1 and id=".$usuario;
			$resultag = mysql_query(convertSQL($sqlag));
			$rowag = mysql_fetch_array($resultag);
				if ($rowag["id_agenda1"] == $rowag["id_agenda2"]) {$agenda2 = "";} else { $agenda2 = $rowag["id_agenda2"];}
				########INICI incidenciaS
				echo "<strong>".$Tarea."</strong> (del día ".$seleccionado.")";
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				$estado_color = "White";
				mostrar_incidencia(1,$hoy1,$hoy2,$rowag["id_agenda1"],$agenda2,$usuario);
				echo "</table>";
				########FIN incidenciaS
				########INICI FUTURES
				echo "<br><strong>".$Proximas."</strong>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				$estado_color = "White";
				mostrar_incidencia(2,$hoy1,$hoy2,$rowag["id_agenda1"],$agenda2,$usuario);
				echo "</table>";
				########FIN PENDIENTES NO INICIADAS
				########INICI PENDIENTES SI INICIADAS
				echo "<br><strong>".$Caducadas."</strong>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				$estado_color = "White";
				mostrar_incidencia(3,$hoy1,$hoy2,$rowag["id_agenda1"],$agenda2,$usuario);
				echo "</table>";
				########FIN EJECUTANDOSE
				########INICI notaS
				echo "<br><strong>".$Notas."</strong>";
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				$estado_color = "White";
				mostrar_incidencia(4,$hoy1,$hoy2,$rowag["id_agenda1"],$agenda2,$usuario);
				echo "</table>";
				########FIN notaS
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}


	if (($soption == 0) and (($ssoption == 3) or ($ssoption == 4))) {
		if ($ssoption == 4) {
			echo "<strong>".$General." :</strong>";
			echo "<form action=\"index.php?op=1017&sop=0&ssop=4\" method=\"post\">";
		}
		if ($ssoption == 3) {
			echo "<strong>".$Historico." : </strong>";
			echo "<form action=\"index.php?op=1017&sop=0&ssop=3\" method=\"post\">";
		}

		echo "<br><br>";
		echo "<center><table cellspacing=\"0\">";
			$x=0;
			$sql = "select * from sgm_tareas where visible=1";
			if ($ssoption == 4) { $sql = $sql." and (id_estado <> -2)"; }
			if ($ssoption == 3) { $sql = $sql." and id_estado = -2"; }
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {

				$sqlu = "select * from sgm_users where id=".$row["id_usuario_destino"];
				$resultu = mysql_query(convertSQL($sqlu));
				$rowu = mysql_fetch_array($resultu);

				if ($row["id_estado"] > 0) {
					$sqle = "select * from sgm_tareas_estados where id=".$row["id_estado"];
					$resulte = mysql_query(convertSQL($sqle));
					$rowe = mysql_fetch_array($resulte);
					$descripcion_estado = $rowe["estado"];
					$estado_color = $rowe["color"];
					$estado_color_letras = "Black";
				} else {
					if ($row["id_estado"] == -1) { 
						$descripcion_estado = "Registrada";
						$estado_color = "Red";
						$estado_color_letras = "White";
					}
					if ($row["id_estado"] == -2) {
						$descripcion_estado = "Finalizada";
						$estado_color = "White";
						$estado_color_letras = "Black";
					}
				}
				$sqlc = "select * from sgm_contratos_cliente where id=".$row["id_contratos_cliente"];
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr style=\"background-color:".$estado_color.";\">";
					echo "<td style=\"text-align:right;vertical-align:top;color:".$estado_color_letras."\">".$row["id"]."</td>";
					$sqlti = "select count(*) as total from sgm_tareas where id_origen=".$row["id"]." and visible=1";
					$resultti = mysql_query(convertSQL($sqlti));
					$rowti = mysql_fetch_array($resultti);
					if ($rowti["total"] == 0) {
						echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1017&sop=21&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
					} else {echo "<td></td>";}
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=200&id=".$rowc["id"]."\" style=\"color:".$estado_color_letras.";\">".$rowc["num_contrato"]."</a>";
					if ($row["asunto"] != "") {
						echo "<br><strong>".$row["asunto"]."</strong>";
					}
					echo "</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$descripcion_estado."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowd["nombre"]."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">";
					if (strlen($rowu["usuario"]) > 15) {
						 echo "&nbsp;&nbsp;".substr($rowu["usuario"],0,11)." ...";
					} else {
						echo "&nbsp;&nbsp;".$rowu["usuario"]."";
					}
					echo "</td>";
					echo "<td style=\"text-align:center;vertical-align:top;\">";
						echo "<a href=\"index.php?op=1017&sop=20&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px;\"><a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 10) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"text-align:center;vertical-align:top;\">";
					echo "<form name=\"formulari\" action=\"index.php?op=1017&sop=10&usuario=".$usuario."&dd=".$_GET["dd"]."&aa=".$_GET["aa"]."&mm=".$_GET["mm"]."\" method=\"post\">";
					echo "<center><table cellspacing=\"10\" style=\"width:300px\">";
						echo "<tr><td><strong>".$Seleccionar." ".$Agendas." :</strong></td></tr>";
							echo "<td><table><tr>";
							$sql = "select * from sgm_agendas_users where visible=1 and id_user=".$usuario;
							$result = mysql_query(convertSQL($sql));
							while ($row = mysql_fetch_array($result)){
								$sqlv = "select * from sgm_agendas where visible=1 and id=".$row["id_agenda"];
								$resultv = mysql_query(convertSQL($sqlv));
								while ($rowv = mysql_fetch_array($resultv)){
									echo "<tr><td><input type=\"checkbox\" name=\"casilla1[]\" value=\"".$rowv["id"]."\">".$rowv["nombre"]."</td></tr>";
								}
							}
							echo "<tr><td><input type=\"Submit\" name=\"Ver\" value=\"".$Ver." ".$Calendario."\"></td></tr>";
							echo "</table></td>";
						echo "</tr>";
					echo "</form>";
					echo "<tr><td>&nbsp;</td></tr>";
					echo "<tr><td><strong>".$Calendario." de :</strong></td></tr>";
					if ($_POST["casilla1"] != ""){
						$x=0;
						$casilla = $_POST["casilla1"];
						for ($i = 0 ; $i < count($casilla); $i++){
							$casillas = $casillas.$casilla[$i].",";
						}
						for ($i = 0; $i < strlen($casillas) ; $i++){
							while ($casillas[$i] != ","){
								$id_agenda = $id_agenda.$casillas[$i];
								$i++;
							}
							$sqla = "select * from sgm_agendas where visible=1 and id=".$id_agenda;
							$resulta = mysql_query(convertSQL($sqla));
							$rowa = mysql_fetch_array($resulta);
							echo "<tr><td>".$rowa["nombre"]."</td></tr>";
							$id_agenda = "";
						}
					}
					echo "</table></center>";

				echo "</td><td>";
					if ($_GET["dd"] != ""){$dia == $_GET["dd"];}
					if ($_GET["mm"] != ""){$mes == $_GET["mm"];}
					if ($_GET["aa"] != ""){$any == $_GET["aa"];}
					if ($_POST["casilla1"] != ""){ $id_agendas = $_POST["casilla1"];} else { $id_agendas = 0;}
					echo calendario_conjunto($dia,$any,$mes,$usuario,$id_agendas);
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 20) {
		if ($ssoption == 1) {
			$reinicia_estat = false;
			$sqli = "select * from sgm_tareas where id=".$_GET["id"];
			$resulti = mysql_query(convertSQL($sqli));
			$rowi = mysql_fetch_array($resulti);
			if (($rowi["id_agenda"] != $_POST["id_agenda"]) and ($_POST["id_agenda"] != 0)){
				$sql = "insert into sgm_tareas_canvio_usuario (id_tarea, id_agenda, fecha, motivo) ";
				$sql = $sql."values (";
				$sql = $sql.$_GET["id"];
				$sql = $sql.",".$rowi["id_agenda"];
				$a = date("Y");
				$m = date("n");
				$d = date("j");
				$xfecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i:s");
				$sql = $sql.",'".$xfecha."'";
				$sql = $sql.",'".comillas($_POST["motivo"])."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
				$reinicia_estat = true;
			}
			if ($_POST["notas_desarrollo"] != ""){
				$sql = "insert into sgm_tareas_notas_desarrollo (id_tarea, id_agenda, fecha, notas) ";
				$sql = $sql."values (";
				$sql = $sql.$_GET["id"];
				$sql = $sql.",".$userid;
				$a = date("Y");
				$m = date("n");
				$d = date("j");
				$xfecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i:s");
				$sql = $sql.",'".$xfecha."'";
				$sql = $sql.",'".comillas($_POST["notas_desarrollo"])."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
			}
			$sql = "update sgm_tareas set ";
			$sql = $sql."id_agenda=".$_POST["id_agenda"]."";
			$sql = $sql.",id_2=".$_POST["id_agenda2"]."";
			$sql = $sql.",id_3=".$_POST["id_agenda3"]."";
			$sql = $sql.",id_4=".$_POST["id_agenda4"]."";
			$sql = $sql.",id_5=".$_POST["id_agenda5"]."";
			$sql = $sql.",id_6=".$_POST["id_agenda6"]."";
			$sql = $sql.",id_7=".$_POST["id_agenda7"]."";
			$sql = $sql.",id_8=".$_POST["id_agenda8"]."";
			$sql = $sql.",id_9=".$_POST["id_agenda9"]."";
			$sql = $sql.",id_10=".$_POST["id_agenda10"]."";
			$sql = $sql.",privada=".$_POST["privada"]."";
			$sql = $sql.",id_cliente=".$_POST["id_cliente"]."";
			$sql = $sql.",id_servicio=".$_POST["id_servicio"]."";
			$sql = $sql.",data_registro='".$_POST["data_registro"]."'";
			$sql = $sql.",data_margen='".$_POST["data_margen"]."'";
			$sql = $sql.",tiempo=".$_POST["tiempo"]."";
			$sql = $sql.",aviso=".$_POST["aviso"]."";
			if ($reinicia_estat == false) {
				$sql = $sql.",id_estado=".$_POST["id_estado"]."";
			} else {
				$sql = $sql.",id_estado=-1";
			}
			$sql = $sql.",id_entrada=".$_POST["id_entrada"]."";
			$sql = $sql.",id_tipo=".$_POST["id_tipo"]."";
			$sql = $sql.",notas_conclusion='".comillas($_POST["notas_conclusion"])."'";
			$sql = $sql.",programada=".$_POST["programada"];
			$sql = $sql.",cliente_nombre='".$_POST["cliente_nombre"]."'";
			$sql = $sql.",cliente_contacto='".$_POST["cliente_contacto"]."'";
			$sql = $sql.",asunto='".comillas($_POST["asunto"])."'";
			if ($_POST["id_estado"] == -2){
				$sql = $sql.",id_usuario_finalizacion=".$userid;
				$a = date("Y");
				$m = date("n");
				$d = date("j");
				$xfecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i:s");
				$sql = $sql.",data_finalizacion='".$xfecha."'";
			}
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 6) {
			$sql = "update sgm_tareas set ";
			$sql = $sql."id_origen=0";
			$sql = $sql." WHERE id=".$_GET["id_tarea"]."";
			mysql_query(convertSQL($sql));
		}

		if ($_GET["inc"] == 0) {echo "<strong>Edición de Tarea:</strong>";}
		if ($_GET["inc"] == 1) {echo "<strong>Edición de Tarea ".$Telefonica.":</strong>";}
		if ($_GET["inc"] == 2) {echo "<strong>Edición de nota:</strong>";}
		$editando = false;

		$a = date("Y");
		$m = date("n");
		$d = date("j");

		if ($_GET["id"] == ""){
			echo "<form action=\"index.php?op=1017&sop=21\" method=\"post\">";
			$fecha_prevision = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i");
			if ($_POST["data_registro"] != "") { $fecha_prevision = $_POST["data_registro"]; }
			$fecha_margen = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i");
			if ($_POST["data_registro"] != "") { $fecha_margen = $_POST["data_registro"]; }
			$fecha_reg = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i");
			$usuario_con_permiso = true;
		} else {
			$sql = "select * from sgm_tareas where id=".$_GET["id"];
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			$fecha_prevision = $row["data_registro"];
			$fecha_margen = $row["data_margen"];
			$fecha_reg = $row["data_insert"];

			$sqlu = "select * from sgm_users where id=".$row["id_usuario"];
			$resultu = mysql_query(convertSQL($sqlu));
			$rowu = mysql_fetch_array($resultu);

			echo "&nbsp;&nbsp;".$Numero." : <strong>".$row["id"]."</strong>";
			echo "&nbsp;&nbsp;".$Origen." : <strong>".$rowu["usuario"]."</strong>";

			if ($row["id_estado"] == -2) {
				$sqlu = "select * from sgm_users where id=".$row["id_usuario_finalizacion"];
				$resultu = mysql_query(convertSQL($sqlu));
				$rowu = mysql_fetch_array($resultu);
				echo "&nbsp;&nbsp; ".$Usuario." / ".$Fecha." ".$Finalizacion." : <strong>".$rowu["usuario"]." / ".$row["data_finalizacion"]."</strong>";
			}
			echo "<form action=\"index.php?op=1017&sop=20&ssop=1&id=".$row["id"]."\" method=\"post\">";
			$editando = true;

			### DETERMINA SI HAY PERMISO DE EDICION
			$usuario_con_permiso = false;
			if ($row["id_agenda"] == 0){$usuario_con_permiso = true;}
			$sqli = "select count(*) as total from sgm_agendas_users where escritura=1 and id_agenda=".$row["id_agenda"]." and id_user=".$userid;
			$resulti = mysql_query(convertSQL($sqli));
			$rowi = mysql_fetch_array($resulti);
			if (($rowi["total"] == 1) or ($editando == false)) {
				$usuario_con_permiso = true;
			}
			if ($row["id_estado"] == -2) { $usuario_con_permiso = false; }
		}

		if ($editando == true) {
				$sqlc = "select * from sgm_clients where id=".$row["id_cliente"];
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);

			if ($row["id_cliente"] <> 0) { echo " <a href=\"index.php?op=1008&sop=201&id=".$row["id_cliente"]."\">[ ".$Ficha." de  <strong>".$rowc["nombre"]."</strong> ]</a>"; }
		}

		if ($usuario_con_permiso == true) {
			echo " <a href=\"index.php?op=1017&sop=24&id=".$_GET["id"]."&usuario=".$_GET["usuario"]."\">[ ".$Eliminar." ".$Tarea." ]</a>";
		}
		echo "<br><center><table>";
		echo "<tr><td><table cellspacing=\"0\" cellspacing=\"0\">";

		#inicio de la tabla de modificación o inserción.

		if ($usuario_con_permiso == true) {
			echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:200px\"></td></tr>";
		}

		if ($_GET["inc"] != 2){
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Fecha." ".$Registro." :</td>";
				echo "<td><input type=\"Text\" name=\"data_insert\" value=\"".$fecha_reg."\" style=\"width:150px;text-align:left;\"></td>";
			echo "</td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Origen." ".$tarea." :</td><td><select name=\"id_entrada\" class=\"px150\">";
				echo "<option value=\"0\" selected>-</option>";
				$sqle = "select * from sgm_incidencias_entrada order by entrada";
				$resulte = mysql_query(convertSQL($sqle));
				while ($rowe = mysql_fetch_array($resulte)) {
					if ($rowe["id"] == $row["id_entrada"] ) {
						echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["entrada"]."</option>";
					} else {
						echo "<option value=\"".$rowe["id"]."\">".$rowe["entrada"]."</option>";
					}
				}
			echo "</select></td></tr>";

			echo "<tr><td>&nbsp;</td></tr>";

			if ($editando == true) { $cliente = $row["id_cliente"]; }
			if ($editando == false) {
				if ($_POST["id_cliente"] != 0) {
					$cliente = $_POST["id_cliente"];
				} else {
					$cliente = $_GET["id_cliente"];
				}
			}
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;vertical-align:top;\">".$Cliente." :</td><td><select name=\"id_cliente\" class=\"px300\">";
				echo "<option value=\"0\" selected>-</option>";
					$sqlc = "select * from sgm_clients where visible=1 order by nombre, id_agrupacio";
					$resultc = mysql_query(convertSQL($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						if ($rowc["id"] == $cliente) {
							if ($rowc["id_agrupacio"] == 0 ){
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." (*)</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]."</option>";
							}
						} else {
							if ($rowc["id_agrupacio"] == 0 ){
								echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." (*)</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]."</option>";
							}
						}
					}
				echo "</select>";
			echo "</td></tr>";

			$sqlc = "select * from sgm_clients where visible=1 and id=".$cliente;
			$resultc = mysql_query(convertSQL($sqlc));
			$rowc = mysql_fetch_array($resultc);
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;vertical-align:top;\">".$Telefono." :</td><td><input type=\"Text\" name=\"telefono\" value=\"".$rowc["telefono"]."\" class=\"px300\"></td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;vertical-align:top;\">".$Contacto." :</td><td><input type=\"Text\" name=\"cliente_contacto\" value=\"".$row["cliente_contacto"]."\" class=\"px300\"></td></tr>";

			echo "<tr><td>&nbsp;</td></tr>";

			if ($editando == true) { $servicio = $row["id_servicio"]; }
			if ($editando == false) { 
				if ($_POST["id_servicio"] != 0) {
					$servicio = $_POST["id_servicio"];
				} else {
					$servicio = $_GET["id_servicio"];
				}
			}
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Servicio." :</td><td><select name=\"id_servicio\" class=\"px300\">";
				echo "<option value=\"0\" selected>-</option>";
					$sqlc = "select * from sgm_tareas_servicios where visible=1 order by servicio";
					$resultc = mysql_query(convertSQL($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						if ($rowc["id"] == $servicio) {
							echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["servicio"]."</option>";
						} else {
							echo "<option value=\"".$rowc["id"]."\">".$rowc["servicio"]."</option>";
						}
#						echo busca_servicios($rowc["id"],$rowc["servicio"],$servicio);
					}
				echo "</select>";
			echo "</td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Tipo." :</td><td><select name=\"id_tipo\" class=\"px300\">";
				echo "<option value=\"0\" selected>-</option>";
				$sqlt = "select * from sgm_tareas_tipos_grupo where visible=1";
				$resultt = mysql_query(convertSQL($sqlt));
				while ($rowt = mysql_fetch_array($resultt)) {
					$sqltg = "select count(*) as total from sgm_tareas_tipos where visible=1 and id_tipo_grupo=".$rowt["id"];
					$resulttg = mysql_query(convertSQL($sqltg));
					$rowtg = mysql_fetch_array($resulttg);
					if ($rowtg["total"] > 0){
						$sqltt = "select * from sgm_tareas_tipos where visible=1 and id_tipo_grupo=".$rowt["id"];
						$resulttt = mysql_query(convertSQL($sqltt));
						$rowtt = mysql_fetch_array($resulttt);
						if ($rowtt["id"] == $row["id_tipo"]) {
							echo "<option value=\"".$rowtt["id"]."\" selected>".$rowt["grupo"]."-".$rowtt["tipo"]."</option>";
						} else {
							echo "<option value=\"".$rowtt["id"]."\">".$rowt["grupo"]."-".$rowtt["tipo"]."</option>";
						}
					}
				}
			echo "</select></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Departamento." :</td><td><select name=\"id_departamento\" class=\"px300\">";
			echo "<option value=\"0\" selected>-</option>";
				$sqld = "select * from sgm_tareas_departamento where visible=1 order by nombre";
				$resultd = mysql_query(convertSQL($sqld));
				while ($rowd = mysql_fetch_array($resultd)) {
					if ($rowd["id"] == $row["id_departamento"] ) {
						echo "<option value=\"".$rowd["id"]."\" selected>".$rowd["nombre"]."</option>";
					} else {
						echo "<option value=\"".$rowd["id"]."\">".$rowd["nombre"]."</option>";
					}
				}
			echo "</select>";
			echo "</td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td></td><td>";
					$sqlc = "select * from sgm_tareas_canvio_usuario where id_tarea=".$_GET["id"]." order by fecha";
					$resultc = mysql_query(convertSQL($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						$sqlu = "select * from sgm_users where id=".$rowc["id_usuario_origen"];
						$resultu = mysql_query(convertSQL($sqlu));
						$rowu = mysql_fetch_array($resultu);
						echo $rowu["usuario"]." <strong>".$rowc["fecha"]."</strong> <em>".$rowc["motivo"]."</em><br>";
					}
			echo "</td></tr>";
		}
		if ($editando == true) { $agenda = $row["id_agenda"]; }
		if ($editando == false) {
			if ($_POST["id_agenda"] != 0) {
				$agenda = $_POST["id_agenda"];
			} else {
				$agenda = $_GET["id_agenda"];
			}
		}
		echo "<tr style=\"background-color : Silver;\"><td style=\"text-align:right;vertical-align:top;\">".$Agenda." :</td><td><select name=\"id_agenda\" class=\"px300\">";
		echo "<option value=\"0\" selected>-</option>";
			$sqlu = "select * from sgm_agendas where visible=1";
			$resultu = mysql_query(convertSQL($sqlu));
			while ($rowu = mysql_fetch_array($resultu)) {
				if ($rowu["id"] == $agenda ) {
					echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["nombre"]."</option>";
				} else {
					echo "<option value=\"".$rowu["id"]."\">".$rowu["nombre"]."</option>";
				}
			}
		echo "</select></td></tr>";
		#### INVITADOS
		echo "<tr style=\"background-color : Silver;\">";
			echo "<td style=\"text-align:right;vertical-align:top;\">".$Agendas." ".$Invitadas.":</td>";
				echo "<td><select name=\"id_agenda2\" class=\"px300\">";
					echo "<option value=\"0\" selected>-</option>";
						$sqlu = "select * from sgm_agendas where visible=1";
						$resultu = mysql_query(convertSQL($sqlu));
						while ($rowu = mysql_fetch_array($resultu)) {
							if ($rowu["id"] == $row["id_2"]){
								echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowu["id"]."\">".$rowu["nombre"]."</option>";
							}
						}
				echo "</select></td>";
		echo "</tr>";
			for ($i=3;$i<=10;$i++){
				echo "<tr style=\"background-color : Silver;\">";
					echo "<td></td><td><select name=\"id_agenda".$i."\" class=\"px300\">";
						echo "<option value=\"0\" selected>-</option>";
							$sqlu = "select * from sgm_agendas where visible=1";
							$resultu = mysql_query(convertSQL($sqlu));
							while ($rowu = mysql_fetch_array($resultu)) {
							if ($rowu["id"] == $row["id_".$i.""]){
								echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowu["id"]."\">".$rowu["nombre"]."</option>";
							}
							}
					echo "</select></td>";
				echo "</tr>";
			}

		if ($editando == true) {
		echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Motivo." <br>".$Cambio." :</td><td><textarea name=\"motivo\" class=\"px300\" rows=\"2\"></textarea></td></tr>";
		}

		echo "<tr><td>&nbsp;</td></tr>";

		echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Estado." ".$Tarea." :";

		echo "</td><td><select name=\"id_estado\" class=\"px200\">";
			if ($row["id_estado"] == -1) { echo "<option value=\"-1\" selected>".$Registrada."</option>"; } else { echo "<option value=\"-1\">".$Registrada."</option>"; }
			if ($row["id_estado"] == -2) { 
				echo "<option value=\"-2\" selected>".$Finalizada."</option>";
			} else { 
				if (cerrable($row["id"])) { echo "<option value=\"-2\">".$Finalizada."</option>"; }
			}
			$sqls = "select * from sgm_tareas_estados where visible=1 order by estado";
			$results = mysql_query(convertSQL($sqls));
			while ($rows = mysql_fetch_array($results)) {
				if ($rows["id"] == $row["id_estado"] ) {
					echo "<option value=\"".$rows["id"]."\" selected>".$rows["estado"]."</option>";
				} else {
					echo "<option value=\"".$rows["id"]."\">".$rows["estado"]."</option>";
				}
			}
		echo "</select></td></tr>";

		if (cerrable($row["id"]) == false) { echo "<tr><td></td><td><strong style=\"color:red;\">No ".$finalizable."</strong></td></tr>"; }
		

		echo "<tr><td>&nbsp;</td></tr>";

		if ($_GET["inc"] != 2){
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Prevision." :</td>";
				echo "<td><table><tr><td><input type=\"Text\" name=\"data_registro\" value=\"".$fecha_prevision."\" style=\"width:150px;text-align:left;\"></td>";
				echo "<td style=\"width:60px;text-align:right;\">".$Duracion." : </td>";
				echo "<td><select name=\"tiempo\">";
					if ($editando == true) { $tiempo = $row["tiempo"]; }
					if ($editando == false) { $tiempo = $_POST["tiempo"]; }

					if ($tiempo == 0) { echo "<option value=\"0\" selected>0'</option>"; } else { echo "<option value=\"0\">0'</option>"; }
					if ($tiempo == 1) { echo "<option value=\"1\" selected>1'</option>"; } else { echo "<option value=\"1\">1'</option>"; }
					if ($tiempo == 2) { echo "<option value=\"2\" selected>2'</option>"; } else { echo "<option value=\"2\">2'</option>"; }
					if ($tiempo == 3) { echo "<option value=\"3\" selected>3'</option>"; } else { echo "<option value=\"3\">3'</option>"; }
					if ($tiempo == 4) { echo "<option value=\"4\" selected>4'</option>"; } else { echo "<option value=\"4\">4'</option>"; }
					if ($tiempo == 5) { echo "<option value=\"5\" selected>5'</option>"; } else { echo "<option value=\"5\">5'</option>"; }
					if ($tiempo == 10) { echo "<option value=\"10\" selected>10'</option>"; } else { echo "<option value=\"10\">10'</option>"; }
					if ($tiempo == 15) { echo "<option value=\"15\" selected>15'</option>"; } else { echo "<option value=\"15\">15'</option>"; }
					if ($tiempo == 20) { echo "<option value=\"20\" selected>20'</option>"; } else { echo "<option value=\"20\">20'</option>"; }
					if ($tiempo == 25) { echo "<option value=\"25\" selected>25'</option>"; } else { echo "<option value=\"25\">25'</option>"; }
					if ($tiempo == 30) { echo "<option value=\"30\" selected>30'</option>"; } else { echo "<option value=\"30\">30'</option>"; }
					if ($tiempo == 35) { echo "<option value=\"35\" selected>35'</option>"; } else { echo "<option value=\"35\">35'</option>"; }
					if ($tiempo == 40) { echo "<option value=\"40\" selected>40'</option>"; } else { echo "<option value=\"40\">40'</option>"; }
					if ($tiempo == 45) { echo "<option value=\"45\" selected>45'</option>"; } else { echo "<option value=\"45\">45'</option>"; }
					if ($tiempo == 50) { echo "<option value=\"50\" selected>50'</option>"; } else { echo "<option value=\"50\">50'</option>"; }
					if ($tiempo == 55) { echo "<option value=\"55\" selected>55'</option>"; } else { echo "<option value=\"55\">55'</option>"; }
					if ($tiempo == 60) { echo "<option value=\"60\" selected>60'</option>"; } else { echo "<option value=\"60\">60'</option>"; }
					if ($tiempo == 90) { echo "<option value=\"90\" selected>90'</option>"; } else { echo "<option value=\"90\">90'</option>"; }
					if ($tiempo == 120) { echo "<option value=\"120\" selected>120'</option>"; } else { echo "<option value=\"120\">120'</option>"; }
					if ($tiempo == 150) { echo "<option value=\"150\" selected>150'</option>"; } else { echo "<option value=\"150\">150'</option>"; }
					if ($tiempo == 180) { echo "<option value=\"180\" selected>180'</option>"; } else { echo "<option value=\"180\">180'</option>"; }
					if ($tiempo == 210) { echo "<option value=\"210\" selected>210'</option>"; } else { echo "<option value=\"210\">210'</option>"; }
					if ($tiempo == 240) { echo "<option value=\"240\" selected>240'</option>"; } else { echo "<option value=\"240\">240'</option>"; }
					if ($tiempo == 270) { echo "<option value=\"270\" selected>270'</option>"; } else { echo "<option value=\"270\">270'</option>"; }
					if ($tiempo == 300) { echo "<option value=\"300\" selected>300'</option>"; } else { echo "<option value=\"300\">300'</option>"; }
					if ($tiempo == 330) { echo "<option value=\"330\" selected>330'</option>"; } else { echo "<option value=\"330\">330'</option>"; }
					if ($tiempo == 360) { echo "<option value=\"360\" selected>360'</option>"; } else { echo "<option value=\"360\">360'</option>"; }
					if ($tiempo == 390) { echo "<option value=\"390\" selected>390'</option>"; } else { echo "<option value=\"390\">390'</option>"; }
					if ($tiempo == 420) { echo "<option value=\"420\" selected>420'</option>"; } else { echo "<option value=\"420\">420'</option>"; }
					if ($tiempo == 450) { echo "<option value=\"450\" selected>450'</option>"; } else { echo "<option value=\"450\">450'</option>"; }
					if ($tiempo == 480) { echo "<option value=\"480\" selected>480'</option>"; } else { echo "<option value=\"480\">480'</option>"; }
					if ($tiempo == 510) { echo "<option value=\"510\" selected>510'</option>"; } else { echo "<option value=\"510\">510'</option>"; }
					if ($tiempo == 540) { echo "<option value=\"540\" selected>540'</option>"; } else { echo "<option value=\"540\">540'</option>"; }
					if ($tiempo == 600) { echo "<option value=\"600\" selected>600'</option>"; } else { echo "<option value=\"600\">600'</option>"; }
				echo "</select></td>";
				echo "</tr></table>";
			echo "</td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Fecha." ".$Limite." ".$Prevision." :</td>";
				echo "<td><table><tr><td><input type=\"Text\" name=\"data_margen\" value=\"".$fecha_margen."\" style=\"width:150px;text-align:left;\"></td>";
				echo "<td style=\"width:60px;text-align:right;\">".$Aviso." : </td>";
				echo "<td><select name=\"aviso\">";
					if ($editando == true) { $tiempo = $row["tiempo"]; }
					if ($editando == false) { $tiempo = $_POST["tiempo"]; }

					if ($tiempo == 0) { echo "<option value=\"0\" selected>0'</option>"; } else { echo "<option value=\"0\">0'</option>"; }
					if ($tiempo == 1) { echo "<option value=\"1\" selected>1'</option>"; } else { echo "<option value=\"1\">1'</option>"; }
					if ($tiempo == 2) { echo "<option value=\"2\" selected>2'</option>"; } else { echo "<option value=\"2\">2'</option>"; }
					if ($tiempo == 3) { echo "<option value=\"3\" selected>3'</option>"; } else { echo "<option value=\"3\">3'</option>"; }
					if ($tiempo == 4) { echo "<option value=\"4\" selected>4'</option>"; } else { echo "<option value=\"4\">4'</option>"; }
					if ($tiempo == 5) { echo "<option value=\"5\" selected>5'</option>"; } else { echo "<option value=\"5\">5'</option>"; }
					if ($tiempo == 10) { echo "<option value=\"10\" selected>10'</option>"; } else { echo "<option value=\"10\">10'</option>"; }
					if ($tiempo == 15) { echo "<option value=\"15\" selected>15'</option>"; } else { echo "<option value=\"15\">15'</option>"; }
					if ($tiempo == 20) { echo "<option value=\"20\" selected>20'</option>"; } else { echo "<option value=\"20\">20'</option>"; }
					if ($tiempo == 25) { echo "<option value=\"25\" selected>25'</option>"; } else { echo "<option value=\"25\">25'</option>"; }
					if ($tiempo == 30) { echo "<option value=\"30\" selected>30'</option>"; } else { echo "<option value=\"30\">30'</option>"; }
					if ($tiempo == 35) { echo "<option value=\"35\" selected>35'</option>"; } else { echo "<option value=\"35\">35'</option>"; }
					if ($tiempo == 40) { echo "<option value=\"40\" selected>40'</option>"; } else { echo "<option value=\"40\">40'</option>"; }
					if ($tiempo == 45) { echo "<option value=\"45\" selected>45'</option>"; } else { echo "<option value=\"45\">45'</option>"; }
					if ($tiempo == 50) { echo "<option value=\"50\" selected>50'</option>"; } else { echo "<option value=\"50\">50'</option>"; }
					if ($tiempo == 55) { echo "<option value=\"55\" selected>55'</option>"; } else { echo "<option value=\"55\">55'</option>"; }
					if ($tiempo == 60) { echo "<option value=\"60\" selected>60'</option>"; } else { echo "<option value=\"60\">60'</option>"; }
					if ($tiempo == 90) { echo "<option value=\"90\" selected>90'</option>"; } else { echo "<option value=\"90\">90'</option>"; }
					if ($tiempo == 120) { echo "<option value=\"120\" selected>120'</option>"; } else { echo "<option value=\"120\">120'</option>"; }
					if ($tiempo == 150) { echo "<option value=\"150\" selected>150'</option>"; } else { echo "<option value=\"150\">150'</option>"; }
					if ($tiempo == 180) { echo "<option value=\"180\" selected>180'</option>"; } else { echo "<option value=\"180\">180'</option>"; }
					if ($tiempo == 210) { echo "<option value=\"210\" selected>210'</option>"; } else { echo "<option value=\"210\">210'</option>"; }
					if ($tiempo == 240) { echo "<option value=\"240\" selected>240'</option>"; } else { echo "<option value=\"240\">240'</option>"; }
					if ($tiempo == 270) { echo "<option value=\"270\" selected>270'</option>"; } else { echo "<option value=\"270\">270'</option>"; }
					if ($tiempo == 300) { echo "<option value=\"300\" selected>300'</option>"; } else { echo "<option value=\"300\">300'</option>"; }
					if ($tiempo == 330) { echo "<option value=\"330\" selected>330'</option>"; } else { echo "<option value=\"330\">330'</option>"; }
					if ($tiempo == 360) { echo "<option value=\"360\" selected>360'</option>"; } else { echo "<option value=\"360\">360'</option>"; }
					if ($tiempo == 390) { echo "<option value=\"390\" selected>390'</option>"; } else { echo "<option value=\"390\">390'</option>"; }
					if ($tiempo == 420) { echo "<option value=\"420\" selected>420'</option>"; } else { echo "<option value=\"420\">420'</option>"; }
					if ($tiempo == 450) { echo "<option value=\"450\" selected>450'</option>"; } else { echo "<option value=\"450\">450'</option>"; }
					if ($tiempo == 480) { echo "<option value=\"480\" selected>480'</option>"; } else { echo "<option value=\"480\">480'</option>"; }
					if ($tiempo == 510) { echo "<option value=\"510\" selected>510'</option>"; } else { echo "<option value=\"510\">510'</option>"; }
					if ($tiempo == 540) { echo "<option value=\"540\" selected>540'</option>"; } else { echo "<option value=\"540\">540'</option>"; }
					if ($tiempo == 600) { echo "<option value=\"600\" selected>600'</option>"; } else { echo "<option value=\"600\">600'</option>"; }
				echo "</select></td>";
				echo "</tr></table>";
			echo "</td></tr>";
		}
		echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Asunto." : </td><td><input type=\"Text\" name=\"asunto\" value=\"".$row["asunto"]."\" class=\"px300\"></td></tr>";
		echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Notas." ".$Registro." :</td><td><textarea name=\"notas_registro\" class=\"px400\" rows=\"5\">".$row["notas_registro"]."</textarea></td></tr>";

		if ($usuario_con_permiso == true) {
			echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:200px\"></td></tr>";
		}

		$sqlc = "select * from sgm_tareas_notas_desarrollo where id_tarea=".$_GET["id"]." order by fecha";
		$resultc = mysql_query(convertSQL($sqlc));
		while ($rowc = mysql_fetch_array($resultc)) {
			$sqlu = "select * from sgm_users where id=".$rowc["id_usuario_origen"];
			$resultu = mysql_query(convertSQL($sqlu));
			$rowu = mysql_fetch_array($resultu);
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">";
			echo $rowu["usuario"]."<br><strong>".$rowc["fecha"]."</strong>";
			echo "</td><td>";
			if (strlen($rowc["notas"]) > 200) {
				echo "<textarea class=\"px400\" rows=\"8\">".$rowc["notas"]."</textarea>";
			} else {
				echo  "<table class=\"px400\"><tr><td style=\"border: 1px solid black\">".str_replace(chr(13),"<br>", $rowc["notas"])."</td></tr></table>";
			}
		}

		echo "</td></tr>";
		if (($_GET["inc"] != 2) and ($_GET["inc"] != 1)){
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Notas." ".$Desarrollo." :</td><td><textarea name=\"notas_desarrollo\" class=\"px400\" rows=\"5\"></textarea></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Notas." ".$Conclusion." :</td><td><textarea name=\"notas_conclusion\" class=\"px400\" rows=\"5\">".$row["notas_conclusion"]."</textarea></td></tr>";
			if ($usuario_con_permiso == true) {
				echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:200px\"></td></tr>";
			}
		}
		echo "<input type=\"Hidden\" name=\"programada\" value=\"0\">";
		echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Privada."</td><td><select name=\"privada\" class=\"px50\">";
				if (($editando == false) or ($row["privada"] == 1)) {
					echo "<option value=\"1\" selected>NO</option>";
					echo "<option value=\"0\">SI</option>";
				}
				if (($editando == true) and ($row["privada"] == 0)) {
					echo "<option value=\"1\">NO</option>";
					echo "<option value=\"0\" selected>SI</option>";
				}
			echo "</select>";
		echo "</td></tr>";
		echo "</table>";
		if ($_GET["inc"] == 2){
			echo "<input type=\"hidden\" value=\"".$fecha_reg."\" name=\"data_insert\">";
			echo "<input type=\"hidden\" value=\"0\" name=\"id_entrada\">";
			echo "<input type=\"hidden\" value=\"0\" name=\"id_cliente\">";
			echo "<input type=\"hidden\" value=\"\" name=\"cliente_nombre\">";
			echo "<input type=\"hidden\" value=\"\" name=\"cliente_contacto\">";
			echo "<input type=\"hidden\" value=\"0\" name=\"id_servicio\">";
			echo "<input type=\"hidden\" value=\"0\" name=\"id_tipo\">";
			echo "<input type=\"hidden\" value=\"0\" name=\"id_departamento\">";
			echo "<input type=\"hidden\" value=\"0000-00-00 00:00:00\" name=\"data_registro\">";
			echo "<input type=\"hidden\" value=\"0000-00-00 00:00:00\" name=\"data_margen\">";
			echo "<input type=\"hidden\" value=\"0\" name=\"tiempo\">";
			echo "<input type=\"Hidden\" name=\"programada\" value=\"0\">";
		}
		echo "</form>";
		echo "</td>";
		if (($_GET["inc"] != 2) and ($_GET["inc"] != 1)){
			echo "<td style=\"vertical-align: top\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\">";
					echo "<tr>";
						echo "<td style=\"text-align:right;\"><strong>".$Plantillas." ".$Asociadas." :</strong></td>";
						echo "<td style=\"width:135px;\"></td>";
					echo "</tr>";
					echo "<tr style=\"background-color : Silver;\">";
						echo "<td style=\"width:150px;text-align:center;\">".$Plantilla."</td>";
						echo "<td style=\"width:100px;text-align:center;color:black;\"></td>";
					echo "</tr>";
					$sql2 = "select * from sgm_tareas_tipos_plantillas where id_tarea_tipo=".$row["id_tipo"];
					$result2 = mysql_query(convertSQL($sql2));
					while ($row2 = mysql_fetch_array($result2)) {	
						$sqlv = "select * from sgm_ft_plantilla where id=".$row2["id_plantilla"];
						$resultv = mysql_query(convertSQL($sqlv));
						$rowv = mysql_fetch_array($resultv);
						echo "<tr>";
							echo "<td style=\"text-align:right;\">".$rowv["plantilla"]."</td>";
						$sqlt = "select count(*) as total from sgm_ft where  id_plantilla=".$rowv["id"]." and id_tarea=".$_GET["id"];
						$resultt = mysql_query(convertSQL($sqlt));
						$rowt = mysql_fetch_array($resultt);
						if ($rowt["total"] == 0) {
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=210&id_tarea=".$_GET["id"]."&id_plantilla=".$rowv["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white.png\" alt=\"Editar\" border=\"0\"> ".$Anadir." ".$Datos."</a></td>";
						} else {
							$sqlft = "select * from sgm_ft where  id_plantilla=".$rowv["id"]." and id_tarea=".$_GET["id"];
							$resultft = mysql_query(convertSQL($sqlft));
							$rowft = mysql_fetch_array($resultft);
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=210&id_ft=".$rowft["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white.png\" alt=\"Editar\" border=\"0\"> ".$Editar." ".$Datos."</a></td>";
						}
						echo "</tr>";
					}
				echo "</table>";
				echo "<br><br>";
				echo "<table cellpadding=\"1\" cellspacing=\"0\">";
					echo "<tr>";
						echo "<td style=\"text-align:right;\"><strong>".$Historial." ".$Tareas." :</strong></td>";
						echo "<td style=\"width:180px;\">";
						if ($row["id_origen"] != 0) { echo "<a href=\"index.php?op=1017&sop=20&id=".$row["id_origen"]."\">&raquo; ".$Ver." ".$Tarea." ".$Anterior." nº ".$row["id_origen"]."</a>"; }
						echo "</td>";
					echo "</tr>";
					echo "<tr style=\"background-color : Silver;\">";
						echo "<td style=\"text-align:right;\"></td>";
						echo "<td style=\"width:180px;color:black;\">".$Tarea." ".$Actual." nº ".$row["id"]."</td>";
					echo "</tr>";
					busca_tareas($row["id"],0);
				echo "</table>";
			echo "</td>";
		}
		echo "</tr>";
		echo "</table></center>";
	}

		if ($soption == 21) {
			$sql = "insert into sgm_tareas (id_usuario,id_2,id_3,id_4,id_5,id_6,id_7,id_8,id_9,id_10,data_registro,id_cliente,id_servicio,data_insert,id_entrada,id_departamento,id_agenda,data_registro,data_margen,tiempo,id_estado,id_tipo,notas_registro,notas_conclusion,programada,cliente_nombre,cliente_contacto,asunto,privada)";
			$sql = $sql."values (";
			$sql = $sql."".$userid."";
			$sql = $sql.",".$_POST["id_agenda2"]."";
			$sql = $sql.",".$_POST["id_agenda3"]."";
			$sql = $sql.",".$_POST["id_agenda4"]."";
			$sql = $sql.",".$_POST["id_agenda5"]."";
			$sql = $sql.",".$_POST["id_agenda6"]."";
			$sql = $sql.",".$_POST["id_agenda7"]."";
			$sql = $sql.",".$_POST["id_agenda8"]."";
			$sql = $sql.",".$_POST["id_agenda9"]."";
			$sql = $sql.",".$_POST["id_agenda10"]."";
			$a = date("Y");
			$m = date("n");
			$d = date("j");
			$xfecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i");
			$sql = $sql.",'".$xfecha."'";
			$sql = $sql.",".$_POST["id_cliente"]."";
			$sql = $sql.",".$_POST["id_servicio"]."";
			$sql = $sql.",'".$_POST["data_insert"]."'";
			$sql = $sql.",".$_POST["id_entrada"]."";
			$sql = $sql.",".$_POST["id_departamento"]."";
			$sql = $sql.",".$_POST["id_agenda"]."";
			$sql = $sql.",'".$_POST["data_registro"]."'";
			$sql = $sql.",'".$_POST["data_margen"]."'";
			$sql = $sql.",".$_POST["tiempo"]."";
			$sql = $sql.",".$_POST["id_estado"]."";
			$sql = $sql.",".$_POST["id_tipo"]."";
			$sql = $sql.",'".comillas($_POST["notas_registro"])."'";
			$sql = $sql.",'".comillas($_POST["notas_conclusion"])."'";
			$sql = $sql.",".$_POST["programada"];
			$sql = $sql.",'".$_POST["cliente_nombre"]."'";
			$sql = $sql.",'".$_POST["cliente_contacto"]."'";
			$sql = $sql.",'".comillas($_POST["asunto"])."'";
			$sql = $sql.",".$_POST["privada"]."";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
			if ($_POST["notas_desarrollo"] != ""){
				$sqli = "select * from sgm_tareas where asunto='".$_POST["asunto"]."' order by id DESC";
				$resulti = mysql_query(convertSQL($sqli));
				$rowi = mysql_fetch_array($resulti);
				$sql = "insert into sgm_tareas_notas_desarrollo (id_tarea, id_usuario_origen, fecha, notas) ";
				$sql = $sql."values (";
				$sql = $sql.$rowi["id"];
				$sql = $sql.",".$userid;
				$a = date("Y");
				$m = date("n");
				$d = date("j");
				$xfecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i:s");
				$sql = $sql.",'".$xfecha."'";
				$sql = $sql.",'".comillas($_POST["notas_desarrollo"])."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
			}
			echo "<br><br>Operación realizada correctamente.";
			echo "<br><br><a href=\"index.php?op=1017&sop=0\">[ Volver ]</a>";	
		}

	if ($soption == 22){
		echo "<br><br>¿Desea eliminar la relación entre esta incidencia/tarea seleccionada?";
		echo "<br><br><a href=\"index.php?op=1017&sop=20&ssop=6&id=".$_GET["id"]."&id_tarea=".$_GET["id_tarea"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=20&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if ($soption == 24) {
		echo "<center><br><br>¿Desea eliminar la incidencia/tarea seleccionada?";
		echo "<br><br><a href=\"index.php?op=1017&sop=0&ssop=2&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=20\">[ NO ]</a></center>";
	}

	if ($soption == 30){
		echo "<br><table>";
			echo "<tr><td style=\"width:500px\">";
				echo agenda_mes($dia,$any,$mes,$usuario,$soption);
			echo "</td><td>";
			echo "<center><table>";
			if ($ssoption == 0){
				echo "<tr><strong>".$Imprimir." ".$Jornada."</strong></tr>";
				echo "<tr><td style=\"width:120px;text-align:left;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 15px;padding-left : 5px;\"><a href=\"".$urloriginal."/mgestion/gestion-agenda-jornada-print.php?usuario=".$_GET["usuario"]."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" target=\"_blank\" style=\"color:white;\">".$Grafico."<br><img src=\"mgestion/pics/jor_graf.gif\" border=\"0\"></a></td>";
				echo "<td style=\"width:120px;text-align:left;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 15px;padding-left : 5px;\"><a href=\"".$urloriginal."/mgestion/gestion-agenda-jornada-lista-print.php?usuario=".$_GET["usuario"]."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" target=\"_blank\" style=\"color:white;\">".$Lista."<br><img src=\"mgestion/pics/mes_list.gif\" border=\"0\"></a></td></tr>";
			}
			if ($ssoption == 1){
				echo "<tr><strong>".$Imprimir." ".$Semana."</strong></tr>";
				echo "<tr><td style=\"width:120px;text-align:left;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 15px;padding-left : 5px;\"><a href=\"".$urloriginal."/mgestion/gestion-agenda-setmana-print.php?usuario=".$_GET["usuario"]."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" target=\"_blank\" style=\"color:white;\">".$Grafico."<br><img src=\"mgestion/pics/sem_graf.gif\" border=\"0\"></a></td>";
				echo "<td style=\"width:120px;text-align:left;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 15px;padding-left : 5px;\"><a href=\"".$urloriginal."/mgestion/gestion-agenda-setmana-lista-print.php?usuario=".$_GET["usuario"]."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" target=\"_blank\" style=\"color:white;\">".$Lista."<br><img src=\"mgestion/pics/mes_list.gif\" border=\"0\"></a></td></tr>";
			}
			if ($ssoption == 2){
				echo "<tr><strong>".$Imprimir." ".$Mes."</strong></tr>";
				echo "<tr><td style=\"width:120px;text-align:left;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 15px;padding-left : 5px;\"><a href=\"".$urloriginal."/mgestion/gestion-agenda-mes-print.php?usuario=".$_GET["usuario"]."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" target=\"_blank\" style=\"color:white;\">".$Grafico."<br><img src=\"mgestion/pics/mes_graf.gif\" border=\"0\"></a></td>";
				echo "<td style=\"width:120px;text-align:left;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 15px;padding-left : 5px;\"><a href=\"".$urloriginal."/mgestion/gestion-agenda-mes-lista-print.php?usuario=".$_GET["usuario"]."&dd=".$_GET["dd"]."&mm=".$_GET["mm"]."&aa=".$_GET["aa"]."\" target=\"_blank\" style=\"color:white;\">".$Lista."<br><img src=\"mgestion/pics/mes_list.gif\" border=\"0\"></a></td></tr>";
			}
			echo "</tr>";
			echo "</table></center>";
			echo "</td></tr>";
		echo "</table><br>";
	}

	if (($soption == 40) and ($admin == true)) {
		echo "<strong>Administrar</strong>";
		echo "<br><br>";
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=120\" style=\"color:white;\">".$Agendas."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=100\" style=\"color:white;\">".$Acceso." ".$Agendas."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=50\" style=\"color:white;\">".$Departamento."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=60\" style=\"color:white;\">".$Estados."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=70\" style=\"color:white;\">".$Tipos."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=80\" style=\"color:white;\">".$Servicios."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1017&sop=90\" style=\"color:white;\">".$Servicios." ".$Estados."</a>";
				echo "</td>";
		echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}

	if (($soption == 50) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_departamento (nombre) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_tareas_departamento set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_tareas_departamento set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Departamentos."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"><em>".$Eliminar."</em></td>";
			echo "<td style=\"text-align:center;\">".$Departamento."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
			echo "<form action=\"index.php?op=1017&sop=50&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "<td></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_tareas_departamento where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
#				echo "<td><a href=\"index.php?op=1017&sop=103&id=".$row["id"]."\">[E]</a></td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=51&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1017&sop=50&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if (($soption == 51) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar el departamento seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=50&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=50\">[ NO ]</a></center>";
	}

	if (($soption == 60) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_estados (estado,color) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["estado"]."'";
			$sql = $sql.",'".$_POST["color"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_tareas_estados set ";
			$sql = $sql."estado='".$_POST["estado"]."'";
			$sql = $sql.",color='".$_POST["color"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_tareas_estados set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Estados." de ".$Tareas."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table><tr><td style=\"vertical-align:top;\">";

		echo "<table cellpadding=\"2\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"><em>".$Eliminar."</em></td>";
			echo "<td style=\"text-align:center;\">".$Tipo." de ".$Estado."</td>";
			echo "<td style=\"text-align:center;\">".$Color."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1017&sop=60&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"estado\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Text\" name=\"color\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:75px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
				$sql = "select * from sgm_tareas_estados where visible=1";
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr style=\"background-color:".$row["color"].";\">";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=61&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						echo "<form action=\"index.php?op=1017&sop=60&ssop=2&id=".$row["id"]."\" method=\"post\">";
						echo "<td><input type=\"Text\" name=\"estado\" style=\"width:150px\" value=\"".$row["estado"]."\"></td>";
						echo "<td><input type=\"Text\" name=\"color\" style=\"width:100px\" value=\"".$row["color"]."\"></td>";
						echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:75px\"></td>";
						echo "</form>";
					echo "</tr>";
				}
		echo "</table>";
			echo "<br><br>* para introducir el color deseado debe escribir el nombre o el codigo de<br> la paleta de colores de la derecha.";
			echo "<br><br>* existe el estado <strong>REGISTRADA</strong>, que es la incidencia que aun no se ha iniciado en ninguno de sus estados.";
			echo "<br><br>* existe el estado <strong>FINALIZADA</strong>, que hace referéncia a la finalización de la incidencia.";
			echo "</td><td bgcolor=\"#CCCCCC\" style=\"vertical-align:top;\">";
			colors();
		echo "</td></tr></table></center>";
	}

	if (($soption == 61) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar el estado seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=60&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=60\">[ NO ]</a></center><br>";
	}

	if (($soption == 70) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_tipos (tipo,id_tipo_grupo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["tipo"]."'";
			$sql = $sql.",".$_POST["id_tipo_grupo"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_tareas_tipos set ";
			$sql = $sql."tipo='".$_POST["tipo"]."'";
			$sql = $sql.",id_tipo_grupo=".$_POST["id_tipo_grupo"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_tareas_tipos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 4) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_tipos_grupo (grupo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["grupo"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 5) and ($admin == true)) {
			$sql = "update sgm_tareas_tipos_grupo set ";
			$sql = $sql."grupo='".$_POST["grupo"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 6) and ($admin == true)) {
			$sql = "update sgm_tareas_tipos_grupo set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Tipos." de ".$Tarea."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"><em>".$Eliminar."</em></td>";
			echo "<td style=\"width:200px;text-align:center;\">".$Grupo." de ".$Tipo." de ".$Tarea."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<form action=\"index.php?op=1017&sop=70&ssop=4\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"Text\" name=\"grupo\" style=\"width:200px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "<td></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_tareas_tipos_grupo where visible=1 order by grupo";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=72&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1017&sop=70&ssop=5&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"grupo\" style=\"width:200px\" value=\"".$row["grupo"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";

		echo "<br><br>";

		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"><em>".$Eliminar."</em></td>";
			echo "<td style=\"text-align:center;\">".$Grupo."</td>";
			echo "<td style=\"width:200px;text-align:center;\">".$Tipo." de ".$Tarea."</td>";
			echo "<td></td>";
			echo "<td style=\"\"><em>".$Plantillas."</em></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<form action=\"index.php?op=1017&sop=70&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td><select name=\"id_tipo_grupo\" style=\"width:150px;\">";
				echo "<option value=\"0\">-</option>";
				$sqlg = "select * from sgm_tareas_tipos_grupo where visible=1 order by grupo";
				$resultg = mysql_query(convertSQL($sqlg));
				while ($rowg = mysql_fetch_array($resultg)) {
					echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
				}
			echo "</select></td>";
			echo "<td><input type=\"Text\" name=\"tipo\" style=\"width:200px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "<td></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_tareas_tipos where visible=1 order by tipo";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=71&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1017&sop=70&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_tipo_grupo\" style=\"width:150px;\">";
					echo "<option value=\"0\">-</option>";
					$sqlg = "select * from sgm_tareas_tipos_grupo where visible=1 order by grupo";
					$resultg = mysql_query(convertSQL($sqlg));
					while ($rowg = mysql_fetch_array($resultg)) {
						if ($rowg["id"] == $row["id_tipo_grupo"]) { echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["grupo"]."</option>";  }
						else { echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>"; }
					}
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"tipo\" style=\"width:200px\" value=\"".$row["tipo"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
					$sqlxx = "select count(*) as total from sgm_tareas_tipos_plantillas where id_tarea_tipo=".$row["id"];
					$resultxx = mysql_query(convertSQL($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=110&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white.png\" alt=\"Plantillas\" border=\"0\"> ".$rowxx["total"]."</a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 71) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar el tipo seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=70&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=70\">[ NO ]</a></center><br>";
	}

	if (($soption == 72) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar grupo de tipos de incidencias seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=70&ssop=6&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=70\">[ NO ]</a></center><br>";
	}

	if (($soption == 80) and ($admin == true)) {

		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_servicios (servicio,codigo,id_origen) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["servicio"]."'";
			$sql = $sql.",'".$_POST["codigo"]."'";
			$sql = $sql.",".$_POST["id_origen"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_tareas_servicios set ";
			$sql = $sql."servicio='".$_POST["servicio"]."'";
			$sql = $sql.",codigo='".$_POST["codigo"]."'";
			$sql = $sql.",id_origen=".$_POST["id_origen"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_tareas_servicios set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 4) and ($admin == true)) {
			$sql = "update sgm_tareas_servicios set ";
			$sql = $sql."titol=1";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 5) and ($admin == true)) {
			$sql = "update sgm_tareas_servicios set ";
			$sql = $sql."titol=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Servicios."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td></td>";
			echo "<td style=\"\"</td>";
			echo "<td style=\"width:200px;text-align:center;\">".$Dependencia."</td>";
			echo "<td style=\"width:80px;text-align:center;\">".$Codigo."</td>";
			echo "<td style=\"width:250px;text-align:center;\">".$Servicio."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<form action=\"index.php?op=1017&sop=80&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><select name=\"id_origen\" style=\"width:200px\">";
				echo "<option value=\"0\">-</option>";
				$sqlser = "select * from sgm_tareas_servicios where visible=1 order by servicio";
				$resultser = mysql_query(convertSQL($sqlser));
				while ($rowser = mysql_fetch_array($resultser)) {
					echo "<option value=\"".$rowser["id"]."\">".$rowser["servicio"]."</option>";
				}
			echo "</select></td>";
			echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:80px\"></td>";
			echo "<td><input type=\"Text\" name=\"servicio\" style=\"width:250px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
			echo "<td></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"></td>";
			echo "<td style=\"\"><em>Eliminar</em></td>";
			echo "<td style=\"width:200px;text-align:center;\">".$Dependencia."</td>";
			echo "<td style=\"width:80px;text-align:center;\">".$Codigo."</td>";
			echo "<td style=\"width:250px;text-align:center;\">".$Servicio."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
			$sql = "select * from sgm_tareas_servicios where visible=1 order by codigo";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["titol"] == 1){ $color= "silver";} 
				echo "<tr style=\"background-color:".$color."\">";
				if ($row["titol"] == 0){
					echo "<form action=\"index.php?op=1017&sop=80&ssop=4&id=".$row["id"]."\" method=\"post\">";
				} else {
					echo "<form action=\"index.php?op=1017&sop=80&ssop=5&id=".$row["id"]."\" method=\"post\">";
				}
				echo "<td><input type=\"submit\" value=\"".$Titulo."\" style=\"width:40px;\"></td></form>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=81&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1017&sop=80&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_origen\" style=\"width:200px\">";
					echo "<option value=\"0\">-</option>";
					$sqlser = "select * from sgm_tareas_servicios where visible=1 order by servicio";
					$resultser = mysql_query(convertSQL($sqlser));
					while ($rowser = mysql_fetch_array($resultser)) {
						if ($rowser["id"] != $row["id"])  { 
							if ($rowser["id"] == $row["id_origen"])  { 
								echo "<option value=\"".$rowser["id"]."\" selected>".$rowser["servicio"]."</option>";
							}
							else {
								echo "<option value=\"".$rowser["id"]."\">".$rowser["servicio"]."</option>";
							}
						}
					}
				echo "</select></td>";
				echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:80px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"servicio\" style=\"width:250px\" value=\"".$row["servicio"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 81) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar el servicios seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=80&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=80\">[ NO ]</a></center><br>";
	}

	if (($soption == 90) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_servicios_estados (nombre) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_tareas_servicios_estados set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_tareas_servicios_estados set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Estado." de ".$Servicios."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"><em>Eliminar</em></td>";
			echo "<td style=\"text-align:center;\">".$Estado." de ".$Servicio."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
			echo "<form action=\"index.php?op=1017&sop=90&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "<td></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_tareas_servicios_estados where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=91&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1017&sop=90&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if (($soption == 91) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar el departamento seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=90&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=90\">[ NO ]</a></center><br>";
	}

	if (($soption == 100) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {
			$sql = "insert into sgm_agendas_users (id_agenda,id_user,escritura) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["id_agenda"];
			$sql = $sql.",".$_POST["id_user"];
			$sql = $sql.",".$_POST["escritura"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_agendas_users set ";
			$sql = $sql."escritura=".$_POST["escritura"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "delete from sgm_agendas_users WHERE id=".$_GET["id"];
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 4) and ($admin == true)) {
			$sql = "update sgm_agendas_users set ";
			$sql = $sql."propietario = 0";
			$sql = $sql." WHERE id_agenda=".$_GET["id"]." and id_user<>".$_GET["user"];
			mysql_query(convertSQL($sql));
			$sql = "update sgm_agendas_users set ";
			$sql = $sql."propietario = 1";
			$sql = $sql.",escritura = 1";
			$sql = $sql." WHERE id_agenda=".$_GET["id"]." and id_user=".$_GET["user"];
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$sql = "update sgm_agendas_users set ";
			$sql = $sql."propietario = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Acceso." a las ".$Agendas." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr>";
				echo "<td style=\"text-align:center;\">".$Agenda."</td>";
				echo "<td style=\"text-align:center;\"><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Usuario."</td>";
				echo "<td style=\"text-align:center;\">".$Permiso."</td>";
			echo "</tr>";
			$sqlv = "select * from sgm_agendas where visible=1";
			$resultv = mysql_query(convertSQL($sqlv));
			while ($rowv = mysql_fetch_array($resultv)){
				echo "<tr style=\"background-color : Silver;\">";
					echo "<form action=\"index.php?op=1017&sop=100&ssop=1\" method=\"post\">";
					echo "<input type=\"Hidden\" value=\"".$rowv["id"]."\" name=\"id_agenda\">";
					echo "<td style=\"width:125px\">".$rowv["nombre"]."</td>";
					echo "<td></td>";
					echo "<td><select name=\"id_user\" style=\"width:100px\">";
						$sqlx = "select * from sgm_users where sgm=1 and activo=1 and validado=1 and id<>0";
						$resultx = mysql_query(convertSQL($sqlx));
						while ($rowx = mysql_fetch_array($resultx)) {	
							echo "<option value=\"".$rowx["id"]."\">".$rowx["usuario"]."</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"escritura\" style=\"width:150px\">";
						echo "<option value=\"0\">".$Lectura."</option>";
						echo "<option value=\"1\" selected>".$Lectura."/".$Escritura."</option>";
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
					echo "</form>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				$sql2 = "select * from sgm_agendas_users where visible=1 and id_agenda=".$rowv["id"];
				$result2 = mysql_query(convertSQL($sql2));
				while ($row2 = mysql_fetch_array($result2)) {
					if ($row2["propietario"] == 1){ $color = "#FF8C00";} else {$color = "white";}
					$sqlu = "select * from sgm_users where id=".$row2["id_user"];
					$resultu = mysql_query(convertSQL($sqlu));
					$rowu = mysql_fetch_array($resultu);
				echo "<tr style=\"background-color:".$color."\">";
						echo "<form action=\"index.php?op=1017&sop=100&ssop=2&id=".$row2["id"]."\" method=\"post\">";
						echo "<td></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=101&id=".$row2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
						echo "<td>".$rowu["usuario"]."</td>";
						echo "<td><select name=\"escritura\" style=\"width:150px\">";
							if ($row2["propietario"] == 0){
								if ($row2["escritura"] == 0) {
									echo "<option value=\"0\" selected>".$Lectura."</option>";
									echo "<option value=\"1\">".$Lectura."/".$Escritura."</option>";
								}
								if ($row2["escritura"] == 1) {
									echo "<option value=\"0\">".$Lectura."</option>";
									echo "<option value=\"1\" selected>".$Lectura."/".$Escritura."</option>";
								}
							} else {
									echo "<option value=\"1\" selected>".$Lectura."/".$Escritura."</option>";
							}
						echo "</select></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
					if ($row2["propietario"] == 0){
						echo "<form action=\"index.php?op=1017&sop=100&ssop=4&id=".$rowv["id"]."&user=".$rowu["id"]."\" method=\"post\">";
					} else {
						echo "<form action=\"index.php?op=1017&sop=100&ssop=5&id=".$row2["id"]."\" method=\"post\">";
					}
						echo "<td><input type=\"Submit\" value=\"".$Propietario."\" style=\"width:80px\"></td>";
					echo "</form>";
					echo "</tr>";
				}
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 101) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar el permiso seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=100&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=100\">[ NO ]</a></center><br>";
	}

	if (($soption == 110) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_tareas_tipos_plantillas (id_tarea_tipo,id_plantilla) ";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id"];
			$sql = $sql.",".$_POST["id_plantilla"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "delete from sgm_tareas_tipos_plantillas WHERE id=".$_GET["id_tarea_tipo"];
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Plantillas." ".$Asociadas." al ".$Tipo." de ".$Tarea." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=70\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		$sqluuxx = "select * from sgm_tareas_tipos where id=".$_GET["id"];
		$resultuuxx = mysql_query(convertSQL($sqluuxx));
		$rowuuxx = mysql_fetch_array($resultuuxx);
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"text-align:center;\">".$rowuuxx["tipo"]."</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1017&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
#				echo "<td></td>";
				echo "<td><select name=\"id_plantilla\" style=\"width:100px\">";
					$sqlx = "select * from sgm_ft_plantilla where visible=1";
					$resultx = mysql_query(convertSQL($sqlx));
					while ($rowx = mysql_fetch_array($resultx)) {	
						echo "<option value=\"".$rowx["id"]."\">".$rowx["plantilla"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir." ".$Plantilla."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql2 = "select * from sgm_tareas_tipos_plantillas where id_tarea_tipo=".$_GET["id"];
			$result2 = mysql_query(convertSQL($sql2));
			while ($row2 = mysql_fetch_array($result2)) {	
				$sqlv = "select * from sgm_ft_plantilla where id=".$row2["id_plantilla"];
				$resultv = mysql_query(convertSQL($sqlv));
				$rowv = mysql_fetch_array($resultv);
				echo "<tr>";
					echo "<td style=\"text-align:left;\">".$rowv["plantilla"]."</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=111&id_tarea_tipo=".$row2["id"]."&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
		echo "<br><br><br>* Solo elimina las relaciones, no las plantillas o los datos entrados.";
	}

	if (($soption == 111) and ($admin == true)) {
		echo "<br><br>¿Desea eliminar la relación seleccionada?";
		echo "<br><br><a href=\"index.php?op=1017&sop=110&ssop=2&id_tarea_tipo=".$_GET["id_tarea_tipo"]."&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=110&id=".$_GET["id"]."\">[ NO ]</a>";
	}

	if (($soption == 120) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$sql = "insert into sgm_agendas (nombre,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nombre"]."'";
			$sql = $sql.",'".$_POST["descripcion"]."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 2) and ($admin == true)) {
			$sql = "update sgm_agendas set ";
			$sql = $sql."nombre='".$_POST["nombre"]."'";
			$sql = $sql.",descripcion='".$_POST["descripcion"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_agendas set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Agendas."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1017&sop=40\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"\"><em>Eliminar</em></td>";
			echo "<td style=\"text-align:center;\">".$Agendas."</td>";
			echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
			echo "<form action=\"index.php?op=1017&sop=120&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
			echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:300px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "<td></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_agendas where visible=1";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=121&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1017&sop=120&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:300px\" value=\"".$row["descripcion"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if (($soption == 121) and ($admin == true)) {
		echo "<center><br>¿Desea eliminar la agenda seleccionado?";
		echo "<br><br><a href=\"index.php?op=1017&sop=120&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1017&sop=120\">[ NO ]</a></center><br>";
	}

	if ($soption == 200) {
		if ($ssoption == 1000) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				$archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
				$tipo = $_POST["id_tipo"];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
				$tipo = $HTTP_POST_VARS["id_tipo"];
			}
			$sql = "select * from sgm_files_tipos where id=".$tipo;
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			$lim_tamano = $row["limite_kb"]*1000;
			if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
				if (copy ($archivo, "files/tareas/".$archivo_name)) {
					echo "<center>";
					echo "<h2>Se ha transferido el archivo $archivo_name</h2>";
					echo "<br>Su tamaño es: $archivo_size bytes<br><br>";
					echo "Operación realizada correctamente.";
					echo "</center>";
				}
			}else{
				echo "<h2>No ha podido transferirse el archivo.</h2>";
				echo "<h3>Su tamaño no puede exceder de ".$lim_tamano." bytes.</h2>";
			}
		}
		echo "<strong>".$Importar." ".$Tarea." :</strong>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1017&sop=200&ssop=1000&usuario=".$_GET["usuario"]."\" method=\"post\">";
					echo "<center>";
						echo "<input type=\"hidden\" name=\"id_tipo\" value=\"4\">";
						echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
						echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta FILES/tareas/\" style=\"width:200px\">";
					echo "</center>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		if ($archivo_name != ""){
			echo "<table>";
				echo "</tr>";
					echo "<td>";
					$d="";
					$fecha="";
					$linea="";
					$line="";
					$x=1;
					$ar=fopen("files/tareas/".$archivo_name,"r");
					while (!feof($ar)){
						$line=fgets($ar);
						$linea= $linea.$line;
						if ($linea != ""){
							$contador = explode( "	", $linea);
							$total = count($contador);
							if (($total >= 22) and ($x > 1)){
								$convi1=0;
								$convi2=0;
								$convi3=0;
								$convi4=0;
								$convi5=0;
								$convi6=0;
								$convi7=0;
								$convi8=0;
								$convi9=0;
								$nom1=0;
								$nom2=0;
								$nom3=0;
								$nom4=0;
								$nom5=0;
								$nom6=0;
								$nom7=0;
								$nom8=0;
								$nom9=0;
								list($asunto, $data_com, $hora_com, $data_fin, $fin, $mx, $n, $data_reminder, $hora_reminder, $user, $convidats, $c, $dx, $e, $f, $notas, $g, $h, $j, $privado, $k, $l) = explode( "	", $linea);
								list($d, $m, $a) = explode("/", $data_com);
								$d = str_replace(chr(34),"",$d);
								$a = str_replace(chr(34),"",$a);
								if ($d < 10){ $dia = "0".$d; } else { $dia = $d; }
								if ($m < 10){ $mes = "0".$m; } else { $mes = $m; }
								$fecha = $a."-".$mes."-".$dia;
								$data_inst = $fecha." ".$hora_com;
								$data_insert = str_replace(chr(34),"",$data_inst);
								$data_final = str_replace(chr(34),"",$data_fin);
								$tiempo = RestarHoras($hora_com,$fin);
								if ($tiempo == 0){$time = 600;} else {$time = $tiempo;}
								if ($fin == "0:00:00"){
									$fin = "23:59:59";
								} else {
									list($d, $m, $a) = explode("/", $data_final);
									$d = str_replace(chr(34),"",$d);
									$a = str_replace(chr(34),"",$a);
									if ($d < 10){ $dia = "0".$d; } else { $dia = $d; }
									if ($m < 10){ $mes = "0".$m; } else { $mes = $m; }
									$fecha = $a."-".$mes."-".$dia;
								}
								$data_final = $fecha." ".$fin;
								$data_finalit = str_replace(chr(34),"",$data_final);
								if ($asunto == "") { $asunto = "''"; }
								$notas = str_replace(chr(34),"'",$notas);
								if ($notas == "") { $notas = "''"; }
								$privado = str_replace(chr(34),"'",$privado);
								if ($privado == "") { $privado = "0"; }
								if ($privado == "'Falso'") { $privado = "0"; } else { $privado = "1"; }
								$user = str_replace(chr(34),"",$user);
								if ($user != "") { list($cognom, $nom) = explode(", ", $user); } else { $nom = 0;}
								if ($nom != "") {} else {list($cognom, $nom) = explode(" ", $user); }
								if ($nom != "") {} else {list($cognom, $nom) = explode(",", $user); }
								$sqlu = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom."'";
								$resultu = mysql_query(convertSQL($sqlu));
								$rowu = mysql_fetch_array($resultu);

								$convidats = str_replace(chr(34),"",$convidats);
								$num_convidats = explode(";", $convidats);
								$total_convidats = count($num_convidats);
								if ($total_convidats == 1){$convi1 = $convidats;}
								if ($total_convidats == 2){list($convi1, $convi2) = explode(";", $convidats);}
								if ($total_convidats == 3){list($convi1, $convi2, $convi3) = explode(";", $convidats);}
								if ($total_convidats == 4){list($convi1, $convi2, $convi3, $convi4) = explode(";", $convidats);}
								if ($total_convidats == 5){list($convi1, $convi2, $convi3, $convi4, $convi5) = explode(";", $convidats);}
								if ($total_convidats == 6){list($convi1, $convi2, $convi3, $convi4, $convi5, $convi6) = explode(";", $convidats);}
								if ($total_convidats == 7){list($convi1, $convi2, $convi3, $convi4, $convi5, $convi6, $convi7) = explode(";", $convidats);}
								if ($total_convidats == 8){list($convi1, $convi2, $convi3, $convi4, $convi5, $convi6, $convi7, $convi8) = explode(";", $convidats);}
								if ($total_convidats == 9){list($convi1, $convi2, $convi3, $convi4, $convi5, $convi6, $convi7, $convi8, $convi9) = explode(";", $convidats);}

								if ($convi1 != "") { list($cognom1, $nom1) = explode(", ", $convi1); }
								if ($nom1 != "") {} else {list($cognom, $nom1) = explode(" ", $convi1); }
								if ($nom1 != "") {} else {list($cognom, $nom1) = explode(",", $convi1); }

								if ($convi2 != "") { list($cognom2, $nom2) = explode(", ", $convi2); }
								if ($nom2 != "") {} else {list($cognom, $nom2) = explode(" ", $convi2); }
								if ($nom2 != "") {} else {list($cognom, $nom2) = explode(",", $convi2); }

								if ($convi3 != "") { list($cognom3, $nom3) = explode(", ", $convi3); }
								if ($nom3 != "") {} else {list($cognom, $nom3) = explode(" ", $convi3); }
								if ($nom3 != "") {} else {list($cognom, $nom3) = explode(",", $convi3); }

								if ($convi4 != "") { list($cognom4, $nom4) = explode(", ", $convi4); }
								if ($nom4 != "") {} else {list($cognom, $nom4) = explode(" ", $convi4); }
								if ($nom4 != "") {} else {list($cognom, $nom4) = explode(",", $convi4); }

								if ($convi5 != "") { list($cognom5, $nom5) = explode(", ", $convi5); }
								if ($nom5 != "") {} else {list($cognom, $nom5) = explode(" ", $convi5); }
								if ($nom5 != "") {} else {list($cognom, $nom5) = explode(",", $convi5); }

								if ($convi6 != "") { list($cognom6, $nom6) = explode(", ", $convi6); }
								if ($nom6 != "") {} else {list($cognom, $nom6) = explode(" ", $convi6); }
								if ($nom6 != "") {} else {list($cognom, $nom6) = explode(",", $convi6); }

								if ($convi7 != "") { list($cognom7, $nom7) = explode(", ", $convi7); }
								if ($nom7 != "") {} else {list($cognom, $nom7) = explode(" ", $convi7); }
								if ($nom7 != "") {} else {list($cognom, $nom7) = explode(",", $convi7); }

								if ($convi8 != "") { list($cognom8, $nom8) = explode(", ", $convi8); }
								if ($nom8 != "") {} else {list($cognom, $nom8) = explode(" ", $convi8); }
								if ($nom8 != "") {} else {list($cognom, $nom8) = explode(",", $convi8); }

								if ($convi9 != "") { list($cognom9, $nom9) = explode(", ", $convi9); }
								if ($nom9 != "") {} else {list($cognom, $nom9) = explode(" ", $convi9); }
								if ($nom9 != "") {} else {list($cognom, $nom9) = explode(",", $convi9); }

								if ($nom1 != ""){
									$sql1 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom1."'";
									$result1 = mysql_query(convertSQL($sql1));
									$row1 = mysql_fetch_array($result1);
									$sql1 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row1["id"];
									$result1 = mysql_query(convertSQL($sql1));
									$row1 = mysql_fetch_array($result1);
									$nom1 = $row1["id_agenda"];
								} else { $nom1 = 0;}

								if ($nom2 != ""){
									$sql2 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom2."'";
									$result2 = mysql_query(convertSQL($sql2));
									$row2 = mysql_fetch_array($result2);
									$sql2 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row2["id"];
									$result2 = mysql_query(convertSQL($sql2));
									$row2 = mysql_fetch_array($result2);
									$nom2 = $row2["id_agenda"];
								} else { $nom2 = 0;}

								if ($nom3 != ""){
									$sql3 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom3."'";
									$result3 = mysql_query(convertSQL($sql3));
									$row3 = mysql_fetch_array($result3);
									$sql3 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row3["id"];
									$result3 = mysql_query(convertSQL($sql3));
									$row3 = mysql_fetch_array($result3);
									$nom3 = $row3["id_agenda"];
								} else { $nom3 = 0;}

								if ($nom4 != ""){
									$sql4 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom4."'";
									$result4 = mysql_query(convertSQL($sql4));
									$row4 = mysql_fetch_array($result4);
									$sql4 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row4["id"];
									$result4 = mysql_query(convertSQL($sql4));
									$row4 = mysql_fetch_array($result4);
									$nom4 = $row4["id_agenda"];
								} else { $nom4 = 0;}

								if ($nom5 != ""){
									$sql5 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom5."'";
									$result5 = mysql_query(convertSQL($sql5));
									$row5 = mysql_fetch_array($result5);
									$sql5 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row5["id"];
									$result5 = mysql_query(convertSQL($sql5));
									$row5 = mysql_fetch_array($result5);
									$nom5 = $row5["id_agenda"];
								} else { $nom5 = 0;}

								if ($nom6 != ""){
									$sql6 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom6."'";
									$result6 = mysql_query(convertSQL($sql6));
									$row6 = mysql_fetch_array($result6);
									$sql6 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row6["id"];
									$result6 = mysql_query(convertSQL($sql6));
									$row6 = mysql_fetch_array($result6);
									$nom6 = $row6["id_agenda"];
								} else { $nom6 = 0;}

								if ($nom7 != ""){
									$sql7 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom7."'";
									$result7 = mysql_query(convertSQL($sql7));
									$row7 = mysql_fetch_array($result7);
									$sql7 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row7["id"];
									$result7 = mysql_query(convertSQL($sql7));
									$row7 = mysql_fetch_array($result7);
									$nom7 = $row7["id_agenda"];
								} else { $nom7 = 0;}

								if ($nom8 != ""){
									$sql8 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom8."'";
									$result8 = mysql_query(convertSQL($sql8));
									$row8 = mysql_fetch_array($result8);
									$sql8 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row8["id"];
									$result8 = mysql_query(convertSQL($sql8));
									$row8 = mysql_fetch_array($result8);
									$nom8 = $row8["id_agenda"];
								} else { $nom8 = 0;}

								if ($nom9 != ""){
									$sql9 = "select * from sgm_users where activo=1 and validado=1 and usuario='".$nom9."'";
									$result9 = mysql_query(convertSQL($sql9));
									$row9 = mysql_fetch_array($result9);
									$sql9 = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$row9["id"];
									$result9 = mysql_query(convertSQL($sql9));
									$row9 = mysql_fetch_array($result9);
									$nom9 = $row9["id_agenda"];
								} else { $nom9 = 0;}

								$fecha = getdate();
								$fecha1 = date("Y-m-d", mktime(0,0,0,$fecha["mon"] ,$fecha["mday"], $fecha["year"]))." ".date("H:i");

								$sql = "select count(*) as total from sgm_tareas where visible=1 and data_margen='".$data_finalit."' and asunto='".$asunto."' and data_registro='".$data_insert."' and notas_registro=".$notas." and tiempo=".$time." and privada=".$privado;
								$result = mysql_query(convertSQL($sql));
								$row = mysql_fetch_array($result);
								if (($row["total"] == 0 ) and ($rowu["id"] > 0)){
									$sqlau = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$rowu["id"];
									$resultau = mysql_query(convertSQL($sqlau));
									while ($rowau = mysql_fetch_array($resultau)){
										$sqla = "insert into sgm_tareas (asunto,data_registro,data_margen,notas_registro,privada,id_agenda,id_estado,data_insert,id_2,id_3,id_4,id_5,id_6,id_7,id_8,id_9,id_10,tiempo) ";
										$sqla = $sqla."values ('".$asunto."','".$data_insert."','".$data_finalit."',".$notas.",".$privado.",".$rowau["id_agenda"].",-1,'".$fecha1."',".$nom1.",".$nom2.",".$nom3.",".$nom4.",".$nom5.",".$nom6.",".$nom7.",".$nom8.",".$nom9.",".$time.")";
										mysql_query(convertSQL($sqla));
									}
								}
								if (($row["total"] == 0 ) and ($rowu["id"] <= 0)){
									$sqlau = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$userid;
									$resultau = mysql_query(convertSQL($sqlau));
									while ($rowau = mysql_fetch_array($resultau)){
										$sqla = "insert into sgm_tareas (asunto,data_registro,data_margen,notas_registro,privada,id_agenda,id_estado,data_insert,id_2,id_3,id_4,id_5,id_6,id_7,id_8,id_9,id_10,tiempo) ";
										$sqla = $sqla."values ('".$asunto."','".$data_insert."','".$data_finalit."',".$notas.",".$privado.",".$rowau["id_agenda"].",-1,'".$fecha1."',".$nom1.",".$nom2.",".$nom3.",".$nom4.",".$nom5.",".$nom6.",".$nom7.",".$nom8.",".$nom9.",".$time.")";
										mysql_query(convertSQL($sqla));
									}
								}
								$linea="";
							}
							if ($x == 1) {$linea="";}
							$x++;
						}
					}

					$sqld = "insert into sgm_tareas_reg (data_sincro) values ('".$fecha1."')";
					mysql_query(convertSQL($sqld));
					fclose($ar);
					if (!unlink("files/tareas/".$archivo_name)){
						echo "no se pudo borrar el archivo :".$archivo_name;
					}
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		}
		echo "</center>";
		echo "<br><br><br>";
		echo "<strong>".$Exportar." ".$Tarea." :</strong>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"5\">";
			echo "<tr>";
				echo "<td style=\"background-color:silver;\">".$Desde."</td>";
				echo "<td style=\"background-color:silver;\">".$Hasta."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<form action=\"index.php?op=1017&sop=200&usuario=".$_GET["usuario"]."\" method=\"post\">";
							echo "<center>";
								echo "<td><select name=\"dia1\" style=\"width:40px;\">";
									for ($i = 1; $i <= 31; $i++){
										if ($_POST["dia1"] == $i){
											echo "<option value=\"".$i."\" selected>".$i."</option>";
										} else {
											echo "<option value=\"".$i."\">".$i."</option>";
										}
									}
								echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
								echo "<td><select name=\"mes1\" style=\"width:40px;\">";
									for ($i = 1; $i <= 12; $i++){
										if ($_POST["mes1"] == $i){
											echo "<option value=\"".$i."\" selected>".$i."</option>";
										} else {
											echo "<option value=\"".$i."\">".$i."</option>";
										}
									}
								echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
								echo "<td><select name=\"año1\" style=\"width:60px;\">";
									for ($i = 2005; $i <= 2100; $i++){
										if ($_POST["año1"] == $i){
											echo "<option value=\"".$i."\" selected>".$i."</option>";
										} else {
											echo "<option value=\"".$i."\">".$i."</option>";
										}
									}
								echo "</select></td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
					echo "<td>";
						echo "<table cellpadding=\"0\" cellspacing=\"0\">";
							echo "<tr>";
								echo "<td><select name=\"dia2\" style=\"width:40px;\">";
									for ($i = 1; $i <= 31; $i++){
										if ($_POST["dia2"] == $i){
											echo "<option value=\"".$i."\" selected>".$i."</option>";
										} else {
											echo "<option value=\"".$i."\">".$i."</option>";
										}
									}
								echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
								echo "<td><select name=\"mes2\" style=\"width:40px;\">";
									for ($i = 1; $i <= 12; $i++){
										if ($_POST["mes2"] == $i){
											echo "<option value=\"".$i."\" selected>".$i."</option>";
										} else {
											echo "<option value=\"".$i."\">".$i."</option>";
										}
									}
								echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
								echo "<td><select name=\"año2\" style=\"width:60px;\">";
									for ($i = 2005; $i <= 2100; $i++){
										if ($_POST["año2"] == $i){
											echo "<option value=\"".$i."\" selected>".$i."</option>";
										} else {
											echo "<option value=\"".$i."\">".$i."</option>";
										}
									}
								echo "</select></td>";
							echo "</tr>";
						echo "</table>";
				echo "</td>";
				echo "<td><input type=\"submit\" value=\"Crear .TXT\" style=\"width:100px\"></td>";
				echo "</center>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		if (($_POST["dia1"] != "") and ($_POST["mes1"] != "") and ($_POST["año1"] != "")){
			$desde = $_POST["año1"]."-".$_POST["mes1"]."-".$_POST["dia1"]." 00:00:00";
			$hasta = $_POST["año2"]."-".$_POST["mes2"]."-".$_POST["dia2"]." 23:59:59";
			$nombre_archivo = "temporal/incidencia.txt";
			$principal="Asunto	Fecha de comienzo	Comienzo	Fecha de finalización	Finalización	Todo el día	Reminder on/off	Reminder Date	Reminder Time	Meeting Organizer	Required Attendees	Optional Attendees	Recursos de la reunión	Billing Information	Categories	Description	Location	Mileage	Priority	Private	Sensitivity	Show time as";
			fopen($nombre_archivo, 'w');
			if (is_writable($nombre_archivo)) {
				if (!$gestor = fopen($nombre_archivo, 'a')) {
					mensageError("No se puede abrir el archivo (".$nombre_archivo.")");
					exit;
				}
				if (fwrite($gestor, $principal) === FALSE) {
					mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
					exit;
				}
				if (fwrite($gestor, "\r\n") === FALSE) {
					mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
					exit;
				}
				$sql = "select * from sgm_tareas where visible=1 and data_registro>'".$desde."' and data_registro<'".$hasta."'";
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)){
					if ($row["notas_registro"] != "") { $notas = "\"".$row["notas_registro"]."\""; } else { $notas = ""; }
					$sqlu = "select u.usuario from sgm_users u JOIN sgm_agendas_users a ON u.id=a.id_user where validado=1 and activo=1";
					$resultu = mysql_query(convertSQL($sqlu));
					$rowu = mysql_fetch_array($resultu);
					if ($rowu["usuario"] != ""){ $usuari = "\"".$rowu["usuario"]."\""; } else { $usuari = ""; }
					$x = "";
					$fals = "Falso";
					list($data, $hora) = explode(" ", $row["data_registro"]);
					list($a, $m, $d) = explode("-", $data);
					$date = $d."/".$m."/".$a;
					if ($row["data_finalizacion"] != ""){
						list($data2, $hora2) = explode(" ", $row["data_finalizacion"]);
						list($a, $m, $d) = explode("-", $data2);
						$date2 = $d."/".$m."/".$a;
					} else { $date2 = ""; $hora2 = "";}
					if ($row["privada"] == 0) {$privado = "Verdadero";} else {$privado = "Falso"; }
					$contenido.= $row["asunto"]."	".$date."	".$hora."	".$date2."	".$hora2."	".$fals."	".$fals."	".$x."	".$x."	".$usuari."	".$x."	".$x."	".$x."	".$x."	".$notas."	".$x."	".$x."	".$privado."	Normal	1";
					if (fwrite($gestor, $contenido) === FALSE) {
						mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
						exit;
					}
					if (fwrite($gestor, "\r\n") === FALSE) {
						mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
						exit;
					}
					$contenido = "";
				}
	 			fclose($gestor);
			} else {
				mensageError("No se puede escribir al archivo (".$nombre_archivo.")");
			}
		echo mensageInfo("<a href=\"temporal/incidencia.txt\" style=\"color:white\">click boton derecho y \"guardar como\"</a>","green");
		}
		echo "</center>";
		echo "<br><br><br>";

		if ($ssoption == 1){
			$sqls = "select * from sgm_tareas_reg where id=".$_GET["id"];
			$results = mysql_query(convertSQL($sqls));
			$rows = mysql_fetch_array($results);
			$sql = "update sgm_tareas set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE data_insert='".$rows["data_sincro"]."'";
			mysql_query(convertSQL($sql));

			$sql = "delete from sgm_tareas_reg";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Sincronizaciones." de ".$Tarea." :</strong>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		$x = 1;
		$sqls = "select * from sgm_tareas_reg order by data_sincro desc";
		$results = mysql_query(convertSQL($sqls));
		while ($rows = mysql_fetch_array($results)) {
			if ($x <= 5){
				echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=200&ssop=1&id=".$rows["id"]."&usuario=".$_GET["usuario"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<td style=\"width:150px\">".$rows["data_sincro"]."</td>";
				echo "</tr>";
				$x++;
			}
		}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 300){
		
#		echo time()."<br>";
#		echo strtotime ("2009-07-06 19:35:00")."<br>";
#		$x ="06-07-2009 19:35";
#		echo strtotime (substr($x,6,4)."-".substr($x,3,2)."-".substr($x,0,2)." ".substr($x,11,2).":".substr($x,14,2).":00")."<br>";
		echo strtotime ("1972-07-06 08:00:00")."<br>";
		$i = strtotime ("1972-07-06 08:00:00");
		echo date("d-m-Y H:i",$i)."<br>";
	}


	echo "</td></tr></table><br>";

}


function cerrable($id_tarea)
{ 
	global $db;
	$volver = true;
	$sqlx = "select * from sgm_tareas where id_origen=".$id_tarea;
	$resultx = mysql_query(convertSQL($sqlx));
	while ($rowx = mysql_fetch_array($resultx) and ($volver == true)) {
		if (($rowx["id_estado"] != -2) and cerrable($rowx["id"])) {	$volver = false; }
	}
	return $volver;
}

function relacionable($id_tarea,$id_inici)
{ 
	global $db;
			$volver = false;
			$sqlx = "select * from sgm_tareas where id=".$id_inici;
			$resultx = mysql_query(convertSQL($sqlx));
			$rowx = mysql_fetch_array($resultx);
			$id = $rowx["id"];
			$id_origen = $rowx["id_origen"];

			while (($id != $id_tarea) and ($id_origen != 0)) {
				$sqlxx = "select * from sgm_tareas where id=".$id_origen;
				$resultxx = mysql_query(convertSQL($sqlxx));
				$rowxx = mysql_fetch_array($resultxx);
				$id = $rowxx["id"];
				$id_origen = $rowxx["id_origen"];
			}
			if (($id_origen == 0) and ($id_tarea != $id)) { $volver = true; } 

			return $volver;
}

function ver_agenda($id,$dia,$any,$mes,$usuario)
{
	global $db;
		$sqlv = "select * from sgm_agendas where visible=1 and id=".$id;
		$resultv = mysql_query(convertSQL($sqlv));
		$rowv = mysql_fetch_array($resultv);

		$sqlau = "select * from sgm_agendas_users where visible=1 and id_agenda=".$id." and id_user=".$usuario;
		$resultau = mysql_query(convertSQL($sqlau));
		$rowau = mysql_fetch_array($resultau);

			echo "<td style=\"vertical-align:top;width:350px;text\">";
				echo "<center>";
				echo "<strong>Agenda : </strong><font style=\"font-size:14px\">".$rowv["nombre"]." </font> <strong>".$any."-".$mes."-".$dia."</strong>";
				echo "<br>";
				echo "<div style=\"width:300px;height:500px;position:relative;left:0;top:0;z-index:1\">";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						$i=0;
						while ($i <= 23) {
								if ($i < 10) {
									$hora = "0".$i.":00";
								} else {
									$hora =  $i.":00";
								}
						echo "<tr>";
							echo "<td>";
								if ($rowau["escritura"] == 1){
								echo "<form action=\"index.php?op=1017&sop=20\" method=\"post\">";
									echo "<input type=\"Submit\" style=\"background-color : #4B53AF;color :white;width:25px;text-align:center\" value=\"&raquo;\">";
									echo "<input type=\"Hidden\" name=\"data_registro\" value=\"".$any."-".$mes."-".$dia." ".$hora.":00\">";
									echo "<input type=\"Hidden\" name=\"tiempo\" value=\"60\">";
									echo "<input type=\"Hidden\" name=\"id_agenda\" value=\"".$id."\">";
								echo "</form>";
								}
							echo "</td>";
							if ($i == 0){
								echo "<td style=\"vertical-align:top;width:600px;height:20px;border-bottom:0px solid black;border-top:1px solid black;background-color:#FFEA6C\">";
							} else {
								if (($i < 8) or ($i > 16)) {
									echo "<td style=\"vertical-align:top;width:600px;height:20px;border-bottom:0px solid black;border-top:1px solid black;background-color:#FFEA6C\">";
								} else {
									echo "<td style=\"vertical-align:top;width:600px;height:20px;border-bottom:0px solid black;border-top:1px solid black;background-color:#FFF19F\">";
								}
							}
							$i ++;
							echo $hora;
							echo "</td>";
						echo "</tr>";
						}
					echo "</table>";
					$horainici = '00:00:00';
					$hoy1 = $any."-".$mes."-".$dia." ".$horainici;
					$horafin = '23:59:59';
					$hoy2 = $any."-".$mes."-".$dia." ".$horafin;
					$sql = "select * from sgm_tareas where visible=1 and tiempo > 0 and ((id_agenda=".$id.") or (id_2=".$id.") or (id_3=".$id.") or (id_4=".$id.") or (id_5=".$id.") or (id_6=".$id.") or (id_7=".$id.") or (id_8=".$id.") or (id_9=".$id."))";
					if ($rowau["propietario"] == 0) { $sql.=" and privada=1"; }
					$sql.= " order by data_registro";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)){
						if (($row["data_registro"] >= $hoy1) and ($row["data_registro"] <= $hoy2)){
							$hora = date("H", strtotime($row["data_registro"])); 
							$minut = date("i", strtotime($row["data_registro"]));
							$segon = date("s", strtotime($row["data_registro"]));
							$posicion = (($hora*20)+($minut*0.333333333333333333));
							$sqlc = "select * from sgm_clients where id=".$row["id_cliente"];
							$resultc = mysql_query(convertSQL($sqlc));
							$rowc = mysql_fetch_array($resultc);
							$estado_color = "White";
							if ($row["id_estado"] > 0) {
								$sqle = "select * from sgm_tareas_estados where id=".$row["id_estado"];
								$resulte = mysql_query(convertSQL($sqle));
								$rowe = mysql_fetch_array($resulte);
								$estado_color = $rowe["color"];
								$estado_color_letras = "Black";
							} else {
								if ($row["id_estado"] == -1) { 
									$estado_color = "Red";
									$estado_color_letras = "White";
								}
								if ($row["id_estado"] == -2) {
									$estado_color = "White";
									$estado_color_letras = "Black";
								}
							}
							echo "<div style=\"position:absolute;left:70;top:".($posicion).";z-index:2;width:200px;height:".(($row["tiempo"]*0.33333333333)-1)."px;background-color:".$estado_color.";color:".$estado_color_letras.";border:1px solid black\">";
								echo "<a href=\"index.php?op=1017&sop=20&id=".$row["id"]."\" style=\"color:".$estado_color_letras.";\">";
								if (strlen($rowc["nombre"]) > 35) { echo substr($rowc["nombre"],0,36); } else {	echo $rowc["nombre"]; }
								if ($row["asunto"] != "") { echo " - \"".$row["asunto"]."\""; }
								if (($row["asunto"] == "") and ($row["id_cliente"] == 0)) {	echo "VER TAREA"; }
								echo "</a>";
							echo "</div>";
						}
					}
				echo "</div>";
				echo "</center>";
				echo "</td>";
}

function mostrar_incidencia($tipus,$hoy1,$hoy2,$agenda1,$agenda2,$usuario)
{
	$agenda[0] = $agenda1;
	$agenda[1] = $agenda2;
	for ($i = 0; $i < 2 ; $i++){
		$sqlu = "select * from sgm_agendas_users where id_agenda=".$agenda[$i]." and id_user=".$usuario;
		$resultu = mysql_query(convertSQL($sqlu));
		$rowu = mysql_fetch_array($resultu);
		if ($rowu["propietario"] == 0){ $ver_privada = "and privada=1"; } else { $ver_privada = ""; }

		if ($tipus == 1){$sql = "select * from sgm_tareas where ((data_registro>'".$hoy1."') or (data_registro='".$hoy1."')) and ((data_registro<'".$hoy2."') or (data_registro='".$hoy2."')) and visible=1 and ((id_agenda=".$agenda[$i].") or (id_2=".$agenda[$i].") or (id_3=".$agenda[$i].") or (id_4=".$agenda[$i].") or (id_5=".$agenda[$i].") or (id_6=".$agenda[$i].") or (id_7=".$agenda[$i].") or (id_8=".$agenda[$i].") or (id_9=".$agenda[$i].")) ".$ver_privada." order by data_registro";}
		if ($tipus == 2){$sql = "select * from sgm_tareas where ((data_registro>'".$hoy2."') or (data_registro='".$hoy2."')) and visible=1 and ((id_agenda=".$agenda[$i].") or (id_2=".$agenda[$i].") or (id_3=".$agenda[$i].") or (id_4=".$agenda[$i].") or (id_5=".$agenda[$i].") or (id_6=".$agenda[$i].") or (id_7=".$agenda[$i].") or (id_8=".$agenda[$i].") or (id_9=".$agenda[$i].")) ".$ver_privada." order by data_registro";}
		if ($tipus == 3){$sql = "select * from sgm_tareas where ((data_registro<'".$hoy1."') or (data_registro='".$hoy1."')) and data_registro<>'1900-01-01 00:00:00' and id_estado<>-2  and id_origen=0 and visible=1 and id_cliente<>0 and ((id_agenda=".$agenda[$i].") or (id_2=".$agenda[$i].") or (id_3=".$agenda[$i].") or (id_4=".$agenda[$i].") or (id_5=".$agenda[$i].") or (id_6=".$agenda[$i].") or (id_7=".$agenda[$i].") or (id_8=".$agenda[$i].") or (id_9=".$agenda[$i].")) ".$ver_privada." order by data_registro";}
		if ($tipus == 4){$sql = "select * from sgm_tareas where id_estado<>-2 and ((data_registro is NULL) or (data_registro = '0000-00-00 00:00:00') or (data_registro = '1900-01-01 00:00:00'))and id_origen=0 and id_cliente=0 and visible=1 and ((id_agenda=".$agenda[$i].") or (id_2=".$agenda[$i].") or (id_3=".$agenda[$i].") or (id_4=".$agenda[$i].") or (id_5=".$agenda[$i].") or (id_6=".$agenda[$i].") or (id_7=".$agenda[$i].") or (id_8=".$agenda[$i].") or (id_9=".$agenda[$i].")) ".$ver_privada." order by data_registro";}
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					if ($row["id_estado"] > 0) {
						$sqle = "select * from sgm_tareas_estados where id=".$row["id_estado"];
						$resulte = mysql_query(convertSQL($sqle));
						$rowe = mysql_fetch_array($resulte);
						$descripcion_estado = $rowe["estado"];
						$estado_color = $rowe["color"];
						$estado_color_letras = "Black";
					} else {
						if ($row["id_estado"] == -1) { 
							$descripcion_estado = "Registrada";
							$estado_color = "Red";
							$estado_color_letras = "White";
						}
						if ($row["id_estado"] == -2) {
							$descripcion_estado = "Finalizada";
							$estado_color = "White";
							$estado_color_letras = "Black";
						}
					}
					$sqlc = "select * from sgm_clients where id=".$row["id_cliente"];
					$resultc = mysql_query(convertSQL($sqlc));
					$rowc = mysql_fetch_array($resultc);
					echo "<tr style=\"background-color:".$estado_color.";\">";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:25px;text-align:right\">".$row["id"]."</td>";
						$sqlti = "select count(*) as total from sgm_tareas where id_origen=".$row["id"]." and visible=1";
						$resultti = mysql_query(convertSQL($sqlti));
						$rowti = mysql_fetch_array($resultti);
						if (($rowti["total"] == 0) and ($rowu["escritura"] == 1)) {
							echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1017&sop=24&id=".$row["id"]."&usuario=".$usuario."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
						} else { echo "<td style=\"text-align:center;vertical-align:top;\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></td>"; }
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".date('d-m H:i',strtotime($row["data_registro"]))."</td>";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:200px;\">";
					if ($tipus != 4){
						if ($row["id_cliente"] == 0) {
							if (strlen($row["cliente_nombre"]) > 25) {
								echo "&nbsp;&nbsp;".substr($row["cliente_nombre"],0,26);
							} else {
								echo "&nbsp;&nbsp;".$row["cliente_nombre"];
							}
						} else {
							if (strlen($rowc["nombre"]) > 25) {
								 echo "&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=200&id=".$rowc["id"]."\" style=\"color:".$estado_color_letras.";\">".substr($rowc["nombre"],0,26)." ...</a>";
							} else {
								echo "&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=200&id=".$rowc["id"]."\" style=\"color:".$estado_color_letras.";\">".$rowc["nombre"]."</a>";
							}
						}
					}
						if ($row["asunto"] != "") {
							echo "<br><strong>".$row["asunto"]."</strong>";
						}
						echo "</td>";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:100px\">";
							if (strlen($$descripcion_estado) > 15) {
								 echo "&nbsp;".substr($descripcion_estado,0,16)." ...";
							} else {
								echo "&nbsp;".$descripcion_estado."</a>";
							}
							echo "</td>";
						echo "<td style=\"text-align:center;vertical-align:top;\">";
							$inc = 0;
							if ($row["data_registro"] == '0000-00-00 00:00:00'){$inc = 2;}
							echo "<a href=\"index.php?op=1017&sop=20&id=".$row["id"]."&inc=".$inc."&usuario=".$usuario."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px;\"><a>";
							echo "&nbsp;";
							echo "<a href=\"/demo/mgestion/gestion-agenda-print.php?id=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px;\"></a>";
						echo "</td>";
						echo "<td style=\"text-align:center;vertical-align:top;width:70px;\">";
							if ($rowu["escritura"] == 1) {
								echo "<form action=\"index.php?op=1017&sop=0&ssop=1&id=".$row["id"]."&usuario=".$usuario."\" method=\"post\">";
								echo "<select name=\"id_origen\" style=\"width:50px;\">";
									echo "<option value=\"0\" selected>-</option>";
									$sqlin = "select * from sgm_tareas where id<>".$row["id"]." and id_agenda=".$row["id_agenda"]." and id_estado<>-2 and visible=1 ";
									$resultin = mysql_query(convertSQL($sqlin));
									while ($rowin = mysql_fetch_array($resultin)) {
									if (relacionable($row["id"],$rowin["id"])) {
										if ($rowin["id"] == $row["id_origen"]) {
											echo "<option value=\"".$rowin["id"]."\" selected>".$rowin["id"]."</option>";
										} else {
											echo "<option value=\"".$rowin["id"]."\" >".$rowin["id"]."</option>";
										}
									}
								}
								echo "</select>";
								echo "<input type=\"Submit\" value=\"R\">";
								echo "</form>";
							}
						echo "</td>";
					echo "</tr>";
				}
	}
}


function calendario_conjunto($dia_select,$year,$mes,$usuario,$ids_users) {
	global $db;
		$a = $year;
		$m = $mes;
		$d = 1;

	### emes / eany <- mes i any anterios
	### dmes / dany <- mes i anys posteriors
	if ($m == 1) { 
		$emes = 12;
		$eany = $a-1;
	} else {
		$emes = $mes-1;
		if ($emes < 10) { $emes = "0".$emes; }
		$eany = $a;
	}
	if ($m == 12) {
		$dmes = "01";
		$dany = $a+1;
	} else { 
		$dmes = $mes+1;
		if ($dmes < 10) { $dmes = "0".$dmes; }
		$dany = $a;
	}
		$horainici = '00:00:00';
		$horafin = '23:59:59';
		for ($i = 0 ; $i < count($ids_users); $i++){
			$users = $users.$ids_users[$i];
			$users = $users.",";
		}
		$programada = 1;
		$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$totaldiasmes = 31;
			if ($mes == 1) { $mesesp = "Enero"; }
			if ($mes == 2) { 
				$mesesp = "Febrero";
				if (checkdate(2, 29, $a)) { $totaldiasmes = 29; } else { $totaldiasmes = 28; }
			}
			if ($mes == 3) { $mesesp = "Marzo"; }
			if ($mes == 4) { $mesesp = "Abril"; $totaldiasmes--; }
			if ($mes == 5) { $mesesp = "Mayo"; }
			if ($mes == 6) { $mesesp = "Junio"; $totaldiasmes--;}
			if ($mes == 7) { $mesesp = "Julio"; }
			if ($mes == 8) { $mesesp = "Agosto"; }
			if ($mes == 9) { $mesesp = "Septiembre"; $totaldiasmes--; }
			if ($mes == 10) { $mesesp = "Octubre"; }
			if ($mes == 11) { $mesesp = "Noviembre"; $totaldiasmes--; }
			if ($mes == 12) { $mesesp = "Diciembre"; }
		$semananum = 0;
		$mesok = "<center><table style=\"background-color:#4B53AF\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"text-align:center;;color:white;\">";

		$mesok .= "<a href=\"index.php?op=1017&sop=10&dd=".$dia_select."&aa=".($eany)."&mm=".($emes)."&usuario=".$usuario."\" style=\"color:white;\">&laquo;&laquo;&nbsp;&nbsp;</a>";
		$mesok .= "<strong>".$mesesp."</strong> ".$year;
		$mesok .= "<a href=\"index.php?op=1017&sop=10&dd=".$dia_select."&aa=".($dany)."&mm=".($dmes)."&usuario=".$usuario."\" style=\"color:white;\">&nbsp;&nbsp;&raquo;&raquo;</a>";

		$mesok .= "</td></tr><tr><td>";
		$mesok .= "<table style=\"background-color:#4B53AF\" cellpadding=\"0\" cellspacing=\"1\"><tr>";
		$sumadias = 0;
		$diasemana = 1;
		$semanax = 0;
		$control = 0;
		while (($d < 32) and ($mes == $m)) {
			$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
			if ($diasemana == 0) { $diasemana = 7; }
			$semana = date("W", mktime(0,0,0,$m ,$d, $a));
			if ($mes != $mesanterior) {
				$mesok .= "<td style=\"text-align:center;color:white;\">L</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">M</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">X</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">J</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">V</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">S</td>";
				$mesok .= "<td style=\"text-align:center;color:white;\">D</td>";
				$mesok .= "</tr><tr>";
			}
			if ($semana != $semanaanterior) {
				$semananum++;
				$mesok .= "</tr><tr>";
			}
			if ($semanax == 0) { 
				if ($diasemana == 7) { $mesok .= "<td></td><td></td><td></td><td></td><td></td><td></td>"; $sumadias = 6;}
				if ($diasemana == 6) { $mesok .= "<td></td><td></td><td></td><td></td><td></td>"; $sumadias = 5;}
				if ($diasemana == 5) { $mesok .= "<td></td><td></td><td></td><td></td>"; $sumadias = 4;}
				if ($diasemana == 4) { $mesok .= "<td></td><td></td><td></td>"; $sumadias = 3;}
				if ($diasemana == 3) { $mesok .= "<td></td><td></td>"; $sumadias = 2;}
				if ($diasemana == 2) { $mesok .= "<td></td>"; $sumadias = 1;}
				if ($diasemana == 1) { $mesok .= ""; $sumadias = 0;}
				$semanax = 1;
			}
			######### COLOR DEL FONDO DEL CALENDARIO
			$date = getdate();
			if ($date["mday"] < 10) { $z = "0".$date["mday"]; }	else {$z = $date["mday"]; }
			if ($date["mon"] < 10) { $y = "0".$date["mon"]; } else {$y = $date["mon"]; }
			$hoy = $date["year"]."-".$y."-".$z;
			$sqla = "select count(*) as total from agm_incidencias where fecha='".$fecha."' and id_usuario=".$usuario;
			$resulta = mysql_query(convertSQL($sqla));
			$rowa = mysql_fetch_array($resulta);
			if (($fecha != $hoy) and ($rowa["total"] == 0)) { $color = 'white'; }
			if (($fecha != $hoy) and ($rowa["total"] > 1)) { $color = 'silver'; }
			if (($fecha == $hoy) and ($rowa["total"] > 0)) { $color = '#FF4848'; }
			if (($fecha == $hoy) and ($rowa["total"] == 0)) { $color = '#FFCC33'; }
			$bodercolor = "#4B53AF";
			if ($d == $dia_select) { $bodercolor = "yellow"; }
			$mesok .= "<td style=\"text-align:left;width:120px;background-color:".$color.";height:80px;border : 2px solid ".$bodercolor.";vertical-align:top\">";
			if ($d < 10) { $dformat = "0".$d; } else { $dformat = $d; }
			$mesok .= "<a href=\"index.php?op=1017&dd=".$dformat."&aa=".($year)."&mm=".($mes)."&usuario=".$usuario."\" style=\"color:black;\">".$d."</a>";
				if ($d < 10) {$dia = "0".$d;} else {$dia = $d;}
				for ($i = 0; $i < strlen($users) ; $i++){
					while ($users[$i] != ","){
						$id_agenda = $id_agenda.$users[$i];
						$i++;
					}
					if ($id_agenda > 0){
						$sqlu = "select * from sgm_agendas_users where id_agenda=".$id_agenda." and id_user=".$_GET["usuario"];
					} else {
						$sqlu = "select * from sgm_agendas_users where propietario=1 and id_user=".$_GET["usuario"];
					}
					$resultu = mysql_query(convertSQL($sqlu));
					$rowu = mysql_fetch_array($resultu);

					$sql = "select * from sgm_tareas where data_registro>'".$a."-".$m."-".$dia." ".$horainici."' and data_registro< '".$a."-".$m."-".$dia." ".$horafin."' and visible=1";
					$sql .= " and id_agenda=".$rowu["id_agenda"]."";
					if ($rowu["propietario"] == 0) {$sql .=	" and privada=1";}
					$sql .=" order by data_registro";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)){
						if ($row["id_agenda"] )
							$hora = date("H", strtotime($row["data_registro"])); 
							$minut = date("i", strtotime($row["data_registro"]));

							$estado_color = "White";
							if ($row["id_estado"] > 0) {
								$sqle = "select * from sgm_tareas_estados where id=".$row["id_estado"];
								$resulte = mysql_query(convertSQL($sqle));
								$rowe = mysql_fetch_array($resulte);
								$estado_color = $rowe["color"];
								$estado_color_letras = "Black";
							} else {
								if ($row["id_estado"] == -1) { 
									$estado_color = "Red";
									$estado_color_letras = "White";
								}
								if ($row["id_estado"] == -2) {
									$estado_color = "White";
									$estado_color_letras = "Black";
								}
							}


							$mesok .= "<table cellspacing=\"0\" cellspacing=\"0\" style=\"border:1px solid black;width:100%;background-color : ".$estado_color.";color:".$estado_color_letras."\">";
							$mesok .= "<tr><td><a href=\"index.php?op=1017&sop=20&id=".$row["id"]."\" style=\"color:".$estado_color_letras."\">".$hora.":".$minut." (".$row["tiempo"]." min.)</a></td></tr>";
								$sqlusuario = "select * from sgm_agendas where id=".$row["id_agenda"];
								$resultusuario = mysql_query(convertSQL($sqlusuario));
								$rowusuario = mysql_fetch_array($resultusuario);
								$mesok .= "<tr><td style=\"color:".$estado_color_letras."\"><strong>".$rowusuario["nombre"]."</strong></td></tr>";
							$mesok .= "<tr><td style=\"color:".$estado_color_letras."\"><strong>".$row["asunto"]."</strong></td></tr>";
							$mesok .= "</table>";
					}
					$id_agenda = "";
				}

			$mesok .= "</td>";
			$d++;
			$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a));
			$mes = date("m", mktime(0,0,0,$m ,$d, $a));
			$semanaanterior = $semana;
			$mesanterior = $mes;
		}
		$mesok .= "</tr></table>";
		$mesok .= "</td></tr></table></center>";
	return $mesok;
}

function busca_tareas($id,$x)
{ 
	global $db;
			$sql = "select * from sgm_tareas where visible=1 and id_origen=".$id;
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=22&id_tarea=".$row["id"]."&id=".$id."\"><img src=\"mgestion/pics/icons-mini/link_break.png\" alt=\"Desvincular\" border=\"0\"></a></td>";
					echo "<td style=\"width:100px;padding-left: ".$x."px;\"><a href=\"index.php?op=1017&sop=20&id=".$row["id"]."\">&raquo; Ver Tarea nº ".$row["id"]."</a></td>";
				echo "</tr>";
				busca_tareas($row["id"],($x+10));
			}
}

function RestarHoras($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$ini=((($horai*60)*60)+($mini*60)/*+$segi*/);
	$fin=((($horaf*60)*60)+($minf*60)/*+$segf*/);
	$dif=$fin-$ini;
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	//$difs=$dif-($difm*60)-($difh*3600);
	$time = date("H:i",mktime($difh,$difm));
	list($hora,$minut) = explode(":", $time);
	$minuts = ($hora * 60) + $minut;
	return $minuts;
}

?>

