<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1004) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Articulos."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if ($soption == 0) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1004&sop=0\" class=".$class.">".$Articulos."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1004&sop=200\" class=".$class.">".$Buscar." ".$Articulo."</a></td>";
					if ($soption == 300) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1004&sop=300\" class=".$class.">".$Impresion."</a></td>";
					if (($soption >= 500) and ($soption <= 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1004&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 200)) {
		if ($ssoption == 1) {
			$sql = "select count(*) as total from sgm_articles where codigo='".$_POST["codigo"]."' or nombre='".$_POST["nombre"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if ($row["total"] == 0) {
				$camposInsert = "codigo,nombre,id_subgrupo";
				$datosInsert = array($_POST["codigo"],$_POST["nombre"],$_POST["id_subgrupo"]);
				insertFunction ("sgm_articles",$camposInsert,$datosInsert);
			} else {
				echo mensageError($ErrorAnadirArticulo);
			}
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$camposUpdate=array('descatalogat');
			$datosUpdate=array(1);
			updateFunction("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate=array('descatalogat');
			$datosUpdate=array(0);
			updateFunction("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($soption == 0) {
			echo "<h4>".$Articulos."</h4>";
			echo "<table><tr>";
				echo "<td class=\"menu\">";
					if ($_GET["ver"] == 0) { 
						$sql = "select * from sgm_users where activo=1 order by usuario";
						echo "<a href=\"index.php?op=1004&sop=0&ver=1\" style=\"color:white;\">".$Descatalogados."</a>";
					}
					if ($_GET["ver"] == 1) { 
						$sql = "select * from sgm_users order by usuario";
						echo "<a href=\"index.php?op=1004&sop=0&ver=0\" style=\"color:white;\">".$Catalogados."</a>";
					}
				echo "</td>";
			echo "</tr></table>";
			echo "<br>";
		}
		if ($soption == 200) { echo "<h4>".$Buscar."</h4>"; }
			echo "<table cellspacing=\"0\" cellpadding=\"1\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<th></th>";
#					echo "<th>".$Fecha."</th>";
					echo "<th style=\"width:100px\">".$Codigo."</th>";
					echo "<th style=\"width:400px\">".$Articulo."</th>";
					echo "<th style=\"width:200px;\">".$Familia." - ".$Subfamilia."</th>";
					if ($soption == 200) { echo "<th style=\"width:80px;\">".$Descatalogado."</th>"; }
					echo "<th style=\"width:100px;text-align:right;\">".$PVD."</th>";
					echo "<th style=\"width:100px;text-align:right;\">".$PVP."</th>";
					echo "<th></th>";
				echo "</tr>";
			if ($soption == 200) {
				echo "<form action=\"index.php?op=1004&sop=200\" method=\"post\">";
				echo "<tr>";
					echo "<td></td>";
					echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\" value=\"".$_POST["codigo"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:400px\" value=\"".$_POST["nombre"]."\"></td>";
					echo "<td><select name=\"id_subgrupo\" style=\"width:300px\">";
						echo "<option value=\"-1\">".$Todas."</option>";
						$sqli = "select id,grupo from sgm_articles_grupos";
						$resulti = mysqli_query($dbhandle,convertSQL($sqli));
						while ($rowi = mysqli_fetch_array($resulti)) {
							$sqls = "select id,subgrupo from sgm_articles_subgrupos where id_grupo=".$rowi["id"];
							$results = mysqli_query($dbhandle,convertSQL($sqls));
							while ($rows = mysqli_fetch_array($results)) {
								if ($rows["id"] == $_POST["id_subgrupo"]){
									echo "<option value=\"".$rows["id"]."\" selected>".$rowi["grupo"]."-".$rows["subgrupo"]."</option>";
								} else {
									echo "<option value=\"".$rows["id"]."\">".$rowi["grupo"]."-".$rows["subgrupo"]."</option>";
								}
							}
						}
					echo "</select></td>";
					echo "<td><select name=\"descatalogat\" style=\"width:80px\">";
						if ($_POST["descatalogat"] == 0){
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						}
						if ($_POST["descatalogat"] == 1){
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
				echo "</tr>";
				echo "</form>";
			} elseif ($soption == 0) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1004&sop=0&ssop=1\" method=\"post\">";
					echo "<td></td>";
					echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\"></td>";
					echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:400px;\"></td>";
					echo "<td><select name=\"id_subgrupo\" style=\"width:300px\">";
						echo "<option value=\"0\">".$Sin." ".$Clasificar."</option>";
						$sqlg1 = "select id,grupo from sgm_articles_grupos order by grupo";
						$resultg1 = mysqli_query($dbhandle,convertSQL($sqlg1));
						while ($rowg1 = mysqli_fetch_array($resultg1)) {
							$sqlsg1 = "select id,subgrupo from sgm_articles_subgrupos where id_grupo=".$rowg1["id"]." order by subgrupo";
							$resultsg1 = mysqli_query($dbhandle,convertSQL($sqlsg1));
							while ($rowsg1 = mysqli_fetch_array($resultsg1)) {
								echo "<option value=\"".$rowsg1["id"]."\">".$rowg1["grupo"]." - ".$rowsg1["subgrupo"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
					echo "</form>";
				echo "</tr>";
				$subgrupo = -1;
			}
				echo "<tr><td>&nbsp;</td></tr>";
		if (($soption == 0) or (($soption == 200) and (($_POST["codigo"] != 0) or ($_POST["nombre"] != 0) or ($_POST["notas"] != 0) or ($_POST["id_subgrupo"] != 0)))) {
			$sql = "select id,id_subgrupo,codigo,nombre,descatalogat from sgm_articles where visible=1";
			if ($_POST["id_subgrupo"] < 0) {$subgrupo = $_POST["id_subgrupo"]; }
			if ($soption == 0){
				if ($_GET["ver"] == 1) {$sql .= " and descatalogat=1";} else {$sql .= " and descatalogat=0";}
			}
			if (($soption == 200) and ($ssoption == 0)){
				if ($_POST["codigo"] <> "") {$sql .= " and codigo like '%".$_POST["codigo"]."%'";}
				if ($_POST["nombre"] <> "") {$sql .= " and nombre like '%".$_POST["nombre"]."%'";}
				if ($_POST["notas"] <> "") {$sql .= " and notas like '%".$_POST["notas"]."%'";}
				if ($_POST["id_subgrupo"] > 0) {$sql .= " and id_subgrupo=".$_POST["id_subgrupo"]."";}
				if ($_POST["descatalogat"] == 1) {$sql .= " and descatalogat=1";}
			}
			if (($soption == 200) and ($ssoption == 2)) {
				if ($_POST["codigo2"] <> "") {$sql .= " and codigo like '%".$_POST["codigo2"]."%'";}
				if ($_POST["nombre2"] <> "") {$sql .= " and nombre like '%".$_POST["nombre2"]."%'";}
				if ($_POST["notas2"] <> "") {$sql .= " and notas like '%".$_POST["notas2"]."%'";}
				if ($_POST["id_subgrupo2"] > 0) {$sql .= " and id_subgrupo=".$_POST["id_subgrupo2"]."";}
			}
			$sql .= " order by id_subgrupo,nombre";
#			echo $sql;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlsg = "select id,id_grupo,subgrupo from sgm_articles_subgrupos where id=".$row["id_subgrupo"]." order by subgrupo";
				$resultsg = mysqli_query($dbhandle,convertSQL($sqlsg));
				$rowsg = mysqli_fetch_array($resultsg);
				$sqlg = "select id,grupo from sgm_articles_grupos where id=".$rowsg["id_grupo"]." order by grupo";
				$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
				$rowg = mysqli_fetch_array($resultg);
				$sqlst = "select pvd,pvp,id_divisa_pvd,id_divisa_pvp from sgm_stock where vigente=1 and id_article=".$row["id"]."";
				$resultst = mysqli_query($dbhandle,convertSQL($sqlst));
				$rowst = mysqli_fetch_array($resultst);
				if ($subgrupo < 0) {echo "<tr style=\"background-color:silver;\"><th colspan=\"2\"></th><th>".$Sin_clasificar."</th><th colspan=\"6\"></th></tr>"; $subgrupo = 0;}
				if ($rowsg["id"] != $subgrupo) {echo "<tr style=\"background-color:silver;\"><th colspan=\"2\"></th><th>".$rowg["grupo"]." - ".$rowsg["subgrupo"]."</th><th colspan=\"6\"></th></tr>";}
				$subgrupo = $rowsg["id"];
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1004&sop=1&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
#						$ultima_fecha = date("d/m/Y",strtotime($row["fecha"]));
#						echo "<td>".$ultima_fecha."</td>";
					echo "<td>".$row["codigo"]."</td>";
					echo "<td>".$row["nombre"]."</td>";
					$sqlsg1 = "select id_grupo,subgrupo from sgm_articles_subgrupos where id=".$row["id_subgrupo"];
					$resultsg1 = mysqli_query($dbhandle,convertSQL($sqlsg1));
					$rowsg1 = mysqli_fetch_array($resultsg1);
					$sqlg1 = "select grupo from sgm_articles_grupos where id=".$rowsg1["id_grupo"];
					$resultg1 = mysqli_query($dbhandle,convertSQL($sqlg1));
					$rowg1 = mysqli_fetch_array($resultg1);
					echo "<td>".$rowg1["grupo"]." - ".$rowsg1["subgrupo"]."</td>";
					$sqld = "select id,abrev from sgm_divisas where visible=1 and id=".$rowst["id_divisa_pvd"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					echo "<td style=\"text-align:right;\">".$rowst["pvd"]." ".$rowd["abrev"]."</td>";
					$sqld = "select id,abrev from sgm_divisas where visible=1 and id=".$rowst["id_divisa_pvp"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					echo "<td style=\"text-align:right;\">".$rowst["pvp"]." ".$rowd["abrev"]."</td>";
					echo "<form action=\"index.php?op=1004&sop=100&id=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
					if ($row["descatalogat"] == 0){
						echo "<form action=\"index.php?op=1004&sop=0&ssop=4&id=".$row["id"]."\" method=\"post\">";
						echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Descatalogar."\"></td>";
						echo "</form>";
					} elseif ($row["descatalogat"] == 1){
						echo "<form action=\"index.php?op=1004&sop=0&ssop=5&id=".$row["id"]."\" method=\"post\">";
						echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Catalogar."\"></td>";
						echo "</form>";
					}
					echo "<form action=\"index.php?op=1004&sop=106&id=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Duplicar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}

	if ($soption == 1) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=0&ssop=3&id=".$_GET["id"],"op=1004&sop=0&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption >= 100) and ($soption < 200) and ($_GET["id"] > 0)) {
		if (($soption == 100) and ($ssoption == 2)) {
			$camposUpdate = array("codigo","nombre","notas","id_subgrupo");
			$datosUpdate = array($_POST["codigo"],$_POST["nombre"],$_POST["notas"],$_POST["id_subgrupo"]);
			updateFunction ("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		$sqld = "select abrev from sgm_divisas where predefinido=1";
		$resultd = mysqli_query($dbhandle,convertSQL($sqld));
		$rowd = mysqli_fetch_array($resultd);
		$sql = "select id,codigo,nombre,id_subgrupo,escandall from sgm_articles where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=0\" style=\"color:white;\">&laquo; ".$Volver."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=100&id=".$row["id"]."\" style=\"color:white;\">".$Datos." ".$Generales."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=110&id=".$row["id"]."\" style=\"color:white;\">".$Archivos."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=120&id=".$row["id"]."\" style=\"color:white;\">".$Imagenes."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=130&id=".$row["id"]."\" style=\"color:white;\">".$Stock."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=140&id=".$row["id"]."\" style=\"color:white;\">".$Logistica."</a></td></tr>";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=150&id=".$row["id"]."\" style=\"color:white;\">".$Escandallo."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:500px;padding : 5px 10px 10px 10px;\">";
					echo "<strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;\">".$row["codigo"]."&nbsp;".$row["nombre"]."&nbsp;&nbsp;</strong>";
					if ($row["escandall"]==1) {echo "(".$escandallo.")";}
					$sqls = "select id_grupo,subgrupo from sgm_articles_subgrupos where id=".$row["id_subgrupo"];
					$results = mysqli_query($dbhandle,convertSQL($sqls));
					$rows = mysqli_fetch_array($results);
					$sqlg = "select grupo from sgm_articles_grupos where id=".$rows["id_grupo"];
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					$rowg = mysqli_fetch_array($resultg);
					$sqlst = "select pvd,pvp from sgm_stock where vigente=1 and id_article=".$row["id"]."";
					$resultst = mysqli_query($dbhandle,convertSQL($sqlst));
					$rowst = mysqli_fetch_array($resultst);
					echo "<br>".$Familia.":".$rowg["grupo"];
					echo "<br>".$Subfamilia.":".$rows["subgrupo"];
					echo "<br>".$PVD.":".$rowst["pvd"]." ".$rowd["abrev"];
					echo "<br>".$PVP.":".$rowst["pvp"]." ".$rowd["abrev"];
					echo "<br>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1004&sop=105&id=".$row["id"]."\" style=\"color:white;\">".$Opciones."</a></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 100) {
		if ($ssoption == 3) {
			$camposInsert = "id_articulo,id_proveedor,codigo_proveedor";
			$datosInsert = array($_GET["id"],$_POST["id_proveedor"],$_POST["codigo_proveedor"]);
			insertFunction ("sgm_articles_rel_proveedores",$camposInsert,$datosInsert);
		}
		if ($ssoption == 4) {
			$camposUpdate = array("id_proveedor","codigo_proveedor");
			$datosUpdate = array($_POST["id_proveedor"],$_POST["codigo_proveedor"]);
			updateFunction ("sgm_articles_rel_proveedores",$_GET["id_prov"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_articles_rel_proveedores",$_GET["id_prov"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			$sqlv = "select id from sgm_articles_rel_caracteristicas where id_articulo=".$_GET["id"];
			$resultv = mysqli_query($dbhandle,convertSQL($sqlv));
			while ($rowv = mysqli_fetch_array($resultv)) {
				$camposUpdate = array("valor");
				$datosUpdate = array($_POST["valor".$rowv["id"]]);
				updateFunction ("sgm_articles_rel_caracteristicas",$rowv["id"],$camposUpdate,$datosUpdate);
			}
		}

		$sqla = "select id,id_subgrupo,nombre,notas,codigo from sgm_articles where id=".$_GET["id"];
		$resulta = mysqli_query($dbhandle,convertSQL($sqla));
		$rowa = mysqli_fetch_array($resulta);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th></th>";
							echo "<th>".$Datos." ".$Generales."</th>";
						echo "</tr>";
						echo "<form action=\"index.php?op=1004&sop=100&ssop=2&id=".$rowa["id"]."\" method=\"post\">";
						$sqlsg1 = "select id_grupo,codigo from sgm_articles_subgrupos where id=".$rowa["id_subgrupo"];
						$resultsg1 = mysqli_query($dbhandle,convertSQL($sqlsg1));
						$rowsg1 = mysqli_fetch_array($resultsg1);
						$sqlg1 = "select codigo from sgm_articles_grupos where id=".$rowsg1["id_grupo"];
						$resultg1 = mysqli_query($dbhandle,convertSQL($sqlg1));
						$rowg1 = mysqli_fetch_array($resultg1);
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Codigo."</th><td><input type=\"Text\" value=\"".$rowg1["codigo"]."".$rowsg1["codigo"]."\" disabled style=\"width:50px\"><input type=\"Text\" name=\"codigo\" style=\"width:250px\" value=\"".$rowa["codigo"]."\" required></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Nombre."</th><td><input type=\"Text\" name=\"nombre\" style=\"width:300px\" value=\"".$rowa["nombre"]."\" required></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Familia."</th><td><select name=\"id_subgrupo\" style=\"width:300px\">";
							echo "<option value=\"0\">".$Sin." ".$Clasificar."</option>";
							$sqlg2 = "select id,grupo from sgm_articles_grupos order by grupo";
							$resultg2 = mysqli_query($dbhandle,convertSQL($sqlg2));
							while ($rowg2 = mysqli_fetch_array($resultg2)) {
								$sqlsg2 = "select id,subgrupo from sgm_articles_subgrupos where id_grupo=".$rowg2["id"]." order by subgrupo";
								$resultsg2 = mysqli_query($dbhandle,convertSQL($sqlsg2));
								while ($rowsg2 = mysqli_fetch_array($resultsg2)) {
									if ($rowsg2["id"] == $rowa["id_subgrupo"]) { echo "<option value=\"".$rowsg2["id"]."\" selected>".$rowg2["grupo"]." - ".$rowsg2["subgrupo"]."</option>"; }
									else { echo "<option value=\"".$rowsg2["id"]."\">".$rowg2["grupo"]." - ".$rowsg2["subgrupo"]."</option>"; }
								}
							}
						echo "</select></td></tr>";
						echo "<tr><th style=\"text-align:right;vertical-align:top;\">".$Descripcion."</th><td><textarea name=\"notas\" style=\"width:300px\" rows=\"5\">".$rowa["notas"]."</textarea></td></tr>";
						echo "<tr><td></td><td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
						echo "</form>";
					echo "</table>";
				echo "</td><td style=\"width:100px\">&nbsp;</td><td style=\"vertical-align:top;text-align:left;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th></th>";
							echo "<th>".$Proveedores." :</th>";
						echo "</tr><tr>";
							echo "<th></th>";
							echo "<th>".$Codigo."</th>";
							echo "<th>".$Proveedor."</th>";
							echo "<th></th>";
							echo "<form action=\"index.php?op=1004&sop=100&ssop=3&id=".$rowa["id"]."\" method=\"post\">";
						echo "</tr><tr>";
							echo "<td></td>";
							echo "<td><input type=\"Text\" name=\"codigo_proveedor\" style=\"width:100px\"></td>";
							echo "<td><select name=\"id_proveedor\" style=\"width:300px\">";
								$sqlg1 = "select id,nombre from sgm_clients where visible=1 order by nombre";
								$resultg1 = mysqli_query($dbhandle,convertSQL($sqlg1));
								while ($rowg1 = mysqli_fetch_array($resultg1)) {
									echo "<option value=\"".$rowg1["id"]."\">".$rowg1["nombre"]."</option>";
								}
							echo "</select></td>";
							echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
						echo "</tr>";
						echo "</form>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sqlp = "select id,codigo_proveedor,id_proveedor from sgm_articles_rel_proveedores where id_articulo=".$_GET["id"]." and visible=1";
						$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
						while ($rowp = mysqli_fetch_array($resultp)) {
							echo "<form action=\"index.php?op=1004&sop=100&ssop=4&id=".$rowa["id"]."&id_prov=".$rowp["id"]."\" method=\"post\">";
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1004&sop=102&id=".$rowa["id"]."&id_prov=".$rowp["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
								echo "<td><input type=\"Text\" name=\"codigo_proveedor\" value=\"".$rowp["codigo_proveedor"]."\" style=\"width:100px\"></td>";
								echo "<td><select name=\"id_proveedor\" style=\"width:300px\">";
									$sqlg1 = "select id,nombre from sgm_clients where visible=1 order by nombre";
									$resultg1 = mysqli_query($dbhandle,convertSQL($sqlg1));
									while ($rowg1 = mysqli_fetch_array($resultg1)) {
										if ($rowg1["id"] == $rowp["id_proveedor"]) { echo "<option value=\"".$rowg1["id"]."\" selected>".$rowg1["nombre"]."</option>"; }
										else { echo "<option value=\"".$rowg1["id"]."\">".$rowg1["nombre"]."</option>"; }
									}
								echo "</select></td>";
								echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
							echo "</tr>";
							echo "</form>";
						}
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						########## BLOQUE CARACTERISTICAS
						echo "<form action=\"index.php?op=1004&sop=100&ssop=6&id=".$rowa["id"]."\" method=\"post\">";
						echo "<tr style=\"\">";
							echo "<th style=\"width:125px\" colspan=\"2\">".$Caracteristica."</th>";
							echo "<th style=\"width:300px\">".$Valor."</th>";
							echo "<th style=\"width:125px\">".$Unidad." (".$abreviatura.")</th>";
						echo "</tr>";
						$sqlf = "select id_caracteristica from sgm_articles_subgrupos_caracteristicas where id_subgrupo=".$rowa["id_subgrupo"]."";
						$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
						while ($rowf = mysqli_fetch_array($resultf)) {
							$sqlc = "select id,nombre,valor,unidad,unidad_abr from sgm_articles_caracteristicas where id_caracteristica=0 and id=".$rowf["id_caracteristica"]." and visible=1 order by nombre";
							$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
							while ($rowc = mysqli_fetch_array($resultc)) {
							## CARACTERISTICAS
								echo "<tr style=\"background-color : Silver;\">";
									echo "<td colspan=\"2\"><strong>".$rowc["nombre"]."</strong></td>";
										### RECUPERO EL VALOR O PONGO EL PREDEFINIDO
										$valor_inicial = false;
										$sqlvt = "select count(*) as total from sgm_articles_rel_caracteristicas where id_articulo=".$rowa["id"]." and id_valor=".$rowc["id"];
										$resultvt = mysqli_query($dbhandle,convertSQL($sqlvt));
										$rowvt = mysqli_fetch_array($resultvt);
										if ($rowvt["total"] == 0) {
											$sql = "insert into sgm_articles_rel_caracteristicas (id_articulo,id_valor,valor) values (".$rowa["id"].",".$rowc["id"].",'".$rowc["valor"]."')";
											mysqli_query($dbhandle,convertSQL($sql));
											$valor_inicial = true;
										}
										$sqlv = "select id,valor from sgm_articles_rel_caracteristicas where id_articulo=".$rowa["id"]." and id_valor=".$rowc["id"];
										$resultv = mysqli_query($dbhandle,convertSQL($sqlv));
										$rowv = mysqli_fetch_array($resultv);
										$valor = $rowv["valor"];
										if (($valor == "") and ($valor_inicial == true)) { $valor = $rowc["valor"]; }
										### COMPROBACION DE TABLA SI / NO
										$tabla = false;
										$sqlvt = "select count(*) as total from sgm_articles_caracteristicas_tablas where visible=1 and  id_caracteristica=".$rowc["id"];
										$resultvt = mysqli_query($dbhandle,convertSQL($sqlvt));
										$rowvt = mysqli_fetch_array($resultvt);
										if ($rowvt["total"] >= 1) { $tabla = true; } else { $tabla = false; }
										### ECHO EN FUNCION DE TABLA SI / NO
									if ($tabla == false) {	echo "<td><input type=\"Text\" name=\"valor".$rowv["id"]."\" value=\"".$valor."\" style=\"width:300px\"></td>"; }
									else {
										echo "<td><select name=\"valor".$rowv["id"]."\" style=\"width:300px\">";
										 echo "<option value=\"0\">-</option>";
										$sqlvta = "select id,valor from sgm_articles_caracteristicas_tablas where visible=1 and  id_caracteristica=".$rowc["id"];
										$resultvta = mysqli_query($dbhandle,convertSQL($sqlvta));
										while ($rowvta = mysqli_fetch_array($resultvta)) {
											if ($rowvta["id"] == $valor) { echo "<option value=\"".$rowvta["id"]."\" selected>".$rowvta["valor"]."</option>"; }
												else { echo "<option value=\"".$rowvta["id"]."\">".$rowvta["valor"]."</option>"; }
										}
										echo "</select></td>";
									}
									echo "<td>";
										if ($rowc["unidad"] != "") { echo $rowc["unidad"]." (".$rowc["unidad_abr"].")"; }
									echo "</td>";
								echo "</tr>";
								###################################### SUB
								$sqlsc = "select id,nombre,valor,unidad,unidad_abr from sgm_articles_caracteristicas where id_caracteristica=".$rowc["id"]." and visible=1 order by nombre";
								$resultsc = mysqli_query($dbhandle,convertSQL($sqlsc));
								while ($rowsc = mysqli_fetch_array($resultsc)) {
								## CARACTERISTICAS
									echo "<tr style=\"background-color : white;\">";
										echo "<td colspan=\"2\"><strong>".$rowsc["nombre"]."</strong></td>";
											### RECUPERO EL VALOR O PONGO EL PREDEFINIDO
											$valor_inicial = false;
											$sqlvt = "select count(*) as total from sgm_articles_rel_caracteristicas where id_articulo=".$rowa["id"]." and id_valor=".$rowsc["id"];
											$resultvt = mysqli_query($dbhandle,convertSQL($sqlvt));
											$rowvt = mysqli_fetch_array($resultvt);
											if ($rowvt["total"] == 0) {
												$sql = "insert into sgm_articles_rel_caracteristicas (id_articulo,id_valor,valor) values (".$rowa["id"].",".$rowsc["id"].",'".$rowsc["valor"]."')";
												mysqli_query($dbhandle,convertSQL($sql));
												$valor_inicial = true;
											}
											$sqlv = "select id,valor from sgm_articles_rel_caracteristicas where id_articulo=".$rowa["id"]." and id_valor=".$rowsc["id"];
											$resultv = mysqli_query($dbhandle,convertSQL($sqlv));
											$rowv = mysqli_fetch_array($resultv);
											$valor = $rowv["valor"];
											if (($valor == "") and ($valor_inicial == true)) { $valor = $rowsc["valor"]; }
											### COMPROBACION DE TABLA SI / NO
											$tabla = false;
											$sqlvt = "select count(*) as total from sgm_articles_caracteristicas_tablas where visible=1 and  id_caracteristica=".$rowsc["id"];
											$resultvt = mysqli_query($dbhandle,convertSQL($sqlvt));
											$rowvt = mysqli_fetch_array($resultvt);
											if ($rowvt["total"] >= 1) { $tabla = true;} else { $tabla = false; }
											### ECHO EN FUNCION DE TABLA SI / NO
										if ($tabla == false) {	echo "<td><input type=\"Text\" name=\"valor".$rowv["id"]."\" value=\"".$valor."\" style=\"width:300px\"></td>"; }
										else {
											echo "<td><select name=\"valor".$rowv["id"]."\" style=\"width:300px\">";
											$sqlvta = "select id,valor from sgm_articles_caracteristicas_tablas where visible=1 and  id_caracteristica=".$rowsc["id"];
											$resultvta = mysqli_query($dbhandle,convertSQL($sqlvta));
											while ($rowvta = mysqli_fetch_array($resultvta)) {
												if ($rowvta["id"] == $valor) { echo "<option value=\"".$rowvta["id"]."\" selected>".$rowvta["valor"]."</option>"; }
													else { echo "<option value=\"".$rowvta["id"]."\">".$rowvta["valor"]."</option>"; }
											}
											echo "</select></td>";
										}
										echo "<td>";
											if ($rowsc["unidad"] != "") { echo $rowsc["unidad"]." (".$rowsc["unidad_abr"].")"; }
										echo "</td>";
									echo "</tr>";
								}
							}
						}
					echo "<tr><td colspan=\"2\"></td><td><input type=\"submit\" style=\"width:300px\" value=\"".$Cambiar."\"></td><td></td></tr>";
					echo "</form>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=0&ssop=3&id=".$_GET["id"],"op=1004&sop=105&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 102) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=100&ssop=5&id=".$_GET["id"]."&id_prov=".$_GET["id_prov"],"op=1004&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 105) {
		if ($ssoption == 4) {
			$camposUpdate=array('descatalogat');
			$datosUpdate=array(1);
			updateFunction("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate=array('descatalogat');
			$datosUpdate=array(0);
			updateFunction("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Opciones."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"1\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;Width:33%;text-align:center;background-color:silver;\">";
					echo "<table style=\"text-align:left;vertical-align:top;\" class=\"lista\"><tr>";
						echo "<th style=\"width:400px\">".$Duplicar." ".$Articulo."</th>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">".$duplicarArticulo."</td>";
					echo "</tr></table><table class=\"lista\"><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1004&sop=106&id=".$_GET["id"]."\" style=\"color:white;\">".$Duplicar."</a>";
						echo "</td>";
					echo "</tr></table></center>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;width:33%;text-align:center;background-color:silver;\">";
					echo "<center><table style=\"text-align:left;vertical-align:top;\"><tr>";
						echo "<th style=\"width:400px\">".$Eliminar." ".$Articulo."</th>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">".$eliminarArticulo."</td>";
					echo "</tr></table><table class=\"lista\"><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:red;border: 1px solid black;\">";
							echo "<a href=\"index.php?op=1004&sop=101&id=".$row["id"]."\" style=\"color:white;\">".$Eliminar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;Width:33%;text-align:center;background-color:silver;\">";
					$sql = "select descatalogat from sgm_articles where id=".$_GET["id"];
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					if ($row["descatalogat"] == 0){
					echo "<table style=\"text-align:left;vertical-align:top;\" class=\"lista\"><tr>";
						echo "<th style=\"width:400px\">".$Descatalogar." ".$Articulo."</th>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">".$descatalogarArticulo."</td>";
					echo "</tr></table><table class=\"lista\"><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1004&sop=105&ssop=4&id=".$_GET["id"]."\" style=\"color:white;\">".$Descatalogar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table>";
					}
					if ($row["descatalogat"] == 1){
					echo "<table style=\"text-align:left;vertical-align:top;\" class=\"lista\"><tr>";
						echo "<th style=\"width:400px\">".$Catalogar." ".$Articulo."</th>";
					echo "</tr><tr>";
						echo "<td style=\"width:400px\">".$catalogarArticulo."</td>";
					echo "</tr></table><table class=\"lista\"><tr>";
						echo "<td style=\"width:120px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1004&sop=105&ssop=5&id=".$_GET["id"]."\" style=\"color:white;\">".$Catalogar."</a>";
						echo "</td>";
					echo "</tr><tr><td>&nbsp;</td>";
					echo "</tr></table>";
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 106) {
		$sql = "select * from sgm_articles where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);

		$camposInsert = "codigo,nombre,id_subgrupo,img1,img2,img3,notas,escandall,recalc_escandall,stock_max,stock_min,descatalogat,id_divisa";
		$datosInsert = array($row["codigo"],$row["nombre"],$row["id_subgrupo"],$row["img1"],$row["img2"],$row["img3"],$row["notas"],$row["escandall"],$row["recalc_escandall"],$row["stock_max"],$row["stock_min"],$row["descatalogat"],$row["id_divisa"]);
		insertFunction ("sgm_articles",$camposInsert,$datosInsert);

		$sqlart = "select id from sgm_articles where visible=1 and codigo='".$row["codigo"]."' order by id desc";
		$resultart = mysqli_query($dbhandle,convertSQL($sqlart));
		$rowart = mysqli_fetch_array($resultart);

		$sqles = "select id_article,unitats,visible from sgm_articles_escandall where visible=1 and id_escandall=".$_GET["id"];
		$resultes = mysqli_query($dbhandle,convertSQL($sqles));
		while ($rowes = mysqli_fetch_array($resultes)) {
			$camposInsert = "id_escandall,id_article,unitats,visible";
			$datosInsert = array($rowart["id"],$rowes["id_article"],$rowes["unitats"],$rowes["visible"]);
			insertFunction ("sgm_articles_escandall",$camposInsert,$datosInsert);
		}

		$sqlca = "select id_valor,valor from sgm_articles_rel_caracteristicas where id_articulo=".$_GET["id"];
		$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
		while ($rowca = mysqli_fetch_array($resultca)) {
			$camposInsert = "id_articulo,id_valor,valor";
			$datosInsert = array($rowart["id"],$rowca["id_valor"],$rowca["valor"]);
			insertFunction ("sgm_articles_rel_caracteristicas",$camposInsert,$datosInsert);
		}

		$sqlpr = "select * from sgm_articles_rel_proveedores where visible=1 and id_articulo=".$_GET["id"];
		$resultpr = mysqli_query($dbhandle,convertSQL($sqlpr));
		while ($rowpr = mysqli_fetch_array($resultpr)) {
			$camposInsert = "id_articulo,id_proveedor,codigo_proveedor,visible";
			$datosInsert = array($rowart["id"],$rowpr["id_proveedor"],$rowpr["codigo_proveedor"],$rowpr["visible"]);
			insertFunction ("sgm_articles_rel_proveedores",$camposInsert,$datosInsert);
		}

		$sqlst = "select * from sgm_stock where id_article=".$_GET["id"];
		$resultst = mysqli_query($dbhandle,convertSQL($sqlst));
		while ($rowst = mysqli_fetch_array($resultst)) {
			$camposInsert = "id_article,id_almacen,unidades,pvd,pvp,web,vigente,fecha,id_user,id_compte_entradas,id_divisa_pvp,id_divisa_pvd";
			$datosInsert = array($rowart["id"],$rowst["id_almacen"],$rowst["unidades"],$rowst["pvd"],$rowst["pvp"],$rowst["web"],$rowst["vigente"],$rowst["fecha"],$rowst["id_user"],$rowst["id_compte_entradas"],$rowst["id_divisa_pvp"],$rowst["id_divisa_pvd"]);
			insertFunction ("sgm_stock",$camposInsert,$datosInsert);
		}
		echo "<center>";
		echo boton(array("op=1004&sop=100&id=".$_GET["id"],"op=1004&sop=100&id=".$rowart["id"]),array($Original,$Duplicado));
		echo "</center>";
	}

	if ($soption == 110) {
		echo "<h4>".$Archivos."</h4>";
		anadirArchivo ($_GET["id"],1,"");
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=110&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1004&sop=110&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 120) {
		if ($ssoption == 1) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				$archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
				$id_imagen = $_POST["imagen"];
				$id_articulo = $_POST["id_articulo"];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
				$id_imagen = $HTTP_POST_VARS["imagen"];
				$id_articulo = $HTTP_POST_VARS["id_articulo"];
			}
			$lim_tamano = 200*1000;
			$sqlt = "select count(*) as total from sgm_articles where img1='".$archivo_name."' or img2='".$archivo_name."' or img3='".$archivo_name."'";
			$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
			$rowt = mysqli_fetch_array($resultt);
			if ($rowt["total"] != 0) {
				echo mensageError($errorSubirArchivoDuplicado);
			} else {
				if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
					if (copy ($archivo, "archivos/articulos/".$archivo_name)) {
						$sql = "update sgm_articles set ";
						if ($id_imagen == 1) { $sql = $sql."img1='".$archivo_name."'"; }
						if ($id_imagen == 2) { $sql = $sql."img2='".$archivo_name."'"; }
						if ($id_imagen == 3) { $sql = $sql."img3='".$archivo_name."'"; }
						$sql = $sql." WHERE id=".$id_articulo."";
						mysqli_query($dbhandle,convertSQL($sql));
					}else{
						echo mensageError($errorSubirArchivo);
					}
				}else{
					echo mensageError($errorSubirArchivoTamany);
				}
			}
		}
		if ($ssoption == 3) {
			$sql = "select * from sgm_articles where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			unlink ( "archivos/articulos/".$row["img".$_GET["id_imagen"].""]);

			$sql = "update sgm_articles set ";
			if ($_GET["id_imagen"] == 1) { $sql = $sql."img1=''"; }
			if ($_GET["id_imagen"] == 2) { $sql = $sql."img2=''"; }
			if ($_GET["id_imagen"] == 3) { $sql = $sql."img3=''"; }
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
		}

		$sqla = "select id,img1,img2,img3 from sgm_articles where id=".$_GET["id"];
		$resulta = mysqli_query($dbhandle,convertSQL($sqla));
		$rowa = mysqli_fetch_array($resulta);
		$id_articulo = $rowa["id"];
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td style=\"width:33%\"></td><th style=\"width:67%\">".$Imagen."</th></tr>";
			echo "<tr style=\"background-color : Silver;\">";
				echo "<td style=\"vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1004&sop=120&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"Hidden\" name=\"id_articulo\" value=\"".$rowa["id"]."\">";
					echo "<input type=\"Hidden\" name=\"imagen\" value=\"1\">";
					echo "<input type=\"file\" name=\"archivo\">";
					echo "<br><input type=\"submit\" value=\"".$Subir." ".$Imagen." 1\" style=\"width:200px\">";
					echo "<br><a href=\"index.php?op=1004&sop=121&id=".$rowa["id"]."&id_imagen=1\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>";
					echo "</form>";
				echo "</td><td>";
					if ($rowa["img1"] != "") { echo "<img src=\"archivos/articulos/".$rowa["img1"]."\">"; }
				echo "</td></tr>";
				echo "<tr><td style=\"vertical-align:top;\">";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1004&sop=120&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
					echo "<center>";
					echo "<input type=\"Hidden\" name=\"id_articulo\" value=\"".$rowa["id"]."\">";
					echo "<input type=\"Hidden\" name=\"imagen\" value=\"2\">";
					echo "<input type=\"file\" name=\"archivo\">";
					echo "<br><input type=\"submit\" value=\"".$Subir." ".$Imagen."  2\" style=\"width:200px\">";
					echo "<br><a href=\"index.php?op=1004&sop=121&id=".$rowa["id"]."&id_imagen=2\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>";
					echo "</form>";
				echo "</td><td>";
				if ($rowa["img2"] != "") { echo "<img src=\"archivos/articulos/".$rowa["img2"]."\">"; }
			echo "</td></tr>";
			echo "<tr style=\"background-color : Silver;\"><td style=\"vertical-align:top;\">";
				echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1004&sop=120&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<center>";
				echo "<input type=\"Hidden\" name=\"id_articulo\" value=\"".$rowa["id"]."\">";
				echo "<input type=\"Hidden\" name=\"imagen\" value=\"3\">";
				echo "<input type=\"file\" name=\"archivo\">";
				echo "<br><input type=\"submit\" value=\"".$Subir." ".$Imagen."  3\" style=\"width:200px\">";
				echo "<br><a href=\"index.php?op=1004&sop=121&id=".$rowa["id"]."&id_imagen=3\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>";
				echo "</form>";
			echo "</td><td>";
				if ($rowa["img3"] != "") { echo "<img src=\"archivos/articulos/".$rowa["img3"]."\">"; }
			echo "</td></tr>";
		echo "</table>";
	}

	if ($soption == 121) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=120&ssop=3&id=".$_GET["id"]."&id_imagen=".$_GET["id_imagen"],"op=1004&sop=120&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 130) {
		if ($ssoption == 1){
			$camposInsert = "id_article,pvd,pvp,id_divisa_pvd,id_divisa_pvp,vigente,fecha,id_user,descuento";
			$datosInsert = array($_GET["id"],$_POST["pvd"],$_POST["pvp"],$_POST["id_divisa_pvd"],$_POST["id_divisa_pvp"],$_POST["vigente"],$_POST["fecha"],$userid,$_POST["descuento"]);
			insertFunction ("sgm_stock",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$sql = "update sgm_stock set ";
			$sql = $sql."vigente=0";
			$sql = $sql." WHERE id_article=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));

			$sql = "update sgm_stock set ";
			$sql = $sql."vigente=1";
			$sql = $sql." WHERE id=".$_GET["id_stock"]."";
			mysqli_query($dbhandle,convertSQL($sql));
		}
		if ($ssoption == 3) {
			$camposUpdate = array("pvd","pvp","id_divisa_pvd","id_divisa_pvp","fecha","descuento");
			$datosUpdate = array($_POST["pvd"],$_POST["pvp"],$_POST["id_divisa_pvd"],$_POST["id_divisa_pvp"],$_POST["fecha"],$_POST["descuento"]);
			updateFunction ("sgm_stock",$_GET["id_stock"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Stock." : </h4>";
		echo boton(array("op=1004&sop=135&id=".$_GET["id"]),array($Por_clientes));

		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"background: Silver;\">";
			echo "<caption>".$Calculadora."</caption>";
			echo "<tr>";
				echo "<th>".$Precio." I.V.A.</th><th>% I.V.A.</th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form name=\"calcular\">";
				echo "<td><input type=\"Text\" name=\"preu_iva\" style=\"width:100px\"></td>";
				echo "<td><input type=\"Text\" name=\"iva\" style=\"width:50px\"></td>";
				echo "</form>";
				echo "<td><a href=\"#\" onclick=\"add.pvd.value=calcular.preu_iva.value/((calcular.iva.value/100)+1)\" style=\"color:black\">".$PVD."</a></td>";
				echo "<td><a href=\"#\" onclick=\"add.pvp.value=calcular.preu_iva.value/((calcular.iva.value/100)+1)\" style=\"color:black\">".$PVP."</a></td>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		$sqlt = "select count(*) as total from sgm_stock where id_article=".$_GET["id"];
		$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
		$rowt = mysqli_fetch_array($resultt);
		$sqlst = "select count(*) as total from sgm_stock where id_article=".$_GET["id"]." and vigente=1";
		$resultst = mysqli_query($dbhandle,convertSQL($sqlst));
		$rowst = mysqli_fetch_array($resultst);
		$vigente = 1;
		if ($rowst["total"] > 0) { $vigente=0; }
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<th></th>";
				echo "<th>".$Fecha." ".$Entrada."</th>";
				echo "<th>".$PVD."</th>";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$PVP."</th>";
				echo "<th>".$Divisa."</th>";
				echo "<th>".$Descuento."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1004&sop=130&ssop=1&id=".$_GET["id"]."\" method=\"post\" name=\"add\">";
				echo "<input type=\"Hidden\" name=\"vigente\" value=\"".$vigente."\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" name=\"fecha\" style=\"width:100px\" value=\"".date("Y-m-d")."\"></td>";
				echo "<td><input type=\"text\" name=\"pvd\" style=\"width:50px\" value=\"0\"></td>";
				echo "<td><select name=\"id_divisa_pvd\" type=\"Text\" style=\"width:100px\">";
					echo "<option value=\"0\">-</option>";
					$sqlp= "select id,divisa from sgm_divisas";
					$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
					while ($rowp = mysqli_fetch_array($resultp)){
						echo "<option value=\"".$rowp["id"]."\">".$rowp["divisa"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"text\" name=\"pvp\" style=\"width:50px\" value=\"0\"></td>";
				echo "<td><select name=\"id_divisa_pvp\" type=\"Text\" style=\"width:100px\">";
					echo "<option value=\"0\">-</option>";
					$sqlp= "select id,divisa from sgm_divisas";
					$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
					while ($rowp = mysqli_fetch_array($resultp)){
						echo "<option value=\"".$rowp["id"]."\">".$rowp["divisa"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"text\" name=\"descuento\" style=\"width:50px\" value=\"0.00\"> %</td>";
				echo "<td class=\"Submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$totalunidades = 0;
			$totalpvd = 0;
			$totalpvp = 0;
			$sqls = "select * from sgm_stock where id_article=".$_GET["id"]." order by fecha desc, id asc";
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			while ($rows = mysqli_fetch_array($results)) {
				$color = "white";
				if ($rows["vigente"] == 1) { $color = "#FF4500"; }
				echo "<tr style=\"background-color : ".$color."\">";
					echo "<form action=\"index.php?op=1004&sop=130&ssop=2&id=".$_GET["id"]."&id_stock=".$rows["id"]."\" method=\"post\" name=\"formulario".$rows["id"]."\">";
					echo "<td class=\"Submit\"><input type=\"submit\" value=\"Vigente\"></td>";
					echo "<input type=\"Hidden\" name=\"codigo\" value=\"".$rows["codigo"]."\">";
					echo "</form>";
					echo "<form action=\"index.php?op=1004&sop=130&ssop=3&id=".$_GET["id"]."&id_stock=".$rows["id"]."\" method=\"post\" name=\"formulario".$rows["id"]."\">";
					echo "<td><input type=\"text\" name=\"fecha\" style=\"width:100px\" value=\"".$rows["fecha"]."\"></td>";
					echo "<td><input type=\"text\" name=\"pvd\" style=\"width:50px\" value=\"".$rows["pvd"]."\"></td>";
					echo "<td><select name=\"id_divisa_pvd\" type=\"Text\" style=\"width:100px\">";
						echo "<option value=\"0\">-</option>";
						$sqlp= "select id,divisa from sgm_divisas";
						$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
						while ($rowp = mysqli_fetch_array($resultp)){
							if ($rows["id_divisa_pvd"] == $rowp["id"]){
								echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["divisa"]."</option>";
							}else{
								echo "<option value=\"".$rowp["id"]."\">".$rowp["divisa"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"pvp\" style=\"width:50px\" value=\"".$rows["pvp"]."\"></td>";
					echo "<td><select name=\"id_divisa_pvp\" type=\"Text\" style=\"width:100px\">";
						echo "<option value=\"0\">-</option>";
						$sqlp= "select id,divisa from sgm_divisas";
						$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
						while ($rowp = mysqli_fetch_array($resultp)){
							if ($rows["id_divisa_pvp"] == $rowp["id"]){
								echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["divisa"]."</option>";
							}else{
								echo "<option value=\"".$rowp["id"]."\">".$rowp["divisa"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"descuento\" style=\"width:50px\" value=\"".$rows["descuento"]."\"> %</td>";
					if ($rows["idfactura"] == 0){
						echo "<td class=\"Submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
					}
					echo "</form>";
				echo "</tr>";
				$totalunidades = $totalunidades+$rows["unidades"];
				$totalpvd = $totalpvd+($rows["pvd"]*$rows["unidades"]);
				$totalpvp = $totalpvp+($rows["pvp"]*$rows["unidades"]);
			}
			if (($rowt["total"] > 0) and ($totalunidades > 0)){
				echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td style=\"color:#FF4500\"><strong>".$totalunidades."</strong></td>";
					echo "<td style=\"color:#FF4500\"><strong>".number_format(($totalpvd/$totalunidades), 3, ',', '.')."</strong></td>";
					echo "<td style=\"color:#FF4500\"><strong>".number_format(($totalpvp/$totalunidades), 3, ',', '.')."</strong></td>";
					echo "<td></td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 140) {
		if ($ssoption == 1) {
			$sqls = "select id_estanteria,id from sgm_stock_almacenes_pasillo_estanteria_seccion where id=".$_POST["id_seccion"];
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			$rows = mysqli_fetch_array($results);
			$sqle = "select id_pasillo,id from sgm_stock_almacenes_pasillo_estanteria where id=".$rows["id_estanteria"];
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			$rowe = mysqli_fetch_array($resulte);
			$sqlp = "select id_almacen,id from sgm_stock_almacenes_pasillo where id=".$rowe["id_pasillo"];
			$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
			$rowp = mysqli_fetch_array($resultp);
			$sqla = "select id from sgm_stock_almacenes where id=".$rowp["id_almacen"];
			$resulta = mysqli_query($dbhandle,convertSQL($sqla));
			$rowa = mysqli_fetch_array($resulta);
			$camposUpdate = "id_article,id_seccion,id_estanteria,id_pasillo,id_almacen";
			$datosInsert = array($_GET["id"],$rows["id"],$rowe["id"],$rowp["id"],$rowa["id"]);
			insertFunction ("sgm_articles_seccions",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_articles_seccions",$_GET["id_seccion_articulo"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Logistica."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Nueva." ".$Ubicacion."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1004&sop=140&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_seccion\" style=\"width:300px\">";
				$sqla = "select id,nombre from sgm_stock_almacenes order by nombre";
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				while ($rowa = mysqli_fetch_array($resulta)) {
					$sqlp = "select id,nombre from sgm_stock_almacenes_pasillo where visible=1 and id_almacen=".$rowa["id"]." order by orden";
					$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
					while ($rowp = mysqli_fetch_array($resultp)) {
						$sqle = "select id,nombre from sgm_stock_almacenes_pasillo_estanteria where visible=1 and id_pasillo=".$rowp["id"]." order by orden";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						while ($rowe = mysqli_fetch_array($resulte)) {
							$sqls = "select id,nombre from sgm_stock_almacenes_pasillo_estanteria_seccion where visible=1 and id_estanteria=".$rowe["id"]." order by orden";
							$results = mysqli_query($dbhandle,convertSQL($sqls));
							while ($rows = mysqli_fetch_array($results)) {
								echo "<option value=\"".$rows["id"]."\">".$rowa["nombre"]."-".$rowp["nombre"]."-".$rowe["nombre"]."-".$rows["nombre"]."</option>";
							}
						}
					}
				}
				echo "</select></td>";
				echo "<td class=\"Submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$sqlas = "select id_seccion,id_almacen,id from sgm_articles_seccions where id_article=".$_GET["id"]." and visible=1";
			$resultas = mysqli_query($dbhandle,convertSQL($sqlas));
			while ($rowas = mysqli_fetch_array($resultas)) {
				$sqls = "select id_estanteria,nombre from sgm_stock_almacenes_pasillo_estanteria_seccion where id=".$rowas["id_seccion"];
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				$rows = mysqli_fetch_array($results);
				$sqle = "select id_pasillo,nombre from sgm_stock_almacenes_pasillo_estanteria where id=".$rows["id_estanteria"];
				$resulte = mysqli_query($dbhandle,convertSQL($sqle));
				$rowe = mysqli_fetch_array($resulte);
				$sqlp = "select id_almacen,nombre,id from sgm_stock_almacenes_pasillo where id=".$rowe["id_pasillo"];
				$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
				$rowp = mysqli_fetch_array($resultp);
				$sqla = "select nombre from sgm_stock_almacenes where id=".$rowp["id_almacen"];
				$resulta = mysqli_query($dbhandle,convertSQL($sqla));
				$rowa = mysqli_fetch_array($resulta);
				echo "<tr style=\"background-color:silver;\">";
					echo "<th>".$Eliminar."</th>";
					echo "<th style=\"text-align:center;\">".$Localizacion."</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1004&sop=141&id=".$_GET["id"]."&id_seccion_articulo=".$rowas["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td>".$rowa["nombre"]."-".$rowp["nombre"]."-".$rowe["nombre"]."-".$rows["nombre"]."</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>";
						echo boton(array("op=1004&sop=145&id=".$_GET["id"]."&id_almacen=".$rowas["id_almacen"]."&id_seccion=".$rowas["id_seccion"]),array($Ver." ".$Almacen));
					echo "</td>";
				echo "</tr><tr>";
					echo "<td></td>";
					echo "<td>";
						$sqlp = "select id,nombre from sgm_stock_almacenes_pasillo where id=".$rowp["id"];
						$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
						while ($rowp = mysqli_fetch_array($resultp)) {
							echo "Pasillo : <strong>".$rowp["nombre"]."</strong><br><br>";
							echo "<table cellpadding=\"0\" cellspacing=\"0\">";
							$sqlet = "select count(*) as total from sgm_stock_almacenes_pasillo_estanteria where id_pasillo=".$rowp["id"]." and visible=1 order by orden";
							$resultet = mysqli_query($dbhandle,convertSQL($sqlet));
							$rowet = mysqli_fetch_array($resultet);
							if ($rowet["total"] == 0) {
								echo "<tr><td style=\"width:100px;text-align:right;vertical-align:top;\">Sin estanterias&nbsp;&nbsp;</td><td><table style=\"width:520px;height:50px;background-color: Black;\"><tr>";
								echo "<td style=\"width:100%;\">&nbsp;</td>";
								echo "</tr></table></td></tr>";
							} else {
								$sqle = "select id,nombre from sgm_stock_almacenes_pasillo_estanteria where id_pasillo=".$rowp["id"]." and visible=1 order by orden";
								$resulte = mysqli_query($dbhandle,convertSQL($sqle));
								while ($rowe = mysqli_fetch_array($resulte)) {
									echo "<tr><td style=\"width:100px;text-align:right;vertical-align:top;\">".$rowe["nombre"]."&nbsp;&nbsp;</td><td><table style=\"width:520px;border-left: 1px solid Black;border-top: 1px solid Black;\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
									$sqlst = "select count(*) as total from sgm_stock_almacenes_pasillo_estanteria_seccion where id_estanteria=".$rowe["id"]." and visible=1 order by orden";
									$resultst = mysqli_query($dbhandle,convertSQL($sqlst));
									$rowst = mysqli_fetch_array($resultst);
									if ($rowst["total"] == 0) {
										echo "<td style=\"width:100%;background-color: Black;height:25px\">&nbsp;</td>";
									} else {
										$sqls = "select id,porcentage from sgm_stock_almacenes_pasillo_estanteria_seccion where id_estanteria=".$rowe["id"]." and visible=1 order by orden";
										$results = mysqli_query($dbhandle,convertSQL($sqls));
										while ($rows = mysqli_fetch_array($results)) {
											if ($rows["id"] == $rowas["id_seccion"]) {
												echo "<td style=\"background-color: Red;width:".$rows["porcentage"]."%;height:25px;border-right: 1px solid Black;\">&nbsp;</td>";
											} else {
												echo "<td style=\"width:".$rows["porcentage"]."%;height:25px;border-right: 1px solid Black;\">&nbsp;</td>";
											}
										}
									}
									echo "</tr>";
								echo "</table></td></tr>";
							}
						}
						echo "<tr><td></td><td>";
						echo "<table style=\"width:520px;border-left: 1px solid Black;border-top: 1px solid Black;\" cellpadding=\"0\" cellspacing=\"0\">";
							echo "<tr>";
								echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
								echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
								echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
								echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td></tr>";
			echo "</table><br><br><br>";
		}
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 141) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=140&ssop=3&id=".$_GET["id"]."&id_seccion_articulo=".$_GET["id_seccion_articulo"],"op=1004&sop=140&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 145) {
		$sql = "select id,nombre from sgm_stock_almacenes where id=".$_GET["id_almacen"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<h4>".$row["nombre"]."</h4>";
		echo boton(array("op=1004&sop=140&id=".$_GET["id"]),array("&laquo; ".$Volver));
		echo mostrarAlmacen($row["id"],$_GET["id_seccion"]);
	}

	if ($soption == 150) {
		$sql= "select id from sgm_articles where codigo='".$_POST["codigo"]."'";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($ssoption == 1) {
			$sqls= "select pvd,pvp from sgm_stock where id_article=".$row["id"]." and vigente=1";
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			$rows = mysqli_fetch_array($results);
			if ($_GET["id"] != $row["id"]){
				$camposUpdate = "id_escandall,id_article,unitats,pvd_forzat,pvp_forzat";
				if ($rows["pvd"] != 0){ $pvd = $rows["pvd"]; } else { $pvd = 0; }
				if ($rows["pvp"] != 0){ $pvp = $rows["pvp"]; } else { $pvp = 0; }
				$datosInsert = array($_GET["id"],$row["id"],$_POST["unitats"],$pvd,$pvp);
				insertFunction ("sgm_articles_escandall",$camposUpdate,$datosInsert);

				$camposUpdate = array("escandall");
				$datosUpdate = array("1");
				updateFunction ("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
			} else {
				echo mensageError($ErrorEscandallo);
			}
		}
		if ($ssoption == 2) {
			if ($_GET["id"] != $row["id"]){
				$camposUpdate = array("id_article","unitats","pvd_forzat","pvp_forzat");
				$datosUpdate = array($row["id"],$_POST["unitats"],$_POST["pvd_forzat"],$_POST["pvp_forzat"]);
				updateFunction ("sgm_articles_escandall",$_GET["id_escandall"],$camposUpdate,$datosUpdate);
			} else {
				echo mensageError($ErrorEscandallo);
			}
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_articles_escandall",$_GET["id_escandall"],$camposUpdate,$datosUpdate);

			$sqle= "select count(*) as total from sgm_articles where id=".$_GET["id"]." and escandall=1";
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			$rowe = mysqli_fetch_array($resulte);
			if ($rowe["total"]==0){
				$camposUpdate = array("escandall");
				$datosUpdate = array("0");
				updateFunction ("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 5) {
			$camposUpdate = array("recalc_escandall");
			$datosUpdate = array($_POST["recalc"]);
			updateFunction ("sgm_articles",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Escandallo."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td>".$Recalcular." ".$Precio.": </td>";
				$sql = "select recalc_escandall from sgm_articles where id=".$_GET["id"];
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				echo "<form action=\"index.php?op=1004&sop=150&ssop=5&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><select name=\"recalc\" style=\"width:50px\">";
					if ($row["recalc_escandall"] == 0){
						echo "<option value=\"0\" selected>".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
					}
					if ($row["recalc_escandall"] == 1){
						echo "<option value=\"0\">".$No."</option>";
						echo "<option value=\"1\" selected>".$Si."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Codigo."</th>";
				echo "<th>".$Unidades."</th>";
				echo "<th>".$PVD."</th>";
				echo "<th>".$PVP."</th>";
				echo "<th>".$PVD." ".$Forzado."</th>";
				echo "<th>".$PVP." ".$Forzado."</th>";
				echo "<th>".$Precio." ".$Total."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1004&sop=150&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td style=\"width:300px\"></td>";
				echo "<td><input name=\"codigo\" type=\"Text\" style=\"width:70px\"></td>";
				echo "<td><input name=\"unitats\" type=\"Text\" style=\"width:70px\"></td>";
				echo "<td colspan=\"5\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$total=0;
			$sqle= "select * from sgm_articles_escandall where id_escandall=".$_GET["id"]." and visible=1";
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			while ($rowe = mysqli_fetch_array($resulte)){
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1004&sop=151&id_escandall=".$rowe["id"]."&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					$sql= "select id,nombre,codigo from sgm_articles where id=".$rowe["id_article"]."";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1004&sop=100&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
					echo "<form action=\"index.php?op=1004&sop=150&ssop=2&id_escandall=".$rowe["id"]."&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td><input name=\"codigo\" type=\"Text\" value=\"".$row["codigo"]."\" style=\"width:70px;text-align:right;\"></td>";
					echo "<td><input name=\"unitats\" type=\"Text\" value=\"".$rowe["unitats"]."\" style=\"width:70px;text-align:right;\"></td>";
					$sqls= "select pvd,pvp from sgm_stock where id_article=".$row["id"]." and vigente=1";
					$results = mysqli_query($dbhandle,convertSQL($sqls));
					$rows = mysqli_fetch_array($results);
					echo "<td style=\"text-align:right;width:70px;\">".$rows["pvd"]."</td>";
					echo "<td style=\"text-align:right;width:70px;\">".$rows["pvp"]."</td>";
					echo "<td><input name=\"pvd_forzat\" type=\"Text\" value=\"".$rowe["pvd_forzat"]."\" style=\"width:70px;text-align:right;\"></td>";
					echo "<td><input name=\"pvp_forzat\" type=\"Text\" value=\"".$rowe["pvp_forzat"]."\" style=\"width:70px;text-align:right;\"></td>";
					$_total=$rowe["unitats"]*$rowe["pvp_forzat"];
					echo "<td style=\"text-align:right;width:70px;\">".number_format($_total, 3, '.', ',')."</td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					$total=$total+$_total;
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td colspan=\"7\"></td>";
				echo "<td style=\"text-align:center;\"><strong>".$Total."</strong></td>";
				echo "<td style=\"text-align:right;\">".number_format($total, 3, '.', ',')."</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 151) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=150&ssop=3&id=".$_GET["id"]."&id_escandall=".$_GET["id_escandall"],"op=1004&sop=150&id=".$_GET["id"]."&id_escandall=".$_GET["id_escandall"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 300) {
		echo "<h4>".$Impresion."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td>";
					echo "<table cellspacing=\"0\">";
						echo "<tr style=\"background-color:silver;\">";
							echo "<th>".$Familias."</th>";
						echo "</tr><tr>";
							echo "<form method=\"post\" action=\"".$urloriginal."/mgestion/gestion-articulos-lista-print-pdf.php?\"	target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
							echo "<td><select name=\"subfamilia\" style=\"width:150px\">";
								echo "<option value=\"0\">".$Todas."</option>";
								$sqli = "select id,grupo from sgm_articles_grupos";
								$resulti = mysqli_query($dbhandle,convertSQL($sqli));
								while ($rowi = mysqli_fetch_array($resulti)) {
									$sqls = "select id,subgrupo from sgm_articles_subgrupos where id_grupo=".$rowi["id"];
									$results = mysqli_query($dbhandle,convertSQL($sqls));
									while ($rows = mysqli_fetch_array($results)) {
										echo "<option value=\"".$rows["id"]."\">".$rowi["grupo"]."-".$rows["subgrupo"]."</option>";
									}
								}
							echo "</select></td>";
							echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 500){
		if ($admin == true) {
			echo boton(array("op=1004&sop=510","op=1004&sop=520","op=1004&sop=530"),array($Familias,$Caracteristicas,$Almacenes));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1){
			$camposUpdate = "grupo,codigo";
			$datosInsert = array($_POST["grupo"],$_POST["codigo"]);
			insertFunction ("sgm_articles_grupos",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 2){
			$sqlg = "select id from sgm_articles_grupos order by codigo";
			$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
			while ($rowg = mysqli_fetch_array($resultg)) {
				#actualizar familia
				$camposUpdate = array("grupo","codigo");
				$datosUpdate = array($_POST["fgrupo".$rowg["id"]],$_POST["fcodigo".$rowg["id"]]);
				updateFunction ("sgm_articles_grupos",$rowg["id"],$camposUpdate,$datosUpdate);
				#actualizar todas las sufamilias
				$sqls = "select id from sgm_articles_subgrupos where id_grupo=".$rowg["id"]." order by codigo";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				while ($rows = mysqli_fetch_array($results)) {
					$camposUpdate = array("subgrupo","codigo","id_grupo");
					$datosUpdate = array($_POST["sfsubgrupo".$rows["id"]],$_POST["sfcodigo".$rows["id"]],$_POST["sfid_grupo".$rows["id"]]);
					updateFunction ("sgm_articles_subgrupos",$rows["id"],$camposUpdate,$datosUpdate);
				}
			}
		}
		if ($ssoption == 3){
			$camposUpdate = "subgrupo,codigo,id_grupo";
			$datosInsert = array($_POST["subgrupo"],$_POST["codigo"],$_POST["id_grupo"]);
			insertFunction ("sgm_articles_subgrupos",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 4) {
			### Pone a 0 el valor de todos articulos de las subfamilias afectadas
			$sqls = "select id from sgm_articles_subgrupos where id_grupo=".$_GET["id"];
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			while ($rows = mysqli_fetch_array($results)) {
				$sql = "update sgm_articles set ";
				$sql = $sql."id_subgrupo=0";
				$sql = $sql." WHERE id_subgrupo=".$rows["id"]."";
				mysqli_query($dbhandle,convertSQL($sql));
			}
			#### Elimina las subfamilias
			$sql = "delete from sgm_articles_subgrupos WHERE id_grupo=".$_GET["id"];
			mysqli_query($dbhandle,convertSQL($sql));
			#### ELimina las familias
			$sql = "delete from sgm_articles_grupos WHERE id=".$_GET["id"];
			mysqli_query($dbhandle,convertSQL($sql));
		}
		if ($ssoption == 5) {
			### Pone a 0 el valor de todos articulos de las subfamilias afectadas
			$sql = "update sgm_articles set ";
			$sql = $sql."id_subgrupo=0";
			$sql = $sql." WHERE id_subgrupo=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			#### Elimina las subfamilias
			$sql = "delete from sgm_articles_subgrupos WHERE id=".$_GET["id"];
			mysqli_query($dbhandle,convertSQL($sql));
		}

		echo "<h4>".$Familias." / ".$Subfamilias." : </h4>";
		echo boton(array("op=1004&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<caption>".$Anadir." ".$Familias."/".$Subfamilias."</caption>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Codigo."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<form action=\"index.php?op=1004&sop=510&ssop=1\" method=\"post\">";
				echo "<th></th>";
				echo "<th><input type=\"Text\" name=\"codigo\" style=\"width:50px\" maxlength=\"5\"></th>";
				echo "<th><input type=\"Text\" name=\"grupo\" style=\"width:150px\" maxlength=\"30\"></th>";
				echo "<th class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir." ".$Familias."\"></th>";
				echo "</form>";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<form action=\"index.php?op=1004&sop=510&ssop=3\" method=\"post\">";
				echo "<th><select name=\"id_grupo\" style=\"width:150px\">";
					$sqlg = "select id,grupo from sgm_articles_grupos order by grupo";
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)) {
						echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
					}
				echo "</select></th>";
				echo "<th><input type=\"Text\" name=\"codigo\" style=\"width:50px\" maxlength=\"5\"></th>";
				echo "<th><input type=\"Text\" name=\"subgrupo\" style=\"width:150px\" maxlength=\"30\"></th>";
				echo "<th class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir." ".$Subfamilias."\"></th>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<caption>".$Listado." ".$Familias."</caption>";
			echo "<form action=\"index.php?op=1004&sop=510&ssop=2\" method=\"post\">";
			echo "<tr><td colspan=\"8\" style=\"text-align:center;\" class=\"Submit\"><input type=\"Submit\" value=\"".$Guardar."\"></td></tr>";
			$sql = "select id,codigo,grupo from sgm_articles_grupos order by codigo";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr style=\"background-color:silver;border:1px solid Silver;\">";
					echo "<td style=\"vertical-align:top\"><a href=\"index.php?op=1004&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td style=\"vertical-align:top\"><input type=\"Text\" name=\"fcodigo".$row["id"]."\" style=\"width:25px\" maxlength=\"5\" value=\"".$row["codigo"]."\"></td>";
					echo "<td style=\"vertical-align:top\"><input type=\"Text\" name=\"fgrupo".$row["id"]."\" style=\"width:150px\" maxlength=\"30\" value=\"".$row["grupo"]."\"></td>";
					echo "<td></td>";
					echo "<th>".$Familia."</th>";
					echo "<th>".$Codigo."</th>";
					echo "<th>".$Subfamilia."</th>";
				echo "</tr>";
				$sqls = "select id,codigo,subgrupo,id_grupo from sgm_articles_subgrupos where id_grupo=".$row["id"]." order by codigo";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				while ($rows = mysqli_fetch_array($results)) {
					echo "<tr>";
						echo "<td colspan=\"3\"></td>";
						echo "<td><a href=\"index.php?op=1004&sop=512&id=".$rows["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
						echo "<td><select name=\"sfid_grupo".$rows["id"]."\" style=\"width:150px\">";
							$sqlg = "select id,grupo from sgm_articles_grupos order by grupo";
							$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
							while ($rowg = mysqli_fetch_array($resultg)) {
								if ($rows["id_grupo"] == $rowg["id"]) {
									echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["grupo"]."</option>";
								} else {
									echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
								}
							}
						echo "</select></td>";
						echo "<td><input type=\"Text\" name=\"sfcodigo".$rows["id"]."\" style=\"width:50px\" maxlength=\"5\" value=\"".$rows["codigo"]."\"></td>";
						echo "<td><input type=\"Text\" name=\"sfsubgrupo".$rows["id"]."\" style=\"width:150px\" maxlength=\"30\" value=\"".$rows["subgrupo"]."\"></td>";
						echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
							echo "<a href=\"index.php?op=1004&sop=515&id=".$rows["id"]."\" style=\"color:white;\">".$Caracteristicas."</a>";
						echo "</td>";
					echo "</tr>";
				}
			}
			echo "<tr><td colspan=\"8\" style=\"text-align:center;\" class=\"Submit\"><input type=\"Submit\" value=\"".$Guardar."\"></td></tr>";
			echo "</form>";
		echo "</table>";
	}

	if (($soption == 511) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=510&ssop=4&id=".$_GET["id"],"op=1004&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 512) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=510&ssop=5&id=".$_GET["id"],"op=1004&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 515) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "id_subgrupo,id_caracteristica";
			$datosInsert = array($_GET["id"],$_POST["id_caracteristica"]);
			insertFunction ("sgm_articles_subgrupos_caracteristicas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$sql = "delete from sgm_articles_subgrupos_caracteristicas WHERE id_subgrupo=".$_GET["id"]." and id_caracteristica=".$_GET["id_car"]."";
			mysqli_query($dbhandle,convertSQL($sql));
		}

		echo "<h4>".$Caracteristicas." : </h4>";
		echo boton(array("op=1004&sop=510"),array("&laquo; ".$Volver));
		echo "<table cellspacing=\"0\ style=\"width:300px;\" class=\"lista\">";
			echo "<caption>".$Anadir." ".$Caracteristicas."</caption>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th style=\"width:30px\"></th>";
				echo "<th>".$Caracteristica."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1004&sop=515&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_caracteristica\" style=\"width:150px\">";
					$sqlg = "select id,nombre from sgm_articles_caracteristicas where visible=1 order by nombre";
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)) {
						echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select id_caracteristica from sgm_articles_subgrupos_caracteristicas where id_subgrupo=".$_GET["id"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqls = "select id,nombre from sgm_articles_caracteristicas where id=".$row["id_caracteristica"]." order by nombre";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				while ($rows = mysqli_fetch_array($results)) {
					echo "<tr>";
						echo "<td><a href=\"index.php?op=1004&sop=516&id=".$_GET["id"]."&id_car=".$rows["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
						echo "<td>".$rows["nombre"]."</td>";
					echo "<td></td>";
					echo "</tr>";
				}
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 516) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=515&ssop=2&id=".$_GET["id"]."&id_car=".$_GET["id_car"],"op=1004&sop=515"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,unidad,unidad_abr,valor,id_caracteristica";
			$datosInsert = array($_POST["nombre"],$_POST["unidad"],$_POST["unidad_abr"],$_POST["valor"],$_POST["id_caracteristica"]);
			insertFunction ("sgm_articles_caracteristicas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("nombre","unidad","unidad_abr","valor","id_caracteristica");
			$datosUpdate = array($_POST["nombre"],$_POST["unidad"],$_POST["unidad_abr"],$_POST["valor"],$_POST["id_caracteristica"]);
			updateFunction ("sgm_articles_caracteristicas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_articles_caracteristicas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Caracteristicas." : </h4>";
		echo boton(array("op=1004&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color: Silver;\">";
			echo "<th></th>";
			echo "<th>".$Dependencia."</th>";
			echo "<th>".$Nombre."</th>";
			echo "<th>".$Unidad."</th>";
			echo "<th>".$Abreviatura."</th>";
			echo "<th>".$Valor." ".$por_defecto."*</th>";
			echo "<th></th>";
		echo "</tr>";
		echo "<tr>";
			echo "<td></td>";
			echo "<form action=\"index.php?op=1004&sop=520&ssop=1\" method=\"post\">";
			echo "<td><select name=\"id_caracteristica\">";
				echo "<option value=\"0\">".$Sin_dependencias."</option>";
				$sqlg = "select id,nombre from sgm_articles_caracteristicas where id_caracteristica=0 and visible=1 order by nombre";
				$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
				while ($rowg = mysqli_fetch_array($resultg)) {
					echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre"]."</option>";
				}
			echo "</select></td>";
			echo "<td><input type=\"text\" name=\"nombre\" value=\"".$row["nombre"]."\"></td>";
			echo "<td><input type=\"text\" name=\"unidad\" value=\"".$row["unidad"]."\"></td>";
			echo "<td><input type=\"text\" name=\"unidad_abr\" value=\"".$row["unidad_abr"]."\"></td>";
			echo "<td><input type=\"text\" name=\"valor\" value=\"".$row["valor"]."\"></td>";
			echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_articles_caracteristicas where id_caracteristica=0 and visible=1 order by nombre";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr>";
				echo "<td><a href=\"index.php?op=1004&sop=131&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=1004&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><select name=\"id_caracteristica\">";
					echo "<option value=\"0\">".$Sin_dependencias."</option>";
					$sqlg = "select id,nombre from sgm_articles_caracteristicas where id_caracteristica=0 and visible=1 and id<>".$row["id"]." order by nombre";
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)) {
						if ($rows["id_caracteristica"] == $rowg["id"]) {
							echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["nombre"]."</option>";
						} else {
							echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><input type=\"text\" name=\"nombre\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"text\" name=\"unidad\" value=\"".$row["unidad"]."\"></td>";
				echo "<td><input type=\"text\" name=\"unidad_abr\" value=\"".$row["unidad_abr"]."\"></td>";
				echo "<td><input type=\"text\" name=\"valor\" value=\"".$row["valor"]."\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				if ($row["valor"] == "") {
					$sqlg = "select count(*) as total from sgm_articles_caracteristicas_tablas where id_caracteristica=".$row["id"]." and visible=1";
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					$rowg = mysqli_fetch_array($resultg);
					if ($rowg["total"] == 0) {
							echo "<td style=\"width:100px;height:5px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1004&sop=522&id_caracteristica=".$row["id"]."\" style=\"color:white;\">".$Crear." ".$Tabla."</a>";
							echo "</td>";
					}
					if ($rowg["total"] > 0) {
							echo "<td style=\"width:100px;height:5px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1004&sop=522&id_caracteristica=".$row["id"]."\" style=\"color:white;\">".$Editar." ".$Tabla."</a>";
							echo "</td>";
					}
				}
			echo "</tr>";
			##### recorrido de todas las caracteristicas secundarias
			$sql1 = "select * from sgm_articles_caracteristicas where id_caracteristica=".$row["id"]." and visible=1 order by nombre";
			$result1 = mysqli_query($dbhandle,convertSQL($sql1));
			while ($row1 = mysqli_fetch_array($result1)) {
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1004&sop=521&id=".$row1["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1004&sop=520&ssop=2&id=".$row1["id"]."\" method=\"post\">";
					echo "<td><select name=\"id_caracteristica\">";
						echo "<option value=\"0\">".$Sin_dependencias."</option>";
						$sqlg = "select id,nombre from sgm_articles_caracteristicas where id_caracteristica=0 and visible=1 order by nombre";
						$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
						while ($rowg = mysqli_fetch_array($resultg)) {
							if ($row1["id_caracteristica"] == $rowg["id"]) {
								echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"nombre\" value=\"".$row1["nombre"]."\"></td>";
					echo "<td><input type=\"text\" name=\"unidad\" value=\"".$row1["unidad"]."\"></td>";
					echo "<td><input type=\"text\" name=\"unidad_abr\" value=\"".$row1["unidad_abr"]."\"></td>";
					echo "<td><input type=\"text\" name=\"valor\" value=\"".$row1["valor"]."\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					if ($row1["valor"] == "") {
						$sqlg = "select count(*) as total from sgm_articles_caracteristicas_tablas where id_caracteristica=".$row1["id"]." and visible=1";
						$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
						$rowg = mysqli_fetch_array($resultg);
						if ($rowg["total"] == 0) {
							echo "<td style=\"width:100px;height:5px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1004&sop=522&id_caracteristica=".$row1["id"]."\" style=\"color:white;\">".$Crear." ".$Tabla."</a>";
							echo "</td>";
						}
						if ($rowg["total"] > 0) {
							echo "<td style=\"width:100px;height:5px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
								echo "<a href=\"index.php?op=1004&sop=522&id_caracteristica=".$row1["id"]."\" style=\"color:white;\">".$Editar." ".$Tabla."</a>";
							echo "</td>";
						}
					}
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "<br>* ".$ValorDefectoCaracteristicaArt;
	}

	if (($soption == 521) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=520&ssop=3&id=".$_GET["id"],"op=1004&sop=520"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 522) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposUpdate = "valor,id_caracteristica";
			$datosInsert = array($_POST["valor"],$_GET["id_caracteristica"]);
			insertFunction ("sgm_articles_caracteristicas_tablas",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("valor");
			$datosUpdate = array($_POST["valor"]);
			updateFunction ("sgm_articles_caracteristicas_tablas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_articles_caracteristicas_tablas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Editar." ".$Tabla."</h4>";
		echo boton(array("op=1004&sop=520"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Valor."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1004&sop=522&ssop=1&id_caracteristica=".$_GET["id_caracteristica"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"valor\" style=\"width:150px\"></td>";
				echo "<td class=\"Submit\">&nbsp;<input type=\"submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql1 = "select id,valor from sgm_articles_caracteristicas_tablas where id_caracteristica=".$_GET["id_caracteristica"]." and visible=1 order by valor";
			$result1 = mysqli_query($dbhandle,convertSQL($sql1));
			while ($row1 = mysqli_fetch_array($result1)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1004&sop=522&ssop=2&id=".$row1["id"]."&id_caracteristica=".$_GET["id_caracteristica"]."\" method=\"post\">";
					echo "<td><a href=\"index.php?op=1004&sop=523&id=".$row1["id"]."&id_caracteristica=".$_GET["id_caracteristica"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td><input type=\"Text\" name=\"valor\" value=\"".$row1["valor"]."\" style=\"width:150px\"></td>";
					echo "<td class=\"Submit\">&nbsp;<input type=\"submit\" value=\"".$Cambiar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 523) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=522&ssop=3&id=".$_GET["id"]."&id_caracteristica=".$_GET["id_caracteristica"],"op=1004&sop=522&id_caracteristica=".$_GET["id_caracteristica"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 530) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,direccion,poblacion,cp,provincia,mail,telefono,notas";
			$datosInsert = array($_POST["nombre"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["mail"],$_POST["telefono"],$_POST["notas"]);
			insertFunction ("sgm_stock_almacenes",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("nombre","direccion","poblacion","cp","provincia","mail","telefono","notas");
			$datosUpdate = array($_POST["nombre"],$_POST["direccion"],$_POST["poblacion"],$_POST["cp"],$_POST["provincia"],$_POST["mail"],$_POST["telefono"],$_POST["notas"]);
			updateFunction ("sgm_stock_almacenes",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_stock_almacenes",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Gestion." ".$Almacenes."</h4>";
		echo boton(array("op=1004&sop=500"),array("&laquo; ".$Volver));
		echo boton(array("op=1004&sop=530&id=0"),array($Anadir." ".$Almacen));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" width=\"80%\">";
			echo "<tr><td style=\"width:47%;vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
					echo "<tr style=\"background-color: Silver;\">";
						echo "<th></th>";
						echo "<th>".$Almacen."</th>";
						echo "<th>".$Poblacion."</th>";
						echo "<th>".$Telefono."</th>";
						echo "<th>".$Editar."</th>";
					echo "</tr>";
					$sql = "select id,nombre,poblacion,telefono from sgm_stock_almacenes where visible=1 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
						echo "<td><a href=\"index.php?op=1004&sop=531&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
						echo "<td style=\"width:45%;\">".$row["nombre"]."</td>";
						echo "<td>".$row["poblacion"]."</td>";
						echo "<td>".$row["telefono"]."</td>";
						echo "<td><a href=\"index.php?op=1004&sop=530&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" border=\"0\"></a></td>";
						echo "<td>";
							echo boton(array("op=1004&sop=532&id=".$row["id"],"op=1004&sop=539&id=".$row["id"]),array($Configurar,$Esquema));
						echo "</td>";
					echo "</tr>";
					}
				echo "</table>";
			echo "</td>";
			echo "<td style=\"width:6%\">&nbsp;</td>";
			echo "<td style=\"width:47%;vertical-align:top;\">";
				echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				if ($_GET["id"] == 0) {
					echo "<caption>".$Anadir." ".$Nuevo." ".$Almacen."</caption>";
				} else {
					echo "<caption>".$Modificar." ".$Almacen."</caption>";
				}
					$sql = "select * from sgm_stock_almacenes where visible=1 and id=".$_GET["id"];
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					if ($_GET["id"] == 0) {
						echo "<form action=\"index.php?op=1004&sop=530&ssop=1\" method=\"post\">";
					} else {
						echo "<form action=\"index.php?op=1004&sop=530&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
					}
					echo "<tr><td>".$Nombre."</td><td><input type=\"Text\" name=\"nombre\" style=\"width:400px\" value=\"".$row["nombre"]."\"></td></tr>";
					echo "<tr><td>".$Direccion."</td><td><input type=\"Text\" name=\"direccion\" style=\"width:400px\" value=\"".$row["direccion"]."\"></td></tr>";
					echo "<tr><td>".$Poblacion."</td><td><input type=\"Text\" name=\"poblacion\" style=\"width:400px\" value=\"".$row["poblacion"]."\"></td></tr>";
					echo "<tr><td>".$Codigo." ".$Postal."</td><td><input type=\"Text\" name=\"cp\" style=\"width:400px\" value=\"".$row["cp"]."\"></td></tr>";
					echo "<tr><td>".$Provincia."</td><td><input type=\"Text\" name=\"provincia\" style=\"width:400px\" value=\"".$row["provincia"]."\"></td></tr>";
					echo "<tr><td>".$Email."</td><td><input type=\"Text\" name=\"mail\" style=\"width:400px\" value=\"".$row["mail"]."\"></td></tr>";
					echo "<tr><td>".$Telefono."</td><td><input type=\"Text\" name=\"telefono\" style=\"width:400px\" value=\"".$row["telefono"]."\"></td></tr>";
					echo "<tr><td>".$Notas."</td><td><textarea name=\"notas\" style=\"width:400px\" rows=\"3\">".$row["notas"]."</textarea></td></tr>";
					if ($_GET["id"] == 0) {
						echo "<tr><td></td><td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td></tr>";
					} else {
						echo "<tr><td></td><td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td></tr>";
					}
					echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr></table>";
	}

	if (($soption == 531) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=530&ssop=3&id=".$_GET["id"],"op=1004&sop=530"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 532) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposUpdate = "nombre,orden,id_almacen";
			$datosInsert = array($_POST["nombre"],$_POST["orden"],$_GET["id"]);
			insertFunction ("sgm_stock_almacenes_pasillo",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("nombre","orden");
			$datosUpdate = array($_POST["nombre"],$_POST["orden"]);
			updateFunction ("sgm_stock_almacenes_pasillo",$_GET["id_pasillo"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_stock_almacenes_pasillo",$_GET["id_pasillo"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 10) {
			$camposUpdate = "nombre,orden,id_pasillo";
			$datosInsert = array($_POST["nombre"],$_POST["orden"],$_GET["id_pasillo"]);
			insertFunction ("sgm_stock_almacenes_pasillo_estanteria",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 20) {
			$camposUpdate = array("nombre","orden");
			$datosUpdate = array($_POST["nombre"],$_POST["orden"]);
			updateFunction ("sgm_stock_almacenes_pasillo_estanteria",$_GET["id_estanteria"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 30) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_stock_almacenes_pasillo_estanteria",$_GET["id_estanteria"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 100) {
			$camposUpdate = "nombre,orden,id_estanteria,porcentage";
			$datosInsert = array($_POST["nombre"],$_POST["orden"],$_GET["id_estanteria"],$_POST["porcentage"]);
			insertFunction ("sgm_stock_almacenes_pasillo_estanteria_seccion",$camposUpdate,$datosInsert);
		}
		if ($ssoption == 200) {
			$camposUpdate = array("nombre","orden","porcentage");
			$datosUpdate = array($_POST["nombre"],$_POST["orden"],$_POST["porcentage"]);
			updateFunction ("sgm_stock_almacenes_pasillo_estanteria_seccion",$_GET["id_seccion"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 300) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_stock_almacenes_pasillo_estanteria_seccion",$_GET["id_seccion"],$camposUpdate,$datosUpdate);
		}

		$sqla = "select nombre from sgm_stock_almacenes where id=".$_GET["id"];
		$resulta = mysqli_query($dbhandle,convertSQL($sqla));
		$rowa = mysqli_fetch_array($resulta);
		echo "<h4>".$Almacenes." : ".$rowa["nombre"]."</h4>";
		echo boton(array("op=1004&sop=530"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Orden."</th>";
				echo "<th colspan=\"2\">".$Nombre." ".$Pasillo."</th>";
				echo "<th colspan=\"2\"></th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1004&sop=532&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"orden\" style=\"width:40px\" value=\"0\"></td>";
				echo "<td colspan=\"2\"><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
				echo "<td colspan=\"2\" class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select id,nombre,orden from sgm_stock_almacenes_pasillo where visible=1 and id_almacen=".$_GET["id"]." order by orden";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1004&sop=533&id=".$_GET["id"]."&id_pasillo=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1004&sop=532&ssop=2&id=".$_GET["id"]."&id_pasillo=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"orden\" style=\"width:40px\" value=\"".$row["orden"]."\"></td>";
					echo "<td colspan=\"2\"><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$row["nombre"]."\"></td>";
					echo "<td colspan=\"2\" class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";
				echo "<tr style=\"background-color: Silver;\">";
					echo "<th style=\"background-color:white;\"></th>";
					echo "<th style=\"background-color:white;\"></th>";
					echo "<th style=\"text-align:right;\" colspan=\"2\">".$Orden."</th>";
					echo "<th colspan=\"2\">".$Nombre."  ".$Estanteria."</th>";
					echo "<th></th>";
					echo "<th></th>";
					echo "<th></th>";
				echo "</tr>";
				echo "<tr>";
					echo "<form action=\"index.php?op=1004&sop=532&ssop=10&id=".$_GET["id"]."&id_pasillo=".$row["id"]."\" method=\"post\">";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td style=\"text-align:right;\" colspan=\"2\"><input type=\"Text\" name=\"orden\" style=\"width:40px\" value=\"0\"></td>";
					echo "<td colspan=\"2\"><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</form>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				$sqlpe = "select id,nombre,orden from sgm_stock_almacenes_pasillo_estanteria where visible=1 and id_pasillo=".$row["id"]." order by orden";
				$resultpe = mysqli_query($dbhandle,convertSQL($sqlpe));
				while ($rowpe = mysqli_fetch_array($resultpe)) {
					echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1004&sop=534&id=".$_GET["id"]."&id_estanteria=".$rowpe["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
						echo "<form action=\"index.php?op=1004&sop=532&ssop=20&id=".$_GET["id"]."&id_estanteria=".$rowpe["id"]."\" method=\"post\">";
						echo "<td style=\"text-align:right;width:40px\"><input type=\"Text\" name=\"orden\" style=\"width:40px\" value=\"".$rowpe["orden"]."\"></td>";
						echo "<td colspan=\"2\"><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$rowpe["nombre"]."\"></td>";
						echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
						echo "</form>";
						echo "<td></td>";
						echo "<td></td>";
					echo "</tr>";
					echo "<tr style=\"background-color: Silver;\">";
						echo "<th style=\"background-color:white;\"></th>";
						echo "<th style=\"background-color:white;\"></th>";
						echo "<th style=\"background-color:white;\"></th>";
						echo "<th style=\"background-color:white;\"></th>";
						echo "<th style=\"text-align:right;\" colspan=\"2\">".$Orden."</th>";
						echo "<th>".$Nombre."  ".$Seccion."</th>";
						echo "<th>(%)</th>";
						echo "<th></th>";
					echo "</tr>";
					echo "<tr>";
						echo "<form action=\"index.php?op=1004&sop=532&ssop=100&id=".$_GET["id"]."&id_estanteria=".$rowpe["id"]."\" method=\"post\">";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td style=\"text-align:right;\" colspan=\"2\"><input type=\"Text\" name=\"orden\" style=\"width:40px\" value=\"0\"></td>";
						echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\"></td>";
						echo "<td><input type=\"Text\" name=\"porcentage\" style=\"width:100px\" value=\"0\"></td>";
						echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
						echo "</form>";
					echo "</tr>";
					echo "<tr><td>&nbsp;</td></tr>";
					$sqlpes = "select id,nombre,orden,porcentage from sgm_stock_almacenes_pasillo_estanteria_seccion where visible=1 and id_estanteria=".$rowpe["id"]." order by orden";
					$resultpes = mysqli_query($dbhandle,convertSQL($sqlpes));
					while ($rowpes = mysqli_fetch_array($resultpes)) {
						echo "<tr>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td style=\"text-align:right;\"><a href=\"index.php?op=1004&sop=535&id=".$_GET["id"]."&id_seccion=".$rowpes["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
							echo "<form action=\"index.php?op=1004&sop=532&ssop=200&id=".$_GET["id"]."&id_seccion=".$rowpes["id"]."\" method=\"post\">";
							echo "<td style=\"text-align:right;width:40px\"><input type=\"Text\" name=\"orden\" style=\"width:40px\" value=\"".$rowpes["orden"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:150px\" value=\"".$rowpes["nombre"]."\"></td>";
							echo "<td><input type=\"Text\" name=\"porcentage\" style=\"width:100px\" value=\"".$rowpes["porcentage"]."\"></td>";
							echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
							echo "</form>";
						echo "</tr>";
					}
					echo "<tr><td>&nbsp;</td></tr>";
				}
				echo "<tr><td>&nbsp;</td></tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
		echo "</table>";
	}

	if (($soption == 533) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=532&ssop=3&id=".$_GET["id"]."&id_pasillo=".$_GET["id_pasillo"],"op=1004&sop=532&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 534) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=532&ssop=30&id=".$_GET["id"]."&id_estanteria=".$_GET["id_estanteria"],"op=1004&sop=532&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 535) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1004&sop=532&ssop=300&id=".$_GET["id"]."&id_seccion=".$_GET["id_seccion"],"op=1004&sop=532&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}
	
	if ($soption == 539) {
		$sql = "select id,nombre from sgm_stock_almacenes where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<h4>".$row["nombre"]."</h4>";
		echo boton(array("op=1004&sop=530"),array("&laquo; ".$Volver));
		echo mostrarAlmacen($row["id"],0);
	}

/*
	if ($soption == 400) {
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td valign=\"top\"><strong>".$Familias."</strong>";
			echo "<table style=\"width:150px\">";
			echo "<tr><td><a href=\"index.php?op=1004&sop=400&descatalogat=1\" class=\"style2\">".$Descatalogados."</a></td></tr>";
			echo "<tr><td><a href=\"index.php?op=1004&sop=400&idgrupo=0&idsubgrupo=0&descatalogat=0\" class=\"style2\">".$Sin." ".$Clasificar."</a></td></tr>";
			$sql = "select * from sgm_articles_grupos order by grupo";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
					if ($_GET['idgrupo'] == $row["id"]) { echo "<tr><td style=\"background-color:#32599E;color:White;\"><a href=\"index.php?op=1004&sop=400&idgrupo=".$row["id"]."\" class=\"style2\" style=\"color:White;\">".$row["grupo"]." (".$total.")</a></td></tr>"; }
					else { echo "<tr><td><a href=\"index.php?op=1004&sop=400&idgrupo=".$row["id"]."\" class=\"style2\">".$row["grupo"]."</a></td></tr>"; }
			}
			echo "</table>";
		echo "</td><td valign=\"top\"><strong>".$Subfamilias."</strong>";
			echo "<table style=\"width:200px\">";
			$sqlg = "select * from sgm_articles_subgrupos where id_grupo=".$_GET['idgrupo']." order by subgrupo";
			$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
			while ($rowg = mysqli_fetch_array($resultg)) {
					if ($_GET['idsubgrupo'] == $rowg["id"]) { echo "<tr><td style=\"background-color:#32599E;color:White;\"><a href=\"index.php?op=1004&sop=400&idgrupo=".$_GET['idgrupo']."&idsubgrupo=".$rowg["id"]."\" class=\"style2\" style=\"color:White;\">".$rowg["subgrupo"]." (".$rowt["total"].")</a></td></tr>";	}
					else { echo "<tr><td><a href=\"index.php?op=1004&sop=400&idgrupo=".$_GET['idgrupo']."&idsubgrupo=".$rowg["id"]."\" class=\"style2\">".$rowg["subgrupo"]."</a></td></tr>"; }
			}
			echo "</table>";
		echo "</td><td>&nbsp;</td><td style=\"text-align:center;vertical-align:top;witdh:300px\"><strong>".$Articulos."</strong>";
			if (($_GET['idsubgrupo'] != "") and ($_GET["id"] == "")) {
				$sqlt = "select count(*) as total from sgm_articles where visible=1 and descatalogat=0 and id_subgrupo=".$_GET["idsubgrupo"];
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				if ($rowt["total"] <> 0) {
					$x = 0;
					$sql = "select * from sgm_articles where visible=1 and id_subgrupo=".$_GET["idsubgrupo"]." and descatalogat=0 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						if ($x == 0) { echo "<tr style=\"background-color : #D8D8D8;\">"; }
						if ($x == 1) { echo "<tr>"; }
							echo "<td style=\"text-align:left; width:100px\">".$row["codigo"]."</td>"; 
							echo "<td style=\"text-align:left; width:300px\" class=\"style2\"><a href=\"index.php?op=1004&sop=26&id=".$row["id"]."\" class=\"style2\">".$row["nombre"]."</a></td>";
							echo "<td style=\"text-align:right; width:100px\" class=\"style2\">".number_format($row["pvp"], 2, ',', '.')."€</td>";
						echo "</tr>";
						if ($x == 0) { $x = 1; } else { $x = 0; }
					}
				}
				echo "</table>";
			}
			if ($_GET['descatalogat'] != "") {
				$sqlt = "select count(*) as total from sgm_articles where visible=1 and descatalogat=1";
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				echo "<table cellpadding=\"0\" cellspacing=\"0\">";
				if ($rowt["total"] <> 0) {
					$x = 0;
					$sql = "select * from sgm_articles where visible=1 and descatalogat=1 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						if ($x == 0) { echo "<tr style=\"background-color : #D8D8D8;\">"; }
						if ($x == 1) { echo "<tr>"; }
							echo "<td>".$row["codigo"]."</td>"; 
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1004&sop=26&id=".$row["id"]."\" class=\"style2\">[+]&nbsp;</a></td>";
							echo "<td style=\"text-align:left; width:275px\" class=\"style2\">".$row["nombre"]."</td>";
						$sqlpvp = "select * from sgm_cuerpo where codigo=".$row["codigo"]." and vigente=1";
						$resultpvp = mysqli_query($dbhandle,convertSQL($sqlpvp));
						$rowpvp = mysqli_fetch_array($resultpvp);
							echo "<td style=\"text-align:right; width:75px\" class=\"style2\">".number_format($row["pvp"], 2, ',', '.')."€</td>";
						echo "</tr>";
						if ($x == 0) { $x = 1; } else { $x = 0; }
					}
				}
				echo "</table>";
			}
		echo "</td></tr></table>";
	}
*/

	echo "</td></tr></table><br>";
}

function mostrarAlmacen($id_almacen,$id_seccion)
{
	global $db,$dbhandle,$Pasillo,$Sin,$Estanterias;

	$sqlp = "select id,nombre from sgm_stock_almacenes_pasillo where id_almacen=".$id_almacen." and visible=1 order by orden";
	$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
	while ($rowp = mysqli_fetch_array($resultp)) {
		echo $Pasillo." : <strong>".$rowp["nombre"]."</strong><br><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
		$sqlet = "select count(*) as total from sgm_stock_almacenes_pasillo_estanteria where id_pasillo=".$rowp["id"]." and visible=1 order by orden";
		$resultet = mysqli_query($dbhandle,convertSQL($sqlet));
		$rowet = mysqli_fetch_array($resultet);
		if ($rowet["total"] == 0) {
			echo "<tr><td style=\"width:100px;text-align:right;vertical-align:top;\">".$Sin." ".$Estanterias."&nbsp;&nbsp;</td><td><table style=\"width:700px;height:50px;background-color: Black;\"><tr>";
				echo "<td style=\"width:100%;\">&nbsp;</td>";
			echo "</tr></table></td></tr>";
		} else {
			$sqle = "select id,nombre from sgm_stock_almacenes_pasillo_estanteria where id_pasillo=".$rowp["id"]." and visible=1 order by orden";
			$resulte = mysqli_query($dbhandle,convertSQL($sqle));
			while ($rowe = mysqli_fetch_array($resulte)) {
				echo "<tr><td style=\"width:100px;text-align:right;vertical-align:top;\">".$rowe["nombre"]."&nbsp;&nbsp;</td><td><table style=\"width:700px;border-left: 1px solid Black;border-top: 1px solid Black;\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
				$sqlst = "select count(*) as total from sgm_stock_almacenes_pasillo_estanteria_seccion where id_estanteria=".$rowe["id"]." and visible=1 order by orden";
				$resultst = mysqli_query($dbhandle,convertSQL($sqlst));
				$rowst = mysqli_fetch_array($resultst);
				if ($rowst["total"] == 0) {
					echo "<td style=\"width:100%;background-color: Black;height:25px\">&nbsp;</td>";
				} else {
					$sqls = "select id,porcentage from sgm_stock_almacenes_pasillo_estanteria_seccion where id_estanteria=".$rowe["id"]." and visible=1 order by orden";
					$results = mysqli_query($dbhandle,convertSQL($sqls));
					while ($rows = mysqli_fetch_array($results)) {
						if ($rows["id"] == $id_seccion) {
							echo "<td style=\"background-color: Red;width:".$rows["porcentage"]."%;height:25px;border-right: 1px solid Black;\">&nbsp;</td>";
						} else {
							echo "<td style=\"width:".$rows["porcentage"]."%;height:25px;border-right: 1px solid Black;\">&nbsp;</td>";
						}
					}
				}
				echo "</tr></table></td></tr>";
			}
		}
				echo "<tr><td></td><td>";
					echo "<table style=\"width:700px;border-left: 1px solid Black;border-top: 1px solid Black;\" cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
							echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
							echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
							echo "<td style=\"width:25%;border-right: 1px solid Black\">&nbsp;</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td></tr>";
		echo "</table><br><br><br>";
	}
}

?>
