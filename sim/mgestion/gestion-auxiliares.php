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
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
				echo "</form>";
			echo "</tr>";
			$sql = "select * from sgm_idiomas where visible=1";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			while ($row = mysqli_fetch_array($result)) {
					$color = "white";
					if ($row["predefinido"] == 1) { $color = "#FF4500"; }
						echo "<tr style=\"background-color : ".$color."\">";
						echo "<td>";
					if ($row["predefinido"] == 1) {
						echo "<form action=\"index.php?op=1023&sop=130&ssop=5&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
						echo "</form>";
						echo "<td></td>";
					}
					if ($row["predefinido"] == 0) {
						echo "<form action=\"index.php?op=1023&sop=130&ssop=4&id=".$row["id"]."\" method=\"post\">";
						echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
						echo "</form>";
						echo "<td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=131&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
					}
					echo "<form action=\"index.php?op=1023&sop=130&ssop=2&id=".$row["id"]."\" method=\"post\">";
					echo "<td><input type=\"Text\" name=\"idioma\" style=\"width:50px\" value=\"".$row["idioma"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"descripcion\" style=\"width:150px\" value=\"".$row["descripcion"]."\"></td>";
					echo "<td><input type=\"Text\" name=\"imagen\" style=\"width:100px\" value=\"".$row["imagen"]."\"></td>";
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
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
			while ($data = fgetcsv($handle,1000,",","'")){
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
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sim_paises where visible=1 order by pais";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
								$color = "white";
								if ($row["predefinido"] == 1) { $color = "#FF4500"; }
									echo "<tr style=\"background-color : ".$color."\">";
									echo "<td>";
								if ($row["predefinido"] == 1) {
									echo "<form action=\"index.php?op=1023&sop=140&ssop=5&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
									echo "</form>";
									echo "</td><td></td>";
								}
								if ($row["predefinido"] == 0) {
									echo "<form action=\"index.php?op=1023&sop=140&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
									echo "</form>";
									echo "</td><td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=141&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								}
								echo "<form action=\"index.php?op=1023&sop=140&ssop=2&id=".$row["id"]."\" method=\"post\">";
								echo "<td><input type=\"Text\" name=\"pais\" style=\"width:200px\" value=\"".$row["pais"]."\"></td>";
								echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\" value=\"".$row["siglas"]."\"></td>";
								echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
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
							echo "<th><input name=\"csv\" type=\"file\" id=\"csv\"></th>";
							echo "<th><input type=\"submit\" value=\"".$Subir."\"></th>";
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
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
							echo "</form>";
						echo "</tr>";
						echo "<tr><td>&nbsp;</td></tr>";
						$sql = "select * from sim_comunidades_autonomas where visible=1 order by comunidad_autonoma";
						$result = mysqli_query($dbhandle,convertSQL($sql));
						while ($row = mysqli_fetch_array($result)) {
								$color = "white";
								if ($row["predefinido"] == 1) { $color = "#FF4500"; }
									echo "<tr style=\"background-color : ".$color."\">";
									echo "<td>";
								if ($row["predefinido"] == 1) {
									echo "<form action=\"index.php?op=1023&sop=150&ssop=5&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Despre."\" style=\"width:100px\">";
									echo "</form>";
									echo "</td><td></td>";
								}
								if ($row["predefinido"] == 0) {
									echo "<form action=\"index.php?op=1023&sop=150&ssop=4&id=".$row["id"]."\" method=\"post\">";
									echo "<input type=\"Submit\" value=\"".$Predet."\" style=\"width:100px\">";
									echo "</form>";
									echo "</td><td style=\"text-align:center;\"><a href=\"index.php?op=1023&sop=151&id=".$row["id"]."\"><img src=\"mgestion/pics/icons-mini/page_white_delete.png\" style=\"border:0px\"></a></td>";
								}
								echo "<form action=\"index.php?op=1023&sop=150&ssop=2&id=".$row["id"]."\" method=\"post\">";
								echo "<td><input type=\"Text\" name=\"comunidad_autonoma\" style=\"width:200px\" value=\"".$row["comunidad_autonoma"]."\"></td>";
								echo "<td><input type=\"Text\" name=\"siglas\" style=\"width:50px\" value=\"".$row["siglas"]."\"></td>";
								echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
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
							echo "<th><input name=\"csv\" type=\"file\" id=\"csv\"></th>";
							echo "<th><input type=\"submit\" value=\"".$Subir."\"></th>";
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
							echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
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
								echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
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
							echo "<th><input name=\"csv\" type=\"file\" id=\"csv\"></th>";
							echo "<th><input type=\"submit\" value=\"".$Subir."\"></th>";
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
				echo "<td><input type=\"Submit\" value=\"".$Anadir."\" style=\"width:80px\"></td>";
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
					echo "<td><input type=\"Submit\" value=\"".$Modificar."\" style=\"width:80px\"></td>";
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

	echo "</td></tr></table><br>";
}

?>
