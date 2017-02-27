<?php

$autorizado = autorizado($userid,$option);
$admin = admin($userid,$option);
if ($autorizado == false) {	echo "<h1 style=\"text-align:center\">".$UsuarioNoAutorizado."</h1>"; }
if (($option == 1023) AND ($autorizado == true)) {
	echo "<table class=\"principal\"><tr>";
		echo "<td style=\"width:8%;vertical-align : middle;text-align:left;\">";
			echo "<h4>".$Auxiliares."</h4>";
		echo "</td><td style=\"width:92%;vertical-align:top;text-align:left;\">";
			echo "<table>";
				echo "<tr>";
				if (($soption >= 130) and($soption < 140)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=130\" class=".$class.">".$Idioma."</a></td>";
				if (($soption >= 140) and($soption < 150)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=140\" class=".$class.">".$Pais."</a></td>";
				if (($soption >= 150) and($soption < 160)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=150\" class=".$class.">".$Comunidades_autonomas."</a></td>";
				if (($soption >= 160) and($soption < 170)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=160\" class=".$class.">".$Provincia."</a></td>";
				if (($soption >= 170) and($soption < 180)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=170\" class=".$class.">".$Region."</a></td>";
				if (($soption >= 180) and($soption < 190)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=180\" class=".$class.">".$Medio." ".$Comunicacion."</a></td>";
				if (($soption >= 190) and($soption < 200)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=190\" class=".$class.">".$Formato." ".$Documentos."</a></td>";
				if (($soption >= 200) and($soption < 210)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=200\" class=".$class.">".$Modulos."</a></td>";
				if (($soption >= 210) and($soption < 220)) {$class = "menu_select";} else {$class = "menu";}
				echo "<td class=".$class."><a href=\"index.php?op=1023&sop=210\" class=".$class.">".$Color."</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table><br>";
		echo "<table  class=\"principal\"><tr>";
		echo "<td style=\"width:100%;vertical-align : top;text-align:left;\">";


	if ($soption == 0) {
	}

	if ($soption == 130){
		if ($ssoption == 1) {
			$camposInsert = "idioma,descripcion,imagen";
			$datosInsert = array($_POST["idioma"],$_POST["descripcion"],$_POST["imagen"]);
			insertFunction ("sgm_idiomas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('idioma','descripcion','imagen');
			$datosUpdate=array($_POST["idioma"],$_POST["descripcion"],$_POST["imagen"]);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sgm_idiomas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$camposUpdate=array('predefinido');
			$datosUpdate=array(1);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$camposUpdate=array('predefinido');
			$datosUpdate=array(0);
			updateFunction("sgm_idiomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Idioma."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Idioma."*</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th>".$Imagen."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=130&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"idioma\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:150px\"></td>";
				echo "<td><input type=\"Text\" name=\"imagen\" style=\"width:100px\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			$sql = "select * from sgm_idiomas where visible=1";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
					$color = "white";
					if ($row["predefinido"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td class=\"submit\">";
					if ($row["predefinido"] == 1) {
						echo "<form action=\"index.php?op=1023&sop=130&ssop=5&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
						echo "</form>";
						echo "<td></td>";
					}
					if ($row["predefinido"] == 0) {
						echo "<form action=\"index.php?op=1023&sop=130&ssop=4&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predeterminar."\">";
						echo "</form>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=131&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					}
					echo "<form action=\"index.php?op=1023&sop=130&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"idioma\" style=\"width:50px\" value=\"".$row["idioma"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:150px\" value=\"".$row["descripcion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"imagen\" style=\"width:100px\" value=\"".$row["imagen"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
			echo "<tr><td>&nbsp;</td></tr>";
			echo "<tr><td colspan=\"6\">* ".$ayuda_iso_idioma." <a href=\"https://es.wikipedia.org/wiki/ISO_639-1\" target=\"_blank\">https://es.wikipedia.org/wiki/ISO_639-1</a></td></tr>";
		echo "</table>";
	}

	if ($soption == 131) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=130&ssop=3&id=".$_GET["id"],"op=1023&sop=130"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 140){
		if ($ssoption == 1) {
			$camposInsert = "pais,siglas";
			$datosInsert = array($_POST["pais"],$_POST["siglas"]);
			insertFunction ("sim_paises",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('pais','siglas');
			$datosUpdate=array($_POST["pais"],$_POST["siglas"]);
			updateFunction("sim_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sim_paises set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$camposUpdate=array('predefinido');
			$datosUpdate=array(1);
			updateFunction("sim_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$camposUpdate=array('predefinido');
			$datosUpdate=array(0);
			updateFunction("sim_paises",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($_FILES[csv][size] > 0) {
			//get the csv file
			$file = $_FILES[csv][tmp_name];
			$handle = fopen($file,"r");
			//loop through the csv file and insert into database
			while ($data = fgetcsv($handle,1000,";","'")){
				if ($data[0]) {
					$camposInsert = "pais,siglas";
					$datosInsert = array(utf8_decode($data[0]),$data[1]);
					insertFunction ("sim_paises",$camposInsert,$datosInsert);
				}
			}
		}

		echo "<h4>".$Paises."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th></th>";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Pais."</th>";
							echo "<th>".$Siglas."*</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=140&ssop=1\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><input type=\"Text\" name=\"pais\" style=\"width:200px\"></td>";
							echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\"></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sim_paises where visible=1 order by pais";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
								$color = "white";
								if ($row["predefinido"] == 1) { $color = "#FF4500"; }
									echo "<tr style=\"background-color : ".$color."\">";
									echo "<td class=\"submit\">";
								if ($row["predefinido"] == 1) {
									echo "<form action=\"index.php?op=1023&sop=140&ssop=5&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
									echo "</form>";
									echo "</td><td></td>";
								}
								if ($row["predefinido"] == 0) {
									echo "<form action=\"index.php?op=1023&sop=140&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Predeterminar."\">";
									echo "</form>";
									echo "</td><td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=141&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								}
								echo "<form action=\"index.php?op=1023&sop=140&ssop=2&id=".$row["id"]."\" method=\"post\">";
								echo "<td><input type=\"Text\" name=\"pais\" style=\"width:200px\" value=\"".$row["pais"]."\"></td>";
								echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\" value=\"".$row["siglas"]."\"></td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
								echo "</form>";
							echo "</tr>";
						}
						echo "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td colspan=\"6\">* ".$ayuda_iso_pais." <a href=\"https://es.wikipedia.org/wiki/ISO_3166-1\" target=\"_blank\">https://es.wikipedia.org/wiki/ISO_3166-1</a></td></tr>";
					echo "</table>";
				echo "</td><td>&nbsp;";
				echo "</td><td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th>pais,codigo iso 3166-1 alpha-3</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=140\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" id=\"form1\">";
							echo "<td><input name=\"csv\" type=\"file\" id=\"csv\"></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Subir."\"></td>";
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 141) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=140&ssop=3&id=".$_GET["id"],"op=1023&sop=140"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 150){
		if ($ssoption == 1) {
			$camposInsert = "comunidad_autonoma,siglas";
			$datosInsert = array($_POST["comunidad_autonoma"],$_POST["siglas"]);
			insertFunction ("sim_comunidades_autonomas",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('comunidad_autonoma','siglas');
			$datosUpdate=array($_POST["comunidad_autonoma"],$_POST["siglas"]);
			updateFunction("sim_comunidades_autonomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_comunidades_autonomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 4) AND ($admin == true)) {
			$sql = "update sim_comunidades_autonomas set ";
			$sql = $sql."predefinido = 0";
			$sql = $sql." WHERE id<>".$_GET["id"]."";
			mysqli_query($dbhandle,convertSQL($sql));
			$camposUpdate=array('predefinido');
			$datosUpdate=array(1);
			updateFunction("sim_comunidades_autonomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if (($ssoption == 5) AND ($admin == true)) {
			$camposUpdate=array('predefinido');
			$datosUpdate=array(0);
			updateFunction("sim_comunidades_autonomas",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($_FILES[csv][size] > 0) {
			//get the csv file
			$file = $_FILES[csv][tmp_name];
			$handle = fopen($file,"r");
			//loop through the csv file and insert into database
			while ($data = fgetcsv($handle,1000,",","'")){
				if ($data[0]) {
					$camposInsert = "comunidad_autonoma,siglas";
					$datosInsert = array(utf8_decode($data[0]),$data[1]);
					insertFunction ("sim_comunidades_autonomas",$camposInsert,$datosInsert);
				}
			}
		}

		echo "<h4>".$Comunidades_autonomas."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th></th>";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Comunidad_autonoma."</th>";
							echo "<th>".$Siglas."*</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=150&ssop=1\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><input type=\"Text\" name=\"comunidad_autonoma\" style=\"width:200px\"></td>";
							echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\"></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sim_comunidades_autonomas where visible=1 order by comunidad_autonoma";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
								$color = "white";
								if ($row["predefinido"] == 1) { $color = "#FF4500"; }
									echo "<tr style=\"background-color : ".$color."\">";
									echo "<td class=\"submit\">";
								if ($row["predefinido"] == 1) {
									echo "<form action=\"index.php?op=1023&sop=150&ssop=5&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Despredeterminar."\">";
									echo "</form>";
									echo "</td><td></td>";
								}
								if ($row["predefinido"] == 0) {
									echo "<form action=\"index.php?op=1023&sop=150&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Predeterminar."\">";
									echo "</form>";
									echo "</td><td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=151&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								}
								echo "<form action=\"index.php?op=1023&sop=150&ssop=2&id=".$row["id"]."\" method=\"post\">";
								echo "<td><input type=\"Text\" name=\"comunidad_autonoma\" style=\"width:200px\" value=\"".$row["comunidad_autonoma"]."\"></td>";
								echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\" value=\"".$row["siglas"]."\"></td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td><td>&nbsp;";
				echo "</td><td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th>".$Comunidad_autonoma.",".$Siglas."</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=150\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" id=\"form1\">";
							echo "<td><input name=\"csv\" type=\"file\" id=\"csv\"></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Subir."\"></td>";
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 151) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=150&ssop=3&id=".$_GET["id"],"op=1023&sop=150"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 160){
		if ($ssoption == 1) {
			$camposInsert = "provincia";
			$datosInsert = array($_POST["provincia"]);
			insertFunction ("sim_provincias",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('provincia');
			$datosUpdate=array($_POST["provincia"]);
			updateFunction("sim_provincias",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_provincias",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		if ($_FILES[csv][size] > 0) {
			//get the csv file
			$file = $_FILES[csv][tmp_name];
			$handle = fopen($file,"r");
			//loop through the csv file and insert into database
			while ($data = fgetcsv($handle,1000,",","'")){
				if ($data[0]) {
					$camposInsert = "provincia";
					$datosInsert = array(utf8_decode($data[0]));
					insertFunction ("sim_provincias",$camposInsert,$datosInsert);
				}
			}
		}

		echo "<h4>".$Provincia."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr>";
				echo "<td>";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr style=\"background-color: Silver;\">";
							echo "<th></th>";
							echo "<th>".$Eliminar."</th>";
							echo "<th>".$Provincia."</th>";
							echo "<th></th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=160&ssop=1\" method=\"post\">";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td><input type=\"Text\" name=\"provincia\" style=\"width:200px\"></td>";
							echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sim_provincias where visible=1 order by provincia";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
							echo "<tr>";
								echo "<td></td>";
								echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=161&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								echo "<form action=\"index.php?op=1023&sop=160&ssop=2&id=".$row["id"]."\" method=\"post\">";
								echo "<td><input type=\"Text\" name=\"provincia\" style=\"width:200px\" value=\"".$row["provincia"]."\"></td>";
								echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
								echo "</form>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td><td>&nbsp;";
				echo "</td><td style=\"vertical-align:top;\">";
					echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
						echo "<tr>";
							echo "<th>".$Provincia."</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<form action=\"index.php?op=1023&sop=160\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" id=\"form1\">";
							echo "<td><input name=\"csv\" type=\"file\" id=\"csv\"></td>";
							echo "<td class=\"submit\"><input type=\"submit\" value=\"".$Subir."\"></td>";
							echo "</form>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

	if ($soption == 161) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=160&ssop=3&id=".$_GET["id"],"op=1023&sop=160"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 170){
		if ($ssoption == 1) {
			$camposInsert = "region";
			$datosInsert = array($_POST["region"]);
			insertFunction ("sim_regiones",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('region');
			$datosUpdate=array($_POST["region"]);
			updateFunction("sim_regiones",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_regiones",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Region."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Region."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=170&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"region\" style=\"width:200px\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_regiones where visible=1 order by region";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td></td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=171&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=170&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"region\" style=\"width:200px\" value=\"".$row["region"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 171) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=170&ssop=3&id=".$_GET["id"],"op=1023&sop=170"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 180){
		if ($ssoption == 1) {
			$camposInsert = "medio_comunicacion";
			$datosInsert = array($_POST["medio_comunicacion"]);
			insertFunction ("sim_medio_comunicacion",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('medio_comunicacion');
			$datosUpdate=array($_POST["medio_comunicacion"]);
			updateFunction("sim_medio_comunicacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_medio_comunicacion",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Medio." ".$Comunicacion."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Medio." ".$Comunicacion."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=180&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"medio_comunicacion\" style=\"width:200px\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_medio_comunicacion where visible=1 order by medio_comunicacion";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td></td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=181&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=180&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"medio_comunicacion\" style=\"width:200px\" value=\"".$row["medio_comunicacion"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 181) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=180&ssop=3&id=".$_GET["id"],"op=1023&sop=180"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 190){
		if ($ssoption == 1) {
			$camposInsert = "formato_documento";
			$datosInsert = array($_POST["formato_documento"]);
			insertFunction ("sim_formato_documento",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('formato_documento');
			$datosUpdate=array($_POST["formato_documento"]);
			updateFunction("sim_formato_documento",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposUpdate=array('visible');
			$datosUpdate=array(0);
			updateFunction("sim_formato_documento",$_GET["id"],$camposUpdate,$datosUpdate);
		}

		echo "<h4>".$Formato." ".$Documentos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\">";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th></th>";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Formato." ".$Documentos."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=190&ssop=1\" method=\"post\">";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><input type=\"Text\" name=\"formato_documento\" style=\"width:200px\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sim_formato_documento where visible=1 order by formato_documento";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<td></td>";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=191&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<form action=\"index.php?op=1023&sop=190&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"formato_documento\" style=\"width:200px\" value=\"".$row["formato_documento"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 191) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=190&ssop=3&id=".$_GET["id"],"op=1023&sop=190"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 200){
		if ($ssoption == 1) {
			$camposInsert = "id_modulo,nombre_es,nombre_cat,descripcion,id_grupo,visible";
			$datosInsert = array($_POST["id_modulo"],$_POST["nombre_es"],$_POST["nombre_cat"],$_POST["descripcion"],$_POST["id_grupo"],$_POST["visible"]);
			insertFunction ("sgm_users_permisos_modulos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 2) {
			$camposUpdate=array('id_modulo','nombre_es','nombre_cat','descripcion','id_grupo','visible');
			$datosUpdate=array($_POST["id_modulo"],$_POST["nombre_es"],$_POST["nombre_cat"],$_POST["descripcion"],$_POST["id_grupo"],$_POST["visible"]);
			updateFunction("sgm_users_permisos_modulos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 3) {
			$camposInsert = "nombre_es,nombre_cat";
			$datosInsert = array($_POST["nombre_es"],$_POST["nombre_cat"]);
			insertFunction ("sgm_users_permisos_modulos_grupos",$camposInsert,$datosInsert);
		}
		if ($ssoption == 4) {
			$camposUpdate=array('nombre_es','nombre_cat');
			$datosUpdate=array($_POST["nombre_es"],$_POST["nombre_cat"]);
			updateFunction("sgm_users_permisos_modulos_grupos",$_GET["id"],$camposUpdate,$datosUpdate);
		}
		if ($ssoption == 5) {
			$sqlg = "select count(*) as total from sgm_users_permisos_modulos where visible=1 and id_grupo=".$_GET["id"];
			$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
			$rowg = mysqli_fetch_array($resultg);
			if ($rowg["total"] > 0){
				mensageError($errorEliminarGrupo);
			} else {
				$camposUpdate=array('visible');
				$datosUpdate=array(0);
				updateFunction("sgm_users_permisos_modulos_grupos",$_GET["id"],$camposUpdate,$datosUpdate);
			}
		}

		echo "<h4>".$Modulos."</h4>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"display:inline;margin-left:30px;margin-right:30px;\">";
			echo "<tr>";
				echo "<th></th>";
				echo "<th style=\"background-color:Silver;text-align:center;\" colspan=\"2\">".$Grupos." ".$Modulos."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>".$Eliminar."</th>";
				echo "<th>".$Castellano."</th>";
				echo "<th>".$Catalan."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<th></th>";
				echo "<form action=\"index.php?op=1023&sop=200&ssop=3\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"nombre_es\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre_cat\" style=\"width:200px\"></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select id,nombre_es,nombre_cat from sgm_users_permisos_modulos_grupos where visible=1 order by nombre_".$idioma;
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1023&sop=200&ssop=4&id=".$row["id"]."\" method=\"post\">";
					echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=201&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					echo "<td><input type=\"Text\" name=\"nombre_es\" style=\"width:200px\" value=\"".$row["nombre_es"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"nombre_cat\" style=\"width:200px\" value=\"".$row["nombre_cat"]."\"></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
		echo "<table cellpadding=\"1\" cellspacing=\"0\" class=\"lista\" style=\"display:inline;margin-right:30px;\">";
			echo "<tr>";
				echo "<th></th>";
				echo "<th style=\"background-color:Silver;text-align:center;\" colspan=\"2\">".$Modulo."</th>";
				echo "<th></th>";
				echo "<th></th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr style=\"background-color: Silver;\">";
				echo "<th>Id</th>";
				echo "<th>".$Castellano."</th>";
				echo "<th>".$Catalan."</th>";
				echo "<th>".$Descripcion."</th>";
				echo "<th>".$Grupo."</th>";
				echo "<th>".$Activo."</th>";
				echo "<th></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<form action=\"index.php?op=1023&sop=200&ssop=1\" method=\"post\">";
				echo "<td><input type=\"Text\" name=\"id_modulo\" style=\"width:50px\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre_es\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"nombre_cat\" style=\"width:200px\"></td>";
				echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:400px\"></td>";
				echo "<td><select style=\"width:200px\" name=\"id_grupo\">";
					echo "<option value=\"0\">-</option>";
					$sqlg = "select id,nombre_es,nombre_cat from sgm_users_permisos_modulos_grupos where visible=1 order by nombre_".$idioma;
					$resultg = mysqli_query($dbhandle,convertSQL($sqlg));
					while ($rowg = mysqli_fetch_array($resultg)) {
						echo "<option value=\"".$rowg["id"]."\">".$rowg["nombre_".$idioma]."</option>";
					}
				echo "</select></td>";
				echo "<td><select style=\"width:70px\" name=\"visible\">";
					echo "<option value=\"0\">".$No."</option>";
					echo "<option value=\"1\">".$Si."</option>";
				echo "</select></td>";
				echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Anadir."\"></td>";
				echo "</form>";
			echo "</tr>";
			echo "<tr><td>&nbsp;</td></tr>";
			$sql = "select * from sgm_users_permisos_modulos order by id_modulo";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo "<form action=\"index.php?op=1023&sop=200&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"id_modulo\" style=\"width:50px\" value=\"".$row["id_modulo"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"nombre_es\" style=\"width:200px\" value=\"".$row["nombre_es"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"nombre_cat\" style=\"width:200px\" value=\"".$row["nombre_cat"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:400px\" value=\"".$row["descripcion"]."\"></td>";
					if ($row["id_modulo"] >= 2000) { $disable = "disabled"; }
					echo "<td><select style=\"width:200px\" name=\"id_grupo\" ".$disable.">";
						echo "<option value=\"0\">-</option>";
						$sqls = "select id,nombre_".$idioma." from sgm_users_permisos_modulos_grupos where visible=1 order by nombre_".$idioma;
						$results = mysqli_query($dbhandle,convertSQL($sqls));
						while ($rows = mysqli_fetch_array($results)) {
							if ($rows["id"] == $row["id_grupo"]){
								echo "<option value=\"".$rows["id"]."\" selected>".$rows["nombre_".$idioma]."</option>";
							} else {
								echo "<option value=\"".$rows["id"]."\">".$rows["nombre_".$idioma]."</option>";
							}
						}
					echo "</select></td>";
					echo "<td><select style=\"width:70px\" name=\"visible\">";
						if ($row["visible"] == 1){
							echo "<option value=\"1\" selected>".$Si."</option>";
							echo "<option value=\"0\">".$No."</option>";
						} else {
							echo "<option value=\"1\">".$Si."</option>";
							echo "<option value=\"0\" selected>".$No."</option>";
						}
					echo "</select></td>";
					echo "<td class=\"submit\"><input type=\"Submit\" value=\"".$Modificar."\"></td>";
					echo "</form>";
				echo "</tr>";
			}
		echo "</table>";
	}

	if ($soption == 201) {
		echo "<center>";
		echo "<br><br>".$pregunta_eliminar;
		echo boton(array("op=1023&sop=200&ssop=5&id=".$_GET["id"],"op=1023&sop=200"),array($Si,$No));
		echo "</center>";
	}

	if ($soption == 210) {
		$colors = array();
		$colors[] = array("AliceBlue","#F0F8FF");
		$colors[] = array("AntiqueWhite","#FAEBD7");
		$colors[] = array("Aqua","#00FFFF");
		$colors[] = array("Aquamarine","#7FFFD4");
		$colors[] = array("Azure","#F0FFFF");
		$colors[] = array("Beige","#F5F5DC");
		$colors[] = array("Bisque","#FFE4C4");
		$colors[] = array("Black","#000000");
		$colors[] = array("BlanchedAlmond","#FFEBCD");
		$colors[] = array("Blue","#0000FF");
		$colors[] = array("BlueViolet","#8A2BE2");
		$colors[] = array("Brown","#A52A2A");
		$colors[] = array("BurlyWood","#DEB887");
		$colors[] = array("CadetBlue","#5F9EA0");
		$colors[] = array("Chartreuse","#7FFF00");
		$colors[] = array("Chocolate","#D2691E");
		$colors[] = array("Coral","#FF7F50");
		$colors[] = array("CornflowerBlue","#6495ED");
		$colors[] = array("Cornsilk","#FFF8DC");
		$colors[] = array("Crimson","#DC143C");
		$colors[] = array("Cyan","#00FFFF");
		$colors[] = array("DarkBlue","#00008B");
		$colors[] = array("DarkCyan","#008B8B");
		$colors[] = array("DarkGoldenRod","#B8860B");
		$colors[] = array("DarkGray","#A9A9A9");
		$colors[] = array("DarkGreen","#006400");
		$colors[] = array("DarkKhaki","#BDB76B");
		$colors[] = array("DarkMagenta","#8B008B");
		$colors[] = array("DarkOliveGreen","#556B2F");
		$colors[] = array("Darkorange","#FF8C00");
		$colors[] = array("DarkOrchid","#9932CC");
		$colors[] = array("DarkRed","#8B0000");
		$colors[] = array("DarkSalmon","#E9967A");
		$colors[] = array("DarkSeaGreen","#8FBC8F");
		$colors[] = array("DarkSlateBlue","#483D8B");
		$colors[] = array("DarkSlateGray","#2F4F4F");
		$colors[] = array("DarkTurquoise","#00CED1");
		$colors[] = array("DarkViolet","#9400D3");
		$colors[] = array("DeepPink","#FF1493");
		$colors[] = array("DeepSkyBlue","#00BFFF");
		$colors[] = array("DimGray","#696969");
		$colors[] = array("DodgerBlue","#1E90FF");
		$colors[] = array("FireBrick","#B22222");
		$colors[] = array("FloralWhite","#FFFAF0");
		$colors[] = array("ForestGreen","#228B22");
		$colors[] = array("Fuchsia","#FF00FF");
		$colors[] = array("Gainsboro","#DCDCDC");
		$colors[] = array("GhostWhite","#F8F8FF");
		$colors[] = array("Gold","#FFD700");
		$colors[] = array("GoldenRod","#DAA520");
		$colors[] = array("Gray","#808080");
		$colors[] = array("Green","#008000");
		$colors[] = array("GreenYellow","#ADFF2F");
		$colors[] = array("HoneyDew","#F0FFF0");
		$colors[] = array("HotPink","#FF69B4");
		$colors[] = array("IndianRed","#CD5C5C");
		$colors[] = array("Indigo","#4B0082");
		$colors[] = array("Ivory","#FFFFF0");
		$colors[] = array("Khaki","#F0E68C");
		$colors[] = array("Lavender","#E6E6FA");
		$colors[] = array("LavenderBlush","#FFF0F5");
		$colors[] = array("LawnGreen","#7CFC00");
		$colors[] = array("LemonChiffon","#FFFACD");
		$colors[] = array("LightBlue","#ADD8E6");
		$colors[] = array("LightCoral","#F08080");
		$colors[] = array("LightCyan","#E0FFFF");
		$colors[] = array("LightGoldenRodYellow","#FAFAD2");
		$colors[] = array("LightGrey","#D3D3D3");
		$colors[] = array("LightGreen","#90EE90");
		$colors[] = array("LightPink","#FFB6C1");
		$colors[] = array("LightSalmon","#FFA07A");
		$colors[] = array("LightSeaGreen","#20B2AA");
		$colors[] = array("LightSkyBlue","#87CEFA");
		$colors[] = array("LightSlateGray","#778899");
		$colors[] = array("LightSteelBlue","#B0C4DE");
		$colors[] = array("LightYellow","#FFFFE0");
		$colors[] = array("Lime","#00FF00");
		$colors[] = array("LimeGreen","#32CD32");
		$colors[] = array("Linen","#FAF0E6");
		$colors[] = array("Magenta","#FF00FF");
		$colors[] = array("Maroon","#800000");
		$colors[] = array("MediumAquaMarine","#66CDAA");
		$colors[] = array("MediumBlue","#0000CD");
		$colors[] = array("MediumOrchid","#BA55D3");
		$colors[] = array("MediumPurple","#9370D8");
		$colors[] = array("MediumSeaGreen","#3CB371");
		$colors[] = array("MediumSlateBlue","#7B68EE");
		$colors[] = array("MediumSpringGreen","#00FA9A");
		$colors[] = array("MediumTurquoise","#48D1CC");
		$colors[] = array("MediumVioletRed","#C71585");
		$colors[] = array("MidnightBlue","#191970");
		$colors[] = array("MintCream","#F5FFFA");
		$colors[] = array("MistyRose","#FFE4E1");
		$colors[] = array("Moccasin","#FFE4B5");
		$colors[] = array("NavajoWhite","#FFDEAD");
		$colors[] = array("Navy","#000080");
		$colors[] = array("OldLace","#FDF5E6");
		$colors[] = array("Olive","#808000");
		$colors[] = array("OliveDrab","#6B8E23");
		$colors[] = array("Orange","#FFA500");
		$colors[] = array("OrangeRed","#FF4500");
		$colors[] = array("Orchid","#DA70D6");
		$colors[] = array("PaleGoldenRod","#EEE8AA");
		$colors[] = array("PaleGreen","#98FB98");
		$colors[] = array("PaleTurquoise","#AFEEEE");
		$colors[] = array("PaleVioletRed","#D87093");
		$colors[] = array("PapayaWhip","#FFEFD5");
		$colors[] = array("PeachPuff","#FFDAB9");
		$colors[] = array("Peru","#CD853F");
		$colors[] = array("Pink","#FFC0CB");
		$colors[] = array("Plum","#DDA0DD");
		$colors[] = array("PowderBlue","#B0E0E6");
		$colors[] = array("Purple","#800080");
		$colors[] = array("Red","#FF0000");
		$colors[] = array("RosyBrown","#BC8F8F");
		$colors[] = array("RoyalBlue","#4169E1");
		$colors[] = array("SaddleBrown","#8B4513");
		$colors[] = array("Salmon","#FA8072");
		$colors[] = array("SandyBrown","#F4A460");
		$colors[] = array("SeaGreen","#2E8B57");
		$colors[] = array("SeaShell","#FFF5EE");
		$colors[] = array("Sienna","#A0522D");
		$colors[] = array("Silver","#C0C0C0");
		$colors[] = array("SkyBlue","#87CEEB");
		$colors[] = array("SlateBlue","#6A5ACD");
		$colors[] = array("SlateGray","#708090");
		$colors[] = array("Snow","#FFFAFA");
		$colors[] = array("SpringGreen","#00FF7F");
		$colors[] = array("SteelBlue","#4682B4");
		$colors[] = array("Tan","#D2B48C");
		$colors[] = array("Teal","#008080");
		$colors[] = array("Thistle","#D8BFD8");
		$colors[] = array("Tomato","#FF6347");
		$colors[] = array("Turquoise","#40E0D0");
		$colors[] = array("Violet","#EE82EE");
		$colors[] = array("Wheat","#F5DEB3");
		$colors[] = array("White","#FFFFFF");
		$colors[] = array("WhiteSmoke","#F5F5F5");
		$colors[] = array("Yellow","#FFFF00");
		$colors[] = array("YellowGreen","#9ACD32");
		$indice_colum = 0;
#		var_dump($colors);

		echo "<table cellpadding=\"1\" cellspacing=\"1\" class=\"lista\">";
			echo "<tr>";
			for ($i=1;$i<=10;$i++){
				echo " <td style=\"border-bottom: black 2px solid;width:15px;\"><strong></strong></td>";
				echo " <td style=\"border-bottom: black 2px solid\"><strong>".$Nombre."</strong></td>";
				echo " <td style=\"border-bottom: black 2px solid\"><strong>RGB</strong></td>";
			}
			echo "</tr><tr>";
		    for ( $count = 0 ; $count < count($colors) ; $count++ ){
				if ($indice_colum == 10){
					echo "</tr><tr>";
					$indice_colum = 0;
				}
				echo "<td style=\"background: ".$colors[$count][1]."\";>&nbsp;</td><td>".$colors[$count][0]."</td><td>".$colors[$count][1]."</td>";
				$indice_colum++;
			}
		echo "</table>";
	}
	
#	if ($soption == 10000){
#		$sql = "select * from sgm_users_permisos_modulos order by id_modulo";
#		$result = mysqli_query($dbhandle,convertSQL($sql));
#		while ($row = mysqli_fetch_array($result)) {
#			$camposUpdate=array('nombre_es');
#			$datosUpdate=array($row["nombre"]);
#			updateFunction("sgm_users_permisos_modulos",$row["id"],$camposUpdate,$datosUpdate);
#		}
#		$sql = "select * from sgm_users_permisos_modulos_grupos order by id";
#		$result = mysqli_query($dbhandle,convertSQL($sql));
#		while ($row = mysqli_fetch_array($result)) {
#			$camposUpdate=array('nombre_es');
#			$datosUpdate=array($row["nombre"]);
#			updateFunction("sgm_users_permisos_modulos_grupos",$row["id"],$camposUpdate,$datosUpdate);
#		}
#	}

	echo "</td></tr></table><br>";
}



?>
