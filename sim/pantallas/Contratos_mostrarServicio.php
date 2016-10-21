<?php
error_reporting(~E_ALL);


function mostrarServicio ($id_contrato,$id_cliente,$sop_delete){
	global $db,$dbhandle,$idioma;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

		if ($_GET["ssop"] == 2) {
			$sql = "select id from sgm_contratos_servicio where visible=1 and id_contrato=".$_GET["id"]." and servicio='".comillas($_POST["servicio"])."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if (!$row){
				$camposInsert = "id_contrato,servicio,obligatorio,extranet,incidencias,id_cobertura,temps_resposta,nbd,sla,duracion,precio_hora,codigo_catalogo,auto_email,funcion,id_servicio_origen,prefijo_notificacion";
				$datosInsert = array($_GET["id"],$_POST["servicio"],$_POST["obligatorio"],$_POST["extranet"],$_POST["incidencias"],$_POST["id_cobertura"],$_POST["temps_resposta"],$_POST["nbd"],$_POST["sla"],$_POST["duracion"],$_POST["precio_hora"],$_POST["codigo_catalogo"],$_POST["auto_email"],$_POST["funcion"],$_POST["id_servicio_origen"],$_POST["prefijo_notificacion"]);
				insertFunction ("sgm_contratos_servicio",$camposInsert,$datosInsert);
			} else {
				echo $ErrorServicio;
			}
		}
		if ($_GET["ssop"] == 3) {
			$camposUpdate = array("servicio","obligatorio","extranet","incidencias","id_cobertura","temps_resposta","nbd","sla","duracion","precio_hora","codigo_catalogo","auto_email","funcion","id_servicio_origen","prefijo_notificacion");
			$datosUpdate = array($_POST["servicio"],$_POST["obligatorio"],$_POST["extranet"],$_POST["incidencias"],$_POST["id_cobertura"],$_POST["temps_resposta"],$_POST["nbd"],$_POST["sla"],$_POST["duracion"],$_POST["precio_hora"],$_POST["codigo_catalogo"],$_POST["auto_email"],$_POST["funcion"],$_POST["id_servicio_origen"],$_POST["prefijo_notificacion"]);
			updateFunction ("sgm_contratos_servicio",$_GET["id_ser"],$camposUpdate,$datosUpdate);
		}
		if ($_GET["ssop"] == 4) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sgm_contratos_servicio",$_GET["id_ser"],$camposUpdate,$datosUpdate);
		}

		if (isset($id_contrato)){ $id_contrato = $id_contrato;} else { $id_contrato = 0;}
		if ($id_cliente > 0){ $contrato_adress = $id_cliente."&id_con=".$id_contrato;} else { $contrato_adress = $id_contrato;}

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
			echo "</tr><tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&ssop=2&id=".$contrato_adress."\" method=\"post\">";
				echo "<td><input style=\"width:250px\" type=\"Text\" name=\"servicio\"></td>";
				echo "<td><input style=\"width:100px\" type=\"Text\" name=\"codigo_catalogo\"></td>";
				echo "<td><input style=\"width:100px\" type=\"Text\" name=\"prefijo_notificacion\"></td>";
				echo "<td><select style=\"width:70px\" name=\"obligatorio\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"extranet\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"incidencias\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"duracion\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"id_cobertura\">";
					echo "<option value=\"0\">-</option>";
					$sql = "select id,nombre from sgm_contratos_sla_cobertura where visible=1 order by nombre";
					$result = mysqli_query($dbhandle,convertSQL($sql));
					while ($row = mysqli_fetch_array($result)) {
						echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
					}
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"temps_resposta\">";
					for ($i = 0; $i <= 24 ; $i++) {
						echo "<option value=\"".$i."\">".$i."</option>";
					}
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"nbd\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"0\" name=\"sla\" value=\"0\"></td>";
				echo "<td><input style=\"text-align:right;width:70px\" type=\"number\" min=\"0\" step=\"any\" name=\"precio_hora\" value=\"0\"></td>";
				echo "<td><select style=\"width:70px\" name=\"auto_email\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td><input style=\"width:150px\" type=\"Text\" name=\"funcion\"></td>";
				echo "<td><select style=\"width:70px\" name=\"id_servicio_origen\">";
					echo "<option value=\"0\">-</option>";
					$sqlcso = "select id,codigo_origen from sgm_contratos_servicio_origen where visible=1 order by codigo_origen";
					$resultcso = mysqli_query($dbhandle,convertSQL($sqlcso));
					while ($rowcso = mysqli_fetch_array($resultcso)) {
						echo "<option value=\"".$rowcso["id"]."\">".$rowcso["codigo_origen"]."</option>";
					}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
			echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$id_contrato." order by servicio";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$_GET["op"]."&sop=".$sop_delete."&id=".$contrato_adress."&id_ser=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
					echo "<form action=\"index.php?op=".$_GET["op"]."&sop=".$_GET["sop"]."&ssop=3&id=".$contrato_adress."&id_ser=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"text\" value=\"".$row["servicio"]."\" style=\"width:250px\" name=\"servicio\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["codigo_catalogo"]."\" style=\"width:100px\" name=\"codigo_catalogo\"></td>";
					echo "<td><input type=\"text\" value=\"".$row["prefijo_notificacion"]."\" style=\"width:100px\" name=\"prefijo_notificacion\"></td>";
					echo "<td><select style=\"width:70px\" name=\"obligatorio\">";
						if ($row["obligatorio"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"extranet\">";
						if ($row["extranet"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"incidencias\">";
						if ($row["incidencias"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"duracion\">";
						if ($row["duracion"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"id_cobertura\">";
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
					echo "<td><select style=\"width:70px\" name=\"temps_resposta\">";
						for ($i = 0; $i <= 24 ; $i++) {
							if ($i == $row["temps_resposta"]){
								echo "<option value=\"".$i."\" selected>".$i."</option>";
							} else {
								echo "<option value=\"".$i."\">".$i."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"nbd\">";
						if ($row["nbd"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"number\" min=\"0\" value=\"".$row["sla"]."\" style=\"text-align:right;width:70px\" name=\"sla\"></td>";
					echo "<td><input type=\"number\" min=\"0\" step=\"any\" value=\"".$row["precio_hora"]."\" style=\"text-align:right;width:70px\" name=\"precio_hora\"></td>";
					echo "<td><select style=\"width:70px\" name=\"auto_email\">";
						if ($row["auto_email"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"text\" value=\"".$row["funcion"]."\" style=\"width:150px\" name=\"funcion\"></td>";
					echo "<td><select style=\"width:70px\" name=\"id_servicio_origen\">";
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
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
					echo "</form>";
				if ($id_contrato > 0){
					$sqlind = "select sum(duracion) as total from sgm_incidencias where visible=1 and id_incidencia IN (select id from sgm_incidencias where visible=1 and id_servicio=".$row["id"].")";
					$resultind = mysqli_query($dbhandle,convertSQL($sqlind));
					$rowind = mysqli_fetch_array($resultind);
					$hora = $rowind["total"]/60;
					$horas = explode(".",$hora);
					$minutos = $rowind["total"] % 60;
					echo "<td style=\"text-align:right;\"><strong>".$horas[0]." h. ".$minutos." m.&nbsp;&nbsp;</strong></td>";
					$total_euros = $hora * $row["precio_hora"];
					echo "<td style=\"text-align:right;\"><strong>".number_format ($total_euros,2,',','')." ".$rowdiv["abrev"]."</strong></td>";
				}
				echo "</tr>";
				$total_horas_contracte += $rowind["total"];
				$total_euros_contracte += $total_euros;
			}
		if ($id_contrato > 0){
			echo "<tr>";
				$hora = $total_horas_contracte/60;
				$horas = explode(".",$hora);
				$minutos = $rowind["total"] % 60;
				echo "<td style=\"text-align:right;\" colspan=\"17\"><strong>".$Total."&nbsp;&nbsp;</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".$horas[0]." h. ".$minutos." m.&nbsp;&nbsp;</strong></td>";
				echo "<td style=\"text-align:right;\"><strong>".number_format ($total_euros_contracte,2,',','')." ".$rowdiv["abrev"]."</strong></td>";
			echo "</tr>";
		}
		echo "</table></center>";
		echo "<br><br>";
}

?>