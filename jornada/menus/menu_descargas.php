<?php
echo "<b>".$Descargas."</b><br><br>";
echo "<table style=\"width:100%;height:100%;\">";
	echo "<tr><td>".$Fotografias."</td></tr>";
	echo "<tr>";
	$counter = 0;
	foreach (glob("fotos/*.jpg") as $filename)
	{
		echo "<td><a href=\"http://www.solucions-im.com/jornada/".$filename."\" target=\"_blank\"><img src=\"/".$filename."\" height=\"100px\" width=\"170px\"></a></td>";
		$counter++;
		if ($counter == 6){
			echo "</tr><tr>";
			$counter = 0;
		}
	}
	echo "</tr>";
echo "</table>";

?>
