<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);

if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1012) AND ($autorizado == true)) {

	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Mailing."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1012&sop=0\" class=".$class.">".$Envio."</a></td>";
					if (($soption == 200)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1012&sop=200\" class=".$class.">".$Historico."</a></td>";
					if (($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1012&sop=500\" class=".$class.">".$Administrar."</a></td>";
					if ($soption == 600) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1012&sop=600\" class=".$class.">".$Ayuda."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
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
	#		echo $tipo."- ".$sector."- ".$origen."- ".$pais."- ".$comunidad."- ".$provincia."- ".$region."- ".var_dump($chars);
		}

		echo "<h4>".$Buscar_Contacto." : </h4>";
		echo "<form action=\"index.php?op=1012&sop=0&filtro=1\" method=\"post\">";
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
			echo "</tr><tr>";
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
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<th style=\"text-align:right\">".$Contactos."</th>";
				echo "<td style=\"text-align:leftt\">";
					echo "<select name=\"contactes\" style=\"width:50px\">";
						echo "<option value=\"0\">".$No."</option>";
							if ($_POST["contactes"] == 1) {
								echo "<option value=\"1\" selected>".$Si."</option>";
							} else {
								echo "<option value=\"1\">".$Si."</option>";
							}
						echo "</select>";
				echo "</td>";
				echo "<th></th>";
				echo "<td style=\"text-align:center;\" colspan=\"15\" class=\"Submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
			echo "</tr>";
		echo "</table>";
		echo "</form>";
		echo "<br>";

		$ok = 0;
		for ($i = 48; $i <= 90; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				if (($_POST[chr($i)] == true) or (in_array(chr($i), $chars))) { $ok = 1;}
			}
		}
		if ($_GET["id_tipo"] != "") {$tipo_cliente = $_GET["id_tipo"];} else {$tipo_cliente = $tipo;}
		if (($soption == 0) or (($_GET["filtro"] == 1) and ((isset($tipo_cliente)) or (isset($sector)) or (isset($origen)) or (isset($pais)) or (isset($comunidad)) or (isset($provincia)) or (isset($region)) or ($likenombre != "") or ($ok == 1)))) {
			$ver = true;
			if ($tipo_cliente != 0){
				$sqlct = "select * from sgm_clients_tipos where visible=1 and id=".$tipo_cliente;
				$resultct = mysqli_query($dbhandle,convertSQL($sqlct));
				$rowct = mysqli_fetch_array($resultct);
				$nombre_tipo = $rowct["nombre"];
			} else {
				$nombre_tipo = "";
			}

			echo "<br><br>";
			##################################################
			################### BUSCADOR   ###################
			##################################################
			echo "<center>";
			echo "<h4>".$Contactos."</h4>";
			for ($i = 0; $i <= 127; $i++) {
				if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
					echo "<a href=\"#".chr($i)."\"><strong>".chr($i)."</strong></a>&nbsp;";
				}
			}
			echo "<br><br>";
			echo "<form name=\"formulari\" action=\"index.php?op=1012&sop=110\" method=\"post\">";
			echo boton_funcion(array("javascript:marcar()","javascript:desmarcar()","javascript:marcar_perso()","javascript:desmarcar_perso()"),array($Marcar." ".$Contacto,$Desmarcar." ".$Contacto,$Marcar." ".$Personal,$Desmarcar." ".$Personal));
			echo "</center>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
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
									echo "<td><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></td>";
									echo "<td><center><em>".$Nombre." ".$Cliente."</em></center></td>";
									echo "<td></td>";
									echo "<td><em>".$Enviar."</em></td>";
									echo "<td><em>".$Email."</em></td>";
									echo "<td><em>".$Carta."</em></td>";
									echo "<td><em>".$Etiqueta."</em></td>";
								echo "</tr>";
								$linea_letra = 0;
							}
							ver_contacto_mailing($row["id"],$color,$_POST["contactes"],$check);
							if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
						}
					}
				}
			}
			#### FIN TABLA, MUESTRA NUMERO RESULTADOS Y LEYENDA
			echo "</table>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr>";
					echo "<td class=\"submit\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Enviar."\"></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
			echo "<br><br>";
		}
	}

	if ($soption == 110) {
		var_dump($_POST["enviar"]);
		var_dump($_POST["enviar_perso"]);

		echo "<h4>".$Envio."</h4>";
		boton_volver($Volver);
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<form action=\"index.php?op=1012&sop=120\" method=\"post\">";
				echo "<td>";
					echo "<select name=\"e-mail\" style=\"width:170px\">";
						$sqle = "select * from sgm_cartas where visible=1 and carta=0 order by asunto";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						while ($rowe = mysqli_fetch_array($resulte)){
							echo "<option value=\"".$rowe["id"]."\">".$rowe["asunto"]."</option>";
						}
					echo "</select>";
					foreach($_POST["enviar"] as $clients){
						echo "<input type=\"hidden\" name=\"clients[]\" value=\"".$clients."\">";
					}
					foreach($_POST["enviar_perso"] as $contactes){
						echo "<input type=\"hidden\" name=\"contactes[]\" value=\"".$contactes."\">";
					}
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Email."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"".$urloriginal."/mgestion/gestion-mailing-print.php?\" target=\"_blank\" method=\"post\" name=\"post\">";
				echo "<td>";
					echo "<select name=\"carta\" style=\"width:170px\">";
						$sqlc = "select * from sgm_cartas where visible=1 and carta=1 order by asunto";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							echo "<option value=\"".$rowc["id"]."\">".$rowc["asunto"]."</option>";
						}
					echo "</select>";
					echo "<input type=\"Hidden\" name=\"clients\" value=\"".$clients."\">";
					echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$contactes."\">";
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Carta."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"".$urloriginal."/mgestion/gestion-clientes-eti-print.php?\" target=\"_blank\" method=\"post\" name=\"post\">";
				echo "<td>";
					echo "<select name=\"etiquetas\" style=\"width:170px\">";
							echo "<option value=\"0\">Contactos</option>";
							echo "<option value=\"1\">Personales</option>";
					echo "</select>";
					echo "<input type=\"Hidden\" name=\"clients\" value=\"".$clients."\">";
					echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$contactes."\">";
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Etiqueta."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 120) {
		var_dump($_POST["clients"]);
		var_dump($_POST["contactes"]);

		echo "<h4>".$Email."</h4>";
		echo "<center><table>";
			echo "<tr>";
				echo "<td>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<form action=\"index.php?op=1012&sop=130\" method=\"post\">";
						$sql = "select * from sgm_cartas where visible=1 and id=".$_POST["e-mail"];
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						$sqlf = "select * from sgm_cartas_firmas where id_user=".$userid."";
						$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
						$rowf = mysqli_fetch_array($resultf);
						$sqla = "select * from sgm_cartas_adjuntos where id_user=".$userid;
						$resulta = mysqli_query($dbhandle,convertSQL($sqla));
						$rowa = mysqli_fetch_array($resulta);
						echo "<tr>";
							echo "<td style=\"text-align:right\"><strong>".$Asunto." :</strong></td>";
							echo "<td><input type=\"Text\" name=\"asunto\" style=\"width:600px\" value=\"".$row["asunto"]."\"></td>";
						echo "</tr><tr>";
							echo "<td style=\"text-align:right;vertical-align:top;\"><strong>".$Texto." :</strong></td>";
							echo "<td><textarea name=\"cuerpo\" rows=\"20\" style=\"width:600px\">".$row["cuerpo"]."\n\n\n".$rowf["firma"]."</textarea></td>";
						echo "</tr>";
							foreach($_POST["clients"] as $clients){
								echo "<input type=\"hidden\" name=\"clients[]\" value=\"".$clients."\">";
							}
							foreach($_POST["contactes"] as $contactes){
								echo "<input type=\"hidden\" name=\"contactes[]\" value=\"".$contactes."\">";
							}
							echo "<input type=\"Hidden\" name=\"mail\" value=\"".$row["id"]."\">";
						echo "<tr>";
							echo "<td></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Enviar."\"></td>";
						echo "</tr></form>";
					echo "</table>";
				echo "</td><td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<td><strong>".$Archivos." ".$Adjuntos." : </strong></td>";
						echo "</tr>";
						$sqlad = "select * from sgm_cartas_adjuntos where id_carta=".$_POST["e-mail"];
						$resultad = mysqli_query($dbhandle,convertSQL($sqlad));
						while ($rowad = mysqli_fetch_array($resultad)){
							echo "<tr>";
								echo "<td><a href=\"".$urloriginal."/mgestion/imagen.php?id=".$rowad["id"]."&tipo=2\" target=\"_blank\">".$rowad["nombre_archivo"]."</a></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 130) {
		var_dump($_POST["clients"]);
		var_dump($_POST["contactes"]);
#		$clients = $_POST["clients"];
#		$contactes = $_POST["contactes"];

		foreach($_POST["clients"] as $clients){
			$sqle = "select * from sgm_clients where visible=1 and id=".$clients;
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			$rowe = mysqli_fetch_array($resulte);
			if ($rowe["mail"] != ""){
				send_mail_mailing($_POST["asunto"],$_POST["cuerpo"],$_POST["mail"],$rowe["mail"]);
				$camposInsert = "id_user,id_client,id_carta,fecha";
				$datosInsert = array($userid,$clients,$_POST["mail"],date('Y-m-d'));
				insertFunction("sgm_cartas_enviadas",$camposInsert,$datosInsert);
			}
		}
		foreach($_POST["contactes"] as $contactes){
			echo $sqle = "select * from sgm_clients_contactos where visible=1 and id=".$contactes;
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			$rowe = mysqli_fetch_array($resulte);
			if ($rowe["mail"] != ""){
				send_mail_mailing($_POST["asunto"],$_POST["cuerpo"],$_POST["mail"],$rowe["mail"]);
				$camposInsert = "id_user,id_contacto,id_carta,fecha";
				$datosInsert = array($userid,$contactes,$_POST["mail"],date('Y-m-d'));
				insertFunction("sgm_cartas_enviadas",$camposInsert,$datosInsert);
			}
		}
	}

	if ($soption == 200) {
		echo "<h4>".$Historico." de ".$Correo."</h4>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<caption>".$Buscador." </caption>";
			echo "<tr>";
				echo "<td>".$Cliente."</td>";
				echo "<td>".$Formato."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1012&sop=200\" method=\"post\">";
				echo "<td>";
				echo "<select name=\"id_client\" style=\"width:300px\">";
					$sqle = "select nombre,cognom1,cognom2,id from sgm_clients where visible=1 order by nombre";
					$resulte = mysqli_query($dbhandle,convertSQL($sqle));
					while ($rowe = mysqli_fetch_array($resulte)){
						if ($_POST["id_client"] == $rowe["id"]){
							echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["nombre"]." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</option>";
						}
					}
				echo "</select>";
				echo "</td>";
				echo "<td>";
				echo "<select name=\"carta\" style=\"width:100px\">";
					if ($_POST["carta"] == 0){
						echo "<option value=\"1\">".$Carta."</option>";
						echo "<option value=\"0\" selected>".$Email."</option>";
					} else {
						echo "<option value=\"1\">".$Carta."</option>";
						echo "<option value=\"0\">".$Email."</option>";
					}
				echo "</select>";
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Buscar."\"></td>";
			echo "</tr></table>";
		if ($_POST["id_client"] != "") {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td style=\"width:100px;\">".$Fecha."</td>";
					echo "<td style=\"width:200px;\">".$Usuario."</td>";
					echo "<td style=\"width:300px;\">".$Cliente."</td>";
					echo "<td style=\"width:300px;\">".$Contacto."</td>";
					echo "<td style=\"width:200px;\">".$Asunto."</td>";
				echo "</tr>";

			$sqls = "select * from sgm_cartas_enviadas where id_client=".$_POST["id_client"]." or id_contacto in (select id from sgm_clients_contactos where visible=1 and id_client=".$_POST["id_client"].")";
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			while ($rows = mysqli_fetch_array($results)) {
				$sqlc = "select asunto from sgm_cartas where id=".$rows["id_carta"]." and carta=".$_POST["carta"];
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);

				$sqlu = "select usuario from sgm_users where id=".$rows["id_user"];
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);

				$sqlec = "select nombre,apellido1,apellido2,id_client from sgm_clients_contactos where visible=1 and id=".$rows["id_contacto"];
				$resultec = mysqli_query($dbhandle,convertSQL($sqlec));
				$rowec = mysqli_fetch_array($resultec);
				if ($rows["id_contacto"] > 0){
					$id_cliente = $rowec["id_client"];
				} else {
					$id_cliente = $rows["id_client"];
				}
				$sqle = "select nombre,cognom1,cognom2 from sgm_clients where id=".$id_cliente;
				$resulte = mysqli_query($dbhandle,convertSQL($sqle));
				$rowe = mysqli_fetch_array($resulte);
				echo "<tr>";
					echo "<td style=\"width:100px;\">".$rows["fecha"]."</td>";
					echo "<td style=\"width:200px;\">".$rowu["usuario"]."</td>";
					echo "<td style=\"width:300px;\">".$rowe["nombre"]." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</td>";
					echo "<td style=\"width:300px;\">".$rowec["nombre"]." ".$rowec["apellido1"]." ".$rowec["apellido2"]."</td>";
					echo "<td style=\"width:200px;\">".$rowc["asunto"]."</td>";
				echo "</tr>";
				}
			echo "</table>";
		}
	}

 	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1012&sop=510","op=1012&sop=520"),array($Carta."/".$Email,$Firma));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "asunto,cuerpo,carta";
			$datosInsert = array($_POST["asunto"],$_POST["message"],$_POST["carta"]);
			insertFunction ("sgm_cartas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array('0');
			updateFunction("sgm_cartas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Carta."</h4>";
		echo boton(array("op=1012&sop=500","op=1012&sop=511"),array("&laquo; ".$Volver,$Anadir." ".$Carta."/".$Email));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center\">".$Asunto."</td>";
				echo "<td><em>".$Editar."</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_cartas where visible=1 order by asunto";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$color = "black";
				if ($row["id"] == $_GET["id"]){
					echo "<tr style=\"background-color:#4B53AF;\">";
					$color = "white";
				} else {
					echo "<tr>";
				}
				echo "<form action=\"index.php?op=1012&sop=511&id=".$row["id"]."\" method=\"post\">";
				echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=512&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
				echo "<td style=\"width:200px\">".$row["asunto"]."</td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
				echo "</form>";
			echo "</tr>";
			}
		echo "</table>";
	}
	if ($soption == 511) {
		if ($ssoption == 2) {
			$camposUpdate=array('asunto','cuerpo','carta');
			$datosUpdate=array($_POST["asunto"],$_POST["cuerpo"],$_POST["carta"]);
			updateFunction("sgm_cartas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_cartas_adjuntos",$_GET["id_adj"]);
		}

	if ($_GET["id"] == "") {
			echo "<h4>".$Anadir." ".$Nueva." ".$Carta."</h4>";
		} else {
			echo "<h4>".$Modificar." ".$Carta."</h4>";
		}
		echo boton(array("op=1012&sop=510"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				if ($_GET["id"] == "") {
					echo "<form action=\"index.php?op=1012&sop=510&ssop=1\" method=\"post\" name=\"post\">";
				} else {
					echo "<form action=\"index.php?op=1012&sop=511&ssop=2&id=".$_GET["id"]."\" method=\"post\" name=\"post\">";
				}
				$sql = "select * from sgm_cartas where visible=1 and id=".$_GET["id"]." order by asunto";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				echo "<tr>";
					echo "<td style=\"text-align:right;vertical-align:top;\"><strong>".$Carta."/".$Email." :</strong></td>";
					echo "<td>";
						echo "<select name=\"carta\" style=\"width:120px\">";
							if ($_GET["id"] == ""){
								echo "<option value=\"1\">".$Carta."</option>";
								echo "<option value=\"0\">".$Email."</option>";
							} else {
								$sqlu = "select * from sgm_cartas where id=".$_GET["id"];
								$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
								while ($rowu = mysqli_fetch_array($resultu)){
									if ($rowu["carta"] == 1) {
										echo "<option value=\"1\" selected>".$Carta."</option>";
										echo "<option value=\"0\">".$Email."</option>";
									} else {
										echo "<option value=\"1\">".$Carta."</option>";
										echo "<option value=\"0\" selected>".$Email."</option>";
									}
								}
							}
						echo "</select>";
					echo "</td>";
				echo "</tr><tr>";
					echo "<td style=\"text-align:right\"><strong>".$Asunto." :</strong></td>";
					echo "<td><input type=\"Text\" name=\"asunto\" style=\"width:600px\" value=\"".$row["asunto"]."\"></td>";
				echo "</tr><tr>";
					echo "<td style=\"text-align:right;vertical-align:top;\"><strong>".$Texto." :</strong></td>";
					echo "<td><textarea name=\"message\" rows=\"20\" style=\"width:600px\">".$row["cuerpo"]."</textarea></td>";
				echo "</tr><tr>";
					echo "<td></td>";
					echo "<td class=\"submit\">";
						if ($_GET["id"] == "") {
							echo "<input type=\"submit\" value=\"".$Anadir."\">";
						}else{
							echo "<input type=\"submit\" value=\"".$Modificar."\">";
						}
					echo "</td>";
				echo "</tr>";
				echo "</form>";
			echo "</table>";
			echo "<br>";
			anadirArchivo ($_GET["id"],8);
	}

	if ($soption == 512) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1012&sop=510&ssop=3&id=".$_GET["id"],"op=1012&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 520) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_cartas_firmas where id_user=".$userid;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if ($row["id"] == 0) {
				$camposinsert = "firma,id_user";
				$datosInsert = array($_POST["firma"],$userid);
				insertFunction ("sgm_cartas_firmas",$camposinsert,$datosInsert);
			} else {
				$camposUpdate = array("firma");
				$datosUpdate = array($_POST["firma"]);
				updateFunction ("sgm_cartas_firmas",$row["id"],$camposUpdate,$datosUpdate);
			}
		}

		echo "<h4>".$Firma." ".$Personal."</h4>";
		echo boton(array("op=1012&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1012&sop=520&ssop=1\" method=\"post\" name=\"post\">";
			$sql = "select * from sgm_cartas_firmas where id_user=".$userid."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			echo "<tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\"><strong>".$Firma." :</strong></td>";
				echo "<td><textarea name=\"firma\" rows=\"20\" style=\"width:600px\">".$row["firma"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	echo "</td></tr></table><br>";
}

function ver_contacto_mailing($id,$color,$contactes,$check) {
	global $db,$dbhandle;
	$sql = "select * from sgm_clients where visible=1 and id=".$id;
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	echo "<tr style=\"background-color:".$color."\">";
		echo "<td></td>";
		echo "<td>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</td><td></td>";
		if (($check == 1) or ($check != "")){
			echo "<td><input type=\"Checkbox\" id=\"chequea\" name=\"enviar[]\" value=\"0\"></td>";
		}
		if (($check == 1) or ($check == "")){
			echo "<td><input type=\"Checkbox\" id=\"chequea\" name=\"enviar[]\" value=\"".$row["id"]."\" checked></td>";
		}
		echo "<td><a href=\"index.php?op=1012&sop=150&ssop=1&id=".$row["id"]."&x=1\"><img src=\"mgestion/pics/icons-mini/page_white_world.png\" border=\"0\"></a></td>";
		echo "<td><a href=\"index.php?op=1012&sop=150&ssop=2&id=".$row["id"]."&x=1\"><img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"></a></td>";
		echo "<td><a href=\"index.php?op=1012&sop=160&id=".$row["id"]."&x=1\"><img src=\"mgestion/pics/icons-mini/vcard.png\" border=\"0\"></a></td>";
	echo "</tr>";
	if ($contactes == 1) {
		$sql = "select * from sgm_clients_contactos where visible=1 and id_client=".$id;
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)){
			echo "<tr><td></td><td style=\"padding-left:15px;\">".$row["nombre"]." ".$row["apellido1"]." ".$row["apellido2"]."</td><td>".$row["departament"]."</td>";
			if (($check == 1) or ($check != "")){
				echo "<td><input type=\"Checkbox\" id=\"chequea_perso\" name=\"enviar_perso[]\" value=\"0\"></td>";
			}
			if (($check == 1) or ($check == "")){
				echo "<td><input type=\"Checkbox\" id=\"chequea_perso\" name=\"enviar_perso[]\" value=\"".$row["id"]."\" checked></td>";
			}
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=1&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/page_white_world.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=150&ssop=2&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"></a></td>";
			echo "<td><a href=\"index.php?op=1012&sop=160&id=".$row["id"]."&x=2\"><img src=\"mgestion/pics/icons-mini/vcard.png\" border=\"0\"></a></td>";
			echo "</tr>";
		}
	}
}

function send_mail_mailing($asunto,$cuerpo,$mail,$destinatario){
	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$titulo = "=?ISO-8859-1?B?".base64_encode($asunto)."?=";
	$mensaje = "<html><head></head><body bgcolor=\"white\">";
	$mensaje .= "<font face=\"Calibri\" size=4>";
	$mensaje .= $cuerpo;
	$mensaje .= "</font>";

	$separador = "_separador_de_trozos_".md5 (uniqid (rand()));
	
	$cabecera = "MIME-Version: 1.0".$UN_SALTO; 
	$cabecera .= "From: ".$remitente."<".$remite.">".$UN_SALTO;
	$cabecera .= "Return-path: ". $remite.$UN_SALTO;
	$cabecera .= "Reply-To: ".$remite.$UN_SALTO;
	$cabecera .="X-Mailer: PHP/". phpversion().$UN_SALTO;
	$cabecera .= "Content-Type: multipart/mixed;".$UN_SALTO; 
	$cabecera .= " boundary=".$separador."".$DOS_SALTOS; 
	$texto ="--".$separador."".$UN_SALTO; 
	$texto .="Content-Type: text/html; charset=\"ISO-8859-1\"".$UN_SALTO; 
	$texto .="Content-Transfer-Encoding: 7bit".$DOS_SALTOS; 
	$texto .= $mensaje;
	$sqla = "select * from sgm_files where tipo_id_elemento=8 and id_elemento=".$mail;
	$resulta = mysqli_query(convertSQL($sqla));
	while ($rowa = mysqli_fetch_array($resulta)){
		$adj1 .= $UN_SALTO."--".$separador."".$UN_SALTO;
		$adj1 .="Content-Type: ".$rowa["tipo"]."; name=\"".$rowa["nombre_archivo"]."\"".$UN_SALTO;
		$adj1 .="Content-Disposition: inline; filename=\"".$rowa["nombre_archivo"]."\"".$UN_SALTO;
		$adj1 .="Content-Transfer-Encoding: base64".$DOS_SALTOS;
		$adj1 .= chunk_split(base64_encode($rowa["contenido"]));
	}
	$mensaje=$texto.$adj1;
	if( mail('conchi.rodriguez@multivia.com', $titulo, $mensaje, $cabecera)){
		echo "<br>Se ha enviado un mail a : <strong>".$mail_dest."</strong>";
	}
}

?>