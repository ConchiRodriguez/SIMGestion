<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1025) AND ($autorizado == true)) {

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:15%;vertical-align : middle;text-align:left;\">";
			echo "<strong>".$Monitorizacion."</strong>";
		echo "</td><td style=\"width:85%;vertical-align : top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if ($soption == 0) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1025&sop=0\" class=".$class.">".$Servidores."</a></td>";
#				if ($soption == 100) {$class = "menu";} else {$class = "menu";}
#				echo "<td class=".$class."><a href=\"index.php?op=1025&sop=100\" class=".$class.">".$Anadir." ".$Incidencia."</a></td>";
#				if ($soption == 200) {$class = "menu_select";} else {$class = "menu";}
#				echo "<td class=".$class."><a href=\"index.php?op=1025&sop=200\" class=".$class.">".$Buscar." ".$Incidencia."</a></td>";
#				if ($soption == 500) {$class = "menu_select";} else {$class = "menu";}
#				echo "<td class=".$class."><a href=\"index.php?op=1025&sop=500\" class=".$class.">".$Indicadores."</a></td>";
				if (($soption >= 500) and ($soption <= 600) and ($admin == true)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1025&sop=500\" class=".$class.">".$Administrar."</a></td>";
#				echo "<td></td>";
#				echo "<td class=menu><a href=\"index.php?op=1008&sop=210&id=0\" class=menu>".$Anadir." ".$Contacto."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

#Administració de taules auxiliars del módul#
	if ($soption == 0) {

		echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:1200px;\">";
			$sqlcl= "select * from sgm_clients where visible=1 and id IN (select id_cliente from sgm_contratos where visible=1 and activo=1 and id_cliente in (select id_client from sgm_clients_servidors where visible=1)) order by nombre";
			$resultcl = mysql_query($sqlcl,$dbhandle);
			while ($rowcl = mysql_fetch_array($resultcl)){
				echo "<tr><td colspan=\"5\"  style=\"background-color:silver;\"><strong>".$rowcl["nombre"].$rowcl["cognom1"].$rowcl["cognom2"]."</strong></td></tr>";

				echo servidoresMonitorizados($rowcl["id"],5,10);

			}
		echo "</table>";
	}

	if ($soption == 10) {
		echo detalleServidoresMonitorizados ($_GET["id_cli"],$_GET["id_serv"]);
	}




	if ($soption == 500) {
		if ($admin == true) {
			$ruta_botons = array("op=1025&sop=510","op=1025&sop=520","op=1025&sop=530");
			$texto = array($Bases_Datos,$Alertas,$Servidores);
			echo boton($ruta_botons,$texto);
		}
		if ($admin == false) {
			echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>";
		}
	}

#bases de dades#
	if (($soption == 510) and ($admin == true)) {
		echo afegirModificarBasesDades("op=1025&sop=510","op=1025&sop=511");
	}

	if ($soption == 511) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1025&sop=510&ssop=3&id=".$_GET["id"]."&id_bd=".$_GET["id_bd"]."\">[ SI ]</a><a href=\"index.php?op=1025&sop=510\">[ NO ]</a>";
		echo "</center>";
	}

#Alertes#
	if ($soption == 520) {
		if ($ssoption == 2) {
			if ($_GET["id"] != ""){
				$sqlc = "update sgm_clients_servidors_param set ";
				$sqlc = $sqlc."cpu=".$_POST["cpu"]."";
				$sqlc = $sqlc.",mem=".$_POST["mem"]."";
				$sqlc = $sqlc.",memswap=".$_POST["memswap"]."";
				$sqlc = $sqlc.",hd=".$_POST["hd"]."";
				$sqlc = $sqlc." WHERE id=".$_GET["id"]."";
				mysql_query(convert_sql($sqlc));
			} else {
				$sql = "insert into sgm_clients_servidors_param (cpu,mem,memswap,hd) ";
				$sql = $sql."values (";
				$sql = $sql."".$_POST["cpu"]."";
				$sql = $sql.",".$_POST["mem"]."";
				$sql = $sql.",".$_POST["memswap"]."";
				$sql = $sql.",".$_POST["hd"]."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			}
		}
		echo "<strong>".$Alertas."</strong>";
		echo "<br><br>";
			echo "<table><tr>";
					echo "<td class=\"menu\">";
						echo "<a href=\"index.php?op=1025&sop=500\" style=\"color:white;\">&laquo; ".$Volver."</a>";
					echo "</td>";
			echo "</tr></table>";
		echo "<br><br><center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Concepto."</td>";
				echo "<td>".$Valor."</td>";
			echo "</tr>";
			$sql = "select * from sgm_clients_servidors_param";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			echo "<form action=\"index.php?op=1025&sop=520&ssop=2&id=".$row["id"]."\" method=\"post\">";
			echo "<tr><td>CPU</td><td><input name=\"cpu\" type=\"Text\" value=\"".$row["cpu"]."\" style=\"width:100px\"></td></tr>";
			echo "<tr><td>Memoria</td><td><input name=\"mem\" type=\"Text\" value=\"".$row["mem"]."\" style=\"width:100px\"></td></tr>";
			echo "<tr><td>Memoria Swap</td><td><input name=\"memswap\" type=\"Text\" value=\"".$row["memswap"]."\" style=\"width:100px\"></td></tr>";
			echo "<tr><td>HD</td><td><input name=\"hd\" type=\"Text\" value=\"".$row["hd"]."\" style=\"width:100px\"></td></tr>";
			echo "<tr><td></td><td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:100px;\"></td></tr>";
			echo "</form>";
		echo "</table></center>";
	}

#servidors#
	if (($soption == 530) and ($admin == true)) {
		echo afegirModificarServidors("op=1025&sop=530","op=1025&sop=531");
	}

	if ($soption == 531) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo "<br><br><a href=\"index.php?op=1025&sop=530&ssop=3&id=".$_GET["id"]."&id_serv=".$_GET["id_serv"]."\">[ SI ]</a><a href=\"index.php?op=1025&sop=530\">[ NO ]</a>";
		echo "</center>";
	}

	echo "</td></tr></table><br>";
}

#	if ($soption == 1234) {
#		$sql = "select * from sgm_clients_bases_dades";
#		$result = mysql_query(convert_sql($sql));
#		while ($row = mysql_fetch_array($result)) {
#			$cadena = encrypt($row["pass"], $simclau);
#			$sql = "update sgm_clients_bases_dades set ";
#			$sql = $sql."pass='".$cadena."'";
#			$sql = $sql." WHERE id=".$row["id"]."";
#			mysql_query(convert_sql($sql));
#			echo $sql."<br>";
#		}
#	}

?>
