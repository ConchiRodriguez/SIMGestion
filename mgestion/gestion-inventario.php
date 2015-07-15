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
					echo "<td class=".$class."><a href=\"index.php?op=1005&sop=300\" class=".$class.">".$Impresion."</a></td>";
					if (($soption >= 500) and ($soption <= 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1005&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

/*	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<center><table><tr>";
				echo "<td style=\"height:20px;width:170px;\";><strong>".$Inventario.":</strong></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 80) and (!$_GET["id"])) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1005&sop=80\" class=\"gris\" style=\"color:".$lcolor."\">".$Buscar." ".$Dispositivo."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 1) and (!$_GET["id"])) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1005&sop=1\" class=\"gris\" style=\"color:".$lcolor."\">".$Crear." ".$Dispositivo."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 300) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1005&sop=300\" class=\"gris\" style=\"color:".$lcolor."\">".$Actuaciones." ".$Pendientes."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 1000) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:170px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1005&sop=1000\" class=\"gris\" style=\"color:".$lcolor."\">".$Administrar."</a></td>";
			echo "</tr></table></center>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
*/
	if (($soption >= 1) and ($soption <= 99) and (($_POST["nombre"]) or ($_GET[id] != 0))) {
		if (($soption == 1) and ($ssoption == 1)) {
			$sql = "update sgm_inventario set ";
			$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql.",id_tipo=".$_POST["id_tipo"];
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sqla = "select * from sgm_inventario_tipo_atributo where id_tipo=".$_POST["id_tipo"];
			$resulta = mysql_query(convert_sql($sqla));
			while ($rowa = mysql_fetch_array($resulta)){
				if ($_POST["dada_".$rowa["id"]]){
					$sqld = "select count(*) as total from sgm_inventario_tipo_atributo_dada where id_inventario=".$_GET["id"]." and id_atribut=".$rowa["id"];
					$resultd = mysql_query(convert_sql($sqld));
					$rowd = mysql_fetch_array($resultd);
					if ($rowd["total"] != 0){
						$sqlb = "update sgm_inventario_tipo_atributo_dada set ";
						$sqlb = $sqlb."dada='".comillas($_POST["dada_".$rowa["id"]])."'";
						$sqlb = $sqlb." WHERE id_inventario=".$_GET["id"]." and id_atribut=".$rowa["id"];
						mysql_query(convert_sql($sqlb));
					}
					if ($rowd["total"] == 0){
						$sqlc = "insert into sgm_inventario_tipo_atributo_dada (dada,id_atribut,id_inventario) ";
						$sqlc = $sqlc."values (";
						$sqlc = $sqlc."'".comillas($_POST["dada_".$rowa["id"]])."'";
						$sqlc = $sqlc.",".$rowa["id"]."";
						$sqlc = $sqlc.",".$_GET["id"]."";
						$sqlc = $sqlc.")";
						mysql_query(convert_sql($sqlc));
					}
				}
			}
		}
		if (($soption == 1) and ($ssoption == 2)) {
			$sql = "insert into sgm_inventario (nombre,id_tipo)";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["nombre"])."'";
			$sql = $sql.",".$_POST["id_tipo"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
			$sql1 = "select * from sgm_inventario where visible=1 order by id desc";
			$result1 = mysql_query(convert_sql($sql1));
			$row1 = mysql_fetch_array($result1);
		}
		$sql = "select * from sgm_inventario where id=".$_GET["id"]."".$row1["id"]."";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		echo "<center>";
		echo "<table cellpadding=\"0\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"javascript:history.go(-1);\" style=\"color:white;\">&laquo; ".$Volver."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\" style=\"color:white;\">".$Datos."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1005&sop=70&id=".$row["id"]."\" style=\"color:white;\">".$Relaciones."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1005&sop=60&id=".$row["id"]."\" style=\"color:white;\">".$Actuaciones."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td style=\"width:120px;text-align:center;vertical-align:middle;background-color: #4B53AF;color: white;border: 1px solid black;height: 30px;\"><a href=\"index.php?op=1005&sop=90&id=".$row["id"]."\" style=\"color:white;\">".$Archivos."</a></td></tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:400px;padding : 5px 10px 10px 10px;\">";
					echo "<strong style=\"font : bold normal normal 15px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$row["nombre"]."</strong>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td style=\"width:120px;text-align:center;vertical-align:middle;background-color:Red;color:white;border:1px solid black;height:30px;\"><a href=\"index.php?op=1005&sop=3&id=".$row["id"]."\" style=\"color:white;\">".$Eliminar."</a></td>";
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

	if ($soption == 1) {
		if (($_GET["id"] > 0) or ($_POST["nombre"])) {
			$sql = "select * from sgm_inventario where id=".$_GET["id"].$row1["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1005&sop=1&ssop=1&id=".$row["id"]."\"  method=\"post\">";
		} 
		if (($_GET["id"] == 0) and (!$_POST["nombre"])) {
			echo "<strong>".$Nuevo." ".$Dispositivo." :</strong><br>";
			$sql = "select * from sgm_inventario where id=".$_GET["id"].$row1["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1005&sop=1&ssop=2\" method=\"post\">";
		}
		echo "<center>";
		echo "<table><tr>";
			echo "<td style=\"vertical-align:top;\">";
				echo "<center>";
				echo "<strong>".$Datos."</strong>";
				echo "<table>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Nombre.": </td><td><input type=\"Text\" name=\"nombre\" value=\"".$row["nombre"]."\"  style=\"width:385px\"></td></tr>";
					echo "<tr><td style=\"text-align:right;width:100px\">".$Tipo.": </td><td>";
						echo "<select name=\"id_tipo\" style=\"width:385px;\">";
						echo "<option value=\"0\">-</option>";
						$sqlo = "select * from sgm_inventario_tipo where visible=1 order by tipo";
						$resulto = mysql_query(convert_sql($sqlo));
						while ($rowo = mysql_fetch_array($resulto)) {
							if ((($_GET["id"] > 0) or ($row1["id"])) and ($row["id_tipo"] == $rowo["id"])){
								echo "<option value=\"".$rowo["id"]."\" selected>".$rowo["tipo"]."</option>";
								$tipo = $rowo["id"];
							} else {
								echo "<option value=\"".$rowo["id"]."\">".$rowo["tipo"]."</option>";
							}
						}
					echo "</td></tr>";
				echo "</table>";
				echo "</center>";
			echo "</td>";
			if (($_GET["id"] > 0) or ($_POST["nombre"])){
				echo "<td style=\"vertical-align:top\">";
					echo "<table>";
						echo "<tr><td></td><td><strong>".$Atributos."</strong></td></tr>";
						$sqla = "select * from sgm_inventario_tipo_atributo where visible=1 and id_tipo=".$tipo."";
						$resulta = mysql_query(convert_sql($sqla));
						while ($rowa = mysql_fetch_array($resulta)) {
							$sqld = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and id_atribut=".$rowa["id"]." and id_inventario=".$row["id"]."";
							$resultd = mysql_query(convert_sql($sqld));
							$rowd = mysql_fetch_array($resultd);
							echo "<tr><td style=\"text-align:right;width:150px\">".$rowa["atributo"]." : </td><td><input type=\"Text\" name=\"dada_".$rowa["id"]."\" value=\"".$rowd["dada"]."\"  style=\"width:385px\"></td></tr>";
						}
					echo "</table>";
				echo "</td>";
			}
		echo "</tr></table></center>";
		if (($_GET["id"] > 0) or ($_POST["nombre"])) { echo "<center><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:300px\"></center>"; }
		if (($_GET["id"] == 0) and (!$_POST["nombre"])) { echo "<center><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:300px\"></center>"; }
		echo "</form>";
	}

	if ($soption == 3) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este dispositivo?";
		echo "<br><br><a href=\"index.php?op=1005&sop=4&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1005&sop=0&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 4) {
		$sql = "update sgm_inventario set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
		echo "<center>";
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1005&sop=0\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 60){
		$a = date("Y");
		$m = date("n");
		$d = date("j");
		$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i:s");
		if ($ssoption == 1) {
			if ($_POST["mod"] == 0){
				$sql = "insert into sgm_inventario_actuacion_disp (id_act,id_disp,id_user,data)";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_act"]."";
				$sql = $sql.",".$_GET["id_disp"];
				$sql = $sql.",".$userid."";
				$sql = $sql.",'".$_POST["data"]."'";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
			if ($_POST["mod"] == 1){
				$sql = "update sgm_inventario_actuacion_disp set ";
				$sql = $sql."data='".$_POST["data"]."'";
				$sql = $sql."WHERE id_disp=".$_GET["id"]." and id_act=".$_GET["id_act"]."";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 3) {
			$sql = "update sgm_inventario_actuacion_disp set ";
			$sql = $sql."visible=0";
			$sql = $sql."WHERE id_disp=".$_POST["id_disp"]." and id_act=".$_POST["id_act"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Actuaciones." : </strong><br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>&nbsp;</td>";
				echo "<td>".$Nombre."</td>";
				echo "<td>".$Dispositivo." ".$Relacionado."</td>";
				echo "<td>".$Fecha."</td>";
				echo "<td>".$Usuario."</td>";
				echo "<td></td>";
			echo "</tr>";
		$sql = "select * from sgm_inventario where visible=1 and id=".$_GET["id"]."";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		$sqltip = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]."";
		$resulttip = mysql_query(convert_sql($sqltip));
		$rowtip = mysql_fetch_array($resulttip);
		$sqli = "select * from sgm_inventario_actuacion where visible=1 and id_disp=".$row["id"]."";
		$resulti = mysql_query(convert_sql($sqli));
		while ($rowi = mysql_fetch_array($resulti)) {
			$sqlr = "select * from sgm_inventario_relacion where visible=1 and ((id_disp1=".$row["id"].") or (id_disp2=".$row["id"]."))";
			$resultr = mysql_query(convert_sql($sqlr));
			while ($rowr = mysql_fetch_array($resultr)) {
				if ($rowr["id_disp1"] == $row["id"]){ $id_disp = $rowr["id_disp2"]; } else { $id_disp = $rowr["id_disp1"]; }
				$sqlti = "select * from sgm_inventario_tipo where visible=1 and orden < ".$rowtip["orden"]."";
				$resultti = mysql_query(convert_sql($sqlti));
				$rowti = mysql_fetch_array($resultti);
				$sqlt = "select * from sgm_inventario where visible=1 and id=".$id_disp." and id_tipo=".$rowti["id"]."";
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["id"]){
	 				$sqld = "select count(*) as total from sgm_inventario_actuacion_disp where visible=1 and id_disp=".$rowt["id"]." and id_act=".$rowi["id"]."";
					$resultd = mysql_query(convert_sql($sqld));
					$rowd = mysql_fetch_array($resultd);
					if ($rowd["total"] == 0) {
						$color = "red";
						$rowdu["id_user"] = '';
						$a = date("Y");
						$m = date("n");
						$d = date("j");
						$fecha = date("Y-m-d", mktime(0,0,0,$m ,$d, $a))." ".date("H:i:s");
						$rowdu["data"] = '';
					} else {
						$color = "green";
						$sqldu = "select * from sgm_inventario_actuacion_disp where visible=1 and id_disp=".$rowt["id"]." and id_act=".$rowi["id"]."";
						$resultdu = mysql_query(convert_sql($sqldu));
						$rowdu = mysql_fetch_array($resultdu);
						$fecha = '';
					}
					echo "<form action=\"index.php?op=1005&sop=60&ssop=1&id=".$_GET["id"]."&id_act=".$rowi["id"]."&id_disp=".$rowt["id"]."\" method=\"post\">";
					echo "<tr style=\"background-color:".$color."\">";
						echo "<td></td>";
						echo "<td style=\"vertical-align:top;width:150px;\">".$rowi["nombre"]."</td>";
						echo "<td style=\"vertical-align:top;width:150px;\">".$rowt["nombre"]."</td>";
						echo "<td style=\"color:black;text-align:left;\"><input type=\"Text\" name=\"data\" value=\"".$rowdu["data"].$fecha."\" style=\"width:150px\"></td>";
						$sqluu = "select * from sgm_users where id=".$rowdu["id_user"]."";
						$resultuu = mysql_query(convert_sql($sqluu));
						$rowuu = mysql_fetch_array($resultuu);
						echo "<td style=\"vertical-align:top;text-align:center;width:150px;\">".$rowuu["usuario"]."</td>";
						if ($rowd["total"] == 0){
							echo "<td><input type=\"Submit\" value=\"".$Echo."\" style=\"width:100px\"></td>";
							echo "<input type=\"Hidden\" name=\"mod\" value=\"0\">";
						} else {
							echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
							echo "<input type=\"Hidden\" name=\"mod\" value=\"1\">";
						}
					echo "</tr>";
					echo "</form>";
				}
			}
		}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 70){
		if ($ssoption == 3) {
			$sql = "delete from sgm_inventario_relacion WHERE (id_disp1=".$_GET["id_disp"]." and id_disp2=".$_GET["id"].") or (id_disp2=".$_GET["id_disp"]." and id_disp1=".$_GET["id"].")";
			mysql_query(convert_sql($sql));
		}
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=75&id=".$_GET["id"]."\" style=\"color:white;\">".$Ver." ".$Esquema."</a>";
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
		$resulti = mysql_query(convert_sql($sqli));
		while ($rowi = mysql_fetch_array($resulti)) {
			if ($rowi["id_disp1"] == $_GET["id"]) {$id_disp = $rowi["id_disp2"];}
			if ($rowi["id_disp2"] == $_GET["id"]) {$id_disp = $rowi["id_disp1"];}
			$sql = "select * from sgm_inventario where visible=1 and id=".$id_disp."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<tr>";
				echo "<td style=\"text-align:center;vertical-align:top;\"><a href=\"index.php?op=1005&sop=71&id=".$_GET["id"]."&id_disp=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				$sqlt = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]." order by tipo";
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				echo "<td style=\"vertical-align:top;width:150px;\"\">".$rowt["tipo"]."</td>";
				echo "<td style=\"vertical-align:top;width:150px;\"><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
				echo "<td><table>";
					$sqla = "select * from sgm_inventario_tipo_atributo where visible=1 and id_tipo=".$row["id_tipo"]." order by atributo";
					$resulta = mysql_query(convert_sql($sqla));
					while ($rowa = mysql_fetch_array($resulta)){
						echo "<tr><td style=\"width:150px;vertical-align:top\">".$rowa["atributo"]."</td>";
						$sqlda = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and id_atribut=".$rowa["id"]." and id_inventario=".$row["id"]."";
						$resultda = mysql_query(convert_sql($sqlda));
						while ($rowda = mysql_fetch_array($resultda)){
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

	if ($soption == 71) {
		echo "<center>";
		echo "¿Seguro que desea eliminar este archivo?";
		echo "<br><br><a href=\"index.php?op=1005&sop=70&ssop=3&id=".$_GET["id"]."&id_disp=".$_GET["id_disp"]."\">[ SI ]</a><a href=\"index.php?op=1005&sop=70&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 75){
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=70&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<strong>".$Esquema." : </strong><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
		$sql0 = "select * from sgm_inventario where visible=1 and id=".$_GET["id"]."";
		$result0 = mysql_query(convert_sql($sql0));
		$row0 = mysql_fetch_array($result0);
		$id = $row0["id"];
		echo "<tr><td><strong>".$row["nombre"]."</strong></td></tr>";
		echo "</table><br><br>";
		echo "<table>";
			$sqli = "select * from sgm_inventario_relacion where visible=1 and (id_disp1=".$_GET["id"]." or id_disp2=".$_GET["id"].")";
			$resulti = mysql_query(convert_sql($sqli));
			while ($rowi = mysql_fetch_array($resulti)) {
				if ($rowi["id_disp1"] == $_GET["id"]) {$id_disp = $rowi["id_disp2"];}
				if ($rowi["id_disp2"] == $_GET["id"]) {$id_disp = $rowi["id_disp1"];}
				$sql = "select * from sgm_inventario where visible=1 and id=".$id_disp."";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				if ($row["id"]){
					echo "<tr>";
						$id = $id.",".$row["id"];
						$sqlt = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]."";
						$resultt = mysql_query(convert_sql($sqlt));
						$rowt = mysql_fetch_array($resultt);
					if (($ssoption == 1) and ($row["id"] == $_GET["id_disp"])){
						echo "<td>";
							echo "<table>";
							$sqlii = "select * from sgm_inventario_relacion where visible=1 and (id_disp2=".$_GET["id_disp"]." or id_disp1=".$_GET["id_disp"].")";
							$resultii = mysql_query(convert_sql($sqlii));
							while ($rowii = mysql_fetch_array($resultii)) {
								if ($rowii["id_disp1"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp2"];}
								if ($rowii["id_disp2"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp1"];}
								$sqltx = "select * from sgm_inventario_tipo where visible=1 and orden>".$rowt["orden"]."";
								$resulttx = mysql_query(convert_sql($sqltx));
								while ($rowtx = mysql_fetch_array($resulttx)) {
									$sqlx = "select * from sgm_inventario where visible=1 and id=".$id_disp2." and id NOT IN (".$id.") and id_tipo=".$rowtx["id"];
									$resultx = mysql_query(convert_sql($sqlx));
									$rowx = mysql_fetch_array($resultx);
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
							$resultii = mysql_query(convert_sql($sqlii));
							while ($rowii = mysql_fetch_array($resultii)) {
								if ($rowii["id_disp1"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp2"];}
								if ($rowii["id_disp2"] == $_GET["id_disp"]) {$id_disp2 = $rowii["id_disp1"];}
								$sqltx = "select * from sgm_inventario_tipo where visible=1 and orden<".$rowt["orden"]."";
								$resulttx = mysql_query(convert_sql($sqltx));
								while ($rowtx = mysql_fetch_array($resulttx)) {
									$sqlx = "select * from sgm_inventario where visible=1 and id=".$id_disp2." and id NOT IN (".$id.") and id_tipo=".$rowtx["id"];
									$resultx = mysql_query(convert_sql($sqlx));
									$rowx = mysql_fetch_array($resultx);
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

	if ($soption == 80){
		if ($ssoption == 1) {
			$sql = "insert into sgm_inventario_relacion (id_disp1,id_disp2) ";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id"]."";
			$sql = $sql.",".$_GET["id_disp"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($_GET["id"]){
			echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1005&sop=70&id=".$_GET["id"]."\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
			echo "</tr></table>";
		}
		echo "<strong>".$Buscar." ".$Dispositivo." : </strong><br><br>";
		echo "<form action=\"index.php?op=1005&sop=80&id=".$_GET["id"]."\" method=\"post\">";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Tipo."</td>";
				echo "<td>".$Nombre."</td>";
				echo "<td>".$Datos."</td>";
			echo "</tr>";
			echo "<tr>";
			$sqlx = "select * from sgm_inventario where visible=1 and id=".$_GET["id_disp"]."";
			$resultx = mysql_query(convert_sql($sqlx));
			$rowx = mysql_fetch_array($resultx);
				echo "<td><select style=\"width:250px\" name=\"id_tipo\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select * from sgm_inventario_tipo where visible=1 order by tipo";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						if ($_POST["id_tipo"] == $row["id"]){
							echo "<option value=\"".$row["id"]."\" selected>".$row["tipo"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["tipo"]."</option>";
						}
					}
				echo "</td>";
				echo "<td style=\"color:black;text-align:left;width:250px\"><input type=\"Text\" name=\"nom\" value=\"".$_POST["nom"]."\" style=\"width:250px\"></td>";
				echo "<td style=\"color:black;text-align:left;width:250px\"><input type=\"Text\" name=\"dada\" value=\"".$_POST["dada"]."\" style=\"width:250px\"></td>";
				echo "<td><input type=\"Submit\" value=\"Buscar\" style=\"width:150px\"></td>";
			echo "</tr>";
		echo "</form>";
		echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td>".$Tipo."</td>";
			echo "<td>".$Nombre."</td>";
			echo "<td><table><tr><td style=\"width:150px;\">".$Atributos."</td>";
			echo "<td style=\"width:150px;\">".$Datos."</td></tr></table></td>";
		echo "</tr>";
		if ($_POST["dada"] or $_POST["nom"] or $_POST["id_tipo"]) {$sqli = "select * from sgm_inventario where visible=1";}
		if ($_POST["dada"]) {
			$sqldada = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and dada like '%".$_POST["dada"]."%'";
			$resultdada = mysql_query(convert_sql($sqldada));
			$rowdada = mysql_fetch_array($resultdada);
			$sqli = $sqli." and id=".$rowdada["id_inventario"]."";
		}
		if ($_POST["nom"]) {
			$sqli = $sqli." and nombre like '%".$_POST["nom"]."%'";
		}
		if ($_POST["id_tipo"]) {
			$sqli = $sqli." and id_tipo=".$_POST["id_tipo"]."";
		}
			$resulti = mysql_query(convert_sql($sqli));
			while ($rowi = mysql_fetch_array($resulti)){
				echo "<tr style=\"border-bottom : 1px solid black;\">";
					echo "<form action=\"index.php?op=1005&sop=80&ssop=1&id=".$_GET["id"]."&id_disp=".$rowi["id"]."\" method=\"post\">";
					$sqlt = "select * from sgm_inventario_tipo where visible=1 and id=".$rowi["id_tipo"]." order by tipo";
					$resultt = mysql_query(convert_sql($sqlt));
					$rowt = mysql_fetch_array($resultt);
					echo "<td style=\"vertical-align:top\">".$rowt["tipo"]."</td>";
					echo "<td style=\"vertical-align:top\"><a href=\"index.php?op=1005&sop=1&id=".$rowi["id"]."\">".$rowi["nombre"]."</a></td>";
					echo "<td><table>";
						$sqla = "select * from sgm_inventario_tipo_atributo where visible=1 and id_tipo=".$rowi["id_tipo"]." order by atributo";
						$resulta = mysql_query(convert_sql($sqla));
						while ($rowa = mysql_fetch_array($resulta)){
							echo "<tr><td style=\"width:150px;\">".$rowa["atributo"]."</td>";
							$sqlda = "select * from sgm_inventario_tipo_atributo_dada where visible=1 and id_atribut=".$rowa["id"]." and id_inventario=".$rowi["id"]."";
							$resultda = mysql_query(convert_sql($sqlda));
							while ($rowda = mysql_fetch_array($resultda)){
								echo "<td style=\"width:150px;\">".$rowda["dada"]."</td></tr>";
							}
						}
					echo "</table></td>";
					$sqlx = "select count(*) as total from sgm_inventario_relacion where visible=1 and ((id_disp1=".$_GET["id"]." and id_disp2=".$rowi["id"].") or (id_disp1=".$rowi["id"]." and id_disp2=".$_GET["id"]."))";
					$resultx = mysql_query(convert_sql($sqlx));
					$rowx = mysql_fetch_array($resultx);
					if (($rowx["total"] == 0) and ($_GET["id"])){
						echo "<td><input type=\"Submit\" value=\"".$Relacionar."\" style=\"width:150px\"></td>";
					} else { echo "<td></td>"; }
					echo "<input type=\"Hidden\" name=\"nom\" value=\"".$_POST["nom"]."\">";
					echo "<input type=\"Hidden\" name=\"id_tipo\" value=\"".$_POST["id_tipo"]."\">";
					echo "<input type=\"Hidden\" name=\"dada\" value=\"".$_POST["dada"]."\">";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 90) {
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
			echo "<br><br><a href=\"index.php?op=1005&sop=90&ssop=1002&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"]."\">[ SI ]</a><a href=\"index.php?op=1008&sop=290&id=".$_GET["id"]."\">[ NO ]</a>";
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
						echo "<table cellpadding=\"0\" cellspacing=\"0\">";
						echo "<tr style=\"background-color:silver\">";
							echo "<td style=\"width:100px\">".$Tipo."</td>";
							echo "<td style=\"width:100px\">".$Nombre."</td>";
							echo "<td style=\"width:100px\">".$Tamano."</td>";
							echo "<td style=\"width:100px\"><em>".$Eliminar."</em></td>";
						echo "</tr>";
						while ($row = mysql_fetch_array($result)) {
							$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and id_client=".$_GET["id"];
							$resultele = mysql_query(convert_sql($sqlele));
							while ($rowele = mysql_fetch_array($resultele)) {
								echo "<tr><td>".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/files/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong></td>";
								echo "<td>".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td><a href=\"index.php?op=1005&sop=90&ssop=1001&id=".$_GET["id"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
							}
						}
						echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>".$Formulario." de ".$envio." de ".$Archivos." :</strong><br><br>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1005&sop=90&ssop=1000&id=".$_GET["id"]."\" method=\"post\">";
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

	if (($soption == 100)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$sql = "update sgm_inventario_tipo set ";
			$sql = $sql."tipo='".comillas($_POST["tipo"])."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$sql = "select * from sgm_inventario_tipo order by orden desc";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$orden = $row["orden"]+1;
			$sql = "insert into sgm_inventario_tipo (tipo,orden) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["tipo"])."'";
			$sql = $sql.",".$orden."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_inventario set ";
			$sql = $sql."id_tipo=0";
			$sql = $sql." WHERE id_tipo=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "delete from sgm_inventario_tipo WHERE id=".$_GET["id"];
			mysql_query(convert_sql($sql));
		}
		if ((($ssoption == 4) or ($ssoption == 5)) AND ($admin == true)) {
			$sql = "select * from sgm_inventario_tipo where id=".$_GET["id"]."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($ssoption == 4) {$orden = $row["orden"]-1;}
			if ($ssoption == 5) {$orden = $row["orden"]+1;}
			$sql2 = "select * from sgm_inventario_tipo where orden=".$orden."";
			$result2 = mysql_query(convert_sql($sql2));
			$row2 = mysql_fetch_array($result2);
			$sql1 = "update sgm_inventario_tipo set ";
			$sql1 = $sql1."orden=".$orden;
			$sql1 = $sql1." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql1));
			$sql3 = "update sgm_inventario_tipo set ";
			$sql3 = $sql3."orden= ".$row["orden"];
			$sql3 = $sql3." WHERE id=".$row2["id"]."";
			mysql_query(convert_sql($sql3));
		}
		echo "<strong>".$Administracion." de ".$Tipos." de ".$Dispositivo." :</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=1000\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<form action=\"index.php?op=1005&sop=100&ssop=2\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Tipo."</td>";
				echo "<td style=\"text-align:center;\">".$Orden."</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"tipo\"></td>";
				echo "<td></td>";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select * from sgm_inventario_tipo order by orden";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=101&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1005&sop=100&ssop=1&id=".$row["id"]."\" method=\"post\">";
					echo "<td>&nbsp;<input type=\"text\" value=\"".$row["tipo"]."\" style=\"width:200px\" name=\"tipo\"></td>";
					echo "<td><a href=\"index.php?op=1005&sop=100&ssop=4&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/arrow_up.png\" border=\"0\"></a>";
					echo "<a href=\"index.php?op=1005&sop=100&ssop=5&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/arrow_down.png\" border=\"0\"></a></td>";
					echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "<td>";
						echo "<a href=\"index.php?op=1005&sop=110&id=".$row["id"]."\">&nbsp;".$Atributos."</a>";
					echo "</td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption ==101) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este tipo? (Todos los dispositivos con este tipo quedarán pendientes de asignación de tipo)";
		echo "<br><br><a href=\"index.php?op=1005&sop=100&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1005&sop=100\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 110)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$sql = "update sgm_inventario_tipo_atributo set ";
			$sql = $sql."atributo='".comillas($_POST["atributo"])."'";
			$sql = $sql." WHERE id=".$_GET["id_atri"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$sql = "insert into sgm_inventario_tipo_atributo (atributo, id_tipo) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["atributo"])."'";
			$sql = $sql.",".$_GET["id"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "delete from sgm_inventario_tipo_atributo WHERE id=".$_GET["id_atri"];
			mysql_query(convert_sql($sql));
		}
		$sqlx = "select * from sgm_inventario_tipo where id=".$_GET["id"]."";
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);
		echo "<strong>".$Atributos." del ".$Dispositivo." : ".$rowx["tipo"]."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=100\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<form action=\"index.php?op=1005&sop=110&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Atributo."</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"atributo\"></td>";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select * from sgm_inventario_tipo_atributo where id_tipo=".$_GET["id"]." order by atributo";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=111&id=".$_GET["id"]."&id_atri=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1005&sop=110&ssop=1&id=".$_GET["id"]."&id_atri=".$row["id"]."\" method=\"post\">";
					echo "<td>&nbsp;<input type=\"text\" value=\"".$row["atributo"]."\" style=\"width:200px\" name=\"atributo\"></td>";
					echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption ==111) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este tipo? (Todos los dispositivos con este tipo quedarán pendientes de asignación de tipo)";
		echo "<br><br><a href=\"index.php?op=1005&sop=110&ssop=3&id=".$_GET["id"]."&id_atri=".$_GET["id_atri"]."\">[ SI ]</a><a href=\"index.php?op=1005&sop=110&id=".$_GET["id"]."\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 120)) {
		if (($ssoption == 1) AND ($admin == true)) {
			$sql = "update sgm_inventario_actuacion set ";
			$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
			$sql = $sql.", id_disp=".$_POST["id_disp"]."";
			$sql = $sql.", parada=".$_POST["parada"]."";
			$sql = $sql.", duracion=".$_POST["duracion"]."";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 2) AND ($admin == true)) {
			$sql = "insert into sgm_inventario_actuacion (nombre,id_disp,parada,duracion) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["nombre"])."'";
			$sql = $sql.",".$_POST["id_disp"]."";
			$sql = $sql.",".$_POST["parada"]."";
			$sql = $sql.",".$_POST["duracion"]."";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 3) AND ($admin == true)) {
			$sql = "update sgm_inventario_actuacion set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		echo "<strong>".$Actuaciones." en los ".$Dispositivo." :</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=1000\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<form action=\"index.php?op=1005&sop=120&ssop=2\" method=\"post\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center;\">".$Actuacion."</td>";
				echo "<td style=\"text-align:center;\">".$Dispositivo."</td>";
				echo "<td style=\"text-align:center;\">".$Parada."</td>";
				echo "<td style=\"text-align:center;\">".$Duracion."</td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"nombre\"></td>";
					echo "<td>&nbsp;<select style=\"width:250px\" name=\"id_disp\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select * from sgm_inventario where visible=1 order by nombre";
						$resultt = mysql_query(convert_sql($sqlt));
						while ($rowt = mysql_fetch_array($resultt)) {
								echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
						}
					echo "</select></td>";
					echo "<td>&nbsp;<select style=\"width:50px\" name=\"parada\">";
						echo "<option value=\"0\">NO</option>";
						echo "<option value=\"1\">SI</option>";
					echo "</select></td>";
					echo "<td>&nbsp;<input type=\"text\" style=\"width:50px\" name=\"duracion\">";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "</form>";
			$sql = "select * from sgm_inventario_actuacion where visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1005&sop=121&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
					echo "<form action=\"index.php?op=1005&sop=120&ssop=1&id=".$row["id"]."\" method=\"post\">";
					echo "<td>&nbsp;<input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:200px\" name=\"nombre\"></td>";
					echo "<td>&nbsp;<select style=\"width:250px\" name=\"id_disp\">";
						echo "<option value=\"0\">-</option>";
						$sqlt = "select * from sgm_inventario where visible=1 order by nombre";
						$resultt = mysql_query(convert_sql($sqlt));
						while ($rowt = mysql_fetch_array($resultt)) {
							if ($row["id_disp"] == $rowt["id"]){
								echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td>&nbsp;<select style=\"width:50px\" name=\"parada\">";
						if ($row["parada"] == 0){
							echo "<option value=\"0\" selected>NO</option>";
							echo "<option value=\"1\">SI</option>";
						} else {
							echo "<option value=\"0\">NO</option>";
							echo "<option value=\"1\" selected>SI</option>";
						}
					echo "</select></td>";
					echo "<td>&nbsp;<input type=\"text\" value=\"".$row["duracion"]."\" style=\"width:50px\" name=\"duracion\"></td>";
					echo "<td>&nbsp;<input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 121) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar esta actuación?";
		echo "<br><br><a href=\"index.php?op=1005&sop=120&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1005&sop=120\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 300) {
		echo "<strong>".$Actuaciones." ".$Pendientes." :</strong>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center;\">".$Actuacion."</td>";
				echo "<td style=\"text-align:center;\">".$Dispositivo."</td>";
				echo "<td style=\"text-align:center;\">".$Echo." / ".$Total."</td>";
				echo "<td style=\"text-align:center;\">".$Duracion." ".$Echo." / ".$Duracion." ".$Total."</td>";
			echo "</tr>";
			$total1 = 0;
			$total2 = 0;
			$sql = "select * from sgm_inventario_actuacion where visible=1 order by nombre";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$total = 0;
				echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td style=\"width:200px\">".$row["nombre"]."</td>";
					$sqlt = "select * from sgm_inventario where visible=1 and id=".$row["id_disp"];
					$resultt = mysql_query(convert_sql($sqlt));
					$rowt = mysql_fetch_array($resultt);
					echo "<td style=\"width:200px\">".$rowt["nombre"]."</td>";
					$sqla = "select count(*) as total from sgm_inventario_actuacion_disp where visible=1 and id_act=".$row["id"]."";
					$resulta = mysql_query(convert_sql($sqla));
					$rowa = mysql_fetch_array($resulta);
					$sqlr = "select * from sgm_inventario_relacion where visible=1 and ((id_disp1=".$rowt["id"].") or (id_disp2=".$rowt["id"]."))";
					$resultr = mysql_query(convert_sql($sqlr));
					while ($rowr = mysql_fetch_array($resultr)) {
						if ($rowr["id_disp1"] == $rowt["id"]){ $id_disp = $rowr["id_disp2"]; } else { $id_disp = $rowr["id_disp1"]; }
						$sqltip = "select * from sgm_inventario_tipo where visible=1 and id=".$rowt["id_tipo"];
						$resulttip = mysql_query(convert_sql($sqltip));
						$rowtip  = mysql_fetch_array($resulttip);
						$sqlti = "select * from sgm_inventario_tipo where visible=1 and orden < ".$rowtip["orden"]."";
						$resultti = mysql_query(convert_sql($sqlti));
						$rowti = mysql_fetch_array($resultti);
						$sqld = "select * from sgm_inventario where visible=1 and id=".$id_disp." and id_tipo=".$rowti["id"]."";
						$resultd = mysql_query(convert_sql($sqld));
						$rowd = mysql_fetch_array($resultd);
						if ($rowd["id"]){ $total = $total+1; }
					}
					echo "<td style=\"width:100px;text-align:center;\">".$rowa["total"]."/".$total."</td>";
					$duracion = $rowa["total"] * $row["duracion"];
					$duracion_total = $total * $row["duracion"];
					echo "<td style=\"width:200px;text-align:center;\">".$duracion."/".$duracion_total."</td>";
					echo "<td>";
						echo "<a href=\"index.php?op=1005&sop=310&id=".$row["id"]."\">&nbsp;".$Detalles."</a>";
					echo "</td>";
				echo "</tr>";
				$total1 = $total1+$duracion;
				$total2 = $total2+$duracion_total;
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr style=\"background-color:silver\">";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:left;\"><strong>".$Total."</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td style=\"text-align:center;\">".$total1." / ".$total2."</td>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 310) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_inventario_actuacion_disp (id_act,id_disp,id_user,data)";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id_act"]."";
			$sql = $sql.",".$_GET["id_disp"];
			$sql = $sql.",".$userid."";
			$sql = $sql.",'".$xfecha."'";
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
		$sqla = "select * from sgm_inventario_actuacion where visible=1 and id=".$_GET["id"]."";
		$resulta = mysql_query(convert_sql($sqla));
		$rowa = mysql_fetch_array($resulta);
		echo "<strong>".$Actuacion." : ".$rowa["nombre"]."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1005&sop=300\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td>&nbsp;</td>";
				echo "<td style=\"text-align:center;\">".$Dispositivo."</td>";
				echo "<td style=\"text-align:center;\">".$Dispositivo." ".$Relacionado."</td>";
				echo "<td style=\"text-align:center;\">".$Estado."</td>";
			echo "</tr>";
			$sql = "select * from sgm_inventario where visible=1 and id=".$rowa["id_disp"]."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			$sqltip = "select * from sgm_inventario_tipo where visible=1 and id=".$row["id_tipo"]."";
			$resulttip = mysql_query(convert_sql($sqltip));
			$rowtip = mysql_fetch_array($resulttip);
			$sqlr = "select * from sgm_inventario_relacion where visible=1 and ((id_disp1=".$rowa["id_disp"].") or (id_disp2=".$rowa["id_disp"]."))";
			$resultr = mysql_query(convert_sql($sqlr));
			while ($rowr = mysql_fetch_array($resultr)) {
				if ($rowr["id_disp1"] == $row["id"]){ $id_disp = $rowr["id_disp2"]; } else { $id_disp = $rowr["id_disp1"]; }
				$sqlti = "select * from sgm_inventario_tipo where visible=1 and orden < ".$rowtip["orden"]."";
				$resultti = mysql_query(convert_sql($sqlti));
				$rowti = mysql_fetch_array($resultti);
				$sqlt = "select * from sgm_inventario where visible=1 and id=".$id_disp." and id_tipo=".$rowti["id"]."";
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["id"]){
	 				$sqld = "select count(*) as total from sgm_inventario_actuacion_disp where visible=1 and id_disp=".$rowt["id"]." and id_act=".$rowa["id"]."";
					$resultd = mysql_query(convert_sql($sqld));
					$rowd = mysql_fetch_array($resultd);
					if ($rowd["total"] == 0) {$color = "red"; $estado = 'Pendiente'; } else { $color = "green"; $estado = 'Echo'; }
					echo "<form action=\"index.php?op=1005&sop=310&ssop=1&id=".$_GET["id"]."&id_act=".$rowa["id"]."&id_disp=".$rowt["id"]."\" method=\"post\">";
					echo "<tr style=\"background-color:".$color."\">";
						echo "<td></td>";
						echo "<td style=\"width:150px;\"><a href=\"index.php?op=1005&sop=1&id=".$row["id"]."\" style=\"color:white;\">".$row["nombre"]."</a></td>";
						echo "<td style=\"width:150px;\"><a href=\"index.php?op=1005&sop=1&id=".$rowt["id"]."\" style=\"color:white;\">".$rowt["nombre"]."</a></td>";
						echo "<td style=\"width:100px\">".$estado."</td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 1000) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1005&sop=100\" style=\"color:white;\">".$Tipos."</a>";
				echo "</td>";
				echo "<td style=\"width:150px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1005&sop=120\" style=\"color:white;\">".$Actuaciones."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}



	echo "</td></tr></table><br>";
}

function mostra_relacio($id, $ides, $ssoption, $orden)
{ 
	global $db;
}


?>
