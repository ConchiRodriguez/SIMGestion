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
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,funcion";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$_POST["funcion"]);
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
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
				echo "</tr>";
				echo "</form>";
			echo "</table>";
			echo "<br><br>";
		}
		if (($soption != 200) or ($_POST["id_contrato_tipo2"] > 0) or ($_POST["id_cliente2"] > 0) or ($_POST["id_cliente_final2"] > 0)){
			echo "<table cellpadding=\"3\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<th>".$Eliminar."</th>";
					echo "<th>".$Cliente."</th>";
					echo "<th>".$Cliente." ".$Final."</th>";
					echo "<th>".$Descripcion."</th>";
					echo "<th></th>";
					echo "<th></th>";
					echo "<th></th>";
				echo "</tr>";
#				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sgm_contratos where visible=1 and id_plantilla<>0 ";
				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion,activo,renovado from sgm_contratos where visible=1 ";
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

						echo "<form action=\"index.php?op=1011&sop=100&id=".$rowcc["id"]."\" method=\"post\">";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
						echo "</form>";
						if ($rowcc["activo"] == 1) {
							echo "<form action=\"index.php?op=1011&sop=0&ssop=5&id=".$rowcc["id"]."\" method=\"post\">";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Desactivar."\"></td>";
						} else {
							echo "<form action=\"index.php?op=1011&sop=0&ssop=6&id=".$rowcc["id"]."\" method=\"post\">";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Activar."\"></td>";
						}
						echo "</form>";
						if ($rowcc["renovado"] == 0) {
							echo "<form action=\"index.php?op=1011&sop=0&ssop=7&id=".$rowcc["id"]."\" method=\"post\">";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"renovar".$Renovar."\"></td>";
							echo "</form>";
						} else {
							echo "<td></td>";
						}
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

#Mascara superior del contrato
	if (($soption >= 100) and ($soption < 200) and (($_GET["id"] != 0) or ($ssoption != 0))) {
		if (($soption == 100) and ($ssoption == 1)) {
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
				$id_contrato = $rowc["id"];
				$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 and id<0";
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				while ($rowcs = mysqli_fetch_array($resultcs)) {
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email";
					$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"]);
					insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
				}
			}
		}
		if ($id_contrato == '') {$id_contrato = $_GET["id"];}
		$sqlcontrato = "select * from sgm_contratos where id=".$id_contrato;
		$resultcontrato = mysqli_query($dbhandle,convertSQL($sqlcontrato));
		$rowcontrato = mysqli_fetch_array($resultcontrato);
#		echo $sql;
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=100&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Datos." ".$Contrato."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=110&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Servicios."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=120&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Facturas."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=130&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Archivos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=140&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Notificaciones."</a></td>";
							echo "<td></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:500px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1011&sop=100&id=".$rowcontrato["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$rowcontrato["num_contrato"]." ".$rowcontrato["descripcion"]."</strong></a>";
					$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcontrato["id_cliente"];
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					$rowa = mysqli_fetch_array($resulta);
					$sqla2 = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcontrato["id_cliente_final"];
					$resulta2 = mysqli_query($dbhandle,convertSQL($sqla2));
					$rowa2 = mysqli_fetch_array($resulta2);
					echo "<br>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"];
					echo "<br>".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"];
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1011&sop=195&id=".$row["id"]."\" style=\"color:white;\">".$Opciones."</a></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 100) {
		echo "<h4>".$Datos." ".$Contrato." : </h4>";
		mostrarContrato ($id_contrato,0);
	}

	if ($soption == 110) {
		echo "<h4>".$Servicios." : </h4>";
		mostrarServicio ($_GET["id"],0,111);
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=100&ssop=4&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"],"op=1011&sop=100&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 120) {
		if ($ssoption == 1) {
			$datosInsert = array('fecha' => $_POST["fecha"], 'fecha_prevision' => $_POST["fecha_prevision"], 'id_cliente' => $_POST["id_cliente"], 'id_contrato' => $_GET["id"]);
			insertCabezera($datosInsert);

			$sql = "select id from sgm_cabezera where visible=1 and id_contrato=".$_POST["id_contrato"]." order by id desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposInsert = "idfactura,nombre,pvp,unidades,fecha_prevision,fecha_prevision_propia,total";
			$datosInsert = array($row["id"],$_POST["concepto"],$_POST["importe"],1,$_POST["fecha_prevision"],$_POST["fecha_prevision"],$_POST["importe"]);
			insertFunction ("sgm_cuerpo",$camposInsert,$datosInsert);
			refactura($row["id"]);

		}
		if ($ssoption == 2) {
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
		if ($ssoption == 3) {
			deleteFunction("sgm_cabezera",$_GET["id_fact"]);
			$sql = "select id from sgm_cuerpo where idfactura=".$_GET["id_fact"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			deleteCuerpo($row["id"],$_GET["id_fact"]);
		}

		echo "<h4>".$Facturas." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Fecha." ".$Prevision."</th>";
				echo "<th>".$Concepto."</th>";
				echo "<th>".$Importe."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
			echo "<form action=\"index.php?op=1011&sop=120&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$rowcontrato["id_cliente"]."\">";
				$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
				echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$date."\"></td>";
				echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$date."\"></td>";
				echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\"></td>";
				echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"1\" step=\"any\" name=\"importe\" value=\"0\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=121&id=".$_GET["id"]."&id_fact=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=120&ssop=2&id=".$_GET["id"]."&id_fact=".$row["id"]."\" method=\"post\">";
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha\" value=\"".$row["fecha"]."\"></td>";
					echo "<td><input style=\"text-align:center;width:100px\" type=\"Text\" name=\"fecha_prevision\" value=\"".$row["fecha_prevision"]."\"></td>";
					echo "<td><input style=\"text-align:left;width:400px\" type=\"Text\" name=\"concepto\" value=\"".$rowcu["nombre"]."\"></td>";
					echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"1\" step=\"any\" name=\"importe\" value=\"".$rowcu["pvp"]."\"></td>";
					echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$rowcontrato["id_cliente"]."\">";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 121) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=120&ssop=3&id=".$_GET["id"]."&id_fact=".$_GET["id_fact"],"op=1011&sop=120&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 130) {
		if ($ssoption == 1) {
			if (version_compare(phpversion(), "4.0.0", ">")) {
				$archivo_name = $_FILES['archivo']['name'];
				$archivo_size = $_FILES['archivo']['size'];
				$archivo_type =  $_FILES['archivo']['type'];
				$archivo = $_FILES['archivo']['tmp_name'];
				$tipo = $_POST["id_tipo"];
			}
			if (version_compare(phpversion(), "4.0.1", "<")) {
				$archivo_name = $HTTP_POST_FILES['archivo']['name'];
				$archivo_size = $HTTP_POST_FILES['archivo']['size'];
				$archivo_type =  $HTTP_POST_FILES['archivo']['type'];
				$archivo = $HTTP_POST_FILES['archivo']['tmp_name'];
				$tipo = $HTTP_POST_VARS["id_tipo"];
			}
			echo subirArchivo($tipo,$archivo,$archivo_name,$archivo_size,$archivo_type,3,$_GET["id_con"]);
		}
		if ($ssoption == 2) {
			$sqlf = "select name from sgm_files where id=".$_GET["id_archivo"];
			$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
			$rowf = mysqli_fetch_array($resultf);
			deleteFunction ("sgm_files",$_GET["id_archivo"]);
			$filepath = "archivos/contratos/".$rowf["name"];
			unlink($filepath);
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"width:70%;vertical-align:top;\">";
					echo "<h4>".$Archivos." :</h4>";
					echo "<table>";
					$sql = "select * from sgm_files_tipos order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						$sqlele = "select * from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=3 and id_elemento=".$_GET["id_con"];
						$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
						while ($rowele = mysqli_fetch_array($resultele)) {
							echo "<tr>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=131&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$rowele["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
								echo "<td style=\"text-align:right;\">".$row["nombre"]."</td>";
								echo "<td><a href=\"".$urloriginal."/archivos/contratos/".$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
								echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
							echo "</tr>";
						}
					}
					echo "</table>";
				echo "</td>";
				echo "<td style=\"width:30%;vertical-align:top;\">";
					echo "<h4>".$Formulario_Subir_Archivo." :</h4>";
					echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1011&sop=130&ssop=1&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."\" method=\"post\">";
					echo "<table>";
						echo "<tr>";
							echo "<td><select name=\"id_tipo\" style=\"width:300px\">";
								$sql = "select * from sgm_files_tipos order by nombre";
								$result = mysqli_query($dbhandle,convertSQL($sql));
								while ($row = mysqli_fetch_array($result)) {
									echo "<option value=\"".$row["id"]."\">".$row["nombre"]." (hasta ".$row["limite_kb"]." Kb)</option>";
								}
							echo "</select></td>";
						echo "</tr>";
						echo "<tr><td><input type=\"file\" name=\"archivo\" size=\"30px\"></td></tr>";
						echo "<tr><td><input type=\"submit\" value=\"Enviar a la carpeta /archivos/contratos/\" style=\"width:300px\"></td></tr>";
					echo "</table>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=130&ssop=2&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$_GET["id_archivo"],"op=1011&sop=130&id=".$_GET["id"]."&id_con=".$_GET["id_con"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 140) {
		if ($ssoption == 1) {
			$camposInsert = "id_contrato,id_servicio,id_usuario";
			$datosInsert = array($_GET["id"],$_POST["id_servicio"],$_POST["id_usuario"]);
			insertFunction ("sgm_contratos_servicio_notificacion",$camposInsert,$datosInsert);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_contratos_servicio_notificacion",$_GET["id"]);
		}

		echo "<h4>".$Notificaciones." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Servicio."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
			echo "<form action=\"index.php?op=1011&sop=140&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select name=\"id_servicio\" style=\"width:300px\">";
					$sql = "select id,servicio from sgm_contratos_servicio where id_contrato=".$_GET["id"]." order by servicio";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["servicio"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select name=\"id_usuario\" style=\"width:300px\">";
					$sql = "select id,usuario from sgm_users where validado=1 and activo=1 and id in (select id_user from sgm_users_clients where id_client=".$rowcontrato["id_cliente"].") order by usuario";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["usuario"]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_servicio_notificacion where id_contrato=".$_GET["id"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqls = "select servicio from sgm_contratos_servicio where id=".$row["id_servicio"]."";
				$results = mysqli_query($dbhandle,convertSQL($sqls));
				$rows = mysqli_fetch_array($results);
				$sqlu = "select usuario from sgm_users where id=".$row["id_usuario"]."";
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=141&id=".$_GET["id"]."&id_not=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=145&id=".$_GET["id"]."&id_not=".$row["id"]."\" method=\"post\">";
					echo "<td>".$rows["servicio"]."</td>";
					echo "<td>".$rowu["usuario"]."</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 141) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=140&ssop=3&id=".$_GET["id"]."&id_not=".$_GET["id_not"],"op=1011&sop=140&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 145) {
		$todos_contactos = -1;
		if ($ssoption == 1) {
			$sql = "select id from sgm_users where validado=1 and activo=1 and id in (select id_user from sgm_users_clients where id_client=".$rowcontrato["id_cliente"].")";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$tipo_edit = array("anadir","modificar","cerrar","todos");
				for ($i=0;$i<=count($tipo_edit);$i++){
					$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$row["id"]." and tipo_edicion_incidencia=".($i+1);
					$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
					$rowcs = mysqli_fetch_array($resultcs);
					if (($rowcs["total"] == 0) and($_POST[$tipo_edit[$i]."_".$row["id"]])){
						$camposInsert = "id_servicio_notificacion,id_usuario_origen,tipo_edicion_incidencia";
						$datosInsert = array($_GET["id_not"],$row["id"],($i+1));
						insertFunction ("sgm_contratos_servicio_notificacion_condicion",$camposInsert,$datosInsert);
					}
					if (($rowcs["total"] == 1) and(!$_POST[$tipo_edit[$i]."_".$row["id"]])){
						$sql = "delete from sgm_contratos_servicio_notificacion_condicion WHERE id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$row["id"]." and tipo_edicion_incidencia=".($i+1);
						mysqli_query($dbhandle,convertSQL($sql));
						echo $sql;
					}
				}
			}
			$tipo_edit = array("anadir","modificar","cerrar","todos");
			for ($i=0;$i<=count($tipo_edit);$i++){
				$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$todos_contactos." and tipo_edicion_incidencia=".($i+1);
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				$rowcs = mysqli_fetch_array($resultcs);
				if (($rowcs["total"] == 0) and($_POST[$tipo_edit[$i]."_".$todos_contactos])){
					$camposInsert = "id_servicio_notificacion,id_usuario_origen,tipo_edicion_incidencia";
					$datosInsert = array($_GET["id_not"],$todos_contactos,($i+1));
					insertFunction ("sgm_contratos_servicio_notificacion_condicion",$camposInsert,$datosInsert);
				}
				if (($rowcs["total"] == 1) and(!$_POST[$tipo_edit[$i]."_".$todos_contactos])){
					$sql = "delete from sgm_contratos_servicio_notificacion_condicion WHERE id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$todos_contactos." and tipo_edicion_incidencia=".($i+1);
					mysqli_query($dbhandle,convertSQL($sql));
					echo $sql;
				}
			}
		}

		$sql = "select * from sgm_contratos_servicio_notificacion where id=".$_GET["id_not"]."";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$sqls = "select servicio from sgm_contratos_servicio where id=".$row["id_servicio"]."";
		$results = mysqli_query($dbhandle,convertSQL($sqls));
		$rows = mysqli_fetch_array($results);
		$sqlu = "select id,usuario from sgm_users where id=".$row["id_usuario"]."";
		$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
		$rowu = mysqli_fetch_array($resultu);

		echo "<h4>".$Notificaciones." ".$Codiciones." :</h4>";
		echo "<table cellpadding=\"10\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Servicio." : ".$rows["servicio"]."</th>";
				echo "<th>".$Usuario." : ".$rowu["usuario"]."</th>";
				echo "<th></th>";
			echo "<tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\" style=\"min-width:200px;\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Usuarios." ".$Origen."</th>";
				echo "<th>".$Acciones."</th>";
			echo "</tr>";
		echo "<form action=\"index.php?op=1011&sop=145&ssop=1&id=".$_GET["id"]."&id_not=".$_GET["id_not"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\">".$Todos."</td>";
				echo "<td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<td><input type=\"Checkbox\" name=\"todos_".$todos_contactos."\" value=\"4\"";
							$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$todos_contactos." and tipo_edicion_incidencia=4";
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							$rowcs = mysqli_fetch_array($resultcs);
							if ($rowcs["total"] == 1){ echo "checked";}
							echo "></td>";
							echo "<td>".$Todos."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><input type=\"Checkbox\" name=\"anadir_".$todos_contactos."\" value=\"1\"";
							$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$todos_contactos." and tipo_edicion_incidencia=1";
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							$rowcs = mysqli_fetch_array($resultcs);
							if ($rowcs["total"] == 1){ echo "checked";}
							echo "></td>";
							echo "<td>".$Anadir."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><input type=\"Checkbox\" name=\"modificar_".$todos_contactos."\" value=\"2\"";
							$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$todos_contactos." and tipo_edicion_incidencia=2";
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							$rowcs = mysqli_fetch_array($resultcs);
							if ($rowcs["total"] == 1){ echo "checked";}
							echo "></td>";
							echo "<td>".$Modificar."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><input type=\"Checkbox\" name=\"cerrar_".$todos_contactos."\" value=\"3\"";
							$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$todos_contactos." and tipo_edicion_incidencia=3";
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							$rowcs = mysqli_fetch_array($resultcs);
							if ($rowcs["total"] == 1){ echo "checked";}
							echo "></td>";
							echo "<td>".$Cerrar."</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select id,usuario from sgm_users where validado=1 and activo=1 and id in (select id_user from sgm_users_clients where id_client=".$rowcontrato["id_cliente"].") order by usuario";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)) {
			if ($rowu["id"] != $row["id"]){
				echo "<tr>";
					echo "<td style=\"vertical-align:top;\">".$row["usuario"]."</td>";
					echo "<td style=\"vertical-align:top;\">";
						echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
							echo "<tr>";
								echo "<td><input type=\"Checkbox\" name=\"todos_".$row["id"]."\" value=\"4\"";
								$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$row["id"]." and tipo_edicion_incidencia=4";
								$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
								$rowcs = mysqli_fetch_array($resultcs);
								if ($rowcs["total"] == 1){ echo "checked";}
								echo "></td>";
								echo "<td>".$Todos."</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td><input type=\"Checkbox\" name=\"anadir_".$row["id"]."\" value=\"1\"";
								$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$row["id"]." and tipo_edicion_incidencia=1";
								$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
								$rowcs = mysqli_fetch_array($resultcs);
								if ($rowcs["total"] == 1){ echo "checked";}
								echo "></td>";
								echo "<td>".$Anadir."</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td><input type=\"Checkbox\" name=\"modificar_".$row["id"]."\" value=\"2\"";
								$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$row["id"]." and tipo_edicion_incidencia=2";
								$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
								$rowcs = mysqli_fetch_array($resultcs);
								if ($rowcs["total"] == 1){ echo "checked";}
								echo "></td>";
								echo "<td>".$Modificar."</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td><input type=\"Checkbox\" name=\"cerrar_".$row["id"]."\" value=\"3\"";
								$sqlcs = "select count(*) as total from sgm_contratos_servicio_notificacion_condicion where id_servicio_notificacion=".$_GET["id_not"]." and id_usuario_origen=".$row["id"]." and tipo_edicion_incidencia=3";
								$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
								$rowcs = mysqli_fetch_array($resultcs);
								if ($rowcs["total"] == 1){ echo "checked";}
								echo "></td>";
								echo "<td>".$Cerrar."</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
		}
			echo "<tr>";
				echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Guardar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
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

