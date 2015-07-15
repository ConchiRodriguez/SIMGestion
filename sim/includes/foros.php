<TABLE WIDTH=766 height="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR><TD background="images/tiling-5_38.jpg" WIDTH=18 HEIGHT=483></TD><TD height="100%"><center><br>
<?php
if ($option == 10) {
if ($user == true) {
	if ($soption == 0) {
		echo "<table style=\"border : 1px solid #AAAAAA;\" cellpadding=\"0\" cellspacing=\"0\">";
		$sql = "select * from sgm_foros_grupos WHERE visible=1 ORDER BY orden";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			echo "<tr><td class=\"inverse\"></td><td class=\"inverse\"><strong>".$row["titulo"]."</strong>";
			if  ($row["descripcion"] != "") { echo " (".$row["descripcion"].")</td>"; } else { echo "</td>"; }
			echo "<td class=\"inverse\" style=\"text-align : center;\">Temas</td><td class=\"inverse\" style=\"text-align : center;\">Mensajes</td><td class=\"inverse\" style=\"text-align : center;\">Último</td></tr>";
			$sql2 = "select * from sgm_foros where id_grupo=".$row["id"]." AND visible=1 and id_iaula=0 ORDER BY orden";
			$result2 = $db->sql_query($sql2);
			while ($row2 = $db->sql_fetchrow($result2)) {
				echo "<tr style=\"height :35px;\">";
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;\">&nbsp;&nbsp;<a href=\"index.php?op=10&sop=1&id_foro=".$row2["id"]."\">";

					$nuevos = 0;
					$sqlnuevo = "select * from sgm_foros_posts WHERE top=0 AND id_post=0 AND visible=1 AND id_foro=".$row2["id"];
					$resultnuevo = $db->sql_query($sqlnuevo);
					while ($rownuevo = $db->sql_fetchrow($resultnuevo)) {
						$sql8 = "select count(*) as total from sgm_foros_lecturas WHERE id_post=".$rownuevo["id"]." AND id_user=".$userid;
						$result8 = $db->sql_query($sql8);
						$row8 = $db->sql_fetchrow($result8);
						if ($row8["total"] == 0) { $nuevos = 1; }
#						echo $sql8."<br>";
					}
#				echo $sqlnuevo."xx<br>";
				if ($nuevos == 1) { echo "<img src=\"pics/foros/post_nuevo.gif\" border=\"0\">"; }
				if ($nuevos == 0) { echo "<img src=\"pics/foros/post_leido.gif\" border=\"0\">"; }

				echo "</a>&nbsp;&nbsp;</td>";
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;width : 500px;\"><a href=\"index.php?op=10&sop=1&id_foro=".$row2["id"]."\"><strong>".$row2["titulo"]."</strong></a><br>";
				if  ($row2["descripcion"] != "") { echo " (".$row2["descripcion"].")</td>"; } else { echo "</td>"; }
					$sqlxx = "select Count(*) AS total from sgm_foros_posts WHERE (visible=1) AND (id_post=0) AND (id_foro=".$row2["id"].")";
					$resultxx = $db->sql_query($sqlxx);
					$rowxx = $db->sql_fetchrow($resultxx);
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;text-align : center;width : 60px;\">".$rowxx["total"]."</td>";
					$sqlxx = "select Count(*) AS total from sgm_foros_posts WHERE (visible=1) AND (id_foro=".$row2["id"].")";
					$resultxx = $db->sql_query($sqlxx);
					$rowxx = $db->sql_fetchrow($resultxx);
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;text-align : center;width : 60px;\">".$rowxx["total"]."</td>";
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;text-align : center;width : 160px;\">";
					$sqlxx = "select Count(*) AS total from sgm_foros_posts WHERE (visible=1) AND (id_foro=".$row2["id"].")";
					$resultxx = $db->sql_query($sqlxx);
					$rowxx = $db->sql_fetchrow($resultxx);
				if ($rowxx["total"] == 0) { echo "-"; }
				else {
						$sqlx = "select * from sgm_foros_posts WHERE (visible=1) AND (id_foro=".$row2["id"].") ORDER BY id DESC";
						$resultx = $db->sql_query($sqlx);
						$rowx = $db->sql_fetchrow($resultx);
					echo "<a href=\"index.php?op=10&sop=1\">".fecha($rowx["fecha"])." , ".hora($rowx["hora"])."";
					echo "<br>".buscarnick($rowx["id_user"])." <img src=\"pics/foros/icono_nuevo.gif\" border=\"0\"></a>";
				}
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}

	if ($soption == 1) {
		$autorizado = 1;
			## autoriza a foros de selecciones (solo miembros y administradores)
			$sql1 = "select count(*) as total from sgm_selecciones WHERE id_foro2=".$id_foro."";
			$result1 = $db->sql_query($sql1);
			$row1 = $db->sql_fetchrow($result1);
				if ( $row1["total"] == 1 ) {
					$sqls = "select * from sgm_selecciones WHERE id_foro2=".$id_foro."";
					$results = $db->sql_query($sqls);
					$rows = $db->sql_fetchrow($results);
					$sqlu = "select count(*) as total from sgm_selecciones_users WHERE (id_user=".$userid.") AND (id_seleccion=".$rows["id"].") AND (seleccionado=1)";
					$resultu = $db->sql_query($sqlu);
					$rowu = $db->sql_fetchrow($resultu);
					if ( $rowu["total"] == 0 ) {  $autorizado = 0; }
					$sqlu = "select count(*) as total from sgm_selecciones_admins WHERE (id_user=".$userid.") AND (id_seleccion=".$rows["id"].")";
					$resultu = $db->sql_query($sqlu);
					$rowu = $db->sql_fetchrow($resultu);
					if ( $rowu["total"] == 1 ) {  $autorizado = 1; }
				}

			## autoriza a foros de selecciones (solo administradores)
			$sql1 = "select count(*) as total from sgm_selecciones WHERE id_foro3=".$id_foro."";
			$result1 = $db->sql_query($sql1);
			$row1 = $db->sql_fetchrow($result1);
				if ( $row1["total"] == 1 ) {
					$sqls = "select * from sgm_selecciones WHERE id_foro3=".$id_foro."";
					$results = $db->sql_query($sqls);
					$rows = $db->sql_fetchrow($results);
					$sqlu = "select count(*) as total from sgm_selecciones_admins WHERE (id_user=".$userid.") AND (id_seleccion=".$rows["id"].")";
					$resultu = $db->sql_query($sqlu);
					$rowu = $db->sql_fetchrow($resultu);
					if ( $rowu["total"] == 1 ) {  $autorizado = 1; }
					else {  $autorizado = 0; }
				}

		if ( $autorizado == 1 ) {
			$id_foro = $_GET["id_foro"];
			$sqlf = "select * from sgm_foros WHERE id=".$id_foro."";
			$resultf = $db->sql_query($sqlf);
			$rowf = $db->sql_fetchrow($resultf);
			echo "Foro : <strong>".$rowf["titulo"]."</strong>";
				$sqlm = "select count(*) as total from sgm_foros_posts WHERE (visible=1) AND (id_post=0) AND (id_foro=".$id_foro.")";
				$resultm = $db->sql_query($sqlm);
				$rowm = $db->sql_fetchrow($resultm);
				if ($_GET["page"] == "") { $page = 1; } else { $page = $_GET["page"]; }
				$match4page = 20;
				$pages = ($rowm["total"]/$match4page);
				$y = 1;
				if ($pages != 0) { echo "<br>Página : "; }
				while ( $y < $pages+1){
					if ($page == $y) { echo "[".$y."]"; }
					else { echo "<a href=\"index.php?op=10&sop=1&id_foro=".$id_foro."&page=".$y."\">[".$y."]</a>";}
					$y++;
				}
				$maxup = ($page * $match4page);
				$mindown = ($maxup - $match4page)+1;
				$count = 1;
			echo "<br><br><table style=\"border : 1px solid #AAAAAA;\" cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			echo "<tr><td></td><td>";
			echo "<a href=\"index.php?op=10\"><strong>&laquo; Volver al indice de los foros</strong></a><br>";
			echo "<a href=\"#\" onClick=\"history.go(-1)\"><strong>&laquo; Volver</strong></a><br>";
			echo "<br><strong>Administradores del foro :</strong>";
			$sqladmins = "select * from sgm_users_foros WHERE id_foro=".$id_foro." ORDER BY id";
			$resultadmins = $db->sql_query($sqladmins);
			$coma = 0;
			while ($rowadmins = $db->sql_fetchrow($resultadmins)) {
				if ($coma > 0) { echo ",&nbsp;".buscarnick($rowadmins["id_user"]); }
				else { echo "&nbsp;".buscarnick($rowadmins["id_user"]); }
				$coma++;
			}
			echo "</td><td></td><td></td><td style=\"text-align : center;\"><a href=\"index.php?op=10&sop=2&id_foro=".$id_foro."\">[ Nuevo ]</a></td></tr>";
			echo "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			echo "<tr><td class=\"inverse\"></td><td class=\"inverse\"  style=\"width : 500px;\"><strong>Asunto</strong></td>";
			echo "<td class=\"inverse\" style=\"text-align : center;width : 60px;\">Respuestas</td><td class=\"inverse\" style=\"text-align : center;width : 60px;\">Visitas</td><td class=\"inverse\" style=\"text-align : center;width : 160px;\">Último</td></tr>";
			$sql = "select * from sgm_foros_posts WHERE (visible=1) AND (id_post=0) AND (id_foro=".$id_foro.") ORDER BY top DESC,lastfecha DESC,lasttime DESC";
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
			if (($count <= $maxup) AND ($count >= $mindown)) {
				echo "<tr style=\"height :35px;\">";

#################### CONTROL ICONOS
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;\"><a href=\"index.php?op=10&sop=4&id_post=".$row["id"]."&id_foro=".$id_foro."\">&nbsp;&nbsp;";
				if ($row["top"] == 1 ) { echo "<img src=\"pics/foros/anuncio.gif\" border=\"0\">"; }
				else {
					if ($row["abierto"] == 1 ) { 
						$sql8 = "select count(*) as total from sgm_foros_lecturas WHERE id_post=".$row["id"]." AND id_user=".$userid;
						$result8 = $db->sql_query($sql8);
						$row8 = $db->sql_fetchrow($result8);
						if ($row8["total"] == 0) { echo "<img src=\"pics/foros/post_nuevo.gif\" border=\"0\">";	}
						else { echo "<img src=\"pics/foros/post_leido.gif\" border=\"0\">";	}
					}
					if ($row["abierto"] == 0 ) { echo "<img src=\"pics/foros/post_cerrado.gif\" border=\"0\">"; }
				}
				echo "</a>&nbsp;&nbsp;</td>";

				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;width : 500px;\"><a href=\"index.php?op=10&sop=4&id_post=".$row["id"]."&id_foro=".$id_foro."\"><strong>".$row["asunto"]."</strong></a></td>";
						$sqlxx = "select Count(*) AS total from sgm_foros_posts WHERE (visible=1) AND (id_post=".$row["id"].")";
						$resultxx = $db->sql_query($sqlxx);
						$rowxx = $db->sql_fetchrow($resultxx);
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;text-align : center;width : 60px;\">".$rowxx["total"]."</td>";
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;text-align : center;width : 60px;\">".$row["visitas"]."</td>";
				echo "<td style=\"vertical-align : middle;border-top : 1px solid #AAAAAA;text-align : center;width : 160px;\">";
				echo "<a href=\"index.php?op=10&sop=4&id_post=".$row["id"]."&id_foro=".$id_foro."\">".fecha($row["lastfecha"])." , ".hora($row["lasttime"])."";
						$sqlx = "select count(*) as total  from sgm_foros_posts WHERE (visible=1) AND (id_post=".$row["id"].") ORDER BY id DESC";
						$resultx = $db->sql_query($sqlx);
						$rowx = $db->sql_fetchrow($resultx);
						if ($rowx["total"] != 0) {
							$sqlx = "select * from sgm_foros_posts WHERE (visible=1) AND (id_post=".$row["id"].") ORDER BY id DESC";
							$resultx = $db->sql_query($sqlx);
							$rowx = $db->sql_fetchrow($resultx);
							echo "<br>".buscarnick($rowx["id_user"])." <img src=\"pics/foros/icono_nuevo.gif\" border=\"0\"></a>";
						}
						else {
							echo "<br>".buscarnick($row["id_user"])." <img src=\"pics/foros/icono_nuevo.gif\" border=\"0\"></a>";
						}
				echo "</td>";
				echo "</tr>";
			}
			$count++;
			}
			echo "</table>";
		}
		if ( $autorizado == 0 ) { echo "Tu usuario no tiene acceso a este foro"; }
	}


	if ($soption == 2) {
		$id_foro = $_GET["id_foro"];
		$id_post = $_GET["id_post"];
		#determina si eres admin
		$sqladmin = "select Count(*) AS total from sgm_users_foros WHERE id_user=".$userid." AND id_foro=".$id_foro;
		$resultadmin = $db->sql_query($sqladmin);
		$rowadmin = $db->sql_fetchrow($resultadmin);
		if ($rowadmin["total"] == 0) { $admin = 0; } else { $admin = 1; }
		#end determina si eres admin
		if ($id_post != "") { echo "<br><strong>RESPONDER MENSAJE</strong><br>"; }
			else { echo "<br><strong>NUEVO MENSAJE</strong><br>"; }
		echo "<table><tr><td>";
			include ("includes/bbcode.php");
		echo "</td><td>";
				echo "<form action=\"index.php?op=10&sop=3\" method=\"post\" name=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_foro\" value=\"".$id_foro."\">";
				echo "<input type=\"Hidden\" name=\"id_post\" value=\"".$id_post."\">";
				echo "<table>";
					if ($id_post != "") {
						$sql = "select * from sgm_foros_posts WHERE id=".$id_post;
						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						echo "<tr><td>Asunto</td><td><input type=\"Text\" name=\"asunto\" class=\"px400\" value=\"Re: ".$row["asunto"]."\"></td></tr>";
					}
					else {
						echo "<tr><td>Asunto</td><td><input type=\"Text\" name=\"asunto\" class=\"px400\"></td></tr>";
					}
					if (($admin == 1) AND ($id_post == "")) {
						echo "<tr><td>Importante! top!</td><td><input type=\"Radio\" name=\"top\" value=\"0\" checked style=\"border : 0;\">NO<input type=\"Radio\" name=\"top\" value=\"1\" style=\"border : 0;\">SI</td></tr>";
					}
					echo "<tr><td>Mensaje</td><td><textarea name=\"message\"rows=\"10\" class=\"px400\"></textarea></td></tr>";
					$sqlfirma = "select * from sgm_users WHERE id=".$userid;
					$resultfirma = $db->sql_query($sqlfirma);
					$rowfirma = $db->sql_fetchrow($resultfirma);
					if ($rowfirma["firma"] == 0) { echo "<tr><td>Firma</td><td><input type=\"Radio\" name=\"firma\" value=\"0\" style=\"border : 0;\" checked>NO<input type=\"Radio\" name=\"firma\" value=\"1\" style=\"border : 0;\">SI</td></tr>"; }
					if ($rowfirma["firma"] == 1) { echo "<tr><td>Firma</td><td><input type=\"Radio\" name=\"firma\" value=\"0\" style=\"border : 0;\">NO<input type=\"Radio\" name=\"firma\" value=\"1\" checked style=\"border : 0;\">SI</td></tr>"; }
					echo "<tr><td></td><td><input type=\"Submit\" value=\"Mandar Mensaje\" class=\"px150\"></td></tr>";
				echo "</table>";
				echo "</form>";
		echo "</td></tr></table>";
	}
	if ($soption == 3) {
		if (($_POST["asunto"] == "") OR ($_POST["message"] == "")) {
			echo "No se permite mandar mensajes sin asunto o texto";
		}
		else {
			$sql = "insert into sgm_foros_posts (asunto,cuerpo,id_foro,id_post,top,firma,id_user,fecha,hora,lastfecha,lasttime,lastid_user) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["asunto"]."'";
			$sql = $sql.",'".$_POST["message"]."'";
			$sql = $sql.",".$_POST["id_foro"]."";
			if ($_POST["id_post"] != "") { $sql = $sql.",".$_POST["id_post"].""; } else { $sql = $sql.",0"; }
			if ($_POST["top"] == 1) { $sql = $sql.",1"; } else { $sql = $sql.",0"; }
			if ($_POST["firma"] == 1) { $sql = $sql.",1"; } else { $sql = $sql.",0"; }
			$sql = $sql.",".$userid."";
			$date = getdate();
			$sql = $sql.",'".$date["year"]."-".$date["mon"]."-".$date["mday"]."'";
			$sql = $sql.",'".$date["hours"].":".$date["minutes"].":".$date["seconds"]."'";
			$sql = $sql.",'".$date["year"]."-".$date["mon"]."-".$date["mday"]."'";
			$sql = $sql.",'".$date["hours"].":".$date["minutes"].":".$date["seconds"]."'";
			$sql = $sql.",".$userid."";
			$sql = $sql.")";
			$db->sql_query($sql);
			echo "<a href=\"index.php?op=10&sop=1&id_foro=".$_POST["id_foro"]."\">[ Volver ]</a>";
			if ($_POST["id_post"] != "") {
				$sql = "delete from sgm_foros_lecturas where id_post=".$_POST["id_post"];
				$db->sql_query($sql);
				$sql = "insert into sgm_foros_lecturas (id_post, id_user) ";
				$sql = $sql."values (";
				$sql = $sql."".$id_post;
				$sql = $sql.",".$userid."";
				$sql = $sql.")";
#				$db->sql_query($sql);
				$sql = "update sgm_foros_posts set lastfecha='".$date["year"]."-".$date["mon"]."-".$date["mday"]."',lasttime='".$date["hours"].":".$date["minutes"].":".$date["seconds"]."',lastid_user=".$userid." WHERE id=".$_POST["id_post"];
				$db->sql_query($sql);
			}

		}
	}

	if ($soption == 4) {
		$id_foro = $_GET["id_foro"];
		$id_post = $_GET["id_post"];

			$sqlm = "select count(*) as total from sgm_foros_posts WHERE (visible=1) AND (id_post=".$id_post.") ORDER BY id ";
			$resultm = $db->sql_query($sqlm);
			$rowm = $db->sql_fetchrow($resultm);

			$match4page = 10;
			$pages = ceil(($rowm["total"]/$match4page));

			if ($_GET["page"] == "") { $page = $pages; } else { $page = $_GET["page"]; }

			$y = 1;
			if ($pages != 0) { echo "<br>Página : "; }
			while ( $y < $pages+1){
				if ($page == $y) { echo "[".$y."]"; }
				else { echo "<a href=\"index.php?op=10&sop=4&id_foro=".$id_foro."&id_post=".$id_post."&page=".$y."\">[".$y."]</a>";}
				$y++;
			}
			$maxup = ($page * $match4page);
			$mindown = ($maxup - $match4page)+1;
			$count = 1;
		#determina si eres admin
		$admin = 0;
		$sqladmin = "select Count(*) AS total from sgm_users_foros WHERE id_user=".$userid." AND id_foro=".$id_foro;
		$resultadmin = $db->sql_query($sqladmin);
		$rowadmin = $db->sql_fetchrow($resultadmin);
		if ($rowadmin["total"] == 0) { $admin = 0; } else { $admin = 1; }
		#end determina si eres admin
		#suma vistas y inserta lectura
		$sql8 = "select * from sgm_foros_posts WHERE id=".$id_post;
		$result8 = $db->sql_query($sql8);
		$row8 = $db->sql_fetchrow($result8);
		$visitas = $row8["visitas"] + 1;
		$sql9 = "update sgm_foros_posts set ";
		$sql9 = $sql9."visitas=".$visitas;
		$sql9 = $sql9." WHERE id=".$id_post;
		$db->sql_query($sql9);
		$sql8 = "select count(*) as total from sgm_foros_lecturas WHERE id_post=".$id_post." AND id_user=".$userid;
		$result8 = $db->sql_query($sql8);
		$row8 = $db->sql_fetchrow($result8);
		if ($row8["total"] == 0) {
			$sql = "insert into sgm_foros_lecturas (id_post, id_user) ";
			$sql = $sql."values (";
			$sql = $sql."".$id_post;
			$sql = $sql.",".$userid."";
			$sql = $sql.")";
			$db->sql_query($sql);
		}
		#final suma vistas y inserta lectura
		$sqlp = "select * from sgm_foros_posts WHERE id=".$id_post;
		$resultp = $db->sql_query($sqlp);
		$rowp = $db->sql_fetchrow($resultp);
		echo "<br><br><table style=\"border : 1px solid #AAAAAA;\" cellpadding=\"0\" cellspacing=\"0\">";
		echo "<tr><td>&nbsp;</td><td></td></tr>";
		echo "<tr><td>&nbsp;&nbsp;<a href=\"index.php?op=10&sop=1&id_foro=".$id_foro."\"><strong>&laquo; Volver al foro.</strong></a></td><td style=\"text-align: right;\">";
		if ($admin == 1) {
			echo "<a href=\"index.php?op=10&sop=8&id_foro=".$id_foro."&id_post=".$id_post."\">[ Editar ]</a>&nbsp;&nbsp;";
			if ($rowp["abierto"] == 1 ) { echo "<a href=\"index.php?op=10&sop=5&id_foro=".$id_foro."&id_post=".$id_post."&value=0\">[ Cerrar ]</a>&nbsp;&nbsp;"; }
			if ($rowp["abierto"] == 0 ) { echo "<a href=\"index.php?op=10&sop=5&id_foro=".$id_foro."&id_post=".$id_post."&value=1\">[ Abrir ]</a>&nbsp;&nbsp;"; }
			echo "<a href=\"index.php?op=10&sop=6&id_foro=".$id_foro."&id_post=".$id_post."\">[ Eliminar ]</a>&nbsp;&nbsp;";
		}
		if ($rowp["abierto"] == 1 ) { echo "<a href=\"index.php?op=10&sop=2&id_foro=".$id_foro."&id_post=".$id_post."\">[ Responder ]</a>&nbsp;&nbsp;</td></tr>"; }
		if ($rowp["abierto"] == 0 ) { echo "</td></tr>"; }
		echo "<tr><td>&nbsp;</td><td></td></tr>";
		$sql = "select * from sgm_foros_posts WHERE (visible=1) AND (id=".$id_post.") ORDER BY id";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if (($page == 1) OR ($page == 0)){ 
			echo "<tr style=\"height :25px;\"><td class=\"inverse\" style=\"vertical-align : middle; text-align: center;\">&nbsp;".fecha($row["fecha"])."<br>".hora($row["hora"])."</td><td class=\"inverse\" style=\"vertical-align : middle;\">";
			echo "&nbsp;Asunto : <strong>".$row["asunto"]."</strong></td></tr>";
			echo "<tr>";
				$sqlxxx = "select * from sgm_users WHERE id=".$row["id_user"];
				$resultxxx = $db->sql_query($sqlxxx);
				$rowxxx = $db->sql_fetchrow($resultxxx);
			echo "<td style=\"vertical-align : top;border-top : 1px solid #AAAAAA;border-right : 1px solid #AAAAAA;width : 120px;padding : 10px 10px 10px 10px;\">";
				echo "<a href=\"index.php?op=10&sop=1\"><strong>".buscarnick($row["id_user"])."</strong></a>";
				if ($rowxxx["ocultar"] == 0) {	echo "<br><a href=\"mailto:".ocultar($rowxxx["mail"])."\">[ eMail ]</a>"; }
				if ($rowxxx["msn"] != "") {	echo "<br><a href=\"mailto:".ocultar($rowxxx["msn"])."\">[ MSN ]</a>"; }
				echo "</td>";
			echo "<td style=\"vertical-align : top;border-top : 1px solid #AAAAAA;width : 660;padding : 10px 10px 10px 10px;text-align:justify;\">".verpost($row["cuerpo"])."<br><br>";
			if ($row["firma"] == 1) { echo "<hr><br>".verpost($rowxxx["textfirma"])."<br><br>";	}
			echo "</td>";
			echo "</tr>";
		}
		$sql = "select * from sgm_foros_posts WHERE (visible=1) AND (id_post=".$id_post.") ORDER BY id ";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
		if (($count <= $maxup) AND ($count >= $mindown)) {
			echo "<tr style=\"height :25px;\"><td class=\"inverse\" style=\"vertical-align : middle; text-align: center;\">&nbsp;".fecha($row["fecha"])."<br>".hora($row["hora"])."</td><td class=\"inverse\" style=\"vertical-align : middle;\">";
			if ($admin == 1) {
				echo "<a href=\"index.php?op=10&sop=8&id_foro=".$id_foro."&id_post=".$row["id"]."\">[ Editar ]</a>&nbsp;&nbsp;";
				echo "<a href=\"index.php?op=10&sop=6&id_foro=".$id_foro."&id_post=".$row["id"]."\">[ Eliminar ]</a>&nbsp;&nbsp;";
			}			
			echo "Asunto : <strong>".$row["asunto"]."</strong></td></tr>";
			echo "<tr>";
				$sqlxxx = "select * from sgm_users WHERE id=".$row["id_user"];
				$resultxxx = $db->sql_query($sqlxxx);
				$rowxxx = $db->sql_fetchrow($resultxxx);
			echo "<td style=\"vertical-align : top;border-top : 1px solid #AAAAAA;border-right : 1px solid #AAAAAA;width : 120px;padding : 10px 10px 10px 10px;\">";
				echo "<a href=\"index.php?op=10&sop=1\"><strong>".buscarnick($row["id_user"])."</strong></a>";
				if ($rowxxx["ocultar"] == 0) {	echo "<br><a href=\"mailto:".ocultar($rowxxx["mail"])."\">[ eMail ]</a>"; }
				if ($rowxxx["msn"] != "") {	echo "<br><a href=\"mailto:".ocultar($rowxxx["msn"])."\">[ MSN ]</a>"; }
				echo "</td>";
			echo "<td style=\"vertical-align : top;border-top : 1px solid #AAAAAA;width : 660;padding : 10px 10px 10px 10px; text-align:justify;\">".verpost($row["cuerpo"])."<br><br>";
			if ($row["firma"] == 1) { echo "<hr><br>".verpost($rowxxx["textfirma"])."<br><br>";	}
			echo "</td>";
			echo "</tr>";
		}
		$count++;
		}

		echo "</table>";
		echo "<br>";
		$y = 1;
		if ($pages != 0) { echo "<br>Página : "; }
		while ( $y < $pages+1){
			if ($page == $y) { echo "[".$y."]"; }
			else { echo "<a href=\"index.php?op=10&sop=4&id_foro=".$id_foro."&id_post=".$id_post."&page=".$y."\">[".$y."]</a>";}
			$y++;
		}
		echo "<br><br>";
	}

	if ($soption == 5) {
		$sql = "update sgm_foros_posts set abierto=".$_GET["value"]." WHERE id=".$_GET["id_post"];
		$db->sql_query($sql);
		echo "<a href=\"index.php?op=10&sop=1&id_foro=".$_GET["id_foro"]."\">[ Volver ]</a>";
	}

	if ($soption == 6) {
		echo "¿Seguro que quieres eliminar este mensaje?";
		echo "<a href=\"index.php?op=10&sop=7&id_foro=".$id_foro."&id_post=".$id_post."&value=0\">[ SI ]</a> <a href=\"index.php?op=10&sop=1&id_foro=".$_GET["id_foro"]."\">[ NO ]</a>";
	}

	if ($soption == 7) {
		$sql = "update sgm_foros_posts set visible=0 WHERE id=".$_GET["id_post"];
		$db->sql_query($sql);
		echo "<a href=\"index.php?op=10&sop=1&id_foro=".$_GET["id_foro"]."\">[ Volver ]</a>";
	}

	if ($soption == 8) {
		$id_foro = $_GET["id_foro"];
		$id_post = $_GET["id_post"];
		$sql = "select * from sgm_foros_posts WHERE id=".$id_post;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($id_post != "") { echo "<br><strong>EDITAR MENSAJE</strong><br>"; }
			else { echo "<br><strong>NUEVO MENSAJE</strong><br>"; }
		echo "<table><tr><td>";
			include ("includes/bbcode.php");
		echo "</td><td>";
				echo "<form action=\"index.php?op=10&sop=9\" method=\"post\" name=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_foro\" value=\"".$id_foro."\">";
				echo "<input type=\"Hidden\" name=\"id_post\" value=\"".$id_post."\">";
				echo "<table>";
				echo "<tr><td>Asunto</td><td><input type=\"Text\" name=\"asunto\" class=\"px400\" value=\"".$row["asunto"]."\"></td></tr>";
#				echo "<tr><td>Importante! top!</td><td><input type=\"Radio\" name=\"top\" value=\"0\" checked style=\"border : 0;\">NO<input type=\"Radio\" name=\"top\" value=\"1\" style=\"border : 0;\">SI</td></tr>";
				echo "<tr><td>Mensaje</td><td><textarea name=\"message\"rows=\"10\" class=\"px400\">".$row["cuerpo"]."</textarea></td></tr>";
				$sqlfirma = "select * from sgm_users WHERE id=".$row["id_user"];
				$resultfirma = $db->sql_query($sqlfirma);
				$rowfirma = $db->sql_fetchrow($resultfirma);
#				if ($rowfirma["firma"] == 0) { echo "<tr><td>Firma</td><td><input type=\"Radio\" name=\"firma\" value=\"0\" style=\"border : 0;\" checked>NO<input type=\"Radio\" name=\"firma\" value=\"1\" style=\"border : 0;\">SI</td></tr>"; }
#				if ($rowfirma["firma"] == 1) { echo "<tr><td>Firma</td><td><input type=\"Radio\" name=\"firma\" value=\"0\" style=\"border : 0;\">NO<input type=\"Radio\" name=\"firma\" value=\"1\" checked style=\"border : 0;\">SI</td></tr>"; }
				echo "<tr><td></td><td><input type=\"Submit\" value=\"Mandar Mensaje\" class=\"px150\"></td></tr>";
				echo "</table>";
				echo "</form>";
		echo "</td></tr></table>";
	}
	if ($soption == 9) {
		$sql = "update sgm_foros_posts set asunto='".$_POST["asunto"]."',cuerpo='".$_POST["message"]."' WHERE id=".$_POST["id_post"];
		$db->sql_query($sql);
		echo "<a href=\"index.php?op=10&sop=1&id_foro=".$_POST["id_foro"]."\">[ Volver ]</a>";
	}

	if (($soption == 0) OR ($soption == 1)) {
		echo "<br><br><strong>Leyenda de iconos en los foros : </strong>";
		echo "<img src=\"pics/foros/post_nuevo.gif\" border=\"0\"> No leído.";
		echo "<img src=\"pics/foros/post_leido.gif\" border=\"0\"> Leído.";
		echo "<img src=\"pics/foros/post_cerrado.gif\" border=\"0\"> Cerrado.";
		echo "<img src=\"pics/foros/anuncio.gif\" border=\"0\"> Anuncio.";
	}

} else {
	echo "Para acceder a los foros debes registrarte o identificarte como usuario.<br><br><a href=\"index.php?op=100\">[ Registrarse ]</a>";
}
}
?>
	</center></TD><TD background="images/tiling-6_25.jpg" WIDTH=18 HEIGHT=483></TD></TR>
</TABLE>
