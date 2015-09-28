<?php
error_reporting(~E_ALL);

function afegirModificarBasesDades ($url,$url_del){
	global $db,$Volver,$Modificar,$Anadir,$Eliminar,$Cliente,$Bases_Datos,$Descripcion,$Usuario,$Contrasena,$ssoption,$simclau;
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
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)) {
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
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;width:40;\"><a href=\"index.php?".$url_del."&id=".$_GET["id"]."&id_bd=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
				echo "<form action=\"index.php?".$url."&ssop=2&id=".$_GET["id"]."&id_bd=".$row["id"]."\" method=\"post\">";
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

function afegirModificarContrasenya ($url){
	global $db,$Volver,$Editar,$Contrasena,$Contrato,$Aplicacion,$Acceso,$Usuario,$Descripcion,$Modificar,$Anadir,$Anterior,$Nueva,$Repetir;
	if ($_GET["id_con"] > 0){
		$sqlcc = "select * from sgm_contrasenyes WHERE id=".$_GET["id_con"];
		$resultcc = mysql_query(convert_sql($sqlcc));
		$rowcc = mysql_fetch_array($resultcc);
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
				$sqlc = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1";
				if ($_GET["id"] > 0){ $sqlc .= " and id=".$_GET["id"];}
				$sqlc .= " order by nombre";
				$resultc = mysql_query(convert_sql($sqlc));
				while ($rowc = mysql_fetch_array($resultc)) {
					$sql = "select id,descripcion from sgm_contratos where visible=1 and activo=1 and id_cliente_final=".$rowc["id"]."";
					$result = mysql_query(convert_sql($sql));
					while ($row = mysql_fetch_array($result)){
						if ($rowcc["id_contrato"] == $row["id"]){
							echo "<option value=\"".$row["id"]."\" selected>".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]." - ".$row["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]." - ".$row["descripcion"]."</option>";
						}
					}
				}
			echo "</select></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<th>".$Aplicacion."</th>";
			echo "<td><select style=\"width:200px\" name=\"id_aplicacion\">";
				echo "<option value=\"0\">-</option>";
				$sqlam = "select id,aplicacion from sgm_contrasenyes_apliciones where visible=1 order by aplicacion";
				$resultam = mysql_query(convert_sql($sqlam));
				while ($rowam = mysql_fetch_array($resultam)) {
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
			echo "<tr><th>".$Contrasena." ".$Anterior."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"passold\" style=\"width:200px\"></td></tr>";
			echo "<tr><th>".$Nueva." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"pass1\" style=\"width:200px\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"pass2\" style=\"width:200px\"></td></tr>";
		} else {
			echo "<tr><th>".$Contrasena."</th><td><input type=\"text\" style=\"width:200px\" name=\"pass1\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"pass2\" style=\"width:200px\"></td></tr>";
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

function mostrarContrasenyes ($link_edit,$link_del,$link_veure_contra,$link_edit_contra) {
	global $db,$Contrasenas,$Contrato,$Aplicacion,$Buscar,$Acceso,$Usuario,$Contrasena,$Descripcion,$userid,$ssoption,$simclau,$ErrorPass,$PassIncorrecto,$id_aplicacion,$id_contrato;
		if ($ssoption == 1) {
			if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") {
				echo mensaje_error($PassIncorrecto);
			} else {
				$cadena = encrypt($_POST["pass1"],$simclau);
				$camposInsert = "id_contrato,id_aplicacion,acceso,usuario,pass,descripcion";
				$datosInsert = array($_POST["id_contrato"],$_POST["id_aplicacion"],$_POST["acceso"],$_POST["usuario"],$cadena,$_POST["descripcion"]);
				insertFunction ("sgm_contrasenyes",$camposInsert,$datosInsert);

				$sqlcc = "select id from sgm_contrasenyes where id_contrato=".$_POST["id_contrato"]." and id_aplicacion=".$_POST["id_aplicacion"]." and acceso='".$_POST["acceso"]."' order by id desc";
				$resultcc = mysql_query(convert_sql($sqlcc));
				$rowcc = mysql_fetch_array($resultcc);
				$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
				$datosInsert = array($rowcc["id"],$userid,time(),"0");
				insertFunction ("sgm_contrasenyes_lopd",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			if ($_POST["passold"] != "") {
				$clau = encrypt($_POST["passold"],$simclau);
				$sqlx = "select id from sgm_contrasenyes WHERE id=".$_GET["id_con"]." and pass='".$clau."'";
				$resultx = mysql_query(convert_sql($sqlx));
				$rowx = mysql_fetch_array($resultx);
				if ($rowx){
					if (($_POST["pass1"] != "") and ($_POST["pass1"] == $_POST["pass2"])) {
						$contrasena = encrypt($_POST["pass1"],$simclau);
						$camposUpdate = array("id_contrato","id_aplicacion","acceso","usuario","descripcion","pass");
						$datosUpdate = array($_POST["id_contrato"],$_POST["id_aplicacion"],$_POST["acceso"],$_POST["usuario"],$_POST["descripcion"],$contrasena);
						updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
					} else {
						echo mensaje_error($PassIncorrecto);
					}
				} else {
					echo mensaje_error($ErrorPass);
				}
			} else {
				$camposUpdate = array("id_contrato","id_aplicacion","acceso","usuario","descripcion");
				$datosUpdate = array($_POST["id_contrato"],$_POST["id_aplicacion"],$_POST["acceso"],$_POST["usuario"],$_POST["descripcion"]);
				updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
			}
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
		}
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;\">";
		if (($id_contrato != 0) or ($id_aplicacion != 0) or ($_GET["id"] > 0)) {
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Contrato."</th>";
				echo "<th>".$Aplicacion."</th>";
				echo "<th>".$Acceso."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Contrasena."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th></th>";
			echo "</tr>";
			$sqlcc = "select * from sgm_contrasenyes where visible=1";
		}
		if (($id_contrato > 0) and ($_GET["id"] <= 0)) {$sqlcc = $sqlcc." and id_contrato=".$id_contrato."";}
		if (($id_aplicacion > 0) and ($_GET["id"] <= 0)) {$sqlcc = $sqlcc." and id_aplicacion=".$id_aplicacion."";}
		if ($_GET["id"] > 0) {$sqlcc .= " and id_contrato in (select id from sgm_contratos where id_cliente=".$_GET["id"].")";}
		$sqlcc = $sqlcc." order by id_contrato desc,id_aplicacion";
#		echo $sqlcc;
		$resultcc = mysql_query(convert_sql($sqlcc));
		while ($rowcc = mysql_fetch_array($resultcc)){
			$url_enlace = "";
			echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?".$link_del."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				$sql = "select id,id_cliente_final,descripcion from sgm_contratos where visible=1 and id=".$rowcc["id_contrato"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$sqlc = "select nombre,cognom1,cognom2 from sgm_clients where id=".$row["id_cliente_final"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<td nowrap><a href=\"index.php?op=1011&sop=100&id=".$row["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]." - ".$row["descripcion"]."</a></td>";
				$sqlam = "select aplicacion from sgm_contrasenyes_apliciones where visible=1 and id=".$rowcc["id_aplicacion"];
				$resultam = mysql_query(convert_sql($sqlam));
				$rowam = mysql_fetch_array($resultam);
				echo "<td>".$rowam["aplicacion"]."</td>";
				echo "<td>".$rowcc["acceso"]."</td>";
				echo "<td><a href=\"index.php?".$link_edit."&id_con=".$rowcc["id"]."\">".$rowcc["usuario"]."</a></td>";
				echo "<td style=\"text-align:center;\">";
				echo "<a href=\"index.php?".$link_veure_contra."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a>&nbsp;&nbsp;";
				echo "<a href=\"index.php?".$link_edit_contra."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a>";
				echo "</td>";
				echo "<td>".$rowcc["descripcion"]."</td>";
			echo "</tr>";
		}
		echo "</table>";
}

function mostrarContrasenya(){
	global $db,$Contrasena,$Cliente,$Aplicacion,$Ver,$userid,$simclau;
		?><script>setTimeout ("redireccionar()", 10000);</script><?php
		$sqlc = "select id_contrato,id_aplicacion,pass from sgm_contrasenyes where id=".$_GET["id_con"];
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		$sqlcl = "select nombre,cognom1,cognom2 from sgm_clients where id in (select id_cliente from sgm_contratos where id=".$rowc["id_contrato"].")";
		$resultcl = mysql_query(convert_sql($sqlcl));
		$rowcl = mysql_fetch_array($resultcl);
		$sqlca = "select aplicacion from sgm_contrasenyes_apliciones where id=".$rowc["id_aplicacion"];
		$resultca = mysql_query(convert_sql($sqlca));
		$rowca = mysql_fetch_array($resultca);

		echo "<h4>".$Ver." ".$Contrasena."</h4>";
		echo $Cliente." : ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."<br>".$Aplicacion." : ".$rowca["aplicacion"]."";
		echo "<table class=\"lista\">";
			$cadena = decrypt($rowc["pass"],$simclau);
			echo "<tr><th>".$Contrasena." : </th><td style=\"vertical-align middle;\">".$cadena."</td></tr>";
		echo "</table>";
		echo "<br><br>En 10 segundos será redirigido por motivos de seguridad.<br>";
		$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
		$datosInsert = array($_GET["id_con"],$userid,time(),1);
		insertFunction ("sgm_contrasenyes_lopd",$camposInsert,$datosInsert);
}

function modificarContrasenya($url_volver){
	global $db,$Volver,$Modificar,$Contrasena,$Cliente,$Aplicacion,$Anterior,$Nueva,$Repetir,$Campos,$Obligatorios,$ssoption,$userid,$simclau,$mesaje_modificar,$PassIncorrecto;
	if ($ssoption == 1) {
		$cadena = encrypt($_POST["passold"],$simclau);
		$sql = "select Count(*) AS total from sgm_contrasenyes WHERE id='".$_GET["id_con"]."' and pass='".$cadena."'";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if (($_POST["pass1"] != $_POST["pass2"]) or ($_POST["pass1"] == "") or ($row["total"] <= 0)) { echo mensaje_error($PassIncorrecto);}
		if (($row["total"] > 0) and ($_POST["pass1"] == $_POST["pass2"]) and ($_POST["pass1"] != "")){
			$cadena2 = encrypt($_POST["pass1"],$simclau);

			$camposUpdate = array("pass");
			$datosUpdate = array($cadena2);
			updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
			echo mensaje_error_c($mesaje_modificar,"green");
			
			$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
			$datosInsert = array($_GET["id_con"],$userid,time(),2);
			insertFunction ("sgm_contrasenyes_lopd",$camposInsert,$datosInsert);
		}
	}
	$sqlc = "select id_contrato,id_aplicacion from sgm_contrasenyes where id=".$_GET["id_con"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	$sqlcl = "select nombre,cognom1,cognom2 from sgm_clients where id in (select id_cliente from sgm_contratos where id=".$rowc["id_contrato"].")";
	$resultcl = mysql_query(convert_sql($sqlcl));
	$rowcl = mysql_fetch_array($resultcl);
	$sqlca = "select aplicacion from sgm_contrasenyes_apliciones where id=".$rowc["id_aplicacion"];
	$resultca = mysql_query(convert_sql($sqlca));
	$rowca = mysql_fetch_array($resultca);

	echo "<h4>".$Modificar." ".$Contrasena." </h4>";
	echo "".$Cliente." : ".$rowcl["nombre"]." ".$rowcl["cognom1"]." ".$rowcl["cognom2"]."<br>".$Aplicacion." : ".$rowca["aplicacion"]."";
	echo boton(array($url_volver."&id_contrato=".$rowc["id_contrato"]."&id_aplicacion=".$rowc["id_aplicacion"]),array("&laquo; ".$Volver));
	echo "<table class=\"lista\">";
		echo "<form action=\"index.php?".$_SERVER["QUERY_STRING"]."&ssop=1\" method=\"post\">";
		echo "<tr><th>".$Contrasena." ".$Anterior."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"passold\" style=\"width:100px\" required>*</td></tr>";
		echo "<tr><th>".$Nueva." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"pass1\" style=\"width:100px\" required>*</td></tr>";
		echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"text\" name=\"pass2\" style=\"width:100px\" required>*</td></tr>";
		echo "<tr>";
			echo "<td></td><td>";
				echo "<input type=\"submit\" value=\"".$Modificar."\" style=\"width:100px\">";
			echo "</td>";
		echo "</tr>";
		echo "</form>";
		echo "<tr><td>* ".$Campos." ".$Obligatorios."</td><tr>";
	echo "</table>";
}

function mostrarUsuari ($sql_usuaris,$link_edit,$link_permisos,$link_clientes){
	global $db,$Usuario,$Gestion,$Validado,$Activo,$Ultima,$Conexion,$Modificar,$ssoption,$Permisos,$Clientes,$UsuarioYaReg,$NombreIncorrecto,$MailYaReg,$MailIncorrecto,$PassIncorrecto,$CompletaCorrect,$Si,$No;
	if ($ssoption == 1) {
		$camposUpdate = array("sgm","activo","validado");
		$datosUpdate = array($_POST["sgm"],$_POST["activo"],$_POST["validado"]);
		updateFunction ("sgm_users",$_POST["id_user"],$camposUpdate,$datosUpdate);
	}
	if ($ssoption == 2) {
		$registro = 1;
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."'";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { echo mensaje_error($UsuarioYaReg); $registro = 0; }
		if ($_POST["user"] == "") { echo mensaje_error($NombreIncorrecto); $registro = 0; }
		$sql = "select Count(*) AS total from sgm_users WHERE mail='".$_POST["mail"]."'";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] != 0) { echo mensaje_error($MailYaReg); $registro = 0; }
		if (comprobar_mail($_POST["mail"]) == false) { echo mensaje_error($MailIncorrecto); $registro = 0; }
		if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") { echo mensaje_error($PassIncorrecto); $registro = 0; }
		if ($registro == 0 ) {echo mensaje_error($CompletaCorrect);}
		$contrasena = crypt($_POST["pass1"]);
		if ($registro == 1 ) {
			$datosInsert = array($_POST["user"],$contrasena,$_POST["mail"],date("Y-m-d"),$_POST["id_tipus"]);
			insertFunction ("sgm_users","usuario,pass,mail,datejoin,id_tipus",$datosInsert);
			$sqlu = "select id from sgm_users where usuario='".$_POST["user"]."'";
			$resultu = mysql_query(convert_sql($sqlu));
			$rowu = mysql_fetch_array($resultu);
			$sql = "select id_modulo,admin from sgm_users_permisos where id_tipus=".$_POST["id_tipus"];
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$datosInsert = array($rowu["id"],$row["id_modulo"],$row["admin"]);
				insertFunction ("sgm_users_permisos","id_user,id_modulo,admin",$datosInsert);
			}
		}
		if ($_GET["id"] > 0){
			$camposInsert = "id_user,id_client";
			$datosInsert = array($rowu["id"],$_GET["id"]);
			insertFunction ("sgm_users_clients",$camposInsert,$datosInsert);
		}
	}
	if ($ssoption == 3) {
		$sqlx = "select id_tipus from sgm_users WHERE mail='".$_POST["mail"]."' AND id<>".$_GET["id_user"];
		$resultx = mysql_query(convert_sql($sqlx));
		$rowx = mysql_fetch_array($resultx);
		if (!$rowx){
			if ($_POST["pass1"] != "") {
				if ($_POST["pass1"] == $_POST["pass2"]){
					$contrasena = crypt($_POST["pass1"]);
					$camposUpdate = array("usuario","mail","pass","id_tipus");
					$datosUpdate = array($_POST["usuario"],$_POST["mail"],$contrasena,$_POST["id_tipus"]);
				} else {
					echo mensaje_error($PassIncorrecto);
				}
			} else {
				$camposUpdate = array("usuario","mail","id_tipus");
				$datosUpdate = array($_POST["user"],$_POST["mail"],$_POST["id_tipus"]);
			}
			updateFunction ("sgm_users",$_GET["id_user"],$camposUpdate,$datosUpdate);
			if ($rowx["id_tipus"] != $_POST["id_tipus"]){
				$sqlt = "select id from sgm_users_permisos where id_user=".$_GET["id_user"];
				$resultt = mysql_query(convert_sql($sqlt));
				while ($rowt = mysql_fetch_array($resultt)){
					deleteFunction ("sgm_users_permisos",$rowt["id"]);
				}
				$sql = "select id_modulo,admin from sgm_users_permisos where id_tipus=".$_POST["id_tipus"];
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					$datosInsert = array($_GET["id_user"],$row["id_modulo"],$row["admin"]);
					insertFunction ("sgm_users_permisos","id_user,id_modulo,admin",$datosInsert);
				}
			}
		}
	}

	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<th style=\"text-align:center;width:20px\">Id.</th>";
			echo "<th style=\"text-align:center;width:20px\">Id.Or.</th>";
			echo "<th></th>";
			echo "<th style=\"text-align:center;width:300px\">".$Usuario."</th>";
			echo "<th style=\"text-align:center;width:50px\">".$Gestion."</th>";
			echo "<th style=\"text-align:center;width:50px\">".$Validado."</th>";
			echo "<th style=\"text-align:center;width:50px\">".$Activo."</th>";
			echo "<th></th>";
			echo "<th style=\"text-align:center;width:20px\">".$Permisos."</th>";
		if ($_GET["id"] <= 0){
			echo "<th style=\"text-align:center;width:20px\">".$Clientes."</th>";
		}
		echo "</tr>";
	$sql = $sql_usuaris;
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)) {
		echo "<tr>";
			echo "<td style=\"text-align:center;\">".$row["id"]."</td>";
			echo "<td style=\"text-align:center;\">".$row["id_origen"]."</td>";
			echo "<td></td>";
			echo "<td>";
				echo " <a href=\"index.php?op=".$_GET["op"]."&sop=".$link_edit."&id_user=".$row["id"]."\"><strong>".$row["usuario"]."</strong></a>";
			echo "</td>";
			echo "<form action=\"index.php?".$_SERVER["QUERY_STRING"]."&ssop=1&ver=".$_GET["ver"]."&sims=".$_GET["sims"]."\" method=\"post\">";
			echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$row["id"]."\">";
			echo "<td style=\"text-align:left;\"><select name=\"sgm\" style=\"width:40px\">";
				if ($row["sgm"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($row["sgm"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select>";
			echo "</td>";
			echo "<td style=\"text-align:center;\"><select name=\"validado\" style=\"width:40px\">";
				if ($row["validado"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($row["validado"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select></td>";
			echo "<td style=\"text-align:center;\"><select name=\"activo\" style=\"width:40px\">";
				if ($row["activo"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($row["activo"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select></td>";
			echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
			echo "</form>";
			$sqlt = "select count(*) as total from sgm_users_permisos where id_user=".$row["id"];
			$resultt = mysql_query(convert_sql($sqlt));
			$rowt = mysql_fetch_array($resultt);
			if ($rowt["total"] > 0) { $imagen = "application_key.png"; } else { $imagen = "application.png"; }
			echo "<td style=\"text-align:center\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$link_permisos."&id_user=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/".$imagen."\" style=\"border:0px;\"></a></td>";
			## SI MODULO FACTURAS MUESTRO CLIENTES RELACIONADOS
		if ($_GET["id"] <= 0){
			$sqlp = "select count(*) as total from sgm_users_permisos_modulos WHERE id_modulo=1003";
			$resultp = mysql_query(convert_sql($sqlp));
			$rowp = mysql_fetch_array($resultp);
			if ($rowp["total"] == 1) {
				$sqlt = "select count(*) as total from sgm_users_clients where id_user=".$row["id"];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if ($rowt["total"] > 0) { $imagen2 = "report_user.png"; } else { $imagen2 = "report.png"; }
				echo "<td style=\"text-align:center\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$link_clientes."&id_user=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/".$imagen2."\" style=\"border:0px;\"></a></td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>";
}

function afegirModificarUsuari ($url){
	global $db,$Datos,$Usuario,$Anadir,$Usuarios,$Direccion,$Email,$Contrasena,$Repetir,$Tipo,$Modificar,$Volver;
	if ($_GET["id_user"] > 0){
		$sqluser = "select usuario,mail,id_tipus from sgm_users WHERE id=".$_GET["id_user"];
		$resultuser = mysql_query(convert_sql($sqluser));
		$rowuser = mysql_fetch_array($resultuser);
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
			$resultc = mysql_query(convert_sql($sqlc));
			while ($rowc = mysql_fetch_array($resultc)) {
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
			echo "<td><input type=\"Submit\" value=\"".$Modificar."\" class=\"px100\"></td>";
		} else {
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" class=\"px100\"></td>";
		}
		echo "</tr>";
	echo "</table>";
	echo "</form>";
	echo "<br>* Campos obligatorios.";
}

function modificarPermisosUsuaris ($url_volver,$url){
	global $db,$Volver,$Administrar,$Permisos,$Acceso,$Modulo,$Modificar,$ssoption,$Si,$No;
	if ($ssoption == 1) {
		$sql = "select id from sgm_users_permisos_modulos where visible=1 order by nombre";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			if ($_POST["permiso".$row["id"]] == 0) {
				$sqlt = "select * from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				deleteFunction ("sgm_users_permisos",$rowt["id"]);
			}
			if ($_POST["permiso".$row["id"]] == 1) {
				$sqlt = "select * from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$_POST["id_modulo".$row["id"]];
				$resultt = mysql_query(convert_sql($sqlt));
				$rowt = mysql_fetch_array($resultt);
				if (!$rowt){
					$camposInsert = "id_user,id_modulo";
					$datosInsert = array($_GET["id_user"],$_POST["id_modulo".$row["id"]]);
					insertFunction ("sgm_users_permisos",$camposInsert,$datosInsert);
				}
			}
			$camposUpdate = array("admin");
			$datosUpdate = array($_POST["admin".$row["id"]]);
			updateFunction ("sgm_users_permisos",$_POST["id_linea".$row["id"]],$camposUpdate,$datosUpdate);
		}
	}

	$sql = "select usuario from sgm_users where id=".$_GET["id_user"];
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	echo "<h4>".$Administrar." ".$Permisos.": ".$row["usuario"]."</h4>";
	echo boton(array($url_volver),array("&laquo; ".$Volver));
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<th>".$Modulo."</th>";
			echo "<th>".$Acceso."</th>";
			echo "<th>Admin</th>";
			echo "<th></th>";
		echo "</tr>";
	echo "<form action=\"index.php?".$url."&id_user=".$_GET["id_user"]."&ssop=1\" method=\"post\">";
		echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100%\"></td></tr>";
	$sql = "select * from sgm_users_permisos_modulos where visible=1 order by nombre";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)) {
		$sqlt = "select count(*) as total from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$row["id_modulo"];
		$resultt = mysql_query(convert_sql($sqlt));
		$rowt = mysql_fetch_array($resultt);
		echo "<tr>";
			echo "<td style=\"width:150px\"><strong>".$row["nombre"]."</strong></td>";
			echo "<input type=\"Hidden\" name=\"id_modulo".$row["id"]."\" value=\"".$row["id_modulo"]."\">";
			echo "<td style=\"width:60px\"><select name=\"permiso".$row["id"]."\" style=\"width:40px\">";
				if ($rowt["total"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($rowt["total"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select></td>";
			$sqlad = "select id,admin from sgm_users_permisos where id_user=".$_GET["id_user"]." and id_modulo=".$row["id_modulo"];
			$resultad = mysql_query(convert_sql($sqlad));
			$rowad = mysql_fetch_array($resultad);
			echo "<input type=\"Hidden\" name=\"id_linea".$row["id"]."\" value=\"".$rowad["id"]."\">";
			echo "<td style=\"width:60px\"><select name=\"admin".$row["id"]."\" style=\"width:40px\">";
				if ($rowad["admin"] == 1) {
					echo "<option value=\"1\" selected>".$Si."</option>";
					echo "<option value=\"0\">".$No."</option>";
				}
				if ($rowad["admin"] == 0) {
					echo "<option value=\"1\">".$Si."</option>";
					echo "<option value=\"0\" selected>".$No."</option>";
				}
			echo "</select></td>";
		echo "</tr>";
	}
		echo "<tr><td colspan=\"3\"><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100%\"></td></tr>";
	echo "</form>";
	echo "</table>";
}

function calculPausaIncidencia ($id_incidencia, $id_nota_incidencia,$data_nota_incidencia){
	global $db;
	
	$pausada = 0;

	$sql = "select id_usuario_registro,pausada,id from sgm_incidencias where id_incidencia=".$id_incidencia." and visible=1 order by fecha_inicio";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)){
		if ($row["id_usuario_registro"] > 0) {
			$sqlu = "select id from sgm_users where id=".$row["id_usuario_registro"]." and validado=1 and activo=1 and sgm=1";
			$resultu = mysql_query($sqlu);
			$rowu = mysql_fetch_array($resultu);
			if (($rowu) and ($row["pausada"] == 1)){
				$pausada = 1;
			} elseif (($rowu) and ($row["pausada"] == 0)) {
				$pausada = 0;
			} else {
				$pausada = $pausada;
			}
		}
		$sql = "update sgm_incidencias set ";
		$sql = $sql."pausada=".$pausada;
		$sql = $sql." WHERE id=".$row["id"]."";
		mysql_query(convert_sql($sql));
#		echo $sql."<br>";
#		echo date("Y-m-d H:i:s", $row["fecha_inicio"])."--".$pausada."<br>";
	}
	$sql1 = "update sgm_incidencias set ";
	$sql1 = $sql1."pausada=".$pausada;
	$sql1 = $sql1." WHERE id=".$id_incidencia."";
	mysql_query(convert_sql($sql1));
#	echo $sql1."<br>";
}	
	
function resumEconomicContractes($id){
	global $Enero,$Febrero,$Marzo,$Abril,$Mayo,$Junio,$Julio,$Agosto,$Septiembre,$Octubre,$Noviembre,$Ano,$Total,$meses;
		echo "<center><table cellspacing=\"0\" style=\"width:200px\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$fechahoy = getdate();
					$yact = $fechahoy["year"];
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&y=".$yant."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&y=".$yact."\">".$yact."</a></td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&y=".$ypost."\">&gt;".$ypost."</a></td>";
		echo "</tr></table></center>";
	if ($id == 0) { 
		echo "<br><center><table cellspacing=\"0\" style=\"width:100%\">";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 0; $x < 12; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$meses[$x]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				}
				echo "<td style=\"text-align:right;\"><strong>".$Total." ".$Ano." h.</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$Total." ".$Ano." €</strong></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select id,id_cliente,num_contrato from sgm_contratos where activo=1 and renovado=0 and visible=1";
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$total_horas_any = 0;
				$total_euros_any = 0;
				$sqlc = "select id,nombre from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\">";
					echo "<a href=\"index.php?op=1011&sop=100&id=".$rowtipos["id"]."\">".$rowtipos["num_contrato"]."</a>";
				echo "</td></tr>";
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\">";
					echo "<strong><a href=\"index.php?op=1008&sop=210&id=".$rowc["id"]."\">".$rowc["nombre"]."</a></strong>";
				echo "</td></tr>";
				$sqls = "select id,servicio,precio_hora from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysql_query(convert_sql($sqls));
				while ($rows = mysql_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 1; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where visible=1 and fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo $horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\">".number_format ($total_euros,2,',','')." €</td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
						$inicio_mes = date("U", mktime(0,0,0,1, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,13, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where visible=1 and fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo $horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\">".number_format ($total_euros,2,',','')." €</td>";
						$total_horas_any += $rowind["total"];
						$total_euros_any += $total_euros;
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 1; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong>".number_format ($total_euros_mes[$x],2,',','')." €</strong></td>";
					}
						echo "<td style=\"text-align:right;\">";
							$hora = $total_horas_any/60;
							$horas = explode(".",$hora);
							$minutos = $total_horas_any % 60;
							echo $horas[0]." h. ".$minutos." m.";
						echo "</td>";
						echo "<td style=\"text-align:right;background-color:".$color."\">".number_format ($total_euros_any,2,',','')." €</td>";
					echo "</tr>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table></center>";
	} else {
		echo "<br><center><table cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 0; $x < 6; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$meses[$x]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				}
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select id,id_cliente from sgm_contratos where activo=1 and renovado=0 and visible=1 and id=".$id;
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\"><strong>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysql_query(convert_sql($sqls));
				while ($rows = mysql_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 1; $x <= 6; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\"><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_serv=".$rows["id"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros,2,',','')." €</a></td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 1; $x <= 6; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros_mes[$x],2,',','')." €</a></strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td></td>";
				for ($x = 6; $x < 12; $x++) {
					echo "<td style=\"text-align:right;\"><strong>".$meses[$x]."</strong></td>";
					echo "<td style=\"text-align:right;\"><strong>".$Total." €</strong></td>";
				}
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$mes = date("n");
			$sqltipos = "select * from sgm_contratos where activo=1 and renovado=0 and visible=1 and id=".$id;
			$sqltipos .= " order by id_cliente";
			$resulttipos = mysql_query(convert_sql($sqltipos));
			while ($rowtipos = mysql_fetch_array($resulttipos)){
				unset($total_horas_mes);
				unset($total_euros_mes);
				$sqlc = "select * from sgm_clients where id=".$rowtipos["id_cliente"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				echo "<tr><td style=\"vertical-align:top;\" colspan=\"14\"><strong>";
				echo "</td></tr>";
				$sqls = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowtipos["id"]." order by servicio";
				$results = mysql_query(convert_sql($sqls));
				while ($rows = mysql_fetch_array($results)){
					echo "<tr>";
						echo "<td>".$rows["servicio"]."</td>";
					for ($x = 7; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$inicio_mes = date("U", mktime(0,0,0,$x, 1, $yact));
						$final_mes = date("U", mktime(23,59,59,$x+1, 1-1,$yact));
						echo "<td style=\"text-align:right;background-color:".$color."\">";
							$sqlind = "select sum(duracion) as total from sgm_incidencias where fecha_inicio between ".$inicio_mes." and ".$final_mes." and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$rows["id"].")";
							$resultind = mysql_query(convert_sql($sqlind));
							$rowind = mysql_fetch_array($resultind);
							$hora = $rowind["total"]/60;
							$horas = explode(".",$hora);
							$minutos = $rowind["total"] % 60;
							echo "".$horas[0]." h. ".$minutos." m.";
						echo "</td>";
						$total_euros = $hora * $rows["precio_hora"];
						echo "<td style=\"text-align:right;background-color:".$color."\"><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_serv=".$rows["id"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros,2,',','')." €</a></td>";
						$total_horas_mes[$x] += $rowind["total"];
						$total_euros_mes[$x] += $total_euros;
					}
					echo "</tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					for ($x = 7; $x <= 12; $x++) {
						if ($x == $mes) {$color = "yellow";} else {$color = "white";}
						$hora2 = $total_horas_mes[$x]/60;
						$horas2 = explode(".",$hora2);
						$minutos2 = $total_horas_mes[$x] % 60;
						echo "<td style=\"text-align:right;background-color:".$color."\"><strong>".$horas2[0]." h. ".$minutos2." m.</strong></td><td style=\"text-align:right;background-color:".$color."\"><strong><a href=\"index.php?op=".$_GET["op"]."&sop=13&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&mes=".$x."&any=".$yact."\">".number_format ($total_euros_mes[$x],2,',','')." €</a></strong></td>";
					}
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		echo "</table></center>";
	}
}

function calculSLAtotal(){
	global $db;
	$sql = "select * from sgm_incidencias where id_incidencia=0 and visible=1 and id_estado<>-2";
	$result = mysql_query(convert_sql($sql));
	while ($row = mysql_fetch_array($result)){
#		echo $row["id"];
		$pendent = calculSLA($row["id"],0);
		if ($row["pausada"] == 0){$previsio = fecha_prevision($row["id_servicio"], $row["fecha_inicio"]);} else {$previsio = 0;}
		$sql1 = "update sgm_incidencias set ";
		$sql1 = $sql1."temps_pendent=".$pendent;
		$sql1 = $sql1.",fecha_prevision=".$previsio;
		$sql1 = $sql1." WHERE id=".$row["id"]."";
		mysql_query($sql1);
#		echo $sql1."<br>";
	}
}

function calculSLA($id,$cierre){
	global $db;
	$sql = "select * from sgm_incidencias where id=".$id."";
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);

	$durada = 0;
	$pausada = 0;

	$sqlc = "select * from sgm_contratos_servicio where id=".$row["id_servicio"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
		$contador = 0;
		$fecha_ant = 0;
		$sqld = "select * from sgm_incidencias where id_incidencia=".$id." and visible=1 and fecha_inicio >= ".$row["fecha_inicio"]." order by fecha_inicio";
		$resultd = mysql_query(convert_sql($sqld));
		while ($rowd = mysql_fetch_array($resultd)){
			if ($contador==0){$fecha_ant = $row["fecha_inicio"];}
			if ($rowc["nbd"] == 1) {$tiempo = buscaFestivo($rowd["fecha_inicio"],$fecha_ant);}
			if ($rowc["nbd"] == 0) {$tiempo = $rowd["fecha_inicio"]-$fecha_ant;}
			if (($pausada == 0)){$durada += $tiempo;}
			$fecha_ant = $rowd["fecha_inicio"];
			$contador++;
			$pausada = $rowd["pausada"];
#			echo $id."-".($rowd["fecha_inicio"] - $row["fecha_inicio"])."-".$durada."a<br><br>";
		}
		if ($fecha_ant == 0){$fecha_ant = $row["fecha_inicio"];}
		if (($pausada==0) and ($cierre==0)){
			if ($rowc["nbd"] == 1) {$tiempo = buscaFestivo(time(),$fecha_ant);}
			if ($rowc["nbd"] == 0) {$tiempo = time()-$fecha_ant;}
#			$tiempo = buscaFestivo(time(),$fecha_ant);
			$durada += $tiempo;
#			echo $id." ".(time() - $fecha_ant)."--".$tiempo."--".$durada."1<br>";
		} elseif (($pausada==0) and ($cierre==1)){
			if ($rowc["nbd"] == 1) {$tiempo = buscaFestivo($row["fecha_cierre"],$fecha_ant);}
			if ($rowc["nbd"] == 0) {$tiempo = $row["fecha_cierre"]-$fecha_ant;}
#			$tiempo = buscaFestivo($row["fecha_cierre"],$fecha_ant);
			$durada += $tiempo;
#			echo $id." ".(time() - $fecha_ant)."-b-".$tiempo."-b-".$durada."2<br>";
		}

	$sqlc = "select * from sgm_contratos_servicio where id=".$row["id_servicio"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	$sla = ($rowc["temps_resposta"]*3600)-$durada;
#	echo "ID:".$row["id"]."SLA:".($sla/3600)."Durada:".($durada/3600)."Temps Resposta:".$rowc["temps_resposta"]."<br>";
	return $sla;
}


function buscaFestivo($fecha_act,$fecha_ant){
	global $db;
	$tiempo=0;

	#calcul primera hora del dia, 00:00:00
	$data_ini = date("Y-m-d", $fecha_act);
	$act_hora = date("H",$fecha_act);
	$act_min = date("i",$fecha_act);
	$act_sec = date("s",$fecha_act);
	$time_act = $act_sec + ($act_min*60) + ($act_hora*3600);
	$data_act = date('U', strtotime($data_ini));
	$data_fi = date("Y-m-d", $fecha_ant);
	$ant_hora = date("H",$fecha_ant);
	$ant_min = date("i",$fecha_ant);
	$ant_sec = date("s",$fecha_ant);
	$time_ant = $ant_sec + ($ant_min*60) + ($ant_hora*3600);
	$data_ant = date('U', strtotime($data_fi));
	$mesdia=0;

	if (comprobar_festivo2($data_ant) == 0){
		$diaSemana2 = date("N", ($data_ant));
		$sqlch2 = "select * from sgm_calendario_horario where id=".$diaSemana2."";
		$resultch2 = mysql_query(convert_sql($sqlch2));
		$rowch2 = mysql_fetch_array($resultch2);
		if ($fecha_ant < ($data_ant+$rowch2["hora_fin"])) {$y= $time_ant;}
		if ($fecha_ant < ($data_ant+$rowch2["hora_inicio"])){$y= $rowch2["hora_inicio"];}
		if ($fecha_ant > ($data_ant+$rowch2["hora_inicio"])) {$y= $time_ant;}
		if ($fecha_ant > ($data_ant+$rowch2["hora_fin"])) {$y= $rowch2["hora_fin"];}
	} else {
		$y= 0;
	}

	if (comprobar_festivo2($data_act) == 0){
		$diaSemana = date("N", ($data_act));
		$sqlch = "select * from sgm_calendario_horario where id=".$diaSemana."";
		$resultch = mysql_query(convert_sql($sqlch));
		$rowch = mysql_fetch_array($resultch);
		if ($fecha_act < ($data_act+$rowch["hora_fin"])) {$x = $time_act;}
		if ($fecha_act < ($data_ant+$rowch["hora_inicio"])){$x= $rowch["hora_inicio"];}
		if ($fecha_act > ($data_ant+$rowch["hora_inicio"])) {$x= $time_act;}
		if ($fecha_act > ($data_act+$rowch["hora_fin"])){$x= $rowch["hora_fin"];}
	} else {
		$x= 0;
	}

	if ($data_ant < $data_act){
		$tiempo += $rowch2["hora_fin"]-$y;
		$tiempo += $x - $rowch["hora_inicio"];
	} else {
		$tiempo += $x-$y;
	}

	$data_ant = sumaDies($data_ant,1);
	while ($data_ant < $data_act){
		$comprobar = comprobar_festivo2($data_ant);
		if ($comprobar == 0){
			$diaSemanaX = date("N", ($data_ant));
			$sqlch = "select * from sgm_calendario_horario where id=".$diaSemanaX."";
			$resultch = mysql_query(convert_sql($sqlch));
			$rowch = mysql_fetch_array($resultch);
			$tiempo += (($data_ant+$rowch["hora_fin"]) - ($data_ant+$rowch["hora_inicio"]));
#			echo "g".($tiempo/3600)."<br>";
		}
		$data_ant = sumaDies($data_ant,1);
	}

	return $tiempo;
}

function fecha_prevision($id_servicio, $data_ini)
{
	global $db;

	$sqlc = "select * from sgm_contratos_servicio where id=".$id_servicio;
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc["temps_resposta"] > 0){
		$temps_resposta = ($rowc["temps_resposta"]*3600);
		$fecha_ini = (date("Y-m-d H:i:s", $data_ini));
		list($fecha,$hora)=explode(" ",$fecha_ini);
		list($any,$mes,$dia)=explode("-", $fecha);
		$j = 0;

		if ($rowc["nbd"] == 0){
			$prevision = $temps_resposta+$data_ini;
		}

		if ($rowc["nbd"] == 1) {
			while ($temps_resposta > 0){
				$festivo = comprobar_festivo2($data_ini);
				while ($festivo == 1){
					$j++;
					$dia_dema = date("N", sumaDies($data_ini,1));
					$sqlch = "select * from sgm_calendario_horario where id=".$dia_dema;
					$resultch = mysql_query(convert_sql($sqlch));
					$rowch = mysql_fetch_array($resultch);
					$data_ini = date('U', mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
					$festivo = comprobar_festivo2($data_ini);
				}
				$dia2 = date("N", ($data_ini));
				$sqlch = "select * from sgm_calendario_horario where id=".$dia2;
				$resultch = mysql_query(convert_sql($sqlch));
				$rowch = mysql_fetch_array($resultch);
				$inici_jornada = date('U', mktime(($rowch["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
				if ($data_ini >= $inici_jornada) {$data_ini=$data_ini;} else {$data_ini=$inici_jornada;}
				$fin_jornada = date('U', mktime(($rowch["hora_fin"]/3600), 0, 0, $mes, $dia+$j, $any));
				$hores_prev = $temps_resposta - ($fin_jornada - $data_ini);
				if ($hores_prev > 0){
					if (($fin_jornada - $data_ini) >= 0){
						$temps_resposta = $temps_resposta - ($fin_jornada - $data_ini);
					}
					$j++;
					$dia_dema = date("N", sumaDies($data_ini,1));
					$sqlch2 = "select * from sgm_calendario_horario where id=".$dia_dema;
					$resultch2 = mysql_query(convert_sql($sqlch2));
					$rowch2 = mysql_fetch_array($resultch2);
					$data_ini = date('U', mktime(($rowch2["hora_inicio"]/3600), 0, 0, $mes, $dia+$j, $any));
				}
				if ($hores_prev <= 0){
					$prevision = $data_ini + $temps_resposta;
					$temps_resposta = 0;
				}
			}
		}
	} else {
		$prevision = 0;
	}
	return $prevision;
}

function comprobar_festivo2($fecha)
{
	global $db;
	$festivo=0;
#Extreiem l'hora a la que acabaria la peça
	$dia_sem = date("w", ($fecha));
	if ($dia_sem == 0){
		$festivo=1;
	}
	if ($dia_sem == 6){
		$festivo=1;
	}
	$sqlc = "select * from sgm_calendario where dia=".date("j", ($fecha))." and mes=".date("n", ($fecha))."";
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc){
		$festivo=1;
	}
#	echo $festivo."<br>";
	return $festivo;
}

function sumaDies($dia_actual,$num){
	$proxim_any = date("Y",$dia_actual);
	$proxim_mes = date("m",$dia_actual);
	$proxim_dia = date("d",$dia_actual);
	$dia_prox = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+$num,$proxim_any));
	return $dia_prox;
}

function servidoresMonitorizados ($id_cliente, $serv_linea,$ssop){
	global $db,$dbhandle,$Uso,$Memoria,$simclau;
	echo "<tr>";
	$i = 1;
	$sqlcs2 = "select * from sgm_clients_servidors where id_client in (".$id_cliente.") and visible=1";
	$resultcs2 = mysql_query($sqlcs2,$dbhandle);
	while ($rowcs2 = mysql_fetch_array($resultcs2)){
		if ($i > $serv_linea) { echo "</tr><tr>"; }
		$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
		$resultcbd = mysql_query($sqlcbd,$dbhandle);
		$rowcbd = mysql_fetch_array($resultcbd);
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = decrypt($rowcbd["pass"],$simclau);
		$base = $rowcbd["base"];

		$sqlcsa = "select * from sgm_clients_servidors_param";
		$resultcsa = mysql_query($sqlcsa,$dbhandle);
		$rowcsa = mysql_fetch_array($resultcsa);
		$cpu = $rowcsa["cpu"];
		$mem = $rowcsa["mem"];
		$memswap = $rowcsa["memswap"];
		$hhdd = $rowcsa["hd"];

		$dbhandle3 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
		$db3 = mysql_select_db($base, $dbhandle3) or die("Couldn't open database $myDB");

		$sqlna = "select * from sim_nagios where id_servidor=".$rowcs2["servidor"]." order by time_register desc";
		$resultna = mysql_query(convert_sql($sqlna,$dbhandle3));
		$rowna = mysql_fetch_array($resultna);

		if ($rowna["nagios"] == 0){ $nagios = "OFF"; $colorn = "red"; $colorna = "white"; } else { $nagios = "ON"; $colorn = "Yellowgreen"; $colorna = "black"; }
		if ($rowna["httpd"] == 0){ $httpd = "OFF"; $colorh = "red"; $colorht = "white"; } else { $httpd = "ON"; $colorh = "Yellowgreen"; $colorht = "black"; }
		if ($rowna["mysqld"] == 0){ $mysqld = "OFF"; $colors = "red"; $colorsq = "white"; } else { $mysqld = "ON"; $colors = "Yellowgreen"; $colorsq = "black"; }
		if ($rowna["cpu"] >= $cpu){ $colorc = "red"; $colorcp = "white"; } else { $colorc = "Yellowgreen"; $colorcp = "black"; }
		if ($rowna["mem"] >= $mem){ $colorm = "red"; $colorme = "white"; } else { $colorm = "Yellowgreen"; $colorme = "black"; }
		if ($rowna["mem_swap"] <= $memswap){ $colorms = "red"; $colormsw = "white"; } else { $colorms = "Yellowgreen"; $colormsw = "black"; }
		if ($rowna["hd"] <= $hhdd){ $colorhd = "red"; $colorhhdd = "white"; } else { $colorhd = "Yellowgreen"; $colorhhdd = "black"; }
		$hd = ($rowna["hd"]/1000000);
		$diezmin = 600;
		if (($rowna["time_register"]+$diezmin) < time()){
			$color_linea = "red";
			$color_letras = "white";
			$colorn = "red"; $colorna = "white";
			$colorh = "red"; $colorht = "white";
			$colors = "red"; $colorsq = "white";
			$colorc = "red"; $colorcp = "white";
			$colorm = "red"; $colorme = "white";
			$colorms = "red"; $colormsw = "white";
			$colorhd = "red"; $colorhhdd = "white";
		} else { $color_linea = "white";}
		echo "<td style=\"vertical-align:top;\"><table>";
			echo "<tr><td style=\"vertical-align:top;\">".$rowcs2["descripcion"]."</td></tr>";
			echo "<tr><td><table><tr>";
				echo "<td style=\"text-align:center;vertical-align:top;background-color:".$color_linea.";color:".$color_letras.";\">";
					$fecha_ser = date("Y-m-d H:i:s", $rowna["time_server"]);
					echo $fecha_ser."<br>";
					echo "<a href=\"index.php?op=".$_GET["op"]."&sop=".$ssop."&id=".$_GET["id"]."&id_serv=".$rowcs2["servidor"]."&id_cli=".$id_cliente."\" style=\"text-decoration: none;\"><img src=\"".$urlmgestion."/archivos_comunes/images/server_nagios.JPG\" style=\"border:0px;\"></a>";
				echo "</td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorc.";color:".$colorcp."\">".$Uso." CPU : ".$rowna["cpu"]."%</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorm.";color:".$colorme."\">".$Uso." ".$Memoria." : ".$rowna["mem"]."%</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorms.";color:".$colormsw."\">".$Uso." ".$Memoria." SWAP : ".$rowna["mem_swap"]."%</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorhd.";color:".$colorhhdd."\">".$Espacio." HD : ".number_format ( $hd,2,".",",")." Gb.</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorn.";color:".$colorna."\">Nagios : ".$nagios."</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colorh.";color:".$colorht."\">HTTP : ".$httpd."</td></tr>";
						echo "<tr><td style=\"text-align:left;background-color:".$colors.";color:".$colorsq."\">MYSQL : ".$mysqld."</td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr></table></td></tr>";
		echo "</table></td>";
		$i++;
	}
	echo "</tr>";
}

function detalleServidoresMonitorizados ($id_cliente,$id_serv,$color){
	global $db,$dbhandle,$Volver,$Dia,$Mes,$Any,$Ultimos,$Estados,$Buscar,$Fecha,$Registro,$Servidor,$Uso,$Memoria,$Espacio;
		$sqlcbd = "select * from sgm_clients_bases_dades where visible=1 and id_client in (".$id_cliente.")";
		$resultcbd = mysql_query(convert_sql($sqlcbd));
		$rowcbd = mysql_fetch_array($resultcbd);
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = decrypt($rowcbd["pass"],$simclau);
		$base = $rowcbd["base"];

		$sqlcsa = "select * from sgm_clients_servidors_param";
		$resultcsa = mysql_query(convert_sql($sqlcsa));
		$rowcsa = mysql_fetch_array($resultcsa);
		$cpu = $rowcsa["cpu"];
		$mem = $rowcsa["mem"];
		$memswap = $rowcsa["memswap"];
		$hhdd = $rowcsa["hd"];

		$sqlcs = "select * from sgm_clients_servidors where servidor=".$id_serv." and id_client in (".$id_cliente.") and visible=1";
		$resultcs = mysql_query(convert_sql($sqlcs,$dbhandle));
		$rowcs = mysql_fetch_array($resultcs);

		echo "<strong>".$Ultimos." ".$Estados." :</strong> ".$rowcs["descripcion"]."";
		echo "<br>";
			echo "<table><tr>";
					echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:".$color.";border:1px solid black\">";
						echo "<a href=\"javascript:history.go(-1);\" style=\"color:white;\">&laquo; ".$Volver."</a>";
					echo "</td>";
			echo "</tr></table>";
		echo "<br>";
		echo "<center><table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver\"><td>".$Dia."</td><td>".$Mes."</td><td>".$Any."</td><td></td></tr>";
			echo "<form action=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&id_cli=".$id_cliente."&id_serv=".$_GET["id_serv"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td><select name=\"dia\" style=\"width:40px\">";
					for ($i=1;$i<=31;$i++){
						if (($_POST["dia"] != "") and ($_POST["dia"] == $i)){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} elseif (($_POST["dia"] == "") and (date("j") == $i)) {
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} else {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					}
					echo "</select></td>";
				echo "<td><select name=\"mes\" style=\"width:40px\">";
					for ($i=1;$i<=12;$i++){
						if (($_POST["mes"] != "") and ($_POST["mes"] == $i)){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} elseif (($_POST["mes"] == "") and (date("n")) == $i) {
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} else {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					}
					echo "</select></td>";
				echo "<td><select name=\"any\" style=\"width:60px\">";
					for ($i=2013;$i<=2023;$i++){
						if (($_POST["any"] != "") and ($_POST["any"] == $i)){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} elseif (($_POST["any"] == "") and (date("Y") == $i)) {
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						} else {
							echo "<option value=\"".$i."\">".$i."</option>";
						}
					}
					echo "</select></td>";
					echo "<td><input type=\"submit\" value=\"".$Buscar."\"></td>";
			echo "</form>";
			echo "</tr>";
		echo "</table></center>";
		echo "<br><br>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:1200px\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<td style=\"text-align:center;width:150px\">".$Fecha." ".$Registro."</td>";
				echo "<td style=\"text-align:center;width:150px\">".$Fecha." ".$Servidor."</td>";
				echo "<td style=\"text-align:center;width:100px\">% ".$Uso." CPU</td>";
				echo "<td style=\"text-align:center;width:150px\">% ".$Uso." ".$Memoria."</td>";
				echo "<td style=\"text-align:center;width:150px\">% ".$Uso." ".$Memoria." SWAP</td>";
				echo "<td style=\"text-align:center;width:100px\">".$Espacio." HD</td>";
				echo "<td style=\"text-align:center;width:80px\">Nagios</td>";
				echo "<td style=\"text-align:center;width:80px\">HTTP</td>";
				echo "<td style=\"text-align:center;width:80px\">MYSQL</td>";
			echo "</tr>";

		$dbhandle2 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
		$db2 = mysql_select_db($base, $dbhandle2) or die("Couldn't open database $myDB");

		if ($_POST["dia"] != ""){
			$data_ini = (date(U, mktime (0,0,0,$_POST["mes"],$_POST["dia"],$_POST["any"])));
			$data_fin = (date(U, mktime (23,59,59,$_POST["mes"],$_POST["dia"],$_POST["any"])));
		} else {
			$data_ini = (date(U, mktime (0,0,0,date("n"),date("j"),date("Y"))));
			$data_fin = (date(U, mktime (23,59,59,date("n"),date("j"),date("Y"))));
		}
			$sqlna = "select * from sim_nagios where id_servidor=".$_GET["id_serv"]." and time_register between ".$data_ini." and ".$data_fin." order by time_register desc";
			$resultna = mysql_query(convert_sql($sqlna,$dbhandle2));
			while ($rowna = mysql_fetch_array($resultna)){
				if ($rowna["nagios"] == 0){ $nagios = "OFF"; $colorn = "red"; $colorna = "white"; } else { $nagios = "ON"; $colorn = "white"; $colorna = "black"; }
				if ($rowna["httpd"] == 0){ $httpd = "OFF"; $colorh = "red"; $colorht = "white"; } else { $httpd = "ON"; $colorh = "white"; $colorht = "black"; }
				if ($rowna["mysqld"] == 0){ $mysqld = "OFF"; $colors = "red"; $colormy = "white"; } else { $mysqld = "ON"; $colors = "white"; $colormy = "black"; }
				if ($rowna["cpu"] >= $cpu){ $colorc = "red"; $colorcp = "white"; } else { $colorc = "white"; $colorcp = "black"; }
				if ($rowna["mem"] >= $mem){ $colorm = "red"; $colorme = "white"; } else { $colorm = "white"; $colorme = "black"; }
				if ($rowna["mem_swap"] <= $memswap){ $colorms = "red"; $colormsw = "white"; } else { $colorms = "white"; $colormsw = "black"; }
				if ($rowna["hd"] <= $hhdd){ $colorhd = "red"; $colorhhdd = "white"; } else { $colorhd = "white"; $colorhhdd = "black"; }
				$difer = $rowna["time_register"] - $rowna["time_server"];
				if ($fechaant > 0){$difer2 = $fechaant - $rowna["time_register"];} else { $difer2=0;}
				if ((($difer < -600) or ($difer > 600)) or ($difer2 > 600)){ $colorti = "red"; $colorte = "white"; } else { $colorti = "white"; $colorte = "black"; }
				$fecha_reg = date("Y-m-d H:i:s", $rowna["time_register"]);
				$fecha_ser = date("Y-m-d H:i:s", $rowna["time_server"]);
				$hd = ($rowna["hd"]/1000000);
				echo "<tr>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorti.";color:".$colorte.";\">".$fecha_reg."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorti.";color:".$colorte.";\">".$fecha_ser."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorc.";color:".$colorcp.";\">".$rowna["cpu"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorm.";color:".$colorme.";\">".$rowna["mem"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorms.";color:".$colormsw.";\">".$rowna["mem_swap"]."</td>";
					echo "<td style=\"text-align:center;width:150px;heitgh:40px;background-color:".$colorhd.";color:".$colorhhdd.";\">".number_format ( $hd,2,".",",")." Gb.</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorn.";color:".$colorna.";\">".$nagios."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colorh.";color:".$colorht.";\">".$httpd."</td>";
					echo "<td style=\"text-align:center;width:80px;heitgh:40px;background-color:".$colors.";color:".$colormy.";\">".$mysqld."</td>";
				echo "</tr>";
				$fechaant = $rowna["time_register"];
			}
		mysql_close($dbhandle2);
		echo "</table>";
		echo "</center>";
}

function calendari_economic($rec){
	global $db;
	$mes = gmdate("n");
	$mes_anterior = date("U", mktime(0,0,0,$mes-1, 1, date("Y")));
	$mes_ultimo = date("U", mktime(0,0,0,$mes+12, 1-1, date("Y")));
	$dia_actual=$mes_anterior;
	$dia_actual1 = date("U", mktime(0,0,0,$mes-1, 1-1, date("Y")));
	if ($rec == 1) {$dia_actual=date("U", mktime(0,0,0,1,1,2012)); $dia_actual1=date("U", mktime(0,0,0,1,1-1,2012));}

	$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual1."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ($row){
		$saldo_inicial = $row["liquido"];
		$pagos_externos = $row["externos"];
	} else {
		$saldo_inicial = 0;
		$pagos_externos = 0;
	}

	while ($dia_actual<=$mes_ultimo){
		$dia_actual2 = date("Y-m-d", $dia_actual);
		$hoy = date("U", mktime(0,0,0,date("m"), date("d"), date("Y")));

		if ($hoy >= $dia_actual){
			$sqlgasto = "select sum(total) as total_gasto from sgm_cabezera where visible=1 and tipo=5 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
			$resultgasto = mysql_query($sqlgasto);
			$rowgasto = mysql_fetch_array($resultgasto);
		}
		if ($hoy == $dia_actual){
			$sqlgasto2 = "select sum(total) as total_gasto2 from sgm_cabezera where visible=1 and tipo=8 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		} elseif ($hoy < $dia_actual){
			$sqlgasto2 = "select sum(total) as total_gasto2 from sgm_cabezera where visible=1 and tipo in (5,8) and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		}
			$resultgasto2 = mysql_query($sqlgasto2);
			$rowgasto2 = mysql_fetch_array($resultgasto2);


		if ($hoy >= $dia_actual){
			$sqlingre1 = "select sum(total) as total_ingre1 from sgm_recibos where id_factura IN (select id from sgm_cabezera where visible=1 and tipo=1 and id_pagador=1 and cerrada=0) and fecha='".$dia_actual2."' and visible=1";
			$resultingre1 = mysql_query($sqlingre1);
			$rowingre1 = mysql_fetch_array($resultingre1);
		}
		if ($hoy <= $dia_actual){
			$sqlingre2 = "select sum(total) as total_ingre2 from sgm_cabezera where visible=1 and tipo=1 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1 and cerrada=0 and cobrada=0";
			$resultingre2 = mysql_query($sqlingre2);
			$rowingre2 = mysql_fetch_array($resultingre2);
		}

#		$sqlingre1 = "select sum(total) as total_ingre1 from sgm_cabezera where visible=1 and tipo=1 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
#		$resultingre1 = mysql_query($sqlingre1);
#		$rowingre1 = mysql_fetch_array($resultingre1);

		$sqlingre3 = "select sum(total) as total_ingre3 from sgm_cabezera where visible=1 and tipo=7 and fecha_vencimiento='".$dia_actual2."' and id_pagador=1";
		$resultingre3 = mysql_query($sqlingre3);
		$rowingre3 = mysql_fetch_array($resultingre3);
		$sqliv = "select sum(total) as total_ingreso_varios from sgm_cabezera where visible=1 and tipo=9 and fecha_vencimiento = '".$dia_actual2."' and id_pagador=1";
		$resultiv = mysql_query($sqliv);
		$rowiv = mysql_fetch_array($resultiv);
		$sqlprep = "select sum(total) as total_prep from sgm_cabezera where visible=1 and tipo=10 and fecha_vencimiento = '".$dia_actual2."' and id_pagador=1";
		$resultprep = mysql_query($sqlprep);
		$rowprep = mysql_fetch_array($resultprep);
		$sqlex = "select sum(total) as total_externos from sgm_cabezera where visible=1 and fecha_vencimiento = '".$dia_actual2."' and id_pagador<>1";
		$resultex = mysql_query($sqlex);
		$rowex = mysql_fetch_array($resultex);
		$total_gastos = $rowgasto["total_gasto"] + $rowgasto2["total_gasto2"];
		$saldo_actual = $saldo_inicial - $rowgasto["total_gasto"] - $rowgasto2["total_gasto2"] + ($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowingre3["total_ingre3"]) + $rowiv["total_ingreso_varios"];
		$ingresos = ($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowingre3["total_ingre3"] + $rowiv["total_ingreso_varios"]);
		$pagos_externos = $pagos_externos + $rowex["total_externos"];
#		echo date("Y-m-d", $dia_actual)."<br>Saldo : ".$saldo_inicial." - Ingresos :".($rowingre1["total_ingre1"] + $rowingre2["total_ingre2"] + $rowiv["total_ingreso_varios"])." - Gastos : ".$rowgasto["total_gasto"]." - Saldo Final:".$saldo_actual."<br>";
		$sql = "select * from sgm_factura_calendario where fecha='".$dia_actual."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if (!$row){
			$sql = "insert into sgm_factura_calendario (fecha,gastos,ingresos,pre_pagos,externos,liquido) ";
			$sql = $sql."values (";
			$sql = $sql."".$dia_actual."";
			$sql = $sql.",'".$total_gastos."'";
			$sql = $sql.",'".$ingresos."'";
			$sql = $sql.",'".$rowprep["total_prep"]."'";
			$sql = $sql.",'".$pagos_externos."'";
			$sql = $sql.",'".$saldo_actual."'";
			$sql = $sql.")";
			mysql_query($sql);
#			echo $sql."in<br>";
		} else {
			$sql = "update sgm_factura_calendario set ";
			$sql = $sql."gastos='".$total_gastos."'";
			$sql = $sql.",ingresos='".$ingresos."'";
			$sql = $sql.",pre_pagos='".$rowprep["total_prep"]."'";
			$sql = $sql.",externos='".$pagos_externos."'";
			$sql = $sql.",liquido='".$saldo_actual."'";
			$sql = $sql." WHERE fecha=".$dia_actual."";
			mysql_query($sql);
#			echo $sql."<br>";
		}
		$saldo_inicial = $saldo_actual;
		$proxim_any = date("Y",$dia_actual);
		$proxim_mes = date("m",$dia_actual);
		$proxim_dia = date("d",$dia_actual);
		$dia_actual = date("U",mktime(0,0,0,$proxim_mes,$proxim_dia+1,$proxim_any));
		$iva1=0;
		$iva2=0;
		$iva3=0;
		$iva4=0;
		$irpf1=0;
		$irpf2=0;
		$irpf3=0;
		$irpf4=0;
		$rowgasto["total_gasto"]=0;
		$rowingre1["total_ingre1"]=0;
	}
}

function correo_incidencias(){
	global $db,$buzon_correo,$buzon_usuario,$buzon_pass;

	$imap = imap_open ($buzon_correo, $buzon_usuario, $buzon_pass) or die("No Se Pudo Conectar Al Servidor:".imap_last_error());
#	$imap = imap_open ("{mail.solucions-im.com:143/imap/notls}INBOX", "soporte@solucions-im.com", "Multi12") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
	$checar = imap_check($imap);
	// Detalles generales de todos los mensajes del usuario.
	$resultados = imap_fetch_overview($imap,"1:{$checar->Nmsgs}",0);
	// Ordenamos los mensajes arriba los más nuevos y abajo los más antiguos
#	krsort($resultados);
	foreach ($resultados as $detalles) {
		$id_cliente = 0;
		$id_usuario = 0;

		$destinatario = imap_utf8($detalles->to);
		$destinatario = str_replace('"','',$destinatario);
		$destinatario = str_replace("'","",$destinatario);
		$uid = $detalles->uid;
		$sqli = "select * from sgm_incidencias_correos";
		$resulti = mysql_query($sqli);
		$rowi = mysql_fetch_array($resulti);
		if ($rowi["uid"]<$uid) {
			$sql = "update sgm_incidencias_correos set ";
			$sql = $sql."uid=".$uid;
			mysql_query($sql);
#			echo $sql."<br>";

			$asunto = imap_utf8($detalles->subject);
			$remitente = imap_utf8($detalles->from);
			$remite = imap_headerinfo($imap,$detalles->msgno);
			$correo_rem = $remite->from;
			foreach ($correo_rem as $correo_remite) {
				$correo_remitente = $correo_remite->mailbox."@".$correo_remite->host;
			}

#			$fecha = $detalles->date;
#			$id = $detalles->message_id;
#			$num_mensage = $detalles->msgno;
			$leido = $detalles->seen;
			$estructura = imap_fetchstructure($imap,$detalles->msgno);
			$flattenedParts = flattenParts($estructura->parts);
			if ($flattenedParts){
				foreach($flattenedParts as $partNumber => $part) {
					switch($part->type) {
						case 0:
							// the HTML or plain text part of the email
							$message = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
							// now do something with the message, e.g. render it
							$message = str_replace("</p>","\r\n",$message);
							$message = strip_tags($message,'\r\n');
							$message = str_replace("&nbsp;", "", $message);
							$message = trim($message);
						break;
					
						case 1:
							// multi-part headers, can ignore
					
						break;
						case 2:
							// attached message headers, can ignore
						break;
					
						case 3: // application
						case 4: // audio
						case 5: // image
							$tipus = "image/";
						case 6: // video
						case 7: // other
							$filename = getFilenameFromPart($part);
							$tipus .= $part->subtype;
							$size = $part->bytes;
							if($filename) {
								// it's an attachment
								$attachment = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
								// now do something with the attachment, e.g. save it somewhere
								file_put_contents("../sim/files/incidencias/".$filename,$attachment,FILE_APPEND); 
							}
							else {
								// don't know what it is
							}
						break;
					}
	#				echo "<pre>".var_dump($message)."</pre>";
				}
			} else {
				$message = imap_body($imap, $detalles->msgno);
			}
#			echo "<img src=\"".$filename."\">";

			$cabeza = imap_header($imap, $detalles->msgno );
			$data_missatge = strtotime($cabeza->MailDate);
			$data = time();

			$sqlum = "select * from sgm_users where mail='".$correo_remitente."'";
			$resultum = mysql_query($sqlum);
			$rowum = mysql_fetch_array($resultum);
			if ($rowum){
				$sqluc = "select * from sgm_users_clients where id_user=".$rowum["id"];
				$resultuc = mysql_query($sqluc);
				$rowuc = mysql_fetch_array($resultuc);
				$id_cliente = $rowuc["id_client"];
				$id_usuario = $rowum["id"];
			} else {
				$sqlcc = "select * from sgm_clients_contactos where mail='".$correo_remitente."'";
				$resultcc = mysql_query($sqlcc);
				$rowcc = mysql_fetch_array($resultcc);
				if ($rowcc){
					$id_cliente = $rowcc["id_client"];
					$id_usuario = 0;
				} else {
					$sqlumh = "select * from sgm_users where mail like '%@".$correo_remite->host."'";
					$resultumh = mysql_query($sqlumh);
					$rowumh = mysql_fetch_array($resultumh);
					if ($rowumh){
						$sqluch = "select * from sgm_users_clients where id_user=".$rowumh["id"];
						$resultuch = mysql_query($sqluch);
						$rowuch = mysql_fetch_array($resultuch);
						$id_cliente = $rowuch["id_client"];
						$id_usuario = 0;
					}
				}
			}
			if ($id_usuario == "") { $id_usuario = 0;}
			if ($id_cliente == "") { $id_cliente = 0;}
			if ($asunto == "") { $asunto = "Sense assumpte";}
#			if (($remitente != "guardian@grupserhs.com") and ($remitente != "soporte@solucions-im.com")){
			if ($remitente != "soporte@solucions-im.com") {
				$sql = "insert into sgm_incidencias (correo,id_usuario_registro,id_usuario_origen,id_cliente,fecha_registro_inicio,fecha_inicio,id_estado,id_entrada,notas_registro,asunto,pausada)";
				$sql = $sql."values (";
				$sql = $sql."1";
				$sql = $sql.",".$id_usuario."";
				$sql = $sql.",".$id_usuario."";
				$sql = $sql.",".$id_cliente."";
				$sql = $sql.",".$data."";
				$sql = $sql.",".$data_missatge."";
				$sql = $sql.",-1";
				$sql = $sql.",3";
				$sql = $sql.",'".comillas(utf8_decode($message))."'";
				$sql = $sql.",'".comillas(utf8_decode($asunto))."'";
				$sql = $sql.",0";
				$sql = $sql.")";
				mysql_query($sql);
#	echo $sql."<br>";
				if ($filename){
					$sqlin = "select * from sgm_incidencias where fecha_registro_inicio=".$data." and fecha_inicio=".$data_missatge." and asunto='".comillas($asunto)."'";
					$resultin = mysql_query($sqlin);
					$rowin = mysql_fetch_array($resultin);
					$sql2 = "insert into sgm_files (id_tipo,name,type,size,id_incidencia)";
					$sql2 = $sql2."values (";
					$sql2 = $sql2."1";
					$sql2 = $sql2.",'".$filename."'";
					$sql2 = $sql2.",'".$tipus."'";
					$sql2 = $sql2.",".$size;
					$sql2 = $sql2.",".$rowin["id"];
					$sql2 = $sql2.")";
					mysql_query($sql2);
#	echo $sql2."<br>";
				}
			}
		if ($leido == 0){imap_clearflag_full($imap, $uid, '\\Seen');}
		}
	}

	imap_close($imap, CL_EXPUNGE);

}

function getPart($connection, $messageNumber, $partNumber, $encoding) {
	
	$data = imap_fetchbody($connection, $messageNumber, $partNumber);
	switch($encoding) {
		case 0: return $data; // 7BIT
		case 1: return $data; // 8BIT
		case 2: return $data; // BINARY
		case 3: return base64_decode($data); // BASE64
		case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
		case 5: return $data; // OTHER
	}
}

function getFilenameFromPart($part) {

	$filename = '';
	
	if($part->ifdparameters) {
		foreach($part->dparameters as $object) {
			if(strtolower($object->attribute) == 'filename') {
				$filename = $object->value;
			}
		}
	}

	if(!$filename && $part->ifparameters) {
		foreach($part->parameters as $object) {
			if(strtolower($object->attribute) == 'name') {
				$filename = $object->value;
			}
		}
	}
	
	return $filename;
	
}

function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {

	foreach($messageParts as $part) {
		$flattenedParts[$prefix.$index] = $part;
		if(isset($part->parts)) {
			if($part->type == 2) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
			}
			elseif($fullPrefix) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
			}
			else {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
			}
			unset($flattenedParts[$prefix.$index]->parts);
		}
		$index++;
	}

	return $flattenedParts;
}

function simAlert(){
	global $db,$dbhandle;
	$diezmin = 600;
	$fechaant = 0;

	$sqlcsa = "select * from sgm_clients_servidors_param";
	$resultcsa = mysql_query($sqlcsa,$dbhandle);
	$rowcsa = mysql_fetch_array($resultcsa);
	$cpu = $rowcsa["cpu"];
	$mem = $rowcsa["mem"];
	$memswap = $rowcsa["memswap"];
	$hhdd = $rowcsa["hd"];

	$sqlcbd = "select * from sgm_clients_bases_dades where visible=1";
	$resultcbd = mysql_query($sqlcbd,$dbhandle);
	while ($rowcbd = mysql_fetch_array($resultcbd)){
		$ip = $rowcbd["ip"];
		$usuario = $rowcbd["usuario"];
		$pass = $rowcbd["pass"];
		$base = $rowcbd["base"];
		$id_cliente=$rowcbd["id_client"];

		$sqlcsi = "select * from sgm_clients_servidors where id_client=".$id_cliente." and visible=1";
		$resultcsi= mysql_query($sqlcsi,$dbhandle);
		while ($rowcsi = mysql_fetch_array($resultcsi)){
			$nagiosServ = 0;
			$httpdServ = 0;
			$mysqldServ = 0;
			$cpuServ = 0;
			$memServ = 0;
			$memswapServ = 0;
			$hhddServ = 0;

			$dbhandle3 = mysql_connect($ip, $usuario, $pass, true) or die("Couldn't connect to SQL Server on $dbhost");
			$db3 = mysql_select_db($base, $dbhandle3) or die("Couldn't open database $myDB");

			$sqlnac = "select count(*) as total from sim_nagios where id_servidor=".$rowcsi["servidor"]."";
			if ($rowcsi["indice"] > 0){ $sqlnac .= " and id >= ".$rowcsi["indice"]; }
			$sqlnac .=" order by time_register";
			$resultnac = mysql_query($sqlnac,$dbhandle3);
			$rownac = mysql_fetch_array($resultnac);
			$i = $rownac["total"];

			$sqlna = "select * from sim_nagios where id_servidor=".$rowcsi["servidor"]."";
			if ($rowcsi["indice"] > 0){ $sqlna .= " and id >= ".$rowcsi["indice"]; }
			$sqlna .=" order by time_register";
			$resultna = mysql_query($sqlna,$dbhandle3);
			while ($rowna = mysql_fetch_array($resultna)){

				$text= $id_cliente." - ".$rowcsi["servidor"]." - ".date("Y-m-d H:i:s", $rowna["time_register"])."<br>";

				if ($fechaant != 0){
					$maxtime = $fechaant + $diezmin;
					if ($rowna["time_register"] > $maxtime){
						echo insertar_alerta($id_cliente, $rowcsi["servidor"], $fechaant, $rowna["time_register"], $rowna["id"], "81");
						$text.= " - 81/n";
						echo controlLog($text);
					}

					if (($i != 1) and (($rowna["time_register"]+$diezmin) < time())){
						echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "82");
						$text.= " - 82/n";
						echo controlLog($text);
					}
				}

				if ($rowna["nagios"] == 0){
					if($nagiosant == 0) {$nagiosServ++;} else {$nagiosServ = 0;}
				} else {
					$nagiosServ = 0;
				}
				if ($rowna["httpd"] == 0){
					if($httpdant == 0) {$httpdServ++;} else {$httpdServ = 0;}
				} else {
					$httpdServ = 0;
				}
				if ($rowna["mysqld"] == 0){
					if($mysqldant == 0) {$mysqldServ++;} else {$mysqldServ = 0;}
				} else {
					$mysqldServ = 0;
				}
				if ($rowna["cpu"] > $cpu){
					if($cpuant > $cpu) {$cpuServ++;} else {$cpuServ = 0;}
				} else {
					$cpuServ = 0;
				}
				if ($rowna["mem"] > $mem){
					if($memant > $mem) {$memServ++;} else {$memServ = 0;}
				} else {
					$memServ = 0;
				}
				if ($rowna["mem_swap"] < $memswap){
					if($memswapant < $memswap) {$memswapServ++;} else {$memswapServ = 0;}
				} else {
					$memswapServ = 0;
				}
				if ($rowna["hd"] < $hhdd){
					if($hhddant < $hhdd) {$hhddServ++;} else {$hhddServ = 0;}
				} else {
					$hhddServ = 0;
				}

				if ($nagiosServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "1");
					$nagiosServ = 0;
					$text.= " - 1/n";
					echo controlLog($text);
				}
				if ($httpdServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "2");
					$httpdServ = 0;
					$text.= " - 2/n";
					echo controlLog($text);
				}
				if ($mysqldServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "3");
					$mysqldServ = 0;
					$text.= " - 3/n";
					echo controlLog($text);
				}
				if ($cpuServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "4");
					$cpuServ = 0;
					$text.= " - 4/n";
					echo controlLog($text);
				}
				if ($memServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "5");
					$memServ = 0;
					$text.= " - 5/n";
					echo controlLog($text);
				}
				if ($memswapServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "6");
					$memswapServ = 0;
					$text.= " - 6/n";
					echo controlLog($text);
				}
				if ($hhddServ == 3){
					echo insertar_alerta($id_cliente, $rowcsi["servidor"], $rowna["time_register"], 0, $rowna["id"], "7");
					$hhddServ = 0;
					$text.= " - 7/n";
					echo controlLog($text);
				}
#				echo $nagiosServ."-".$httpdServ."-".$mysqldServ."-".$cpuServ."-".$memServ."-".$memswapServ."-".$hhddServ."-".$rowna["time_register"]."<br>";
				$fechaant = $rowna["time_register"];
				$i--;
				$indice = $rowna["id"];
				$nagiosant = $rowna["nagios"];
				$httpdant = $rowna["httpd"];
				$mysqldant = $rowna["mysqld"];
				$cpuant = $rowna["cpu"];
				$memant = $rowna["mem"];
				$memswapant = $rowna["mem_swap"];
				$hhddant = $rowna["hd"];
			}
			$sql = "update sgm_clients_servidors set ";
			$sql = $sql."indice=".$indice."";
			$sql = $sql." WHERE id_client=".$id_cliente." and servidor=".$rowcsi["servidor"];
			mysql_query($sql,$dbhandle);
		}
	}
}

function insertar_alerta($id_cliente, $servidors, $fechaant, $fechaact, $id, $error)
{
	global $db;
	$sqlcsa = "select * from sgm_clients_servidors_alertes where servidor=".$servidors." and id_cliente=".$id_cliente." and fecha_caida=".$fechaant;
	$resultcsa= mysql_query($sqlcsa,$dbhandle);
	$rowcsa = mysql_fetch_array($resultcsa);
	if (($fechaant != 0) and (!$rowcsa)){
		$sql = "insert into sgm_clients_servidors_alertes (servidor, id_cliente, fecha_caida, caido, error) ";
		$sql = $sql."values (";
		$sql = $sql."".$servidors."";
		$sql = $sql.",".$id_cliente."";
		$sql = $sql.",".$fechaant."";
		$sql = $sql.",0";
		$sql = $sql.",".$error."";
		$sql = $sql.")";
		mysql_query($sql);
#echo $sql."<br>";

		$sqlc = "select * from sgm_clients where id=".$id_cliente."";
		$resultc= mysql_query($sqlc,$dbhandle);
		$rowc = mysql_fetch_array($resultc);
		$sqlcos = "select * from sgm_contratos_servicio where servicio like '%inci%' and id_contrato in (select id from sgm_contratos where id_cliente=".$id_cliente." and activo=1 and id_contrato_tipo between 1 and 2)";
		$resultcos= mysql_query($sqlcos,$dbhandle);
		$rowcos = mysql_fetch_array($resultcos);
		$sqlcsi = "select * from sgm_clients_servidors where id_client=".$id_cliente." and id=".$servidors;
		$resultcsi= mysql_query($sqlcsi);
		$rowcsi = mysql_fetch_array($resultcsi);
		$sql = "insert into sgm_incidencias (id_usuario_destino,id_usuario_origen,id_servicio,fecha_inicio,fecha_registro_inicio,fecha_prevision,id_estado,id_entrada,notas_registro,asunto)";
		$sql = $sql."values (";
		$sql = $sql."28";
		$sql = $sql.",28";
		if ($rowcos["id"] != 0){
			$sql = $sql.",".$rowcos["id"]."";
		} else {
			$sql = $sql.",0";
		}
		$data = time();
		$sql = $sql.",".$data."";
		$sql = $sql.",".$data."";
		$prevision = fecha_prevision($rowcos["id"], $data);
		$sql = $sql.",".$prevision."";
		$sql = $sql.",-1";
		$sql = $sql.",4";
		if($error == 1) {$texto_error = 'servicio nagios';}
		if($error == 2) {$texto_error = 'servicio httpd';}
		if($error == 3) {$texto_error = 'servicio mysqld';}
		if($error == 4) {$texto_error = 'espacio CPU';}
		if($error == 5) {$texto_error = 'memoria';}
		if($error == 6) {$texto_error = 'memoria swap';}
		if($error == 7) {$texto_error = 'disco duro';}
		if($error == 8) {$texto_error = 'tiempo de respuesta';}
		$sql = $sql.",'El servidor ".$rowcsi["descripcion"]." del cliente ".$rowc["nombre"]." tiene una alerta ".$texto_error."'";
		$sql = $sql.",'Alerta servidor ".$rowcsi["descripcion"]."'";
		$sql = $sql.")";
		mysql_query($sql);
#echo $sql."<br>";
#		send_mail("Alerta servidor ".$rowcsi["descripcion"]."","El servidor ".$rowcsi["descripcion"]." del cliente ".$rowc["nombre"]." tiene una alerta ".$texto_error."");
	}
	if ($fechaact != 0) {
		$sqlcsa = "select * from sgm_clients_servidors_alertes where servidor=".$servidors." and id_cliente=".$id_cliente." and error=".$error." and caido=0 order by id desc";
		$resultcsa= mysql_query($sqlcsa,$dbhandle);
		$rowcsa = mysql_fetch_array($resultcsa);
		if ($rowcsa){
			$tiempo = $fechaact - $rowcsa["fecha_caida"];
			$sql = "update sgm_clients_servidors_alertes set ";
			$sql = $sql."fecha_subida=".$fechaact."";
			$sql = $sql.",tiempo=".$tiempo."";
			$sql = $sql.",caido=1";
			$sql = $sql." WHERE id=".$rowcsa["id"]."";
			mysql_query($sql);
#echo $sql."<br>";
		}
	}
}

function controlLog($text){
	if (!$gestor = fopen("controlLog.txt", "a+")) { echo "No se pueden grabar los datos de registro de accesos."; }
	if (fwrite($gestor, $text.Chr(13)) === FALSE) { echo "Cannot write to file ($filename)"; }
}

function encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return base64_encode($result);
}

function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

function informesContratos(){
	global $db,$Informes,$Cliente,$Mes,$Ano,$Horas,$Imprimir,$urlmgestion,$Contrato,$Ver_Horas,$Hasta,$Si,$No;
	echo "<strong>".$Informes."</strong>";
	echo "<br><br>";
	echo "<center><table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
		if ($_GET["id"] <= 0) {
			echo "<td>".$Cliente."</td>";
		}
			echo "<td>".$Contrato."</td>";
			echo "<td>".$Mes."-".$Ano."</td>";
			echo "<td>".$Mes."-".$Ano." ".$Hasta."</td>";
			echo "<td>".$Ver_Horas."</td>";
			echo "<td></td>";
		echo "</tr><tr>";
			echo "<form method=\"post\" name=\"form2\" action=\"".$urlmgestion."/mgestion/gestion-contratos-informe-print-pdf.php\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
		if ($_GET["id"] <= 0) {
			echo "<td><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:300px\" onchange=\"desplegableCombinado5()\">";
				echo "<option value=\"0\">Todos</option>";
				$sqli = "select * from sgm_clients where visible=1 and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
				$resulti = mysql_query(convert_sql($sqli));
				while ($rowi = mysql_fetch_array($resulti)) {
					if ($_POST["id_cliente"] == $rowi["id"]){
						echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["nombre"]." ".$rowi["apellido1"]." ".$rowi["apellido2"]."</option>";
					} else {
						echo "<option value=\"".$rowi["id"]."\">".$rowi["nombre"]." ".$rowi["apellido1"]." ".$rowi["apellido2"]."</option>";
					}
				}
			echo "</select></td>";
		} else {
			echo "<input type=\"Hidden\" value=\"".$_GET["id"]."\" name=\"id_cliente\">";
		}
			echo "<td><select name=\"id_contrato\" id=\"id_contrato\" style=\"width:300px\" onchange=\"desplegableCombinado5()\">";
			if ($_GET["id"] <= 0) {
				echo "<option value=\"0\">Todos</option>";
			
			}
				$sqlc = "select id,descripcion from sgm_contratos where visible=1 and id_cliente=".$_POST["id_cliente"].$_GET["id"];
				$resultc = mysql_query(convert_sql($sqlc));
				while ($rowc = mysql_fetch_array($resultc)) {
					if ($_POST["id_contrato"] == $rowc["id"]){
						echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$rowc["id"]."\">".$rowc["descripcion"]."</option>";
					}
				}
			echo "</select></td>";
			$sqlco = "select * from sgm_contratos where id=".$_POST["id_contrato"]." order by fecha_ini";
			$resultco = mysql_query(convert_sql($sqlco));
			$rowco = mysql_fetch_array($resultco);
			if ($rowco){
				$mes_ini = date("U",strtotime($rowco["fecha_ini"]));
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
				$mes_act = $mes_ini;
			} else {
				$count = 1;
				$sqlco2 = "select fecha_ini,fecha_fin from sgm_contratos where visible=1";
				if ($_POST["id_cliente"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysql_query(convert_sql($sqlco2));
				while ($rowco2 = mysql_fetch_array($resultco2)){
					if ($count == 1) {
						$mes_ini = date("U",strtotime($rowco2["fecha_ini"])); $mes_fin = date("U",strtotime($rowco2["fecha_fin"])); $count ++;
					} else {
						if ($rowco2["fecha_ini"] < $mes_ini) {$mes_ini = date("U",strtotime($rowco2["fecha_ini"]));}
						if ($rowco2["fecha_fin"] > $mes_fin) {$mes_fin = date("U",strtotime($rowco2["fecha_fin"]));}
					}
				}
				$mes_act = $mes_ini;
			}
			echo "<td style=\"width:100px;\"><select name=\"fecha\" style=\"width:150px;\" onchange=\"desplegableCombinado5()\">";

				while (($mes_ini<=$mes_act) and (($mes_act<=$mes_fin) and ($mes_act<=time()))){
					$any_inicio = date("Y",$mes_act);
					$mes_inicio = date("m",$mes_act);

					if ($_POST["fecha"] == $mes_inicio."-".$any_inicio){
						echo "<option value=\"".$mes_inicio."-".$any_inicio."\" selected>".$mes_inicio."-".$any_inicio."</option>";
					} else {
						echo "<option value=\"".$mes_inicio."-".$any_inicio."\">".$mes_inicio."-".$any_inicio."</option>";
					}
					$proxim_any = date("Y",$mes_act);
					$proxim_mes = date("m",$mes_act);
					$proxim_dia = date("d",$mes_act);
					$mes_act = date("U",mktime(0,0,0,$proxim_mes+1,$proxim_dia,$proxim_any));
					
				}
			echo "</select></td>";
			$sqlco = "select * from sgm_contratos where id=".$_POST["id_contrato"]." order by fecha_ini";
			$resultco = mysql_query(convert_sql($sqlco));
			$rowco = mysql_fetch_array($resultco);
			if ($rowco){
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
			} else {
				$mes_fin = 0;
				$count = 1;
				$sqlco2 = "select fecha_ini,fecha_fin from sgm_contratos where visible=1 and activo=1";
				if ($_POST["id_cliente"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysql_query(convert_sql($sqlco2));
				while ($rowco2 = mysql_fetch_array($resultco2)){
					if ($count == 1) {
						$mes_fin = date("U",strtotime($rowco2["fecha_fin"])); $count ++;
					} else {
						if ($rowco2["fecha_fin"] > $mes_fin) {$mes_fin = date("U",strtotime($rowco2["fecha_fin"]));}
					}
				}
			}

			$fecha_ini = date("U",strtotime("01-".$_POST["fecha"]));
			if (($_POST["fecha"] > 0) and ($fecha_ini > $mes_ini)){
				list($mes,$any) = explode ("-",$_POST["fecha"]);
			} else {
				$any = date("Y",$mes_ini);
				$mes = date("m",$mes_ini);
			}
			$mes_ini2 = date("U",mktime(0,0,0,$mes+1,1,$any));

			$mes_act = $mes_ini2;
			echo "<td style=\"width:100px;\"><select name=\"fecha_hasta\" style=\"width:150px;\">";
				echo "<option value=\"0\">-</option>";
				while (($mes_ini<=$mes_act) and (($mes_act<=$mes_fin) and ($mes_act<=time()))){
					$any_inicio = date("Y",$mes_act);
					$mes_inicio = date("m",$mes_act);

					echo "<option value=\"".$mes_inicio."-".$any_inicio."\">".$mes_inicio."-".$any_inicio."</option>";
					$proxim_any = date("Y",$mes_act);
					$proxim_mes = date("m",$mes_act);
					$proxim_dia = date("d",$mes_act);
					$mes_act = date("U",mktime(0,0,0,$proxim_mes+1,$proxim_dia,$proxim_any));
					
				}
			echo "</select></td>";
			echo "<td><select name=\"horas\" style=\"width:50px\">";
				if ($_POST["horas"] == 0){
					echo "<option value=\"0\" selected>".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				} else {
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\" selected>".$Si."</option>";
				}
			echo "</select></td>";
			echo "<td><input type=\"Submit\" value=\"".$Imprimir."\" style=\"width:100px\"></td>";
			echo "</form>";
		echo "</tr>";
	echo "</table></center>";
}

?>
