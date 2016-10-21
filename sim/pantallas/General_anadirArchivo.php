<?php
error_reporting(~E_ALL);


function anadirArchivo ($id_elemento,$tipo_elemento,$url_adicional){
	global $db,$dbhandle,$idioma,$urloriginal,$option,$soption,$ssoption;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

	if ($tipo_elemento == 0) {$adress = "facturas/";}
	if ($tipo_elemento == 1) {$adress = "articulos/";}
	if ($tipo_elemento == 2) {$adress = "clientes/";}
	if ($tipo_elemento == 3) {$adress = "contratos/";}
	if ($tipo_elemento == 4) {$adress = "incidencias/";}
	if ($tipo_elemento == 5) {$adress = "dispositivos/";}
	if ($tipo_elemento == 6) {$adress = "empleados/";}
	if ($tipo_elemento == 7) {$adress = "comercial/";}

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
		subirArchivo($tipo,$archivo,$archivo_name,$archivo_size,$archivo_type,$tipo_elemento,$id_elemento,$adress);
	}
	if ($ssoption == 2) {
		$sqlf = "select name from sgm_files where id=".$_GET["id_archivo"];
		$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
		$rowf = mysqli_fetch_array($resultf);
		deleteFunction ("sgm_files",$_GET["id_archivo"]);
		$filepath = "archivos/".$adress.$rowf["name"];
		unlink($filepath);
	}
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
		echo "<tr>";
			echo "<td style=\"width:70%;vertical-align:top;\">";
				echo "<h4>".$Archivos." :</h4>";
				echo "<table>";
				$sql = "select id,nombre from sgm_files_tipos order by nombre";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)) {
					$sqlele = "select id,name,size from sgm_files where id_tipo=".$row["id"]." and tipo_id_elemento=".$tipo_elemento." and id_elemento=".$id_elemento;
					$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
					while ($rowele = mysqli_fetch_array($resultele)) {
						echo "<tr>";
							echo "<td style=\"text-align:center;\"><a href=\"index.php?op=".$option."&sop=".($soption+1)."&id=".$id_elemento."&id_archivo=".$rowele["id"].$url_adicional."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
							echo "<td style=\"text-align:right;\">".$row["nombre"]."</td>";
							echo "<td><a href=\"".$urloriginal."/archivos/".$adress.$rowele["name"]."\" target=\"_blank\"><strong>".$rowele["name"]."</a></strong>";
							echo "</td><td style=\"text-align:right;\">".round(($rowele["size"]/1000), 1)." Kb</td>";
						echo "</tr>";
					}
				}
				echo "</table>";
			echo "</td>";
			echo "<td style=\"width:350px;vertical-align:top;\">";
				echo "<h4>".$Formulario_Subir_Archivo." :</h4>";
				echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=".$option."&sop=".$soption."&ssop=1&id=".$id_elemento.$url_adicional."\" method=\"post\">";
				echo "<table>";
					echo "<tr>";
						echo "<td><select name=\"id_tipo\" style=\"width:300px\">";
							$sql = "select id,nombre,limite_kb from sgm_files_tipos order by nombre";
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

function subirArchivo($tipo, $archivo, $archivo_name, $archivo_size, $archivo_type,$id_tipo,$id,$adress) {
	global $db,$dbhandle,$idioma;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

	
#	echo $archivo_name." - ".$archivo_size." - ".$archivo_type." - ".$id_tipo."<br>";

	if ($tipo == 0){
		$tipo1 = explode("/",$archivo_type);
		$sql = "select * from sgm_files_tipos where nombre like '%".$tipo1[1]."%'";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if (!$row){
			$sql = "select * from sgm_files_tipos where nombre like '%".$tipo1[0]."%'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
		}
		$lim_tamano = $row["limite_kb"]*1000;
	} else {
		$sql = "select * from sgm_files_tipos where id=".$tipo;
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		$lim_tamano = $row["limite_kb"]*1000;
	}
	$sqlt = "select count(*) as total from sgm_files where visible=1 and name='".$archivo_name."'";
	$resultt = mysqli_query($dbhandle,convertSQL($sqlt));
	$rowt = mysqli_fetch_array($resultt);
	if ($rowt["total"] != 0) {
		echo mensageError($errorSubirArchivoDuplicado);
	} else {
		if (($archivo != "none") AND ($archivo_size != 0) AND (($archivo_size/1024)<=$lim_tamano)){
			if (copy ($archivo, $adr."archivos/".$adress.$archivo_name)) {
				$camposInsert = "id_tipo,name,type,size,id_elemento,tipo_id_elemento";
				$datosInsert = array($tipo,$archivo_name,$archivo_type,$archivo_size,$id,$id_tipo);
				insertFunction ("sgm_files",$camposInsert,$datosInsert);
			} else {
				echo mensageError("Error subir archivo");
			}
		}else{
			echo mensageError($errorSubirArchivoTamany);
		}
	}
}

?>