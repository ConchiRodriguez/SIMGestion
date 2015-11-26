<?php
echo "<b>".$Descargas."</b><br><br>";
echo "<table class=\"cuerpo\">";
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
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td>".$Documentos."</td></tr>";
	foreach (glob("docs/*.pptx") as $filename)
	{
		echo "<tr><td><a href=\"http://www.solucions-im.com/jornada/".$filename."\" target=\"_blank\">".$filename."</a></td></tr>";
	}
echo "</table>";
echo "<br><br>";
?>
