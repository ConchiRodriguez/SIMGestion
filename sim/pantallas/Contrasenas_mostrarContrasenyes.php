<?php
error_reporting(~E_ALL);


function mostrarContrasenyes ($link_edit,$link_del,$link_veure_contra,$link_edit_contra) {
	global $db,$dbhandle,$idioma,$userid,$ssoption,$simclau,$id_aplicacion,$id_cliente;

	if ($idioma == "es"){ include ("sgm_es.php");}
	if ($idioma == "cat"){ include ("sgm_cat.php");}

	if ($ssoption == 1) {
		if (($_POST["pass1"] != $_POST["pass2"]) OR $_POST["pass1"] == "") {
			echo mensageError($PassIncorrecto);
		} else {
			if ($id_cliente == 0) {
				echo mensageError($SinContrato);
			} else {
				$cadena = encrypt($_POST["pass1"],$simclau);
				$camposInsert = "id_client,id_aplicacion,acceso,usuario,pass,descripcion";
				$datosInsert = array($id_cliente,$_POST["id_aplicacion"],$_POST["acceso"],$_POST["usuario"],$cadena,$_POST["descripcion"]);
				insertFunction ("sgm_contrasenyes",$camposInsert,$datosInsert);

				$sqlcc = "select id from sgm_contrasenyes where id_client=".$id_cliente." and id_aplicacion=".$_POST["id_aplicacion"]." and acceso='".$_POST["acceso"]."' order by id desc";
				$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
				$rowcc = mysqli_fetch_array($resultcc);
				$camposInsert = "id_contrasenya,id_usuario,fecha,accion";
				$datosInsert = array($rowcc["id"],$userid,time(),"0");
				insertFunction ("sgm_contrasenyes_lopd",$camposInsert,$datosInsert);
			}
		}
	}
	if ($ssoption == 2) {
		if ($_POST["passold"] != "") {
			$clau = encrypt($_POST["passold"],$simclau);
			$sqlx = "select id from sgm_contrasenyes WHERE id=".$_GET["id_con"]." and pass='".$clau."'";
			$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
			$rowx = mysqli_fetch_array($resultx);
			if ($rowx){
				if (($_POST["pass1"] != "") and ($_POST["pass1"] == $_POST["pass2"])) {
					$contrasena = encrypt($_POST["pass1"],$simclau);
					$camposUpdate = array("id_client","id_aplicacion","acceso","usuario","descripcion","pass");
					$datosUpdate = array($id_cliente,$_POST["id_aplicacion"],$_POST["acceso"],$_POST["usuario"],$_POST["descripcion"],$contrasena);
					updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
				} else {
					echo mensageError($PassIncorrecto);
				}
			} else {
				echo mensageError($ErrorPass);
			}
		} else {
			$camposUpdate = array("id_client","id_aplicacion","acceso","usuario","descripcion");
			$datosUpdate = array($id_cliente,$_POST["id_aplicacion"],$_POST["acceso"],$_POST["usuario"],$_POST["descripcion"]);
			updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
		}
	}
	if ($ssoption == 3) {
		$camposUpdate = array("visible");
		$datosUpdate = array("0");
		updateFunction ("sgm_contrasenyes",$_GET["id_con"],$camposUpdate,$datosUpdate);
	}
	echo "<br><br>";
	echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"width:100%;\">";
	if (($id_cliente != 0) or ($id_aplicacion != 0) or ($_GET["id"] > 0)) {
		echo "<tr style=\"background-color:silver\">";
			echo "<th></th>";
			echo "<th>".$Cliente."</th>";
			echo "<th>".$Aplicacion."</th>";
			echo "<th>".$Acceso."</th>";
			echo "<th>".$Usuario."</th>";
			echo "<th>".$Contrasena."</th>";
			echo "<th>".$Descripcion."</th>";
			echo "<th></th>";
		echo "</tr>";
		$sqlcc = "select * from sgm_contrasenyes where visible=1";
	}
	if (($id_cliente > 0) and ($_GET["id"] <= 0)) {$sqlcc = $sqlcc." and id_client=".$id_cliente."";}
	if (($id_aplicacion > 0) and ($_GET["id"] <= 0)) {$sqlcc = $sqlcc." and id_aplicacion=".$id_aplicacion."";}
	if ($_GET["id"] > 0) {$sqlcc .= " and id_contrato in (select id from sgm_contratos where id_cliente=".$_GET["id"].")";}
	$sqlcc = $sqlcc." order by id_client desc,id_aplicacion";
#		echo $sqlcc;
	$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
	while ($rowcc = mysqli_fetch_array($resultcc)){
		$url_enlace = "";
		echo "<form action=\"index.php?".$link_edit."&id_con=".$rowcc["id"]."\" method=\"post\">";
		echo "<tr>";
			echo "<td style=\"text-align:center;\"><a href=\"index.php?".$link_del."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"".$Eliminar."\" title=\"".$Eliminar."\" border=\"0\"></a></td>";
			$sqlc = "select nombre,cognom1,cognom2 from sgm_clients where id=".$rowcc["id_client"];
			$resultc = mysqli_query($dbhandle,convertSQL($sqlc));
			$rowc = mysqli_fetch_array($resultc);
			echo "<td nowrap><a href=\"index.php?op=1011&sop=100&id=".$rowc["id"]."\">".$rowc["nombre"]." ".$rowc["cognom1"]." ".$rowc["cognom2"]."</a></td>";
			$sqlam = "select aplicacion from sgm_contrasenyes_apliciones where visible=1 and id=".$rowcc["id_aplicacion"];
			$resultam = mysqli_query($dbhandle,convertSQL($sqlam));
			$rowam = mysqli_fetch_array($resultam);
			echo "<td>".$rowam["aplicacion"]."</td>";
			if (strrpos($rowcc["acceso"], 'http') === false){ $http = 'http://';} else {$http = '';}
			echo "<td><a href=\"".$http.$rowcc["acceso"]."\" target=\"_blank\">".$rowcc["acceso"]."</td>";
			echo "<td>".$rowcc["usuario"]."</td>";
			echo "<td style=\"text-align:left;\">";
			echo "<a href=\"index.php?".$link_veure_contra."&id_con=".$rowcc["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Ver\" border=\"0\" title=\"".$Visualizar."\"></a>";
			echo "</td>";
			echo "<td>".$rowcc["descripcion"]."</td>";
			echo "<td class=\"Submit\"><input type=\"Submit\" value=\"".$Editar."\"></td>";
		echo "</tr>";
		echo "</form>";
	}
	echo "</table>";
}

?>