<?php
error_reporting(~E_ALL);


function afegirModificarBasesDades ($url,$url_del){
	global $db,$dbhandle,$Volver,$Modificar,$Anadir,$Eliminar,$Cliente,$Bases_Datos,$Descripcion,$Usuario,$Contrasena,$ssoption,$simclau;
	if ($ssoption == 1) {
		$clau = encrypt($_POST["pass"],$simclau);
		$camposInsert = "id_client,base,ip,usuario,pass,descripcion";
		$datosInsert = array($_POST["id_client"].$_GET["id"],$_POST["base"],$_POST["ip"],$_POST["usuario"],$clau,comillas($_POST["descripcion"]));
		insertFunction ("sgm_clients_bases_dades",$camposInsert,$datosInsert);
	}
	if ($ssoption == 2) {
		$clau = encrypt($_POST["pass"],$simclau);
		$camposUpdate = array("id_client","base","ip","usuario","pass","descripcion");
		$datosUpdate = array($_POST["id_client"].$_GET["id"],$_POST["base"],$_POST["ip"],$_POST["usuario"],$clau,comillas($_POST["descripcion"]));
		updateFunction ("sgm_clients_bases_dades",$_GET["id_bd"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 3){
		updateFunction ("sgm_clients_bases_dades",$_GET["id_bd"],array("visible"),array("0"));
	}
	echo "<h4>".$Bases_Datos." : </h4>";
	if ($_GET["id"] == 0) {echo boton(array("op=1025&sop=500"),array("&laquo; ".$Volver));}
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<th>".$Eliminar."</th>";
			if ($_GET["id"] == 0) {echo "<th>".$Cliente."</th>";}
			echo "<th>".$Bases_Datos."</th>";
			echo "<th>IP</th>";
			echo "<th>".$$Usuario."</th>";
			echo "<th>".$Contrasena."</th>";
			echo "<th>".$Descripcion."</th>";
			echo "<th></th>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><form action=\"index.php?".$url."&ssop=1&id=".$_GET["id"]."\" method=\"post\"></td>";
		if ($_GET["id"] == 0) {
			echo "<td>";
				echo "<select style=\"width:500px\" name=\"id_client\">";
					$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
					}
				echo "</select>";
			echo "</td>";
		}
			echo "<td><input name=\"base\" type=\"Text\" required></td>";
			echo "<td><input name=\"ip\" type=\"Text\" required></td>";
			echo "<td><input name=\"usuario\" type=\"Text\" required></td>";
			echo "<td><input name=\"pass\" type=\"Text\" required></td>";
			echo "<td><input name=\"descripcion\" type=\"Text\" style=\"width:250px\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px;\"></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td></td>";
		echo "</tr>";
		$sql = "select * from sgm_clients_bases_dades where visible=1";
		if ($_GET["id"] > 0) {$sql.=" and id_client=".$_GET["id"];}
		$sql.=" order by id_client";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?".$url_del."&id=".$_GET["id"]."&id_bd=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<form action=\"index.php?".$url."&ssop=2&id=".$_GET["id"]."&id_bd=".$row["id"]."\" method=\"post\">";
			if ($_GET["id"] == 0) {
				echo "<td>";
					echo "<select style=\"width:500px\" name=\"id_client\">";
					$sqlc = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
					$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
					while ($rowc = mysqli_fetch_array($resultc)) {
						if ($rowc["id"] == $row["id_client"]){
							echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
						}
					}
					echo "</select>";
				echo "</td>";
			}
				echo "<td><input name=\"base\" type=\"Text\" value=\"".$row["base"]."\" required></td>";
				echo "<td><input name=\"ip\" type=\"Text\" value=\"".$row["ip"]."\" required></td>";
				echo "<td><input name=\"usuario\" type=\"Text\" value=\"".$row["usuario"]."\" required></td>";
				$cadena = decrypt($row["pass"],$simclau);
				echo "<td><input name=\"pass\" type=\"Text\" value=\"".$cadena."\" required></td>";
				echo "<td><input name=\"descripcion\" type=\"Text\" value=\"".$row["descripcion"]."\" style=\"width:250px\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td>";
				echo "</form>";
			echo "</tr>";
		}
	echo "</table>";
}

?>