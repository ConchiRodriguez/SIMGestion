<?php
if ($option == 13) {
	if ($soption == 0) {
		$sql = "select * from sgm_articles_marcas order by marca";
		$result = $db->sql_query($sql);
		echo "<center><table cellpadding=\"5\"><tr>";
		$x = 0;
		while ($row = $db->sql_fetchrow($result)) {
			if (($x == 4) or ($x == 8) or ($x == 12) or ($x == 16) or ($x == 20) or ($x == 24) or ($x == 28) or ($x == 32) or ($x == 36) or ($x == 40) or ($x == 44) or ($x == 48) or ($x == 52) or ($x == 56) or ($x == 60)) {
				echo "</tr><tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr><tr>";
			}
			echo "<td style=\"text-align:center;\"><img src=\"http://www.multivia.com/inici/backoffice/articulos/logos/".$row["logo"]."\"><br>";
			echo "<a href=\"index.php?op=1&sop=3&idmarca=".$row["id"]."\" class=\"style2\">[ Productos ]</a><br>";
			echo "<a href=\"".$row["web"]."\" class=\"style2\"><strong>".$row["marca"]."</strong></a></td>";
			$x = $x+1;
		}
		echo "</tr></table></center>";
	}
}
?>