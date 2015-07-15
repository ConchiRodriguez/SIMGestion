<?php
if ($option == 11) {
	if ($soption == 0) {
			echo "<strong>Últimos 5 Contenidos en cada Grupo :</strong><br>";
			$sqlg = "select * from sgm_news_grupos WHERE visible=1 AND general=1 ORDER BY articulos,name";
			$resultg = $db->sql_query($sqlg);
			while ($rowg = $db->sql_fetchrow($resultg)) {
				$sqlt = "select count(*) as total from sgm_news_posts WHERE visible=1 AND validada=1 AND id_grupo=".$rowg["id"];
				$resultt = $db->sql_query($sqlt);
				$rowt = $db->sql_fetchrow($resultt);
				echo "<br><strong>".$rowg["name"]."</strong> : <a href=\"index.php?op=11&sop=1&id_grupo=".$rowg["id"]."\">[ Ver todos ]</a> Total de Contenidos : ".$rowt["total"]."<br><table>";
				$date = getdate();
				if ($rowg["articulos"] == 0) {
					$sql = "select * from sgm_news_posts WHERE visible=1 AND validada=1 AND id_grupo=".$rowg["id"]." ORDER BY fecha DESC,hora DESC";
					$newsporlista = 5;
				}
				if ($rowg["articulos"] == 1) {
					$sql = "select * from sgm_news_posts WHERE visible=1 AND validada=1 AND id_grupo=".$rowg["id"]." ORDER BY fecha DESC,hora DESC";
					$newsporlista = 25;
				}
				$result = $db->sql_query($sql);
				$count = 1;
				while ($row = $db->sql_fetchrow($result)) {
					if ($count <= $newsporlista) {
						echo "<tr><td style=\"width:35px\">";
							$a = date("Y", strtotime($row["fecha"])); 
							$m = date("n", strtotime($row["fecha"])); 
							$d = date("j", strtotime($row["fecha"])); 
							$date2 = $row["fecha"];
							if ((date("Y-n-j", strtotime($date2)) == $date["year"]."-".$date["mon"]."-".$date["mday"]) OR (date("Y-n-j", mktime(0,0,0,$m ,$d+1, $a)) == $date["year"]."-".$date["mon"]."-".$date["mday"])) { 
								echo "<strong style=\"color:grey\">NUEVA</strong>&nbsp;&nbsp;";
							}
						echo "</td><td>";
						echo "&raquo;&nbsp;";
						if ($rowg["articulos"] == 0) {
							echo fechacorta($row["fecha"])." ".hora($row["hora"]);
							echo "&nbsp;<a href=\"index.php?op=12&id_new=".$row["id"]."\"><strong style=\"text-decoration : underline;\">".$row["asunto"]."</strong></a> (".buscarnick($row["id_user"]).") ".$row["lecturas"]." lecturas";
						}
						if ($rowg["articulos"] == 1) {
							echo "<a href=\"index.php?op=12&id_new=".$row["id"]."\"><strong style=\"text-decoration : underline;\">".$row["asunto"]."</strong></a> (".buscarnick($row["id_user"]).") ".$row["lecturas"]." lecturas";
						}
						echo "</td></tr>";
					}
					$count++;
				}
				echo "</table>";
			}
			echo "<br><br><strong>Otros grupos de notícias :</strong><br>";
			$sqlg = "select * from sgm_news_grupos WHERE visible=1 AND general=0 ORDER BY name";
			$resultg = $db->sql_query($sqlg);
			echo "<table cellspacing=\"0\">";
			while ($rowg = $db->sql_fetchrow($resultg)) {
				$date = getdate();
				$sqlt = "select count(*) as total from sgm_news_posts WHERE visible=1 AND validada=1 AND id_grupo=".$rowg["id"];
				$resultt = $db->sql_query($sqlt);
				$rowt = $db->sql_fetchrow($resultt);
				if ($rowt["total"] > 0) {
					echo "<tr>";
					$sql = "select * from sgm_news_posts WHERE visible=1 AND validada=1 AND id_grupo=".$rowg["id"]." ORDER BY fecha DESC,hora DESC";
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					echo "<tr><td style=\"width:35px\">";
					$date2 = $row["fecha"];
					if (date("Y-n-j", strtotime($date2)) == $date["year"]."-".$date["mon"]."-".$date["mday"]) { echo "<img src=\"pics/news/newsa.gif\">"; }
					echo "</td><td>&raquo;&nbsp;<a href=\"index.php?op=11&sop=1&id_grupo=".$rowg["id"]."\"><strong>".$rowg["name"]."</strong></a> Total de noticias : ".$rowt["total"]."</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
	}
	if ($soption == 1) {
			$sqlg = "select * from sgm_news_grupos WHERE id=".$_GET["id_grupo"];
			$resultg = $db->sql_query($sqlg);
			$rowg = $db->sql_fetchrow($resultg);
			echo "<a href=\"#\" onClick=\"history.go(-1)\"><strong>&laquo; Volver</strong></a><br><br>";
			echo "<strong>Todos los contenidos publicados en el grupo :</strong>";
			echo "&nbsp;<strong>\"".$rowg["name"]."\"</strong>";
			$sqlm = "select count(*) as total from sgm_news_posts WHERE id_grupo=".$_GET["id_grupo"]." AND visible=1";
			$resultm = $db->sql_query($sqlm);
			$rowm = $db->sql_fetchrow($resultm);
			if ($_GET["page"] == "") { $page = 1; } else { $page = $_GET["page"]; }
			if ($rowg["articulos"] == 0) {
				$match4page = 20;
			}
			if ($rowg["articulos"] == 1) {
				$match4page = 100;
			}
			$pages = ($rowm["total"]/$match4page);
			$y = 1;
			echo "<br>Página ";
			while ( $y < $pages+1){
				if ($page == $y) { echo "[".$y."]"; }
				else { echo "<a href=\"index.php?op=11&sop=1&page=".$y."&id_grupo=".$_GET["id_grupo"]."\">[".$y."]</a>";}
				$y++;
			}
			$maxup = ($page * $match4page);
			$mindown = ($maxup - $match4page)+1;
			$count = 1;
			echo "<br>";
			echo "<br><table>";
			if ($rowg["articulos"] == 0) {
				$sql = "select * from sgm_news_posts WHERE visible=1 AND id_grupo=".$rowg["id"]." ORDER BY fecha DESC,hora DESC";
			}
			if ($rowg["articulos"] == 1) {
				$sql = "select * from sgm_news_posts WHERE visible=1 AND id_grupo=".$rowg["id"]." ORDER BY asunto";
			}
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
				if (($count <= $maxup) AND ($count >= $mindown)) {
					echo "<tr><td>";
					$date = getdate(); 
					$date2 = $row["fecha"];
					if ($rowg["articulos"] == 0) { 
							$a = date("Y", strtotime($row["fecha"])); 
							$m = date("n", strtotime($row["fecha"])); 
							$d = date("j", strtotime($row["fecha"])); 
							$date2 = $row["fecha"];
							if ((date("Y-n-j", strtotime($date2)) == $date["year"]."-".$date["mon"]."-".$date["mday"]) OR (date("Y-n-j", mktime(0,0,0,$m ,$d+1, $a)) == $date["year"]."-".$date["mon"]."-".$date["mday"])) { 
								echo "<strong style=\"color:grey\">NUEVA</strong>&nbsp;&nbsp;";
							}
					}
					if ($rowg["articulos"] == 1) { 
						$a = date("Y", strtotime($row["fecha"])); 
						$m = date("n", strtotime($row["fecha"])); 
						$d = date("j", strtotime($row["fecha"])); 
						if (date("Y-n-j", mktime(0,0,0,$m+1,$d, $a)) > $date["year"]."-".$mes."-".$date["mday"]) {
								echo "<strong style=\"color:grey\">NUEVA</strong>&nbsp;&nbsp;";
						}
					}
					echo "</td><td>";
					echo "&raquo;&nbsp;";
					if ($rowg["articulos"] == 0) {
						echo fechalarga($row["fecha"])." ".hora($row["hora"]);
						echo "&nbsp;<a href=\"index.php?op=12&id_new=".$row["id"]."\"><strong style=\"text-decoration : underline;\">".$row["asunto"]."</strong></a> (".buscarnick($row["id_user"]).") ".$row["lecturas"]." lecturas";
					}
					if ($rowg["articulos"] == 1) {
						echo "<a href=\"index.php?op=12&id_new=".$row["id"]."\"><strong style=\"text-decoration : underline;\">".$row["asunto"]."</strong></a> (".buscarnick($row["id_user"]).") ".$row["lecturas"]." lecturas";
					}
					echo "</td></tr>";
				}
				$count++;
			}
			echo "</table>";
	}

}
?>
