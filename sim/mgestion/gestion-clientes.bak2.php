<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);

if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1008) AND ($autorizado == true)) {
	if ($_GET['or'] != "") { $orden = $_GET['or']; } else { $orden = 0; }

	## canvis en les definicions de clients (noms, color, relacions, etc) ##
	if (($soption == 60) and ($ssoption == 1) AND ($admin == true)) {
		$sql = "insert into sgm_clients_classificacio_tipus (id_origen,nom,color,color_lletra) ";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_origen"]."";
		$sql = $sql.",'".comillas($_POST["nom"])."'";
		if ($_POST["id_origen"] == 0){
			$sql = $sql.",'".comillas($_POST["color"])."'";
			$sql = $sql.",'".comillas($_POST["color_lletra"])."'";
		} else {
			$sqlx = "select * from sgm_clients_classificacio_tipus where visible=1 and id=".$_POST["id_origen"];
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
			$sql = $sql.",'".$rowx["color"]."'";
			$sql = $sql.",'".$rowx["color_lletra"]."'";
		}
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
	}
	if (($soption == 60) and ($ssoption == 2) AND ($admin == true)) {
		$sql = "update sgm_clients_classificacio_tipus set ";
		$sql = $sql."id_origen='".$_POST["id_origen"]."'";
		$sql = $sql.",nom='".comillas($_POST["nom"])."'";
		$sql = $sql.",color='".comillas($_POST["color"])."'";
		$sql = $sql.",color_lletra='".comillas($_POST["color_lletra"])."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		canviar_color($_GET["id"],$_POST["color"],$_POST["color_lletra"]);
	}
	if (($soption == 60) and ($ssoption == 3) AND ($admin == true)) {
		$sql = "update sgm_clients_classificacio_tipus set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		$sqls = "update sgm_clients_classificacio set ";
		$sqls = $sqls."visible=0";
		$sqls = $sqls." WHERE id_clasificacio_tipus=".$_GET["id"]."";
		mysql_query(convert_sql($sqls));
		$sqls = "update sgm_clients_classificacio_tipus set ";
		$sqls = $sqls."id_origen=0";
		$sqls = $sqls." WHERE id_origen=".$_GET["id"]."";
		mysql_query(convert_sql($sqls));
	}
	## fi de canvis en les definicions de client ##

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<tr><td>";
			echo "<center><table><tr>";
				echo "<td style=\"height:20px;width:150px;\";><strong>".$Contactos." 2.1 :</strong></td>";
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=0\" class=\"gris\" style=\"color: white\">".$Buscar."</a></td>";
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=3&id_classificacio=0\" class=\"gris\" style=\"color: white\">".$Ver_Todos."</a></td>";
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=2\" class=\"gris\" style=\"color: white\">".$Ver_Todos_Personales."</a></td>";
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=210&id=0\" class=\"gris\" style=\"color: white\">".$Anadir_Contacto."</a></td>";
				echo "<td style=\"height:20px;width:150px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=300\" class=\"gris\" style=\"color: white\">".$Indicadores."</a></td>";
				if ($admin == true) { echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=500\" class=\"gris\" style=\"color: white\">".$Administrar."</a></td>"; }
				echo "</tr></table>";
					$id_origen = 0;
					### BUSCO CATEGORIA DE ORIGEN
					$sqltx1 = "select * from sgm_clients_classificacio_tipus where id=".$_GET["id_classificacio"];
					$resulttx1 = mysql_query(convert_sql($sqltx1));
					$rowtx1 = mysql_fetch_array($resulttx1);
					if ($rowtx1["id_origen"] == 0) {
						$id_origen = $rowtx1["id"];
					} else {
						$sqltx2 = "select * from sgm_clients_classificacio_tipus where id=".$rowtx1["id_origen"];
						$resulttx2 = mysql_query(convert_sql($sqltx2));
						$rowtx2 = mysql_fetch_array($resulttx2);
						if ($rowtx2["id_origen"] == 0) {
							$id_origen = $rowtx2["id"];
						} else {
							$sqltx3 = "select * from sgm_clients_classificacio_tipus where id=".$rowtx2["id_origen"];
							$resulttx3 = mysql_query(convert_sql($sqltx3));
							$rowtx3 = mysql_fetch_array($resulttx3);
							if ($rowtx3["id_origen"] == 0) {
								$id_origen = $rowtx3["id"];
							}
						}
					}
				echo "<table><tr>";
				$sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0 order by nom";
				$resultt = mysql_query(convert_sql($sqlt));
				while ($rowt = mysql_fetch_array($resultt)){
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=3&id_classificacio=".$rowt["id"]."\" class=\"gris\" style=\"color: ".$rowt["color_lletra"]."\">".$rowt["nom"]."</a></td>";
				}
				echo "</tr></table>";
				if ($id_origen != 0) {
					echo "<table><tr>";
					$sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$id_origen." order by nom";
					$resultt = mysql_query(convert_sql($sqlt));
					while ($rowt = mysql_fetch_array($resultt)){
						echo "<td style=\"vertical-align:top;\">";
							echo "<table>";
								echo "<tr><td style=\"height:16px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=3&id_classificacio=".$rowt["id"]."\" class=\"gris\" style=\"color: ".$rowt["color_lletra"]."\">".$rowt["nom"]."</a></td></tr>";
								echo "<tr><td style=\"height:6px\"></td></tr>";
								$sqltt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"]." order by nom";
								$resulttt = mysql_query(convert_sql($sqltt));
								while ($rowtt = mysql_fetch_array($resulttt)){
									echo "<tr><td style=\"height:16px;width:120px;text-align:center;vertical-align:middle;background-color: ".$rowtt["color"].";color: white;border: 1px solid black\"><a href=\"index.php?op=1008&sop=3&id_classificacio=".$rowtt["id"]."\" class=\"gris\" style=\"color: ".$rowtt["color_lletra"]."\">".$rowtt["nom"]."</a></td></tr>";
								}
							echo "</table>";
						echo "</td>";
					}
					echo "</tr></table>";
				}
			echo "</center></td></tr>";
		echo "</table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 0) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=1\" style=\"color:white;\">".$Personalizada."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=3\" style=\"color:white;\">".$Completa."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 1) {
		echo "<table>";
			echo "<tr>";
			$x = 0;
			$sql = "select * from sgm_cerques where nombre<>'' order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)){
				echo "<td style=\"width:400px;height:50px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=4&id=".$row["id"]."\" style=\"color:white;\">".$row["nombre"]."</a>";
				echo "</td>";
				$x++;
				if ($x >= 3){ echo "</tr><tr>"; $x = 0 ;}
			}
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 3) {
		if ($ssoption == 1){
			$sql = "delete from sgm_cerques WHERE id_user=".$userid."";
			mysql_query(convert_sql($sql));

			$lletres = "";
			for ($i = 0; $i <= 127; $i++) {
				if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
					if ($_POST[chr($i)] == true) {
						$lletres .= chr($i);
						echo "<input type=\"Hidden\" name=\"lletres\" value=\"".$lletres."\">";
					}
				}
			}
		    $desde = $_POST["año1"]."-".$_POST["mes1"]."-".$_POST["dia1"]." 00:00:00";
			$hasta = $_POST["año2"]."-".$_POST["mes2"]."-".$_POST["dia2"]." 23:59:59";
			$sql = "insert into sgm_cerques (nombre,lletres,id_tipo,id_grupo,id_sector,id_ubicacion,id_classificacio,id_servicio,id_sestado,id_proveedor,id_certificado,id_cestado,contactes,likenombre,incidencies,desde,hasta,id_user) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["nom_cerca"]."'";
			$sql = $sql.",'".$lletres."'";
			$sql = $sql.",".$_POST["tipo"];
			$sql = $sql.",".$_POST["grupo"];
			$sql = $sql.",".$_POST["sector"];
			$sql = $sql.",".$_POST["ubicacion"];
			$sql = $sql.",".$_POST["id_classificacio"];
			$sql = $sql.",".$_POST["servicio"];
			$sql = $sql.",".$_POST["id_sestado"];
			$sql = $sql.",".$_POST["id_proveedor"];
			$sql = $sql.",".$_POST["certificado"];
			$sql = $sql.",".$_POST["id_cestado"];
			$sql = $sql.",".$_POST["contactes"];
			$sql = $sql.",'".$_POST["likenombre"]."'";
			$sql = $sql.",'".$_POST["incidencies"]."'";
			$sql = $sql.",'".$desde."'";
			$sql = $sql.",'".$hasta."'";
			$sql = $sql.",".$userid."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		if ($_GET["id_classificacio"] != "") {
			$sql = "delete from sgm_cerques WHERE id_user=".$userid."";
			mysql_query(convert_sql($sql));
			$sql = "insert into sgm_cerques (id_classificacio,id_user) ";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id_classificacio"];
			$sql = $sql.",".$userid."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($_GET["id_classificacio"] == "") {
			echo "<form action=\"index.php?op=1008&sop=3&ssop=1\" method=\"post\">";
			echo "<center>";
						echo "<table cellspacing=\"0\">";
							echo "<tr style=\"background-color:silver;\">";
								echo "<td><strong>".$Buscar_Contacto."</strong></td>";
								echo "<td>".$Tipo."</td>";
								echo "<td>".$Grupo."</td>";
								echo "<td>".$Sector."</td>";
								echo "<td>".$Ubicacion."</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>";
									echo "<select name=\"id_classificacio\" style=\"width:354px\">";
										echo "<option value=\"0\">".$Todos."</option>";
										$sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0";
										$resultt = mysql_query(convert_sql($sqlt));
										while ($rowt = mysql_fetch_array($resultt)) {
											if ($rowt["id"] == $_POST["id_classificacio"]){
												echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nom"]."</option>";
											} else {
												echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
											}
											$sqlti = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"];
											$resultti = mysql_query(convert_sql($sqlti));
											while ($rowti = mysql_fetch_array($resultti)) {
												if ($rowti["id"] == $_POST["id_classificacio"]){
													echo "<option value=\"".$rowti["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."</option>";
												} else {
													echo "<option value=\"".$rowti["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."</option>";
												}
												$sqltip = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowti["id"];
												$resulttip = mysql_query(convert_sql($sqltip));
												while ($rowtip = mysql_fetch_array($resulttip)) {
													if ($rowtip["id"] == $_POST["id_classificacio"]){
														echo "<option value=\"".$rowtip["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
													} else {
														echo "<option value=\"".$rowtip["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
													}
												}
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"tipo\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqlt = "select * from sgm_clients_tipos order by tipo";
										$resultt = mysql_query(convert_sql($sqlt));
										while ($rowt = mysql_fetch_array($resultt)){
											if ((($rowt["predeterminado"] == 1) and ($_POST["tipo"] == "")) or ($_POST["tipo"] == $rowt["id"])) {
												echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["tipo"]."</option>";
											} else {
												echo "<option value=\"".$rowt["id"]."\">".$rowt["tipo"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"grupo\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqlg = "select * from sgm_clients_grupos order by grupo";
										$resultg = mysql_query(convert_sql($sqlg));
										while ($rowg = mysql_fetch_array($resultg)){
											if ((($rowg["predeterminado"] == 1) and ($_POST["grupo"] == "")) or ($_POST["grupo"] == $rowg["id"])) {
												echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["grupo"]."</option>";
											} else {
												echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"sector\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqls = "select * from sgm_clients_sectors order by sector";
										$results = mysql_query(convert_sql($sqls));
										while ($rows = mysql_fetch_array($results)){
											if ((($rows["predeterminado"] == 1) and ($_POST["sector"] == "")) or ($_POST["sector"] == $rows["id"])) {
												echo "<option value=\"".$rows["id"]."\" selected>".$rows["sector"]."</option>";
											} else {
												echo "<option value=\"".$rows["id"]."\">".$rows["sector"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"ubicacion\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqlu = "select * from sgm_clients_ubicacion order by ubicacion";
										$resultu = mysql_query(convert_sql($sqlu));
										while ($rowu = mysql_fetch_array($resultu)){
											if ((($rowu["predeterminado"] == 1) and ($_POST["ubicacion"] == "")) or ($_POST["ubicacion"] == $rowu["id"])) {
												echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["ubicacion"]."</option>";
											} else {
												echo "<option value=\"".$rowu["id"]."\">".$rowu["ubicacion"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							echo "<tr style=\"background-color:grey;\">";
								echo "<td><table><tr><td style=\"width:175px\">".$Certificacion."</td>";
								echo "<td>".$Estado_de_la_Certificacion."</td></tr></table></td>";
								echo "<td>".$Servicio."</td>";
								echo "<td>".$Estado_del_Servicio."</td>";
								echo "<td>".$Caracteristicas."</td>";
								echo "<td>".$Proveedor."</td>";
							echo "</tr><tr>";
								echo "<td><table cellspacing=\"2\" cellpadding=\"0\"><tr>";
								echo "<td>";
									echo "<select name=\"certificado\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqlu = "select * from sgm_clients_certificaciones order by nombre";
										$resultu = mysql_query(convert_sql($sqlu));
										while ($rowu = mysql_fetch_array($resultu)){
											if ((($rowu["predeterminado"] == 1) and ($_POST["certificado"] == "")) or ($_POST["certificado"] == $rowu["id"])) {
												echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowu["id"]."\">".$rowu["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"id_cestado\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqle = "select * from sgm_clients_certificaciones_estados where visible=1 order by nombre";
										$resulte = mysql_query(convert_sql($sqle));
										while ($rowe = mysql_fetch_array($resulte)){
											if ((($rowe["predeterminado"] == 1) and ($_POST["id_cestado"] == "")) or ($_POST["id_cestado"] == $rowe["id"])) {
												echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
											}
										}
										echo "</select>";
									echo "</td>";
								echo "</tr></table></td>";
								echo "<td>";
									echo "<select name=\"servicio\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqls = "select * from sgm_incidencias_servicios where visible=1 order by servicio";
										$results = mysql_query(convert_sql($sqls));
										while ($rows = mysql_fetch_array($results)){
											if ((($rows["predeterminado"] == 1) and($_POST["servicio"] == "")) or ($_POST["servicio"] == $rows["id"])) {
												echo "<option value=\"".$rows["id"]."\" selected>".$rows["servicio"]."</option>";
											} else {
												echo "<option value=\"".$rows["id"]."\">".$rows["servicio"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"id_sestado\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqle = "select * from sgm_incidencias_servicios_estados where visible=1 order by nombre";
										$resulte = mysql_query(convert_sql($sqle));
										while ($rowe = mysql_fetch_array($resulte)){
											if ((($rowe["predeterminado"] == 1) and ($_POST["id_sestado"] == "")) or ($_POST["id_sestado"] == $rowe["id"])) {
												echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"id_caracteristica\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqlc = "select * from sgm_incidencias_servicios_caracteristicas where visible=1 order by nombre";
										$resultc = mysql_query(convert_sql($sqlc));
										while ($rowc = mysql_fetch_array($resultc)){
											if ((($rowu["predeterminado"] == 1) and ($_POST["id_caracteristica"] == "")) or ($_POST["id_caracteristica"] == $rowc["id"])) {
												echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"id_proveedor\" style=\"width:175px\">";
										echo "<option value=\"0\">-</option>";
										$sqlp = "select * from sgm_incidencias_servicios_proveedores where visible=1 order by nombre";
										$resultp = mysql_query(convert_sql($sqlp));
										while ($rowp = mysql_fetch_array($resultp)){
											if ((($rowu["predeterminado"] == 1) and($_POST["id_proveedor"] == "")) or ($_POST["id_proveedor"] == $rowp["id"])) {
												echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowp["id"]."\">".$rowp["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							echo "<tr style=\"background-color:silver;\">";
								echo "<td style=\"text-align:right;\">".$Listar."</td>";
								echo "<td>".$Contactos."</td>";
								echo "<td>".$Incidencias."</td>";
								echo "<td>".$Desde."</td>";
								echo "<td>".$Hasta."</td>";
							echo "</tr><tr>";
								echo "<td></td>";
								echo "<td>";
									echo "<select name=\"contactes\" style=\"width:175px\">";
										echo "<option value=\"0\">NO</option>";
											if ($_POST["contactes"] == 1) {
												echo "<option value=\"1\" selected>SI</option>";
											} else {
												echo "<option value=\"1\">SI</option>";
											}
											if ($_POST["contactes"] == 2) {
												echo "<option value=\"2\" selected>".$Solo_predeterminado."</option>";
											} else {
												echo "<option value=\"2\">".$Solo_predeterminado."</option>";
											}
										echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"incidencies\" style=\"width:175px\">";
										echo "<option value=\"0\">NO</option>";
											if ($_POST["incidencies"] == 1) {
												echo "<option value=\"1\" selected>SI</option>";
											} else {
												echo "<option value=\"1\">SI</option>";
											}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<table cellpadding=\"0\" cellspacing=\"0\">";
										echo "<tr>";
											echo "<td><select name=\"dia1\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 31; $i++){
													if ($_POST["dia1"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"mes1\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 12; $i++){
													if ($_POST["mes1"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"año1\" style=\"width:60px;\">";
												echo "<option value=\"0\">-</option>";
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
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 31; $i++){
													if ($_POST["dia2"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"mes2\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 12; $i++){
													if ($_POST["mes2"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"año2\" style=\"width:60px;\">";
												echo "<option value=\"0\">-</option>";
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
							echo "</tr>";
						echo "</table>";
					echo "<br>";
						echo "<table cellpadding=\"0\" cellspacing=\"1\">";
							echo "<tr>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								for ($i = 0; $i <= 127; $i++) {
									if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
										echo "<td style=\"color:black;text-align: center;\">".chr($i)."</td>";
									}
								}
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"color:black;text-align: right;\"><strong>".$Nombre."</strong></td>";
								echo "<td style=\"color:black;text-align: leftt;width:160px\"><input type=\"Text\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\" style=\"width:150px\"></td>";
								echo "<td style=\"color:black;text-align: right;\"><strong>".$Inicial."</strong></td>";
								for ($i = 0; $i <= 127; $i++) {
									if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
										echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"".chr($i)."\"";
										if ($_POST[chr($i)] == true) { echo " checked"; }
										echo " value=\"true\" style=\"border:0px solid black\"></td>";
									}
								}
							echo "</tr>";
			echo "</table>";
			echo "<br>";
			echo "<input type=\"Submit\" value=\"".$Buscar."\" style=\"width:200px\">";
			echo "</center>";
			echo "</form>";
			echo "<br>";
		}


		##################################################
		################### BUSCADOR   ###################
		##################################################
		if (($_GET["id_classificacio"] != "") or ($_POST["tipo"] != "")) {

		$calidad = 0;
		$lletres = "";
		$sqlc = "select count(*) as total  from sgm_users_permisos_modulos where visible=1 and id_modulo=1015";
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		if ($rowc["total"] == 1) { $calidad = 1; }

		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				if ($_POST[chr($i)] == true) {
					$lletres .= $_POST[chr($i)];
				}
			}
		}

		echo "<center>";
		echo "<table>";
			echo "<tr>";
				echo "<td><strong>".$CONTACTOS."</strong>".$en_orden_alfabetico;
					for ($i = 0; $i <= 127; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							echo "<a href=\"#".chr($i)."\"><strong>".chr($i)."</strong></a>&nbsp;";
						}
					}
				echo "</td>";

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
				echo "<input type=\"Hidden\" name=\"servicio\" value=\"".$_POST["servicio"]."\">";
				echo "<input type=\"Hidden\" name=\"id_sestado\" value=\"".$_POST["id_sestado"]."\">";
				echo "<input type=\"Hidden\" name=\"id_proveedor\" value=\"".$_POST["id_proveedor"]."\">";
				echo "<input type=\"Hidden\" name=\"certificado\" value=\"".$_POST["certificado"]."\">";
				echo "<input type=\"Hidden\" name=\"id_cestado\" value=\"".$_POST["id_cestado"]."\">";
				echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$_POST["contactes"]."\">";
				echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
				echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Imprimir_Lista."\" style=\"width:150px\"></td>";
				echo "</form>";
				echo "<form action=\"index.php?op=1008&sop=5\" method=\"post\">";
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
				echo "<input type=\"Hidden\" name=\"servicio\" value=\"".$_POST["servicio"]."\">";
				echo "<input type=\"Hidden\" name=\"id_sestado\" value=\"".$_POST["id_sestado"]."\">";
				echo "<input type=\"Hidden\" name=\"id_proveedor\" value=\"".$_POST["id_proveedor"]."\">";
				echo "<input type=\"Hidden\" name=\"certificado\" value=\"".$_POST["certificado"]."\">";
				echo "<input type=\"Hidden\" name=\"id_cestado\" value=\"".$_POST["id_cestado"]."\">";
				echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$_POST["contactes"]."\">";
				echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
				echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Guardar_Busqueda."\" style=\"width:150px\"></td>";
				echo "</form>";

			echo "</tr>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:880px;\">";
		$z = 0;
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
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
				$linea_letra = 1;
				$color = "white";
				$calidad = 0;
				$sql = "select * from sgm_clients where visible=1";
				if ($_POST["tipo"] != 0) { $sql = $sql." and id_tipo=".$_POST["tipo"]; }
				if ($_POST["grupo"] != 0) { $sql = $sql." and id_grupo=".$_POST["grupo"]; }
				if ($_POST["sector"] != 0) { $sql = $sql." and sector=".$_POST["sector"]; }
				if ($_POST["ubicacion"] != 0) { $sql = $sql." and id_ubicacion=".$_POST["ubicacion"]; }
				$sql = $sql." and nombre like '".chr($i)."%'";
				if ($_POST["likenombre"] != "") {
					$sql = $sql." and (nombre like '%".$_POST["likenombre"]."%' or cognom1 like '%".$_POST["likenombre"]."%' or cognom2 like '%".$_POST["likenombre"]."%')";
				}

				$sql =$sql." order by nombre,cognom1,cognom2,id_origen";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					$ver = true;
					#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
					if ($ver_todas_letras == false) {
						if ($_POST[chr($i)] != true) {
							$ver = false;
						}
					}
					#### BUSCA TIPUS
					if (($ver == true) and (($_GET["id_classificacio"] != 0) OR ($_POST["id_classificacio"] != 0))) {
						if (($_GET["id_classificacio"] != "") OR ($_POST["id_classificacio"] != 0))  {
							if ($_GET["id_classificacio"] != "") { $id_classificacio = $_GET["id_classificacio"]; }
							if ($_POST["id_classificacio"] != "") { $id_classificacio = $_POST["id_classificacio"]; }
							$sqlcxx = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$id_classificacio;
							$resultcxx = mysql_query(convert_sql($sqlcxx));
							$rowcxx = mysql_fetch_array($resultcxx);
							if ($rowcxx["total"] <= 0) { $ver = false; }
							$sqlcxx2 = "select * from sgm_clients_classificacio_tipus where id_origen=".$id_classificacio;
							$resultcxx2 = mysql_query(convert_sql($sqlcxx2));
							while ($rowcxx2 = mysql_fetch_array($resultcxx2)) {
								$sqlcxx3 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx2["id"];
								$resultcxx3 = mysql_query(convert_sql($sqlcxx3));
								$rowcxx3 = mysql_fetch_array($resultcxx3);
								if ($rowcxx3["total"] > 0) { $ver = true; }
								$sqlcxx4 = "select * from sgm_clients_classificacio_tipus where id_origen=".$rowcxx2["id"];
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
					#### BUSCA SERVEIS
					if ($ver == true) {
						if ((($_POST["servicio"] == 0) and ($_POST["id_sestado"] == 0) and ($_POST["id_caracteristica"] == 0) and ($_POST["id_proveedor"] == 0)) OR (($_POST["servicio"] == "") and ($_POST["id_sestado"] == "") and ($_POST["id_caracteristica"] == "") and ($_POST["id_proveedor"] == ""))) {
							$ver = true;
						} else {
							$sqlmostrar = "select count(*) as total from sgm_incidencias_servicios_cliente where id_cliente=".$row["id"];
								if ($_POST["servicio"] != 0) { $sqlmostrar = $sqlmostrar." and id_servicio=".$_POST["servicio"]; }
								if ($_POST["id_sestado"] != 0) {
									$sqlmostrar = $sqlmostrar." and id_estado=".$_POST["id_sestado"];
								} else {
									$sqlmostrar = $sqlmostrar." and id_estado<>0";
								}
								if ($_POST["id_caracteristica"] != 0) { $sqlmostrar = $sqlmostrar." and id_proveedor_caracteristica=".$_POST["id_caracteristica"]; }
								if ($_POST["id_proveedor"] != 0) { $sqlmostrar = $sqlmostrar." and id_proveedor=".$_POST["id_proveedor"]; }
							$sqlmostrar = $sqlmostrar." and visible=1";
							$resultmostrar = mysql_query(convert_sql($sqlmostrar));
							$rowmostrar = mysql_fetch_array($resultmostrar);
							if ($rowmostrar["total"] <= 0) {
								$ver = false;
							}
						}
					}
					#### BUSCA CERTIFICATS
					if ($ver == true) {
						if ((($_POST["certificado"] == 0) and ($_POST["id_cestado"] == 0)) OR (($_POST["certificado"] == "") and ($_POST["id_cestado"] == ""))) {
							$ver = true;
						} else {
							$sqlmostrar = "select count(*) as total from sgm_clients_certificaciones_cliente where id_cliente=".$row["id"];
								if ($_POST["certificado"] != 0) { $sqlmostrar = $sqlmostrar." and id_certificado=".$_POST["certificado"]; }
								if ($_POST["id_cestado"] != 0) { $sqlmostrar = $sqlmostrar." and id_estado=".$_POST["id_cestado"]; }
							$resultmostrar = mysql_query(convert_sql($sqlmostrar));
							$rowmostrar = mysql_fetch_array($resultmostrar);
							if ($rowmostrar["total"] <= 0) {
								$ver = false;
							}
						}
					}
					#### INICI IMPRESIO PANTALLA
					if ($ver == true) {
						if ($linea_letra == 1) {
							echo "<tr style=\"background-color: Silver;\">";
								echo "<td><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></td>";
								echo "<td><center>Fid.</center></td>";
								echo "<td><center>Vip</center></td>";
								echo "<td><center>DE</center></td>";
								echo "<td style=\"width:500px;\"><center><em>".$Nombre_cliente."</em></center></td>";
								echo "<td><em><center>".$Telefono."</center></em></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><center><em>".$Ficha_de_Contacto."</em></center></td>";
								if ($calidad == true) {
									echo "<td></td>";
									echo "<td><em>".$Valoracion."</em></td>";
								}
							echo "</tr>";
							$linea_letra = 0;
						}
					    $desde = $_POST["año1"]."-".$_POST["mes1"]."-".$_POST["dia1"]." 00:00:00";
						$hasta = $_POST["año2"]."-".$_POST["mes2"]."-".$_POST["dia2"]." 23:59:59";
						ver_contacto($row["id"],$color,$calidad,$_POST["contactes"],$_POST["incidencies"],$desde,$hasta);
						if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
						$z++;
					}
				}
			}
		}
			#### FIN TABLA, MUESTRA NUMERO RESULTADOS Y LEYENDA
			echo "</table>";
			echo "<strong>".$Resultado_de_la_busqueda.$z."</strong>";
			echo "</center>";
			echo "<br><br>";
			echo "<img src=\"mgestion/pics/icons-mini/page_white_error.png\" border=\"0\"> - ".$Datos_fiscales_incompletos;
			echo "&nbsp;&nbsp;<strong>Fid.</strong> - ".$Cliente_fidelizado;
			echo "&nbsp;&nbsp;<strong>Vip</strong> - ".$Cliente_vip;
			echo "<img src=\"mgestion/pics/icons-mini/building_add.png\" border=\"0\"> - ".$Con_delegaciones_asociadas;
			echo "<br>";
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/email_link.png\" border=\"0\"> - ".$Email;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_link.png\" border=\"0\"> - ".$Web;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" border=\"0\"> - ".$Informacion;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"> - ".$Datos_Fiscales;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/creditcards.png\" border=\"0\"> - ".$Datos_Administrativos;
			echo "<img src=\"mgestion/pics/icons-mini/page_white_star.png\" border=\"0\"> - ".$Gestion_Comercial;
			echo "<br>";
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_medal.png\" border=\"0\"> - ".$Certificaciones;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/group.png\" border=\"0\"> - ".$Contactos;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/chart_organisation.png\" border=\"0\"> - ".$Archivos;
			if ($calidad == true) {
				echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_gear.png\" border=\"0\"> - ".$Controles_de_calidad;
			}
		}
	}

	if ($soption == 4){
		if ($_GET["id"] != ""){	$sqlc = "select * from sgm_cerques where id=".$_GET["id"];}
		else {$sqlc = "select * from sgm_cerques where id_user=".$userid." order by id asc";}
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		echo "<center>";
		echo "<table>";
			echo "<tr>";
				echo "<td><strong>".$CONTACTOS."</strong>".$en_orden_alfabetico;
					for ($i = 0; $i <= 127; $i++) {
						if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
							echo "<a href=\"#".chr($i)."\"><strong>".chr($i)."</strong></a>&nbsp;";
						}
					}
				echo "</td>";
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
				echo "<input type=\"Hidden\" name=\"servicio\" value=\"".$_POST["servicio"]."\">";
				echo "<input type=\"Hidden\" name=\"id_sestado\" value=\"".$_POST["id_sestado"]."\">";
				echo "<input type=\"Hidden\" name=\"id_proveedor\" value=\"".$_POST["id_proveedor"]."\">";
				echo "<input type=\"Hidden\" name=\"certificado\" value=\"".$_POST["certificado"]."\">";
				echo "<input type=\"Hidden\" name=\"id_cestado\" value=\"".$_POST["id_cestado"]."\">";
				echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$_POST["contactes"]."\">";
				echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
				echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Imprimir_Lista."\" style=\"width:150px\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:880px;\">";
		$z = 0;
		#### DETERMINA SI HAY FILTRO POR INICIO LETRA
		$ver_todas_letras = true;
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				if (ereg(chr($i),$rowc["lletres"])){
					$ver_todas_letras = false;
				}
			}
		}
		#### INICIA BUCLE TODAS LAS LETRAS
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
				$linea_letra = 1;
				$color = "white";
				$calidad = 0;
				$sql = "select * from sgm_clients where visible=1";
				if ($rowc["id_tipo"] != 0) { $sql = $sql." and id_tipo=".$rowc["id_tipo"]; }
				if ($rowc["id_grupo"] != 0) { $sql = $sql." and id_grupo=".$rowc["id_grupo"]; }
				if ($rowc["id_sector"] != 0) { $sql = $sql." and sector=".$rowc["id_sector"]; }
				if ($rowc["id_ubicacion"] != 0) { $sql = $sql." and id_ubicacion=".$rowc["id_ubicacion"]; }
				$sql = $sql." and nombre like '".chr($i)."%'";
				if ($rowc["likenombre"] != "") {
					$sql = $sql." and (nombre like '%".$rowc["likenombre"]."%' or cognom1 like '%".$rowc["likenombre"]."%' or cognom2 like '%".$rowc["likenombre"]."%')";
				}
				$sql =$sql." order by nombre,cognom1,cognom2,id_origen";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					$ver = true;
					#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
					if ($ver_todas_letras == false) {
						if (!ereg(chr($i),$rowc["lletres"])){
							$ver = false;
						}
					}
					#### BUSCA TIPUS
					if (($ver == true) and (($_POST["id_classificacio"] != 0) OR ($rowc["id_classificacio"] != 0))) {
						if (($_POST["id_classificacio"] != "") OR ($rowc["id_classificacio"] != 0))  {
							if ($_POST["id_classificacio"] != "") { $id_classificacio = $_POST["id_classificacio"]; }
							if ($rowc["id_classificacio"] != "") { $id_classificacio = $rowc["id_classificacio"]; }
							$sqlcxx = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$id_classificacio;
							$resultcxx = mysql_query(convert_sql($sqlcxx));
							$rowcxx = mysql_fetch_array($resultcxx);
							if ($rowcxx["total"] <= 0) { $ver = false; }
							$sqlcxx2 = "select * from sgm_clients_classificacio_tipus where id_origen=".$id_classificacio;
							$resultcxx2 = mysql_query(convert_sql($sqlcxx2));
							while ($rowcxx2 = mysql_fetch_array($resultcxx2)) {
								$sqlcxx3 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx2["id"];
								$resultcxx3 = mysql_query(convert_sql($sqlcxx3));
								$rowcxx3 = mysql_fetch_array($resultcxx3);
								if ($rowcxx3["total"] > 0) { $ver = true; }
								$sqlcxx4 = "select * from sgm_clients_classificacio_tipus where id_origen=".$rowcxx2["id"];
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
					#### BUSCA SERVEIS
					if ($ver == true) {
						if ((($rowc["servicio"] == 0) and ($rowc["id_sestado"] == 0) and ($rowc["id_caracteristica"] == 0) and ($rowc["id_proveedor"] == 0)) OR (($rowc["servicio"] == "") and ($rowc["id_sestado"] == "") and ($rowc["id_caracteristica"] == "") and ($rowc["id_proveedor"] == ""))) {
							$ver = true;
						} else {
							$sqlmostrar = "select count(*) as total from sgm_incidencias_servicios_cliente where id_cliente=".$row["id"];
								if ($rowc["id_servicio"] != 0) { $sqlmostrar = $sqlmostrar." and id_servicio=".$rowc["id_servicio"]; }
								if ($rowc["id_sestado"] != 0) {
									$sqlmostrar = $sqlmostrar." and id_estado=".$rowc["id_sestado"];
								} else {
									$sqlmostrar = $sqlmostrar." and id_estado<>0";
								}
								if ($rowc["id_caracteristica"] != 0) { $sqlmostrar = $sqlmostrar." and id_proveedor_caracteristica=".$rowc["id_caracteristica"]; }
								if ($rowc["id_proveedor"] != 0) { $sqlmostrar = $sqlmostrar." and id_proveedor=".$rowc["id_proveedor"]; }
							$sqlmostrar = $sqlmostrar." and visible=1";
							$resultmostrar = mysql_query(convert_sql($sqlmostrar));
							$rowmostrar = mysql_fetch_array($resultmostrar);
							if ($rowmostrar["total"] <= 0) {
								$ver = false;
							}
						}
					}
					#### BUSCA CERTIFICATS
					if ($ver == true) {
						if ((($rowc["id_certificado"] == 0) and ($rowc["id_cestado"] == 0)) OR (($rowc["id_certificado"] == "") and ($rowc["id_cestado"] == ""))) {
							$ver = true;
						} else {
							$sqlmostrar = "select count(*) as total from sgm_clients_certificaciones_cliente where id_cliente=".$row["id"];
								if ($rowc["id_certificado"] != 0) { $sqlmostrar = $sqlmostrar." and id_certificado=".$rowc["id_certificado"]; }
								if ($rowc["id_cestado"] != 0) { $sqlmostrar = $sqlmostrar." and id_estado=".$rowc["id_cestado"]; }
							$resultmostrar = mysql_query(convert_sql($sqlmostrar));
							$rowmostrar = mysql_fetch_array($resultmostrar);
							if ($rowmostrar["total"] <= 0) {
								$ver = false;
							}
						}
					}
					#### INICI IMPRESIO PANTALLA
					if ($ver == true) {
						if ($linea_letra == 1) {
							echo "<tr style=\"background-color: Silver;\">";
								echo "<td><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></td>";
								echo "<td><center>Fid.</center></td>";
								echo "<td><center>Vip</center></td>";
								echo "<td><center>DE</center></td>";
								echo "<td style=\"width:500px;\"><center><em>".$Nombre_cliente."</em></center></td>";
								echo "<td><em><center>".$Telefono."</center></em></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><center><em>".$Ficha_de_Contacto."</em></center></td>";
								if ($calidad == true) {
									echo "<td></td>";
									echo "<td><em>".$Valoracion."</em></td>";
								}
							echo "</tr>";
							$linea_letra = 0;
						}
						ver_contacto($row["id"],$color,$calidad,$rowc["contactes"],$rowc["incidencies"],$rowc["desde"],$rowc["hasta"]);
						if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
						$z++;
					}
				}
			}
		}
			#### FIN TABLA, MUESTRA NUMERO RESULTADOS Y LEYENDA
			echo "</table>";
			echo "<strong>".$Resultado_de_la_busqueda.$z."</strong>";
			echo "</center>";
			echo "<br><br>";
			echo "<img src=\"mgestion/pics/icons-mini/page_white_error.png\" border=\"0\"> - ".$Datos_fiscales_incompletos;
			echo "&nbsp;&nbsp;<strong>Fid.</strong> - ".$Cliente_fidelizado;
			echo "&nbsp;&nbsp;<strong>Vip</strong> - ".$Cliente_vip;
			echo "<img src=\"mgestion/pics/icons-mini/building_add.png\" border=\"0\"> - ".$Con_delegaciones_asociadas;
			echo "<br>";
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/email_link.png\" border=\"0\"> - ".$Email;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_link.png\" border=\"0\"> - ".$Web;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" border=\"0\"> - ".$Informacion;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_text.png\" border=\"0\"> - ".$Datos_Fiscales;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/creditcards.png\" border=\"0\"> - ".$Datos_Administrativos;
			echo "<img src=\"mgestion/pics/icons-mini/page_white_star.png\" border=\"0\"> - ".$Gestion_Comercial;
			echo "<br>";
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_medal.png\" border=\"0\"> - ".$Certificaciones;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/group.png\" border=\"0\"> - ".$Contactos;
			echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/chart_organisation.png\" border=\"0\"> - ".$Archivos;
			if ($calidad == true) {
				echo "&nbsp;&nbsp;<img src=\"mgestion/pics/icons-mini/page_white_gear.png\" border=\"0\"> - ".$Controles_de_calidad;
			}
	}

	if ($soption == 2) {
		$calidad = false;
		$sqlc = "select count(*) as total  from sgm_users_permisos_modulos where visible=1 and id_modulo=1015";
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		if ($rowc["total"] == 1) { $calidad = true; }
		echo "<center>";
		if ($_GET["filtro"] == "") {
			echo "<br><strong>".$CONTACTOS." ".$PERSONALES."</strong> en orden alfabético :";
			 for ($i = 0; $i <= 127; $i++) {
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
			$filtro = 0;
		} else {
			$filtro = $_GET["filtro"];
		}

	echo "<table>";
		echo "<tr>";
			echo "<td>".$por_empresa."</td>";
			echo "<td>";
				echo "<form action=\"index.php?op=1008&sop=2\" method=\"post\">";
				echo "<select name=\"id_client\" style=\"width:300px\">";
					echo "<option value=\"0\">-</option>";
					$sqle = "select * from sgm_clients where visible=1 order by nombre";
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
			echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Buscar."\" style=\"width:100px\"></td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<br>";
	echo "<table cellpadding=\"1\" cellspacing=\"0\">";
	 for ($i = 0; $i <= 127; $i++) {
		 if (((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) and (($filtro == 0) or ($filtro == $i))) {
		$sqlxt = "select count(*) as total from sgm_clients_contactos where visible=1 and nombre like '".chr($i)."%'";
		if ($_POST["id_client"] > 0){
			$sqlxt = $sqlxt." and id_client=".$_POST["id_client"];
		}
		if ($_POST["likenombre"] != ""){
			$sqlxt = $sqlxt." and (nombre like '%".$_POST["likenombre"]."%' or apellido1 like '%".$_POST["likenombre"]."%' or apellido2 like '%".$_POST["likenombre"]."%')";
		}
		$sqlxt = $sqlxt." order by nombre";
		$resultxt = mysql_query(convert_sql($sqlxt));
		$rowxt = mysql_fetch_array($resultxt);
			if ($rowxt["total"] > 0) {
				echo "<tr style=\"background-color: Silver;\">";
					echo "<td><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>".chr($i)."</strong></a></td>";
					echo "<td><center>".$Trato."</center></td>";
					echo "<td style=\"width:200px;\">".$Nombre."</td>";
					echo "<td><center>".$Telefono."</center></td>";
					echo "<td style=\"width:280px;\">".$Empresa."</td>";
					echo "<td style=\"width:150px;\">".$Cargo."</td>";
					echo "<td><em>".$Ver."</em></td></td>";
					echo "<td><em>".$Editar."</em></td>";
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
					$sqltr = "select * from sgm_clients_tratos where id=".$rowt["id_trato"];
					$resultr = mysql_query(convert_sql($sqltr));
					$rowtr = mysql_fetch_array($resultr);
					$sqlc = "select * from sgm_clients where id=".$rowt["id_client"];
					$resultc = mysql_query(convert_sql($sqlc));
					$rowc = mysql_fetch_array($resultc);
					if ($cambio == 0) { $color = "white"; $cambio = 1; } else { $color = "#F5F5F5"; $cambio = 0; }
					echo "<tr style=\"background-color:".$color."\">";
						echo "<td></td>";
						echo "<td>".$rowtr["trato"]."</td>";
						echo "<td><a href=\"index.php?op=1008&sop=260&id=".$rowt["id_client"]."\">".$rowt["nombre"]." ".$rowt["apellido1"]." ".$rowt["apellido2"]."</a></td>";
						echo "<td>".$rowt["telefono"]."</td>";
						if (strlen($rowc["nombre"]) > 35) {
							echo "<td><a href=\"index.php?op=1008&sop=201&id=".$rowt["id_client"]."\">".substr($rowc["nombre"],0,36)." ".$rowc["cognom1"]."  ".$rowc["cognom2"]." </a></td>";
						} else {
							echo "<td><a href=\"index.php?op=1008&sop=201&id=".$rowt["id_client"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]."  ".$rowc["cognom2"]." </a></td>";
						}
#						echo "<td><a href=\"index.php?op=1008&sop=201&id=".$rowt["id"]."\">".$rowc["nombre"]."</a></td>";
						if (strlen($rowt["carrec"]) > 20) {
							echo "<td>".substr($rowt["carrec"],0,21)."</td>";
						} else {
							echo "<td>".$rowt["carrec"]."</td>";
						}
#						echo "<td>".$rowt["carrec"]."</td>";
						echo "<td style=\"text-align:center;\">";
							echo "<a href=\"index.php?op=1008&sop=260&id=".$rowt["id_client"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Información\" border=\"0\"></a>&nbsp;";
						echo "</td><td style=\"text-align:center;\">";
							echo "<a href=\"index.php?op=1008&sop=261&ssop=2&id=".$rowt["id_client"]."&id_contacto=".$rowt["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Información\" border=\"0\"></a>&nbsp;";
						echo "</td>";
					echo "</tr>";
				}
			}
		}
	}
	echo "</table>";
	echo "</center>";
}

if ($soption == 5){
	if ($ssoption == 1){
		$sql = "insert into sgm_cerques (nombre,lletres,id_tipo,id_grupo,id_sector,id_ubicacion,id_classificacio,id_servicio,id_sestado,id_proveedor,id_certificado,id_cestado,contactes,likenombre) ";
		$sql = $sql."values (";
		$sql = $sql."'".$_POST["nom_cerca"]."'";
		$sql = $sql.",'".$_POST["lletres"]."'";
		$sql = $sql.",".$_POST["tipo"];
		$sql = $sql.",".$_POST["grupo"];
		$sql = $sql.",".$_POST["sector"];
		$sql = $sql.",".$_POST["ubicacion"];
		$sql = $sql.",".$_POST["id_classificacio"];
		$sql = $sql.",".$_POST["servicio"];
		$sql = $sql.",".$_POST["id_sestado"];
		$sql = $sql.",".$_POST["id_proveedor"];
		$sql = $sql.",".$_POST["certificado"];
		$sql = $sql.",".$_POST["id_cestado"];
		$sql = $sql.",".$_POST["contactes"];
		$sql = $sql.",'".$_POST["likenombre"]."'";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
	}
	if ($ssoption == 2){
		$sql = "update sgm_cerques set ";
		$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
	}
	if ($ssoption == 3){
		$sql = "delete from sgm_cerques WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
	}

	echo "<strong>".$Busquedas."</strong><br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1008&sop=3\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center><table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td><em>".$Eliminar."</em></td>";
			echo "<td>".$Nombre."</td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<form action=\"index.php?op=1008&sop=5&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"text\" name=\"nom_cerca\"></td>";
			echo "<td><input type=\"submit\" value=\"".$Guardar."\" style=\"width:100px;\"></td>";
			$lletres = "";
			for ($i = 0; $i <= 127; $i++) {
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
			echo "<input type=\"Hidden\" name=\"servicio\" value=\"".$_POST["servicio"]."\">";
			echo "<input type=\"Hidden\" name=\"id_sestado\" value=\"".$_POST["id_sestado"]."\">";
			echo "<input type=\"Hidden\" name=\"id_proveedor\" value=\"".$_POST["id_proveedor"]."\">";
			echo "<input type=\"Hidden\" name=\"certificado\" value=\"".$_POST["certificado"]."\">";
			echo "<input type=\"Hidden\" name=\"id_cestado\" value=\"".$_POST["id_cestado"]."\">";
			echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$_POST["contactes"]."\">";
			echo "<input type=\"Hidden\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\">";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_cerques where nombre<>'' order by nombre";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			echo "<form action=\"index.php?op=1008&sop=5&ssop=2&id=".$row["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=5&ssop=3&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				echo "<td><input type=\"Text\" value=\"".$row["nombre"]."\" name=\"nombre\"></td>";
				echo "<td><input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "</form>";
		}
	echo "</table></center>";
}

    if (($soption == 10) AND ($admin == true)) {
                if (($ssoption == 1) AND ($admin == true)) {
                        $sql = "update sgm_clients_grupos set ";
                        $sql = $sql."grupo='".comillas($_POST["grupo"])."'";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) AND ($admin == true)) {
                        $sql = "insert into sgm_clients_grupos (grupo) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["grupo"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 3) AND ($admin == true)) {
                        $sql = "update sgm_clients set ";
                        $sql = $sql."id_grupo=0";
                        $sql = $sql." WHERE id_grupo=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                        $sql = "delete from sgm_clients_grupos WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
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

                echo "<strong>".$Administracion." de ".$Grupos." de ".$Clientes." :</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center>";
                echo "<table cellpadding=\"0\" cellspacing=\"0\">";
                        echo "<form action=\"index.php?op=1008&sop=11&ssop=2\" method=\"post\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td></td>";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Grupo."</td>";
                                echo "<td></td>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"grupo\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "</form>";
                        $sql = "select * from sgm_clients_grupos order by grupo";
                        $result = mysql_query(convert_sql($sql));
                        while ($row = mysql_fetch_array($result)) {
                        $color = "white";
                        if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
                        echo "<tr style=\"background-color : ".$color."\">";
                                echo "<td>";
                                        if ($row["predeterminado"] == 1) {
                                                echo "<form action=\"index.php?op=1008&sop=10&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                        if ($row["predeterminado"] == 0) {
                                                echo "<form action=\"index.php?op=1008&sop=10&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                echo "</td>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=12&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<form action=\"index.php?op=1008&sop=11&ssop=1&id=".$row["id"]."\" method=\"post\">";
                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["grupo"]."\" style=\"width:200px\" name=\"grupo\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
                        echo "</form>";
                        echo "</tr>";
                        }
                echo "</table>";
                echo "</center>";
        }

        if (($soption == 12) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este grupo? (Todos los clientes del grupo quedaran como pendientes de clasificar)";
                echo "<br><br><a href=\"index.php?op=1008&sop=10&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=10\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 20) AND ($admin == true)) {
                if (($ssoption == 1) AND ($admin == true)) {
                        $sql = "update sgm_clients_sectors set ";
                        $sql = $sql."sector='".comillas($_POST["sector"])."'";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) AND ($admin == true)) {
                        $sql = "insert into sgm_clients_sectors (sector) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["sector"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 3) AND ($admin == true)) {
                        $sql = "update sgm_clients set ";
                        $sql = $sql."sector=0";
                        $sql = $sql." WHERE sector=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                        $sql = "delete from sgm_clients_sectors WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
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

                echo "<strong>".$Administracion." de ".$Sectores." de ".$Clientes." :</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center>";
                echo "<table cellpadding=\"0\" cellspacing=\"0\">";
                        echo "<form action=\"index.php?op=1008&sop=20&ssop=2\" method=\"post\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td></td>";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Sector."</td>";
                                echo "<td></td>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"sector\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "</form>";
                        $sql = "select * from sgm_clients_sectors order by sector";
                        $result = mysql_query(convert_sql($sql));
                        while ($row = mysql_fetch_array($result)) {
                        $color = "white";
                        if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
                        echo "<tr style=\"background-color : ".$color."\">";
                                echo "<td>";
                                        if ($row["predeterminado"] == 1) {
                                                echo "<form action=\"index.php?op=1008&sop=20&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                        if ($row["predeterminado"] == 0) {
                                                echo "<form action=\"index.php?op=1008&sop=20&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                echo "</td>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=21&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<form action=\"index.php?op=1008&sop=20&ssop=1&id=".$row["id"]."\" method=\"post\">";
                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["sector"]."\" style=\"width:200px\" name=\"sector\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
                        echo "</form>";
                        echo "</tr>";
                        }
                echo "</table>";
                echo "</center>";
        }

        if (($soption == 21) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este sector? (Todos los clientes del sector quedaran como pendientes de clasificar)";
                echo "<br><br><a href=\"index.php?op=1008&sop=20&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=20\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 30) AND ($admin == true)) {
                if (($ssoption == 1) AND ($admin == true)) {
                        $sql = "update sgm_clients_ubicacion set ";
                        $sql = $sql."ubicacion='".comillas($_POST["ubicacion"])."'";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) AND ($admin == true)) {
                        $sql = "insert into sgm_clients_ubicacion (ubicacion) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["ubicacion"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 3) AND ($admin == true)) {
                        $sql = "update sgm_clients set ";
                        $sql = $sql."id_ubicacion=0";
                        $sql = $sql." WHERE id_ubicacion=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                        $sql = "delete from sgm_clients_ubicacion WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
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

                echo "<strong>".$Administracion." de ".$Ubicaciones." de ".$Clientes." :</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center>";
                echo "<table cellpadding=\"0\" cellspacing=\"0\">";
                        echo "<form action=\"index.php?op=1008&sop=30&ssop=2\" method=\"post\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td></td>";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Ubicacion."</td>";
                                echo "<td></td>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"ubicacion\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "</form>";
                        $sql = "select * from sgm_clients_ubicacion order by ubicacion";
                        $result = mysql_query(convert_sql($sql));
                        while ($row = mysql_fetch_array($result)) {
                        $color = "white";
                        if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
                        echo "<tr style=\"background-color : ".$color."\">";
                                echo "<td>";
                                        if ($row["predeterminado"] == 1) {
                                                echo "<form action=\"index.php?op=1008&sop=30&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                        if ($row["predeterminado"] == 0) {
                                                echo "<form action=\"index.php?op=1008&sop=30&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                echo "</td>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=31&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<form action=\"index.php?op=1008&sop=30&ssop=1&id=".$row["id"]."\" method=\"post\">";
                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["ubicacion"]."\" style=\"width:200px\" name=\"ubicacion\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
                        echo "</form>";
                        echo "</tr>";
                        }
                echo "</table>";
                echo "</center>";
        }

        if (($soption == 31) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar esta ubicación? (Todos los clientes de esta ubicación quedaran como pendientes de clasificar)";
                echo "<br><br><a href=\"index.php?op=1008&sop=30&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=30\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 40) AND ($admin == true)) {
                if (($ssoption == 1) AND ($admin == true)) {
                        $sql = "update sgm_clients_tratos set ";
                        $sql = $sql."trato='".comillas($_POST["trato"])."'";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) AND ($admin == true)) {
                        $sql = "insert into sgm_clients_tratos (trato) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["trato"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 3) AND ($admin == true)) {
                        $sql = "update sgm_clients set ";
                        $sql = $sql."id_trato=0";
                        $sql = $sql." WHERE id_trato=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                        $sql = "delete from sgm_clients_tratos WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
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

                echo "<strong>".$Administracion." de ".$Tratos." de ".$Clientes." :</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center>";
                echo "<table cellpadding=\"0\" cellspacing=\"0\">";
                        echo "<form action=\"index.php?op=1008&sop=40&ssop=2\" method=\"post\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td></td>";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Trato."</td>";
                                echo "<td></td>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"trato\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "</form>";
                        $sql = "select * from sgm_clients_tratos order by trato";
                        $result = mysql_query(convert_sql($sql));
                        while ($row = mysql_fetch_array($result)) {
                        $color = "white";
                        if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
                        echo "<tr style=\"background-color : ".$color."\">";
                                echo "<td>";
                                        if ($row["predeterminado"] == 1) {
                                                echo "<form action=\"index.php?op=1008&sop=40&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                        if ($row["predeterminado"] == 0) {
                                                echo "<form action=\"index.php?op=1008&sop=40&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                echo "</td>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=41&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<form action=\"index.php?op=1008&sop=40&ssop=1&id=".$row["id"]."\" method=\"post\">";
                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["trato"]."\" style=\"width:200px\" name=\"trato\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
                        echo "</form>";
                        echo "</tr>";
                        }
                echo "</table>";
                echo "</center>";
        }

        if (($soption == 41) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este trato? (Todos los clientes con este trato quedarán pendientes de asignación de trato)";
                echo "<br><br><a href=\"index.php?op=1008&sop=40&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=40\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 50)) {
                if (($ssoption == 1) AND ($admin == true)) {
                        $sql = "update sgm_clients_tipos set ";
                        $sql = $sql."tipo='".comillas($_POST["tipo"])."'";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) AND ($admin == true)) {
                        $sql = "insert into sgm_clients_tipos (tipo) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["tipo"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 3) AND ($admin == true)) {
                        $sql = "update sgm_clients set ";
                        $sql = $sql."id_tipo=0";
                        $sql = $sql." WHERE id_tipo=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                        $sql = "delete from sgm_clients_tipos WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
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

                echo "<strong>".$Administracion." de ".$Tipos." de ".$Clientes." :</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center>";
                echo "<table cellpadding=\"0\" cellspacing=\"0\">";
                        echo "<form action=\"index.php?op=1008&sop=50&ssop=2\" method=\"post\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td></td>";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Tipo."</td>";
                                echo "<td></td>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"tipo\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                        echo "</form>";
                        $sql = "select * from sgm_clients_tipos order by tipo";
                        $result = mysql_query(convert_sql($sql));
                        while ($row = mysql_fetch_array($result)) {
                        $color = "white";
                        if ($row["predeterminado"] == 1) { $color = "#FF4500"; }
                        echo "<tr style=\"background-color : ".$color."\">";
                                echo "<td>";
                                        if ($row["predeterminado"] == 1) {
                                                echo "<form action=\"index.php?op=1008&sop=50&ssop=4&s=0&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                        if ($row["predeterminado"] == 0) {
                                                echo "<form action=\"index.php?op=1008&sop=50&ssop=4&s=1&id=".$row["id"]."\" method=\"post\">";
                                                echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
                                                echo "</form>";
                                        }
                                echo "</td>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=51&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<form action=\"index.php?op=1008&sop=50&ssop=1&id=".$row["id"]."\" method=\"post\">";
                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["tipo"]."\" style=\"width:200px\" name=\"tipo\"></td>";
                                echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
                        echo "</form>";
                        echo "</tr>";
                        }
                echo "</table>";
                echo "</center>";
        }

        if (($soption ==51) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este tipo? (Todos los clientes con este tipo quedarán pendientes de asignación de tipo)";
                echo "<br><br><a href=\"index.php?op=1008&sop=50&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=50\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 60)) {
			echo "<strong>".$Administracion." de ".$Definiciones." :</strong>";
			echo "<br><br>";
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
			echo "</tr></table>";
				echo "<center>";
				echo "<br><table cellpadding=\"1\" cellspacing=\"0\">";
					echo "<form action=\"index.php?op=1008&sop=60&ssop=1\" method=\"post\">";
                                echo "<tr style=\"background-color:silver\">";
                                        echo "<td><em>".$Eliminar."</em></td>";
                                        echo "<td><center><strong>".$Principal."</strong></center></td>";
                                        echo "<td><center><strong>".$Nombre."</strong></center></td>";
                                        echo "<td><center><strong>".$Color." ".$Boton."</strong></center></td>";
                                        echo "<td><center><strong>".$Color." ".$Letra."</strong></center></td>";
                                        echo "<td></td>";
                                echo "</tr>";
                                echo "<tr>";
                                        echo "<td></td>";
                                        echo "<form action=\"index.php?op=1008&sop=60&ssop=1\" method=\"post\">";
                                        echo "<td>";
                                                echo "<select name=\"id_origen\" style=\"width:200px\">";
                                                        echo "<option value=\"0\">-</option>";
                                                        $sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0";
                                                        $resultt = mysql_query(convert_sql($sqlt));
                                                        while ($rowt = mysql_fetch_array($resultt)) {
															echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
	                                                        $sqlti = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"];
															$resultti = mysql_query(convert_sql($sqlti));
															while ($rowti = mysql_fetch_array($resultti)) {
                                                                echo "<option value=\"".$rowti["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."</option>";
																$sqltip = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowti["id"];
																$resulttip = mysql_query(convert_sql($sqltip));
																while ($rowtip = mysql_fetch_array($resulttip)) {
																	echo "<option value=\"".$rowtip["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
																}
															}
                                                        }
                                                echo "</select>";
                                        echo "</td>";
                                        echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"nom\"></td>";
                                        echo "<td>&nbsp;<input type=\"text\" style=\"width:140px\" name=\"color\"></td>";
                                        echo "<td>&nbsp;<input type=\"text\" style=\"width:140px\" name=\"color_lletra\"></td>";
                                        echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:60px\"></td>";
                                echo "</tr>";
                        echo "</form>";
                        echo "<tr>";
                                echo "<td>&nbsp;</td>";
                        echo "</tr>";
                        $sql = "select * from sgm_clients_classificacio_tipus where visible=1 order by id_origen,nom";
                        $result = mysql_query(convert_sql($sql));
                        while ($row = mysql_fetch_array($result)) {
                                echo "<tr>";
                                        $sqlx = "select count(*) as total from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$row["id"];
                                        $resultx = mysql_query(convert_sql($sqlx));
                                        $rowx = mysql_fetch_array($resultx);
                                        if ($rowx["total"] == 0){
                                                echo "<td style=\"width:20px\"><center><a href=\"index.php?op=1008&sop=61&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></center></td>";
                                        } else {
                                                echo "<td></td>";
                                        }
                                        echo "<form action=\"index.php?op=1008&sop=60&ssop=2&id=".$row["id"]."\" method=\"post\">";
                                        echo "<td>";
                                                echo "<select name=\"id_origen\" style=\"width:200px\">";
                                                        echo "<option value=\"0\">-</option>";
                                                        $sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0";
                                                        $resultt = mysql_query(convert_sql($sqlt));
                                                        while ($rowt = mysql_fetch_array($resultt)) {
                                                            if ($rowt["id"] == $row["id_origen"]){
	                                                            echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nom"]."</option>";
                                                            } else {
   		                                                        echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
                                                            }
	                                                        $sqlti = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"];
															$resultti = mysql_query(convert_sql($sqlti));
															while ($rowti = mysql_fetch_array($resultti)) {
	                                                            if ($rowti["id"] == $row["id_origen"]){
    	                                                            echo "<option value=\"".$rowti["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."</option>";
   	    	                                                    } else {
	                                                                echo "<option value=\"".$rowti["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."</option>";
																}
																$sqltip = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowti["id"];
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
                                        echo "<td>&nbsp;<input type=\"text\" value=\"".$row["nom"]."\" style=\"width:200px\" name=\"nom\"></td>";
                                        if ($row["id_origen"] == 0){
                                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["color"]."\" style=\"width:140px\" name=\"color\"></td>";
                                                echo "<td>&nbsp;<input type=\"text\" value=\"".$row["color_lletra"]."\" style=\"width:140px\" name=\"color_lletra\"></td>";
                                        } else {
                                                echo "<td></td>";
                                                echo "<td></td>";
                                        }
                                        echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:60px\"></td>";
                                echo "</form>";
										echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
											echo "<a href=\"index.php?op=1008&sop=140&id_clas=".$row["id"]."\" style=\"color:white;\">".$Incompatibles."</a>";
										echo "</td>";
                                echo "</tr>";
                        }
                echo "</table></center>";
                echo "<br>* no se pueden eliminar aquellas definiciones con otras definiciones asociadas.";
				echo "<br><br><center><table>";
					echo "<tr><td style=\"background-color:silver;\">";
						echo colors2();
					echo "</td></tr>";
				echo "</table></center>";
        }

        if (($soption == 61) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este tipo cliente?";
                echo "<br><br><a href=\"index.php?op=1008&sop=60&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=60\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 70) AND ($admin == true)) {
                if (($ssoption == 1) and ($admin == true)) {
                        if ($_GET["s"] == 0){
                                $sql = "insert into sgm_clients_certificaciones (nombre) ";
                        } else {
                                $sql = "insert into sgm_clients_certificaciones_estados (nombre) ";
                        }
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["nombre"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) and ($admin == true)) {
                        if ($_GET["s"] == 0){
                                $sql = "update sgm_clients_certificaciones set ";
                        } else {
                                $sql = "update sgm_clients_certificaciones_estados set ";
                        }
                        $sql = $sql."nombre='".comillas($_POST["nombre"])."'";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 3) and ($admin == true)) {
                        if ($_GET["s"] == 0){
                                $sql = "update sgm_clients_certificaciones set ";
                        } else {
                                $sql = "update sgm_clients_certificaciones_estados set ";
                        }
                        $sql = $sql."visible=0";
                        $sql = $sql." WHERE id=".$_GET["id"]."";
                        mysql_query(convert_sql($sql));
                }

                echo "<strong>".$Gestion_Certificaciones."</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo"<table><tr><td style=\"vertical-align:top;\">";
                        echo "<center>";
                        echo "<table cellpadding=\"1\" cellspacing=\"0\">";
                        echo "<tr style=\"background-color:silver;\">";
                                echo "<td style=\"\"><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Certificacion."</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                        echo "</tr>";
                                echo "<form action=\"index.php?op=1008&sop=70&ssop=1&s=0\" method=\"post\">";
                                echo "<td></td>";
                                echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
                                echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
                                echo "<td></td>";
                                echo "</form>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                                $sql = "select * from sgm_clients_certificaciones where visible=1";
                                $result = mysql_query(convert_sql($sql));
                                while ($row = mysql_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=71&s=0&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
                                        echo "<form action=\"index.php?op=1008&sop=70&ssop=2&s=0&id=".$row["id"]."\"method=\"post\">";
                                        echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"value=\"".$row["nombre"]."\"></td>";
                                        echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
                                        echo "</form>";
                                        echo "</tr>";
                                }
                        echo "</table>";
                        echo "</center>";
                        echo "</td><td style=\"width:200px\">&nbsp;</td><td style=\"vertical-align:top;\">";
                        echo "<center>";
                        echo "<table cellpadding=\"1\" cellspacing=\"0\">";
                        echo "<tr style=\"background-color:silver;\">";
                                echo "<td style=\"\"><em>".$Eliminar."</em></td>";
                                echo "<td style=\"text-align:center;\">".$Estado." de la ".$Certificacion."</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                        echo "</tr>";
                                echo "<form action=\"index.php?op=1008&sop=70&ssop=1&s=1\" method=\"post\">";
                                echo "<td></td>";
                                echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
                                echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
                                echo "<td></td>";
                                echo "</form>";
                        echo "</tr>";
                        echo "<tr><td>&nbsp;</td></tr>";
                                $sql = "select * from sgm_clients_certificaciones_estados where visible=1";
                                $result = mysql_query(convert_sql($sql));
                                while ($row = mysql_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=71&s=1&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\"border=\"0\"></a></td>";
                                        echo "<form action=\"index.php?op=1008&sop=70&ssop=2&s=1&id=".$row["id"]."\"method=\"post\">";
                                        echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"value=\"".$row["nombre"]."\"></td>";
                                        echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
                                        echo "</form>";
                                        echo "</tr>";
                                }
                        echo "</table>";
                        echo "</center>";
                echo "</td></tr></table>";
        }

        if (($soption == 71) and ($admin == true)) {
                if ($_GET["s"] == 0){
                        echo "<center><br><br>¿Desea eliminar la certificación seleccionada?";
                        echo "<br><br><a href=\"index.php?op=1008&sop=70&ssop=3&s=0&id=".$_GET["id"]."\">[ SI ]</a>";
                } else {
                        echo "<center><br><br>¿Desea eliminar el estado certificación seleccionado?";
                        echo "<br><br><a href=\"index.php?op=1008&sop=70&ssop=3&s=1&id=".$_GET["id"]."\">[ SI ]</a>";
                }
                echo "&nbsp;<a href=\"index.php?op=1008&sop=70\">[ NO ]</a></center>";
        }

        if (($soption == 80) and ($admin == true)) {
                if ($ssoption == 1) {
                        $sql = "insert into sgm_clients_camps_dades_adicionals (nom_camp) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["nom_camp"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 2) {
                        $sql = "update sgm_clients_camps_dades_adicionals set ";
                        $sql = $sql."nom_camp='".comillas($_POST["nom_camp"])."'";
                        $sql = $sql." WHERE id=".$_POST["id"];
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 3) {
                        $sql = "delete from sgm_clients_camps_dades_adicionals WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
                }
                echo "<strong>".$Administrar." ".$Datos_Adicionales."</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center><table cellspacing=\"0\" style=\"width:300px\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"width:100px;\"><em>".$Nombre."</em></td>";
                                echo "<td style=\"width:100px;\"></td>";
                        echo "</tr>";
                        echo "<tr>";
                                echo "<form action=\"index.php?op=1008&sop=80&ssop=1\" method=\"post\">";
                                echo "<td></td>";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nom_camp\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Anadir."\"></td>";
                                echo "</form>";
                        echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
                $sql = "select * from sgm_clients_camps_dades_adicionals order by nom_camp";
                $result = mysql_query(convert_sql($sql));
                while ($row = mysql_fetch_array($result)) {
                        echo "<tr>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=81&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\"border=\"0\"></td>";
                                echo "<form action=\"index.php?op=1008&sop=80&ssop=2&id=".$_GET["id"]."\"method=\"post\">";
                                echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nom_camp\"value=\"".$row["nom_camp"]."\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Modificar."\"></td>";
                                echo "</form>";
                        echo "</tr>";
                }
                echo "</table></center>";
        }

        if ($soption == 81) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este dato adicional?";
                echo "<br><br><a href=\"index.php?op=1008&sop=80&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=80&id=".$_GET["id"]."\">[ NO ]</a>";
                echo "</center>";
        }

## NO SE UTILIZA ACTUALMENTE
	if (($soption == 99)) {
		echo "<table>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:left;width:150px\">Cliente/Proveedor</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Previsión</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Llegada</td>";
				echo "<td style=\"text-align:center;width:25px\">Emb.</td>";
				echo "<td style=\"text-align:center;width:25px\">Mat.</td>";
				echo "<td style=\"text-align:center;width:25px\">Med.</td>";
				echo "<td style=\"text-align:center;width:25px\">Aca.</td>";
				echo "<td style=\"text-align:center;width:25px\">Can.</td>";
				echo "<td style=\"text-align:center;width:25px\">Fec.</td>";
				echo "<td style=\"text-align:center;width:50px\"><strong>Total</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		$sql = "select * from sgm_control_calidad where visible=1 and id_cliente=".$_GET["id"]." order by fecha_prevision desc";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
				echo "<td></td>";
				$sqlc = "select * from sgm_clients where id=".$row["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<td><strong>".$rowc["nombre"]."</strong></td>";
				echo "<td style=\"text-align:center;width:75px\"><strong>".$row["fecha"]."</strong></td>";
				echo "<td style=\"text-align:center;width:75px\">".$row["fecha_prevision"]."</td>";
				echo "<td style=\"text-align:center;width:75px\"><strong>".$row["fecha_llegada"]."</strong></td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["embalage"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["material"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["medidas"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["acabados"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["cantidad"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["puntos_fechas"]."</td>";
				echo "<td style=\"text-align:center;width:50px\"><strong>".(10-$row["total"])."</strong></td>";
				echo "<td></td>";
			echo "</tr>";
		}
		echo "</table>";
	}




#### Añadir/Modificar CLIENTES    NO SE UTILIZA ACTUALMENTE

	if ($soption == 100)	{
			echo "<table>";
					echo "<tr><td>Cliente : </td><td>";
						if ($_GET["origen"] == 1008) {
							echo "<input type=\"Radio\" name=\"cliente\" value=\"1\" checked>SI";
							echo "<input type=\"Radio\" name=\"cliente\" value=\"0\">NO";
						}
						if ($_GET["origen"] <> 1008) {
							echo "<input type=\"Radio\" name=\"cliente\" value=\"1\">SI";
							echo "<input type=\"Radio\" name=\"cliente\" value=\"0\" checked>NO";
						}
					echo "</td></tr>";
					echo "<tr><td>Proveedor : </td><td>";
						if ($_GET["origen"] == 1010) {
							echo "<input type=\"Radio\" name=\"proveedor\" value=\"1\" checked>SI";
							echo "<input type=\"Radio\" name=\"proveedor\" value=\"0\">NO";
						}
						if ($_GET["origen"] <> 1010) {
							echo "<input type=\"Radio\" name=\"proveedor\" value=\"1\">SI";
							echo "<input type=\"Radio\" name=\"proveedor\" value=\"0\" checked>NO";
						}
					echo "</td></tr>";
					echo "<tr><td>Impacto : </td><td>";
						if ($_GET["origen"] == 1009) {
							echo "<input type=\"Radio\" name=\"impacto\" value=\"1\" checked>SI";
							echo "<input type=\"Radio\" name=\"impacto\" value=\"0\">NO";
						}
						if ($_GET["origen"] <> 1009) {
							echo "<input type=\"Radio\" name=\"impacto\" value=\"1\">SI";
							echo "<input type=\"Radio\" name=\"impacto\" value=\"0\" checked>NO";
						}
					echo "</td></tr>";
					echo "<tr><td><strong>Datos fiscales</strong></td><td></td></tr>";
					echo "<tr><td>Nombre</td><td><input type=\"Text\" name=\"nombre\" class=\"px300\"></td></tr>";
					echo "<tr><td>NIF</td><td><input type=\"Text\" name=\"nif\" class=\"px150\"></td></tr>";
					echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"direccion\" class=\"px150\"></td></tr>";
					echo "<tr><td>Población</td><td><input type=\"Text\" name=\"poblacion\" class=\"px150\"></td></tr>";
					echo "<tr><td>Codigo Postal</td><td><input type=\"Text\" name=\"cp\" class=\"px150\"></td></tr>";
					echo "<tr><td>Provincia</td><td><input type=\"Text\" name=\"provincia\" class=\"px150\"></td></tr>";
					echo "<tr><td><strong>Datos bancarios</strong></td><td></td></tr>";
					echo "<tr><td>Entidad</td><td><input type=\"Text\" name=\"entidadbancaria\" class=\"px300\"></td></tr>";
					echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"domiciliobancario\" class=\"px300\"></td></tr>";
					echo "<tr><td>Cuenta</td><td><input type=\"Text\" name=\"cuentabancaria\" class=\"px300\"></td></tr>";
					echo "<tr><td>Día de fact.</td><td>";
#					echo "<input type=\"Text\" name=\"dia_facturacion\" class=\"px150\">";

					echo "<select>";
						echo "<option value=\"0\">-<option>";
						for ($x = 1; $x < 32; $x++) { echo "<option value=\"".$x."\">".$x."<option>";	}
					echo "</select>";

					echo "</td></tr>";
					echo "<tr><td>Vencimiento</td><td><input type=\"Text\" name=\"dias_vencimiento\" class=\"px100\">&nbsp;";
						echo "<select name=\"dias\">";
								echo "<option value=\"1\" selected>Días</option>";
								echo "<option value=\"0\">Meses</option>";
						echo "</select>";
					echo "</td></tr>";
					echo "<tr><td>Cuenta Contable</td><td><input type=\"Text\" name=\"cuentacontable\" class=\"px150\"></td></tr>";
					echo "<tr><td><strong>Definición cliente</strong></td><td></td></tr>";
					echo "<tr><td>Tipo</td><td><select class=\"px150\" name=\"id_tipo\">";
						echo "<option value=\"0\">Indeterminado</option>";
						$sql = "select * from sgm_clients_tipos order by tipo";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
						}
					echo "</select></td></tr>";
					echo "<tr><td>Client Fidelizado</td><td>";
						echo "SI <input type=\"Radio\" name=\"client\" value=\"1\">";
						echo "NO <input type=\"Radio\" name=\"client\" value=\"0\" checked>";
					echo "</td></tr>";
					echo "<tr><td>Client VIP</td><td>";
						echo "Si <input type=\"Radio\" name=\"clientvip\" value=\"1\">";
						echo "No <input type=\"Radio\" name=\"clientvip\" value=\"0\" checked>";
					echo "</td></tr>";
					echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:300px\"></td></tr>";
			echo "</table>";
		echo "</td><td style=\"vertical-align:top;\">";
			echo "<table>";
					echo "<tr><td><strong>Datos adicionales</strong></td><td></td></tr>";
					echo "<tr><td>Sector</td><td><select class=\"px150\" name=\"sector\">";
						echo "<option value=\"0\">Indeterminado</option>";
						$sql = "select * from sgm_clients_sectors order by sector";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["sector"]."</option>";
						}
					echo "</select></td></tr>";
					echo "<tr><td>E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\"></td></tr>";
					echo "<tr><td>Web</td><td><input type=\"Text\" name=\"web\" class=\"px150\"></td></tr>";
					echo "<tr><td>Telefono</td><td><input type=\"Text\" name=\"telefono\" class=\"px150\"></td></tr>";
					echo "<tr><td>Notas</td><td><textarea name=\"notas\" class=\"px300\" rows=\"6\"></textarea></td></tr>";
					echo "<tr><td><strong>Datos comerciales</strong></td><td></td></tr>";
					echo "<tr><td>Nombre contacto</td><td><input type=\"Text\" name=\"contacto_nombre\" class=\"px300\"></td></tr>";
					echo "<tr><td>Telefono contacto</td><td><input type=\"Text\" name=\"contacto_telefono\" class=\"px150\"></td></tr>";
					echo "<tr><td>Mail contacto</td><td><input type=\"Text\" name=\"contacto_mail\" class=\"px150\"></td></tr>";
					echo "<tr><td>Recibir propaganda</td><td>";
						echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\"checked>";
						echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\">";
					echo "</td></tr>";
					echo "<tr><td>Notas comerciales</td><td><textarea name=\"notas_comerciales\" class=\"px300\" rows=\"6\"></textarea></td></tr>";
			echo "</table>";
		echo "</form>";
	}

## NO SE UTILIZA ACTUALMENTE
	if ($soption == 102) {
		$sql = "select * from sgm_clients where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>".$Modificar." registro en la base de datos : </strong><br><br>";
		echo "<table><tr><td style=\"vertical-align:top;\">";
			echo "<table>";
				echo "<form action=\"index.php?op=1008&sop=103&id=".$_GET["id"]."\" method=\"post\">";
				echo "<tr><td>Cliente : </td><td>";
					if ($row["cliente"] == 1) {
						echo "<input type=\"Radio\" name=\"cliente\" value=\"1\" checked>SI";
						echo "<input type=\"Radio\" name=\"cliente\" value=\"0\">NO";
					}
					if ($row["cliente"] == 0) {
						echo "<input type=\"Radio\" name=\"cliente\" value=\"1\">SI";
						echo "<input type=\"Radio\" name=\"cliente\" value=\"0\" checked>NO";
					}
				echo "</td></tr>";
				echo "<tr><td>Proveedor : </td><td>";
					if ($row["proveedor"] == 1) {
						echo "<input type=\"Radio\" name=\"proveedor\" value=\"1\" checked>SI";
						echo "<input type=\"Radio\" name=\"proveedor\" value=\"0\">NO";
					}
					if ($row["proveedor"] == 0) {
						echo "<input type=\"Radio\" name=\"proveedor\" value=\"1\">SI";
						echo "<input type=\"Radio\" name=\"proveedor\" value=\"0\" checked>NO";
					}
				echo "</td></tr>";
				echo "<tr><td>Impacto : </td><td>";
					if ($row["impacto"] == 1) {
						echo "<input type=\"Radio\" name=\"impacto\" value=\"1\" checked>SI";
						echo "<input type=\"Radio\" name=\"impacto\" value=\"0\">NO";
					}
					if ($row["impacto"] == 0) {
						echo "<input type=\"Radio\" name=\"impacto\" value=\"1\">SI";
						echo "<input type=\"Radio\" name=\"impacto\" value=\"0\" checked>NO";
					}
				echo "</td></tr>";
					echo "<tr><td><strong>Datos fiscales</strong></td><td></td></tr>";
					echo "<tr><td>Nombre</td><td><input type=\"Text\" name=\"nombre\" class=\"px300\" value=\"".$row["nombre"]."\"></td></tr>";
					echo "<tr><td>NIF</td><td><input type=\"Text\" name=\"nif\" class=\"px150\" value=\"".$row["nif"]."\"></td></tr>";
					echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"direccion\" class=\"px150\" value=\"".$row["direccion"]."\"></td></tr>";
					echo "<tr><td>Población</td><td><input type=\"Text\" name=\"poblacion\" class=\"px150\" value=\"".$row["poblacion"]."\"></td></tr>";
					echo "<tr><td>Codigo Postal</td><td><input type=\"Text\" name=\"cp\" class=\"px150\" value=\"".$row["cp"]."\"></td></tr>";
					echo "<tr><td>Provincia</td><td><input type=\"Text\" name=\"provincia\" class=\"px150\" value=\"".$row["provincia"]."\"></td></tr>";
					echo "<tr><td><strong>Datos bancarios</strong></td><td></td></tr>";
					echo "<tr><td>Entidad</td><td><input type=\"Text\" name=\"entidadbancaria\" class=\"px300\" value=\"".$row["entidadbancaria"]."\"></td></tr>";
					echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"domiciliobancario\" class=\"px300\" value=\"".$row["domiciliobancario"]."\"></td></tr>";
					echo "<tr><td>Cuenta</td><td><input type=\"Text\" name=\"cuentabancaria\" class=\"px300\" value=\"".$row["cuentabancaria"]."\"></td></tr>";
					echo "<tr><td>Día de fact.</td><td>";
					$i = 1;
					echo "<select name=\"dia_facturacion".$i."\" style=\"background-color:silver;\">";
						echo "<option value=\"0\">-</option>";
						for ($x = 1; $x < 32; $x++) { echo "<option value=\"".$x."\">".$x."</option>";	}
					echo "</select>";
					$sqlz = "select * from sgm_clients_dias_facturacion where id_cliente=".$row["id"]." order by dia";
					$resultz = mysql_query(convert_sql($sqlz));
					while ($rowz = mysql_fetch_array($resultz)) {
						$i++;
						echo "&nbsp;<select name=\"dia_facturacion".$i."\">";
							echo "<option value=\"0\">-</option>";
							for ($x = 1; $x < 32; $x++) { 
								if ($rowz["dia"] == $x) { echo "<option value=\"".$x."\" selected>".$x."</option>"; }
								else { echo "<option value=\"".$x."\">".$x."</option>"; }
							}
						echo "</select>";
					}
					echo "</td></tr>";
					echo "<tr><td>Día recibo</td><td>";
					$i = 1;
					echo "<select name=\"dia_recibo".$i."\" style=\"background-color:silver;\">";
						echo "<option value=\"0\">-</option>";
						for ($x = 1; $x < 32; $x++) { echo "<option value=\"".$x."\">".$x."</option>";	}
					echo "</select>";
					$sqlz = "select * from sgm_clients_dias_recibos where id_cliente=".$row["id"]." order by dia";
					$resultz = mysql_query(convert_sql($sqlz));
					while ($rowz = mysql_fetch_array($resultz)) {
						$i++;
						echo "&nbsp;<select name=\"dia_recibo".$i."\">";
							echo "<option value=\"0\">-</option>";
							for ($x = 1; $x < 32; $x++) { 
								if ($rowz["dia"] == $x) { echo "<option value=\"".$x."\" selected>".$x."</option>"; }
								else { echo "<option value=\"".$x."\">".$x."</option>"; }
							}
						echo "</select>";
					}
					echo "</td></tr>";
					echo "<tr><td>Vencimiento</td><td><input type=\"Text\" name=\"dias_vencimiento\" class=\"px100\" value=\"".$row["dias_vencimiento"]."\">&nbsp;";
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
					echo "</td></tr>";
					echo "<tr><td>Cuenta Contable</td><td><input type=\"Text\" name=\"cuentacontable\" class=\"px150\" value=\"".$row["cuentacontable"]."\"></td></tr>";
			echo "<tr><td><strong>Dirección de envio</strong></td><td></td></tr>";
			echo "<tr><td>Dirección por defecto</td><td><select class=\"px300\" name=\"id_direccion_envio\">";
				echo "<option value=\"0\">DIRECCIÓN DATOS FISCALES</option>";
				$sql1 = "select * from sgm_clients_envios where id_client=".$_GET["id"]." order by nombre";
				$result1 = mysql_query(convert_sql($sql1));
				while ($row1 = mysql_fetch_array($result1)) {
					if ($row1["id"] == $row["id_direccion_envio"]) { echo "<option value=\"".$row1["id"]."\" selected>".$row1["nombre"]."(".$row1["direccion"].", ".$row1["poblacion"]." (".$row1["cp"].") ".$row1["provincia"].")</option>"; }
					else { echo "<option value=\"".$row1["id"]."\">".$row1["nombre"]."(".$row1["direccion"].", ".$row1["poblacion"]." (".$row1["cp"].") ".$row1["provincia"].")</option>"; }
				}
			echo "</select></td></tr>";
					echo "<tr><td><strong>Definición cliente</strong></td><td></td></tr>";
				echo "<tr><td>Tipo</td><td><select class=\"px150\" name=\"id_tipo\">";
					echo "<option value=\"0\">Indeterminado</option>";
					$sql1 = "select * from sgm_clients_tipos order by tipo";
					$result1 = mysql_query(convert_sql($sql1));
					while ($row1 = mysql_fetch_array($result1)) {
						if ($row1["id"] == $row["id_tipo"]) { echo "<option value=\"".$row1["id"]."\" selected>".$row1["tipo"]."</option>"; }
						else { echo "<option value=\"".$row1["id"]."\">".$row1["tipo"]."</option>"; }
					}
				echo "</select></td></tr>";
				echo "<tr><td>Client Fidelizado</td><td>";
						if ($row["client"] == 1) {
							echo "SI <input type=\"Radio\" name=\"client\" value=\"1\" checked>";
							echo "NO <input type=\"Radio\" name=\"client\" value=\"0\">";
						}
						if ($row["client"] == 0) {
							echo "SI <input type=\"Radio\" name=\"client\" value=\"1\">";
							echo "NO <input type=\"Radio\" name=\"client\" value=\"0\" checked>";
						}
					echo "</td></tr>";
					echo "<tr><td>Cliente VIP</td><td>";
						if ($row["clientvip"] == 1) {
							echo "Si <input type=\"Radio\" name=\"clientvip\" value=\"1\" checked>";
							echo "No <input type=\"Radio\" name=\"clientvip\" value=\"0\">";
						}
						if ($row["clientvip"] == 0) {
							echo "Si <input type=\"Radio\" name=\"clientvip\" value=\"1\">";
							echo "No <input type=\"Radio\" name=\"clientvip\" value=\"0\" checked>";
						}
					echo "</td></tr>";
					echo "<tr><td></td><td><input type=\"Submit\" value=\"Guardar cambios\" style=\"width:300px\"></td></tr>";
				echo "</table>";
		echo "</td><td style=\"vertical-align:top\"><table>";
			echo "<tr><td><strong>Datos adicionales</strong></td><td></td></tr>";
			echo "<tr><td>Sector</td><td><select class=\"px150\" name=\"sector\">";
				echo "<option value=\"0\">Indeterminado</option>";
				$sql1 = "select * from sgm_clients_sectors order by sector";
				$result1 = mysql_query(convert_sql($sql1));
				while ($row1 = mysql_fetch_array($result1)) {
					if ($row1["id"] == $row["sector"]) { echo "<option value=\"".$row1["id"]."\" selected>".$row1["sector"]."</option>"; }
					else { echo "<option value=\"".$row1["id"]."\">".$row1["sector"]."</option>"; }
				}
			echo "</select></td></tr>";
			echo "<tr><td>E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\" value=\"".$row["mail"]."\"></td></tr>";
			echo "<tr><td>Web</td><td><input type=\"Text\" name=\"web\" class=\"px150\" value=\"".$row["web"]."\"></td></tr>";
			echo "<tr><td>Telefono</td><td><input type=\"Text\" name=\"telefono\" class=\"px150\" value=\"".$row["telefono"]."\"></td></tr>";
			echo "<tr><td>Notas</td><td><textarea name=\"notas\" class=\"px300\" rows=\"6\">".$row["notas"]."</textarea></td></tr>";
			echo "<tr><td><strong>Datos comerciales</strong></td><td></td></tr>";
			echo "<tr><td>Nombre contacto</td><td><input type=\"Text\" name=\"contacto_nombre\" class=\"px300\" value=\"".$row["contacto_nombre"]."\"></td></tr>";
			echo "<tr><td>Telefono contacto</td><td><input type=\"Text\" name=\"contacto_telefono\" class=\"px150\" value=\"".$row["contacto_telefono"]."\"></td></tr>";
			echo "<tr><td>Mail contacto</td><td><input type=\"Text\" name=\"contacto_mail\" class=\"px150\" value=\"".$row["contacto_mail"]."\"></td></tr>";
			echo "<tr><td>Recibir propaganda</td><td>";
				if ($row["propaganda"] == 1) {
					echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\" checked>";
					echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\">";
				}
				if ($row["propaganda"] == 0) {
					echo "SI <input type=\"Radio\" name=\"propaganda\" value=\"1\">";
					echo "NO <input type=\"Radio\" name=\"propaganda\" value=\"0\" checked>";
				}
			echo "</td></tr>";
			echo "<tr><td>Notas comerciales</td><td><textarea name=\"notas_comerciales\" class=\"px300\" rows=\"6\">".$row["notas_comerciales"]."</textarea></td></tr>";
			echo "<tr><td><strong>Opciones de web</strong></td><td></td></tr>";
					echo "<tr><td>Cliente en web</td><td>";
						if ($row["onweb"] == 1) {
							echo "Si <input type=\"Radio\" name=\"onweb\" value=\"1\" checked>";
							echo "No <input type=\"Radio\" name=\"onweb\" value=\"0\">";
						}
						if ($row["onweb"] == 0) {
							echo "Si <input type=\"Radio\" name=\"onweb\" value=\"1\">";
							echo "No <input type=\"Radio\" name=\"onweb\" value=\"0\" checked>";
						}
					echo "</td></tr>";
		echo "</form>";
			echo "<tr><td><strong>Logo</strong><br><a href=\"index.php?op=1011&sop=1001&id=".$row["id"]."&origen=".$_GET["origen"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td><td>";
				echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1011&sop=1000&origen=".$_GET["origen"]."\" method=\"post\">";
				echo "<center>";
				echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$row["id"]."\">";
				echo "<input type=\"Hidden\" name=\"imagen\" value=\"1\">";
				echo "<input type=\"file\" name=\"archivo\">";
				echo "<br><input type=\"submit\" value=\"Enviar\" style=\"width:100px\">";
				echo "</form>";
				if ($row["logo"] != "") { echo "<br><img src=\"pics/clientes/".$row["logo"]."\">"; }
			echo "</td></tr>";
			echo "</table>";
		echo "</td></tr></table>";
		#### DIRECCIONES DE ENVIO
		echo "<br><br><strong>Direcciones de envio : </strong><br><br>";
		$sql = "select * from sgm_clients_envios where id_client=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		echo "<table>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><em>Nombre</em></td>";
				echo "<td><em>Dirección</em></td>";
				echo "<td><em>Población</em></td>";
				echo "<td><em>CP</em></td>";
				echo "<td><em>Provincia</em></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1008&sop=110&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:100px\"></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\"></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\"></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\"></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\"></td>";
				echo "<td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:75px\"></td>";
				echo "</form>";
			echo "</tr>";
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1008&sop=111&id=".$_GET["id"]."&id_envio=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:100px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\" value=\"".$row["direccion"]."\"></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\" value=\"".$row["poblacion"]."\"></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\" value=\"".$row["cp"]."\"></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\" value=\"".$row["provincia"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:75px\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table>";
	}

## NO SE UTILIZA ACTUALMENTE
	if ($soption == 103) {
		$sql = "update sgm_clients set ";
		$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
		$sql = $sql.",nif='".$_POST["nif"]."'";
		$sql = $sql.",direccion='".comillas($_POST["direccion"])."'";
		$sql = $sql.",poblacion='".comillas($_POST["poblacion"])."'";
		$sql = $sql.",cp='".$_POST["cp"]."'";
		$sql = $sql.",entidadbancaria='".$_POST["entidadbancaria"]."'";
		$sql = $sql.",domiciliobancario='".$_POST["domiciliobancario"]."'";
		$sql = $sql.",cuentabancaria='".$_POST["cuentabancaria"]."'";
		$sql = $sql.",dias_vencimiento='".$_POST["dias_vencimiento"]."'";
		$sql = $sql.",dias=".$_POST["dias"]."";
		$sql = $sql.",cuentacontable='".$_POST["cuentacontable"]."'";
		$sql = $sql.",provincia='".comillas($_POST["provincia"])."'";
		$sql = $sql.",mail='".$_POST["mail"]."'";
		$sql = $sql.",web='".$_POST["web"]."'";
		$sql = $sql.",telefono='".$_POST["telefono"]."'";
		$sql = $sql.",notas='".comillas($_POST["notas"])."'";
		$sql = $sql.",notas_comerciales='".comillas($_POST["notas_comerciales"])."'";
		$sql = $sql.",client=".$_POST["client"]."";
		$sql = $sql.",id_tipo=".$_POST["id_tipo"]."";
		$sql = $sql.",clientvip=".$_POST["clientvip"]."";
		$sql = $sql.",sector=".$_POST["sector"]."";
		$sql = $sql.",propaganda=".$_POST["propaganda"]."";
		$sql = $sql.",contacto_nombre='".$_POST["contacto_nombre"]."'";
		$sql = $sql.",contacto_telefono='".$_POST["contacto_telefono"]."'";
		$sql = $sql.",contacto_mail='".$_POST["contacto_mail"]."'";
		$sql = $sql.",cliente=".$_POST["cliente"]."";
		$sql = $sql.",impacto=".$_POST["impacto"]."";
		$sql = $sql.",proveedor=".$_POST["proveedor"]."";
		$sql = $sql.",id_direccion_envio=".$_POST["id_direccion_envio"]."";
		$sql = $sql.",onweb=".$_POST["onweb"]."";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
#		$i = 1;
		$sqlz = "select * from sgm_clients_dias_facturacion where id_cliente=".$_GET["id"]." order by dia";
		$resultz = mysql_query(convert_sql($sqlz));
		while ($rowz = mysql_fetch_array($resultz)) {
			$i++;
			if ($_POST["dia_facturacion".$i.""] == 0) {
				$sql = "delete from sgm_clients_dias_facturacion WHERE id=".$rowz["id"];
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_clients_dias_facturacion set ";
				$sql = $sql."dia=".$_POST["dia_facturacion".$i.""]."";
				$sql = $sql." WHERE id=".$rowz["id"]."";
				mysql_query(convert_sql($sql));
			}
		}

		if ($_POST["dia_facturacion1"] != 0) {
			$sql = "insert into sgm_clients_dias_facturacion (dia,id_cliente) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["dia_facturacion1"];
			$sql = $sql.",".$_GET["id"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		$i = 1;
		$sqlz = "select * from sgm_clients_dias_recibos where id_cliente=".$_GET["id"]." order by dia";
		$resultz = mysql_query(convert_sql($sqlz));
		while ($rowz = mysql_fetch_array($resultz)) {
			$i++;
			if ($_POST["dia_recibo".$i.""] == 0) {
				$sql = "delete from sgm_clients_dias_recibos WHERE id=".$rowz["id"];
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_clients_dias_recibos set ";
				$sql = $sql."dia=".$_POST["dia_recibo".$i.""]."";
				$sql = $sql." WHERE id=".$rowz["id"]."";
				mysql_query(convert_sql($sql));
			}
		}

		if ($_POST["dia_recibo1"] != 0) {
			$sql = "insert into sgm_clients_dias_recibos (dia,id_cliente) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["dia_recibo1"];
			$sql = $sql.",".$_GET["id"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=102&id=".$_GET["id"]."\">[ Volver ]</a>";
	}


	if ($soption == 110) {
		$sql = "insert into sgm_clients_envios (nombre,direccion,poblacion,cp,provincia,id_client) ";
		$sql = $sql."values (";
		$sql = $sql."'".comillas($_POST["nombre"])."'";
		$sql = $sql.",'".comillas($_POST["direccion"])."'";
		$sql = $sql.",'".comillas($_POST["poblacion"])."'";
		$sql = $sql.",'".$_POST["cp"]."'";
		$sql = $sql.",'".comillas($_POST["provincia"])."'";
		$sql = $sql.",".$_GET["id"]."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=102&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 111) {
		$sql = "update sgm_clients_envios set ";
		$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
		$sql = $sql.",direccion='".comillas($_POST["direccion"])."'";
		$sql = $sql.",poblacion='".comillas($_POST["poblacion"])."'";
		$sql = $sql.",cp='".$_POST["cp"]."'";
		$sql = $sql.",provincia='".comillas($_POST["provincia"])."'";
		$sql = $sql." WHERE id=".$_GET["id_envio"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&&sop=102&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption >= 150) and ($soption <= 299) and  ($_GET[id] != 0) or ($soption == 550)) {
		if (($soption == 210) and ($ssoption == 1)) {
			$sql = "update sgm_clients set ";
			$sql = $sql."id_origen=".$_POST["id_origen"];
			$sql = $sql.",id_agrupacio=".$_POST["id_agrupacio"];
			$sql = $sql.",nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql.",cognom1='".comillas($_POST["cognom1"])."'";
			$sql = $sql.",cognom2='".comillas($_POST["cognom2"])."'";
			$sql = $sql.",nif='".$_POST["nif"]."'";
			$sql = $sql.",direccion='".comillas($_POST["direccion"])."'";
			$sql = $sql.",poblacion='".comillas($_POST["poblacion"])."'";
			$sql = $sql.",cp='".$_POST["cp"]."'";
			$sql = $sql.",provincia='".comillas($_POST["provincia"])."'";
			$sql = $sql.",client=".$_POST["client"];
			$sql = $sql.",clientvip=".$_POST["clientvip"];
			$sql = $sql.",sector=".$_POST["sector"];
			$sql = $sql.",id_tipo=".$_POST["id_tipo"];
			$sql = $sql.",id_grupo=".$_POST["id_grupo"];
			$sql = $sql.",id_ubicacion=".$_POST["id_ubicacion"];
			$sql = $sql.",id_pais=".$_POST["id_pais"];
			$sql = $sql.",id_idioma=".$_POST["id_idioma"];
			$sql = $sql.",mail='".$_POST["mail"]."'";
			$sql = $sql.",telefono='".$_POST["telefono"]."'";
			$sql = $sql.",fax='".$_POST["fax"]."'";
			$sql = $sql.",telefono2='".$_POST["telefono2"]."'";
			$sql = $sql.",fax2='".$_POST["fax2"]."'";
			$sql = $sql.",web='".$_POST["web"]."'";
			$sql = $sql.",notas='".comillas($_POST["notas"])."'";
			$sql = $sql.",fecha_contrac='".$_POST["fecha_contrac"]."'";
			$sql = $sql.",id_tipo_carrer=".$_POST["id_tipo_carrer"];
			$sql = $sql.",id_carrer=".$_POST["id_carrer"];
			$sql = $sql.",numero=".$_POST["numero"];
			$sql = $sql.",id_sector_zf=".$_POST["id_sector_zf"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));

			if ($_POST["id_clasificacio_tipus"] > 0){
				$total = 0;
				$total1 = 0;
				$definiciones = "";
				$sqln = "select * from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_POST["id_clasificacio_tipus"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select * from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus_neg"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$total= $total+1;
						$sqld = "select * from sgm_clients_classificacio_tipus where visible=1 and id=".$rowc["id_clasificacio_tipus"];
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$definiciones = $definiciones." ".$rowd["nom"];
					}
				}
				$sqln = "select * from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus_neg=".$_POST["id_clasificacio_tipus"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select * from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$total1= $total1+1;
						$sqld = "select * from sgm_clients_classificacio_tipus where visible=1 and id=".$rowc["id_clasificacio_tipus"];
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						$definiciones = $definiciones." ".$rowd["nom"];
					}
				}
				if (($total <= 0) and ($total1 <= 0)){
					$sqlcc = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus) ";
					$sqlcc = $sqlcc."values (";
					$sqlcc = $sqlcc."".$_GET["id"]."";
					$sqlcc = $sqlcc.",".$_POST["id_clasificacio_tipus"]."";
					$sqlcc = $sqlcc.")";
					mysql_query(convert_sql($sqlcc));
				} else {
					echo "<center><table cellspacing=\"0\" style=\"width:700px;height:70px;\">";
						echo "<tr style=\"background-color:red;\">";
							echo "<td style=\"color:white;text-align:center;\">la definición de cliente es incompatible con las ya existentes para este cliente:";
							echo "<br><br><center>".$definiciones."</center>";
							echo "<br><center><a href=\"index.php?op=1008&sop=210&ssop=3&id=".$_GET["id"]."&id_clas=".$_POST["id_clasificacio_tipus"]."\" style=\"color:white;\">[ ".$Anadir." ]</a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=210&ssop=4&id=".$_GET["id"]."&id_clas=".$_POST["id_clasificacio_tipus"]."\" style=\"color:white;\">[ ".$Anadir." ".$ygriega." eliminar incompatibles]</a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=210&id=".$_GET["id"]."\" style=\"color:white;\">[ No ".$Anadir." ]</a></center>";
						echo "</td></tr>";
					echo "</table></center>";
				}
			}
		}

		$sql = "select * from sgm_clients where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<center>";
		echo "<table cellpadding=\"0\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\">";
							echo "<a href=\"index.php?op=1008&sop=4&id=".$_GET["id_cerca"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
					echo "</table>";
				echo "</td";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=210&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Fiscales."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=220&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Administrativos."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=260&id=".$row["id"]."\" style=\"color:white;\">".$Contactos."</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=240&id=".$row["id"]."\" style=\"color:white;\">".$Gestion_Comercial."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=270&id=".$row["id"]."\" style=\"color:white;\">".$Datos_Tecnicos."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=250&id=".$row["id"]."\" style=\"color:white;\">".$Certificaciones."</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=280&ssop=1&id=".$row["id"]."\" style=\"color:white;\">".$Incidencias."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=290&id=".$row["id"]."\" style=\"color:white;\">".$Archivos."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=280&ssop=0&id=".$row["id"]."\" style=\"color:white;\">".$Historico."</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=150&id=".$row["id"]."\" style=\"color:white;\">".$Direcciones."<br>de ".$envio."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=160&id=".$row["id"]."\" style=\"color:white;\">".$Estado." de ".$Cuentas."</a></td></tr>";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=295&id=".$row["id"]."\" style=\"color:white;\">".$Agrupacion." de ".$Contactos."</a></td></tr>";
					echo "</table>";
				echo "</td>";

				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:400px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1008&sop=201&id=".$row["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</strong></a>";
					echo "<br>".$row["nif"];
					echo "<br><strong>".$row["direccion"]."</strong>";
					if ($row["cp"] != "") {echo " (".$row["cp"].") ";}
					echo "<strong>".$row["poblacion"]."</strong>";
					if ($row["provincia"] != "") {echo " (".$row["provincia"].")";}
					echo "<br>";
					if ($row["telefono"] != "") { echo "<br>".$Telefono." : <strong>".$row["telefono"]."</strong>"; }
					if ($row["mail"] != "") { echo "<br>".$Email." : <a href=\"mailto:".$row["email"]."\"><strong>".$row["mail"]."</strong></a>"; }
					if ($row["url"] != "") { echo "<br>".$Web." : <strong>".$row["url"]."</strong>"; }
					echo "<br><br>".$Otras." ".$Direcciones.":<br>";
					$sqlc = "select * from sgm_clients";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						if ($row["id_agrupacio"] > 0) {
							if (($rowc["id_agrupacio"] == $row["id_agrupacio"]) and ($row["id"] != $rowc ["id"])) {
								echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">";
								echo "<strong>".$rowc["direccion"]."</strong>";
								if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
								echo "<strong>".$rowc["poblacion"]."</strong>";
								if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
								echo "</a><br>";
							}
							if ($rowc["id"] == $row["id_agrupacio"]) {
								echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">";
								echo "(*)<strong>".$rowc["direccion"]."</strong>";
								if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
								echo "<strong>".$rowc["poblacion"]."</strong>";
								if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
								echo "</a><br>";
							}
						}
						if ($row["id_agrupacio"] == 0) {
							if (($rowc["id_agrupacio"] == $row["id"]) and ($row["id"] != $rowc ["id"])) {
								echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">";
								echo "<strong>".$rowc["direccion"]."</strong>";
								if ($rowc["cp"] != "") {echo " (".$rowc["cp"].") ";}
								echo "<strong>".$rowc["poblacion"]."</strong>";
								if ($rowc["provincia"] != "") {echo " (".$rowc["provincia"].")";}
								echo "</a><br>";
							}
						}
					}
					echo "<br>";
				echo "</td>";

				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color:#4B53AF;color:white;border:1px solid black;height:30px;\"><a href=\"index.php?op=1008&sop=550&id=".$row["id"]."\" style=\"color:white;\">".$Opciones."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"mgestion/gestion-clientes-contact-print.php?id=".$row["id"]."\" target=\"_blank\" style=\"color:white;\">".$Imprimir."</a></td>";
						echo "</tr>";
						echo "<tr>";
##							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1008&sop=230&id=".$row["id"]."\" style=\"color:white;\">Definición cliente</a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";


			echo "</tr>";
		echo "</table>";

		echo "</td></tr></table><br>";
		echo "</center>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

        if (($soption == 140) AND ($admin == true)) {
                if (($ssoption == 1) AND ($admin == true)) {
                        $sql = "insert into sgm_clients_classificacio_neg (id_clasificacio_tipus,id_clasificacio_tipus_neg) ";
                        $sql = $sql."values (";
                        $sql = $sql."".$_GET["id_clas"]."";
                        $sql = $sql.",".$_POST["id_neg"]."";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if (($ssoption == 2) AND ($admin == true)) {
                        $sql = "update sgm_clients_classificacio_neg set ";
                        $sql = $sql."visible=0";
                        $sql = $sql." WHERE id_clasificacio_tipus=".$_GET["id_clas"]." and id_clasificacio_tipus_neg=".$_GET["id_neg"]."";
                        mysql_query(convert_sql($sql));
                }

                $sql = "select * from sgm_clients_classificacio_tipus where id=".$_GET["id_clas"];
                $result = mysql_query(convert_sql($sql));
                $row = mysql_fetch_array($result);
                echo "<strong>".$Definiciones." ".$Incompatibles." : ".$row["nom"]."</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=60\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center>";
                echo "<table cellpadding=\"1\" cellspacing=\"0\">";
                        echo "<form action=\"index.php?op=1008&sop=140&ssop=1&id_clas=".$_GET["id_clas"]."\" method=\"post\">";
                                echo "<tr style=\"background-color:silver\">";
                                        echo "<td><em>".$Eliminar."</em></td>";
                                        echo "<td><center><strong>".$Incompatibles."</strong></center></td>";
                                        echo "<td></td>";
                                echo "</tr>";
                                echo "<tr>";
                                        echo "<td></td>";
                                        echo "<form action=\"index.php?op=1008&sop=140&ssop=1\" method=\"post\">";
                                        echo "<td>";
                                                echo "<select class=\"px150\" name=\"id_neg\">";
                                                        $sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id<>".$_GET["id_clas"];
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
                                        echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:60px\"></td>";
                                echo "</tr>";
                        echo "</form>";
                        echo "<tr>";
                                echo "<td>&nbsp;</td>";
                        echo "</tr>";
                        $sqln = "select * from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_GET["id_clas"];
                        $resultn = mysql_query(convert_sql($sqln));
                        while ($rown = mysql_fetch_array($resultn)) {
                                echo "<tr>";
                                        $sqlx = "select * from sgm_clients_classificacio_tipus where visible=1 and id=".$rown["id_clasificacio_tipus_neg"];
                                        $resultx = mysql_query(convert_sql($sqlx));
                                        $rowx = mysql_fetch_array($resultx);
											echo "<td style=\"width:20px\"><center><a href=\"index.php?op=1008&sop=141&id_clas=".$_GET["id_clas"]."&id_neg=".$rowx["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></center></td>";
	                                        echo "<td style=\"width:140px\">".$rowx["nom"]."</td>";
                                echo "</tr>";
                        }
                echo "</table>";
                echo "</center>";
		}

        if (($soption == 141) AND ($admin == true)) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar esta incompatibilidad?";
                echo "<br><br><a href=\"index.php?op=1008&sop=140&ssop=2&id_clas=".$_GET["id_clas"]."&id_neg=".$_GET["id_neg"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=60\">[ NO ]</a>";
                echo "</center>";
        }

	if ($soption == 150) {
		if ($ssoption == 1) {
			$sqlx = "insert into sgm_clients_envios (nombre,direccion,poblacion,cp,provincia,id_pais,id_client) ";
			$sqlx = $sqlx."values (";
			$sqlx = $sqlx."'".comillas($_POST["nombre"])."'";
			$sqlx = $sqlx.",'".comillas($_POST["direccion"])."'";
			$sqlx = $sqlx.",'".comillas($_POST["poblacion"])."'";
			$sqlx = $sqlx.",'".$_POST["cp"]."'";
			$sqlx = $sqlx.",'".comillas($_POST["provincia"])."'";
			$sqlx = $sqlx.",".$_POST["id_pais"]."";
			$sqlx = $sqlx.",".$_GET["id"]."";
			$sqlx = $sqlx.")";
			mysql_query(convert_sql($sqlx));
		}
		if ($ssoption == 2) {
			$sqlx = "update sgm_clients_envios set ";
			$sqlx = $sqlx."nombre='".comillas($_POST["nombre"])."'";
			$sqlx = $sqlx.",direccion='".comillas($_POST["direccion"])."'";
			$sqlx = $sqlx.",poblacion='".comillas($_POST["poblacion"])."'";
			$sqlx = $sqlx.",cp='".$_POST["cp"]."'";
			$sqlx = $sqlx.",provincia='".comillas($_POST["provincia"])."'";
			$sqlx = $sqlx.",id_pais=".$_POST["id_pais"];
			$sqlx = $sqlx." WHERE id=".$_GET["id_envio"];
			mysql_query(convert_sql($sqlx));
		}
		if ($ssoption == 3) {
			$sqlx = "update sgm_clients_envios set ";
			$sqlx = $sqlx."visible=0";
			$sqlx = $sqlx." WHERE id=".$_GET["id_envio"];
			mysql_query(convert_sql($sqlx));
		}
		if ($ssoption == 4) {
			$sql = "update sgm_clients_envios set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_envios set ";
			$sql = $sql."predefinido = 1";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_clients_envios set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<br><strong>".$Direcciones." de ".$envio." : </strong><br><br>";
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td></td>";
				echo "<td><em>".$Eliminar."</td>";
				echo "<td>".$Nombre."</td>";
				echo "<td>".$Direccion."</td>";
				echo "<td>".$Poblacion."</td>";
				echo "<td>".$CP."</td>";
				echo "<td>".$Provincia."</td>";
				echo "<td>".$Pais."</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1008&sop=150&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:200px\"></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\"></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\"></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\"></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\"></td>";
				echo "<td><select name=\"id_pais\" style=\"width:150px;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sys_naciones where visible=1 order by Nacion";
						$resulto = mysql_query(convert_sql($sqlo));
						while ($rowo = mysql_fetch_array($resulto)) {
							echo "<option value=\"".$rowo["CodigoNacion"]."\">".$rowo["Nacion"]."</option>";
						}
				echo "</td>";
				echo "<td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:60px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td>".$Fiscal.":</td></tr>";
			$color = "white";
			if ($row["id_direccion_envio"] == 0) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
					echo "<td>";
				if ($row["id_direccion_envio"] != 0) {
					echo "<form action=\"index.php?op=1008&sop=150&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
					echo "<input type=\"hidden\" name=\"exec_sql_1\" value=\"update sgm_clients set id_direccion_envio=0 where id=".$_GET["id"]."\">";
					echo "</form>";
				}
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:200px\" value=\"".$row["nombre"]."\" disabled></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\" value=\"".$row["direccion"]."\" disabled></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\" value=\"".$row["poblacion"]."\" disabled></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\" value=\"".$row["cp"]."\" disabled></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\" value=\"".$row["provincia"]."\" disabled></td>";
				echo "<td><select name=\"id_pais\" style=\"width:150px;\" disabled>";
					$sqlo = "select * from sys_naciones where visible=1 order by Nacion";
					$resulto = mysql_query(convert_sql($sqlo));
					while ($rowo = mysql_fetch_array($resulto)) {
						if ($rowo["CodigoNacion"] == $row["id_pais"]){
							echo "<option value=\"".$rowo["CodigoNacion"]."\" selected>".$rowo["Nacion"]."</option>";
						}
					}
				echo "</td>";
			echo "<tr><td>".$Otras."S:</td></tr>";
		$sqle = "select * from sgm_clients_envios where visible=1 and id_client=".$_GET["id"];
		$resulte = mysql_query(convert_sql($sqle));
		while ($rowe = mysql_fetch_array($resulte)) {
			$color = "white";
			if ($row["id_direccion_envio"] == $rowe["id"]) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
					echo "<td>";
				if ($row["id_direccion_envio"] == $rowe["id"]) {
#					echo "<form action=\"index.php?op=1008&sop=150&ssop=5&id=".$_GET["id"]."&id_envio=".$rowe["id"]."\" method=\"post\">";
#					echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:50px\">";
#					echo "</form>";
				}
				if ($row["id_direccion_envio"] != $rowe["id"]) {
					echo "<form action=\"index.php?op=1008&sop=150&id=".$_GET["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
					echo "<input type=\"hidden\" name=\"exec_sql_0\" value=\"update sgm_clients set id_direccion_envio=".$rowe["id"]." where id=".$_GET["id"]."\">";
					echo "</form>";
				}
			if ($row["id_direccion_envio"] != $rowe["id"]) {
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=151&id=".$_GET["id"]."&id_envio=".$rowe["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
			} else { echo "<td></td>";}
				echo "<form action=\"index.php?op=1008&sop=150&ssop=2&id=".$_GET["id"]."&id_envio=".$rowe["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:200px\" value=\"".$rowe["nombre"]."\"></td>";
				echo "<td><input type=\"text\" name=\"direccion\" style=\"width:200px\" value=\"".$rowe["direccion"]."\"></td>";
				echo "<td><input type=\"text\" name=\"poblacion\" style=\"width:105px\" value=\"".$rowe["poblacion"]."\"></td>";
				echo "<td><input type=\"text\" name=\"cp\" style=\"width:40px\" value=\"".$rowe["cp"]."\"></td>";
				echo "<td><input type=\"text\" name=\"provincia\" style=\"width:105px\" value=\"".$rowe["provincia"]."\"></td>";
				echo "<td><select name=\"id_pais\" style=\"width:150px;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sys_naciones where visible=1 order by Nacion";
						$resulto = mysql_query(convert_sql($sqlo));
						while ($rowo = mysql_fetch_array($resulto)) {
							if ($rowo["CodigoNacion"] == $rowe["id_pais"]){
								echo "<option value=\"".$rowo["CodigoNacion"]."\" selected>".$rowo["Nacion"]."</option>";
							} else {
								echo "<option value=\"".$rowo["CodigoNacion"]."\">".$rowo["Nacion"]."</option>";
							}
						}
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:60px\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table></center>";
	}


	if ($soption == 151) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta dirección de envio?";
		echo "<br><br><a href=\"index.php?op=1008&sop=150&ssop=3&id=".$_GET["id"]."&id_envio=".$_GET["id_envio"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=150&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}



	if ($soption == 160) {
		echo "<strong>".$Estado." de ".$Cuentas." del ".$Contacto." :</strong>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
		$sql = "select * from sgm_factura_tipos where visible=1 and tpv=0 order by orden,tipo";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr><td><strong>".$row["tipo"]." :</strong></td></tr>";
			$sqlf = "select * from sgm_cabezera where tipo=".$row["id"]." and visible=1 and id_cliente=".$_GET["id"]." order by fecha";;
			$resultf = mysql_query(convert_sql($sqlf));
			$poner_cabezera = 1;
			while ($rowf = mysql_fetch_array($resultf)) {
				if ($poner_cabezera == 1) {
					echo "<tr style=\"background-color:silver;\"><td style=\"width:100px;text-align:right;\">".$Numero."</td><td style=\"width:100px;text-align:right;\">".$Fecha."</td><td style=\"width:100px;text-align:right;\">".$Importe."</td><td style=\"width:100px;text-align:center;\">".$Cobrada."</td><td style=\"width:100px;text-align:center;\">".$Cerrada."</td><td style=\"width:100px;text-align:center;\">".$Confirmada."</td><td style=\"width:100px;text-align:center;\">".$Confirmada." ".$Cliente."</td></tr>";
					$poner_cabezera = 0;
				}
				echo "<tr><td style=\"text-align:right;\">".$rowf["numero"]."</td><td style=\"text-align:right;\">".$rowf["fecha"]."</td><td style=\"text-align:right;\">".$rowf["total"]."</td>";
				if ($rowf["cobrada"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				if ($rowf["cerrada"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				if ($rowf["confirmada"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				if ($rowf["confirmada_cliente"] == 1) { echo "<td style=\"background-color:green;color:black;text-align:center;\">SI</td>"; } else { echo "<td style=\"background-color:red;color:white;text-align:center;\">NO</td>"; }
				echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=22&id=".$rowf["id"]."&id_tipo=".$row["id"]."\"><input type=\"Submit\" value=\"".$Editar."\" style=\"width:50px\"></form></td>";
				echo "<td><form method=\"post\" action=\"index.php?op=1003&sop=12&id=".$rowf["id"]."&id_tipo=".$row["id"]."\"><input type=\"Submit\" value=\"".$Imprimir."\" style=\"width:50px\"></form></td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}


	if (($soption == 201) or ($soption == 240)) {
		$sql = "select * from sgm_clients where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<table style=\"background-color : Silver;width:100%\"><tr><td style=\"background-color : Silver;width:100%;text-align:left;\">";
			$sqlct = "select * from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1";
			$resultct = mysql_query(convert_sql($sqlct));
			while ($rowct = mysql_fetch_array($resultct)) {
				$sqlcla = "select * from sgm_clients_classificacio_tipus where id=".$rowct["id_clasificacio_tipus"]." and visible=1";
				$resultcla = mysql_query(convert_sql($sqlcla));
				$rowcla = mysql_fetch_array($resultcla);
				echo "<tr>";
					echo "<td><strong style=\"font : bold normal normal 12px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$rowcla["nom"]."</strong></td>";
				echo "</tr>";
			}
		echo "<tr>";
			echo "<td>";
				echo "<table style=\"width:300px;\">";
					if ($row["id_tipo"] != 0){
					$sqlt = "select * from sgm_clients_tipos where id=".$row["id_tipo"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
						echo "<tr><td style=\"text-align:right;\">Tipo :</td><td style=\"text-align:left;\"><strong>".$rowt["tipo"]."</strong></td></tr>";
					}
					if ($row["id_grupo"] != 0){
						$sqlg = "select * from sgm_clients_grupos where id=".$row["id_grupo"];
						$resultg = mysql_query(convert_sql($sqlg));
						$rowg = mysql_fetch_array($resultg);
						echo "<tr><td style=\"text-align:right;\">Grupo :</td><td style=\"text-align:left;\"><strong>".$rowg["grupo"]."</strong></td></tr>";
					}
					if ($row["sector"] != 0){
						$sqls = "select * from sgm_clients_sectors where id=".$row["sector"];
						$results = mysql_query(convert_sql($sqls));
						$rows = mysql_fetch_array($results);
						echo "<tr><td style=\"text-align:right;\">Sector :</td><td style=\"text-align:left;\"><strong>".$rows["sector"]."</strong></td></tr>";
					}
					if ($row["id_ubicacion"] != 0){
						$sqlu = "select * from sgm_clients_ubicacion where id=".$row["id_ubicacion"];
						$resultu = mysql_query(convert_sql($sqlu));
						$rowu= mysql_fetch_array($resultu);
						echo "<tr><td style=\"text-align:right;\">".$Ubicacion." :</td><td style=\"text-align:left;\"><strong>".$rowu["ubicacion"]."</strong></td></tr>";
					}
					echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Trabajadores." :</td><td style=\"text-align:left;\"><strong>".$row["num_treballadors"]."</strong></td></tr>";
				echo "</table>";
			echo "</td><td style=\"vertical-align:top;\">";
				echo "<table style=\"width:300px;\">";
					$sqlce = "select count(*) as total from sgm_clients_certificaciones_cliente where id_cliente=".$row["id"]." and id_estado<>0";
					$resultce = mysql_query(convert_sql($sqlce));
					$rowce= mysql_fetch_array($resultce);
					if ($rowce["total"] != 0){
					echo "<tr><td style=\"vertical-align:top;text-align:right;\">".$Certificaciones." :</td>";
							$sqlc = "select * from sgm_clients_certificaciones_cliente where id_cliente=".$row["id"];
							$resultc = mysql_query(convert_sql($sqlc));
							while ($rowc= mysql_fetch_array($resultc)){
								$sqlcer = "select * from sgm_clients_certificaciones where id=".$rowc["id_certificado"]." and visible=1";
								$resultcer = mysql_query(convert_sql($sqlcer));
								while ($rowcer= mysql_fetch_array($resultcer)){
									$sqlcert = "select * from sgm_clients_certificaciones_estados where id=".$rowc["id_estado"]." and visible=1";
									$resultcert = mysql_query(convert_sql($sqlcert));
									$rowcert= mysql_fetch_array($resultcert);
									echo "<td style=\"text-align:left;\"><strong>".$rowcer["nombre"]."</strong></td><td style=\"text-align:right;\">".$rowcert["nombre"]."</td>";
								}
							}
					}
					echo "</table>";
				echo "</td><td>";
					echo "<table style=\"width:300px\"></table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 210) {
		if ($ssoption == 2) {
			$sql = "update sgm_clients_classificacio set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id_clasificacio_tipus=".$_GET["id_class"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sqlcc = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus) ";
			$sqlcc = $sqlcc."values (";
			$sqlcc = $sqlcc."".$_GET["id"]."";
			$sqlcc = $sqlcc.",".$_GET["id_clas"]."";
			$sqlcc = $sqlcc.")";
			mysql_query(convert_sql($sqlcc));
		}
		if ($ssoption == 4) {
				$sqln = "select * from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus=".$_GET["id_clas"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select * from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus_neg"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$sql = "update sgm_clients_classificacio set ";
						$sql = $sql."visible=0";
						$sql = $sql." WHERE id=".$rowc["id"];
						mysql_query(convert_sql($sql));
					}
				}
				$sqln = "select * from sgm_clients_classificacio_neg where visible=1 and id_clasificacio_tipus_neg=".$_GET["id_clas"];
				$resultn = mysql_query(convert_sql($sqln));
				while ($rown = mysql_fetch_array($resultn)){
					$sqlc = "select * from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rown["id_clasificacio_tipus"];
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)){
						$sql = "update sgm_clients_classificacio set ";
						$sql = $sql."visible=0";
						$sql = $sql." WHERE id=".$rowc["id"];
						mysql_query(convert_sql($sql));
					}
				}

			$sqlcc = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus) ";
			$sqlcc = $sqlcc."values (";
			$sqlcc = $sqlcc."".$_GET["id"]."";
			$sqlcc = $sqlcc.",".$_GET["id_clas"]."";
			$sqlcc = $sqlcc.")";
			mysql_query(convert_sql($sqlcc));
		}

		if ($_GET["id"] > 0) {
			$sql = "select * from sgm_clients where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1008&sop=210&ssop=1&id=".$_GET["id"]."\"  method=\"post\">";
		} 
		if ($_GET["id"] == 0) {
			echo "<br><center><strong>Nueva ficha de contacto</strong></center><br>";
			$sql = "select * from sgm_clients where id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1008&sop=212\"  method=\"post\">";
		}
		echo "<center>";
		echo "<table><tr>";
			echo "<td style=\"vertical-align:top;\">";
				echo "<center>";
				echo "<strong>".$Datos_Fiscales."</strong>";
				echo "<table style=\"background-color : Silver;\">";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Nombre.": </td><td><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"  style=\"width:385px\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Apellido." 1: </td>";
						echo "<td style=\"text-align:left;\">";
							echo "<table cellspacing=\"0\"><tr><td><input type=\"Text\" name=\"cognom1\" value=\"".$row["cognom1"]."\" style=\"width:150px\"></td>";
							echo "<td style=\"text-align:right;width:80px\">".$Apellido." 2: </td>";
							echo "<td><input type=\"Text\" name=\"cognom2\" value=\"".$row["cognom2"]."\" style=\"width:150px\"></td></tr></table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$NIF.": </td><td><input type=\"Text\" name=\"nif\" value=\"".$row["nif"]."\" class=\"px300\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px;vertical-align:top;\">".$Direccion.": </td><td><textarea name=\"direccion\" class=\"px300\" rows=\"3\">".$row["direccion"]."</textarea></td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Direccion.": </td>";
						echo "<td style=\"text-align:left;\">";
							echo "<table cellspacing=\"0\"><tr><td>";
								echo "<select name=\"id_tipo_carrer\" style=\"width:120px\">";
									echo "<option value=\"0\">-</option>";
									$sqlo = "select * from sgm_clients_carrer_tipo where visible=1 order by nombre";
									$resulto = mysql_query(convert_sql($sqlo));
									while ($rowo = mysql_fetch_array($resulto)) {
										if ($rowo["id"] != $row["id"]) {
											if ($rowo["id"] == $row["id_tipo_carrer"]) { 
												echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>";
											}
										}
									}
								echo "</select>";
							echo "</td>";
							echo "<td style=\"text-align:right;width:60px\">".$Calle.": </td>";
							echo "<td>";
								echo "<select name=\"id_carrer\" style=\"width:200px\">";
									echo "<option value=\"0\">-</option>";
									$sqlo = "select * from sgm_clients_carrer where visible=1 order by nombre";
									$resulto = mysql_query(convert_sql($sqlo));
									while ($rowo = mysql_fetch_array($resulto)) {
										if ($rowo["id"] != $row["id"]) {
											if ($rowo["id"] == $row["id_carrer"]) { 
												echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>";
											}
										}
									}
								echo "</select>";
							echo "</td></tr></table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Numero." : </td>";
						echo "<td style=\"text-align:left;\">";
							echo "<table cellspacing=\"0\"><tr><td><input type=\"Text\" name=\"numero\" value=\"".$row["numero"]."\" style=\"width:60px\"></td>";
							echo "<td style=\"text-align:right;width:120px\">".$Sector." ".$Zona.": </td>";
							echo "<td>";
								echo "<select name=\"id_sector_zf\" style=\"width:200px\">";
									echo "<option value=\"0\">-</option>";
									$sqlo = "select * from sgm_clients_sector_zf where visible=1 order by nombre";
									$resulto = mysql_query(convert_sql($sqlo));
									while ($rowo = mysql_fetch_array($resulto)) {
										if ($rowo["id"] != $row["id"]) {
											if ($rowo["id"] == $row["id_sector_zf"]) { 
												echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>";
											}
										}
									}
								echo "</select>";
							echo "</td></tr></table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$CP.": </td><td><input type=\"Text\" name=\"cp\" value=\"".$row["cp"]."\" class=\"px300\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Poblacion.": </td><td><input type=\"Text\" name=\"poblacion\" value=\"".$row["poblacion"]."\" class=\"px300\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Provincia.": </td><td><input type=\"Text\" name=\"provincia\" value=\"".$row["provincia"]."\" class=\"px300\"></td></tr>";
				echo "</table>";
				echo "<table>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Pais.": </td><td>";
						echo "<select name=\"id_pais\" style=\"width:385px;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sys_naciones where visible=1 order by Nacion";
						$resulto = mysql_query(convert_sql($sqlo));
						while ($rowo = mysql_fetch_array($resulto)) {
							if ($_GET["id"] == 0){
								if ($rowo["predeterminado"] == 1){
									echo "<option value=\"".$rowo["CodigoNacion"]."\" selected>".$rowo["Nacion"]."</option>";
								}
							} else {
								if ($row["id_pais"] == $rowo["CodigoNacion"]){
									echo "<option value=\"".$rowo["CodigoNacion"]."\" selected>".$rowo["Nacion"]."</option>";
								}
							}
							echo "<option value=\"".$rowo["CodigoNacion"]."\">".$rowo["Nacion"]."</option>";
						}
					echo "</td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Idioma.": </td><td>";
						echo "<select name=\"id_idioma\" style=\"width:385px;\">";
						echo "<option value=\"0\">-</option>";
						$sqli = "select * from sgm_idiomas where visible=1 order by idioma";
						$resulti = mysql_query(convert_sql($sqli));
						while ($rowi = mysql_fetch_array($resulti)) {
							if ($_GET["id"] == 0){
								if ($rowi["predefinido"] == 1){
									echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["idioma"]."</option>";
								}
							} else {
								if ($row["id_idioma"] == $rowi["id"]){
									echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["idioma"]."</option>";
								}
							}
							echo "<option value=\"".$rowi["id"]."\">".$rowi["idioma"]."</option>";
						}
					echo "</td></tr>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Email."</td><td><input type=\"Text\" name=\"mail\"  style=\"width:385px\" value=\"".$row["mail"]."\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Web."</td><td><input type=\"Text\" name=\"web\"  style=\"width:385px\" value=\"".$row["web"]."\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Telefono."</td><td>";
						echo "<table cellspacing=\"0\">";
							echo "<tr><td><input type=\"Text\" name=\"telefono\" class=\"px120\" value=\"".$row["telefono"]."\"></td>";
							echo "<td style=\"text-align:right;width:100px\">".$Telefono." 2</td><td><input type=\"Text\" name=\"telefono2\"   style=\"width:120px\" value=\"".$row["telefono2"]."\"></td></tr>";
						echo "</table>";
					echo "</td></tr>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Fax."</td><td>";
						echo "<table cellspacing=\"0\">";
							echo "<tr><td><input type=\"Text\" name=\"fax\" class=\"px120\" value=\"".$row["fax"]."\"></td>";
							echo "<td style=\"text-align:right;width:100px\">".$Fax." 2</td><td><input type=\"Text\" name=\"fax2\" class=\"px120\" value=\"".$row["fax2"]."\"></td></tr>";
						echo "</table>";
					echo "</td></tr>";

				echo "</table>";

				echo "</center>";
			echo "</td>";

			echo "<td style=\"vertical-align:top\">";
				echo "<table>";

					echo "<tr><td></td><td><strong>".$Dependencias."</strong></td></tr>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Delegacion." ".$Central."</td><td>";
						echo "<select name=\"id_origen\" style=\"width:300px\"><option value=\"0\">-</option>";
							$sqlo = "select * from sgm_clients where visible=1 order by nombre";
							$resulto = mysql_query(convert_sql($sqlo));
							while ($rowo = mysql_fetch_array($resulto)) {
								if ($rowo["id"] != $row["id"]) {
									if ($rowo["id"] == $row["id_origen"]) { echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>"; }
									else { echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>"; }
								}
							}
						echo "</select>";
					echo "<tr><td style=\"text-align:right;width:150px\">".$Contacto." ".$Principal."</td><td>";
						echo "<select name=\"id_agrupacio\" style=\"width:300px\"><option value=\"0\">-</option>";
							$sqlo = "select * from sgm_clients where visible=1 order by nombre";
							$resulto = mysql_query(convert_sql($sqlo));
							while ($rowo = mysql_fetch_array($resulto)) {
								if ($rowo["id"] != $row["id"]) {
									if ($rowo["id"] == $row["id_agrupacio"]) { echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["nombre"]."</option>"; }
									else { echo "<option value=\"".$rowo["id"]."\">".$rowo["nombre"]."</option>"; }
								}
							}
						echo "</select>";
					echo "</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><strong>".$Definicion." de ".$Cliente."</strong></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td>";
					echo "<select name=\"id_clasificacio_tipus\" style=\"width:300px;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0 order by nom";
						$resulto = mysql_query(convert_sql($sqlo));
						while ($rowo = mysql_fetch_array($resulto)) {
							$sqlv = "select count(*) as total from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rowo["id"];
							$resultv = mysql_query(convert_sql($sqlv));
							$rowv = mysql_fetch_array($resultv);
							if ($rowv["total"] == 0 ){
								echo "<option value=\"".$rowo["id"]."\">".$rowo["nom"]."</option>";
							}
							$sqlo2 = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowo["id"]." order by nom";
							$resulto2 = mysql_query(convert_sql($sqlo2));
							while ($rowo2 = mysql_fetch_array($resulto2)) {
								$sqlv2 = "select count(*) as total from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rowo2["id"];
								$resultv2 = mysql_query(convert_sql($sqlv2));
								$rowv2 = mysql_fetch_array($resultv2);
								if ($rowv2["total"] == 0 ){
									echo "<option value=\"".$rowo2["id"]."\">".$rowo["nom"]."-".$rowo2["nom"]."</option>";
								}
								$sqlo3 = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowo2["id"]." order by nom";
								$resulto3 = mysql_query(convert_sql($sqlo3));
								while ($rowo3 = mysql_fetch_array($resulto3)) {
									$sqlv3 = "select count(*) as total from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"]." and id_clasificacio_tipus=".$rowo3["id"];
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

			$sqlcl = "select * from sgm_clients_classificacio where visible=1 and id_client=".$_GET["id"];
			$resultcl = mysql_query(convert_sql($sqlcl));
			while ($rowcl = mysql_fetch_array($resultcl)) {
				$sqlcla = "select * from sgm_clients_classificacio_tipus  where visible=1 and id=".$rowcl["id_clasificacio_tipus"];
				$resultcla = mysql_query(convert_sql($sqlcla));
				while ($rowcla = mysql_fetch_array($resultcla)) {
					echo "<tr>";
						echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1008&sop=216&id_class=".$rowcla["id"]."&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
						echo "<td>".$rowcla["nom"]."</td>";
							echo "</tr>";
						}
					}

					echo "<tr><td style=\"text-align:right;width:100px\">".$Cliente_fidelizado."</td><td>";
						if ($row["client"] == 1) {
							echo "SI <input type=\"Radio\" name=\"client\" value=\"1\" style=\"border:0px solid black\" checked>";
							echo "NO <input type=\"Radio\" name=\"client\" value=\"0\" style=\"border:0px solid black\">";
						}
						if ($row["client"] == 0) {
							echo "SI <input type=\"Radio\" name=\"client\" value=\"1\" style=\"border:0px solid black\">";
							echo "NO <input type=\"Radio\" name=\"client\" value=\"0\" style=\"border:0px solid black\" checked>";
						}
					echo "</td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Cliente_vip."</td><td>";
						if ($row["clientvip"] == 1) {
							echo "SI <input type=\"Radio\" name=\"clientvip\" value=\"1\" style=\"border:0px solid black\" checked>";
							echo "NO <input type=\"Radio\" name=\"clientvip\" value=\"0\" style=\"border:0px solid black\">";
						}
						if ($row["clientvip"] == 0) {
							echo "SI <input type=\"Radio\" name=\"clientvip\" value=\"1\" style=\"border:0px solid black\">";
							echo "NO <input type=\"Radio\" name=\"clientvip\" value=\"0\" style=\"border:0px solid black\" checked>";
						}
					echo "</td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Tipo."</td><td><select style=\"width:300px;\" name=\"id_tipo\">";
						echo "<option value=\"0\">Indeterminado</option>";
						$sql1 = "select * from sgm_clients_tipos order by tipo";
						$result1 = mysql_query(convert_sql($sql1));
						while ($row1 = mysql_fetch_array($result1)) {
							if (($row1["id"] == $row["id_tipo"]) or (($row1["predeterminado"] == 1) and ($_GET["id"] == 0))) {
								echo "<option value=\"".$row1["id"]."\" selected>".$row1["tipo"]."</option>";
							} else {
								echo "<option value=\"".$row1["id"]."\">".$row1["tipo"]."</option>";
							}
						}
					echo "</select></td></tr>";

					echo "<tr><td style=\"text-align:right;width:100px\">".$Grupo."</td><td><select style=\"width:300px;\" name=\"id_grupo\">";
					echo "<option value=\"0\">Indeterminado</option>";
						$sql1 = "select * from sgm_clients_grupos order by grupo";
						$result1 = mysql_query(convert_sql($sql1));
						while ($row1 = mysql_fetch_array($result1)) {
							if (($row1["id"] == $row["id_grupo"]) or (($row1["predeterminado"] == 1) and ($_GET["id"] == 0))) {
								echo "<option value=\"".$row1["id"]."\" selected>".$row1["grupo"]."</option>";
							} else {
								echo "<option value=\"".$row1["id"]."\">".$row1["grupo"]."</option>";
							}
						}
					echo "</select></td></tr>";

					echo "<tr><td style=\"text-align:right;width:100px\">".$Sector."</td><td><select style=\"width:300px;\" name=\"sector\">";
						echo "<option value=\"0\">Indeterminado</option>";
						$sql1 = "select * from sgm_clients_sectors order by sector";
						$result1 = mysql_query(convert_sql($sql1));
						while ($row1 = mysql_fetch_array($result1)) {
							if (($row1["id"] == $row["sector"]) or (($row1["predeterminado"] == 1) and ($_GET["id"] == 0))) {
								echo "<option value=\"".$row1["id"]."\" selected>".$row1["sector"]."</option>";
							} else {
								echo "<option value=\"".$row1["id"]."\">".$row1["sector"]."</option>";
							}
						}
					echo "</select></td></tr>";

					echo "<tr><td style=\"text-align:right;width:100px\">".$Ubicacion."</td><td><select style=\"width:300px;\" name=\"id_ubicacion\">";
						echo "<option value=\"0\">Indeterminado</option>";
						$sql1 = "select * from sgm_clients_ubicacion order by ubicacion";
						$result1 = mysql_query(convert_sql($sql1));
						while ($row1 = mysql_fetch_array($result1)) {
							if (($row1["id"] == $row["id_ubicacion"]) or (($row1["predeterminado"] == 1) and ($_GET["id"] == 0))) {
								echo "<option value=\"".$row1["id"]."\" selected>".$row1["ubicacion"]."</option>";
							} else {
								echo "<option value=\"".$row1["id"]."\">".$row1["ubicacion"]."</option>";
							}
						}
					echo "</select></td></tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr></table></center>";
		echo "<center><table>";
			echo "<tr>";
				echo "<td style=\"text-align:right;width:300px;vertical-align:top;\">".$Notas.": </td>";
				echo "<td><textarea name=\"notas\" style=\"width:783px\" rows=\"2\">".$row["notas"]."</textarea></td>";
				echo "<td style=\"width:200px\"></td>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
		if ($_GET["id"] > 0) { echo "<center><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:300px\"></center>"; }
		if ($_GET["id"] == 0) {	echo "<center><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:300px\"></center>"; }
		echo "</form>";
	}

	if ($soption == 212) {
		$sql = "insert into sgm_clients (id_origen,id_agrupacio,nombre,cognom1,cognom2,nif,direccion,poblacion,cp,provincia,client,clientvip,id_tipo_carrer,id_carrer,numero,id_sector_zf,sector,id_tipo,id_grupo,id_ubicacion,id_pais,id_idioma,mail,telefono,telefono2,fax,fax2,web,notas,general,servicio,fecha_contrac)";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_origen"];
		$sql = $sql.",".$_POST["id_agrupacio"];
		$sql = $sql.",'".comillas($_POST["nombre"])."'";
		$sql = $sql.",'".comillas($_POST["cognom1"])."'";
		$sql = $sql.",'".comillas($_POST["cognom2"])."'";
		$sql = $sql.",'".$_POST["nif"]."'";
		$sql = $sql.",'".comillas($_POST["direccion"])."'";
		$sql = $sql.",'".comillas($_POST["poblacion"])."'";
		$sql = $sql.",'".$_POST["cp"]."'";
		$sql = $sql.",'".comillas($_POST["provincia"])."'";

		$sql = $sql.",".$_POST["client"];
		$sql = $sql.",".$_POST["clientvip"];
		$sql = $sql.",".$_POST["id_tipo_carrer"];
		$sql = $sql.",".$_POST["id_carrer"];
		$sql = $sql.",".$_POST["numero"];
		$sql = $sql.",".$_POST["id_sector_zf"];
		$sql = $sql.",".$_POST["sector"];
		$sql = $sql.",".$_POST["id_tipo"];
		$sql = $sql.",".$_POST["id_grupo"];
		$sql = $sql.",".$_POST["id_ubicacion"];

		$sql = $sql.",".$_POST["id_pais"]."";
		$sql = $sql.",".$_POST["id_idioma"]."";
		$sql = $sql.",'".$_POST["mail"]."'";
		$sql = $sql.",'".$_POST["telefono"]."'";
		$sql = $sql.",'".$_POST["telefono2"]."'";
		$sql = $sql.",'".$_POST["fax"]."'";
		$sql = $sql.",'".$_POST["fax2"]."'";
		$sql = $sql.",'".$_POST["web"]."'";
		$sql = $sql.",'".comillas($_POST["notas"])."'";

		if ($_POST["general"] == "") { $sql = $sql.",0"; }
		if ($_POST["general"] == 1) { $sql = $sql.",1"; }
		
		if ($_POST["servicio"] == "") { $sql = $sql.",0"; }
		if ($_POST["servicio"] == 1) { $sql = $sql.",1"; }
		$sql = $sql.",'".$_POST["fecha_contrac"]."'";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));

		$sql = "select * from sgm_clients where visible=1 order by id desc";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);

			$sqlcc = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus) ";
			$sqlcc = $sqlcc."values (";
			$sqlcc = $sqlcc."".$row["id"]."";
			$sqlcc = $sqlcc.",".$_POST["id_clasificacio_tipus"]."";
			$sqlcc = $sqlcc.")";
			mysql_query(convert_sql($sqlcc));


		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=210&id=".$row["id"]."\">[ Volver ]</a>";
		echo "&nbsp;<a href=\"index.php?op=1008&sop=260&id=".$row["id"]."\">[ Continuar ]</a>";
		echo "</center>";
	}

	if ($soption == 213) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este cliente?";
		echo "<br><br><a href=\"index.php?op=1008&sop=214&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=210&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 214) {
		$sql = "update sgm_clients set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=0\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 216) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea quitar la definición del cliente?";
		echo "<br><br><a href=\"index.php?op=1008&sop=210&ssop=2&id=".$_GET["id"]."&id_class=".$_GET["id_class"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=210&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 220) {
		$sql = "select * from sgm_clients where id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<table style=\"width:100%\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;\">";

					echo "<table cellspacing=\"0\" style=\"width:325px\">";
						echo "<tr>";
							echo "<td><strong>Datos de facturación : </strong></td>";
						echo "</tr>";
						echo "<form action=\"index.php?op=1008&sop=221&id=".$_GET["id"]."\" method=\"post\">";
						echo "<tr>";
							echo "<td>Día de fact.</td>";
							echo "<td>";
								$i = 1;
								echo "<select name=\"dia_facturacion".$i."\" style=\"background-color:silver;\">";
									echo "<option value=\"0\">-</option>";
									for ($x = 1; $x < 32; $x++) { echo "<option value=\"".$x."\">".$x."</option>";	}
								echo "</select>";
								$sqlz = "select * from sgm_clients_dias_facturacion where id_cliente=".$row["id"]." order by dia";
								$resultz = mysql_query(convert_sql($sqlz));
								while ($rowz = mysql_fetch_array($resultz)) {
									$i++;
									echo "&nbsp;<select name=\"dia_facturacion".$i."\">";
										echo "<option value=\"0\">-</option>";
										for ($x = 1; $x < 32; $x++) { 
											if ($rowz["dia"] == $x) { echo "<option value=\"".$x."\" selected>".$x."</option>";
											} else { echo "<option value=\"".$x."\">".$x."</option>";
											}
										}
									echo "</select>";
								}
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>Día recibo</td>";
							echo "<td>";
								$i = 1;
								echo "<select name=\"dia_recibo".$i."\" style=\"background-color:silver;\">";
									echo "<option value=\"0\">-</option>";
									for ($x = 1; $x < 32; $x++) { echo "<option value=\"".$x."\">".$x."</option>";	}
								echo "</select>";
								$sqlz = "select * from sgm_clients_dias_recibos where id_cliente=".$row["id"]." order by dia";
								$resultz = mysql_query(convert_sql($sqlz));
								while ($rowz = mysql_fetch_array($resultz)) {
									$i++;
									echo "&nbsp;<select name=\"dia_recibo".$i."\">";
										echo "<option value=\"0\">-</option>";
										for ($x = 1; $x < 32; $x++) { 
											if ($rowz["dia"] == $x) { echo "<option value=\"".$x."\" selected>".$x."</option>";
											} else { echo "<option value=\"".$x."\">".$x."</option>";
											}
										}
									echo "</select>";
								}
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>Vencimiento</td>";
							echo "<td><input type=\"Text\" name=\"dias_vencimiento\" class=\"px100\" value=\"".$row["dias_vencimiento"]."\">&nbsp;";
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
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>Cuenta Contable</td><td><input type=\"Text\" name=\"cuentacontable\" class=\"px150\" value=\"".$row["cuentacontable"]."\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td><input type=\"submit\" value=\"Guardar cambios\"></td>";
						echo "</tr>";
					echo "</form>";
					echo "</table>";

				echo "</td>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;\">";

					$sql = "select * from sgm_clients where id=".$_GET["id"];
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<form action=\"index.php?op=1008&sop=222&id=".$_GET["id"]."\"  method=\"post\">";
					echo "<center>";
					echo "<table style=\"width:325px\">";
						echo "<tr>";
							echo "<td></td>";
							echo "<td><strong>Datos bancarios : </strong></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-align:right\">Entidad: </td>";
							echo "<td><input type=\"text\" name=\"entidadbancaria\" style=\"width:200px\" value=\"".$row["entidadbancaria"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td style=\"text-align:right\">Dirección: </td>";
							echo "<td><input type=\"Text\" name=\"domiciliobancario\" style=\"width:200px\" value=\"".$row["domiciliobancario"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td style=\"text-align:right\">Cuenta: </td>";
							echo "<td><input type=\"Text\" name=\"cuentabancaria\" style=\"width:200px\" value=\"".$row["cuentabancaria"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td><input type=\"submit\" value=\"Guardar\" style=\"width:100px\"></td>";
						echo "</tr>";
					echo "</table>";
					echo "</center>";
					echo "</form>";

				echo "</td></tr><tr>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;\">";


					echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<form action=\"index.php?op=1008&sop=225&id=".$_GET["id"]."\" method=\"post\">";
						echo "<tr style=\"background-color:silver\">";
							echo "<td></td>";
							echo "<td><em>".$Eliminar."</em></td>";
							echo "<td style=\"text-align:center;\">Tarifa</td>";
							echo "<td></td>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><select style=\"width:200px\" name=\"id_tarifa\">";
								$sqlt = "select * from sgm_tarifas where visible=1";
								$resultt = mysql_query(convert_sql($sqlt));
								while ($rowt = mysql_fetch_array($resultt)){
									echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
								}
							echo "</td>";
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						echo "</form>";
						$sqltc = "select * from sgm_tarifas_clients";
						$resulttc = mysql_query(convert_sql($sqltc));
						while ($rowtc = mysql_fetch_array($resulttc)) {
						$color = "white";
						if ($rowtc["predeterminado"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
							echo "<td>";
								if ($rowtc["predeterminado"] == 0) {
									echo "<form action=\"index.php?op=1008&sop=228&id=".$_GET["id"]."&id_tarifa=".$rowtc["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:50px\">";
									echo "</form>";
									echo "</td>";
									echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=226&id=".$_GET["id"]."&id_tarifa=".$rowtc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
								} else {
									echo "</td>";
									echo "<td></td>";
								}
							$sqlt = "select * from sgm_tarifas where visible=1 and id=".$rowtc["id_tarifa"]."";
							$resultt = mysql_query(convert_sql($sqlt));
							$rowt = mysql_fetch_array($resultt);
							echo "<td>&nbsp;<input type=\"text\" value=\"".$rowt["nombre"]."\" style=\"width:200px\" name=\"nombre\"></td>";
						echo "</tr>";
						}
					echo "</table>";

				echo "</td>";
				echo "<td style=\"vertical-align:top;width:50%;text-align:center;\">";

					$sql = "select * from sgm_clients where id=".$_GET["id"];
					$result = mysql_query(convert_sql($sql));
					$row = mysql_fetch_array($result);
					echo "<form action=\"index.php?op=1008&sop=223&id=".$_GET["id"]."\"  method=\"post\">";
					echo "<center>";
					echo "<table style=\"width:325px\">";
						echo "<tr>";
							echo "<td></td>";
							echo "<td><strong>Costes Adicionales : </strong></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-align:right\">Coste €/Kg.: </td>";
							echo "<td><input type=\"text\" name=\"coste_ekl\" style=\"width:200px\" value=\"".$row["coste_ekl"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td style=\"text-align:right\">Coste €/m&sup3;: </td>";
							echo "<td><input type=\"Text\" name=\"coste_em3\" style=\"width:200px\" value=\"".$row["coste_em3"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td style=\"text-align:right\">Coste 1000€/dia: </td>";
							echo "<td><input type=\"Text\" name=\"coste_miledia\" style=\"width:200px\" value=\"".$row["coste_miledia"]."\" class=\"px200\"></td>";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td><input type=\"submit\" value=\"Guardar\" style=\"width:100px\"></td>";
						echo "</tr>";
					echo "</table>";
					echo "</center>";
					echo "</form>";



				echo "</td>";
			echo "</tr>";
		echo "</table>";

		}

	if ($soption == 221) {
		$sql = "update sgm_clients set ";
		$sql = $sql."dias_vencimiento='".$_POST["dias_vencimiento"]."'";
		$sql = $sql.",dias=".$_POST["dias"]."";
		$sql = $sql.",cuentacontable='".$_POST["cuentacontable"]."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));

		$i = 1;
		$sqlz = "select * from sgm_clients_dias_facturacion where id_cliente=".$_GET["id"]." order by dia";
		$resultz = mysql_query(convert_sql($sqlz));
		while ($rowz = mysql_fetch_array($resultz)) {
			$i++;
			if ($_POST["dia_facturacion".$i.""] == 0) {
				$sql = "delete from sgm_clients_dias_facturacion WHERE id=".$rowz["id"];
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_clients_dias_facturacion set ";
				$sql = $sql."dia=".$_POST["dia_facturacion".$i.""]."";
				$sql = $sql." WHERE id=".$rowz["id"]."";
				mysql_query(convert_sql($sql));
			}
		}

		if ($_POST["dia_facturacion1"] != 0) {
			$sql = "insert into sgm_clients_dias_facturacion (dia,id_cliente) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["dia_facturacion1"];
			$sql = $sql.",".$_GET["id"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		$i = 1;
		$sqlz = "select * from sgm_clients_dias_recibos where id_cliente=".$_GET["id"]." order by dia";
		$resultz = mysql_query(convert_sql($sqlz));
		while ($rowz = mysql_fetch_array($resultz)) {
			$i++;
			if ($_POST["dia_recibo".$i.""] == 0) {
				$sql = "delete from sgm_clients_dias_recibos WHERE id=".$rowz["id"];
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_clients_dias_recibos set ";
				$sql = $sql."dia=".$_POST["dia_recibo".$i.""]."";
				$sql = $sql." WHERE id=".$rowz["id"]."";
				mysql_query(convert_sql($sql));
			}
		}

		if ($_POST["dia_recibo1"] != 0) {
			$sql = "insert into sgm_clients_dias_recibos (dia,id_cliente) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["dia_recibo1"];
			$sql = $sql.",".$_GET["id"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}


	if ($soption == 222) {
		$sql = "update sgm_clients set ";
		$sql = $sql."entidadbancaria='".$_POST["entidadbancaria"]."'";
		$sql = $sql.",domiciliobancario='".$_POST["domiciliobancario"]."'";
		$sql = $sql.",cuentabancaria='".$_POST["cuentabancaria"]."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 223) {
		$sql = "update sgm_clients set ";
		$sql = $sql."coste_ekl=".$_POST["coste_ekl"];
		$sql = $sql.",coste_em3=".$_POST["coste_em3"];
		$sql = $sql.",coste_miledia=".$_POST["coste_miledia"];
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 225) {
		$sqltc = "select count(*) as total from sgm_tarifas_clients where predeterminado=1";
		$resulttc = mysql_query(convert_sql($sqltc));
		$rowtc = mysql_fetch_array($resulttc);
			if ($rowtc["total"]== 0){
				$sql = "insert into sgm_tarifas_clients (id_tarifa,id_cliente,predeterminado) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["id_tarifa"]."";
				$sql = $sql.",".$_GET["id"]."";
				$sql = $sql.",1";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "insert into sgm_tarifas_clients (id_tarifa,id_cliente) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["id_tarifa"]."";
				$sql = $sql.",".$_GET["id"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 226) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta tarifa?";
		echo "<br><br><a href=\"index.php?op=1008&sop=227&id=".$_GET["id"]."&id_tarifa=".$_GET["id_tarifa"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 227) {
		$sql = "delete from sgm_tarifas_clients WHERE id=".$_GET["id_tarifa"];
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 228) {
		$sql = "update sgm_tarifas_clients set ";
		$sql = $sql."predeterminado = 0";
		$sql = $sql." WHERE id<>".$_GET["id_tarifa"]."";
		mysql_query(convert_sql($sql));
		$sql = "update sgm_tarifas_clients set ";
		$sql = $sql."predeterminado = 1";
		$sql = $sql." WHERE id=".$_GET["id_tarifa"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=220&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 240) {
		if ($ssoption == 1) {
			$sql = "select * from sgm_incidencias_servicios where visible=1 order by codigo,servicio";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqlx = "select count(*) as total from sgm_incidencias_servicios_cliente where id_servicio=".$row["id"]." and id_cliente=".$_GET["id"];
				$resultx = mysql_query(convert_sql($sqlx));
				$rowx = mysql_fetch_array($resultx);
				if ($rowx["total"] == 0) {
					$sql = "insert into sgm_incidencias_servicios_cliente (id_servicio,id_cliente,id_estado,id_proveedor,id_proveedor_caracteristica,data) ";
					$sql = $sql."values (";
					$sql = $sql."".$row["id"];
					$sql = $sql.",".$_GET["id"];
					$sql = $sql.",".$_POST["id_estado_".$row["id"]];
					$sql = $sql.",".$_POST["id_proveedor_".$row["id"]];
					$sql = $sql.",".$_POST["id_proveedor_caracteristica_".$row["id"]];
					$sql = $sql.",'".$_POST["data_".$row["id"]]."'";
					$sql = $sql.")";
					mysql_query(convert_sql($sql));
				} else {
					$sql = "update sgm_incidencias_servicios_cliente set ";
					$sql = $sql."id_estado=".$_POST["id_estado_".$row["id"]]."";
					$sql = $sql.",id_proveedor=".$_POST["id_proveedor_".$row["id"]]."";
					$sql = $sql.",id_proveedor_caracteristica=".$_POST["id_proveedor_caracteristica_".$row["id"]]."";
					$sql = $sql.",data='".$_POST["data_".$row["id"]]."'";
					$sql = $sql." WHERE id_servicio=".$row["id"]." and id_cliente=".$_GET["id"];
					mysql_query(convert_sql($sql));
				}
			}
		}
		if ($ssoption == 6) {
			$sql = "update sgm_clients set ";
			$sql = $sql."num_treballadors=".$_POST["num_treballadors"]."";
			$sql = $sql." WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Gestion_Comercial." :</strong>";
		echo "<center>";
			echo "<table>";
				$sqlt = "select * from sgm_clients where id=".$_GET["id"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				echo "<tr>";
					echo "<form action=\"index.php?op=1008&sop=240&ssop=6&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td>Numero de Trabajadores :</td>";
					echo "<td><input type=\"text\" name=\"num_treballadors\" value=\"".$rowt["num_treballadors"]."\" style=\"width:100px\"></td>";
					echo "<td><input type=\"submit\" value=\"Guardar\" style=\"width:80px\"></td>";
					echo "</form>";

					echo "<td>";
						echo "<table><tr>";
							echo "<td style=\"width:120px;height:10px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1008&sop=247&id=".$_GET["id"]."\" style=\"color:white;\">Listado de proveedores</a>";
							echo "</td>";
						echo "</tr></table>";
					echo "</td>";


		echo "<form action=\"index.php?op=1023&sop=210\" method=\"post\">";
			echo "<td style=\"width:90px;text-align:right;\">Plantilla : </td><td>";
				echo "<select name=\"id_plantilla\" style=\"width:200\">";
				$sql = "select * from sgm_ft_plantilla where visible=1 order by plantilla";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<option value=\"".$row["id"]."\">".$row["plantilla"]."</option>";
				}
				echo "</select>";
			echo "<input type=\"Hidden\" value=\"".$_GET["id"]."\" name=\"id_client\">";
			echo "</td>";
			echo "<td style=\"text-align:right;\"></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px;\"></td>";
		echo "</form>";



				echo "</tr>";
			echo "</table>";

			echo "<br>";
			echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:100px;text-align:center;\">Fecha</td>";
				echo "<td style=\"width:250px;text-align:center;\">Servicio</td>";
				echo "<td style=\"width:125px;text-align:center;\">Estado</td>";
				echo "<td style=\"width:100px;text-align:center;\">Característica</td>";
				echo "<td style=\"width:150px;text-align:center;\">Proveedor</td>";
				echo "<td style=\"width:20px;text-align:center;\">EC</td>";
				echo "<td style=\"width:20px;text-align:center;\">EA</td>";
				echo "<td style=\"width:20px;text-align:center;\">ET</td>";
				echo "<td style=\"width:20px;text-align:center;\">TP</td>";
				echo "<td style=\"width:20px;text-align:center;\">TC</td>";
				echo "<td style=\"width:20px;text-align:center;\">TH</td>";
				echo "<td>Tarea</td>";
			echo "</tr>";


			echo "<form action=\"index.php?op=1008&sop=240&ssop=1&id=".$_GET["id"]."\" method=\"post\">";

				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));

				$sql = "select * from sgm_incidencias_servicios where visible=1 order by codigo,servicio";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					$sqlxx = "select * from sgm_incidencias_servicios_cliente where id_servicio=".$row["id"]." and id_cliente=".$_GET["id"];
					$resultxx = mysql_query(convert_sql($sqlxx));
					$rowxx = mysql_fetch_array($resultxx);
					echo "<tr>";
					if ($rowxx["data"] != "") {$date1 = $rowxx["data"];}
					echo "<td><input type=\"Text\" name=\"data_".$row["id"]."\" style=\"width:100px\" value=\"".$date1."\"></td>";
					echo "<td><input type=\"Text\" name=\"servicio\" style=\"width:250px\" value=\"".$row["servicio"]."\" disabled></td>";
					echo "<td><select name=\"id_estado_".$row["id"]."\" style=\"width:125px\">";
						echo "<option value=\"0\">-</option>";
						$sqlser = "select * from sgm_incidencias_servicios_estados where visible=1 order by nombre";
						$resultser = mysql_query(convert_sql($sqlser));
						while ($rowser = mysql_fetch_array($resultser)) {
							if ($rowser["id"] == $rowxx["id_estado"])  { 
									echo "<option value=\"".$rowser["id"]."\" selected>".$rowser["nombre"]."</option>";
								} else {
									echo "<option value=\"".$rowser["id"]."\">".$rowser["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select name=\"id_proveedor_caracteristica_".$row["id"]."\" style=\"width:100px\">";
						echo "<option value=\"0\">-</option>";
						$sqlser = "select * from sgm_incidencias_servicios_caracteristicas where visible=1 order by nombre";
						$resultser = mysql_query(convert_sql($sqlser));
						while ($rowser = mysql_fetch_array($resultser)) {
							if ($rowser["id"] == $rowxx["id_proveedor_caracteristica"])  { 
									echo "<option value=\"".$rowser["id"]."\" selected>".$rowser["nombre"]."</option>";
								} else {
									echo "<option value=\"".$rowser["id"]."\">".$rowser["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select name=\"id_proveedor_".$row["id"]."\" style=\"width:150px\">";
						echo "<option value=\"0\">-</option>";
						$sqlser = "select * from sgm_incidencias_servicios_proveedores where visible=1 order by nombre";
						$resultser = mysql_query(convert_sql($sqlser));
						while ($rowser = mysql_fetch_array($resultser)) {
							if ($rowser["id"] == $rowxx["id_proveedor"])  { 
									echo "<option value=\"".$rowser["id"]."\" selected>".$rowser["nombre"]."</option>";
								} else {
									echo "<option value=\"".$rowser["id"]."\">".$rowser["nombre"]."</option>";
							}
						}
					echo "</select></td>";

					echo "<td><center>-</center></td>";
					echo "<td><center>-</center></td>";
					echo "<td><center>-</center></td>";
						$sqlt = "select count(*) as total from sgm_incidencias where id_estado=-1 and visible=1 and id_cliente=".$_GET["id"]." and id_servicio=".$row["id"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
					echo "<td><center><a href=\"index.php?op=1008&sop=280&ssop=1&id=".$_GET["id"]."&id_servicio=".$row["id"]."\">".$rowt["total"]."</a></center></td>";
						$sqlt = "select count(*) as total from sgm_incidencias where id_estado>=0 and visible=1 and id_cliente=".$_GET["id"]." and id_servicio=".$row["id"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
					echo "<td><center><a href=\"index.php?op=1008&sop=280&ssop=1&id=".$_GET["id"]."&id_servicio=".$row["id"]."\">".$rowt["total"]."</a></center></td>";
						$sqlt = "select count(*) as total from sgm_incidencias where id_estado=-2 and visible=1 and id_cliente=".$_GET["id"]." and id_servicio=".$row["id"];
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
					echo "<td><center><a href=\"index.php?op=1008&sop=280&ssop=0&id=".$_GET["id"]."&id_servicio=".$row["id"]."\">".$rowt["total"]."</a></center></td>";

				$sqla = "select * from sgm_agendas_users where visible=1 and propietario=1 and id_user=".$userid;
				$resulta = mysql_query(convert_sql($sqla));
				$rowa = mysql_fetch_array($resulta);
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1017&sop=20&id_cliente=".$_GET["id"]."&id_servicio=".$row["id"]."&id_agenda=".$rowa["id_agenda"]."\"><img src=\"mgestion/pics/icons-mini/page_white_go.png\" style=\"border:0px\"></a></td>";
				echo "</tr>";

				}

			echo "</table>";
			echo "<input type=\"Submit\" value=\"Guardar todos los cambios\" style=\"width:400px\">";

			echo "</form>";


		echo "</center>";
		echo "<br><strong>EC</strong> : Estado Contable.";
		echo "<br><strong>EA</strong> : Estado Administrativo.";
		echo "<br><strong>ET</strong> : Estado Técnico.";
		echo "<br><strong>TP</strong> : Tareas/Incidencias Pendientes.";
		echo "<br><strong>TC</strong> : Tareas/Incidencias En Curso.";
		echo "<br><strong>TH</strong> : Tareas/Incidencias Histórico.";
	}

	if ($soption == 247) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_incidencias_servicios_proveedores (nombre) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["nombre"])."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_incidencias_servicios_proveedores set ";
			$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql." WHERE id=".$_POST["id_proveedor"];
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_incidencias_servicios_proveedores set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_proveedor"];
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Administrar." ".$Proveedores." :</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:130px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
			if ($_GET["id"] != ""){
				echo "<a href=\"index.php?op=1008&sop=240&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			} else {
				echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			}
			echo "</td>";
		echo "</tr></table>";
		echo "<br><center>";
		echo "<table cellspacing=\"0\" style=\"width:300px\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"width:100px;\"><em>".$Nombre."</em></td>";
				echo "<td style=\"width:100px;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1008&sop=247&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"></td>";
				echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_incidencias_servicios_proveedores where visible=1 order by nombre";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=248&id_proveedor=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></td>";
				echo "<form action=\"index.php?op=1008&sop=247&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_proveedor\" value=\"".$row["id"]."\">";
				echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 248) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este proveedor?";
		echo "<br><br><a href=\"index.php?op=1008&sop=247&ssop=3&id_proveedor=".$_GET["id_proveedor"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=247&id_proveedor=".$_GET["id_proveedor"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 250) {
		if ($ssoption == 1) {
			$sql = "select count(*) as total from sgm_clients_certificaciones_cliente where id_cliente=".$_GET["id"]." and id_certificado=".$_GET["id_certificado"]."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] == 0){
				$sql = "insert into sgm_clients_certificaciones_cliente (id_certificado,id_cliente,id_estado) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_certificado"];
				$sql = $sql.",".$_GET["id"];
				$sql = $sql.",".$_POST["id_estado"];
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_clients_certificaciones_cliente set ";
				$sql = $sql."id_estado=".$_POST["id_estado"]."";
				$sql = $sql." WHERE id_cliente=".$_GET["id"]." and id_certificado=".$_GET["id_certificado"]."";
				mysql_query(convert_sql($sql));
			}
		}

		echo "<strong>".$Listado." de ".$Certificaciones."</strong><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td style=\"width:200px;text-align:center;\">".$Certificacion."</td>";
			echo "<td style=\"width:200px;text-align:center;\">".$Estado."</td>";
			echo "<td></td>";
			echo "<td></td>";
		echo "</tr>";
			$sql = "select * from sgm_clients_certificaciones where visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
				echo "<form action=\"index.php?op=1008&sop=250&ssop=1&id=".$_GET["id"]."&id_certificado=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\" value=\"".$row["nombre"]."\" disabled></td>";
				echo "<td><select name=\"id_estado\" style=\"width:200px\">";
					echo "<option value=\"0\">-</option>";
					$sqlser = "select * from sgm_clients_certificaciones_estados where visible=1 order by nombre";
					$resultser = mysql_query(convert_sql($sqlser));
					while ($rowser = mysql_fetch_array($resultser)) {
						$sqlx = "select * from sgm_clients_certificaciones_cliente where id_cliente=".$_GET["id"]." and id_certificado=".$row["id"]."";
						$resultx = mysql_query(convert_sql($sqlx));
						$rowx = mysql_fetch_array($resultx);
							if ($rowser["id"] == $rowx["id_estado"] ){
								echo "<option value=\"".$rowser["id"]."\" selected>".$rowser["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowser["id"]."\">".$rowser["nombre"]."</option>";
							}
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 260) {
		if ($ssoption == 4) {
			$sql = "update sgm_clients_contactos set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id<>".$_GET["id_contacte"]." and id_client=".$_GET["id"];
			mysql_query(convert_sql($sql));
			$sql = "update sgm_clients_contactos set ";
			$sql = $sql."pred = 1";
			$sql = $sql." WHERE id =".$_GET["id_contacte"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 5) {
			$sql = "update sgm_clients_contactos set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id =".$_GET["id_contacte"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$CONTACTOS."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:130px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1008&sop=261&ssop=1&id=".$_GET["id"]."\" style=\"color:white;\">".$Anadir." ".$Contacto."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td style=\"width:50px;text-align:right;\"><em>".$Predeterminar."</em></td>";
				echo "<td style=\"width:50px;text-align:right;\"><em>".$Eliminar."</em></td>";
				echo "<td style=\"width:200px;text-align:left;\"><em>".$Nombre." ".$Contacto."</em></td>";
				echo "<td style=\"width:200px;text-align:left;\"><em>".$Cargo."</em></td>";
				echo "<td style=\"width:100px;text-align:center;\"><em>".$Telefono."</em></td>";
				echo "<td style=\"width:100px;text-align:center;\"><em>".$Movil."</em></td>";
				echo "<td style=\"width:50px;text-align:right;\">&nbsp;</td>";
				echo "<td style=\"width:30px;text-align:center;\"><em>".$Ver."</em></td>";
				echo "<td style=\"width:30px;text-align:center;\"><em>".$Editar."</em></td>";
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
						echo "<form action=\"index.php?op=1008&sop=260&ssop=5&id=".$_GET["id"]."&id_contacte=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:60px\">";
						echo "</form>";
					}
					if ($row["pred"] == 0) {
						echo "<form action=\"index.php?op=1008&sop=260&ssop=4&id=".$_GET["id"]."&id_contacte=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:60px\">";
						echo "</form>";
					}
					echo "</td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=263&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
							$sqlt = "select * from sgm_clients_tratos where id=".$row["id_trato"];
							$resultt = mysql_query(convert_sql($sqlt));
							$rowt = mysql_fetch_array($resultt);
						echo "<td style=\"color:".$colorl.";\">".$rowt["trato"]." ".$row["nombre"]." ".$row["apellido1"]." ".$row["apellido2"]."</td>";
						echo "<td style=\"color:".$colorl.";\">".$row["carrec"]."</td>";
						echo "<td style=\"color:".$colorl.";\">".$row["telefono"]."</td>";
						echo "<td style=\"text-align:center;color:".$colorl.";\">".$row["movil"]."</td>";
						echo "<td style=\"text-align:center;color:".$colorl.";\">";
							if ($row["mail"] != "") { echo "<a href=\"mailto:".$row["mail"]."\"><img src=\"mgestion/pics/icons-mini/email_link.png\" style=\"border:0px\"></a>"; }
						echo "</td>";
					echo "<td style=\"text-align:center;color:".$colorl.";\"><a href=\"index.php?op=1008&sop=261&ssop=0&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" style=\"border:0px\"></a></td>";
					if ($row["pred"] == 1){
						echo "<td style=\"text-align:center;color:".$colorl.";\"><a href=\"index.php?op=1008&sop=261&ssop=4&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
					} else {
						echo "<td style=\"text-align:center;color:".$colorl.";\"><a href=\"index.php?op=1008&sop=261&ssop=2&id=".$row["id_client"]."&id_contacto=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
					}
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 261) {
		if (($ssoption == 3) or ($ssoption == 4)) {
			$sqlc = "select * from sgm_clients where id=".$_GET["id"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$pre = "contacto_";
		}
		if (($ssoption == 0) or ($ssoption == 2)) {
			$sqlc = "select * from sgm_clients_contactos where id=".$_GET["id_contacto"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$pre = "";
		}
		if ($ssoption == 1) { 
			echo "<strong>".$Anadir." ".$Contacto."</strong><br><br>";
			echo "<form action=\"index.php?op=1008&sop=262&id=".$_GET["id"]."&id_contacto=".$_GET["id_contacto"]."\" method=\"post\">";
		}
		if ($ssoption == 2) {
			echo "<strong>".$Editar." ".$Contacto."</strong><br><br>";
			echo "<form action=\"index.php?op=1008&sop=265&id=".$_GET["id"]."&id_contacto=".$_GET["id_contacto"]."\" method=\"post\">";
		}
		if ($ssoption == 4) {
			echo "<strong>".$Editar." ".$Contacto." ".$Principal."</strong><br><br>";
			echo "<form action=\"index.php?op=1008&sop=266&id=".$_GET["id"]."\" method=\"post\">";
		}
		echo "<table><tr>";
			echo "<td style=\"width:130px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1008&sop=260&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table>";
			echo "<tr>";
				if ($ssoption == 1) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>"; }
				if (($ssoption == 2) or ($ssoption == 4)) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>"; }
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Trato.": </td>";
				echo "<td><select name=\"id_trato\" style=\"width:50px\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select * from sgm_clients_tratos order by trato";
						$resultt = mysql_query(convert_sql($sqlt));
						while ($rowt = mysql_fetch_array($resultt)) {
							if ($rowt["id"] == $rowc["id_trato"]) { echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["trato"]."</option>"; }
							else { echo "<option value=\"".$rowt["id"]."\">".$rowt["trato"]."</option>"; }
						}

				echo "</select></td>";
				
#				<input type=\"text\" name=\"tracte\" style=\"width:200px\" value=\"".$rowc[$pre."tracte"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Nombre.": </td>";
				echo "<td><input type=\"text\" name=\"nombre\" style=\"width:200px\" value=\"".$rowc[$pre."nombre"]."\"></td>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Apellido." 1: </td>";
				echo "<td><input type=\"text\" name=\"apellido1\" style=\"width:200px\" value=\"".$rowc[$pre."apellido1"]."\"></td>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Apellido." 2: </td>";
				echo "<td><input type=\"text\" name=\"apellido2\" style=\"width:200px\" value=\"".$rowc[$pre."apellido2"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Departamento.": </td>";
				echo "<td><input type=\"text\" name=\"departament\" style=\"width:200px\" value=\"".$rowc[$pre."departament"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Cargo.": </td>";
				echo "<td><input type=\"text\" name=\"carrec\" style=\"width:200px\" value=\"".$rowc[$pre."carrec"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Telefono.": </td>";
				echo "<td><input type=\"text\" name=\"telefono\" style=\"width:200px\" value=\"".$rowc[$pre."telefono"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Fax.": </td>";
				echo "<td><input type=\"text\" name=\"fax\" style=\"width:200px\" value=\"".$rowc[$pre."fax"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Email.": </td>";
				echo "<td><input type=\"text\" name=\"mail\" style=\"width:200px\" value=\"".$rowc[$pre."mail"]."\"></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Movil.": </td>";
				echo "<td><input type=\"text\" name=\"movil\" style=\"width:200px\" value=\"".$rowc[$pre."movil"]."\"></td>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Idioma.": </td>";
				echo "<td><select name=\"id_idioma\" style=\"width:200px\">";
				echo "<option value=\"0\">-</option>";
				$sql = "select * from sgm_idiomas where visible=1";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)){
					$sqlcl = "select * from sgm_clients where visible=1 and id=".$rowc["id_client"];
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
			echo "</tr><tr>";
			echo "</tr><tr>";
			echo "</tr><tr>";
#			echo "</tr><tr>";
#				echo "<td style=\"text-align:right;\">Interlocutor: </td>";
#				echo "<td><input type=\"text\" name=\"interlocutor\" style=\"width:200px\" value=\"".$rowc[$pre."interlocutor"]."\"></td>";
#			echo "</tr><tr>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;\">".$Secretario.": </td>";
				echo "<td><input type=\"text\" name=\"secretari\" style=\"width:200px\" value=\"".$rowc[$pre."secretari"]."\"></td>";
			echo "</tr><tr>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\">".$Notas."</td>";
				echo "<td><textarea name=\"notas\" class=\"px400\" rows=\"9\">".$rowc[$pre."notas"]."</textarea></td>";
			echo "</tr><tr>";
		if ($ssoption == 1) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>"; }
		if (($ssoption == 2) or ($ssoption == 4)) { echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>"; }
			echo "</tr>";
		echo "</table>";
		echo "</center>";
		echo "</form>";
	}

	if ($soption == 262) {
		$sql = "insert into sgm_clients_contactos (id_trato,nombre,apellido1,apellido2,carrec,departament,telefono,fax,mail,movil,secretari,notas,id_client,id_idioma)";
		$sql = $sql."values (";
		$sql = $sql."".$_POST["id_trato"];
		$sql = $sql.",'".comillas($_POST["nombre"])."'";
		$sql = $sql.",'".comillas($_POST["apellido1"])."'";
		$sql = $sql.",'".comillas($_POST["apellido2"])."'";
		$sql = $sql.",'".comillas($_POST["carrec"])."'";
		$sql = $sql.",'".comillas($_POST["departament"])."'";
		$sql = $sql.",'".$_POST["telefono"]."'";
		$sql = $sql.",'".$_POST["fax"]."'";
		$sql = $sql.",'".$_POST["mail"]."'";
		$sql = $sql.",'".$_POST["movil"]."'";
		$sql = $sql.",'".comillas($_POST["secretari"])."'";
		$sql = $sql.",'".comillas($_POST["notas"])."'";
		$sql = $sql.",".$_GET["id"]."";
		$sql = $sql.",".$_POST["id_idioma"]."";
		$sql = $sql.")";
		mysql_query(convert_sql($sql));
		echo "<center><br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=260&id=".$_GET["id"]."\">[ Volver ]</a></center>";
	}

	if ($soption == 263) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este contacto?";
		echo "<br><br><a href=\"index.php?op=1008&sop=264&id=".$_GET["id"]."&id_contacto=".$_GET["id_contacto"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=1008&sop=260&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 264) {
		$sql = "update sgm_clients_contactos set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id_contacto"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=260&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}
	
	if ($soption == 265) {
		$sql = "update sgm_clients_contactos set ";
#		$sql = $sql."interlocutor='".$_POST["interlocutor"]."'";
		$sql = $sql."id_trato=".$_POST["id_trato"];
		$sql = $sql.",nombre='".comillas($_POST["nombre"])."'";
		$sql = $sql.",apellido1='".comillas($_POST["apellido1"])."'";
		$sql = $sql.",apellido2='".comillas($_POST["apellido2"])."'";
		$sql = $sql.",carrec='".comillas($_POST["carrec"])."'";
		$sql = $sql.",departament='".comillas($_POST["departament"])."'";
		$sql = $sql.",telefono='".$_POST["telefono"]."'";
		$sql = $sql.",fax='".$_POST["fax"]."'";
		$sql = $sql.",mail='".$_POST["mail"]."'";
		$sql = $sql.",movil='".$_POST["movil"]."'";
		$sql = $sql.",secretari='".comillas($_POST["secretari"])."'";
		$sql = $sql.",notas='".comillas($_POST["notas"])."'";
		$sql = $sql.",id_idioma=".$_POST["id_idioma"]."";
		$sql = $sql." WHERE id=".$_GET["id_contacto"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=260&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 266) {
		$sql = "update sgm_clients set ";
#		$sql = $sql."contacto_interlocutor='".$_POST["interlocutor"]."'";
		$sql = $sql."id_trato=".$_POST["id_trato"];
		$sql = $sql.",contacto_nombre='".comillas($_POST["nombre"])."'";
		$sql = $sql.",contacto_carrec='".comillas($_POST["carrec"])."'";
		$sql = $sql.",contacto_departament='".comillas($_POST["departament"])."'";
		$sql = $sql.",contacto_telefono='".comillas($_POST["telefono"])."'";
		$sql = $sql.",contacto_fax='".$_POST["fax"]."'";
		$sql = $sql.",contacto_mail='".$_POST["mail"]."'";
		$sql = $sql.",contacto_movil='".$_POST["movil"]."'";
		$sql = $sql.",contacto_secretari='".comillas($_POST["secretari"])."'";
		$sql = $sql.",contacto_notas='".comillas($_POST["notas"])."'";
#		$sql = $sql.",contacto_id_idioma=".$_POST["id_idioma"]."";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008&sop=260&id=".$_GET["id"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 270) {
		if ($ssoption == 1) {
		$sql = "update sgm_clients_dades_adicionals set ";
		$sql = $sql."existe=".$_POST["existe"];
		$sql = $sql.",observacions='".comillas($_POST["observacions"])."'";
		$sql = $sql." WHERE id=".$_GET["id_dato"]."";
		mysql_query(convert_sql($sql));
		}
		if ($ssoption == 2) {
		$sql = "update sgm_clients set ";
		$sql = $sql."dades_adicionals='".comillas($_POST["dades_adicionals"])."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		}

		echo "<center>";
		echo "<br><table cellpadding=\"1\" cellspacing=\"0\">";
			echo "<tr style=\"background-color : Silver;\">";
				echo "<td style=\"width:150px;\">".$Datos_Adicionales."</td>";
				echo "<td></td>";
				echo "<td>".$Observacions."</td>";
				echo "<td></td>";
			echo "</tr>";

			$sql = "select * from sgm_clients_camps_dades_adicionals order by nom_camp";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				### CREO CAMPO SI NO EXISTE
				$sqlt = "select count(*) as total from sgm_clients_dades_adicionals where id_client=".$_GET["id"]." and id_camp=".$row["id"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] == 0) {
					$sql = "insert into sgm_clients_dades_adicionals (id_camp,id_client)";
					$sql = $sql."values (";
					$sql = $sql."".$row["id"];
					$sql = $sql.",".$_GET["id"]."";
					$sql = $sql.")";
					mysql_query(convert_sql($sql));
				}

				$sqlc = "select * from sgm_clients_dades_adicionals where id_client=".$_GET["id"]." and id_camp=".$row["id"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);

				echo "<tr>";
					echo "<form action=\"index.php?op=1008&sop=270&ssop=1&id=".$_GET["id"]."&id_dato=".$rowc["id"]."\" method=\"post\">";
					echo "<td>".$row["nom_camp"]."</td>";
					echo "<td><select name=\"existe\">";
						if ($rowc["existe"] == 0) {
							echo "<option value=\"0\" selected>NO</option>";
							echo "<option value=\"1\">SI</option>";
						}
						if ($rowc["existe"] == 1) {
							echo "<option value=\"0\">NO</option>";
							echo "<option value=\"1\" selected>SI</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Text\" name=\"observacions\" value=\"".$rowc["observacions"]."\" style=\"width:300px;\"></td>";
					echo "<td><input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "<center>";

		echo "<form action=\"index.php?op=1008&sop=270&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
		echo "<br><table>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"width:800px\">".$Datos_Adicionales."</td></tr>";
			$sqlcli = "select * from sgm_clients where id=".$_GET["id"];
			$resultcli = mysql_query(convert_sql($sqlcli));
			$rowcli = mysql_fetch_array($resultcli);
			echo "<tr><td><textarea style=\"width:800px;\" name=\"dades_adicionals\" rows=\"8\">".$rowcli["dades_adicionals"]."</textarea></td></tr>";
			echo "<tr><td style=\"width:800px;text-align:center\"><input type=\"submit\" value=\"".$Modificar."\" style=\"width:200px\"></td></tr>";
#			echo "<tr style=\"background-color : Silver;\"><td style=\"width:800px\">OTROS</td></tr>";
##			echo "<tr><td><textarea style=\"width:800px;\" rows=\"8\">".$rowcli["text_lliure"]."</textarea></td></tr>";
		echo "</table>";


	}

	if ($soption == 280) {
		if ($ssoption == 1) { echo "<strong>Incidencias : </strong><br>"; }
		if ($ssoption == 0) { echo "<strong>Histórico : </strong><br>"; }
		if ($ssoption == 0) {
		$sql = "select count(*) as total2 from sgm_ft where visible=1 and id_client=".$_GET["id"]." order by id";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<strong>Listado Hojas de Trabajo :</strong><br><br>";
		$lineas_por_pagina = 25;
		$paginas = ceil($row["total2"]/$lineas_por_pagina);
		if ($_GET["pag"] == "") { $pag = 1; } else { $pag = $_GET["pag"]; }
		$inicio = $lineas_por_pagina*($pag-1);
		echo "<br><center>";
#		echo "<a href=\"index.php?op=1023&sop=201\">Primera</a>&nbsp;&nbsp;";
#		if ($pag == 1) { echo "&laquo;&laquo;&nbsp;&nbsp;"; } else { echo "<a href=\"index.php?op=1023&sop=201&pag=".($pag-1)."\">&laquo;&laquo;</a>&nbsp;&nbsp;"; }
#		echo $pag;
#		if ($pag == $paginas) { echo "&nbsp;&nbsp;&raquo;&raquo;"; } else { echo "&nbsp;&nbsp;<a href=\"index.php?op=1023&sop=201&pag=".($pag+1)."\">&raquo;&raquo;</a>"; }
#		echo "&nbsp;&nbsp;<a href=\"index.php?op=1023&sop=201&pag=".$paginas."\">Última</a>";
		echo "<br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;width:150px\">Cliente</td>";
				echo "<td style=\"text-align:center;width:150px\">Plantilla</td>";
				echo "<td style=\"text-align:center;width:75px\">OT</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		$pintar = true;
		$sql = "select * from sgm_ft where visible=1 and id_client=".$_GET["id"]." order by id desc";
#		$sql = "select * from sgm_ft where visible=1 and id_client=".$_GET["id"]." order by id desc limit ".$inicio.", ".$lineas_por_pagina;
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sqlc = "select * from sgm_clients where id=".$row["id_client"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
			$sqlp = "select * from sgm_ft_plantilla where id=".$row["id_plantilla"];
			$resultpc = mysql_query(convert_sql($sqlp));
			$rowp = mysql_fetch_array($resultp);
			$sqlf = "select * from sgm_cabezera where id=".$row["id_ot"];
			$resultpf = mysql_query(convert_sql($sqlf));
			$rowf = mysql_fetch_array($resultf);
			if ($pintar == true) { $color = "#C8C8C8"; $pintar =false; }
			else {$color = "white"; $pintar = true; }
			echo "<tr style=\"background-color:".$color.";\">";
				echo "<td style=\"width:50px\">".$row["id"]."</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=202&id_ot=".$row["id"]."&pag=".$paginas."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<td>".$rowc["nombre"]."</td>";
				echo "<td>".$rowp["plantilla"]."</td>";
				echo "<td>";
					if ($rowf["numero"] == "") {
						echo "Sin OT";
					} else {
						echo "<a href=\"\">[ ".$rowf["numero"]." ]</a>";
					}
				echo "</td>";
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=1023&sop=210&id_ft=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
				echo "<td style=\"text-align:center\"><a href=\"mgestion/gestion-produccion-ft-print.php?id=".$rowc["id"]."&id_ft=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px\"></a></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
#		echo "<a href=\"index.php?op=1023&sop=201\">Primera</a>&nbsp;&nbsp;";
#		if ($pag == 1) { echo "&laquo;&laquo;&nbsp;&nbsp;"; } else { echo "<a href=\"index.php?op=1023&sop=201&pag=".($pag-1)."\">&laquo;&laquo;</a>&nbsp;&nbsp;"; }
#		echo $pag;
#		if ($pag == $paginas) { echo "&nbsp;&nbsp;&raquo;&raquo;"; } else { echo "&nbsp;&nbsp;<a href=\"index.php?op=1023&sop=201&pag=".($pag+1)."\">&raquo;&raquo;</a>"; }
#		echo "&nbsp;&nbsp;<a href=\"index.php?op=1023&sop=201&pag=".$paginas."\">Última</a>";
		echo "</center><br>";
		}

		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td></td>";
#				echo "<td style=\"text-align:right;\"></td>";
				echo "<td><table><tr><td>";
					if (($_POST["fecha"] == 5) OR ($_POST["fecha"] == "")) {
						echo "<input type=\"Radio\" name=\"orden\" value=\"5\" checked style=\"border:0px\">";
					} else {
						echo "<input type=\"Radio\" name=\"orden\" value=\"5\" style=\"border:0px\">";
					}
				echo "</td>";
				echo "<td>".$Fecha."</td></tr></table></td>";
				echo "<td><table><tr><td>";
					if ($_POST["orden"] == 6) {
						echo "<input type=\"Radio\" name=\"orden\" value=\"6\" checked style=\"border:0px\">";
					} else {
						echo "<input type=\"Radio\" name=\"orden\" value=\"6\" style=\"border:0px\">";
					}
				echo "</td>";
				echo "<td>".$Servicio."</td></tr></table></td>";
				echo "<td><table><tr><td>";
					if ($_POST["orden"] == 4) {
						echo "<input type=\"Radio\" name=\"orden\" value=\"4\" checked style=\"border:0px\">";
					} else {
						echo "<input type=\"Radio\" name=\"orden\" value=\"4\" style=\"border:0px\">";
					}
				echo "</td>";
				echo "<td>".$Cliente."</td></tr></table></td>";
				echo "<td><table><tr><td>";
					if ($_POST["orden"] == 1) {
						echo "<input type=\"Radio\" name=\"orden\" value=\"1\" checked style=\"border:0px\">";
					} else {
						echo "<input type=\"Radio\" name=\"orden\" value=\"1\" style=\"border:0px\">";
					}
				echo "</td>";
				echo "<td>".$Estado."</td></tr></table></td>";
				echo "<td><table><tr><td>";
					if ($_POST["orden"] == 2) {
						echo "<input type=\"Radio\" name=\"orden\" value=\"2\" checked style=\"border:0px\">";
					} else {
						echo "<input type=\"Radio\" name=\"orden\" value=\"2\" style=\"border:0px\">";
					}
				echo "</td>";
				echo "<td>".$Departamento."</td></tr></table></td>";
				echo "<td><table><tr><td>";
					if ($_POST["orden"] == 3) {
						echo "<input type=\"Radio\" name=\"orden\" value=\"3\" checked style=\"border:0px\">";
					} else {
						echo "<input type=\"Radio\" name=\"orden\" value=\"3\" style=\"border:0px\">";
					}
				echo "</td>";
				echo "<td>".$Usuario."</td></tr></table></td>";
				echo "<td></td>";
				echo "<td style=\"width:50px\"></td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Numero."</td>";
				echo "<td></td>";
				echo "<td style=\"text-align:right;\">".$Filtrado_por.":</td>";
				echo "<td><select name=\"servicio\" class=\"px80\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_incidencias_servicios where visible=1";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) { 
						if ($_POST["servicio"] == $row["id"]) {
							echo "<option value=\"".$row["id"]."\" selected>".$row["servicio"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["servicio"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><select name=\"cliente\" class=\"px200\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_clients where visible=1 order by nombre";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {	
						if ($_POST["cliente"] == $row["id"]) {
							echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><select name=\"estado\" class=\"px80\">";
					echo "<option value=\"0\">-</option>";
					echo "<option value=\"-1\">Registrada</option>";
					echo "<option value=\"-2\">Finalizada</option>";
					$sql = "select * from sgm_incidencias_estados where visible=1";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						if ($_POST["estado"] == $row["id"]) {
							echo "<option value=\"".$row["id"]."\" selected>".$row["estado"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["estado"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><select name=\"departamento\" class=\"px80\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_incidencias_departamento where visible=1";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) { 
						if ($_POST["departamento"] == $row["id"]) {
							echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td>";
					echo "<select name=\"usuario\" class=\"px80\">";
					if (($admin == true) or ($ssoption == 1)) {
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_users where sgm=1 and activo=1 and validado=1";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {	
							if ($_POST["usuario"] == $row["id"]) {
								echo "<option value=\"".$row["id"]."\" selected>".$row["usuario"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["usuario"]."</option>";
							}
						}
					} else { echo "<option value=\"0\" selected>".$username."</option>";}
				echo "</select></td>";
				echo "<td>";
					echo "<input type=\"Submit\" value=\"".$Ver."\" style=\"width:50px\">";
				echo "</td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</form>";
			$estado_color = "White";
			$sql = "select * from sgm_incidencias where (visible=1)";
			if ($ssoption == 1) { $sql = $sql." and (id_estado<>-2)"; }
			if ($ssoption == 0) { $sql = $sql." and (id_estado=-2)"; }
			if ($_GET["id_servicio"] != "") { $sql = $sql." and id_servicio = ".$_GET["id_servicio"].""; }
			$sql = $sql." and id_cliente = ".$_GET["id"]."";
			$sql = $sql." order by data_prevision DESC";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$sqld = "select * from sgm_incidencias_departamento where id=".$row["id_departamento"];
				$resultd = mysql_query(convert_sql($sqld));
				$rowd = mysql_fetch_array($resultd);
				$sqlu = "select * from sgm_users where id=".$row["id_usuario_destino"];
				$resultu = mysql_query(convert_sql($sqlu));
				$rowu = mysql_fetch_array($resultu);
				$sqlser = "select * from sgm_incidencias_servicios where id=".$row["id_servicio"];
				$resultser = mysql_query(convert_sql($sqlser));
				$rowser = mysql_fetch_array($resultser);
				if ($row["id_estado"] > 0) {
					$sqle = "select * from sgm_incidencias_estados where id=".$row["id_estado"];
					$resulte = mysql_query(convert_sql($sqle));
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
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr style=\"background-color:".$estado_color.";\">";
					echo "<td style=\"text-align:center;vertical-align:top;color:".$estado_color_letras."\">".$row["id"]."</td>";
#					$sqlti = "select count(*) as total from sgm_incidencias where id_origen=".$row["id"]." and visible=1";
#					$resultti = mysql_query(convert_sql($sqlti));
#					$rowti = mysql_fetch_array($resultti);
#					if ($rowti["total"] == 0) {
#						echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1006&sop=21&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"><a></td>";
#					} else {echo "<td></td>";}
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">".date('d-m H:i',strtotime($row["data_prevision"]))."</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">";
					if (strlen($rowser["servicio"]) > 15) {
						 echo "&nbsp;&nbsp;".substr($rowser["servicio"],0,11)." ...";
					} else {
						echo "&nbsp;&nbsp;".$rowser["servicio"]."";
					}
					echo "</td>";
					echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;\">";
					if ($row["id_cliente"] == 0) {
						if (strlen($row["cliente_nombre"]) > 45) {
							echo "&nbsp;&nbsp;".substr($row["cliente_nombre"],0,41);
						} else {
							echo "&nbsp;&nbsp;".$row["cliente_nombre"];
						}
					} else {
						if (strlen($rowc["nombre"]) > 35) {
							 echo "&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=200&id=".$rowc["id"]."\" style=\"color:".$estado_color_letras.";\">".substr($rowc["nombre"],0,36)." ...</a>";
						} else {
							echo "&nbsp;&nbsp;<a href=\"index.php?op=1008&sop=200&id=".$rowc["id"]."\" style=\"color:".$estado_color_letras.";\">".$rowc["nombre"]."</a>";
						}
					}
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
						if ($ssoption <> 1){echo "<a href=\"index.php?op=1006&sop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px;\"><a>";}
						if ($ssoption == 1){echo "<a href=\"index.php?op=1006&sop=2&ssop=1&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_add.png\" style=\"border:0px;\"><a>";}
						echo "&nbsp;";
						echo "<a href=\"".$urloriginal."/includes/gestion-incidencia-print.php?id=".$row["id"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/printer.png\" style=\"border:0px;\"></a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table></center>";
	}

	if ($soption == 290) {
		if ($ssoption == 1000) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				$archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
				$tipo = $_POST["id_tipo"];
				$id_cuerpo = $_POST["id_cuerpo"];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
				$tipo = $HTTP_POST_VARS["id_tipo"];
				$id_cuerpo = $HTTP_POST_VARS["id_cuerpo"];
			}
			$sql = "select * from sgm_files_tipos where id=".$tipo;
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$lim_tamano = $row["limite_kb"]*1000;
			$sqlt = "select count(*) as total from sgm_files where name='".$archivo_name."'";
			$resultt = mysql_query(convert_sql($sqlt));
			$rowt = mysql_fetch_array($resultt);
			if ($rowt["total"] != 0) {
				echo "No se puede ".$Anadir." archivo por que ya existe uno con el mismo nombre.";
			}
			else {
				if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
			    	if (copy ($archivo, "files/".$archivo_name)) {
						echo "<center>";
						echo "<h2>Se ha transferido el archivo $archivo_name</h2>";
						echo "<br>Su tamaño es: $archivo_size bytes<br><br>";
						echo "Operación realizada correctamente.";
						echo "</center>";
						$sql = "insert into sgm_files (id_tipo,name,type,size,id_client) ";
						$sql = $sql."values (";
						$sql = $sql."".$tipo."";
						$sql = $sql.",'".$archivo_name."'";
						$sql = $sql.",'".$archivo_type."'";
						$sql = $sql.",".$archivo_size."";
						$sql = $sql.",".$id_cuerpo."";
						$sql = $sql.")";
						mysql_query(convert_sql($sql));
	    	          }
					}else{
					    echo "<h2>No ha podido transferirse el archivo.</h2>";
		    			echo "<h3>Su tamaño no puede exceder de ".$lim_tamano." bytes.</h2>";
				}
			}
		}
		if ($ssoption == 1001) {
			echo "<center>";
			echo "¿Seguro que desea eliminar este archivo?";
			echo "<br><br><a href=\"index.php?op=1008&sop=290&ssop=1002&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=290&id=".$_GET["id"]."\">[ NO ]</a>";
			echo "</center>";
		}
		if ($ssoption == 1002) {
			$sql = "delete from sgm_files WHERE id=".$_GET["id_archivo"];
			mysql_query(convert_sql($sql));
			echo "<center>";
			echo "Operación realizada correctamente.";
			echo "</center>";
		}
		echo "<br>";
			echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:400px;vertical-align:top;\">";
						echo "<strong>".$Listado." de ".$Archivos." :</strong><br><br>";
						$sql = "select * from sgm_files_tipos order by nombre";
						$result = mysql_query(convert_sql($sql));
						echo "<table>";
						while ($row = mysql_fetch_array($result)) {
							$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and id_client=".$_GET["id"];
							$resultele = mysql_query(convert_sql($sqlele));
							while ($rowele = mysql_fetch_array($resultele)) {
								echo "<tr><td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/files/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td>&nbsp;<a href=\"index.php?op=1008&sop=290&ssop=1001&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\">[ ".$Eliminar." ]</a></td></tr>";
							}
						}
						echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>".$Formulario." de ".$envio." de ".$Archivos." :</strong><br><br>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1008&sop=290&ssop=1000&id=".$_GET["id"]."\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"Hidden\" name=\"id_cuerpo\" value=\"".$_GET["id"]."\">";
					echo "<select name=\"id_tipo\" style=\"width:200px\">";
						$sql = "select * from sgm_files_tipos order by nombre";
						$result = mysql_query(convert_sql($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (".$Hasta." ".$row["limite_kb"]." Kb)</option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"file\" name=\"archivo\" size=\"29px\">";
					echo "<br><br><input type=\"submit\" value=\"Enviar a la carpeta FILES/\" style=\"width:200px\">";
					echo "</form>";
					echo "</center>";
			echo "</td></tr></table>";
	}

	if ($soption == 295) {
		echo "<strong>".$Agrupacion." de ".$Contactos." : </strong><br>";
		echo "<table style=\"width:1000px\"><tr>";
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
					echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">";
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
					echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">";
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
					echo "<a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">";
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

	if ($soption == 300) {
		echo "<strong>".$Indicadores."</strong><br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
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
		echo "<center>";
	}

        if (($soption == 400) and ($admin == true)) {
                if ($ssoption == 1) {
                        $sql = "insert into sgm_clients_carrer (nombre) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["nombre"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 2) {
                        $sql = "update sgm_clients_carrer set ";
                        $sql = $sql."nombre='".comillas($_POST["nombre"])."'";
                        $sql = $sql." WHERE id=".$_POST["id"];
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 3) {
                        $sql = "delete from sgm_clients_carrer WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
                }
                echo "<strong>".$Calles."</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center><table cellspacing=\"0\" style=\"width:300px\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"width:100px;\"><em>".$Nombre."</em></td>";
                                echo "<td style=\"width:100px;\"></td>";
                        echo "</tr>";
                        echo "<tr>";
                                echo "<form action=\"index.php?op=1008&sop=400&ssop=1\" method=\"post\">";
                                echo "<td></td>";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Anadir."\"></td>";
                                echo "</form>";
                        echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
                $sql = "select * from sgm_clients_carrer order by nombre";
                $result = mysql_query(convert_sql($sql));
                while ($row = mysql_fetch_array($result)) {
                        echo "<tr>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=401&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\"border=\"0\"></td>";
                                echo "<form action=\"index.php?op=1008&sop=400&ssop=2&id=".$_GET["id"]."\"method=\"post\">";
                                echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"value=\"".$row["nombre"]."\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Modificar."\"></td>";
                                echo "</form>";
                        echo "</tr>";
                }
                echo "</table></center>";
        }

        if ($soption == 401) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este dato adicional?";
                echo "<br><br><a href=\"index.php?op=1008&sop=400&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=400&id=".$_GET["id"]."\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 410) and ($admin == true)) {
                if ($ssoption == 1) {
                        $sql = "insert into sgm_clients_carrer_tipo (nombre) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["nombre"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 2) {
                        $sql = "update sgm_clients_carrer_tipo set ";
                        $sql = $sql."nombre='".comillas($_POST["nombre"])."'";
                        $sql = $sql." WHERE id=".$_POST["id"];
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 3) {
                        $sql = "delete from sgm_clients_carrer_tipo WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
                }
                echo "<strong>".$Tipos." ".$Calles."</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center><table cellspacing=\"0\" style=\"width:300px\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"width:100px;\"><em>".$Nombre."</em></td>";
                                echo "<td style=\"width:100px;\"></td>";
                        echo "</tr>";
                        echo "<tr>";
                                echo "<form action=\"index.php?op=1008&sop=410&ssop=1\" method=\"post\">";
                                echo "<td></td>";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Anadir."\"></td>";
                                echo "</form>";
                        echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
                $sql = "select * from sgm_clients_carrer_tipo order by nombre";
                $result = mysql_query(convert_sql($sql));
                while ($row = mysql_fetch_array($result)) {
                        echo "<tr>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=411&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\"border=\"0\"></td>";
                                echo "<form action=\"index.php?op=1008&sop=410&ssop=2&id=".$_GET["id"]."\"method=\"post\">";
                                echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"value=\"".$row["nombre"]."\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Modificar."\"></td>";
                                echo "</form>";
                        echo "</tr>";
                }
                echo "</table></center>";
        }

        if ($soption == 411) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este dato adicional?";
                echo "<br><br><a href=\"index.php?op=1008&sop=410&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=410&id=".$_GET["id"]."\">[ NO ]</a>";
                echo "</center>";
        }

        if (($soption == 420) and ($admin == true)) {
                if ($ssoption == 1) {
                        $sql = "insert into sgm_clients_sector_zf (nombre) ";
                        $sql = $sql."values (";
                        $sql = $sql."'".comillas($_POST["nombre"])."'";
                        $sql = $sql.")";
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 2) {
                        $sql = "update sgm_clients_sector_zf set ";
                        $sql = $sql."nombre='".comillas($_POST["nombre"])."'";
                        $sql = $sql." WHERE id=".$_POST["id"];
                        mysql_query(convert_sql($sql));
                }
                if ($ssoption == 3) {
                        $sql = "delete from sgm_clients_sector_zf WHERE id=".$_GET["id"];
                        mysql_query(convert_sql($sql));
                }
                echo "<strong>".$Sector." ".$Zona."</strong>";
                echo "<br><br>";
				echo "<table><tr>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1008&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
						echo "</td>";
				echo "</tr></table>";
                echo "<center><table cellspacing=\"0\" style=\"width:300px\">";
                        echo "<tr style=\"background-color:silver\">";
                                echo "<td><em>".$Eliminar."</em></td>";
                                echo "<td style=\"width:100px;\"><em>".$Nombre."</em></td>";
                                echo "<td style=\"width:100px;\"></td>";
                        echo "</tr>";
                        echo "<tr>";
                                echo "<form action=\"index.php?op=1008&sop=420&ssop=1\" method=\"post\">";
                                echo "<td></td>";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Anadir."\"></td>";
                                echo "</form>";
                        echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
                $sql = "select * from sgm_clients_sector_zf order by nombre";
                $result = mysql_query(convert_sql($sql));
                while ($row = mysql_fetch_array($result)) {
                        echo "<tr>";
                                echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=421&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\"border=\"0\"></td>";
                                echo "<form action=\"index.php?op=1008&sop=420&ssop=2&id=".$_GET["id"]."\"method=\"post\">";
                                echo "<input type=\"Hidden\" name=\"id\" value=\"".$row["id"]."\">";
                                echo "<td><input style=\"width:150px\" type=\"Text\" name=\"nombre\"value=\"".$row["nombre"]."\"></td>";
                                echo "<td><input style=\"width:100px\" type=\"Submit\" value=\"".$Modificar."\"></td>";
                                echo "</form>";
                        echo "</tr>";
                }
                echo "</table></center>";
        }

        if ($soption == 421) {
                echo "<center>";
                echo "<br><br>¿Seguro que desea eliminar este dato adicional?";
                echo "<br><br><a href=\"index.php?op=1008&sop=420&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=420&id=".$_GET["id"]."\">[ NO ]</a>";
                echo "</center>";
        }

	if ($soption == 500) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=10\" style=\"color:white;\">".$Grupos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=20\" style=\"color:white;\">".$Sectores."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=30\" style=\"color:white;\">".$Ubicaciones."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=40\" style=\"color:white;\">".$Tratos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=50\" style=\"color:white;\">".$Tipos."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=60\" style=\"color:white;\">".$Definiciones."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=70\" style=\"color:white;\">".$Certificaciones."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=80\" style=\"color:white;\">".$Datos_Adicionales."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=99\" style=\"color:white;\">".$Proveedores."</a>";
				echo "</td>";
			echo "</tr><tr>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=400\" style=\"color:white;\">".$Calles."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=410\" style=\"color:white;\">".$Tipos." ".$Calles."</a>";
				echo "</td>";
				echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1008&sop=420\" style=\"color:white;\">".$Sector." ".$Zona."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}

	if ($soption == 550) {
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
							echo "<a href=\"index.php?op=1008&sop=213&id=".$row["id"]."\" style=\"color:white;\">".$Eliminar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table></center>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($soption == 600){
	}




	if ($soption == "999999xxxxx") {
			$sql2 = "select * from Empresas";
			$result2 = mysql_query(convert_sql($sql2));
			while ($row2 = mysql_fetch_array($result2)){

		$sql = "insert into sgm_clients (nombre,direccion,poblacion,cp,provincia,cliente,mail,telefono,web,sector,id_tipo,id_ubicacion)";
		$sql = $sql."values (";
		$sql = $sql."'".$row2["Empres"]."'";
		$sql = $sql.",'".$row2["Direcc"]."'";
		$sql = $sql.",'".$row2["Ciudad"]."'";
		$sql = $sql.",'".$row2["Codpos"]."'";
		$sql = $sql.",'".$row2["Provincia"]."'";

		$sql = $sql.",1";

		$sql = $sql.",'".$row2["E-mail"]."'";
		$sql = $sql.",'".$row2["Telef"]."'";
		$sql = $sql.",'".$row2["Web"]."'";

			$sqlx = "select count(*) as total from sgm_clients_sectors where sector='".$row2["Sector"]."'";
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
			if ($rowx["total"] == 0) {
				$x = 0;
			} else {
				$sql3 = "select * from sgm_clients_sectors where sector='".$row2["Sector"]."'";
				$result3 = mysql_query(convert_sql($sql3));
				$row3 = mysql_fetch_array($result3);
				$x = $row3["id"];
			}
		$sql = $sql.",".$x;

			$sqlx = "select count(*) as total from sgm_clients_tipos where tipo='".$row2["Tipologia"]."'";
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
			if ($rowx["total"] == 0) {
				$x = 0;
			} else {
				$sql3 = "select * from sgm_clients_tipos where tipo='".$row2["Tipologia"]."'";
				$result3 = mysql_query(convert_sql($sql3));
				$row3 = mysql_fetch_array($result3);
				$x = $row3["id"];
			}
		$sql = $sql.",".$x;

			$sqlx = "select count(*) as total from sgm_clients_ubicacion where ubicacion='".$row2["Ubicació"]."'";
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
			if ($rowx["total"] == 0) {
				$x = 0;
			} else {
				$sql3 = "select * from sgm_clients_ubicacion where ubicacion='".$row2["Ubicació"]."'";
				$result3 = mysql_query(convert_sql($sql3));
				$row3 = mysql_fetch_array($result3);
				$x = $row3["id"];
			}
		$sql = $sql.",".$x;


		$sql = $sql.")";
		mysql_query(convert_sql($sql));

				$sql200= "select * from sgm_clients order by id desc";
				$result200 = mysql_query(convert_sql($sql200));
				$row200 = mysql_fetch_array($result200);

				
				$sql20= "select * from Personas where ID=".$row2["ID"];
				$result20 = mysql_query(convert_sql($sql20));
				while ($row20 = mysql_fetch_array($result20)) {
					$sql = "insert into sgm_clients_contactos (id_client,nombre,carrec,departament,telefono,fax,mail,movil,secretari,id_trato)";
					$sql = $sql."values (";
					$sql = $sql."".$row200["id"];
					$sql = $sql.",'".$row20["Nom"]." ".$row20["Ape1"]."'";
					$sql = $sql.",'".$row20["Cargo"]."'";
					$sql = $sql.",'".$row20["Depart"]."'";

					$sql = $sql.",'".$row20["Telef"]."'";
					$sql = $sql.",'".$row20["Fax"]."'";
					$sql = $sql.",'".$row20["E-mail"]."'";
					$sql = $sql.",'".$row20["Mobil"]."'";
					$sql = $sql.",'".$row20["Secretari/a"]."'";

			$sqlx = "select count(*) as total from sgm_clients_tratos where trato='".$row20["Trates"]."'";
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
			if ($rowx["total"] == 0) {
				$x = 0;
			} else {
				$sql3 = "select * from sgm_clients_tratos where trato='".$row20["Trates"]."'";
				$result3 = mysql_query(convert_sql($sql3));
				$row3 = mysql_fetch_array($result3);
				$x = $row3["id"];
			}
		$sql = $sql.",".$x;

					$sql = $sql.")";
					mysql_query(convert_sql($sql));
				}



			}
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1008\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == -1) {
		$sql= "select * from sgm_clients where visible=1";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			if ($row["contacto_nombre"] != ""){
				$sql = "insert into sgm_clients_contactos (id_client,nombre,carrec,departament,telefono,fax,mail,movil,secretari,interlocutor,notas,id_idioma)";
				$sql = $sql."values (";
				$sql = $sql."".$row["id"];
				$sql = $sql.",'".$row["contacto_nombre"]."'";
				$sql = $sql.",'".$row["contacto_carrec"]."'";
				$sql = $sql.",'".$row["contacto_departament"]."'";
				$sql = $sql.",'".$row["contacto_telefono"]."'";
				$sql = $sql.",'".$row["contacto_fax"]."'";
				$sql = $sql.",'".$row["contacto_mail"]."'";
				$sql = $sql.",'".$row["contacto_movil"]."'";
				$sql = $sql.",'".$row["contacto_secretari"]."'";
				$sql = $sql.",'".$row["contacto_interlocutor"]."'";
				$sql = $sql.",'".$row["contacto_notas"]."'";
				$sql = $sql.",".$row["id_idioma"];
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
	}


	if ($soption == -2) {
		$sql= "select * from sgm_clients where visible=1";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			if ($row["cliente"] == 1){
				$sql = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus)";
				$sql = $sql."values (";
				$sql = $sql."".$row["id"];
				$sql = $sql.",1)";
				mysql_query(convert_sql($sql));
			}
			if ($row["proveedor"] == 1){
				$sql = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus)";
				$sql = $sql."values (";
				$sql = $sql."".$row["id"];
				$sql = $sql.",2)";
				mysql_query(convert_sql($sql));
			}
			if ($row["impacto"] == 1){
				$sql = "insert into sgm_clients_classificacio (id_client,id_clasificacio_tipus)";
				$sql = $sql."values (";
				$sql = $sql."".$row["id"];
				$sql = $sql.",3)";
				mysql_query(convert_sql($sql));
			}
		}
	}






	echo "</td></tr></table><br>";

}


function canviar_color($id,$color,$color_lletra)
{
	$sql = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$id;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
		$sqlx = "update sgm_clients_classificacio_tipus set ";
		$sqlx = $sqlx."color='".$color."'";
		$sqlx = $sqlx.",color_lletra='".$color_lletra."'";
		$sqlx = $sqlx." WHERE id=".$row["id"]."";
		mysql_query(convert_sql($sqlx));
		$sqlc = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$row["id"];
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