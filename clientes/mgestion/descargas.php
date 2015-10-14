<?php

$ftp_server="ftp.solucions-im.net";
$ftp_user_name="solucions-im.net";
$ftp_user_pass="Solucions69";
// establecer una conexión básica
$conn_id = ftp_connect($ftp_server); 

// iniciar una sesión con nombre de usuario y contraseña
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

$local_file = "../temp/".$_GET['file']."";
#echo "<br>";
$server_file = "".$_GET['dir']."/".$_GET['file']."";
#echo "<br>";


if (ftp_get($conn_id,$local_file,$server_file,FTP_BINARY)){
#	echo "tot be";
} else {
#	echo "tot malament";
}


if (!isset($_GET['file']) || empty($_GET['file'])) {
	exit();
}
$root = "../temp/";
$file = $_GET['file'];
$path = $root.$file;
#echo "<br>";

$type = '';

if (is_file($path)) {
	$size = filesize($path);
	if (function_exists('mime_content_type')) {
		$type = mime_content_type($path);
	} else if (function_exists('finfo_file')) {
		$info = finfo_open(FILEINFO_MIME);
		$type = finfo_file($info, $path);
		finfo_close($info);
	}
	if ($type == '') {
		$type = "application/force-download";
	}
	// Definir headers
	header("Content-Type: $type");
	header("Content-Disposition: attachment; filename=$file");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . $size);
	// Descargar archivo
	readfile($path);
} else {
	die("El archivo no existe.");
}
unlink($path);
?>