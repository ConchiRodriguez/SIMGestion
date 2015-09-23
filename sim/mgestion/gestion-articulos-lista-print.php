<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../../archivos_comunes/config.php");	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
	$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}

if ($_COOKIE["username"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
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
	$result = mysql_query(convert_sql($sql));
	$row = mysql_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
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
		<STYLE>

<?php 
if 	(ereg("MSIE", $_SERVER['HTTP_USER_AGENT'])) {
		echo ".saltopagina {";
		echo "PAGE-BREAK-AFTER: always;";
		echo "height:0px; line-height:0px;";
		echo "}";
} else {
		echo ".saltopagina {";
		echo "PAGE-BREAK-AFTER: always;";
		echo "}";
}
?>



</STYLE>
</head>
<body style="padding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;">

<?php

$autorizado = false;
if ($user == true) {
		$sqlcabezera = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultcabezera = mysql_query(convert_sql($sqlcabezera));
		$rowcabezera = mysql_fetch_array($resultcabezera);

		$sqlsgm = "select * from sgm_users where id=".$userid;
		$resultsgm = mysql_query(convert_sql($sqlsgm));
		$rowsgm = mysql_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }

		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowcabezera["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysql_query(convert_sql($sqlpermiso));
		$rowpermiso = mysql_fetch_array($resultpermiso);
		if ($rowpermiso["total"] >= 1) { $autorizado = true; }

}

$autorizado = true;
if ($autorizado == true) {
	if ($_POST["subfamilia"] > 0){ 
		$sqlsf = "select * from sgm_articles_subgrupos where id=".$_POST["subfamilia"];
		$resultsf = mysql_query(convert_sql($sqlsf));
		$rowsf = mysql_fetch_array($resultsf);

		$sqlf = "select * from sgm_articles_grupos where id=".$rowsf["id_grupo"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
		echo "<strong>Listado de Articulos de la Familia : ".$rowf["grupo"]." - ".$rowsf["subgrupo"]."</strong><br><br>";
	} else {
		echo "<strong>Listado de Articulos</strong><br><br>";
	}
	echo "<table cellspacing=\"0\" style=\"width:650px;border:0px;\">";
		echo "<tr style=\"background-color:silver;\">";
			echo "<td>Codigo</td>";
			echo "<td>Unidades</td>";
			echo "<td>Nombre</td>";
			echo "<td>Codigo Antiguo</td>";
			echo "<td>Coste</td>";
			echo "<td>Venta</td>";
		echo "</tr>";
		$sql = "select * from sgm_articles where visible=1 ";
		if ($_POST["subfamilia"] > 0){ $sql = $sql."and id_subgrupo=".$_POST["subfamilia"];	}
		$sql = $sql." order by codigo2";
		$result = mysql_query(convert_sql($sql));
		while ($row = mysql_fetch_array($result)) {
			$sqls = "select * from sgm_stock WHERE vigente=1 and id_article=".$row["id"];
			$results = mysql_query(convert_sql($sqls));
			$rows = mysql_fetch_array($results);
			echo "<tr><td>".$row["codigo"]."</td><td>".$rows["unidades"]."</td><td>".$row["nombre"]."</td><td>".$row["codigo2"]."</td><td>".$rows["pvd"]."</td><td>".$rows["pvp"]."</td></tr>";
		}
	echo "</table>";
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>


</body>
</html>
