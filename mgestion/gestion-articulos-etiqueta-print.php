<?php 

if ($option == 600){


error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../config.php");
	include ("../auxiliar/functions.php");
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
<style type="text/css" media="print">
.nover {display:none}
</style>
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
	if ($_POST["codigo"] > 0){
		$sqli = "select * from sgm_tamany_paper where visible=1 and id=".$_POST["tamany"];
		$resulti = mysql_query(convert_sql($sqli));
		$rowi = mysql_fetch_array($resulti);

		$sqlf = "select * from sgm_articles where codigo=".$_POST["codigo"];
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);

		$sqls = "select * from sgm_stock where vigente=1 and id_article=".$rowf["id"];
		$results = mysql_query(convert_sql($sqls));
		$rows = mysql_fetch_array($results);

		echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:".$rowi["x"]."cm;height:".$rowi["y"]."cm;border:0px black solid;\">";
			echo "<tr>";
				echo "<td style=\"width:50%;\"></td>";
				echo "<td style=\"width:25%;\">";
					echo "<table>";
						echo "<tr>";
							echo "<td style=\"vertical-align:top;text-align:right;font: normal bold;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 2.1mm;text-align:center\">".$rowf["nom_etiq"]."</td>";
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;text-align:right;font-family:C39HrP24DlTt; font-size : 2.6mm;text-align:center\">".$rowf["codigo"]."</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td><td style=\"width:25%;\">";
					echo "<table>";
						$pvp = $rows["pvp"] * 166.386;
						if ($rowf["web"] == 0){$ptas = "pts";} else {$ptas = "PTS";}
						echo "<tr>";
							echo "<td style=\"vertical-align:top;text-align:right;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 2.1mm;text-align:center\">".$pvp." ".$ptas."</td>";
						echo "</tr><tr>";
							echo "<td style=\"vertical-align:top;text-align:right;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 2.6mm;text-align:center\">".$rows["pvp"]." €</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table><tr><td>";
		echo "<form>";
			echo "<input type=\"Button\" class=\"nover\" onclick=\"javascript:print()\" value=\"Imprimir\">";
		echo "</form>";
		echo "</td></tr></table>";
	}
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}


}
?>


</body>
</html>
