<?php
error_reporting(~E_ALL);

#inclusió dades de connexió a la BBDD
include ("config.php");

#connexió a la BBDD
$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on ".$dbhost."");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database");

#discriminació del missatges no enviat que hi ha a la taula 'z_sim_sms'
$sqlt = "select * from z_sim_sms where enviat=0";
$result = mysql_query($sqlt);
while ($row = mysql_fetch_array($result)) {
	#comprovació de que el missatge no s'hagi enviat recentment
	if ($row["data_enviament"] <= date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y")))){
		$salida = '';
		$sms = '';
		#comprovació de que el missatge o el remitent no existeixin
		if (empty($row["missatge"]) || empty($row["destinataris"])) {
			$salida .= $salida."KO\n";
		} else {
			#crida funció d'enviament
			echo enviarSMS($row);
		}
		#marcar missatge com llegit i guardar la data i hora de l'enviament
		$sqlz = "update z_sim_sms set enviat=1, data_enviament='".date("Y-m-d H:i:s")."' where id=".$row["id"];
		echo $sqlz;
		mysql_query($sqlz);
	} else {
		echo "mensaje duplicado<br>";
	}
}

function enviarSMS ($row){
	global $db;
	$url = 'http://api.labsmobile.com/clients/acct01client/';
	$user = 'conchi.rodriguez@solucions-im.com';
	$pass = '95019501';
	$sms = '<sms>
				<recipient>';
					$destinataris = explode(",", $row["destinataris"]);
					for ($i=0;$i<count($destinataris);$i++){
						#una etiqueta por detinatario
						$sms .='<msisdn>'.$destinataris[$i].'</msisdn>';
					}
		$sms .=	'</recipient>
				<message>'.utf8_encode($row["missatge"]).'</message>
				<tpoa>Proves</tpoa>
				<crt>conchi.rodriguez@solucions-im.com</crt>
				<test>1</test>
				<nofilter>1</nofilter>
			</sms>';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'XmlData='.$sms);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	$result = curl_exec($ch); curl_close($ch);
	$salida .= $salida.htmlentities('Message has been sent.<br />Details:' . "<br />" . $result);
}

?>