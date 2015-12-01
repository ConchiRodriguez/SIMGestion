<?php
include ("config.php");
setcookie("username", "", time()+60*$cookiestime, "/sim", $domain);
setcookie("password", "", time()+60*$cookiestime, "/sim", $domain);
header("Location: ".$urloriginal."");
?>