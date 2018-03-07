<?php
error_reporting(~E_ALL);


function informesContratos(){
	global $db,$dbhandle,$Informes,$Cliente,$Mes,$Ano,$Horas,$Imprimir,$urlmgestion,$Contrato,$Ver_Horas,$Hasta,$Si,$No,$Idioma,$Ver_Detalles,$Tipo,$Todos,$Activos;
	echo "<strong>".$Informes."</strong>";
	echo "<br><br>";
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<caption>PDF</caption>";
		echo "<tr style=\"background-color:silver;\">";
		if ($_GET["id"] <= 0) {
			echo "<td>".$Cliente."</td>";
		}
			echo "<td>".$Tipo."</td>";
			echo "<td>".$Contrato."</td>";
			echo "<td>".$Mes."-".$Ano."</td>";
			echo "<td>".$Mes."-".$Ano." ".$Hasta."</td>";
			echo "<td>".$Idioma."</td>";
			echo "<td>".$Ver_Horas."</td>";
			echo "<td>".$Ver_Detalles."</td>";
			echo "<td></td>";
		echo "</tr><tr>";
			echo "<form method=\"post\" name=\"form2\" action=\"".$urlmgestion."/mgestion/gestion-contratos-informe-print-pdf.php\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
		if ($_GET["id"] <= 0) {
			echo "<td><select name=\"id_cliente\" id=\"id_cliente\" style=\"width:300px\" onchange=\"desplegableCombinado5()\">";
				echo "<option value=\"0\">".$Todos."</option>";
				$sqli = "select * from sgm_clients where visible=1 and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				while ($rowi = mysqli_fetch_array($resulti)) {
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
			echo "<td><select name=\"id_tipo\" id=\"id_tipo\" style=\"width:100px\" onchange=\"desplegableCombinado5()\">";
				if ($_POST["id_tipo"] == 1){
					echo "<option value=\"0\">".$Todos."</option>";
					echo "<option value=\"1\" selected>".$Activos."</option>";
					echo "<option value=\"2\">".$No." ".$Activos."</option>";
				} elseif ($_POST["id_tipo"] == 2){
					echo "<option value=\"0\">".$Todos."</option>";
					echo "<option value=\"1\">".$Activos."</option>";
					echo "<option value=\"2\" selected>".$No." ".$Activos."</option>";
				} else {
					echo "<option value=\"0\" selected>".$Todos."</option>";
					echo "<option value=\"1\">".$Activos."</option>";
					echo "<option value=\"2\">".$No." ".$Activos."</option>";
				}
			echo "</select></td>";
			echo "<td><select name=\"id_contrato\" id=\"id_contrato\" style=\"width:300px\" onchange=\"desplegableCombinado5()\">";
				if ($_GET["id"] <= 0) {
					echo "<option value=\"0\">".$Todos."</option>";
				}
				if ($_GET["id"] > 0) { $id_cli = $_GET["id"]; } else {$id_cli = $_POST["id_cliente"]; }
				$sqlc = "select id,descripcion from sgm_contratos where visible=1 and id_cliente=".$id_cli;
				if ($_POST["id_tipo"] == 1){ $sqlc .= " and activo=1";} elseif ($_POST["id_tipo"] == 2){ $sqlc .= " and activo=0";}
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				while ($rowc = mysqli_fetch_array($resultc)) {
					if ($_POST["id_contrato"] == $rowc["id"]){
						echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$rowc["id"]."\">".$rowc["descripcion"]."</option>";
					}
				}
			echo "</select></td>";
			$sqlco = "select * from sgm_contratos where id=".$_POST["id_contrato"]." order by fecha_ini";
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			$rowco = mysqli_fetch_array($resultco);
			if ($rowco){
				$mes_ini = date("U",strtotime($rowco["fecha_ini"]));
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
				$mes_act = $mes_ini;
			} else {
				$count = 1;
				$sqlco2 = "select fecha_ini,fecha_fin from sgm_contratos where visible=1 and (id_plantilla<>0 or id_contrato_tipo<>0)";
				if ($_POST["id_cliente"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
				while ($rowco2 = mysqli_fetch_array($resultco2)){
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
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			$rowco = mysqli_fetch_array($resultco);
			if ($rowco){
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
			} else {
				$mes_fin = 0;
				$count = 1;
				$sqlco2 = "select fecha_ini,fecha_fin from sgm_contratos where visible=1 and activo=1";
				if ($_POST["id_cliente"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
				while ($rowco2 = mysqli_fetch_array($resultco2)){
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
			echo "<td><select name=\"idioma\" id=\"idioma\" style=\"width:50px\">";
				$sqlid = "select * from sgm_idiomas where visible=1 order by predefinido desc,idioma";
				$resultid = mysqli_query($dbhandle,convertSQL($sqlid));
				while ($rowid = mysqli_fetch_array($resultid)) {
					if ($_POST["idioma"] == $rowid["idioma"]){
						echo "<option value=\"".$rowid["idioma"]."\" selected>".$rowid["idioma"]."</option>";
					} else {
						echo "<option value=\"".$rowid["idioma"]."\">".$rowid["idioma"]."</option>";
					}
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
			echo "<td><select name=\"detalles\" style=\"width:60px\">";
				if ($_POST["detalles"] == 0){
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
	echo "</table>";
	echo "<br><br>";
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<caption>CSV</caption>";
		echo "<tr style=\"background-color:silver;\">";
		if ($_GET["id"] <= 0) {
			echo "<td>".$Cliente."</td>";
		}
			echo "<td>".$Tipo."</td>";
			echo "<td>".$Contrato."</td>";
			echo "<td>".$Mes."-".$Ano."</td>";
			echo "<td>".$Mes."-".$Ano." ".$Hasta."</td>";
			echo "<td></td>";
		echo "</tr><tr>";
			echo "<form method=\"post\" name=\"form3\" action=\"".$urlmgestion."/mgestion/gestion-contratos-informe-print-csv.php\" target=\"popup\" onsubmit=\"window.open('', 'popup', '')\">";
		if ($_GET["id"] <= 0) {
			echo "<td><select name=\"id_cliente2\" id=\"id_cliente2\" style=\"width:300px\" onchange=\"desplegableCombinado6()\">";
				echo "<option value=\"0\">".$Todos."</option>";
				$sqli = "select * from sgm_clients where visible=1 and id in (select id_cliente from sgm_contratos where visible=1 and activo=1) order by nombre";
				$resulti = mysqli_query($dbhandle,convertSQL($sqli));
				while ($rowi = mysqli_fetch_array($resulti)) {
					if ($_POST["id_cliente2"] == $rowi["id"]){
						echo "<option value=\"".$rowi["id"]."\" selected>".$rowi["nombre"]." ".$rowi["apellido1"]." ".$rowi["apellido2"]."</option>";
					} else {
						echo "<option value=\"".$rowi["id"]."\">".$rowi["nombre"]." ".$rowi["apellido1"]." ".$rowi["apellido2"]."</option>";
					}
				}
			echo "</select></td>";
		} else {
			echo "<input type=\"Hidden\" value=\"".$_GET["id"]."\" name=\"id_cliente2\">";
		}
			echo "<td><select name=\"id_tipo2\" id=\"id_tipo2\" style=\"width:100px\" onchange=\"desplegableCombinado6()\">";
				if ($_POST["id_tipo2"] == 1){
					echo "<option value=\"0\">".$Todos."</option>";
					echo "<option value=\"1\" selected>".$Activos."</option>";
					echo "<option value=\"2\">".$No." ".$Activos."</option>";
				} elseif ($_POST["id_tipo2"] == 2){
					echo "<option value=\"0\">".$Todos."</option>";
					echo "<option value=\"1\">".$Activos."</option>";
					echo "<option value=\"2\" selected>".$No." ".$Activos."</option>";
				} else {
					echo "<option value=\"0\" selected>".$Todos."</option>";
					echo "<option value=\"1\">".$Activos."</option>";
					echo "<option value=\"2\">".$No." ".$Activos."</option>";
				}
			echo "</select></td>";
			echo "<td><select name=\"id_contrato2\" id=\"id_contrato2\" style=\"width:300px\" onchange=\"desplegableCombinado6()\">";
				if ($_GET["id"] <= 0) {
					echo "<option value=\"0\">".$Todos."</option>";
				}
				if ($_GET["id"] > 0) { $id_cli = $_GET["id"]; } else {$id_cli = $_POST["id_cliente2"]; }
				$sqlc = "select id,descripcion from sgm_contratos where visible=1 and id_cliente=".$id_cli;
				if ($_POST["id_tipo2"] == 1){ $sqlc .= " and activo=1";} elseif ($_POST["id_tipo2"] == 2){ $sqlc .= " and activo=0";}
				$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
				while ($rowc = mysqli_fetch_array($resultc)) {
					if ($_POST["id_contrato2"] == $rowc["id"]){
						echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["descripcion"]."</option>";
					} else {
						echo "<option value=\"".$rowc["id"]."\">".$rowc["descripcion"]."</option>";
					}
				}
			echo "</select></td>";
			$sqlco = "select * from sgm_contratos where id=".$_POST["id_contrato2"]." order by fecha_ini";
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			$rowco = mysqli_fetch_array($resultco);
			if ($rowco){
				$mes_ini = date("U",strtotime($rowco["fecha_ini"]));
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
				$mes_act = $mes_ini;
			} else {
				$count = 1;
				$sqlco2 = "select fecha_ini,fecha_fin from sgm_contratos where visible=1 and (id_plantilla<>0 or id_contrato_tipo<>0)";
				if ($_POST["id_cliente"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente2"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
				while ($rowco2 = mysqli_fetch_array($resultco2)){
					if ($count == 1) {
						$mes_ini = date("U",strtotime($rowco2["fecha_ini"])); $mes_fin = date("U",strtotime($rowco2["fecha_fin"])); $count ++;
					} else {
						if ($rowco2["fecha_ini"] < $mes_ini) {$mes_ini = date("U",strtotime($rowco2["fecha_ini"]));}
						if ($rowco2["fecha_fin"] > $mes_fin) {$mes_fin = date("U",strtotime($rowco2["fecha_fin"]));}
					}
				}
				$mes_act = $mes_ini;
			}
			echo "<td style=\"width:100px;\"><select name=\"fecha2\" style=\"width:150px;\" onchange=\"desplegableCombinado6()\">";

				while (($mes_ini<=$mes_act) and (($mes_act<=$mes_fin) and ($mes_act<=time()))){
					$any_inicio = date("Y",$mes_act);
					$mes_inicio = date("m",$mes_act);

					if ($_POST["fecha2"] == $mes_inicio."-".$any_inicio){
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
			$sqlco = "select * from sgm_contratos where id=".$_POST["id_contrato2"]." order by fecha_ini";
			$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
			$rowco = mysqli_fetch_array($resultco);
			if ($rowco){
				$mes_fin = date("U",strtotime($rowco["fecha_fin"]));
			} else {
				$mes_fin = 0;
				$count = 1;
				$sqlco2 = "select fecha_ini,fecha_fin from sgm_contratos where visible=1 and activo=1";
				if ($_POST["id_cliente2"] > 0) { $sqlco2.=" and id_cliente=".$_POST["id_cliente2"]; }
				$sqlco2.=" order by fecha_ini";
				$resultco2 = mysqli_query($dbhandle,convertSQL($sqlco2));
				while ($rowco2 = mysqli_fetch_array($resultco2)){
					if ($count == 1) {
						$mes_fin = date("U",strtotime($rowco2["fecha_fin"])); $count ++;
					} else {
						if ($rowco2["fecha_fin"] > $mes_fin) {$mes_fin = date("U",strtotime($rowco2["fecha_fin"]));}
					}
				}
			}

			$fecha_ini = date("U",strtotime("01-".$_POST["fecha2"]));
			if (($_POST["fecha2"] > 0) and ($fecha_ini > $mes_ini)){
				list($mes,$any) = explode ("-",$_POST["fecha2"]);
			} else {
				$any = date("Y",$mes_ini);
				$mes = date("m",$mes_ini);
			}
			$mes_ini2 = date("U",mktime(0,0,0,$mes+1,1,$any));

			$mes_act = $mes_ini2;
			echo "<td style=\"width:100px;\"><select name=\"fecha_hasta2\" style=\"width:150px;\">";
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
			echo "<td><input type=\"Submit\" value=\"".$Imprimir."\" style=\"width:100px\"></td>";
			echo "</form>";
		echo "</tr>";
	echo "</table>";
}

?>
