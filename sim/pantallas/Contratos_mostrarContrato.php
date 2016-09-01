<?php
error_reporting(~E_ALL);


function mostrarContrato ($id_contrato,$id_cliente){
	global $db,$dbhandle,$option,$soption,$ssoption,$idioma;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

	if ($id_cliente > 0){ $contrato_adress = $id_cliente."&id_con=".$id_contrato;} else { $contrato_adress = $id_contrato;}
	$contract = $id_contrato;
	
	if ($ssoption == 2) {
		$camposUpdate = array("num_contrato","id_contrato_tipo","id_cliente","id_cliente_final","fecha_ini","fecha_fin","descripcion","id_responsable","id_tecnico","id_tarifa");
		$datosUpdate = array($_POST["num_contrato"],$_POST["id_contrato_tipo"],$_POST["id_cliente"],$_POST["id_cliente_final"],$_POST["fecha_ini"],$_POST["fecha_fin"],$_POST["descripcion"],$_POST["id_responsable"],$_POST["id_tecnico"],$_POST["id_tarifa"]);
		updateFunction ("sgm_contratos",$_POST["id_contrato"],$camposUpdate,$datosUpdate);
	}

	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		if ($id_contrato != "") {
			echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=2&id=".$contrato_adress."\" method=\"post\">";
			$sqlc = "select * from sgm_contratos where visible=1 and id=".$id_contrato;
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			$numeroc = $rowc["num_contrato"];
			echo "<input type=\"Hidden\" name=\"id_contrato\" value=\"".$id_contrato."\">";
		} else {
			echo "<form action=\"index.php?op=".$option."&sop=100&ssop=1\" method=\"post\">";
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
		echo "<tr>";
			echo "<td style=\"text-align:right;\">".$Tarifa.": </td>";
			echo "<td><select style=\"width:500px\" name=\"id_tarifa\">";
				echo "<option value=\"0\">-</option>";
				$sqlt = "select id,nombre from sgm_tarifas where visible=1";
				$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
				while ($rowt = mysqli_fetch_array($resultt)){
					if ($rowt["id"] == $rowc["id_tarifa"]){
						echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nombre"]."</option>";
					} else {
						echo "<option value=\"".$rowt["id"]."\">".$rowt["nombre"]."</option>";
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
		if ($id_contrato != "") {
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
		if ($id_contrato != "") {
			echo "<td></td><td><input type=\"Submit\" style=\"width:100px\" value=\"".$Editar."\"></td>";
		} else {
			echo "<td></td><td><input type=\"Submit\" style=\"width:100px\" value=\"".$Anadir."\"></td>";
		}
		echo "</form>";
	echo "</table>";
}

?>