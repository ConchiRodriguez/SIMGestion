<?php
error_reporting(~E_ALL);


function afegirModificarServidors ($url,$url_del){
	global $db,$Volver,$Modificar,$Anadir,$Eliminar,$Cliente,$Servidor,$Descripcion,$Servidores,$ssoption;
	if ($ssoption == 1) {
		$camposInsert = "id_client,servidor,descripcion";
		$datosInsert = array($_POST["id_client"].$_GET["id"],comillas($_POST["servidor"]),comillas($_POST["descripcion"]));
		insertFunction ("sgm_clients_servidors",$camposInsert,$datosInsert);
	}
	if ($ssoption == 2) {
		$camposUpdate = array("id_client","servidor","descripcion");
		$datosUpdate = array($_POST["id_client"].$_GET["id"],comillas($_POST["servidor"]),comillas($_POST["descripcion"]));
		updateFunction ("sgm_clients_servidors",$_GET["id_serv"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 3){
		updateFunction ("sgm_clients_servidors",$_GET["id_serv"],array("visible"),array("0"));
	}
	echo "<h4>".$Servidores." : </h4>";
	if ($_GET["id"] == 0) {echo boton(array("op=1025&sop=500"),array("&laquo; ".$Volver));}
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<th>".$Eliminar."</th>";
			if ($_GET["id"] == 0) {echo "<th>".$Cliente."</th>";}
			echo "<th>".$Servidor."</th>";
			echo "<th>".$Descripcion."</th>";
			echo "<th></th>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><form action=\"index.php?".$url."&ssop=1&id=".$_GET["id"]."\" method=\"post\"></td>";
		if ($_GET["id"] == 0) {
			echo "<td>";
				echo "<select style=\"width:500px\" name=\"id_client\">";
					$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
					}
				echo "</select>";
			echo "</td>";
		}
			echo "<td><input name=\"servidor\" type=\"Text\" style=\"width:60px\" required></td>";
			echo "<td><input name=\"descripcion\" type=\"Text\" style=\"width:300px\" required></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px;\"></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_clients_servidors where visible=1";
		if ($_GET["id"] > 0) {$sql.=" and id_client=".$_GET["id"];}
		$sql.=" order by id_client";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?".$url_del."&id=".$_GET["id"]."&id_serv=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<form action=\"index.php?".$url."&ssop=2&id=".$_GET["id"]."&id_serv=".$row["id"]."\" method=\"post\">";
			if ($_GET["id"] == 0) {
				echo "<td>";
					echo "<select style=\"width:500px\" name=\"id_client\">";
					$sqlc = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
					$resultc = mysql_query(convert_sql($sqlc));
					while ($rowc = mysql_fetch_array($resultc)) {
						if ($rowc["id"] == $row["id_client"]){
							echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
						}
					}
					echo "</select>";
				echo "</td>";
			}
				echo "<td><input name=\"servidor\" type=\"Text\" value=\"".$row["servidor"]."\" style=\"width:60px\" ".$row["cognom1"]." ".$row["cognom2"]."></td>";
				echo "<td><input name=\"descripcion\" type=\"Text\" value=\"".$row["descripcion"]."\" style=\"width:300px\" ".$row["cognom1"]." ".$row["cognom2"]."></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
		}
	echo "</table>";
}

?>