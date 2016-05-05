<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";  }
if (($option == 1011) AND ($autorizado == true)) {

	$sqldiv = "select * from sgm_divisas where visible=1 and predefinido=1";
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
			$sqlcc = "select id from sgm_contratos where visible=1 and id_contrato_tipo=".$_POST["id_contrato_tipo"]." and id_cliente=".$_POST["id_cliente"]." and id_cliente_final=".$_POST["id_cliente_final"]." and num_contrato=".$_POST["num_contrato"]." and fecha_ini='".$_POST["fecha_ini"]."' and fecha_fin='".$_POST["fecha_fin"]."' and descripcion='".$_POST["descripcion"]."'";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if (!$rowcc){
				$camposInsert = "id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico";
				$datosInsert = array($_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["num_contrato"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"]);
				insertFunction ("sgm_contratos",$camposInsert,$datosInsert);

				$sqlc = "select id from sgm_contratos where num_contrato='".$_POST["num_contrato"]."' and visible=1";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 and id<0";
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)) {
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"]);
					insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
				}
			}
		}
		if ($ssoption == 3) {
			$borrar = 0;
			$sql = "select id from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$sqli = "select count(*) as total from sgm_incidencias where visible=1 and id_servicio=".$row["id"];
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				$rowi = mysqli_fetch_array($resulti);
				if ($rowi["total"] > 0){$borrar = 1;}
			}
			if ($borrar == 1){
				mensageError($ContratoErrorEliminar);
			} else {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);

				$sqlf = "select id from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"];
				$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
				while ($rowf = mysqli_fetch_array($resultf)){
					$camposUpdate = array("visible");
					$datosUpdate = array("0");
					updateFunction ("sgm_cabezera",$rowf["id"],$camposUpdate,$datosUpdate);
					$sql = "select id from sgm_cuerpo where idfactura=".$rowf["id"]."";
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
						$sql = "select id,nombre from sgm_contratos_tipos where visible=1 order by nombre";
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
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
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
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
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
#				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sgm_contratos where visible=1 and id_plantilla<>0 ";
				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sgm_contratos where visible=1 ";
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
						$sql = "select id,nombre from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sql = "select id,nombre from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
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
		if ($ssoption == 1) {
			$camposUpdate = array("num_contrato","id_contrato_tipo","id_cliente","id_cliente_final","fecha_ini","fecha_fin","descripcion","id_responsable","id_tecnico");
			$datosUpdate = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"]);
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate = array("activo");
			$datosUpdate = array("0");
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			$camposUpdate = array("activo");
			$datosUpdate = array("1");
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 7) {
			$sqln = "select num_contrato from sgm_contratos where visible=1 order by num_contrato desc";
			$resultn = mysqli_query($dbhandle,convertSQL($sqln));
			$rown = mysqli_fetch_array($resultn);
			$numeroc = ($rown["num_contrato"]+ 1);
			$sqlcc = "select * from sgm_contratos where visible=1 and id=".$_GET["id"]."";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			$ini = date("U",strtotime($rowcc["fecha_fin"].""));
			$inici = $ini+86400;
			$fecha_inici = date("Y-m-d", $inici);
			$fin = $inici+31536000;
			$fecha_fin = date("Y-m-d", $fin);
			if ($rowcc){
				$camposInsert = "id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico,id_contrato";
				$datosInsert = array($rowcc["id_contrato_tipo"],$rowcc["id_cliente"],$rowcc["id_cliente_final"],$numeroc,$fecha_inici,$fecha_fin,$rowcc["descripcion"],$rowcc["id_responsable"],$rowcc["id_tecnico"],$_GET["id"]);
				insertFunction ("sgm_contratos",$camposInsert,$datosInsert);
				$camposUpdate = array("renovado");
				$datosUpdate = array("1");
				updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);

				$sqlc = "select id from sgm_contratos where num_contrato='".$numeroc."'";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				
				$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"];
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)) {
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email,funcion";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"],$_POST["funcion"]);
					insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
				}

				$sqlca = "select id,fecha,fecha_prevision,id_cliente from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"];
				$resultca = mysqli_query($dbhandle,convertSQL($sqlca));
				while ($rowca = mysqli_fetch_array($resultca)) {
					$datosInsert = array('fecha' => $rowca["fecha"], 'fecha_prevision' => $rowca["fecha_prevision"], 'id_cliente' => $rowca["id_cliente"], 'id_contrato' => $rowc["id"]);
					insertCabezera($datosInsert);
					$sqlcab = "select id from sgm_cabezera where visible=1 and id_contrato=".$rowc["id"]." order by id desc";
					$resultcab = mysqli_query($dbhandle,convertSQL($sqlcab));
					$rowcab = mysqli_fetch_array($resultcab);
					$sqlcu = "select * from sgm_cuerpo where idfactura=".$rowca["id"];
					$resultcu = mysqli_query($dbhandle,convertSQL($sqlcu));
					while ($rowcu = mysqli_fetch_array($resultcu)) {
#						insertCuerpo($rowcab["id"],1,0,$rowcu["nombre"],0,$rowcu["total"],1,$rowcu["fecha_prevision"],0,0,$rowcu["fecha_prevision_propia"]);
						$camposInsert = "idfactura,nombre,pvp,unidades,fecha_prevision,fecha_prevision_propia,total";
						$datosInsert = array($rowcab["id"],$rowcu["nombre"],$rowcu["pvp"],1,$rowcu["fecha_prevision"],$rowcu["fecha_prevision"],$rowcu["total"]);
						insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
						refactura($rowcab["id"]);
					}
				}

				$sqlco = "select id from sgm_contrasenyes where visible=1 and id_contrato=".$_GET["id"];
				$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
				while ($rowco = mysqli_fetch_array($resultco)) {
					$camposUpdate = array("id_contrato");
					$datosUpdate = array($rowc["id"]);
					updateFunction ("sgm_contrasenyes",$rowco["id"],$camposUpdate,$datosUpdate);
				}
			}
		}
		if ($ssoption == 10) {
			$datosInsert = array('fecha' => $_POST["fecha"], 'fecha_prevision' => $_POST["fecha_prevision"], 'id_cliente' => $_POST["id_cliente"], 'id_contrato' => $_POST["id_contrato"]);
			insertCabezera($datosInsert);
#			insertCabezera(0,7,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],$_POST["id_cliente"],$_POST["id_contrato"],0);
			$sql = "select id from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]." order by id desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposInsert = "idfactura,nombre,pvp,unidades,fecha_prevision,fecha_prevision_propia,total";
			$datosInsert = array($row["id"],$_POST["concepto"],$_POST["importe"],1,$_POST["fecha_prevision"],$_POST["fecha_prevision"],$_POST["importe"]);
			insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
			refactura($row["id"]);
#			insertCuerpo($row["id"],1,0,$_POST["concepto"],0,$_POST["importe"],1,$_POST["fecha_prevision"],0,0,$_POST["fecha_prevision"]);
		}
		if ($ssoption == 11) {
			$sql = "select fecha_prevision from sgm_cabezera where visible=1 and id=".$_GET["id_fact"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if ($row["fecha_prevision"] != $_POST["fecha_prevision"]){
				$camposInsert = "id_factura,id_usuario,fecha_ant,data";
				$datosInsert = array($_GET["id_fact"],$userid,$row["fecha_prevision"],$_POST["fecha_prevision"]);
				insertFunction ("sgm_factura_canvi_data_prevision",$camposInsert,$datosInsert);
			}
			$camposUpdate = array("fecha","fecha_prevision");
			$datosUpdate = array($_POST["fecha"],$_POST["fecha_prevision"]);
			updateFunction ("sgm_cabezera",$_GET["id_fact"],$camposUpdate,$datosUpdate);
			$data = date("Y-m-d");
			$hora = date("H:i:s");
			$camposInsert = "id_factura, id_usuario, data, hora";
			$datosInsert = array($_GET["id_fact"],$userid,$data,$hora);
			insertFunction ("sgm_factura_modificacio",$camposInsert,$datosInsert);
#			updateCabezera($_GET["id_fact"],0,0,0,0,0,0,$_POST["fecha"],$_POST["fecha_prevision"],0,0,$_POST["id_cliente"],$_POST["id_contrato"],0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

			$sql = "select id,fecha_prevision from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposUpdate = array("nombre","pvp","fecha_prevision","fecha_prevision_propia","total");
			$datosUpdate = array($_POST["concepto"],$_POST["importe"],$_POST["fecha_prevision"],$_POST["fecha_prevision"],$_POST["importe"]);
			updateFunction ("sgm_cuerpo",$row["id"],$camposUpdate,$datosUpdate);
			if ($row["fecha_prevision"] != $_POST["fecha_prevision"]){
				$fecha = date("Y-m-d");
				$camposInsert = "id_factura,id_usuario,fecha_ant,data,id_cuerpo";
				$datosInsert = array($_GET["id_fact"],$userid,$row["fecha_prevision"],$fecha,$row["id"]);
				insertFunction ("sgm_factura_canvi_data_prevision_cuerpo",$camposInsert,$datosInsert);
			}
#			updateCuerpo($row["id"],$_GET["id_fact"],$row["linea"],$row["codigo"],$_POST["concepto"],$row["pvd"],$_POST["importe"],1,$_POST["fecha_prevision"],$row["id_article"],$row["stock"],$_POST["fecha_prevision"],$row["descuento"],$row["descuento_absoluto"]);
			refactura($_GET["id_fact"]);
		}
		if ($ssoption == 12) {
			deleteFunction("sgm_cabezera",$_GET["id_fact"]);
			$sql = "select id from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			deleteCuerpo($row["id"],$_GET["id_fact"]);
		}

		if ($_GET["id"] != "") { echo "<h4>".$Editar." ".$Contrato." : </h4>";} else { echo "<h4>".$Anadir." ".$Contrato." : </h4>";}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			if ($_GET["id"] != "") {
				echo "<form action=\"index.php?op=1011&sop=100&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				$sqlc = "select * from sgm_contratos where visible=1 and id=".$_GET["id"];
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				$numeroc = $rowc["num_contrato"];
			} else {
				echo "<form action=\"index.php?op=1011&sop=0&ssop=1\" method=\"post\">";
				$numeroc = 0;
				$sqln = "select num_contrato from sgm_contratos where visible=1 order by num_contrato desc";
				$resultn = mysqli_query($dbhandle,convertSQL($sqln));
				$rown = mysqli_fetch_array($resultn);
				$numeroc = ($rown["num_contrato"]+ 1);
			}
			echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Contrato.": </td><td><input style=\"width:100px\" type=\"Text\" name=\"num_contrato\" value=\"".$numeroc."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Contrato." ".$Tipo.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_contrato_tipo\">";
					$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						if ($row["id"] == $rowc["id_contrato_tipo"]){
							echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." - ".$row["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$row["id"]."\">".$row["nombre"]." - ".$row["descripcion"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_cliente\">";
					$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					while ($rowa = mysqli_fetch_array($resulta)) {
						if ($rowa["id"] == $rowc["id_cliente"]){
							echo "<option value=\"".$rowa["id"]."\" selected>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente." ".$Final.": </td>";
				echo "<td><select style=\"width:500px\" name=\"id_cliente_final\">";
					$sqlb = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
					$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
					while ($rowb = mysqli_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_cliente_final"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["nombre"]." ".$rowb["cognom1"]." ".$rowb["cognom2"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Descripcion.": </td><td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\" value=\"".$rowc["descripcion"]."\"></td></tr>";
			if ($_GET["id"] != "") {
				$date1 = $rowc["fecha_ini"];
				$date2 = $rowc["fecha_fin"];
			} else {
				$date = getdate();
				$date1 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
				$date2 = date("Y-m-d", mktime(0,0,0,$date["mon"] ,$date["mday"], $date["year"]));
			}
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Inicio.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_ini\" value=\"".$date1."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Fecha." ".$Fin.": </td><td><input style=\"width:100px\" type=\"text\" name=\"fecha_fin\" value=\"".$date2."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Responsable_cliente.": </td>";
				echo "<td><select name=\"id_responsable\" style=\"width:150px\">";
				$sqlua = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1";
				$resultua = mysqli_query($dbhandle,convertSQL($sqlua));
				while ($rowua = mysqli_fetch_array($resultua)) {
						if ($rowua["id"] == $rowc["id_responsable"]){
							echo "<option value=\"".$rowua["id"]."\" selected>".$rowua["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowua["id"]."\">".$rowua["usuario"]."</option>";
						}
				}
				echo "</select></td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Responsable_tecnico.": </td>";
				echo "<td><select name=\"id_tecnico\" style=\"width:150px\">";
				$sqluu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1";
				$resultuu = mysqli_query($dbhandle,convertSQL($sqluu));
				while ($rowuu = mysqli_fetch_array($resultuu)) {
						if ($rowuu["id"] == $rowc["id_tecnico"]){
							echo "<option value=\"".$rowuu["id"]."\" selected>".$rowuu["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowuu["id"]."\">".$rowuu["usuario"]."</option>";
						}
				}
				echo "</select></td>";
			echo "</tr>";
			if ($_GET["edit"] == "") {
				if ($_GET["id"] != "") {
					echo "<td></td><td><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
				} else {
					echo "<td></td><td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				}
			}
			echo "</form>";
			if ($_GET["id"] != "") {
				if ($rowc["activo"] == 1) {
					echo "<form action=\"index.php?op=1011&sop=100&ssop=5&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td><td><input type=\"Submit\" value=\"".$Desactivar."\" style=\"width:100px\"></td>";
				} else {
					echo "<form action=\"index.php?op=1011&sop=100&ssop=6&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td><td><input type=\"Submit\" value=\"".$Activar."\" style=\"width:100px\"></td>";
				}
				echo "</form>";
			}
			if ($_GET["id"] != "") {
				if ($rowc["renovado"] == 0) {
					echo "<form action=\"index.php?op=1011&sop=100&ssop=7&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td><td><input type=\"Submit\" value=\"renovar".$Renovar."\" style=\"width:100px\"></td>";
					echo "</form>";
				} else {
					echo "<td></td><td></td>";
				}
			}
		echo "</table>";
		echo "<br><br>";

		if ($_GET["id"] != "") {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<caption>".$Facturas."</caption>";
				echo "<tr style=\"background-color:silver\">";
					echo "<th></th>";
					echo "<th>".$Fecha."</th>";
					echo "<th>".$Fecha." ".$Prevision."</th>";
					echo "<th>".$Concepto."</th>";
					echo "<th>".$Importe."</th>";
					echo "<th></th>";
				echo "</tr><tr>";
				echo "<form action=\"index.php?op=1011&sop=100&ssop=10&id=".$_GET["id"]."\" method=\"post\">";
					echo "<td></td>";
					echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowc["id_cliente"]."\">";
					echo "<input type=\"hidden\" name=\"id_contrato\" value=\"".$_GET["id"]."\">";
					$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$date."\"></td>";
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$date."\"></td>";
					echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\"></td>";
					echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"1\" step=\"any\" name=\"importe\" value=\"0\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "</form>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
				$sql = "select id,fecha,fecha_prevision from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]."";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					$sqlcu = "select nombre,pvp from sgm_cuerpo where idfactura=".$row["id"]."";
					$resultcu = mysqli_query($dbhandle,convertSQL($sqlcu));
					$rowcu = mysqli_fetch_array($resultcu);
					echo "<tr>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=102&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						echo "<form action=\"index.php?op=1011&sop=100&ssop=11&id=".$_GET["id"]."&id_fact=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowc["id_cliente"]."\">";
						echo "<input type=\"hidden\" name=\"id_contrato\" value=\"".$_GET["id"]."\">";
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$row["fecha"]."\"></td>";
						echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\"></td>";
						echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\" value=\"".$rowcu["nombre"]."\"></td>";
						echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"1\" step=\"any\" name=\"importe\" value=\"".$rowcu["pvp"]."\"></td>";
						echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
						echo "</form>";
					echo "</tr>";
				}
			echo "</table>";
			echo "<br><br><br>";
			mostrarServicio($_GET["id"],101);
		}
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
			insertFunction ("sgm_contratos_tipos",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("nombre","descripcion");
			$datosUpdate = array($_POST["nombre"],$_POST["descripcion"]);
			updateFunction ("sgm_contratos_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$sqlc = "select count(*) as total from sgm_contratos where visible=1 and id_contrato_tipo=".$_GET["id"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			if ($rowc["total"] > 0){
				mensageError($ContratoTipoErrorEliminar);
			} else {
				$camposUpdate = array("visible");
				$datosUpdate = array("0");
				updateFunction ("sgm_contratos_tipos",$_GET["id"],$camposUpdate,$datosUpdate);
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
			$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
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
			insertFunction ("sgm_contratos_sla_cobertura",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("nombre","descripcion");
			$datosUpdate = array($_POST["nombre"],$_POST["descripcion"]);
			updateFunction ("sgm_contratos_sla_cobertura",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_contratos_sla_cobertura",$_GET["id"],$camposUpdate,$datosUpdate);
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
			$sql = "select * from sgm_contratos_sla_cobertura where visible=1 order by nombre";
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
			$sqlcc = "select id from sgm_contratos where visible=1 and id_plantilla=0 and id_contrato_tipo=".$_POST["id_contrato_tipo"]." and num_contrato=".$_POST["num_contrato"]." and descripcion='".$_POST["descripcion"]."'";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if (!$rowcc){
				$camposInsert = "num_contrato,id_contrato_tipo,descripcion";
				$datosInsert = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["descripcion"]);
				insertFunction ("sgm_contratos",$camposInsert,$datosInsert);
			}
		}
		if ($ssoption == 2) {
			$camposUpdate = array("num_contrato","id_contrato_tipo","descripcion");
			$datosUpdate = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["descripcion"]);
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate = array("activo");
			$datosUpdate = array("0");
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6) {
			$camposUpdate = array("activo");
			$datosUpdate = array("1");
			updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 7) {
			$sqln = "select num_contrato from sgm_contratos where visible=1 and id_plantilla=0 order by num_contrato desc";
			$resultn = mysqli_query($dbhandle,convertSQL($sqln));
			$rown = mysqli_fetch_array($resultn);
			$numeroc = ($rown["num_contrato"]+ 1);
			$sqlcc = "select * from sgm_contratos where visible=1 and id=".$_GET["id"]."";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);
			if ($rowcc){
				$camposInsert = "num_contrato,id_contrato_tipo,descripcion,id_contrato";
				$datosInsert = array($numeroc,$rowcc["id_contrato_tipo"],$rowcc["descripcion"],$_GET["id"]);
				insertFunction ("sgm_contratos",$camposInsert,$datosInsert);

				$camposUpdate = array("renovado");
				$datosUpdate = array("1");
				updateFunction ("sgm_contratos",$_GET["id"],$camposUpdate,$datosUpdate);

				$sqlc = "select id from sgm_contratos where num_contrato='".$numeroc."'";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				
				$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowc["id"];
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)) {
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email,funcion";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"],$_POST["funcion"]);
					insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
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
					$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
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
			$sqlcc = "select id,num_contrato,id_contrato_tipo,descripcion,activo,renovado from sgm_contratos where visible=1 and id_plantilla=0";
			if ($_GET["act"] == 0){ $sqlcc = $sqlcc." and activo=1";}
			if ($_GET["act"] == 1){ $sqlcc = $sqlcc." and activo=0";}
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			while ($rowcc = mysqli_fetch_array($resultcc)){
				echo "<tr>";
				echo "<form action=\"index.php?op=1011&sop=530&ssop=2&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=531&id=".$rowcc["id"]."&act=".$_GET["act"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input style=\"width:100px\" type=\"Text\" name=\"num_contrato\" value=\"".$rowcc["num_contrato"]."\"></td>";
					echo "<td><select style=\"width:500px\" name=\"id_contrato_tipo\">";
						$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
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
		$sqlcc = "select num_contrato,descripcion from sgm_contratos where id=".$_GET["id"]."";
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
			insertFunction ("sgm_contratos_servicio_origen",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("codigo_origen","descripcion_origen");
			$datosUpdate = array($_POST["codigo_origen"],$_POST["descripcion_origen"]);
			updateFunction ("sgm_contratos_servicio_origen",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_contratos_servicio_origen",$_GET["id"],$camposUpdate,$datosUpdate);
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
			$sql = "select * from sgm_contratos_servicio_origen where visible=1 order by codigo_origen";
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

