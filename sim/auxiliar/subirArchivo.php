<?php
error_reporting(~E_ALL);

function subirArchivo($tipo, $archivo, $archivo_name, $archivo_size, $archivo_type,$id_tipo,$id) {
	global $db,$errorSubirArchivoDuplicado,$errorSubirArchivoTamany;
	
	if ($id_tipo == 0) {$adress = "facturas/";}
	if ($id_tipo == 1) {$adress = "articulos/";}
	if ($id_tipo == 2) {$adress = "clientes/";}
	if ($id_tipo == 3) {$adress = "contratos/";}
	if ($id_tipo == 4) {$adress = "incidencias/";}
	if ($id_tipo == 5) {$adress = "dispositivos/";}
	if ($id_tipo == 6) {$adress = "empleados/";}

	$sql = "select * from sgm_files_tipos where id=".$tipo;
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);
	$lim_tamano = $row["limite_kb"]*1000;
	$sqlt = "select count(*) as total from sgm_files where visible=1 and name='".$archivo_name."'";
	$resultt = mysql_query(convertSQL($sqlt));
	$rowt = mysql_fetch_array($resultt);
	if ($rowt["total"] != 0) {
		echo mensageError($errorSubirArchivoDuplicado);
	} else {
		if (($archivo != "none") AND ($archivo_size != 0) AND ($archivo_size<=$lim_tamano)){
			if (copy ($archivo, "archivos/".$adress.$archivo_name)) {
				$camposInsert = "id_tipo,name,type,size,id_elemento,tipo_id_elemento";
				$datosInsert = array($tipo,$archivo_name,$archivo_type,$archivo_size,$id,$id_tipo);
				insertFunction ("sgm_files",$camposInsert,$datosInsert);
			}
		}else{
			echo mensageError($errorSubirArchivoTamany);
		}
	}
}

?>