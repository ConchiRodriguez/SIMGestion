<?php
    $message = '';
    if (isset($_POST['send'])) {
        if (empty($_POST['msisdn']) || empty($_POST['message'])) {
            $message = 'All fields need to be filled in';
        } else {
            $url = 'http://www.solucions-im.net/api/';
            $username = 'conchi.rodriguez';
            $password = '95019501';
            $sms = '<sms>
						<recipient>
							<msisdn>:MSISDN</msisdn>
						</recipient>
						<message>:MESSAGE</message>
						<tpoa>Nagios</tpoa>
						<crt>conchi.rodriguez@solucions-im.com</crt>
						<test>1</test>
					</sms>';
			$sms = utf8_encode(str_replace(array(':MSISDN', ':MESSAGE'), array($_POST['msisdn'], $_POST['message']), $sms));

            $ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'XmlData='.$sms);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $result = curl_exec($ch);
			curl_close($ch);
            $message = htmlentities('Message has been sent.<br />Details:' . "<br />" . $result);
        }
    }
?>
<html>
    <head>
        <title>SMS Example</title>
    </head>
    <body>
        <p><?php echo $message ?></p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <p>MSISDN: <input type="text" value="" name="msisdn" /></p>
            <p>Message: <input type="text" value="" maxlength="160" name="message" /></p>
            <p><input type="submit" value="Send SMS" name="send" /></p>
        </form>
    </body>
</html>