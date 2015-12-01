<?php 
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

if ($_COOKIE["username"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
		$row = mysql_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysql_query(convertSQL($sql));
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
	$result = mysql_query(convertSQL($sql));
	$row = mysql_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["username"]."' AND validado=1 AND activo=1";
		$result = mysql_query(convertSQL($sql));
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
</head>
<body>

<table style="border:0px"><tr><td style="width:600px;text-align:center;border:0px">
<?php

$autorizado = true;

if ($autorizado == true) {

		$sqlf = "select * from sgm_cabezera where id=".$_GET["id"];
		$resultf = mysql_query(convertSQL($sqlf));
		$rowf = mysql_fetch_array($resultf);

		echo "<table style=\"width:640px\" cellpadding=\"2\" cellspacing=\"2\" ><tr><td style=\"width:50px;vertical-align : top;text-align:left;\">";
#				echo "<strong>Pieza : </strong>".$rowp["nombre"];
	#			echo "<br><strong>Unidades : </strong>".number_format($rowp["unidades"],2,',','.');
			echo "</td><td style=\"width:550px;vertical-align : top;text-align:left;\">";
				echo "<strong>OT (Orden de Trabajo) : </strong>".$rowf["numero"];
#				echo "<br><strong>Nº plano : </strong>".$rowp["codigo"];
				echo "<br><strong>Cliente : </strong>".$rowf["nombre"];
				echo "<br><strong>Nº pedido cliente : </strong>".$rowf["numero_cliente"];
				echo "<br>";
				echo "<br><strong>Fecha pedido : </strong>".cambiarFormatoFechaDMY($rowf["fecha"]);
				echo "<br><strong>Fecha entrega : </strong>".cambiarFormatoFechaDMY($rowf["fecha_prevision"]);
		echo "</td></tr></table><br>";


		$sqlx = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
		$resultx = mysql_query(convertSQL($sqlx));
		$x = 0;
		while ($rowx = mysql_fetch_array($resultx)) {
			if ($x == 1) { $sql2 = $sql2." or id_cuerpo=".$rowx["id"]; }
			if ($x == 0) { $sql2 = $sql2." id_cuerpo=".$rowx["id"];	$x = 1;	}
		}
		$sql = "select * from sgm_cuerpo where ".$sql2." order by id";

		$result = mysql_query(convertSQL($sql));
		echo "<table cellpadding=\"0\" cellspacing=\"0\" style=\"border:0px;width:640px\"><tr><td><strong>LISTA DE MATERIALES :</strong><br><br></td></tr>";
		while ($row = mysql_fetch_array($result)) {

			$sql2 = "select * from sgm_cuerpo where id=".$row["id_cuerpo"];
			$result2 = mysql_query(convertSQL($sql2));
			$row2 = mysql_fetch_array($result2);



			echo "<tr><td style=\"font-size : 13px;	font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;height:20px\">";
			echo $row2["linea"]." - <strong>".number_format($row["unidades"],2,',','.')."</strong> uni. <strong>".$row["nombre"]."</strong> (ref. ".$row["codigo"].")";
			echo "</td></tr>";
		}


		echo "</table>";

}
else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}
?>
</td></tr></table>
</body>
</html>
