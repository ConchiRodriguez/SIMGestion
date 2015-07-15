<?php
include ("../archivos_comunes/config.php");
setcookie("username", "", time()+60*$cookiestime, "/", $domain);
setcookie("password", "", time()+60*$cookiestime, "/", $domain);
header("Location: ".$urloriginal."");
?>