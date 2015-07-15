<?php
if ($option == 101) {
	echo "<br><table style=\" border-bottom : 1px solid Black; border-left : 1px solid Black; border-right : 1px solid Black; border-top : 1px solid Black;text-align:left;\" cellpadding=\"10\" cellspacing=\"10\">";
	echo "<tr><td style=\"width=780\">";

	if ($soption == 0) { 
		echo "<strong class=\"titulo\">Últimos&nbsp;10&nbsp;usuarios&nbsp;registrados</strong>";
		echo "<table><tr><td></td><td></td><td class=\"px200\"><em>Nombre</em></td><td><em>eMail</em></td><td><em>ICQ</em></td><td><em>Web</em></td><td class=\"px200\"><em>MSN</em></td></tr>";
		$sql = "SELECT * from vs_users WHERE validado=1 ORDER BY id DESC";
		$result = $db->sql_query($sql);
		$size = 1;
		while (($row = $db->sql_fetchrow($result)) AND ($size<10)) {
				echo "<tr>";
				echo "<td style=\"text-align:right;\">".fecha($row["datejoin"])."</td>";
				echo "<td><img src=\"vsladder/pics/flags/".$row["country"].".gif\"></td>";
				echo "<td><strong>".buscarnick($row["id"])."</strong></td>";
				if ($row["public"] == 1) { echo "<td><a href=\"mailto:".ocultar($row["mail"])."\">[ eMail ]</a></td>"; } else { echo "<td></td>"; }
				if ($row["icq"] != "") { echo "<td><a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=".$row["icq"]."\">[ Añadir a mi ICQ ]</a></td>"; } else { echo "<td></td>"; }
				if (($row["url"] == "http://") OR ($row["url"] == "http://")) { echo "<td></td>"; } else { echo "<td><a href=\"".$row["url"]."\" target=\"_blank\">[ web ]</a></td>"; }
				if ((strlen($row["msn"]) < 32) AND ($row["msn"] != "")) { echo "<td>".ocultar($row["msn"])."</td>"; }
				if ((strlen($row["msn"]) > 31) AND ($row["msn"] != "")) { echo "<td>".substr(ocultar($row["msn"]),0,30)."...</td>"; }
				echo "</tr>";
			$size++;
		}
		echo "</table>";
		
		echo "<br><br>";

		echo "<table><tr><td>";
			echo "<strong><em class=\"titulo\">Buscador&nbsp;de&nbsp;nicks&nbsp;de&nbsp;usuarios</em></strong>";
			echo "<form action=\"index.php?op=101&sop=1\" method=\"post\">";
			echo "<table><tr>";
			echo "<td>Buscar nick : <input type=\"Text\" name=\"busqueda\" class=\"px150\"></td>";
			echo "<td><input type=\"submit\" value=\"Buscar\" class=\"px100\"></td>";
			echo "</tr></table>";
			echo "</form>";
		echo "</td><td>";
			echo "<strong><em class=\"titulo\">Buscador&nbsp;de&nbsp;GUID's</em></strong>";
			echo "<form action=\"index.php?op=101&sop=2\" method=\"post\">";
			echo "<table><tr>";
			echo "<td>Buscar GUID : <input type=\"Text\" name=\"busqueda\" class=\"px150\"></td>";
			echo "<td><input type=\"submit\" value=\"Buscar\" class=\"px100\"></td>";
			echo "</tr></table>";
			echo "</form>";
		echo "</td></tr></table>";

		$sqlm = "select count(*) as total from vs_users WHERE validado=1";
		$resultm = $db->sql_query($sqlm);
		$rowm = $db->sql_fetchrow($resultm);
		$page=0;
		if ($_GET["page"] == "") { $page = 1; } else { $page = $_GET["page"]; }
		$match4page = 25;
		$pages = ($rowm["total"]/$match4page);
		$y = 1;
		echo "<br><br><strong class=\"titulo\">Usuarios&nbsp;registrados : </strong><br>Página ";
		while ( $y < $pages+1){
			if (($page == $y) AND ($y != 1) AND ($y != $pages)) { echo "[".$y."]"; }
			if ($y == 1) { echo "<a href=\"index.php?op=101&sop=0&page=".$y."\">[".$y."]</a> &raquo; "; }
			if ($y == $page+1) { echo "<a href=\"index.php?op=101&sop=0&page=".$y."\">[".$y."]</a>"; }
			if ($y == $page+2) { echo "<a href=\"index.php?op=101&sop=0&page=".$y."\">[".$y."]</a>"; }
			if ($y == $page-1) { echo "<a href=\"index.php?op=101&sop=0&page=".$y."\">[".$y."]</a>"; }
			if ($y == $page-2) { echo "<a href=\"index.php?op=101&sop=0&page=".$y."\">[".$y."]</a>"; }
			if (($y < $pages+1) AND ($y > $pages)) { echo " &laquo; <a href=\"index.php?op=101&sop=0&page=".$y."\">[".$y."]</a>"; }
			$y++;
		}
		$maxup = ($page * $match4page);
		$mindown = ($maxup - $match4page)+1;
		$count = 1;
		echo "<table><tr><td></td><td class=\"px200\"><em>Nombre</em></td><td><em>eMail</em></td><td><em>ICQ</em></td><td><em>Web</em></td><td class=\"px200\"><em>MSN</em></td></tr>";
		$sql = "select * from vs_users WHERE validado=1 ORDER BY nick";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			if (($count <= $maxup) AND ($count >= $mindown)) {
				echo "<tr>";
				echo "<td><img src=\"vsladder/pics/flags/".$row["country"].".gif\"></td>";
				echo "<td><strong>".buscarnick($row["id"])."</strong></td>";
				if ($row["public"] == 1) { 	echo "<td><a href=\"mailto:".ocultar($row["mail"])."\">[ eMail ]</a></td>";
				} else { echo "<td></td>"; }
				if ($row["icq"] != "") { echo "<td><a href=\"http://wwp.icq.com/scripts/contact.dll?msgto=".$row["icq"]."\">[ Añadir a mi ICQ ]</a></td>"; } else { echo "<td></td>"; }
				if (($row["url"] == "http://") OR ($row["url"] == "http://")) { echo "<td></td>"; } else { echo "<td><a href=\"".$row["url"]."\" target=\"_blank\">[ web ]</a></td>"; }
				echo "<td>".ocultar($row["msn"])."</td>";
				echo "</tr>";
			}
			$count++;
		}
		echo "</table>";
	}

	if ($soption == 1) {
		echo "<strong><em class=\"titulo\">Buscador&nbsp;de&nbsp;nicks&nbsp;de&nbsp;usuarios</em></strong><br>";
		$busqueda = $_POST["busqueda"];
		$sqlm = "select count(*) as total from vs_users_roster WHERE ((nick LIKE '%".$busqueda."%') OR (warnick LIKE '%".$busqueda."%'))";
		$resultm = $db->sql_query($sqlm);
		$rowm = $db->sql_fetchrow($resultm);
		$sqlm2 = "select count(*) as total from vs_users WHERE ((nick LIKE '%".$busqueda."%') OR (warnick LIKE '%".$busqueda."%'))";
		$resultm2 = $db->sql_query($sqlm2);
		$rowm2 = $db->sql_fetchrow($resultm2);
		echo "<br>Hay <strong>".$rowm["total"]."</strong> nicks o nicks de guerra para clanes que contienen la cadena : ".$busqueda;
		echo "<br>Hay <strong>".$rowm2["total"]."</strong> nicks o nicks de guerra individuales que contienen la cadena : ".$busqueda;
		echo "<hr>";
		$sqlm = "select * from vs_users_roster WHERE ((nick LIKE '%".$busqueda."%') OR (warnick LIKE '%".$busqueda."%')) ORDER BY nick, warnick";
		$resultm = $db->sql_query($sqlm);
		while ($rowm = $db->sql_fetchrow($resultm)) { echo "<br><strong>Nick : </strong>".$rowm["nick"]." <strong>WarNick : </strong>".$rowm["warnick"]." <strong>Usuario : </strong> ".buscarnick($rowm["id_user"]); }
		echo "<hr>";
		$sqlm = "select * from vs_users WHERE ((nick LIKE '%".$busqueda."%') OR (warnick LIKE '%".$busqueda."%')) ORDER BY nick, warnick";
		$resultm = $db->sql_query($sqlm);
		while ($rowm = $db->sql_fetchrow($resultm)) { echo "<br><strong>Nick : </strong>".$rowm["nick"]." <strong>WarNick : </strong>".$rowm["warnick"]." <strong>Usuario : </strong> ".buscarnick($rowm["id"]); }
	}

	if ($soption == 2) {
		echo "<strong><em class=\"titulo\">Buscador&nbsp;de&nbsp;GUID's</em></strong><br>";
		$busqueda = $_POST["busqueda"];
		$sqlm = "select count(*) as total from vs_guids WHERE guid='".$busqueda."'";
		$resultm = $db->sql_query($sqlm);
		$rowm = $db->sql_fetchrow($resultm);
		echo "<br>Hay <strong>".$rowm["total"]."</strong> usuario/usuarios con el siguiente GUID : ".$busqueda;
		echo "<br><br>Si aprecias alguna irregularidad en el uso de GUID's debes mandar un mail a : <a href=\"mailto:admin@spanish-arena.com\">admin@spanish-arena.com</a> , para que los administradores puedan tomar las medidas oportunas.<br><br>";
		echo "<hr>";
		$sqlm = "select * from vs_guids WHERE guid='".$busqueda."'";
		$resultm = $db->sql_query($sqlm);
		while (
			$rowm = $db->sql_fetchrow($resultm)) { echo "<br><br><strong>GUID : </strong>".$busqueda." <strong>Usuario : </strong> ".buscarnick($rowm["id_user"]);
				$sqlm2 = "select * from vs_guids WHERE id_user=".$rowm["id_user"]." AND id_game=".$rowm["id_game"]." ORDER by id";
				$resultm2 = $db->sql_query($sqlm2);
				$rowm2 = $db->sql_fetchrow($resultm2);
				if ($rowm2["guid"] == $busqueda) { echo "<br><em style=\"color:#00C600;\">Esta GUID es la que usa el usuario en la actualidad.</em>"; }
				else { echo "<br><em style=\"color:#FF9595;\">Esta GUID no es la que actualmente tiene el usuario como válida.</em>"; }
		}
	}





	echo "</td></tr>";
	echo "</table>";
}
?>
