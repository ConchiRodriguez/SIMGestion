<form name="enviador" method="post" action="ftp-connect.php" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1000">
Archivo: <input type="file" name="archivo">
<input type="submit">
<?php
$ftp_server="ftp.solucions-im.net";
$ftp_user_name="solucions-im.net";
$ftp_user_pass="Solucions69";
// establecer una conexión básica
$conn_id = ftp_connect($ftp_server); 

// iniciar una sesión con nombre de usuario y contraseña
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

// verificar la conexión
if ((!$conn_id) || (!$login_result)) {  
    echo "¡La conexión FTP ha fallado!<br>";
    echo "Se intentó conectar al $ftp_server por el usuario $ftp_user_name<br>"; 
    exit; 
} else {
    echo "Conexión a $ftp_server realizada con éxito, por el usuario $ftp_user_name<br>";
}

// subir un archivo
$remote_file = './data/simdocs/csms/'.$_FILES["archivo"]["name"];
$local_file = $_FILES["archivo"]["tmp_name"];
echo $_FILES["archivo"]["tmp_name"];
if (ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY)) {
echo 'El archivo ' . $local_file . ' se ha cargado en el servidor remoto.' . "\n";
} else {
echo 'El archivo ' . $local_file . ' NO se ha cargado en el servidor remoto.' . "\n";
}



echo "<br><br><br>";
function rawlist_dump($path) {
  global $conn_id ;
  $ftp_rawlist = ftp_rawlist($conn_id , $path);
  foreach ($ftp_rawlist as $v) {
    $info = array();
    $vinfo = preg_split("/[\s]+/", $v, 9);
    if ($vinfo[0] !== "total") {
      $info['chmod'] = $vinfo[0];
      $info['num'] = $vinfo[1];
      $info['owner'] = $vinfo[2];
      $info['group'] = $vinfo[3];
      $info['size'] = $vinfo[4];
      $info['month'] = $vinfo[5];
      $info['day'] = $vinfo[6];
      $info['time'] = $vinfo[7];
      $info['name'] = $vinfo[8];
      $rawlist[$info['name']] = $info;
    }
  }
  $dir = array();
  $file = array();
  foreach ($rawlist as $k => $v) {
    if ($v['chmod']{0} == "d") {
      $dir[$k] = $v;
    } elseif ($v['chmod']{0} == "-") {
      $file[$k] = $v;
    }
  }
  foreach ($dir as $dirname => $dirinfo) {
      echo "[ $dirname ] " . $dirinfo['chmod'] . " | " . $dirinfo['owner'] . " | " . $dirinfo['group'] . " | " . $dirinfo['month'] . " " . $dirinfo['day'] . " " . $dirinfo['time'] . "<br>";
      rawlist_dump($path."/".$dirname);
  }
  foreach ($file as $filename => $fileinfo) {
      echo "$filename " . $fileinfo['chmod'] . " | " . $fileinfo['owner'] . " | " . $fileinfo['group'] . " | " . $fileinfo['size'] . " Byte | " . $fileinfo['month'] . " " . $fileinfo['day'] . " " . $fileinfo['time'] . "<br>";
  }
}
rawlist_dump("./data/simdocs/csms");

// cerrar la conexión ftp 

ftp_close($conn_id);


?>
