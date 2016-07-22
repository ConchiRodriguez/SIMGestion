<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";  }
if (($option == 1011) AND ($autorizado == true)) {

	$sqldiv = "select * from sim_divisas where visible=1 and predefinido=1";
	$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
	$rowdiv = mysqli_fetch_array($resultdiv);


	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Contratos."</h4>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if (($soption >= 0) and ($soption < 100)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1011&sop=0\" class=".$class.">".$Contratos."</a></td>";
					if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1011&sop=100\" class=".$class.">".$Anadir." ".$Contrato."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1011&sop=200\" class=".$class.">".$Buscar." ".$Contrato."</a></td>";
					if ($soption == 210) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1011&sop=210\" class=".$class.">".$Indicadores."</a></td>";
					if ($soption == 290) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1011&sop=290\" class=".$class.">".$Informes."</a></td>";
					if (($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1011&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr></table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 1) or ($soption == 200)) {
		if ($ssoption == 1) {
			$sqlcc = "select id from sim_contratos where visible=1 and id_contrato_tipo=".$_POST["id_contrato_tipo"]." and id_cliente=".$_POST["id_cliente"]." and id_cliente_final=".$_POST["id_cliente_final"]." and num_contrato=".$_POST["num_contrato"]." and fecha_ini='".$_POST["fecha_ini"]."' and fecha_fin='".$_POST["fecha_fin"]."' and descripcion='".$_POST["descripcion"]."'";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if (!$rowcc){
				$camposInsert = "id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico";
				$datosInsert = array($_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["num_contrato"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"]);
				insertFunction ("sim_contratos",$camposInsert,$datosInsert);

				$sqlc = "select id from sim_contratos where num_contrato='".$_POST["num_contrato"]."' and visible=1";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				$sqlcs = "select * from sim_contratos_servicio where visible=1 and id_contrato=0 and id<0";
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)) {
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,tiempo_respuesta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["tiempo_respuesta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"]);
					insertFunction ("sim_contratos_servicio",$camposInsert,$datosInsert);
				}
			}
		}
		if ($ssoption == 3) {
			$borrar = 0;
			$sql = "select id from sim_contratos_servicio where visible=1 and id_contrato=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$sqli = "select count(*) as total from sim_incidencias where visible=1 and id_servicio=".$row["id"];
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				$rowi = mysqli_fetch_array($resulti);
				if ($rowi["total"] > 0){$borrar = 1;}
			}
			if ($borrar == 1){
				mensageError($ContratoErrorEliminar);
			} else {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sim_contratos",$_GET["id"],$camposUpdate,$datosUpdate);

				$sqlf = "select id from sim_cabezera where visible=1 and id_contrato=".$_GET["id"];
				$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
				while ($rowf = mysqli_fetch_array($resultf)){
					$camposUpdate = array("visible");
					$datosUpdate = array("0");
					updateFunction ("sim_cabezera",$rowf["id"],$camposUpdate,$datosUpdate);
					$sql = "select id from sim_cuerpo where idfactura=".$rowf["id"]."";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)){
						deleteCuerpo($row["id"],$rowf["id"]);
					}
				}

			}
		}
		if ($soption == 0) { echo "<strong>".$Actual."</strong>";}
		if ($soption == 1) { echo "<strong>".$Historico."</strong>";}
		if ($soption == 200) { echo "<strong>".$Buscador."</strong>";}
		echo "<br><br>";
		if ($soption != 200){
			echo "<table><tr>";
				echo "<td>";
					if ($soption == 1) { echo boton(array("op=1011&sop=0"),array($Activo));}
					if ($soption == 0) { echo boton(array("op=1011&sop=1"),array($Inactivo));}
				echo "</td>";
			echo "</tr></table>";
			echo "<br><br>";
		}
		echo "<center>";
		if ($soption == 200){
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"background-color:silver;\">";
				echo "<form action=\"index.php?op=1011&sop=200\" method=\"post\">";
				echo "<tr>";
					echo "<th>".$Contrato."</th>";
					echo "<th>".$Cliente."</th>";
					echo "<th>".$Cliente." ".$Final."</th>";
					echo "<th></th>";
					echo "<th></th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><select style=\"width:250px\" name=\"id_contrato_tipo2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select id,nombre from sim_contratos_tipos where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_contrato_tipo2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_cliente2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select id,nombre,cognom1,cognom2 from sim_clients where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_cliente2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:250px\" name=\"id_cliente_final2\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select id,nombre,cognom1,cognom2 from sim_clients where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_cliente_final2"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"".$Buscar."\"></td>";
				echo "</tr>";
				echo "</form>";
			echo "</table>";
			echo "<br><br>";
		}
		if (($soption != 200) or ($_POST["id_contrato_tipo2"] > 0) or ($_POST["id_cliente2"] > 0) or ($_POST["id_cliente_final2"] > 0)){
			echo "<table cellpadding=\"3\" cellspacing=\"0\" class=\"lista\">";
				echo "<form action=\"index.php?op=1011&sop=100&ssop=1\" method=\"post\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<th>".$Eliminar."</th>";
					echo "<th>".$Cliente."</th>";
					echo "<th>".$Cliente." ".$Final."</th>";
					echo "<th>".$Descripcion."</th>";
					echo "<th>".$Editar."</th>";
					echo "<th>".$Ver."</th>";
				echo "</tr>";
#				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sim_contratos where visible=1 and id_plantilla<>0 ";
				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sim_contratos where visible=1 ";
				if ($_POST["id_contrato_tipo2"] > 0) {
					$sqlcc = $sqlcc." and id_contrato_tipo=".$_POST["id_contrato_tipo2"]."";
				}
				if ($_POST["id_cliente2"] > 0) {
					$sqlcc = $sqlcc." and id_cliente=".$_POST["id_cliente2"]."";
				}
				if ($_POST["id_cliente_final2"] > 0) {
					$sqlcc = $sqlcc." and id_cliente_final=".$_POST["id_cliente_final2"]."";
				}
				if ($soption == 0){ $sqlcc = $sqlcc." and activo=1";}
				if ($soption == 1){ $sqlcc = $sqlcc." and activo=0";}
				$sqlcc = $sqlcc." order by num_contrato desc";
#				echo $sqlcc."<br>";
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				while ($rowcc = mysqli_fetch_array($resultcc)){
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=10&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						$sql = "select id,nombre from sim_clients where visible=1 and id=".$rowcc["id_cliente"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sql = "select id,nombre from sim_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						echo "<td><a href=\"index.php?op=1011&sop=100&id=".$rowcc["id"]."\">".$rowcc["descripcion"]."</a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=100&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" alt=\"Editar\" border=\"0\"></a></td>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1008&sop=142&id=".$row["id"]."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\"></a></td>";
					echo "</tr>";
				}
			echo "</table>";
		}
	}

	if ($soption == 10) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=0&ssop=3&id=".$_GET["id"],"op=1011&sop=0"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 100) {
		if ($_GET["id"] != "") { echo "<h4>".$Editar." ".$Contrato." : </h4>";} else { echo "<h4>".$Anadir." ".$Contrato." : </h4>";}
		mostrarContrato ($_GET["id"],0,101,102);
	}

	if ($soption == 101) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=100&ssop=4&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"],"op=1011&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 102) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=100&ssop=12&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"],"op=1011&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 210) {
		echo "<strong>".$Indicadores." : </strong><br><br>";
		resumEconomicContractes(0);
	}

	#Informes
	if ($soption == 290) {
		informesContratos();
	}

	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1011&sop=510","op=1011&sop=520","op=1011&sop=530","op=1011&sop=540"),array($Tipo." ".$Contratos,$Cobertura." ".$SLA,$Plantillas." ".$Contrato,$Origen." ".$Servicios));
		}
		if ($admin == false) {
			echo $UseNoAutorizado;
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "nombre,descripcion";
			$datosInsert = array($_POST["nombre"],$_POST["descripcion"]);
			insertFunction ("sim_contratos_tipos",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("nombre","descripcion");
			$datosUpdate = array($_POST["nombre"],$_POST["descripcion"]);
			updateFunction ("sim_contratos_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$sqlc = "select count(*) as total from sim_contratos where visible=1 and id_contrato_tipo=".$_GET["id"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			if ($rowc["total"] > 0){
				mensageError($ContratoTipoErrorEliminar);
			} else {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sim_contratos_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
			}
		}

		echo "<h4>".$Tipos." ".$Contratos."</h4>";
		echo boton(array("op=1011&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1011&sop=510&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_contratos_tipos where visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 511) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=510&ssop=3&id=".$_GET["id"],"op=1011&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) and ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "nombre,descripcion";
			$datosInsert = array($_POST["nombre"],$_POST["descripcion"]);
			insertFunction ("sim_contratos_sla_cobertura",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("nombre","descripcion");
			$datosUpdate = array($_POST["nombre"],$_POST["descripcion"]);
			updateFunction ("sim_contratos_sla_cobertura",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sim_contratos_sla_cobertura",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Cobertura." ".$SLA."</h4>";
		echo boton(array("op=1011&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1011&sop=520&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_contratos_sla_cobertura where visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=521&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 521) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=520&ssop=3&id=".$_GET["id"],"op=1011&sop=520"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 530) and ($admin == true)) {
		if ($ssoption == 1) {
			$sqlcc = "select id from sim_contratos where visible=1 and id_plantilla=0 and id_contrato_tipo=".$_POST["id_contrato_tipo"]." and num_contrato=".$_POST["num_contrato"]." and descripcion='".$_POST["descripcion"]."'";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if (!$rowcc){
				$camposInsert = "num_contrato,id_contrato_tipo,descripcion";
				$datosInsert = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["descripcion"]);
				insertFunction ("sim_contratos",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$camposUpdate = array("num_contrato","id_contrato_tipo","descripcion");
			$datosUpdate = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["descripcion"]);
			updateFunction ("sim_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sim_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate = array("activo");
			$datosUpdate = array("0");
			updateFunction ("sim_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			$camposUpdate = array("activo");
			$datosUpdate = array("1");
			updateFunction ("sim_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 7) {
			$sqln = "select num_contrato from sim_contratos where visible=1 and id_plantilla=0 order by num_contrato desc";
			$resultn = mysqli_query($dbhandle,convertSQL($sqln));
			$rown = mysqli_fetch_array($resultn);
			$numeroc = ($rown["num_contrato"]+ 1);
			$sqlcc = "select * from sim_contratos where visible=1 and id=".$_GET["id"]."";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if ($rowcc){
				$camposInsert = "num_contrato,id_contrato_tipo,descripcion,id_contrato";
				$datosInsert = array($numeroc,$rowcc["id_contrato_tipo"],$rowcc["descripcion"],$_GET["id"]);
				insertFunction ("sim_contratos",$camposInsert,$datosInsert);

				$camposUpdate = array("renovado");
				$datosUpdate = array("1");
				updateFunction ("sim_contratos",$_GET["id"],$camposUpdate,$datosUpdate);

				$sqlc = "select id from sim_contratos where num_contrato='".$numeroc."'";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				
				$sqlcs = "select * from sim_contratos_servicio where visible=1 and id_contrato=".$rowc["id"];
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)) {
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,tiempo_respuesta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email,funcion";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["tiempo_respuesta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"],$_POST["funcion"]);
					insertFunction ("sim_contratos_servicio",$camposInsert,$datosInsert);
				}
			}
		}

		echo "<h4>".$Plantillas." ".$Contrato."</h4>";
		echo boton(array("op=1011&sop=500"),array("&laquo; ".$Volver));
		echo "<table><tr>";
			echo "<td>";
				if ($_GET["act"] == 1) { echo boton(array("op=1011&sop=530&act=0"),array($Activo));}
				if ($_GET["act"] == 0) { echo boton(array("op=1011&sop=530&act=1"),array($Inactivo));}
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Numero." ".$Contrato."</th>";
				echo "<th>".$Contrato." ".$Tipo."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1011&sop=530&ssop=1&act=".$_GET["act"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input style=\"width:100px\" type=\"Text\" name=\"num_contrato\"></td>";
				echo "<td><select style=\"width:500px\" name=\"id_contrato_tipo\">";
					$sql = "select * from sim_contratos_tipos where visible=1 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]." - ".$row["descripcion"]."</option>";
					}
				echo "</select></td>";
				echo "<td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\"\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlcc = "select id,num_contrato,id_contrato_tipo,descripcion,activo,renovado from sim_contratos where visible=1 and id_plantilla=0";
			if ($_GET["act"] == 0){ $sqlcc = $sqlcc." and activo=1";}
			if ($_GET["act"] == 1){ $sqlcc = $sqlcc." and activo=0";}
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			while ($rowcc = mysqli_fetch_array($resultcc)){
				echo "<tr>";
				echo "<form action=\"index.php?op=1011&sop=530&ssop=2&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=531&id=".$rowcc["id"]."&act=".$_GET["act"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input style=\"width:100px\" type=\"Text\" name=\"num_contrato\" value=\"".$rowcc["num_contrato"]."\"></td>";
					echo "<td><select style=\"width:500px\" name=\"id_contrato_tipo\">";
						$sql = "select * from sim_contratos_tipos where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($row["id"] == $rowcc["id_contrato_tipo"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." - ".$row["descripcion"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." - ".$row["descripcion"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\" value=\"".$rowcc["descripcion"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				if ($rowcc["activo"] == 1) {
					echo "<form action=\"index.php?op=1011&sop=530&ssop=5&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td><input type=\"Submit\" value=\"".$Desactivar."\"></td>";
				} else {
					echo "<form action=\"index.php?op=1011&sop=530&ssop=6&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td><input type=\"Submit\" value=\"".$Activar."\"></td>";
				}
				echo "</form>";
				if ($rowcc["renovado"] == 0) {
					echo "<form action=\"index.php?op=1011&sop=530&ssop=7&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td><input type=\"Submit\" value=\"renovar".$Renovar."\"></td>";
					echo "</form>";
				} else {
					echo "<td></td>";
				}
					echo "<td>";
						echo boton(array("op=1011&sop=535&id=".$rowcc["id"]),array($Servicios));
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 531) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=530&ssop=3&id=".$_GET["id"],"op=1011&sop=530"),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 535) and ($admin == true)) {
		$sqlcc = "select num_contrato,descripcion from sim_contratos where id=".$_GET["id"]."";
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		echo "<h4>".$Servicios." ".$Contrato." : ".$rowcc["num_contrato"]."-".$rowcc["descripcion"]."</h4>";
		echo boton(array("op=1011&sop=530"),array("&laquo; ".$Volver));
		mostrarServicio($_GET["id"],536);
	}

	if (($soption == 536) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=535&ssop=3&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"],"op=1011&sop=535&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 540) and ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "codigo_origen,descripcion_origen";
			$datosInsert = array($_POST["codigo_origen"],$_POST["descripcion_origen"]);
			insertFunction ("sim_contratos_servicio_origen",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("codigo_origen","descripcion_origen");
			$datosUpdate = array($_POST["codigo_origen"],$_POST["descripcion_origen"]);
			updateFunction ("sim_contratos_servicio_origen",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sim_contratos_servicio_origen",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Cobertura." ".$SLA."</h4>";
		echo boton(array("op=1011&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Codigo."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1011&sop=540&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"codigo_origen\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion_origen\"></td>";
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_contratos_servicio_origen where visible=1 order by codigo_origen";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=541&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=540&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["codigo_origen"]."\" style=\"width:150px\" name=\"codigo_origen\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion_origen"]."\" style=\"width:350px\" name=\"descripcion_origen\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 541) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=540&ssop=3&id=".$_GET["id"],"op=1011&sop=540"),array($Si,$No));
		echo "</center>";
	}

	echo "</td></tr></table><br>";
}
?>

