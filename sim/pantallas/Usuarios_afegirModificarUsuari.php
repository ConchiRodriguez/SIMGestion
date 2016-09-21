<?php
error_reporting(~E_ALL);


function afegirModificarUsuari ($url){
	global $db,$dbhandle,$idioma;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

	if ($_GET["id_user"] > 0){
		$sqluser = "select usuario,mail,id_tipus from sgm_users WHERE id=".$_GET["id_user"];
		$resultuser = mysqli_query($dbhandle,convertSQL($sqluser));
		$rowuser = mysqli_fetch_array($resultuser);
		echo "<h4>".$Datos." ".$Usuario." : ".$rowuser["usuario"]."</h4>";
		echo boton(array($url),array("&laquo; ".$Volver));
		echo "<form action=\"index.php?".$url."&ssop=3&id_user=".$_GET["id_user"]."\" method=\"post\">";
	} else {
		echo "<h4>".$Anadir." ".$Usuarios." :</h4>";
		echo "<form action=\"index.php?".$url."&ssop=2\" method=\"post\">";
	}

	echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"lista\">";
	echo "<tr><th>*".$Usuario."</th><td><input type=\"Text\" name=\"user\" style=\"width:200px;\" value=\"".$rowuser["usuario"]."\" required></td></tr>";
	echo "<tr><th>*".$Direccion." ".$Email."</th><td><input type=\"email\" name=\"mail\" style=\"width:200px;\" value=\"".$rowuser["mail"]."\" required></td></tr>";
	echo "<tr><th>*".$Contrasena."</th><td><input type=\"Password\" name=\"pass1\" style=\"width:200px;\" maxlength=\"10\" placeholder=\"Máximo 10 caracteres\"></td></tr>";
	echo "<tr><th>*".$Repetir." ".$Contrasena."</th><td><input type=\"Password\" name=\"pass2\"  style=\"width:200px;\" maxlength=\"10\" placeholder=\"Máximo 10 caracteres\"></td></tr>";
	echo "<tr><th>*".$Tipo." ".$Usuario."</th>";
		echo "<th><select name=\"id_tipus\" style=\"width:200px;\">";
			echo "<option value=\"0\">-</option>";
			$sqlc = "select id,tipus from sgm_users_tipus where visible=1 order by tipus";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			while ($rowc = mysqli_fetch_array($resultc)) {
				if ($rowc["id"] == $rowuser["id_tipus"]){
					echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["tipus"]."</option>";
				} else {
					echo "<option value=\"".$rowc["id"]."\">".$rowc["tipus"]."</option>";
				}
			}
		echo "</select></td>";
	echo "</tr>";
		echo "<tr>";
			echo "<td></td>";
		if ($_GET["id_user"] > 0){
			echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
		} else {
			echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Anadir."\"></td>";
		}
		echo "</tr>";
	echo "</table>";
	echo "</form>";
	echo "<br>* Campos obligatorios.";
}

?>