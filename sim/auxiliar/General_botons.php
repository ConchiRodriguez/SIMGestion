<?php
error_reporting(~E_ALL);


function boton($ruta,$texto) 
{
	echo "<table><tr>";
	for ($i=0;$i<=(count($ruta)-1);$i++){
		echo "<td class=\"boton\">";
			echo "<a href=\"index.php?".$ruta[$i]."\" style=\"color:white;\">".$texto[$i]."</a>";
		echo "</td>";
	}
	echo "</tr></table>";
}

function boton_area_cliente($ruta,$texto) 
{
	echo "<table><tr>";
	for ($i=0;$i<=(count($ruta)-1);$i++){
		echo "<td class=\"boton_area_cliente\">";
			echo "<a href=\"index.php?".$ruta[$i]."\" style=\"color:white;\">".$texto[$i]."</a>";
		echo "</td>";
	}
	echo "</tr></table>";
}

function boton_form($ruta,$texto) 
{
	echo "<td class=\"boton\" style=\"height:3px;\">";
		echo "<a href=\"index.php?".$ruta."\" style=\"color:white;\">".$texto."</a>";
	echo "</td>";
}

function boton_volver($Volver) 
{
	echo "<table cellpadding=\"0\">";
		echo "<tr><td class=menu><a href=\"javascript:history.go(-1);\" style=\"color:white;\">".$Volver."</a></td></tr>";
	echo "</table>";
}

?>