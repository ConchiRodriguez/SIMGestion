<?php

if ($user == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 200) AND ($user == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Panel_usuario."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if (($soption >= 0) and($soption < 10)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=0&id=".$userid["id"]."\" class=".$class.">".$Estado." ".$General."</a></td>";
				if (($soption >= 10) and($soption < 20)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=10&id=".$userid["id"]."\" class=".$class.">".$Cambio." ".$Contrasena."</a></td>";
				if (($soption >= 20) and($soption < 30)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=20\" class=".$class.">".$Versiones." SIMges</a></td>";
				if (($soption >= 30) and($soption < 40)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=30\" class=".$class.">".$Calendario."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
	echo "</table><br>";
	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
		$sqlx = "select id_tipus from sgm_users where sgm=1 and activo=1 and validado=1 and id=".$userid;
		$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
		$rowx = mysqli_fetch_array($resultx);

		$sqldiv = "select * from sgm_divisas where predefinido=1";
		$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
		$rowdiv = mysqli_fetch_array($resultdiv);

		echo "<h4>".$Estado." ".$General."</h4>";
		$inicio_mes = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-5,date("Y")));
		$final_mes = date("Y-m-d");
		$sqlcv = "select count(*) as total from sim_control_versiones where visible=1 and fecha between '".$inicio_mes."' and '".$final_mes."' order by fecha desc";
		$resultcv = mysqli_query($dbhandle,convertSQL($sqlcv));
		$rowcv = mysqli_fetch_array($resultcv);
		if ($rowcv["total"] > 0){
			echo "<h4>".$Versiones." SIMges</h4>";
			echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			$sqlcv = "select * from sim_control_versiones where visible=1 and fecha between '".$inicio_mes."' and '".$final_mes."' order by fecha desc";
			$resultcv = mysqli_query($dbhandle,convertSQL($sqlcv));
			while ($rowcv = mysqli_fetch_array($resultcv)) {
				echo "<tr>";
					echo "<td style=\"vertical-align:top;width:80px;\">".cambiarFormatoFechaDMY($rowcv["fecha"])."</td>";
					$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 and id=".$rowcv["id_usuario"];
					$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
					$rowx = mysqli_fetch_array($resultx);
					echo "<td style=\"vertical-align:top;\">".$rowx["usuario"]."</td>";
					echo "<td><textarea name=\"comentarios\" style=\"width:800px\" disabled>".$rowcv["comentarios"]."</textarea></td>";
				echo "</tr>";
				echo "<tr><td>&nbsp;</td></tr>";
			}
			echo "<tr><td></td><td></td><td style=\"text-align:right;\"><a href=\"index.php?op=200&sop=20\">".$VerMas."</a></td></tr>";
			echo "</table>";
		}
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<h4>".$Contratos."</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"width:750px;\">".$Bolsa." ".$Horas."</th>";
							echo "<th style=\"text-align:right;width:150px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["bh"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"bh\" value=\"1\">";
#							}
#							if ($_POST["bh"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"bh\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["bh"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:400px;\">".$Cliente."</th>";
							echo "<th style=\"width:200px;\">".$Contrato."</th>";
							echo "<th style=\"width:50px;\">".$Fecha_Fin."</th>";
							echo "<th style=\"width:100px;\">".$Numero." ".$Horas."</th>";
							echo "<th style=\"width:150px;\">".$Horas." ".$Consumidas."</th>";
						echo "</tr>";
						$sqlch = "select * from sgm_contratos where visible=1 and activo=1 and pack_horas=1 order by fecha_ini desc";
						$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
						while ($rowch = mysqli_fetch_array($resultch)) {
							$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowch["id_cliente"];
							$resulta = mysqli_query($dbhandle,convertSQL($sqla));
							$rowa = mysqli_fetch_array($resulta);

							$total_horas = 0;
							$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowch["id"];
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							while ($rowcs = mysqli_fetch_array($resultcs)) {
								$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia in (select id from sgm_incidencias where id_servicio=".$rowcs["id"].") and visible=1";
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								$rowd = mysqli_fetch_array($resultd);
								$total_horas += $rowd["total"];
							}
							$hora = $total_horas/60;
							$horas = explode(".",$hora);
							$minutos = $total_horas % 60;
							if ($rowch["num_horas"] <= $horas[0]) { $color = "red"; $color_letra = "white";}
							elseif (($rowch["num_horas"]-$horas[0]) <= 5) { $color = "orange"; $color_letra = "";}
							else { $color = "white"; $color_letra = "";}
							echo "<tr style=\"background-color:".$color."\">";
								echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\" style=\"color:".$color_letra."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
								echo "<td><a href=\"index.php?op=1011&sop=100&id=".$rowch["id"]."\" style=\"color:".$color_letra."\">".$rowch["descripcion"]."</a></td>";
								echo "<td style=\"color:".$color_letra."\">".cambiarFormatoFechaDMY($rowch["fecha_fin"])."</td>";
								echo "<td style=\"color:".$color_letra."\">".$rowch["num_horas"]." ".$Horas."</td>";
								echo "<td style=\"color:".$color_letra."\">".$horas[0]." ".$Horas." ".$minutos." ".$Minutos."</td>";
							echo "</tr>";
						}
#					}
					echo "</table>";
				echo "<td>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<h4>&nbsp;</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"2\" style=\"width:750px;\">".$Resumen." ".$Contratos."</th>";
							echo "<th style=\"text-align:right;width:150px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["rc"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"1\">";
#							}
#							if ($_POST["rc"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["rc"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:500px;\">".$Cliente."</th>";
							echo "<th style=\"width:200px;\">".$Contrato."</th>";
							echo "<th style=\"width:50px;\">".$Fecha_Fin."</th>";
							echo "<th style=\"width:150px;\">".$Horas." ".$Consumidas."</th>";
						echo "</tr>";
						$sqlch = "select * from sgm_contratos where visible=1 and activo=1 and pack_horas=0 order by fecha_fin";
						$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
						while ($rowch = mysqli_fetch_array($resultch)) {
							$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowch["id_cliente"];
							$resulta = mysqli_query($dbhandle,convertSQL($sqla));
							$rowa = mysqli_fetch_array($resulta);

							$total_horas = 0;
							$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowch["id"];
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							while ($rowcs = mysqli_fetch_array($resultcs)) {
								$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia in (select id from sgm_incidencias where id_servicio=".$rowcs["id"].") and visible=1";
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								$rowd = mysqli_fetch_array($resultd);
								$total_horas += $rowd["total"];
							}
							$hora = $total_horas/60;
							$horas = explode(".",$hora);
							$minutos = $total_horas % 60;
							if (date('U',strtotime($rowch["fecha_fin"])) <= date('U')) { $color = "red"; $color_letra = "white";}
							else { $color = "white"; $color_letra = "";}
							echo "<tr style=\"background-color:".$color."\">";
								echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\" style=\"color:".$color_letra."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
								echo "<td><a href=\"index.php?op=1011&sop=100&id=".$rowch["id"]."\" style=\"color:".$color_letra."\">".$rowch["descripcion"]."</a></td>";
								echo "<td style=\"color:".$color_letra."\">".cambiarFormatoFechaDMY($rowch["fecha_fin"])."</td>";
								echo "<td style=\"color:".$color_letra."\">".$horas[0]." ".$Horas." ".$minutos." ".$Minutos."</td>";
							echo "</tr>";
						}
#					}
					echo "</table>";
				echo "<td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"2\" style=\"width:750px;\">".$Facturacion." ".$Mensual." ".$Horas."</th>";
							echo "<th style=\"text-align:right;width:150px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["fm"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"1\">";
#							}
#							if ($_POST["fm"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["fm"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:400px;\">".$Cliente."</th>";
							echo "<th style=\"width:300px;\">".$Contrato."</th>";
							echo "<th style=\"width:50px;\">".$Fecha_Fin."</th>";
							echo "<th style=\"width:150px;\">".$Horas." ".$Consumidas."</th>";
						echo "</tr>";
						$sqlch = "select * from sgm_contratos where visible=1 and activo=1 and horas_mensual=1 order by fecha_ini desc";
						$resultch = mysqli_query($dbhandle,convertSQL($sqlch));
						while ($rowch = mysqli_fetch_array($resultch)) {
							$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowch["id_cliente"];
							$resulta = mysqli_query($dbhandle,convertSQL($sqla));
							$rowa = mysqli_fetch_array($resulta);

							$total_horas = 0;
							$sqlcs = "select * from sgm_contratos_servicio where visible=1 and id_contrato=".$rowch["id"];
							$resultcs = mysqli_query($dbhandle,convertSQL($sqlcs));
							while ($rowcs = mysqli_fetch_array($resultcs)) {
								$ultimaDiaMes = date("d",(mktime(0,0,0,date("m")+1,1,date("Y"))-1));
								$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia in (select id from sgm_incidencias where id_servicio=".$rowcs["id"].") and fecha_inicio between ".date("U",mktime(0,0,0,date("m"),1,date("Y")))." and ".date("U",mktime(23,59,59,date("m"),$ultimaDiaMes,date("Y")))." and visible=1";
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								$rowd = mysqli_fetch_array($resultd);
								$total_horas += $rowd["total"];
							}
							$hora = $total_horas/60;
							$horas = explode(".",$hora);
							$minutos = $total_horas % 60;
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
								echo "<td><a href=\"index.php?op=1011&sop=100&id=".$rowch["id"]."\">".$rowch["descripcion"]."</a></td>";
								echo "<td style=\"color:".$color_letra."\">".cambiarFormatoFechaDMY($rowch["fecha_fin"])."</td>";
								echo "<td>".$horas[0]." ".$Horas." ".$minutos." ".$Minutos."</td>";
							echo "</tr>";
						}
#					}
					echo "</table>";
				echo "<td>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
				echo "<td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<h4>".$Facturacion."</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"width:800px;\">".$Facturacion." 15 ".$Dias."</th>";
							echo "<th style=\"text-align:right;width:100px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["fd"] == 0){ 
##								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
	#							echo "<input type=\"hidden\" name=\"fd\" value=\"1\">";
	#						}
	#						if ($_POST["fd"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["fd"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:150px;\">".$Numero." ".$Factura."</th>";
							echo "<th style=\"width:150px;\">".$Fecha."</th>";
							echo "<th style=\"width:500px;\">".$Cliente."</th>";
							echo "<th style=\"width:100px;\">".$Total."</th>";
						echo "</tr>";
						$total_factura = 0;
						$sqlc = "select * from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=1)";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							if ((date("U", strtotime($rowc["fecha"])) >= date("U")) and date("U", strtotime($rowc["fecha"])) <= (date("U",mktime(0,0,0,date("m"),date("d")+15,date("Y"))))){
								$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
								$resulta = mysqli_query($dbhandle,convertSQL($sqla));
								$rowa = mysqli_fetch_array($resulta);
								echo "<tr>";
									echo "<td><a href=\"index.php?op=1003&sop=100&id=".$rowc["id"]."\">".$rowc["numero"]."</a></td>";
									echo "<td>".cambiarFormatoFechaDMY($rowc["fecha"])."</td>";
									echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
									echo "<td style=\"text-align:right;\">".number_format($rowc["total"],3,'.',',')." ".$rowdiv["abrev"]."</td>";
								echo "</tr>";
								$total_factura += $rowc["total"];
							}
						}
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"border-top:1px solid black;\"></th>";
							echo "<th style=\"width:100px;border-top:1px solid black;text-align:right;\">".number_format($total_factura,3,'.',',')." ".$rowdiv["abrev"]."</th>";
						echo "</tr>";
#					}
					echo "</table>";
				echo "<td>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<h4>&nbsp;</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"width:800px;\">".$Presupuesto." ".$Aprobado."</th>";
							echo "<th style=\"text-align:right;width:100px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["pa"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"1\">";
#							}
#							if ($_POST["pa"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["pa"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:150px;\">".$Numero." ".$Factura."</th>";
							echo "<th style=\"width:150px;\">".$Fecha."</th>";
							echo "<th style=\"width:500px;\">".$Cliente."</th>";
							echo "<th style=\"width:100px;\">".$Total."</th>";
						echo "</tr>";
						$total_factura = 0;
						$sqlc = "select * from sgm_cabezera where visible=1 and aprovado=1 and cerrada=0 and tipo in (select id from sgm_factura_tipos where contabilidad=0)";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
							$resulta = mysqli_query($dbhandle,convertSQL($sqla));
							$rowa = mysqli_fetch_array($resulta);
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1003&sop=100&id=".$rowc["id"]."\">".$rowc["numero"]."</a></td>";
								echo "<td>".cambiarFormatoFechaDMY($rowc["fecha"])."</td>";
								echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
								echo "<td style=\"text-align:right;\">".number_format($rowc["total"],3,'.',',')." ".$rowdiv["abrev"]."</td>";
							echo "</tr>";
							$total_factura += $rowc["total"];
						}
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"border-top:1px solid black;\"></th>";
							echo "<th style=\"width:100px;border-top:1px solid black;text-align:right;\">".number_format($total_factura,3,'.',',')." ".$rowdiv["abrev"]."</th>";
						echo "</tr>";
#					}
					echo "</table>";
				echo "<td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"width:800px;\">".$Pagos." 15 ".$Dias."</th>";
							echo "<th style=\"text-align:right;width:100px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["pd"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"1\">";
#							}
#							if ($_POST["pd"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["pd"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:150px;\">".$Numero." ".$Factura."</th>";
							echo "<th style=\"width:150px;\">".$Fecha."</th>";
							echo "<th style=\"width:500px;\">".$Cliente."</th>";
							echo "<th style=\"width:100px;\">".$Total."</th>";
						echo "</tr>";
						$total_factura = 0;
						$sqlc = "select * from sgm_cabezera where visible=1 and tipo in (select id from sgm_factura_tipos where contabilidad=-1)";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							if ((date("U", strtotime($rowc["fecha_vencimiento"])) >= date("U")) and date("U", strtotime($rowc["fecha_vencimiento"])) <= (date("U",mktime(0,0,0,date("m"),date("d")+15,date("Y"))))){
								$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
								$resulta = mysqli_query($dbhandle,convertSQL($sqla));
								$rowa = mysqli_fetch_array($resulta);
								echo "<tr>";
									echo "<td><a href=\"index.php?op=1003&sop=100&id=".$rowc["id"]."\">".$rowc["numero"]."</a></td>";
									echo "<td>".cambiarFormatoFechaDMY($rowc["fecha"])."</td>";
									echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
									echo "<td style=\"text-align:right;\">".number_format($rowc["total"],3,'.',',')." ".$rowdiv["abrev"]."</td>";
								echo "</tr>";
								$total_factura += $rowc["total"];
							}
						}
						echo "<tr>";
							echo "<th colspan=\"3\" style=\"border-top:1px solid black;\"></th>";
							echo "<th style=\"width:100px;border-top:1px solid black;text-align:right;\">".number_format($total_factura,3,'.',',')." ".$rowdiv["abrev"]."</th>";
						echo "</tr>";
#					}
					echo "</table>";
				echo "<td>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"4\" style=\"width:800px;\">".$Cobros." 15 ".$Dias."</th>";
							echo "<th style=\"text-align:right;width:100px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["cd"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"1\">";
#							}
#							if ($_POST["cd"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["cd"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:100px;\">".$Numero." ".$Factura."</th>";
							echo "<th style=\"width:100px;\">".$Fecha."</th>";
							echo "<th style=\"width:100px;\">".$Fecha." ".$Vencimiento."</th>";
							echo "<th style=\"width:500px;\">".$Cliente."</th>";
							echo "<th style=\"width:100px;\">".$Total."</th>";
						echo "</tr>";
						$total_factura = 0;
						$sqlc = "select * from sgm_cabezera where visible=1 and cobrada=0 and tipo in (select id from sgm_factura_tipos where contabilidad=1)";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							if ((date("U", strtotime($rowc["fecha_vencimiento"])) >= date("U")) and date("U", strtotime($rowc["fecha_vencimiento"])) <= (date("U",mktime(0,0,0,date("m"),date("d")+15,date("Y"))))){
								$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowc["id_cliente"];
								$resulta = mysqli_query($dbhandle,convertSQL($sqla));
								$rowa = mysqli_fetch_array($resulta);
								echo "<tr>";
									echo "<td><a href=\"index.php?op=1003&sop=100&id=".$rowc["id"]."\">".$rowc["numero"]."</a></td>";
									echo "<td>".cambiarFormatoFechaDMY($rowc["fecha"])."</td>";
									echo "<td>".cambiarFormatoFechaDMY($rowc["fecha_vencimiento"])."</td>";
									echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
									echo "<td style=\"text-align:right;\">".number_format($rowc["total"],3,'.',',')." ".$rowdiv["abrev"]."</td>";
								echo "</tr>";
								$total_factura += $rowc["total"];
							}
						}
						echo "<tr>";
							echo "<th colspan=\"4\" style=\"border-top:1px solid black;\"></th>";
							echo "<th style=\"width:100px;border-top:1px solid black;text-align:right;\">".number_format($total_factura,3,'.',',')." ".$rowdiv["abrev"]."</th>";
						echo "</tr>";
#					}
					echo "</table>";
				echo "<td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<h4>".$Incidencias."</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"2\" style=\"width:800px;\">".$Sin." ".$Contrato."</th>";
							echo "<th style=\"text-align:right;width:100px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["sc"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"1\">";
#							}
#							if ($_POST["sc"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"".$_POST["ua"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["sc"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:400px;\">".$Cliente."</th>";
							echo "<th style=\"width:350px;\">".$Asunto."</th>";
							echo "<th style=\"width:150px;\">".$Numero." ".$Horas."</th>";
						echo "</tr>";
						$sqlin = "select * from sgm_incidencias where visible=1 and id_incidencia=0 and id_servicio=-1 and facturada=0 and id_estado=-2 order by fecha_inicio desc";
						$resultin = mysqli_query($dbhandle,convertSQL($sqlin));
						while ($rowin = mysqli_fetch_array($resultin)) {
							$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowin["id_cliente"];
							$resulta = mysqli_query($dbhandle,convertSQL($sqla));
							$rowa = mysqli_fetch_array($resulta);

							$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowin["id"]." and visible=1";
							$resultd = mysqli_query($dbhandle,convertSQL($sqld));
							$rowd = mysqli_fetch_array($resultd);
							$total_horas = $rowd["total"];
							$hora = $total_horas/60;
							$horas = explode(".",$hora);
							$minutos = $total_horas % 60;
							echo "<tr>";
								echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
								echo "<td><a href=\"index.php?op=1018&sop=100&id=".$rowin["id"]."\">".$rowin["asunto"]."</a></td>";
								echo "<td>".$horas[0]." ".$Horas." ".$minutos." ".$Minutos."</td>";
							echo "</tr>";
						}
#					}
					echo "</table>";
				echo "<td>";
				echo "<td style=\"width:50%;vertical-align:top;\">";
					echo "<h4>&nbsp;</h4>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th colspan=\"2\" style=\"width:800px;\">".$Usuario." ".$Actual."</th>";
							echo "<th style=\"text-align:right;width:100px;\">";
#							echo "<form action=\"index.php?op=200&sop=0\" method=\"post\">";
#							if ($_POST["ua"] == 0){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_down.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"1\">";
#							}
#							if ($_POST["ua"] == 1){ 
#								echo "<input type=\"image\" src=\"mgestion/pics/icons-mini/bullet_arrow_up.png\" value=\"boton\" style=\"width:20px;height:20px;border:0\">";
#								echo "<input type=\"hidden\" name=\"ua\" value=\"0\">";
#							}
#								echo "<input type=\"hidden\" name=\"bh\" value=\"".$_POST["bh"]."\">";
#								echo "<input type=\"hidden\" name=\"rc\" value=\"".$_POST["rc"]."\">";
#								echo "<input type=\"hidden\" name=\"fm\" value=\"".$_POST["fm"]."\">";
#								echo "<input type=\"hidden\" name=\"fd\" value=\"".$_POST["fd"]."\">";
#								echo "<input type=\"hidden\" name=\"pa\" value=\"".$_POST["pa"]."\">";
#								echo "<input type=\"hidden\" name=\"pd\" value=\"".$_POST["pd"]."\">";
#								echo "<input type=\"hidden\" name=\"cd\" value=\"".$_POST["cd"]."\">";
#								echo "<input type=\"hidden\" name=\"sc\" value=\"".$_POST["sc"]."\">";
#							echo "</form>";
							echo "</th>";
						echo "</tr>";
#					if ($_POST["ua"] == 1){ 
						echo "<tr style=\"background-color:silver;\">";
							echo "<th style=\"width:400px;\">".$Cliente."</th>";
							echo "<th style=\"width:400px;\">".$Asunto."</th>";
							echo "<th style=\"width:100px;\">".$SLA."</th>";
						echo "</tr>";
						for ($i = 1; $i<=4;$i++){
							$sqli = "select * from sgm_incidencias where visible=1 and id_incidencia=0 and id_estado<>-2 and id_usuario_destino=".$userid;
							if ($i == 1) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision > 0 and pausada=0"; }
							elseif ($i == 2) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision=0 and pausada=0 and id_cliente<>(select id from sgm_clients where nif='B65702227' and visible=1)"; } 
							elseif ($i == 3) { $sqli = $sqli." and id_servicio <> 0 and fecha_prevision=0 and pausada=0 and id_cliente=(select id from sgm_clients where nif='B65702227' and visible=1)"; } 
							elseif ($i == 4) { $sqli = $sqli." and pausada=1"; }
							$sqli = $sqli." order by temps_pendent,id_cliente,id_servicio,id_usuario_destino";
							$resulti = mysqli_query($dbhandle,convertSQL($sqli));
							while ($rowi = mysqli_fetch_array($resulti)) {
								$sqla = "select id,nombre,cognom1,cognom2 from sgm_clients where visible=1 and id=".$rowi["id_cliente"];
								$resulta = mysqli_query($dbhandle,convertSQL($sqla));
								$rowa = mysqli_fetch_array($resulta);

								$sqld = "select sum(duracion) as total from sgm_incidencias where id_incidencia=".$rowi["id"]." and visible=1";
								$resultd = mysqli_query($dbhandle,convertSQL($sqld));
								$rowd = mysqli_fetch_array($resultd);
								$total_horas = $rowd["total"];
								$hora = $total_horas/60;
								$horas = explode(".",$hora);
								$minutos = $total_horas % 60;
								$sqlc = "select temps_resposta from sgm_contratos_servicio where id=".$rowi["id_servicio"];
								$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
								$rowc = mysqli_fetch_array($resultc);
								if ($rowc["temps_resposta"] != 0){
									$hora_actual = time();
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
									$fecha_prev = date("Y-m-d H:i:s", $rowi["fecha_prevision"]);
								} else {
									$sla = "";
									$fecha_prev = "";
									$estado_color = "";
									$estado_color_letras = "";
								}
								if ($rowi["pausada"] == 1){
									$fecha_prev = "";
									$estado_color = "#E5E5E5";
									$estado_color_letras = "";
								}
								echo "<tr style=\"background-color:".$estado_color.";\">";
									echo "<td><a href=\"index.php?op=1008&sop=100&id=".$rowa["id"]."\" style=\"color:".$estado_color_letras."\">".$rowa["nombre"]." ".$rowa["cognom1"]." ".$rowa["cognom2"]."</a></td>";
									echo "<td><a href=\"index.php?op=1018&sop=100&id=".$rowi["id"]."\" style=\"color:".$estado_color_letras."\">".$rowi["asunto"]."</a></td>";
									echo "<td style=\"color:".$estado_color_letras."\">".$sla."</td>";
								echo "</tr>";
							}
						}
#					}
					echo "</table>";
				echo "<td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 10) {
		echo "<h4>".$Cambio." ".$Contrasena."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=200&sop=11\" method=\"post\">";
			echo "<tr><th>".$Contrasena."</th><td style=\"vertical-align:middle;\"><input type=\"Password\" name=\"pass1\" style=\"width:100px\" maxlength=\"10\" placeholder=\"".$ayudaPanelUserPass."\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" style=\"width:100px\" maxlength=\"10\" placeholder=\"".$ayudaPanelUserPass."\"></td></tr>";
			echo "<tr><td></td><td class=\"Submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 11) {
		if (($_POST["pass1"] == $_POST["pass2"]) AND ($_POST["pass1"] != "")) {
			$contrasena = crypt($_POST["pass1"]);
			$sql = "update sgm_users set ";
			$sql = $sql."pass='".$contrasena."'";
			$sql = $sql." WHERE id=".$userid."";
			mysqli_query($dbhandle,convertSQL($sql));
			echo "<center>";
			echo "<br><br>".$ayudaPanelUserPass2;
			echo boton(array("op=0&sop=666"),array($Salir));
			echo "</center>";
		} else {
			echo mensageError($errorPanelUserPass);
		}
	}

	if ($soption == 20) {
		echo "<h4>".$Versiones." SIMges</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$yact = date("Y");
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><b>".$yact."</b></td>";
				if ($ypost <= date("Y")){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
			echo "<tr>";
				if ($_GET["m"] == "") {
					$mact = date("n");
				} else {
					$mact = $_GET["m"];
				}
				$mant = $mact - 1;
				$mpost = $mact +1;
				if ($mant >= 1){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$yact."&m=".$mant."\">".$meses[$mant-1]."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><b>".$meses[$mact-1]."</b></td>";
				if ($mpost <= 12){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$yact."&m=".$mpost."\">&gt;".$meses[$mpost-1]."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Comentarios."</th>";
			echo "</tr>";
		$ultimo_dia = date("t", mktime(0,0,0,$mact,1,$yact));
		$inicio_mes = date("Y-m-d", mktime(0,0,0,$mact,1,$yact));
		$final_mes = date("Y-m-d", mktime(0,0,0,$mact,$ultimo_dia, $yact));
		$sqlcv = "select * from sim_control_versiones where visible=1 and fecha between '".$inicio_mes."' and '".$final_mes."' order by fecha desc";
		$resultcv = mysqli_query($dbhandle,convertSQL($sqlcv));
		while ($rowcv = mysqli_fetch_array($resultcv)) {
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:80px;\">".cambiarFormatoFechaDMY($rowcv["fecha"])."</td>";
				$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 and id=".$rowcv["id_usuario"];
				$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
				$rowx = mysqli_fetch_array($resultx);
				echo "<td style=\"vertical-align:top;\">".$rowx["usuario"]."</td>";
				echo "<td><textarea name=\"comentarios\" style=\"width:800px\" disabled>".$rowcv["comentarios"]."</textarea></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		}
		echo "</table>";
	}

	if ($soption == 30) {
		echo "<h4>".$Calendario."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=200&sop=30\" method=\"post\">";
			echo "<tr>";
				echo "<th style=\"text-align:center;\">".$Ano." : </th>";
				echo "<td><select name=\"ano\">";
				for ($i = date("Y")+1; $i >= 2012; $i--) {
					if ($_POST["ano"] == $i) {
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					} else {
						echo "<option value=\"".$i."\">".$i."</option>";
					}
				}
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Enviar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
			$color_vac_user = array();
		for ($j=1;$j<=12;$j++){
			echo "<td style=\"vertical-align:top\">";
				### parametros configurables
				if ($_POST["ano"] == "") {
					$a = date("Y");
				} else {
					$a = $_POST["ano"];
				}
				$m = $j;
				$d = 1;
				$programada = 1;
				$totaldiasmes = date("t", mktime(0,0,0,$m ,$d, $a));
				$semananum = 0;
				echo "<table>";
				echo "<caption>".$meses[$m-1]."</caption>";
				echo "<tr>";
					for ($i=0;$i<=6;$i++){
						echo "<td style=\"text-align:center\">".$dias[$i]."</td>";
					}
				echo "</tr><tr>";
				$sumadias = 0;
				$diasemana = 1;
				$semanax = 0;
				$control = 0;

				$index = 0;
				$color_vacances = array('8FBC8F','7B68EE','FF00FF','4682B4','4169E1','FF00FF','228B22','00FF00','808000');
				$sqlu = "select * from sgm_users where validado=1 and activo=1 and sgm=1 and id>1";
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				while ($rowu = mysqli_fetch_array($resultu)){
					$color_vac_user[$rowu["id"]] = "#".$color_vacances[$index];
					$index++;
				}

				while ($d <= $totaldiasmes) {
					$diasemana = date("w", mktime(0,0,0,$m ,$d, $a));
					if ($diasemana == 0) { $diasemana = 7; }
					$semana = date("W", mktime(0,0,0,$m ,$d, $a));
					if ($semana != $semanaanterior) {
						$semananum++;
						echo "</tr><tr>";
					}
					if ($semanax == 0) { 
						if ($diasemana == 7) { echo "<td></td><td></td><td></td><td></td><td></td><td></td>"; $sumadias = 6;}
						if ($diasemana == 6) { echo "<td></td><td></td><td></td><td></td><td></td>"; $sumadias = 5;}
						if ($diasemana == 5) { echo "<td></td><td></td><td></td><td></td>"; $sumadias = 4;}
						if ($diasemana == 4) { echo "<td></td><td></td><td></td>"; $sumadias = 3;}
						if ($diasemana == 3) { echo "<td></td><td></td>"; $sumadias = 2;}
						if ($diasemana == 2) { echo "<td></td>"; $sumadias = 1;}
						if ($diasemana == 1) { echo ""; $sumadias = 0;}
						$semanax = 1;
					}

					$fecha = date("U", mktime(0,0,0,$m ,$d, $a));
					$color = "white";
					if ($fecha == date('U', mktime(0, 0, 0, date('m'), date('d'), date('Y')))){ $color = "yellow"; } else {$color = $color;}
					if (comprobar_festivo2($fecha) == 1){ $color = "Tomato"; } else {$color = $color;}
					echo "<td style=\"text-align:center;width:50px;background-color:".$color.";vertical-align:top;color:black;border:1px Black Solid;height:40px;\">";
						echo "<table cellpadding=\"0\" cellspacing=\"0\">";
							echo "<caption>".$d."</caption>";
							echo "<tr>";
							$sqlu = "select * from sgm_users where validado=1 and activo=1 and sgm=1 and id>1";
							$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
							while ($rowu = mysqli_fetch_array($resultu)){
								if (comprobarFestivoEmpleado($fecha,$rowu["id"]) == 1){
									$color2 = $color_vac_user[$rowu["id"]];
									echo "<td style=\"background-color:".$color2.";height:10px;width:5px;\">&nbsp;</td>";
								}
							}
							echo "</tr>";
						echo "</table>";
					echo "</td>";
					$d++;
					$semanaanterior = $semana;
				}
				echo "</tr></table>";
			echo "</td>";
			if(($m==4) or ($m==8)){
				echo "</tr><tr>";
			}
		}
			echo "</tr>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
			foreach ( $color_vac_user as $usuario => $color_usuario){
				$sqlu = "select * from sgm_users where validado=1 and activo=1 and sgm=1 and id=".$usuario."";
				$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
				$rowu = mysqli_fetch_array($resultu);
				echo "<td style=\"background: ".$color_usuario.";width:15px;\";>&nbsp;</td>";
				echo "<td style=\"width:100px;\";>".$rowu["usuario"]."</td>";
			}
#			var_dump($color_vac_user);
			echo "</tr>";
		echo "</table>";

	}
	
	echo "</td></tr></table><br>";
}


?>
