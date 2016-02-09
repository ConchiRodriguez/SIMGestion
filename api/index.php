<?php

#include ("config.php");

#$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
#$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

header('Content-type: text/html');
echo $_POST['USER']."xxxx<br>";
echo $_POST['XmlData']."xxxx<br>";
header('Content-type: application/json');
echo json_encode($_POST['XmlData']);

// Cerrar la conexión
#mysql_close($dbhandle);
?>