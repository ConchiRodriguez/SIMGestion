<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
$autorizado = true;
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }

if (($option == 1022) AND ($autorizado == true)) {

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<strong>".$Datos." ".$Sistema."</strong>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($soption == 1) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=1\" class=".$class.">PHP INFO</a></td>";
				if ($soption == 2) {$class = "menu";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=2\" class=".$class.">".$Actualizar." ".$Base." ".$Datos."</a></td>";
#				if ($soption == 3) {$class = "menu_select";} else {$class = "menu";}
#				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=3\" class=".$class.">".$Mantenimiento." ".$Base." ".$Datos."</a></td>";
#				if ($soption == 4) {$class = "menu_select";} else {$class = "menu";}
#				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=4\" class=".$class.">".$Traspasar." ".$Datos."</a></td>";
				if ($soption == 5) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=5\" class=".$class.">CentOS</a></td>";
				if ($soption == 6) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1022&sop=6\" class=".$class.">".$Control." ".$Versiones."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 1) {
		echo "<center>";
		ob_start();
		phpinfo();
		$info = ob_get_contents();
		ob_end_clean();
		$info = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info);
		echo $info;
		echo "</center>";
	}

	if ($soption == 2) {
		#Abrimos el fichero en modo lectura 
		#$source_file = 'http://www.multivia.com/updates/mgestion/sql.sql';
		#$dest_file = 'mgestion/sql.sql';
		#copy($source_file, $dest_file);
		$DescriptorFichero = fopen("mgestion/sql.sql","r"); 
		while(!feof($DescriptorFichero)){ 
			$buffer = fgets($DescriptorFichero,4096); 
			$longitud = strlen($buffer)-2;
			$sql = substr($buffer, 0, $longitud);
			mysqli_query($dbhandle,convertSQL($sql));
			echo $sql."<BR>"; 
		} 
	}

	if ($soption == 3){
		if ($ssoption == 1){
			$sqlser = "select * from sgm_incidencias_servicios where visible=0 order by servicio";
			$resultser = mysqli_query($dbhandle,convertSQL($sqlser));
			while ($rowser = mysqli_fetch_array($resultser)) {
				$sql = "update sgm_incidencias_servicios_cliente set ";
				$sql = $sql."visible=0";
				$sql = $sql." WHERE id_servicio=".$rowser["id"]."";
				mysqli_query($dbhandle,convertSQL($sql));
			}
		}
		if ($ssoption == 2){
			$sqlser = "select * from sgm_incidencias_servicios_estados where visible=0 order by servicio";
			$resultser = mysqli_query($dbhandle,convertSQL($sqlser));
			while ($rowser = mysqli_fetch_array($resultser)) {
				$sql = "update sgm_incidencias_servicios_cliente set ";
				$sql = $sql."visible=0";
				$sql = $sql." WHERE id_estado=".$rowser["id"]."";
				mysqli_query($dbhandle,convertSQL($sql));
			}
		}

		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
			echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
				echo "<center><table><tr>";
					echo "<td style=\"height:20px;width:200px;\";><strong>".$Mantenimientos." :</strong></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 1) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:200px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1022&sop=3&ssop=1&usuario=".$userid."\" style=\"color:".$lcolor."\">".$Servicios." ".$Incidencias."</a></td>";
					$color = "#4B53AF";
					$lcolor = "white";
					if ($ssoption == 2) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:200px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1022&sop=3&ssop=2&usuario=".$userid."\" style=\"color:".$lcolor."\">".$Estados." ".$Servicios." ".$Incidencias."</a></td>";
				echo "</tr></table></center>";
		echo "</td></tr></table><br>";
	}

	if ($soption == 4) {
		echo "TRASPASO DE DATOS<br>";
		include ("mgestion/system-traspaso.php");
	}

	if ($soption == 5) {
		echo "<h4>Shell : </h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Orden."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1022&sop=5\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"comando\" style=\"width:300px\"></td>";
				echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Ejecutar."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
			$salida = shell_exec($_POST["comando"]);
				echo "<td><pre>$salida</pre></td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 6) {
		if ($ssoption == 1) {
			$camposInsert = "fecha,comentarios,id_usuario";
			$datosInsert = array(cambiarFormatoFechaDMY($_POST["fecha"]),comillas($_POST["comentarios"]),$_POST["id_usuario"]);
			insertFunction ("sim_control_versiones",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate = array("fecha","comentarios","id_usuario");
			$datosUpdate = array(cambiarFormatoFechaDMY($_POST["fecha"]),comillas($_POST["comentarios"]),$_POST["id_usuario"]);
			updateFunction ("sim_control_versiones",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate = array("visible");
			$datosUpdate = array("0");
			updateFunction ("sim_control_versiones",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Control." ".$Versiones."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"10\" class=\"lista\">";
			echo "<tr>";
				if ($_GET["y"] == "") {
					$yact = date("Y");
				} else {
					$yact = $_GET["y"];
				}
				$yant = $yact - 1;
				$ypost = $yact +1;
				if ($yant >= 2012){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1022&sop=6&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><b>".$yact."</b></td>";
				if ($ypost <= date("Y")){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1022&sop=6&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
			echo "<tr>";
				if ($_GET["m"] == "") {
					$mact = date("n");
				} else {
					$mact = $_GET["m"];
				}
				$mant = $mact - 1;
				$mpost = $mact +1;
				if ($mant >= 1){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1022&sop=6&y=".$yact."&m=".$mant."\">".$meses[$mant-1]."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><b>".$meses[$mact-1]."</b></td>";
				if ($mpost <= 12){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1022&sop=6&y=".$yact."&m=".$mpost."\">&gt;".$meses[$mpost-1]."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th></th>";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Comentarios."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<td></td>";
				echo "<form action=\"index.php?op=1022&sop=6&ssop=1\" method=\"post\">";
				echo "<td style=\"vertical-align:top;width:80px;\"><input type=\"Text\" name=\"fecha\" value=\"".date("d-m-Y")."\"></td>";
				echo "<td style=\"vertical-align:top;\"><select name=\"id_usuario\" style=\"width:150px\">";
					echo "<option value=\"0\">-</option>";
					$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
					$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
					while ($rowx = mysqli_fetch_array($resultx)) {
						if ($userid == $rowx["id"]) {
							echo "<option value=\"".$rowx["id"]."\" selected>".$rowx["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowx["id"]."\">".$rowx["usuario"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><textarea name=\"comentarios\" rows=\"3\" style=\"width:500px\"></textarea></td>";
				echo "<td class=\"Submit\" style=\"vertical-align:top;\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		$ultimo_dia = date("t", mktime(0,0,0,$mact,1,$yact));
		$inicio_mes = date("Y-m-d", mktime(0,0,0,$mact,1,$yact));
		$final_mes = date("Y-m-d", mktime(0,0,0,$mact,$ultimo_dia, $yact));
		$sqlcv = "select * from sim_control_versiones where visible=1 and fecha between '".$inicio_mes."' and '".$final_mes."' order by fecha desc";
		$resultcv = mysqli_query($dbhandle,convertSQL($sqlcv));
		while ($rowcv = mysqli_fetch_array($resultcv)) {
			echo "<tr>";
				echo "<td style=\"vertical-align:top;\"><a href=\"index.php?op=1022&sop=7&id=".$rowcv["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px;\"></a></td>";
				echo "<form action=\"index.php?op=1022&sop=6&ssop=2&id=".$rowcv["id"]."\" method=\"post\">";
				echo "<td style=\"vertical-align:top;width:80px;\"><input type=\"Text\" name=\"fecha\" value=\"".cambiarFormatoFechaDMY($rowcv["fecha"])."\"></td>";
				echo "<td style=\"vertical-align:top;\"><select name=\"id_usuario\" style=\"width:150px\">";
					echo "<option value=\"0\">-</option>";
					$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 order by usuario";
					$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
					while ($rowx = mysqli_fetch_array($resultx)) {
						if ($rowcv["id_usuario"] == $rowx["id"]) {
							echo "<option value=\"".$rowx["id"]."\" selected>".$rowx["usuario"]."</option>";
						} else {
							echo "<option value=\"".$rowx["id"]."\">".$rowx["usuario"]."</option>";
						}
					}
				echo "</select></td>";
				echo "<td><textarea name=\"comentarios\" rows=\"3\" style=\"width:500px\">".$rowcv["comentarios"]."</textarea></td>";
				echo "<td class=\"Submit\" style=\"vertical-align:top;\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
				echo "</form>";
			echo "</tr>";
		}
		echo "</table>";
	}

	if ($soption == 7) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1022&sop=6&ssop=3&id=".$_GET["id"],"op=1022&sop=6"),array($Si,$No));
		echo "</center>";
	}

echo "</td></tr></table><br>";
}
?>
