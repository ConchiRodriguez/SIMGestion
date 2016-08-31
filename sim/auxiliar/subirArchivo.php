<?php
error_reporting(~E_ALL);

function subirArchivo($tipo, $archivo, $archivo_name, $archivo_size, $archivo_type,$id_tipo,$id) {
	global $db,$dbhandle,$errorSubirArchivoDuplicado,$errorSubirArchivoTamany,$urlmgestion;
	
	if ($id_tipo == 0) {$adress = "facturas/";}
	if ($id_tipo == 1) {$adress = "articulos/";}
	if ($id_tipo == 2) {$adress = "clientes/";}
	if ($id_tipo == 3) {$adress = "contratos/";}
	if ($id_tipo == 4) {$adress = "incidencias/";}
	if ($id_tipo == 5) {$adress = "dispositivos/";}
	if ($id_tipo == 6) {$adress = "empleados/";}

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
		$adr = "http://www.solucions-im.net/sim/";
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
#		echo $adr."archivos/".$adress.$archivo_name."<br>";
			if (copy ($archivo, $adr."archivos/".$adress.$archivo_name)) {
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