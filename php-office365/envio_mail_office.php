<?php
#require_once('/usr/share/php/Mail.php');


$from = "Conchi Rodríguez <conchi.rodriguez@solucions-im.com>";
$to = "Conchi Rodríguez <conchi.rodriguez@multivia.com>";
$bcc = '';
$subject = "Hi!";
$body = "Hi,\n\nLooks like it worked.";

$host = 'smtp.office365.com';
$port = '587';
$username = 'conchi.rodriguez@solucions-im.com';
$password = '9501Conchi';

$headers = array(
 'Port'          => $port,
 'From'          => $from,
 'To'            => $to,
 'Subject'       => $subject,
'Content-Type'  => 'text/html; charset=UTF-8'
);

echo $recipients = $to.", ".$bcc;

$smtp = Mail::factory('smtp',
 array ('host' => $host,
 'auth' => true,
 'username' => $username,
 'password' => $password));

$mail = $smtp->send($recipients, $headers, $body);

echo "test";

if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
} else {
   echo("<p>Message successfully sent!</p>");
}
?>