#!/usr/bin/php

<?php

$user = "";
$pass = "";
$message = "";
$recipient = "";
$help = false;
$version = false;


foreach ($argv as $arg) {
	if (strpos($arg, "u=") !== false) { $user = str_replace("u=","",$arg); }
	if (strpos($arg, "p=") !== false) { $pass = str_replace("p=","",$arg); }

	if (strpos($arg, "m=") !== false) { $message = str_replace("m=","",$arg); }
	if (strpos($arg, "r=") !== false) { $recipient = str_replace("r=","",$arg); }

	if (strpos($arg, "-h") !== false) { $help = true; }
	if (strpos($arg, "-v") !== false) { $version = true; }
}

if ($version == true) {
	echo "check_sms.php Version 0.1.0\n";
	echo "check_sms.php -h for help.\n";
}

if ($help == true) {
	echo "check_sms.php Version 0.1.0\n\n";
	echo "\t# check_sms.php u=user p=password m=message r=recipient\n";
	echo "List:\n";
	echo "m=message -> Message to send (UTF-8).\n";
	echo "r=recipient -> Cellphone numbre recipient of the message (contry pref.+num).\n";
}

if (($version == false) and ($help == false) and ($message != "")) {
	if (empty($message) || empty($recipient)) {
#		$salida = 'All fields need to be filled in';
		$salida = "KO\n";
	} else {
		$url = 'http://api.labsmobile.com/clients/acct01client/';
		$sms = '<sms>
					<recipient>
						<msisdn>:MSISDN</msisdn>
					</recipient>
					<message>:MESSAGE</message>
					<tpoa>Nagios</tpoa>
					<crt>conchi.rodriguez@solucions-im.com</crt>
					<test>1</test>
				</sms>';
		$sms = utf8_encode(str_replace(array(':MSISDN', ':MESSAGE'), array($recipient, $message), $sms));

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'XmlData='.$sms);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$result = curl_exec($ch); curl_close($ch);
#		$salida = htmlentities('Message has been sent.<br />Details:' . "<br />" . $result);
		$salida = "OK\n";
	}
}

exit($salida)
	
	
?>
