<?php
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1010) AND ($autorizado == true)) {
	if ($_GET['or'] != "") { $orden = $_GET['or']; } else { $orden = 0; }

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:25%;vertical-align : top;text-align:left;\">";
			echo "<strong>Gestor de Proveedores 1.0</strong>";
			echo "<br><br>Opciones del Gestor :";


			echo "<br><a href=\"index.php?op=1010&sop=0\">&raquo; Ver Todos</a>";
			echo "<br><a href=\"index.php?op=1010&sop=0&tipo=0\">&raquo; Ver <strong>sin Clasificar</strong></a>";
			$sql = "select * from sgm_clients_tipos where grupo=".$option." order by tipo";
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
				echo "<br><a href=\"index.php?op=1010&sop=0&tipo=".$row["id"]."\">&raquo; Ver <strong>".$row["tipo"]."</strong></a>";
			}

		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\"><br><br>";

			echo "<br><a href=\"index.php?op=1011&sop=2&origen=1010\">&raquo; Añadir Proveedor</a>";
#			if ($orden == 1) { echo "<a href=\"index.php?op=1010&sop=0&tipo=".$_GET["tipo"]."\">&raquo; Orden por nombre</a>"; }
#			if ($orden == 0) { echo "<a href=\"index.php?op=1010&sop=0&tipo=".$_GET["tipo"]."&or=1\">&raquo; Orden por poblacion</a>"; }
#			echo "<br><br>";

			echo "<br>";
			if ($admin == true) {
				echo "<br><a href=\"index.php?op=1010&sop=10\">&raquo; Administrar Grupos</a>";
				echo "<br><a href=\"index.php?op=1010&sop=20\">&raquo; Administrar Sectores</a>";
			}
			if ($admin == false) {
				echo "<br>&raquo; Administrar Grupos (Solo administradores)";
				echo "<br>&raquo; Administrar Sectores (Solo administradores)";
			}

		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";












	if ($soption == 0) {
		$cp = 00000;
		echo "<table cellpadding=\"0\" cellspacing=\"1\">";

		echo "<tr><td></td><td><center>Fid.</center></td><td><center>Vip</center></td><td></td><td><em>Nombre cliente</em></td><td></td><td><em><center>Teléfono</center></em></td><td></td></tr>";

		if ($_GET["tipo"] == "") { $sql = "select * from sgm_clients where visible=1 and proveedor=1 order by nombre"; }
		else { $sql = "select * from sgm_clients where visible=1 and id_tipo=".$_GET["tipo"]." and proveedor=1 order by nombre"; }
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {

			echo "<tr>";
				if ((valida_nif_cif_nie($row["nif"]) <= 0) OR ($row["nombre"] == "") OR ($row["direccion"] == "") OR ($row["cp"] == "") OR ($row["poblacion"] == "") OR ($row["provincia"] == "")) { 
					echo "<td><strong style=\"color:red\">!!!</strong></td>";
				} else { 
					echo "<td></td>"; 
				}
				if ($row["client"] == 1) { echo "<td style=\"background-color:#32CD32;width:20px\"></td>"; }
				if ($row["client"] == 0) { echo "<td style=\"background-color:Red;width:20px\"></td>"; }
				if ($row["clientvip"] == 1) { echo "<td style=\"background-color:#32CD32;;width:20px\"></td>"; }
				if ($row["clientvip"] == 0) { echo "<td style=\"background-color:Red;width:20px\"></td>"; }
				echo "<td>&nbsp;<a href=\"index.php?op=1010&sop=4&id=".$row["id"]."\">[E]</a>&nbsp;</td>";
				if (strlen($row["nombre"]) > 30) {
					echo "<td><strong><em>".substr($row["nombre"],0,30)."...</em></strong></td>";
				} else {
					echo "<td><strong><em>".$row["nombre"]."</em></strong></td>";
				}
				echo "<td><a href=\"index.php?op=1011&sop=0&id=".$row["id"]."&origen=".$option."\">[ Detalles ]</a></td>";
				echo "<td>".$row["telefono"]."</td>";
				echo "<td><a href=\"index.php?op=1010&sop=99&id=".$row["id"]."\">[ Valoración ]</a></td>";
				$sqlx = "select count(*) as total from sgm_control_calidad where visible=1 and id_cliente=".$row["id"]." ";
				$resultx = $db->sql_query($sqlx);
				$rowx = $db->sql_fetchrow($resultx);
				$controles = $rowx["total"];

				$sqlx = "select * from sgm_control_calidad where visible=1 and id_cliente=".$row["id"]." order by fecha_prevision desc LIMIT 0 , 5 ";
				$resultx = $db->sql_query($sqlx);
				while ($rowx = $db->sql_fetchrow($resultx)) {
					$media = $rowx["total"] + $media;
				}
				$media = $media/5;
				
				$media = number_format((10-round($media,2)),2);
				echo "<td>Controles:<strong> ".$controles."</strong> Últ. 5 : ";
				$x = $media;
				if ($x < 5) { echo "<strong>".$x."</strong> Cuarentena"; }
				if (($x >= 5) and ($x < 8)) { echo "<strong>".$x." </strong>Aceptado"; }
				if ($x >= 8) { echo "<strong>".$x." </strong>Excelente"; }
				if (($controles <= 5) or ($x <= 5)) { echo "-Pruebas"; }
				echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br><strong style=\"color:red\">!!!</strong> - Datos fiscales incompletos o NIF/CIF/NIE incorrectos";
		echo "<br>Fid. : Cliente fidelizado.";
		echo "<br>Vip : Cliente vip.";
	}


	if ($soption == 4) {
		echo "<br><br>¿Seguro que desea eliminar este proveedor?";
		echo "<br><br><a href=\"index.php?op=1010&sop=5&id=".$_GET["id"]."\"><img src=\"pics/flexa.gif\" border=\"0\">[ SI ]</a><a href=\"index.php?op=1010&sop=0\"><img src=\"pics/flexa.gif\" border=\"0\">[ NO ]</a>";
	}

	if ($soption == 5) {
		$sql = "update sgm_clients set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=0\"><img src=\"pics/flexa.gif\" border=\"0\">[ Volver ]</a>";
	}


	if (($soption == 10) AND ($admin == true)) {
		echo "<strong>Administración de Grupos de Clientes :</strong>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<form action=\"index.php?op=1010&sop=12\" method=\"post\">";
				echo "<tr><td></td>";
				echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"tipo\"></td>";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"Añadir\" style=\"width:80px\"></td>";
				echo "</tr>";
			echo "</form>";
			$sql = "select * from sgm_clients_tipos where grupo=1010 order by tipo";
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
				echo "<td><a href=\"index.php?op=1010&sop=13&id=".$row["id"]."\">&raquo; Eliminar</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "<form action=\"index.php?op=1010&sop=11&id=".$row["id"]."\" method=\"post\">";
				echo "<td>&nbsp;<input type=\"text\" value=\"".$row["tipo"]."\" style=\"width:200px\" name=\"tipo\"></td>";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"Modificar\" style=\"width:80px\"></td>";
			echo "</form>";
			echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 11) AND ($admin == true)) {
		$sql = "update sgm_clients_tipos set ";
		$sql = $sql."tipo='".$_POST["tipo"]."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=10\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 12) AND ($admin == true)) {
		$sql = "insert into sgm_clients_tipos (tipo,grupo) ";
		$sql = $sql."values (";
		$sql = $sql."'".$_POST["tipo"]."'";
		$sql = $sql.",".$option;
		$sql = $sql.")";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=10\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 13) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este grupo? (Todos los clientes del grupo quedaran como pendientes de clasificar)";
		echo "<br><br><a href=\"index.php?op=1010&sop=14&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1010&sop=10\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 14) AND ($admin == true)) {
		$sql = "update sgm_clients set ";
		$sql = $sql."id_tipo=0";
		$sql = $sql." WHERE id_tipo=".$_GET["id"]."";
		$db->sql_query($sql);
		$sql = "delete from sgm_clients_tipos WHERE id=".$_GET["id"];
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=10\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 20) AND ($admin == true)) {
		echo "<strong>Administración de Sectores de Clientes :</strong>";
		echo "<center>";
		echo "<table cellpadding=\"0\" cellspacing=\"0\">";
			echo "<form action=\"index.php?op=1010&sop=22\" method=\"post\">";
				echo "<tr><td></td>";
				echo "<td>&nbsp;<input type=\"text\" style=\"width:200px\" name=\"sector\"></td>";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"Añadir\" style=\"width:80px\"></td>";
				echo "</tr>";
			echo "</form>";
			$sql = "select * from sgm_clients_sectors order by sector";
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
				echo "<td><a href=\"index.php?op=1010&sop=23&id=".$row["id"]."\">&raquo; Eliminar</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "<form action=\"index.php?op=1010&sop=21&id=".$row["id"]."\" method=\"post\">";
				echo "<td>&nbsp;<input type=\"text\" value=\"".$row["sector"]."\" style=\"width:200px\" name=\"sector\"></td>";
				echo "<td>&nbsp;<input type=\"Submit\" value=\"Modificar\" style=\"width:80px\"></td>";
			echo "</form>";
			echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if (($soption == 21) AND ($admin == true)) {
		$sql = "update sgm_clients_sectors set ";
		$sql = $sql."sector='".$_POST["sector"]."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=20\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 22) AND ($admin == true)) {
		$sql = "insert into sgm_clients_sectors (sector) ";
		$sql = $sql."values (";
		$sql = $sql."'".$_POST["sector"]."'";
		$sql = $sql.")";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=20\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 23) AND ($admin == true)) {
		echo "<center>";
		echo "<br><br>¿Seguro que desea eliminar este sector? (Todos los clientes del sector quedaran como pendientes de clasificar)";
		echo "<br><br><a href=\"index.php?op=1010&sop=24&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1010&sop=20\">[ NO ]</a>";
		echo "</center>";
	}

	if (($soption == 24) AND ($admin == true)) {
		$sql = "update sgm_clients set ";
		$sql = $sql."sector=0";
		$sql = $sql." WHERE sector=".$_GET["id"]."";
		$db->sql_query($sql);
		$sql = "delete from sgm_clients_sectors WHERE id=".$_GET["id"];
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1010&sop=20\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 99)) {
		echo "<table>";
			echo "<tr>";
				echo "<td></td>";
				echo "<td style=\"text-align:left;width:150px\">Cliente/Proveedor</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Previsión</td>";
				echo "<td style=\"text-align:center;width:75px\">Fecha Llegada</td>";
				echo "<td style=\"text-align:center;width:25px\">Emb.</td>";
				echo "<td style=\"text-align:center;width:25px\">Mat.</td>";
				echo "<td style=\"text-align:center;width:25px\">Med.</td>";
				echo "<td style=\"text-align:center;width:25px\">Aca.</td>";
				echo "<td style=\"text-align:center;width:25px\">Can.</td>";
				echo "<td style=\"text-align:center;width:25px\">Fec.</td>";
				echo "<td style=\"text-align:center;width:50px\"><strong>Total</strong></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		$sql = "select * from sgm_control_calidad where visible=1 and id_cliente=".$_GET["id"]." order by fecha_prevision desc";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
				echo "<td></td>";
				$sqlc = "select * from sgm_clients where id=".$row["id_cliente"];
				$resultc = $db->sql_query($sqlc);
				$rowc = $db->sql_fetchrow($resultc);
				echo "<td><strong>".$rowc["nombre"]."</strong></td>";
				echo "<td style=\"text-align:center;width:75px\"><strong>".$row["fecha"]."</strong></td>";
				echo "<td style=\"text-align:center;width:75px\">".$row["fecha_prevision"]."</td>";
				echo "<td style=\"text-align:center;width:75px\"><strong>".$row["fecha_llegada"]."</strong></td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["embalage"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["material"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["medidas"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["acabados"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["cantidad"]."</td>";
				echo "<td style=\"text-align:center;width:25px\">".$row["puntos_fechas"]."</td>";
				echo "<td style=\"text-align:center;width:50px\"><strong>".(10-$row["total"])."</strong></td>";
				echo "<td></td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	echo "</td></tr></table><br>";

}
?>
