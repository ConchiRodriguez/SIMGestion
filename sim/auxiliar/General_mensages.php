<?php
error_reporting(~E_ALL);


function mensageError($texto) 
{
	echo "<center><table><tr><td style=\"background-color:red; color:white; width:400px; vertical-align:middle;height:50px; text-align:center;\">";
	echo htmlentities($texto);
	echo "</td></tr></table></center>";
}

function mensageInfo($texto,$color) 
{
	echo "<center><table><tr><td style=\"background-color:".$color."; color:white; width:400px; vertical-align:middle;height:50px; text-align:center;\">";
	echo htmlentities($texto);
	echo "</td></tr></table></center>";
}

?>