<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1009) AND ($autorizado == true)) {
	if ($_GET['or'] != "") { $orden = $_GET['or']; } else { $orden = 0; }

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<strong>Gestión Comercial 1.0</strong>";
			echo "<br><br>Opciones del Gestor :";
			echo "<br><a href=\"index.php?op=1009&sop=0\">&raquo; Ver Todos</a>";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<br>";
			if ($admin == true) {
				echo "<br><a href=\"index.php?op=1009&sop=10\">&raquo; Administrar Tipos de Visita</a>";
			}


		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	if ($soption == 0) {
	}

	if ($soption == 10) {
		echo "<strong>Lista de tipos de visita : </strong><br><br>";
		echo "<a href=\"index.php?op=1009&sop=11&sop=1\">&raquo; Añadir un nuevo tipo de visita</a>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td style=\"text-align:center\"><em>Eliminar</em></td>";
				echo "<td style=\"width:200px;text-align:center\">Tipo de visita</td>";
				echo "<td style=\"text-align:center\"><em>Editar</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_comercial_visitas_tipo order by tipo_visita";
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=15&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" alt=\"Eliminar\" border=\"0\"></a></td>";
				echo "<td style=\"width:200px;text-align:left\">".$row["tipo_visita"]."</td>";
				echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1009&sop=11&sop=2&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_magnify.png\" alt=\"Información\" border=\"0\"></a></td>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 11) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:100px;text-align:right;vertical-align:top\">Tipo de visita : </td>";
				echo "<td><input type=\"Text\" style=\"width:300px\" name=\"visita_tipo\">".$row["visita_tipo"]."</textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:100px;text-align:right;vertical-align:top\">Descripción : </td>";
				echo "<td><textarea name=\"descripcion\" style=\"width:300px\" rows=\"20\">".$row["descripcion"]."</textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td style=\"width:100px;text-align:right;vertical-align:top\">Protocolo : </td>";
				echo "<td><textarea name=\"descripcion\" style=\"width:300px\" rows=\"20\">".$row["descripcion"]."</textarea></td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 12) {
		$sql = "insert into sgm_clients (nombre,poblacion,cp,mail,web,telefono,notas,id_tipo,sector,cliente,impacto,proveedor) ";
		$sql = $sql."values (";
		$sql = $sql."'".$_POST["nombre"]."'";
		$sql = $sql.",'".$_POST["poblacion"]."'";
		$sql = $sql.",'".$_POST["cp"]."'";
		$sql = $sql.",'".$_POST["mail"]."'";
		$sql = $sql.",'".$_POST["web"]."'";
		$sql = $sql.",'".$_POST["telefono"]."'";
		$sql = $sql.",'".$_POST["notas"]."'";
		$sql = $sql.",".$_POST["id_tipo"]."";
		$sql = $sql.",".$_POST["sector"]."";
		$sql = $sql.",0,1,0";
		$sql = $sql.")";
		$db->sql_query($sql);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1009&sop=0\">[ Volver ]</a> <a href=\"index.php?op=1009&sop=30\">[ Añadir otro ]</a>";
	}

	echo "</td></tr></table><br>";

}
?>
