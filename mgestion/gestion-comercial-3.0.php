<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) { echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1009) AND ($autorizado == true)) {

	echo "<table class=\"principal\"><tr>";
		echo "<tr><td>";
			echo "<center><table><tr>";
				echo "<td><strong>".$Comercial." :</strong></td>";
				if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1009&sop=0\" class=".$class.">".$Ver." ".$Oferta_Comercial."</a></td>";
				if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1009&sop=100\" class=".$class.">".$Anadir." ".$Oferta_Comercial."</a></td>";
				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1009&sop=200\" class=".$class.">".$Buscar." ".$Oferta_Comercial."</a></td>";
				if (($soption >= 300) and ($soption < 400)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1009&sop=300\" class=".$class.">".$Administrar."</a></td>";
			echo "</tr></table>";
		echo "</center></td></tr>";
	echo "</table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 1) {
			$camposInsert="numero,versio,data,id_client,id_client_final,descripcio,num_host,id_idioma";
			$datosInsert=array($_POST["numero"],$_POST["versio"],$_POST["data"],$_POST["id_client"],$_POST["id_client_final"],$_POST["descripcio"],$_POST["num_host"],$_POST["id_idioma"]);
			insertFunction("sgm_comercial_oferta",$camposInsert,$datosInsert);
		}
		if ($soption == 0) { echo "<strong>".$Actual."</strong>";}
		if ($soption == 1) { echo "<strong>".$Historico."</strong>";}
		if ($soption == 200) { echo "<strong>".$Buscador."</strong>";}
		echo "<br><br>";
		if ($soption != 200){
			echo "<table><tr>";
				echo "<td class=\"boton\">";
					if ($soption == 1) { echo "<a href=\"index.php?op=1009&sop=0\" style=\"color:white;\">".$Activo."</a>";}
					if ($soption == 0) { echo "<a href=\"index.php?op=1009&sop=1\" style=\"color:white;\">".$Inactivo."</a>";}
				echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
		}
		echo "<center>";
		if ($soption == 200){
			echo "<form action=\"index.php?op=1009&sop=200\" method=\"post\">";
			echo "<table cellspacing=\"0\" style=\"background-color:silver;\">";
				echo "<tr>";
					echo "<td>".$Cliente."</td>";
					echo "<td>".$Cliente." ".$Final."</td>";
					echo "<td>".$Descripcion."</td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><select style=\"width:250px\" name=\"id_client2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_client2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_client_final2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_client_final2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Filtrar."\" style=\"width:150px\"></td>";
				echo "</tr>";
			echo "</form>";
			echo "</table>";
			echo "<br><br>";
		}
		if (($soption != 200) or ($_POST["id_client2"] > 0) or ($_POST["id_client_final2"] > 0)){
			echo "<table cellspacing=\"0\" style=\"width:1000px;\">";
				echo "<form action=\"index.php?op=1009&sop=100&ssop=1\" method=\"post\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td><em>".$Eliminar."</em></td>";
					echo "<td style=\"text-align:center;\">".$Cliente."</td>";
					echo "<td style=\"text-align:center;\">".$Cliente." ".$Final."</td>";
					echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
					echo "<td><em>".$Editar."</em></td>";
				echo "</tr>";
				$sqlcc = "select * from sgm_comercial_oferta where visible=1 ";
				if ($_POST["id_client2"] > 0) {
					$sqlcc = $sqlcc." and id_client=".$_POST["id_client2"]."";
				}
				if ($_POST["id_client_final2"] > 0) {
					$sqlcc = $sqlcc." and id_client_final=".$_POST["id_client_final2"]."";
				}
#				if ($soption == 0){ $sqlcc = $sqlcc." and renovado=0";}
#				if ($soption == 1){ $sqlcc = $sqlcc." and renovado=1";}
				echo $sqlcc."<br>";
				$resultcc = mysql_query(convert_sql($sqlcc));
				while ($rowcc = mysql_fetch_array($resultcc)){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=0&ssop=3&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_client"]."";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=210&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_client_final"]."";
						$result = mysql_query(convert_sql($sql));
						$row = mysql_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=210&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						echo "<td><a href=\"index.php?op=1009&sop=100&id=".$rowcc["id"]."\">".$rowcc["descripcio"]."</a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=100&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
					echo "</tr>";
				}
			echo "</table>";
			echo "</center>";
		}
	}

	if ($soption == 10) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este contrato?<br><br>";
		echo "<a href=\"index.php?op=1009&sop=0&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1009&sop=0\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 100) {
		if ($ssoption == 2) {
			$camposUpdate=array('numero','versio','data','id_client','id_client_final','descripcio','num_host','id_idioma');
			$datosUpdate=array($_POST["numero"],$_POST["versio"],$_POST["data"],$_POST["id_client"],$_POST["id_client_final"],$_POST["descripcio"],$_POST["num_host"],$_POST["id_idioma"]);
			updateFunction("sgm_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_comercial_oferta",$_GET["id"]);
		}
		if ($ssoption == 4) {
			$camposInsert="ordre,id_comercial_contingut,id_comercial_oferta";
			$datosInsert=array($_POST["ordre"],$_POST["id_contingut"],$_GET["id"]);
			insertFunction("sgm_comercial_oferta_contingut",$camposInsert,$datosInsert);
		}
		if ($ssoption == 5) {
			$camposUpdate=array('ordre','id_comercial_contingut');
			$datosUpdate=array($_POST["ordre"],$_POST["id_contingut"]);
			updateFunction("sgm_comercial_oferta_contingut",$_GET["id_con"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			deleteFunction("sgm_comercial_oferta_contingut",$_GET["id_con"]);
		}
		if ($ssoption == 7) {
			$sqlcov = "select * from sgm_comercial_oferta_valors where visible=1 and id_comercial_oferta=".$_GET["id"]." and id_comercial_camps=".$_GET["id_cam"].")";
			$resultcov = mysql_query(convert_sql($sqlcov));
			$rowcov = mysql_fetch_array($resultcov);
			if ($rowcov){
				$camposUpdate=array('id_comercial_camps_valor');
				$datosUpdate=array($_POST["id_comercial_camps_valor"]);
				updateFunction("sgm_comercial_oferta_valors",$rowcov["id"],$camposUpdate,$datosUpdate);
			} else {
				$camposInsert="id_comercial_oferta,id_comercial_camps,id_comercial_camps_valor";
				$datosInsert=array($_GET["id"],$_GET["id_cam"],$_POST["id_comercial_camps_valor"]);
				insertFunction("sgm_comercial_oferta_valors",$camposInsert,$datosInsert);
			}
		}

		if ($_GET["id"] != "") {
				echo "<strong>".$Editar." ".$Oferta_Comercial." : </strong>";
				echo "<form action=\"index.php?op=1009&sop=100&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
				$sqlc = "select * from sgm_comercial_oferta where visible=1 and id=".$_GET["id"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$numeroo = $rowc["numero"];
				$versiono = $rowc["versio"];
				$date1 = $rowc["data"];
		} else {
				echo "<strong>".$Anadir." ".$Oferta_Comercial." : </strong>";
				echo "<form action=\"index.php?op=1009&sop=0&ssop=1\" method=\"post\">";
				$numeroo = 0;
				$sqln = "select * from sgm_comercial_oferta where visible=1 order by numero desc";
				$resultn = mysql_query(convert_sql($sqln));
				$rown = mysql_fetch_array($resultn);
				$numeroo = ($rown["numero"]+ 1);
				$versiono = 0;
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
		}
		echo "<br><br>";
		echo "<table cellspacing=\"0\"";
			echo "<tr><td><b>".$Datos_Generales."</b></td></tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Numero."/".$Version." ".$Oferta_Comercial.": </td><td colspan=\"2\"><input style=\"width:100px\" type=\"Text\" name=\"numero\" value=\"".$numeroo."\"> / <input style=\"width:50px\" type=\"Text\" name=\"versio\" value=\"".$versiono."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Fecha.": </td><td colspan=\"2\"><input style=\"width:100px\" type=\"datetime\" name=\"data\" value=\"".$date1."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Cliente.": </td>";
				echo "<td style=\"width:200px;\" colspan=\"2\"><select style=\"width:550px\" name=\"id_client\">";
					$sqla = "select * from sgm_clients where visible=1 order by nombre";
					$resulta = mysql_query(convert_sql($sqla));
					while ($rowa = mysql_fetch_array($resulta)) {
						if ($rowa["id"] == $rowc["id_client"]){
							echo "<option value=\"".$rowa["id"]."\" selected>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Cliente." ".$Final.": </td>";
				echo "<td colspan=\"2\"><select style=\"width:550px\" name=\"id_client_final\">";
					$sqlb = "select * from sgm_clients where visible=1 order by nombre";
					$resultb = mysql_query(convert_sql($sqlb));
					while ($rowb = mysql_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_client_final"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Descripcion.": </td><td colspan=\"2\"><input style=\"width:550px\" type=\"Text\" name=\"descripcio\" value=\"".$rowc["descripcio"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Numero." Hosts: </td><td colspan=\"2\"><input style=\"width:100px\" type=\"Text\" name=\"num_host\" value=\"".$rowc["num_host"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:200px;\" colspan=\"2\">".$Idioma.": </td>";
				echo "<td colspan=\"2\"><select style=\"width:50px\" name=\"id_idioma\">";
					$sqlb = "select * from sgm_idiomas where visible=1 order by predefinido desc,idioma";
					$resultb = mysql_query(convert_sql($sqlb));
					while ($rowb = mysql_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_client_final"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["idioma"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["idioma"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				if ($_GET["id"] != "") {
					if ($rowc["renovado"] == 0) {
						echo "<td colspan=\"2\"></td><td colspan=\"2\"><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
					} else {
						echo "<td></td><td></td>";
					}
				} else {
					echo "<td colspan=\"2\"></td><td colspan=\"2\"><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				}
			echo "</tr>";
			echo "</form>";
#			echo "<td colspan=\"2\"></td>";
#			if ($_GET["id"] != "") {
#				if ($rowc["renovado"] == 0) {
#					echo "<form action=\"index.php?op=1009&sop=100&ssop=7&id=".$_GET["id"]."\" method=\"post\">";
#					echo "<td colspan=\"2\"><input type=\"Submit\" value=\"renovar".$Renovar."\" style=\"width:100px\"></td>";
#					echo "</form>";
#				} else {
#					echo "<td></td>";
#				}
#			}
		if ($_GET["id"]!= "") {
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td><b>".$Contenidos."</b></td></tr>";
			echo "<tr style=\"background-color:silver\">";
				echo "<td></td>";
				echo "<td style=\"text-align:right;\">".$Orden."</td>";
				echo "<td>".$Contenido."</td>";
				echo "<td></td>";
			echo "</tr>";
			if ($rowc["renovado"] == 0) {
				echo "<tr>";
					echo "<td></td>";
					echo "<form action=\"index.php?op=1009&sop=100&ssop=4&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:right;\"><input type=\"Text\" name=\"ordre\" value=\"0\" style=\"width:50px\"></td>";
					echo "<td><select style=\"width:450px\" name=\"id_contingut\">";
						echo "<option value=\"0\">-</option>";
						$sqlg = "select * from sgm_comercial_contingut where visible=1 and id_idioma=".$rowc["id_idioma"];
						$resultg = mysql_query(convert_sql($sqlg));
						$rowg = mysql_fetch_array($resultg);
						echo "<option value=\"".$rowg["id"]."\">".$rowg["titol"]."</option>";
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
			$sqlco = "select * from sgm_comercial_oferta_contingut where id_comercial_oferta=".$_GET["id"]." order by ordre";
			$resultco = mysql_query(convert_sql($sqlco));
			while ($rowco = mysql_fetch_array($resultco)) {
				echo "<form action=\"index.php?op=1009&sop=100&ssop=5&id=".$_GET["id"]."&id_con=".$rowco["id"]."\" method=\"post\">";
				echo "<tr>";
					if ($rowc["renovado"] == 0) {
						echo "<td style=\"text-align:right;width:150px;\"><a href=\"index.php?op=1009&sop=101&id=".$_GET["id"]."&id_con=".$rowco["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					} else { echo "<td></td>"; }
					echo "<td style=\"text-align:right;width:50px;\"><input type=\"Text\" name=\"ordre\" value=\"".$rowco["ordre"]."\" style=\"width:50px\"></td>";
					echo "<td><select style=\"width:450px\" name=\"id_contingut\">";
						$sqls = "select * from sgm_comercial_contingut where visible=1";
						$results = mysql_query(convert_sql($sqls));
						while ($rows = mysql_fetch_array($results)){
							if ($rows["id"] == $rowco["id_comercial_contingut"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rows["titol"]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rows["titol"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</tr>";
				echo "</form>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td><b>".$Datos_Adicionales."</b></td></tr>";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:right;\" colspan=\"2\">".$Campos."</td>";
				echo "<td>".$Valores."</td>";
				echo "<td></td>";
			echo "</tr>";
#			if ($rowc["renovado"] == 0) {
				$sqlg = "select * from sgm_comercial_oferta_camps where id_idioma=".$rowc["id_idioma"];
				$resultg = mysql_query(convert_sql($sqlg));
				while ($rowg = mysql_fetch_array($resultg)){
					$sqloc = "select * from sgm_comercial_oferta_valors where id_comercial_camps=".$rowg["id"]." and id_comercial_oferta=".$rowc["id"];
					$resultoc = mysql_query(convert_sql($sqloc));
					$rowoc = mysql_fetch_array($resultoc);
					echo "<form action=\"index.php?op=1009&sop=100&ssop=7&id=".$_GET["id"]."&id_cam=".$rowg["id"]."\" method=\"post\">";
					echo "<tr>";
						if ($rowg["obligatori"] == 1) { $camp = "* ".$rowg["camp"]; } else { $camp = $rowg["camp"];  }
						echo "<td style=\"text-align:right;\" colspan=\"2\">".$camp." : </td>";
						echo "<td><select style=\"width:450px\" name=\"id_comercial_camps_valor\">";
							echo "<option value=\"0\" selected>-</option>";
							$sqls = "select * from sgm_comercial_oferta_camps_valors where visible=1 and id_comercial_oferta_camps=".$rowg["id"];
							$results = mysql_query(convert_sql($sqls));
							while ($rows = mysql_fetch_array($results)){
								if ($rows["id"] == $rowoc["id_comercial_camps_valor"]){
									echo "<option value=\"".$rows["id"]."\" selected>".$rows["valor_camp"]."</option>";
								} else {
									echo "<option value=\"".$rows["id"]."\">".$rows["valor_camp"]."</option>";
								}
							}
						echo "</select></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
					echo "</tr>";
					echo "</form>";
				}
#			}
		}
		echo "</table>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1009&sop=100&ssop=6&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."\">[ SI ]</a><a href=\"index.php?op=1009&sop=100&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 102) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1009&sop=100&ssop=9&id=".$_GET["id"]."&id_com_art=".$_GET["id_com_art"]."\">[ SI ]</a><a href=\"index.php?op=1009&sop=100&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}


	if ($soption == 300) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td><strong>".$Administrar." :</strong></td>";
				echo "<td class=\"menu\">";
					echo "<a href=\"index.php?op=1009&sop=310\" style=\"color:white;\">".$Articulos." ".$Oferta_Comercial."</a>";
				echo "</td>";
				echo "<td class=\"menu\">";
					echo "<a href=\"index.php?op=1009&sop=320\" style=\"color:white;\">".$Contenidos." ".$Oferta_Comercial."</a>";
				echo "</td>";
				echo "<td class=\"menu\">";
					echo "<a href=\"index.php?op=1009&sop=340\" style=\"color:white;\">".$Campos." ".$Oferta_Comercial."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}

	if ($soption == 310) {
		if ($ssoption == 1) {
			$sqll = "select count(*) as total from sgm_comercial_articles_grups where id_grup=".$_POST["id_grup"];
			$resultl = mysql_query(convert_sql($sqll));
			$rowl = mysql_fetch_array($resultl);
			if ($rowl["total"] == 0) {
				$camposInsert="id_grup";
				$datosInsert=array($_POST["id_grup"]);
				insertFunction("sgm_comercial_articles_grups",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_comercial_articles_grups where id=".$_GET["id"];
			mysql_query(convert_sql($sql));
#			echo $sql;
		}

		echo "<strong>".$Familias." ".$Articulos." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1009&sop=300\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">".$Familia."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=310&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select style=\"width:150px\" name=\"id_grup\">";
					$sql = "select * from sgm_articles_grupos order by grupo";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["grupo"]."</option>";
					}
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqll = "select * from sgm_comercial_articles_grups";
			$resultl = mysql_query(convert_sql($sqll));
			while ($rowl = mysql_fetch_array($resultl)) {
				$sqla = "select * from sgm_articles_grupos where id=".$rowl["id_grup"];
				$resulta = mysql_query(convert_sql($sqla));
				$rowa = mysql_fetch_array($resulta);
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=311&id=".$rowl["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td>".$rowa["grupo"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 311) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta familia?";
		echo "<br><br><a href=\"index.php?op=1009&sop=310&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1009&sop=310\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 320) {
		if ($ssoption == 1) {
			$camposInsert="id_comercial_contingut,titol,id_idioma,obligatori,id_servicio";
			$datosInsert=array($_POST["id_comercial_contingut"],comillas($_POST["titol"]),$_POST["id_idioma"],$_POST["obligatori"],$_POST["id_servicio"]);
			insertFunction("sgm_comercial_contingut",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('id_comercial_contingut','titol','id_idioma','obligatori','id_servicio');
			$datosUpdate=array($_POST["id_comercial_contingut"],comillas($_POST["titol"]),$_POST["id_idioma"],$_POST["obligatori"],$_POST["id_servicio"]);
			updateFunction("sgm_comercial_contingut",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_comercial_contingut",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<strong>".$Contenidos." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1009&sop=300\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Origen."</td>";
				echo "<td style=\"text-align:center;\">".$Titulo."</td>";
				echo "<td style=\"text-align:center;\">".$Idioma."</td>";
				echo "<td style=\"text-align:center;\">".$Obligatorio."</td>";
				echo "<td style=\"text-align:center;\">".$Servicio."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=320&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select style=\"width:300px\" name=\"id_comercial_contingut\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_comercial_contingut where visible=1 order by titol";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["titol"]."</option>";
					}
				echo "</td>";
				echo "<td><input type=\"text\" style=\"width:300px\" name=\"titol\"></td>";
				echo "<td><select style=\"width:50px\" name=\"id_idioma\">";
					$sql = "select * from sgm_idiomas where visible=1 order by idioma";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["idioma"]."</option>";
					}
				echo "</td>";
				echo "<td><select style=\"width:50px\" name=\"obligatori\">";
					echo "<option value=\"0\">No</option>";
					echo "<option value=\"1\">Si</option>";
				echo "</td>";
				echo "<td><select style=\"width:300px\" name=\"id_servicio\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_contratos_servicio where visible=1 and id<0 order by servicio";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["servicio"]."</option>";
					}
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlci = "select * from sgm_comercial_contingut where visible=1";
			$resultci = mysql_query(convert_sql($sqlci));
			while ($rowci = mysql_fetch_array($resultci)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=321&id=".$rowci["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1009&sop=320&ssop=2&id=".$rowci["id"]."\" method=\"post\">";
					echo "<td><select style=\"width:300px\" name=\"id_comercial_contingut\">";
						echo "<option value=\"0\" selected>-</option>";
						$sql = "select * from sgm_comercial_contingut where visible=1 and id<>".$rowci["id"]." order by titol";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($row["id"] == $rowci["id_comercial_contingut"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["titol"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["titol"]."</option>";
							}
						}
					echo "</td>";
					echo "<td><input type=\"text\" style=\"width:300px\" name=\"titol\" value=\"".$rowci["titol"]."\"></td>";
					echo "<td><select style=\"width:50px\" name=\"id_idioma\">";
						$sql = "select * from sgm_idiomas where visible=1 order by idioma";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($row["id"] == $rowci["id_idioma"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["idioma"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["idioma"]."</option>";
							}
						}
					echo "</td>";
					echo "<td><select style=\"width:50px\" name=\"obligatori\">";
						if ($rowci["obligatori"] == 0){
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						} elseif ($rowci["obligatori"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</td>";
					echo "<td><select style=\"width:300px\" name=\"id_servicio\">";
						echo "<option value=\"0\" selected>-</option>";
						$sql = "select * from sgm_contratos_servicio where visible=1 and id<0 order by servicio";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($row["id"] == $rowci["id_servicio"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["servicio"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["servicio"]."</option>";
							}
						}
					echo "</td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=330&id=".$rowci["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 321) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1009&sop=320&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1009&sop=320\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 330) {
		if ($ssoption == 1) {
			$camposUpdate=array('contingut','contingut_estes');
			$datosUpdate=array(comillas($_POST["contingut"]),comillas($_POST["contingut_estes"]));
			updateFunction("sgm_comercial_contingut",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<strong>".$Text_Contenidos." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1009&sop=320\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			$sql = "select * from sgm_comercial_contingut where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1009&sop=330&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\">".$Contenido." : </td><td><textarea name=\"contingut\" style=\"width:900px\" rows=\"20\">".$row["contingut"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\">".$Contenido_Estendido." : </td><td><textarea name=\"contingut_estes\" style=\"width:900px\" rows=\"20\">".$row["contingut_estes"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td></td><td><input type=\"Submit\" value=\"".$Editar."\" style=\"width:80px\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 340) {
		if ($ssoption == 1) {
			$camposInsert="id_article,camp,id_idioma,obligatori";
			$datosInsert=array($_POST["id_article"],comillas($_POST["camp"]),$_GET["lag"],$_POST["obligatori"]);
			insertFunction("sgm_comercial_oferta_camps",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('id_article','camp');
			$datosUpdate=array($_POST["id_article"],comillas($_POST["camp"]));
			updateFunction("sgm_comercial_oferta_camps",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_comercial_oferta_camps",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<strong>".$Campos." : </strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1009&sop=300\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"10\">";
		$sql = "select * from sgm_idiomas where visible=1 order by id";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			if (($_GET["lag"] == $row["id"]) or (($row["predefinido"] == 1) and $_GET["lag"] == 0)){
				$color = "white"; $color_l = "black";
			} else {
				$color = "#4B53AF"; $color_l = "white";
			}
			if ($row["predefinido"] == 1){$lag = $row["id"];} 
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black\">";
				echo "<a href=\"index.php?op=1009&sop=340&lag=".$row["id"]."\" style=\"color:".$color_l.";\">".$row["idioma"]."</a>";
			echo "</td>";
		}
		if ($_GET["lag"] > 0) { $lag = $_GET["lag"];}
		echo "</table>";
		echo "<table cellspacing=\"0\">";
		echo "<br><br>";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Campo."</td>";
				echo "<td style=\"text-align:center;\">".$Articulo."</td>";
				echo "<td style=\"text-align:center;\">".$Obligatorio."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=340&lag=".$lag."&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:300px\" name=\"camp\"></td>";
				echo "<td><select style=\"width:300px\" name=\"id_article\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_articles where visible=1 and id_subgrupo in (select id_grup from sgm_comercial_articles_grups) order by nombre";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
					}
				echo "</td>";
				echo "<td><select style=\"width:50px\" name=\"obligatori\">";
					echo "<option value=\"0\">No</option>";
					echo "<option value=\"1\">Si</option>";
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlci = "select * from sgm_comercial_oferta_camps where visible=1 and id_idioma=".$lag;
			$resultci = mysql_query(convert_sql($sqlci));
			while ($rowci = mysql_fetch_array($resultci)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=341&lag=".$lag."&id=".$rowci["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1009&sop=340&lag=".$lag."&ssop=2&id=".$rowci["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" style=\"width:300px\" name=\"camp\" value=\"".$rowci["camp"]."\"></td>";
					echo "<td><select style=\"width:300px\" name=\"id_article\">";
						echo "<option value=\"0\" selected>-</option>";
						$sql = "select * from sgm_articles where visible=1 and id_subgrupo in (select id_grup from sgm_comercial_articles_grups) order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($row["id"] == $rowci["id_article"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
							}
						}
					echo "</td>";
					echo "<td><select style=\"width:50px\" name=\"obligatori\">";
						if ($rowci["obligatori"] == 0){
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						} elseif ($rowci["obligatori"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=350&lag=".$lag."&id=".$rowci["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 341) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1009&sop=340&lag=".$_GET["lag"]."&ssop=3&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."\">[ SI ]</a><a href=\"index.php?op=1009&sop=340&lag=".$_GET["lag"]."&id_val=".$_GET["id_val"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 350) {
		if ($ssoption == 1) {
			$camposInsert="id_comercial_oferta_camps,valor_camp,id_idioma";
			$datosInsert=array($_GET["id"],comillas($_POST["valor_camp"]),$_GET["lag"]);
			insertFunction("sgm_comercial_oferta_camps_valors",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('valor_camp');
			$datosUpdate=array(comillas($_POST["valor_camp"]));
			updateFunction("sgm_comercial_oferta_camps_valors",$_GET["id_val"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_comercial_oferta_camps_valors",$_GET["id_val"],$camposUpdate,$datosUpdate);
		}

		$sqlci = "select * from sgm_comercial_oferta_camps where visible=1 and id=".$_GET["id"];
		$resultci = mysql_query(convert_sql($sqlci));
		$rowci = mysql_fetch_array($resultci);
		echo "<strong>".$Valor." ".$Campos." : </strong>".$rowci["camp"];
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1009&sop=340&lag=".$_GET["lag"]."&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Valor."</td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=350&lag=".$_GET["lag"]."&id=".$rowci["id"]."&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:300px\" name=\"valor_camp\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlci2 = "select * from sgm_comercial_oferta_camps_valors where visible=1 and id_idioma=".$_GET["lag"]." and id_comercial_oferta_camps=".$_GET["id"];
			$resultci2 = mysql_query(convert_sql($sqlci2));
			while ($rowci2 = mysql_fetch_array($resultci2)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=351&lag=".$_GET["lag"]."&id=".$rowci["id"]."&id_val=".$rowci2["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1009&sop=350&lag=".$_GET["lag"]."&ssop=2&id=".$rowci["id"]."&id_val=".$rowci2["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" style=\"width:300px\" name=\"valor_camp\" value=\"".$rowci2["valor_camp"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 351) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1009&sop=350&ssop=3&lag=".$_GET["lag"]."&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."\">[ SI ]</a><a href=\"index.php?op=1009&sop=350&lag=".$_GET["lag"]."&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."\">[ NO ]</a>";
		echo "</center>";
	}


	echo "</td></tr></table><br>";
	}
?>
