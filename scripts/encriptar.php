<?php
include ("config.php");
include ("auxiliar/functions.php");
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

		$sqlt = "select id,pass from sgm_users";
		$resultt = mysql_query(convert_sql($sqlt));
		while ($rowt = mysql_fetch_array($resultt)){
			echo $sqlt."<br>";
			$contrasena = crypt($rowt["pass"]);
			$sql = "update sgm_users set ";
			$sql = $sql."pass='".$contrasena."'";
			$sql = $sql." WHERE id=".$rowt["id"]."";
			mysql_query(convert_sql($sql));
			echo $sql."<br>";
		}
?>
