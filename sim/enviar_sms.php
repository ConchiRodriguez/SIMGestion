<?php
error_reporting(~E_ALL);

include ("config.php");

$dbhandle = mysql_connect($dbhost, $dbuname, $dbpass) or die("Couldn't connect to SQL Server on ".$dbhost."");
$db = mysql_select_db($dbname, $dbhandle) or die("Couldn't open database");

$sqlt = "select * from z_sim_sms where enviat=0";
$result = mysql_query($sqlt);
while ($row = mysql_fetch_array($result)) {
	if ($row["data_enviament"] <= date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y")))){
		echo enviarSMS($row);
		$sqlz = "update z_sim_sms set enviat=1, data_enviament='".date("Y-m-d H:i:s")."' where id=".$row["id"];
		echo $sqlz;
		mysql_query($sqlz);
	} else {
		echo "mensaje duplicado<br>";
	}
}

function enviarSMS ($row){
	global $db;
		$salida = '';
		$sms = '';
		if (empty($row["missatge"]) || empty($row["destinataris"])) {
	#		$salida = 'All fields need to be filled in';
			$salida .= $salida."KO\n";
		} else {
			$url = 'http://api.labsmobile.com/clients/acct01client/';
            $user = 'conchi.rodriguez@solucions-im.com';
            $pass = '95019501';
			$sms = '<sms>
						<recipient>';
							$destinataris = explode(",", $row["destinataris"]);
							for ($i=0;$i<count($destinataris);$i++){
								$sms .='<msisdn>'.$destinataris[$i].'</msisdn>';
							}
			$sms .=		'</recipient>
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
#			$salida = "OK\n".$sms;
		}
#	echo $salida;
}

?>