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
				if ($_POST["id_cliente2"] > 0) {
					$sqlcc = $sqlcc." and id_cliente=".$_POST["id_cliente2"]."";
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
					if (date('U',strtotime($rowcc["fecha_fin"])) < date('U')) { $color = "red"; $color_letra = "white";}
					else { $color = "white"; $color_letra = "";}
					echo "<tr style=\"background-color:".$color."\">";
						echo "<td style=\"text-align:center;color:".$color_letra."\"><a href=\"index.php?op=1011&sop=10&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
						$sql = "select id,nombre from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\" style=\"color:".$color_letra."\">".$row["nombre"]."</a></td>";
						$sql = "select id,nombre from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1008&sop=140&id=".$row["id"]."\" style=\"color:".$color_letra."\">".$row["nombre"]."</a></td>";
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
				$camposInsert = "id_contrato_tipo,id_cliente,id_cliente_final,num_contrato,fecha_ini,fecha_fin,descripcion,id_responsable,id_tecnico,id_tarifa,pack_horas,num_horas";
				$datosInsert = array($_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["num_contrato"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"],$_POST["id_tarifa"],$_POST["pack_horas"],$_POST["num_horas"]);
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
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=120&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Facturacion."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1011&sop=150&id=".$rowcontrato["id"]."\" style=\"color:white;\">".$Tecnicos."</a></td>";
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
						echo "<tr><td>".$Gastos."</td><td style=\"text-align:right;\">".number_format ($rowfact3["total_fact"],3,",",".")." ".$rowdiv["abrev"]."</td></tr>";
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

