<?php


if ($option == 0) { 
	if ($soption == 0) {
			echo "<table><tr><td style=\"vertical-align:top;width : 580px;\">";
				?>
<center>
<!-- SiteSearch Google --><table border="0" bgcolor="#ffffff">
	<tr><td nowrap="nowrap" valign="top" align="left" height="32">
		<a href="http://www.google.com/"><img src="pics/Logo_25wht.gif" border="0" alt="Google" align="middle"></img></a>
	</td><td nowrap="nowrap">
		<form method="get" action="http://www.google.com/custom" target="google_window">
		<input type="hidden" name="domains" value="Multivia.com"></input>
		<input type="text" name="q" size="31" maxlength="255" value=""></input>
		<input type="submit" name="sa" value="Búsqueda"></input>
		<input type="radio" name="sitesearch" value="" checked="checked" border="0" style="border:0px"></input>Web
		<input type="radio" name="sitesearch" value="Multivia.com" border="0" style="border:0px"></input>Multivia.com
		<input type="hidden" name="client" value="pub-1790510857950310"></input>
		<input type="hidden" name="forid" value="1"></input>
		<input type="hidden" name="ie" value="ISO-8859-1"></input>
		<input type="hidden" name="oe" value="ISO-8859-1"></input>
		<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1;"></input>
		<input type="hidden" name="hl" value="es"></input>
		</form>
	</td></tr>
</table><!-- SiteSearch Google -->	
</center>
				<?php
				####### BLOQUE NOTICIAS
					echo "<table cellpadding=\"0\" cellspacing=\"1\">";
					echo "<tr><td></td><td></td><td></td><td class=\"gris\"><strong>NOTÍCIAS / NOVEDADES</strong><br>&nbsp;</td></tr>";
					$date = getdate(); 
					$sql = "select * from sgm_news_posts WHERE (visible=1) AND (validada=1) ORDER BY fecha DESC,hora DESC";
					$result = $db->sql_query($sql);
					$count = 1;
					while ($row = $db->sql_fetchrow($result)) {
						if ($count <= 7) {
							echo "<tr><td>";
							$a = date("Y", strtotime($row["fecha"])); 
							$m = date("n", strtotime($row["fecha"])); 
							$d = date("j", strtotime($row["fecha"])); 
							$date2 = $row["fecha"];
							if ((date("Y-n-j", strtotime($date2)) == $date["year"]."-".$date["mon"]."-".$date["mday"]) OR (date("Y-n-j", mktime(0,0,0,$m ,$d+1, $a)) == $date["year"]."-".$date["mon"]."-".$date["mday"])) { 
								echo "<img src=\"pics/news/new.gif\">";
							}
							echo "</td>";
							echo "<td style=\"text-align:right\">".fecha($row["fecha"])."</td>";
							echo "<td><center>&nbsp;<strong>".$row["idioma"]."</strong>&nbsp;</center></td>";
							if (strlen($row["asunto"]) > 63) {
								echo "<td><a href=\"index.php?op=12&id_new=".$row["id"]."\"><strong style=\"text-decoration : underline;\">".substr($row["asunto"],0,60)." ...</strong></a> (".$row["lecturas"]." lect.)";
							}
							else {
								echo "<td><a href=\"index.php?op=12&id_new=".$row["id"]."\"><strong style=\"text-decoration : underline;\">".$row["asunto"]."</strong></a> (".$row["lecturas"]." lect.)";
							}
							echo "</td></tr>";
						}
						$count++;
					}
					echo "</table>";
	?>
		<br>
		<br>
		<?php 
	
	class RssReader { 
	    var $url; 
	    var $data; 
	    
	    function RssReader ($url){ 
	        $this->url; 
	        $this->data = implode ("", file ($url)); 
	    } 
	    
	    function get_items (){ 
	        preg_match_all ("/<item .*>.*<\/item>/xsmUi", $this->data, $matches); 
	        $items = array (); 
	        foreach ($matches[0] as $match){ 
	            $items[] = new RssItem ($match); 
	        } 
	        return $items; 
	    } 
	} 
	
	class RssItem { 
	    var $title, $url, $description; 
	    
	    function RssItem ($xml){ 
	        $this->populate ($xml); 
	    } 
	    
	    function populate ($xml){ 
	        preg_match ("/<title> (.*) <\/title>/xsmUi", $xml, $matches); 
	        $this->title = $matches[1]; 
	        preg_match ("/<link> (.*) <\/link>/xsmUi", $xml, $matches); 
	        $this->url = $matches[1]; 
	        preg_match ("/<description> (.*) <\/description>/xsmUi", $xml, $matches); 
	        $this->description = $matches[1]; 
    } 
	    
    function get_title (){ 
        return $this->title; 
	    } 
	
	    function get_url (){ 
        return $this->url; 
	    } 
	    
	    function get_description (){ 
	        return $this->description; 
	    } 
	} 

$rss = new RssReader ("http://www.php.net/news.rss"); 
	
	foreach ($rss->get_items () as $item){ 
		printf ('<a href="%s">%s</a><br />%s<br /><br />', 
		$item->get_url (), $item->get_title (), $item->get_description ()); 
	} 
?> 

		<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td height="146" align="left" valign="top" background="images/back_1.jpg" style="border:1px solid silver; background-position:top right; background-repeat:no-repeat">
					<div style="padding-left:26px; padding-top:16px" class="style7">
						<strong>ACADEMIAS / E-LEARNING</strong>
					</div>
					<div style="padding-left:27px; padding-top:18px;width:350px; text-align:justify;" class="style7">
						Desde nuestro apartado de formación on-line (e-learning), podrás acceder a las diferentes academias, los cursos que se imparten, y el campus virtual de Multivia.com.
						<br><br>
						Otra opción disponible es el alquiler de aulas virtuales. Desde ellas podrás impartir cursos on-line de todo tipo.
					</div>
				</td>
              </tr>
		</table>
		<br>
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#6EBB1F">
              <tr>
                <td height="146" align="left" valign="top" background="images/suselinuxbanner.jpg" style="border:1px solid #6EBB1F; background-position:top right; background-repeat:no-repeat" bordercolor="#6EBB1F">
					<div style="padding-left:10px; padding-top:10px; color:white; text-align:justify;  width:295px;">
						<strong>NOVELL : SUSE Linux</strong>
						<br><br>SUSE Linux Enterprise Server 9 ayuda a las empresas a afianzar Linux* y otros programas de código abierto gracias al establecimiento de una base escalable y de gran rendimiento que otorga seguridad a los sistemas informáticos comerciales.
						<br><br>Nuestro técnicos especializados le asesoraran con la mejor opción para su empresa.
					</div>
				</td>
              </tr>
		</table>
		<br>
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td height="146" align="left" valign="top" background="images/bannerseguridad.jpg" style="border:1px solid silver; background-position:top right; background-repeat:no-repeat">
					<div style="padding-left:26px; padding-top:16px" class="style7">
						<strong>SEGURIDAD / NORMATIVAS</strong>
					</div>
					<div style="padding-left:27px; padding-top:18px;width:350px; text-align:justify;" class="style7">
						En Multivia.com trabajamos continuamente en la aplicación de las nuevas tecnologias y normativas, lo que ofrece un producto de garantia para nuestros clientes y sus usuarios.
						<br><br>
						Todos nuestros productos cumplen los requisitos de la LOPD y LSSI, incluyen encriptaciones (SSL, MD5, etc), y registran la actividad generada.
					</div>
				</td>
              </tr>
		</table>

<?php
	echo "</td><td style=\"width:200px; vertical-align:top;text-align:justify;padding-left : 5px;\">";

		$sqlt = "select count(*) as total from sgm_articles where ((id_subgrupo=62) or (id_subgrupo=67) or (id_subgrupo=68) or (id_subgrupo=69)) AND web=1 AND visible=1";
		$resultt = $db->sql_query($sqlt);
		$rowt = $db->sql_fetchrow($resultt);
		$limite = $rowt["total"];
		$x = rand(1,$limite);
		$sqlxx = "select * from sgm_articles where ((id_subgrupo=62) or (id_subgrupo=67) or (id_subgrupo=68) or (id_subgrupo=69)) AND web=1 AND visible=1";
		$resultxx = $db->sql_query($sqlxx);
		$w = 1;
		while ($rowxx = $db->sql_fetchrow($resultxx)) {
			if ($w == $x) { 
				$sql = "select * from sgm_articles where id=".$rowxx["id"];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				echo "<center><table>";
					echo "<tr><td class=\"style2\">";
						echo "<center><strong>".$row["nombre"]."</strong>";
						echo "<br>PVP : <strong>".$row["pvp"]."</strong> € *";
							$sqlf = "select * from sgm_articles_marcas where id=".$row["id_marca"];
							$resultf = $db->sql_query($sqlf);
							$rowf = $db->sql_fetchrow($resultf);
						echo "<br><br>Fabricante : <a href=\"".$rowf["web"]."\" target=\"_blank\"><strong>".$rowf["marca"]."</strong></a>";
						echo "<br>+info : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>Visitar tienda</strong></a>";
						echo "<br>+info : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>Web producto</strong></a>";
						echo "</td></tr><tr><td><center><img src=\"images/articulos/imagenes/".$row["img"]."\" width=\"100px\"></center></td></tr>";
						echo "</table></center>";
			}
			$w++;
		}

		echo "<br>Nuestras marcas<br><br>";
		$sql = "select * from sgm_articles_marcas order by marca";
		$result = $db->sql_query($sql);
		$x = 0;
		while ($row = $db->sql_fetchrow($result)) {
			if ($x == 0 ) { $x++; echo ""; } else { echo ", "; }
			echo "<a href=\"".$row["web"]."\" target=\"_blank\"><strong>".$row["marca"]."</strong></a>";
		}

		echo "<br><br><br>";
		$sqlt = "select count(*) as total from sgm_articles where ((id_subgrupo<>62) and (id_subgrupo<>67) and (id_subgrupo<>68) and (id_subgrupo<>69)) AND web=1 AND visible=1";
		$resultt = $db->sql_query($sqlt);
		$rowt = $db->sql_fetchrow($resultt);
		$limite = $rowt["total"];
		$x = rand(1,$limite);
		$sqlxx = "select * from sgm_articles where ((id_subgrupo<>62) and (id_subgrupo<>67) and (id_subgrupo<>68) and (id_subgrupo<>69)) AND web=1 AND visible=1";
		$resultxx = $db->sql_query($sqlxx);
		$w = 1;
		while ($rowxx = $db->sql_fetchrow($resultxx)) {
			if ($w == $x) { 
				$sql = "select * from sgm_articles where id=".$rowxx["id"];
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				echo "<center><table>";
					echo "<tr><td class=\"style2\">";
						echo "<center><strong>".$row["nombre"]."</strong>";
						echo "<br>PVP : <strong>".$row["pvp"]."</strong> € *";
							$sqlf = "select * from sgm_articles_marcas where id=".$row["id_marca"];
							$resultf = $db->sql_query($sqlf);
							$rowf = $db->sql_fetchrow($resultf);
						echo "<br><br>Fabricante : <a href=\"".$rowf["web"]."\" target=\"_blank\"><strong>".$rowf["marca"]."</strong></a>";
						echo "<br>+info : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>Visitar tienda</strong></a>";
						echo "<br>+info : <a href=\"".$row["url"]."\" target=\"_blank\"><strong>Web producto</strong></a>";
						echo "</td></tr><tr><td><center><img src=\"images/articulos/imagenes/".$row["img"]."\" width=\"100px\"></center></td></tr>";
						echo "</table></center>";
			}
			$w++;
		}

	echo "</td></tr></table>";
	}
}

?>