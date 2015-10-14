<?php

if ($option == 0) {
		echo "<strong>LOGIN</strong>";
		echo "<br><br><br>";
		echo "<center>";
			echo "<table cellpadding=\"0\">";
			echo "<form method=\"post\" action=\"index.php\">";
			echo "<tr><td><font class=\"tahomagrey\"><strong>Usuario</strong></font></td>";
			echo "<td><input type=\"Text\" name=\"user\" maxlength=\"100\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
			echo "<tr><td><font class=\"tahomagrey\"><strong>Password</strong></font></td>";
			echo "<td><input type=\"Password\" name=\"pass\" maxlength=\"100\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"Entrar\" style=\"width:150px\" class=\"tahomagrey\"></td></tr>";
			echo "</form>";
			echo "</table>";
		echo "</center>";
		echo "<br><br><br>";
}

?>
