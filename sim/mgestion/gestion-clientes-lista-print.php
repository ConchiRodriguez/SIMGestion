<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../config.php");
	include ("../auxiliar/functions.php");
	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}

if ($_COOKIE["username"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			if ($row["pass"] == $_POST["pass"]) {
				setcookie("username", $_POST["user"], time()+86400*$cookiestime, "/", $domain);
				setcookie("password", md5( $row["pass"] ), time()+86400*$cookiestime, "/", $domain);
				header("Location: ".$urloriginal."/index.php?op=200");
			}
		}
	}
}
else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ( md5( $row["pass"] ) == $_COOKIE["password"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
		}
	}
}

?>
<html>
<head>
		<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<?php

$autorizado = false;
if ($user == true) {

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = $db->sql_query($sqlsgm);
		$rowsgm = $db->sql_fetchrow($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }

		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowi["id_cliente"]." and id_user=".$userid;
		$resultpermiso = $db->sql_query($sqlpermiso);
		$rowpermiso = $db->sql_fetchrow($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }

}
if ($autorizado == true) {
	echo "<table width=\"600px\" cellpadding=\"10px\" cellspacing=\"10px\"><tr><td><center>";
	echo "<strong>Listado</strong>";
	echo "<br><br><br>";
	echo "<table cellpadding=\"10px\" cellspacing=\"0px\" width=\"100%\">";
		echo "<tr style=\"background-color: Silver;\">";
			echo "<td style=\"width:20px;text-align:center;\"><em>num</em></td>";
			echo "<td style=\"width:180px;text-align:center;\"><em>nombre</em></td>";
			echo "<td style=\"width:100px;text-align:center;\"><em>dirección</em></td>";
			echo "<td style=\"width:90px;text-align:center;\"><em>población</em></td>";
			echo "<td style=\"width:70px;text-align:center;\"><em>c. postal</em></td>";
			echo "<td style=\"width:70px;text-align:center;\"><em>provincia</em></td>";
			echo "<td style=\"width:70px;text-align:center;\"><em>teléfono</em></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
		echo "</tr>";
		$i = 1;
		$sql = $_GET["sql"];
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".$row["nombre"]."</td>";
			echo "<td>".$row["direccion"]."</td>";
			echo "<td>".$row["poblacion"]."</td>";
			echo "<td>".$row["cp"]."</td>";
			echo "<td>".$row["provincia"]."</td>";
			echo "<td>".$row["telefono"]."</td>";
			echo "</tr>";
			$i ++;
		}
	echo "</table>";
	echo "</center></td></tr></table>";
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}

?>


</body>
</html>