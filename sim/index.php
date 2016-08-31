<?php
#32599E antiguo color

error_reporting(E_ALL);
date_default_timezone_set('Europe/Madrid');

### BUSCA SI ES UNA IP LOCAL
#$accesolocal = true;
#$ip = $_SERVER['REMOTE_ADDR'];
#$subxarxa = "192.168.1.";
#$x = 0;
#for ($x = 0 ; $x < strlen($subxarxa) ; $x++) {
#	if ($ip[$x] != $subxarxa[$x]) { $accesolocal = false ; }
#}
#if ($accesolocal == true) {	include ("config.php"); }
#if ($accesolocal == false) { include ("config2.php"); }


include ("config.php");
### CONEXION
#$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass ) or die("Couldn't connect to SQL Server on $dbhost");
#$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database $myDB");

$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

foreach (glob("auxiliar/*.php") as $filename)
{
    include ($filename);
}


if ($_GET['op'] != "") { $option = $_GET['op']; } else { $option = 0; }
if ($_GET['sop'] != "") { $soption = $_GET['sop']; } else { $soption = 0; }
if ($_GET['ssop'] != "") { $ssoption = $_GET['ssop']; } else { $ssoption = 0; }

$user = false;
$userid = 0;
if ($soption == 666) {
	setcookie("musername", "", time()-1, $url_raiz);
	setcookie("mpassword", "", time()-1, $url_raiz);
	unset($_COOKIE["musername"]); 
	unset($_COOKIE["mpassword"]); 
	header("Location: ".$urlmgestion);
}

if ($option == 667) {
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, $url_raiz, $domain);
	header("Location: ".$urlmgestion);
}


if ($_GET["i"] != "") {
	$idioma = $_GET["i"];
	setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, $url_raiz, $domain);
} else {
	if ($_COOKIE["idioma"] == "") {
		$idioma = "es";
		setcookie("idioma", "".$_GET["i"]."", time()+31536000*$cookiestime, $url_raiz, $domain);
	} else { $idioma = $_COOKIE["idioma"]; }
}

if ($idioma == "es"){ include ("sgm_es.php");}
if ($idioma == "cat"){ include ("sgm_cat.php");}

if ($_COOKIE["musername"] == "") {
	if ($_POST["user"] != "") {
		$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_POST["user"] ."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["total"] == 1) {
			$sql = "select * from sgm_users WHERE usuario='".$_POST["user"]."'";
			$result = mysqli_query($dbhandle,convertSQL($sql));
			$row = mysqli_fetch_array($result);
			if (crypt($_POST["pass"], $row["pass"]) == $row["pass"]){
				$user = true;
				$username = $row["usuario"];
				$userid = $row["id"];
				$sgm = $row["sgm"];
				setcookie("musername", $_POST["user"], time()+60*$cookiestime, $url_raiz);
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, $url_raiz);
				header("Location: ".$urlmgestion."/index.php?op=200");
			}
		}
	}
	if ($_GET["idp"] != "") {
		$sql = "select * from sgm_users WHERE validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		while ($row = mysqli_fetch_array($result)){
			if ($_GET["idp"] == $row["pass"]){
				$user = true;
				$username = $row["usuario"];
				$userid = $row["id"];
				$sgm = $row["sgm"];
				setcookie("musername", $row["usuario"], time()+60*$cookiestime, $url_raiz);
				setcookie("mpassword", $row["pass"], time()+60*$cookiestime, $url_raiz);
				header("Location: ".$urlmgestion."/index.php?op=200&sop=70");
			}
		}
	}
} else { 
	$sql = "select Count(*) AS total from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
	$result = mysqli_query($dbhandle,convertSQL($sql));
	$row = mysqli_fetch_array($result);
	if ( $row["total"] == 1 ) {
		$sql = "select * from sgm_users WHERE usuario='".$_COOKIE["musername"]."' AND validado=1 AND activo=1";
		$result = mysqli_query($dbhandle,convertSQL($sql));
		$row = mysqli_fetch_array($result);
		if ($row["pass"] == $_COOKIE["mpassword"] ) {
			$user = true;
			$username = $row["usuario"];
			$userid = $row["id"];
			$sgm = $row["sgm"];
			setcookie("musername", $row["usuario"], time()+60*$cookiestime, $url_raiz);
			setcookie("mpassword", $row["pass"], time()+60*$cookiestime, $url_raiz);
		}
	}
}

lopd($userid,$username,$option,$soption);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>SIMGESTION 3.0</title>

		<?php include ("functions-js.php"); ?>
		<script>
		function desplegableCombinado(){
			if (document.getElementById('id_servicio2').value!=0){document.getElementById('id_cliente').value=0;}
			if (document.getElementById('id_cliente').value!=0){document.getElementById('id_cliente').value=0;}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado2(){
			if (document.getElementById('id_cliente').value!=0){
				document.getElementById('id_servicio').value=0;
			}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado3($service2){
			if ($service2!=0){document.getElementById('id_servicio').value=0;}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado4($id_usuario_origen){
			if ($id_usuario_origen!=0){document.getElementById('id_servicio').value=0;}
			document.forms.form1.action='';
			document.forms.form1.method='POST';
			document.forms.form1.submit();
		}

		function desplegableCombinado5(){
			document.forms.form2.action='';
			document.forms.form2.target='';
			document.forms.form2.method='POST';
			document.forms.form2.submit();
		}
		</script>
		<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
		<script type="text/javascript">
			tinymce.init({
			  selector: '#mytextarea',
			  height: 500,
			  plugins: [
				"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
			  ],

			  toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
			  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
			  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

			  menubar: false,
			  toolbar_items_size: 'small',

			  style_formats: [{
				title: 'Bold text',
				inline: 'b'
			  }, {
				title: 'Red text',
				inline: 'span',
				styles: {
				  color: '#ff0000'
				}
			  }, {
				title: 'Red header',
				block: 'h1',
				styles: {
				  color: '#ff0000'
				}
			  }, {
				title: 'Example 1',
				inline: 'span',
				classes: 'example1'
			  }, {
				title: 'Example 2',
				inline: 'span',
				classes: 'example2'
			  }, {
				title: 'Table styles'
			  }, {
				title: 'Table row 1',
				selector: 'tr',
				classes: 'tablerow1'
			  }],

			  templates: [{
				title: 'Test template 1',
				content: 'Test 1'
			  }, {
				title: 'Test template 2',
				content: 'Test 2'
			  }],
			  content_css: [
				'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
				'//www.tinymce.com/css/codepen.min.css'
			  ]
			});
		</script>
  </head>
<body>
<center>
<?php 
if (($option == 900) or ($option == 600)) {
	include ("mgestion/help/mail.php");
	include ("mgestion/gestion-articulos-etiqueta-print.php");
} else {
	echo "<table class=\"maestra\">";
		echo "<tr>";
			echo "<td class=\"maestra\">";
				echo "<table style=\"width:100%;\"><tr>";
					echo "<td style=\"color:white;width:17%;\">";
						if ($user == true) {
							echo "<strong>".$Bienvenido." <strong>".$username."</strong>&nbsp;&nbsp; (id.<strong>".$userid.")</strong>";
						} else {
							echo "<a href=\"index.php?op=100\" style=\"color : white;\"><strong>[ ".$Identificarse." ]</strong></a>";
						}
						echo "&nbsp;&nbsp;&nbsp;&nbsp; <strong>".date("d/m/Y")."&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i")."</strong>";
				echo "</td>";
				echo "<td style=\"color:white;width:70%;\">";
					if ($sgm == 1) {
						echo "<ul class=\"menu1\">";
							echo "<li><a href=\"index.php?op=200\">".$Panel_usuario."</a>";
							$sqlu = "select * from sgm_users where id=".$userid;
							$resultu = mysqli_query($dbhandle,convertSQL($sqlu));
							$rowu = mysqli_fetch_array($resultu);
								if ($rowu["sgm"] == 1) {
									$sqlmg = "select * from sgm_users_permisos_modulos_grupos where visible=1 order by nombre";
									$resultmg = mysqli_query($dbhandle,convertSQL($sqlmg));
									while ($rowmg = mysqli_fetch_array($resultmg)) {

										echo "<li><a href=\"#\">".$rowmg["nombre"]."</a>";
											echo "<ul>";
												$sqlm = "select * from sgm_users_permisos_modulos where visible=1 and id_grupo=".$rowmg["id"]." order by nombre";
												$resultm = mysqli_query($dbhandle,convertSQL($sqlm));
												while ($rowm = mysqli_fetch_array($resultm)) {
													echo "<li><a href=\"index.php?op=".$rowm["id_modulo"]."\">".$rowm["nombre"]."</a></li>";
												}
											echo "</ul>";
										echo "</li>";
									}
								}
						echo "</ul>";
					}
				echo "</td>";
				echo "<td style=\"color:white;width:3%;\">";
					echo "<a href=\"index.php?op=1008&sop=100\"><img src=\"mgestion/pics/icons-mini/group_add.png\" alt=\"Cliente\" title=\"".$Anadir." ".$Cliente."\" border=\"0\"></a>";
				echo "</td>";
				echo "<td style=\"color:white;width:3%;\">";
					echo "<a href=\"index.php?op=1018&sop=100&id_entrada=1\"><img src=\"mgestion/pics/icons-mini/telephone.png\" alt=\"Telefono\" title=\"".$Incidencia." ".$Telefono."\" border=\"0\"></a>";
				echo "</td>";
				echo "<td style=\"color:white;width:4%;\">";
					if ($idioma == "cat") {	echo "<a href=\"index.php?i=cat\" style=\"color : white;\"><strong>Cat</strong></a> | <a href=\"index.php?i=es\" style=\"color : white;\">Es</a>"; }
					if ($idioma == "es") {	echo "<a href=\"index.php?i=cat\" style=\"color : white;\">Cat</a> | <a href=\"index.php?i=es\" style=\"color : white;\"><strong>Es</strong></a>"; }
				echo "</td>";
				echo "<td style=\"color:white;width:3%;\">";
					echo "<a href=\"index.php?sop=666\"><img src=\"mgestion/pics/icons-mini/door_out.png\" alt=\"Logout\" title=\"".$Salir."\" border=\"0\"></a>";
				echo "</td>";
				echo "</tr></table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td  class=\"maestra2\">";
				$veure_peu = 1;
				include ("mgestion/indice.php");
#				if ($option == 0) { }
			echo "</td>";
		echo "</tr>";
#		if ($veure_peu != 0){
		echo "<tr>";
			echo "<td class=\"maestra\" style=\"color:white;\">&copy;".date('Y')." Solucions-im.com</td>";
		echo "</tr>";
#		}
	echo "</table>";

	$errors= error_get_last();
	echo "COPY ERROR: ".$errors['type'];
	echo "<br />\n".$errors['message'];
#	var_dump($errors);

}
?>
</center>
</body>
</html>
<?php
	// Cerrar la conexión
	mysql_close($dbhandle);
?>