<?php

if ($funcio == 1) {
		echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=2&id=".$_GET["id"]."&id_tipo=".$_GET["id_tipo"]."\" method=\"post\">";
		$sql = "select * from sgm_cabezera where visible=1 and id=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>Numero factura : </td>";
				echo "<td>".$row["numero"]."</td>";
				echo "<td>Fecha : ".$row["fecha"]."</td>";
				echo "<td>Cliente : </td>";
			$sqlc = "select * from sgm_clients where visible=1 and id=".$row["id_cliente"];
			$resultc = mysql_query(convert_sql($sqlc));
			$rowc = mysql_fetch_array($resultc);
				echo "<td>".$rowc["nombre"]."</td>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"width:100px;\"><strong>Codigo</strong></td>";
				echo "<td style=\"width:150px;\"><strong>Nombre del articulo</strong></td>";
				echo "<td style=\"width:100px;\"><strong>Unidades</strong></td>";
				echo "<td style=\"width:50px;\"><strong>Unidades a traspasar</strong></td>";
				echo "<td style=\"text-align:center;\"><strong>Traspasar</strong></td>";
			echo "</tr>";
		$sqlcu = "select * from sgm_cuerpo where idfactura=".$_GET["id"];
		$resultcu = mysql_query(convert_sql($sqlcu));
		while ($rowcu = mysql_fetch_array($resultcu)){
			echo "<tr>";
				echo "<td style=\"width:100px;\">".$rowcu["codigo"]."</td>";
				echo "<td style=\"width:150px;\">".$rowcu["nombre"]."</td>";
				echo "<td style=\"width:100px;\">".$rowcu["unidades"]."</td>";
				echo "<td style=\"width:50px;\"><input name=\"unitats_".$rowcu["id"]."\" value=\"".$rowcu["unidades"]."\" type=\"text\"></td>";
				if (($_POST["traspasar_".$rowcu["id"]] == true) or ($_POST["traspasar_".$rowcu["id"]] == "")) {
					echo "<td style=\"width:50px;text-align:center\"><input name=\"traspasar_".$rowcu["id"]."\" type=\"Checkbox\" checked></td>";
				} else {
					echo "<td style=\"width:50px;text-align:center\"><input name=\"traspasar_".$rowcu["id"]."\" type=\"Checkbox\"></td>";
				}
			echo "</tr>";
		}
			echo "<tr>";
				echo "<td></td>";
				$date = getdate();
				$date = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				echo "<td><input type=\"text\" name=\"data\" value=\"".$date."\" style=\"width:100px\"></td>";
				echo "<td><select name=\"id_tipus\" style=\"width:200px\">";
					$sqlf = "select * from sgm_factura_tipos where id=".$row["tipo"];
					$resultf = mysql_query(convert_sql($sqlf));
					$rowf = mysql_fetch_array($resultf);
					echo "<option value=\"".$rowf["id"]."\">".$rowf["tipo"]."</option>";
					$sqlr = "select * from sgm_factura_tipos_relaciones where id_tipo_o=".$_GET["id_tipo"];
					$resultr = mysql_query(convert_sql($sqlr));
					while ($rowr = mysql_fetch_array($resultr)) {
						$sqld = "select * from sgm_factura_tipos where id=".$rowr["id_tipo_d"];
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
					echo "<option value=\"".$rowd["id"]."\">".$rowd["tipo"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Enviar\" style=\"width:100px\"></td>";
			echo "</tr>";
		echo "</table></center>";
		echo "<br><br>";
}

	if ($funcio == 2) {
		$sqlfa = "select * from sgm_cabezera where visible=1 and tipo=".$_POST["id_tipus"]." order by numero desc";
		$resultfa = mysql_query(convert_sql($sqlfa));
		$rowfa = mysql_fetch_array($resultfa);
		$numero = ($rowfa["numero"]+1);

		$sqla = "select * from sgm_cabezera where visible=1 and id=".$_GET["id"];
		$resulta = mysql_query(convert_sql($sqla));
		$rowa = mysql_fetch_array($resulta);

		$sql = "insert into sgm_cabezera (id_origen,numero,version,numero_cliente,fecha,fecha_prevision,fecha_entrega,fecha_vencimiento,visible,tipo,subtipo,nombre,nif";
		$sql = $sql.",direccion,poblacion,cp,provincia,id_pais,mail,telefono,edireccion,epoblacion,ecp,eprovincia,eid_pais,onombre,onif,odireccion,opoblacion,ocp";
		$sql = $sql.",oprovincia,omail,otelefono,notas,subtotal,descuento,descuento_absoluto,subtotaldescuento,iva,total,total_forzado,id_cliente,id_user,recibos,cobrada";
		$sql = $sql.",id_tipo_pago,file,cerrada,controlcalidad,print,bultos,peso,nombre_contacto,confirmada,confirmada_cliente,id_divisa,div_canvi,imp_exp,trz) ";
		$sql = $sql."values (";
		$sql = $sql."".$rowa["id_origen"];
		$sqlf = "select * from sgm_factura_tipos where visible=1 and id=".$_POST["id_tipus"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
		if (($rowa["tipo"] == $_POST["id_tipus"]) and ($rowf["presu"] == 1)){
			$sql = $sql.",".$rowa["numero"];
			$version = ($rowa["version"] + 1);
			$sql = $sql.",'".$version."'";
		} else {
			$sql = $sql.",".$numero;
			$sql = $sql.",'".$rowa["version"]."'";
		}
		$sql = $sql.",'".$rowa["numero_cliente"]."'";
		$sql = $sql.",'".$_POST["data"]."'";
		$sql = $sql.",'".$rowa["fecha_prevision"]."'";
		$sql = $sql.",'".$rowa["fecha_entrega"]."'";
		$sql = $sql.",'".$rowa["fecha_vencimiento"]."'";
		$sql = $sql.",".$rowa["visible"];
		$sql = $sql.",".$_POST["id_tipus"];
		$sql = $sql.",".$rowa["subtipo"];
		$sql = $sql.",'".$rowa["nombre"]."'";
		$sql = $sql.",'".$rowa["nif"]."'";
		$sql = $sql.",'".$rowa["direccion"]."'";
		$sql = $sql.",'".$rowa["poblacion"]."'";
		$sql = $sql.",'".$rowa["cp"]."'";
		$sql = $sql.",'".$rowa["provincia"]."'";
		$sql = $sql.",".$rowa["id_pais"]."";
		$sql = $sql.",'".$rowa["mail"]."'";
		$sql = $sql.",'".$rowa["telefono"]."'";
		$sql = $sql.",'".$rowa["edireccion"]."'";
		$sql = $sql.",'".$rowa["epoblacion"]."'";
		$sql = $sql.",'".$rowa["ecp"]."'";
		$sql = $sql.",'".$rowa["eprovincia"]."'";
		$sql = $sql.",".$rowa["eid_pais"]."";
		$sql = $sql.",'".$rowa["onombre"]."'";
		$sql = $sql.",'".$rowa["onif"]."'";
		$sql = $sql.",'".$rowa["odireccion"]."'";
		$sql = $sql.",'".$rowa["opoblacion"]."'";
		$sql = $sql.",'".$rowa["ocp"]."'";
		$sql = $sql.",'".$rowa["oprovincia"]."'";
		$sql = $sql.",'".$rowa["omail"]."'";
		$sql = $sql.",'".$rowa["otelefono"]."'";
		$sql = $sql.",'".$rowa["notas"]."'";
		$sql = $sql.",'".$rowa["subtotal"]."'";
		$sql = $sql.",'".$rowa["descuento"]."'";
		$sql = $sql.",'".$rowa["descuento_absoluto"]."'";
		$sql = $sql.",'".$rowa["subtotaldescuento"]."'";
		$sql = $sql.",'".$rowa["iva"]."'";
		$sql = $sql.",'".$rowa["total"]."'";
		$sql = $sql.",'".$rowa["total_forzado"]."'";
		$sql = $sql.",".$rowa["id_cliente"];
		$sql = $sql.",".$rowa["id_user"];
		$sql = $sql.",".$rowa["recibos"];
		$sql = $sql.",".$rowa["cobrada"];
		$sql = $sql.",".$rowa["id_tipo_pago"];
		$sql = $sql.",'".$rowa["file"]."'";
		$sql = $sql.",".$rowa["cerrada"];
		$sql = $sql.",".$rowa["controlcalidad"];
		$sql = $sql.",".$rowa["print"];
		$sql = $sql.",".$rowa["bultos"];
		$sql = $sql.",".$rowa["peso"];
		$sql = $sql.",'".$rowa["nombre_contacto"]."'";
		$sql = $sql.",".$rowa["confirmada"];
		$sql = $sql.",".$rowa["confirmada_cliente"];
		$sql = $sql.",".$rowa["id_divisa"];
		$sql = $sql.",'".$rowa["div_canvi"]."'";
		$sql = $sql.",".$rowa["imp_exp"];
		$sql = $sql.",".$rowa["id"];
		$sql = $sql.")";
		mysql_query(convert_sql($sql));

		$sqlfa = "select * from sgm_cabezera where visible=1 order by id desc";
		$resultfa = mysql_query(convert_sql($sqlfa));
		$rowfa = mysql_fetch_array($resultfa);

		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"];
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)){
			if ($_POST["traspasar_".$row["id"]] == true) {
				$sql = "insert into sgm_cuerpo (id_origen,linea,id_cuerpo,idfactura,id_estado,fecha_prevision,fecha_entrega,facturado,id_facturado,codigo,nombre,pvd";
				$sql = $sql.",pvp,unidades,descuento,descuento_absoluto,subtotaldescuento,total,notes,bloqueado,id_article,stock,prioridad,controlcalidad,id_tarifa,tarifa,trz) ";
				$sql = $sql."values (";
				$sql = $sql."".$row["id_origen"]."";
				$sql = $sql.",".$row["linea"]."";
				$sql = $sql.",".$row["id_cuerpo"]."";
				$sql = $sql.",".$rowfa["id"]."";
				$sql = $sql.",".$row["id_estado"]."";
				$sql = $sql.",'".$row["fecha_prevision"]."'";
				$sql = $sql.",'".$row["fecha_entrega"]."'";
				$sql = $sql.",".$row["facturado"];
				$sql = $sql.",".$row["id_facturado"];
				$sql = $sql.",'".$row["codigo"]."'";
				$sql = $sql.",'".$row["nombre"]."'";
				$sql = $sql.",'".$row["pvd"]."'";
				$sql = $sql.",'".$row["pvp"]."'";
				$sql = $sql.",'".$_POST["unitats_".$row["id"]]."'";
				$sql = $sql.",'".$row["descuento"]."'";
				$sql = $sql.",'".$row["descuento_absoluto"]."'";
				$sql = $sql.",'".$row["subtotaldescuento"]."'";
				$total = ($_POST["unitats_".$row["id"]] * $row["pvp"]);
				$sql = $sql.",'".$total."'";
				$sql = $sql.",'".$row["notes"]."'";
				$sql = $sql.",".$row["bloqueado"];
				$sql = $sql.",".$row["id_article"];
				$sql = $sql.",".$row["stock"];
				$sql = $sql.",".$row["prioridad"];
				$sql = $sql.",".$row["controlcalidad"];
				$sql = $sql.",".$row["id_tarifa"];
				$sql = $sql.",'".$row["tarifa"]."'";
				$sql = $sql.",".$row["id"];
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		refactura($rowfa["id"]);
	}

#inici calcul de costos
	if ($funcio == 3) {
		if ($sfuncio == 1) {
			$sql = "update sgm_articles_costos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_coste"];
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 2) {
			$sql = "update sgm_articles_costos set ";
			$sql = $sql."aprovat = 1";
			$sql = $sql." WHERE id =".$_GET["id_coste"];
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 3) {
			$sql = "update sgm_articles_costos set ";
			$sql = $sql."aprovat = 0";
			$sql = $sql." WHERE id =".$_GET["id_coste"];
			mysql_query(convert_sql($sql));
		}

		echo "<strong>Cálculo de Costes</strong><br>";
			echo "<table><tr>";
			if ($_GET["tipo"] == 1) {
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=".$option."&sop=".$soption."&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
			}
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=5&sfu=1&tipo=".$_GET["tipo"]."&id_linea=".$_GET["id_linea"]."&id=".$_GET["id"]."\" style=\"color:white;\">Añadir Coste</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<center><table cellspacing=\"0\" style=\"width:500px;\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>Aprobado</em></td>";
				echo "<td><em>Eliminar</em></td>";
				echo "<td style=\"text-align:center;\">Fecha</td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\">Descripción</td>";
				echo "<td style=\"text-align:center;\">Coste</td>";
				echo "<td style=\"text-align:center;\">Tiempo</td>";
				echo "<td><em>Editar</em></td>";
			echo "</tr>";
			$coste = 0;
			$temps = 0;
			if ($_GET["tipo"] == 0) {
				$sqla = "select * from sgm_articles_costos where visible=1 and id_article=".$_GET["id"]." order by fecha";
			}
			if ($_GET["tipo"] == 1) {
				$sqla = "select * from sgm_articles_costos where visible=1 and id_cuerpo=".$_GET["id_linea"]." order by fecha";
			}
			$resulta = mysql_query(convert_sql($sqla));
			while ($rowa = mysql_fetch_array($resulta)) {
				$color = "white";
				$colorl = "black";
				if ($rowa["aprovat"] == 1) { $color = "#FF4500"; $colorl = "white"; }
					echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
						if ($rowa["aprovat"] == 1) {
							echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=3&sfu=3&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$rowa["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"Desaprobar\" style=\"width:72px\">";
							echo "</form>";
						}
						if ($rowa["aprovat"] == 0) {
							echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=3&sfu=2&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$rowa["id"]."\" method=\"post\">";
							echo "<input type=\"Submit\" value=\"aprobar\" style=\"width:72px\">";
							echo "</form>";
						}
						echo "</td>";
						if ($rowa["aprovat"] == 0) {
							echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=".$option."&sop=".$soption."&fu=4&tipo=".$_GET["tipo"]."&id_coste=".$rowa["id"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
						} else {
							echo "<td></td>";
						}
						echo "<td style=\"text-align:right;width:80px;\">".$rowa["fecha"]."</td>";
						echo "<td>&nbsp;&nbsp;</td>";
						echo "<td style=\"width:200px;\">".$rowa["descripcio"]."</td>";
						echo "<td style=\"text-align:right;width:80;\">".$rowa["preu_cost"]."</td>";
						echo "<td style=\"text-align:right;width:80;\">".$rowa["temps"]."</td>";
						echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=".$option."&sop=".$soption."&fu=5&tipo=".$_GET["tipo"]."&id_coste=".$rowa["id"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" style=\"border:0px\"></a></td>";
					echo "</tr>";
				if ($rowa["aprovat"] == 1){
					$coste = $coste + $rowa["preu_cost"];
					$temps = $temps + $rowa["temps"];
				}
			}
		echo "</table></center>";
		echo "<br>";
		echo "<center><table>";
			echo "<tr><td>Coste total : ".$coste."</td></tr>";
			echo "<tr><td>Temps total : ".$temps."</td></tr>";
		echo "</table></center>";
		echo "<br><br>";
	}

	if ($funcio == 4) {
		echo "<center>";
		echo "¿Seguro que desea eliminar este coste?";
		echo "<br><br><a href=\"index.php?op=".$option."&sop=".$soption."&fu=3&sfu=1&id=".$_GET["id"]."&tipo=".$_GET["tipo"]."&id_coste=".$_GET["id_coste"]."&id_linea=".$_GET["id_linea"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=3&id=".$_GET["id"]."&tipo=".$_GET["tipo"]."&id_coste=".$_GET["id_coste"]."&id_linea=".$_GET["id_linea"]."\">[ NO ]</a>";
		echo "</center>";
		echo "<br><br>";
}

	if ($funcio == 5) {
		if ($sfuncio == 1) {
			if ($_GET["tipo"] == 0){
				$sql = "insert into sgm_articles_costos (id_article) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id"];
			}
			if ($_GET["tipo"] == 1){
				$sql = "insert into sgm_articles_costos (id_cuerpo) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_linea"];
			}
			$sql = $sql.")";
			mysql_query(convert_sql($sql));

			$sqla= "select * from sgm_articles_costos order by id desc";
			$resulta = mysql_query(convert_sql($sqla));
			$rowa = mysql_fetch_array($resulta);
			$sql = "insert into sgm_articles_material (id_coste) ";
			$sql = $sql."values (";
			$sql = $sql."".$rowa["id"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}

		if ($sfuncio == 2) {
			if (($_POST["id_material"] != 0) or ($_POST["id_barra"] != 0)) {
				$sqlc = "update sgm_articles_material set ";

				if ($_POST["id_material"] != 0){
					$sqlm= "select * from sgm_material where id=".$_POST["id_material"];
					$resultm = mysql_query(convert_sql($sqlm));
					$rowm = mysql_fetch_array($resultm);

					$volum = ($_POST["x"]*$_POST["y"]*($_POST["z"]));
					$pes_total = $volum * $rowm["pes_mm3"];
					$coste_total= $volum * $rowm["preu_mm3"];

					$sqlc = $sqlc."id_material=".$_POST["id_material"];
				}

				if ($_POST["id_barra"] != 0){
					$sqlm= "select * from sgm_material where id=".$_POST["id_barra"];
					$resultm = mysql_query(convert_sql($sqlm));
					$rowm = mysql_fetch_array($resultm);

					if (($_POST["y"] != 0) and ($_POST["x"] != 0)) {
						$volum = ($_POST["x"]*$_POST["y"]*$_POST["z"]);
					}
					if (($_POST["diametro"] != 0) or ($_POST["radio"] != 0)) {
						if ($_POST["diametro"] != 0){
							$radio = $_POST["diametro"]/2;
						} else {
							$radio = ($_POST["radio"]);
						}
						$volum = ((pi()*pow($radio,2))*($_POST["z"]));
					}
					$pes_total = $volum * $rowm["pes_mm3"];
					$coste_total= $volum * $rowm["preu_mm3"];

					$sqlc = $sqlc."id_material=".$_POST["id_barra"];
				}

				$sqlc = $sqlc.",x=".$_POST["x"];
				$sqlc = $sqlc.",y=".$_POST["y"];
				$sqlc = $sqlc.",z=".$_POST["z"];
				$sqlc = $sqlc.",diametro=".$_POST["diametro"];
				$sqlc = $sqlc.",preu_mat=".$coste_total;
				$sqlc = $sqlc." WHERE id_coste=".$_GET["id_coste"];
				mysql_query(convert_sql($sqlc));
			}
			if (($_POST["id_material"] != 0) and ($_POST["id_barra"] != 0)) {
					mensaje_error("No se puede añadir dos tipos de materiales a la vez.");
			}
		}
		if ($sfuncio == 3) {
			$siguiente = false;
			$id_fase = "";
			$id_recurso = "";

			for($i=0; $i<strlen($_POST["id_fase_recurso"]); $i++) {
				if ($_POST["id_fase_recurso"][$i] == "-") { $siguiente = true; $i = $i+1;}
				if ($siguiente == false) { $id_fase = $id_fase.$_POST["id_fase_recurso"][$i]; }
				if ($siguiente == true) { $id_recurso = $id_recurso.$_POST["id_fase_recurso"][$i]; }
			}

			$sql = "insert into sgm_articles_fases_recursos (id_fase,id_recurso,id_coste,temps,ordre,preu_fases) ";
			$sql = $sql."values (";
			$sql = $sql."".$id_fase;
			$sql = $sql.",".$id_recurso;
			$sql = $sql.",".$_GET["id_coste"];
			$sql = $sql.",".$_POST["temps"];
			$sql = $sql.",".$_POST["ordre"];

			$sqlre= "select * from sgm_recursos where visible=1 and id=".$id_recurso;
			$resultre = mysql_query(convert_sql($sqlre));
			$rowre = mysql_fetch_array($resultre);
			$coste_hora =  $rowre["coste_hora"];

			$preu_fases = (($_POST["temps"]/3600)*$coste_hora);
			$sql = $sql.",".$preu_fases;
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 4) {
			$siguiente = false;
			$id_fase = "";
			$id_recurso = "";

			for($i=0; $i<strlen($_POST["id_fase_recurso"]); $i++) {
				if ($_POST["id_fase_recurso"][$i] == "-") { $siguiente = true; $i = $i+1;}
				if ($siguiente == false) { $id_fase = $id_fase.$_POST["id_fase_recurso"][$i]; }
				if ($siguiente == true) { $id_recurso = $id_recurso.$_POST["id_fase_recurso"][$i]; }
			}

			$sql = "update sgm_articles_fases_recursos set ";
			$sql = $sql."id_fase=".$id_fase;
			$sql = $sql.",id_recurso=".$id_recurso;
			$sql = $sql.",temps=".$_POST["temps"];
			$sql = $sql.",ordre=".$_POST["ordre"];
			$sqlre= "select * from sgm_recursos where visible=1 and id=".$id_recurso;
			$resultre = mysql_query(convert_sql($sqlre));
			$rowre = mysql_fetch_array($resultre);
			$coste_hora =  $rowre["coste_hora"];
			$coste = (($_POST["temps"]/3600)*$coste_hora);
			$sql = $sql.",preu_fases=".$coste;
			$sql = $sql." WHERE id=".$_GET["id_fr"];
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 5) {
			$sql = "update sgm_articles_fases_recursos set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_fr"]."";
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 6) {
			$sql = "update sgm_articles_costos set ";
			$sql = $sql."descripcio = '".$_POST["descripcio"]."'";
			$sql = $sql." WHERE id =".$_GET["id_coste"];
			mysql_query(convert_sql($sql));
		}

		$coste_total = 0;
		$temps_total = 0;
		$sqla= "select * from sgm_articles_fases_recursos where id_coste=".$_GET["id_coste"];
		$resulta = mysql_query(convert_sql($sqla));
		while ($rowa = mysql_fetch_array($resulta)){
			$coste_total = $coste_total + $rowa["preu_fases"];
			$temps_total = $temps_total + $rowa["calc_temps"];
		}
		$date = getdate();
		$date = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));

		$sqlc= "select * from sgm_articles_material where id_coste=".$_GET["id_coste"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$coste_total = ($coste_total + $rowc["preu_mat"]);
		$sqlb = "update sgm_articles_costos set ";
		$sqlb = $sqlb."preu_cost=".$coste_total;
		$sqlb = $sqlb.",temps=".$temps_total;
		$sqlb = $sqlb.",fecha='".$date."'";
		$sqlb = $sqlb." WHERE id=".$_GET["id_coste"];
		mysql_query(convert_sql($sqlb));

		$sql= "select * from sgm_articles_costos order by id desc";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($_GET["id_coste"] == "") {
			echo "<strong>Añadir Nuevo Coste</strong>";
			$id_coste = $row["id"];
		} else {
			echo "<strong>Modificar Coste</strong>";
			$id_coste = $_GET["id_coste"];
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=3&id=".$_GET["id"]."&tipo=".$_GET["tipo"]."&id_linea=".$_GET["id_linea"]."\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>Descripción</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=5&sfu=6&id=".$_GET["id"]."&tipo=".$_GET["tipo"]."&id_coste=".$id_coste."&id_linea=".$_GET["id_linea"]."\" method=\"post\">";
				$sqld= "select * from sgm_articles_costos where visible=1 and id=".$_GET["id_coste"];
				$resultd = mysql_query(convert_sql($sqld));
				$rowd = mysql_fetch_array($resultd);
				echo "<td><input name=\"descripcio\" type=\"text\" style=\"width:100px;height:16px;\" value=\"".$rowd["descripcio"]."\"></td>";
				echo "<td><input type=\"Submit\" value=\"Guardar\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>Material</td>";
				echo "<td>Barra</td>";
				echo "<td>X(mm.)</td>";
				echo "<td>Y(mm.)</td>";
				echo "<td>Z(mm.)</td>";
				echo "<td>Diametro(mm.)</td>";
				echo "<td>Coste (€.)</td>";
				echo "<td>Peso (Kg.)</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=5&sfu=2&id=".$_GET["id"]."&tipo=".$_GET["tipo"]."&id_coste=".$id_coste."&id_linea=".$_GET["id_linea"]."\" method=\"post\">";
				$sqlfb= "select * from sgm_articles_material where visible=1 and id_coste=".$id_coste;
				$resultfb = mysql_query(convert_sql($sqlfb));
				$rowfb = mysql_fetch_array($resultfb);
				echo "<td><select name=\"id_material\" style=\"width:110px;\">";
					echo "<option value=\"0\">-</option>";
					$sqlfa= "select * from sgm_material where visible=1 and especifico=2";
					$resultfa = mysql_query(convert_sql($sqlfa));
					while ($rowfa = mysql_fetch_array($resultfa)){
						if ($rowfb["id_material"] == $rowfa["id"]){
							echo "<option value=\"".$rowfa["id"]."\" selected>".$rowfa["material"]."</option>";
						} else {
							echo "<option value=\"".$rowfa["id"]."\">".$rowfa["material"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><select name=\"id_barra\" style=\"width:110px;\">";
					echo "<option value=\"0\">-</option>";
					$sqlfa= "select * from sgm_material where visible=1 and especifico=1";
					$resultfa = mysql_query(convert_sql($sqlfa));
					while ($rowfa = mysql_fetch_array($resultfa)){
						if ($rowfb["id_material"] == $rowfa["id"]){
							echo "<option value=\"".$rowfa["id"]."\" selected>".$rowfa["material"]."</option>";
						} else {
							echo "<option value=\"".$rowfa["id"]."\">".$rowfa["material"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><input name=\"x\" type=\"text\" style=\"text-align:right;width:70px;height:16px;\" value=\"".$rowfb["x"]."\"></td>";
				echo "<td><input name=\"y\" type=\"text\" style=\"text-align:right;width:70px;height:16px;\" value=\"".$rowfb["y"]."\"></td>";
				echo "<td><input name=\"z\" type=\"text\" style=\"text-align:right;width:70px;height:16px;\" value=\"".$rowfb["z"]."\"></td>";
				echo "<td><input name=\"diametro\" type=\"text\" style=\"text-align:right;width:80px;height:16px;\" value=\"".$rowfb["diametro"]."\"></td>";
				echo "<td style=\"text-align:right;width:50px;height:16px;\">".number_format($rowfb["preu_mat"], 3, '.', '')."</td>";
				echo "<td style=\"text-align:right;width:52px;height:16px;\">".number_format($pes_total, 3, '.', '')."</td>";
				echo "<td><input type=\"Submit\" value=\"Guardar\" style=\"width:100px\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Orden</td>";
				echo "<td>Fase-Grupo de recursos</td>";
#				echo "<td>Recurso</td>";
				echo "<td>Tiempo (s.)</td>";
				echo "<td>Cal. Tiempo</td>";
				echo "<td>Coste (€.)</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><form action=\"index.php?op=".$option."&sop=".$soption."&fu=5&sfu=3&tipo=".$_GET["tipo"]."&id_coste=".$_GET["id_coste"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."\" method=\"post\"></td>";
				$sql= "select * from sgm_articles_fases_recursos where id_coste=".$_GET["id_coste"]." and visible=1 order by id desc";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$orden = ($row["ordre"] + 10);
				echo "<td><input name=\"ordre\" type=\"text\" style=\"width:50px;height:16px;\" value=\"".$orden."\"></td>";

				echo "<td><select name=\"id_fase_recurso\" style=\"width:250px;\">";
					$sqlfa= "select * from sgm_fases where visible=1 order by fase";
					$resultfa = mysql_query(convert_sql($sqlfa));
					while ($rowfa = mysql_fetch_array($resultfa)){
						$sqlre= "select * from sgm_fases_grupo_rec where visible=1 and id_fase=".$rowfa["id"];
						$resultre = mysql_query(convert_sql($sqlre));
						while ($rowre = mysql_fetch_array($resultre)){
							$sqlrecurso= "select * from sgm_recursos_grupo where id=".$rowre["id_grupo_rec"];
							$resultrecurso = mysql_query(convert_sql($sqlrecurso));
							$rowrecurso = mysql_fetch_array($resultrecurso);
							echo "<option value=\"".$rowfa["id"]."-".$rowrecurso["id"]."\">".$rowfa["fase"]."-".$rowrecurso["grupo"]."</option>";
						}
					}
				echo "</select></td>";

				echo "<td><input name=\"temps\" type=\"text\" style=\"width:60px;height:16px;text-align:right;\" value=\"0\"></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:60px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
				$sql= "select * from sgm_articles_fases_recursos where visible=1 and id_coste=".$id_coste." order by ordre";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)){
					echo "<tr>";
						echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=5&sfu=4&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$row["id"]."&id_linea=".$_GET["id_linea"]."\" method=\"post\">";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$option."&sop=".$soption."&fu=6&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_fr=".$row["id"]."&id_coste=".$_GET["id_coste"]."&id_linea=".$_GET["id_linea"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
						echo "<td><input name=\"ordre\" type=\"text\" style=\"width:50px;height:16px;\" value=\"".$row["ordre"]."\"></td>";
					echo "<td><select name=\"id_fase_recurso\" style=\"width:250px;\">";
					$sqlfa= "select * from sgm_fases where visible=1 order by fase";
					$resultfa = mysql_query(convert_sql($sqlfa));
					while ($rowfa = mysql_fetch_array($resultfa)){
						$sqlre= "select * from sgm_fases_grupo_rec where visible=1 and id_fase=".$rowfa["id"];
						$resultre = mysql_query(convert_sql($sqlre));
						while ($rowre = mysql_fetch_array($resultre)){
							$sqlrecurso= "select * from sgm_recursos_grupo where id=".$rowre["id_grupo_rec"];
							$resultrecurso = mysql_query(convert_sql($sqlrecurso));
							$rowrecurso = mysql_fetch_array($resultrecurso);
							if (($rowfa["id"] == $row["id_fase"]) and ($rowre["id_grupo_rec"] == $row["id_recurso"])) {
								echo "<option value=\"".$rowfa["id"]."-".$rowrecurso["id"]."\" selected>".$rowfa["fase"]."-".$rowrecurso["grupo"]."</option>";
							} else {
								echo "<option value=\"".$rowfa["id"]."-".$rowrecurso["id"]."\">".$rowfa["fase"]."-".$rowrecurso["grupo"]."</option>";
							}
						}
					}
				echo "</select></td>";

						echo "<td><input name=\"temps\" type=\"text\" style=\"width:60px;height:16px;text-align:right;\" value=\"".$row["temps"]."\"></td>";
						echo "<td style=\"width:60px;height:16px;text-align:right;\">".$row["calc_temps"]."</td>";
						echo "<td style=\"width:60px;height:16px;text-align:right;\">".$row["preu_fases"]."</td>";
						echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:60px\"></td>";
						echo "</form>";
						echo "<td style=\"width:100px;height:5px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=7&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$row["id"]."&id_linea=".$_GET["id_linea"]."\" style=\"color:white;\">Operaciones</a>";
						echo "</td>";
					echo "</tr>";
				}
			$sql= "select * from sgm_articles_costos where id=".$_GET["id_coste"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:left;\">Totales:</td>";
				echo "<td style=\"text-align:right;\"><strong>".$row["temps"]."</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$row["preu_cost"]."</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table></center>";
	}

	if ($funcio == 6) {
		echo "<center>";
		echo "¿Seguro que desea eliminar esta fase y recurso del coste?";
		echo "<br><br><a href=\"index.php?op=".$option."&sop=".$soption."&fu=5&sfu=5&tipo=".$_GET["tipo"]."&id_fr=".$_GET["id_fr"]."&id=".$_GET["id"]."&id_coste=".$_GET["id_coste"]."&id_linea=".$_GET["id_linea"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=5&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_coste=".$_GET["id_coste"]."&id_linea=".$_GET["id_linea"]."\">[ NO ]</a>";
		echo "</center>";
		echo "<br><br>";
	}

	if ($funcio == 7) {
		if ($sfuncio == 1) {
			$sql = "insert into sgm_articles_operaciones (id_operacion,id_estacada,temps,descripcio) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["id_operacion"]."";
			$sql = $sql.",".$_GET["id_estacada"]."";
			$sql = $sql.",".$_POST["temps"]."";
			$sql = $sql.",'".$_POST["descripcio"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));

			$tempstotal = 0;
			$sqle = "SELECT * FROM `sgm_articles_estacada` WHERE id_fase_recurso=".$_GET["id_fr"]." and visible=1";
			$resulte = mysql_query(convert_sql($sqle));
			while ($rowe = mysql_fetch_array($resulte)) {
				$sqlo = "select * from sgm_articles_operaciones where visible=1 and id_estacada=".$rowe["id"];
				$resulto = mysql_query(convert_sql($sqlo));
				while ($rowo = mysql_fetch_array($resulto)) {
					$tempstotal = $tempstotal + $rowo["temps"];
				}
			}
			$sql = "update sgm_articles_fases_recursos set ";
			$sql = $sql."calc_temps='".$tempstotal."'";
			$sql = $sql." WHERE id=".$_GET["id_fr"];
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 2) {
			$sql = "update sgm_articles_operaciones set ";
			$sql = $sql."temps='".$_POST["temps"]."'";
			$sql = $sql.",descripcio='".$_POST["descripcio"]."'";
			$sql = $sql." WHERE id=".$_GET["id_operacion"]."";
			mysql_query(convert_sql($sql));
			$tempstotal = 0;
			$sqle = "SELECT * FROM `sgm_articles_estacada` WHERE id_fase_recurso=".$_GET["id_fr"]." and visible=1";
			$resulte = mysql_query(convert_sql($sqle));
			while ($rowe = mysql_fetch_array($resulte)) {
				$sqlo = "select * from sgm_articles_operaciones where visible=1 and id_estacada=".$rowe["id"];
				$resulto = mysql_query(convert_sql($sqlo));
				while ($rowo = mysql_fetch_array($resulto)) {
					$tempstotal = $tempstotal + $rowo["temps"];
				}
			}
			$sql = "update sgm_articles_fases_recursos set ";
			$sql = $sql."calc_temps='".$tempstotal."'";
			$sql = $sql." WHERE id=".$_GET["id_fr"];
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 3) {
			$sql = "update sgm_articles_estacada set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id_operacion"]."";
			mysql_query(convert_sql($sql));
			$tempstotal = 0;
			$sqle = "SELECT * FROM `sgm_articles_estacada` WHERE id_fase_recurso=".$_GET["id_fr"]." and visible=1";
			$resulte = mysql_query(convert_sql($sqle));
			while ($rowe = mysql_fetch_array($resulte)) {
				$sqlo = "select * from sgm_articles_operaciones where visible=1 and id_estacada=".$rowe["id"];
				$resulto = mysql_query(convert_sql($sqlo));
				while ($rowo = mysql_fetch_array($resulto)) {
					$tempstotal = $tempstotal + $rowo["temps"];
				}
			}
			$sql = "update sgm_articles_fases_recursos set ";
			$sql = $sql."calc_temps='".$tempstotal."'";
			$sql = $sql." WHERE id=".$_GET["id_fr"];
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 4) {
			$sql = "update sgm_articles_fases_recursos set ";
			$sql = $sql."calc_temps='".$calc_temps."'";
			$sql = $sql." WHERE id=".$id_fr."";
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 5) {
			$sql = "insert into sgm_articles_estacada (id_fase_recurso,orden,descripcio) ";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id_fr"]."";
			$sql = $sql.",".$_POST["orden"]."";
			$sql = $sql.",'".$_POST["descripcio"]."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($sfuncio == 6) {
			$sql = "update sgm_articles_estacada set ";
			$sql = $sql."orden='".$_POST["orden"]."'";
			$sql = $sql.",descripcio='".$_POST["descripcio"]."'";
			$sql = $sql." WHERE id=".$_GET["id_estacada"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=5&tipo=".$_GET["tipo"]."&id_coste=".$_GET["id_coste"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."\" style=\"color:white;\">&laquo; Volver</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>Eliminar</em></td>";
				echo "<td>Orden</td>";
				echo "<td>Descripción Estacada</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				$sqlo = "select * from sgm_articles_estacada where visible=1 and id_fase_recurso=".$_GET["id_fr"]." order by orden desc";
				$resulto = mysql_query(convert_sql($sqlo));
				$rowo = mysql_fetch_array($resulto);
				$orden = 0;
				$orden = $rowo["orden"] +1;
				echo "<td><form action=\"index.php?op=".$option."&sop=".$soption."&fu=7&sfu=5&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."&id_linea=".$_GET["id_linea"]."\" method=\"post\"></td>";
				echo "<td><input name=\"orden\" type=\"text\" style=\"width:30px;height:16px;text-align:right;\" value=\"".$orden."\"></td>";
				echo "<td><input name=\"descripcio\" type=\"text\" style=\"width:400px;height:16px;\"></td>";
				echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:60px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			$sql = "select * from sgm_articles_estacada where visible=1 and id_fase_recurso=".$_GET["id_fr"]." order by orden";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr style=\"background-color:silver;\">";
					echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=".$option."&sop=".$soption."&fu=8&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."&id_operacion=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=7&sfu=6&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_coste=".$_GET["id_coste"]."&id_linea=".$_GET["id_linea"]."&id_fr=".$_GET["id_fr"]."&id_estacada=".$row["id"]."\" method=\"post\">";
					echo "<td><input name=\"orden\" type=\"text\" style=\"width:30px;height:16px;text-align:right;\" value=\"".$row["orden"]."\"></td>";
					echo "<td><input name=\"descripcio\" type=\"text\" style=\"width:400px;height:16px;\" value=\"".$row["descripcio"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:60px;\"></td>";
					echo "</form>";
				echo "</tr>";
				echo "<tr><td></td><td></td><td>";
					echo "<table cellspacing=\"0\" style=\"width:350px\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<td><em>Eliminar</em></td>";
							echo "<td>Operacion</td>";
							echo "<td>Descripción</td>";
							echo "<td>Tiempo(s.)</td>";
							echo "<td></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><form action=\"index.php?op=".$option."&sop=".$soption."&fu=7&sfu=1&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."&id_estacada=".$row["id"]."\" method=\"post\"></td>";
								echo "<td><select name=\"id_operacion\" style=\"width:80px\">";
									$sqlg = "select * from sgm_operaciones where visible=1 order by operacion";
									$resultg = mysql_query(convert_sql($sqlg));
									while ($rowg = mysql_fetch_array($resultg)) {
										echo "<option value=\"".$rowg["id"]."\">".$rowg["operacion"]."</option>";
									}
								echo "</select></td>";
							echo "<td><input name=\"descripcio\" type=\"text\" style=\"width:160px;height:16px;\" value=\"\"></td>";
							echo "<td><input name=\"temps\" type=\"text\" style=\"width:50px;height:16px;text-align:right;\" value=\"0\"></td>";
							echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:60px;\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>&nbsp;</td>";
						echo "</tr>";
						$sqlop = "select * from sgm_articles_operaciones where visible=1 and id_estacada=".$row["id"];
						$resultop = mysql_query(convert_sql($sqlop));
						while ($rowop = mysql_fetch_array($resultop)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?op=".$option."&sop=".$soption."&fu=8&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."&id_operacion=".$rowop["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<form action=\"index.php?op=".$option."&sop=".$soption."&fu=7&sfu=2&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."&id_operacion=".$rowop["id"]."\" method=\"post\">";
								$sqlsu= "select * from sgm_operaciones where id=".$rowop["id_operacion"];
								$resultsu = mysql_query(convert_sql($sqlsu));
								$rowsu = mysql_fetch_array($resultsu); 
								echo "<td><input name=\"operacion\" type=\"Text\" value=\"".$rowsu["operacion"]."\" style=\"width:80px;\" disabled></td>";
								echo "<td><input name=\"descripcio\" type=\"text\" style=\"width:160px;height:16px;\" value=\"".$rowop["descripcio"]."\"></td>";
								echo "<td><input name=\"temps\" type=\"text\" style=\"width:50px;height:16px;text-align:right;\" value=\"".$rowop["temps"]."\"></td>";
								echo "<td><input type=\"Submit\" value=\"Modificar\" style=\"width:60px;\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td></tr>";
				echo "<tr>";
					echo "<td>&nbsp;</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\">Tiempo total de la fase : ";
				$sql = "select * from sgm_articles_fases_recursos where visible=1 and id=".$_GET["id_fr"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<strong>".$row["calc_temps"]."</strong></td>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table></center>";
}

	if ($funcio == 8) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta operacion del calculo?";
		echo "<br><br><a href=\"index.php?op=".$option."&sop=".$soption."&fu=7&sfu=3&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."&id_operacion=".$_GET["id_operacion"]."\">[ SI ]</a>";
		echo "<a href=\"index.php?op=".$option."&sop=".$soption."&fu=7&tipo=".$_GET["tipo"]."&id=".$_GET["id"]."&id_linea=".$_GET["id_linea"]."&id_coste=".$_GET["id_coste"]."&id_fr=".$_GET["id_fr"]."\">[ NO ]</a>";
		echo "</center>";
		echo "<br><br>";
	}
#fi calcul de costos


?>
