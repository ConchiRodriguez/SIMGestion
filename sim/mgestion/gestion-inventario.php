<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1005) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Inventario."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if ($soption == 0) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1005&sop=0\" class=".$class.">".$Dispositivos."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1005&sop=200\" class=".$class.">".$Buscar." ".$Dispositivo."</a></td>";
					if ($soption == 300) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1005&sop=300\" class=".$class.">".$Actuaciones."</a></td>";
					if (($soption >= 500) and ($soption <= 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1005&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 200)) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,id_tipo,id_client,codigo,id_empleado,num_serie";
			$datosInsert = array($_POST["nombre"],$_POST["id_tipo"],$_POST["id_client"],$_POST["codigo"],$_POST["id_empleado"],$_POST["num_serie"]);
			insertFunction ("sgm_inventario",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("nombre","id_tipo","id_client","codigo","id_empleado","num_serie");
			$datosUpdate = array($_POST["nombre"],$_POST["id_tipo"],$_POST["id_client"],$_POST["codigo"],$_POST["id_empleado"],$_POST["num_serie"]);
			updateFunction ("sgm_inventario",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_inventario",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($soption == 0) {echo "<h4>".$Dispositivos."</h4>";}
		if ($soption == 200) { echo "<h4>".$Buscar."</h4>"; }
			echo "<table cellspacing=\"0\" cellpadding=\"1\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<th></th>";
#					echo "<th style=\"width:300px\">".$Codigo."</th>";
					echo "<th style=\"width:300px\">".$Tipo."</th>";
					echo "<th style=\"width:300px\">".$Nombre."</th>";
					echo "<th style=\"width:300px\">".$Numero_serie."</th>";
					echo "<th style=\"width:300px\">".$Cliente."</th>";
					echo "<th style=\"width:300px\">".$Trabajador."</th>";
#					if ($soption == 200) {echo "<th style=\"width:100px\">".$Datos."</th>";}
					echo "<th></th>";
				echo "</tr>";
			if ($soption == 200) {
				echo "<form action=\"index.php?op=1005&sop=200\" method=\"post\">";
				echo "<tr>";
				$sqlx = "select * from sgm_inventario where visible=1 and id=".$_GET["id_disp"]."";
				$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
				$rowx = mysqli_fetch_array($resultx);
					echo "<td></td>";
#					echo "<td><input type=\"Text\" name=\"codigo\" value=\"".$_POST["codigo"]."\" style=\"width:100%\"></td>";
					echo "<td><select style=\"width:100%;\" name=\"id_tipo\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select * from sgm_inventario_tipo where visible=1 order by tipo";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_tipo"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["tipo"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
							}
						}
					echo "</td>";
					echo "<td style=\"color:black;text-align:left;\"><input type=\"Text\" name=\"nombre\" value=\"".$_POST["nombre"]."\" style=\"width:100%\"></td>";
					echo "<td style=\"color:black;text-align:left;\"><input type=\"Text\" name=\"num_serie\" value=\"".$_POST["num_serie"]."\" style=\"width:100%\"></td>";
					echo "<td>";
						echo "<select name=\"id_client\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlc = "select * from sgm_clients where visible=1 order by nombre";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)) {
							if ($_POST["id_client"] == $rowc["id"]){
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							}
						}
					echo "</td>";
					echo "<td>";
						echo "<select name=\"id_empleado\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlc = "select * from sgm_rrhh_empleado where visible=1 order by nombre";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)) {
							if ($_POST["id_client"] == $rowc["id"]){
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							}
						}
					echo "</td>";
					echo "<td style=\"color:black;text-align:left;width:250px\"><input type=\"Text\" name=\"dada\" value=\"".$_POST["dada"]."\" style=\"width:250px\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
				echo "</tr>";
				echo "</form>";
			} elseif ($soption == 0) {
				echo "<form action=\"index.php?op=1005&sop=0&ssop=1\" method=\"post\">";
				echo "<tr>";
					echo "<td></td>";
#					echo "<td></td>";
					echo "<td>";
						echo "<select name=\"id_tipo\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sgm_inventario_tipo where visible=1 order by tipo";
						$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
						while ($rowo = mysqli_fetch_array($resulto)) {
							echo "<option value=\"".$rowo["id"]."\">".$rowo["tipo"]."</option>";
						}
					echo "</td>";
					echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:100%;\"></td>";
					echo "<td><input type=\"Text\" name=\"num_serie\" style=\"width:100%\"></td>";
					echo "<td>";
						echo "<select name=\"id_client\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlc = "select * from sgm_clients where visible=1 order by nombre";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)) {
							echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
						}
					echo "</td>";
					echo "<td>";
						echo "<select name=\"id_empleado\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlc = "select * from sgm_rrhh_empleado where visible=1 order by nombre";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)) {
							echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
						}
					echo "</td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</tr>";
				echo "</form>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
		if (($soption == 0) or (($soption == 200) and (($_POST["nombre"] != "") or ($_POST["id_tipo"] > 0) or ($_POST["id_client"] > 0) or ($_POST["dada"] != "")))) {
			$sql = "select * from sgm_inventario where visible=1";
			if (($soption == 200) and ($ssoption == 0)){
				if ($_POST["dada"]) {
					$sqldada = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and dada like '%".$_POST["dada"]."%'";
					$resultdada = mysqli_query($dbhandle,convertSQL($sqldada));
					$rowdada = mysqli_fetch_array($resultdada);
					$sql = $sql." and id=".$rowdada["id_inventario"]."";
				}
				if ($_POST["nombre"]) {$sql = $sql." and nombre like '%".$_POST["nombre"]."%'";}
				if ($_POST["id_tipo"]) {$sql = $sql." and id_tipo=".$_POST["id_tipo"]."";}
				if ($_POST["id_client"]) {$sql = $sql." and id_client=".$_POST["id_client"]."";}
			}
			if (($soption == 200) and ($ssoption == 2)) {
				if ($_POST["dada2"]) {
					$sqldada = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and dada like '%".$_POST["dada"]."%'";
					$resultdada = mysqli_query($dbhandle,convertSQL($sqldada));
					$rowdada = mysqli_fetch_array($resultdada);
					$sql = $sql." and id=".$rowdada["id_inventario"]."";
				}
				if ($_POST["nombre2"]) {$sql = $sql." and nombre like '%".$_POST["nombre"]."%'";}
				if ($_POST["id_tipo2"]) {$sql = $sql." and id_tipo=".$_POST["id_tipo"]."";}
				if ($_POST["id_client2"]) {$sql = $sql." and id_client2=".$_POST["id_client2"]."";}
			}
			$sql = $sql." order by id_client,id_empleado,id_tipo,nombre";
#			echo $sql;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<tr style=\"border-bottom : 1px solid black;\">";
					echo "<form action=\"index.php?op=1005&sop=0&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
#					echo "<td>".$row["codigo"]."</td>";
					echo "<td>";
						echo "<select name=\"id_tipo\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sgm_inventario_tipo where visible=1 order by tipo";
						$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
						while ($rowo = mysqli_fetch_array($resulto)) {
							if ($row["id_tipo"] == $rowo["id"]){
								echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["tipo"]."</option>";
							} else {
								echo "<option value=\"".$rowo["id"]."\">".$rowo["tipo"]."</option>";
							}
						}
					echo "</td>";
					echo "<td style=\"vertical-align:top\"><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\" style=\"width:100%;\"></td>";
					echo "<td style=\"vertical-align:top\"><input type=\"Text\" name=\"num_serie\" value=\"".$row["num_serie"]."\" style=\"width:100%;\"></td>";
					echo "<td>";
						echo "<select name=\"id_client\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlc = "select * from sgm_clients where visible=1 order by nombre";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)) {
							if ($row["id_client"] == $rowc["id"]){
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							}
						}
					echo "</td>";
					echo "<td>";
						echo "<select name=\"id_empleado\" style=\"width:100%;\">";
						echo "<option value=\"0\">-</option>";
						$sqlc = "select * from sgm_rrhh_empleado where visible=1 order by nombre";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)) {
							if ($row["id_empleado"] == $rowc["id"]){
								echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</option>";
							}
						}
					echo "</td>";
					echo "<input type=\"Hidden\" name=\"nombre2\" value=\"".$_POST["nombre"]."\">";
					echo "<input type=\"Hidden\" name=\"id_tipo2\" value=\"".$_POST["id_tipo"]."\">";
					echo "<input type=\"Hidden\" name=\"dada2\" value=\"".$_POST["dada"]."\">";
					echo "<input type=\"Hidden\" name=\"id_client2\" value=\"".$_POST["id_client2"]."\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
#					echo "<td><a href=\"index.php?op=1005&sop=100&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" border=\"0\"></a></td>";
					echo "</form>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}

	if ($soption == 1) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1005&sop=0&ssop=3&id=".$_GET["id"],"op=1005&sop=0&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption >= 100) and ($soption < 200) and ($_GET["id"] > 0)) {
		if (($soption == 100) and ($ssoption == 1)) {
			$camposUpdate = array("nombre","id_tipo");
			$datosUpdate = array($_POST["nombre"],$_POST["id_tipo"]);
			updateFunction ("sgm_inventario",$_GET["id"],$camposUpdate,$datosUpdate);
			$sqla = "select * from sgm_inventario_tipo_atributo where id_tipo=".$_POST["id_tipo"];
			$resulta = mysqli_query($dbhandle,convertSQL($sqla));
			while ($rowa = mysqli_fetch_array($resulta)){
				if ($_POST["dada_".$rowa["id"]]){
					$sqld = "select count(*) as total from sgm_inventario_tipo_atributo_dada where id_inventario=".$_GET["id"]." and id_atribut=".$rowa["id"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					if ($rowd["total"] != 0){
						$sqlb = "update sgm_inventario_tipo_atributo_dada set ";
						$sqlb = $sqlb."dada='".comillas($_POST["dada_".$rowa["id"]])."'";
						$sqlb = $sqlb." WHERE id_inventario=".$_GET["id"]." and id_atribut=".$rowa["id"];
						mysqli_query($dbhandle,convertSQL($sqlb));
					}
					if ($rowd["total"] == 0){
						$sqlc = "insert into sgm_inventario_tipo_atributo_dada (dada,id_atribut,id_inventario) ";
						$sqlc = $sqlc."values (";
						$sqlc = $sqlc."'".comillas($_POST["dada_".$rowa["id"]])."'";
						$sqlc = $sqlc.",".$rowa["id"]."";
						$sqlc = $sqlc.",".$_GET["id"]."";
						$sqlc = $sqlc.")";
						mysqli_query($dbhandle,convertSQL($sqlc));
					}
				}
			}
		}
		$sql = "select * from sgm_inventario where id=".$_GET["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1005&sop=0\" style=\"color:white;\">&laquo; ".$Volver."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1005&sop=100&id=".$row["id"]."\" style=\"color:white;\">".$Datos." ".$Generales."</a></td>";
#							echo "<td class=\"ficha\"><a href=\"index.php?op=1005&sop=110&id=".$row["id"]."\" style=\"color:white;\">".$Relaciones."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1005&sop=120&id=".$row["id"]."\" style=\"color:white;\">".$Actuaciones."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1005&sop=130&id=".$row["id"]."\" style=\"color:white;\">".$Archivos."</a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:400px;padding : 5px 10px 10px 10px;\">";
					echo "<strong style=\"font : bold normal normal 15px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]."</strong>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\" style=\"background-color:Red;\"><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\" style=\"color:white;\">".$Eliminar."</a></td></tr>";
					echo "</table>";
				echo "</td>";

			echo "</tr>";
		echo "</table>";

		echo "</td></tr></table><br>";
		echo "</center>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 100) {
		$sql = "select * from sgm_inventario where id=".$_GET["id"].$row1["id"];
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		echo "<form action=\"index.php?op=1005&sop=100&ssop=1&id=".$row["id"]."\"  method=\"post\">";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">";
						echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
							echo "<tr>";
								echo "<th></th>";
								echo "<th>".$Datos." ".$Generales."</th>";
							echo "</tr>";
						echo "<tr><td style=\"text-align:right;width:100px\">".$Nombre.": </td><td><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"  style=\"width:400px\"></td></tr>";
						echo "<tr><td style=\"text-align:right;width:100px\">".$Tipo.": </td><td>";
							echo "<select name=\"id_tipo\" style=\"width:400px;\">";
							echo "<option value=\"0\">-</option>";
							$sqlo = "select * from sgm_inventario_tipo where visible=1 order by tipo";
							$resulto = mysqli_query($dbhandle,convertSQL($sqlo));
							while ($rowo = mysqli_fetch_array($resulto)) {
								if ($row["id_tipo"] == $rowo["id"]){
									echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["tipo"]."</option>";
									$tipo = $rowo["id"];
								} else {
									echo "<option value=\"".$rowo["id"]."\">".$rowo["tipo"]."</option>";
								}
							}
						echo "</td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr><td></td><td><strong>".$Atributos."</strong></td></tr>";
						$sqla = "select * from sgm_inventario_tipo_atributo where visible=1 and id_tipo=".$tipo."";
						$resulta = mysqli_query($dbhandle,convertSQL($sqla));
						while ($rowa = mysqli_fetch_array($resulta)) {
							$sqld = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and id_atribut=".$rowa["id"]." and id_inventario=".$row["id"]."";
							$resultd = mysqli_query($dbhandle,convertSQL($sqld));
							$rowd = mysqli_fetch_array($resultd);
							echo "<tr><td style=\"text-align:right;width:150px\">".$rowa["atributo"]." : </td><td><input type=\"Text\" name=\"dada_".$rowa["id"]."\" value=\"".$rowd["dada"]."\"  style=\"width:385px\"></td></tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td colspan=\"2\" style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:400px\"></td></tr>";
		echo "</table>";
		echo "</form>";
	}

/*
	if ($soption == 110){
		if ($ssoption == 3) {
			$sql = "delete from sgm_inventario_relacion WHERE (id_disp1=".$_GET["id_disp"]." and id_disp2=".$_GET["id"].") or (id_disp2=".$_GET["id_disp"]." and id_disp1=".$_GET["id"].")";
			mysqli_query($dbhandle,convertSQL($sql));
		}
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=115&id=".$_GET["id"]."\" style=\"color:white;\">".$Ver." ".$Esquema."</a>";
			echo "</td>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=80&id=".$_GET["id"]."\" style=\"color:white;\">".$Anadir." &raquo;</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<strong>".$Relaciones." : </strong><br><br>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td>".$Tipo."</td>";
				echo "<td>".$Nombre."</td>";
				echo "<td><table><tr><td style=\"width:150px;\">".$Atributos."</td>";
				echo "<td style=\"width:150px;\">".$Datos."</td></tr></table></td>";
			echo "</tr>";
		$sqli = "select * from sgm_inventario_relacion where visible=1 and (id_disp1=".$_GET["id"]." or id_disp2=".$_GET["id"].")";
		$resulti = mysqli_query($dbhandle,convertSQL($sqli));
		while ($rowi = mysqli_fetch_array($resulti)) {
			if ($rowi["id_disp1"] == $_GET["id"]) {$id_disp = $rowi["id_disp2"];}
			if ($rowi["id_disp2"] == $_GET["id"]) {$id_disp = $rowi["id_disp1"];}
			$sql = "select * from sgm_inventario where visible=1 and id=".$id_disp."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			echo "<tr>";
				echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1005&sop=71&id=".$_GET["id"]."&id_disp=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				$sqlt = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]." order by tipo";
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				echo "<td style=\"vertical-align:top;width:150px;\"\">".$rowt["tipo"]."</td>";
				echo "<td style=\"vertical-align:top;width:150px;\"><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
				echo "<td><table>";
					$sqla = "select * from sgm_inventario_tipo_atributo where visible=1 and id_tipo=".$row["id_tipo"]." order by atributo";
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					while ($rowa = mysqli_fetch_array($resulta)){
						echo "<tr><td style=\"width:150px;vertical-align:top\">".$rowa["atributo"]."</td>";
						$sqlda = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and id_atribut=".$rowa["id"]." and id_inventario=".$row["id"]."";
						$resultda = mysqli_query($dbhandle,convertSQL($sqlda));
						while ($rowda = mysqli_fetch_array($resultda)){
							if (strlen($rowda["dada"]) < 2){
								echo "<td style=\"width:150px;\">".$rowda["dada"]."</td></tr>";
							} else {
								echo "<td><textarea cols=\"20\" rows=\"2\">".$rowda["dada"]."</textarea></td>";
							}
						}
					}
				echo "</table></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 111) {
		echo "<center>";
		echo "�Seguro que desea eliminar este archivo?";
		echo "<br><br><a href=\"index.php?op=1005&sop=70&ssop=3&id=".$_GET["id"]."&id_disp=".$_GET["id_disp"]."\">[ SI ]</a><a href=\"index.php?op=1005&sop=70&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 115){
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=70&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<strong>".$Esquema." : </strong><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
		$sql0 = "select * from sgm_inventario where visible=1 and id=".$_GET["id"]."";
		$result0 = mysqli_query($dbhandle,convertSQL($sql0));
		$row0 = mysqli_fetch_array($result0);
		$id = $row0["id"];
		echo "<tr><td><strong>".$row["nombre"]."</strong></td></tr>";
		echo "</table><br><br>";
		echo "<table>";
			$sqli = "select * from sgm_inventario_relacion where visible=1 and (id_disp1=".$_GET["id"]." or id_disp2=".$_GET["id"].")";
			$resulti = mysqli_query($dbhandle,convertSQL($sqli));
			while ($rowi = mysqli_fetch_array($resulti)) {
				if ($rowi["id_disp1"] == $_GET["id"]) {$id_disp = $rowi["id_disp2"];}
				if ($rowi["id_disp2"] == $_GET["id"]) {$id_disp = $rowi["id_disp1"];}
				$sql = "select * from sgm_inventario where visible=1 and id=".$id_disp."";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				$row = mysqli_fetch_array($result);
				if ($row["id"]){
					echo "<tr>";
						$id = $id.",".$row["id"];
						$sqlt = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]."";
						$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
						$rowt = mysqli_fetch_array($resultt);
					if (($ssoption == 1) and ($row["id"] == $_GET["id_disp"])){
						echo "<td>";
							echo "<table>";
							$sqlii = "select * from sgm_inventario_relacion where visible=1 and (id_disp2=".$_GET["id_disp"]." or id_disp1=".$_GET["id_disp"].")";
							$resultii = mysqli_query($dbhandle,convertSQL($sqlii));
							while ($rowii = mysqli_fetch_array($resultii)) {
								if ($rowii["id_disp1"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp2"];}
								if ($rowii["id_disp2"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp1"];}
								$sqltx = "select * from sgm_inventario_tipo where visible=1 and orden>".$rowt["orden"]."";
								$resulttx = mysqli_query($dbhandle,convertSQL($sqltx));
								while ($rowtx = mysqli_fetch_array($resulttx)) {
									$sqlx = "select * from sgm_inventario where visible=1 and id=".$id_disp2." and id NOT IN (".$id.") and id_tipo=".$rowtx["id"];
									$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
									$rowx = mysqli_fetch_array($resultx);
									if ($rowx["id"]){
										echo "<tr>";
											echo "<td>";
												echo "<a href=\"index.php?op=1005&sop=75&ssop=1".$ssoption."&id=".$_GET["id"]."&id_disp=".$_GET["id_disp"]."&id_disp2=".$rowx["id"]."\"><img src=\"mgestion/pics/icons-mini/bullet_toggle_minus.png\" border=\"0\"></a>";
												echo "<a href=\"index.php?op=1005&sop=1&id=".$rowx["id"]."\"><strong>".$rowx["nombre"]."</strong></a>";
												echo "<a href=\"index.php?op=1005&sop=75&ssop=2&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/bullet_toggle_plus.png\" border=\"0\"></a>";
											echo "</td>";
										echo "</tr>";
									}
								}
							}
							echo "</table>";
						echo "</td>";
					} else { echo "<td><table><tr><td>&nbsp;</td></tr></table></td>"; }
						echo "<td>";
							echo "<a href=\"index.php?op=1005&sop=75&ssop=1&id=".$_GET["id"]."&id_disp=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/bullet_toggle_minus.png\" border=\"0\"></a>";
							echo "<a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\"><strong>".$row["nombre"]."</strong></a>";
							echo "<a href=\"index.php?op=1005&sop=75&ssop=2&id=".$_GET["id"]."&id_disp=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/bullet_toggle_plus.png\" border=\"0\"></a>";
						echo "</td>";
					if (($ssoption == 2) and ($row["id"] == $_GET["id_disp"])){
						echo "<td>";
							echo "<table>";
							$sqlii = "select * from sgm_inventario_relacion where visible=1 and (id_disp2=".$_GET["id_disp"]." or id_disp1=".$_GET["id_disp"].")";
							$resultii = mysqli_query($dbhandle,convertSQL($sqlii));
							while ($rowii = mysqli_fetch_array($resultii)) {
								if ($rowii["id_disp1"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp2"];}
								if ($rowii["id_disp2"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp1"];}
								$sqltx = "select * from sgm_inventario_tipo where visible=1 and orden<".$rowt["orden"]."";
								$resulttx = mysqli_query($dbhandle,convertSQL($sqltx));
								while ($rowtx = mysqli_fetch_array($resulttx)) {
									$sqlx = "select * from sgm_inventario where visible=1 and id=".$id_disp2." and id NOT IN (".$id.") and id_tipo=".$rowtx["id"];
									$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
									$rowx = mysqli_fetch_array($resultx);
									if ($rowx["id"]){
										echo "<tr>";
											echo "<td>";
												echo "<a href=\"index.php?op=1005&sop=75&ssop=1&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/bullet_toggle_minus.png\" border=\"0\"></a>";
												echo "<a href=\"index.php?op=1005&sop=1&id=".$rowx["id"]."\"><strong>".$rowx["nombre"]."</strong></a>";
												echo "<a href=\"index.php?op=1005&sop=75&ssop=2&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/bullet_toggle_plus.png\" border=\"0\"></a>";
											echo "</td>";
										echo "</tr>";
									}
								}
							}
							echo "</table>";
						echo "</td>";
					} else { echo "<td><table><tr><td>&nbsp;</td></tr></table></td>"; }
					echo "</tr>";
				}
			}
		echo "</table>";
	}
*/
	if ($soption == 120){
		$fecha = date("Y-m-d H:i:s");
		if ($ssoption == 1) {
			$camposUpdate=array('finalizada');
			$datosUpdate=array(1);
			updateFunction("sgm_inventario_actuacion_disp",$_GET["id_act"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Actuaciones." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th></th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Fecha." ".$Prevision."</th>";
				echo "<th>".$Duracion."</th>";
				echo "<th></th>";
			echo "</tr>";
		$sqli = "select * from sgm_inventario_actuacion_disp where visible=1 and id_dispositivo=".$_GET["id"]."";
		$resulti = mysqli_query($dbhandle,convertSQL($sqli));
		while ($rowi = mysqli_fetch_array($resulti)) {
			if ($rowi["finalizada"] == 0) {	$color = "red";	} else { $color = "green"; }
			echo "<form action=\"index.php?op=1005&sop=120&ssop=1&id=".$_GET["id"]."&id_act=".$rowi["id"]."\" method=\"post\">";
			echo "<tr style=\"background-color:".$color."\">";
				echo "<td></td>";
				$sqlac = "select * from sgm_inventario_actuacion where visible=1 and id=".$rowi["id_actuacion"];
				$resultac = mysqli_query($dbhandle,convertSQL($sqlac));
				$rowac = mysqli_fetch_array($resultac);
				echo "<td style=\"width:150px;\">".$rowac["nombre"]."</td>";
				$sqluu = "select * from sgm_users where id=".$rowi["id_user"]."";
				$resultuu = mysqli_query($dbhandle,convertSQL($sqluu));
				$rowuu = mysqli_fetch_array($resultuu);
				echo "<td style=\"vertical-align:top;width:150px;\">".$rowuu["usuario"]."</td>";
				echo "<td style=\"color:black;\">".$rowi["data_prevision"]."</td>";
				echo "<td style=\"color:black;text-align:center;\">".$rowac["duracion"]." h.</td>";
				if ($rowi["finalizada"] == 0) {
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Finalizar."\"></td>";
				} else {
					echo "<td></td>";
				}
			echo "</tr>";
			echo "</form>";
		}
		echo "</table>";
	}

	if ($soption == 130) {
		echo "<h4>".$Archivos."</h4>";
		anadirArchivo ($_GET["id"],5,"");
	}

	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1005&sop=130&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1005&sop=130&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 300) {
		if ($ssoption == 1) {
			$camposInsert = "id_actuacion,id_dispositivo,id_user,data_prevision";
			$datosInsert = array($_POST["id_actuacion"],$_POST["id_dispositivo"],$_POST["id_user"],$_POST["data_prevision"]);
			insertFunction ("sgm_inventario_actuacion_disp",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("id_actuacion","id_dispositivo","id_user","data_prevision");
			$datosUpdate = array($_POST["id_actuacion"],$_POST["id_dispositivo"],$_POST["id_user"],$_POST["data_prevision"]);
			updateFunction ("sgm_inventario_actuacion_disp",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_inventario_actuacion_disp",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Actuaciones." ".$Pendientes." :</h4>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Actuacion."</th>";
				echo "<th>".$Dispositivo."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Fecha." ".$Prevision."</th>";
				echo "<th>".$Duracion."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1005&sop=300&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select style=\"width:250px\" name=\"id_actuacion\">";
					echo "<option value=\"0\">-</option>";
					$sqla = "select * from sgm_inventario_actuacion where visible=1 order by nombre";
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					while ($rowa = mysqli_fetch_array($resulta)) {
						echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select style=\"width:250px\" name=\"id_dispositivo\">";
					echo "<option value=\"0\">-</option>";
					$sqli = "select * from sgm_inventario where visible=1 order by nombre";
					$resulti = mysqli_query($dbhandle,convertSQL($sqli));
					while ($rowi = mysqli_fetch_array($resulti)) {
						echo "<option value=\"".$rowi["id"]."\">".$rowi["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select style=\"width:250px\" name=\"id_user\">";
					echo "<option value=\"0\">-</option>";
					$sqlu = "select * from sgm_users where sgm=1 and validado=1 and activo=1 order by usuario";
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					while ($rowu = mysqli_fetch_array($resultu)) {
						echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
					}
				echo "</select></td>";
				$fecha = date("Y-m-d H:i:s");
				echo "<td><input type=\"text\" name=\"data_prevision\" value=\"".$fecha."\"></td>";
				echo "<td></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_inventario_actuacion_disp where visible=1 order by data_prevision";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=301&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1005&sop=300&ssop=2\" method=\"post\">";
					echo "<td><select style=\"width:250px\" name=\"id_actuacion\">";
						echo "<option value=\"0\">-</option>";
						$sqlia = "select * from sgm_inventario_actuacion where visible=1 order by nombre";
						$resultia = mysqli_query($dbhandle,convertSQL($sqlia));
						while ($rowia = mysqli_fetch_array($resultia)) {
							if ($row["id_actuacion"] == $rowia["id"]){
								echo "<option value=\"".$rowia["id"]."\" selected>".$rowia["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowia["id"]."\">".$rowia["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_dispositivo\">";
						echo "<option value=\"0\">-</option>";
						$sqli = "select * from sgm_inventario where visible=1 order by nombre";
						$resulti = mysqli_query($dbhandle,convertSQL($sqli));
						while ($rowi = mysqli_fetch_array($resulti)) {
							if ($row["id_dispositivo"] == $rowi["id"]){
								echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowi["id"]."\">".$rowi["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_user\">";
						echo "<option value=\"0\">-</option>";
						$sqlu = "select * from sgm_users where sgm=1 and validado=1 and activo=1 order by usuario";
						$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
						while ($rowu = mysqli_fetch_array($resultu)) {
							if ($row["id_user"] == $rowu["id"]){
								echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
							} else {
								echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" name=\"data_prevision\" value=\"".$row["data_prevision"]."\"></td>";
					$sqlac = "select * from sgm_inventario_actuacion where visible=1 and id=".$row["id_actuacion"];
					$resultac = mysqli_query($dbhandle,convertSQL($sqlac));
					$rowac = mysqli_fetch_array($resultac);
					echo "<td style=\"text-align:center;\">".$rowac["duracion"]." h.</td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 301) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1005&sop=300&ssop=3&id=".$_GET["id"],"op=1005&sop=300"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 310) {
		if ($ssoption == 1) {
			mysqli_query($dbhandle,convertSQL($sql));
			$camposInsert = "id_act,id_disp,id_user,data";
			$datosInsert = array($_GET["id_act"],$_GET["id_disp"],$userid,$xfecha);
			insertFunction ("sgm_inventario_actuacion_disp",$camposInsert,$datosInsert);
		}
		$sqla = "select * from sgm_inventario_actuacion where visible=1 and id=".$_GET["id"]."";
		$resulta = mysqli_query($dbhandle,convertSQL($sqla));
		$rowa = mysqli_fetch_array($resulta);
		echo "<h4>".$Actuacion." : ".$rowa["nombre"]."</h4>";
		echo boton(array("op=1005&sop=300"),array("&laquo; ".$Volver));
		echo "<table cellspacing=\"0\ style=\"width:300px;\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Dispositivo."</th>";
				echo "<th>".$Dispositivo." ".$Relacionado."</th>";
				echo "<th>".$Estado."</th>";
			echo "</tr>";
			$sql = "select * from sgm_inventario where visible=1 and id=".$rowa["id_disp"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$sqltip = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]."";
			$resulttip = mysqli_query($dbhandle,convertSQL($sqltip));
			$rowtip = mysqli_fetch_array($resulttip);
			$sqlr = "select * from sgm_inventario_relacion where visible=1 and ((id_disp1=".$rowa["id_disp"].") or (id_disp2=".$rowa["id_disp"]."))";
			$resultr = mysqli_query($dbhandle,convertSQL($sqlr));
			while ($rowr = mysqli_fetch_array($resultr)) {
				if ($rowr["id_disp1"] == $row["id"]){ $id_disp = $rowr["id_disp2"]; } else { $id_disp = $rowr["id_disp1"]; }
				$sqlti = "select * from sgm_inventario_tipo where visible=1 and orden < ".$rowtip["orden"]."";
				$resultti = mysqli_query($dbhandle,convertSQL($sqlti));
				$rowti = mysqli_fetch_array($resultti);
				$sqlt = "select * from sgm_inventario where visible=1 and id=".$id_disp." and id_tipo=".$rowti["id"]."";
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				$rowt = mysqli_fetch_array($resultt);
				if ($rowt["id"]){
	 				$sqld = "select count(*) as total from sgm_inventario_actuacion_disp where visible=1 and id_disp=".$rowt["id"]." and id_act=".$rowa["id"]."";
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					if ($rowd["total"] == 0) {$color = "red"; $estado = 'Pendiente'; } else { $color = "green"; $estado = 'Echo'; }
					echo "<form action=\"index.php?op=1005&sop=310&ssop=1&id=".$_GET["id"]."&id_act=".$rowa["id"]."&id_disp=".$rowt["id"]."\" method=\"post\">";
					echo "<tr style=\"background-color:".$color."\">";
						echo "<td style=\"width:150px;\"><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\" style=\"color:white;\">".$row["nombre"]."</a></td>";
						echo "<td style=\"width:150px;\"><a href=\"index.php?op=1005&sop=1&id=".$rowt["id"]."\" style=\"color:white;\">".$rowt["nombre"]."</a></td>";
						echo "<td style=\"width:100px\">".$estado."</td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		echo "</table>";
	}

	if ($soption == 500){
		if ($admin == true) {
			echo boton(array("op=1005&sop=510","op=1005&sop=520"),array($Tipos,$Actuaciones));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "tipo";
			$datosInsert = array($_POST["tipo"]);
			insertFunction ("sgm_inventario_tipo",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("tipo");
			$datosUpdate = array($_POST["tipo"]);
			updateFunction ("sgm_inventario_tipo",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$sql = "update sgm_inventario set ";
			$sql = $sql."id_tipo=0";
			$sql = $sql." WHERE id_tipo=".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$sql = "delete from sgm_inventario_tipo WHERE id=".$_GET["id"];
			mysqli_query($dbhandle,convertSQL($sql));
		}
		echo "<h4>".$Tipos." :</h4>";
		echo boton(array("op=1005&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</td>";
#				echo "<th style=\"width:50px\">".$Orden."</th>";
#				echo "<th style=\"width:50px\">".$Codigo."</th>";
				echo "<th style=\"width:200px\">".$Tipo."</th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1005&sop=510&ssop=1\" method=\"post\">";
				echo "<td></td>";
#				echo "<td><input type=\"text\" style=\"width:100%\" name=\"orden\"></td>";
#				echo "<td><input type=\"text\" style=\"width:100%\" name=\"codigo\"></td>";
				echo "<td><input type=\"text\" style=\"width:100%\" name=\"tipo\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_inventario_tipo order by orden";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1005&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
#					echo "<td><input type=\"text\" value=\"".$row["orden"]."\" style=\"width:100%\" name=\"orden\"></td>";
#					echo "<td><input type=\"text\" value=\"".$row["codigo"]."\" style=\"width:100%\" name=\"codigo\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["tipo"]."\" style=\"width:100%\" name=\"tipo\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
#					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
#						echo "<a href=\"index.php?op=1005&sop=515&id=".$row["id"]."\" style=\"color:white;\">".$Atributos."</a>";
#					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 511) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1005&sop=510&ssop=3&id=".$_GET["id"],"op=1005&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 515) and ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "id_tipo,atributo";
			$datosInsert = array($_GET["id"],$_POST["atributo"]);
			insertFunction ("sgm_inventario_tipo_atributo",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("atributo");
			$datosUpdate = array($_POST["atributo"]);
			updateFunction ("sgm_inventario_tipo_atributo",$_GET["id_atri"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_inventario_tipo_atributo WHERE id=".$_GET["id_atri"];
			mysqli_query($dbhandle,convertSQL($sql));
		}

		echo "<h4>".$Atributos." : </h4>";
		echo boton(array("op=1005&sop=510"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1005&sop=515&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Atributo."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"atributo\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select * from sgm_inventario_tipo_atributo where id_tipo=".$_GET["id"]." order by atributo";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=516&id=".$_GET["id"]."&id_atri=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1005&sop=515&ssop=2&id=".$_GET["id"]."&id_atri=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["atributo"]."\" style=\"width:200px\" name=\"atributo\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 516) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1005&sop=515&ssop=3&id=".$_GET["id"]."&id_atri=".$_GET["id_atri"],"op=1005&sop=515"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) AND ($admin == true)) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,parada,duracion";
			$datosInsert = array($_POST["nombre"],$_POST["parada"],$_POST["duracion"]);
			insertFunction ("sgm_inventario_actuacion",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("nombre","parada","duracion");
			$datosUpdate = array($_POST["nombre"],$_POST["parada"],$_POST["duracion"]);
			updateFunction ("sgm_inventario_actuacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_inventario_actuacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Actuaciones." :</h4>";
		echo boton(array("op=1005&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Actuacion."</th>";
				echo "<th>".$Parada."</th>";
				echo "<th>".$Duracion." (h.)</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1005&sop=520&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:200px\" name=\"nombre\"></td>";
				echo "<td><select style=\"width:50px\" name=\"parada\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input type=\"text\" style=\"width:50px\" name=\"duracion\">";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select * from sgm_inventario_actuacion where visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=521&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1005&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:200px\" name=\"nombre\"></td>";
					echo "<td><select style=\"width:50px\" name=\"parada\">";
						if ($row["parada"] == 0){
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						} else {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" value=\"".$row["duracion"]."\" style=\"width:50px\" name=\"duracion\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 521) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1005&sop=520&ssop=3&id=".$_GET["id"],"op=1005&sop=520"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 999){
		$sql = "select * from sgm_files";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)){
			if ($row["id_cuerpo"] > 0) {$tipo = 0; $id = $row["id_cuerpo"];}
			if ($row["id_article"] > 0) {$tipo = 1; $id = $row["id_article"];}
			if ($row["id_client"] > 0) {$tipo = 2; $id = $row["id_client"];}
			if ($row["id_contrato"] > 0) {$tipo = 3; $id = $row["id_contrato"];}
			if ($row["id_incidencia"] > 0) {$tipo = 4; $id = $row["id_incidencia"];}
			$camposUpdate=array("tipo_id_elemento","id_elemento");
			$datosUpdate=array($tipo,$id);
			updateFunction("sgm_files",$row["id"],$camposUpdate,$datosUpdate);
		}

	}

	echo "</td></tr></table><br>";
}

?>
