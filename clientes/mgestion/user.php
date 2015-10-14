<?php

if ($option == 200) {
$simclau = "Solucions00";
	if ($user == false) {
		echo $UseNoAutorizado;
	} else {

	$sqluserclient = "select count(*) as total from sgm_users_clients WHERE id_user=".$userid;
	$resultuserclient = mysql_query(convert_sql($sqluserclient));
	$rowuserclient = mysql_fetch_array($resultuserclient);
	$nclientes = $rowuserclient["total"];

	$sqluserclient = "select * from sgm_users_clients WHERE id_user=".$userid;
	$resultuserclient = mysql_query(convert_sql($sqluserclient));
	while ($rowuserclient = mysql_fetch_array($resultuserclient)){
		$id_cliente .= $rowuserclient["id_client"].",";
		if ($rowuserclient["id_agrupacio"] == 0){$admin = $rowuserclient["admin"];}
	}
	$id_cliente = rtrim($id_cliente, ",");

	$sqlt = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='1002'";
	$resultt = mysql_query(convert_sql($sqlt));
	$rowt = mysql_fetch_array($resultt);
	if ($rowt) { $gusuarios = 1;}
	$sqlf = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='1003'";
	$resultf = mysql_query(convert_sql($sqlf));
	$rowf = mysql_fetch_array($resultf);
	if ($rowf) { $gfacturacion = 1;}

	$sqlc = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='1011'";
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc) { $gcontratos = 1;}

	$sqli = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='1018'";
	$resulti = mysql_query(convert_sql($sqli));
	$rowi = mysql_fetch_array($resulti);
	if ($rowi) { $gincidencias = 1;}

	$sqla = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='1024'";
	$resulta = mysql_query(convert_sql($sqla));
	$rowa = mysql_fetch_array($resulta);
	if ($rowa) { $gaplicaciones = 1;}

	$sqles = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='2001'";
	$resultes = mysql_query(convert_sql($sqles));
	$rowes = mysql_fetch_array($resultes);
	if ($rowes) { $gservidor = 1;}

	$sqlr = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='2002'";
	$resultr = mysql_query(convert_sql($sqlr));
	$rowr = mysql_fetch_array($resultr);
	if ($rowr) { $greports = 1;}

	$sqld = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='2003'";
	$resultd = mysql_query(convert_sql($sqld));
	$rowd = mysql_fetch_array($resultd);
	if ($rowd) { $gdocumentos = 1;}

	$sqlct = "select * from sgm_users_permisos where id_user=".$userid." and id_modulo='1024'";
	$resultct = mysql_query(convert_sql($sqlct));
	$rowct = mysql_fetch_array($resultct);
	if ($rowct) { $gcontrasenyes = 1;}

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;width:100%\" cellpadding=\"2\" cellspacing=\"2\" class=\"gris\"><tr><td>";

	if ($soption == 0) {
		echo "<center>";
		echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:1200px;\">";
		$sqlnew = "select * from sgm_news_posts WHERE id_grupo in (select id from sgm_news_grupos WHERE name like '%cliente%') order by fecha desc";
		$resultnew = mysql_query(convert_sql($sqlnew));
		$rownew = mysql_fetch_array($resultnew);
		if ($rownew){
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td>";
					echo "<table style=\"background-color: #E5E5E5;width:800px;\">";
						echo "<tr><td>".$rownew["asunto"]."</td></tr>";
						echo "<tr><td>".$rownew["cuerpo"]."</td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table style=\"width:300px;\">";
							$sqlc = "select id,descripcion from sgm_contratos where id_cliente in (".$id_cliente.") and visible=1 and activo=1";
							$resultc = mysql_query($sqlc,$dbhandle);
							while ($rowc = mysql_fetch_array($resultc)){
								echo "<tr><td>".$Contrato." : ".$rowc["descripcion"]."</td></tr>";
									$sqlcs = "select * from sgm_contratos_servicio where visible=1 and extranet=1 and id_contrato=".$rowc["id"]."";
									$resultcs = mysql_query($sqlcs,$dbhandle);
									while ($rowcs = mysql_fetch_array($resultcs)){
										$sqli = "select count(*) as total from sgm_incidencias where id_servicio=".$rowcs["id"]." and fecha_registro_cierre<>0 and visible=1";
										$resulti = mysql_query($sqli,$dbhandle);
										$rowi = mysql_fetch_array($resulti);
										$sqli2 = "select count(*) as total2 from sgm_incidencias where id_servicio=".$rowcs["id"]." and fecha_registro_cierre<>0 and sla=0 and visible=1";
										$resulti2 = mysql_query($sqli2,$dbhandle);
										$rowi2 = mysql_fetch_array($resulti2);
										$percent = $rowi2["total2"]*100/$rowi["total"];
	#									$percent = buscar_percent($rowcs["id"]);
										if ($percent < $rowcs["sla"]) { $color = "red"; $colorl = "white";} else { $color = "Yellowgreen"; $colorl = "black"; }
										if ($percent == ""){ $percent = 0;  $color = "#E5E5E5"; $colorl = "black"; } else { $percent = number_format ( $percent,2,".",","); }
										echo "<tr><td style=\"background-color:".$color.";text-align:left;color:".$colorl.";\">".$percent."%&nbsp;".$rowcs["servicio"]." (".$rowi2["total2"]."/".$rowi["total"].")</td></tr>";
									}
								echo "<tr><td>&nbsp;</td></tr>";
							}
					echo "</table>";
				echo "</td>";
				echo "<td style=\"width:10px;\">&nbsp;</td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table style=\"width:800px;\">";
	#					echo "<tr>";
	#						echo "<td>";
	#							echo "<table><tr>";
	#								$mes = date("n");
	#								$dia = date("j");
	#								$sqlc = "select * from sgm_calendario where mes>=".$mes." and dia>=".$dia."";
	#								$resultc = mysql_query($sqlc,$dbhandle);
	#								$rowc = mysql_fetch_array($resultc);
	#								echo "<br>Le recordamos que el pr&oacute;ximo ".fechalarga(date("Y")."-".$rowc["mes"]."-".$rowc["dia"])." es festivo.</td>";
	#								echo "<td style=\"width:50px;\">&nbsp;</td>";
	#								echo "<td style=\"width:200px;\"></td>";
	#							echo "</tr></table>";
	#						echo "</td>";
	#					echo "</tr>";
						echo servidoresMonitorizados($id_cliente,3,91);

					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}

	if ((($soption == 10) and ($gcontratos != 1)) or (($soption == 80) and ($gcontratos != 1))) {echo $UseNoAutorizado;}
	if ((($soption == 10) and ($gcontratos == 1)) or (($soption == 80) and ($gcontratos == 1))) {
		if ($soption == 10) { echo "<strong>".$Contratos." : </strong>"; }
		if ($soption == 80) { echo "<strong>".$Proyectos." : </strong>"; }
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
			if ($_GET["hist"] == 0) {echo "<a href=\"index.php?op=200&sop=".$_GET["sop"]."&hist=1\" style=\"color:white;\">".$Historico."</a>";}
			if ($_GET["hist"] == 1) {echo "<a href=\"index.php?op=200&sop=".$_GET["sop"]."&hist=0\" style=\"color:white;\">".$Volver."</a>";}
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:800px;\">";
			echo "<form action=\"index.php?op=1011&sop=100&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:left;\">".$Cliente." ".$Final."</td>";
				echo "<td style=\"text-align:left;\">".$Descripcion."</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			if ($soption == 10) { $sqlcc = "select * from sgm_contratos where visible=1 and id_cliente in (".$id_cliente.") and id_contrato_tipo in (select id from sgm_contratos_tipos where nombre not like '%proyecto%')"; }
			if ($soption == 80) { $sqlcc = "select * from sgm_contratos where visible=1 and id_cliente in (".$id_cliente.") and id_contrato_tipo in (select id from sgm_contratos_tipos where nombre like '%proyecto%')"; }
			if ($_GET["hist"] == 0) { $sqlcc .= " and activo=1";}
			$resultcc = mysql_query(convert_sql($sqlcc));
			while ($rowcc = mysql_fetch_array($resultcc)){
				if ($rowcc["activo"] == 1) { $color = "Yellowgreen"; $colorl = "black"; } else { $color = "red"; $colorl = "white"; }
				echo "<tr style=\"background-color:".$color.";\">";
					$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<td style=\"color:".$colorl.";\">".$row["nombre"]."</a></td>";
					echo "<td style=\"color:".$colorl.";\">".$rowcc["descripcion"]."</td>";
					if ($soption == 10) {
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=11&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\"><img src=\"images/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=12&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\"><img src=\"images/icons-mini/page_white_put.png\" alt=\"Ver\" border=\"0\"></a></td>";
					}
					if ($soption == 80) {
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=81&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\"><img src=\"images/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=82&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\"><img src=\"images/icons-mini/page_white_put.png\" alt=\"Ver\" border=\"0\"></a></td>";
					}
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
		echo "<br>";
	}

	if ((($soption == 11) and ($gcontratos != 1)) or (($soption == 81) and ($gcontratos != 1))) {echo $UseNoAutorizado;}
	if ((($soption == 11) and ($gcontratos == 1)) or (($soption == 81) and ($gcontratos == 1))) {
		if ($soption == 11) { echo "<strong>".$Contrato." : </strong>"; }
		if ($soption == 81) { echo "<strong>".$Proyecto." : </strong>"; }
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:60px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=10&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<table cellspacing=\"0\" cellpadding=\"0\"  style=\"width:1100px;\"><tr><td style=\"vertical-align:top\">";
			$sqlc = "select * from sgm_contratos where visible=1 and id=".$_GET["id_con"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$numeroc = $rowc["num_contrato"];
			if ($rowc["activo"] == 1) { $color = "Yellowgreen"; $colorl = "black"; } else { $color = "red"; $colorl = "white"; }
			echo "<table cellspacing=\"0\" style=\"width:400px;background-color:".$color.";\">";
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Numero."</strong> :</td><td style=\"color:".$colorl.";\">".$numeroc."</td></tr>";
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Contrato."</strong> :</td>";
					$sql = "select * from sgm_contratos_tipos where visible=1 and id=".$rowc["id_contrato_tipo"];
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<td style=\"color:".$colorl.";\">".$row["nombre"]."</td>";
				echo "</tr>";
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Cliente."</strong> :</td>";
					$sqla = "select * from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
					$resulta = mysql_query(convert_sql($sqla));
					$rowa = mysql_fetch_array($resulta);
					echo "<td style=\"color:".$colorl.";\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</td>";
				echo "</tr>";
				if($rowc["id_cliente"] != $rowc["id_cliente_final"]) {	
					$sqlb = "select * from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"];
					$resultb = mysql_query(convert_sql($sqlb));
					$rowb = mysql_fetch_array($resultb);
					echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Cliente." ".$Final."</strong> :</td>";
					echo "<td style=\"color:".$colorl.";\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</td></tr>";
				}
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Descripcion."</strong> :</td><td style=\"color:".$colorl.";\">".$rowc["descripcion"]."</td></tr>";
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Fecha." ".$Inicio."</strong> :</td><td style=\"color:".$colorl.";\">".$rowc["fecha_ini"]."</td></tr>";
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Fecha." ".$Fin."</strong> :</td><td style=\"color:".$colorl.";\">".$rowc["fecha_fin"]."</td></tr>";
				echo "<tr><td style=\"text-align:right;color:".$colorl.";\"><strong>".$Estado."</strong> :</td><td style=\"color:".$colorl.";\">";				
				if ($rowc["activo"] == 1) {
					echo $Activo;
				} else {
					echo $Inactivo;
				}
				echo "</td></tr>";
			echo "</table>";
		echo "</td><td><table style=\"width:100px;\"><tr><td>&nbsp;</td></tr></table></td><td style=\"vertical-align:top\">";
			echo "<table cellspacing=\"0\" style=\"width:600px;\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td style=\"text-align:left;\">".$Servicio."</td>";
					echo "<td style=\"text-align:left;\">".$Periodo." ".$Cobertura."&#185;</td>";
					echo "<td style=\"text-align:left;\">".$Tiempo." ".$Respuesta."&#178;</td>";
					echo "<td style=\"text-align:left;\">".$SLA."</td>";
					echo "<td></td>";
				echo "</tr>";
				$i = 0;
				$sql = "select * from sgm_contratos_servicio where visible=1 and extranet=1 and id_contrato=".$_GET["id_con"];
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					if ($i == 0) { $bgcolor = "white"; $i=1;} elseif ($i == 1) { $bgcolor = "#E5E5E5"; $i=0;}
					echo "<tr style=\"background-color:".$bgcolor."\">";
						echo "<td>".$row["servicio"]."</td>";
						$sqls = "select * from sgm_contratos_sla_cobertura where visible=1 and id=".$row["id_cobertura"];
						$results = mysql_query(convert_sql($sqls));
						$rows = mysql_fetch_array($results);
						echo "<td>".$rows["nombre"]."</td>";
						echo "<td>".$row["temps_resposta"]."h.";
							if ($row["nbd"] == 1){
								echo " NBD";
							}
						echo "</td>";
						if ($row["sla"] > 0){
							echo "<td>".$row["sla"]."%</td>";
						} else {
							echo "<td></td>";
						}
					echo "</tr>";
				}
			echo "</table>";
		echo "</td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td></td><td></td><td>";
			echo "<table>";
				echo "<tr><td style=\"text-align: justify;\">&#185;. ".$Explicacion_cobertura."</td></tr>";
				echo "<tr><td style=\"text-align: justify;\">&#178;. ".$Explicacion_respuesta."</td></tr>";
			echo "</table>";
		echo "</td></tr></table>";
		$sqlccc = "select * from sgm_clients_classificacio where visible=1 and predeterminado=1 and id_client=".$rowc["id_cliente"]."";
		$resultccc = mysql_query(convert_sql($sqlccc));
		$rowccc = mysql_fetch_array($resultccc);
		if ($rowccc["id_clasificacio_tipus"] == 1) {
			echo "<br><br>";
			echo "<table><tr><td>";
				resumEconomicContractes($_GET["id_con"]);
			echo "</td></tr></table>";
		}
	}

	if ((($soption == 12) and ($gcontratos != 1)) or (($soption == 82) and ($gcontratos != 1))) {echo $UseNoAutorizado;}
	if ((($soption == 12) and ($gcontratos == 1)) or (($soption == 82) and ($gcontratos == 1))) {
		if ($soption == 12) { echo "<strong>".$Contrato." : </strong>"; }
		if ($soption == 82) { echo "<strong>".$Proyecto." : </strong>"; }
		echo "<br><br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:center;width:50px\">".$Tipo."</td>";
				echo "<td style=\"text-align:center;width:200px\">".$Nombre."</td>";
				echo "<td style=\"text-align:center;width:50px\">".$Tamano."</td>";
			echo "</tr>";
			$sql = "select * from sgm_files_tipos order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and id_contrato=".$_GET["id_con"];
				$resultele = mysql_query(convert_sql($sqlele));
				while ($rowele = mysql_fetch_array($resultele)) {
					echo "<tr><td style=\"text-align:left;\">".$row["nombre"]."</td>";
					echo "<td><a href=\"https://solucions-im.com/sim/files/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
					echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
					echo "</tr>";
				}
			}
		echo "</table></center>";
	}

	if ((($soption == 13) and ($gcontratos != 1)) or (($soption == 83) and ($gcontratos != 1))) {echo $UseNoAutorizado;}
	if ((($soption == 13) and ($gcontratos == 1)) or (($soption == 83) and ($gcontratos == 1))) {
		if ($soption == 13) { echo "<strong>".$Contrato." : </strong>"; }
		if ($soption == 83) { echo "<strong>".$Proyecto." : </strong>"; }
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:60px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=11&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:center;width:600px\">".$Asunto."</td>";
				echo "<td style=\"text-align:right;width:100px\">".$Duracion."</td>";
				echo "<td style=\"text-align:right;width:100px\">".$Total." €</td>";
			echo "</tr>";
			$inicio_mes = date("U", mktime(0,0,0,$_GET["mes"], 1, $_GET["any"]));
			$final_mes = date("U", mktime(23,59,59,$_GET["mes"]+1, 1-1,$_GET["any"]));
			$sqlind = "select * from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and visible=1";
			if ($_GET["id_serv"] > 0){ $sqlind .= " and id_servicio=".$_GET["id_serv"]."";} else {$sqlind .= " and id_cliente IN (".$id_cliente.")";}
			$resultind = mysql_query(convert_sql($sqlind));
			while ($rowind = mysql_fetch_array($resultind)){
				$sqlind2 = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowind["id"]." and visible=1";
				$resultind2 = mysql_query(convert_sql($sqlind2));
				$rowind2 = mysql_fetch_array($resultind2);
				$sqls = "select * from sgm_contratos_servicio where visible=1";
				if ($_GET["id_serv"] > 0){ $sqls .= " and id=".$_GET["id_serv"]."";} else { $sqls .= " and id=".$rowind["id_servicio"]."";}
				$results = mysql_query(convert_sql($sqls));
				$rows = mysql_fetch_array($results);
				echo "<tr>";
					echo "<td style=\"text-align:left;width:600px\"><a href=\"index.php?op=".$_GET["op"]."&sop=42&id=".$rowind["id"]."\">".$rowind["asunto"]."</a></td>";
					$hora = $rowind2["total"]/60;
					$horas = explode(".",$hora);
					$minutos = $rowind2["total"] % 60;
					echo "<td style=\"text-align:right;width:100px\">".$horas[0]." h. ".$minutos." m.</td>";
					$precio_servicio = $rows["precio_hora"]*$hora;
					echo "<td style=\"text-align:right;width:100px\">".number_format ($precio_servicio,2,',','')." €</td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if (($soption == 20) and ($gusuarios != 1)) {echo $UseNoAutorizado;}
	if (($soption == 20) and ($gusuarios == 1)) {
		if ($ssoption == 1) {
			echo "<center>";
			$registro = 1;
			$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] != 0) { $mensa = 3 ; $registro = 0; }
			$sql = "select Count(*) AS total from sgm_users WHERE mail='".$_POST["mail"]."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] != 0) { $mensa = 4; $registro = 0; }
			if (comprobar_mail($_POST["mail"]) == false) { $mensa = 2 ; $registro = 0; }
			if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { $mensa = 1 ; $registro = 0; }
			if ($registro == 1 ) {
				$contrasena = crypt($_POST["pass1"]);
				$sql = "insert into sgm_users (usuario,pass,mail,id_origen, validado) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["mail"]."'";
				$sql = $sql.",'".$contrasena."'";
				$sql = $sql.",'".$_POST["mail"]."'";
				$sql = $sql.",'".$_GET["id"]."'";
				$sql = $sql.",1";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
				$sqlt = "select * from sgm_users order by id desc";
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				$sqlcl = "select * from sgm_clients where id in (".$id_cliente.") and id_agrupacio=0";
				$resultcl = mysql_query(convert_sql($sqlcl));
				$rowcl = mysql_fetch_array($resultcl);
				$sql = "insert into sgm_users_clients (id_user,id_client) ";
				$sql = $sql."values (";
				$sql = $sql."'".$rowt["id"]."'";
				$sql = $sql.",'".$rowcl["id"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
			echo "</center>";
		}
		if ($ssoption == 2) {
			$sql = "select Count(*) AS total from sgm_users WHERE id='".$_POST["id_user"]."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { $mensa = 1 ; $registro = 0; }
			if ($row["total"] > 0) {
				$contrasena = crypt($_POST["pass1"]);
				$sql = "update sgm_users set ";
				$sql = $sql."pass='".$contrasena."'";
				$sql = $sql." WHERE id=".$_POST["id_user"]."";
				mysql_query(convert_sql($sql));
				$mensa = 5;
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_users set ";
			$sql = $sql."activo=0";
			$sql = $sql." WHERE id=".$_GET["id_user"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Gestion." ".$Usuarios."</strong>";
		echo "<br><br>";
		echo "<center>";
		echo "<table><tr><td style=\"vertical-align:top\">";
			echo "<table cellspacing=\"0\" style=\"width:450px;\">";
				echo "<tr style=\"background-color: Silver;\">";
					echo "<td style=\"text-align:center;width:20px;\"><em>".$Eliminar."</em></td>";
					echo "<td style=\"text-align:center;width:220px;\">".$Usuario." / ".$Email."</td>";
					echo "<td style=\"text-align:center;width:20px;\"><em>".$Editar."</em></td>";
					echo "<td style=\"text-align:center;width:20px;\"><em>".$Permisos."</em></td>";
				echo "</tr>";
				$sql = "select * from sgm_users where activo=1 and id_origen=".$_GET["id"];
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=22&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						echo "<td style=\"color:".$color.";width:220px;\">".$row["usuario"]."</td>";
						echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=20&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
						$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$row["id"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
						if ($rowt["total"] > 0) {
							echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=23&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/application_key.png\" style=\"border:0px;\"></a></td>";
						} else {
							echo "<td style=\"text-align:center;width:20px;\"><a href=\"index.php?op=200&sop=23&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/application.png\" style=\"border:0px;\"></a></td>";
						}
						busca_usuarios($row["id"],($x+10));
					echo "</tr>";
				}
			echo "</table>";
		echo "</td>";
		echo "<td style=\"width:70px\">&nbsp;</td>";
		echo "<td style=\"vertical-align:top;\">";
		$sql = "select * from sgm_users where id=".$_GET["id_user"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($_GET["id_user"] == "") {
			echo "<strong>".$Anadir." ".$Nuevo." ".$Usuario."</strong>";
		} else {
			echo "<strong>".$Modificar." ".$Usuario." : ".$row["usuario"]."</strong>";
		}
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			echo "<tr>";
			echo "<td></td>";
			if ($_GET["id_user"] == "") {
				echo "<form action=\"index.php?op=200&sop=20&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<tr><td><strong>*".$Usuario." / ".$Mail."</strong></td><td style=\"vertical-align : middle;\"><input type=\"text\" name=\"mail\" class=\"px200\" value=\"".$row["mail"]."\">*</td></tr>";
			} else {
				echo "<form action=\"index.php?op=200&sop=20&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$_GET["id_user"]."\">";
			}
			echo "<tr><td><strong>*".$Contrasena."</strong><br>".$Maximo." 10 ".$Caracteres.".</td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass1\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr><td><strong>*".$Repetir." ".$Contrasena."</strong><br>".$Maximo." 10 ".$Caracteres.".</td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr>";
				echo "<td>";
					if ($_GET["id_user"] == "") {
						echo "<input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\">";
					}else{
						echo "<input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px\">";
					}
				echo "</td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>* ".$Campos." ".$Obligatorios."</td><tr>";
		echo "</table>";
		echo "</center>";
		if ($mensa == 1) { echo mensaje_error($PassIncorrecto.$Completa);}
		if ($mensa == 2) { echo mensaje_error($MailIncorrecto.$Completa);}
		if ($mensa == 3) { echo mensaje_error($UsuarioYaReg.$Completa);}
		if ($mensa == 4) { echo mensaje_error($MailYaReg.$Completa);}
		if ($mensa == 5) { echo mensaje_error_c("cambio de contraseña correcto", "verde");}
	echo "</td></tr></table>";
	echo "</center>";
	}

	if (($soption == 22) and ($gusuarios != 1)) {echo $UseNoAutorizado;}
	if (($soption == 22) and ($gusuarios == 1)) {
		echo "<center>";
		echo $InvalidarUsuario;
		echo "<br><br><a href=\"index.php?op=200&sop=20&ssop=3&id=".$_GET["id"]."&id_user=".$_GET["id_user"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=200&sop=20&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 23) and ($gusuarios != 1)) {echo $UseNoAutorizado;}
	if (($soption == 23) and ($gusuarios == 1)) {
		if ($ssoption == 1) {
			if ($_POST["permiso"] == 0) {
				$sql = "delete from sgm_users_permisos WHERE id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo"];
				mysql_query(convert_sql($sql));
			}
			if ($_POST["permiso"] == 1) {
				$sqlt = "select count(*) as total from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] <= 0){
					$sql = "insert into sgm_users_permisos (id_user, id_modulo) ";
					$sql = $sql."values (";
					$sql = $sql."".$_GET["id_user"]."";
					$sql = $sql.",".$_POST["id_modulo"]."";
					$sql = $sql.")";
					mysql_query(convert_sql($sql));
				}
			}
		}

		$sql = "select * from sgm_users where id=".$_GET["id_user"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>".$Permisos." ".$Usuario.": </strong> ".$row["usuario"]."<br>";
		echo "<table><tr>";
			echo "<td style=\"width:60px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=20&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		$sqlcl = "select * from sgm_clients where id in (".$id_cliente.")";
		$resultcl = mysql_query(convert_sql($sqlcl));
		$rowcl = mysql_fetch_array($resultcl);
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		$sqlc = "select * from sgm_users_clients where id_user=".$_GET["id_user"];
		$resultc = mysql_query(convert_sql($sqlc));
		while ($rowc = mysql_fetch_array($resultc)) {
			echo "<tr style=\"background-color:silver\"><td><strong>".$Modulo."</strong></td><td></td><td><strong>".$Permisos."</strong></td><td></td></tr>";
			$sql = "select * from sgm_users_permisos_modulos where visible=1 and id_modulo in ('1011','1018','1003','1002','2001','2002','2003','1024')";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlt = "select * from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$row["id_modulo"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				echo "<tr>";
					echo "<td><strong>".$row["nombre"]."</strong></td>";
					echo "<td><em>(".$row["descripcion"].")</em></td>";
					echo "<form action=\"index.php?op=200&sop=23&ssop=1&id_user=".$_GET["id_user"]."&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"id_modulo\" value=\"".$row["id_modulo"]."\">";
					echo "<td><select name=\"permiso\" style=\"width:60px\">";
					if ($rowt != ""){
						echo "<option value=\"1\" selected>SI</option>";
						echo "<option value=\"0\">NO</option>";
					} else {
							echo "<option value=\"1\">SI</option>";
							echo "<option value=\"0\" selected>NO</option>";
					}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Cambiar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		}
		echo "</table></center>";
		echo "<br><br>";
	}

	if (($soption == 30) and ($gfacturacion != 1)) {echo $UseNoAutorizado;}
	if (($soption == 30) and ($gfacturacion == 1)) {
		echo "<strong>".$Facturacion."</strong>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$fechahoy = getdate();
					$yact = $fechahoy["year"];
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				echo "<td style=\"width:200px;text-align:center;\"><a href=\"index.php?op=200&sop=30&y=".$yant."\">".$yant."</a></td>";
				echo "<td style=\"width:200px;text-align:center;\"><a href=\"index.php?op=200&sop=30&y=".$yact."\">".$yact."</a></td>";
				echo "<td style=\"width:200px;text-align:center;\"><a href=\"index.php?op=200&sop=30&y=".$ypost."\">".$ypost."</a></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><table><tr>";
					if ($_GET["m"] == "01"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-01-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=01&y=".$yact."\">Ene</a>";
					} else {
						echo "Ene";
					}
					echo "</td>";
					if ($_GET["m"] == "02"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-02-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=02&y=".$yact."\">Feb</a>";
					} else {
						echo "Feb";
					}
					echo "</td>";
					if ($_GET["m"] == "03"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-03-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=03&y=".$yact."\">Mar</a>";
					} else {
						echo "Mar";
					}
					echo "</td>";
					if ($_GET["m"] == "04"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-04-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=04&y=".$yact."\">Abr</a>";
					} else {
						echo "Abr";
					}
					echo "</td>";
				echo "</tr></table></td>";
				echo "<td><table><tr>";
					if ($_GET["m"] == "05"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-05-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=05&y=".$yact."\">May</a>";
					} else {
						echo "May";
					}
					echo "</td>";
					if ($_GET["m"] == "06"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-06-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=06&y=".$yact."\">Jun</a>";
					} else {
						echo "Jun";
					}
					echo "</td>";
					if ($_GET["m"] == "07"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-07-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=07&y=".$yact."\">Jul</a>";
					} else {
						echo "Jul";
					}
					echo "</td>";
					if ($_GET["m"] == "08"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-08-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=08&y=".$yact."\">Ago</a>";
					} else {
						echo "Ago";
					}
					echo "</td>";
				echo "</tr></table></td>";
				echo "<td><table><tr>";
					if ($_GET["m"] == "09"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-09-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=09&y=".$yact."\">Sep</a>";
					} else {
						echo "Sep";
					}
					echo "</td>";
					if ($_GET["m"] == "10"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-10-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=10&y=".$yact."\">Oct</a>";
					} else {
						echo "Oct";
					}
					echo "</td>";
					if ($_GET["m"] == "11"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-11-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=11&y=".$yact."\">Nov</a>";
					} else {
						echo "Nov";
					}
					echo "</td>";
					if ($_GET["m"] == "12"){ $color = "silver";} else {$color="white";}
					echo "<td style=\"width:50px;background-color:".$color.";text-align:center;\">";
					$sql = "select count(*) as total from sgm_cabezera where visible=1 AND tipo=1 AND id_cliente in (".$id_cliente.") AND fecha LIKE '%-12-%'";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					if ($row["total"] > 0){
						echo "<a href=\"index.php?op=200&sop=30&m=12&y=".$yact."\">Dic</a>";
					} else {
						echo "Dic";
					}
					echo "</td>";
				echo "</tr></table></td>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:600px\">";
			$sqltipos = "select * from sgm_factura_tipos where id=1 order by id";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			$rowtipos = mysql_fetch_array($resulttipos);
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"width:150px;text-align:left;\"><em>".$Numero."</em></td>";
				echo "<td style=\"width:150px;text-align:left;\"><em>".$Fecha."</em></td>";
				echo "<td style=\"width:150px;text-align:left;\"><em>".$Total."</em></td>";
				echo "<td style=\"width:150px;text-align:left;\"><em>".$Estado."</em></td>";
				echo "<td></td>";
			echo "</tr>";
			$sql = "select * from sgm_cabezera where visible=1 AND tipo=".$rowtipos["id"]." AND id_cliente in (".$id_cliente.")";
			$sql = $sql." AND fecha LIKE '".$yact."%'";
			if ($_GET["m"] != "") {
				$sql = $sql." AND fecha LIKE '%-".$_GET["m"]."-%'";
			}
			$sql = $sql." order by numero desc,fecha desc";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align : left;\">".$row["numero"]."</td>";
						$a = date("Y", strtotime($row["fecha"]));
						$m = date("m", strtotime($row["fecha"]));
						$d = date("d", strtotime($row["fecha"]));
						$date = getdate();
						if ($date["year"]."-".$date["mon"]."-".$date["mday"] < $row["fecha"]) {
							$fecha_proxima = $row["fecha"];
						} else { 
							$fecha_proxima = $row["fecha"];
							$multiplica = 0;
							$sql00 = "select * from sgm_facturas_relaciones where id_plantilla=".$row["id"]." order by fecha";
							$result00 = mysql_query(convert_sql($sql00));
							while ($row00 = mysql_fetch_array($result00)) {
								if ($fecha_proxima == $row00["fecha"]) {
									$multiplica++;
									$fecha_proxima = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*$multiplica), $a));
								}
							}
						}
					if ($rowtipos["dias"] == 0) { echo "<td style=\"text-align:left;\"><strong>".$row["fecha"]."</strong></td>"; }
						else { 
							if ($fecha_proxima > $date1) {
								$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
								if ($fecha_aviso <  $date1) { echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
								else { echo "<td style=\"text-align:left;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
							}
							else { echo "<td style=\"background-color:red;color:White;text-align:left;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
						}
					echo "<td style=\"text-align : left;\"><strong>".$row["total"]." €</strong> </td>";
					echo "<td style=\"text-align : left;\">";
					if ($rowtipos["id"] == 1) {
						if ($row["cobrada"] == 1) {
							echo "<em>".$PAGADA."</em>";
						} else {
							if ($row["domiciliada"] == 1) {
								echo "<em>".$DOMICILIADA."</em>";
							} else {
								echo "<em>".$PENDIENTE."</em>";
							}
						}
					}
					if ($rowtipos["id"] == 2) {
						if ($row["cobrada"] == 1) {
							echo "<em>".$FACTURADO."</em>";
						} else {
							echo "<em>".$PENDIENTE."</em>";
						}
					}
					echo "</td>";
					echo "<td>&nbsp;&nbsp;<a href=\"mgestion/gestion-facturas-print-pdf.php?id=".$row["id"]."&tipo=1\" target=\"_blank\" class=\"gris\"><img src=\"images/icons-mini/page_white_magnify.png\" style=\"border:0px;\"><a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
		echo "<br><br>";
	}

	if (($soption == 40) and ($gincidencias != 1)) {echo $UseNoAutorizado;}
	if (($soption == 40) and ($gincidencias == 1)) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_incidencias where visible=1 and id_usuario=".$userid." and id_servicio=".$_POST["id_servicio"]." and data_registro2=".$_POST["data_registro"]."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if (!($row)){
				$sqls = "select * from sgm_contratos_servicio where visible=1 and incidencias=1 and id=".$_POST["id_servicio"];
				$results = mysql_query(convert_sql($sqls));
				$rows = mysql_fetch_array($results);
				$sqlc = "select * from sgm_contratos where visible=1 and id=".$rows["id_contrato"]." and activo=1";
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);

				$sql = "insert into sgm_incidencias (id_usuario_origen,id_usuario_registro,id_servicio,fecha_inicio,fecha_registro_inicio,fecha_prevision,id_estado,id_entrada,notas_registro,asunto,id_cliente)";
				$sql = $sql."values (";
				$sql = $sql."".$userid."";
				$sql = $sql.",".$userid."";
				$sql = $sql.",".$_POST["id_servicio"]."";
				$sql = $sql.",".$_POST["fecha_inicio"]."";
				$data = time();
				$sql = $sql.",".$data."";
				$prevision = fecha_prevision($_POST["id_servicio"], $_POST["fecha_inicio"]);
				$sql = $sql.",".$prevision."";
				$sql = $sql.",-1";
				$sql = $sql.",".$_POST["id_entrada"]."";
				$notas_registro = str_replace(chr(13),"<br>", $_POST["notas_registro"]);
				$sql = $sql.",'".comillas($notas_registro)."'";
				$sql = $sql.",'".comillas($_POST["asunto"])."'";
				$sql = $sql.",".$rowc["id_cliente"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}

		echo "<strong>".$Incidencias."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=41\" style=\"color:white;text-decoration:none;\">".$Anadir." ".$Incidencia."</a>";
			echo "</td>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				if ($_GET["hist"] == 0) { echo "<a href=\"index.php?op=200&sop=40&hist=1\" style=\"color:white;\">".$Historico."</a>";}
				if ($_GET["hist"] == 1) { echo "<a href=\"index.php?op=200&sop=40&hist=0\" style=\"color:white;\">".$Actual."</a>";}
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>ID</td>";
				if ($_GET["hist"] == 0) {
					echo "<td>".$SLA."</td>";
				} else {
					echo "<td></td>";
				}
				if ($_GET["hist"] == 0) { echo "<td>".$Fecha." ".$Prevision."</td>"; }
				if ($_GET["hist"] == 1) { echo "<td>".$Fecha." ".$Fin."</td>"; }
				echo "<td>".$Asunto."</td>";
				echo "<td>".$Cliente." ".$Final."</td>";
				echo "<td>".$Contrato." - ".$Servicio."</td>";
				echo "<td>".$Usuario." ".$Origen."</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";

			$sqlcc = "select * from sgm_clients where id in (".$id_cliente.")";
			$resultcc = mysql_query(convert_sql($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			$sql = "select * from sgm_incidencias where visible=1 and id_cliente=".$rowcc["id"]."";
			if ($_GET["hist"] == 0) { $sql = $sql." and (id_estado <> -2) order by fecha_prevision"; }
			if ($_GET["hist"] == 1) { $sql = $sql." and id_estado = -2 order by fecha_registro_cierre desc"; }
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlc = "select * from sgm_contratos_servicio where id=".$row["id_servicio"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$sqls = "select * from sgm_contratos where activo=1 and id=".$rowc["id_contrato"];
				$results = mysql_query(convert_sql($sqls));
				$rows = mysql_fetch_array($results);
				$sqlcli = "select * from sgm_clients where visible=1 and id=".$rows["id_cliente_final"]." order by nombre";
				$resultcli = mysql_query(convert_sql($sqlcli));
				$rowcli = mysql_fetch_array($resultcli);

				$estado_color = "White";
				$estado_color_letras = "Black";
				$sqlu = "select * from sgm_users where id=".$row["id_usuario_origen"];
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
				$sqlu2 = "select * from sgm_users where id=".$row["id_usuario_destino"];
				$resultu2 = mysql_query(convert_sql($sqlu2));
				$rowu2 = mysql_fetch_array($resultu2);
				$sqld = "select sum(tiempo) as total from sgm_incidencias where id_incidencia=".$row["id"]."";
				$resultd = mysql_query(convert_sql($sqld));
				$rowd = mysql_fetch_array($resultd);
				$hora = $rowd["total"]/60;
				$horas = explode(".",$hora);
				$minutos = $rowd["total"] % 60;
				if ($rowc["temps_resposta"] != 0){
					if ($_GET["hist"] == 0) { $hora_actual = time(); }
					if ($_GET["hist"] == 1) { $hora_actual = $row["fecha_registro_cierre"]; }
						$sla2 = calculSLA($row["id"]);
						$hora = $sla2/3600;
						$horas2 = explode(".",$hora);
						$minuto = (($hora - $horas2[0])*60);
						$minutos2 = explode(".",$minuto);
						$sla = "".$horas2[0]."h. ".$minutos2[0]."m.";
					if ($_GET["hist"] == 0) {
						if ($horas2[0] > 4){
							$estado_color = "White";
							$estado_color_letras = "Black";
						}
						if (($horas2[0] <= 4) and ($total >= 0)) {
							$estado_color = "Orange";
							$estado_color_letras = "White";
						}
						if (($horas2[0] < 0) or ($minutos2[0] < 0)) {
							$estado_color = "Red";
							$estado_color_letras = "White";
						}
					}
					if ($_GET["hist"] == 0) { $fecha_prev = date("Y-m-d H:i:s", $row["fecha_prevision"]); }
					if ($_GET["hist"] == 1) { $fecha_prev = date("Y-m-d H:i:s", $row["fecha_cierre"]); }
				} else {
					$sla = "";
					$fecha_prev = "";
				}
				if ($row["pausada"] == 1){
					$fecha_prev = "";
					$estado_color = "#E5E5E5";
					$estado_color_letras = "";
				}
				echo "<tr style=\"background-color:".$estado_color.";\">";
					echo "<td style=\"color:".$estado_color_letras.";\">".$row["id"]."</a></td>";
					if ($_GET["hist"] == 0) {
						echo "<td style=\"color:".$estado_color_letras.";text-align:right;\">".$sla."</td>";
					} else {
						if ($row["sla"] == 1) {
							echo "<td style=\"text-align:center;\"><img src=\"images/icons-mini/exclamation.png\" style=\"border:0px;\"></td>";
						} else {
							echo "<td></td>";
						}
					}
					echo "<td style=\"color:".$estado_color_letras.";\">".$fecha_prev."</td>";
					if (strlen($row["nombre"]) > 50) {
						echo "<td style=\"color:".$estado_color_letras.";\">".substr($row["asunto"],0,50)." ...</td>";
					} else {
						echo "<td style=\"color:".$estado_color_letras.";\">".$row["asunto"]."</a></td>";
					}
					echo "<td style=\"color:".$estado_color_letras.";\">".$rowcli["nombre"]."</td>";
					echo "<td style=\"color:".$estado_color_letras.";\">".$rows["descripcion"]." - ".$rowc["servicio"]."</td>";
					if ($rowu["usuario_origen"] > 0){
						echo "<td style=\"color:".$estado_color_letras.";\">".$rowu["usuario"]."</td>";
					} else {
						echo "<td style=\"color:".$estado_color_letras.";\">".$rowu2["usuario"]."</td>";
					}
					if ($rowc["duracion"]==1){
						echo "<td style=\"color:".$estado_color_letras.";\">".$horas[0]."h. ".$minutos."m.</td>";
					} else { echo "<td></td>";}
					echo "<td style=\"text-align:center;\">";
						echo "<a href=\"index.php?op=200&sop=42&id=".$row["id"]."\"><img src=\"images/icons-mini/page_white_magnify.png\" style=\"border:0px;\"><a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if (($soption == 41) and ($gincidencias != 1)) {echo $UseNoAutorizado;}
	if (($soption == 41) and ($gincidencias == 1)) {
		echo "<strong>".$Nueva." ".$Incidencias."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=40\" style=\"color:white;text-decoration:none;\">".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		#inicio de la tabla de modificación o inserción.
		echo "<center><table cellspacing=\"2\" cellspacing=\"2\" style=\"width:1200px\">";
		echo "<form action=\"index.php?op=200&sop=40&ssop=1\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"text-align:right;vertical-align:top;width:400px\">";
					echo "<table cellspacing=\"0\" cellspacing=\"0\">";
						echo "<tr><td>&nbsp;</td></tr>";
						$fecha_reg = date("Y-m-d H:i:s", time ());
						echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Fecha." ".$Registro." :</td><td>".$fecha_reg."</td></tr>";
						echo "<input type=\"Hidden\" name=\"fecha_inicio\" value=\"".time ()."\">";
						$sqle = "select * from sgm_incidencias_entrada where id=4";
						$resulte = mysql_query(convert_sql($sqle));
						$rowe = mysql_fetch_array($resulte);
						echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Origen." :</td><td>".$rowe["entrada"]."</td></tr>";
						echo "<input type=\"Hidden\" name=\"id_entrada\" value=\"".$rowe["id"]."\">";
						$sqlu = "select * from sgm_users where validado=1 and activo=1 and id=".$userid;
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
						echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Usuario." ".$Origen." :</td><td>".$rowu["usuario"]."</td></tr>";
						echo "<input type=\"Hidden\" name=\"id_usuario_origen\" value=\"".$rowu["id"]."\">";
#							$sqld = "select sum(tiempo) as total from sgm_incidencias_notas_desarrollo where id_incidencia=".$_GET["id"]."";
#							$resultd = mysql_query(convert_sql($sqld));
#							$rowd = mysql_fetch_array($resultd);
#							$hora = $rowd["total"]/60;
#							$horas = explode(".",$hora);
#							$minutos = $rowd["total"] % 60;
#							echo "<tr><td style=\"text-align:right;vertical-align:top;\" ".$dis.">".$Tiempo." :</td><td>".$horas[0]." ".$Horas." ".$minutos." ".$Minutos."</td></tr>";
					echo "</table>";
				echo "</td><td style=\"text-align:right;vertical-align:top;\">";
					echo "<table cellspacing=\"0\" cellspacing=\"0\">";
						echo "<tr><td style=\"text-align:left;vertical-align:top;\">".$Servicio." :</td></tr>";
						echo "<tr><td><select name=\"id_servicio\" style=\"width:600px\">";
							$sqlc = "select * from sgm_contratos where visible=1 and id_cliente in (".$id_cliente.") and activo=1 order by num_contrato";
							$resultc = mysql_query(convert_sql($sqlc));
							while ($rowc = mysql_fetch_array($resultc)) {
								$sqlcli = "select * from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"]." order by nombre";
								$resultcli = mysql_query(convert_sql($sqlcli));
								$rowcli = mysql_fetch_array($resultcli);
								$sqls = "select * from sgm_contratos_servicio where visible=1 and incidencias=1 and id_contrato=".$rowc["id"];
								$results = mysql_query(convert_sql($sqls));
								while ($rows = mysql_fetch_array($results)){
									if ($row["id_servicio"] == $rows["id"]){
										echo "<option value=\"".$rows["id"]."\" selected>".$rowcli["nombre"]." - ".$rowc["descripcion"]." - ".$rows["servicio"]."</option>";
									} else {
										echo "<option value=\"".$rows["id"]."\">".$rowcli["nombre"]." - ".$rowc["descripcion"]." - ".$rows["servicio"]."</option>";
									}
								}
							}
						echo "</select></td></tr>";
					echo "<tr><td style=\"text-align:left;vertical-align:top;\">".$Asunto." :</td></tr>";
					echo "<tr><td><input type=\"text\" name=\"asunto\" style=\"width:600px\" value=\"".$row["asunto"]."\" ".$dis."></td></tr>";
					echo "<tr><td style=\"text-align:left;vertical-align:top;\">".$Notas." ".$Registro." :</td></tr>";
					echo "<tr><td><textarea name=\"notas_registro\" style=\"width:600px;\" rows=\"4\" ".$dis.">".$row["notas_registro"]."</textarea></td></tr>";
					echo "<tr><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:150px\"></td></tr>";
					echo "</table>";
				echo "</form>";
			echo "</td></tr>";
		echo "</td>";
		echo "</tr>";
		echo "</table></center>";
	}

	if (($soption == 42) and ($gincidencias != 1)) {echo $UseNoAutorizado;}
	if (($soption == 42) and ($gincidencias == 1)) {
		if ($ssoption == 3) {
			if ($_POST["notas_desarrollo"] != ""){
				$sql = "insert into sgm_incidencias (id_incidencia, id_usuario_origen, id_usuario_registro, fecha_inicio, fecha_registro_inicio, notas_desarrollo, visible_cliente) ";
				$sql = $sql."values (";
				$sql = $sql.$_GET["id"];
				$sql = $sql.",".$userid;
				$sql = $sql.",".$userid;
				$registro = time();
				$sql = $sql.",".$registro."";
#				$data = (date("Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"))));
				$data = time();
				$sql = $sql.",".$data."";
				$notas_desarrollo = str_replace(chr(13),"<br>", $_POST["notas_desarrollo"]);
				$sql = $sql.",'".comillas($notas_desarrollo)."'";
				$sql = $sql.",1";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				mensaje_error($NotasDes);
			}
			$sql = "update sgm_incidencias set ";
			$sql = $sql."pausada=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Incidencia."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=40\" style=\"color:white;text-decoration:none;\">".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		#inicio de la tabla de modificación o inserción.
		echo "<center><table cellspacing=\"2\" cellspacing=\"2\" style=\"width:1200px\">";
		$sql = "select * from sgm_incidencias where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$fecha_reg = date("Y-m-d H:i:s", $row["fecha_inicio"]);

#		if ($row["id_estado"] == -2){$dis = "disabled";} else {$dis = "";}

		echo "<tr>";
			echo "<td style=\"text-align:right;vertical-align:top;width:300px\">";
				echo "<table cellspacing=\"0\" cellspacing=\"0\">";
					echo "<tr>";
						echo "<td style=\"text-align:right;vertical-align:top;\">".$Fecha." ".$Registro." :</td>";
						echo "<td>".$fecha_reg."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"text-align:right;vertical-align:top;\">".$Forma." ".$Registro." :</td>";
						$sqle = "select * from sgm_incidencias_entrada where id=4";
						$resulte = mysql_query(convert_sql($sqle));
						$rowe = mysql_fetch_array($resulte);
						echo "<td>".$rowe["entrada"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"text-align:right;vertical-align:top;\">".$Usuario." ".$Origen." :</td>";
						$sqlu = "select * from sgm_users where validado=1 and activo=1 and id=".$row["id_usuario_origen"];
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
						echo "<td>".$rowu["usuario"]."</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td><td style=\"text-align:right;vertical-align:top;\">";
				echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:850px;\">";
					$sqls = "select * from sgm_contratos_servicio where id=".$row["id_servicio"];
					$results = mysql_query(convert_sql($sqls));
					$rows = mysql_fetch_array($results);
					$sqlcli = "select * from sgm_clients where visible=1 and id in (".$id_cliente.")";
					$resultcli = mysql_query(convert_sql($sqlcli));
					$rowcli = mysql_fetch_array($resultcli);
					$sqlc = "select * from sgm_contratos where id=".$rows["id_contrato"];
					$resultc = mysql_query(convert_sql($sqlc));
					$rowc = mysql_fetch_array($resultc);
					echo "<tr><td style=\"text-align:right;vertical-align:top;width:150px;\">".$Cliente." ".$Final." :</td><td>".$rowcli["nombre"]."</td></tr>";
					echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Contrato." :</td><td>".$rowc["descripcion"]."</td></tr>";
					echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Servicio." :</td><td>".$rows["servicio"]."</td></tr>";
					echo "<tr><td>&nbsp;</td></tr>";
					echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Asunto." :</td><td><strong>".$row["asunto"]."</strong></td></tr>";
					echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Notas." ".$Registro." :</td><td style=\"text-align:justify;\">".$row["notas_registro"]."</td></tr>";
					echo "<tr><td>&nbsp;</td></tr>";
					$sqlc = "select * from sgm_incidencias where id_incidencia=".$_GET["id"]." and visible_cliente=1 order by fecha_inicio";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						$fecha = date("Y-m-d H:i:s", $rowc["fecha_inicio"]);
						$sqlu = "select * from sgm_users where id=".$rowc["id_usuario_registro"];
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
						if ($rowu["sgm"] == 0) {
							$colortr = "white";
							echo "<tr style=\"background-color:".$colortr."\"><td style=\"text-align:right;vertical-align:top;\">".$Anotacion." ".$Cliente." :</td><td>".$rowu["usuario"]."&nbsp;".$fecha."</td></tr>";
						} else {
							$colortr = "#E5E5E5";
							echo "<tr style=\"background-color:".$colortr."\"><td style=\"text-align:right;vertical-align:top;\">".$Anotacion." ".$Tecnico." :</td><td>".$rowu["usuario"]."&nbsp;".$fecha."</td></tr>";
						}
						echo "<tr style=\"background-color:".$colortr."\"><td style=\"text-align:right;vertical-align:top;\"></td><td style=\"text-align:justify;\">".$rowc["notas_desarrollo"]."</td></tr>";
						echo "<tr style=\"background-color:".$colortr."\"><td>&nbsp;</td><td>&nbsp;</td></tr>";
					}
					if ($row["notas_conclusion"] == ""){
						echo "<form action=\"index.php?op=200&sop=42&ssop=3&id=".$row["id"]."\" method=\"post\">";
						echo "<tr><td>&nbsp;</td></tr>";
						$hoy = date("Y-m-d H:i:s", time ());
						echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Fecha." ".$Registro." :</td><td>".$hoy."</td></tr>";
						echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Notas." ".$Desarrollo." :</td>";
						echo "<td><textarea name=\"notas_desarrollo\" style=\"width:700px;\" rows=\"4\"></textarea></td></tr>";
			#			if ($row["id_estado"] != -2){
							echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:150px\"></td></tr>";
			#			}
						echo "</form>";
					} else {
						$sqlu = "select * from sgm_users where id=".$row["id_usuario_finalizacion"];
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
						if ($row["fecha_registro_cierre"]){
							$fecha = date("Y-m-d H:i:s", $row["fecha_cierre"]);
						} else {
							$fecha = date("Y-m-d H:i:s", time());
						}
						echo "<tr><td style=\"text-align:right;vertical-align:top;\">".$Notas." ".$Conclusion." :</td><td>".$rowu["usuario"]."&nbsp;".$fecha."</td></tr>";
						echo "<tr><td style=\"text-align:right;vertical-align:top;\"></td><td style=\"text-align:justify;\">".$row["notas_conclusion"]."</td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
					}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</td>";
		echo "</tr>";
		echo "</table></center>";
	}

	if (($soption == 50) and ($admin != 1)) {echo $UseNoAutorizado;}
	if (($soption == 50) and ($admin == 1)) {
		$sqlclient = "select * from sgm_clients WHERE id in (".$id_cliente.")";
		$resultclient = mysql_query(convert_sql($sqlclient));
		$rowclient = mysql_fetch_array($resultclient);
		echo "<center>";
		echo "<table>";
		echo "<tr><td></td><td><strong>".$Datos_Fiscales."</strong></td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Nombre." :</td><td>".$rowclient["nombre"]." ".$rowclient["cognom1"]." ".$rowclient["cognom2"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$NIF." :</td><td>".$rowclient["nif"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Direccion." :</td><td>".$rowclient["direccion"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Poblacion." :</td><td>".$rowclient["poblacion"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Codigo." ".$Postal." :</td><td>".$rowclient["cp"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Provincia." :</td><td>".$rowclient["provincia"]."</td></tr>";
		echo "<tr><td></td><td><strong>".$Datos_Bancarios."</strong></td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Cuenta_Bancaria." :</td><td>".$rowclient["cuentabancaria"]."</td></tr>";
		echo "<tr><td></td><td><strong>".$Datos_Adicionales."</strong></td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Email." :</td><td>".$rowclient["mail"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Web." :</td><td>".$rowclient["web"]."</td></tr>";
		echo "<tr><td style=\"text-align:right;\">".$Telefono." :</td><td>".$rowclient["telefono"]."</td></tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td></td><td>".$cambiarDatos."<a href=\"mailto:administracion@solucions-im.com\">administracion@solucions-im.com</a></td></tr>";
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 60) and ($gcontrasenyes != 1)) {echo $UseNoAutorizado;}
	if (($soption == 60) and ($gcontrasenyes == 1)) {
		echo "<strong>".$Contrasenas." : </strong><br><br>";
		echo "<br><br>";
		echo "<form action=\"index.php?op=1024&sop=0\" method=\"post\">";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			$sqlc = "select * from sgm_contratos where activo=1 and id_cliente in (".$id_cliente.")";
			$resultc = mysql_query(convert_sql($sqlc));
			while ($rowc = mysql_fetch_array($resultc)){
				echo "<tr><td colspan=\"2\">".$Contrato." : ".$rowc["descripcion"]."</td></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<td style=\"text-align:left;\">".$Aplicacion."</td>";
					echo "<td style=\"text-align:left;\">".$Acceso."</td>";
					echo "<td style=\"text-align:left;\">".$Usuario."</td>";
					echo "<td style=\"text-align:center;\">".$Editar." ".$Contrasena."</td>";
					echo "<td style=\"text-align:center;\">".$Ver." ".$Contrasena."</td>";
					echo "<td style=\"text-align:left;\">".$Descripcion."</td>";
				echo "</tr>";
				$sqlcc = "select * from sgm_contrasenyes where visible=1 and id_contrato=".$rowc["id"]."";
				$resultcc = mysql_query(convert_sql($sqlcc));
				while ($rowcc = mysql_fetch_array($resultcc)){
					echo "<form action=\"index.php?op=1024&sop=0&ssop=2&id=".$rowcc["id"]."\" method=\"post\">";
					echo "<tr>";
						$sqlam = "select * from sgm_contrasenyes_apliciones where visible=1 and id=".$rowcc["id_aplicacion"];
						$resultam = mysql_query(convert_sql($sqlam));
						$rowam = mysql_fetch_array($resultam);
						echo "<td style=\"width:200px\">".$rowam["aplicacion"]."</td>";
						echo "<td style=\"width:200px\">".$rowcc["acceso"]."</td>";
						echo "<td style=\"width:100px\">".$rowcc["usuario"]."</td>";
						echo "<td style=\"text-align:center;width:100px;\"><a href=\"index.php?op=200&sop=61&id=".$rowcc["id"]."\"><img src=\"images/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
						echo "<td style=\"text-align:center;width:100px;\"><a href=\"index.php?op=200&sop=62&id=".$rowcc["id"]."\"><img src=\"images/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a></td>";
						echo "</td>";
						echo "<td style=\"width:200px\">".$rowcc["descripcion"]."</td>";
					echo "</tr>";
				}
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 61) {
		if ($ssoption == 1) {
			$cadena = encrypt($_POST["passold"],$simclau);
			$sql = "select Count(*) AS total from sgm_contrasenyes WHERE id='".$_GET["id"]."' and pass='".$cadena."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { echo "<br>Valor en los campos passwords incorrecto."; $registro = 0; }
			if ($row["total"] > 0) {
				$sql = "update sgm_contrasenyes set ";
				$cadena2 = encrypt($_POST["pass1"],$simclau);
				$sql = $sql."pass='".$cadena2."'";
				$sql = $sql." WHERE id=".$_GET["id"]."";
				mysql_query(convert_sql($sql));
				$mensa = 10;
				$sql = "insert into sgm_contrasenyes_lopd (id_contrasenya,id_usuario,fecha,accion) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id"]."";
				$sql = $sql.",".$userid."";
				$sql = $sql.",".time();
				$sql = $sql.",2";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		$sqlc = "select * from sgm_contrasenyes where id=".$_GET["id"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlcl = "select * from sgm_clients where id=".$rowc["id_client"];
		$resultcl = mysql_query(convert_sql($sqlcl));
		$rowcl = mysql_fetch_array($resultcl);
		$sqlca = "select * from sgm_contrasenyes_apliciones where id=".$rowc["id_aplicacion"];
		$resultca = mysql_query(convert_sql($sqlca));
		$rowca = mysql_fetch_array($resultca);

		echo "<strong>".$Modificar." ".$Contrasena." </strong>";
		echo "<br>".$Cliente." : ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]." / ".$Aplicacion." : ".$rowca["aplicacion"]."";
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			echo "<form action=\"index.php?op=200&sop=61&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr><td><strong>".$Anterior." ".$Contrasena."</strong></td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"passold\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr><td><strong>".$Nueva." ".$Contrasena."</strong></td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass1\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr><td><strong>".$Repetir." ".$Contrasena."</strong></td><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" class=\"px100\" maxlength=\"10\">*</td></tr>";
			echo "<tr>";
				echo "<td></td><td>";
					echo "<input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px\">";
				echo "</td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>* ".$Campos." ".$Obligatorios."</td><tr>";
		echo "</table>";
		echo "</center>";
		if ($mensa == 10) { echo mensaje_error_c($CambioPassCorrecto, "green");}
	}

	if ($soption == 62) {
		?><script>function redireccionar(){
				window.location="index.php?op=200&sop=60";
			}
		setTimeout ("redireccionar()", 10000);</script><?php
		$sqlc = "select * from sgm_contrasenyes where id=".$_GET["id"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlcl = "select * from sgm_clients where id=".$rowc["id_client"];
		$resultcl = mysql_query(convert_sql($sqlcl));
		$rowcl = mysql_fetch_array($resultcl);
		$sqlca = "select * from sgm_contrasenyes_apliciones where id=".$rowc["id_aplicacion"];
		$resultca = mysql_query(convert_sql($sqlca));
		$rowca = mysql_fetch_array($resultca);

		echo "<strong>".$Ver." ".$Contrasena."</strong>";
		echo "<br>".$Cliente." : ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]." / ".$Aplicacion." : ".$rowca["aplicacion"]."";
		echo "<br><br>";
		echo "<center>";
		echo "<table>";
			$cadena = decrypt($rowc["pass"],$simclau);
			echo "<tr><td style=\"text-align:center;\"><strong>".$Contrasena." : </strong>".$cadena."</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td style=\"text-align:center;\">".$Redireccion10seg."</td></tr>";
		echo "</table>";
		echo "</center>";

		$sql = "insert into sgm_contrasenyes_lopd (id_contrasenya,id_usuario,fecha,accion) ";
		$sql = $sql."values (";
		$sql = $sql."".$_GET["id"]."";
		$sql = $sql.",".$userid."";
		$sql = $sql.",".time();
		$sql = $sql.",2";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
	}

	if ($soption == 70) {
		echo "<strong>".$Datos." ".$Usuario."</strong>";
		echo "<br><br>";
		echo "<form action=\"index.php?sop=666&ssop=1\" method=\"post\">";
		echo "<center>";
		echo "<table>";
		echo "<tr><td>".$Mail."</td><td style=\"vertical-align : middle;width:250px;\"><input type=\"Text\" name=\"mail\" style=\"width:240px;\" value=\"".$rowuser["mail"]."\"></td></tr>";
		echo "<tr><td><strong>".$Nueva." ".$Contrasena."</strong><br>".$Maximo." 10 ".$Caracteres.".</td><td style=\"vertical-align : middle;width:250px;\"><input type=\"Password\" name=\"pass1\" style=\"width:240px;\" maxlength=\"10\">*</td></tr>";
		echo "<tr><td><strong>".$Repetir." ".$Contrasena."</strong><br>".$Maximo." 10 ".$Caracteres.".</td><td style=\"vertical-align : middle;width:250px;\"><input type=\"Password\" name=\"pass2\" style=\"width:240px;\" maxlength=\"10\">*</td></tr>";
		echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$userid."\">";
		echo "<tr><td></td><td><input type=\"submit\" value=\"".$Cambiar."\" width=\"350px\"></td>";
		echo "</tr></table>";
		echo "</form>";
		echo "</center>";
	}

	if (($soption == 90) and ($gservidor != 1)) {echo $UseNoAutorizado;}
	if (($soption == 90) and ($gservidor == 1)) {
		echo "<strong>".$Estado." ".$Servidor.":</strong>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:1200px\">";
			$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
			$resultcbd = mysql_query(convert_sql($sqlcbd));
			$rowcbd = mysql_fetch_array($resultcbd);
			$ip = $rowcbd["ip"];
			$usuario = $rowcbd["usuario"];
			$pass = decrypt($rowcbd["pass"],$simclau);
#			$pass = $rowcbd["pass"];
			$base = $rowcbd["base"];

			$sqlcsa = "select * from sgm_clients_servidors_param";
			$resultcsa = mysql_query(convert_sql($sqlcsa));
			$rowcsa = mysql_fetch_array($resultcsa);
			$cpu = $rowcsa["cpu"];
			$mem = $rowcsa["mem"];
			$memswap = $rowcsa["memswap"];
			$hhdd = $rowcsa["hd"];

			echo "<tr><td>".$Ultimo." ".$Estado."</td></tr>";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:center;width:200px\">".$Servidor."</td>";
				echo "<td style=\"text-align:center;width:150px\">".$Fecha." ".$Registro."</td>";
				echo "<td style=\"text-align:center;width:150px\">".$Fecha." ".$Servidor."</td>";
				echo "<td style=\"text-align:center;width:80px\">% CPU</td>";
				echo "<td style=\"text-align:center;width:80px\">% RAM</td>";
				echo "<td style=\"text-align:center;width:80px\">% SWAP</td>";
				echo "<td style=\"text-align:center;width:100px\">HD</td>";
				echo "<td style=\"text-align:center;width:80px\">Nagios</td>";
				echo "<td style=\"text-align:center;width:80px\">HTTP</td>";
				echo "<td style=\"text-align:center;width:80px\">MYSQL</td>";
				echo "<td style=\"text-align:center;width:80px\"></td>";
				echo "<td style=\"text-align:center;width:80px\"></td>";
			echo "</tr>";

			$sqlcs = "select * from sgm_clients_servidors where id_client in (".$id_cliente.") and visible=1";
			$resultcs = mysql_query(convert_sql($sqlcs,$dbhandle));
			while ($rowcs = mysql_fetch_array($resultcs)){

				$dbhandle2 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
				$db2 = mysql_select_db($base, $dbhandle2) or die("Couldn't open database $myDB");

				$sqlna = "select * from sim_nagios where id_servidor=".$rowcs["servidor"]." order by time_register desc";
				$resultna = mysql_query(convert_sql($sqlna,$dbhandle2));
				$rowna = mysql_fetch_array($resultna);

				$diezmin = 600;
				if (($rowna["time_register"]+$diezmin) < time()){ $color_linea = "red";} else { $color_linea = "white";}

				if ($rowna["nagios"] == 0){ $nagios = "OFF"; $colorn = "red"; } elseif ($rowna["nagios"] == 1) { $nagios = "ON"; $colorn = "white"; }
				if ($rowna["httpd"] == 0){ $httpd = "OFF"; $colorh = "red"; } else { $httpd = "ON"; $colorh = "white"; }
				if ($rowna["mysqld"] == 0){ $mysqld = "OFF"; $colors = "red"; } else { $mysqld = "ON"; $colors = "white"; }
				if ($rowna["cpu"] >= $cpu){ $colorc = "red"; } else { $colorc = "white"; }
				if ($rowna["mem"] >= $mem){ $colorm = "red"; } else { $colorm = "white"; }
				if ($rowna["mem_swap"] <= $memswap){ $colorms = "red"; } else { $colorms = "white"; }
				if ($rowna["hd"] <= $hhdd){ $colorhd = "red"; } else { $colorhd = "white"; }
				$difer = $rowna["time_register"] - $rowna["time_server"];
				if (($difer < -600) or ($difer > 600)){ $colorti = "red"; } else { $colorti = "white"; }
				$fecha_reg = date("Y-m-d H:i:s", $rowna["time_register"]);
				$fecha_ser = date("Y-m-d H:i:s", $rowna["time_server"]);
				$hd = ($rowna["hd"]/1000000);
				echo "<tr style=\"background-color:".$color_linea."\">";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$color_linea.";color:".$color.";\">".$rowcs["descripcion"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorti.";color:".$color.";\">".$fecha_reg."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorti.";color:".$color.";\">".$fecha_ser."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorc.";color:".$color.";\">".$rowna["cpu"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorm.";color:".$color.";\">".$rowna["mem"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorms.";color:".$color.";\">".$rowna["mem_swap"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorhd.";color:".$color.";\">".number_format ( $hd,2,".",",")." Gb.</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorn.";color:".$color.";\">".$nagios."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorh.";color:".$color.";\">".$httpd."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colors.";color:".$color.";\">".$mysqld."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:white\">";
						echo "<a href=\"index.php?op=200&sop=91&id=".$_GET["id"]."&id_serv=".$rowcs["servidor"]."\">".$Historico."</a>";
					echo "</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:white\">";
						echo "<a href=\"index.php?op=200&sop=92&id=".$_GET["id"]."&id_serv=".$rowcs["servidor"]."\">".$Alertas."</a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 91) and ($gservidor != 1)) {echo $UseNoAutorizado;}
	if (($soption == 91) and ($gservidor == 1)) {
		echo detalleServidoresMonitorizados ($id_cliente,$_GET["id_serv"],"Grey");
		echo "<br><br>";
	}

	if (($soption == 92) and ($gservidor != 1)) {echo $UseNoAutorizado;}
	if (($soption == 92) and ($gservidor == 1)) {
		echo "<strong>".$Alertas."</strong>";
		echo "<br>";
		echo "<table><tr>";
			echo "<td style=\"width:60px;height:20px;text-align:center;vertical-align:middle;background-color:grey;border:1px solid black\">";
				echo "<a href=\"index.php?op=200&sop=90&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"10\"><tr><td style=\"vertical-align:top;\">";
			echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td style=\"text-align:left;width:150px\">".$Fecha." ".$Alerta."</td>";
					echo "<td style=\"text-align:left;width:150px\">".$Fecha." ".$Fin." ".$Alerta."</td>";
					echo "<td style=\"text-align:left;width:70px\">".$Estado."</td>";
					echo "<td style=\"text-align:left;width:80px\">".$Tiempo."</td>";
				echo "</tr>";
				$sqlcc = "select * from sgm_clients_servidors_alertes where id_cliente in (".$id_cliente.") and servidor=".$_GET["id_serv"]." order by fecha_caida desc";
				$resultcc = mysql_query(convert_sql($sqlcc));
				while ($rowcc = mysql_fetch_array($resultcc)){
					$fecha1 = date("Y-m-d H:i:s", $rowcc["fecha_caida"]);
					if ($rowcc["fecha_subida"] != ""){$fecha2 = date("Y-m-d H:i:s", $rowcc["fecha_subida"]);}
					echo "<tr>";
						echo "<td style=\"text-align:left;\">".$fecha1."</td>";
						echo "<td style=\"text-align:left;\">".$fecha2."</td>";
						if ($rowcc["caido"] == 0){ $estado = $Error; } elseif ($rowcc["caido"] == 1) { $estado = $Correcto; }
						echo "<td style=\"text-align:left;\">".$estado."</td>";
						$hora = $rowcc["tiempo"]/3600;
						$horas = explode(".",$hora);
						$minuto = (($hora - $horas[0])*60);
						$minutos = explode(".",$minuto);
						echo "<td style=\"text-align:left;\">".$horas[0]." h. ".$minutos[0]." m.</td>";
					echo "</tr>";
				}
			echo "</table>";
		echo "</td></tr><tr><td>";
				$sqlcc1 = "select sum(tiempo) as total from sgm_clients_servidors_alertes where id_cliente in (".$id_cliente.") and servidor=".$_GET["id_serv"]."";
				$resultcc1 = mysql_query(convert_sql($sqlcc1));
				$rowcc1 = mysql_fetch_array($resultcc1);

		$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
		$resultcbd = mysql_query(convert_sql($sqlcbd));
		$rowcbd = mysql_fetch_array($resultcbd);
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
#		$pass = $rowcbd["pass"];
		$pass = decrypt($rowcbd["pass"],$simclau);
		$base = $rowcbd["base"];

		$dbhandle2 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
		$db2 = mysql_select_db($base, $dbhandle2) or die("Couldn't open database $myDB");

				$sqln = "select time_register from sim_nagios order by id asc";
				$resultn = mysql_query(convert_sql($sqln,$dbhandle2));
				$rown = mysql_fetch_array($resultn);
				$tiempo_total = time() - $rown["time_register"];
						$hora = $tiempo_total/3600;
						$horas = explode(".",$hora);
						$minuto = (($hora - $horas[0])*60);
						$minutos = explode(".",$minuto);
				$tiempo_ok = ($rowcc1["total"] * 100)/ $tiempo_total;
		echo "<br><br>";
			echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr><td style=\"text-align:left;\">".$Tiempo." ".$Fuera." ".$Parametros." ".$Seguridad." : ".number_format ( $tiempo_ok,2,",",".")." %</td></tr>";
			echo "</table>";
		echo "</td></tr></table>";
		echo "</center>";
		echo "<br><br>";
	}

	if (($soption == 100) and ($greports != 1)) {echo $UseNoAutorizado;}
	if (($soption == 100) and ($greports == 1)) {
		echo "<strong>".$Reports."</strong>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"10\" style=\"width:1200px\"><tr><td style=\"vertical-align:top;\">";
			echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:600px\">";
				echo "<tr><td><strong>".$Auditoria." ".$Servicio."</strong></td></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<td style=\"text-align:center;width:450px\">".$Fecha."</td>";
					echo "<td style=\"text-align:center;width:150px\"></td>";
				echo "</tr>";
				$sqlcc = "select * from sgm_contratos where visible=1 and id_cliente in (".$id_cliente.") order by fecha_ini";
				$resultcc = mysql_query(convert_sql($sqlcc));
				while ($rowcc = mysql_fetch_array($resultcc)){
					list($ano, $mes, $dia) = explode("-", $rowcc["fecha_ini"]);
					if ($mes < 10) {$mes = substr($mes, -1);}
					$fechahoy = getdate();
					$mes2 = $fechahoy["mon"];
					$i = 0;
					for ($i=$mes;$i<$mes2;$i++){
					}
				}
			echo "</table>";
		echo "</td><td style=\"vertical-align:top;\">";
			echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:600px\">";
				echo "<tr><td><strong>".$Auditoria." ".$Plataforma."</strong></td></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<td style=\"text-align:center;width:450px\">".$Fecha."</td>";
					echo "<td style=\"text-align:center;width:150px\"></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr></table>";
		echo "</center>";
		echo "<br><br>";
	}

	if (($soption == 110) and ($gdocumentos != 1)) {echo $UseNoAutorizado;}
	if (($soption == 110) and ($gdocumentos == 1)) {
		echo "<strong>".$Documentos."</strong>";
		echo "<br><br>";
		$ftp_server="ftp.solucions-im.net";
		$ftp_user_name="solucions-im.net";
		$ftp_user_pass="Solucions69";
		// establecer una conexión básica
		$conn_id = ftp_connect($ftp_server); 
		// iniciar una sesión con nombre de usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		$sqlc = "select * from sgm_clients where id in (".$id_cliente.") and id_agrupacio=0";
		$resultc = mysql_query(convert_sql($sqlc,$dbhandle));
		$rowc = mysql_fetch_array($resultc);
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\" style=\"width:1000px\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table>";
						echo "<tr style=\"background-color:silver\"><td>".$Subir." ".$Archivo."</td></tr>";
						echo "<form action=\"index.php?op=200&sop=110\" method=\"post\" enctype=\"multipart/form-data\">";
						echo "<tr><td><input type=\"file\" name=\"archivo\"></td></tr>";
						echo "<tr><td><input type=\"submit\" value=\"".$Subir."\"></td></tr>";
						$remote_file = "./data/simdocs/".$rowc["alias"]."/uploads/".$_FILES["archivo"]["name"];
						$local_file = $_FILES["archivo"]["tmp_name"];
						ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY);
					echo "</table>";
				echo "</td><td>";
					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr style=\"background-color:silver\">";
							echo "<td style=\"text-align:center;width:300px\">".$Nombre."</td>";
							echo "<td style=\"text-align:center;width:100px\">".$Fecha."</td>";
							echo "<td style=\"text-align:center;width:100px\">".$Tamano."</td>";
						echo "</tr>";
						rawlist_dump("./data/simdocs/".$rowc["alias"]."", "", $rowc["alias"], "white");
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
		echo "<br><br>";
		// cerrar la conexión ftp 
		ftp_close($conn_id);
	}

	echo "</td></tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "</table><br>";
	}
}


function rawlist_dump($path, $path2, $cli, $color)
{
#echo $path."<br>";
	global $conn_id ;
	$ftp_rawlist = ftp_rawlist($conn_id , $path);
	foreach ($ftp_rawlist as $v) {
		$info = array();
		$vinfo = preg_split("/[\s]+/", $v, 9);
		if ($vinfo[0] !== "total") {
			$info['chmod'] = $vinfo[0];
			$info['num'] = $vinfo[1];
			$info['owner'] = $vinfo[2];
			$info['group'] = $vinfo[3];
			$info['size'] = $vinfo[4];
			$info['month'] = $vinfo[5];
			$info['day'] = $vinfo[6];
			$info['time'] = $vinfo[7];
			$info['name'] = $vinfo[8];
			$rawlist[$info['name']] = $info;
		}
	}
	$dir = array();
	$file = array();
	foreach ($rawlist as $k => $v) {
		if ($v['chmod']{0} == "d") {
			$dir[$k] = $v;
		} elseif ($v['chmod']{0} == "-") {
			$file[$k] = $v;
		}
	}
	foreach ($file as $filename => $fileinfo) {
		$tamany = $fileinfo['size']/1024;
		if($color == "red") { $colorl = "white"; } else { $colorl = "black";}
		echo "<tr style=\"background-color:".$color.";color:".$colorl."\">";
			if($color == "red") {
				echo"<td><a href=\"mgestion/descargas.php?file=".$filename."&cli=".$cli."&dir=".$path."\" class=\"docs\">".$path2."/<strong>".$filename."</strong></a></td>";
			} else {
				echo"<td><a href=\"mgestion/descargas.php?file=".$filename."&cli=".$cli."&dir=".$path."\">".$path2."/<strong>".$filename."</strong></a></td>";
			}
			echo "<td style=\"color:".$colorl."\">".$fileinfo['month'] . " " . $fileinfo['day'] . " " . $fileinfo['time'] . "</td>";
			echo "<td style=\"color:".$colorl."\">".number_format ( $tamany,2,",",".")." Kb</td>";
		echo "</tr>";
	}
	foreach ($dir as $dirname => $dirinfo) {
		if($dirname == "uploads") { $color = "red";} else { $color = "white";}
		rawlist_dump($path."/".$dirname, $path2."/".$dirname, $cli, $color);
	}
}


function buscar_percent($id_servicio)
{

	global $db;
	include ("config.php");
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

	$sqli = "select count(*) as total from sgm_incidencias where id_servicio=".$id_servicio." and data_finalizacion2<>0 and visible=1";
	$resulti = mysql_query($sqli,$dbhandle);
	$rowi = mysql_fetch_array($resulti);

	$sqli2 = "select count(*) as total2 from sgm_incidencias where id_servicio=".$id_servicio." and data_finalizacion2<>0 and sla=1 and visible=1";
	$resulti2 = mysql_query($sqli2,$dbhandle);
	$rowi2 = mysql_fetch_array($resulti2);

	$percent = $rowi2["total2"]*100/$rowi["total"];
	return $percent;
}

function busca_usuarios($id,$x)
{ 
	global $db;
	$sql = "select * from sgm_users where id_origen=".$id;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
		echo "<tr>";
				echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=200&sop=20&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<td style=\"padding-left: ".$x."px;color:".$color.";width:120;\">".$row["usuario"]."</td>";
				echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=200&sop=20&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$row["id"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] > 0) {
					echo "<td style=\"text-align:center\"><a href=\"index.php?op=200&sop=23&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/application_key.png\" style=\"border:0px;\"></a></td>";
				} else {
					echo "<td style=\"text-align:center\"><a href=\"index.php?op=200&sop=23&id=".$_GET["id"]."&id_user=".$row["id"]."\"><img src=\"images/icons-mini/application.png\" style=\"border:0px;\"></a></td>";
				}
		echo "</tr>";
		busca_usuarios($row["id"],($x+10));
	}
}

function busca_usuarios2($id)
{ 
	global $db;
	$sql = "select * from sgm_users where id_origen=".$id;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)) {
		echo "<tr>";
			echo "<td><strong>".$row["usuario"]."</strong></td>";
		echo "</tr>";
		$sqlu = "select * from sgm_users_clients where id_user=".$row["id"];
		$resultu = mysql_query(convert_sql($sqlu));
		while ($rowu = mysql_fetch_array($resultu)) {
			echo "<tr>";
				$sqlc = "select * from sgm_clients where id=".$rowu["id_client"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				if ($client != $rowu["id_client"]) {
					echo "<td>".$rowc["nombre"]."</td>";
					$sqlp = "select * from sgm_users_permisos_modulos where visible=1 and id_modulo in ('1011','1006','1003','1002')";
					$resultp = mysql_query(convert_sql($sqlp));
					while ($rowp = mysql_fetch_array($resultp)) {
						$sqlpm = "select count(*) as total from sgm_users_clients where id_modulo in ('".$rowp["id_modulo"]."','-1') and id_client=".$rowu["id_client"];
						$resultpm = mysql_query(convert_sql($sqlpm));
						$rowpm = mysql_fetch_array($resultpm);
						if ($rowpm["total"] == 1) { $color = "grey"; $colorl = "white"; } else { $color = "silver"; $colorl = "black"; }
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black;color:".$colorl."\">".$rowp["nombre"]."</td><td>&nbsp;</td>";
					}
					echo "</tr>";
					$client = $rowu["id_client"];
					echo "<tr><td></td></tr>";
				}
		}
		echo "<tr><td></td></tr>";
		echo "<tr><td></td></tr>";
		busca_usuarios2($row["id"]);
	}

}


?>
