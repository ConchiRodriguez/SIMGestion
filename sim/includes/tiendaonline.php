<?php

if ($idioma == "es"){ include ("includes/lenguajes/1-es.php");}
	### PARAMETROS
# nualart	$colorbase = "#C83E24";
# multivia	
$colorbase = "#32599E";
#	$colorbase = "#F4BF21";
	$enlace_info = "index.php?op=203";
	$tienda_open = true;
	# si el valor esta en false se trata de un catálogo on-line
	$mostrar_precios = true;

if ($option == 1) { 
	if ($userid != 0) {
		$sqluser = "select * from sgm_users WHERE id=".$userid;
		$resultuser = $db->sql_query($sqluser);
		$rowuser = $db->sql_fetchrow($resultuser);
		$sqluserclient = "select count(*) as total from sgm_users_clients WHERE id_user=".$userid;
		$resultuserclient = $db->sql_query($sqluserclient);
		$rowuserclient = $db->sql_fetchrow($resultuserclient);
		$nclientes = $rowuserclient["total"];
	}

	echo "<center>";
	echo "<a href=\"index.php?op=1&sop=1\"><strong>[ ".$tienda." ]</strong></a>";
	echo "&nbsp;<a href=\"index.php?op=1&sop=30\"><strong>[ ".$buscador." ]</strong></a>";
	echo "&nbsp;<a href=\"index.php?op=1&sop=3\"><strong>[ ".$marcas." ]</strong></a>";
	echo "</center><br>";

	if ($soption == 0) {

	echo "<table><td style=\"width:200px; vertical-align:top;text-align:justify;padding-left : 5px;\">";

		$sqlt = "select count(*) as total from sgm_articles where web=1 AND visible=1";
		$resultt = $db->sql_query($sqlt);
		$rowt = $db->sql_fetchrow($resultt);
		$limite = $rowt["total"];
		$x = rand(1,$limite);
		$sqlxx = "select * from sgm_articles where web=1 AND visible=1";
		$resultxx = $db->sql_query($sqlxx);
		$w = 1;
		while ($rowxx = $db->sql_fetchrow($resultxx)) {
			if ($w == $x) { 
				$sql = "select * from sgm_articles where id=".$rowxx["id"];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				echo "<center><table>";
					echo "<tr><td class=\"style2\">";
						echo "<center><strong>".$row["nombre"]."</strong>";
						$sqlpvp = "select * from sgm_stock where id_article=".$row["id"]." and vigente=1";
						$resultpvp = $db->sql_query($sqlpvp);
						$rowpvp = $db->sql_fetchrow($resultpvp);
						echo "<br>PVP : <strong>".$rowpvp["pvp"]."</strong> € *";
							$sqlf = "select * from sgm_articles_marcas where id=".$row["id_marca"];
							$resultf = $db->sql_query($sqlf);
							$rowf = $db->sql_fetchrow($resultf);
						echo "<br><br>".$fabricante." : <a href=\"".$rowf["web"]."\" target=\"_blank\"><strong>".$rowf["marca"]."</strong></a>";
						if ($row["url"] <> "") { echo "<br>".$info." : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>".$web_del_producto."</strong></a>"; }
#						echo "<br>+info : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>Web producto</strong></a>";
						echo "</td></tr><tr><td><center><img src=\"pics/articulos/".$row["img1"]."\" width=\"150px\"></center></td></tr>";
						echo "</table></center>";
			}
			$w++;
		}

	echo "</td><td style=\"width:350px; vertical-align:top;text-align:justify;padding-left : 5px;\">";
		echo "<br><br><strong>".$nuestras_marcas."</strong><br><br>";
		$sql = "select * from sgm_articles_marcas order by marca";
		$result = $db->sql_query($sql);
		$x = 0;
		while ($row = $db->sql_fetchrow($result)) {
			if ($x == 0 ) { $x++; echo ""; } else { echo ", "; }
			echo "<a href=\"".$row["web"]."\" target=\"_blank\"><strong>".$row["marca"]."</strong></a>";
		}
		if ($tienda_open == true) {
			echo "<br><br><a href=\"index.php?op=1&sop=1\">[ ".$tienda." ]</a>";
			echo "<br><br>".$recuerda."";
		} else {
			echo "<br><br><a href=\"index.php?op=1&sop=1\">[ ".$catalogo."  ]</a>";
			echo "<br><br>".$dispones."";
		}
	echo "</td><td style=\"width:200px; vertical-align:top;text-align:justify;padding-left : 5px;\">";

		$sqlt = "select count(*) as total from sgm_articles where web=1 AND visible=1";
		$resultt = $db->sql_query($sqlt);
		$rowt = $db->sql_fetchrow($resultt);
		$limite = $rowt["total"];
		$x = rand(1,$limite);
		$sqlxx = "select * from sgm_articles where web=1 AND visible=1";
		$resultxx = $db->sql_query($sqlxx);
		$w = 1;
		while ($rowxx = $db->sql_fetchrow($resultxx)) {
			if ($w == $x) { 
				$sql = "select * from sgm_articles where id=".$rowxx["id"];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				echo "<center><table>";
					echo "<tr><td class=\"style2\">";
						echo "<center><strong>".$row["nombre"]."</strong>";
						$sqlpvp = "select * from sgm_stock where id_article=".$row["id"]." and vigente=1";
						$resultpvp = $db->sql_query($sqlpvp);
						$rowpvp = $db->sql_fetchrow($resultpvp);
						echo "<br>".$pvp."<strong>".$rowpvp["pvp"]."</strong> € *";
							$sqlf = "select * from sgm_articles_marcas where id=".$row["id_marca"];
							$resultf = $db->sql_query($sqlf);
							$rowf = $db->sql_fetchrow($resultf);
						echo "<br><br>".$fabricante."<a href=\"".$rowf["web"]."\" target=\"_blank\"><strong>".$rowf["marca"]."</strong></a>";
						if ($row["url"] <> "") { echo "<br>".$info." : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>".$web_del_producto."</strong></a>"; }
#						echo "<br>+info : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>Web producto</strong></a>";
						echo "</td></tr><tr><td><center><img src=\"pics/articulos/".$row["img1"]."\" width=\"150px\"></center></td></tr>";
						echo "</table></center>";
			}
			$w++;
		}

	echo "</td></tr></table>";

	}

	if ($soption == 1) {
		echo "<strong>".$familia."</strong>";
		echo "<table>";
			$sql = "select * from sgm_articles_grupos order by grupo";
			$result = $db->sql_query($sql);
			$x = 0;
			$y = 1;
			while ($row = $db->sql_fetchrow($result)) {
				if ($x == (5 * $y)) {
					echo "</tr><tr>";
					$y = $y+1;
				}
				$total = 0;
				$sqlg = "select * from sgm_articles_subgrupos where id_grupo=".$row['id']." order by subgrupo";
				$resultg = $db->sql_query($sqlg);
				while ($rowg = $db->sql_fetchrow($resultg)) {
					$sqlt = "select count(*) as total from sgm_articles where visible=1 and id_subgrupo=".$rowg["id"]." and web=1";
					$resultt = $db->sql_query($sqlt);
					$rowt = $db->sql_fetchrow($resultt);
					$total = $total + $rowt["total"];
				}
				if ($total != 0) { 
					if ($_GET['idgrupo'] == $row["id"]) { echo "<td style=\"background-color:".$colorbase.";color:White;width:150px;text-align:center;\"><a href=\"index.php?op=1&sop=1&idgrupo=".$row["id"]."\" class=\"style2\" style=\"color:White;\">".$row["grupo"]." (".$total.")</a></td>"; }
					else { echo "<td style=\"width:150px;text-align:center;\"><a href=\"index.php?op=1&sop=1&idgrupo=".$row["id"]."\" class=\"style2\">".$row["grupo"]." (".$total.")</a></td>"; }
					$x = $x+1;
				}
			}
		echo "</table>";
		if ($_GET["idgrupo"] != "") {
			echo "<strong>".$subfamilia."</strong>";
			echo "<table>";
			$sqlg = "select * from sgm_articles_subgrupos where id_grupo=".$_GET['idgrupo']." order by subgrupo";
			$resultg = $db->sql_query($sqlg);
			$x = 0;
			$y = 1;
			while ($rowg = $db->sql_fetchrow($resultg)) {
				if ($x == (5 * $y)) {
					echo "</tr><tr>";
					$y = $y+1;
				}
					$sqlt = "select count(*) as total from sgm_articles where visible=1 and id_subgrupo=".$rowg["id"]." and web=1";
				$resultt = $db->sql_query($sqlt);
				$rowt = $db->sql_fetchrow($resultt);
				if ($rowt["total"] != 0) {
					if ($_GET['idsubgrupo'] == $rowg["id"]) { echo "<td style=\"background-color:".$colorbase.";color:White;width:150px;text-align:center;\"><a href=\"index.php?op=1&sop=1&idgrupo=".$_GET['idgrupo']."&idsubgrupo=".$rowg["id"]."\" class=\"style2\" style=\"color:White;\">".$rowg["subgrupo"]." (".$rowt["total"].")</a></td>";	}
					else { echo "<td style=\"width:150px;text-align:center;\"><a href=\"index.php?op=1&sop=1&idgrupo=".$_GET['idgrupo']."&idsubgrupo=".$rowg["id"]."\" class=\"style2\">".$rowg["subgrupo"]." (".$rowt["total"].")</a></td>"; }
					$x = $x+1;
				}
			}
			echo "</table>";
		}
		if (($_GET["idsubgrupo"] != "") and ($_GET["id"] == "")) {
			busca_articulos("","",$_GET["idsubgrupo"],0,0);
		}
			if ($_GET["id"] <> "") {
					$sql = "select * from sgm_articles where id=".$_GET["id"];
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);

				echo "<br><center>";
				echo "<table style=\"\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
				echo "<td class=\"style2\" style=\"background-color : #DDDDDD;width:15px;vertical-align:middle;\">&nbsp;</td>";
				echo "<td class=\"style2\" style=\"background-color : #DDDDDD;vertical-align:middle;\"><center>";
						if ($row["img1"] != '') { echo "<br><img src=\"pics/articulos/".$row["img1"]."\"><br>"; }
						if ($row["img2"] != '') { echo "<br><img src=\"pics/articulos/".$row["img2"]."\"><br>"; }
						if ($row["img3"] != '') { echo "<br><img src=\"pics/articulos/".$row["img3"]."\"><br>"; }
						echo "<br>";
					echo "</center></td>";
				echo "<td class=\"style2\" style=\"background-color : #DDDDDD;width:15px;vertical-align:middle;\">&nbsp;</td>";
				echo "<td class=\"style2\" style=\"background-color : #DDDDDD;width:100%;vertical-align:middle;\">";

					echo "<strong>".$row["nombre"]."</strong>";
						$sqlpvp = "select * from sgm_stock where id_article=".$row["id"]." and vigente=1";
						$resultpvp = $db->sql_query($sqlpvp);
						$rowpvp = $db->sql_fetchrow($resultpvp);
							echo "<br>".$pvp."<strong>".number_format($rowpvp["pvp"], 2, ',', '.')."</strong> € *";
							echo "<br><a href=\"index.php?op=1&sop=6&id_articulo=".$row["id"]."\"><img src=\"images/comprar.jpg\" border=\"0\"></a>";
								$sqlf = "select * from sgm_articles_marcas where id=".$row["id_marca"];
								$resultf = $db->sql_query($sqlf);
								$rowf = $db->sql_fetchrow($resultf);
							if ($row["id_marca"] != 0) { 
								if ($rowf["logo"] != "") { echo "<br><br><img src=\"images/marcas/".$rowf["logo"]."\">"; }
								echo "<br><br>".$fabricante."<a href=\"".$rowf["web"]."\" target=\"_blank\"><strong>".$rowf["marca"]."</strong></a>";
							}
								else { echo "<br><br>".$fabricante."<strong>Multivia.com</strong>";}
							if ($row["url"] != "") { echo "<br>".$info." : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>".$web_del_producto."</strong></a>"; }
								else  { echo "<br>".$info." : <strong>".$no_disponible."</strong>"; }
					echo "<br><br>".$row["notas"];
					echo "<br><br><em>".$articulo."".$rowpvp["fecha"]."</em>";
					echo "<br><br>".$iva."";
				echo "</td></tr></table></center>";
			}






	}




	if ($soption == 3) {
		$sql = "select * from sgm_articles_marcas order by marca";
		$result = $db->sql_query($sql);
		echo "<center><table cellpadding=\"5\"><tr>";
		$x = 0;
		$y = 1;
		while ($row = $db->sql_fetchrow($result)) {
			if ($x == (7 * $y)) {
				echo "</tr><tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr><tr>";
				$y = $y+1;
			}
			echo "<td style=\"text-align:center;\">";
			if ($row["logo"] == "") {
				echo "<strong style=\"font-size : 14px;font-family : \"Arial Black\";\">".$row["marca"]."</strong>";
			} else {
				echo "<img src=\"images/marcas/".$row["logo"]."\">";
			}
			echo "<br>";
			echo "<a href=\"index.php?op=1&sop=4&idmarca=".$row["id"]."\" class=\"style2\">[ ".$productos." ]</a><br>";
			echo "<a href=\"".$row["web"]."\" class=\"style2\"><strong>".$row["marca"]."</strong></a></td>";
			$x = $x+1;
		}
		echo "</tr></table></center>";
	}


	if ($soption == 4) {
		if ($_GET["idmarca"] != "") {
			busca_articulos("",$_GET["idmarca"],"",0,0);
		}
	}

	if ($soption == 5) {
		if ($nclientes == 0) { echo $mensaje_nocliente;	}
		if ($nclientes != 0) {

			$sqluserclient = "select * from sgm_users_clients WHERE id_user=".$userid;
			$resultuserclient = $db->sql_query($sqluserclient);
			echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			while ($rowuserclient = $db->sql_fetchrow($resultuserclient)) {
				$sqltipos = "select * from sgm_factura_tipos where id=12";
				$resulttipos = $db->sql_query($sqltipos);
				$sqlg = "select * from sgm_clients where id=".$rowuserclient["id_client"];
				$resultg = $db->sql_query($sqlg);
				$rowg = $db->sql_fetchrow($resultg);
				echo "<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>";
				echo "<tr><td></td><td></td><td></td><td>".$cesta."<strong>".$rowg["nombre"]."</strong></td><td></td><td></td></tr>";
				echo "<tr><td></td><td style=\"width:70px\"><em><center>".$numero."</center></em></td><td style=\"width:85px\"><em>".$fecha."</em></td><td style=\"width:220px\"><em>".$cliente."</em></td><td style=\"width:80px\"><em>".$total."</em></td><td></td></tr>";
				echo "<tr>";
				while ($rowtipos = $db->sql_fetchrow($resulttipos)) {
					$sql = "select * from sgm_cabezera where visible=1 AND tipo=12 AND id_cliente=".$rowuserclient["id_client"]." order by numero desc,fecha desc";
					$result = $db->sql_query($sql);
					$fechahoy = getdate();
					$data1 = date("Y-m-d", mktime(0,0,0,$fechahoy["mon"] ,$fechahoy["mday"]-100, $fechahoy["year"]));
					while ($row = $db->sql_fetchrow($result)) {
						if (($data1 <= $row["fecha"]) OR ($row["cobrada"] == 0)) {
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1&sop=8&id=".$row["id"]."\">[E]</a></td>";
								echo "<td><center>".$row["numero"]."</center></td>";
									$a = date("Y", strtotime($row["fecha"]));
									$m = date("m", strtotime($row["fecha"]));
									$d = date("d", strtotime($row["fecha"]));
									$date = getdate();
									if ($date["year"]."-".$date["mon"]."-".$date["mday"] < $row["fecha"]) {
										$fecha_proxima = $row["fecha"];
									}
									else { 
										$fecha_proxima = $row["fecha"];
										$multiplica = 0;
										$sql00 = "select * from sgm_facturas_relaciones where id_plantilla=".$row["id"]." order by fecha";
										$result00 = $db->sql_query($sql00);
										while ($row00 = $db->sql_fetchrow($result00)) {
											if ($fecha_proxima == $row00["fecha"]) {
												$multiplica++;
												$fecha_proxima = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*$multiplica), $a));
											}
										}
									}
								if ($rowtipos["dias"] == 0) { echo "<td style=\"text-align:center;\"><strong>".$row["fecha"]."</strong></td>"; }
									else { 
										if ($fecha_proxima > $date1) {
											$fecha_aviso = date("Y-m-d", mktime(0,0,0,$m ,$d+($rowtipos["dias"]*($multiplica))-10, $a));
											if ($fecha_aviso <  $date1) { echo "<td style=\"background-color:orange;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
											else { echo "<td style=\"text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
										}
										else { echo "<td style=\"background-color:red;color:White;text-align:center;\">I: ".$row["fecha"]."<br><strong>P: ".$fecha_proxima."</strong></td>"; }
									}
								echo "<td>".$row["nombre"]."</td>";
								echo "<td style=\"text-align : right;\">".$row["total"]." €</td>";
								echo "<td><a href=\"index.php?op=1&sop=22&id=".$row["id"]."\">&nbsp;[".$modificar."]</a></td>";
								echo "<td><a href=\"".$urloriginal."/includes/gestion-facturas-print.php?id=".$row["id"]."\" target=\"_blank\">&nbsp;[".$imprimir."]</a></td>";
								echo "<td>";
								echo "<td><a href=\"index.php?op=1&sop=27&id=".$row["id"]."\">&nbsp;[".$procesar."]</a></td>";
								echo "</td>";
							echo "</tr>";
						}
					}
				}
			}
			echo "</table>";
		}
	}

	if ($soption == 6) {
		if ($user == true) {
			if ($nclientes == 0) { 
				echo "<br>".$hacer_pedido."<a href=\"index.php?op=200&sop=30\"><strong style=\"color:".$colorbase.";\">".$CLICK_AQUI."</strong></a>.";
			}
			if ($nclientes != 0) {
				echo "<table>";
					echo "<tr><td></td><td>".$client."</td><td>".$unidades."</td><td></td><td></td></tr>";
					echo "<tr>";
					echo "<form action=\"index.php?op=1&sop=7&id_articulo=".$_GET["id_articulo"]."\" method=\"post\">";
							$sql = "select * from sgm_articles where id=".$_GET["id_articulo"];
							$result = $db->sql_query($sql);
							$row = $db->sql_fetchrow($result);
						echo "<td>";
							echo "<strong>".$row["nombre"]."</strong>";
						echo "</td>";
						echo "<td>";
							echo "<select name=\"id_client\">";
							$sqluserclient = "select * from sgm_users_clients WHERE id_user=".$userid;
							$resultuserclient = $db->sql_query($sqluserclient);
							echo "<table cellpadding=\"0\" cellspacing=\"0\">";
							while ($rowuserclient = $db->sql_fetchrow($resultuserclient)) {
								$sqlg = "select * from sgm_clients where id=".$rowuserclient["id_client"];
								$resultg = $db->sql_query($sqlg);
								$rowg = $db->sql_fetchrow($resultg);
								echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre"]."</option>";
							}
							echo "</select>";
						echo "</td>";
						echo "<td>";
							echo "<input type=\"text\" value=\"1\" size=\"4\" name=\"unidades\">";
						echo "</td>";
						echo "<td>";
							echo "<strong>".$row["pvp"]." €</strong>";
						echo "</td>";
						echo "<td>";
							echo "<input type=\"Submit\" value=\"Añadir a la cesta\">";
						echo "</td>";
					echo "</form>";
					echo "</tr>";
				echo "</table>";
			}
		} else {
			echo "<center>".$compra."";
			echo "<br><br>".$hacer_login."<a href=\"index.php?op=100\"><strong style=\"color:".$colorbase.";\">".$CLICK_AQUI."</strong></a>";
			echo "<br>".$registrarse."<a href=\"index.php?op=100&sop=1\"><strong style=\"color:".$colorbase.";\">".$CLICK_AQUI."</strong></a></center>";
		}
		echo "<br><br>";
	}

	if ($soption == 7) {
			$sqltipos = "select count(*) as total from sgm_cabezera where (tipo=12) and (id_cliente=".$_POST["id_client"].") and visible=1";
			$resulttipos = $db->sql_query($sqltipos);
			$rowtipos = $db->sql_fetchrow($resulttipos);
			if ($rowtipos["total"] == 0) {
					$sql = "select * from sgm_clients where id=".$_POST["id_client"];
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$sql = "insert into sgm_cabezera (numero,fecha,tipo,nombre,nif,direccion,poblacion,cp,provincia,mail,telefono,onombre,onif,odireccion,opoblacion,ocp,oprovincia,omail,otelefono,id_cliente,id_user) ";
					$sql = $sql."values (";
						$sqlxx = "select * from sgm_cabezera where tipo=12 order by numero desc";
						$resultxx = $db->sql_query($sqlxx);
						$rowxx = $db->sql_fetchrow($resultxx);
						$numero = $rowxx["numero"] + 1;
					$sql = $sql."".$numero."";
						$date = getdate();
						$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
					$sql = $sql.",'".$date1."'";
					$sql = $sql.",12";
					$sql = $sql.",'".$row["nombre"]."'";
					$sql = $sql.",'".$row["nif"]."'";
					$sql = $sql.",'".$row["direccion"]."'";
					$sql = $sql.",'".$row["poblacion"]."'";
					$sql = $sql.",'".$row["cp"]."'";
					$sql = $sql.",'".$row["provincia"]."'";
					$sql = $sql.",'".$row["mail"]."'";
					$sql = $sql.",'".$row["telefono"]."'";
					$sql2 = "select * from sgm_dades_origen_factura";
					$result2 = $db->sql_query($sql2);
					$row = $db->sql_fetchrow($result2);
					$sql = $sql.",'".$row["nombre"]."'";
					$sql = $sql.",'".$row["nif"]."'";
					$sql = $sql.",'".$row["direccion"]."'";
					$sql = $sql.",'".$row["poblacion"]."'";
					$sql = $sql.",'".$row["cp"]."'";
					$sql = $sql.",'".$row["provincia"]."'";
					$sql = $sql.",'".$row["mail"]."'";
					$sql = $sql.",'".$row["telefono"]."'";
					$sql = $sql.",".$_POST["id_client"];
					$sql = $sql.",".$userid;
					$sql = $sql.")";
					$db->sql_query($sql);
			}
		$sqlxx = "select * from sgm_cabezera where tipo=12 and (id_cliente=".$_POST["id_client"].") and visible=1 order by id desc";
		$resultxx = $db->sql_query($sqlxx);
		$rowxx = $db->sql_fetchrow($resultxx);
		$id_factura = $rowxx["id"];
		$sql = "select * from sgm_articles where id=".$_GET["id_articulo"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);

		$sql23 = "select * from sgm_stock where id_article=".$row["id"]." and vigente=1";
		$result23 = $db->sql_query($sql23);
		$row23 = $db->sql_fetchrow($result23);

		$sql = "insert into sgm_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total,id_article) ";
		$sql = $sql."values (";
		$sql = $sql."".$id_factura;
		$sql = $sql.",'".$row["codigo"]."'";
		$sql = $sql.",'".$row["nombre"]."'";
		$sql = $sql.",".$row23["pvd"];
		$sql = $sql.",".$row23["pvp"];
		$sql = $sql.",".$_POST["unidades"];
		$total = $_POST["unidades"] * $row23["pvp"];
		$sql = $sql.",".$total;
		$sql = $sql.",".$row["id"]."";
		$sql = $sql.")";
		$db->sql_query($sql);
		refactura($id_factura);
		echo "".$anadir."";
		echo "<br><br><a href=\"index.php?op=1&sop=5\">[ ".$volver." ]</a>";
	}

	if ($soption == 8) {
		echo "<br><br>".$seguro."";
		echo "<br><br><a href=\"index.php?op=1&sop=9&id=".$_GET["id"]."\">[ ".$SI." ]</a>";
		echo "<a href=\"index.php?op=1&sop=5\">[ ".$NO." ]</a>";
	}

	if ($soption == 9) {
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultcabezera = $db->sql_query($sqlcabezera);
		$rowcabezera = $db->sql_fetchrow($resultcabezera);
		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
		$resultpermiso = $db->sql_query($sqlpermiso);
		$rowpermiso = $db->sql_fetchrow($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }
		if ($autorizado == true) {
			$sql = "update sgm_cabezera set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			$db->sql_query($sql);
			echo "<br><br>".$operacion."";
			echo "<br><br><a href=\"index.php?op=1&sop=5\">[ ".$volver." ]</a>";
		}
		else {
			echo "<strong>".$autorizado."</strong>";
		}
	}

	if ($soption == 22) {

		$sql = "select * from sgm_cabezera where id=".$_GET["id"]." ORDER BY id";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);

		echo "<br><br>";
		echo "<table><tr><td width=\"250\">";
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr><td width=\"100\"><strong>".$numero."</strong></td><td><strong>".$row["numero"]."</strong></td></tr>";
				echo "<tr><td><strong>".$fecha."</strong></td><td><strong>".$row["fecha"]."</strong></td></tr>";
				echo "<tr><td>".$nombre."</td><td><strong>".$row["nombre"]."</strong></td></tr>";
				echo "<tr><td>".$NIF."</td><td><strong>".$row["nif"]."</strong></td></tr>";
				echo "<tr><td>".$direccion."</td><td><strong>".$row["direccion"]."</strong></td></tr>";
				echo "<tr><td>".$poblacion."</td><td><strong>".$row["poblacion"]."</strong></td></tr>";
				echo "<tr><td>".$codigo_postal."</td><td><strong>".$row["cp"]."</strong></td></tr>";
				echo "<tr><td>".$provincia."</td><td><strong>".$row["provincia"]."</strong></td></tr>";
				echo "<tr><td>".$Email."</td><td><strong>".$row["mail"]."</strong></td></tr>";
				echo "<tr><td>".$telefono."</td><td><strong>".$row["telefono"]."</strong></td></tr>";
				echo "</table>";
		echo "</td><td valign=\"top\">";
			echo "<table>";
				echo "<tr>";
					echo "<form action=\"index.php?op=1&sop=24\" method=\"post\">";
					echo "<td>";
						echo "<input type=\"Hidden\" name=\"idfactura\" value=\"".$_GET["id"]."\">";
						echo "<select name=\"cliente\" style=\"width:300px\">";
							$sqlx = "select * from sgm_clients where visible=1 order by nombre";
							$resultx = $db->sql_query($sqlx);
							while ($rowx = $db->sql_fetchrow($resultx)) {
								$autorizado = false;
								$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowx["id"]." and id_user=".$userid;
								$resultpermiso = $db->sql_query($sqlpermiso);
								$rowpermiso = $db->sql_fetchrow($resultpermiso);
								if ($rowpermiso["total"] == 1) { $autorizado = true; }
								if ($autorizado == true) {
									if ($rowx["id"] == $row["id_cliente"]) {	echo "<option value=\"".$rowx["id"]."\" selected>".$rowx["nombre"]."</option>"; }
									else { 	echo "<option value=\"".$rowx["id"]."\">".$rowx["nombre"]."</option>"; }
								}
							}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Submit\" value=\"Cambio cliente\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			echo "".$cambiar_cesta."";
			echo "<br><br>".$cambiar_numero."";
		echo "</td></tr></table>";

		echo "<br><br>";
		echo "<table>";
		echo "<tr><td></td><td><em>".$codigo."</em></td><td><em>".$nombre."</em></td><td><em>".$precio."</em></td><td><em>".$unidades."</em></td><td><em>".$total."</em></td><td></td></tr>";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
				echo "<td><a href=\"index.php?op=1&sop=25&idfactura=".$_GET["id"]."&id=".$row["id"]."\">[ ".$borrar." ]</a></td>";
				echo "<form action=\"index.php?op=1&sop=23&idfactura=".$_GET["id"]."&id=".$row["id"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"pvp\" value=\"".$row["pvp"]."\">";
				echo "<td><input type=\"Text\" disabled style=\"width:75px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" disabled style=\"width:350px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Text\" disabled style=\"text-align:right;width:50px\" value=\"".$row["pvp"]."\">€</td>";
				echo "<td><input type=\"Text\" name=\"unidades\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td><input type=\"Text\" disabled style=\"text-align:right;width:50px\" value=\"".$row["total"]."\"> €</td>";
				echo "<td><input type=\"Submit\" value=\"Modif.\" style=\"width:50px\"></td>";
				echo "</form>";
		echo "</tr>";
		}
		$sql = "select * from sgm_cabezera where id=".$_GET["id"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
			echo "<tr><td></td><td></td><td></td><td></td><td style=\"text-align:right;\"><em>".$subtotal."</em></td><td style=\"text-align:right;\">".$row["subtotal"]." €</td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td></td><td style=\"text-align:right;\"><em>".$descuento."</em></td><td style=\"text-align:right;\">".$row["descuento"]."%</td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td></td><td style=\"text-align:right;\"><em>".$subtotal."</em></td><td style=\"text-align:right;\">".$row["subtotaldescuento"]." €</td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td></td><td style=\"text-align:right;\"><em>".$IVA."</em></td><td style=\"text-align:right;\">".$row["iva"]."%</td><td></td></tr>";
			echo "<tr><td></td><td></td><td></td><td></td><td style=\"text-align:right;\"><em>".$total."</em></td><td style=\"text-align:right;\">".$row["total"]." €</td><td></td></tr>";
		echo "</table>";
		echo "<br><br>";
	}

	if ($soption == 23) {
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["idfactura"];
		$resultcabezera = $db->sql_query($sqlcabezera);
		$rowcabezera = $db->sql_fetchrow($resultcabezera);
		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
		$resultpermiso = $db->sql_query($sqlpermiso);
		$rowpermiso = $db->sql_fetchrow($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }
		if ($autorizado == true) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."pvp=".$_POST["pvp"];
			$sql = $sql.",unidades=".$_POST["unidades"];
			$total = $_POST["unidades"] * $_POST["pvp"];
			$sql = $sql.",total=".$total;
			$sql = $sql." WHERE id=".$_GET["id"]."";
			$db->sql_query($sql);
			refactura($_GET["idfactura"]);
			echo "<br><br>".$operacion."";
			echo "<br><br><a href=\"index.php?op=1&sop=22&id=".$_GET["idfactura"]."\">[ ".$volver." ]</a>";
		}
		else {
			echo "<strong>".$autorizado."</strong>";
		}
	}

	if ($soption == 24) {
		$sql = "select * from sgm_clients where id=".$_POST["cliente"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);

		$sql = "update sgm_cabezera set ";
		$sql = $sql."nombre='".$row["nombre"]."'";
		$sql = $sql.",nif='".$row["nif"]."'";
		$sql = $sql.",direccion='".$row["direccion"]."'";
		$sql = $sql.",poblacion='".$row["poblacion"]."'";
		$sql = $sql.",cp='".$row["cp"]."'";
		$sql = $sql.",provincia='".$row["provincia"]."'";
		$sql = $sql.",mail='".$row["mail"]."'";
		$sql = $sql.",telefono='".$row["telefono"]."'";
		$sql = $sql.",id_cliente=".$row["id"]."";
		$sql = $sql." WHERE id=".$_POST["idfactura"]."";
		$db->sql_query($sql);
		echo "<br><br>".$operacion."";
		echo "<br><br><a href=\"index.php?op=1&sop=22&id=".$_POST["idfactura"]."\">[ ".$volver." ]</a>";
	}

	if ($soption == 25) {
		echo "<br><br>".$seguro2."";
		echo "<br><br><a href=\"index.php?op=1&sop=26&idfactura=".$_GET["idfactura"]."&id=".$_GET["id"]."\">[ ".$SI." ]</a><a href=\"index.php?op=1&sop=22&id=".$_GET["idfactura"]."\">[ ".$NO." ]</a>";
	}

	if ($soption == 26) {
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["idfactura"];
		$resultcabezera = $db->sql_query($sqlcabezera);
		$rowcabezera = $db->sql_fetchrow($resultcabezera);
		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
		$resultpermiso = $db->sql_query($sqlpermiso);
		$rowpermiso = $db->sql_fetchrow($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }
		if ($autorizado == true) {
			$sql = "delete from sgm_cuerpo WHERE id=".$_GET["id"];
			$db->sql_query($sql);
			refactura($_GET["idfactura"]);
			echo "<br><br>".$operacion."";
			echo "<br><br><a href=\"index.php?op=1&sop=22&id=".$_GET["idfactura"]."\">[ ".$volver." ]</a>";
		}
		else {
			echo "<strong>".$autorizado."</strong>";
		}
	}

	##### FORMULARIO ENVIO BANCO
	if ($soption == 27) {
		$sql = "select * from sgm_cabezera where id=".$_GET["id"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		echo "<center>";
		echo "<br>".$compra_segura."";
		echo "<br><br>".$entidad_bancaria."";
		echo "<br><br>".$pago."";

		echo "<form method=\"post\" action=\"https://sis-t.sermepa.es:25443/sis/realizarPago\">";

		echo "<br><table style=\"width:400px;\"><tr><td style=\"border : 1px solid Black;\">";

		$amount =  number_format($row["total"], 2, '', ''); #importe
		$currency='978'; #moneda euro
		$order = date('ymdHis'); #orden de transaccion
		$producto=$row["numero"]; #numero de pedido
		$titular = substr($row["nombre"], 0, 59); #titular MAX 60 car
		$code='999008881'; #código FUC asignado al comercio
		$urlMerchant= "http://sis-d5.sermepa.es/sis/pruebaCom.jsp";
		$Ds_Merchant_UrlOK = "http://www.multivia.com/inici/index.php?op=1&sop=28&ok=1";
		$Ds_Merchant_UrlKO = "http://www.multivia.com/inici/index.php?op=1&sop=28&ok=0";
		$Ds_Merchant_MerchantName='Multivia.com';

		$clave='qwertyasdf0123456789';
		$terminal='4';
		$transactionType='0';



		echo "<input type=hidden name=Ds_Merchant_Amount value=".$amount.">";
		echo "<input type=hidden name=Ds_Merchant_Currency value=".$currency.">";
		echo "<input type=hidden name=Ds_Merchant_Order  value=".$order.">";
		echo "<input type=hidden name=Ds_Merchant_Merchant_ProductDescription value=".$producto.">";
		echo "<input type=hidden name=Ds_Merchant_Merchant_Titular value=".$titular.">";
		echo "<input type=hidden name=Ds_Merchant_MerchantCode value=".$code.">";
		echo "<input type=hidden name=Ds_Merchant_MerchantURL value=".$urlMerchant.">";
		echo "<input type=hidden name=Ds_Merchant_UrlOK value=".$Ds_Merchant_UrlOK.">";
		echo "<input type=hidden name=Ds_Merchant_UrlKO value=".$Ds_Merchant_UrlKO.">";
		echo "<input type=hidden name=Ds_Merchant_MerchantName value=".$Ds_Merchant_MerchantName.">";


		echo "<input type=hidden name=Ds_Merchant_Terminal value='$terminal'>";
		echo "<input type=hidden name=Ds_Merchant_TransactionType value='$transactionType'>";
		$message = $amount.$order.$code.$currency.$transactionType.$urlMerchant.$clave;
		$signature = strtoupper(sha_1($message));
		echo "<input type=hidden name=Ds_Merchant_MerchantSignature value='$signature'>";

		echo "<br><strong>".$num_orden."</strong>".$order;
		echo "<br><strong>".$num_pedido." </strong>".$producto;
		echo "<br><strong>".$importe."</strong>".$row["total"];
		echo "<br><strong>".$cliente."</strong>".$titular;

		echo "<br><br>";
		echo "</td></tr></table><br>";

			echo "<input type=\"Submit\" value=\"Ir a mi entidad bancaria\" style=\"width:400px;\">";
		echo "</form>";
		echo "</center>";
	}

	if ($soption == 28) {
		if ($_GET["ok"] == 1) {
			echo "".$compra_correcta."";
		}
		if ($_GET["ok"] == 0) {
			echo "".$error."";
		}
	}




	if ($soption == 30) {
		echo "<strong>".$buscador2."</strong><br><br>";
		echo "<table>";
			echo "<form action=\"index.php?op=1&sop=31\" method=\"post\">";
			echo "<tr><td style=\"text-align:right;\">".$nombre."</td><td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$precio."</td>";
					echo "<td><table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"text-align:middle;\">".$desde."</td>";
							echo "<td style=\"width:3px\"></td>";
							echo "<td style=\"text-align:middle;\">".$hasta."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><input type=\"Text\" name=\"min\" style=\"width:73px;text-align:right;\" value=\"0.00\"></td>";
							echo "<td style=\"width:3px\"></td>";
							echo "<td><input type=\"Text\" name=\"max\" style=\"width:73px;text-align:right;\" value=\"0.00\"></td>";
						echo "</tr>";
					echo "</table></td>";
				echo "</tr>";
				echo "<tr><td style=\"text-align:right;\">".$marca."</td><td><select style=\"width:150px\" name=\"id_marca\">";
				echo "<option value=\"0\">-</option>";
				$sqlg1 = "select * from  sgm_articles_marcas order by marca";
				$resultg1 = $db->sql_query($sqlg1);
				while ($rowg1 = $db->sql_fetchrow($resultg1)) { echo "<option value=\"".$rowg1["id"]."\">".$rowg1["marca"]."</option>"; }
			echo "</select></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$fam_sub."</td><td><select style=\"width:150px\" name=\"id_subgrupo\">";
				echo "<option value=\"0\">-</option>";
				$sqlg1 = "select * from  sgm_articles_grupos order by grupo";
				$resultg1 = $db->sql_query($sqlg1);
				while ($rowg1 = $db->sql_fetchrow($resultg1)) { 
					$sqlg2 = "select * from  sgm_articles_subgrupos where id_grupo=".$rowg1["id"]." order by subgrupo";
					$resultg2 = $db->sql_query($sqlg2);
					while ($rowg2 = $db->sql_fetchrow($resultg2)) { 
						echo "<option value=\"".$rowg2["id"]."\">".$rowg1["grupo"]."-".$rowg2["subgrupo"]."</option>";
					}
				}
			echo "</select></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"".$buscar."\" style=\"width:150px\"></td></tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 31) {

		busca_articulos($_POST["nombre"],$_POST["id_marca"],$_POST["id_subgrupo"],$_POST["min"],$_POST["max"]);

	}
				
	if ($soption == 51) {
		echo "<strong>".$funcionamiento."</strong>";
		echo "<br><br><table cellspacing=\"20\">";
			echo "<tr>";
				echo "<td style=\"width:300px;text-align:center;vertical-align:top\"><img src=\"images/registrarse.jpg\" border=\"0\"><br><br><br><br><br><br><br><br>";
				echo "<style=\"width:300px;text-align:center;vertical-align:top\"><img src=\"images/cesta.jpg\" border=\"0\"><br><br><br><br><br><br><br><br>";
				echo "<style=\"width:300px;text-align:center;vertical-align:top\"><img src=\"images/pasar_por_caja.jpg\" border=\"0\"></td>";
				echo "<td style=\"text-align: justify\">";
					echo "<ol><li><a class=\"tocxref\" href=\"#0.1\">".$primeros_pasos."</a></li>";
					echo "<li><a class=\"tocxref\" href=\"#0.2\">".$como_comprar."</a></li>";
					echo "<li><a class=\"tocxref\" href=\"#0.3\">".$como_pagar."</a></li>";
					echo "<li><a class=\"tocxref\" href=\"#0.4\">".$envio_compra."</a></li>";
					echo "</ol>";
					echo "<br><a name=\"0.1\"><strong>1. ".$primeros_pasos."</strong></a></a><br><br>";
					echo "".$primero."";
					echo "<br><br>".$segundo."";
					echo "<a href=\"mailto:info@multivia.com\">info@multivia.com</a>";
					echo "<br><br><br><a name=\"0.2\"><strong>2. ".$como_comprar."</strong></a></a><br><br>".$tercero."";
					echo "<br><br>".$cuarto."";
					echo "<br><br>".$quinto."";
					echo "<br><br><br><a name=\"0.3\"><strong>3. ".$como_pagar."</strong></a></a><br><br>";
					echo "".$sexto."";
					echo "<a href=\"http://www.sermepa.es/espanol/index.htm\">Sermepa</a>.".$septimo."";
					echo "<br><br><br><a name=\"0.4\"><strong>4. ".$envio_compra."</strong></a></a><br><br>";
					echo "".$octavo."";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}

	echo "<br><br>".$duda."<a href=\"".$enlace_info."\"><strong style=\"color:".$colorbase."\">".$CLICK_AQUI."</strong></a>";

}



function busca_articulos($nombre,$id_marca,$id_subgrupo,$min,$max) 
{ 
	global $db;
				$sqlt = "select count(*) as total from sgm_articles where visible=1 and web=1";
				if ($id_marca > 0) { $sqlt = $sqlt." and id_marca=".$id_marca; }
				if ($id_subgrupo > 0) { $sqlt = $sqlt." and id_subgrupo=".$id_subgrupo; }
				if ($nombre != "") { $sqlt = $sqlt." and nombre LIKE '%".$nombre."%'"; }
				$sqlt = $sqlt." order by nombre";

				$resultt = $db->sql_query($sqlt);
				$rowt = $db->sql_fetchrow($resultt);
				echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
				if ($rowt["total"] <> 0) {
					$x = 0;
					$sql = "select * from sgm_articles where visible=1 and web=1";
					if ($id_marca > 0) { $sql = $sql." and id_marca=".$id_marca; }
					if ($id_subgrupo > 0) { $sql = $sql." and id_subgrupo=".$id_subgrupo; }
					if ($nombre != "") { $sql = $sql." and (nombre LIKE '%".$nombre."%')"; }

					$sql = $sql." order by nombre";

					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result)) {

						$sqlpvp = "select * from sgm_stock where id_article=".$row["id"]." and vigente=1";
						$resultpvp = $db->sql_query($sqlpvp);
						$rowpvp = $db->sql_fetchrow($resultpvp);

						if ($max == 0) { $pvp_max = 999999999; } else { $pvp_max = $max; }

						if (($min <= $rowpvp["pvp"]) and ($pvp_max >= $rowpvp["pvp"])) {

							if ($x == 0) { echo "<tr style=\"background-color : #D8D8D8;\">"; }
							if ($x == 1) { echo "<tr>"; }
								$sqlm = "select * from sgm_articles_subgrupos where id=".$row["id_subgrupo"];
								$resultm = $db->sql_query($sqlm);
								$rowm = $db->sql_fetchrow($resultm);
								$sqlmarca = "select * from sgm_articles_marcas where id=".$row["id_marca"];
								$resultmarca = $db->sql_query($sqlmarca);
								$rowmarca = $db->sql_fetchrow($resultmarca);
								echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1&sop=4&idmarca=".$rowmarca["id"]."\" style=\"color:".$colorbase.";\">".$rowmarca["marca"]."</a>&nbsp;</td>";
								echo "<td>&nbsp;<strong>".$row["codigo"]."</strong>&nbsp;&nbsp;</td>";
								echo "<td style=\"text-align:left; width:350px\" class=\"style2\"><a href=\"index.php?op=1&sop=1&idgrupo=".$rowm["id_grupo"]."&idsubgrupo=".$row["id_subgrupo"]."&id=".$row["id"]."\" class=\"style2\" style=\"color: black;\">".$row["nombre"]."</a></td>";

								$sqltxx = "select SUM(unidades) as total from sgm_stock where id_article=".$row["id"];
								$resulttxx = $db->sql_query($sqltxx);
								$rowtxx = $db->sql_fetchrow($resulttxx);
								echo "<td style=\"text-align:right; width:50px\" class=\"style2\">".number_format($rowtxx["total"], 1, ',', '.')."&nbsp;Unid.</td>";

								if ($mostrar_precios == true) {
									echo "<td style=\"text-align:right; width:75px\" class=\"style2\">".number_format($rowpvp["pvp"], 2, ',', '.')."&nbsp;€&nbsp;</td>";
								}

								$sqltxx = "select * from sgm_users_permisos_modulos where id_modulo=1003";
								$resulttxx = $db->sql_query($sqltxx);
								$rowtxx = $db->sql_fetchrow($resulttxx);
								if ($rowtxx["visible"] == 1) {
									echo "<td><a href=\"index.php?op=1&sop=6&id_articulo=".$row["id"]."\"><img src=\"images/comprar.jpg\" border=\"0\"></a></td>";
								} else { echo "<td></td>"; }
						}

						echo "</tr>";
						if ($x == 0) { $x = 1; } else { $x = 0; }
					}
				} else { echo "<tr><td class=\"style2\">".$no_disponibles."</td></tr>"; }
				echo "</table></center>";
}

?>