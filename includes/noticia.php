<?php

if ($option == 12) {
	if ($soption == 0) {
		#suma lecturas
		$sql8 = "select * from sgm_news_posts WHERE id=".$_GET["id_new"];
		$result8 = $db->sql_query($sql8);
		$row8 = $db->sql_fetchrow($result8);
		$visitas = $row8["lecturas"] + 1;
		$sql9 = "update sgm_news_posts set ";
		$sql9 = $sql9."lecturas=".$visitas;
		$sql9 = $sql9." WHERE id=".$_GET["id_new"];
		$db->sql_query($sql9);
		#final suma lecturas
		$sqlnew = "select * from sgm_news_posts WHERE id=".$_GET["id_new"];
		$resultnew = $db->sql_query($sqlnew);
		$rownew = $db->sql_fetchrow($resultnew);
		echo "<center><table><tr><td style=\"vertical-align:top;width:500px;text-align:justify\">";
			echo "<a href=\"#\" onClick=\"history.go(-1)\"><strong>&laquo; Volver</strong></a>";
			echo "<br><br>Titular : <strong>\"".$rownew["asunto"]."\"</strong>";
			echo "<br><br> Autor : <em>".buscarnick($rownew["id_user"])."</em>";
			echo "<br> Fecha : <em>".fechalarga($rownew["fecha"])." ".hora($rownew["hora"])."</em>";
			echo "<hr><br><center><strong>\"".$rownew["asunto"]."\"</strong></center><br><br>".verpost($rownew["cuerpo"])."<br><br>";
			$sqlsite = "select * from sgm_news_sites WHERE id=".$rownew["id_site"];
			$resultsite = $db->sql_query($sqlsite);
			$rowsite = $db->sql_fetchrow($resultsite);
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
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result)) {
					$sqlele = "select * from sgm_news_elementos where id=".$row["id_elemento"];
					$resultele = $db->sql_query($sqlele);
					$rowele = $db->sql_fetchrow($resultele);
					if ($rowele["id_tipo"] == 1) { echo "<br><br><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\" target=\"_blank\"><img src=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\" border=\"0\" width=\"150\" /></a>"; }
					if ($rowele["id_tipo"] == 2) { echo "<br><br><table><tr><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><img src=\"pics/docs/video.gif\" border=\"0\"/></a></td><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><strong style=\"color:gray\">DESCARGAR VIDEO</strong><br><br>".$rowele["name"]."</a></td></tr></table>"; }
					if ($rowele["id_tipo"] == 3) { echo "<br><br><table><tr><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><img src=\"pics/docs/doc.gif\" border=\"0\"/></a></td><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><strong style=\"color:gray\">DESCARGAR DOC</strong><br><br>".$rowele["name"]."</a></td></tr></table>"; }
					if ($rowele["id_tipo"] == 4) { echo "<br><br><table><tr><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><img src=\"pics/docs/pdf.gif\" border=\"0\"/></a></td><td><a href=\"".$urloriginal."/backoffice/uploads/".$rowele["name"]."\"><strong style=\"color:gray\">DESCARGAR PDF</strong><br><br>".$rowele["name"]."</a></td></tr></table>"; }
				}
		echo "</td></tr></table></center>";
	}
}
?>