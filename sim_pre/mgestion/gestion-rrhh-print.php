<?php 

error_reporting(~E_ALL);

if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}
	include ("../../archivos_comunes/config.php");
	include ("../../archivos_comunes/functions.php");
#	$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");
$user = false;
if ($soption == 666) {
	setcookie("username", "", time()+86400*$cookiestime, "/", $domain);
	setcookie("password", "", time()+86400*$cookiestime, "/", $domain);
	header("Location: ".$urloriginal);
}
if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"]."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='" .$_POST["user"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if ($row["pass"] == $_POST["pass"]) {
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, "/");
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
				header("Location: ".$urloriginal."/index.php?op=200");
			}
		}
	}
}
else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysql_query($sql);
	$row = mysqli_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["pass"] == $_COOKIE["mpassword"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, "/");
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, "/");
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
		$resultsgm = mysqli_query($dbhandle,convertSQL($sqlsgm));
		$rowsgm = mysqli_fetch_array($resultsgm);
		if ($rowsgm["sgm"] == 1) { $autorizado = true; }

		$sqlpermiso = "select count(*) as total from sgm_users_clients where id_client=".$rowi["id_cliente"]." and id_user=".$userid;
		$resultpermiso = mysqli_query($dbhandle,convertSQL($sqlpermiso));
		$rowpermiso = mysqli_fetch_array($resultpermiso);
		if ($rowpermiso["total"] == 1) { $autorizado = true; }

}
if ($autorizado == true) {
	echo "<table width=\"600px\" cellpadding=\"10px\" cellspacing=\"10px\"><tr><td><center>";
	if ($_GET["op"] == 30){
		echo "<strong>Organigrama</strong>";
		echo "<br><br><br>";
		echo "<table cellpadding=\"10px\" cellspacing=\"10px\" width=\"100%\">";
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=0 order by departamento";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<tr><td style=\"padding-left: 0px;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\">";
					echo "&nbsp;".$row["departamento"]."";
				echo "</td></tr>";
				busca_departamentos($row["id"],50);
			}
		echo "</table>";
	}

	if ($_GET["op"] == 31){
		echo "<strong>Organigrama</strong>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<table cellpadding=\"10px\" cellspacing=\"10px\" width=\"100%\">";
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=0 order by departamento";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<tr><td style=\"padding-left: 0px;font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\">";
				echo "<strong>".$row["departamento"]."</strong>";
				$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$row["id"]." order by puesto";
				$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
				while ($rowp = mysqli_fetch_array($resultp)){
					$sqlpe = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"]." and fecha_baja= '0000-00-00'";
					$resultpe = mysqli_query($dbhandle,convertSQL($sqlpe));
					while ($rowpe = mysqli_fetch_array($resultpe)){
						$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$rowpe["id_empleado"]."";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						$rowe = mysqli_fetch_array($resulte);
						echo "</td></tr><tr><td style=\"padding-left: 0px;\">";
						echo "&nbsp;".$rowp["puesto"].": &nbsp;".$rowe["nombre"]."";
						echo "<tr><td>";
					}
				}
				busca_departamentos2($row["id"],50);
				echo "</td></tr>";
			}
		echo "</table>";
	}

	if ($_GET["op"] == 71){
		echo "<center>";
			echo "<strong>Ficha empleado</strong>";
			echo "<br><br>";
			echo "<table cellpadding=\"10px\" cellspacing=\"10px\" width=\"100%\">";
				$sql = "select * from sgm_rrhh_empleado where visible=1 and id=".$_GET["id"]."";
				$result = mysqli_query($dbhandle,convertSQL($sql));
				while ($row = mysqli_fetch_array($result)){
					echo "<tr style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\">";
						echo "<td>";
							echo "Numero:&nbsp;<strong>".$row["numero"]."</strong><br>";
							echo "Nombre:&nbsp;<strong>".$row["nombre"]."</strong><br>";
							echo "Fecha de Incorporaci&oacute;n:&nbsp;<strong>".$row["fecha_incor"]."</strong><br>";
							echo "Plan de Acogida:&nbsp;<strong>".$row["plan_acogida"]."</strong><br>";
							echo "Formación Previa:&nbsp;<strong>".$row["formacion"]."</strong><br>";
							echo "Trayectoria Anterior:&nbsp;<strong>".$row["trayectoria"]."</strong><br>";
						echo "</td>";
					echo "</tr>";
			echo "</table>";
			echo "<br>";
			echo "<table cellpadding=\"10px\" cellspacing=\"10px\" width=\"100%\">";
					echo "<tr style=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\">";
						echo "<td>&nbsp;</td><td><strong>Puesto Trabajo</strong></td>";
						echo "<td><strong>Fecha Alta</strong></td>";
						echo "<td><strong>Fecha Baja</strong></td>";
					echo "</tr>";
					echo "<tr></tr>";
					echo "<tr></tr>";
						$sqlpe = "select * from sgm_rrhh_puesto_empleado where id_empleado=".$_GET["id"]." and visible=1";
						$resultpe = mysqli_query($dbhandle,convertSQL($sqlpe));
						while ($rowpe = mysqli_fetch_array($resultpe)){
							$sqle = "select * from sgm_rrhh_puesto_trabajo where id=".$rowpe["id_puesto"];
							$resulte = mysqli_query($dbhandle,convertSQL($sqle));
							while ($rowe = mysqli_fetch_array($resulte)){
								echo "<trstyle=\"font-family : Verdana, Geneva, Arial, Helvetica, sans-serif; font-size : 10px;\">";
								echo "<td>&nbsp;</td><td>".$rowe["puesto"]."</td>";
								echo "<td>".$rowpe["fecha_alta"]."</td>";
								echo "<td>".$rowpe["fecha_baja"]."</td></tr>";
							}
						}
					echo "</tr>";
				}
			echo "</table>";
			echo "<br>";
			echo "<table cellpadding=\"10px\" cellspacing=\"10px\" width=\"100%\">";
				echo "<tr>";
					echo "<td>&nbsp;</td><td><strong>Cursos Realizados</strong></td>";
					echo "<td><strong>Fecha Inicio</strong></td>";
					echo "<td><strong>Fecha Fin</strong></td>";
				echo "</tr>";
						echo "<tr></tr>";
						echo "<tr></tr>";
						$sqlc = "select * from sgm_rrhh_formacion_empleado where id_empleado=".$_GET["id"]." and visible=1";
						$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
						while ($rowc = mysqli_fetch_array($resultc)){
							$sqlf = "select * from sgm_rrhh_formacion where id=".$rowc["id_curso"];
							$resultf = mysqli_query($dbhandle,convertSQL($sqlf));
							while ($rowf = mysqli_fetch_array($resultf)){
								echo "<tr>";
									echo "<td>&nbsp;</td><td>".$rowf["nombre"]."</td>";
									echo "<td>".$rowf["fecha_inicio"]."</td>";
									echo "<td>".$rowf["fecha_fin"]."</td></tr>";
							}
						}
			echo "</table>";
	}

	echo "</center></td></tr></table>";
	
} else {
	echo "<strong>USUARIO NO AUTORIZADO</strong>";
}






function busca_departamentos($id,$x)
{ 
	global $db;
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=".$id;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<tr><td style=\"padding-left: ".$x."px;\">";
					echo "&nbsp;".$row["departamento"]."";
				echo "</td></tr>";
				busca_departamentos($row["id"],($x+50));
			}
}

function busca_departamentos2($id,$x)
{ 
	global $db;
			$sql = "select * from sgm_rrhh_departamento where visible=1 and id_departamento=".$id;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)){
				echo "<tr><td style=\"padding-left: ".$x."px;\">";
				echo "&nbsp;<strong>".$row["departamento"]."</strong>";
				$sqlp = "select * from sgm_rrhh_puesto_trabajo where visible=1 and id_departamento=".$row["id"]." order by puesto";
				$resultp = mysqli_query($dbhandle,convertSQL($sqlp));
				while ($rowp = mysqli_fetch_array($resultp)){
					$sqlpe = "select * from sgm_rrhh_puesto_empleado where visible=1 and id_puesto=".$rowp["id"]." and fecha_baja= '0000-00-00'";
					$resultpe = mysqli_query($dbhandle,convertSQL($sqlpe));
					while ($rowpe = mysqli_fetch_array($resultpe)){
						$sqle = "select * from sgm_rrhh_empleado where visible=1 and id=".$rowpe["id_empleado"]."";
						$resulte = mysqli_query($dbhandle,convertSQL($sqle));
						$rowe = mysqli_fetch_array($resulte);
						echo "</td></tr><tr><td style=\"padding-left: ".$x."px;\">";
						echo "&nbsp;".$rowp["puesto"].": &nbsp;".$rowe["nombre"]."";
						echo "<tr><td>";
					}
				}
				echo "</td></tr>";
				busca_departamentos2($row["id"],($x+50));
			}
}




?>


</body>
</html>