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
					$sqlcu = "select nombre,pvp,fecha_prevision,total from sgm_cuerpo where idfactura=".$rowca["id"];
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
							if (($_POST["id_cliente2"] == $row["id"]) or ($_GET["id_cli"] == $row["id"])){
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
		if (($soption != 200) or ($_POST["id_contrato_tipo2"] > 0) or ($_POST["id_cliente2"] > 0) or ($_POST["id_cliente_final2"] > 0) or ($_GET["id_cli"] > 0)){
			echo "<table cellpadding=\"3\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<th>".$Eliminar."</th>";
					echo "<th>".$Cliente."</th>";
					echo "<th>".$Cliente." ".$Final."</th>";
					echo "<th>".$Descripcion."</th>";
					echo "<th>".$Fecha." ".$Inicio."</th>";
					echo "<th>".$Fecha." ".$Fin."</th>";
					echo "<th></th>";
					echo "<th></th>";
					echo "<th></th>";
				echo "</tr>";
#				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion from sgm_contratos where visible=1 and id_plantilla<>0 ";
				$sqlcc = "select id,id_cliente,id_cliente_final,descripcion,activo,renovado,fecha_ini,fecha_fin from sgm_contratos where visible=1 ";
				if ($_POST["id_contrato_tipo2"] > 0) {
					$sqlcc = $sqlcc." and id_contrato_tipo=".$_POST["id_contrato_tipo2"]."";
				}
				if (($_POST["id_cliente2"] > 0) or ($_GET["id_cli"] > 0)) {
					$sqlcc = $sqlcc." and id_cliente=".$_POST["id_cliente2"].$_GET["id_cli"]."";
				}
				if ($_POST["id_cliente_final2"] > 0) {
					$sqlcc = $sqlcc." and id_cliente_final=".$_POST["id_cliente_final2"]."";
				}
				if ($soption == 0){ $sqlcc = $sqlcc." and activo=1";}
				if ($soption == 1){ $sqlcc = $sqlcc." and activo=0";}
				$sqlcc = $sqlcc." order by fecha_ini desc, fecha_fin desc";
#				echo $sqlcc."<br>";
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				while ($rowcc = mysqli_fetch_array($resultcc)){
					if ((date('U',strtotime($rowcc["fecha_fin"])) < date('U')) and ($rowcc["activo"] == 1)) { $color = "red"; $color_letra = "white";}
					else { $color = "white"; $color_letra = "";}
					echo "<tr style=\"background-color:".$color."\">";
						echo "<td style=\"text-align:center;color:".$color_letra."\"><a href=\"index.php?op=1011&sop=10&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\" style=\"color:".$color_letra."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\" style=\"color:".$color_letra."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</a></td>";
						echo "<td><a href=\"index.php?op=1011&sop=100&id=".$rowcc["id"]."\" style=\"color:".$color_letra."\">".$rowcc["descripcion"]."</a></td>";
						echo "<td style=\"color:".$color_letra."\">".$rowcc["fecha_ini"]."</td>";
						echo "<td style=\"color:".$color_letra."\">".$rowcc["fecha_fin"]."</td>";

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
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Renovar."\"></td>";
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
				$camposInsert = "id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico,id_tarifa,pack_horas,num_horas,id_articulo_desplazamiento";
				$datosInsert = array($_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["num_contrato"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"],$_POST["id_tarifa"],$_POST["pack_horas"],$_POST["num_horas"],$_POST["id_articulo_desplazamiento"]);
				insertFunction ("sgm_contratos",$camposInsert,$datosInsert);

				$sqlc = "select id from sgm_contratos where num_contrato='".$_POST["num_contrato"]."' and visible=1";
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				$rowc = mysqli_fetch_array($resultc);
				$id_contrato = $rowc["id"];
			}

			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 order by servicio";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				if ($_POST["servicios".$row["id"]] == 1){
					$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email";
					$datosInsert = array($id_contrato,$_POST["servicio".$row["id"]],$_POST["obligatorio".$row["id"]],$_POST["extranet".$row["id"]],$_POST["incidencias".$row["id"]],$_POST["id_cobertura".$row["id"]],$_POST["temps_resposta".$row["id"]],$_POST["nbd".$row["id"]],$_POST["sla".$row["id"]],$_POST["duracion".$row["id"]],$_POST["precio_hora".$row["id"]],$_POST["codigo_catalogo".$row["id"]],$_POST["auto_email".$row["id"]]);
					insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
				}
			}
		}
		if (($soption == 100) and ($ssoption == 2)) {
			$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email";
			$datosInsert = array($rowc["id"],$rowcs["servicio"],$rowcs["obligatorio"],$rowcs["extranet"],$rowcs["incidencias"],$rowcs["id_cobertura"],$rowcs["temps_resposta"],$rowcs["nbd"],$rowcs["sla"],$rowcs["duracion"],$rowcs["precio_hora"],$rowcs["codigo_catalogo"],$rowcs["auto_email"]);
			insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
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
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=120&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Facturacion."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=160&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Incidencias."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=150&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Tecnicos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=130&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Archivos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=140&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Notificaciones."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=170&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Desplazamientos."</a></td>";
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
					echo "<br>".$Cliente.": <a href=\"index.php?op=1008&sop=140&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a>";
					echo "<br>".$Cliente." ".$Final.": <a href=\"index.php?op=1008&sop=140&id=".$rowa2["id"]."\">".$rowa2["nombre"]." ".$rowa2["cognom1"]." ".$rowa2["cognom2"]."</a>";
				echo "</td>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						$sqldiv = "select * from sgm_divisas where predefinido=1";
						$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
						$rowdiv = mysqli_fetch_array($resultdiv);
						$sqlfact = "select sum(subtotal) as total_fact from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]." and tipo in (select id from sgm_factura_tipos where contabilidad=1)";
						$resultfact = mysqli_query($dbhandle,convertSQL($sqlfact));
						$rowfact = mysqli_fetch_array($resultfact);
						echo "<tr><td>".$Total." ".$Contrato."</td><td style=\"text-align:right;\">".number_format ($rowfact["total_fact"],3,",",".")." ".$rowdiv["abrev"]."</td></tr>";
						$sqlfact2 = "select sum(subtotal) as total_fact2 from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]." and tipo in (select id from sgm_factura_tipos where contabilidad=1 and v_recibos=1)";
						$resultfact2 = mysqli_query($dbhandle,convertSQL($sqlfact2));
						$rowfact2 = mysqli_fetch_array($resultfact2);
						echo "<tr><td>".$Facturado."</td><td style=\"text-align:right;\">".number_format ($rowfact2["total_fact2"],3,",",".")." ".$rowdiv["abrev"]."</td></tr>";
						$fact_pendiente = $rowfact["total_fact"] - $rowfact2["total_fact2"];
						echo "<tr><td>".$Pendiente."</td><td style=\"text-align:right;\">".number_format ($fact_pendiente,3,",",".")." ".$rowdiv["abrev"]."</td></tr>";
						$sqlfact3 = "select sum(subtotal) as total_fact from sgm_cabezera where visible=1 and fecha<'".date("Y-m-d")."' and id_contrato=".$_GET["id"]." and tipo in (select id from sgm_factura_tipos where contabilidad='-1')";
						$resultfact3 = mysqli_query($dbhandle,convertSQL($sqlfact3));
						$rowfact3 = mysqli_fetch_array($resultfact3);
						
						$ini_con = date('U',strtotime($rowcontrato["fecha_ini"]));
						$fin_con = date('U',strtotime($rowcontrato["fecha_fin"]));
						$fecha_anterior = 0;
						$contador_deplazamiento = 0;
						$sql = "select * from sgm_incidencias where (fecha_inicio>".$ini_con.") and (fecha_inicio<".$fin_con.") and id_servicio in (select id from sgm_contratos_servicio where id_contrato=".$_GET["id"].") and desplazamiento=1 order by fecha_inicio";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($row["fecha_inicio"] != $fecha_anterior){
								$contador_deplazamiento++;
							}
							$fecha_anterior = $row["fecha_inicio"];
						}
						$sqlar = "select pvp from sgm_stock where vigente=1 and id_article=".$rowcontrato["id_articulo_desplazamiento"];
						$resultar = mysqli_query($dbhandle,convertSQL($sqlar));
						$rowar = mysqli_fetch_array($resultar);

						$total_gasto = $rowfact3["total_fact"]+($contador_deplazamiento*$rowar["pvp"]);
						
						echo "<tr><td>".$Gastos."</td><td style=\"text-align:right;\">".number_format ($total_gasto,3,",",".")." ".$rowdiv["abrev"]."</td></tr>";
					echo "</table>";
				echo "</td>";
#				echo "<td style=\"vertical-align:top\">";
#					echo "<table cellpadding=\"0\">";
#						echo "<tr><td class=\"ficha\"><a href=\"index.php?op=1011&sop=195&id=".$row["id"]."\" style=\"color:white;\">".$Opciones."</a></td></tr>";
#					echo "</table>";
#				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 100) {
		echo "<h4>".$Datos." ".$Contrato." : </h4>";
		mostrarContrato ($id_contrato,0,$_GET["id_cli"]);
	}

	if ($soption == 101) {
		echo "<h4>".$Servicios." : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Servicio."</th>";
				echo "<th>".$Codigo." ".$Catalogo."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios9."\"></th>";
				echo "<th>".$Prefijo." ".$Notificacion."</th>";
				echo "<th>".$Obligatorio."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios1."\"></th>";
				echo "<th>".$Extranet."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios2."\"></th>";
				echo "<th>".$Incidencias."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios3."\"></th>";
				echo "<th>".$Duracion."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios4."\"></th>";
				echo "<th>".$Cobertura."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios5."\"></th>";
				echo "<th>".$Tiempo."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios6."\"></th>";
				echo "<th>".$NBD."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios7."\"></th>";
				echo "<th>".$SLA." %<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios8."\"></th>";
				echo "<th>".$Precio."</th>";
				echo "<th>".$AutoEmail."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios10."\"></th>";
				echo "<th>".$Funcion."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios11."\"></th>";
				echo "<th>".$Origen."<img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_servicios12."\"></th>";
				echo "<th></th>";
			echo "</tr>";
			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 order by servicio";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<form action=\"index.php?op=1011&sop=100&ssop=1\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"servicios".$row["id"]."\" value=\"1\" style=\"border:0px solid black\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["servicio"]."\" style=\"width:250px\" name=\"servicio".$row["id"]."\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["codigo_catalogo"]."\" style=\"width:100px\" name=\"codigo_catalogo".$row["id"]."\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["prefijo_notificacion"]."\" style=\"width:100px\" name=\"prefijo_notificacion".$row["id"]."\"></td>";
					echo "<td><select style=\"width:70px\" name=\"obligatorio".$row["id"]."\">";
						if ($row["obligatorio"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"extranet".$row["id"]."\">";
						if ($row["extranet"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"incidencias".$row["id"]."\">";
						if ($row["incidencias"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"duracion".$row["id"]."\">";
						if ($row["duracion"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"id_cobertura".$row["id"]."\">";
						echo "<option value=\"0\">-</option>";
						$sqls = "select id,nombre from sgm_contratos_sla_cobertura where visible=1 order by nombre";
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						while ($rows = mysqli_fetch_array($results)) {
							if ($rows["id"] == $row["id_cobertura"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rows["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rows["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"temps_resposta".$row["id"]."\">";
						for ($i = 0; $i <= 24 ; $i++) {
							if ($i == $row["temps_resposta"]){
								echo "<option value=\"".$i."\" selected>".$i."</option>";
							} else {
								echo "<option value=\"".$i."\">".$i."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"nbd".$row["id"]."\">";
						if ($row["nbd"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"number\" min=\"0\" value=\"".$row["sla"]."\" style=\"text-align:right;width:70px\" name=\"sla".$row["id"]."\"></td>";
					echo "<td><input type=\"number\" min=\"0\" step=\"any\" value=\"".$row["precio_hora"]."\" style=\"text-align:right;width:70px\" name=\"precio_hora".$row["id"]."\"></td>";
					echo "<td><select style=\"width:70px\" name=\"auto_email".$row["id"]."\">";
						if ($row["auto_email"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" value=\"".$row["funcion"]."\" style=\"width:150px\" name=\"funcion".$row["id"]."\"></td>";
					echo "<td><select style=\"width:70px\" name=\"id_servicio_origen".$row["id"]."\">";
						echo "<option value=\"0\">-</option>";
						$sqlcso = "select id,codigo_origen from sgm_contratos_servicio_origen where visible=1 order by codigo_origen";
						$resultcso = mysqli_query($dbhandle,convertSQL($sqlcso));
						while ($rowcso = mysqli_fetch_array($resultcso)) {
							if ($rowcso["id"] == $row["id_servicio_origen"]){
								echo "<option value=\"".$rowcso["id"]."\" selected>".$rowcso["codigo_origen"]."</option>";
							} else {
								echo "<option value=\"".$rowcso["id"]."\">".$rowcso["codigo_origen"]."</option>";
							}
						}
					echo "</select></td>";
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
			echo "</tr>";
			echo "<input type=\"hidden\" name=\"id_contrato_tipo\" value=\"".$_POST["id_contrato_tipo"]."\">";
			echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
			echo "<input type=\"hidden\" name=\"id_cliente_final\" value=\"".$_POST["id_cliente_final"]."\">";
			echo "<input type=\"hidden\" name=\"num_contrato\" value=\"".$_POST["num_contrato"]."\">";
			echo "<input type=\"hidden\" name=\"fecha_ini\" value=\"".$_POST["fecha_ini"]."\">";
			echo "<input type=\"hidden\" name=\"fecha_fin\" value=\"".$_POST["fecha_fin"]."\">";
			echo "<input type=\"hidden\" name=\"descripcion\" value=\"".$_POST["descripcion"]."\">";
			echo "<input type=\"hidden\" name=\"id_responsable\" value=\"".$_POST["id_responsable"]."\">";
			echo "<input type=\"hidden\" name=\"id_tecnico\" value=\"".$_POST["id_tecnico"]."\">";
			echo "<input type=\"hidden\" name=\"id_tarifa\" value=\"".$_POST["id_tarifa"]."\">";
			echo "<input type=\"hidden\" name=\"pack_horas\" value=\"".$_POST["pack_horas"]."\">";
			echo "<input type=\"hidden\" name=\"num_horas\" value=\"".$_POST["num_horas"]."\">";
			echo "<input type=\"hidden\" name=\"id_articulo_desplazamiento\" value=\"".$_POST["id_articulo_desplazamiento"]."\">";
		echo "</form>";
		echo "</table>";
		echo "<br><br>";
	}

	if ($soption == 110) {
		echo "<h4>".$Servicios." : </h4>";
		mostrarServicio ($_GET["id"],0,111);
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=110&ssop=4&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"],"op=1011&sop=110&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 120) {
		echo "<h4>".$Facturacion."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"2\" class=\"lista\">";
			echo "<tr>";
			$sqltipos2 = "select id,tipo from sgm_factura_tipos where visible=1 and id in (select tipo from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"].") order by orden,descripcion";
			$resulttipos2 = mysqli_query($dbhandle,convertSQL($sqltipos2));
			while ($rowtipos2 = mysqli_fetch_array($resulttipos2)) {
				$sqlpermiso = "select count(*) as total from sgm_factura_tipos_permisos where id_tipo=".$rowtipos2["id"]." and id_user=".$userid;
				$resultpermiso = mysqli_query($dbhandle,convertSQL($sqlpermiso));
				$rowpermiso = mysqli_fetch_array($resultpermiso);
				if ($rowpermiso["total"] > 0) { 
					if ($rowtipos2["id"] == $_GET["id_tipo"]) {$class2 = "menu_select";} else {$class2 = "menu";}
					echo "<td class=".$class2."><a href=\"index.php?op=1011&sop=120&id=".$_GET["id"]."&id_tipo=".$rowtipos2["id"]."&hist=1\" class=".$class2.">".$rowtipos2["tipo"]."</a></td>";
				} else { echo "<td style=\"background-color:black;color:white;border:1px solid black;text-align:center;vertical-align:middle;height:20px;width:150px;\"><a href=\"index.php?op=1008&sop=160\" class=\"menu\">".$rowtipos2["tipo"]."</a></td>"; }
			}
			echo "</tr>";
		echo "</table>";

		echo "<br>";
		$sqltipos = "select * from sgm_factura_tipos where id=".$_GET["id_tipo"];
		$resulttipos = mysqli_query($dbhandle,convertSQL($sqltipos));
		$rowtipos = mysqli_fetch_array($resulttipos);
		echo "<table cellpadding=\"2\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th></th>";
				if (($rowtipos["v_recibos"] == 0) and ($rowtipos["v_fecha_prevision"] == 0) and ($rowtipos["v_rfq"] == 0) and ($rowtipos["presu"] == 0) and ($rowtipos["dias"] == 0) and ($rowtipos["v_fecha_vencimiento"] == 0) and ($rowtipos["v_numero_cliente"] == 0) and ($rowtipos["tipo_ot"] == 0)) {
					echo "<th>Docs</th>";
				} else {echo "<th></th>";}
				echo "<th style=\"min-width:60px;\">".$Numero."</th>";
				if ($rowtipos["presu"] == 1) { echo "<th>Ver.</th>";} else {echo "<th></th>";}
				echo "<th style=\"min-width:65px;\">".$Fecha."</th>";
				if ($rowtipos["v_fecha_prevision"] == 1) { echo "<th style=\"min-width:70px;\">".$Prevision."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_fecha_vencimiento"] == 1) { echo "<th style=\"min-width:70px;\">".$Vencimiento."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_numero_cliente"] == 1) { echo "<th style=\"min-width:80px;\">Ref. Ped. ".$Cliente."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_rfq"] == 1) { echo "<th style=\"min-width:80px;\">".$Numero." RFQ</th>";} else {echo "<th></th>";}
				if ($rowtipos["tpv"] == 0) { echo "<th class=\"factur\">".$Cliente."</th>";} else {echo "<th></th>";}
				if ($rowtipos["v_subtipos"] == 1) { echo "<th style=\"min-width:100px;\">".$Subtipo."</th>";} else {echo "<th></th>";}
				echo "<th style=\"text-align:right;\">".$Subtotal."</th>";
				echo "<th style=\"text-align:right;\">".$Total."</th>";
				if ($rowtipos["v_recibos"] == 1)  {echo "<th style=\"text-align:right;\">".$Pendiente."</th>";} else {echo "<th></th>";}
				if ($_GET["id"]) {$link = "&id=".$_GET["id"];} else {$link = "";}
				if ($_GET["id_tipo"]) {$link .= "&id_tipo=".$_GET["id_tipo"];} else {$link .= "";}
				if ($_GET["hist"]) {$link .= "&hist=".$_GET["hist"];} else {$link .= "";}
				if ($_GET["filtra"] == 0){
					echo "<form action=\"index.php?op=1008&sop=".$_GET["sop"]."&filtra=1".$link."\" method=\"post\">";
				} else {
					echo "<form action=\"index.php?op=1008&sop=".$_GET["sop"]."&filtra=0".$link."\" method=\"post\">";
				}
				echo "<input type=\"Hidden\" name=\"id_cliente\" value=\"".$_POST["id_cliente"]."\">";
				echo "<input type=\"Hidden\" name=\"ref_cli\" value=\"".$_POST["ref_cli"]."\">";
				echo "<input type=\"Hidden\" name=\"data_desde1\" value=\"".$_POST["data_desde1"]."\">";
				echo "<input type=\"Hidden\" name=\"data_fins1\" value=\"".$_POST["data_fins1"]."\">";
				echo "<input type=\"Hidden\" name=\"codigo\" value=\"".$_POST["codigo"]."\">";
				echo "<input type=\"Hidden\" name=\"articulo\" value=\"".$_POST["articulo"]."\">";
				echo "<input type=\"Hidden\" name=\"hist\" value=\"".$_POST["hist"]."\">";
				echo "<input type=\"Hidden\" name=\"todo\" value=\"1\">";
				if ($_GET["filtra"] == 0){
					echo "<td colspan=\"3\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Desplegar." ".$Todo."\"></td>";
				} else {
					echo "<td colspan=\"3\"></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Plegar." ".$Todo."\"></td>";
				}
				echo "</form>";
			echo "</tr>";
			$sql = "select * from sgm_cabezera where visible=1 and id_contrato=".$_GET["id"]." and tipo=".$_GET["id_tipo"];
			$sql = $sql." order by numero desc,version desc,fecha desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo mostrarFacturas($row);
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
		echo "<h4>".$Archivos." : <img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_archivos."\"></h4>";
		anadirArchivo ($_GET["id"],3,"");
	}

	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=130&ssop=2&id=".$_GET["id"]."&id_con=".$_GET["id_con"]."&id_archivo=".$_GET["id_archivo"],"op=1011&sop=130&id=".$_GET["id"]."&id_con=".$_GET["id_con"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 140) {
		if ($ssoption == 1) {
			$camposInsert = "id_contrato,id_servicio,id_usuario,id_usuario_origen,tipo_edicion_todas,tipo_edicion_anadir,tipo_edicion_modificar,tipo_edicion_cerrar";
			$datosInsert = array($_GET["id"],$_POST["id_servicio"],$_POST["id_usuario"],$_POST["id_usuario_origen"],$_POST["todas"],$_POST["anadir"],$_POST["modificar"],$_POST["cerrar"]);
			insertFunction ("sgm_contratos_servicio_notificacion",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("id_contrato","id_servicio","id_usuario","id_usuario_origen","tipo_edicion_todas","tipo_edicion_anadir","tipo_edicion_modificar","tipo_edicion_cerrar");
			$datosUpdate = array($_GET["id"],$_POST["id_servicio"],$_POST["id_usuario"],$_POST["id_usuario_origen"],$_POST["todas"],$_POST["anadir"],$_POST["modificar"],$_POST["cerrar"]);
			updateFunction ("sgm_contratos_servicio_notificacion",$_GET["id_not"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_contratos_servicio_notificacion",$_GET["id_not"]);
		}

		echo "<h4>".$Notificaciones." : <img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_notificaciones."\"></h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th colspan=\"4\" style=\"text-align:center;\">".$Tipo." ".$Edicion." ".$Incidencia."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Servicio."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Usuarios." ".$Origen." ".$Incidencia."</th>";
				echo "<th>".$Todos."</th>";
				echo "<th>".$Anadir."</th>";
				echo "<th>".$Modificar."</th>";
				echo "<th>".$Cerrar."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
			echo "<form action=\"index.php?op=1011&sop=140&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select name=\"id_servicio\" style=\"width:300px\">";
					$sql = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"]." order by servicio";
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
				echo "<td><select name=\"id_usuario_origen\" style=\"width:300px\">";
					echo "<option value=\"-1\">".$Todos."</option>";
					$sql = "select id,usuario from sgm_users where validado=1 and activo=1 and id in (select id_user from sgm_users_clients where id_client=".$rowcontrato["id_cliente"].") order by usuario";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["usuario"]."</option>";
					}
				echo "</select></td>";

				echo "<td><input type=\"Checkbox\" name=\"todas\" value=\"1\"></td>";
				echo "<td><input type=\"Checkbox\" name=\"anadir\" value=\"1\"></td>";
				echo "<td><input type=\"Checkbox\" name=\"modificar\" value=\"1\"></td>";
				echo "<td><input type=\"Checkbox\" name=\"cerrar\" value=\"1\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_servicio_notificacion where id_contrato=".$_GET["id"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=141&id=".$_GET["id"]."&id_not=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=140&ssop=2&id=".$_GET["id"]."&id_not=".$row["id"]."\" method=\"post\">";
					echo "<td><select name=\"id_servicio\" style=\"width:300px\">";
					$sqls = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"]." order by servicio";
					$results = mysqli_query($dbhandle,convertSQL($sqls));
					while ($rows = mysqli_fetch_array($results)) {
						if ($row["id_servicio"] == $rows["id"]){
							echo "<option value=\"".$rows["id"]."\" selected>".$rows["servicio"]."</option>";
						} else {
							echo "<option value=\"".$rows["id"]."\">".$rows["servicio"]."</option>";
						} 
					}
					echo "</select></td>";
				echo "<td><select name=\"id_usuario\" style=\"width:300px\">";
					$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and id in (select id_user from sgm_users_clients where id_client=".$rowcontrato["id_cliente"].") order by usuario";
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					while ($rowu = mysqli_fetch_array($resultu)) {
						if ($row["id_usuario"] == $rowu["id"]){
							echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowu["id"]."\">".$rowu["usuario"]."</option>";
						} 
					}
				echo "</select></td>";
				echo "<td><select name=\"id_usuario_origen\" style=\"width:300px\">";
					if ($row["id_usuario_origen"] == '-1'){
						echo "<option value=\"-1\" selected>".$Todos."</option>";
					} else {
						echo "<option value=\"-1\">".$Todos."</option>";
					} 
					$sqlu2 = "select id,usuario from sgm_users where validado=1 and activo=1 and id in (select id_user from sgm_users_clients where id_client=".$rowcontrato["id_cliente"].") order by usuario";
					$resultu2 = mysqli_query($dbhandle,convertSQL($sqlu2));
					while ($rowu2 = mysqli_fetch_array($resultu2)) {
						if ($row["id_usuario_origen"] == $rowu2["id"]){
							echo "<option value=\"".$rowu2["id"]."\" selected>".$rowu2["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowu2["id"]."\">".$rowu2["usuario"]."</option>";
						} 
					}
				echo "</select></td>";
					echo "<td><input type=\"Checkbox\" name=\"todas\" value=\"1\"";
					if ($row["tipo_edicion_todas"] == 1){ echo "checked";}
					echo "></td>";
					echo "<td><input type=\"Checkbox\" name=\"anadir\" value=\"1\"";
					if ($row["tipo_edicion_anadir"] == 1){ echo "checked";}
					echo "></td>";
					echo "<td><input type=\"Checkbox\" name=\"modificar\" value=\"1\"";
					if ($row["tipo_edicion_modificar"] == 1){ echo "checked";}
					echo "></td>";
					echo "<td><input type=\"Checkbox\" name=\"cerrar\" value=\"1\"";
					if ($row["tipo_edicion_cerrar"] == 1){ echo "checked";}
					echo "></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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

	if ($soption == 150) {
		if ($ssoption == 1) {
			$camposInsert = "id_contrato,id_usuario";
			$datosInsert = array($_GET["id"],$_POST["id_usuario"]);
			insertFunction ("sgm_contratos_usuarios",$camposInsert,$datosInsert);
		}
		if ($ssoption == 3) {
			deleteFunction ("sgm_contratos_usuarios",$_GET["id_con_user"]);
		}

		echo "<h4>".$Tecnicos." : <img src=\"mgestion/pics/icons-mini/information.png\" alt=\"Info\" border=\"0\" title=\"".$info_contrato_tecnicos."\"></h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th></th>";
				echo "<th>".$Usuario."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
			echo "<form action=\"index.php?op=1011&sop=150&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><select name=\"id_usuario\" style=\"width:300px\">";
					$sql = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 order by usuario";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["usuario"]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_usuarios where id_contrato=".$_GET["id"]."";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=151&id=".$_GET["id"]."&id_con_user=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 and id=".$row["id_usuario"];
					$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
					$rowu = mysqli_fetch_array($resultu);
					echo "<td>".$rowu["usuario"]."</td>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 151) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=150&ssop=3&id=".$_GET["id"]."&id_con_user=".$_GET["id_con_user"],"op=1011&sop=150&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 160) {
		echo "<h4>".$Incidencias."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>ID</th>";
				echo "<th>".$SLA."</th>";
				echo "<th>".$Fecha." ".$Prevision."</th>";
				echo "<th>".$Asunto."</th>";
				echo "<th colspan=\"2\">".$Nivel." ".$Tecnico."</a></th>";
				echo "<th>".$Servicio."</th>";
				echo "<th>".$Usuario." ".$Destino."</th>";
				echo "<th>".$Tiempo."</th>";
			echo "</tr>";
		$sqli = "select * from sgm_incidencias where visible=1 and id_servicio in (select id from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"]." order by servicio) and id_incidencia=0 order by id";
		$resulti = mysqli_query($dbhandle,convertSQL($sqli));
		while ($rowi = mysqli_fetch_array($resulti)){
			$estado_color = "White";
			$estado_color_letras = "Black";

			$sqlu = "select usuario from sgm_users where id=".$rowi["id_usuario_destino"];
			$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
			$rowu = mysqli_fetch_array($resultu);
			$sqlc = "select servicio,id_contrato,temps_resposta from sgm_contratos_servicio where id=".$rowi["id_servicio"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$sqls = "select id_cliente,descripcion from sgm_contratos where id=".$rowc["id_contrato"];
			$results = mysqli_query($dbhandle,convertSQL($sqls));
			$rows = mysqli_fetch_array($results);

			if ($rowi["id_servicio"] == 0){
				$estado_color = "black";
				$estado_color_letras = "white";
			}

			$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]." and visible=1";
			$resultd = mysqli_query($dbhandle,convertSQL($sqld));
			$rowd = mysqli_fetch_array($resultd);
			$hora = $rowd["total"]/60;
			$horas = explode(".",$hora);
			$minutos = $rowd["total"] % 60;
			if ($rowc["temps_resposta"] != 0){
				if ($rowi["id_estado"] != -2) { $hora_actual = time(); }
				if ($rowi["id_estado"] == -2) { $hora_actual = $rowi["fecha_registro_cierre"]; }
				$horax = $rowi["temps_pendent"]/3600;
				$horas2 = explode(".",$horax);
				$minutox = (($horax - $horas2[0])*60);
				$minutos2 = explode(".",$minutox);
				$sla = "".$horas2[0]."h. ".$minutos2[0]."m.";
				if ($horas2[0] > 4){
						$estado_color = "White";
						$estado_color_letras = "";
				}
				if (($horas2[0] < 4) and ($horas2[0] >= 0)) {
						$estado_color = "Orange";
						$estado_color_letras = "";
				}
				if (($horas2[0] < 0) or ($minutos2[0] < 0)) {
					$estado_color = "Red";
					$estado_color_letras = "White";
				}
				if ($rowi["id_estado"] == -1) { $fecha_prev = date("Y-m-d H:i:s", $rowi["fecha_prevision"]); }
				if ($rowi["id_estado"] == -2) { $fecha_prev = date("Y-m-d H:i:s", $rowi["fecha_registro_cierre"]); }
			} else {
				$sla = "";
				$fecha_prev = "";
			}
			if ($rowi["pausada"] == 1){
				$fecha_prev = "";
				$estado_color = "#E5E5E5";
				$estado_color_letras = "";
			}
			echo "<tr style=\"background-color:".$estado_color.";\">";
				echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:50px;\">".$rowi["id"]."</td>";
				echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:100px;\" nowrap>".$sla."</td>";
				echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:150px;\" nowrap>".$fecha_prev."</td>";
				if (($rowi["id_estado"] <> -2) and ($rowi["pausada"] != 1)){$estado_color = "#33CC33";}
				if ($rowi["asunto"] != ""){$asun = $rowi["asunto"];} else {$asun = $SinAsunto;}
				echo "<td style=\"vertical-align:top;background-color:".$estado_color.";\"><a href=\"index.php?op=1018&sop=100&id=".$rowi["id"].$adres."\" style=\"color:".$estado_color_letras.";\">".$asun."<a></td>";
				if ($rowi["nivel_tecnico"] == 1) {$icon = "medal_bronze_3.png";} elseif ($rowi["nivel_tecnico"] == 2) {$icon = "medal_silver_3.png";} elseif ($rowi["nivel_tecnico"] == 3) {$icon = "medal_gold_3.png";} else {$icon = "";}
				if ($rowi["nivel_tecnico"] > 0) { $nivel_tech = $rowi["nivel_tecnico"]; } else { $nivel_tech = $Sin;}
				echo "<td style=\"vertical-align:top;text-align:center;width:30px;background-color:".$estado_color.";color:".$estado_color_letras.";\">".$nivel_tech."</td>";
				echo "<td style=\"text-align:left;vertical-align:top;width:50px;\"><img src=\"mgestion/pics/icons-mini/".$icon."\" alt=\"".$Nivel."\" title=\"".$Nivel."\" style=\"border:0px;\"></td>";
				if ($rowi["id_servicio"] > 0) {$texto_servicio = $rowc["servicio"]." (".$rows["descripcion"].")"; } elseif ($rowi["id_servicio"] == -1) { $texto_servicio = $SinContrato;} else {$texto_servicio = '';}
				echo "<td style=\"vertical-align:top;\"><a href=\"index.php?op=1011&sop=110&id=".$rowc["id_contrato"]."\" style=\"color:".$estado_color_letras.";\">".$texto_servicio."<a></td>";
				echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:100px;\">".$rowu["usuario"]."</td>";

			$sqldd = "select sum(duracion) as temps from sgm_incidencias where visible=1 and id_incidencia=".$rowi["id"]."";
			$resultdd = mysqli_query($dbhandle,convertSQL($sqldd));
			$rowdd = mysqli_fetch_array($resultdd);
			$horad = $rowdd["temps"]/60;
			$horasd = explode(".",$horad);
			$minutosd = $rowdd["temps"] % 60;
			$temps_total += $rowdd["temps"];

			if (($_POST["dia"] != 0) or ($_GET["d"] != 0) or ($_POST["mes"] != 0) or ($_GET["m"] != 0) or ($_POST["any"] != 0) or ($_GET["a"] != 0) or ($_GET["u"] != 0)){
				$duration = $horasd[0]."h. ".$minutosd."m. (".$horas[0]."h. ".$minutos."m.)";
			} else {
				$duration = $horas[0]."h. ".$minutos."m.";
			}
			echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:100px;\" nowrap>".$duration."</td>";
			if (($soption == 0) or ($soption == 1)){
				echo "<form action=\"index.php?op=1018&sop=3&id=".$rowi["id"]."&id_cli=".$_GET["id_cli"]."\" method=\"post\">";
				echo "<td style=\"color:".$estado_color_letras.";vertical-align:top;width:50px;\"><input type=\"number\" name=\"id_inc_rel\" style=\"width:100%\" min=\"1\"></td>";
				echo "<td class=\"submit\" style=\"vertical-align:top;\"><input type=\"Submit\" value=\"".$Relacion."\"></td>";
				echo "</form>";
			}
			echo "</tr>";
		}
			$horad2 = $temps_total/60;
			$horasd2 = explode(".",$horad2);
			$minutod2 = ($horad2 - $horasd2[0])*60;
			$minutosd2 = explode(".",$minutod2);

			echo "<tr><td colspan=\"8\"></td><td style=\"text-align:left;\"><strong>";
			if ($temps_total > 0) {
				echo $horasd2[0]."h. ".$minutosd2[0]."m.";
			}
			echo "</strong></td><td></td></tr>";
		echo "</table>";
	}

	if ($soption == 170) {
		echo "<h4>".$Desplazamientos."</h4>";
		$sqlc = "select * from sgm_contratos where visible=1 and id=".$_GET["id"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Asunto."</th>";
			echo "</tr>";
			$ini_con = date('U',strtotime($rowc["fecha_ini"]));
			$fin_con = date('U',strtotime($rowc["fecha_fin"]));
			$fecha_anterior = 0;
			$contador_deplazamiento = 0;
			$sql = "select * from sgm_incidencias where (fecha_inicio>".$ini_con.") and (fecha_inicio<".$fin_con.") and id_servicio in (select id from sgm_contratos_servicio where id_contrato=".$_GET["id"].") and desplazamiento=1 order by fecha_inicio";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr><td>".date('Y-m-d',$row["fecha_inicio"])."</td><td>".$row["asunto"]."</td></tr>";
				if ($row["fecha_inicio"] != $fecha_anterior){
					$contador_deplazamiento++;
				}
				$fecha_anterior = $row["fecha_inicio"];
			}
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Total." ".$Desplazamientos."</th>";
				echo "<th>".$contador_deplazamiento."</th>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 210) {
		echo "<strong>".$Indicadores." : </strong><br><br>";
		resumEconomicContractes(0);
	}

	#Informes
	if ($soption == 290) {
		informesContratos(0);
	}

	if ($soption == 500) {
		if ($admin == true) {
			echo boton(array("op=1011&sop=510","op=1011&sop=520","op=1011&sop=530","op=1011&sop=540","op=1011&sop=550","op=1011&sop=580"),array($Tipo." ".$Contratos,$Cobertura." ".$SLA,$Plantillas." ".$Contrato,$Servicios,$Origen." ".$Servicios,$Tarifas));
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
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_tipos where visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=511&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=510&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_sla_cobertura where visible=1 order by nombre";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=521&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:150px\" name=\"nombre\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:350px\" name=\"descripcion\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
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
			$sqlcc = "select id from sgm_contratos where visible=1 and id=".$_GET["id"]."";
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
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=531&id=".$rowcc["id"]."&act=".$_GET["act"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
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
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
				if ($rowcc["activo"] == 1) {
					echo "<form action=\"index.php?op=1011&sop=530&ssop=5&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Desactivar."\"></td>";
				} else {
					echo "<form action=\"index.php?op=1011&sop=530&ssop=6&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Activar."\"></td>";
				}
				echo "</form>";
				if ($rowcc["renovado"] == 0) {
					echo "<form action=\"index.php?op=1011&sop=530&ssop=7&id=".$rowcc["id"]."&act=".$_GET["act"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"renovar".$Renovar."\"></td>";
					echo "</form>";
				} else {
					echo "<td></td>";
				}
#					echo "<td>";
#						echo boton(array("op=1011&sop=535&id=".$rowcc["id"]),array($Servicios));
#					echo "</td>";
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

	if (($soption == 540) and ($admin == true)) {
		$sqlcc = "select num_contrato,descripcion from sgm_contratos where id=".$_GET["id"]."";
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		echo "<h4>".$Servicios." ".$Contrato." : ".$rowcc["num_contrato"]."-".$rowcc["descripcion"]."</h4>";
		echo boton(array("op=1011&sop=530"),array("&laquo; ".$Volver));
		mostrarServicio(0,0,541);
	}

	if (($soption == 541) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=535&ssop=3&id=".$_GET["id"]."&id_ser=".$_GET["id_ser"],"op=1011&sop=535&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 550) and ($admin == true)) {
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
				echo "<form action=\"index.php?op=1011&sop=550&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"codigo_origen\"></td>";
				echo "<td><input type=\"text\" style=\"width:350px\" name=\"descripcion_origen\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_servicio_origen where visible=1 order by codigo_origen";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=551&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=550&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["codigo_origen"]."\" style=\"width:150px\" name=\"codigo_origen\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["descripcion_origen"]."\" style=\"width:350px\" name=\"descripcion_origen\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 551) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=550&ssop=3&id=".$_GET["id"],"op=1011&sop=550"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 580) {
		if ($ssoption == 1) {
			$camposInsert = "nombre,porcentage,descuento";
			$datosInsert = array($_POST["nombre"],$_POST["porcentage"],$_POST["descuento"]);
			insertFunction ("sgm_tarifas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('nombre','porcentage','descuento');
			$datosUpdate=array($_POST["nombre"],$_POST["porcentage"],$_POST["descuento"]);
			updateFunction("sgm_tarifas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_tarifas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Tarifas."</h4>";
		echo boton(array("op=1011&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Descuento."/".$Incremento."</th>";
				echo "<th>".$Nombre."</th>";
				echo "<th>".$Porcentage."</th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1011&sop=580&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td>";
					echo "<select name=\"descuento\" style=\"width:150px\">";
						echo "<option value=\"1\" selected>".$Descuento." ".$PVP."</option>";
						echo "<option value=\"0\">".$Incremento." ".$PVD."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\"></td>";
				echo "<td><input type=\"number\" min=\"1\" name=\"porcentage\" style=\"width:70px\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_tarifas where visible=1";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1011&sop=581&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1011&sop=580&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td>";
						echo "<select name=\"descuento\" style=\"width:150px\">";
							if ($row["descuento"] == 0) {
								echo "<option value=\"1\">".$Descuento." PVP</option>";
								echo "<option value=\"0\" selected>".$Incremento." PVD</option>";
							}
							if ($row["descuento"] == 1) {
								echo "<option value=\"1\" selected>".$Descuento." PVP</option>";
								echo "<option value=\"0\">".$Incremento." PVD</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:200px\" value=\"".$row["nombre"]."\"></td>";
					echo "<td><input type=\"number\" min=\"1\" name=\"porcentage\" style=\"width:70px\" value=\"".$row["porcentage"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 581) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1011&sop=580&ssop=3&id=".$_GET["id"],"op=1011&sop=580"),array($Si,$No));
		echo "</center>";
	}

	echo "</td></tr></table><br>";
}
?>

