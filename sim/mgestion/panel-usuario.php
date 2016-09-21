<?php

if ($user == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 200) AND ($user == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Auxiliares."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if (($soption >= 10) and($soption < 20)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=10&id=".$userid["id"]."\" class=".$class.">".$Cambio." ".$Contrasena."</a></td>";
				if (($soption >= 20) and($soption < 30)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=200&sop=20\" class=".$class.">".$Versiones." SIMges</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
	echo "</table><br>";
	echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
	}

	if ($soption == 10) {
		echo "<h4>".$Cambio." ".$Contrasena."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<form action=\"index.php?op=200&sop=11\" method=\"post\">";
			echo "<tr><th>".$Contrasena."</th><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass1\" style=\"width:100px\" maxlength=\"10\" placeholder=\"".$ayudaPanelUserPass."\"></td></tr>";
			echo "<tr><th>".$Repetir." ".$Contrasena."</th><td style=\"vertical-align : middle;\"><input type=\"Password\" name=\"pass2\" style=\"width:100px\" maxlength=\"10\" placeholder=\"".$ayudaPanelUserPass."\"></td></tr>";
			echo "<tr><td></td><td class=\"Submit\"><input type=\"submit\" value=\"".$Modificar."\"></td>";
			echo "</tr>";
			echo "</form>";
		echo "</table>";
	}

	if ($soption == 11) {
		if (($_POST["pass1"] == $_POST["pass2"]) AND ($_POST["pass1"] != "")) {
			$contrasena = crypt($_POST["pass1"]);
			$sql = "update sgm_users set ";
			$sql = $sql."pass='".$contrasena."'";
			$sql = $sql." WHERE id=".$userid."";
			mysqli_query($dbhandle,convertSQL($sql));
			echo "<center>";
			echo "<br><br>".$ayudaPanelUserPass2;
			echo boton(array("op=0&sop=666"),array($Salir));
			echo "</center>";
		} else {
			echo mensageError($errorPanelUserPass);
		}
	}

	if ($soption == 20) {
		echo "<h4>".$Versiones." SIMges</h4>";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$yant."&m=".$_GET["m"]."\">".$yant."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><b>".$yact."</b></td>";
				if ($ypost <= date("Y")){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$ypost."&m=".$_GET["m"]."\">&gt;".$ypost."</a></td>";
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
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$yact."&m=".$mant."\">".$meses[$mant-1]."&lt;</a></td>";
				} else { echo "<td></td>";}
				echo "<td style=\"text-align:center;\"><b>".$meses[$mact-1]."</b></td>";
				if ($mpost <= 12){
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=200&sop=20&y=".$yact."&m=".$mpost."\">&gt;".$meses[$mpost-1]."</a></td>";
				} else { echo "<td></td>";}
			echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<th>".$Fecha."</th>";
				echo "<th>".$Usuario."</th>";
				echo "<th>".$Comentarios."</th>";
			echo "</tr>";
		$ultimo_dia = date("t", mktime(0,0,0,$mact,1,$yact));
		$inicio_mes = date("Y-m-d", mktime(0,0,0,$mact,1,$yact));
		$final_mes = date("Y-m-d", mktime(0,0,0,$mact,$ultimo_dia, $yact));
		$sqlcv = "select * from sim_control_versiones where visible=1 and fecha between '".$inicio_mes."' and '".$final_mes."' order by fecha desc";
		$resultcv = mysqli_query($dbhandle,convertSQL($sqlcv));
		while ($rowcv = mysqli_fetch_array($resultcv)) {
			echo "<tr>";
				echo "<td style=\"vertical-align:top;width:80px;\">".cambiarFormatoFechaDMY($rowcv["fecha"])."</td>";
				$sqlx = "select id,usuario from sgm_users where sgm=1 and activo=1 and validado=1 and id=".$rowcv["id_usuario"];
				$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
				$rowx = mysqli_fetch_array($resultx);
				echo "<td style=\"vertical-align:top;\">".$rowx["usuario"]."</td>";
				echo "<td><textarea name=\"comentarios\" style=\"width:800px\" disabled>".$rowcv["comentarios"]."</textarea></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		}
		echo "</table>";
	}


	echo "</td></tr></table><br>";
}


?>
