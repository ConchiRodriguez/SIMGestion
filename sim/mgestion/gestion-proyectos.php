<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1013) AND ($autorizado == true)) {

	echo "<table class=\"principal\"><tr>";
		echo "<tr><td>";
			echo "<center><table><tr>";
				echo "<td><strong>".$Proyectos." :</strong></td>";
				if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1013&sop=0\" class=".$class.">".$Ver." ".$Proyectos."</a></td>";
				if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1013&sop=100\" class=".$class.">".$Anadir." ".$Proyecto."</a></td>";
				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1013&sop=200\" class=".$class.">".$Buscar." ".$Proyecto."</a></td>";
				if ($soption == 210) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1013&sop=210\" class=".$class.">".$Indicadores."</a></td>";
				if ($soption == 290) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1013&sop=290\" class=".$class.">".$Informes."</a></td>";
				if (($soption >= 300) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1013&sop=300\" class=".$class.">".$Administrar."</a></td>";
			echo "</tr></table>";
		echo "</center></td></tr>";
	echo "</table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 1) {
			$sqlcc = "select * from sgm_contratos where visible=1 and id_contrato_tipo=".$_POST["id_contrato_tipo"]." and id_cliente=".$_POST["id_cliente"]." and id_cliente_final=".$_POST["id_cliente_final"]." and num_contrato=".$_POST["num_contrato"]." and fecha_ini='".$_POST["fecha_ini"]."' and fecha_fin='".$_POST["fecha_fin"]."' and descripcion='".$_POST["descripcion"]."'";
			$resultcc = mysql_query(convertSQL($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			if (!$rowcc){
				$sql = "insert into sgm_contratos (id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico) ";
				$sql = $sql."values (";
				$sql = $sql.$_POST["id_contrato_tipo"];
				$sql = $sql.",".$_POST["id_cliente"];
				$sql = $sql.",".$_POST["id_cliente_final"];
				$sql = $sql.",'".$_POST["num_contrato"]."'";
				$sql = $sql.",'".$_POST["fecha_ini"]."'";
				$sql = $sql.",'".$_POST["fecha_fin"]."'";
				$sql = $sql.",'".comillas($_POST["descripcion"])."'";
				$sql = $sql.",".$_POST["id_responsable"];
				$sql = $sql.",".$_POST["id_tecnico"];
				$sql = $sql.")";
				mysql_query(convertSQL($sql));

				$sqlc = "select * from sgm_contratos where num_contrato='".$_POST["num_contrato"]."' and visible=1";
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 and id<0";
				$resultcs = mysql_query(convertSQL($sqlcs));
				while ($rowcs = mysql_fetch_array($resultcs)) {
					$sql = "insert into sgm_contratos_servicio (id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora) ";
					$sql = $sql."values (";
					$sql = $sql.$rowc["id"];
					$sql = $sql.",'".$rowcs["servicio"]."'";
					$sql = $sql.",".$rowcs["obligatorio"];
					$sql = $sql.",".$rowcs["extranet"];
					$sql = $sql.",".$rowcs["incidencias"];
					$sql = $sql.",".$rowcs["id_cobertura"];
					$sql = $sql.",".$rowcs["temps_resposta"];
					$sql = $sql.",".$rowcs["nbd"];
					$sql = $sql.",".$rowcs["sla"];
					$sql = $sql.",".$rowcs["duracion"];
					$sql = $sql.",".$rowcs["precio_hora"];
					$sql = $sql.")";
					mysql_query(convertSQL($sql));
				}
			}
		}
		if ($ssoption == 3) {
			$borrar = 0;
			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"];
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)){
				$sqli = "select count(*) as total from sgm_incidencias where visible=1 and id_servicio=".$row["id"];
				$resulti = mysql_query(convertSQL($sqli));
				$rowi = mysql_fetch_array($resulti);
				if ($rowi["total"] > 0){$borrar = 1;}
			}
			if ($borrar == 1){
				mensageError("No se puede eliminar este contrato, ya que existen incidencias asociados.");
			} else {
				$sql = "update sgm_contratos set ";
				$sql = $sql."visible=0";
				$sql = $sql." WHERE id=".$_GET["id"]."";
				mysql_query(convertSQL($sql));

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
		}
		if ($soption == 0) { echo "<strong>".$Actual."</strong>";}
		if ($soption == 1) { echo "<strong>".$Historico."</strong>";}
		if ($soption == 200) { echo "<strong>".$Buscador."</strong>";}
		echo "<br><br>";
		if ($soption != 200){
			echo "<table><tr>";
				echo "<td class=\"boton\">";
					if ($soption == 1) { echo "<a href=\"index.php?op=1013&sop=0\" style=\"color:white;\">".$Activo."</a>";}
					if ($soption == 0) { echo "<a href=\"index.php?op=1013&sop=1\" style=\"color:white;\">".$Inactivo."</a>";}
				echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
		}
		echo "<center>";
		if ($soption == 200){
			echo "<form action=\"index.php?op=1013&sop=200\" method=\"post\">";
			echo "<table cellspacing=\"0\" style=\"background-color:silver;\">";
				echo "<tr>";
					echo "<td>".$Contrato."</td>";
					echo "<td>".$Cliente."</td>";
					echo "<td>".$Cliente." ".$Final."</td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><select style=\"width:250px\" name=\"id_contrato_tipo2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_contrato_tipo2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_cliente2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_cliente2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_cliente_final2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_clients where visible=1 order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							if ($_POST["id_cliente_final2"] == $row["id"]){
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
		if (($soption != 200) or ($_POST["id_contrato_tipo2"] > 0) or ($_POST["id_cliente2"] > 0) or ($_POST["id_cliente_final2"] > 0)){
			echo "<table cellspacing=\"0\" style=\"width:1000px;\">";
				echo "<form action=\"index.php?op=1013&sop=100&ssop=1\" method=\"post\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<td><em>".$Eliminar."</em></td>";
					echo "<td style=\"text-align:center;\">".$Cliente."</td>";
					echo "<td style=\"text-align:center;\">".$Cliente." ".$Final."</td>";
					echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
					echo "<td><em>".$Editar."</em></td>";
					echo "<td><em>".$Ver."</em></td>";
				echo "</tr>";
				$sqlcc = "select * from sgm_contratos where visible=1 ";
				if ($_POST["id_contrato_tipo2"] > 0) {
					$sqlcc = $sqlcc." and id_contrato_tipo=".$_POST["id_contrato_tipo2"]."";
				}
				if ($_POST["id_cliente2"] > 0) {
					$sqlcc = $sqlcc." and id_cliente=".$_POST["id_cliente2"]."";
				}
				if ($_POST["id_cliente_final2"] > 0) {
					$sqlcc = $sqlcc." and id_cliente_final=".$_POST["id_cliente_final2"]."";
				}
				if ($soption == 0){ $sqlcc = $sqlcc." and activo=1";}
				if ($soption == 1){ $sqlcc = $sqlcc." and activo=0";}
				$sqlcc = $sqlcc." order by num_contrato desc";
#				echo $sqlcc."<br>";
				$resultcc = mysql_query(convertSQL($sqlcc));
				while ($rowcc = mysql_fetch_array($resultcc)){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=10&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
						$result = mysql_query(convertSQL($sql));
						$row = mysql_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
						$result = mysql_query(convertSQL($sql));
						$row = mysql_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						echo "<td><a href=\"index.php?op=1013&sop=100&id=".$rowcc["id"]."&edit=0\">".$rowcc["descripcion"]."</a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=100&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=142&id=".$row["id"]."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a></td>";
					echo "</tr>";
				}
			echo "</table>";
			echo "</center>";
		}
	}

	if ($soption == 10) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este contrato?<br><br>";
		echo "<a href=\"index.php?op=1013&sop=0&ssop=3&id=".$_GET["id"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1013&sop=0\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 100) {
		if ($ssoption == 1) {
			$sql = "update sgm_contratos set ";
			$sql = $sql."num_contrato='".$_POST["num_contrato"]."'";
			$sql = $sql.",id_contrato_tipo='".$_POST["id_contrato_tipo"]."'";
			$sql = $sql.",id_cliente='".$_POST["id_cliente"]."'";
			$sql = $sql.",id_cliente_final='".$_POST["id_cliente_final"]."'";
			$sql = $sql.",fecha_ini='".$_POST["fecha_ini"]."'";
			$sql = $sql.",fecha_fin='".$_POST["fecha_fin"]."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql.",id_responsable=".$_POST["id_responsable"];
			$sql = $sql.",id_tecnico=".$_POST["id_tecnico"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"]." and servicio='".comillas($_POST["servicio"])."'";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			if (!$row){
				$sql = "insert into sgm_contratos_servicio (id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora) ";
				$sql = $sql."values (";
				$sql = $sql.$_GET["id"];
				$sql = $sql.",'".comillas($_POST["servicio"])."'";
				$sql = $sql.",".$_POST["obligatorio"];
				$sql = $sql.",".$_POST["extranet"];
				$sql = $sql.",".$_POST["incidencias"];
				$sql = $sql.",".$_POST["id_cobertura"];
				$sql = $sql.",".$_POST["temps_resposta"];
				$sql = $sql.",".$_POST["nbd"];
				$sql = $sql.",".$_POST["sla"];
				$sql = $sql.",".$_POST["duracion"];
				$sql = $sql.",".$_POST["precio_hora"];
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_contratos_servicio set ";
			$sql = $sql."id_contrato=".$_GET["id"];
			$sql = $sql.",servicio='".comillas($_POST["servicio"])."'";
			$sql = $sql.",obligatorio=".$_POST["obligatorio"];
			$sql = $sql.",extranet=".$_POST["extranet"];
			$sql = $sql.",incidencias=".$_POST["incidencias"];
			$sql = $sql.",id_cobertura=".$_POST["id_cobertura"];
			$sql = $sql.",temps_resposta=".$_POST["temps_resposta"];
			$sql = $sql.",nbd=".$_POST["nbd"];
			$sql = $sql.",sla=".$_POST["sla"];
			$sql = $sql.",duracion=".$_POST["duracion"];
			$sql = $sql.",precio_hora=".$_POST["precio_hora"];
			$sql = $sql." WHERE id=".$_GET["id_ser"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_contratos_servicio set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_ser"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_contratos set ";
			$sql = $sql."activo=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 6) {
			$sql = "update sgm_contratos set ";
			$sql = $sql."activo=1";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 7) {
			$sqln = "select * from sgm_contratos where visible=1 order by num_contrato desc";
			$resultn = mysql_query(convertSQL($sqln));
			$rown = mysql_fetch_array($resultn);
			$numeroc = ($rown["num_contrato"]+ 1);
			$sqlcc = "select * from sgm_contratos where visible=1 and id=".$_GET["id"]."";
			$resultcc = mysql_query(convertSQL($sqlcc));
			$rowcc = mysql_fetch_array($resultcc);
			$ini = date("U",strtotime($rowcc["fecha_fin"].""));
			$inici = $ini+86400;
			$fecha_inici = date("Y-m-d", $inici);
			$fin = $inici+31536000;
			$fecha_fin = date("Y-m-d", $fin);
			if ($rowcc){
				$sql = "insert into sgm_contratos (id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico) ";
				$sql = $sql."values (";
				$sql = $sql.$rowcc["id_contrato_tipo"];
				$sql = $sql.",".$rowcc["id_cliente"];
				$sql = $sql.",".$rowcc["id_cliente_final"];
				$sql = $sql.",'".$numeroc."'";
				$sql = $sql.",'".$fecha_inici."'";
				$sql = $sql.",'".$fecha_fin."'";
				$sql = $sql.",'".comillas($rowcc["descripcion"])."'";
				$sql = $sql.",".$rowcc["id_responsable"];
				$sql = $sql.",".$rowcc["id_tecnico"];
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
				$sql = "update sgm_contratos set ";
				$sql = $sql."renovado=1";
				$sql = $sql." WHERE id=".$_GET["id"]."";
				mysql_query(convertSQL($sql));

				$sqlc = "select * from sgm_contratos where num_contrato='".$numeroc."'";
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"];
				$resultcs = mysql_query(convertSQL($sqlcs));
				while ($rowcs = mysql_fetch_array($resultcs)) {
					$sql = "insert into sgm_contratos_servicio (id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora) ";
					$sql = $sql."values (";
					$sql = $sql.$rowc["id"];
					$sql = $sql.",'".$rowcs["servicio"]."'";
					$sql = $sql.",".$rowcs["obligatorio"];
					$sql = $sql.",".$rowcs["extranet"];
					$sql = $sql.",".$rowcs["incidencias"];
					$sql = $sql.",".$rowcs["id_cobertura"];
					$sql = $sql.",".$rowcs["temps_resposta"];
					$sql = $sql.",".$rowcs["nbd"];
					$sql = $sql.",".$rowcs["sla"];
					$sql = $sql.",".$rowcs["duracion"];
					$sql = $sql.",".$rowcs["precio_hora"];
					$sql = $sql.")";
					mysql_query(convertSQL($sql));
#					echo $sql;
				}
				$sqlca = "select * from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"];
				$resultca = mysql_query(convertSQL($sqlca));
				while ($rowca = mysql_fetch_array($resultca)) {
					insertCabezera(0,7,0,0,0,0,$rowca["fecha"],$rowca["fecha_prevision"],$rowca["id_cliente"],$rowc["id"],0);
					$sqlcab = "select * from sgm_cabezera where visible=1 and id_contrato=".$rowc["id"]." order by id desc";
					$resultcab = mysql_query(convertSQL($sqlcab));
					$rowcab = mysql_fetch_array($resultcab);
					$sqlcu = "select * from sgm_cuerpo where idfactura=".$rowca["id"];
					$resultcu = mysql_query(convertSQL($sqlcu));
					while ($rowcu = mysql_fetch_array($resultcu)) {
						insertCuerpo($rowcab["id"],1,0,$rowcu["nombre"],0,$rowcu["total"],1,$rowcu["fecha_prevision"],0,0,$rowcu["fecha_prevision_propia"]);
					}
				}
				$sqlc = "select * from sgm_contratos where num_contrato='".$numeroc."' order by id desc";
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$sqlco = "update sgm_contrasenyes set ";
				$sqlco = $sqlco."id_contrato=".$rowc["id"]."";
				$sqlco = $sqlco." WHERE id_contrato=".$_GET["id"]."";
				mysql_query(convertSQL($sqlco));
#				echo $sqlco;
			}
		}
		if ($ssoption == 10) {
			insertCabezera(0,7,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],$_POST["id_cliente"],$_POST["id_contrato"],0);
			$sql = "select * from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]." order by id desc";
			$result = mysql_query(convertSQL($sql));
			$row = mysql_fetch_array($result);
			insertCuerpo($row["id"],1,0,$_POST["concepto"],0,$_POST["importe"],1,$_POST["fecha_prevision"],0,0,$_POST["fecha_prevision"]);
		}
		if ($ssoption == 11) {
			updateCabezera($_GET["id_fact"],0,0,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],0,0,$_POST["id_cliente"],$_POST["id_contrato"],0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
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

		if ($_GET["id"] != "") { echo "<strong>".$Editar." ".$Contrato." : </strong>";} else { echo "<strong>".$Anadir." ".$Contrato." : </strong>";}
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			if ($_GET["id"] != "") {
				echo "<form action=\"index.php?op=1013&sop=100&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				$sqlc = "select * from sgm_contratos where visible=1 and id=".$_GET["id"];
				$resultc = mysql_query(convertSQL($sqlc));
				$rowc = mysql_fetch_array($resultc);
				$numeroc = $rowc["num_contrato"];
			} else {
				echo "<form action=\"index.php?op=1013&sop=0&ssop=1\" method=\"post\">";
				$numeroc = 0;
				$sqln = "select * from sgm_contratos where visible=1 order by num_contrato desc";
				$resultn = mysql_query(convertSQL($sqln));
				$rown = mysql_fetch_array($resultn);
				$numeroc = ($rown["num_contrato"]+ 1);
			}
			echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Contrato.": </td><td><input style=\"width:100px\" type=\"Text\" name=\"num_contrato\" value=\"".$numeroc."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Contrato." ".$Tipo.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_contrato_tipo\">";
					$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)) {
						if ($row["id"] == $rowc["id_contrato_tipo"]){
							echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." - ".$row["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]." - ".$row["descripcion"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_cliente\">";
					$sqla = "select * from sgm_clients where visible=1 order by nombre";
					$resulta = mysql_query(convertSQL($sqla));
					while ($rowa = mysql_fetch_array($resulta)) {
						if ($rowa["id"] == $rowc["id_cliente"]){
							echo "<option value=\"".$rowa["id"]."\" selected>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente." ".$Final.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_cliente_final\">";
					$sqlb = "select * from sgm_clients where visible=1 order by nombre";
					$resultb = mysql_query(convertSQL($sqlb));
					while ($rowb = mysql_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_cliente_final"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Descripcion.": </td><td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\" value=\"".$rowc["descripcion"]."\"></td></tr>";
			if ($_GET["id"] != "") {
				$date1 = $rowc["fecha_ini"];
				$date2 = $rowc["fecha_fin"];
			} else {
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				$date2 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			}
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Inicio.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_ini\" value=\"".$date1."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Fin.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_fin\" value=\"".$date2."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Responsable_cliente.": </td>";
				echo "<td><select name=\"id_responsable\" style=\"width:150px\">";
				$sqlua = "select * from sgm_users where validado=1 and activo=1 and sgm=1";
				$resultua = mysql_query(convertSQL($sqlua));
				while ($rowua = mysql_fetch_array($resultua)) {
						if ($rowua["id"] == $rowc["id_responsable"]){
							echo "<option value=\"".$rowua["id"]."\" selected>".$rowua["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowua["id"]."\">".$rowua["usuario"]."</option>";
						}
				}
				echo "</select></td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Responsable_tecnico.": </td>";
				echo "<td><select name=\"id_tecnico\" style=\"width:150px\">";
				$sqluu = "select * from sgm_users where validado=1 and activo=1 and sgm=1";
				$resultuu = mysql_query(convertSQL($sqluu));
				while ($rowuu = mysql_fetch_array($resultuu)) {
						if ($rowuu["id"] == $rowc["id_tecnico"]){
							echo "<option value=\"".$rowuu["id"]."\" selected>".$rowuu["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowuu["id"]."\">".$rowuu["usuario"]."</option>";
						}
				}
				echo "</select></td>";
			echo "</tr>";
			if ($_GET["edit"] == "") {
				if ($_GET["id"] != "") {
					echo "<td></td><td><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
				} else {
					echo "<td></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				}
			}
			echo "</form>";
			if ($_GET["id"] != "") {
				if ($rowc["activo"] == 1) {
					echo "<form action=\"index.php?op=1013&sop=100&ssop=5&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td><td><input type=\"Submit\" value=\"".$Desactivar."\" style=\"width:100px\"></td>";
				} else {
					echo "<form action=\"index.php?op=1013&sop=100&ssop=6&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td><td><input type=\"Submit\" value=\"".$Activar."\" style=\"width:100px\"></td>";
				}
				echo "</form>";
			}
			if ($_GET["id"] != "") {
				if ($rowc["renovado"] == 0) {
					echo "<form action=\"index.php?op=1013&sop=100&ssop=7&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td><td><input type=\"Submit\" value=\"renovar".$Renovar."\" style=\"width:100px\"></td>";
					echo "</form>";
				} else {
					echo "<td></td><td></td>";
				}
			}
		echo "</table>";
		echo "</center>";
		echo "<br><br>";

		if ($_GET["id"] != "") {

			echo "<center><table cellspacing=\"0\">";
				echo "<tr><td>".$Facturas."</td></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<td></td>";
					echo "<td style=\"text-align:center;\">".$Fecha."</td>";
					echo "<td style=\"text-align:center;\">".$Fecha." ".$Prevision."</td>";
					echo "<td style=\"text-align:center;\">".$Concepto."</td>";
					echo "<td style=\"text-align:center;\">".$Importe."</td>";
					echo "<td></td>";
				echo "</tr><tr>";
				echo "<form action=\"index.php?op=1013&sop=100&ssop=10&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td>";
					echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowc["id_cliente"]."\">";
					echo "<input type=\"hidden\" name=\"id_contrato\" value=\"".$_GET["id"]."\">";
					$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$date."\"></td>";
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$date."\"></td>";
					echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\"></td>";
					echo "<td><input style=\"text-align:right;width:70px\" type=\"Text\" name=\"importe\" value=\"0\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				$sql = "select * from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]."";
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					$sqlcu = "select * from sgm_cuerpo where idfactura=".$row["id"]."";
					$resultcu = mysql_query(convertSQL($sqlcu));
					$rowcu = mysql_fetch_array($resultcu);
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=102&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						echo "<form action=\"index.php?op=1013&sop=100&ssop=11&id=".$_GET["id"]."&id_fact=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowc["id_cliente"]."\">";
						echo "<input type=\"hidden\" name=\"id_contrato\" value=\"".$_GET["id"]."\">";
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$row["fecha"]."\"></td>";
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\"></td>";
						echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\" value=\"".$rowcu["nombre"]."\"></td>";
						echo "<td><input style=\"text-align:right;width:70px\" type=\"Text\" name=\"importe\" value=\"".$rowcu["pvp"]."\"></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
						echo "</form>";
					echo "</tr>";
				}
			echo "</table></center>";
			echo "<br><br>";

			echo "<br><br>";
			echo "<center><table cellspacing=\"0\">";
				echo "<tr><td>".$SLA."</td></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<td></td>";
					echo "<td style=\"text-align:center;\">".$Servicio."</td>";
					echo "<td style=\"text-align:center;\">".$Obligatorio."</td>";
					echo "<td style=\"text-align:center;\">".$Extranet."</td>";
					echo "<td style=\"text-align:center;\">".$Incidencias."</td>";
					echo "<td style=\"text-align:center;\">".$Duracion."</td>";
					echo "<td style=\"text-align:center;\">".$Cobertura."</td>";
					echo "<td style=\"text-align:center;\">".$Tiempo."</td>";
					echo "<td style=\"text-align:center;\">".$NBD."</td>";
					echo "<td style=\"text-align:center;\">".$SLA." %</td>";
					echo "<td style=\"text-align:center;\">".$Precio."</td>";
					echo "<td></td>";
				echo "</tr><tr>";
					echo "<td></td>";
					echo "<form action=\"index.php?op=1013&sop=100&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td><input style=\"width:250px\" type=\"Text\" name=\"servicio\"></td>";
					echo "<td><select style=\"width:70px\" name=\"obligatorio\">";
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\">Si</option>";
					echo "</td>";
					echo "<td><select style=\"width:70px\" name=\"extranet\">";
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\">Si</option>";
					echo "</td>";
					echo "<td><select style=\"width:70px\" name=\"incidencias\">";
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\">Si</option>";
					echo "</td>";
					echo "<td><select style=\"width:70px\" name=\"duracion\">";
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\">Si</option>";
					echo "</td>";
					echo "<td><select style=\"width:70px\" name=\"id_cobertura\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_contratos_sla_cobertura where visible=1 order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
						}
					echo "</td>";
					echo "<td><select style=\"width:70px\" name=\"temps_resposta\">";
						for ($i = 0; $i <= 24 ; $i++) {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					echo "</td>";
					echo "<td><select style=\"width:70px\" name=\"nbd\">";
						echo "<option value=\"0\">No</option>";
						echo "<option value=\"1\">Si</option>";
					echo "</td>";
					echo "<td><input style=\"text-align:right;width:70px\" type=\"Text\" name=\"sla\" value=\"0\"></td>";
					echo "<td><input style=\"text-align:right;width:70px\" type=\"Text\" name=\"precio_hora\" value=\"0\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"]." order by id desc";
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=101&id=".$_GET["id"]."&id_ser=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						echo "<form action=\"index.php?op=1013&sop=100&ssop=3&id=".$_GET["id"]."&id_ser=".$row["id"]."\" method=\"post\">";
						echo "<td><input type=\"text\" value=\"".$row["servicio"]."\" style=\"width:250px\" name=\"servicio\"></td>";
						echo "<td><select style=\"width:70px\" name=\"obligatorio\">";
							if ($row["obligatorio"] == 1){
								echo "<option value=\"1\" selected>Si</option>";
								echo "<option value=\"0\">No</option>";
							} else {
								echo "<option value=\"1\">Si</option>";
								echo "<option value=\"0\" selected>No</option>";
							}
						echo "</td>";
						echo "<td><select style=\"width:70px\" name=\"extranet\">";
							if ($row["extranet"] == 1){
								echo "<option value=\"1\" selected>Si</option>";
								echo "<option value=\"0\">No</option>";
							} else {
								echo "<option value=\"1\">Si</option>";
								echo "<option value=\"0\" selected>No</option>";
							}
						echo "</td>";
						echo "<td><select style=\"width:70px\" name=\"incidencias\">";
							if ($row["incidencias"] == 1){
								echo "<option value=\"1\" selected>Si</option>";
								echo "<option value=\"0\">No</option>";
							} else {
								echo "<option value=\"1\">Si</option>";
								echo "<option value=\"0\" selected>No</option>";
							}
						echo "</td>";
						echo "<td><select style=\"width:70px\" name=\"duracion\">";
							if ($row["duracion"] == 1){
								echo "<option value=\"1\" selected>Si</option>";
								echo "<option value=\"0\">No</option>";
							} else {
								echo "<option value=\"1\">Si</option>";
								echo "<option value=\"0\" selected>No</option>";
							}
						echo "</td>";
						echo "<td><select style=\"width:70px\" name=\"id_cobertura\">";
							echo "<option value=\"0\">-</option>";
							$sqls = "select * from sgm_contratos_sla_cobertura where visible=1 order by nombre";
							$results = mysql_query(convertSQL($sqls));
							while ($rows = mysql_fetch_array($results)) {
								if ($rows["id"] == $row["id_cobertura"]){
									echo "<option value=\"".$rows["id"]."\" selected>".$rows["nombre"]."</option>";
								} else {
									echo "<option value=\"".$rows["id"]."\">".$rows["nombre"]."</option>";
								}
							}
						echo "</td>";
						echo "<td><select style=\"width:70px\" name=\"temps_resposta\">";
							for ($i = 0; $i <= 24 ; $i++) {
								if ($i == $row["temps_resposta"]){
									echo "<option value=\"".$i."\" selected>".$i."</option>";
								} else {
									echo "<option value=\"".$i."\">".$i."</option>";
								}
							}
						echo "</td>";
						echo "<td><select style=\"width:70px\" name=\"nbd\">";
							if ($row["nbd"] == 1){
								echo "<option value=\"1\" selected>Si</option>";
								echo "<option value=\"0\">No</option>";
							} else {
								echo "<option value=\"1\">Si</option>";
								echo "<option value=\"0\" selected>No</option>";
							}
						echo "</td>";
						echo "<td><input type=\"text\" value=\"".$row["sla"]."\" style=\"text-align:right;width:70px\" name=\"sla\"></td>";
						echo "<td><input type=\"text\" value=\"".$row["precio_hora"]."\" style=\"text-align:right;width:70px\" name=\"precio_hora\"></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
						echo "</form>";
						$sqlind = "select sum(duracion) as total from sgm_incidencias where visible=1 and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$row["id"].")";
						$resultind = mysql_query(convertSQL($sqlind));
						$rowind = mysql_fetch_array($resultind);
						$hora = $rowind["total"]/60;
						$horas = explode(".",$hora);
						$minutos = $rowind["total"] % 60;
						echo "<td><strong>".$horas[0]." h. ".$minutos." m.</strong></td>";
					echo "</tr>";
				}
			echo "</table></center>";
			echo "<br><br>";
			echo "<strong>".$Obligatorio."</strong>: Si para aquellos servicios que van incluidos en el contrato y no son seleccionables por el cliente.<br>";
			echo "<strong>".$Extranet."</strong>: Si el servicio es visible para el cliente en la extranet, sección contratos.<br>";
			echo "<strong>".$Incidencias."</strong>: Si el cliente puede abrir incidencias sobre este servicio.<br>";
			echo "<strong>".$Duracion." </strong>: Si el cliente puede ver la duraci&oacute;n de las incidencias.<br>";
			echo "<strong>".$Cobertura."</strong>: Horas de cobertura del servicio.<br>";
			echo "<strong>".$Tiempo."</strong>: Tiempo máximo de resolución de incidencias del servicio en SLA.<br>";
			echo "<strong>NBD</strong>: Next Bussines Day, Si las incidencias hay que resolverlas dentro del horario laboral.<br>";
			echo "<strong>SLA</strong>: Porcentage de incidencias que se deben resolver dentro del máximo de horas de SLA.<br>";
		}
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este servicio?";
		echo "<br><br><a href=\"index.php?op=1013&sop=100&ssop=4&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"]."\">[ SI ]</a><a href=\"index.php?op=1013&sop=100&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 102) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta factura?";
		echo "<br><br><a href=\"index.php?op=1013&sop=100&ssop=12&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"]."\">[ SI ]</a><a href=\"index.php?op=1013&sop=100&id=".$_GET["id"]."\">[ NO ]</a>";
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
			echo "<form action=\"index.php?op=1013&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
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
				$sql = "select * from sgm_clients where visible=1 and id=".$rown["id_cliente"];
				$result = mysql_query(convertSQL($sql));
				$row = mysql_fetch_array($result);
				echo "<td><input style=\"width:300px\" name=\"id_cliente\" value=\"".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."\"></td>";
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
						echo "<a href=\"index.php?op=1013&sop=120&id=".$rowc["id"]."\" style=\"color:white;\">".$rowc["tipo"]."</a>";
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


	if ($soption == 210) {
		echo "<strong>".$Indicadores." : </strong><br><br>";
		resumEconomicContractes(0);
	}

	#Informes
	if ($soption == 290) {
		informesContratos();
	}

	if ($soption == 300) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td><strong>Administrar : &nbsp;&nbsp;</strong></td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1013&sop=310\" style=\"color:white;\">".$Contratos."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1013&sop=500\" style=\"color:white;\">".$Cobertura." ".$SLA."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1013&sop=400\" style=\"color:white;\">".$Tipo." ".$Incidencia."</a>";
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
			$sql = "insert into sgm_contratos_tipos (nombre,descripcion) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["nombre"])."'";
			$sql = $sql.",'".comillas($_POST["descripcion"])."'";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_contratos_tipos set ";
			$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sqlc = "select count(*) as total from sgm_contratos where visible=1 and id_contrato_tipo=".$_GET["id"];
			$resultc = mysql_query(convertSQL($sqlc));
			$rowc = mysql_fetch_array($resultc);
			if ($rowc["total"] > 0){
				mensageError("No se puede eliminar este tipo de contrato, ya que existen contratos asociados.");
			} else {
				$sql = "update sgm_contratos_tipos set ";
				$sql = $sql."visible=0";
				$sql = $sql." WHERE id=".$_GET["id"]."";
				mysql_query(convertSQL($sql));
			}
		}

		echo "<strong>".$Tipos." ".$Contratos." : </strong>";
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
				echo "<form action=\"index.php?op=1013&sop=310&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=311&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1013&sop=310&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "<td style=\"width:100px;height:13px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1013&sop=320&id_contrato_tipo=".$row["id"]."\" style=\"color:white;\">".$Incidencias."</a>";
				echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 311) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este tipo de contrato?";
		echo "<br><br><a href=\"index.php?op=1013&sop=310&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1013&sop=310\">[ NO ]</a>";
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
				echo "<form action=\"index.php?op=1013&sop=320&ssop=1&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\" method=\"post\">";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=321&id=".$rowci["id"]."&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1013&sop=320&ssop=2&id=".$rowci["id"]."&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\" method=\"post\">";
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
		echo "<br><br><a href=\"index.php?op=1013&sop=320&ssop=3&id=".$_GET["id"]."&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\">[ SI ]</a><a href=\"index.php?op=1013&sop=320&id_contrato_tipo=".$_GET["id_contrato_tipo"]."\">[ NO ]</a>";
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
				echo "<form action=\"index.php?op=1013&sop=400&ssop=1\" method=\"post\">";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=401&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1013&sop=400&ssop=2&id=".$row["id"]."\" method=\"post\">";
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
		echo "<br><br><a href=\"index.php?op=1013&sop=400&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1013&sop=400\">[ NO ]</a>";
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
				echo "<form action=\"index.php?op=1013&sop=500&ssop=1\" method=\"post\">";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1013&sop=501&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1013&sop=500&ssop=2&id=".$row["id"]."\" method=\"post\">";
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
		echo "<br><br><a href=\"index.php?op=1013&sop=500&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1013&sop=500\">[ NO ]</a>";
		echo "</center>";
	}


	echo "</td></tr></table><br>";
	}
?>

