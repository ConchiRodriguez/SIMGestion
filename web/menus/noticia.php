<?php
if ($_GET["id"] != 0){
	echo "<table class=\"news\">";
		$dbhost = "qrg996.dbname.net";
		$dbuname = "qrg996";
		$dbpass = "Solucions69";
		$dbname = "qrg996";
		
		$dbhandle1 = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
		$db = mysql_select_db($dbname, $dbhandle1) or die("Couldn't open database $myDB");
		echo "<br>";
		$sql = "select * from wp_posts where id=".$_GET["id"];
		$result = mysql_query($sql, $dbhandle1);
		$row = mysql_fetch_array($result);
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
		echo "<tr><td>".$mess." ".$any."</td></tr>";
		echo "<tr><td><strong>".utf8_encode ($row["post_title"])."</strong></td></tr>";
		$texto_noticia = str_replace( "[embed]", "</td></tr><tr><td>&nbsp;</td></tr><tr><td style=\"text-align:center;\"><iframe src=\"",utf8_encode ($row["post_content"]));
		$texto_noticia = str_replace( "[/embed]", "\" width=\"600\" height=\"400\"></iframe></td></tr>",$texto_noticia);
		$texto_noticia = str_replace( "watch?v=", "embed/",$texto_noticia);
		echo "<tr><td>".$texto_noticia."</td></tr>";
	echo "</table>";
}
if ($_GET["tax"] != 0){
	echo "<table class=\"news\">";
		$dbhost = "qrg996.dbname.net";
		$dbuname = "qrg996";
		$dbpass = "Solucions69";
		$dbname = "qrg996";
		
		$dbhandle1 = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on $dbhost");
		$db = mysql_select_db($dbname, $dbhandle1) or die("Couldn't open database $myDB");
		echo "<br>";
		$sql = "select * from wp_posts where id in (select object_id from wp_term_relationships where term_taxonomy_id=".$tax.") and post_type='post' and post_status='publish' order by post_date desc";
		$result = mysql_query($sql, $dbhandle1);
		while ($row = mysql_fetch_array($result)){
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
			echo "<tr><td>".$mess." ".$any."</td></tr>";
			echo "<tr><td><strong>".utf8_encode ($row["post_title"])."</strong></td></tr>";
		$texto_noticia = str_replace( "[embed]", "</td></tr><tr><td>&nbsp;</td></tr><tr><td style=\"text-align:center;\"><iframe src=\"",utf8_encode ($row["post_content"]));
		$texto_noticia = str_replace( "[/embed]", "\" width=\"600\" height=\"400\"></iframe></td></tr>",$texto_noticia);
		$texto_noticia = str_replace( "watch?v=", "embed/",$texto_noticia);
		echo "<tr><td>".$texto_noticia."</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		}
	echo "</table>";
}
?>
