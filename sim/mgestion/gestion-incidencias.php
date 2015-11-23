<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1018) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Incidencias."</h4>";
		echo "</td><td style=\"width:92%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($_GET["id_cli"] > 0) { $adres = "&id_cli=".$_GET["id_cli"]; } else { $adres = "";}
				if ($soption == 0) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=0".$adres."\" class=".$class.">".$Incidencias."</a></td>";
				if ($soption == 100) {$class = "menu_select";} else {$class = "menu";}
				if($_GET["id"] > 0){$variable = $Editar;} else {$variable = $Anadir;}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=100".$adres."\" class=".$class.">".$variable." ".$Incidencias."</a></td>";
				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=200".$adres."\" class=".$class.">".$Buscar." ".$Incidencias."</a></td>";
				if ($soption == 300) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=300\" class=".$class.">".$Indicadores."</a></td>";
				if ($soption == 400) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=400\" class=".$class.">".$Informes."</a></td>";
				if (($soption >= 500) and ($soption <= 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td class=menu><a href=\"index.php?op=1008&sop=210&id=0\" class=menu>".$Anadir." ".$Contacto."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

#Vista general de monitorizacion
	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 1) {
			$sqlin = "select pausada from sgm_incidencias where id_incidencia=".$_GET["id_inc_rel"]." and visible=1 order by fecha_inicio desc";
			$resultin = mysql_query(convert_sql($sqlin));
			$rowin = mysql_fetch_array($resultin);

			$sqlinc = "select notas_registro from sgm_incidencias where id=".$_GET["id"];
			$resultinc = mysql_query(convert_sql($sqlinc));
			$rowinc = mysql_fetch_array($resultinc);

			if ($rowin) {
				$pausada = $rowin["pausada"];
			} else {
				$pausada = 0;
			}
			$camposUpdate = array("id_incidencia","notas_desarrollo","pausada");
			$datosUpdate = array($_GET["id_inc_rel"],$rowinc["notas_registro"],$pausada);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

			$sqlinc2 = "select id from sgm_incidencias where id_incidencia=".$_GET["id"];
			$resultinc2 = mysql_query(convert_sql($sqlinc2));
			while($rowinc2 = mysql_fetch_array($resultinc2)){
				$camposUpdate = array("id_incidencia");
				$datosUpdate = array($_GET["id_inc_rel"]);
				updateFunction ("sgm_incidencias",$rowinc2["id"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 2) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
			mysql_query(convert_sql($sql));
			$sql = "update sgm_incidencias set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id_incidencia=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		if ($soption == 0) {
			echo "<h4>".$Incidencias."</h4>";
?>
			<script>
			function redireccionar(){
				window.location="index.php?op=1018&sop=0";
			}
			setTimeout ("redireccionar()", 180000);
			</script>
<?php
		}
#		if ($soption == 1) { echo "<h4>".$Historico."</h4>";}
		if ($soption == 200) { echo "<h4>".$Buscador."</h4>";}
		if ($soption != 200){
			echo "<table cellspacing=\"2\" cellpadding=\"0\" class=\"lista\"><tr>";
#				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
#					if ($soption == 0) { echo "<a href=\"index.php?op=1018&sop=1\" style=\"color:white;\">".$Historico."</a>";}
#					if ($soption == 1) { echo "<a href=\"index.php?op=1018&sop=0\" style=\"color:white;\">".$Actual."</a>";}
#				echo "</td>";
#				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
#					if ($_GET["pausa"] == 0) { echo "<a href=\"index.php?op=1018&pausa=1\" style=\"color:white;\">".$Ver." ".$Pausadas."</a>";}
#					if ($_GET["pausa"] == 1) { echo "<a href=\"index.php?op=1018&pausa=0\" style=\"color:white;\">".$NoVer." ".$Pausadas."</a>";}
#				echo "</td>";
					if ($_GET["id_cli"] == 0) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1018&sop=0\" class=".$class.">".$Todos."</a></td>";
					echo "<td>&nbsp;&nbsp;</td>";
					$counter = 0;
					$sqlcli = "select id,alias from sgm_clients where visible=1 and id in (select id_cliente from sgm_incidencias where visible=1 and id_estado<>-2 and id_incidencia=0) order by alias";
					$resultcli = mysql_query(convert_sql($sqlcli));
					while ($rowcli = mysql_fetch_array($resultcli)){
						if ($rowcli["id"] == $_GET["id_cli"]) {$class = "menu_select";} else {$class = "menu";}
						if ($counter == 12) {echo "</tr><tr><td colspan=\"2\"></td>";}
						echo "<td class=".$class."><a href=\"index.php?op=1018&sop=0&id_cli=".$rowcli["id"]."\" class=".$class.">".$rowcli["alias"]."</a></td>";
						$counter++;
					}
			echo "</tr></table>";
			echo "<br><br>";
		}

		if ($soption == 200){
			echo "<table cellspacing=\"1\" cellpadding=\"0\" style=\"background-color:silver;\" class=\"lista\">";
				echo "<form action=\"index.php?op=1018&sop=200&filtra=1\" method=\"post\" name=\"form1\">";
				echo "<tr>";
					echo "<th colspan=\"4\" style=\"text-align:left;vertical-align:top;\">".$Cliente."</th>";
					echo "<th colspan=\"3\" style=\"text-align:left;vertical-align:top;\">".$Servicio."</th>";
				echo "</tr><tr>";
					echo "<td colspan=\"4\"><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:500px\" onchange=\"desplegableCombinado2()\">";
						echo "<option value=\"0\">-</option>";
						$sqlcl1 = "select id,nombre from sgm_clients where visible=1 and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
						$resultcl1 = mysql_query(convert_sql($sqlcl1));
						while ($rowcl1 = mysql_fetch_array($resultcl1)){
							if ($_POST["id_cliente"] == $rowcl1["id"]){
								echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
							} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl1["id"])){
								echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowcl1["id"]."\">- ".$rowcl1["nombre"]."</option>";
							}
						}
						$sqlcl = "select id,nombre from sgm_clients where visible=1 and id not in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
						$resultcl = mysql_query(convert_sql($sqlcl));
						while ($rowcl = mysql_fetch_array($resultcl)){
							if ($_POST["id_cliente"] == $rowcl["id"]){
								echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]."</option>";
							} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl["id"])){
								echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowcl["id"]."\"> ".$rowcl["nombre"]."</option>";
							}
						}
					echo "</select></td>";
#				echo "</tr><tr>";
					echo "<td colspan=\"3\"><select name=\"id_servicio\" id=\"id_servicio\" style=\"width:500px;\">";
						echo "<option value=\"0\">-</option>";
							if ($_POST["id_cliente"] != "") {$sqlc = "select id_cliente_final,id from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_POST["id_cliente"]."";}
							elseif ($_GET["id_cli"] != "") {$sqlc = "select id_cliente_final,id from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_GET["id_cli"]."";}
							$resultc = mysql_query(convert_sql($sqlc));
							$rowc = mysql_fetch_array($resultc);
							$sqlclie = "select nombre from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"]." order by nombre";
							$resultclie = mysql_query(convert_sql($sqlclie));
							$rowclie = mysql_fetch_array($resultclie);
							$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"]." order by servicio";
							$results = mysql_query(convert_sql($sqls));
							while ($rows = mysql_fetch_array($results)){
								if ($_POST["id_servicio"] == $rows["id"]){
									echo "<option value=\"".$rows["id"]."\" selected>(".$rowclie["nombre"].")".$rows["servicio"]."</option>";
								} else {
									echo "<option value=\"".$rows["id"]."\">(".$rowclie["nombre"].")".$rows["servicio"]."</option>";
								}
							}
					echo "</select></td>";
				echo "</tr>";
#				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr>";
					echo "<th style=\"width:70px\">".$Fecha." (".$Mes.")</th>";
					echo "<th style=\"width:70px\">".$Fecha." (".$Ano.")</th>";
					echo "<th style=\"width:180px\">".$Estado."</th>";
					echo "<th style=\"width:180px\">".$Usuario."</th>";
					echo "<th style=\"width:100px\">ID</th>";
					echo "<th style=\"width:300px\">".$Texto."</th>";
					echo "<th style=\"width:100px\"></th>";
				echo "</tr><tr>";
					echo "<td><select name=\"mes\" style=\"width:70px\">";
						echo "<option value=\"0\" selected>-</option>";
						for ($j=1;$j<=12;$j++){
							if (($j == $_POST["mes"]) or ($j == $_GET["m"])){
								echo "<option value=\"".$j."\" selected>".$j."</option>";
							} else {
								echo "<option value=\"".$j."\">".$j."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select name=\"any\" style=\"width:70px\">";
						echo "<option value=\"0\" selected>-</option>";
						for ($k=2013;$k<=date("Y");$k++){
							if (($k == $_POST["any"]) or ($k == $_GET["a"])){
								echo "<option value=\"".$k."\" selected>".$k."</option>";
							} else {
								echo "<option value=\"".$k."\">".$k."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select name=\"id_estado\" style=\"width:180px\">";
							echo "<option value=\"0\" selected>Todos</option>";
						$sqle = "select id,estado from sgm_incidencias_estados where visible=1 order by estado";
						$resulte = mysql_query(convert_sql($sqle));
						while ($rowe = mysql_fetch_array($resulte)) {
								if ($rowe["id"] == $_POST["id_estado"]){
									echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["estado"]."</option>";
								} else {
									echo "<option value=\"".$rowe["id"]."\">".$rowe["estado"]."</option>";
								}
						}
					echo "</select></td>";
					echo "<td><select name=\"id_usuario\" style=\"width:180px\">";
							echo "<option value=\"0\" selected>-</option>";
						$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1";
						$resultu = mysql_query(convert_sql($sqlu));
						while ($rowu = mysql_fetch_array($resultu)) {
								if (($rowu["id"] == $_POST["id_usuario"]) or ($rowu["id"] == $_GET["u"])){
									echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
								} else {
									echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
								}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"id_incidencia\" value=\"".$_POST["id_incidencia"]."\" style=\"width:100px\"></td>";
					echo "<td><input type=\"text\" name=\"texto\" value=\"".$_POST["texto"]."\" style=\"width:300px\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Filtrar."\" style=\"width:100px\"></td>";
				echo "</tr>";
			echo "</form>";
			echo "</table>";
			echo "<br><br>";
		}

		if ((($_POST["mes"] != 0) and ($_POST["any"] == 0)) and ($soption == 200)){
			mensaje_error($ErrorBusqueda);
		}
		echo "<table cellspacing=\"0\" style=\"width:100%\" class=\"lista\">";
			$tiempo_total = 0;
			$temps_total = 0;
			$id_relacio = array();
			$sqle = "select id from sgm_incidencias where visible=1 and id_estado<>-2 and id_incidencia=0 order by id desc";
			$resulte = mysql_query(convert_sql($sqle));
			while ($rowe = mysql_fetch_array($resulte)){
				array_push($id_relacio, $rowe["id"]);
			}
#			echo var_dump($id_relacio);
		for ($i = 0; $i<=5;$i++){
			if (($soption == 0) or ($soption == 1) or (($soption == 200) and ($_GET["filtra"] == 1) and (($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0) or ($_POST["id_cliente"] != 0) or ($_POST["id_servicio"] != 0) or ($_POST["id_usuario"] != 0) or ($_POST["texto"] != "") or ($_POST["id_incidencia"] != "") or ($_POST["id_estado"] != "")))) {
				if ($i == 0) {
					echo "<tr style=\"background-color:silver;\">";
						echo "<th></th>";
						echo "<th>ID</th>";
						echo "<th>".$SLA."</th>";
						if ($soption == 0) { echo "<th><a href=\"index.php?op=1018&fil=1\">".$Fecha." ".$Prevision."</a></th>"; }
		#				if ($soption == 1) { echo "<td>".$Fecha." ".$Fin."</td>"; }
						if ($soption == 200) { echo "<th>".$Fecha."</th>"; }
						echo "<th>".$Asunto."</th>";
						echo "<th><a href=\"index.php?op=1018&fil=2\">".$Cliente."</a></th>";
		#				echo "<th>".$Servicio."</th>";
						echo "<th><a href=\"index.php?op=1018&fil=3\">".$Usuario." ".$Destino."</a></th>";
					if (($_POST["dia"] != 0) or ($_GET["d"] != 0) or ($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0)){
						echo "<th>".$Tiempo."/".$Tiempo." ".$Total."</th>";
					} else {
						echo "<th>".$Tiempo."</th>";
					}
					if ($soption == 0){
						echo "<th colspan=\"2\">".$Relacion."</th>";
					}
					echo "</tr>";
				}
				$sqli = "select id,id_usuario_destino,id_servicio,id_cliente,id_estado,fecha_registro_cierre,fecha_prevision,fecha_inicio,pausada,asunto,temps_pendent from sgm_incidencias where visible=1 and id_incidencia = 0";
			}
			if (($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0)){
				$mes = $_POST["mes"].$_GET["m"];
				$any = $_POST["any"].$_GET["a"];
				if ($_GET["d"] != 0){
					$data1 = date(U, mktime(0, 0, 0, $mes, $_GET["d"], $any));
					$data2 = date(U, mktime(0, 0, 0, $mes, $_GET["d"]+1, $any));
				} else {
					if (($_GET["m"] != 0) or ($_POST["mes"] != 0)){
						$data1 = date(U, mktime(0, 0, 0, $mes, 1, $any));
						$data2 = date(U, mktime(0, 0, 0, $mes+1,1, $any));
					} else {
						$data1 = date(U, mktime(0, 0, 0, 1, 1, $any));
						$data2 = date(U, mktime(0, 0, 0, 12, 31, $any));
					}
				}
				$sqli = $sqli." and (fecha_inicio between ".$data1." and ".$data2." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$data1." and ".$data2." and visible=1))";
			}
			if (($_GET["u"] != 0) or ($_POST["id_usuario"] != 0)) { $sqli = $sqli." and (id_usuario_destino=".$_GET["u"].$_POST["id_usuario"]." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and id_usuario_registro=".$_GET["u"].$_POST["id_usuario"]."))"; }
			if ($_POST["id_cliente"] != 0) { $sqli = $sqli." and id_cliente=".$_POST["id_cliente"].""; }
			if ($_GET["id_cli"] != 0) { $sqli = $sqli." and (id_cliente=".$_GET["id_cli"]." or id_servicio in (select id from sgm_contratos_servicio where id_contrato in (select id from sgm_contratos where id_cliente=".$_GET["id_cli"]." and visible=1) and visible=1))"; }
			if ($_POST["id_servicio"] != 0) { $sqli = $sqli." and id_servicio=".$_POST["id_servicio"].""; }
			if ($_POST["id_estado"] != 0) { $sqli = $sqli." and id_estado=".$_POST["id_estado"].""; }
			if ($_POST["texto"] != "") { $sqli = $sqli." and (notas_registro like '%".$_POST["texto"]."%' or notas_conclusion like '%".$_POST["texto"]."%' or id in (select id_incidencia from sgm_incidencias where visible=1 and id_incidencia<>0 and notas_desarrollo like '%".$_POST["texto"]."%')) ";}
			if ($_POST["id_incidencia"] != "") { $sqli = $sqli." and id=".$_POST["id_incidencia"].""; }
			if (($soption == 0) and ($_POST["id_estado"] == 0)) { $sqli = $sqli." and (id_estado <> -2)"; }
#			if ($soption == 1) { $sqli = $sqli." and id_estado = -2"; }
#			if ($_GET["pausa"] == 0) { $sqli = $sqli." and pausada=0"; }
			if ($i == 0) { $sqli = $sqli." and id_servicio = 0 and pausada=0"; }
			elseif ($i == 1) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision > 0 and pausada=0"; }
			elseif ($i == 2) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision=0 and pausada=0"; } 
			elseif ($i == 3) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision > 0 and pausada=1"; }
			elseif ($i == 4) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision=0 and pausada=1"; } 
			elseif ($i == 5) { $sqli = $sqli." and id_servicio = 0 and pausada=1"; } 
			if (($soption == 200) and ($_GET["filtra"] == 1)) {
				$sqli = $sqli." order by fecha_inicio desc,id_estado desc";
			} else {
				if ($_GET["fil"] <= 1) {
					$sqli = $sqli." order by fecha_prevision,pausada,id_cliente,id_servicio,id_usuario_destino";
				} elseif ($_GET["fil"] == 2) {
					$sqli = $sqli." order by id_cliente desc,id_servicio,pausada,fecha_prevision,id_usuario_destino";
				} elseif ($_GET["fil"] == 3) {
					$sqli = $sqli." order by id_usuario_destino,pausada,fecha_prevision,id_cliente,id_servicio";
				}
			}
#		echo $sqli."<br>";
			$resulti = mysql_query(convert_sql($sqli));
			while ($rowi = mysql_fetch_array($resulti)) {

				$estado_color = "White";
				$estado_color_letras = "Black";

				$sqlu = "select usuario from sgm_users where id=".$rowi["id_usuario_destino"];
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
				$sqlc = "select servicio,id_contrato,temps_resposta from sgm_contratos_servicio where id=".$rowi["id_servicio"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$sqls = "select id_cliente,descripcion from sgm_contratos where id=".$rowc["id_contrato"];
				$results = mysql_query(convert_sql($sqls));
				$rows = mysql_fetch_array($results);
				if ($rowi["id_cliente"] != 0){
					$cliente = $rowi["id_cliente"];
				} elseif ($rows) {
					$cliente = $rows["id_cliente"];
				} else {
					$cliente = 0;
				}
				$sqlcc = "select id,nombre from sgm_clients where id=".$cliente;
				$resultcc = mysql_query(convert_sql($sqlcc));
				$rowcc = mysql_fetch_array($resultcc);

				if ($rowcc["id"] != $id_client_inc){
					if ($rowcc["id"] == 0){$nom_cli = $SinCliente;} else {$nom_cli = $rowcc["nombre"];}
					echo "<tr style=\"background-color:#D8D8D8;\"><td colspan=\"5\"></td><td><a href=\"index.php?op=1008&sop=260&id=".$rowcc["id"]."\"><b>".$nom_cli."</b><a></td><td colspan=\"4\"></td></tr>";
					$id_client_inc = $rowcc["id"];
				}

				if ($rowi["id_servicio"] == 0){
					$estado_color = "black";
					$estado_color_letras = "white";
				}

				$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]." and visible=1";
				$resultd = mysql_query(convert_sql($sqld));
				$rowd = mysql_fetch_array($resultd);
				$hora = $rowd["total"]/60;
				$horas = explode(".",$hora);
				$minutos = $rowd["total"] % 60;
				if ($rowc["temps_resposta"] != 0){
					if ($rowi["id_estado"] != -2) { $hora_actual = time(); }
					if ($rowi["id_estado"] == -2) { $hora_actual = $rowi["fecha_registro_cierre"]; }
					$horax = $rowi["temps_pendent"]/3600;
					$horas2 = explode(".",$horax);
					$minutox = (($horax - $horas2[0])*60);
					$minutos2 = explode(".",$minutox);
					$sla = "".$horas2[0]."h. ".$minutos2[0]."m.";
					if ($horas2[0] > 4){
							$estado_color = "White";
							$estado_color_letras = "";
					}
					if (($horas2[0] < 4) and ($horas2[0] >= 0)) {
							$estado_color = "Orange";
							$estado_color_letras = "";
					}
					if (($horas2[0] < 0) or ($minutos2[0] < 0)) {
						$estado_color = "Red";
						$estado_color_letras = "White";
					}
					if ($rowi["id_estado"] == -1) { $fecha_prev = date("Y-m-d H:i:s", $rowi["fecha_prevision"]); }
					if ($rowi["id_estado"] == -2) { $fecha_prev = date("Y-m-d H:i:s", $rowi["fecha_registro_cierre"]); }
				} else {
					$sla = "";
					$fecha_prev = "";
				}
				if ($rowi["pausada"] == 1){
					$fecha_prev = "";
					$estado_color = "#E5E5E5";
					$estado_color_letras = "";
				}
				if ($soption == 200){ $fecha_prev = date("Y-m-d H:i:s", $rowi["fecha_inicio"]);}
				echo "<tr style=\"background-color:".$estado_color.";\">";
				echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1018&sop=2&id=".$rowi["id"].$adres."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowi["id"]."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\" nowrap>".$sla."</td>";
				$sqlind = "select id_usuario_registro from sgm_incidencias where id_incidencia=".$rowi["id"]." and visible=1 order by fecha_inicio desc";
				$resultind = mysql_query(convert_sql($sqlind));
				$rowind = mysql_fetch_array($resultind);
				if ($rowind){
					$sqluu = "select * from sgm_users where id=".$rowind["id_usuario_registro"];
					$resultuu = mysql_query(convert_sql($sqluu));
					$rowuu = mysql_fetch_array($resultuu);
					if (($rowi["id_usuario_destino"] != $rowind["id_usuario_registro"]) and ($rowuu["sgm"] == 0)){$novetats = '!!!';} else {$novetats = '';}
				} else {
					$novetats = '';
				}
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:150px;\" nowrap>".$fecha_prev."</td>";
					if (($rowi["id_estado"] <> -2) and ($soption == 200) and ($rowi["pausada"] != 1)){$estado_color = "#33CC33";}
					if ($rowi["asunto"] != ""){$asun = $rowi["asunto"];} else {$asun = $SinAsunto;}
					echo "<td style=\"vertical-align:top;background-color:".$estado_color.";\"><a href=\"index.php?op=1018&sop=100&id=".$rowi["id"].$adres."\" style=\"color:".$estado_color_letras.";\">".$novetats." ".$asun."<a></td>";
					echo "<td style=\"vertical-align:top;\"><a href=\"index.php?op=1011&sop=100&id=".$rowc["id_contrato"]."\" style=\"color:".$estado_color_letras.";\">".$rowc["servicio"]." (".$rows["descripcion"].")<a></td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowu["usuario"]."</td>";

				$sqldd = "select sum(duracion) as temps from sgm_incidencias where visible=1 and fecha_inicio between ".$data1." and ".$data2." and id_incidencia=".$rowi["id"]."";
				$resultdd = mysql_query(convert_sql($sqldd));
				$rowdd = mysql_fetch_array($resultdd);
				$horad = $rowdd["temps"]/60;
				$horasd = explode(".",$horad);
				$minutosd = $rowdd["temps"] % 60;
				$temps_total += $rowdd["temps"];

				if (($_POST["dia"] != 0) or ($_GET["d"] != 0) or ($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0)){
					$duration = $horasd[0]."h. ".$minutosd."m. (".$horas[0]."h. ".$minutos."m.)";
				} else {
					$duration = $horas[0]."h. ".$minutos."m.";
				}
				echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\" nowrap>".$duration."</td>";
				if ($soption == 0){
					echo "<form action=\"index.php?op=1018&sop=3&id=".$rowi["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\">";
					echo "<td><input type=\"number\" name=\"id_inc_rel\" style=\"width:80px\" min=\"1\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Relacion."\" style=\"width:80px\"></td>";
					echo "</form>";
				}
#					echo "<td style=\"text-align:center;vertical-align:top;\">";
#						echo "<a href=\"index.php?op=1018&sop=100&id=".$rowi["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px;\"><a>";
#					echo "</td>";
				echo "</tr>";
				$sqlnd = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]."";
				if (($_GET["d"] != 0) or ($_GET["m"] != 0) or ($_GET["a"] != 0)){
					$data1 = date(U, mktime(0, 0, 0, $_GET["m"], $_GET["d"], $_GET["a"]));
					$data2 = date(U, mktime(0, 0, 0, $_GET["m"], $_GET["d"]+1, $_GET["a"]));
					$sqlnd = $sqlnd." and fecha_inicio between ".$data1." and ".$data2."";
				}
				$resultnd = mysql_query(convert_sql($sqlnd));
				$rownd = mysql_fetch_array($resultnd);
				$tiempo_total += $rownd["total"];
			}
		}
		if (($soption == 200) and ($_GET["filtra"] == 1) and (($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0) or ($_POST["id_cliente"] != 0) or ($_POST["id_servicio"] != 0) or ($_POST["id_usuario"] != 0) or ($_POST["texto"] != "") or ($_POST["id_incidencia"] != "") or ($_POST["id_estado"] != ""))) {
			$horad2 = $temps_total/60;
			$horasd2 = explode(".",$horad2);
			$minutod2 = ($horad2 - $horasd2[0])*60;
			$minutosd2 = explode(".",$minutod2);

			$hora = $tiempo_total/60;
			$horas = explode(".",$hora);
			$minuto = ($hora - $horas[0])*60;
			$minutos = explode(".",$minuto);
			
			echo "<tr><td colspan=\"7\"></td><td style=\"text-align:left;\"><strong>";
			if ($temps_total > 0) {
				echo $horasd2[0]."h. ".$minutosd2[0]."m. / ";
			}
			echo "".$horas[0]." h. ".$minutos[0]." m.</strong></td><td></td></tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 2) {
		$sqlinc = "select id,id_cliente,asunto from sgm_incidencias where id=".$_GET["id"]."";
		$resultinc = mysql_query(convert_sql($sqlinc));
		$rowinc = mysql_fetch_array($resultinc);
		$sqlcc = "select nombre from sgm_clients where id=".$rowinc["id_cliente"];
		$resultcc = mysql_query(convert_sql($sqlcc));
		$rowcc = mysql_fetch_array($resultcc);
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br>".$rowinc["id"]." - ".$rowinc["asunto"]." - ".$rowcc["nombre"]."<br><br>";
		echo boton(array("op=1018&sop=0&ssop=2&id=".$_GET["id"].$adres,"op=1018&sop=0".$adres),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 3) {
		$sqlinc = "select id from sgm_incidencias where visible=1 and id_incidencia=0";
		$resultinc = mysql_query(convert_sql($sqlinc));
		while ($rowinc = mysql_fetch_array($resultinc)){
			$ids[] = $rowinc["id"];
		}
		if ((is_numeric($_POST["id_inc_rel"])) and (in_array($_POST["id_inc_rel"],$ids))){
			echo "<center>";
			echo "<br><br>¿Seguro que desea relacionar esta incidencias?<br><br>".$_GET["id"]." y ".$_POST["id_inc_rel"];
			echo "<br>La incidencia ".$_GET["id"]." se convertirá en una nota de la incidencia ".$_POST["id_inc_rel"]."<br><br>";
			echo boton(array("op=1018&sop=0&ssop=1&id=".$_GET["id"]."&id_inc_rel=".$_POST["id_inc_rel"].$adres,"op=1018&sop=0".$adres),array($Si,$No));
			echo "</center>";
		} else {
			echo boton(array("op=1018&sop=0"),array("&laquo; ".$Volver));
			mensaje_error($ErrorRelacion);
		}
	}
# fi vista general

#detall tickets#
	if ($soption == 100) {
		if ($ssoption > 0){
			$sqli = "select id,pausada,id_usuario_destino,id_usuario_finalizacion,fecha_registro_cierre,fecha_cierre,notas_conclusion,id_estado from sgm_incidencias where id=".$_GET["id"];
			$resulti = mysql_query(convert_sql($sqli));
			$rowi = mysql_fetch_array($resulti);
			$sqlc = "select temps_resposta,id from sgm_contratos_servicio where id in (select id_servicio from sgm_incidencias where id=".$_GET["id"].")";
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
		}

		if ($ssoption == 1) {
		#update incidencia#
			if (($_POST["id_servicio"] > 0) or ($_POST["id_servicio2"] > 0) or ($_POST["id_cliente"] > 0)){
				if ($_POST["asunto"] != ""){
					$registro = date(U, strtotime($_POST["fecha_inicio"]));
					if ($_POST["id_servicio"] > 0) {$servicio = $_POST["id_servicio"];} else {$servicio = $_POST["id_servicio2"];}
					if ($rowi["pausada"] == 0) {$prevision = fecha_prevision($servicio, $registro);} else {$prevision = 0;}
					if ($_POST["duracion"] == ""){ $duracion = 0; } else { $duracion = $_POST["duracion"]; }

					$camposUpdate = array("id_usuario_origen","id_usuario_destino","fecha_inicio","id_entrada","notas_registro","id_servicio","asunto","fecha_prevision","duracion","id_cliente");
					$datosUpdate = array($_POST["id_usuario_origen"],$_POST["id_usuario_destino"],$registro,$_POST["id_entrada"],$_POST["notas_registro"],$servicio,$_POST["asunto"],$prevision,$duracion,$_POST["id_cliente"]);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

					$sqlc = "select temps_resposta,id from sgm_contratos_servicio where id in (select id_servicio from sgm_incidencias where id=".$_GET["id"].")";
					$resultc = mysql_query(convert_sql($sqlc));
					$rowc = mysql_fetch_array($resultc);
					$sla_inc = calculSLA($_GET["id"],0);
					if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

					$camposUpdate = array("temps_pendent","fecha_prevision");
					$datosUpdate = array($sla_inc,$fecha_prevision);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
					$id_inc = $row["id"];
				} else {
					mensaje_error($ErrorSinAsunto);
				}
			} else {
				mensaje_error($ErrorSinServicioCliente);
			}
		}
		if (($ssoption == 2) and ($_POST["ejecutar"] == 1)) {
		#update notes desenvolupament#
			$registro = date(U, strtotime($_POST["fecha_inicio"]));
			if ($_POST["id_servicio"] > 0) {$servicio = $_POST["id_servicio"];} else {$servicio = $_POST["id_servicio2"];}
			if ($rowi["pausada"] == 0) {$prevision = fecha_prevision($servicio, $registro);} else {$prevision = 0;}
			if ($_POST["duracion"] == ""){ $duracion = 0; } else { $duracion = $_POST["duracion"]; }

			$camposUpdate = array("id_usuario_registro","id_incidencia","fecha_inicio","visible_cliente","pausada","notas_desarrollo","duracion");
			$datosUpdate = array($_POST["id_usuario_registro"],$_POST["id_incidencia"],$registro,$_POST["visible_cliente"],$_POST["pausada"],$_POST["notas_desarrollo"],$duracion);
			updateFunction ("sgm_incidencias",$_GET["id_not"],$camposUpdate,$datosUpdate);
			
			calculPausaIncidencia($_GET["id"],$_GET["id_not"],$registro);

			$sla_inc = calculSLA($_GET["id"],0);
			if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

			$camposUpdate = array("temps_pendent","fecha_prevision");
			$datosUpdate = array($sla_inc,$fecha_prevision);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
		#insert notes desenvolupament#
			if (($_POST["notas_desarrollo"] != "") and ($_POST["duracion"] != "")){
				$fecha_registro_inicio = time();
				$fecha_inicio = date(U, strtotime($_POST["fecha_inicio"]));
				$camposInsert = "id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,duracion,visible_cliente,pausada";
				$datosInsert = array($_GET["id"],$userid,$fecha_registro_inicio,$fecha_inicio,$_POST["notas_desarrollo"],$_POST["duracion"],$_POST["visible_cliente"],$_POST["pausada"]);
				insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);
			} elseif (($_POST["id_cliente"] == 0) and ($_POST["id_servicio"] == 0)) {
				mensaje_error($ErrorSinTextoDuracion);
			}
			if ($rowi["id_usuario_destino"] == 0){
				$camposUpdate = array("id_usuario_destino");
				$datosUpdate = array($userid);
				updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
			}

			calculPausaIncidencia($_GET["id"],$_GET["id_not"],$registro);

			$sla_inc = calculSLA($_GET["id"],0);
			if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

			$camposUpdate = array("temps_pendent","fecha_prevision");
			$datosUpdate = array($sla_inc,$fecha_prevision);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
		#finalizacion incidencia#
			if ($rowi["id_estado"] == -2){
				$camposInsert = "id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo";
				$datosInsert = array($rowi["id"],$rowi["id_usuario_finalizacion"],$rowi["fecha_registro_cierre"],$rowi["fecha_cierre"],$rowi["notas_conclusion"]);
				insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

				$camposUpdate = array("notas_conclusion","fecha_registro_cierre","fecha_cierre","id_usuario_finalizacion","id_estado","sla");
				$datosUpdate = array('','','','','-1','');
				updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

			} else {
				$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$_GET["id"]."";
				$resultd = mysql_query(convert_sql($sqld));
				$rowd = mysql_fetch_array($resultd);
				$total = $rowd["total"];
				if ((($_POST["notas_registro"] != "") or ($_POST["notas_conclusion"] != ""))  and ($total > 0) and (strtotime($_POST["fecha_cierre"]) > 0)){
					if ($rowc["temps_resposta"] != 0){
						$temps_pendent=(calculSLA($_GET["id"],1));
						if ($temps_pendent > 0) { $sla = 0;} else { $sla = 1;}
					} else {
						$sqld = "select temps_pendent from sgm_incidencias where id_incidencia=".$_GET["id"]."";
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$sla = 0;
						$temps_pendent = $rowd["temps_pendent"];
					}
					$fecha_cierre = date("U", strtotime($_POST["fecha_cierre"]));
					$fecha_fi = time();
					$camposUpdate = array("notas_conclusion","fecha_registro_cierre","fecha_cierre","id_usuario_finalizacion","id_estado","sla","temps_pendent","pausada");
					$datosUpdate = array($_POST["notas_conclusion"],$fecha_fi,$fecha_cierre,$userid,'-2',$sla,$temps_pendent,0);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
				} else {
					mensaje_error($ErrorFinalizacion);
				}
			}
		}
		if ($ssoption == 5) {
		#insert incidencia#
			if (($_POST["id_servicio"] > 0) or ($_POST["id_servicio2"] > 0) or ($_POST["id_cliente"] > 0)){
				if ($_POST["asunto"] != ""){
					if ($_POST["id_servicio"] > 0) {$servicio = $_POST["id_servicio"];} else {$servicio = $_POST["id_servicio2"];}
					$fecha_registro_inicio = time();
					$fecha_inicio = date(U, strtotime($_POST["fecha_inicio"]));
					$fecha_prevision = fecha_prevision($servicio, $fecha_inicio);
					$camposInsert = "id_usuario_registro,id_usuario_destino,id_usuario_origen,id_servicio,fecha_registro_inicio,fecha_inicio,fecha_prevision,id_estado,id_entrada,notas_registro,asunto,id_cliente,pausada";
					$datosInsert = array($userid,$_POST["id_usuario_destino"],$_POST["id_usuario_origen"],$servicio,$fecha_registro_inicio,$fecha_inicio,$fecha_prevision,"-1",$_POST["id_entrada"],$_POST["notas_registro"],$_POST["asunto"],$_POST["id_cliente"],$_POST["pausada"]);
					insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

					$sql = "select id from sgm_incidencias where fecha_prevision=".$fecha_prevision." and id_incidencia=0 order by id desc";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);

					if ($_POST["duracion"] != ""){
						$sql = "select id from sgm_incidencias where fecha_prevision=".$fecha_prevision." order by id desc";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);

						$fecha_registro_inicio = time();
						$fecha_inicio = date(U, strtotime($_POST["fecha_inicio"]));
						$camposInsert = "id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,duracion,visible_cliente,pausada";
						$datosInsert = array($row["id"],$userid,$fecha_registro_inicio,$fecha_inicio,$_POST["notas_registro"],$_POST["duracion"],$_POST["visible_cliente"],$_POST["pausada"]);
						insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

						if ($_POST["pausada"] == 1){
							$fecha_prevision = 0;
							$camposUpdate = array("fecha_prevision");
							$datosUpdate = array("0");
							updateFunction ("sgm_incidencias",$row["id"],$camposUpdate,$datosUpdate);
						}
						if ($_POST["finalizar"] == 1){
							$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$row["id"]."";
							$resultd = mysql_query(convert_sql($sqld));
							$rowd = mysql_fetch_array($resultd);
							$total = $rowd["total"];
							if ((($_POST["notas_registro"] != "") or ($_POST["notas_conclusion"] != "")) and ($total > 0)){
								$sqlc = "select temps_resposta from sgm_contratos_servicio where id=(select id_servicio from sgm_incidencias where id=".$row["id"].")";
								$resultc = mysql_query(convert_sql($sqlc));
								$rowc = mysql_fetch_array($resultc);
								if ($rowc["temps_resposta"] != 0){
									if ((calculSLA($_GET["id"],0)) > 0) { $sla = 1;} else { $sla = 0;}
								} else {
									$sla = 0;
								}
								$fecha_cierre = date("U", strtotime($_POST["fecha_inicio"]));
								$fecha_fi = time();
								$camposUpdate = array("notas_conclusion","fecha_registro_cierre","fecha_cierre","id_usuario_finalizacion","id_estado","sla");
								$datosUpdate = array($_POST["notas_registro"],$fecha_fi,$fecha_cierre,$userid,"-2",$sla);
								updateFunction ("sgm_incidencias",$row["id"],$camposUpdate,$datosUpdate);
							}
						}
					}
					if ($row["id_servicio"] > 0) {
						$sla_inc = calculSLA($row["id"],0);
						if ($row["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

						$camposUpdate = array("temps_pendent","fecha_prevision");
						$datosUpdate = array($sla_inc,$fecha_prevision);
						updateFunction ("sgm_incidencias",$row["id"],$camposUpdate,$datosUpdate);
					}
					$id_inc = $row["id"];
				} else {
					mensaje_error($ErrorSinAsunto);
				}
			} else {
				mensaje_error($ErrorSinServicioCliente);
			}
		}

		if ($ssoption == 6) {
		#eliminar incidencia nota#
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_incidencias",$_GET["id_not"],$camposUpdate,$datosUpdate);

			calculPausaIncidencia($_GET["id"],$_GET["id_not"],$registro);

			$sla_inc = calculSLA($_GET["id"],0);
			if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

			$camposUpdate = array("temps_pendent","fecha_prevision");
			$datosUpdate = array($sla_inc,$fecha_prevision);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($_GET["id"] != ""){$id_inc= $_GET["id"];}
		#inicio de la tabla de modificación o inserción.
		if ($id_inc != ""){
			$sql = "select * from sgm_incidencias where id=".$id_inc;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$fecha_reg = date("Y-m-d H:i:s", $row["fecha_inicio"]);
			echo "<h4>ID: ".$id_inc."</h4>";
			echo "<form action=\"index.php?op=1018&sop=100&ssop=1&id=".$id_inc."\" method=\"post\" name=\"form1\" ENCTYPE=\"multipart/form-data\">";
		} else { 
			echo "<form action=\"index.php?op=1018&sop=100&ssop=5\" method=\"post\" name=\"form1\">";
			if ($_POST["fecha_inicio"] != "") {$fecha_reg = $_POST["fecha_inicio"];} else {$fecha_reg = date("Y-m-d H:i:s", time ());}
			echo "<input type=\"Hidden\" name=\"fecha_inicio\" value=\"".$fecha_reg."\">";
		}
		$sqlid = "select idioma from sgm_idiomas where visible=1 and id=(select id_idioma from sgm_clients where visible=1 ";
		$sqlid .= "and id=(select id_cliente from sgm_contratos where visible=1 ";
		$sqlid .= "and id=(select id_contrato from sgm_contratos_servicio where visible=1 and id=".$row["id_servicio"].")))";
		$resultid = mysql_query(convert_sql($sqlid));
		$rowid = mysql_fetch_array($resultid);
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\" style=\"width:100%;\">";
			echo "<tr><td style=\"text-align:left;vertical-align:top;width:23%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:100px\">".$Fecha." ".$Registro." :</th>";
							echo "<td><input type=\"text\" name=\"fecha_inicio\" style=\"width:150px\" value=\"".$fecha_reg."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Origen." :</th>";
							echo "<td><select name=\"id_entrada\" style=\"width:150px\">";
								echo "<option value=\"0\">-</option>";
								$sqle = "select id,entrada from sgm_incidencias_entrada order by entrada";
								$resulte = mysql_query(convert_sql($sqle));
								while ($rowe = mysql_fetch_array($resulte)) {
									if (($rowe["id"] == $row["id_entrada"]) or ($_POST["id_entrada"] == $rowe["id"])){
										echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["entrada"]."</option>";
									} else {
										echo "<option value=\"".$rowe["id"]."\">".$rowe["entrada"]."</option>";
									}
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Usuario." ".$Registro." :</th>";
						if ($id_inc != ""){
							$sqlu = "select usuario from sgm_users where validado=1 and activo=1 and id=".$row["id_usuario_registro"];
						} else {
							$sqlu = "select usuario from sgm_users where validado=1 and activo=1 and id=".$userid;
						}
							$resultu = mysql_query(convert_sql($sqlu));
							$rowu = mysql_fetch_array($resultu);
							echo "<td>".$rowu["usuario"]."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Usuario." ".$Origen." :</th>";
							echo "<td><select name=\"id_usuario_origen\" style=\"width:150px\">";
								$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 order by usuario";
								$resultu = mysql_query(convert_sql($sqlu));
								while ($rowu = mysql_fetch_array($resultu)) {
									if ($id_inc != ""){
										if ($rowu["id"] == $row["id_usuario_origen"]){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
										}
									} else {
										if (($rowu["id"] == $userid) or ($rowu["id"] == $_POST["id_usuario_origen"])){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
										}
									}
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Usuario." ".$Destino." :</th>";
							echo "<td><select name=\"id_usuario_destino\" style=\"width:150px\">";
								echo "<option value=\"0\">-</option>";
								$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 order by usuario";
								$resultu = mysql_query(convert_sql($sqlu));
								while ($rowu = mysql_fetch_array($resultu)) {
									if ($id_inc != ""){
										if ($rowu["id"] == $row["id_usuario_destino"]){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
										}
									} else {
										if (($rowu["id"] == $userid) or ($rowu["id"] == $_POST["id_usuario_destino"])){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
										}
									}
								}
							echo "</select></td>";
						echo "</tr>";
						$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$id_inc." and visible=1";
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$total = $rowd["total"];
						$hora = $total/60;
						$horas = explode(".",$hora);
						$minutos = $total % 60;
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Tiempo." :</th><td>".$horas[0]." ".$Horas." ".$minutos." ".$Minutos."</td></tr>";
						$sqlpa = "select pausada from sgm_incidencias where id_incidencia=".$id_inc." and visible=1 order by fecha_inicio desc";
						$resultpa = mysql_query(convert_sql($sqlpa));
						$rowpa = mysql_fetch_array($resultpa);
						if ($row["id_estado"] == -2) {$imagen_estado = "control_stop_blue.png";}
						else { if ($rowpa["pausada"] == 0) {$imagen_estado = "control_play_blue.png";} else {$imagen_estado = "control_pause_blue.png";} }
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Estado." :</th><td style=\"text-align:left;width:40;\"><img src=\"mgestion/pics/icons-mini/".$imagen_estado."\" style=\"border:0px\"></td></tr>";
					echo "</table>";
				echo "</td><td style=\"text-align:right;vertical-align:top;width:60%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						$sqlcl = "select nif from sgm_dades_origen_factura";
						$resultcl = mysql_query(convert_sql($sqlcl));
						$rowcl = mysql_fetch_array($resultcl);
						$sqlcli = "select id from sgm_clients where visible=1 and nif='".$rowcl["nif"]."'";
						$resultcli = mysql_query(convert_sql($sqlcli));
						$rowcli = mysql_fetch_array($resultcli);
						echo "<tr>";
							echo "<th style=\"text-align:left;vertical-align:top;width:13%;\">".$Servicio." SIM :</th>";
							echo "<td colspan=\"9\"><select name=\"id_servicio\" id=\"id_servicio\" style=\"width:100%\" onchange=\"desplegableCombinado()\">";
								echo "<option value=\"0\">-</option>";
								$sqlc = "select id from sgm_contratos where visible=1 and id_cliente=".$rowcli["id"]." and activo=1 order by num_contrato";
								$resultc = mysql_query(convert_sql($sqlc));
								while ($rowc = mysql_fetch_array($resultc)) {
									$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"];
									$results = mysql_query(convert_sql($sqls));
									while ($rows = mysql_fetch_array($results)){
										if ($_POST["id_servicio"] == $rows["id"]){
											echo "<option value=\"".$rows["id"]."\" selected>".$rows["servicio"]."</option>";
										} elseif (($_POST["id_servicio"] == "") and ($row["id_servicio"] == $rows["id"])){
											echo "<option value=\"".$rows["id"]."\" selected>".$rows["servicio"]."</option>";
										} else {
											echo "<option value=\"".$rows["id"]."\">".$rows["servicio"]."</option>";
										}
									}
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:left;vertical-align:top;\">".$Cliente." :</th>";
							echo "<td colspan=\"9\"><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:100%\" onchange=\"desplegableCombinado2()\">";
								echo "<option value=\"0\">-</option>";
								$sqlcl1 = "select id,nombre from sgm_clients where visible=1 and id<>".$rowcli["id"]." and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
								$resultcl1 = mysql_query(convert_sql($sqlcl1));
								while ($rowcl1 = mysql_fetch_array($resultcl1)){
									if ($_POST["id_cliente"] == $rowcl1["id"]){
										echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl1["id"])){
										echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == "") and ($row["id_cliente"] == $rowcl1["id"])){
										echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
									} else {
										echo "<option value=\"".$rowcl1["id"]."\">- ".$rowcl1["nombre"]."</option>";
									}
								}
								$sqlcl = "select id,nombre from sgm_clients where visible=1 and id not in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
								$resultcl = mysql_query(convert_sql($sqlcl));
								while ($rowcl = mysql_fetch_array($resultcl)){
									if ($_POST["id_cliente"] == $rowcl["id"]){
										echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl["id"])){
										echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == "") and ($row["id_cliente"] == $rowcl["id"])){
										echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]."</option>";
									} else {
										echo "<option value=\"".$rowcl["id"]."\"> ".$rowcl["nombre"]."</option>";
									}
								}
							echo "</select></td>";
						echo "<tr>";
						echo "</tr>";
							echo "<th style=\"text-align:left;vertical-align:top;\">".$Servicio." :</th>";
							echo "<td colspan=\"9\"><select name=\"id_servicio2\" id=\"id_servicio2\" style=\"width:100%;\" onchange=\"desplegableCombinado3(this.value)\">";
								echo "<option value=\"0\">-</option>";
									if ($_POST["id_cliente"] != ""){
										$sqlc = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_POST["id_cliente"]."";
									} elseif ($row["id_cliente"] != ""){
										$sqlc = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente=".$row["id_cliente"]."";
									} elseif ($_GET["id_cli"] != ""){
										$sqlc = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_GET["id_cli"]."";
									}
									$resultc = mysql_query(convert_sql($sqlc));
									while ($rowc = mysql_fetch_array($resultc)){
										$sqlclie = "select * from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"]." order by nombre";
										$resultclie = mysql_query(convert_sql($sqlclie));
										$rowclie = mysql_fetch_array($resultclie);
										$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"]." order by servicio";
										$results = mysql_query(convert_sql($sqls));
										while ($rows = mysql_fetch_array($results)){
											if ($_POST["id_servicio2"] == $rows["id"]){
												echo "<option value=\"".$rows["id"]."\" selected>(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
											} elseif (($_POST["id_servicio2"] == "") and ($row["id_servicio"] == $rows["id"])){
												echo "<option value=\"".$rows["id"]."\" selected>(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
											} else {
												echo "<option value=\"".$rows["id"]."\">(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
											}
										}
									}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><th style=\"text-align:left;vertical-align:top;\">".$Asunto." :</th></tr>";
						if ($row["asunto"] != ""){$asunto = $row["asunto"];} else {$asunto = $_POST["asunto"];}
						if ($row["notas_registro"] != ""){$notas_registro = $row["notas_registro"];} else {$notas_registro = $_POST["notas_registro"];}
						if ($row["duracion"] != ""){$duracion = $row["duracion"];} else {$duracion = $_POST["duracion"];}
						echo "<tr><td colspan=\"9\"><input type=\"text\" name=\"asunto\" style=\"width:100%;\" value=\"".$asunto."\" required></td></tr>";
						echo "<tr><th colspan=\"3\" style=\"text-align:left;vertical-align:top;\">".$Notas." ".$Registro." :</th></tr>";
						echo "<tr><td colspan=\"9\"><textarea name=\"notas_registro\" style=\"width:100%;\" rows=\"4\">".$notas_registro."</textarea></td></tr>";
						echo "<tr>";
							if ($id_inc == ""){
								echo "<th style=\"text-align:left;vertical-align:top;\">".$Duracion." (Min) :</th>";
								echo "<td><input type=\"number\" min=\"1\" name=\"duracion\" style=\"width:50px\" value=\"".$duracion."\"></td>";
								echo "<th style=\"text-align:right;vertical-align:top;\">".$Visible." ".$Cliente." :</th>";
								echo "<td><select name=\"visible_cliente\" style=\"width:50px\">";
									echo "<option value=\"0\">".$No."</option>";
									echo "<option value=\"1\" selected>".$Si."</option>";
								echo "</select></td>";
								echo "<th style=\"text-align:right;vertical-align:top;\">".$Pausar." ".$Incidencia." :</th>";
								echo "<td><select name=\"pausada\" style=\"width:50px\">";
									echo "<option value=\"0\" selected>".$No."</option>";
									echo "<option value=\"1\">".$Si."</option>";
								echo "</select></td>";
								echo "<th style=\"text-align:right;vertical-align:top;\">".$Finalizar." :</th>";
								echo "<td><select name=\"finalizar\" style=\"width:50px\">";
									echo "<option value=\"0\" selected>".$No."</option>";
									echo "<option value=\"1\">".$Si."</option>";
								echo "</select></td>";
							} else {
								echo "<td colspan=\"8\"></td>";
							}
							echo "<td style=\"text-align:right;vertical-align:top;\">";
								if ($row["id_estado"] != -2){
									echo "<input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\">";
								}
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</form>";
				echo "</td><td style=\"vertical-align:top;width:25%;\">";
				if ($rowid["idioma"] != ""){echo "<img src=\"mgestion/pics/flags/".$rowid["idioma"].".png\" style=\"border:0px;width:100%;\"\">";}
				if ($row["correo"] == 1){
					echo "<br>".$Documentos." ".$Adjuntos." :";
					$sqlfiles = "select name from sgm_files where visible=1 and id_incidencia=".$row["id"];
					$resultfiles = mysql_query(convert_sql($sqlfiles));
					while ($rowfiles = mysql_fetch_array($resultfiles)){
						echo "<br><a href=\"".$urlmgestion."/files/incidencias/".$rowfiles["name"]."\" target=\"_blank\">".$rowfiles["name"]."</a>";
					}
				}
				echo "</td>";
			echo "</tr>";
		if ($id_inc != ""){
			echo "<form action=\"index.php?op=1018&sop=100&ssop=3&id=".$row["id"]."\" method=\"post\" name=\"form1\">";
			echo "<tr>";
			echo "<tr><td style=\"text-align:left;vertical-align:top;width:20%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr><td>&nbsp;</td></tr>";
						$hoy = date("Y-m-d H:i:s", time ());
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Registro." :</th><td><input type=\"text\" name=\"fecha_inicio\" style=\"width:150px\" value=\"".$hoy."\"></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Duracion." (".$Minutos.") :</th><td><input type=\"number\" min=\"1\" name=\"duracion\" style=\"width:50px\"></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Visible." ".$Cliente." :</th>";
							echo "<td><select name=\"visible_cliente\" style=\"width:50px\">";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Pausar." ".$Incidencia." :</th>";
							echo "<td><select name=\"pausada\" style=\"width:50px\">";
							if ($row["pausada"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td style=\"text-align:right;vertical-align:top;width:60%;\">";
					echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%\">";
						echo "<tr><th style=\"text-align:left;vertical-align:top;\">".$Notas." ".$Desarrollo." :</th></tr>";
						if (($_POST["notas_desarrollo"] != "") and ($_POST["duracion"] != "")){
							echo "<tr><td><textarea name=\"notas_desarrollo\" style=\"width:100%;\" rows=\"4\"></textarea></td></tr>";
						} else {
							echo "<tr><td><textarea name=\"notas_desarrollo\" style=\"width:100%;\" rows=\"4\">".$_POST["notas_desarrollo"]."</textarea></td></tr>";
						}
						if ($row["id_estado"] != -2){
							echo "<tr><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td></tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlc = "select * from sgm_incidencias where id_incidencia=".$id_inc." and visible=1 order by fecha_inicio asc";
			$resultc = mysql_query(convert_sql($sqlc));
			while ($rowc = mysql_fetch_array($resultc)) {
				echo "<form action=\"index.php?op=1018&sop=100&ssop=2&id=".$id_inc."&id_not=".$rowc["id"]."\" method=\"post\" name=\"form1\">";
					echo "<input type=\"Hidden\" name=\"ejecutar\" value=\"1\">";
					$fecha = date("Y-m-d H:i:s", $rowc["fecha_inicio"]);
					echo "<tr>";
					if ($rowc["id_usuario_registro"] == $userid){$color_td = "white";} else {$color_td = "silver";}
					echo "<td style=\"text-align:left;vertical-align:top;width:25%;\">";
					echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">ID. ".$Incidencia." :</th><td><input type=\"number\" min=\"1\" name=\"id_incidencia\" style=\"width:150px\" value=\"".$rowc["id_incidencia"]."\"></td></tr>";
						echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." :</th>";
						if ($rowc["id_usuario_registro"] == $userid){
							echo "<td><input type=\"text\" name=\"fecha_inicio\" style=\"width:150px\" value=\"".$fecha."\"></td></tr>";
						} else {
							echo "<td style=\"width:150px\">".$fecha."</td></tr>";
							echo "<input type=\"hidden\" name=\"fecha_inicio\" value=\"".$fecha."\">";
						}
						echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Usuario." :</th>";
						if ($rowc["id_usuario_registro"] == $userid){
							echo "<td><select name=\"id_usuario_registro\" style=\"width:150px\">";
							echo "<option value=\"0\">-</option>";
								$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1";
								$resultu = mysql_query(convert_sql($sqlu));
								while ($rowu = mysql_fetch_array($resultu)) {
										if ($rowu["id"] == $rowc["id_usuario_registro"]){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
										}
								}
							echo "</select></td>";
						} else {
							$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and id=".$rowc["id_usuario_registro"];
							$resultu = mysql_query(convert_sql($sqlu));
							$rowu = mysql_fetch_array($resultu);
							echo "<td style=\"width:150px\">".$rowu["usuario"]."</td>";
							echo "<input type=\"hidden\" name=\"id_usuario_registro\" value=\"".$rowu["id"]."\">";
						}
						echo "</tr>";
					if ($rowc["id_usuario_registro"] == $userid){
						if ($rowc["duracion"] <= 0) { $color_fondo = 'red'; } else { $color_fondo = 'white'; }
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Duracion." :</th><td><input type=\"number\" min=\"1\" name=\"duracion\" style=\"width:150px;background-color:".$color_fondo."\" value=\"".$rowc["duracion"]."\"></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Visible." ".$Cliente." :</th>";
							echo "<td><select name=\"visible_cliente\" style=\"width:50px\">";
							if ($rowc["visible_cliente"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Pausar." ".$Incidencia." :</th>";
							echo "<td><select name=\"pausada\" style=\"width:50px\">";
							if ($rowc["pausada"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
						echo "</tr>";
					} else {
						echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Duracion." :</th><td>".$rowc["duracion"]."</td></tr>";
						echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Visible." ".$Cliente." :</th>";
						if ($rowc["visible_cliente"] == 0){echo "<td>".$No."</td>";} else { echo "<td>".$Si."</td>";}
						echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Pausar." ".$Incidencia." :</th>";
						if ($rowc["pausada"] == 0){echo "<td>".$No."</td>";} else { echo "<td>".$Si."</td>";}
						echo "<input type=\"hidden\" name=\"duracion\" value=\"".$rowc["duracion"]."\">";
						echo "<input type=\"hidden\" name=\"visible_cliente\" value=\"".$rowc["visible_cliente"]."\">";
						echo "<input type=\"hidden\" name=\"pausada\" value=\"".$rowc["pausada"]."\">";
					}
					echo "<tr><td>&nbsp;</td></tr>";
					echo "</table>";
				echo "</td><td style=\"text-align:right;vertical-align:top;width:60%;\">";
						echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%;\">";
						if ($rowc["id_usuario_registro"] == $userid){
							echo "<tr><td colspan=\"2\"><textarea name=\"notas_desarrollo\" style=\"width:100%;height:97px\">".$rowc["notas_desarrollo"]."</textarea></td></tr>";
						} else {
							echo "<tr><td style=\"width:100%;height:97px;background-color:silver;vertical-align:top;\">".$rowc["notas_desarrollo"]."&nbsp;</td></tr>";
							echo "<input type=\"hidden\" name=\"notas_desarrollo\" value=\"".$rowc["notas_desarrollo"]."\">";
						}
							if ($row["id_estado"] != -2){
								echo "<tr>";
									echo "<td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td>";
									echo "</form>";
								if ($rowc["id_usuario_registro"] == $userid){
									echo "<form action=\"index.php?op=1018&sop=100&ssop=6&id=".$id_inc."&id_not=".$rowc["id"]."\" method=\"post\" name=\"form2\">";
									echo "<td style=\"text-align:right;\"><input type=\"Submit\" value=\"".$Eliminar."\" style=\"width:100px\"></td>";
								}
								echo "</tr>";
							}
						echo "</table>";
					echo "</form>";
				echo "</td></tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<form action=\"index.php?op=1018&sop=100&ssop=4&id=".$row["id"]."\" method=\"post\" name=\"form1\">";
			echo "<tr><td style=\"text-align:left;vertical-align:top;width:23%;\">";
					echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Finalizacion." :</th>";
						if ($row["fecha_cierre"] > 0){ $fecha_c = date("Y-m-d H:i:s", $row["fecha_cierre"]); } else { $fecha_c = date("Y-m-d H:i:s", time()); }
						echo "<td><input type=\"text\" name=\"fecha_cierre\" style=\"width:150px\" value=\"".$fecha_c."\"></td></tr>";
						$sqlu = "select usuario from sgm_users where id=".$row["id_usuario_finalizacion"];
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
						if ($row["fecha_cierre"]){
							$fecha = date("Y-m-d H:i:s", $row["fecha_cierre"]);
							echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Usuario." :</th><td style=\"width:150px\">".$rowu["usuario"]."</td></tr>";
							echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." :</th><td style=\"width:150px\">".$fecha."</td></tr>";
						}
					echo "</table>";
			echo "</td><td style=\"text-align:right;vertical-align:top;width:60%;\">";
				echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%;\">";
					echo "<tr><th style=\"text-align:left;vertical-align:top;\">".$Notas." ".$Conclusion." :</th></tr>";
					echo "<tr><td><textarea name=\"notas_conclusion\" style=\"width:100%;\" rows=\"4\">".$row["notas_conclusion"]."</textarea></td></tr>";
					if ($row["id_estado"] == -2){
						echo "<tr><td><input type=\"Submit\" value=\"".$Abrir."\" style=\"width:100px\"></td></tr>";
					} else {
						echo "<tr><td><input type=\"Submit\" value=\"".$Finalizar."\" style=\"width:100px\"></td></tr>";
					}
				echo "</table>";
			echo "</td></tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
		}
		echo "</td>";
		echo "</tr>";
		echo "</table>";
	}
#añadir incidencias fi#

#indicadores#
	if ($soption == 300) {
		echo "<h4>".$Indicadores."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Ano."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<form action=\"index.php?op=1018&sop=300\" method=\"post\">";
			echo "<tr>";
				echo "<td><select name=\"id_usuario\" style=\"width:200px;\">";
					if ($_POST["id_usuario"] == 0) {$id_usuari = $userid;} else {$id_usuari = $_POST["id_usuario"];}
					$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1";
					$resultu = mysql_query(convert_sql($sqlu));
					while ($rowu = mysql_fetch_array($resultu)) {
							if ($rowu["id"] == $id_usuari){
								echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
							} else {
								echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
							}
					}
				echo "</select></td>";
				echo "<td><select name=\"any\" style=\"width:100px\">";
					if ($_POST["any"] == 0) {$year = date("Y");} else {$year = $_POST["any"];}
					for ($j=2013;$j<=date("Y");$j++){
						if ($j == $year){
							echo "<option value=\"".$j."\" selected>".$j."</option>";
						} else {
							echo "<option value=\"".$j."\">".$j."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
		if ($_POST["id_usuario"] > 0){
		echo "<br><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"lista\">";
			$count = 0;
			echo "<tr>";
			$total_any = 0;
			for ($me=1;$me<=12;$me++){
				$total_mes = 0;
				$color = "white";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver\"><td></td><th>".$meses[$me-1]."</th><td></td></tr>";
						for ($i=1;$i<=31;$i++){
							if ($i <= cal_days_in_month(CAL_GREGORIAN, $me, $_POST["any"])){
								$data1 = date(U, mktime(0, 0, 0, $me, $i, $_POST["any"]));
								$data2 = date(U, mktime(0, 0, 0, $me, $i+1, $_POST["any"]));
								if (comprobar_festivo_empleado($data1,$_POST["id_usuario"]) == 1){ $color = "Orange"; } else {$color = "white";}
								if (comprobar_festivo2($data1) == 1){ $color = "Tomato"; } else {$color = $color;}
								echo "<tr style=\"background-color:".$color."\">";
									if ($count == 0){echo "<th style=\"background-color:white;\">".$i."</th>";} else {echo "<td></td>";}
									$sqlis = "select sum(duracion) as duracion_total from sgm_incidencias where visible=1 and id_incidencia<>0 and id_usuario_registro=".$_POST["id_usuario"]." and fecha_inicio between ".$data1." and ".$data2."";
									$resultis = mysql_query(convert_sql($sqlis));
									$rowis = mysql_fetch_array($resultis);
									$hora = $rowis["duracion_total"]/60;
									$horas = explode(".",$hora);
									$minutos = $rowis["duracion_total"] % 60;
									if ($horas[0]<10) { $horas_x = "0".$horas[0]; } else { $horas_x = $horas[0]; }
									if ($minutos<10) { $minutos_x = "0".$minutos; } else { $minutos_x = $minutos; }
									echo "<td style=\"width:100px;\"><a href=\"index.php?op=1018&sop=200&filtra=1&d=".$i."&m=".$me."&a=".$_POST["any"]."&u=".$_POST["id_usuario"]."\">".$horas_x." Hr. ".$minutos_x." min.</a></td>";
									$total_mes += $rowis["duracion_total"];
	#							$total_sem += $rowis["duracion_total"];
	#							if (date("w", ($data2)) == 6){
	#								echo "<tr><td><strong>".$Total." ".$Horas."</strong></td>";
	#									$hora2 = $total_sem/60;
	#									$horas2 = explode(".",$hora2);
	#									$minutos2 = $total_sem % 60;
	#									echo "<td style=\"width:50%;\"><strong>".$horas2[0]." ".$Horas." ".$minutos2." ".$Minutos."</strong></td>";
	#								echo "</tr>";
	#								$total_sem = 0;
	#							}
								if ($count == 11){echo "<th style=\"background-color:white;\">".$i."</th>";} else {echo "<td></td>";}
								echo "</tr>";
							} else {
								echo "<tr><td>&nbsp;</td></tr>";
							}
						}
						echo "<tr>";
							if ($count == 0){echo "<td><strong>".$Total."</strong></td>";} else {echo "<td></td>";}
								$hora2 = $total_mes/60;
								$horas2 = explode(".",$hora2);
								$minutos2 = $total_mes % 60;
							echo "<td><strong>".$horas2[0]." Hr. ".$minutos2." min.</strong></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				$count++;
#				if ($count == 6){ echo "</tr><td>&nbsp;</td><tr></tr><td>&nbsp;</td><tr>"; $count=0;}
				$total_any += $total_mes;
			}
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		$hora3 = $total_any/60;
		$horas3 = explode(".",$hora3);
		$minutos3 = $total_any % 60;
		$sqlr = "select num_horas_any from sgm_rrhh_jornada_anual";
		$resultr = mysql_query(convert_sql($sqlr));
		$rowr = mysql_fetch_array($resultr);
		echo "<table><tr><td><strong>".$Total." ".$Horas." ".$Ano." : ".$horas3[0]." ".$Horas." ".$minutos3." ".$Minutos." / ".$rowr["num_horas_any"]." ".$Horas."</strong></td></tr></table>";
		}
	}
#fi indicadores

#Informes
	if ($soption == 400) {
		informesContratos();
	}

#Administració de taules auxiliars del módul#
	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1018&sop=510"),array($Estado));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}
#Administració de taules auxiliars del módul fi#

#estados incidencias#
	if (($soption == 510) and ($admin == true)) {
		if (($ssoption == 1) and ($admin == true)) {	
			$camposInsert = "estado,editable";
			$datosInsert = array($_POST["estado"],$_POST["editable"]);
			insertFunction ("sgm_incidencias_estados",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) and ($admin == true)) {
			$camposUpdate = array("estado","editable");
			$datosUpdate = array($_POST["estado"],$_POST["editable"]);
			updateFunction ("sgm_incidencias_estados",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) and ($admin == true)) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_incidencias_estados",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Estados." ".$Incidencias."</h4>";
		echo boton(array("op=1018&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Tipo." ".$Estado."</th>";
				echo "<th>".$Editable."</th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1018&sop=510&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"estado\" style=\"width:150px\" required></td>";
				echo "<td>";
					echo "<select style=\"width:50px\" name=\"editable\">";
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:75px\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
				$sql = "select * from sgm_incidencias_estados where visible=1";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;\">";
							if ($row["editable"] == 1) {echo "<a href=\"index.php?op=1018&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>";}
						echo "</td>";
						echo "<form action=\"index.php?op=1018&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
						echo "<td><input type=\"Text\" name=\"estado\" style=\"width:150px\" value=\"".$row["estado"]."\"></td>";
						echo "<td>";
							if ($row["editable"] == 1){
								echo "<select style=\"width:50px\" name=\"editable\">";
									echo "<option value=\"0\">".$No."</option>";
									echo "<option value=\"1\" selected>".$Si."</option>";
								echo "</select>";
							}
						echo "</td>";
						echo "<td>";
							if ($row["editable"] == 1) {echo "<input type=\"Submit\" value=\"Modificar\" style=\"width:75px\">";}
						echo "</td>";
						echo "</form>";
					echo "</tr>";
				}
		echo "</table>";
	}

	if (($soption == 511) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1018&sop=510&ssop=3&id=".$_GET["id"],"op=1018&sop=510".$adres),array($Si,$No));
		echo "</center>";
	}
#estados incidencias fin#

	echo "</td></tr></table><br>";
}

function comprobar_festivo_empleado($fecha,$id_user)
{
	global $db;
	$festivo=0;
	$sqle = "select * from sgm_rrhh_empleado_calendario where ((data_ini=".$fecha.") or ((".$fecha." >= data_ini) and (".$fecha." <= data_fi))) and id_empleado=(select id from sgm_rrhh_empleado where id_usuario=".$id_user.")";
	$resulte = mysql_query(convert_sql($sqle));
	$rowe = mysql_fetch_array($resulte);
	if ($rowe){
		$festivo=1;
	}
#	echo $festivo."<br>";
	return $festivo;
}

?>
