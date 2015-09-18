<?php
include ("twitter.php");

echo "<table class=\"news\">";
	echo "<tr><td></td><td>Twitter @Solucions-IM</td></tr>";
	echo tweetSim();
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td></td><td>".$NOTICIAS."</td></tr>";
		$dbhost = "qrg996.dbname.net";
		$dbuname = "qrg996";
		$dbpass = "Solucions69";
		$dbname = "qrg996";
		
		$dbhandle1 = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
		$db = mysql_select_db($dbname, $dbhandle1) or die("Couldn't open database $myDB");
		echo "<br>";
		$sql = "select * from wp_posts where id in (select object_id from wp_term_relationships where term_taxonomy_id=6) and post_type='post' and post_status='publish' order by post_date desc limit 0, 5";
		$result = mysql_query($sql, $dbhandle1);
		while ($row = mysql_fetch_array($result)) {
			list($fecha,$hora)=explode(" ",$row["post_date"]);
			List($any,$mes,$dia)=explode("-", $fecha);
			if ($mes == 1) {$mess = "Enero";}
			if ($mes == 2) {$mess = "Febrero";}
			if ($mes == 3) {$mess = "Marzo";}
			if ($mes == 4) {$mess = "Abril";}
			if ($mes == 5) {$mess = "Mayo";}
			if ($mes == 6) {$mess = "Junio";}
			if ($mes == 7) {$mess = "Julio";}
			if ($mes == 8) {$mess = "Agosto";}
			if ($mes == 9) {$mess = "Septiembre";}
			if ($mes == 10) {$mess = "Octubre";}
			if ($mes == 11) {$mess = "Noviembre";}
			if ($mes == 12) {$mess = "Diciembre";}
			echo "<tr>";
				echo "<td class=\"news\">".$mess." ".$any." -&nbsp; </td>";
				echo "<td class=\"news2\"><a href=\"index.php?mn=401&id=".$row["ID"]."\"><strong>".utf8_encode ($row["post_title"])."</strong></a></td>";
			echo "</tr>";
		}
	echo "<tr><td></td><td><a href=\"index.php?mn=401&tax=6\">".$Leer_todas."</a></td></tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td></td><td>".$BLOG." ".$TECNICO."</td></tr>";
	$dbhost = "qqj569.dbname.net";
	$dbuname = "qqj569";
	$dbpass = "Multi2013";
	$dbname = "qqj569";
	
	$dbhandle2 = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
	$db = mysql_select_db($dbname, $dbhandle2) or die("Couldn't open database $myDB");
	$sql = "select * from wp_posts where post_type='post' and post_status='publish' order by post_date desc limit 0, 5";
	$result = mysql_query($sql, $dbhandle2);
	while ($row = mysql_fetch_array($result)) {
		list($fecha,$hora)=explode(" ",$row["post_date"]);
		List($any,$mes,$dia)=explode("-", $fecha);
		if ($mes == 1) {$mess = "Enero";}
		if ($mes == 2) {$mess = "Febrero";}
		if ($mes == 3) {$mess = "Marzo";}
		if ($mes == 4) {$mess = "Abril";}
		if ($mes == 5) {$mess = "Mayo";}
		if ($mes == 6) {$mess = "Junio";}
		if ($mes == 7) {$mess = "Julio";}
		if ($mes == 8) {$mess = "Agosto";}
		if ($mes == 9) {$mess = "Septiembre";}
		if ($mes == 10) {$mess = "Octubre";}
		if ($mes == 11) {$mess = "Noviembre";}
		if ($mes == 12) {$mess = "Diciembre";}
		echo "<tr>";
			echo "<td class=\"news\">".$dia." ".$mess." ".$any." -&nbsp;</td>";
			echo "<td class=\"news2\"><a href=\"".$row["guid"]."\" target=\"_blank\"><strong>".utf8_encode ($row["post_title"])."</strong></a></td>";
		echo "</tr>";
	}
	echo "<tr><td></td><td><a href=\"http://www.solucions-im.com/blogs/tecnic/\" target=\"_blank\">".$Leer_todos."</a></td></tr>";
echo "</table>";
?>
