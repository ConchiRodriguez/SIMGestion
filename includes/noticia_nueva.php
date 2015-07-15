<?php
if ($option == 9) {
	echo "<br><table style=\" border-bottom : 1px solid Black; border-left : 1px solid Black; border-right : 1px solid Black; border-top : 1px solid Black;text-align:justify;\" cellpadding=\"10\" cellspacing=\"10\">";
	echo "<tr><td style=\"width=780\">";

	if ($soption == 0) {
		echo "<strong class=\"titulo\">Formulario&nbsp;para&nbsp;mandar&nbsp;una&nbsp;nueva&nbsp;noticia&nbsp;a&nbsp;la&nbsp;comunidad&nbsp;:</strong>";
		echo "<br><br>Recuerda que debes escribir sin faltas de ortografía, el texto debe ser claro, preciso y bien redactado. No se publicaran noticias de tipo personal o con referencia a clanes (exceptuando comunicados de interés público).";
		echo "<br><br>Selecciona correctamente la fuente de la noticia y el grupo de noticias en que debe incluirse dicha noticia. Una vez almacenada en la base de datos, los administradores del  grupo al cual se ha mandado la noticia, deben autorizarla (lo que supone algunas horas de retraso desde que la noticia se manda hasta que se visualiza).";
		echo "<br><br>Spanish-Arena se reserva el derecho de modificar el contenido de la noticia y la decisión de si se debe publicar o no.";
		echo "<br><br>Si quieres que la noticia aparezca con tu nombre de usuario, solo hace falta que este con el login realizado, de lo contrario la noticia aparecerá como escrita por un anónimo.";
		echo "<br><br>";
		echo "<table><tr><td>";
			include ("includes/bbcode.php");
		echo "</td><td>";
			echo "<form action=\"index.php?op=9&sop=1\" method=\"post\" name=\"post\">";
			echo "<table>";
			echo "<tr><td>Fuente</td><td><select name=\"id_site\" class=\"px400\">";
				echo "<option value=\"0\">- Selecciona una fuente -</option>";
				$sql = "select * from vs_news_sites WHERE showonweb=1";
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result)) {
					echo "<option value=\"".$row["id"]."\">".$row["name"]."</option>";
				}
			echo "</select></td></tr>";
			echo "<tr><td>Grupo de noticias</td><td><select name=\"id_grupo\" class=\"px400\">";
				echo "<option value=\"0\">- Selecciona un grupo -</option>";
					$sql2 = "select * from vs_news_grupos ORDER BY name";
					$result2 = $db->sql_query($sql2);
					while ($row2 = $db->sql_fetchrow($result2)) {
						echo "<option value=\"".$row2["id"]."\">".$row2["name"]."</option>";
					}
			echo "</select></td></tr>";
			echo "<tr><td>Titular</td><td><input type=\"Text\" name=\"asunto\" class=\"px400\"></td></tr>";
			echo "<tr><td>Noticia</td><td><textarea name=\"message\"rows=\"30\" class=\"px400\"></textarea></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Mandar Noticia\" class=\"px150\"></td></tr>";
			echo "</table>";
			echo "</form>";
		echo "</td></tr></table>";
		echo "</td></tr>";
		echo "</table>";
	}
	if ($soption == 1) {
		if (($_POST["id_grupo"] == "0") OR ($_POST["message"] == "" ) OR ($_POST["id_site"] == "0") OR ($_POST["asunto"] == "")) {
			echo "No se permite mandar noticias que no estan con todos los datos.";
		}
		else {
			$sql = "insert into vs_news_posts (asunto,cuerpo,fecha,hora,id_user,id_grupo,id_site,validada) ";
			$sql = $sql."values (";
			$sql = $sql."'".$_POST["asunto"]."'";
			$sql = $sql.",'".$_POST["message"]."'";
			$date = getdate();
			$sql = $sql.",'".$date["year"]."-".$date["mon"]."-".$date["mday"]."'";
			$sql = $sql.",'".$date["hours"].":".$date["minutes"].":".$date["seconds"]."'";
			if ($user == false) {
				$sql = $sql.",0";
			}
			else {
				$sql = $sql.",".$userid."";
			}
			$sql = $sql.",".$_POST["id_grupo"]."";
			$sql = $sql.",".$_POST["id_site"]."";
			$sql = $sql.",0";
			$sql = $sql.")";
			$db->sql_query($sql);
		}
		echo $sql."<a href=\"index.php\">[ Volver ]</a>";
	}





	echo "</td></tr>";
	echo "</table>";
}
?>
