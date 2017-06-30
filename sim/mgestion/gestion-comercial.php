<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1009) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Comercial."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
					if ($soption == 0) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1009&sop=0\" class=".$class.">".$Oferta_Comercial."</a></td>";
					if (($soption >= 100) and ($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1009&sop=100\" class=".$class.">".$Anadir." ".$Oferta_Comercial."</a></td>";
					if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1009&sop=200\" class=".$class.">".$Buscar." ".$Oferta_Comercial."</a></td>";
					if (($soption >= 500) and ($soption < 600)) {$class = "menu_select";} else {$class = "menu";}
					echo "<td class=".$class."><a href=\"index.php?op=1009&sop=500\" class=".$class.">".$Administrar."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
	echo "</table><br>";
	echo "<table class=\"principal\"><tr>";
	echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if (($soption == 0) or ($soption == 200)) {
		if ($ssoption == 1) {
			$camposInsert="numero,version,fecha,id_cliente,id_cliente_final,descripcion,id_plantilla,id_idioma,id_autor,num_dispositivos,num_servicios,id_tipo_servidor,id_software,socio_tecnologico";
			$datosInsert=array($_POST["numero"],$_POST["version"],$_POST["fecha"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["descripcion"],$_POST["id_plantilla"],$_POST["id_idioma"],$_POST["id_autor"],$_POST["num_dispositivos"],$_POST["num_servicios"],$_POST["id_tipo_servidor"],$_POST["id_software"],$_POST["socio_tecnologico"]);
			insertFunction("sim_comercial_oferta",$camposInsert,$datosInsert);

			$sqlcc = "select * from sim_comercial_oferta where visible=1 and numero=".$_POST["numero"];
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);

			$sqlco = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_POST["id_plantilla"]." order by orden";
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				$camposInsert="orden,id_comercial_contenido,id_comercial_oferta";
				$datosInsert=array($rowco["orden"],$rowco["id_comercial_contenido"],$rowcc["id"]);
				insertFunction("sim_comercial_oferta_rel_contenido",$camposInsert,$datosInsert);
			}
			$sqlc = "select * from sgm_contratos_servicio where id_contrato=0";
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			while ($rowc = mysqli_fetch_array($resultc)) {
				if(($_POST["servicios".$rowc["id"]] == 1) or ($rowc["obligatorio"] == 1)){
					$camposInsert="id_comercial_oferta,id_servicio";
					$datosInsert=array($rowcc["id"],$rowc["id"]);
					insertFunction("sim_comercial_oferta_rel_servicios",$camposInsert,$datosInsert);
				}
			}
		}
		if ($ssoption == 2) {
			$camposUpdate=array('aceptada');
			$datosUpdate=array(1);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
			# Pediente de que hacer en facturación #
		}
		if ($ssoption == 3) {
			$camposUpdate=array('aceptada');
			$datosUpdate=array(0);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$camposUpdate=array('cerrada');
			$datosUpdate=array(1);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate=array('cerrada');
			$datosUpdate=array(0);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Oferta_Comercial." :</h4>";
		if ($_GET["hist"] == 0) { echo boton(array("op=1009&sop=0&hist=1"),array($Historico)); }
		if ($_GET["hist"] == 1) { echo boton(array("op=1009&sop=0"),array($Actual)); $adresa = "&hist=".$_GET["hist"];}

		if ($soption == 200) {
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<th>".$Cliente."</th>";
					echo "<th>".$Cliente." ".$Final."</th>";
					echo "<th>".$Historico."</th>";
					echo "<th></th>";
				echo "</tr>";
				echo "<tr>";
					echo "<form action=\"index.php?op=1009&sop=200\" method=\"post\">";
					echo "<td style=\"width:500px\">";
						echo "<select name=\"id_cliente\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_cliente"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td style=\"width:500px\">";
						echo "<select name=\"id_cliente_final\">";
						echo "<option value=\"0\">-</option>";
						$sql = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 order by nombre";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							if ($_POST["id_cliente_final"] == $row["id"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["nombre"]." ".$row["cognom1"]." ".$row["cognom2"]."</option>";
							}
						}
						echo "</select>";
					echo "</td>";
					echo "<td style=\"width:50\">";
						echo "<select name=\"hist\">";
							if ($_POST["hist"] == 0){
								echo "<option value=\"0\" selected>".$No."</option>";
								echo "<option value=\"1\">".$Si."</option>";
							} else {
								echo "<option value=\"0\">".$No."</option>";
								echo "<option value=\"1\" selected>".$Si."</option>";
							}
						echo "</select>";
					echo "</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Buscar."\"></td>";
					echo "</form>";
				echo "</tr>";
			echo "</table>";
			echo "<br>";
		}
		if (($soption != 200) or ($_POST["id_cliente"] > 0) or ($_POST["id_cliente_final"] > 0)){
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
				echo "<tr style=\"background-color:silver\">";
					echo "<th>".$Eliminar."</th>";
					echo "<th style=\"width:400px;\">".$Cliente."</th>";
					echo "<th style=\"width:400px;\">".$Cliente." ".$Final."</th>";
					echo "<th style=\"width:200px;\">".$Descripcion."</th>";
					echo "<th></th>";
					echo "<th></th>";
					echo "<th></th>";
					echo "<th></th>";
				echo "</tr>";
				$sqlcc = "select * from sim_comercial_oferta where visible=1 and id_plantilla<>0 ";
				if ($_POST["id_cliente"] > 0) {
					$sqlcc = $sqlcc." and id_cliente=".$_POST["id_cliente"]."";
				}
				if ($_POST["id_cliente_final"] > 0) {
					$sqlcc = $sqlcc." and id_cliente_final=".$_POST["id_cliente_final"]."";
				}
				if ((($_GET["hist"] == 0) and ($soption != 200)) or (($_POST["hist"] == 0) and ($soption == 200))) { $sqlcc = $sqlcc." and cerrada=0";}
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				while ($rowcc = mysqli_fetch_array($resultcc)){
					if ($rowcc["aceptada"] == 1){$color = $color_verde;} else {$color = "white";}
					echo "<tr style=\"background-color:".$color.";\">";
					echo "<form action=\"index.php?op=1009&sop=100&id=".$rowcc["id"].$adresa."\" method=\"post\">";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=0&ssop=3&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
						$sql = "select id,nombre from sgm_clients where visible=1 and id=".$rowcc["id_cliente"]."";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						$row = mysqli_fetch_array($result);
						echo "<td><a href=\"index.php?op=1009&sop=210&id=".$row["id"]."\">".$row["nombre"]."</a></td>";
						$sqlf = "select id,nombre from sgm_clients where visible=1 and id=".$rowcc["id_cliente_final"]."";
						$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
						$rowf = mysqli_fetch_array($resultf);
						echo "<td><a href=\"index.php?op=1009&sop=210&id=".$rowf["id"]."\">".$rowf["nombre"]."</a></td>";
						echo "<td><a href=\"index.php?op=1009&sop=100&id=".$rowcc["id"]."\">".$rowcc["descripcion"]."</a></td>";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=10&id=".$rowcc["id"]."\" method=\"post\">";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
					echo "</form>";
				if ($rowcc["aceptada"] == 0){
					echo "<form action=\"index.php?op=1009&sop=0&ssop=2&id=".$rowcc["id"].$adresa."\" method=\"post\">";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Aprobar."\"></td>";
					echo "</form>";
				} else {
					echo "<form action=\"index.php?op=1009&sop=0&ssop=3&id=".$rowcc["id"].$adresa."\" method=\"post\">";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Desaprobar."\"></td>";
					echo "</form>";
				}
				if ($rowcc["cerrada"] == 0){
					echo "<form action=\"index.php?op=1009&sop=5&id=".$rowcc["id"].$adresa."\" method=\"post\">";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Cerrar."\"></td>";
					echo "</form>";
				} else {
					echo "<form action=\"index.php?op=1009&sop=0&ssop=5&id=".$rowcc["id"].$adresa."\" method=\"post\">";
						echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Abrir."\"></td>";
					echo "</form>";
				}
					echo "</tr>";
				}
			echo "</table>";
			echo "</center>";
		}
	}


	if ($soption == 5) {
		if ($_GET["hist"] == 1) { $adresa = "&hist=".$_GET["hist"];}
		echo "<center>";
		echo "<br><br>".$ayudaFacturaCerrar;
		echo boton(array("op=1009&sop=0&ssop=4&id=".$_GET["id"].$adresa,"op=1009&sop=0".$adresa),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 10) {
		echo "<h4>".$Impresion." ".$Documentos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Tipo."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form method=\"post\" action=\"".$urlmgestion."/mgestion/gestion-comercial-ofertas-print-pdf.php?id=".$_GET["id"]."\" target=\"_blank\">";
				echo "<td><select name=\"tipo\" style=\"width:100px\">";
					echo "<option value=\"0\">".$Normal."</option>";
					echo "<option value=\"1\">".$Extendido."</option>";
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imprimir."\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

#Mascara superior del contrato
	if (($soption >= 100) and ($soption < 200) and (($_GET["id"] != 0) or ($ssoption != 0))) {
		if (($soption == 100) and ($ssoption == 2)) {
			$sqlc = "select * from sim_comercial_oferta where visible=1 and id=".$_GET["id"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			echo $rowc["id_plantilla"]."- -".$_POST["id_plantilla"];
			if ($rowc["id_plantilla"] != $_POST["id_plantilla"]){
				$sqlco = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
				$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
				while ($rowco = mysqli_fetch_array($resultco)) {
					deleteFunction ("sim_comercial_oferta_rel_contenido",$rowco["id"]);
				}
				echo $sqlco2 = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_POST["id_plantilla"]." order by orden";
				$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
				while ($rowco2 = mysqli_fetch_array($resultco2)) {
					$camposInsert="orden,id_comercial_contenido,id_comercial_oferta";
					$datosInsert=array($rowco2["orden"],$rowco2["id_comercial_contenido"],$_GET["id"]);
					insertFunction("sim_comercial_oferta_rel_contenido",$camposInsert,$datosInsert);
				}
			}

			$camposUpdate=array('numero','version','fecha','id_cliente','id_cliente_final','descripcion','id_plantilla','id_idioma','id_autor','num_dispositivos','num_servicios','id_tipo_servidor','id_software','socio_tecnologico');
			$datosUpdate=array($_POST["numero"],$_POST["version"],$_POST["fecha"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["descripcion"],$_POST["id_plantilla"],$_POST["id_idioma"],$_POST["id_autor"],$_POST["num_dispositivos"],$_POST["num_servicios"],$_POST["id_tipo_servidor"],$_POST["id_software"],$_POST["socio_tecnologico"]);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);

			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 order by servicio";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlcs = "select id from sim_comercial_oferta_rel_servicios where id_servicio=".$row["id"]." and id_comercial_oferta=".$_GET["id"];
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				$rowcs = mysqli_fetch_array($resultcs);
				if((($_POST["servicios".$row["id"]] == 1) or ($row["obligatorio"] == 1)) and (!$rowcs["id"])){
					$camposInsert="id_comercial_oferta,id_servicio";
					$datosInsert=array($_GET["id"],$row["id"]);
					insertFunction("sim_comercial_oferta_rel_servicios",$camposInsert,$datosInsert);
				} elseif((($_POST["servicios".$row["id"]] == 0) and ($row["obligatorio"] == 0)) and ($rowcs["id"])) {
					deleteFunction ("sim_comercial_oferta_rel_servicios",$rowcs["id"]);
				}
			}
		}
		if (($soption == 100) and ($ssoption == 3)) {
			deleteFunction ("sim_comercial_oferta",$_GET["id"]);
		}
		if (($soption == 100) and ($ssoption == 7)) {
			$sqlcov = "select id from sim_comercial_oferta_valors where visible=1 and id_comercial_oferta=".$_GET["id"]." and id_comercial_camps=".$_GET["id_cam"].")";
			$resultcov = mysqli_query($dbhandle,convertSQL($sqlcov));
			$rowcov = mysqli_fetch_array($resultcov);
			if ($rowcov){
				$camposUpdate=array('id_comercial_camps_valor');
				$datosUpdate=array($_POST["id_comercial_camps_valor"]);
				updateFunction("sim_comercial_oferta_valors",$rowcov["id"],$camposUpdate,$datosUpdate);
			} else {
				$camposInsert="id_comercial_oferta,id_comercial_camps,id_comercial_camps_valor";
				$datosInsert=array($_GET["id"],$_GET["id_cam"],$_POST["id_comercial_camps_valor"]);
				insertFunction("sim_comercial_oferta_valors",$camposInsert,$datosInsert);
			}
		}

		$sqlc = "select * from sim_comercial_oferta where visible=1 and id=".$_GET["id"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);

		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"vertical-align:top\">";
					echo "<table cellpadding=\"0\">";
						echo "<tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1009&sop=100&id=".$rowc["id"]."\" style=\"color:white;\">".$Datos." ".$Oferta."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1009&sop=130&id=".$rowc["id"]."\" style=\"color:white;\">".$Contenidos." ".$Especificos."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1009&sop=110&id=".$rowc["id"]."\" style=\"color:white;\">".$Contenidos." ".$Genericos."</a></td>";
						echo "<tr></tr>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1009&sop=120&id=".$rowc["id"]."\" style=\"color:white;\">".$Valoraciones."</a></td>";
							echo "<td class=\"ficha\"><a href=\"index.php?op=1009&sop=140&id=".$rowc["id"]."\" style=\"color:white;\">".$Comentarios."</a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"vertical-align : top;background-color : Silver; margin : 5px 10px 10px 10px;width:500px;padding : 5px 10px 10px 10px;\">";
					echo "<a href=\"index.php?op=1009&sop=100&id=".$rowc["id"]."\" style=\"color:black;\"><strong style=\"font : bold normal normal 20px/normal Verdana, Geneva, Arial, Helvetica, sans-serif;color:black\">".$rowc["descripcion"]."</strong></a>";
					$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
					$resulta = mysqli_query($dbhandle,convertSQL($sqla));
					$rowa = mysqli_fetch_array($resulta);
					$sqla2 = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente_final"];
					$resulta2 = mysqli_query($dbhandle,convertSQL($sqla2));
					$rowa2 = mysqli_fetch_array($resulta2);
					echo "<br>".$Cliente.": <a href=\"index.php?op=1009&sop=140&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a>";
					echo "<br>".$Cliente." ".$Final.": <a href=\"index.php?op=1009&sop=140&id=".$rowa2["id"]."\">".$rowa2["nombre"]." ".$rowa2["cognom1"]." ".$rowa2["cognom2"]."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";
	}

	if ($soption == 100) {
		if ($_GET["id"] != "") {
				echo "<form action=\"index.php?op=1009&sop=100&ssop=2&id=".$_GET["id"]."\" method=\"post\">";
				$numeroo = $rowc["numero"];
				$versiono = $rowc["version"];
				$date1 = $rowc["fecha"];
		} else {
				echo "<form action=\"index.php?op=1009&sop=0&ssop=1\" method=\"post\">";
				$numeroo = 0;
				$sqln = "select numero from sim_comercial_oferta where visible=1 and id_plantilla<>0 order by numero desc";
				$resultn = mysqli_query($dbhandle,convertSQL($sqln));
				$rown = mysqli_fetch_array($resultn);
				$numeroo = ($rown["numero"]+ 1);
				$versiono = 1;
				$date1 = date("Y-m-d");
		}

		echo "<h4>".$Datos_Generales."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr><td style=\"text-align:right;\">".$Numero."/".$Version.": </td><td><input style=\"width:100px\" type=\"Text\" name=\"numero\" value=\"".$numeroo."\"> / <input style=\"width:50px\" type=\"Text\" name=\"version\" value=\"".$versiono."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Fecha.": </td><td><input style=\"width:100px\" type=\"datetime\" name=\"fecha\" value=\"".$date1."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Socio_tecnologico.": </td>";
				echo "<td><select style=\"width:100px\" name=\"socio_tecnologico\">";
					if ($rowc["socio_tecnologico"] == 0){
						echo "<option value=\"0\" selected>".$No."</option>";
						echo "<option value=\"1\">".$Si."</option>";
					} else {
						echo "<option value=\"0\">".$No."</option>";
						echo "<option value=\"1\" selected>".$Si."</option>";
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Idioma.": </td>";
				echo "<td><select style=\"width:100px\" name=\"id_idioma\">";
					$sqlb = "select id,idioma from sgm_idiomas where visible=1 order by predefinido desc,idioma";
					$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
					while ($rowb = mysqli_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_idioma"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["idioma"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["idioma"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Autor.": </td>";
				echo "<td><select style=\"width:200px\" name=\"id_autor\">";
						$sql1 = "select id,usuario from sgm_users where sgm=1 order by usuario";
						$result1 = mysqli_query($dbhandle,convertSQL($sql1));
						while ($row1 = mysqli_fetch_array($result1)) {
						if ($row1["id"] == $rowc["id_autor"]){
							echo "<option value=\"".$row1["id"]."\" selected>".$row1["usuario"]."</option>";
						} else {
							echo "<option value=\"".$row1["id"]."\">".$row1["usuario"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">".$Descripcion.": </td><td><input style=\"width:200px\" type=\"Text\" name=\"descripcion\" value=\"".$rowc["descripcion"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Plantilla.": </td>";
				echo "<td><select style=\"width:550px\" name=\"id_plantilla\">";
					$sqlcc = "select id,descripcion from sim_comercial_oferta where visible=1 and id_plantilla=0 and versionado=0";
					$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
					while ($rowcc = mysqli_fetch_array($resultcc)) {
						if ($rowcc["id"] == $rowc["id_plantilla"]){
							echo "<option value=\"".$rowcc["id"]."\" selected>".$rowcc["descripcion"]."</option>";
						} else {
							echo "<option value=\"".$rowcc["id"]."\">".$rowcc["descripcion"]."</option>";
						}
					}
				echo "</td>";
			echo "<tr>";
			echo "<tr><td style=\"text-align:right;\">".$Cliente.": </td>";
				echo "<td><select style=\"width:550px\" name=\"id_cliente\">";
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
				echo "<td><select style=\"width:550px\" name=\"id_cliente_final\">";
					echo "<option value=\"0\">-</option>";
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
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Dispositivos.": </td><td><input style=\"width:200px\" type=\"number\" name=\"num_dispositivos\" value=\"".$rowc["num_dispositivos"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Numero." ".$Servicios.": </td><td><input style=\"width:200px\" type=\"number\" name=\"num_servicios\" value=\"".$rowc["num_servicios"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;\">".$Tipo." ".$Servidor.": </td>";
				echo "<td><select style=\"width:200px\" name=\"id_tipo_servidor\">";
					echo "<option value=\"0\">-</option>";
					$sqlcts = "select * from sim_comercial_tipos_servidores where visible=1 order by tipo_servidor";
					$resultcts = mysqli_query($dbhandle,convertSQL($sqlcts));
					while ($rowcts = mysqli_fetch_array($resultcts)) {
						if ($rowcts["id"] == $rowc["id_tipo_servidor"]){
							echo "<option value=\"".$rowcts["id"]."\" selected>".$rowcts["tipo_servidor"]."</option>";
						} else {
							echo "<option value=\"".$rowcts["id"]."\">".$rowcts["tipo_servidor"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td style=\"text-align:right;\">Software: </td>";
				echo "<td><select style=\"width:200px\" name=\"id_software\">";
					echo "<option value=\"0\">-</option>";
					$sqlb = "select * from sim_comercial_software where visible=1 order by software";
					$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
					while ($rowb = mysqli_fetch_array($resultb)) {
						if ($rowb["id"] == $rowc["id_software"]){
							echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["software"]."</option>";
						} else {
							echo "<option value=\"".$rowb["id"]."\">".$rowb["software"]."</option>";
						}
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=0 order by servicio";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				$sqlcs = "select id from sim_comercial_oferta_rel_servicios where id_servicio=".$row["id"]." and id_comercial_oferta=".$rowc["id"];
				$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
				$rowcs = mysqli_fetch_array($resultcs);
				echo "<tr>";
					echo "<td style=\"color:black;text-align:right;\"><input type=\"Checkbox\" name=\"servicios".$row["id"]."\" value=\"1\"";
					if (($row["obligatorio"] == 1) or ($rowcs["id"])){ echo "checked";}
					if ($row["obligatorio"] == 1) { echo " disabled";}
					echo "></td>";
					echo "<td>".$row["servicio"]."</td>";
				echo "</tr>";
			}
			echo "<tr>";
				if ($_GET["id"] != "") {
					echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
				} else {
					echo "<td></td><td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				}
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 110) {
		if ($ssoption == 1) {
			$camposInsert="orden,id_comercial_contenido,id_comercial_oferta";
			$datosInsert=array($_POST["orden"],$_POST["id_contenido"],$_GET["id"]);
			insertFunction("sim_comercial_oferta_rel_contenido",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('orden','id_comercial_contenido');
			$datosUpdate=array($_POST["orden"],$_POST["id_contenido"]);
			updateFunction("sim_comercial_oferta_rel_contenido",$_GET["id_con"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction("sim_comercial_oferta_rel_contenido",$_GET["id_con"]);
		}
		echo "<h4>".$Contenidos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Orden."</th>";
				echo "<th>".$Contenido."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1009&sop=110&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td style=\"text-align:right;\"><input type=\"Text\" name=\"orden\" value=\"0\" style=\"width:50px\"></td>";
				echo "<td><select style=\"width:450px\" name=\"id_contenido\">";
					echo "<option value=\"0\">-</option>";
					$sqlg = "select id,titulo from sim_comercial_contenido where visible=1 and versionado=0 and id_idioma=".$rowc["id_idioma"];
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)){
						echo "<option value=\"".$rowg["id"]."\">".$rowg["titulo"]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlco = "select id,orden,id_comercial_contenido from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				echo "<form action=\"index.php?op=1009&sop=110&ssop=2&id=".$_GET["id"]."&id_con=".$rowco["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1009&sop=111&id=".$_GET["id"]."&id_con=".$rowco["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td style=\"text-align:right;width:50px;\"><input type=\"Text\" name=\"orden\" value=\"".$rowco["orden"]."\" style=\"width:50px\"></td>";
					echo "<td><select style=\"width:450px\" name=\"id_contenido\">";
						$sqls = "select id,titulo from sim_comercial_contenido where visible=1";
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						while ($rows = mysqli_fetch_array($results)){
							if ($rows["id"] == $rowco["id_comercial_contenido"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rows["titulo"]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rows["titulo"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</tr>";
				echo "</form>";
			}
		echo "</table>";
	}

	if ($soption == 111) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=110&ssop=3&id=".$_GET["id"]."&id_con=".$_GET["id_con"],"op=1009&sop=110&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 120) {
		if ($ssoption == 1){
			$camposInsert = "id_comercial_oferta,descripcion,descuento";
			$datosInsert = array($_GET["id"],comillas($_POST["descripcion"]),$_POST["descuento"]);
			insertFunction ("sim_comercial_oferta_valoracion",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("descripcion","descuento");
			$datosUpdate = array(comillas($_POST["descripcion"]),$_POST["descuento"]);
			updateFunction ("sim_comercial_oferta_valoracion",$_GET["id_val"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction("sim_comercial_oferta_valoracion",$_GET["id_val"]);
		}
		if ($ssoption == 4) {
			$sql = "select id from sim_comercial_oferta_valoracion where id_comercial_oferta=".$_GET["id"]." order by descripcion";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$camposUpdate=array('aceptada');
				$datosUpdate=array(0);
				updateFunction("sim_comercial_oferta_valoracion",$row["id"],$camposUpdate,$datosUpdate);
			}
			$camposUpdate=array('aceptada');
			$datosUpdate=array(1);
			updateFunction("sim_comercial_oferta_valoracion",$_GET["id_val"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$camposUpdate=array('aceptada');
			$datosUpdate=array(0);
			updateFunction("sim_comercial_oferta_valoracion",$_GET["id_val"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 6){
			$sql = "select id,descripcion,descuento,total from sim_comercial_oferta_valoracion where id_comercial_oferta=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposInsert = "id_comercial_oferta,descripcion,descuento,total";
			$datosInsert = array($_GET["id"],comillas($row["descripcion"]),$row["descuento"],$row["total"]);
			insertFunction ("sim_comercial_oferta_valoracion",$camposInsert,$datosInsert);

			$sqlc = "select id from sim_comercial_oferta_valoracion where descripcion='".$row["descripcion"]."' and id<>".$row["id"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$sqlco = "select id_articulo,unidades,pvp from sim_comercial_oferta_valoracion_rel_articulos where id_comercial_oferta_valoracion=".$row["id"];
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				$camposInsert = "id_comercial_oferta_valoracion,id_articulo,unidades,pvp";
				$datosInsert = array($rowc["id"],$rowco["id_articulo"],$rowco["unidades"],$rowco["pvp"]);
				insertFunction ("sim_comercial_oferta_valoracion_rel_articulos",$camposInsert,$datosInsert);
			}
		}

		echo "<h4>".$Valoraciones."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th style=\"width:50px;text-align:right;\">".$Eliminar."</th>";
				echo "<th style=\"width:300px;text-align:left;\">".$Descripcion."</th>";
				echo "<th style=\"width:50px;text-align:left;\">".$Descuento."</th>";
				echo "<th style=\"width:100px;text-align:left;\">".$Total."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1009&sop=120&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\"></td>";
				echo "<td><input type=\"Number\" name=\"descuento\" min=\"0\"></td>";
				echo "<td></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_comercial_oferta_valoracion where id_comercial_oferta=".$_GET["id"]." order by descripcion";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				if ($row["aceptada"] == 1){$color = $color_verde;} else {$color = "white";}
				echo "<tr style=\"background-color:".$color.";\">";
					echo "<form action=\"index.php?op=1009&sop=120&ssop=2&id=".$_GET["id"]."&id_val=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=121&id=".$_GET["id"]."&id_val=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" value=\"".$row["descripcion"]."\"></td>";
					echo "<td><input type=\"Number\" name=\"descuento\" value=\"".$row["descuento"]."\" step=\"0.00\" min=\"0\"></td>";
					$total_valoracion = $row["total"] - (($row["total"]*$row["descuento"])/100);
					$sqld = "select abrev from sgm_divisas where predefinido=1";
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					echo "<td style=\"text-align:right\">".number_format($total_valoracion,2,'.','')." ".$rowd["abrev"]."</td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=122&id=".$_GET["id"]."&id_val=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
				if ($row["aceptada"] == 0){
					echo "<form action=\"index.php?op=1009&sop=120&ssop=4&id=".$_GET["id"]."&id_val=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Aprobar."\"></td>";
					echo "</form>";
				} else {
					echo "<form action=\"index.php?op=1009&sop=120&ssop=5&id=".$_GET["id"]."&id_val=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Desaprobar."\"></td>";
					echo "</form>";
				}
					echo "<form action=\"index.php?op=1009&sop=120&ssop=6&id=".$_GET["id"]."&id_val=".$row["id"]."\" method=\"post\">";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Duplicar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 121) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=120&ssop=3&id=".$_GET["id"]."&id_val=".$_GET["id_val"],"op=1009&sop=120&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 122) {
		if ($ssoption == 1){
			$sql = "select pvp from sgm_stock where vigente=1 and id_article=".$_POST["id_articulo"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			$camposInsert = "id_comercial_oferta_valoracion,id_articulo,unidades,pvp";
			$datosInsert = array($_GET["id_val"],$_POST["id_articulo"],$_POST["unidades"],$row["pvp"]);
			insertFunction ("sim_comercial_oferta_valoracion_rel_articulos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("id_articulo","unidades","pvp");
			$datosUpdate = array($_POST["id_articulo"],$_POST["unidades"],$_POST["pvp"]);
			updateFunction ("sim_comercial_oferta_valoracion_rel_articulos",$_GET["id_art"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction("sim_comercial_oferta_valoracion_rel_articulos",$_GET["id_art"]);
		}
		if ($ssoption > 0){
			$total_val=0;
			$sqlco = "select id_articulo,unidades,pvp from sim_comercial_oferta_valoracion_rel_articulos where id_comercial_oferta_valoracion=".$_GET["id_val"];
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				$total_art = $rowco["pvp"] * $rowco["unidades"];
				$total_val += $total_art;
			}
			$camposUpdate = array("total");
			$datosUpdate = array($total_val);
			updateFunction ("sim_comercial_oferta_valoracion",$_GET["id_val"],$camposUpdate,$datosUpdate);
		}

		echo boton(array("op=1009&sop=120&id=".$_GET["id"]),array("&laquo; ".$Volver));
		echo "<h4>".$Articulos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Articulo."</th>";
				echo "<th>".$Unidades."</th>";
				echo "<th>".$PVP."</th>";
				echo "<th>".$Total."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1009&sop=122&ssop=1&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."\" method=\"post\">";
				echo "<td><select style=\"width:450px\" name=\"id_articulo\">";
					echo "<option value=\"0\">-</option>";
					$sqlg = "select id,nombre from sgm_articles where visible=1";
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)){
						echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td style=\"text-align:right;\"><input type=\"number\" name=\"unidades\" min=\"0\" style=\"width:50px\"></td>";
				echo "<td style=\"text-align:right;width:50px\"></td>";
				echo "<td></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$total_val=0;
			$sqlco = "select * from sim_comercial_oferta_valoracion_rel_articulos where id_comercial_oferta_valoracion=".$_GET["id_val"];
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				echo "<form action=\"index.php?op=1009&sop=122&ssop=2&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."&id_art=".$rowco["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1009&sop=123&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."&id_art=".$rowco["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td><select style=\"width:450px\" name=\"id_articulo\">";
						$sqls = "select id,nombre from sgm_articles where visible=1";
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						while ($rows = mysqli_fetch_array($results)){
							if ($rows["id"] == $rowco["id_articulo"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rows["nombre"]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rows["nombre"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td style=\"text-align:right;width:50px;\"><input type=\"number\" name=\"unidades\" value=\"".$rowco["unidades"]."\" min=\"0\" style=\"width:50px\"></td>";
					echo "<td style=\"text-align:right;width:50px;\"><input type=\"number\" name=\"pvp\" value=\"".number_format($rowco["pvp"],2,'.','')."\" step=\"0.01\" style=\"width:50px\"></td>";
					$sql = "select pvp,id_divisa_pvp from sgm_stock where vigente=1 and id_article=".$rowco["id_articulo"];
					$result = mysqli_query($dbhandle,convertSQL($sql));
					$row = mysqli_fetch_array($result);
					$sqld = "select abrev from sgm_divisas where id=".$row["id_divisa_pvp"];
					$resultd = mysqli_query($dbhandle,convertSQL($sqld));
					$rowd = mysqli_fetch_array($resultd);
					$total_art = $rowco["pvp"] * $rowco["unidades"];
					$total_val += $total_art;
					echo "<td style=\"width:100px;text-align:right\">".number_format($total_art,2,'.','')." ".$rowd["abrev"]."</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</tr>";
				echo "</form>";
			}
			echo "<tr><td colspan=\"3\"></td><td>".$Total."</td><td style=\"width:100px;text-align:right\">".number_format($total_val,2,'.','')." ".$rowd["abrev"]."</td></tr>";
		echo "</table>";
	}
	
	if ($soption == 123) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=122&ssop=3&id=".$_GET["id"]."&id_val=".$_GET["id_val"]."&id_art=".$_GET["id_art"],"op=1009&sop=122&id=".$_GET["id"]."&id_val=".$_GET["id_val"]),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 130) {
		if ($ssoption == 1) {
			$sqlci = "select id,contenido from sim_comercial_contenido where visible=1 and editable=1";
			$resultci = mysqli_query($dbhandle,convertSQL($sqlci));
			while ($rowci = mysqli_fetch_array($resultci)){
				$sqlcc = "select id,contenido from sim_comercial_contenido where visible=1 and id_comercial_contenido=".$rowci["id"]." and id_comercial_oferta=".$_GET["id"];
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				$rowcc = mysqli_fetch_array($resultcc);
				if (($_POST["contenido".$rowci["id"]] != '') and ($rowcc["id"])){
					$camposUpdate=array('contenido');
					$datosUpdate=array(comillas($_POST["contenido".$rowci["id"]]));
					updateFunction("sim_comercial_contenido",$rowcc["id"],$camposUpdate,$datosUpdate);
				} elseif (($_POST["contenido".$rowci["id"]] != '') and (!$rowcc["id"])) {
					$camposInsert="id_comercial_oferta,contenido,id_comercial_contenido";
					$datosInsert=array($_GET["id"],comillas($_POST["contenido".$rowci["id"]]),$rowci["id"]);
					insertFunction("sim_comercial_contenido",$camposInsert,$datosInsert);
				}
			}
		}

		echo "<h4>".$Contenidos." ".$Especificos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1009&sop=130&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			$sqlci = "select id,titulo,contenido from sim_comercial_contenido where visible=1 and editable=1 where id in (select id_comercial_contenido from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"].")";
			$resultci = mysqli_query($dbhandle,convertSQL($sqlci));
			while ($rowci = mysqli_fetch_array($resultci)){
				$sqlcc = "select contenido from sim_comercial_oferta_rel_contenido where visible=1 and id_comercial_contenido=".$rowci["id"]." and id_comercial_oferta=".$_GET["id"];
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				$rowcc = mysqli_fetch_array($resultcc);
				if ($rowcc){ $content = $rowcc["contenido"]; } else { $content = $rowci["contenido"]; }
				echo "<tr>";
					echo "<td style=\"text-align:right;vertical-align:top;\">".$rowci["titulo"]." : </td><td><textarea name=\"contenido".$rowci["id"]."\" class=\"contenidos\" style=\"width:900px\" rows=\"10\">".$content."</textarea></td>";
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}


	if ($soption == 140) {
		if ($ssoption == 1) {
			$camposInsert="id_comercial_oferta,comentario,fecha,id_usuario";
			$datosInsert=array($_GET["id"],comillas($_POST["comentario"]),$_POST["fecha"],$userid);
			insertFunction("sim_comercial_oferta_comentarios",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('comentario','fecha');
			$datosUpdate=array(comillas($_POST["comentario"]),$_POST["fecha"]);
			updateFunction("sim_comercial_oferta_comentarios",$_GET["id_com"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_comercial_oferta_comentarios",$_GET["id_com"],$camposUpdate,$datosUpdate);
		}
		echo "<h4>".$Comentarios."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=1009&sop=140&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"text-align:left;vertical-align:top;width:30%;\">";
					echo "<table cellspacing=\"0\" style=\"width:100%;\">";
						echo "<tr>";
							echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Registro." :</th>";
							echo "<td><input type=\"text\" name=\"fecha\" style=\"width:150px\" value=\"".date("Y-m-d H:i:s")."\"></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				echo "<td style=\"text-align:left;vertical-align:top;width:70%;\"><textarea name=\"comentario\" style=\"width:100%;\" rows=\"4\">".$comentario."</textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td><td><input type=\"Submit\" value=\"".$Guardar."\" style=\"width:100px\"></td>";
			echo "</tr>";
			echo "</form>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_comercial_oferta_comentarios where id_comercial_oferta=".$_GET["id"]." order by fecha desc";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				$sqlu = "select id,usuario from sgm_users where validado=1 and activo=1 and sgm=1 and id=".$row["id_usuario"];
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);
				echo "<form action=\"index.php?op=1009&sop=140&ssop=2&id=".$_GET["id"]."&id_com=".$row["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td style=\"text-align:left;vertical-align:top;width:30%;\">";
						echo "<table cellspacing=\"0\" style=\"width:100%;\">";
							echo "<tr>";
								echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Fecha." ".$Registro." :</th>";
								echo "<td><input type=\"text\" name=\"fecha\" style=\"width:150px\" value=\"".$row["fecha"]."\"></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<th style=\"text-align:right;vertical-align:top;width:150px\">".$Usuario." :</th>";
								echo "<td style=\"width:150px\">".$rowu["usuario"]."</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
					echo "<td style=\"text-align:left;vertical-align:top;width:70%;\"><textarea name=\"comentario\" style=\"width:100%;\" rows=\"4\">".$row["comentario"]."</textarea></td>";
				echo "</tr>";
				if ($rowu["id"] == $userid){
					echo "<tr>";
						echo "<td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
					echo "</tr>";
					echo "</form>";
				}
			}
		echo "</table>";
	}

	if ($soption == 500) {
		if ($admin == true) {
			$ruta_botons = array("op=1009&sop=510","op=1009&sop=520","op=1009&sop=530","op=1009&sop=540");
			$texto = array($Contenidos,$Tipos." ".$Servidores,$Plantillas,"Software");
			echo boton($ruta_botons,$texto);
		}
		if ($admin == false) {
			echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";
		}
	}

	if ($soption == 510) {
		if ($ssoption == 1) {
			$camposInsert="id_comercial_contenido,titulo,id_idioma,obligatorio,id_servicio,editable";
			$datosInsert=array($_POST["id_comercial_contenido"],comillas($_POST["titulo"]),$_POST["id_idioma"],$_POST["obligatorio"],$_POST["id_servicio"],$_POST["editable"]);
			insertFunction("sim_comercial_contenido",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('id_comercial_contenido','titulo','id_idioma','obligatorio','id_servicio','editable');
			$datosUpdate=array($_POST["id_comercial_contenido"],comillas($_POST["titulo"]),$_POST["id_idioma"],$_POST["obligatorio"],$_POST["id_servicio"],$_POST["editable"]);
			updateFunction("sim_comercial_contenido",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_comercial_contenido",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 4) {
			$sqlco = "select * from sim_comercial_contenido where visible=1 and id=".$_GET["id"];
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			$rowco = mysqli_fetch_array($resultco);

			$sqlco2 = "select version from sim_comercial_contenido where visible=1 and id_comercial_contenido=".$rowco["id"]." order by version desc";
			$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
			$rowco2 = mysqli_fetch_array($resultco2);
			if ($rowco2) { $version = $rowco2["version"]+1; } else { $version = $rowco["version"]+1; }
			
			$camposInsert="id_comercial_contenido,titulo,version,contenido,contenido_extenso,id_idioma,obligatorio,id_servicio,editable";
			$datosInsert=array($_GET["id"],$rowco["titulo"],$version,$rowco["contenido"],$rowco["contenido_extenso"],$rowco["id_idioma"],$rowco["obligatorio"],$rowco["id_servicio"],$rowco["editable"]);
			insertFunction("sim_comercial_contenido",$camposInsert,$datosInsert);

			$camposUpdate=array('versionado');
			$datosUpdate=array(1);
			updateFunction("sim_comercial_contenido",$_GET["id"],$camposUpdate,$datosUpdate);
		}


		echo "<h4>".$Contenidos." :</h4>";
		echo boton(array("op=1009&sop=500"),array("&laquo; ".$Volver));
		if ($_GET["ver"] == 0) { echo boton(array("op=1009&sop=510&ver=1"),array($Versiones_anteriores)); }
		if ($_GET["ver"] == 1) { echo boton(array("op=1009&sop=510"),array($Versiones_actuales)); }
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Version."</th>";
				echo "<th>".$Titulo."</th>";
				echo "<th>".$Idioma."</th>";
				echo "<th>".$Obligatorio."</th>";
				echo "<th>".$Editable."</th>";
				echo "<th>".$Servicio."</th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=510&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:300px\" name=\"titulo\"></td>";
				echo "<td><select style=\"width:50px\" name=\"id_idioma\">";
					$sql = "select id,idioma from sgm_idiomas where visible=1 order by idioma";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)){
						echo "<option value=\"".$row["id"]."\">".$row["idioma"]."</option>";
					}
				echo "</td>";
				echo "<td><select style=\"width:60px\" name=\"obligatorio\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</td>";
				echo "<td><select style=\"width:60px\" name=\"editable\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</td>";
				echo "<td><select style=\"width:300px\" name=\"id_servicio\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=0 order by servicio";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)){
						echo "<option value=\"".$row["id"]."\">".$row["servicio"]."</option>";
					}
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlci = "select * from sim_comercial_contenido where visible=1";
			if ($_GET["ver"] == 0) { $sqlci .= " and versionado=0";}
			$resultci = mysqli_query($dbhandle,convertSQL($sqlci));
			while ($rowci = mysqli_fetch_array($resultci)){
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=511&id=".$rowci["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1009&sop=510&ssop=2&id=".$rowci["id"]."\" method=\"post\">";
					echo "<td><input style=\"width:50px\" type=\"Text\" name=\"version\" value=\"".$rowci["version"]."\"></td>";
					echo "<td><input type=\"text\" style=\"width:300px\" name=\"titulo\" value=\"".$rowci["titulo"]."\"></td>";
					echo "<td><select style=\"width:50px\" name=\"id_idioma\">";
						$sql = "select id,idioma from sgm_idiomas where visible=1 order by idioma";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)){
							if ($row["id"] == $rowci["id_idioma"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["idioma"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["idioma"]."</option>";
							}
						}
					echo "</td>";
					echo "<td><select style=\"width:60px\" name=\"obligatorio\">";
						if ($rowci["obligatorio"] == 0){
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						} elseif ($rowci["obligatorio"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</td>";
					echo "<td><select style=\"width:60px\" name=\"editable\">";
						if ($rowci["editable"] == 0){
							echo "<option value=\"0\" selected>".$No."</option>";
							echo "<option value=\"1\">".$Si."</option>";
						} elseif ($rowci["editable"] == 1) {
							echo "<option value=\"0\">".$No."</option>";
							echo "<option value=\"1\" selected>".$Si."</option>";
						}
					echo "</td>";
					echo "<td><select style=\"width:300px\" name=\"id_servicio\">";
						echo "<option value=\"0\" selected>-</option>";
						$sql = "select id,servicio from sgm_contratos_servicio where visible=1 and id_contrato=0 order by servicio";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)){
							if ($row["id"] == $rowci["id_servicio"]){
								echo "<option value=\"".$row["id"]."\" selected>".$row["servicio"]."</option>";
							} else {
								echo "<option value=\"".$row["id"]."\">".$row["servicio"]."</option>";
							}
						}
					echo "</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=515&id=".$rowci["id"]."\" method=\"post\">";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=516&id=".$rowci["id"]."\" method=\"post\">";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Imagenes."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=512&id=".$rowci["id"]."\" method=\"post\">";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Versionar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 511) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=510&ssop=3&id=".$_GET["id"],"op=1009&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 512) {
		echo "<center>";
		echo "<br><br>".$pregunta_versionar;
		echo boton(array("op=1009&sop=510&ssop=4&id=".$_GET["id"],"op=1009&sop=510"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 515) {
		if ($ssoption == 1) {
			$camposUpdate=array('contenido','contenido_extenso');
#			$datosUpdate=array(comillas($_POST["contenido"]),comillas($_POST["contenido_extenso"]));
			$datosUpdate=array($_POST['contenido'],$_POST['contenido_extenso']);
			updateFunction("sim_comercial_contenido",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Texto_Contenidos." :</h4>";
		echo boton(array("op=1009&sop=510"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$sql = "select titulo,contenido,contenido_extenso from sim_comercial_contenido where id=".$_GET["id"];
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			echo "<form action=\"index.php?op=1009&sop=515&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
			echo "<tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\">".$Titulo." : </td><td>".$row["titulo"]."</td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\">".$Contenido." : </td><td><textarea name=\"contenido\" class=\"contenidos\" style=\"width:900px\" rows=\"10\">".$row["contenido"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td style=\"text-align:right;vertical-align:top;\">".$Contenido_Estendido." : </td><td><textarea name=\"contenido_extenso\" class=\"contenidos\" style=\"width:900px\" rows=\"10\">".$row["contenido_extenso"]."</textarea></td>";
			echo "</tr><tr>";
				echo "<td></td><td><input type=\"Submit\" value=\"".$Editar."\" style=\"width:100px\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if (($soption == 516) AND ($admin == true)){
		echo anadirArchivo($_GET["id"],7,'');
	}

	if (($soption == 517) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=516&ssop=2&id=".$_GET["id"]."&id_archivo=".$_GET["id_archivo"],"op=1009&sop=516&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 520) and ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "tipo_servidor";
			$datosInsert = array($_POST["tipo_servidor"]);
			insertFunction ("sim_comercial_tipos_servidores",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("tipo_servidor");
			$datosUpdate = array($_POST["tipo_servidor"]);
			updateFunction ("sim_comercial_tipos_servidores",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sim_comercial_tipos_servidores",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Tipos." ".$Servidores."</h4>";
		echo boton(array("op=1009&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Tipo." ".$Servidor."</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=520&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"tipo_servidor\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_comercial_tipos_servidores where visible=1 order by tipo_servidor";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=521&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1009&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["tipo_servidor"]."\" style=\"width:150px\" name=\"tipo_servidor\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 521) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=520&ssop=3&id=".$_GET["id"],"op=1009&sop=520"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 530) {
		if ($ssoption == 1){
			$camposInsert="numero,version,fecha,descripcion,id_idioma";
			$datosInsert=array($_POST["numero"],$_POST["version"],date("Y-m-d"),$_POST["descripcion"],$_POST["id_idioma"]);
			insertFunction("sim_comercial_oferta",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate=array('numero','version','descripcion','id_idioma');
			$datosUpdate=array($_POST["numero"],$_POST["version"],$_POST["descripcion"],$_POST["id_idioma"]);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction("sim_comercial_oferta_valoracion",$_GET["id_val"]);
		}
		if ($ssoption == 4) {
			$sqlco = "select * from sim_comercial_oferta where visible=1 and id=".$_GET["id"];
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			$rowco = mysqli_fetch_array($resultco);

			$sqlco2 = "select version from sim_comercial_oferta where visible=1 and id_plantilla=0 and numero=".$rowco["numero"]." order by version desc";
			$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
			$rowco2 = mysqli_fetch_array($resultco2);
			$version = $rowco2["version"]+1;

			$camposInsert="numero,version,fecha,descripcion,id_idioma";
			$datosInsert=array($rowco["numero"],$version,$rowco["fecha"],$rowco["descripcion"],$rowco["id_idioma"]);
			insertFunction("sim_comercial_oferta",$camposInsert,$datosInsert);

			$sqlcc = "select id from sim_comercial_oferta where visible=1 and id_plantilla=0 and numero=".$rowco["numero"]." and version=".$version;
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			$rowcc = mysqli_fetch_array($resultcc);

			$sqlcor = "select orden,id_comercial_contenido from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
			$resultcor = mysqli_query($dbhandle,convertSQL($sqlcor));
			while ($rowcor = mysqli_fetch_array($resultcor)) {
				$camposInsert="orden,id_comercial_contenido,id_comercial_oferta";
				$datosInsert=array($rowcor["orden"],$rowcor["id_comercial_contenido"],$rowcc["id"]);
				insertFunction("sim_comercial_oferta_rel_contenido",$camposInsert,$datosInsert);
			}

			$camposUpdate=array('versionado');
			$datosUpdate=array(1);
			updateFunction("sim_comercial_oferta",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		$sqln = "select numero from sim_comercial_oferta where visible=1 and id_plantilla=0 order by numero desc";
		$resultn = mysqli_query($dbhandle,convertSQL($sqln));
		$rown = mysqli_fetch_array($resultn);
		$numeroo = ($rown["numero"]+ 1);
		$versiono = 0;

		echo "<h4>".$Plantillas."</h4>";
		echo boton(array("op=1009&sop=500"),array("&laquo; ".$Volver));
		if ($_GET["ver"] == 0) { echo boton(array("op=1009&sop=530&ver=1"),array($Versiones_anteriores)); }
		if ($_GET["ver"] == 1) { echo boton(array("op=1009&sop=530"),array($Versiones_actuales)); }
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Numero."</th>";
				echo "<th>/".$Version."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th>".$Idioma."</th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1009&sop=530&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input style=\"width:100px\" type=\"Text\" name=\"numero\" value=\"".$numeroo."\"></td>";
				echo "<td></td>";
				echo "<td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\"></td>";
				echo "<td><select style=\"width:50px\" name=\"id_idioma\">";
					$sqlb = "select id,idioma from sgm_idiomas where visible=1 order by predefinido desc,idioma";
					$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
					while ($rowb = mysqli_fetch_array($resultb)) {
						echo "<option value=\"".$rowb["id"]."\">".$rowb["idioma"]."</option>";
					}
				echo "</td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlcc = "select * from sim_comercial_oferta where visible=1 and id_plantilla=0";
			if ($_GET["ver"] == 0) { $sqlcc .= " and versionado=0";}
			$sqlcc .= " order by numero desc, version desc";
			$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
			while ($rowcc = mysqli_fetch_array($resultcc)){
				echo "<tr>";
					echo "<form action=\"index.php?op=1009&sop=530&ssop=2&id=".$rowcc["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=531&id=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
					echo "<td><input style=\"width:100px\" type=\"Text\" name=\"numero\" value=\"".$rowcc["numero"]."\"></td>";
					echo "<td>/ <input style=\"width:50px\" type=\"Text\" name=\"version\" value=\"".$rowcc["version"]."\"></td>";
					echo "<td><input style=\"width:500px\" type=\"Text\" name=\"descripcion\" value=\"".$rowcc["descripcion"]."\"></td>";
					echo "<td><select style=\"width:50px\" name=\"id_idioma\">";
						$sqlb = "select id,idioma from sgm_idiomas where visible=1 order by predefinido desc,idioma";
						$resultb = mysqli_query($dbhandle,convertSQL($sqlb));
						while ($rowb = mysqli_fetch_array($resultb)) {
							if ($rowb["id"] == $rowcc["id_idioma"]){
								echo "<option value=\"".$rowb["id"]."\" selected>".$rowb["idioma"]."</option>";
							} else {
								echo "<option value=\"".$rowb["id"]."\">".$rowb["idioma"]."</option>";
							}
						}
					echo "</td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=535&id=".$rowcc["id"]."\" method=\"post\">";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
					echo "</form>";
					echo "<form action=\"index.php?op=1009&sop=532&id=".$rowcc["id"]."\" method=\"post\">";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Versionar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 531) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=530&ssop=3&id=".$_GET["id"],"op=1009&sop=530"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 532) {
		echo "<center>";
		echo "<br><br>".$pregunta_versionar;
		echo boton(array("op=1009&sop=530&ssop=4&id=".$_GET["id"],"op=1009&sop=530"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 535) {
		if ($ssoption == 1) {
#			if ($_POST["orden"] < 10) {$orden = "0".$_POST["orden"];} else {$orden = $_POST["orden"];}
			$camposInsert="orden,id_comercial_contenido,id_comercial_oferta";
			$datosInsert=array($_POST["orden"],$_POST["id_contenido"],$_GET["id"]);
			insertFunction("sim_comercial_oferta_rel_contenido",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
#			if ($_POST["orden"] < 10) {$orden = "0".$_POST["orden"];} else {$orden = $_POST["orden"];}
			$camposUpdate=array('orden','id_comercial_contenido');
			$datosUpdate=array($_POST["orden"],$_POST["id_contenido"]);
			updateFunction("sim_comercial_oferta_rel_contenido",$_GET["id_con"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			deleteFunction("sim_comercial_oferta_rel_contenido",$_GET["id_con"]);
		}

		$sqlc = "select id_idioma from sim_comercial_oferta where visible=1 and id=".$_GET["id"];
		$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
		$rowc = mysqli_fetch_array($resultc);
		echo "<h4>".$Contenidos."</h4>";
		echo boton(array("op=1009&sop=530"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Orden."</th>";
				echo "<th>".$Contenido."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1009&sop=535&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
				echo "<td style=\"text-align:right;\"><input type=\"Text\" name=\"orden\" value=\"0\" style=\"width:50px\"></td>";
				echo "<td><select style=\"width:450px\" name=\"id_contenido\">";
					echo "<option value=\"0\">-</option>";
					$sqlg = "select id,titulo from sim_comercial_contenido where visible=1 and versionado=0 and id_idioma=".$rowc["id_idioma"];
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)){
						echo "<option value=\"".$rowg["id"]."\">".$rowg["titulo"]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sqlco = "select * from sim_comercial_oferta_rel_contenido where id_comercial_oferta=".$_GET["id"]." order by orden";
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			while ($rowco = mysqli_fetch_array($resultco)) {
				echo "<form action=\"index.php?op=1009&sop=535&ssop=2&id=".$_GET["id"]."&id_con=".$rowco["id"]."\" method=\"post\">";
				echo "<tr>";
					echo "<td><a href=\"index.php?op=1009&sop=536&id=".$_GET["id"]."&id_con=".$rowco["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
					echo "<td style=\"text-align:right;width:50px;\"><input type=\"Text\" name=\"orden\" value=\"".$rowco["orden"]."\" style=\"width:50px\"></td>";
					echo "<td><select style=\"width:450px\" name=\"id_contenido\">";
						$sqls = "select id,titulo from sim_comercial_contenido where visible=1";
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						while ($rows = mysqli_fetch_array($results)){
							if ($rows["id"] == $rowco["id_comercial_contenido"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rows["titulo"]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rows["titulo"]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</tr>";
				echo "</form>";
			}
		echo "</table>";
	}

	if ($soption == 536) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=535&ssop=3&id=".$_GET["id"]."&id_con=".$_GET["id_con"],"op=1009&sop=535&id=".$_GET["id"]),array($Si,$No));
		echo "</center>";
	}

	if (($soption == 540) and ($admin == true)) {
		if ($ssoption == 1){
			$camposinsert = "software";
			$datosInsert = array($_POST["software"]);
			insertFunction ("sim_comercial_software",$camposinsert,$datosInsert);
		}
		if ($ssoption == 2){
			$camposUpdate = array("software");
			$datosUpdate = array($_POST["software"]);
			updateFunction ("sim_comercial_software",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sim_comercial_software",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>Software</h4>";
		echo boton(array("op=1009&sop=500"),array("&laquo; ".$Volver));
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>Software</th>";
				echo "<th></th>";
			echo "</tr><tr>";
				echo "<form action=\"index.php?op=1009&sop=540&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td><input type=\"text\" style=\"width:150px\" name=\"software\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_comercial_software where visible=1 order by software";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=541&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=1009&sop=540&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["software"]."\" style=\"width:150px\" name=\"tipo_servidor\"></td>";
					echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if (($soption == 541) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1009&sop=540&ssop=3&id=".$_GET["id"],"op=1009&sop=540"),array($Si,$No));
		echo "</center>";
	}

	
	echo "</td></tr></table><br>";
	}
?>
