<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1025) AND ($autorizado == true)) {
	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<tr><td>";
			echo "<center><table><tr>";
				echo "<td style=\"height:20px;width:120px;\";><strong>".$Plan." :</strong></td>";
				if (($soption >= 0) and ($soption < 100)) { $color = "white"; $colorl = "blue"; } else { $color = "#4B53AF"; $colorl = "white"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1025&sop=0\" style=\"color:".$colorl."\">".$Planes."</a></td>";
				if (($soption >= 500) and ($soption < 600)) { $color = "white"; $colorl = "blue"; } else { $color = "#4B53AF"; $colorl = "white"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";color: white;border: 1px solid black\"><a href=\"index.php?op=1025&sop=500\" style=\"color:".$colorl."\">".$Administrar."</a></td>";
				echo "</tr></table>";
			echo "</center></td></tr>";
		echo "</table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 0) {
		if ($ssoption == 1) {
			if ($_POST["accion"] == 3){
				$sql = "select * from sgm_plan where visible=1 and id=".$_POST["id_version"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$multicuerpo = $row["multicuerpo"];
			} else {
				$multicuerpo = $_POST["multicuerpo"];
			}
			insertTablaPlanes($_POST["accion"], $multicuerpo);
		}
		if ($ssoption == 2) {updateTablaPlanes($_POST["nombre"]);}
		if ($ssoption == 3) {bajaTablaPlanes();}
		echo "<strong>".$Planes." : </strong>";
		echo "<br><br>";
		formTablaPlanes($option, $soption, "2", "3", "4", "1", "1");
	}

	if ($soption == 1) {
		confirmarEliminacion($option, "0");
	}

	if ($soption == 2) {
		echo "<strong>".$Plantillas." ".$Subplanes." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "0");
		formTablaSubplanes($option, "0");
	}

	if ($soption == 3) {
		echo "<strong>".$Plantillas." ".$Version." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "0");
		formTablaPlanesVersion($option, "0");
	}

	if ($soption == 500) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td><strong>".$Administrar." : &nbsp;&nbsp;</strong></td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1025&sop=510\" style=\"color:white;\">".$Tipo." ".$Planes."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1025&sop=520\" style=\"color:white;\">".$Relacion." ".$Planes."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1025&sop=530\" style=\"color:white;\">".$Plantillas." ".$Planes."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}

	if (($soption == 510) and ($admin == true)) {
		if ($ssoption == 1) {insertTablaAuxTipos("sgm_plan_tipos");}
		if ($ssoption == 2) {updateTablaAuxTipos("sgm_plan_tipos");}
		if ($ssoption == 3) {bajaTablaAuxTipos("sgm_plan_tipos","sgm_plan","id_plan_tipos");}
		echo "<strong>".$Tipos." ".$Planes." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "500");
		formTablaAuxTipos("sgm_plan_tipos",$option,$soption,"511","500");
	}

	if ($soption == 511) {
		confirmarEliminacion($option, "510");
	}

	if ($soption == 520) {
		if ($ssoption == 1) {insertTablaAuxTiposRelaciones("sgm_plan_tipos_relaciones");}
		if ($ssoption == 3) {deleteTablaAuxTiposRelaciones("sgm_plan_tipos_relaciones");}
		echo "<strong>".$Relaciones." ".$Tipos." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "500");
		formTablaAuxTiposRelaciones("sgm_plan_tipos","sgm_plan_tipos_relaciones", $option, $soption, "521", "500");
	}

	if ($soption == 521) {
		confirmarEliminacion($option, "520");
	}

	if (($soption == 530) and ($admin == true)) {
		if ($ssoption == 1) {insertTablaPlanes($_POST["accion"]);}
		if ($ssoption == 2) {updateTablaPlanes($_POST["nombre"]);}
		if ($ssoption == 3) {bajaTablaPlanes();}
		echo "<strong>".$Plantillas." ".$Planes." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "500");
		formTablaPlanes($option, $soption, "532", "533", "0", "531", "2");
	}

	if ($soption == 531) {
		confirmarEliminacion($option, "530");
	}

	if ($soption == 532) {
		echo "<strong>".$Plantillas." ".$Subplanes." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "530");
		formTablaSubplanes($option, "530");
	}

	if ($soption == 533) {
		echo "<strong>".$Plantillas." ".$Version." : </strong>";
		echo "<br><br>";
		botonVolverAdmin($option, "530");
		formTablaPlanesVersion($option, "530");
	}

	echo "</td></tr></table><br>";
}


function formTablaAuxTipos($tabla, $option, $soption, $soptionEliminar, $soptionAdmin)
{
	global $db;
	global $Eliminar, $Nombre, $Descripcion, $Anadir, $Modificar,$Volver;
	echo "<br><br>";
	echo "<center>";
	echo "<table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver\">";
			echo "<td>".$Eliminar."</td>";
			echo "<td style=\"text-align:center;\">".$Nombre."</td>";
			echo "<td style=\"text-align:center;\">".$Descripcion."</td>";
			echo "<td style=\"text-align:center;\">".$Mutable."</td>";
			echo "<td style=\"text-align:center;\">".$Clonable."</td>";
			echo "<td style=\"text-align:center;\">".$Cuerpo."</td>";
			echo "<td style=\"text-align:center;\">".$Plantilla."</td>";
			echo "<td style=\"text-align:center;\">".$Subplanes."</td>";
			echo "<td></td>";
		echo "</tr><tr>";
			echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=1\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"text\" style=\"width:100px\" name=\"nombre\"></td>";
			echo "<td><input type=\"text\" style=\"width:250px\" name=\"descripcion\"></td>";
			echo "<td><select name=\"mutable\" style=\"width:50px;\">";
				echo "<option value=\"1\">Si</option>";
				echo "<option value=\"0\">No</option>";
			echo "</select></td>";
			echo "<td><select name=\"clonable\" style=\"width:50px;\">";
				echo "<option value=\"1\">Si</option>";
				echo "<option value=\"0\">No</option>";
			echo "</select></td>";
			echo "<td><select name=\"cuerpo\" style=\"width:50px;\">";
				echo "<option value=\"1\">Si</option>";
				echo "<option value=\"0\">No</option>";
			echo "</select></td>";
			echo "<td><select name=\"plantilla\" style=\"width:50px;\">";
				echo "<option value=\"1\">Si</option>";
				echo "<option value=\"0\">No</option>";
			echo "</select></td>";
			echo "<td><select name=\"subplans\" style=\"width:50px;\">";
				echo "<option value=\"1\">Si</option>";
				echo "<option value=\"0\">No</option>";
			echo "</select></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
			echo "</form>";
		echo "</tr>";
		echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from ".$tabla." where visible=1 order by nombre";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$option."&sop=".$soptionEliminar."&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" value=\"".$row["nombre"]."\" style=\"width:100px\" name=\"nombre\"></td>";
				echo "<td><input type=\"text\" value=\"".$row["descripcion"]."\" style=\"width:250px\" name=\"descripcion\"></td>";
					echo "<td><select name=\"mutable\" style=\"width:50px\">";
						if ($row["mutable"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row["mutable"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"clonable\" style=\"width:50px\">";
						if ($row["clonable"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row["clonable"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"cuerpo\" style=\"width:50px\">";
						if ($row["cuerpo"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row["cuerpo"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"plantilla\" style=\"width:50px\">";
						if ($row["plantilla"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row["plantilla"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</select></td>";
					echo "<td><select name=\"subplans\" style=\"width:50px\">";
						if ($row["subplans"] == 0) {
							echo "<option value=\"0\" selected>No</option>";
							echo "<option value=\"1\">Si</option>";
						}
						if ($row["subplans"] == 1) {
							echo "<option value=\"0\">No</option>";
							echo "<option value=\"1\" selected>Si</option>";
						}
					echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
		}
	echo "</table>";
	echo "</center>";
}

function insertTablaAuxTipos($tabla)
{
	$sql = "insert into ".$tabla." (nombre,descripcion,mutable,clonable,cuerpo,plantilla,subplans) ";
	$sql = $sql."values (";
	$sql = $sql."'".comillas($_POST["nombre"])."'";
	$sql = $sql.",'".comillas($_POST["descripcion"])."'";
	$sql = $sql.",".$_POST["mutable"]."";
	$sql = $sql.",".$_POST["clonable"]."";
	$sql = $sql.",".$_POST["cuerpo"]."";
	$sql = $sql.",".$_POST["plantilla"]."";
	$sql = $sql.",".$_POST["subplans"]."";
	$sql = $sql.")";
	mysql_query(convert_sql($sql));
}

function updateTablaAuxTipos($tabla)
{
	$sql = "update ".$tabla." set ";
	$sql = $sql."nombre='".comillas($_POST["nombre"])."'";
	$sql = $sql.",descripcion='".comillas($_POST["descripcion"])."'";
	$sql = $sql.",mutable=".$_POST["mutable"]."";
	$sql = $sql.",clonable=".$_POST["clonable"]."";
	$sql = $sql.",cuerpo=".$_POST["cuerpo"]."";
	$sql = $sql.",plantilla=".$_POST["plantilla"]."";
	$sql = $sql.",subplans=".$_POST["subplans"]."";
	$sql = $sql." WHERE id=".$_GET["id"]."";
	mysql_query(convert_sql($sql));
}

function bajaTablaAuxTipos($tabla,$tabla2,$id)
{
	global $errorEliminar;
	$sqlc = "select count(*) as total from ".$tabla2." where visible=1 and ".$id."=".$_GET["id"];
	$resultc = mysql_query(convert_sql($sqlc));
	$rowc = mysql_fetch_array($resultc);
	if ($rowc["total"] > 0){
		mensaje_error($errorEliminar);
	} else {
		$sql = "update ".$tabla." set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
	}
}

function formTablaPlanes($option, $soption, $soptionSubplanes, $soptionVersiones, $soptionTraspaso, $soptionEliminar, $accion)
{
	global $db;
	global $Eliminar, $Nombre, $Plantilla, $Tipos, $Plan, $Anadir, $Subplan,$Version, $de, $Modificar, $Versionar, $Traspasar;
	echo "<center>";
	echo "<table cellspacing=\"0\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td>".$Eliminar."</td>";
			echo "<td>".$Nombre."</td>";
		if ($accion == 1) { echo "<td>".$Plantilla."</td>";}
			echo "<td>".$Tipos." ".$Plan."</td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=1\" method=\"post\">";
		echo "<tr>";
			echo "<td></td>";
			echo "<td><input type=\"text\" style=\"width:300px\" name=\"nombre\"></td>";
		if ($accion == 1) { 
			echo "<td><select name=\"id_plantilla\" style=\"width:200px;\">";
				echo "<option value=\"0\">-</option>";
				$sql = "select * from sgm_plan where visible=1 and id_plantilla=0 and id_plan=0 order by nombre";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					echo "<option value=\"".$row["id"]."\">".$row["nombre"]."</option>";
				}
			echo "</select></td>";
			echo "<input type=\"Hidden\"  name=\"accion\" value=\"4\">";
		} else {
			echo "<input type=\"Hidden\"  name=\"accion\" value=\"1\">";
		}
			echo "<td><select name=\"id_plan_tipo\" style=\"width:300px;\">";
				echo "<option value=\"0\">-</option>";
				$sqlpt = "select * from sgm_plan_tipos where visible=1 order by nombre";
				$resultpt = mysql_query(convert_sql($sqlpt));
				while ($rowpt = mysql_fetch_array($resultpt)) {
					echo "<option value=\"".$rowpt["id"]."\">".$rowpt["nombre"]."</option>";
				}
			echo "</select></td>";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:100px\"></td>";
		echo "</tr>";
		echo "</form>";
		echo "<tr><td>&nbsp;</td></tr>";
		$sql = "select * from sgm_plan where visible=1";
		if ($accion == 1) { $sql .= " and id_plantilla<>0";}
		if ($accion == 2) { $sql .= " and id_plantilla=0";}
		$sql .= " order by nombre";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$option."&sop=".$soptionEliminar."&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<form action=\"index.php?op=".$option."&sop=".$soption."&ssop=2&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"text\" style=\"width:300px\" name=\"nombre\" value=\"".$row["nombre"]."\"></td>";
				$sqlp = "select * from sgm_plan where visible=1 and id=".$row["id_plan"];
				$resultp = mysql_query(convert_sql($sqlp));
				$rowp = mysql_fetch_array($resultp);
				echo "<td style=\"width:300px\">".$rowp["nombre"]."</td>";
				$sqlp = "select * from sgm_plan where visible=1 and id=".$row["id_version"];
				$resultp = mysql_query(convert_sql($sqlp));
				$rowp = mysql_fetch_array($resultp);
				echo "<td style=\"width:100px\">".$rowp["nombre"]."</td>";
				if ($row["id_plan_tipo"] == 1){ $idPlanTipo = "Si";} else { $idPlanTipo = "No";}
				echo "<td style=\"text-align:center;width:100px;\">".$idPlanTipo."</td>";
				echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px\"></td>";
				echo "</form>";

				echo "<form action=\"index.php?op=".$option."&sop=".$soptionVersiones."&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Submit\" value=\"".$Versionar."\" style=\"width:100px\"></td>";
				echo "</form>";

			if ($accion == 1) { 
				echo "<form action=\"index.php?op=".$option."&sop=".$soptionTraspaso."&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Submit\" value=\"".$Traspasar."\" style=\"width:100px\"></td>";
				echo "</form>";
			} else {
				echo "<form action=\"index.php?op=".$option."&sop=".$soptionSubplanes."&id=".$row["id"]."\" method=\"post\">";
				echo "<td><input type=\"Submit\" value=\"".$Subplanes."\" style=\"width:100px\"></td>";
				echo "</form>";
			}
			echo "</tr>";
		}
	echo "</table>";
	echo "</center>";
}

function insertTablaPlanes($accion, $multicuerpo)
{
	if ($accion == 1) {$sql = "insert into sgm_plan (nombre,id_plan_tipo) ";}
	if ($accion == 2) {$sql = "insert into sgm_plan (nombre,id_plan,id_plan_tipo) ";}
	if ($accion == 3) {$sql = "insert into sgm_plan (nombre,id_version,id_plan_tipo) ";}
	if ($accion == 4) {$sql = "insert into sgm_plan (nombre,id_plantilla,id_plan_tipo) ";}
	$sql = $sql."values (";
	$sql = $sql."'".comillas($_POST["nombre"])."'";
	if ($accion == 2) {$sql = $sql.",".$_POST["id_plan"];}
	if ($accion == 3) {$sql = $sql.",".$_POST["id_version"];}
	if ($accion == 4) {$sql = $sql.",".$_POST["id_plantilla"];}
	$sql = $sql.",".$_POST["id_plan_tipo"];
	$sql = $sql.")";
	mysql_query(convert_sql($sql));
echo $sql;

	if ($accion == 3) {
		$sqlp1 = "select * from sgm_plan where visible=1 order by id desc";
		$resultp1 = mysql_query(convert_sql($sqlp1));
		$rowp1 = mysql_fetch_array($resultp1);
		$sqlp = "select * from sgm_plan where visible=1 and id_plan =".$_POST["id_version"];
		$resultp = mysql_query(convert_sql($sqlp));
		while ($rowp = mysql_fetch_array($resultp)) {
			$sql = "insert into sgm_plan (nombre,id_plan,id_version,multicuerpo) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($rowp["nombre"])."'";
			$sql = $sql.",".$rowp1["id"];
			$sql = $sql.",".$rowp["id"];
			$sql = $sql.",".$rowp["multicuerpo"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
	}
	if ($accion == 4) {
		$sqlp1 = "select * from sgm_plan where visible=1 order by id desc";
		$resultp1 = mysql_query(convert_sql($sqlp1));
		$rowp1 = mysql_fetch_array($resultp1);
		$sqlp = "select * from sgm_plan where visible=1 and id_plan =".$_POST["id_plantilla"];
		$resultp = mysql_query(convert_sql($sqlp));
		while ($rowp = mysql_fetch_array($resultp)) {
			$sql = "insert into sgm_plan (nombre,id_plan,id_plantilla,multicuerpo) ";
			$sql = $sql."values (";
			$sql = $sql."'".comillas($rowp["nombre"])."'";
			$sql = $sql.",".$rowp1["id"];
			$sql = $sql.",".$rowp["id"];
			$sql = $sql.",".$rowp["multicuerpo"];
			$sql = $sql.")";
			mysql_query(convert_sql($sql));
		}
	}
}

function updateTablaPlanes($nombre)
{
	$sql = "update sgm_plan set ";
	$sql = $sql."nombre='".$nombre."'";
	$sql = $sql." WHERE id=".$_GET["id"]."";
	mysql_query(convert_sql($sql));
}

function bajaTablaPlanes()
{
	$sqlp = "select * from sgm_plan where visible=1 and (id_plan=".$_GET["id"]." or id_version=".$_GET["id"]." or id_plantilla=".$_GET["id"].")";
	$resultp = mysql_query(convert_sql($sqlp));
	$rowp = mysql_fetch_array($resultp);
	if (!$rowp){
		$sql = "update sgm_plan set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		mysql_query(convert_sql($sql));
	} else {
		echo mensaje_error_c("no se puede eliminar el elemento que contiene subelementos","red");
	}
}

function formTablaSubplanes($option, $soptionInsert)
{
	global $db;
	global $Nombre, $Permitir, $Subplanes, $Anadir;
	echo "<center>";
	echo "<table cellspacing=\"0\">";
		echo "<form action=\"index.php?op=".$option."&sop=".$soptionInsert."&ssop=1\" method=\"post\">";
		echo "<tr>";
			echo "<td style=\"text-align:right;\">".$Nombre." :</td>";
			echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
		echo "</tr><tr>";
			echo "<td style=\"text-align:right;\">".$Permitir." ".$Subplanes." :</td>";
			echo "<td><select name=\"multicuerpo\" style=\"width:150px;\">";
				echo "<option value=\"0\">No</option>";
				echo "<option value=\"1\">Si</option>";
			echo "</select></td>";
		echo "</tr><tr>";
			echo "<td></td>";
			echo "<input type=\"Hidden\" name=\"id_plan\" value=\"".$_GET["id"]."\">";
			echo "<input type=\"Hidden\" name=\"accion\" value=\"2\">";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
		echo "</tr>";
		echo "</form>";
	echo "</table>";
	echo "</center>";
}

function formTablaPlanesVersion($option, $soptionInsert)
{
	global $db;
	global $Nombre, $Anadir;
	echo "<center>";
	echo "<table cellspacing=\"0\">";
		echo "<form action=\"index.php?op=".$option."&sop=".$soptionInsert."&ssop=1\" method=\"post\">";
		echo "<tr>";
			echo "<td style=\"text-align:right;\">".$Nombre." :</td>";
			echo "<td><input type=\"text\" style=\"width:150px\" name=\"nombre\"></td>";
		echo "</tr><tr>";
			echo "<td></td>";
			echo "<input type=\"Hidden\" name=\"id_version\" value=\"".$_GET["id"]."\">";
			echo "<input type=\"Hidden\" name=\"accion\" value=\"3\">";
			echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
		echo "</tr>";
		echo "</form>";
	echo "</table>";
	echo "</center>";
}

?>
