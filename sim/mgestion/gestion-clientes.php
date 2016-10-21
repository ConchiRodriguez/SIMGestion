<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);

if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1008) AND ($autorizado == true)) {
	## canvis en les definicions de clients (noms, color, relacions, etc) ##
	if (($soption == 560) and ($ssoption == 1) AND ($admin == true)) {
		if ($_POST["id_origen"] == 0){
			$color=comillas($_POST["color"]);
			$color_letra=comillas($_POST["color_letra"]);
		} else {
			$sqlc = "select color,color_letra from sgm_clients_tipos where visible=1 and id=".$_POST["id_origen"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$color=$rowc["color"];
			$color_letra=$rowc["color_letra"];
		}
		$camposInsert = "id_origen,nombre,color,color_letra,factura,contrato,incidencia,datos_fiscales";
		$datosInsert = array($_POST["id_origen"],comillas($_POST["nombre"]),$color,$color_letra,$_POST["factura"],$_POST["contrato"],$_POST["incidencia"],$_POST["datos_fiscales"]);
		if (($_POST["factura"] > 0) and ($_POST["id_tipo_factura"] > 0)){
			$camposInsert .= ",id_tipo_factura";
			array_push($datosInsert,$_POST["id_tipo_factura"]);
		}
		if (($_POST["contrato"] > 0) and ($_POST["contrato_activo"] >= 0)){
			$camposInsert .= ",contrato_activo";
			array_push($datosInsert,$_POST["contrato_activo"]);
		}
		insertFunction ("sgm_clients_tipos",$camposInsert,$datosInsert);
	}
	if (($soption == 560) and ($ssoption == 2) AND ($admin == true)) {
		if ($_POST["id_origen"] == 0){
			$color=comillas($_POST["color"]);
			$color_letra=comillas($_POST["color_letra"]);
		} else {
			$sqlc = "select color,color_letra from sgm_clients_tipos where visible=1 and id=".$_POST["id_origen"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$color=$rowc["color"];
			$color_letra=$rowc["color_letra"];
		}
		$camposUpdate = array('id_origen','nombre','color','color_letra','factura','id_tipo_factura','contrato','incidencia','datos_fiscales');
		$datosUpdate = array($_POST["id_origen"],comillas($_POST["nombre"]),$color,$color_letra,$_POST["factura"],$_POST["id_tipo_factura"],$_POST["contrato"],$_POST["incidencia"],$_POST["datos_fiscales"]);
		if (($_POST["factura"] > 0) and ($_POST["id_tipo_factura"] > 0)){
			array_push($camposUpdate,"id_tipo_factura");
			array_push($datosUpdate,$_POST["id_tipo_factura"]);
		} elseif ($_POST["factura"] == 0){
			array_push($camposUpdate,"id_tipo_factura");
			array_push($datosUpdate,0);
		}
		if (($_POST["contrato"] > 0) and ($_POST["contrato_activo"] >= 0)){
			array_push($camposUpdate,"contrato_activo");
			array_push($datosUpdate,$_POST["contrato_activo"]);
		} elseif ($_POST["contrato"] == 0){
			array_push($camposUpdate,"contrato_activo");
			array_push($datosUpdate,0);
		}
		updateFunction("sgm_clients_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
	}
	if (($soption == 560) and ($ssoption == 3) AND ($admin == true)) {
		$camposUpdate=array('visible');
		$datosUpdate=array(0);
		updateFunction("sgm_clients_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
	}
	## fi de canvis en les definicions de client ##

	echo "<table class=\"principal\">";
		echo"<tr>";
			echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
				echo "<h4>".$Clientes."</h4>";
			echo "</td><td style=\"width:85%;vertical-align:top;text-align:left;\">";
				echo "<table>";
					echo "<tr>";
						if (($soption == 0) or ($_GET["id_tipo"] != 0)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=0\" class=".$class.">".$Contactos."</a></td>";
						if (($soption == 1) and ($_GET["id_tipo"] == 0)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=1\" class=".$class.">".$Personas."</a></td>";
						if ($soption == 100) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=100&id=0\" class=".$class.">".$Anadir." ".$Contactos."</a></td>";
						if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=200\" class=".$class.">".$Buscar." ".$Contactos."</a></td>";
						if ($soption == 300) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=300\" class=".$class.">".$Actualizar." ".$Contactos."</a></td>";
						if (($soption >= 500) and ($soption < 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
						echo "<td class=".$class."><a href=\"index.php?op=1008&sop=500\" class=".$class.">".$Administrar."</a></td>";
					echo "</tr>";
				echo "</table>";
		echo"</tr><tr>";
			echo "<td colspan=\"2\">";
				echo "<table class=\"lista\">";
					echo "<tr>";
					$sqlt = "select * from sgm_clients_tipos where visible=1 and id_origen=0 order by nombre";
					$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
					while ($rowt = mysqli_fetch_array($resultt)){
						echo "<td class=".$class." style=\"background-color:".$rowt["color"].";\"><a href=\"index.php?op=1008&sop=0&id_tipo=".$rowt["id"]."\" style=\"color:".$rowt["color_letra"]."\">".$rowt["nombre"]."</a></td>";
					}
					echo "</tr>";
				echo "</table>";
				$id_origen = 0;
				### BUSCO CATEGORIA DE ORIGEN
				$sqltx1 = "select id,id_origen from sgm_clients_tipos where id=".$_GET["id_tipo"];
				$resulttx1 = mysqli_query($dbhandle,convertSQL($sqltx1));
				$rowtx1 = mysqli_fetch_array($resulttx1);
				if ($rowtx1["id_origen"] == 0) {
					$id_origen = $rowtx1["id"];
				} else {
					$sqltx2 = "select id,id_origen from sgm_clients_tipos where id=".$rowtx1["id_origen"];
					$resulttx2 = mysqli_query($dbhandle,convertSQL($sqltx2));
					$rowtx2 = mysqli_fetch_array($resulttx2);
					if ($rowtx2["id_origen"] == 0) {
						$id_origen = $rowtx2["id"];
					} else {
						$sqltx3 = "select id,id_origen from sgm_clients_tipos where id=".$rowtx2["id_origen"];
						$resulttx3 = mysqli_query($dbhandle,convertSQL($sqltx3));
						$rowtx3 = mysqli_fetch_array($resulttx3);
						if ($rowtx3["id_origen"] == 0) {
							$id_origen = $rowtx3["id"];
						}
					}
				}
				if ($id_origen != 0) {
					echo "<table class=\"lista\"><tr>";
					$sqlt = "select * from sgm_clients_tipos where visible=1 and id_origen=".$id_origen." order by nombre";
					$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
					while ($rowt = mysqli_fetch_array($resultt)){
						echo "<td style=\"vertical-align:top;\">";
							echo "<table class=\"lista\">";
								echo "<tr><td style=\"height:16px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=0&id_tipo=".$rowt["id"]."\" style=\"color: ".$rowt["color_letra"]."\">".$rowt["nombre"]."</a></td></tr>";
								echo "<tr><td style=\"height:6px\"></td></tr>";
								$sqltt = "select * from sgm_clients_tipos where visible=1 and id_origen=".$rowt["id"]." order by nombre";
								$resulttt = mysqli_query($dbhandle,convertSQL($sqltt));
								while ($rowtt = mysqli_fetch_array($resulttt)){
									echo "<tr><td style=\"height:16px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowtt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=0&id_tipo=".$rowtt["id"]."\" style=\"color: ".$rowtt["color_letra"]."\">".$rowtt["nombre"]."</a></td></tr>";
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

	if (($soption == 0) or ($soption == 200)) {
		if ($ssoption == 1){
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($soption == 0) {
			echo "<h4>".$Contactos."</h4>";
		} elseif ($soption == 200) {
			if ($_GET["filtro"] > 0) {
				if ($_GET["filtro"] == 1) {
					$tipos = $_POST["id_tipo"];
					$sectores = $_POST["id_sector"];
					$origenes = $_POST["id_origen"];
					$paises = $_POST["id_pais"];
					$comunidades = $_POST["id_comunidad_autonoma"];
					$provincias = $_POST["id_provincia"];
					$regiones = $_POST["id_region"];

					$tipo = implode(",", $tipos);
					$sector = implode(",", $sectores);
					$origen = implode(",", $origenes);
					$pais = implode(",", $paises);
					$comunidad = implode(",", $comunidades);
					$provincia = implode(",", $provincias);
					$region = implode(",", $regiones);
					$likenombre = $_POST["likenombre"];
				}
				if ($_GET["filtro"] == 2) {
					$sql = "select * from sgm_clients_busquedas where id=".$_GET["id"];
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					$tipo = $row["tipos"];
					$sector = $row["sectores"];
					$origen = $row["origenes"];
					$pais = $row["paises"];
					$comunidad = $row["comunidades"];
					$provincia = $row["provincias"];
					$region = $row["regiones"];
					$likenombre = $row["likenombre"];
					
					$tipos = explode(",",$tipo);
					$sectores = explode(",",$sector);
					$origenes = explode(",",$origen);
					$paises = explode(",",$pais);
					$comunidades = explode(",",$comunidad);
					$provincias = explode(",",$provincia);
					$regiones = explode(",",$region);
					$chars = explode(",",$row["letras"]);
				}
#				echo $tipo."- ".$sector."- ".$origen."- ".$pais."- ".$comunidad."- ".$provincia."- ".$region."- ".var_dump($chars);
			}
			if ($ssoption == 2){
				$camposInsert = "nombre,letras,tipos,sectores,origenes,paises,comunidades,provincias,regiones,likenombre";
				$datosInsert = array($_POST["nom_cerca"],$_POST["letras"],$_POST["tipos"],$_POST["sectores"],$_POST["origenes"],$_POST["paises"],$_POST["comunidades"],$_POST["provincias"],$_POST["regiones"],$likenombre);
				insertFunction ("sgm_clients_busquedas",$camposInsert,$datosInsert);
			}
			echo "<h4>".$Buscar_Contacto." : </h4>";
			echo "<table style=\"width:100%;\">";
				echo "<tr>";
				echo "<td style=\"vertical-align:top;width:85%;\">";
					echo "<form action=\"index.php?op=1008&sop=200&filtro=1\" method=\"post\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Tipo."</th>";
							echo "<th>".$Sector."</th>";
							echo "<th>".$Origen."</th>";
							echo "<th>".$Pais."</th>";
							echo "<th>".$Comunidad_autonoma."</th>";
							echo "<th>".$Provincia."</th>";
							echo "<th>".$Region."</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_tipo[]\" size=\"10\" style=\"width:100%\">";
										if (in_array(0, $tipos)){
											echo "<option value=\"0\" selected>".$Todos."</option>";
										} else {
											echo "<option value=\"0\">".$Todos."</option>";
										}
									$sqlt = "select id,nombre from sgm_clients_tipos where visible=1";
									$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
									while ($rowt = mysqli_fetch_array($resultt)) {
										if (in_array($rowt["id"], $tipos)){
											echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nombre"]."</option>";
										} else {
											echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_sector[]\" size=\"10\" style=\"width:100%\">";
									echo "<option value=\"\">-</option>";
									$sqls = "select id,sector from sgm_clients_sectores order by sector";
									$results = mysqli_query($dbhandle,convertSQL($sqls));
									while ($rows = mysqli_fetch_array($results)){
										if (in_array($rows["id"], $sectores)){
											echo "<option value=\"".$rows["id"]."\" selected>".$rows["sector"]."</option>";
										} else {
											echo "<option value=\"".$rows["id"]."\">".$rows["sector"]."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_origen[]\" size=\"10\" style=\"width:100%\">";
									echo "<option value=\"\">-</option>";
									$sqlu = "select id,origen from sgm_clients_origen order by origen";
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)){
										if (in_array($rowu["id"], $origenes)){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["origen"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["origen"]."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_pais[]\" size=\"10\" style=\"width:100%\">";
									echo "<option value=\"\">-</option>";
									$sqlu = "select id,pais from sim_paises order by pais";
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)){
										if (in_array($rowu["id"], $paises)){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["pais"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["pais"]."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_comunidad_autonoma[]\" size=\"10\" style=\"width:100%\">";
									echo "<option value=\"\">-</option>";
									$sqlu = "select id,comunidad_autonoma from sim_comunidades_autonomas order by comunidad_autonoma";
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)){
										if (in_array($rowu["id"], $comunidades)){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["comunidad_autonoma"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["comunidad_autonoma"]."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_provincia[]\" size=\"10\" style=\"width:100%\">";
									echo "<option value=\"\">-</option>";
									$sqlu = "select id,provincia from sim_provincias order by provincia";
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)){
										if (in_array($rowu["id"], $provincias)){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["provincia"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["provincia"]."</option>";
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"width:15%\">";
								echo "<select multiple name=\"id_region[]\" size=\"10\" style=\"width:100%\">";
									echo "<option value=\"\">-</option>";
									$sqlu = "select id,region from sim_regiones order by region";
									$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
									while ($rowu = mysqli_fetch_array($resultu)){
										if (in_array($rowu["id"], $regiones)){
											echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["region"]."</option>";
										} else {
											echo "<option value=\"".$rowu["id"]."\">".$rowu["region"]."</option>";
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
							echo "<th style=\"color:black;text-align:right;width:10%\">".$Nombre."</th>";
							echo "<td style=\"color:black;text-align:leftt;width:25%\"><input type=\"Text\" name=\"likenombre\" value=\"".$likenombre."\" style=\"width:100%;\"></td>";
							echo "<th style=\"color:black;text-align:right;width:10%\">".$Inicial."</th>";
							for ($i = 48; $i <= 90; $i++) {
								if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
									echo "<td style=\"color:black;text-align:center;\"><input type=\"Checkbox\" name=\"".chr($i)."\"";
									if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) { echo " checked"; }
									echo " value=\"true\" style=\"border:0px solid black;width:55%\"></td>";
								}
							}
						echo "<td style=\"text-align:center;\" class=\"Submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td></tr>";
					echo "</table>";
					echo "</form>";
				echo "</td><td style=\"text-align:left;vertical-align:top;width:15%;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"1\" class=\"lista\">";
						echo "<th style=\"white-space:nowrap\">".$Busquedas." ".$Guardadas." : </th>";
						$x = 0;
						$sql = "select id,nombre from sgm_clients_busquedas order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)){
							echo "<tr>";
								echo "<td>";
									echo boton(array("op=1008&sop=200&filtro=2&id=".$row["id"]),array($row["nombre"]));
									$x++;
									if ($x >= 4){ echo "</tr><tr>"; $x = 0 ;}
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "<br>";
		}

		$ok = 0;
		for ($i = 48; $i <= 90; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) { $ok = 1;}
			}
		}
		if ($_GET["id_tipo"] != "") {$tipo_cliente = $_GET["id_tipo"];} else {$tipo_cliente = $tipo;}
		if (($soption == 0) or (($soption == 200) and ($_GET["filtro"] > 0) and ((isset($tipo_cliente)) or (isset($sector)) or (isset($origen)) or (isset($pais)) or (isset($comunidad)) or (isset($provincia)) or (isset($region)) or ($likenombre != "") or ($ok == 1)))) {
			$ver = true;
			if ($tipo_cliente != 0){
				$sqlct = "select * from sgm_clients_tipos where visible=1 and id=".$tipo_cliente;
				$resultct = mysqli_query($dbhandle,convertSQL($sqlct));
				$rowct = mysqli_fetch_array($resultct);
				$nombre_tipo = $rowct["nombre"];
			} else {
				$nombre_tipo = "";
			}

			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr>";
					echo "<td><strong>".$nombre_tipo."</strong>".$en_orden_alfabetico;
					for ($i = 48; $i <= 90; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							echo "<a href=\"#".chr($i)."\"><strong>".chr($i)."</strong></a>&nbsp;";
						}
					}
					echo "</td>";
					echo "<form action=\"index.php?op=1008&sop=5\" method=\"post\">";
					for ($i = 48; $i <= 90; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) {
								echo "<input type=\"Hidden\" name=\"".chr($i)."\" value=\"".$_POST[chr($i)]."\">";
							}
						}
					}
					echo "<input type=\"Hidden\" name=\"tipos\" value=\"".$tipo_cliente."\">";
					echo "<input type=\"Hidden\" name=\"sectores\" value=\"".$sector."\">";
					echo "<input type=\"Hidden\" name=\"origenes\" value=\"".$origen."\">";
					echo "<input type=\"Hidden\" name=\"paises\" value=\"".$pais."\">";
					echo "<input type=\"Hidden\" name=\"comunidades\" value=\"".$comunidad."\">";
					echo "<input type=\"Hidden\" name=\"provincias\" value=\"".$provincia."\">";
					echo "<input type=\"Hidden\" name=\"regiones\" value=\"".$region."\">";
					echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$likenombre."\">";
					echo "<td class=\"submit\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Imprimir_Lista."\"></td>";
					echo "</form>";
				if ($soption != 4){
					echo "<form action=\"index.php?op=1008&sop=6\" method=\"post\">";
					for ($i = 48; $i <= 90; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) {
								echo "<input type=\"Hidden\" name=\"".chr($i)."\" value=\"".$_POST[chr($i)]."\">";
							}
						}
					}
					echo "<input type=\"Hidden\" name=\"tipos\" value=\"".$tipo_cliente."\">";
					echo "<input type=\"Hidden\" name=\"sectores\" value=\"".$sector."\">";
					echo "<input type=\"Hidden\" name=\"origenes\" value=\"".$origen."\">";
					echo "<input type=\"Hidden\" name=\"paises\" value=\"".$pais."\">";
					echo "<input type=\"Hidden\" name=\"comunidades\" value=\"".$comunidad."\">";
					echo "<input type=\"Hidden\" name=\"provincias\" value=\"".$provincia."\">";
					echo "<input type=\"Hidden\" name=\"regiones\" value=\"".$region."\">";
					echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$likenombre."\">";
					echo "<td class=\"submit\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Guardar_Busqueda."\"></td>";
					echo "</form>";
				}
				echo "</tr>";
			echo "</table>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$z = 0;
			$clientes_ids = array();
			#### DETERMINA SI HAY FILTRO POR INICIO LETRA
			$ver_todas_letras = true;
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
					if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) {
						$ver_todas_letras = false;
					}
				}
			}
			#### INICIA BUCLE TODAS LAS LETRAS
			for ($i = 48; $i <= 90; $i++) {
				if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
					$linea_letra = 1;
					$color = "white";
					$sql = "select * from sgm_clients where visible=1 and nombre like '".chr($i)."%'";
					if ($likenombre != "") { $sql = $sql." and (nombre like '%".$likenombre."%' or cognom1 like '%".$likenombre."%' or cognom2 like '%".$likenombre."%')";}
					$sql =$sql." order by nombre,cognom1,cognom2,id_origen";
#					echo $sql."<br>";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						#### MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
						if (($_GET["id_tipo"] != "") and ($tipo_cliente == "")) {
							if ($row["id_agrupacio"] == 0){$ver = true;} else {$ver = false;}
						} else {
							$ver = true;
						}
						#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
						if ($ver_todas_letras == false) {
							if (($_POST[chr($i)] != true) and (!in_array(chr($i), $chars))) {
								$ver = false;
							}
						}
						#### BUSCA TIPUS
						if (($ver == true) and ($tipo_cliente != "")) {
							if ($tipo_cliente > 0) {
								$sqlct = "select * from sgm_clients_rel_tipos where id_cliente=".$row["id"]." and id_tipo=".$tipo_cliente;
								$resultct = mysqli_query($dbhandle,convertSQL($sqlct));
								$rowct = mysqli_fetch_array($resultct);
								if (!$rowct){ $ver = false;}
							}
						}
						if (($ver == true) and ($sector != "")) {
							$sqlsec = "select count(*) as total from sgm_clients_rel_sectores where id_cliente=".$row["id"]." and id_sector in (".$sector.")";
							$resultsec = mysqli_query($dbhandle,convertSQL($sqlsec));
							$rowsec = mysqli_fetch_array($resultsec);
							if ($rowsec["total"] <= 0) { $ver = false; }
						}
						if (($ver == true) and ($origen != "")) {
							$sqlsec = "select count(*) as total from sgm_clients_rel_origen where id_cliente=".$row["id"]." and id_origen in (".$origen.")";
							$resultsec = mysqli_query($dbhandle,convertSQL($sqlsec));
							$rowsec = mysqli_fetch_array($resultsec);
							if ($rowsec["total"] <= 0) { $ver = false; }
						}
						if (($ver == true) and ($pais != "")) {
							$sqlp = "select count(*) as total from sgm_clients_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=1 and id_ubicacion in (".$pais.")";
							$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
							$rowp = mysqli_fetch_array($resultp);
							if ($rowp["total"] <= 0) { $ver = false; }
						}
						if (($ver == true) and ($comunidad != "")) {
							$sqlcom = "select count(*) as total from sgm_clients_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=2 and id_ubicacion in (".$comunidad.")";
							$resultcom = mysqli_query($dbhandle,convertSQL($sqlcom));
							$rowcom = mysqli_fetch_array($resultcom);
							if ($rowcom["total"] <= 0) { $ver = false; }
						}
						if (($ver == true) and ($provincia != "")) {
							$sqlpro = "select count(*) as total from sgm_clients_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=3 and id_ubicacion in (".$provincia.")";
							$resultpro = mysqli_query($dbhandle,convertSQL($sqlpro));
							$rowpro = mysqli_fetch_array($resultpro);
							if ($rowpro["total"] <= 0) { $ver = false; }
						}
						if (($ver == true) and ($region != "")) {
							$sqlreg = "select count(*) as total from sgm_clients_rel_ubicacion where id_cliente=".$row["id"]." and tipo_ubicacion=4 and id_ubicacion in (".$region.")";
							$resultreg = mysqli_query($dbhandle,convertSQL($sqlreg));
							$rowreg = mysqli_fetch_array($resultreg);
							if ($rowreg["total"] <= 0) { $ver = false; }
						}
						#### INICI IMPRESIO PANTALLA
						if ($ver == true) {
							if ($linea_letra == 1) {
								echo "<tr style=\"background-color: Silver;\">";
									echo "<th></th>";
									echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\">".chr($i)."</a></th>";
									echo "<th>Fid.</th>";
									echo "<th>Vip</th>";
									echo "<th>DE</th>";
									echo "<th style=\"width:600px;\">".$Cliente."</th>";
									echo "<th>".$Telefono."</th>";
									echo "<th>".$Correo."</th>";
									echo "<th>".$Web."</th>";
									echo "<th></th>";
								echo "</tr>";
								$linea_letra = 0;
							}
							mostrarContacto($row["id"],$color);
							if ($color == "white") { $color = "#dcdcdc"; } else { $color = "white"; }
							$z++;
							#Se añade el id al array#
							array_push($clientes_ids,$row["id"]);
						}
						$ver_madre = $ver;
						$sqlsub = "select id,id_agrupacio from sgm_clients where visible=1 and id_agrupacio=".$row["id"];
						if ($likenombre != "") { $sqlsub = $sqlsub." and (nombre like '%".$likenombre."%' or cognom1 like '%".$likenombre."%' or cognom2 like '%".$likenombre."%')";}
						$sqlsub =$sqlsub." order by nombre,cognom1,cognom2,id_origen";
#						echo $sqlsub."<br>";
						$resultsub = mysqli_query($dbhandle,convertSQL($sqlsub));
						while ($rowsub = mysqli_fetch_array($resultsub)) {
							#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
							if ($ver_todas_letras == false) {
								if (($_POST[chr($i)] != true) and (!in_array(chr($i), $chars))) {
									$ver_madre = false;
								}
							}
							#### INICI IMPRESIO PANTALLA
							if ($ver_madre == true) {
								if ($linea_letra == 1) {
									echo "<tr style=\"background-color: Silver;\">";
										echo "<th></th>";
										echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></th>";
										echo "<th>Fid.</th>";
										echo "<th>Vip</th>";
										echo "<th>DE</th>";
										echo "<th style=\"width:600px;\">".$Cliente."</th>";
										echo "<th>".$Telefono."</th>";
										echo "<th>".$Correo."</th>";
										echo "<th>".$Web."</th>";
										echo "<th></th>";
									echo "</tr>";
									$linea_letra = 0;
								}
								mostrarContacto($rowsub["id"],$color);
								if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
								#Se comprueba que el id no este en el array y así no se contabilice dos veces#
								if (!in_array($rowsub["id"],$clientes_ids)) { $z++; }
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

	if ($soption == 1) {
		echo "<h4>".$Personas."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			if ($_GET["filtro"] == "") {
				echo "<caption  style=\"text-align:center;\">";
				for ($i = 48; $i <= 90; $i++) {
					if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
						$sqlxt = "select count(*) as total from sgm_clients_contactos where visible=1 and nombre like '".chr($i)."%'  order by nombre";
						$resultxt = mysqli_query($dbhandle,convertSQL($sqlxt));
						$rowxt = mysqli_fetch_array($resultxt);
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
					echo "<form action=\"index.php?op=1008&sop=1\" method=\"post\">";
					echo "<select name=\"id_client\" style=\"width:300px\">";
						echo "<option value=\"0\">-</option>";
						$sqle = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						while ($rowe = mysqli_fetch_array($resulte)){
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
				echo "<td class=\"submit\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
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
			$resultxt = mysqli_query($dbhandle,convertSQL($sqlxt));
			$rowxt = mysqli_fetch_array($resultxt);
				if ($rowxt["total"] > 0) {
					echo "<tr style=\"background-color: Silver;\">";
						echo "<th><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>".chr($i)."</strong></a></th>";
						echo "<th>".$Trato."</th>";
						echo "<th style=\"white-space:nowrap\">".$Nombre."</th>";
						echo "<th>".$Telefono."</th>";
						echo "<th>".$Movil."</th>";
						echo "<th>".$Empresa."</th>";
						echo "<th>".$Cargo."</th>";
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
					$result = mysqli_query($dbhandle,convertSQL($sqlt));
					while ($rowt = mysqli_fetch_array($result)) {
						$sqltr = "select trato from sgm_clients_tratos where id=".$rowt["id_trato"];
						$resultr = mysqli_query($dbhandle,convertSQL($sqltr));
						$rowtr = mysqli_fetch_array($resultr);
						$sqlc = "select nombre,cognom1,cognom2 from sgm_clients where id=".$rowt["id_client"];
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						$rowc = mysqli_fetch_array($resultc);
						if ($cambio == 0) { $color = "white"; $cambio = 1; } else { $color = "#F5F5F5"; $cambio = 0; }
						echo "<tr style=\"background-color:".$color."\">";
							echo "<td></td>";
							echo "<td>".$rowtr["trato"]."</td>";
							echo "<td style=\"white-space:nowrap;\"><a href=\"index.php?op=1008&sop=122&ssop=2&id=".$rowt["id_client"]."&id_contacto=".$rowt["id"]."\">".$rowt["nombre"]." ".$rowt["apellido1"]." ".$rowt["apellido2"]."</a></td>";
							echo "<td>".$rowt["telefono"]."</td>";
							echo "<td>".$rowt["movil"]."</td>";
							echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowt["id_client"]."\">".$rowc["nombre"]." ".$rowc["apellido1"]."  ".$rowc["apellido2"]." </a></td>";
							echo "<td>".$rowt["carrec"]."</td>";
						echo "</tr>";
					}
				}
			}
		}
		echo "</table>";
	}

	if ($soption == 2) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=0&id_tipo=".$_GET["id_tipo"]."&ssop=1&id=".$_GET["id"],"op=1008&sop=0&id_tipo=".$_GET["id_tipo"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 5) {
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"text-align:center;width:150px;\">".$Listado." ".$Contactos." : </td>";
				echo "<td></td>";
				echo "<form action=\"mgestion/gestion-clientes-print-pdf.php?\" target=\"_blank\" method=\"post\">";
					for ($i = 0; $i <= 127; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) {
								echo "<input type=\"Hidden\" name=\"".chr($i)."\" value=\"".$_POST[chr($i)]."\">";
							}
						}
					}
					echo "<input type=\"Hidden\" name=\"tipos\" value=\"".$_POST["tipos"]."\">";
					echo "<input type=\"Hidden\" name=\"sectores\" value=\"".$_POST["sectores"]."\">";
					echo "<input type=\"Hidden\" name=\"origenes\" value=\"".$_POST["origenes"]."\">";
					echo "<input type=\"Hidden\" name=\"paises\" value=\"".$_POST["paises"]."\">";
					echo "<input type=\"Hidden\" name=\"comunidades\" value=\"".$_POST["comunidades"]."\">";
					echo "<input type=\"Hidden\" name=\"provincias\" value=\"".$_POST["provincias"]."\">";
					echo "<input type=\"Hidden\" name=\"regiones\" value=\"".$_POST["regiones"]."\">";
					echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
				echo "<td style=\"text-align:center;width:100px;\"><input type=\"Checkbox\" name=\"colorsi\"> ".$Color."</td>";
				echo "<td style=\"text-align:center;width:100px;\"><input type=\"Checkbox\" name=\"completa\"> ".$Completo."</td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 6) {
		echo "<h4>".$Guardar." ".$Busquedas."</h4><br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Nombre."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1008&sop=200&ssop=2\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nom_cerca\" style=\"width:250px;\" required></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Guardar."\"></td>";
				$lletres = "";
				for ($i = 48; $i <= 90; $i++) {
					if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
						if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) {
							$lletres .= chr($i);
							echo "<input type=\"Hidden\" name=\"letras\" value=\"".$lletres."\">";
						}
					}
				}
				echo "<input type=\"Hidden\" name=\"tipos\" value=\"".$_POST["tipos"]."\">";
				echo "<input type=\"Hidden\" name=\"sectores\" value=\"".$_POST["sectores"]."\">";
				echo "<input type=\"Hidden\" name=\"origenes\" value=\"".$_POST["origenes"]."\">";
				echo "<input type=\"Hidden\" name=\"paises\" value=\"".$_POST["paises"]."\">";
				echo "<input type=\"Hidden\" name=\"comunidades\" value=\"".$_POST["comunidades"]."\">";
				echo "<input type=\"Hidden\" name=\"provincias\" value=\"".$_POST["provincias"]."\">";
				echo "<input type=\"Hidden\" name=\"regiones\" value=\"".$_POST["regiones"]."\">";
				echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	#Mascara superior del clients
	if (($soption >= 100) and ($soption < 200) and (($_GET["id"] != 0) or ($ssoption != 0))) {
		if (($soption == 100) and ($ssoption == 1)) {
			$camposInsert="nombre,cognom1,cognom2,nif,direccion,poblacion,cp,provincia,id_pais,tipo_identificador";
			$datosInsert = array($_POST["nombre"],$_POST["cognom1"],$_POST["cognom2"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["tipo_identificador"]);
			insertFunction ("sgm_clients",$camposInsert,$datosInsert);

			$sql = "select id from sgm_clients where visible=1 and nombre='".comillas($_POST["nombre"])."' and nif='".$_POST["nif"]."' order by id desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$id_client = $row["id"];
		} else {
			$id_client = $_GET["id"];
		}
		if (($soption == 100) and ($ssoption == 2)) {
			$camposUpdate = array('nombre','cognom1','cognom2','nif','direccion','poblacion','cp','provincia','id_pais','tipo_identificador','tipo_persona','tipo_residencia','dir3_oficina_contable','dir3_organo_gestor','dir3_unidad_tramitadora');
			$datosUpdate = array($_POST["nombre"],$_POST["cognom1"],$_POST["cognom2"],$_POST["nif"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["id_pais"],$_POST["tipo_identificador"],$_POST["tipo_persona"],$_POST["tipo_residencia"],$_POST["dir3_oficina_contable"],$_POST["dir3_organo_gestor"],$_POST["dir3_unidad_tramitadora"]);
			updateFunction("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
	
	}
		if ($id_client <= 0){
			$sql = "select * from sgm_clients where nombre='".$_POST["nombre"]."' and nif='".$_POST["nif"]."'";
		} else {
			$sql = "select * from sgm_clients where id=".$id_client;
		}
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
#		echo $sql;
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=100&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Fiscales."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=105&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Administrativos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=110&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Facturacion."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=115&id=".$row["id"]."\" style=\"color:white;\">".$Documentos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=160&id=".$row["id"]."\" style=\"color:white;\">".$Facturacion."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\" style=\"color:white;\">".$Contratos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=130&id=".$row["id"]."\" style=\"color:white;\">".$Informes."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=180&id=".$row["id"]."\" style=\"color:white;\">".$Incidencias."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=170&id=".$row["id"]."\" style=\"color:white;\">".$Contrasenas."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=120&id=".$row["id"]."\" style=\"color:white;\">".$Contactos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=150&id=".$row["id"]."\" style=\"color:white;\">".$Usuarios."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=190&id=".$row["id"]."\" style=\"color:white;\">".$Servidores."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1008&sop=135&id=".$row["id"]."\" style=\"color:white;\">".$Bases_Datos."</a></td>";
						echo "</tr>";
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
					if ($row["mail"] != "") { echo "<br>".$Email." : <a href=\"mailto:".$row["mail"]."\"><strong>".$row["mail"]."</strong></a>"; }
					if ($row["url"] != "") { echo "<br>".$Web." : <strong>".$row["url"]."</strong>"; }
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1008&sop=195&id=".$row["id"]."\" style=\"color:white;\">".$Opciones."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"mgestion/gestion-clientes-contact-print-pdf.php?id=".$row["id"]."\" style=\"color:white;\" target=\"_blank\">".$Imprimir."</a></td></tr>";
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
		if ($id_client > 0) {
			$sql = "select * from sgm_clients where id=".$id_client;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			echo "<form action=\"index.php?op=1008&sop=100&ssop=2&id=".$id_client."\"  method=\"post\">";
		} 
		if ($id_client <= 0) {
			echo "<h4>".$Nuevo." ".$Cliente."</h4>";
			echo "<form action=\"index.php?op=1008&sop=100&ssop=1\"  method=\"post\">";
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td></td><th>".$Datos_Fiscales."</th></tr>";
			echo "<tr><th class=\"formclient\">*".$Nombre.": </th><td style=\"width:400px\"><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"  class=\"formclient\" required></td></tr>";
			echo "<tr><th class=\"formclient\">".$Apellido." 1: </th><td><input type=\"Text\" name=\"cognom1\" value=\"".$row["cognom1"]."\" class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\">".$Apellido." 2: </th><td><input type=\"Text\" name=\"cognom2\" value=\"".$row["cognom2"]."\" class=\"formclient\"></td></tr>";
			echo "<tr><td></td><td style=\"vertical-align:middle;\">";
				echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"1\" style=\"border:0px solid black;width:15%\"";
				if ($row["tipo_identificador"] == 1) { echo " checked";}
				echo ">NIF&nbsp;&nbsp;";
				echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"2\" style=\"border:0px solid black;width:15%\"";
				if ($row["tipo_identificador"] == 2) { echo " checked";}
				echo ">VAT&nbsp;&nbsp;";
				echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"3\" style=\"border:0px solid black;width:15%\"";
				if ($row["tipo_identificador"] == 3) { echo " checked";}
				echo ">Extrangero&nbsp;&nbsp;";
				echo "<input type=\"Radio\" name=\"tipo_identificador\" value=\"4\" style=\"border:0px solid black;width:15%\"";
				if ($row["tipo_identificador"] == 4) { echo " checked";}
				echo ">Sin&nbsp;&nbsp;";
			echo "</td></tr>";
			echo "<tr><th class=\"formclient\">".$Numero.": </th><td><input type=\"Text\" name=\"nif\" value=\"".$row["nif"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\" style=\"vertical-align:top;\">*".$Direccion.": </th><td><textarea name=\"direccion\" class=\"formclient\" rows=\"3\">".$row["direccion"]."</textarea></td></tr>";
			echo "<tr><th class=\"formclient\">*".$CP.": </th><td><input type=\"Text\" name=\"cp\" value=\"".$row["cp"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\">*".$Poblacion.": </th><td><input type=\"Text\" name=\"poblacion\" value=\"".$row["poblacion"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\">*".$Provincia.": </th><td><input type=\"Text\" name=\"provincia\" value=\"".$row["provincia"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\">*".$Pais.": </th>";
				echo "<td><select name=\"id_pais\" class=\"formclient\">";
				echo "<option></option>";
				$sqlo = "select id,pais from sim_paises where visible=1 order by pais";
				$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
				while ($rowo = mysqli_fetch_array($resulto)) {
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
			echo "<tr><td></td><td>";
				if ($id_client > 0) { echo "<input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\">"; }
				if ($id_client <= 0) {	echo "<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\">"; }
			echo "</td></tr>";
		echo "</table>";
		echo "</form>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td style=\"text-align:right;\">*</td><td>".$Campos_obligatorios."</td></tr>";
		echo "</table>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=100&ssop=7&id=".$_GET["id"]."&id_class=".$_GET["id_class"],"op=1008&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Dades administratives
	if ($soption == 105) {
		if ($ssoption == 1) {
			$camposUpdate = array('mail','telefono','telefono2','fax','web','id_idioma','id_origen','id_agrupacio','client','clientvip','num_treballadors','notas','alias');
			$datosUpdate = array($_POST["mail"],$_POST["telefono"],$_POST["telefono2"],$_POST["fax"],$_POST["web"],$_POST["id_idioma"],$_POST["id_origen"],$_POST["id_agrupacio"],$_POST["client"],$_POST["clientvip"],$_POST["num_treballadors"],$_POST["notas"],$_POST["alias"]);
			updateFunction("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);

			if ($_POST["id_sector"] != -1){
				$sql = "select * from sgm_clients_rel_sectores where id_cliente=".$id_client." and id_sector=".$_POST["id_sector"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_sector";
					$datosInsert = array($id_client,$_POST["id_sector"]);
					insertFunction("sgm_clients_rel_sectores",$camposInsert,$datosInsert);
				}
			}

			if ($_POST["id_origen_cliente"] != -1){
				$sql = "select * from sgm_clients_rel_origen where id_cliente=".$id_client." and id_origen=".$_POST["id_origen_cliente"]." and tipo_origen=1";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_origen,tipo_origen";
					$datosInsert = array($id_client,$_POST["id_origen_cliente"],1);
					insertFunction("sgm_clients_rel_origen",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["id_cliente_origen"] != -1){
				$sql = "select * from sgm_clients_rel_origen where id_cliente=".$id_client." and id_origen=".$_POST["id_cliente_origen"]." and tipo_origen=2";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_origen,tipo_origen";
					$datosInsert = array($id_client,$_POST["id_cliente_origen"],2);
					insertFunction("sgm_clients_rel_origen",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["id_contacto_origen"] != -1){
				$sql = "select * from sgm_clients_rel_origen where id_cliente=".$id_client." and id_origen=".$_POST["id_contacto_origen"]." and tipo_origen=3";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_origen,tipo_origen";
					$datosInsert = array($id_client,$_POST["id_contacto_origen"],3);
					insertFunction("sgm_clients_rel_origen",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["id_empleado_origen"] != -1){
				$sql = "select * from sgm_clients_rel_origen where id_cliente=".$id_client." and id_origen=".$_POST["id_empleado_origen"]." and tipo_origen=4";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_origen,tipo_origen";
					$datosInsert = array($id_client,$_POST["id_empleado_origen"],4);
					insertFunction("sgm_clients_rel_origen",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["otro_origen"] != ''){
				$sql = "select * from sgm_clients_rel_origen where id_cliente=".$id_client." and otro_origen='".$_POST["otro_origen"]."' and tipo_origen=5";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,tipo_origen,otro_origen";
					$datosInsert = array($id_client,5,$_POST["otro_origen"]);
					insertFunction("sgm_clients_rel_origen",$camposInsert,$datosInsert);
				}
			}

			if ($_POST["id_ubicacion_pais"] != -1){
				$sql = "select * from sgm_clients_rel_ubicacion where id_cliente=".$id_client." and id_ubicacion=".$_POST["id_ubicacion_pais"]." and tipo_ubicacion=1";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_ubicacion,tipo_ubicacion";
					$datosInsert = array($id_client,$_POST["id_ubicacion_pais"],1);
					insertFunction("sgm_clients_rel_ubicacion",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["id_ubicacion_comunidad"] != -1){
				$sql = "select * from sgm_clients_rel_ubicacion where id_cliente=".$id_client." and id_ubicacion=".$_POST["id_ubicacion_comunidad"]." and tipo_ubicacion=2";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_ubicacion,tipo_ubicacion";
					$datosInsert = array($id_client,$_POST["id_ubicacion_comunidad"],2);
					insertFunction("sgm_clients_rel_ubicacion",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["id_ubicacion_provincia"] != -1){
				$sql = "select * from sgm_clients_rel_ubicacion where id_cliente=".$id_client." and id_ubicacion=".$_POST["id_ubicacion_provincia"]." and tipo_ubicacion=3";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_ubicacion,tipo_ubicacion";
					$datosInsert = array($id_client,$_POST["id_ubicacion_provincia"],3);
					insertFunction("sgm_clients_rel_ubicacion",$camposInsert,$datosInsert);
				}
			}
			if ($_POST["id_ubicacion_region"] != -1){
				$sql = "select * from sgm_clients_rel_ubicacion where id_cliente=".$id_client." and id_ubicacion=".$_POST["id_ubicacion_region"]." and tipo_ubicacion=4";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if (!$row){
					$camposInsert = "id_cliente,id_ubicacion,tipo_ubicacion";
					$datosInsert = array($id_client,$_POST["id_ubicacion_region"],4);
					insertFunction("sgm_clients_rel_ubicacion",$camposInsert,$datosInsert);
				}
			}
		}
		if ($ssoption == 2) {
			deleteFunction ("sgm_clients_rel_sectores",$_GET["id_sec"]);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_clients_rel_origen",$_GET["id_ori"]);
		}
		if ($ssoption == 4) {
			deleteFunction ("sgm_clients_rel_ubicacion",$_GET["id_ubi"]);
		}

		$sql = "select * from sgm_clients where id=".$id_client;
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<form action=\"index.php?op=1008&sop=105&ssop=1&id=".$id_client."\"  method=\"post\">";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:20%;\">";
					echo "<table class=\"formclient\">";
						echo "<tr><td></td><th>".$Datos." ".$Obligatorios.":</th></tr>";
						echo "<tr><th class=\"formclient\">".$Alias." <img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_cliente_alias."\"></th><td><input type=\"Text\" name=\"alias\" value=\"".$row["alias"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td></td><th>".$Datos_Adicionales."</th></tr>";
						echo "<tr><th class=\"formclient\">".$Email."</th><td><input type=\"Text\" name=\"mail\" value=\"".$row["mail"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Telefono." 1</th><td><input type=\"Text\" name=\"telefono\" value=\"".$row["telefono"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Telefono." 2</th><td><input type=\"Text\" name=\"telefono2\" value=\"".$row["telefono2"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Fax."</th><td><input type=\"Text\" name=\"fax\" value=\"".$row["fax"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Web."</th><td><input type=\"Text\" name=\"web\" value=\"".$row["web"]."\" class=\"formclient\"></td></tr>";
						echo "<tr><th class=\"formclient\">".$Idioma."</th><td>";
							echo "<select name=\"id_idioma\" style=\"width:100%;\">";
							echo "<option value=\"0\">-</option>";
							$sqli = "select id,idioma from sgm_idiomas where visible=1 order by idioma";
							$resulti = mysqli_query($dbhandle,convertSQL($sqli));
							while ($rowi = mysqli_fetch_array($resulti)) {
								if (($id_client <= 0) and ($rowi["predefinido"] == 1)){
										echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["idioma"]."</option>";
								} elseif ($row["id_idioma"] == $rowi["id"]){
										echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["idioma"]."</option>";
								} else {
									echo "<option value=\"".$rowi["id"]."\">".$rowi["idioma"]."</option>";
								}
							}
						echo "</td></tr>";
						echo "<tr><th class=\"formclient\">".$Numero." ".$Trabajadores."</th><td><input type=\"number\" min=\"0\" name=\"num_treballadors\" value=\"".$row["num_treballadors"]."\" class=\"formclient\"></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:40%;\">";
					echo "<table class=\"formclient\">";
						echo "<tr><td></td><th>".$Dependencias."</th></tr>";
						echo "<tr><th class=\"formclient2\">".$Delegacion." ".$Central."</th><td>";
							echo "<select name=\"id_origen\" style=\"width:100%\"><option value=\"0\">-</option>";
								$sqlo = "select id,nombre from sgm_clients where visible=1 order by nombre";
								$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
								while ($rowo = mysqli_fetch_array($resulto)) {
									if ($rowo["id"] != $row["id"]) {
										if ($rowo["id"] == $row["id_origen"]) { echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>"; }
										else { echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>"; }
									}
								}
							echo "</select>";
						echo "<tr><th class=\"formclient2\">".$Contacto." ".$Principal."</th><td>";
							echo "<select name=\"id_agrupacio\" style=\"width:100%\"><option value=\"0\">-</option>";
								$sqlo = "select id,nombre from sgm_clients where visible=1 order by nombre";
								$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
								while ($rowo = mysqli_fetch_array($resulto)) {
									if ($rowo["id"] != $row["id"]) {
										if ($rowo["id"] == $row["id_agrupacio"]) { echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>"; }
										else { echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>"; }
									}
								}
							echo "</select>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><th class=\"formclient2\">".$Notas."</th><td>";
							echo "<textarea name=\"notas\" style=\"width:100%;\" rows=\"5\">".$row["notas"]."</textarea>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:20%;\">";
					echo "<table class=\"formclient\">";
						echo "<tr><td></td><th>".$Clasificacion."</th></tr>";
						echo "<tr><th class=\"formclient2\">".$Cliente_fidelizado."</th><td>";
							if ($row["client"] == 1) {
								echo $Si." <input type=\"Radio\" name=\"client\" value=\"1\" style=\"border:0px solid black;width:25%\" checked>";
								echo $No." <input type=\"Radio\" name=\"client\" value=\"0\" style=\"border:0px solid black;width:25%\">";
							}
							if ($row["client"] == 0) {
								echo $Si." <input type=\"Radio\" name=\"client\" value=\"1\" style=\"border:0px solid black;width:25%\">";
								echo $No." <input type=\"Radio\" name=\"client\" value=\"0\" style=\"border:0px solid black;width:25%\" checked>";
							}
						echo "</td></tr>";
						echo "<tr><th class=\"formclient2\">".$Cliente_vip."  <img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_cliente_vip."\"></th><td>";
							if ($row["clientvip"] == 1) {
								echo $Si." <input type=\"Radio\" name=\"clientvip\" value=\"1\" style=\"border:0px solid black;width:25%\" checked>";
								echo $No." <input type=\"Radio\" name=\"clientvip\" value=\"0\" style=\"border:0px solid black;width:25%\">";
							}
							if ($row["clientvip"] == 0) {
								echo $Si." <input type=\"Radio\" name=\"clientvip\" value=\"1\" style=\"border:0px solid black;width:25%\">";
								echo $No." <input type=\"Radio\" name=\"clientvip\" value=\"0\" style=\"border:0px solid black;width:25%\" checked>";
							}
						echo "</td></tr>";
						echo "<tr>";
							echo "<th class=\"formclient2\" style=\"vertical-align:top;\">".$Tipo."</th>";
							echo "<td>";
								$sqlcl = "select id_tipo from sgm_clients_rel_tipos where id_cliente=".$id_client;
								$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
								while ($rowcl = mysqli_fetch_array($resultcl)) {
									$sqlcla = "select nombre from sgm_clients_tipos where id_origen<>0 and id=".$rowcl["id_tipo"];
									$resultcla = mysqli_query($dbhandle,convertSQL($sqlcla));
									while ($rowcla = mysqli_fetch_array($resultcla)) {
										echo $rowcla["nombre"]."<br>";
									}
								}
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:20%;\">";
					echo "<table class=\"formclient\">";
						echo "<tr><th style=\"width:5%;\"></th><th style=\"width:95%;\">".$Sector."</th></tr>";
						echo "<tr><td></td><td><select class=\"formclient\" name=\"id_sector\">";
							echo "<option value=\"-1\">Indeterminado</option>";
							$sql1 = "select * from sgm_clients_sectores where id_sector=0 order by sector";
							$result1 = mysqli_query($dbhandle,convertSQL($sql1));
							while ($row1 = mysqli_fetch_array($result1)) {
								$sqlsec2 = "select id,sector from sgm_clients_sectores where id_sector=".$row1["id"];
								$resultsec2 = mysqli_query($dbhandle,convertSQL($sqlsec2));
								$rowsec2 = mysqli_fetch_array($resultsec2);
								echo "<option value=\"".$row1["id"]."\">".$rowsec1["sector"]."-".$row2["sector"]."</option>";
							}
						echo "</select></td></tr>";
						$sqlse = "select id,id_sector from sgm_clients_rel_sectores where id_cliente=".$id_client;
						$resultse = mysqli_query($dbhandle,convertSQL($sqlse));
						while ($rowse = mysqli_fetch_array($resultse)) {
							$sqlsec = "select id,sector,id_sector from sgm_clients_sectores where id=".$rowse["id_sector"];
							$resultsec = mysqli_query($dbhandle,convertSQL($sqlsec));
							$rowsec = mysqli_fetch_array($resultsec);
							$sqlsec2 = "select sector from sgm_clients_sectores where id=".$rowsec["id_sector"];
							$resultsec2 = mysqli_query($dbhandle,convertSQL($sqlsec2));
							$rowsec2 = mysqli_fetch_array($resultsec2);
							echo "<tr>";
								echo "<td style=\"text-align:right;\" class=\"formclient\"><a href=\"index.php?op=1008&sop=106&id_sec=".$rowse["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
								echo "<td class=\"formclient\">".$rowsec2["sector"]."-".$rowsec["sector"]."</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr><tr><td>&nbsp;</td></tr><tr>";
				echo "<td style=\"vertical-align:top;\" colspan=\"4\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><th colspan=\"6\">".$Origen."</th></tr>";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th>".$Tipo."</th>";
							echo "<th>".$Cliente."</th>";
							echo "<th>".$Contacto."</th>";
							echo "<th>".$Empleado."</th>";
							echo "<th>".$Otro."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"width:16%;\"><select style=\"width:100%;\" name=\"id_origen_cliente\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql1 = "select id,origen from sgm_clients_origen order by origen";
								$result1 = mysqli_query($dbhandle,convertSQL($sql1));
								while ($row1 = mysqli_fetch_array($result1)) {
									echo "<option value=\"".$row1["id"]."\">".$row1["origen"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:35%;\"><select style=\"width:100%;\" name=\"id_cliente_origen\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql2 = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre,cognom1,cognom2";
								$result2 = mysqli_query($dbhandle,convertSQL($sql2));
								while ($row2 = mysqli_fetch_array($result2)) {
									echo "<option value=\"".$row2["id"]."\">".$row2["nombre"]." ".$row2["cognom1"]." ".$row2["cognom2"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:16%;\"><select style=\"width:100%;\" name=\"id_contacto_origen\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql3 = "select id,nombre,apellido1,apellido2 from sgm_clients_contactos where visible=1 order by nombre,apellido1,apellido2";
								$result3 = mysqli_query($dbhandle,convertSQL($sql3));
								while ($row3 = mysqli_fetch_array($result3)) {
									echo "<option value=\"".$row3["id"]."\">".$row3["nombre"]." ".$row3["apellido1"]." ".$row3["apellido2"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:16%;\"><select style=\"width:100%;\" name=\"id_empleado_origen\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql4 = "select id,nombre from sgm_rrhh_empleado where visible=1 order by nombre";
								$result4 = mysqli_query($dbhandle,convertSQL($sql4));
								while ($row4 = mysqli_fetch_array($result4)) {
									echo "<option value=\"".$row4["id"]."\">".$row4["nombre"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:16%;\"><input type=\"Text\" name=\"otro_origen\" value=\"".$row["otro_origen"]."\"></td>";
						echo"</tr>";
						echo "<tr>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori1 = "select * from sgm_clients_rel_origen where tipo_origen=1 and id_cliente=".$id_client;
								$resultori1 = mysqli_query($dbhandle,convertSQL($sqlori1));
								while ($rowori1 = mysqli_fetch_array($resultori1)) {
									$sql1 = "select id,origen from sgm_clients_origen where id=".$rowori1["id_origen"];
									$result1 = mysqli_query($dbhandle,convertSQL($sql1));
									$row1 = mysqli_fetch_array($result1);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=107&id_ori=".$rowori1["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row1["origen"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori2 = "select * from sgm_clients_rel_origen where tipo_origen=2 and id_cliente=".$id_client;
								$resultori2 = mysqli_query($dbhandle,convertSQL($sqlori2));
								while ($rowori2 = mysqli_fetch_array($resultori2)) {
									$sql2 = "select id,nombre,cognom1,cognom2 from sgm_clients where id=".$rowori2["id_origen"];
									$result2 = mysqli_query($dbhandle,convertSQL($sql2));
									$row2 = mysqli_fetch_array($result2);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=107&id_ori=".$rowori2["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row2["nombre"]." ".$row2["cognom1"]. "".$row2["cognom2"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori3 = "select * from sgm_clients_rel_origen where tipo_origen=3 and id_cliente=".$id_client;
								$resultori3 = mysqli_query($dbhandle,convertSQL($sqlori3));
								while ($rowori3 = mysqli_fetch_array($resultori3)) {
									$sql3 = "select id,nombre,apellido1,apellido2 from sgm_clients_contactos where id=".$rowori3["id_origen"];
									$result3 = mysqli_query($dbhandle,convertSQL($sql3));
									$row3 = mysqli_fetch_array($result3);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=107&id_ori=".$rowori3["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row3["nombre"]." ".$row3["apellido1"]." ".$row3["apellido2"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori4 = "select * from sgm_clients_rel_origen where tipo_origen=4 and id_cliente=".$id_client;
								$resultori4 = mysqli_query($dbhandle,convertSQL($sqlori4));
								while ($rowori4 = mysqli_fetch_array($resultori4)) {
									$sql4 = "select id,nombre from sgm_rrhh_empleado where id=".$rowori4["id_origen"];
									$result4 = mysqli_query($dbhandle,convertSQL($sql4));
									$row4 = mysqli_fetch_array($result4);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=107&id_ori=".$rowori4["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row4["nombre"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori5 = "select * from sgm_clients_rel_origen where tipo_origen=5 and id_cliente=".$id_client;
								$resultori5 = mysqli_query($dbhandle,convertSQL($sqlori5));
								while ($rowori5 = mysqli_fetch_array($resultori5)) {
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=107&id_ori=".$rowori5["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$rowori5["otro_origen"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr><td>&nbsp;</td></tr><tr>";
				echo "<td style=\"vertical-align:top;\" colspan=\"4\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><th>".$Ambito_geografico."</th></tr>";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th>".$Pais."</th>";
							echo "<th>".$Comunidad_autonoma."</th>";
							echo "<th>".$Provincia."</th>";
							echo "<th>".$Region."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"width:25%;\"><select style=\"width:100%;\" name=\"id_ubicacion_pais\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql1 = "select id,pais from sim_paises where visible=1 order by pais";
								$result1 = mysqli_query($dbhandle,convertSQL($sql1));
								while ($row1 = mysqli_fetch_array($result1)) {
									echo "<option value=\"".$row1["id"]."\">".$row1["pais"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:25%;\"><select style=\"width:100%;\" name=\"id_ubicacion_comunidad\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql2 = "select id,comunidad_autonoma from sim_comunidades_autonomas where visible=1 order by comunidad_autonoma";
								$result2 = mysqli_query($dbhandle,convertSQL($sql2));
								while ($row2 = mysqli_fetch_array($result2)) {
									echo "<option value=\"".$row2["id"]."\">".$row2["comunidad_autonoma"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:25%;\"><select style=\"width:100%;\" name=\"id_ubicacion_provincia\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql3 = "select id,provincia from sim_provincias where visible=1 order by provincia";
								$result3 = mysqli_query($dbhandle,convertSQL($sql3));
								while ($row3 = mysqli_fetch_array($result3)) {
									echo "<option value=\"".$row3["id"]."\">".$row3["provincia"]."</option>";
								}
							echo "</select></td>";
							echo "<td style=\"width:25%;\"><select style=\"width:100%;\" name=\"id_ubicacion_region\">";
								echo "<option value=\"-1\">Indeterminado</option>";
								$sql4 = "select id,region from sim_regiones where visible=1 order by region";
								$result4 = mysqli_query($dbhandle,convertSQL($sql4));
								while ($row4 = mysqli_fetch_array($result4)) {
									echo "<option value=\"".$row4["id"]."\">".$row4["region"]."</option>";
								}
							echo "</select></td>";
						echo"</tr>";
						echo "<tr>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori1 = "select * from sgm_clients_rel_ubicacion where tipo_ubicacion=1 and id_cliente=".$id_client;
								$resultori1 = mysqli_query($dbhandle,convertSQL($sqlori1));
								while ($rowori1 = mysqli_fetch_array($resultori1)) {
									$sql1 = "select id,pais from sim_paises where id=".$rowori1["id_ubicacion"];
									$result1 = mysqli_query($dbhandle,convertSQL($sql1));
									$row1 = mysqli_fetch_array($result1);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=108&id_ubi=".$rowori1["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row1["pais"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori2 = "select * from sgm_clients_rel_ubicacion where tipo_ubicacion=2 and id_cliente=".$id_client;
								$resultori2 = mysqli_query($dbhandle,convertSQL($sqlori2));
								while ($rowori2 = mysqli_fetch_array($resultori2)) {
									$sql2 = "select id,comunidad_autonoma from sim_comunidades_autonomas where id=".$rowori2["id_ubicacion"];
									$result2 = mysqli_query($dbhandle,convertSQL($sql2));
									$row2 = mysqli_fetch_array($result2);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=108&id_ubi=".$rowori2["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row2["comunidad_autonoma"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori3 = "select * from sgm_clients_rel_ubicacion where tipo_ubicacion=3 and id_cliente=".$id_client;
								$resultori3 = mysqli_query($dbhandle,convertSQL($sqlori3));
								while ($rowori3 = mysqli_fetch_array($resultori3)) {
									$sql3 = "select id,provincia from sim_provincias where id=".$rowori3["id_ubicacion"];
									$result3 = mysqli_query($dbhandle,convertSQL($sql3));
									$row3 = mysqli_fetch_array($result3);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=108&id_ubi=".$rowori3["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row3["provincia"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
							echo "<td style=\"text-align:center;vertical-align:top;\">";
								echo "<table>";
								$sqlori4 = "select * from sgm_clients_rel_ubicacion where tipo_ubicacion=4 and id_cliente=".$id_client;
								$resultori4 = mysqli_query($dbhandle,convertSQL($sqlori4));
								while ($rowori4 = mysqli_fetch_array($resultori4)) {
									$sql4 = "select id,region from sim_regiones where id=".$rowori4["id_ubicacion"];
									$result4 = mysqli_query($dbhandle,convertSQL($sql4));
									$row4 = mysqli_fetch_array($result4);
									echo "<tr>";
										echo "<td><a href=\"index.php?op=1008&sop=108&id_ubi=".$rowori4["id"]."&id=".$id_client."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
										echo "<td>".$row4["region"]."</td>";
									echo "</tr>";
								}
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr><tr><td>&nbsp;</td></tr><tr>";
				echo "<td class=\"submit\" colspan=\"4\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "</form>";
	}

	if ($soption == 106) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=105&ssop=2&id=".$_GET["id"]."&id_sec=".$_GET["id_sec"],"op=1008&sop=105&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 107) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=105&ssop=3&id=".$_GET["id"]."&id_ori=".$_GET["id_ori"],"op=1008&sop=105&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 108) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=105&ssop=4&id=".$_GET["id"]."&id_ubi=".$_GET["id_ubi"],"op=1008&sop=105&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Dades facturació
	if ($soption == 110) {
		if ($ssoption == 1) {
			$camposUpdate = array("cuentabancaria","dia_facturacion","dia_recibo","dias_vencimiento","dias","id_medio_facturacion","destino_facturacion","id_formato_facturacion","id_contacto_facturacion","notas_facturacion","dir3_oficina_contable","dir3_organo_gestor","dir3_unidad_tramitadora","tipo_persona","tipo_residencia");
			$datosUpdate = array($_POST["cuentabancaria"],$_POST["dia_facturacion"],$_POST["dia_recibo"],$_POST["dias_vencimiento"],$_POST["dias"],$_POST["id_medio_facturacion"],$_POST["destino_facturacion"],$_POST["id_formato_facturacion"],$_POST["id_contacto_facturacion"],$_POST["notas_facturacion"],$_POST["dir3_oficina_contable"],$_POST["dir3_organo_gestor"],$_POST["dir3_unidad_tramitadora"],$_POST["tipo_persona"],$_POST["tipo_residencia"]);
			updateFunction ("sgm_clients",$_GET["id"],$camposUpdate,$datosUpdate);
			if ($_POST["dia"] != 0){
				$camposInsert = "dia,id_cliente";
				$datosInsert = array($_POST["dia"],$_GET["id"]);
				insertFunction ("sgm_clients_dias_vencimiento",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			deleteFunction ("sgm_clients_dias_vencimiento",$_GET["id_dia"]);
		}

		$sql = "select id,dia_facturacion,dia_recibo,dias_vencimiento,dias,cuentabancaria,id_medio_facturacion,destino_facturacion,id_formato_facturacion,id_contacto_facturacion,notas_facturacion,dir3_oficina_contable,dir3_organo_gestor,dir3_unidad_tramitadora,tipo_persona,tipo_residencia from sgm_clients where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<form action=\"index.php?op=1008&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><th></th><th>".$Datos_Facturacion." :</th></tr>";
			echo "<tr>";
				echo "<th class=\"formclient\">IBAN</td>";
				echo "<td class=\"formclient2\"><input type=\"Text\" name=\"cuentabancaria\" style=\"width:100%\" value=\"".$row["cuentabancaria"]."\"></td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Dia." ".$Facturacion."</td>";
				echo "<td class=\"formclient2\">";
					$i = 1;
					echo "<select name=\"dia_facturacion\" style=\"width:50px\">";
						echo "<option value=\"0\">-</option>";
						for ($x = 1; $x < 32; $x++) {
							if ($row["dia_facturacion"] == $x) {
								echo "<option value=\"".$x."\" selected>".$x."</option>";
							} else {
								echo "<option value=\"".$x."\">".$x."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Dia." ".$Recibo."</td>";
				echo "<td class=\"formclient2\">";
					$i = 1;
					echo "<select name=\"dia_recibo\" style=\"width:50px\">";
						echo "<option value=\"0\">-</option>";
						for ($x = 1; $x < 32; $x++) {
							if ($row["dia_recibo"] == $x) {
								echo "<option value=\"".$x."\" selected>".$x."</option>";
							} else {
								echo "<option value=\"".$x."\">".$x."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Vencimiento."</td>";
				echo "<td class=\"formclient2\"><input type=\"numbre\" name=\"dias_vencimiento\" style=\"width:50px\" value=\"".$row["dias_vencimiento"]."\">";
					echo "<select name=\"dias\" style=\"width:100px\">";
						if ($row["dias"] == 1) {
							echo "<option value=\"1\" selected>".$Dias."</option>";
							echo "<option value=\"0\">".$Meses."</option>";
						}
						if ($row["dias"] == 0) {
							echo "<option value=\"1\">".$Dias."</option>";
							echo "<option value=\"0\" selected>".$Meses."</option>";
						}
					echo "</select>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Vencimiento." : ".$Dia." del ".$Mes."</td>";
				echo "<td class=\"formclient2\"><select name=\"dia\" style=\"width:50px\">";
					echo "<option value=\"0\">-</option>";
					for ($x = 1; $x < 32; $x++) {
						if ($rowdv["dia"] == $x) {
							echo "<option value=\"".$x."\" selected>".$x."</option>";
						} else {
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					}
				echo "</select></td>";
			echo "</tr>";
			$sqldv = "select dia,id from sgm_clients_dias_vencimiento where id_cliente=".$_GET["id"];
			$resultdv = mysqli_query($dbhandle,convertSQL($sqldv));
			while ($rowdv = mysqli_fetch_array($resultdv)){
				echo "<tr>";
					echo "<th class=\"formclient\"></td>";
					echo "<td class=\"formclient2\"><a href=\"index.php?op=1008&sop=110&ssop=2&id=".$_GET["id"]."&id_dia=".$rowdv["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>".$rowdv["dia"]."</td>";
				echo "</tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td></td><th>Facturae (DIR3):</th></tr>";
			echo "<tr><th class=\"formclient\">".$Oficina_contable.": </th><td><input type=\"Text\" name=\"dir3_oficina_contable\" value=\"".$row["dir3_oficina_contable"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\">".$Organo_gestor.": </th><td><input type=\"Text\" name=\"dir3_organo_gestor\" value=\"".$row["dir3_organo_gestor"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><th class=\"formclient\">".$Unidad_tramitadora.": </th><td><input type=\"Text\" name=\"dir3_unidad_tramitadora\" value=\"".$row["dir3_unidad_tramitadora"]."\"  class=\"formclient\"></td></tr>";
			echo "<tr><td></td><td style=\"vertical-align:top;text-align:left;\">";
				echo "<table style=\"width:100%;\">";
					echo "<tr>";
						echo "<td style=\"width:33%\">";
							echo "<input type=\"Radio\" name=\"tipo_persona\" value=\"0\" style=\"border:0px solid black;\"";
							if ($row["tipo_persona"] == 0) { echo " checked";}
							echo "></td><td>".$Juridica."";
						echo "</td><td style=\"width:33%\">";
							echo "<input type=\"Radio\" name=\"tipo_persona\" value=\"1\" style=\"border:0px solid black;\"";
							if ($row["tipo_persona"] == 1) { echo " checked";}
							echo "></td><td>".$Fisica."";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style=\"width:33%\">";
							echo "<input type=\"Radio\" name=\"tipo_residencia\" value=\"0\" style=\"border:0px solid black;\"";
							if ($row["tipo_residencia"] == 0) { echo " checked";}
							echo "></td><td>".$Residente."";
						echo "</td><td style=\"width:33%\">";
							echo "<input type=\"Radio\" name=\"tipo_residencia\" value=\"1\" style=\"border:0px solid black;\"";
							if ($row["tipo_residencia"] == 1) { echo " checked";}
							echo "></td><td>".$Residente."";
						echo "</td><td style=\"width:33%\">";
							echo "<input type=\"Radio\" name=\"tipo_residencia\" value=\"2\" style=\"border:0px solid black;\"";
							if ($row["tipo_residencia"] == 2) { echo " checked";}
							echo "></td><td>".$Extranjero."";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><th></th><th>".$Envio." :</th></tr>";
			echo "<tr>";
				echo "<th class=\"formclient\">".$Medio."</td>";
				echo "<td class=\"formclient2\">";
					echo "<select name=\"id_medio_facturacion\" style=\"width:100%\">";
						echo "<option value=\"0\">-</option>";
						$sql1 = "select id,medio_comunicacion from sim_medio_comunicacion where visible=1 order by medio_comunicacion";
						$result1 = mysqli_query($dbhandle,convertSQL($sql1));
						while ($row1 = mysqli_fetch_array($result1)) {
							if ($row1["id"] == $row["id_medio_facturacion"]) {
								echo "<option value=\"".$row1["id"]."\" selected>".$row1["medio_comunicacion"]."</option>";
							} else {
								echo "<option value=\"".$row1["id"]."\">".$row1["medio_comunicacion"]."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Destino." (".$Direccion.", URL, etc.)</td>";
				echo "<td class=\"formclient2\"><input type=\"Text\" name=\"destino_facturacion\" style=\"width:100%\" value=\"".$row["destino_facturacion"]."\"></td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Formato." ".$Documentos."</td>";
				echo "<td class=\"formclient2\">";
					echo "<select name=\"id_formato_facturacion\" style=\"width:100%\">";
						echo "<option value=\"0\">-</option>";
						$sql2 = "select id,formato_documento from sim_formato_documento where visible=1 order by formato_documento";
						$result2 = mysqli_query($dbhandle,convertSQL($sql2));
						while ($row2 = mysqli_fetch_array($result2)) {
							if ($row2["id"] == $row["id_formato_facturacion"]) {
								echo "<option value=\"".$row2["id"]."\" selected>".$row2["formato_documento"]."</option>";
							} else {
								echo "<option value=\"".$row2["id"]."\">".$row2["formato_documento"]."</option>";
							}
						}
					echo "</select>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Contacto."</td>";
				echo "<td class=\"formclient2\">";
					echo "<select name=\"id_contacto_facturacion\" style=\"width:94%\">";
						echo "<option value=\"0\">-</option>";
						$sql3 = "select id,nombre,apellido1,apellido2 from sgm_clients_contactos where visible=1 and id_client=".$_GET["id"]." order by nombre,apellido1,apellido2";
						$result3 = mysqli_query($dbhandle,convertSQL($sql3));
						while ($row3 = mysqli_fetch_array($result3)) {
							if ($row3["id"] == $row["id_contacto_facturacion"]) {
								echo "<option value=\"".$row3["id"]."\" selected>".$row3["nombre"]." ".$row3["apellido1"]." ".$row3["apellido2"]."</option>";
							} else {
								echo "<option value=\"".$row3["id"]."\">".$row3["nombre"]." ".$row3["apellido1"]." ".$row3["apellido2"]."</option>";
							}
						}
					echo "</select>";
					$sql4 = "select mail from sgm_clients_contactos where visible=1 and id_client=".$_GET["id"]." order by nombre,apellido1,apellido2";
					$result4 = mysqli_query($dbhandle,convertSQL($sql4));
					$row4 = mysqli_fetch_array($result4);
					echo "&nbsp;<a href=\"mailto:".$row4["mail"]."\"><img src=\"mgestion/pics/icons-mini/email_link.png\" style=\"border:0px;vertical-align:middle;\"></a>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<th class=\"formclient\">".$Notas."</td>";
				echo "<td class=\"formclient2\"><textarea name=\"notas_facturacion\" class=\"formclient\" rows=\"2\">".$row["notas_facturacion"]."</textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td><td class=\"submit\" colspan=\"3\"><input type=\"submit\" value=\"".$Guardar."\" style=\"width:100px\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=110&ssop=6&id=".$_GET["id"]."&id_tarifa=".$_GET["id_tarifa"],"op=1008&sop=110&ssop=6&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 115) {
		echo "<h4>".$Archivos."</h4>";
		anadirArchivo ($_GET["id"],2,"");
	}

	if ($soption == 116) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=115&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1008&sop=115&id=".$_GET["id"]),array($Si,$No));
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
			mysqli_query($dbhandle,convertSQL($sql));
			updateFunction ("sgm_clients_contactos",$_GET["id_contacto"],array("pred"),array("1"));
		}
		if ($ssoption == 5) {
			updateFunction ("sgm_clients_contactos",$_GET["id_contacto"],array("pred"),array("0"));
		}
		echo "<h4>".$Contactos."</h4>";
		echo boton(array("op=1008&sop=122&ssop=1&id=".$_GET["id"]),array($Anadir." ".$Contacto));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th style=\"width:50px;text-align:right;\">".$Predeterminarerminar."</th>";
				echo "<th style=\"width:50px;text-align:right;\">".$Eliminar."</th>";
				echo "<th style=\"width:300px;text-align:left;\">".$Nombre." ".$Contacto."</th>";
				echo "<th style=\"width:200px;text-align:left;\">".$Cargo."</th>";
				echo "<th style=\"width:100px;text-align:center;\">".$Telefono."</th>";
				echo "<th style=\"width:100px;text-align:center;\">".$Movil."</th>";
				echo "<th></th>";
				echo "<th style=\"width:100px;text-align:center;\"></th>";
			echo "</tr>";
			$sql = "select * from sgm_clients_contactos where id_client=".$_GET["id"]." and visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$color = "white";
				$colorl = "black";
				if ($row["pred"] == 1) { $color = "#FF4500"; $colorl = "white";}
				echo "<tr style=\"background-color : ".$color."\">";
					echo "<td class=\"submit\">";
					if ($row["pred"] == 1) {
						echo "<form action=\"index.php?op=1008&sop=120&ssop=5&id=".$_GET["id"]."&id_contacto=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
						echo "</form>";
					}
					if ($row["pred"] == 0) {
						echo "<form action=\"index.php?op=1008&sop=120&ssop=4&id=".$_GET["id"]."&id_contacto=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predeterminar."\">";
						echo "</form>";
					}
					echo "</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=121&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					$sqlt = "select trato from sgm_clients_tratos where id=".$row["id_trato"];
					$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
					$rowt = mysqli_fetch_array($resultt);
					echo "<td style=\"color:".$colorl.";\">".$rowt["trato"]." ".$row["nombre"]." ".$row["apellido1"]." ".$row["apellido2"]."</td>";
					echo "<td style=\"color:".$colorl.";\">".$row["carrec"]."</td>";
					echo "<td style=\"color:".$colorl.";\">".$row["telefono"]."</td>";
					echo "<td style=\"text-align:center;color:".$colorl.";\">".$row["movil"]."</td>";
					echo "<td style=\"text-align:center;color:".$colorl.";\">";
						if ($row["mail"] != "") { echo "<a href=\"mailto:".$row["mail"]."\"><img src=\"mgestion/pics/icons-mini/email_link.png\" style=\"border:0px\"></a>"; }
					echo "</td>";
					echo "<form action=\"index.php?op=1008&sop=122&ssop=2&id=".$row["id_client"]."&id_contacto=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
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
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);

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
				if ($ssoption == 1) { echo "<td></td><td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>"; }
				if ($ssoption == 2) { echo "<td></td><td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>"; }
			echo "</tr><tr>";
				echo "<th>".$Trato.": </th>";
				echo "<td><select name=\"id_trato\" style=\"width:50px\">";
						$sqlt = "select * from sgm_clients_tratos order by trato";
						$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
						while ($rowt = mysqli_fetch_array($resultt)) {
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
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)){
					$sqlcl = "select id_idioma from sgm_clients where visible=1 and id=".$rowc["id_client"];
					$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
					$rowcl = mysqli_fetch_array($resultcl);
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
				echo "<td><textarea name=\"notas\" rows=\"3\">".$rowc["notas"]."</textarea></td>";
			echo "</tr><tr>";
			if ($ssoption == 1) { echo "<td></td><td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>"; }
			if ($ssoption == 2) { echo "<td></td><td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>"; }
			echo "</tr>";
		echo "</table>";
		echo "</form>";
	}
	
#Informes
	if ($soption == 130) {
		informesContratos();
	}

#Bases de dades
	if ($soption == 135){
		echo afegirModificarBasesDades("op=1008&sop=135","op=1008&sop=136");
	}

	if ($soption == 136) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=135&ssop=3&id=".$_GET["id"]."&id_bd=".$_GET["id_bd"],"op=1008&sop=135&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
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
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			while ($rowcc = mysqli_fetch_array($resultcc)){
				echo "<tr>";
					$sql = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<td>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</td>";
					$sql = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<td>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
					echo "<td><a href=\"index.php?op=1011&sop=100&id=".$rowcc["id"]."\">".$rowcc["descripcion"]."</a></td>";
					echo "<form action=\"index.php?op=1008&sop=141&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1008&sop=145&id=".$_GET["id"]."&id_con=".$rowcc["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Archivo."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

#Detall del Contracte
	if ($soption == 141) {
		echo "<h4>".$Contrato." : </h4>";
		echo boton(array("op=1008&sop=140&id=".$_GET["id"]),array("&laquo; ".$Volver));
		mostrarContrato ($_GET["id_con"],$_GET["id"],0);
		echo "<br><br>";
		mostrarServicio ($_GET["id_con"],$_GET["id"],142);

	}

	if ($soption == 142) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=141&ssop=4&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"],"op=1008&sop=141&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

#Archius contractes
	if ($soption == 145) {
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
			$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
			$rowf = mysqli_fetch_array($resultf);
			deleteFunction ("sgm_files",$_GET["id_archivo"]);
			$filepath = "archivos/contratos/".$rowf["name"];
			unlink($filepath);
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"width:70%;vertical-align:top;\">";
					echo "<h4>".$Archivos." :</h4>";
					echo "<table>";
					$sql = "select * from sgm_files_tipos order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=3 and id_elemento=".$_GET["id_con"];
						$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
						while ($rowele = mysqli_fetch_array($resultele)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=146&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
								echo "<td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/archivos/contratos/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
							echo "</tr>";
						}
					}
					echo "</table>";
				echo "</td><td style=\"width:30%;vertical-align:top;\">";
					echo "<h4>".$Formulario_Subir_Archivo." :</h4>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1008&sop=145&ssop=1&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."\" method=\"post\">";
					echo "<table>";
						echo "<tr>";
							echo "<td><select name=\"id_tipo\" style=\"width:300px\">";
								$sql = "select * from sgm_files_tipos order by nombre";
								$result = mysqli_query($dbhandle,convertSQL($sql));
								while ($row = mysqli_fetch_array($result)) {
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

	if ($soption == 146) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=145&ssop=2&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$_GET["id_archivo"],"op=1008&sop=145&id=".$_GET["id"]."&id_con=".$_GET["id_con"]),array($Si,$No));
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
		echo "<h4>".$Facturacion."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"2\" class=\"lista\">";
			echo "<tr>";
			$sqltipos2 = "select id,tipo from sgm_factura_tipos where visible=1 and id in (select tipo from sgm_cabezera where visible=1 and id_cliente=".$_GET["id"].") order by orden,descripcion";
			$resulttipos2 = mysqli_query($dbhandle,convertSQL($sqltipos2));
			while ($rowtipos2 = mysqli_fetch_array($resulttipos2)) {
				$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
				$resultpermiso = mysqli_query($dbhandle,convertSQL($sqlpermiso));
				$rowpermiso = mysqli_fetch_array($resultpermiso);
				if ($rowpermiso["total"] > 0) { 
					if ($rowtipos2["id"] == $_GET["id_tipo"]) {$class2 = "menu_select";} else {$class2 = "menu";}
					echo "<td class=".$class2."><a href=\"index.php?op=1008&sop=160&id=".$_GET["id"]."&id_tipo=".$rowtipos2["id"]."&hist=1\" class=".$class2.">".$rowtipos2["tipo"]."</a></td>";
				} else { echo "<td style=\"background-color:black;color:white;border:1px solid black;text-align:center;vertical-align:middle;height:20px;width:150px;\"><a href=\"index.php?op=1008&sop=160\" class=\"menu\">".$rowtipos2["tipo"]."</a></td>"; }
			}
			echo "</tr>";
		echo "</table>";

		echo "<br>";
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id_tipo"];
		$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
		$rowtipos = mysqli_fetch_array($resulttipos);
		echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th></th>";
				if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
					echo "<th>Docs</th>";
				} else {echo "<th></th>";}
				echo "<th style=\"min-width:60px;\">".$Numero."</th>";
				if ($rowtipos["presu"] == 1) { echo "<th>Ver.</th>";} else {echo "<th></th>";}
				echo "<th style=\"min-width:65px;\">".$Fecha."</th>";
				if ($rowtipos["v_fecha_prevision"] == 1) { echo "<th style=\"min-width:70px;\">".$Prevision."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<th style=\"min-width:70px;\">".$Vencimiento."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_numero_cliente"] == 1) { echo "<th style=\"min-width:80px;\">Ref. Ped. ".$Cliente."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_rfq"] == 1) { echo "<th style=\"min-width:80px;\">".$Numero." RFQ</th>";} else {echo "<th></th>";}
				if ($rowtipos["tpv"] == 0) { echo "<th class=\"factur\">".$Cliente."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_subtipos"] == 1) { echo "<th style=\"min-width:100px;\">".$Subtipo."</th>";} else {echo "<th></th>";}
				echo "<th style=\"text-align:right;\">".$Subtotal."</th>";
				echo "<th style=\"text-align:right;\">".$Total."</th>";
				if ($rowtipos["v_recibos"] == 1)  {echo "<th style=\"text-align:right;\">".$Pendiente."</th>";} else {echo "<th></th>";}
				if ($_GET["id"]) {$link = "&id=".$_GET["id"];} else {$link = "";}
				if ($_GET["id_tipo"]) {$link .= "&id_tipo=".$_GET["id_tipo"];} else {$link .= "";}
				if ($_GET["hist"]) {$link .= "&hist=".$_GET["hist"];} else {$link .= "";}
				if ($_GET["filtra"] == 0){
					echo "<form action=\"index.php?op=1008&sop=".$_GET["sop"]."&filtra=1".$link."\" method=\"post\">";
				} else {
					echo "<form action=\"index.php?op=1008&sop=".$_GET["sop"]."&filtra=0".$link."\" method=\"post\">";
				}
				echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
				echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
				echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
				echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
				echo "<input type=\"Hidden\" name=\"codigo\" value=\"".$_POST["codigo"]."\">";
				echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
				echo "<input type=\"Hidden\" name=\"hist\" value=\"".$_POST["hist"]."\">";
				echo "<input type=\"Hidden\" name=\"todo\" value=\"1\">";
				if ($_GET["filtra"] == 0){
					echo "<td colspan=\"3\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Desplegar." ".$Todo."\"></td>";
				} else {
					echo "<td colspan=\"3\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Plegar." ".$Todo."\"></td>";
				}
				echo "</form>";
			echo "</tr>";
			$sql = "select * from sgm_cabezera where visible=1 and id_cliente=".$_GET["id"]." and tipo=".$_GET["id_tipo"];
			$sql = $sql." order by numero desc,version desc,fecha desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo mostrarFacturas($row);
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
		if ($ssoption == 1) {
			$duracion = 0;
			$sql = "select id from sgm_incidencias where visible=1";
			if ($_POST["id_servicio"] != 0){ $sql = $sql." and id_servicio=".$_POST["id_servicio"];}
			if (($_POST["mes"] != 0) or ($_GET["m"] != 0)){
				$mes = $_POST["mes"].$_GET["m"];
				$data1 = date(U, mktime(0, 0, 0, $mes, 1, 2013));
				$data2 = date(U, mktime(0, 0, 0, $mes, 31, 2013));
				$sql = $sql." and id in (select id_incidencia from sgm_incidencias_notas_desarrollo where data_registro2 between ".$data1." and ".$data2.")";
			}
			if (($_POST["id_usuario"] != 0) or ($_GET["u"] != 0)) { $sql = $sql." and id_usuario=".$_POST["id_usuario"].$_GET["u"]; }
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				if ($_POST["facturada".$row["id"]] == 1){
					$sqli = "select sum(duracion) as total_horas from sgm_incidencias where visible=1 and id_incidencia=".$row["id"];
					$resulti = mysqli_query($dbhandle,convertSQL($sqli));
					$rowi = mysqli_fetch_array($resulti);
					$duracion += $rowi["total_horas"];

					$camposUpdate = array("facturada");
					$datosUpdate = array(1);
					updateFunction ("sgm_incidencias",$row["id"],$camposUpdate,$datosUpdate);
				}
			}
			if ($duracion > 0){
				$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
				$datosInsert = array('fecha' => $date, 'fecha_prevision' => $date, 'id_cliente' => $_GET["id"], 'tipo' => 1);
				insertCabezera($datosInsert);

				$sql2 = "select id from sgm_cabezera where visible=1 and id_cliente=".$_GET["id"]." order by id desc";
				$result2 = mysqli_query($dbhandle,convertSQL($sql2));
				$row2 = mysqli_fetch_array($result2);

				$duracion2 = $duracion/60;
				$total_cuerpo = $duracion2*$_POST["pvp"];
				$camposInsert = "idfactura,unidades,fecha_prevision,fecha_prevision_propia,nombre,pvp,total";
				$datosInsert = array($row2["id"],$duracion2,$date,$date,$_POST["nombre"],$_POST["pvp"],$total_cuerpo);
				insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);

				refactura($row2["id"]);
			}
		}

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
					if ($_POST["id_servicio"] == "-1"){
						echo "<option value=\"-1\" selected>".$SinContrato."</option>";
					} else {
						echo "<option value=\"-1\">".$SinContrato."</option>";
					}
					$sqlc = "select id,id_cliente,id_cliente_final from sgm_contratos where visible=1 and id_cliente=".$_GET["id"]." order by num_contrato";
					$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
					while ($rowc = mysqli_fetch_array($resultc)) {
						$sqlcl = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"]." order by nombre";
						$resultcl = mysqli_query($dbhandle,convertSQL($sqlcl));
						$rowcl = mysqli_fetch_array($resultcl);
						$sqlcli = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"]." order by nombre";
						$resultcli = mysqli_query($dbhandle,convertSQL($sqlcli));
						$rowcli = mysqli_fetch_array($resultcli);
						$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"];
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						while ($rows = mysqli_fetch_array($results)){
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
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					while ($rowu = mysqli_fetch_array($resultu)) {
							if (($rowu["id"] == $_POST["id_usuario"]) or ($rowu["id"] == $_GET["u"])){
								echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
							} else {
								echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
							}
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
			echo "</tr>";
		echo "</form>";
		echo "</table>";
		echo "<br><br>";
		if (($_POST["id_servicio"] != 0) or ($_POST["mes"] != 0) or ($_POST["id_usuario"] != 0)){
			echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\" style=\"background-color:silver;\">";
				echo "<tr style=\"background-color:silver;\">";
					if ($_POST["id_servicio"] == "-1"){echo "<th></th>";}
					echo "<th>".$SLA."</th>";
					echo "<th>".$Fecha." ".$Prevision."</th>";
					echo "<th>".$Asunto."</th>";
					echo "<th>".$Cliente." ".$Final."</th>";
					echo "<th>".$Contrato." - ".$Servicio."</th>";
					echo "<th>".$Duracion."</th>";
					echo "<th>".$Usuario."</th>";
					echo "<th></th>";
				echo "</tr>";

			echo "<form action=\"index.php?op=1008&sop=180&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<input type=\"Hidden\" name=\"id_servicio\" value=\"".$_POST["id_servicio"]."\">";
			echo "<input type=\"Hidden\" name=\"id_usuario\" value=\"".$_POST["id_usuario"]."\">";
			echo "<input type=\"Hidden\" name=\"mes\" value=\"".$_POST["mes"]."\">";
			$sql = "select * from sgm_incidencias where visible=1 and id_estado=-2";
			if ($_POST["id_servicio"] != 0){ $sql = $sql." and id_servicio=".$_POST["id_servicio"];}
			if ($_POST["mes"] != 0){
				$mes = $_POST["mes"];
				$data1 = date(U, mktime(0, 0, 0, $mes, 1, 2013));
				$data2 = date(U, mktime(0, 0, 0, $mes, 31, 2013));
				$sql = $sql." and id in (select id_incidencia from sgm_incidencias_notas_desarrollo where data_registro2 between ".$data1." and ".$data2.")";
			}
			if (($_POST["id_usuario"] != 0) or ($_GET["u"] != 0)) { $sql = $sql." and id_usuario=".$_POST["id_usuario"].$_GET["u"]; }
			$sql = $sql." order by fecha_prevision asc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlcli = "select nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rows["id_cliente_final"]." order by nombre";
				$resultcli = mysqli_query($dbhandle,convertSQL($sqlcli));
				$rowcli = mysqli_fetch_array($resultcli);
				$sqlc = "select id,temps_resposta,servicio from sgm_contratos_servicio where id=".$row["id_servicio"];
				if ($_POST["id_servicio"] != 0) { $sqlc = $sqlc." and id=".$_POST["id_servicio"].""; }
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				$sqls = "select id,id_cliente_final,descripcion from sgm_contratos where id_cliente=".$_GET["id"]." and id=".$rowc["id_contrato"]." order by fecha_ini desc";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				$rows = mysqli_fetch_array($results);

				$estado_color = "White";
				$estado_color_letras = "Black";
				$sqlu = "select usuario from sgm_users where id=".$row["id_usuario_destino"];
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);
				$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$row["id"]." and visible=1";
				$resultd = mysqli_query($dbhandle,convertSQL($sqld));
				$rowd = mysqli_fetch_array($resultd);
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
					if ($_POST["id_servicio"] == "-1"){
						echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"facturada".$row["id"]."\"";
						if ($row["facturada"] == 1) { echo " disabled"; }
						echo " value=\"1\" style=\"border:0px solid black\"></td>";
					}
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$sla."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$fecha_prev."</td>";
					if (strlen($row["nombre"]) > 50) {
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".substr($row["asunto"],0,50)." ...</td>";
					} else {
						echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$row["asunto"]."</a></td>";
					}
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowcli["nombre"]." ".$rowcli["cognom1"]." ".$rowcli["cognom2"]."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rows["descripcion"]." - ".$rowc["servicio"]."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$horas[0]."h. ".$minutos."m.</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".$rowu["usuario"]."</td>";
					echo "<td style=\"text-align:center;vertical-align:top;\">";
						echo "<a href=\"index.php?op=1018&sop=100&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px;\"><a>";
					echo "</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td colspan=\"7\"><table><tr>";
			if ($_POST["id_servicio"] == "-1"){
				echo "<td>".$Concepto."</td>";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:250px;\" required></td>";
				echo "<td>".$Precio."/".$Hora."</td>";
				echo "<td><input type=\"number\" name=\"pvp\" style=\"width:50px;\" required></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Facturar."\"></td>";
			}
			echo "</form>";
			echo "</tr>";
			echo "</table></td></tr>";
		echo "</table>";
		}
	}

#Servidors	
	if ($soption == 190) {
		echo afegirModificarServidors("op=1008&sop=190","op=1008&sop=191");
		echo "<br><br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo servidoresMonitorizados ($_GET["id"],5,192);
		echo "</table>";
	}

	if ($soption == 191) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=190&ssop=3&id=".$_GET["id"]."&id_serv=".$_GET["id_serv"],"op=1008&sop=190&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 192){
		detalleServidoresMonitorizados ($_GET["id"],$_GET["id_serv"],$color_corp);
	}

#Opcions clients
	if ($soption == 195) {
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
							echo "<a href=\"index.php?op=1008&sop=196&id=".$_GET["id"]."\" style=\"color:white;\">".$Eliminar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table></center>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 196) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=0&id_tipo=0&ssop=1&id=".$_GET["id"],"op=1008&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 300) {
		if (comprobarTipoCliente()){
			mensageInfo($OkActualizacionCliente,"green");
		} else {
			mensageError($ErrorActualizacionCliente);
		}
	}

	if ($soption == 500) {
		if ($admin == true) {
			$ruta_botons = array("op=1008&sop=510","op=1008&sop=520","op=1008&sop=540","op=1008&sop=560","op=1008&sop=570");
			$texto = array($Origenes,$Sectores,$Tratos,$Tipos,$Busquedas);
			echo boton($ruta_botons,$texto);
		}
		if ($admin == false) {
			echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";
		}
	}

	if (($soption == 510) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "origen";
			$datosInsert = array(comillas($_POST["origen"]));
			insertFunction ("sgm_clients_origen",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("origen");
			$datosUpdate = array(comillas($_POST["origen"]));
			updateFunction ("sgm_clients_origen",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "select id from sgm_clients_rel_origen where id_origen=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				deleteFunction ("sgm_clients_rel_origen",$row["id"]);
			}
			deleteFunction ("sgm_clients_origen",$_GET["id"]);
		}

		echo "<h4>".$Origen." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1008&sop=510&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</td>";
				echo "<th>".$Origen."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"origen\" required></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,origen from sgm_clients_origen order by origen";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=512&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1008&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["origen"]."\" style=\"width:200px\" name=\"origen\" required></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 512) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=510&ssop=3&id=".$_GET["id"],"op=1008&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) AND ($admin == true)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$camposInsert = "id_sector,sector";
			$datosInsert = array(comillas($_POST["id_sector"]),comillas($_POST["sector"]));
			insertFunction ("sgm_clients_sectores",$camposInsert,$datosInsert);
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$camposUpdate = array("id_sector","sector");
			$datosUpdate = array(comillas($_POST["id_sector"]),comillas($_POST["sector"]));
			updateFunction ("sgm_clients_sectores",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."sector=0";
			$sql = $sql." WHERE sector=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			deleteFunction ("sgm_clients_sectores",$_GET["id"]);
		}

		echo "<h4>".$Sectores.":</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1008&sop=520&ssop=1\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Sector." ".$Principal."</th>";
				echo "<th>".$Sector."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td>";
					echo "<select name=\"id_sector\" style=\"width:200px\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select id,sector from sgm_clients_sectores order by sector";
						$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
						while ($rowt = mysqli_fetch_array($resultt)) {
							echo "<option value=\"".$rowt["id"]."\">".$rowt["sector"]."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"sector\" required></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,id_sector,sector from sgm_clients_sectores order by sector";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=521&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1008&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td>";
						echo "<select name=\"id_sector\" style=\"width:200px\">";
							echo "<option value=\"0\">-</option>";
							$sqlt = "select id,sector from sgm_clients_sectores order by sector";
							$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
							while ($rowt = mysqli_fetch_array($resultt)) {
								if ($rowt["id"] == $row["id_sector"]){
									echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["sector"]."</option>";
								} else {
									echo "<option value=\"".$rowt["id"]."\">".$rowt["sector"]."</option>";
								}
							}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"text\" value=\"".$row["sector"]."\" style=\"width:200px\" name=\"sector\" required></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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
			mysqli_query($dbhandle,convertSQL($sql));
			deleteFunction ("sgm_clients_tratos",$_GET["id"]);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_clients_tratos set ";
			$sql = $sql."predeterminado = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$sql = "update sgm_clients_tratos set ";
			$sql = $sql."predeterminado = ".$_GET["s"];
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
		}

		echo "<h4>".$Tratos." :</h4>";
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
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select id,trato,predeterminado from sgm_clients_tratos order by trato";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$color = "white";
				if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
				echo "<td class=\"submit\">";
				if ($row["predeterminado"] == 1) {
					echo "<form action=\"index.php?op=1008&sop=540&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
					echo "</form>";
				}
				if ($row["predeterminado"] == 0) {
					echo "<form action=\"index.php?op=1008&sop=540&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predeterminar."\">";
					echo "</form>";
				}
				echo "</td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=541&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				echo "<form action=\"index.php?op=1008&sop=540&ssop=2&id=".$row["id"]."\" method=\"post\" required>";
				echo "<td><input type=\"text\" value=\"".$row["trato"]."\" style=\"width:200px\" name=\"trato\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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

	if (($soption == 560)) {
		echo "<h4>".$Tipos." :</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Principal."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Color." ".$Boton."</th>";
				echo "<th>".$Color." ".$Letra."</th>";
				echo "<th>".$Factura."</th>";
				echo "<th>".$Tipo." ".$Factura."</th>";
				echo "<th>".$Contrato."</th>";
				echo "<th>".$Contrato." ".$Activo."</th>";
				echo "<th>".$Incidencia."</th>";
				echo "<th>".$Datos_Fiscales."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1008&sop=560&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td>";
				echo "<select name=\"id_origen\" style=\"width:100%\">";
				echo "<option value=\"0\">-</option>";
				$sqlt = "select id,nombre from sgm_clients_tipos where visible=1";
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				while ($rowt = mysqli_fetch_array($resultt)) {
					echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
				}
				echo "</select>";
				echo "</td>";
				echo "<td><input type=\"text\" style=\"width:100%\" name=\"nombre\" required></td>";
				echo "<td><input type=\"text\" style=\"width:100%\" name=\"color\" required></td>";
				echo "<td><input type=\"text\" style=\"width:100%\" name=\"color_letra\" required></td>";
				echo "<td>";
					echo "<select name=\"factura\" style=\"width:100%\">";
						echo "<option value=\"2\" selected>-</option>";
						echo "<option value=\"0\">".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "<select name=\"id_tipo_factura\" style=\"width:100%\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select id,tipo from sgm_factura_tipos order by tipo";
						$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
						while ($rowt = mysqli_fetch_array($resultt)) {
							echo "<option value=\"".$rowt["id"]."\">".$rowt["tipo"]."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "<select name=\"contrato\" style=\"width:100%\">";
						echo "<option value=\"2\" selected>-</option>";
						echo "<option value=\"0\">".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "<select name=\"contrato_activo\" style=\"width:100%\">";
						echo "<option value=\"0\" selected>".$Todos."</option>";
						echo "<option value=\"1\">".$Activo."</option>";
						echo "<option value=\"2\">".$Inactivo."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "<select name=\"incidencia\" style=\"width:100%\">";
						echo "<option value=\"2\" selected>-</option>";
						echo "<option value=\"0\">".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td>";
					echo "<select name=\"datos_fiscales\" style=\"width:100%\">";
						echo "<option value=\"2\" selected>-</option>";
						echo "<option value=\"0\">".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_clients_tipos where visible=1 order by id_origen,nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					$sqlx = "select count(*) as total from sgm_clients_tipos where visible=1 and id_origen=".$row["id"];
					$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
					$rowx = mysqli_fetch_array($resultx);
					if ($rowx["total"] == 0){
						echo "<td><center><a href=\"index.php?op=1008&sop=561&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></center></td>";
					} else {
						echo "<td></td>";
					}
					echo "<form action=\"index.php?op=1008&sop=560&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td>";
						echo "<select name=\"id_origen\" style=\"width:100%\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select id,nombre from sgm_clients_tipos where visible=1 and id<>".$row["id"];
						$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
						while ($rowt = mysqli_fetch_array($resultt)) {
							if ($rowt["id"] == $row["id_origen"]){
								echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:100%\" name=\"nombre\" required></td>";
					if ($row["id_origen"] == 0){
						echo "<td><input type=\"text\" value=\"".$row["color"]."\" style=\"width:100%\" name=\"color\" required></td>";
						echo "<td><input type=\"text\" value=\"".$row["color_letra"]."\" style=\"width:100%\" name=\"color_letra\" required></td>";
					} else {
						echo "<td></td>";
						echo "<td></td>";
					}
					echo "<td>";
						echo "<select name=\"factura\" style=\"width:100%\">";
							if ($row["factura"] == 0){
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} elseif ($row["factura"] == 1) {
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							} elseif ($row["factura"] == 2) {
								echo "<option value=\"2\" selected>-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td>";
						echo "<select name=\"id_tipo_factura\" style=\"width:100%\">";
							echo "<option value=\"0\">-</option>";
							$sqlt = "select id,tipo from sgm_factura_tipos order by tipo";
							$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
							while ($rowt = mysqli_fetch_array($resultt)) {
								if ($row["id_tipo_factura"] == $rowt["id"]){
									echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["tipo"]."</option>";
								} else {
									echo "<option value=\"".$rowt["id"]."\">".$rowt["tipo"]."</option>";
								}
							}
						echo "</select>";
					echo "</td>";
					echo "<td>";
						echo "<select name=\"contrato\" style=\"width:100%\">";
							if ($row["contrato"] == 0){
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} elseif ($row["contrato"] == 1) {
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							} elseif ($row["contrato"] == 2) {
								echo "<option value=\"2\" selected>-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td>";
						echo "<select name=\"contrato_activo\" style=\"width:100%\">";
							if ($row["contrato_activo"] == 0){
								echo "<option value=\"0\" selected>".$Todos."</option>";
								echo "<option value=\"1\">".$Activo."</option>";
								echo "<option value=\"2\">".$Inactivo."</option>";
							} elseif ($row["contrato_activo"] == 1){
								echo "<option value=\"0\">".$Todos."</option>";
								echo "<option value=\"1\" selected>".$Activo."</option>";
								echo "<option value=\"2\">".$Inactivo."</option>";
							} elseif ($row["contrato_activo"] == 2){
								echo "<option value=\"0\">".$Todos."</option>";
								echo "<option value=\"1\">".$Activo."</option>";
								echo "<option value=\"2\" selected>".$Inactivo."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td>";
						echo "<select name=\"incidencia\" style=\"width:100%\">";
							if ($row["incidencia"] == 0){
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} elseif ($row["incidencia"] == 1) {
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							} elseif ($row["incidencia"] == 2) {
								echo "<option value=\"2\" selected>-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td>";
						echo "<select name=\"datos_fiscales\" style=\"width:100%\">";
							if ($row["datos_fiscales"] == 0){
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} elseif ($row["datos_fiscales"] == 1) {
								echo "<option value=\"2\">-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							} elseif ($row["datos_fiscales"] == 2) {
								echo "<option value=\"2\" selected>-</option>";
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "<br>* no se pueden eliminar aquellas definiciones con otras definiciones asociadas.<br><br>";
	}

	if (($soption == 561) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1008&sop=560&ssop=3&id=".$_GET["id"],"op=1008&sop=560"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 570) {
		if ($ssoption == 2){
			$camposUpdate = array("nombre");
			$datosUpdate = array(comillas($_POST["nombre"]));
			updateFunction ("sgm_clients_busquedas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3){
			deleteFunction ("sgm_clients_busquedas",$_GET["id"]);
		}
	
		echo "<h4>".$Busquedas."</h4>";
		echo boton(array("op=1008&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sql = "select id,nombre from sgm_clients_busquedas where nombre<>'' order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<form action=\"index.php?op=1008&sop=570&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=570&ssop=3&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<td><input type=\"Text\" value=\"".$row["nombre"]."\" name=\"nombre\" style=\"width:250px;\"></td>";
					echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
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

	echo "</td></tr></table><br>";
}

function mostrarContacto($id,$color) {
	global $db,$dbhandle,$Editar,$Enviar,$Email,$Web;
	$sql = "select * from sgm_clients where id=".$id;
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	echo "<tr style=\"background-color:".$color."\">";
		echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
		if (($row["tipo_identificador"] == 2) or ($row["tipo_identificador"] == 3) or ($row["tipo_identificador"] == 4)) { $check_nif = 1;} else { $check_nif = valida_nif_cif_nie($row["nif"]);}
		if (($check_nif <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
			echo "<td><img src=\"mgestion/pics/icons-mini/page_white_error.png\" title=\"Error Id. Fiscal\" alt=\"Error Id. Fiscal\" border=\"0\"></td>";
		} else { 
			echo "<td></td>"; 
		}
		if ($row["client"] == 1) { echo "<td><img src=\"mgestion/pics/icons-mini/accept.png\" alt=\"SI\" border=\"0\"></td>"; } else  { echo "<td></td>"; }
		if ($row["clientvip"] == 1) { echo "<td><img src=\"mgestion/pics/icons-mini/accept.png\" alt=\"SI\" border=\"0\"></td>"; } else  { echo "<td></td>"; }
		$sqltotal= "select count(*) as total from sgm_clients where visible=1 and id_origen=".$row["id"]." and id<>".$row["id"];
		$resulttotal = mysqli_query($dbhandle,convertSQL($sqltotal));
		$rowtotal = mysqli_fetch_array($resulttotal);
		if ($rowtotal["total"] > 0) { echo "<td><img src=\"mgestion/pics/icons-mini/building_add.png\" alt=\"SI\" border=\"0\"></td>"; } else  { echo "<td></td>"; }
		$distancia = 5;
		$letra = "bold";
		if ($row["id_agrupacio"] != 0) { $distancia = 15; $letra = "normal";}
		### NOMBRE
		echo "<td style=\"padding-left:".$distancia."px;font-weight:".$letra.";white-space:nowrap;\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</td>";
		### FIN NOMBRE
		echo "<td>".$row["telefono"]."</td>";
		if ($row["mail"] != "") { echo "<td><a href=\"mailto:".$row["mail"]."\"><img src=\"mgestion/pics/icons-mini/email_link.png\" title=\"".$Enviar." ".$Email."\" alt=\"Email\" border=\"0\"></a></td>"; } else { echo "<td></td>"; }
		if ($row["web"] != "") { echo "<td><a href=\"http://".$row["web"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/world_link.png\" title=\"".$Web."\" alt=\"Web\" border=\"0\"></a></td>"; } else { echo "<td></td>"; }
		echo "<form action=\"index.php?op=1008&sop=100&id=".$row["id"]."\" method=\"post\">";
		echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
		echo "</form>";
	echo "</tr>";
}

?>