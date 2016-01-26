<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";  }
if (($option == 1026) AND ($autorizado == true)) {

	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Licencias."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1026&sop=0\" class=".$class.">".$Ver." ".$Licencias."</a></td>";
					if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1026&sop=100\" class=".$class.">".$Anadir." ".$Licencia."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1026&sop=200\" class=".$class.">".$Buscar." ".$Licencia."</a></td>";
					if (($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1026&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 3) {
			$sql = "update sgm_licencias set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));

			$sqlf = "select * from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"];
			$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
			while ($rowf = mysqli_fetch_array($resultf)){
				deleteCabezera($rowf["id"]);
				$sql = "select * from sgm_cuerpo where idfactura=".$rowf["id"]."";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
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
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
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
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
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
				$sqlcc = "select * from sgm_licencias where visible=1 ";
				if ($_POST["id_client2"] > 0) {
					$sqlcc = $sqlcc." and id_client=".$_POST["id_client2"]."";
				}
				if ($_POST["id_client_final2"] > 0) {
					$sqlcc = $sqlcc." and id_client_final=".$_POST["id_client_final2"]."";
				}
				if ($soption == 0){ $sqlcc = $sqlcc." and renovado=0";}
				if ($soption == 1){ $sqlcc = $sqlcc." and renovado=1";}
#				echo $sqlcc."<br>";
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				while ($rowcc = mysqli_fetch_array($resultcc)){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=0&ssop=3&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_client"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=201&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sql = "select * from sgm_clients where visible=1 and id=".$rowcc["id_client_final"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
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
			$camposInsert = "id_client,id_client_final,fecha_ini,fecha_fin,num_elementos";
			$datosInsert = array($_POST["id_client"],$_POST["id_client_final"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["num_elementos"]);
			insertFunction ("sgm_licencias",$camposInsert,$datosInsert);
			$sqln = "select id from sgm_licencias where visible=1 and id_client_final=".$_POST["id_client_final"]." and fecha_fin='".$_POST["fecha_fin"]."'";
			$resultn = mysqli_query($dbhandle,convertSQL($sqln));
			$rown = mysqli_fetch_array($resultn);
			$id_lic = $rown["id"];
		}
		if ($ssoption == 2) {
			$camposUpdate = array("id_client","id_client_final","fecha_ini","fecha_fin","num_elementos");
			$datosUpdate = array($_POST["id_client"],$_POST["id_client_final"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["num_elementos"]);
			updateFunction ("sgm_licencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("renovado");
			$datosUpdate = array(1);
			updateFunction ("sgm_licencias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$camposInsert = "id_licencia,id_article";
			$datosInsert = array($_GET["id"],$_POST["id_article"]);
			insertFunction ("sgm_licencias_articles",$camposInsert,$datosInsert);
		}
		if ($ssoption == 5) {
			deleteFunction("sgm_licencias_articles",$_GET["id_lic_art"]);
		}

		if ($_GET["id"] > 0) {$id_lic = $_GET["id"];}

		if ($id_lic > 0) { echo "<h4>".$Editar." ".$Licencia." : </h4>";} else { echo "<h4>".$Anadir." ".$Licencia." : </h4>";}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			if ($id_lic > 0) {
				echo "<form action=\"index.php?op=1026&sop=100&ssop=2&id=".$id_lic."\" method=\"post\">";
				$sqlc = "select * from sgm_licencias where visible=1 and id=".$id_lic;
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
			} else {
				echo "<form action=\"index.php?op=1026&sop=100&ssop=1\" method=\"post\">";
			}
			echo "<tr><td style=\"text-align:right;\">".$Cliente.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_client\">";
					$sqla = "select * from sgm_clients where visible=1 order by nombre";
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					while ($rowa = mysqli_fetch_array($resulta)) {
						if ($rowa["id"] == $rowc["id_client"]){
							echo "<option value=\"".$rowa["id"]."\" selected>".$rowa["nombre"]."x ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente." ".$Final.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_client_final\">";
					$sqlb = "select * from sgm_clients where visible=1 order by nombre";
					$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
					while ($rowb = mysqli_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_client_final"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Elementos.": </td><td><input style=\"width:100px\" type=\"Text\" name=\"num_elementos\" value=\"".$rowc["num_elementos"]."\"></td></tr>";
			if ($id_lic != "") {
				$date1 = $rowc["fecha_ini"];
				$date2 = $rowc["fecha_fin"];
			} else {
				$date1 = date("Y-m-d");
				$date2 = date("Y-m-d");
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
					echo "<form action=\"index.php?op=1026&sop=100&ssop=3&id=".$id_lic."\" method=\"post\">";
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
							$sql = "select * from sgm_articles where visible=1 and id_subgrupo in (select id from sgm_articles_subgrupos where id_grupo in (select id from sgm_articles_grupos where id in (select id_familia from sgm_licencias_families_articles)))";
							$result = mysqli_query($dbhandle,convertSQL($sql));
							while ($row = mysqli_fetch_array($result)) {
								$sqlg = "select * from sgm_articles_subgrupos where id=".$row["id_subgrupo"];
								$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
								$rowg = mysqli_fetch_array($resultg);
								echo "<option value=\"".$row["id"]."\">".$rowg["subgrupo"]."(".$row["codigo"].") - ".$row["nombre"]."</option>";
							}
						echo "</td>";
						echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
					echo "</form>";
					echo "</tr>";
					echo "<tr><td>&nbsp;</td></tr>";
				}
				$sql = "select * from sgm_licencias_articles where visible=1 and id_licencia=".$id_lic."";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
						if ($rowc["renovado"] == 0) {
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=101&id=".$id_lic."&id_lic_art=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						} else { echo "<td></td>"; }
						$sqls = "select * from sgm_articles where id=".$row["id_article"];
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						$rows = mysqli_fetch_array($results);
						echo "<td style=\"text-align:left;width:500px\">".$rows["nombre"]."</td>";
						echo "<td></td>";
					echo "</tr>";
				}
			echo "</table></center>";
			echo "<br><br>";

			echo "<br><br>";
			echo "<center><table cellspacing=\"0\">";
				if (($rowc["renovado"] == 0) and ($rowc["facturado"] == 0)) {
					echo "<tr>";
					echo "<form action=\"index.php?op=1026&sop=102&id=".$id_lic."\" method=\"post\">";
						echo "<input type=\"hidden\" name=\"id_client\" value=\"".$rowc["id_client"]."\">";
						echo "<input type=\"hidden\" name=\"id_licencia\" value=\"".$id_lic."\">";
						echo "<td><input type=\"Submit\" value=\"".$Crear." ".$Factura."\"></td>";
					echo "</form>";
					echo "</tr>";
				}
				echo "<tr><th>".$Factura."</th></tr>";
				echo "<tr style=\"background-color:silver\">";
					echo "<th style=\"text-align:left;width:100px\">".$Fecha."</th>";
					echo "<th style=\"text-align:left;width:150px\">".$Fecha." ".$Vencimiento."</th>";
					echo "<th style=\"text-align:left;width:500px\">".$Cliente."</th>";
					echo "<th style=\"text-align:left;width:100px\">".$Importe."</th>";
				echo "</tr><tr>";
				$sql = "select * from sgm_cabezera where visible=1 and id_licencia=".$id_lic."";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
						echo "<td>".$row["fecha"]."</td>";
						echo "<td>".$row["fecha_vencimiento"]."</td>";
						echo "<td><a href=\"index.php?op=1003&sop=100&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						echo "<td>".$row["total"]."</td>";
					echo "</tr>";
				}
			echo "</table></center>";
		}
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1026&sop=100&ssop=5&id=".$_GET["id"]."&id_lic_art=".$_GET["id_lic_art"],"op=1026&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 102) {

		$sql = "select id_client from sgm_licencias where visible=1 and id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);

		$datosInsert = array('fecha' => date("Y-m-d"), 'fecha_prevision' => date("Y-m-d",date("U")+$row["dias_vencimiento"]), 'id_cliente' => $row["id_client"], 'id_licencia' => $_GET["id"]);
		insertCabezera($datosInsert);

		$sqlc = "select id from sgm_cabezera where visible=1 and id_licencia=".$_GET["id"]." and fecha='".date("Y-m-d")."' order by id desc";
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);

		$sqla = "select * from sgm_articles where visible=1 and id in (select id_article from sgm_licencias_articles where visible=1 and id_licencia=".$_GET["id"].")";
		$resulta = mysqli_query($dbhandle,convertSQL($sqla));
		while ($rowa = mysqli_fetch_array($resulta)){
			$sqls = "select * from sgm_stock where vigente=1 and id_article=".$rowa["id"];
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			$rows = mysqli_fetch_array($results);

			$camposInsert = "idfactura,nombre,pvp,unidades,fecha_prevision,fecha_prevision_propia,total";
			$datosInsert = array($rowc["id"],$rowa["nombre"],$rows["pvp"],1,date("Y-m-d"),date("Y-m-d"),$rows["pvp"]);
			insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
		}

		refactura($rowc["id"]);

		$camposUpdate = array("facturado");
		$datosUpdate = array(1);
		updateFunction ("sgm_licencias",$_GET["id"],$camposUpdate,$datosUpdate);

		echo "<center>";
		echo boton(array("op=1003&sop=100&id=".$rowc["id"],"op=1026&sop=100&id=".$_GET["id"]),array($Factura,$Licencia));
		echo "</center>";
	}


	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1026&sop=510"),array($Articulos));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "id_familia";
			$datosInsert = array($_POST["id_familia"]);
			insertFunction ("sgm_licencias_families_articles",$camposinsert,$datosInsert);
		}
		if ($ssoption == 3) {
			deleteFunction("sgm_licencias_families_articles",$_GET["id"]);
		}

		echo "<h4>".$Articulos." ".$Familias."</h4>";
		echo boton(array("op=1026&sop=500"),array("&laquo; ".$Volver));
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th style=\"text-align:center;\">".$Familia."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1026&sop=510&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select style=\"width:200px\" name=\"id_familia\">";
					$sql = "select * from sgm_articles_grupos order by grupo";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["grupo"]."</option>";
					}
				echo "</td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqll = "select * from sgm_licencias_families_articles";
			$resultl = mysqli_query($dbhandle,convertSQL($sqll));
			while ($rowl = mysqli_fetch_array($resultl)) {
				$sqla = "select * from sgm_articles_grupos where id=".$rowl["id_familia"];
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				$rowa = mysqli_fetch_array($resulta);
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1026&sop=511&id=".$rowl["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input type=\"text\" value=\"".$rowa["grupo"]."\" style=\"width:200px\" name=\"nombre\"></td>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 511) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1026&sop=510&ssop=3&id=".$_GET["id"],"op=1026&sop=510"),array($Si,$No));
		echo "</center>";
	}

	echo "</td></tr></table><br>";

}
?>

