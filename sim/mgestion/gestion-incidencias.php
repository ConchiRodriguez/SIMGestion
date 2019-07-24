<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1018) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Incidencias."</h4>";
		echo "</td><td style=\"width:92%;vertical-align : top;text-align:left;\">";
			echo "<table class=\"lista\">";
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
				if (($soption >= 500) and ($soption < 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=500\" class=".$class.">".$Administrar."</a></td>";
 				if ($soption == 600) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1018&sop=600\" class=".$class.">".$Ayuda."</a></td>";
 				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

#Vista general de incidencias
	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		$relacionada = 0;
#		$eliminada = 0;
		if ($ssoption == 1) {
			$sqlin = "select pausada from sgm_incidencias where id_incidencia=".$_GET["id_inc_rel"]." and visible=1 order by fecha_inicio desc";
			$resultin = mysqli_query($dbhandle,convertSQL($sqlin));
			$rowin = mysqli_fetch_array($resultin);

			$sqlinc = "select notas_registro from sgm_incidencias where id=".$_GET["id"];
			$resultinc = mysqli_query($dbhandle,convertSQL($sqlinc));
			$rowinc = mysqli_fetch_array($resultinc);

			if ($rowin) {
				$pausada = $rowin["pausada"];
			} else {
				$pausada = 0;
			}
			$camposUpdate = array("id_incidencia","notas_desarrollo","pausada");
			$datosUpdate = array($_GET["id_inc_rel"],$rowinc["notas_registro"],$pausada);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

			$sqlinc2 = "select id from sgm_incidencias where id_incidencia=".$_GET["id"];
			$resultinc2 = mysqli_query($dbhandle,convertSQL($sqlinc2));
			while($rowinc2 = mysqli_fetch_array($resultinc2)){
				$camposUpdate = array("id_incidencia");
				$datosUpdate = array($_GET["id_inc_rel"]);
				updateFunction ("sgm_incidencias",$rowinc2["id"],$camposUpdate,$datosUpdate);
			}
			$relacionada = 1;
			$tipo = 7;
		}
		if ($ssoption == 2) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
			mysqli_query($dbhandle,convertSQL($sql));
			$sql = "update sgm_incidencias set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id_incidencia=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));

			$sqli2 = "select * from sgm_incidencias where id=".$_GET["id"];
			$resulti2 = mysqli_query($dbhandle,convertSQL($sqli2));
			$rowi2 = mysqli_fetch_array($resulti2);
#			if ($rowi2["visible_cliente"] == 1){
#				$eliminada = 1;
#				$tipo = 8;
#			}
		}
		if ($relacionada==1){
			$sqlinci = "select id,id_servicio,id_usuario_registro,id_usuario_origen from sgm_incidencias where id=".$_GET["id"];
			$resultinci = mysqli_query($dbhandle,convertSQL($sqlinci));
			$rowinci = mysqli_fetch_array($resultinci);
			envioNotificacionIncidencia($_GET["id"],$rowinci["id_servicio"],$rowinci["id_usuario_registro"],$rowinci["id_usuario_origen"],$insertada,$editada,$cerrada,$relacionada,$eliminada,$tipo);
			$relacionada = 0;
		}

		if (($soption == 0) or ($soption == 1)) {
			if ($_GET["id_cli"] != ""){ $adress = "&id_cli=".$_GET["id_cli"];}else{$adress = "";} 
?>
			<script>
			function redireccionar(){
				window.location.reload();
			}
			setTimeout ("redireccionar()", 180000);
			</script>
<?php
		}
#		if ($soption == 1) { echo "<h4>".$Historico."</h4>";}
		if ($soption != 200){
			echo "<table cellspacing=\"2\" cellpadding=\"0\" class=\"lista\" style=\"width:100%;\">";
				echo "<tr>";
					echo "<td>";
						echo "<table class=\"lista\">";
							echo "<tr>";
							if ($_GET["id_cli"] == 0) {$class = "menu_select";} else {$class = "menu";}
								$sqliw = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and fecha_prevision>0 and (temps_pendent<14400 and temps_pendent>0) and id_incidencia=0";
								$resultiw = mysqli_query($dbhandle,convertSQL($sqliw));
								$rowiw = mysqli_fetch_array($resultiw);
								$sqlic = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and fecha_prevision>0 and temps_pendent<0 and id_incidencia=0";
								$resultic = mysqli_query($dbhandle,convertSQL($sqlic));
								$rowic = mysqli_fetch_array($resultic);
								$sqlip = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and pausada=1 and id_incidencia=0";
								$resultip = mysqli_query($dbhandle,convertSQL($sqlip));
								$rowip = mysqli_fetch_array($resultip);
								$sqlit = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and pausada=0 and fecha_prevision=0 and id_incidencia=0";
								$resultit = mysqli_query($dbhandle,convertSQL($sqlit));
								$rowit = mysqli_fetch_array($resultit);
								$novedades = 0;
								$contador1 = 0;
								$sqlind = "select * from sgm_incidencias where visible=1 and id_estado<>-2 and id_usuario_destino=".$userid." and id_incidencia=0";
								$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
								while ($rowind = mysqli_fetch_array($resultind)){
									$novedades = contarIncidenciasNovedades ($rowind["id"],$rowind["id_usuario_destino"]);
									if ($novedades > 0){$contador1++;}
								}
								echo "<td class=".$class.">";
									echo "<table class=\"lista\"><tr>";
										echo "<td style=\"text-align:left;\"><a href=\"index.php?op=1018&sop=0\" class=".$class.">".$Todos."</a></td>";
										echo "<td style=\"width:10px;\">&nbsp;</td>";
										echo "<td style=\"width:10px;background-color:#00BFFF;\"><a href=\"index.php?op=1018&sop=1&bt=5\">".$rowit["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:Orange;\"><a href=\"index.php?op=1018&sop=1&bt=1\">".$rowiw["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:red;color:white\"><a href=\"index.php?op=1018&sop=1&bt=2\">".$rowic["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:silver;\"><a href=\"index.php?op=1018&sop=1&bt=3\">".$rowip["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:yellow;\"><a href=\"index.php?op=1018&sop=1&bt=4&id_cli=".$rowcli["id"]."\">".$contador1."</a></td>";
									echo "</tr></table>";
								echo "</td>";
							echo "<td>&nbsp;&nbsp;</td>";
							$counter = 0;
							$sqlcli = "select id,alias from sgm_clients where visible=1 and id in (select id_cliente from sgm_incidencias where visible=1 and id_estado<>-2 and id_incidencia=0) order by alias";
							$resultcli = mysqli_query($dbhandle,convertSQL($sqlcli));
							while ($rowcli = mysqli_fetch_array($resultcli)){
								$sqliw = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and fecha_prevision>0 and (temps_pendent<14400 and temps_pendent>0) and id_incidencia=0 and id_cliente=".$rowcli["id"];
								$resultiw = mysqli_query($dbhandle,convertSQL($sqliw));
								$rowiw = mysqli_fetch_array($resultiw);
								$sqlic = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and fecha_prevision>0 and temps_pendent<0 and id_incidencia=0 and id_cliente=".$rowcli["id"];
								$resultic = mysqli_query($dbhandle,convertSQL($sqlic));
								$rowic = mysqli_fetch_array($resultic);
								$sqlip = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and pausada=1 and id_incidencia=0 and id_cliente=".$rowcli["id"];
								$resultip = mysqli_query($dbhandle,convertSQL($sqlip));
								$rowip = mysqli_fetch_array($resultip);
								$sqlit = "select count(*) as total from sgm_incidencias where visible=1 and id_estado<>-2 and pausada=0 and fecha_prevision=0 and id_incidencia=0 and id_cliente=".$rowcli["id"];
								$resultit = mysqli_query($dbhandle,convertSQL($sqlit));
								$rowit = mysqli_fetch_array($resultit);
								$novedades = 0;
								$contador1 = 0;
								$sqlind = "select * from sgm_incidencias where visible=1 and id_estado<>-2 and id_usuario_destino=".$userid." and id_cliente=".$rowcli["id"]." and id_incidencia=0";
								$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
								while ($rowind = mysqli_fetch_array($resultind)){
									$novedades = contarIncidenciasNovedades ($rowind["id"],$rowind["id_usuario_destino"]);
									if ($novedades > 0){$contador1++;}
								}
								if ($rowcli["id"] == $_GET["id_cli"]) {$class = "menu_select";} else {$class = "menu";}
								if ($counter == 12) {echo "</tr><tr><td colspan=\"2\"></td>";}
								echo "<td class=".$class.">";
									echo "<table class=\"lista\"><tr>";
										echo "<td style=\"text-align:left;\"><a href=\"index.php?op=1018&sop=0&id_cli=".$rowcli["id"]."&id_user=".$_GET["id_user"]."\" class=".$class.">".$rowcli["alias"]."</a></td>";
										echo "<td style=\"width:10px;\">&nbsp;</td>";
										echo "<td style=\"width:10px;background-color:#00BFFF;\"><a href=\"index.php?op=1018&sop=1&bt=5&id_cli=".$rowcli["id"]."\">".$rowit["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:Orange;\"><a href=\"index.php?op=1018&sop=1&bt=1&id_cli=".$rowcli["id"]."\"&id_user=".$_GET["id_user"].">".$rowiw["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:red;\"><a href=\"index.php?op=1018&sop=1&bt=2&id_cli=".$rowcli["id"]."&id_user=".$_GET["id_user"]."\">".$rowic["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:silver;\"><a href=\"index.php?op=1018&sop=1&bt=3&id_cli=".$rowcli["id"]."&id_user=".$_GET["id_user"]."\">".$rowip["total"]."</a></td>";
										echo "<td style=\"width:10px;background-color:yellow;\"><a href=\"index.php?op=1018&sop=1&bt=4&id_cli=".$rowcli["id"]."&id_user=".$_GET["id_user"]."\">".$contador1."</a></td>";
									echo "</tr></table>";
								echo "</td>";
								$counter++;
							}
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "<table class=\"lista\">";
							echo "<tr>";
							$counter = 0;
							$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 and id in (select id_usuario_destino from sgm_incidencias where visible=1 and id_estado<>-2 and id_incidencia=0) order by usuario";
							$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
							while ($rowu = mysqli_fetch_array($resultu)) {
								if ($rowu["id"] == $_GET["id_user"]) {$class = "menu_select";} else {$class = "menu";}
								if ($counter == 12) {echo "</tr><tr><td colspan=\"2\"></td>";}
								echo "<td class=".$class.">";
									echo "<table class=\"lista\"><tr>";
										echo "<td style=\"text-align:left;\"><a href=\"index.php?op=1018&sop=0&id_user=".$rowu["id"]."&id_cli=".$_GET["id_cli"]."\" class=".$class.">".$rowu["usuario"]."</a></td>";
									echo "</tr></table>";
								echo "</td>";
								$counter++;
							}
							echo "</tr>";
						echo "</table>";
						echo "<table class=\"lista\">";
							echo "<tr>";
								if ($_GET["id_niv"] == 1) {$class = "menu_select";} else {$class = "menu";}
								echo "<td class=".$class.">";
									echo "<table class=\"lista\"><tr>";
										echo "<td><a href=\"index.php?op=1018&sop=0&id_user=".$_GET["id_user"]."&id_cli=".$_GET["id_cli"]."&id_niv=1\" class=".$class."><img src=\"mgestion/pics/icons-mini/medal_bronze_3.png\" alt=\"".$Nivel."\" title=\"".$Nivel."\" style=\"border:0px;\">N1</a></td>";
									echo "</tr></table>";
								echo "</td>";
								if ($_GET["id_niv"] == 2) {$class = "menu_select";} else {$class = "menu";}
								echo "<td class=".$class.">";
									echo "<table class=\"lista\"><tr>";
										echo "<td><a href=\"index.php?op=1018&sop=0&id_user=".$_GET["id_user"]."&id_cli=".$_GET["id_cli"]."&id_niv=2\" class=".$class."><img src=\"mgestion/pics/icons-mini/medal_silver_3.png\" alt=\"".$Nivel."\" title=\"".$Nivel."\" style=\"border:0px;\">N2</a></td>";
									echo "</tr></table>";
								echo "</td>";
								if ($_GET["id_niv"] == 3) {$class = "menu_select";} else {$class = "menu";}
								echo "<td class=".$class.">";
									echo "<table class=\"lista\"><tr>";
										echo "<td><a href=\"index.php?op=1018&sop=0&id_user=".$_GET["id_user"]."&id_cli=".$_GET["id_cli"]."&id_niv=3\" class=".$class."><img src=\"mgestion/pics/icons-mini/medal_gold_3.png\" alt=\"".$Nivel."\" title=\"".$Nivel."\" style=\"border:0px;\">N3</a></td>";
									echo "</tr></table>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					if ($_GET["id_cli"] != ""){
						$sqlcli1 = "select * from sgm_clients where visible=1 and id=".$_GET["id_cli"];
						$resultcli1 = mysqli_query($dbhandle,convertSQL($sqlcli1));
						$rowcli1 = mysqli_fetch_array($resultcli1);
						echo "<td style=\"border:1px black solid;\">";
							echo "<table class=\"lista\">";
								echo "<tr>";
									echo "<td style=\"vertical-align:top;margin:5px 10px 10px 10px;width:500px;padding:5px 10px 10px 10px;\">";
										echo "<a href=\"index.php?op=1008&sop=100&id=".$rowcli1["id"]."\"><strong>".$rowcli1["nombre"]." ".$rowcli1["cognom1"]." ".$rowcli1["cognom2"]."</strong></a>";
										echo "<br><strong>".$rowcli1["direccion"]." </strong>";
										if ($rowcli1["cp"] != "") {echo " (".$rowcli1["cp"].") ";}
										echo "<strong>".$rowcli1["poblacion"]."</strong>";
										if ($rowcli1["provincia"] != "") {echo " (".$rowcli1["provincia"].")";}
										if ($rowcli1["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$rowcli1["telefono"]."</strong>"; }
										if ($rowcli1["mail"] != "") { echo " ".$Email." : <a href=\"mailto:".$rowcli1["mail"]."\"><strong>".$rowcli1["mail"]."</strong></a>"; }
										if ($rowcli1["url"] != "") { echo " ".$Web." : <strong>".$rowcli1["url"]."</strong>"; }
									echo "</td>";
									echo "<td style=\"vertical-align:top\">";
										echo "<table cellpadding=\"0\">";
											echo "<tr>";
											$contador = 0;
											$sqlcli2 = "select * from sgm_clients_contactos where visible=1 and id_client=".$_GET["id_cli"];
											$resultcli2 = mysqli_query($dbhandle,convertSQL($sqlcli2));
											while ($rowcli2 = mysqli_fetch_array($resultcli2)){
													echo "<td style=\"width:150px;text-align:left;\">".$rowcli2["nombre"]." ".$rowcli2["apellido1"]." ".$rowcli2["apellido2"]."</td>";
													echo "<td style=\"width:200px;text-align:left;\"><a href=\"mailto:".$rowcli2["mail"]."\">".$rowcli2["mail"]."</a></td>";
													echo "<td style=\"width:150px;text-align:left;\">".$rowcli2["telefono"]."</td>";
												$contador++;
												if ($contador>=2){echo "</tr><tr>"; $contador=0;}
											}
											echo "</tr>";
										echo "</table>";
									echo "</td>";
									echo "<td style=\"vertical-align:top\">";
										echo "<a href=\"index.php?op=1008&sop=122&ssop=1&id=".$rowcli1["id"]."\"><img src=\"mgestion/pics/icons-mini/user_add.png\" alt=\"Cliente\" title=\"".$Anadir." ".$Contacto."\" border=\"0\"></a>&nbsp;&nbsp;";
										echo "<a href=\"index.php?op=1024&sop=0&id_cli=".$rowcli1["id"]."\"><img src=\"mgestion/pics/icons-mini/key.png\" alt=\"Contraseñas\" title=\"".$Ver." ".$Contrasenas."\" border=\"0\"></a>";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					}
				echo "</tr>";
			echo "</table>";
			echo "<br><br>";
		}

		if ($soption == 200){
			echo "<h4>".$Buscador."</h4>";
			echo "<table cellspacing=\"1\" cellpadding=\"0\" style=\"background-color:silver;\" class=\"lista\">";
				echo "<form action=\"index.php?op=1018&sop=200&filtra=1\" method=\"post\" name=\"form1\">";
				echo "<tr>";
					echo "<th colspan=\"3\" style=\"text-align:left;vertical-align:top;\">".$Cliente."</th>";
					echo "<th colspan=\"3\" style=\"text-align:left;vertical-align:top;\">".$Servicio."</th>";
				echo "</tr><tr>";
					echo "<td colspan=\"3\"><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:500px\" onchange=\"desplegableCombinado2()\">";
						echo "<option value=\"0\">-</option>";
						$sqlcl1 = "select id,nombre from sgm_clients where visible=1 and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
						$resultcl1 = mysqli_query($dbhandle,convertSQL($sqlcl1));
						while ($rowcl1 = mysqli_fetch_array($resultcl1)){
							if ($_POST["id_cliente"] == $rowcl1["id"]){
								echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
							} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl1["id"])){
								echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowcl1["id"]."\">- ".$rowcl1["nombre"]."</option>";
							}
						}
						$sqlcl = "select id,nombre from sgm_clients where visible=1 and id not in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
						$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
						while ($rowcl = mysqli_fetch_array($resultcl)){
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
						if ($_POST["id_servicio"] == "-1") {
							echo "<option value=\"-1\" selected>".$SinContrato."</option>";
						} else {
							echo "<option value=\"-1\">".$SinContrato."</option>";
						}
						if ($_POST["id_cliente"] != "") {$sqlc = "select id_cliente_final,id,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_POST["id_cliente"]."";}
						elseif ($_GET["id_cli"] != "") {$sqlc = "select id_cliente_final,id,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente=".$_GET["id_cli"]."";}
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							$sqlclie = "select nombre from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"]." order by nombre";
							$resultclie = mysqli_query($dbhandle,convertSQL($sqlclie));
							$rowclie = mysqli_fetch_array($resultclie);
							$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"]." order by servicio";
							$results = mysqli_query($dbhandle,convertSQL($sqls));
							while ($rows = mysqli_fetch_array($results)){
								if ($_POST["id_servicio"] == $rows["id"]){
									echo "<option value=\"".$rows["id"]."\" selected>(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
								} else {
									echo "<option value=\"".$rows["id"]."\">(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
								}
							}
						}
					echo "</select></td>";
				echo "</tr>";
#				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr>";
					echo "<th style=\"width:140px\">".$Fecha."</th>";
					echo "<th style=\"width:180px\">".$Estado."</th>";
					echo "<th style=\"width:180px\">".$Usuario."</th>";
					echo "<th style=\"width:100px\">ID</th>";
					echo "<th style=\"width:300px\">".$Texto."</th>";
					echo "<th style=\"width:100px\"></th>";
				echo "</tr><tr>";
					echo "<td><select name=\"fecha\" style=\"width:140px\">";
						echo "<option value=\"0\" selected>-</option>";
						if ($_POST["fecha"] == 1){echo "<option value=\"1\" selected>".$Ayer."</option>";} else {echo "<option value=\"1\">".$Ayer."</option>";}
						if ($_POST["fecha"] == 2){echo "<option value=\"2\" selected>".$Ultima." ".$Semana."</option>";} else {echo "<option value=\"2\">".$Ultima." ".$Semana."</option>";}
						if ($_POST["fecha"] == 3){echo "<option value=\"3\" selected>".$Ultimos." 15 ".$Dias."</option>";} else {echo "<option value=\"3\">".$Ultimos." 15 ".$Dias."</option>";}
						if ($_POST["fecha"] == 4){echo "<option value=\"4\" selected>".$Ultimo." ".$Mes."</option>";} else {echo "<option value=\"4\">".$Ultimo." ".$Mes."</option>";}
						if ($_POST["fecha"] == 5){echo "<option value=\"5\" selected>".$Ultimos." 3 ".$Meses."</option>";} else {echo "<option value=\"5\">".$Ultimos." 3 ".$Meses."</option>";}
						if ($_POST["fecha"] == 6){echo "<option value=\"6\" selected>".$Ultimos." 6 ".$Meses."</option>";} else {echo "<option value=\"6\">".$Ultimos." 6 ".$Meses."</option>";}
					echo "</select></td>";
					echo "<td><select name=\"id_estado\" style=\"width:180px\">";
							echo "<option value=\"0\" selected>Todos</option>";
						$sqle = "select id,estado from sgm_incidencias_estados where visible=1 order by estado";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						while ($rowe = mysqli_fetch_array($resulte)) {
								if ($rowe["id"] == $_POST["id_estado"]){
									echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["estado"]."</option>";
								} else {
									echo "<option value=\"".$rowe["id"]."\">".$rowe["estado"]."</option>";
								}
						}
					echo "</select></td>";
					echo "<td><select name=\"id_usuario\" style=\"width:180px\">";
							echo "<option value=\"0\" selected>-</option>";
						$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 order by usuario";
						$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
						while ($rowu = mysqli_fetch_array($resultu)) {
								if (($rowu["id"] == $_POST["id_usuario"]) or ($rowu["id"] == $_GET["u"]) or ($rowu["id"] == $userid)){
									echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
								} else {
									echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
								}
						}
						$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=0 order by usuario";
						$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
						while ($rowu = mysqli_fetch_array($resultu)) {
								if (($rowu["id"] == $_POST["id_usuario"]) or ($rowu["id"] == $_GET["u"])){
									echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
								} else {
									echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
								}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"id_incidencia\" value=\"".$_POST["id_incidencia"]."\" style=\"width:100px\"></td>";
					echo "<td><input type=\"text\" name=\"texto\" value=\"".$_POST["texto"]."\" style=\"width:300px\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Filtrar."\"></td>";
				echo "</tr>";
			echo "</form>";
			echo "</table>";
			echo "<br><br>";
		}

		if ((($_POST["mes"] != 0) and ($_POST["any"] == 0)) and ($soption == 200)){
			mensageError($ErrorBusqueda);
		}
		echo "<table cellspacing=\"0\" style=\"width:100%\" class=\"lista\">";
			$tiempo_total = 0;
			$temps_total = 0;
			$id_relacio = array();
			$sqle = "select id from sgm_incidencias where visible=1 and id_estado<>-2 and id_incidencia=0 order by id desc";
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			while ($rowe = mysqli_fetch_array($resulte)){
				array_push($id_relacio, $rowe["id"]);
			}
#			echo var_dump($id_relacio);
		for ($i = 0; $i<=4;$i++){
			if (($soption == 0) or ($soption == 1) or (($soption == 200) and ($_GET["filtra"] == 1) and (($_GET["m"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0) or ($_POST["id_cliente"] != 0) or ($_POST["id_servicio"] != 0) or ($_POST["id_usuario"] != 0) or ($_POST["texto"] != "") or ($_POST["id_incidencia"] != "") or ($_POST["id_estado"] != "")))) {
				if ($i == 0) {
					echo "<tr style=\"background-color:silver;\">";
						echo "<th></th>";
						echo "<th>ID</th>";
						echo "<th>".$SLA."</th>";
						if (($soption == 0) or ($soption == 1)) { echo "<th><a href=\"index.php?op=1018&fil=1\">".$Fecha." ".$Prevision."<img src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" alt=\"".$Filtro."\" title=\"".$Filtro."\" style=\"border:0px;\"></a></th>"; }
		#				if ($soption == 1) { echo "<td>".$Fecha." ".$Fin."</td>"; }
						if ($soption == 200) { echo "<th>".$Fecha."</th>"; }
						echo "<th>".$Asunto."</th>";
						echo "<th colspan=\"2\">".$Nivel." ".$Tecnico."</a></th>";
						echo "<th><a href=\"index.php?op=1018&fil=2\">".$Cliente."<img src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" alt=\"".$Filtro."\" title=\"".$Filtro."\" style=\"border:0px;\"></a></th>";
		#				echo "<th>".$Servicio."</th>";
						echo "<th><a href=\"index.php?op=1018&fil=3\">".$Usuario." ".$Destino."<img src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" alt=\"".$Filtro."\" title=\"".$Filtro."\" style=\"border:0px;\"></a></th>";
					if (($_POST["dia"] != 0) or ($_GET["d"] != 0) or ($_POST["fecha"] != 0) or ($_GET["m"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0)){
						echo "<th>".$Tiempo."/".$Tiempo." ".$Total."</th>";
					} else {
						echo "<th>".$Tiempo."</th>";
					}
					if ($soption == 0){
						echo "<th colspan=\"2\">".$Relacion."</th>";
					}
					echo "</tr>";
				}
				$sqli = "select id,id_usuario_destino,id_servicio,id_cliente,id_estado,fecha_registro_cierre,fecha_prevision,fecha_inicio,pausada,asunto,temps_pendent,nivel_tecnico from sgm_incidencias where visible=1 and id_incidencia=0";
			}
			if (($_GET["m"] != 0) or ($_GET["a"] != 0)){
				if ($_GET["d"] != 0){
					$data1 = date(U, mktime(0, 0, 0, $_GET["m"], $_GET["d"], $_GET["a"]));
					$data2 = date(U, mktime(0, 0, 0, $_GET["m"], $_GET["d"]+1, $_GET["a"]));
				} else {
					if ($_GET["m"] != 0){
						$data1 = date(U, mktime(0, 0, 0, $_GET["m"], 1, $_GET["a"]));
						$data2 = date(U, mktime(0, 0, 0, $_GET["m"]+1,1, $_GET["a"]));
					} else {
						$data1 = date(U, mktime(0, 0, 0, 1, 1, $_GET["a"]));
						$data2 = date(U, mktime(0, 0, 0, 12, 31, $_GET["a"]));
					}
				}
				$sqli = $sqli." and id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$data1." and ".$data2." and visible=1)";
			}
			if ($_POST["fecha"] != 0){
				$data2 = date(U);
				if ($_POST["fecha"] == 1) { $data1 = date(U, mktime(0, 0, 0, date("n"), date("j")-1, date("Y")));}
				if ($_POST["fecha"] == 2) { $data1 = date(U, mktime(0, 0, 0, date("n"), date("j")-7, date("Y")));}
				if ($_POST["fecha"] == 3) { $data1 = date(U, mktime(0, 0, 0, date("n"), date("j")-15, date("Y")));}
				if ($_POST["fecha"] == 4) { $data1 = date(U, mktime(0, 0, 0, date("n")-1, date("j"), date("Y")));}
				if ($_POST["fecha"] == 5) { $data1 = date(U, mktime(0, 0, 0, date("n")-3, date("j"), date("Y")));}
				if ($_POST["fecha"] == 6) { $data1 = date(U, mktime(0, 0, 0, date("n")-6, date("j"), date("Y")));}
				$sqli = $sqli." and id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and fecha_inicio between ".$data1." and ".$data2." and visible=1)";
			}
			if (($_GET["u"] != 0) or ($_POST["id_usuario"] != 0)) { $sqli = $sqli." and (id_usuario_destino=".$_GET["u"].$_POST["id_usuario"]." or id IN (select id_incidencia from sgm_incidencias where id_incidencia<>0 and id_usuario_registro=".$_GET["u"].$_POST["id_usuario"]."))"; }
			if ($_GET["id_user"] != 0) { $sqli = $sqli." and id_usuario_destino=".$_GET["id_user"]; }
			if ($_POST["id_cliente"] != 0) { $sqli = $sqli." and id_cliente=".$_POST["id_cliente"].""; }
			if ($_GET["id_cli"] != 0) { $sqli = $sqli." and (id_cliente=".$_GET["id_cli"]." or id_servicio in (select id from sgm_contratos_servicio where id_contrato in (select id from sgm_contratos where id_cliente=".$_GET["id_cli"]." and visible=1) and visible=1))"; }
			if ($_POST["id_servicio"] != 0) { $sqli = $sqli." and id_servicio=".$_POST["id_servicio"].""; }
			if ($_POST["id_estado"] != 0) { $sqli = $sqli." and id_estado=".$_POST["id_estado"].""; }
			if ($_POST["texto"] != "") { $sqli = $sqli." and (notas_registro like '%".$_POST["texto"]."%' or notas_conclusion like '%".$_POST["texto"]."%' or id in (select id_incidencia from sgm_incidencias where visible=1 and id_incidencia<>0 and notas_desarrollo like '%".$_POST["texto"]."%')) ";}
			if ($_POST["id_incidencia"] != "") { $sqli = $sqli." and id=".$_POST["id_incidencia"].""; }
			if ($_GET["id_niv"] != 0) { $sqli = $sqli." and nivel_tecnico=".$_GET["id_niv"].""; }
			if (($soption == 0) and ($_POST["id_estado"] == 0)) { $sqli = $sqli." and (id_estado <> -2)"; }
#			if ($_GET["pausa"] == 0) { $sqli = $sqli." and pausada=0"; }
			if ($soption == 1) {
				if ($_GET["bt"] == 1) { $sqli = $sqli." and id_estado<>-2 and fecha_prevision>0 and (temps_pendent<14400 and temps_pendent>0)";}
				if ($_GET["bt"] == 2) { $sqli = $sqli." and id_estado<>-2 and fecha_prevision>0 and temps_pendent<0";}
				if ($_GET["bt"] == 3) { $sqli = $sqli." and id_estado<>-2 and pausada=1";}
				if ($_GET["bt"] == 4) { $sqli = $sqli." and id_estado<>-2 and id_usuario_destino=".$userid;}
				if ($_GET["bt"] == 5) { $sqli = $sqli." and id_estado<>-2 and fecha_prevision=0 and pausada=0";}
				$i = 4;
			} else {
				if ($i == 0) { $sqli = $sqli." and id_servicio = 0 and pausada=0"; }
				elseif ($i == 1) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision > 0 and pausada=0"; }
				elseif ($i == 2) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision=0 and pausada=0 and id_cliente<>(select id from sgm_clients where nif='B65702227' and visible=1)"; } 
				elseif ($i == 3) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision=0 and pausada=0 and id_cliente=(select id from sgm_clients where nif='B65702227' and visible=1)"; } 
				elseif ($i == 4) { $sqli = $sqli." and pausada=1"; }
				if (($soption == 200) and ($_GET["filtra"] == 1)) {
					$sqli = $sqli." order by fecha_inicio desc,id_estado desc";
				} else {
					if ($_GET["fil"] == 1) {
						$sqli = $sqli." order by fecha_prevision,id_cliente,id_usuario_destino";
					} elseif ($_GET["fil"] == 2) {
						$sqli = $sqli." order by id_cliente,fecha_prevision,id_usuario_destino";
					} elseif ($_GET["fil"] == 3) {
						$sqli = $sqli." order by id_usuario_destino,id_cliente,fecha_prevision";
					} else {
						if ($i == 1) {
							$sqli = $sqli." order by temps_pendent,id_cliente,id_servicio,id_usuario_destino";
						} elseif ($i == 4) {
							$sqli = $sqli." order by id_cliente,id_servicio,id_usuario_destino";
						}
					}
				}
			}
#		echo $sqli."<br>";
			$resulti = mysqli_query($dbhandle,convertSQL($sqli));
			while ($rowi = mysqli_fetch_array($resulti)) {
				$ver = 1;
				$novedades1 = 0;
				if ($_GET["bt"] == 4) { 
					$novedades1 = contarIncidenciasNovedades ($rowi["id"],$rowi["id_usuario_destino"]);
					if ($novedades1 == 0){ $ver = 0;}
				}
				if ($ver == 1){
					$estado_color = "White";
					$estado_color_letras = "Black";

					$sqlu = "select usuario from sgm_users where id=".$rowi["id_usuario_destino"];
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					$rowu = mysqli_fetch_array($resultu);
					$sqlc = "select servicio,id_contrato,temps_resposta from sgm_contratos_servicio where id=".$rowi["id_servicio"];
					$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
					$rowc = mysqli_fetch_array($resultc);
					$sqls = "select id_cliente,descripcion from sgm_contratos where id=".$rowc["id_contrato"];
					$results = mysqli_query($dbhandle,convertSQL($sqls));
					$rows = mysqli_fetch_array($results);
					if ($rowi["id_cliente"] != 0){
						$cliente = $rowi["id_cliente"];
					} elseif ($rows) {
						$cliente = $rows["id_cliente"];
					} else {
						$cliente = 0;
					}
					$sqlcc = "select id,nombre,alias from sgm_clients where id=".$cliente;
					$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
					$rowcc = mysqli_fetch_array($resultcc);

					if ($rowcc["id"] != $id_client_inc){
						if ($rowcc["id"] == 0){$nom_cli = $SinCliente;} else {$nom_cli = $rowcc["nombre"];}
						echo "<tr style=\"background-color:#D8D8D8;\"><td colspan=\"7\"></td><td><a href=\"index.php?op=1008&sop=100&id=".$rowcc["id"]."\"><b>".$rowcc["alias"]." (".$nom_cli.")</b><a></td><td colspan=\"4\"></td></tr>";
						$id_client_inc = $rowcc["id"];
					}

					if ($rowi["id_servicio"] == 0){
						$estado_color = "black";
						$estado_color_letras = "white";
					}

					$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]." and visible=1";
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
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
						echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1018&sop=2&id=".$rowi["id"].$adres."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" style=\"border:0px;\"><a></td>";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:50px;\">".$rowi["id"]."</td>";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:100px;\" nowrap>".$sla."</td>";

						$novedades = contarIncidenciasNovedades ($rowi["id"],$rowi["id_usuario_destino"]);
						if ($novedades > 0) {$novetats = '!!!';} else {$novetats = '';}

						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:150px;\" nowrap>".$fecha_prev."</td>";
						if (($rowi["id_estado"] <> -2) and ($soption == 200) and ($rowi["pausada"] != 1)){$estado_color = "#33CC33";}
						if ($rowi["asunto"] != ""){$asun = $rowi["asunto"];} else {$asun = $SinAsunto;}
						echo "<td style=\"vertical-align:top;background-color:".$estado_color.";\"><a href=\"index.php?op=1018&sop=100&id=".$rowi["id"].$adres."\" style=\"color:".$estado_color_letras.";\">".$novetats." ".$asun."<a></td>";
						if ($rowi["nivel_tecnico"] == 1) {$icon = "medal_bronze_3.png";} elseif ($rowi["nivel_tecnico"] == 2) {$icon = "medal_silver_3.png";} elseif ($rowi["nivel_tecnico"] == 3) {$icon = "medal_gold_3.png";} else {$icon = "";}
						if ($rowi["nivel_tecnico"] > 0) { $nivel_tech = $rowi["nivel_tecnico"]; } else { $nivel_tech = $Sin;}
						echo "<td style=\"vertical-align:top;text-align:center;width:30px;background-color:".$estado_color.";color:".$estado_color_letras.";\">".$nivel_tech."</td>";
						echo "<td style=\"text-align:left;vertical-align:top;width:50px;\"><img src=\"mgestion/pics/icons-mini/".$icon."\" alt=\"".$Nivel."\" title=\"".$Nivel."\" style=\"border:0px;\"></td>";
						if ($rowi["id_servicio"] > 0) {$texto_servicio = $rowc["servicio"]." (".$rows["descripcion"].")"; } elseif ($rowi["id_servicio"] == -1) { $texto_servicio = $SinContrato;} else {$texto_servicio = '';}
						echo "<td style=\"vertical-align:top;\"><a href=\"index.php?op=1011&sop=110&id=".$rowc["id_contrato"]."\" style=\"color:".$estado_color_letras.";\">".$texto_servicio."<a></td>";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:100px;\">".$rowu["usuario"]."</td>";

					$sqldd = "select sum(duracion) as temps from sgm_incidencias where visible=1 and fecha_inicio between ".$data1." and ".$data2." and id_incidencia=".$rowi["id"]."";
					$resultdd = mysqli_query($dbhandle,convertSQL($sqldd));
					$rowdd = mysqli_fetch_array($resultdd);
					$horad = $rowdd["temps"]/60;
					$horasd = explode(".",$horad);
					$minutosd = $rowdd["temps"] % 60;
					$temps_total += $rowdd["temps"];

					if (($_POST["dia"] != 0) or ($_GET["d"] != 0) or ($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0)){
						$duration = $horasd[0]."h. ".$minutosd."m. (".$horas[0]."h. ".$minutos."m.)";
					} else {
						$duration = $horas[0]."h. ".$minutos."m.";
					}
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:50px;\" nowrap>".$duration."</td>";
					if (($soption == 0) or ($soption == 1)){
						echo "<form action=\"index.php?op=1018&sop=3&id=".$rowi["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\">";
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:50px;\"><input type=\"number\" name=\"id_inc_rel\" style=\"width:100%\" min=\"1\"></td>";
						echo "<td class=\"submit\" style=\"vertical-align:top;\"><input type=\"Submit\" value=\"".$Relacion."\"></td>";
						echo "</form>";
					}
	#					echo "<td style=\"text-align:center;vertical-align:top;\">";
	#						echo "<a href=\"index.php?op=1018&sop=100&id=".$rowi["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px;\"><a>";
	#					echo "</td>";
					echo "</tr>";
					$sqlnd = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]."";
					$resultnd = mysqli_query($dbhandle,convertSQL($sqlnd));
					$rownd = mysqli_fetch_array($resultnd);
					$tiempo_total += $rownd["total"];
				}
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
			
			echo "<tr><td colspan=\"9\"></td><td style=\"text-align:left;\"><strong>";
			if ($temps_total > 0) {
				echo $horasd2[0]."h. ".$minutosd2[0]."m.(";
			}
			echo "".$horas[0]." h. ".$minutos[0]." m.)</strong></td><td></td></tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 2) {
		$sqlinc = "select id,id_cliente,asunto from sgm_incidencias where id=".$_GET["id"]."";
		$resultinc = mysqli_query($dbhandle,convertSQL($sqlinc));
		$rowinc = mysqli_fetch_array($resultinc);
		$sqlcc = "select nombre from sgm_clients where id=".$rowinc["id_cliente"];
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br>".$rowinc["id"]." - ".$rowinc["asunto"]." - ".$rowcc["nombre"]."<br><br>";
		echo boton(array("op=1018&sop=0&ssop=2&id=".$_GET["id"].$adres,"op=1018&sop=0".$adres),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 3) {
		if ($_GET["id"] != $_POST["id_inc_rel"]){
			$sqlinc = "select id,asunto from sgm_incidencias where visible=1 and id_incidencia=0";
			$resultinc = mysqli_query($dbhandle,convertSQL($sqlinc));
			while ($rowinc = mysqli_fetch_array($resultinc)){
				$ids[] = $rowinc["id"];
			}
			if ((is_numeric($_POST["id_inc_rel"])) and (in_array($_POST["id_inc_rel"],$ids))){
				$sqlinc1 = "select id,asunto from sgm_incidencias where id=".$_GET["id"];
				$resultinc1 = mysqli_query($dbhandle,convertSQL($sqlinc1));
				$rowinc1 = mysqli_fetch_array($resultinc1);
				$sqlinc2 = "select id,asunto from sgm_incidencias where id=".$_POST["id_inc_rel"];
				$resultinc2 = mysqli_query($dbhandle,convertSQL($sqlinc2));
				$rowinc2 = mysqli_fetch_array($resultinc2);
				echo "<center>";
				echo "<br><br>".$ayudaRelacionar."<br><br>".$_GET["id"]." y ".$_POST["id_inc_rel"];
				echo "<br>".$ayudaRelacionar2."<br>".$_GET["id"]."-'".$rowinc1["asunto"]."'<br>".$ayudaRelacionar3."<br>".$_POST["id_inc_rel"]."-'".$rowinc2["asunto"]."'<br><br>";
				echo boton(array("op=1018&sop=0&ssop=1&id=".$_GET["id"]."&id_inc_rel=".$_POST["id_inc_rel"].$adres,"op=1018&sop=0".$adres),array($Si,$No));
				echo "</center>";
			} else {
				echo boton(array("op=1018&sop=0"),array("&laquo; ".$Volver));
				mensageError($ErrorRelacion);
			}
		} else {
			echo boton(array("op=1018&sop=0"),array("&laquo; ".$Volver));
			mensageError($ErrorRelacion);
		}
	}
# fi vista general

#Mascara superior de la incidencia
	if (($soption >= 100) and ($soption < 200) and (($_GET["id"] != 0) or ($ssoption != 0))) {
		$insertada = 0;
		$editada = array();
		$puntero = 0;
		$cerrada = 0;
		if (($soption == 100) and ($ssoption > 0)) {
			$sqli = "select * from sgm_incidencias where id=".$_GET["id"];
			$resulti = mysqli_query($dbhandle,convertSQL($sqli));
			$rowi = mysqli_fetch_array($resulti);
			$sqlc = "select temps_resposta,id from sgm_contratos_servicio where id in (select id_servicio from sgm_incidencias where id=".$_GET["id"].")";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			if ($_GET["id"] > 0){
				$registro = date(U, $rowi["fecha_inicio"]);
			} else {
				$registro = date(U, strtotime($_POST["fecha_inicio"]));
			}
		}
		if (($soption == 100) and ($ssoption == 1)) {
		#insert incidencia#
			if (($_POST["id_servicio"] > 0) or ($_POST["id_servicio2"] > 0) or ($_POST["id_cliente"] > 0)){
				if ($_POST["asunto"] != ""){
					if ($_POST["id_servicio"] > 0) {$servicio = $_POST["id_servicio"];} else {$servicio = $_POST["id_servicio2"];}
					if ($_POST["id_cliente"] > 0) {$id_cliente = $_POST["id_cliente"];} else {$id_cliente = $_POST["id_cliente2"];}
					$fecha_registro_inicio = time();
					$fecha_inicio = date(U, strtotime($_POST["fecha_inicio"]));
					$fecha_prevision = fecha_prevision($servicio, $fecha_inicio);
					$camposInsert = "id_usuario_registro,id_usuario_destino,id_usuario_origen,id_servicio,fecha_registro_inicio,fecha_inicio,fecha_prevision,id_estado,id_entrada,notas_registro,asunto,id_cliente,pausada,visible_cliente,nivel_tecnico,notificar_cliente,desplazamiento";
					$datosInsert = array($userid,$_POST["id_usuario_destino"],$_POST["id_usuario_origen"],$servicio,$fecha_registro_inicio,$fecha_inicio,$fecha_prevision,"-1",$_POST["id_entrada"],$_POST["notas_registro"],$_POST["asunto"],$id_cliente,$_POST["pausada"],$_POST["visible_cliente"],$_POST["nivel_tecnico"],$_POST["notificar_cliente"],$_POST["desplazamiento"]);
					insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

					$sqlif = "select id,id_servicio,id_usuario_registro,id_usuario_origen from sgm_incidencias where fecha_prevision=".$fecha_prevision." and id_incidencia=0 order by id desc";
					$resultif = mysqli_query($dbhandle,convertSQL($sqlif));
					$rowif = mysqli_fetch_array($resultif);

					if (($rowif) and ($_POST["notificar_cliente"] == 1)){
						$insertada = 1;
						$id_incidencia_noti = $rowif["id"];
						$id_servicio_noti = $rowif["id_servicio"];
						$id_usuario_registro_noti = $rowif["id_usuario_registro"];
						$id_usuario_origen_noti = $rowif["id_usuario_origen"];
						$tipo = 3;
					}

					if ($_POST["duracion"] != ""){
						$fecha_registro_inicio = time();
						$fecha_inicio = date(U, strtotime($_POST["fecha_inicio"]));
						$camposInsert = "id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,duracion,visible_cliente,pausada,notificar_cliente";
						$datosInsert = array($rowif["id"],$userid,$fecha_registro_inicio,$fecha_inicio,$_POST["notas_registro"],$_POST["duracion"],$_POST["visible_cliente"],$_POST["pausada"],$_POST["notificar_cliente"]);
						insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

						if ($_POST["pausada"] == 1){
							$fecha_prevision = 0;
							$camposUpdate = array("fecha_prevision");
							$datosUpdate = array("0");
							updateFunction ("sgm_incidencias",$rowif["id"],$camposUpdate,$datosUpdate);
						}
						if ($_POST["finalizar"] == 1){
							if ($_POST["pausada"] == 0){
								$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowif["id"]."";
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								$rowd = mysqli_fetch_array($resultd);
								$total = $rowd["total"];
								if ((($_POST["notas_registro"] != "") or ($_POST["notas_conclusion"] != "")) and ($total > 0)){
									$sqlc = "select temps_resposta from sgm_contratos_servicio where id=(select id_servicio from sgm_incidencias where id=".$rowif["id"].")";
									$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
									$rowc = mysqli_fetch_array($resultc);
									if ($rowc["temps_resposta"] != 0){
										if ((calculSLA($_GET["id"],0)) > 0) { $sla = 1;} else { $sla = 0;}
									} else {
										$sla = 0;
									}
									$fecha_cierre = date("U", strtotime($_POST["fecha_inicio"]));
									$fecha_fi = time();
									$camposUpdate = array("notas_conclusion","fecha_registro_cierre","fecha_cierre","id_usuario_finalizacion","id_estado","sla");
									$datosUpdate = array($_POST["notas_registro"],$fecha_fi,$fecha_cierre,$userid,"-2",$sla);
									updateFunction ("sgm_incidencias",$rowif["id"],$camposUpdate,$datosUpdate);
								}
							} else {
								mensageError($ErrorFinalizacion);
							}
						}
					}
					if ($rowif["id_servicio"] > 0) {
						$sla_inc = calculSLA($rowif["id"],0);
						if ($rowif["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

						$camposUpdate = array("temps_pendent","fecha_prevision");
						$datosUpdate = array($sla_inc,$fecha_prevision);
						updateFunction ("sgm_incidencias",$rowif["id"],$camposUpdate,$datosUpdate);
					}
					$id_inc = $rowif["id"];
				} else {
					mensageError($ErrorSinAsunto);
				}
			} else {
				mensageError($ErrorSinServicioCliente);
			}
		}
		if (($soption == 100) and ($ssoption == 2)) {
		#update incidencia#
			if (($_POST["id_servicio"] > 0) or ($_POST["id_servicio2"] > 0) or ($_POST["id_cliente"] > 0)){
				if ($_POST["asunto"] != ""){
					if ($_POST["id_servicio"] > 0) {$servicio = $_POST["id_servicio"];} else {$servicio = $_POST["id_servicio2"];}
					if ($rowi["pausada"] == 0) {$prevision = fecha_prevision($servicio, $registro);} else {$prevision = 0;}
					if ($_POST["duracion"] == ""){ $duracion = 0; } else { $duracion = $_POST["duracion"]; }
					if ($_POST["id_cliente"] > 0) {$id_cliente = $_POST["id_cliente"];} else {$id_cliente = $_POST["id_cliente2"];}

					$notas_registro = str_replace("/","/ ",$_POST["notas_registro"]);
					
					$camposUpdate = array("id_usuario_origen","id_usuario_destino","fecha_inicio","id_entrada","notas_registro","id_servicio","asunto","fecha_prevision","duracion","id_cliente","visible_cliente","nivel_tecnico","notificar_cliente","desplazamiento");
					$datosUpdate = array($_POST["id_usuario_origen"],$_POST["id_usuario_destino"],date(U, strtotime($_POST["fecha_inicio"])),$_POST["id_entrada"],$notas_registro,$servicio,$_POST["asunto"],$prevision,$duracion,$id_cliente,$_POST["visible_cliente"],$_POST["nivel_tecnico"],$_POST["notificar_cliente"],$_POST["desplazamiento"]);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

					$sqli2 = "select * from sgm_incidencias where id=".$_GET["id"];
					$resulti2 = mysqli_query($dbhandle,convertSQL($sqli2));
					$rowi2 = mysqli_fetch_array($resulti2);
					if (($rowi2["notificar_cliente"] == 1)){
						if ($_POST["id_usuario_destino"] != $rowi["id_usuario_destino"]){
							$editada[$puntero] = 2;
							$puntero++;
							$id_incidencia_noti = $_GET["id"];
							$tipo = 4;
						}
						if ($notas_registro != $rowi["notas_registro"]){
							$editada[$puntero] = 3;
							$puntero++;
							$id_incidencia_noti = $_GET["id"];
							$tipo = 4;
						}
#						if (($_POST["id_usuario_destino"] != $rowi["id_usuario_destino"]) and ($notas_registro != $rowi["notas_registro"])) {
#							$editada[$puntero] = 4;
#							$puntero++;
#							$id_incidencia_noti = $_GET["id"];
#							$tipo = 4;
#						}
					}

					$sqlc = "select temps_resposta,id from sgm_contratos_servicio where id in (select id_servicio from sgm_incidencias where id=".$_GET["id"].")";
					$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
					$rowc = mysqli_fetch_array($resultc);
					$sla_inc = calculSLA($_GET["id"],0);
					if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

					$camposUpdate = array("temps_pendent","fecha_prevision");
					$datosUpdate = array($sla_inc,$fecha_prevision);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
					$id_inc = $rowincid["id"];
				} else {
					mensageError($ErrorSinAsunto);
				}
			} else {
				mensageError($ErrorSinServicioCliente);
			}
		}
		if (($soption == 100) and ($ssoption == 3)) {
		#finalizacion incidencia#
			if ($rowi["id_estado"] == -2){
				$camposInsert = "id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,notificar_cliente";
				$datosInsert = array($rowi["id"],$rowi["id_usuario_finalizacion"],$rowi["fecha_registro_cierre"],$rowi["fecha_cierre"],$rowi["notas_conclusion"],$rowi["notificar_cliente"]);
				insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

				$camposUpdate = array("notas_conclusion","fecha_registro_cierre","fecha_cierre","id_usuario_finalizacion","id_estado","sla");
				$datosUpdate = array('','','','','-1','');
				updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

				$sqlii = "select id from sgm_incidencias where id_incidencia=".$_GET["id"]." and notas_desarrollo='".$rowi["notas_conclusion"]."' and fecha_registro_inicio=".$rowi["fecha_registro_cierre"];
				$resultii = mysqli_query($dbhandle,convertSQL($sqlii));
				$rowii = mysqli_fetch_array($resultii);

				$sqlxx = "select * from sgm_incidencias where id=".$_GET["id"]." and id_estado='-1' and notificar_cliente=1";
				$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
				$rowxx = mysqli_fetch_array($resultxx);

				if ($rowxx){
					$cerrada = 2;
					$id_incidencia_noti = $rowii["id"];
					$tipo = 6;
				}
			} else {
				$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$_GET["id"]."";
				$resultd = mysqli_query($dbhandle,convertSQL($sqld));
				$rowd = mysqli_fetch_array($resultd);
				$total = $rowd["total"];
				
				$sqld1 = "select notas_registro,id_servicio,id_cliente from sgm_incidencias where id=".$_GET["id"]."";
				$resultd1 = mysqli_query($dbhandle,convertSQL($sqld1));
				$rowd1 = mysqli_fetch_array($resultd1);
				$sqld2 = "select id from sgm_contratos where id_cliente=".$rowd1["id_cliente"]." and visible=1 and activo=1";
				$resultd2 = mysqli_query($dbhandle,convertSQL($sqld2));
				$rowd2 = mysqli_fetch_array($resultd2);
				$serv = 1;
				if (($rowd2["id"] != '') and ($rowd1["id_servicio"] <= 0)) { $serv = 0; }

				if ((($rowd1["notas_registro"] != "") or ($_POST["notas_conclusion"] != ""))  and ($total > 0) and (strtotime($_POST["fecha_cierre"]) > 0) and ($serv == 1)){
					if ($rowc["temps_resposta"] != 0){
						$temps_pendent=(calculSLA($_GET["id"],1));
						if ($temps_pendent > 0) { $sla = 0;} else { $sla = 1;}
					} else {
						$sqld = "select temps_pendent from sgm_incidencias where id_incidencia=".$_GET["id"]."";
						$resultd = mysqli_query($dbhandle,convertSQL($sqld));
						$rowd = mysqli_fetch_array($resultd);
						$sla = 0;
						$temps_pendent = $rowd["temps_pendent"];
					}
					$fecha_cierre = date("U", strtotime($_POST["fecha_cierre"]));
					$fecha_fi = time();
					$camposUpdate = array("notas_conclusion","fecha_registro_cierre","fecha_cierre","id_usuario_finalizacion","id_estado","sla","temps_pendent","pausada");
					$datosUpdate = array($_POST["notas_conclusion"],$fecha_fi,$fecha_cierre,$userid,'-2',$sla,$temps_pendent,0);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
					
					$sqlxx = "select * from sgm_incidencias where id=".$_GET["id"]." and id_estado='-2' and notificar_cliente=1";
					$resultxx = mysqli_query($dbhandle,convertSQL($sqlxx));
					$rowxx = mysqli_fetch_array($resultxx);

					if ($rowxx){
						$cerrada = 1;
						$id_incidencia_noti = $_GET["id"];
						$tipo = 5;
					}
				} else {
					mensageError($ErrorFinalizacion);
				}
			}
		}
		if (($soption == 100) and ($ssoption == 4)) {
		#insert notes desenvolupament#
			if (($_POST["notas_desarrollo"] != "") and ($_POST["duracion"] != "")){
				$fecha_registro_inicio = time();
				$fecha_inicio = date(U, strtotime($_POST["fecha_inicio"]));
				$camposInsert = "id_incidencia,id_usuario_registro,fecha_registro_inicio,fecha_inicio,notas_desarrollo,duracion,visible_cliente,pausada,notificar_cliente,nivel_tecnico";
				$datosInsert = array($_GET["id"],$userid,$fecha_registro_inicio,$fecha_inicio,$_POST["notas_desarrollo"],$_POST["duracion"],$_POST["visible_cliente"],$_POST["pausada"],$_POST["notificar_cliente"],$_POST["nivel_tecnico"]);
				insertFunction ("sgm_incidencias",$camposInsert,$datosInsert);

				$sqlii = "select id from sgm_incidencias where id_incidencia=".$_GET["id"]." and notas_desarrollo='".comillas($_POST["notas_desarrollo"])."' and fecha_registro_inicio=".$fecha_registro_inicio;
				$resultii = mysqli_query($dbhandle,convertSQL($sqlii));
				$rowii = mysqli_fetch_array($resultii);
				if (($rowii) and ($_POST["notificar_cliente"] == 1)){
					$editada[$puntero] = 1;
					$puntero++;
					$id_incidencia_noti = $rowii["id"];
					$tipo = 4;
				}
			} elseif (($_POST["id_cliente"] == 0) and ($_POST["id_servicio"] == 0)) {
				mensageError($ErrorSinTextoDuracion);
			}

			$sqli2 = "select * from sgm_incidencias where id=".$_GET["id"];
			$resulti2 = mysqli_query($dbhandle,convertSQL($sqli2));
			$rowi2 = mysqli_fetch_array($resulti2);
			if ($rowi2["notificar_cliente"] == 1){
				if ($rowi["id_usuario_destino"] == 0){
					$camposUpdate = array("id_usuario_destino");
					$datosUpdate = array($userid);
					updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
					$editada[$puntero] = 2;
					$puntero++;
#					$id_incidencia_noti = $_GET["id"];
					$tipo = 4;
				}

#				if (($rowi["id_usuario_destino"] == 0) and ($_POST["notas_desarrollo"] != "")) {
#					$editada[$puntero] = 4;
#					$puntero++;
#					$id_incidencia_noti = $rowii["id"];
#					$tipo = 4;
#				}
			}
			calculPausaIncidencia($_GET["id"]);

			$sla_inc = calculSLA($_GET["id"],0);
			if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

			$camposUpdate = array("temps_pendent","fecha_prevision");
			$datosUpdate = array($sla_inc,$fecha_prevision);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);

#			var_dump($editada);
		}
		if (($soption == 100) and ($ssoption == 5) and ($_POST["ejecutar"] == 1)) {
		#update notes desenvolupament#
			if ($_POST["duracion"] == ""){ $duracion = 0; } else { $duracion = $_POST["duracion"]; }

			$sqlx = "select notas_desarrollo from sgm_incidencias where id=".$_GET["id_not"];
			$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
			$rowx = mysqli_fetch_array($resultx);

			$sqlix = "select * from sgm_incidencias where id_incidencia=".$_GET["id"];
			$resultix = mysqli_query($dbhandle,$sqlix);
			$rowix = mysqli_fetch_array($resultix);

			if ($_POST["id_incidencia"] == 0){
				$camposUpdate = array("id_usuario_registro","id_incidencia","fecha_inicio","notas_registro");
				$datosUpdate = array($_POST["id_usuario_registro"],$_POST["id_incidencia"],date(U, strtotime($_POST["fecha_inicio"])),$_POST["notas_desarrollo"]);
				updateFunction ("sgm_incidencias",$_GET["id_not"],$camposUpdate,$datosUpdate);
			} else {
				$camposUpdate = array("id_usuario_registro","id_incidencia","fecha_inicio","visible_cliente","pausada","notas_desarrollo","duracion","notificar_cliente","nivel_tecnico");
				$datosUpdate = array($_POST["id_usuario_registro"],$_POST["id_incidencia"],date(U, strtotime($_POST["fecha_inicio"])),$_POST["visible_cliente"],$_POST["pausada"],$_POST["notas_desarrollo"],$duracion,$_POST["notificar_cliente"],$_POST["nivel_tecnico"]);
				updateFunction ("sgm_incidencias",$_GET["id_not"],$camposUpdate,$datosUpdate);
				if ((($rowx["notas_desarrollo"] != $_POST["notas_desarrollo"]) or ($rowix["pausada"] != $_POST["pausada"])) and ($_POST["notificar_cliente"] == 1)){
					$editada[$puntero] = 1;
					$puntero++;
					$tipo = 4;
					$id_incidencia_noti = $_GET["id_not"];
				}
			}
			
			calculPausaIncidencia($_GET["id"]);

			$sla_inc = calculSLA($_GET["id"],0);
			if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

			$camposUpdate = array("temps_pendent","fecha_prevision");
			$datosUpdate = array($sla_inc,$fecha_prevision);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($soption == 100) and ($ssoption == 6)) {
		#eliminar incidencia nota#
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_incidencias",$_GET["id_not"],$camposUpdate,$datosUpdate);

			calculPausaIncidencia($_GET["id"]);

			$sla_inc = calculSLA($_GET["id"],0);
			if ($rowc["temps_resposta"] != 0){$fecha_prevision = fecha_prevision($rowc["id"], $registro);}else{$fecha_prevision = 0;}

			$camposUpdate = array("temps_pendent","fecha_prevision");
			$datosUpdate = array($sla_inc,$fecha_prevision);
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($soption == 100) and ($ssoption == 7)) {
		#Añadir a control de versiones#
			$sqlx = "select * from sgm_incidencias where id=".$_GET["id"];
			$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
			$rowx = mysqli_fetch_array($resultx);
			$comentarios = $rowx["asunto"]."\r\n".$rowx["notas_registro"]."\r\n";
			$sqlx2 = "select * from sgm_incidencias where id_incidencia=".$rowx["id"];
			$resultx2 = mysqli_query($dbhandle,convertSQL($sqlx2));
			while ($rowx2 = mysqli_fetch_array($resultx2)){
				if ($rowx["notas_registro"] != $rowx2["notas_desarrollo"]){
					$comentarios .= $rowx2["notas_desarrollo"]."\r\n";
				}
			}
			if ($rowx["notas_registro"] != $rowx["notas_conclusion"]){
				$comentarios .= $rowx["notas_conclusion"]."\r\n";
			}
			$camposInsert = "fecha,comentarios,id_usuario";
			$datosInsert = array(date("Y-m-d",$rowx["fecha_cierre"]),comillas($comentarios),$rowx["id_usuario_destino"]);
			insertFunction ("sim_control_versiones",$camposInsert,$datosInsert);

			$camposUpdate = array("control_version");
			$datosUpdate = array("1");
			updateFunction ("sgm_incidencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		
		if (($insertada==1) or (!empty($editada)) or ($cerrada>=1)){
			if ($id_servicio_noti == ''){$id_servicio_noti = $rowi["id_servicio"]; $id_usuario_registro_noti = $rowi["id_usuario_registro"]; $id_usuario_origen_noti = $rowi["id_usuario_origen"];}
			envioNotificacionIncidencia($id_incidencia_noti,$id_servicio_noti,$id_usuario_registro_noti,$id_usuario_origen_noti,$insertada,$editada,$cerrada,$relacionada,$eliminada,$tipo);
		}
		
		if ($_GET["id"] != ""){$id_inc= $_GET["id"];}
		if ($id_inc != ""){
			$sqlincid = "select * from sgm_incidencias where id=".$id_inc;
			$resultincid = mysqli_query($dbhandle,convertSQL($sqlincid));
			$rowincid = mysqli_fetch_array($resultincid);
		}
#		echo $sql;
		echo "<table cellpadding=\"1\" cellspacing=\"2\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1018&sop=100&id=".$id_inc."\" style=\"color:white;\">".$Datos." ".$Generales."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1018&sop=120&id=".$id_inc."\" style=\"color:white;\">".$Notificaciones."</a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:200px;padding : 5px 10px 10px 10px;\">";
					echo "<strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">ID. ".$rowincid["id"]."</strong>";
					if ($rowincid["id"] != ""){
						$sqlu = "select usuario from sgm_users where validado=1 and activo=1 and id=".$rowincid["id_usuario_registro"];
					} else {
						$sqlu = "select usuario from sgm_users where validado=1 and activo=1 and id=".$userid;
					}
						$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
						$rowu = mysqli_fetch_array($resultu);
					echo "<br>".$Usuario." ".$Registro." : ".$rowu["usuario"];
					$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowincid["id"]." and visible=1";
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					$total = $rowd["total"];
					$hora = $total/60;
					$horas = explode(".",$hora);
					$minutos = $total % 60;
					echo "<br>".$Tiempo." : ".$horas[0]." ".$Horas." ".$minutos." ".$Minutos;
					$sqlpa = "select pausada from sgm_incidencias where id_incidencia=".$rowincid["id"]." and visible=1 order by fecha_inicio desc";
					$resultpa = mysqli_query($dbhandle,convertSQL($sqlpa));
					$rowpa = mysqli_fetch_array($resultpa);
					if ($rowincid["id_estado"] == -2) {
						$imagen_estado = "control_stop_blue.png";
						$mensa = $Finalizada;
					} else {
						if (($rowpa["pausada"] == 1) or ($rowincid["pausada"] == 1)){
							$imagen_estado = "control_pause_blue.png";
							$mensa = $Pausada;
						} else {
							$imagen_estado = "control_play_blue.png";
							$mensa = $Activa;
						}
					}
					echo "<br>".$Estado." : <img src=\"mgestion/pics/icons-mini/".$imagen_estado."\" alt=\"".$mensa."\" title=\"".$mensa."\" style=\"border:0px;vertical-align:middle;\">";
				echo "</td>";
				if ($rowincid["id_cliente"] != ""){
					$sqlcli1 = "select * from sgm_clients where visible=1 and id=".$rowincid["id_cliente"];
					$resultcli1 = mysqli_query($dbhandle,convertSQL($sqlcli1));
					$rowcli1 = mysqli_fetch_array($resultcli1);
					echo "<td style=\"border:1px black solid;\">";
						echo "<table class=\"lista\">";
							echo "<tr>";
								echo "<td style=\"vertical-align:top;margin:5px 10px 10px 10px;width:300px;padding:5px 10px 10px 10px;\">";
									echo "<a href=\"index.php?op=1008&sop=100&id=".$rowcli1["id"]."\"><strong>".$rowcli1["nombre"]." ".$rowcli1["cognom1"]." ".$rowcli1["cognom2"]."</strong></a>";
									echo "<br><strong>".$rowcli1["direccion"]." </strong>";
									if ($rowcli1["cp"] != "") {echo " (".$rowcli1["cp"].") ";}
									echo "<strong>".$rowcli1["poblacion"]."</strong>";
									if ($rowcli1["provincia"] != "") {echo " (".$rowcli1["provincia"].")";}
									if ($rowcli1["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$rowcli1["telefono"]."</strong>"; }
									if ($rowcli1["mail"] != "") { echo " ".$Email." : <a href=\"mailto:".$rowcli1["mail"]."\"><strong>".$rowcli1["mail"]."</strong></a>"; }
									if ($rowcli1["url"] != "") { echo " ".$Web." : <strong>".$rowcli1["url"]."</strong>"; }
								echo "</td>";
								echo "<td style=\"vertical-align:top\">";
									echo "<table cellpadding=\"0\">";
										$sqlcli2 = "select * from sgm_clients_contactos where visible=1 and id_client=".$rowincid["id_cliente"];
										$resultcli2 = mysqli_query($dbhandle,convertSQL($sqlcli2));
										while ($rowcli2 = mysqli_fetch_array($resultcli2)){
											echo "<tr>";
												echo "<td style=\"width:150px;text-align:left;\">".$rowcli2["nombre"]." ".$rowcli2["apellido1"]." ".$rowcli2["apellido2"]."</td>";
												echo "<td style=\"width:200px;text-align:left;\"><a href=\"mailto:".$rowcli2["mail"]."\">".$rowcli2["mail"]."</a></td>";
												echo "<td style=\"width:150px;text-align:left;\">".$rowcli2["telefono"]."</td>";
											echo "</tr>";
										}
									echo "</table>";
								echo "</td>";
								echo "<td style=\"vertical-align:top\">";
									echo "<a href=\"index.php?op=1008&sop=122&ssop=1&id=".$rowcli1["id"]."\"><img src=\"mgestion/pics/icons-mini/user_add.png\" alt=\"Cliente\" title=\"".$Anadir." ".$Contacto."\" border=\"0\"></a>&nbsp;&nbsp;";
									echo "<a href=\"index.php?op=1024&sop=0&id_cli=".$rowcli1["id"]."\"><img src=\"mgestion/pics/icons-mini/key.png\" alt=\"Contraseñas\" title=\"".$Ver." ".$Contrasenas."\" border=\"0\"></a>&nbsp;&nbsp;";
									$sqlcon = "select * from sgm_contratos where visible=1 and id=(select id_contrato from sgm_contratos_servicio where id=".$rowincid["id_servicio"].")";
									$resultcon = mysqli_query($dbhandle,convertSQL($sqlcon));
									$rowcon = mysqli_fetch_array($resultcon);
									echo "<a href=\"index.php?op=1011&sop=200&id_cli=".$rowcli1["id"]."\"><img src=\"mgestion/pics/icons-mini/report.png\" alt=\"Contratos\" title=\"".$Ver." ".$Contratos."\" border=\"0\"></a>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				}
				$sqlid = "select idioma from sgm_idiomas where visible=1 and id=(select id_idioma from sgm_clients where visible=1 ";
				$sqlid .= "and id=(select id_cliente from sgm_contratos where visible=1 ";
				$sqlid .= "and id=(select id_contrato from sgm_contratos_servicio where visible=1 and id=".$rowincid["id_servicio"].")))";
				$resultid = mysqli_query($dbhandle,convertSQL($sqlid));
				$rowid = mysqli_fetch_array($resultid);
				echo "<td style=\"vertical-align:top;\">";
					echo "<table class=\"lista\">";
						echo "<tr>";
							if ($rowid["idioma"] != ""){echo "<td><img src=\"mgestion/pics/flags/".$rowid["idioma"].".png\" style=\"border:0px;width:100%;\"\"></td>";}
						echo "</tr>";
					echo "</table>";
				echo "</td>";
		#				echo "<td style=\"vertical-align:top\">";
#					echo "<table cellpadding=\"0\">";
#						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1018&sop=195&id=".$rowincid["id"]."\" style=\"color:white;\">".$Opciones."</a></td></tr>";
#					echo "</table>";
#				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	#detall tickets#
	if ($soption == 100) {
		if ($id_inc != ""){
			$fecha_reg = date("Y-m-d H:i:s", $rowincid["fecha_inicio"]);
			echo "<form action=\"index.php?op=1018&sop=100&ssop=2&id=".$id_inc."&id_cli=".$_GET["id_cli"]."\" method=\"post\" name=\"form1\" ENCTYPE=\"multipart/form-data\">";
		} else { 
			echo "<form action=\"index.php?op=1018&sop=100&ssop=1\" method=\"post\" name=\"form1\">";
			if ($_POST["fecha_inicio"] != "") {$fecha_reg = $_POST["fecha_inicio"];} else {$fecha_reg = date("Y-m-d H:i:s", time ());}
			echo "<input type=\"Hidden\" name=\"fecha_inicio\" value=\"".$fecha_reg."\">";
		}
		#inicio de la tabla de modificación o inserción.
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"text-align:left;vertical-align:top;width:30%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Registro." :</th>";
							echo "<td><input type=\"text\" name=\"fecha_inicio\" style=\"width:150px\" value=\"".$fecha_reg."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Origen." :</th>";
							echo "<td><select name=\"id_entrada\" style=\"width:150px\">";
								echo "<option value=\"0\">-</option>";
								$sqle = "select id,entrada from sgm_incidencias_entrada order by entrada";
								$resulte = mysqli_query($dbhandle,convertSQL($sqle));
								while ($rowe = mysqli_fetch_array($resulte)) {
									if (($rowe["id"] == $rowincid["id_entrada"]) or ($_POST["id_entrada"] == $rowe["id"]) or ($_GET["id_entrada"] == $rowe["id"])){
										echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["entrada"]."</option>";
									} else {
										echo "<option value=\"".$rowe["id"]."\">".$rowe["entrada"]."</option>";
									}
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Usuario." ".$Destino." :</th>";
							echo "<td><select name=\"id_usuario_destino\" style=\"width:150px\">";
								echo "<option value=\"0\">-</option>";
								$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 order by usuario";
								$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
								while ($rowu = mysqli_fetch_array($resultu)) {
									if ($id_inc != ""){
										if ($rowu["id"] == $rowincid["id_usuario_destino"]){
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
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Nivel." ".$Tecnico." :</th>";
							echo "<td><select name=\"nivel_tecnico\" style=\"width:150px\">";
								if ($rowincid["nivel_tecnico"] == 1){
									echo "<option value=\"1\" selected>1</option>";
									echo "<option value=\"2\">2</option>";
									echo "<option value=\"3\">3</option>";
								} elseif  ($rowincid["nivel_tecnico"] == 2){
									echo "<option value=\"1\">1</option>";
									echo "<option value=\"2\" selected>2</option>";
									echo "<option value=\"3\">3</option>";
								} elseif  ($rowincid["nivel_tecnico"] == 3){
									echo "<option value=\"1\">1</option>";
									echo "<option value=\"2\">2</option>";
									echo "<option value=\"3\" selected>3</option>";
								} else {
									echo "<option value=\"1\">1</option>";
									echo "<option value=\"2\">2</option>";
									echo "<option value=\"3\">3</option>";
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
					if ($id_inc == ""){
						echo "<tr>";
							echo "<th style=\"text-align:right;\">".$Duracion." (Min) :</th>";
							echo "<td><input type=\"number\" min=\"1\" name=\"duracion\" style=\"width:50px\" value=\"".$duracion."\"></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Notificar." ".$Cliente." :</th>";
							echo "<td><select name=\"notificar_cliente\" style=\"width:50px\">";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Desplazamiento." :</th>";
							echo "<td><select name=\"desplazamiento\" style=\"width:50px\">";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Visible." ".$Cliente." :</th>";
							echo "<td><select name=\"visible_cliente\" style=\"width:50px\">";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							echo "</select></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Pausar." ".$Incidencia." :</th>";
							echo "<td><select name=\"pausada\" style=\"width:50px\">";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;\">".$Finalizar." :</th>";
							echo "<td><select name=\"finalizar\" style=\"width:50px\">";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							echo "</select></td>";
						echo "</tr>";
					}
					if ($id_inc != ""){
						echo "<tr>";
							echo "<th style=\"text-align:right;width:100px;\">".$Notificar." ".$Cliente." :</th>";
							echo "<td><select name=\"notificar_cliente\" style=\"width:50px\">";
							if ($rowincid["notificar_cliente"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;width:100px;\">".$Desplazamiento." :</th>";
							echo "<td><select name=\"desplazamiento\" style=\"width:50px\">";
							if ($rowincid["desplazamiento"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
						echo "</tr><tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:100px;\">".$Visible." ".$Cliente." :</th>";
							echo "<td><select name=\"visible_cliente\" style=\"width:50px\">";
							if ($rowincid["visible_cliente"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
							echo "</select></td>";
						echo "</tr>";
					}
					echo "</table>";
				echo "</td>";
				echo "<td style=\"text-align:right;vertical-align:top;width:60%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						$sqlcl = "select nif from sgm_dades_origen_factura";
						$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
						$rowcl = mysqli_fetch_array($resultcl);
						$sqlcli = "select id from sgm_clients where visible=1 and nif='".$rowcl["nif"]."'";
						$resultcli = mysqli_query($dbhandle,convertSQL($sqlcli));
						$rowcli = mysqli_fetch_array($resultcli);
						echo "<input type=\"Hidden\" name=\"id_cliente2\" value=\"".$rowcli["id"]."\">";
						echo "<tr>";
							echo "<th style=\"text-align:left;vertical-align:top;width:13%;\">".$Servicio." SIM :</th>";
							echo "<td><select name=\"id_servicio\" id=\"id_servicio\" style=\"width:100%\" onchange=\"desplegableCombinado()\">";
								echo "<option value=\"0\">-</option>";
								$sqlc = "select id,descripcion from sgm_contratos where visible=1 and id_cliente=".$rowcli["id"]." and activo=1 order by num_contrato";
								$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
								while ($rowc = mysqli_fetch_array($resultc)) {
									$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"];
									$results = mysqli_query($dbhandle,convertSQL($sqls));
									while ($rows = mysqli_fetch_array($results)){
										if ($_POST["id_servicio"] == $rows["id"]){
											echo "<option value=\"".$rows["id"]."\" selected>(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
										} elseif (($_POST["id_servicio"] == "") and ($rowincid["id_servicio"] == $rows["id"])){
											echo "<option value=\"".$rows["id"]."\" selected>(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
										} else {
											echo "<option value=\"".$rows["id"]."\">(".$rowc["descripcion"].")".$rows["servicio"]."</option>";
										}
									}
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:left;vertical-align:top;\">".$Cliente." :</th>";
							echo "<td><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:100%\" onchange=\"desplegableCombinado2()\">";
								echo "<option value=\"0\">-</option>";
								$sqlcl1 = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id<>".$rowcli["id"]." and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
								$resultcl1 = mysqli_query($dbhandle,convertSQL($sqlcl1));
								while ($rowcl1 = mysqli_fetch_array($resultcl1)){
									if ($_POST["id_cliente"] == $rowcl1["id"]){
										echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]." ".$rowcl1["cognom1"]." ".$rowcl1["cognom2"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl1["id"])){
										echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]." ".$rowcl1["cognom1"]." ".$rowcl1["cognom2"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == "") and ($rowincid["id_cliente"] == $rowcl1["id"])){
										echo "<option value=\"".$rowcl1["id"]."\" selected>- ".$rowcl1["nombre"]." ".$rowcl1["cognom1"]." ".$rowcl1["cognom2"]."</option>";
									} else {
										echo "<option value=\"".$rowcl1["id"]."\">- ".$rowcl1["nombre"]." ".$rowcl1["cognom1"]." ".$rowcl1["cognom2"]."</option>";
									}
								}
								$sqlcl = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id not in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
								$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
								while ($rowcl = mysqli_fetch_array($resultcl)){
									if ($_POST["id_cliente"] == $rowcl["id"]){
										echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == $rowcl["id"])){
										echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."</option>";
									} elseif (($_POST["id_cliente"] == "") and ($_GET["id_cli"] == "") and ($rowincid["id_cliente"] == $rowcl["id"])){
										echo "<option value=\"".$rowcl["id"]."\" selected> ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."</option>";
									} else {
										echo "<option value=\"".$rowcl["id"]."\"> ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."</option>";
									}
								}
							echo "</select></td>";
						echo "<tr>";
						echo "</tr>";
							echo "<th style=\"text-align:left;vertical-align:top;\">(".$Contrato.") ".$Servicio." : </th>";
							echo "<td><select name=\"id_servicio2\" id=\"id_servicio2\" style=\"width:100%;\">";
									if (($_POST["id_cliente"] == 0) and ($rowincid["id_cliente"] == 0) and ($_GET["id_cli"] == 0)){
										echo "<option value=\"0\">-</option>";
									}
									if (($_POST["id_servicio2"] == "-1") or ($rowincid["id_servicio"] == "-1")){
										echo "<option value=\"-1\" selected>".$SinContrato."</option>";
									} else {
										echo "<option value=\"-1\">".$SinContrato."</option>";
									}
									if ($rowincid["id_servicio"] == ''){$rowincid["id_servicio"]=0;}
									if ($_POST["id_cliente"] != ""){
										$sqlc2 = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and (activo=1 or id in (select id_contrato from sgm_contratos_servicio where id=".$rowincid["id_servicio"].")) and id_cliente=".$_POST["id_cliente"]."";
									} elseif ($_GET["id_cli"] != ""){
										$sqlc2 = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and (activo=1 or id in (select id_contrato from sgm_contratos_servicio where id=".$rowincid["id_servicio"].")) and id_cliente=".$_GET["id_cli"]."";
									} elseif ($rowincid["id_cliente"] != ""){
										$sqlc2 = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and (activo=1 or id in (select id_contrato from sgm_contratos_servicio where id=".$rowincid["id_servicio"].")) and id_cliente=".$rowincid["id_cliente"]." order by fecha_ini desc";
									}
									$resultc2 = mysqli_query($dbhandle,convertSQL($sqlc2));
									while ($rowc2 = mysqli_fetch_array($resultc2)){
										$sqlclie = "select * from sgm_clients where visible=1 and id=".$rowc2["id_cliente_final"]." order by nombre";
										$resultclie = mysqli_query($dbhandle,convertSQL($sqlclie));
										$rowclie = mysqli_fetch_array($resultclie);
										$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc2["id"]." order by servicio";
										$results = mysqli_query($dbhandle,convertSQL($sqls));
										while ($rows = mysqli_fetch_array($results)){
											if ($_POST["id_servicio2"] == $rows["id"]){
												echo "<option value=\"".$rows["id"]."\" selected>(".$rowc2["descripcion"].")".$rows["servicio"]."</option>";
											} elseif (($_POST["id_servicio2"] == "") and ($rowincid["id_servicio"] == $rows["id"])){
												echo "<option value=\"".$rows["id"]."\" selected>(".$rowc2["descripcion"].")".$rows["servicio"]."</option>";
											} else {
												echo "<option value=\"".$rows["id"]."\">(".$rowc2["descripcion"].")".$rows["servicio"]."</option>";
											}
										}
									}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th style=\"text-align:left;vertical-align:top;\">".$Usuario." ".$Origen." :</th>";
							$count=0;
							echo "<td><select name=\"id_usuario_origen\" id=\"id_usuario_origen\" style=\"width:100%\">";
								if (($_POST["id_cliente"] == "") and ($rowincid["id_cliente"] == "") and ($_GET["id_cli"] == "") and ($rowcli["id"] == "")){
									echo "<option value=\"0\">-</option>";
								}
								if ($_POST["id_cliente"] > 0){
									$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and usuario not like 'admin_%' and id in (select id_user from sgm_users_clients where id_client=".$_POST["id_cliente"].") order by usuario";
								} elseif ($rowincid["id_cliente"] > 0){
									$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and usuario not like 'admin_%' and id in (select id_user from sgm_users_clients where id_client=".$rowincid["id_cliente"].") order by usuario";
								} elseif ($_GET["id_cli"] > 0){
									$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and usuario not like 'admin_%' and id in (select id_user from sgm_users_clients where id_client=".$_GET["id_cliente"].") order by usuario";
								} else {
									$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and usuario not like 'admin_%' and id in (select id_user from sgm_users_clients where id_client=".$rowcli["id"].") order by usuario";
								}
								$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
								while ($rowu = mysqli_fetch_array($resultu)) {
									if ($rowu["id"] == $_POST["id_usuario_origen"]){
										echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
									} elseif (($_POST["id_usuario_origen"] == "") and ($rowu["id"] == $rowincid["id_usuario_origen"])){
										echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
									} elseif ($rowu["id"] == $userid){
										echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
									} else {
										echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
									}
									$count++;
								}
								if ($count == 0){
									$sqlu = "select id,nombre,apellido1,apellido2 from sgm_clients_contactos where visible=1 and id_client=".$rowincid["id_cliente"];
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)) {
										echo "<option value=\"".$rowu["id"]."\">".$rowu["nombre"]." ".$rowu["apellido1"]." ".$rowu["apellido2"]."</option>";
									}
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><th style=\"text-align:left;vertical-align:top;\">".$Asunto." :</th></tr>";
						if ($rowincid["asunto"] != ""){$asunto = $rowincid["asunto"];} else {$asunto = $_POST["asunto"];}
						if ($rowincid["notas_registro"] != ""){$notas_registro = $rowincid["notas_registro"];} else {$notas_registro = $_POST["notas_registro"];}
						if ($rowincid["duracion"] != ""){$duracion = $rowincid["duracion"];} else {$duracion = $_POST["duracion"];}
						echo "<tr><td colspan=\"2\"><input type=\"text\" name=\"asunto\" style=\"width:100%;\" value=\"".$asunto."\" required></td></tr>";
						echo "<tr><th colspan=\"2\" style=\"text-align:left;vertical-align:top;\">".$Notas." ".$Registro." :</th></tr>";
						echo "<tr><td colspan=\"2\"><textarea name=\"notas_registro\" style=\"width:100%;\" rows=\"4\">".$notas_registro."</textarea></td></tr>";
							echo "<td style=\"vertical-align:top;\" class=\"Submit\">";
								if ($rowincid["id_estado"] != -2){
									echo "<input type=\"Submit\" value=\"".$Guardar."\" >";
								}
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</form>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:10%;\">";
						$sqlice = "select id,tipo from sgm_incidencias_correos_enviados where id_incidencia=".$rowincid["id"];
						$resultice = mysqli_query($dbhandle,convertSQL($sqlice));
						while ($rowice = mysqli_fetch_array($resultice)){
							if (($rowice["tipo"] == 1) or ($rowice["tipo"] == 3)){
								echo "<a href=\"index.php?op=1000&id=".$rowice["id"]."\" onmouseover=\"NewWindow(this.href,'name','800','400','yes');return false;\">".$Notificacion.": ".$Insertada."</a><br>";
							}
							if (($rowice["tipo"] == 8)){
								echo "<a href=\"index.php?op=1000&id=".$rowice["id"]."\" onmouseover=\"NewWindow(this.href,'name','800','400','yes');return false;\">".$Notificacion.": ".$Eliminada."</a><br>";
							}
						}
						echo "<br>".$Documentos." ".$Adjuntos."<br>";
						$sql = "select id,nombre from sgm_files_tipos order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							$sqlele = "select id,name,size from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=4 and id_elemento=".$_GET["id"];
							$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
							while ($rowele = mysqli_fetch_array($resultele)) {
									echo "<a href=\"".$urloriginal."/archivos/incidencias/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong><br>";
							}
						}
				echo "&nbsp;</td>";
			echo "</tr>";
		if ($id_inc != ""){
			echo "<form action=\"index.php?op=1018&sop=100&ssop=4&id=".$rowincid["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\" name=\"form1\">";
			echo "<tr>";
				echo "<td style=\"text-align:left;vertical-align:top;width:30%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr><td>&nbsp;</td></tr>";
						$hoy = date("Y-m-d H:i:s", time ());
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Registro." :</th><td><input type=\"text\" name=\"fecha_inicio\" style=\"width:150px\" value=\"".$hoy."\"></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Duracion." (".$Minutos.") :</th><td><input type=\"number\" min=\"1\" name=\"duracion\" style=\"width:50px\"></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Notificar." ".$Cliente." :</th>";
							echo "<td><select name=\"notificar_cliente\" style=\"width:50px\">";
								if ($rowincid["notificar_cliente"] == 0){
									echo "<option value=\"0\" selected>".$No."</option>";
									echo "<option value=\"1\">".$Si."</option>";
								} else {
									echo "<option value=\"0\">".$No."</option>";
									echo "<option value=\"1\" selected>".$Si."</option>";
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<th style=\"text-align:right;vertical-align:top;\">".$Nivel." ".$Tecnico." :</th>";
							echo "<td><select name=\"nivel_tecnico\" style=\"width:50px\">";
								echo "<option value=\"1\" selected>1</option>";
								echo "<option value=\"2\">2</option>";
								echo "<option value=\"3\">3</option>";
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Visible." ".$Cliente." :</th>";
							echo "<td><select name=\"visible_cliente\" style=\"width:50px\">";
								if ($rowincid["visible_cliente"] == 0){
									echo "<option value=\"0\" selected>".$No."</option>";
									echo "<option value=\"1\">".$Si."</option>";
								} else {
									echo "<option value=\"0\">".$No."</option>";
									echo "<option value=\"1\" selected>".$Si."</option>";
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Pausar." ".$Incidencia." :</th>";
							echo "<td><select name=\"pausada\" style=\"width:50px\">";
							if ($rowincid["pausada"] == 0){
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
					echo "<table cellspacing=\"0\" style=\"width:100%\">";
						echo "<tr><th style=\"text-align:left;vertical-align:top;\">".$Notas." ".$Desarrollo." :</th></tr>";
						if (($_POST["notas_desarrollo"] != "") and ($_POST["duracion"] != "")){
							echo "<tr><td><textarea name=\"notas_desarrollo\" style=\"width:100%;\" rows=\"5\"></textarea></td></tr>";
						} else {
							echo "<tr><td><textarea name=\"notas_desarrollo\" style=\"width:100%;\" rows=\"5\">".$_POST["notas_desarrollo"]."</textarea></td></tr>";
						}
						if ($rowincid["id_estado"] != -2){
							echo "<tr><td class=\"Submit\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td></tr>";
						}
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:10%;\">&nbsp;";
				echo "</td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlc = "select * from sgm_incidencias where id_incidencia=".$id_inc." and visible=1 order by fecha_inicio asc";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			while ($rowc = mysqli_fetch_array($resultc)) {
				echo "<form action=\"index.php?op=1018&sop=100&ssop=5&id=".$id_inc."&id_not=".$rowc["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\" name=\"form1\">";
					echo "<input type=\"Hidden\" name=\"ejecutar\" value=\"1\">";
					$fecha = date("Y-m-d H:i:s", $rowc["fecha_inicio"]);
					echo "<tr>";
					if (($rowc["id_usuario_registro"] == $userid) or ($admin == true)){$color_td = "white";} else {$color_td = "silver";}
					echo "<td style=\"text-align:left;vertical-align:top;width:30%;\">";
						echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%;\">";
							echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">ID. ".$Incidencia." :</th><td><input type=\"number\" min=\"0\" name=\"id_incidencia\" style=\"width:150px\" value=\"".$rowc["id_incidencia"]."\"></td></tr>";
							echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;\">".$Fecha." :</th>";
							if ($rowc["id_usuario_registro"] == $userid){
								echo "<td><input type=\"text\" name=\"fecha_inicio\" style=\"width:150px\" value=\"".$fecha."\"></td></tr>";
							} else {
								echo "<td>".$fecha."</td></tr>";
								echo "<input type=\"hidden\" name=\"fecha_inicio\" value=\"".$fecha."\">";
							}
							echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;\">".$Usuario." :</th>";
							if (($rowc["id_usuario_registro"] == $userid) or ($rowc["id_usuario_registro"] == 0)){
								echo "<td><select name=\"id_usuario_registro\" style=\"width:150px\">";
								echo "<option value=\"0\">-</option>";
									$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 order by usuario";
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)) {
											if ($rowu["id"] == $rowc["id_usuario_registro"]){
												echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
											} else {
												echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
											}
									}
								echo "</select></td>";
							} else {
								$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and id=".$rowc["id_usuario_registro"];
								$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
								$rowu = mysqli_fetch_array($resultu);
								echo "<td>".$rowu["usuario"]."</td>";
								echo "<input type=\"hidden\" name=\"id_usuario_registro\" value=\"".$rowu["id"]."\">";
							}
							echo "</tr>";
						if (($rowc["id_usuario_registro"] == $userid) or ($admin == true)){
							if ($rowc["duracion"] <= 0) { $color_fondo = 'red'; } else { $color_fondo = 'white'; }
							echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Duracion." :</th><td><input type=\"number\" name=\"duracion\" style=\"width:50px;background-color:".$color_fondo."\" value=\"".$rowc["duracion"]."\"></td></tr>";
							echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Notificar." ".$Cliente." :</th>";
								echo "<td><select name=\"notificar_cliente\" style=\"width:50px\">";
								if ($rowc["notificar_cliente"] == 0){
									echo "<option value=\"0\" selected>".$No."</option>";
									echo "<option value=\"1\">".$Si."</option>";
								} else {
									echo "<option value=\"0\">".$No."</option>";
									echo "<option value=\"1\" selected>".$Si."</option>";
								}
								echo "</select></td>";
							echo "</tr>";
						echo "<tr>";
						echo "<th style=\"text-align:right;vertical-align:top;\">".$Nivel." ".$Tecnico." :</th>";
							echo "<td><select name=\"nivel_tecnico\" style=\"width:50px\">";
								if ($rowc["nivel_tecnico"] == 1){
									echo "<option value=\"1\" selected>1</option>";
									echo "<option value=\"2\">2</option>";
									echo "<option value=\"3\">3</option>";
								} elseif  ($rowc["nivel_tecnico"] == 2){
									echo "<option value=\"1\">1</option>";
									echo "<option value=\"2\" selected>2</option>";
									echo "<option value=\"3\">3</option>";
								} elseif  ($rowc["nivel_tecnico"] == 3){
									echo "<option value=\"1\">1</option>";
									echo "<option value=\"2\">2</option>";
									echo "<option value=\"3\" selected>3</option>";
								} else {
									echo "<option value=\"1\">1</option>";
									echo "<option value=\"2\">2</option>";
									echo "<option value=\"3\">3</option>";
								}
							echo "</select></td>";
						echo "</tr>";
							echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Visible." ".$Cliente." :</th>";
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
							echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Pausar." ".$Incidencia." :</th>";
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
							echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Notificar." ".$Cliente." :</th>";
							if ($rowc["notificar_cliente"] == 0){echo "<td>".$No."</td>";} else { echo "<td>".$Si."</td>";}
							echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Visible." ".$Cliente." :</th>";
							if ($rowc["visible_cliente"] == 0){echo "<td>".$No."</td>";} else { echo "<td>".$Si."</td>";}
							echo "<tr style=\"background-color:".$color_td."\"><th style=\"text-align:right;vertical-align:top;width:150px\">".$Pausar." ".$Incidencia." :</th>";
							if ($rowc["pausada"] == 0){echo "<td>".$No."</td>";} else { echo "<td>".$Si."</td>";}
							echo "<input type=\"hidden\" name=\"duracion\" value=\"".$rowc["duracion"]."\">";
							echo "<input type=\"hidden\" name=\"notificar_cliente\" value=\"".$rowc["notificar_cliente"]."\">";
							echo "<input type=\"hidden\" name=\"visible_cliente\" value=\"".$rowc["visible_cliente"]."\">";
							echo "<input type=\"hidden\" name=\"pausada\" value=\"".$rowc["pausada"]."\">";
						}
						echo "<tr><td>&nbsp;</td></tr>";
						echo "</table>";
					echo "</td><td style=\"text-align:right;vertical-align:top;width:60%;\">";
						echo "<table cellspacing=\"0\" cellspacing=\"0\" style=\"width:100%;\">";
						if ($rowc["id_usuario_registro"] == $userid){
							echo "<tr><td colspan=\"3\"><textarea name=\"notas_desarrollo\" style=\"width:100%;\" rows=\"8\">".$rowc["notas_desarrollo"]."</textarea></td></tr>";
						} else {
							echo "<tr><td colspan=\"2\" style=\"width:100%;height:125px;background-color:silver;vertical-align:top;\">".$rowc["notas_desarrollo"]."&nbsp;</td></tr>";
							echo "<input type=\"hidden\" name=\"notas_desarrollo\" value=\"".$rowc["notas_desarrollo"]."\">";
						}
						$sqlud = "select * from sgm_users where id=".$rowincid["id_usuario_origen"];
						$resultud = mysqli_query($dbhandle,convertSQL($sqlud));
						$rowud = mysqli_fetch_array($resultud);
						if (($rowincid["id_estado"] != -2) and (($rowc["id_usuario_registro"] == $userid) or ($admin == true))){
							echo "<tr>";
								echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td>";
							if ($rowc["id_usuario_registro"] == $userid){
								echo "</form>";
								echo "<form action=\"index.php?op=1018&sop=100&ssop=6&id=".$id_inc."&id_not=".$rowc["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\" name=\"form2\">";
								echo "<td style=\"text-align:right;\" class=\"Submit\"><input type=\"Submit\" value=\"".$Eliminar."\" style=\"width:100px\"></td>";
							}
							echo "</tr>";
						}
						echo "</table>";
					echo "</form>";
					echo "</td>";
					echo "<td style=\"vertical-align:top;width:10%;\">";
						$sqlice = "select id,tipo from sgm_incidencias_correos_enviados where id_incidencia=".$rowc["id"];
						$resultice = mysqli_query($dbhandle,convertSQL($sqlice));
						while ($rowice = mysqli_fetch_array($resultice)){
							if (($rowice["tipo"] == 2) or ($rowice["tipo"] == 4)){
								echo "<a href=\"index.php?op=1000&id=".$rowice["id"]."\" onmouseover=\"NewWindow(this.href,'name','800','400','yes');return false;\">".$Notificacion.": ".$Insertada."</a><br>";
							}
							if (($rowice["tipo"] == 6)){
								echo "<a href=\"index.php?op=1000&id=".$rowice["id"]."\" onmouseover=\"NewWindow(this.href,'name','800','400','yes');return false;\">".$Notificacion.": ".$Reabierta."</a><br>";
							}
							if (($rowice["tipo"] == 7)){
								echo "<a href=\"index.php?op=1000&id=".$rowice["id"]."\" onmouseover=\"NewWindow(this.href,'name','800','400','yes');return false;\">".$Notificacion.": ".$Relacionada."</a><br>";
							}
						}
					echo "</td>";
				echo "</tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<form action=\"index.php?op=1018&sop=100&ssop=3&id=".$rowincid["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\" name=\"form1\">";
			echo "<tr>";
				echo "<td style=\"text-align:left;vertical-align:top;width:30%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Finalizacion." :</th>";
						if ($rowincid["fecha_cierre"] > 0){ $fecha_c = date("Y-m-d H:i:s", $rowincid["fecha_cierre"]); } else { $fecha_c = date("Y-m-d H:i:s", time()); }
						echo "<td><input type=\"text\" name=\"fecha_cierre\" style=\"width:150px\" value=\"".$fecha_c."\"></td></tr>";
						if ($rowincid["fecha_cierre"]){
							$sqlu = "select usuario from sgm_users where id=".$rowincid["id_usuario_finalizacion"];
							$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
							$rowu = mysqli_fetch_array($resultu);
							$fecha = date("Y-m-d H:i:s", $rowincid["fecha_cierre"]);
							echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Usuario." :</th><td>".$rowu["usuario"]."</td></tr>";
							echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Fecha." :</th><td>".$fecha."</td></tr>";
						}
					echo "</table>";
				echo "</td><td style=\"text-align:right;vertical-align:top;width:60%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr><th style=\"text-align:left;vertical-align:top;\" colspan=\"2\">".$Notas." ".$Conclusion." :</th></tr>";
						echo "<tr><td colspan=\"2\"><textarea name=\"notas_conclusion\" style=\"width:100%;\" rows=\"5\" required>".$rowincid["notas_conclusion"]."</textarea></td></tr>";
						if ($rowincid["id_estado"] == -2){
							echo "<tr>";
								echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Abrir."\" style=\"width:100px\"></td>";
							echo "</form>";
							if ($rowincid["control_version"] == 0){
								echo "<form action=\"index.php?op=1018&sop=100&ssop=7&id=".$rowincid["id"]."\" method=\"post\">";
									echo "<td style=\"text-align:right;\" class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir_version."\" style=\"width:200px\"></td>";
								echo "</form>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td class=\"Submit\"><input type=\"Submit\" value=\"".$Finalizar."\" style=\"width:100px\"></td></tr>";
							echo "</form>";
						}
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:10%;\">";
						$sqlice = "select id from sgm_incidencias_correos_enviados where tipo=5 and id_incidencia=".$rowincid["id"];
						$resultice = mysqli_query($dbhandle,convertSQL($sqlice));
						$rowice = mysqli_fetch_array($resultice);
						if ($rowice and ($rowincid["id_estado"] == -2)){
							echo "<a href=\"index.php?op=1000&id=".$rowice["id"]."\" onmouseover=\"NewWindow(this.href,'name','800','400','yes');return false;\">".$Notificacion.": ".$Cerrada."</a><br>";
						}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		}
		echo "</table>";
	}
#añadir incidencias fi#

#Archivos adjuntos a la incidencia
	if ($soption == 110){
		echo "<h4>".$Documentos." ".$Adjuntos."</h4>";
		anadirArchivo ($_GET["id"],4,"");
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1018&sop=110&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1018&sop=110&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}
#Fin archivos adjuntos a la incidencia

#Lista de notificaciones enviadas
	if ($soption == 120){
		echo "<h4>".$Notificaciones." ".$Enviadas."</h4>";
		echo "<table cellpadding=\"3\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th style=\"width:100px\">".$Fecha."</th>";
				echo "<th style=\"width:100px\">".$Destinatario."</th>";
				echo "<th style=\"width:150px\">".$Tipo."</th>";
				echo "<th style=\"width:600px\">".$Asunto."</th>";
				echo "<th style=\"width:600px\">".$Mensaje."</th>";
			echo "</tr>";
		$color = "white";
		$sqlice = "select * from sgm_incidencias_correos_enviados where id_incidencia=".$_GET["id"];
		$resultice = mysqli_query($dbhandle,convertSQL($sqlice));
		while ($rowice = mysqli_fetch_array($resultice)){
			if ($rowice["tipo"] == 1) { $tipo = "incidencia nueva externa";}
			if ($rowice["tipo"] == 2) { $tipo = "nota de incidencia externa";}
			if ($rowice["tipo"] == 3) { $tipo = "incidencia nueva interna";}
			if ($rowice["tipo"] == 4) { $tipo = "nota de incidencia interna";}
			if ($rowice["tipo"] == 5) { $tipo = "cierre incidencia";}
			if ($rowice["tipo"] == 6) { $tipo = "reabrir incidencia";}
			if ($rowice["tipo"] == 7) { $tipo = "relacionar incidencia";}
			if ($rowice["tipo"] == 8) { $tipo = "eliminar incidencia";}
			echo "<tr style=\"background-color:".$color.";\">";
				echo "<td style=\"vertical-align:top;\">".date("Y-m-d",$rowice["fecha"])."</td>";
				echo "<td style=\"vertical-align:top;\">".$rowice["destinatario"]."</td>";
				echo "<td style=\"vertical-align:top;\">".$tipo."</td>";
				echo "<td style=\"vertical-align:top;\">".$rowice["asunto"]."</td>";
				echo "<td style=\"vertical-align:top;\">".$rowice["mensaje"]."</td>";
			echo "</tr>";
			if ($color == "white") { $color = "#DCDCDC"; } else { $color = "white"; }
		}
		$sqlice2 = "select * from sgm_incidencias_correos_enviados where id_incidencia in (select id from sgm_incidencias where visible=1 and id_incidencia=".$_GET["id"].")";
		$resultice2 = mysqli_query($dbhandle,convertSQL($sqlice2));
		while ($rowice2 = mysqli_fetch_array($resultice2)){
			if ($rowice2["tipo"] == 1) { $tipo = "incidencia nueva externa";}
			if ($rowice2["tipo"] == 2) { $tipo = "nota de incidencia externa";}
			if ($rowice2["tipo"] == 3) { $tipo = "incidencia nueva interna";}
			if ($rowice2["tipo"] == 4) { $tipo = "nota de incidencia interna";}
			if ($rowice2["tipo"] == 5) { $tipo = "cierre incidencia";}
			if ($rowice2["tipo"] == 6) { $tipo = "reabrir incidencia";}
			if ($rowice2["tipo"] == 7) { $tipo = "relacionar incidencia";}
			if ($rowice2["tipo"] == 8) { $tipo = "eliminar incidencia";}
			echo "<tr style=\"background-color:".$color.";\">";
				echo "<td style=\"vertical-align:top;\">".date("Y-m-d",$rowice2["fecha"])."</td>";
				echo "<td style=\"vertical-align:top;\">".$rowice2["destinatario"]."</td>";
				echo "<td style=\"vertical-align:top;\">".$tipo."</td>";
				echo "<td style=\"vertical-align:top;\">".$rowice2["asunto"]."</td>";
				echo "<td style=\"vertical-align:top;\">".$rowice2["mensaje"]."</td>";
			echo "</tr>";
			if ($color == "white") { $color = "#DCDCDC"; } else { $color = "white"; }
		}
		echo "</table>";
	}
#Fin lista de notificaciones enviadas

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
					$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 order by usuario";
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					while ($rowu = mysqli_fetch_array($resultu)) {
							if ($rowu["id"] == $id_usuari){
								echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
							} else {
								echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
							}
					}
				echo "</select></td>";
				echo "<td><select name=\"any\" style=\"width:100px\">";
					if ($_POST["any"] == 0) {$year = date("Y");} else {$year = $_POST["any"];}
					for ($j=2013;$j<=(date("Y")+1);$j++){
						if ($j == $year){
							echo "<option value=\"".$j."\" selected>".$j."</option>";
						} else {
							echo "<option value=\"".$j."\">".$j."</option>";
						}
					}
				echo "</select></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
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
								if (comprobarFestivoEmpleado($data1,$_POST["id_usuario"]) == 1){ $color = "Orange"; } else {$color = "white";}
								if ($data1 == date(U, mktime(0, 0, 0, date(m), date(d), date(Y)))){ $color = "yellow"; } else {$color = $color;}
								if (comprobar_festivo2($data1) == 1){ $color = "Tomato"; } else {$color = $color;}
								echo "<tr style=\"background-color:".$color."\">";
									if ($count == 0){echo "<th style=\"background-color:white;\">".$i."</th>";} else {echo "<td></td>";}
									$sqlis = "select sum(duracion) as duracion_total from sgm_incidencias where visible=1 and id_incidencia<>0 and id_usuario_registro=".$_POST["id_usuario"]." and fecha_inicio between ".$data1." and ".$data2."";
									$resultis = mysqli_query($dbhandle,convertSQL($sqlis));
									$rowis = mysqli_fetch_array($resultis);
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
		$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
		$rowr = mysqli_fetch_array($resultr);
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
			echo boton(array("op=1018&sop=510","op=1018&sop=520"),array($Estado,$EliminacionMasiva));
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
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
				$sqlie = "select * from sgm_incidencias_estados where visible=1";
				$resultie = mysqli_query($dbhandle,convertSQL($sqlie));
				while ($rowie = mysqli_fetch_array($resultie)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;\">";
							if ($rowie["editable"] == 1) {echo "<a href=\"index.php?op=1018&sop=511&id=".$rowie["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a>";}
						echo "</td>";
						echo "<form action=\"index.php?op=1018&sop=510&ssop=2&id=".$rowie["id"]."\" method=\"post\">";
						echo "<td><input type=\"Text\" name=\"estado\" style=\"width:150px\" value=\"".$rowie["estado"]."\"></td>";
						echo "<td>";
							if ($rowie["editable"] == 1){
								echo "<select style=\"width:50px\" name=\"editable\">";
									echo "<option value=\"0\">".$No."</option>";
									echo "<option value=\"1\" selected>".$Si."</option>";
								echo "</select>";
							}
						echo "</td>";
						echo "<td class=\"Submit\">";
							if ($rowie["editable"] == 1) {echo "<input type=\"Submit\" value=\"Modificar\">";}
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

#Eliminación masiva de incidencias sin cliente#
	if (($soption == 520) and ($admin == true)) {
		if (($ssoption == 3) and ($admin == true)) {
			$sql = "update sgm_incidencias set visible=0 WHERE id_incidencia=0 and visible=1 and id_cliente=191";
			mysqli_query($dbhandle,convertSQL($sql));
#			echo $sql."<br>";
		}
		echo boton(array("op=1018&sop=521"),array($SinCliente));
	}

	if (($soption == 521) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1018&sop=520&ssop=3&id=","op=1018&sop=520"),array($Si,$No));
		echo "</center>";
	}
#Eliminación masiva de incidencias sin cliente fin#

#ayuda#
	if ($soption == 600){
		echo "<h4>".$Ayuda."</h4>";
		echo "<div style=\"margin-left:10%;margin-right:10%;\">";
			echo "<h4>".$Colores."</h4>";
			echo $IncidenciasAyudaColores;
		echo "</div>";
		echo "<div style=\"margin-left:10%;margin-right:10%;margin-bottom:5%;\">";
			echo "<h4>".$Notificaciones."</h4>";
			echo $IncidenciasAyudaNotificaciones;
		echo "</div>";
	}
#ayuda fin#

	echo "</td></tr></table><br>";
}

function contarIncidenciasNovedades ($id,$id_usuario_destino){
	global $db,$dbhandle;

	$novetats = 0;
	$sqlind = "select id_usuario_registro from sgm_incidencias where id_incidencia=".$id." and visible=1 order by fecha_inicio desc";
	$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
	$rowind = mysqli_fetch_array($resultind);
	if ($rowind["id_usuario_registro"] != ""){
		$sqluu = "select * from sgm_users where sgm=0 and id=".$rowind["id_usuario_registro"];
		$resultuu = mysqli_query($dbhandle,convertSQL($sqluu));
		$rowuu = mysqli_fetch_array($resultuu);
		if ($id_usuario_destino != $rowind["id_usuario_registro"]) {$novetats ++;}
	}

	return $novetats;
}

function envioNotificacionIncidencia($id_incidencia,$id_servicio,$id_usuario_registro,$usuario_origen,$insertada,$editada,$cerrada,$relacionada,$eliminada,$tipo)
{
	global $db,$dbhandle;
	$enviar = 0;

	$sqlu = "select * from sgm_users where validado=1 and activo=1 and sgm=0 and id=".$id_usuario_registro;
	$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
	$rowu = mysqli_fetch_array($resultu);
	if ($rowu){
		enviarNotInci($id_usuario_registro,$id_incidencia,$tipo,$id_servicio,$insertada,$editada,$cerrada,$relacionada,$eliminada);

		$sqls = "select * from sgm_contratos_servicio where auto_email=1 and id=".$id_servicio;
		$results = mysqli_query($dbhandle,convertSQL($sqls));
		$rows = mysqli_fetch_array($results);
		if (($rows) and ($id_usuario_registro != $usuario_origen)){
			enviarNotInci($usuario_origen,$id_incidencia,$tipo,$id_servicio,$insertada,$editada,$cerrada,$relacionada,$eliminada);
		}

	} else {
		$sqlu2 = "select * from sgm_users where validado=1 and activo=1 and sgm=0 and id=".$usuario_origen;
		$resultu2 = mysqli_query($dbhandle,convertSQL($sqlu2));
		$rowu2 = mysqli_fetch_array($resultu2);
		if ($rowu2){
			enviarNotInci($usuario_origen,$id_incidencia,$tipo,$id_servicio,$insertada,$editada,$cerrada,$relacionada,$eliminada);
		}
	}


	$sqlcsn = "select * from sgm_contratos_servicio_notificacion where id_servicio=".$id_servicio." and id_usuario<>".$id_usuario_registro;
	$resultcsn = mysqli_query($dbhandle,convertSQL($sqlcsn));
	while ($rowcsn = mysqli_fetch_array($resultcsn)){
#	echo "xx";
		$sqlcsnc = "select * from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$rowcsn["id"];
		$resultcsnc = mysqli_query($dbhandle,convertSQL($sqlcsnc));
		while ($rowcsnc = mysqli_fetch_array($resultcsnc)){
#	echo "xxa".$enviar;
			if (($rowcsnc["id_usuario_origen"] == -1) and ($rowcsnc["tipo_edicion_incidencia"] == 4)){ $enviar = 1;}
				if (($rowcsnc["id_usuario_origen"] == -1) and ($rowcsnc["tipo_edicion_incidencia"] == 4)){ $enviar = 1;}
				elseif ($rowcsnc["id_usuario_origen"] == $usuario_origen){
					if ($rowcsnc["tipo_edicion_incidencia"] == 4){
						$enviar = 1;
	#	echo "xxb".$enviar;
					} else {
						if (($rowcsnc["tipo_edicion_incidencia"] == 1) and ($insertada == 1)) { $enviar = 1;} 
						if (($rowcsnc["tipo_edicion_incidencia"] == 2) and ($editada >= 1)) { $enviar = 1;}
						if (($rowcsnc["tipo_edicion_incidencia"] == 3) and ($cerrada >= 1)) { $enviar = 1;}
						if (($rowcsnc["tipo_edicion_incidencia"] == 5) and ($relacionada == 1)) { $enviar = 1;}
						if (($rowcsnc["tipo_edicion_incidencia"] == 6) and ($eliminada == 1)) { $enviar = 1;}
#		echo "xxc".$enviar;
					}
				}
		}
#echo $enviar;
		if ($enviar == 1){
#	echo "xx";
			enviarNotInci($rowcsn["id_usuario"],$id_incidencia,$tipo,$id_servicio,$insertada,$editada,$cerrada,$relacionada,$eliminada);
		}
	}
}

function enviarNotInci($id_usuario,$id_incidencia,$tipo,$id_servicio,$insertada,$editada,$cerrada,$relacionada,$eliminada){
	global $db,$dbhandle;
	$text = '';
#	var_dump($editada);

	$sqls = "select * from sgm_contratos_servicio where id=".$id_servicio;
	$results = mysqli_query($dbhandle,convertSQL($sqls));
	$rows = mysqli_fetch_array($results);
	$codigo_catalogo = $rows["codigo_catalogo"];

	$sqlu = "select * from sgm_users where validado=1 and activo=1 and id=".$id_usuario;
	$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
	$rowu = mysqli_fetch_array($resultu);

	$id_nota_inci = $id_incidencia;
	$sqli = "select * from sgm_incidencias where visible=1 and id=".$id_incidencia;
	$resulti = mysqli_query($dbhandle,convertSQL($sqli));
	$rowi = mysqli_fetch_array($resulti);
	if ($rowi["id_incidencia"] != 0){
		$sqlii = "select * from sgm_incidencias where visible=1 and id=".$rowi["id_incidencia"];
		$resultii = mysqli_query($dbhandle,convertSQL($sqlii));
		$rowii = mysqli_fetch_array($resultii);
		$id_usuario_destino = $rowii["id_usuario_destino"];
		$notas_conclusion = $rowii["notas_conclusion"];
		$notas_registro = $rowi["notas_desarrollo"];
		$id_incidencia = $rowii["id"];
		$codigo_externo = $rowii["codigo_externo"];
		$pausa = $rowii["pausada"];
	} else {
		$id_usuario_destino = $rowi["id_usuario_destino"];
		$notas_conclusion = $rowi["notas_conclusion"];
		$notas_registro = $rowi["notas_registro"];
		$codigo_externo = $rowi["codigo_externo"];
		$pausa = $rowi["pausada"];
	}
	$sqluu = "select * from sgm_users where validado=1 and activo=1 and sgm=1 and id=".$id_usuario_destino;
	$resultuu = mysqli_query($dbhandle,convertSQL($sqluu));
	$rowuu = mysqli_fetch_array($resultuu);
	if ($insertada == 1){
		$text .= "<em>".$notas_registro."</em>";
		if ($rows["prefijo_notificacion"] != ''){$codigo_catalogo = $rows["prefijo_notificacion"];}
	}
	if (in_array(1,$editada)){
		$text1 = "<em>".$rowi["notas_desarrollo"]."</em>";
		if ($pausa == 1){$text1 .= "<br>i esta pausada";}
		$text = $text.$text1."<br>";
	}
	if (in_array(2,$editada)){
		$text2 = "S'ha assignat un nou t&egrave;cnic: ".$rowuu["usuario"];
		$text = $text.$text2."<br>";
	}
	if (in_array(3,$editada)){
		$text3 = "<em>".$rowi["notas_registro"]."</em>";
		$text = $text.$text3."<br>";
	}
#	if (in_array(4,$editada)){
#		$text4 = "S'ha assignat un nou t&egrave;cnic: ".$rowuu["usuario"]."<br>";
#		$text4 .= "<em>".$notas_registro."</em>";
#		if ($pausa == 1){$text4 .= "<br><br>i esta pausada";}
#		$text = $text.$text4."<br>";
#	}
	if ($cerrada == 1){
		$text .= "<em>".$notas_conclusion."</em>";
	}
	if ($relacionada == 1){
		$text .= "<em>".$id_incidencia." - ".$rowii["asunto"]."</em>";
	}
	
	enviarNotificacion($rowu["mail"],$id_incidencia,$codigo_catalogo,$codigo_externo,$tipo,$text,$id_nota_inci );
}	
?>
