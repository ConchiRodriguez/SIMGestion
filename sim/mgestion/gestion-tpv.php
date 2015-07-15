<?php
#		$xfecha = date("Y-m-d");
#		$sql = $sql.",'".$xfecha."'";

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }
if (($option == 1021) AND ($autorizado == true)) {
	if ($soption >= 0) {

	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:50%;vertical-align : top;text-align:left;\">";
			echo "<strong>TPV 1.4</strong>";
			echo "<br><br>Listado de TPV's :";

			$sql = "select * from sgm_tpv_cajas where visible=1 order by nombre";
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result)) {
				$sqlt = "select count(*) as total from sgm_tpv_permisos where id_user=".$userid." and id_caja=".$row["id"];
				$resultt = $db->sql_query($sqlt);
				$rowt = $db->sql_fetchrow($resultt);
				if ($rowt["total"] == 1) {
					$sqlx = "select * from sgm_tpv_permisos where id_user=".$userid." and id_caja=".$row["id"];
					$resultx = $db->sql_query($sqlx);
					$rowx = $db->sql_fetchrow($resultx);
					echo "<br>";
					if ($rowx["admin"] == 1) {
						echo "<a href=\"\">[ Cierres ]</a>";
					} else {
						echo "[ Cierres ]";
					}
				echo "<a href=\"index.php?op=1021&sop=1&id=".$row["id"]."\">[ Acceder a TPV ]</a> <strong>".$row["nombre"]."</strong>";
				}
			}
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\"><br><br>";
			if ($admin == true) {
				echo "<br><a href=\"index.php?op=1021&sop=120\">&raquo; Administrar Cajas</a>";
				echo "<br><a href=\"index.php?op=1021&sop=40\">&raquo; Administrar Usuarios para Cajas</a>";
			}
			if ($admin == false) {
				echo "<br>&raquo; Administrar Cajas (Solo administradores)";
				echo "<br>&raquo; Administrar Usuarios para Cajas(Solo administradores)";
			}
		echo "</td><td style=\"width:25%;vertical-align : top;text-align:left;\">";
		echo "</td></tr></table><br>";
		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";

	}


	if ($soption == 1) {
		$sql = "select * from sgm_tpv_cajas where id=".$_GET["id"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		echo "<table>";
			echo "<tr><td style=\"text-align:right;\">Nombre : </td><td><strong>".$row["nombre"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right;\">Dirección : </td><td><strong>".$row["direccion"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right;\">Población : </td><td><strong>".$row["poblacion"]."</strong> (".$row["cp"].") <strong>".$row["provincia"]."</strong></td></tr>";
		echo "</table>";
		echo "<br><table><tr>";
		echo "<td style=\"border:1px solid navy;width:100px;text-align:center;\"><a href=\"index.php?op=1021&sop=10&id_caja=".$_GET["id"]."\"><strong>Nuevo tiquet</strong></a></td>";
		echo "</tr></table>";
		echo "<br>";
		$sql = "select * from sgm_tpv_cabezera where id_caja=".$_GET["id"]." order by numero desc";
		$result = $db->sql_query($sql);
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:60px;text-align:right\"><em>Tiquet</em></td>";
				echo "<td style=\"width:60px\">&nbsp;<em>Fecha</em></td>";
				echo "<td style=\"width:60px\">&nbsp;<em>Hora</em></td>";
				echo "<td style=\"width:60px;text-align:right\"><em>Importe</em></td>";
				echo "<td style=\"width:60px;text-align:right\"><em>Pago</em></td>";
				echo "<td style=\"width:20px;text-align:right\"><em>idU</em></td>";
				echo "<td></td>";
			echo "</tr>";
		while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:right\"><strong>".$row["id"]."</strong></td>";
				echo "<td>&nbsp;".$row["fecha"]."</td>";
				echo "<td>&nbsp;".$row["hora"]."</td>";
				echo "<td style=\"text-align:right\"><strong>".$row["total"]."</strong></td>";
					$sqlx = "select * from sgm_tpv_tipos_pago where id=".$row["id_tipo_pago"];
					$resultx = $db->sql_query($sqlx);
					$rowx = $db->sql_fetchrow($resultx);
				
				echo "<td style=\"text-align:right\">".$rowx["tipo"]."</td>";
				echo "<td style=\"text-align:right\">".$row["id_user"]."</td>";
				echo "<td><a href=\"index.php?op=1021&sop=10&id=".$row["id"]."&id_caja=".$row["id_caja"]."\">[ Editar Tiquet ]</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}



	if ($soption == 10) {
		if ($_GET["id"] == "") {
			#### CREA NUEVO TIQUET
			$sql = "select * from sgm_tpv_cabezera where visible=1 and id_caja=".$_GET["id_caja"]." order by numero desc";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$numero = $row["numero"]+1;
			$sql = "insert into sgm_tpv_cabezera (numero,id_caja,fecha,hora,id_user) ";
			$sql = $sql."values (";
			$sql = $sql."".$numero."";
			$sql = $sql.",".$_GET["id_caja"]."";
			$xfecha = date("Y-m-d");
			$sql = $sql.",'".$xfecha."'";
			$xhora = date("H:i:s");
			$sql = $sql.",'".$xhora."'";
			$sql = $sql.",".$userid."";
			$sql = $sql.")";
			$db->sql_query($sql);
		} else {
			$sql = "select * from sgm_tpv_cabezera where id=".$_GET["id"];
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$numero = $row["numero"];
		}
		
		#### SELECCIONA TIQUET CREADO Y LO PREPARA PARA MODIFICAR
		$sql = "select * from sgm_tpv_cabezera where numero=".$numero." and id_caja=".$_GET["id_caja"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$sqlc = "select * from sgm_tpv_cajas where id=".$_GET["id_caja"];
		$resultc = $db->sql_query($sqlc);
		$rowc = $db->sql_fetchrow($resultc);
		echo "<table>";
			echo "<tr><td style=\"text-align:right\">Caja : </td><td><strong>".$rowc["nombre"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right\">Número de tiquet : </td><td><strong>".$row["numero"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right\">Fecha : </td><td><strong>".$row["fecha"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right\">Hora : </td><td><strong>".$row["hora"]."</strong></td></tr>";
		echo "</table>";


		echo "<br><br>";
		echo "<table cellspacing=\"0\">";
		echo "<tr><td></td><td><em>Código</em></td><td><em>Nombre</em></td><td><center><em>Unidades</em></center></td><td><center><em>Precio</em></center></td><td></td></tr>";
		echo "<tr>";
			echo "<form action=\"index.php?op=1021&sop=24&id_caja=".$_GET["id_caja"]."\" method=\"post\">";
			echo "<td></td>";
			echo "<td><input type=\"Text\" name=\"codigo\" style=\"width:100px\"></td>";
			echo "<td><input type=\"Text\" name=\"nombre\" style=\"width:320px\"></td>";
			echo "<td><input type=\"Text\" name=\"unidades\" style=\"width:50px\" value=\"0.000\"></td>";
			echo "<td><input type=\"Text\" name=\"pvp\" style=\"width:50px\" value=\"0.000\"></td>";
			echo "<td><input type=\"Submit\" value=\"Añadir\" style=\"width:50px\"></td>";
			echo "</form>";
		echo "</tr>";

		$x=1;
		echo "<form action=\"index.php?op=1021&sop=29&id_caja=".$_GET["id_caja"]."\" method=\"post\">";
		echo "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td><input type=\"Submit\" value=\"Modif.\" style=\"width:50px\"></td></tr>";
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["id"]." order by id";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$color = "white";
			echo "<tr style=\"background-color : ".$color.";\">";
				echo "<td><a href=\"index.php?op=1021&sop=25&idfactura=".$_GET["id"]."&id=".$row["id"]."\">[E]</a></td>";
				echo "<input type=\"hidden\" name=\"id".$x."\" value=\"".$row["id"]."\">";
				echo "<td><input type=\"Text\" name=\"codigo".$x."\" style=\"width:100px\" value=\"".$row["codigo"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre".$x."\" style=\"width:320px\" value=\"".$row["nombre"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"unidades".$x."\" style=\"text-align:right;width:50px\" value=\"".$row["unidades"]."\"></td>";
				echo "<td><input type=\"Text\" name=\"pvp".$x."\" style=\"text-align:right;width:50px\" value=\"".$row["pvp"]."\"></td>";
				echo "<td style=\"text-align:right;background-color : silver;\"><strong>".$row["total"]."</strong> €</td>";
			echo "</tr>";
			$x++;
		}
		echo "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td><input type=\"Submit\" value=\"Modif.\" style=\"width:50px\"></td></tr>";
		echo "</form>";

		$sql = "select * from sgm_cabezera where id=".$_GET["id"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
			echo "<tr><td></td><td></td><td></td><td style=\"text-align:right;\"><em>Subtotal</em></td><td style=\"text-align:right;\">".$row["subtotal"]." €</td><td></td></tr>";
			echo "<form action=\"index.php?op=1021&sop=27&id=".$row["id"]."\" method=\"post\">";
				echo "<tr><td></td><td></td><td></td><td style=\"text-align:right;\"><em>Descuento</em></td><td><input type=\"Text\" name=\"descuento\" style=\"text-align:right;width:50px\" value=\"".$row["descuento"]."\">%</td><td><input type=\"Submit\" value=\"Modif.\" style=\"width:50px\"></td></tr>";
			echo "</form>";
			echo "<tr><td></td><td></td><td></td><td style=\"text-align:right;\"><em>Subtotal</em></td><td style=\"text-align:right;\">".$row["subtotaldescuento"]." €</td><td></td></tr>";
			echo "<form action=\"index.php?op=1021&sop=28&id=".$row["id"]."\" method=\"post\">";
				echo "<tr><td></td><td></td><td></td><td style=\"text-align:right;\"><em>IVA</em></td><td><input type=\"Text\" name=\"iva\" style=\"text-align:right;width:50px\" value=\"".$row["iva"]."\">%</td><td><input type=\"Submit\" value=\"Modif.\" style=\"width:50px\"></td></tr>";
			echo "</form>";
			echo "<tr><td></td><td></td><td></td><td style=\"text-align:right;\"><em>TOTAL</em></td><td style=\"text-align:right;\">".$row["total"]." €</td><td></td></tr>";
		echo "</table>";
		echo "<br><br>";


	}

	if ($soption == 24) {
		if (($_POST["nombre"] == "") and ($_POST["codigo"] != "")) {

			$sql = "select * from sgm_articles where codigo2='".$_POST["codigo"]."'";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			echo "<br>".$sql;

			#### BUSCA EL PRECIO VIGENTE EN LA DB

			$sqls = "select * from sgm_stock where id_article=".$row["id"]." AND vigente=1";
			$results = $db->sql_query($sqls);
			$rows = $db->sql_fetchrow($results);

			#### INSERTA DATOS EN EL CUERPO

			$sql = "insert into sgm_tpv_cuerpo (idfactura,codigo,nombre,pvd,pvp,unidades,total,id_article,stock) ";
			$sql = $sql."values (";
			$sql = $sql."".$_GET["id_caja"];
			$sql = $sql.",'".$row["codigo"]."'";
			$sql = $sql.",'".$row["nombre"]."'";
			$sql = $sql.",".$rows["pvd"];
			$sql = $sql.",".$rows["pvp"];
			$sql = $sql.",".$_POST["unidades"];
			$total = $_POST["unidades"] * $rows["pvp"];
			$sql = $sql.",".$total;
			$sql = $sql.",".$row["id"];
			$sql = $sql.",1";
			$sql = $sql.")";
			$db->sql_query($sql);
			echo "<br>".$sql;
		}
		refactura($_GET["id"]);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=22&id=".$_GET["id"]."\">[ Volver ]</a>";
	}


	if ($soption == 29) {
		$x=1;
		$sql = "select * from sgm_cuerpo where idfactura=".$_GET["idfactura"]." order by id";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$sql = "update sgm_cuerpo set ";
			$sql = $sql."codigo='".$_POST["codigo".$x.""]."'";
			$sql = $sql.",nombre='".$_POST["nombre".$x.""]."'";
			$sql = $sql.",pvp=".$_POST["pvp".$x.""];
			$sql = $sql.",linea=".$_POST["linea".$x.""];
			$sql = $sql.",unidades=".$_POST["unidades".$x.""];
			$total = $_POST["unidades".$x.""] * $_POST["pvp".$x.""];
			$sql = $sql.",total=".$total;
			$sql = $sql.",fecha_prevision='".$_POST["fecha_prevision".$x.""]."'";
			$sql = $sql." WHERE id=".$_POST["id".$x.""]."";
			$db->sql_query($sql);
			$x++;
		}
		refactura($_GET["idfactura"]);
		echo "<br><br>Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=22&id=".$_GET["idfactura"]."\">[ Volver ]</a>";
	}








	if (($soption == 40) and ($admin == true)) {
		$sql = "select * from sgm_users where activo=1 and sgm=1 order by usuario";
		$result = $db->sql_query($sql);
		echo "Lista de usuarios y número de permisos para cajas TPV's.";
		echo "<br><br>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr><td>Id.</td><td>Usuario</td><td>Permisos</td></tr>";
		while ($row = $db->sql_fetchrow($result)) {
			echo "<tr>";
				echo "<td style=\"text-align:right;\">".$row["id"]."</td>";
				echo "<td>&nbsp;<strong>".$row["usuario"]."</strong></td>";
				$sqlt = "select count(*) as total from sgm_tpv_permisos where id_user=".$row["id"];
				$resultt = $db->sql_query($sqlt);
				$rowt = $db->sql_fetchrow($resultt);
				echo "<td style=\"text-align:right\"><a href=\"index.php?op=1021&sop=41&id_user=".$row["id"]."\">[ <strong>".$rowt["total"]."</strong> Autorizaciones ]</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	if (($soption == 41) and ($admin == true)) {
		$sql = "select * from sgm_users where id=".$_GET["id_user"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		echo "Estos son los permisos sobre cajas TPV del usuario : <strong>".$row["usuario"]."</strong> id.<strong>".$row["id"]."</strong>";
		echo "<br><br>";
		$sql = "select * from sgm_tpv_cajas where visible=1 order by nombre";
		$result = $db->sql_query($sql);
		echo "<table cellpadding=\"1\" cellspacing=\"0\">";
		echo "<tr><td></td><td><strong>Permisos</strong></td><td></td><td><strong>Admin.</strong></td><td><strong>Caja TPV</strong></td></tr>";
		while ($row = $db->sql_fetchrow($result)) {
			$sqlt = "select count(*) as total from sgm_tpv_permisos where id_user=".$_GET["id_user"]." and id_caja=".$row["id"];
			$resultt = $db->sql_query($sqlt);
			$rowt = $db->sql_fetchrow($resultt);
			echo "<tr>";
				echo "<form action=\"index.php?op=1021&sop=42\" method=\"post\">";
				echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$_GET["id_user"]."\">";
				echo "<input type=\"Hidden\" name=\"id_caja\" value=\"".$row["id"]."\">";
				echo "<td><select name=\"permiso\" style=\"width:40px\">";
					if ($rowt["total"] == 1) {
						echo "<option value=\"1\" selected>SI</option>";
						echo "<option value=\"0\">NO</option>";
					}
					if ($rowt["total"] == 0) {
						echo "<option value=\"1\">SI</option>";
						echo "<option value=\"0\" selected>NO</option>";
					}
				echo "</select></td>";
				echo "<td><input type=\"Submit\" value=\"Cambiar\"></td>";
				echo "</form>";
				if ($rowt["total"] == 1) {
					$sqlx = "select * from sgm_tpv_permisos where id_user=".$_GET["id_user"]." and id_caja=".$row["id"];
					$resultx = $db->sql_query($sqlx);
					$rowx = $db->sql_fetchrow($resultx);
					echo "<form action=\"index.php?op=1021&sop=43\" method=\"post\">";
					echo "<input type=\"Hidden\" name=\"id_user\" value=\"".$_GET["id_user"]."\">";
					echo "<input type=\"Hidden\" name=\"id_caja\" value=\"".$row["id"]."\">";
					echo "<td><select name=\"admin\" style=\"width:40px\">";
						if ($rowx["admin"] == 1) {
							echo "<option value=\"1\" selected>SI</option>";
							echo "<option value=\"0\">NO</option>";
						}
						if ($rowx["admin"] == 0) {
							echo "<option value=\"1\">SI</option>";
							echo "<option value=\"0\" selected>NO</option>";
						}
					echo "</select></td>";
					echo "<td><input type=\"Submit\" value=\"Cambiar\"></td>";
					echo "</form>";
				}
				if ($rowt["total"] == 0) { echo "<td></td><td></td>"; }
				echo "<td>&nbsp;".$row["nombre"]."</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
		echo "<br>*. Los administradores pueden cerrar cajas automatica y manualmente. Los demás usuarios solo pueden generar tiquets de venta.";
	}

	if (($soption == 42) and ($admin == true)) {
		if ($_POST["permiso"] == 0) {
			$sql = "delete from sgm_tpv_permisos WHERE id_user=".$_POST["id_user"]." and id_caja=".$_POST["id_caja"];
			$db->sql_query($sql);
		}
		if ($_POST["permiso"] == 1) {
			$sql = "insert into sgm_tpv_permisos (id_user,id_caja) ";
			$sql = $sql."values (";
			$sql = $sql."".$_POST["id_user"]."";
			$sql = $sql.",".$_POST["id_caja"]."";
			$sql = $sql.")";
			$db->sql_query($sql);
		}
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=41&id_user=".$_POST["id_user"]."\">[ Volver ]</a>";
		echo "</center>";
	}

	if (($soption == 43) and ($admin == true)) {
		$sql = "update sgm_tpv_permisos set ";
		$sql = $sql."admin=".$_POST["admin"]."";
		$sql = $sql." WHERE id_user=".$_POST["id_user"]." and id_caja=".$_POST["id_caja"];
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=41&id_user=".$_POST["id_user"]."\">[ Volver ]</a>";
		echo "</center>";
	}














	if ($soption == 120) {
		echo "<strong>Gestión Cajas</strong><br>";
		echo "<br><a href=\"index.php?op=1021&sop=121\">&raquo; Añadir Caja</a>";
		echo "<br><br><table>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td><center><em>Almacen</em></center></td>";
			echo "<td><center><em>Población</em></center></td>";
			echo "<td><center><em>Teléfono</em></center></td>";
			echo "<td></td>";
		echo "</tr>";
		$sql = "select * from sgm_tpv_cajas where visible=1 order by nombre";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
		echo "<tr>";
			echo "<td><a href=\"index.php?op=1021&sop=125&id=".$row["id"]."\">[E]</a></td>";
			echo "<td><strong>".$row["nombre"]."</strong></td>";
			echo "<td>".$row["poblacion"]."</td>";
			echo "<td><strong>".$row["telefono"]."</strong></td>";
			echo "<td><a href=\"index.php?op=1021&sop=123&id=".$row["id"]."\">[ Detalles / Modificar ]</a></td>";
		echo "</tr>";
		}
		echo "</table>";
	}

	if ($soption == 121) {
		echo "<strong>Añadir Caja</strong><br><br>";
		echo "<table>";
		echo "<form action=\"index.php?op=1021&sop=122\" method=\"post\">";
		echo "<tr><td><strong>Añadir nueva caja</strong></td><td></td></tr>";
		echo "<tr><td>Nombre</td><td><input type=\"Text\" name=\"nombre\" class=\"px300\"></td></tr>";
		echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"direccion\" class=\"px150\"></td></tr>";
		echo "<tr><td>Población</td><td><input type=\"Text\" name=\"poblacion\" class=\"px150\"></td></tr>";
		echo "<tr><td>Codigo Postal</td><td><input type=\"Text\" name=\"cp\" class=\"px150\"></td></tr>";
		echo "<tr><td>Provincia</td><td><input type=\"Text\" name=\"provincia\" class=\"px150\"></td></tr>";
		echo "<tr><td>E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\"></td></tr>";
		echo "<tr><td>Telefono</td><td><input type=\"Text\" name=\"telefono\" class=\"px150\"></td></tr>";
		echo "<tr><td>Notas</td><td><textarea name=\"notas\" class=\"px300\" rows=\"6\"></textarea></td></tr>";
		echo "<tr><td></td><td><input type=\"Submit\" value=\"Añadir\" style=\"width:150px\"></td></tr>";
		echo "</form>";
		echo "</table>";
	}

	if ($soption == 122) {
		$sql = "insert into sgm_tpv_cajas (nombre,direccion,poblacion,cp,provincia,mail,telefono,notas) ";
		$sql = $sql."values (";
		$sql = $sql."'".$_POST["nombre"]."'";
		$sql = $sql.",'".$_POST["direccion"]."'";
		$sql = $sql.",'".$_POST["poblacion"]."'";
		$sql = $sql.",'".$_POST["cp"]."'";
		$sql = $sql.",'".$_POST["provincia"]."'";
		$sql = $sql.",'".$_POST["mail"]."'";
		$sql = $sql.",'".$_POST["telefono"]."'";
		$sql = $sql.",'".$_POST["notas"]."'";
		$sql = $sql.")";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=120\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 123) {
		$sql = "select * from sgm_tpv_cajas where id=".$_GET["id"];
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		echo "<strong>Modificar Almacen</strong><br><br>";
		echo "<table>";
		echo "<form action=\"index.php?op=1021&sop=124&id=".$_GET["id"]."\" method=\"post\">";
		echo "<tr><td>Nombre</td><td><input type=\"Text\" name=\"nombre\" class=\"px300\" value=\"".$row["nombre"]."\"></td></tr>";
		echo "<tr><td>Dirección</td><td><input type=\"Text\" name=\"direccion\" class=\"px150\" value=\"".$row["direccion"]."\"></td></tr>";
		echo "<tr><td>Población</td><td><input type=\"Text\" name=\"poblacion\" class=\"px150\" value=\"".$row["poblacion"]."\"></td></tr>";
		echo "<tr><td>Codigo Postal</td><td><input type=\"Text\" name=\"cp\" class=\"px150\" value=\"".$row["cp"]."\"></td></tr>";
		echo "<tr><td>Provincia</td><td><input type=\"Text\" name=\"provincia\" class=\"px150\" value=\"".$row["provincia"]."\"></td></tr>";
		echo "<tr><td>E-mail</td><td><input type=\"Text\" name=\"mail\" class=\"px150\" value=\"".$row["mail"]."\"></td></tr>";
		echo "<tr><td>Telefono</td><td><input type=\"Text\" name=\"telefono\" class=\"px150\" value=\"".$row["telefono"]."\"></td></tr>";
		echo "<tr><td>Notas</td><td><textarea name=\"notas\" class=\"px300\" rows=\"6\">".$row["notas"]."</textarea></td></tr>";
		echo "<tr><td></td><td><input type=\"Submit\" value=\"Modificar\" style=\"width:150px\"></td></tr>";
		echo "</form>";
		echo "</table>";
	}

	if ($soption == 124) {
		$sql = "update sgm_tpv_cajas set ";
		$sql = $sql."nombre='".$_POST["nombre"]."'";
		$sql = $sql.",direccion='".$_POST["direccion"]."'";
		$sql = $sql.",poblacion='".$_POST["poblacion"]."'";
		$sql = $sql.",cp='".$_POST["cp"]."'";
		$sql = $sql.",provincia='".$_POST["provincia"]."'";
		$sql = $sql.",mail='".$_POST["mail"]."'";
		$sql = $sql.",telefono='".$_POST["telefono"]."'";
		$sql = $sql.",notas='".$_POST["notas"]."'";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=120\">[ Volver ]</a>";
		echo "</center>";
	}

	if ($soption == 125) {
		echo "<center>";
		echo "¿Seguro que desea eliminar esta caja? Se perderan todos los cierres y la caja actual.";
		echo "<br><br><a href=\"index.php?op=1021&sop=126&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1021&sop=120\">[ NO ]</a>";
		echo "</center>";
	}

	if ($soption == 126) {
		$sql = "update sgm_tpv_cajas set ";
		$sql = $sql."visible=0";
		$sql = $sql." WHERE id=".$_GET["id"]."";
		$db->sql_query($sql);
		echo "<center>";
		echo "Operación realizada correctamente.";
		echo "<br><br><a href=\"index.php?op=1021&sop=120\">[ Volver ]</a>";
		echo "</center>";
	}

	echo "</td></tr></table><br>";

}
?>
