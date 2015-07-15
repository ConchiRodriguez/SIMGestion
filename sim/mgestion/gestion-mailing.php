<?php
error_reporting(~E_ALL);
$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>"; }

if (($option == 1012) AND ($autorizado == true)) {
	echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td>";
			echo "<center><table><tr>";
				echo "<td style=\"height:20px;width:120px;\";><strong>Mailing 3.0 :</strong></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if (($soption == 100) or ($soption == 110) or ($soption == 120) or ($soption == 150) or ($soption == 151) or ($soption == 160)) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1012&sop=100\" class=\"gris\" style=\"color:".$lcolor."\">".$Envio."</a></td>";
				$color = "#4B53AF";
				$lcolor = "white";
				if ($soption == 200) { $color = "white"; $lcolor = "blue"; }
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1012&sop=200\" class=\"gris\" style=\"color:".$lcolor."\">".$Historico."</a></td>";
#				if ($admin == true) {
					$color = "#4B53AF";
					$lcolor = "white";
					if (($soption == 1) or ($soption == 2) or ($soption == 5) or ($soption == 10) or ($soption == 25) or ($soption == 35)) { $color = "white"; $lcolor = "blue"; }
					echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=1012&sop=1\" class=\"gris\" style=\"color:".$lcolor."\">".$Administrar."</a></td>";
#				}
				$color = "red";
				$lcolor = "white";
				echo "<td style=\"height:20px;width:120px;text-align:center;vertical-align:middle;background-color:".$color.";border: 1px solid black\"><a href=\"index.php?op=900&text=".$_GET["op"]."".$_GET["sop"]."\" onclick=\"NewWindow(this.href,'name','400','300','no');return false;\" style=\"color:".$lcolor."\">".$Ayuda."</a></td>";
			echo "</tr></table></center>";
		echo "</td></tr></table><br>";

		echo "<table style=\" border-bottom : 1px solid grey; border-left : 1px solid grey; border-right : 1px solid grey; border-top : 1px solid grey;text-align:center;width:100%\" cellpadding=\"2\" cellspacing=\"2\" ><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
	}

	if ($soption == 1) {
		if ($admin == true) {
		echo "<table>";
			echo "<tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=10\" style=\"color:white;\">".$Carta."/".$Email."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=20\" style=\"color:white;\">".$Configuracion."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=30\" style=\"color:white;\">".$Firma."</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		if ($admin == false) {
			echo "<center><br><strong>USUARIO NO AUTORIZADO</strong></center><br><br>";
		}
	}

	if ($soption == 10) {
		if ($ssoption == 1) {
			$sql1 = "insert into sgm_cartas (asunto,cuerpo,carta,visible) ";
			$sql1 = $sql."values (";
			$sql1 = $sql."'".$_POST["asunto"]."'";
			$sql1 = $sql.",'".comillas($_POST["message"])."'";
			$sql1 = $sql.",'".comillas($_POST["carta"])."'";
			$sql1 = $sql.",1";
			$sql1 = $sql.")";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_cartas set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Carta."</strong>";
		echo "<br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=1\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
				echo "<td style=\"width:170px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=11\" style=\"color:white;\">".$Anadir." ".$Carta."/".$Email."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:300px;\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center\">".$Asunto."</td>";
				echo "<td><em>".$Editar."</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_cartas where visible=1 order by asunto";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "black";
				if ($row["id"] == $_GET["id"]){
					echo "<tr style=\"background-color:#4B53AF;\">";
					$color = "white";
				} else {
					echo "<tr>";
				}
				echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=12&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
				echo "<td style=\"width:200px\">".$row["asunto"]."</td>";
				echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=11&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" border=\"0\"></a></td>";
			echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 11) {
		if ($ssoption == 1){
			if(sizeof($_FILES)==0){
				echo "No se puede subir el archivo";
			}
			$archivo = $_FILES["adjunto"]["tmp_name"];
			$tamanio=array();
			$tamanio = $_FILES["adjunto"]["size"];
			$tipo = $_FILES["adjunto"]["type"];
			$nombre_archivo = $_FILES["adjunto"]["name"];
			extract($_REQUEST);
			if ( $archivo != "none" ){
				$fp = fopen($archivo, "rb");
				$contenido = fread($fp, $tamanio);
				$contenido = addslashes($contenido);
				fclose($fp);
				$sql = "insert into sgm_cartas_adjuntos (id_carta, nombre_archivo, contenido, tamany, tipo )";
				$sql = $sql."values (";
				$sql = $sql.$_GET["id"];
				$sql = $sql.",'".$nombre_archivo."'";
				$sql = $sql.",'".$contenido."'";
				$sql = $sql.",".$tamanio."";
				$sql = $sql.",'".$tipo."'";
				$sql = $sql.")";
				mysql_query($sql);
			}
		}
		if ($ssoption == 2) {
			$sql = "update sgm_cartas set ";
			$sql = $sql."asunto='".$_POST["asunto"]."'";
			$sql = $sql.",cuerpo='".$_POST["message"]."'";
			$sql = $sql.",carta='".$_POST["carta"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if ($ssoption == 3) {
			$sql = "delete from sgm_cartas_adjuntos";
			$sql = $sql." WHERE id=".$_GET["id_adj"]."";
			mysql_query(convert_sql($sql));
		}

	if ($_GET["id"] == "") {
			echo "<strong>".$Anadir." ".$Nueva." ".$Carta."</strong>";
		} else {
			echo "<strong>".$Modificar." ".$Carta."</strong>";
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=10\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center><table><tr><td>";
			echo "<table>";
				if ($_GET["id"] == "") {
					echo "<form action=\"index.php?op=1012&sop=10&ssop=1\" method=\"post\" name=\"post\">";
				} else {
					echo "<form action=\"index.php?op=1012&sop=11&ssop=2&id=".$_GET["id"]."\" method=\"post\" name=\"post\">";
				}
				$sql = "select * from sgm_cartas where visible=1 and id=".$_GET["id"]." order by asunto";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Carta."/".$Email." :</strong></td><td>";
					echo "<select name=\"carta\" style=\"width:120px\">";
						if ($_GET["id"] == ""){
							echo "<option value=\"1\">".$Carta."</option>";
							echo "<option value=\"0\">".$Email."</option>";
						} else {
							$sqlu = "select * from sgm_cartas where id=".$_GET["id"];
							$resultu = mysql_query(convert_sql($sqlu));
							while ($rowu = mysql_fetch_array($resultu)){
								if ($rowu["carta"] == 1) {
									echo "<option value=\"1\" selected>".$Carta."</option>";
									echo "<option value=\"0\">".$Email."</option>";
								} else {
									echo "<option value=\"1\">".$Carta."</option>";
									echo "<option value=\"0\" selected>".$Email."</option>";
								}
							}
						}
					echo "</select>";
				echo "</td></tr>";
				echo "<tr><td style=\"text-align:right\"><strong>".$Asunto." :</strong></td><td><input type=\"Text\" name=\"asunto\" style=\"width:600px\" value=\"".$row["asunto"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Texto." :</strong></td><td><textarea name=\"message\" rows=\"20\" style=\"width:600px\">".$row["cuerpo"]."</textarea></td></tr>";
				echo "<tr><td></td><td>";
					if ($_GET["id"] == "") {
						echo "<input type=\"submit\" value=\"".$Anadir."\" style=\"width:150px\">";
					}else{
						echo "<input type=\"submit\" value=\"".$Modificar."\" style=\"width:150px\">";
					}
				echo "</td></tr></form>";
				echo "<tr><td></td><td>";
					echo "<table><tr><td>";
						echo "<table>";
						echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1012&sop=11&ssop=1&id=".$_GET["id"]."\" method=\"post\">";
						echo "<center>";
							echo "<tr><td><input type=\"file\" name=\"adjunto\" size=\"29px\"></td></tr>";
							echo "<tr><td><input type=\"submit\" value=\"".$Adjuntar."\" style=\"width:200px\"></td></tr>";
						echo "</center>";
						echo "</form>";
						echo "</table>";
					echo "</td><td>";
						echo "<table>";
						$sqlad = "select * from sgm_cartas_adjuntos where id_carta=".$_GET["id"];
						$resultad = mysql_query(convert_sql($sqlad));
						while ($rowad = mysql_fetch_array($resultad)){
							echo "<tr><td><a href=\"".$urloriginal."/mgestion/imagen.php?id=".$rowad["id"]."&tipo=2\" target=\"_blank\">".$rowad["nombre_archivo"]."</a></td>";
							echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=11&ssop=3&id_adj=".$rowad["id"]."&id=".$_GET["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td></tr>";
						}
						echo "</table>";
					echo "</td></tr></table>";
				echo "</td></tr>";
			echo "</table>";
		echo "</td><td style=\"vertical-align:top\">";
			echo "<table><tr><td>&nbsp;</td></tr><tr><td>";
				include ("includes/bbcode3.php");
			echo "</td></tr></table>";
				echo "</td><td style=\"vertical-align:top\">";
		echo "</td></tr></table></center>";
	}

	if ($soption == 12) {
		echo "<center><br><br>¿Seguro que desea eliminar esta carta?";
		echo "<br><br><a href=\"index.php?op=1012&sop=10&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1012&sop=10\">[ NO ]</a></center>";
	}

	if ($soption == 20) {
		if ($ssoption == 1) {
			$sql1 = "insert into sgm_servidores_correo (servidorSMTP,sgm_user,usuari,pass,port,direccio,nom_correu) ";
			$sql1 = $sql1."values (";
			$sql1 = $sql1."'".$_POST["servidorSMTP"]."'";
			$sql1 = $sql1.",'".comillas($_POST["sgm_user"])."'";
			$sql1 = $sql1.",'".comillas($_POST["usuari"])."'";
			$sql1 = $sql1.",'".comillas($_POST["pass"])."'";
			$sql1 = $sql1.",'".comillas($_POST["port"])."'";
			$sql1 = $sql1.",'".comillas($_POST["direccio"])."'";
			$sql1 = $sql1.",'".comillas($_POST["nom_correu"])."'";
			$sql1 = $sql1.")";
			mysql_query(convert_sql($sql1));
		}
		if ($ssoption == 3) {
			$sql = "update sgm_servidores_correo set ";
			$sql = $sql."visible=0";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_servidores_correo set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysql_query(convert_sql($sql));
			$sql = "update sgm_servidores_correo set ";
			$sql = $sql."pred = 1";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$sql = "update sgm_servidores_correo set ";
			$sql = $sql."pred = 0";
			$sql = $sql." WHERE id =".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Servidor." de ".$Correo." ".$Electronico."</strong>";
		echo "<br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=1\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=21\" style=\"color:white;\">".$Anadir." ".$Servidor."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<td><em>".$Predeterminar."</em></td>";
				echo "<td><em>".$Eliminar."</em></td>";
				echo "<td style=\"text-align:center\">".$Servidor."</td>";
				echo "<td><em>".$Editar."</em></td>";
			echo "</tr>";
			$sql = "select * from sgm_servidores_correo where visible=1";
			$result = mysql_query(convert_sql($sql));
			while ($row = mysql_fetch_array($result)) {
				$color = "white";
				if ($row["pred"] == 1) { $color = "#FF4500"; }
					echo "<tr style=\"background-color : ".$color."\">";
					echo "<td>";
				if ($row["pred"] == 1) {
					echo "<form action=\"index.php?op=1012&sop=20&ssop=5&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
					echo "</form>";
					echo "<td style=\"text-align:center;width:50;\"></td>";
				}
				if ($row["pred"] == 0) {
					echo "<form action=\"index.php?op=1012&sop=20&ssop=4&id=".$row["id"]."\" method=\"post\">";
					echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
					echo "</form>";
					echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=22&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td>";
				}
				echo "<td style=\"width:200px\">".$row["servidorSMTP"]."</td>";
				echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=21&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_edit.png\" border=\"0\"></a></td>";
			echo "</tr>";
			}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 21) {
		if ($ssoption == 2) {
			$sql = "update sgm_servidores_correo set ";
			$sql = $sql."servidorSMTP='".$_POST["servidorSMTP"]."'";
			$sql = $sql.",sgm_user='".$_POST["sgm_user"]."'";
			$sql = $sql.",usuari='".$_POST["usuari"]."'";
			$sql = $sql.",pass='".$_POST["pass"]."'";
			$sql = $sql.",port='".$_POST["port"]."'";
			$sql = $sql.",direccio='".$_POST["direccio"]."'";
			$sql = $sql.",nom_correu='".$_POST["nom_correu"]."'";
			$sql = $sql." WHERE id=".$_GET["id"]."";
			mysql_query(convert_sql($sql));
		}
	if ($_GET["id"] == "") {
			echo "<strong>".$Anadir." ".$Nuevo." ".$Servidor."</strong>";
		} else {
			echo "<strong>".$Modificar." ".$Servidor."</strong>";
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=20\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table>";
			if ($_GET["id"] == "") {
				echo "<form action=\"index.php?op=1012&sop=20&ssop=1\" method=\"post\" name=\"post\">";
			} else {
				echo "<form action=\"index.php?op=1012&sop=21&ssop=2&id=".$_GET["id"]."\" method=\"post\" name=\"post\">";
			}
			$sql = "select * from sgm_servidores_correo where visible=1 and id=".$_GET["id"];
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
				echo "<tr><td style=\"text-align:right\"><strong>".$Servidor." SMTP :</strong></td>";
					echo "<td><input type=\"Text\" name=\"servidorSMTP\" style=\"width:200px\" value=\"".$row["servidorSMTP"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Usuario." :</strong></td>";
					echo "<td><input type=\"Text\" name=\"sgm_user\" style=\"width:200px\" value=\"".$row["sgm_user"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Usuario." ".$Correo." :</strong></td>";
					echo "<td><input type=\"Text\" name=\"usuari\" style=\"width:200px\" value=\"".$row["usuari"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Contrasena." ".$Correo." :</strong></td>";
					echo "<td><input type=\"Password\" name=\"pass\" style=\"width:200px\" value=\"".$row["pass"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Puerto." ".$Correo." :</strong></td>";
					echo "<td><input type=\"Text\" name=\"port\" style=\"width:200px\" value=\"".$row["port"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Direccion." ".$Correo." :</strong></td>";
					echo "<td><input type=\"Text\" name=\"direccio\" style=\"width:200px\" value=\"".$row["direccio"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Nombre." ".$Remitente." :</strong></td>";
					echo "<td><input type=\"Text\" name=\"nom_correu\" style=\"width:200px\" value=\"".$row["nom_correu"]."\"></td></tr>";
					if ($_GET["id"] == "") {
						echo "<tr><td></td><td><input type=\"submit\" value=\"".$Anadir."\" style=\"width:150px\"></td></tr>";
					}else{
						echo "<tr><td></td><td><input type=\"submit\" value=\"".$Modificar."\" style=\"width:150px\"></td></tr>";
					}
				echo "</form>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 22) {
		echo "<br><br>¿Seguro que desea eliminar este servidor?";
		echo "<br><br><a href=\"index.php?op=1012&sop=20&ssop=3&id=".$_GET["id"]."\">[ SI ]</a><a href=\"index.php?op=1012&sop=20\">[ NO ]</a>";
	}

	if ($soption == 30) {
		if ($ssoption == 1) {
			$sql = "select count(*) as total from sgm_cartas_firmas where id_user=".$userid."";
			$result = mysql_query(convert_sql($sql));
			$row = mysql_fetch_array($result);
			if ($row["total"] == 0) {
				$sql = "insert into sgm_cartas_firmas (firma,id_user) ";
				$sql = $sql."values (";
				$sql = $sql."'".$_POST["firma"]."'";
				$sql = $sql.",".$userid."";
				$sql = $sql.")";
				mysql_query(convert_sql($sql));
			} else {
				$sql = "update sgm_cartas_firmas set ";
				$sql = $sql."firma='".$_POST["firma"]."'";
				$sql = $sql." WHERE id_user=".$userid."";
				mysql_query(convert_sql($sql));
			}
		}
		if ($ssoption == 4){
			if(sizeof($_FILES)==0){
				echo "No se puede subir el archivo";
			}
			$archivo = $_FILES["adjunto"]["tmp_name"];
			$tamanio=array();
			$tamanio = $_FILES["adjunto"]["size"];
			$tipo = $_FILES["adjunto"]["type"];
			$nombre_archivo = $_FILES["adjunto"]["name"];
			extract($_REQUEST);
			if ( $archivo != "none" ){
				$fp = fopen($archivo, "rb");
				$contenido = fread($fp, $tamanio);
				$contenido = addslashes($contenido);
				fclose($fp);
				$sql = "insert into sgm_cartas_adjuntos (id_user, nombre_archivo, contenido, tamany, tipo )";
				$sql = $sql."values (";
				$sql = $sql.$userid;
				$sql = $sql.",'".$nombre_archivo."'";
				$sql = $sql.",'".$contenido."'";
				$sql = $sql.",".$tamanio."";
				$sql = $sql.",'".$tipo."'";
				$sql = $sql.")";
				mysql_query($sql);
			}
		}
		if ($ssoption == 5) {
			$sql = "delete from sgm_cartas_adjuntos";
			$sql = $sql." WHERE id=".$_GET["id_adj"]."";
			mysql_query(convert_sql($sql));
		}

		echo "<strong>".$Firma." ".$Personal."</strong><br><br>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=1\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center><table><tr><td>";
			echo "<table>";
				echo "<form action=\"index.php?op=1012&sop=30&ssop=1\" method=\"post\" name=\"post\">";
				$sql = "select * from sgm_cartas_firmas where id_user=".$userid."";
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Firma." :</strong></td><td><textarea name=\"firma\" rows=\"20\" style=\"width:600px\">".$row["firma"]."</textarea></td></tr>";
				echo "<tr><td></td><td>";
				echo "<input type=\"submit\" value=\"".$Modificar."\" style=\"width:150px\">";
				echo "</td></tr></form>";
				echo "<tr><td></td><td>";
					echo "<table><tr><td>";
						echo "<table>";
						echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1012&sop=30&ssop=4\" method=\"post\">";
						echo "<center>";
							echo "<tr><td><input type=\"file\" name=\"adjunto\" size=\"29px\"></td></tr>";
							echo "<tr><td><input type=\"submit\" value=\"".$Adjuntar."\" style=\"width:200px\"></td></tr>";
						echo "</center>";
						echo "</form>";
						echo "</table>";
					echo "</td><td>";
						echo "<table>";
						$sqlad = "select * from sgm_cartas_adjuntos where id_user=".$userid;
						$resultad = mysql_query(convert_sql($sqlad));
						while ($rowad = mysql_fetch_array($resultad)){
							echo "<tr><td><a href=\"".$urloriginal."/mgestion/imagen.php?id=".$rowad["id"]."&tipo=2\" target=\"_blank\">".$rowad["nombre_archivo"]."</a></td>";
							echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=30&ssop=5&id_adj=".$rowad["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td></tr>";
						}
						echo "</table>";
					echo "</td></tr></table>";
				echo "</td></tr>";
			echo "</table>";
		echo "</td><td style=\"vertical-align:top\">";
			echo "<table><tr><td>&nbsp;</td></tr><tr><td>";
				include ("includes/bbcode2.php");
			echo "</td></tr></table>";
				echo "</td><td style=\"vertical-align:top\">";
		echo "</td></tr></table></center>";
	}

	if ($soption == 100) {
		$tipos = $_POST["tipo"];
		if ($tipos){
 			foreach ($tipos as $t){$tipo .= $t.",";}
		}
		$tipo = rtrim($tipo, ",");
		$tipo = ltrim($tipo, ",");
		$grupos = $_POST["grupo"];
		if ($grupos){
 			foreach ($grupos as $t){$grupo .= $t.",";}
		}
		$grupo = rtrim($grupo, ",");
		$grupo = ltrim($grupo, ",");
		$sectors = $_POST["sector"];
		if ($sectors){
 			foreach ($sectors as $t){$sector .= $t.",";}
		}
		$sector = rtrim($sector, ",");
		$sector = ltrim($sector, ",");
		$ubicacions = $_POST["ubicacion"];
		if ($ubicacions){
 			foreach ($ubicacions as $t){$ubicacion .= $t.",";}
		}
		$ubicacion = rtrim($ubicacion, ",");
		$ubicacion = ltrim($ubicacion, ",");
		$id_classificacions = $_POST["id_classificacio"];
		if ($id_classificacions){
 			foreach ($id_classificacions as $t){$id_classificacio .= $t.",";}
		}
		$id_classificacio = rtrim($id_classificacio, ",");
		$id_classificacio = ltrim($id_classificacio, ",");
		$servicios = $_POST["servicio"];
		if ($servicios){
 			foreach ($servicios as $t){$servicio .= $t.",";}
		}
		$servicio = rtrim($servicio, ",");
		$servicio = ltrim($servicio, ",");
		$id_sestados = $_POST["id_sestado"];
		if ($id_sestados){
 			foreach ($id_sestados as $t){$id_sestado .= $t.",";}
		}
		$id_sestado = rtrim($id_sestado, ",");
		$id_sestado = ltrim($id_sestado, ",");
		$id_proveedors = $_POST["id_proveedor"];
		if ($id_proveedors){
 			foreach ($id_proveedors as $t){$id_proveedor .= $t.",";}
		}
		$id_proveedor = rtrim($id_proveedor, ",");
		$id_proveedor = ltrim($id_proveedor, ",");
		$certificados = $_POST["certificado"];
		if ($certificados){
 			foreach ($certificados as $t){$certificado .= $t.",";}
		}
		$certificado = rtrim($certificado, ",");
		$certificado = ltrim($certificado, ",");
		$id_cestados = $_POST["id_cestado"];
		if ($id_cestados){
 			foreach ($id_cestados as $t){$id_cestado .= $t.",";}
		}
		$id_cestado = rtrim($id_cestado, ",");
		$id_cestado = ltrim($id_cestado, ",");

		$tipo = str_replace("Array","",$tipo);
		$grupo = str_replace("Array","",$grupo);
		$sector = str_replace("Array","",$sector);
		$ubicacion = str_replace("Array","",$ubicacion);
		$id_classificacio = str_replace("Array","",$id_classificacio);
		$servicio = str_replace("Array","",$servicio);
		$id_sestado = str_replace("Array","",$id_sestado);
		$id_proveedor = str_replace("Array","",$id_proveedor);
		$certificado = str_replace("Array","",$certificado);
		$id_cestado = str_replace("Array","",$id_cestado);

		if ($_POST["dia1"] < 10){$dia1 = "0".$_POST["dia1"];} else {$dia1 = $_POST["dia1"];}
		if ($_POST["dia2"] < 10){$dia2 = "0".$_POST["dia2"];} else {$dia2 = $_POST["dia2"];}
		if ($_POST["mes1"] < 10){$mes1 = "0".$_POST["mes1"];} else {$mes1 = $_POST["mes1"];}
		if ($_POST["mes2"] < 10){$mes2 = "0".$_POST["mes2"];} else {$mes2 = $_POST["mes2"];}
		$desde = $_POST["año1"]."-".$mes1."-".$dia1." 00:00:00";
		$hasta = $_POST["año2"]."-".$mes2."-".$dia2." 23:59:59";

		echo "<strong>".$Buscar." ".$Contacto."</strong><br><br>";
			echo "<form action=\"index.php?op=1012&sop=100\" method=\"post\">";
			echo "<center>";
						echo "<table cellspacing=\"0\">";
							echo "<tr style=\"background-color:silver;\">";
								echo "<td><strong>".$Buscar_Contacto."</strong></td>";
								echo "<td>".$Tipo."</td>";
								echo "<td>".$Grupo."</td>";
								echo "<td>".$Sector."</td>";
								echo "<td>".$Ubicacion."</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>";
									echo "<select multiple name=\"id_classificacio[]\" size=\"10\" style=\"width:354px\">";
										echo "<option value=\"0\">".$Todos."</option>";
										$sqlt = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=0";
										$resultt = mysql_query(convert_sql($sqlt));
										while ($rowt = mysql_fetch_array($resultt)) {
											if (ereg(",".$rowt["id"].",",",".$id_classificacio.",")){
												echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["nom"]."</option>";
											} else {
												echo "<option value=\"".$rowt["id"]."\">".$rowt["nom"]."</option>";
											}
											$sqlti = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowt["id"];
											$resultti = mysql_query(convert_sql($sqlti));
											while ($rowti = mysql_fetch_array($resultti)) {
												if (ereg(",".$rowti["id"].",",",".$id_classificacio.",")){
													echo "<option value=\"".$rowti["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."</option>";
												} else {
													echo "<option value=\"".$rowti["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."</option>";
												}
												$sqltip = "select * from sgm_clients_classificacio_tipus where visible=1 and id_origen=".$rowti["id"];
												$resulttip = mysql_query(convert_sql($sqltip));
												while ($rowtip = mysql_fetch_array($resulttip)) {
													if (",".$rowtip["id"]."," == ",".$_POST["id_classificacio"].","){
														echo "<option value=\"".$rowtip["id"]."\" selected>".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
													} else {
														echo "<option value=\"".$rowtip["id"]."\">".$rowt["nom"]."-".$rowti["nom"]."-".$rowtip["nom"]."</option>";
													}
												}
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"tipo[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqlt = "select * from sgm_clients_tipos order by tipo";
										$resultt = mysql_query(convert_sql($sqlt));
										while ($rowt = mysql_fetch_array($resultt)){
											if (ereg(",".$rowt["id"].",",",".$tipo.",")) {
												echo "<option value=\"".$rowt["id"]."\" selected>".$rowt["tipo"]."</option>";
											} else {
												echo "<option value=\"".$rowt["id"]."\">".$rowt["tipo"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"grupo[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqlg = "select * from sgm_clients_grupos order by grupo";
										$resultg = mysql_query(convert_sql($sqlg));
										while ($rowg = mysql_fetch_array($resultg)){
											if (ereg(",".$rowg["id"].",",",".$grupo.",")) {
												echo "<option value=\"".$rowg["id"]."\" selected>".$rowg["grupo"]."</option>";
											} else {
												echo "<option value=\"".$rowg["id"]."\">".$rowg["grupo"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"sector[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqls = "select * from sgm_clients_sectors order by sector";
										$results = mysql_query(convert_sql($sqls));
										while ($rows = mysql_fetch_array($results)){
											if (ereg(",".$rows["id"].",",",".$sector.",")) {
												echo "<option value=\"".$rows["id"]."\" selected>".$rows["sector"]."</option>";
											} else {
												echo "<option value=\"".$rows["id"]."\">".$rows["sector"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"ubicacion[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqlu = "select * from sgm_clients_ubicacion order by ubicacion";
										$resultu = mysql_query(convert_sql($sqlu));
										while ($rowu = mysql_fetch_array($resultu)){
											if (ereg(",".$rowu["id"].",",",".$ubicacion.",")) {
												echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["ubicacion"]."</option>";
											} else {
												echo "<option value=\"".$rowu["id"]."\">".$rowu["ubicacion"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							echo "<tr style=\"background-color:grey;\">";
								echo "<td><table><tr><td style=\"width:175px\">".$Certificacion."</td>";
								echo "<td>".$Estado_de_la_Certificacion."</td></tr></table></td>";
								echo "<td>".$Servicio."</td>";
								echo "<td>".$Estado_del_Servicio."</td>";
								echo "<td>".$Caracteristicas."</td>";
								echo "<td>".$Proveedor."</td>";
							echo "</tr><tr>";
								echo "<td><table cellspacing=\"2\" cellpadding=\"0\"><tr>";
								echo "<td>";
									echo "<select multiple name=\"certificado[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqlu = "select * from sgm_clients_certificaciones where visible=1 order by nombre";
										$resultu = mysql_query(convert_sql($sqlu));
										while ($rowu = mysql_fetch_array($resultu)){
											if (ereg(",".$rowu["id"].",",",".$certificado.",")) {
												echo "<option value=\"".$rowu["id"]."\" selected>".$rowu["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowu["id"]."\">".$rowu["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"id_cestado[]\" size=\"10\" style=\"width:175px;\">";
										echo "<option value=\"\">-</option>";
										$sqle = "select * from sgm_clients_certificaciones_estados where visible=1 order by nombre";
										$resulte = mysql_query(convert_sql($sqle));
										while ($rowe = mysql_fetch_array($resulte)){
											if (ereg(",".$rowe["id"].",",",".$id_cestado.",")) {
												echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
											}
										}
										echo "</select>";
									echo "</td>";
								echo "</tr></table></td>";
								echo "<td>";
									echo "<select multiple name=\"servicio[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqls = "select * from sgm_incidencias_servicios where visible=1 order by servicio";
										$results = mysql_query(convert_sql($sqls));
										while ($rows = mysql_fetch_array($results)){
											if (ereg(",".$rows["id"].",",",".$servicio.",")) {
												echo "<option value=\"".$rows["id"]."\" selected>".$rows["servicio"]."</option>";
											} else {
												echo "<option value=\"".$rows["id"]."\">".$rows["servicio"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"id_sestado[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqle = "select * from sgm_incidencias_servicios_estados where visible=1 order by nombre";
										$resulte = mysql_query(convert_sql($sqle));
										while ($rowe = mysql_fetch_array($resulte)){
											if (ereg(",".$rowe["id"].",",",".$id_sestado.",")) {
												echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"id_caracteristica[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqlc = "select * from sgm_incidencias_servicios_caracteristicas where visible=1 order by nombre";
										$resultc = mysql_query(convert_sql($sqlc));
										while ($rowc = mysql_fetch_array($resultc)){
											if (ereg(",".$rowc["id"].",",",".$id_caracteristica.",")) {
												echo "<option value=\"".$rowc["id"]."\" selected>".$rowc["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowc["id"]."\">".$rowc["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select multiple name=\"id_proveedor[]\" size=\"10\" style=\"width:175px\">";
										echo "<option value=\"\">-</option>";
										$sqlp = "select * from sgm_incidencias_servicios_proveedores where visible=1 order by nombre";
										$resultp = mysql_query(convert_sql($sqlp));
										while ($rowp = mysql_fetch_array($resultp)){
											if (ereg(",".$rowp["id"].",",",".$id_proveedor.",")) {
												echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowp["id"]."\">".$rowp["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							echo "<tr style=\"background-color:silver;\">";
								echo "<td>".$Contacto."</td>";
								echo "<td>".$Contactos."</td>";
								echo "<td>".$Incidencias."</td>";
								echo "<td>".$Desde."</td>";
								echo "<td>".$Hasta."</td>";
							echo "</tr><tr>";
								echo "<td>";
									echo "<select  name=\"id_client\"  style=\"width:355px\">";
										echo "<option value=\"0\">-</option>";
										$sqlp = "select * from sgm_clients where visible=1 order by nombre";
										$resultp = mysql_query(convert_sql($sqlp));
										while ($rowp = mysql_fetch_array($resultp)){
											if ($_POST["id_client"] == $rowp["id"]) {
												echo "<option value=\"".$rowp["id"]."\" selected>".$rowp["nombre"]."</option>";
											} else {
												echo "<option value=\"".$rowp["id"]."\">".$rowp["nombre"]."</option>";
											}
										}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"contactes\" style=\"width:175px\">";
										echo "<option value=\"0\">NO</option>";
											if ($_POST["contactes"] == 1) {
												echo "<option value=\"1\" selected>SI</option>";
											} else {
												echo "<option value=\"1\">SI</option>";
											}
											if ($_POST["contactes"] == 2) {
												echo "<option value=\"2\" selected>".$Solo_predeterminado."</option>";
											} else {
												echo "<option value=\"2\">".$Solo_predeterminado."</option>";
											}
										echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<select name=\"incidencies\" style=\"width:175px\">";
										echo "<option value=\"0\">NO</option>";
											if ($_POST["incidencies"] == 1) {
												echo "<option value=\"1\" selected>SI</option>";
											} else {
												echo "<option value=\"1\">SI</option>";
											}
									echo "</select>";
								echo "</td>";
								echo "<td>";
									echo "<table cellpadding=\"0\" cellspacing=\"0\">";
										echo "<tr>";
											echo "<td><select name=\"dia1\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 31; $i++){
													if ($_POST["dia1"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"mes1\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 12; $i++){
													if ($_POST["mes1"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"año1\" style=\"width:60px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 2005; $i <= 2100; $i++){
													if ($_POST["año1"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td>";
										echo "</tr>";
									echo "</table>";
								echo "</td>";
								echo "<td>";
									echo "<table cellpadding=\"0\" cellspacing=\"0\">";
										echo "<tr>";
											echo "<td><select name=\"dia2\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 31; $i++){
													if ($_POST["dia2"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"mes2\" style=\"width:40px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 1; $i <= 12; $i++){
													if ($_POST["mes2"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td><td style=\"width:17px;text-aling:left;\">&nbsp;&nbsp;/</td>";
											echo "<td><select name=\"año2\" style=\"width:60px;\">";
												echo "<option value=\"0\">-</option>";
												for ($i = 2005; $i <= 2100; $i++){
													if ($_POST["año2"] == $i){
														echo "<option value=\"".$i."\" selected>".$i."</option>";
													} else {
														echo "<option value=\"".$i."\">".$i."</option>";
													}
												}
											echo "</select></td>";
										echo "</tr>";
									echo "</table>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "<br>";
						echo "<table cellpadding=\"0\" cellspacing=\"1\">";
							echo "<tr>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								for ($i = 0; $i <= 127; $i++) {
									if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
										echo "<td style=\"color:black;text-align: center;\">".chr($i)."</td>";
									}
								}
							echo "</tr>";
							echo "<tr>";
								echo "<td style=\"color:black;text-align: right;\"><strong>".$Nombre."</strong></td>";
								echo "<td style=\"color:black;text-align: leftt;width:160px\"><input type=\"Text\" name=\"likenombre\" value=\"".$_POST["likenombre"]."\" style=\"width:150px\"></td>";
								echo "<td></td>";
								echo "<td style=\"color:black;text-align: right;\"><strong>".$Inicial."</strong></td>";
								for ($i = 0; $i <= 127; $i++) {
									if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
										echo "<td style=\"color:black;text-align: center;\"><input type=\"Checkbox\" name=\"".chr($i)."\"";
										if ($_POST[chr($i)] == true) { echo " checked"; }
										echo " value=\"true\" style=\"border:0px solid black\"></td>";
									}
								}
							echo "</tr>";
			echo "</table>";
			echo "<br>";
			echo "<input type=\"Submit\" value=\"".$Buscar."\" style=\"width:200px\">";
			echo "</center>";
			echo "</form>";
			echo "<br><br>";


		##################################################
		################### BUSCADOR   ###################
		##################################################
						echo $_POST["id_classificacio"]."xxx";
		if (($_POST["id_classificacio"] != "") or ($_POST["tipo"] != "")) {

		$calidad = 0;
		$sqlc = "select count(*) as total  from sgm_users_permisos_modulos where visible=1 and id_modulo=1012";
		$resultc = mysql_query(convert_sql($sqlc));
		$rowc = mysql_fetch_array($resultc);
		if ($rowc["total"] == 1) { $calidad = 1; }
		echo "<center>";
		echo "<br><strong>CONTACTOS</strong> en orden alfabético :";
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				echo "<a href=\"#".chr($i)."\"><strong>".chr($i)."</strong></a>&nbsp;";
			}
		}
		echo "<br><br>";

		echo "<form name=\"formulari\" action=\"index.php?op=1012&sop=110\" method=\"post\">";
		echo "<table>";
			echo "<tr>";
				echo "<td>";
					echo "<table>";
						echo "<tr>";

							echo "<td style=\"width:170px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\"><a href=\"javascript:marcar()\" style=\"color:white;\">".$Marcar." ".$Contacto."</a></td>";
							echo "<td style=\"width:170px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\"><a href=\"javascript:desmarcar()\" style=\"color:white;\">".$Desmarcar." ".$Contacto."</a></td>";

							echo "<td style=\"width:170px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\"><a href=\"javascript:marcar_perso()\" style=\"color:white;\">".$Marcar." ".$Personal."</a></td>";
							echo "<td style=\"width:170px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\"><a href=\"javascript:desmarcar_perso()\" style=\"color:white;\">".$Desmarcar." ".$Personal."</a></td>";

						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" style=\"width:700px\">";
		$z = 0;
		#### DETERMINA SI HAY FILTRO POR INICIO LETRA
		$ver_todas_letras = true;
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or(($i >= 65) and ($i <= 90))) {
				if ($_POST[chr($i)] == true) {
					$ver_todas_letras = false;
				}
			}
		}
		#### INICIA BUCLE TODAS LAS LETRAS
		for ($i = 0; $i <= 127; $i++) {
			if ((($i >= 48) and ($i <= 57)) or (($i >= 65) and ($i <= 90))) {
				$linea_letra = 1;
				$color = "white";
				$calidad = 0;
				$sql = "select * from sgm_clients where visible=1";
				if ($tipo != "") { $sql = $sql." and id_tipo in (".$tipo.")"; }
				if ($grupo != "") { $sql = $sql." and id_grupo in (".$grupo.")"; }
				if ($sector != "") { $sql = $sql." and sector in (".$sector.")"; }
				if ($ubicacion != "") { $sql = $sql." and id_ubicacion in (".$ubicacion.")"; }
				if ($_POST["id_client"] != 0) { $sql = $sql." and id=".$_POST["id_client"]; }
				$sql = $sql." and nombre like '".chr($i)."%'";
				if ($_POST["likenombre"] != "") {
					$sql = $sql." and (nombre like '%".$_POST["likenombre"]."%' or cognom1 like '%".$_POST["likenombre"]."%' or cognom2 like '%".$_POST["likenombre"]."%')";
				}
				$sql =$sql." order by nombre,cognom1,cognom2,id_origen";
				$result = mysql_query(convert_sql($sql));
				while ($row = mysql_fetch_array($result)) {
					if(($_GET["id_classificacio"] != 0) OR ($id_classificacio != 0)){
						if ($row["id_agrupacio"] == 0){$ver = true;} else {$ver = false;}
					} else {
						$ver = true;
					}
					#### NO MOSTRARA SI LA LETRA NO ESTA SELECCIONADA
					if ($ver_todas_letras == false) {
						if ($_POST[chr($i)] != true) {
							$ver = false;
						}
					}
					#### BUSCA TIPUS
					if (($ver == true) and (($_GET["id_classificacio"] != 0) OR ($id_classificacio != 0))) {
						if (($_GET["id_classificacio"] != "") OR ($id_classificacio != 0))  {
							if ($_GET["id_classificacio"] != "") { $id_classificacio = $_GET["id_classificacio"]; }
							$sqlcxx = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus in (".$id_classificacio.")";
							$resultcxx = mysql_query(convert_sql($sqlcxx));
							$rowcxx = mysql_fetch_array($resultcxx);
							if ($rowcxx["total"] <= 0) { $ver = false; }
							$sqlcxx2 = "select * from sgm_clients_classificacio_tipus where id_origen in (".$id_classificacio.")";
							$resultcxx2 = mysql_query(convert_sql($sqlcxx2));
							while ($rowcxx2 = mysql_fetch_array($resultcxx2)) {
								$sqlcxx3 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx2["id"];
								$resultcxx3 = mysql_query(convert_sql($sqlcxx3));
								$rowcxx3 = mysql_fetch_array($resultcxx3);
								if ($rowcxx3["total"] > 0) { $ver = true; }
								$sqlcxx4 = "select * from sgm_clients_classificacio_tipus where id_origen=".$rowcxx2["id"];
								$resultcxx4 = mysql_query(convert_sql($sqlcxx4));
								while ($rowcxx4 = mysql_fetch_array($resultcxx4)) {
									$sqlcxx5 = "select count(*) as total  from sgm_clients_classificacio where id_client=".$row["id"]." and visible=1 and id_clasificacio_tipus=".$rowcxx4["id"];
									$resultcxx5 = mysql_query(convert_sql($sqlcxx5));
									$rowcxx5 = mysql_fetch_array($resultcxx5);
									if ($rowcxx5["total"] > 0) { $ver = true; }
								}
							}
						}
					}
					#### BUSCA SERVEIS
					if ($ver == true) {
						if ($_POST["incidencies"] == 0) {
							if (($servicio == "") and ($id_sestado == "") and ($id_caracteristica == "") and ($id_proveedor == "")) {
								$ver = true;
							} else {
								$sqlmostrar = "select count(*) as total from sgm_incidencias_servicios_cliente where id_cliente=".$row["id"];
									if ($servicio != "") { $sqlmostrar = $sqlmostrar." and id_servicio in (".$servicio.")"; }
									if ($id_sestado != "") {
										$sqlmostrar = $sqlmostrar." and id_estado in (".$id_sestado.")";
									} else {
										$sqlmostrar = $sqlmostrar." and id_estado<>0";
									}
									if ($id_caracteristica != "") { $sqlmostrar = $sqlmostrar." and id_proveedor_caracteristica in (".$id_classificacio.")"; }
									if ($id_proveedor != "") { $sqlmostrar = $sqlmostrar." and id_proveedor in (".$id_proveedor.")"; }
								$sqlmostrar = $sqlmostrar." and visible=1";
								$resultmostrar = mysql_query(convert_sql($sqlmostrar));
								$rowmostrar = mysql_fetch_array($resultmostrar);
								if ($rowmostrar["total"] <= 0) {
									$ver = false;
								}
							}
						} else {
							if (($desde > 0) and ($hasta > 0)){
								$sqli = "select count(*) as total from sgm_incidencias where visible=1 and ((data_prevision>'".$desde."') or (data_prevision='".$desde."')) and ((data_prevision<'".$hasta."') or (data_prevision='".$hasta."')) and id_cliente=".$row["id"];
							} else {
								$sqli = "select count(*) as total from sgm_incidencias where visible=1 and id_cliente=".$row["id"];
							}
								if ($_POST["servicio"] != 0) { $sqli = $sqli." and id_servicio in (".$servicio.")"; }
								$resulti = mysql_query(convert_sql($sqli));
								$rowi = mysql_fetch_array($resulti);
								if ($rowi["total"] <= 0 ){ $ver = false;}
						}
					}
					#### BUSCA CERTIFICATS
					if ($ver == true) {
						if (($certificado == "") and ($id_cestado == "")) {
							$ver = true;
						} else {
							$sqlmostrar = "select count(*) as total from sgm_clients_certificaciones_cliente where id_cliente=".$row["id"];
								if ($certificado != "") { $sqlmostrar = $sqlmostrar." and id_certificado in (".$certificado.")"; }
								if ($id_cestado != "") { $sqlmostrar = $sqlmostrar." and id_estado in (".$id_cestado.")"; }
							$resultmostrar = mysql_query(convert_sql($sqlmostrar));
							$rowmostrar = mysql_fetch_array($resultmostrar);
							if ($rowmostrar["total"] <= 0) {
								$ver = false;
							}
						}
					}
					#### INICI IMPRESIO PANTALLA
					if ($ver == true) {
						if ($linea_letra == 1) {
							echo "<tr style=\"background-color: Silver;\">";
								echo "<td><a href=\"#indice\" name=\"".chr($i)."\" style=\"color:black;\"><strong>^".chr($i)."</strong></a></td>";
								echo "<td style=\"width:350px;\"><center><em>".$Nombre." ".$Cliente."</em></center></td>";
								echo "<td></td>";
								echo "<td><em>".$Enviar."</em></td>";
								echo "<td><em>".$Email."</em></td>";
								echo "<td><em>".$Carta."</em></td>";
								echo "<td><em>".$Etiqueta."</em></td>";
							echo "</tr>";
							$linea_letra = 0;
						}
						ver_contacto_mailing($row["id"],$color,$_POST["contactes"],$check);
						if ($color == "white") { $color = "#F5F5F5"; } else { $color = "white"; }
						$z++;
					}
				}
			}
		}
			#### FIN TABLA, MUESTRA NUMERO RESULTADOS Y LEYENDA
			echo "</table>";
			echo "<table><tr>";
					echo "<td style=\"text-align:center;\"><input type=\"Submit\" value=\"".$Enviar."\" style=\"width:200px\"></td>";
			echo "</tr></table>";
			echo "</center>";
			echo "</form>";
			echo "<br><br>";
		}
	}

	if ($soption == 110) {
		$clients = $_POST["enviar"];
		for ($i = 0 ; $i < count($clients); $i++){
			$clientes = $clientes.$clients[$i].",";
		}
		$contactes = $_POST["enviar_perso"];
		for ($i = 0 ; $i < count($contactes); $i++){
			$contacs = $contacs.$contactes[$i].",";
		}

		echo "<strong>".$Envio."</strong>";
		echo "<br><br>";
		echo "<table><tr>";
			echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
				echo "<a href=\"index.php?op=1012&sop=100\" style=\"color:white;\">&laquo; ".$Volver."</a>";
			echo "</td>";
		echo "</tr></table>";
		echo "<br><br><br>";
		echo "<center>";
		echo "<table cellspacing=\"0\" style=\"width:200px;\">";
			echo "<tr>";
				echo "<form action=\"index.php?op=1012&sop=120\" method=\"post\">";
				echo "<td>";
					echo "<select name=\"e-mail\" style=\"width:170px\">";
						$sqle = "select * from sgm_cartas where visible=1 and carta=0 order by asunto";
						$resulte = mysql_query(convert_sql($sqle));
						while ($rowe = mysql_fetch_array($resulte)){
							echo "<option value=\"".$rowe["id"]."\">".$rowe["asunto"]."</option>";
						}
					echo "</select>";
					echo "<input type=\"Hidden\" name=\"clients\" value=\"".$clientes."\">";
					echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$contacs."\">";
				echo "</td>";
				echo "<td><input type=\"submit\" value=\"".$Email."\" style=\"width:120px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"".$urloriginal."/mgestion/gestion-mailing-print.php?\" target=\"_blank\" method=\"post\" name=\"post\">";
				echo "<td>";
					echo "<select name=\"carta\" style=\"width:170px\">";
						$sqlc = "select * from sgm_cartas where visible=1 and carta=1 order by asunto";
						$resultc = mysql_query(convert_sql($sqlc));
						while ($rowc = mysql_fetch_array($resultc)){
							echo "<option value=\"".$rowc["id"]."\">".$rowc["asunto"]."</option>";
						}
					echo "</select>";
					echo "<input type=\"Hidden\" name=\"clients\" value=\"".$clientes."\">";
					echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$contacs."\">";
				echo "</td>";
				echo "<td><input type=\"submit\" value=\"".$Carta."\" style=\"width:120px;\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"".$urloriginal."/mgestion/gestion-clientes-eti-print.php?\" target=\"_blank\" method=\"post\" name=\"post\">";
				echo "<td>";
					echo "<select name=\"etiquetas\" style=\"width:170px\">";
							echo "<option value=\"0\">Contactos</option>";
							echo "<option value=\"1\">Personales</option>";
					echo "</select>";
					echo "<input type=\"Hidden\" name=\"clients\" value=\"".$clientes."\">";
					echo "<input type=\"Hidden\" name=\"contactes\" value=\"".$contacs."\">";
				echo "</td>";
				echo "<td><input type=\"submit\" value=\"".$Etiqueta."\" style=\"width:120px;\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 120) {
		echo "<strong>".$Email."</strong>";
		echo "<br>";
		echo "<center><table><tr><td>";
			echo "<table>";
				echo "<form action=\"index.php?op=1012&sop=130\" method=\"post\">";
				$sql = "select * from sgm_cartas where visible=1 and id=".$_POST["e-mail"];
				$result = mysql_query(convert_sql($sql));
				$row = mysql_fetch_array($result);
				$sqlf = "select * from sgm_cartas_firmas where id_user=".$userid."";
				$resultf = mysql_query(convert_sql($sqlf));
				$rowf = mysql_fetch_array($resultf);
				$sqla = "select * from sgm_cartas_adjuntos where id_user=".$userid;
				$resulta = mysql_query(convert_sql($sqla));
				$rowa = mysql_fetch_array($resulta);
				echo "<tr><td style=\"text-align:right\"><strong>".$Asunto." :</strong></td><td><input type=\"Text\" name=\"asunto\" style=\"width:600px\" value=\"".$row["asunto"]."\"></td></tr>";
				echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Texto." :</strong></td><td><textarea name=\"cuerpo\" rows=\"20\" style=\"width:600px\">".$row["cuerpo"]."\n\n\n".$rowf["firma"]."</textarea></td></tr>";
				echo "<input type=\"Hidden\" name=\"client\" value=\"".$_POST["clients"]."\">";
				echo "<input type=\"Hidden\" name=\"contact\" value=\"".$_POST["contactes"]."\">";
				echo "<input type=\"Hidden\" name=\"mail\" value=\"".$row["id"]."\">";
				echo "<tr><td></td><td>";
				echo "<input type=\"submit\" value=\"".$Enviar."\" style=\"width:150px\">";
				echo "</td></tr></form>";
			echo "</table>";
		echo "</td><td style=\"vertical-align:top;\">";
			echo "<table>";
				echo "<tr><td><strong>".$Archivos." ".$Adjuntos." : </strong></td></tr>";
				$sqlad = "select * from sgm_cartas_adjuntos where id_carta=".$_POST["e-mail"];
				$resultad = mysql_query(convert_sql($sqlad));
				while ($rowad = mysql_fetch_array($resultad)){
							echo "<tr><td><a href=\"".$urloriginal."/mgestion/imagen.php?id=".$rowad["id"]."&tipo=2\" target=\"_blank\">".$rowad["nombre_archivo"]."</a></td>";
						}
			echo "</table>";
		echo "</td></tr></table></center>";
	}

	if ($soption == 130) {
		$clients = $_POST["client"];
		$contactes = $_POST["contact"];
		for ($i = 0 ; $i < strlen($clients) ; $i++){
			while ($clients[$i] != ",") {
				$id = $id.$clients[$i];
				$i++;
			}
			$sqle = "select * from sgm_clients where visible=1 and id=".$id;
			$resulte = mysql_query(convert_sql($sqle));
			$rowe = mysql_fetch_array($resulte);

			if ($rowe["mail"] != ""){
				send_mail($_POST["asunto"],$_POST["cuerpo"],$_POST["mail"],$id,$rowe["mail"],$urloriginal);
			}
			$id = "";
		}
		for ($i = 0 ; $i < strlen($contactes) ; $i++){
			while ($contactes[$i] != ",") {
				$id = $id.$contactes[$i];
				$i++;
			}
			$sqle = "select * from sgm_clients_contactos where visible=1 and id=".$id;
			$resulte = mysql_query(convert_sql($sqle));
			$rowe = mysql_fetch_array($resulte);

			if ($rowe["mail"] != ""){
				send_mail($_POST["asunto"],$_POST["cuerpo"],$_POST["mail"],$id,$rowe["mail"],$urloriginal);
			}
			$id = "";
		}
	}

	if ($soption == 150) {
		if ($_GET["guardar"] == 1){
			if(sizeof($_FILES)==0){
				echo "No se puede subir el archivo";
			}
			$archivo = $_FILES["adjunto"]["tmp_name"];
			$tamanio=array();
			$tamanio = $_FILES["adjunto"]["size"];
			$tipo = $_FILES["adjunto"]["type"];
			$nombre_archivo = $_FILES["adjunto"]["name"];
			extract($_REQUEST);
			if ( $archivo != "none" ){
				$fp = fopen($archivo, "rb");
				$contenido = fread($fp, $tamanio);
				$contenido = addslashes($contenido);
				fclose($fp);
				$sql = "insert into sgm_cartas_adjuntos (id_carta, nombre_archivo, contenido, tamany, tipo )";
				$sql = $sql."values (";
				$sql = $sql."0";
				$sql = $sql.",'".$nombre_archivo."'";
				$sql = $sql.",'".$contenido."'";
				$sql = $sql.",".$tamanio."";
				$sql = $sql.",'".$tipo."'";
				$sql = $sql.")";
				mysql_query($sql);
			}
		}
		if ($_GET["borrar"] == 1) {
			$sql = "delete from sgm_cartas_adjuntos";
			$sql = $sql." WHERE id=".$_GET["id_adj"]."";
			mysql_query(convert_sql($sql));
		}

		if ($ssoption == 1){
			echo "<strong>".$Email." ".$Personal."</strong><br><br>";
		}
		if ($ssoption == 2){
			echo "<strong>".$Carta." ".$Personal."</strong><br><br>";
		}
		if ($_GET["x"] == 1) {
			$sqle = "select * from sgm_clients where visible=1 and id=".$_GET["id"];
			$resulte = mysql_query(convert_sql($sqle));
			$rowe = mysql_fetch_array($resulte);
		}
		if ($_GET["x"] == 2) {
			$sqle = "select * from sgm_clients_contactos where visible=1 and id=".$_GET["id"];
			$resulte = mysql_query(convert_sql($sqle));
			$rowe = mysql_fetch_array($resulte);
		}
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=100\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center>";
		echo "<table>";
		$sqlf = "select * from sgm_cartas_firmas where id_user=".$userid."";
		$resultf = mysql_query(convert_sql($sqlf));
		$rowf = mysql_fetch_array($resultf);
		if ($ssoption == 1){
			echo "<tr><td style=\"vertical-align:top\">";

			echo "<table>";
			echo "<form action=\"index.php?op=1012&sop=151&id=".$_GET["id"]."&x=".$_GET["x"]."\" method=\"post\">";
			echo "<tr><td></td><td><strong>".$Email." ".$Para." : ".$rowe["nombre"]." ".$rowe["apellido1"]." ".$rowe["apellido2"]." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right\"><strong>".$Asunto." :</strong></td><td><input type=\"Text\" name=\"asunto\" style=\"width:800px\" value=\"".$row["asunto"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Texto." :</strong></td><td><textarea name=\"cuerpo\" rows=\"15\" style=\"width:800px\">".$row["cuerpo"]."\n\n\n".$rowf["firma"]."</textarea></td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"".$Enviar."\" style=\"width:150px\"></td></tr>";
			echo "</form>";
			echo "</table>";

			echo "</td><td style=\"vertical-align:top\">";

				echo "<table>";
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<form enctype=\"multipart/form-data\" action=\"index.php?op=1012&sop=150&ssop=1&guardar=1&id=".$_GET["id"]."&x=".$_GET["x"]."\" method=\"post\">";
				echo "<center>";
					echo "<tr><td><input type=\"file\" name=\"adjunto\" size=\"29px\"></td></tr>";
					echo "<tr><td><input type=\"submit\" value=\"".$Adjuntar."\" style=\"width:200px\"></td></tr>";
				echo "</center>";
				echo "</form>";
				echo "</table>";
				echo "<table>";
				$sqlad = "select * from sgm_cartas_adjuntos where id_carta=0";
				$resultad = mysql_query(convert_sql($sqlad));
				while ($rowad = mysql_fetch_array($resultad)){
					echo "<tr><td><a href=\"".$urloriginal."/mgestion/imagen.php?id=".$rowad["id"]."&tipo=2\" target=\"_blank\">".$rowad["nombre_archivo"]."</a></td>";
					echo "<td style=\"text-align:center;width:50;\"><a href=\"index.php?op=1012&sop=150&ssop=1&borrar=1&id_adj=".$rowad["id"]."&id=".$_GET["id"]."&x=".$_GET["x"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" border=\"0\"></a></td></tr>";
				}
				echo "</table>";

			echo "</td></tr>";
			echo "<tr><td>* Antes de escribir el mensaje, adjunte los ficheros necesarios.</td></tr>";
		}
		if ($ssoption == 2){
			echo "<form action=\"".$urloriginal."/mgestion/gestion-mailing-print.php?\" target=\"_blank\" method=\"post\" name=\"post\">";
			echo "<tr><td></td><td><strong>".$Carta." ".$Para." : ".$rowe["nombre"]." ".$rowe["apellido1"]." ".$rowe["apellido2"]." ".$rowe["cognom1"]." ".$rowe["cognom2"]."</strong></td></tr>";
			echo "<tr><td style=\"text-align:right\"><strong>".$Asunto." :</strong></td><td><input type=\"Text\" name=\"asunto\" style=\"width:800px\" value=\"".$row["asunto"]."\"></td></tr>";
			echo "<tr><td style=\"text-align:right;vertical-align:top;\"><strong>".$Texto." :</strong></td><td><textarea name=\"message\" rows=\"15\" style=\"width:800px\">".$row["cuerpo"]."</textarea></td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"".$Imprimir."\" style=\"width:150px\"></td></tr>";
			echo "</form>";

			$sql1 = "insert into sgm_cartas_enviadas (id_user,id_client,id_carta,fecha) ";
			$sql1 = $sql1."values (";
			$sql1 = $sql1."".$userid;
			$sql1 = $sql1.",".$rowe["id"];
			$sql1 = $sql1.",".$row["id"];
			$date = getdate(); 
			$fecha = $date["year"]."-".$date["mon"]."-".$date["mday"];
			$sql1 = $sql1.",'".$fecha."'";
			$sql1 = $sql1.")";
			mysql_query(convert_sql($sql1));
		}
		echo "</table>";
		echo "</center>";
	}

	if ($soption == 151) {
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=100\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		if ($_GET["x"] == 1) {
			$sqle = "select * from sgm_clients where visible=1 and id=".$_GET["id"];
			$resulte = mysql_query(convert_sql($sqle));
			$rowe = mysql_fetch_array($resulte);
		}
		if ($_GET["x"] == 2) {
			$sqle = "select * from sgm_clients_contactos where visible=1 and id=".$_GET["id"];
			$resulte = mysql_query(convert_sql($sqle));
			$rowe = mysql_fetch_array($resulte);
		}

			if ($rowe["mail"] != ""){
				send_mail($_POST["asunto"],$_POST["cuerpo"],$_POST["mail"],$id,$rowe["mail"],$urloriginal);
			}
	}

	if ($soption == 160) {
		echo "<strong>".$Posicion." ".$Etiqueta."</strong>";
		echo "<table><tr>";
				echo "<td style=\"width:100px;height:20px;text-align:center;vertical-align:middle;background-color:#4B53AF;border:1px solid black\">";
					echo "<a href=\"index.php?op=1012&sop=100\" style=\"color:white;\">&laquo; ".$Volver."</a>";
				echo "</td>";
		echo "</tr></table>";
		echo "<br>";
		echo "<center>";
		echo "<table cellspacing=\"0\">";
			echo "<tr style=\"background-color:silver;\">";
				echo "<td>".$Posicion."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<form action=\"".$urloriginal."/mgestion/gestion-clientes-eti-print-personales.php?\" target=\"_blank\" method=\"post\">";
				echo "<td>";
					echo "<select name=\"posicion\" style=\"width:50px\">";
							echo "<option value=\"0\">1</option>";
							echo "<option value=\"1\">2</option>";
							echo "<option value=\"2\">3</option>";
							echo "<option value=\"3\">4</option>";
							echo "<option value=\"4\">5</option>";
							echo "<option value=\"5\">6</option>";
							echo "<option value=\"6\">7</option>";
							echo "<option value=\"7\">8</option>";
							echo "<option value=\"8\">9</option>";
							echo "<option value=\"9\">10</option>";
							echo "<option value=\"10\">11</option>";
							echo "<option value=\"11\">12</option>";
							echo "<option value=\"12\">13</option>";
							echo "<option value=\"13\">14</option>";
					echo "</select>";
				echo "</td>";
				echo "<input type=\"Hidden\" name=\"cliente\" value=\"".$_GET["id"]."\">";
				echo "<input type=\"Hidden\" name=\"personal\" value=\"".$_GET["x"]."\">";
				echo "<td><input type=\"submit\" value=\"".$Imprimir."\" style=\"width:80px;\"></td>";
				echo "</form>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 200) {
		echo "<strong>".$Historico." de ".$Correo."</strong><br><br>";
		echo "<center><table><tr>";
				echo "<td>".$Buscar." ".$Por.": </td>";
				echo "<td>".$Cliente."</td>";
				echo "<td>".$Formato."</td>";
				echo "<td></td>";
			echo "</tr><tr>";
				echo "<td><form action=\"index.php?op=1012&sop=200\" method=\"post\"></td>";
				echo "<td>";
				echo "<select name=\"id_client\" style=\"width:300px\">";
					$sqle = "select * from sgm_clients where visible=1 order by nombre";
					$resulte = mysql_query(convert_sql($sqle));
					while ($rowe = mysql_fetch_array($resulte)){
						if ($_POST["id_client"] == $rowe["id"]){
							echo "<option value=\"".$rowe["id"]."\" selected>".$rowe["nombre"]."</option>";
						} else {
							echo "<option value=\"".$rowe["id"]."\">".$rowe["nombre"]."</option>";
						}
					}
				echo "</select>";
				echo "</td>";
				echo "<td>";
				echo "<select name=\"carta\" style=\"width:100px\">";
					if ($_POST["carta"] == 0){
						echo "<option value=\"1\">".$Carta."</option>";
						echo "<option value=\"0\" selected>".$Email."</option>";
					} else {
						echo "<option value=\"1\">".$Carta."</option>";
						echo "<option value=\"0\">".$Email."</option>";
					}
				echo "</select>";
				echo "</td>";
				echo "<td><input type=\"submit\" value=\"".$Buscar."\" style=\"width:150px;\"></td>";
		echo "</tr></table>";
		if ($_POST["id_client"] != "") {
			echo "<table cellspacing=\"0\" style=\"width:800px;\">";
				echo "<tr style=\"background-color:silver;\">";
					echo "<td style=\"width:100px;\">".$Fecha."</td>";
					echo "<td style=\"width:200px;\">".$Usuario."</td>";
					echo "<td style=\"width:300px;\">".$Cliente."</td>";
					echo "<td style=\"width:200px;\">".$Asunto."</td>";
				echo "</tr>";
			$sqls = "select * from sgm_cartas_enviadas where id_client=".$_POST["id_client"];
			$results = mysql_query(convert_sql($sqls));
			while ($rows = mysql_fetch_array($results)) {
				$sqlc = "select * from sgm_cartas where id=".$rows["id_carta"]." and carta=".$_POST["carta"];
				$resultc = mysql_query(convert_sql($sqlc));
				$rowc = mysql_fetch_array($resultc);
				if ($rowc){
					$sqlu = "select * from sgm_users where id=".$rows["id_user"];
					$resultu = mysql_query(convert_sql($sqlu));
					$rowu = mysql_fetch_array($resultu);
					$sqle = "select * from sgm_clients where id=".$rows["id_client"];
					$resulte = mysql_query(convert_sql($sqle));
					$rowe = mysql_fetch_array($resulte);
					echo "<tr>";
						echo "<td style=\"width:100px;\">".$rows["fecha"]."</td>";
						echo "<td style=\"width:200px;\">".$rowu["usuario"]."</td>";
						echo "<td style=\"width:300px;\">".$rowe["nombre"]."</td>";
						echo "<td style=\"width:200px;\">".$rowc["asunto"]."</td>";
					echo "</tr>";
				}
			}
			echo "</table></center>";
		}
	}




	echo "</td></tr></table><br>";

}

function send_mail($asunto,$cuerpo,$mail,$id,$mail_dest,$urloriginal){
	$sqls = "select * from sgm_servidores_correo where pred=1";
	$results = mysql_query(convert_sql($sqls));
	$rows = mysql_fetch_array($results);

	$UN_SALTO="\r\n";
	$DOS_SALTOS="\r\n\r\n";

	$destinatario = $mail_dest;
	$titulo = $asunto;
	$mensaje = "<html><head></head><body bgcolor=\"#0000ff\">";
	$mensaje .= "<font face=\"Tahoma\" size=10>";
	$mensaje = ver_carta($cuerpo,$id,1);
	$mensaje .= "</font>";

	$nombre_archivo = "C:\\Archivos de programa\\EasyPHP5.3.0\\www\\demo\\temporal\\logo.jpeg";
	$file=fopen($nombre_archivo,'w+');
	if (is_writable($nombre_archivo)) {
		$sql = "select * from sgm_logos where clase=4";
		$result = mysql_query(convert_sql($sql));
		$row = mysql_fetch_array($result);
		if (fwrite($file,$row["contenido"]) === FALSE) {
			mensaje_error("No se puede escribir al archivo (".$nombre_archivo.")");
			exit;
		}
		fclose($file);
	} else {
		mensaje_error("No se puede escribir al archivo (".$nombre_archivo.")");
	}

	$mensaje .= "<br><img src=\"".$urloriginal."/temporal/logo.jpeg\">";

	$responder = $rows["direccio"];
	$remite = $rows["direccio"];
	$remitente = $rows["sgm_user"];

	$separador = "_separador_de_trozos_".md5 (uniqid (rand())); 
	$cabecera = "MIME-Version: 1.0".$UN_SALTO; 
	$cabecera .= "From: ".$remitente."<".$remite.">".$UN_SALTO;
	$cabecera .= "Return-path: ". $remite.$UN_SALTO;
	$cabecera .= "Reply-To: ".$remite.$UN_SALTO;
	$cabecera .="X-Mailer: PHP/". phpversion().$UN_SALTO;
	$cabecera .= "Content-Type: multipart/mixed;".$UN_SALTO; 
	$cabecera .= " boundary=".$separador."".$DOS_SALTOS; 

	$texto ="--".$separador."".$UN_SALTO; 
	$texto .="Content-Type: text/html; charset=\"ISO-8859-1\"".$UN_SALTO; 
	$texto .="Content-Transfer-Encoding: 7bit".$DOS_SALTOS; 
	$texto .= $mensaje;

	$sqla = "select * from sgm_cartas_adjuntos where id_carta=".$mail;
	$resulta = mysql_query(convert_sql($sqla));
	while ($rowa = mysql_fetch_array($resulta)){
		$adj1 .= $UN_SALTO."--".$separador."".$UN_SALTO;
		$adj1 .="Content-Type: ".$rowa["tipo"]."; name=\"".$rowa["nombre_archivo"]."\"".$UN_SALTO;
		$adj1 .="Content-Disposition: inline; filename=\"".$rowa["nombre_archivo"]."\"".$UN_SALTO;
		$adj1 .="Content-Transfer-Encoding: base64".$DOS_SALTOS;
		$adj1 .= chunk_split(base64_encode($rowa["contenido"]));
	}

	$mensaje=$texto.$adj1;

	if( mail($destinatario, $titulo, $mensaje, $cabecera)){
		echo "<br>Se ha enviado un mail a : <strong>".$mail_dest."</strong>";
	}

	$sql1 = "insert into sgm_cartas_enviadas (id_user,id_client,id_carta,fecha) ";
	$sql1 = $sql1."values (";
	$sql1 = $sql1."".$userid;
	$sql1 = $sql1.",".$id;
	$sql1 = $sql1.",".$mail;
	$date = getdate(); 
	$fecha = $date["year"]."-".$date["mon"]."-".$date["mday"];
	$sql1 = $sql1.",'".$fecha."'";
	$sql1 = $sql1.")";
	mysql_query(convert_sql($sql1));
}

?>


