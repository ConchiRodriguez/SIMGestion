<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) { echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1026) AND ($autorizado == true)) {

	echo "<table class=\"principal\"><tr>";
		echo "<tr><td>";
			echo "<center><table><tr>";
				echo "<td><strong>".$Licencias." :</strong></td>";
				if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1026&sop=0\" class=".$class.">".$Ver." ".$Licencias."</a></td>";
				if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1026&sop=100\" class=".$class.">".$Anadir." ".$Licencia."</a></td>";
				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1026&sop=200\" class=".$class.">".$Buscar." ".$Licencia."</a></td>";
				if (($soption >= 300) and ($soption < 400)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1026&sop=300\" class=".$class.">".$Administrar."</a></td>";
			echo "</tr></table>";
		echo "</center></td></tr>";
	echo "</table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 3) {
			$sql = "update sgm_Licencias set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
			$sqlla = "select * from sgm_Licencias_articles where visible=1 and id_licencia=".$_GET["id"];
			$resultla = mysql_query(convertSQL($sqlla));
			while ($rowla = mysql_fetch_array($resultla)){
				$sql = "delete from `sgm_Licencias` where id=".$rowla["id"]."";
			}
			$sqlf = "select * from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"];
			$resultf = mysql_query(convertSQL($sqlf));
			while ($rowf = mysql_fetch_array($resultf)){
				deleteCabezera($rowf["id"]);
				$sql = "select * from sgm_cuerpo where idfactura=".$rowf["id"]."";
				$result = mysql_query(convertSQL($sql));
				$row = mysql_fetch_array($result);
				deleteCuerpo($row["id"],$rowf["id"]);
			}
		}
		if ($soption == 0) { echo "<strong>".$Actual."</strong>";}
		if ($soption == 1) { echo "<strong>".$Historico."</strong>";}
		if ($soption == 200) { echo "<strong>".$Buscador."</strong>";}
		echo "<br><br>";
		if ($soption != 200){
			echo "<table><tr>";
				echo "<td class=\"boton\">";
					if ($soption == 1) { echo "<a href=\"index.php?op=1026&sop=0\" style=\"color:white;\">".$Activo."</a>";}
					if ($soption == 0) { echo "<a href=\"index.php?op=1026&sop=1\" style=\"color:white;\">".$Inactivo."</a>";}
				echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
		}
		echo "<center>";
		if ($soption == 200){
			echo "<form action=\"index.php?op=1026&sop=200\" method=\"post\">";
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
						$result = mysql_query(convertSQL($sql));
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
						$result = mysql_query(convertSQL($sql));
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
				echo "<form action=\"index.php?op=1026&sop=100&ssop=1\" method=\"post\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td><em>".$Eliminar."</em></td>";
					echo "<td style=\"text-align:center;\">".$Cliente."</td>";
					echo "<td style=\"text-align:center;\">".$Cliente." ".$Final."</td>";
					echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
					echo "<td><em>".$Editar."</em></td>";
				echo "</tr>";
				$sqlcc = "select * from sgm_Licencias where visible=1 ";
				if ($_POST["id_client2"] > 0) {
					$sqlcc = $sqlcc." and id_client=".$_POST["id_client2"]."";
				}
				if ($_POST["id_client_final2"] > 0) {
					$sqlcc = $sqlcc." and id_client_final=".$_POST["id_client_final2"]."";
				}
				if ($soption == 0){ $sqlcc = $sqlcc." and renovado=0";}
				if ($soption == 1){ $sqlcc = $sqlcc." and renovado=1";}
#				echo $sqlcc."<br>";
				$resultcc = mysql_query(convertSQL($sqlcc));
				while ($rowcc = mysql_fetch_array($resultcc)){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=0&ssop=3&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_client"]."";
						$result = mysql_query(convertSQL($sql));
						$row = mysql_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=201&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_client_final"]."";
						$result = mysql_query(convertSQL($sql));
						$row = mysql_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=201&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						echo "<td><a href=\"index.php?op=1026&sop=100&id=".$rowcc["id"]."\">".$rowcc["descripcion"]."</a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=100&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
					echo "</tr>";
				}
			echo "</table>";
			echo "</center>";
		}
	}

	if ($soption == 10) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este contrato?<br><br>";
		echo "<a href=\"index.php?op=1026&sop=0&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1026&sop=0\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_Licencias (id_client,id_client_final,fecha_ini,fecha_fin,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql.$_POST["id_client"];
			$sql = $sql.",".$_POST["id_client_final"];
			$sql = $sql.",'".strtotime($_POST["fecha_ini"])."'";
			$sql = $sql.",'".strtotime($_POST["fecha_fin"])."'";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
			$sqlc = "select * from sgm_Licencias where visible=1 order by id desc";
			$resultc = mysql_query(convertSQL($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$id_lic = $rowc["id"];
		}
		if ($ssoption == 2) {
			$sqlc = "select * from sgm_Licencias where visible=1 and id=".$_GET["id"];
			$resultc = mysql_query(convertSQL($sqlc));
			$rowc = mysql_fetch_array($resultc);
			if ($rowc["id_client"] != $_POST["id_client"]){
				$sqlca = "select * from sgm_cabezera where visible=1 and id_licencia=".$_GET["id"];
				$resultca = mysql_query(convertSQL($sqlca));
				while ($rowca = mysql_fetch_array($resultca)) {
					updateCabezera($rowca["id"],0,0,0,0,0,0,$rowca["fecha"],$rowca["fecha_prevision"],0,0,$_POST["id_client"],0,$_GET["id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
				}
			}

			$sql = "update sgm_Licencias set ";
			$sql = $sql."id_client='".$_POST["id_client"]."'";
			$sql = $sql.",id_client_final='".$_POST["id_client_final"]."'";
			$sql = $sql.",fecha_ini='".strtotime($_POST["fecha_ini"])."'";
			$sql = $sql.",fecha_fin='".strtotime($_POST["fecha_fin"])."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
#			echo $sql;
		}
		if ($ssoption == 4) {
			$sql = "insert into sgm_Licencias_articles (id_licencia,id_article) ";
			$sql = $sql."values (";
			$sql = $sql.$_GET["id"];
			$sql = $sql.",".$_POST["id_article"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_Licencias_articles set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_lic_art"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 7) {
			$sqlcc = "select * from sgm_Licencias where visible=1 and id=".$_GET["id"]."";
			$resultcc = mysql_query(convertSQL($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			$fecha_inici = $rowcc["fecha_fin"]+86400;
			$fecha_fin = $fecha_inici+31536000;
			if ($rowcc){
				$sql = "insert into sgm_Licencias (id_client,id_client_final,fecha_ini,fecha_fin,descripcion) ";
				$sql = $sql."values (";
				$sql = $sql.$rowcc["id_client"];
				$sql = $sql.",".$rowcc["id_client_final"];
				$sql = $sql.",'".$fecha_inici."'";
				$sql = $sql.",'".$fecha_fin."'";
				$sql = $sql.",'".$rowcc["descripcion"]."'";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));

				$sql = "update sgm_Licencias set ";
				$sql = $sql."renovado=1";
				$sql = $sql." WHERE id=".$_GET["id"]."";
				mysql_query(convertSQL($sql));

				$sqlcc2 = "select * from sgm_Licencias where visible=1 and renovado=0 and id_client_final=".$rowcc["id_client_final"]." and descripcion='".$rowcc["descripcion"]."' order by id desc";
				$resultcc2 = mysql_query(convertSQL($sqlcc2));
				$rowcc2 = mysql_fetch_array($resultcc2);

				$sqlcs = "select * from sgm_Licencias_articles where visible=1 and id_licencia=".$rowcc["id"];
				$resultcs = mysql_query(convertSQL($sqlcs));
				while ($rowcs = mysql_fetch_array($resultcs)) {
					$sql = "insert into sgm_Licencias_articles (id_licencia,id_article) ";
					$sql = $sql."values (";
					$sql = $sql.$rowcc2["id"];
					$sql = $sql.",".$rowcs["id_article"];
					$sql = $sql.")";
					mysql_query(convertSQL($sql));
#					echo $sql."<br>";
				}
				$sqlca = "select * from sgm_cabezera where visible=1 and id_licencia=".$_GET["id"];
				$resultca = mysql_query(convertSQL($sqlca));
				while ($rowca = mysql_fetch_array($resultca)) {
					insertCabezera(0,7,0,0,0,0,$rowca["fecha"],$rowca["fecha_prevision"],$rowca["id_cliente"],0,$rowcc2["id"]);

					$sqlcax = "select * from sgm_cabezera where visible=1 and fecha='".$rowca["fecha"]."' and fecha_prevision='".$rowca["fecha_prevision"]."' and id_cliente=".$rowca["id_cliente"]." and id_licencia=".$rowcc2["id"];
					$resultcax = mysql_query(convertSQL($sqlcax));
					$rowcax = mysql_fetch_array($resultcax);

					$sqlcu = "select * from sgm_cuerpo where idfactura=".$rowca["id"];
					$resultcu = mysql_query(convertSQL($sqlcu));
					while ($rowcu = mysql_fetch_array($resultcu)) {
						insertCuerpo($rowcax["id"],1,0,$rowcu["nombre"],0,$rowcu["pvp"],1,$rowcu["fecha_prevision"],0,0,$rowcu["fecha_prevision"]);
					}
				}
			}
		}
		if ($ssoption == 10) {
			insertCabezera(0,7,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],$_POST["id_client"],0,$_POST["id_licencia"]);
			$sql = "select * from sgm_cabezera where visible=1 and id_licencia=".$_GET["id"]." order by id desc";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			insertCuerpo($row["id"],1,0,$_POST["concepto"],0,$_POST["importe"],1,$_POST["fecha_prevision"],0,0,$_POST["fecha_prevision"]);
		}
		if ($ssoption == 11) {
			updateCabezera($_GET["id_fact"],0,0,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],0,0,$_POST["id_client"],0,$_POST["id_licencia"],0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			updateCuerpo($row["id"],$_GET["id_fact"],$row["linea"],$row["codigo"],$_POST["concepto"],$row["pvd"],$_POST["importe"],1,$_POST["fecha_prevision"],$row["id_article"],$row["stock"],$_POST["fecha_prevision"],$row["descuento"],$row["descuento_absoluto"]);
		}
		if ($ssoption == 12) {
			deleteCabezera($_GET["id_fact"]);
			$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			deleteCuerpo($row["id"],$_GET["id_fact"]);
		}

		if ($_GET["id"] > 0) {$id_lic = $_GET["id"];}

		if ($id_lic != "") { echo "<strong>".$Editar." ".$Licencia." : </strong>";} else { echo "<strong>".$Anadir." ".$Licencia." : </strong>";}
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			if ($id_lic != "") {
				echo "<form action=\"index.php?op=1026&sop=100&ssop=2&id=".$id_lic."\" method=\"post\">";
				$sqlc = "select * from sgm_Licencias where visible=1 and id=".$id_lic;
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
			} else {
				echo "<form action=\"index.php?op=1026&sop=100&ssop=1\" method=\"post\">";
			}
			echo "<tr><td style=\"text-align:right;\">".$Cliente.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_client\">";
					$sqla = "select * from sgm_clients where visible=1 order by nombre";
					$resulta = mysql_query(convertSQL($sqla));
					while ($rowa = mysql_fetch_array($resulta)) {
						if ($rowa["id"] == $rowc["id_client"]){
							echo "<option value=\"".$rowa["id"]."\" selected>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente." ".$Final.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_client_final\">";
					$sqlb = "select * from sgm_clients where visible=1 order by nombre";
					$resultb = mysql_query(convertSQL($sqlb));
					while ($rowb = mysql_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_client_final"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Descripcion.": </td><td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\" value=\"".$rowc["descripcion"]."\"></td></tr>";
			if ($id_lic != "") {
				$date1 = date("Y-m-d",$rowc["fecha_ini"]);
				$date2 = date("Y-m-d",$rowc["fecha_fin"]);
			} else {
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				$date2 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			}
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Inicio.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_ini\" value=\"".$date1."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Fin.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_fin\" value=\"".$date2."\"></td></tr>";
				if ($id_lic != "") {
					if ($rowc["renovado"] == 0) {
						echo "<td></td><td><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
					} else {
						echo "<td></td><td></td>";
					}
				} else {
					echo "<td></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				}
			echo "</form>";
			echo "<td></td>";
			if ($id_lic != "") {
				if ($rowc["renovado"] == 0) {
					echo "<form action=\"index.php?op=1026&sop=100&ssop=7&id=".$id_lic."\" method=\"post\">";
					echo "<td><input type=\"Submit\" value=\"renovar".$Renovar."\" style=\"width:100px\"></td>";
					echo "</form>";
				} else {
					echo "<td></td>";
				}
			}
		echo "</table>";
		echo "</center>";
		echo "<br><br>";

		if ($id_lic != "") {

			echo "<center><table cellspacing=\"0\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td></td>";
					echo "<td>".$Articulos."</td>";
					echo "<td></td>";
				echo "</tr>";
				if ($rowc["renovado"] == 0) {
					echo "<tr>";
						echo "<td></td>";
						echo "<form action=\"index.php?op=1026&sop=100&ssop=4&id=".$id_lic."\" method=\"post\">";
						echo "<td><select style=\"width:400px\" name=\"id_article\">";
							echo "<option value=\"0\">-</option>";
							$sql = "select * from sgm_articles where visible=1 and id_subgrupo in (select id from sgm_articles_subgrupos where id_grupo in (select id from sgm_articles_grupos where id in (select id_familia from sgm_Licencias_families_articles)))";
							$result = mysql_query(convertSQL($sql));
							while ($row = mysql_fetch_array($result)) {
								$sqlg = "select * from sgm_articles_subgrupos where id=".$row["id_subgrupo"];
								$resultg = mysql_query(convertSQL($sqlg));
								$rowg = mysql_fetch_array($resultg);
								echo "<option value=\"".$row["id"]."\">".$rowg["subgrupo"]."(".$row["codigo"].") - ".$row["nombre"]."</option>";
							}
						echo "</td>";
						echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
					echo "</form>";
					echo "</tr>";
					echo "<tr><td>&nbsp;</td></tr>";
				}
				$sql = "select * from sgm_Licencias_articles where visible=1 and id_licencia=".$id_lic."";
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						if ($rowc["renovado"] == 0) {
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=101&id=".$id_lic."&id_lic_art=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						} else { echo "<td></td>"; }
						$sqls = "select * from sgm_articles where id=".$row["id_article"];
						$results = mysql_query(convertSQL($sqls));
						$rows = mysql_fetch_array($results);
						echo "<td style=\"text-align:left;width:500px\">".$rows["nombre"]."</td>";
						echo "<td></td>";
					echo "</tr>";
				}
			echo "</table></center>";
			echo "<br><br>";

			echo "<br><br>";
			echo "<center><table cellspacing=\"0\">";
				echo "<tr><td colspan=\"7\" style=\"text-align:center;\"><strong>".$Factura."</strong></td></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<td></td>";
					echo "<td style=\"text-align:center;\">".$Fecha."</td>";
					echo "<td style=\"text-align:center;\">".$Fecha." ".$Prevision."</td>";
					echo "<td style=\"text-align:center;\">".$Concepto."</td>";
					echo "<td style=\"text-align:center;\">".$Importe."</td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
				if ($rowc["renovado"] == 0) {
					echo "<tr>";
					echo "<form action=\"index.php?op=1026&sop=100&ssop=10&id=".$id_lic."\" method=\"post\">";
						echo "<td></td>";
						echo "<input type=\"hidden\" name=\"id_client\" value=\"".$rowc["id_client"]."\">";
						echo "<input type=\"hidden\" name=\"id_licencia\" value=\"".$id_lic."\">";
						$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$date."\"></td>";
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$date."\"></td>";
						echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\"></td>";
					$precio_lic = 0;
					$sql = "select * from sgm_Licencias_articles where visible=1 and id_licencia=".$id_lic."";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)) {
							$sqls = "select precio from sgm_articles where id=".$row["id_article"];
							$results = mysql_query(convertSQL($sqls));
							$rows = mysql_fetch_array($results);
							$precio_lic += $rows["precio"];
					}
						echo "<td><input style=\"text-align:right;width:70px\" type=\"Text\" name=\"importe\" value=\"".$precio_lic."\"></td>";
						echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
					echo "</form>";
					echo "</tr>";
					echo "<tr><td>&nbsp;</td></tr>";
				}
				$sql = "select * from sgm_cabezera where visible=1 and id_licencia=".$id_lic."";
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					$sqlcu = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
					$resultcu = mysql_query(convertSQL($sqlcu));
					$rowcu = mysql_fetch_array($resultcu);
					echo "<tr>";
						if ($rowc["renovado"] == 0) {
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=102&id=".$id_lic."&id_fact=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						} else { echo "<td></td>"; }
						echo "<form action=\"index.php?op=1026&sop=100&ssop=11&id=".$id_lic."&id_fact=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"hidden\" name=\"id_client\" value=\"".$rowc["id_client"]."\">";
						echo "<input type=\"hidden\" name=\"id_licencia\" value=\"".$id_lic."\">";
						echo "<td>";
						echo "<input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$row["fecha"]."\"></td>";
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\"></td>";
						echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\" value=\"".$rowcu["nombre"]."\"></td>";
						echo "<td><input style=\"text-align:right;width:70px\" type=\"Text\" name=\"importe\" value=\"".$rowcu["pvp"]."\"></td>";
						if ($rowc["renovado"] == 0) {
							echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
						}
						echo "</form>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1003&sop=22&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"ver\" border=\"0\"></a></td>";
					echo "</tr>";
				}
			echo "</table></center>";
		}
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta licencia?";
		echo "<br><br><a href=\"index.php?op=1026&sop=100&ssop=5&id=".$_GET["id"]."&id_lic_art=".$_GET["id_lic_art"]."\">[ SI ]</a><a href=\"index.php?op=1026&sop=100&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 102) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta factura?";
		echo "<br><br><a href=\"index.php?op=1026&sop=100&ssop=12&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"]."\">[ SI ]</a><a href=\"index.php?op=1026&sop=100&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 110) {
		if ($ssoption == 1) {
			$sql = "update sgm_contratos set ";
			$sql = $sql."nombre_firmante='".comillas($_POST["nombre_firmante"])."'";
			$sql = $sql.",carrec_firmante='".comillas($_POST["carrec_firmante"])."'";
			$sql = $sql.",nif_firmante='".comillas($_POST["nif_firmante"])."'";
			$sql = $sql.",fecha_firma='".comillas($_POST["fecha_firma"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo boton_volver($Volver);
		echo "<strong>".$Editar." ".$Contrato." : </strong>";
		echo "<br><br>";
		echo "<centre><table><tr><td style=\"vertical-align:top;text-align:right;width:900px;\">";
		echo "<center>";
		echo "<table>";
			echo "<form action=\"index.php?op=1026&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			$sqln = "select * from sgm_contratos where visible=1 and id=".$_GET["id"];
			$resultn = mysql_query(convertSQL($sqln));
			$rown = mysql_fetch_array($resultn);
			echo "<tr><td style=\"text-align:right;width:150px\">".$Numero.": </td><td><input type=\"Text\" name=\"num_contrato\" value=\"".$rown["num_contrato"]."\" class=\"px300\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:150px\">".$Contrato.": </td>";
				$sql = "select * from sgm_contratos_tipos where visible=1 and id=".$rown["id_contrato_tipo"];
				$result = mysql_query(convertSQL($sql));
				$row = mysql_fetch_array($result);
				echo "<td><input style=\"width:300px\" name=\"id_contrato_tipo\" value=\"".$row["nombre"]."\"></td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;width:150px\">".$Nombre." ".$Firmante.": </td><td><input type=\"Text\" name=\"nombre_firmante\" value=\"".$rown["nombre_firmante"]."\" class=\"px300\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:150px\">".$Cargo.": </td><td><input type=\"Text\" name=\"carrec_firmante\" value=\"".$rown["carrec_firmante"]."\" class=\"px300\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:150px\">".$NIF.": </td><td><input type=\"Text\" name=\"nif_firmante\" value=\"".$rown["nif_firmante"]."\" class=\"px300\"></td></tr>";
			echo "<tr><td style=\"text-align:right;width:150px\">".$Fecha.": </td><td><input type=\"Text\" name=\"fecha_firma\" value=\"".$rown["fecha_firma"]."\" class=\"px300\"></td></tr>";
			echo "<tr>";
				echo "<td style=\"text-align:right;width:150px\">".$Cliente.": </td>";
				$sql = "select * from sgm_clients where visible=1 and id=".$rown["id_client"];
				$result = mysql_query(convertSQL($sql));
				$row = mysql_fetch_array($result);
				echo "<td><input style=\"width:300px\" name=\"id_client\" value=\"".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."\"></td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;width:150px\"></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:300px\"></td></tr>";
		echo "</table>";
		echo "</center>";
		echo "</form>";
		echo "</td><td style=\"vertical-align:top;text-align:right;width:100px;\">";
			echo "<table>";
			$sqlc = "select * from sgm_contratos_incidencias_tipo where visible=1";
			$resultc = mysql_query(convertSQL($sqlc));
			while ($rowc = mysql_fetch_array($resultc)){
				echo "<tr>";
					echo "<td style=\"width:100px;height:13px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1026&sop=120&id=".$rowc["id"]."\" style=\"color:white;\">".$rowc["tipo"]."</a>";
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		echo "</td></tr></table>";
	}

	if ($soption == 120) {
		if ($ssoption == 1) {
			$sql = "update sgm_contratos set ";
			$sql = $sql."nombre_firmante='".comillas($_POST["nombre_firmante"])."'";
			$sql = $sql.",carrec_firmante='".comillas($_POST["carrec_firmante"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo boton_volver($Volver);
		echo "<strong>".$Editar." ".$Incidencia." : </strong>";
		echo "<br><br>";
		echo "<center><table>";
			echo "<tr>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 300) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td><strong>Administrar : &nbsp;&nbsp;</strong></td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1026&sop=310\" style=\"color:white;\">".$Articulos."</a>";
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
			$sql = "insert into sgm_Licencias_families_articles (id_familia) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["id_familia"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
#			echo $sql;
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_Licencias_families_articles where id=".$_GET["id"];
#			echo $sql;
		}

		echo "<strong>".$Familias." ".$Articulos." : </strong>";
		echo "<br><br>";
		echo boton_volver($Volver);
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">".$Familia."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1026&sop=310&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select style=\"width:150px\" name=\"id_familia\">";
					$sql = "select * from sgm_articles_grupos order by grupo";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["grupo"]."</option>";
					}
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqll = "select * from sgm_Licencias_families_articles";
			$resultl = mysql_query(convertSQL($sqll));
			while ($rowl = mysql_fetch_array($resultl)) {
				$sqla = "select * from sgm_articles_grupos where id=".$rowl["id_familia"];
				$resulta = mysql_query(convertSQL($sqla));
				$rowa = mysql_fetch_array($resulta);
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=311&id=".$rowl["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input type=\"text\" value=\"".$rowa["grupo"]."\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 311) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta familia?";
		echo "<br><br><a href=\"index.php?op=1026&sop=310&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1026&sop=310\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 320) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_contratos_incidencias (id_contrato_tipo,nombre,descripcion,dias,id_tipo) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_GET["id_contrato_tipo"]."'";
			$sql = $sql.",'".comillas($_POST["nombre"])."'";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.",".$_POST["dias"];
			$sql = $sql.",".$_POST["id_tipo"];
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_contratos_incidencias set ";
			$sql = $sql."id_contrato_tipo='".$_GET["id_contrato_tipo"]."'";
			$sql = $sql.",nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql.",dias=".$_POST["dias"];
			$sql = $sql.",id_tipo=".$_POST["id_tipo"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_contratos_incidencias set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Incidencias." ".$Contratos." : </strong>";
		echo "<br><br>";
		echo boton_volver($Volver);
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Tipo."</td>";
				echo "<td style=\"text-align:center;\">".$Nombre."</td>";
				echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
				echo "<td style=\"text-align:center;\">".$Dias."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1026&sop=320&ssop=1&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select style=\"width:100px\" name=\"id_tipo\">";
					$sql = "select * from sgm_contratos_incidencias_tipo where visible=1 order by tipo";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
					}
				echo "</td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"text\" style=\"width:50px\" name=\"dias\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlci = "select * from sgm_contratos_incidencias where visible=1 and id_contrato_tipo=".$_GET["id_contrato_tipo"];
			$resultci = mysql_query(convertSQL($sqlci));
			while ($rowci = mysql_fetch_array($resultci)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=321&id=".$rowci["id"]."&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1026&sop=320&ssop=2&id=".$rowci["id"]."&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\" method=\"post\">";
					echo "<td><select style=\"width:100px\" name=\"id_tipo\">";
						$sql = "select * from sgm_contratos_incidencias_tipo where visible=1 order by tipo";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($row["id"] == $rowci["id_tipo"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["tipo"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
							}
						}
					echo "</td>";
					echo "<td><input type=\"text\" value=\"".$rowci["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$rowci["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"text\" value=\"".$rowci["dias"]."\" style=\"width:50px;text-align:right;\" name=\"dias\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 321) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta incidencia del contrato?";
		echo "<br><br><a href=\"index.php?op=1026&sop=320&ssop=3&id=".$_GET["id"]."&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\">[ SI ]</a><a href=\"index.php?op=1026&sop=320&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\">[ NO ]</a>";
		echo "</center>";
	}


	if ($soption == 400) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_contratos_incidencias_tipo (tipo,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["tipo"])."'";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
			echo $sql;
		}
		if ($ssoption == 2) {
			$sql = "update sgm_contratos_incidencias_tipo set ";
			$sql = $sql."tipo='".comillas($_POST["tipo"])."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
			echo $sql;
		}
		if ($ssoption == 3) {
			$sql = "update sgm_contratos_incidencias_tipo set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Contratos." : </strong>";
		echo "<br><br>";
		echo boton_volver($Volver);
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Tipo."</td>";
				echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1026&sop=400&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"tipo\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_incidencias_tipo where visible=1 order by tipo";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=401&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1026&sop=400&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["tipo"]."\" style=\"width:150px\" name=\"tipo\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 401) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este contrato?";
		echo "<br><br><a href=\"index.php?op=1026&sop=400&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1026&sop=400\">[ NO ]</a>";
		echo "</center>";
	}

		if ($soption == 500) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_contratos_sla_cobertura (nombre,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["nombre"])."'";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_contratos_sla_cobertura set ";
			$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_contratos_sla_cobertura set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}

		echo "<strong>".$Cobertura." ".$SLA." de los ".$Contratos." : </strong>";
		echo "<br><br>";
		echo boton_volver($Volver);
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">".$Nombre."</td>";
				echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1026&sop=500&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_sla_cobertura where visible=1 order by nombre";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=501&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1026&sop=500&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 501) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este contrato?";
		echo "<br><br><a href=\"index.php?op=1026&sop=500&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1026&sop=500\">[ NO ]</a>";
		echo "</center>";
	}


	echo "</td></tr></table><br>";
	}
?>

