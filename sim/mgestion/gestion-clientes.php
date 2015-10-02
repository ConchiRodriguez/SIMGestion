<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);

if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1008) AND ($autorizado == true)) {
	$id_client = 0;
	if ($_GET['or'] != "") { $orden = $_GET['or']; } else { $orden = 0; }

	## canvis en les definicions de clients (noms, color, relacions, etc) ##
	if (($soption == 560) and ($ssoption == 1) AND ($admin == true)) {
		if ($_POST["id_origen"] == 0){
			$color=comillas($_POST["color"]);
			$color_lletra=comillas($_POST["color_lletra"]);
		} else {
			$sqlc = "select color,color_lletra from sgm_clients_classificacio_tipus where visible=1 and id=".$_POST["id_origen"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$color=$rowc["color"];
			$color_lletra=$rowc["color_lletra"];
		}
		$camposInsert = "id_origen,nom,color,color_lletra";
		$datosInsert = array($_POST["id_origen"],comillas($_POST["nom"]),$color,$color_lletra);
		insertFunction ("sgm_clients_classificacio_tipus",$camposInsert,$datosInsert);
	}
	if (($soption == 560) and ($ssoption == 2) AND ($admin == true)) {
		if ($_POST["id_origen"] == 0){
			$color=comillas($_POST["color"]);
			$color_lletra=comillas($_POST["color_lletra"]);
		} else {
			$sqlc = "select color,color_lletra from sgm_clients_classificacio_tipus where visible=1 and id=".$_POST["id_origen"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$color=$rowc["color"];
			$color_lletra=$rowc["color_lletra"];
		}
		$camposUpdate=array('id_origen','nom','color','color_lletra');
		$datosUpdate=array($_POST["id_origen"],comillas($_POST["nom"]),$color,$color_lletra);
		updateFunction("sgm_clients_classificacio_tipus",$_GET["id"],$camposUpdate,$datosUpdate);
		canviar_color($_GET["id"],$_POST["color"],$_POST["color_lletra"]);
	}
	if (($soption == 560) and ($ssoption == 3) AND ($admin == true)) {
		$sql = "update sgm_clients_classificacio_tipus set visible=0 WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		$sqls = "update sgm_clients_classificacio set visible=0 WHERE id_clasificacio_tipus=".$_GET["id"]."";
		mysql_query(convert_sql($sqls));
		$sqls = "update sgm_clients_classificacio_tipus set id_origen=0 WHERE id_origen=".$_GET["id"]."";
		mysql_query(convert_sql($sqls));
	}
	## fi de canvis en les definicions de client ##

	echo "<table class=\"principal\">";
		echo"<tr>";
			echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
				echo "<h4>".$Clientes."</h4>";
			echo "</td><td style=\"width:85%;vertical-align:top;text-align:left;\">";
				echo "<table>";
					echo "<tr>";
						if (($soption == 0) or ($_GET["id_classificacio"] != 0)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=0\" class=".$class.">".$Buscar." ".$Clientes."</a></td>";
						if (($soption == 1) and ($_GET["id_classificacio"] == 0)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=1&id_classificacio=0\" class=".$class.">".$Ver_Todos."</a></td>";
						if ($soption == 2) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=2\" class=".$class.">".$Ver." ".$Contactos."</a></td>";
						if ($soption == 3) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=3\" class=".$class.">".$Busquedas."</a></td>";
						if (($soption == 100) and ($_GET["id"] == 0)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=100&id=0\" class=".$class.">".$Anadir." ".$Cliente."</a></td>";
						if ($soption == 400) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=400\" class=".$class.">".$Indicadores."</a></td>";
						if ($soption == 600) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=600\" class=".$class.">".$Gestion."</a></td>";
						if (($soption >= 500) and ($soption < 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=500\" class=".$class.">".$Administrar."</a></td>";
					echo "</tr>";
				echo "</table>";
		echo"</tr><tr>";
			echo "<td colspan=\"2\">";
			$id_origen = 0;
			### BUSCO CATEGORIA DE ORIGEN
			$sqltx1 = "select id,id_origen from sgm_clients_classificacio_tipus where id=".$_GET["id_classificacio"];
			$resulttx1 = mysql_query(convert_sql($sqltx1));
			$rowtx1 = mysql_fetch_array($resulttx1);
			if ($rowtx1["id_origen"] == 0) {
				$id_origen = $rowtx1["id"];
			} else {
				$sqltx2 = "select id,id_origen from sgm_clients_classificacio_tipus where id=".$rowtx1["id_origen"];
				$resulttx2 = mysql_query(convert_sql($sqltx2));
				$rowtx2 = mysql_fetch_array($resulttx2);
				if ($rowtx2["id_origen"] == 0) {
					$id_origen = $rowtx2["id"];
				} else {
					$sqltx3 = "select id,id_origen from sgm_clients_classificacio_tipus where id=".$rowtx2["id_origen"];
					$resulttx3 = mysql_query(convert_sql($sqltx3));
					$rowtx3 = mysql_fetch_array($resulttx3);
					if ($rowtx3["id_origen"] == 0) {
						$id_origen = $rowtx3["id"];
					}
				}
			}
				echo "<table class=\"lista\">";
					echo "<tr>";
					$sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0 order by nom";
					$resultt = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($resultt)){
						echo "<td class=".$class." style=\"background-color:".$rowt["color"].";\"><a href=\"index.php?op=1008&sop=0&id_classificacio=".$rowt["id"]."\" style=\"color:".$rowt["color_lletra"]."\">".$rowt["nom"]."</a></td>";
					}
					echo "</tr>";
				echo "</table>";
				if ($id_origen != 0) {
					echo "<table class=\"lista\"><tr>";
					$sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$id_origen." order by nom";
					$resultt = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($resultt)){
						echo "<td style=\"vertical-align:top;\">";
							echo "<table class=\"lista\">";
								echo "<tr><td style=\"height:16px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=0&id_classificacio=".$rowt["id"]."\" style=\"color: ".$rowt["color_lletra"]."\">".$rowt["nom"]."</a></td></tr>";
								echo "<tr><td style=\"height:6px\"></td></tr>";
								$sqltt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"]." order by nom";
								$resulttt = mysql_query(convert_sql($sqltt));
								while ($rowtt = mysql_fetch_array($resulttt)){
									echo "<tr><td style=\"height:16px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowtt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=0&id_classificacio=".$rowtt["id"]."\" style=\"color: ".$rowtt["color_lletra"]."\">".$rowtt["nom"]."</a></td></tr>";
								}
							echo "</table>";
						echo "</td>";
					}
					echo "</tr></table>";
				}
			echo "</td>";
		echo "</tr>";
	echo "</table><br>";
	echo "<table  class=\"principal\">";
		echo "<tr>";
			echo "<td style=\"width:100%;vertical-align:top;text-align:left;\">";

	if (($soption == 0) or ($soption == 1) or ($soption == 4)) {
		if ($ssoption == 1){
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($soption == 4){
			$sqlc = "select * from sgm_cerques where id=".$_GET["id"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$tipo = $rowc["id_tipo"];
			$tipos = explode(",", $tipo);
			$grupo = $rowc["id_grupo"];
			$grupos = explode(",", $grupo);
			$sector = $rowc["id_sector"];
			$sectors = explode(",", $sector);
			$ubicacion = $rowc["id_ubicacion"];
			$ubicacions = explode(",", $ubicacion);
			$id_classificacio = $rowc["id_classificacio"];
			$id_classificacions = explode(",", $id_classificacio);
		} else {
			$tipos = $_POST["tipo"];
			$tipo = implode(",", $tipos);
			$grupos = $_POST["grupo"];
			$grupo = implode(",", $grupos);
			$sectors = $_POST["sector"];
			$sector = implode(",", $sectors);
			$ubicacions = $_POST["ubicacion"];
			$ubicacion = implode(",", $ubicacions);
			$id_classificacions = $_POST["id_classificacio"];
			$id_classificacio = implode(",", $id_classificacions);
		}
		##################################################
		################### CERCADOR   ###################
		##################################################
		if ($_GET["id_classificacio"] == "") {
			echo "<form action=\"index.php?op=1008&sop=0&ssop=10\" method=\"post\">";
				echo "<h4>".$Buscar_Contacto." : </h4>";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
					echo "<tr style=\"background-color:silver;\">";
						echo "<th>".$Definicion."</th>";
						echo "<th>".$Tipo."</th>";
						echo "<th>".$Grupo."</th>";
						echo "<th>".$Sector."</th>";
						echo "<th>".$Ubicacion."</th>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>";
							echo "<select multiple name=\"id_classificacio[]\" size=\"10\" style=\"width:354px\">";
								echo "<option value=\"0\">".$Todos."</option>";
								$sqlt = "select id,nom from sgm_clients_classificacio_tipus where visible=1";
								$resultt = mysql_query(convert_sql($sqlt));
								while ($rowt = mysql_fetch_array($resultt)) {
									if (in_array($rowt["id"], $id_classificacions)){
										echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nom"]."</option>";
									} else {
										echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
									}
								}
							echo "</select>";
						echo "</td>";
						echo "<td>";
							echo "<select multiple name=\"tipo[]\" size=\"10\" style=\"width:175px\">";
								echo "<option value=\"\">-</option>";
								$sqlt = "select id,tipo from sgm_clients_tipos order by tipo";
								$resultt = mysql_query(convert_sql($sqlt));
								while ($rowt = mysql_fetch_array($resultt)){
									if (in_array($rowt["id"], $tipos)){
										echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["tipo"]."</option>";
									} else {
										echo "<option value=\"".$rowt["id"]."\">".$rowt["tipo"]."</option>";
									}
								}
							echo "</select>";
						echo "</td>";
						echo "<td>";
							echo "<select multiple name=\"grupo[]\" size=\"10\" style=\"width:175px\">";
								echo "<option value=\"\">-</option>";
								$sqlg = "select id,grupo from sgm_clients_grupos order by grupo";
								$resultg = mysql_query(convert_sql($sqlg));
								while ($rowg = mysql_fetch_array($resultg)){
									if (in_array($rowg["id"], $grupos)){
										echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["grupo"]."</option>";
									} else {
										echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
									}
								}
							echo "</select>";
						echo "</td>";
						echo "<td>";
							echo "<select multiple name=\"sector[]\" size=\"10\" style=\"width:175px\">";
								echo "<option value=\"\">-</option>";
								$sqls = "select id,sector from sgm_clients_sectors order by sector";
								$results = mysql_query(convert_sql($sqls));
								while ($rows = mysql_fetch_array($results)){
									if (in_array($rows["id"], $sectors)){
										echo "<option value=\"".$rows["id"]."\" selected>".$rows["sector"]."</option>";
									} else {
										echo "<option value=\"".$rows["id"]."\">".$rows["sector"]."</option>";
									}
								}
							echo "</select>";
						echo "</td>";
						echo "<td>";
							echo "<select multiple name=\"ubicacion[]\" size=\"10\" style=\"width:175px\">";
								echo "<option value=\"\">-</option>";
								$sqlu = "select id,ubicacion from sgm_clients_ubicacion order by ubicacion";
								$resultu = mysql_query(convert_sql($sqlu));
								while ($rowu = mysql_fetch_array($resultu)){
									if (in_array($rowu["id"], $ubicacions)){
										echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["ubicacion"]."</option>";
									} else {
										echo "<option value=\"".$rowu["id"]."\">".$rowu["ubicacion"]."</option>";
									}
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "<br>";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
					echo "<tr>";
						echo "<th></th>";
						echo "<th></th>";
						echo "<th></th>";
						for ($i = 48; $i <= 90; $i++) {
							if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
								echo "<th style=\"color:black;text-align: center;\">".chr($i)."</th>";
							}
						}
					echo "</tr>";
					echo "<tr>";
						echo "<th style=\"color:black;text-align: right;\">".$Nombre."</th>";
						echo "<td style=\"color:black;text-align: leftt;width:160px\"><input type=\"Text\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\" style=\"width:150px\"></td>";
						echo "<th style=\"color:black;text-align: right;\">".$Inicial."</th>";
						for ($i = 48; $i <= 90; $i++) {
							if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
								echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"".chr($i)."\"";
								if ($_POST[chr($i)] == true) { echo " checked"; }
								echo " value=\"true\" style=\"border:0px solid black\"></td>";
							}
						}
					echo "</tr>";
					echo "<tr><td colspan=\"39\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:400px\"></td></tr>";
				echo "</table>";
			echo "</form>";
			echo "<br>";
		}
		##################################################
		################### RESULTAT   ###################
		##################################################
		if (($_GET["id_classificacio"] != "") or ($ssoption == 10) or ($_GET["id"] > 0)) {

			$lletres = "";
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
					if ($_POST[chr($i)] == true) {
						$lletres .= $_POST[chr($i)];
					}
				}
			}
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr>";
					echo "<td><strong>".$Clientes."</strong>".$en_orden_alfabetico;
						for ($i = 48; $i <= 90; $i++) {
							if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
								echo "<a href=\"#".chr($i)."\"><strong>".chr($i)."</strong></a>&nbsp;";
							}
						}
					echo "</td>";
					echo "<form action=\"index.php?op=1008&sop=6\" method=\"post\">";
						for ($i = 48; $i <= 90; $i++) {
							if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
								if ($_POST[chr($i)] == true) {
									echo "<input type=\"Hidden\" name=\"".chr($i)."\" value=\"".$_POST[chr($i)]."\">";
								}
							}
						}
						echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$tipo."\">";
						echo "<input type=\"Hidden\" name=\"grupo\" value=\"".$grupo."\">";
						echo "<input type=\"Hidden\" name=\"sector\" value=\"".$sector."\">";
						echo "<input type=\"Hidden\" name=\"ubicacion\" value=\"".$ubicacion."\">";
						if ($_GET["id_classificacio"] != "") {$id_classif = $_GET["id_classificacio"];} else {$id_classif = $id_classificacio;}
						echo "<input type=\"Hidden\" name=\"id_classificacio\" value=\"".$id_classif."\">";
						echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
						echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Imprimir_Lista."\" style=\"width:150px\"></td>";
					echo "</form>";
				if ($soption != 4){
					echo "<form action=\"index.php?op=1008&sop=572\" method=\"post\">";
					for ($i = 48; $i <= 90; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							if ($_POST[chr($i)] == true) {
								echo "<input type=\"Hidden\" name=\"".chr($i)."\" value=\"".$_POST[chr($i)]."\">";
							}
						}
					}
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$tipo."\">";
					echo "<input type=\"Hidden\" name=\"grupo\" value=\"".$grupo."\">";
					echo "<input type=\"Hidden\" name=\"sector\" value=\"".$sector."\">";
					echo "<input type=\"Hidden\" name=\"ubicacion\" value=\"".$ubicacion."\">";
					echo "<input type=\"Hidden\" name=\"id_classificacio\" value=\"".$id_classificacio.$_GET["id_classificacio"]."\">";
					echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
					echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Guardar_Busqueda."\" style=\"width:150px\"></td>";
					echo "</form>";
				}
				echo "</tr>";
			echo "</table>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$z = 0;
			#### DETERMINA SI HAY FILTRO POR INICIO LETRA
			$ver_todas_letras = true;
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
					if ($_POST[chr($i)] == true) {
						$ver_todas_letras = false;
					}
				}
			}
			#### INICIA BUCLE TODAS LAS LETRAS
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
					$linea_letra = 1;
					$color = "white";
					$sql = "select id,id_agrupacio from sgm_clients where visible=1";
					if ($tipo != "") { $sql = $sql." and id_tipo in (".$tipo.")"; }
					if ($grupo != "") { $sql = $sql." and id_grupo in (".$grupo.")"; }
					if ($sector != "") { $sql = $sql." and sector in (".$sector.")"; }
					if ($ubicacion != "") { $sql = $sql." and id_ubicacion in (".$ubicacion.")"; }
					if ($_POST["id_client"] != 0) { $sql = $sql." and id=".$_POST["id_client"]; }
					$sql = $sql." and nombre like '".chr($i)."%'";
					if ($_POST["likenombre"] != "") {
						$sql = $sql." and (nombre like '%".$_POST["likenombre"]."%' or cognom1 like '%".$_POST["likenombre"]."%' or cognom2 like '%".$_POST["likenombre"]."%')";
					}
					$sql =$sql." order by nombre,cognom1,cognom2,id_origen";
#					echo $sql."<br>";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						if(($_GET["id_classificacio"] != "") OR ($id_classificacio != "")){
							if ($row["id_agrupacio"] == 0){$ver = true;} else {$ver = false;}
						} else {
							$ver = true;
						}
						#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
						if ($ver_todas_letras == false) {
							if ($_POST[chr($i)] != true) {
								$ver = false;
							}
						}
						#### BUSCA TIPUS
						if (($ver == true) and (($_GET["id_classificacio"] != "") OR ($id_classificacio != ""))) {
							if (($_GET["id_classificacio"] != "") OR ($id_classificacio != 0))  {
								if ($_GET["id_classificacio"] != "") { $id_classificacio = $_GET["id_classificacio"]; }
								$sqlcxx = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus in (".$id_classificacio.")";
								$resultcxx = mysql_query(convert_sql($sqlcxx));
								$rowcxx = mysql_fetch_array($resultcxx);
								if ($rowcxx["total"] <= 0) { $ver = false; }

								$sqlcxx2 = "select id from sgm_clients_classificacio_tipus where id_origen in (".$id_classificacio.")";
								$resultcxx2 = mysql_query(convert_sql($sqlcxx2));
								while ($rowcxx2 = mysql_fetch_array($resultcxx2)) {
									$sqlcxx3 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx2["id"];
									$resultcxx3 = mysql_query(convert_sql($sqlcxx3));
									$rowcxx3 = mysql_fetch_array($resultcxx3);
									if ($rowcxx3["total"] > 0) { $ver = true; }

									$sqlcxx4 = "select id from sgm_clients_classificacio_tipus where id_origen=".$rowcxx2["id"];
									$resultcxx4 = mysql_query(convert_sql($sqlcxx4));
									while ($rowcxx4 = mysql_fetch_array($resultcxx4)) {
										$sqlcxx5 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx4["id"];
										$resultcxx5 = mysql_query(convert_sql($sqlcxx5));
										$rowcxx5 = mysql_fetch_array($resultcxx5);
										if ($rowcxx5["total"] > 0) { $ver = true; }
									}
								}
							}
						}
						#### INICI IMPRESIO PANTALLA
						if ($ver == true) {
							if ($linea_letra == 1) {
								echo "<tr style=\"background-color: Silver;\">";
									echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\">".chr($i)."</a></th>";
									echo "<th>Fid.</th>";
									echo "<th>Vip</th>";
									echo "<th>DE</th>";
									echo "<th style=\"width:600px;\">".$Cliente."</th>";
									echo "<th>".$Telefono."</th>";
									echo "<th>".$Correo."</th>";
									echo "<th>".$Web."</th>";
								echo "</tr>";
								$linea_letra = 0;
							}
							ver_contacto($row["id"],$color);
							if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
							$z++;
						}
						$ver_madre = $ver;
						$sqlsub = "select id from sgm_clients where visible=1 and id_agrupacio=".$row["id"];
						if ($tipo != "") { $sqlsub = $sqlsub." and id_tipo in (".$tipo.")"; }
						if ($grupo != "") { $sqlsub = $sqlsub." and id_grupo in (".$grupo.")"; }
						if ($sector != "") { $sqlsub = $sqlsub." and sector in (".$sector.")"; }
						if ($ubicacion != "") { $sqlsub = $sqlsub." and id_ubicacion in (".$ubicacion.")"; }
						if ($_POST["id_client"] != 0) { $sqlsub = $sqlsub." and id=".$_POST["id_client"]; }
						if ($_POST["likenombre"] != "") {
							$sqlsub = $sqlsub." and (nombre like '%".$_POST["likenombre"]."%' or cognom1 like '%".$_POST["likenombre"]."%' or cognom2 like '%".$_POST["likenombre"]."%')";
						}
						$sqlsub =$sqlsub." order by nombre,cognom1,cognom2,id_origen";
#						echo $sqlsub."<br>";
						$resultsub = mysql_query(convert_sql($sqlsub));
						while ($rowsub = mysql_fetch_array($resultsub)) {
							if (($_GET["id_classificacio"] != 0) OR ($id_classificacio != 0)){
								$ver = true;
							} else {
								$ver = false;
							}
							#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
							if ($ver_todas_letras == false) {
								if ($_POST[chr($i)] != true) {
									$ver = false;
								}
							}
							#### BUSCA TIPUS
							if (($ver == true) and (($_GET["id_classificacio"] != 0) OR ($id_classificacio != 0))) {
								if (($_GET["id_classificacio"] != "") OR ($id_classificacio != 0))  {
									if ($_GET["id_classificacio"] != "") { $id_classificacio = $_GET["id_classificacio"]; }
									$sqlcxx = "select count(*) as total  from sgm_clients_classificacio where id_client=".$rowsub["id"]." and visible=1 and id_clasificacio_tipus in (".$id_classificacio.")";
									$resultcxx = mysql_query(convert_sql($sqlcxx));
									$rowcxx = mysql_fetch_array($resultcxx);
									if ($rowcxx["total"] <= 0) { $ver = false; }
									$sqlcxx2 = "select id from sgm_clients_classificacio_tipus where id_origen in (".$id_classificacio.")";
									$resultcxx2 = mysql_query(convert_sql($sqlcxx2));
									while ($rowcxx2 = mysql_fetch_array($resultcxx2)) {
										$sqlcxx3 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$rowsub["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx2["id"];
										$resultcxx3 = mysql_query(convert_sql($sqlcxx3));
										$rowcxx3 = mysql_fetch_array($resultcxx3);
										if ($rowcxx3["total"] > 0) { $ver = true; }
										$sqlcxx4 = "select id from sgm_clients_classificacio_tipus where id_origen=".$rowcxx2["id"];
										$resultcxx4 = mysql_query(convert_sql($sqlcxx4));
										while ($rowcxx4 = mysql_fetch_array($resultcxx4)) {
											$sqlcxx5 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$rowsub["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx4["id"];
											$resultcxx5 = mysql_query(convert_sql($sqlcxx5));
											$rowcxx5 = mysql_fetch_array($resultcxx5);
											if ($rowcxx5["total"] > 0) { $ver = true; }
										}
									}
								}
							}
							#### INICI IMPRESIO PANTALLA
							if ($ver == true) {
								if ($linea_letra == 1) {
									echo "<tr style=\"background-color: Silver;\">";
										echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></th>";
										echo "<th>Fid.</th>";
										echo "<th>Vip</th>";
										echo "<th>DE</th>";
										echo "<th style=\"width:600px;\">".$Cliente."</th>";
										echo "<th>".$Telefono."</th>";
										echo "<th>".$Correo."</th>";
										echo "<th>".$Web."</th>";
									echo "</tr>";
									$linea_letra = 0;
								}
								ver_contacto($rowsub["id"],$color);
								if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
								$z++;
							}
						}
					}
				}
			}
				#### FIN TABLA, MUESTRA NUMERO RESULTADOS Y LEYENDA
				echo "<tr><th colspan=\"9\"  style=\"text-align:center;\">".$Resultado_de_la_busqueda.$z."</th></tr>";
			echo "</table>";
		}
	}

	if ($soption == 2) {
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			if ($_GET["filtro"] == "") {
				echo "<caption><strong>".$Contactos." ".$Personales."</strong> (A->Z) :";
				for ($i = 48; $i <= 90; $i++) {
					if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
						$sqlxt = "select count(*) as total from sgm_clients_contactos where visible=1 and nombre like '".chr($i)."%'  order by nombre";
						$resultxt = mysql_query(convert_sql($sqlxt));
						$rowxt = mysql_fetch_array($resultxt);
						if ($rowxt["total"] > 0) {
							echo "<a href=\"#".chr($i)."\"  name=\"indice\"><strong>".chr($i)."</strong></a>&nbsp;";
						} else {
							echo "<font style=\"color:silver;\">".chr($i)."</font>&nbsp;";
						}
					}
				}
				echo "</caption>";
				$filtro = 0;
			} else {
				$filtro = $_GET["filtro"];
			}
			echo "<tr>";
				echo "<td>".$por_empresa."</td>";
				echo "<td>";
					echo "<form action=\"index.php?op=1008&sop=2\" method=\"post\">";
					echo "<select name=\"id_client\" style=\"width:300px\">";
						echo "<option value=\"0\">-</option>";
						$sqle = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
						$resulte = mysql_query(convert_sql($sqle));
						while ($rowe = mysql_fetch_array($resulte)){
							if (($_POST["id_client"] == $rowe["id"])) {
								echo "<option value=\"".$rowe["id"]."\" selected>".substr($rowe["nombre"],0,36)." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$rowe["id"]."\">".substr($rowe["nombre"],0,36)." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
				echo "<td style=\"color:black;text-align: right;\">".$por_nombre."</td>";
				echo "<td style=\"color:black;text-align: leftt;width:160px\"><input type=\"Text\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\" style=\"width:150px\"></td>";
				echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"100%\">";
		 for ($i = 48; $i <= 90; $i++) {
			 if (((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) and (($filtro == 0) or ($filtro == $i))) {
			$sqlxt = "select count(*) as total from sgm_clients_contactos where visible=1 and nombre like '".chr($i)."%'";
			if ($_POST["id_client"] > 0){
				$sqlxt = $sqlxt." and id_client=".$_POST["id_client"];
			}
			if ($_POST["likenombre"] != ""){
				$sqlxt = $sqlxt." and (nombre like '%".$_POST["likenombre"]."%' or apellido1 like '%".$_POST["likenombre"]."%' or apellido2 like '%".$_POST["likenombre"]."%')";
			}
	#		$sqlxt = $sqlxt." order by nombre";
			$resultxt = mysql_query(convert_sql($sqlxt));
			$rowxt = mysql_fetch_array($resultxt);
				if ($rowxt["total"] > 0) {
					echo "<tr style=\"background-color: Silver;\">";
						echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>".chr($i)."</strong></a></th>";
						echo "<th>".$Trato."</th>";
						echo "<th style=\"white-space:nowrap\">".$Nombre."</th>";
						echo "<th>".$Telefono."</th>";
						echo "<th style=\"white-space:nowrap;\">".$Empresa."</th>";
						echo "<th style=\"white-space:nowrap\">".$Cargo."</th>";
					echo "</tr>";
					$cambio = 0;
					$sqlt = "select * from sgm_clients_contactos where visible=1 and nombre like '".chr($i)."%'";
					if ($_POST["id_client"] > 0){
						$sqlt = $sqlt." and id_client=".$_POST["id_client"];
					}
					if ($_POST["likenombre"] != ""){
						$sqlt = $sqlt." and (nombre like '%".$_POST["likenombre"]."%' or apellido1 like '%".$_POST["likenombre"]."%' or apellido2 like '%".$_POST["likenombre"]."%')";
					}
					$sqlt = $sqlt." order by nombre";
					$result = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($result)) {
						$sqltr = "select trato from sgm_clients_tratos where id=".$rowt["id_trato"];
						$resultr = mysql_query(convert_sql($sqltr));
						$rowtr = mysql_fetch_array($resultr);
						$sqlc = "select nombre,cognom1,cognom2 from sgm_clients where id=".$rowt["id_client"];
						$resultc = mysql_query(convert_sql($sqlc));
						$rowc = mysql_fetch_array($resultc);
						if ($cambio == 0) { $color = "white"; $cambio = 1; } else { $color = "#F5F5F5"; $cambio = 0; }
						echo "<tr style=\"background-color:".$color."\">";
							echo "<td></td>";
							echo "<td>".$rowtr["trato"]."</td>";
							echo "<td style=\"white-space:nowrap;\"><a href=\"index.php?op=1008&sop=122&ssop=2&id=".$rowt["id_client"]."&id_contacto=".$rowt["id"]."\">".$rowt["nombre"]." ".$rowt["apellido1"]." ".$rowt["apellido2"]."</a></td>";
							echo "<td>".$rowt["telefono"]."</td>";
							echo "<td style=\"white-space:nowrap;\"><a href=\"index.php?op=1008&sop=100&id=".$rowt["id_client"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]."  ".$rowc["cognom2"]." </a></td>";
							echo "<td style=\"white-space:nowrap;\">".$rowt["carrec"]."</td>";
						echo "</tr>";
					}
				}
			}
		}
		echo "</table>";
	}

	if ($soption == 3) {
		echo "<table cellpadding=\"1\" cellspacing=\"1\" class=\"lista\">";
			echo "<tr>";
			$x = 0;
			$sql = "select id,nombre from sgm_cerques order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<td style=\"width:400px;height:50px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=4&id=".$row["id"]."\" style=\"color:white;\">".$row["nombre"]."</a>";
				echo "</td>";
				$x++;
				if ($x >= 4){ echo "</tr><tr>"; $x = 0 ;}
			}
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 6) {
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"text-align:center;width:150px;\">".$Listado." ".$Contactos." : </td>";
				echo "<td></td>";
				echo "<form action=\"mgestion/gestion-clientes-print.php?\" target=\"_blank\" method=\"post\">";
					for ($i = 0; $i <= 127; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							if ($_POST[chr($i)] == true) {
								echo "<input type=\"Hidden\" name=\"".chr($i)."\" value=\"".$_POST[chr($i)]."\">";
							}
						}
					}
					echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$_POST["tipo"]."\">";
					echo "<input type=\"Hidden\" name=\"grupo\" value=\"".$_POST["grupo"]."\">";
					echo "<input type=\"Hidden\" name=\"sector\" value=\"".$_POST["sector"]."\">";
					echo "<input type=\"Hidden\" name=\"ubicacion\" value=\"".$_POST["ubicacion"]."\">";
					echo "<input type=\"Hidden\" name=\"id_classificacio\" value=\"".$_POST["id_classificacio"]."\">";
				echo "<td style=\"text-align:center;width:100px;\"><input type=\"Checkbox\" name=\"colorsi\"> ".$Color."</td>";
				echo "<td style=\"text-align:center;width:100px;\"><input type=\"Checkbox\" name=\"completa\"> ".$Completo."</td>";
				echo "<td><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	#Mascara superior del clients
	if (($soption >= 100) and ($soption < 300) and ($_GET["id"] != 0)) {
		if (($soption == 100) and ($ssoption == 1)) {
			$camposInsert="id_origen,id_agrupacio,nombre,cognom1,cognom2,alias,nif,direccion,poblacion,cp,provincia,client,clientvip,sector,id_tipo,id_grupo,id_ubicacion,id_pais,id_idioma,mail,telefono,telefono2,fax,fax2,web,notas,tipo_identificador,tipo_persona,tipo_residencia,dir3_oficina_contable,dir3_organo_gestor,dir3_unidad_tramitadora";
			$datosInsert = array($_POST["id_origen"],$_POST["id_agrupacio"],$_POST["nombre"],$_POST["cognom1"],$_POST["cognom2"],$_POST["alias"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["client"],$_POST["clientvip"],$_POST["sector"],$_POST["id_tipo"],$_POST["id_grupo"],$_POST["id_ubicacion"],$_POST["id_pais"],$_POST["id_idioma"],$_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["fax"],$_POST["fax2"],$_POST["web"],$_POST["notas"],$_POST["tipo_identificador"],$_POST["tipo_persona"],$_POST["tipo_residencia"],$_POST["dir3_oficina_contable"],$_POST["dir3_organo_gestor"],$_POST["dir3_unidad_tramitadora"]);
			insertFunction ("sgm_clients",$camposInsert,$datosInsert);

			$sql = "select id from sgm_clients where visible=1 and nombre='".$_POST["nombre"]."' and nif='".$_POST["nif"]."' order by id desc";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$camposInsert="id_client,id_clasificacio_tipus";
			$datosInsert = array($row["id"],$_POST["id_clasificacio_tipus"]);
			insertFunction ("sgm_clients_classificacio",$camposInsert,$datosInsert);
			$id_client = $row["id"];
		} else {
			$id_client = $_GET["id"];
		}
		if (($soption == 100) and ($ssoption == 2)) {
			$camposUpdate = array('id_origen','id_agrupacio','nombre','cognom1','cognom2','alias','nif','direccion','poblacion','cp','provincia','client','clientvip','sector','id_tipo','id_grupo','id_ubicacion','id_pais','id_idioma','mail','telefono','telefono2','fax','fax2','web','notas','tipo_identificador','tipo_persona','tipo_residencia','dir3_oficina_contable','dir3_organo_gestor','dir3_unidad_tramitadora');
			$datosUpdate = array($_POST["id_origen"],$_POST["id_agrupacio"],$_POST["nombre"],$_POST["cognom1"],$_POST["cognom2"],$_POST["alias"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["client"],$_POST["clientvip"],$_POST["sector"],$_POST["id_tipo"],$_POST["id_grupo"],$_POST["id_ubicacion"],$_POST["id_pais"],$_POST["id_idioma"],$_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["fax"],$_POST["fax2"],$_POST["web"],$_POST["notas"],$_POST["tipo_identificador"],$_POST["tipo_persona"],$_POST["tipo_residencia"],$_POST["dir3_oficina_contable"],$_POST["dir3_organo_gestor"],$_POST["dir3_unidad_tramitadora"]);
			updateFunction("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
	
			if ($_POST["id_clasificacio_tipus"] > 0){
				$total = 0;
				$total1 = 0;
				$definiciones = "";
				$sqln = "select id_clasificacio_tipus_neg from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_POST["id_clasificacio_tipus"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select id_clasificacio_tipus from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus_neg"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$total= $total+1;
						$sqld = "select nom from sgm_clients_classificacio_tipus where visible=1 and id=".$rowc["id_clasificacio_tipus"];
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$definiciones = $definiciones." ".$rowd["nom"];
					}
				}
				$sqln = "select id_clasificacio_tipus from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus_neg=".$_POST["id_clasificacio_tipus"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select id_clasificacio_tipus from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$total1= $total1+1;
						$sqld = "select nom from sgm_clients_classificacio_tipus where visible=1 and id=".$rowc["id_clasificacio_tipus"];
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$definiciones = $definiciones." ".$rowd["nom"];
					}
				}
				if (($total <= 0) and ($total1 <= 0)){
					$camposInsert = "id_client,id_clasificacio_tipus";
					$datosInsert = array($_GET["id"],$_POST["id_clasificacio_tipus"]);
					insertFunction ("sgm_clients_classificacio",$camposInsert,$datosInsert);
				} else {
					mensaje_error($definicionesIncompatibles);
					$rutes = array("op=1008&sop=100&ssop=3&id=".$_GET["id"]."&id_clas=".$_POST["id_clasificacio_tipus"],"op=1008&sop=100&ssop=4&id=".$_GET["id"]."&id_clas=".$_POST["id_clasificacio_tipus"],"op=1008&sop=100&id=".$_GET["id"]);
					$text_rutes = array($Anadir,$AnadiryEliminarIncompatibles,$Cancelar);
					echo "<center>";
						echo boton($rutes,$text_rutes);
					echo "</center><br><br>";
				}
			}
		}
		if ($id_client <= 0){
			$sql = "select * from sgm_clients where nombre='".$_POST["nombre"]."' and nif='".$_POST["nif"]."'";
		} else {
			$sql = "select * from sgm_clients where id=".$id_client;
		}
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
#		echo $sql;
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=1\" style=\"color:white;\">&laquo; ".$Volver."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=100&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Fiscales."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=110&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Administrativos."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=120&id=".$row["id"]."\" style=\"color:white;\">".$Contactos."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=130&id=".$row["id"]."\" style=\"color:white;\">".$Informes."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\" style=\"color:white;\">".$Contratos."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=150&id=".$row["id"]."\" style=\"color:white;\">".$Usuarios."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=160&id=".$row["id"]."\" style=\"color:white;\">".$Estado." de ".$Cuentas."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=170&id=".$row["id"]."\" style=\"color:white;\">".$Contrasenas."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=180&id=".$row["id"]."\" style=\"color:white;\">".$Incidencias."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=190&id=".$row["id"]."\" style=\"color:white;\">".$Archivos."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=200&id=".$row["id"]."\" style=\"color:white;\">".$Agrupacion."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=210&id=".$row["id"]."\" style=\"color:white;\">".$Direcciones_Envio."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=220&id=".$row["id"]."\" style=\"color:white;\">".$Servidores."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=230&id=".$row["id"]."\" style=\"color:white;\">".$Bases_Datos."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:500px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1008&sop=100&id=".$row["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</strong></a>";
					echo "<br>".$row["nif"];
					echo "<br><strong>".$row["direccion"]." </strong>";
					if ($row["cp"] != "") {echo " (".$row["cp"].") ";}
					echo "<strong>".$row["poblacion"]."</strong>";
					if ($row["provincia"] != "") {echo " (".$row["provincia"].")";}
					if ($row["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$row["telefono"]."</strong>"; }
					if ($row["mail"] != "") { echo "<br>".$Email." : <a href=\"mailto:".$row["email"]."\"><strong>".$row["mail"]."</strong></a>"; }
					if ($row["url"] != "") { echo "<br>".$Web." : <strong>".$row["url"]."</strong>"; }
					echo "<br><br>".$Otras." ".$Direcciones.":<br>";
					$sqlc = "select * from sgm_clients";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						if ($row["id_agrupacio"] > 0) {
							if (($rowc["id_agrupacio"] == $row["id_agrupacio"]) and ($row["id"] != $rowc ["id"])) {
								echo "<a href=\"index.php?op=1008&sop=100&id=".$rowc["id"]."\">";
								echo "<strong>".$rowc["direccion"]."</strong>";
								if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
								echo "<strong>".$rowc["poblacion"]."</strong>";
								if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
								echo "</a><br>";
							}
							if ($rowc["id"] == $row["id_agrupacio"]) {
								echo "<a href=\"index.php?op=1008&sop=100&id=".$rowc["id"]."\">";
								echo "(*)<strong>".$rowc["direccion"]."</strong>";
								if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
								echo "<strong>".$rowc["poblacion"]."</strong>";
								if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
								echo "</a><br>";
							}
						}
						if ($row["id_agrupacio"] == 0) {
							if (($rowc["id_agrupacio"] == $row["id"]) and ($row["id"] != $rowc ["id"])) {
								echo "<a href=\"index.php?op=1008&sop=100&id=".$rowc["id"]."\">";
								echo "<strong>".$rowc["direccion"]."</strong>";
								if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
								echo "<strong>".$rowc["poblacion"]."</strong>";
								if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
								echo "</a><br>";
							}
						}
					}
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=300&id=".$row["id"]."\" style=\"color:white;\">".$Opciones."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"mgestion/gestion-clientes-contact-print.php?id=".$row["id"]."\" style=\"color:white;\" target=\"_blank\">".$Imprimir."</a></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

#Edició client
	if ($soption == 100) {
		if ($ssoption == 3) {
			$camposInsert = "id_client,id_clasificacio_tipus";
			$datosInsert = array($_GET["id"],$_GET["id_clas"]);
			insertFunction ("sgm_clients_classificacio",$camposInsert,$datosInsert);
		}
		if ($ssoption == 4) {
				$sqln = "select id_clasificacio_tipus_neg from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_GET["id_clas"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select id from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus_neg"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$camposUpdate = array("visible");
						$datosUpdate = array("0");
						updateFunction ("sgm_clients_classificacio",$rowc["id"],$camposUpdate,$datosUpdate);
					}
				}
				$sqln = "select id_clasificacio_tipus from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus_neg=".$_GET["id_clas"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select id from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$camposUpdate = array("visible");
						$datosUpdate = array("0");
						updateFunction ("sgm_clients_classificacio",$rowc["id"],$camposUpdate,$datosUpdate);
					}
				}
			$camposInsert = "id_client,id_clasificacio_tipus";
			$datosInsert = array($_GET["id"],$_GET["id_clas"]);
			insertFunction ("sgm_clients_classificacio",$camposInsert,$datosInsert);
		}
		if ($ssoption == 5) {
			$sql = "update sgm_clients_classificacio set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id_clas"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_classificacio set ";
			$sql = $sql."predeterminado = 1";
			$sql = $sql." WHERE id=".$_GET["id_clas"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 6) {
			$sql = "update sgm_clients_classificacio set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id=".$_GET["id_clas"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 7) {
			$sql = "update sgm_clients_classificacio set visible=0 WHERE id_clasificacio_tipus=".$_GET["id_class"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}

		if ($id_client > 0) {
			$sql = "select * from sgm_clients where id=".$id_client;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1008&sop=100&ssop=2&id=".$id_client."\"  method=\"post\">";
		} 
		if ($id_client <= 0) {
			echo "<h4>".$Nuevo." ".$Cliente."</h4>";
			echo "<form action=\"index.php?op=1008&sop=100&ssop=1&id=-1\"  method=\"post\">";
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table style=\"background-color : Silver;\">";
						echo "<tr><td></td><th>".$Datos_Fiscales."</th></tr>";
						echo "<tr><th class=\"formclient\">*".$Nombre.": </th><td><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"  class=\"formclient\" required></td></tr>";
						echo "<tr><th class=\"formclient\">".$Apellido." 1: </th><td><input type=\"Text\" name=\"cognom1\" value=\"".$row["cognom1"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Apellido." 2: </th><td><input type=\"Text\" name=\"cognom2\" value=\"".$row["cognom2"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><td></td><td style=\"vertical-align:middle;\">";
							echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"1\" style=\"border:0px solid black\"";
							if ($row["tipo_identificador"] == 1) { echo " checked";}
							echo ">NIF&nbsp;&nbsp;";
							echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"2\" style=\"border:0px solid black\"";
							if ($row["tipo_identificador"] == 2) { echo " checked";}
							echo ">VAT&nbsp;&nbsp;";
							echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"3\" style=\"border:0px solid black\"";
							if ($row["tipo_identificador"] == 3) { echo " checked";}
							echo ">Extrangero&nbsp;&nbsp;";
							echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"4\" style=\"border:0px solid black\"";
							if ($row["tipo_identificador"] == 4) { echo " checked";}
							echo ">Sin&nbsp;&nbsp;";
						echo "</td></tr>";
						echo "<tr><th class=\"formclient\">".$Numero.": </th><td><input type=\"Text\" name=\"nif\" value=\"".$row["nif"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\" style=\"vertical-align:top;\">*".$Direccion.": </th><td><textarea name=\"direccion\" style=\"width:400px\" rows=\"3\">".$row["direccion"]."</textarea></td></tr>";
						echo "<tr><th class=\"formclient\">*".$CP.": </th><td><input type=\"Text\" name=\"cp\" value=\"".$row["cp"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">*".$Poblacion.": </th><td><input type=\"Text\" name=\"poblacion\" value=\"".$row["poblacion"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">*".$Provincia.": </th><td><input type=\"Text\" name=\"provincia\" value=\"".$row["provincia"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">*".$Pais.": </th>";
							echo "<td><select name=\"id_pais\" class=\"formclient\">";
							echo "<option value=\"0\">-</option>";
							$sqlo = "select id,pais from sgm_paises where visible=1 order by pais";
							$resulto = mysql_query(convert_sql($sqlo));
							while ($rowo = mysql_fetch_array($resulto)) {
								if ($id_client <= 0){
									if ($rowo["predefinido"] == 1){
										echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["pais"]."</option>";
									} else {
										echo "<option value=\"".$rowo["id"]."\">".$rowo["pais"]."</option>";
									}
								} else {
									if ($row["id_pais"] == $rowo["id"]){
										echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["pais"]."</option>";
									} else {
										echo "<option value=\"".$rowo["id"]."\">".$rowo["pais"]."</option>";
									}
								}
							}
						echo "</td></tr>";
						echo "<tr><td></td><td style=\"vertical-align:middle;width:400px;\">";
							echo "<input type=\"Radio\" name=\"tipo_persona\" value=\"0\" style=\"border:0px solid black\"";
							if ($row["tipo_persona"] == 0) { echo " checked";}
							echo ">".$Juridica."&nbsp;&nbsp;";
							echo "<input type=\"Radio\" name=\"tipo_persona\" value=\"1\" style=\"border:0px solid black\"";
							if ($row["tipo_persona"] == 1) { echo " checked";}
							echo ">".$Fisica."&nbsp;&nbsp;";
						echo "</td></tr>";
						echo "<tr><td></td><td style=\"vertical-align:middle;width:400px;\">";
							echo "<input type=\"Radio\" name=\"tipo_residencia\" value=\"0\" style=\"border:0px solid black\"";
							if ($row["tipo_residencia"] == 0) { echo " checked";}
							echo ">".$Residente."&nbsp;&nbsp;";
							echo "<input type=\"Radio\" name=\"tipo_residencia\" value=\"1\" style=\"border:0px solid black\"";
							if ($row["tipo_residencia"] == 1) { echo " checked";}
							echo ">".$Residente." UE&nbsp;&nbsp;";
							echo "<input type=\"Radio\" name=\"tipo_residencia\" value=\"2\" style=\"border:0px solid black\"";
							if ($row["tipo_residencia"] == 2) { echo " checked";}
							echo ">".$Extranjero."&nbsp;&nbsp;";
						echo "</td></tr>";
						echo "<tr><td></td><th>Facturae (DIR3):</th></tr>";
						echo "<tr><th class=\"formclient\">".$Oficina_contable.": </th><td><input type=\"Text\" name=\"dir3_oficina_contable\" value=\"".$row["dir3_oficina_contable"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Organo_gestor.": </th><td><input type=\"Text\" name=\"dir3_organo_gestor\" value=\"".$row["dir3_organo_gestor"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Unidad_tramitadora.": </th><td><input type=\"Text\" name=\"dir3_unidad_tramitadora\" value=\"".$row["dir3_unidad_tramitadora"]."\"  class=\"formclient\"></td></tr>";
					echo "</table>";
					echo "<table>";
						echo "<tr><td></td><th>".$Datos_Contacto."</th></tr>";
						echo "<tr><th class=\"formclient\">".$Email."</th><td colspan=\"3\"><input type=\"Text\" name=\"mail\" class=\"formclient\" value=\"".$row["mail"]."\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Telefono."</th><td><input type=\"Text\" name=\"telefono\"  style=\"width:120px\" value=\"".$row["telefono"]."\"></td>";
						echo "<th class=\"formclient\">".$Telefono." 2</th><td><input type=\"Text\" name=\"telefono2\" style=\"width:120px\" value=\"".$row["telefono2"]."\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Fax."</th><td><input type=\"Text\" name=\"fax\" style=\"width:120px\" value=\"".$row["fax"]."\"></td>";
						echo "<th class=\"formclient\">".$Fax." 2</th><td><input type=\"Text\" name=\"fax2\" style=\"width:120px\" value=\"".$row["fax2"]."\"></td></tr>";
					echo "</table>";
					echo "<table>";
						echo "<tr><td></td><th>".$Datos_Adicionales."</th></tr>";
						echo "<tr><th class=\"formclient\">".$Web."</th><td><input type=\"Text\" name=\"web\"  class=\"formclient\" value=\"".$row["web"]."\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Alias.": </th><td><input type=\"Text\" name=\"alias\" value=\"".$row["alias"]."\"  class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Idioma.": </th><td>";
							echo "<select name=\"id_idioma\" style=\"width:400px;\">";
							echo "<option value=\"0\">-</option>";
							$sqli = "select id,idioma from sgm_idiomas where visible=1 order by idioma";
							$resulti = mysql_query(convert_sql($sqli));
							while ($rowi = mysql_fetch_array($resulti)) {
								if (($id_client <= 0) and ($rowi["predefinido"] == 1)){
										echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["idioma"]."</option>";
								} elseif ($row["id_idioma"] == $rowi["id"]){
										echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["idioma"]."</option>";
								} else {
									echo "<option value=\"".$rowi["id"]."\">".$rowi["idioma"]."</option>";
								}
							}
						echo "</td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table>";
						echo "<tr><td></td><th>".$Dependencias."</th></tr>";
						echo "<tr><th class=\"formclient\">".$Delegacion." ".$Central."</th><td>";
							echo "<select name=\"id_origen\" style=\"width:300px\"><option value=\"0\">-</option>";
								$sqlo = "select id,nombre from sgm_clients where visible=1 order by nombre";
								$resulto = mysql_query(convert_sql($sqlo));
								while ($rowo = mysql_fetch_array($resulto)) {
									if ($rowo["id"] != $row["id"]) {
										if ($rowo["id"] == $row["id_origen"]) { echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>"; }
										else { echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>"; }
									}
								}
							echo "</select>";
						echo "<tr><th class=\"formclient\">".$Contacto." ".$Principal."</th><td>";
							echo "<select name=\"id_agrupacio\" style=\"width:300px\"><option value=\"0\">-</option>";
								$sqlo = "select id,nombre from sgm_clients where visible=1 order by nombre";
								$resulto = mysql_query(convert_sql($sqlo));
								while ($rowo = mysql_fetch_array($resulto)) {
									if ($rowo["id"] != $row["id"]) {
										if ($rowo["id"] == $row["id_agrupacio"]) { echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>"; }
										else { echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>"; }
									}
								}
							echo "</select>";
							echo "</td>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<th>".$Definicion." de ".$Cliente."</th>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td>";
								echo "<select name=\"id_clasificacio_tipus\" style=\"width:300px;\">";
									echo "<option value=\"0\">-</option>";
									$sqlo = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=0 order by nom";
									$resulto = mysql_query(convert_sql($sqlo));
									while ($rowo = mysql_fetch_array($resulto)) {
										$sqlv = "select count(*) as total from sgm_clients_classificacio where visible=1 and id_client=".$id_client." and id_clasificacio_tipus=".$rowo["id"];
										$resultv = mysql_query(convert_sql($sqlv));
										$rowv = mysql_fetch_array($resultv);
										if ($rowv["total"] == 0 ){
											echo "<option value=\"".$rowo["id"]."\">".$rowo["nom"]."</option>";
										}
										$sqlo2 = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowo["id"]." order by nom";
										$resulto2 = mysql_query(convert_sql($sqlo2));
										while ($rowo2 = mysql_fetch_array($resulto2)) {
											$sqlv2 = "select count(*) as total from sgm_clients_classificacio where visible=1 and id_client=".$id_client." and id_clasificacio_tipus=".$rowo2["id"];
											$resultv2 = mysql_query(convert_sql($sqlv2));
											$rowv2 = mysql_fetch_array($resultv2);
											if ($rowv2["total"] == 0 ){
												echo "<option value=\"".$rowo2["id"]."\">".$rowo["nom"]."-".$rowo2["nom"]."</option>";
											}
											$sqlo3 = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowo2["id"]." order by nom";
											$resulto3 = mysql_query(convert_sql($sqlo3));
											while ($rowo3 = mysql_fetch_array($resulto3)) {
												$sqlv3 = "select count(*) as total from sgm_clients_classificacio where visible=1 and id_client=".$id_client." and id_clasificacio_tipus=".$rowo3["id"];
												$resultv3 = mysql_query(convert_sql($sqlv3));
												$rowv3 = mysql_fetch_array($resultv3);
												if ($rowv3["total"] == 0 ){
													echo "<option value=\"".$rowo3["id"]."\">".$rowo["nom"]."-".$rowo2["nom"]."-".$rowo3["nom"]."</option>";
												}
											}
										}
									}
								echo "</select>";
							echo "</td>";
						echo "</tr>";
			$sqlcl = "select id_clasificacio_tipus,predeterminado,id from sgm_clients_classificacio where visible=1 and id_client=".$id_client;
			$resultcl = mysql_query(convert_sql($sqlcl));
			while ($rowcl = mysql_fetch_array($resultcl)) {
				$sqlcla = "select id,nom from sgm_clients_classificacio_tipus  where visible=1 and id=".$rowcl["id_clasificacio_tipus"];
				$resultcla = mysql_query(convert_sql($sqlcla));
				while ($rowcla = mysql_fetch_array($resultcla)) {
					$color = "white";
					if ($rowcl["predeterminado"] == 1) { $color = "#FF4500"; }
						echo "<tr>";
							echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1008&sop=101&id_class=".$rowcla["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
							echo "<td style=\"background-color : ".$color."\">".$rowcla["nom"]."</td>";
							echo "<td style=\"width:50px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								if ($rowcl["predeterminado"] == 1) {
									echo "<a href=\"index.php?op=1008&sop=100&ssop=6&id_clas=".$rowcl["id"]."&id=".$id_client."\" style=\"color:white;\">".$Despre."</a>";
								}
								if ($rowcl["predeterminado"] == 0) {
									echo "<a href=\"index.php?op=1008&sop=100&ssop=5&id_clas=".$rowcl["id"]."&id=".$id_client."\" style=\"color:white;\">".$Predet."</a>";
								}
							echo "</td>";
						echo "</tr>";
					}
				}
						echo "<tr><th class=\"formclient\">".$Cliente_fidelizado."</th><td>";
							if ($row["client"] == 1) {
								echo "SI <input type=\"Radio\" name=\"client\" value=\"1\" style=\"border:0px solid black\" checked>";
								echo "NO <input type=\"Radio\" name=\"client\" value=\"0\" style=\"border:0px solid black\">";
							}
							if ($row["client"] == 0) {
								echo "SI <input type=\"Radio\" name=\"client\" value=\"1\" style=\"border:0px solid black\">";
								echo "NO <input type=\"Radio\" name=\"client\" value=\"0\" style=\"border:0px solid black\" checked>";
							}
						echo "</td></tr>";
						echo "<tr><th class=\"formclient\">".$Cliente_vip."</th><td>";
							if ($row["clientvip"] == 1) {
								echo "SI <input type=\"Radio\" name=\"clientvip\" value=\"1\" style=\"border:0px solid black\" checked>";
								echo "NO <input type=\"Radio\" name=\"clientvip\" value=\"0\" style=\"border:0px solid black\">";
							}
							if ($row["clientvip"] == 0) {
								echo "SI <input type=\"Radio\" name=\"clientvip\" value=\"1\" style=\"border:0px solid black\">";
								echo "NO <input type=\"Radio\" name=\"clientvip\" value=\"0\" style=\"border:0px solid black\" checked>";
							}
						echo "</td></tr>";
						echo "<tr><th class=\"formclient\">".$Tipo."</th><td><select style=\"width:300px;\" name=\"id_tipo\">";
							echo "<option value=\"0\">Indeterminado</option>";
							$sql1 = "select id,tipo,predeterminado from sgm_clients_tipos order by tipo";
							$result1 = mysql_query(convert_sql($sql1));
							while ($row1 = mysql_fetch_array($result1)) {
								if (($row1["id"] == $row["id_tipo"]) or (($row1["predeterminado"] == 1) and ($id_client <= 0))) {
									echo "<option value=\"".$row1["id"]."\" selected>".$row1["tipo"]."</option>";
								} else {
									echo "<option value=\"".$row1["id"]."\">".$row1["tipo"]."</option>";
								}
							}
						echo "</select></td></tr>";
						echo "<tr><th class=\"formclient\">".$Grupo."</th><td><select style=\"width:300px;\" name=\"id_grupo\">";
						echo "<option value=\"0\">Indeterminado</option>";
							$sql1 = "select id,grupo,predeterminado from sgm_clients_grupos order by grupo";
							$result1 = mysql_query(convert_sql($sql1));
							while ($row1 = mysql_fetch_array($result1)) {
								if (($row1["id"] == $row["id_grupo"]) or (($row1["predeterminado"] == 1) and ($id_client <= 0))) {
									echo "<option value=\"".$row1["id"]."\" selected>".$row1["grupo"]."</option>";
								} else {
									echo "<option value=\"".$row1["id"]."\">".$row1["grupo"]."</option>";
								}
							}
						echo "</select></td></tr>";
						echo "<tr><th class=\"formclient\">".$Sector."</th><td><select style=\"width:300px;\" name=\"sector\">";
							echo "<option value=\"0\">Indeterminado</option>";
							$sql1 = "select id,sector,predeterminado from sgm_clients_sectors order by sector";
							$result1 = mysql_query(convert_sql($sql1));
							while ($row1 = mysql_fetch_array($result1)) {
								if (($row1["id"] == $row["sector"]) or (($row1["predeterminado"] == 1) and ($id_client <= 0))) {
									echo "<option value=\"".$row1["id"]."\" selected>".$row1["sector"]."</option>";
								} else {
									echo "<option value=\"".$row1["id"]."\">".$row1["sector"]."</option>";
								}
							}
						echo "</select></td></tr>";
						echo "<tr><th class=\"formclient\">".$Ubicacion."</th><td><select style=\"width:300px;\" name=\"id_ubicacion\">";
							echo "<option value=\"0\">Indeterminado</option>";
							$sql1 = "select id,ubicacion,predeterminado from sgm_clients_ubicacion order by ubicacion";
							$result1 = mysql_query(convert_sql($sql1));
							while ($row1 = mysql_fetch_array($result1)) {
								if (($row1["id"] == $row["id_ubicacion"]) or (($row1["predeterminado"] == 1) and ($id_client <= 0))) {
									echo "<option value=\"".$row1["id"]."\" selected>".$row1["ubicacion"]."</option>";
								} else {
									echo "<option value=\"".$row1["id"]."\">".$row1["ubicacion"]."</option>";
								}
							}
						echo "</select></td></tr>";
						echo "<tr>";
							echo "<th class=\"formclient\" style=\"vertical-align:top;\">".$Notas.": </th>";
							echo "<td><textarea name=\"notas\" style=\"width:300px\" rows=\"10\">".$row["notas"]."</textarea></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\"><tr><td>";
			if ($id_client > 0) { echo "<input type=\"Submit\" value=\"".$Guardar."\" style=\"width:500px;height:50px\">"; }
			if ($id_client <= 0) {	echo "<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:500px;height:50px\">"; }
		echo "</td></tr></table>";
		echo "</form>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td style=\"text-align:right;\">*</td><td>".$Campos_obligatorios."</td></tr>";
			echo "<tr><td style=\"text-align:right;\">Alias</td><td>".$Ajuda_alias."</td></tr>";
		echo "</table>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=100&ssop=7&id=".$_GET["id"]."&id_class=".$_GET["id_class"],"op=1008&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Dades administratives
	if ($soption == 110) {
		if ($ssoption == 1) {
			$camposUpdate = array("entidadbancaria","domiciliobancario","cuentabancaria");
			$datosUpdate = array($_POST["entidadbancaria"],$_POST["domiciliobancario"],$_POST["cuentabancaria"]);
			updateFunction ("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("dias_vencimiento","dias","dia_mes_vencimiento","cuentacontable");
			$datosUpdate = array($_POST["dias_vencimiento"],$_POST["dias"],$_POST["dia_mes_vencimiento"],$_POST["cuentacontable"]);
			updateFunction ("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
			$i = 1;
			$sqlz = "select id from sgm_clients_dias_facturacion where id_cliente=".$_GET["id"]." order by dia";
			$resultz = mysql_query(convert_sql($sqlz));
			while ($rowz = mysql_fetch_array($resultz)) {
				$i++;
				if ($_POST["dia_facturacion".$i.""] == 0) {
					deleteFunction ("sgm_clients_dias_facturacion",$rowz["id"]);
				} else {
					$camposUpdate = array("dia");
					$datosUpdate = array($_POST["dia_facturacion".$i.""]);
					updateFunction ("sgm_clients_dias_facturacion",$_GET["id"],$camposUpdate,$datosUpdate);
				}
			}

			if ($_POST["dia_facturacion1"] != 0) {
				$camposInsert = "dia,id_cliente";
				$datosInsert = array($_POST["dia_facturacion1"],$_GET["id"]);
				insertFunction ("sgm_clients_dias_facturacion",$camposInsert,$datosInsert);
			}
			$i = 1;
			$sqlz = "select id from sgm_clients_dias_recibos where id_cliente=".$_GET["id"]." order by dia";
			$resultz = mysql_query(convert_sql($sqlz));
			while ($rowz = mysql_fetch_array($resultz)) {
				$i++;
				if ($_POST["dia_recibo".$i.""] == 0) {
					deleteFunction ("sgm_clients_dias_recibos",$rowz["id"]);
				} else {
					$camposUpdate = array("dia");
					$datosUpdate = array($_POST["dia_recibo".$i.""]);
					updateFunction ("sgm_clients_dias_recibos",$_GET["id"],$camposUpdate,$datosUpdate);
				}
			}

			if ($_POST["dia_recibo1"] != 0) {
				$camposInsert = "dia,id_cliente";
				$datosInsert = array($_POST["dia_recibo1"],$_GET["id"]);
				insertFunction ("sgm_clients_dias_recibos",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 3) {
			$camposUpdate = array("coste_ekl","coste_em3","coste_miledia");
			$datosUpdate = array($_POST["coste_ekl"],$_POST["coste_em3"],$_POST["coste_miledia"]);
			updateFunction ("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sqltc = "select count(*) as total from sgm_tarifas_clients where predeterminado=1";
			$resulttc = mysql_query(convert_sql($sqltc));
			$rowtc = mysql_fetch_array($resulttc);
			if ($rowtc["total"]== 0){
				$camposInsert = "id_tarifa,id_cliente,predeterminado";
				$datosInsert = array($_POST["id_tarifa"],$_GET["id"],1);
				insertFunction ("sgm_tarifas_clients",$camposInsert,$datosInsert);
			} else {
				$camposInsert = "id_tarifa,id_cliente";
				$datosInsert = array($_POST["id_tarifa"],$_GET["id"]);
				insertFunction ("sgm_tarifas_clients",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 5) {
			$sql = "update sgm_tarifas_clients set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id_tarifa"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_tarifas_clients set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id_tarifa"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 6) {
			deleteFunction ("sgm_tarifas_clients",$_GET["id_tarifa"]);
		}

		$sql = "select * from sgm_clients where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<table style=\"width:100%\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><th>".$Datos_Facturacion." :</th></tr>";
						echo "<form action=\"index.php?op=1008&sop=110&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
						echo "<tr>";
							echo "<td>".$Dia." ".$Facturacion."</td>";
							echo "<td>";
								$i = 1;
								$sqlz = "select dia from sgm_clients_dias_facturacion where id_cliente=".$row["id"]." order by dia";
								$resultz = mysql_query(convert_sql($sqlz));
								$rowz = mysql_fetch_array($resultz);
								echo "<select name=\"dia_facturacion".$i."\">";
									echo "<option value=\"0\">-</option>";
									for ($x = 1; $x < 32; $x++) {
										if ($rowz["dia"] == $x) {
											echo "<option value=\"".$x."\" selected>".$x."</option>";
										} else {
											echo "<option value=\"".$x."\">".$x."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>".$Dia." ".$Recibo."</td>";
							echo "<td>";
								$i = 1;
								$sqlz = "select dia from sgm_clients_dias_recibos where id_cliente=".$row["id"]." order by dia";
								$resultz = mysql_query(convert_sql($sqlz));
								$rowz = mysql_fetch_array($resultz);
								echo "<select name=\"dia_recibo".$i."\">";
									echo "<option value=\"0\">-</option>";
									for ($x = 1; $x < 32; $x++) {
										if ($rowz["dia"] == $x) {
											echo "<option value=\"".$x."\" selected>".$x."</option>";
										} else {
											echo "<option value=\"".$x."\">".$x."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>".$Vencimiento."</td>";
							echo "<td><input type=\"Text\" name=\"dias_vencimiento\" style=\"width:50px\" value=\"".$row["dias_vencimiento"]."\">";
								echo "<select name=\"dias\">";
									if ($row["dias"] == 1) {
										echo "<option value=\"1\" selected>Días</option>";
										echo "<option value=\"0\">Meses</option>";
									}
									if ($row["dias"] == 0) {
										echo "<option value=\"1\">Días</option>";
										echo "<option value=\"0\" selected>Meses</option>";
									}
								echo "</select>";
								echo "Dia de mes: <select name=\"dia_mes_vencimiento\">";
									echo "<option value=\"0\">-</option>";
									for ($x = 1; $x < 32; $x++) {
										if ($row["dia_mes_vencimiento"] == $x) {
											echo "<option value=\"".$x."\" selected>".$x."</option>";
										} else {
											echo "<option value=\"".$x."\">".$x."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>".$Cuenta_Contable."</td><td><input type=\"Text\" name=\"cuentacontable\" style=\"width:300px\" value=\"".$row["cuentacontable"]."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td><input type=\"submit\" value=\"".$Guardar."\" style=\"width:300px\"></td>";
						echo "</tr>";
						echo "</form>";
						echo "</tr><td>&nbsp;</td><tr>";
						echo "<form action=\"index.php?op=1008&sop=110&ssop=1&id=".$_GET["id"]."\"  method=\"post\">";
						echo "<tr>";
							echo "<th>".$Datos_Bancarios." : </th>";
						echo "<tr>";
							echo "<td>".$Entidad.": </td>";
							echo "<td><input type=\"text\" name=\"entidadbancaria\" style=\"width:300px\" value=\"".$row["entidadbancaria"]."\"></td>";
						echo "</tr><tr>";
							echo "<td>".$Direccion.": </td>";
							echo "<td><input type=\"Text\" name=\"domiciliobancario\" style=\"width:300px\" value=\"".$row["domiciliobancario"]."\"></td>";
						echo "</tr><tr>";
							echo "<td>IBAN : </td>";
							echo "<td><input type=\"Text\" name=\"cuentabancaria\" style=\"width:300px\" value=\"".$row["cuentabancaria"]."\"></td>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td><input type=\"submit\" value=\"".$Guardar."\" style=\"width:300px\"></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;\">";
					echo "<form action=\"index.php?op=1008&sop=110&ssop=3&id=".$_GET["id"]."\"  method=\"post\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th><strong>".$Costes_Adicionales." : </strong></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>".$Costes." €/Kg.: </td>";
							echo "<td><input type=\"text\" name=\"coste_ekl\" style=\"width:300px\" value=\"".$row["coste_ekl"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td>".$Costes." €/m&sup3;: </td>";
							echo "<td><input type=\"Text\" name=\"coste_em3\" style=\"width:300px\" value=\"".$row["coste_em3"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td>".$Costes." 1000€/dia: </td>";
							echo "<td><input type=\"Text\" name=\"coste_miledia\" style=\"width:300px\" value=\"".$row["coste_miledia"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td><input type=\"submit\" value=\"".$Guardar."\" style=\"width:300px\"></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
					echo "<br><br><br>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver\">";
							echo "<th></th>";
							echo "<th>".$Eliminar."</th>";
							echo "<th>Tarifa</th>";
							echo "<th></th>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1008&sop=110&ssop=4&id=".$_GET["id"]."\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><select style=\"width:200px\" name=\"id_tarifa\">";
								$sqlt = "select id,nombre from sgm_tarifas where visible=1";
								$resultt = mysql_query(convert_sql($sqlt));
								while ($rowt = mysql_fetch_array($resultt)){
									echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
								}
							echo "</td>";
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sqltc = "select id,predeterminado,id_tarifa from sgm_tarifas_clients where id_cliente=".$row["id"]."";
						$resulttc = mysql_query(convert_sql($sqltc));
						while ($rowtc = mysql_fetch_array($resulttc)) {
							$color = "white";
							if ($rowtc["predeterminado"] == 1) { $color = "#FF4500"; }
							echo "<tr style=\"background-color : ".$color."\">";
								echo "<td>";
								if ($rowtc["predeterminado"] == 1) {
									echo "<form action=\"index.php?op=1008&sop=110&ssop=5&s=0&id=".$row["id"]."&id_tarifa=".$rowtc["id"]."\" method=\"post\">";
										echo "<input type=\"Submit\" value=\"".$Despre."\">";
									echo "</form>";
								}
								if ($rowtc["predeterminado"] == 0) {
									echo "<form action=\"index.php?op=1008&sop=110&ssop=5&s=1&id=".$row["id"]."&id_tarifa=".$rowtc["id"]."\" method=\"post\">";
										echo "<input type=\"Submit\" value=\"".$Predet."\">";
									echo "</form>";
								}
								echo "</td>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=111&id=".$_GET["id"]."&id_tarifa=".$rowtc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
								$sqlt = "select nombre from sgm_tarifas where visible=1 and id=".$rowtc["id_tarifa"]."";
								$resultt = mysql_query(convert_sql($sqlt));
								$rowt = mysql_fetch_array($resultt);
								echo "<td><input type=\"text\" value=\"".$rowt["nombre"]."\" style=\"width:200px\" name=\"nombre\"></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=110&ssop=6&id=".$_GET["id"]."&id_tarifa=".$_GET["id_tarifa"],"op=1008&sop=110&ssop=6&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Contactes
	if ($soption == 120) {
		if ($ssoption == 1){
			$camposInsert = "id_trato,nombre,apellido1,apellido2,carrec,departament,telefono,fax,mail,movil,notas,id_client,id_idioma";
			$datosInsert = array($_POST["id_trato"],comillas($_POST["nombre"]),comillas($_POST["apellido1"]),comillas($_POST["apellido2"]),comillas($_POST["carrec"]),comillas($_POST["departament"]),$_POST["telefono"],$_POST["fax"],$_POST["mail"],$_POST["movil"],comillas($_POST["notas"]),$_GET["id"],$_POST["id_idioma"]);
			insertFunction ("sgm_clients_contactos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("id_trato","nombre","apellido1","apellido2","carrec","departament","telefono","fax","mail","movil","notas","id_idioma");
			$datosUpdate = array($_POST["id_trato"],comillas($_POST["nombre"]),comillas($_POST["apellido1"]),comillas($_POST["apellido2"]),comillas($_POST["carrec"]),comillas($_POST["departament"]),$_POST["telefono"],$_POST["fax"],$_POST["mail"],$_POST["movil"],comillas($_POST["notas"]),$_POST["id_idioma"]);
			updateFunction ("sgm_clients_contactos",$_GET["id_contacto"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3){
			updateFunction ("sgm_clients_contactos",$_GET["id_contacto"],array("visible"),array("0"));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_clients_contactos set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id<>".$_GET["id_contacto"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
			updateFunction ("sgm_clients_contactos",$_GET["id_contacto"],array("pred"),array("1"));
		}
		if ($ssoption == 5) {
			updateFunction ("sgm_clients_contactos",$_GET["id_contacto"],array("pred"),array("0"));
		}
		echo "<h4>".$Contactos."</h4>";
		echo boton(array("op=1008&sop=122&ssop=1&id=".$_GET["id"]),array($Anadir." ".$Contacto));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th style=\"width:50px;text-align:right;\">".$Predeterminar."</th>";
				echo "<th style=\"width:50px;text-align:right;\">".$Eliminar."</th>";
				echo "<th style=\"width:300px;text-align:left;\">".$Nombre." ".$Contacto."</th>";
				echo "<th style=\"width:200px;text-align:left;\">".$Cargo."</th>";
				echo "<th style=\"width:100px;text-align:center;\">".$Telefono."</th>";
				echo "<th style=\"width:100px;text-align:center;\">".$Movil."</th>";
				echo "<th></th>";
				echo "<th style=\"width:30px;text-align:center;\">".$Ver."</th>";
				echo "<th style=\"width:30px;text-align:center;\">".$Editar."</th>";
			echo "</tr>";
			$sql = "select * from sgm_clients_contactos where id_client=".$_GET["id"]." and visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				$color = "white";
				$colorl = "black";
				if ($row["pred"] == 1) { $color = "#FF4500"; $colorl = "white";}
					echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["pred"] == 1) {
						echo "<form action=\"index.php?op=1008&sop=120&ssop=5&id=".$_GET["id"]."&id_contacto=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\">";
						echo "</form>";
					}
					if ($row["pred"] == 0) {
						echo "<form action=\"index.php?op=1008&sop=120&ssop=4&id=".$_GET["id"]."&id_contacto=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\">";
						echo "</form>";
					}
					echo "</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=121&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						$sqlt = "select trato from sgm_clients_tratos where id=".$row["id_trato"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
						echo "<td style=\"color:".$colorl.";\">".$rowt["trato"]." ".$row["nombre"]." ".$row["apellido1"]." ".$row["apellido2"]."</td>";
						echo "<td style=\"color:".$colorl.";\">".$row["carrec"]."</td>";
						echo "<td style=\"color:".$colorl.";\">".$row["telefono"]."</td>";
						echo "<td style=\"text-align:center;color:".$colorl.";\">".$row["movil"]."</td>";
						echo "<td style=\"text-align:center;color:".$colorl.";\">";
							if ($row["mail"] != "") { echo "<a href=\"mailto:".$row["mail"]."\"><img src=\"mgestion/pics/icons-mini/email_link.png\" style=\"border:0px\"></a>"; }
						echo "</td>";
					echo "<td style=\"text-align:center;color:".$colorl.";\"><a href=\"index.php?op=1008&sop=122&ssop=0&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px\"></a></td>";
					echo "<td style=\"text-align:center;color:".$colorl.";\"><a href=\"index.php?op=1008&sop=122&ssop=2&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 121) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=120&ssop=3&id=".$_GET["id"]."&id_contacto=".$_GET["id_contacto"],"op=1008&sop=120&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Detall de contacte
	if ($soption == 122) {
		$sqlc = "select * from sgm_clients_contactos where id=".$_GET["id_contacto"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);

		if ($ssoption == 1) { 
			echo "<h4>".$Anadir." ".$Contacto."</h4>";
			echo "<form action=\"index.php?op=1008&sop=120&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
		}
		if ($ssoption == 2) {
			echo "<h4>".$Editar." ".$Contacto."</h4>";
			echo "<form action=\"index.php?op=1008&sop=120&ssop=2&id=".$_GET["id"]."&id_contacto=".$_GET["id_contacto"]."\" method=\"post\">";
		}
		echo boton(array("op=1008&sop=120&id=".$_GET["id"]),array("&laquo; ".$Volver));
		$selecionar = 0;
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				if ($ssoption == 1) { echo "<td></td><td><input type=\"submit\" value=\"".$Anadir."\"></td>"; }
				if (($ssoption == 2) or ($ssoption == 4)) { echo "<td></td><td><input type=\"submit\" value=\"".$Modificar."\"></td>"; }
			echo "</tr><tr>";
				echo "<th>".$Trato.": </th>";
				echo "<td><select name=\"id_trato\" style=\"width:50px\">";
						$sqlt = "select * from sgm_clients_tratos order by trato";
						$resultt = mysql_query(convert_sql($sqlt));
						while ($rowt = mysql_fetch_array($resultt)) {
							if ($rowt["id"] == $rowc["id_trato"]) {
								echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["trato"]."</option>";
								$seleccionar = 1;
							} else {
								if (($rowt["predeterminado"] == 1) and ($selecionar == 0)){
									echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["trato"]."</option>";
								} else {
									echo "<option value=\"".$rowt["id"]."\">".$rowt["trato"]."</option>";
								}
							}
						}

				echo "</select></td>";
			echo "</tr><tr>";
				echo "<th>".$Nombre.": </th>";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:200px\" value=\"".$rowc["nombre"]."\" required></td>";
			echo "</tr><tr>";
				echo "<th>".$Apellido." 1: </th>";
				echo "<td><input type=\"text\" name=\"apellido1\" style=\"width:200px\" value=\"".$rowc["apellido1"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Apellido." 2: </th>";
				echo "<td><input type=\"text\" name=\"apellido2\" style=\"width:200px\" value=\"".$rowc["apellido2"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Departamento.": </th>";
				echo "<td><input type=\"text\" name=\"departament\" style=\"width:200px\" value=\"".$rowc["departament"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Cargo.": </th>";
				echo "<td><input type=\"text\" name=\"carrec\" style=\"width:200px\" value=\"".$rowc["carrec"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Telefono.": </th>";
				echo "<td><input type=\"text\" name=\"telefono\" style=\"width:200px\" value=\"".$rowc["telefono"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Fax.": </th>";
				echo "<td><input type=\"text\" name=\"fax\" style=\"width:200px\" value=\"".$rowc["fax"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Email.": </th>";
				echo "<td><input type=\"text\" name=\"mail\" style=\"width:200px\" value=\"".$rowc["mail"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Movil.": </th>";
				echo "<td><input type=\"text\" name=\"movil\" style=\"width:200px\" value=\"".$rowc["movil"]."\"></td>";
			echo "</tr><tr>";
				echo "<th>".$Idioma.": </th>";
				echo "<td><select name=\"id_idioma\" style=\"width:200px\">";
				echo "<option value=\"0\">-</option>";
				$sql = "select id,idioma from sgm_idiomas where visible=1";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)){
					$sqlcl = "select id_idioma from sgm_clients where visible=1 and id=".$rowc["id_client"];
					$resultcl = mysql_query(convert_sql($sqlcl));
					$rowcl = mysql_fetch_array($resultcl);
					if (($rowc[$pre."id_idioma"] == 0) and ($row["id"] == $rowcl["id_idioma"])){
						echo "<option value=\"".$row["id"]."\" selected>".$row["idioma"]."</option>";
					}
					if ($rowc[$pre."id_idioma"] == $row["id"]){
						echo "<option value=\"".$row["id"]."\" selected>".$row["idioma"]."</option>";
					} else {
						echo "<option value=\"".$row["id"]."\">".$row["idioma"]."</option>";
					}
				}
				echo "</select></td>";
			echo "</tr><tr>";
				echo "<th style=\";vertical-align:top;\">".$Notas."</th>";
				echo "<td><textarea name=\"notas\" class=\"px400\" rows=\"9\">".$rowc["notas"]."</textarea></td>";
			echo "</tr><tr>";
			if ($ssoption == 1) { echo "<td></td><td><input type=\"submit\" value=\"".$Anadir."\"></td>"; }
			if (($ssoption == 2) or ($ssoption == 4)) { echo "<td></td><td><input type=\"submit\" value=\"".$Modificar."\"></td>"; }
			echo "</tr>";
		echo "</table>";
		echo "</form>";
	}
	
#Informes
	if ($soption == 130) {
		informesContratos();
	}

#Contractes
	if ($soption == 140) {
		echo "<h4>".$Contratos." : </h4>";
		if ($_GET["hist"] == 0) {echo boton(array("op=1008&sop=140&id=".$_GET["id"]."&hist=1"),array($Historico));}
		if ($_GET["hist"] == 1) {echo boton(array("op=1008&sop=140&id=".$_GET["id"]."&hist=0"),array($Activos));}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Cliente."</th>";
				echo "<th>".$Cliente." ".$Final."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sgm_contratos where visible=1 and id_cliente=".$_GET["id"]."";
			if ($_GET["hist"] == 0) { $sqlcc .= " and activo=1";}
			$resultcc = mysql_query(convert_sql($sqlcc));
			while ($rowcc = mysql_fetch_array($resultcc)){
				echo "<tr>";
					$sql = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<td>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</td>";
					$sql = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<td>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
					echo "<td>".$rowcc["descripcion"]."</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=141&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a></td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=142&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_get.png\" alt=\"Subir\" border=\"0\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
	}

#Detall del Contracte
	if ($soption == 141) {
		echo "<h4>".$Contrato." : </h4>";
		echo boton(array("op=1008&sop=140&id=".$_GET["id"]),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		$sqlc = "select * from sgm_contratos where visible=1 and id=".$_GET["id_con"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$numeroc = $rowc["num_contrato"];
			echo "<tr><th>".$Numero." :</th><td>".$numeroc."</td></tr>";
			echo "<tr><th>".$Contrato." :</th>";
				$sql = "select nombre from sgm_contratos_tipos where visible=1 and id=".$rowc["id_contrato_tipo"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<td>".$row["nombre"]."</td>";
			echo "</tr>";
			echo "<tr><th>".$Cliente." :</th>";
				$sqla = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
				$resulta = mysql_query(convert_sql($sqla));
				$rowa = mysql_fetch_array($resulta);
				echo "<td>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</td>";
			echo "</tr>";
			echo "<tr><th>".$Cliente." ".$Final." :</th>";
				$sqlb = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"];
				$resultb = mysql_query(convert_sql($sqlb));
				$rowb = mysql_fetch_array($resultb);
				echo "<td>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</td></tr>";
			echo "<tr><th>".$Descripcion." :</th><td>".$rowc["descripcion"]."</td></tr>";
			echo "<tr><th>".$Fecha." ".$Inicio." :</th><td>".$rowc["fecha_ini"]."</td></tr>";
			echo "<tr><th>".$Fecha." ".$Fin." :</th><td>".$rowc["fecha_fin"]."</td></tr>";
			if ($rowc["activo"] == 1) {
				echo "<td></td><td style=\"background-color:YellowGreen\">".$Activo."</td>";
			} else {
				echo "<td></td><td style=\"background-color:red\">".$Inactivo."</td>";
			}
		echo "</table>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td>".$SLA."</td></tr>";
			echo "<tr style=\"background-color:silver\">";
				echo "<th style=\"text-align:left;\">".$Servicio."</th>";
				echo "<th style=\"text-align:left;\">".$Cobertura."</th>";
				echo "<th style=\"text-align:left;\">".$Tiempo."</th>";
				echo "<th style=\"text-align:left;\">".$NBD."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id_con"];
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td>".$row["servicio"]."</td>";
				$sqls = "select nombre from sgm_contratos_sla_cobertura where visible=1 and id=".$row["id_cobertura"];
				$results = mysql_query(convert_sql($sqls));
				$rows = mysql_fetch_array($results);
					echo "<td>".$rows["nombre"]."</td>";
					echo "<td>".$row["temps_resposta"]."</td>";
					echo "<td>";
						if ($row["nbd"] == 1){
							echo "Si";
						} else {
							echo "No";
						}
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

#Archius contractes
	if ($soption == 142) {
		if ($ssoption == 1) {
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
			echo subirArchivo($tipo,$archivo,$archivo_name,$archivo_size,$archivo_type,3,$_GET["id_con"]);
		}
		if ($ssoption == 2) {
			$sqlf = "select name from sgm_files where id=".$_GET["id_archivo"];
			$resultf = mysql_query(convert_sql($sqlf));
			$rowf = mysql_fetch_array($resultf);
			deleteFunction ("sgm_files",$_GET["id_archivo"]);
			$filepath = "archivos/articulos/".$rowf["name"];
			unlink($filepath);
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"width:70%;vertical-align:top;\">";
					echo "<h4>".$Archivos." :</h4>";
					echo "<table>";
					$sql = "select * from sgm_files_tipos order by nombre";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=3 and id_elemento=".$_GET["id_con"];
						$resultele = mysql_query(convert_sql($sqlele));
						while ($rowele = mysql_fetch_array($resultele)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=143&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
								echo "<td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/archivos/contratos/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
							echo "</tr>";
						}
					}
					echo "</table>";
				echo "</td><td style=\"width:30%;vertical-align:top;\">";
					echo "<h4>".$Formulario_Subir_Archivo." :</h4>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1008&sop=142&ssop=1&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."\" method=\"post\">";
					echo "<table>";
						echo "<tr>";
							echo "<td><select name=\"id_tipo\" style=\"width:300px\">";
								$sql = "select * from sgm_files_tipos order by nombre";
								$result = mysql_query(convert_sql($sql));
								while ($row = mysql_fetch_array($result)) {
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><td><input type=\"file\" name=\"archivo\" size=\"30px\"></td></tr>";
						echo "<tr><td><input type=\"submit\" value=\"Enviar a la carpeta /archivos/contratos/\" style=\"width:300px\"></td></tr>";
					echo "</table>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 143) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=142&ssop=2&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$_GET["id_archivo"],"op=1008&sop=142&id=".$_GET["id"]."&id_con=".$_GET["id_con"]),array($Si,$No));
		echo "</center>";
	}


#Usuaris
	if ($soption == 150) {
		echo "<h4>".$Usuarios." :</h4>";
		echo boton(array("op=1008&sop=151&id=".$_GET["id"]),array($Anadir." ".$Usuario));
		mostrarUsuari("select * from sgm_users where id in (select id_user from sgm_users_clients where id_client=".$_GET["id"].") and activo=1 order by usuario","151&id=".$_GET["id"],"152&id=".$_GET["id"],"153&id=".$_GET["id"]);
	}

#Modificar Usuaris
	if ($soption == 151) {
		echo afegirModificarUsuari ("op=1008&sop=150&id=".$_GET["id"]);
	}

#Modificar Permisos dels Usuaris
	if ($soption == 152) {
		echo modificarPermisosUsuaris ("op=1008&sop=150&id=".$_GET["id"],"op=1008&sop=152&id=".$_GET["id"]);
	}

#Facturació
	if ($soption == 160) {
		echo "<h4>".$Estado_de_Cuentas."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		$sql = "select id,tipo from sgm_factura_tipos where visible=1 and tpv=0 order by orden,tipo";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr><th colspan=\"2\">".$row["tipo"]." :</th></tr>";
			$sqlf = "select id,numero,fecha,total,cobrada,cerrada,confirmada,confirmada_cliente from sgm_cabezera where tipo=".$row["id"]." and visible=1 and id_cliente=".$_GET["id"]." order by fecha";;
			$resultf = mysql_query(convert_sql($sqlf));
			$poner_cabezera = 1;
			while ($rowf = mysql_fetch_array($resultf)) {
				if ($poner_cabezera == 1) {
					echo "<tr style=\"background-color:silver;\">";
						echo "<th style=\"width:100px;text-align:right;\">".$Numero."</th>";
						echo "<th style=\"width:100px;text-align:right;\">".$Fecha."</th>";
						echo "<th style=\"width:100px;text-align:right;\">".$Importe."</th>";
						echo "<th style=\"width:100px;text-align:center;\">".$Cobrada."</th>";
						echo "<th style=\"width:100px;text-align:center;\">".$Cerrada."</th>";
						echo "<th style=\"width:100px;text-align:center;\">".$Confirmada."</th>";
						echo "<th style=\"width:100px;text-align:center;\">".$Confirmada." ".$Cliente."</th></tr>";
					$poner_cabezera = 0;
				}
				echo "<tr><td style=\"text-align:right;\">".$rowf["numero"]."</td><td style=\"text-align:right;\">".$rowf["fecha"]."</td><td style=\"text-align:right;\">".$rowf["total"]."</td>";
				if ($rowf["cobrada"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				if ($rowf["cerrada"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				if ($rowf["confirmada"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				if ($rowf["confirmada_cliente"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=100&id=".$rowf["id"]."&id_tipo=".$row["id"]."\"><input type=\"Submit\" value=\"".$Editar."\"></form></td>";
				echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=20&id=".$rowf["id"]."&id_tipo=".$row["id"]."\"><input type=\"Submit\" value=\"".$Imprimir."\"></form></td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}

#Contrasenyes
	if ($soption == 170) {
		echo "<h4>".$Contrasenas." :</h4>";
		echo boton(array("op=1008&sop=172&id=".$_GET["id"]),array($Anadir." ".$Contrasenas));
		mostrarContrasenyes ("op=1008&sop=172&id=".$_GET["id"],"op=1008&sop=171&id=".$_GET["id"],"op=1008&sop=173&id=".$_GET["id"],"op=1008&sop=174&id=".$_GET["id"]);
	}

	if ($soption == 171) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=170&ssop=3&id=".$_GET["id"]."&id_con=".$_GET["id_con"],"op=1008&sop=170&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Afegir / Modificar contrasenyes
	if ($soption == 172) {
		echo  afegirModificarContrasenya("op=1008&sop=170&id=".$_GET["id"]);
	}

#Modificar contrasenya
	if ($soption == 173) {
		echo  modificarContrasenya("op=1008&sop=170&id=".$_GET["id"]);
	}

#Mostrar contrasenya
	if ($soption == 174) {
		echo mostrarContrasenya();
	}

#Incidències
	if ($soption == 180) {
		echo "<h4>".$Incidencias." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"background-color:silver;\">";
			echo "<tr>";
				echo "<th>".$Contrato."</th>";
				echo "<th>".$Fecha." (".$Mes.")</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
			echo "<form action=\"index.php?op=1008&sop=180&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_servicio\" style=\"width:600px\" >";
					echo "<option value=\"0\" selected>-</option>";
					$sqlc = "select id,id_cliente,id_cliente_final from sgm_contratos where visible=1 and id_cliente=".$_GET["id"]." order by num_contrato";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						$sqlcl = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"]." order by nombre";
						$resultcl = mysql_query(convert_sql($sqlcl));
						$rowcl = mysql_fetch_array($resultcl);
						$sqlcli = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"]." order by nombre";
						$resultcli = mysql_query(convert_sql($sqlcli));
						$rowcli = mysql_fetch_array($resultcli);
						$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"];
						$results = mysql_query(convert_sql($sqls));
						while ($rows = mysql_fetch_array($results)){
							if ($_POST["id_servicio"] == $rows["id"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."(".$rowcli["nombre"]." ".$rowcli["cognom1"]." ".$rowcli["cognom2"].")".$rows["servicio"]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."(".$rowcli["nombre"]." ".$rowcli["cognom1"]." ".$rowcli["cognom2"].")".$rows["servicio"]."</option>";
							}
						}
					}
				echo "</select></td>";
				echo "<td><select name=\"mes\" style=\"width:100px\">";
					echo "<option value=\"0\" selected>-</option>";
						for ($j=1;$j<=12;$j++){
							if (($j == $_POST["mes"]) or ($j == $_GET["m"])){
								echo "<option value=\"".$j."\" selected>".$j."</option>";
							} else {
								echo "<option value=\"".$j."\">".$j."</option>";
							}
						}
					echo "</select></td>";
				echo "<td><select name=\"id_usuario\" style=\"width:150px\">";
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
				echo "<td><input type=\"Submit\" value=\"".$Buscar."\"></td>";
			echo "</tr>";
		echo "</form>";
		echo "</table>";
		echo "<br><br>";
		echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\" style=\"background-color:silver;\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$SLA."</th>";
				echo "<th>".$Fecha." ".$Prevision."</th>";
				echo "<th>".$Asunto."</th>";
				echo "<th>".$Cliente." ".$Final."</th>";
				echo "<th>".$Contrato." - ".$Servicio."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th></th>";
			echo "</tr>";

			$sqls = "select id,id_cliente_final,descripcion from sgm_contratos where id_cliente=".$_GET["id"]." order by fecha_ini desc";
			$results = mysql_query(convert_sql($sqls));
			while ($rows = mysql_fetch_array($results)){
				$sqlc = "select id,temps_resposta,servicio from sgm_contratos_servicio where id_contrato=".$rows["id"];
				if ($_POST["id_servicio"] != 0) { $sqlc = $sqlc." and id=".$_POST["id_servicio"].""; }
				$resultc = mysql_query(convert_sql($sqlc));
				while ($rowc = mysql_fetch_array($resultc)) {

					$sql = "select * from sgm_incidencias where visible=1 and id_servicio=".$rowc["id"]."";
					if (($_POST["mes"] != 0) or ($_GET["m"] != 0)){
						$mes = $_POST["mes"].$_GET["m"];
						if ($_GET["d"] != 0){
							$data1 = date(U, mktime(0, 0, 0, $mes, $_GET["d"], 2013));
							$data2 = date(U, mktime(0, 0, 0, $mes, $_GET["d"]+1, 2013));
						} else {
							$data1 = date(U, mktime(0, 0, 0, $mes, 1, 2013));
							$data2 = date(U, mktime(0, 0, 0, $mes, 31, 2013));
						}
						$sql = $sql." and id in (select id_incidencia from sgm_incidencias_notas_desarrollo where data_registro2 between ".$data1." and ".$data2.")";
					}
					if (($_POST["id_usuario"] != 0) or ($_GET["u"] != 0)) { $sql = $sql." and id_usuario=".$_POST["id_usuario"].$_GET["u"].""; }
					$sql = $sql." order by fecha_prevision asc";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						$sqlcli = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rows["id_cliente_final"]." order by nombre";
						$resultcli = mysql_query(convert_sql($sqlcli));
						$rowcli = mysql_fetch_array($resultcli);

						$estado_color = "White";
						$estado_color_letras = "Black";
						$sqlu = "select usuario from sgm_users where id=".$row["id_usuario_destino"];
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu = mysql_fetch_array($resultu);
						$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]." and visible=1";
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$hora = $rowd["total"]/60;
						$horas = explode(".",$hora);
						$minutos = $rowd["total"] % 60;
						if ($rowc["temps_resposta"] != 0){
							$hora_actual = time();
							$hora_limit = $row["temps_pendent"]/3600;
							$horas2 = explode(".",$hora_limit);
							$minuto2 = (($hora_limit - $horas2[0])*60);
							$minutos2 = explode(".",$minuto2);
							$sla = "".$horas2[0]." h. ".$minutos2[0]." m.";
							if ($horas2[0] > 4){
									$estado_color = "White";
									$estado_color_letras = "Black";
							}
							if (($horas2[0] <= 4) and ($total >= 0)) {
									$estado_color = "Orange";
									$estado_color_letras = "White";
							}
							if ($horas2[0] < 0) {
								$estado_color = "Red";
								$estado_color_letras = "White";
							}
							if ($row["id_estado"] == -1) { $fecha_prev = date("Y-m-d H:i:s", $row["fecha_prevision"]); }
							if ($row["id_estado"] == -2) { $fecha_prev = date("Y-m-d H:i:s", $row["fecha_registro_cierre"]); }
						} else {
							$sla = "";
							$fecha_prev = "";
						}
						echo "<tr style=\"background-color:".$estado_color.";\">";
							echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$sla."</td>";
							echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$fecha_prev."</td>";
							if (strlen($row["nombre"]) > 50) {
								echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".substr($row["asunto"],0,50)." ...</td>";
							} else {
								echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$row["asunto"]."</a></td>";
							}
							echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowcli["nombre"]." ".$rowcli["cognom1"]." ".$rowcli["cognom2"]."</td>";
							echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rows["descripcion"]." - ".$rowc["servicio"]."</td>";
							echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowu["usuario"]."</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<a href=\"index.php?op=1018&sop=100&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"><a>";
							echo "</td>";
						echo "</tr>";
					}
				}
			}
		echo "</table>";
	}

#Archius client
	if ($soption == 190) {
		if ($ssoption == 1) {
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
			echo subirArchivo($tipo, $archivo, $archivo_name, $archivo_size, $archivo_type,2,$_GET["id"]);
		}
		if ($ssoption == 2) {
			deleteFunction ("sgm_files",$_GET["id_archivo"]);
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"width:400px;vertical-align:top;\">";
					echo "<h4>".$Archivos." :</h4>";
					echo "<table>";
					$sql = "select * from sgm_files_tipos order by nombre";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=2 and id_elemento=".$_GET["id"];
						$resultele = mysql_query(convert_sql($sqlele));
						while ($rowele = mysql_fetch_array($resultele)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=191&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
								echo "<td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/archivos/clientes/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong></td>";
								echo "<td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
							echo "</tr>";
						}
					}
					echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
				echo "<h4>".$Formulario_Subir_Archivo." :</h4>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1008&sop=190&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<table>";
						echo "<tr>";
							echo "<td><select name=\"id_tipo\" style=\"width:300px\">";
								$sql = "select * from sgm_files_tipos order by nombre";
								$result = mysql_query(convert_sql($sql));
								while ($row = mysql_fetch_array($result)) {
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><td><input type=\"file\" name=\"archivo\" size=\"30px\"></td></tr>";
						echo "<tr><td><input type=\"submit\" value=\"Enviar a la carpeta /archivos/clientes/\" style=\"width:300px\"></td></tr>";
					echo "</table>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 191) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=190&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1008&sop=190&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 200) {
		echo "<h4>".$Agrupacion." ".$Clientes." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" Style=\"width:100%\">";
			echo "<tr>";
		$x = 0;
		$sqlc = "select * from sgm_clients order by nombre";
		$resultc = mysql_query(convert_sql($sqlc));
		while ($rowc = mysql_fetch_array($resultc)) {
			if ($x >= 4){
				echo "</tr><tr>";
				$x = 0;
			}
			if ($row["id_agrupacio"] > 0) {
				if (($rowc["id_agrupacio"] == $row["id_agrupacio"]) and ($row["id"] != $rowc ["id"])) {
					echo "<td style=\"width:250px;height:100px;background-color:silver;vertical-align:top;\">";
					echo "<a href=\"index.php?op=1008&sop=100&id=".$rowc["id"]."\">";
					echo "<strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$rowc["nombre"]."</strong></a>";
					echo "<br>".$rowc["nif"];
					echo "<br><strong>".$rowc["direccion"]."</strong>";
					if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
					echo "<strong>".$rowc["poblacion"]."</strong>";
					if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
					echo "<br>";
					if ($rowc["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$rowc["telefono"]."</strong>"; }
					if ($rowc["mail"] != "") { echo "<br>".$Email." : <a href=\"mailto:".$rowc["email"]."\"><strong>".$rowc["mail"]."</strong></a>"; }
					if ($rowc["url"] != "") { echo "<br>".$Web." : <strong>".$rowc["url"]."</strong>"; }
					echo "</a></td>";
					$x++;
				}
				if ($rowc["id"] == $row["id_agrupacio"]) {
					echo "<td style=\"width:250px;height:100px;background-color:silver;vertical-align:top;\">";
					echo "<a href=\"index.php?op=1008&sop=100&id=".$rowc["id"]."\">";
					echo "<strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$rowc["nombre"]."(*)</strong></a>";
					echo "<br>".$rowc["nif"];
					echo "<br><strong>".$rowc["direccion"]."</strong>";
					if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
					echo "<strong>".$rowc["poblacion"]."</strong>";
					if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
					echo "<br>";
					if ($rowc["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$rowc["telefono"]."</strong>"; }
					if ($rowc["mail"] != "") { echo "<br>".$Email." : <a href=\"mailto:".$rowc["email"]."\"><strong>".$rowc["mail"]."</strong></a>"; }
					if ($rowc["url"] != "") { echo "<br>".$Web." : <strong>".$rowc["url"]."</strong>"; }
					echo "</a></td>";
					$x++;
				}
			}
			if ($row["id_agrupacio"] == 0) {
				if (($rowc["id_agrupacio"] == $row["id"]) and ($row["id"] != $rowc ["id"])) {
					echo "<td style=\"width:250px;height:100px;background-color:silver;vertical-align:top;\">";
					echo "<a href=\"index.php?op=1008&sop=100&id=".$rowc["id"]."\">";
					echo "<strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$rowc["nombre"]."</strong></a>";
					echo "<br>".$rowc["nif"];
					echo "<br><strong>".$rowc["direccion"]."</strong>";
					if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
					echo "<strong>".$rowc["poblacion"]."</strong>";
					if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
					echo "<br>";
					if ($rowc["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$rowc["telefono"]."</strong>"; }
					if ($rowc["mail"] != "") { echo "<br>".$Email." : <a href=\"mailto:".$rowc["email"]."\"><strong>".$rowc["mail"]."</strong></a>"; }
					if ($rowc["url"] != "") { echo "<br>".$Web." : <strong>".$rowc["url"]."</strong>"; }
					echo "</a></td>";
					$x++;
				}
			}
		}
		echo "</tr></table>";
	}

#Adresses d'enviament
	if ($soption == 210) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,direccion,poblacion,cp,provincia,id_client";
			$datosInsert = array(comillas($_POST["nombre"]),comillas($_POST["direccion"]),comillas($_POST["poblacion"]),$_POST["cp"],comillas($_POST["provincia"]),$_GET["id"]);
			insertFunction ("sgm_clients_envios",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("nombre","direccion","poblacion","cp","provincia");
			$datosUpdate = array(comillas($_POST["nombre"]),comillas($_POST["direccion"]),comillas($_POST["poblacion"]),$_POST["cp"],comillas($_POST["provincia"]));
			updateFunction ("sgm_clients_envios",$_GET["id_envio"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3){
			updateFunction ("sgm_clients_envios",$_GET["id_envio"],array("visible"),array("0"));
		}

		echo "<h4>".$Direcciones_Envio." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Direccion."</th>";
				echo "<th>".$Poblacion."</th>";
				echo "<th>".$CP."</th>";
				echo "<th>".$Provincia."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1008&sop=210&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:100px\" required></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\" required></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\" required></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\"></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\"></td>";
				echo "<td><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_clients_envios where visible=1 and id_client=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=211&id=".$_GET["id"]."&id_envio=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1008&sop=210&ssop=2&id=".$_GET["id"]."&id_envio=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:100px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\" value=\"".$row["direccion"]."\"></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\" value=\"".$row["poblacion"]."\"></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\" value=\"".$row["cp"]."\"></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\" value=\"".$row["provincia"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table>";
	}

	if ($soption == 211) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=210&ssop=3&id=".$_GET["id"]."&id_envio=".$_GET["id_envio"],"op=1008&sop=210&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Servidors	
	if ($soption == 220){
		echo afegirModificarServidors("op=1008&sop=220","op=1008&sop=221");
		echo "<br><br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo servidoresMonitorizados ($_GET["id"],5,222);
		echo "</table>";
	}

	if ($soption == 221) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=220&ssop=3&id=".$_GET["id"]."&id_serv=".$_GET["id_serv"],"op=1008&sop=220&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 222){
		detalleServidoresMonitorizados ($_GET["id"],$_GET["id_serv"]);
	}

#Bases de dades
	if ($soption == 230){
		echo afegirModificarBasesDades("op=1008&sop=230","op=1008&sop=231");
	}

	if ($soption == 231) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=230&ssop=3&id=".$_GET["id"]."&id_bd=".$_GET["id_bd"],"op=1008&sop=230&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Opcions clients
	if ($soption == 300) {
		echo "<strong>".$Opciones."</strong><br><br>";
		echo "<center><table style=\"width:900px\" cellspacing=\"10\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;Width:50%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\"><tr>";
						echo "<td style=\"width:400px\"><strong>".$Eliminar." ".$Contacto."</strong></td>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">Se eliminará el contacto en todo el progama. Todos los datos relacionados con él serán inaccesibles.</td>";
					echo "</tr></table><table><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:red;border: 1px solid black;\">";
							echo "<a href=\"index.php?op=1008&sop=301&id=".$_GET["id"]."\" style=\"color:white;\">".$Eliminar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table></center>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 301) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=0&id_classificacio=0&ssop=1&id=".$_GET["id"],"op=1008&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 400) {
		echo "<h4>".$Indicadores."</h4><br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\"><td style=\"text-align:center;width:300px\">".$Indicador."</td><td style=\"text-align:center;width:150px\">".$Valor."</td></tr>";
				$sqlxt = "select count(*) as total from sgm_clients where visible=1";
				$resultxt = mysql_query(convert_sql($sqlxt));
				$rowxt = mysql_fetch_array($resultxt);
			echo "<tr><td style=\"text-align:left\"><strong>".$Total." ".$Contactos."</strong></td><td style=\"text-align:center\"><strong>".$rowxt["total"]."</strong></td></tr>";
				$sqlxt = "select count(*) as total from sgm_clients where visible=1 and id_origen=0";
				$resultxt = mysql_query(convert_sql($sqlxt));
				$rowxt = mysql_fetch_array($resultxt);
			echo "<tr><td style=\"text-align:left\"><strong>".$Total." ".$Contactos." (sin delegaciones)</strong></td><td style=\"text-align:center\"><strong>".$rowxt["total"]."</strong></td></tr>";
				$sqlxt = "select count(*) as total from sgm_clients_contactos where visible=1";
				$resultxt = mysql_query(convert_sql($sqlxt));
				$rowxt = mysql_fetch_array($resultxt);
			echo "<tr><td style=\"text-align:left\"><strong>".$Total." ".$Contactos." ".$Personales."</strong></td><td style=\"text-align:center\"><strong>".$rowxt["total"]."</strong></td></tr>";
		echo "</table>";
	}

	if ($soption == 500) {
		if ($admin == true) {
			$ruta_botons = array("op=1008&sop=510","op=1008&sop=520","op=1008&sop=530","op=1008&sop=540","op=1008&sop=550","op=1008&sop=560","op=1008&sop=570");
			$texto = array($Grupos,$Sectores,$Ubicaciones,$Tratos,$Tipos,$Definiciones,$Busquedas);
			echo boton($ruta_botons,$texto);
		}
		if ($admin == false) {
			echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";
		}
	}

	if (($soption == 510) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "grupo";
			$datosInsert = array(comillas($_POST["grupo"]));
			insertFunction ("sgm_clients_grupos",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("grupo");
			$datosUpdate = array(comillas($_POST["grupo"]));
			updateFunction ("sgm_clients_grupos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."id_grupo=0";
			$sql = $sql." WHERE id_grupo=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			deleteFunction ("sgm_clients_grupos",$_GET["id"]);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_clients_grupos set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_grupos set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<h4>".$Administracion." de ".$Grupos." de ".$Clientes." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1008&sop=510&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</td>";
				echo "<th>".$Grupo."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"grupo\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,grupo,predeterminado from sgm_clients_grupos order by grupo";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
					echo "<td>";
					if ($row["predeterminado"] == 1) {
						echo "<form action=\"index.php?op=1008&sop=510&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Despre."\">";
						echo "</form>";
					}
					if ($row["predeterminado"] == 0) {
						echo "<form action=\"index.php?op=1008&sop=510&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Predet."\">";
						echo "</form>";
					}
					echo "</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=512&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1008&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["grupo"]."\" style=\"width:200px\" name=\"grupo\" required></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 512) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=510&ssop=3&id=".$_GET["id"],"op=1018&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "sector";
			$datosInsert = array(comillas($_POST["sector"]));
			insertFunction ("sgm_clients_sectors",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("sector");
			$datosUpdate = array(comillas($_POST["sector"]));
			updateFunction ("sgm_clients_sectors",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."sector=0";
			$sql = $sql." WHERE sector=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			deleteFunction ("sgm_clients_sectors",$_GET["id"]);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_clients_sectors set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_sectors set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<h4>".$Sectores.":</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1008&sop=520&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Sector."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"sector\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,sector,predeterminado from sgm_clients_sectors order by sector";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
					echo "<td>";
						if ($row["predeterminado"] == 1) {
							echo "<form action=\"index.php?op=1008&sop=520&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Despre."\">";
							echo "</form>";
						}
						if ($row["predeterminado"] == 0) {
							echo "<form action=\"index.php?op=1008&sop=520&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"".$Predet."\">";
							echo "</form>";
						}
					echo "</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=521&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1008&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td>&nbsp;<input type=\"text\" value=\"".$row["sector"]."\" style=\"width:200px\" name=\"sector\" required></td>";
					echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 521) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=520&ssop=3&id=".$_GET["id"],"op=1008&sop=520"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 530) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "ubicacion";
			$datosInsert = array(comillas($_POST["ubicacion"]));
			insertFunction ("sgm_clients_ubicacion",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("ubicacion");
			$datosUpdate = array(comillas($_POST["ubicacion"]));
			updateFunction ("sgm_clients_ubicacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."id_ubicacion=0";
			$sql = $sql." WHERE id_ubicacion=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			deleteFunction ("sgm_clients_ubicacion",$_GET["id"]);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_clients_ubicacion set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_ubicacion set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		
		echo "<h4>".$Administracion." de ".$Ubicaciones." de ".$Clientes." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<form action=\"index.php?op=1008&sop=530&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Ubicacion."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"ubicacion\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,ubicacion,predeterminado from sgm_clients_ubicacion order by ubicacion";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
				echo "<td>";
				if ($row["predeterminado"] == 1) {
					echo "<form action=\"index.php?op=1008&sop=530&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Despre."\">";
					echo "</form>";
				}
				if ($row["predeterminado"] == 0) {
					echo "<form action=\"index.php?op=1008&sop=530&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predet."\">";
					echo "</form>";
				}
				echo "</td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=531&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				echo "<form action=\"index.php?op=1008&sop=530&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" value=\"".$row["ubicacion"]."\" style=\"width:200px\" name=\"ubicacion\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 531) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=530&ssop=3&id=".$_GET["id"],"op=1008&sop=530"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 540) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "trato";
			$datosInsert = array(comillas($_POST["trato"]));
			insertFunction ("sgm_clients_tratos",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("trato");
			$datosUpdate = array(comillas($_POST["trato"]));
			updateFunction ("sgm_clients_tratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."id_trato=0";
			$sql = $sql." WHERE id_trato=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			deleteFunction ("sgm_clients_tratos",$_GET["id"]);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_clients_tratos set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_tratos set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<h4>".$Administracion." de ".$Tratos." de ".$Clientes." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<form action=\"index.php?op=1008&sop=540&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th><em>".$Eliminar."</em></th>";
				echo "<th style=\"text-align:center;\">".$Trato."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"trato\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,trato,predeterminado from sgm_clients_tratos order by trato";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
				echo "<td>";
				if ($row["predeterminado"] == 1) {
					echo "<form action=\"index.php?op=1008&sop=540&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Despre."\">";
					echo "</form>";
				}
				if ($row["predeterminado"] == 0) {
					echo "<form action=\"index.php?op=1008&sop=540&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predet."\">";
					echo "</form>";
				}
				echo "</td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=541&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				echo "<form action=\"index.php?op=1008&sop=540&ssop=2&id=".$row["id"]."\" method=\"post\" required>";
				echo "<td><input type=\"text\" value=\"".$row["trato"]."\" style=\"width:200px\" name=\"trato\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 541) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=540&ssop=3&id=".$_GET["id"],"op=1008&sop=540"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 550)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "tipo";
			$datosInsert = array(comillas($_POST["tipo"]));
			insertFunction ("sgm_clients_tipos",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("tipo");
			$datosUpdate = array(comillas($_POST["tipo"]));
			updateFunction ("sgm_clients_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."id_tipo=0";
			$sql = $sql." WHERE id_tipo=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			deleteFunction ("sgm_clients_tipos",$_GET["id"]);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_clients_tipos set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_tipos set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		
		echo "<h4>".$Administracion." de ".$Tipos." de ".$Clientes." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<form action=\"index.php?op=1008&sop=550&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Tipo."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"tipo\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,tipo,predeterminado from sgm_clients_tipos order by tipo";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
				echo "<td>";
				if ($row["predeterminado"] == 1) {
					echo "<form action=\"index.php?op=1008&sop=550&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Despre."\">";
					echo "</form>";
				}
				if ($row["predeterminado"] == 0) {
					echo "<form action=\"index.php?op=1008&sop=550&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predet."\">";
					echo "</form>";
				}
				echo "</td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=551&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				echo "<form action=\"index.php?op=1008&sop=550&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" value=\"".$row["tipo"]."\" style=\"width:200px\" name=\"tipo\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption ==551) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=550&ssop=3&id=".$_GET["id"],"op=1008&sop=550"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 560)) {
		echo "<h4>".$Administracion." de ".$Definiciones." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Principal."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Color." ".$Boton."</th>";
				echo "<th>".$Color." ".$Letra."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1008&sop=560&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td>";
				echo "<select name=\"id_origen\" style=\"width:200px\">";
				echo "<option value=\"0\">-</option>";
				$sqlt = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=0";
				$resultt = mysql_query(convert_sql($sqlt));
				while ($rowt = mysql_fetch_array($resultt)) {
					echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
					$sqlti = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"];
					$resultti = mysql_query(convert_sql($sqlti));
					while ($rowti = mysql_fetch_array($resultti)) {
						echo "<option value=\"".$rowti["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."</option>";
						$sqltip = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowti["id"];
						$resulttip = mysql_query(convert_sql($sqltip));
						while ($rowtip = mysql_fetch_array($resulttip)) {
							echo "<option value=\"".$rowtip["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
						}
					}
				}
				echo "</select>";
				echo "</td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"nom\" required></td>";
				echo "<td><input type=\"text\" style=\"width:140px\" name=\"color\" required></td>";
				echo "<td><input type=\"text\" style=\"width:140px\" name=\"color_lletra\" required></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_clients_classificacio_tipus where visible=1 order by id_origen,nom";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					$sqlx = "select count(*) as total from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$row["id"];
					$resultx = mysql_query(convert_sql($sqlx));
					$rowx = mysql_fetch_array($resultx);
					if ($rowx["total"] == 0){
						echo "<td style=\"width:20px\"><center><a href=\"index.php?op=1008&sop=561&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></center></td>";
					} else {
						echo "<td></td>";
					}
					echo "<form action=\"index.php?op=1008&sop=560&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td>";
						echo "<select name=\"id_origen\" style=\"width:200px\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=0";
						$resultt = mysql_query(convert_sql($sqlt));
						while ($rowt = mysql_fetch_array($resultt)) {
							if ($rowt["id"] == $row["id_origen"]){
								echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nom"]."</option>";
							} else {
								echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
							}
							$sqlti = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"];
							$resultti = mysql_query(convert_sql($sqlti));
							while ($rowti = mysql_fetch_array($resultti)) {
								if ($rowti["id"] == $row["id_origen"]){
									echo "<option value=\"".$rowti["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."</option>";
								} else {
									echo "<option value=\"".$rowti["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."</option>";
								}
								$sqltip = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowti["id"];
								$resulttip = mysql_query(convert_sql($sqltip));
								while ($rowtip = mysql_fetch_array($resulttip)) {
									if ($rowtip["id"] == $row["id_origen"]){
										echo "<option value=\"".$rowtip["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
									} else {
										echo "<option value=\"".$rowtip["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
									}
								}
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"text\" value=\"".$row["nom"]."\" style=\"width:200px\" name=\"nom\" required></td>";
					if ($row["id_origen"] == 0){
						echo "<td><input type=\"text\" value=\"".$row["color"]."\" style=\"width:140px\" name=\"color\" required></td>";
						echo "<td><input type=\"text\" value=\"".$row["color_lletra"]."\" style=\"width:140px\" name=\"color_lletra\" required></td>";
					} else {
						echo "<td></td>";
						echo "<td></td>";
					}
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					boton_form("op=1008&sop=565&id=".$row["id"]."",$Incompatibles);
				echo "</tr>";
			}
		echo "</table>";
		echo "<br>* no se pueden eliminar aquellas definiciones con otras definiciones asociadas.<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td style=\"background-color:silver;\">";
				echo colors2();
			echo "</td></tr>";
		echo "</table>";
	}

	if (($soption == 561) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=560&ssop=3&id=".$_GET["id"],"op=1008&sop=560"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 565) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "id_clasificacio_tipus,id_clasificacio_tipus_neg";
			$datosInsert = array($_GET["id"],$_POST["id_class_neg"]);
			insertFunction ("sgm_clients_classificacio_neg",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_clients_classificacio_neg",$_GET["id_neg"],$camposUpdate,$datosUpdate);
		}

		$sql = "select nom from sgm_clients_classificacio_tipus where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<h4>".$Definiciones." ".$Incompatibles." : ".$row["nom"]."</h4>";
		echo boton(array("op=1008&sop=560"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1008&sop=565&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Incompatibles."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
				echo "<select class=\"px150\" name=\"id_class_neg\">";
					$sqlt = "select id,nom from sgm_clients_classificacio_tipus where visible=1 and id<>".$_GET["id"];
					$resultt = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($resultt)) {
						$sqlv = "select count(*) as total from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_GET["id_clas"]." and id_clasificacio_tipus_neg=".$rowt["id"];
						$resultv = mysql_query(convert_sql($sqlv));
						$rowv = mysql_fetch_array($resultv);
						if ($rowv["total"] == 0 ){
							echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
						}
					}
				echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqln = "select id,id_clasificacio_tipus_neg from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_GET["id"];
			$resultn = mysql_query(convert_sql($sqln));
			while ($rown = mysql_fetch_array($resultn)) {
				echo "<tr>";
					$sqlx = "select * from sgm_clients_classificacio_tipus where visible=1 and id=".$rown["id_clasificacio_tipus_neg"];
					$resultx = mysql_query(convert_sql($sqlx));
					$rowx = mysql_fetch_array($resultx);
					echo "<td style=\"width:20px\"><a href=\"index.php?op=1008&sop=566&id=".$_GET["id"]."&id_neg=".$rown["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td style=\"width:140px\">".$rowx["nom"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 566) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=565&ssop=3&id=".$_GET["id"]."&id_neg=".$_GET["id_neg"],"op=1008&sop=565&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 570) {
		if ($ssoption == 1){
			$camposInsert = "nombre,lletres,id_tipo,id_grupo,id_sector,id_ubicacion,id_classificacio,likenombre";
			$datosInsert = array($_POST["nom_cerca"],$_POST["lletres"],$_POST["tipo"],$_POST["grupo"],$_POST["sector"],$_POST["ubicacion"],$_POST["id_classificacio"],$_POST["likenombre"]);
			insertFunction ("sgm_cerques",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("nombre");
			$datosUpdate = array(comillas($_POST["nombre"]));
			updateFunction ("sgm_cerques",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3){
			deleteFunction ("sgm_cerques",$_GET["id"]);
		}
	
		echo "<h4>".$Busquedas."</h4><br><br>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sql = "select id,nombre from sgm_cerques where nombre<>'' order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<form action=\"index.php?op=1008&sop=570&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=570&ssop=3&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<td><input type=\"Text\" value=\"".$row["nombre"]."\" name=\"nombre\" style=\"width:250px;\"></td>";
					echo "<td><input type=\"submit\" value=\"".$Modificar."\"></td>";
				echo "</tr>";
				echo "</form>";
			}
		echo "</table>";
	}

	if ($soption == 571) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=570&ssop=3&id_proveedor=".$_GET["id_proveedor"],"op=1008&sop=570&id_proveedor=".$_GET["id_proveedor"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 572) {
		echo "<h4>".$Guardar." ".$Busquedas."</h4><br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Nombre."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1008&sop=570&ssop=1\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nom_cerca\" style=\"width:250px;\" required></td>";
				echo "<td><input type=\"submit\" value=\"".$Guardar."\"></td>";
				$lletres = "";
				for ($i = 48; $i <= 90; $i++) {
					if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
						if ($_POST[chr($i)] == true) {
							$lletres .= chr($i);
							echo "<input type=\"Hidden\" name=\"lletres\" value=\"".$lletres."\">";
						}
					}
				}
				echo "<input type=\"Hidden\" name=\"tipo\" value=\"".$_POST["tipo"]."\">";
				echo "<input type=\"Hidden\" name=\"grupo\" value=\"".$_POST["grupo"]."\">";
				echo "<input type=\"Hidden\" name=\"sector\" value=\"".$_POST["sector"]."\">";
				echo "<input type=\"Hidden\" name=\"ubicacion\" value=\"".$_POST["ubicacion"]."\">";
				echo "<input type=\"Hidden\" name=\"id_classificacio\" value=\"".$_POST["id_classificacio"]."\">";
				echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 600){
		if ($ssoption == 1) {
			$sql = "select id from sgm_clients where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlc = "update sgm_clients set ";
				if ($_POST["client".$row["id"]] == 1) { $cliente = $_POST["client".$row["id"]];} else {$cliente = 0;}
				$sqlc = $sqlc."client=".$cliente;
				if ($_POST["clientvip".$row["id"]] == 1) { $clientevip = $_POST["clientvip".$row["id"]];} else {$clientevip = 0;}
				$sqlc = $sqlc.",clientvip=".$clientevip;
				$sqlc = $sqlc.",id_tipo=".$_POST["id_tipo".$row["id"]];
				$sqlc = $sqlc.",id_grupo=".$_POST["id_grupo".$row["id"]];
				$sqlc = $sqlc.",sector=".$_POST["id_sector".$row["id"]];
				$sqlc = $sqlc.",id_ubicacion=".$_POST["id_ubicacion".$row["id"]];
				$sqlc = $sqlc." WHERE id=".$row["id"]."";
				mysql_query(convert_sql($sqlc));
#echo $sqlc."<br>";
			}
		}

		#### DETERMINA SI HAY FILTRO POR INICIO LETRA
		$ver_todas_letras = true;
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				if ($_POST[chr($i)] == true) {
					$ver_todas_letras = false;
				}
			}
		}
		#### INICIA BUCLE TODAS LAS LETRAS
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:1200px;\">";
			echo "<form action=\"index.php?op=1008&sop=600&ssop=1\" method=\"post\">";
			echo "<tr><td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:300px\"></td></tr>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:1200px;\">";
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
				$linea_letra = 1;
				$color = "white";
				$sql = "select * from sgm_clients where visible=1 and nombre like '".chr($i)."%' order by nombre,cognom1,cognom2";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
					if ($linea_letra == 1) {
						echo "<tr style=\"background-color: Silver;\">";
							echo "<td><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></td>";
							echo "<td style=\"width:600px;\"><center><em>".$Nombre_cliente."</em></center></td>";
							echo "<td><center>Fid.</center></td>";
							echo "<td><center>Vip</center></td>";
							echo "<td><center>Tipo</center></td>";
							echo "<td><center>Grupo</center></td>";
							echo "<td><center>Sector</center></td>";
							echo "<td><center>Ubicacion</center></td>";
						echo "</tr>";
						$linea_letra = 0;
					}
					echo "<tr>";
						$distancia = 5;
						$letra = "normal";
						echo "<td></td>";
						if (strlen($row["nombre"]) > 65) { 
							echo "<td style=\"padding-left:".$distancia."px;font-weight:".$letra.";\">";
								echo "<a href=\"index.php?op=1008&sop=100&id=".$row["id"]."\">".substr($row["nombre"],0,63)." ... ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
						} else {
							echo "<td style=\"padding-left:".$distancia."px;font-weight:".$letra.";\">";
								echo "<a href=\"index.php?op=1008&sop=100&id=".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
						}
						echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"client".$row["id"]."\"";
						if ($row["client"] == 1) { echo " checked"; }
						echo " value=\"1\" style=\"border:0px solid black\"></td>";
						echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"clientvip".$row["id"]."\"";
						if ($row["clientvip"] == 1) { echo " checked"; }
						echo " value=\"1\" style=\"border:0px solid black\"></td>";
						echo "<td><select name=\"id_tipo".$row["id"]."\" style=\"width:100px\">";
							echo "<option value=\"0\">-</option>";
							$sqlct = "select id,tipo from sgm_clients_tipos order by tipo";
							$resultct = mysql_query(convert_sql($sqlct));
							while ($rowct = mysql_fetch_array($resultct)) {
								if ($row["id_tipo"] == $rowct["id"]){
									echo "<option value=\"".$rowct["id"]."\" selected>".$rowct["tipo"]."</option>";
								} else {
									echo "<option value=\"".$rowct["id"]."\">".$rowct["tipo"]."</option>";
								}
							}
						echo "</select></td>";
						echo "<td><select name=\"id_grupo".$row["id"]."\" style=\"width:200px\">";
							echo "<option value=\"0\">-</option>";
							$sqlcg = "select id,grupo from sgm_clients_grupos order by grupo";
							$resultcg = mysql_query(convert_sql($sqlcg));
							while ($rowcg = mysql_fetch_array($resultcg)) {
								if ($row["id_grupo"] == $rowcg["id"]){
									echo "<option value=\"".$rowcg["id"]."\" selected>".$rowcg["grupo"]."</option>";
								} else {
									echo "<option value=\"".$rowcg["id"]."\">".$rowcg["grupo"]."</option>";
								}
							}
						echo "</select></td>";
						echo "<td><select name=\"id_sector".$row["id"]."\" style=\"width:100px\">";
							echo "<option value=\"0\">-</option>";
							$sqlcg = "select id,sector from sgm_clients_sectors order by sector";
							$resultcg = mysql_query(convert_sql($sqlcg));
							while ($rowcg = mysql_fetch_array($resultcg)) {
								if ($row["sector"] == $rowcg["id"]){
									echo "<option value=\"".$rowcg["id"]."\" selected>".$rowcg["sector"]."</option>";
								} else {
									echo "<option value=\"".$rowcg["id"]."\">".$rowcg["sector"]."</option>";
								}
							}
						echo "</select></td>";
						echo "<td><select name=\"id_ubicacion".$row["id"]."\" style=\"width:200px\">";
							echo "<option value=\"0\">-</option>";
							$sqlcg = "select id,ubicacion from sgm_clients_ubicacion order by ubicacion";
							$resultcg = mysql_query(convert_sql($sqlcg));
							while ($rowcg = mysql_fetch_array($resultcg)) {
								if ($row["id_ubicacion"] == $rowcg["id"]){
									echo "<option value=\"".$rowcg["id"]."\" selected>".$rowcg["ubicacion"]."</option>";
								} else {
									echo "<option value=\"".$rowcg["id"]."\">".$rowcg["ubicacion"]."</option>";
								}
							}
						echo "</select></td>";
					echo "</tr>";
					if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
				}
			}
		}
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:1200px;\">";
			echo "<tr><td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:300px\"></td></tr>";
			echo "</form>";
		#### FIN TABLA, MUESTRA NUMERO RESULTADOS Y LEYENDA
		echo "</table>";
	}

	echo "</td></tr></table><br>";
}

function ver_contacto($id,$color,$contactes) {
	global $db;
	$sql = "select * from sgm_clients where id=".$id;
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	echo "<tr style=\"background-color:".$color."\">";
		if (($row["tipo_identificador"] == 2) or ($row["tipo_identificador"] == 3)) { $check_nif = 1;} else { $check_nif = valida_nif_cif_nie($row["nif"]);}
		if (($check_nif <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
			echo "<td><img src=\"mgestion/pics/icons-mini/page_white_error.png\" title=\"Error Id. Fiscal\" alt=\"Error Id. Fiscal\" border=\"0\"></td>";
		} else { 
			echo "<td></td>"; 
		}
		if ($row["client"] == 1) { echo "<td><img src=\"mgestion/pics/icons-mini/shape_handles.png\" alt=\"SI\" border=\"0\"></td>"; } else  { echo "<td></td>"; }
		if ($row["clientvip"] == 1) { echo "<td><img src=\"mgestion/pics/icons-mini/shape_handles.png\" alt=\"SI\" border=\"0\"></td>"; } else  { echo "<td></td>"; }
		$sqltotal= "select count(*) as total from sgm_clients where visible=1 and id_origen=".$row["id"]." and id<>".$row["id"];
		$resulttotal = mysql_query(convert_sql($sqltotal));
		$rowtotal = mysql_fetch_array($resulttotal);
		if ($rowtotal["total"] > 0) { echo "<td><img src=\"mgestion/pics/icons-mini/building_add.png\" alt=\"SI\" border=\"0\"></td>"; } else  { echo "<td></td>"; }
		$distancia = 5;
		$letra = "normal";
		if ($row["id_agrupacio"] != 0) { $distancia = 15; }
		if ($row["id_agrupacio"] == 0) { $letra = "bold"; }
		### NOMBRE
		echo "<td style=\"padding-left:".$distancia."px;font-weight:".$letra.";white-space:nowrap;\"><a href=\"index.php?op=1008&sop=100&id=".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
		### FIN NOMBRE
		echo "<td>".$row["telefono"]."</td>";
		if ($row["mail"] != "") { echo "<td><a href=\"mailto:".$row["mail"]."\"><img src=\"mgestion/pics/icons-mini/email_link.png\" alt=\"e-mail\" border=\"0\"></a></td>"; } else { echo "<td></td>"; }
		if ($row["web"] != "") { echo "<td><a href=\"http://".$row["web"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/page_white_link.png\" alt=\"URL\" border=\"0\"></a></td>"; } else { echo "<td></td>"; }
	echo "</tr>";
	if ($contactes == 1) {
		$sql = "select nombre,apellido1,apellido2,telefono from sgm_clients_contactos where id_client=".$id;
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			echo "<tr><td colspan=\"5\">".$row["nombre"]." ".$row["apellido1"]." ".$row["apellido2"]."</td><td>".$row["telefono"]."</td></tr>";
		}
	}
	if ($contactes == 2) {
		$sql = "select nombre,apellido1,apellido2,telefono from sgm_clients_contactos where pred=1 and id_client=".$id;
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<tr><td colspan=\"5\">".$row["nombre"]." ".$row["apellido1"]." ".$row["apellido2"]."</td><td>".$row["telefono"]."</td></tr>";
	}
}

function canviar_color($id,$color,$color_lletra)
{
	$sql = "select id from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$id;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
		$sqlx = "update sgm_clients_classificacio_tipus set ";
		$sqlx = $sqlx."color='".$color."'";
		$sqlx = $sqlx.",color_lletra='".$color_lletra."'";
		$sqlx = $sqlx." WHERE id=".$row["id"]."";
		mysql_query(convert_sql($sqlx));
		$sqlc = "select id from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$row["id"];
		$resultc = mysql_query(convert_sql($sqlc));
		while ($rowc = mysql_fetch_array($resultc)){
			$sqlxx = "update sgm_clients_classificacio_tipus set ";
			$sqlxx = $sqlxx."color='".$color."'";
			$sqlxx = $sqlxx.",color_lletra='".$color_lletra."'";
			$sqlxx = $sqlxx." WHERE id=".$rowc["id"]."";
			mysql_query(convert_sql($sqlxx));
		}
	}
}

?>