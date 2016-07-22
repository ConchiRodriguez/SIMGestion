<?php
error_reporting(~E_ALL);


function afegirModificarContrasenya ($url){
	global $db,$dbhandle,$Volver,$Editar,$Contrasena,$Contrato,$Aplicacion,$Acceso,$Usuario,$Descripcion,$Modificar,$Anadir,$Anterior,$Nueva,$Repetir;
	if ($_GET["id_con"] > 0){
		$sqlcc = "select * from sim_contrasenas WHERE id=".$_GET["id_con"];
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		echo "<h4>".$Editar." ".$Contrasena." :</h4>";
		echo boton(array($url."&id_contrato=".$rowcc["id_contrato"]."&id_aplicacion=".$rowcc["id_aplicacion"]),array("&laquo; ".$Volver));
		echo "<form action=\"index.php?".$url."&ssop=2&id_con=".$_GET["id_con"]."\" method=\"post\">";
	} else {
		echo "<h4>".$Anadir." ".$Contrasena." :</h4>";
		echo "<form action=\"index.php?".$url."&ssop=1\" method=\"post\">";
	}

	echo "<table class=\"lista\">";
		echo "<tr>";
			echo "<th>".$Contrato."</th>";
			echo "<td><select style=\"width:700px\" name=\"id_contrato\">";
				echo "<option value=\"0\">-</option>";
				$sqlc = "select id,nombre,apellido1,apellido2 from sim_clientes where visible=1";
				if ($_GET["id"] > 0){ $sqlc .= " and id=".$_GET["id"];}
				$sqlc .= " order by nombre";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				while ($rowc = mysqli_fetch_array($resultc)) {
					$sql = "select id,descripcion from sim_contratos where visible=1 and activo=1 and id_cliente_final=".$rowc["id"]."";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)){
						if ($rowcc["id_contrato"] == $row["id"]){
							echo "<option value=\"".$row["id"]."\" selected>".$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"]." - ".$row["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$rowc["nombre"]." ".$rowc["apellido1"]." ".$rowc["apellido2"]." - ".$row["descripcion"]."</option>";
						}
					}
				}
			echo "</select></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<th>".$Aplicacion."</th>";
			echo "<td><select style=\"width:200px\" name=\"id_aplicacion\">";
				echo "<option value=\"0\">-</option>";
				$sqlam = "select id,aplicacion from sim_contrasenas_apliciones where visible=1 order by aplicacion";
				$resultam = mysqli_query($dbhandle,convertSQL($sqlam));
				while ($rowam = mysqli_fetch_array($resultam)) {
					if ($rowcc["id_aplicacion"] == $rowam["id"]){
						echo "<option value=\"".$rowam["id"]."\" selected>".$rowam["aplicacion"]."</option>";
					} else {
						echo "<option value=\"".$rowam["id"]."\">".$rowam["aplicacion"]."</option>";
					}
				}
			echo "</select></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<th>".$Acceso."</th>";
			echo "<td><input type=\"text\" value=\"".$rowcc["acceso"]."\" style=\"width:200px\" name=\"acceso\"></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<th>".$Usuario."</th>";
			echo "<td><input type=\"text\" value=\"".$rowcc["usuario"]."\" style=\"width:200px\" name=\"usuario\" required></td>";
		echo "</tr>";
		if ($_GET["id_con"] > 0){
			echo "<tr><th>".$Contrasena." ".$Anterior."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"passold\" style=\"width:200px\"></td></tr>";
			echo "<tr><th>".$Nueva." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"pass1\" style=\"width:200px\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"pass2\" style=\"width:200px\"></td></tr>";
		} else {
			echo "<tr><th>".$Contrasena."</th><td><input type=\"password\" style=\"width:200px\" name=\"pass1\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"password\" name=\"pass2\" style=\"width:200px\"></td></tr>";
		}
		echo "<tr>";
			echo "<th>".$Descripcion."</th>";
			echo "<td><input type=\"text\" value=\"".$rowcc["descripcion"]."\" style=\"width:200px\" name=\"descripcion\"></td>";
		echo "</tr>";
		echo "<tr>";
		if ($_GET["id_con"] > 0){
			echo "<td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:200px\"></td>";
		} else {
			echo "<td></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:200px\"></td>";
		}
		echo "</tr>";
	echo "</table>";
}

?>