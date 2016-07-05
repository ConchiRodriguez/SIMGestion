<?php$autorizado = autorizado($userid,$option);$admin = admin($userid,$option);if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }if (($option == 1001) AND ($autorizado == true)) {	echo "<table class=\"principal\">";		echo"<tr>";			echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";				echo "<h4>".$Contenido."</h4>";			echo "</td><td style=\"width:85%;vertical-align:top;text-align:left;\">";				echo "<table>";					echo "<tr>";						if (($soption == 0) or ($_GET["id_tipo"] != 0)) {$class = "menu_select";} else {$class = "menu";}						echo "<td class=".$class."><a href=\"index.php?op=1001&sop=0\" class=".$class.">".$Contenido."</a></td>";						if ($soption == 100) {$class = "menu_select";} else {$class = "menu";}						echo "<td class=".$class."><a href=\"index.php?op=1001&sop=100&id=0\" class=".$class.">".$Anadir." ".$Contenido."</a></td>";						if (($soption >= 500) and ($soption < 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}						echo "<td class=".$class."><a href=\"index.php?op=1001&sop=500\" class=".$class.">".$Administrar."</a></td>";					echo "</tr>";				echo "</table>";			echo "</td>";		echo "</tr>";	echo "</table><br>";	echo "<table  class=\"principal\">";		echo "<tr>";			echo "<td style=\"width:100%;vertical-align:top;text-align:left;\">";	if ($soption == 0) {		if ($ssoption == 1) {			$camposInsert = "id_autor,fecha_creacion,fecha_publicacion,id_idioma,titulo,contenido";			$datosInsert = array($userid,date('U'),$_POST["fecha_publicacion"],$_POST["id_idioma"],comillas($_POST["titulo"]),comillas($_POST["contenido"]));			insertFunction ("sim_contenidos",$camposInsert,$datosInsert);		}		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";#			$sqlg = "select * from sim_contenidos_categoria where visibe=1";#			$resultg = mysqli_query($dbhandle,convertSQL($sqlg));#			while ($rowg = mysql_fetch_array($resultg)) {#				echo "<tr><td><strong>".$rowg["categoria"]."</strong></td></tr>";#				$sqlg2 = "select * from sim_contenidos where visible=1 and id in (select id_contenido from sim_contenidos_rel_categoria where id_categoria=".$rowg["id"].")";				$sqlg2 = "select * from sim_contenidos where visible=1";				$resultg2 = mysqli_query($dbhandle,convertSQL($sqlg2));				while ($rowg2 = mysqli_fetch_array($resultg2)){					$sqlg3 = "select * from sgm_idiomas WHERE id=".$rowg["id_idioma"];					$resultg3 = mysql_query(convertSQL($sqlg3));					$rowg3 = mysql_fetch_array($resultg3);					echo "<tr>";						echo "<td>".$rowg3["idioma"]."-".$rowg2["fecha_publicacion"]."-<a href=\"index.php?op=1001&sop=100&id=".$rowg2["id"]."\">".$rowg2["titulo"]."</a></td>";					echo "</tr>";				}#			}		echo "</table>";	}	if ($soption == 500) {		if ($admin == true) {			$ruta_botons = array("op=1001&sop=510","op=1001&sop=520","op=1001&sop=530","op=1001&sop=540");			$texto = array($Categorias,$Etiquetas,$Redes_Sociales,$Medios);			echo boton($ruta_botons,$texto);		}		if ($admin == false) {			echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";		}	}	if (($soption == 510) AND ($admin == true)) {		if (($ssoption == 1) AND ($admin == true)) {			$camposInsert = "categoria";			$datosInsert = array(comillas($_POST["categoria"]));			insertFunction ("sim_contenidos_categorias",$camposInsert,$datosInsert);		}		if (($ssoption == 2) AND ($admin == true)) {			$camposUpdate = array("categoria");			$datosUpdate = array(comillas($_POST["categoria"]));			updateFunction ("sim_contenidos_categorias",$_GET["id"],$camposUpdate,$datosUpdate);		}		if (($ssoption == 3) AND ($admin == true)) {			$sql = "select id from sim_contenidos_rel_categoria where id_categoria=".$_GET["id"];			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				deleteFunction ("sim_contenidos_rel_categoria",$row["id"]);			}			deleteFunction ("sim_contenidos_categorias",$_GET["id"]);		}		echo "<h4>".$Categorias." :</h4>";		echo boton(array("op=1001&sop=500"),array("&laquo; ".$Volver));		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";			echo "<form action=\"index.php?op=1001&sop=510&ssop=1\" method=\"post\">";			echo "<tr style=\"background-color:silver\">";				echo "<th>".$Eliminar."</td>";				echo "<th>".$Categoria."</th>";				echo "<th></th>";			echo "</tr><tr>";				echo "<td></td>";				echo "<td><input type=\"text\" style=\"width:200px\" name=\"categoria\" required></td>";				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";			echo "</tr>";			echo "<tr><td>&nbsp;</td></tr>";			echo "</form>";			$sql = "select id,categoria from sim_contenidos_categorias order by categoria";			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				echo "<tr>";					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1001&sop=512&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";					echo "<form action=\"index.php?op=1001&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";					echo "<td><input type=\"text\" value=\"".$row["categoria"]."\" style=\"width:200px\" name=\"categoria\" required></td>";					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";					echo "</form>";				echo "</tr>";			}		echo "</table>";	}	if (($soption == 512) AND ($admin == true)) {		echo "<center>";		echo "<br><br>".$pregunta_eliminar;		echo boton(array("op=1001&sop=510&ssop=3&id=".$_GET["id"],"op=1001&sop=510"),array($Si,$No));		echo "</center>";	}	if (($soption == 520) AND ($admin == true)) {		if (($ssoption == 1) AND ($admin == true)) {			$camposInsert = "etiqueta";			$datosInsert = array(comillas($_POST["etiqueta"]));			insertFunction ("sim_contenidos_etiquetas",$camposInsert,$datosInsert);		}		if (($ssoption == 2) AND ($admin == true)) {			$camposUpdate = array("etiqueta");			$datosUpdate = array(comillas($_POST["etiqueta"]));			updateFunction ("sim_contenidos_etiquetas",$_GET["id"],$camposUpdate,$datosUpdate);		}		if (($ssoption == 3) AND ($admin == true)) {			$sql = "select id from sim_contenidos_rel_etiquetas where id_etiqueta=".$_GET["id"];			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				deleteFunction ("sgm_clients_rel_etiqueta",$row["id"]);			}			deleteFunction ("sim_contenidos_etiquetas",$_GET["id"]);		}		echo "<h4>".$Etiquetas." :</h4>";		echo boton(array("op=1001&sop=500"),array("&laquo; ".$Volver));		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";			echo "<form action=\"index.php?op=1001&sop=520&ssop=1\" method=\"post\">";			echo "<tr style=\"background-color:silver\">";				echo "<th>".$Eliminar."</td>";				echo "<th>".$Etiqueta."</th>";				echo "<th></th>";			echo "</tr><tr>";				echo "<td></td>";				echo "<td><input type=\"text\" style=\"width:200px\" name=\"etiqueta\" required></td>";				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";			echo "</tr>";			echo "<tr><td>&nbsp;</td></tr>";			echo "</form>";			$sql = "select id,etiqueta from sim_contenidos_etiquetas order by etiqueta";			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				echo "<tr>";					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1001&sop=522&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";					echo "<form action=\"index.php?op=1001&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";					echo "<td><input type=\"text\" value=\"".$row["etiqueta"]."\" style=\"width:200px\" name=\"etiqueta\" required></td>";					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";					echo "</form>";				echo "</tr>";			}		echo "</table>";	}	if (($soption == 522) AND ($admin == true)) {		echo "<center>";		echo "<br><br>".$pregunta_eliminar;		echo boton(array("op=1001&sop=520&ssop=3&id=".$_GET["id"],"op=1001&sop=520"),array($Si,$No));		echo "</center>";	}	if (($soption == 530) AND ($admin == true)) {		if (($ssoption == 1) AND ($admin == true)) {			$camposInsert = "red_social";			$datosInsert = array(comillas($_POST["red_social"]));			insertFunction ("sim_contenidos_redes_sociales",$camposInsert,$datosInsert);		}		if (($ssoption == 2) AND ($admin == true)) {			$camposUpdate = array("red_social");			$datosUpdate = array(comillas($_POST["red_social"]));			updateFunction ("sim_contenidos_redes_sociales",$_GET["id"],$camposUpdate,$datosUpdate);		}		if (($ssoption == 3) AND ($admin == true)) {			$sql = "select id from sim_contenidos_rel_redes_sociales where id_red_social=".$_GET["id"];			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				deleteFunction ("sim_contenidos_rel_redes_sociales",$row["id"]);			}			deleteFunction ("sim_contenidos_redes_sociales",$_GET["id"]);		}		echo "<h4>".$Redes_Sociales." :</h4>";		echo boton(array("op=1001&sop=500"),array("&laquo; ".$Volver));		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";			echo "<form action=\"index.php?op=1001&sop=530&ssop=1\" method=\"post\">";			echo "<tr style=\"background-color:silver\">";				echo "<th>".$Eliminar."</td>";				echo "<th>".$Redes_Sociales."</th>";				echo "<th></th>";			echo "</tr><tr>";				echo "<td></td>";				echo "<td><input type=\"text\" style=\"width:200px\" name=\"red_social\" required></td>";				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";			echo "</tr>";			echo "<tr><td>&nbsp;</td></tr>";			echo "</form>";			$sql = "select id,red_social from sim_contenidos_redes_sociales order by red_social";			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				echo "<tr>";					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1001&sop=532&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";					echo "<form action=\"index.php?op=1001&sop=530&ssop=2&id=".$row["id"]."\" method=\"post\">";					echo "<td><input type=\"text\" value=\"".$row["red_social"]."\" style=\"width:200px\" name=\"red_social\" required></td>";					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";					echo "</form>";				echo "</tr>";			}		echo "</table>";	}	if (($soption == 532) AND ($admin == true)) {		echo "<center>";		echo "<br><br>".$pregunta_eliminar;		echo boton(array("op=1001&sop=530&ssop=3&id=".$_GET["id"],"op=1001&sop=530"),array($Si,$No));		echo "</center>";	}	if (($soption == 540) AND ($admin == true)) {		if (($ssoption == 1) AND ($admin == true)) {			$camposInsert = "medio_publicacion";			$datosInsert = array(comillas($_POST["medio_publicacion"]));			insertFunction ("sim_contenidos_medios_publicacion",$camposInsert,$datosInsert);		}		if (($ssoption == 2) AND ($admin == true)) {			$camposUpdate = array("medio_publicacion");			$datosUpdate = array(comillas($_POST["medio_publicacion"]));			updateFunction ("sim_contenidos_medios_publicacion",$_GET["id"],$camposUpdate,$datosUpdate);		}		if (($ssoption == 3) AND ($admin == true)) {			$sql = "select id from sim_contenidos_rel_medios_publicacion where id_medio_publicacion=".$_GET["id"];			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				deleteFunction ("sim_contenidos_rel_medios_publicacion",$row["id"]);			}			deleteFunction ("sim_contenidos_medios_publicacion",$_GET["id"]);		}		echo "<h4>".$Medios." :</h4>";		echo boton(array("op=1001&sop=500"),array("&laquo; ".$Volver));		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";			echo "<form action=\"index.php?op=1001&sop=540&ssop=1\" method=\"post\">";			echo "<tr style=\"background-color:silver\">";				echo "<th>".$Eliminar."</td>";				echo "<th>".$Medios."</th>";				echo "<th></th>";			echo "</tr><tr>";				echo "<td></td>";				echo "<td><input type=\"text\" style=\"width:200px\" name=\"medio_publicacion\" required></td>";				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";			echo "</tr>";			echo "<tr><td>&nbsp;</td></tr>";			echo "</form>";			$sql = "select id,medio_publicacion from sim_contenidos_medios_publicacion order by medio_publicacion";			$result = mysqli_query($dbhandle,convertSQL($sql));			while ($row = mysqli_fetch_array($result)) {				echo "<tr>";					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1001&sop=542&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";					echo "<form action=\"index.php?op=1001&sop=540&ssop=2&id=".$row["id"]."\" method=\"post\">";					echo "<td><input type=\"text\" value=\"".$row["medio_publicacion"]."\" style=\"width:200px\" name=\"medio_publicacion\" required></td>";					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";					echo "</form>";				echo "</tr>";			}		echo "</table>";	}	if (($soption == 542) AND ($admin == true)) {		echo "<center>";		echo "<br><br>".$pregunta_eliminar;		echo boton(array("op=1001&sop=540&ssop=3&id=".$_GET["id"],"op=1001&sop=540"),array($Si,$No));		echo "</center>";	}	if ($soption == 100) {		if ($ssoption == 2) {			$camposUpdate = array("id_autor","fecha_creacion","fecha_publicacion","id_idioma","titulo","contenido");			$datosUpdate = array($userid,date('U'),$_POST["fecha_publicacion"],$_POST["id_idioma"],comillas($_POST["titulo"]),comillas($_POST["contenido"]));			updateFunction ("sim_contenidos",$_GET["id"],$camposUpdate,$datosUpdate);		}		if ($ssoption == 3){			updateFunction ("sim_contenidos",$_GET["id"],array("visible"),array("0"));		}		if ($_GET["id"] > 0) {			$sql = "select * from sgm_clients where id=".$_GET["id"];			$result = mysqli_query($dbhandle,convertSQL($sql));			$row = mysqli_fetch_array($result);			echo "<h4>".$Editar." ".$Contenido."</h4>";			echo "<form action=\"index.php?op=1001&sop=100&ssop=2&id=".$_GET["id"]."\"  method=\"post\">";			$sql = "select * from sim_contenidos where visible=1 and id=".$_GET["id"];			$result = mysqli_query($dbhandle,convertSQL($sql));			$row = mysqli_fetch_array($result);		} 		if ($_GET["id"] <= 0) {			echo "<h4>".$Anadir." ".$Contenido."</h4>";			echo "<form action=\"index.php?op=1001&sop=0&ssop=1\"  method=\"post\">";		}
		echo "<table>";			echo "<tr>";				echo "<td>";					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";						echo "<tr><td>".$Titulo."</td><td><input type=\"Text\" name=\"titulo\" value=\"".$row["titulo"]."\"></td></tr>";						echo "<tr><td style=\"vertical-align:top;\">".$Contenido."</td><td><textarea name=\"contenido\" id=\"mytextarea\">".$row["contenido"]."</textarea></td></tr>";						echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Anadir."\"></td></tr>";						echo "</form>";					echo "</table>";			echo "</td><td style=\"vertical-align:top;\">";
				echo "<option value=\"0\">- Selecciona un grupo -</option>";
				$sql2 = "select * from sgm_news_grupos order by id_idioma";
				$result2 = mysql_query(convertSQL($sql2));
				while ($row2 = mysql_fetch_array($result2)) {
					$sql = "select * from sgm_users_permisos_news WHERE id_news=".$row2["id"]." and id_user=".$userid;
					$result = mysql_query(convertSQL($sql));
					while ($row = mysql_fetch_array($result)) {
						$sql3 = "select * from sgm_idiomas WHERE id=".$row2["id_idioma"];
						$result3 = mysql_query(convertSQL($sql3));
						$row3 = mysql_fetch_array($result3);
							if ($rownew["id_grupo"] == $row2["id"]) {
								echo "<option value=\"".$row2["id"]."\" selected>".$row3["idioma"]." - ".$row2["name"]."</option>";
							} else {
								echo "<option value=\"".$row2["id"]."\">".$row3["idioma"]." - ".$row2["name"]."</option>";
							}
					}
				}
			echo "</select></td></tr>";
			if ($_GET["id_new"] != "") {
				echo "<tr><td>Fecha</td><td style=\"width:400px;\"><table cellspacing=\"0\"><tr><td><input type=\"Text\" style=\"width:180px;\" name=\"fecha\" value=\"".$rownew["fecha"]."\"></td>";
				echo "<td style=\"width:40px;\">Hora</td><td><input type=\"Text\" style=\"width:180px;\" name=\"hora\" value=\"".$rownew["hora"]."\"></td></tr></table></td></tr>";
			} else {				$date = date("Y-m-d");				$hora = date("H:i");				echo "<tr><td>Fecha</td><td style=\"width:400px;\"><table cellspacing=\"0\"><tr><td><input type=\"Text\" style=\"width:180px;\" name=\"fecha\" value=\"".$date."\"></td>";				echo "<td style=\"width:35px;text-align:center;\">Hora</td><td><input type=\"Text\" style=\"width:180px;\" name=\"hora\" value=\"".$hora."\"></td></tr></table></td></tr>";
			}

			if ($_GET["id_new"] != "") {
				if ($rownew["validada"] == 1) { echo "<tr><td></td><td><input type=\"Submit\" value=\"Modificar\" class=\"px150\"></td></tr>";	}
				if ($rownew["validada"] == 0) { echo "<tr><td></td><td><input type=\"Submit\" value=\"Validar Noticia - Ok\" class=\"px150\"></td></tr>"; }
			} else {
				echo "<tr><td></td><td><input type=\"Submit\" value=\"Añadir\" class=\"px150\"></td></tr>";
			}
			echo "</table>";
			echo "</form>";
		if ($_GET["id_new"] != "") {
			echo "<br><br><strong>Elementos a incluir en el contenido:</strong><br><br>";
				echo "<form action=\"index.php?op=1001&sop=15&ssop=2&id_new=".$_GET["id_new"]."\" method=\"post\">";
				$sql = "select * from sgm_news_elementos_tipos order by nombre";
				$result = mysql_query(convertSQL($sql));
				echo "<select name=\"id_elemento\" style=\"width:250px\">";
				while ($row = mysql_fetch_array($result)) {
					$sqlele = "select * from sgm_news_elementos where id_tipo=".$row["id"];
					$resultele = mysql_query(convertSQL($sqlele));
					while ($rowele = mysql_fetch_array($resultele)) {
						echo "<option value=\"".$rowele["id"]."\">".$row["nombre"]." - ".$rowele["name"]."</option>";
					}
				}
				echo "</select>";
				echo "<br><br><input type=\"Submit\" value=\"Incluir Elemento\" style=\"width:250px\">";
				echo "</form>";
				echo "<img src=\"mgestion/pics/icons-mini/error.png\" border=\"0\"> Guarda primero los cambios o se perderán.";
				echo "<br><br><br><strong>Elementos incluidos en el contenido:</strong><br>";
				$sql = "select * from sgm_news_elementos_news where id_new=".$_GET["id_new"];
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					$sqlele = "select * from sgm_news_elementos where id=".$row["id_elemento"];
					$resultele = mysql_query(convertSQL($sqlele));
					$rowele = mysql_fetch_array($resultele);
					if ($rowele["id_tipo"] == 1) {
						echo "<br><a href=\"javascript:emoticon('[img]".$urloriginal."/uploads/".$rowele["name"]."[/img]')\"><img src=\"mgestion/pics/icons-mini/page_white_copy.png\" border=\"0\"></a>";
					} else {
						echo "<br><a href=\"javascript:emoticon('[url]".$urloriginal."/uploads/".$rowele["name"]."[/url]')\"><img src=\"mgestion/pics/icons-mini/page_white_copy.png\" border=\"0\"></a>";
					}
					echo "&nbsp;<a href=\"".$urloriginal."/uploads/".$rowele["name"]."\" target=\"_blank\"><img src=\"mgestion/pics/icons-mini/page_white_find.png\" border=\"0\"></a>";
					echo "&nbsp;<a href=\"index.php?op=1001&sop=16&id_element=".$rowele["id"]."&id_new=".$_GET["id_new"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>";
					echo "&nbsp;".$rowele["name"];
				}
				echo "<br>";
				echo "<br><img src=\"mgestion/pics/icons-mini/page_white_copy.png\" border=\"0\"> Copiar al contenido en el formato correcto.";
				echo "<br><img src=\"mgestion/pics/icons-mini/page_white_find.png\" border=\"0\"> Previsualizar en una ventana nueva.";
				echo "<br><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"> Eliminar, no pide confirmación.";
			}
		echo "</td></tr></table>";
	}

	if ($soption == 16) {
		echo "<center><br><br>¿Seguro que quieres eliminar este elemento?";
		echo "<br><br><a href=\"index.php?op=1001&sop=15&ssop=3&id_element=".$_GET["id_element"]."&id_new=".$_GET["id_new"]."\">[ SI ]</a> <a href=\"index.php?op=1001&sop=15&id_new=".$_GET["id_new"]."\">[ NO ]</a></center>";
	}

	if ($soption == 17) {
		echo "<center><br><br>¿Seguro que quieres eliminar esta noticia?";
		echo "<br><br><a href=\"index.php?op=1001&sop=12&ssop=2&id_new=".$_GET["id_new"]."\">[ SI ]</a> <a href=\"index.php?op=1001&sop=12\">[ NO ]</a></center>";
	}

	if ($soption == 20) {
		#suma lecturas
		$sql8 = "select * from sgm_news_posts WHERE id=".$_GET["id_new"];
		$result8 = mysql_query(convertSQL($sql8));
		$row8 = mysql_fetch_array($result8);
		$visitas = $row8["lecturas"] + 1;

		$sql9 = "update sgm_news_posts set ";
		$sql9 = $sql9."lecturas=".$visitas;
		$sql9 = $sql9." WHERE id=".$_GET["id_new"];
		mysql_query(convertSQL($sql9));
		#final suma lecturas
		$sqlnew = "select * from sgm_news_posts WHERE id=".$_GET["id_new"];
		$resultnew = mysql_query(convertSQL($sqlnew));
		$rownew = mysql_fetch_array($resultnew);
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				if ($_GET["s"] == 21) {
					echo "<a href=\"index.php?op=1001&sop=21&id_grupo=".$_GET["id_grupo"]."\" style=\"color:white;\">&laquo; Volver</a>";
				}
				if ($_GET["s"] == 12) {
					echo "<a href=\"index.php?op=1001&sop=12\" style=\"color:white;\">&laquo; Volver</a>";
				}
				echo "</td>";
		echo "</tr></table>";
		echo "<center><table><tr><td style=\"vertical-align:top;width:500px;text-align:justify\">";
			echo "<br><br>Titular : <strong>\"".$rownew["asunto"]."\"</strong>";
			echo "<br><br> Autor : <em>".buscarnick($rownew["id_user"])."</em>";
			echo "<br> Fecha : <em>".fechalarga($rownew["fecha"])." ".hora($rownew["hora"])."</em>";
			echo "<hr><br><center><strong>\"".$rownew["asunto"]."\"</strong></center><br><br>".verpost($rownew["cuerpo"])."<br><br>";
			$sqlsite = "select * from sgm_news_sites WHERE id=".$rownew["id_site"];
			$resultsite = mysql_query(convertSQL($sqlsite));
			$rowsite = mysql_fetch_array($resultsite);
			echo "<hr>Fuente : ";
			echo "<br><strong><a href=\"".$rowsite["url"]."\" target=\"_blank\">".$rowsite["name"]."</a></strong>";
			if ($rowsite["banner"] != "") {
				echo "<br><a href=\"".$rowsite["url"]."\" target=\"_blank\"><img src=\"pics/banner/".$rowsite["banner"]."\" border=\"0\"></a>";
			}
			else {
				echo "<br><a href=\"".$rowsite["url"]."\" target=\"_blank\">".$rowsite["url"]."</a>";
			}
		echo "</td><td style=\"vertical-align:top;wicth:160px;text-align:center;\">";
				echo "<br><br><br><strong>Elementos incluidos :</strong><br>";
				$sql = "select * from sgm_news_elementos_news where id_new=".$_GET["id_new"];
				$result = mysql_query(convertSQL($sql));
				while ($row = mysql_fetch_array($result)) {
					$sqlele = "select * from sgm_news_elementos where id=".$row["id_elemento"];
					$resultele = mysql_query(convertSQL($sqlele));
					$rowele = mysql_fetch_array($resultele);
					if ($rowele["id_tipo"] == 1) { echo "<br><br><a href=\"uploads/".$rowele["name"]."\" target=\"_blank\"><img src=\"uploads/".$rowele["name"]."\" border=\"0\" width=\"150\" /></a>"; }
					if ($rowele["id_tipo"] == 2) { echo "<br><br><table><tr><td><a href=\"uploads/".$rowele["name"]."\"><img src=\"pics/docs/video.gif\" border=\"0\"/></a></td><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><strong style=\"color:gray\">DESCARGAR VIDEO</strong><br><br>".$rowele["name"]."</a></td></tr></table>"; }
					if ($rowele["id_tipo"] == 3) { echo "<br><br><table><tr><td><a href=\"uploads/".$rowele["name"]."\"><img src=\"pics/docs/doc.gif\" border=\"0\"/></a></td><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><strong style=\"color:gray\">DESCARGAR DOC</strong><br><br>".$rowele["name"]."</a></td></tr></table>"; }
					if ($rowele["id_tipo"] == 4) { echo "<br><br><table><tr><td><a href=\"uploads/".$rowele["name"]."\"><img src=\"pics/docs/pdf.gif\" border=\"0\"/></a></td><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><strong style=\"color:gray\">DESCARGAR PDF</strong><br><br>".$rowele["name"]."</a></td></tr></table>"; }
				}
		echo "</td></tr></table></center>";
	}


	if ($soption == 21) {
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1001&sop=12\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<center><table style=\" border-bottom : 1px solid Black; border-left : 1px solid Black; border-right : 1px solid Black; border-top : 1px solid Black;text-align:left;\" cellpadding=\"10\" cellspacing=\"10\">";
		echo "<tr><td style=\"width:780px;\">";
			echo "<strong>Todos&nbsp;los&nbsp;contenidos&nbsp;publicados&nbsp;en&nbsp;el&nbsp;grupo :</strong>";
			$sqlg = "select * from sgm_news_grupos WHERE id=".$_GET["id_grupo"];
			$resultg = mysql_query(convertSQL($sqlg));
			$rowg = mysql_fetch_array($resultg);
			echo "&nbsp;<strong>\"".$rowg["name"]."\"</strong>";
			$sqlm = "select count(*) as total from sgm_news_posts WHERE id_grupo=".$_GET["id_grupo"]." AND visible=1";
			$resultm = mysql_query(convertSQL($sqlm));
			$rowm = mysql_fetch_array($resultm);
			if ($_GET["page"] == "") { $page = 1; } else { $page = $_GET["page"]; }
			$match4page = 20;
			$pages = ($rowm["total"]/$match4page);
			$y = 1;
			echo "<br>Página ";
			while ( $y < $pages+1){
				if ($page == $y) { echo "[".$y."]"; }
				else { echo "<a href=\"index.php?op=1001&sop=21&page=".$y."&id_grupo=".$_GET["id_grupo"]."\">[".$y."]</a>";}
				$y++;
			}
			$maxup = ($page * $match4page);
			$mindown = ($maxup - $match4page)+1;
			$count = 1;
			echo "<br>";
			$date = getdate(); 
			$sql = "select * from sgm_news_posts WHERE visible=1 AND id_grupo=".$rowg["id"]." ORDER BY fecha DESC,hora DESC";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				if (($count <= $maxup) AND ($count >= $mindown)) {
						echo "<br>";
						echo "&nbsp;&nbsp;<a href=\"index.php?op=1001&sop=17&id_new=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>&nbsp;";
						echo fechalarga($row["fecha"])." ".hora($row["hora"]);
						echo "&nbsp;<a href=\"index.php?op=1001&sop=20&id_new=".$row["id"]."&id_grupo=".$_GET["id_grupo"]."&s=21\"><strong style=\"text-decoration:underline;\">\"".$row["asunto"]."\"</strong></a>";
						echo "&nbsp;".buscarnick($row["id_user"]);
						echo "&nbsp;<a href=\"index.php?op=1001&sop=15&id_new=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" border=\"0\"></a>";
				}
				$count++;
			}
		echo "</td></tr>";
		echo "</table></center>";
	}

	if (($soption == 30) and ($admin == true)) {
		if ($ssoption == 1) {
			$sql = "insert into sgm_news_sites (name,url,banner,showonweb) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($_POST["name"])."'";
			$sql = $sql.",'".$_POST["url"]."'";
			$sql = $sql.",'".$_POST["banner"]."'";
			$sql = $sql.",".$_POST["showonweb"]."";
			$sql = $sql.")";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 2) {
			$sql = "update sgm_news_sites set ";
			$sql = $sql."name='".comillas($_POST["name"])."'";
			$sql = $sql.",url='".$_POST["url"]."'";
			$sql = $sql.",banner='".$_POST["banner"]."'";
			$sql = $sql.",showonweb=".$_POST["showonweb"]."";
			$sql = $sql." WHERE id=".$_POST["id_site"]."";
			mysql_query(convertSQL($sql));
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_news_sites WHERE id=".$_GET["id"];
			mysql_query(convertSQL($sql));
		}

			echo "<strong>Administración de Fuentes para Contenidos :</strong><br><br>";
			echo "<table><tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1001&sop=10\" style=\"color:white;\">&laquo; Volver</a>";
					echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
			echo "<center><table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"text-align:right;\">Id.</td>";
				echo "<td style=\"text-align:right;\">Cont.</td>";
				echo "<td style=\"text-align:left;\">Nombre de la Fuente</td>";
				echo "<td style=\"text-align:left;\">Direccion web de la Fuente</td>";
				echo "<td style=\"text-align:left;\">Banner de la Fuente</td>";
				echo "<td style=\"text-align:center;\">Visible</td>";
				echo "<td style=\"text-align:center;\"></td>";
				echo "<td style=\"text-align:center;\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1001&sop=30&ssop=1\" method=\"post\">";
					echo "<td style=\"text-align:right;\"></td>";
					echo "<td style=\"text-align:right;\"></td>";
					echo "<td style=\"text-align:left;\"><input type=\"Text\" name=\"name\" style=\"width:200px\"></td>";
					echo "<td style=\"text-align:left;\"><input type=\"Text\" name=\"url\" style=\"width:200px\"></td>";
					echo "<td style=\"text-align:left;\"><input type=\"Text\" name=\"banner\" style=\"width:100px\"></td>";
					echo "<td><select name=\"showonweb\" style=\"width:50px\">";
						echo "<option value=\"1\" selected>SI</option>";
						echo "<option value=\"0\">NO</option>";
					echo "</select></td>";
					echo "<td style=\"text-align:left;\"><input type=\"Submit\" style=\"width:100px\" value=\"Añadir\"></td>";
					echo "<td style=\"text-align:center;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_news_sites ORDER BY name";
			$result = mysql_query(convertSQL($sql));
			while ($row = mysql_fetch_array($result)) {
				echo "<form action=\"index.php?op=1001&sop=30&ssop=2\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_site\" value=\"".$row["id"]."\">";
				echo "<tr>";
					echo "<td style=\"text-align:right;\">".$row["id"]."</td>";
						$sqlt = "select count(*) as total from sgm_news_posts where id_site=".$row["id"];
						$resultt = mysql_query(convertSQL($sqlt));
						$rowt = mysql_fetch_array($resultt);
					echo "<td style=\"text-align:right;\">".$rowt["total"]."</td>";
					echo "<td><input type=\"Text\" name=\"name\" value=\"".$row["name"]."\" style=\"width:200px\"></td>";
					echo "<td><input type=\"Text\" name=\"url\" value=\"".$row["url"]."\" style=\"width:200px\"></td>";
					echo "<td><input type=\"Text\" name=\"banner\" value=\"".$row["banner"]."\" style=\"width:100px\"></td>";
					echo "<td><select name=\"showonweb\" style=\"width:50px\">";
						if ($row["showonweb"] == 1) {
							echo "<option value=\"1\" selected>SI</option>";
							echo "<option value=\"0\">NO</option>";
						}
						if ($row["showonweb"] == 0) {
							echo "<option value=\"1\">SI</option>";
							echo "<option value=\"0\" selected>NO</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" style=\"width:100px\" value=\"Modificar\"></td>";
					echo "</form>";
					echo "<td>";
						if (($rowt["total"] == 0) and ($row["blocked"] == 0)) { 
							echo "<a href=\"index.php?op=1001&sop=31&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a>";
						}
					echo "</td>";
				echo "</tr>";
			}
			echo "</table></center>";
	}

	if (($soption == 31) and ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este elemento?";
		echo "<br><br><a href=\"index.php?op=1001&sop=30&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1001&sop=30\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 40) and ($admin == true)) {
		$sql = "select * from sgm_users order by usuario";
		$result = mysql_query(convertSQL($sql));
			echo "<strong>Administración de Usuarios para Contenidos :</strong><br><br>";
			echo "<table><tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
						echo "<a href=\"index.php?op=1001&sop=10\" style=\"color:white;\">&laquo; Volver</a>";
					echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color: Silver;\"><td style=\"width:50px;text-align:center;\"><em>Id.</em></td><td style=\"width:200px;text-align:center;\"><em>Usuario</em></td><td style=\"width:100px;text-align:center;\"><em>Permisos</em></td></tr>";
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;\">".$row["id"]."</td>";
				echo "<td>&nbsp;<strong>".$row["usuario"]."</strong></td>";
				echo "<form action=\"index.php?op=1002&sop=2\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$row["id"]."\">";
				$sqlt = "select count(*) as total from sgm_users_permisos_news where id_user=".$row["id"];
				$resultt = mysql_query(convertSQL($sqlt));
				$rowt = mysql_fetch_array($resultt);
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1001&sop=41&id_user=".$row["id"]."\">";
				if ($total =! 0){echo "<img src=\"mgestion/pics/icons-mini/application_key.png\" border=\"0\"></a></td>";}
				else {echo "<img src=\"mgestion/pics/icons-mini/application_key.png\" border=\"0\"></a></td>";}
			echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 41) and ($admin == true)) {
		if ($ssoption == 1) {
			if ($_POST["permiso"] == 0) {
				$sql = "delete from sgm_users_permisos_news WHERE id_user=".$_GET["id_user"]." and id_news=".$_POST["id_news"];
				mysql_query(convertSQL($sql));
			}
			if ($_POST["permiso"] == 1) {
				$sql = "insert into sgm_users_permisos_news (id_user,id_news) ";
				$sql = $sql."values (";
				$sql = $sql."".$_GET["id_user"]."";
				$sql = $sql.",".$_POST["id_news"]."";
				$sql = $sql.")";
				mysql_query(convertSQL($sql));
			}
		}
		if ($ssoption == 2) {
			$sql = "update sgm_users_permisos_news set ";
			$sql = $sql."admin=".$_POST["admin"]."";
			$sql = $sql." WHERE id_user=".$_GET["id_user"]." and id_news=".$_POST["id_news"];
			mysql_query(convertSQL($sql));
		}

		echo "<strong>Permisos de: ".$row["usuario"]."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1001&sop=40\" style=\"color:white;\">&laquo; Volver</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		$sql = "select * from sgm_users where id=".$_GET["id_user"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$sql = "select * from sgm_news_grupos order by name";
		$result = mysql_query(convertSQL($sql));
		echo "<center><table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver\">";
			echo "<td></td>";
			echo "<td>Permisos</td>";
			echo "<td></td>";
			echo "<td>Admin.</td>";
			echo "<td>Grupo de contenidos</td>";
		echo "</tr>";
		while ($row = mysql_fetch_array($result)) {
			$sqlt = "select count(*) as total from sgm_users_permisos_news where id_user=".$_GET["id_user"]." and id_news=".$row["id"];
			$resultt = mysql_query(convertSQL($sqlt));
			$rowt = mysql_fetch_array($resultt);
			echo "<tr>";
				echo "<form action=\"index.php?op=1001&sop=41&ssop=1&id_user=".$_GET["id_user"]."\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_news\" value=\"".$row["id"]."\">";
				echo "<td><select name=\"permiso\" style=\"width:40px\">";
					if ($rowt["total"] == 1) {
						echo "<option value=\"1\" selected>SI</option>";
						echo "<option value=\"0\">NO</option>";
					}
					if ($rowt["total"] == 0) {
						echo "<option value=\"1\">SI</option>";
						echo "<option value=\"0\" selected>NO</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Cambiar\"></td>";
				echo "</form>";
				if ($rowt["total"] == 1) {
					$sqlx = "select * from sgm_users_permisos_news where id_user=".$_GET["id_user"]." and id_news=".$row["id"];
					$resultx = mysql_query(convertSQL($sqlx));
					$rowx = mysql_fetch_array($resultx);
					echo "<form action=\"index.php?op=1001&sop=41&ssop=2&id_user=".$_GET["id_user"]."\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"id_news\" value=\"".$row["id"]."\">";
					echo "<td><select name=\"admin\" style=\"width:40px\">";
						if ($rowx["admin"] == 1) {
							echo "<option value=\"1\" selected>SI</option>";
							echo "<option value=\"0\">NO</option>";
						}
						if ($rowx["admin"] == 0) {
							echo "<option value=\"1\">SI</option>";
							echo "<option value=\"0\" selected>NO</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"Cambiar\"></td>";
					echo "</form>";
				}
				if ($rowt["total"] == 0) { echo "<td></td><td></td>"; }
				echo "<td>&nbsp;".$row["name"]."</td>";
			echo "</tr>";
		}
		echo "</table></center>";
	}

	if ($soption == 50) {
		if ($ssoption == 3) {
			$sql = "delete from sgm_news_elementos WHERE id=".$_GET["id"];
			mysql_query(convertSQL($sql));
		}
		echo "<strong>Gestión de Elementos.</strong>";
			echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:400px;vertical-align:top;\">";
						echo "<br><br><strong>Listado de Elementos disponibles :</strong>";
						$sql = "select * from sgm_news_elementos_tipos order by nombre";
						$result = mysql_query(convertSQL($sql));
						echo "<table>";
						while ($row = mysql_fetch_array($result)) {
							$sqlele = "select * from sgm_news_elementos where id_tipo=".$row["id"];
							$resultele = mysql_query(convertSQL($sqlele));
							while ($rowele = mysql_fetch_array($resultele)) {
								echo "<tr><td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><strong>".$rowele["name"]."</strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
								echo "<td>&nbsp;<a href=\"index.php?op=1001&sop=52&id=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td></tr>";
							}
						}
						echo "</table>";
				echo "</td><td style=\"width:200px;vertical-align:top;\">";
					echo "<strong>Formulario de envio de Elementos :</strong><br><br>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1001&sop=51\" method=\"post\">";
					echo "<center>";
					echo "<select name=\"id_tipo\" style=\"width:200px\">";
						$sql = "select * from sgm_news_elementos_tipos order by nombre";
						$result = mysql_query(convertSQL($sql));
						while ($row = mysql_fetch_array($result)) {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
						}
					echo "</select>";
					echo "<br><br>";
					echo "<input type=\"file\" name=\"archivo\" size=\"28px\">";
					echo "<br><br><input type=\"submit\" value=\"Subir Elemento\" style=\"width:200px\">";
					echo "</form>";
					echo "</center>";
			echo "</td></tr></table>";
	}

	if ($soption == 51) {
		$archivo_name = $HTTP_POST_FILES['archivo']['name'];
		$archivo_size = $HTTP_POST_FILES['archivo']['size'];
		$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
		$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
		$sql = "select * from sgm_news_elementos_tipos where id=".$HTTP_POST_VARS["id_tipo"];
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		$lim_tamano = $row["limite_kb"]*1000;
		$sqlt = "select count(*) as total from sgm_news_elementos where name='".$archivo_name."'";
		$resultt = mysql_query(convertSQL($sqlt));
		$rowt = mysql_fetch_array($resultt);
		if ($rowt["total"] != 0) {
			echo mensageError("No se puede añadir elemento por que ya existe uno con el mismo nombre.");
		} else {
			if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size <= $lim_tamano)){
			    if (copy ($archivo, "uploads/".$archivo_name)) {
					echo "<center>";
					echo "<h2>Se ha transferido el archivo $archivo_name</h2>";
					echo "<br>Su tamaño es: $archivo_size bytes<br><br>";
					echo "Operación realizada correctamente.";
					echo "<br><br><a href=\"index.php?op=1001&sop=50\">[ Volver ]</a>";
					echo "</center>";
					$sql = "insert into sgm_news_elementos (id_tipo,name,type,size) ";
					$sql = $sql."values (";
					$sql = $sql."".$HTTP_POST_VARS["id_tipo"]."";
					$sql = $sql.",'".$archivo_name."'";
					$sql = $sql.",'".$archivo_type."'";
					$sql = $sql.",".$archivo_size."";
					$sql = $sql.")";
					mysql_query(convertSQL($sql));
	              }
				} else {
				    echo mensageError("<h2>No ha podido transferirse el fichero</h2><br><h3>su tamaño no puede exceder de ".$lim_tamano." bytes</h3>");
			}
		}
	}

	if ($soption == 52) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este elemento?";
		echo "<br><br><a href=\"index.php?op=1001&sop=50&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1001&sop=50\">[ NO ]</a>";
		echo "</center>";
	}


echo "</td></tr></table><br>";
}
?>
